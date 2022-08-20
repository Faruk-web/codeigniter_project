<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends MX_Controller {

    protected $table;
    protected $viewpath;
    public $path;
    function __construct()
    {
        parent::__construct();
        $this->load->module('templates');
        $this->templates->authCheck();

        $this->table = 'web_events';
        $this->viewpath = 'cms/events_view';
        $this->path = 'cms/events';

        $this->load->model('eventsModel');
    }

    public function index()
    {
        $this->lists();    //Call Lists function.
    }

    public function lists()
    {
        $count = $this->eventsModel->countResult($this->table);
        $pagination = $this->templates->pagination($count, $this->path.'/lists/');

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->eventsModel->selectResult($this->table, $pagination['limit']);

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
        $data['dataview'] = $this->eventsModel->selectById($this->table, $id);

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

        $this->form_validation->set_rules('event_head', 'Head', 'trim|required');
        $this->form_validation->set_rules('event_date', 'Date', 'trim|required');
        $this->form_validation->set_rules('event_details', 'Details', 'trim|required');
        
        if ($this->form_validation->run()==false) {
            $this->create();
        } else {
            $data = [
                'event_head' => $this->input->post('event_head'),
                'event_date' => $this->input->post('event_date'),
                'event_details' => $this->input->post('event_details'),
                'status' => $this->input->post('status'),
            ];

            if ($_FILES['event_image']['name']!='') {
                $uploadArray = [
                    'allowed_types' => 'gif|jpg|jpeg|png',
                    'thumb' => '1'
                ];
                $upload = $this->templates->upload('event_image', 'events', $uploadArray);
                $data['event_image'] = $upload['file_name'];
            }
            $data = $this->security->xss_clean($data);
            $insId = $this->eventsModel->insert($this->table, $data);

            if (is_numeric($insId)) {
                $this->session->set_flashdata('flash_msg', $this->alert->success('News & Event Added Successfully.'));

                redirect($this->path.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('News & Event Adding Failed. '.$insId));

                $this->create();
            }
        }
    }

    public function update($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->alert->dmStart(),$this->alert->dmEnd());

        $this->form_validation->set_rules('event_head', 'Head', 'trim|required');
        $this->form_validation->set_rules('event_date', 'Date', 'trim|required');
        $this->form_validation->set_rules('event_details', 'Details', 'trim|required');
       
        if ($this->form_validation->run()==false) {
            $this->edit($id);
        } else {
            $data = [
                'event_head' => $this->input->post('event_head'),
                'event_date' => $this->input->post('event_date'),
                'event_details' => $this->input->post('event_details'),
                'status' => $this->input->post('status'),
            ];

            if ($_FILES['event_image']['name']!='') {
                $uploadArray = [
                    'allowed_types' => 'gif|jpg|jpeg|png',
                    'thumb' => '1'
                ];
                $upload = $this->templates->upload('event_image', 'events', $uploadArray);
                $data['event_image'] = $upload['file_name'];
            }
            $data = $this->security->xss_clean($data);
            $result = $this->eventsModel->update($this->table, $data, ['id'=>$id]);

            if (is_numeric($result)) {
                $this->session->set_flashdata('flash_msg', $this->alert->success('News & Event Update Successfully.'));

                redirect($this->path.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('News & Event Update Failed. '.$result));
                
                redirect($this->path.'/edit/'.$id.qString());
            }
        }
    }

    public function delete($id)
    {
        $result = $this->eventsModel->delete($this->table, ['id'=>$id]);

        if (is_numeric($result)) {
            $this->session->set_flashdata('flash_msg', $this->alert->success('News & Event Delete Successfully.'));
        } else {
            $this->session->set_flashdata('flash_msg', $this->alert->warning($result));
        }
        redirect($this->path.qString());
    }
}
?>