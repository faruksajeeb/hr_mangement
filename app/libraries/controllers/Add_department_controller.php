<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_department_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function addDepartmentAction($post_data=array()){
        //$ci=& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('taxonomy');
        $msg = "";
        $vid=22; // texonomy type id for department
        $departmentName = $post_data['department_name'];
        $description = $post_data['description'];
        $status = $post_data['status'];
        $content_id = $post_data['content_id'];
       ;
        $check_duplicate=$this->CI->taxonomy->getTaxonomybyname($vid, $departmentName);
            $t_id=$this->CI->taxonomy->getLasttaxonomyId();
            $toadd_tid=$t_id+1;
        if($departmentName && !$check_duplicate){
            if($content_id){
                $params_vocavulary = array(
                    'name'              =>  $departmentName,
                    'description'       =>  $description,
                    'status'            =>  $status
                    );
                $update_condition=array('id' => $content_id);
                $this->CI->taxonomy->updTaxanomytbl($params_vocavulary, $update_condition);
                $msg = "Department data updated";
            }else{
                $params_vocavulary = array(
                    'id'                => '',
                    'vid'               =>  $vid,
                    'tid'               =>  $toadd_tid,
                    'name'              =>  $departmentName,
                    'description'       =>  $description,
                    'status'            =>  $status
                    );
                
                $this->CI->db->insert("taxonomy",$params_vocavulary);
                $msg = "Department data inserted";         
            }
        }else if($check_duplicate){
            $upd_id=$check_duplicate[0]['id'];
            $params_vocavulary = array(
                    'name'              =>  $departmentName,
                    'description'       =>  $description,
                    'status'            =>  $status,
                );
            $update_condition=array('id' => $upd_id);
            $this->CI->taxonomy->updTaxanomytbl($params_vocavulary, $update_condition);
            $msg = "Department data updated";
        }else{
           $msg="Something wrong!"; 
        }
        
        return $data['msg']=$msg;

    }


}

?>