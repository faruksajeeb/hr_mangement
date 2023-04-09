<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports extends CI_Controller {

    function __construct() {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        // ini_set('max_execution_time', 30000);
    }

    public function index() {
        redirect("reports/monthlyattendancereports");
    }

    public function monthlyattendancereports() {
        $this->check_permission_controller->check_permission_action("view_monthly_attendance");
        $searchpage = "monthlyattendancereports";
        if ($this->input->post()) {
            $this->form_validation->set_rules('emp_name', 'Name', 'required');
            $this->form_validation->set_rules('emp_id', 'Employee Code', 'required');
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                $user_id = $this->session->userdata('user_id');
                $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
                date_default_timezone_set('Asia/Dhaka');
                $servertime = time();
                $now = date("d-m-Y", $servertime);
                $emp_id = $this->input->post('emp_id');
                $emp_att_start_date = $this->input->post('emp_attendance_start_date');
                $emp_att_end_date = $this->input->post('emp_attendance_end_date');
                $content_id = $this->employee_id_model->getemp_idby_empcode($emp_id);
                $query = $content_id;
                $params_contents = array(
                    'id' => '',
                    'search_query' => $query,
                    'user_id' => $user_id,
                    'table_view' => $emp_att_start_date,
                    'per_page' => $emp_att_end_date,
                    'search_page' => $searchpage,
                    'search_date' => $now,
                );
                $this->db->insert("search_query", $params_contents);
            }
        }
        $default_emp_id = $this->search_field_emp_model->getsearchQuery($searchpage);

        $content_id = $default_emp_id['search_query'];
        $emp_att_start_date = $default_emp_id['table_view'];
        $emp_att_end_date = $default_emp_id['per_page'];
        $data['defaultcontent_id'] = $default_emp_id['search_query'];
        $data['defaultstart_date'] = $default_emp_id['table_view'];
        $data['defaultend_date'] = $default_emp_id['per_page'];
        $data['default_emp'] = $this->search_field_emp_model->getallsearch_table_contentByid($default_emp_id['search_query']);
        $emp_details = $this->search_field_emp_model->getallsearch_table_contentByid($content_id);
        $data['emp_details_info'] = $this->search_field_emp_model->getallsearch_table_contentByid($content_id);
        $data['emp_working_time'] = $this->emp_working_time_model->getcontentByid($content_id);
        $data['emp_division'] = $this->taxonomy->getTaxonomyBytid($emp_details['emp_division']);
        $data['date_range'] = dateRange($emp_att_start_date, $emp_att_end_date);
        $data['emp_content_id'] = $content_id;
        $data['emp_attendance'] = $this->emp_attendance_model->getemp_attbyrange($content_id, $emp_att_start_date, $emp_att_end_date);

        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $user_data = $this->users_model->getuserbyid($user_id);
        $user_division_id = $user_data['user_division'];
        $data['user_info'] = $this->users_model->getuserbyid($user_id);
        $data['user_type_id'] = $this->session->userdata('user_type');
        if ($user_id == 14) {
            $data['allemployee'] = $this->search_field_emp_model->getall_left_employee();
        } else if ($user_type != 1) {
            $emp_ids_data = $this->users_model->getpermittedemployee($user_id);
            $content_ids = $emp_ids_data['emp_content_ids'];
            if ($user_id == 16 || $user_id == 36) {
                $data['allemployee'] = $this->search_field_emp_model->getallemployee();
            } else {
                $data['allemployee'] = $this->search_field_emp_model->getallsearch_table_contentByids($content_ids);
            }
        } else {
            $data['allemployee'] = $this->search_field_emp_model->getallemployee();
        }

        $this->load->view('reports/attendance/monthlyattendancereport', $data);
    }

    public function monthlyAttendance() {
//       echo"Heloo"; 
//       print_r($this->input->post());
//       exit;
        $this->check_permission_controller->check_permission_action("view_monthly_attendance");
        $searchpage = "monthlyattendancereports";

        if ($this->input->post()) {

            $this->form_validation->set_rules('emp_name', 'Name', 'required');
            $this->form_validation->set_rules('emp_id', 'Employee Code', 'required');
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                $user_id = $this->session->userdata('user_id');
                $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
                date_default_timezone_set('Asia/Dhaka');
                $servertime = time();
                $now = date("d-m-Y", $servertime);
                $emp_id = $this->input->post('emp_id');

                $emp_att_start_date = $this->input->post('emp_attendance_start_date');
                $emp_att_end_date = $this->input->post('emp_attendance_end_date');
                $content_id = $this->employee_id_model->getemp_idby_empcode($emp_id);

                $query = $content_id;
                $params_contents = array(
                    'id' => '',
                    'search_query' => $query,
                    'user_id' => $user_id,
                    'table_view' => $emp_att_start_date,
                    'per_page' => $emp_att_end_date,
                    'search_page' => $searchpage,
                    'search_date' => $now,
                );
                $this->db->insert("search_query", $params_contents);
            }
        }
        $data['emp_details_info'] = $this->search_field_emp_model->get_emp_info_by_contentid($content_id, $emp_att_end_date);
//    echo "<pre>";
//    echo  $data['emp_details_info'];
//    print_r($data);
//    exit;
        $data['content_id'] = $content_id;
        $data['date_range'] = dateRange($emp_att_start_date, $emp_att_end_date);
        $data['emp_content_id'] = $content_id;
        $this->load->view('reports/attendance/monthly_attendance_single', $data);
    }
    public function dailyAttendance(){
       
        $this->check_permission_controller->check_permission_action("view_daily_attendance_reports");
        $searchpage = "dailyattendancereports";
        if ($this->input->post()) {
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Date', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                $user_id = $this->session->userdata('user_id');
                $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
                date_default_timezone_set('Asia/Dhaka');
                $servertime = time();
                $now = date("d-m-Y", $servertime);
                $empCompanyId = $this->input->post('emp_company');
                $empDivisionId = $this->input->post('emp_division');
                $emp_attendance_start_date = $this->input->post('emp_attendance_start_date');
                
                $data['defaultdivision_id'] = $empCompanyId;
                $data['default_date'] = $emp_attendance_start_date;
                if ($empCompanyId && $empDivisionId == '') {
                    // echo $empDivisionId; exit;
                    $data['default_employee'] = $this->search_field_emp_model->getallemployeebydivision($empCompanyId);
                } else if($empCompanyId &&  $empDivisionId){
                    $data['default_employee'] = $this->search_field_emp_model->getAllEmployeeByDivisionAndDepartment($empCompanyId,$empDivisionId);
                }
    
            }
            
        }
        $this->load->view('reports/attendance/daily_attendance_report', $data);
    }

    public function monthlyattendancereportsmultiple() {
        $this->check_permission_controller->check_permission_action("view_attendance_reports_multiple");
        $division_vid = 1;
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $user_data = $this->users_model->getuserbyid($user_id);
        $user_division_id = $user_data['user_division'];
        $data['user_info'] = $this->users_model->getuserbyid($user_id);
        $data['user_type_id'] = $this->session->userdata('user_type');
        if ($user_id == 14) {
            $data['allemployee'] = $this->search_field_emp_model->getall_left_employee();
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        } else if ($user_type != 1) {
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);
            // $data['allemployee']=$this->search_field_emp_model->getallemployeebydivision($user_division_id);
            $emp_ids_data = $this->users_model->getpermittedemployee($user_id);
            $content_ids = $emp_ids_data['emp_content_ids'];
            $data['allemployee'] = $this->search_field_emp_model->getallsearch_table_contentByids($content_ids);
        } else {
            $data['allemployee'] = $this->search_field_emp_model->getallemployee();
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        }
        $this->load->view('reports/attendance/multiplemonthlyattendancereport', $data);
    }

    public function dailyattendancereports() {
        $this->check_permission_controller->check_permission_action("view_daily_attendance_reports");
        $searchpage = "dailyattendancereports";
        if ($this->input->post()) {
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                $user_id = $this->session->userdata('user_id');
                $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
                date_default_timezone_set('Asia/Dhaka');
                $servertime = time();
                $now = date("d-m-Y", $servertime);
                $empCompanyId = $this->input->post('emp_company');
                $empDivisionId = $this->input->post('emp_division');
                $emp_attendance_start_date = $this->input->post('emp_attendance_start_date');
                
                $data['defaultdivision_id'] = $empCompanyId;
                $data['default_date'] = $emp_attendance_start_date;
                if ($empCompanyId && $empDivisionId == '') {
                    // echo $empDivisionId; exit;
                    $data['default_employee'] = $this->search_field_emp_model->getallemployeebydivision($empCompanyId);
                } else if($empCompanyId &&  $empDivisionId){
                    $data['default_employee'] = $this->search_field_emp_model->getAllEmployeeByDivisionAndDepartment($empCompanyId,$empDivisionId);
                }
    //        print_r($data['default_employee']);
    //        exit;
            }
            
        }

        $division_vid = 1;
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $user_data = $this->users_model->getuserbyid($user_id);
        $user_division_id = $user_data['user_division'];
        $data['user_info'] = $this->users_model->getuserbyid($user_id);
        $data['user_type_id'] = $this->session->userdata('user_type');
        if ($user_id == 14) {
            $data['allemployee'] = $this->search_field_emp_model->getall_left_employee();
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        } else if ($user_type != 1) {
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);
            $data['allemployee'] = $this->search_field_emp_model->getallemployeebydivision($user_division_id);
        } else {
            $data['allemployee'] = $this->search_field_emp_model->getallemployee();
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        }

        
        $this->load->view('reports/attendance/dailyattendancereport', $data);
    }

    public function dailylatereports() {
        $this->check_permission_controller->check_permission_action("view_daily_late_reports");
        $searchpage = "dailylatereports";
        if ($this->input->post()) {
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                $user_id = $this->session->userdata('user_id');
                $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
                date_default_timezone_set('Asia/Dhaka');
                $servertime = time();
                $now = date("d-m-Y", $servertime);
                $emp_division = $this->input->post('emp_division');
                $emp_attendance_start_date = $this->input->post('emp_attendance_start_date');
                $query = $emp_division;
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
        $user_data = $this->users_model->getuserbyid($user_id);
        $user_division_id = $user_data['user_division'];
        $data['user_info'] = $this->users_model->getuserbyid($user_id);
        $data['user_type_id'] = $this->session->userdata('user_type');
        if ($user_type != 1) {
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);
            $data['allemployee'] = $this->search_field_emp_model->getallemployeebydivision($user_division_id);
        } else {
            $data['allemployee'] = $this->search_field_emp_model->getallemployee();
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        }

        $default_division_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $division_id = $default_division_id['search_query'];
        $emp_att_date = $default_division_id['table_view'];
        $data['defaultdivision_id'] = $default_division_id['search_query'];
        $data['default_date'] = $default_division_id['table_view'];
        if ($division_id == 'all') {
            $data['default_employee'] = $this->search_field_emp_model->getallemployeeorderdivision();
        } else if ($division_id) {
            $data['default_employee'] = $this->search_field_emp_model->getallemployeebydivision($division_id);
        }
        $this->load->view('reports/attendance/dailylatereport', $data);
    }

    public function holidayreports() {
        $this->check_permission_controller->check_permission_action("view_holiday_reports");
        $searchpage = "holidayreports";
        if ($this->input->post()) {
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                $user_id = $this->session->userdata('user_id');
                $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
                date_default_timezone_set('Asia/Dhaka');
                $servertime = time();
                $now = date("d-m-Y", $servertime);
                $emp_division = $this->input->post('emp_division');
                $emp_attendance_start_date = $this->input->post('emp_attendance_start_date');
                $query = $emp_division;
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
        $user_data = $this->users_model->getuserbyid($user_id);
        $user_division_id = $user_data['user_division'];
        $data['user_info'] = $this->users_model->getuserbyid($user_id);
        $data['user_type_id'] = $this->session->userdata('user_type');
        if ($user_type != 1) {
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);
        } else {
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        }

        $default_division_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $division_id = $default_division_id['search_query'];
        $holiday_year = $default_division_id['table_view'];
        $data['defaultdivision_id'] = $default_division_id['search_query'];
        $data['default_year'] = $default_division_id['table_view'];
        if ($division_id == "all") {
            $data['default_holidays'] = $this->emp_holiday_model->getemp_yearlyallholiday($holiday_year);
        } else {
            $data['default_holidays'] = $this->emp_holiday_model->getemp_yearlytotalholiday($division_id, $holiday_year);
        }
        $this->load->view('reports/attendance/holidayreport', $data);
    }

    public function dailyabsentreports() {
        $this->check_permission_controller->check_permission_action("view_daily_absent_reports");
        $searchpage = "dailyabsentreports";
        if ($this->input->post()) {
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                $user_id = $this->session->userdata('user_id');
                $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
                date_default_timezone_set('Asia/Dhaka');
                $servertime = time();
                $now = date("d-m-Y", $servertime);
                $emp_division = $this->input->post('emp_division');
                $emp_attendance_start_date = $this->input->post('emp_attendance_start_date');
                $query = $emp_division;
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
        $user_data = $this->users_model->getuserbyid($user_id);
        $user_division_id = $user_data['user_division'];
        $data['user_info'] = $this->users_model->getuserbyid($user_id);
        $data['user_type_id'] = $this->session->userdata('user_type');
        if ($user_type != 1) {
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);
            $data['allemployee'] = $this->search_field_emp_model->getallemployeebydivision($user_division_id);
        } else {
            $data['allemployee'] = $this->search_field_emp_model->getallemployee();
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        }

        $default_division_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $division_id = $default_division_id['search_query'];
        $emp_att_date = $default_division_id['table_view'];
        $data['defaultdivision_id'] = $default_division_id['search_query'];
        $data['default_date'] = $default_division_id['table_view'];
        if ($division_id == 'all') {
            $data['default_employee'] = $this->search_field_emp_model->getallemployeeorderdivision();
        } else if ($division_id) {
            $data['default_employee'] = $this->search_field_emp_model->getallemployeebydivision($division_id);
        }
        $this->load->view('reports/attendance/dailyabsentreport', $data);
    }

    public function dailyearlyreports() {
        $this->check_permission_controller->check_permission_action("view_daily_early_reports");
        $searchpage = "dailyearlyreports";
        if ($this->input->post()) {
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                $user_id = $this->session->userdata('user_id');
                $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
                date_default_timezone_set('Asia/Dhaka');
                $servertime = time();
                $now = date("d-m-Y", $servertime);
                $emp_division = $this->input->post('emp_division');
                $emp_attendance_start_date = $this->input->post('emp_attendance_start_date');
                $query = $emp_division;
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
        $user_data = $this->users_model->getuserbyid($user_id);
        $user_division_id = $user_data['user_division'];
        $data['user_info'] = $this->users_model->getuserbyid($user_id);
        $data['user_type_id'] = $this->session->userdata('user_type');
        if ($user_type != 1) {
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);
            $data['allemployee'] = $this->search_field_emp_model->getallemployeebydivision($user_division_id);
        } else {
            $data['allemployee'] = $this->search_field_emp_model->getallemployee();
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        }

        $default_division_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $division_id = $default_division_id['search_query'];
        $emp_att_date = $default_division_id['table_view'];
        $data['defaultdivision_id'] = $default_division_id['search_query'];
        $data['default_date'] = $default_division_id['table_view'];
        if ($division_id == 'all') {
            $data['default_employee'] = $this->search_field_emp_model->getallemployeeorderdivision();
        } else if ($division_id) {
            $data['default_employee'] = $this->search_field_emp_model->getallemployeebydivision($division_id);
        }
        $this->load->view('reports/attendance/dailyearlyreport', $data);
    }

    public function informedreports() {
        $this->check_permission_controller->check_permission_action("view_attendance_informed_reports");
        $searchpage = "informedreports";
        if ($this->input->post()) {
            // $this->form_validation->set_rules('emp_name', 'Name', 'required');
            $this->form_validation->set_rules('emp_id', 'Employee Code', 'required');
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                $user_id = $this->session->userdata('user_id');
                $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
                date_default_timezone_set('Asia/Dhaka');
                $servertime = time();
                $now = date("d-m-Y", $servertime);
                $emp_id = $this->input->post('emp_id');
                $emp_att_start_date = $this->input->post('emp_attendance_start_date');
                $emp_att_end_date = $this->input->post('emp_attendance_end_date');
                $content_id = $this->employee_id_model->getemp_idby_empcode($emp_id);
                $query = $content_id;
                $params_contents = array(
                    'id' => '',
                    'search_query' => $query,
                    'user_id' => $user_id,
                    'table_view' => $emp_att_start_date,
                    'per_page' => $emp_att_end_date,
                    'search_page' => $searchpage,
                    'search_date' => $now,
                );
                $this->db->insert("search_query", $params_contents);
            }
        }
        $default_emp_id = $this->search_field_emp_model->getsearchQuery($searchpage);

        $content_id = $default_emp_id['search_query'];
        $emp_att_start_date = $default_emp_id['table_view'];
        $emp_att_end_date = $default_emp_id['per_page'];
        $data['defaultcontent_id'] = $default_emp_id['search_query'];
        $data['defaultstart_date'] = $default_emp_id['table_view'];
        $data['defaultend_date'] = $default_emp_id['per_page'];
        $data['default_emp'] = $this->search_field_emp_model->getallsearch_table_contentByid($default_emp_id['search_query']);
        $emp_details = $this->search_field_emp_model->getallsearch_table_contentByid($content_id);
        $data['emp_details_info'] = $this->search_field_emp_model->getallsearch_table_contentByid($content_id);
        $data['emp_working_time'] = $this->emp_working_time_model->getcontentByid($content_id);
        $data['emp_division'] = $this->taxonomy->getTaxonomyBytid($emp_details['emp_division']);
        $data['date_range'] = dateRange($emp_att_start_date, $emp_att_end_date);
        $data['informed'] = $this->emp_informed_model->getemp_informedbyrange($content_id, $emp_att_start_date, $emp_att_end_date);
        $data['emp_content_id'] = $content_id;
        $data['emp_attendance'] = $this->emp_attendance_model->getemp_attbyrange($content_id, $emp_att_start_date, $emp_att_end_date);
        $data['allemployee'] = $this->search_field_emp_model->getallemployee();
        $this->load->view('reports/attendance/empinformedreport', $data);
    }

    public function logerrorreports() {
        $this->check_permission_controller->check_permission_action("view_attendance_log_reports");
        $searchpage = "logerrorreports";
        if ($this->input->post()) {
           
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
               
                $user_id = $this->session->userdata('user_id');
                $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
                date_default_timezone_set('Asia/Dhaka');
                $servertime = time();
                $now = date("d-m-Y", $servertime);
                $emp_att_start_date = $this->input->post('emp_attendance_start_date');
                $emp_att_end_date = $this->input->post('emp_attendance_end_date');
              
                $params_contents = array(
                    'id' => '',
                    'search_query' => "",
                    'user_id' => $user_id,
                    'table_view' => $emp_att_start_date,
                    'per_page' => $emp_att_end_date,
                    'search_page' => $searchpage,
                    'search_date' => $now,
                );
                $this->db->insert("search_query", $params_contents);
            }
        }
        $default_emp_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $emp_att_start_date = $default_emp_id['table_view'];
        $emp_att_end_date = $default_emp_id['per_page'];
        $data['defaultstart_date'] = $default_emp_id['table_view'];
        $data['defaultend_date'] = $default_emp_id['per_page'];
        $data['date_range'] = dateRange($emp_att_start_date, $emp_att_end_date);
        $data['logederrors'] = $this->log_maintenence_model->getemp_logedbyrange($emp_att_start_date, $emp_att_end_date);
       # dd($data['logederrors']);
        $this->load->view('reports/attendance/logerrorreport', $data);
    }

    public function getempbydivisionid() {
        header('Content-type: application/json');
        $division_tid = $this->input->post('division_tid');
        $user_id = $this->session->userdata('user_id');

        if ($user_id == 14 && $division_tid == 'all') {
            $data['allemployee'] = $this->search_field_emp_model->getall_left_employee();
        }if ($user_id == 14) {
            $data['allemployee'] = $this->search_field_emp_model->getall_left_employeeorderdivision();
        } else if ($division_tid == 'all') {
            $data['allemployee'] = $this->search_field_emp_model->getallemployee();
        } else {
            $data['allemployee'] = $this->search_field_emp_model->getallemployeebydivision($division_tid);
        }
        // $division_tid = 16;
        echo json_encode($data['allemployee']);
    }

    public function monthlyattendancesummeryreports() {
        
    }

    public function leavesummeryreport() {
        $this->check_permission_controller->check_permission_action("view_leave_summery_reports");
        $searchpage = "leavesummeryreport";
        if ($this->input->post()) {
            $this->form_validation->set_rules('emp_name', 'Name', 'required');
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                $user_id = $this->session->userdata('user_id');
                $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
                date_default_timezone_set('Asia/Dhaka');
                $servertime = time();
                $now = date("d-m-Y", $servertime);
                $emp_division = $this->input->post('emp_division');
                $emp_attendance_start_date = $this->input->post('emp_attendance_start_date');
                $codes = $this->input->post('emp_name');
                $emp_codes_string = rtrim(implode(',', $codes), ',');
                $query = $emp_division;
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
        $default_division_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $division_id = $default_division_id['search_query'];
        $emp_att_date = $default_division_id['table_view'];
        $data['defaultdivision_id'] = $default_division_id['search_query'];
        $data['defaultstart_date'] = $default_division_id['table_view'];
        $data['default_date'] = $default_division_id['table_view'];
        $emp_codes_query = $default_division_id['per_page'];
        $data['emp_codes'] = explode(",", $emp_codes_query);
        if ($division_id == 'all') {
            $data['defsultdivision_name'] = "All";
            $data['defsultdivision_shortname'] = "All";
            $data['default_employee'] = $this->search_field_emp_model->getallemployeeorderdivision();
        } else if ($division_id) {
            $emp_division = $this->taxonomy->getTaxonomyBytid($division_id);
            $data['defsultdivision_name'] = $emp_division['name'];
            $data['defsultdivision_shortname'] = $emp_division['keywords'];
            $data['default_employee'] = $this->search_field_emp_model->getallemployeebydivision($division_id);
        }
        $division_vid = 1;
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $user_data = $this->users_model->getuserbyid($user_id);
        $user_division_id = $user_data['user_division'];
        $data['user_info'] = $this->users_model->getuserbyid($user_id);
        $data['user_type_id'] = $this->session->userdata('user_type');
        if ($user_id == 14) {
            $data['allemployee'] = $this->search_field_emp_model->getall_left_employee();
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);
        } else if ($user_type != 1) {
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);
            // $data['allemployee']=$this->search_field_emp_model->getallemployeebydivision($user_division_id);
            $emp_ids_data = $this->users_model->getpermittedemployee($user_id);
            $content_ids = $emp_ids_data['emp_content_ids'];
            $data['allemployee'] = $this->search_field_emp_model->getallsearch_table_contentByids($content_ids);
        } else {
            $data['allemployee'] = $this->search_field_emp_model->getallemployee();
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        }

        $this->load->view('reports/attendance/leavesummeryreport', $data);
    }

    public function resume() {
        $this->check_permission_controller->check_permission_action("view_resume");
        $searchpage = "resume";
        if ($this->input->post()) {
            $this->form_validation->set_rules('emp_name', 'Name', 'required');
            //$this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                $user_id = $this->session->userdata('user_id');
                $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
                date_default_timezone_set('Asia/Dhaka');
                $servertime = time();
                $now = date("d-m-Y", $servertime);
                $emp_id = $this->input->post('emp_id');
                // $emp_att_start_date=$this->input->post('emp_attendance_start_date');
                $content_id = $this->employee_id_model->getemp_idby_empcode($emp_id);
                $query = $content_id;
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
            }
        }

        $default_emp_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $data['defaultcontent_id'] = $default_emp_id['search_query'];
        $data['default_emp'] = $this->search_field_emp_model->getallsearch_table_contentByid($default_emp_id['search_query']);
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $user_data = $this->users_model->getuserbyid($user_id);
        $user_division_id = $user_data['user_division'];
        $data['user_info'] = $this->users_model->getuserbyid($user_id);
        $data['user_type_id'] = $this->session->userdata('user_type');
        if ($user_type != 1) {
            $data['allemployee'] = $this->search_field_emp_model->getallemployeebydivision($user_division_id);
        } else {
            $data['allemployee'] = $this->search_field_emp_model->getallemployee();
        }
        $data['allhistory'] = $this->emp_job_history_model->getalljobhistorybyasc($default_emp_id['search_query']);
        $this->load->view('reports/resume', $data);
    }

}

?>