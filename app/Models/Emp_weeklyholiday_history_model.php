<?php

class Emp_weeklyholiday_history_model extends CI_Model {

    public function getemp_weeklyholiday_history($content_id, $emp_job_change_date, $sat_off, $sun_off, $mon_off, $tue_off, $wed_off, $thus_off, $fri_off) {
    	if($content_id && $emp_job_change_date){
            $empatt_start_date_arr=explode("-",$emp_job_change_date);
            $emp_att_start_date=$empatt_start_date_arr[2]."-".$empatt_start_date_arr[1]."-".$empatt_start_date_arr[0];
 			return $this->db->query("select * from emp_weeklyholiday_history WHERE content_id='$content_id' and str_to_date(start_date, '%d-%m-%Y') <='$emp_att_start_date' and sat_off='$sat_off' AND sun_off='$sun_off' AND mon_off='$mon_off' AND tue_off='$tue_off' AND wed_off='$wed_off' AND thus_off='$thus_off' AND fri_off='$fri_off' and end_date='' order by id DESC")->row_array();
    	}
    }
    public function getemp_last_weeklyholiday_history($content_id) {
    	if($content_id){
 			return $this->db->query("select * from emp_weeklyholiday_history WHERE content_id='$content_id' order by id DESC")->row_array();
    	}
    }    
	public function updemp_weeklyholiday_historytbl($data = array(), $where = array()) {
		if($data && $where){
			$this->db->where($where);
			$this->db->update('emp_weeklyholiday_history', $data);
			return true;
		}
	}
	public function update_emp_working_holiday_history($data = array(), $where = array()) {
		if($data && $where){
			$this->db->where($where);
			$this->db->update('emp_weeklyholiday_history', $data);
			return true;
		}
	}   
    public function getemp_weeklyholiday_historybydate($content_id, $emp_atten_date) {
        if($content_id && $emp_atten_date){
            $empatt_start_date_arr=explode("-",$emp_atten_date);
            $emp_att_start_date=$empatt_start_date_arr[2]."-".$empatt_start_date_arr[1]."-".$empatt_start_date_arr[0];
            return $this->db->query("select * from emp_weeklyholiday_history WHERE content_id='$content_id' and str_to_date(start_date, '%d-%m-%Y') <='$emp_att_start_date' order by id DESC LIMIT 1")->row_array();
        }
    }












    public function getemp_weekly_holiday_history_by_date($content_id,$start_date,$end_date){
        //echo $start_date;
        //exit();
        $this->db->select('*')->from('emp_weeklyholiday_history');
        $this->db->WHERE('content_id',$content_id);
       // $this->db->WHERE('start_date >=',$start_date);
        $this->db->WHERE('end_date <=',$end_date);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    } 


















         
}

?>