<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/third_party/RestController.php';
require APPPATH . '/third_party/Format.php';
use chriskacerguis\RestServer\RestController;

class Auth extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['login_get']['limit'] = 500;         // 500 requests per hour per user/key
        $this->methods['login_post']['limit'] = 100;         // 100 requests per hour per user/key
        $this->methods['logout_get']['limit'] = 50;         // 50 requests per hour per user/key
        $this->methods['logout_post']['limit'] = 50;         // 50 requests per hour per user/key
    }

//	public function index()
//    {
//
//	}

	public function login_get()
    {
        $username = $this->input->get('username');
        $password = $this->input->get('password');
        $rest_valid_logins = $this->config->item('rest_valid_logins');

        $rest_valid_logins[$username] = $password;

        $this->config->set_item('rest_valid_logins', $rest_valid_logins);

        echo $username;
//        echo $username;
        print_r($rest_valid_logins);
        $rest_valid_logins2 = $this->config->item('rest_valid_logins');
        print_r($rest_valid_logins2);


//        $this->response([
//            'status' => true,
//            'message' => 'Successfully Logged In'
//        ], RestController::HTTP_OK);

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
