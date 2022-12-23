<?php

class Emp_shift_history_model extends CI_Model {

    public function getemp_shift_history($content_id, $emp_job_change_date, $emp_working_time_from, $emp_working_end_time, $attendance_required, $logout_required, $emp_latecount_time, $emp_earlycount_time, $half_day_absent, $absent_count_time, $overtime_count, $overtime_hourly_rate) {
    	if($content_id && $emp_job_change_date){
             $empatt_start_date_arr=explode("-",$emp_job_change_date);
            $emp_att_start_date=$empatt_start_date_arr[2]."-".$empatt_start_date_arr[1]."-".$empatt_start_date_arr[0];
 			return $this->db->query("select * from emp_shift_history WHERE content_id='$content_id' and str_to_date(start_date, '%d-%m-%Y') <='$emp_att_start_date' and work_starting_time='$emp_working_time_from' AND work_ending_time='$emp_working_end_time' AND attendance_required='$attendance_required' AND logout_required='$logout_required' AND emp_latecount_time='$emp_latecount_time' AND emp_earlycount_time='$emp_earlycount_time' AND half_day_absent='$half_day_absent' AND absent_count_time='$absent_count_time' AND overtime_count='$overtime_count' AND overtime_hourly_rate='$overtime_hourly_rate' and end_date='' order by id DESC LIMIT 1")->row_array();
    	}
    }
    public function getemp_last_shift_history($content_id) {
    	if($content_id){
 			return $this->db->query("select * from emp_shift_history WHERE content_id='$content_id' order by id DESC")->row_array();
    	}
    }    
	public function updemp_shift_historytbl($data = array(), $where = array()) {
		if($data && $where){
			$this->db->where($where);
			$this->db->update('emp_shift_history', $data);
			return true;
		}
	}     
         
}

?>