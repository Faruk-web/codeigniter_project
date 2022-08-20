<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galleries extends MX_Controller {

    protected $table;
    protected $viewpath;
    public $path;
    function __construct()
    {
        parent::__construct();
        $this->load->module('templates');
        $this->templates->authCheck();

        $this->table = 'web_galleries';
        $this->viewpath = 'cms/galleries_view';
        $this->path = 'cms/galleries';

        $this->load->model('galleriesModel');
    }

    public function index()
    {
        $this->lists();    //Call Lists function.
    }

    public function lists()
    {
        $count = $this->galleriesModel->countResult($this->table);
        $pagination = $this->templates->pagination($count, $this->path.'/lists/');

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->galleriesModel->selectResult($this->table, $pagination['limit']);

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
        $data['dataview'] = $this->galleriesModel->selectById($this->table, $id);

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
        $insId = 'Image Not Found!';
        if ($_FILES['image']['name']!='') {
            $data['caption'] = $this->input->post('caption');
            $data['status'] = $this->input->post('status');

            $uploadArray = [
                'allowed_types' => 'gif|jpg|jpeg|png',
                'thumb' => '1'
            ];
            $upload = $this->templates->upload('image', 'galleries', $uploadArray);
            $data['image'] = $upload['file_name'];

            $data = $this->security->xss_clean($data);
            $insId = $this->galleriesModel->insert($this->table, $data);
        }

        if (is_numeric($insId)) {
            $this->session->set_flashdata('flash_msg', $this->alert->success('Image Added Successfully.'));

            redirect($this->path.qString());
        } else {
            $this->session->set_flashdata('flash_msg', $this->alert->warning('Image Adding Failed. '.$insId));

            $this->create();
        }
    }

    public function update($id)
    {
        $data = [
            'caption' => $this->input->post('caption'),
            'status' => $this->input->post('status'),
        ];
        $data = $this->security->xss_clean($data);

        if ($_FILES['image']['name']!='') {
            $uploadArray = [
                'allowed_types' => 'gif|jpg|jpeg|png',
                'thumb' => '1'
            ];
            $upload = $this->templates->upload('image', 'galleries', $uploadArray);
            $data['image'] = $upload['file_name'];
        }

        $result = $this->galleriesModel->update($this->table, $data, ['id'=>$id]);

        if (is_numeric($result)) {
            $this->session->set_flashdata('flash_msg', $this->alert->success('Image Update Successfully.'));

            redirect($this->path.qString());
        } else {
            $this->session->set_flashdata('flash_msg', $this->alert->warning('Image Update Failed. '.$result));
            
            redirect($this->path.'/edit/'.$id.qString());
        }
    }

    public function delete($id)
    {
        $result = $this->galleriesModel->delete($this->table, ['id'=>$id]);

        if (is_numeric($result)) {
            $this->session->set_flashdata('flash_msg', $this->alert->success('Image Delete Successfully.'));
        } else {
            $this->session->set_flashdata('flash_msg', $this->alert->warning($result));
        }
        redirect($this->path.qString());
    }
}
?>