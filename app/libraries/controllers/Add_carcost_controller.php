<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_carcost_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function add_carcost_action($post_data=array()){
        //$ci=& get_instance();
        $this->CI->load->database();
        $msg = "";
        $cost_id=$post_data['cost_id']; 
        $cost_type=$post_data['cost_type']; 
        $Car_id=$post_data['Car_Name'];
        $cost_buyer=$post_data['cost_buyer'];
        $cost_amount=$post_data['cost_amount'];
        $car_cost_date=$post_data['car_cost_date'];
        $remarks=$post_data['remarks'];
        if($cost_id){
            $params = array(
                'car_id'            =>$Car_id,
                'Cost_Type'         =>$cost_type,
                'buyer'             =>$cost_buyer,
                'Cost_Amount'       =>$cost_amount,
                'Cost_Date'         =>$car_cost_date,
                'Remarks'           =>$remarks,
                'updated_by'        =>$this->CI->session->userdata('user_id'),
                'updated_time'      =>getCurrentDateTime()
                );
            $update_condition=array('id' => $cost_id);
            $tblname="car_cost";
            $this->CI->car_info_model->updanytbl($params, $update_condition, $tblname);
             $this->CI->session->set_userdata("success", "Data updated"); 
        }else{
            $params = array(
                'id'                =>"",
                'car_id'            =>$Car_id,
                'Cost_Type'         =>$cost_type,
                'buyer'             =>$cost_buyer,
                'Cost_Amount'       =>$cost_amount,
                'Cost_Date'         =>$car_cost_date,
                'Remarks'           =>$remarks,
                'created_by'        =>$this->CI->session->userdata('user_id'),
                'created_time'      =>getCurrentDateTime(),
                'updated_by'        =>$this->CI->session->userdata('user_id'),
                'updated_time'      =>getCurrentDateTime(),
                'reserved1'         =>""               
                );
            $this->CI->db->insert("car_cost",$params);
            $insert_id = $this->CI->db->insert_id();
            $this->CI->session->set_userdata("success", "Data inserted");      
        }
        $data['error']="";
        $data['msg']=$msg;

    }


}

?>