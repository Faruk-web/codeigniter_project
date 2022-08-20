<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MX_Controller {

    protected $table;
    protected $viewpath;
    public $path;
    function __construct()
    {
        parent::__construct();
        $this->load->module('templates');
        $this->templates->authCheck();

        $this->path = 'report/report';

        $this->load->model('reportModel');
    }

    public function index()
    {
        $this->register();
    }

    public function register()
    {
        $memberData = [];
        $categoryData = [];
        $amountData = [];
        $registers = $this->reportModel->selectRegister();
        foreach ($registers as $reg) {
            $memberData[$reg->id] = [0 => $reg->recepit_number, 1 => $reg->membership_number, 2 => $reg->member_name];
            $categoryData[$reg->category_id] = $reg->category_name;
            $amountData[$reg->id][$reg->category_id] = $reg->amount;
        }

        $data['records'] = [
            'memberData' => $memberData,
            'categoryData' => $categoryData,
            'amountData' => $amountData
        ];

        $data['path'] = $this->path;
        $data['content_view'] = 'report/register_view';
        $this->templates->body($data);
    }

    public function received()
    {
        $categoryData = [];
        $receiptData = [];
        $receipts = $this->reportModel->selectReceived();
        foreach ($receipts as $val) {
            $categoryData[$val->category_id] = $val->category_name;
            $receiptData[$val->category_id][$val->receipt_bank] = $val->sumAmount;
        }

        $data['records'] = [
            'receipts' => $receiptData,
            'categoryData' => $categoryData
        ];

        $data['path'] = $this->path;
        $data['content_view'] = 'report/received_view';
        $this->templates->body($data);
    }

    public function cashbook()
    {
        $this->load->model('category/categoryModel');
        $data['catData'] = $this->categoryModel->fetchCategory();

        $dateArr = [];
        $records = $this->reportModel->selectCashbook();
        foreach ($records as $val) {
            $dateArr[$val->approved_date][$val->receipt_bank][] = [
                'category' => $val->category_name,
                'amount' => $val->sumAmount,
            ];
        }

        $data['dateArr'] = $dateArr;

        $data['path'] = $this->path;
        $data['content_view'] = 'report/cashbook_view';
        $this->templates->body($data);
    }

    public function ledger()
    {
        $this->load->model('category/categoryModel');
        $data['catData'] = $this->categoryModel->fetchCategory();

        $data['records'] = $this->reportModel->selectLedger();

        $data['path'] = $this->path;
        $data['content_view'] = 'report/ledger_view';
        $this->templates->body($data);
    }

    public function vakalatnama()
    {
        $data['records'] = $this->reportModel->selectVakalatnama();

        $data['path'] = $this->path;
        $data['content_view'] = 'report/vakalatnama_view';
        $this->templates->body($data);
    }
}
?>