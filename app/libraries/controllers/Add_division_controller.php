<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_division_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function addDivisionAction($post_data=array()){
        //$ci=& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('taxonomy');
        $msg = "";
        $vid=2;
        $supervisor_employee_code=$post_data['emp_name'];
        if($supervisor_employee_code){
           $supervisor_employee_id=$this->CI->employee_id_model->getemp_idby_empcode($supervisor_employee_code); 
       }else{
        $supervisor_employee_id="";
       }
        $divisionName=$post_data['division_name'];
        $divisionId=$post_data['division_id'];
        $check_duplicate=$this->CI->taxonomy->getTaxonomybynameandparent($vid, $department_name, $post_data['company_name']);
            $t_id=$this->CI->taxonomy->getLasttaxonomyId();
            $toadd_tid=$t_id+1;
        if($divisionName && !$check_duplicate){
            if($divisionId){ 
                $params_vocavulary = array(
                    'name'              =>  $divisionName,
                    'description'       =>  $post_data['division_description'],
                    'parents_term'      =>  $post_data['company_name'],  
                    'weight'            =>  $supervisor_employee_id,                                      
                    'url_path'          =>  $post_data['division_location'],
                    'page_title'        =>  $post_data['division_phone'],
                    'page_description'  =>  $post_data['division_email'],
                    'status'            =>  $post_data['status'],
                    'keywords'          =>  $post_data['short_name'],
                    );
                $update_condition=array('id' => $divisionId);
                $this->CI->taxonomy->updTaxanomytbl($params_vocavulary, $update_condition);
                $msg = "Division information updated";
            }else{
                $params_vocavulary = array(
                    'id'                => '',
                    'vid'               =>  $vid,
                    'tid'               =>  $toadd_tid,
                    'name'              =>  $divisionName,
                    'description'       =>  $post_data['division_description'],
                    'parents_term'      =>  $post_data['company_name'],  
                    'weight'            =>  $supervisor_employee_id,                                      
                    'url_path'          =>  $post_data['division_location'],
                    'page_title'        =>  $post_data['division_phone'],
                    'page_description'  =>  $post_data['division_email'],
                    'status'            =>  $post_data['status'],
                    'keywords'          =>  $post_data['short_name'],
                    );
                $this->CI->db->insert("taxonomy",$params_vocavulary);
                $msg = "Division data inserted";         
            }
        }else if($check_duplicate){
            $upd_id=$check_duplicate[0]['id'];
            $params_vocavulary = array(
                    'name'              =>  $divisionName,
                    'description'       =>  $post_data['division_description'],
                    'parents_term'      =>  $post_data['company_name'],  
                    'weight'            =>  $supervisor_employee_id,                                      
                    'url_path'          =>  $post_data['division_location'],
                    'page_title'        =>  $post_data['division_phone'],
                    'page_description'  =>  $post_data['division_email'],
                    'status'            =>  $post_data['status'],
                    'keywords'          =>  $post_data['short_name'], 
                );
            $update_condition=array('id' => $upd_id);
            $this->CI->taxonomy->updTaxanomytbl($params_vocavulary, $update_condition);
            $msg = "Division information updated";
        }
        $data['error']="";
        $data['msg']=$msg;
        return $msg;

    }


}

?>