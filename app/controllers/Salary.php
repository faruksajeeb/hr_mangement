<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Salary extends CI_Controller {

    function __construct() {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->helper(array('form', 'url'));
        $this->load->library('pagination');
        $this->load->library("pdf");
         //$ci=& get_instance();
      //  $this->CI->load->database();
       // $this->CI->load->model('emp_salary_model');
    }

    public function index() {
        redirect("salary/salaryhistorysingle");
    }

    public function save_payroll() {
        $post_data = $this->input->post();
      
        $content_id = $post_data['content_id'];
        $res1=$this->add_salary_controller->add_salary_action($post_data, $content_id);
        $res2=$this->add_salarydeduction_controller->add_deduction_action($post_data, $content_id);
        $this->add_paymentmethod_controller->add_paymentmethod_action($post_data, $content_id);    
       
            $this->session->set_userdata('add_status',$res1."<br/>".$res2);
            redirect('findemployeelist/contentwithpagination');
       
    }

    public function salaryhistorysingle() {
        $this->check_permission_controller->check_permission_action("view_salary_history");
        $searchpage = "salaryhistorysingle";
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
        $att_date_arr = explode("-", $default_emp_id['search_query']);

        $data['defaultcontent_id'] = $default_emp_id['search_query'];
        $data['default_emp'] = $this->search_field_emp_model->getallsearch_table_contentByid($default_emp_id['search_query']);
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $user_data = $this->users_model->getuserbyid($user_id);
        $user_division_id = $user_data['user_division'];
        $data['user_info'] = $this->users_model->getuserbyid($user_id);
        $data['user_type_id'] = $this->session->userdata('user_type');
        if ($user_type != 1) {
            if($user_id==16 || $user_id==36){
                $data['allemployee'] = $this->search_field_emp_model->getallemployee();
            }else{
                $data['allemployee'] = $this->search_field_emp_model->getallemployeebydivision($user_division_id);
            }
        } else {
            $data['allemployee'] = $this->search_field_emp_model->getallemployee();
        }
        $data['salary_allamount_ascorder'] = $this->emp_salary_model->getallsalarybyasc($default_emp_id['search_query']);
        $this->load->view('reports/salary/salary_history_single', $data);
    }

    public function salaryhistorymultiple() {
        $this->check_permission_controller->check_permission_action("view_salary_history_multiple");
        $searchpage = "salaryhistorymultiple";
        if ($this->input->post()) {
            $this->form_validation->set_rules('emp_name', 'Name', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                $user_id = $this->session->userdata('user_id');
                $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
                date_default_timezone_set('Asia/Dhaka');
                $servertime = time();
                $now = date("d-m-Y", $servertime);
                $emp_division = $this->input->post('emp_division');
                $codes = $this->input->post('emp_name');
                $emp_codes_string = rtrim(implode(',', $codes), ',');
                $query = $emp_division;
                $params_contents = array(
                    'id' => '',
                    'search_query' => $query,
                    'user_id' => $user_id,
                    'table_view' => "",
                    'per_page' => $emp_codes_string,
                    'search_page' => $searchpage,
                    'search_date' => $now,
                );
                $this->db->insert("search_query", $params_contents);
            }
        }
        $default_division_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $division_id = $default_division_id['search_query'];
        $data['defaultdivision_id'] = $default_division_id['search_query'];
        $data['defaultstart_date'] = $default_division_id['table_view'];
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
        $data['user_id'] = $user_id;
        $data['user_type_id'] = $this->session->userdata('user_type');
        if ($user_type != 1) {
            if($user_id==16 || $user_id==36){
                $data['allemployee'] = $this->search_field_emp_model->getallemployee();
                $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
            }else{
                $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);
                $data['allemployee'] = $this->search_field_emp_model->getallemployeebydivision($user_division_id);
            }
        } else {
            $data['allemployee'] = $this->search_field_emp_model->getallemployee();
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        }

        $this->load->view('reports/salary/salary_history_multiple', $data);
    }

    public function singlesalaryincrementpdf() {
        $searchpage = "salaryhistorysingle";
        $default_emp_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $att_date_arr = explode("-", $default_emp_id['search_query']);

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
        $data['salary_allamount_ascorder'] = $this->emp_salary_model->getallsalarybyasc($default_emp_id['search_query']);

        $mpdf = $this->pdf->load();
        $html = $this->load->view('print/salary/printsinglesalaryhistorypdf', $data, true);
        // $mpdf->SetProtection(array('print'), 'pass2open', 'pass2havefullaccess');
        // $mpdf->SetVisibility('screenonly'); 
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetVisibility('hidden');
        // $mpdf->SetProtection(array('copy','print','modify'), 'r', 'MyPassword');
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output();
    }

    public function multiplesalaryincrementpdf() {
        $this->load->library("pdflandscape");
        $searchpage = "salaryhistorymultiple";
        $default_division_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $division_id = $default_division_id['search_query'];
        $data['defaultdivision_id'] = $default_division_id['search_query'];
        $data['defaultstart_date'] = $default_division_id['table_view'];
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
        $mpdf = $this->pdflandscape->load();
        $html = $this->load->view('print/salary/printmultiplesalaryhistorypdf', $data, true);
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output();
    }

    public function detail_salary_info_by_id() {

        $content_id = $this->input->post('id');

        $sdata = array(
            "salary_allamount_ascorder" => $this->emp_salary_model->getallsalarybyasc($content_id),
        );
        
        $this->load->view("recruiting/salary_history", $sdata);
    }

    public function get_salary_by_content_id() {

        $content_id = $this->input->post('id');

        $sdata = array(
            "salary_allamount" => $this->emp_salary_model->getallsalary($content_id),
        );
        echo $sdata;
//        print_r($sdata);
//$this->load->view("recruiting/payroll", $sdata);
    }


    function deletesalary() {
        if ($this->input->post('id')) {
            $id =$this->input->post('id');
            $rst=$this->emp_salary_model->deleteSalary($id);
            //redirect($this->session->flashdata('redirect'));
            
            if($rst){
            echo " Deleted! ";  
            }else{
                echo " ERROR! ";  
            }
            
//            redirect('findemployeelist/contentwithpagination');
            //redirect($final_controller_url);
        }
    }
    function salaryStatement(){
       // $this->check_permission_controller->check_permission_action("view_attendance_summery_reports");
    $searchpage="salary_statement";         
    
    $division_vid = 1; 
    $user_type = $this->session->userdata('user_type');
    $user_id = $this->session->userdata('user_id');
    $user_data=$this->users_model->getuserbyid($user_id);
    $user_division_id=$user_data['user_division'];
    $data['user_info']=$this->users_model->getuserbyid($user_id);
    $data['user_type_id'] =$this->session->userdata('user_type');
    
      $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid); 
    
    
    $this->load->view('reports/salary/salary_statement',$data);
    }

}

?>