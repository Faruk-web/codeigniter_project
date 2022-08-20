<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Templates extends MX_Controller {
    
	function __construct()
    {
		parent:: __construct();
	}

    public function web($data=null)
    {
        $this->load->view('web_view', $data);
    }

	public function auth($data=null)
    {
		$this->load->view('auth_view', $data);
	}

    public function body($data=null)
    {
        $this->load->view('body_view', $data);
    }

    public function blank()
    {
        $data['content_view'] = 'blank_view';
        $this->templates->body($data);
    }

    public function error()
    {
        //Admin 404
        if (isset($this->session->userdata['logged_in'])) {
            $data['content_view'] = 'error_view';
            $data['session'] = 1;
            $this->body($data);
        } else {
            //Website 404
            $data['templateView'] = 'website/404_view';
            $data['session'] = 1;
            $this->web($data);
        }        
    }

    public function authCheck() 
    {
        if (!isset($this->session->userdata['logged_in'])) {
            $this->session->set_flashdata('flash_msg','<h4 style="color:red; text-align:center;">Please Login First!</h4>');
            redirect('auth');
        }
    }

    public function portalSecurity()
    {
        if (!isset($this->session->userdata['member_logged_in'])) {
            $this->session->set_flashdata('flash_msg','<h4 style="color:red; text-align:center;">Please Login First!</h4>');
            redirect('portal/security/auth');
        }
    }

    public function pagination($count, $url, $show = 50, $segment = 4)
    {
        $this->load->library('pagination');
        $config['base_url'] = base_url($url);
        $config['suffix'] = ($_GET)?'?'.http_build_query($_GET):''; //For Query String.
        $config['first_url'] = ($_GET)?$config['base_url'].'?'.http_build_query($_GET):$config['base_url']; //For Query String.

        $config['uri_segment'] = $segment;
        $config['total_rows'] = $count;
        $config['per_page'] = $show;
        $config['use_page_numbers'] = TRUE;
        /*$config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';*/
        $config['num_links'] = 10;
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] ="</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tag_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tag_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tag_close'] = "</li>";
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $this->pagination->initialize($config);

        $pageNumber = $this->uri->segment($segment);
        $pageRow = intval(($pageNumber<=1)?0:($pageNumber*$config['per_page'])-$config['per_page']);

        $pageCount = ($pageNumber>0)?$pageNumber:1;

        $showTo = ($count>$show)?($pageRow+$show):$count;
        $data['msg'] = '<span class="text-muted">Showing '.($pageRow+1).' - '.$showTo.' of '.$count.' data(s)</span>';        

        $data['links'] = $this->pagination->create_links();

        $data['serial'] = ($pageRow+1);
        $data['limit'] = $config['per_page'].','.$pageRow;
        return $data;
    }

    public function upload($field_name,$path,$uploadArray=[],$thumbArray=[])
    {
        $this->load->library('upload');

        $path = UPLOADS.$path.'/';
        makedir($path);

        $config['upload_path'] = $path;
        if (!empty($uploadArray)) {
            foreach ($uploadArray as $key => $value) {
                if ($key!='thumb') {
                    $config[$key] = $value;
                }
            }
        }
        if (!isset($config['allowed_types'])) {
            $config['allowed_types'] = '*';
        }
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($field_name)) {
            $data['upload_error'] = $this->upload->display_errors();
            $data['file_name'] = '';
            return $data;
        } else {
            $data = $this->upload->data();

            if (isset($uploadArray['thumb'])) {

                $this->load->library('image_lib');
                $resize['image_library'] = 'gd2';
                $resize['source_image'] = $path.$data['file_name'];
                $resize['create_thumb'] = FALSE;
                $resize['new_image'] = 'thumb_'.$data['file_name'];
                $resize['maintain_ratio'] = TRUE;

                if (!empty($thumbArray)) {
                    foreach ($thumbArray as $key => $value) {
                        $resize[$key] = $value;
                    }
                } else {
                    $resize['width'] = 60;
                    $resize['height'] = 60;
                }
                $this->image_lib->initialize($resize);

                if ( ! $this->image_lib->resize()) {
                    echo $this->image_lib->display_errors();
                }
            }
            return $data;
        }
    }
    
}
