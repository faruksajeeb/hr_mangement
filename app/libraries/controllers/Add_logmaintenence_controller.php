<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_logmaintenence_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    function add_logmaintenence_action($post_data=array(), $log_start_date){
        //$ci=& get_instance();
        $this->CI->load->database(); 
        $msg = "";
        $emp_code=$post_data['emp_name']; 
        $emp_company=$post_data['emp_company'];
        $empDivision=$post_data['emp_division'];
        $emp_attendance_start_date=$post_data['emp_attendance_start_date'];
        $emp_attendance_end_date=$post_data['emp_attendance_end_date'];
        $weekly_holiday=$post_data['weekly_holiday'];
        $late_status=$post_data['late_status'];
        $emp_late_count_time=$post_data['emp_late_count_time'];
        $half_day_absent_status=$post_data['half_day_absent_status'];
        $half_day_absent_count_time=$post_data['half_day_absent_count_time'];
        $early_status=$post_data['early_status'];
        $early_count_time=$post_data['early_count_time'];        
        $entryCompanyWise=$post_data['entry_company_wise'];
        $entryDivisionWise=$post_data['entry_division_wise'];
        $entryEmployeeWise=$post_data['entry_emp_wise'];
        $presence_status=$post_data['presence_status'];
        $remarks=$post_data['remarks'];
        $employee_id = $this->CI->employee_id_model->getemp_idby_empcode($emp_code);
            if($late_status=='Late_Not_Count'){
                $emp_late_count_time="";
            }
            if($early_status=='Early_Not_Count'){
                $early_count_time="";
            }            
            if($half_day_absent_status=='Half_Day_Absent_Not_Count'){
                $half_day_absent_count_time="";
            }                
            if($entryCompanyWise){
                $emp_code="";
                foreach ($emp_company as $singleCompany) {
                    $empContentId = NULL;
                    $empDivisionId = NULL;
                    $empCompanyId=$singleCompany;
                    $entryType='entry_company_wise'; 
                    $hasLogAttendance = $this->CI->log_maintenence_model->getLogByCompany($empCompanyId, $log_start_date);
                    if($hasLogAttendance){
                        $this->updateLogMaintenance($entryType,$empCompanyId,$empDivisionId, $empContentId, $log_start_date,$weekly_holiday, $late_status, $emp_late_count_time, $early_status, $early_count_time, $half_day_absent_status, $half_day_absent_count_time,  $presence_status, $remarks);
                    }else{
                        $this->insertLogMaintenance($empCompanyId, $empDivisionId, $empContentId, $log_start_date,$weekly_holiday, $late_status, $emp_late_count_time, $early_status, $early_count_time, $half_day_absent_status, $half_day_absent_count_time, $presence_status,  $remarks);
                    }                     
                }
            }else if($entryDivisionWise){
                    $entryType='entry_division_wise';
                    $empDivisionId = $empDivision;
                    $empContentId = NULL;
                    $empCompanyId = $post_data['company'];
                    $hasLogAttendance = $this->CI->log_maintenence_model->getLogByDivisionId($empDivisionId, $log_start_date);
                    if($hasLogAttendance){
                        $this->updateLogMaintenance($entryType,$empCompanyId,$empDivisionId, $empContentId, $log_start_date,$weekly_holiday, $late_status, $emp_late_count_time, $early_status, $early_count_time, $half_day_absent_status, $half_day_absent_count_time,  $presence_status, $remarks);
                    }else{
                        $this->insertLogMaintenance($empCompanyId,$empDivisionId, $empContentId, $log_start_date,$weekly_holiday, $late_status, $emp_late_count_time, $early_status, $early_count_time, $half_day_absent_status, $half_day_absent_count_time, $presence_status,  $remarks);
                    }
            }else if($entryEmployeeWise){
                $empContentId = $employee_id;
                $getEmpInfo = $this->CI->db->query("SELECT * FROM search_field_emp WHERE content_id=$empContentId")->row();
                $empCompanyId = $getEmpInfo->emp_division;
                $empDivisionId = $getEmpInfo->emp_department;
                $entryType='entry_emp_wise';
                $hasLogAttendance = $this->CI->log_maintenence_model->getlogbyemployee($empContentId, $log_start_date);
                if($hasLogAttendance){
                    $this->updateLogMaintenance($entryType,$empCompanyId, $empDivisionId, $empContentId, $log_start_date,$weekly_holiday, $late_status, $emp_late_count_time, $early_status, $early_count_time, $half_day_absent_status, $half_day_absent_count_time,  $presence_status, $remarks);
                }else{
                    $this->insertLogMaintenance($empCompanyId,$empDivisionId, $empContentId, $log_start_date,$weekly_holiday, $late_status, $emp_late_count_time, $early_status, $early_count_time, $half_day_absent_status, $half_day_absent_count_time, $presence_status, $remarks);
                }            
            }             

    }
    function insertLogMaintenance($empCompanyId,$empDivisionId, $empContentId, $log_start_date,$weekly_holiday, $late_status, $emp_late_count_time, $early_status, $early_count_time, $half_day_absent_status, $half_day_absent_count_time, $presence_status, $remarks){
        $this->CI->load->database(); 
        $params = array(
            // 'id'                         => '',
            'company_id'                =>  $empCompanyId,
            'division_id'               =>  $empDivisionId,
            'content_id'                 =>  $empContentId,
            'start_date'                 =>  $log_start_date,
            'end_date'                   =>  $log_start_date,
            'weekly_holiday'             =>  $weekly_holiday,
            'late_status'                =>  $late_status,
            'late_count_time'            =>  $emp_late_count_time,
            'half_day_absent_status'     =>  $half_day_absent_status,
            'half_day_absent_count_time' =>  $half_day_absent_count_time,
            'early_status'               =>  $early_status,
            'early_count_time'           =>  $early_count_time,
            'present_status'             =>  $presence_status,    // who has no log         
            'reason'                     =>  $remarks,
            'created_at'               =>  getCurrentDateTime(),
            'created_by'                 =>  $this->CI->session->userdata('user_id'),
            'reserve1'                   =>  "",
            'reserve2'                   =>  ""
            );
        $this->CI->db->insert("log_maintenence",$params);
        $insert_id = $this->CI->db->insert_id();
        $this->CI->session->set_flashdata('success', "Data Inserted");
}

function updateLogMaintenance($entryType, $empCompanyId,$empDivisionId, $empContentId, $log_start_date,$weekly_holiday, $late_status, $emp_late_count_time, $early_status, $early_count_time, $half_day_absent_status, $half_day_absent_count_time,  $presence_status, $remarks){
    $this->CI->load->database(); 
    $params = array(
        'company_id'                =>  $empCompanyId,
        'division_id'               =>  $empDivisionId,
        'content_id'                 =>  $empContentId,
        'start_date'                 =>  $log_start_date,
        'end_date'                   =>  $log_start_date,
        'weekly_holiday'             =>  $weekly_holiday,
        'late_status'                =>  $late_status,
        'late_count_time'            =>  $emp_late_count_time,
        'half_day_absent_status'     =>  $half_day_absent_status,
        'half_day_absent_count_time' =>  $half_day_absent_count_time,
        'early_status'               =>  $early_status,
        'early_count_time'           =>  $early_count_time,        
        'present_status'             =>  $presence_status,        
        'reason'                     =>  $remarks,
        'updated_at'               =>  getCurrentDateTime(),
        'updated_by'                 =>  $this->CI->session->userdata('user_id')
        );   
    //$params=array_filter($params,'strlen');  
    if($entryType=='entry_company_wise'){
        $update_condition=array('company_id' => $empCompanyId, 'start_date' => $log_start_date);
    }else if($entryType=='entry_division_wise'){
        $update_condition=array('division_id' => $empDivisionId, 'start_date' => $log_start_date);
    }else if($entryType=='entry_emp_wise'){
        $update_condition=array('content_id' => $empContentId, 'start_date' => $log_start_date);
    }              
    $this->CI->log_maintenence_model->updlog_maintenencetbl($params, $update_condition);
    $this->CI->session->set_flashdata('success', "Data Updated");
}
}

?>