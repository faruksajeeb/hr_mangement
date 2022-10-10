<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AttendanceReportController extends CI_Controller
{

    function __construct()
    {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->library("pdf");
        // ini_set('max_execution_time', 30000);
    }

    public function myAttendance(){
        $dateFrom = $this->input->post('date_from');
        //echo $dateFrom;
        $dateTo = $this->input->post('date_to');
        if($this->input->post()){
            if($dateFrom && $dateTo){
                $html = '';
                $html .= '<table class="table table-sm table-bordered">';
                $html .= '<thead>';
                $html .= '<tr>';
                    $html .= '<th>Attendance Date</th>';
                    $html .= '<th>In Time</th>';
                    $html .= '<th>Out Time</th>';
                    $html .= '<th>Remarks</th>';
                    $dateRange = dateRange($dateFrom, $dateTo);
                    $contentId =  $this->session->userdata('content_id');
                    foreach($dateRange as $date):
                        if(date('Y-m-d') < date('Y-m-d',strtotime($date)))
                        continue;
                        $result = $this->employeeDailyAttendanceStatus($contentId, $date);
                        $html .= '</tr>';
                        $html .= '<tr>';
                        $html .= '<td>'.$date.'</td>';
                        $html .= '<td>'.$result["login"].'</td>';
                        $html .= '<td>'.$result["logout"].'</td>';
                        $html .= '<td>'.$result["remarks"].'</td>';
                        $html .= '</tr>';
                    endforeach;
                $html .= '</thead>';
                $html .= '</table>';
                echo $html;
                return false;
            }
        }
        
        $this->load->view('attendance/my_attendance');
    }

    function getCompanyWiseBranch()
    {
        $company_info = explode('|', $this->input->get('company_id'));
        $company_id = $company_info[0];
        $company_name = $company_info[1];
        $getBraches = $this->db->query("SELECT * FROM taxonomy WHERE vid=2 AND parents_term='$company_id' AND status=1 ")->result();
        #dd($getBraches);
        $result = '<option value="all|All Division">All</option>';
        foreach ($getBraches as $key => $val) :
            $result .= '<option value="' . $val->id . '|' . $val->name . '">' . $val->name . '</option>';
        endforeach;
        echo $result;
    }
    function dailyPresentReport()
    {
        $data['companies'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=1 AND status=1")->result();
        $this->load->view('reports/attendance/daily_present_report', $data);
    }
    function getDailyPresentReport()
    {
        $company_info = explode('|', $this->input->get('company_id'));
        $company_id = $company_info[0];
        $company_name = $company_info[1];
        $division_info = explode('|', $this->input->get('division_id'));
        $division_id = $division_info[0];
        $division_name = $division_info[1];
        $attendance_date = date('d-m-Y', strtotime($this->input->get('attendance_date')));
        #dd($attendance_date);
        if ($company_id && $division_id && $attendance_date) {
            $daily_present_data = $this->db->query("
            SELECT DISTINCT A.content_id,A.attendance_date,
            A.login_time,A.logout_time,SFE.emp_name,SFE.emp_id 
            FROM emp_attendance A
                LEFT JOIN search_field_emp SFE ON SFE.content_id=A.content_id 
                WHERE A.attendance_date='$attendance_date' GROUP BY A.content_id");
            if ($daily_present_data->num_rows() > 0) {
                $html = '
                <table class="table table-striped custom-table mb-0">
           <thead>';
                $html .= '<tr>
                   <th>Company Name:</th>
                   <th colspan="2">' . $company_name . '</th>
                   <th>Branch/ Division Name: </th>
                   <th colspan="2">' . $division_name . '</th>
               </tr>';
                $html .= '<tr>
                   <th>SL NO</th>
                   <th>Date</th>
                   <th>Employee Name</th>
                   <th>Employee ID</th>
                   <th>Check In <i class="fas fa-arrows-alt-h"></i> Check Out</th>
                   <th>Remarks</th>
               </tr>';
                $html .= '</thead>
           <tbody>';
                foreach ($daily_present_data->result() as $key => $val) :
                    $html .= '<tr><td>' . ($key + 1) . '</td><td>' . $val->attendance_date . '</td><td>' . $val->emp_name . '</td><td>' . $val->emp_id . '</td><td>' . $val->login_time . ' <i class="fas fa-arrows-alt-h"></i> ' . $val->logout_time . '</td><td>-</td></tr>';
                endforeach;
                $html .= '</tbody></table>';
                echo $html;
            } else {
                echo "no_data_found";
            }
        }
    }

    function dailyAbsentReport()
    {
        $data['companies'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=1 AND status=1")->result();
        $this->load->view('reports/attendance/daily_absent_report', $data);
    }

    function getDailyAbsentReport()
    {
        $company_info = explode('|', $this->input->get('company_id'));
        $company_id = $company_info[0];
        $company_name = $company_info[1];
        $division_info = explode('|', $this->input->get('division_id'));
        $division_id = $division_info[0];
        $division_name = $division_info[1];
        $attendance_date = date('d-m-Y', strtotime($this->input->get('attendance_date')));
        #dd($attendance_date);
        if ($company_id && $division_id && $attendance_date) {
            $daily_absent_data = $this->db->query("
            SELECT emp_name, emp_id FROM search_field_emp WHERE content_id NOT IN(
            SELECT DISTINCT content_id
            FROM emp_attendance 
            WHERE attendance_date = '$attendance_date' GROUP BY content_id) 
            AND type_of_employee IN(1,155) 
            ORDER BY emp_name
            ");

            if ($daily_absent_data->num_rows() > 0) {
                $html = '
                <table class="table table-striped custom-table mb-0">
           <thead>';
                $html .= '<tr>
                   <th>Company Name:</th>
                   <th colspan="2">' . $company_name . '</th>
                   <th>Branch/ Division Name: </th>
                   <th colspan="2">' . $division_name . '</th>
               </tr>';
                $html .= '<tr>
                   <th>SL NO</th>
                   <th>Date</th>
                   <th>Employee Name</th>
                   <th>Employee ID</th>
                   <th>Remarks</th>
               </tr>';
                $html .= '</thead>
           <tbody>';
                foreach ($daily_absent_data->result() as $key => $val) :
                    // Check Vacation/ Tour
                    $vacationTourExist = $this->db->query("");
                    if ($vacationTourExist->row_nums() > 0) {
                        $remarks = "On Vacation";
                        #continue;
                    }
                    // Check Leave
                    $leaveExist = $this->db->query("SELECT * FROM emp_leave WHERE leave_start_date <= '$attendance_date' AND leave_end_date >= '$attendance_date' AND content_id=$val->content_id ");
                    dd($this->db->last_query());
                    if ($leaveExist->row_nums() > 0) {
                        $remarks = "Leave";
                        continue;
                    }
                    // Check Daily Movement
                    $dailyMovementExist = $this->db->query("");
                    if ($dailyMovementExist->row_nums() > 0) {
                        $remarks = "Daily Movement";
                        #continue;
                    }

                    $html .= '<tr>
                    <td>' . ($key + 1) . '</td>
                    <td>' . $attendance_date . '</td>
                    <td>' . $val->emp_name . '</td>
                    <td>' . $val->emp_id . '</td>
                    <td>' . $remarks . '</td>
                    </tr>';
                endforeach;
                $html .= '</tbody></table>';
                echo $html;
            } else {
                echo "no_data_found";
            }
        }
    }

    function dailyAttendanceReport()
    {
        $data['companies'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=1 AND status=1")->result();
        $this->load->view('reports/attendance/daily_attendance_report', $data);
    }

    function getDailyAttendanceReport()
    {

        $data['companies'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=1 AND status=1")->result();
        $this->load->view('reports/attendance/daily_attendance_report', $data);
        $company_info = explode('|', $this->input->get('company_id'));
        $company_id = $company_info[0];
        $company_name = $company_info[1];
        $division_info = explode('|', $this->input->get('division_id'));
        $division_id = $division_info[0];
        $division_name = $division_info[1];
        $attendance_date = date('d-m-Y', strtotime($this->input->get('attendance_date')));
        $report_type = $this->input->get('report_type');
        #dd($attendance_date);
        if ($company_id && $division_id && $attendance_date) {
            $divisionCondition = '';
            $divisionCondition2 = '';
            if ($division_id != 'all') {
                $divisionCondition = "AND emp_department='$division_id'";
                $divisionCondition2 = "AND SFE.emp_department='$division_id'";
            }
            if ('attendance' == $report_type) {

                $daily_attendance_data = $this->db->query("SELECT 
                emp_name, emp_id,content_id,emp_division as emp_company,emp_department as emp_division 
                FROM search_field_emp                 
                WHERE type_of_employee IN(1,155/*provision*/,863/*contactual*/,154/*on vacation*/) 
                AND emp_division='$company_id' 
                $divisionCondition  
                ORDER BY emp_name
                ");
                if ($daily_attendance_data->num_rows() > 0) {
                    $html = '
                <table id="table2excel" class="table2excel_with_colors table table-striped custom-table mb-0 ">
                <thead>';
                    $html .= '<tr>
                <th colspan="7" style="text-align:center;font-size:20px;background-color:#CCC">Daily Attendance Report</th>
                        </tr>';
                    $html .= '<tr>
                        <th>Company Name:</th>
                        <th >' . $company_name . '</th>
                        <th style="text-align:right">Branch/ Division Name: </th>
                        <th >' . $division_name . '</th>
                        <th >Report Type: ' . ucfirst($report_type) . '</th>
                        <th >Date: ' . $attendance_date . '</th>
                    </tr>';
                    $html .= '<tr>
                   <th>SL NO</th>
                   <th>Employee Name</th>
                   <th>Employee ID</th>';
                    // $html .= '<th>Late Count Time</th>';
                    // $html .= '<th>Early Count Time</th>';
                    $html .= '<th>Check In <i class="fas fa-arrows-alt-h"></i> Check Out</th>
                   
                   <th style="text-align:center">Att.</th>
                   <th style="text-align:center">Remarks</th>
                     </tr>';
                    $html .= '</thead>
                 <tbody>';
                    #dd($daily_absent_data->result());
                    foreach ($daily_attendance_data->result() as $key => $val) :
                        $login_time = '';
                        $logout_time = '';
                        $remarks = "<font color='red'>A</font>";
                        $result = $this->employeeDailyAttendanceStatus($val->content_id, $attendance_date);
                        $html .= '<tr><td>' . ($key + 1) . '</td>
                        <td>' . $val->emp_name . '</td>
                        <td>' . $val->emp_id . '</td>';
                        // $html .= '<td>' . $result['late_count_time'] . '</td>';
                        // $html .= '<td>' . $result['early_count_time'] . '</td>';
                        $html .= '<td>' . $result['login'] . ' <i class="fas fa-arrows-alt-h"></i> ' . $result['logout'] . '</td>
                        <td style="text-align:center;font-weight:bold">' . $result['status'] . '</td>
                        <td style="text-align:center;font-weight:bold">' . $result['remarks'] . '</td>
                        </tr>';
                    endforeach;
                    $html .= '</tbody></table>';
                    echo $html;
                } else {
                    echo "no_data_found";
                }
            } elseif ('present' == $report_type) {
                $daily_present_data = $this->db->query("SELECT DISTINCT A.content_id,A.attendance_date,
                    A.login_time,A.logout_time,SFE.emp_name,SFE.emp_id 
                    FROM emp_attendance A
                LEFT JOIN search_field_emp SFE ON SFE.content_id=A.content_id 
                WHERE A.attendance_date='$attendance_date' 
                AND SFE.emp_division='$company_id' 
                $divisionCondition2 
                GROUP BY A.content_id");
                #dd($this->db->last_query());
                if ($daily_present_data->num_rows() > 0) {
                    $html = '
                    <table id="table2excel" class="table2excel_with_colors table table-striped custom-table mb-0">
                    <thead>';
                    $html .= '<tr>
                        <th colspan="6" style="text-align:center;font-size:20px;background-color:#CCC">Daily Present Report</th>
                    </tr>';
                    $html .= '<tr>
                    <th>Company Name:</th>
                    <th >' . $company_name . '</th>
                    <th style="text-align:right">Branch/ Division Name: </th>
                    <th >' . $division_name . '</th>
                    <th style="text-align:right">Report Type: </th>
                    <th >' . ucfirst($report_type) . '</th>
                </tr>';
                    $html .= '<tr>
                    <th>SL NO</th>
                    <th>Date</th>
                    <th>Employee Name</th>
                    <th>Employee ID</th>
                    <th>Check In <i class="fas fa-arrows-alt-h"></i> Check Out</th>
                    <th>Remarks</th>
                </tr>';
                    $html .= '</thead>
                    <tbody>';
                    foreach ($daily_present_data->result() as $key => $val) :
                        $html .= '<tr><td>' . ($key + 1) . '</td><td>' . $val->attendance_date . '</td><td>' . $val->emp_name . '</td><td>' . $val->emp_id . '</td>
                        <td>' . $val->login_time . ' <i class="fas fa-arrows-alt-h"></i> ' . $val->logout_time . '</td><td>P</td></tr>';
                    endforeach;
                    $html .= '</tbody></table>';
                    echo $html;
                } else {
                    echo "no_data_found";
                }
            } elseif ('absent' == $report_type) {
                $daily_absent_data = $this->db->query("SELECT 
                emp_name, emp_id,content_id,emp_division as emp_company,emp_department as emp_division 
                FROM search_field_emp 
                WHERE content_id NOT IN(
                SELECT DISTINCT content_id
                FROM emp_attendance 
                WHERE 
                attendance_date = '$attendance_date' 
                GROUP BY content_id) 
                AND type_of_employee IN(1,155/*provision*/,863/*contactual*/,154/*on vacation*/) 
                AND emp_division='$company_id' 
                $divisionCondition  
                ORDER BY emp_name
                ");
                if ($daily_absent_data->num_rows() > 0) {
                    $html = '
                <table id="table2excel" class="table2excel_with_colors table  table-striped custom-table mb-0">
                <thead>';
                    $html .= '<tr>
                <th colspan="6" style="text-align:center;font-size:20px;background-color:#CCC">Daily Absent Report</th>
                        </tr>';
                    $html .= '<tr>
                        <th>Company Name:</th>
                        <th >' . $company_name . '</th>
                        <th style="text-align:right">Branch/ Division Name: </th>
                        <th >' . $division_name . '</th>
                        <th >Report Type:' . ucfirst($report_type) . '</th>
                    </tr>';
                    $html .= '<tr>
                   <th>SL NO</th>
                   <th>Date</th>
                   <th>Employee Name</th>
                   <th>Employee ID</th>
                   <th style="text-align:center">Remarks</th>
                     </tr>';
                    $html .= '</thead>
                 <tbody>';
                    #dd($daily_absent_data->result());
                    foreach ($daily_absent_data->result() as $key => $val) :
                        $remarks = "<font color='red'>A</font>";
                        $result = $this->employeeDailyAttendanceStatus($val->content_id, $attendance_date);
                        if ($result['status'] != 'A') {
                            continue;
                        }
                        $html .= '<tr><td>' . ($key + 1) . '</td>
                        <td>' . $attendance_date . '</td>
                        <td>' . $val->emp_name . '</td>
                        <td>' . $val->emp_id . '</td>
                        <td style="text-align:center;font-weight:bold">' . $result['status'] . '</td>
                        </tr>';
                    endforeach;
                    $html .= '</tbody></table>';
                    echo $html;
                } else {
                    echo "no_data_found";
                }
            } elseif ('late' == $report_type) {
                $daily_late_data = $this->db->query("SELECT DISTINCT A.content_id,A.attendance_date,
                    A.login_time,A.logout_time,SFE.emp_name,SFE.emp_id,
                    SHIFT_HISTORY.emp_latecount_time,SHIFT_HISTORY.emp_earlycount_time
                    FROM emp_attendance A
                    LEFT JOIN search_field_emp SFE ON SFE.content_id=A.content_id 
                    LEFT JOIN emp_shift_history SHIFT_HISTORY 
                    ON SHIFT_HISTORY.content_id=A.content_id 
                    AND STR_TO_DATE(SHIFT_HISTORY.start_date,'%d-%m-%Y') <= STR_TO_DATE('$attendance_date','%d-%m-%Y')
                    AND ((SHIFT_HISTORY.end_date='') OR (STR_TO_DATE(SHIFT_HISTORY.end_date,'%d-%m-%Y') >= STR_TO_DATE('$attendance_date','%d-%m-%Y')))
                    WHERE 
                    A.attendance_date='$attendance_date' 
                    AND SFE.emp_division='$company_id' 
                    $divisionCondition2 
                    GROUP BY A.content_id");
                if ($daily_late_data->num_rows() > 0) {
                    $html = '
                    <table id="table2excel" class="table2excel_with_colors table table-striped custom-table mb-0">
                    <thead>';
                    $html .= '<tr>
                        <th colspan="8" style="text-align:center;font-size:20px;background-color:#CCC">Daily Late Report</th>
                    </tr>';
                    $html .= '<tr>
                    <th>Company Name:</th>
                    <th colspan="2">' . $company_name . '</th>
                    <th style="text-align:right">Branch/ Division Name: </th>
                    <th  colspan="2">' . $division_name . '</th>
                    <th style="text-align:right">Report Type: </th>
                    <th >' . ucfirst($report_type) . '</th>
                    </tr>';
                    $html .= '<tr>
                    <th>SL NO</th>
                    <th>Date</th>
                    <th>Employee Name</th>
                    <th>Employee ID</th>
                    <th>Late Count Time</th>
                    <th>Early Count Time</th>
                    <th>Check In <i class="fas fa-arrows-alt-h"></i> Check Out</th>
                    <th>Remarks</th>
                    </tr>';
                    $html .= '</thead>
                    <tbody>';
                    foreach ($daily_late_data->result() as $key => $val) :
                        $remarks = "";
                        $result = $this->employeeDailyAttendanceStatus($val->content_id, $attendance_date);
                        if ($result['status'] != 'L') {
                            continue;
                        }
                        $html .= '<tr>
                        <td>' . ($key + 1) . '</td>
                        <td>' . $val->attendance_date . '</td>
                        <td>' . $val->emp_name . '</td>
                        <td>' . $val->emp_id . '</td>
                        <td>' . $val->emp_latecount_time . '</td>
                        <td>' . $val->emp_earlycount_time . '</td>
                        <td>' . $val->login_time . ' <i class="fas fa-arrows-alt-h"></i> ' . $val->logout_time . '</td>
                        <td>' . $result['status'] . '</td>
                        </tr>';
                    endforeach;
                    $html .= '</tbody></table>';
                    echo $html;
                } else {
                    echo "no_data_found";
                }
            } elseif ('early' == $report_type) {
                $daily_late_data = $this->db->query("SELECT DISTINCT A.content_id,A.attendance_date,
                    A.login_time,A.logout_time,SFE.emp_name,SFE.emp_id,
                    SHIFT_HISTORY.emp_latecount_time,SHIFT_HISTORY.emp_earlycount_time
                    FROM emp_attendance A
                    LEFT JOIN search_field_emp SFE ON SFE.content_id=A.content_id 
                    LEFT JOIN emp_shift_history SHIFT_HISTORY 
                    ON SHIFT_HISTORY.content_id=A.content_id 
                    AND STR_TO_DATE(SHIFT_HISTORY.start_date,'%d-%m-%Y') <= STR_TO_DATE('$attendance_date','%d-%m-%Y')
                    AND ((SHIFT_HISTORY.end_date='') OR (STR_TO_DATE(SHIFT_HISTORY.end_date,'%d-%m-%Y') >= STR_TO_DATE('$attendance_date','%d-%m-%Y')))
                    WHERE 
                    A.attendance_date='$attendance_date' 
                    AND SFE.emp_division='$company_id' 
                    $divisionCondition2 
                    GROUP BY A.content_id");
                if ($daily_late_data->num_rows() > 0) {
                    $html = '
                    <table id="table2excel" class="table2excel_with_colors table table-striped custom-table mb-0">
                    <thead>';
                    $html .= '<tr>
                        <th colspan="8" style="text-align:center;font-size:20px;background-color:#CCC">Daily Early Report</th>
                    </tr>';
                    $html .= '<tr>
                    <th>Company Name:</th>
                    <th colspan="2">' . $company_name . '</th>
                    <th style="text-align:right">Branch/ Division Name: </th>
                    <th  colspan="2">' . $division_name . '</th>
                    <th style="text-align:right">Report Type: </th>
                    <th >' . ucfirst($report_type) . '</th>
                    </tr>';
                    $html .= '<tr>
                    <th>SL NO</th>
                    <th>Date</th>
                    <th>Employee Name</th>
                    <th>Employee ID</th>
                    <th>Late Count Time</th>
                    <th>Early Count Time</th>
                    <th>Check In <i class="fas fa-arrows-alt-h"></i> Check Out</th>
                    <th>Remarks</th>
                    </tr>';
                    $html .= '</thead>
                    <tbody>';
                    foreach ($daily_late_data->result() as $key => $val) :
                        $remarks = "";
                        $result = $this->employeeDailyAttendanceStatus($val->content_id, $attendance_date);
                        if ($result['status'] != 'E') {
                            continue;
                        }
                        $html .= '<tr>
                        <td>' . ($key + 1) . '</td>
                        <td>' . $val->attendance_date . '</td>
                        <td>' . $val->emp_name . '</td>
                        <td>' . $val->emp_id . '</td>
                        <td>' . $val->emp_latecount_time . '</td>
                        <td>' . $val->emp_earlycount_time . '</td>
                        <td>' . $val->login_time . ' <i class="fas fa-arrows-alt-h"></i> ' . $val->logout_time . '</td>
                        <td>' . $result['status'] . '</td>
                        </tr>';
                    endforeach;
                    $html .= '</tbody></table>';
                    echo $html;
                } else {
                    echo "no_data_found";
                }
            }
        }
        exit;
    }

    function monthlyAttendanceReport()
    {
        $this->check_permission_controller->check_permission_action("view_monthly_attendance");
        if ($postData = $this->input->post()) {
            $contentId = $postData['content_id'];
            $startDate = $postData['start_date'];
            $endDate = $postData['end_date'];
            $reportType = $postData['report_type'];
            $empInfo = $this->db->query("SELECT 
            SFE.*,DESIGNATION.name as Designation, 
            COMPANY.name as CompanyName,DIVISION.name as DivisionName,
            SHIFT.emp_latecount_time,SHIFT.emp_earlycount_time,SHIFT.attendance_required
            FROM search_field_emp SFE 
            LEFT JOIN taxonomy DESIGNATION ON DESIGNATION.tid=SFE.emp_post_id
            LEFT JOIN taxonomy COMPANY ON COMPANY.tid=SFE.emp_division
            LEFT JOIN taxonomy DIVISION ON DIVISION.tid=SFE.emp_department
            LEFT JOIN emp_shift_history SHIFT ON 
            (SHIFT.content_id=SFE.content_id 
            AND STR_TO_DATE(`start_date`,'%d-%m-%Y') <= STR_TO_DATE('$startDate','%d-%m-%Y') 
            AND ((`end_date`='') OR (STR_TO_DATE(`end_date`,'%d-%m-%Y') >= STR_TO_DATE('$endDate','%d-%m-%Y'))))
            WHERE SFE.content_id=$contentId ")->row();

            $html = "";
            $html .= '<table border="1" style="width:100%;margin:10px 0" >';
            $html .= "
                <style>
                .text-start{
                    text-align:left!important;
                }
                td{
                    text-align:center!important;
                    padding:5px;
                }
                </style>
                    <thead>
                        <tr>
                            <th class='text-start'> \t Employee ID:</th>
                            <th class='text-start'> \t " . $empInfo->emp_id . "</th>
                            <th class='text-start'> \t Company:</th>
                            <th class='text-start'> \t " . $empInfo->CompanyName . "</th>
                            <th class='text-start'> \t Late Count Time:</th>
                            <th class='text-start'> \t " . $empInfo->emp_latecount_time . "</th>
                           
                            </tr>
                        <tr>
                            <th class='text-start'> \t Employee Name:</th>
                            <th class='text-start'> \t " . $empInfo->emp_name . "</th>                            
                            <th class='text-start'> \t Division</th>
                            <th class='text-start'> \t " . $empInfo->DivisionName . "</th>
                            <th class='text-start'> \t Early Count Time</th>
                            <th class='text-start'> \t " . $empInfo->emp_earlycount_time . "</th>
                            
                            </tr>
                        <tr>
                            <th class='text-start'> \t Designation:</th>
                            <th class='text-start'> \t " . $empInfo->Designation . "</th>
                            <th class='text-start'> \t Joining Date:</th>
                            <th class='text-start'> \t " . $empInfo->joining_date . "</th>
                            <th class='text-start'> \t Attendance Required:</th>
                            <th class='text-start'> \t " . $empInfo->attendance_required . "</th>
                            
                            </tr>
                        <tr style='background-color:#CCC'>
                            <th>Date</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Working Time</th>
                            <th>Att.</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    
                
            ";
            $html .= '<tbody>';
            $date_range = dateRange($startDate, $endDate);
            $totalPresent=
            $totalLeave=
            $totalLate=
            $totalEarly=
            $totalLateEarly=
            $totalAbsent=
            $dailyMovement=
            $attendanceException=0;
            $totalHours=0;
            $totalMinutes=0;
            foreach ($date_range as $date) :
                if(date('Y-m-d') < date('Y-m-d',strtotime($date)))
                    continue;
                $result = $this->employeeDailyAttendanceStatus($contentId, $date);
                $status = $result["status"];
                if($reportType!='attendance'){
                    if(($reportType=='present') && ($status != 'P')){
                        continue;
                    }elseif(($reportType=='absent') && ($status != 'A')){
                        continue;
                    }elseif(($reportType=='late') && ($status != 'L')){
                        continue;
                    }elseif(($reportType=='early') && ($status != 'E')){
                        continue;
                    }elseif(($reportType=='late_n_early') && ($status != 'L.E')){
                        continue;
                    }elseif(($reportType=='attendance_exception') && ($status != 'A.E')){
                        continue;
                    }
                }
                $login = $result['login'];
                $logout = $result['logout'];
                $weeklyHolidayColor = ($result["status"]=='W.H')?'background-color:#e6ffe6':'';
                $bgColor = ($result["status"]=='A')?'background-color:#ffb3b3':(($result["status"]=='L' || $result["status"]=='E' || $result["status"]=='L.E')?'background-color:#ffff1a':'');
                $fontColor = ($result["status"]=='A' || $result["status"]=='L' || $result["status"]=='E' || $result["status"]=='L.E')?'color:red':'';
                $workingDuration = $this->timeDiff("$date $login","$date $logout");
                $totalHours += $workingDuration['hours'];
                $totalMinutes += $workingDuration['minutes'];
                $html .= '<tr style="'.$weeklyHolidayColor.'">
                <td>' . date('d-M-Y', strtotime($date)) . '</td>
                <td>' . $login . '</td>
                <td>' . $logout . '</td>
                <td>' . $workingDuration['diff'].'</td>
                <td style="'.$bgColor.'">' . $result['status'] . '</td>
                <td style="'.$fontColor.'">' . $result['remarks'] . '</td>
            </tr>';
            if($result['status']=='Y.L'){
                $totalLeave++;
            }elseif($result['status']=='A'){
                $totalAbsent++;
            }elseif($result['status']=='D.M'){
                $dailyMovement++;
            }elseif($result['status']=='A.E'){
                $attendanceException++;
            }
            elseif($result['status']=='P'){
                $totalPresent++;
            }
            elseif($result['status']=='L'){
                $totalLate++;
            }
            elseif($result['status']=='E'){
                $totalEarly++;
            }
            elseif($result['status']=='L.E'){
                $totalLateEarly++;
            }
            endforeach;
            $extraHours = floor($totalMinutes/60);
           // $extraHours =$totalMinutes/60;
            $totalMinutes = $totalMinutes % 60;
            // dd($extraHours);
            $html .='<tr><td colspan="3"></td><td>Total Working Time: '.($totalHours+$extraHours).':'.$totalMinutes.' hours</td><td colspan="2"></td></tr>';
            $summary = 'Total Late:'.$totalLate.', Total Early:'.$totalEarly.', Total Late & Early:'.$totalLateEarly.', Total Leave:'.$totalLeave.', Total Absent:'.$totalAbsent.',  Attendance Exception:'.$attendanceException.', Daily Movement:'.$dailyMovement;
            $html .= '<tfoot><tr style="font-weight:bold"><td colspan="6">'.$summary.'</td></tr></tfoot>';
            $html .= '</tbody>';
            $html .= '</table>';
            echo $html;
            return false;
        }
        $data['employees'] = $this->db->query("SELECT 
        SFE.*,T.name as Designation 
        FROM search_field_emp SFE 
        LEFT JOIN taxonomy T ON T.tid=SFE.emp_post_id 
        ORDER BY SFE.grade ASC")->result();
        $this->load->view('reports/attendance/monthly_attendance_report', $data);
    }
    function timeDiff($firstTime, $lastTime)
    {

        // convert to unix timestamps
        $firstTime = strtotime($firstTime);
        $lastTime = strtotime($lastTime);

        // perform subtraction to get the difference (in seconds) between times
        $difference = $lastTime - $firstTime;
        $years = abs(floor($difference / 31536000));
        $days = abs(floor(($difference-($years * 31536000))/86400));
        $hours = abs(floor(($difference-($years * 31536000)-($days * 86400))/3600));
        $mins = abs(floor(($difference-($years * 31536000)-($days * 86400)-($hours * 3600))/60));#floor($difference / 60);
        // return the difference
        #$timeDiff = $years . " Years, " . $days . " Days, " . $hours . " Hours, " . $mins . " Minutes.</p>";
        
        $timeDiff = $hours . " Hours, " . $mins . " Minutes";
        if($years==0 && $days==0 && $hours==0 && $mins==0){
            $timeDiff='';
        }
        $data = array(
            'hours' => $hours,
            'minutes' => $mins,
            'diff' => $timeDiff,
        );
        return $data;
    }
  

    function monthlyAttendanceSummaryReport()
    {
        $data['companies'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=1 /*AND status=1*/")->result();

        if ($this->input->post()) {
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            $this->form_validation->set_rules('emp_attendance_end_date', 'Attendance End Date', 'required');
            $this->form_validation->set_rules('emp_division', 'Division Field', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
                $this->load->view('reports/attendance/monthly_attendance_summary_report', $data);
            } else {
                $postData = $this->input->post();
                $data['start_date'] = $postData['emp_attendance_start_date'];
                $data['end_date'] = $postData['emp_attendance_end_date'];
                $datee = date_create($data['end_date']);
                $data['nowbigmonth'] = date_format($datee, 'F Y');
                $empCompany = $postData['emp_division'];
                $empDivision = $postData['emp_department'];
                $employees = $this->db->query("SELECT 
                SFE.*,T.name as Designation 
                FROM search_field_emp SFE 
                LEFT JOIN taxonomy T ON T.tid=SFE.emp_post_id 
                WHERE SFE.emp_division=$empCompany AND 
                SFE.emp_department=$empDivision 
                ORDER BY ABS(SFE.grade)/*CAST(SFE.grade as unsigned)*/ ASC")->result();
                $data['date_range'] = dateRange($data['start_date'], $data['end_date']);
                $companyName = $this->db->query("SELECT name as companyName FROM taxonomy WHERE tid=$empCompany")->row('companyName');
                $divisionName = $this->db->query("SELECT name as divisionName FROM taxonomy WHERE tid=$empDivision")->row('divisionName');
                $data['company_name'] = $companyName;
                $data['division_name'] = $divisionName;
                foreach ($employees as $empVal) :
                    $typeOfEmployee = $empVal->type_of_employee;
                    // If employee join after attendance end date please skip this employee ----                       
                    if (strtotime($empVal->joining_date) >= strtotime($data['end_date'])) {
                        continue; // skip this employee and goes back to first -->
                    }
                    // Check Employee left or Terminated ------------
                    if ($typeOfEmployee == 153 || $typeOfEmployee == 473) {
                        // get last job history
                        $getLeftHistory = $this->db->query("SELECT * FROM emp_job_history WHERE content_id=$empVal->content_id AND emp_type_tid IN('153','473') ORDER BY id DESC LIMIT 1")->row();
                        if ($getLeftHistory) {
                            $left_or_termineted_date = $getLeftHistory->start_date;
                        }
                        if ($left_or_termineted_date) {
                            if (strtotime($data['start_date']) >= strtotime($left_or_termineted_date)) {
                                continue;
                            }
                        }
                    }
                    $totalPresent =
                        $totalLate =
                        $totalEarly =
                        $totalLeave =
                        $totalHoliday =
                        $totalDailyMovement =
                        $totalAttendanceException =
                        $totalANR =
                        $totalAbsent = 0;
                    foreach ($data['date_range'] as $attendanceDate) {
                        // If attendance date is >= graterthan or equal to left or terminate date break the date
                        if ($typeOfEmployee == 153 || $typeOfEmployee == 473) {
                            if ($left_or_termineted_date) {
                                if (strtotime($attendanceDate) >= strtotime($left_or_termineted_date)) {
                                    break;
                                }
                            }
                        }

                        $attResult = $this->employeeDailyAttendanceStatus($empVal->content_id, $attendanceDate);
                        switch ($attResult['status']) {
                            case 'P':
                                $totalPresent++;
                                break;
                            case 'A':
                                $totalAbsent++;
                                break;
                            case 'H':
                                $totalHoliday++;
                                break;
                            case 'Y.L':
                                $totalLeave++;
                                break;
                            case 'D.M':
                                $totalDailyMovement++;
                                break;
                            case 'A.E':
                                $totalAttendanceException++;
                                break;
                            case 'A.N.R':
                                $totalANR++;
                                break;
                            default:
                        }
                    }
                    $empMonthlyAttendanceSummary[] = array(
                        'employee_id' => $empVal->emp_id,
                        'employee_name' => $empVal->emp_name,
                        'emp_designation' => $empVal->Designation,
                        'emp_grade' => $empVal->grade,
                        'total_present' => $totalPresent,
                        'total_absent' => $totalAbsent,
                        'total_holiday' => $totalHoliday,
                        'total_leave' => $totalLeave,
                        'total_late' => $totalLate,
                        'total_early' => $totalEarly,
                        'total_daily_movement' => $totalDailyMovement,
                        'total_attendance_exception' => $totalAttendanceException,
                        'total_attendance_not_required' => $totalANR,
                    );
                endforeach;
                $reportFormat = $this->input->post('report_format');
                if ($reportFormat == 'excel') {
                    $this->attendanceSummaryExportToExcel($data, $empMonthlyAttendanceSummary);
                } elseif ($reportFormat == 'pdf') {
                    $mpdf = $this->pdf->load();
                    $data['records'] = $empMonthlyAttendanceSummary;
                    $html = $this->load->view('print/printmonthlyattendancesummerypdf', $data, true);
                    #$mpdf->SetVisibility('printonly'); // This will be my code; 
                    //$mpdf->SetProtection(array('copy','print','modify'), 'r', '58');
                    #$mpdf->SetJS('this.print();');
                    $mpdf->WriteHTML(utf8_encode($html));
                    $mpdf->Output();
                    #$this->attendanceSummaryExportToPDF($data, $empMonthlyAttendanceSummary);
                }
            }
        }
        $this->load->view('reports/attendance/monthly_attendance_summary_report', $data);
    }

    function attendanceSummaryExportToExcel($data, $empMonthlyAttendanceSummary)
    {
        // Create a new Spreadsheet (Object) 
        // $spreadsheet = new Spreadsheet();

        // Printer setup ----------------------------------

        /* Loading a Workbook from a file */
        $inputFileName = './resources/files/attendance-summary-report.xlsx';
        /** Load $inputFileName to a Spreadsheet object * */
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
        $spreadsheet->getActiveSheet()->getPageSetup()
            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);

        $spreadsheet->getProperties()
            ->setCreator("HR Software")
            ->setLastModifiedBy("")
            ->setTitle("Attendance Summary Report")
            ->setSubject($data['division_name'] . "(Attendance Summary)")
            ->setDescription(
                "Summary report for employee attendance, generated by IIDFC Securities Limited HR Software."
            )
            ->setKeywords("attendance")
            ->setCategory("Report");

        // Rename worksheet
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Attendance Summary");
        // Set default row height
        //  $sheet->getDefaultRowDimension()->setRowHeight(50);
        $sheet->getPageSetup()
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->getPageMargins()->setTop(0.75);
        $sheet->getPageMargins()->setRight(0.25);
        $sheet->getPageMargins()->setLeft(0.25);
        $sheet->getPageMargins()->setBottom(0.75);
        $sheet->getPageSetup()->setHorizontalCentered(true);
        $sheet->getPageSetup()->setVerticalCentered(false);
        // $spreadsheet->getActiveSheet()->getHeaderFooter()
        //        ->setOddHeader('&C&HPlease treat this document as confidential!');
        $sheet->getHeaderFooter()
            ->setOddFooter('&L&B' . $spreadsheet->getProperties()->getTitle() . '&RPage &P of &N');
        // end printer setup ------------------------------
        // Print image
        // $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        // $drawing->setName('Logo');
        // $drawing->setDescription('Logo');
        // $drawing->setPath('./resources/images/logo.png');
        // $drawing->setCoordinates('A1');
        // $drawing->setHeight(100); // image height
        // $drawing->setOffsetX(10); //margin left
        // $drawing->setOffsetY(10); // margin top
        // $drawing->setRotation(0); // image rotaion
        // $drawing->getShadow()->setVisible(true); // image shadow
        // $drawing->getShadow()->setDirection(45);
        // $drawing->setWorksheet($sheet);
        $datee = date_create($data['end_date']);
        $nowbigmonth = date_format($datee, 'F Y');
        $sheet->setCellValue('A9', $nowbigmonth);
        $sheet->setCellValue('c11', $data['company_name']);
        $sheet->setCellValue('c12', $data['division_name']);

        $sheet->setCellValue('H11', $data['start_date']);
        $sheet->setCellValue('H12', $data['end_date']);

        $servertime = time();
        $now = date("d-m-Y H:i:s", $servertime);
        $row = 14;
        $no = 1;
        $totalEmployee = sizeof($empMonthlyAttendanceSummary);

        $sheet->insertNewRowBefore(15, $totalEmployee);

        $counter = 1;
        #dd($empMonthlyAttendanceSummary);
        foreach ($empMonthlyAttendanceSummary as $val) :
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $val['employee_id']);
            $sheet->setCellValue('C' . $row, $val['employee_name']);
            //$sheet->getCell('C' . $row)->getHyperlink()->setUrl('http://bdclbd.com/reports/monthlyattendancereports');
            // set wrap text
            $sheet->getStyle('C' . $row)->getAlignment()->setWrapText(true);
            $sheet->setCellValue('D' . $row, $val['emp_designation']);
            $sheet->setCellValue('E' . $row, $val['total_late']);
            $sheet->setCellValue('F' . $row, $val['total_early']);
            $sheet->setCellValue('G' . $row, $val['total_leave']);
            $sheet->setCellValue('H' . $row, $val['total_absent']);
            $sheet->setCellValue('I' . $row, $val['total_attendance_not_required'] > 0 ? 'Attendance Not Required' : '');
            $sheet->getStyle('I' . $row)->getAlignment()->setWrapText(true);
            $row++;
            $no++;
        endforeach;
        $row = $row + 6;

        $sheet->setCellValue('A' . $row, "Report generated by HR Software at " . $now);
        $sheet->getStyle('A' . $row)->getFont()->setItalic(TRUE);
        $sheet->getStyle('A' . $row)->getFont()->setSize(6);


        $writer = new Xlsx($spreadsheet);
        $now = date("d-m-Y_H:i:s", $servertime);
        $filename = 'attendance-summmary-report-of-' . str_replace(' ', '-', $data['defsultdivision_name'] . "-" . $nowbigmonth) . "-" . $now;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output'); // download file 
        die();
    }

    function employeeDailyAttendanceStatus($content_id, $attendance_date)
    {
        //get emp info by content id
        $empInfo = $this->db->query("SELECT emp_id,emp_name,emp_division as emp_company,emp_department as emp_division FROM search_field_emp WHERE content_id=$content_id ")->row();
        $empCompany = $empInfo->emp_company;
        $empDivision = $empInfo->emp_division;
        $result = array(
            'login' => '',
            'logout' => '',
            'status' => 'A',
            'remarks' => 'Absent'
        );

        // check holiday
        $holidayExist = $this->db->query("SELECT H.*,taxonomy.name 
        FROM emp_yearlyholiday H 
        LEFT JOIN taxonomy ON taxonomy.ID=H.holiday_type WHERE 
        ((H.holiday_for_division='all') 
        OR ((H.holiday_for_division='$empCompany') AND (H.holiday_for_department=''))
        OR ((H.holiday_for_division='$empCompany') AND (H.holiday_for_department='$empDivision'))) AND STR_TO_DATE(H.holiday_start_date,'%d-%m-%Y') <= STR_TO_DATE('$attendance_date','%d-%m-%Y') AND STR_TO_DATE(H.holiday_end_date,'%d-%m-%Y') >= STR_TO_DATE('$attendance_date','%d-%m-%Y')")->row();
        if ($holidayExist) {
            $remarks = $holidayExist->name;
            $result['status'] = 'H';
            $result['remarks'] = $remarks;
            return $result;
            #continue;
        }

        // Check Leave
        $leaveExist = $this->db->query("SELECT * FROM emp_leave 
        WHERE STR_TO_DATE(`leave_start_date`,'%d-%m-%Y') <= STR_TO_DATE('$attendance_date','%d-%m-%Y') AND STR_TO_DATE(`leave_end_date`,'%d-%m-%Y') >= STR_TO_DATE('$attendance_date','%d-%m-%Y') AND content_id=$content_id ");
        //dd($leaveExist->num_rows());
        if ($leaveExist->num_rows() > 0) {
            $remarks = "Leave";
            $result['status'] = 'Y.L';
            $result['remarks'] = $remarks;
            return $result;
            //continue;
        }

        // Check Vacation/ Tour
        $vacationTourExist = $this->db->query("SELECT * FROM emp_job_history 
        WHERE STR_TO_DATE(`start_date`,'%d-%m-%Y') <= STR_TO_DATE('$attendance_date','%d-%m-%Y') AND ((`end_date`='') OR (STR_TO_DATE(`end_date`,'%d-%m-%Y') >= STR_TO_DATE('$attendance_date','%d-%m-%Y'))) AND content_id=$content_id AND emp_type_tid='154' ");
        if ($vacationTourExist->num_rows() > 0) {
            $remarks = "On Vacation";
            $result['status'] = 'O.V';
            $result['remarks'] = $remarks;
            return $result;
            #continue;
        }

        $empShiftInfo = $this->db->query("SELECT * FROM emp_shift_history 
        WHERE content_id=$content_id 
        AND STR_TO_DATE(`start_date`,'%d-%m-%Y') <= STR_TO_DATE('$attendance_date','%d-%m-%Y') 
        AND ((`end_date`='') OR (STR_TO_DATE(`end_date`,'%d-%m-%Y') >= STR_TO_DATE('$attendance_date','%d-%m-%Y')))")->row();
       
        if ($empShiftInfo) {
            $empLateCountTime = $empShiftInfo->emp_latecount_time;
            $empEarlyCountTime = $empShiftInfo->emp_earlycount_time;
            $attendanceRequired = $empShiftInfo->attendance_required; //Required, Not_Required, Optional 
        }

        //check Employee Log Exception
        $formattedAttDate = date('Y-m-d', strtotime($attendance_date));
        $logExceptionAttendence = $this->db->query("SELECT * FROM log_maintenence WHERE company_id='$empCompany' AND division_id=$empDivision AND content_id=$content_id AND `start_date` <= '$formattedAttDate' AND `end_date` >= '$formattedAttDate' ")->row();

        //if employee not check Divsion Log Exception        
        if (!$logExceptionAttendence) {
            $logExceptionAttendence = $this->db->query("SELECT * FROM log_maintenence WHERE company_id='$empCompany' AND division_id=$empDivision AND content_id IS NULL AND `start_date` <= '$formattedAttDate' AND `end_date` >= '$formattedAttDate' ")->row();
        }

        //if division not check company Log Exception
        if (!$logExceptionAttendence) {
            $logExceptionAttendence = $this->db->query("SELECT * FROM log_maintenence WHERE company_id='$empCompany' AND division_id IS NULL AND content_id IS NULL AND `start_date` <= '$formattedAttDate' AND `end_date` >= '$formattedAttDate' ")->row();
        }
        // if division not check all
        if (!$logExceptionAttendence) {
            $logExceptionAttendence = $this->db->query("SELECT * FROM log_maintenence WHERE company_id='all' AND division_id IS NULL AND content_id IS NULL AND `start_date` <= '$formattedAttDate' AND `end_date` >= '$formattedAttDate' ")->row();
        }
        $logWeeklyHoliDay = '';

        // dd($this->db->last_query(),1);
        // dd($logExceptionAttendence);
        if ($logExceptionAttendence) {

            if ($logExceptionAttendence->late_status == 'Late_Count_Time') {
                $empLateCountTime = $logExceptionAttendence->late_count_time;
            } elseif ($logExceptionAttendence->late_status == 'Late_Not_Count') {
                $attendanceRequired = 'Not_Required';
            }
            if ($logExceptionAttendence->early_status == 'Early_Count_Time') {
                $empEarlyCountTime = $logExceptionAttendence->early_count_time;
            } elseif ($logExceptionAttendence->late_status == 'Early_Not_Count') {
                $attendanceRequired = 'Not_Required';
            }

            if ($logExceptionAttendence->present_status == 'P') {
                #$remarks = "P";
                $result['status'] = 'P';
                $result['remarks'] = 'Present';
            }
            $logWeeklyHoliDay = $logExceptionAttendence->weekly_holiday;
        }
        if($content_id == 34){ 
            // dd($empLateCountTime,1);
            // dd($empShiftInfo);
        }
       
        $result['late_count_time'] = $empLateCountTime;
        $result['early_count_time'] = $empEarlyCountTime;
        // ckeck weekly holiday
        $weeklyHoliday = $this->db->query("SELECT * 
        FROM emp_weeklyholiday_history 
        WHERE content_id=$content_id 
        AND STR_TO_DATE(`start_date`,'%d-%m-%Y') <= STR_TO_DATE('$attendance_date','%d-%m-%Y') 
        AND ((`end_date`='') OR (STR_TO_DATE(`end_date`,'%d-%m-%Y') >= STR_TO_DATE('$attendance_date','%d-%m-%Y')))")->row();
        #dd($this->db->last_query());
        $dayName = strtolower(date('D', strtotime($attendance_date)));
        $dayOff = $dayName . '_off';
        if ($weeklyHoliday && $weeklyHoliday->$dayOff === 'off' && $logWeeklyHoliDay != 'working_day') {
            $remarks = 'Weekly Holiday';
            $result['status'] = 'W.H';
            $result['remarks'] = $remarks;
            return $result;
        }

        $getAttendance = $this->db->query("SELECT * FROM emp_attendance WHERE content_id=$content_id AND STR_TO_DATE(attendance_date,'%d-%m-%Y') = STR_TO_DATE('$attendance_date','%d-%m-%Y')")->row();
        #dd($this->db->last_query());
        if ($getAttendance) {
            $login_time = $getAttendance->login_time;
            $logout_time = $getAttendance->logout_time;
            if ($attendanceRequired == 'Required') {
                
                if ($login_time && $empLateCountTime && $empEarlyCountTime && (strtotime($login_time) >= strtotime($empLateCountTime)) && (strtotime($logout_time) <= strtotime($empEarlyCountTime))) {
                    if (strtotime($attendance_date) < strtotime(date('d-m-Y'))) {
                        #$remarks = "Late & Early";
                        $result['login'] = $login_time;
                        $result['logout'] = $logout_time;
                        $result['late_count_time'] = $empLateCountTime;
                        $result['early_count_time'] = $empEarlyCountTime;
                        $result['status'] = 'L.E';
                        $result['remarks'] = 'Late & Early';
                    } else {
                        #$remarks = "Late";
                        $result['login'] = $login_time;
                        $result['logout'] = $logout_time;
                        $result['status'] = 'L';
                        $result['remarks'] = 'Late';
                    }
                } elseif ($login_time && $empLateCountTime && (strtotime($login_time) >= strtotime($empLateCountTime))) {
                    #$remarks = "Late";
                    $result['login'] = $login_time;
                    $result['logout'] = $logout_time;
                    $result['status'] = 'L';
                    $result['remarks'] = 'Late';
                } elseif ($empEarlyCountTime && (strtotime($logout_time) <= strtotime($empEarlyCountTime))) {
                    if (strtotime($attendance_date) < strtotime(date('d-m-Y'))) {
                        #$remarks = "Early";
                        $result['login'] = $login_time;
                        $result['logout'] = $logout_time;
                        $result['status'] = 'E';
                        $result['remarks'] = 'Early';
                    } else {
                        $result['login'] = $login_time;
                        $result['logout'] = $logout_time;
                        $result['status'] = '';
                        $result['remarks'] = '';
                    }
                } else {
                    #$remarks = "P";
                    $result['login'] = $login_time;
                    $result['logout'] = $logout_time;
                    $result['status'] = 'P';
                    $result['remarks'] = 'Present';
                }
            }elseif ($attendanceRequired == 'Not_Required') {
                #$remarks = "attendance_not_required";
                $result['login'] = $login_time;
                $result['logout'] = $logout_time;
                $result['status'] = 'A.N.R';
                $result['remarks'] = 'Attendance not required';
            }elseif ($attendanceRequired == 'Optional') {
                #$remarks = "Attendance optional";
                $result['login'] = $login_time;
                $result['logout'] = $logout_time;
                $result['status'] = 'A.O';
                $result['remarks'] = 'Attendance optional';
            }else{
                #$remarks = "Undefine";
                $result['login'] = $login_time;
                $result['logout'] = $logout_time;
                $result['status'] = 'UnDef.';
                $result['remarks'] = 'Undefine';
            }
        }

        #Check Daily Movement
        $dailyMovementExist = $this->db->query("SELECT * FROM emp_informed WHERE STR_TO_DATE(`attendance_date`,'%d-%m-%Y')=STR_TO_DATE('$attendance_date','%d-%m-%Y') AND content_id=$content_id AND second_approval=1 ");
        if ($dailyMovementExist->num_rows() > 0) {
            $dailyMovement = $dailyMovementExist->row();
            $remarks = "Daily Movement";
            $result['status'] = 'D.M';
            $result['remarks'] = 'Daily Movement ('.$dailyMovement->remarks.')';
            #continue;
        }

        # Check Attendance Exception
        $attedAttDate = date('Y-m-d', strtotime($attendance_date));
        $attendanceExceptionExist = $this->db->query("SELECT * FROM attendance_exceptions WHERE attendance_date = '$attedAttDate' AND content_id=$content_id AND status=1 ");
        if ($attendanceExceptionExist->num_rows() > 0) {
            $attendanceException = $attendanceExceptionExist->row();
            $remarks = "Attendance Exception";
            $result['status'] = 'A.E';
            $result['remarks'] = 'Attendance Exception ('.$attendanceException->exception_type.')';
            #continue;
        }
        return $result;
    }
}
