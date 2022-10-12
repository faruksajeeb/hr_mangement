<?php
/**
 * Description of ChallanController
 *
 * @author Mohammad Omar Faruk Sajeeb Mridha
 * Created at : 29 December 2021
 */
class ReportController extends CI_Controller{
    function __construct() {
		 error_reporting(0);
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        #$this->load->model("challan_model");
    }
	function today_present(){
		$data['title'] = 'Report';
		$data['today_present_data'] = $this->db->query("SELECT DISTINCT A.content_id,A.attendance_date,A.login_time,A.logout_time,SFE.emp_name,SFE.emp_id 
		FROM emp_attendance A
			LEFT JOIN search_field_emp SFE ON SFE.content_id=A.content_id 
			WHERE str_to_date(A.attendance_date, '%d-%m-%Y')=CURDATE() GROUP BY A.content_id")->result();
		 $this->load->view('reports/attendance/daily_present',$data);
	}
	function today_absent(){
		$data['title'] = 'Report';
		$data['today_absent_data'] = $this->db->query("
		SELECT emp_name, emp_id FROM search_field_emp WHERE content_id NOT IN(
		SELECT DISTINCT content_id
		FROM emp_attendance WHERE str_to_date(attendance_date, '%d-%m-%Y')=CURDATE() GROUP BY content_id) 
		AND type_of_employee NOT IN (153,473) 
		ORDER BY emp_name
		")->result();
		 $this->load->view('reports/attendance/daily_absent',$data);
	}
}