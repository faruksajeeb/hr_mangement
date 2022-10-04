<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Deletecontent extends CI_Controller {

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
    }
    function deletetaxonomy() {
        if ($this->uri->segment(3)) {
            $taxonomy_id = ($this->uri->segment(3));
            $this->taxonomy->deleteTexanomy($taxonomy_id);
            redirect($this->session->flashdata('redirect'));
             //redirect($final_controller_url);
        }
    }

    function deletesalary() {
        if ($this->uri->segment(3)) {
            $id = ($this->uri->segment(3));
            $this->emp_salary_model->deleteSalary($id);
            //redirect($this->session->flashdata('redirect'));
            redirect($this->session->userdata('session_redirect'));
             //redirect($final_controller_url);
        }
    }    
    function deleteinformed() {
        if ($this->uri->segment(3)) {
            $id = ($this->uri->segment(3));
            $this->emp_informed_model->deleteInformed($id);
            redirect("reports/informedreports");
        }
    } 
    function deleteinformedmultiple() {
        $ids = $this->input->post('id');
        if ($ids) {
            foreach ($ids as $single_id) {
                if($single_id){
                     $this->emp_informed_model->deleteInformed($single_id);
                }
            }
        }
        redirect("reports/informedreports");
    }   
    function deleteloged() {
        if ($this->uri->segment(3)) {
            $id = ($this->uri->segment(3));
            $this->log_maintenence_model->deleteLoged($id);
            redirect("reports/logerrorreports");
        }
    }  
    function deletelogedmultiple() {
        $ids = $this->input->post('id');
        if ($ids) {
            foreach ($ids as $single_id) {
                if($single_id){
                     $this->log_maintenence_model->deleteLoged($single_id);
                }
            }
        }
        redirect("reports/logerrorreports");
    }  
        function deleteCandidate() {
        if ($this->uri->segment(3)) {
            $content_id = ($this->uri->segment(3));

            $file_name_value = "resources/uploads";
            $image_exist = $this->re_circular_model->getcontentByidandname($content_id, $file_name_value);
            if($image_exist){
            $current_img = $image_exist[0]['field_value'];
            unlink('./resources/uploads/' . $current_img);
            }
            $this->re_circular_model->deleteCandidatesByid($content_id);
        }

        redirect('recruitment_pub/findcandidates');
    }

    

}

?>