<?php

class Emp_job_history_model extends CI_Model
{

    public function getemp_job_history($content_id, $emp_job_change_date, $emp_company, $emp_division, $emp_department, $emp_position, $emp_grade, $emp_type)
    {
        if ($content_id && $emp_job_change_date) {
            $empatt_start_date_arr = explode("-", $emp_job_change_date);
            $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
            return $this->db->query("select * from emp_job_history WHERE content_id='$content_id' and "
                . "str_to_date(start_date, '%d-%m-%Y') <='$emp_att_start_date' and "
                . "division_tid='$emp_company' and "
                . "department_tid='$emp_division'  and "
                . "department_id=$emp_department  and "
                . "post_tid='$emp_position' and "
                . "grade_tid='$emp_grade' and "
                . "emp_type_tid='$emp_type' and "
                . "end_date='' "
                . "order by id DESC LIMIT 1")->row_array();
        }
    }
    public function getemp_last_job_history($content_id)
    {
        if ($content_id) {
            return $this->db->query("select * from emp_job_history WHERE content_id='$content_id' order by id DESC LIMIT 1")->row_array();
        }
    }

    public function getalljobhistorybyasc($content_id)
    {
        if ($content_id) {
            return $this->db->query("select * from emp_job_history WHERE content_id=$content_id order by id ASC")->result_array();
        }
    }
    public function updemp_job_historytbl($data = array(), $where = array())
    {

        if ($data && $where) {
            $this->db->where($where);
            $this->db->update('emp_job_history', $data);
            return true;
        }
    }
    public function updemp_job_starting_date($emp_joining_date, $content_id, $jobStartId)
    {

        if ($emp_joining_date && $content_id && $jobStartId) {
            $this->db->query("UPDATE emp_job_history SET start_date='$emp_joining_date' WHERE content_id=$content_id AND id=$jobStartId");
        }
    }
    public function getemp_first_job_history($content_id)
    {
        if ($content_id) {
            return $this->db->query("select * from emp_job_history WHERE content_id='$content_id' order by id ASC LIMIT 1")->row_array();
        }
    }
    function updateJobHistoryById($editId, $data)
    {

        $this->db->where('id', $editId);
        $this->db->update('emp_job_history', $data);
        return true;
    }

    public function deleteJobHistoryById($id)
    {
        if ($id) {
            $this->db->where('id', $id);
            return $this->db->delete('emp_job_history');
            //return $this->db->query("DELETE FROM emp_job_history WHERE id=$id");
        }
    }
    function getJobHistoryById($id)
    {
        return $this->db->query("SELECT content_id FROM emp_job_history WHERE id=$id")->row();
    }
}
