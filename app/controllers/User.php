<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->helper('form');
        $this->load->helper('security');
    }

    public function index() {
        redirect("user/adduser");
    }

    public function addtasktype() {
        if ($this->input->post('add_btn')) {
            $this->add_tasktype_controller->add_tasktype_action($this->input->post());
            $msg = "Data inserted";
            $data['msg'] = $msg;
        }
        if ($this->uri->segment(3)) {
            $to_edit_id = ($this->uri->segment(3));
            $data['id'] = $to_edit_id;
            $data['toedit_records'] = $this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $task_vid = 13;
        $data['alltask'] = $this->taxonomy->getTaxonomyByvid($task_vid);
        $this->load->view('settings/addtasktype', $data);
    }

    public function adduserrole() {
        if ($this->input->post('add_btn')) {
            $this->add_userrole_controller->add_userrole_action($this->input->post());
            $msg = "Data inserted";
            $data['msg'] = $msg;
        }
        if ($this->uri->segment(3)) {
            $to_edit_id = ($this->uri->segment(3));
            $data['id'] = $to_edit_id;
            $data['toedit_records'] = $this->role_model->getrolebyid($to_edit_id);
        }
        $data['alluserrole'] = $this->role_model->getAllrole();
        $this->load->view('settings/adduserrole', $data);
    }
    function manageUser($data=NULL){  
//        echo "Hi";
//        exit;
        $division_vid = 1;
        $department_vid = 2;
        $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        $data['alldepartment'] = $this->taxonomy->getTaxonomyByvid($department_vid);
        $data['alluserrole'] = $this->role_model->getAllrole();
        $data['all_users'] = $this->users_model->getAllUsers();
        $this->load->view('settings/manage_user', $data);
    }
    function saveUser(){
    
        if ($this->input->post('add_btn')) {     
            $edit_id = $this->input->post('user_id');
            $password = $this->input->post('password');
            $confirm_password = $this->input->post('confirm_password');
            $this->form_validation->set_rules('employee_id', 'Employee id', 'required');
            $this->form_validation->set_rules('fullname', 'Name', 'required');
            $this->form_validation->set_rules('user_type', 'User Type', 'required');
            if ($edit_id) {
                $this->form_validation->set_rules('user_name', 'Username', 'required|min_length[4]|max_length[12]|callback_edit_unique[users.username.' . $edit_id . ']');
                $this->form_validation->set_rules('email_address', 'Email', 'required|valid_email|callback_edit_unique[users.email.' . $edit_id . ']');
            } else {
               // $this->form_validation->set_rules('user_name', 'Username', '|trim|required|min_length[4]|max_length[12]|is_unique[users.username]');
               // $this->form_validation->set_rules('email_address', 'Email', '|trim|required|valid_email|is_unique[users.email]');
            }

            if (!$edit_id) {
         
                $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[confirm_password]');
                 $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|required');
            } else if (($edit_id) && ($password || $confirm_password)) {
                
                $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[confirm_password]');
                $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|required');
            }
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_userdata('add_status', 'Please fill up data correctly. '.validation_errors());
                $data['msg'] = $this->session->userdata('add_status');
            } else {
                $result=$this->add_user_controller->adduser_action($this->input->post()); 
                if($result){
                //$this->session->set_userdata('add_status', 'Data inserted successfully!');
                }else{
                    $this->session->set_userdata('add_status', '');
                }
                $data['msg'] = $this->session->userdata('add_status');
                
            }
        }else{
            print_r($_POST);
            exit;
        }
        redirect('user/manageUser');
    }
    function adduser() {
      
        if ($this->input->post('add_btn')) {
            $edit_id = $this->input->post('content_id');
            $password = $this->input->post('password');
            $confirm_password = $this->input->post('confirm_password');
            $this->form_validation->set_rules('employee_id', 'Employee id', 'required');
            $this->form_validation->set_rules('fullname', 'Name', 'required');
            $this->form_validation->set_rules('user_type', 'User Type', 'required');
            if ($edit_id) {
                $this->form_validation->set_rules('user_name', 'Username', 'required|min_length[4]|max_length[12]|callback_edit_unique[users.username.' . $edit_id . ']');
                $this->form_validation->set_rules('email_address', 'Email', 'required|valid_email|callback_edit_unique[users.email.' . $edit_id . ']');
            } else {
                $this->form_validation->set_rules('user_name', 'Username', '|trim|required|min_length[4]|max_length[12]|is_unique[users.username]');
                $this->form_validation->set_rules('email_address', 'Email', '|trim|required|valid_email|is_unique[users.email]');
            }

            if (!$edit_id) {
                $this->form_validation->set_rules('password', 'Password', '|trim|required|matches[confirm_password]');
                $this->form_validation->set_rules('confirm_password', 'Confirm password', '|trim|required');
            } else if (($edit_id) && ($password || $confirm_password)) {
                $this->form_validation->set_rules('password', 'Password', '|trim|required|matches[confirm_password]');
                $this->form_validation->set_rules('confirm_password', 'Confirm password', '|trim|required');
            }
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_userdata('add_status', 'Please fill up data correctly');
                $data['msg'] = $this->session->userdata('add_status');
            } else {
                $result=$this->add_user_controller->adduser_action($this->input->post()); 
                if($result){
                //$this->session->set_userdata('add_status', 'Data inserted successfully!');
                }else{
                    $this->session->set_userdata('add_status', '');
                }
                $data['msg'] = $this->session->userdata('add_status');
                
            }
        }
        $division_vid = 1;
        $department_vid = 2;
        $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        $data['alldepartment'] = $this->taxonomy->getTaxonomyByvid($department_vid);
        $data['alluserrole'] = $this->role_model->getAllrole();
        $data['allusers'] = $this->users_model->getAllusers();
        if ($this->uri->segment(3)) {
            $to_edit_id = ($this->uri->segment(3));
            $data['id'] = $to_edit_id;
            $user_data = $this->users_model->getuserbyid($to_edit_id);
            $data['toedit_records'] = $this->users_model->getuserbyid($to_edit_id);
            $data['department_selected'] = $this->taxonomy->getTaxonomychildbyparent($user_data['user_division']);
        }
        $this->load->view('settings/adduser', $data);
       
        $this->session->set_userdata('add_status', '');
        
    }

    function userregistration() {

        if ($this->input->post('add_btn')) {
            $edit_id = $this->input->post('content_id');
            $password = $this->input->post('password');
            $confirm_password = $this->input->post('confirm_password');
            $this->form_validation->set_rules('employee_id', 'Employee id', 'required');
            $this->form_validation->set_rules('fullname', 'Name', 'required');
            $this->form_validation->set_rules('user_type', 'User Type', 'required');
            if ($edit_id) {
                $this->form_validation->set_rules('user_name', 'Username', 'required|min_length[4]|max_length[12]|callback_edit_unique[users.username.' . $edit_id . ']');
                $this->form_validation->set_rules('email_address', 'Email', 'required|valid_email|callback_edit_unique[users.email.' . $edit_id . ']');
            } else {
                $this->form_validation->set_rules('user_name', 'Username', '|trim|required|min_length[4]|max_length[12]|is_unique[users.username]');
                $this->form_validation->set_rules('email_address', 'Email', '|trim|required|valid_email|is_unique[users.email]');
            }

            if (!$edit_id) {
                $this->form_validation->set_rules('password', 'Password', '|trim|required|matches[confirm_password]');
                $this->form_validation->set_rules('confirm_password', 'Confirm password', '|trim|required');
            } else if (($edit_id) && ($password || $confirm_password)) {
                $this->form_validation->set_rules('password', 'Password', '|trim|required|matches[confirm_password]');
                $this->form_validation->set_rules('confirm_password', 'Confirm password', '|trim|required');
            }
            if ($this->form_validation->run() == FALSE) {
                $msg = "Please fill up data correctly";
                $data['msg'] = $msg;
            } else {
                $this->add_user_controller->adduser_action($this->input->post());
                $msg = "Data inserted";
                $data['msg'] = $msg;
            }
        }
        $division_vid = 1;
        $department_vid = 2;
        $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        $data['alldepartment'] = $this->taxonomy->getTaxonomyByvid($department_vid);
        $data['alluserrole'] = $this->role_model->getAllrole();
        $data['allusers'] = $this->users_model->getAllusers();
        if ($this->uri->segment(3)) {
            $to_edit_id = ($this->uri->segment(3));
            $data['id'] = $to_edit_id;
            $user_data = $this->users_model->getuserbyid($to_edit_id);
            $data['toedit_records'] = $this->users_model->getuserbyid($to_edit_id);
            $data['department_selected'] = $this->taxonomy->getTaxonomychildbyparent($user_data['user_division']);
        }
        $this->load->view('settings/userregistration', $data);
    }

    function userpermission() {
        $user_type = $this->session->userdata('user_type');
        // $administer_user_permission = "administer_user_permission";
        // $data['administer_user_permission_access'] = $this->user_model->userpermission($administer_user_permission, $user_type);        
        // if ($user_type == 1 || $data['administer_user_permission_access'][0]['status'] == 1) {
        // }else{
        //     redirect('login');
        // }  
        
        if ($this->input->post()) {
            foreach ($this->input->post() as $key => $value) {
                if ($value) {
                    foreach ($value as $per_name => $per_value) {
                        $content_exist = $this->users_model->userpermission($per_name, $key);
                        if ($content_exist) {
                            $params = array(
                                'status' => $per_value,
                            );
                            $update_con = array('action' => $per_name, 'user_type' => $key);
                            $tbl_name = "permissions";
                            // ends of Search_field_content tables
                            $this->users_model->updanytbl($params, $update_con, $tbl_name);
                        } else {
                            $params_permission = array(
                                'id' => '',
                                'action' => $per_name,
                                'user_type' => $key,
                                'status' => $per_value,
                            );
                            $this->db->insert("permissions", $params_permission);
                        }
                    }
                }
            }
            $this->session->set_userdata('add_status', 'Data Updated');
        }
        $data['error'] = "";
        $data['msg'] = $this->session->userdata('add_status');
        $task_vid = 13;
        $data['alltask'] = $this->taxonomy->getTaxonomyByvid($task_vid);
        $this->load->view('settings/user-permission', $data);
        $this->session->set_userdata('add_status', '');
    }

    function userwisepermission($id) {
        if ($id) {
            $data = array(
                'id' => $id,
                'all_employee' => $this->search_field_emp_model->getallemployee(), // for all employee
                'all_division' => $this->taxonomy->getTaxonomyByvid(1), // for all division
                'all_task' => $this->taxonomy->getTaxonomyByvid(13),  // for all task
                'toedit_records' => $this->users_model->getuserbyid($id),
                'msg' => $this->session->userdata('message') // message if update else blank
            );
            $emp_ids_data = $this->users_model->getpermittedemployee($id);
            $content_ids = $emp_ids_data['emp_content_ids'];
            $data['all_permitted_employee'] = $this->search_field_emp_model->getallsearch_table_contentByids($content_ids);
        }
        $this->load->view('settings/user-wise-permission', $data);
        $this->session->set_userdata('message', '');
    }

    function updateUserWisePermission() {
        
        if ($this->input->post()) {
            $id = $this->input->post('user_id');
            $emp_ids_array = $this->input->post('emp_name_selcted');
            $ids_string = implode(', ', $emp_ids_array);
            foreach ($this->input->post("task_value") as $single_user => $permissions) {
            $user_id = $single_user;
                $this->users_model->deleteUserwisePermissionByUserId($user_id);
                $params_empid = array(
                    'id' => '',
                    'user_id' => $user_id,
                    'emp_content_ids' => $ids_string,
                    'created' => getCurrentDateTime(),
                    'created_by' => $this->session->userdata('user_id'),
                );
                $result1 = $this->db->insert("permitted_emp", $params_empid);
                foreach ($permissions as $key => $value) {
                    if ($value) {
                        $params_permission = array(
                            'id' => '',
                            'action' => $key,
                            'user_id' => $user_id,
                            'status' => $value,
                        );
                        $result2 = $this->db->insert("userwiseaccess", $params_permission);
                    }
                }
            }
            if ($result1 && $result2) {
                $this->session->set_userdata('add_status', '<font color=green > User permission updated successfully ! </font>');
            } else {
                $this->session->set_userdata('add_status', '<font color=red > SORRY!Something Wrong !</font> ');
            }
        }
        redirect("user/userwisepermission/$id");
    }

    function viewuserwisepermission() {
        if ($this->uri->segment(3)) {
            $to_edit_id = ($this->uri->segment(3));
            $data['id'] = $to_edit_id;
            $data['toedit_records'] = $this->users_model->getuserbyid($to_edit_id);
            $emp_ids_data = $this->users_model->getpermittedemployee($to_edit_id);
            $content_ids = $emp_ids_data['emp_content_ids'];
            $data['allemployee'] = $this->search_field_emp_model->getallsearch_table_contentByids($content_ids);
        } else {
            redirect("user/adduser");
        }
        $task_vid = 13;
        $data['alltask'] = $this->taxonomy->getTaxonomyByvid($task_vid);
        $this->load->view('settings/view-user-wise-permission', $data);
    }

    public function getallpermissions() {
        header('Content-type: application/json');
        $data['value'] = $this->users_model->allpermission();
        echo json_encode($data['value']);
    }

    public function getallglobalsettings() {
        header('Content-type: application/json');
        $data['value'] = $this->users_model->allglobalsettings();
        echo json_encode($data['value']);
    }

    public function viewprofile() {
        $this->check_permission_controller->check_permission_action("edit_view_login_profile");
        $country_vid = 4;
        $company_vid = 2;
        $data['error'] = "";
        $data['msg'] = $this->session->userdata('add_status');
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $data['userinfo'] = $this->users_model->getuserdetails($user_id);

        date_default_timezone_set('Asia/Dhaka');
        $servertime = time();
        $now = date("Y.m.d", $servertime);
        $user_edit_id = $this->input->post('user_id');
        if ($user_edit_id) {
            $name = $this->input->post('fullname');
            $user_name = $this->input->post('user_name');
            $email_address = $this->input->post('email_address');
            $password = trim($this->input->post('password'));

            $confirm_password = $this->input->post('confirm_password');
            $phone = $this->input->post('phone');

            $this->form_validation->set_rules('fullname', 'Name', 'required');
            $this->form_validation->set_rules('user_name', 'Username', 'required|min_length[4]|max_length[12]|callback_edit_unique[users.username.' . $user_edit_id . ']');
            $this->form_validation->set_rules('email_address', 'Email', 'required|valid_email|callback_edit_unique[users.email.' . $user_edit_id . ']');
            $this->form_validation->set_rules('password', 'Password', 'matches[confirm_password]');

            if ($this->form_validation->run() == FALSE) {
                
            } else {
                $params = array(
                    'name' => $name,
                    'username' => $user_name,
                    'email' => $email_address,
                    'password' => $password,
                    'phone' => $phone
                );

                $params = array_filter($params, 'strlen');
                $this->users_model->updateuser($params, $user_id);
                $this->session->set_userdata('add_status', 'Profile Updated');
                redirect("user/viewprofile");
            }
        }
        $view_profile = "view_profile";
        $this->load->view('settings/profile/viewprofile', $data);
        $this->session->set_userdata('add_status', '');
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

    public function activeInactiveUser() {
        $ids = $this->input->post('id');
        $task_type = $this->input->post('task_type');
        if ($task_type == "1") {
            foreach ($ids as $single_id) {
                $params = array(
                    'user_status' => 1,
                );
                $params = array_filter($params, 'strlen');
                $this->users_model->updateuser($params, $single_id);
            }
        } else if ($task_type == "0") {
            foreach ($ids as $single_id) {
                $params = array(
                    'user_status' => 0,
                );
                $params = array_filter($params, 'strlen');
                $this->users_model->updateuser($params, $single_id);
            }
        }
        $this->session->set_userdata('add_status', 'User status updated');
        redirect('user/manageUser');
    }

}

?>