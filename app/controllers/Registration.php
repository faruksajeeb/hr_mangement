<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registration extends CI_Controller {

    function __construct() {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        $this->load->helper('form'); 
        $this->load->helper('security');       
       
    }

    public function index() {
        redirect("registration/userregistration");
    }

    function userregistration() {

        if($this->input->post('add_btn')){  
            $edit_id=$this->input->post('content_id');
            $password=$this->input->post('password');
            $confirm_password=$this->input->post('confirm_password');         
            $this->form_validation->set_rules('employee_id', 'Employee id', 'required');
            $this->form_validation->set_rules('fullname', 'Name', 'required');
            //$this->form_validation->set_rules('user_type', 'User Type', 'required');
            if($edit_id){
                $this->form_validation->set_rules('user_name', 'Username', 'required|min_length[4]|max_length[12]|callback_edit_unique[users.username.' . $edit_id . ']');
                $this->form_validation->set_rules('email_address', 'Email', 'required|valid_email|callback_edit_unique[users.email.' . $edit_id . ']');
            }else{
                $this->form_validation->set_rules('user_name', 'Username', '|trim|required|min_length[4]|max_length[12]|is_unique[users.username]');
                $this->form_validation->set_rules('email_address', 'Email', '|trim|required|valid_email|is_unique[users.email]');
            }

            if(!$edit_id){
                $this->form_validation->set_rules('password', 'Password', '|trim|required|matches[confirm_password]');
                $this->form_validation->set_rules('confirm_password', 'Confirm password', '|trim|required'); 
            }else if(($edit_id) && ($password || $confirm_password)){
                $this->form_validation->set_rules('password', 'Password', '|trim|required|matches[confirm_password]');
                $this->form_validation->set_rules('confirm_password', 'Confirm password', '|trim|required');  
            }           
            if ($this->form_validation->run() == FALSE) {
                $msg = "Please fill up data correctly";
                $data['msg']=$msg;
            } else {
                $this->add_user_controller->register_action($this->input->post());
                $msg = "Data inserted";
                $data['msg']=$msg;
            }
        }      
        $division_vid = 1; 
        $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);  
        // if($this->uri->segment(3)){
        //     $to_edit_id = ($this->uri->segment(3)) ;
        //     $data['id']=$to_edit_id;
        //     $user_data=$this->users_model->getuserbyid($to_edit_id);
        //     $data['toedit_records']=$this->users_model->getuserbyid($to_edit_id);
        //     $data['department_selected'] = $this->taxonomy->getTaxonomychildbyparent($user_data['user_division']); 
        // }        
        $this->load->view('settings/userregistration', $data);
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
 
}

?>