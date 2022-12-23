<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_criteriacategory_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function add_criteriacategory_action($post_data=array()){
        //$ci=& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('taxonomy');
        $msg = "";
        $vid=18;
        $criteriacategory=$post_data['criteriacategory'];
        $criteriacategory_serial=$post_data['criteriacategory_serial'];
        $criteriacategory_weight_age=$post_data['criteriacategory_weight_age'];
        $description=$post_data['description'];
        $content_id=$post_data['content_id'];
        $machine_name =strtolower($post_data['criteriacategory']);
        $machine_name = str_replace(' ', '_', $machine_name);
        $check_duplicate=$this->CI->taxonomy->getTaxonomybyname($vid, $criteriacategory);
            $t_id=$this->CI->taxonomy->getLasttaxonomyId();
            $toadd_tid=$t_id+1;
        if($criteriacategory && !$check_duplicate){
            if($content_id){
                $params_vocavulary = array(
                    'name'              =>  $criteriacategory,
                    'description'       =>  $description,
                    'weight'            =>  $criteriacategory_serial,
                    'url_path'          =>  $criteriacategory_weight_age,                  
                    );
                $update_condition=array('id' => $content_id);
                $this->CI->taxonomy->updTaxanomytbl($params_vocavulary, $update_condition);
                $msg = "Data updated";
            }else{
                $params_vocavulary = array(
                    'id'                => '',
                    'vid'               =>  $vid,
                    'tid'               =>  $toadd_tid,
                    'name'              =>  $criteriacategory,
                    'description'       =>  $description,
                    'parents_term'      =>  '',
                    'weight'            =>  $criteriacategory_serial,
                    'url_path'          =>  $criteriacategory_weight_age,
                    'page_title'        =>  $machine_name,
                    );
                $this->CI->db->insert("taxonomy",$params_vocavulary);
                $msg = "Data inserted";         
            }
        }else if($check_duplicate){
            $upd_id=$check_duplicate[0]['id'];
            $params_vocavulary = array(
                    'name'              =>  $criteriacategory,
                    'description'       =>  $description,
                    'weight'            =>  $criteriacategory_serial,
                    'url_path'          =>  $criteriacategory_weight_age,                  
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