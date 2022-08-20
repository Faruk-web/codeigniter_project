<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

	function __construct()
    {
        parent:: __construct();
    }
    
    public function insert( $table, $data, $queryView=false )
    {
        $defaultData = ['created_by' => $this->session->userdata['logged_in']->user_id];

        $this->db->insert($table, array_merge($data, $defaultData));
        $insert_id = $this->db->insert_id();

        if ($queryView) {
            echo $this->db->last_query();
        }

        if ($insert_id) {
            return $insert_id;
        } else {
            return $this->db->error()['message'];
        }
    }
    
    public function insertBatch($table, $dataArr, $queryView=false)
    {
        $defaultData = ['created_by' => $this->session->userdata['logged_in']->user_id];

        foreach ($dataArr as $key => $value) {
            $data[] = array_merge($value, $defaultData);
        }

        $insert_all = $this->db->insert_batch($table, $data);

        if ($queryView) {
            echo $this->db->last_query();
        }

        if ($insert_all) {
            return 1;
        } else {
            return $this->db->error()['message'];
        }
    }

    public function update($table, $data, $condition, $null='', $queryView=false)
    {
        if ($null) {
            $this->db->where($condition, NULL, FALSE);
        } else {
            $this->db->where($condition);
        }
        $this->db->update($table, $data);
        $affectedRow = $this->db->affected_rows();

        if ($queryView) {
            echo $this->db->last_query();
        }

        if ($affectedRow==1) {
            return 1;
        } else {
            return $this->db->error()['message'];
        }
    }
    
    public function updateBatch($table, $dataArr, $field, $queryView=false)
    {
        foreach ($dataArr as $key => $value) {
            $data[] = $value;
        }
        $update_all = $this->db->update_batch($table, $data, $field);

        if ($queryView) {
            echo $this->db->last_query();
        }

        if ($update_all) {
            return 1;
        } else {
            return $this->db->error()['message'];
        }
    }

    public function delete($table, $condition, $null='', $queryView=false)
    {
        
        if ($null) {
            $this->db->where($condition, NULL, FALSE);
        } else {
            $this->db->where($condition);
        }
        $deletedRow = $this->db->delete($table);

        if ($queryView) {
            echo $this->db->last_query();
        }

        if ($deletedRow==1) {
            return 1;
        } else {
            return $this->db->error()['message'];
        }
    }
}