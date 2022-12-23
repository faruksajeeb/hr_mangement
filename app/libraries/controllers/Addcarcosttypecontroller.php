<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Addcarcosttypecontroller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function addcarcosttypeaction($post_data=array()){
        //$ci=& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('taxonomy');
        $msg = "";
        $vid=20;
        $car_cost_type=$post_data['car_cost_type'];
        $description=$post_data['description'];
        $content_id=$post_data['content_id'];
        $check_duplicate=$this->CI->taxonomy->getTaxonomybyname($vid, $car_cost_type);
            $t_id=$this->CI->taxonomy->getLasttaxonomyId();
            $toadd_tid=$t_id+1;
        if($car_cost_type && !$check_duplicate){
            if($content_id){
                $params_vocavulary = array(
                    'name'              =>  $car_cost_type,
                    'description'       =>  $description,
                    );
                $update_condition=array('id' => $content_id);
                $this->CI->taxonomy->updTaxanomytbl($params_vocavulary, $update_condition);
                $msg = "Data updated";
            }else{
                $params_vocavulary = array(
                    'id'                => '',
                    'vid'               =>  $vid,
                    'tid'               =>  $toadd_tid,
                    'name'              =>  $car_cost_type,
                    'description'       =>  $description,
                    );
                $this->CI->db->insert("taxonomy",$params_vocavulary);
                $msg = "Data inserted";         
            }
        }else if($check_duplicate){
            $upd_id=$check_duplicate[0]['id'];
            $params_vocavulary = array(
                    'name'              =>  $car_cost_type,
                    'description'       =>  $description,
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