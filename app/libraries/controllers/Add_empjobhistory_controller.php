<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_empjobhistory_controller {
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    function add_empjobhistory_action($post_data=array(), $content_id){  
        //$ci=& get_instance();
		
        $this->CI->load->database();
        $emp_joining_date=$post_data['emp_starting_date'];
        $emp_company=$post_data['emp_company'];
        $emp_division=$post_data['emp_division'];
        $emp_department=$post_data['emp_department'];
        $emp_position=$post_data['emp_position'];
        $emp_grade=$post_data['emp_grade'];
        $emp_type=$post_data['emp_type'];
        $emp_job_change_date=$post_data['emp_job_change_date'];
        if(!$emp_job_change_date){
        $emp_job_change_date=$post_data['emp_starting_date'];
        }    
			
        $has_history = $this->CI->emp_job_history_model->getemp_job_history($content_id, $emp_job_change_date,$emp_company,$emp_division, $emp_department, $emp_position, $emp_grade, $emp_type);
        $has_last_history = $this->CI->emp_job_history_model->getemp_last_job_history($content_id);
        $first_job_history = $this->CI->emp_job_history_model->getemp_first_job_history($content_id);
		
        $jobStartId = $first_job_history['id'];
        $jobStartDate = $first_job_history['start_date'];
        $firstJobHistoryEndDate = $first_job_history['end_date'];
        if($first_job_history){  
		
            if(strtotime ($emp_joining_date) != strtotime ($jobStartDate)){
				
                // IF Change Joining date ----------------
                if($firstJobHistoryEndDate && strtotime ($emp_joining_date)>strtotime($firstJobHistoryEndDate) ){
                    $res = "Invalid_joining_date";
                        return $res;
                }else{
					
                    $this->CI->emp_job_history_model->updemp_job_starting_date($emp_joining_date, $content_id,$jobStartId);
                }   
            }
        }
		
        if(!$has_history){            
            if($has_last_history){     
			
                $previous_id=$has_last_history['id'];
                $previous_start_date=$has_last_history['start_date'];
                $last_end_date=date('d-m-Y',(strtotime ( '-1 day' , strtotime ( $emp_job_change_date) ) ));
                $d1 = explode('-', $previous_start_date);
                $d2 = explode('-', $last_end_date);
                $d1 = array_reverse($d1);
                $d2 = array_reverse($d2);
                if($emp_job_change_date){
                if (strtotime(implode('-', $d2)) >= strtotime(implode('-', $d1)))
                { 
                $params = array(
                    'end_date'        =>  $last_end_date,
                    'updated_time'    =>  getCurrentDateTime(),
                    'updated_by'      =>  $this->CI->session->userdata('user_id'),
                );  
                $update_condition=array('id' => $previous_id);
				$currentDateTime= getCurrentDateTime();
				$currentUser = $this->CI->session->userdata('user_id');
				#dd(55,1);	
				$this->CI->db->query("UPDATE emp_job_history SET end_date='$last_end_date',updated_time='$currentDateTime',updated_by='$currentUser' WHERE id=$previous_id");			
                #$this->CI->emp_job_history_model->updemp_job_historytbl($params, $update_condition);
				#dd(56);
                $this->CI->session->set_userdata("success", "Job History Updated Successfully!");
                // insert new history
                $this->insertemphistory($content_id, $emp_job_change_date,$emp_company, $emp_division, $emp_department, $emp_position, $emp_grade, $emp_type);
//                                    echo "No History";
//            exit;
                }else{
                    $res = "Invalid_effective_date";
                    return $res;
                    
//                    $params = array(
//                        'start_date'        =>  $emp_job_change_date,
//                        'division_tid'        =>  $emp_company,
//                        'department_tid'        =>  $emp_division,
//                        'department_id'        =>  $emp_department,
//                        'post_tid'        =>  $emp_position,
//                        'grade_tid'        =>  $emp_grade,
//                        'emp_type_tid'        =>  $emp_type,
//                        'updated_time'    =>  getCurrentDateTime(),
//                        'updated_by'      =>  $this->CI->session->userdata('user_id'),
//                    );  
//                    $update_condition=array('id' => $previous_id);
//                    $this->CI->emp_job_history_model->updemp_job_historytbl($params, $update_condition);
//                    $this->CI->session->set_userdata("success", "Data Updated!");
                   
                }
                }
            }else{
                $this->insertemphistory($content_id, $emp_job_change_date,$emp_company, $emp_division, $emp_department, $emp_position, $emp_grade, $emp_type);
            }
        }else{
            //$this->CI->emp_job_history_model->updemp_job_starting_date($emp_joining_date, $content_id);
        }
		

    }

    function insertemphistory($content_id, $emp_job_change_date,$emp_company, $emp_division, $emp_department, $emp_position, $emp_grade, $emp_type){
        $this->CI->load->database();
        if($emp_job_change_date){
        $params = array(
            'id'                    => '',
            'content_id'            =>  $content_id,
            'start_date'            =>  $emp_job_change_date,
            'end_date'              =>  "",
            'division_tid'          =>  $emp_company,
            'department_tid'        =>  $emp_division,
            'department_id'         =>  $emp_department,
            'post_tid'              =>  $emp_position,
            'grade_tid'             =>  $emp_grade,
            'emp_type_tid'          =>  $emp_type,
            'created_time'          =>  getCurrentDateTime(),
            'created_by'            =>  $this->CI->session->userdata('user_id'),
            'updated_time'          =>  getCurrentDateTime(),
            'updated_by'            =>  $this->CI->session->userdata('user_id'),
            'reserved1'             =>  "",
            'reserved2'             =>  "",
            );
        $this->CI->db->insert("emp_job_history",$params);
        $insert_id = $this->CI->db->insert_id();
        $this->CI->session->set_userdata("success", "Data Inserted!");
        $msg = "Data inserted";      
       }
    }

}

?>