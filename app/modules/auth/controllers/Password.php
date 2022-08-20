<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Password extends MX_Controller {
    
    function __construct()
    {
        parent:: __construct();
        $this->load->module('templates');
        $this->load->model('passwordmodel');
    }

	public function index()
    {
        $data['content_view'] = 'auth/password_view';
        $this->templates->auth($data);
	}

	public function email()
    {
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="help-block"><strong>','</strong></span>');

        $this->form_validation->set_rules('email', 'E-Mail Address', 'trim|required|valid_email');
        if ($this->form_validation->run()==false) {
            $this->index();
        } else {
            $result = $this->passwordmodel->checkExists();
            if ($result>0) {                
                //Save token row.
                $token = md5(uniqid(rand(), true));
                $data = [
                    'email' => $this->input->post('email'),
                    'token' => $token
                ];            
                $data = $this->security->xss_clean($data);
                $this->passwordmodel->storeToken($data);
                
                //Send Mail.
                $message = '<p>You recently requested to reset your password for your '.SITENAME.' account. Click the button below to reset it.</p>';
                $message .= '<p><a href="'.base_url('password/resetform/'.$token).'">Reset your password</a></p>';
                $message .= '<p>If you did not request a password reset, ignore this mail. This password reset only valid for the next 30 minutes.</p>';
                $message .= "<p><hr> If you're having trouble the password reset button, copy and paste the URL below into your web browser.</p>";
                $message .= '<p>'.base_url('password/resetform/'.$token).'</p>';

                $this->load->library('email');
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $config['charset'] = 'iso-8859-1';
                $config['wordwrap'] = TRUE;
                $config['mailtype'] = 'html';
                $this->email->initialize($config);

                $this->email->from(EMAIL, EMAIL_NAME);
                $this->email->to($this->input->post('email'));
                $this->email->subject('Password Reset Link');
                $this->email->message(mailBody($message));
                if ( $this->email->send() ) {
                    $this->session->set_flashdata('flash_email',$this->input->post('email'));
                    redirect('password/sent');
                } else {
                    $this->session->set_flashdata('flash_msg',"<span class='help-block' style='color:#a94442;'><strong>Password reset email sending failed. Please try again after sometime.</strong></span>");

                    redirect('password/reset');
                }
            } else {
                $data = array('error_message' => "<span class='help-block' style='color:#a94442;'><strong>We can't find a user with that e-mail address.</strong></span>");

                $data['content_view'] = 'auth/password_view';
                $this->templates->auth($data);
            }
        }
	}

    public function sent()
    {
        $data['content_view'] = 'auth/password_sent';
        $this->templates->auth($data);
    }

    public function resetform($token)
    {
        $rowData = $this->passwordmodel->checkToken($token);
        if (!empty($rowData)) {
            $this->session->set_userdata('reset_data', $rowData);

            $data['form'] = 1;
            $data['content_view'] = 'auth/password_reset';
            $this->templates->auth($data);
        } else {
            $data['expire'] = 1;
            $data['content_view'] = 'auth/password_reset';
            $this->templates->auth($data);
        }
    }

    public function update()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="help-block"><strong>','</strong></span>');
        $this->form_validation->set_rules('email', 'E-Mail Address', 'trim|required|valid_email|callback_emailCheck');
        $this->form_validation->set_rules('password', 'New Password', 'trim|required|min_length[6]|max_length[12]');
        $this->form_validation->set_rules('password_confirmation', 'Confirm Password', 'trim|required|matches[password]');
        if ($this->form_validation->run($this)==false) {
            //$this use for callback_ function (HMVC req.)
            $this->resetform($this->session->userdata['reset_data']->token);
        } else {
            $this->load->helper('password');
            $data = [
                'password' => passHash($this->input->post('password'))
            ];
            
            $result = $this->passwordmodel->updatePassword($data, $this->session->userdata['reset_data']->email);
            if ($result) {
                $this->session->unset_userdata('reset_data', $this->session->userdata['reset_data']);

                
                $this->session->set_flashdata('flash_success', "success");
                redirect('password/success');

            } else {
                $this->session->set_flashdata('flash_msg', "<span class='help-block' style='color:#a94442;'><strong>Your password updating failed. Please try again.</strong></span>");
                
                $this->resetform($this->session->userdata['reset_data']->token);
            }
        }
    }

    public function emailCheck( $email )
    {
        if ($email != $this->session->userdata['reset_data']->email) {
            $this->form_validation->set_message('emailCheck', '{field} did\'nt match with reset email.');
            return false;
        } else {
            return true;
        }
    }

    public function success()
    {
        $data['content_view'] = 'auth/password_success';
        $this->templates->auth($data);
    }
}
