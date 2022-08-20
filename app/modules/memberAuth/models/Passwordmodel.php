<?php
Class PasswordModel extends CI_Model {
	
	public function checkExists()
    {
		$condition = [
            'user_email' => $this->input->post('email'),
            'status' => 1
        ];

        $this->db->select('*');
        $this->db->from('users');
        $this->db->where($condition);
        return  $this->db->count_all_results();
	}

    public function storeToken( $data )
    {
        $this->db->insert('users_password_resets', $data);
        $this->db->insert_id();
    }
    
    public function checkToken( $token )
    {
        $condition = [
            'token' => $token,
            'created_at >=' => strtotime("-30 minutes")
        ];

        $this->db->select('*');
        $this->db->from('users_password_resets');
        $this->db->where($condition);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }

    public function updatePassword( $data, $email )
    {
        $condition = [
            'user_email' => $email
        ];
        
        $this->db->where($condition);
        $this->db->update('users', $data);
        $affectedRow = $this->db->affected_rows();
        //echo $this->db->last_query();
        return $affectedRow;
    }
}
?>