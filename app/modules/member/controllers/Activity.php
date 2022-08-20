<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity extends MX_Controller {

    protected $table;
    protected $viewpath;
    public $path;
    function __construct()
    {
        parent::__construct();
        $this->load->module('templates');
        $this->templates->authCheck();

        $this->viewpath = 'member/activity_view';
        $this->path = 'member/activity';

        $this->load->model('activityModel');
    }

    public function index()
    {
        $this->voter();
    }

    public function voter()
    {
        if ($this->input->get('year')>0 && $this->input->get('month')>0) {
            $count = $this->activityModel->countVoter();
            $pagination = $this->templates->pagination($count, $this->path.'/voter/', 500);

            $data['paginationLinks'] = $pagination['links'];
            $data['paginationMsg'] = $pagination['msg'];
            $data['serial'] = $pagination['serial'];
            $data['records'] = $this->activityModel->selectVoter($pagination['limit']);
        } else {
            $data['records'] = [];
        }

        $data['pageName'] = 'voter';
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function defaulter()
    {
        if ($this->input->get('year')>0 && $this->input->get('month')>0) {
            $count = $this->activityModel->countDefaulter();
            $pagination = $this->templates->pagination($count, $this->path.'/defaulter/', 500);

            $data['paginationLinks'] = $pagination['links'];
            $data['paginationMsg'] = $pagination['msg'];
            $data['serial'] = $pagination['serial'];
            $data['records'] = $this->activityModel->selectDefaulter($pagination['limit']);
        } else {
            $data['records'] = [];
        }

        $data['pageName'] = 'defaulter';
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function stuckoff()
    {
        $count = $this->activityModel->countStuckOff();
        $pagination = $this->templates->pagination($count, $this->path.'/stuckoff/', 500);

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->activityModel->selectStuckOff($pagination['limit']);

        $data['pageName'] = 'stuckoff';
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function makeStuckoff()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->alert->dmStart(), $this->alert->dmEnd());

        $this->form_validation->set_rules('id[0]', 'Member ID', 'trim|required');

        if ($this->form_validation->run()==false) {
            $this->session->set_flashdata('flash_msg', $this->alert->warning("Member Not checked!"));
            redirect($this->path.'/defaulter/'.qString());
        } else {
            $allId = $this->input->post('id');
            $this->db->where_in('id', $allId);
            $this->db->update('members', ['status' => 3]);
            $affectedRow = $this->db->affected_rows();

            if (is_numeric($affectedRow)) {
                $this->session->set_flashdata('flash_msg', $this->alert->success("Successfully Made Stuck-off (".count($allId).") Member's."));

                redirect($this->path.'/stuckoff');
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning("Failed to Made Stuck-off (".count($allId).") Member's."));
                
                redirect($this->path.'/defaulter/'.qString());
            }
        }
    }
}