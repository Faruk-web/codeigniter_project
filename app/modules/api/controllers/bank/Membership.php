<?php


//namespace bank;

require APPPATH . '/third_party/RestController.php';
require APPPATH . '/third_party/Format.php';

use chriskacerguis\RestServer\RestController;

class Membership extends RestController
{

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
            ->get('members')
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

    public function list_get()
    {
        $order = $this->input->get_post('order') ? $this->input->get_post('order') : 'ASC';
        $column = $this->input->get_post('column') ? $this->input->get_post('column') : 'membership_number';
        $offset = $this->input->get_post('offset') ? $this->input->get_post('offset') : 1;
        $limit = $this->input->get_post('limit') ? $this->input->get_post('limit') : 10;
        $query = $this->input->get_post('q') ? $this->input->get_post('q') : null;

        // list all with limit and order

        $qStr = ($query != null ) ?  "membership_number like '%".$query
            ."%' OR member_name  like '%".$query
            ."%' OR residential_address like '%".$query
            ."%' OR mobile_number like '%".$query
            ."%' OR gender like '%".$query."%'" : " id > 0";

        $membership = $this->db
            ->select('membership_number, member_name, residential_address, mobile_number,gender')
            ->order_by($column, $order)
            ->limit($limit, $offset)
            ->where($qStr)
            ->get('members')
            ->result();

        if($membership){
            $this->response([
                'status' => TRUE,
                'membership' => $membership
            ], RestController::HTTP_OK);         // FOUND (200) being the HTTP response code
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Could not find any membership'
            ], RestController::HTTP_NOT_FOUND);   // INTERNAL_SERVER_ERROR (500) being the HTTP response code
        }

    }

}