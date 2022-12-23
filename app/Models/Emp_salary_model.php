<?php

class Emp_salary_model extends CI_Model
{

    public function getsalary($content_id)
    {
        if ($content_id) {
            return $this->db->query("select * from emp_salary WHERE content_id=$content_id order by id DESC")->row_array();
        }
    }
    public function get_salary_deduction($content_id)
    {
        if ($content_id) {
            return $this->db->query("select content_id from emp_salary_deduction WHERE content_id=$content_id order by id DESC")->row_array();
        }
    }
    public function get_payment_method($content_id)
    {
        if ($content_id) {
            return $this->db->query("SELECT content_id FROM emp_payment_method WHERE content_id=$content_id ORDER BY id DESC")->row_array();
        }
    }
    public function getallsalary($content_id)
    {
        if ($content_id) {
            return $this->db->query("select * from emp_salary WHERE content_id=$content_id order by id DESC")->result_array();
        }
    }
    public function get_salary_info_by_content_id($content_id)
    {
        //dd($content_id);
        // $content_id=19;
        if ($content_id) {
            return $this->db->query("select SUM(basic_salary) as basic_salary,"
                . "SUM(house_rent) as house_rent,"
                . "SUM(medical_allow) as medical_allow,"
                . "SUM(conveyance_allow) as conveyance_allow,"
                . "SUM(telephone_allow) as telephone_allow,"
                . "SUM(special_allowa) as special_allowa,"
                . "SUM(provident_allow) as provident_allow,"
                . "SUM(transport_allow) as transport_allow,"
                . "SUM(other_allow) as other_allow,"
                . "SUM(performance_bonus) as performance_bonus,"
                . "SUM(festival_bonus) as festival_bonus,"
                . "SUM(total_benifit)  as total_benifit "
                . "from emp_salary WHERE content_id=$content_id order by id DESC")->row_array();
        }
    }
    public function getallsalarybyasc($content_id)
    {
        if ($content_id) {
            return $this->db->query("select * from emp_salary WHERE content_id=$content_id order by id ASC")->result_array();
        }
    }
    public function getprevioussalary($content_id)
    {
        if ($content_id) {
            return $this->db->query("select * from emp_salary WHERE content_id=$content_id order by id DESC LIMIT 2")->result_array();
        }
    }
    public function getsalarybysalaryid($id)
    {
        if ($id) {
            return $this->db->query("select * from emp_salary WHERE id=$id")->row_array();
        }
    }
    function getLastcontentId($content_id)
    {
        if ($content_id) {
            $query = $this->db->query("SELECT id FROM emp_salary WHERE content_id=$content_id ORDER BY id DESC LIMIT 1");
            return $last_id = $query->row()->id;
        }
    }
    public function updEmp_salarytbl($data = array(), $where = array())
    {
        if ($data && $where) {
            $this->db->where($where);
            $this->db->update('emp_salary', $data);
            return true;
        }
    }
    public function updateSalaryDeduction($data, $content_id)
    {
        $this->db->where('content_id', $content_id);
        $this->db->update('emp_salary_deduction', $data);
        return true;
    }

    function deleteSalary($id)
    {
        $tables = array('emp_salary');
        $this->db->where('id', $id);
        $this->db->delete($tables);
        return true;
    }
    public function update_payment_method($pay_data, $content_id)
    {
        $this->db->where('content_id', $content_id);
        $res = $this->db->update('emp_payment_method', $pay_data);
        return $res;
    }
}
