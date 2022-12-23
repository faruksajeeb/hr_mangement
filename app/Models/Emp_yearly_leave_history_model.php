<?php

class Emp_yearly_leave_history_model extends CI_Model {

    public function getemp_yearly_leave_cat_history($content_id, $leave_tid, $start_year) {
        if($content_id && $leave_tid && $start_year){
            return $this->db->query("select * from emp_yearly_leave_cat_history WHERE content_id='$content_id' and start_year='$start_year' and leave_type='$leave_tid' order by id DESC")->row_array();
        }
       
    } 
    public function getemp_leave_total_system_history($content_id) {
        if($content_id){
            return $this->db->query("select * from emp_leave_total_system_history WHERE content_id='$content_id' order by id DESC")->row_array();
        }
    }    
    public function get_last_emp_yearly_leave_cat_history($content_id, $start_year, $leave_tid) {
        if($content_id && $leave_tid){
            return $this->db->query("select * from emp_yearly_leave_cat_history WHERE content_id='$content_id' and start_year='$start_year' and leave_type='$leave_tid' order by id DESC")->row_array();
        }
    }    
       
    public function updemp_yearly_leave_cat_history($data = array(), $where = array()) {
        if($data && $where){
           
            $this->db->where($where);
            // $this->db->update('emp_yearly_leave_cat_history', $data);
            $res = $this->db->update('emp_yearly_leave_cat_history', $data);
           
            return $res;
        }
    }  
    public function updemp_yearlytotal_leave_historytbl($data = array(), $where = array()) {
        if($data && $where){
           
            $this->db->where($where);
           
            $res = $this->db->update('emp_leave_total_system_history', $data);
            return $res;
        }
    }    
    function deleteemp_leave_total_system_history($content_id, $firstday_of_year) {
        if($content_id && $firstday_of_year){
            // $tables = array('emp_leave_total_system_history');
            // $where_con=array(
            //     'content_id'=>  $content_id,
            //     'start_year'=>  $firstday_of_year);
            // $this->db->where($where_con);
            
            // $res = $this->db->delete($tables);
            // return $res;
            $res = $this->db->query("DELETE FROM emp_leave_total_system_history 
            WHERE content_id=$content_id AND start_year=$firstday_of_year");
            return true; 
        }        
    }  
    function deleteemp_yearly_leave_history($content_id, $firstday_of_year) {
        if($content_id && $firstday_of_year){
            // $tables = array('emp_yearly_leave_cat_history');
            // $conditions=array(
            //     'content_id'=>  $content_id,
            //     'start_year'=>  $firstday_of_year
            // );
            // $this->db->where($conditions);
            // $res = $this->db->delete($tables,$conditions);
            // return $res;
            $res = $this->db->query("DELETE FROM emp_yearly_leave_cat_history 
            WHERE content_id=$content_id AND start_year=$firstday_of_year");
            return true; 
        }
    }  
    function deleteemp_leave_history_emptyvalue() {
            // $tables = array('emp_leave_total_system_history', 'emp_yearly_leave_cat_history');
            // $conditions=array(
            //     'total_days'=>  ""
            // );
            //$this->db->where($conditions);
            // $res = $this->db->delete($tables);
            $res = $this->db->query("DELETE FROM emp_leave_total_system_history WHERE total_days='' ");
            $res = $this->db->query("DELETE FROM emp_yearly_leave_cat_history WHERE total_days='' ");
            return true; 
    }  
    public function getemp_yearlyleave_historybydate($content_id, $emp_atten_date) {
        if($content_id && $emp_atten_date){
            $empatt_start_date_arr=explode("-",$emp_atten_date);
            $emp_att_start_date=$empatt_start_date_arr[2]."-".$empatt_start_date_arr[1]."-".$empatt_start_date_arr[0];
            $query = $this->db->query("select total_days from emp_leave_total_system_history WHERE content_id='$content_id' and str_to_date(start_year, '%d-%m-%Y') <='$emp_att_start_date' order by id DESC LIMIT 1");
            return $total_days = $query->row()->total_days;
        }
    }               
}

?>