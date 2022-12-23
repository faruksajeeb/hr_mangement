<?php

class Log_maintenence_model extends CI_Model
{

    public function getlogbyemployee($content_id, $attendance_date)
    {
        if ($content_id && $attendance_date) {
            return $this->db->query("select * from log_maintenence WHERE content_id='$content_id' and start_date='$attendance_date' order by id DESC")->row_array();
        }
    }
    public function getlogbydivision($division_id, $attendance_date)
    {
        if ($division_id && $attendance_date) {
            return $this->db->query("select * from log_maintenence WHERE division_id='$division_id' and start_date='$attendance_date' order by id DESC")->row_array();
        }
    }
    public function getLogByCompany($companyId, $attendanceDate)
    {
        if ($companyId && $attendanceDate) {
            return $this->db->query("SELECT * FROM log_maintenence WHERE division_id='$companyId' AND start_date='$attendanceDate' ORDER BY id DESC")->row_array();
        }
    }
    public function getLogByDivisionId($divisionId, $attendanceDate)
    {
        if ($divisionId && $attendanceDate) {
            return $this->db->query("SELECT * FROM log_maintenence WHERE division_id=$divisionId AND start_date='$attendanceDate' ORDER BY id DESC")->row_array();
        }
    }
    public function updlog_maintenencetbl($data = array(), $where = array())
    {
        if ($data && $where) {
            $this->db->where($where);
            $this->db->update('log_maintenence', $data);
            return true;
        }
    }
    public function getemp_logedbyrange($emp_att_start_date, $emp_att_end_date)
    {
        $empatt_start_date_arr = explode("-", $emp_att_start_date);
        $emp_att_end_date_arr = explode("-", $emp_att_end_date);
        $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
        $emp_att_end_date = $emp_att_end_date_arr[2] . "-" . $emp_att_end_date_arr[1] . "-" . $emp_att_end_date_arr[0];
        return $this->db->query("SELECT * FROM `log_maintenence` WHERE str_to_date(start_date, '%d-%m-%Y')>='$emp_att_start_date'  and str_to_date(start_date, '%d-%m-%Y')<='$emp_att_end_date' ORDER BY str_to_date(start_date, '%d-%m-%Y') DESC ")->result_array();
    }
    function deleteLoged($id)
    {
        $tables = array('log_maintenence');
        $this->db->where('id', $id);
        $this->db->delete($tables);
        return true;
    }
}
