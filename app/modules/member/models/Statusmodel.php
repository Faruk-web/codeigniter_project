<?php
class StatusModel extends MY_Model {

	function __construct()
    {
		parent::__construct();
	}

    protected function searchData()
    {
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

	public function countResult($condition)
	{
        $this->searchData();
        $this->db->where($condition);

		$this->db->select('A.*');
		$this->db->from("members AS A");
		return $this->db->count_all_results();
	}

	public function selectResult($condition, $limit=null)
	{
        $this->searchData();
        $this->db->where($condition);
    	
		$this->db->select('A.*');
		$this->db->from("members AS A");
		$this->db->order_by('A.membership_number', 'ASC');

		if ($limit!=null) {
            $lm = explode(',',$limit);
            $this->db->limit(intval($lm[0]),intval($lm[1]));
    	}

		$query = $this->db->get();
		return $query->result();
	}
}
?>