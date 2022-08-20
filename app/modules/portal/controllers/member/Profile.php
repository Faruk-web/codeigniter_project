<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MX_Controller {

        protected $table;
        protected $viewpath;
        public $path;

        function __construct()
        {
            parent::__construct();
            $this->load->module('templates');
            $this->templates->portalSecurity();

            $this->table = 'nomineeinfo';
            $this->viewpath = 'portal/profile/view';
            $this->path = 'portal/member/profile';

            $this->load->model('portal/receiptModel');
        }

        public function index()
        {
            echo 'profile-page';

            //$this->lists();    //Call Lists function.
        }

        public function view()
            {
                //$count = 10; //, $this->receiptModel->countResult($this->table, '0');
                //$pagination = $this->templates->pagination($count, $this->path.'/view');
                $data['path'] = $this->path;
                $data['content_view'] = 'portal/profile/view';
                $this->templates->body($data);
            }

            
        public function store() {

            // var_dump($_POST);

            /*
    'firstname' => string 'fjfgjgj' (length=7)
  'deposit_date' => string '2022-08-16' (length=10)
  'lastname' => string 'hjfhyjhgfsf' (length=11)
  'deposit_amount' => string '54654' (length=5)
  'country' => string 'canada' (length=6)
            */


            $data = [
                'profile_image' => $this->input->post('profile_image'),
                'firstname'     => $this->input->post('firstname'),
                'date_birth'    => $this->input->post('date_birth'),
                'passing_year'  => $this->input->post('passing_year'),
                'joining_year'  => $this->input->post('joining_year'),
                'nid_no'        => $this->input->post('nid_no'),
                'fb_link'       => $this->input->post('fb_link'),
                'twitter_link'  => $this->input->post('twitter_link'),
                'linkedIn'      => $this->input->post('linkedIn'),
                'country'       => $this->input->post('country'),
            ];
            
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters($this->alert->dmStart(), $this->alert->dmEnd());
            $this->form_validation->set_rules('firstname', 'Type', 'trim|required');
            // $this->form_validation->set_rules('date_birth', 'Date', 'trim|required');
            // $this->form_validation->set_rules('nid_no', 'Number', 'trim|required');
            
            if ($this->form_validation->run()==false) { 

                echo "error";
                var_dump($data);

            } else { 
                $insId = $this->db->insert($this->table, $data);
                echo "Data inserted >> ".$insId;
            }



            }




            public function change()
            {
                $count = $this->receiptModel->countResult($this->table, '0');
                $pagination = $this->templates->pagination($count, $this->path.'/change');
                $data['path'] = $this->path;
                $data['content_view'] = 'portal/profile/change';
                $this->templates->body($data);
            }
            public function recieptlist()
            {
                $count = $this->receiptModel->countResult($this->table, '0');
                $pagination = $this->templates->pagination($count, $this->path.'/recieptlist');
                $data['path'] = $this->path;
                $data['content_view'] = 'portal/profile/recieptlist';
                $this->templates->body($data);
            }

        }
      ?>



