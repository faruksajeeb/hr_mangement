<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_weeklyholidayhistory_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function add_weeklyholidayhistory_action($post_data=array(), $content_id){  
        //$ci=& get_instance();
        $this->CI->load->database();
        $holidays=$post_data['emp_weekly_holiday'];
        $sat_off   =  'on';                            
        $sun_off   =  'on';
        $mon_off   =  'on';
        $tue_off   =  'on';
        $wed_off   =  'on';
        $thus_off  =  'on';
        $fri_off   =  'on';        
        foreach ($holidays as $single_holiday) {
            if($single_holiday=='fri'){
            $fri_off   =  'off';  
            }else if($single_holiday=='sat'){
                $sat_off   =  'off';  
            }else if($single_holiday=='sun'){
                $sun_off   =  'off';  
            }else if($single_holiday=='mon'){
                $mon_off   =  'off';  
            }else if($single_holiday=='tue'){
                $tue_off   =  'off';  
            }else if($single_holiday=='wed'){
                $wed_off   =  'off';  
            }else if($single_holiday=='thus'){
                $thus_off   =  'off';  
            }
        }
        $emp_job_change_date=$post_data['emp_job_change_date']; 
        if(!$emp_job_change_date){
                $emp_job_change_date=$post_data['emp_starting_date'];
        }        
        $has_history = $this->CI->emp_weeklyholiday_history_model->getemp_weeklyholiday_history($content_id, $emp_job_change_date, $sat_off, $sun_off, $mon_off, $tue_off, $wed_off, $thus_off, $fri_off);
        $has_last_history = $this->CI->emp_weeklyholiday_history_model->getemp_last_weeklyholiday_history($content_id);
        if(!$has_history){
            if($has_last_history){
                $previous_id=$has_last_history['id'];
                $previous_start_date=$has_last_history['start_date'];
                $last_end_date=date('d-m-Y',(strtotime ( '-1 day' , strtotime ( $emp_job_change_date) ) ));
                $d1 = explode('-', $previous_start_date);
                $d2 = explode('-', $last_end_date);
                $d1 = array_reverse($d1);
                $d2 = array_reverse($d2);

                if (strtotime(implode('-', $d2)) > strtotime(implode('-', $d1)))
                {              
                $params = array(
                'end_date'        =>  $last_end_date,
                'updated_time'    =>  getCurrentDateTime(),
                'updated_by'      =>  $this->CI->session->userdata('user_id'),
                );  
                $update_condition=array('id' => $previous_id);
                $this->CI->emp_weeklyholiday_history_model->updemp_weeklyholiday_historytbl($params, $update_condition);
                $this->CI->session->set_userdata("success", "Data Updated!");
                // insert new history
                $this->insertemphistory($content_id, $emp_job_change_date, $sat_off, $sun_off, $mon_off, $tue_off, $wed_off, $thus_off, $fri_off); 
                } else {
                    $params = array(
                        
                        'sat_off' => $sat_off,
                        'sun_off' => $sun_off,
                        'mon_off' => $mon_off,
                        'tue_off' => $tue_off,
                        'wed_off' => $wed_off,
                        'thus_off' => $thus_off,
                        'fri_off' => $fri_off,
                        'updated_time' => getCurrentDateTime(),
                        'updated_by' => $this->CI->session->userdata('user_id'),
                    );
                     $update_condition = array('id' => $previous_id);
                     $this->CI->emp_weeklyholiday_history_model->update_emp_working_holiday_history($params, $update_condition);
                   
                }               
            }else{
                $this->insertemphistory($content_id, $emp_job_change_date, $sat_off, $sun_off, $mon_off, $tue_off, $wed_off, $thus_off, $fri_off);
            }
        }

    }

    function insertemphistory($content_id, $emp_job_change_date, $sat_off, $sun_off, $mon_off, $tue_off, $wed_off, $thus_off, $fri_off){
        $this->CI->load->database();
        $params = array(
            'id'                    => '',
            'content_id'            =>  $content_id,
            'start_date'            =>  $emp_job_change_date,
            'end_date'              =>  "",
            'sat_off'               =>  $sat_off,
            'sun_off'               =>  $sun_off,
            'mon_off'               =>  $mon_off,
            'tue_off'               =>  $tue_off,
            'wed_off'               =>  $wed_off,
            'thus_off'              =>  $thus_off,
            'fri_off'               =>  $fri_off,
            'created_time'          =>  getCurrentDateTime(),
            'created_by'            =>  $this->CI->session->userdata('user_id'),
            'updated_time'          =>  getCurrentDateTime(),
            'updated_by'            =>  $this->CI->session->userdata('user_id'),
            'reserved1'             =>  "",
            'reserved2'             =>  "",
            );
        $this->CI->db->insert("emp_weeklyholiday_history",$params);
        $insert_id = $this->CI->db->insert_id();
        $this->CI->session->set_userdata("success", "Data Inserted!");
        $msg = "Data inserted";      
    }

}

?>