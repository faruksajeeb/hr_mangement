<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class TaxReportController extends CI_Controller
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

    public function taxCalculation()
    {
        $data = [];
        if ($this->input->post('export_btn')) {
            //            print_r($this->input->post());
            //            exit;
            // $this->form_validation->set_rules('emp_name', 'Employee Name ', 'required');
            $this->form_validation->set_rules('financial_year', 'Financial Year', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
                redirect('tax-calculation');
            }
            $content_id = $this->input->post('content_id');
            $financialYear = $this->input->post('financial_year');
            $finYear = explode('-', $financialYear);
            $fromYear = $finYear[0];
            $toYear = $finYear[1];
            $fromDate = "$fromYear-07-01";
            $toDate = "$toYear-06-30";

            $spreadsheet = new Spreadsheet();
            $additinalWhere = '';
            if ($content_id) {
                $additinalWhere = ' AND ES.content_id=' . $content_id;
            }
            $employees =  $this->db->query("SELECT ES.*,
            SFE.emp_name,SFE.emp_id,SFE.mobile_no,
            SFE.joining_date,
            -- ED.field_value as profile_picture,
            DESIGNATION.name as designation_name,
            salary_grade.grade_name,
            DIVISION.name as DivisionName
            FROM emp_salary ES 
            LEFT JOIN search_field_emp SFE ON SFE.content_id=ES.content_id 
            LEFT JOIN taxonomy DIVISION ON DIVISION.tid=SFE.emp_department 
            LEFT JOIN taxonomy DESIGNATION ON DESIGNATION.tid =SFE.emp_post_id
            LEFT JOIN tbl_salary_grades salary_grade ON salary_grade.id =ES.grade_id
            -- LEFT JOIN emp_details ED ON ED.content_id=ES.content_id AND ED.field_name='resources/uploads'
            WHERE SFE.type_of_employee $additinalWhere
            -- NOT IN (153/*Left*/,473/*Terminated*/)
            AND ES.id IN (
                SELECT MAX(id)
                FROM emp_salary
                GROUP BY content_id
            )")->result();
            if (count($employees) < 1) {
                $this->session->set_flashdata('errors', 'Employee salary information not found. Please set salary first. Go to <a href="' . base_url() . 'staff-salary">Staff Salary Setup</a>');
                redirect('tax-calculation');
            }
            foreach ($employees as $key => $employee) {

                # get fastival bonus data
                $fastivalBonusData = $this->db->query("SELECT * FROM tbl_festival_bonus WHERE content_id=$employee->content_id AND ((adjust_month>=7 AND adjust_year=$fromYear) OR (adjust_month<=6 AND adjust_year=$toYear)) ")->result();
                # get leave encashment data
                $encashmentData = $this->db->query("SELECT * FROM tbl_festival_bonus WHERE content_id=$employee->content_id AND ((adjust_month>=7 AND adjust_year=$fromYear) OR (adjust_month<=6 AND adjust_year=$toYear)) ")->result();
                # get intensive data
                $intensiveData = $this->db->query("SELECT * FROM tbl_incentive WHERE content_id=$employee->content_id AND ((adjust_month>=7 AND adjust_year=$fromYear) OR (adjust_month<=6 AND adjust_year=$toYear)) ")->result();

                $empName = substr(($key + 1) . '-' . $employee->emp_name, 0, 25);
                // Create a new worksheet called "My Data"
                $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $empName);


                // $myWorkSheet->getStyle('D' . $row)->applyFromArray($styleArray);
                $myWorkSheet->mergeCells('A1:H1');
                $myWorkSheet->mergeCells('A2:H2');
                $myWorkSheet->mergeCells('A3:H3');

                $myWorkSheet->setCellValue('A1', $employee->emp_name);
                $myWorkSheet->setCellValue('A2', 'Computation of Total Income and Tax Liability');
                $myWorkSheet->setCellValue('A3', 'for the Income Year ' . $this->input->post('financial_year'));

                $myWorkSheet->setCellValue('A5', 'SL');
                $myWorkSheet->setCellValue('C5', 'Particulars');
                $myWorkSheet->setCellValue('E5', 'Rate');
                $myWorkSheet->setCellValue('F5', 'Month');
                $myWorkSheet->setCellValue('H5', 'Amount in Taka');

                $myWorkSheet->setCellValue('A6',  "`1.00");
                $myWorkSheet->setCellValue('A10', "`2.00");
                $myWorkSheet->setCellValue('A14', "`3.00");
                $myWorkSheet->setCellValue('A19', "`4.00");
                $myWorkSheet->setCellValue('A24', "`5.00");
                $myWorkSheet->setCellValue('A28', "`6.00");
                $myWorkSheet->setCellValue('A31', "`7.00");
                $myWorkSheet->setCellValue('A35', "`8.00");

                $myWorkSheet->setCellValue('C6', 'Basic');
                // $myWorkSheet->setCellValue('C10', 'Total Basic');
                $myWorkSheet->setCellValue('C10', 'Conveyance/ Entertainment');
                $myWorkSheet->setCellValue('C15', 'Total Conveyance');
                // $myWorkSheet->setCellValue('C16', 'Less: Exemption');
                $myWorkSheet->setCellValue('C14', 'House Rent ');
                // $myWorkSheet->setCellValue('C20', 'Total');
                $myWorkSheet->setCellValue('C17', 'Less: Examption');
                $myWorkSheet->setCellValue('C19', 'Medical Allowance');
                $myWorkSheet->setCellValue('C22', 'Less: Examption');
                $myWorkSheet->setCellValue('C24', 'PF Contribution');
                $myWorkSheet->setCellValue('C28', 'Leave Fare  Assistance');
                $myWorkSheet->setCellValue('C29', 'Less: Examption');
                $myWorkSheet->setCellValue('C31', 'Festival Bonus');
                $myWorkSheet->setCellValue('C35', 'Leave encashment');
                $myWorkSheet->setCellValue('C36', 'Incentive');

                $myWorkSheet->setCellValue('C37', 'Total Income');

                $myWorkSheet->setCellValue('B39', 'Slab');
                $myWorkSheet->setCellValue('C39', 'Tax Calculation');
                $myWorkSheet->setCellValue('E39', 'Tax Rate(%)');
                $myWorkSheet->setCellValue('H39', 'Taka');

                $myWorkSheet->setCellValue('A40', 'Ist');
                $myWorkSheet->setCellValue('A41', 'Next');
                $myWorkSheet->setCellValue('A42', 'Next');
                $myWorkSheet->setCellValue('A43', 'Next');
                $myWorkSheet->setCellValue('A44', 'Next');
                $myWorkSheet->setCellValue('A45', 'Balance');

                $myWorkSheet->setCellValue('B40', 350000);
                $myWorkSheet->setCellValue('B41', 100000);
                $myWorkSheet->setCellValue('B42', 300000);
                $myWorkSheet->setCellValue('B43', 400000);
                $myWorkSheet->setCellValue('B44', 500000);
                $myWorkSheet->setCellValue('B45', 0);


                $myWorkSheet->setCellValue('A48', 'Calculation of Investment Allowance :');
                $myWorkSheet->setCellValue('A49', 'Actual Investment(Subs & cont)');
                $myWorkSheet->setCellValue('A51', '20% of total income');
                $myWorkSheet->setCellValue('A52', 'Total');
                $myWorkSheet->setCellValue('A53', 'Additional investment required');
                $myWorkSheet->setCellValue('A54', 'Maximum limit');
                $myWorkSheet->setCellValue('A55', '( Actual Income or 20% of total income or maximum 15,000,000 Tk. Which ever is lower)');

                $myWorkSheet->setCellValue('A58', 'Tax liability on total income');
                $myWorkSheet->setCellValue('A59', 'Less: Investment Allowance');
                $myWorkSheet->setCellValue('A60', 'Tax Liability');
                $myWorkSheet->setCellValue('A61', 'Tax already deducted');
                $myWorkSheet->setCellValue('A62', 'Net tax liability ');
                $myWorkSheet->setCellValue('A63', 'Tax to be deducted');


                $myWorkSheet->setCellValue('E6', $employee->basic);
                $myWorkSheet->setCellValue('E7', 0);
                $myWorkSheet->setCellValue('E10', ($employee->ea > 1) ? $employee->ea : $employee->ca);
                $myWorkSheet->setCellValue('E11', '=E7*0.05');
                $myWorkSheet->setCellValue('E14', $employee->hra);
                $myWorkSheet->setCellValue('E15', '=E7*0.05');
                $myWorkSheet->setCellValue('E19', $employee->ma);
                $myWorkSheet->setCellValue('E20', '=E7*0.05');
                $myWorkSheet->setCellValue('E24', $employee->pf);
                $myWorkSheet->setCellValue('E25', '=E7*0.1');
                $myWorkSheet->setCellValue('E28', "=E6");
                $myWorkSheet->setCellValue('E31', "=E6");
                $myWorkSheet->setCellValue('E32', "=E7");
                $myWorkSheet->setCellValue('E35', 0); //Leave encashment
                $myWorkSheet->setCellValue('E36', 0); // intensive

                $myWorkSheet->setCellValue('F6', 12);
                $myWorkSheet->setCellValue('F7', 1);
                $myWorkSheet->setCellValue('F10', 12);
                $myWorkSheet->setCellValue('F11', 1);
                $myWorkSheet->setCellValue('F14', 12);
                $myWorkSheet->setCellValue('F15', 1);
                $myWorkSheet->setCellValue('F19', 12);
                $myWorkSheet->setCellValue('F20', 1);
                $myWorkSheet->setCellValue('F24', 12);
                $myWorkSheet->setCellValue('F25', 1);
                $myWorkSheet->setCellValue('F28', 1);
                // $myWorkSheet->setCellValue('F29',1);
                $myWorkSheet->setCellValue('F31', 2);
                $myWorkSheet->setCellValue('F32', 1);

                $myWorkSheet->setCellValue('F35', 1);
                $myWorkSheet->setCellValue('F36', 1);


                $myWorkSheet->setCellValue('G6', "=F6*E6");
                $myWorkSheet->setCellValue('G7', "=F7*E7");
                $myWorkSheet->setCellValue('G8', "=SUM(G6:G7)");
                $myWorkSheet->setCellValue('G10', "=F10*E10");
                $myWorkSheet->setCellValue('G11', "=F11*E11");
                $myWorkSheet->setCellValue('G12', "=SUM(G10:G11)");
                $myWorkSheet->setCellValue('G14', "=E14*F14");
                $myWorkSheet->setCellValue('G15', "=E15*F15");
                $myWorkSheet->setCellValue('G16', "=SUM(G14:G15)");
                $myWorkSheet->setCellValue('G17', 0);
                $myWorkSheet->setCellValue('G19', "=F19*E19");
                $myWorkSheet->setCellValue('G20', "=F20*E20");
                $myWorkSheet->setCellValue('G21', "=SUM(G19:G20)");
                $myWorkSheet->setCellValue('G22', 0);
                $myWorkSheet->setCellValue('G24', "=F24*E24");
                $myWorkSheet->setCellValue('G25', "=F25*E25");
                $myWorkSheet->setCellValue('G26', "=SUM(G24:G25)");

                $myWorkSheet->setCellValue('G28', "=E28*F28");
                $myWorkSheet->setCellValue('G29', 0);

                $myWorkSheet->setCellValue('G31', "=E31*F31");
                $myWorkSheet->setCellValue('G32', "=E32*F32");
                $myWorkSheet->setCellValue('G33', "=SUM(G31:G32)");


                $myWorkSheet->setCellValue('G35', "=E35*F35");
                $myWorkSheet->setCellValue('G36', "=E36*F36");

                $myWorkSheet->setCellValue('H8', '=G8');
                $myWorkSheet->setCellValue('H12', '=G12');
                $myWorkSheet->setCellValue('H17', '=G16-G17');
                $myWorkSheet->setCellValue('H26', '=G26');
                $myWorkSheet->setCellValue('H33', '=G33');
                $myWorkSheet->setCellValue('H35', '=G35');
                $myWorkSheet->setCellValue('H36', '=G36');
                $myWorkSheet->setCellValue('H37', "=SUM(H6:H36)");

                $myWorkSheet->setCellValue('H40', "=C40*E40");
                $myWorkSheet->setCellValue('H41', "=C41*E41%");
                $myWorkSheet->setCellValue('H42', "=C42*E42%");
                $myWorkSheet->setCellValue('H43', "=C43*E43%");
                $myWorkSheet->setCellValue('H44', "=C44*E44%");
                $myWorkSheet->setCellValue('H45', "=C45*E45%");
                $myWorkSheet->setCellValue('H46', "=SUM(H40:H45)");

                $myWorkSheet->setCellValue('D49', "=H26*2");
                $myWorkSheet->setCellValue('D51', "=H37*0.2");
                $myWorkSheet->setCellValue('D52', "=SUM(D51:D51)");
                $myWorkSheet->setCellValue('D53', "=D52-D49");
                $myWorkSheet->setCellValue('D54', 15000000);

                $myWorkSheet->setCellValue('E51', '15%');
                $myWorkSheet->setCellValue('E52', '(20% of total income)');

                // $myWorkSheet->setCellValue('H51','=D51*E51');
                $myWorkSheet->setCellValue('H51', '=D51*15%');
                $myWorkSheet->setCellValue('H52', '=SUM(H51:H51)');

                $myWorkSheet->setCellValue('H58', '=H46');
                $myWorkSheet->setCellValue('H59', '=H52');
                $myWorkSheet->setCellValue('H60', '=H58-H59');
                $myWorkSheet->setCellValue('H29', '=G28-G29');
                $taxAlreadyDeducted = 0;
                $taxAlreadyDeducted = $this->db->query("SELECT SUM(tax) as taxAlreadyDeducted FROM tbl_payroll  WHERE content_id=$employee->content_id AND ((month_id>=7 AND year=$fromYear) OR (month_id<=6 AND year=$toYear)) GROUP BY content_id")->row('taxAlreadyDeducted');
                $myWorkSheet->setCellValue('H61', $taxAlreadyDeducted);
                $myWorkSheet->setCellValue('H62', "=H60-H61");
                $myWorkSheet->setCellValue('H63', "=H62");




                $myWorkSheet->setCellValue('E40', 0);
                $myWorkSheet->setCellValue('E41', 5);
                $myWorkSheet->setCellValue('E42', 10);
                $myWorkSheet->setCellValue('E43', 15);
                $myWorkSheet->setCellValue('E44', 20);
                $myWorkSheet->setCellValue('E45', 25);
                // Attach the getActiveSheet()->"My Data" worksheet as the first worksheet in the Spreadsheet object
                $spreadsheet->addSheet($myWorkSheet, $key);

                $styleArray = [
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];
                $spreadsheet->setActiveSheetIndex($key);
                // $spreadsheet->getActiveSheet()->calculate();      
                $totalIncome = $spreadsheet->getActiveSheet()->getCell('H37')->getCalculatedValue();
                // dd($totalIncome);
                $remainingIncome = 0;
                if ($totalIncome > 350000) {
                    $taxCalOne = 350000;
                    $remainingIncome = $totalIncome - 350000;
                } else {
                    $taxCalOne = $totalIncome;
                }


                if ($remainingIncome > 100000) {
                    $taxCalTwo = 100000;
                    $remainingIncome = $remainingIncome - 100000;
                } else {
                    $taxCalTwo = $remainingIncome;
                }

                if ($remainingIncome > 300000) {
                    $taxCalThree = 300000;
                    $remainingIncome = $remainingIncome - 300000;
                } else {
                    $taxCalThree = $remainingIncome;
                }

                if ($remainingIncome > 400000) {
                    $taxCalFour = 400000;
                    $remainingIncome = $remainingIncome - 400000;
                } else {
                    $taxCalFour = $remainingIncome;
                }

                if ($remainingIncome > 500000) {
                    $taxCalFive = 500000;
                    $remainingIncome = $remainingIncome - 500000;
                } else {
                    $taxCalFive = $remainingIncome;
                }
                $myWorkSheet->setCellValue('C40', $taxCalOne);
                $myWorkSheet->setCellValue('C41', $taxCalTwo);
                $myWorkSheet->setCellValue('C42', $taxCalThree);
                $myWorkSheet->setCellValue('C43', $taxCalFour);
                $myWorkSheet->setCellValue('C44', $taxCalFive);
                $myWorkSheet->setCellValue('C45', $remainingIncome);
                $myWorkSheet->setCellValue('C46', "=SUM(C40:C45)");

                $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
                $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(TRUE);
                $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('A2')->applyFromArray(['alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]]);
                $spreadsheet->getActiveSheet()->getStyle('A3')->applyFromArray(['alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]]);
                $spreadsheet->getActiveSheet()->getStyle('A5')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('C5')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('E5')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('F5')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('H5')->applyFromArray(['font' => ['bold' => true,]]);

                $spreadsheet->getActiveSheet()->getStyle('B39')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('C39')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('E39')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('H39')->applyFromArray(['font' => ['bold' => true,]]);

                $spreadsheet->getActiveSheet()->getStyle('A48')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('A49')->applyFromArray(['font' => ['bold' => true,]]);

                $spreadsheet->getActiveSheet()->getStyle('C46')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('H46')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('D52')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('H52')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('H60')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('H62')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('H63')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('H8')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('H12')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('H17')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('H26')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('H33')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('H35')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('H37')->applyFromArray(['font' => ['bold' => true,]]);
                $spreadsheet->getActiveSheet()->getStyle('A6:A38')->applyFromArray(['font' => ['bold' => true,]]);

                $styleArray = array(
                    'borders' => array(
                        'outline' => array(
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => array('argb' => '000000'),
                        ),
                    ),
                );
                $spreadsheet->getActiveSheet()->getStyle('A1:H63')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('A5')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('B5:D5')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('E5')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('F5')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('G5')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('H5')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('G8')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('G12')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('G33')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('H37')->applyFromArray($styleArray);


                $spreadsheet->getActiveSheet()->getStyle('A6:A38')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('E6:E38')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('F6:F38')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('G6:G38')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('A39:H39')->applyFromArray($styleArray);

                $styleArray = array(
                    'borders' => array(
                        'bottom' => array(
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => array('argb' => '000000'),
                        ),
                    ),
                );
                $spreadsheet->getActiveSheet()->getStyle('C46')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('H46')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('D52')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('H52')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('H59')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('H61')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('H62')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('G15')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('G17')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('G20')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('G25')->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('G29')->applyFromArray($styleArray);
            }

            $spreadsheet->setActiveSheetIndex(0);
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            die();

        }

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
        $this->load->view("reports/tax/tax-calculation", $data);
    }
}
