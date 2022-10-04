<?php

class Savepdfcar extends CI_Controller {

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
        redirect("savepdfcar/printcarcostpdf");
    }

    //mpdf function
    public function printcarcostpdf() {
        $searchpage="viewcarcost";                
        $user_id = $this->session->userdata('user_id');
        $data["records"] = $this->car_info_model->get_all_carcost($searchpage); 
        $mpdf = $this->pdf->load();
        $html = $this->load->view('print/car/printcarcostpdf', $data, true); 
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetVisibility('hidden');
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output();
    }
      public function printcarlistpdf() {
         $searchpage="cars";                
        $user_id = $this->session->userdata('user_id');
        $data["records"] = $this->car_info_model->get_all_carlist($searchpage);  
        $mpdf = $this->pdf->load();
        $html = $this->load->view('print/car/printcarlistpdf', $data, true); 
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetVisibility('hidden');
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output();
    }
}

?>