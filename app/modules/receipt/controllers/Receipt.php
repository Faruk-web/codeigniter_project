<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Receipt extends MX_Controller {

    protected $table;
    protected $viewpath;
    public $path;
    function __construct()
    {
        parent::__construct();
        $this->load->module('templates');
        $this->templates->authCheck();

        $this->table = 'receipt';
        $this->viewpath = 'receipt/receipt_view';
        $this->path = 'receipt/receipt';

        $this->load->model('receiptModel');
    }

    public function index()
    {
        $this->lists();    //Call Lists function.
    }

    public function lists()
    {
        $count = $this->receiptModel->countResult($this->table);
        $pagination = $this->templates->pagination($count, $this->path.'/lists/');

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->receiptModel->selectResult($this->table, $pagination['limit']);

        $data['lists'] = 1;
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    //unapproved receipt list
    public function unapproved()
    {
        $count = $this->receiptModel->countResult($this->table, '0');
        $pagination = $this->templates->pagination($count, $this->path.'/unapproved/');

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->receiptModel->selectResult($this->table, $pagination['limit'], '0');

        $data['path'] = $this->path;
        $data['content_view'] = 'receipt/unapproved_view';
        $this->templates->body($data);
    }

    //approved receipt list
    public function approved()
    {
        $count = $this->receiptModel->countResult($this->table, 1);
        $pagination = $this->templates->pagination($count, $this->path.'/unapproved/');

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->receiptModel->selectResult($this->table, $pagination['limit'], 1);

        $data['path'] = $this->path;
        $data['content_view'] = 'receipt/approved_view';
        $this->templates->body($data);
    }

    public function create()
    {
        $data['catData'] = $this->receiptModel->categoryAll();

        $data['create'] = 1;
        $data['route'] = $this->path.'/store';
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function show($id)
    {
        $data['dataRow'] = $this->receiptModel->selectById($this->table, $id);

        if (empty($data['dataRow'])) {
            $this->templates->blank();
        } else {
            $data['catData'] = $this->receiptModel->categoryAll($id, 'inner');

            $data['show'] = $id;
            $data['path'] = $this->path;
            $data['content_view'] = $this->viewpath;
            $this->templates->body($data);
        }
    }

    public function prints($id)
    {
        $data['dataRow'] = $this->receiptModel->selectById($this->table, $id);

        if (empty($data['dataRow'])) {
            $this->templates->blank();
        } else {
            $data['catData'] = $this->receiptModel->categoryAll($id, 'inner');
            $this->load->view('receipt/receipt_print', $data);
        }
    }

    public function edit($id)
    {
        $data['dataRow'] = $this->receiptModel->selectById($this->table, $id);

        if (empty($data['dataRow'])) {
            $this->templates->blank();
        } else {
            $data['catData'] = $this->receiptModel->categoryAll($id);

            $data['edit'] = $id;
            $data['route'] = $this->path.'/update/'.$id;
            $data['path'] = $this->path;
            $data['content_view'] = $this->viewpath;
            $this->templates->body($data);
        }
    }

    public function store()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->alert->dmStart(), $this->alert->dmEnd());

        if ($this->input->post('new')!=1) {
            $this->form_validation->set_rules('membership_number', 'Member ID', 'trim|required');
            $this->form_validation->set_rules('member_id', 'Member ID', 'trim|required');
        }

        $this->form_validation->set_rules('month_period', 'Month', 'trim|required');
        $this->form_validation->set_rules('recepit_date', 'Date', 'trim|required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
        $this->form_validation->set_rules('finish_date', 'Finish Date', 'trim|required');
        $this->form_validation->set_rules('total_amount', 'Amount', 'trim|required');
        
        if ($this->form_validation->run()==false) {
            $this->create();
        } else {
            $recepitNo = $this->receiptModel->receiptNo();
            
            $rDate = str_replace('/', '-', $this->input->post('recepit_date'));
            $sDate = str_replace('/', '-', $this->input->post('start_date'));
            $fDate = str_replace('/', '-', $this->input->post('finish_date'));
            $data = [
                'member_id' => $this->input->post('member_id'),
                'receipt_member' => $this->input->post('receipt_member'),
                'recepit_number' => $recepitNo,
                'recepit_description' => $this->input->post('recepit_description'),
                'month_period' => $this->input->post('month_period'),
                'recepit_date' => date("Y-m-d", strtotime($rDate)),
                'start_date' => date("Y-m-d", strtotime($sDate)),
                'finish_date' => date("Y-m-d", strtotime($fDate)),
                'total_amount' => $this->input->post('total_amount'),
            ];

            $data = $this->security->xss_clean($data);
            $insId = $this->receiptModel->insert($this->table, $data);

            if (is_numeric($insId)) {
                $amountArr = array_filter($this->input->post('amount'));
                if (!empty($amountArr)) {
                    $insDataArr = [];
                    foreach ($amountArr as $key => $amount) {
                        $catData = [
                            'receipt_id' => $insId,
                            'amount' => $amount,
                            'category_id' => $this->input->post('category_id')[$key],
                        ];
                        $insDataArr[] = $this->security->xss_clean($catData);
                    }
                   $this->receiptModel->insertBatch('receipt_data', $insDataArr);

                   $this->session->set_flashdata('flash_msg', $this->alert->success('Receipt Added Successfully.'));
                } else {
                    $this->session->set_flashdata('flash_msg', $this->alert->warning('Receipt Category Not Found!'));
                }

                redirect($this->path.'/prints/'.$insId.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('Receipt Adding Failed. '.$insId));

                $this->create();
            }
        }
    }

    public function update($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->alert->dmStart(), $this->alert->dmEnd());

        if ($this->input->post('new')!=1) {
            $this->form_validation->set_rules('membership_number', 'Member ID', 'trim|required');
            $this->form_validation->set_rules('member_id', 'Member ID', 'trim|required');
        }
        
        $this->form_validation->set_rules('month_period', 'Month', 'trim|required');
        $this->form_validation->set_rules('recepit_date', 'Date', 'trim|required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
        $this->form_validation->set_rules('finish_date', 'Finish Date', 'trim|required');
        $this->form_validation->set_rules('total_amount', 'Amount', 'trim|required');
       
        if ($this->form_validation->run()==false) {
            $this->edit($id);
        } else {
            $data = [
                'member_id' => $this->input->post('member_id'),
                'receipt_member' => $this->input->post('receipt_member'),
                'recepit_description' => $this->input->post('recepit_description'),
                'month_period' => $this->input->post('month_period'),
                'recepit_date' => $this->input->post('recepit_date'),
                'start_date' => date("Y-m-d", strtotime($this->input->post('start_date'))),
                'finish_date' => date("Y-m-d", strtotime($this->input->post('finish_date'))),
                'total_amount' => $this->input->post('total_amount'),
            ];
            
            $data = $this->security->xss_clean($data);
            $result = $this->receiptModel->update($this->table, $data, ['id'=>$id]);

            /*For Update Data Table*/
            $insDataArr = [];
            $updDataArr = [];
            $dltDataArr = [];
            foreach ($this->input->post('data_id') as $key => $dId) {
                if ($this->input->post('amount')[$key]>0) {
                    $catData = [
                        'receipt_id' => $id,
                        'amount' => $this->input->post('amount')[$key],
                        'category_id' => $this->input->post('category_id')[$key],
                    ];
                    if ($dId>0) {
                        $catData['id'] = $dId;
                        $updDataArr[] = $this->security->xss_clean($catData);
                    } else {
                        $insDataArr[] = $this->security->xss_clean($catData);
                    }
                } else {
                    $dltDataArr[] = $dId;
                }
            }

            $rD = 0;
            if (!empty($insDataArr)) {
                $rD += $this->receiptModel->insertBatch('receipt_data', $insDataArr);
            }

            if (!empty($updDataArr)) {
                $rD += $this->receiptModel->updateBatch('receipt_data', $updDataArr, 'id');
            }

            if (!empty(array_filter($dltDataArr))) {
                $idImp = implode(',', $dltDataArr);
                $rD += $this->receiptModel->delete('receipt_data', ['receipt_id' => $id, 'id IN('=>$idImp.')'], 'null');
            }
            /*For Update Data Table::END*/

            if (is_numeric($result) || $rD>0) {
                $this->session->set_flashdata('flash_msg', $this->alert->success('Receipt Update Successfully.'));

                redirect($this->path.'/prints/'.$id.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('Receipt Update Failed. '.$result));
                
                redirect($this->path.'/edit/'.$id.qString());
            }
        }
    }

    public function delete($id)
    {
        $result = $this->receiptModel->delete($this->table, ['id'=>$id]);

        if (is_numeric($result)) {
            $this->receiptModel->delete('receipt_data', ['receipt_id'=>$id]);
            $this->session->set_flashdata('flash_msg', $this->alert->success('Receipt Delete Successfully.'));
        } else {
            $this->session->set_flashdata('flash_msg', $this->alert->warning($result));
        }
        redirect($this->path.qString());
    }

    public function memberCheck()
    {
        $memberNo = $this->input->get('membership_number');
        $monthPeriod = $this->input->get('month_period');
        
        $data = $this->receiptModel->memberCheck($memberNo);
        if (!empty($data)) {
        
            $memberReceipt = $this->receiptModel->memberLastPayment($memberNo);
            $lastRcptDate = (!empty($memberReceipt))?$memberReceipt->finish_date:'2018-12-31';
            $startDate = date("Y-m", strtotime("+1 month", strtotime($lastRcptDate)));
            $startDate = $startDate.'-01';
        
            $finishDate = date("Y-m-t", strtotime("+".($monthPeriod-1)." month", strtotime($startDate)));

            $yearlyin = 0;
            $monthArr = monthsBetweenDates($startDate, $finishDate);
            if (in_array(10, $monthArr) || 
                in_array(11, $monthArr) || 
                in_array(12, $monthArr)) {
                $yearlyin = 1;
            }

        
            $res = [
                'status' => 1,
                'id' => $data->id,
                'member_name' => $data->member_name,
                'lifemember' => $data->lifetime_member,
                'unapproved_count' => $data->unapprovedCount,
                'yearlyin' => $yearlyin,
                'start_date' => date("d/m/Y", strtotime($startDate)),
                'finish_date' => date("d/m/Y", strtotime($finishDate)),
                'benevolentFund' => benevolentFund($data->benevolent_fund, $data->benevolent_startdate),
            ];
        } else {
            $res = [
                'status' => 0
            ];
        }
        echo json_encode($res);
    }

    //Checked receipt Row approved
    public function approvedAll()
    {
        $dataArr = [];
        foreach ($this->input->post('id') as $k => $id) {
            $appDate = ($this->input->post('date')[$k]>0)?$this->input->post('date')[$k]:date('Y-m-d');
            $data = [
                'receipt_bank' => $this->input->post('bank')[$k],
                'approved_date' => $appDate,
                'approved' => 1,
                'id' => $id,
            ];
            $dataArr[] = $this->security->xss_clean($data);
        }

        if (!empty($dataArr)) {
            $upDt = $this->receiptModel->updateBatch($this->table, $dataArr, 'id');
            if ($upDt) {
                $this->session->set_flashdata('flash_msg', $this->alert->success('Receipt Approved Successfully.'));
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('Receipt Approving Failed. '.$upDt));
            }
        }
        redirect($this->path.'/unapproved/'.qString());
    }

    //Single Row approved receipt
    public function approvedSingle()
    {
        $response = [
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash()
        ];

        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'Receipt ID', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $response['error'] = validation_errors();
        } else {
            $response['error'] = '';
        }

        $id = $this->input->post('id');
        $appDate = ($this->input->post('date')>0)?$this->input->post('date'):date('Y-m-d');
        $data = [
            'receipt_bank' => $this->input->post('bank'),
            'approved_date' => $appDate,
            'approved' => 1,
        ];
        $data = $this->security->xss_clean($data);
        $result = $this->receiptModel->update($this->table, $data, ['id'=>$id]);
        $response['status'] = (is_numeric($result))?1:0;

        echo json_encode($response);
    }

    //Single Row unApproved receipt
    public function unApprovedSingle()
    {
        $response = [
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash()
        ];

        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'Receipt ID', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $response['error'] = validation_errors();
        } else {
            $response['error'] = '';
        }

        $id = $this->input->post('id');
        $data = [
            'receipt_bank' => 0,
            'approved_date' => 0,
            'approved' => 0,
        ];
        $data = $this->security->xss_clean($data);
        $result = $this->receiptModel->update($this->table, $data, ['id'=>$id]);
        $response['status'] = (is_numeric($result))?1:0;

        echo json_encode($response);
    }
}
?>