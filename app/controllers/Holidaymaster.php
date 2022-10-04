<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Holidaymaster extends CI_Controller {

  function __construct() {
    error_reporting(0);
    parent::__construct();
    $this->load->library('session');
    if (!$this->session->userdata('logged_in')) {
      redirect('login');
    }
    
  }

  public function index() {
     redirect("holidaymaster/add_holiday");
  }
  function add_holiday($year=null, $month=null){
    $this->check_permission_controller->check_permission_action("add_holiday");
        $division_vid = 1; $department_vid = 2;
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $user_data=$this->users_model->getuserbyid($user_id);
        $user_division_id=$user_data['user_division'];
        $data['user_info']=$this->users_model->getuserbyid($user_id);
        $data['user_type_id'] =$this->session->userdata('user_type');
        if($user_type !=1){
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);        
            $data['department_selected'] = $this->taxonomy->getTaxonomychildbyparent($user_division_id); 
            $emp_last_code=$this->employee_id_model->getLastempcodebydivision($user_division_id);
            $data['tobeaddempcode']=$emp_last_code+1;            
        }else{
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        }        
        $data['alldepartment'] = $this->taxonomy->getTaxonomyByvid($department_vid);    
    if(!$year){
      $year=date('Y');
    }
    if(!$month){
      $month= date('m');
    }
    $this->load->model("mycalholiday_model");
    $searchpage="add_holiday";
    $default_emp_query=$this->search_field_emp_model->getsearchQuery($searchpage);
    $division_tid=$default_emp_query['search_query'];
    $department_tid=$default_emp_query['table_view'];
    // $department_tid=$default_emp_query['per_page'];
    // $default_emp_code=$default_emp_query['table_view'];


    $data['alldepartment'] = $this->taxonomy->getTaxonomychildbyparent($division_tid);
    $data['default_division']=$division_tid;
    $data['default_department']=$department_tid;
    // $data['default_emp_code']=$default_emp_code;
    // if($department_tid){
    //   $data['allemployee']=$this->search_field_emp_model->getallemployeebydepartment($department_tid);
    // }else 
    if($division_tid){
       $data['allemployee']=$this->search_field_emp_model->getallemployeebydivision($division_tid);
    }else{
      $data['allemployee']=$this->search_field_emp_model->getallemployee();
    }
    $data['emp_holiday']=$this->emp_holiday_model->getemp_holiday($default_emp_id['search_query']);
    $data['calendar']=$this->mycalholiday_model->generate($year, $month);
    $allleavetype_vid = 17;
    $data['allholidaytype'] = $this->taxonomy->getTaxonomyByvid($allleavetype_vid);  
    $this->load->view('recruiting/holidaymaster', $data);
  }


    public function getdepartmentidbydivisionid() {
        header('Content-type: application/json');
        $division_tid = $this->input->post('division_tid');
      //  $data['division'] = $this->taxonomy->getTaxonomychildbyparent($division_tid);
        //$data['emp'] = $this->search_field_emp_model->getallemployeebydivision($division_tid);
        $searchpage="add_holiday";
        $user_id = $this->session->userdata('user_id');
        $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
        date_default_timezone_set('Asia/Dhaka');
        $servertime = time();
        $now = date("d-m-Y", $servertime);
        $query=$division_tid;
        $params_contents = array(
          'id' => '',
          'search_query' => $query,
          'user_id' => $user_id,
          'table_view' => "",
          'per_page' => "",
          'search_page' => $searchpage,                
          'search_date' => $now,
          );
        $this->db->insert("search_query", $params_contents);   
        $default_emp_query=$this->search_field_emp_model->getsearchQuery($searchpage);
        $division_tid=$default_emp_query['search_query'];
        echo json_encode($division_tid);
    }
    public function getEmpIdByDepartmenTid() {
        header('Content-type: application/json');
        $division_tid = $this->input->post('division_tid');
        $department_tid = $this->input->post('department_tid');
      //  $data['division'] = $this->taxonomy->getTaxonomychildbyparent($division_tid);
        $data['emp'] = $this->search_field_emp_model->getAllEmployeeByDivisionAndDepartment($division_tid,$department_tid);
        $searchpage="add_holiday";
        $user_id = $this->session->userdata('user_id');
        $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
        date_default_timezone_set('Asia/Dhaka');
        $servertime = time();
        $now = date("d-m-Y", $servertime);
        $query=$division_tid;
        $params_contents = array(
          'id' => '',
          'search_query' => $query,
          'user_id' => $user_id,
          'table_view' => $department_tid,
          'per_page' => "",
          'search_page' => $searchpage,                
          'search_date' => $now,
          );
        $this->db->insert("search_query", $params_contents);   
        $default_emp_query=$this->search_field_emp_model->getsearchQuery($searchpage);
        $division_tid=$default_emp_query['search_query'];
        echo json_encode($division_tid);
    }
  public function entryHoliday(){
    header('Content-type: application/json');
    $holiday_start_date = $this->input->post('holiday_start_date');
    $holiday_end_date = $this->input->post('holiday_end_date');
    date_default_timezone_set('Asia/Dhaka');

    while (strtotime($holiday_start_date) <= strtotime($holiday_end_date)) {
     $this->add_yearlyholidaytype_controller->add_yearlyholiday_action($this->input->post(), $holiday_start_date);
     $holiday_start_date = date ("d-m-Y", strtotime("+1 day", strtotime($holiday_start_date)));
     if($holiday_start_date==$holiday_end_date){
      $this->add_yearlyholidaytype_controller->add_yearlyholiday_action($this->input->post(), $holiday_start_date);
     }
   }
   echo json_encode($this->input->post());
 }    
  public function getEmployeeholiday() {
    header('Content-type: application/json');
    $holiday_date = $this->input->post('holiday_date');
    $searchpage="add_holiday";
    $user_id = $this->session->userdata('user_id');
    $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
    $emp_division_query= $this->db->query($search_query)->row_array();    
    $division_tid=$emp_division_query['search_query'];

    if($division_tid !='all'){
  $data_queryforall = "SELECT * FROM emp_yearlyholiday WHERE holiday_for_division='all' AND holiday_start_date='$holiday_date' order by id DESC";
    $holiday_data= $this->db->query($data_queryforall)->result_array(); 
    }
  $data_query = "SELECT * FROM emp_yearlyholiday WHERE holiday_for_division='$division_tid' AND holiday_start_date='$holiday_date' order by id DESC";
    $holiday_data2= $this->db->query($data_query)->result_array(); 
    $cal_data='';
    if($holiday_data){
      $combined_array = array_merge($holiday_data, $holiday_data2);
    }else{
      $combined_array =$holiday_data2;
    }
    foreach ($combined_array as $single_data) {
      $tid=$single_data['holiday_type'];
    $vocabulary = "SELECT * FROM taxonomy WHERE id='$tid' order by id DESC limit 1";
    $holiday_query= $this->db->query($vocabulary)->row_array();      
      // $cal_data=$holiday_query['name'];
    }

    echo json_encode($holiday_query);
  }
    
}

?>