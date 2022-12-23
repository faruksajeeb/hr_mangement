<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_salary_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    // Salary insert and update start
    function add_salary_action($post_data=array(), $toadd_id){
//        print_r($post_data);
//        exit;
        if($post_data['emp_gross_salary']){
            
        //$ci=& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('emp_salary_model');
        $content_exist=$this->CI->emp_salary_model->getsalary($toadd_id);
        $params_contents = array(
            'id'                    => '',
            'content_id'            =>  $toadd_id,
            'basic_salary'          =>  $post_data['emp_basic_salary'],                             
            'house_rent'            =>  $post_data['emp_house_rent'],
            'medical_allow'         =>  $post_data['emp_medical_allowance'],
            //'conveyance_allow'      =>  $post_data['emp_conveyance'],
            'telephone_allow'       =>  $post_data['emp_telephone_allowance'],
            //'special_allowa'        =>  $post_data['emp_special_allowance'],
            //'provident_allow'       =>  $post_data['emp_provident_fund_allowance'],
            'transport_allow'       =>  $post_data['emp_transport_allowance'],
            'other_allow'           =>  $post_data['emp_other_allowance'],
            //'performance_bonus'     =>  $post_data['emp_performance_bonus'],
            'festival_bonus'        =>  $post_data['emp_festival_bonus'],
            'total_benifit'         =>  $post_data['emp_total_benifit'],
            'increment_amount'      =>  $post_data['emp_salary_increment_amount'],
            'increment_percentage'  =>  $post_data['emp_increment_percentage'],
            'increment_date'        =>  $post_data['emp_increment_date'],
            'gross_salary'          =>  $post_data['emp_gross_salary'],
            'yearly_paid'           =>  $post_data['emp_yearly_paid'],
            'created'               =>  getCurrentDateTime(),
            'updated'               =>  getCurrentDateTime(),
            'created_by'            =>  $this->CI->session->userdata('user_id'),
            'updated_by'            =>  $this->CI->session->userdata('user_id'),
            'comments'              =>  '',
            );        
            if($content_exist){
                if($post_data['emp_salary_increment'] && $post_data['emp_salary_increment_amount']>0){
                        $res=$this->CI->db->insert("emp_salary",$params_contents);
                         if($res){
                            $info='Salary updated successfully!';
                        }else{
                            $info='Something Wrong! Salary not changes!';
                        }
                }else{
                    $update_id=$this->CI->emp_salary_model->getLastcontentId($toadd_id);
                    $params_toupdate_contents = array(
                        'basic_salary'          =>  $post_data['emp_basic_salary'],                             
                        'house_rent'            =>  $post_data['emp_house_rent'],
                        'medical_allow'         =>  $post_data['emp_medical_allowance'],
                        'conveyance_allow'      =>  $post_data['emp_conveyance'],
                        'telephone_allow'       =>  $post_data['emp_telephone_allowance'],
                        'special_allowa'        =>  $post_data['emp_special_allowance'],
                        'provident_allow'       =>  $post_data['emp_provident_fund_allowance'],
                        'transport_allow'       =>  $post_data['emp_transport_allowance'],
                        'other_allow'           =>  $post_data['emp_other_allowance'],
                        'performance_bonus'     =>  $post_data['emp_performance_bonus'],
                        'festival_bonus'        =>  $post_data['emp_festival_bonus'],
                        'total_benifit'         =>  $post_data['emp_total_benifit'],
                        'gross_salary'          =>  $post_data['emp_gross_salary'],
                        'yearly_paid'           =>  $post_data['emp_yearly_paid'],
                        'updated'               =>  getCurrentDateTime(),
                        'updated_by'            =>  $this->CI->session->userdata('user_id'),
                        'comments'              =>  '',
                        );            
                $update_conditions=array('id' => $update_id);
                
                $res=$this->CI->emp_salary_model->updEmp_salarytbl($params_toupdate_contents, $update_id);
                
                if($res){
                    $info='Payroll data updated successfully!';
                }else{
                    $info='Something Wrong! Payroll data not updated!';
                }
                }
            }else{           
                $this->CI->db->insert("emp_salary",$params_contents);
                if($res){
                    $info='Salary data inserted successfully!';
                }else{
                    $info='Something Wrong! Salary not inserted!';
                }
            }
            return $info;
        }
    }

public function updatesalarybyid($post_data=array(), $salary_id){
  $this->CI->load->database();
  $this->CI->load->model('emp_salary_model');    
  $params_toupdate_contents = array(
    'basic_salary'          =>  $post_data['emp_basic_salary'],                             
    'house_rent'            =>  $post_data['emp_house_rent'],
    'medical_allow'         =>  $post_data['emp_medical_allowance'],
    'conveyance_allow'      =>  $post_data['emp_conveyance'],
    'telephone_allow'       =>  $post_data['emp_telephone_allowance'],
    'special_allowa'        =>  $post_data['emp_special_allowance'],
    'provident_allow'       =>  $post_data['emp_provident_fund_allowance'],
    'transport_allow'       =>  $post_data['emp_transport_allowance'],
    'other_allow'           =>  $post_data['emp_other_allowance'],
    'performance_bonus'     =>  $post_data['emp_performance_bonus'],
    'festival_bonus'        =>  $post_data['emp_festival_bonus'],
    'total_benifit'         =>  $post_data['emp_total_benifit'],
    'increment_amount'      =>  $post_data['emp_salary_increment_amount'],
    'increment_percentage'  =>  $post_data['emp_increment_percentage'],
    'increment_date'        =>  $post_data['emp_increment_date'],            
    'gross_salary'          =>  $post_data['emp_gross_salary'],
    'yearly_paid'           =>  $post_data['emp_yearly_paid'],
    'updated'               =>  getCurrentDateTime(),
    'updated_by'            =>  $this->CI->session->userdata('user_id'),
    'comments'              =>  '',
    );            
$update_conditions=array('id' => $salary_id);
$this->CI->emp_salary_model->updEmp_salarytbl($params_toupdate_contents, $update_conditions);    
}

}

?>