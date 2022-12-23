<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Recruitmentcontroller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function addcircularaction($post_data=array()){
       //$ci=& get_instance();
        $this->CI->load->database();
        $msg = "";
        $circular_id=$post_data['circular_id']; 
        $emp_position=$post_data['emp_position']; 
        $Start_Date=$post_data['Start_Date']; 
        $Last_Date=$post_data['Last_Date'];
        $short_description=$post_data['short_description'];
        $description=$post_data['description'];
        if($circular_id){
            $params = array(
                'position_id'       =>$emp_position,
                'Start_Date'        =>$Start_Date,
                'Last_Date'         =>$Last_Date,
                'short_description' =>$short_description,
                'description'       =>$description,
                'updated_by'        =>$this->CI->session->userdata('user_id'),
                'updated_time'      =>getCurrentDateTime() 
                );
            $update_condition=array('id' => $circular_id);
            $tblname="re_circular";
            $this->CI->re_circular_model->updanytbl($params, $update_condition, $tblname);
             $this->CI->session->set_userdata("success", "Data updated"); 
        }else{
            $params = array(
                'id'                =>"",
                'position_id'       =>$emp_position,
                'Start_Date'        =>$Start_Date,
                'Last_Date'         =>$Last_Date,
                'short_description' =>$short_description,
                'description'       =>$description,
                'created_by'        =>$this->CI->session->userdata('user_id'),
                'updated_by'        =>$this->CI->session->userdata('user_id'),
                'updated_time'      =>getCurrentDateTime(),
                'created_time'      =>getCurrentDateTime(),
                'reserved1'         =>""               
                );
            $this->CI->db->insert("re_circular",$params);
            $insert_id = $this->CI->db->insert_id();
            $this->CI->session->set_userdata("success", "Data inserted");      
        }
        $data['error']="";
        $data['msg']=$msg;

    }

}

?>