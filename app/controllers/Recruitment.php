<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Recruitment extends CI_Controller {

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
        $this->load->model("circular_model");
    }

    public function index() {
        //redirect("holidaymaster/add_holiday");
    }

    public function view_circular() {
        $data = array();
        $data['all_circular'] = $this->circular_model->getAllCircular();
        $this->load->view("recruitment/view_circular", $data);
    }
    
    public function selectJobInfo(){
        
        $result = $this->circular_model->select_job_info();
//        print_r($result);
//        exit;
        return $result;
    }
    
    public function apply(){
        
        //        print_r($_FILES);
      //  exit;
        $date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $currentTime = $date->format('Y-m-d H:i:s');
        $data = Array(
            'CircularID' => $this->input->post('circular_id', true),
            'ApplicantName' => $this->input->post('applicant_name', true),
            'ApplicantEmail' => $this->input->post('applicant_email', true),
            'ApplicantPhone' => $this->input->post('applicant_phone', true),
            'Age' => $this->input->post('applicant_age', true),
            'LastInstitute' => $this->input->post('applicant_institute', true),
            'ExpSalary' => $this->input->post('expected_salary', true),
            'TotalExp' => $this->input->post('applicant_experience', true),
            'ExpDetail' => $this->input->post('experience_detail', true),
            //'ApplicantImage' => $this->input->post('applicant_image', true),
            //'ApplicantCV' => $this->input->post('applicant_cv', true),
            //'AdditionalInformation' => $this->input->post('AdditionalInformation', true),
            'AppliedTime' => $currentTime,
        );
        /* Start applicant image upload */
      
        $config = Array(
            'upload_path' => 'resources/images/applicant_image',
            'allowed_types' => 'jpg|png',
            'max_size' => 512,
            'max_width' => 2000,
            'max_height' => 2000
        );
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $error = '';
        $fdata = Array();
        if (!$this->upload->do_upload('applicant_image')) {
            $error = $this->upload->display_errors();
            echo $error;
            //exit();
        } else {
            $fdata = $this->upload->data();
            $fileName = $fdata['file_name'];
            $data['ApplicantImage'] = $config['upload_path'] . $fdata['file_name'];
        }
        /* End applicant image upload */

        /* Start applicant cv upload */
      
        $config2 = Array(
            'upload_path' => 'resources/images/applicant_cv',
            'allowed_types' => 'pdf|doc|docx|jpg|png',
            'max_size' => 1024
        );
        // Initialize the new config
        $this->upload->initialize($config2);
        $error = '';
        $fdata2 = Array();
        if (!$this->upload->do_upload('applicant_cv')) {
            $error = $this->upload->display_errors();
            echo $error;
            //exit();
        } else {
            $fdata2 = $this->upload->data();
            $fileName2 = $fdata2['file_name'];     
            $data['ApplicantCV'] = $config2['upload_path'] . $fdata2['file_name'];
        }
        /* End applicant cv upload */
//        print_r($data);
//        exit;
        $result = $this->db->insert("tbl_applicant", $data);
        $sdata = Array();
        if ($result) {
            $sdata['message'] = 'save';
        } else {
            $sdata['message'] = 'fail';
        }
        $this->session->set_userdata($sdata);

       echo "SUCCESS! <a href=".$_SERVER['HTTP_REFERER'].">Go Back</a>";
    }
    

    public function view_applicant() {
        $searchpage = 'view_applicants';
        if ($this->input->post('multiple_search_btn')) {
            $division = $this->input->post('job_division');
            $post = $this->input->post('job_post');
            $status = $this->input->post('applicant_status'); 
            $from = $this->input->post('applied_from');
            $to = $this->input->post('applied_to');
            $query = " a.ApplicantID !=0 ";
             
            if ($division) {
                $query .= " AND c.DivisionID=$division ";
            }
            if ($post) {
                $result = $this->db->query("SELECT name FROM taxonomy WHERE tid=$post")->row_array();                
                $this->session->set_userdata('post_name', $result['name']);
                $query .= " AND c.PostID=$post ";
            } else {
                $this->session->unset_userdata('post_name');
            }
            
            if($status==0){ 
               
//                $this->session->set_userdata('applicant_status',$status);
                $query .= " AND a.Status=0 ";
                $this->session->unset_userdata('applicant_status');
            }else if($status){
               
                $this->session->set_userdata('applicant_status',$status);
                $query .= " AND a.Status=$status ";
            } else {
                $this->session->unset_userdata('applicant_status');
            }
            if ($from) {
                $fdate = date("Y-m-d", strtotime($from));
                $query .= " AND CAST(a.AppliedTime AS DATE) >='$fdate' ";
            }
            if ($to) {
                $tdate = date("Y-m-d", strtotime($to));
                $query .= " AND CAST(a.AppliedTime AS DATE) <='$tdate' ";
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
                'table_view' => "0",
                'per_page' => "",
                'search_page' => $searchpage,
                'search_date' => $now,
            );
            $this->db->insert("search_query", $params_contents);
        }

        $query = $this->circular_model->get_all_applicant_data($searchpage);
        /*
        $shortlist_query = $this->circular_model->getAllApplicantShortlist();
        $writtenlist_query = $this->circular_model->getAllApplicantWrittenlist();
        $interviewlist_query = $this->circular_model->getAllApplicantInterviewlist();
        $selectedlist_query = $this->circular_model->getAllApplicantSelectedlist();
        $appointedlist_query = $this->circular_model->getAllApplicantAppointedlist();
        $joinedlist_query = $this->circular_model->getAllApplicantJoinedlist();
        */
        $trash_query = $this->circular_model->getAllTrashApplicant();
        $data = array(
            'all_applicant' => $query['result'],
            'num_row' => $query['rows'],
           // 'shortlist_num_row' => $shortlist_query ['rows'],
           // 'written_num_row' => $writtenlist_query ['rows'],
           // 'interview_num_row' => $interviewlist_query ['rows'],
           // 'selected_num_row' => $selectedlist_query ['rows'],
           // 'appointed_num_row' => $appointedlist_query ['rows'],
          //  'joined_num_row' => $joinedlist_query ['rows'],
            'trash_num_row' => $trash_query ['rows']
        );
        $data['circular_division'] = $this->circular_model->getApplicantInfo("DivisionID");
        $data['circular_post'] = $this->circular_model->getApplicantInfo("PostID");

        $this->load->view("recruitment/view_applicant", $data);
    }

    public function submitMultipleTask() {
        $post_data = $this->input->post();
   
        if ($post_data['multiple_task'] == "delete_selected_list") {
            
            foreach ($post_data['applicant_id'] as $sigle_id) {
                $this->circular_model->update_applicant_deletion_status_info($sigle_id);
            }
        }else if ($post_data['multiple_task'] == "selected_list_shorted" ||
                  $post_data['multiple_task'] == "selected_list_written" ||
                  $post_data['multiple_task'] == "selected_list_interview" ||
                  $post_data['multiple_task'] == "selected_list_selected" ||
                  $post_data['multiple_task'] == "selected_list_appointed" ||
                  $post_data['multiple_task'] == "selected_list_joined"  
                ) {   
           
            foreach ($post_data['applicant_id'] as $sigle_id) {
                $data=array();
                if ($post_data['multiple_task'] == 'selected_list_shorted') {
                    $data['Status'] = 1;
                } else if ($post_data['multiple_task'] == 'selected_list_written') {
                    $data['Status'] = 2;
                } else if ($post_data['multiple_task'] == 'selected_list_interview') {
                    $data['Status'] = 3;
                } else if ($post_data['multiple_task'] == 'selected_list_selected') {
                    $data['Status'] = 4;
                } else if ($post_data['multiple_task'] == 'selected_list_appointed') {
                    $data['Status'] = 5;
                } else if ($post_data['multiple_task'] == 'selected_list_joined') {
                    $data['Status'] = 6;
                }
                $this->circular_model->update_applicant_status_info($sigle_id,$data);
            }
        }else if ($post_data['multiple_task'] == "download_selected_applicant_list" || $post_data['multiple_task'] == "download_all_applicant_list") {

            $this->applicantlistpdf($post_data);
        }
        redirect("recruitment/view_applicant");
    }
 
    public function applicantlistpdf($post_data = array()) {
        $this->load->library("pdflandscape");
        if ($post_data['multiple_task'] == "download_selected_applicant_list" || $post_data['multiple_task'] == "download_all_applicant_list") {

            $data['applicant_data'] = $post_data;
//              print_r($data);
//            exit;
            $mpdf = $this->pdflandscape->load();
            $html = $this->load->view('print/job/print_applicant_list_pdf', $data, true);
            //$mpdf->SetVisibility('printonly'); // This will be my code; 
            $mpdf->SetJS('this.print();');
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output();
        } else {
            redirect("recruitment/view_applicant");
        }
    }

    public function shortlisted_applicant() {
        $shortlist_query = $this->circular_model->getAllApplicantShortlist();
        $writtenlist_query = $this->circular_model->getAllApplicantWrittenlist();
        $interviewlist_query = $this->circular_model->getAllApplicantInterviewlist();
        $selectedlist_query = $this->circular_model->getAllApplicantSelectedlist();
        $appointedlist_query = $this->circular_model->getAllApplicantAppointedlist();
        $joinedlist_query = $this->circular_model->getAllApplicantJoinedlist();
        $trash_query = $this->circular_model->getAllTrashApplicant();
        $data = array(
            'all_shortlisted_applicant' => $shortlist_query['result'],
            'shortlist_num_row' => $shortlist_query ['rows'],
            'written_num_row' => $writtenlist_query ['rows'],
            'interview_num_row' => $interviewlist_query ['rows'],
            'selected_num_row' => $selectedlist_query ['rows'],
            'appointed_num_row' => $appointedlist_query ['rows'],
            'joined_num_row' => $joinedlist_query ['rows'],
            'trash_num_row' => $trash_query ['rows']
        );

        $this->load->view("recruitment/view_shortlisted_applicant", $data);
    }

    public function written_applicant() {

        $writtenlist_query = $this->circular_model->getAllApplicantWrittenlist();
        $interviewlist_query = $this->circular_model->getAllApplicantInterviewlist();
        $selectedlist_query = $this->circular_model->getAllApplicantSelectedlist();
        $appointedlist_query = $this->circular_model->getAllApplicantAppointedlist();
        $joinedlist_query = $this->circular_model->getAllApplicantJoinedlist();
        $trash_query = $this->circular_model->getAllTrashApplicant();
        $data = array(
            'all_written_applicant' => $writtenlist_query['result'],
            'written_num_row' => $writtenlist_query ['rows'],
            'interview_num_row' => $interviewlist_query ['rows'],
            'selected_num_row' => $selectedlist_query ['rows'],
            'appointed_num_row' => $appointedlist_query ['rows'],
            'joined_num_row' => $joinedlist_query ['rows'],
            'trash_num_row' => $trash_query ['rows']
        );

        $this->load->view("recruitment/view_written_applicant", $data);
    }

    public function interview_applicant() {

        $interviewlist_query = $this->circular_model->getAllApplicantInterviewlist();
        $selectedlist_query = $this->circular_model->getAllApplicantSelectedlist();
        $appointedlist_query = $this->circular_model->getAllApplicantAppointedlist();
        $joinedlist_query = $this->circular_model->getAllApplicantJoinedlist();
        $trash_query = $this->circular_model->getAllTrashApplicant();
        $data = array(
            'all_interview_applicant' => $interviewlist_query['result'],
            'interview_num_row' => $interviewlist_query ['rows'],
            'selected_num_row' => $selectedlist_query ['rows'],
            'appointed_num_row' => $appointedlist_query ['rows'],
            'joined_num_row' => $joinedlist_query ['rows'],
            'trash_num_row' => $trash_query ['rows']
        );

        $this->load->view("recruitment/view_interview_applicant", $data);
    }

    public function selected_applicant() {
        $selectedlist_query = $this->circular_model->getAllApplicantSelectedlist();
        $appointedlist_query = $this->circular_model->getAllApplicantAppointedlist();
        $joinedlist_query = $this->circular_model->getAllApplicantJoinedlist();
        $trash_query = $this->circular_model->getAllTrashApplicant();
        $data = array(
            'all_selected_applicant' => $selectedlist_query['result'],
            'selected_num_row' => $selectedlist_query ['rows'],
            'appointed_num_row' => $appointedlist_query ['rows'],
            'joined_num_row' => $joinedlist_query ['rows'],
            'trash_num_row' => $trash_query ['rows']
        );

        $this->load->view("recruitment/view_selected_applicant", $data);
    }

    public function appointed_applicant() {
        $appointedlist_query = $this->circular_model->getAllApplicantAppointedlist();
        $joinedlist_query = $this->circular_model->getAllApplicantJoinedlist();
        $trash_query = $this->circular_model->getAllTrashApplicant();
        $data = array(
            'all_appointed_applicant' => $appointedlist_query['result'],
            'appointed_num_row' => $appointedlist_query ['rows'],
            'joined_num_row' => $joinedlist_query ['rows'],
            'trash_num_row' => $trash_query ['rows']
        );

        $this->load->view("recruitment/view_appointed_applicant", $data);
    }

    public function joined_applicant() {
        $joinedlist_query = $this->circular_model->getAllApplicantJoinedlist();
        $trash_query = $this->circular_model->getAllTrashApplicant();
        $data = array(
            'all_joined_applicant' => $joinedlist_query['result'],
            'joined_num_row' => $joinedlist_query ['rows'],
            'trash_num_row' => $trash_query ['rows']
        );
        $this->load->view("recruitment/view_joined_applicant", $data);
    }

    //---------- Tash View list -------------------------------------------------------------------------------------------------
    public function trash_circular() {
        $data = array();
        $data['all_circular'] = $this->circular_model->getAllTrashCircular();
        $this->load->view("recruitment/trash_circular", $data);
    }

    public function trash_applicant() {
        $query = $this->circular_model->getAllTrashApplicant();
        $data = array(
            'all_trash_applicant' => $query['result']
        );
        $this->load->view("recruitment/trash_applicant", $data);
    }

    public function post_circular() {
        $data = array();
        $data['alldivisions'] = $this->circular_model->getAllDivisions();
        $data['alldepartments'] = $this->circular_model->getAllDepartments();
        $data['allposts'] = $this->circular_model->getAllPost();
        $this->load->view("recruitment/post_circular", $data);
    }

    public function save_circular() {

        $startDate = date("Y-m-d", strtotime($this->input->post('txt_Start_Date', true)));
        $endDate = date("Y-m-d", strtotime($this->input->post('txt_Last_Date', true)));
        $date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $data = Array(
            'DivisionID' => $this->input->post('txt_division', true),
            'DepartmentID' => $this->input->post('txt_department', true),
            'PostID' => $this->input->post('txt_post', true),
            'StartDate' => $startDate,
            'EndDate' => $endDate,
            'JobType' => $this->input->post('txt_job_type', true),
            'JobLocation' => $this->input->post('txt_job_location', true),
            'JobExperience' => $this->input->post('txt_job_experience', true),
            'Education' => $this->input->post('txt_education', true),
            'ShortDescription' => $this->input->post('txt_short_description', true),
            'LongDescription' => $this->input->post('txt_long_description', true),
            'JobRequirments' => $this->input->post('txt_job_requirments', true),
            'Salary' => $this->input->post('txt_salary', true),
            'OtherBenifits' => $this->input->post('txt_other_benefit', true),
            'Vacancy' => $this->input->post('txt_vacancy', true),
            'CreatedBy' => $this->session->userdata('user_id'),
            'CreaedTime' => $date->format('Y-m-d H:i:s')
        );
        /* Start image upload */
        $config = Array(
            'upload_path' => 'resources/images/circularBanner/',
            'allowed_types' => 'gif|jpg|png',
            'max_size' => 1000,
            'max_width' => 740,
            'max_height' => 680
        );
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $error = '';
        $fdata = Array();
        if (!$this->upload->do_upload('text_banner_image')) {
            $error = $this->upload->display_errors();
            echo $error;
            //exit();
        } else {
            $fdata = $this->upload->data();
            $data['BannerImage'] = $config['upload_path'] . $fdata['file_name'];
        }
        /* End image upload */


        $result = $this->circular_model->insert_circular_info($data);
        $sdata = Array();
        if ($result) {
            $sdata['message'] = 'saved';
        } else {
            $sdata['error'] = 'fail';
        }
        $this->session->set_userdata($sdata);
        $this->post_circular();
    }

// Publisd / unpublish ---------------------------------------------------------------------------------------------------------------------
    public function update_applicant_status() { 
        $status = $this->uri->segment(3);
        $id = $this->uri->segment(4);
        $data = Array();
        if ($status == 'shortlist') {
            $data['Status'] = 1;
        } else if ($status == 'written') {
            $data['Status'] = 2;
        } else if ($status == 'interview') {
            $data['Status'] = 3;
        } else if ($status == 'selected') {
            $data['Status'] = 4;
        } else if ($status == 'appointed') {
            $data['Status'] = 5;
        } else if ($status == 'joined') {
            $data['Status'] = 6;
        } else {
            
        }
        $this->circular_model->update_applicant_status_info($id, $data);
//        if ($status == 'shortlist') {
//            $this->view_applicant();
//        } else if ($status == 'written') {
//            $this->shortlisted_applicant();
//        } else if ($status == 'interview') {
//            $this->written_applicant();
//        } else if ($status == 'selected') {
//            $this->interview_applicant();
//        } else if ($status == 'appointed') {
//            $this->selected_applicant();
//        } else if ($status == 'joined') {
//            $this->appointed_applicant();
//        }
        redirect("recruitment/view_applicant");
    }

    public function status() {
        $status = $this->uri->segment(3);
        $id = $this->uri->segment(4);
        $data = array();
        if ($status == 'approve') {
            $data['PublicationStatus'] = 1;
        }if ($status == 'unpublish') {
            $data['PublicationStatus'] = -1;
        }if ($status == 'publish') {
            $data['PublicationStatus'] = 1;
        }
//        echo $status;
//        print_r($data);
//        exit();
        $this->circular_model->update_status_info($id, $data);
        $this->view_circular();
    }

    // Details ------------------------------------------------------------------------------------------------------------------------------------    
    public function post_detail_by_id($id) {

        $data = Array(
            'display_detail_by_id' => $this->circular_model->select_detail_by_id($id)
        );
        //print_r( $data);
        // exit;
        $this->load->view("recruitment/post_details", $data);
    }

    public function applicant_detail_by_id($id) {

        $data = Array(
            'applicant_detail' => $this->circular_model->select_applicant_detail_by_id($id)
        );
        //print_r( $data);
        // exit;
        $this->load->view("recruitment/applicant_details", $data);
    }

    // edit ------------------------------------------------------------------------------------------------------------------------------------    
    public function post_edit_by_id($id) {

        $data = Array(
            'display_detail_by_id' => $this->circular_model->select_detail_by_id($id),
            'alldivisions' => $this->circular_model->getAllDivisions(),
            'alldepartments' => $this->circular_model->getAllDepartments(),
            'allposts' => $this->circular_model->getAllPost()
        );

//        print_r( $data);
//         exit;
        $this->load->view("recruitment/edit_circular", $data);
    }

    public function edit_circular() {
        $id = $this->input->post('circular_id');
        $startDate = date("Y-m-d", strtotime($this->input->post('txt_Start_Date', true)));
        $endDate = date("Y-m-d", strtotime($this->input->post('txt_Last_Date', true)));
        $date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $data = Array(
            'DivisionID' => $this->input->post('txt_division', true),
            'DepartmentID' => $this->input->post('txt_department', true),
            'PostID' => $this->input->post('txt_post', true),
            'StartDate' => $startDate,
            'EndDate' => $endDate,
            'JobType' => $this->input->post('txt_job_type', true),
            'JobLocation' => $this->input->post('txt_job_location', true),
            'JobExperience' => $this->input->post('txt_job_experience', true),
            'Education' => $this->input->post('txt_education', true),
            'ShortDescription' => $this->input->post('txt_short_description', true),
            'LongDescription' => $this->input->post('txt_long_description', true),
            'JobRequirments' => $this->input->post('txt_job_requirments', true),
            'Salary' => $this->input->post('txt_salary', true),
            'OtherBenifits' => $this->input->post('txt_other_benefit', true),
            'Vacancy' => $this->input->post('txt_vacancy', true),
            'CreatedBy' => $this->session->userdata('user_id'),
            'CreaedTime' => $date->format('Y-m-d H:i:s')
        );
        /* Start image upload */
        $config = Array(
            'upload_path' => 'resources/images/circularBanner/',
            'allowed_types' => 'gif|jpg|png',
            'max_size' => 1000,
            'max_width' => 740,
            'max_height' => 680
        );
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $error = '';
        $fdata = Array();
        if (!$this->upload->do_upload('text_banner_image')) {
            $error = $this->upload->display_errors();
            echo $error;
            //exit();
        } else {
            $fdata = $this->upload->data();
            $data['BannerImage'] = $config['upload_path'] . $fdata['file_name'];
        }
        /* End image upload */


        $result = $this->circular_model->edit_circular_info($id, $data);
        $sdata = Array();
        if (!$result) {
            $sdata['message'] = 'Data Updated Sucessfully';
        } else {
            $sdata['error'] = 'fail updated';
        }
        $this->session->set_userdata($sdata);
        redirect('recruitment/view_circular');
    }

    //Trash -------------------------------------------------------------------------------------------------------------------------------------
    public function delete_circular() {
        $id = $this->uri->segment(3);
        $this->circular_model->update_deletion_status_info($id);
        redirect('recruitment/view_circular');
    }

    public function trash_applicant_by_id() {
        $id = $this->uri->segment(4);
        $page = $this->uri->segment(3);
        $this->circular_model->update_applicant_deletion_status_info($id);
        redirect("recruitment/" . $page . "_applicant");
    }

    // restore -------------------------------------------------------------------------------------------------------------------------------------
    public function restore_circular() {
        $id = $this->uri->segment(3);
        $this->circular_model->restore_circular($id);
        $this->trash_circular();
    }

    public function restore_applicant() {
        $id = $this->uri->segment(3);
        $this->circular_model->restore_applicant($id);
        $this->trash_applicant();
    }

    //Permanently Delete -------------------------------------------------------------------------------------------------------------------------------------
    public function parmanently_delete_circular() {
        $id = $this->uri->segment(3);
        $this->circular_model->delete_circular($id);
        $this->trash_circular();
    }

    public function parmanently_delete_applicant() {
        $id = $this->uri->segment(3);
        $result = $this->circular_model->select_applicant_detail_by_id($id);
//        print_r($result);
//        exit();

        $applicant_image = $result->ApplicantImage;
        $file = $result->ApplicantCV;
        if (file_exists($applicant_image)) {
            if (!unlink($applicant_image)) {

                echo ("<script type='text/javascript'> alert('Error deleting $result->ApplicantName Image'); </script>");
            } else {
                echo ("<script type='text/javascript'> alert('Deleted $result->ApplicantName Image'); </script>");
            }
        } else {
            echo "<script type='text/javascript'> alert('$result->ApplicantName Image not found '); </script>";
        }
        if (file_exists($file)) {
            if (!unlink($file)) {
                echo ("<script type='text/javascript'> alert('Error deleting $result->ApplicantName CV'); </script>");
            } else {
                echo ("<script type='text/javascript'> alert('Deleted $result->ApplicantName CV'); </script>");
            }
        } else {
            echo "<script type='text/javascript'> alert('$result->ApplicantName CV not found '); </script>";
        }
        //exit();
        $this->circular_model->delete_applicant($id);
        $this->trash_applicant();
    }

    public function postcircular() {
        $searchpage = "post_circular";
        if ($this->input->post('add_btn')) {
            $this->recruitmentcontroller->addcircularaction($this->input->post());
            $msg = "Data inserted";
            $data['msg'] = $msg;
        }
        if ($this->uri->segment(3)) {
            $to_edit_id = ($this->uri->segment(3));
            $data['id'] = $to_edit_id;
            $data['toedit_records'] = $this->re_circular_model->get_data_by_id($to_edit_id);
        }

        $jobtitle_vid = 3;
        $data['alljobtitle'] = $this->taxonomy->getTaxonomyByvid($jobtitle_vid);
        $this->load->view("recruitment/postcircular", $data);
    }

    public function viewcircular() {
        $searchpage = "post_circular";
        $config = array();
        $config["base_url"] = base_url() . "recruitment/viewcircular";
        $total_row = $this->re_circular_model->search_record_count();
        $per_page_query = 20;
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
        $data["records"] = $this->re_circular_model->get_all_data($config["per_page"], $page);
        $jobtitle_vid = 3;
        $data['alljobtitle'] = $this->taxonomy->getTaxonomyByvid($jobtitle_vid);
        $this->load->view("recruitment/viewcircular", $data);
    }

    function deletecircular() {
        if ($this->uri->segment(3)) {
            $id = ($this->uri->segment(3));
            $this->re_circular_model->deletecertificate($id);
            redirect("recruitment/viewcircular");
        }
    }

    public function candidateresume() {
        if ($this->uri->segment(3)) {
            $content_id = ($this->uri->segment(3));
            $data['candidate_search_tbl'] = $this->re_circular_model->getallsearch_table_contentByid($content_id);
            $data['defaultcontent_id'] = $content_id;

            // $data['allhistory'] = $this->emp_job_history_model->getalljobhistorybyasc($default_emp_id['search_query']);  
            $this->load->view('recruitment/candidateresume', $data);
        }
    }

    public function candidateresumepdf() {
        if ($this->uri->segment(3)) {
            $content_id = ($this->uri->segment(3));
            $data['candidate_search_tbl'] = $this->re_circular_model->getallsearch_table_contentByid($content_id);
            $data['defaultcontent_id'] = $content_id;

            // $data['allhistory'] = $this->emp_job_history_model->getalljobhistorybyasc($default_emp_id['search_query']);  
            $mpdf = $this->pdf->load();
            $html = $this->load->view('recruitment/printcandidateresumepdf', $data, true);

            $mpdf->SetJS('this.print();');
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output();
        }
    }

    public function exportcandidate() {
        // $this->check_permission_controller->check_permission_action("add_edit_profile");
        $division_vid = 1;
        $department_vid = 2;
        $jobtitle_vid = 3;
        $typeofemployee_vid = 4;
        $qualification_vid = 5;
        $religion_vid = 6;
        $marital_status_vid = 7;
        $bloodgroup_vid = 8;
        $allleavetype_vid = 16;
        $allpaytype_vid = 9;
        $bankname_vid = 10;
        $city_vid = 11;
        $distict_vid = 12;
        $relative_vid = 14;
        $grade_vid = 15;
        $workingshift_vid = 21;
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
        $data['allworkingshift'] = $this->taxonomy->getTaxonomyByvid($workingshift_vid);
        $data['alltypeofemployee'] = $this->taxonomy->getTaxonomyByvid($typeofemployee_vid);
        $data['allqualification'] = $this->taxonomy->getTaxonomyByvid($qualification_vid);
        $data['allreligion'] = $this->taxonomy->getTaxonomyByvid($religion_vid);
        $data['allmarital_status'] = $this->taxonomy->getTaxonomyByvid($marital_status_vid);
        $data['allbloodgroup'] = $this->taxonomy->getTaxonomyByvid($bloodgroup_vid);
        $data['allpaytype'] = $this->taxonomy->getTaxonomyByvid($allpaytype_vid);
        $data['allbankname'] = $this->taxonomy->getTaxonomyByvid($bankname_vid);
        $data['allcity'] = $this->taxonomy->getTaxonomyByvid($city_vid);
        $data['alldistict'] = $this->taxonomy->getTaxonomyByvid($distict_vid);
        $data['allrelative'] = $this->taxonomy->getTaxonomyByvid($relative_vid);
        $data['country'] = $this->hs_hr_country->getCountry();
        $data['allgrade'] = $this->taxonomy->getTaxonomyByvid($grade_vid);
        // $data['allleavetype'] = $this->taxonomy->getTaxonomyByvid($allleavetype_vid);        
        if ($this->uri->segment(3)) {
            $content_id = ($this->uri->segment(3));
            $data['toedit_id'] = $content_id;
            $data['emp_details_records'] = $this->re_circular_model->getallcontentByid($content_id);
            $data['search_field_emp_data'] = $this->re_circular_model->getallsearch_table_contentByid($content_id);
            $this->session->set_userdata('session_redirect', $this->uri->uri_string());
            $this->load->view('recruitment/exportcandidate', $data);
        } else {
            redirect('recruitment_pub/findcandidates');
        }
        // $this->session->set_flashdata('redirect', validation_errors());
        //     redirect('addprofile/addemployee');
    }

    function do_upload() {

        $this->form_validation->set_rules('emp_name', 'Name', 'required');
        $this->form_validation->set_rules('emp_fathername', 'Father\'s Name', 'required');
        $this->form_validation->set_rules('emp_division', 'Division', 'required');
        $this->form_validation->set_rules('emp_department', 'Department', 'required');
        $this->form_validation->set_rules('emp_gender', 'Gender', 'required');
        $this->form_validation->set_rules('emp_dob', 'Date of Birth', 'required');
        $this->form_validation->set_rules('emp_starting_date', 'Joining Date', 'required');
        $this->form_validation->set_rules('emp_type', 'Type Of Employee', 'required');
        $this->form_validation->set_rules('emp_position', 'Position', 'required');
        $this->form_validation->set_rules('emp_grade', 'Grade', 'required');
        $edit_id = $this->input->post('content_id');
        $content_id_candidate = $this->input->post('content_id_candidate');
        $this->form_validation->set_rules('content_id', 'Content ID', 'is_unique[employee_id.id]');
        $this->form_validation->set_rules('emp_id', 'Employee Code', 'required|is_unique[employee_id.emp_id]');
        $this->form_validation->set_rules('content_id', 'Content ID', 'is_unique[search_field_emp.content_id]');
        $this->form_validation->set_rules('emp_id', 'Employee Code', 'required|is_unique[search_field_emp.emp_id]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('addprofile/addemployee');
            //redirect($this->session->flashdata('redirect'));
        } else {

            $content_id = $this->employee_id_model->getLastcontentId();
            $toadd_id = $content_id + 1;
            $emp_id = $this->input->post('emp_id');
            $params_employee_id = array(
                'id' => '',
                'emp_id' => $emp_id,
                'author' => $this->session->userdata('user_id'),
                'created' => getCurrentDateTime(),
                'updated' => getCurrentDateTime(),
                'status' => 1,
            );
            $content_ids = $this->db->insert("employee_id", $params_employee_id);
            $insert_id = $this->db->insert_id();
            $file_counter = $_FILES['file'];
            echo "string";
            foreach ($_FILES['file'] as $key => $val) {
                $i = 1;
                foreach ($val as $v) {
                    $field_name = "file_" . $i;
                    $_FILES[$field_name][$key] = $v;
                    $i++;
                }
            }
            // Unset the useless one ;)
            unset($_FILES['file']);
            foreach ($_FILES['documents'] as $key => $val) {
                $i = 1;
                foreach ($val as $v) {
                    $field_name = "documents_" . $i;
                    $_FILES[$field_name][$key] = $v;
                    $i++;
                }
            }
            // Unset the useless one ;)
            unset($_FILES['documents']);
            $content_repeat = 0;
            $content_repeat2 = 0;
            foreach ($_FILES as $field_name => $file) {

                $new_name = time() . "_" . $file['name'];
                $new_name = str_replace(' ', '_', $new_name);
                $lastDot = strrpos($new_name, ".");
                $new_name = str_replace(".", "", substr($new_name, 0, $lastDot)) . substr($new_name, $lastDot);
                if ($field_name == "file_1") {
                    $upload_conf = array(
                        'upload_path' => './resources/uploads/',
                        'allowed_types' => 'gif|jpg|png',
                        'max_size' => '3000',
                        'remove_spaces' => TRUE,
                        'file_name' => $new_name,
                    );
                    if ($file['name']) {
                        $params_content = array(
                            'id' => '',
                            'content_id' => $insert_id,
                            'emp_id' => $emp_id,
                            'field_repeat' => $content_repeat,
                            'field_name' => 'resources/uploads',
                            'field_value' => $new_name,
                        );
                        $this->db->insert("emp_details", $params_content);
                        $content_repeat++;
                    }
                } else {
                    if ($file['name']) {
                        $upload_conf = array(
                            'upload_path' => './resources/uploads/documents/',
                            'allowed_types' => 'gif|jpg|png|pdf|doc|docs|txt',
                            'max_size' => '30000',
                            'remove_spaces' => TRUE,
                            'file_name' => $new_name,
                        );
                        $params_content2 = array(
                            'id' => '',
                            'content_id' => $insert_id,
                            'emp_id' => $emp_id,
                            'field_repeat' => $content_repeat2,
                            'field_name' => 'resources/uploads/documents',
                            'field_value' => $new_name,
                        );
                        $this->db->insert("emp_details", $params_content2);
                        $content_repeat2++;
                    }
                }
                if ($file['name']) {
                    $this->upload->initialize($upload_conf);
                    $this->upload->do_upload($field_name);
                }
            }
            //end of documents uploads 
            foreach ($this->input->post() as $key => $val) {
                if ($key == 'emp_provision_starting_date' && $this->input->post('emp_type') == '155') {
                    $this->add_provision_controller->add_provision_action($this->input->post(), $toadd_id);
                } else if ($key == 'attendance_required') {
                    $this->add_workingtime_controller->add_workingtime_action($this->input->post(), $toadd_id);
                    $this->add_empshifthistory_controller->add_empshifthistory_action($this->input->post(), $toadd_id);
                } else if ($key == 'emp_basic_salary') {
                    $this->add_salary_controller->add_salary_action($this->input->post(), $toadd_id);
                } else if ($key == 'emp_total_deduction') {
                    $this->add_salarydeduction_controller->add_deduction_action($this->input->post(), $toadd_id);
                } else if ($key == 'emp_pay_type') {
                    $this->add_paymentmethod_controller->add_paymentmethod_action($this->input->post(), $toadd_id);
                } else if ($key == 'emp_weekly_holiday') {
                    $this->add_holiday_controller->add_holiday_action($this->input->post(), $toadd_id);
                    $this->add_weeklyholidayhistory_controller->add_weeklyholidayhistory_action($this->input->post(), $toadd_id);
                } else if ($key == 'annual_leave_total') {
                    $this->add_leave_controller->add_yearlyleave_action($this->input->post(), $toadd_id);
                    $this->add_leave_controller->add_yearlyleavehistory_action($this->input->post(), $toadd_id);
                } else if (trim($val) && $key != 'emp_name' && $key != 'emp_id' && $key != 'content_id' && $key != 'emp_division' && $key != 'emp_department' && $key != 'emp_position' && $key != 'emp_gender' && $key != 'emp_dob' && $key != 'emp_marital_status' && $key != 'emp_religion' && $key != 'emp_age' && $key != 'emp_starting_date' && $key != 'emp_type' && $key != 'emp_present_salary' && $key != 'emp_visa_selling' && $key != 'emp_pay_type' && $key != 'emp_current_distict' && $key != 'emp_mobile_no' && $key != 'emp_nid' && $key != 'emp_provision_ending_date' && $key != 'emp_working_time_from' && $key != 'emp_working_end_time' && $key != 'attendance_required' && $key != 'emp_latecount_time' && $key != 'logout_required' && $key != 'emp_salary_update' && $key != 'emp_salary_increment' && $key != 'emp_basic_salary' && $key != 'emp_house_rent' && $key != 'emp_medical_allowance' && $key != 'emp_conveyance' && $key != 'emp_conveyance' && $key != 'emp_telephone_allowance' && $key != 'emp_special_allowance' && $key != 'emp_provident_fund_allowance' && $key != 'emp_transport_allowance' && $key != 'emp_other_allowance' && $key != 'emp_performance_bonus' && $key != 'emp_festival_bonus' && $key != 'emp_total_benifit' && $key != 'emp_gross_salary' && $key != 'emp_yearly_paid' && $key != 'emp_provident_fund_deduction' && $key != 'emp_other_deduction' && $key != 'emp_total_deduction' && $key != 'emp_bank' && $key != 'emp_bank_branch' && $key != 'emp_bank_account' && $key != 'emp_pay_type' && $key != 'emp_grade' && $key != 'emp_salary_increment_amount' && $key != 'emp_increment_percentage' && $key != 'emp_increment_date' && $key != 'emp_weekly_holiday' && $key != 'annual_leave' && $key != 'leave_total_system' && $key != 'leave_category_system' && $key != 'annual_leave_total' && $key != 'emp_earlycount_time' && $key != 'half_day_absent' && $key != 'overtime_count' && $key != 'curr_doc_' && $key != 'absent_count_time' && $key != 'emp_job_change_date' && $key != 'emp_shift' && $key != 'content_id_candidate') {

                    if ($key == 'current_img' && !$file_counter['name'][0]) {
                        $key = "resources/uploads";
                    }
                    $params_contents = array(
                        'id' => '',
                        'content_id' => $insert_id,
                        'emp_id' => $emp_id,
                        'field_repeat' => 0,
                        'field_name' => $key,
                        'field_value' => trim($val),
                    );
                    if ($key == 'current_img' && $file_counter['name'][0]) {
                        
                    } else {
                        $this->db->insert("emp_details", $params_contents);
                    }
                }
            }

            // insert job history
            $this->add_empjobhistory_controller->add_empjobhistory_action($this->input->post(), $insert_id);
            // insert employee search table
            $params_content_id = array(
                'id' => '',
                'content_id' => $insert_id,
                'emp_id' => $emp_id,
                'emp_name' => $this->input->post('emp_name'),
                'emp_division' => $this->input->post('emp_division'),
                'emp_department' => $this->input->post('emp_department'),
                'emp_post_id' => $this->input->post('emp_position'),
                'grade' => $this->input->post('emp_grade'),
                'gender' => $this->input->post('emp_gender'),
                'dob' => $this->input->post('emp_dob'),
                'marital_status' => $this->input->post('emp_marital_status'),
                'religion' => $this->input->post('emp_religion'),
                'age' => $this->input->post('emp_age'),
                'joining_date' => $this->input->post('emp_starting_date'),
                'type_of_employee' => $this->input->post('emp_type'),
                'visa_selling' => $this->input->post('emp_visa_selling'),
                'pay_type' => $this->input->post('emp_pay_type'),
                'distict' => $this->input->post('emp_current_distict'),
                'mobile_no' => $this->input->post('emp_mobile_no'),
                'national_id' => $this->input->post('emp_nid'),
            );
            $content_ids = $this->db->insert("search_field_emp", $params_content_id);
            $inserted_id_search_field_emp = $this->db->insert_id();
            // insert candidates status  
            $this->deleteCandidatesBycontentid($content_id_candidate);
            $this->session->set_flashdata('success', "Data Added");
            $content_id_redirect = $this->employee_id_model->getLastcontentId();
            redirect('addprofile/addemployee/' . $content_id_redirect);
            // redirect($this->session->flashdata('redirect'));                                        
        }
    }

    public function edit_unique($value, $params) {
        $this->form_validation->set_message('edit_unique', 'The %s is already being used by another account.');

        list($table, $field, $id) = explode(".", $params, 3);

        $query = $this->db->select($field)->from($table)
                        ->where($field, $value)->where('id !=', $id)->limit(1)->get();

        if ($query->row()) {
            return false;
        } else {
            return true;
        }
    }

    function deleteCandidatesBycontentid($content_id_candidate) {
        $file_name_value = "resources/uploads";
        $image_exist = $this->re_circular_model->getcontentByidandname($content_id_candidate, $file_name_value);
        if ($image_exist) {
            $current_img = $image_exist[0]['field_value'];
            unlink('./resources/uploads/' . $current_img);
        }
        $this->re_circular_model->deleteCandidatesByid($content_id_candidate);
    }

}

?>