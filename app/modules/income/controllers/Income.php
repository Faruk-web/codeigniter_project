<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Income extends MX_Controller {
    
    protected $table;
    protected $dataTable;
    protected $viewpath;
    public $path;
    function __construct()
    {
        parent::__construct();
        $this->load->module('templates');
        $this->templates->authCheck();

        $this->table = 'income';
        $this->dataTable = 'income_data';
        $this->viewpath = 'income/income_view';
        $this->path = 'income/income';

        $this->load->model('incomeModel');
    }

    public function index()
    {
        $this->lists();    //Call Lists function.
    }

    public function lists()
    {
        /*Income Head Fetch For dropdown*/
        $this->load->model('headModel');
        $data['headData'] = $this->headModel->fetchHead();

        $count = $this->incomeModel->countResult($this->table);
        $pagination = $this->templates->pagination($count, $this->path.'/lists/');

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->incomeModel->selectResult($this->table, $pagination['limit']);

        $data['lists'] = 1;
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function show($id)
    {
        $data['dataview'] = $this->incomeModel->selectById($this->table, $id);
        $data['dataSub'] = $this->incomeModel->findData($id);

        $data['show'] = $id;
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function create()
    {
        /*Income Head Fetch For dropdown*/
        $this->load->model('headModel');
        $data['headData'] = $this->headModel->fetchHead();

        $data['dataSub'] = [(object)['id'=>'', 'head_id'=>'', 'amount'=>'']];

        $data['create'] = 1;
        $data['route'] = $this->path.'/store';
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function edit($id)
    {
        $data['dataview'] = $this->incomeModel->selectById($this->table, $id);

        if (empty($data['dataview'])) {
            $this->templates->blank();
        } else {
            /*Income Head Fetch For dropdown*/
            $this->load->model('headModel');
            $data['headData'] = $this->headModel->fetchHead();

            $dataSubEmpty = [(object) ['id'=>'', 'head_id'=>'', 'amount'=>'']];
            $dataSub = $this->incomeModel->findData($id);
            $data['dataSub'] = array_merge($dataSub, $dataSubEmpty);

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

        $this->form_validation->set_rules('income_date', 'Date', 'trim|required');
        
        if ($this->form_validation->run()==false) {
            $this->create();
        } else {
            $incomeNo = $this->incomeModel->incomeNo();
            $data = [
                'income_number' => $incomeNo,
                'income_date' => $this->input->post('income_date'),
                'income_note' => $this->input->post('income_note'),
                'income_amount' => $this->input->post('income_amount'),
            ];

            $data = $this->security->xss_clean($data);
            $insId = $this->incomeModel->insert($this->table, $data);

            if (is_numeric($insId)) {

                $subData = [];
                foreach ($this->input->post('row_id') as $key => $rowId) {
                    if ($this->input->post('head_id')[$key]>0) {
                        $subD = [
                            'income_id' => $insId,
                            'head_id' => $this->input->post('head_id')[$key],
                            'amount' => $this->input->post('amount')[$key]
                        ];
                        $subData[$key] = $this->security->xss_clean($subD);
                    }
                }
                $this->incomeModel->insertBatch($this->dataTable, $subData);


                $this->session->set_flashdata('flash_msg', $this->alert->success('Income Added Successfully.'));

                redirect($this->path.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('Income Adding Failed. '.$insId));

                $this->create();
            }
        }
    }

    public function update($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->alert->dmStart(),$this->alert->dmEnd());

        $this->form_validation->set_rules('income_date', 'Date', 'trim|required');
       
        if ($this->form_validation->run()==false) {
            $this->edit($id);
        } else {
            $data = [
                'income_date' => $this->input->post('income_date'),
                'income_note' => $this->input->post('income_note'),
                'income_amount' => $this->input->post('income_amount'),
            ];
            
            $data = $this->security->xss_clean($data);
            $result = $this->incomeModel->update($this->table, $data, ['id'=>$id]);

            /*Data Table Update*/
            $implodeId = implode(',', array_filter($this->input->post('row_id')));
            if ($implodeId!='') {
                $this->incomeModel->delete($this->dataTable, ['income_id'=>$id, 'id NOT IN('=>$implodeId.')'], 'null');
            }

            $updateSub = 0;
            foreach ($this->input->post('row_id') as $key => $rowId) {
                if ($this->input->post('head_id')[$key]>0) {
                    $subData = [
                        'income_id' => $id,
                        'head_id' => $this->input->post('head_id')[$key],
                        'amount' => $this->input->post('amount')[$key]
                    ];
                    $subData = $this->security->xss_clean($subData);

                    if ($rowId>0) {
                        $this->incomeModel->update($this->dataTable, $subData, ['id'=>$rowId]);
                    } else {
                        $this->incomeModel->insert($this->dataTable, $subData);
                    }
                    $updateSub++;
                }
            }
            /*Data Table Update:: End*/

            if (is_numeric($result) || $updateSub>0) {
                $this->session->set_flashdata('flash_msg', $this->alert->success('Income Update Successfully.'));

                redirect($this->path.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('Income Update Failed. '.$result));
                
                redirect($this->path.'/edit/'.$id.qString());
            }
        }
    }

    public function delete($id)
    {
        $result = $this->incomeModel->delete($this->table, ['id'=>$id]);

        if (is_numeric($result)) {
            $this->incomeModel->delete($this->dataTable, ['income_id'=>$id]);

            $this->session->set_flashdata('flash_msg', $this->alert->success('Income Delete Successfully.'));
        } else {
            $this->session->set_flashdata('flash_msg', $this->alert->warning($result));
        }
        redirect($this->path.qString());
    }
}
?>
