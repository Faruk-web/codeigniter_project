<?php
Class ProfileModel extends CI_Model {

    function __construct()
    {
        parent:: __construct();
    }

    public function findProfile()
    {
        $this->db->select("A.*");
        $this->db->from("users AS A");
        $this->db->where([
            'A.user_id'=>$this->session->userdata['logged_in']->user_id
        ]);
        
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }

    public function updateProfile( $table, $data )
    {
        $this->db->where([
            'user_id'=>$this->session->userdata['logged_in']->user_id
        ]);

        $this->db->update($table, $data);
        $affectedRow = $this->db->affected_rows();
        if ($affectedRow==1) {
            return 1;
        } else {
            return $this->db->error()['message'];
        }
    }
}
?>