<?php
Class UsersModel extends MY_Model {

    function __construct(){
        parent:: __construct();
    }

    protected function searchData()
    {
        $this->db->where(['A.account_role!=' => 1]);
        if ($this->input->get('status')) {
            $status = trim($this->input->get('status'));
            $this->db->where(['A.status' => $status]);
        }

        if ($this->input->get('q')) {
            $q = trim($this->input->get('q'));
            $this->db->where("(A.user_name LIKE '%".$q."%' 
                OR A.user_email LIKE '%".$q."%' 
                OR A.username LIKE '%".$q."%')", NULL, FALSE);
        }
    }

    public function countResult($table)
    {
        $this->searchData();

        $this->db->select('A.*');
        $this->db->from("$table AS A");
        return  $this->db->count_all_results();
    }

    public function selectResult($table, $limit=null)
    {
        $this->searchData();

        $this->db->select('A.*');
        $this->db->from("$table AS A");
        $this->db->order_by('A.user_id','DESC');

        if ($limit!=null) {
            $lm = explode(',',$limit);
            $this->db->limit(intval($lm[0]),intval($lm[1]));
        }

        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    public function selectById($table, $id)
    {
        $this->db->select('A.*');
        $this->db->from("$table AS A");
        $this->db->where(['A.account_role!=' => 1, 'A.user_id'=>$id]);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }

    public function fetchUsers()
    {
        $this->db->select('A.user_id, A.user_name');
        $this->db->from("users AS A");
        $this->db->where(['A.account_role!=' => 1, 'A.status'=>1]);
        $this->db->order_by('A.user_name ASC');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
}
?>