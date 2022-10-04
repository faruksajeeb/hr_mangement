<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class UpdateController extends CI_Controller {

    function __construct() {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $autoload['libraries'] = array('globals');
    }

    public function index() {

        //$this->load->view('recruiting/addprofile');
        // redirect("addprofile/addemployee");
    }

    public function updateProvisionData() {
      // echo "Updating...";
     //  exit;
        // Check provision period expaired employee ----------------------------------------------------------------
        date_default_timezone_set('Asia/Dhaka');
        $serverTime = time();
        $todayDate = date("d-m-Y", $serverTime);
        $res = $this->db->select("ep.provision_date_to as provision_end_date,sfe.content_id,sfe.type_of_employee ")
                ->from("search_field_emp AS sfe")
                ->join("emp_provision AS ep", "sfe.content_id=ep.content_id ")
                ->where("sfe.type_of_employee", 155)
                ->where("ep.insertflag", 0)
                ->where("STR_TO_DATE(ep.provision_date_to, '%d-%m-%Y') < STR_TO_DATE('$todayDate', '%d-%m-%Y') ")
                ->get();
       // $res = $this->db->select('*')->from('search_field_emp')->get();
        $provitionToPermanent = $res->result_array();
    //print_r($provitionToPermanent);
     //  exit;
        
        // Update provision to permanent ------------------------------------------------------------------------------
        if ($provitionToPermanent) {
        
            foreach ($provitionToPermanent as $single) {
                $this->updateEmployeeProvisionPeriod($single['content_id'], $single['provision_end_date']);
            }
            $this->session->set_flashdata('success', "Software updated!");
        }else{
            $this->session->set_flashdata('success', "Nothing changed!");
        }
        redirect('dashboard', 'refresh');
    }

    function updateEmployeeProvisionPeriod($contentId, $provisionEndDate) {
        $has_last_history = $this->emp_job_history_model->getemp_last_job_history($contentId);
        $previousId = $has_last_history['id'];
        $empTypeId = $has_last_history['emp_type_tid'];
        if ($empTypeId == '155') {         
            $updateData = array(
                'end_date' => $provisionEndDate,
                'updated_time' => getCurrentDateTime(),
                'updated_by' => $this->session->userdata('user_id')
            );
            $update_condition = array('id' => $previousId);
            $updateJobHistory = $this->emp_job_history_model->updemp_job_historytbl($updateData, $update_condition);
            if ($updateJobHistory == true) {
                // insert new history
                $startPermanentDate = $last_end_date = date('d-m-Y', (strtotime('+1 day', strtotime($provisionEndDate))));
                $insertData = array(
                    'content_id' => $has_last_history['content_id'],
                    'start_date' => $startPermanentDate,
                    'division_tid' => $has_last_history['division_tid'],
                    'department_tid' => $has_last_history['department_tid'],
                    'post_tid' => $has_last_history['post_tid'],
                    'grade_tid' => $has_last_history['grade_tid'],
                    'emp_type_tid' => '1',
                    'created_time' => getCurrentDateTime(),
                    'created_by' => $this->session->userdata('user_id')
                );
                $insertJobHostory = $this->db->insert("emp_job_history", $insertData);
            }
        
        if ($insertJobHostory) {
            $condition = array('content_id' => $contentId);
            $updateProvisionData = array(
                'insertflag' => 1,
                'updated' => getCurrentDateTime(),
                'updated_by' => $this->session->userdata('user_id')
            );
            $this->emp_provision_model->updEmp_provisiontbl($updateProvisionData, $condition);
            $empUpdateData = array(
                'type_of_employee' => '1'
            );
            $this->search_field_emp_model->updSearch_field_contenttbl($empUpdateData, $condition);
        }
        }
    }

}

?>