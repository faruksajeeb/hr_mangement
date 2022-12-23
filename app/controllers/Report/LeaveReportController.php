<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LeaveReportController extends CI_Controller
{
    function __construct()
    {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model("Emp_leave_model", "emp_leave_model");
    }
    public function daliyLeaveReport()
    {
        $this->check_permission_controller->check_permission_action("view_daily_leave_reports");
        $searchpage = "daily_leave_report";
        if ($this->input->post()) {
            #dd($this->input->post());
            $this->form_validation->set_rules('company_id', 'Company', 'required');
            $this->form_validation->set_rules('division_id', 'Division', 'required');
            $this->form_validation->set_rules('attendance_date', 'Attendance Date', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                $company_info = explode('|', $this->input->post('company_id'));
                $company_id = $company_info[0];
                $company_name = $company_info[1];
                $division_info = explode('|', $this->input->post('division_id'));
                $division_id = $division_info[0];
                $division_name = $division_info[1];
                $attendance_date = date('d-m-Y', strtotime($this->input->post('attendance_date')));
                if ($company_id && $division_id && $attendance_date) {
                    $divisionCondition = '';
                    if ($division_id != 'all') {
                        $divisionCondition = "AND SFE.emp_department='$division_id'";
                    }
                    $dailyLeaveData = $this->db->query("SELECT 
                    EL.*,SFE.emp_name,SFE.emp_id,
                    division.name as division_name,
                    leave_type.name as leave_type_name 
                    FROM emp_leave as EL
                    LEFT JOIN search_field_emp as SFE ON SFE.content_id=EL.content_id 
                    LEFT JOIN taxonomy as division ON division.id=SFE.emp_department 
                    LEFT JOIN taxonomy as leave_type ON leave_type.id=EL.leave_type 
                    WHERE SFE.emp_division='$company_id'
                    AND STR_TO_DATE(EL.leave_start_date,'%d-%m-%Y') = STR_TO_DATE('$attendance_date','%d-%m-%Y') 
                    $divisionCondition  
                ORDER BY SFE.emp_name");

                    if ($dailyLeaveData->num_rows() > 0) {
                        $html = '
                    <table id="table2excel" class="table2excel_with_colors table table-striped custom-table mb-0">
                    <thead>';
                        $html .= '<tr>
                        <th colspan="6" style="text-align:center;font-size:20px;background-color:#CCC">Daily Leave Report</th>
                    </tr>';
                        $html .= '<tr>
                    <th>Company Name:</th>
                    <th >' . $company_name . '</th>
                    <th style="text-align:right">Branch/ Division Name: </th>
                    <th >' . $division_name . '</th>
                    
                </tr>';
                        $html .= '<tr>
                    <th>SL NO</th>
                    <th>Leave Date</th>
                    <th>Employee Name</th>
                    <th>Employee ID</th>
                    <th>Division Name</th>
                    <th>Leave Type</th>
                </tr>';
                        $html .= '</thead>
                    <tbody>';
                        foreach ($dailyLeaveData->result() as $key => $val) :
                            $html .=
                                '<tr><td>' . ($key + 1) .
                                '</td><td>' . $val->leave_start_date .
                                '</td><td>' . $val->emp_name .
                                '</td><td>' . $val->emp_id .
                                '</td><td>' . $val->division_name .
                                '</td><td>' . $val->leave_type_name . '</td></tr>';
                        endforeach;
                        $html .= '</tbody></table>';
                        echo $html;
                    } else {
                        echo "No data found.";
                    }
                } else {
                    echo "Something went wrong!";
                }
            }
            return FALSE;
        }
        // if ($this->input->post()) {
        //     $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
        //     if ($this->form_validation->run() == FALSE) {
        //         $this->session->set_flashdata('errors', validation_errors());
        //     } else {
        //         $user_id = $this->session->userdata('user_id');
        //         $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
        //         date_default_timezone_set('Asia/Dhaka');
        //         $servertime = time();
        //         $now = date("d-m-Y", $servertime);
        //         $emp_division = $this->input->post('emp_division');
        //         $emp_attendance_start_date = $this->input->post('emp_attendance_start_date');
        //         $query = $emp_division;
        //         $params_contents = array(
        //             'id' => '',
        //             'search_query' => $query,
        //             'user_id' => $user_id,
        //             'table_view' => $emp_attendance_start_date,
        //             'per_page' => "",
        //             'search_page' => $searchpage,
        //             'search_date' => $now,
        //         );
        //         $this->db->insert("search_query", $params_contents);
        //     }
        // }

        // $division_vid = 1;
        // $user_type = $this->session->userdata('user_type');
        // $user_id = $this->session->userdata('user_id');
        // $user_data = $this->users_model->getuserbyid($user_id);
        // $user_division_id = $user_data['user_division'];
        // $data['user_info'] = $this->users_model->getuserbyid($user_id);
        // $data['user_type_id'] = $this->session->userdata('user_type');
        // if ($user_type != 1) {
        //     $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);
        //     $data['allemployee'] = $this->search_field_emp_model->getallemployeebydivision($user_division_id);
        // } else {
        //     $data['allemployee'] = $this->search_field_emp_model->getallemployee();
        //     $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        // }

        // $default_division_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        // $division_id = $default_division_id['search_query'];
        // $emp_att_date = $default_division_id['table_view'];
        // $data['defaultdivision_id'] = $default_division_id['search_query'];
        // $data['default_date'] = $default_division_id['table_view'];
        // if ($division_id == 'all') {
        //     $data['default_employee'] = $this->emp_leave_model->getemp_spentleavebydate($emp_att_date);
        // } else if ($division_id) {
        //     $today_leaved_emp = $this->emp_leave_model->getemp_spentleavebydate($emp_att_date);
        //     $leaved_emp_ids = "";
        //     $counter_emp = 1;
        //     foreach ($today_leaved_emp as $single_emp) {
        //         if ($single_emp['content_id'] && $counter_emp == 1) {
        //             $leaved_emp_ids .= $single_emp['content_id'];
        //         } else if ($single_emp['content_id']) {
        //             $leaved_emp_ids .= "," . $single_emp['content_id'];
        //         }
        //         $counter_emp++;
        //     }
        //     $data['default_employee'] = $this->search_field_emp_model->getallemployeebydivisionandids($division_id, $leaved_emp_ids);
        // }
        $data['companies'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=1 and status=1")->result();
        $this->load->view('reports/leave/daily_leave_report', $data);
    }

    public function singleLeaveReport()
    {
        $this->check_permission_controller->check_permission_action("view_single_leave_reports");
        $searchpage = "daily_leave_report";
        if ($this->input->post()) {
            #dd($this->input->post());
            $this->form_validation->set_rules('content_id', 'Employee', 'required');
            $this->form_validation->set_rules('leave_date_from', 'Date From', 'required');
            $this->form_validation->set_rules('leave_date_to', 'Date To', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                $content_id = $this->input->post('content_id');
                $leave_date_from = date('d-m-Y', strtotime($this->input->post('leave_date_from')));
                $leave_date_to = date('d-m-Y', strtotime($this->input->post('leave_date_to')));
                $year = date('Y');
                $previous_carry_forward_leave_balance = 0;
                $current_year_total_leave = 0;
                $previous_carry_forward_leave_balance = $this->emp_leave_model->getPreviousCarryForwardLeaveBalance($year, $content_id);
                $current_year_total_leave = $this->emp_leave_model->getCurrentYearTotalLeave($year, $content_id);
                #dd($previous_carry_forward_leave_balance,1);
                
                if ($content_id && $leave_date_from && $leave_date_to) {
                    $employeeInfo = $this->db->query("SELECT sfe.emp_name,sfe.emp_id,
                    company.name as company_name,
                    division.name as division_name,
                    department.name as department_name
                    FROM search_field_emp as sfe
                    LEFT JOIN taxonomy as company ON company.id=sfe.emp_division 
                    LEFT JOIN taxonomy as division ON division.id=sfe.emp_department 
                    LEFT JOIN taxonomy as department ON department.id=sfe.department_id 
                    WHERE SFE.content_id='$content_id' ")->row();
                    $dailyLeaveData = $this->db->query("SELECT 
                    EL.*,SFE.emp_name,SFE.emp_id,
                    division.name as division_name,
                    leave_type.name as leave_type_name 
                    FROM emp_leave as EL
                    LEFT JOIN search_field_emp as SFE ON SFE.content_id=EL.content_id 
                    LEFT JOIN taxonomy as division ON division.id=SFE.emp_department 
                    LEFT JOIN taxonomy as leave_type ON leave_type.id=EL.leave_type 
                    WHERE SFE.content_id='$content_id'
                    AND STR_TO_DATE(EL.leave_start_date,'%d-%m-%Y') BETWEEN STR_TO_DATE('$leave_date_from','%d-%m-%Y') AND  STR_TO_DATE('$leave_date_to','%d-%m-%Y')
                    ORDER BY SFE.emp_name");



                    if ($dailyLeaveData->num_rows() > 0) {
                        
                        #dd($dailyLeaveData->result());
                        $html = '
                    <table id="table2excel" class="table2excel_with_colors table table-striped custom-table mb-0">
                    <thead>';
                        $html .= '<tr>
                        <th colspan="6" style="text-align:center;font-size:20px;background-color:#CCC">Single Leave Report</th>
                    </tr>';
                        $html .= '<tr>
                    <th>Employee Name:</th>
                    <th >' . $employeeInfo->emp_name . '</th>
                    <th style="text-align:right">Company Name: </th>
                    <th >' . $employeeInfo->company_name . '</th>
                    
                </tr>';
                        $html .= '<tr>
                    <th>Department Name:</th>
                    <th >' . $employeeInfo->department_name . '</th>
                    <th style="text-align:right">Branch/ Division Name: </th>
                    <th >' . $employeeInfo->division_name . '</th>
                    
                </tr>';
                        $html .= '<tr>
                    <th>SL NO</th>
                    <th>Leave Date</th>
                    <th>Leave Type</th>
                    <th>Remarks</th>
                </tr>';
                        $html .= '</thead>
                    <tbody>'; 
                        $totalLeave = 0;
                        
                        foreach ($dailyLeaveData->result() as $key => $val) :
                            $html .=
                                '<tr><td>' . ($key + 1) .
                                '</td><td>' . $val->leave_start_date .
                                '</td><td>' . $val->leave_type_name .
                                '</td><td>' . $val->remarks .
                                '</td></tr>';
                            $totalLeave++;
                        endforeach;
                        
                        $html .= '<tfoot>
                            <tr><td colspan="4"><strong>
                            Previous Year Earn Leave Balance:' . $previous_carry_forward_leave_balance . ', 
                            This Year Total Leave: ' . $current_year_total_leave . ', 
                            This Year Leave Availed: ' . $totalLeave . ', 
                            This Year Available: ' . ($current_year_total_leave - $totalLeave) . '</strong></td></tr>
                        </tfoot>';
                        $html .= '</tbody></table>';
                        
                        echo $html;
                    } else {
                        echo "No data found.";
                    }
                } else {
                    echo "Something went wrong!";
                }
            }
            return FALSE;
        }
        $data['employees'] = $this->db->query("SELECT * FROM search_field_emp")->result();
        $this->load->view('reports/leave/single_leave_report', $data);
    }

    public function leaveSummeryReport(){
        $this->check_permission_controller->check_permission_action("view_leave_summery_reports");
        $searchpage = "leavesummeryreport";
        if ($this->input->post()) {
            $this->form_validation->set_rules('emp_name[]', 'Name', 'required');
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                $user_id = $this->session->userdata('user_id');
                $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
                date_default_timezone_set('Asia/Dhaka');
                $servertime = time();
                $now = date("d-m-Y", $servertime);
                $emp_division = $this->input->post('emp_division');
                $emp_attendance_start_date = $this->input->post('emp_attendance_start_date');
                $codes = $this->input->post('emp_name');
                $emp_codes_string = rtrim(implode(',', $codes), ',');
                $query = $emp_division;
                $params_contents = array(
                    'id' => '',
                    'search_query' => $query,
                    'user_id' => $user_id,
                    'table_view' => $emp_attendance_start_date,
                    'per_page' => $emp_codes_string,
                    'search_page' => $searchpage,
                    'search_date' => $now,
                );
                $this->db->insert("search_query", $params_contents);
            }
        }
        $default_division_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $division_id = $default_division_id['search_query'];
        $emp_att_date = $default_division_id['table_view'];
        $data['defaultdivision_id'] = $default_division_id['search_query'];
        $data['defaultstart_date'] = $default_division_id['table_view'];
        $data['default_date'] = $default_division_id['table_view'];
        $emp_codes_query = $default_division_id['per_page'];
        $data['emp_codes'] = explode(",", $emp_codes_query);
        if ($division_id == 'all') {
            $data['defsultdivision_name'] = "All";
            $data['defsultdivision_shortname'] = "All";
            $data['default_employee'] = $this->search_field_emp_model->getallemployeeorderdivision();
        } else if ($division_id) {
            $emp_division = $this->taxonomy->getTaxonomyBytid($division_id);
            $data['defsultdivision_name'] = $emp_division['name'];
            $data['defsultdivision_shortname'] = $emp_division['keywords'];
            $data['default_employee'] = $this->search_field_emp_model->getallemployeebydivision($division_id);
        }
        $division_vid = 1;
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $user_data = $this->users_model->getuserbyid($user_id);
        $user_division_id = $user_data['user_division'];
        $data['user_info'] = $this->users_model->getuserbyid($user_id);
        $data['user_type_id'] = $this->session->userdata('user_type');
        if ($user_id == 14) {
            $data['allemployee'] = $this->search_field_emp_model->getall_left_employee();
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);
        } else if ($user_type != 1) {
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);
            // $data['allemployee']=$this->search_field_emp_model->getallemployeebydivision($user_division_id);
            $emp_ids_data = $this->users_model->getpermittedemployee($user_id);
            $content_ids = $emp_ids_data['emp_content_ids'];
            $data['allemployee'] = $this->search_field_emp_model->getallsearch_table_contentByids($content_ids);
        } else {
            $data['allemployee'] = $this->search_field_emp_model->getallemployee();
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        }
        $this->load->view('reports/leave/leave_summery_report', $data);
    }
}
