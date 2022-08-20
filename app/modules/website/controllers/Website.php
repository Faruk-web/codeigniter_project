<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Website extends MX_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->module('templates');
    }

    public function index()
    {
        $this->load->model('website/webModel');
        $data['slides'] = $this->webModel->slides();
        $data['events'] = $this->webModel->events();
        
        $data['committeeG'] = $this->webModel->committeeGroup();

        $data['committees'] = $this->webModel->committeeSession($data['committeeG'][0]->session);

        $data['templateView'] = 'website/home_view';
        $this->templates->web($data);
    }

    public function history()
    {
        $this->load->model('website/webModel');
        $data['pages'] = $this->webModel->pages('history');
        $data['events'] = $this->webModel->events();

        $data['templateView'] = 'website/pages_view';
        $this->templates->web($data);
    }

    public function constitution()
    {
        $this->load->model('website/webModel');
        $data['pages'] = $this->webModel->pages('constitution');
        $data['events'] = $this->webModel->events();
        
        $data['templateView'] = 'website/pages_view';
        $this->templates->web($data);
    }
    public function display($id)
    {
        $this->load->model('website/webModel');

//        $path = 'D:\\wamp64\\www\\dtba.btla.net\\taxbar\\uploads\\members\\' .$id. '.jpg';
        $path = '/var/www/btla-net/dtba/uploads/members/' .$id. '.jpg';
        if(!$id || !file_exists($path)) $path = 'web-assets/img/no-image.jpg';
        $contents = file_get_contents($path);
        $this->output
            ->set_status_header(200)
            ->set_content_type('image/jpeg')
            ->set_output($contents)
            ->_display();

        /*<img src="<?php echo base_url().'constitution'; ?>"
        style="display: inline; left:0 !important;    " />*/
//        exit;
    }

    public function activities()
    {
        $this->load->model('website/webModel');
        $data['pages'] = $this->webModel->pages('activities');
        $data['events'] = $this->webModel->events();
        
        $data['templateView'] = 'website/pages_view';
        $this->templates->web($data);
    }

    public function presidentMessage()
    {
        $this->load->model('website/webModel');
        $data['pages'] = $this->webModel->pages('president-message');
        $data['events'] = $this->webModel->events();
        
        $data['templateView'] = 'website/pages_view';
        $this->templates->web($data);
    }

    public function secretaryMessage()
    {
        $this->load->model('website/webModel');
        $data['pages'] = $this->webModel->pages('secretary-message');
        $data['events'] = $this->webModel->events();
        
        $data['templateView'] = 'website/pages_view';
        $this->templates->web($data);
    }

    public function admissionForm()
    {
        $this->load->model('website/webModel');
        $data['pages'] = $this->webModel->pages('admission-form');
        $data['events'] = $this->webModel->events();
        
        $data['templateView'] = 'website/pages_view';
        $this->templates->web($data);
    }

    public function officeStaff()
    {
        $this->load->model('website/webModel');
        $data['staffs'] = $this->webModel->staffs();
        $data['events'] = $this->webModel->events();
        
        $data['templateView'] = 'website/staffs_view';
        $this->templates->web($data);
    }

    public function newsEvent()
    {
        $this->load->model('website/webModel');
        $data['events'] = $this->webModel->events();

        $data['templateView'] = 'website/events_view';
        $this->templates->web($data);
    }

    public function newsEventDetails($id)
    {
        $this->load->model('website/webModel');
        $data['events'] = $this->webModel->events(['id!=' => $id]);

        $data['eventsRow'] = $this->webModel->eventsSingle($id);
        
        $data['single'] = 1;
        $data['templateView'] = 'website/events_view';
        $this->templates->web($data);
    }

    public function gallery()
    {
        $this->load->model('website/webModel');
        $data['galleries'] = $this->webModel->galleries();

        $data['templateView'] = 'website/galleries_view';
        $this->templates->web($data);
    }

    public function membership()
    {
        $this->load->model('website/webModel');
        $data['events'] = $this->webModel->events();

        $count = $this->webModel->membersCount();
        $pagination = $this->templates->pagination($count, 'membership/lists/', 100, 3);

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['members'] = $this->webModel->members($pagination['limit']);

        $data['templateView'] = 'website/members_view';
        $this->templates->web($data);
    }

    public function membershipDetails($id)
    {
        $this->load->model('website/webModel');
        $data['events'] = $this->webModel->events();

        $data['members'] = $this->webModel->membersById($id);

        $data['templateView'] = 'website/members_details_view';
        $this->templates->web($data);
    }

    public function membershipChange($id)
    {
        $this->load->model('website/webModel');
        $data['events'] = $this->webModel->events();

        $data['members'] = $this->webModel->membersById($id);

        $data['templateView'] = 'website/members_change_view';
        $this->templates->web($data);
    }

    public function membershipUpdate($memberNo)
    {
        $this->load->model('website/webModel');
        $members = $this->webModel->membersById($memberNo);
        if (empty($members)) {
            $this->session->set_flashdata('flash_msg', $this->alert->warning('Member ID not found!'));
            redirect('membership/change-details/'.$memberNo);
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->alert->dmStart(), $this->alert->dmEnd());
        
        $this->form_validation->set_rules('data[member_name]', 'Name', 'trim|required');
        $this->form_validation->set_rules('data[father_name]', 'Fathers/Husband Name', 'trim|required');
        $this->form_validation->set_rules('data[gender]', 'Gender', 'trim|required');
        $this->form_validation->set_rules('data[religion]', 'Religion', 'trim|required');
        $this->form_validation->set_rules('data[permanent_address]', 'Permanent Address', 'trim|required');
        $this->form_validation->set_rules('data[residential_address]', 'Residential Address', 'trim|required');
       
        if ($this->form_validation->run()==false) {
            $this->session->set_flashdata('flash_msg', $this->alert->warning(validation_errors()));
            redirect('membership/change-details/'.$memberNo);
        }

        $data = $_POST['data'];
        if ($_FILES['image']['name']!='') {
            $uploadArray = [
                'file_name' => $memberNo,
                'allowed_types' => 'png|jpg|jpeg'
            ];

            $upload = $this->templates->upload('image', 'requests', $uploadArray);
            $data['member_image'] = $upload['file_name'];
        }        

        if ($_FILES['nid']['name']!='') {
            $uploadArray = [
                'file_name' => $memberNo,
                'allowed_types' => 'gif|png|jpg|jpeg'
            ];

            $upload = $this->templates->upload('nid', 'requests-nid', $uploadArray);
            $data['nationalid_copy'] = $upload['file_name'];
        }

        if ($_FILES['certif']['name'][0]!='') {
            $uploadArray = [
                'file_name' => $memberNo,
                'allowed_types' => 'gif|png|jpg|jpeg|pdf'
            ];

            $certificateData = [];
            foreach ($_FILES['certif']['name'] as $cK => $name) {
                $_FILES["certificate"] = [
                    'name' => $_FILES['certif']['name'][$cK],
                    'type' => $_FILES['certif']['type'][$cK],
                    'size' => $_FILES['certif']['size'][$cK],
                    'error' => $_FILES['certif']['error'][$cK],
                    'tmp_name' => $_FILES['certif']['tmp_name'][$cK],
                ];
                $upload = $this->templates->upload('certificate', 'requests-certificate', $uploadArray);

                $certificateData[] = $upload['file_name'];
            }

            $data['certificate'] = $certificateData;
        }


        $nomData = [];
        foreach ($this->input->post('n_name') as $nK => $n_name) {
            if ($n_name!='') {
                $subD = [
                    'nominee_name' => $this->input->post('n_name')[$nK],
                    'nominee_nid' => $this->input->post('n_nid')[$nK],
                    'percentage' => $this->input->post('n_per')[$nK],
                ];
                
                if ($_FILES['n_image']['name'][$nK]!='') {
                    $uploadArray = [
                        'file_name' => $memberNo.'-p',
                        'allowed_types' => 'png|jpg|jpeg'
                    ];
                    $_FILES["nImg"] = [
                        'name' => $_FILES['n_image']['name'][$nK],
                        'type' => $_FILES['n_image']['type'][$nK],
                        'size' => $_FILES['n_image']['size'][$nK],
                        'error' => $_FILES['n_image']['error'][$nK],
                        'tmp_name' => $_FILES['n_image']['tmp_name'][$nK],
                    ];
                    $upload = $this->templates->upload('nImg', 'requests-nominee', $uploadArray);
                    $subD['nominee_image'] = $upload['file_name'];
                }

                if ($_FILES['n_nid_copy']['name'][$nK]!='') {
                    $uploadArray = [
                        'file_name' => $memberNo.'-n',
                        'allowed_types' => 'png|jpg|jpeg|pdf'
                    ];
                    $_FILES["nNidCopy"] = [
                        'name' => $_FILES['n_nid_copy']['name'][$nK],
                        'type' => $_FILES['n_nid_copy']['type'][$nK],
                        'size' => $_FILES['n_nid_copy']['size'][$nK],
                        'error' => $_FILES['n_nid_copy']['error'][$nK],
                        'tmp_name' => $_FILES['n_nid_copy']['tmp_name'][$nK],
                    ];
                    $upload = $this->templates->upload('nNidCopy', 'requests-nominee', $uploadArray);
                    $subD['nominee_nid_copy'] = $upload['file_name'];
                }
                $nomData[] = $this->security->xss_clean($subD);
            }
            $data['nominee'] = $nomData;
        }

        $madeData = [
            'member_id' => $members->id,
            'json_data' => json_encode($data),
        ];
        $insId = $this->webModel->insert('member_change_requests', $madeData);

        if (is_numeric($insId)) {
            $this->session->set_flashdata('flash_msg', $this->alert->success('Change request sent successfully. Please be patience we will contact you shortly.'));
        } else {
            $this->session->set_flashdata('flash_msg', $this->alert->warning('Change request sending failed. Please try again later.'));
        }
        redirect('membership/change-details/'.$memberNo);
    }

    public function presentCommittee()
    {
        $this->load->model('website/webModel');
        $data['events'] = $this->webModel->events();
        
        $data['committeeG'] = $this->webModel->committeeGroup();

        $data['committees'] = $this->webModel->committeeSession($data['committeeG'][0]->session);

        $data['templateView'] = 'website/committee_view';
        $this->templates->web($data);
    }

    public function previousCommittee()
    {
        $this->load->model('website/webModel');
        $data['events'] = $this->webModel->events();
        
        $data['committeeG'] = $this->webModel->committeeGroup();

        $data['templateView'] = 'website/committee_group_view';
        $this->templates->web($data);
    }

    public function committee($session)
    {
        $this->load->model('website/webModel');
        $data['events'] = $this->webModel->events();
        
        $data['committeeG'] = [ (object) ['session' => $session]];

        $data['committees'] = $this->webModel->committeeSession($session);

        $data['templateView'] = 'website/committee_view';
        $this->templates->web($data);
    }

    public function contact()
    {
        $data['templateView'] = 'website/contact_view';
        $this->templates->web($data);
    }

    public function contactSend()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->alert->dmStart(), $this->alert->dmEnd());

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('message', 'Message', 'trim|required');

        if ($this->form_validation->run()==false) {
            $this->contact();
        } else {
            $this->load->library('email');
            $config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = TRUE;
            $config['mailtype'] = 'html';
            $this->email->initialize($config);

            $this->email->from(EMAIL, EMAIL_NAME);
            $this->email->to(EMAIL);
            $this->email->reply_to($this->input->post('email'), $this->input->post('name'));
            $this->email->subject(SITENAME.' : Contact mail.');
            $this->email->message(
                mailBody(
                    '<p>'.$this->input->post('message').'</p>'.
                    '<p>'.$this->input->post('name').'<br>'.$this->input->post('email').'</p>'
                )
            );

            if($this->email->send()){
                $this->session->set_flashdata('flash_msg', $this->alert->webSuccess('Thank you for your message. We will contact you as soon as possible.'));
            } else {
                $this->session->set_flashdata('flash_msg', $this->alert->warning('Email could not be sent. Try after a short time.'));
            }
            redirect('contact-us');
        }
    }
}
?>
