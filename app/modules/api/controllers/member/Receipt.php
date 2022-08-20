<?php


require APPPATH . '/third_party/RestController.php';
require APPPATH . '/third_party/Format.php';

use chriskacerguis\RestServer\RestController;

class Receipt extends RestController
{
    // history
    // Create
    // list
    // cancel

    public function __construct($config = 'rest')
    {

        parent::__construct();
        $this->get_local_config($config);

    }

    // Member Info
    // Update Info
    //

    protected $table = 'receipt';

    protected $methods = [
        'list_get' => ['level' => 1, 'limit' => 1000],
        'index_get' => ['level' => 1, 'limit' => 1000],
        'select_post' => ['level' => 1, 'limit' => 1000],
    ];

    public function index_get(){

        $receipt_number = $this->input->get_post('receipt_number') ? $this->input->get_post('receipt_number') : null;
        $receipt_list = $this->db
            ->select('id, recepit_number as receipt_number, DATE_FORMAT(recepit_date,"%d-%m-%Y") as receipt_date, 
            start_date, finish_date, month_period, total_amount, IF(approved IS false, "UNPAID", "PAID") as status')
            // ->from("receipt AS A");
            ->where('recepit_number', $receipt_number)
            ->get($this->table)
            ->row();

        if($receipt_list ){
            $this->response([
                'status' => TRUE,
                'data' => $receipt_list 
            ], RestController::HTTP_OK);         // OK (200) being the HTTP response code
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Could not find any membership '.$receipt_list 
            ], RestController::HTTP_NOT_FOUND);         // INTERNAL_SERVER_ERROR (500) being the HTTP response code
        }

    }

    
    public function list_get(){

        $membership_number = $this->input->get_post('membership_number') ? $this->input->get_post('membership_number') : null;
        // $receipt_id = $this->input->get_post('receipt_number') ? $this->input->get_post('receipt_number') : null;

        $this->db->select("
        A.id, A.recepit_number as receipt_number, DATE_FORMAT(A.created_at,'%d-%m-%Y') as receipt_date, 
        A.start_date, A.finish_date, A.month_period, A.total_amount, IF(A.approved IS false, 'UNPAID', 'PAID') as status,
        B.id AS member_id, B.membership_number, B.member_name, B.mobile_number as member_mobile_number");
        $this->db->from("receipt AS A");
        $this->db->join('members AS B', 'A.member_id=B.id', 'left');
        $this->db->where(['B.membership_number'=>$membership_number]);
        $receipt_list = $this->db->get()->result();

        if($receipt_list ){
            $this->response([
                'status' => TRUE,
                'data' => $receipt_list 
            ], RestController::HTTP_OK);         // OK (200) being the HTTP response code
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Could not find any membership '.$receipt_list 
            ], RestController::HTTP_NOT_FOUND);         // INTERNAL_SERVER_ERROR (500) being the HTTP response code
        }

    }

}