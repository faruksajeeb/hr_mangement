<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LeaveEncashmentController extends CI_Controller
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
    function leaveEncashment()
    {
        $data['title'] = "PF Payment";
        $where = "";
        if ($this->input->get()) {
            $search_content_id = $this->input->get('search_content_id');
            if ($search_content_id) {
                $where .= " AND MA.content_id=" . $search_content_id;
            }
            $search_leave_type_id = $this->input->get('search_leave_type_id');
            if ($search_leave_type_id) {
                $where .= " AND MA.leave_type_id=" . $search_leave_type_id;
            }
            $date_from = $this->input->get('date_from');
            if ($date_from) {
                $where .= " AND MA.encashment_date>='$date_from'";
            }
            $date_to = $this->input->get('date_to');
            if ($date_to) {
                $where .= " AND MA.encashment_date<='$date_to'";
            }
        }
        $data['records'] = $this->db->query("SELECT MA.*,
        SFE.emp_name,SFE.emp_id,SFE.mobile_no,leave_type.name as leave_type_name       
        FROM tbl_leave_encashments MA 
        LEFT JOIN search_field_emp SFE ON SFE.content_id=MA.content_id 
        LEFT JOIN taxonomy leave_type ON leave_type.id=MA.leave_type_id 
        WHERE encashment_amount IS NOT NULL $where ORDER BY MA.id DESC LIMIT 100")->result();
        $data['active_employees'] = $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153/*Left*/,473/*Terminated*/)")->result();
        $data['leave_types'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=16")->result();
        $this->load->view('leave/leave_encashment/manage_leave_encashment', $data);
    }
    function create()
    {
        $data['active_employees'] = $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153/*Left*/,473/*Terminated*/)")->result();
        $data['leave_types'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=16")->result();
        echo  $this->load->view('leave/leave_encashment/add_leave_encashment', $data);
    }
    function save()
    {
        date_default_timezone_set('Asia/Dhaka');
        $data['title'] = "Save Leave Encashment";
        $this->load->library('form_validation');
        $this->form_validation->set_rules('content_id', 'Employee', 'required|callback_check_duplicate');
        $this->form_validation->set_rules('payment_type', 'Payment type', 'required');
        $this->form_validation->set_rules('encashment_date', 'encashment_date', 'required|callback_valid_date');
        $this->form_validation->set_rules('leave_type_id', 'leave_type_id', 'required');
        $this->form_validation->set_rules('encashed_days', 'encashed_days', 'required');
        $this->form_validation->set_rules('encashment_amount', 'encashment_amount', 'required');

        if ($this->form_validation->run() == FALSE) {
            # for ajax call
            // if( validation_errors() ){
            // 	exit("Submit Error:\n".strip_tags(validation_errors()));
            // }
            #dd(validation_errors());
            $this->session->set_flashdata('message', validation_errors());

            redirect('leave-encashment');
        }
        $input = $this->input->post();
        // dd($input);
        $contentId = $input['content_id'];

        $actionTime = date("Y-m-d H:i:s", strtotime("now"));
        $actionBy = $_SESSION['user_id'];
        $salaryData = array(
            'content_id' => $contentId,
            'leave_type_id' => $input['leave_type_id'],
            'encashment_date' => $input['encashment_date'],
            'encashed_days' => $input['encashed_days'],
            'payment_type' => $input['payment_type'],
            'per_day_amount' => $input['per_day_amount'],
            'encashment_amount' => $input['encashment_amount'],
            'remarks' => $input['remarks'],
            'created_at' => $actionTime,
            'created_by' => $actionBy
        );

        if ($editId = $input['edit_id']) {
            $this->db->where('id', $editId)->update('tbl_leave_encashments', $salaryData);
            $this->session->set_flashdata('message', "Leave encashment data updated successfully!");
        } else {
            $this->db->insert('tbl_leave_encashments', $salaryData);
            $this->session->set_flashdata('message', "Leave encashment added successfully!");
        }

        redirect('leave-encashment');
    }
    
    function edit()
    {
        $edit_id = $this->input->get('edit_id');
        $data['edit_data'] = $this->db->query("SELECT *
        FROM tbl_leave_encashments 
        WHERE id=$edit_id")->row();
        $data['active_employees'] = $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153/*Left*/,473/*Terminated*/)")->result();
        $data['leave_types'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=16")->result();
        echo  $this->load->view('leave/leave_encashment/add_leave_encashment', $data);
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
        $encashment_date = $this->input->post('encashment_date');
        $leave_type_id = $this->input->post('leave_type_id');
        if ($this->input->post('edit_id'))
            $edit_id = $this->input->post('edit_id');
        else
            $edit_id = '';

        $this->db->where('content_id', $emp_content_id);
        $this->db->where('leave_type_id', $leave_type_id);
        $this->db->where('encashment_date', $encashment_date);
        if ($edit_id) {
            $this->db->where_not_in('id', $edit_id);
        }
        $result = $this->db->get('tbl_leave_encashments')->num_rows();
        #dd($this->db->last_query());
        // if ($result == 0)
        if ($edit_id || ($result == 0))
            $response = true;
        else {
            $this->form_validation->set_message('check_encashment_amount', 'Sorry, Duplicate record found!');
            $response = false;
        }
        return $response;
    }
}
