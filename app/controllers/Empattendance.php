<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Empattendance extends CI_Controller
{

    function __construct()
    {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    public function index()
    {
        //$this->load->view('recruiting/addprofile');
        redirect("empattendance/attendanceadjustment");
    }
    public function adddailyattendance()
    {
        $this->check_permission_controller->check_permission_action("add_daily_attendance");
        if ($this->input->post()) {
            $this->form_validation->set_rules('emp_name', 'Name', 'required');
            $this->form_validation->set_rules('emp_id', 'Employee Code', 'required');
            $this->form_validation->set_rules('emp_attendance_date', 'Attendance Date', 'required');
            $this->form_validation->set_rules('emp_login_time', 'Login Time', 'required');
            $this->form_validation->set_rules('emp_logout_time', 'Logout Time', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                $this->add_dailyattendance_controller->add_attendance_action($this->input->post());
            }
        }
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $user_data = $this->users_model->getuserbyid($user_id);
        $user_division_id = $user_data['user_division'];
        $data['user_info'] = $this->users_model->getuserbyid($user_id);
        $data['user_type_id'] = $this->session->userdata('user_type');
        if ($user_type != 1) {
            $data['allemployee'] = $this->search_field_emp_model->getallemployeebydivision($user_division_id);
        } else {
            $data['allemployee'] = $this->search_field_emp_model->getallemployee();
        }
        $this->load->view('attendance/adddailyattendance', $data);
    }
    public function attendanceinformed()
    {
        $this->check_permission_controller->check_permission_action("add_informed");
        if ($this->input->post()) {
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            $this->form_validation->set_rules('emp_attendance_end_date', 'Attendance End Date', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                $emp_id = $this->input->post('emp_id');
                $companyTid = $this->input->post('emp_company');
                $divisionTid = $this->input->post('emp_division');
                if ($emp_id == '') {
                    $informed_start_date = $this->input->post('emp_attendance_start_date');
                    $informed_end_date = $this->input->post('emp_attendance_end_date');
                    if ($divisionTid == '') {
                        $content_id = $this->employee_id_model->get_all_content_id($companyTid);
                    } else {
                        $content_id = $this->employee_id_model->getAllActiveEmpByDivisionId($companyTid, $divisionTid);
                    }

                    //                    echo '<pre>';
                    //                    print_r($content_id);
                    //                    echo '</pre>';
                    //                    exit();
                    while (strtotime($informed_start_date) <= strtotime($informed_end_date)) {
                        $this->add_informed_controller->add_all_informed_action($this->input->post(), $informed_start_date, $content_id);
                        $informed_start_date = date("d-m-Y", strtotime("+1 day", strtotime($informed_start_date)));
                        //                        if($informed_start_date==$informed_end_date){
                        //                             $this->add_informed_controller->add_all_informed_action($this->input->post(), $informed_start_date, $content_id);
                        //                        }
                    }
                } else {
                    $informed_start_date = $this->input->post('emp_attendance_start_date');
                    $informed_end_date = $this->input->post('emp_attendance_end_date');
                    $emp_id = $this->input->post('emp_id');
                    $content_id = $this->employee_id_model->getemp_idby_empcode($emp_id);
                    while (strtotime($informed_start_date) <= strtotime($informed_end_date)) {
                        $this->add_informed_controller->add_informed_action($this->input->post(), $informed_start_date, $content_id);
                        $informed_start_date = date("d-m-Y", strtotime("+1 day", strtotime($informed_start_date)));
                        if ($informed_start_date == $informed_end_date) {
                            $this->add_informed_controller->add_informed_action($this->input->post(), $informed_start_date, $content_id);
                        }
                    }
                }
            }
        }
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $user_data = $this->users_model->getuserbyid($user_id);
        $user_division_id = $user_data['user_division'];
        $data['user_info'] = $this->users_model->getuserbyid($user_id);
        $data['user_type_id'] = $this->session->userdata('user_type');
        if ($user_type != 1) {
            $data['allemployee'] = $this->search_field_emp_model->getallemployeebydivision($user_division_id);
        } else {
            $data['allemployee'] = $this->search_field_emp_model->getallemployee();
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid(1);
        }
        $this->load->view('attendance/empinformed', $data);
    }
    public function saveEmployeeMovementOrder()
    {
        //        echo "<pre/>";
        //        print_r($this->input->post());
        $contentId = $this->session->userdata('content_id');
        $postData = $this->input->post();
        if ($postData) {
            $this->form_validation->set_rules('date_of_movement', 'Date Of Movement', 'required');
            $this->form_validation->set_rules('work_location', 'Work Location', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                if ($contentId > 0) {
                    $editId = $this->input->post('edit_movement_id');
                    if (!$editId) {
                        $formData = array(
                            'content_id' => $contentId,
                            'attendance_date' => $postData['date_of_movement'],
                            'presence_status' => "P",
                            'logout_status' => "P",
                            'reason' => $postData['reason'],
                            'work_location' => $postData['work_location'],
                            'contact_number' => $postData['contact_number'],
                            'informed_earlier' => $postData['informed_earlier'],
                            'type_of_movement' => $postData['type_of_movement'],
                            'remarks' => $postData['type_of_movement'],
                            'out_time' => $postData['out_time'],
                            'expected_in_time' => $postData['in_time'],
                            'location_from' => $postData['location_form'],
                            'location_to' => $postData['location_to'],
                            'possibility_of_return' => $postData['possibility_of_return'],
                            'first_approval' => 0,
                            'second_approval' => 0,
                            'entry_date' => getCurrentDateTime(),
                            'entry_user' => $this->session->userdata('content_id')
                        );
                        //                echo "<pre/>";
                        //                print_r($formData);
                        $this->db->insert("emp_informed", $formData);
                        $this->session->set_flashdata('success', "Movement Order Submited Successfully!");
                    } else {
                        $updateData = array(
                            'attendance_date' => $postData['date_of_movement'],
                            'presence_status' => "P",
                            'logout_status' => "P",
                            'reason' => $postData['reason'],
                            'work_location' => $postData['work_location'],
                            'contact_number' => $postData['contact_number'],
                            'informed_earlier' => $postData['informed_earlier'],
                            'type_of_movement' => $postData['type_of_movement'],
                            'remarks' => $postData['type_of_movement'],
                            'out_time' => $postData['out_time'],
                            'expected_in_time' => $postData['in_time'],
                            'location_from' => $postData['location_form'],
                            'location_to' => $postData['location_to'],
                            'possibility_of_return' => $postData['possibility_of_return'],
                            'first_approval' => 0,
                            'second_approval' => 0,
                            'updated_time'          =>  getCurrentDateTime(),
                            'updated_by'            =>  $this->session->userdata('content_id'),
                        );
                        $updateConditionArr = array(
                            'id' => $editId
                        );
                        $this->emp_informed_model->updemp_emp_informedtbl($updateData, $updateConditionArr);
                        $this->session->set_flashdata('msg', "Movement Order Updated successfully.");
                        redirect('employee-movement-orders');
                    }
                } else {
                    $this->session->set_flashdata('ERROR!', "Something went wrong!");
                }
            }
        }
        redirect('employee-movement-order-form');
    }

    public function employeeMovementOrder()
    {
        $contentId = $this->session->userdata('content_id');
        $data['employee_movement_orders'] = $this->emp_informed_model->movementOrderByEmp($contentId);
        $this->load->view('movement-order/employee-movement-orders', $data);
    }
    public function attendanceinformedajax()
    {
        header('Content-type: application/json');
        $informed_id = $this->input->post('informed_id');
        if ($informed_id) {
            $informed_data = $this->emp_informed_model->getemp_informedbyid($informed_id);
            echo json_encode($informed_data);
        }
    }
    public function attendanceinformedajaxsubmit()
    {
        header('Content-type: application/json');
        $informed_datapost = $this->input->post();
        $informed_id = $this->input->post('informed_id');
        $informed_start_date = $this->input->post('emp_attendance_start_date');
        if ($informed_id) {
            $informed_data = $this->emp_informed_model->getemp_informedbyid($informed_id);
            $content_id = $informed_data['content_id'];
            $this->add_informed_controller->add_informed_action($this->input->post(), $informed_start_date, $content_id);
            $informed_newdata = $this->emp_informed_model->getemp_informedbyid($informed_id);
            echo json_encode($informed_newdata);
        }
    }
    public function logMaintenance()
    {
        $this->check_permission_controller->check_permission_action("add_log_maintenence");
        if ($this->input->post()) {
            // $this->form_validation->set_rules('emp_name', 'Name', 'required');
            //$this->form_validation->set_rules('emp_id', 'Employee Code', 'required');
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            $this->form_validation->set_rules('emp_attendance_end_date', 'Attendance End Date', 'required');
            //$this->form_validation->set_rules('emp_login_time', 'Login Time', 'required');
            //$this->form_validation->set_rules('emp_logout_time', 'Logout Time', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                $informed_start_date = $this->input->post('emp_attendance_start_date');
                $informed_end_date = $this->input->post('emp_attendance_end_date');
                $emp_id = $this->input->post('emp_id');
                $content_id = $this->employee_id_model->getemp_idby_empcode($emp_id);
                while (strtotime($informed_start_date) <= strtotime($informed_end_date)) {
                    $this->add_logmaintenence_controller->add_logmaintenence_action($this->input->post(), date('Y-m-d',strtotime($informed_start_date)));
                    $informed_start_date = date("Y-m-d", strtotime("+1 day", strtotime($informed_start_date)));
                    if ($informed_start_date == $informed_end_date) {
                        $this->add_logmaintenence_controller->add_logmaintenence_action($this->input->post(), $informed_start_date);
                    }
                }
            }
            redirect('empattendance/logMaintenance');
        }
        $division_vid = 1;
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $user_data = $this->users_model->getuserbyid($user_id);
        $user_division_id = $user_data['user_division'];
        $data['user_info'] = $this->users_model->getuserbyid($user_id);
        $data['user_type_id'] = $this->session->userdata('user_type');
        if ($user_type != 1) {
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);
            $data['allemployee'] = $this->search_field_emp_model->getallemployeebydivision($user_division_id);
        } else {
            $data['allemployee'] = $this->search_field_emp_model->getallemployee();
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        }
        $this->load->view('attendance/logmaintenence', $data);
    }
    public function getempattendancebydate()
    {
        header('Content-type: application/json');
        $emp_code = $this->input->post('emp_id');
        //$emp_code = 365;
        $emp_attendance_date = $this->input->post('emp_attendance_date');
        // $emp_attendance_date = '03-08-2015';
        $employee_id = $this->employee_id_model->getemp_idby_empcode($emp_code);
        $has_attendance = $this->emp_attendance_model->getemp_dailyattendance($employee_id, $emp_attendance_date);
        echo json_encode($has_attendance);
    }

    public function adminMovementOrderForm()
    {
        $id = $this->uri->segment(2);
        if ($id) {
            $data['edit_info'] = $this->emp_informed_model->getemp_informedbyid($id);
            //        print_r($data['edit_info']);
            //        exit;
        }
        $allleavetype_vid = 16;
        $data['allleavetype'] = $this->taxonomy->getTaxonomyByvid($allleavetype_vid);
        $user_id = $this->session->userdata('user_id');
        $emp_ids_data = $this->users_model->getpermittedemployee($user_id);
        $content_ids = $emp_ids_data['emp_content_ids'];
        if ($user_id == 1 || $user_id == 16 || $user_id == 36) {
            $data['allemployee'] = $this->search_field_emp_model->getallemployee();
        } else {
            $data['allemployee'] = $this->search_field_emp_model->getallsearch_table_contentByids($content_ids);
        }
        $this->load->view('movement-order/admin-movement-order-form', $data);
    }

    public function saveAdminMovementOrder()
    {
        //        echo "<pre/>";
        //        print_r($this->input->post());
        $postData = $this->input->post();
        if ($postData) {
            $this->form_validation->set_rules('date_of_movement', 'Date Of Movement', 'required');
            $this->form_validation->set_rules('work_location', 'Work Location', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                $userEmployeeId = $this->session->userdata('employee_id');
                $empInfo = $this->db->query("SELECT id FROM employee_id WHERE emp_id='$userEmployeeId' ")->row();
                $contentId = $empInfo->id;
                if ($postData['content_id'] > 0) {
                    $editId = $this->input->post('edit_movement_id');
                    if (!$editId) {
                        $postContentId = $postData['content_id'];
                        $dateOfMovement = $postData['date_of_movement'];
                        $checkExist = $this->db->query("SELECT * FROM emp_informed WHERE content_id=$postContentId AND attendance_date='$dateOfMovement' ")->row();
                        if($checkExist){
                            $this->session->set_flashdata('error', "Movement Order Already Exist!");
                            redirect('admin-daily-movement-form');
                        }
                        $formData = array(
                            'content_id' => $postContentId,
                            'attendance_date' => $postData['date_of_movement'],
                            'presence_status' => "P",
                            'logout_status' => "P",
                            'reason' => $postData['reason'],
                            'work_location' => $postData['work_location'],
                            'contact_number' => $postData['contact_number'],
                            'informed_earlier' => $postData['informed_earlier'],
                            'type_of_movement' => $postData['type_of_movement'],
                            'remarks' => $postData['type_of_movement'],
                            'out_time' => $postData['out_time'],
                            'expected_in_time' => $postData['in_time'],
                            'location_from' => $postData['location_form'],
                            'location_to' => $postData['location_to'],
                            'possibility_of_return' => $postData['possibility_of_return'],
                            'first_approval' => 0,
                            'second_approval' => 0,
                            'entry_date' => getCurrentDateTime(),
                            'entry_user' => $contentId
                        );
                        //                echo "<pre/>";
                        //                print_r($formData);
                        $this->db->insert("emp_informed", $formData);
                        $this->session->set_flashdata('success', "Movement Order Submited Successfully!");
                    } else {
                        $updateData = array(
                            'content_id' => $postData['content_id'],
                            'attendance_date' => $postData['date_of_movement'],
                            'presence_status' => "P",
                            'logout_status' => "P",
                            'reason' => $postData['reason'],
                            'work_location' => $postData['work_location'],
                            'contact_number' => $postData['contact_number'],
                            'informed_earlier' => $postData['informed_earlier'],
                            'type_of_movement' => $postData['type_of_movement'],
                            'remarks' => $postData['type_of_movement'],
                            'out_time' => $postData['out_time'],
                            'expected_in_time' => $postData['in_time'],
                            'location_from' => $postData['location_form'],
                            'location_to' => $postData['location_to'],
                            'possibility_of_return' => $postData['possibility_of_return'],
                            'first_approval' => 0,
                            'second_approval' => 0,
                            'updated_time'          =>  getCurrentDateTime(),
                            'updated_by'            =>  $contentId,
                        );
                        $updateConditionArr = array(
                            'id' => $editId
                        );
                        $this->emp_informed_model->updemp_emp_informedtbl($updateData, $updateConditionArr);
                        $this->session->set_flashdata('success', "Movement Order Updated successfully.");
                        redirect('admin-movement-orders');
                    }
                } else {
                    $this->session->set_flashdata('error', "Something went wrong!");
                }
            }
        }
        redirect('admin-daily-movement-form');
    }

    public function adminMovementOrder()
    {
        $user_id = $this->session->userdata('user_id');
        $emp_ids_data = $this->users_model->getpermittedemployee($user_id);
        $content_ids = $emp_ids_data['emp_content_ids'];
        $data['employee_movement_orders'] = $this->emp_informed_model->allMovementOrderByAdmin($content_ids);
        $this->load->view('movement-order/admin-movement-orders', $data);
    }

    public function updateApprovalStatus()
    {
        $userEmployeeId = $this->session->userdata('employee_id');
        $empInfo = $this->db->query("SELECT id FROM employee_id WHERE emp_id='$userEmployeeId' ")->row();
        $empContentId = $empInfo->id;
        $columnName = $this->input->post('name');
        $newValue = $this->input->post('value');
        $contentId = $this->input->post('pk');
        // Edit ----------------------------------
        $this->db->set($columnName, $newValue);
        $this->db->set('updated_time', getCurrentDateTime());
        $this->db->set('updated_by', $empContentId);
        $this->db->where('id', $contentId);
        $result = $this->db->update('emp_informed');
    }

    public function dailyMovementOrders()
    {
        $data['employee_movement_orders'] = $this->emp_informed_model->allMovementOrderByHrAdmin();
        $this->load->view('movement-order/daily-movement-orders', $data);
    }
    public function pendingDailyMovementOrders()
    {
        $data['employee_movement_orders'] = $this->emp_informed_model->pendingMovementOrderByHrAdmin();
        $this->load->view('movement-order/pending-daily-movement-orders', $data);
    }

    public function printDailyMovement($id)
    {
        // echo $id; exit;
        $this->load->library("pdf");
        $mpdf = $this->pdf->load();
        $data['empDailyMovementInfo'] = $this->emp_informed_model->getMovementOrderInfoById($id);
        $html = $this->load->view('movement-order/daily-movement-order-pdf', $data, true);
        // $mpdf->SetProtection(array('print'), 'pass2open', 'pass2havefullaccess');
        // $mpdf->SetVisibility('screenonly'); 
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetVisibility('hidden');
        // $mpdf->SetProtection(array('copy','print','modify'), 'r', 'MyPassword');
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $pdfFilePath = "daily-movement-order.pdf";
        $mpdf->Output($pdfFilePath, "I"); // Preview In browser
        // Preview In Firefox browser problem Issue: Menu Bar(Alt) >> Tools >> options >> General >> Applications >> PDF >> Select Action >>Preview in Firefox.
    }
    public function deleteEmployeeMovementOrder($id)
    {
        $movInfo = $this->emp_informed_model->getemp_informedbyid($id);
        if ($movInfo['first_approval'] == 0 && $movInfo['second_approval'] == 0) {
            $res = $this->emp_informed_model->deleteInformed($id);
            if ($res) {
                $this->session->set_flashdata('msg', "Movement order <font color='red'>deleted</font> successfully.");
            }
        } else {
            $this->session->set_flashdata('msg', "SORRY! Movement order <font color='warning'>not deleted</font>. You can't delete this without admistrator permission.");
        }

        // redirect('employee-movement-orders');
        redirect('pending-daily-movement-orders');
    }
    public function deleteAdminMovementOrder($id)
    {
        $movInfo = $this->emp_informed_model->getemp_informedbyid($id);
        if ($movInfo['second_approval'] == 0) {
            $res = $this->emp_informed_model->deleteInformed($id);
            if ($res) {
                $this->session->set_flashdata('success', "Movement order <font color='red'>deleted</font> successfully.");
            }
        } else {
            $this->session->set_flashdata('success', "SORRY! Movement order <font color='warning'>not deleted</font>. You can't delete this without admistrator permission.");
        }
        redirect('admin-movement-orders');
    }
}
