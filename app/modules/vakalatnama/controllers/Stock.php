<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends MX_Controller {
    
    protected $table;
    protected $viewpath;
    public $path;
    function __construct()
    {
        parent::__construct();
        $this->load->module('templates');
        $this->templates->authCheck();

        $this->table = 'vakalatnama_stock';
        $this->viewpath = 'vakalatnama/stock_view';
        $this->path = 'vakalatnama/stock';

        $this->load->model('stockModel');
    }

    public function index()
    {
        $this->lists();    //Call Lists function.
    }

    public function lists()
    {
        $count = $this->stockModel->countResult($this->table);
        $pagination = $this->templates->pagination($count, $this->path.'/lists/');

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->stockModel->selectResult($this->table, $pagination['limit']);

        $data['lists'] = 1;
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function show($id)
    {
        $data['dataview'] = $this->stockModel->selectById($this->table, $id);

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
        $data['dataview'] = $this->stockModel->selectById($this->table, $id);

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

        $this->form_validation->set_rules('type', 'Type', 'trim|required');
        $this->form_validation->set_rules('stock_date', 'Date', 'trim|required');
        $this->form_validation->set_rules('stock_quantity', 'Quantity', 'trim|required');
        
        if ($this->form_validation->run()==false) {
            $this->create();
        } else {
            $data = [
                'type' => $this->input->post('type'),
                'stock_date' => $this->input->post('stock_date'),
                'stock_quantity' => $this->input->post('stock_quantity'),
            ];

            $data = $this->security->xss_clean($data);
            $insId = $this->stockModel->insert($this->table, $data);

            if (is_numeric($insId)) {
                $this->session->set_flashdata('flash_msg', $this->alert->success('Stock Added Successfully.'));

                redirect($this->path.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('Stock Adding Failed. '.$insId));

                $this->create();
            }
        }
    }

    public function update($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->alert->dmStart(),$this->alert->dmEnd());

        $this->form_validation->set_rules('type', 'Type', 'trim|required');
        $this->form_validation->set_rules('stock_date', 'Date', 'trim|required');
        $this->form_validation->set_rules('stock_quantity', 'Quantity', 'trim|required');
       
        if ($this->form_validation->run()==false) {
            $this->edit($id);
        } else {
            $data = [
                'type' => $this->input->post('type'),
                'stock_date' => $this->input->post('stock_date'),
                'stock_quantity' => $this->input->post('stock_quantity'),
            ];
            
            $data = $this->security->xss_clean($data);
            $result = $this->stockModel->update($this->table, $data, ['id'=>$id]);

            if (is_numeric($result)) {
                $this->session->set_flashdata('flash_msg', $this->alert->success('Stock Update Successfully.'));

                redirect($this->path.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('Stock Update Failed. '.$result));
                
                redirect($this->path.'/edit/'.$id.qString());
            }
        }
    }

    public function delete($id)
    {
        $result = $this->stockModel->delete($this->table, ['id'=>$id]);

        if (is_numeric($result)) {
            $this->session->set_flashdata('flash_msg', $this->alert->success('Stock Delete Successfully.'));
        } else {
            $this->session->set_flashdata('flash_msg', $this->alert->warning($result));
        }
        redirect($this->path.qString());
    }
}
?>
