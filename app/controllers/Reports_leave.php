<?php
 
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Reports_leave extends CI_Controller {

  function __construct() {
     error_reporting(0);
    parent::__construct();
    $this->load->library('session');
    if (!$this->session->userdata('logged_in')) {
      redirect('login');
    }
   
  }
 
  public function index() {
    redirect("reports_leave/single_leave_report");
  }
   
  public function single_leave_report(){
    $this->check_permission_controller->check_permission_action("view_single_leave_reports");
    $searchpage="single_leave_report";
    if($this->input->post()){
      $this->form_validation->set_rules('emp_id', 'Employee Name', 'required');
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
      $emp_id=$this->input->post('emp_id');
      $emp_att_start_date=$this->input->post('emp_attendance_start_date');
      $content_id = $this->employee_id_model->getemp_idby_empcode($emp_id);             
        $query=$content_id;
        $params_contents = array(
          'id' => '',
          'search_query' => $query,
          'user_id' => $user_id,
          'table_view' => $emp_att_start_date,
          'per_page' => "",
          'search_page' => $searchpage,                
          'search_date' => $now,
          );
        $this->db->insert("search_query", $params_contents);                 
      }
    } 

    $default_emp_id=$this->search_field_emp_model->getsearchQuery($searchpage);
    $att_date_arr=explode("-", $default_emp_id['table_view']) ; 
    $year=$att_date_arr[2];
    $month=$att_date_arr[1];
    if(!$year){
      $year=date('Y');
    }
    if(!$month){
      $month= date('m');
    }      
    $to_date=$default_emp_id['table_view'];
    $content_id=$default_emp_id['search_query'];
    $data['defaultatt_date']=$default_emp_id['table_view'];
    $data['defaultcontent_id']=$default_emp_id['search_query'];
    $data['default_emp']=$this->search_field_emp_model->getallsearch_table_contentByid($default_emp_id['search_query']);
    $data['defaultyear']=$year;   
   $emp_atten_date="01-01-$year";
    $data['emp_total_leave'] = $this->emp_yearly_leave_history_model->getemp_yearlyleave_historybydate($default_emp_id['search_query'], $emp_atten_date);   
    $user_type = $this->session->userdata('user_type');
    $user_id = $this->session->userdata('user_id');
    $user_data=$this->users_model->getuserbyid($user_id);
    $user_division_id=$user_data['user_division'];
    $data['user_info']=$this->users_model->getuserbyid($user_id);
    $data['user_type_id'] =$this->session->userdata('user_type');
    // get all absent task start here
    $joining_date=$data['default_emp']['joining_date'];
    $joining_date_arr=explode("-", $joining_date) ; 
    $joining_year=$joining_date_arr[2];
    if($year==$joining_year){
      $date_range_beforejoining=dateRange($emp_atten_date, $joining_date);
    }
    $all_att_dates=$this->emp_attendance_model->getallattendancedate($content_id, $emp_atten_date, $to_date);
    $all_informed_dates=$this->emp_informed_model->getemp_informealldates($content_id, $emp_atten_date, $to_date);
    $all_leaved_dates=$this->emp_leave_model->getallleavedate($content_id, $emp_atten_date, $to_date);
    $all_holiday_dates=$this->emp_holiday_model->getallholidaydate($user_division_id, $emp_atten_date, $to_date);
    $final_all_dates=$all_att_dates['att_dates'].",".$all_informed_dates['informed_dates'].",".$all_leaved_dates['leave_dates'].",".$all_holiday_dates['holiday_dates'];
    $final_all_dates_arr = explode(",",$final_all_dates);
     $date_range=dateRange($emp_atten_date, $to_date);
     $total_absent_dates = array_diff($date_range, $final_all_dates_arr);
     if($date_range_beforejoining){
     $total_absent_dates = array_diff($total_absent_dates, $date_range_beforejoining);
      }
     $counter_absent=0;
     foreach ($total_absent_dates as $single_date) {
      $tstamp = strtotime($single_date);
      $dated_day_name = date("D", $tstamp);
      $dated_day_name = strtolower($dated_day_name);
      $offday_exist =$this->emp_weeklyholiday_history_model->getemp_weeklyholiday_historybydate($content_id, $single_date);

      if ($offday_exist['' . $dated_day_name . '_off'] !==  'off') {
        $counter_absent++;                                       
      }
     }
    //  if($joining_year>$year){
    //   $counter_absent=0;
    // }
    $data['total_absent'] =$counter_absent;
    // get all absent ends here;
    if($user_type !=1){
      $data['allemployee']=$this->search_field_emp_model->getallemployeebydivision($user_division_id);
    }else{
      $data['allemployee']=$this->search_field_emp_model->getallemployee();
    }
    $data['emp_holiday']=$this->emp_holiday_model->getemp_holiday($default_emp_id['search_query']);
    $allleavetype_vid = 16;
    $data['allleavetype'] = $this->taxonomy->getTaxonomyByvid($allleavetype_vid);  
    $this->load->view('reports/attendance/leave_report_single',$data);
  } 
  public function single_leave_report2(){
    $this->check_permission_controller->check_permission_action("add_leave");
    $searchpage="single_leave_report2";
    if($this->input->post()){
      $this->form_validation->set_rules('emp_name', 'Name', 'required');
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
      $emp_id=$this->input->post('emp_id');
      $emp_att_start_date=$this->input->post('emp_attendance_start_date');
      $content_id = $this->employee_id_model->getemp_idby_empcode($emp_id);             
        $query=$content_id;
        $params_contents = array(
          'id' => '',
          'search_query' => $query,
          'user_id' => $user_id,
          'table_view' => $emp_att_start_date,
          'per_page' => "",
          'search_page' => $searchpage,                
          'search_date' => $now,
          );
        $this->db->insert("search_query", $params_contents);                 
      }
    } 

    $default_emp_id=$this->search_field_emp_model->getsearchQuery($searchpage);
    $att_date_arr=explode("-", $default_emp_id['table_view']) ; 
    $year=$att_date_arr[2];
    $month=$att_date_arr[1];
    if(!$year){
      $year=date('Y');
    }
    if(!$month){
      $month= date('m');
    }      
    $data['defaultatt_date']=$default_emp_id['table_view'];
    $data['defaultcontent_id']=$default_emp_id['search_query'];
    $data['default_emp']=$this->search_field_emp_model->getallsearch_table_contentByid($default_emp_id['search_query']);
    $data['defaultyear']=$year;   
   $emp_atten_date="01-01-$year";
    $data['emp_total_leave'] = $this->emp_yearly_leave_history_model->getemp_yearlyleave_historybydate($default_emp_id['search_query'], $emp_atten_date);   
    $user_type = $this->session->userdata('user_type');
    $user_id = $this->session->userdata('user_id');
    $user_data=$this->users_model->getuserbyid($user_id);
    $user_division_id=$user_data['user_division'];
    $data['user_info']=$this->users_model->getuserbyid($user_id);
    $data['user_type_id'] =$this->session->userdata('user_type');
    if($user_type !=1){
      $data['allemployee']=$this->search_field_emp_model->getallemployeebydivision($user_division_id);
    }else{
      $data['allemployee']=$this->search_field_emp_model->getallemployee();
    }
    $data['emp_holiday']=$this->emp_holiday_model->getemp_holiday($default_emp_id['search_query']);
    $allleavetype_vid = 16;
    $data['allleavetype'] = $this->taxonomy->getTaxonomyByvid($allleavetype_vid);  
    $this->load->view('reports/attendance/leave_report_single2',$data);
  }  
  public function total_absent_reports(){
    $this->check_permission_controller->check_permission_action("view_absent_reports_single");
    $searchpage="total_absent_reports";
    if($this->input->post()){
      $this->form_validation->set_rules('emp_name', 'Name', 'required');
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
      $emp_id=$this->input->post('emp_id');
      $emp_att_start_date=$this->input->post('emp_attendance_start_date');
      $content_id = $this->employee_id_model->getemp_idby_empcode($emp_id);             
        $query=$content_id;
        $params_contents = array(
          'id' => '',
          'search_query' => $query,
          'user_id' => $user_id,
          'table_view' => $emp_att_start_date,
          'per_page' => "",
          'search_page' => $searchpage,                
          'search_date' => $now,
          );
        $this->db->insert("search_query", $params_contents);                 
      }
    } 

    $default_emp_id=$this->search_field_emp_model->getsearchQuery($searchpage);
    $att_date_arr=explode("-", $default_emp_id['table_view']) ; 
    $year=$att_date_arr[2];
    $month=$att_date_arr[1];
    if(!$year){
      $year=date('Y');
    }
    if(!$month){
      $month= date('m');
    }      
    $to_date=$default_emp_id['table_view'];
    $content_id=$default_emp_id['search_query'];
    $data['defaultatt_date']=$default_emp_id['table_view'];
    $data['defaultcontent_id']=$default_emp_id['search_query'];
    $data['default_emp']=$this->search_field_emp_model->getallsearch_table_contentByid($default_emp_id['search_query']);
    $data['defaultyear']=$year;   
   $emp_atten_date="01-01-$year";
    $data['emp_total_leave'] = $this->emp_yearly_leave_history_model->getemp_yearlyleave_historybydate($default_emp_id['search_query'], $emp_atten_date);   
    $user_type = $this->session->userdata('user_type');
    $user_id = $this->session->userdata('user_id');
    $user_data=$this->users_model->getuserbyid($user_id);
    $user_division_id=$user_data['user_division'];
    $data['user_info']=$this->users_model->getuserbyid($user_id);
    $data['user_type_id'] =$this->session->userdata('user_type');
    // get all absent task start here
    $joining_date=$data['default_emp']['joining_date'];
    $joining_date_arr=explode("-", $joining_date) ; 
    $joining_year=$joining_date_arr[2];
    if($year==$joining_year){
      $date_range_beforejoining=dateRange($emp_atten_date, $joining_date);
    }
    $all_att_dates=$this->emp_attendance_model->getallattendancedate($content_id, $emp_atten_date, $to_date);
    $all_informed_dates=$this->emp_informed_model->getemp_informealldates($content_id, $emp_atten_date, $to_date);
    $all_leaved_dates=$this->emp_leave_model->getallleavedate($content_id, $emp_atten_date, $to_date);
    $all_holiday_dates=$this->emp_holiday_model->getallholidaydate($user_division_id, $emp_atten_date, $to_date);
    $final_all_dates=$all_att_dates['att_dates'].",".$all_informed_dates['informed_dates'].",".$all_leaved_dates['leave_dates'].",".$all_holiday_dates['holiday_dates'];
    $final_all_dates_arr = explode(",",$final_all_dates);
     $date_range=dateRange($emp_atten_date, $to_date);
     $total_absent_dates = array_diff($date_range, $final_all_dates_arr);
     if($date_range_beforejoining){
       $total_absent_dates = array_diff($total_absent_dates, $date_range_beforejoining);
     }
     $data['total_abs_dates']=$total_absent_dates;
     $counter_absent=0;
     foreach ($total_absent_dates as $single_date) {
      $tstamp = strtotime($single_date);
      $dated_day_name = date("D", $tstamp);
      $dated_day_name = strtolower($dated_day_name);
      $offday_exist =$this->emp_weeklyholiday_history_model->getemp_weeklyholiday_historybydate($content_id, $single_date);
      if ($offday_exist['' . $dated_day_name . '_off'] != 'off') {
        $counter_absent++;                                       
      }
     }
     if($joining_year>$year){
      $counter_absent=0;
    }
    $data['total_absent'] =$counter_absent;
    // get all absent ends here;
    if($user_type !=1){
      $data['allemployee']=$this->search_field_emp_model->getallemployeebydivision($user_division_id);
    }else{
      $data['allemployee']=$this->search_field_emp_model->getallemployee();
    }
    $data['emp_holiday']=$this->emp_holiday_model->getemp_holiday($default_emp_id['search_query']);
    $allleavetype_vid = 16;
    $data['allleavetype'] = $this->taxonomy->getTaxonomyByvid($allleavetype_vid);  
    $this->load->view('reports/attendance/absent_report_single',$data);
  }   
  public function daily_leave_report(){
    $this->check_permission_controller->check_permission_action("view_daily_leave_reports");
    $searchpage="daily_leave_report";
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
        $query=$emp_division;
        $params_contents = array(
          'id' => '',
          'search_query' => $query,
          'user_id' => $user_id,
          'table_view' => $emp_attendance_start_date,
          'per_page' => "",
          'search_page' => $searchpage,                
          'search_date' => $now,
          );
        $this->db->insert("search_query", $params_contents);                 
      }
    }       

    $division_vid = 1; 
    $user_type = $this->session->userdata('user_type');
    $user_id = $this->session->userdata('user_id');
    $user_data=$this->users_model->getuserbyid($user_id);
    $user_division_id=$user_data['user_division'];
    $data['user_info']=$this->users_model->getuserbyid($user_id);
    $data['user_type_id'] =$this->session->userdata('user_type');
    if($user_type !=1){
      $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);    
      $data['allemployee']=$this->search_field_emp_model->getallemployeebydivision($user_division_id);
    }else{
      $data['allemployee']=$this->search_field_emp_model->getallemployee();
      $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid); 
    }         

    $default_division_id=$this->search_field_emp_model->getsearchQuery($searchpage);
    $division_id=$default_division_id['search_query'];
    $emp_att_date=$default_division_id['table_view'];
    $data['defaultdivision_id']=$default_division_id['search_query'];
    $data['default_date']=$default_division_id['table_view']; 
    if($division_id=='all'){
      $data['default_employee']=$this->emp_leave_model->getemp_spentleavebydate($emp_att_date);
    }else if($division_id){
      $today_leaved_emp=$this->emp_leave_model->getemp_spentleavebydate($emp_att_date);
      $leaved_emp_ids="";
      $counter_emp=1;
      foreach ($today_leaved_emp as $single_emp) {
        if($single_emp['content_id'] && $counter_emp==1){
          $leaved_emp_ids .=$single_emp['content_id'];
        }else if($single_emp['content_id']){
          $leaved_emp_ids .=",".$single_emp['content_id'];
        }
       $counter_emp++;
      }
      $data['default_employee']=$this->search_field_emp_model->getallemployeebydivisionandids($division_id, $leaved_emp_ids); 
    }    
    $this->load->view('reports/attendance/dailyleavereport',$data);
  }   
  public function leavesummeryreport(){
    //$this->check_permission_controller->check_permission_action("view_monthly_attendance");
    $searchpage="leavesummeryreport";         
    if($this->input->post()){
      $this->form_validation->set_rules('emp_name', 'Name', 'required');
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
      $codes=$this->input->post('emp_name');    
      $emp_codes_string = rtrim(implode(',', $codes), ',');                              
        $query=$emp_division;
        $params_contents = array(
          'id' => '',
          'search_query' => $query,
          'user_id' => $user_id,
          'table_view' => $emp_attendance_start_date,
          'per_page' => $emp_codes_string,
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
    $data['default_date']=$default_division_id['table_view']; 
    $emp_codes_query=$default_division_id['per_page']; 
    $data['emp_codes']= explode(",", $emp_codes_query); 
    if($division_id=='all'){
      $data['defsultdivision_name']="All";
      $data['defsultdivision_shortname']="All";
      $data['default_employee']=$this->search_field_emp_model->getallemployeeorderdivision();
    }else if($division_id){
       $emp_division=$this->taxonomy->getTaxonomyBytid($division_id);
      $data['defsultdivision_name']=$emp_division['name'];
      $data['defsultdivision_shortname']=$emp_division['keywords']; 
      $data['default_employee']=$this->search_field_emp_model->getallemployeebydivision($division_id); 
    } 
    $division_vid = 1; 
    $user_type = $this->session->userdata('user_type');
    $user_id = $this->session->userdata('user_id');
    $user_data=$this->users_model->getuserbyid($user_id);
    $user_division_id=$user_data['user_division'];
    $data['user_info']=$this->users_model->getuserbyid($user_id);
    $data['user_type_id'] =$this->session->userdata('user_type');
    if($user_type !=1){
      $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);    
      $data['allemployee']=$this->search_field_emp_model->getallemployeebydivision($user_division_id);
    }else{
      $data['allemployee']=$this->search_field_emp_model->getallemployee();
      $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid); 
    }  
    
    $this->load->view('reports/attendance/leavesummeryreport',$data);
  }

}

?>