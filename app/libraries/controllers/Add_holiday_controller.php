<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_holiday_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function add_holiday_action($post_data=array(), $toadd_id){
        //$ci=& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('emp_holiday_model');
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
    $content_exist=$this->CI->emp_holiday_model->getemp_holiday($toadd_id);
    $params_contents = array(
        'id'                    => '',
        'content_id'            =>  $toadd_id,
        'sat_off'               =>  $sat_off,                             
        'sun_off'               =>  $sun_off,
        'mon_off'               =>  $mon_off,
        'tue_off'               =>  $tue_off,
        'wed_off'               =>  $wed_off,
        'thus_off'              =>  $thus_off,
        'fri_off'               =>  $fri_off,
        );       
    if($content_exist){
        $params_toupdate_contents = array(
            'sat_off'               =>  $sat_off,                             
            'sun_off'               =>  $sun_off,
            'mon_off'               =>  $mon_off,
            'tue_off'               =>  $tue_off,
            'wed_off'               =>  $wed_off,
            'thus_off'              =>  $thus_off,
            'fri_off'               =>  $fri_off,           
            );            
        $update_conditions=array('content_id' => $toadd_id);
        $this->CI->emp_holiday_model->updemp_holidaytbl($params_toupdate_contents, $update_conditions);
    }else{           
        $this->CI->db->insert("emp_weeklyholiday",$params_contents);
    }

}


}

?>