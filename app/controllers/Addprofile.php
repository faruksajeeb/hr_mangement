<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Addprofile extends CI_Controller{

    function __construct()
    {
       
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

    public function index()
    {
       
        //$this->load->view('recruiting/addprofile');
        redirect("addprofile/addemployee");
    }

    public function addEmployee()
    {
        $this->check_permission_controller->check_permission_action("add_edit_profile");
        $companyVid = 1;
        $division_vid = 2;
        $jobtitle_vid = 3;
        $typeofemployee_vid = 4;
        $qualification_vid = 5;
        $religion_vid = 6;
        $marital_status_vid = 7;
        $bloodgroup_vid = 8;
        $allleavetype_vid = 16;
        $allpaytype_vid = 9;
        $bankname_vid = 10;
        $city_vid = 11;
        $distict_vid = 12;
        $relative_vid = 14;
        $grade_vid = 15;
        $workingshift_vid = 21;
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $user_data = $this->users_model->getuserbyid($user_id);
        $userCompanyId = $user_data['user_division'];
        $data['user_info'] = $this->users_model->getuserbyid($user_id);
        $data['user_type_id'] = $this->session->userdata('user_type');
        if ($user_type != 1) {
            $data['companies'] = $this->taxonomy->getTaxonomyBytid($userCompanyId);
            $data['division_selected'] = $this->taxonomy->getTaxonomychildbyparent($userCompanyId);
            $emp_last_code = $this->employee_id_model->getLastempcodebydivision($userCompanyId);
            $data['tobeaddempcode'] = $emp_last_code + 1;
        } else {
            $data['companies'] = $this->taxonomy->getActiveTaxonomyByVId($companyVid);
        }

        $data['divisions'] = $this->taxonomy->getActiveTaxonomyByVId($division_vid);
        $data['departments'] = $this->taxonomy->getActiveTaxonomyByVId(22);
        $data['alljobtitle'] = $this->taxonomy->getActiveTaxonomyByVId($jobtitle_vid);
        $data['allworkingshift'] = $this->taxonomy->getActiveTaxonomyByVId($workingshift_vid);
        $data['alltypeofemployee'] = $this->taxonomy->getActiveTaxonomyByVId($typeofemployee_vid);
        $data['allqualification'] = $this->taxonomy->getActiveTaxonomyByVId($qualification_vid);
        $data['allreligion'] = $this->taxonomy->getActiveTaxonomyByVId($religion_vid);
        $data['allmarital_status'] = $this->taxonomy->getActiveTaxonomyByVId($marital_status_vid);
        $data['allbloodgroup'] = $this->taxonomy->getActiveTaxonomyByVId($bloodgroup_vid);
        $data['allpaytype'] = $this->taxonomy->getActiveTaxonomyByVId($allpaytype_vid);
        $data['allbankname'] = $this->taxonomy->getActiveTaxonomyByVId($bankname_vid);
        $data['allcity'] = $this->taxonomy->getActiveTaxonomyByVId($city_vid);
        $data['alldistict'] = $this->taxonomy->getActiveTaxonomyByVId($distict_vid);
        $data['allrelative'] = $this->taxonomy->getActiveTaxonomyByVId($relative_vid);
        $data['country'] = $this->hs_hr_country->getCountry();
        #$data['allgrade'] = $this->taxonomy->getActiveTaxonomyByVId($grade_vid);
        $data['grades'] = $this->db->query("SELECT * FROM tbl_salary_grades WHERE status=1")->result();
        $data['allleavetype'] = $this->taxonomy->getActiveTaxonomyByVId($allleavetype_vid);        
        if ($this->uri->segment(3)) {
            $content_id = ($this->uri->segment(3));
            $data['toedit_id'] = $content_id;
            $data['emp_details_records'] = $this->emp_details_model->getallcontentByid($content_id);
            $data['search_field_emp_data'] = $this->search_field_emp_model->getallsearch_table_contentByid($content_id);
            $data['provision'] = $this->emp_provision_model->getcontentByid($content_id);
            $data['working_time'] = $this->emp_working_time_model->getcontentByid($content_id);
            // $data['salary_amount'] = $this->emp_salary_model->getsalary($content_id);
            // $data['salary_allamount'] = $this->emp_salary_model->getallsalary($content_id);
            // $data['salary_allamount_ascorder'] = $this->emp_salary_model->getallsalarybyasc($content_id);
            // $data['salary_amount_previous'] = $this->emp_salary_model->getprevioussalary($content_id);
            $company_tid = $data['search_field_emp_data']['emp_division'];
            if ($user_type != 1 && $company_tid != $userCompanyId) {
                redirect('addprofile/addEmployee');
            }
            $data['documents'] = $this->emp_details_model->getsinglebiodocuments($content_id);
            $data['division_selected'] = $this->taxonomy->getTaxonomychildbyparent($company_tid);
            $data['salary_deduction'] = $this->emp_salary_deduction_model->getdeduction($content_id);
            $data['payment_type'] = $this->emp_payment_method_model->getpayment_method($content_id);
            $data['emp_holiday'] = $this->emp_holiday_model->getemp_holiday($content_id);
            $data['emp_total_leave'] = $this->emp_leave_model->getemp_yearlyleavetotal($content_id);
        }
        // $this->session->set_flashdata('redirect', validation_errors());
        //     redirect('addprofile/addemployee');
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->session->set_userdata('session_redirect', $this->uri->uri_string());
        $this->load->view('recruiting/add_employee', $data);
    }

    function employeeProfile()
    {
        if ($this->uri->segment(2)) {
            $content_id = ($this->uri->segment(2));
            $data['toedit_id'] = $content_id;
            $allleavetype_vid = 16;
            $data['employeeInfo'] = $this->search_field_emp_model->getEmployeeInfoById($content_id);
            $data['emp_details_records'] = $this->emp_details_model->getallcontentByid($content_id);
            $data['working_time'] = $this->emp_working_time_model->getcontentByid($content_id);
            $data['salary_amount'] = $this->emp_salary_model->getsalary($content_id);
            $data['documents'] = $this->emp_details_model->getsinglebiodocuments($content_id);
            $data['salary_deduction'] = $this->emp_salary_deduction_model->getdeduction($content_id);
            $data['payment_type'] = $this->emp_payment_method_model->getpayment_method($content_id);
            $data['emp_holiday'] = $this->emp_holiday_model->getemp_holiday($content_id);
            $data['emp_total_leave'] = $this->emp_leave_model->getemp_yearlyleavetotal($content_id);
            $data['grades'] = $this->db->query("SELECT * FROM tbl_salary_grades WHERE status=1")->result();
            $data['allleavetype'] = $this->taxonomy->getActiveTaxonomyByVId($allleavetype_vid);        
            
        }
        //        echo "<pre/>";
        //        print_r($data); 
        //        exit;

        $this->load->view('recruiting/employee_profile', $data);
    }

    function do_upload()
    {
       
        $this->form_validation->set_rules('emp_name', 'Name', 'required');
        $this->form_validation->set_rules('emp_fathername', 'Father\'s Name', 'required');
        $this->form_validation->set_rules('emp_company', 'Company', 'required');
        $this->form_validation->set_rules('emp_division', 'Division', 'required');
        $this->form_validation->set_rules('emp_department', 'Department', 'required');
        $this->form_validation->set_rules('emp_gender', 'Gender', 'required');
        $this->form_validation->set_rules('emp_dob', 'Date of Birth', 'required');
        $this->form_validation->set_rules('emp_starting_date', 'Joining Date', 'required');
        $this->form_validation->set_rules('emp_type', 'Type Of Employee', 'required');
        $this->form_validation->set_rules('emp_position', 'Position', 'required');
        $this->form_validation->set_rules('emp_grade', 'Grade', 'required');
        $edit_id = $this->input->post('content_id');
        if ($edit_id) {
            //$this->form_validation->set_rules('content_id', 'Content ID', 'callback_edit_unique[search_field_emp.content_id.' . $edit_id . ']');
            //$this->form_validation->set_rules('emp_id', 'Employee Code', 'callback_edit_unique[search_field_emp.emp_id.' . $edit_id . ']');
        } else {
            $this->form_validation->set_rules('content_id', 'Content ID', 'is_unique[employee_id.id]');
            $this->form_validation->set_rules('emp_id', 'Employee Code', 'required|is_unique[employee_id.emp_id]');
            $this->form_validation->set_rules('content_id', 'Content ID', 'is_unique[search_field_emp.content_id]');
            $this->form_validation->set_rules('emp_id', 'Employee Code', 'required|is_unique[search_field_emp.emp_id]');
        }
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('addprofile/addemployee');
            //redirect($this->session->flashdata('redirect'));
        } else {
           
            $content_edit_id = $this->input->post('content_id');
            if (!$content_edit_id) {
            
                $content_id = $this->employee_id_model->getLastcontentId();
                $toadd_id = $content_id + 1;
                $emp_id = $this->input->post('emp_id');
                $params_employee_id = array(
                    'id' => '',
                    'emp_id' => $emp_id,
                    'author' => $this->session->userdata('user_id'),
                    'created' => getCurrentDateTime(),
                    'updated' => getCurrentDateTime(),
                    'status' => 1,
                );
                $content_ids = $this->db->insert("employee_id", $params_employee_id);
                $insert_id = $this->db->insert_id();
                $file_counter = $_FILES['file'];
                foreach ($_FILES['file'] as $key => $val) {
                    $i = 1;
                    foreach ($val as $v) {
                        $field_name = "file_" . $i;
                        $_FILES[$field_name][$key] = $v;
                        $i++;
                    }
                }
                // Unset the useless one ;)
                unset($_FILES['file']);
                foreach ($_FILES['documents'] as $key => $val) {
                    $i = 1;
                    foreach ($val as $v) {
                        $field_name = "documents_" . $i;
                        $_FILES[$field_name][$key] = $v;
                        $i++;
                    }
                }
                // Unset the useless one ;)
                unset($_FILES['documents']);
                $content_repeat = 0;
                $content_repeat2 = 0;
                foreach ($_FILES as $field_name => $file) {

                    $new_name = time() . "_" . $file['name'];
                    $new_name = str_replace(' ', '_', $new_name);
                    $lastDot = strrpos($new_name, ".");
                    $new_name = str_replace(".", "", substr($new_name, 0, $lastDot)) . substr($new_name, $lastDot);
                    if ($field_name == "file_1") {
                        $upload_conf = array(
                            'upload_path' => './resources/uploads/',
                            'allowed_types' => 'gif|jpg|png',
                            'max_size' => '3000',
                            'remove_spaces' => TRUE,
                            'file_name' => $new_name,
                        );
                        if ($file['name']) {
                            $params_content = array(
                                'id' => '',
                                'content_id' => $insert_id,
                                'emp_id' => $emp_id,
                                'field_repeat' => $content_repeat,
                                'field_name' => 'resources/uploads',
                                'field_value' => $new_name,
                            );
                            $this->db->insert("emp_details", $params_content);
                            $content_repeat++;
                        }
                    } else {
                        if ($file['name']) {
                            $upload_conf = array(
                                'upload_path' => './resources/uploads/documents/',
                                'allowed_types' => 'gif|jpg|png|pdf|doc|docs|txt',
                                'max_size' => '30000',
                                'remove_spaces' => TRUE,
                                'file_name' => $new_name,
                            );
                            $params_content2 = array(
                                'id' => '',
                                'content_id' => $insert_id,
                                'emp_id' => $emp_id,
                                'field_repeat' => $content_repeat2,
                                'field_name' => 'resources/uploads/documents',
                                'field_value' => $new_name,
                            );
                            $this->db->insert("emp_details", $params_content2);
                            $content_repeat2++;
                        }
                    }
                    if ($file['name']) {
                        $this->upload->initialize($upload_conf);
                        $this->upload->do_upload($field_name);
                    }
                }
                //end of documents uploads  
                foreach ($this->input->post() as $key => $val) {
                    if ($key == 'emp_provision_starting_date' && $this->input->post('emp_type') == '155') {
                        $this->add_provision_controller->add_provision_action($this->input->post(), $toadd_id);
                    } else if ($key == 'attendance_required') {
                        $this->add_workingtime_controller->add_workingtime_action($this->input->post(), $toadd_id);
                        $this->add_empshifthistory_controller->add_empshifthistory_action($this->input->post(), $toadd_id);
                    } else if ($key == 'emp_basic_salary') {
                        $this->add_salary_controller->add_salary_action($this->input->post(), $toadd_id);
                    } else if ($key == 'emp_total_deduction') {
                        $this->add_salarydeduction_controller->add_deduction_action($this->input->post(), $toadd_id);
                    } else if ($key == 'emp_pay_type') {
                        $this->add_paymentmethod_controller->add_paymentmethod_action($this->input->post(), $toadd_id);
                    } else if ($key == 'emp_weekly_holiday') {
                        $this->add_holiday_controller->add_holiday_action($this->input->post(), $toadd_id);
                        $this->add_weeklyholidayhistory_controller->add_weeklyholidayhistory_action($this->input->post(), $toadd_id);
                    } else if ($key == 'annual_leave_total') {
                        $this->add_leave_controller->add_yearlyleave_action($this->input->post(), $toadd_id);
                        $this->add_leave_controller->add_yearlyleavehistory_action($this->input->post(), $toadd_id);
                    } else if (trim($val) && $key != 'emp_name' && $key != 'emp_id' && $key != 'content_id' && $key != 'emp_division' && $key != 'emp_department' && $key != 'emp_position' && $key != 'emp_gender' && $key != 'emp_dob' && $key != 'emp_marital_status' && $key != 'emp_religion' && $key != 'emp_age' && $key != 'emp_starting_date' && $key != 'emp_type' && $key != 'emp_present_salary' && $key != 'emp_visa_selling' && $key != 'emp_pay_type' && $key != 'emp_current_distict' && $key != 'emp_mobile_no' && $key != 'emp_nid' && $key != 'emp_provision_ending_date' && $key != 'emp_working_time_from' && $key != 'emp_working_end_time' && $key != 'attendance_required' && $key != 'emp_latecount_time' && $key != 'logout_required' && $key != 'emp_salary_update' && $key != 'emp_salary_increment' && $key != 'emp_basic_salary' && $key != 'emp_house_rent' && $key != 'emp_medical_allowance' && $key != 'emp_conveyance' && $key != 'emp_conveyance' && $key != 'emp_telephone_allowance' && $key != 'emp_special_allowance' && $key != 'emp_provident_fund_allowance' && $key != 'emp_transport_allowance' && $key != 'emp_other_allowance' && $key != 'emp_performance_bonus' && $key != 'emp_festival_bonus' && $key != 'emp_total_benifit' && $key != 'emp_gross_salary' && $key != 'emp_yearly_paid' && $key != 'emp_provident_fund_deduction' && $key != 'emp_other_deduction' && $key != 'emp_total_deduction' && $key != 'emp_bank' && $key != 'emp_bank_branch' && $key != 'emp_bank_account' && $key != 'emp_pay_type' && $key != 'emp_grade' && $key != 'emp_salary_increment_amount' && $key != 'emp_increment_percentage' && $key != 'emp_increment_date' && $key != 'emp_weekly_holiday' && $key != 'annual_leave' && $key != 'current_img' && $key != 'leave_total_system' && $key != 'leave_category_system' && $key != 'annual_leave_total' && $key != 'emp_earlycount_time' && $key != 'half_day_absent' && $key != 'overtime_count' && $key != 'curr_doc_' && $key != 'absent_count_time' && $key != 'emp_job_change_date' && $key != 'emp_shift') {

                        $params_contents = array(
                            'id' => '',
                            'content_id' => $insert_id,
                            'emp_id' => $emp_id,
                            'field_repeat' => 0,
                            'field_name' => $key,
                            'field_value' => trim($val),
                        );
                        $this->db->insert("emp_details", $params_contents);
                    }
                }
                // insert job history
                $this->add_empjobhistory_controller->add_empjobhistory_action($this->input->post(), $insert_id);
                // insert employee search table
                $params_content_id = array(
                    'id' => '',
                    'content_id' => $insert_id,
                    'emp_id' => $emp_id,
                    'emp_name' => $this->input->post('emp_name'),
                    'emp_division' => $this->input->post('emp_company'),
                    'emp_department' => $this->input->post('emp_division'),
                    'department_id' => $this->input->post('emp_department'),
                    'emp_post_id' => $this->input->post('emp_position'),
                    'grade' => $this->input->post('emp_grade'),
                    'gender' => $this->input->post('emp_gender'),
                    'dob' => $this->input->post('emp_dob'),
                    'marital_status' => $this->input->post('emp_marital_status'),
                    'religion' => $this->input->post('emp_religion'),
                    'age' => $this->input->post('emp_age'),
                    'joining_date' => $this->input->post('emp_starting_date'),
                    'type_of_employee' => $this->input->post('emp_type'),
                    'visa_selling' => $this->input->post('emp_visa_selling'),
                    'pay_type' => $this->input->post('emp_pay_type'),
                    'distict' => $this->input->post('emp_current_distict'),
                    'mobile_no' => $this->input->post('emp_mobile_no'),
                    'national_id' => $this->input->post('emp_nid'),
                    'tin' => $this->input->post('emp_tin'),
                );
                $content_ids = $this->db->insert("search_field_emp", $params_content_id);
                $inserted_id_search_field_emp = $this->db->insert_id();
                // insert candidates status    
                $this->session->set_flashdata('success', "Data Added Successfully!");
                $content_id_redirect = $this->employee_id_model->getLastcontentId();
                redirect('addprofile/addemployee/' . $content_id_redirect);
                // redirect($this->session->flashdata('redirect'));         
            } else if ($content_edit_id) {
               
                // content edit start ------------------------------------------------------------------------edit -----------------------
                // $status=$this->input->post('field_publish_status');
                $user_id = $this->session->userdata('user_id');
                $user_type = $this->session->userdata('user_type');
                $user_data = $this->users_model->getuserbyid($user_id);
                $user_division_id = $user_data['user_division'];
                $search_field_emp_data = $this->search_field_emp_model->getallsearch_table_contentByid($content_edit_id);
                $division_tid = $search_field_emp_data['emp_division'];
                if ($user_type != 1 && $division_tid != $user_division_id) {
                    redirect('addprofile/addemployee');
                }
                $params_update_date = array(
                    'emp_id' => $this->input->post('emp_id'),
                    'updated' => getCurrentDateTime(),
                    'status' => 1,
                );

                $this->employee_id_model->upddataContent($params_update_date, $content_edit_id);
                
                // update image
                $current_removed_docs = $this->input->post('curr_doc_');
                foreach ($current_removed_docs as $single_remo_docskey => $single_remo_docs) {
                    if ($single_remo_docs) {
                        $this->emp_details_model->deletesinglebiodocuments($content_edit_id, $single_remo_docskey);
                        unlink('./resources/uploads/documents/' . $single_remo_docs);
                    }
                }
                $file_counter = $_FILES['file'];
                foreach ($_FILES['file'] as $key => $val) {
                    $i = 1;
                    foreach ($val as $v) {
                        $field_name = "file_" . $i;
                        $_FILES[$field_name][$key] = $v;
                        $i++;
                    }
                }
                // Unset the useless one ;)
                unset($_FILES['file']);
                foreach ($_FILES['documents'] as $key => $val) {
                    $i = 1;
                    foreach ($val as $v) {
                        $field_name = "documents_" . $i;
                        $_FILES[$field_name][$key] = $v;
                        $i++;
                    }
                }
                
                // Unset the useless one ;)
                unset($_FILES['documents']);
                $content_repeat = 0;
                $last_repeat_id = $this->emp_details_model->getbiodocumentsrepeatid($content_edit_id);
                $content_repeat2 = $last_repeat_id['field_repeat'] + 1;
                foreach ($_FILES as $field_name => $file) {

                    $new_name = time() . "_" . $file['name'];
                    $new_name = str_replace(' ', '_', $new_name);
                    $lastDot = strrpos($new_name, ".");
                    $new_name = str_replace(".", "", substr($new_name, 0, $lastDot)) . substr($new_name, $lastDot);
                    if ($field_name == "file_1") {
                        $upload_conf = array(
                            'upload_path' => './resources/uploads/',
                            'allowed_types' => 'gif|jpg|png',
                            'max_size' => '3000',
                            'remove_spaces' => TRUE,
                            'file_name' => $new_name,
                        );
                        $params_image_content = array(
                            'emp_id' => $this->input->post('emp_id'),
                            'field_value' => $new_name,
                        );
                        $params_new_img_content = array(
                            'id' => '',
                            'content_id' => $content_edit_id,
                            'emp_id' => $this->input->post('emp_id'),
                            'field_repeat' => $content_repeat,
                            'field_name' => 'resources/uploads',
                            'field_value' => $new_name,
                        );
                        if ($file['name']) {
                            $file_name_value = "resources/uploads";
                            $current_img = $this->input->post('current_img');
                            $image_exist = $this->emp_details_model->getcontentByidandname($content_edit_id, $file_name_value);
                            if ($image_exist) {
                                $update_condition = array('content_id' => $content_edit_id, 'field_name' => $file_name_value);
                                $this->emp_details_model->updContenttbl($params_image_content, $update_condition);
                                unlink('./resources/uploads/' . $current_img);
                            } else {
                                $this->db->insert("emp_details", $params_new_img_content);
                            }
                        }
                        $content_repeat++;
                    } else {
                        if ($file['name']) {
                            $upload_conf = array(
                                'upload_path' => './resources/uploads/documents/',
                                'allowed_types' => 'gif|jpg|png|pdf|doc|docs|txt',
                                'max_size' => '30000',
                                'remove_spaces' => TRUE,
                                'file_name' => $new_name,
                            );
                            $params_content2 = array(
                                'id' => '',
                                'content_id' => $content_edit_id,
                                'emp_id' => $this->input->post('emp_id'),
                                'field_repeat' => $content_repeat2,
                                'field_name' => 'resources/uploads/documents',
                                'field_value' => $new_name,
                            );
                            $this->db->insert("emp_details", $params_content2);
                            $content_repeat2++;
                        }
                    }
                    if ($file['name']) {
                        $this->upload->initialize($upload_conf);
                        $this->upload->do_upload($field_name);
                    }
                }

                // end of update image and start of update or insert image
                foreach ($this->input->post() as $key => $val) {

                    $params_contents = array(
                        'id' => '',
                        'content_id' => $content_edit_id,
                        'emp_id' => $this->input->post('emp_id'),
                        'field_repeat' => 0,
                        'field_name' => $key,
                        'field_value' => trim($val),
                    );
                    
                    $params_toupdate_contents = array(
                        'emp_id' => $this->input->post('emp_id'),
                        'field_value' => trim($val),
                    );
                    $content_exist = $this->emp_details_model->getcontentByidandname($content_edit_id, $key);
                    
                    if ($key == 'emp_provision_starting_date' && $this->input->post('emp_type') == '155') {
                         $this->add_provision_controller->add_provision_action($this->input->post(), $content_edit_id);
                    } elseif ($key == 'attendance_required') {
                        $this->add_workingtime_controller->add_workingtime_action($this->input->post(), $content_edit_id);
                        $this->add_empshifthistory_controller->add_empshifthistory_action($this->input->post(), $content_edit_id);
                    } elseif ($key == 'emp_gross_salary') {
                        $this->add_salary_controller->add_salary_action($this->input->post(), $content_edit_id);
                    } elseif ($key == 'emp_total_deduction') {
                        $this->add_salarydeduction_controller->add_deduction_action($this->input->post(), $content_edit_id);
                    } elseif ($key == 'emp_pay_type') {
                        $this->add_paymentmethod_controller->add_paymentmethod_action($this->input->post(), $content_edit_id);
                      
                    } elseif ($key == 'emp_weekly_holiday') {
                        $this->add_holiday_controller->add_holiday_action($this->input->post(), $content_edit_id);
                        $this->add_weeklyholidayhistory_controller->add_weeklyholidayhistory_action($this->input->post(), $content_edit_id);
                    } elseif ($key == 'annual_leave_total') {
                        $this->add_leave_controller->add_yearlyleave_action($this->input->post(), $content_edit_id);
                        $this->add_leave_controller->add_yearlyleavehistory_action($this->input->post(), $content_edit_id);
                    } elseif ($content_exist) {

                        $update_conditions = array('content_id' => $content_edit_id, 'field_name' => $key);
                        $empID = $this->input->post('emp_id');
                        $newVal = trim($val);
                        // $this->db->query("UPDATE emp_details SET emp_id='$empID', field_value= '$newVal' 
						// WHERE content_id='$content_edit_id' AND field_name='$key' ");
                        $this->emp_details_model->updContenttbl($params_toupdate_contents, $update_conditions);




                    } elseif (
                        trim($val) &&
                        $key != 'emp_name' &&
                        $key != 'emp_id' &&
                        $key != 'content_id' &&
                        $key != 'emp_division' &&
                        $key != 'emp_department' &&
                        $key != 'emp_position' &&
                        $key != 'emp_gender' &&
                        $key != 'emp_dob' &&
                        $key != 'emp_marital_status' &&
                        $key != 'emp_religion' &&
                        $key != 'emp_age' &&
                        $key != 'emp_starting_date' &&
                        $key != 'emp_type' &&
                        $key != 'emp_present_salary' &&
                        $key != 'emp_visa_selling' &&
                        $key != 'emp_pay_type' &&
                        $key != 'emp_current_distict' &&
                        $key != 'emp_mobile_no' &&
                        $key != 'emp_nid' &&
                        $key != 'emp_provision_ending_date' &&
                        $key != 'emp_working_time_from' &&
                        $key != 'emp_working_end_time' &&
                        $key != 'attendance_required' &&
                        $key != 'emp_latecount_time' &&
                        $key != 'logout_required' &&
                        $key != 'emp_salary_update' &&
                        $key != 'emp_salary_increment' &&
                        $key != 'emp_basic_salary' &&
                        $key != 'emp_house_rent' &&
                        $key != 'emp_medical_allowance' &&
                        $key != 'emp_conveyance' &&
                        $key != 'emp_conveyance' &&
                        $key != 'emp_telephone_allowance' &&
                        $key != 'emp_special_allowance' &&
                        $key != 'emp_provident_fund_allowance' &&
                        $key != 'emp_transport_allowance' &&
                        $key != 'emp_other_allowance' &&
                        $key != 'emp_performance_bonus' &&
                        $key != 'emp_festival_bonus' &&
                        $key != 'emp_total_benifit' &&
                        $key != 'emp_gross_salary' &&
                        $key != 'emp_yearly_paid' &&
                        $key != 'emp_provident_fund_deduction' &&
                        $key != 'emp_other_deduction' &&
                        $key != 'emp_total_deduction' &&
                        $key != 'emp_bank' &&
                        $key != 'emp_bank_branch' &&
                        $key != 'emp_bank_account' &&
                        $key != 'emp_pay_type' &&
                        $key != 'emp_grade' &&
                        $key != 'emp_salary_increment_amount' &&
                        $key != 'emp_increment_percentage' &&
                        $key != 'emp_increment_date' &&
                        $key != 'emp_weekly_holiday' &&
                        $key != 'annual_leave' &&
                        $key != 'current_img' &&
                        $key != 'leave_total_system' &&
                        $key != 'leave_category_system' &&
                        $key != 'annual_leave_total' &&
                        $key != 'emp_earlycount_time' &&
                        $key != 'half_day_absent' &&
                        $key != 'overtime_count' &&
                        $key != 'curr_doc_' &&
                        $key != 'absent_count_time' &&
                        $key != 'emp_job_change_date' &&
                        $key != 'emp_shift'
                    ) {

                        $this->db->insert("emp_details", $params_contents);
                    }
                   
                    
                }

                // insert job history
                $jobHistoryRes = $this->add_empjobhistory_controller->add_empjobhistory_action($this->input->post(), $content_edit_id);

                // update  Search_field_content tables data
                $params_search_fields = array(
                    'emp_id' => $this->input->post('emp_id'),
                    'emp_name' => $this->input->post('emp_name'),
                    'emp_division' => $this->input->post('emp_company'),
                    'emp_department' => $this->input->post('emp_division'),
                    'department_id' => $this->input->post('emp_department'),
                    'emp_post_id' => $this->input->post('emp_position'),
                    'grade' => $this->input->post('emp_grade'),
                    'gender' => $this->input->post('emp_gender'),
                    'dob' => $this->input->post('emp_dob'),
                    'marital_status' => $this->input->post('emp_marital_status'),
                    'religion' => $this->input->post('emp_religion'),
                    'age' => $this->input->post('emp_age'),
                    'joining_date' => $this->input->post('emp_starting_date'),
                    'type_of_employee' => $this->input->post('emp_type'),
                    'visa_selling' => $this->input->post('emp_visa_selling'),
                    'pay_type' => $this->input->post('emp_pay_type'),
                    'distict' => $this->input->post('emp_current_distict'),
                    'mobile_no' => $this->input->post('emp_mobile_no'),
                    'national_id' => $this->input->post('emp_nid'),
                    'tin' => $this->input->post('emp_tin'),
                    'updated_at' => getCurrentDateTime(),
                    'updated_by' => $this->session->userdata('user_id'),
                );
                $params = array_filter($params_search_fields, 'strlen');


                $update_con2 = array('content_id' => $content_edit_id);
                // ends of Search_field_content tables
                if ($jobHistoryRes == 'Invalid_effective_date') {
                    $this->session->set_flashdata('success', "<font color=red>SORRY! Invalid effective date! Please check employee job history. </font>");
                } else if ($jobHistoryRes == 'Invalid_joining_date') {
                    $this->session->set_flashdata('success', '<font color=red>SORRY! Invalid joining date! Please check employee job history. </font> ');
                } else {
                    #dd($params);
                    if ($params) {
                        $sql = "UPDATE `search_field_emp` 
						SET `emp_id` = '" . $params['emp_id'] . "', 
						`emp_name` = '" . $params['emp_name'] . "', 
						`emp_division` = '" . $params['emp_division'] . "', 
						`emp_department` = '" . $params['emp_department'] . "', 
						`department_id` = '" . $params['department_id'] . "', 
						`emp_post_id` = '" . $params['emp_post_id'] . "', 
						`grade` = '" . $params['grade'] . "', 
						`gender` = '" . $params['gender'] . "', 
						`dob` = '" . $params['dob'] . "', 
						`marital_status` = '" . $params['marital_status'] . "', 
						`religion` = '" . $params['religion'] . "', 
						`age` = '" . $params['age'] . "', 
						`joining_date` = '" . $params['joining_date'] . "', 
						`type_of_employee` = '" . $params['type_of_employee'] . "', 
						`distict` = '" . $params['distict'] . "', 
						`mobile_no` = '" . $params['mobile_no'] . "', 
						`national_id` = '" . $params['national_id'] . "', 
						`tin` = '" . $params['tin'] . "', 
						`updated_at` = '" . getCurrentDateTime() . "', 
						`updated_by` = '" . $this->session->userdata('user_id') . "' 
						WHERE content_id='$content_edit_id' ";
                        #$this->db->query($sql);
                        $this->db->update('search_field_emp', $params, $update_con2);
                        
                        #dd($this->db->last_query());
                    }
                    $this->session->set_flashdata('success', "Data Updated Succesfully!");
                }

                //redirect('addprofile/addemployee');
                redirect('addprofile/addemployee/' . $content_edit_id);
                //redirect($this->session->flashdata('redirect'));
            }
           
        }
    }

    public function edit_unique($value, $params)
    {
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

    function deleteemployee()
    {
        if ($this->uri->segment(3)) {
            $content_id = ($this->uri->segment(3));

            $file_name_value = "resources/uploads";
            $image_exist = $this->emp_details_model->getcontentByidandname($content_id, $file_name_value);
            if ($image_exist) {
                $current_img = $image_exist[0]['field_value'];
                unlink('./resources/uploads/' . $current_img);
            }
            $document_name_value = "resources/uploads/documents";
            $documents_exist = $this->emp_details_model->getcontentByidandname($content_id, $document_name_value);
            if ($documents_exist) {
                foreach ($documents_exist as $single_document) {
                    $current_document = $single_document['field_value'];
                    unlink('./resources/uploads/documents/' . $current_document);
                }
            }
            $this->emp_details_model->deleteContentByid($content_id);
            $this->emp_details_model->deleteemployeeidByid($content_id);
        }

        redirect('findemployeelist/all_delete_employee');
    }

    public function getsalarybysalaryid()
    {
        header('Content-type: application/json');
        $id = $this->input->post('salary_id');
        $salary_info = $this->emp_salary_model->getsalarybysalaryid($id);
        echo json_encode($salary_info);
    }

    public function updatesalarybysalaryid()
    {
        header('Content-type: application/json');
        $salary_id = $this->input->post('emp_salary_id');
        $salary_info = $this->add_salary_controller->updatesalarybyid($this->input->post(), $salary_id);
        echo json_encode($salary_info);
    }

    public function getempcontentid()
    {
        header('Content-type: application/json');
        $emp_code = $this->input->post('emp_code');
        $employee_id = $this->employee_id_model->getemp_idby_empcode($emp_code);
        echo json_encode($employee_id);
    }

    public function getdepartmentidbydivisionid()
    {
        header('Content-type: application/json');
        $companyTid = $this->input->post('division_tid');
        // $division_tid = 16;
        $data['department_selected'] = $this->taxonomy->getTaxonomychildbyparent($companyTid);
        echo json_encode($data['department_selected']);
    }

    public function getDivisionByCompanyId()
    {
        header('Content-type: application/json');
        $companyTid = $this->input->post('company_id');
        // $division_tid = 16;
        $data['divisions'] = $this->taxonomy->getTaxonomychildbyparent($companyTid);
        echo json_encode($data['divisions']);
    }

    public function getshifttime()
    {
        header('Content-type: application/json');
        $emp_shift_id = $this->input->post('emp_shift_id');
        // $division_tid = 16;
        $data['allworkingshift'] = $this->taxonomy->getTaxonomyBytid($emp_shift_id);
        echo json_encode($data['allworkingshift']);
    }

    public function getactivetab()
    {
        header('Content-type: application/json');
        $activeid = $this->input->post('activeid');
        if ($activeid) {
            $sessiondata = array(
                'activeid' => "",
            );
            $this->session->set_userdata($sessiondata);
            $sessiondata = array(
                'activeid' => $activeid,
            );
            $this->session->set_userdata($sessiondata);
        }

        echo json_encode($this->session->userdata('activeid'));
    }
}
