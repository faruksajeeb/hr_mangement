<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class FestivalBonusController extends CI_Controller
{
    function __construct()
    {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->helper('url');
    }
    function manage()
    {
        $data['title'] = "Festival Bonus";
        $data['records'] = $this->db->query("SELECT MA.*,
        SFE.emp_name,SFE.emp_id,SFE.mobile_no        
        FROM tbl_festival_bonus MA 
        LEFT JOIN search_field_emp SFE ON SFE.content_id=MA.content_id 
        ")->result();
        $this->load->view('payroll/festival_bonus/manage_festival_bonus', $data);
    }
    function create()
    {
        $data['active_employees'] = $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153/*Left*/,473/*Terminated*/)")->result();
        $data['months'] = $this->db->query("SELECT * FROM tbl_month")->result();
        $data['years'] = $this->db->query("SELECT * FROM tbl_years")->result();
        echo  $this->load->view('payroll/festival_bonus/add_festival_bonus', $data);
    }

    function createDivisionWise()
    {

        //$data['active_employees'] = $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153/*Left*/,473/*Terminated*/)")->result();
        $data['active_companies'] = $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153/*Left*/,473/*Terminated*/)")->result();
        $data['active_divisions'] = $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153/*Left*/,473/*Terminated*/)")->result();
        $data['months'] = $this->db->query("SELECT * FROM tbl_month")->result();
        $data['years'] = $this->db->query("SELECT * FROM tbl_years")->result();

        echo  $this->load->view('payroll/festival_bonus/add_division_festival_bonus', $data);
    }
    function save()
    {
        date_default_timezone_set('Asia/Dhaka');
        $data['title'] = "Save Festival Bonus";
        $this->load->library('form_validation');
        $this->form_validation->set_rules('content_id', 'Employee', 'required|callback_check_duplicate');
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

            redirect('festival-bonus');
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
            'remarks' => $input['remarks'],
            'created_at' => $actionTime,
            'created_by' => $actionBy
        );

        if ($editId = $input['edit_id']) {
            $this->db->where('id', $editId)->update('tbl_festival_bonus', $salaryData);
            $this->session->set_flashdata('message', "FestivalBonus data updated successfully!");
        } else {
            $this->db->insert('tbl_festival_bonus', $salaryData);
            $this->session->set_flashdata('message', "FestivalBonus added successfully!");
        }

        redirect('festival-bonus');
    }
    function saveDivisionWise()
    {
        date_default_timezone_set('Asia/Dhaka');
        $data['title'] = "Save Festival Bonus";
        $this->load->library('form_validation');

        $this->form_validation->set_rules('company_id', 'Company', 'required');
        $this->form_validation->set_rules('division_id', 'Division', 'required');
        $this->form_validation->set_rules('payment_type', 'Payment type', 'required');
        $this->form_validation->set_rules('payment_date', 'payment_date', 'required|callback_valid_date');
        $this->form_validation->set_rules('adjust_month', 'adjust_month', 'required');
        $this->form_validation->set_rules('adjust_year', 'adjust_month', 'required');

        if ($this->form_validation->run() == FALSE) {
            # for ajax call
            // if( validation_errors() ){
            // 	exit("Submit Error:\n".strip_tags(validation_errors()));
            // }
            #dd(validation_errors());
            $this->session->set_flashdata('message', validation_errors());

            redirect('festival-bonus');
        }
        $input = $this->input->post();
        #dd($input);
        $adjustMonth = $input['adjust_month'];
        $adjustYear = $input['adjust_year'];
        $company_id = explode('|', $input['company_id']);
        $company_id = $company_id[0];

        $division_id = explode('|', $input['division_id']);
        $division_id = $division_id[0];
        if ($division_id == 'all') {
            #get company wise employee
            $whereCondition = "SFE.emp_division=$company_id";
        } else {
            #get division wise employee
            $whereCondition = "SFE.emp_division=$company_id AND SFE.emp_department=$division_id";
        }
        $employeeInfo = $this->db->query("SELECT SFE.content_id,IFNULL(ES.gross_salary,0) as gross_salary,SFE.type_of_employee FROM search_field_emp as SFE LEFT JOIN emp_salary as ES ON ES.content_id=SFE.content_id WHERE SFE.type_of_employee IN(1/*permenent*/,155/*provision*/,863/*contactual*/) AND $whereCondition")->result();

        $actionTime = date("Y-m-d H:i:s", strtotime("now"));
        $actionBy = $_SESSION['user_id'];
        if ($employeeInfo) {
            $salaryData = array();
            $existMsg="";
            $existCount=0;
            $successCount=0;
            foreach ($employeeInfo as $v) :
                #check Exist
                $existOk = $this->db->query("SELECT * 
                FROM tbl_festival_bonus 
                WHERE content_id=$v->content_id 
                AND adjust_month=$adjustMonth AND adjust_year=$adjustYear 
                ");
                 #dd($this->db->last_query(),1);
                // dd($existOk->num_rows());
                if($existOk->num_rows()>0){
                    $existCount++;                    
                    $existOk = false;
                    continue;
                }
                $grossSalary = $v->gross_salary;
                $typeOfEmployee = $v->type_of_employee;
                $amount = 0;
                if($typeOfEmployee==1){
                    #permenent
                    $amount = ($grossSalary*$input['permenent_percentage'])/100;
                }elseif($typeOfEmployee==155){
                    #provision
                    $amount = ($grossSalary*$input['provision_percentage'])/100;
                }elseif($typeOfEmployee==863){
                    #contactual
                    $amount = ($grossSalary*$input['contactual_percentage'])/100;
                }
                
                $salaryData[] = array(
                    'content_id' => $v->content_id,
                    'payment_date' => $input['payment_date'],
                    'payment_type' => $input['payment_type'],
                    'adjust_month' => $input['adjust_month'],
                    'adjust_year' => $input['adjust_year'],
                    'amount' => $amount,
                    'remarks' => $input['remarks'],
                    'created_at' => $actionTime,
                    'created_by' => $actionBy
                );
                $successCount++;
            endforeach;
            $successMsg="";
            if($successCount > 0){
                $this->db->insert_batch('tbl_festival_bonus', $salaryData);            
                $successMsg=$successCount." festival bonus added successfully! ";
            }
            if($existCount>0){
                $existMsg = $existCount." data already exist.";
            }
            
            $this->session->set_flashdata('message', $successMsg." <br/>".$existMsg);
        
        }else{
            $this->session->set_flashdata('message', "Employee not found!"); 
        }
        redirect('festival-bonus');
    }
    function edit()
    {
        $edit_id = $this->input->get('edit_id');
        $data['edit_data'] = $this->db->query("SELECT *
        FROM tbl_festival_bonus 
        WHERE id=$edit_id")->row();
        $data['active_employees'] = $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153/*Left*/,473/*Terminated*/)")->result();
        $data['months'] = $this->db->query("SELECT * FROM tbl_month")->result();
        $data['years'] = $this->db->query("SELECT * FROM tbl_years")->result();
        echo  $this->load->view('payroll/festival_bonus/add_festival_bonus', $data);
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
    function check_duplicate($emp_content_id)
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
        $result = $this->db->get('tbl_festival_bonus')->num_rows();
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
}
