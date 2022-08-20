<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MX_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->module('templates');
        $this->templates->authCheck();

        $this->load->model('profilemodel');
    }

    function index()
    {
        $data['show'] = 1;
    	$data['dataview'] = $this->profilemodel->findProfile();
        $data['accountRole'] = accountRole();
        $data['content_view'] = 'auth/profile_view';
        $this->templates->body($data);
    }

    public function edit()
    {
        $data['edit'] = 1;
        $data['dataview'] = $this->profilemodel->findProfile();
        $data['content_view'] = 'auth/profile_view';
        $this->templates->body($data);
    }

    public function update()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->alert->dmStart(),$this->alert->dmEnd());

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('user_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run()==false) {
            $this->edit();
        } else {
            $data = [
                'username' => $this->input->post('username'),
                'user_name' => $this->input->post('user_name'),
                'user_email' => $this->input->post('user_email'),
                'user_contact' => $this->input->post('user_contact'),
            ];
            $data = $this->security->xss_clean($data);
            $result = $this->profilemodel->updateProfile("users", $data);

            if (is_numeric($result)) {
                $this->session->set_flashdata('flash_msg',$this->alert->success('User Profile Details Update Successfully.'));

                redirect('profile/edit');
            } else {
                $this->session->set_flashdata('flash_msg',$this->alert->warning('User Profile Details Update Failed. '.$result));

                redirect('profile/edit');
            }
        }
    }

    public function password()
    {
        $data['password'] = 1;
        $data['dataview'] = $this->profilemodel->findProfile();
        $data['content_view'] = 'auth/profile_view';
        $this->templates->body($data);
    }

    public function change()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->alert->dmStart(),$this->alert->dmEnd());

        $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|callback_passCheck');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');

        if ($this->form_validation->run($this)==false) {
            //$this use for callback_ function (HMVC req.)
            $this->password();
        } else {
            $this->load->helper('password');
            $data = array(
                'password' => passHash($this->input->post('password'))
            );
            $data = $this->security->xss_clean($data);

            $result = $this->profilemodel->updateProfile("users", $data);

            if (is_numeric($result)) {
                $this->session->set_flashdata('flash_msg',$this->alert->success('User Password Update Successfully.'));

                redirect('profile/password');
            } else {
                $this->session->set_flashdata('flash_msg',$this->alert->warning('User Password Update Failed. '.$result));

                redirect('profile/password');
            }
        }
    }

    public function passCheck($old_password)
    {
        $this->load->helper('password');
        $current_password = $this->session->userdata['logged_in']->password;
        if ( !passVerify($old_password, $current_password) ) {
            $this->form_validation->set_message('passCheck', '{field} did\'nt match.');
            return false;
        } else {
            return true;
        }
    }
}
?>
