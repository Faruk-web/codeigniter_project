<?php
Class SlidesModel extends MY_Model {

    function __construct()
    {
        parent:: __construct();
    }

    public function countResult($table)
    {
        $this->db->select('A.*');
        $this->db->from("$table AS A");
        //echo $this->db->last_query();
        return  $this->db->count_all_results();
    }

    public function selectResult($table, $limit=null)
    {
        $this->db->select('A.*');
        $this->db->from("$table AS A");
        $this->db->order_by('A.id','DESC');

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
}
?>