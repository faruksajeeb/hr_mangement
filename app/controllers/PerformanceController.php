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
        if ($postData = $this->input->post()) {
            
            $empContentId = $postData['emp_content_id'];
            $performanceSessionId = $postData['performance_session_id'];
            $empInfo = $this->db->query("SELECT * FROM search_field_emp WHERE content_id=?", array($empContentId))->row();
            $performanceSessionInfo = $this->db->query("SELECT * FROM performance_sessions WHERE id=?", array($performanceSessionId))->row();
            $appraiserContentId = $postData['appraiser_content_id'];
            $performanceData = array(
                'performance_session_id'=>$performanceSessionId,
                'content_id'=>$empContentId,
                'emp_id'=>$empInfo->emp_id,
                'company_id'=>$empInfo->emp_division,
                'division_id'=>$empInfo->emp_department,
                'department_id'=>$empInfo->department_id,
                'designation_id'=>$empInfo->emp_post_id,
                'appraiser_id'=>$appraiserContentId,
                'date_from'=>$performanceSessionInfo->appraisal_period_from,
                'date_to'=>$performanceSessionInfo->appraisal_period_to,
                'created_at'=>date('Y-m-d H:i:s',time()),
                'created_by'=> $this->session->userdata('user_id')
            );
            dd($performanceData);
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
