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
                'performance_session_id' => $performanceSessionId,
                'content_id' => $empContentId,
                'emp_id' => $empInfo->emp_id,
                'company_id' => $empInfo->emp_division,
                'division_id' => $empInfo->emp_department,
                'department_id' => $empInfo->department_id,
                'designation_id' => $empInfo->emp_post_id,
                'appraiser_id' => $appraiserContentId,
                'date_from' => $performanceSessionInfo->appraisal_period_from,
                'date_to' => $performanceSessionInfo->appraisal_period_to,
                'created_at' => date('Y-m-d H:i:s', time()),
                'created_by' => $this->session->userdata('user_id')
            );
            // dd($postData);

            #transition start
            $this->db->trans_begin();
            $exist = $this->db->query("SELECT * FROM performances WHERE performance_session_id=? AND content_id=?",array($performanceSessionId,$empContentId))->row();
            if($exist){   
                $this->db->query("DELETE FROM performances_competency_details WHERE performance_id=?",array($exist->id)); 
                $this->db->query("DELETE FROM performances_business_details WHERE performance_id=?",array($exist->id)); 
                $this->db->query("DELETE FROM performances WHERE id=?",array($exist->id));             
            }
            #query one
            #insert performance data
            $this->db->insert('performances', $performanceData);
            #query two
            if ($insertId = $this->db->insert_id()) {
                #general performance
                if ($performanceSessionInfo->general == 'yes') {
                    $generalPerformanceData = array();
                    $totalNumberOfPerformanceCriteriaGeneral = count($postData['performance_criteria_parent_id']);
                    for ($i = 0; $i < $totalNumberOfPerformanceCriteriaGeneral; $i++) {
                        $generalPerformanceData[] = array(
                            'performance_id' => $insertId,
                            'performance_criteria_parent_id' => $postData['performance_criteria_parent_id'][$i],
                            'performance_criteria_id' => $postData['performance_criteria_id'][$i],
                            'weight' => $postData['general_weight'][$i],
                            'rating' => $postData['general_rate'][$i],
                            'score' => $postData['general_score'][$i],
                        );
                    }
                    //dd($generalPerformanceData);
                    $this->db->insert_batch('performances_competency_details',$generalPerformanceData);
                }

                #business performance
                if ($performanceSessionInfo->business == 'yes') {
                    $businessPerformanceData = array();
                    $totalNumberOfPerformanceCriteriaBusiness = count($postData['performance_bus_criteria_parent_id']);
                    for ($i = 0; $i < $totalNumberOfPerformanceCriteriaBusiness; $i++) {
                        $businessPerformanceData[] = array(
                            'performance_id' => $insertId,
                            'performance_criteria_parent_id' => $postData['performance_bus_criteria_parent_id'][$i],
                            'performance_criteria_id' => $postData['performance_bus_criteria_id'][$i],
                            'weight' => $postData['business_weight'][$i],
                            'rating' => $postData['business_rate'][$i],
                            'score' => $postData['business_score'][$i],
                        );
                    }
                    // dd(count($businessPerformanceData));
                    $this->db->insert_batch('performances_business_details',$businessPerformanceData);
                }
            }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error',"Something went wrong!");
                redirect('add-employee-performance');
            } else {
                $this->db->trans_commit();
                $this->session->set_flashdata('success',"Performance inserted successfully!");
                redirect('add-employee-performance');
            }
            //$this->db->trans_off();
            #transition end
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
        $data['title'] = 'Manage Employee- Performance';

        $data['oranizations'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=1")->result();
        $data['branches'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=2")->result();
        $data['departments'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=22")->result();
        $data['designations'] = $this->db->query("SELECT * FROM taxonomy WHERE vid=3")->result();
        $data['performance_sessions'] = $this->db->query("SELECT * FROM performance_sessions WHERE status=1")->result();
        $data['employees'] = $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee in(155,1) ORDER BY emp_name")->result();  
        
        $data['records'] = $this->db->query("SELECT p.*,
        e.emp_name,e.emp_id,company.name as company_name,
        ps.performance_title,ap.emp_name as appraiser_name 
        FROM performances p 
        LEFT JOIN search_field_emp as e ON e.content_id=p.content_id
        LEFT JOIN taxonomy as company ON company.id=p.company_id
        LEFT JOIN performance_sessions as ps ON ps.id=p.performance_session_id
        LEFT JOIN search_field_emp as ap ON ap.content_id=p.appraiser_id")->result();
        
        $this->load->view('performance/manage-employee-performance',$data);
    }

    public function printSinglePerformance($id){
        $this->load->library("pdf");  
        $mpdf = $this->pdf->load();
        $html = $this->load->view('performance/print-single-performance-pdf', $data, true);
       // $mpdf->SetProtection(array('print'), 'pass2open', 'pass2havefullaccess');
        // $mpdf->SetVisibility('screenonly'); 
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetVisibility('hidden');
       // $mpdf->SetProtection(array('copy','print','modify'), 'r', 'MyPassword');
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output();
    }
}
