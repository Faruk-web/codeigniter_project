<?php
Class AuthModel extends CI_Model {
	
	public function doLogin()
	{
		$condition = [
            'BINARY(username)' => $this->input->post('username'),
            'status' => 1
        ];

		$this->db->select('user_id, user_name, user_email, username, password, account_role');
		$this->db->from('users');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();
		
		if ($query->num_rows()==1) {
			return $query->row();
		} else{
			return false;
		}
	}
}
?>