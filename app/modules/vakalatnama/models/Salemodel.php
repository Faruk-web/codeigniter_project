<?php
Class SaleModel extends MY_Model {

    function __construct()
    {
        parent:: __construct();
    }

    public function saleNo()
    {
        $this->db->select("*");
        $this->db->from('vakalatnama_sale');
        $this->db->where([
            'YEAR(created_at)'=>date('Y')
        ]);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->row();
        $lastInt = (!empty($data))?intval(substr($data->sale_number,2)):0;
        $ref = date('y');
        $ref .= substr("0000",0,-strlen($lastInt+1));
        $ref .= $lastInt+1;
        return $ref;
    }
    
    protected function searchData()
    {
        if ($this->input->get('q')) {
            $q = trim($this->input->get('q'));
            $this->db->where("(A.membership_number LIKE '%".$q."%' 
                OR A.serial_number LIKE '%".$q."%')", NULL, FALSE);
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
        $this->db->select('A.*, B.member_name, B.member_image');
        $this->db->from("$table AS A");
        $this->db->join("members AS B", 'A.membership_number=B.membership_number', 'left');
        $this->db->where(['A.id'=>$id]);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }
}
?>