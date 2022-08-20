<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends MX_Controller {

	protected $table;
    protected $viewpath;
    public $path;
	function __construct()
    {
        parent::__construct();
        $this->load->module('templates');
        $this->templates->authCheck();

        $this->table = 'members';
        $this->viewpath = 'member/member_view';
        $this->path = 'member/member';

        $this->load->model('memberModel');
    }

	public function index()
	{
		$this->lists();
	}

	public function lists()
	{
        $count = $this->memberModel->countResult($this->table);
        $pagination = $this->templates->pagination($count, $this->path.'/lists/', 100);

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->memberModel->selectResult($this->table, $pagination['limit']);

        $data['lists'] = 1;
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
	}

	public function show($id)
	{
		$data['data'] = $this->memberModel->selectById($this->table, $id);
        $data['nomineeData'] = $this->memberModel->selectNominee($id);

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
   		$data['data'] = $this->memberModel->selectById($this->table, $id);

   		if (empty($data['data'])) {
   			$this->templates->blank();
   		} else {
            $data['nomineeData'] = $this->memberModel->selectNominee($id);
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
        
        $this->form_validation->set_rules('membership_number', 'Membership No', 'trim|required');
        $this->form_validation->set_rules('member_name', 'Member Name', 'trim|required');
       
        if ($this->form_validation->run()==false) {
            $this->create();
        } else {
            $birthDate = '';
            if ($this->input->post('birth_date')!='') {
                $birthDate = $this->input->post('birth_date');
                $birthDate = str_replace('/', '-', $birthDate);
                $birthDate = date("Y-m-d", strtotime($birthDate));
            }

            $sanadDate = '';
            if ($this->input->post('sanad_date')!='') {
                $sanadDate = $this->input->post('sanad_date');
                $sanadDate = str_replace('/', '-', $sanadDate);
                $sanadDate = date("Y-m-d", strtotime($sanadDate));
            }

            $lifeMemberDate = '';
            if ($this->input->post('lifetime_member_date')!='') {
                $lifeMemberDate = $this->input->post('lifetime_member_date');
                $lifeMemberDate = str_replace('/', '-', $lifeMemberDate);
                $lifeMemberDate = date("Y-m-d", strtotime($lifeMemberDate));
            }

            $deathDate = '';
            if ($this->input->post('death_date')!='') {
                $deathDate = $this->input->post('death_date');
                $deathDate = str_replace('/', '-', $deathDate);
                $deathDate = date("Y-m-d", strtotime($deathDate));
            }

            $enrollDate = '';
            if ($this->input->post('enrollment_date')!='') {
                $enrollDate = $this->input->post('enrollment_date');
                $enrollDate = str_replace('/', '-', $enrollDate);
                $enrollDate = date("Y-m-d", strtotime($enrollDate));
            }
            $date = explode('-', $enrollDate);

            $data = [
                'membership_number' => $this->input->post('membership_number'),
                'member_name' => $this->input->post('member_name'),
                'father_name' => $this->input->post('father_name'),
                'mother_name' => $this->input->post('mother_name'),
                'spouse_name' => $this->input->post('spouse_name'),
                'birth_date' => $birthDate,
                'gender' => $this->input->post('gender'),
                'religion' => $this->input->post('religion'),
                'nationality' => $this->input->post('nationality'),
                'mobile_number' => $this->input->post('mobile_number'),
                'email' => $this->input->post('email'),
                'blood_group' => $this->input->post('blood_group'),
                'permanent_address' => $this->input->post('permanent_address'),
                'residential_address' => $this->input->post('residential_address'),
                'office_address' => $this->input->post('office_address'),
                'practicing_district' => $this->input->post('practicing_district'),
                'practicing_firm' => $this->input->post('practicing_firm'),
                'nationalid_number' => $this->input->post('nationalid_number'),
                'sanad_number' => $this->input->post('sanad_number'),
                'sanad_date' => $sanadDate,
                'enrollment_date' => $enrollDate,
                'lifetime_member' => $this->input->post('lifetime_member'),
                'lifetime_member_date' => $lifeMemberDate,
                'benevolent_fund' => $this->input->post('benevolent_fund'),
                'benevolent_startdate' => ($date[0]+1).'-01-01',
                'death_date' => $deathDate,
                'status' => $this->input->post('status'),
            ];

            /*For Image Upload*/
            if ($_FILES['member_image']['name']!='') {
                $uploadArray = [
                    'file_name' => $this->input->post('membership_number'),
                    'allowed_types' => 'gif|png|jpg|jpeg'
                ];

                $upload = $this->templates->upload('member_image', $this->table, $uploadArray);
                $data['member_image'] = $upload['file_name'];
            }

            if ($_FILES['nationalid_copy']['name']!='') {
                $uploadArray = [
                    'file_name' => $this->input->post('membership_number'),
                    'allowed_types' => 'gif|png|jpg|jpeg'
                ];

                $upload = $this->templates->upload('nationalid_copy', $this->table.'-nid', $uploadArray);
                $data['nationalid_copy'] = $upload['file_name'];
            }
            /*For Image Upload*/

            $data = $this->security->xss_clean($data);
            $insId = $this->memberModel->insert($this->table, $data);

            if (is_numeric($insId)) {
                /*For Certificate Upload*/
                if ($_FILES['certificate']['name'][0]!='') {
                    $uploadArray = [
                        'file_name' => $this->input->post('membership_number'),
                        'allowed_types' => 'gif|png|jpg|jpeg|pdf'
                    ];

                    $certData = [];
                    foreach ($_FILES['certificate']['name'] as $cK => $name) {
                        $_FILES["certificate_file"] = [
                            'name' => $_FILES['certificate']['name'][$cK],
                            'type' => $_FILES['certificate']['type'][$cK],
                            'size' => $_FILES['certificate']['size'][$cK],
                            'error' => $_FILES['certificate']['error'][$cK],
                            'tmp_name' => $_FILES['certificate']['tmp_name'][$cK],
                        ];
                        $upload = $this->templates->upload('certificate_file', $this->table.'-certificate', $uploadArray);

                        $certData[] = [
                            'member_id' => $insId,
                            'certificate' => $upload['file_name']
                        ];
                    }

                    if (!empty($certData)) {
                        $this->memberModel->insertBatch('member_certificates', $certData);
                    }
                }
                /*For Certificate Upload*/

                /*For Nominee Save*/
                $nomData = [];
                foreach ($this->input->post('row_id') as $nK => $rowId) {
                    if ($this->input->post('nominee_name')[$nK]!='') {
                        $subD = [
                            'member_id' => $insId,
                            'nominee_name' => $this->input->post('nominee_name')[$nK],
                            'nominee_nid' => $this->input->post('nominee_nid')[$nK],
                            'percentage' => $this->input->post('percentage')[$nK],
                        ];
                        
                        if ($_FILES['n_image']['name'][$nK]!='') {
                            $uploadArray = [
                                'file_name' => $this->input->post('membership_number').'-p',
                                'allowed_types' => 'png|jpg|jpeg'
                            ];
                            $_FILES["nominee_image"] = [
                                'name' => $_FILES['n_image']['name'][$nK],
                                'type' => $_FILES['n_image']['type'][$nK],
                                'size' => $_FILES['n_image']['size'][$nK],
                                'error' => $_FILES['n_image']['error'][$nK],
                                'tmp_name' => $_FILES['n_image']['tmp_name'][$nK],
                            ];
                            $upload = $this->templates->upload('nominee_image', $this->table.'-nominee', $uploadArray);
                            $subD['nominee_image'] = $upload['file_name'];
                        }

                        if ($_FILES['n_nid_copy']['name'][$nK]!='') {
                            $uploadArray = [
                                'file_name' => $this->input->post('membership_number').'-n',
                                'allowed_types' => 'png|jpg|jpeg|pdf'
                            ];
                            $_FILES["nominee_nid_copy"] = [
                                'name' => $_FILES['n_nid_copy']['name'][$nK],
                                'type' => $_FILES['n_nid_copy']['type'][$nK],
                                'size' => $_FILES['n_nid_copy']['size'][$nK],
                                'error' => $_FILES['n_nid_copy']['error'][$nK],
                                'tmp_name' => $_FILES['n_nid_copy']['tmp_name'][$nK],
                            ];
                            $upload = $this->templates->upload('nominee_nid_copy', $this->table.'-nominee', $uploadArray);
                            $subD['nominee_nid_copy'] = $upload['file_name'];
                        }
                        $nomData[] = $this->security->xss_clean($subD);
                    }
                }

                if (!empty($nomData)) {
                    $this->memberModel->insertBatch('member_nominees', $nomData);
                }
                /*For Nominee Save*/


                $this->session->set_flashdata('flash_msg', $this->alert->success('Member Added Successfully.'));

                redirect($this->path.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('Member Adding Failed. '.$insId));

                $this->create();
            }
        }
    }

    public function update($id)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->alert->dmStart(), $this->alert->dmEnd());

        $this->form_validation->set_rules('membership_number', 'Membership No', 'trim|required');
        $this->form_validation->set_rules('member_name', 'Member Name', 'trim|required');     

        if ($this->form_validation->run()==false) {
            $this->edit($id);
        } else {
            $birthDate = '';
            if ($this->input->post('birth_date')!='') {
                $birthDate = $this->input->post('birth_date');
                $birthDate = str_replace('/', '-', $birthDate);
                $birthDate = date("Y-m-d", strtotime($birthDate));
            }

            $sanadDate = '';
            if ($this->input->post('sanad_date')!='') {
                $sanadDate = $this->input->post('sanad_date');
                $sanadDate = str_replace('/', '-', $sanadDate);
                $sanadDate = date("Y-m-d", strtotime($sanadDate));
            }

            $lifeMemberDate = '';
            if ($this->input->post('lifetime_member_date')!='') {
                $lifeMemberDate = $this->input->post('lifetime_member_date');
                $lifeMemberDate = str_replace('/', '-', $lifeMemberDate);
                $lifeMemberDate = date("Y-m-d", strtotime($lifeMemberDate));
            }

            $deathDate = '';
            if ($this->input->post('death_date')!='') {
                $deathDate = $this->input->post('death_date');
                $deathDate = str_replace('/', '-', $deathDate);
                $deathDate = date("Y-m-d", strtotime($deathDate));
            }

            $enrollDate = '';
            if ($this->input->post('enrollment_date')!='') {
                $enrollDate = $this->input->post('enrollment_date');
                $enrollDate = str_replace('/', '-', $enrollDate);
                $enrollDate = date("Y-m-d", strtotime($enrollDate));
            }
            $date = explode('-', $enrollDate);
            
            $data = [
                'membership_number' => $this->input->post('membership_number'),
                'member_name' => $this->input->post('member_name'),
                'father_name' => $this->input->post('father_name'),
                'mother_name' => $this->input->post('mother_name'),
                'spouse_name' => $this->input->post('spouse_name'),
                'birth_date' => $birthDate,
                'gender' => $this->input->post('gender'),
                'religion' => $this->input->post('religion'),
                'nationality' => $this->input->post('nationality'),
                'mobile_number' => $this->input->post('mobile_number'),
                'email' => $this->input->post('email'),
                'blood_group' => $this->input->post('blood_group'),
                'permanent_address' => $this->input->post('permanent_address'),
                'residential_address' => $this->input->post('residential_address'),
                'office_address' => $this->input->post('office_address'),
                'practicing_district' => $this->input->post('practicing_district'),
                'practicing_firm' => $this->input->post('practicing_firm'),
                'nationalid_number' => $this->input->post('nationalid_number'),
                'sanad_number' => $this->input->post('sanad_number'),
                'sanad_date' => $sanadDate,
                'enrollment_date' => $enrollDate,
                'lifetime_member' => $this->input->post('lifetime_member'),
                'lifetime_member_date' => $lifeMemberDate,
                'benevolent_fund' => $this->input->post('benevolent_fund'),
                'benevolent_startdate' => ($date[0]+1).'-01-01',
                'death_date' => $deathDate,
                'status' => $this->input->post('status'),
            ];

            /*For Image Upload*/
            if ($_FILES['member_image']['name']!='') {
                $uploadArray = [
                    'file_name' => $this->input->post('membership_number'),
                    'allowed_types' => 'gif|png|jpg|jpeg'
                ];

                $upload = $this->templates->upload('member_image', $this->table, $uploadArray);
                $data['member_image'] = $upload['file_name'];
            }

            if ($_FILES['nationalid_copy']['name']!='') {
                $uploadArray = [
                    'file_name' => $this->input->post('membership_number'),
                    'allowed_types' => 'gif|png|jpg|jpeg'
                ];

                $upload = $this->templates->upload('nationalid_copy', $this->table.'-nid', $uploadArray);
                $data['nationalid_copy'] = $upload['file_name'];
            }
            /*For Image Upload*/

            $data = $this->security->xss_clean($data);
            $result = $this->memberModel->update($this->table, $data, ['id'=>$id]);

            /*For Certificate Upload*/
            if ($_FILES['certificate']['name'][0]!='') {
                $uploadArray = [
                    'file_name' => $this->input->post('membership_number'),
                    'allowed_types' => 'gif|png|jpg|jpeg|pdf'
                ];

                $certData = [];
                foreach ($_FILES['certificate']['name'] as $cK => $name) {
                    $_FILES["certificate_file"] = [
                        'name' => $_FILES['certificate']['name'][$cK],
                        'type' => $_FILES['certificate']['type'][$cK],
                        'size' => $_FILES['certificate']['size'][$cK],
                        'error' => $_FILES['certificate']['error'][$cK],
                        'tmp_name' => $_FILES['certificate']['tmp_name'][$cK],
                    ];
                    $upload = $this->templates->upload('certificate_file', $this->table.'-certificate', $uploadArray);

                    $certData[] = [
                        'member_id' => $id,
                        'certificate' => $upload['file_name']
                    ];
                }

                if (!empty($certData)) {
                    $this->memberModel->insertBatch('member_certificates', $certData);
                }
            }
            /*For Certificate Upload*/


            /*For Nominee Save*/
            $nomData = [];
            $nomUpdate = [];
            foreach ($this->input->post('row_id') as $nK => $rowId) {
                if ($this->input->post('nominee_name')[$nK]!='') {
                    $subD = [
                        'member_id' => $id,
                        'nominee_name' => $this->input->post('nominee_name')[$nK],
                        'nominee_nid' => $this->input->post('nominee_nid')[$nK],
                        'percentage' => $this->input->post('percentage')[$nK],
                    ];

                    if ($_FILES['n_image']['name'][$nK]!='') {
                        $uploadArray = [
                            'file_name' => $this->input->post('membership_number').'-p',
                            'allowed_types' => 'png|jpg|jpeg'
                        ];
                        $_FILES["nominee_image"] = [
                            'name' => $_FILES['n_image']['name'][$nK],
                            'type' => $_FILES['n_image']['type'][$nK],
                            'size' => $_FILES['n_image']['size'][$nK],
                            'error' => $_FILES['n_image']['error'][$nK],
                            'tmp_name' => $_FILES['n_image']['tmp_name'][$nK],
                        ];
                        $upload = $this->templates->upload('nominee_image', $this->table.'-nominee', $uploadArray);
                        $subD['nominee_image'] = $upload['file_name'];
                    }

                    if ($_FILES['n_nid_copy']['name'][$nK]!='') {
                        $uploadArray = [
                            'file_name' => $this->input->post('membership_number').'-n',
                            'allowed_types' => 'png|jpg|jpeg|pdf'
                        ];
                        $_FILES["nominee_nid_copy"] = [
                            'name' => $_FILES['n_nid_copy']['name'][$nK],
                            'type' => $_FILES['n_nid_copy']['type'][$nK],
                            'size' => $_FILES['n_nid_copy']['size'][$nK],
                            'error' => $_FILES['n_nid_copy']['error'][$nK],
                            'tmp_name' => $_FILES['n_nid_copy']['tmp_name'][$nK],
                        ];
                        $upload = $this->templates->upload('nominee_nid_copy', $this->table.'-nominee', $uploadArray);
                        $subD['nominee_nid_copy'] = $upload['file_name'];
                    }

                    if ($rowId>0) {
                        $subD['id'] = $rowId;
                        $nomUpdate[] = $this->security->xss_clean($subD);
                    } else {
                        $nomData[] = $this->security->xss_clean($subD);
                    }
                }
            }

            if (!empty($nomData)) {
                $this->memberModel->insertBatch('member_nominees', $nomData);
            }

            if (!empty($nomUpdate)) {
                $this->memberModel->updateBatch('member_nominees', $nomUpdate, 'id');
            }
            /*For Nominee Save*/

            if (is_numeric($result)) {
                $this->session->set_flashdata('flash_msg', $this->alert->success('Member Update Successfully.'));

                redirect($this->path.qString());
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('Member Update Failed. '.$result.$resultDetails));
                
                redirect($this->path.'/edit/'.$id.qString());
            }
        }
    }

    public function delete($id)
    {
        $result = $this->memberModel->delete($this->table, ['id'=>$id]);

        if (is_numeric($result)) {
            $this->memberModel->delete('member_certificates', ['member_id'=>$id]);
            $this->memberModel->delete('member_nominees', ['member_id'=>$id]);
            $this->session->set_flashdata('flash_msg', $this->alert->success('Member Delete Successfully.'));
        } else {
            $this->session->set_flashdata('flash_msg', $this->alert->warning($result));
        }
        redirect($this->path.qString());
    }

    public function memberCheckByQrCode()
    {
        $member_qr = $this->input->get('member_qr');
        $data = null;
        if (!empty($member_qr)) {
            $member_qr = explode("\n", $member_qr);
            $memberNo = str_replace('Membership ID: ', '', trim($member_qr[1]));
            $data = $this->memberModel->selectByNumber($memberNo);
        }        
        echo json_encode($data);
    }
}