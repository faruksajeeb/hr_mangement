<?php

if (!defined('BASEPATH')) 
    exit('No direct script access allowed');

class Add_empperformance_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function create_performance_action($post_data=array()){
        $this->CI->load->database();
        $msg = "";
        $performance_id=$post_data['performance_id'];
        $Performance_Title=$post_data['Performance_Title'];
        $Evaluation_Period_From=$post_data['Evaluation_Period_From'];
        $Evaluation_Period_Till=$post_data['Evaluation_Period_Till'];
        $Last_Date_of_Submission=$post_data['Last_Date_of_Submission'];
        $performance_status=$post_data['performance_status'];
        $description=$post_data['description'];
        if($performance_id){
            $params = array(
                'Performance_Title'          =>  $Performance_Title,
                'appraisal_period_from'      =>  $Evaluation_Period_From,
                'appraisal_period_to'        =>  $Evaluation_Period_Till,
                'Last_Date_Submission'       =>  $Last_Date_of_Submission,
                'Status'                     =>  $performance_status,
                'Remarks'                    =>  $description,
                'updated_time'               =>  getCurrentDateTime(),
                'updated_by'                 =>  $this->CI->session->userdata('user_id'),
                );
            $update_condition=array('id' => $performance_id);
            $this->CI->emp_performance_model->updEmp_performance_idtbl($params, $update_condition);
            $performance_id = $performance_id;
            $msg = "Data updated";
        }else{
            $params = array(
                'id'                         => '',
                'Performance_Title'          =>  $Performance_Title,
                'appraisal_period_from'      =>  $Evaluation_Period_From,
                'appraisal_period_to'        =>  $Evaluation_Period_Till,
                'Last_Date_Submission'       =>  $Last_Date_of_Submission,
                'Status'                     =>  $performance_status,
                'Remarks'                    =>  $description,
                'created_time'               =>  getCurrentDateTime(),
                'updated_time'               =>  "",
                'created_by'                 =>  $this->CI->session->userdata('user_id'),
                'updated_by'                 =>  "",
                );
            $this->CI->db->insert("emp_performance_id",$params);
            $performance_id = $this->CI->db->insert_id();
            $msg = "Data inserted";         
        }
        $data['error']="";
        $data['msg']=$msg;
    }
    function add_performance_action($post_data=array()){
        //$ci=& get_instance();
        $this->CI->load->database();
        $msg = "";
        $emp_content_id=$post_data['emp_content_id'];
        $performance_content_id=$post_data['performance_content_id'];
        $appraisal_period_from=$post_data['appraisal_period_from'];
        $appraisal_period_to=$post_data['appraisal_period_to'];
        $emp_id=$post_data['emp_id'];
        $emp_designation=$post_data['emp_designation'];
        $emp_department=$post_data['emp_department'];
        $emp_appraiser_code=$post_data['emp_appraiser_user_id'];
        $emp_appraiser_designation=$post_data['emp_appraiser_designation'];
        $emp_appraiser_department=$post_data['emp_appraiser_department'];
        $emp_rating=$post_data['rating'];
        $employee_id = $this->CI->employee_id_model->getemp_idby_empcode($emp_id);
        $appraiser_employee_id = $this->CI->employee_id_model->getemp_idby_empcode($emp_appraiser_code);
        // if($performance_content_id){
        //     $params = array(
        //         'appraisal_period_from'      =>  $appraisal_period_from,
        //         'appraisal_period_to'        =>  $appraisal_period_to,
        //         'emp_appraiser_name'         =>  $appraiser_employee_id,             
        //         'updated_time'               =>  getCurrentDateTime(),
        //         'updated_by'                 =>  $this->CI->session->userdata('user_id'),
        //         );
        //     $update_condition=array('id' => $performance_content_id);
        //     $this->CI->emp_performance_model->updEmp_performance_idtbl($params, $update_condition);
        //     $performance_id = $performance_content_id;
        //     $msg = "Data updated";
        // }else{
            $params = array(
                'id'                         => '',
                'per_main_id'                =>  $performance_content_id,
                'appraisor_usr_id'           =>  $emp_appraiser_code,
                'to_emp_id'                  =>  $employee_id,
                'created_time'               =>  getCurrentDateTime(),
            );
            $this->CI->db->insert("emp_per_submit_id",$params);
            $performance_id = $this->CI->db->insert_id();
            $msg = "Data inserted";         
        $emp_rating=array_filter($emp_rating,'strlen');   
        foreach ($emp_rating as $key => $value) {
            $this->add_performance_rating($performance_id, $key, $value);
        }
        $data['error']="";
        $data['msg']=$msg;

    }

    function add_performance_rating($performance_id, $fieldname, $fieldvalue){
        $this->CI->load->database();
        $content_exist=$this->CI->emp_performance_model->getperfomanceByidandfieldname($performance_id, $fieldname);
        if($content_exist){
            $toeditid=$content_exist['id'];
            $params = array(
                'field_name'                 =>  $fieldname,
                'field_value'                =>  $fieldvalue,
                );
            $update_condition=array('id' => $toeditid);
            $this->CI->emp_performance_model->updEmp_performance_valuetbl($params, $update_condition);
        }else{
            $params = array(
                'id'                         => '',
                'performance_id'             =>  $performance_id,
                'field_name'                 =>  $fieldname,
                'field_value'                =>  $fieldvalue,
                );
            $this->CI->db->insert("emp_performance_value",$params);       
        }
    }
}

?>