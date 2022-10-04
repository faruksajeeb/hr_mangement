<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
         error_reporting(0);
        parent::__construct();
        /*
        include('Visitor_controller.php');
    	$info=new Visitor_controller();
    	$info->setSubdomain(base_url());
    	$info->getVisitorInfo($_SERVER['HTTP_USER_AGENT']);
    	*/
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('admin-login');
        }   
        $this->load->model("Emp_leave_model","emp_leave_model");    
    }

    public function index() {
       $userName = $this->session->userdata('user_name');
       if ($userName =='ac-sadmin') { 
           $data['approval_notifications'] = $this->db->query("SELECT count(p.id) as pending_approval,p.company_id,p.month_id,p.year,m.month_name,p.year,t.name as company_name FROM tbl_payroll p LEFT JOIN tbl_month m ON m.id=p.month_id LEFT JOIN taxonomy t ON t.tid=p.company_id WHERE p.checked=1 AND p.approved=0 GROUP BY p.year,p.month_id,p.company_id ORDER BY t.tid,p.year,p.month_id")->result();
       }else if($userName =='ac-admin') { 
          $data['checking_notifications'] = $this->db->query("SELECT count(p.id) as pending_chacking,p.company_id,p.month_id,p.year,m.month_name,p.year,t.name as company_name FROM tbl_payroll p LEFT JOIN tbl_month m ON m.id=p.month_id LEFT JOIN taxonomy t ON t.tid=p.company_id WHERE p.status!=0 AND p.checked=0 GROUP BY p.year,p.month_id,p.company_id ORDER BY t.tid,p.year,p.month_id")->result();
          //$cashDatabase = $this->load->database('cash_database',TRUE);
         // $data['iou_first_approval_notifications'] =  $cashDatabase->query("SELECT count(id) as pending_iou FROM tbl_iou  WHERE first_approval=0")->result();
          
       }else if($userName == 'adminhr' || $userName == 'sajeeb'){
           $this->updateProvisionData();
           $data['braches'] = $this->db->query("SELECT id,name as branch_name FROM taxonomy WHERE parents_term=11 AND status=1")->result();
           $data['departments'] = $this->db->query("SELECT id,name as department_name FROM taxonomy WHERE vid=22 AND status=1")->result();
		   $data['total_employee']=$this->db->query("SELECT COUNT(id) as total_employee FROM search_field_emp WHERE type_of_employee NOT IN (153,473)")->row('total_employee');
		   $data['total_present']=$this->db->query("SELECT COUNT(DISTINCT content_id) as total_present FROM emp_attendance WHERE str_to_date(attendance_date, '%d-%m-%Y')=CURDATE()")->row('total_present');
		   $data['dep_attendance_data'] = $this->db->query("
		   SELECT COUNT(DISTINCT EA.content_id) as totalPresent, T.name as DepartmentName 
           FROM emp_attendance EA
		   LEFT JOIN search_field_emp SFE ON SFE.content_id = EA.content_id
		   LEFT JOIN taxonomy T ON T.id = SFE.department_id 
           WHERE str_to_date(EA.attendance_date, '%d-%m-%Y')=CURDATE() 
           GROUP BY SFE.department_id ORDER BY totalPresent DESC")->result();
		   $data['division_attendance_data'] = $this->db->query("
		   SELECT 
                T.name AS DivisionName,
                (SELECT COUNT(DISTINCT content_id) AS TotalEmployee FROM search_field_emp WHERE emp_department=T.id) AS TotalEmployee,
                (SELECT COUNT(DISTINCT emp_attendance.content_id) AS TotalPresentToday FROM emp_attendance LEFT JOIN search_field_emp ON search_field_emp.content_id=emp_attendance.content_id WHERE search_field_emp.emp_department=T.id AND STR_TO_DATE(attendance_date, '%d-%m-%Y')=CURDATE()) AS TotalPresentToday
                FROM taxonomy AS T WHERE T.parents_term=11 AND T.status=1")->result();
		   
		   $data['emp_attendance_data'] = $this->db->query("
		   SELECT COUNT(DISTINCT EA.attendance_date) as totalPresent, SFE.emp_name as EmployeeName,SFE.emp_id as EmployeeID FROM emp_attendance EA
		   LEFT JOIN search_field_emp SFE ON SFE.content_id = EA.content_id
		   WHERE str_to_date(EA.attendance_date, '%d-%m-%Y') BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() 
		   GROUP BY EA.content_id
		   ORDER BY totalPresent DESC")->result();
		   
		   #dd($this->db->last_query());
           //$this->getExpProvisionEmpFromJobHistory();
       }
	   if($this->session->userdata('user_type')=='employee'){
		   redirect('employee-dashboard');
	   }
        $this->load->view('dashboard',$data);
        // absent time // count time

        // $tstamp = strtotime('13-08-2015');
        // print $dated_day_name=date("d",$tstamp);
    }
    
    public function employeeDashboard(){
        $year=date('Y');
        $month=date('m');
        $emp_atten_date="01-01-$year";
        $data['content_id'] = $this->session->userdata('content_id');
        $content_id = $data['content_id'];
        $previous_carry_forward_leave_balance = $this->emp_leave_model->getPreviousCarryForwardLeaveBalance($year,$content_id);
       
        $data['previous_carry_forward_leave_balance'] = $previous_carry_forward_leave_balance;
        
        $data['current_year_total_leave'] = $this->emp_leave_model->getCurrentYearTotalLeave($year, $content_id);
        $report_year = $year;
        $report_month = $month;
        $report_date = "$report_year-$report_month-01";
        $data['this_year_earn_leave'] = $this->db->query("SELECT total_days as TOTAL FROM emp_yearly_leave_cat_history WHERE content_id=$content_id AND leave_type=864 
            AND ((start_year<='$report_date' AND end_year='0000-00-00') OR ('$report_date' BETWEEN start_year AND end_year))")->row('TOTAL');

        $data['emp_total_leave'] = $this->emp_yearly_leave_history_model->getemp_yearlyleave_historybydate($content_id, $emp_atten_date); 
        $allleavetype_vid = 16;
        $data['allleavetype'] = $this->taxonomy->getTaxonomyByvid($allleavetype_vid);  
        $this->load->view('employee-dashboard',$data);
    }

    public function employeeLeaveApplication(){
        $id = $this->uri->segment(2);
        if($id){
            $data['edit_info'] = $this->emp_leave_model->getLeaveByLeaveId($id);
            //        print_r($data['edit_info']);
//        exit;
        }
        $allleavetype_vid = 16;
        $contentId = $this->session->userdata('content_id');
        $currentYear = date("Y"); 
        $result = $this->emp_leave_model->getEmpPaidLeave($contentId,$currentYear);
        if($result){            
            $data['paid_leave_availed'] = $result;
        }else{
            $data['paid_leave_availed'] =0;
        }
        $data['allleavetype'] = $this->taxonomy->getTaxonomyByvid($allleavetype_vid); 
         $this->load->view('leave/employee-leave-application',$data);
    }
    function getExpProvisionEmpFromJobHistory(){
        // Check provision period expaired employee ----------------------------------------------------------------
        date_default_timezone_set('Asia/Dhaka');
        $serverTime = time();
        $todayDate = date("d-m-Y", $serverTime);
        $res = $this->db->select("sfe.emp_name,sfe.emp_id,sfe.emp_division,ep.provision_date_to as provision_end_date,sfe.content_id,sfe.type_of_employee ")
                ->from("emp_job_history AS ejh")                
                ->join("search_field_emp AS sfe", "sfe.content_id=ejh.content_id ")
                ->join("emp_provision AS ep", "sfe.content_id=ep.content_id ")
               // ->join("taxonomy AS company", "company.tid=sfe.emp_division")
                ->where("ejh.emp_type_tid", 155)
                ->where("ejh.end_date", '')
                ->where("STR_TO_DATE(ep.provision_date_to, '%d-%m-%Y') < STR_TO_DATE('$todayDate', '%d-%m-%Y') ")
                ->get();
       // $res = $this->db->select('*')->from('search_field_emp')->get();
        $provitionToPermanent = $res->result_array();
     // print_r($provitionToPermanent);
     // exit;
    }
    public function globalsettings(){
        $user_type = $this->session->userdata('user_type'); 
        if($this->input->post()){
            $this->users_model->deleteglobalsettings();
        foreach ($this->input->post("task_type") as $task_type => $taskvalue) {
             if ($taskvalue) {
                $params_settings = array(
                    'id'        => '',
                    'action'    => $task_type,
                    'status'    => $taskvalue,
                );
                $this->db->insert("globalsettings", $params_settings);
            }
    }
        $this->session->set_userdata('add_status', 'Data Updated');
        }             
        $data['error'] = "";
        $data['msg'] = $this->session->userdata('add_status');   
        $this->load->view('globalsettings', $data);
        $this->session->set_userdata('add_status', '');
    } 
public function getprovisionalemp(){
    header('Content-type: application/json');
    $params = array(
    'type_of_employee'  =>  "1",
    );    
    $params2 = array(
    'insertflag'  =>  "1",
    );     
    $provision_employee=$this->emp_provision_model->getprovisionalemp();
    if($provision_employee){
    foreach ($provision_employee as $single_employee) {
    $toupdate_content_id=$single_employee['content_id'];
    $update_con=array('content_id' => $toupdate_content_id);
    $this->search_field_emp_model->updSearch_field_contenttbl($params, $update_con);
    $this->emp_provision_model->updEmp_provisiontbl($params2, $update_con);
    }        
    }
//        echo json_encode($this->session->userdata('activeid'));
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
                //->where("ep.insertflag", 0)
                ->where("STR_TO_DATE(ep.provision_date_to, '%d-%m-%Y') < STR_TO_DATE('$todayDate', '%d-%m-%Y') ")
                ->get();
       // $res = $this->db->select('*')->from('search_field_emp')->get();
        $provitionToPermanent = $res->result_array();
    //  print_r($provitionToPermanent);
    //  exit;
        $count = count($provitionToPermanent);
        
        // Update provision to permanent ------------------------------------------------------------------------------
        if ($count>0) {        
            foreach ($provitionToPermanent as $singlePermanent) {
                $this->updateEmployeeProvisionPeriod($singlePermanent['content_id'], $singlePermanent['provision_end_date']);
            }
            $this->session->set_flashdata('success', "Software updated!");
        }else{
           # $this->session->set_flashdata('success', "Welcome to AAG HRMS!");
        }
       // redirect('dashboard', 'refresh');
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
                    'created_by' => 6
                );
                $insertJobHostory = $this->db->insert("emp_job_history", $insertData);
            }
        
        if ($insertJobHostory) {
            $condition = array('content_id' => $contentId);
            $updateProvisionData = array(
                'insertflag' => 1,
                'updated' => getCurrentDateTime(),
                'updated_by' => 6
            );
            $this->emp_provision_model->updEmp_provisiontbl($updateProvisionData, $condition);
            $empUpdateData = array(
                'type_of_employee' => '1',
                'updated_at' => getCurrentDateTime(),
                'updated_by' => 6
            );
            $this->search_field_emp_model->updSearch_field_contenttbl($empUpdateData, $condition);
        }
        }
    }
    
    public function employeeMovementOrderForm(){
         $id = $this->uri->segment(2);
        if($id){
            $data['edit_info'] = $this->emp_informed_model->getemp_informedbyid($id);
            //        print_r($data['edit_info']);
//        exit;
        }
             $this->load->view('movement-order/employee-movement-order-form',$data);
    }
}

?>