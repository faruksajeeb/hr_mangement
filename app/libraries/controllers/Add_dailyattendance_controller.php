<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_dailyattendance_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function add_attendance_action($post_data=array()){
        //$ci=& get_instance();
        $this->CI->load->database();
        $msg = "";
        $emp_code=$post_data['emp_name']; 
        $emp_attendance_date=$post_data['emp_attendance_date'];
        $emp_login_time=$post_data['emp_login_time'];
        $emp_logout_time=$post_data['emp_logout_time'];
        $presence_status=$post_data['presence_status'];
        $remarks=$post_data['remarks'];
        $entry_type='manual';//automatic
        $employee_id = $this->CI->employee_id_model->getemp_idby_empcode($emp_code);
        $has_attendance = $this->CI->emp_attendance_model->getemp_dailyattendance($employee_id, $emp_attendance_date);
        if($has_attendance){
            $params = array(
                'login_time'            =>  $emp_login_time,
                'logout_time'           =>  $emp_logout_time,
                'attendance_date'       =>  $emp_attendance_date,
                'entry_type'            =>  $entry_type,
                'presence_status'       =>  $presence_status,
                'remarks'               =>  $remarks,                
                'updated_time'          =>  getCurrentDateTime(),
                'updated_by'            =>  $this->CI->session->userdata('user_id'),
                );
            $params=array_filter($params,'strlen');   
            $update_condition=array('content_id' => $employee_id, 'attendance_date' => $emp_attendance_date);
            $this->CI->emp_attendance_model->updemp_attendancetbl($params, $update_condition);
        }else{
            $params = array(
                'id'                    => '',
                'content_id'            =>  $employee_id,
                'login_time'            =>  $emp_login_time,
                'logout_time'           =>  $emp_logout_time,
                'attendance_date'       =>  $emp_attendance_date,
                'total_hours_perday'    =>  "",
                'entry_type'            =>  $entry_type,
                'presence_status'       =>  $presence_status,
                'remarks'               =>  $remarks,
                'updated_time'          =>  getCurrentDateTime(),
                'updated_by'            =>  $this->CI->session->userdata('user_id'),
                'entry_date'            =>  getCurrentDateTime(),
                'entry_user'            =>  $this->CI->session->userdata('user_id'),
                'reserved1'             =>  "",
                'reserved2'             =>  "",
                'reserved3'             =>  "",                
                );
            $this->CI->db->insert("emp_attendance",$params);
            $insert_id = $this->CI->db->insert_id();
            $msg = "Data inserted";         
        }
        $data['error']="";
        $data['msg']=$msg;

    }


}

?>