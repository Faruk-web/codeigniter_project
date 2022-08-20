<?php
Class DashboardModel extends MY_Model {

    function __construct()
    {
        parent:: __construct();
    }

    protected function searchData()
    {
        if ($this->input->get('status')) {
            $status = trim($this->input->get('status'));
            $this->db->where(['A.status' => $status]);
        } else {
            $this->db->where(['A.status' => '0']);
        }
    }

    public function countResult()
    {
        $this->searchData();

        $this->db->select('A.*, B.membership_number');
        $this->db->from("member_change_requests AS A");
        $this->db->join("members AS B", 'A.member_id=B.id', 'inner');
        return $this->db->count_all_results();
    }

    public function selectResult($limit=null)
    {
        $this->searchData();

        $this->db->select('A.*, B.membership_number');
        $this->db->from("member_change_requests AS A");
        $this->db->join("members AS B", 'A.member_id=B.id', 'inner');
        $this->db->order_by('A.created_at', 'ASC');

        if ($limit!=null) {
            $lm = explode(',',$limit);
            $this->db->limit(intval($lm[0]),intval($lm[1]));
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function selectById($id)
    {
        $this->db->select('B.*, A.json_data, A.status, A.id, C.certificate');
        $this->db->from("member_change_requests AS A");
        $this->db->join("members AS B", 'A.member_id=B.id', 'inner');
        $this->db->join("(SELECT member_id, GROUP_CONCAT(certificate SEPARATOR '|') AS certificate FROM member_certificates GROUP BY member_id) AS C", 'A.member_id=C.member_id', 'left');
        $this->db->where(['A.id' => $id]);
        $query = $this->db->get();
        return $query->row();
    }

    public function selectNominee($memberId)
    {
        $this->db->select('A.*');
        $this->db->from("member_nominees AS A");
        $this->db->where(['A.member_id' => $memberId]);
        $query = $this->db->get();
        return $query->result();
    }
}
?>