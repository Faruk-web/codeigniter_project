<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MX_Controller {
    
    function __construct()
    {
        parent:: __construct();
        $this->load->module('templates');
        $this->load->model('portal/security/authmodel');
    }

	public function index()
    {
        $data['content_view'] = 'portal/security/auth_view';
        $this->templates->auth($data);
	}

	public function login()
    {

		$this->load->library('form_validation');
		$this->load->model('portal/security/authmodel');
        $this->form_validation->set_error_delimiters('<span class="help-block"><strong>','</strong></span>');
        $this->form_validation->set_rules('membership_number', 'Membership Number', 'trim|required');
        $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');

        if ($this->form_validation->run()==false) {
            $this->index();
        } else {

            $result = $this->authmodel->doLogin();

            if ($result) {

                // send OTP functionality

                $this->authmodel->startSession($result);
                redirect('portal/dashboard');

            } else{
                $data = ['error_message' => $this->alert->warning('Invalid Membership Number OR Mobile Number.')];
                $data['content_view'] =  'portal/security/auth_view';
                $this->templates->auth($data);
            }
        }

        // $this->session->session_id : jf9m6lmek08hggd29b66t63892u7p8p1
        // TODO insert session id in session management table

	}

    public function logout()
    {
        $this->authmodel->destroySession();
        if ( $this->authmodel->isLoggedIn() ) {
            $this->authmodel->destroySession();
            $this->session->set_flashdata('flash_msg',$this->alert->success('You Are Successfully Logout.'));
            redirect('portal/dashboard');
        } else {
            $this->index();
        }
    }

}
