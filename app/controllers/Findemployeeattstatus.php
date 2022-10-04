<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Findemployeeattstatus extends CI_Controller {

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
        redirect("findemployeeattstatus/find_employee_by_att_status");
    }
    function find_employee_by_att_status() {
        $this->check_permission_controller->check_permission_action("view_attendance_wise_employee");
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $searchpage="find_employee_by_att_status";
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
            $mobile_no = $this->input->post('mobile_no');
            $attendance_required = $this->input->post('attendance_required');
            $logout_required = $this->input->post('logout_required');
            $half_day_absent = $this->input->post('half_day_absent');
            $overtime_count = $this->input->post('overtime_count');
            $emp_weekly_holiday = $this->input->post('emp_weekly_holiday');
            $searchbyname = $this->input->post('searchbyname');
            $sort_by = $this->input->post('sort_by');
            $query = " content_id !='0' ";
            $emp_ids_data=$this->users_model->getpermittedemployee($user_id);
            $content_ids=$emp_ids_data['emp_content_ids'];
            if($user_type !=1){
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
            if ($emp_type !='153') {
                $query .= " AND type_of_employee !='153'";
            } 
            if ($emp_type !='473') {
                $query .= " AND type_of_employee !='473'";
            }           
            if ($joining_date_from1 && $joining_date_to1) {
                $joindatefrom = explode("-", $joining_date_from1);
                $finaljoindatefrom=$joindatefrom[2]."-".$joindatefrom[1]."-".$joindatefrom[0];
                $joindateto = explode("-", $joining_date_to1);
                $finaljoindateto=$joindateto[2]."-".$joindateto[1]."-".$joindateto[0];
                $query .= " AND str_to_date(joining_date, '%d-%m-%Y') BETWEEN '$finaljoindatefrom' AND '$finaljoindateto'";
            } else if ($joining_date_from1) {
                $joindatefrom = explode("-", $joining_date_from1);
                $finaljoindatefrom=$joindatefrom[2]."-".$joindatefrom[1]."-".$joindatefrom[0];
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
            if ($mobile_no) {
                $query .= " AND mobile_no LIKE '$mobile_no'";
            } 
            if ($attendance_required) {
                $query1 = "SELECT DISTINCT content_id FROM emp_working_time WHERE attendance_required LIKE '$attendance_required' AND logout_required LIKE '$logout_required' AND half_day_absent LIKE '$half_day_absent' AND overtime_count LIKE '$overtime_count'";
                $allemp_id = $this->db->query($query1)->result_array();

                $ids = array();
                foreach ($allemp_id as $single_id) {
                    $ids[] = $single_id['content_id'];
                }

            }

            $all_ids = implode(',', $ids);
            if ($all_ids) {
                $query .= " AND content_id IN ($all_ids)";
            }            
            if ($emp_weekly_holiday) {
                $emp_weekly_holiday_off=$emp_weekly_holiday.'_off';
                $query2 = "SELECT DISTINCT content_id FROM emp_weeklyholiday WHERE $emp_weekly_holiday_off ='off' ";
                $allempl_id = $this->db->query($query2)->result_array();

                $ids2 = array();
                foreach ($allempl_id as $single_id) {
                    $ids2[] = $single_id['content_id'];
                }

            }

           $all_ids2 = implode(',', $ids2);
            if ($all_ids2) {
                $query .= " AND content_id IN ($all_ids2)";
            }
            if ($searchbyname) {
                $query .= " AND emp_name LIKE '%$searchbyname%'";
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
                'per_page' => "24",
                'search_page' => $searchpage,                
                'search_date' => $now,
                );
            $this->db->insert("search_query", $params_contents);

            // $allname = $this->db->query($query)->result_array();
        } 
        $config = array();
        $config["base_url"] = base_url() . "findemployeeattstatus/find_employee_by_att_status";
        $total_row = $this->search_field_emp_model->search_record_count($searchpage);
        $per_page_query = $this->search_field_emp_model->getsearchQuery($searchpage);
        $config["total_rows"] = $total_row;
        if ($per_page_query['per_page']) {
            $config["per_page"] = $per_page_query['per_page'];
        } else {
            $config["per_page"] = 12;
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
        $data["records"] = $this->search_field_emp_model->get_all_data($config["per_page"], $page, $searchpage);        
        $allcontent = array();
        $i = 0;
        $division_vid = 1; $department_vid = 2; $jobtitle_vid = 3; $typeofemployee_vid = 4;
        $religion_vid = 6; $marital_status_vid = 7; 
        $allpaytype_vid = 9; $distict_vid = 12; 
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
        $data['alljobtitle'] = $this->taxonomy->getTaxonomyByvid($jobtitle_vid);
        $data['alltypeofemployee'] = $this->taxonomy->getTaxonomyByvid($typeofemployee_vid);
        $data['allreligion'] = $this->taxonomy->getTaxonomyByvid($religion_vid);
        $data['allmarital_status'] = $this->taxonomy->getTaxonomyByvid($marital_status_vid);
        $data['allpaytype'] = $this->taxonomy->getTaxonomyByvid($allpaytype_vid);
        $data['alldistict'] = $this->taxonomy->getTaxonomyByvid($distict_vid);
        $data['age'] = $this->search_field_emp_model->getallAge();
        // $data['records'] = $allname;
        $data['total_search'] = $total_row;
        $this->load->view('reports/attendance/find_employee_att_status', $data);
    }

    public function insertItemperpage() {
     header('Content-type: application/json');
     $applicant_per_page = $this->input->post('applicant_per_page');
     //$applicant_per_page = 12;
     $user_id = $this->session->userdata('user_id');
     $searchpage=$this->input->post('search_page');
     //$searchpage='contentwithpagination';
     $params_contents = array(
        'per_page' => $applicant_per_page,
        );
     $update_con = array('user_id' => $user_id, 'search_page' => $searchpage);
     $this->search_query_model->update_view_status($params_contents, $update_con);
     $content_table = $this->search_field_emp_model->getsearchQuery($searchpage);
     echo json_encode($this->input->post());
 }

 public function submitmultipletask(){
    $searchpage="find_employee_by_att_status";
    $user_id = $this->session->userdata('user_id');
    $post_data=$this->input->post();
    if($post_data['multiple_task']=="Update Total Leave For All"){
       $page_query = $this->search_field_emp_model->get_all_search_emp($searchpage);
       foreach ($page_query as $single_employee) {
        $toadd_id=$single_employee['content_id'];
        if($post_data['annual_leave_total'] && $post_data['emp_job_change_date']){
            $this->add_leave_controller->add_yearlyleave_action($this->input->post(), $toadd_id);
            $this->add_leave_controller->add_yearlyleavehistory_action($this->input->post(), $toadd_id);
        }
    }
}else if($post_data['multiple_task']=="Update Total Leave For Selected"){
    foreach ($post_data['content_id'] as $single_contect_id) {
        $toadd_id=$single_contect_id;
        if($post_data['annual_leave_total'] && $post_data['emp_job_change_date']){
            $this->add_leave_controller->add_yearlyleave_action($this->input->post(), $toadd_id);
            $this->add_leave_controller->add_yearlyleavehistory_action($this->input->post(), $toadd_id);
        }
    }
}else if($post_data['multiple_task']=="Download Selected Employee List" || $post_data['multiple_task']=="Download All Employee List"){

    $this->employeelistpdf($post_data);
}
redirect("findemployeeattstatus/find_employee_by_att_status");

}

  public function employeelistpdf($post_data=array()){
       $this->load->library("pdflandscape");
        $searchpage="find_employee_by_att_status"; 
        if($post_data['multiple_task']=="Download Selected Employee List" || $post_data['multiple_task']=="Download All Employee List"){

             $data['emp_data']=$post_data;
             $mpdf = $this->pdflandscape->load();
             $html = $this->load->view('print/job/printemployeelist_by_att_status_pdf', $data,true);
              //$mpdf->SetVisibility('printonly'); // This will be my code; 
               $mpdf->SetJS('this.print();');
              $mpdf->WriteHTML(utf8_encode($html));
              $mpdf->Output();  
        }else{
            redirect("findemployeeattstatus/find_employee_by_att_status");
        }
                             
  }  
}

?>