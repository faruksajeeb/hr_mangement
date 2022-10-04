<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Calendar extends CI_Controller {

    function __construct() {
      error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

       
    }

    public function index() {
      // $this->db2= $this->load->database('test', true);  
      // $query = $this->db2->get('circular');
      // echo "<pre>";
      // print_r($query->result());
      // echo "</pre>";
      // $this->db2= $this->load->database('sqldatabase', true);  
      // $query = $this->db2->get('KQZ_Employee');
      // echo "<pre>";
      // print_r($query->result());
      // echo "</pre>";
       redirect("calendar/display");
      
    }
function display($year=null, $month=null){
  if(!$year){
    $year=date('Y');
  }
  if(!$month){
    $month= date('m');
  }
  $this->load->model("mycal_model");
  if($day = $this->input->post('day')){
    $this->mycal_model->add_calendar_data(
      "$year-$month-$day",
      $this->input->post('data')
      );
  }
  $data['calendar']=$this->mycal_model->generate($year, $month);
  $this->load->view('recruiting/mycal', $data);
}


}

?>