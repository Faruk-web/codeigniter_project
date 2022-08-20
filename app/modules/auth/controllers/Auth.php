<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MX_Controller {
    
    function __construct()
    {
        parent:: __construct();
        $this->load->module('templates');
    }

	public function index()
    {
        $data['content_view'] = 'auth/auth_view';
        $this->templates->auth($data);
	}

	public function login()
    {
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="help-block"><strong>','</strong></span>');

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        // print_r($this->session->userdata);
        // [logged_in] => stdClass Object ( [user_id] => 3 [user_name] => Kazi Rashed Hasan
        // [user_email] => dhakataxesbar@gmail.com [username] => Rashed
        // [password] => $2y$10$Yl8LXoRAG5qxBLQ21zYDP.TWW/LAypmwwmZXUkp8o9r4Vh6lV8wOG
        // [account_role] => 4 ) )

        // TODO the whole user data including the password is put inside session :D
        // TODO make it to safety


        if ($this->form_validation->run()==false) {
            $this->index();
        } else {
            $this->load->model('authmodel');
            $result = $this->authmodel->doLogin();
            if ( $result==true ) {
                $this->load->helper('password');
                if ( passVerify($this->input->post('password'), $result->password) ) {
                    $this->session->set_userdata('logged_in', $result);
                    redirect('dashboard');
                } else {
                    $data = ['error_message' => $this->alert->warning('Invalid Password.')];
                    $data['content_view'] = 'auth/auth_view';
                    $this->templates->auth($data);
                }
                
            } else{
                $data = ['error_message' => $this->alert->warning('Invalid Username.')];
                $data['content_view'] = 'auth/auth_view';
                $this->templates->auth($data);
            }
        }

        // $this->session->session_id : jf9m6lmek08hggd29b66t63892u7p8p1
        // TODO insert session id in session management table

	}

    public function logout()
    {
        if ( isset($this->session->userdata['logged_in']) ) {
            $this->session->unset_userdata('logged_in',$this->session->userdata['logged_in']);

            $this->session->set_flashdata('flash_msg',$this->alert->success('You Are Successfully Logout.'));
            redirect('auth');
        } else {
            $this->index();
        }
    }
}
