<?php

class Emp_attendance_model extends CI_Model {

    public function getemp_dailyattendance($content_id, $attendance_date) {
    	if($content_id && $attendance_date){
            if(strtotime($attendance_date)>strtotime('30-11-2018')){
 			    return $this->db->query("select * from emp_attendance WHERE content_id='$content_id' and attendance_date='$attendance_date' order by id DESC")->row_array();
            }else{
                return $this->db->query("select * from emp_attendance_old WHERE content_id='$content_id' and attendance_date='$attendance_date' order by id DESC")->row_array();
            }
        }
    }
    public function getemp_attbyrange($content_id, $emp_att_start_date, $emp_att_end_date) {
    	if($content_id && $emp_att_start_date && $emp_att_end_date){
            $empatt_start_date_arr=explode("-",$emp_att_start_date);
            $emp_att_end_date_arr=explode("-",$emp_att_end_date);
            $emp_att_start_date=$empatt_start_date_arr[2]."-".$empatt_start_date_arr[1]."-".$empatt_start_date_arr[0];
            $emp_att_end_date=$emp_att_end_date_arr[2]."-".$emp_att_end_date_arr[1]."-".$emp_att_end_date_arr[0];
            return $this->db->query("SELECT * FROM `emp_attendance` WHERE str_to_date(attendance_date, '%d-%m-%Y')>='$emp_att_start_date'  and str_to_date(attendance_date, '%d-%m-%Y')<='$emp_att_end_date' AND content_id='$content_id' ")->result_array();
    	}
    }
	public function updemp_attendancetbl($data = array(), $where = array()) {
		if($data && $where){
			$this->db->where($where);                        
            if(strtotime($where['attendance_date'])>strtotime('30-11-2018')){
                $this->db->update('emp_attendance', $data);
            }else{
                $this->db->update('emp_attendance_old', $data);
            }
			return true;
		}
	}     
    public function getemp_attendance_log() {
          date_default_timezone_set('Asia/Dhaka');
            $servertime = time();
          $today_date = date("d-m-Y", $servertime);   
          $emp_att_end_date_arr=explode("-",$today_date);
            $emp_att_end_date=$emp_att_end_date_arr[2]."-".$emp_att_end_date_arr[1]."-".$emp_att_end_date_arr[0];
            return $this->db->query("SELECT * FROM `emp_attendance` WHERE str_to_date(attendance_date, '%d-%m-%Y')<='$emp_att_end_date' ORDER BY str_to_date(attendance_date, '%d-%m-%Y') DESC LIMIT 1")->row_array();
    }         
    public function getemp_attendance_greaterthenlogout() {
            return $this->db->query("SELECT * FROM `emp_attendance` WHERE `login_time`>`logout_time` ORDER BY str_to_date(attendance_date, '%d-%m-%Y') DESC")->result_array();
    }  
    public function getallattendancedate($content_id, $emp_att_start_date, $emp_att_end_date){
       if($content_id && $emp_att_start_date && $emp_att_end_date){
        $empatt_start_date_arr=explode("-",$emp_att_start_date);
            $emp_att_end_date_arr=explode("-",$emp_att_end_date);
            $emp_att_start_date=$empatt_start_date_arr[2]."-".$empatt_start_date_arr[1]."-".$empatt_start_date_arr[0];
            $emp_att_end_date=$emp_att_end_date_arr[2]."-".$emp_att_end_date_arr[1]."-".$emp_att_end_date_arr[0];
            $this->db->simple_query('SET SESSION group_concat_max_len=100000000');
           return $this->db->query("SELECT GROUP_CONCAT(attendance_date) as att_dates FROM `emp_attendance` WHERE str_to_date(attendance_date, '%d-%m-%Y')>='$emp_att_start_date'  and str_to_date(attendance_date, '%d-%m-%Y')<='$emp_att_end_date' AND content_id='$content_id' ")->row_array();
        } 
    }        
}

?>