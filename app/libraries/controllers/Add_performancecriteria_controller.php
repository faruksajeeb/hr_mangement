<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_performancecriteria_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function add_performancecriteria_action($post_data=array()){
        //$ci=& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('taxonomy');
        $msg = "";
        $vid=19;
        $criteria_type=$post_data['criteria_type'];
        $criteria=$post_data['criteria'];
        $criteria_serial=$post_data['criteria_serial'];
        $description=$post_data['description'];
        $content_id=$post_data['content_id'];
        $parents_term_data=$this->CI->taxonomy->getTaxonomyBytid($criteria_type);
        $machine_name=$parents_term_data['page_title']."_".time()."_".$criteria_serial;
        $check_duplicate=$this->CI->taxonomy->getcriteriaTaxonomybycriteria($vid, $criteria_type, $criteria);
            $t_id=$this->CI->taxonomy->getLasttaxonomyId();
            $toadd_tid=$t_id+1;
        if($criteria && !$check_duplicate){
            if($content_id){
                $params_vocavulary = array(
                    'name'              =>  $criteria,
                    'description'       =>  $description,
                    'parents_term'      =>  $criteria_type,
                    'weight'            =>  $criteria_serial,
                    );
                $update_condition=array('id' => $content_id);
                $this->CI->taxonomy->updTaxanomytbl($params_vocavulary, $update_condition);
                $msg = "Data updated";
            }else{
                $params_vocavulary = array(
                    'id'                => '',
                    'vid'               =>  $vid,
                    'tid'               =>  $toadd_tid,
                    'name'              =>  $criteria,
                    'description'       =>  $description,
                    'parents_term'      =>  $criteria_type,
                    'weight'            =>  $criteria_serial,
                    'url_path'          =>  $machine_name,
                    );
                $this->CI->db->insert("taxonomy",$params_vocavulary);
                $msg = "Data inserted";         
            }
        }else if($check_duplicate){
            $upd_id=$check_duplicate[0]['id'];
            $params_vocavulary = array(
                    'name'              =>  $criteria,
                    'description'       =>  $description,
                    'parents_term'      =>  $criteria_type,
                    'weight'            =>  $criteria_serial,
                );
            $update_condition=array('id' => $upd_id);
            $this->CI->taxonomy->updTaxanomytbl($params_vocavulary, $update_condition);
            $msg = "Data updated";
        }
        $data['error']="";
        $data['msg']=$msg;

    }


}

?>