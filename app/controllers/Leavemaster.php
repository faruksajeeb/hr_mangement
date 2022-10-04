<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Leavemaster extends CI_Controller {

    function __construct() {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model("Emp_leave_model","emp_leave_model");
    }

    public function index() {
        // $this->db2= $this->load->database('test', true);  
        // $query = $this->db2->get('circular');
        // echo "<pre>";
        // print_r($query->result());
        // echo "</pre>";
        redirect("leavemaster/single_leave");
    }

    function single_leave($year = null, $month = null) {
        $this->check_permission_controller->check_permission_action("add_leave");
        if (!$year) {
            $year = date('Y');
        }
        if (!$month) {
            $month = date('m');
        }

        $this->load->model("mycal_model");
        $searchpage = "single_leave";
        $default_emp_id = $this->search_field_emp_model->getsearchQuery($searchpage);
		$data['defaultyear'] = $year;
        $data['defaultmonth'] = $month;
        $emp_atten_date = "01-01-$year";
        if($default_emp_id['search_query']){
            $data['defaultcontent_id'] = $default_emp_id['search_query'];
        
        }else{
            $data['defaultcontent_id'] =0;
        }
        $previous_year_total_earn_leave = 0;
        $previous_year_earn_leave_availed =0;
        $previous_carry_forward_leave_balance = 0;
        
        $previous_carry_forward_leave_balance = $this->emp_leave_model->getPreviousCarryForwardLeaveBalance($year,$data['defaultcontent_id']);
       
        $data['previous_carry_forward_leave_balance'] = $previous_carry_forward_leave_balance;
        
        $data['current_year_total_leave'] = $this->emp_leave_model->getCurrentYearTotalLeave($year, $data['defaultcontent_id']);
        $data['default_emp'] = $this->search_field_emp_model->getallsearch_table_contentByid($default_emp_id['search_query']);
        
        $data['emp_total_leave'] = $this->emp_yearly_leave_history_model->getemp_yearlyleave_historybydate($default_emp_id['search_query'], $emp_atten_date);
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
		
        $data['emp_holiday'] = $this->emp_holiday_model->getemp_holiday($default_emp_id['search_query']);
		
        $data['calendar'] = $this->mycal_model->generate($year, $month);
        $allleavetype_vid = 16;
        $data['allleavetype'] = $this->taxonomy->getTaxonomyByvid($allleavetype_vid);
        $this->load->view('recruiting/leavemaster', $data);
    }

    public function saveEmployeeLeaveApplication() {
        $postData = $this->input->post();
//      print_r($postData);
        $contentId = $this->session->userdata('content_id');
        $empInfo = $this->db->query("SELECT emp_department,emp_division,emp_post_id FROM search_field_emp WHERE content_id=$contentId ")->row();
        $empDivisionId = $empInfo->emp_division;
        $empDepartmentId = $empInfo->emp_department;
        $empPostInfo = $this->db->query("SELECT name FROM taxonomy WHERE tid=$empInfo->emp_post_id ")->row();
        $empPostName = strtolower($empPostInfo->name);
        if (strpos($empPostName, 'security guard') !== false) {
            $empPostName = 'security_guard';
        }else{
            $empPostName = 'others';
        }
        $leaveStartDate = $postData['leave_form'];
        $leaveEndDate = $postData['leave_to'];
        if ($postData) {
            $this->form_validation->set_rules('leave_type', 'Leave Type', 'required');
            $this->form_validation->set_rules('purpose', 'Purpose', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
                redirect('employee-leave-application');
            } else {
                $editId = $postData['leave_edit_id'];
                if (!$editId) {
                    $message = "";
                    $message = "<ul class='msg'>";
                    while (strtotime($leaveStartDate) <= strtotime($leaveEndDate)) {                        
                        $dated_day_name = date("D", strtotime($leaveStartDate));
                        $nameOfDay = strtolower($dated_day_name);
                        $empatt_start_date_arr = explode("-", $leaveStartDate);
                        $leaveDate = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
                        $weeklyHolidayExist = $this->db->query("SELECT * FROM emp_weeklyholiday_history WHERE content_id='$contentId' AND str_to_date(start_date, '%d-%m-%Y') <='$leaveDate' ORDER BY id DESC LIMIT 1")->row_array();
                        $holidayExist = $this->db->query("SELECT * FROM emp_yearlyholiday WHERE holiday_for_department=$empDepartmentId AND holiday_start_date='$leaveStartDate' ")->row();
                        if (!$holidayExist) {                           
                            $holidayExist = $this->db->query("SELECT * FROM emp_yearlyholiday WHERE holiday_for_division=$empDivisionId AND (holiday_for_department = NULL OR holiday_for_department = '') AND holiday_start_date='$leaveStartDate' ")->row();
                        }
                        if (!$holidayExist) {
                             
                            $holidayExist = $this->db->query("SELECT * FROM emp_yearlyholiday WHERE holiday_for_division='all' AND holiday_start_date='$leaveStartDate' ")->row();
                        }
                        
                        if (($empPostName != 'security_guard') && ($holidayExist || ($weeklyHolidayExist['' . $nameOfDay . '_off'] == 'off'))) {
                            if($holidayExist){
                                $message .= "<li><font color=red>SORRY! (" .$leaveStartDate.") is a holiday.</font></li/>"; 
                            }else{
                                $message .= "<li><font color=red>SORRY! (" .$leaveStartDate.") is a weekly holiday.</font></li>";
                            }
                           
                        } else {
                            
                            $leaveExist = $this->db->query("SELECT * FROM emp_leave WHERE leave_start_date='$leaveStartDate' AND content_id='$contentId' ")->row();
                            if ($leaveExist) {
                                $message .= "<li><font color=red>SORRY! (" .$leaveStartDate.") leave application already exist!</font></li>";
                            } else {
                                
                                $this->add_leave_controller->insertLeaveApplication($postData, $leaveStartDate, $contentId);
                                $message .= "<li><font color=green> (" .$leaveStartDate.") Leave Application Submitted successfully.</font></li>";
                            }
                        }
                        $leaveStartDate = date("d-m-Y", strtotime("+1 day", strtotime($leaveStartDate)));
                    }
                    $this->session->set_flashdata('msg', $message);
                } else {
                    $updateData = array(
                        'leave_type' => $postData['leave_type'],
                        'pay_status' => $postData['leave_pay_status'],
                        'justification' => $postData['purpose'],
                        'leave_address' => $postData['contact_address'],
                        'contact_number' => $postData['contact_number'],
                        'department_approval' => 0,
                        'approve_status' => "pending",
                        'updated_time' => getCurrentDateTime(),
                        'updated_by' => $this->session->userdata('user_id'),
                    );
                    $updateConditionArr = array(
                        'id' => $editId
                    );
                    $this->emp_leave_model->updemp_leavetbl($updateData, $updateConditionArr);
                    $this->session->set_flashdata('msg', "<font color=green> Leave Application Updated successfully.</font>");
                }
            }
        }

        redirect('employee-leave');
    }

    public function saveAdminLeaveApplication() {
        $postData = $this->input->post();
//      print_r($postData);
//      exit;
        $contentId = $postData['content_id'];
        $empInfo = $this->db->query("SELECT emp_department,emp_division,emp_post_id FROM search_field_emp WHERE content_id=$contentId ")->row();
        $empDivisionId = $empInfo->emp_division;
        $empDepartmentId = $empInfo->emp_department;
        $empPostInfo = $this->db->query("SELECT name FROM taxonomy WHERE tid=$empInfo->emp_post_id ")->row();
        $empPostName = strtolower($empPostInfo->name);
        if (strpos($empPostName, 'security guard') !== false) {
            $empPostName = 'security_guard';
        }else{
            $empPostName = 'others';
        }
        $leaveStartDate = $postData['leave_form'];
        $leaveEndDate = $postData['leave_to'];
        if ($postData) {
            $this->form_validation->set_rules('content_id', 'Employee', 'required');
            $this->form_validation->set_rules('leave_type', 'Leave Type', 'required');
            $this->form_validation->set_rules('purpose', 'Purpose', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
                redirect('admin-leave-application-form');
            } else {
                $editId = $postData['leave_edit_id'];
                if (!$editId) {
                    $message = "";
                    $message = "<ul class='msg'>";
                    while (strtotime($leaveStartDate) <= strtotime($leaveEndDate)) {
                        $dated_day_name = date("D", strtotime($leaveStartDate));
                        $nameOfDay = strtolower($dated_day_name);
                        $empatt_start_date_arr = explode("-", $leaveStartDate);
                        $leaveDate = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
                        $weeklyHolidayExist = $this->db->query("SELECT * FROM emp_weeklyholiday_history WHERE content_id='$contentId' AND str_to_date(start_date, '%d-%m-%Y') <='$leaveDate' ORDER BY id DESC LIMIT 1")->row_array();
                        $holidayExist = $this->db->query("SELECT * FROM emp_yearlyholiday WHERE holiday_for_department=$empDepartmentId AND holiday_start_date='$leaveStartDate' ")->row();
                        if (!$holidayExist) {
                            $holidayExist = $this->db->query("SELECT * FROM emp_yearlyholiday WHERE holiday_for_division=$empDivisionId AND (holiday_for_department = NULL OR holiday_for_department = '') AND holiday_start_date='$leaveStartDate' ")->row();
                        }
                        if (!$holidayExist) {
                            $holidayExist = $this->db->query("SELECT * FROM emp_yearlyholiday WHERE holiday_for_division='all' AND holiday_start_date='$leaveStartDate' ")->row();
                        }
                        
                        
                        if (($empPostName != 'security_guard') && ($holidayExist || ($weeklyHolidayExist['' . $nameOfDay . '_off'] == 'off'))) {
                            if($holidayExist){
                                $message .= "<li><font color=red>SORRY! (" .$leaveStartDate.") is a holiday.</font></li/>"; 
                            }else{
                                $message .= "<li><font color=red>SORRY! (" .$leaveStartDate.") is a weekly holiday.</font></li>";
                            }
                            
                        } else {
                            $leaveExist = $this->db->query("SELECT * FROM emp_leave WHERE leave_start_date='$leaveStartDate' AND content_id='$contentId' ")->row();
                            if ($leaveExist) {
                                $message .= "<li><font color=red>SORRY! (" .$leaveStartDate.") leave application already exist!</font></li>";
                            } else {
                                // echo "Not Exist!";
                                $this->add_leave_controller->insertLeaveApplication($postData, $leaveStartDate, $contentId);                           
                                $message .= "<li><font color=green> (" .$leaveStartDate.") Leave Application Submitted successfully.</font></li>";
                            }                            
                        }
                        $leaveStartDate = date("d-m-Y", strtotime("+1 day", strtotime($leaveStartDate)));
                        
                    }
                    $message .= "</ul>";
                    $this->session->set_flashdata('msg', $message);
                } else {
                    $updateData = array(
                        'content_id' => $postData['content_id'],
                        'leave_type' => $postData['leave_type'],
                        'pay_status' => $postData['leave_pay_status'],
                        'justification' => $postData['purpose'],
                        'leave_address' => $postData['contact_address'],
                        'contact_number' => $postData['contact_number'],
                        'department_approval' => 0,
                        'approve_status' => "pending",
                        'updated_time' => getCurrentDateTime(),
                        'updated_by' => $this->session->userdata('user_id'),
                    );
                    $updateConditionArr = array(
                        'id' => $editId
                    );
                    $this->emp_leave_model->updemp_leavetbl($updateData, $updateConditionArr);
                    $this->session->set_flashdata('msg', "Leave Application Updated successfully.");
                    redirect('admin-leave-application');
                }
            }
        }

        redirect('admin-leave-application-form');
    }

    public function employeeLeave() {
        $contentId = $this->session->userdata('content_id');
        $data['employee_leaves'] = $this->emp_leave_model->leaveByEmp($contentId);
        $this->load->view('leave/employee-leave', $data);
    }

    public function leaveApplication() {
        $data['employee_leaves'] = $this->emp_leave_model->allLeaveApplication();
        $this->load->view('leave/leave-application', $data);
    }

    public function pendingLeaveApplication() {
        $data['employee_leaves'] = $this->emp_leave_model->pendingLeaveApplication();
        $this->load->view('leave/pending-leave-application', $data);
    }

    public function getempcontentid() {
        header('Content-type: application/json');
        $searchpage = "single_leave";
        $emp_code = $this->input->post('emp_code');
        $employee_id = $this->employee_id_model->getemp_idby_empcode($emp_code);
        $user_id = $this->session->userdata('user_id');
        $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
        date_default_timezone_set('Asia/Dhaka');
        $servertime = time();
        $now = date("d-m-Y", $servertime);
        $query = $employee_id;
        $params_contents = array(
            'id' => '',
            'search_query' => $query,
            'user_id' => $user_id,
            'table_view' => "0",
            'per_page' => "24",
            'search_page' => $searchpage,
            'search_date' => $now,
        );
        $this->db->insert("search_query", $params_contents);
        $desearchpage = "single_leave";
        $default_emp_idd = $this->search_field_emp_model->getsearchQuery($desearchpage);
        // $data['defaultcontent_id']=$default_emp_idd['search_query'];    
        echo json_encode($default_emp_idd['search_query']);
    }

    public function getempavailleave() {
        header('Content-type: application/json');
        $searchpage = "single_leave";
        date_default_timezone_set('Asia/Dhaka');
        $servertime = time();
        $leave_year = date("Y", $servertime);
        $leave_code = $this->input->post('leave_code');
        $leave_start_date = $this->input->post('leave_start_date');
        $att_date_arr = explode("-", $leave_start_date);
        $leave_year = $att_date_arr[2];
        $month = $att_date_arr[1];
        if (!$leave_year) {
            $leave_year = date('Y');
        }
        if (!$month) {
            $month = date('m');
        }
        //$leave_code = 331;
        $emp_id = $this->input->post('emp_id');
        //$emp_id = 334;
        $content_id = $this->employee_id_model->getemp_idby_empcode($emp_id);
        $emp_total_leave = $this->emp_leave_model->getemp_yearlyleavetotal($content_id);
        $previous_carry_forward_leave_balance = 0;
        
        $previous_carry_forward_leave_balance = $this->emp_leave_model->getPreviousCarryForwardLeaveBalance($leave_year,$content_id);
        
        if ($emp_total_leave) {
            $allleavetype_vid = 16;
            $allleavetype = $this->taxonomy->getTaxonomyByvid($allleavetype_vid);
            $spent_grant_total = 0;
            foreach ($allleavetype as $single_leave) {
                $tid = $single_leave['tid'];
                $total_leave_spent_query = $this->emp_leave_model->getempSpentleave($content_id, $tid, $leave_year);
                $total_leave_spent = 0;
                foreach ($total_leave_spent_query as $single_spent_leave) {
                    $total_leave_spent = $total_leave_spent + $single_spent_leave['leave_total_day'];
                }
                $spent_grant_total = $spent_grant_total + $total_leave_spent;
            }
            $available_leave = ($previous_carry_forward_leave_balance+$emp_total_leave['total_days']) - $spent_grant_total;
        } else if ($content_id) {
            $total_leave = $this->emp_leave_model->getemp_yearlyleave($content_id, $leave_code);
            $total_leave_spent_query = $this->emp_leave_model->getempSpentleave($content_id, $leave_code, $leave_year);
            $total_leave_spent = 0;
            foreach ($total_leave_spent_query as $single_spent_leave) {
                $total_leave_spent = $total_leave_spent + $single_spent_leave['leave_total_day'];
            }
            $available_leave = ($previous_carry_forward_leave_balance+$total_leave['total_days']) - $total_leave_spent;
        }

        echo json_encode($available_leave);
    }

    public function entryLeave() {
        header('Content-type: application/json');
        $leave_start_date = $this->input->post('leave_start_date');
        $leave_end_date = $this->input->post('leave_end_date');
        $emp_id = $this->input->post('emp_id');
        $content_id = $this->employee_id_model->getemp_idby_empcode($emp_id);
        date_default_timezone_set('Asia/Dhaka');

        while (strtotime($leave_start_date) <= strtotime($leave_end_date)) {
            $this->add_leave_controller->add_leave_action($this->input->post(), $content_id, $leave_start_date);
            $leave_start_date = date("d-m-Y", strtotime("+1 day", strtotime($leave_start_date)));
            if ($leave_start_date == $leave_end_date) {
                $this->add_leave_controller->add_leave_action($this->input->post(), $content_id, $leave_start_date);
            }
        }
        echo json_encode($content_id);
    }

    public function getEmployeeleave() {
        header('Content-type: application/json');
        $leave_date = $this->input->post('leave_date');
        $searchpage = "single_leave";
        $default_emp_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $defaultcontent_id = $default_emp_id['search_query'];
        $leave_info = $this->emp_leave_model->getemp_leave($defaultcontent_id, $leave_date);

        echo json_encode($leave_info);
    }

    public function updateLeaveStatus() {
        $columnName = $this->input->post('name');
        $newValue = $this->input->post('value');
        $contentId = $this->input->post('pk');
        // Edit ----------------------------------
        $this->db->set($columnName, $newValue);
        $this->db->set('updated_time', $this->current_time());
        $this->db->set('updated_by', $this->session->userdata('user_id'));
        $this->db->where('id', $contentId);
        $result = $this->db->update('emp_leave');
    }

    public function adminLeaveApplicationForm() {
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
        $id = $this->uri->segment(2);
        if ($id) {
            $data['edit_info'] = $this->emp_leave_model->getLeaveByLeaveId($id);
            //        print_r($data['edit_info']);
//        exit;
        }
        $this->load->view('leave/admin-leave-application-form', $data);
    }

    public function adminLeaveApplication() {
        $user_id = $this->session->userdata('user_id');
        $emp_ids_data = $this->users_model->getpermittedemployee($user_id);
        $content_ids = $emp_ids_data['emp_content_ids'];
        $data['employee_leaves'] = $this->emp_leave_model->allAdminLeaveApplication($content_ids);
        $this->load->view('leave/admin-leave-application', $data);
    }

    public function printLeaveApplication($id) {
        // echo $id; exit;
        $this->load->library("pdf");
        $mpdf = $this->pdf->load();
        $data['empLeaveAppInfo'] = $this->emp_leave_model->getLeaveApplicationInfoById($id);
        $html = $this->load->view('leave/leave-application-pdf', $data, true);
        // $mpdf->SetProtection(array('print'), 'pass2open', 'pass2havefullaccess');
        // $mpdf->SetVisibility('screenonly'); 
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetVisibility('hidden');
        // $mpdf->SetProtection(array('copy','print','modify'), 'r', 'MyPassword');
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $pdfFilePath = "payslip-of-" . $data['paySlipInfo']->emp_name . "-for-the-month-of-" . $data['paySlipInfo']->month_name . "'" . $data['paySlipInfo']->year . ".pdf";
        $mpdf->Output($pdfFilePath, "I"); // Preview In browser
        // Preview In Firefox browser problem Issue: Menu Bar(Alt) >> Tools >> options >> General >> Applications >> PDF >> Select Action >>Preview in Firefox.
    }

    public function deleteLeaveApplication($id) {
        $leaveInfo = $this->emp_leave_model->getLeaveByLeaveId($id);
        if ($leaveInfo->approve_status == 'pending' && $leaveInfo->department_approval == 0) {
            $res = $this->emp_leave_model->deleteLeaveById($id);
            if ($res) {
                $this->session->set_flashdata('msg', "Leave Application <font color='red'>deleted</font> successfully.");
            }
        } else {
            $this->session->set_flashdata('success', "Leave Application <font color='orange'>not deleted</font> . You can't delete this application without admistrator approval.");
        }

        redirect('employee-leave');
    }

    public function deleteAdminLeaveApplication($id) {
        $leaveInfo = $this->emp_leave_model->getLeaveByLeaveId($id);
        if ($leaveInfo->approve_status == 'pending') {
            $res = $this->emp_leave_model->deleteLeaveById($id);
            if ($res) {
                $this->session->set_flashdata('success', "Leave Application <font color='red'>deleted</font> successfully.");
            }
        } else {
            $this->session->set_flashdata('success', "Leave Application <font color='orange'>not deleted</font> . You can't delete this application without admistrator approval.");
        }

        redirect('admin-leave-application');
    }
    public function employeeLeaveApplication(){
        $id = $this->uri->segment(2);
        if($id){
            $data['edit_info'] = $this->emp_leave_model->getLeaveByLeaveId($id);
        }
         $allleavetype_vid = 16;
        $contentId = $this->session->userdata('content_id');
        $currentYear = date("Y"); 
        $result = $this->emp_leave_model->getEmpLeaveInfo($contentId,$currentYear);
        $data['length_of_services'] = $this->getEmpLengthOfServices($contentId,$return=TRUE);
        if($result){            
            $data['emp_leave_info'] = $result;
        }
        $data['allleavetype'] = $this->taxonomy->getTaxonomyByvid($allleavetype_vid); 
         $this->load->view('leave/employee-leave-application',$data);
    }
    public function getEmpLengthOfServices($contentId,$return=FALSE) {
      //  $contentId = $this->input->post('content_id');
      //  $currentYear = $this->input->post('year');
//        $leaveFrom = $this->input->post('leave_from');
        $singleEmployeeInfo = $this->emp_leave_model->getEmpInfo($contentId);
        $joining_date_arr = explode('-', $singleEmployeeInfo->joining_date);
        $joining_date_reversed = $joining_date_arr[2] . "-" . $joining_date_arr[1] . "-" . $joining_date_arr[0] . " 00:00:00";
        $jo = strtotime($joining_date_reversed);
        date_default_timezone_set('Asia/Dhaka');
        $now = time();
        $removed = timespan($jo, $now);
        $pieces = explode(",", $removed);
        foreach ($pieces as $key => $ll) {
            if (strpos($ll, 'Hour') !== false || strpos($ll, 'Minute') !== false) {
                unset($pieces[$key]);
            }
        }
        $string = rtrim(implode(',', $pieces), ',');
        if($return=="TRUE"){
            return $string;
        }else{            
            echo $string;
        }
        
    }

    public function getEmpLeaveInfo() {
        $contentId = $this->input->post('content_id');
        $currentYear = $this->input->post('year');
        $result = $this->emp_leave_model->getEmpLeaveInfo($contentId, $currentYear);
//        echo "55";
//        exit;
        if (!$result) {
            //echo json_encode($result);
            $result = array(
                'TotalPaidLeave' => 0,
                'TotalAnnualLeaveSpent' => 0,
                'emp_total_annual_leave' => 12,
            );
        }
        echo json_encode($result);
    }

    public function current_time() {
        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
        $current_time = $dt->format('Y-m-d H:i:s');
        return $current_time;
    }

}
