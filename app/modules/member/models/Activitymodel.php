<?php
class ActivityModel extends MY_Model {

    function __construct()
    {
        parent::__construct();
    }

    public function countDefaulter()
    {
        $this->db->where(['A.approved' => 1, 'C.status' => 1]);
        if ($this->input->get('date')) {
            $date = trim($this->input->get('date'));
            $this->db->where(["A.recepit_date<=" => $date]);
        }
        if ($this->input->get('year')) {
            $year = trim($this->input->get('year'));
            $this->db->where(["YEAR(A.finish_date)<=" => $year]);
        }
        if ($this->input->get('month')) {
            $month = trim($this->input->get('month'));
            $this->db->where(["MONTH(A.finish_date)<=" => $month]);
        }

        $this->db->select('C.*, A.recepit_date, A.finish_date');
        $this->db->from("receipt AS A");
        $this->db->join("receipt_data AS B", 'A.id=B.receipt_id', 'inner');
        $this->db->join("members AS C", 'A.member_id=C.id', 'inner');
        $this->db->where(['B.category_id' => 6]);
        $this->db->group_by('A.member_id');
        $this->db->order_by('C.membership_number', 'ASC');

        $query = $this->db->get();
        return $query->num_rows();
    }

    public function selectDefaulter($limit=null)
    {
        $this->db->where(['A.approved' => 1, 'C.status' => 1]);
        if ($this->input->get('date')) {
            $date = trim($this->input->get('date'));
            $this->db->where(["A.recepit_date<=" => $date]);
        }
        if ($this->input->get('year')) {
            $year = trim($this->input->get('year'));
            $this->db->where(["YEAR(A.finish_date)<=" => $year]);
        }
        if ($this->input->get('month')) {
            $month = trim($this->input->get('month'));
            $this->db->where(["MONTH(A.finish_date)<=" => $month]);
        }

        $this->db->select('C.*, A.recepit_date, A.finish_date');
        $this->db->from("receipt AS A");
        $this->db->join("receipt_data AS B", 'A.id=B.receipt_id', 'inner');
        $this->db->join("members AS C", 'A.member_id=C.id', 'inner');
        $this->db->where(['B.category_id' => 6]);
        $this->db->group_by('A.member_id');
        $this->db->order_by('C.membership_number', 'ASC');

        if ($limit!=null) {
            $lm = explode(',',$limit);
            $this->db->limit(intval($lm[0]),intval($lm[1]));
        }

        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    public function countVoter()
    {
        $this->db->where(['A.approved' => 1, 'C.status' => 1]);
        if ($this->input->get('date')) {
            $date = trim($this->input->get('date'));
            $this->db->where(["A.recepit_date>=" => $date]);
        }
        if ($this->input->get('year')) {
            $year = trim($this->input->get('year'));
            $this->db->where(["YEAR(A.finish_date)>=" => $year]);
        }
        if ($this->input->get('month')) {
            $month = trim($this->input->get('month'));
            $this->db->where(["MONTH(A.finish_date)>=" => $month]);
        }

        $this->db->select('C.*, A.recepit_date, A.finish_date');
        $this->db->from("receipt AS A");
        $this->db->join("receipt_data AS B", 'A.id=B.receipt_id', 'inner');
        $this->db->join("members AS C", 'A.member_id=C.id', 'inner');
        $this->db->where(['B.category_id' => 6]);
        $this->db->group_by('A.member_id');
        $this->db->order_by('C.membership_number', 'ASC');

        $query = $this->db->get();
        return $query->num_rows();
    }

    public function selectVoter($limit=null)
    {
        $this->db->where(['A.approved' => 1, 'C.status' => 1]);
        if ($this->input->get('date')) {
            $date = trim($this->input->get('date'));
            $this->db->where(["A.recepit_date>=" => $date]);
        }
        if ($this->input->get('year')) {
            $year = trim($this->input->get('year'));
            $this->db->where(["YEAR(A.finish_date)>=" => $year]);
        }
        if ($this->input->get('month')) {
            $month = trim($this->input->get('month'));
            $this->db->where(["MONTH(A.finish_date)>=" => $month]);
        }

        $this->db->select('C.*, A.recepit_date, A.finish_date');
        $this->db->from("receipt AS A");
        $this->db->join("receipt_data AS B", 'A.id=B.receipt_id', 'inner');
        $this->db->join("members AS C", 'A.member_id=C.id', 'inner');
        $this->db->where(['B.category_id' => 6]);
        $this->db->group_by('A.member_id');
        $this->db->order_by('C.membership_number', 'ASC');

        if ($limit!=null) {
            $lm = explode(',',$limit);
            $this->db->limit(intval($lm[0]),intval($lm[1]));
        }

        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    public function countStuckOff()
    {
        $this->db->where(['A.status' => 3]);

        $this->db->select('A.*, B.recepit_date, B.finish_date');
        $this->db->from("members AS A");
        $this->db->join("(SELECT X.member_id, X.recepit_date, X.finish_date 
            FROM receipt AS X 
            INNER JOIN receipt_data AS Y ON X.id=Y.receipt_id
            WHERE Y.category_id=6 GROUP BY X.member_id
        ) AS B", 'A.id=B.member_id', 'left');
        $this->db->order_by('A.membership_number', 'ASC');

        $query = $this->db->get();
        return $query->num_rows();
    }

    public function selectStuckOff($limit=null)
    {
        $this->db->where(['A.status' => 3]);

        $this->db->select('A.*, B.recepit_date, B.finish_date');
        $this->db->from("members AS A");
        $this->db->join("(SELECT X.member_id, X.recepit_date, X.finish_date 
            FROM receipt AS X 
            INNER JOIN receipt_data AS Y ON X.id=Y.receipt_id
            WHERE Y.category_id=6 GROUP BY X.member_id
        ) AS B", 'A.id=B.member_id', 'left');
        $this->db->order_by('A.membership_number', 'ASC');

        if ($limit!=null) {
            $lm = explode(',',$limit);
            $this->db->limit(intval($lm[0]),intval($lm[1]));
        }

        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
}
?>