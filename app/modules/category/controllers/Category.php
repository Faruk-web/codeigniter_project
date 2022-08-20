<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MX_Controller {

    protected $table;
    protected $viewpath;
    public $path;
    function __construct()
    {
        parent::__construct();
        $this->load->module('templates');
        $this->templates->authCheck();

        $this->table = 'category';
        $this->viewpath = 'category/category_view';
        $this->path = 'category/category';

        $this->load->model('categoryModel');
    }

    public function index()
    {
        $this->lists();    //Call Lists function.
    }

    public function lists()
    {
        $count = $this->categoryModel->countResult($this->table);
        $pagination = $this->templates->pagination($count, $this->path.'/lists/');

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->categoryModel->selectResult($this->table, $pagination['limit']);

        $data['lists'] = 1;
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
        $data['dataview'] = $this->categoryModel->selectById($this->table, $id);

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

        $this->form_validation->set_rules('category_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('category_amount', 'Amount', 'trim|required');
        $this->form_validation->set_rules('serial', 'Display At', 'trim|numeric');

        if ($this->form_validation->run()==false) {
            $this->create();
        } else {
            $data = [
                'category_name' => $this->input->post('category_name'),
                'category_amount' => $this->input->post('category_amount'),
                'serial' => $this->input->post('serial'),
                'category_details' => $this->input->post('category_details'),
                'benevolent_status' => $this->input->post('benevolent_status'),
                'monthlyin_receipt' => $this->input->post('monthlyin_receipt'),
                'yearlyin_receipt' => $this->input->post('yearlyin_receipt'),
                'applied_lifemember' => $this->input->post('applied_lifemember'),
            ];

            $data = $this->security->xss_clean($data);
            $insId = $this->categoryModel->insert($this->table, $data);

            if (is_numeric($insId)) {
                $this->session->set_flashdata('flash_msg', $this->alert->success('Category Added Successfully.'));

                redirect($this->path.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('Category Adding Failed. '.$insId));

                $this->create();
            }
        }
    }

    public function update($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->alert->dmStart(),$this->alert->dmEnd());

        $this->form_validation->set_rules('category_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('category_amount', 'Amount', 'trim|required');
        $this->form_validation->set_rules('serial', 'Display At', 'trim|numeric');

        if ($this->form_validation->run()==false) {
            $this->edit($id);
        } else {
            $data = [
                'category_name' => $this->input->post('category_name'),
                'category_amount' => $this->input->post('category_amount'),
                'serial' => $this->input->post('serial'),
                'category_details' => $this->input->post('category_details'),
                'benevolent_status' => $this->input->post('benevolent_status'),
                'monthlyin_receipt' => $this->input->post('monthlyin_receipt'),
                'yearlyin_receipt' => $this->input->post('yearlyin_receipt'),
                'applied_lifemember' => $this->input->post('applied_lifemember'),
            ];
            
            $data = $this->security->xss_clean($data);
            $result = $this->categoryModel->update($this->table, $data, ['id'=>$id]);

            if (is_numeric($result)) {
                $this->session->set_flashdata('flash_msg', $this->alert->success('Category Update Successfully.'));

                redirect($this->path.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('Category Update Failed. '.$result));
                
                redirect($this->path.'/edit/'.$id.qString());
            }
        }
    }

    public function delete($id)
    {
        $result = $this->categoryModel->delete($this->table, ['id'=>$id]);

        if (is_numeric($result)) {
            $this->session->set_flashdata('flash_msg', $this->alert->success('Category Name Delete Successfully.'));
        } else {
            $this->session->set_flashdata('flash_msg', $this->alert->warning($result));
        }
        redirect($this->path.qString());
    }
}
?>