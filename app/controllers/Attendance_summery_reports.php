<?php
 
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Attendance_summery_reports extends CI_Controller {

  function __construct() {
    error_reporting(0);
    parent::__construct();
    $this->load->library('session');
    if (!$this->session->userdata('logged_in')) {
      redirect('login');
    }
    // ini_set('max_execution_time', 30000);
    
  }

  public function monthly_attendance_summery_reports(){
    $this->check_permission_controller->check_permission_action("view_attendance_summery_reports");
    $searchpage="monthlyattendancesummeryreports";         
    if($this->input->post()){
     $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
      if($this->form_validation->run()==FALSE)
      {
        $this->session->set_flashdata('errors', validation_errors());
      }else{
        $user_id = $this->session->userdata('user_id');
        $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
        date_default_timezone_set('Asia/Dhaka');
        $servertime = time();
        $now = date("d-m-Y", $servertime);
      $emp_division=$this->input->post('emp_division');
      $emp_attendance_start_date=$this->input->post('emp_attendance_start_date');              
      $emp_attendance_end_date=$this->input->post('emp_attendance_end_date');              
        $query=$emp_division;
        $params_contents = array(
          'id' => '',
          'search_query' => $query,
          'user_id' => $user_id,
          'table_view' => $emp_attendance_start_date,
          'per_page' => $emp_attendance_end_date,
          'search_page' => $searchpage,                
          'search_date' => $now,
          );
        $this->db->insert("search_query", $params_contents);                 
      }
    }        

    $default_division_id=$this->search_field_emp_model->getsearchQuery($searchpage);
    $division_id=$default_division_id['search_query'];
    $emp_att_date=$default_division_id['table_view'];
    $data['defaultdivision_id']=$default_division_id['search_query'];
    $data['defaultstart_date']=$default_division_id['table_view']; 
    $data['defaultend_date']=$default_division_id['per_page']; 
     $data['date_range']=dateRange( $default_division_id['table_view'], $default_division_id['per_page']);
    if($division_id=='all'){
      $data['default_employee']=$this->search_field_emp_model->getallemployeeorderdivision();
    }else if($division_id){
      $data['default_employee']=$this->search_field_emp_model->getallemployeebydivision($division_id); 
    } 
    $division_vid = 1; 
    $user_type = $this->session->userdata('user_type');
    $user_id = $this->session->userdata('user_id');
    $user_data=$this->users_model->getuserbyid($user_id);
    $user_division_id=$user_data['user_division'];
    $data['user_info']=$this->users_model->getuserbyid($user_id);
    $data['user_type_id'] =$this->session->userdata('user_type');
    if($user_id==14){
      $data['allemployee']=$this->search_field_emp_model->getall_left_employee();
       $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid); 
    }else if($user_type !=1){
      $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);    
      $data['allemployee']=$this->search_field_emp_model->getallemployeebydivision($user_division_id);
    }else{
      $data['allemployee']=$this->search_field_emp_model->getallemployee();
      $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid); 
    }  
    
    $this->load->view('reports/attendance/monthly_attendance_summery_report',$data);
  }    
  

}

?>