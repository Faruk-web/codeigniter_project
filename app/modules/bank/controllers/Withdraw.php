<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Withdraw extends MX_Controller {
    
    protected $table;
    protected $viewpath;
    public $path;
    function __construct()
    {
        parent::__construct();
        $this->load->module('templates');
        $this->templates->authCheck();

        $this->table = 'bank_withdraw';
        $this->viewpath = 'bank/withdraw_view';
        $this->path = 'bank/withdraw';

        $this->load->model('withdrawModel');
    }

    public function index()
    {
        $this->lists();    //Call Lists function.
    }

    public function lists()
    {
        $count = $this->withdrawModel->countResult($this->table);
        $pagination = $this->templates->pagination($count, $this->path.'/lists/');

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->withdrawModel->selectResult($this->table, $pagination['limit']);

        $data['lists'] = 1;
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function show($id)
    {
        $data['dataview'] = $this->withdrawModel->selectById($this->table, $id);

        $data['show'] = $id;
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function create()
    {
        $data['create'] = 1;
        $data['route'] = $this->path.'/store';
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function edit($id)
    {
        $data['dataview'] = $this->withdrawModel->selectById($this->table, $id);

        if (empty($data['dataview'])) {
            $this->templates->blank();
        } else {
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

        $this->form_validation->set_rules('withdraw_purpose', 'Purpose', 'trim|required');
        $this->form_validation->set_rules('cheque_number', 'Cheque', 'trim|required');
        $this->form_validation->set_rules('withdraw_date', 'Date', 'trim|required');
        $this->form_validation->set_rules('withdraw_amount', 'Amount', 'trim|required');
        
        if ($this->form_validation->run()==false) {
            $this->create();
        } else {
            $data = [
                'withdraw_purpose' => $this->input->post('withdraw_purpose'),
                'cheque_number' => $this->input->post('cheque_number'),
                'withdraw_date' => $this->input->post('withdraw_date'),
                'withdraw_amount' => $this->input->post('withdraw_amount'),
            ];

            $data = $this->security->xss_clean($data);
            $insId = $this->withdrawModel->insert($this->table, $data);

            if (is_numeric($insId)) {
                $this->session->set_flashdata('flash_msg', $this->alert->success('Withdraw Added Successfully.'));

                redirect($this->path.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('Withdraw Adding Failed. '.$insId));

                $this->create();
            }
        }
    }

    public function update($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->alert->dmStart(),$this->alert->dmEnd());

        $this->form_validation->set_rules('withdraw_purpose', 'Purpose', 'trim|required');
        $this->form_validation->set_rules('cheque_number', 'Cheque', 'trim|required');
        $this->form_validation->set_rules('withdraw_date', 'Date', 'trim|required');
        $this->form_validation->set_rules('withdraw_amount', 'Amount', 'trim|required');
       
        if ($this->form_validation->run()==false) {
            $this->edit($id);
        } else {
            $data = [
                'withdraw_purpose' => $this->input->post('withdraw_purpose'),
                'cheque_number' => $this->input->post('cheque_number'),
                'withdraw_date' => $this->input->post('withdraw_date'),
                'withdraw_amount' => $this->input->post('withdraw_amount'),
            ];
            
            $data = $this->security->xss_clean($data);
            $result = $this->withdrawModel->update($this->table, $data, ['id'=>$id]);

            if (is_numeric($result)) {
                $this->session->set_flashdata('flash_msg', $this->alert->success('Withdraw Update Successfully.'));

                redirect($this->path.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('Withdraw Update Failed. '.$result));
                
                redirect($this->path.'/edit/'.$id.qString());
            }
        }
    }

    public function delete($id)
    {
        $result = $this->withdrawModel->delete($this->table, ['id'=>$id]);

        if (is_numeric($result)) {
            $this->session->set_flashdata('flash_msg', $this->alert->success('Withdraw Delete Successfully.'));
        } else {
            $this->session->set_flashdata('flash_msg', $this->alert->warning($result));
        }
        redirect($this->path.qString());
    }
}
?>
