<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ramadan extends CI_Controller {

    function __construct() {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->helper('form'); 
        $this->load->helper('security');   
        $this->load->model('ramadan_model');   
    }

    public function index() {
        redirect("ramadan/addschedule");
    }

    function manage_ramadan_schedule() {     
        $data['display_all_ramadan_info']=$this->ramadan_model->select_ramadan_scdedule_info();
        $this->load->view('settings/manage_ramadan_schedule', $data);
    }
    function save_ramadan_schedule(){
//        print_r($this->input->post());
//        exit;
        $this->form_validation->set_rules('ramadan_year', 'year', 'required');
        $this->form_validation->set_rules('start_date', 'start_date', 'required');
        $this->form_validation->set_rules('end_date', 'end_date', 'required');
        $this->form_validation->set_rules('late_count_time', 'late_count_time', 'required');
        $this->form_validation->set_rules('early_count_time', 'early_count_time', 'required');
        if ($this->form_validation->run() == FALSE) {
            // $this->load->view('myform');
//             echo $this->input->post('category_type_id');
//            exit;
            $this->manage_ramadan_schedule();
        } else {

            $id = $this->input->post('id');
            if (!$id) {
                $data = array(
                    'year' => $this->input->post('ramadan_year', true),
                    'start_date' => $this->input->post('start_date', true),
                    'end_date' => $this->input->post('end_date', true),
                    'late_count_time' => $this->input->post('late_count_time', true),
                    'early_count_time' => $this->input->post('early_count_time', true),
                   
                );
                $result = $this->ramadan_model->insert_table_info($data);
            } else {
                $data = array(
                    'year' => $this->input->post('ramadan_year', true),
                    'start_date' => $this->input->post('start_date', true),
                    'end_date' => $this->input->post('end_date', true),
                    'late_count_time' => $this->input->post('late_count_time', true),
                    'early_count_time' => $this->input->post('early_count_time', true),
                   
                );
                $result = $this->ramadan_model->update_table_info($id,$data);
            }
            $this->manage_ramadan_schedule();
        }
    
    }
}

?>