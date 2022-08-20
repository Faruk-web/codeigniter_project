<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Committees extends MX_Controller {

    protected $table;
    protected $viewpath;
    public $path;
    function __construct()
    {
        parent::__construct();
        $this->load->module('templates');
        $this->templates->authCheck();

        $this->table = 'web_committees';
        $this->viewpath = 'cms/committees_view';
        $this->path = 'cms/committees';

        $this->load->model('committeesModel');
    }

    public function index()
    {
        $this->lists();    //Call Lists function.
    }

    public function lists()
    {
        $count = $this->committeesModel->countResult($this->table);
        $pagination = $this->templates->pagination($count, $this->path.'/lists/');

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->committeesModel->selectResult($this->table, $pagination['limit']);

        $data['lists'] = 1;
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function create()
    {
        $committeeData = [
            [
                'id' => '',
                'designation' => 'President',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Vice-President',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Vice-President',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'General Secretary',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Treasurer',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Assistant General Secretary',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Library Secretary',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Sports & Cultural Secretary',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Welfare Secretary',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Executive Committee Member',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Executive Committee Member',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Executive Committee Member',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Executive Committee Member',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Executive Committee Member',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Executive Committee Member',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Executive Committee Member',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Executive Committee Member',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Executive Committee Member',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Executive Committee Member',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Executive Committee Member',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Executive Committee Member',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Executive Committee Member',
                'membership_number' => '',
            ],
            [
                'id' => '',
                'designation' => 'Ex-Officio',
                'membership_number' => '',
            ],
        ];
        $data['committeeData'] = json_decode(json_encode($committeeData));

        $data['create'] = 1;
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function edit($session)
    {
        $data['committeeData'] = $this->committeesModel->selectSession($this->table, $session);

        if (empty($data['committeeData'])) {
            $this->templates->blank();
        } else {
            $data['edit'] = $session;
            $data['path'] = $this->path;
            $data['content_view'] = $this->viewpath;
            $this->templates->body($data);
        }
    }

    public function store()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->alert->dmStart(), $this->alert->dmEnd());

        $this->form_validation->set_rules('session', 'Session', 'trim|required');
        
        if ($this->form_validation->run()==false) {
            $this->create();
        } else {
            $dataArr = [];
            $updateArr = [];
            $data['session'] = $this->input->post('session');
            foreach ($this->input->post('id') as $k => $ids) {
                $data['designation'] = $this->input->post('designation')[$k];
                $data['membership_number'] = $this->input->post('membership_number')[$k];

                if ($ids>0) {
                    $data['id'] = $ids;
                    $updateArr[] = $this->security->xss_clean($data);
                } else {
                    $dataArr[] = $this->security->xss_clean($data);
                }
            }

            if (!empty($dataArr)) {
                $this->committeesModel->insertBatch($this->table, $dataArr);
            }

            if (!empty($updateArr)) {
                $this->committeesModel->updateBatch($this->table, $updateArr, 'id');
            }

            $this->session->set_flashdata('flash_msg', $this->alert->success('Committee Added Successfully.'));
            redirect($this->path.qString());
        }
    }

    public function delete($session)
    {
        $result = $this->committeesModel->delete($this->table, ['session'=>$session]);

        if (is_numeric($result)) {
            $this->session->set_flashdata('flash_msg', $this->alert->success('Committee Delete Successfully.'));
        } else {
            $this->session->set_flashdata('flash_msg', $this->alert->warning($result));
        }
        redirect($this->path.qString());
    }
}
?>