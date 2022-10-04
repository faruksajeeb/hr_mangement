<?php
 
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Posthistory extends CI_Controller {

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
    
  }

  public function index() {
    redirect("posthistory/jobhistorysingle");
  }
  
  public function jobhistorysingle(){
    $this->check_permission_controller->check_permission_action("view_job_history");
    $searchpage="jobhistorysingle";
    if($this->input->post()){
      $this->form_validation->set_rules('emp_name', 'Name', 'required');
      //$this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
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
     // $emp_att_start_date=$this->input->post('emp_attendance_start_date');
      $content_id = $this->employee_id_model->getemp_idby_empcode($emp_id);             
        $query=$content_id;
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

    $default_emp_id=$this->search_field_emp_model->getsearchQuery($searchpage);
    $att_date_arr=explode("-", $default_emp_id['search_query']) ; 
   
    $data['defaultcontent_id']=$default_emp_id['search_query'];
    $data['default_emp']=$this->search_field_emp_model->getallsearch_table_contentByid($default_emp_id['search_query']);  
    $user_type = $this->session->userdata('user_type');
    $user_id = $this->session->userdata('user_id');
    $user_data=$this->users_model->getuserbyid($user_id);
    $user_division_id=$user_data['user_division'];
    $data['user_info']=$this->users_model->getuserbyid($user_id);
    $data['user_type_id'] =$this->session->userdata('user_type');
    if($user_type !=1){
      $data['allemployee']=$this->search_field_emp_model->getallemployeebydivision($user_division_id);
    }else{
      $data['allemployee']=$this->search_field_emp_model->getAllEmployees();
    } 
    $data['allhistory'] = $this->emp_job_history_model->getalljobhistorybyasc($default_emp_id['search_query']);  
    $this->load->view('reports/job/job_history_single',$data);
  }

    public function singlejobhistorypdf() {
    $searchpage="jobhistorysingle";                 
    $default_emp_id=$this->search_field_emp_model->getsearchQuery($searchpage);
    $att_date_arr=explode("-", $default_emp_id['search_query']) ; 
   
    $data['defaultcontent_id']=$default_emp_id['search_query'];
    $data['default_emp']=$this->search_field_emp_model->getallsearch_table_contentByid($default_emp_id['search_query']);  
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
    $data['allhistory'] = $this->emp_job_history_model->getalljobhistorybyasc($default_emp_id['search_query']); 

        $mpdf = $this->pdf->load();
        $html = $this->load->view('print/job/printsinglejobhistorypdf', $data, true);
       // $mpdf->SetProtection(array('print'), 'pass2open', 'pass2havefullaccess');
        // $mpdf->SetVisibility('screenonly'); 
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetVisibility('hidden');
       // $mpdf->SetProtection(array('copy','print','modify'), 'r', 'MyPassword');
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output();
    }  
    
    function deleteJobHistory($id){   
        $empJobHistory = $this->emp_job_history_model->getJobHistoryById($id);
        $empContentId = $empJobHistory->content_id;
        $deleteOk = $this->emp_job_history_model->deleteJobHistoryById($id);
        if($deleteOk){
            $empLastJobHistory = $this->emp_job_history_model->getemp_last_job_history($empContentId);
            $updateData = array(
                    'end_date' => ''
            );
            $returnUpdateOk = $this->emp_job_history_model->updateJobHistoryById($empLastJobHistory['id'],$updateData);
            if($returnUpdateOk){
                // if job history update now update search_field_emp update emp type.
                $empUpdateData = array(
                    'emp_division' => $empLastJobHistory['division_tid'],
                    'emp_department' => $empLastJobHistory['department_tid'],
                    'department_id' => $empLastJobHistory['department_id'],
                    'emp_post_id' => $empLastJobHistory['post_tid'],
                    'grade' => $empLastJobHistory['grade_tid'],
                    'type_of_employee' => $empLastJobHistory['emp_type_tid']
                );
                $condition = array('content_id' => $empLastJobHistory['content_id']);
                $this->search_field_emp_model->updSearch_field_contenttbl($empUpdateData, $condition);
                if($empLastJobHistory['emp_type_tid']==155){
                    $updateProvisionData = array(
                        'insertflag' => 0,
                        'updated' => getCurrentDateTime(),
                        'updated_by' => $this->session->userdata('user_id')
                    );
                    $this->emp_provision_model->updEmp_provisiontbl($updateProvisionData, $condition);
                }
            }
            $this->session->set_flashdata('success', 'Job History deleted!');
        }
      redirect("posthistory/jobhistorysingle");          
    }  
}

?>