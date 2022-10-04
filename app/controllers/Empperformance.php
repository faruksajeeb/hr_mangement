<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Empperformance extends CI_Controller {
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
        //$this->load->view('recruiting/addprofile');
         redirect("empperformance/addempperformance");
    }
    public function createperformance(){
        $this->check_permission_controller->check_permission_action("add_employee_performance");
        if($this->input->post()){
        $this->form_validation->set_rules('Performance_Title', 'Performance Title', 'required');
        $this->form_validation->set_rules('Evaluation_Period_From', 'Evaluation Period From', 'required');
        $this->form_validation->set_rules('Evaluation_Period_Till', 'Evaluation Period Till', 'required');
        $this->form_validation->set_rules('Last_Date_of_Submission', 'Last Date of Submission', 'required');
        $edit_id=$this->input->post('performance_id');
        if($this->form_validation->run()==FALSE)
        {
            $this->session->set_flashdata('errors', validation_errors());
        }else{
            $this->add_empperformance_controller->create_performance_action($this->input->post());
        }
        }
        if($this->uri->segment(3)){
            $performance_id= ($this->uri->segment(3)) ;
            $data['performance_id']=$performance_id;
            $data['performance_id_data']=$this->emp_performance_model->getperfomanceidByid($performance_id);
        }   
        $data['all_performance_title']=$this->emp_performance_model->getallperfomanceid();
        $this->load->view('performance/createperformance',$data);
    }
    public function addempperformance() {
        $this->check_permission_controller->check_permission_action("add_employee_performance");
        $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type');
        $user_info=$this->users_model->getuserbyid($user_id);
        $data['user_data']=$this->users_model->getuserbyid($user_id);
        if($user_info['employee_id']){
            $data['emp_information']=$this->search_field_emp_model->getallsearch_table_contentByempcode($user_info['employee_id']);
        }
        
        if($this->input->post()){
            $this->add_empperformance_controller->add_performance_action($this->input->post());
        }
        if($this->uri->segment(3)){
            $performance_id= ($this->uri->segment(3)) ;
            $data['performance_id']=$performance_id;
            $data['performance_id_data']=$this->emp_performance_model->getperfomanceidByid($performance_id);
        } else{
            redirect("empperformance/createperformance");
        }        
        $department_vid = 2;$criteriacategory_vid = 18;$jobtitle_vid = 3;
        if($user_type !=1){
            $emp_ids_data=$this->users_model->getpermittedemployee($user_id);
          $content_ids=$emp_ids_data['emp_content_ids'];
          $data['allemployee']=$this->search_field_emp_model->getallsearch_table_contentByids($content_ids);
        }else{
          $data['allemployee']=$this->search_field_emp_model->getallemployee();
          
        }     
        $data['alldepartment'] = $this->taxonomy->getTaxonomyByvid($department_vid);
        $data['alljobtitle'] = $this->taxonomy->getTaxonomyByvid($jobtitle_vid);
        $data['allcriteriacategory'] = $this->taxonomy->getcriteriaTaxonomybycriteriacategory($criteriacategory_vid);
        $this->load->view('recruiting/add_emp_performance',$data);
    }

    public function viewsingleperformance() {
        $this->check_permission_controller->check_permission_action("add_employee_performance");
        $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type');
        $user_info=$this->users_model->getuserbyid($user_id);
        $data['user_data']=$this->users_model->getuserbyid($user_id);
        if($user_info['employee_id']){
            $data['emp_information']=$this->search_field_emp_model->getallsearch_table_contentByempcode($user_info['employee_id']);
        }
        
        if($this->input->post()){
            $this->add_empperformance_controller->add_performance_action($this->input->post());
        }
        if($this->uri->segment(3)){
            $performance_id= ($this->uri->segment(3)) ;
            $data['performance_id']=$performance_id;
            $data['performance_id_data']=$this->emp_performance_model->getsubmittedperformanceByid($performance_id);
        } else{
            redirect("empperformance/createperformance");
        }        
        $department_vid = 2;$criteriacategory_vid = 18;$jobtitle_vid = 3;
        if($user_type !=1){
            $emp_ids_data=$this->users_model->getpermittedemployee($user_id);
          $content_ids=$emp_ids_data['emp_content_ids'];
          $data['allemployee']=$this->search_field_emp_model->getallsearch_table_contentByids($content_ids);
        }else{
          $data['allemployee']=$this->search_field_emp_model->getallemployee();
          
        }     
        $data['alldepartment'] = $this->taxonomy->getTaxonomyByvid($department_vid);
        $data['alljobtitle'] = $this->taxonomy->getTaxonomyByvid($jobtitle_vid);
        $data['allcriteriacategory'] = $this->taxonomy->getcriteriaTaxonomybycriteriacategory($criteriacategory_vid);
        $this->load->view('performance/view_single_performance',$data);
    }    
    public function searchempperformance() {
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $searchpage="searchempperformance";
        if ($this->input->post('multiple_search_btn')) {
            $emp_division = $this->input->post('emp_division');
            $emp_department = $this->input->post('emp_department');
            $Performance_Title = $this->input->post('Performance_Title');
            $appraisor_usr_id = $this->input->post('appraisor_usr_id');
            $Evaluation_Period_From = $this->input->post('Evaluation_Period_From');
            $Evaluation_Period_Till = $this->input->post('Evaluation_Period_Till');
            $query = " id !='0' ";
            // $emp_ids_data=$this->users_model->getpermittedemployee($user_id);
            // $content_ids=$emp_ids_data['emp_content_ids'];
            // if($user_type !=1){
            //     $query .= " AND content_id IN ($content_ids)";
            // }
            if ($Performance_Title) {
                $query .= " AND per_main_id LIKE '$Performance_Title'";
            }
            if ($appraisor_usr_id) {
                $query .= " AND appraisor_usr_id LIKE '$appraisor_usr_id'";
            }
            if($Evaluation_Period_From && $Evaluation_Period_Till){
                $Periodfrom = explode("-", $Evaluation_Period_From);
                $finalPeriodfrom=$Periodfrom[2]."-".$Periodfrom[1]."-".$Periodfrom[0];
                $Period_Till = explode("-", $Evaluation_Period_Till);
                $finalPeriod_Till=$Period_Till[2]."-".$Period_Till[1]."-".$Period_Till[0];
                $query1 = "SELECT id FROM emp_performance_id WHERE str_to_date(appraisal_period_from, '%d-%m-%Y') BETWEEN '$finalPeriodfrom' AND '$finalPeriod_Till'";
                $allevaluation = $this->db->query($query1)->result_array();
                $ids = array();
                foreach ($allevaluation as $single_id) {
                    $ids[] = $single_id['id'];
                }
                $all_ids = implode(',', $ids);
               $query .= " AND per_main_id IN ($all_ids)";
                
            }else if($Evaluation_Period_From){
                $Periodfrom = explode("-", $Evaluation_Period_From);
                $finalPeriodfrom=$Periodfrom[2]."-".$Periodfrom[1]."-".$Periodfrom[0];
                $query1 = "SELECT id FROM emp_performance_id WHERE str_to_date(appraisal_period_from, '%d-%m-%Y') >= '$finalPeriodfrom'";
                $allevaluation = $this->db->query($query1)->result_array();
                $ids = array();
                foreach ($allevaluation as $single_id) {
                    $ids[] = $single_id['id'];
                }
                $all_ids = implode(',', $ids);
               $query .= " AND per_main_id IN ($all_ids)";
            }
            if($emp_department){
                $query1 = "SELECT content_id FROM search_field_emp WHERE emp_department='$emp_department'";
                $alleempdipertment= $this->db->query($query1)->result_array();
                $ids = array();
                foreach ($alleempdipertment as $single_id) {
                    $ids[] = $single_id['content_id'];
                }
                $all_ids = implode(',', $ids);
               $query .= " AND  to_emp_id IN ($all_ids)";
                
            }else if($emp_division){
                $query3 = "SELECT content_id FROM search_field_emp WHERE emp_division='$emp_division'";
                $allevaluation2 = $this->db->query($query3)->result_array();
                $ids = array();
                foreach ($allevaluation2 as $single_id) {
                    $ids[] = $single_id['content_id'];
                }
                $all_ids = implode(',', $ids);
               $query .= " AND  to_emp_id IN ($all_ids)";
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
                'table_view' => '',
                'per_page' => "24",
                'search_page' => $searchpage,                
                'search_date' => $now,
                );
            $this->db->insert("search_query", $params_contents);

            // $allname = $this->db->query($query)->result_array();
        } 

        $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type');
        $data['user_type_id'] =$this->session->userdata('user_type');
        $config = array();
        $config["base_url"] = base_url() . "empperformance/searchempperformance";
        $total_row = $this->emp_performance_model->search_record_count($searchpage);
        $per_page_query = $this->emp_performance_model->getsearchQuery($searchpage);
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
        $data["records"] = $this->emp_performance_model->get_all_data($config["per_page"], $page, $searchpage);        
        $allcontent = array();

         $division_vid = 1; $department_vid = 2; 
        if($user_type !=1){
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);        
            $data['department_selected'] = $this->taxonomy->getTaxonomychildbyparent($user_division_id); 
            $emp_last_code=$this->employee_id_model->getLastempcodebydivision($user_division_id);
            $data['tobeaddempcode']=$emp_last_code+1;            
        }else{
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        } 

        $data['all_performance_title']=$this->emp_performance_model->getallperfomanceid();
        $data['all_appraisor']=$this->emp_performance_model->getallappraisor();
        $this->load->view('performance/searchperformance',$data);
    }
    public function viewempperformance() {
        $this->check_permission_controller->check_permission_action("add_employee_performance");
        $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type');
        $user_info=$this->users_model->getuserbyid($user_id);
        $data['user_data']=$this->users_model->getuserbyid($user_id);
        if($user_info['employee_id']){
            $data['emp_information']=$this->search_field_emp_model->getallsearch_table_contentByempcode($user_info['employee_id']);
        }
       
        if($this->uri->segment(3)){
            $performance_id= ($this->uri->segment(3)) ;
            $data['performance_id']=$performance_id;
            $data['performance_id_data']=$this->emp_performance_model->getperfomanceidByid($performance_id);
        }      
        $department_vid = 2;$criteriacategory_vid = 18;$jobtitle_vid = 3;
        if($user_type !=1){
            $emp_ids_data=$this->users_model->getpermittedemployee($user_id);
          $content_ids=$emp_ids_data['emp_content_ids'];
          $data['allemployee']=$this->search_field_emp_model->getallsearch_table_contentByids($content_ids);
        }else{
          $data['allemployee']=$this->search_field_emp_model->getallemployee();
          
        }     
        $data['alldepartment'] = $this->taxonomy->getTaxonomyByvid($department_vid);
        $data['alljobtitle'] = $this->taxonomy->getTaxonomyByvid($jobtitle_vid);
        $data['allcriteriacategory'] = $this->taxonomy->getcriteriaTaxonomybycriteriacategory($criteriacategory_vid);
        $this->load->view('performance/viewperformancesingle',$data);
    }
    public function getempoyeeInfo(){
        header('Content-type: application/json');
        $emp_id = $this->input->post('emp_id');
        $emp_info=$this->search_field_emp_model->getallsearch_table_contentByempcode($emp_id);
        echo json_encode($emp_info);        
    }
    public function getempcontentid() {
        header('Content-type: application/json');
        $emp_code = $this->input->post('emp_code');
        $employee_id = $this->employee_id_model->getemp_idby_empcode($emp_code);
        $emp_performance_id=$this->emp_performance_model->getemployeelastperformance($employee_id);
        echo json_encode($emp_performance_id);

    }

    public function printsingleperformancepdf() {

        $this->check_permission_controller->check_permission_action("add_employee_performance");
        $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type');
        $user_info=$this->users_model->getuserbyid($user_id);
        $data['user_data']=$this->users_model->getuserbyid($user_id);
        if($user_info['employee_id']){
            $data['emp_information']=$this->search_field_emp_model->getallsearch_table_contentByempcode($user_info['employee_id']);
        }
        
        if($this->input->post()){
            $this->add_empperformance_controller->add_performance_action($this->input->post());
        }
        if($this->uri->segment(3)){
            $performance_id= ($this->uri->segment(3)) ;
            $data['performance_id']=$performance_id;
            $data['performance_id_data']=$this->emp_performance_model->getsubmittedperformanceByid($performance_id);
        } else{
            redirect("empperformance/createperformance");
        }        
        $department_vid = 2;$criteriacategory_vid = 18;$jobtitle_vid = 3;
        if($user_type !=1){
            $emp_ids_data=$this->users_model->getpermittedemployee($user_id);
          $content_ids=$emp_ids_data['emp_content_ids'];
          $data['allemployee']=$this->search_field_emp_model->getallsearch_table_contentByids($content_ids);
        }else{
          $data['allemployee']=$this->search_field_emp_model->getallemployee();
          
        }     
        $data['alldepartment'] = $this->taxonomy->getTaxonomyByvid($department_vid);
        $data['alljobtitle'] = $this->taxonomy->getTaxonomyByvid($jobtitle_vid);
        $data['allcriteriacategory'] = $this->taxonomy->getcriteriaTaxonomybycriteriacategory($criteriacategory_vid);
        $mpdf = $this->pdf->load();
        $html = $this->load->view('print/performance/print_single_performance_pdf', $data, true);
       // $mpdf->SetProtection(array('print'), 'pass2open', 'pass2havefullaccess');
        // $mpdf->SetVisibility('screenonly'); 
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetVisibility('hidden');
       // $mpdf->SetProtection(array('copy','print','modify'), 'r', 'MyPassword');
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output();
    }
}

?>