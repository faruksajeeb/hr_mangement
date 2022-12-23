<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Addworkingshiftcontroller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function addworkingshifaction($post_data=array()){
        //$ci=& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('taxonomy');
        $msg = "";
        $vid=21;
        $working_shift=$post_data['working_shift'];
        $attendance_required=$post_data['attendance_required'];
        $emp_working_time_from=$post_data['emp_working_time_from'];
        $emp_working_end_time=$post_data['emp_working_end_time'];
        $emp_latecount_time=$post_data['emp_latecount_time'];
        $emp_earlycount_time=$post_data['emp_earlycount_time'];
        $logout_required=$post_data['logout_required'];
        $half_day_absent=$post_data['half_day_absent'];
        $absent_count_time=$post_data['absent_count_time'];
        $description=$post_data['description'];
        $content_id=$post_data['content_id'];
        $check_duplicate=$this->CI->taxonomy->getTaxonomybyname($vid, $working_shift);
            $t_id=$this->CI->taxonomy->getLasttaxonomyId();
            $toadd_tid=$t_id+1;
        if($working_shift && !$check_duplicate){
            if($content_id){
                $params_vocavulary = array(
                    'name'              =>  $working_shift,
                    'description'       =>  $description,
                    'parents_term'      =>  $attendance_required,
                    'weight'            =>  $emp_working_time_from,
                    'url_path'          =>  $emp_working_end_time,
                    'page_title'        =>  $emp_latecount_time,
                    'page_description'  =>  $emp_earlycount_time,
                    'keywords'          =>  $logout_required,
                    'reserved1'         =>  $half_day_absent,
                    'reserved2'         =>  $absent_count_time
                    );
                $update_condition=array('id' => $content_id);
                $this->CI->taxonomy->updTaxanomytbl($params_vocavulary, $update_condition);
                $msg = "Data updated";
            }else{
                $params_vocavulary = array(
                    'id'                => '',
                    'vid'               =>  $vid,
                    'tid'               =>  $toadd_tid,
                    'name'              =>  $working_shift,
                    'description'       =>  $description,
                    'parents_term'      =>  $attendance_required,
                    'weight'            =>  $emp_working_time_from,
                    'url_path'          =>  $emp_working_end_time,
                    'page_title'        =>  $emp_latecount_time,
                    'page_description'  =>  $emp_earlycount_time,
                    'keywords'          =>  $logout_required,
                    'reserved1'         =>  $half_day_absent,
                    'reserved2'         =>  $absent_count_time
                    );
                $this->CI->db->insert("taxonomy",$params_vocavulary);
                $msg = "Data inserted";         
            }
        }else if($check_duplicate){
            $upd_id=$check_duplicate[0]['id'];
            $params_vocavulary = array(
                    'name'              =>  $working_shift,
                    'description'       =>  $description,
                    'parents_term'      =>  $attendance_required,
                    'weight'            =>  $emp_working_time_from,
                    'url_path'          =>  $emp_working_end_time,
                    'page_title'        =>  $emp_latecount_time,
                    'page_description'  =>  $emp_earlycount_time,
                    'keywords'          =>  $logout_required,
                    'reserved1'         =>  $half_day_absent,
                    'reserved2'         =>  $absent_count_time
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