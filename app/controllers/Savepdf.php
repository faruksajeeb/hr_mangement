<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Savepdf extends CI_Controller
{

    function __construct()
    {
        error_reporting(0);
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->helper(array('form', 'url'));
        $this->load->library('pagination');
        $this->load->library("pdf");
    }

    function index()
    {
        redirect("savepdf/singleattendancereportspdf");
    }

    //mpdf function
    public function singleattendancereportspdf()
    {
        $searchpage = "monthlyattendancereports";
        $default_emp_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $content_id = $default_emp_id['search_query'];
        $emp_att_start_date = $default_emp_id['table_view'];
        $emp_att_end_date = $default_emp_id['per_page'];
        $data['defaultcontent_id'] = $default_emp_id['search_query'];
        $data['defaultstart_date'] = $default_emp_id['table_view'];
        $data['defaultend_date'] = $default_emp_id['per_page'];
        $data['default_emp'] = $this->search_field_emp_model->getallsearch_table_contentByid($default_emp_id['search_query']);
        $emp_details = $this->search_field_emp_model->getallsearch_table_contentByid($content_id);
        $data['emp_details_info'] = $this->search_field_emp_model->getallsearch_table_contentByid($content_id);
        $data['emp_working_time'] = $this->emp_working_time_model->getcontentByid($content_id);
        $data['emp_division'] = $this->taxonomy->getTaxonomyBytid($emp_details['emp_division']);
        $data['date_range'] = dateRange($emp_att_start_date, $emp_att_end_date);
        $data['emp_content_id'] = $content_id;
        $data['emp_attendance'] = $this->emp_attendance_model->getemp_attbyrange($content_id, $emp_att_start_date, $emp_att_end_date);
        $data['allemployee'] = $this->search_field_emp_model->getallemployee();
        $mpdf = $this->pdf->load();
        $html = $this->load->view('print/printsingleattendancepdf', $data, true);
        // $mpdf->SetProtection(array('print'), 'pass2open', 'pass2havefullaccess');
        $mpdf->SetVisibility('screenonly');
        #$mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetVisibility('hidden');
        // $mpdf->SetProtection(array('copy','print','modify'), 'r', 'MyPassword');
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output();
    }
    // multiple attentence print in pdf
    public function multipleattendancereportspdf()
    {
        if ($this->input->post()) {
            // $this->form_validation->set_rules('emp_name', 'Name', 'required');
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
                redirect('reports/monthlyattendancereportsmultiple');
            } else {
                $data['emp_codes'] = $this->input->post('emp_name');
                $emp_att_start_date = $this->input->post('emp_attendance_start_date');
                $emp_att_end_date = $this->input->post('emp_attendance_end_date');
                $data['date_range'] = dateRange($emp_att_start_date, $emp_att_end_date);
                $mpdf = $this->pdf->load();
                $html = $this->load->view('print/printmultipleattendancepdf', $data, true);
                #$mpdf->SetVisibility('printonly'); // This will be my code; 
                $mpdf->SetJS('this.print();');
                $mpdf->WriteHTML(utf8_encode($html));
                $mpdf->Output();
            }
        }
    }
    public function dailyattendancereportspdf()
    {
        $searchpage = "dailyattendancereports";
        $division_vid = 1;
        $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        $default_division_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $division_id = $default_division_id['search_query'];
        $emp_att_date = $default_division_id['table_view'];
        $data['defaultdivision_id'] = $default_division_id['search_query'];
        $data['default_date'] = $default_division_id['table_view'];
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
        $mpdf = $this->pdf->load();
        $html = $this->load->view('print/printdailyattendancepdf', $data, true);
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetProtection(array('copy','print','modify'), 'r', 'MyPassword');
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output();
    }
    public function dailylatereportspdf()
    {
        $searchpage = "dailylatereports";
        $division_vid = 1;
        $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        $default_division_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $division_id = $default_division_id['search_query'];
        $emp_att_date = $default_division_id['table_view'];
        $data['defaultdivision_id'] = $default_division_id['search_query'];
        $data['default_date'] = $default_division_id['table_view'];
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
        $mpdf = $this->pdf->load();
        $html = $this->load->view('print/printdailylatepdf', $data, true);
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetProtection(array('copy','print','modify'), 'r', 'MyPassword');
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output();
    }
    public function dailyabsentreportspdf()
    {
        $searchpage = "dailyabsentreports";
        $division_vid = 1;
        $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        $default_division_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $division_id = $default_division_id['search_query'];
        $emp_att_date = $default_division_id['table_view'];
        $data['defaultdivision_id'] = $default_division_id['search_query'];
        $data['default_date'] = $default_division_id['table_view'];
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
        $mpdf = $this->pdf->load();
        $html = $this->load->view('print/printdailyabsentpdf', $data, true);
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetProtection(array('copy','print','modify'), 'r', 'MyPassword');
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output();
    }
    public function dailyleavereportspdf()
    {
        $searchpage = "daily_leave_report";
        $division_vid = 1;
        $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        $default_division_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $division_id = $default_division_id['search_query'];
        $emp_att_date = $default_division_id['table_view'];
        $data['defaultdivision_id'] = $default_division_id['search_query'];
        $data['default_date'] = $default_division_id['table_view'];
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
        if ($division_id == 'all') {
            $data['defsultdivision_name'] = "All";
            $data['defsultdivision_shortname'] = "All";
            $data['default_employee'] = $this->emp_leave_model->getemp_spentleavebydate($emp_att_date);
        } else if ($division_id) {
            $emp_division = $this->taxonomy->getTaxonomyBytid($division_id);
            $data['defsultdivision_name'] = $emp_division['name'];
            $data['defsultdivision_shortname'] = $emp_division['keywords'];
            $today_leaved_emp = $this->emp_leave_model->getemp_spentleavebydate($emp_att_date);
            $leaved_emp_ids = "";
            $counter_emp = 1;
            foreach ($today_leaved_emp as $single_emp) {
                if ($single_emp['content_id'] && $counter_emp == 1) {
                    $leaved_emp_ids .= $single_emp['content_id'];
                } else if ($single_emp['content_id']) {
                    $leaved_emp_ids .= "," . $single_emp['content_id'];
                }
                $counter_emp++;
            }
            $data['default_employee'] = $this->search_field_emp_model->getallemployeebydivisionandids($division_id, $leaved_emp_ids);
        }
        $mpdf = $this->pdf->load();
        $html = $this->load->view('print/printdailyleavepdf', $data, true);
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetProtection(array('copy','print','modify'), 'r', 'MyPassword');
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output();
    }
    //jjj
    public function yearlyholidayreportspdf()
    {
        $searchpage = "holidayreports";
        $default_division_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $division_id = $default_division_id['search_query'];
        $holiday_year = $default_division_id['table_view'];
        $data['defaultdivision_id'] = $default_division_id['search_query'];
        $data['default_year'] = $default_division_id['table_view'];
        if ($division_id == "all") {
            $data['default_holidays'] = $this->emp_holiday_model->getemp_yearlyallholiday($holiday_year);
        } else {
            $data['default_holidays'] = $this->emp_holiday_model->getemp_yearlytotalholiday($division_id, $holiday_year);
        }
        $mpdf = $this->pdf->load();
        $html = $this->load->view('print/printyearlyholidaypdf', $data, true);
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetProtection(array('copy','print','modify'), 'r', 'MyPassword');
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output();
    }
    public function dailyearlyreportspdf()
    {
        $searchpage = "dailyearlyreports";
        $division_vid = 1;
        $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        $default_division_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $division_id = $default_division_id['search_query'];
        $emp_att_date = $default_division_id['table_view'];
        $data['defaultdivision_id'] = $default_division_id['search_query'];
        $data['default_date'] = $default_division_id['table_view'];
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
        $mpdf = $this->pdf->load();
        $html = $this->load->view('print/printdaily_earlypdf', $data, true);
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetProtection(array('copy','print','modify'), 'r', 'MyPassword');
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output();
    }
    function monthlySalaryStatementReport()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            $this->form_validation->set_rules('emp_attendance_end_date', 'Attendance End Date', 'required');
            $this->form_validation->set_rules('emp_division', 'Division Field', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
                redirect('salary/salaryStatement');
            } else {
                $emp_division = $this->input->post('emp_division');
                $emp_department = $this->input->post('emp_department');
                $emp_att_start_date = $this->input->post('emp_attendance_start_date');
                $emp_att_end_date = $this->input->post('emp_attendance_end_date');
                if (strtotime($emp_att_start_date) > strtotime($emp_att_end_date)) {
                    $this->session->set_flashdata('errors', "Date range invalid!");
                    redirect('salary/salaryStatement');
                }
                $data['defaultdivision_id'] = $emp_division;
                $data['defaultstart_date'] = $emp_att_start_date;
                $data['defaultend_date'] = $emp_att_end_date;
                $data['date_range'] = dateRange($emp_att_start_date, $emp_att_end_date);
                if ($emp_division == 'all') {
                    $data['defsultdivision_name'] = "All";
                    $data['defsultdivision_shortname'] = "All";
                    $data['default_employee'] = $this->search_field_emp_model->getallemployeeorderdivision();
                } else if ($emp_division) {
                    $emp_division_data = $this->taxonomy->getTaxonomyBytid($emp_division);
                    $data['defsultdivision_name'] = $emp_division_data['name'];
                    $data['defsultdivision_shortname'] = $emp_division_data['keywords'];
                    if ($emp_department != "") {
                        $emp_department_data = $this->taxonomy->getTaxonomyBytid($emp_department);
                        $data['department_name'] = $emp_department_data['name'];
                        $data['default_employee'] = $this->search_field_emp_model->getAllEmployeeByDivisionAndDepartment($emp_division, $emp_department);
                    } else {
                        $data['department_name'] = "";
                        $data['default_employee'] = $this->search_field_emp_model->getallemployeebydivision($emp_division);
                    }
                }
                $reportFormat = $this->input->post('report_format');
                if ($reportFormat == 'excel') {
                    // Create a new Spreadsheet (Object) 
                    // $spreadsheet = new Spreadsheet();

                    // Printer setup ----------------------------------

                    /* Loading a Workbook from a file */
                    $inputFileName = './resources/files/salary-statement.xlsx';
                    /** Load $inputFileName to a Spreadsheet object * */
                    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
                    $spreadsheet->getActiveSheet()->getPageSetup()
                        ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

                    $spreadsheet->getProperties()
                        ->setCreator("HR Software")
                        ->setLastModifiedBy("")
                        ->setTitle("Salary Statement Report")
                        ->setSubject($data['defsultdivision_name'] . "(Salary Statement)")
                        ->setDescription(
                            "Salary Statement report for employee, generated by IIDFC Securities Limited HR Software."
                        )
                        ->setKeywords("Salary Statement")
                        ->setCategory("Report");

                    // Rename worksheet
                    $sheet = $spreadsheet->getActiveSheet();
                    $sheet->setTitle("Salary Statement");
                    // Set default row height
                    //  $sheet->getDefaultRowDimension()->setRowHeight(50);
                    $sheet->getPageSetup()
                        ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

                    $sheet->getPageMargins()->setTop(0.50);
                    $sheet->getPageMargins()->setRight(0.25);
                    $sheet->getPageMargins()->setLeft(0.25);
                    $sheet->getPageMargins()->setBottom(0.50);
                    $sheet->getPageSetup()->setHorizontalCentered(true);
                    $sheet->getPageSetup()->setVerticalCentered(false);
                    // $spreadsheet->getActiveSheet()->getHeaderFooter()
                    //        ->setOddHeader('&C&HPlease treat this document as confidential!');
                    $sheet->getHeaderFooter()
                        ->setOddFooter('&L&B' . $spreadsheet->getProperties()->getTitle() . '&RPage &P of &N');
                    // end printer setup ------------------------------
                    // Print image
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $drawing->setName('Logo');
                    $drawing->setDescription('Logo');
                    $drawing->setPath('./resources/images/logo.png');
                    $drawing->setCoordinates('A1');
                    $drawing->setHeight(100); // image height
                    $drawing->setOffsetX(10); //margin left
                    $drawing->setOffsetY(10); // margin top
                    $drawing->setRotation(0); // image rotaion
                    $drawing->getShadow()->setVisible(true); // image shadow
                    $drawing->getShadow()->setDirection(45);
                    $drawing->setWorksheet($sheet);

                    $lastdateofattendance = end($data['date_range']);

                    $datee = date_create($lastdateofattendance);
                    $nowbigmonth = date_format($datee, 'F Y');
                    $getMonthVal = $sheet->getCell('A4')->getValue();
                    $sheet->setCellValue('A4', $getMonthVal . $nowbigmonth);
                    $sheet->setCellValue('A1', $data['defsultdivision_name']);
                    $sheet->setCellValue('A2', $data['department_name']);

                    // Start Loop
                    $servertime = time();
                    $now = date("d-m-Y H:i:s", $servertime);
                    $row = 9;
                    $no = 1;
                    $totalEmployee = sizeof($data['default_employee']);

                    $sheet->insertNewRowBefore(10, $totalEmployee);

                    $counter = 1;
                    foreach ($data['default_employee'] as $single_emp) {
                        $single_code = $single_emp['emp_id'];
                        $emp_content_id = $single_emp['content_id'];
                        $emp_name = $single_emp['emp_name'];
                        $emp_division_id = $single_emp['emp_division'];
                        $mobile_no = "";
                        if ($single_emp['mobile_no']) {
                            $mobile_no = "-" . $single_emp['mobile_no'];
                        }
                        $emp_division = $this->taxonomy->getTaxonomyBytid($emp_division_id);
                        $emp_post_id = $single_emp['emp_post_id'];
                        $emp_post_id_data = $this->taxonomy->getTaxonomyBytid($emp_post_id);
                        $emp_designation = $emp_post_id_data['name'];

                        $emp_department_id = $single_emp['emp_department'];

                        $late_counter = 0;
                        $early_counter = 0;
                        $absent_counter = 0;
                        $absent_halfday_counter = 0;
                        $leave_with_pay = 0;
                        $daily_movement = 0;
                        $leave_without_pay = 0;
                        $emp_division_shortname = $emp_division['keywords'];
                        $emp_joining_date = $single_emp['joining_date'];
                        $half_day_absent_status = "";
                        $early_status = "";
                        $late_status = "";
                        $today = date("d-m-Y", $servertime);
                        $left_or_termineted = $single_emp['type_of_employee'];
                        if ($left_or_termineted == 153 || $left_or_termineted == 473) {
                            $left_or_termineted_data = $this->emp_job_history_model->getemp_last_job_history($emp_content_id);
                            $left_or_termineted_date = $left_or_termineted_data['start_date'];
                        }
                        foreach ($data['date_range'] as $single_date) {
                            // Check Employee left or Terminated ------------
                            if ($left_or_termineted_date) {
                                if (strtotime($single_date) >= strtotime($left_or_termineted_date)) {
                                    break;
                                }
                            }
                            // Check joining date ----------------------------------------
                            if (strtotime($single_date) >= strtotime($emp_joining_date)) {
                                $empatt_start_date_arr = explode("-", $single_date);
                                $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
                                // Get employee shift history ----------------------------
                                $emp_shift_time = $this->db->query("select * from emp_shift_history WHERE content_id ='$emp_content_id' AND str_to_date(start_date, '%d-%m-%Y') <='$emp_att_start_date' ORDER BY ID DESC LIMIT 1")->row_array();
                                $attendance_required = $emp_shift_time['attendance_required'];
                                $work_starting_time = $emp_shift_time['work_starting_time'];
                                $work_ending_time = $emp_shift_time['work_ending_time'];
                                $logout_required = $emp_shift_time['logout_required'];
                                $year = date('Y', strtotime($single_date));
                                $empatt_start_date_arr = explode("-", $single_date);
                                $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
                                $emp_latecount_time = $emp_shift_time['emp_latecount_time'];
                                $emp_earlycount_time = $emp_shift_time['emp_earlycount_time'];
                                $half_day_absent = $emp_shift_time['half_day_absent'];
                                $absent_count_time = $emp_shift_time['absent_count_time'];
                                $overtime_count = $emp_shift_time['overtime_count'];

                                $tstamp1 = strtotime($single_date);
                                $dated_day_name1 = date("D", $tstamp1);
                                $dated_day_name1 = strtolower($dated_day_name1);
                                // Noor Medical Services Work ending time 4:00:00 PM -----------------
                                if ($emp_division_id == 301 && $dated_day_name1 == 'thu') {
                                    $work_ending_time = "16:00:00";
                                    $emp_earlycount_time = "16:00:00";
                                }
                                // Check Attendance log mantainance ----------------------------------------------------------------------------
                                $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,"
                                    . "half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status "
                                    . "FROM log_maintenence WHERE content_id=$emp_content_id and start_date='$single_date' "
                                    . "order by id DESC LIMIT 1")->row_array();
                                // check department log maintanence if employee log dosen't exist ----------------
                                if (!$has_log_attendance_error) {
                                    $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status FROM log_maintenence WHERE department_id=$emp_department_id and start_date='$single_date' order by id DESC LIMIT 1")->row_array();
                                }
                                // check division log maintanence if department & employee log dosen't  exist ----------------
                                if (!$has_log_attendance_error) {
                                    $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status FROM log_maintenence 
                                    WHERE division_id='$emp_division_id' and start_date='$single_date' order by id DESC LIMIT 1")->row_array();
                                }
                                $division = "all";
                                if (!$has_log_attendance_error) {
                                    $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status FROM log_maintenence 
                                    WHERE division_id='$division' and start_date='$single_date' order by id DESC LIMIT 1")->row_array();
                                }

                                // If log exist ------------------
                                if ($has_log_attendance_error) {
                                    $late_status = $has_log_attendance_error['late_status'];
                                    $log_weekly_holiday = $has_log_attendance_error['weekly_holiday'];
                                    $presence_status_has_no_log = $has_log_attendance_error['present_status'];
                                    if ($late_status == 'Late_Count_Time') {
                                        $emp_latecount_time = $has_log_attendance_error['late_count_time'];
                                    }
                                    $half_day_absent_status = $has_log_attendance_error['half_day_absent_status'];
                                    if ($half_day_absent_status == 'Half_Day_Absent_Count_Time') {
                                        $absent_count_time = $has_log_attendance_error['half_day_absent_count_time'];
                                    }
                                    $early_status = $has_log_attendance_error['early_status'];
                                    if ($early_status == 'Early_Count_Time') {
                                        $emp_earlycount_time = $has_log_attendance_error['early_count_time'];
                                    }
                                    $reason = $has_log_attendance_error['reason'];
                                }
                                // Attendance info from attendance table -------------------------------------------------
                                if (strtotime($single_date) <= strtotime('30-11-2018')) {
                                    // If before December, 2018 ----------------------------------------------------
                                    $attendance_info = $this->db->query("SELECT login_time,logout_time,remarks "
                                        . "FROM emp_attendance_old "
                                        . "WHERE content_id=$emp_content_id AND attendance_date='$single_date' "
                                        . "ORDER BY id DESC")->row_array();
                                } else {
                                    // If after November, 2018 ------------------------------------------------------
                                    $attendance_info = $this->db->query("SELECT login_time,logout_time,remarks "
                                        . "FROM emp_attendance "
                                        . "WHERE content_id=$emp_content_id AND attendance_date='$single_date' "
                                        . "ORDER BY id DESC")->row_array();
                                }
                                $login_time = $attendance_info['login_time'];
                                $logout_time = $attendance_info['logout_time'];
                                // Attendance informed info from informed table(such as  Daily movement ) --------------------------------------
                                $emp_informed_info = $this->db->query("SELECT presence_status,logout_status,reason,remarks FROM emp_informed WHERE content_id=$emp_content_id AND attendance_date='$single_date' AND second_approval=1 ORDER BY id DESC")->row_array();

                                // If holiday exist for employee division ----
                                $holiday_exist = $this->db->query("SELECT eyh.holiday_type,t.name as holiday_name "
                                    . "FROM emp_yearlyholiday eyh "
                                    . "LEFT JOIN taxonomy t ON t.tid=eyh.holiday_type "
                                    . "WHERE eyh.holiday_for_division='$emp_division_id' AND eyh.holiday_for_department='$emp_department_id' AND eyh.holiday_start_date='$single_date' "
                                    . "ORDER BY eyh.id DESC")->row_array();

                                if (!$holiday_exist) {
                                    // If holiday exist for employee company ----
                                    $holiday_exist = $this->db->query("SELECT eyh.holiday_type,t.name as holiday_name "
                                        . "FROM emp_yearlyholiday eyh "
                                        . "LEFT JOIN taxonomy t ON t.tid=eyh.holiday_type "
                                        . "WHERE eyh.holiday_for_division='$emp_division_id' AND (eyh.holiday_for_department = NULL OR eyh.holiday_for_department = '') AND eyh.holiday_start_date='$single_date' "
                                        . "ORDER BY eyh.id DESC")->row_array();
                                    //                    $holiday_exist = $this->emp_holiday_model->getemp_yearlyholiday($division, $single_date);
                                }
                                if (!$holiday_exist) {
                                    // If holiday exist for all company ----
                                    $holiday_exist = $this->db->query("SELECT eyh.holiday_type,t.name as holiday_name "
                                        . "FROM emp_yearlyholiday eyh "
                                        . "LEFT JOIN taxonomy t ON t.tid=eyh.holiday_type "
                                        . "WHERE eyh.holiday_for_division='$division' AND eyh.holiday_start_date='$single_date' "
                                        . "ORDER BY eyh.id DESC LIMIT 1")->row_array();
                                    //                $holiday_exist = $this->emp_holiday_model->getemp_yearlyholiday($division, $single_date);
                                }
                                if ($holiday_exist) {
                                    // If holiday ----
                                    $holiday_type_tid = $holiday_exist['holiday_type'];
                                    $holiday_name = $holiday_exist['holiday_name']; // this will be echoed
                                    $remarks = $holiday_exist['holiday_name'];
                                    $login_time = $attendance_info['login_time'];
                                    $logout_time = $attendance_info['logout_time'];
                                } else {
                                    $tstamp = strtotime($single_date);
                                    $dated_day_name = date("D", $tstamp);
                                    $dated_day_name = strtolower($dated_day_name);
                                    $empatt_start_date_arr = explode("-", $single_date);
                                    $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
                                    $offday_exist = $this->db->query("SELECT * FROM emp_weeklyholiday_history WHERE content_id='$emp_content_id' AND str_to_date(start_date, '%d-%m-%Y') <='$emp_att_start_date' ORDER BY id DESC LIMIT 1")->row_array();
                                    //                    $offday_exist = $this->emp_weeklyholiday_history_model->getemp_weeklyholiday_historybydate($emp_content_id, $single_date);
                                    //$offday_exist = $this->emp_holiday_model->getemp_holiday($emp_content_id);

                                    if ($offday_exist['' . $dated_day_name . '_off'] == 'off') {
                                        $weekly_holiday = "Weekly Holiday";
                                        $remarks = "Weekly Holiday";
                                        // If weekly holiday

                                    }
                                    if ($log_weekly_holiday == 'off_day') {
                                        if ($reason == "Weekly Holiday") {
                                            $remarks = $reason;
                                        } else if ($reason == "Official Holiday") {
                                            $holiday_name = "Official Holiday";
                                        }

                                        // If log holiday
                                    }

                                    if (($remarks != "Weekly Holiday") || ($log_weekly_holiday == 'working_day')) {
                                        //                        $leave_exist = $this->emp_leave_model->getemp_leave($emp_content_id, $single_date);
                                        //                        $leave_exist = $this->db->query("SELECT leave_type,justification FROM emp_leave WHERE content_id='$emp_content_id' AND leave_start_date='$single_date' ORDER BY id DESC")->row_array();
                                        $leave_exist = $this->db->query("SELECT el.leave_type,el.justification,t.name as leave_name "
                                            . "FROM emp_leave el "
                                            . "LEFT JOIN taxonomy t ON t.tid=el.leave_type "
                                            . "WHERE el.content_id='$emp_content_id' "
                                            . "AND el.leave_start_date='$single_date' AND approve_status='approved' ORDER BY el.id DESC")->row_array();

                                        if ($leave_exist) {
                                            // If Leave ------
                                            $leave_type = $leave_exist['leave_type'];
                                            $leave_reason = $leave_exist['leave_name'];
                                            if (!$leave_reason) {
                                                $leave_reason = "Leave";
                                            }
                                            if ($leave_type == '446') {
                                                $remarks = "Half Day Leave";
                                                $login_time = $attendance_info['login_time'];
                                                $logout_time = $attendance_info['logout_time'];
                                            } else if ($leave_type == '336') {
                                                $remarks = "leave_without_pay";
                                            } else {
                                                $remarks = "Leave";
                                            }
                                        } else {
                                            // If employee no leave ----------------------------
                                            // Check Attendance Informed Info(Such as :Daily Movement)-----------------------------
                                            $presence_status = "";
                                            $presence_status_informed = $emp_informed_info['presence_status'];
                                            $logout_status_informed = $emp_informed_info['logout_status'];
                                            $reason_informed = $emp_informed_info['reason'];
                                            $informed_remarks = $emp_informed_info['remarks'];
                                            if ($reason_informed != $informed_remarks) {
                                                $informed_remarks = $emp_informed_info['reason'] . " [<span style='font-size:8px;'>" . $emp_informed_info['remarks'] . "]</span>";
                                            }
                                            $login_time = $attendance_info['login_time'];
                                            $logout_time = $attendance_info['logout_time'];
                                            if ($half_day_absent == 'Eligible') {
                                                if ($half_day_absent_status == 'Half_Day_Absent_Not_Count') { // problem day
                                                    $remarks = $reason;
                                                } else if ($login_time && strtotime($login_time) > strtotime($absent_count_time)) {
                                                    if (!$logout_time) {
                                                        $half_absent_found = "Half Day Absent";
                                                        $remarks = "Half Day Absent";
                                                    } else if (strtotime($emp_earlycount_time) > strtotime($logout_time)) {
                                                        $half_absent_found = "Half Day Absent";
                                                        $remarks = "Half Day Absent";
                                                    } else {
                                                        $half_absent_found = "Half Day Absent";
                                                        $remarks = "Half Day Absent";
                                                    }
                                                } else if ($late_status == "Late_Not_Count") {
                                                    $remarks = $reason;
                                                } else if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                                    $emp_late_found = "Late";
                                                    $remarks = "Late";
                                                    $login_time = "<font color=red >" . $login_time . "</font>";
                                                } else {
                                                    $remarks = $attendance_info['remarks'];
                                                }
                                            } else {
                                                //echo $emp_latecount_time;
                                                if ($presence_status_informed) {
                                                    //---------------------------------------------------------------------------------------------------------------------------------------
                                                    $presence_status = $presence_status_informed;
                                                    $remarks = $informed_remarks;
                                                    if ($presence_status == 'A') {
                                                        $login_time = "";
                                                        $logout_time = "";
                                                    }
                                                } else if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                                    $emp_late_found = "Late";
                                                    $remarks = "Late";
                                                    // $login_time="<font color=red >".$login_time."</font>";
                                                } else {
                                                    $remarks = $attendance_info['remarks'];
                                                }
                                            }
                                        } // end of leave check condition
                                    }
                                }

                                // if not login but logout after 04:00 PM ....................................................
                                if (!$logout_time && $login_time && $login_time >= "16:00:00") {
                                    $logout_time = $login_time;
                                    $login_time = "";
                                }

                                // Counter Start ---------------------------------------------------------------Counter++ Start---------------------------------------------
                                if ($holiday_name) {
                                    // yearly holiday
                                } else if (($remarks == "Weekly Holiday") && ($log_weekly_holiday != 'working_day')) {
                                    // weekly holiday
                                } else if ($remarks == 'leave_without_pay') {
                                    $leave_without_pay++;
                                    $absent_counter++;
                                } else if ($remarks == 'Leave') {
                                    $leave_with_pay++;
                                } else if ($remarks == 'Half Day Leave') {
                                } else if ($attendance_required == 'Not_Required') {
                                } else if ($presence_status_informed) {
                                    $daily_movement++;
                                    if ($informed_remarks == 'personal') {
                                        $daily_movement_personal++;
                                    }
                                    if ($presence_status == 'A') {
                                        $absent_counter++;
                                    } else if ($presence_status == 'P' && $logout_status_informed == 'P') {
                                    } else if ($presence_status == 'P' && $logout_status_informed == 'E') {
                                        $early_counter++;
                                    } else if ($presence_status == 'L' && $logout_status_informed == 'E') {
                                        $late_counter++;
                                        $early_counter++;
                                    } else if ($presence_status == 'A.H') {
                                        $absent_halfday_counter++;
                                    } else if ($presence_status == 'L') {
                                        $late_counter++;
                                    } else if ($presence_status_informed == 'L') {
                                        $late_counter++;
                                    } else if ($logout_status_informed == 'E') {
                                        $early_counter++;
                                    }
                                } else if ($presence_status == 'A') {
                                    $absent_counter++;
                                } else if ($presence_status == 'P') {
                                } else if ($presence_status == 'A.H') {
                                    if (strtotime($single_date) == strtotime($today)) {
                                        // echo "P";
                                    } else {
                                        $absent_halfday_counter++;
                                    }
                                } else if ($presence_status == 'L') {
                                    $late_counter++;
                                } else if ($late_status == "Late_Not_Count" && $early_status == "Early_Not_Count") {
                                    if ($presence_status_has_no_log == "A" && !$login_time && !$logout_time) {
                                        $absent_counter++;
                                    } else if ($presence_status_has_no_log == "P") {
                                        //    echo "P";
                                    } else {
                                        // echo "P";
                                    }
                                } else if ($late_status == "Late_Count_Time" && $early_status == "Early_Count_Time") {
                                    if (
                                        $login_time && $logout_time && strtotime($login_time) >= strtotime($emp_latecount_time) &&
                                        strtotime($logout_time) <= strtotime($emp_earlycount_time)
                                    ) {
                                        $late_counter++;
                                        if (strtotime($single_date) == strtotime($today)) {
                                            // $late_counter++;
                                        } else {
                                            //$late_counter++;
                                            $early_counter++;
                                        }
                                    } else if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                        $late_counter++;
                                    } else if ($logout_time && strtotime($logout_time) <= strtotime($emp_earlycount_time)) {
                                        if (strtotime($single_date) == strtotime($today)) {
                                            //  echo "P";
                                        } else {
                                            $early_counter++;
                                        }
                                    } else if (!$login_time && !$logout_time) {
                                        $absent_counter++;
                                    } else {
                                        // echo "P";
                                    }
                                } else if ($late_status == "Late_Count_Time" && $early_status == "Early_Not_Count") {
                                    if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                        $late_counter++;
                                    } else if (!$login_time && !$logout_time) {
                                        $absent_counter++;
                                    } else {
                                        // echo "P";
                                    }
                                } else if ($late_status == "Late_Not_Count" && $early_status == "Early_Count_Time") {
                                    if (strtotime($logout_time) <= strtotime($emp_earlycount_time)) {
                                        if (strtotime($single_date) == strtotime($today)) {
                                            // echo "P";
                                        } else {
                                            $early_counter++;
                                        }
                                    } else if (!$login_time && !$logout_time) {
                                        $absent_counter++;
                                    } else {
                                        // echo "P";
                                    }
                                } else if (!$login_time && !$logout_time) {
                                    $attendance_log = $this->emp_attendance_model->getemp_attendance_log();
                                    $attendance_log_date = $attendance_log['attendance_date'];
                                    if (strtotime($single_date) > strtotime($attendance_log_date)) {
                                        // echo "NC";
                                    } else {
                                        $absent_counter++;
                                    }
                                } else if ($login_time && !$logout_time && $logout_required == "Required" && $half_day_absent == 'Eligible') {
                                    if (strtotime($single_date) == strtotime($today)) {
                                        // echo "P";
                                    } else {
                                        $absent_halfday_counter++;
                                    }
                                } else if ($login_time && !$logout_time && $logout_required == "Required") {
                                    if ($emp_late_found) {
                                        $late_counter++;
                                        if (strtotime($single_date) == strtotime($today)) {
                                        } else {
                                            $early_counter++;
                                        }
                                    } else {
                                        if (strtotime($single_date) == strtotime($today)) {
                                            //echo "p";
                                        } else {
                                            $early_counter++;
                                        }
                                    }
                                } else if ($login_time && !$logout_time && $logout_required == "Optional") {
                                    // echo "P";
                                } else if ($half_absent_found) {
                                    if (strtotime($single_date) == strtotime($today)) {
                                        // echo "P";
                                    } else {
                                        $absent_halfday_counter++;
                                    }
                                } else if ($emp_late_found) {
                                    if ($login_time && $logout_time && $logout_required == "Required" && strtotime($logout_time) <= strtotime($emp_earlycount_time)) {
                                        $late_counter++;
                                        if (strtotime($single_date) == strtotime($today)) {
                                        } else {
                                            $early_counter++;
                                        }
                                    } else {
                                        $late_counter++;
                                    }
                                } else if ($login_time && $logout_time && $logout_required == "Required") {
                                    if (strtotime($emp_earlycount_time) >= strtotime($logout_time)) {
                                        if (strtotime($single_date) == strtotime($today)) {
                                            // echo "p";
                                        } else {
                                            $early_counter++;
                                        }
                                    } else {
                                        if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                            $late_counter++;
                                        } else {
                                            //  echo "P";
                                        }
                                    }
                                } else {
                                    // echo "P";
                                }
                                // Start Over Time Count ------------------------------------------------------------------------------------------
                                /*
                                if ($defsultdivision_shortname == 'BCPL') {
                                    if (strtotime($logout_time) > strtotime($work_ending_time) || ($login_time && $logout_time && $division_id_emp == 20)) {
                                        // overtime count after 16 minutes for medisys
                                        // echo $working_time_today_total;
                                        if ($division_id_emp == 20) {
                                            $medisys_time = strtotime($work_ending_time);
                                            $endTime_medisys = date("H:i:s", strtotime('+16 minutes', $medisys_time));
                                            if (strtotime($logout_time) > strtotime($endTime_medisys)) {
                                                $emp_overtime_today = get_time_difference($endTime_medisys, $logout_time);

                                                if ($holiday_exist || $remarks == "Weekly Holiday") {

                                                    $emp_overtime_today = $working_time_today_total;
                                                } else if (!$emp_overtime_today) {
                                                    $emp_overtime_today = $working_time_today_total;
                                                }

                                                $b = explode(':', $emp_overtime_today);
                                                $ot1 = $b[0] * 3600 + $b[1] * 60 + $b[2];
                                                $ot3 = $ot3 + $ot1;

                                                //  echo $emp_overtime_today;
                                            } else if ($remarks == "Weekly Holiday" && $working_time_today_total) {
                                                $b = explode(':', $working_time_today_total);
                                                $ot1 = $b[0] * 3600 + $b[1] * 60 + $b[2];
                                                $ot3 = $ot3 + $ot1;
                                                //  echo $working_time_today_total;
                                            }
                                        } else {
                                            // for BEL over time
                                            // security guard er jonno daily -8 hours overtime and holiday wholeday holiday
                                            if ($post_id_emp == 57 || $post_id_emp == 58 || $post_id_emp == 59 || $post_id_emp == 60 || $post_id_emp == 117) {
                                                if (strtotime($login_time) && strtotime($logout_time)) {
                                                    $emp_overtime_today = get_time_difference($login_time, $logout_time);
                                                    $officetime = strtotime("-8 hours");
                                                    $timestamp = strtotime($emp_overtime_today);
                                                    if ($timestamp > $officetime) {
                                                        if ($holiday_exist || $remarks == 'Weekly Holiday') {
                                                            $timestamp = strtotime($emp_overtime_today);
                                                        } else {
                                                            $timestamp = strtotime($emp_overtime_today) - 60 * 60 * 8;
                                                        }

                                                        $timestamp = date("H:i:s", $timestamp);

                                                        if ($timestamp) {
                                                            $b = explode(':', $timestamp);
                                                            $ot1 = $b[0] * 3600 + $b[1] * 60 + $b[2];
                                                            $ot3 = $ot3 + $ot1;
                                                            //  echo $timestamp;
                                                        }
                                                    }
                                                }
                                            } else {
                                                // For BCPL & others...
                                                $for_all_time = strtotime($work_ending_time);
                                                //$endTime_for_all = date("H:i:s", strtotime('+20 minutes', $for_all_time));
                                                $endTime_for_all = date("H:i:s", strtotime('+00 minutes', $for_all_time));
                                                if (strtotime($logout_time) > strtotime($endTime_for_all)) {
                                                    $emp_overtime_today = get_time_difference($endTime_for_all, $logout_time);

                                                    if ($holiday_exist || $remarks == "Weekly Holiday") {
                                                        $emp_overtime_today = $working_time_today_total;
                                                    } else if (!$emp_overtime_today) {
                                                        $emp_overtime_today = $working_time_today_total;
                                                    }

                                                    $b = explode(':', $emp_overtime_today);
                                                    $ot1 = $b[0] * 3600 + $b[1] * 60 + $b[2];
                                                    $ot3 = $ot3 + $ot1;

                                                    // echo $emp_overtime_today;
                                                } else if ($remarks == "Weekly Holiday" && $working_time_today_total) {
                                                    $b = explode(':', $working_time_today_total);
                                                    $ot1 = $b[0] * 3600 + $b[1] * 60 + $b[2];
                                                    $ot3 = $ot3 + $ot1;
                                                    // echo $working_time_today_total;
                                                }


                                                // start for all overtime
                                                // $emp_overtime_today= get_time_difference($work_ending_time, $logout_time);
                                                // $b=explode(':',$emp_overtime_today);
                                                // $ot1=$b[0]*3600+$b[1]*60+$b[2];
                                                // $ot3=$ot3+$ot1;
                                                // echo $emp_overtime_today;
                                                // ends for all overtime
                                            }
                                        }
                                    }
                                }
                                */
                                // End Over Time Count -------------------------------------------------------------------------------------------

                                $login_time = "";
                                $logout_time = "";
                                $holiday_name = "";
                                $weekly_holiday = "";
                                $log_weekly_holiday = "";
                                $remarks = "";
                                $reason = "";
                                $half_absent_found = "";
                                $emp_late_found = "";
                                $late_status = "";
                                $early_status = "";
                                $holiday_exist = "";
                                if (strtotime($single_date) >= strtotime($today)) {
                                    break;
                                }
                                if ($left_or_termineted_date) {
                                    if (strtotime($single_date) >= strtotime($left_or_termineted_date)) {
                                        break;
                                    }
                                }
                            }
                        }
                        // excel row info here ----------
                        // set column width 
                        //  $sheet->getColumnDimension('A')->setWidth(12);
                        $sheet->setCellValue('A' . $row, $no);
                        $sheet->setCellValue('B' . $row, $single_emp['emp_name']);
                        $sheet->setCellValue('C' . $row, $single_emp['emp_id']);
                        $sheet->getCell('B' . $row)->getHyperlink()->setUrl('http://bdclbd.com/reports/monthlyattendancereports');
                        // set wrap text
                        $sheet->getStyle('B' . $row)->getAlignment()->setWrapText(true);
                        $sheet->setCellValue('D' . $row, $emp_designation);
                        $sheet->setCellValue('E' . $row, $absent_counter);
                        //$sheet->setCellValue('E' . $row, $late_counter);
                        $sheet->setCellValue('F' . $row, "");
                        $basicSalary = ($single_emp['gross_salary'] * 50) / 100;
                        $sheet->setCellValue('G' . $row, $basicSalary);
                        $sheet->setCellValue('H' . $row, $basicSalary * 60 / 100); //House 60%
                        $sheet->setCellValue('I' . $row, $basicSalary * 20 / 100); //Medical 20%
                        $sheet->setCellValue('J' . $row, $basicSalary * 10 / 100); // Transport 10%
                        $sheet->setCellValue('K' . $row, $basicSalary * 10 / 100); // Others 10%
                        $sheet->setCellValue('L' . $row, $single_emp['gross_salary']);
                        $mobileBill = 0;
                        $arearBonus = 0;
                        $oT = 0;
                        $festivalBonus = 0;

                        $sheet->setCellValue('M' . $row, $mobileBill); //Mobile Bill
                        $sheet->setCellValue('N' . $row, $arearBonus); //Arear/ Bonus
                        $sheet->setCellValue('O' . $row, $oT); //O/T Taka
                        $sheet->setCellValue('P' . $row, $festivalBonus); //Festival Bonus
                        $total = $single_emp['gross_salary'] + $mobileBill + $arearBonus + $oT + $festivalBonus;
                        $sheet->setCellValue('Q' . $row, $total); // Total (L+M+N+O+P)
                        $pFundDeduction = 0;
                        $LoanAdvanceDeduction = 0;
                        $taxDeduction = 0;
                        $lateEarlyDeduction = 0;
                        $absentDeduction = 0;
                        $sheet->setCellValue('R' . $row, $pFundDeduction); // P Fund
                        $sheet->setCellValue('S' . $row, $LoanAdvanceDeduction); // Loan/Advance
                        $sheet->setCellValue('T' . $row, $taxDeduction); //Tax
                        $sheet->setCellValue('U' . $row, $lateEarlyDeduction); //Late/Early deduction taka
                        $sheet->setCellValue('V' . $row, $absentDeduction); // Absent deduction Taka
                        $deductionTotal = $pFundDeduction + $LoanAdvanceDeduction + $taxDeduction + $lateEarlyDeduction + $absentDeduction;
                        $sheet->setCellValue('W' . $row, $deductionTotal); // Total (R+S+T+U+V)
                        $netTotal = $total - $deductionTotal;
                        $sheet->setCellValue('X' . $row, $netTotal); //Net Payment (Q-W)
                        $sheet->setCellValue('Y' . $row, ""); //Remarks

                        $row++;
                        $no++;
                        $pFundDeduction = 0;
                        $LoanAdvanceDeduction = 0;
                        $taxDeduction = 0;
                        $lateEarlyDeduction = 0;
                        $absentDeduction = 0;
                        $netTotal = 0;
                        $total = 0;
                        $late_counter = 0;
                        $early_counter = 0;
                        $absent_halfday_counter = 0;
                        $absent_counter = 0;
                        $daily_movement = 0;
                        $daily_movement_personal = 0;
                        $mobile_no = "";
                        $counter++;
                        $ot3 = 0;
                        $oh = 0;
                        $om = 0;
                        $os = 0;
                        $total_ot = 0;
                        $leave_with_pay = 0;
                        $leave_without_pay = 0;
                        $total_leave = 0;
                        $wp = 0;
                        $mobileBill = 0;
                        $arearBonus = 0;
                        $oT = 0;
                        $festivalBonus = 0;
                    }
                    // End Loop

                    $writer = new Xlsx($spreadsheet);
                    $now = date("d-m-Y_H:i:s", $servertime);
                    $filename = 'Salary-statement-report-of-' . str_replace(' ', '-', $data['defsultdivision_name'] . "-" . $nowbigmonth) . "-" . $now;

                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
                    header('Cache-Control: max-age=0');
                    ob_end_clean();
                    $writer->save('php://output'); // download file 
                    die();
                }
            }
        }
    }
    public function monthlyAttendanceSummaryReports()
    {
        // exit;

        //  $this->load->library("pdf");
        if ($this->input->post()) {
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            $this->form_validation->set_rules('emp_attendance_end_date', 'Attendance End Date', 'required');
            $this->form_validation->set_rules('emp_division', 'Division Field', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
                redirect('reports/monthlyattendancesummeryreports');
            } else {
                $emp_division = $this->input->post('emp_division');
                $emp_department = $this->input->post('emp_department');
                $emp_att_start_date = $this->input->post('emp_attendance_start_date');
                $emp_att_end_date = $this->input->post('emp_attendance_end_date');
                if (strtotime($emp_att_start_date) > strtotime($emp_att_end_date)) {
                    $this->session->set_flashdata('errors', "Date range invalid!");
                    redirect('reports/monthlyattendancesummeryreports');
                }
                $data['defaultdivision_id'] = $emp_division;
                $data['defaultstart_date'] = $emp_att_start_date;
                $data['defaultend_date'] = $emp_att_end_date;
                $data['date_range'] = dateRange($emp_att_start_date, $emp_att_end_date);
                if ($emp_division == 'all') {
                    $data['defsultdivision_name'] = "All";
                    $data['defsultdivision_shortname'] = "All";
                    $data['default_employee'] = $this->search_field_emp_model->getallemployeeorderdivision();
                } else if ($emp_division) {
                    $emp_division_data = $this->taxonomy->getTaxonomyBytid($emp_division);
                    $data['defsultdivision_name'] = $emp_division_data['name'];
                    $data['defsultdivision_shortname'] = $emp_division_data['keywords'];
                    if ($emp_department != "") {
                        $emp_department_data = $this->taxonomy->getTaxonomyBytid($emp_department);
                        $data['department_name'] = $emp_department_data['name'];
                        $data['default_employee'] = $this->search_field_emp_model->getAllEmployeeByDivisionAndDepartment($emp_division, $emp_department);
                    } else {
                        $data['department_name'] = "All";
                        $data['default_employee'] = $this->search_field_emp_model->getallemployeebydivision($emp_division);
                    }
                }
                // if($emp_division){
                //   $data['default_employee']=$this->search_field_emp_model->getallemployeebydivision($emp_division); 
                // } 
                $division_vid = 1;
                $user_type = $this->session->userdata('user_type');
                $user_id = $this->session->userdata('user_id');
                $user_data = $this->users_model->getuserbyid($user_id);
                $user_division_id = $user_data['user_division'];
                $data['user_info'] = $this->users_model->getuserbyid($user_id);
                $data['user_type_id'] = $this->session->userdata('user_type');
                $emp_division_info = $this->taxonomy->getTaxonomyBytid($emp_division);
                $data['defsultdivision_name'] = $emp_division_info['name'];
                $data['defsultdivision_shortname'] = $emp_division_info['keywords'];
                if ($user_type != 1) {
                    $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);
                    $data['allemployee'] = $this->search_field_emp_model->getallemployeebydivision($user_division_id);
                } else {
                    $data['allemployee'] = $this->search_field_emp_model->getallemployee();
                    $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
                }
                $reportFormat = $this->input->post('report_format');
                if ($reportFormat == 'excel') {

                    // Create a new Spreadsheet (Object) 
                    // $spreadsheet = new Spreadsheet();

                    // Printer setup ----------------------------------
                    if ($data['defsultdivision_shortname'] == 'BCPL') {
                        /* Loading a Workbook from a file */
                        $inputFileName = './resources/files/attendance-summary-report-with-ot-without-daily-mov.xlsx';
                        /** Load $inputFileName to a Spreadsheet object * */
                        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
                        $spreadsheet->getActiveSheet()->getPageSetup()
                            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                    } else {
                        /* Loading a Workbook from a file */
                        $inputFileName = './resources/files/attendance-summary-report.xlsx';
                        /** Load $inputFileName to a Spreadsheet object * */
                        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
                        $spreadsheet->getActiveSheet()->getPageSetup()
                            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
                    }
                    $spreadsheet->getProperties()
                        ->setCreator("HR Software")
                        ->setLastModifiedBy("")
                        ->setTitle("Attendance Summary Report")
                        ->setSubject($data['defsultdivision_name'] . "(Attendance Summary)")
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



                    $lastdateofattendance = end($data['date_range']);

                    $datee = date_create($lastdateofattendance);
                    $nowbigmonth = date_format($datee, 'F Y');
                    $sheet->setCellValue('A8', $nowbigmonth);
                    $sheet->setCellValue('c10', $emp_division_info['name']);
                    $sheet->setCellValue('c11', $data['department_name']);
                    if ($data['defsultdivision_shortname'] == 'BCPL') {
                        $sheet->setCellValue('J6', $emp_att_start_date);
                        $sheet->setCellValue('J7', $emp_att_end_date);
                    } else {
                        $sheet->setCellValue('H10', $emp_att_start_date);
                        $sheet->setCellValue('H11', $emp_att_end_date);
                    }
                    $servertime = time();
                    $now = date("d-m-Y H:i:s", $servertime);
                    $row = 13;
                    $no = 1;
                    $totalEmployee = sizeof($data['default_employee']);

                    $sheet->insertNewRowBefore(14, $totalEmployee);

                    $counter = 1;
                    foreach ($data['default_employee'] as $single_emp) {
                        $single_code = $single_emp['emp_id'];
                        $emp_content_id = $single_emp['content_id'];
                        $emp_name = $single_emp['emp_name'];
                        $emp_division_id = $single_emp['emp_division'];
                        $mobile_no = "";
                        if ($single_emp['mobile_no']) {
                            $mobile_no = "-" . $single_emp['mobile_no'];
                        }
                        $emp_division = $this->taxonomy->getTaxonomyBytid($emp_division_id);
                        $emp_post_id = $single_emp['emp_post_id'];
                        $emp_post_id_data = $this->taxonomy->getTaxonomyBytid($emp_post_id);
                        $emp_designation = $emp_post_id_data['name'];

                        $emp_department_id = $single_emp['emp_department'];

                        $late_counter = 0;
                        $early_counter = 0;
                        $absent_counter = 0;
                        $absent_halfday_counter = 0;
                        $leave_with_pay = 0;
                        $daily_movement = 0;
                        $leave_without_pay = 0;
                        $emp_division_shortname = $emp_division['keywords'];
                        $emp_joining_date = $single_emp['joining_date'];

                        // If employee join after attendance end date please skip this employee ----                       
                        if (strtotime($emp_joining_date) >= strtotime($emp_att_end_date)) {
                            continue; // skip this employee and goes back to first -->
                        }

                        $half_day_absent_status = "";
                        $early_status = "";
                        $late_status = "";
                        $today = date("d-m-Y", $servertime);
                        $left_or_termineted = $single_emp['type_of_employee'];
                        if ($left_or_termineted == 153 || $left_or_termineted == 473) {
                            $left_or_termineted_data = $this->emp_job_history_model->getemp_last_job_history($emp_content_id);
                            $left_or_termineted_date = $left_or_termineted_data['start_date'];
                        }

                        // If employee left/terminate before attendance start date please skip this employee ----                        
                        if ($left_or_termineted_date) {
                            if (strtotime($emp_att_start_date) >= strtotime($left_or_termineted_date)) {
                                continue; // skip this employee and goes back to first -->
                            }
                        }


                        foreach ($data['date_range'] as $single_date) {
                            // Check Employee left or Terminated ------------
                            if ($left_or_termineted_date) {
                                if (strtotime($single_date) >= strtotime($left_or_termineted_date)) {
                                    break;
                                }
                            }
                            // Check joining date ----------------------------------------
                            if (strtotime($single_date) >= strtotime($emp_joining_date)) {
                                $empatt_start_date_arr = explode("-", $single_date);
                                $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
                                // Get employee shift history ----------------------------
                                $emp_shift_time = $this->db->query("select * from emp_shift_history WHERE content_id ='$emp_content_id' AND str_to_date(start_date, '%d-%m-%Y') <='$emp_att_start_date' ORDER BY ID DESC LIMIT 1")->row_array();
                                $attendance_required = $emp_shift_time['attendance_required'];
                                $work_starting_time = $emp_shift_time['work_starting_time'];
                                $work_ending_time = $emp_shift_time['work_ending_time'];
                                $logout_required = $emp_shift_time['logout_required'];
                                $year = date('Y', strtotime($single_date));
                                $empatt_start_date_arr = explode("-", $single_date);
                                $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
                                $emp_latecount_time = $emp_shift_time['emp_latecount_time'];
                                $emp_earlycount_time = $emp_shift_time['emp_earlycount_time'];
                                $half_day_absent = $emp_shift_time['half_day_absent'];
                                $absent_count_time = $emp_shift_time['absent_count_time'];
                                $overtime_count = $emp_shift_time['overtime_count'];

                                $tstamp1 = strtotime($single_date);
                                $dated_day_name1 = date("D", $tstamp1);
                                $dated_day_name1 = strtolower($dated_day_name1);
                                // Noor Medical Services Work ending time 4:00:00 PM -----------------
                                if ($emp_division_id == 301 && $dated_day_name1 == 'thu') {
                                    $work_ending_time = "16:00:00";
                                    $emp_earlycount_time = "16:00:00";
                                }
                                // check employee log maintanence ----------------
                                $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,"
                                    . "half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status "
                                    . "FROM log_maintenence WHERE content_id=$emp_content_id and start_date='$single_date' "
                                    . "order by id DESC LIMIT 1")->row_array();

                                // check department log maintanence if employee log dosen't exist ----------------
                                if (!$has_log_attendance_error) {
                                    $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status FROM log_maintenence WHERE department_id=$emp_department_id and start_date='$single_date' order by id DESC LIMIT 1")->row_array();
                                }
                                // check division log maintanence if department & employee log dosen't  exist ----------------
                                if (!$has_log_attendance_error) {
                                    $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,
                                    half_day_absent_count_time,early_status FROM log_maintenence WHERE division_id='$emp_division_id' and start_date='$single_date' order by id DESC LIMIT 1")->row_array();
                                }
                                // check all division log maintanence if division, department & employee log dosen't  exist ----------------
                                $division = "all";
                                if (!$has_log_attendance_error) {
                                    $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status FROM log_maintenence WHERE division_id='$division' and start_date='$single_date' order by id DESC LIMIT 1")->row_array();
                                }

                                // If log exist ------------------
                                if ($has_log_attendance_error) {
                                    $late_status = $has_log_attendance_error['late_status'];
                                    $log_weekly_holiday = $has_log_attendance_error['weekly_holiday'];
                                    $presence_status_has_no_log = $has_log_attendance_error['present_status'];
                                    if ($late_status == 'Late_Count_Time') {
                                        $emp_latecount_time = $has_log_attendance_error['late_count_time'];
                                    }
                                    $half_day_absent_status = $has_log_attendance_error['half_day_absent_status'];
                                    if ($half_day_absent_status == 'Half_Day_Absent_Count_Time') {
                                        $absent_count_time = $has_log_attendance_error['half_day_absent_count_time'];
                                    }
                                    $early_status = $has_log_attendance_error['early_status'];
                                    if ($early_status == 'Early_Count_Time') {
                                        $emp_earlycount_time = $has_log_attendance_error['early_count_time'];
                                    }
                                    $reason = $has_log_attendance_error['reason'];
                                }
                                // Attendance info from attendance table -------------------------------------------------
                                if (strtotime($single_date) <= strtotime('30-11-2018')) {
                                    // If before December, 2018 ----------------------------------------------------
                                    $attendance_info = $this->db->query("SELECT login_time,logout_time,remarks "
                                        . "FROM emp_attendance_old "
                                        . "WHERE content_id=$emp_content_id AND attendance_date='$single_date' "
                                        . "ORDER BY id DESC")->row_array();
                                } else {
                                    // If after November, 2018 ------------------------------------------------------
                                    $attendance_info = $this->db->query("SELECT login_time,logout_time,remarks "
                                        . "FROM emp_attendance "
                                        . "WHERE content_id=$emp_content_id AND attendance_date='$single_date' "
                                        . "ORDER BY id DESC")->row_array();
                                }
                                $login_time = $attendance_info['login_time'];
                                $logout_time = $attendance_info['logout_time'];
                                // Attendance informed info from informed table(such as  Daily movement ) --------------------------------------
                                $emp_informed_info = $this->db->query("SELECT presence_status,logout_status,reason,remarks FROM emp_informed WHERE content_id=$emp_content_id AND attendance_date='$single_date' AND second_approval=1 ORDER BY id DESC")->row_array();

                                // If holiday exist for employee division ----
                                $holiday_exist = $this->db->query("SELECT eyh.holiday_type,t.name as holiday_name "
                                    . "FROM emp_yearlyholiday eyh "
                                    . "LEFT JOIN taxonomy t ON t.tid=eyh.holiday_type "
                                    . "WHERE eyh.holiday_for_division='$emp_division_id' AND eyh.holiday_for_department='$emp_department_id' AND eyh.holiday_start_date='$single_date' "
                                    . "ORDER BY eyh.id DESC")->row_array();

                                if (!$holiday_exist) {
                                    // If holiday exist for employee company ----
                                    $holiday_exist = $this->db->query("SELECT eyh.holiday_type,t.name as holiday_name "
                                        . "FROM emp_yearlyholiday eyh "
                                        . "LEFT JOIN taxonomy t ON t.tid=eyh.holiday_type "
                                        . "WHERE eyh.holiday_for_division='$emp_division_id' AND (eyh.holiday_for_department = NULL OR eyh.holiday_for_department = '') AND eyh.holiday_start_date='$single_date' "
                                        . "ORDER BY eyh.id DESC")->row_array();
                                    //                    $holiday_exist = $this->emp_holiday_model->getemp_yearlyholiday($division, $single_date);
                                }
                                if (!$holiday_exist) {
                                    // If holiday exist for all company ----
                                    $holiday_exist = $this->db->query("SELECT eyh.holiday_type,t.name as holiday_name "
                                        . "FROM emp_yearlyholiday eyh "
                                        . "LEFT JOIN taxonomy t ON t.tid=eyh.holiday_type "
                                        . "WHERE eyh.holiday_for_division='$division' AND eyh.holiday_start_date='$single_date' "
                                        . "ORDER BY eyh.id DESC LIMIT 1")->row_array();
                                    //                $holiday_exist = $this->emp_holiday_model->getemp_yearlyholiday($division, $single_date);
                                }
                                if ($holiday_exist) {
                                    // If holiday ----
                                    $holiday_type_tid = $holiday_exist['holiday_type'];
                                    $holiday_name = $holiday_exist['holiday_name']; // this will be echoed
                                    $remarks = $holiday_exist['holiday_name'];
                                    $login_time = $attendance_info['login_time'];
                                    $logout_time = $attendance_info['logout_time'];
                                    //echo "holiday";
                                } else {
                                    $tstamp = strtotime($single_date);
                                    $dated_day_name = date("D", $tstamp);
                                    $dated_day_name = strtolower($dated_day_name);
                                    $empatt_start_date_arr = explode("-", $single_date);
                                    $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
                                    $offday_exist = $this->db->query("SELECT * FROM emp_weeklyholiday_history WHERE content_id='$emp_content_id' AND str_to_date(start_date, '%d-%m-%Y') <='$emp_att_start_date' ORDER BY id DESC LIMIT 1")->row_array();
                                    //                    $offday_exist = $this->emp_weeklyholiday_history_model->getemp_weeklyholiday_historybydate($emp_content_id, $single_date);
                                    //$offday_exist = $this->emp_holiday_model->getemp_holiday($emp_content_id);

                                    if ($offday_exist['' . $dated_day_name . '_off'] == 'off') {
                                        $weekly_holiday = "Weekly Holiday";
                                        $remarks = "Weekly Holiday";
                                        // If weekly holiday

                                    }
                                    if ($log_weekly_holiday == 'off_day') {
                                        if ($reason == "Weekly Holiday") {
                                            $remarks = $reason;
                                        } else if ($reason == "Official Holiday") {
                                            $holiday_name = "Official Holiday";
                                        }

                                        // If log holiday
                                    }

                                    if (($remarks != "Weekly Holiday") || ($log_weekly_holiday == 'working_day')) {

                                        //                        $leave_exist = $this->emp_leave_model->getemp_leave($emp_content_id, $single_date);
                                        //                        $leave_exist = $this->db->query("SELECT leave_type,justification FROM emp_leave WHERE content_id='$emp_content_id' AND leave_start_date='$single_date' ORDER BY id DESC")->row_array();
                                        $leave_exist = $this->db->query("SELECT el.leave_type,el.justification,t.name as leave_name "
                                            . "FROM emp_leave el "
                                            . "LEFT JOIN taxonomy t ON t.tid=el.leave_type "
                                            . "WHERE el.content_id='$emp_content_id' "
                                            . "AND el.leave_start_date='$single_date' AND approve_status='approved' ORDER BY el.id DESC")->row_array();

                                        if ($leave_exist) {
                                            // If Leave ------
                                            $leave_type = $leave_exist['leave_type'];
                                            $leave_reason = $leave_exist['leave_name'];
                                            if (!$leave_reason) {
                                                $leave_reason = "Leave";
                                            }
                                            if ($leave_type == '446') {
                                                $remarks = "Half Day Leave";
                                                $login_time = $attendance_info['login_time'];
                                                $logout_time = $attendance_info['logout_time'];
                                            } else if ($leave_type == '336') {
                                                $remarks = "leave_without_pay";
                                            } else {
                                                $remarks = "Leave";
                                            }
                                        } else {
                                            // If employee no leave ----------------------------
                                            // Check Attendance Informed Info(Such as :Daily Movement)-----------------------------
                                            $presence_status = "";
                                            $presence_status_informed = $emp_informed_info['presence_status'];
                                            $logout_status_informed = $emp_informed_info['logout_status'];
                                            $reason_informed = $emp_informed_info['reason'];
                                            $informed_remarks = $emp_informed_info['remarks'];
                                            if ($reason_informed != $informed_remarks) {
                                                $informed_remarks = $emp_informed_info['reason'] . " [<span style='font-size:8px;'>" . $emp_informed_info['remarks'] . "]</span>";
                                            }
                                            $login_time = $attendance_info['login_time'];
                                            $logout_time = $attendance_info['logout_time'];
                                            if ($half_day_absent == 'Eligible') {
                                                if ($half_day_absent_status == 'Half_Day_Absent_Not_Count') { // problem day
                                                    $remarks = $reason;
                                                } else if ($login_time && strtotime($login_time) > strtotime($absent_count_time)) {
                                                    if (!$logout_time) {
                                                        $half_absent_found = "Half Day Absent";
                                                        $remarks = "Half Day Absent";
                                                    } else if (strtotime($emp_earlycount_time) > strtotime($logout_time)) {
                                                        $half_absent_found = "Half Day Absent";
                                                        $remarks = "Half Day Absent";
                                                    } else {
                                                        $half_absent_found = "Half Day Absent";
                                                        $remarks = "Half Day Absent";
                                                    }
                                                } else if ($late_status == "Late_Not_Count") {
                                                    $remarks = $reason;
                                                } else if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                                    $emp_late_found = "Late";
                                                    $remarks = "Late";
                                                    $login_time = "<font color=red >" . $login_time . "</font>";
                                                } else {
                                                    $remarks = $attendance_info['remarks'];
                                                }
                                            } else {
                                                //echo $emp_latecount_time;
                                                if ($presence_status_informed) {
                                                    //---------------------------------------------------------------------------------------------------------------------------------------
                                                    $presence_status = $presence_status_informed;
                                                    $remarks = $informed_remarks;
                                                    if ($presence_status == 'A') {
                                                        $login_time = "";
                                                        $logout_time = "";
                                                    }
                                                } else if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                                    $emp_late_found = "Late";
                                                    $remarks = "Late";
                                                    // $login_time="<font color=red >".$login_time."</font>";
                                                } else {
                                                    $remarks = $attendance_info['remarks'];
                                                }
                                            }
                                        } // end of leave check condition
                                    }
                                }

                                // if not login but logout after 04:00 PM ....................................................
                                if (!$logout_time && $login_time && $login_time >= "16:00:00") {
                                    $logout_time = $login_time;
                                    $login_time = "";
                                }

                                // Counter Start ---------------------------------------------------------------Counter++ Start---------------------------------------------
                                if ($holiday_name) {
                                    // yearly holiday
                                } else if (($remarks == "Weekly Holiday") && ($log_weekly_holiday != 'working_day')) {

                                    // weekly holiday
                                } else if ($remarks == 'leave_without_pay') {
                                    $leave_without_pay++;
                                    $absent_counter++;
                                } else if ($remarks == 'Leave') {
                                    $leave_with_pay++;
                                } else if ($remarks == 'Half Day Leave') {
                                } else if ($attendance_required == 'Not_Required') {
                                } else if ($presence_status_informed) {
                                    $daily_movement++;
                                    if ($informed_remarks == 'personal') {
                                        $daily_movement_personal++;
                                    }
                                    if ($presence_status == 'A') {
                                        $absent_counter++;
                                    } else if ($presence_status == 'P' && $logout_status_informed == 'P') {
                                    } else if ($presence_status == 'P' && $logout_status_informed == 'E') {
                                        $early_counter++;
                                    } else if ($presence_status == 'L' && $logout_status_informed == 'E') {
                                        $late_counter++;
                                        $early_counter++;
                                    } else if ($presence_status == 'A.H') {
                                        $absent_halfday_counter++;
                                    } else if ($presence_status == 'L') {
                                        $late_counter++;
                                    } else if ($presence_status_informed == 'L') {
                                        $late_counter++;
                                    } else if ($logout_status_informed == 'E') {
                                        $early_counter++;
                                    }
                                } else if ($presence_status == 'A') {
                                    $absent_counter++;
                                } else if ($presence_status == 'P') {
                                } else if ($presence_status == 'A.H') {
                                    if (strtotime($single_date) == strtotime($today)) {
                                        // echo "P";
                                    } else {
                                        $absent_halfday_counter++;
                                    }
                                } else if ($presence_status == 'L') {
                                    $late_counter++;
                                } else if ($late_status == "Late_Not_Count" && $early_status == "Early_Not_Count") {
                                    if ($presence_status_has_no_log == "A" && !$login_time && !$logout_time) {
                                        $absent_counter++;
                                    } else if ($presence_status_has_no_log == "P") {
                                        //    echo "P";
                                    } else {
                                        // echo "P";
                                    }
                                } else if ($late_status == "Late_Count_Time" && $early_status == "Early_Count_Time") {
                                    if (
                                        $login_time && $logout_time && strtotime($login_time) >= strtotime($emp_latecount_time) &&
                                        strtotime($logout_time) <= strtotime($emp_earlycount_time)
                                    ) {
                                        $late_counter++;
                                        if (strtotime($single_date) == strtotime($today)) {
                                            // $late_counter++;
                                        } else {
                                            //$late_counter++;
                                            $early_counter++;
                                        }
                                    } else if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                        $late_counter++;
                                    } else if ($logout_time && strtotime($logout_time) <= strtotime($emp_earlycount_time)) {
                                        if (strtotime($single_date) == strtotime($today)) {
                                            //  echo "P";
                                        } else {
                                            $early_counter++;
                                        }
                                    } else if (!$login_time && !$logout_time) {
                                        $absent_counter++;
                                    } else {
                                        // echo "P";
                                    }
                                } else if ($late_status == "Late_Count_Time" && $early_status == "Early_Not_Count") {
                                    if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                        $late_counter++;
                                    } else if (!$login_time && !$logout_time) {
                                        $absent_counter++;
                                    } else {
                                        // echo "P";
                                    }
                                } else if ($late_status == "Late_Not_Count" && $early_status == "Early_Count_Time") {
                                    if (strtotime($logout_time) <= strtotime($emp_earlycount_time)) {
                                        if (strtotime($single_date) == strtotime($today)) {
                                            // echo "P";
                                        } else {
                                            $early_counter++;
                                        }
                                    } else if (!$login_time && !$logout_time) {
                                        $absent_counter++;
                                    } else {
                                        // echo "P";
                                    }
                                } else if (!$login_time && !$logout_time) {
                                    $attendance_log = $this->emp_attendance_model->getemp_attendance_log();
                                    $attendance_log_date = $attendance_log['attendance_date'];
                                    if (strtotime($single_date) > strtotime($attendance_log_date)) {
                                        // echo "NC";
                                    } else {
                                        $absent_counter++;
                                    }
                                } else if ($login_time && !$logout_time && $logout_required == "Required" && $half_day_absent == 'Eligible') {
                                    if (strtotime($single_date) == strtotime($today)) {
                                        // echo "P";
                                    } else {
                                        $absent_halfday_counter++;
                                    }
                                } else if ($login_time && !$logout_time && $logout_required == "Required") {
                                    if ($emp_late_found) {
                                        $late_counter++;
                                        if (strtotime($single_date) == strtotime($today)) {
                                        } else {
                                            $early_counter++;
                                        }
                                    } else {
                                        if (strtotime($single_date) == strtotime($today)) {
                                            //echo "p";
                                        } else {
                                            $early_counter++;
                                        }
                                    }
                                } else if ($login_time && !$logout_time && $logout_required == "Optional") {
                                    // echo "P";
                                } else if ($half_absent_found) {
                                    if (strtotime($single_date) == strtotime($today)) {
                                        // echo "P";
                                    } else {
                                        $absent_halfday_counter++;
                                    }
                                } else if ($emp_late_found) {
                                    if ($login_time && $logout_time && $logout_required == "Required" && strtotime($logout_time) <= strtotime($emp_earlycount_time)) {
                                        $late_counter++;
                                        if (strtotime($single_date) == strtotime($today)) {
                                        } else {
                                            $early_counter++;
                                        }
                                    } else {
                                        $late_counter++;
                                    }
                                } else if ($login_time && $logout_time && $logout_required == "Required") {
                                    if (strtotime($emp_earlycount_time) >= strtotime($logout_time)) {
                                        if (strtotime($single_date) == strtotime($today)) {
                                            // echo "p";
                                        } else {
                                            $early_counter++;
                                        }
                                    } else {
                                        if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                            $late_counter++;
                                        } else {
                                            //  echo "P";
                                        }
                                    }
                                } else {
                                    // echo "P";
                                }

                                // Start Over Time Count ------------------------------------------------------------------------------------------
                                /*
                                if ($defsultdivision_shortname == 'BCPL') {
                                    if (strtotime($logout_time) > strtotime($work_ending_time) || ($login_time && $logout_time && $division_id_emp == 20)) {
                                        // overtime count after 16 minutes for medisys
                                        // echo $working_time_today_total;
                                        if ($division_id_emp == 20) {
                                            $medisys_time = strtotime($work_ending_time);
                                            $endTime_medisys = date("H:i:s", strtotime('+16 minutes', $medisys_time));
                                            if (strtotime($logout_time) > strtotime($endTime_medisys)) {
                                                $emp_overtime_today = get_time_difference($endTime_medisys, $logout_time);

                                                if ($holiday_exist || $remarks == "Weekly Holiday") {

                                                    $emp_overtime_today = $working_time_today_total;
                                                } else if (!$emp_overtime_today) {
                                                    $emp_overtime_today = $working_time_today_total;
                                                }

                                                $b = explode(':', $emp_overtime_today);
                                                $ot1 = $b[0] * 3600 + $b[1] * 60 + $b[2];
                                                $ot3 = $ot3 + $ot1;

                                                //  echo $emp_overtime_today;
                                            } else if ($remarks == "Weekly Holiday" && $working_time_today_total) {
                                                $b = explode(':', $working_time_today_total);
                                                $ot1 = $b[0] * 3600 + $b[1] * 60 + $b[2];
                                                $ot3 = $ot3 + $ot1;
                                                //  echo $working_time_today_total;
                                            }
                                        } else {
                                            // for BEL over time
                                            // security guard er jonno daily -8 hours overtime and holiday wholeday holiday
                                            if ($post_id_emp == 57 || $post_id_emp == 58 || $post_id_emp == 59 || $post_id_emp == 60 || $post_id_emp == 117) {
                                                if (strtotime($login_time) && strtotime($logout_time)) {
                                                    $emp_overtime_today = get_time_difference($login_time, $logout_time);
                                                    $officetime = strtotime("-8 hours");
                                                    $timestamp = strtotime($emp_overtime_today);
                                                    if ($timestamp > $officetime) {
                                                        if ($holiday_exist || $remarks == 'Weekly Holiday') {
                                                            $timestamp = strtotime($emp_overtime_today);
                                                        } else {
                                                            $timestamp = strtotime($emp_overtime_today) - 60 * 60 * 8;
                                                        }

                                                        $timestamp = date("H:i:s", $timestamp);

                                                        if ($timestamp) {
                                                            $b = explode(':', $timestamp);
                                                            $ot1 = $b[0] * 3600 + $b[1] * 60 + $b[2];
                                                            $ot3 = $ot3 + $ot1;
                                                            //  echo $timestamp;
                                                        }
                                                    }
                                                }
                                            } else {
                                                // For BCPL & others...
                                                $for_all_time = strtotime($work_ending_time);
                                                //$endTime_for_all = date("H:i:s", strtotime('+20 minutes', $for_all_time));
                                                $endTime_for_all = date("H:i:s", strtotime('+00 minutes', $for_all_time));
                                                if (strtotime($logout_time) > strtotime($endTime_for_all)) {
                                                    $emp_overtime_today = get_time_difference($endTime_for_all, $logout_time);

                                                    if ($holiday_exist || $remarks == "Weekly Holiday") {
                                                        $emp_overtime_today = $working_time_today_total;
                                                    } else if (!$emp_overtime_today) {
                                                        $emp_overtime_today = $working_time_today_total;
                                                    }

                                                    $b = explode(':', $emp_overtime_today);
                                                    $ot1 = $b[0] * 3600 + $b[1] * 60 + $b[2];
                                                    $ot3 = $ot3 + $ot1;

                                                    // echo $emp_overtime_today;
                                                } else if ($remarks == "Weekly Holiday" && $working_time_today_total) {
                                                    $b = explode(':', $working_time_today_total);
                                                    $ot1 = $b[0] * 3600 + $b[1] * 60 + $b[2];
                                                    $ot3 = $ot3 + $ot1;
                                                    // echo $working_time_today_total;
                                                }


                                                // start for all overtime
                                                // $emp_overtime_today= get_time_difference($work_ending_time, $logout_time);
                                                // $b=explode(':',$emp_overtime_today);
                                                // $ot1=$b[0]*3600+$b[1]*60+$b[2];
                                                // $ot3=$ot3+$ot1;
                                                // echo $emp_overtime_today;
                                                // ends for all overtime
                                            }
                                        }
                                    }
                                }
                                */
                                // End Over Time Count -------------------------------------------------------------------------------------------
                                $login_time = "";
                                $logout_time = "";
                                $holiday_name = "";
                                $weekly_holiday = "";
                                $log_weekly_holiday = "";
                                $remarks = "";
                                $reason = "";
                                $half_absent_found = "";
                                $emp_late_found = "";
                                $late_status = "";
                                $early_status = "";
                                if (strtotime($single_date) >= strtotime($today)) {
                                    break;
                                }
                                if ($left_or_termineted_date) {
                                    if (strtotime($single_date) >= strtotime($left_or_termineted_date)) {
                                        break;
                                    }
                                }
                            }
                        }
                        // excel row info here ----------
                        // set column width 
                        //  $sheet->getColumnDimension('A')->setWidth(12);
                        $sheet->setCellValue('A' . $row, $no);
                        $sheet->setCellValue('B' . $row, $single_emp['emp_id']);
                        if ($attendance_required == 'Not_Required') {
                            $remarks = "Not Required";
                            $empName = $single_emp['emp_name'] . ' *';
                        } else {
                            $empName = $single_emp['emp_name'];
                        }
                        $sheet->setCellValue('C' . $row, $empName);
                        $sheet->getCell('C' . $row)->getHyperlink()->setUrl('http://bdclbd.com/reports/monthlyattendancereports');
                        // set wrap text
                        $sheet->getStyle('C' . $row)->getAlignment()->setWrapText(true);
                        $sheet->setCellValue('D' . $row, $emp_designation);
                        $sheet->setCellValue('E' . $row, $late_counter);
                        $sheet->setCellValue('F' . $row, $early_counter);
                        if ($daily_movement > 0) {
                            $official = $daily_movement - $daily_movement_personal;
                            if ($daily_movement_personal > 0 && $official > 0) {
                                $daily_movement = $daily_movement . "\n(Per-" . $daily_movement_personal . ",Offi-" . $official . ")";
                            } else if ($daily_movement_personal > 0 && $official == 0) {
                                $daily_movement = $daily_movement . "\n(Per-" . $daily_movement_personal . ")";
                            } else if ($daily_movement_personal == 0 && $official > 0) {
                                $daily_movement = $daily_movement . "\n(Offi-" . $official . ")";
                            } else {
                                $daily_movement = 0;
                            }
                            //  $sheet->getStyle('G' . $row)->getAlignment()->setWrapText(true);
                            //   $sheet->getStyle('G' . $row)
                            //       ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                            //  $sheet->getStyle('G' . $row)->getFont()->setSize(8);
                        } else {
                            $daily_movement = $daily_movement;
                        }
                        // $sheet->setCellValue('G' . $row, $daily_movement);
                        $total_leave = $leave_with_pay + $leave_without_pay;
                        if ($total_leave == 0) {
                            $total_leave = '0';
                        } else {
                            if ($leave_with_pay > 0 && $leave_without_pay > 0) {
                                $total_leave = $total_leave . "\n(WP-" . $leave_with_pay . ",WOP-" . $leave_without_pay . ")";
                            } else if ($leave_with_pay > 0 && $leave_without_pay == 0) {
                                $total_leave = $total_leave . "\n(WP-" . $leave_with_pay . ")";
                            } else if ($leave_with_pay == 0 && $leave_without_pay > 0) {
                                $total_leave = $total_leave . "\n(WOP-" . $leave_without_pay . ")";
                            } else {
                                $total_leave = 0;
                            }
                            $sheet->getStyle('G' . $row)
                                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                            $sheet->getStyle('G' . $row)->getAlignment()->setWrapText(true);
                            $sheet->getStyle('G' . $row)->getFont()->setSize(8);
                        }

                        $sheet->setCellValue('G' . $row, $total_leave);
                        $sheet->setCellValue('H' . $row, $absent_counter);
                        if ($attendance_required == 'Not_Required') {
                            $remarks = "Not Required";
                        } else {
                            $remarks = "";
                        }
                        if ($data['defsultdivision_shortname'] == 'BCPL') {
                            $sheet->setCellValue('I' . $row, "");
                            $sheet->setCellValue('J' . $row, $remarks);
                        } else {
                            $sheet->setCellValue('I' . $row, $remarks);
                        }

                        $row++;
                        $no++;
                        $late_counter = 0;
                        $early_counter = 0;
                        $absent_halfday_counter = 0;
                        $absent_counter = 0;
                        $daily_movement = 0;
                        $daily_movement_personal = 0;
                        $mobile_no = "";
                        $counter++;
                        $ot3 = 0;
                        $oh = 0;
                        $om = 0;
                        $os = 0;
                        $total_ot = 0;
                        $leave_with_pay = 0;
                        $leave_without_pay = 0;
                        $total_leave = 0;
                        $wp = 0;
                    }
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
                } else if ($reportFormat == 'pdf') {
                    $mpdf = $this->pdf->load();
                    $html = $this->load->view('print/printmonthlyattendancesummerypdf', $data, true);
                    #$mpdf->SetVisibility('printonly'); // This will be my code; 
                    //$mpdf->SetProtection(array('copy','print','modify'), 'r', '58');
                    $mpdf->SetJS('this.print();');
                    $mpdf->WriteHTML(utf8_encode($html));
                    $mpdf->Output();
                }
            }
        }
    }
    public function monthlyattendancereportssummerypdf()
    {
        //  $this->load->library("pdf");
        if ($this->input->post()) {
            $this->form_validation->set_rules('emp_attendance_start_date', 'Attendance Start Date', 'required');
            $this->form_validation->set_rules('emp_attendance_end_date', 'Attendance End Date', 'required');
            $this->form_validation->set_rules('emp_division', 'Division Field', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
                redirect('reports/monthlyattendancesummeryreports');
            } else {
                $emp_division = $this->input->post('emp_division');
                $emp_department = $this->input->post('emp_department');
                $emp_att_start_date = $this->input->post('emp_attendance_start_date');
                $emp_att_end_date = $this->input->post('emp_attendance_end_date');
                if (strtotime($emp_att_start_date) > strtotime($emp_att_end_date)) {
                    $this->session->set_flashdata('errors', "Date range invalid!");
                    redirect('reports/monthlyattendancesummeryreports');
                }
                $data['defaultdivision_id'] = $emp_division;
                $data['defaultstart_date'] = $emp_att_start_date;
                $data['defaultend_date'] = $emp_att_end_date;
                $data['date_range'] = dateRange($emp_att_start_date, $emp_att_end_date);
                if ($emp_division == 'all') {
                    $data['defsultdivision_name'] = "All";
                    $data['defsultdivision_shortname'] = "All";
                    $data['default_employee'] = $this->search_field_emp_model->getallemployeeorderdivision();
                } else if ($emp_division) {
                    $emp_division_data = $this->taxonomy->getTaxonomyBytid($emp_division);
                    $data['defsultdivision_name'] = $emp_division_data['name'];
                    $data['defsultdivision_shortname'] = $emp_division_data['keywords'];
                    if ($emp_department != "") {
                        $emp_department_data = $this->taxonomy->getTaxonomyBytid($emp_department);
                        $data['department_name'] = $emp_department_data['name'];
                        $data['default_employee'] = $this->search_field_emp_model->getAllEmployeeByDivisionAndDepartment($emp_division, $emp_department);
                    } else {
                        $data['department_name'] = "All";
                        $data['default_employee'] = $this->search_field_emp_model->getallemployeebydivision($emp_division);
                    }
                }
                // if($emp_division){
                //   $data['default_employee']=$this->search_field_emp_model->getallemployeebydivision($emp_division); 
                // } 
                $division_vid = 1;
                $user_type = $this->session->userdata('user_type');
                $user_id = $this->session->userdata('user_id');
                $user_data = $this->users_model->getuserbyid($user_id);
                $user_division_id = $user_data['user_division'];
                $data['user_info'] = $this->users_model->getuserbyid($user_id);
                $data['user_type_id'] = $this->session->userdata('user_type');
                $emp_division_info = $this->taxonomy->getTaxonomyBytid($emp_division);
                $data['defsultdivision_name'] = $emp_division_info['name'];
                $data['defsultdivision_shortname'] = $emp_division_info['keywords'];
                if ($user_type != 1) {
                    $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($user_division_id);
                    $data['allemployee'] = $this->search_field_emp_model->getallemployeebydivision($user_division_id);
                } else {
                    $data['allemployee'] = $this->search_field_emp_model->getallemployee();
                    $data['alldivision'] = $this->taxonomy->getTaxonomyByvid($division_vid);
                }
                $reportFormat = $this->input->post('report_format');
                if ($reportFormat == 'excel') {
                    $this->load->view('print/printMonthlyAttendanceSummeryExcel', $data, true);
                } else if ($reportFormat == 'pdf') {
                    $mpdf = $this->pdf->load();
                    $html = $this->load->view('print/printmonthlyattendancesummerypdf', $data, true);
                    $mpdf->SetVisibility('printonly'); // This will be my code; 
                    //$mpdf->SetProtection(array('copy','print','modify'), 'r', '58');
                    $mpdf->SetJS('this.print();');
                    $mpdf->WriteHTML(utf8_encode($html));
                    $mpdf->Output();
                }
            }
        }
    }
    public function leavesummerypdf()
    {
        $this->load->library("pdflandscape");
        $searchpage = "leavesummeryreport";
        $default_division_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        if ($default_division_id) {
            $emp_codes_query = $default_division_id['per_page'];
            $data['emp_codes'] = explode(",", $emp_codes_query);
            $division_id = $default_division_id['search_query'];
            $data['default_date'] = $default_division_id['table_view'];
            if ($division_id == 'all') {
                $data['defsultdivision_name'] = "All";
                $data['defsultdivision_shortname'] = "All";
            } else if ($division_id) {
                $emp_division = $this->taxonomy->getTaxonomyBytid($division_id);
                $data['defsultdivision_name'] = $emp_division['name'];
                $data['defsultdivision_shortname'] = $emp_division['keywords'];
            }
            
            $mpdf = $this->pdflandscape->load();
            $html = $this->load->view('print/printleavesummerypdf', $data, true);
            //$mpdf->SetVisibility('printonly'); // This will be my code; 
            $mpdf->SetJS('this.print();');
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output();
        } else {
            redirect('leave_summery_report');
        }
    }

    public function leavesummarymonthlypdf(){
        $this->load->library("pdflandscape");
        $searchpage = "leavesummeryreportmonthly";
        $default_division_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        if ($default_division_id) {
            $emp_codes_query = $default_division_id['per_page'];
            $data['emp_codes'] = explode(",", $emp_codes_query);
            $division_id = $default_division_id['search_query'];
            $data['default_start_date'] = $default_division_id['table_view'];
            $data['default_end_date'] = $default_division_id['month'];
            if ($division_id == 'all') {
                $data['defsultdivision_name'] = "All";
                $data['defsultdivision_shortname'] = "All";
            } else if ($division_id) {
                $emp_division = $this->taxonomy->getTaxonomyBytid($division_id);
                $data['defsultdivision_name'] = $emp_division['name'];
                $data['defsultdivision_shortname'] = $emp_division['keywords'];
            }
            
            $mpdf = $this->pdflandscape->load();
            $html = $this->load->view('print/printleavesummerymonthlypdf', $data, true);
            //$mpdf->SetVisibility('printonly'); // This will be my code; 
            $mpdf->SetJS('this.print();');
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output();
        } else {
            redirect('leave_summery_report_monthly');
        }
    }



    public function leave_single_pdf()
    {
        $searchpage = "single_leave_report";

        $default_emp_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $att_date_arr = explode("-", $default_emp_id['table_view']);
        $year = $att_date_arr[2];
        $month = $att_date_arr[1];
        if (!$year) {
            $year = date('Y');
        }
        if (!$month) {
            $month = date('m');
        }
        $data['defaultatt_date'] = $default_emp_id['table_view'];
        $data['lastdateofattendance'] = $default_emp_id['table_view'];
        $data['defaultcontent_id'] = $default_emp_id['search_query'];
        $data['default_emp'] = $this->search_field_emp_model->getallsearch_table_contentByid($default_emp_id['search_query']);
        $data['defaultyear'] = $year;
        $emp_atten_date = "01-01-$year";
        $data['emp_total_leave'] = $this->emp_yearly_leave_history_model->getemp_yearlyleave_historybydate($default_emp_id['search_query'], $emp_atten_date);
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $user_data = $this->users_model->getuserbyid($user_id);
        $user_division_id = $user_data['user_division'];
        $data['user_info'] = $this->users_model->getuserbyid($user_id);
        $data['user_type_id'] = $this->session->userdata('user_type');
        // get all absent task start here
        $joining_date = $data['default_emp']['joining_date'];
        $joining_date_arr = explode("-", $joining_date);
        $joining_year = $joining_date_arr[2];
        if ($year == $joining_year) {
            $date_range_beforejoining = dateRange($emp_atten_date, $joining_date);
        }
        $content_id = $default_emp_id['search_query'];
        $to_date = $default_emp_id['table_view'];
        $all_att_dates = $this->emp_attendance_model->getallattendancedate($content_id, $emp_atten_date, $to_date);
        $all_informed_dates = $this->emp_informed_model->getemp_informealldates($content_id, $emp_atten_date, $to_date);
        $all_leaved_dates = $this->emp_leave_model->getallleavedate($content_id, $emp_atten_date, $to_date);
        $all_holiday_dates = $this->emp_holiday_model->getallholidaydate($user_division_id, $emp_atten_date, $to_date);
        $final_all_dates = $all_att_dates['att_dates'] . "," . $all_informed_dates['informed_dates'] . "," . $all_leaved_dates['leave_dates'] . "," . $all_holiday_dates['holiday_dates'];
        $final_all_dates_arr = explode(",", $final_all_dates);
        $date_range = dateRange($emp_atten_date, $to_date);
        $total_absent_dates = array_diff($date_range, $final_all_dates_arr);
        if ($date_range_beforejoining) {
            $total_absent_dates = array_diff($total_absent_dates, $date_range_beforejoining);
        }
        $counter_absent = 0;
        foreach ($total_absent_dates as $single_date) {
            $tstamp = strtotime($single_date);
            $dated_day_name = date("D", $tstamp);
            $dated_day_name = strtolower($dated_day_name);
            $offday_exist = $this->emp_weeklyholiday_history_model->getemp_weeklyholiday_historybydate($content_id, $single_date);
            if ($offday_exist['' . $dated_day_name . '_off'] != 'off') {
                $counter_absent++;
            }
        }
        if ($joining_year > $year) {
            $counter_absent = 0;
        }
        $data['total_absent'] = $counter_absent;
        // get all absent ends here;    
        if ($user_type != 1) {
            $data['allemployee'] = $this->search_field_emp_model->getallemployeebydivision($user_division_id);
        } else {
            $data['allemployee'] = $this->search_field_emp_model->getallemployee();
        }
        $data['emp_holiday'] = $this->emp_holiday_model->getemp_holiday($default_emp_id['search_query']);
        $allleavetype_vid = 16;
        $data['allleavetype'] = $this->taxonomy->getTaxonomyByvid($allleavetype_vid);
        $mpdf = $this->pdf->load();
        $html = $this->load->view('print/print_leave_report_single_pdf', $data, true);
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetProtection(array('copy','print','modify'), 'r', 'MyPassword');
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output();
    }

    public function total_absent_reports_pdf()
    {
        $searchpage = "total_absent_reports";
        $default_emp_id = $this->search_field_emp_model->getsearchQuery($searchpage);
        $att_date_arr = explode("-", $default_emp_id['table_view']);
        $year = $att_date_arr[2];
        $month = $att_date_arr[1];
        if (!$year) {
            $year = date('Y');
        }
        if (!$month) {
            $month = date('m');
        }
        $to_date = $default_emp_id['table_view'];
        $content_id = $default_emp_id['search_query'];
        $data['defaultatt_date'] = $default_emp_id['table_view'];
        $data['defaultcontent_id'] = $default_emp_id['search_query'];
        $data['default_emp'] = $this->search_field_emp_model->getallsearch_table_contentByid($default_emp_id['search_query']);
        $data['defaultyear'] = $year;
        $emp_atten_date = "01-01-$year";
        $data['emp_total_leave'] = $this->emp_yearly_leave_history_model->getemp_yearlyleave_historybydate($default_emp_id['search_query'], $emp_atten_date);
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $user_data = $this->users_model->getuserbyid($user_id);
        $user_division_id = $user_data['user_division'];
        $data['user_info'] = $this->users_model->getuserbyid($user_id);
        $data['user_type_id'] = $this->session->userdata('user_type');
        // get all absent task start here
        $joining_date = $data['default_emp']['joining_date'];
        $joining_date_arr = explode("-", $joining_date);
        $joining_year = $joining_date_arr[2];
        if ($year == $joining_year) {
            $date_range_beforejoining = dateRange($emp_atten_date, $joining_date);
        }
        $all_att_dates = $this->emp_attendance_model->getallattendancedate($content_id, $emp_atten_date, $to_date);
        $all_informed_dates = $this->emp_informed_model->getemp_informealldates($content_id, $emp_atten_date, $to_date);
        $all_leaved_dates = $this->emp_leave_model->getallleavedate($content_id, $emp_atten_date, $to_date);
        $all_holiday_dates = $this->emp_holiday_model->getallholidaydate($user_division_id, $emp_atten_date, $to_date);
        $final_all_dates = $all_att_dates['att_dates'] . "," . $all_informed_dates['informed_dates'] . "," . $all_leaved_dates['leave_dates'] . "," . $all_holiday_dates['holiday_dates'];
        $final_all_dates_arr = explode(",", $final_all_dates);
        $date_range = dateRange($emp_atten_date, $to_date);
        $total_absent_dates = array_diff($date_range, $final_all_dates_arr);
        if ($date_range_beforejoining) {
            $total_absent_dates = array_diff($total_absent_dates, $date_range_beforejoining);
        }
        $data['total_abs_dates'] = $total_absent_dates;
        $counter_absent = 0;
        foreach ($total_absent_dates as $single_date) {
            $tstamp = strtotime($single_date);
            $dated_day_name = date("D", $tstamp);
            $dated_day_name = strtolower($dated_day_name);
            $offday_exist = $this->emp_weeklyholiday_history_model->getemp_weeklyholiday_historybydate($content_id, $single_date);
            if ($offday_exist['' . $dated_day_name . '_off'] != 'off') {
                $counter_absent++;
            }
        }
        if ($joining_year > $year) {
            $counter_absent = 0;
        }
        $data['total_absent'] = $counter_absent;
        // get all absent ends here;
        if ($user_type != 1) {
            $data['allemployee'] = $this->search_field_emp_model->getallemployeebydivision($user_division_id);
        } else {
            $data['allemployee'] = $this->search_field_emp_model->getallemployee();
        }
        $data['emp_holiday'] = $this->emp_holiday_model->getemp_holiday($default_emp_id['search_query']);
        $allleavetype_vid = 16;
        $data['allleavetype'] = $this->taxonomy->getTaxonomyByvid($allleavetype_vid);
        $mpdf = $this->pdf->load();
        $html = $this->load->view('print/print_absent_report_single_pdf', $data, true);
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetProtection(array('copy','print','modify'), 'r', 'MyPassword');
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output();
    }
    function updatelogintime()
    {
        $emp_atten = $this->emp_attendance_model->getemp_attendance_greaterthenlogout();

        foreach ($emp_atten as $single_atte) {
            $emp_login = $single_atte['login_time'];
            $emp_logout = $single_atte['logout_time'];
            $content_id = $single_atte['content_id'];
            $attendance_date = $single_atte['attendance_date'];
            if ($emp_logout) {

                $data = array(
                    'login_time'            =>  $emp_logout,
                    'logout_time'           =>  $emp_login,
                );

                $update_condition = array('content_id' => $content_id, 'attendance_date' => $attendance_date);
                $this->db->where($update_condition);
                $this->db->update('emp_attendance', $data);
                // $query = $this->db->query("UPDATE emp_attendance SET login_time = ?,  logout_time = ? WHERE content_id =? AND attendance_date=?",  
                //                array($emp_logout, $emp_login,$content_id, $attendance_date)); 
                // echo "<pre>";
                // print_r($str);
                // echo "</pre>";
                //$this->emp_attendance_model->updemp_attendancetbl($params, $update_condition);
            }
        }
        print "Done!";
    }

    function insertinformed()
    {
        $emp_atten = $this->emp_attendance_model->getemp_attendance_informed();

        foreach ($emp_atten as $single_atte) {
            $Dated = $single_atte['Dated'];
            $EmpIdentificationNo = $single_atte['EmpIdentificationNo'];
            $content_id = $this->employee_id_model->getemp_idby_empcode($EmpIdentificationNo);
            $Reason = $single_atte['Reason'];
            if ($content_id) {
                $emp_login_time = $post_data['emp_login_time'];
                $emp_logout_time = $post_data['emp_logout_time'];
                $presence_status = $post_data['presence_status'];
                $remarks = $post_data['remarks'];
                $data = array(
                    'emp_name'            =>  $EmpIdentificationNo,
                    'emp_login_time'            =>  "",
                    'emp_logout_time'            =>  "",
                    'presence_status'            =>  "P",
                    'remarks'            =>   $Reason,
                    'emp_attendance_date'           =>  $Dated,
                );
                $this->add_attendance_controller->add_attendance_action($data);
                // $update_condition=array('content_id' => $content_id, 'attendance_date' => $attendance_date);
                // $this->db->where($update_condition);
                // $this->db->update('emp_attendance', $data);
                // $query = $this->db->query("UPDATE emp_attendance SET login_time = ?,  logout_time = ? WHERE content_id =? AND attendance_date=?",  
                //                array($emp_logout, $emp_login,$content_id, $attendance_date)); 
                // echo "<pre>";
                // print_r($str);
                // echo "</pre>";
                //$this->emp_attendance_model->updemp_attendancetbl($params, $update_condition);
            }
        }
        print "Done!";
    }
}
