<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class PayrollReportController extends CI_Controller
{
        public $user_id;
        public $user_name;
        public $user_type;
        public $user_division;
        public $user_department;
        public $all_company_access;
    function __construct()
    {
        
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('Payroll_model');
        $this->user_id = $this->session->userdata('user_id');
        $this->user_name = $this->session->userdata('user_name');
        $this->user_type = $this->session->userdata('user_type');
        $this->user_division =  $this->session->userdata('user_division');
        $this->user_department =  $this->session->userdata('user_department');
        $this->all_company_access = $this->users_model->getuserwisepermission("all_company_access", $this->user_id);
    }
    public function paySlipReport()
    {
        $searchpage = "payslip_report";
        $user_id = $this->session->userdata('user_id');
        if ($this->input->post('add_btn')) {
            $year = $this->input->post('year');
            //$account_id = $this->input->post('account_id');
            $company = $this->input->post('emp_company');
            $division = $this->input->post('emp_division');
            $salaryMonth = $this->input->post('salary_month');
            $month = explode('-', $salaryMonth);
            $monthId = $month[0];
            $monthName = $month[1];
            $data['year'] = $year;
            $data['month_name'] = $monthName;
            $query = " payroll.year=$year AND payroll.month_id=$monthId AND payroll.status !=0 ";
            if ($company == 'all') {
                $data['company'] = 'All';
            } else {
                $data['company'] = $this->Payroll_model->getTaxonomyNameByTid($company);
                $query .= " AND payroll.company_id=$company";
            }
            if ($division == '') {
                $data['division'] = 'All';
            } else {
                $data['division'] = $this->Payroll_model->getTaxonomyNameByTid($division);
                $query .= " AND payroll.division_id=$division";
            }
            // search history section ---------       


            $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
            date_default_timezone_set('Asia/Dhaka');
            $servertime = time();
            $now = date("d-m-Y", $servertime);
            //$searchpage="payslip_confirmation";
            $params_contents = array(
                'id' => '',
                'search_query' => $query,
                'user_id' => $user_id,
                'table_view' => $data['company'],
                'per_page' => $data['division'],
                'month' => $data['month_name'],
                'year' => $data['year'],
                'search_page' => $searchpage,
                'search_date' => $now,
            );
            $this->db->insert("search_query", $params_contents);
            $data['search_record'] = true;
        }
        $default_info = $this->search_field_emp_model->getsearchQuery($searchpage);
        $data['company'] = $default_info['table_view'];
        $data['division'] = $default_info['per_page'];
        $data['year'] = $default_info['year'];
        $data['month_name'] = $default_info['month'];
        $search_query = $default_info['search_query'];
        $data['paySlips'] = $this->Payroll_model->getPaySlip($searchpage, $search_query);
        $data['months'] = $this->Payroll_model->getMonths();
        $userId = $this->session->userdata('user_id');
        $userType = $this->session->userdata('user_type');
        $userDivision = $this->session->userdata('user_division');
        $userDepartment = $this->session->userdata('user_department');

        if ($this->all_company_access['status'] == 1 || $this->usrtype == 1) {
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid(1);
        } else {
            if ($userDepartment) {
                $data['department_selected'] = $this->taxonomy->getTaxonomyBytid($userDepartment);
            } else {
                $data['department_selected'] = $this->taxonomy->getTaxonomychildbyparent($userDivision);
            }
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($userDivision);
        }
        $data['years'] = $this->db->query("SELECT * FROM tbl_years WHERE status=1")->result();

        $this->load->view("payroll/report/payslip", $data);
    }
    public function employeeWisePayslipReport()
    {
        $userType = $this->session->userdata('user_type');
        $userDivision = $this->session->userdata('user_division');
        $userDepartment = $this->session->userdata('user_department');

        if ($userType == 1) {
            $data['employees'] = $this->search_field_emp_model->getAllEmployees();
        } else {
            if (!$userDepartment) {
                $data['employees'] = $this->search_field_emp_model->getEmployeeByDivision($userDivision);
            } else {
                $data['employees'] = $this->search_field_emp_model->getEmployeeByDivisionAndDepartment($userDivision, $userDepartment);
            }
        }
        $this->load->view("payroll/report/employee-wise-payslip-report", $data);
    }
    public function salaryStatement()
    {
        $searchpage = "salary_statement";
        $user_id = $this->session->userdata('user_id');
        if ($this->input->post('add_btn')) {
            $year = $this->input->post('year');
            // $account_id = $this->input->post('account_id');

            $company = $this->input->post('emp_company');
            $division = $this->input->post('emp_division');
            $salaryMonth = $this->input->post('salary_month');
            $month = explode('-', $salaryMonth);
            $monthId = $month[0];
            $monthName = $month[1];
            $data['year'] = $year;
            $data['month_name'] = $monthName;
            $employee_type = explode('-', $this->input->post('employee_type'));
            $employee_type_id = $employee_type[0];
            $employee_type_name = $employee_type[1];
            $query = " payroll.year=$year AND payroll.month_id=$monthId AND payroll.status !=0 ";
            if ($division == 'all') {
                $data['division'] = 'All';
            } else {
                $data['company'] = $this->Payroll_model->getTaxonomyNameByTid($company);
                $query .= " AND payroll.company_id=$company";
            }
            if ($division == '') {
                $data['division'] = 'All';
            } else {
                $data['division'] = $this->Payroll_model->getTaxonomyNameByTid($division);
                $query .= " AND payroll.division_id=$division";
            }

            if ($employee_type_id == 'all') {
                $employee_type = 'All';
            } else {
                $employee_type = $employee_type_name;
                $query .= " AND sfe.type_of_employee=$employee_type_id";
            }
            // search history section ---------       


            $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
            date_default_timezone_set('Asia/Dhaka');
            $servertime = time();
            $now = date("d-m-Y", $servertime);
            //$searchpage="payslip_confirmation";
            $params_contents = array(
                'search_query' => $query,
                'user_id' => $user_id,
                'table_view' => $data['company'],
                'per_page' => $data['division'],
                'month' => $data['month_name'],
                'year' => $data['year'],
                'search_page' => $searchpage,
                'search_date' => $now,
                'level_one' =>  $employee_type,
            );
            $this->db->insert("search_query", $params_contents);
            $data['search_record'] = true;
        }
        if ($this->uri->segment(2)) {

            $format = $this->uri->segment(2);

            if ($format == 'excel') {
                $this->exportSalaryStatementExcel($searchpage);
            }
            // redirect('pay-slip-confirmation');
        }
        $default_info = $this->search_field_emp_model->getsearchQuery($searchpage);

        $data['company'] = $default_info['table_view'];
        $data['company_id'] = $company;
        $data['division'] = $default_info['per_page'];
        $data['division_id'] = $division;
        $data['year'] = $default_info['year'];
        $data['month_name'] = $default_info['month'];
        $search_query = $default_info['search_query'];

        $data['paySlips'] = $this->Payroll_model->getPaySlip($searchpage, $search_query);

        $data['months'] = $this->Payroll_model->getMonths();
        $userId = $this->session->userdata('user_id');
        $userType = $this->session->userdata('user_type');
        $userDivision = $this->session->userdata('user_division');
        $userDepartment = $this->session->userdata('user_department');
        if ($userId == 16 || $userId == 36 || $userType == 9 || $userType == 1) {
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid(1);
        } else {
            if ($userDepartment) {
                $data['department_selected'] = $this->taxonomy->getTaxonomyBytid($userDepartment);
            } else {
                $data['department_selected'] = $this->taxonomy->getTaxonomychildbyparent($userDivision);
            }
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($userDivision);
        }
        $data['years'] = $this->db->query("SELECT * FROM tbl_years WHERE status=1")->result();
        $data['employee_types'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=4 AND status=1")->result();
        #dd($data);
        $this->load->view("payroll/report/salary-statement", $data);
    }

    public function bankAdvice()
    {
        $searchpage = "bank_advice";
        $user_id = $this->session->userdata('user_id');
        if ($this->input->post('add_btn')) {
            $year = $this->input->post('year');
            // $account_id = $this->input->post('account_id');

            $company = $this->input->post('emp_company');
            $division = $this->input->post('emp_division');
            $salaryMonth = $this->input->post('salary_month');
            $month = explode('-', $salaryMonth);
            $monthId = $month[0];
            $monthName = $month[1];
            $data['year'] = $year;
            $data['month_name'] = $monthName;
            $query = " payroll.year=$year AND payroll.month_id=$monthId AND payroll.status !=0 AND payroll.status !=3 ";
            if ($division == 'all') {
                $data['division'] = 'All';
            } else {
                $data['company'] = $this->Payroll_model->getTaxonomyNameByTid($company);
                $query .= " AND payroll.company_id=$company";
            }
            if ($division == '') {
                $data['division'] = 'All';
            } else {
                $data['division'] = $this->Payroll_model->getTaxonomyNameByTid($division);
                $query .= " AND payroll.division_id=$division";
            }
            // search history section ---------       


            $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
            date_default_timezone_set('Asia/Dhaka');
            $servertime = time();
            $now = date("d-m-Y", $servertime);
            //$searchpage="payslip_confirmation";
            $params_contents = array(
                'id' => '',
                'search_query' => $query,
                'user_id' => $user_id,
                'table_view' => $data['company'],
                'per_page' => $data['division'],
                'month' => $data['month_name'],
                'year' => $data['year'],
                'search_page' => $searchpage,
                'search_date' => $now,
            );
            $this->db->insert("search_query", $params_contents);
            $data['search_record'] = true;
        }
        if ($this->uri->segment(2)) {
            $format = $this->uri->segment(2);
            if ($format == 'excel') {
                $this->exportSalaryStatementExcel($searchpage);
            }
            // redirect('pay-slip-confirmation');
        }
        $default_info = $this->search_field_emp_model->getsearchQuery($searchpage);
        $data['company'] = $default_info['table_view'];
        $data['company_id'] = $company;
        $data['division'] = $default_info['per_page'];
        $data['division_id'] = $division;
        $data['year'] = $default_info['year'];
        $data['month_name'] = $default_info['month'];
        $search_query = $default_info['search_query'];
        $data['paySlips'] = $this->Payroll_model->getPaySlip($searchpage, $search_query);
        $data['months'] = $this->Payroll_model->getMonths();
        $data['banks'] = $this->Payroll_model->getBanks(10);
        $userType = $this->session->userdata('user_type');
        $userDivision = $this->session->userdata('user_division');
        $userDepartment = $this->session->userdata('user_department');
        if ($userType == 1) {
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid(1);
        } else {
            if ($userDepartment) {
                $data['department_selected'] = $this->taxonomy->getTaxonomyBytid($userDepartment);
            } else {
                $data['department_selected'] = $this->taxonomy->getTaxonomychildbyparent($userDivision);
            }
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($userDivision);
        }
        $data['years'] = $this->db->query("SELECT * FROM tbl_years WHERE status=1")->result();

        $this->load->view("payroll/report/bank-advice", $data);
    }

    function salaryCertificate()
    {
        $searchpage = "salary_certificate";
        $user_id = $this->session->userdata('user_id');
        if ($this->input->post('export_btn')) {
            //            print_r($this->input->post());
            //            exit;
            $this->form_validation->set_rules('emp_name', 'Employee Name ', 'required');
            $this->form_validation->set_rules('salary_from', 'From Month ', 'required');
            $this->form_validation->set_rules('salary_to', 'To Month ', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
                redirect('salary-certificate');
            }
            $content_id = $this->input->post('emp_name');
            $salaryFrom = $this->input->post('salary_from');
            $salaryTo = $this->input->post('salary_to');
            if (strtotime($salaryFrom) > strtotime($salaryTo)) {
                $this->session->set_flashdata('errors', "Invalid date!");
                redirect('salary-certificate');
            }
            $salaryFromMonthId = date("m", strtotime($this->input->post('salary_from')));
            $salaryToMonthId = date("m", strtotime($this->input->post('salary_to')));
            $salaryFromYear = date("Y", strtotime($this->input->post('salary_from')));
            $salaryToYear = date("Y", strtotime($this->input->post('salary_to')));

            $data['salaryStartFrom'] = "$salaryFromYear-$salaryFromMonthId-01";
            $dateToTest = "$salaryToYear-$salaryToMonthId-01";
            $data['salaryEndTo'] = date('Y-m-t', strtotime($dateToTest));
            $data['payslip_info'] = $this->Payroll_model->getSalaryCerticatePayslipInfo($content_id, $salaryFromMonthId, $salaryFromYear, $salaryToMonthId, $salaryToYear);
            $this->load->model('challan_model');
            $data['challan_info'] = $this->challan_model->getChallanInfoByEmp($content_id, $salaryFromMonthId, $salaryFromYear, $salaryToMonthId, $salaryToYear);
            $this->load->library("pdf");
            $mPdf = $this->pdf->load();
            $data['employeeInfo'] = $this->search_field_emp_model->getEmployeeInfoById($content_id);
            $html = $this->load->view('payroll/report/salary-certificate-pdf', $data, true);
            //this the the PDF filename that user will get to download
            $pdfFilePath = "salary-certificate-of-" . $data['employeeInfo']->emp_name . ".pdf";
            //$mpdf->SetVisibility('printonly'); // This will be my code; 
            //$mPdf->SetJS('this.print();');
            $mPdf->WriteHTML(utf8_encode($html));
            //  $mPdf->Output($pdfFilePath, "D"); // Download
            $mPdf->Output($pdfFilePath, "I"); // Preview In browser
            // Preview In Firefox browser problem Issue: Menu Bar(Alt) >> Tools >> options >> General >> Applications >> PDF >> Select Action >>Preview in Firefox.
        }
        $data['months'] = $this->Payroll_model->getMonths();
        $userId = $this->session->userdata('user_id');
        $userType = $this->session->userdata('user_type');
        $userDivision = $this->session->userdata('user_division');
        $userDepartment = $this->session->userdata('user_department');

        if ($userType == 1 || $userType == 9) {
            $data['employees'] = $this->search_field_emp_model->getAllEmployees();
        } else {
            if (!$userDepartment) {
                $data['employees'] = $this->search_field_emp_model->getEmployeeByDivision($userDivision);
            } else {
                $data['employees'] = $this->search_field_emp_model->getEmployeeByDivisionAndDepartment($userDivision, $userDepartment);
            }
        }
        $this->load->view("payroll/report/salary-certificate", $data);
    }

    function exportSalaryStatementExcel($searchpage)
    {

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
            ->setSubject("(Salary Statement)")
            ->setDescription(
                "Salary Statement report for employee, generated by Smart HR Software."
            )
            ->setKeywords("Salary Statement")
            ->setCategory("Report");

        // Rename worksheet
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Salary Statement");
        // Set default row height
        // $sheet->getDefaultRowDimension()->setRowHeight(50);
        // $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL); // long width

        $sheet->getPageMargins()->setTop(0.50);
        $sheet->getPageMargins()->setRight(0.25);
        $sheet->getPageMargins()->setLeft(0.05);
        $sheet->getPageMargins()->setBottom(0.50);
        $sheet->getPageSetup()->setHorizontalCentered(true);
        $sheet->getPageSetup()->setVerticalCentered(false);
        // $spreadsheet->getActiveSheet()->getHeaderFooter()
        //        ->setOddHeader('&C&HPlease treat this document as confidential!');
        $sheet->getHeaderFooter()
            ->setOddFooter('&L&B' . $spreadsheet->getProperties()->getTitle() . '&RPage &P of &N');
        // end printer setup ------------------------------
        // Print image
        /*
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
        */
        $default_info = $this->search_field_emp_model->getsearchQuery($searchpage);
        $data['company'] = $default_info['table_view'];
        $data['division'] = $default_info['per_page'];
        $data['year'] = $default_info['year'];
        $data['month_name'] = $default_info['month'];
        $data['emlpoyee_type'] = $default_info['level_one'];
        $search_query = $default_info['search_query'];

        $monthName = $data['month_name'] . "' " . $data['year'];
        $getMonthVal = $sheet->getCell('A5')->getValue();
        $sheet->setCellValue('A5', $getMonthVal . $monthName);
        $sheet->setCellValue('A1', $data['company']);
        $sheet->setCellValue('A2', 'PFI Tower (Level-3), 56-57, Dilkusha C/A,Dhaka-1000, Bangladesh');
        $sheet->setCellValue('A3', $data['division']);
        $sheet->setCellValue('A4', "Emplyee Type: " . $data['emlpoyee_type']); //employee type

        // Start Loop
        $servertime = time();
        $now = date("d-m-Y H:i:s", $servertime);
        $row = 9;
        $no = 1;

        $data['paySlips'] = $this->Payroll_model->getPaySlip($searchpage, $search_query);
        //                    print_r($data['paySlips']);
        //                    exit;
        $totalEmployee = sizeof($data['paySlips']);
        //                    echo $totalEmployee; exit;
        $sheet->insertNewRowBefore(10, $totalEmployee);
            $grandTotalBasicSalary =
            $grandTotalHouseRent =
            $grandTotalMedical =
            $grandTotalConveyance  =
            $grandTotalEntertainment =
            $grandTotalHouseMaintenanceAllowance =
            $grandTotalTotalAllowance =
            $grandTotalArrearSalary =
            $grandTotalArrearPF =
            $grandTotalPFContribution =
            $grandTotalGrossSalary =
            $grandTotalPFSubscriptionAndContribution =
            $grandTotalAITEmployee =
            $grandTotalstaffLoan =
            $grandTotalTotalDeduction =
            $grandTotalNetPayable = 0;
        foreach ($data['paySlips'] as $paySlip) {
            $sheet->getStyle('A' . $row . ':' . 'AG' . $row)
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('G' . $row . ':' . 'AF' . $row)->getNumberFormat()
                ->setFormatCode('#,##0');
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $paySlip->grade_name);
            $sheet->setCellValue('C' . $row, $paySlip->emp_id);
            $sheet->setCellValue('D' . $row, $paySlip->emp_name);
            // set wrap text
            $sheet->getStyle('D' . $row)->getAlignment()->setWrapText(true);
            $sheet->setCellValue('E' . $row, $paySlip->designation_name);
            $sheet->getStyle('E' . $row)->getAlignment()->setWrapText(true);
            $grossSalary = $paySlip->gross_salary;
            $basicSalary =  $paySlip->basic;
            $houseRent =  $paySlip->hra;
            $medical =  $paySlip->ma;
            $convayence =  $paySlip->ca;
            $entertainment =  $paySlip->ea;
            $houseMaintenanceAllowance =  $paySlip->hma;
            $totalAllowance = $houseRent + $medical + $convayence + $entertainment;
            $sheet->setCellValue('F' . $row, $basicSalary);
            $sheet->setCellValue('G' . $row, $houseRent);
            $sheet->setCellValue('H' . $row, $medical);
            $sheet->setCellValue('I' . $row, $convayence);
            $sheet->setCellValue('J' . $row, $entertainment);
            $sheet->setCellValue('K' . $row, $houseMaintenanceAllowance);
            $sheet->setCellValue('L' . $row, $totalAllowance);

            $sheet->setCellValue('M' . $row, $paySlip->arear); 
            $sheet->setCellValue('N' . $row, $paySlip->arrear_pf); 
            $sheet->setCellValue('O' . $row, $paySlip->pf); 
            $sheet->setCellValue('P' . $row, $grossSalary); 
            $sheet->setCellValue('Q' . $row, $paySlip->pf * 2); 
            $sheet->setCellValue('R' . $row, $paySlip->tax); 
            $sheet->setCellValue('S' . $row, $paySlip->loan); 
            $totalDeduction = ($paySlip->pf * 2) + $paySlip->tax + $paySlip->loan;
            $sheet->setCellValue('T' . $row, $totalDeduction); 
            $sheet->setCellValue('U' . $row, $paySlip->net_salary); 
            $sheet->setCellValue('V' . $row, $paySlip->bank_account_no); 
            $sheet->setCellValue('W' . $row, $paySlip->bank_name); 
            $sheet->setCellValue('X' . $row, $paySlip->branch_name); 
            $grandTotalBasicSalary += $paySlip->basic;
            $grandTotalHouseRent += $paySlip->hra;
            $grandTotalMedical += $paySlip->ma;
            $grandTotalConveyance  += $paySlip->ca;
            $grandTotalEntertainment += $paySlip->ea;
            $grandTotalHouseMaintenanceAllowance += $paySlip->hma;
            $grandTotalTotalAllowance += $totalAllowance;
            $grandTotalArrearSalary += $paySlip->arear;
            $grandTotalArrearPF += $paySlip->arrear_pf;
            $grandTotalPFContribution += $paySlip->pf;
            $grandTotalGrossSalary += $paySlip->gross_salary;
            $grandTotalPFSubscriptionAndContribution += ($paySlip->pf*2);
            $grandTotalAITEmployee += $paySlip->tax;
            $grandTotalstaffLoan += $paySlip->loan;
            $grandTotalTotalDeduction += $totalDeduction;
            $grandTotalNetPayable += $paySlip->net_salary;
            $row++;
            $no++;
        }
        // End Loop
        $row = $row + 1;

        $sheet->getStyle('A' . $row . ':' . 'AF' . $row)
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G' . $row . ':' . 'AF' . $row)->getNumberFormat()
            ->setFormatCode('#,##0');
        $sheet->getStyle('E' . $row . ':' . 'AF' . $row)->getFont()->setBold(TRUE);
        
        $sheet->setCellValue('F' . $row, $grandTotalBasicSalary);
        $sheet->setCellValue('G' . $row, $grandTotalHouseRent);
        $sheet->setCellValue('H' . $row, $grandTotalMedical);
        $sheet->setCellValue('I' . $row, $grandTotalConveyance);
        $sheet->setCellValue('J' . $row, $grandTotalEntertainment);
        $sheet->setCellValue('K' . $row, $grandTotalHouseMaintenanceAllowance);
        $sheet->setCellValue('L' . $row, $grandTotalTotalAllowance);
        $sheet->setCellValue('M' . $row, $grandTotalArrearSalary);
        $sheet->setCellValue('N' . $row, $grandTotalArrearPF);
        $sheet->setCellValue('O' . $row, $grandTotalPFContribution);
        $sheet->setCellValue('P' . $row, $grandTotalGrossSalary);
        $sheet->setCellValue('Q' . $row, $grandTotalPFSubscriptionAndContribution);
        $sheet->setCellValue('R' . $row, $grandTotalAITEmployee);
        $sheet->setCellValue('S' . $row, $grandTotalstaffLoan);
        $sheet->setCellValue('T' . $row, $grandTotalTotalDeduction);
        $sheet->setCellValue('U' . $row, $grandTotalNetPayable);
        $row = $row + 7;

        $sheet->setCellValue('A' . $row, "Report generated by HR Software at " . $now);
       
        $writer = new Xlsx($spreadsheet);
        $now = date("d-m-Y_H:i:s", $servertime);
        $filename = 'Salary-statement-report-of-' . str_replace(' ', '-', $data['division'] . "-" . $monthName) . "-" . $now;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output'); // download file 
        die();
    }

    function exportBankAdvice()
    {
        $post_data = $this->input->post();
        $exportType = $post_data['export_bank_advice'];

        if ($exportType == 'export_pdf') {
            //             echo $exportType;
            $this->bankAdvicePdf($post_data);
        } else if ($exportType == 'export_excel') {
            //             echo $exportType;
            $this->bankAdviceExcel($post_data);
        } else {
        }
    }

    function bankAdvicePdf($post_data)
    {
        $exportType = $post_data['export_bank_advice'];
        $searchPage = "bank_advice";
        $data = array();
        $data['company'] = $post_data['company'];
        $data['division'] = $post_data['division'];
        $data['month'] = $post_data['month_name'];
        $data['year'] = $post_data['year'];
        $data['bankName'] = $post_data['bank_name'];
        $data['bankAddress'] = $post_data['bank_address'];
        $data['bankAccountNo'] = $post_data['bank_account_no'];
        // $payslipIds = implode(",",$post_data['payslip_id']);   
        $payslipIds = $post_data['payslip_id'];
        if ($payslipIds) {
            $data['paySlips'] = $this->Payroll_model->getSeletedPayslip($payslipIds);
        } else {
            $default_info = $this->search_field_emp_model->getsearchQuery($searchPage);
            $search_query = $default_info['search_query'];
            $data['paySlips'] = $this->Payroll_model->getPaySlip($searchPage, $search_query);
        }
        $this->load->library("pdf");
        $mPdf = $this->pdf->load();
        $html = $this->load->view('payroll/report/bank-advice-pdf', $data, true);
        //this the the PDF filename that user will get to download
        $pdfFilePath = "bank-advice-of-" . $data['company'] . ".pdf";
        //$mpdf->SetVisibility('printonly'); // This will be my code; 
        //        $mPdf->SetWatermarkText("PÉROLA NEGRA");
        //        $mPdf->showWatermarkText = true;
        //        $mPdf->watermark_font = 'DejaVuSansCondensed';
        //        $mPdf->watermarkTextAlpha = 0.1;
        //        $mPdf->SetDisplayMode('fullpage');
        //        $mPdf->SetHTMLHeader(utf8_encode(get_partial('header')));
        //        $mPdf->SetHTMLFooter(utf8_encode(get_partial('footer')));
        //        $mPdf->SetMargins(500, 500, 65);

        $mPdf->SetJS('this.print();');
        $mPdf->WriteHTML(utf8_encode($html));
        $mPdf->Output($pdfFilePath, "D");
    }

    function bankAdviceExcel($post_data)
    {
        /* Loading a Workbook from a file */
        $inputFileName = './resources/files/bank-advice.xlsx';
        /** Load $inputFileName to a Spreadsheet object * */
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
        $spreadsheet->getActiveSheet()->getPageSetup()
            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);

        $spreadsheet->getProperties()
            ->setCreator("HR Software")
            ->setLastModifiedBy("")
            ->setTitle("Bank Advice Report")
            ->setSubject($data['defsultdivision_name'] . "(Bank Advice)")
            ->setDescription(
                "Bank Advice report for employee, generated by Ahmed Amin Group HR Software."
            )
            ->setKeywords("Bank Advice")
            ->setCategory("Report");

        // Rename worksheet
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Bank Advice");
        // Set default row height
        // $sheet->getDefaultRowDimension()->setRowHeight(50);
        // $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4); // long width

        $sheet->getPageMargins()->setTop(1.75); // inch
        $sheet->getPageMargins()->setRight(0.50);
        $sheet->getPageMargins()->setLeft(0.50);
        $sheet->getPageMargins()->setBottom(1.50);
        $sheet->getPageSetup()->setHorizontalCentered(true);
        $sheet->getPageSetup()->setVerticalCentered(false);
        // $spreadsheet->getActiveSheet()->getHeaderFooter()
        //        ->setOddHeader('&C&HPlease treat this document as confidential!');
        $sheet->getHeaderFooter()
            ->setOddFooter('&L&B' . $spreadsheet->getProperties()->getTitle() . '&RPage &P of &N');
        // end printer setup ------------------------------
        // Print image
        /*
          $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
          $drawing->setName('Logo');
          $drawing->setDescription('Logo');
          $drawing->setPath('./resources/images/logo.png');
          $drawing->setCoordinates('A1');
          $drawing->setHeight(70); // image height
          $drawing->setOffsetX(10); //margin left
          $drawing->setOffsetY(10); // margin top
          $drawing->setRotation(0); // image rotaion
          $drawing->getShadow()->setVisible(true); // image shadow
          $drawing->getShadow()->setDirection(45);
          $drawing->setWorksheet($sheet);
         */
        $exportType = $post_data['export_bank_advice'];
        $searchPage = "bank_advice";
        $data = array();

        $data['company'] = $post_data['company'];
        $data['division'] = $post_data['division'];
        $data['month'] = $post_data['month_name'];
        $data['year'] = $post_data['year'];
        $bankName = $post_data['bank_name'];
        $bankAddress = $post_data['bank_address'];
        $bankAccountNo = "" . $post_data['bank_account_no'] . "";

        $payslipIds = $post_data['payslip_id'];
        if ($payslipIds) {
            $data['paySlips'] = $this->Payroll_model->getSeletedPayslip($payslipIds);
        } else {
            $default_info = $this->search_field_emp_model->getsearchQuery($searchPage);
            $search_query = $default_info['search_query'];
            $data['paySlips'] = $this->Payroll_model->getPaySlip($searchPage, $search_query);
        }

        $sheet->setCellValue('A1', "Date: " . $this->currentDate());
        $sheet->setCellValue('A4', $bankName);
        $sheet->setCellValue('A5', $bankAddress);
        $sheet->setCellValue('A7', "Sub: Request for fund transfer as salary and allowances for the month of " . $data['month'] . ", " . $data['year']);

        // Start Loop
        $servertime = time();
        $now = date("d-m-Y H:i:s", $servertime);
        $row = 16;
        $no = 1;
        $totalEmployee = sizeof($data['paySlips']);
        //                    echo $totalEmployee; exit;
        $sheet->insertNewRowBefore(17, $totalEmployee);

        foreach ($data['paySlips'] as $paySlip) {
            $sheet->setCellValue('A' . $row, $no++);
            //            $sheet->setCellValue('B' . $row, $paySlip->emp_id);
            $sheet->setCellValue('B' . $row, $paySlip->emp_name);
            $sheet->setCellValue('C' . $row, $paySlip->emp_bank_account);
            $amt = $paySlip->net_salary - $paySlip->total_paid;
            $sheet->setCellValue('D' . $row, $amt);
            $totalAmt += $amt;
            $row++;
        }
        $totalInWords = $this->convert_number_to_words($totalAmt);
        $sheet->setCellValue('A11', "Kindly refer to subject mentioned above, please transfer Tk. " . number_format($totalAmt) . " (" . $totalInWords . "  taka only.)  from account no " . $bankAccountNo . " name: " . $data['company'] . " to under mentioned account numbers and account names being maintained with your Bank.");

        // End Loop        
        $sheet->setCellValue('A' . $row, "TOTAL");
        $sheet->setCellValue('D' . $row, $totalAmt);
        $sheet->getStyle('A' . $row)->getFont()->setBold(TRUE);
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],
            //            'borders' => [
            //                'top' => [
            //                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            //                ],
            //            ],
            //            'fill' => [
            //                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
            //                'rotation' => 90,
            //                'startColor' => [
            //                    'argb' => 'FFA0A0A0',
            //                ],
            //                'endColor' => [
            //                    'argb' => 'FFFFFFFF',
            //                ],
            //            ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('D' . $row)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->getStyle('A' . $row . ':D' . $row)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('87CEEB');
        $writer = new Xlsx($spreadsheet);
        $now = date("d-m-Y_H:i:s", $servertime);
        $filename = 'Bank-Advice-of-' . $data['company'];

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename);
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer->save('php://output'); // download file 
        die();
    }

    # Provident Fund Statement
    function providentFundStatement()
    {
        $this->check_permission_controller->check_permission_action("provident_fund_statement");
        $title = "Provident Fund Statement";
        $table = 'tbl_pf_payments';
        $route = 'provident-fund-statement';
        if ($this->input->post()) {
            #dd($this->input->post());
            $this->form_validation->set_rules('content_id', 'Employee', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {

                $content_id = $this->input->post('content_id');
                $year = $this->input->post('financial_year');
                $payment_type = $this->input->post('payment_type');


                if ($content_id) {
                    $this->load->model('search_field_emp_model');
                    $employeeInfo = $this->search_field_emp_model->getEmployeeInfoById($content_id);
                    $this->db->select('ma.*,month.month_name');
                    $this->db->from("$table as ma");
                    $this->db->join('tbl_month as month', 'month.id = ma.adjust_month', 'LEFT');
                    $this->db->where('ma.content_id', $content_id);

                    if ($year) {
                        $this->db->where('ma.adjust_year', $year);
                    }
                    if ($payment_type) {
                        $this->db->where('ma.payment_type', $payment_type);
                    }
                    $query = $this->db->get();
                    $html = '
                        <style>
                        th{
                            font-size:10px;
                            text-align:left
                        }
                        </style>
                    <table id="table2excel" class="table2excel_with_colors table table-striped custom-table mb-0">
                    <thead>';
                    $html .= '<tr>
                        <th colspan="8" style="text-align:center;font-size:20px;background-color:#CCC">' . $title . '</th>
                    </tr>';
                    $html .= '<tr>
                    <th>Employee Name:</th>
                    <th >' . $employeeInfo->emp_name . '</th>
                    <th>Employee ID:</th>
                    <th >' . $employeeInfo->emp_id . '</th>
                    <th >Company Name: </th>
                    <th >' . $employeeInfo->company_name . '</th>
                    <th >Division: </th>
                    <th >' . $employeeInfo->division_name . '</th>
                    
                </tr>';
                    $html .= '<tr>
                    <th>Department Name:</th>
                    <th >' . $employeeInfo->department_name . '</th>
                    <th >Designation: </th>
                    <th >' . $employeeInfo->designation_name . '</th>
                    <th >Type Of Employe: </th>
                    <th >' . $employeeInfo->type_of_emp_name . '</th>
                    <th >Grade Name: </th>
                    <th >' . $employeeInfo->grade_name . '</th>
                    
                </tr>';
                    $html .= '<tr style="background-color:#CCC">
                    <th>SL NO</th>
                    <th>Payment Date</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>amount</th>
                    <th>payment_type</th>
                    <th>remarks</th>
                    <th>status</th>
                </tr>';
                    $html .= '</thead>
                    <tbody>';
                    if ($query->num_rows() > 0) {

                        $totalAmt = 0;
                        foreach ($query->result() as $key => $val) {
                            $status = $val->status == 1 ? 'Pending' : 'paid';
                            $html .=
                                '<tr><td>' . ($key + 1) .
                                '</td><td>' . $val->payment_date .
                                '</td><td>' . $val->month_name .
                                '</td><td>' . $val->adjust_year .
                                '</td><td>' . $val->amount .
                                '</td><td>' . $val->payment_type .
                                '</td><td>' . $val->remarks .
                                '</td><td>' . $status  .
                                '</td></tr>';
                            $totalAmt += $val->amount;
                        }
                    } else {
                        $html .= '<tr><td colspan="8" style="text-align:center">No data found.</td></tr>';
                    }
                    $html .= '</tbody><tfoot>
                            <tr>
                            <td colspan="4">TOTAL</td>
                            <td>' . $totalAmt . '</td>
                            <td colspan="3"></td>
                            </tr>
                        </tfoot>';
                    $html .= '</table>';
                    echo $html;
                    return false;
                } else {
                    echo "SORRY! Employee undefine.";
                }
            }
        }
        $data['title'] = $title;
        $data['route'] = $route;
        $data['years'] = $this->db->query("SELECT * FROM tbl_years /*where status=1*/")->result();
        $data['employees'] = $this->db->query("SELECT * FROM search_field_emp")->result();
        $this->load->view('reports/payroll/pf_payment_statement', $data);
    }
    # Advance Salary
    function advanceSalaryStatement()
    {
        $this->check_permission_controller->check_permission_action("advance_salary_statement");
        $searchpage = "advance_salary_statement";
        if ($this->input->post()) {
            #dd($this->input->post());
            $this->form_validation->set_rules('content_id', 'Employee', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {

                $content_id = $this->input->post('content_id');
                $year = $this->input->post('financial_year');
                $payment_type = $this->input->post('payment_type');


                if ($content_id) {
                    $this->load->model('search_field_emp_model');
                    $employeeInfo = $this->search_field_emp_model->getEmployeeInfoById($content_id);
                    $this->db->select('ma.*,month.month_name');
                    $this->db->from("tbl_advance_salary as ma");
                    $this->db->join('tbl_month as month', 'month.id = ma.adjust_month', 'LEFT');
                    $this->db->where('ma.content_id', $content_id);

                    if ($year) {
                        $this->db->where('ma.adjust_year', $year);
                    }
                    if ($payment_type) {
                        $this->db->where('ma.payment_type', $payment_type);
                    }
                    $query = $this->db->get();
                    $html = '
                        <style>
                        th{
                            font-size:10px;
                            text-align:left
                        }
                        </style>
                    <table id="table2excel" class="table2excel_with_colors table table-striped custom-table mb-0">
                    <thead>';
                    $html .= '<tr>
                        <th colspan="8" style="text-align:center;font-size:20px;background-color:#CCC">Advance Salary Statement</th>
                    </tr>';
                    $html .= '<tr>
                    <th>Employee Name:</th>
                    <th >' . $employeeInfo->emp_name . '</th>
                    <th>Employee ID:</th>
                    <th >' . $employeeInfo->emp_id . '</th>
                    <th >Company Name: </th>
                    <th >' . $employeeInfo->company_name . '</th>
                    <th >Division: </th>
                    <th >' . $employeeInfo->division_name . '</th>
                    
                </tr>';
                    $html .= '<tr>
                    <th>Department Name:</th>
                    <th >' . $employeeInfo->department_name . '</th>
                    <th >Designation: </th>
                    <th >' . $employeeInfo->designation_name . '</th>
                    <th >Type Of Employe: </th>
                    <th >' . $employeeInfo->type_of_emp_name . '</th>
                    <th >Grade Name: </th>
                    <th >' . $employeeInfo->grade_name . '</th>
                    
                </tr>';
                    $html .= '<tr style="background-color:#CCC">
                    <th>SL NO</th>
                    <th>Payment Date</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>amount</th>
                    <th>payment_type</th>
                    <th>remarks</th>
                    <th>status</th>
                </tr>';
                    $html .= '</thead>
                    <tbody>';
                    if ($query->num_rows() > 0) {

                        $totalAmt = 0;
                        foreach ($query->result() as $key => $val) {
                            $status = $val->status == 1 ? 'Pending' : 'paid';
                            $html .=
                                '<tr><td>' . ($key + 1) .
                                '</td><td>' . $val->payment_date .
                                '</td><td>' . $val->month_name .
                                '</td><td>' . $val->adjust_year .
                                '</td><td>' . $val->amount .
                                '</td><td>' . $val->payment_type .
                                '</td><td>' . $val->remarks .
                                '</td><td>' . $status  .
                                '</td></tr>';
                            $totalAmt += $val->amount;
                        }
                    } else {
                        $html .= '<tr><td colspan="8" style="text-align:center">No data found.</td></tr>';
                    }
                    $html .= '</tbody><tfoot>
                            <tr>
                            <td colspan="4">TOTAL</td>
                            <td>' . $totalAmt . '</td>
                            <td colspan="3"></td>
                            </tr>
                        </tfoot>';
                    $html .= '</table>';
                    echo $html;
                    return false;
                } else {
                    echo "SORRY! Employee undefine.";
                }
            }
        }
        $data['years'] = $this->db->query("SELECT * FROM tbl_years /*where status=1*/")->result();
        $data['employees'] = $this->db->query("SELECT * FROM search_field_emp")->result();
        $this->load->view('reports/payroll/advance_salary_statement', $data);
    }
    # Gratuity
    function gratuityStatement()
    {
        $this->check_permission_controller->check_permission_action("gratuity_statement");
        $title = "Gratuity Statement";
        $route = 'gratuity-statement';
        $table = 'tbl_gratuity';
        if ($this->input->post()) {
            #dd($this->input->post());
            $this->form_validation->set_rules('content_id', 'Employee', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {

                $content_id = $this->input->post('content_id');
                $year = $this->input->post('financial_year');
                $payment_type = $this->input->post('payment_type');


                if ($content_id) {
                    $this->load->model('search_field_emp_model');
                    $employeeInfo = $this->search_field_emp_model->getEmployeeInfoById($content_id);
                    $this->db->select('ma.*,month.month_name');
                    $this->db->from("$table as ma");
                    $this->db->join('tbl_month as month', 'month.id = ma.adjust_month', 'LEFT');
                    $this->db->where('ma.content_id', $content_id);

                    if ($year) {
                        $this->db->where('ma.adjust_year', $year);
                    }
                    if ($payment_type) {
                        $this->db->where('ma.payment_type', $payment_type);
                    }
                    $query = $this->db->get();
                    $html = '
                        <style>
                        th{
                            font-size:10px;
                            text-align:left
                        }
                        </style>
                    <table id="table2excel" class="table2excel_with_colors table table-striped custom-table mb-0">
                    <thead>';
                    $html .= '<tr>
                        <th colspan="8" style="text-align:center;font-size:20px;background-color:#CCC">' . $title . '</th>
                    </tr>';
                    $html .= '<tr>
                    <th>Employee Name:</th>
                    <th >' . $employeeInfo->emp_name . '</th>
                    <th>Employee ID:</th>
                    <th >' . $employeeInfo->emp_id . '</th>
                    <th >Company Name: </th>
                    <th >' . $employeeInfo->company_name . '</th>
                    <th >Division: </th>
                    <th >' . $employeeInfo->division_name . '</th>
                    
                </tr>';
                    $html .= '<tr>
                    <th>Department Name:</th>
                    <th >' . $employeeInfo->department_name . '</th>
                    <th >Designation: </th>
                    <th >' . $employeeInfo->designation_name . '</th>
                    <th >Type Of Employe: </th>
                    <th >' . $employeeInfo->type_of_emp_name . '</th>
                    <th >Grade Name: </th>
                    <th >' . $employeeInfo->grade_name . '</th>
                    
                </tr>';
                    $html .= '<tr style="background-color:#CCC">
                    <th>SL NO</th>
                    <th>Payment Date</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>amount</th>
                    <th>payment_type</th>
                    <th>remarks</th>
                    <th>status</th>
                </tr>';
                    $html .= '</thead>
                    <tbody>';
                    if ($query->num_rows() > 0) {

                        $totalAmt = 0;
                        foreach ($query->result() as $key => $val) {
                            $status = $val->status == 1 ? 'Pending' : 'paid';
                            $html .=
                                '<tr><td>' . ($key + 1) .
                                '</td><td>' . $val->payment_date .
                                '</td><td>' . $val->month_name .
                                '</td><td>' . $val->adjust_year .
                                '</td><td>' . $val->amount .
                                '</td><td>' . $val->payment_type .
                                '</td><td>' . $val->remarks .
                                '</td><td>' . $status  .
                                '</td></tr>';
                            $totalAmt += $val->amount;
                        }
                    } else {
                        $html .= '<tr><td colspan="8" style="text-align:center">No data found.</td></tr>';
                    }
                    $html .= '</tbody><tfoot>
                            <tr>
                            <td colspan="4">TOTAL</td>
                            <td>' . $totalAmt . '</td>
                            <td colspan="3"></td>
                            </tr>
                        </tfoot>';
                    $html .= '</table>';
                    echo $html;
                    return false;
                } else {
                    echo "SORRY! Employee undefine.";
                }
            }
        }
        $data['title'] = $title;
        $data['route'] = $route;
        $data['years'] = $this->db->query("SELECT * FROM tbl_years /*where status=1*/")->result();
        $data['employees'] = $this->db->query("SELECT * FROM search_field_emp")->result();
        $this->load->view('reports/payroll/gratuity_statement', $data);
    }
    # Incentive
    function incentiveStatement()
    {
        $this->check_permission_controller->check_permission_action("incentive_statement");
        $title = "Incentive Statement";
        $route = 'incentive-statement';
        $table = 'tbl_incentive';
        if ($this->input->post()) {
            #dd($this->input->post());
            $this->form_validation->set_rules('content_id', 'Employee', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {

                $content_id = $this->input->post('content_id');
                $year = $this->input->post('financial_year');
                $payment_type = $this->input->post('payment_type');


                if ($content_id) {
                    $this->load->model('search_field_emp_model');
                    $employeeInfo = $this->search_field_emp_model->getEmployeeInfoById($content_id);
                    $this->db->select('ma.*,month.month_name');
                    $this->db->from("$table as ma");
                    $this->db->join('tbl_month as month', 'month.id = ma.adjust_month', 'LEFT');
                    $this->db->where('ma.content_id', $content_id);

                    if ($year) {
                        $this->db->where('ma.adjust_year', $year);
                    }
                    if ($payment_type) {
                        $this->db->where('ma.payment_type', $payment_type);
                    }
                    $query = $this->db->get();
                    $html = '
                        <style>
                        th{
                            font-size:10px;
                            text-align:left
                        }
                        </style>
                    <table id="table2excel" class="table2excel_with_colors table table-striped custom-table mb-0">
                    <thead>';
                    $html .= '<tr>
                        <th colspan="8" style="text-align:center;font-size:20px;background-color:#CCC">' . $title . '</th>
                    </tr>';
                    $html .= '<tr>
                    <th>Employee Name:</th>
                    <th >' . $employeeInfo->emp_name . '</th>
                    <th>Employee ID:</th>
                    <th >' . $employeeInfo->emp_id . '</th>
                    <th >Company Name: </th>
                    <th >' . $employeeInfo->company_name . '</th>
                    <th >Division: </th>
                    <th >' . $employeeInfo->division_name . '</th>
                    
                </tr>';
                    $html .= '<tr>
                    <th>Department Name:</th>
                    <th >' . $employeeInfo->department_name . '</th>
                    <th >Designation: </th>
                    <th >' . $employeeInfo->designation_name . '</th>
                    <th >Type Of Employe: </th>
                    <th >' . $employeeInfo->type_of_emp_name . '</th>
                    <th >Grade Name: </th>
                    <th >' . $employeeInfo->grade_name . '</th>
                    
                </tr>';
                    $html .= '<tr style="background-color:#CCC">
                    <th>SL NO</th>
                    <th>Payment Date</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>amount</th>
                    <th>payment_type</th>
                    <th>remarks</th>
                    <th>status</th>
                </tr>';
                    $html .= '</thead>
                    <tbody>';
                    if ($query->num_rows() > 0) {

                        $totalAmt = 0;
                        foreach ($query->result() as $key => $val) {
                            $status = $val->status == 1 ? 'Pending' : 'paid';
                            $html .=
                                '<tr><td>' . ($key + 1) .
                                '</td><td>' . $val->payment_date .
                                '</td><td>' . $val->month_name .
                                '</td><td>' . $val->adjust_year .
                                '</td><td>' . $val->amount .
                                '</td><td>' . $val->payment_type .
                                '</td><td>' . $val->remarks .
                                '</td><td>' . $status  .
                                '</td></tr>';
                            $totalAmt += $val->amount;
                        }
                    } else {
                        $html .= '<tr><td colspan="8" style="text-align:center">No data found.</td></tr>';
                    }
                    $html .= '</tbody><tfoot>
                            <tr>
                            <td colspan="4">TOTAL</td>
                            <td>' . $totalAmt . '</td>
                            <td colspan="3"></td>
                            </tr>
                        </tfoot>';
                    $html .= '</table>';
                    echo $html;
                    return false;
                } else {
                    echo "SORRY! Employee undefine.";
                }
            }
        }
        $data['title'] = $title;
        $data['route'] = $route;
        $data['years'] = $this->db->query("SELECT * FROM tbl_years /*where status=1*/")->result();
        $data['employees'] = $this->db->query("SELECT * FROM search_field_emp")->result();
        $this->load->view('reports/payroll/incentive_statement', $data);
    }
    # Festival Bonus
    function festivalBonusStatement()
    {
        $this->check_permission_controller->check_permission_action("festival_bonus_statement");
        $title = "Festival Bonus Statement";
        $route = 'festival-bonus-statement';
        $table = 'tbl_festival_bonus';
        if ($this->input->post()) {
            #dd($this->input->post());
            $this->form_validation->set_rules('content_id', 'Employee', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {

                $content_id = $this->input->post('content_id');
                $year = $this->input->post('financial_year');
                $payment_type = $this->input->post('payment_type');


                if ($content_id) {
                    $this->load->model('search_field_emp_model');
                    $employeeInfo = $this->search_field_emp_model->getEmployeeInfoById($content_id);
                    $this->db->select('ma.*,month.month_name');
                    $this->db->from("$table as ma");
                    $this->db->join('tbl_month as month', 'month.id = ma.adjust_month', 'LEFT');
                    $this->db->where('ma.content_id', $content_id);

                    if ($year) {
                        $this->db->where('ma.adjust_year', $year);
                    }
                    if ($payment_type) {
                        $this->db->where('ma.payment_type', $payment_type);
                    }
                    $query = $this->db->get();
                    $html = '
                        <style>
                        th{
                            font-size:10px;
                            text-align:left
                        }
                        </style>
                    <table id="table2excel" class="table2excel_with_colors table table-striped custom-table mb-0">
                    <thead>';
                    $html .= '<tr>
                        <th colspan="8" style="text-align:center;font-size:20px;background-color:#CCC">' . $title . '</th>
                    </tr>';
                    $html .= '<tr>
                    <th>Employee Name:</th>
                    <th >' . $employeeInfo->emp_name . '</th>
                    <th>Employee ID:</th>
                    <th >' . $employeeInfo->emp_id . '</th>
                    <th >Company Name: </th>
                    <th >' . $employeeInfo->company_name . '</th>
                    <th >Division: </th>
                    <th >' . $employeeInfo->division_name . '</th>
                    
                </tr>';
                    $html .= '<tr>
                    <th>Department Name:</th>
                    <th >' . $employeeInfo->department_name . '</th>
                    <th >Designation: </th>
                    <th >' . $employeeInfo->designation_name . '</th>
                    <th >Type Of Employe: </th>
                    <th >' . $employeeInfo->type_of_emp_name . '</th>
                    <th >Grade Name: </th>
                    <th >' . $employeeInfo->grade_name . '</th>
                    
                </tr>';
                    $html .= '<tr style="background-color:#CCC">
                    <th>SL NO</th>
                    <th>Payment Date</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>amount</th>
                    <th>payment_type</th>
                    <th>remarks</th>
                    <th>status</th>
                </tr>';
                    $html .= '</thead>
                    <tbody>';
                    if ($query->num_rows() > 0) {

                        $totalAmt = 0;
                        foreach ($query->result() as $key => $val) {
                            $status = $val->status == 1 ? 'Pending' : 'paid';
                            $html .=
                                '<tr><td>' . ($key + 1) .
                                '</td><td>' . $val->payment_date .
                                '</td><td>' . $val->month_name .
                                '</td><td>' . $val->adjust_year .
                                '</td><td>' . $val->amount .
                                '</td><td>' . $val->payment_type .
                                '</td><td>' . $val->remarks .
                                '</td><td>' . $status  .
                                '</td></tr>';
                            $totalAmt += $val->amount;
                        }
                    } else {
                        $html .= '<tr><td colspan="8" style="text-align:center">No data found.</td></tr>';
                    }
                    $html .= '</tbody><tfoot>
                            <tr>
                            <td colspan="4">TOTAL</td>
                            <td>' . $totalAmt . '</td>
                            <td colspan="3"></td>
                            </tr>
                        </tfoot>';
                    $html .= '</table>';
                    echo $html;
                    return false;
                } else {
                    echo "SORRY! Employee undefine.";
                }
            }
        }
        $data['title'] = $title;
        $data['route'] = $route;
        $data['years'] = $this->db->query("SELECT * FROM tbl_years /*where status=1*/")->result();
        $data['employees'] = $this->db->query("SELECT * FROM search_field_emp")->result();
        $this->load->view('reports/payroll/festival_bonus_statement', $data);
    }
    # Performance Bonus
    function performanceBonusStatement()
    {
        $this->check_permission_controller->check_permission_action("performance_bonus_statement");
        $title = "Performance Bonus Statement";
        $route = 'performance-bonus-statement';
        $table = 'tbl_performance_bonus';
        if ($this->input->post()) {
            #dd($this->input->post());
            $this->form_validation->set_rules('content_id', 'Employee', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {

                $content_id = $this->input->post('content_id');
                $year = $this->input->post('financial_year');
                $payment_type = $this->input->post('payment_type');


                if ($content_id) {
                    $this->load->model('search_field_emp_model');
                    $employeeInfo = $this->search_field_emp_model->getEmployeeInfoById($content_id);
                    $this->db->select('ma.*,month.month_name');
                    $this->db->from("$table as ma");
                    $this->db->join('tbl_month as month', 'month.id = ma.adjust_month', 'LEFT');
                    $this->db->where('ma.content_id', $content_id);

                    if ($year) {
                        $this->db->where('ma.adjust_year', $year);
                    }
                    if ($payment_type) {
                        $this->db->where('ma.payment_type', $payment_type);
                    }
                    $query = $this->db->get();
                    $html = '
                        <style>
                        th{
                            font-size:10px;
                            text-align:left
                        }
                        </style>
                    <table id="table2excel" class="table2excel_with_colors table table-striped custom-table mb-0">
                    <thead>';
                    $html .= '<tr>
                        <th colspan="8" style="text-align:center;font-size:20px;background-color:#CCC">' . $title . '</th>
                    </tr>';
                    $html .= '<tr>
                    <th>Employee Name:</th>
                    <th >' . $employeeInfo->emp_name . '</th>
                    <th>Employee ID:</th>
                    <th >' . $employeeInfo->emp_id . '</th>
                    <th >Company Name: </th>
                    <th >' . $employeeInfo->company_name . '</th>
                    <th >Division: </th>
                    <th >' . $employeeInfo->division_name . '</th>
                    
                </tr>';
                    $html .= '<tr>
                    <th>Department Name:</th>
                    <th >' . $employeeInfo->department_name . '</th>
                    <th >Designation: </th>
                    <th >' . $employeeInfo->designation_name . '</th>
                    <th >Type Of Employe: </th>
                    <th >' . $employeeInfo->type_of_emp_name . '</th>
                    <th >Grade Name: </th>
                    <th >' . $employeeInfo->grade_name . '</th>
                    
                </tr>';
                    $html .= '<tr style="background-color:#CCC">
                    <th>SL NO</th>
                    <th>Payment Date</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>amount</th>
                    <th>payment_type</th>
                    <th>remarks</th>
                    <th>status</th>
                </tr>';
                    $html .= '</thead>
                    <tbody>';
                    if ($query->num_rows() > 0) {

                        $totalAmt = 0;
                        foreach ($query->result() as $key => $val) {
                            $status = $val->status == 1 ? 'Pending' : 'paid';
                            $html .=
                                '<tr><td>' . ($key + 1) .
                                '</td><td>' . $val->payment_date .
                                '</td><td>' . $val->month_name .
                                '</td><td>' . $val->adjust_year .
                                '</td><td>' . $val->amount .
                                '</td><td>' . $val->payment_type .
                                '</td><td>' . $val->remarks .
                                '</td><td>' . $status  .
                                '</td></tr>';
                            $totalAmt += $val->amount;
                        }
                    } else {
                        $html .= '<tr><td colspan="8" style="text-align:center">No data found.</td></tr>';
                    }
                    $html .= '</tbody><tfoot>
                            <tr>
                            <td colspan="4">TOTAL</td>
                            <td>' . $totalAmt . '</td>
                            <td colspan="3"></td>
                            </tr>
                        </tfoot>';
                    $html .= '</table>';
                    echo $html;
                    return false;
                } else {
                    echo "SORRY! Employee undefine.";
                }
            }
        }
        $data['title'] = $title;
        $data['route'] = $route;
        $data['years'] = $this->db->query("SELECT * FROM tbl_years /*where status=1*/")->result();
        $data['employees'] = $this->db->query("SELECT * FROM search_field_emp")->result();
        $this->load->view('reports/payroll/performance_bonus_statement', $data);
    }
    # Special Bonus
    function specialBonusStatement()
    {
        $this->check_permission_controller->check_permission_action("special_bonus_statement");
        $title = "Special Bonus Statement";
        $route = 'special-bonus-statement';
        $table = 'tbl_special_bonus';
        if ($this->input->post()) {
            #dd($this->input->post());
            $this->form_validation->set_rules('content_id', 'Employee', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
            } else {

                $content_id = $this->input->post('content_id');
                $year = $this->input->post('financial_year');
                $payment_type = $this->input->post('payment_type');


                if ($content_id) {
                    $this->load->model('search_field_emp_model');
                    $employeeInfo = $this->search_field_emp_model->getEmployeeInfoById($content_id);
                    $this->db->select('ma.*,month.month_name');
                    $this->db->from("$table as ma");
                    $this->db->join('tbl_month as month', 'month.id = ma.adjust_month', 'LEFT');
                    $this->db->where('ma.content_id', $content_id);

                    if ($year) {
                        $this->db->where('ma.adjust_year', $year);
                    }
                    if ($payment_type) {
                        $this->db->where('ma.payment_type', $payment_type);
                    }
                    $query = $this->db->get();
                    $html = '
                        <style>
                        th{
                            font-size:10px;
                            text-align:left
                        }
                        </style>
                    <table id="table2excel" class="table2excel_with_colors table table-striped custom-table mb-0">
                    <thead>';
                    $html .= '<tr>
                        <th colspan="8" style="text-align:center;font-size:20px;background-color:#CCC">' . $title . '</th>
                    </tr>';
                    $html .= '<tr>
                    <th>Employee Name:</th>
                    <th >' . $employeeInfo->emp_name . '</th>
                    <th>Employee ID:</th>
                    <th >' . $employeeInfo->emp_id . '</th>
                    <th >Company Name: </th>
                    <th >' . $employeeInfo->company_name . '</th>
                    <th >Division: </th>
                    <th >' . $employeeInfo->division_name . '</th>
                    
                </tr>';
                    $html .= '<tr>
                    <th>Department Name:</th>
                    <th >' . $employeeInfo->department_name . '</th>
                    <th >Designation: </th>
                    <th >' . $employeeInfo->designation_name . '</th>
                    <th >Type Of Employe: </th>
                    <th >' . $employeeInfo->type_of_emp_name . '</th>
                    <th >Grade Name: </th>
                    <th >' . $employeeInfo->grade_name . '</th>
                    
                </tr>';
                    $html .= '<tr style="background-color:#CCC">
                    <th>SL NO</th>
                    <th>Payment Date</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>amount</th>
                    <th>payment_type</th>
                    <th>remarks</th>
                    <th>status</th>
                </tr>';
                    $html .= '</thead>
                    <tbody>';
                    if ($query->num_rows() > 0) {

                        $totalAmt = 0;
                        foreach ($query->result() as $key => $val) {
                            $status = $val->status == 1 ? 'Pending' : 'paid';
                            $html .=
                                '<tr><td>' . ($key + 1) .
                                '</td><td>' . $val->payment_date .
                                '</td><td>' . $val->month_name .
                                '</td><td>' . $val->adjust_year .
                                '</td><td>' . $val->amount .
                                '</td><td>' . $val->payment_type .
                                '</td><td>' . $val->remarks .
                                '</td><td>' . $status  .
                                '</td></tr>';
                            $totalAmt += $val->amount;
                        }
                    } else {
                        $html .= '<tr><td colspan="8" style="text-align:center">No data found.</td></tr>';
                    }
                    $html .= '</tbody><tfoot>
                            <tr>
                            <td colspan="4">TOTAL</td>
                            <td>' . $totalAmt . '</td>
                            <td colspan="3"></td>
                            </tr>
                        </tfoot>';
                    $html .= '</table>';
                    echo $html;
                    return false;
                } else {
                    echo "SORRY! Employee undefine.";
                }
            }
        }
        $data['title'] = $title;
        $data['route'] = $route;
        $data['years'] = $this->db->query("SELECT * FROM tbl_years /*where status=1*/")->result();
        $data['employees'] = $this->db->query("SELECT * FROM search_field_emp")->result();
        $this->load->view('reports/payroll/special_bonus_statement', $data);
    }

    public function current_time()
    {
        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
        $current_time = $dt->format('Y-m-d H:i:s');
        return $current_time;
    }

    public function currentDate()
    {
        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
        $current_time = $dt->format('d-m-Y');
        return $current_time;
    }

    public function convert_number_to_words($number)
    {
        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'fourty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . $this->convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }
}