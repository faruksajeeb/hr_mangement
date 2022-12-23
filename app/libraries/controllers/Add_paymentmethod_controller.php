<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_paymentmethod_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function add_paymentmethod_action($post_data=array(), $toadd_id){
        if($post_data['emp_pay_type']) {
        //$ci=& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('emp_payment_method_model');
        $content_exist=$this->CI->emp_payment_method_model->getpayment_method($toadd_id);
        $params_contents = array(
            'id'                => '',
            'content_id'        =>  $toadd_id,
            'bank_name'         =>  $post_data['emp_bank'],                             
            'emp_bank_branch'   =>  $post_data['emp_bank_branch'],
            'emp_bank_account'  =>  $post_data['emp_bank_account'],
            'emp_pay_type'      =>  $post_data['emp_pay_type'],
            'created'           =>  getCurrentDateTime(),
            'updated'           =>  getCurrentDateTime(),
            'created_by'        =>  $this->CI->session->userdata('user_id'),
            'updated_by'        =>  $this->CI->session->userdata('user_id'),
            'comments'          =>  '',
            );        
        if($content_exist){
                $update_id=$this->CI->emp_payment_method_model->getLastcontentId($toadd_id);
                $params_toupdate_contents = array(
                    'bank_name'         =>  $post_data['emp_bank'],                             
                    'emp_bank_branch'   =>  $post_data['emp_bank_branch'],
                    'emp_bank_account'  =>  $post_data['emp_bank_account'],
                    'emp_pay_type'      =>  $post_data['emp_pay_type'],
                    'updated'           =>  getCurrentDateTime(),
                    'updated_by'        =>  $this->CI->session->userdata('user_id'),
                    'comments'          =>  '',
                    );            
                $update_conditions=array('id' => $update_id);
                $this->CI->emp_payment_method_model->updEmp_payment_methodtbl($params_toupdate_contents, $update_conditions);
        }else{           
            $this->CI->db->insert("emp_payment_method",$params_contents);
        }
}
    }


}

?>