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
       
        $data['performance_ratings'] = $this->db->query("SELECT * FROM performance_ratings WHERE status=1")->result();
        
        $generalIndicatorRatings = $this->db->query("SELECT PCD.*,PCC.competency_performance_indicator as indicator_name,PCCD.name as sub_indicator_name 
        FROM performances_competency_details  PCD
        LEFT JOIN performance_criteria_competency PCC ON PCC.id=PCD.performance_criteria_parent_id
        LEFT JOIN performance_criteria_competency_details PCCD ON PCCD.id=PCD.performance_criteria_id
        WHERE performance_id=$id")->result();
        $customGeneralPerformancesDetails=array();
        foreach($generalIndicatorRatings as $val):
            $parentId = $val->performance_criteria_parent_id;
            $customGeneralPerformancesDetails[$parentId]['parent_indicator_name']= $val->indicator_name;
            $customGeneralPerformancesDetails[$parentId]['weight']= $val->weight;
            $customGeneralPerformancesDetails[$parentId]['rating']= $val->rating;
            $customGeneralPerformancesDetails[$parentId]['score']= $val->score;
            $customGeneralPerformancesDetails[$parentId]['records'][]=  $val;
        endforeach;

        $businessIndicatorRatings = $this->db->query("SELECT PBD.*,
        PCB.deliverable_area_or_perspective as indicator_name,
        PCB.target_or_kpi,
        PCB.achivment,
        PCBD.name as sub_indicator_name, 
        PCBD.name as sub_target_or_kpi, 
        PCBD.name as sub_achivment 
        FROM performances_business_details  PBD
        LEFT JOIN performance_criteria_business PCB ON PCB.id=PBD.performance_criteria_parent_id
        LEFT JOIN performance_criteria_business_details PCBD ON PCBD.id=PBD.performance_criteria_id
        WHERE performance_id=$id")->result();
        $customBusinessPerformancesDetails=array();
        foreach($businessIndicatorRatings as $val):
            $parentId = $val->performance_criteria_parent_id;
            $customBusinessPerformancesDetails[$parentId]['parent_indicator_name']= $val->indicator_name;
            $customBusinessPerformancesDetails[$parentId]['target_or_kpi']= $val->target_or_kpi;
            $customBusinessPerformancesDetails[$parentId]['achivment']= $val->achivment;
            $customBusinessPerformancesDetails[$parentId]['weight']= $val->weight;
            $customBusinessPerformancesDetails[$parentId]['rating']= $val->rating;
            $customBusinessPerformancesDetails[$parentId]['score']= $val->score;
            $customBusinessPerformancesDetails[$parentId]['records'][]=  $val;
        endforeach;
        
        $data['general_performances_rating_details'] = $customGeneralPerformancesDetails;
        $data['business_performances_rating_details'] = $customBusinessPerformancesDetails;
        
        $data['companyInfo'] = $this->db->query("SELECT * FROM company_info WHERE id=1")->row();
        $data['performanceInfo'] = $this->db->query("SELECT p.*,
        e.emp_name,e.emp_id,
        company.name as company_name,
        division.name as division_name,
        department.name as department_name,
        designation.name as designation_name,
        ps.performance_title,ap.emp_name as appraiser_name,
        ps.general_percentage,
        ps.business_percentage
        FROM performances p 
        LEFT JOIN search_field_emp as e ON e.content_id=p.content_id
        LEFT JOIN taxonomy as company ON company.id = p.company_id
        LEFT JOIN taxonomy as division ON division.id = p.division_id
        LEFT JOIN taxonomy as department ON department.id = p.department_id
        LEFT JOIN taxonomy as designation ON designation.id = p.designation_id
        LEFT JOIN performance_sessions as ps ON ps.id=p.performance_session_id
        LEFT JOIN search_field_emp as ap ON ap.content_id=p.appraiser_id WHERE p.id=?",array($id))->row();
        // $data['performancrGeneralInfo'] = $this->db->query()->result();
        // $data['performancrBusinessInfo'] = $this->db->query()->result();
        $html = $this->load->view('performance/print-single-performance-pdf', $data, true);
       // $mpdf->SetProtection(array('print'), 'pass2open', 'pass2havefullaccess');
        // $mpdf->SetVisibility('screenonly'); 
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetVisibility('hidden');
       // $mpdf->SetProtection(array('copy','print','modify'), 'r', 'MyPassword');
        //$mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output();
    }
}
