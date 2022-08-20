<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends MX_Controller {

	protected $table;
    protected $viewpath;
    public $path;
	function __construct()
    {
        parent::__construct();
        $this->load->module('templates');
        $this->templates->authCheck();

        $this->viewpath = 'member/status_view';
        $this->path = 'member/status';

        $this->load->model('statusModel');
    }

	public function index()
	{
		$this->active();
	}

    public function active()
    {
        $count = $this->statusModel->countResult(['status' => 1]);
        $pagination = $this->templates->pagination($count, $this->path.'/active/', 500);

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->statusModel->selectResult(['status' => 1], $pagination['limit']);

        $data['pageName'] = 'active';
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function lifetime()
    {
        $count = $this->statusModel->countResult(['lifetime_member' => 1]);
        $pagination = $this->templates->pagination($count, $this->path.'/lifetime/', 500);

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->statusModel->selectResult(['lifetime_member' => 1], $pagination['limit']);

        $data['pageName'] = 'lifetime';
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function benevolent()
    {
        $count = $this->statusModel->countResult(['benevolent_fund' => 1]);
        $pagination = $this->templates->pagination($count, $this->path.'/benevolent/', 500);

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->statusModel->selectResult(['benevolent_fund' => 1], $pagination['limit']);

        $data['pageName'] = 'benevolent';
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function benevolentno()
    {
        $count = $this->statusModel->countResult(['benevolent_fund' => 2]);
        $pagination = $this->templates->pagination($count, $this->path.'/benevolentno/', 500);

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->statusModel->selectResult(['benevolent_fund' => 2], $pagination['limit']);

        $data['pageName'] = 'benevolentno';
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }

    public function dead()
    {
        $count = $this->statusModel->countResult(['status' => 2]);
        $pagination = $this->templates->pagination($count, $this->path.'/dead/', 500);

        $data['paginationLinks'] = $pagination['links'];
        $data['paginationMsg'] = $pagination['msg'];
        $data['serial'] = $pagination['serial'];
        $data['records'] = $this->statusModel->selectResult(['status' => 2], $pagination['limit']);

        $data['pageName'] = 'dead';
        $data['path'] = $this->path;
        $data['content_view'] = $this->viewpath;
        $this->templates->body($data);
    }
}