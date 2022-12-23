<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_provision_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function add_provision_action($post_data=array(), $toadd_id){
        //$ci=& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('emp_provision_model');
        $content_exist=$this->CI->emp_provision_model->getcontentByid($toadd_id);
        $params_contents = array(
            'id'                    => '',
            'content_id'            =>  $toadd_id,
            'provision_date_from'   =>  $post_data['emp_provision_starting_date'],                             
            'provision_date_to'     =>  $post_data['emp_provision_ending_date'],
            'insertflag'            =>  '0',
            'created'               =>  getCurrentDateTime(),
            'updated'               =>  getCurrentDateTime(),
            'updated_by'            =>  $this->CI->session->userdata('user_id'),
            );        
        if($content_exist){
            $params_toupdate_contents = array(
                'provision_date_from'   =>  $post_data['emp_provision_starting_date'],                             
                'provision_date_to'     =>  $post_data['emp_provision_ending_date'],
                'insertflag'            =>  '0',                
                'updated'               =>  getCurrentDateTime(),
                'updated_by'            =>  $this->CI->session->userdata('user_id'),
                );            
            $update_conditions=array('content_id' => $toadd_id);
            $this->CI->emp_provision_model->updEmp_provisiontbl($params_toupdate_contents, $update_conditions);
        }else{           
            $this->CI->db->insert("emp_provision",$params_contents);
        }

    }


}

?>