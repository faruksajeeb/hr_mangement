<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class PfReportController extends CI_Controller
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

    public function pfStatement()
    {
        $data = [];
        if ($this->input->post('export_btn')) {
            $this->form_validation->set_rules('emp_company', 'Company', 'required');
            // $this->form_validation->set_rules('emp_division', 'Division', 'required');
            $this->form_validation->set_rules('year', 'year', 'required');
            $this->form_validation->set_rules('month', 'month', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
                redirect('pf-statement');
            }
            $companyId = $this->input->post('emp_company');
            $divisionId = $this->input->post('emp_division');
            $year = $this->input->post('year');
            $month = $this->input->post('month');
            $month = explode('-', $month);
            $monthId = $month[0];
            $monthName = $month[1];


            $additinalWhere = '';
            if ($divisionId) {
                $additinalWhere = ' AND tbl_payroll.division_id=' . $divisionId;
            }
            $pfRecords =  $this->db->query("SELECT tbl_payroll.*,
            SFE.emp_name,SFE.emp_id,SFE.mobile_no,
            SFE.joining_date,
            DESIGNATION.name as designation_name,
            DIVISION.name as DivisionName
            FROM tbl_payroll
            LEFT JOIN search_field_emp SFE ON SFE.content_id=tbl_payroll.content_id 
            LEFT JOIN taxonomy DIVISION ON DIVISION.tid=SFE.emp_department 
            LEFT JOIN taxonomy DESIGNATION ON DESIGNATION.tid =SFE.emp_post_id
            WHERE tbl_payroll.company_id=$companyId AND tbl_payroll.year=$year AND tbl_payroll.month_id=$monthId 
            $additinalWhere
            ORDER BY tbl_payroll.division_id,tbl_payroll.grade_id
            ")->result();
            // dd($pfRecords);
            if (count($pfRecords) < 1) {
                $this->session->set_flashdata('errors', 'PF Information not found. Please generate payslip first. Go to <a href="' . base_url() . 'division-pay-slip-generation-manual">Generate Payslip</a>');
                redirect('pf-statement');
            }
            $spreadsheet = new Spreadsheet();
            // Create a new worksheet called "My Data"
            $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'PF Statement');
            $spreadsheet->addSheet($myWorkSheet, 0);
            $spreadsheet->setActiveSheetIndex(0);

            $styleArrayBoldCenter = [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],'borders' => array(
                    'outline' => array(
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => array('argb' => '000000'),
                    ),
                ),
            ];
            $styleArrayBoldRight = [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_RIGHT,
                ],'borders' => array(
                    'outline' => array(
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => array('argb' => '000000'),
                    ),
                ),
            ];
            $styleBgColor = array(
                'fill' => array(
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => array('argb' => 'D6E8DB')
                )
            );
            $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleArrayBoldCenter);

            // $myWorkSheet->getStyle('D' . $row)->applyFromArray($styleArray);
            # TITLE
            $myWorkSheet->mergeCells('A1:J1');
            $myWorkSheet->setCellValue('A1', "Provident Fund for the Month of " . $monthName . " " . $year);

            # HEADER  ROW
            $myWorkSheet->setCellValue('A2', 'SL NO');
            $myWorkSheet->setCellValue('B2', 'P/F ID');
            $myWorkSheet->setCellValue('C2', 'Employee Name');
            $myWorkSheet->setCellValue('D2', 'Designation');
            $myWorkSheet->setCellValue('E2', 'Basic Salary');
            $myWorkSheet->setCellValue('F2', 'PF Contribution');
            $myWorkSheet->setCellValue('G2', 'Arrear PF Contribution');
            $myWorkSheet->setCellValue('H2', 'Total contribution');
            $myWorkSheet->setCellValue('I2', 'PF Subscription');
            $myWorkSheet->setCellValue('J2', 'Grand Total');
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(TRUE);

            $spreadsheet->getActiveSheet()->getStyle("A2:J2")->applyFromArray($styleArrayBoldCenter);
            $spreadsheet->getActiveSheet()->getStyle("A2:J2")->applyFromArray($styleBgColor);

            $basicTotal = $pfConTotal = $pfArrearTotal = $totalConTotal = $pfSubTotal = $grandTotal = 0;
            $grandbasicTotal = $grandpfConTotal = $grandpfArrearTotal = $grandtotalConTotal = $grandpfSubTotal = $grandgrandTotal = 0;
            $divId = '';
            $divisionName = '';



            foreach ($pfRecords as $key => $val) {
                $row = $key + 3;
                if ($divId != '' && $divId != $val->division_id) {
                    $myWorkSheet->mergeCells("A$row:D$row");
                    $myWorkSheet->setCellValue("A$row", $divisionName . ' Total');
                    $myWorkSheet->setCellValue("E$row", number_format($basicTotal));
                    $myWorkSheet->setCellValue("F$row", number_format($pfConTotal));
                    $myWorkSheet->setCellValue("G$row", number_format($pfArrearTotal));
                    $myWorkSheet->setCellValue("H$row", number_format($totalConTotal));
                    $myWorkSheet->setCellValue("I$row", number_format($pfSubTotal));
                    $myWorkSheet->setCellValue("J$row", number_format($grandTotal));
                    $spreadsheet->getActiveSheet()->getStyle("A$row:J$row")->applyFromArray($styleArrayBoldRight);
                    $spreadsheet->getActiveSheet()->getStyle("A$row:J$row")->applyFromArray($styleBgColor);
                    $grandbasicTotal += $basicTotal;
                    $grandpfConTotal += $pfConTotal;
                    $grandpfArrearTotal += $pfArrearTotal;
                    $grandtotalConTotal += $totalConTotal;
                    $grandpfSubTotal += $pfSubTotal;
                    $grandgrandTotal += $grandTotal;
                    $basicTotal = $pfConTotal = $pfArrearTotal = $totalConTotal = $pfSubTotal = $grandTotal = 0;
                    $divId = '';
                } else {
                    $divId = $val->division_id;
                    $divisionName = $val->DivisionName;
                    $myWorkSheet->setCellValue('A' . $row, $key + 1);
                    $myWorkSheet->setCellValue('B' . $row, '');
                    $myWorkSheet->setCellValue('C' . $row, $val->emp_name);
                    $myWorkSheet->setCellValue('D' . $row, $val->designation_name);
                    $myWorkSheet->setCellValue('E' . $row, number_format($val->basic));
                    $myWorkSheet->setCellValue('F' . $row, number_format($val->pf));
                    $myWorkSheet->setCellValue('G' . $row, number_format($val->arrear_pf));
                    $myWorkSheet->setCellValue('H' . $row, number_format($totalPf = $val->pf + $val->arrear_pf));
                    $myWorkSheet->setCellValue('I' . $row, number_format($val->pf));
                    $myWorkSheet->setCellValue('J' . $row, number_format($gTotal = $val->pf * 2));
                    $spreadsheet->getActiveSheet()->getStyle("E$row:J$row")->applyFromArray(['alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_RIGHT,
                    ]]);
                    $spreadsheet->getActiveSheet()->getStyle("A$row:J$row")->applyFromArray(['borders' => array(
                        'outline' => array(
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => array('argb' => '000000'),
                        ),
                    ),]);
                    $basicTotal += $val->basic;
                    $pfConTotal += $val->pf;
                    $pfArrearTotal += $val->arrear_pf;
                    $totalConTotal += $totalPf;
                    $pfSubTotal += $val->pf;
                    $grandTotal += $gTotal;

                    if (count($pfRecords) == ($key + 1)) {
                        $myWorkSheet->mergeCells("A$row:D$row");
                        $myWorkSheet->setCellValue('A' . $row, $divisionName . ' Total');
                        $myWorkSheet->setCellValue('E' . $row, number_format($basicTotal));
                        $myWorkSheet->setCellValue('F' . $row, number_format($pfConTotal));
                        $myWorkSheet->setCellValue('G' . $row, number_format($pfArrearTotal));
                        $myWorkSheet->setCellValue('H' . $row, number_format($totalConTotal));
                        $myWorkSheet->setCellValue('I' . $row, number_format($pfSubTotal));
                        $myWorkSheet->setCellValue('J' . $row, number_format($grandTotal));
                        $spreadsheet->getActiveSheet()->getStyle("A$row:J$row")->applyFromArray($styleArrayBoldRight);
                        $spreadsheet->getActiveSheet()->getStyle("A$row:J$row")->applyFromArray($styleBgColor);
                        $grandbasicTotal += $basicTotal;
                        $grandpfConTotal += $pfConTotal;
                        $grandpfArrearTotal += $pfArrearTotal;
                        $grandtotalConTotal += $totalConTotal;
                        $grandpfSubTotal += $pfSubTotal;
                        $grandgrandTotal += $grandTotal;
                        $basicTotal = $pfConTotal = $pfArrearTotal = $totalConTotal = $pfSubTotal = $grandTotal = 0;
                        $divId = '';

                        # Grand Total
                        #
                        $row = $row + 1;
                        $myWorkSheet->mergeCells("A$row:D$row");
                        $myWorkSheet->setCellValue('A' . $row, 'Grand Total');
                        $myWorkSheet->setCellValue('E' . $row, number_format($grandbasicTotal));
                        $myWorkSheet->setCellValue('F' . $row, number_format($grandpfConTotal));
                        $myWorkSheet->setCellValue('G' . $row, number_format($grandpfArrearTotal));
                        $myWorkSheet->setCellValue('H' . $row, number_format($grandtotalConTotal));
                        $myWorkSheet->setCellValue('I' . $row, number_format($grandpfSubTotal));
                        $myWorkSheet->setCellValue('J' . $row, number_format($grandgrandTotal));
                        $spreadsheet->getActiveSheet()->getStyle("A$row:J$row")->applyFromArray($styleArrayBoldRight);
                        $spreadsheet->getActiveSheet()->getStyle("A$row:J$row")->applyFromArray($styleBgColor);
                        
                        $row = $row + 1;
                        $myWorkSheet->mergeCells("A$row:I$row");
                        $myWorkSheet->setCellValue('A' . $row, 'Amount to be transferred in PF Account');
                        $myWorkSheet->setCellValue('J' . $row, number_format($grandgrandTotal));
                        $spreadsheet->getActiveSheet()->getStyle("A$row:J$row")->applyFromArray($styleArrayBoldRight);
                        $spreadsheet->getActiveSheet()->getStyle("A$row:J$row")->applyFromArray($styleBgColor);
                    }
                }
            }

            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');

            
            $this->load->library("pdf");
            $mPdf = $this->pdf->load();
            $html = $this->load->view('payroll/report/pf_statement-pdf', $data, true);
            //this the the PDF filename that user will get to download
            $pdfFilePath = "pf_statement-of-" . $data['company'] . ".pdf";
            $mPdf->SetJS('this.print();');
            $mPdf->WriteHTML(utf8_encode($html));
            $mPdf->Output($pdfFilePath, "D");
            
            die();
        }
        if ($this->all_company_access['status'] == 1 || $this->user_type == 1) {

            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid(1);
            // dd( $data['alldivision'] );
        } else {
            if ($this->user_department) {
                $data['department_selected'] = $this->taxonomy->getTaxonomyBytid($this->user_department);
            } else {
                $data['department_selected'] = $this->taxonomy->getTaxonomychildbyparent($this->user_division);
            }
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($this->user_division);
        }
        $data['years'] = $this->db->query("SELECT * FROM tbl_years WHERE status=1")->result();
        $data['months'] = $this->Payroll_model->getMonths();
        $data['userId'] = $this->user_id;
        $data['userType'] = $this->user_type;
        $data['userDivision'] = $this->user_division;
        $data['userDepartment'] = $this->user_department;
        $this->load->view("reports/pf/pf-statement", $data);
    }
}
