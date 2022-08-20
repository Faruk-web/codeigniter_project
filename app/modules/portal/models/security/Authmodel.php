<?php
Class AuthModel extends CI_Model {

    /**
     * @param array $phone_number
     * @return string|string[]
     */
    protected function _phone_repair($phone_number)
    {
        $phone_number = str_replace(['-', ' ', '+88'], "", $phone_number);;
        $phone_number = substr_replace($phone_number,'-',-6,0);
        return $phone_number;
    }

    public function doLogin()
	{
        $query =    $this->findMemberByUsernameAndPassword(
                    $this->input->post('membership_number'),
                    $this->input->post('mobile_number')
                    );

        if ($query->num_rows()==1) {
			//return $this->startSession($query->row());
			return $query->row();
		} else{
			return false;
		}
	}


    /**
     * @return bool
     */
    public function isLoggedIn()
    {
        return isset($this->session->userdata['member_logged_in']);
    }


    /**
     * @return mixed
     */
    public function getLoggedInMember()
    {
        return $this->session->userdata['member_logged_in'] ;
    }

    /**
     * @return mixed
     */
    public function getLoggedInMembershipNumber()
    {
        return $this->session->userdata['member_logged_in']->membership_number ;
    }


    /**
     * @return void
     */
    public function destroySession()
    {
        $this->session->unset_userdata('member_logged_in', $this->session->userdata['member_logged_in']);
        $this->session->sess_destroy();
    }


    /**
     * @param $result
     * @return void
     */
    public function startSession($result)
    {
        $this->session->set_userdata('member_logged_in', $result);
    }


    /**
     * @return mixed
     */
    public function findMemberByUsernameAndPassword($membership_number, $mobile_number)
    {
        $condition = [
            'BINARY(membership_number)' => $membership_number,
            'status' => 1
        ];

        $this->db->select('id, membership_number, member_name, mobile_number, gender');
        $this->db->from('members');
        $this->db->where($condition);
        $this->db->like('mobile_number', $mobile_number);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query;
    }
}
?>