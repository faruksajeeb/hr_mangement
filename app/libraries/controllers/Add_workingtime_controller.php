<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_workingtime_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function add_workingtime_action($post_data=array(), $toadd_id){
        //$ci=& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('emp_working_time_model');
        $content_exist=$this->CI->emp_working_time_model->getcontentByid($toadd_id);
        $params_contents = array(
            'id'                    => '',
            'content_id'            =>  $toadd_id,
            'work_starting_time'    =>  $post_data['emp_working_time_from'],                             
            'work_ending_time'      =>  $post_data['emp_working_end_time'],
            'attendance_required'   =>  $post_data['attendance_required'],
            'logout_required'       =>  $post_data['logout_required'],
            'emp_latecount_time'    =>  $post_data['emp_latecount_time'],
            'emp_earlycount_time'   =>  $post_data['emp_earlycount_time'],
            'half_day_absent'       =>  $post_data['half_day_absent'],
            'absent_count_time'     =>  $post_data['absent_count_time'],
            'overtime_count'        =>  $post_data['overtime_count'],
            'overtime_hourly_rate'  =>  $post_data['overtime_hourly_rate'],
            'created'               =>  getCurrentDateTime(),
            'updated'               =>  getCurrentDateTime(),
            'updated_by'            =>  $this->CI->session->userdata('user_id'),
            );        
        if($content_exist){
            $params_toupdate_contents = array(
                'work_starting_time'    =>  $post_data['emp_working_time_from'],                             
                'work_ending_time'      =>  $post_data['emp_working_end_time'],
                'attendance_required'   =>  $post_data['attendance_required'],
                'logout_required'       =>  $post_data['logout_required'],
                'emp_latecount_time'    =>  $post_data['emp_latecount_time'],
                'emp_earlycount_time'   =>  $post_data['emp_earlycount_time'], 
                'half_day_absent'       =>  $post_data['half_day_absent'],
                'absent_count_time'     =>  $post_data['absent_count_time'],
                'overtime_count'        =>  $post_data['overtime_count'],
                'overtime_hourly_rate'  =>  $post_data['overtime_hourly_rate'],                               
                'updated'               =>  getCurrentDateTime(),
                'updated_by'            =>  $this->CI->session->userdata('user_id'),
                );            
            $update_conditions=array('content_id' => $toadd_id);
            $this->CI->emp_working_time_model->updemp_working_timetbl($params_toupdate_contents, $update_conditions);
        }else{           
            $this->CI->db->insert("emp_working_time",$params_contents);
        }

    }


}

?>