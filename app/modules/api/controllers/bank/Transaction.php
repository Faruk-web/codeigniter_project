<?php


//namespace bank;

require APPPATH . '/third_party/RestController.php';
require APPPATH . '/third_party/Format.php';

use chriskacerguis\RestServer\RestController;

class Transaction extends RestController
{
    public function __construct($config = 'rest')
    {

        parent::__construct();
        $this->get_local_config($config);
        // TODO populate $associations
        // TODO populate $receipt_type

    }

    protected $receipt_type = ['BANK', 'OFFICE', 'ONLINE'];
    protected $associations = ['DTBA', 'BTLA'];

    protected $current_bank = 'SIBL';
    protected $table = 'bank_transaction';

    protected $methods = [
        'index_get' => ['level' => 1, 'limit' => 1000],
        'receipts_get' => ['level' => 1, 'limit' => 1000],
        'reconcile_put' => ['level' => 1, 'limit' => 1000],
        'revoke_put' => ['level' => 1, 'limit' => 1000],
        'summary_get' => ['level' => 1, 'limit' => 1000],
    ];

//    todo check bank code if match with instance-secrete-key SIBL
    public function index_get()
    {

        $transaction_id = $this->input->get_post('transaction_id') ? $this->input->get_post('transaction_id') : null;

        $trxn = $this->db
            ->where('transaction_id', $transaction_id)
            ->where('bank_code', $this->current_bank) // //    todo check bank code if match with instance-secrete-key SIBL
            ->get($this->table)
            ->row();
        // TODO send only relevant row data into response
        if ($trxn) {
            $this->response([
                'status' => TRUE,
                'data' => $trxn
            ], RestController::HTTP_OK);         // CREATED (200) being the HTTP response code
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Could not find any transaction with ' . $transaction_id
            ], RestController::HTTP_NOT_FOUND);         // INTERNAL_SERVER_ERROR (500) being the HTTP response code
        }
    }

    public function list_get()
    {
        $order = $this->input->get_post('order') ? $this->input->get_post('order') : 'DESC';
        $column = $this->input->get_post('column') ? $this->input->get_post('column') : 'id';
        $offset = $this->input->get_post('offset') ? $this->input->get_post('offset') : 0;
        $limit = $this->input->get_post('limit') ? $this->input->get_post('limit') : 100;
        $limit = ($limit > 20) ? 20 : $limit;

        $query = $this->input->get_post('q') ? $this->input->get_post('q') : null;
        $fromDate = $this->input->get_post('fromDate') ? $this->input->get_post('fromDate') : null;
        $toDate = $this->input->get_post('toDate') ? $this->input->get_post('toDate') : null;

        if ($fromDate) {
            $fromDate = date("Y-m-d 00:00:00", strtotime($fromDate));
        } else {
            $fromDate = date("Y-m-d 00:00:00");
        }

        if ($toDate) {
            // fix the date to 23:59:59 hour
            $toDate = date("Y-m-d 23:59:59", strtotime($toDate));
        } else {
            $toDate = date("Y-m-d 23:59:59");
        }

        // list all with limit and order

        $qStr = ($query != null) ? " membership_number like '%" . $query
            . "%' OR member_mobile_number  like '%" . $query
            . "%' OR receipt_number  like '%" . $query
            . "%' OR transaction_id like '%" . $query
            . "%' OR branch_code like '%" . $query . "%'" : " id > 0";

        $trxn = $this->db
            ->order_by($column, $order)
            ->limit($limit, $offset)
            ->where('bank_code', $this->current_bank)
            ->where('is_deleted', 0)
            ->where($qStr)
            ->where('transaction_date >=', $fromDate)
            ->where('transaction_date <=', $toDate)
            ->get($this->table)
            ->result();

        // TODO send only relevant row data into response
        if ($trxn) {
            $this->response([
                'status' => TRUE,
                'data' => $trxn,
                'params' => ['fromDate' => $fromDate, 'toDate' => $toDate, 'order' => $order, 'limit' => $limit, 'offset' => $offset, 'q' => $query],
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'No Data found',
                'data' => $trxn,
                'params' => ['fromDate' => $fromDate, 'toDate' => $toDate, 'order' => $order, 'limit' => $limit, 'offset' => $offset, 'q' => $query],
            ], RestController::HTTP_OK);
        }
    }

    public function index_delete()
    {
        $transaction_id = $this->input->get_post('transaction_id') ? $this->input->get_post('transaction_id') : null;

        if (!$transaction_id) {
            $this->response([
                'status' => FALSE,
                'message' => 'Parameter required : transaction_id'
            ], RestController::HTTP_BAD_REQUEST);
            exit;
        }

        $trxn = $this->db
            ->where('transaction_id', $transaction_id)
            ->where('bank_code', $this->current_bank) //todo check bank code if match with instance-secrete-key SIBL
            ->get($this->table)
            ->row();


        if ($trxn && ($trxn->status === 'APPROVED')) {
            $this->response([
                'status' => false,
                'transaction' => $trxn,
                'message' => "Transaction revoke not allowed after " . $trxn->status . " status."
            ], RestController::HTTP_BAD_REQUEST);
            exit;
        }

        // TODO send only relevant row data into response
        if ($trxn) {

            $this->db->set('is_deleted', 1);
            $this->db->set('status', 'REVOKED');
            $this->db->where('transaction_id', $trxn->transaction_id);
            $this->db->where('receipt_number', $trxn->receipt_number);
            $this->db->update($this->table);


            $trxn = $this->db
                ->where('transaction_id', $transaction_id)
                ->get($this->table)
                ->row();

            $this->response([
                'status' => TRUE,
                'transaction' => $trxn,
            ], RestController::HTTP_DELETED);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Could not find any transaction with ' . $transaction_id
            ], RestController::HTTP_NOT_FOUND);
        }
    }


    public function revoke_put()
    {
        $this->index_delete();

    }

    // TODO : Reformat the methods.
    public function reconcile_put()
    {
        $transaction_id = $this->input->get_post('transaction_id') ? $this->input->get_post('transaction_id') : null;

        if (!$transaction_id) {
            $this->response([
                'status' => FALSE,
                'message' => 'Parameter required : transaction_id'
            ], RestController::HTTP_BAD_REQUEST);
            exit;
        }

        $trxn = $this->db
            ->where('transaction_id', $transaction_id)
            ->where('bank_code', $this->current_bank) // //    todo check bank code if match with instance-secrete-key SIBL
            ->get($this->table)
            ->row();
        // TODO send only relevant row data into response

        if ($trxn && ($trxn->status === 'REVOKED' || $trxn->status === 'APPROVED')) {
            $this->response([
                'status' => false,
                'transaction' => $trxn,
                'message' => "Transaction reconciliation not allowed after " . $trxn->status . " status."
            ], RestController::HTTP_BAD_REQUEST);
            exit;
        } else if ($trxn && $trxn->status === 'DEPOSITED') {
            // so, avoid multiple times reconciliation
            $this->db->set('is_deleted', 0);
            $this->db->set('status', 'RECONCILED');
            $this->db->where('transaction_id', $trxn->transaction_id);
            $this->db->where('receipt_number', $trxn->receipt_number);
            $this->db->where('bank_code', $this->current_bank); // //    todo check bank code if match with instance-secrete-key SIBL
            $this->db->update($this->table);

            $trxn = $this->db
                ->where('transaction_id', $transaction_id)
                ->get($this->table)
                ->row();

            $this->response([
                'status' => TRUE,
//                'data' => ['status' => $trxn->status],
                'transaction' => $trxn,
            ], RestController::HTTP_DELETED);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Could not find any transaction with ' . $transaction_id
            ], RestController::HTTP_NOT_FOUND);
        }
    }


    public function summary_get()
    {


        $fromDate = $this->input->get_post('fromDate') ? $this->input->get_post('fromDate') : null;
        $toDate = $this->input->get_post('toDate') ? $this->input->get_post('toDate') : null;

        if ($fromDate) {
            $fromDate = date("Y-m-d 00:00:00", strtotime($fromDate));
        } else {
            $fromDate = date("Y-m-d 00:00:00");
        }

        if ($toDate) {
            $toDate = date("Y-m-d 23:59:59", strtotime($toDate));
        } else {
            $toDate = date("Y-m-d 23:59:59");
        }


        $trxn = $this->db
            ->select("COUNT(*) as 'total_count', SUM(`transaction_amount`) as 'total_amount', '".$fromDate."' AS 'from_date', '".$toDate."' AS 'to_date'")
            ->where('bank_code', $this->current_bank)
            ->where('is_deleted', 0)
            ->where('transaction_date >=', $fromDate)
            ->where('transaction_date <=', $toDate)
            ->get($this->table)
            ->row();

        // TODO send only relevant row data into response
        if ($trxn) {
            $this->response([
                'status' => TRUE,
                'data' => $trxn,
                'params' => ['fromDate' => $fromDate, 'toDate' => $toDate],
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'data' => $trxn,
                'params' => ['fromDate' => $fromDate, 'toDate' => $toDate],
                'message' => 'No Data found'
            ], RestController::HTTP_OK);
        }
    }

    public function index_put()
    {

        $data = $this->_bind_data();
        $errors = $this->_validate_data($data);

        if ($errors) {
            $this->response([
                'status' => FALSE,
                'message' => $errors,
                'data' => $data,
            ], RestController::HTTP_BAD_REQUEST);
            exit;
        }


        $receipt = $this->db
            ->where('receipt_number', $data['receipt_number'])
            ->where('is_deleted', 0)
            ->get($this->table)
            ->row();

        if ($receipt) {
            $this->response([
                'status' => FALSE,
                'data' => $data,
                'message' => 'Receipt already deposited. [receipt_number: ' . $data['receipt_number'] . ']'
            ], RestController::HTTP_BAD_REQUEST);
            exit;
        }

        // TODO : Receipt table -> change recepit_number to receipt_number
        $receipt = $this->db
            ->where('recepit_number', $data['receipt_number'])
            ->where('approved', 1)
            ->get('receipt')
            ->row();

        if ($receipt) {
            $this->response([
                'status' => FALSE,
                'data' => $data,
                'message' => 'Receipt already PAID. [receipt_number: ' . $data['receipt_number'] . ']'
            ], RestController::HTTP_BAD_REQUEST);
            exit;
        }

        $transaction = $this->db
            ->where('transaction_id', $data['transaction_id'])
            ->get('bank_transaction')
            ->row();

        if ($transaction) {
            $this->response([
                'status' => FALSE,
                'data' => $data,
                'message' => 'Transaction Id must be unique. [transaction_id: ' . $data['transaction_id'] . ' already exists.]'
            ], RestController::HTTP_BAD_REQUEST);
            exit;
        }

        $membership = $this->db
            ->where('membership_number', $data['membership_number'])
//            ->where('mobile_number', $data['member_mobile_number'])
            ->get('members')
            ->row();

        //TODO Emergency : phone match has bugs

        if ($membership) {

            $mobile = $this->_phone_repair($membership->mobile_number);

            if (strpos($mobile, $data['member_mobile_number']) === false) {
                $this->response([
                    'status' => FALSE,
                    'data' => $data,
                    'message' => 'Phone number ' . $data['member_mobile_number'] . ' mismatched with Membership No.' . $membership->membership_number
                ], RestController::HTTP_BAD_REQUEST);
                exit;
            }
        } else {
            $this->response([
                'status' => FALSE,
                'data' => $data,
                'message' => 'Could not find any membership ' . $data['membership_number']
            ], RestController::HTTP_NOT_FOUND);
            exit;
        }

        $data['member_name'] = $membership->member_name;
        $data['member_address'] = $membership->residential_address;

        $this->db->insert($this->table, $data);
        $inserted_id = $this->db->insert_id();
        $inserted = $this->db
            ->where('id', $inserted_id)
            ->get($this->table)
            ->row();

        if ($inserted) {
            $this->response([
                'status' => TRUE,
                'data' => $inserted
            ], RestController::HTTP_CREATED);
        } else {
            $this->response([
                'status' => FALSE,
                'data' => $data,
                'message' => 'Could not save the transaction'
            ], RestController::HTTP_INTERNAL_SERVER_ERROR);
            // TODO check and remove duplicate constant for 500 error
        }

//        if (!empty($db_error)) {
//            throw new Exception('Database error code [' . $db_error['code'] . '] msg: ' . $db_error['message']);
//        }
        // TODO Emergency ... try catch not working...!!!! check it
//            try {  }
//            catch (Exception $exception){
//            $this->response([
//                'status' => FALSE,
//                'error'=>$exception->getMessage(),
//                'message' => 'Could not save the transaction'
//            ], RestController::HTTP_INTERNAL_SERVER_ERROR);
//
//            exit;
//            }

    }


    /**
     * @param
     */
    private function _bind_data()
    {

        // TODO : Set from some settings table DB, retrieve from api_key using $instance_id
        $bank_id = $this->current_bank;

        // TODO check -> form validation trim not working!!!
        $data = [
            'instance_id' => $this->input->request_headers()[$this->config->item('rest_instance_name')],
            'association_code' => ($this->input->get('association_code') ? trim($this->input->get('association_code')) : null),
            'membership_number' => ($this->input->get('membership_number') ? trim($this->input->get('membership_number')) : null),
            'member_mobile_number' => ($this->input->get('member_mobile_number') ? trim($this->_phone_repair($this->input->get('member_mobile_number'))) : null),
            'depositor_name' => ($this->input->get('depositor_name') ? trim($this->input->get('depositor_name')) : null),
            'depositor_mobile_number' => ($this->input->get('depositor_mobile_number') ? trim($this->input->get('depositor_mobile_number')) : null),
            'depositor_details' => $this->input->get('depositor_details') ? trim($this->input->get('depositor_details')) : null,
            'receipt_number' => $this->input->get('receipt_number') ? trim($this->input->get('receipt_number')) : null,
            'receipt_type' => $this->input->get('receipt_type') ? trim($this->input->get('receipt_type')) : null,
            'bank_entry_number' => $this->input->get('bank_entry_number') ? trim($this->input->get('bank_entry_number')) : null,
            'bank_code' => trim($bank_id),
            'branch_code' => $this->input->get('branch_code') ? trim($this->input->get('branch_code')) : null,
            'branch_user' => $this->input->get('branch_user') ? trim($this->input->get('branch_user')) : null,
            'transaction_id' => $this->input->get('transaction_id') ? trim($this->input->get('transaction_id')) : null,
            'transaction_amount' => $this->input->get('transaction_amount') ? trim($this->input->get('transaction_amount')) : null,
        ];
        return $data;
    }

    public function receipt_type_check($value)
    {
        $this->form_validation->set_message('receipt_type_check', '{field} must be one of ' . implode(', ', $this->receipt_type));
        return (array_search($value, $this->receipt_type, false));
    }

    public function association_code_check($value)
    {
        $this->form_validation->set_message('association_code_check', '{field} must be one of ' . implode(', ', $this->associations));
        return (array_search($value, $this->association_code, false));
    }

    public function checkDateTime($dt)
    {
        $pattern = 'same regex pattern';
        if (preg_match($pattern, $this->input->post('fromdatetime'))) {
            return true;
        } else {
            $this->form_validation->set_message('checkDateTime', 'Invalid Date!');
            return false;
        }
    }

    private function _validate_data($data)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_data($data);

        $this->form_validation->set_rules('membership_number', 'Membership No.', 'trim|required|min_length[5]|max_length[10]');
        $this->form_validation->set_rules('member_mobile_number', 'Member Contact No.', 'trim|required|min_length[7]|max_length[20]');
        // TODO member phone validation required
        $this->form_validation->set_rules('association_code', 'Association', 'trim|required|min_length[4]|max_length[10]');
        $this->form_validation->set_rules('depositor_name', 'Depositor', 'trim|required|min_length[3]|max_length[40]');
        $this->form_validation->set_rules('depositor_mobile_number', 'Depositor Mobile', 'trim|required|min_length[11]|max_length[20]');
        $this->form_validation->set_rules('depositor_details', 'Depositor Details or NID', 'trim|required|min_length[11]|max_length[50]');
        $this->form_validation->set_rules('receipt_number', 'Receipt No.', 'trim|required|min_length[3]|max_length[10]');
        $this->form_validation->set_rules('receipt_type', 'Receipt Type', 'trim|callback_receipt_type_check');
        $this->form_validation->set_rules('bank_entry_number', 'Bank Entry No.', 'trim|required|min_length[3]|max_length[10]');
        $this->form_validation->set_rules('branch_code', 'Branch Code', 'trim|required|min_length[3]|max_length[10]');
        $this->form_validation->set_rules('branch_user', 'Bank User', 'trim|required|min_length[3]|max_length[10]');
        $this->form_validation->set_rules('transaction_id', 'Transaction ID', 'trim|required|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('transaction_amount', 'Transaction Amount', 'trim|required|numeric|min_length[4]|max_length[10]');


//        array(
//            'trim','required', 'numeric',
//            'min_length[3]',
//            'max_length[8]',
//            function($value)
//            {
//                return (preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $value));
//            }));

        //        $this->form_validation->set_rules('transaction_date', 'Transaction Date', 'callback_date_check');

        $this->form_validation->run();
        $errors = $this->form_validation->error_array();

        return (sizeof($errors) > 0 ? $errors : null);
    }

    public function date_check($date)
    {
        // Empty Transaction Date is acceptable cause db column is default to CURRENT_TIME
        if ($date == null || $date == '') {
            return TRUE;
        }
        // Transaction Date could be a different than CURRENT_TIME

        if ($date && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {
            $this->form_validation->set_message('transaction_date_check', 'The {field} must be formatted as YYYY-mm-dd H:i:s');
            return FALSE;
        }
        return TRUE;
    }

    /**
     * @param array $phone_number
     * @return string|string[]
     */
    protected function _phone_repair($phone_number)
    {
        return str_replace(['-', ' ', '+88'], "", $phone_number);
    }

}