<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Payroll extends CI_Controller
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
        $this->load->helper('url');
        $this->load->model('Payroll_model');
        $this->user_id = $this->session->userdata('user_id');
        $this->user_name = $this->session->userdata('user_name');
        $this->user_type = $this->session->userdata('user_type');
        $this->user_division =  $this->session->userdata('user_division');
        $this->user_department =  $this->session->userdata('user_department');
        $this->all_company_access = $this->users_model->getuserwisepermission("all_company_access", $this->user_id);
    }
    public function getPayslipInfoById($id){
        if($id){
            $rst = $this->db->query("SELECT p.*,e.emp_id,e.emp_name FROM tbl_payroll p LEFT JOIN search_field_emp e ON e.content_id=p.content_id WHERE p.id=?",array($id))->row();
            echo json_encode( $rst);
        }
    }
    function createGrade()
    {
        date_default_timezone_set('Asia/Dhaka');
        $data['title'] = "Create Grade";
        $this->load->library('form_validation');
        $this->form_validation->set_rules('grade_name', 'Grade Name', 'required|trim|max_length[50]|callback_check_grade_name');
        //$this->form_validation->set_rules('description','Description','required|trim|max_length[200]');
        $this->form_validation->set_rules('absent_deduction_type', 'absent_deduction_type', 'required|trim');
        $this->form_validation->set_rules('overtime_amount_type', 'overtime_amount_type', 'required|trim');
        $this->form_validation->set_rules('absent_deduction_amount', 'absent_deduction_amount', 'trim|numeric');
        $this->form_validation->set_rules('overtime_rate_per_hour', 'overtime_rate_per_hour', 'trim|numeric');
        $this->form_validation->set_rules('component_id[]', 'Component ID ', 'required|trim');
        $this->form_validation->set_rules('deduction_component_id[]', 'Deduction Component ID ', 'required|trim');
        $this->form_validation->set_rules('salary_component_amount[]', 'Component Amount', 'trim|numeric');
        $this->form_validation->set_rules('deduction_salary_component_amount[]', 'Deduction Component Amount', 'trim|numeric');
        //$this->form_validation->set_rules('allowance_id[]','Allowance ID ','required|trim');

        $data['earning_heads'] = $this->db->query('SELECT * FROM tbl_salary_heads WHERE head_type=1 AND status=1')->result();
        $data['deduction_heads'] = $this->db->query('SELECT * FROM tbl_salary_heads WHERE head_type=2 AND status=1')->result();
        if ($this->form_validation->run() == FALSE) {
            # for ajax call
            // if( validation_errors() ){
            // 	exit("Submit Error:\n".strip_tags(validation_errors()));
            // }
            $this->load->view('payroll/settings/create_grade_iidfc', $data);
            return FALSE;
        }
        # get input post
        $input = $this->input->post();
        #dd($input);
        $absent_deduction_amount = NULL;
        if ($input['absent_deduction_type'] == 'fixed') {
            $absent_deduction_amount = $input['absent_deduction_amount'];
        } else {
            $absent_deduction_amount = NULL;
        }

        $overtime_rate_per_hour = NULL;
        if ($input['overtime_amount_type'] == 'fixed') {
            $overtime_rate_per_hour = $input['overtime_rate_per_hour'];
        } else {
            $overtime_rate_per_hour = NULL;
        }
        $gData = array();
        $gdAllowanceData = array();
        $gdDeductionData = array();
        $gData = array(
            'grade_name' => $input['grade_name'],
            'description' => $input['description'],
            'absent_deduction_type' => $input['absent_deduction_type'],
            'absent_deduction_fixed_amount' => $absent_deduction_amount,
            'overtime_amount_type' => $input['overtime_amount_type'],
            'overtime_rate_per_hour' => $overtime_rate_per_hour,
            'created_at' => date("Y-m-d H:i:s", strtotime("now")),
            'created_by' => $_SESSION['user_id'],
            'status' => 1
        );
        $this->db->trans_start();

        $edit_id = $this->input->post('edit_id');

        if (isset($edit_id) && $edit_id) {
            $gData['updated_at'] = date("Y-m-d H:i:s", strtotime("now"));
            $gData['updated_by'] = $_SESSION['user_id'];
            $this->db->where('id', $edit_id);
            $this->db->update('tbl_salary_grades', $gData);
            $insertGradeId = $edit_id;
        } else {
            $gData['created_at'] = date("Y-m-d H:i:s", strtotime("now"));
            $gData['created_by'] = $_SESSION['user_id'];

            $this->db->insert('tbl_salary_grades', $gData);
            $insertGradeId = $this->db->insert_id();
        }


        foreach ($input['component_id'] as $key => $val) {
            if ($val == '') {
                continue;
            }

            if ($input['salary_component_amount_type'][$key] == 'fixed') {
                $percentage = NULL;
                $amount = $input['salary_component_amount'][$key];
                $reference_id = NULL;
            } else {
                $amount = NULL;
                $percentage = $input['salary_component_amount'][$key];
                $reference_id = $input['reference_id'][$key];
            }
            $gdAllowanceData[] = array(
                'grade_id' => $insertGradeId,
                'head_id' => $input['component_id'][$key],
                'amount_type' => $input['salary_component_amount_type'][$key],
                'amount' => $amount,
                'percentage' => $percentage,
                // 'tax_rate' => $input['tax_rate'][$i],
                'based_on_ref_if' => $reference_id
            );
        }

        foreach ($input['deduction_component_id'] as $key => $val) {
            if ($val == '') {
                continue;
            }

            if ($input['deduction_salary_component_amount_type'][$key] == 'fixed') {
                $percentage = NULL;
                $amount = $input['deduction_salary_component_amount'][$key];
                $reference_id = NULL;
            } else {
                $amount = NULL;
                $percentage = $input['deduction_salary_component_amount'][$key];
                $reference_id = $input['deduction_reference_id'][$key];
            }
            $gdDeductionData[] = array(
                'grade_id' => $insertGradeId,
                'head_id' => $input['deduction_component_id'][$key],
                'amount_type' => $input['deduction_salary_component_amount_type'][$key],
                'amount' => $amount,
                'percentage' => $percentage,
                // 'tax_rate' => $input['tax_rate'][$i],
                'based_on_ref_if' => $reference_id
            );
        }

        if (isset($edit_id) && $edit_id) {

            $allowanceHistoryData = array();
            $getAllowanceData = $this->db->query("SELECT * FROM tbl_salary_grade_allowance_details WHERE grade_id=$edit_id")->result();
            if ($getAllowanceData) {
                foreach ($getAllowanceData as $key => $val) {
                    $allowanceHistoryData[] = array(
                        'grade_id' => $val->id,
                        'head_id' => $val->head_id,
                        'amount_type' => $val->amount_type,
                        'amount' => $val->amount,
                        'percentage' => $val->percentage,
                        'based_on_ref_if' => $val->based_on_ref_if,
                        'updated_at' => date("Y-m-d H:i:s", strtotime("now")),
                        'updated_by' => $_SESSION['user_id'],
                    );
                }
                $this->db->delete('tbl_salary_grade_allowance_details', array('grade_id' => $edit_id));
                if (!$this->db->affected_rows()) {
                    $result = 'Error! [' . $this->db->error() . ']';
                } else {
                    if ($allowanceHistoryData) :
                        $this->db->insert_batch('tbl_salary_grade_allowance_details_history', $allowanceHistoryData);
                        $allowanceHistoryData = [];
                    endif;
                }
            }
            if ($gdAllowanceData) :
                $this->db->insert_batch('tbl_salary_grade_allowance_details', $gdAllowanceData);
                $gdAllowanceData = [];
            endif;
            $result = 'Grade info updated successfully!';



            $deductionHistoryData = array();
            $getDedcutionData = $this->db->query("SELECT * FROM tbl_salary_grade_deduction_details WHERE grade_id=$edit_id")->result();

            if ($getDedcutionData) {
                foreach ($getDedcutionData as $key => $val) {
                    $deductionHistoryData[] = array(
                        'grade_id' => $val->id,
                        'head_id' => $val->head_id,
                        'amount_type' => $val->amount_type,
                        'amount' => $val->amount,
                        'percentage' => $val->percentage,
                        'based_on_ref_if' => $val->based_on_ref_if,
                        'updated_at' => date("Y-m-d H:i:s", strtotime("now")),
                        'updated_by' => $_SESSION['user_id'],
                    );
                }
                $this->db->delete('tbl_salary_grade_deduction_details', array('grade_id' => $edit_id));
                if (!$this->db->affected_rows()) {
                    $result = 'Error! [' . $this->db->error() . ']';
                } else {
                    if ($deductionHistoryData) :
                        $this->db->insert_batch('tbl_salary_grade_allowance_details_history', $deductionHistoryData);
                        $deductionHistoryData = [];
                    endif;
                }
            }
            if ($gdDeductionData) :
                $this->db->insert_batch('tbl_salary_grade_deduction_details', $gdDeductionData);
                $gdDeductionData = [];
            endif;
            $result = 'Grade info updated successfully!';
        } else {
            if ($gdAllowanceData) {
                $this->db->insert_batch('tbl_salary_grade_allowance_details', $gdAllowanceData);
                $gdAllowanceData = [];
                $result = 'Grade info inserted successfully!';
            }
            if ($gdDeductionData) {
                $this->db->insert_batch('tbl_salary_grade_deduction_details', $gdDeductionData);
                $gdDeductionData = [];
                $result = 'Grade info inserted successfully!';
            }
        }
        $this->db->trans_complete();
        // dd($gdAllowanceData,1);
        // dd($gdDeductionData);
        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', $this->db->error());
        } else {
            $this->db->trans_commit();

            $this->session->set_flashdata('message',  $result);
        }
        redirect('manage-grade');
    }
    function manageGrade()
    {
        $data['title'] = "Manage Grade";
        $criteria = $this->uri->segment(2);
        $key = $this->uri->segment(3);
        if ($criteria && $key) {
            switch ($criteria) {
                case 'edit':
                    $data['title'] = "Update Grade";
                    $data['earning_heads'] = $this->db->query('SELECT * FROM tbl_salary_heads WHERE head_type=1 AND status=1')->result();
                    $data['deduction_heads'] = $this->db->query('SELECT * FROM tbl_salary_heads WHERE head_type=2 AND status=1')->result();
                    $data['gradeData'] = $this->db->query("SELECT * FROM tbl_salary_grades WHERE id=$key")->row();
                    $data['editedGradeAllowanceData'] = $this->db->query("SELECT * FROM tbl_salary_grade_allowance_details WHERE grade_id=$key")->result();
                    $data['editedGradeDeductionData'] = $this->db->query("SELECT * FROM tbl_salary_grade_deduction_details WHERE grade_id=$key")->result();
                    $this->load->view('payroll/settings/create_grade', $data);
                    return FALSE;
                    break;
                case 'view':

                    break;
                case 'inactive':
                    $this->db->query("UPDATE tbl_salary_grades SET status=0 WHERE id=$key");
                    if ($this->db->affected_rows()) {
                        $this->session->set_flashdata('message', "Grade status successfully updated.");
                    } else {
                        $this->session->set_flashdata('message', $this->db->error());
                    }
                    break;
                case 'active':
                    $this->db->query("UPDATE tbl_salary_grades SET status=1 WHERE id=$key");
                    if ($this->db->affected_rows()) {
                        $this->session->set_flashdata('message', "Grade status successfully updated.");
                    } else {
                        $this->session->set_flashdata('message', $this->db->error());
                    }
                    break;
                case 'delete':

                    break;
            }
        }

        $data['grades'] = $this->db->query('SELECT * FROM tbl_salary_grades')->result();
        $this->load->view('payroll/settings/manage_grade', $data);
    }

    function viewGrade()
    {
        $key = $this->input->get('action_id');

        $data['gradeData'] = $this->db->query("SELECT * FROM tbl_salary_grades WHERE id=$key")->row();
        #dd($data['gradeData']);
        $data['GradeAllowanceData'] = $this->db->query("SELECT 
        ga.*,c.head_name as component_name,ref.head_name as ref_name 
        FROM tbl_salary_grade_allowance_details ga 
        LEFT JOIN tbl_salary_heads c 
        ON c.id=ga.head_id 
        LEFT JOIN tbl_salary_heads ref
        ON ref.id=ga.based_on_ref_if 
        WHERE ga.grade_id=$key")->result();
        $data['GradeDeductionData'] = $this->db->query("SELECT 
        ga.*,c.head_name as component_name,ref.head_name as ref_name 
        FROM tbl_salary_grade_deduction_details ga 
        LEFT JOIN tbl_salary_heads c 
        ON c.id=ga.head_id 
        LEFT JOIN tbl_salary_heads ref
        ON ref.id=ga.based_on_ref_if 
        WHERE ga.grade_id=$key")->result();
        $this->load->view('payroll/settings/view_grade', $data);
    }

    function gradeInfoById()
    {
        $gradeId = $this->input->get('grade_id');
        $data['salary_grade_allowances'] = $this->db->query("SELECT 
        MA.*,SH.short_name as head_short_name,SH2.short_name as based_on 
        FROM tbl_salary_grade_allowance_details MA 
        LEFT JOIN tbl_salary_heads SH ON SH.id=MA.head_id 
        LEFT JOIN tbl_salary_heads SH2 ON SH2.id=MA.based_on_ref_if 
        WHERE MA.grade_id=$gradeId")->result();
        $data['salary_grade_deductions'] = $this->db->query("SELECT 
        MA.*,SH.short_name as head_short_name,SH2.short_name as based_on
        FROM tbl_salary_grade_deduction_details MA 
        LEFT JOIN tbl_salary_heads SH ON SH.id=MA.head_id 
        LEFT JOIN tbl_salary_heads SH2 ON SH2.id=MA.based_on_ref_if 
        WHERE MA.grade_id=$gradeId")->result();
        #dd($data);

        echo json_encode($data);
    }

    function check_grade_name($grade_name)
    {
        if ($this->input->post('edit_id'))
            $edit_id = $this->input->post('edit_id');
        else
            $edit_id = '';
        $this->db->where('grade_name', $grade_name);
        if ($edit_id) {
            $this->db->where_not_in('id', $edit_id);
        }
        $result = $this->db->get('tbl_salary_grades')->num_rows();
        if ($result == 0)
            $response = true;
        else {
            $this->form_validation->set_message('check_grade_name', 'Sorry, that %s is already being used. grade must be unique');
            $response = false;
        }
        return $response;
    }
    function check_salary($emp_content_id)
    {
        if ($this->input->post('edit_id'))
            $edit_id = $this->input->post('edit_id');
        else
            $edit_id = '';

        $this->db->where('content_id', $emp_content_id);
        if ($edit_id) {
            $this->db->where_not_in('id', $edit_id);
        }
        $result = $this->db->get('emp_salary')->num_rows();
        #dd($this->db->last_query());
        // if ($result == 0)
        if ($edit_id || ($result == 0))
            $response = true;
        else {
            $this->form_validation->set_message('check_salary', 'Sorry, that %s is already being used. update the salary setup.');
            $response = false;
        }
        return $response;
    }

    function empGradeByContentId()
    {
        $contentId = $this->input->get('content_id');
        $gradeId = $this->db->query("SELECT grade FROM search_field_emp WHERE content_id='$contentId' ")->row('grade');
        echo $gradeId;
    }

    function addSalary()
    {
        $data['banks'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=10 AND status=1")->result();
        $data['pay_types'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=9 AND status=1")->result();
        $data['salary_earning_heads'] = $this->db->query("SELECT * FROM tbl_salary_heads WHERE head_type=1 AND status=1")->result();
        $data['salary_deduction_heads'] = $this->db->query("SELECT * FROM tbl_salary_heads WHERE head_type=2 AND status=1")->result();
        $data['active_employees'] = $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153/*Left*/,473/*Terminated*/)")->result();
        $data['salary_grades'] = $this->db->query("SELECT * FROM tbl_salary_grades WHERE status=1")->result();
        echo  $this->load->view('payroll/settings/add_salary', $data);
    }

    function viewSalary()
    {
        $view_id = $this->input->get('view_id');
        $data['view_data'] = $this->db->query("SELECT ES.*,EP.bank_id,EP.branch_name,EP.bank_account_no,EP.pay_type_id,EP.comments
        FROM emp_salary ES 
        LEFT JOIN emp_payment_method EP ON EP.content_id=ES.content_id
        WHERE ES.id=$view_id")->row();
        $contentId = $data['view_data']->content_id;
        $data['salary_history'] = $this->db->query("SELECT ES.*,GRADE.grade_name FROM emp_salary ES LEFT JOIN tbl_salary_grades GRADE ON GRADE.id=ES.grade_id WHERE ES.content_id=$contentId")->result();
        $data['banks'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=10 AND status=1")->result();
        $data['pay_types'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=9 AND status=1")->result();
        $data['salary_earning_heads'] = $this->db->query("SELECT * FROM tbl_salary_heads WHERE head_type=1 AND status=1")->result();
        $data['salary_deduction_heads'] = $this->db->query("SELECT * FROM tbl_salary_heads WHERE head_type=2 AND status=1")->result();
        $data['active_employees'] = $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153/*Left*/,473/*Terminated*/)")->result();
        $data['salary_grades'] = $this->db->query("SELECT * FROM tbl_salary_grades WHERE status=1")->result();
        echo  $this->load->view('payroll/settings/view_salary', $data);
    }

    function editSalary()
    {
        $edit_id = $this->input->get('edit_id');
        $data['edit_data'] = $this->db->query("SELECT ES.*,EP.bank_id,EP.branch_name,EP.bank_account_no,EP.pay_type_id,EP.comments
        FROM emp_salary ES 
        LEFT JOIN emp_payment_method EP ON EP.content_id=ES.content_id
        WHERE ES.id=$edit_id")->row();
        $data['banks'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=10 AND status=1")->result();
        $data['pay_types'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=9 AND status=1")->result();
        $data['salary_earning_heads'] = $this->db->query("SELECT * FROM tbl_salary_heads WHERE head_type=1 AND status=1")->result();
        $data['salary_deduction_heads'] = $this->db->query("SELECT * FROM tbl_salary_heads WHERE head_type=2 AND status=1")->result();
        $data['active_employees'] = $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153/*Left*/,473/*Terminated*/)")->result();
        $data['salary_grades'] = $this->db->query("SELECT * FROM tbl_salary_grades WHERE status=1")->result();
        echo  $this->load->view('payroll/settings/add_salary', $data);
    }

    function saveSalary()
    {
        date_default_timezone_set('Asia/Dhaka');
        $data['title'] = "Save Salary";
        $this->load->library('form_validation');
        $this->form_validation->set_rules('content_id', 'Employee', 'required|callback_check_salary');
        $this->form_validation->set_rules('grade_id', 'Grade ID', 'required');
        $this->form_validation->set_rules('basic', 'Basic', 'required|trim|numeric|max_length[50]');
        $this->form_validation->set_rules('hra', 'hra', 'trim|numeric');
        $this->form_validation->set_rules('ma', 'ma', 'trim|numeric');
        $this->form_validation->set_rules('ca', 'ca', 'trim|numeric');
        $this->form_validation->set_rules('ta', 'ta', 'trim|numeric');
        $this->form_validation->set_rules('da', 'da', 'trim|numeric');
        $this->form_validation->set_rules('mba', 'mba', 'trim|numeric');
        $this->form_validation->set_rules('ea', 'ea', 'trim|numeric');
        $this->form_validation->set_rules('oa', 'oa', 'trim|numeric');
        $this->form_validation->set_rules('pf', 'pf', 'trim|numeric');
        $this->form_validation->set_rules('td', 'td', 'trim|numeric');
        $this->form_validation->set_rules('od', 'od', 'trim|numeric');
        $this->form_validation->set_rules('gross_salary', 'gross salary', 'trim|numeric');
        $this->form_validation->set_rules('net_salary', 'net salary', 'trim|numeric');

        if ($this->form_validation->run() == FALSE) {
            # for ajax call
            // if( validation_errors() ){
            // 	exit("Submit Error:\n".strip_tags(validation_errors()));
            // }
            #dd(validation_errors());
            $this->session->set_flashdata('message', validation_errors());

            redirect('staff-salary');
        }
        $input = $this->input->post();

        $contentId = $input['content_id'];
        $empInfo = $this->db->query("SELECT * FROM search_field_emp WHERE content_id=$contentId")->row();
        $gradeId = $input['grade_id'];

        $actionTime = date("Y-m-d H:i:s", strtotime("now"));
        $actionBy = $_SESSION['user_id'];
        $salaryData = array(
            'content_id' => $contentId,
            'grade_id' => $gradeId,
            //'increment_amt' => $input['increment_amt'],
            'effective_date' => date('Y-m-d', strtotime($empInfo->joining_date)),
            'basic' => $input['basic'],
            'hra' => $input['hra'],
            'ma' => $input['ma'],
            'ca' => $input['ca'],
            'ta' => $input['ta'],
            'da' => $input['da'],
            'mba' => $input['mba'],
            'ea' => $input['ea'],
            'oa' => $input['oa'],
            'pf' => $input['pf'],
            'td' => $input['td'],
            'od' => $input['od'],
            'gross_salary' => $input['gross_salary'],
            'net_salary' => $input['net_salary'],
            'comments' => $input['comments'],
            'created_at' => $actionTime,
            'created_by' => $actionBy
        );
        #dd($salaryData);
        $paymentData = array(
            'content_id' => $input['content_id'],
            'bank_id' => $input['bank_id'],
            'branch_name' => $input['branch_name'],
            'bank_account_no' => $input['account_no'],
            'pay_type_id' => $input['pay_type_id'],
            'comments' => $input['comments'],
            'created_at' => date("Y-m-d H:i:s", strtotime("now")),
            'created_by' => $_SESSION['user_id']
        );

        if ($editId = $input['edit_id']) {
            $this->db->where('id', $editId)->update('emp_salary', $salaryData);
            $this->db->where('content_id', $input['content_id'])->update('emp_payment_method', $paymentData);
            $this->session->set_flashdata('message', "Salary data updated successfully!");
            $this->db->query("UPDATE search_field_emp SET grade=$gradeId,updated_at='$actionTime',updated_by=$actionBy WHERE content_id=$contentId");
        } else {
            $this->db->insert('emp_salary', $salaryData);
            $this->db->insert('emp_payment_method', $paymentData);
            $this->session->set_flashdata('message', "Salary added successfully!");
            $this->db->query("UPDATE search_field_emp SET grade=$gradeId,updated_at='$actionTime',updated_by=$actionBy WHERE content_id=$contentId");
        }

        redirect('staff-salary');
        // if ($this->db->inset_id()) {
        //     $this->session->set_flashdata('message', "Salary setup successfully!");
        // } else {
        //     $this->session->set_flashdata('message', "Something went wrong!");
        // }

    }


    function staffSalary()
    {
        $data['title'] = "Staff Salary";
        $data['employee_salaries'] = $this->db->query("SELECT ES.id,ES.gross_salary,
        SFE.emp_name,SFE.emp_id,SFE.mobile_no,
        SFE.joining_date,ED.field_value as profile_picture,
        DESIGNATION.name as designation_name,
        salary_grade.grade_name,
        DIVISION.name as DivisionName
        FROM emp_salary ES 
        LEFT JOIN search_field_emp SFE ON SFE.content_id=ES.content_id 
        LEFT JOIN taxonomy DIVISION ON DIVISION.tid=SFE.emp_department 
        LEFT JOIN taxonomy DESIGNATION ON DESIGNATION.tid =SFE.emp_post_id
        LEFT JOIN tbl_salary_grades salary_grade ON salary_grade.id =ES.grade_id
        LEFT JOIN emp_details ED ON ED.content_id=ES.content_id AND ED.field_name='resources/uploads'
        WHERE SFE.type_of_employee 
        NOT IN (153/*Left*/,473/*Terminated*/)
        AND ES.id IN (
            SELECT MAX(id)
            FROM emp_salary
            GROUP BY content_id
        )")->result();
        $this->load->view('payroll/settings/staff_salary', $data);
    }

    function incrementSalary()
    {
        $view_id = $this->input->get('view_id');
        $data['view_data'] = $this->db->query("SELECT ES.*,EP.bank_id,EP.branch_name,EP.bank_account_no,EP.pay_type_id,EP.comments
        FROM emp_salary ES 
        LEFT JOIN emp_payment_method EP ON EP.content_id=ES.content_id
        WHERE ES.id=$view_id")->row();
        $contentId = $data['view_data']->content_id;
        $data['salary_history'] = $this->db->query("SELECT ES.*,GRADE.grade_name FROM emp_salary ES LEFT JOIN tbl_salary_grades GRADE ON GRADE.id=ES.grade_id WHERE ES.content_id=$contentId")->result();
        $data['banks'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=10 AND status=1")->result();
        $data['pay_types'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=9 AND status=1")->result();
        $data['salary_earning_heads'] = $this->db->query("SELECT * FROM tbl_salary_heads WHERE head_type=1 AND status=1")->result();
        $data['salary_deduction_heads'] = $this->db->query("SELECT * FROM tbl_salary_heads WHERE head_type=2 AND status=1")->result();
        $data['active_employees'] = $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153/*Left*/,473/*Terminated*/)")->result();
        $data['salary_grades'] = $this->db->query("SELECT * FROM tbl_salary_grades WHERE status=1")->result();
        echo  $this->load->view('payroll/settings/increment_salary', $data);
    }

    function saveIncrement()
    {
        date_default_timezone_set('Asia/Dhaka');
        $data['title'] = "Save Salary";
        $this->load->library('form_validation');
        $this->form_validation->set_rules('increment_amount', 'increment_amount', 'required|trim|numeric');
        $this->form_validation->set_rules('effective_date', 'effective_date', 'required');
        $this->form_validation->set_rules('edit_content_id', 'Employee', 'required');
        $this->form_validation->set_rules('grade_id', 'Grade ID', 'required');
        $this->form_validation->set_rules('basic', 'Basic', 'required|trim|numeric|max_length[50]');
        $this->form_validation->set_rules('hra', 'hra', 'trim|numeric');
        $this->form_validation->set_rules('ma', 'ma', 'trim|numeric');
        $this->form_validation->set_rules('ca', 'ca', 'trim|numeric');
        $this->form_validation->set_rules('ta', 'ta', 'trim|numeric');
        $this->form_validation->set_rules('da', 'da', 'trim|numeric');
        $this->form_validation->set_rules('mba', 'mba', 'trim|numeric');
        $this->form_validation->set_rules('ea', 'ea', 'trim|numeric');
        $this->form_validation->set_rules('oa', 'oa', 'trim|numeric');
        $this->form_validation->set_rules('pf', 'pf', 'trim|numeric');
        $this->form_validation->set_rules('td', 'td', 'trim|numeric');
        $this->form_validation->set_rules('od', 'od', 'trim|numeric');
        $this->form_validation->set_rules('gross_salary', 'gross salary', 'trim|numeric');
        $this->form_validation->set_rules('net_salary', 'net salary', 'trim|numeric');

        if ($this->form_validation->run() == FALSE) {
            # for ajax call
            // if( validation_errors() ){
            // 	exit("Submit Error:\n".strip_tags(validation_errors()));
            // }
            #dd(validation_errors());
            $this->session->set_flashdata('message', validation_errors());

            redirect('staff-salary');
        }
        $input = $this->input->post();
        $contentId = $input['edit_content_id'];
        $empSalaryInfo = $this->db->query("SELECT * FROM emp_salary WHERE content_id=$contentId ORDER BY id DESC LIMIT 1")->row();

        if (strtotime($input['effective_date']) < strtotime($empSalaryInfo->effective_date)) {
            $this->session->set_flashdata('message', "Invalid effective date.");
            redirect('staff-salary');
        }
        #dd($input['effective_date']);
        $salaryData = array(
            'content_id' => $contentId,
            'grade_id' => $input['grade_id'],
            'increment_based_on' => $input['increment_based_on'],
            'increment_amt' => $input['increment_amount'],
            'effective_date' =>  date('Y-m-d',strtotime($input['effective_date'])),
            'basic' => $input['basic'],
            'hra' => $input['hra'],
            'ma' => $input['ma'],
            'ca' => $input['ca'],
            'ta' => $input['ta'],
            'da' => $input['da'],
            'mba' => $input['mba'],
            'ea' => $input['ea'],
            'oa' => $input['oa'],
            'pf' => $input['pf'],
            'td' => $input['td'],
            'od' => $input['od'],
            'gross_salary' => $input['gross_salary'],
            'net_salary' => $input['net_salary'],
            'comments' => $input['comments'],
            'created_at' => date("Y-m-d H:i:s", strtotime("now")),
            'created_by' => $_SESSION['user_id']
        );


        $this->db->insert('emp_salary', $salaryData);
        if ($this->db->insert_id()) {
            $this->session->set_flashdata('message', "Salary increment successfully!");
        }
        redirect('staff-salary');
        // if ($this->db->inset_id()) {
        //     $this->session->set_flashdata('message', "Salary setup successfully!");
        // } else {
        //     $this->session->set_flashdata('message', "Something went wrong!");
        // }

    }

    function advanceSalary()
    {
        $data['title'] = "Advance Salary";
        $data['advance_salaries'] = $this->db->query("SELECT ADSAL.*,
        SFE.emp_name,SFE.emp_id,SFE.mobile_no        
        FROM tbl_advance_salary ADSAL 
        LEFT JOIN search_field_emp SFE ON SFE.content_id=ADSAL.content_id 
        ")->result();
        $this->load->view('payroll/advance_salary/manage_advance_salary', $data);
    }
    function addAdvanceSalary()
    {
        $data['active_employees'] = $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153/*Left*/,473/*Terminated*/)")->result();
        $data['months'] = $this->db->query("SELECT * FROM tbl_month")->result();
        $data['years'] = $this->db->query("SELECT * FROM tbl_years")->result();
        echo  $this->load->view('payroll/advance_salary/add_advance_salary', $data);
    }
    function saveAdvanceSalary()
    {
        date_default_timezone_set('Asia/Dhaka');
        $data['title'] = "Save Advance Salary";
        $this->load->library('form_validation');
        $this->form_validation->set_rules('content_id', 'Employee', 'required|callback_check_advance_salary');
        $this->form_validation->set_rules('payment_type', 'Payment type', 'required');
        $this->form_validation->set_rules('payment_date', 'payment_date', 'required|callback_valid_date');
        $this->form_validation->set_rules('adjust_month', 'adjust_month', 'required');
        $this->form_validation->set_rules('adjust_year', 'adjust_month', 'required');
        $this->form_validation->set_rules('amount', 'amount', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            # for ajax call
            // if( validation_errors() ){
            // 	exit("Submit Error:\n".strip_tags(validation_errors()));
            // }
            #dd(validation_errors());
            $this->session->set_flashdata('message', validation_errors());

            redirect('advance-salary');
        }
        $input = $this->input->post();
        // dd($input);
        $contentId = $input['content_id'];

        $actionTime = date("Y-m-d H:i:s", strtotime("now"));
        $actionBy = $_SESSION['user_id'];
        $salaryData = array(
            'content_id' => $contentId,
            'payment_date' => $input['payment_date'],
            'payment_type' => $input['payment_type'],
            'adjust_month' => $input['adjust_month'],
            'adjust_year' => $input['adjust_year'],
            'amount' => $input['amount'],
            'created_at' => $actionTime,
            'created_by' => $actionBy
        );

        if ($editId = $input['edit_id']) {
            $this->db->where('id', $editId)->update('tbl_advance_salary', $salaryData);
            $this->session->set_flashdata('message', "Salary data updated successfully!");
        } else {
            $this->db->insert('tbl_advance_salary', $salaryData);
            $this->session->set_flashdata('message', "Salary added successfully!");
        }

        redirect('advance-salary');
    }
    function editAdvanceSalary()
    {
        $edit_id = $this->input->get('edit_id');
        $data['edit_data'] = $this->db->query("SELECT *
        FROM tbl_advance_salary 
        WHERE id=$edit_id")->row();
        $data['active_employees'] = $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153/*Left*/,473/*Terminated*/)")->result();
        $data['months'] = $this->db->query("SELECT * FROM tbl_month")->result();
        $data['years'] = $this->db->query("SELECT * FROM tbl_years")->result();
        echo  $this->load->view('payroll/advance_salary/add_advance_salary', $data);
    }
    public function valid_date($date)
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        if ($d && $d->format('Y-m-d') === $date) {
            return true;
        }
        $this->form_validation->set_message('valid_date', 'The Payment Date field must be yyyy-mm-dd');
        return false;
    }
    function check_advance_salary($emp_content_id)
    {
        $adjust_month = $this->input->post('adjust_month');
        $adjust_year = $this->input->post('adjust_year');
        if ($this->input->post('edit_id'))
            $edit_id = $this->input->post('edit_id');
        else
            $edit_id = '';

        $this->db->where('content_id', $emp_content_id);
        $this->db->where('adjust_month', $adjust_month);
        $this->db->where('adjust_year', $adjust_year);
        if ($edit_id) {
            $this->db->where_not_in('id', $edit_id);
        }
        $result = $this->db->get('tbl_advance_salary')->num_rows();
        #dd($this->db->last_query());
        // if ($result == 0)
        if ($edit_id || ($result == 0))
            $response = true;
        else {
            $this->form_validation->set_message('check_advance_salary', 'Sorry, Duplicate record found!');
            $response = false;
        }
        return $response;
    }
    function SinglePaySlipGenerator()
    {
        $this->load->model('emp_attendance_model');
        if ($this->input->post('add_btn')) {

            $postData = $this->input->post();

            $emp_content_id = $postData['emp_content_id'];
            $year = $postData['year'];
            $monthId = $postData['salary_month'];

            $empInfo = $this->Payroll_model->getEmpInfoByContentId($emp_content_id);
            $emp_joining_date = $empInfo->joining_date;
            $emp_division_id = $empInfo->emp_division;

            $monthStartDate = "$year-$monthId-01";
            $monthEndDate = date("Y-m-t", strtotime($monthStartDate));
            $dateRange = dateRange($monthStartDate, $monthEndDate);
            $servertime = time();
            $late_counter = 0;
            $early_counter = 0;
            $absent_counter = 0;
            $absent_halfday_counter = 0;
            $leave_with_pay = 0;
            $daily_movement = 0;
            $leave_without_pay = 0;
            $half_day_absent_status = "";
            $early_status = "";
            $late_status = "";
            $today = date("d-m-Y", $servertime);
            foreach ($dateRange as $single_date) {
                if (strtotime($single_date) >= strtotime($emp_joining_date)) {
                    $empatt_start_date_arr = explode("-", $single_date);
                    $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
                    $emp_shift_time = $this->db->query("select * from emp_shift_history WHERE content_id ='$emp_content_id' AND str_to_date(start_date, '%d-%m-%Y') <='$emp_att_start_date' ORDER BY ID DESC LIMIT 1")->row_array();
                    //                $emp_shift_time = $this->emp_working_time_model->getworkingtimeBydateandid($emp_content_id, $single_date);
                    $attendance_required = $emp_shift_time['attendance_required'];
                    $work_starting_time = $emp_shift_time['work_starting_time'];
                    $work_ending_time = $emp_shift_time['work_ending_time'];
                    $logout_required = $emp_shift_time['logout_required'];
                    $year = date('Y', strtotime($single_date));

                    $empatt_start_date_arr = explode("-", $single_date);
                    $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];

                    $emp_latecount_time = $emp_shift_time['emp_latecount_time'];
                    $emp_earlycount_time = $emp_shift_time['emp_earlycount_time'];
                    //                }             
                    $half_day_absent = $emp_shift_time['half_day_absent'];
                    $absent_count_time = $emp_shift_time['absent_count_time'];
                    $overtime_count = $emp_shift_time['overtime_count'];

                    $tstamp1 = strtotime($default_date);
                    $dated_day_name1 = date("D", $tstamp1);
                    $dated_day_name1 = strtolower($dated_day_name1);
                    if ($emp_division_id == 301 && $dated_day_name1 == 'thu') {
                        $work_ending_time = "16:00:00";
                        $emp_earlycount_time = "16:00:00";
                    }
                    // Check Attendance log mantainance ----------------------------------------------------------------------------
                    $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,"
                        . "half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status "
                        . "FROM log_maintenence WHERE content_id=$emp_content_id and start_date='$single_date' "
                        . "order by id DESC LIMIT 1")->row_array();

                    if (!$has_log_attendance_error) {

                        $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status FROM log_maintenence 
                                    WHERE division_id='$emp_division_id' and start_date='$single_date' order by id DESC LIMIT 1")->row_array();
                    }
                    $division = "all";
                    if (!$has_log_attendance_error) {
                        $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status FROM log_maintenence 
                                    WHERE division_id='$division' and start_date='$single_date' order by id DESC LIMIT 1")->row_array();
                    }


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
                        // If before December 01, 2018 ----------------------------------------------------
                        $attendance_info = $this->db->query("SELECT login_time,logout_time,remarks "
                            . "FROM emp_attendance_old "
                            . "WHERE content_id=$emp_content_id AND attendance_date='$single_date' "
                            . "ORDER BY id DESC")->row_array();
                    } else {
                        // If after November 30, 2018 ------------------------------------------------------
                        $attendance_info = $this->db->query("SELECT login_time,logout_time,remarks "
                            . "FROM emp_attendance "
                            . "WHERE content_id=$emp_content_id AND attendance_date='$single_date' "
                            . "ORDER BY id DESC")->row_array();
                    }
                    $login_time = $attendance_info['login_time'];
                    $logout_time = $attendance_info['logout_time'];
                    // Attendance Information check( Daily movement) -------------------------------------------------------------
                    $emp_informed_info = $this->db->query("SELECT presence_status,logout_status,reason,remarks FROM emp_informed WHERE content_id=$emp_content_id AND attendance_date='$single_date' ORDER BY id DESC")->row_array();

                    // Holiday Check ---------------------------------------------------------------------------------------------
                    $holiday_exist = $this->db->query("SELECT eyh.holiday_type,t.name as holiday_name "
                        . "FROM emp_yearlyholiday eyh "
                        . "LEFT JOIN taxonomy t ON t.tid=eyh.holiday_type "
                        . "WHERE eyh.holiday_for_division='$division' AND eyh.holiday_start_date='$single_date' "
                        . "ORDER BY eyh.id DESC LIMIT 1")->row_array();
                    if (!$holiday_exist) {
                        $division = $emp_division_id;
                        $holiday_exist = $this->db->query("SELECT eyh.holiday_type,t.name as holiday_name "
                            . "FROM emp_yearlyholiday eyh "
                            . "LEFT JOIN taxonomy t ON t.tid=eyh.holiday_type "
                            . "WHERE eyh.holiday_for_division='$division' AND eyh.holiday_start_date='$single_date' "
                            . "ORDER BY eyh.id DESC")->row_array();
                    }
                    if ($holiday_exist) {
                        // If holiday -------------------------------------
                        $holiday_type_tid = $holiday_exist['holiday_type'];
                        $holiday_name = $holiday_exist['holiday_name']; // this will be echoed
                        $remarks = $holiday_exist['holiday_name'];
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

                        if (($remarks != "Weekly Holiday") || ($log_weekly_holiday == 'working_day')) {
                            //                                   $leave_exist = $this->emp_leave_model->getemp_leave($emp_content_id, $single_date);
                            //                                   $leave_exist = $this->db->query("SELECT leave_type,justification FROM emp_leave WHERE content_id='$emp_content_id' AND leave_start_date='$single_date' ORDER BY id DESC")->row_array();
                            $leave_exist = $this->db->query("SELECT el.leave_type,el.justification,t.name as leave_name "
                                . "FROM emp_leave el "
                                . "LEFT JOIN taxonomy t ON t.tid=el.leave_type "
                                . "WHERE el.content_id='$emp_content_id' "
                                . "AND el.leave_start_date='$single_date' ORDER BY el.id DESC")->row_array();

                            if ($leave_exist) {

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
                                        } else if (strtotime($emp_earlycount_time) > strtotime($logout_time)) {
                                            $half_absent_found = "Half Day Absent";
                                        } else {
                                            $half_absent_found = "Half Day Absent";
                                        }
                                    } else if ($late_status == "Late_Not_Count") {
                                        $remarks = $reason;
                                    } else if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                        $login_time = "<font color=red >" . $login_time . "</font>";
                                    } else {
                                    }
                                } else {
                                    //echo $emp_latecount_time;
                                    if ($presence_status_informed) {
                                        $presence_status = $presence_status_informed;
                                        $remarks = $informed_remarks;
                                        if ($presence_status == 'A') {
                                            $login_time = "";
                                            $logout_time = "";
                                        }
                                    } else if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                        $emp_late_found = "Late";
                                    } else {
                                    }
                                }
                            }
                        }
                    }

                    // if not login but logout after 04:00 PM ....................................................
                    if (!$logout_time && $login_time && $login_time >= "16:00:00") {
                        $logout_time = $login_time;
                        $login_time = "";
                    }

                    // Counter Start ------------------------------------------------------------------------------------------------------------
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
                        if ($reason_informed == 'personal') {
                            $daily_movement_personal++;
                        }
                        if ($presence_status == 'A') {
                            $absent_counter++;
                        } else if ($presence_status == 'P' && $logout_status_informed == 'P') {
                        } else if ($presence_status == 'P' && $logout_status_informed == 'E') {
                            $early_counter++;
                        } else if ($presence_status == 'L' && $logout_status_informed == 'E') {
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
                                $late_counter++;
                            } else {
                                $late_counter++;
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
                    // If today stop loop -----------
                    if (strtotime($single_date) >= strtotime($today)) {
                        break;
                    }
                }
            }

            $empSalaryInfo = $this->Payroll_model->getEmpSalaryInfoByContentId($emp_content_id, $monthStartDate);
            $empSalaryDeductInfo = $this->Payroll_model->getEmpSalaryDeductInfoById($emp_content_id);
            $empPaymentMethodInfo = $this->Payroll_model->getEmpPaymentMethodInfoById($emp_content_id);
            // Check payslip validation by employee joining date -------------
            if ((strtotime($empJoiningDate) <= strtotime($monthEndDate))) {
                $grossSalary = $empSalaryInfo->gross_salary;
                $basicSalary = $grossSalary / 2;
                //          ========= Allowances Info =====================================
                $houseRent = ($basicSalary * 60) / 100;
                $medicalAllow = ($basicSalary * 20) / 100;
                $transportAllow = ($basicSalary * 10) / 100;
                $othersAllow = ($basicSalary * 10) / 100;
                $empSpecialBonus = 0;
                $festivalBonus = $postData['festival_bonus'];

                if ($festivalBonus == 'true') {
                    $festivalBonus = $basicSalary;
                } else {
                    $festivalBonus = 0;
                }

                $telephoneAllow = $empSalaryInfo->telephone_allow;
                //          Special Bonus Info -------------
                $specialBonus = 0;
                //  ========== Deduction Info =======================================
                $pf = $empSalaryDeductInfo->provident_fund_deduction;
                $tax = $empSalaryDeductInfo->tax_deduction;
                $other_deduction = $empSalaryDeductInfo->other_deduction;
                //          Loan Info ----------------
                $loanInfo = $this->Payroll_model->getLoanInfoByContentId($emp_content_id, $monthId, $year);

                $loanDisbursementId = $loanInfo->id;
                $pricipalAmount = $loanInfo->principal_amount;
                if (!$pricipalAmount) {
                    $pricipalAmount = 0;
                }
                $interestAmount = $loanInfo->interest_amount;
                if (!$interestAmount) {
                    $interestAmount = 0;
                }
                $penaltyAmount = 0;
                // Installment date over -----
                //            if($istallmentDate<$postData['generated_date']){
                //               $penaltyAmount = $loanInfo->penalty_amount; 
                //            }
                $totalLoanPaymentAmount = ($pricipalAmount + $interestAmount + $penaltyAmount);

                // $lateEarlyDay = $late_counter + $early_counter;
                // $absentDay = $absent_counter;
                $lateEarlyDay = 0;
                $absentDay = 0;
                $lateEarlyDeduction = 0;
                $absentDeduction = ($grossSalary / 30) * $absentDay;
                if (!$absentDeduction) {
                    $absentDeduction = 0;
                }

                $total = ($grossSalary + $telephoneAllow + $specialBonus + $festivalBonus);
                $totalDeduction = ($pf + $tax + $lateEarlyDeduction + $absentDeduction + $totalLoanPaymentAmount);
                $netPayment = ($total - $totalDeduction);

                //            echo $total;
                //            exit;

                $paramsData = array(
                    //'account_id' => $postData['account_id'],
                    'year' => $postData['year'],
                    'month_id' => $postData['salary_month'],
                    'pay_from' => date('Y-m-d', strtotime($monthStartDate)),
                    'pay_to' => date('Y-m-d', strtotime($monthEndDate)),
                    'content_id' => $emp_content_id,
                    'reimbursment_date' => date('Y-m-d', strtotime($postData['generated_date'])),
                    'payment_date' => '',
                    'division_id' => $empInfo->emp_division,
                    'department_id' => $empInfo->emp_department,
                    'grade_id' => $empInfo->grade,
                    'emp_post_id' => $empInfo->emp_post_id,
                    'basic' => $basicSalary,
                    'hra' => $houseRent,
                    'ma' => $medicalAllow,
                    'ta' => $transportAllow,
                    'oa' => $othersAllow,
                    'telephone_allow' => $telephoneAllow,
                    'bonus' => $empSpecialBonus,
                    'festival_bonus' => $festivalBonus,
                    'ot_hour' => '',
                    'ot_taka' => '',
                    'gross_salary' => $grossSalary,
                    'total' => $total,
                    'pf' => $pf,
                    'tax' => $tax,
                    'other_deduct' => $other_deduction,
                    'loan' => $totalLoanPaymentAmount,
                    'loan_disbursement_id' => $loanDisbursementId,
                    'late_early_day' => $lateEarlyDay,
                    'late_early_taka' => $lateEarlyDeduction,
                    'absent_day' => $absentDay,
                    'absent_day_taka' => $absentDeduction,
                    'total_deduction' => $totalDeduction,
                    'net_salary' => $netPayment,
                    'payment_method_id' => $empPaymentMethodInfo->emp_pay_type
                );
                //            echo "<pre>";
                //            print_r($paramsData);
                //            exit;
                $checkExist = $this->Payroll_model->getPaySlipExist($emp_content_id, $monthId, $year);
                if ($checkExist) {
                    $this->session->set_flashdata('error', "Pay slip already Exist! <a href='pay-slip-confirmation'>Go to Pay Slip Confirmation.</a> ");
                    //redirect('pay-slip-generation');
                    //  break;
                    //echo "Exist"; 
                    /*
                      $paramsData['updated_at'] = $this->current_time();
                      $paramsData['updated_by'] = $this->session->userdata('user_id');
                      $updateCondition = array('id' => $checkExist->id);
                      $result = $this->Payroll_model->updatePayslipGeneratorData($paramsData, $updateCondition);
                      if ($result == true) {
                      $this->session->set_flashdata('success', "Pay slip updated successfully! ");
                      } else {
                      $this->session->set_flashdata('error', "Pay slip not updated!");
                      }
                     */
                } else {
                    //echo "Not Exist";                
                    $paramsData['created_at'] = $this->current_time();
                    $paramsData['created_by'] = $this->session->userdata('user_id');
                    $result = $this->Payroll_model->insertPayslipGeneratorData($paramsData);
                    if ($result == true) {
                        // loan payment update --------------
                        /*
                          if($totalLoanPaymentAmount>0){
                          $this->Payroll_model->updateLoanInfo($loanInfo->loan_id,$totalLoanPaymentAmount);
                          $this->Payroll_model->updateLoanDisbursementInfo($loanDisbursementId);
                          }
                         */
                        $this->session->set_flashdata('success', "Pay slip generated successfully!  <a href='pay-slip-confirmation'>Go to Pay Slip Confirmation.</a> ");
                    } else {
                        $this->session->set_flashdata('error', "Pay slip not generated!");
                    }
                }
            }
            $late_counter = 0;
            $early_counter = 0;
            $absent_counter = 0;
            $absent_halfday_counter = 0;
            $leave_with_pay = 0;
            $daily_movement = 0;
            $leave_without_pay = 0;
            $half_day_absent_status = "";
            $early_status = "";
            $late_status = "";

            redirect('pay-slip-generation');
        }

        $userId = $this->session->userdata('user_id');
        $userDivision = $this->session->userdata('user_division');
        $userDepartment = $this->session->userdata('user_department');
        $userAccountGroupId = $this->session->userdata('user_permitted_account_group');

        if ($userId == 16) {

            $data['employees'] = $this->Payroll_model->getActiveEmployee();
        } else {

            if (!$userDepartment) {
                $data['employees'] = $this->search_field_emp_model->getallemployeebydivision($userDivision);
            } else {
                $data['employees'] = $this->search_field_emp_model->getAllEmployeeByDivisionAndDepartment($userDivision, $userDepartment);
            }
        }
        $this->load->view('payroll/single-payslip-generator', $data);
    }

    public function singlePaySlipGeneratorManual()
    {
        $userId = $this->session->userdata('user_id');
        $userDivision = $this->session->userdata('user_division');
        $userDepartment = $this->session->userdata('user_department');
        $userAccountGroupId = $this->session->userdata('user_permitted_account_group');
        if ($this->input->post('add_btn')) {
            $postData = $this->input->post();
            $year = $postData['year'];
            $monthId = $postData['salary_month'];
            $empContentId = $postData['emp_content_id'];
            //              echo $emp_content_id;
            //            $singleEmp = $this->Payroll_model->getEmployeeInfoById($emp_content_id, $monthId, $year, $userDivision, $userDepartment);
            $singleEmp = $this->Payroll_model->getEmployeeInfoFromJobHostoryById($empContentId, $monthId, $year);
            //            echo "<pre/>";
            //            print_r($singleEmp);
            //            exit;
            //$this->employeePaySlipGenerator($postData, $emp_content_id);
            $this->empPayslipGeneratorByJobHistry($postData, $singleEmp);
            redirect('single-payslip-generation');
        }

        if ($userId == 16) {
            //$data['employees'] = $this->Payroll_model->getActiveEmployee();
            $data['employees'] = $this->Payroll_model->getAllEmployee();
        } else {
            if (!$userDepartment) {
                //                $data['employees'] = $this->search_field_emp_model->getallemployeebydivision($userDivision); //without left & terminated
                // By job history ---
                $data['employees'] = $this->Payroll_model->getEmpListByDivision($userDivision);
                //             echo "<pre/>";
                //            print_r($data['employees']);
                //            exit;
            } else {
                //$data['employees'] = $this->search_field_emp_model->getAllEmployeeByDivisionAndDepartment($userDivision, $userDepartment); //without left & terminated
                // get employee by division and department with left & terminated --------------
                // by job history -----
                $data['employees'] = $this->Payroll_model->getEmpListByDepartment($userDivision, $userDepartment);
            }
        }
        $this->load->view('payroll/single-payslip-generator', $data);
    }

    public function divisionPaySlipGeneratorManual()
    {
        if ($this->input->post('add_btn')) {
            $postData = $this->input->post();
            $empCompany = $postData['emp_company'];
            $empDivision = $postData['emp_division'];
            $year = $postData['year'];
            $monthId = $postData['salary_month'];

            $data = array();
            if (!$empDivision) {
                //$data['default_employee'] = $this->search_field_emp_model->getallemployeebydivision($emp_division); //without left & terminated
                // $data['default_employee'] = $this->Payroll_model->getAllEmployeeByDivision($emp_division); //with left & terminated
                // get employee by job history ---------------
                $data['default_employee'] = $this->Payroll_model->getEmployeeByCompany($empCompany, $monthId, $year);
            } else {
                //$data['default_employee'] = $this->search_field_emp_model->getAllEmployeeByDivisionAndDepartment($emp_division, $emp_department); //without left & terminated
                // get employee by division and department with left & terminated --------------
                // $data['default_employee'] = $this->Payroll_model->getAllEmployeeByDivisionAndDepartment($emp_division, $emp_department);
                // get employee by job history ---------------
                $data['default_employee'] = $this->Payroll_model->getEmployeeByCompanyAndDivision($empCompany, $empDivision, $monthId, $year);
            }
            //    echo "<pre/>";
            //    print_r($data['default_employee']);
            //    exit;           
            $remarks = '';
            #dd($data['default_employee']);
            $staffSalarySetupNotFound = 0;
            $payslipGenerated = 0;
            $payslipExist = 0;
            $payslipError = 0;
            foreach ($data['default_employee'] as $singleEmp) {
                $empContentId = $singleEmp['content_id'];
                // $emp_content_id=663;
                //$this->employeePaySlipGenerator($postData, $emp_content_id);
                $year = $postData['year'];
                $monthId = $postData['salary_month'];
                $monthStartDate = "$year-$monthId-01";
                ## get salary by effective date ----
                $empSalaryInfo = $this->Payroll_model->getEmpSalaryInfoByContentId($empContentId, $monthStartDate);

                if (!$empSalaryInfo) {
                    $staffSalarySetupNotFound++;
                    continue;
                }

                $res = $this->empPayslipGeneratorByJobHistry($postData, $singleEmp, $empSalaryInfo);
                if ($res == 'generated') {
                    $payslipGenerated++;
                } elseif ($res == 'exist') {
                    $payslipExist++;
                } elseif ($res == 'error') {
                    $payslipError++;
                }
                // dd($monthStartDate);  
                $remarks = '';
            }
            if ($payslipGenerated > 0) {
                $this->session->set_flashdata('generated', $payslipGenerated . " payslip generated successfully!  <a href='pay-slip-confirmation' style='text-decoration:underline;font-style:italic'>Go to Pay Silp Confirmation</a>");
            }
            if ($payslipExist > 0) {
                $this->session->set_flashdata('exist', $payslipExist . " payslip already Exist! <a href='pay-slip-confirmation' style='text-decoration:underline;font-style:italic'>Go to Pay Silp Confirmation</a> for confirm.");
            }
            if ($payslipError > 0) {
                $this->session->set_flashdata('generate_error', $payslipError . " payslip not generated. somthing went wrong.");
            }
            if ($staffSalarySetupNotFound > 0) {
                $this->session->set_flashdata('error', $staffSalarySetupNotFound . " staff salary setup not found! Please setup the salary first.");
            }
            redirect('division-pay-slip-generation-manual');
        }
        $userId = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type');

        $userDivision = $this->session->userdata('user_division');
        $userDepartment = $this->session->userdata('user_department');
        if ($user_type = 1 || $userId == 16) {
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid(1);
        } else {
            if ($userDepartment) {
                $data['department_selected'] = $this->taxonomy->getTaxonomyBytid($userDepartment);
            } else {
                $data['department_selected'] = $this->taxonomy->getTaxonomychildbyparent($userDivision);
            }
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($userDivision);
        }
        //print_r($data['alldivision']);exit;
        $data['years'] = $this->db->query("SELECT * FROM tbl_years WHERE status=1")->result();
        $this->load->view('payroll/manual-payslip-generator', $data);
    }

    function empPayslipGeneratorByJobHistry($postData, $singleEmp, $empSalaryInfo)
    {
        // print_r($singleEmp); exit;
        $empContentId = $singleEmp['content_id'];
        $empCompanyId = $singleEmp['division_tid'];
        $empDivisionId = $singleEmp['department_tid'];
        $empDepartmentId = $singleEmp['department_id'];
        $empPostId = $singleEmp['post_tid'];
        $empGradeId = $singleEmp['grade_tid'];
        $emptypeId = $singleEmp['emp_type_tid'];
        $empJoiningDate = $singleEmp['joining_date'];
        $startDate = $singleEmp['start_date'];
        $endDate = $singleEmp['end_date'];

        $year = $postData['year'];
        $monthId = $postData['salary_month'];
        $monthStartDate = "$year-$monthId-01";
        $monthEndDate = date("Y-m-t", strtotime($monthStartDate));

        // $empSalaryInfo = $this->Payroll_model->getEmpSalaryInfoByContentId($empContentId, $monthStartDate);

        // if (!$empSalaryInfo) {
        //    // $staffSalarySetupNotFound++;
        //    //dd(54,1);
        //     continue;
        //     dd(55);
        // }
        //dd($empSalaryInfo);
        #$empSalaryDeductInfo = $this->Payroll_model->getEmpSalaryDeductInfoById($empContentId);

        # Get payment Information
        $empPaymentMethodInfo = $this->Payroll_model->getEmpPaymentMethodInfoById($empContentId);

        $grossSalary = $empSalaryInfo->gross_salary;

        // end date info ----------------------------
        $endMonthInfo = explode('-', $endDate);
        $endYear = $endMonthInfo[2];
        $endMonth = $endMonthInfo[1];
        //        echo $endYear; exit;
        if (($endMonth == $monthId) && ($endYear == $year) && (strtotime($startDate) > strtotime($monthStartDate))) {
            $date1 = new DateTime($endDate);
            $date2 = new DateTime($monthStartDate);
            $dutyDays = $date2->diff($date1)->format('%a');
            $perDaySalary = $grossSalary / 30;
            $dutyDays = $dutyDays + 1;
            $grossSalary = $perDaySalary * $dutyDays;
            //echo $grossSalary;
            $monthEndDate = $endDate;
            $remarks = "Left after $dutyDays days.";
        }
        //            echo $monthEndDate; exit;
        $startMonthInfo = explode('-', $startDate);
        $startMonth = $startMonthInfo[1];
        $startYear = $startMonthInfo[0];
        // echo $startYear; exit;

        // If Start and end date in  same month & this month salary -------------------
        if ($endMonth && $endYear && ($startMonth == $endMonth) && ($startYear == $endYear)) {
            $date1 = new DateTime($startDate);
            $date2 = new DateTime($endDate);
            $dutyDays = $date2->diff($date1)->format('%a');
            $dutyDays = $dutyDays + 1;
            $remarks = "Duty $dutyDays days.";
            $monthStartDate = $startDate;
            $monthEndDate = $endDate;
            $perDaySalary =  $grossSalary / 30;
            $grossSalary = $dutyDays * $perDaySalary;
            //echo "Left:".$leftMonth;
        }

        # If Joining month salary -------------------------------------
        else if (($startMonth == $monthId) && ($startYear == $year) && (strtotime($endDate) < strtotime($monthEndDate))) {
            $deductDays = 0;
            $date1 = new DateTime($startDate);
            $date2 = new DateTime($monthStartDate);
            $deductDays = $date2->diff($date1)->format('%a');
            if ($deductDays > 0) {
                $remarks = "Join after $deductDays days.";
            }
            $monthStartDate = $startDate;
            $perDaySalary = $empSalaryInfo->gross_salary / 30;
            $deductDaysSalary = $deductDays * $perDaySalary;
            $grossSalary = $grossSalary - $deductDaysSalary;
        }


        ## Check payslip validation by employee joining date -------------
        if ((strtotime($empJoiningDate) <= strtotime($monthEndDate))) {

            # Employee Salary Info
            $basicSalary = $empSalaryInfo->basic;
            # allowances Info
            $houseRent = $empSalaryInfo->hra;
            $medicalAllow = $empSalaryInfo->ma;
            $transportAllow = $empSalaryInfo->ta;
            $dailyAllowence = $empSalaryInfo->da;
            $entertainmentAllowence = $empSalaryInfo->ea;
            $convayenceAllow = $empSalaryInfo->ca;
            $telephoneAllow = $empSalaryInfo->mba;
            $othersAllow = $empSalaryInfo->oa;

            //$festivalBonus = $postData['festival_bonus'];
            # Festival Bonus Info ----
            $festivalBonus = 0;
            $festivalBonusAmt = $this->db->query("SELECT amount FROM tbl_festival_bonus WHERE content_id=$empContentId AND adjust_year=$year AND adjust_month=$monthId AND payment_type='with_salary' ")->row('amount');
            if ($festivalBonusAmt) {
                $festivalBonus = $festivalBonusAmt;
            }
            ## Special Bonus Info -------------
            $specialBonus = 0;
            $specialBonusAmt = $this->db->query("SELECT amount FROM tbl_special_bonus WHERE content_id=$empContentId AND adjust_year=$year AND adjust_month=$monthId AND payment_type='with_salary' ")->row('amount');
            if ($specialBonusAmt) {
                $specialBonus = $specialBonusAmt;
            }
            ## Performance Bonus Info -------------
            $performanceBonus = 0;
            $performanceBonusAmt = $this->db->query("SELECT amount FROM tbl_performance_bonus WHERE content_id=$empContentId AND adjust_year=$year AND adjust_month=$monthId AND payment_type='with_salary' ")->row('amount');
            if ($performanceBonusAmt) {
                $performanceBonus = $performanceBonusAmt;
            }
            ## PF Allowance ---
            $pfAllowance = 0;
            $pfAllowanceAmt = $this->db->query("SELECT amount FROM tbl_pf_payments WHERE content_id=$empContentId AND adjust_year=$year AND adjust_month=$monthId AND payment_type='with_salary' ")->row('amount');
            if ($pfAllowanceAmt) {
                $pfAllowance = $pfAllowanceAmt;
            }
            # Gratuity
            $gratuity = 0;
            $gratuityAmt = $this->db->query("SELECT amount FROM tbl_gratuity WHERE content_id=$empContentId AND adjust_year=$year AND adjust_month=$monthId AND payment_type='with_salary' ")->row('amount');
            if ($gratuityAmt) {
                $gratuity = $gratuityAmt;
            }
            # Incentive
            $incentive = 0;
            $incentiveAmt = $this->db->query("SELECT amount FROM tbl_incentive WHERE content_id=$empContentId AND adjust_year=$year AND adjust_month=$monthId AND payment_type='with_salary' ")->row('amount');
            if ($incentiveAmt) {
                $incentive = $incentiveAmt;
            }

            ## deduction info
            $pf = $empSalaryInfo->pf;
            if (!$pf) {
                $pf = 0;
            }
            $tax = $empSalaryInfo->td;
            if (!$tax) {
                $tax = 0;
            }
            $otherDeduction = $empSalaryInfo->od;
            if (!$otherDeduction) {
                $otherDeduction = 0;
            }

            ## Advance Salary Info
            $advanceSalaryDeduction = 0;
            $advanceSalaryDeductionAmt = $this->db->query("SELECT amount FROM tbl_advance_salary WHERE content_id=$empContentId AND adjust_year=$year AND adjust_month=$monthId AND payment_type='with_salary' ")->row('amount');
            if ($advanceSalaryDeductionAmt) {
                $advanceSalaryDeduction = $advanceSalaryDeductionAmt;
            }

            ## Loan Info ----------------
            $loanInfo = $this->Payroll_model->getLoanInfoByContentId($empContentId, $monthId, $year);
            $loanDisbursementId = $loanInfo->id;
            $pricipalAmount = $loanInfo->principal_amount;
            if (!$pricipalAmount) {
                $pricipalAmount = 0;
            }
            $interestAmount = $loanInfo->interest_amount;
            if (!$interestAmount) {
                $interestAmount = 0;
            }
            $penaltyAmount = 0;
            // Installment date over -----
            //            if($istallmentDate<$postData['generated_date']){
            //               $penaltyAmount = $loanInfo->penalty_amount; 
            //            }
            $totalLoanPaymentAmount = ($pricipalAmount + $interestAmount + $penaltyAmount);


            # Abscent, late & early counter
            $lateDay = 0;
            $earlyDay = 0;
            $lateEarlyDay = 0;
            $absentDay = 0;
            $lateDeduction = 0;
            $earlyDeduction = 0;
            $lateEarlyDeduction = 0;
            $absentDeduction = 0;

            $totalAllowance = $houseRent +
                $medicalAllow +
                $transportAllow +
                $dailyAllowence +
                $entertainmentAllowence +
                $convayenceAllow +
                $telephoneAllow +
                $othersAllow;
            $othersEarnings = $specialBonus + $performanceBonus + $festivalBonus + $pfAllowance + $gratuity + $incentive;
            $total = ($basicSalary + $totalAllowance + $othersEarnings);
            $totalDeduction = ($pf + $tax + $otherDeduction + $lateDeduction + $earlyDeduction + $lateEarlyDeduction + $absentDeduction + $advanceSalaryDeduction + $totalLoanPaymentAmount);
            $netPayment = ($total - $totalDeduction);

            //            echo $total;
            //            exit;
            $paramsData = array(
                // 'account_id' => $postData['account_id'],
                'year' => $postData['year'],
                'month_id' => $postData['salary_month'],
                'pay_from' => date('Y-m-d', strtotime($monthStartDate)),
                'pay_to' => date('Y-m-d', strtotime($monthEndDate)),
                'content_id' => $empContentId,
                'reimbursment_date' => date('Y-m-d', strtotime($postData['generated_date'])),
                'payment_date' => '',
                'company_id' => $empCompanyId,
                'division_id' => $empDivisionId,
                'department_id' => $empDepartmentId,
                'grade_id' => $empGradeId,
                'emp_post_id' => $empPostId,
                'emp_type_id' => $emptypeId,
                'basic' => $basicSalary,
                'hra' => $houseRent,
                'ma' => $medicalAllow,
                'ta' => $transportAllow,
                'da' => $dailyAllowence,
                'ca' => $convayenceAllow,
                'ea' => $entertainmentAllowence,
                'oa' => $othersAllow,
                'mba' => $telephoneAllow,
                'pfa' => $pfAllowance,
                'pb' => $performanceBonus,
                'bonus' => $specialBonus,
                'festival_bonus' => $festivalBonus,
                'incentive' => $incentive,
                'gratuity' => $gratuity,
                'ot_hour' => '',
                'ot_taka' => '',
                'present_salary' => $empSalaryInfo->gross_salary,
                'gross_salary' => $grossSalary,
                'total' => $total,
                'pf' => $pf,
                'tax' => $tax,
                'other_deduct' => $otherDeduction,
                'advance_salary' => $advanceSalaryDeduction,
                'loan' => $totalLoanPaymentAmount,
                'loan_disbursement_id' => $loanDisbursementId,
                'late_day' => $lateDay,
                'late_deduct' => $lateDeduction,
                'early_day' => $earlyDay,
                'early_deduct' => $earlyDeduction,
                'late_early_day' => $lateEarlyDay,
                'late_early_taka' => $lateEarlyDeduction,
                'absent_day' => $absentDay,
                'absent_day_taka' => $absentDeduction,
                'total_deduction' => $totalDeduction,
                'net_salary' => $netPayment,
                'payment_method_id' => $empPaymentMethodInfo->emp_pay_type,
                'remarks' => $remarks
            );
            $checkExist = $this->Payroll_model->getPaySlipExist($empContentId, $empCompanyId, $empDivisionId, $monthId, $year);
            if ($checkExist) {
                return 'exist';
                //$this->session->set_flashdata('error', "Pay slip already Exist! <a href='pay-slip-confirmation' style='text-decoration:underline;font-style:italic'>Go to Pay Silp Confirmation</a>");
            } else {
                //echo "Not Exist";                
                $paramsData['created_at'] = $this->current_time();
                $paramsData['created_by'] = $this->session->userdata('user_id');
                $result = $this->Payroll_model->insertPayslipGeneratorData($paramsData);
                if ($result == true) {
                    return 'generated';
                    //$this->session->set_flashdata('success', "Pay slip generated successfully!  <a href='pay-slip-confirmation' style='text-decoration:underline;font-style:italic'>Go to Pay Silp Confirmation</a>");
                } else {
                    return 'error';
                    //$this->session->set_flashdata('error', "Pay slip not generated!");
                }
            }
        } // end  joining date validation
    }

    function employeePaySlipGenerator($postData, $emp_content_id)
    {
        $year = $postData['year'];
        $monthId = $postData['salary_month'];
        $monthStartDate = "$year-$monthId-01";
        $monthEndDate = date("Y-m-t", strtotime($monthStartDate));
        $empInfo = $this->Payroll_model->getEmpInfoByContentId($emp_content_id);
        // get salary by increment effective date ----
        $empSalaryInfo = $this->Payroll_model->getEmpSalaryInfoByContentId($emp_content_id, $monthStartDate);
        $empSalaryDeductInfo = $this->Payroll_model->getEmpSalaryDeductInfoById($emp_content_id);
        $empPaymentMethodInfo = $this->Payroll_model->getEmpPaymentMethodInfoById($emp_content_id);
        $grossSalary = $empSalaryInfo->gross_salary;
        $empJoiningDate = $empInfo->joining_date;
        if (($empInfo->type_of_employee == '153') || ($empInfo->type_of_employee == '473')) {
            //get left or terminated date__________________________________________
            $getLeftInfo = $this->Payroll_model->getLeftEmployeeInfo($emp_content_id);
            $second_date = strtotime('-1 day', strtotime($getLeftInfo->start_date));
            $empLeftDate = date('Y-m-d', $second_date);
            $leftMonthInfo = explode('-', $empLeftDate);
            $leftYear = $leftMonthInfo[0];
            $leftMonth = $leftMonthInfo[1];

            if (($leftMonth == $monthId) && ($leftYear == $year)) {
                $date1 = new DateTime($getLeftInfo->start_date);
                $date2 = new DateTime($monthStartDate);
                $dutyDays = $date2->diff($date1)->format('%a');
                $perDaySalary = $grossSalary / 30;
                $grossSalary = $perDaySalary * $dutyDays;
                //echo $grossSalary;
                $monthEndDate = $empLeftDate;
                $remarks = "Left after $dutyDays days.";
            }
            // exit;
            // Check payslip validation by employee left date --------------------- 
            if (strtotime($empLeftDate) <= strtotime(date('Y-m-d', strtotime($monthStartDate)))) {
                //                         echo "Left";
                $remarks = 'left';
                // break; //stop payslip generate only for this employee.
            }
        }
        if ($remarks != 'left') {
            $joingingMonthInfo = explode('-', $empJoiningDate);
            $joiningMonth = $joingingMonthInfo[1];
            $joiningYear = $joingingMonthInfo[2];
            // If Joining and left same month & this month salary -------------------
            if ($leftMonth && $leftYear && ($joiningMonth == $leftMonth) && ($joiningYear == $leftYear)) {
                $date1 = new DateTime($empJoiningDate);
                $date2 = new DateTime($getLeftInfo->start_date);
                $dutyDays = $date2->diff($date1)->format('%a');
                $remarks = "Duty $dutyDays days.";
                $monthStartDate = $empJoiningDate;
                $monthEndDate = $empLeftDate;
                $perDaySalary = $empSalaryInfo->gross_salary / 30;
                $grossSalary = $dutyDays * $perDaySalary;
                //echo "Left:".$leftMonth;
            }
            // If Joining month salary -------------------------------------
            else if (($joiningMonth == $monthId) && ($joiningYear == $year)) {
                $date1 = new DateTime($empJoiningDate);
                $date2 = new DateTime($monthStartDate);
                $deductDays = $date2->diff($date1)->format('%a');
                $remarks = "Join after $deductDays days.";
                $monthStartDate = $empJoiningDate;
                $perDaySalary = $empSalaryInfo->gross_salary / 30;
                $deductDaysSalary = $deductDays * $perDaySalary;
                $grossSalary = $grossSalary - $deductDaysSalary;
            }
            //  exit;
            // Check payslip validation by employee joining date -------------
            if ((strtotime($empJoiningDate) <= strtotime($monthEndDate))) {


                $basicSalary = $grossSalary / 2;
                //          ========= Allowances Info =====================================
                $houseRent = ($basicSalary * 60) / 100;
                $medicalAllow = ($basicSalary * 20) / 100;
                $transportAllow = ($basicSalary * 10) / 100;
                $othersAllow = ($basicSalary * 10) / 100;
                $empSpecialBonus = 0;
                $festivalBonus = $postData['festival_bonus'];

                if ($festivalBonus == 'true') {
                    $festivalBonus = $basicSalary;
                } else {
                    $festivalBonus = 0;
                }

                $telephoneAllow = $empSalaryInfo->telephone_allow;
                //          Special Bonus Info -------------
                $specialBonus = 0;
                //  ========== Deduction Info =======================================
                $pf = $empSalaryDeductInfo->provident_fund_deduction;
                if (!$pf) {
                    $pf = 0;
                }
                $tax = $empSalaryDeductInfo->tax_deduction;
                if (!$tax) {
                    $tax = 0;
                }
                $other_deduction = $empSalaryDeductInfo->other_deduction;
                if (!$other_deduction) {
                    $other_deduction = 0;
                }
                //          Loan Info ----------------
                $loanInfo = $this->Payroll_model->getLoanInfoByContentId($emp_content_id, $monthId, $year);
                $loanDisbursementId = $loanInfo->id;
                $pricipalAmount = $loanInfo->principal_amount;
                if (!$pricipalAmount) {
                    $pricipalAmount = 0;
                }
                $interestAmount = $loanInfo->interest_amount;
                if (!$interestAmount) {
                    $interestAmount = 0;
                }
                $penaltyAmount = 0;
                // Installment date over -----
                //            if($istallmentDate<$postData['generated_date']){
                //               $penaltyAmount = $loanInfo->penalty_amount; 
                //            }
                $totalLoanPaymentAmount = ($pricipalAmount + $interestAmount + $penaltyAmount);
                $lateEarlyDay = 0;
                $absentDay = 0;
                $lateEarlyDeduction = 0;
                $absentDeduction = 0;

                $total = ($grossSalary + $telephoneAllow + $specialBonus + $festivalBonus);
                $totalDeduction = ($pf + $tax + $other_deduction + $lateEarlyDeduction + $absentDeduction + $totalLoanPaymentAmount);
                $netPayment = ($total - $totalDeduction);

                //            echo $total;
                //            exit;

                $paramsData = array(
                    // 'account_id' => $postData['account_id'],
                    'year' => $postData['year'],
                    'month_id' => $postData['salary_month'],
                    'pay_from' => date('Y-m-d', strtotime($monthStartDate)),
                    'pay_to' => date('Y-m-d', strtotime($monthEndDate)),
                    'content_id' => $emp_content_id,
                    'reimbursment_date' => date('Y-m-d', strtotime($postData['generated_date'])),
                    'payment_date' => '',
                    'division_id' => $empInfo->emp_division,
                    'department_id' => $empInfo->emp_department,
                    'grade_id' => $empInfo->grade,
                    'emp_post_id' => $empInfo->emp_post_id,
                    'basic' => $basicSalary,
                    'hra' => $houseRent,
                    'ma' => $medicalAllow,
                    'ta' => $transportAllow,
                    'oa' => $othersAllow,
                    'telephone_allow' => $telephoneAllow,
                    'bonus' => $empSpecialBonus,
                    'festival_bonus' => $festivalBonus,
                    'ot_hour' => '',
                    'ot_taka' => '',
                    'gross_salary' => $grossSalary,
                    'total' => $total,
                    'pf' => $pf,
                    'tax' => $tax,
                    'other_deduct' => $other_deduction,
                    'loan' => $totalLoanPaymentAmount,
                    'loan_disbursement_id' => $loanDisbursementId,
                    'late_early_day' => $lateEarlyDay,
                    'late_early_taka' => $lateEarlyDeduction,
                    'absent_day' => $absentDay,
                    'absent_day_taka' => $absentDeduction,
                    'total_deduction' => $totalDeduction,
                    'net_salary' => $netPayment,
                    'payment_method_id' => $empPaymentMethodInfo->emp_pay_type,
                    'remarks' => $remarks
                );

                $checkExist = $this->Payroll_model->getPaySlipExist($emp_content_id, $monthId, $year);
                if ($checkExist) {
                    $this->session->set_flashdata('error', "Pay slip already Exist! <a href='pay-slip-confirmation' style='text-decoration:underline;font-style:italic'>Go to Pay Silp Confirmation</a>");
                    //redirect('manual-pay-slip-generation');
                    //echo "Exist"; 
                    /*
                      $paramsData['updated_at'] = $this->current_time();
                      $paramsData['updated_by'] = $this->session->userdata('user_id');
                      $updateCondition = array('id' => $checkExist->id);
                      $result = $this->Payroll_model->updatePayslipGeneratorData($paramsData, $updateCondition);
                      if ($result == true) {
                      $this->session->set_flashdata('success', "Pay slip updated successfully! ");
                      } else {
                      $this->session->set_flashdata('error', "Pay slip not updated!");
                      }

                     */
                } else {
                    //echo "Not Exist";                
                    $paramsData['created_at'] = $this->current_time();
                    $paramsData['created_by'] = $this->session->userdata('user_id');
                    $result = $this->Payroll_model->insertPayslipGeneratorData($paramsData);
                    if ($result == true) {
                        /*
                          if($totalLoanPaymentAmount>0){
                          $this->Payroll_model->updateLoanInfo($loanInfo->loan_id,$totalLoanPaymentAmount);
                          $this->Payroll_model->updateLoanDisbursementInfo($loanDisbursementId);
                          }
                         */
                        $this->session->set_flashdata('success', "Pay slip generated successfully!  <a href='pay-slip-confirmation' style='text-decoration:underline;font-style:italic'>Go to Pay Silp Confirmation</a>");
                    } else {
                        $this->session->set_flashdata('error', "Pay slip not generated!");
                    }
                }
            } //end joining date checking
        } // end left/terminated checking
        $leftMonth = null;
        $leftYear = null;
    }

    public function divisionPaySlipGenerator()
    {

        if ($this->input->post('add_btn')) {


            //  $this->progress_bar();

            $postData = $this->input->post();
            $emp_division = $postData['emp_division'];
            $emp_department = $postData['emp_department'];
            $data = array();
            if (!$emp_department) {
                $data['default_employee'] = $this->search_field_emp_model->getallemployeebydivision($emp_division);
            } else {
                $data['default_employee'] = $this->search_field_emp_model->getAllEmployeeByDivisionAndDepartment($emp_division, $emp_department);
            }
            //            print_r($data);
            //            exit;
            foreach ($data['default_employee'] as $single_emp) {
                $emp_content_id = $single_emp['content_id'];
                $year = $postData['year'];
                $monthId = $postData['salary_month'];
                $empInfo = $this->Payroll_model->getEmpInfoByContentId($emp_content_id);
                $emp_joining_date = $empInfo->joining_date;
                $emp_division_id = $empInfo->emp_division;

                $monthStartDate = "$year-$monthId-01";
                $monthEndDate = date("Y-m-t", strtotime($monthStartDate));
                $dateRange = dateRange($monthStartDate, $monthEndDate);
                $servertime = time();
                $late_counter = 0;
                $early_counter = 0;
                $absent_counter = 0;
                $absent_halfday_counter = 0;
                $leave_with_pay = 0;
                $daily_movement = 0;
                $leave_without_pay = 0;
                $half_day_absent_status = "";
                $early_status = "";
                $late_status = "";
                $today = date("d-m-Y", $servertime);
                foreach ($dateRange as $single_date) {
                    if (strtotime($single_date) >= strtotime($emp_joining_date)) {
                        $empatt_start_date_arr = explode("-", $single_date);
                        $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
                        $emp_shift_time = $this->db->query("select * from emp_shift_history WHERE content_id ='$emp_content_id' AND str_to_date(start_date, '%d-%m-%Y') <='$emp_att_start_date' ORDER BY ID DESC LIMIT 1")->row_array();
                        //                $emp_shift_time = $this->emp_working_time_model->getworkingtimeBydateandid($emp_content_id, $single_date);
                        $attendance_required = $emp_shift_time['attendance_required'];
                        $work_starting_time = $emp_shift_time['work_starting_time'];
                        $work_ending_time = $emp_shift_time['work_ending_time'];
                        $logout_required = $emp_shift_time['logout_required'];
                        $year = date('Y', strtotime($single_date));

                        $empatt_start_date_arr = explode("-", $single_date);
                        $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];

                        $emp_latecount_time = $emp_shift_time['emp_latecount_time'];
                        $emp_earlycount_time = $emp_shift_time['emp_earlycount_time'];
                        //                }             
                        $half_day_absent = $emp_shift_time['half_day_absent'];
                        $absent_count_time = $emp_shift_time['absent_count_time'];
                        $overtime_count = $emp_shift_time['overtime_count'];

                        $tstamp1 = strtotime($default_date);
                        $dated_day_name1 = date("D", $tstamp1);
                        $dated_day_name1 = strtolower($dated_day_name1);
                        if ($emp_division_id == 301 && $dated_day_name1 == 'thu') {
                            $work_ending_time = "16:00:00";
                            $emp_earlycount_time = "16:00:00";
                        }
                        // Check Attendance log mantainance ----------------------------------------------------------------------------
                        $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,"
                            . "half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status "
                            . "FROM log_maintenence WHERE content_id=$emp_content_id and start_date='$single_date' "
                            . "order by id DESC LIMIT 1")->row_array();

                        if (!$has_log_attendance_error) {

                            $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status FROM log_maintenence 
                                    WHERE division_id='$emp_division_id' and start_date='$single_date' order by id DESC LIMIT 1")->row_array();
                        }
                        $division = "all";
                        if (!$has_log_attendance_error) {
                            $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status FROM log_maintenence 
                                    WHERE division_id='$division' and start_date='$single_date' order by id DESC LIMIT 1")->row_array();
                        }


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
                            // If before December 01, 2018 ----------------------------------------------------
                            $attendance_info = $this->db->query("SELECT login_time,logout_time,remarks "
                                . "FROM emp_attendance_old "
                                . "WHERE content_id=$emp_content_id AND attendance_date='$single_date' "
                                . "ORDER BY id DESC")->row_array();
                        } else {
                            // If after November 30, 2018 ------------------------------------------------------
                            $attendance_info = $this->db->query("SELECT login_time,logout_time,remarks "
                                . "FROM emp_attendance "
                                . "WHERE content_id=$emp_content_id AND attendance_date='$single_date' "
                                . "ORDER BY id DESC")->row_array();
                        }
                        $login_time = $attendance_info['login_time'];
                        $logout_time = $attendance_info['logout_time'];
                        // Attendance Information check( Daily movement) -------------------------------------------------------------
                        $emp_informed_info = $this->db->query("SELECT presence_status,logout_status,reason,remarks FROM emp_informed WHERE content_id=$emp_content_id AND attendance_date='$single_date' ORDER BY id DESC")->row_array();

                        // Holiday Check ---------------------------------------------------------------------------------------------
                        $holiday_exist = $this->db->query("SELECT eyh.holiday_type,t.name as holiday_name "
                            . "FROM emp_yearlyholiday eyh "
                            . "LEFT JOIN taxonomy t ON t.tid=eyh.holiday_type "
                            . "WHERE eyh.holiday_for_division='$division' AND eyh.holiday_start_date='$single_date' "
                            . "ORDER BY eyh.id DESC LIMIT 1")->row_array();
                        if (!$holiday_exist) {
                            $division = $emp_division_id;
                            $holiday_exist = $this->db->query("SELECT eyh.holiday_type,t.name as holiday_name "
                                . "FROM emp_yearlyholiday eyh "
                                . "LEFT JOIN taxonomy t ON t.tid=eyh.holiday_type "
                                . "WHERE eyh.holiday_for_division='$division' AND eyh.holiday_start_date='$single_date' "
                                . "ORDER BY eyh.id DESC")->row_array();
                        }
                        if ($holiday_exist) {
                            // If holiday -------------------------------------
                            $holiday_type_tid = $holiday_exist['holiday_type'];
                            $holiday_name = $holiday_exist['holiday_name']; // this will be echoed
                            $remarks = $holiday_exist['holiday_name'];
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

                            if (($remarks != "Weekly Holiday") || ($log_weekly_holiday == 'working_day')) {
                                //                                   $leave_exist = $this->emp_leave_model->getemp_leave($emp_content_id, $single_date);
                                //                                   $leave_exist = $this->db->query("SELECT leave_type,justification FROM emp_leave WHERE content_id='$emp_content_id' AND leave_start_date='$single_date' ORDER BY id DESC")->row_array();
                                $leave_exist = $this->db->query("SELECT el.leave_type,el.justification,t.name as leave_name "
                                    . "FROM emp_leave el "
                                    . "LEFT JOIN taxonomy t ON t.tid=el.leave_type "
                                    . "WHERE el.content_id='$emp_content_id' "
                                    . "AND el.leave_start_date='$single_date' ORDER BY el.id DESC")->row_array();

                                if ($leave_exist) {

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
                                            } else if (strtotime($emp_earlycount_time) > strtotime($logout_time)) {
                                                $half_absent_found = "Half Day Absent";
                                            } else {
                                                $half_absent_found = "Half Day Absent";
                                            }
                                        } else if ($late_status == "Late_Not_Count") {
                                            $remarks = $reason;
                                        } else if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                            $login_time = "<font color=red >" . $login_time . "</font>";
                                        } else {
                                        }
                                    } else {
                                        //echo $emp_latecount_time;
                                        if ($presence_status_informed) {
                                            $presence_status = $presence_status_informed;
                                            $remarks = $informed_remarks;
                                            if ($presence_status == 'A') {
                                                $login_time = "";
                                                $logout_time = "";
                                            }
                                        } else if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                            $emp_late_found = "Late";
                                        } else {
                                        }
                                    }
                                }
                            }
                        }

                        // if not login but logout after 04:00 PM ....................................................
                        if (!$logout_time && $login_time && $login_time >= "16:00:00") {
                            $logout_time = $login_time;
                            $login_time = "";
                        }

                        // Counter Start ------------------------------------------------------------------------------------------------------------
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
                            if ($reason_informed == 'personal') {
                                $daily_movement_personal++;
                            }
                            if ($presence_status == 'A') {
                                $absent_counter++;
                            } else if ($presence_status == 'P' && $logout_status_informed == 'P') {
                            } else if ($presence_status == 'P' && $logout_status_informed == 'E') {
                                $early_counter++;
                            } else if ($presence_status == 'L' && $logout_status_informed == 'E') {
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
                                    $late_counter++;
                                } else {
                                    $late_counter++;
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
                        // If today stop loop -----------
                        if (strtotime($single_date) >= strtotime($today)) {
                            break;
                        }
                    }
                }

                $empSalaryInfo = $this->Payroll_model->getEmpSalaryInfoByContentId($emp_content_id, $monthStartDate);
                $empSalaryDeductInfo = $this->Payroll_model->getEmpSalaryDeductInfoById($emp_content_id);
                $empPaymentMethodInfo = $this->Payroll_model->getEmpPaymentMethodInfoById($emp_content_id);
                //            echo $empSalaryInfo->gross_salary;
                //            echo "<pre>";
                //            print_r($empSalaryInfo);
                //            exit;
                $grossSalary = $empSalaryInfo->gross_salary;
                $basicSalary = $grossSalary / 2;
                //          ========= Allowances Info =====================================
                $houseRent = ($basicSalary * 60) / 100;
                $medicalAllow = ($basicSalary * 20) / 100;
                $transportAllow = ($basicSalary * 10) / 100;
                $othersAllow = ($basicSalary * 10) / 100;
                $empSpecialBonus = 0;
                $festivalBonus = $postData['festival_bonus'];

                if ($festivalBonus == 'true') {
                    $festivalBonus = $basicSalary;
                } else {
                    $festivalBonus = 0;
                }

                $telephoneAllow = $empSalaryInfo->telephone_allow;
                //          Special Bonus Info -------------
                $specialBonus = 0;
                //  ========== Deduction Info =======================================
                $pf = $empSalaryDeductInfo->provident_fund_deduction;
                $tax = $empSalaryDeductInfo->tax_deduction;
                $other_deduction = $empSalaryDeductInfo->other_deduction;
                //          Loan Info ----------------
                $loanInfo = $this->Payroll_model->getLoanInfoByContentId($emp_content_id);
                $loanDisbursementId = $loanInfo->id;
                $pricipalAmount = $loanInfo->principal_amount;
                if (!$pricipalAmount) {
                    $pricipalAmount = 0;
                }
                $interestAmount = $loanInfo->interest_amount;
                if (!$interestAmount) {
                    $interestAmount = 0;
                }
                $penaltyAmount = 0;
                // Installment date over -----
                //            if($istallmentDate<$postData['generated_date']){
                //               $penaltyAmount = $loanInfo->penalty_amount; 
                //            }
                $totalLoanPaymentAmount = ($pricipalAmount + $interestAmount + $penaltyAmount);
                $lateEarlyDay = $late_counter + $early_counter;
                $absentDay = $absent_counter;
                //                $lateEarlyDay = 0;
                //                $absentDay = 0;
                $lateEarlyDeduction = 0;
                $absentDeduction = ($grossSalary / 30) * $absentDay;
                if (!$absentDeduction) {
                    $absentDeduction = 0;
                }

                $total = ($grossSalary + $telephoneAllow + $specialBonus + $festivalBonus);
                $totalDeduction = ($pf + $tax + $lateEarlyDeduction + $absentDeduction + $totalLoanPaymentAmount);
                $netPayment = ($total - $totalDeduction);

                //            echo $total;
                //            exit;

                $paramsData = array(
                    'account_id' => $postData['account_id'],
                    'year' => $postData['year'],
                    'month_id' => $postData['salary_month'],
                    'pay_from' => date('Y-m-d', strtotime($monthStartDate)),
                    'pay_to' => date('Y-m-d', strtotime($monthEndDate)),
                    'content_id' => $emp_content_id,
                    'reimbursment_date' => date('Y-m-d', strtotime($postData['generated_date'])),
                    'payment_date' => '',
                    'division_id' => $empInfo->emp_division,
                    'department_id' => $empInfo->emp_department,
                    'grade_id' => $empInfo->grade,
                    'emp_post_id' => $empInfo->emp_post_id,
                    'basic' => $basicSalary,
                    'hra' => $houseRent,
                    'ma' => $medicalAllow,
                    'ta' => $transportAllow,
                    'oa' => $othersAllow,
                    'telephone_allow' => $telephoneAllow,
                    'bonus' => $empSpecialBonus,
                    'festival_bonus' => $festivalBonus,
                    'ot_hour' => '',
                    'ot_taka' => '',
                    'gross_salary' => $grossSalary,
                    'total' => $total,
                    'pf' => $pf,
                    'tax' => $tax,
                    'other_deduct' => $other_deduction,
                    'loan' => $totalLoanPaymentAmount,
                    'loan_disbursement_id' => $loanDisbursementId,
                    'late_early_day' => $lateEarlyDay,
                    'late_early_taka' => $lateEarlyDeduction,
                    'absent_day' => $absentDay,
                    'absent_day_taka' => $absentDeduction,
                    'total_deduction' => $totalDeduction,
                    'net_salary' => $netPayment,
                    'payment_method_id' => $empPaymentMethodInfo->emp_pay_type
                );
                //            echo "<pre>";
                //            print_r($paramsData);
                //            exit;
                $checkExist = $this->Payroll_model->getPaySlipExist($emp_content_id, $monthId, $year);
                if ($checkExist) {
                    //echo "Exist"; 
                    $this->session->set_flashdata('success', "Pay slip already Exist! ");
                    // redirect('division-pay-slip-generation');
                    /*
                      $paramsData['updated_at'] = $this->current_time();
                      $paramsData['updated_by'] = $this->session->userdata('user_id');
                      $updateCondition = array('id' => $checkExist->id);
                      $result = $this->Payroll_model->updatePayslipGeneratorData($paramsData, $updateCondition);
                      if ($result == true) {
                      $this->session->set_flashdata('success', "Pay slip updated successfully! ");
                      } else {
                      $this->session->set_flashdata('error', "Pay slip not updated!");
                      }
                     */
                } else {
                    //echo "Not Exist";                
                    $paramsData['created_at'] = $this->current_time();
                    $paramsData['created_by'] = $this->session->userdata('user_id');
                    $result = $this->Payroll_model->insertPayslipGeneratorData($paramsData);
                    if ($result == true) {
                        /*
                          if($totalLoanPaymentAmount>0){
                          $this->Payroll_model->updateLoanInfo($loanInfo->loan_id,$totalLoanPaymentAmount);
                          $this->Payroll_model->updateLoanDisbursementInfo($loanDisbursementId);
                          }
                         */
                        $this->session->set_flashdata('success', "Pay slip generated successfully! ");
                    } else {
                        $this->session->set_flashdata('error', "Pay slip not generated!");
                    }
                }
                $late_counter = 0;
                $early_counter = 0;
                $absent_counter = 0;
                $absent_halfday_counter = 0;
                $leave_with_pay = 0;
                $daily_movement = 0;
                $leave_without_pay = 0;
                $half_day_absent_status = "";
                $early_status = "";
                $late_status = "";
            }

            redirect('division-pay-slip-generation');
        }

        $data['alldivision'] = $this->taxonomy->getTaxonomyByvid(1);
        $this->load->view('payroll/division-payslip-generator', $data);
    }

    public function confirmPayslip()
    {
        $searchpage = "payslip_confirmation";
        $data['user_id'] = $this->user_id;
        $data['user_name'] = $this->user_name;
        $data['user_type'] = $this->user_type;
        $data['user_division'] = $this->user_division;
        $data['user_department'] = $this->user_department;
        $data['all_company_access'] = $this->all_company_access;

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
            $query = " payroll.year=$year AND payroll.month_id=$monthId AND payroll.status=0 ";
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
                'user_id' => $this->user_id,
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

            $edit_id = $this->uri->segment(2);
            $updateData = array(
                'status' => 1,
                'updated_at' => $this->current_time(),
                'updated_by' => $this->user_id
            );
            $updateCondition = array('id' => $edit_id);
            $result = $this->Payroll_model->updatePayslipGeneratorData($updateData, $updateCondition);
            if ($result == true) {


                $this->session->set_flashdata('success', "Pay slip confirmed successfully.  <a href='pay-slip-payment' style='text-decoration:underline;font-style:italic'>Go to Pay Silp Payment</a>");
            } else {
                $this->session->set_flashdata('error', "Pay slip not confirmed!");
            }

            redirect('pay-slip-confirmation');
        }
        if ($this->all_company_access['status'] == 1 || $this->usrtype == 1) {
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid(1);
        } else {
            if ($this->user_department) {
                $data['department_selected'] = $this->taxonomy->getTaxonomyBytid($this->user_department);
            } else {
                $data['department_selected'] = $this->taxonomy->getTaxonomychildbyparent($this->user_division);
            }
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($this->user_division);
        }

        $this->output->set_header("HTTP/1.0 200 OK");
        $this->output->set_header("HTTP/1.1 200 OK");
        $this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        $this->noCache(); // for clear cache 
        $default_info = $this->search_field_emp_model->getsearchQuery($searchpage);
        $data['company'] = $default_info['table_view'];
        $data['division'] = $default_info['per_page'];
        $data['year'] = $default_info['year'];
        $data['month_name'] = $default_info['month'];
        $search_query = $default_info['search_query'];
        $data['paySlips'] = $this->Payroll_model->getPaySlip($searchpage, $search_query);
        $data['months'] = $this->Payroll_model->getMonths();
        $data['years'] = $this->db->query("SELECT * FROM tbl_years WHERE status=1")->result();

        $this->load->view('payroll/payslip-confirmation', $data, 'refresh');
    }

    public function confirmMultiplePayslip()
    {
        $userId = $this->session->userdata('user_id');
        $payslipIds = $this->input->get_post('payslip_id');
        $ids = (explode(',', $payslipIds));
        //         print_r($ids);
        //         exit();
        $updateData = array(
            'status' => 1,
            'updated_at' => $this->current_time(),
            'updated_by' => $userId
        );
        $this->Payroll_model->updateMultiplePayslip($updateData, $ids);
        //redirect('pay-slip-confirmation','refresh');
    }

    public function checkPayslip()
    {
        $searchpage = "payslip_check";
        $data['user_id'] = $this->user_id;
        $data['user_name'] = $this->user_name;
        $data['user_type'] = $this->user_type;
        $data['user_division'] = $this->user_division;
        $data['user_department'] = $this->user_department;
        $data['all_company_access'] = $this->all_company_access;

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
                'user_id' => $this->user_id,
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
        if ($this->uri->segment(4)) {
            $searchpage = "payslip_check";
            $user_id = $this->session->userdata('user_id');
            $company_id = $this->uri->segment(2);
            $monthId = $this->uri->segment(3);
            $year = $this->uri->segment(4);
            $monthName = $this->uri->segment(5);
            $data['year'] = $year;
            $data['month_name'] = $monthName;
            $query = " payroll.year=$year AND payroll.month_id=$monthId AND payroll.status !=0 AND payroll.check_status=0 ";
            if ($company_id == 'all') {
                $data['company'] = 'All';
            } else {
                $data['company'] = $this->Payroll_model->getTaxonomyNameByTid($company_id);
                $query .= " AND payroll.company_id=$company_id";
            }
            $data['division'] = 'All';

            // search history section ---------



            $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
            date_default_timezone_set('Asia/Dhaka');
            $servertime = time();
            $now = date("d-m-Y", $servertime);
            $params_contents = array(
                'id' => '',
                'search_query' => $query,
                'user_id' => $this->user_id,
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

            $edit_id = $this->uri->segment(2);
            $action = $this->uri->segment(3);
            $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
            $currentDate = $dt->format('Y-m-d');
            if ($action == 'checked') {
                $updateData = array(
                    'check_status' => 1,
                    'checked_at' => $currentDate,
                    'updated_at' => $this->current_time(),
                    'updated_by' => $this->user_id
                );
                $updateCondition = array('id' => $edit_id);
                $result = $this->Payroll_model->updatePayslipGeneratorData($updateData, $updateCondition);
                if ($result == true) {
                    $this->session->set_flashdata('success', "Pay slip checked successfully.");
                } else {
                    $this->session->set_flashdata('error', "Pay slip not checked!");
                }
            } else if ($action == 'cancel_checked') {
                $updateData = array(
                    'check_status' => 0,
                    'checked_at' => null,
                    'updated_at' => $this->current_time(),
                    'updated_by' => $this->user_id
                );
                $updateCondition = array('id' => $edit_id);
                $result = $this->Payroll_model->updatePayslipGeneratorData($updateData, $updateCondition);
                if ($result == true) {
                    $this->session->set_flashdata('success', "Pay slip checked cancel successfully.");
                } else {
                    $this->session->set_flashdata('error', "Pay slip checked not canceled!");
                }
            }


            redirect('pay-slip-check');
        }

        if ($this->user_type == 1 || $this->all_company_access['status'] == 1) {
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid(1);
        } else {
            if ($this->user_department) {
                $data['department_selected'] = $this->taxonomy->getTaxonomyBytid($this->user_department);
            } else {
                $data['department_selected'] = $this->taxonomy->getTaxonomychildbyparent($this->user_division);
            }
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($this->user_division);
        }

        $this->output->set_header("HTTP/1.0 200 OK");
        $this->output->set_header("HTTP/1.1 200 OK");
        $this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        $this->noCache(); // for clear cache 
        $default_info = $this->search_field_emp_model->getsearchQuery($searchpage);
        $data['company'] = $default_info['table_view'];
        $data['division'] = $default_info['per_page'];
        $data['year'] = $default_info['year'];
        $data['month_name'] = $default_info['month'];
        $search_query = $default_info['search_query'];
        $data['paySlips'] = $this->Payroll_model->getPaySlip($searchpage, $search_query);
        $data['months'] = $this->Payroll_model->getMonths();
        $data['years'] = $this->db->query("SELECT * FROM tbl_years WHERE status=1")->result();

        $this->load->view('payroll/payslip-check', $data, 'refresh');
    }

    public function checkedMultiplePayslip()
    {
        $userId = $this->session->userdata('user_id');
        $payslipIds = $this->input->get_post('payslip_id');
        $ids = (explode(',', $payslipIds));
        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
        $currentDate = $dt->format('Y-m-d');
        //         print_r($ids);
        //         exit();
        $updateData = array(
            'check_status' => 1,
            'checked_at' => $currentDate,
            'updated_at' => $this->current_time(),
            'updated_by' => $userId
        );
        $this->Payroll_model->updateMultiplePayslip($updateData, $ids);
        //redirect('pay-slip-confirmation','refresh');
    }

    public function cancelCheckedMultiplePayslip()
    {
        $userId = $this->session->userdata('user_id');
        $payslipIds = $this->input->get_post('payslip_id');
        $ids = (explode(',', $payslipIds));
        //         print_r($ids);
        //         exit();
        $updateData = array(
            'check_status' => 0,
            'checked_at' => null,
            'updated_at' => $this->current_time(),
            'updated_by' => $userId
        );
        $this->Payroll_model->updateMultiplePayslip($updateData, $ids);
        //redirect('pay-slip-confirmation','refresh');
    }

    public function approvePayslip()
    {
        $searchpage = "payslip_approve";
        $data['user_id'] = $this->user_id;
        $data['user_name'] = $this->user_name;
        $data['user_type'] = $this->user_type;
        $data['user_division'] = $this->user_division;
        $data['user_department'] = $this->user_department;
        $data['all_company_access'] = $this->all_company_access;

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
            $query = " payroll.year=$year AND payroll.month_id=$monthId AND payroll.check_status=1 ";
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
                'user_id' => $this->user_id,
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
        if ($this->uri->segment(4)) {
            $searchpage = "payslip_approve";
            $user_id = $this->user_id;
            $company_id = $this->uri->segment(2);
            $monthId = $this->uri->segment(3);
            $year = $this->uri->segment(4);
            $monthName = $this->uri->segment(5);
            $data['year'] = $year;
            $data['month_name'] = $monthName;
            $query = " payroll.year=$year AND payroll.month_id=$monthId AND payroll.check_status=1 AND payroll.approve_status=0 ";
            if ($company_id == 'all') {
                $data['company'] = 'All';
            } else {
                $data['company'] = $this->Payroll_model->getTaxonomyNameByTid($company_id);
                $query .= " AND payroll.company_id=$company_id";
            }
            $data['division'] = 'All';
            // search history section ---------
            $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
            date_default_timezone_set('Asia/Dhaka');
            $servertime = time();
            $now = date("d-m-Y", $servertime);
            //$searchpage="payslip_confirmation";
            $params_contents = array(
                'id' => '',
                'search_query' => $query,
                'user_id' => $this->user_id,
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

            $edit_id = $this->uri->segment(2);
            $action = $this->uri->segment(3);
            $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
            $currentDate = $dt->format('Y-m-d');
            if ($action == 'approved') {
                $updateData = array(
                    'approve_status' => 1,
                    'approved_at' => $currentDate,
                    'updated_at' => $this->current_time(),
                    'updated_by' => $this->user_id
                );
                $updateCondition = array('id' => $edit_id);
                $result = $this->Payroll_model->updatePayslipGeneratorData($updateData, $updateCondition);
                if ($result == true) {
                    $this->session->set_flashdata('success', "Pay slip approved successfully.");
                } else {
                    $this->session->set_flashdata('error', "Pay slip not approved!");
                }
            } else if ($action == 'cancel_approved') {
                $updateData = array(
                    'approve_status' => 0,
                    'approved_at' => null,
                    'updated_at' => $this->current_time(),
                    'updated_by' => $this->user_id
                );
                $updateCondition = array('id' => $edit_id);
                $result = $this->Payroll_model->updatePayslipGeneratorData($updateData, $updateCondition);
                if ($result == true) {
                    $this->session->set_flashdata('success', "Pay slip approval cancel successfully.");
                } else {
                    $this->session->set_flashdata('error', "Pay slip approval not cancled!");
                }
            }
            redirect('pay-slip-approval');
        }


        if ($this->user_type == 1 || $this->all_company_access['status'] == 1) {
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid(1);
        } else {
            if ($this->user_department) {
                $data['department_selected'] = $this->taxonomy->getTaxonomyBytid($this->user_department);
            } else {
                $data['department_selected'] = $this->taxonomy->getTaxonomychildbyparent($this->user_division);
            }
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($this->user_division);
        }

        $this->output->set_header("HTTP/1.0 200 OK");
        $this->output->set_header("HTTP/1.1 200 OK");
        $this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        $this->noCache(); // for clear cache 
        $default_info = $this->search_field_emp_model->getsearchQuery($searchpage);
        $data['company'] = $default_info['table_view'];
        $data['division'] = $default_info['per_page'];
        $data['year'] = $default_info['year'];
        $data['month_name'] = $default_info['month'];
        $search_query = $default_info['search_query'];
        $data['paySlips'] = $this->Payroll_model->getPaySlip($searchpage, $search_query);
        $data['months'] = $this->Payroll_model->getMonths();
        $data['years'] = $this->db->query("SELECT * FROM tbl_years WHERE status=1")->result();

        $this->load->view('payroll/payslip-approval', $data, 'refresh');
    }

    public function approvedMultiplePayslip()
    {
        $userId = $this->session->userdata('user_id');
        $payslipIds = $this->input->get_post('payslip_id');
        $ids = (explode(',', $payslipIds));
        //         print_r($ids);
        //         exit();
        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
        $currentDate = $dt->format('Y-m-d');
        $updateData = array(
            'approve_status' => 1,
            'approved_at' => $currentDate,
            'updated_at' => $this->current_time(),
            'updated_by' => $userId
        );
        $this->Payroll_model->updateMultiplePayslip($updateData, $ids);
    }

    public function cancelApprovedMultiplePayslip()
    {
        $userId = $this->session->userdata('user_id');
        $payslipIds = $this->input->get_post('payslip_id');
        $ids = (explode(',', $payslipIds));
        //         print_r($ids);
        //         exit();
        $updateData = array(
            'approve_status' => 0,
            'approved_at' => null,
            'updated_at' => $this->current_time(),
            'updated_by' => $userId
        );
        $this->Payroll_model->updateMultiplePayslip($updateData, $ids);
    }

    public function editPaySlip()
    {
        $postData = $this->input->post();

        $pageName = $postData['page_name'];
        $payslipId = $postData['payslip_id'];

        if ($payslipId) {
            $empName = $postData['emp_name'];
            $month = $postData['month'];
            $year = $postData['year_name'];

            $paramsData = array(
                'basic' => $postData['emp_basic_salary'],
                'hra' => $postData['emp_house_rent'],
                'ma' => $postData['emp_medical_allowance'],
                'ta' => $postData['emp_transport_allowance'],
                'ca' => $postData['emp_conveyance_allowance'],
                'da' => $postData['emp_daily_allowance'],
                'ea' => $postData['emp_entertainment_allowance'],
                'mba' => $postData['emp_telephone_allowance'],
                'oa' => $postData['emp_other_allowance'],
                'pb' => $postData['emp_performance_bonus'],
                'bonus' => $postData['emp_special_bonus'],
                'festival_bonus' => $postData['emp_festival_bonus'],
                'pfa' => $postData['emp_pf_allowance'],
                'gratuity' => $postData['emp_gratuity'],
                'ot_hour' => $postData['emp_ot_hour'],
                'ot_taka' => $postData['emp_ot_taka'],
                'arear' => $postData['emp_arear'],
                'hma' => $postData['emp_hma_allowance'],
                'present_salary' => $postData['present_salary'],
                'gross_salary' => $postData['emp_gross_salary'],
                'loan' => $postData['emp_loan'],
                'advance_salary' => $postData['emp_advance_salary'],
                'incentive' => $postData['emp_incentive'],
                'late_day' => $postData['late_day'],
                'late_deduct' => $postData['late_deduction'],
                'early_day' => $postData['early_day'],
                'early_deduct' => $postData['early_deduction'],
                'absent_day' => $postData['emp_absent_day'],
                'absent_day_taka' => $postData['emp_absent_taka'],
                'arrear_pf' => $postData['arrear_pf'],
                'pf' => $postData['emp_provident_fund_deduction'],
                'tax' => $postData['emp_tax_deduction'],
                'other_deduct' => $postData['emp_other_deduction'],
                'other_deduction_note' => $postData['other_deduction_note'],
                // 'total_deduction' => $postData['GGGGGGGG'],
                'net_salary' => $postData['emp_net_payment'],

                'updated_at' => $this->current_time(),
                'updated_by' => $this->session->userdata('user_id')
            );
            $updateCondition = array('id' => $payslipId);
            $result = $this->Payroll_model->updatePayslipGeneratorData($paramsData, $updateCondition);
            if ($result == true) {
                $this->session->set_flashdata('success', "Pay slip updated successfully of $empName month of $month'$year!  ");
            } else {
                $this->session->set_flashdata('error', "Pay slip not updated!");
            }
        }

        if ($pageName == 'payment') {
            redirect('pay-slip-payment');
        } else {
            redirect('pay-slip-confirmation');
        }
    }

    public function deletePayslip()
    {
        $payslipId = $this->uri->segment(2);
        $result = $this->Payroll_model->deletePayslipById($payslipId);
        if ($result == true) {
            $this->session->set_flashdata('success', "Pay slip deleted successfully. ");
        } else {
            $this->session->set_flashdata('error', "Pay slip not deleted!");
        }

        //redirect('pay-slip-confirmation');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function deleteMultiplePayslip()
    {
        $userId = $this->session->userdata('user_id');
        $payslipIds = $this->input->get_post('payslip_id');
        $ids = (explode(',', $payslipIds));
        $this->Payroll_model->deleteMultiplePayslip($ids);
    }

    public function paymentPayslip()
    {
        $searchpage = "payslip_payment";
        $user_id = $this->user_id;
        $data['user_id'] = $this->user_id;
        $data['user_name'] = $this->user_name;
        $data['user_type'] = $this->user_type;
        $data['user_division'] = $this->user_division;
        $data['user_department'] = $this->user_department;
        $data['all_company_access'] = $this->all_company_access;

        if ($this->input->post('add_btn')) {
            $year = $this->input->post('year');
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
        if ($this->uri->segment(3)) {

            $edit_id = $this->uri->segment(3);
            $updateData = array(
                'status' => 1,
                'updated_at' => $this->current_time(),
                'updated_by' => $user_id
            );
            $updateCondition = array('id' => $edit_id);
            $result = $this->Payroll_model->updatePayslipGeneratorData($updateData, $updateCondition);
            if ($result == true) {

                $this->session->set_flashdata('success', "Pay slip confirmed successfully.");
            } else {
                $this->session->set_flashdata('error', "Pay slip not confirmed!");
            }
            redirect('pay-slip-confirmation');
        }
        if ($this->input->post('payment_btn')) {

            $this->form_validation->set_rules('amount', 'Payment Amount', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('success', "SORRY! " . validation_errors());
                redirect('pay-slip-payment');
            } else {

                $paymentData = $this->input->post();
                $paySlipId = $paymentData['payment_payslip_id'];
                $amount = $paymentData['amount'];
                $netSalary = $paymentData['net_total'];
                $dueAmount = $paymentData['due_amount'];
                $paidAmount = $paymentData['paid_amount'];
                # $accountId = $paymentData['account_id'];
                if ($amount > $dueAmount) {
                    $this->session->set_flashdata('error', "Amount not valid!");
                    redirect('pay-slip-payment');
                } else {

                    $paySlipInfo = $this->Payroll_model->getPaySlipInfoById($paySlipId);
                    //print_r($paySlipInfo); exit;
                    if ($paySlipInfo->status == 1) { //Confirmed & first payment
                        $loanAmount = $paySlipInfo->loan;
                        $loanDisId = $paySlipInfo->loan_disbursement_id;
                        $content_id = $paySlipInfo->content_id;
                        if ($loanAmount > 0) {
                            //print_r($paySlipInfo); exit;
                            $loanDisInfo = $this->Payroll_model->getLoanDisbursementInfoById($loanDisId);
                            $loanId = $loanDisInfo->loan_id;
                            // Update loan status if loan ---------------
                            $this->load->model('Loan_model');
                            $this->Loan_model->updateLoanInfo($loanId, $loanAmount);
                            $this->Loan_model->updateLoanDisbursementInfo($loanDisId);
                            $loanTransData = array(
                                'TransDate' => date('Y-m-d', strtotime($paymentData['payment_date'])),
                                // 'AccountID' => $accountId,
                                'TTypeID' => 1,
                                'CategoryID' => 76, // Loan Repayment
                                'Amount' => $loanAmount,
                                'Cr' => $loanAmount,
                                'Ref' => $loanDisId,
                                'CreatedAt' => $this->current_time(),
                                'CreatedBy' => $this->session->userdata('user_id')
                            );
                            $this->Loan_model->insertPaymentTransData($loanTransData);
                            #$this->Loan_model->updateAccountBalanceCr($accountId, $amount);
                            $paramsData = array(
                                'loan_id' => $loanId,
                                'loan_disbursement_id' => $loanDisId,
                                // 'account_id' => $accountId,
                                'content_id' => $content_id,
                                'posting_date' => date('Y-m-d', strtotime($paymentData['payment_date'])),
                                'payment_date_was' => "$paySlipInfo->year-$paySlipInfo->month_id-01",
                                'year' => $paySlipInfo->year,
                                'payment_method' => 1,
                                'total_amount' => $loanAmount,
                                'created_at' => $this->current_time(),
                                'created_by' => $this->session->userdata('user_id')
                            );
                            $this->Loan_model->insertLoanPayment($paramsData);
                        }
                    }

                    $paymentData = array(
                        'payroll_id' => $paySlipId,
                        //'account_id' => $accountId,
                        'payment_date' => date('Y-m-d', strtotime($paymentData['payment_date'])),
                        'amount' => $amount,
                        'created_at' => $this->current_time(),
                        'created_by' => $this->session->userdata('user_id')
                    );
                    $paymentId = $this->Payroll_model->insertPayslipPaymentData($paymentData);

                    if ($paymentId == true) {
                        $transactionData = array(
                            'TransDate' => date('Y-m-d', strtotime($paymentData['payment_date'])),
                            //'AccountID' => $accountId,
                            'TTypeID' => 2,
                            'CategoryID' => 6,
                            'Amount' => $amount,
                            'Dr' => $amount,
                            'Ref' => $paymentId,
                            'CreatedAt' => $this->current_time(),
                            'CreatedBy' => $this->session->userdata('user_id')
                        );
                        $this->Payroll_model->insertPaymentTransData($transactionData);
                        //$this->Payroll_model->updateAccountBalance($accountId, $amount);

                        // update payslip paid amount and status -----------------------
                        $paidAmount = $paidAmount + $amount;
                        if ($dueAmount == $amount) {
                            $status = 3;
                        } else if ($amount < $dueAmount) {
                            $status = 2;
                        }
                        $updateData = array(
                            'total_paid' => $paidAmount,
                            'status' => $status,
                            'updated_at' => $this->current_time(),
                            'updated_by' => $user_id
                        );
                        $updateCondition = array('id' => $paySlipId);
                        $result = $this->Payroll_model->updatePayslipGeneratorData($updateData, $updateCondition);
                        $this->session->set_flashdata('success', "Payment completed successfully.");
                    } else {
                        $this->session->set_flashdata('error', "Payment not completed!");
                    }
                    redirect('pay-slip-payment');
                }
            }
        }
        $default_info = $this->search_field_emp_model->getsearchQuery($searchpage);
        $data['company'] = $default_info['table_view'];
        $data['division'] = $default_info['per_page'];
        $data['year'] = $default_info['year'];
        $data['month_name'] = $default_info['month'];
        $search_query = $default_info['search_query'];
        $data['paySlips'] = $this->Payroll_model->getPaySlip($searchpage, $search_query);
        $data['months'] = $this->Payroll_model->getMonths();

        if ($this->user_type == 1 || $this->all_company_access['status'] == 1) {
            $data['alldivision'] = $this->taxonomy->getTaxonomyByvid(1);
        } else {
            if ($this->user_department) {
                $data['department_selected'] = $this->taxonomy->getTaxonomyBytid($this->user_department);
            } else {
                $data['department_selected'] = $this->taxonomy->getTaxonomychildbyparent($this->user_division);
            }
            $data['alldivision'] = $this->taxonomy->getTaxonomyBytid($this->user_division);
        }
        $this->noCache(); // for clear cache
        $data['years'] = $this->db->query("SELECT * FROM tbl_years WHERE status=1")->result();

        $this->load->view('payroll/payslip-payment', $data);
    }

    public function getPaymentDetailByPaySlipId()
    {
        $id = $this->input->post('payslip_id');
        $sdata['payslip_id'] = $id;
        $sdata['paySlipInfo'] = $this->Payroll_model->getPaySlipData($id);
        $sdata['paymentDetailInfo'] = $this->Payroll_model->getPaymentDetailData($id);
        $this->load->view("payroll/payment-detail", $sdata);
    }

    public function paySlip($id)
    {
        # echo $id; exit;

        $this->load->library("pdf");
        $mpdf = $this->pdf->load();
        #require_once FCPATH . '/vendor/autoload.php';

        #$mpdf = new \Mpdf\Mpdf();

        $data['paySlipInfo'] = $this->Payroll_model->getPaySlipData($id);
        $data['emp_details_records'] = $this->emp_details_model->getallcontentByid($data['paySlipInfo']->content_id);

        $html = $this->load->view('payroll/payslip-pdf', $data, true);

        // $mpdf->SetProtection(array('print'), 'pass2open', 'pass2havefullaccess');
        // $mpdf->SetVisibility('screenonly'); 
        #$mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetVisibility('hidden');
        // $mpdf->SetProtection(array('copy','print','modify'), 'r', 'MyPassword');
        #$mpdf->SetJS('this.print();');

        $mpdf->WriteHTML(utf8_encode($html));

        $pdfFilePath = "payslip-of-" . $data['paySlipInfo']->emp_name . "-for-the-month-of-" . $data['paySlipInfo']->month_name . "'" . $data['paySlipInfo']->year . ".pdf";
        $mpdf->Output($pdfFilePath, "I"); // Preview In browser
        // Preview In Firefox browser problem Issue: Menu Bar(Alt) >> Tools >> options >> General >> Applications >> PDF >> Select Action >>Preview in Firefox.

    }

    public function getPayslipDetailByPaySlipId()
    {
        $id = $this->input->post('payslip_id');
        $data['payslip_id'] = $id;
        $data['paySlipInfo'] = $this->Payroll_model->getPaySlipData($id);
        //        print_r($data);
        //        exit;
        $this->load->view("payroll/payslip-detail", $data);
    }

   

    function uploadSalaryIncrement()
    {

        if ($this->input->post('upload_btn')) {
            $postData = $this->input->post();
            $config = array(
                'upload_path' => './resources/uploads/data/',
                'allowed_types' => 'xls|xlsx'
            );
            $data['error'] = '';    //initialize image upload error array to empty
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload()) {
                $data['error'] = $this->upload->display_errors();
                $this->session->set_flashdata('error', $data['error']);
            } else {
                // echo "OK";
                $fileData = $this->upload->data();

                /* Open Uploaded File */
                $openFile = './resources/uploads/data/' . $fileData['file_name'];
                /** Load $inputFileName to a Spreadsheet object * */
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($openFile);

                // Rename worksheet
                $sheet = $spreadsheet->getActiveSheet();
                $rowArray = $sheet->toArray();
                $rows = $sheet->getHighestRow();
                $recordRows = $rows - 2;
                $i = 2; // record start from row 2
                for ($i; $i < $recordRows; $i++) {
                    //                         $empId=$sheet->getCell('B'.$i)->getValue();                                                  
                    //                         $incrementAmount=$sheet->getCell('C'.$i)->getValue();
                    //                         $incDate=$sheet->getCell('D'.$i)->getValue();
                    $slNo = $rowArray[$i][0];  // Column A=0 
                    $empId = $rowArray[$i][1];  // Column B=1                                                
                    $incrementAmount = $rowArray[$i][2];  // Column C=2
                    $incDate = $rowArray[$i][3];  // Column D=3
                    //                         $unixTimestamp = ($incDate - 25569) * 86400;                        
                    //                         $incrementDate= date('d-m-Y', $unixTimestamp);

                    $incrementDate = date('d-m-Y', strtotime($incDate));
                    if ($incrementDate == "01-01-1970") {
                        $incrementDate = NULL;
                    }

                    $contentInfo = $this->Payroll_model->getContentId($empId);
                    $contentId = $contentInfo->id;


                    $presentSalaryInfo = $this->Payroll_model->getPresentSalary($contentId);
                    $presentSalary = $presentSalaryInfo->gross_salary;

                    if (!$presentSalary) {
                        $presentSalary = 0;
                    }
                    $incrementPercentage = number_format(($incrementAmount * 100) / $presentSalary);
                    $grossSalary = $presentSalary + $incrementAmount;
                    $yearlySalary = $grossSalary * 12;
                    $basicSalary = $grossSalary / 2;
                    //          ========= Allowances Info =====================================
                    $houseRent = ($basicSalary * 60) / 100;
                    $medicalAllow = ($basicSalary * 20) / 100;
                    $transportAllow = ($basicSalary * 10) / 100;
                    $othersAllow = ($basicSalary * 10) / 100;

                    $paramsData = array(
                        'content_id' => $contentId,
                        'gross_salary' => $grossSalary,
                        'basic_salary' => $basicSalary,
                        'house_rent' => $houseRent,
                        'medical_allow' => $medicalAllow,
                        'transport_allow' => $transportAllow,
                        'other_allow' => $othersAllow,
                        'increment_percentage' => $incrementPercentage . "%",
                        'increment_amount' => $incrementAmount,
                        'increment_date' => $incrementDate,
                        'yearly_paid' => $yearlySalary,
                        'created' => $this->current_time(),
                        'created_by' => $this->session->userdata('user_id')
                    );
                    // print_r($paramsData);
                    //                         echo $incrementDate;
                    //                         exit;
                    if ($contentId && $incrementAmount && ($incrementAmount > 0) && $incrementDate) {
                        $result = $this->Payroll_model->insertSalaryIncrementData($paramsData);
                        if ($result == true) {
                            $empNumber = $i - 1;
                            $this->session->set_flashdata('success', "$empNumber Employee Salary Increment data Imported Successfully!");
                        } else {
                            $this->session->set_flashdata('error', "Data Not imported. Something Wrong!");
                        }
                    }
                }
                unlink($openFile); // delete file after imported.
            }
            redirect('upload-salary-increment');
        }
        $this->load->view('payroll/upload-salary-increment');
    }

    function progressBar()
    {
        $this->load->view('payroll/progress_bar');
    }

    function progress_bar()
    {

        session_start();

        ini_set('max_execution_time', 0); // to get unlimited php script execution time

        if (empty($_SESSION['i'])) {
            $_SESSION['i'] = 0;
        }

        $total = 100;
        for ($i = $_SESSION['i']; $i < $total; $i++) {
            $_SESSION['i'] = $i;
            $percent = intval($i / $total * 100) . "%";

            sleep(1); // Here call your time taking function like sending bulk sms etc.

            echo '<script>
    parent.document.getElementById("progressbar").innerHTML="<div style=\"width:' . $percent . ';background:linear-gradient(to bottom, rgba(125,126,125,1) 0%,rgba(14,14,14,1) 100%); ;height:35px;\">&nbsp;</div>";
    parent.document.getElementById("information").innerHTML="<div style=\"text-align:center; font-weight:bold\">' . $percent . ' is processed.</div>";</script>';

            ob_flush();
            flush();
        }
        echo '<script>parent.document.getElementById("information").innerHTML="<div style=\"text-align:center; font-weight:bold\">Process completed</div>"</script>';

        session_destroy();
    }

    public function deduction()
    {
        $userId = $this->session->userdata('user_id');
        $userDivision = $this->session->userdata('user_division');
        $userDepartment = $this->session->userdata('user_department');
        if (!$userDepartment) {
            $data['employees'] = $this->Payroll_model->getEmployeeDeductionByDivision($userDivision);
        } else {
            $data['employees'] = $this->Payroll_model->getEmployeeDeductionByDivisionAndDepartment($userDivision, $userDepartment);
        }
        $this->load->view('payroll/settings/deductions', $data);
    }

    public function allowance()
    {
        $userId = $this->session->userdata('user_id');
        $userDivision = $this->session->userdata('user_division');
        $userDepartment = $this->session->userdata('user_department');
        if (!$userDepartment) {
            $data['employees'] = $this->Payroll_model->getEmployeeAllowanceByDivision($userDivision);
        } else {
            $data['employees'] = $this->Payroll_model->getEmployeeAllowanceByDivisionAndDepartment($userDivision, $userDepartment);
        }
        $this->load->view('payroll/settings/allowances', $data);
    }

    public function paymentMethod()
    {
        $userId = $this->session->userdata('user_id');
        $userDivision = $this->session->userdata('user_division');
        $userDepartment = $this->session->userdata('user_department');
        if (!$userDepartment) {
            $data['employees'] = $this->Payroll_model->getEmployeePaymentMethodByDivision($userDivision);
        } else {
            $data['employees'] = $this->Payroll_model->getEmployeePaymentMethodByDivisionAndDepartment($userDivision, $userDepartment);
        }
        $data['bank_names'] = $this->Payroll_model->getActiveBankName();
        $data['payment_methods'] = $this->Payroll_model->getActivePaymentMethod();
        $this->load->view('payroll/settings/payment-method', $data);
    }

    public function deductionSetting($table)
    {
        $columnName = $this->input->post('name');
        $newValue = $this->input->post('value');
        $contentId = $this->input->post('pk');
        $empDeductionInfo = $this->db->query("SELECT * FROM emp_salary_deduction WHERE content_id=$contentId ORDER BY id DESC LIMIT 1")->row();

        if ($empDeductionInfo) {
            if ($columnName == 'tax_deduction') {
                $taxDeduction = $newValue;
                $pFund = $empDeductionInfo->provident_fund_deduction;
                $otherDeduction = $empDeductionInfo->other_deduction;
            } else if ($columnName == 'provident_fund_deduction') {
                $taxDeduction = $empDeductionInfo->tax_deduction;
                $pFund = $newValue;
                $otherDeduction = $empDeductionInfo->other_deduction;
            } else if ($columnName == 'other_deduction') {
                $taxDeduction = $empDeductionInfo->tax_deduction;
                $pFund = $empDeductionInfo->provident_fund_deduction;
                $otherDeduction = $newValue;
            }
            $totalDeduction = $taxDeduction + $pFund + $otherDeduction;
            // UPDATE ---------------------------
            $this->db->set($columnName, $newValue);
            $this->db->set("total_deduction", $totalDeduction);
            $this->db->set('updated', $this->current_time());
            $this->db->set('updated_by', $this->session->userdata('user_id'));
            $this->db->where('content_id', $contentId);
            $result = $this->db->update('emp_salary_deduction');
        } else {
            // INSERT --------------------------
            $data = array(
                "content_id" => $contentId,
                "$columnName" => $newValue,
                "total_deduction" => $newValue,
                "created" => $this->current_time(),
                "created_by" => $this->session->userdata('user_id')
            );
            $result = $this->db->insert("emp_salary_deduction", $data);
        }
        return $result;
    }

    public function allowanceSetting($table)
    {
        $columnName = $this->input->post('name');
        $newValue = $this->input->post('value');
        $contentId = $this->input->post('pk');
        //        $empAllowanceInfo = $this->db->query("SELECT MAX(id),basic_salary,house_rent,medical_allow,conveyance_allow,telephone_allow,special_allowa,provident_allow,transport_allow,other_allow,performance_bonus,festival_bonus FROM emp_salary  WHERE content_id = $contentId")->row();
        $empAllowanceInfo = $this->db->query("SELECT MAX(id) AS id FROM emp_salary  WHERE content_id = $contentId")->row();

        if ($empAllowanceInfo) {
            //            if($columnName=='conveyance_allow'){
            //                $convAllow = $newValue;
            //                $pFund = $empDeductionInfo->provident_fund_deduction;
            //                $otherDeduction = $empDeductionInfo->other_deduction;
            //            }else if($columnName=='telephone_allow'){
            //                $taxDeduction = $empDeductionInfo->tax_deduction;
            //                $teleAllow = $newValue;
            //                $otherDeduction = $empDeductionInfo->other_deduction;
            //            }
            //            $totalDeduction = $taxDeduction + $pFund + $otherDeduction;
            // UPDATE ---------------------------
            $this->db->set($columnName, $newValue);
            //            $this->db->set("total_deduction", $totalDeduction);
            $this->db->set('updated', $this->current_time());
            $this->db->set('updated_by', $this->session->userdata('user_id'));
            $this->db->where('content_id', $contentId);
            $this->db->where('id', $empAllowanceInfo->id);
            $result = $this->db->update('emp_salary');
        } else {
            // INSERT --------------------------            
        }
        return $result;
    }

    public function bankAccountSetting($table)
    {
        $columnName = $this->input->post('name');
        $newValue = $this->input->post('value');
        $contentId = $this->input->post('pk');
        $empPaymentMethodInfo = $this->db->query("SELECT * FROM emp_payment_method WHERE content_id=$contentId ORDER BY id DESC LIMIT 1")->row();
        if ($empPaymentMethodInfo) {
            // Edit ----------------------------------
            $this->db->set($columnName, $newValue);
            $this->db->set('updated', $this->current_time());
            $this->db->set('updated_by', $this->session->userdata('user_id'));
            $this->db->where('content_id', $contentId);
            $result = $this->db->update('emp_payment_method');
        } else {
            // INSERT -----------------------------
            $data = array(
                "content_id" => $contentId,
                "$columnName" => $newValue,
                "created" => $this->current_time(),
                "created_by" => $this->session->userdata('user_id')
            );
            $result = $this->db->insert("emp_payment_method", $data);
        }
    }

    public function updateTIN()
    {
        $columnName = $this->input->post('name');
        $newValue = $this->input->post('value');
        $contentId = $this->input->post('pk');
        // Edit ----------------------------------
        $this->db->set($columnName, $newValue);
        $this->db->set('updated_at', $this->current_time());
        $this->db->set('updated_by', $this->session->userdata('user_id'));
        $this->db->where('content_id', $contentId);
        $result = $this->db->update('search_field_emp');
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

    

    public function getEmployeeWisePayslip()
    {
        $empContentId = $this->input->post('emp_name');
        $year = $this->input->post('year');
        $data['employeInfo'] = $this->search_field_emp_model->getEmployeeInfoById($empContentId);
        $data['year'] = $year;
        $data['paySlips'] = $this->Payroll_model->getPayslipByEmployeeId($empContentId, $year);
        $this->load->view("payroll/report/employee-wise-payslip-report-result", $data);
    }

    function noCache()
    {
        $this->output->set_header("HTTP/1.0 200 OK");
        $this->output->set_header("HTTP/1.1 200 OK");
        $this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }
}
