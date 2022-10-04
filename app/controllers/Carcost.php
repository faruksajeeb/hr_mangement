<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Carcost extends CI_Controller {

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
        
    }

    public function index() {

        //$this->load->view('recruiting/addprofile');
        redirect("vahicles/addcar");
    }
    public function addcarcost() {
        if($this->input->post()){
            $this->form_validation->set_rules('cost_type', 'Cost Type', 'required');
            $this->form_validation->set_rules('Car_Name', 'Car Name', 'required');
            $this->form_validation->set_rules('cost_amount', 'Cost Amount', 'required');
            $this->form_validation->set_rules('car_cost_date', 'Cost Date', 'required');
            if($this->form_validation->run()==FALSE)
            {
                $this->session->set_flashdata('errors', validation_errors());
            }else{
                $this->add_carcost_controller->add_carcost_action($this->input->post());
            }
        }          
        if($this->uri->segment(3)){
            $id = ($this->uri->segment(3)) ;
            $data['toedit_id']=$id;                     
            $data['cost_info'] = $this->car_info_model->getcost_info($id);
            $data['car_documents']=$this->car_info_model->getallcontentByid($id);  
            $data['documents'] = $this->car_info_model->getsinglebiodocuments($id);                   
        }
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->session->set_userdata('session_redirect', $this->uri->uri_string());
        $costtype_vid = 20;
        $data['allcosttype']=$this->taxonomy->getTaxonomyByvid($costtype_vid);
        $data['allemployee']=$this->search_field_emp_model->getallemployee();
        $data['alltransportemployee']=$this->car_info_model->getalltransportemployee();
        $data['allactivecar']=$this->car_info_model->getallactivecar();
        $this->load->view('car/addcarcost',$data);
    }   







public function getcarcodeid() {
    header('Content-type: application/json');
    $vehicle_code = $this->input->post('vehicle_code');
    $car_id = $this->car_info_model->getcar_infobycardcode($vehicle_code);
    echo json_encode($car_id);

}

    public function addcosttype() {
        if($this->input->post('add_btn')){
            $this->addcarcosttypecontroller->addcarcosttypeaction($this->input->post());
            $msg = "Data inserted";
            $data['msg']=$msg;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $costtype_vid = 20;
        $data['allcosttype'] = $this->taxonomy->getTaxonomyByvid($costtype_vid);
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('car/addcosttype',$data);
    }
   
}

?>