<?php
 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Check_permission_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
 
    // This function for permission check in every method or page or url
    function check_permission_action($task_type){
        //$ci=& get_instance();
        $this->CI->load->database();
        $user_id = $this->CI->session->userdata('user_id');
        $user_type = $this->CI->session->userdata('user_type');
        if($user_type !=1){
            $has_acces=$this->CI->users_model->getuserwisepermission($task_type, $user_id);
            if($has_acces['status'] !=1){
                redirect('login');
            }
            // $has_acces=$this->CI->users_model->userpermission($task_type, $user_type);
            // if($has_acces[0]['status'] !=1){
            //     redirect('login');
            // }
        }

    }


}

?>