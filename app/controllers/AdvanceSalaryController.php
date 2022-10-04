<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AdvanceSalaryController extends CI_Controller
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
        $data['title'] = "Advance Salary";
        $data['advance_salaries'] = $this->db->query("SELECT ADS.*,
        SFE.emp_name,SFE.emp_id,SFE.mobile_no        
        FROM tbl_advance_salary ADS 
        LEFT JOIN search_field_emp SFE ON SFE.content_id=ADS.content_id 
        ")->result();
        $this->load->view('payroll/advance_salary/manage_advance_salary', $data);
    }
    function create()
    {
        $data['active_employees'] = $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153/*Left*/,473/*Terminated*/)")->result();
        $data['months'] = $this->db->query("SELECT * FROM tbl_month")->result();
        $data['years'] = $this->db->query("SELECT * FROM tbl_years")->result();
        echo  $this->load->view('payroll/advance_salary/add_advance_salary', $data);
    }
    function save()
    {
        date_default_timezone_set('Asia/Dhaka');
        $data['title'] = "Save Advance Salary";
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
            'remarks' => $input['remarks'],
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
    function edit()
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
}
