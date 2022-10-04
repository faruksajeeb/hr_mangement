<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Company extends CI_Controller {

    function __construct() {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        
    }

    public function index() {
        //$this->load->view('recruiting/addprofile');
        redirect("company/addcompany");
    }
    public function addcompany() {
        //echo  getTimeDiff("09:30:01","13:32:11");
        $data['companydetails']=$this->company_info->getcompany();
        $this->load->view('recruiting/addcompany',$data);
    }

}

?>