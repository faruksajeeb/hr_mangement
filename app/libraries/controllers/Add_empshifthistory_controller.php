<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_empshifthistory_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function add_empshifthistory_action($post_data=array(), $content_id){  
        //$ci=& get_instance();
        $this->CI->load->database();
        $emp_working_time_from=$post_data['emp_working_time_from'];
        $emp_working_end_time=$post_data['emp_working_end_time'];
        $attendance_required=$post_data['attendance_required'];
        $logout_required=$post_data['logout_required'];
        $emp_latecount_time=$post_data['emp_latecount_time'];
        $emp_earlycount_time=$post_data['emp_earlycount_time'];
        $half_day_absent=$post_data['half_day_absent'];
        $absent_count_time=$post_data['absent_count_time'];
        $overtime_count=$post_data['overtime_count'];
        $overtime_hourly_rate=$post_data['overtime_hourly_rate'];
        $emp_job_change_date=$post_data['emp_job_change_date'];
        if(!$emp_job_change_date){
        $emp_job_change_date=$post_data['emp_starting_date'];
        }
        $has_history = $this->CI->emp_shift_history_model->getemp_shift_history($content_id, $emp_job_change_date, $emp_working_time_from, $emp_working_end_time, $attendance_required, $logout_required, $emp_latecount_time, $emp_earlycount_time, $half_day_absent, $absent_count_time, $overtime_count, $overtime_hourly_rate);
        $has_last_history = $this->CI->emp_shift_history_model->getemp_last_shift_history($content_id);
        if(!$has_history){
            if($has_last_history){
                // echo "<pre>";
                // print_r($has_last_history);
                // echo "</pre>";
                // die();
                $previous_id=$has_last_history['id'];
                $previous_start_date=$has_last_history['start_date'];
                $last_end_date=date('d-m-Y',(strtotime ( '-1 day' , strtotime ( $emp_job_change_date) ) ));
                $d1 = explode('-', $previous_start_date);
                $d2 = explode('-', $last_end_date);
                $d1 = array_reverse($d1);
                $d2 = array_reverse($d2);

                if (strtotime(implode('-', $d2)) > strtotime(implode('-', $d1)))
                {              
                $params = array(
                'end_date'        =>  $last_end_date,
                'updated_time'    =>  getCurrentDateTime(),
                'updated_by'      =>  $this->CI->session->userdata('user_id'),
                );  
                $update_condition=array('id' => $previous_id);
                $this->CI->emp_shift_history_model->updemp_shift_historytbl($params, $update_condition);
                $this->CI->session->set_userdata("success", "Data Updated!");
                // insert new history
                $this->insertemphistory($content_id, $emp_job_change_date, $emp_working_time_from, $emp_working_end_time, $attendance_required, $logout_required, $emp_latecount_time, $emp_earlycount_time, $half_day_absent, $absent_count_time, $overtime_count, $overtime_hourly_rate); 
                }else{
                    $this->updateemphistory($content_id, $emp_job_change_date, $emp_working_time_from, $emp_working_end_time, $attendance_required, $logout_required, $emp_latecount_time, $emp_earlycount_time, $half_day_absent, $absent_count_time, $overtime_count, $overtime_hourly_rate, $previous_id);
                }               
            }else{
                $this->insertemphistory($content_id, $emp_job_change_date, $emp_working_time_from, $emp_working_end_time, $attendance_required, $logout_required, $emp_latecount_time, $emp_earlycount_time, $half_day_absent, $absent_count_time, $overtime_count, $overtime_hourly_rate);
            }
        }

    }

    function insertemphistory($content_id, $emp_job_change_date, $emp_working_time_from, $emp_working_end_time, $attendance_required, $logout_required, $emp_latecount_time, $emp_earlycount_time, $half_day_absent, $absent_count_time, $overtime_count, $overtime_hourly_rate){
        $this->CI->load->database();
        $params = array(
            'id'                    => '',
            'content_id'            =>  $content_id,
            'start_date'            =>  $emp_job_change_date,
            'end_date'              =>  "",
            'work_starting_time'    =>  $emp_working_time_from,
            'work_ending_time'      =>  $emp_working_end_time,
            'attendance_required'   =>  $attendance_required,
            'logout_required'       =>  $logout_required,
            'emp_latecount_time'    =>  $emp_latecount_time,
            'emp_earlycount_time'   =>  $emp_earlycount_time,
            'half_day_absent'       =>  $half_day_absent,
            'absent_count_time'     =>  $absent_count_time,
            'overtime_count'        =>  $overtime_count,
            'overtime_hourly_rate'  =>  $overtime_hourly_rate,
            'created_time'          =>  getCurrentDateTime(),
            'created_by'            =>  $this->CI->session->userdata('user_id'),
            'updated_time'          =>  getCurrentDateTime(),
            'updated_by'            =>  $this->CI->session->userdata('user_id'),
            'reserved1'             =>  "",
            'reserved2'             =>  "",
            );
        $this->CI->db->insert("emp_shift_history",$params);
        $insert_id = $this->CI->db->insert_id();
        $this->CI->session->set_userdata("success", "Data Inserted!");
        $msg = "Data inserted";      
    }
    function updateemphistory($content_id, $emp_job_change_date, $emp_working_time_from, $emp_working_end_time, $attendance_required, $logout_required, $emp_latecount_time, $emp_earlycount_time, $half_day_absent, $absent_count_time, $overtime_count, $overtime_hourly_rate, $previous_id){
        $this->CI->load->database();
        $params = array(
            'content_id'            =>  $content_id,
            'start_date'            =>  $emp_job_change_date,
            'work_starting_time'    =>  $emp_working_time_from,
            'work_ending_time'      =>  $emp_working_end_time,
            'attendance_required'   =>  $attendance_required,
            'logout_required'       =>  $logout_required,
            'emp_latecount_time'    =>  $emp_latecount_time,
            'emp_earlycount_time'   =>  $emp_earlycount_time,
            'half_day_absent'       =>  $half_day_absent,
            'absent_count_time'     =>  $absent_count_time,
            'overtime_count'        =>  $overtime_count,
            'overtime_hourly_rate'  =>  $overtime_hourly_rate,
            'updated_time'          =>  getCurrentDateTime(),
            'updated_by'            =>  $this->CI->session->userdata('user_id'),
            );
        $update_condition=array('id' => $previous_id);
        $this->CI->emp_shift_history_model->updemp_shift_historytbl($params, $update_condition);
        $this->CI->session->set_userdata("success", "Data Updated!");
        $msg = "Data Updated";      
    }

}

?>