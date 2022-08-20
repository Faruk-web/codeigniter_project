<?php

require APPPATH . '/third_party/RestController.php';
require APPPATH . '/third_party/Format.php';

use chriskacerguis\RestServer\RestController;

class Association extends RestController
{


    protected $associations = [ ['code'=>'DTBA','name'=> "Dhaka Taxes Bar Association"],
        ['code'=>'BTLA','name'=> "Bangladesh Tax Lawyers Association"] ];

    protected $methods = [
        'index_get' => ['level' => 1, 'limit' => 1000],
        'list_get' => ['level' => 1, 'limit' => 1000],
    ];

    public function index_get()
    {
        $this->response([
            'status' => TRUE,
            'data' => $this->associations
        ], RestController::HTTP_OK);
    }

    public function list_get()
    {
        $this->response([
            'status' => TRUE,
            'data' => $this->associations
        ], RestController::HTTP_OK);

    }

}