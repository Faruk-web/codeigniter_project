<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sale extends MX_Controller {
    
    protected $table;
    protected $viewpath;
    public $path;
    function __construct()
    {
        parent::__construct();
        $this->load->module('templates');
        $this->templates->authCheck();

        $this->table = 'vakalatnama_sale';
        $this->viewpath = 'vakalatnama/sale_view';
        $this->path = 'vakalatnama/sale';

        $this->load->model('saleModel');
    }

    public function index()
    {
        $this->lists();    //Call Lists function.
    }

    public function lists()
    {
        $count = $this->saleModel->countResult($this->table);
        $pagination = $this->templates->pagination($count, $this->path.'/lists/');

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->saleModel->selectResult($this->table, $pagination['limit']);

        $data['lists'] = 1;
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function show($id)
    {
        $data['dataview'] = $this->saleModel->selectById($this->table, $id);

        $data['show'] = $id;
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function prints($id)
    {
        $data['dataRow'] = $this->saleModel->selectById($this->table, $id);

        if (empty($data['dataRow'])) {
            $this->templates->blank();
        } else {
            $this->load->view('vakalatnama/sale_print', $data);
        }
    }

    public function receipt($id)
    {
        $data['dataRow'] = $this->saleModel->selectById($this->table, $id);

        if (empty($data['dataRow'])) {
            $this->templates->blank();
        } else {
            $this->load->view('vakalatnama/sale_receipt_print', $data);
        }
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
        $data['dataview'] = $this->saleModel->selectById($this->table, $id);

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

        $this->form_validation->set_rules('membership_number', 'Member ID', 'trim|required');
        $this->form_validation->set_rules('type', 'Type', 'trim|required');
        $this->form_validation->set_rules('serial_number', 'Serial', 'trim|required');
        $this->form_validation->set_rules('sale_date', 'Date', 'trim|required');
        $this->form_validation->set_rules('sale_quantity', 'Quantity', 'trim|required');
        
        if ($this->form_validation->run()==false) {
            $this->create();
        } else {
            $saleNo = $this->saleModel->saleNo();
            $data = [
                'sale_number' => $saleNo,
                'membership_number' => $this->input->post('membership_number'),
                'type' => $this->input->post('type'),
                'serial_number' => $this->input->post('serial_number'),
                'sale_date' => $this->input->post('sale_date'),
                'sale_quantity' => $this->input->post('sale_quantity'),
            ];

            $data = $this->security->xss_clean($data);
            $insId = $this->saleModel->insert($this->table, $data);

            if (is_numeric($insId)) {
                $this->session->set_flashdata('flash_msg', $this->alert->success('Sale Added Successfully.'));

                redirect($this->path.'/prints/'.$insId.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('Sale Adding Failed. '.$insId));

                $this->create();
            }
        }
    }

    public function update($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->alert->dmStart(),$this->alert->dmEnd());

        $this->form_validation->set_rules('membership_number', 'Member ID', 'trim|required');
        $this->form_validation->set_rules('type', 'Type', 'trim|required');
        $this->form_validation->set_rules('serial_number', 'Serial', 'trim|required');
        $this->form_validation->set_rules('sale_date', 'Date', 'trim|required');
        $this->form_validation->set_rules('sale_quantity', 'Quantity', 'trim|required');
       
        if ($this->form_validation->run()==false) {
            $this->edit($id);
        } else {
            $data = [
                'membership_number' => $this->input->post('membership_number'),
                'type' => $this->input->post('type'),
                'serial_number' => $this->input->post('serial_number'),
                'sale_date' => $this->input->post('sale_date'),
                'sale_quantity' => $this->input->post('sale_quantity'),
            ];
            
            $data = $this->security->xss_clean($data);
            $result = $this->saleModel->update($this->table, $data, ['id'=>$id]);

            if (is_numeric($result)) {
                $this->session->set_flashdata('flash_msg', $this->alert->success('Sale Update Successfully.'));

                redirect($this->path.'/prints/'.$id.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('Sale Update Failed. '.$result));
                
                redirect($this->path.'/edit/'.$id.qString());
            }
        }
    }

    public function delete($id)
    {
        $result = $this->saleModel->delete($this->table, ['id'=>$id]);

        if (is_numeric($result)) {
            $this->session->set_flashdata('flash_msg', $this->alert->success('Sale Delete Successfully.'));
        } else {
            $this->session->set_flashdata('flash_msg', $this->alert->warning($result));
        }
        redirect($this->path.qString());
    }
}
?>
