<?php

class Savepdfemployee extends CI_Controller {

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

    function index() {
        redirect("savepdf/singleattendancereportspdf");
    }

    //mpdf function
    public function singleattendancereportspdf() {
    $searchpage="monthlyattendancereports";                 
    $default_emp_id=$this->search_field_emp_model->getsearchQuery($searchpage);
    $content_id=$default_emp_id['search_query'];
    $emp_att_start_date=$default_emp_id['table_view'];
    $emp_att_end_date=$default_emp_id['per_page'];   
    $data['defaultcontent_id']=$default_emp_id['search_query'];
    $data['defaultstart_date']=$default_emp_id['table_view'];
    $data['defaultend_date']=$default_emp_id['per_page'];        
    $data['default_emp']=$this->search_field_emp_model->getallsearch_table_contentByid($default_emp_id['search_query']); 
    $emp_details=$this->search_field_emp_model->getallsearch_table_contentByid($content_id); 
    $data['emp_details_info']=$this->search_field_emp_model->getallsearch_table_contentByid($content_id); 
    $data['emp_working_time']=$this->emp_working_time_model->getcontentByid($content_id);
    $data['emp_division']=$this->taxonomy->getTaxonomyBytid($emp_details['emp_division']);
    $data['date_range']=dateRange( $emp_att_start_date, $emp_att_end_date);
    $data['emp_content_id']=$content_id;
    $data['emp_attendance']=$this->emp_attendance_model->getemp_attbyrange($content_id, $emp_att_start_date, $emp_att_end_date);           
    $data['allemployee']=$this->search_field_emp_model->getallemployee();
        $mpdf = $this->pdf->load();
        $html = $this->load->view('print/printsingleattendancepdf', $data, true);
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