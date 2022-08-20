<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense extends MX_Controller {
    
    protected $table;
    protected $dataTable;
    protected $viewpath;
    public $path;
    function __construct()
    {
        parent::__construct();
        $this->load->module('templates');
        $this->templates->authCheck();

        $this->table = 'expense';
        $this->dataTable = 'expense_data';
        $this->viewpath = 'expense/expense_view';
        $this->path = 'expense/expense';

        $this->load->model('expenseModel');
    }

    public function index()
    {
        $this->lists();    //Call Lists function.
    }

    public function lists()
    {
        /*Expense Head Fetch For dropdown*/
        $this->load->model('headModel');
        $data['headData'] = $this->headModel->fetchHead();

        $count = $this->expenseModel->countResult($this->table);
        $pagination = $this->templates->pagination($count, $this->path.'/lists/');

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->expenseModel->selectResult($this->table, $pagination['limit']);

        $data['lists'] = 1;
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function show($id)
    {
        $data['dataview'] = $this->expenseModel->selectById($this->table, $id);
        $data['dataSub'] = $this->expenseModel->findData($id);

        $data['show'] = $id;
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function create()
    {
        /*Expense Head Fetch For dropdown*/
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
        $data['dataview'] = $this->expenseModel->selectById($this->table, $id);

        if (empty($data['dataview'])) {
            $this->templates->blank();
        } else {
            /*Expense Head Fetch For dropdown*/
            $this->load->model('headModel');
            $data['headData'] = $this->headModel->fetchHead();

            $dataSubEmpty = [(object) ['id'=>'', 'head_id'=>'', 'amount'=>'']];
            $dataSub = $this->expenseModel->findData($id);
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

        $this->form_validation->set_rules('expense_date', 'Date', 'trim|required');
        
        if ($this->form_validation->run()==false) {
            $this->create();
        } else {
            $expenseNo = $this->expenseModel->expenseNo();
            $data = [
                'expense_number' => $expenseNo,
                'expense_date' => $this->input->post('expense_date'),
                'expense_note' => $this->input->post('expense_note'),
                'expense_amount' => $this->input->post('expense_amount'),
            ];

            $data = $this->security->xss_clean($data);
            $insId = $this->expenseModel->insert($this->table, $data);

            if (is_numeric($insId)) {

                $subData = [];
                foreach ($this->input->post('row_id') as $key => $rowId) {
                    if ($this->input->post('head_id')[$key]>0) {
                        $subD = [
                            'expense_id' => $insId,
                            'head_id' => $this->input->post('head_id')[$key],
                            'amount' => $this->input->post('amount')[$key]
                        ];
                        $subData[$key] = $this->security->xss_clean($subD);
                    }
                }
                $this->expenseModel->insertBatch($this->dataTable, $subData);


                $this->session->set_flashdata('flash_msg', $this->alert->success('Expense Added Successfully.'));

                redirect($this->path.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('Expense Adding Failed. '.$insId));

                $this->create();
            }
        }
    }

    public function update($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->alert->dmStart(),$this->alert->dmEnd());

        $this->form_validation->set_rules('expense_date', 'Date', 'trim|required');
       
        if ($this->form_validation->run()==false) {
            $this->edit($id);
        } else {
            $data = [
                'expense_date' => $this->input->post('expense_date'),
                'expense_note' => $this->input->post('expense_note'),
                'expense_amount' => $this->input->post('expense_amount'),
            ];
            
            $data = $this->security->xss_clean($data);
            $result = $this->expenseModel->update($this->table, $data, ['id'=>$id]);

            /*Data Table Update*/
            $implodeId = implode(',', array_filter($this->input->post('row_id')));
            if ($implodeId!='') {
                $this->expenseModel->delete($this->dataTable, ['expense_id'=>$id, 'id NOT IN('=>$implodeId.')'], 'null');
            }

            $updateSub = 0;
            foreach ($this->input->post('row_id') as $key => $rowId) {
                if ($this->input->post('head_id')[$key]>0) {
                    $subData = [
                        'expense_id' => $id,
                        'head_id' => $this->input->post('head_id')[$key],
                        'amount' => $this->input->post('amount')[$key]
                    ];
                    $subData = $this->security->xss_clean($subData);

                    if ($rowId>0) {
                        $this->expenseModel->update($this->dataTable, $subData, ['id'=>$rowId]);
                    } else {
                        $this->expenseModel->insert($this->dataTable, $subData);
                    }
                    $updateSub++;
                }
            }
            /*Data Table Update:: End*/

            if (is_numeric($result) || $updateSub>0) {
                $this->session->set_flashdata('flash_msg', $this->alert->success('Expense Update Successfully.'));

                redirect($this->path.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('Expense Update Failed. '.$result));
                
                redirect($this->path.'/edit/'.$id.qString());
            }
        }
    }

    public function delete($id)
    {
        $result = $this->expenseModel->delete($this->table, ['id'=>$id]);

        if (is_numeric($result)) {
            $this->expenseModel->delete($this->dataTable, ['expense_id'=>$id]);

            $this->session->set_flashdata('flash_msg', $this->alert->success('Expense Delete Successfully.'));
        } else {
            $this->session->set_flashdata('flash_msg', $this->alert->warning($result));
        }
        redirect($this->path.qString());
    }
}
?>
