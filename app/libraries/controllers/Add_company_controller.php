<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_company_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function addCompanyAction($post_data=array()){
        //$ci=& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('taxonomy');
        $msg = "";
        $vid=1;
        $supervisor_employee_code=$post_data['emp_name'];
        if($supervisor_employee_code){
        $supervisor_employee_id=$this->CI->employee_id_model->getemp_idby_empcode($supervisor_employee_code);
        }else{
            $supervisor_employee_id="";
        }
        $company_name=$post_data['company_name'];
        $company_location=$post_data['company_location'];
        $company_phone=$post_data['company_phone'];
        $company_email=$post_data['company_email'];
        $companyDescription=$post_data['company_description'];
        $company_id=$post_data['company_id'];
        $short_name=$post_data['short_name'];
        $company_code=$post_data['company_code'];
        $check_duplicate=$this->CI->taxonomy->getTaxonomybyname($vid, $company_name);
            $t_id=$this->CI->taxonomy->getLasttaxonomyId();
            $toadd_tid=$t_id+1;
        if($company_name && !$check_duplicate){
            if($company_id){
                $params_vocavulary = array(
                    'name'              =>  $company_name,
                    'description'       =>  $companyDescription,
                    'parents_term'      =>  $supervisor_employee_id,
                    'weight'            =>  $company_code,                                        
                    'url_path'          =>  $company_location,
                    'page_title'        =>  $company_phone,
                    'page_description'  =>  $company_email,
                    'status'            =>  $post_data['status'],
                    'keywords'          =>  $short_name,
                    );
                $update_condition=array('id' => $company_id);
                $this->CI->taxonomy->updTaxanomytbl($params_vocavulary, $update_condition);
                $msg = "Company information updated";
            }else{
                $params_vocavulary = array(
                    'id'                => '',
                    'vid'               =>  $vid,
                    'tid'               =>  $toadd_tid,
                    'name'              =>  $company_name,
                    'description'       =>  $companyDescription,
                    'parents_term'      =>  $supervisor_employee_id,
                    'weight'            =>  $company_code,
                    'url_path'          =>  $company_location,
                    'page_title'        =>  $company_phone,
                    'page_description'  =>  $company_email,
                    'status'            =>  $post_data['status'],
                    'keywords'          =>  $short_name,
                    );
                $this->CI->db->insert("taxonomy",$params_vocavulary);
                $msg = "Company data inserted";         
            }
        }else if($check_duplicate){
            $upd_id=$check_duplicate[0]['id'];
            $params_vocavulary = array(
                    'name'              =>  $company_name,
                    'description'       =>  $companyDescription,
                    'parents_term'      =>  $supervisor_employee_id,
                    'weight'            =>  $company_code,                                        
                    'url_path'          =>  $company_location,
                    'page_title'        =>  $company_phone,
                    'page_description'  =>  $company_email,
                    'status'            =>  $post_data['status'],
                    'keywords'          =>  $short_name,
                );
            $update_condition=array('id' => $upd_id);
            $this->CI->taxonomy->updTaxanomytbl($params_vocavulary, $update_condition);
            $msg = "Company information updated";
        }
        $data['error']="";
        $data['msg']=$msg;
        return $msg;

    }


}

?>