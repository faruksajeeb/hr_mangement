<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_salarydeduction_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function add_deduction_action($post_data=array(), $toadd_id){
//        print_r($post_data);
//        exit;
        if(!empty($post_data['emp_total_deduction']) && $post_data['emp_total_deduction']>=0){
        //$ci=& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('emp_salary_deduction_model');
        $content_exist=$this->CI->emp_salary_deduction_model->getdeduction($toadd_id);
        $params_contents = array(
            'id'                        => '',
            'content_id'                =>  $toadd_id,
            'provident_fund_deduction'  =>  $post_data['emp_provident_fund_deduction'], 
            'tax_deduction'             =>  $post_data['emp_tax_deduction'],
            'other_deduction'           =>  $post_data['emp_other_deduction'],
            'total_deduction'           =>  $post_data['emp_total_deduction'],
            'created'                   =>  getCurrentDateTime(),
            'updated'                   =>  getCurrentDateTime(),
            'created_by'                =>  $this->CI->session->userdata('user_id'),
            'updated_by'                =>  $this->CI->session->userdata('user_id'),
            'comments'                  =>  '',
            );        
        if($content_exist){
            if($post_data['emp_salary_increment']){
               // $this->CI->db->insert("emp_salary_deduction",$params_contents);
               $update_id=$this->CI->emp_salary_deduction_model->getLastcontentId($toadd_id);
                $params_toupdate_contents = array(
                    'provident_fund_deduction'  =>  $post_data['emp_provident_fund_deduction'],
                    'tax_deduction'             =>  $post_data['emp_tax_deduction'],
                    'other_deduction'           =>  $post_data['emp_other_deduction'],
                    'total_deduction'           =>  $post_data['emp_total_deduction'],
                    'updated'                   =>  getCurrentDateTime(),
                    'updated_by'                =>  $this->CI->session->userdata('user_id'),
                    'comments'                  =>  '',
                    );            
                $update_conditions=array('id' => $update_id);
                $res=$this->CI->emp_salary_deduction_model->updEmp_salary_deductiontbl($params_toupdate_contents, $update_conditions);
                 if($res){
                    $info='Salary deduction updated successfully!';
                }else{
                    $info='Something Wrong! Salary deduction not updated!';
                }
            }else{
                $update_id=$this->CI->emp_salary_deduction_model->getLastcontentId($toadd_id);
                $params_toupdate_contents = array(
                    'provident_fund_deduction'  =>  $post_data['emp_provident_fund_deduction'],
                    'tax_deduction'             =>  $post_data['emp_tax_deduction'],
                    'other_deduction'           =>  $post_data['emp_other_deduction'],
                    'total_deduction'           =>  $post_data['emp_total_deduction'],
                    'updated'                   =>  getCurrentDateTime(),
                    'updated_by'                =>  $this->CI->session->userdata('user_id'),
                    'comments'                  =>  '',
                    );            
                $update_conditions=array('id' => $update_id);
                $res=$this->CI->emp_salary_deduction_model->updEmp_salary_deductiontbl($params_toupdate_contents, $update_conditions);
                 if($res){
                    $info='Salary deduction updated successfully!';
                }else{
                    $info='Something Wrong! Salary deduction not updated!';
                }
            }
        }else{           
            $res=$this->CI->db->insert("emp_salary_deduction",$params_contents);
             if($res){
                $info='Salary deduction inserted successfully!';
            }else{
                $info='Something Wrong! Salary deduction not inserted!';
            }
        }
        return $info;
}
    }


}

?>