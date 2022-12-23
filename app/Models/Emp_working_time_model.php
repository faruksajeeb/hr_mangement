<?php

class Emp_working_time_model extends CI_Model {

	public function getcontentByid($content_id) {
		if($content_id){
			return $this->db->query("select * from emp_working_time WHERE content_id ='$content_id'")->row_array();
		}
	}
	public function getworkingtimeBydateandid($content_id, $att_date) {
		if($content_id && $att_date){ 
			$empatt_start_date_arr=explode("-",$att_date);
			$emp_att_start_date=$empatt_start_date_arr[2]."-".$empatt_start_date_arr[1]."-".$empatt_start_date_arr[0];
//			return $this->db->query("select * from emp_shift_history WHERE content_id ='$content_id' AND str_to_date(start_date, '%d-%m-%Y') <='$emp_att_start_date' ORDER BY ID DESC LIMIT 1")->row_array();
			return $this->db->query("select * from emp_shift_history WHERE content_id ='$content_id' AND str_to_date(start_date, '%d-%m-%Y') <='$emp_att_start_date' ORDER BY ID DESC LIMIT 1")->row_array();
		}
	}
	    public function getRamadanTimeSchedule($year) {
        return $this->db->query("SELECT * FROM tbl_ramadan_time_schedule WHERE year=$year LIMIT 1")->row_array();       
    }
	public function updemp_working_timetbl($data = array(), $where = array()) {
		if($data && $where){
			$this->db->where($where);
			$this->db->update('emp_working_time', $data);
			return true;
		}
	} 
}

?>