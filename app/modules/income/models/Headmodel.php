<?php
Class HeadModel extends MY_Model {

    function __construct()
    {
        parent:: __construct();
    }

    protected function searchData()
    {
        if ($this->input->get('q')) {
            $q = trim($this->input->get('q'));
            $this->db->where(["A.head_name LIKE" => "%".$q."%"]);
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

        $this->db->select('A.*, B.countId');
        $this->db->from("$table AS A");
        $this->db->join("(SELECT head_id, COUNT(id) AS countId FROM income_data GROUP BY head_id) B", 'A.id=B.head_id', 'left');
        $this->db->order_by('A.head_name','ASC');

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
        $this->db->select("A.*");
        $this->db->from("$table AS A");
        $this->db->where(['A.id'=>$id]);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }

    public function fetchHead()
    {
        $this->db->select('A.id, A.head_name');
        $this->db->from("income_head AS A");
        $this->db->where(['A.status'=>1]);
        $this->db->order_by('A.head_name ASC');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
}
?>