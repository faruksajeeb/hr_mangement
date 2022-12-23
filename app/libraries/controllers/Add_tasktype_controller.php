<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_tasktype_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function add_tasktype_action($post_data=array()){
        //$ci=& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('taxonomy');
        $msg = "";
        $vid=13;
        $task_name=$post_data['task_name'];
        $task_machine_name=$post_data['task_machine_name'];
        $content_id=$post_data['content_id'];
        $check_duplicate=$this->CI->taxonomy->getTaxonomybyname($vid, $task_name);
            $t_id=$this->CI->taxonomy->getLasttaxonomyId();
            $toadd_tid=$t_id+1;
        if($task_name && !$check_duplicate){
            if($content_id){
                $params_vocavulary = array(
                    'name'              =>  $task_name,
                    'description'       =>  $task_machine_name,
                    );
                $update_condition=array('id' => $content_id);
                $this->CI->taxonomy->updTaxanomytbl($params_vocavulary, $update_condition);
                $msg = "Data updated";
            }else{
                $params_vocavulary = array(
                    'id'                => '',
                    'vid'               =>  $vid,
                    'tid'               =>  $toadd_tid,
                    'name'              =>  $task_name,
                    'description' =>  $task_machine_name,
                    );
                $this->CI->db->insert("taxonomy",$params_vocavulary);
                $msg = "Data inserted";         
            }
        }else if($check_duplicate){
            $upd_id=$check_duplicate[0]['id'];
            $params_vocavulary = array(
                    'name'              =>  $task_name,
                    'description' =>  $task_machine_name,
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