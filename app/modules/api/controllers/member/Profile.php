<?php

require APPPATH . '/third_party/RestController.php';
require APPPATH . '/third_party/Format.php';

use chriskacerguis\RestServer\RestController;


class Profile extends RestController
{

    public function __construct($config = 'rest')
    {

        parent::__construct();
        $this->get_local_config($config);

    }

    // Member Info
    // Update Info
    //

    protected $table = 'members';

    protected $methods = [
        'list_get' => ['level' => 1, 'limit' => 1000],
        'index_get' => ['level' => 1, 'limit' => 1000],
        'select_post' => ['level' => 1, 'limit' => 1000],
    ];

    public function index_get(){

        $membership_id = $this->input->get_post('membership_number') ? $this->input->get_post('membership_number') : null;
        $membership = $this->db
            ->select('membership_number, member_name, residential_address, mobile_number, gender')
            ->where('membership_number', $membership_id)
            ->get($this->table)
            ->row();

        if($membership){
            $this->response([
                'status' => TRUE,
                'data' => $membership
            ], RestController::HTTP_OK);         // OK (200) being the HTTP response code
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Could not find any membership '.$membership_id
            ], RestController::HTTP_NOT_FOUND);         // INTERNAL_SERVER_ERROR (500) being the HTTP response code
        }

    }

    public function select_get(){

        $membership_id = $this->input->get_post('membership_number') ? $this->input->get_post('membership_number') : null;
        $mobile_phone = $this->input->get_post('mobile_phone') ? $this->input->get_post('mobile_phone') : null;

        $membership = $this->db
            ->select('membership_number, member_name, residential_address, mobile_number, gender')
            ->where('membership_number', $membership_id)
            ->where('mobile_number', " ilike '%".$mobile_phone."%' " )
            //->like('mobile_number', "'%".$mobile_phone."%'")
            ->get($this->table)
            ->row();

        if($membership){
            $this->response([
                'status' => TRUE,
                'data' => $membership
            ], RestController::HTTP_OK);         // OK (200) being the HTTP response code
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Could not find any membership '.$membership_id
            ], RestController::HTTP_NOT_FOUND);         // INTERNAL_SERVER_ERROR (500) being the HTTP response code
        }

    }

}