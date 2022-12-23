<?php

class Emp_holiday_model extends CI_Model {

    public function getemp_holiday($content_id) {
    	if($content_id){
 			return $this->db->query("select * from emp_weeklyholiday WHERE content_id=$content_id order by id DESC")->row_array();
    	}
    }

	public function updemp_holidaytbl($data = array(), $where = array()) {
		if($data && $where){
			$this->db->where($where);
			$this->db->update('emp_weeklyholiday', $data);
			return true;
		}
	}  
    function cancelHoliday($emp_division_tid,$emp_department_tid,$holiday_date) {
        $tables = array('emp_yearlyholiday');
        $where = array('holiday_for_division'=>$emp_division_tid,'holiday_for_department'=>$emp_department_tid, 'holiday_start_date'=>$holiday_date);
        $this->db->where($where);
        $this->db->delete($tables);
        return true;
    }	
    public function getemp_yearlyholiday($emp_division_tid, $holiday_date) {
    	if($emp_division_tid && $holiday_date){
 			return $this->db->query("select * from emp_yearlyholiday WHERE holiday_for_division='$emp_division_tid' and holiday_start_date='$holiday_date' order by id DESC")->row_array();
    	}
    }   
    public function getemp_yearlytotalholiday($emp_division_tid, $holiday_year) {
        if($emp_division_tid && $holiday_year){
            return $this->db->query("select * from emp_yearlyholiday WHERE holiday_for_division='$emp_division_tid' and holiday_year='$holiday_year' order by str_to_date(holiday_start_date, '%d-%m-%Y') ASC")->result_array();
        }
    }   
    public function getemp_yearlyallholiday($holiday_year) {
        if($holiday_year){
            return $this->db->query("select * from emp_yearlyholiday WHERE holiday_year='$holiday_year' order by str_to_date(holiday_start_date, '%d-%m-%Y') ASC")->result_array();
        }
    }   
	public function updemp_yearlyholidaytbl($data = array(), $where = array()) {
		if($data && $where){
			$this->db->where($where);
			$this->db->update('emp_yearlyholiday', $data);
			return true;
		}
	} 

    public function getallholidaydate($emp_division_tid, $emp_att_start_date, $emp_att_end_date){
       if($emp_division_tid && $emp_att_start_date && $emp_att_end_date){
            $empatt_start_date_arr=explode("-",$emp_att_start_date);
            $emp_att_end_date_arr=explode("-",$emp_att_end_date);
            $emp_att_start_date=$empatt_start_date_arr[2]."-".$empatt_start_date_arr[1]."-".$empatt_start_date_arr[0];
            $emp_att_end_date=$emp_att_end_date_arr[2]."-".$emp_att_end_date_arr[1]."-".$emp_att_end_date_arr[0];
            $this->db->simple_query('SET SESSION group_concat_max_len=100000000');
            return $this->db->query("SELECT GROUP_CONCAT(holiday_start_date) as holiday_dates FROM `emp_yearlyholiday` WHERE str_to_date(holiday_start_date, '%d-%m-%Y')>='$emp_att_start_date'  and str_to_date(holiday_start_date, '%d-%m-%Y')<='$emp_att_end_date' AND (holiday_for_division='$emp_division_tid' OR holiday_for_division='all') order by id DESC")->row_array();
        } 
    }              
}

?>