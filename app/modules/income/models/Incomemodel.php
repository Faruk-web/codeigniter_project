<?php
Class IncomeModel extends MY_Model {

    function __construct()
    {
        parent:: __construct();
    }

    public function incomeNo()
    {
        $this->db->select("*");
        $this->db->from('income');
        $this->db->where([
            'YEAR(created_at)'=>date('Y')
        ]);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->row();
        $lastInt = (!empty($data))?intval(substr($data->income_number,2)):0;
        $ref = date('y');
        $ref .= substr("0000",0,-strlen($lastInt+1));
        $ref .= $lastInt+1;
        return $ref;
    }

    protected function searchData()
    {
        if ($this->input->get('q')) {
            $q = trim($this->input->get('q'));
            $this->db->where("(A.income_number LIKE '%".$q."%' 
                OR A.income_note LIKE '%".$q."%')", NULL, FALSE);
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

        $this->db->select('A.*, B.totalAmount, B.headId');
        $this->db->from("$table AS A");
        $this->db->join("(SELECT income_id, GROUP_CONCAT(head_id SEPARATOR '|') AS headId, SUM(amount) AS totalAmount FROM income_data GROUP BY income_id) B", 'A.id=B.income_id', 'inner');
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
        $this->db->select('A.*');
        $this->db->from("$table AS A");
        $this->db->where(['A.id'=>$id]);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }

    public function findData($incomeId)
    {
        $this->db->select('A.*, B.head_name');
        $this->db->from("income_data AS A");
        $this->db->join('income_head AS B', 'A.head_id=B.id', 'left');
        $this->db->where(['A.income_id'=>$incomeId]);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
}
?>