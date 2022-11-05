<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class PerformanceController extends CI_Controller
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
    public function createPerformanceSession()
    {
        if ($this->input->post()) {
        }
        $data['records'] = $this->db->query("SELECT * FROM performance_sessions")->result();
        $this->load->view('performance/create-performance-session', $data);
    }

    public function addEmployeePerformance()
    {
        if ($this->input->post()) {
        }
        $data['user_id'] = $this->session->userdata('employee_id');
        if (!$data['user_id']) {
            $data['user_id'] = 0000;
        }
        $data['performance_ratings'] = $this->db->query("SELECT * FROM performance_ratings WHERE status=1")->result();
        $data['general_performance_indicators'] = $this->db->query("SELECT * FROM performance_criteria_competency WHERE status=1")->result();
        $data['business_performance_indicators'] = $this->db->query("SELECT * FROM performance_criteria_business WHERE status=1")->result();
        $data['oranizations'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=1")->result();
        $data['branches'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=2")->result();
        $data['departments'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=22")->result();
        $data['designations'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=3")->result();
        $data['performance_sessions'] = $this->db->query("SELECT * FROM performance_sessions WHERE status=1")->result();
        $data['employees'] = $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee in(155,1) ORDER BY emp_name")->result();
        $this->load->view('performance/add-employee-performance', $data);
    }

    public function getPerformanceSessionInfoById($id)
    {
        if ($id) {
            $res = $this->db->query("SELECT * FROM performance_sessions WHERE id=?", array($id))->row();
            if ($res) {
                echo json_encode($res);
            }
        }
    }

    public function getEmployeeInfoById($id)
    {
        if ($id) {
            $res = $this->db->query("SELECT * FROM search_field_emp WHERE content_id=?", array($id))->row();
            if ($res) {
                echo json_encode($res);
            }
        }
    }

    public function manageEmployeePerformance()
    {
    }
}
