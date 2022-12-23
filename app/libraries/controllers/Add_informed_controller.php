<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_informed_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
      function add_all_informed_action($post_data=array(), $attendance_date, $content_id){
        //$ci=& get_instance();
        $this->CI->load->database();
        $login_status=$post_data['presence_status'];
        $logout_status=$post_data['logout_status'];
        $reason=$post_data['reason'];
        $remarks=$post_data['remarks'];
           //$content_id=array(1,2,3,4,5,6,7,8,9);
//                    echo '<pre>';
//                    print_r($content_id);
//                    echo '</pre>';
//     
//        
//         $length=count($content_id);
//                    for ($i = 0; $i < $length; $i++) {
//                    print $content_id[$i]->content_id;
//                    }
//                    exit();
        $length=count($content_id);
        for ($i = 0; $i < $length; $i++) {
        $params = array(
                'id'                    => '',
                'content_id'            =>  $content_id[$i]->content_id,
                'attendance_date'       =>  $attendance_date,
                'presence_status'       =>  $login_status,
                'logout_status'       =>  $logout_status,              
                'reason'               =>  $reason,                
                'updated_time'          =>  getCurrentDateTime(),
                'updated_by'            =>  $this->CI->session->userdata('user_id'),
                'entry_date'            =>  getCurrentDateTime(),
                'entry_user'            =>  $this->CI->session->userdata('user_id'),
                'reserved1'             =>  "",
                'reserved2'             =>  "",
                );
            if(trim($remarks)==''){
                $params['remarks']=$reason;
            }else{
                $params['remarks']=$remarks;
            }            
            $this->CI->db->insert("emp_informed",$params);
        }
            $insert_id = $this->CI->db->insert_id();
            $this->CI->session->set_userdata("success", "Data Inserted!");
            $msg = "Data inserted";         
       
        $data['error']="";
        $data['msg']=$msg;

    }

    function add_informed_action($post_data=array(), $attendance_date, $content_id){
        //$ci=& get_instance();
        $this->CI->load->database();
        $login_status=$post_data['presence_status'];
        $logout_status=$post_data['logout_status'];
        $reason=$post_data['reason'];
        $remarks=$post_data['remarks'];
        $has_attendance = $this->CI->emp_informed_model->getemp_informed($content_id, $attendance_date);
        if($has_attendance){
            $params = array(
                'attendance_date'       =>  $attendance_date,
                'presence_status'       =>  $login_status,
                'logout_status'         =>  $logout_status,
                'reason'               =>  $reason,                
                'updated_time'          =>  getCurrentDateTime(),
                'updated_by'            =>  $this->CI->session->userdata('user_id')
                );
            if(trim($remarks)==''){
                $params['remarks']=$reason;
            }else{
                $params['remarks']=$remarks;
            }
            $params=array_filter($params,'strlen');   
            $update_condition=array('content_id' => $content_id, 'attendance_date' => $attendance_date);
            $this->CI->emp_informed_model->updemp_emp_informedtbl($params, $update_condition);
            $this->CI->session->set_userdata("success", "Data Updated!");
        }else{
            $params = array(
                'id'                    => '',
                'content_id'            =>  $content_id,
                'attendance_date'       =>  $attendance_date,
                'presence_status'       =>  $login_status,
                'logout_status'       =>  $logout_status,              
                'reason'               =>  $reason,                
                'updated_time'          =>  getCurrentDateTime(),
                'updated_by'            =>  $this->CI->session->userdata('user_id'),
                'entry_date'            =>  getCurrentDateTime(),
                'entry_user'            =>  $this->CI->session->userdata('user_id'),
                'reserved1'             =>  "",
                'reserved2'             =>  "",
                );
            if(trim($remarks)==''){
                $params['remarks']=$reason;
            }else{
                $params['remarks']=$remarks;
            }            
            $this->CI->db->insert("emp_informed",$params);
            $insert_id = $this->CI->db->insert_id();
            $this->CI->session->set_userdata("success", "Data Inserted!");
            $msg = "Data inserted";         
        }
        $data['error']="";
        $data['msg']=$msg;

    }


}

?>