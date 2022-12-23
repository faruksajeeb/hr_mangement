<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_carrequisition_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function add_carrequisition_action($post_data=array()){
        //$ci=& get_instance();
        $this->CI->load->database();
        $msg = "";
        $requisition_id=$post_data['id']; 
        $emp_code=$post_data['emp_name']; 
        $requester_content_id = $this->CI->employee_id_model->getemp_idby_empcode($emp_code);
        $Requisition_Date=$post_data['Requisition_Date']; 
        $Requisition_Time=$post_data['Requisition_Time']; 
        $purpose=$post_data['purpose']; 
        $Requisition_Location=$post_data['Requisition_Location']; 
        $Location_Distance=$post_data['Location_Distance']; 
        $Car_content_id=$post_data['Car_Name']; 
        $driver_content_id=$post_data['driver_content_id']; 
        $Requisition_Status=$post_data['Requisition_Status']; 
        $remarks=$post_data['remarks'];
        if($requisition_id){
            $params = array(
                'requester_content_id'  =>$requester_content_id,
                'Requisition_Date'      =>$Requisition_Date,
                'Requisition_Time'      =>$Requisition_Time,
                'purpose'               =>$purpose,
                'Requisition_Location'  =>$Requisition_Location,
                'Location_Distance'     =>$Location_Distance,
                'Car_Code'              =>$Car_content_id,
                'driver_content_id'     =>$driver_content_id,
                'notes'                 =>$remarks,
                'status'                =>$Requisition_Status,
                'updated_by'            =>$this->CI->session->userdata('user_id'),
                'updated_time'          =>getCurrentDateTime()
                );
            $update_condition=array('id' => $requisition_id);
            $tblname="car_requisition";
            $this->CI->car_info_model->updanytbl($params, $update_condition, $tblname);
             $this->CI->session->set_userdata("success", "Data updated"); 
        }else{
            $params = array(
                'id'                    =>"",
                'requester_content_id'  =>$requester_content_id,
                'Requisition_Date'      =>$Requisition_Date,
                'Requisition_Time'      =>$Requisition_Time,
                'purpose'               =>$purpose,
                'Requisition_Location'  =>$Requisition_Location,
                'Location_Distance'     =>$Location_Distance,
                'Car_Code'              =>$Car_content_id,
                'driver_content_id'     =>$driver_content_id,
                'notes'                 =>$remarks,
                'status'                =>$Requisition_Status,
                'created_by'            =>$this->CI->session->userdata('user_id'),
                'created_time'          =>getCurrentDateTime(),
                'updated_by'            =>$this->CI->session->userdata('user_id'),
                'updated_time'          =>getCurrentDateTime(),
                'reserved'              =>""               
                );
            $this->CI->db->insert("car_requisition",$params);
            $insert_id = $this->CI->db->insert_id();
            $this->CI->session->set_userdata("success", "Data inserted");      
        }
        $data['error']="";
        $data['msg']=$msg;

    }


}

?>