<?php
Class ReportModel extends MY_Model {

    function __construct()
    {
        parent:: __construct();
    }

    public function selectRegister()
    {
        if ($this->input->get('date')) {
            $date = trim($this->input->get('date'));
            $this->db->where(["A.recepit_date" => $date]);
        } else {
            if ($this->input->get('from')) {
                $from = trim($this->input->get('from'));
                $this->db->where(["A.recepit_date >=" => $from]);
            } else {
                $this->db->where(["A.recepit_date >=" => date('Y-m-d')]);
            }

            if ($this->input->get('to')) {
                $to = trim($this->input->get('to'));
                $this->db->where(["A.recepit_date <=" => $to]);
            } else {
                $this->db->where(["A.recepit_date <=" => date('Y-m-d')]);
            }
        }

        $this->db->select('A.id, A.recepit_number, B.membership_number, B.member_name, C.category_id, C.amount, D.category_name');
        $this->db->from("receipt AS A");
        $this->db->join('members AS B', 'A.member_id=B.id', 'inner');
        $this->db->join('receipt_data AS C', 'A.id=C.receipt_id', 'inner');
        $this->db->join('category AS D', 'C.category_id=D.id', 'inner');
        $this->db->where(["A.approved" => 1]);
        $this->db->order_by('A.id','ASC');

        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    public function selectReceived()
    {
        if ($this->input->get('year')) {
            $year = trim($this->input->get('year'));
            $this->db->where(["YEAR(A.recepit_date)" => $year]);
        } else {
            $this->db->where(["YEAR(A.recepit_date)" => date('Y')]);
        }

        if ($this->input->get('month')) {
            $month = trim($this->input->get('month'));
            $this->db->where(["MONTH(A.recepit_date)" => $month]);
        } else {
            $this->db->where(["MONTH(A.recepit_date)" => date('m')]);
        }

        $this->db->select('A.receipt_bank, B.category_id, SUM(B.amount) AS sumAmount, C.category_name');
        $this->db->from("receipt AS A");
        $this->db->join('receipt_data AS B', 'A.id=B.receipt_id', 'inner');
        $this->db->join('category AS C', 'B.category_id=C.id', 'inner');
        $this->db->where(["A.approved" => 1]);
        $this->db->group_by('A.receipt_bank, B.category_id');
        $this->db->order_by('A.id','ASC');

        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    public function selectCashbook()
    {
        if ($this->input->get('date')) {
            $date = trim($this->input->get('date'));
            $this->db->where(["A.approved_date" => $date]);
        } else {
            if ($this->input->get('year')) {
                $year = trim($this->input->get('year'));
                $this->db->where(["YEAR(A.approved_date)" => $year]);
            } else {
                $this->db->where(["YEAR(A.approved_date)" => date('Y')]);
            }

            if ($this->input->get('month')) {
                $month = trim($this->input->get('month'));
                $this->db->where(["MONTH(A.approved_date)" => $month]);
            } else {
                $this->db->where(["MONTH(A.approved_date)" => date('m')]);
            }
        }

        $this->db->select('A.approved_date, A.receipt_bank, B.category_id, SUM(B.amount) AS sumAmount, C.category_name');
        $this->db->from("receipt AS A");
        $this->db->join('receipt_data AS B', 'A.id=B.receipt_id', 'inner');
        $this->db->join('category AS C', 'B.category_id=C.id', 'inner');
        $this->db->where(["A.approved" => 1]);
        $this->db->group_by('A.approved_date, A.receipt_bank, B.category_id');
        $this->db->order_by('A.approved_date','ASC');

        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    public function selectLedger()
    {
        if ($this->input->get('category')) {
            $category = trim($this->input->get('category'));
            $this->db->where(["B.category_id" => $category]);
        }
        if ($this->input->get('bank')) {
            $bank = trim($this->input->get('bank'));
            $this->db->where(["A.receipt_bank" => $bank]);
        }

        if ($this->input->get('year')) {
            $year = trim($this->input->get('year'));
            $this->db->where(["YEAR(A.approved_date)" => $year]);
        } else {
            $this->db->where(["YEAR(A.approved_date)" => date('Y')]);
        }

        if ($this->input->get('month')) {
            $month = trim($this->input->get('month'));
            $this->db->where(["MONTH(A.approved_date)" => $month]);
        } else {
            $this->db->where(["MONTH(A.approved_date)" => date('m')]);
        }

        $this->db->select('A.approved_date, A.receipt_bank, B.category_id, SUM(B.amount) AS sumAmount, C.category_name');
        $this->db->from("receipt AS A");
        $this->db->join('receipt_data AS B', 'A.id=B.receipt_id', 'inner');
        $this->db->join('category AS C', 'B.category_id=C.id', 'inner');
        $this->db->where(["A.approved" => 1]);
        $this->db->group_by('A.approved_date');
        $this->db->order_by('A.approved_date','ASC');

        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    public function selectVakalatnama()
    {
        if ($this->input->get('date')) {
            $date = trim($this->input->get('date'));
            $this->db->where(["stock_date<=" => $date]);
        }
        $this->db->select("'stock' AS type, SUM(stock_quantity) AS quantity");
        $this->db->from("vakalatnama_stock");
        $query1 = $this->db->get_compiled_select();


        if ($this->input->get('date')) {
            $date = trim($this->input->get('date'));
            $this->db->where(["sale_date<=" => $date]);
        }
        $this->db->select("'sale' AS type, SUM(sale_quantity) AS quantity");
        $this->db->from("vakalatnama_sale");
        $query2 = $this->db->get_compiled_select();

        $query = $this->db->query("SELECT S.* FROM ($query1 UNION ALL $query2) S");

        //echo $this->db->last_query();
        return $query->result();
    }
}
?>