<?php
Class WebModel extends CI_Model {

    function __construct()
    {
        parent:: __construct();
    }
    
    public function insert($table, $data, $queryView=false)
    {
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();

        if ($queryView) {
            echo $this->db->last_query();
        }

        if ($insert_id) {
            return $insert_id;
        } else {
            return $this->db->error()['message'];
        }
    }

    public function slides()
    {
        $this->db->select("*");
        $this->db->from("web_slides");
        $this->db->where(['status'=>1]);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    public function events($condition = null)
    {
        if($condition) {
            $this->db->where($condition);
        }
        $this->db->select("*");
        $this->db->from("web_events");
        $this->db->where(['status'=>1]);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    public function eventsSingle($id)
    {
        $this->db->select("*");
        $this->db->from("web_events");
        $this->db->where(['id' => $id]);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }

    public function pages($name)
    {
        $this->db->select("*");
        $this->db->from("web_pages");
        $this->db->where(['page_name' => $name]);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->row();
    }

    public function staffs()
    {
        $this->db->select("*");
        $this->db->from("web_staffs");
        $this->db->where(['status'=>1]);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    public function galleries()
    {
        $this->db->select("*");
        $this->db->from("web_galleries");
        $this->db->where(['status'=>1]);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    public function membersCount()
    {
        if ($this->input->get('id')!='') {
            $id = trim($this->input->get('id'));
            $this->db->where(["A.membership_number" => $id]);
        }
        if ($this->input->get('name')!='') {
            $name = trim($this->input->get('name'));
            $this->db->where(["A.member_name LIKE " => '%'.$name.'%']);
        }
        if ($this->input->get('mobile')!='') {
            $mobile = trim($this->input->get('mobile'));
            $this->db->where(["A.mobile_number LIKE " => '%'.$mobile.'%']);
        }

        $this->db->select('A.*');
        $this->db->from("members AS A");
        return $this->db->count_all_results();
    }

    public function members($limit=null)
    {
        if ($this->input->get('id')!='') {
            $id = trim($this->input->get('id'));
            $this->db->where(["A.membership_number" => $id]);
        }
        if ($this->input->get('name')!='') {
            $name = trim($this->input->get('name'));
            $this->db->where(["A.member_name LIKE " => '%'.$name.'%']);
        }
        if ($this->input->get('mobile')!='') {
            $mobile = trim($this->input->get('mobile'));
            $this->db->where(["A.mobile_number LIKE " => '%'.$mobile.'%']);
        }
        
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

    public function membersById($id)
    {
        $this->db->select('A.*');
        $this->db->from("members AS A");
        $this->db->where(['A.membership_number' => $id]);
        $query = $this->db->get();
        return $query->row();
    }
   
    public function committeeGroup()
    {
        $this->db->select("session");
        $this->db->from("web_committees");
        $this->db->group_by('session');
        $this->db->order_by('session', 'DESC');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
   
    public function committeeSession($session)
    {
        $this->db->select("A.designation, A.membership_number, B.member_image, B.member_name");
        $this->db->from("web_committees AS A");
        $this->db->join("members AS B", 'A.membership_number=B.membership_number', 'inner');
        $this->db->where(['session'=>$session]);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
}
?>