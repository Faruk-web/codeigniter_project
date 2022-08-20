<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MX_Controller {

    protected $table;
    protected $viewpath;
    public $path;
    function __construct()
    {
        parent::__construct();
        $this->load->module('templates');
        $this->templates->authCheck();

        $this->table = 'users';
        $this->viewpath = 'users/users_view';
        $this->path = 'users/users';

        $this->load->model('usersModel');
    }

    public function index()
    {
    	$this->lists();    //Call Lists function.
    }

    public function lists()
    {
        $count = $this->usersModel->countResult($this->table);
        $pagination = $this->templates->pagination($count, $this->path.'/lists/');
        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];

        $data['records'] = $this->usersModel->selectResult($this->table, $pagination['limit']);
        $data['accountRole'] = accountRole();

        $data['lists'] = 1;
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function show($id)
    {
        $data['dataView'] = $this->usersModel->selectById($this->table, $id);
        $data['accountRole'] = accountRole();
        
        $data['show'] = $id;
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function create()
    {
        $data['accountRole'] = accountRole();

        $data['create'] = 1;
        $data['route'] = $this->path.'/store';
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function edit($id)
    {
        $data['dataView'] = $this->usersModel->selectById($this->table, $id);
        if (empty($data['dataView'])) {
            $this->templates->blank();
        } else {
            $data['accountRole'] = accountRole();
            
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
        
        $this->form_validation->set_rules('user_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('account_role', 'Role', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[12]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
       

        if ($this->form_validation->run()==false) {
            $this->create();
        } else {
            $this->load->helper('password');
            $password = passHash($this->input->post('password'));
            $data = [
                'user_name' => $this->input->post('user_name'),
                'user_email' => $this->input->post('user_email'),
                'user_contact' => $this->input->post('user_contact'),
                'account_role' => $this->input->post('account_role'),
                'username' => $this->input->post('username'),
                'password' => $password
            ];

            $data = $this->security->xss_clean($data);
            $insId = $this->usersModel->insert($this->table, $data);

            if (is_numeric($insId)) {
                $this->session->set_flashdata('flash_msg', $this->alert->success('User Insert Successfully.'));

                redirect($this->path.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('User Insert Failed. '.$insId));

                $this->create();
            }
        }
    }

    public function update($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->alert->dmStart(), $this->alert->dmEnd());

        $this->form_validation->set_rules('user_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('account_role', 'Role', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        
        if($this->input->post('password')!=''){
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[12]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        }

        if ($this->form_validation->run()==false) {
            $this->edit($id);
        } else {
            $data = [
                'user_name' => $this->input->post('user_name'),
                'user_email' => $this->input->post('user_email'),
                'user_contact' => $this->input->post('user_contact'),
                'account_role' => $this->input->post('account_role'),
                'username' => $this->input->post('username')
            ];

            if ($this->input->post('password')!='') {
                $this->load->helper('password');
                $data['password'] = passHash($this->input->post('password'));
            }

            $data = $this->security->xss_clean($data);
            $result = $this->usersModel->update($this->table, $data, ['user_id'=>$id]);

            if (is_numeric($result)) {
                $this->session->set_flashdata('flash_msg', $this->alert->success('User Update Successfully.'));

                redirect($this->path.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('User Update Failed. '.$result));
                
                redirect($this->path.'/edit/'.$id.qString());
            }
        }
    }

    public function activity($id, $status)
    {
        $data['status'] = $status;
        $result = $this->usersModel->update($this->table, $data, ['user_id'=>$id]);

        if (is_numeric($result)) {
            $this->session->set_flashdata('flash_msg', $this->alert->success('User Status Change Successfully.'));
        } else {
            $this->session->set_flashdata('flash_msg', $this->alert->warning($result));
        }
        redirect($this->path.qString());
    }

    public function delete($id)
    {
        $result = $this->usersModel->delete($this->table, ['user_id'=>$id]);

        if (is_numeric($result)) {
            $this->session->set_flashdata('flash_msg', $this->alert->success('User Delete Successfully.'));
        } else {
            $this->session->set_flashdata('flash_msg', $this->alert->warning($result));
        }
        redirect($this->path.qString());
    }
}
?>
