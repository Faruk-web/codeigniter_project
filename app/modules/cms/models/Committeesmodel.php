<?php
Class CommitteesModel extends MY_Model {

    function __construct()
    {
        parent:: __construct();
    }

    protected function searchData()
    {
        if ($this->input->get('q')) {
            $q = trim($this->input->get('q'));
            $this->db->where(["A.session LIKE" => "%".$q."%"]);
        }
    }

    public function countResult($table)
    {
        $this->searchData();

        $this->db->select('A.*');
        $this->db->from("$table AS A");
        $this->db->group_by('A.session');
        //echo $this->db->last_query();
        return  $this->db->count_all_results();
    }

    public function selectResult($table, $limit=null)
    {
        $this->searchData();

        $this->db->select('A.session, COUNT(A.id) AS total');
        $this->db->from("$table AS A");
        $this->db->group_by('A.session');
        $this->db->order_by('A.session','ASC');

        if ($limit!=null) {
            $lm = explode(',',$limit);
            $this->db->limit(intval($lm[0]),intval($lm[1]));
        }

        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
   
    public function selectSession($table, $session)
    {
        $this->db->select("id, session, designation, membership_number");
        $this->db->from("$table");
        $this->db->where(['session'=>$session]);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
}
?>