<?php
Class ReceiptModel extends MY_Model {

    function __construct()
    {
        parent:: __construct();
    }

    public function receiptNo()
    {
        $this->db->select("*");
        $this->db->from('receipt');
        $this->db->where([
            'YEAR(created_at)'=>date('Y')
        ]);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $data = $query->row();
        $lastInt = (!empty($data))?intval(substr($data->recepit_number,2)):0;
        $ref = date('y');
        $ref .= substr("0000",0,-strlen($lastInt+1));
        $ref .= $lastInt+1;
        return $ref;
    }
   
    public function memberLastPayment($memberNo)
    {
        $this->db->select("A.finish_date");
        $this->db->from('receipt AS A');
        $this->db->join('members AS B', 'A.member_id=B.id', 'inner');
        $this->db->where(['B.membership_number'=>$memberNo]);
        $this->db->order_by('A.finish_date', 'DESC');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }

    protected function searchData($unApp)
    {
        if ($unApp==1) {
            $this->db->where(["A.approved" => 1]);
        }

        if ($unApp=='0') {
            $this->db->where(["A.approved" => 0]);
        }

        if ($this->input->get('receipt')) {
            $receipt = trim($this->input->get('receipt'));
            $this->db->where(["A.recepit_number LIKE" => $receipt."%"]);
        }
        if ($this->input->get('member')) {
            $member = trim($this->input->get('member'));
            $this->db->where(["B.membership_number LIKE" => $member."%"]);
        }
    }

    public function countResult($table, $unApp = null)
    {
        $this->searchData($unApp);

        $this->db->select('A.*, B.membership_number, B.member_name');
        $this->db->from("$table AS A");
        $this->db->join('members AS B', 'A.member_id=B.id', 'left');
        //echo $this->db->last_query();
        return  $this->db->count_all_results();
    }

    public function selectResult($table, $limit=null, $unApp = null)
    {
        $this->searchData($unApp);

        $this->db->select('A.*, B.membership_number, B.member_name');
        $this->db->from("$table AS A");
        $this->db->join('members AS B', 'A.member_id=B.id', 'left');
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
        $this->db->select("A.*, B.id AS member_id, B.membership_number, B.member_name, B.father_name, B.enrollment_date");
        $this->db->from("$table AS A");
        $this->db->join('members AS B', 'A.member_id=B.id', 'left');
        $this->db->where(['A.id'=>$id]);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }

    public function categoryAll($receiptId = null, $join = 'left')
    {
        $this->db->select('A.id, A.category_name, A.category_amount, A.serial as category_serial, A.monthlyin_receipt, A.yearlyin_receipt, A.benevolent_status, A.applied_lifemember');
        $this->db->from("category AS A");
        $this->db->where(['A.status'=>1]);
        //$this->db->order_by('A.category_name ASC');
        if ($receiptId) {
            $this->db->select("B.id AS data_id, B.amount");
            $this->db->join("receipt_data AS B", 'A.id=B.category_id AND B.receipt_id='.$receiptId, $join);
        } else {
            $this->db->select("0 AS data_id, CASE 
                WHEN A.monthlyin_receipt = 1 AND A.category_amount > 0
                THEN A.category_amount
                ELSE '' END AS amount");
        }
        $this->db->order_by("A.serial ASC, A.id ASC");
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    public function memberCheck($memberNo)
    {
        $this->db->select('A.id, A.member_name, A.lifetime_member, A.benevolent_fund, A.benevolent_startdate, B.unapprovedCount');
        $this->db->from("members AS A");
        $this->db->join("(SELECT member_id, COUNT(id) as unapprovedCount FROM receipt WHERE approved=0 GROUP BY member_id) AS B", 'A.id=B.member_id', 'left');
        $this->db->where(['A.membership_number'=>$memberNo]);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }
}
?>