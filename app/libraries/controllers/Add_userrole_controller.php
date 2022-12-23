<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_userrole_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    function add_userrole_action($post_data=array()){
        //$ci=& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('role_model');
        $msg = "";
        $user_role=$post_data['user_role'];
        $description=$post_data['description'];
        $content_id=$post_data['content_id'];
        $check_duplicate=$this->CI->role_model->getuserrolebyrolename($user_role);
        if($user_role && !$check_duplicate){
            if($content_id){
                $params_vocavulary = array(
                    'user_type'         =>  $user_role,
                    'description'       =>  $description,
                    );
                $update_condition=array('id' => $content_id);
                $this->CI->role_model->updRoletbl($params_vocavulary, $update_condition);
                $msg = "Data updated";
            }else{
                $params_vocavulary = array(
                    'id'                => '',
                    'user_type'         =>  $user_role,
                    'description'       =>  $description,
                    );
                $this->CI->db->insert("role",$params_vocavulary);
                $msg = "Data inserted";         
            }
        }else if($check_duplicate){
            $upd_id=$check_duplicate[0]['id'];
            $params_vocavulary = array(
                'user_type'         =>  $user_role,
                'description'       =>  $description,
                );
            $update_condition=array('id' => $upd_id);
            $this->CI->role_model->updRoletbl($params_vocavulary, $update_condition);
            $msg = "Data updated";
        }
        $data['error']="";
        $data['msg']=$msg;
    }


}

?>