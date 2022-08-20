<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->module('templates');
        $this->templates->authCheck();

        $this->load->model('dashboardModel');
    }

    public function index()
    {
        $this->lists();    //Call Lists function.
    }

    public function lists()
    {
        $count = $this->dashboardModel->countResult();
        $pagination = $this->templates->pagination($count, 'dashboard/dashboard/lists/', 100);

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->dashboardModel->selectResult($pagination['limit']);

        $data['lists'] = 1;
        $data['path'] = 'dashboard';
        $data['content_view'] = 'dashboard/dashboard_view';
        $this->templates->body($data);
    }

    public function show($id)
    {
        $data['data'] = $this->dashboardModel->selectById($id);
        $data['nomineeData'] = $this->dashboardModel->selectNominee($id);

        $data['show'] = $id;
        $data['path'] = 'dashboard';
        $data['content_view'] = 'dashboard/dashboard_view';
        $this->templates->body($data);
    }

    public function approval($id)
    {
        $result = $this->dashboardModel->update('member_change_requests', ['status' => 1], ['id'=>$id]);

        if (is_numeric($result)) {
            $this->session->set_flashdata('flash_msg', $this->alert->success('Request Approved Successfully.'));
        } else {
            $this->session->set_flashdata('flash_msg', $this->alert->warning('Request Approving Failed. '.$result));
        }
        redirect('dashboard/show/'.$id.qString());
    }

    public function reject($id)
    {
        $result = $this->dashboardModel->update('member_change_requests', ['status' => 2], ['id'=>$id]);

        if (is_numeric($result)) {
            $this->session->set_flashdata('flash_msg', $this->alert->success('Request Rejected Successfully.'));
        } else {
            $this->session->set_flashdata('flash_msg', $this->alert->warning('Request Rejecting Failed. '.$result));
        }
        redirect('dashboard/show/'.$id.qString());
    }
}
