<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Upload_attendance_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function add_attendance_action($post_data=array()){
        //$ci=& get_instance();
        $this->CI->load->database();
        $msg = "";
        $emp_code=$post_data['emp_code']; 
        $emp_attendance_date=$post_data['attendance_date'];
        $empLogTime=$post_data['emp_log_time'];
        $employee_id = $this->CI->employee_id_model->getemp_idby_empcode($emp_code);
        $has_attendance = $this->CI->emp_attendance_model->getemp_dailyattendance($employee_id, $emp_attendance_date);
        if($has_attendance){
            if($has_attendance['logout_time'] != ""){
                // If logout time has & log time is greater than logout time then update logout time
                if(strtotime($empLogTime) > strtotime($has_attendance['logout_time']) ){
                    $params = array(
                        'logout_time'           =>  $empLogTime,              
                        'updated_time'          =>  getCurrentDateTime(),
                        'updated_by'            =>  $this->CI->session->userdata('user_id'),
                        );
                    $params=array_filter($params,'strlen');   
                    $update_condition=array('content_id' => $employee_id, 'attendance_date' => $emp_attendance_date);
                    $this->CI->emp_attendance_model->updemp_attendancetbl($params, $update_condition);
                }
            }else{
                // If logout time empty & log time is greater than login time then update logout time
                if(strtotime($empLogTime) > strtotime($has_attendance['login_time']) ){
                    $params = array(
                        'logout_time'           =>  $empLogTime,              
                        'updated_time'          =>  getCurrentDateTime(),
                        'updated_by'            =>  $this->CI->session->userdata('user_id'),
                        );
                    $params=array_filter($params,'strlen');   
                    $update_condition=array('content_id' => $employee_id, 'attendance_date' => $emp_attendance_date);
                    $this->CI->emp_attendance_model->updemp_attendancetbl($params, $update_condition);
                }
            }
        }else{
            $params = array(
                'id'                    => '',
                'content_id'            =>  $employee_id,
                'login_time'            =>  $empLogTime,
                'logout_time'           =>  "",
                'attendance_date'       =>  $emp_attendance_date,
                'total_hours_perday'    =>  "",
                'entry_type'            =>  "",
                'presence_status'       =>  "",
                'remarks'               =>  "",
                'updated_time'          =>  getCurrentDateTime(),
                'updated_by'            =>  $this->CI->session->userdata('user_id'),
                'entry_date'            =>  getCurrentDateTime(),
                'entry_user'            =>  $this->CI->session->userdata('user_id'),
                'reserved1'             =>  "",
                'reserved2'             =>  "",
                'reserved3'             =>  "",                
                );
            if(strtotime($emp_attendance_date)>strtotime('30-11-2018')){
                $this->CI->db->insert("emp_attendance",$params);
            }else{
                $this->CI->db->insert("emp_attendance_old",$params);
            }
            $insert_id = $this->CI->db->insert_id();
            $msg = "Data inserted";         
        }
        $data['error']="";
        $data['msg']=$msg;

    }


}

?>