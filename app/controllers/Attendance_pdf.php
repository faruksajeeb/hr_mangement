<?php

class Attendance_pdf extends CI_Controller {

    function __construct() {
      error_reporting(0);
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->helper(array('form', 'url'));
        $this->load->library('pagination');
        $this->load->library("pdf");
    }
      
  public function monthly_attendance_reports_summery_pdf(){
          //  $this->load->library("pdf");
           //         echo 'ok';
            //   exit;
            if($this->input->post()){
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            $this->form_validation->set_rules('emp_attendance_end_date', 'Attendance End Date', 'required');
            $this->form_validation->set_rules('emp_division', 'Division Field', 'required');
            if($this->form_validation->run()==FALSE)
            {
           
              $this->session->set_flashdata('errors', validation_errors());
              redirect('attendance_summery_reports/monthly_attendance_summery_reports');
            }else{
          //       echo 'ok';
           //     exit;
            $emp_division=$this->input->post('emp_division');
            $emp_att_start_date=$this->input->post('emp_attendance_start_date');
            $emp_att_end_date=$this->input->post('emp_attendance_end_date');
            $startDate = date("Y-m-d", strtotime( $emp_att_start_date));
            $endDate = date("Y-m-d", strtotime( $emp_att_end_date));
//            echo   $startDate;
//            exit;
            $data['defaultdivision_id']=$emp_division;
            $data['defaultstart_date']=$emp_att_start_date; 
            $data['start_date']=$startDate; 
            $data['end_date']=$endDate;           
            $data['defaultend_date']=$emp_att_end_date;           
            $data['date_range']=dateRange($emp_att_start_date, $emp_att_end_date);
                if($emp_division=='all'){
                  $data['defsultdivision_name']="All";
                  $data['defsultdivision_shortname']="All";
                  $data['default_employee']=$this->search_field_emp_model->getallemployeeorderdivision();
                 
                }else if($emp_division){
                
                  $data['default_employee']=$this->search_field_emp_model->get_all_employee_info_by_division($emp_division,$startDate,$endDate); 
                } 
//                  print_r($data['default_employee']);
//                  exit();
              // if($emp_division){
              //   $data['default_employee']=$this->search_field_emp_model->getallemployeebydivision($emp_division); 
              // } 

              $emp_division_info=$this->taxonomy->getTaxonomyBytid($emp_division);
              $data['defsultdivision_name']=$emp_division_info['name'];   
        
              
    
              $mpdf = $this->pdf->load();
              $html = $this->load->view('print/print_monthly_attendance_summery_pdf_new', $data, true);
              //$mpdf->SetVisibility('printonly'); // This will be my code; 
              $mpdf->SetJS('this.print();');
              $mpdf->WriteHTML(utf8_encode($html));
              $mpdf->Output();                        
            }
          }        
  }    
 
}

?>