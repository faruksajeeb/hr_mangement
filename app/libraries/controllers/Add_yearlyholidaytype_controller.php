<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_yearlyholidaytype_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function add_holidaytype_action($post_data=array()){
        //$ci=& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('taxonomy');
        $msg = "";
        $vid=17;
        $holidaytype=$post_data['holidaytype'];
        $description=$post_data['description'];
        $content_id=$post_data['content_id'];
        $check_duplicate=$this->CI->taxonomy->getTaxonomybyname($vid, $holidaytype);
        $t_id=$this->CI->taxonomy->getLasttaxonomyId();
        $toadd_tid=$t_id+1;
        if($holidaytype && !$check_duplicate){
            if($content_id){
                $params_vocavulary = array(
                    'name'              =>  $holidaytype,
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
                    'name'              =>  $holidaytype,
                    'description'       =>  $description,
                    );
                $this->CI->db->insert("taxonomy",$params_vocavulary);
                $msg = "Data inserted";         
            }
        }else if($check_duplicate){
            $upd_id=$check_duplicate[0]['id'];
            $params_vocavulary = array(
                'name'              =>  $holidaytype,
                'description'       =>  $description,
                );
            $update_condition=array('id' => $upd_id);
            $this->CI->taxonomy->updTaxanomytbl($params_vocavulary, $update_condition);
            $msg = "Data updated";
        }
        $data['error']="";
        $data['msg']=$msg;

    }
    function add_yearlyholiday_action($post_data=array(), $holiday_date){
        //$ci=& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('emp_holiday_model');
        $emp_division_tid=$post_data['emp_division_tid'];
        $emp_department_tid=$post_data['emp_department_tid'];
        $holiday_start_date=$post_data['holiday_start_date'];
        $holiday_end_date=$post_data['holiday_end_date'];
        $holiday_type=$post_data['holiday_category'];
        $comments=$post_data['comments'];

        if($holiday_type=='cancel_holiday'){
            $this->CI->emp_holiday_model->cancelHoliday($emp_division_tid,$emp_department_tid, $holiday_date);
        }else{
            $holiday_start_date=$holiday_date;
            date_default_timezone_set('Asia/Dhaka');
            $holiday_year = date("Y", strtotime($holiday_start_date));
            $content_exist=$this->CI->emp_holiday_model->getemp_yearlyholiday($emp_division_tid,$emp_department_tid, $holiday_date);
            $params_contents = array(
                'id'                    => '',
                'holiday_for_division'  =>  $emp_division_tid,
                'holiday_for_department'  =>  $emp_department_tid,
                'holiday_year'          =>  $holiday_year,                             
                'holiday_start_date'    =>  $holiday_start_date,
                'holiday_end_date'      =>  $holiday_start_date,
                'holiday_total_day'     =>  1,
                'holiday_type'          =>  $holiday_type,
                'comments'              =>  $comments,
                'created_time'          =>  getCurrentDateTime(),
                'updated_time'          =>  getCurrentDateTime(),
                'created_by'            =>  $this->CI->session->userdata('user_id'),
                'updated_by'            =>  $this->CI->session->userdata('user_id'),
                );        
            if($content_exist){
                $params_toupdate_contents = array(
                    'holiday_for_division'  =>  $emp_division_tid,                    
                    'holiday_for_department' =>  $emp_department_tid,
                    'holiday_year'          =>  $holiday_year,                             
                    'holiday_start_date'    =>  $holiday_start_date,
                    'holiday_end_date'      =>  $holiday_start_date,
                    'holiday_total_day'     =>  1,
                    'holiday_type'          =>  $holiday_type,
                    'comments'              =>  $comments,
                    'updated_time'          =>  getCurrentDateTime(),
                    'updated_by'            =>  $this->CI->session->userdata('user_id'),       
                    );            
                $update_conditions=array('holiday_for_division' => $emp_division_tid,'holiday_for_department' => $emp_department_tid, 'holiday_start_date' => $holiday_date);
                $this->CI->emp_holiday_model->updemp_yearlyholidaytbl($params_toupdate_contents, $update_conditions);
            }else{           
                $this->CI->db->insert("emp_yearlyholiday",$params_contents);
            }
        }
    }

}

?>