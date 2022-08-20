<?php
class MemberModel extends MY_Model {

	function __construct()
    {
		parent::__construct();
	}

    protected function searchData()
    {
        if ($this->input->get('birth_date')) {
            $birth_date = trim($this->input->get('birth_date'));
            $this->db->where(["A.birth_date" => $birth_date]);
        }
        if ($this->input->get('enrollment_date')) {
            $enrollment_date = trim($this->input->get('enrollment_date'));
            $this->db->where(["A.enrollment_date" => $enrollment_date]);
        }

        if ($this->input->get('q')) {
            $q = trim($this->input->get('q'));
            $this->db->where("(A.member_name LIKE '%".$q."%' 
            OR A.membership_number LIKE '%".$q."%' 
            OR A.gender LIKE '%".$q."%' 
            OR A.religion LIKE '%".$q."%' 
            OR A.mobile_number LIKE '%".$q."%' 
            OR A.email LIKE '%".$q."%' 
            OR A.sanad_number LIKE '%".$q."%'
            OR A.nationalid_number LIKE '%".$q."%')", NULL, FALSE);
        }
    }

	public function countResult($table)
	{
        $this->searchData();

		$this->db->select('A.*');
		$this->db->from("$table AS A");
		return $this->db->count_all_results();
	}

	public function selectResult($table, $limit=null )
	{
        $this->searchData();
    	
		$this->db->select('A.*');
		$this->db->from("$table AS A");
		$this->db->order_by('A.membership_number', 'ASC');

		if ($limit!=null) {
            $lm = explode(',',$limit);
            $this->db->limit(intval($lm[0]),intval($lm[1]));
    	}

		$query = $this->db->get();
		return $query->result();
	}

	public function selectById($table, $id)
	{
		$this->db->select('A.*, B.certificate');
        $this->db->from("$table AS A");
		$this->db->join("(SELECT member_id, GROUP_CONCAT(certificate SEPARATOR '|') AS certificate FROM member_certificates GROUP BY member_id) AS B", 'A.id=B.member_id', 'left');
		$this->db->where(['A.id' => $id]);
		$query = $this->db->get();
		return $query->row();
	}

	public function selectByNumber($memberNo)
	{
		$this->db->select('A.*');
        $this->db->from("members AS A");
		$this->db->where(['A.membership_number' => $memberNo]);
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