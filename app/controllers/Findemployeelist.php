<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Findemployeelist extends CI_Controller {

    function __construct() {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $autoload['libraries'] = array('globals');
        $this->load->helper('form');
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->load->library('pagination');
        $this->load->library("pdf");
    }

    public function index() {
        redirect("findemployeelist/contentwithpagination");
    }

    function contentwithpagination() {
        $this->check_permission_controller->check_permission_action("view_employee_list");
        $user_type = $this->session->userdata('user_type');
       
        $user_id = $this->session->userdata('user_id');
        $searchpage = "contentwithpagination";
        if ($this->input->post('multiple_search_btn')) {
            $emp_division = $this->input->post('emp_division');
            $emp_department = $this->input->post('emp_department');
            $emp_position = $this->input->post('emp_position');
            $emp_type = $this->input->post('emp_type');
            $joining_date_from1 = $this->input->post('joining_date_from1');
            $joining_date_to1 = $this->input->post('joining_date_to1');
            $emp_pay_type = $this->input->post('emp_pay_type');
            $emp_visa_selling = $this->input->post('emp_visa_selling');
            $emp_gender = $this->input->post('emp_gender');
            $age_from = $this->input->post('age_from');
            $age_to = $this->input->post('age_to');
            $emp_religion = $this->input->post('emp_religion');
            $emp_marital_status = $this->input->post('emp_marital_status');
            $mobile_no = $this->input->post('mobile_no');
            $searchbyname = $this->input->post('searchbyname');
            $emp_current_distict = $this->input->post('emp_current_distict');
            $sort_by = $this->input->post('sort_by');
            $query = " sfe.content_id !='0' ";
            $emp_ids_data = $this->users_model->getpermittedemployee($user_id);
            $content_ids = $emp_ids_data['emp_content_ids'];
            
            if ($user_type != 1) {
                if($user_type == 5 || $user_type == 10){
                   // echo "ERROR!";
                }else{
                    $query .= " AND sfe.content_id IN ($content_ids)";
                }
            }
            if ($emp_division) {
                $query .= " AND sfe.emp_division LIKE '$emp_division'";
            }
            if ($emp_department) {
                $query .= " AND sfe.emp_department LIKE '$emp_department'";
            }
            if ($emp_position) {
                $query .= " AND sfe.emp_post_id LIKE '$emp_position'";
            }
            if ($emp_type) {
                $query .= " AND sfe.type_of_employee LIKE '$emp_type'";
            }
            if ($emp_type != '153') {
                $query .= " AND sfe.type_of_employee !='153'"; //153=Which employee left
            }
            if ($emp_type != '473') {
                $query .= " AND sfe.type_of_employee !='473'"; //473=Which employee terminated
            }
            if ($joining_date_from1 && $joining_date_to1) {
                $joindatefrom = explode("-", $joining_date_from1);
                $finaljoindatefrom = $joindatefrom[2] . "-" . $joindatefrom[1] . "-" . $joindatefrom[0];
                $joindateto = explode("-", $joining_date_to1);
                $finaljoindateto = $joindateto[2] . "-" . $joindateto[1] . "-" . $joindateto[0];
                $query .= " AND str_to_date(sfe.joining_date, '%d-%m-%Y') BETWEEN '$finaljoindatefrom' AND '$finaljoindateto'";
            } else if ($joining_date_from1) {
                $joindatefrom = explode("-", $joining_date_from1);
                $finaljoindatefrom = $joindatefrom[2] . "-" . $joindatefrom[1] . "-" . $joindatefrom[0];
                $query .= " AND str_to_date(sfe.joining_date, '%d-%m-%Y') >='$finaljoindatefrom'";
            }
            if ($emp_pay_type) {
                $query .= " AND sfe.pay_type LIKE '$emp_pay_type'";
            }

            if ($emp_visa_selling) {
                $query .= " AND sfe.visa_selling LIKE '$emp_visa_selling'";
            }
            if ($emp_gender) {
                $query .= " AND sfe.gender LIKE '$emp_gender'";
            }
            if ($age_from && $age_to) {
                $query .= " AND sfe.age >=$age_from and age <=$age_to";
            } else if ($age_from) {
                $query .= " AND sfe.age >=$age_from";
            }
            if ($emp_religion) {
                $query .= " AND sfe.religion LIKE '$emp_religion'";
            }
            if ($emp_marital_status) {
                $query .= " AND sfe.marital_status LIKE '$emp_marital_status'";
            }
            if ($mobile_no) {
                $query .= " AND sfe.mobile_no LIKE '$mobile_no'";
            }
            if ($searchbyname) {
                $query .= " AND sfe.emp_name LIKE '%$searchbyname%'";
            }
            if ($emp_current_distict) {
                $query .= " AND sfe.distict LIKE '$emp_current_distict'";
            }
            $user_id = $this->session->userdata('user_id');
            $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
            date_default_timezone_set('Asia/Dhaka');
            $servertime = time();
            $now = date("d-m-Y", $servertime);

            $params_contents = array(
                'id' => '',
                'search_query' => $query,
                'user_id' => $user_id,
                'table_view' => $sort_by,
                'per_page' => "1000",
                'search_page' => $searchpage,
                'search_date' => $now,
            );
            $this->db->insert("search_query", $params_contents);

            // $allname = $this->db->query($query)->result_array();
        }
      /*
        $config = array();
        $config["base_url"] = base_url() . "findemployeelist/contentwithpagination";
        $total_row = $this->search_field_emp_model->search_record_count($searchpage);
        $per_page_query = $this->search_field_emp_model->getsearchQuery($searchpage);
        $config["total_rows"] = $total_row;
        if ($per_page_query['per_page']) {
            $config["per_page"] = $per_page_query['per_page'];
        } else {
            $config["per_page"] = 1000;
        }
        $config['use_page_numbers'] = FALSE;
        $config['num_links'] = 9;
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";

        $this->pagination->initialize($config);
        if ($this->uri->segment(3)) {
            $page = ($this->uri->segment(3));
        } else {
            $page = 0;
        }
        */
        //$data["records"] = $this->search_field_emp_model->get_all_data($config["per_page"], $page, $searchpage);
        $data["records"] = $this->search_field_emp_model->get_all_data(NULL, $page, $searchpage);
        if ($user_type == 5) {
            //echo print_r($data["records"]);
          //  exit;
        }
        $allcontent = array();
        $i = 0;
        $division_vid = 1;
        $department_vid = 2;
        $jobtitle_vid = 3;
        $typeofemployee_vid = 4;
        $religion_vid = 6;
        $marital_status_vid = 7;
        $allpaytype_vid = 9;
        $distict_vid = 12;
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $user_data = $this->users_model->getuserbyid($user_id);
        $user_division_id = $user_data['user_division'];
        $user_department = $user_data['user_department'];
        $data['user_info'] = $this->users_model->getuserbyid($user_id);
        $data['user_type_id'] = $this->session->userdata('user_type');
        if ($user_type != 1) {
            if($user_id==16 || $user_id==36 || $user_type==10){                  
                $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
//                echo "<pre/>";
//                print_r($data['alldivision']);
//                 exit;
            }else{
                $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);
                
                $data['department_selected'] = $this->taxonomy->getTaxonomychildbyparent($user_division_id);
                $emp_last_code = $this->employee_id_model->getLastempcodebydivision($user_division_id);
                $data['tobeaddempcode'] = $emp_last_code + 1;
            }
        } else {
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        }
        $data['alldepartment'] = $this->taxonomy->getTaxonomyByvid($department_vid);
        $data['alljobtitle'] = $this->taxonomy->getTaxonomyByvid($jobtitle_vid);
        $data['alltypeofemployee'] = $this->taxonomy->getTaxonomyByvid($typeofemployee_vid);
        $data['allreligion'] = $this->taxonomy->getTaxonomyByvid($religion_vid);
        $data['allmarital_status'] = $this->taxonomy->getTaxonomyByvid($marital_status_vid);
        $data['allpaytype'] = $this->taxonomy->getTaxonomyByvid($allpaytype_vid);
        $bankname_vid = 10;
        $data['allbankname'] = $this->taxonomy->getTaxonomyByvid($bankname_vid);
        $data['alldistict'] = $this->taxonomy->getTaxonomyByvid($distict_vid);
        $data['age'] = $this->search_field_emp_model->getallAge();
        // $data['records'] = $allname;
        $data['total_search'] = $total_row;
        $data['emp_division'] = $emp_division;

        $this->load->view('recruiting/allemployeewithpagination', $data);
    }

    function trash_contentwithpagination() {
        $this->check_permission_controller->check_permission_action("view_employee_list");
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $searchpage = "contentwithpagination";
        if ($this->input->post('multiple_search_btn')) {
            $emp_division = $this->input->post('emp_division');
            $emp_department = $this->input->post('emp_department');
            $emp_position = $this->input->post('emp_position');
            $emp_type = $this->input->post('emp_type');
            $joining_date_from1 = $this->input->post('joining_date_from1');
            $joining_date_to1 = $this->input->post('joining_date_to1');
            $emp_pay_type = $this->input->post('emp_pay_type');
            $emp_visa_selling = $this->input->post('emp_visa_selling');
            $emp_gender = $this->input->post('emp_gender');
            $age_from = $this->input->post('age_from');
            $age_to = $this->input->post('age_to');
            $emp_religion = $this->input->post('emp_religion');
            $emp_marital_status = $this->input->post('emp_marital_status');
            $mobile_no = $this->input->post('mobile_no');
            $searchbyname = $this->input->post('searchbyname');
            $emp_current_distict = $this->input->post('emp_current_distict');
            $sort_by = $this->input->post('sort_by');
            $query = " content_id !='0' ";
            $emp_ids_data = $this->users_model->getpermittedemployee($user_id);
            $content_ids = $emp_ids_data['emp_content_ids'];
            if ($user_type != 1) {
                $query .= " AND content_id IN ($content_ids)";
            }
            if ($emp_division) {
                $query .= " AND emp_division LIKE '$emp_division'";
            }
            if ($emp_department) {
                $query .= " AND emp_department LIKE '$emp_department'";
            }
            if ($emp_position) {
                $query .= " AND emp_post_id LIKE '$emp_position'";
            }
            if ($emp_type) {
                $query .= " AND type_of_employee LIKE '$emp_type'";
            }
            if ($emp_type != '153') {
                $query .= " AND type_of_employee !='153'";
            }
            if ($emp_type != '473') {
                $query .= " AND type_of_employee !='473'";
            }
            if ($joining_date_from1 && $joining_date_to1) {
                $joindatefrom = explode("-", $joining_date_from1);
                $finaljoindatefrom = $joindatefrom[2] . "-" . $joindatefrom[1] . "-" . $joindatefrom[0];
                $joindateto = explode("-", $joining_date_to1);
                $finaljoindateto = $joindateto[2] . "-" . $joindateto[1] . "-" . $joindateto[0];
                $query .= " AND str_to_date(joining_date, '%d-%m-%Y') BETWEEN '$finaljoindatefrom' AND '$finaljoindateto'";
            } else if ($joining_date_from1) {
                $joindatefrom = explode("-", $joining_date_from1);
                $finaljoindatefrom = $joindatefrom[2] . "-" . $joindatefrom[1] . "-" . $joindatefrom[0];
                $query .= " AND str_to_date(joining_date, '%d-%m-%Y') >='$finaljoindatefrom'";
            }
            if ($emp_pay_type) {
                $query .= " AND pay_type LIKE '$emp_pay_type'";
            }

            if ($emp_visa_selling) {
                $query .= " AND visa_selling LIKE '$emp_visa_selling'";
            }
            if ($emp_gender) {
                $query .= " AND gender LIKE '$emp_gender'";
            }
            if ($age_from && $age_to) {
                $query .= " AND age >=$age_from and age <=$age_to";
            } else if ($age_from) {
                $query .= " AND age >=$age_from";
            }
            if ($emp_religion) {
                $query .= " AND religion LIKE '$emp_religion'";
            }
            if ($emp_marital_status) {
                $query .= " AND marital_status LIKE '$emp_marital_status'";
            }
            if ($mobile_no) {
                $query .= " AND mobile_no LIKE '$mobile_no'";
            }
            if ($searchbyname) {
                $query .= " AND emp_name LIKE '%$searchbyname%'";
            }
            if ($emp_current_distict) {
                $query .= " AND distict LIKE '$emp_current_distict'";
            }
            $user_id = $this->session->userdata('user_id');
            $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
            date_default_timezone_set('Asia/Dhaka');
            $servertime = time();
            $now = date("d-m-Y", $servertime);

            $params_contents = array(
                'id' => '',
                'search_query' => $query,
                'user_id' => $user_id,
                'table_view' => $sort_by,
                'per_page' => "500",
                'search_page' => $searchpage,
                'search_date' => $now,
            );
            $this->db->insert("search_query", $params_contents);

            // $allname = $this->db->query($query)->result_array();
        }
        $config = array();
        $config["base_url"] = base_url() . "findemployeelist/contentwithpagination";
        $total_row = $this->search_field_emp_model->search_record_count($searchpage);
        $per_page_query = $this->search_field_emp_model->getsearchQuery($searchpage);
        $config["total_rows"] = $total_row;
        if ($per_page_query['per_page']) {
            $config["per_page"] = $per_page_query['per_page'];
        } else {
            $config["per_page"] = 500;
        }
        $config['use_page_numbers'] = FALSE;
        $config['num_links'] = 9;
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";

        $this->pagination->initialize($config);
        if ($this->uri->segment(3)) {
            $page = ($this->uri->segment(3));
        } else {
            $page = 0;
        }
        $data["records"] = $this->search_field_emp_model->get_all_trash_data($config["per_page"], $page, $searchpage);
        $allcontent = array();
        $i = 0;
        $division_vid = 1;
        $department_vid = 2;
        $jobtitle_vid = 3;
        $typeofemployee_vid = 4;
        $religion_vid = 6;
        $marital_status_vid = 7;
        $allpaytype_vid = 9;
        $distict_vid = 12;
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $user_data = $this->users_model->getuserbyid($user_id);
        $user_division_id = $user_data['user_division'];
        $data['user_info'] = $this->users_model->getuserbyid($user_id);
        $data['user_type_id'] = $this->session->userdata('user_type');
        if ($user_type != 1) {
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);
            $data['department_selected'] = $this->taxonomy->getTaxonomychildbyparent($user_division_id);
            $emp_last_code = $this->employee_id_model->getLastempcodebydivision($user_division_id);
            $data['tobeaddempcode'] = $emp_last_code + 1;
        } else {
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        }
        $data['alldepartment'] = $this->taxonomy->getTaxonomyByvid($department_vid);
        $data['alljobtitle'] = $this->taxonomy->getTaxonomyByvid($jobtitle_vid);
        $data['alltypeofemployee'] = $this->taxonomy->getTaxonomyByvid($typeofemployee_vid);
        $data['allreligion'] = $this->taxonomy->getTaxonomyByvid($religion_vid);
        $data['allmarital_status'] = $this->taxonomy->getTaxonomyByvid($marital_status_vid);
        $data['allpaytype'] = $this->taxonomy->getTaxonomyByvid($allpaytype_vid);
        $data['alldistict'] = $this->taxonomy->getTaxonomyByvid($distict_vid);
        $data['age'] = $this->search_field_emp_model->getallAge();
        // $data['records'] = $allname;
        $data['total_search'] = $total_row;
        $this->load->view('recruiting/all_trash_employeewithpagination', $data);
    }

    public function insertItemperpage() {
        header('Content-type: application/json');
        $applicant_per_page = $this->input->post('applicant_per_page');
        //$applicant_per_page = 12;
        $user_id = $this->session->userdata('user_id');
        $searchpage = $this->input->post('search_page');
        //$searchpage='contentwithpagination';
        $params_contents = array(
            'per_page' => $applicant_per_page,
        );
        $update_con = array('user_id' => $user_id, 'search_page' => $searchpage);
        $this->search_query_model->update_view_status($params_contents, $update_con);
        $content_table = $this->search_field_emp_model->getsearchQuery($searchpage);
        // echo "<pre>";
        // print_r($content_table);
        // echo "</pre>";
        echo json_encode($this->input->post());
    }

    public function submitmultipletask() {
        $searchpage = "contentwithpagination";
        $user_id = $this->session->userdata('user_id');
        $post_data = $this->input->post();
        if ($post_data['multiple_task'] == "Update Total Leave For All") {
            $page_query = $this->search_field_emp_model->get_all_search_emp($searchpage);
            foreach ($page_query as $single_employee) {
                $toadd_id = $single_employee['content_id'];
                if ($post_data['annual_leave_total'] && $post_data['emp_job_change_date']) {
                    $this->add_leave_controller->add_yearlyleave_action($this->input->post(), $toadd_id);
                    $this->add_leave_controller->add_yearlyleavehistory_action($this->input->post(), $toadd_id);
                }
            }
             $this->session->set_userdata('add_status', 'Employee total leave updated successfully!');
        } else if ($post_data['multiple_task'] == "Update Total Leave For Selected") {
            foreach ($post_data['content_id'] as $single_contect_id) {
                $toadd_id = $single_contect_id;
                if ($post_data['annual_leave_total'] && $post_data['emp_job_change_date']) {
                    $this->add_leave_controller->add_yearlyleave_action($this->input->post(), $toadd_id);
                    $this->add_leave_controller->add_yearlyleavehistory_action($this->input->post(), $toadd_id);
                }
            }
            $this->session->set_userdata('add_status', 'Employee total leave updated successfully!');
        } else if ($post_data['multiple_task'] == "update_shift_history_for_all") {

            $this->form_validation->set_rules('emp_job_change_date', 'Effective date', 'required');
            $this->form_validation->set_rules('emp_working_time_from', 'Employee work starting time', 'required');
            $this->form_validation->set_rules('emp_working_end_time', 'Employee work ending time ', 'required');
            $this->form_validation->set_rules('attendance_required', 'Attendance required ', 'required');
            $this->form_validation->set_rules('logout_required', 'Logout required ', 'required');
            $this->form_validation->set_rules('emp_latecount_time', 'Employee late count time ', 'required');
            $this->form_validation->set_rules('emp_earlycount_time', 'Employee early cunt time ', 'required');
            $this->form_validation->set_rules('half_day_absent', 'Half day absent ', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_userdata('add_status', 'Please fill out field properly!');
                redirect("findemployeelist/contentwithpagination");
            } else {
                $page_query = $this->search_field_emp_model->get_all_search_emp($searchpage);
                $effictive_date = $post_data["emp_job_change_date"];
                if ($effictive_date) {
                    foreach ($page_query as $single_employee) {
                        $content_id = $single_employee['content_id'] . "<br>";
                        if ($content_id) {
                            $this->add_workingtime_controller->add_workingtime_action($this->input->post(), $content_id);
                            $this->add_empshifthistory_controller->add_empshifthistory_action($this->input->post(), $content_id);
                           
                        }
                    }
                     $this->session->set_userdata('add_status', 'Employee shift history updated successfully!');
           
          
                }
            }
        } else if ($post_data['multiple_task'] == "update_shift_history_for_selected") {

            $this->form_validation->set_rules('emp_job_change_date', 'Effective date', 'required');
            $this->form_validation->set_rules('emp_working_time_from', 'Employee work starting time', 'required');
            $this->form_validation->set_rules('emp_working_end_time', 'Employee work ending time ', 'required');
            $this->form_validation->set_rules('attendance_required', 'Attendance required ', 'required');
            $this->form_validation->set_rules('logout_required', 'Logout required ', 'required');
            $this->form_validation->set_rules('emp_latecount_time', 'Employee late count time ', 'required');
            $this->form_validation->set_rules('emp_earlycount_time', 'Employee early cunt time ', 'required');
            $this->form_validation->set_rules('half_day_absent', 'Half day absent ', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_userdata('add_status', 'Please fill out field properly!');
                redirect("findemployeelist/contentwithpagination");
            } else {
                $effictive_date = $post_data["emp_job_change_date"];
                if ($effictive_date && $post_data['content_id']) {
                    foreach ($post_data['content_id'] as $single_contect_id) {
                        $content_id = $single_contect_id;
                        if ($content_id) {
                             $this->add_workingtime_controller->add_workingtime_action($this->input->post(), $content_id);
                            $this->add_empshifthistory_controller->add_empshifthistory_action($this->input->post(), $content_id);
                           
                        }
                    }
                    $this->session->set_userdata('add_status', 'Employee shift history updated successfully!');
           
                }
            }
        }else if($post_data['multiple_task'] == "terminated_selected"){

             $effected_date=$post_data['effective_date'];
             
             $reason=$post_data['reason'];
             if($effected_date){
            foreach ($post_data['content_id'] as $single_contect_id) {
                $content_id = $single_contect_id;
               
                if ($content_id) {
                $has_last_history = $this->emp_job_history_model->getemp_last_job_history($content_id);
                if($has_last_history){
                $previousId = $has_last_history['id'];
                $previous_start_date=$has_last_history['start_date'];
                $end_date= date('d-m-Y', (strtotime('-1 day', strtotime($effected_date))));
                $d1 = explode('-', $previous_start_date);
                $d2 = explode('-', $end_date);
                $d1 = array_reverse($d1);
                $d2 = array_reverse($d2);
                
                if (strtotime(implode('-', $d2)) > strtotime(implode('-', $d1)))
                { 
                   
                $updateData = array(
                    'end_date' => $end_date,
                    'updated_time' => getCurrentDateTime(),
                    'updated_by' => $this->session->userdata('user_id')
                );
                
                $update_condition = array('id' => $previousId);
                $result1=$this->emp_job_history_model->updemp_job_historytbl($updateData, $update_condition);
                $empUpdateData = array(
                    'type_of_employee' => '473'
                );
                $condition = array('content_id' => $content_id);
                $result2=$this->search_field_emp_model->updSearch_field_contenttbl($empUpdateData, $condition);
                $insertData = array(
                    'content_id' => $content_id,
                    'start_date' => $effected_date,
                    'division_tid' => $has_last_history['division_tid'],
                    'department_tid' => $has_last_history['department_tid'],
                    'post_tid' => $has_last_history['post_tid'],
                    'grade_tid' => $has_last_history['grade_tid'],
                    'emp_type_tid' => '473',
                    'created_time' => getCurrentDateTime(),
                    'created_by' => $this->session->userdata('user_id'),
                    'reason' => $reason
                );
                $result3=$this->db->insert("emp_job_history", $insertData);
                }
                }
                }
            }
            if($result1 && $result2 && $result3){
            $this->session->set_userdata('add_status', 'Employee terminated successfully!');
            }
             }else{
                 $this->session->set_userdata('add_status', 'Please enter effective date!');
             }
        
        }else if($post_data['multiple_task'] == "left_selected"){

             $effected_date=$post_data['effective_date'];
             
             $reason=$post_data['reason'];
             if($effected_date){
            foreach ($post_data['content_id'] as $single_contect_id) {
                $content_id = $single_contect_id;
               
                if ($content_id) {
                $has_last_history = $this->emp_job_history_model->getemp_last_job_history($content_id);
                if($has_last_history){
                $previousId = $has_last_history['id'];
                $previous_start_date=$has_last_history['start_date'];
                $end_date= date('d-m-Y', (strtotime('-1 day', strtotime($effected_date))));
                $d1 = explode('-', $previous_start_date);
                $d2 = explode('-', $end_date);
                $d1 = array_reverse($d1);
                $d2 = array_reverse($d2);
                
                if (strtotime(implode('-', $d2)) > strtotime(implode('-', $d1)))
                {                   
                $updateData = array(
                    'end_date' => $end_date,
                    'updated_time' => getCurrentDateTime(),
                    'updated_by' => $this->session->userdata('user_id')
                );                
                $update_condition = array('id' => $previousId);
                $result1=$this->emp_job_history_model->updemp_job_historytbl($updateData, $update_condition);
                $empUpdateData = array(
                    'type_of_employee' => '153'
                );
                $condition = array('content_id' => $content_id);
                $result2=$this->search_field_emp_model->updSearch_field_contenttbl($empUpdateData, $condition);
                $insertData = array(
                    'content_id' => $content_id,
                    'start_date' => $effected_date,
                    'division_tid' => $has_last_history['division_tid'],
                    'department_tid' => $has_last_history['department_tid'],
                    'post_tid' => $has_last_history['post_tid'],
                    'grade_tid' => $has_last_history['grade_tid'],
                    'emp_type_tid' => '153',
                    'created_time' => getCurrentDateTime(),
                    'created_by' => $this->session->userdata('user_id'),
                    'reason' => $reason
                );
                $result3=$this->db->insert("emp_job_history", $insertData);
                }
                }
                }
            }
            if($result1 && $result2 && $result3){
            $this->session->set_userdata('add_status', 'Employee Left successfully!');
            }
             }else{
                 $this->session->set_userdata('add_status', 'Please enter effective date!');
             }
        }
        else if ($post_data['multiple_task'] == "Download Selected Employee List" || $post_data['multiple_task'] == "Download All Employee List") {
            $this->employeelistpdf($post_data);
        } else if ($post_data['multiple_task'] == "download_emp_list_excel") {
           
            $this->employeelistExcel($post_data);

        } else if ($post_data['multiple_task'] == "print_emp_list") {
            $this->employeelistPrint($post_data);
        }

        redirect("findemployeelist/contentwithpagination");
    }

    function trash_employee() {

        $left_employees = $this->search_field_emp_model->get_all_left_employee();
// dd($left_employees);
        $terminated_employees = $this->search_field_emp_model->get_all_tarminated_employee();
        dd($terminated_employees);
        $data = Array(
            //'inactive_employee'=> $this->search_field_emp_model->get_all_inactive_employee(),
            'left_employee' => $left_employees['result'],
            'left_employee_numbers' => $left_employees['rows'],
            'terminated_employee' => $terminated_employees['result'],
            'terminated_employee_numbers' => $terminated_employees['rows'],
        );

        $this->load->view('recruiting/all_trash_employee', $data);
    }

    function all_delete_employee() {
        $delete_employees = $this->search_field_emp_model->get_all_delete_employee();
        $data = Array(
            //'inactive_employee'=> $this->search_field_emp_model->get_all_inactive_employee(),
            'delete_employee' => $delete_employees['result'],
            'delete_employee_numbers' => $delete_employees['rows']
        );
//          print_r($data);
//          exit();
        $this->load->view('recruiting/all_delete_employee', $data);
    }

    public function employeelistpdf($post_data = array()) {
        $this->load->library("pdflandscape");
        $searchpage = "contentwithpagination";
        if ($post_data['multiple_task'] == "Download Selected Employee List" || $post_data['multiple_task'] == "Download All Employee List") {

            $data['emp_data'] = $post_data;
            $data['emp_division'] = $post_data['emp_division'];
            $mpdf = $this->pdflandscape->load();

            $html = $this->load->view('print/employee/print_employee_list_pdf', $data, true);

            //$mpdf->SetVisibility('printonly'); // This will be my code; 
            $mpdf->SetJS('this.print();');
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output();
        } else {
            redirect("findemployeelist/contentwithpagination");
        }
    }

   public function employeelistExcel($post_data = array()) {
     
        $searchpage = "contentwithpagination";
        if ($post_data['multiple_task'] == "download_emp_list_excel") {

            $data['emp_data'] = $post_data;
            $data['emp_division'] = $post_data['emp_division'];

            $searchpage = "contentwithpagination";
            $getSearchEmployeeInfo = $this->search_field_emp_model->get_all_search_emp($searchpage);

            // Create a new Spreadsheet (Object) 
            $spreadsheet = new Spreadsheet();
            // Set spreadsheet properties
            $spreadsheet->getProperties()
                    ->setCreator("HR Software")
                    ->setLastModifiedBy("")
                    ->setTitle("Employee Information")
                    ->setSubject($data['emp_division'] . "(Employee Information)")
                    ->setDescription(
                            "Employee Information, generated by IIDFC HR Software."
                    )
                    ->setKeywords("LIST")
                    ->setCategory("LIST");
            // Rename worksheet
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle("Employee List");
            // Printer setup
            $sheet->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            $sheet->getPageSetup()
                    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
            $sheet->getPageMargins()->setTop(0.75);
            $sheet->getPageMargins()->setRight(0.25);
            $sheet->getPageMargins()->setLeft(0.25);
            $sheet->getPageMargins()->setBottom(0.75);
            $sheet->getPageSetup()->setHorizontalCentered(true);
            $sheet->getPageSetup()->setVerticalCentered(false);
            // $spreadsheet->getActiveSheet()->getHeaderFooter()
            //        ->setOddHeader('&C&HPlease treat this document as confidential!');
            $sheet->getHeaderFooter()
                    ->setOddFooter('&L&B' . $spreadsheet->getProperties()->getTitle() . '&RPage &P of &N');
            // end printer setup ------------------------------
            // set field value
            if($data['emp_division']){
                $empDivision = $this->taxonomy->getTaxonomyBytid($data['emp_division']);
                $empDivisionName=$empDivision['name']; 
               }else{
                   $empDivisionName="IIDFC";
               }
            $styleArray = [
                'font' => [
                    'bold' => true,
                    'size' =>20,
                    'color' => [
                        'rgb' => 'FFFFFF',
                    ],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ],
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
                    ],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 360,
                    'startColor' => [
                        'rgb' => '2F4F4F',
                    ],
                    'endColor' => [
                        'rgb' => '2F4F4F',
                    ],
                ],
            ];
            $theadStyleArray=[
                'font' => [
                    'bold' => true
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'rotation' => 90,
                    'startColor' => [
                        'argb' => 'CCCCCCCC',
                    ]
                ],
            ];
            $spreadsheet->getActiveSheet()->mergeCells('A1:Z1');
            $spreadsheet->getActiveSheet()->mergeCells('A2:Z2');
            $sheet->getStyle('A1')->applyFromArray($styleArray);
            $sheet->getStyle('A2')->applyFromArray($styleArray);
            
            $sheet->setCellValue('A1', $empDivisionName);
            $sheet->setCellValue('A2', "Employee List");
            //autofit column width
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);
            $sheet->getColumnDimension('H')->setAutoSize(true);
            $sheet->getColumnDimension('I')->setAutoSize(true);
            $sheet->getColumnDimension('J')->setAutoSize(true);
            $sheet->getColumnDimension('K')->setAutoSize(true);
            $sheet->getColumnDimension('L')->setAutoSize(true);
            $sheet->getColumnDimension('M')->setAutoSize(true);
            $sheet->getColumnDimension('N')->setAutoSize(true);
            $sheet->getColumnDimension('O')->setAutoSize(true);
            $sheet->getColumnDimension('P')->setAutoSize(true);
            $sheet->getColumnDimension('Q')->setAutoSize(true);
            $sheet->getColumnDimension('R')->setAutoSize(true);
            $sheet->getColumnDimension('S')->setAutoSize(true);
            $sheet->getColumnDimension('T')->setAutoSize(true);
            $sheet->getColumnDimension('U')->setAutoSize(true);
            $sheet->getColumnDimension('V')->setAutoSize(true);
            $sheet->getColumnDimension('W')->setAutoSize(true);
            $sheet->getColumnDimension('X')->setAutoSize(true);
            $sheet->getColumnDimension('Y')->setAutoSize(true);
            $sheet->getColumnDimension('Z')->setAutoSize(true);
            $sheet->getColumnDimension('AA')->setAutoSize(true);
            // header set
             // User wise permission ----------------------------------
                $user_id = $this->session->userdata('user_id');
                $user_type = $this->session->userdata('user_type');
                $view_salary_in_emp_list= $this->users_model->getuserwisepermission("view_salary_in_emp_list",$user_id);
                $view_employee_mobile_number = $this->users_model->getuserwisepermission("view_employee_mobile_number",$user_id);
                $view_employee_email_address = $this->users_model->getuserwisepermission("view_employee_email_address",$user_id);
                $view_employee_age = $this->users_model->getuserwisepermission("view_employee_age",$user_id);
                $view_employee_date_of_birth = $this->users_model->getuserwisepermission("view_employee_date_of_birth",$user_id);
            $headerRow = 3;
            $sheet->freezePane('A4');
            $sheet->getStyle('A'.$headerRow.':Z'.$headerRow)->applyFromArray($theadStyleArray);
            $sheet->setCellValue('A' . $headerRow, "Sl No");
            $sheet->setCellValue('B' . $headerRow, "Emp. ID");
            $sheet->setCellValue('C' . $headerRow, "Employee Name");
            $sheet->setCellValue('D' . $headerRow, "Grade");
            $sheet->setCellValue('E' . $headerRow, "Division Name");
            $sheet->setCellValue('F' . $headerRow, "Department Name");
            $sheet->setCellValue('G' . $headerRow, "Designation");
            $sheet->setCellValue('H' . $headerRow, "Type of Employee");
            $sheet->setCellValue('I' . $headerRow, "Joining Date"); 
            $sheet->setCellValue('J' . $headerRow, "Length Of Services"); 
				
            if($view_employee_date_of_birth['status']==1){
                $sheet->setCellValue('K' . $headerRow, "Date of Birth");
            }
            if($view_employee_age['status']==1){
                $sheet->setCellValue('L' . $headerRow, "Age");
            }
            $sheet->setCellValue('M' . $headerRow, "Gender");
            if($view_employee_mobile_number['status']==1){
                $sheet->setCellValue('N' . $headerRow, "Mobile No");
            }
            if($view_employee_email_address['status']==1){
                $sheet->setCellValue('O' . $headerRow, "Email");
            }
            
            $sheet->setCellValue('P' . $headerRow, "Father's Name");
            $sheet->setCellValue('Q' . $headerRow, "Mothers's Name");
            $sheet->setCellValue('R' . $headerRow, "E. Qualification");
            
            $sheet->setCellValue('S' . $headerRow, "Permanent Address");
            $sheet->setCellValue('T' . $headerRow, "Present Address");
            $sheet->setCellValue('U' . $headerRow, "District");
            $sheet->setCellValue('V' . $headerRow, "Blood Group");
            $sheet->setCellValue('W' . $headerRow, "National ID");
            $sheet->setCellValue('X' . $headerRow, "Religion");
            $sheet->setCellValue('Y' . $headerRow, "Merital Status");
            if ($view_salary_in_emp_list['status'] == 1 || $user_id==6 ) {  
            $sheet->setCellValue('Z' . $headerRow, "Present Salary");
            $sheet->setCellValue('AA' . $headerRow, "A/C Number");
            }
            
           

            $row = 4;
            $slNo = 1;
            foreach ($getSearchEmployeeInfo as $singleEmployeeInfo) {
                $sheet->setCellValue('A' . $row, $slNo);
                $sheet->setCellValue('B' . $row, $singleEmployeeInfo['emp_id']);
                $sheet->setCellValue('C' . $row, $singleEmployeeInfo['emp_name']);
                $sheet->setCellValue('D' . $row, $singleEmployeeInfo['grade_name']);
                $sheet->setCellValue('E' . $row, $singleEmployeeInfo['division_name']);
                $sheet->setCellValue('F' . $row, $singleEmployeeInfo['department_name']);
                $sheet->setCellValue('G' . $row, $singleEmployeeInfo['designation_name']);
                $sheet->setCellValue('H' . $row, $singleEmployeeInfo['type_of_emp_name']);
                $sheet->setCellValue('I' . $row, $singleEmployeeInfo['joining_date']);
					$joining_date_arr = explode('-', $singleEmployeeInfo['joining_date']);
					$joining_date_reversed = $joining_date_arr[2] . "-" . $joining_date_arr[1] . "-" . $joining_date_arr[0] . " 00:00:00";
                    $jo = strtotime($joining_date_reversed);
                    date_default_timezone_set('Asia/Dhaka');
                    //$now = time();
                    $download_date_arr = explode('-', $post_data['download_date']);
					$download_date_reversed = $download_date_arr[2] . "-" . $download_date_arr[1] . "-" . $download_date_arr[0] . " 00:00:00";
                    $dd= strtotime($download_date_reversed);
                
//       echo $dd;
//       exit;
                    $removed = timespan($jo, $dd);
                    $pieces = explode(",", $removed);
                    foreach ($pieces as $key => $ll) {
                        if (strpos($ll, 'Hour') !== false || strpos($ll, 'Minute') !== false) {
                            unset($pieces[$key]);
                        }
                    }
                    $lengthOfServices = rtrim(implode(',', $pieces), ',');
                $sheet->setCellValue('J' . $row, $lengthOfServices);
                if($view_employee_date_of_birth['status']==1){
                    $dateOfBirth=$singleEmployeeInfo['dob'];
                    $sheet->setCellValue('K' . $row,$dateOfBirth );
                }
                
                
                //explode the date to get month, day and year
                $birthDate = explode("-", $singleEmployeeInfo['dob']);
                $age = $this->ageDOB($birthDate[2], $birthDate[1], $birthDate[0]); /* with my local time is 2014-07-01 */
                $employeeAge=sprintf("%d years %d months %d days", $age['y'], $age['m'], $age['d']); /* output -> age = 29 year 1 month 24 day */
                if($view_employee_age['status']==1){
                    $sheet->setCellValue('L' . $row, $employeeAge);
                }
                $sheet->setCellValue('M' . $row, $singleEmployeeInfo['gender']);
                if($view_employee_mobile_number['status']==1){
                    $sheet->setCellValue('N' . $row, $singleEmployeeInfo['mobile_no']);
                }
                //get employee detail info
                $emp_details_records=$this->emp_details_model->getallcontentByid($singleEmployeeInfo['content_id']);
                foreach ($emp_details_records as $value) {
                    if($value['field_name']=='emp_email'){
                            $empEmail=$value['field_value'];
                    }else if($value['field_name']=='emp_parmanent_address'){
                            $empPermenentAddress=$value['field_value'];
                    }else if($value['field_name']=='emp_present_address'){
                            $empPresentAddress=$value['field_value'];
                    }else if($value['field_name']=='emp_blood_group'){
                            $empBloodGroup=$value['field_value'];
                            $empBloodGroupData = $this->taxonomy->getTaxonomyBytid($empBloodGroup);                            
                    }else if($value['field_name']=='emp_fathername'){
                            $fatherName=$value['field_value'];
                    }else if($value['field_name']=='emp_mothername'){
                             $motherName=$value['field_value'];
                    }else if($value['field_name']=='emp_qualification'){
                             $eduQualificationId=$value['field_value'];
                             $eduQualificationData = $this->taxonomy->getTaxonomyBytid($eduQualificationId); 
                             $eduQualification=$eduQualificationData['name'];
                    }
                }
                if($view_employee_email_address['status']==1){
                    $sheet->setCellValue('O' . $row, $empEmail);   
                }
                $sheet->setCellValue('P' . $row, $fatherName);
                $sheet->setCellValue('Q' . $row, $motherName);
                $sheet->setCellValue('R' . $row, $eduQualification);
                $sheet->setCellValue('S' . $row, $empPermenentAddress);                                                       
                $sheet->setCellValue('T' . $row, $empPresentAddress);                            
                $sheet->setCellValue('U' . $row, $singleEmployeeInfo['district_name']); 
                $sheet->setCellValue('V' . $row, $empBloodGroupData['name']);

                $empEmail=""; 
                $fatherName="";
                $motherName="";
                $eduQualification="";
                $empPermenentAddress=""; 
                $empPresentAddress="";
                $empBloodGroup="";
                // set this for avoid scientific notation 
                $sheet->getStyle('W' . $row)
                    ->getNumberFormat()
                    ->setFormatCode(
                        '0'
                    );
                $sheet->setCellValue('W' . $row, $singleEmployeeInfo['national_id']);
                $sheet->setCellValue('X' . $row, $singleEmployeeInfo['religion_name']);
                $sheet->setCellValue('Y' . $row, $singleEmployeeInfo['merital_status_name']);				
                // get salary info
                $salary_amount = $this->emp_salary_model->getsalary($singleEmployeeInfo['content_id']);
                if ($view_salary_in_emp_list['status'] == 1 || $user_id==6) { 
                $sheet->setCellValue('Z' . $row, $salary_amount['gross_salary']);
                $sheet->setCellValue('AA' . $row, $singleEmployeeInfo['emp_bank_account']);
                }
                
                $row++;
                $slNo++;
            }
            $row = $row + 2;   
            $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
                                            $current_date = $dt->format('d-m-Y');   
            $sheet->setCellValue('A' . $row, "Report generated by HR Software at " . $current_date. ", Effective Date:".$post_data['download_date']);
            $sheet->getStyle('A' . $row)->getFont()->setItalic(TRUE);
            $sheet->getStyle('A' . $row)->getFont()->setSize(6);
            
            $writer = new Xlsx($spreadsheet);
            $now = date("d-m-Y_H:i:s", time());
            $filename = 'employee-list-'.$now;
            
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output'); // download file 
            die();
            
            //$this->load->view('print/job/printemployeelist_excel', $data,true);
        } else {

            redirect("findemployeelist/contentwithpagination");
        }
    }
    
    function ageDOB($y = 2014, $m = 12, $d = 31) { /* $y = year, $m = month, $d = day */
        date_default_timezone_set("Asia/Jakarta"); /* can change with others time zone */

        $ageY = date("Y") - intval($y);
        $ageM = date("n") - intval($m);
        $ageD = date("j") - intval($d);

        if ($ageD < 0) {
            $ageD = $ageD += date("t");
            $ageM--;
        }
        if ($ageM < 0) {
            $ageM += 12;
            $ageY--;
        }
        if ($ageY < 0) {
            $ageD = $ageM = $ageY = -1;
        }
        return array('y' => $ageY, 'm' => $ageM, 'd' => $ageD);
    }
    public function employeelistPrint($post_data = array()) {

        $searchpage = "contentwithpagination";
        if ($post_data['multiple_task'] == "print_emp_list") {

            $data['emp_data'] = $post_data;
            $data['emp_division'] = $post_data['emp_division'];
            $this->load->view('print/employee/print_employee_list', $data,true);
//            echo "hi";
//            exit;
        } else {

            redirect("findemployeelist/contentwithpagination");
        }
    }
    public function employeeLockSystem(){
                $column = $this->input->post('name');
                $new_value = $this->input->post('value');
                $id = $this->input->post('pk');
        //        echo $column;
        //        exit();
                // exit;
                         if($new_value==1){
                            $status = "unlock";
                        }else if($new_value==0){
                            $status = "lock";
                        }
                       $this->db->set($column, $new_value);
                       $this->db->set('updated_by', $this->session->userdata('user_id'));
                       $this->db->set('updated_at', $this->current_time());
          
                        $this->db->where('content_id', $id);
                        $result = $this->db->update('search_field_emp');

                return $result;
    }
        public function current_time() {
        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
        $current_time = $dt->format('Y-m-d H:i:s');
        return $current_time;
    }

}

?>