<?php

class Search_field_emp_model extends CI_Model {

    function getallemployee() {
        return $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153,473) AND status=1 ORDER BY emp_name")->result_array();
        /*
          $sql="SELECT * FROM search_field_emp  WHERE type_of_employee NOT IN(153,473) order by emp_id";
          $query_result = $this->db->query($sql);
          $result = $query_result->result();
          return $result;
         */
    }
    function getAllEmployees() {
        return $this->db->query("SELECT * FROM search_field_emp ORDER BY emp_id")->result_array();       
    }

    function getallemployeeorderdivision() {
        return $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153,473) ORDER BY emp_division")->result_array();
    }

    function getall_left_employeeorderdivision() {
        return $this->db->query("select * from search_field_emp WHERE type_of_employee  IN(153,473) order by emp_division")->result_array();
    }

    function getall_left_employee() {
        return $this->db->query("select * from search_field_emp WHERE type_of_employee IN(153,473) order by emp_id")->result_array();
    }

    function getallsearch_table_contentByid($content_id) {
        if ($content_id) {
            return $this->db->query("select sfe.*,t.name as post_name FROM search_field_emp sfe "
                            . "LEFT JOIN taxonomy t ON t.tid=sfe.emp_post_id WHERE sfe.content_id =$content_id")->row_array();
        }
    }
    function getEmployeeInfoById($content_id){
        if ($content_id) {
            $query = $this->db->select('sfe.*,grade.grade_name AS grade_name,company.name AS company_name,division.name AS division_name,department.name AS department_name,'
                    . 'designation.name AS designation_name,typeOfEmployee.name AS type_of_emp_name,'
                    . 'meritalStatus.name AS merital_status_name,relegion.name AS religion_name,district.name AS district_name,')
                    ->from('search_field_emp as sfe')
                    ->join('tbl_salary_grades as grade', 'grade.id = sfe.grade', 'left')
                    ->join('taxonomy as company', 'company.tid = sfe.emp_division', 'left')
                    ->join('taxonomy as division', 'division.tid = sfe.emp_department', 'left')
                    ->join('taxonomy as department', 'department.tid = sfe.department_id', 'left')
                    ->join('taxonomy as designation', 'designation.tid = sfe.emp_post_id', 'left')
                    ->join('taxonomy as typeOfEmployee', 'typeOfEmployee.tid = sfe.type_of_employee', 'left')
                    ->join('taxonomy as meritalStatus', 'meritalStatus.tid = sfe.marital_status', 'left')
                    ->join('taxonomy as relegion', 'relegion.tid = sfe.religion', 'left')
                    ->join('taxonomy as district', 'district.tid = sfe.distict', 'left')
                    ->where('sfe.content_id',$content_id)
                    ->get();
            return $query->row();
        }
    }

    function get_emp_info_by_contentid($content_id, $lastdateofattendance) {
        if ($content_id) {

            $empatt_end_date_arr = explode("-", $lastdateofattendance);

            $emp_att_end_date = $empatt_end_date_arr[2] . "-" . $empatt_end_date_arr[1] . "-" . $empatt_end_date_arr[0];
            return $this->db->query("select sfe.*,t.name as post_name,td.keywords as division_name,"
//                    . "tdp.name as department_name, "
                            . "(SELECT SUM(leave_total_day) FROM emp_leave WHERE content_id='$content_id' AND leave_year='$empatt_end_date_arr[2]' "
                    . "AND  str_to_date(leave_end_date, '%d-%m-%Y')  <='$emp_att_end_date' "
                    // 336 = leave without pay
                    . "AND leave_type !='336' AND approve_status='approved' order by id DESC) AS Totalleave, "
                            . "(SELECT work_starting_time FROM emp_shift_history WHERE content_id ='$content_id' AND str_to_date(start_date, '%d-%m-%Y') <='$emp_att_end_date' ORDER BY ID DESC LIMIT 1) AS work_starting_time, "
                            . "(SELECT work_ending_time FROM emp_shift_history WHERE content_id ='$content_id' AND str_to_date(start_date, '%d-%m-%Y') <='$emp_att_end_date' ORDER BY ID DESC LIMIT 1) AS work_ending_time "
                            . "FROM search_field_emp sfe "
                            . "LEFT JOIN taxonomy t ON t.tid=sfe.emp_post_id "
                            . "LEFT JOIN taxonomy td ON td.tid=sfe.emp_division "
//                            . "LEFT JOIN taxonomy tdp ON tdp.tid=sfe.emp_department "
                            . "WHERE sfe.content_id =$content_id")->row_array();
        }
    }

    function getallsearch_table_contentByids($content_ids) {
        if ($content_ids) {
            return $this->db->query("SELECT * FROM search_field_emp WHERE content_id IN ($content_ids) ORDER BY emp_name ")->result_array();
        }
    }

    function getallemployeebydivision($division_tid) {
      
            if($division_tid=='all'){
                $query = $this->db->select('sfe.*,texo.name,es.gross_salary')
                        ->from('search_field_emp sfe')
                        ->join('emp_salary es', 'sfe.content_id=es.content_id AND es.id =(SELECT MAX(id) FROM emp_salary z  WHERE z.content_id = es.content_id)', 'LEFT')
                        ->join('taxonomy AS texo', 'sfe.emp_post_id = texo.tid', 'LEFT')                       
                        ->where("sfe.content_id !='0' AND sfe.type_of_employee !='153' AND sfe.type_of_employee !='473' AND sfe.status=1")
                       // ->where('sfe.publication_status', 1)
//                    ->limit($limit, $offset)
                        //->order_by("sfe.emp_id + 0", "ASC")
                        ->order_by("sfe.emp_id", "ASC")
                        ->get();
            }else{
                $query = $this->db->select('sfe.*,texo.name,es.gross_salary')
                        ->from('search_field_emp sfe')
                        ->join('emp_salary es', 'sfe.content_id=es.content_id AND es.id =(SELECT MAX(id) FROM emp_salary z  WHERE z.content_id = es.content_id)', 'LEFT')
                        ->join('taxonomy AS texo', 'sfe.emp_post_id = texo.tid', 'LEFT')
                        ->where("sfe.emp_division", $division_tid)
                        ->where("sfe.content_id !='0' AND sfe.type_of_employee !='153' AND sfe.type_of_employee !='473' AND sfe.status=1")
                       // ->where('sfe.publication_status', 1)
//                    ->limit($limit, $offset)
                        //->order_by("sfe.emp_id + 0", "ASC")
                        ->order_by("sfe.emp_id", "ASC")
                        ->get();
            }
                

        return $query->result_array();
        //$test=$this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153,473) AND emp_division ='$division_tid' order by emp_id")->result_array();
    }
    
    function getAllEmployeeByDivisionAndDepartment($division_tid,$department_id) {          
       $query = $this->db->select('sfe.*,texo.name')
                        ->from('search_field_emp sfe')
                        ->join('emp_salary es', 'sfe.content_id=es.content_id AND es.id =(SELECT MAX(id) FROM emp_salary z  WHERE z.content_id = es.content_id)', 'LEFT')
                        ->join('taxonomy AS texo', 'sfe.emp_post_id = texo.tid', 'LEFT')
                        ->where("sfe.emp_division", $division_tid)
                        ->where("sfe.emp_department", $department_id)
                        ->where("sfe.content_id !='0' AND sfe.type_of_employee !='153' AND sfe.type_of_employee !='473' AND sfe.status=1")
                      //  ->where('sfe.publication_status', 1)
    //                    ->limit($limit, $offset)
                        //->order_by("sfe.emp_id + 0", "ASC")
                        ->order_by("sfe.emp_id", "ASC")
                        ->get();
       //$query = $this->db->select('*')->from('search_field_emp')->get();
        return $query->result_array();
    }
    
     function getEmployeeByDivision($division_tid) {
           $query = $this->db->select('DISTINCT(ejh.content_id),sfe.content_id,sfe.emp_id,sfe.emp_name,ejh.division_tid,ejh.department_tid')
                             ->from('emp_job_history AS ejh')
                             ->join('search_field_emp AS sfe','sfe.content_id = ejh.content_id', 'LEFT')
                             ->where('ejh.division_tid', $division_tid)
                             ->order_by("sfe.emp_name", "ASC")
                             ->get();
        return $query->result_array();
    }
       function getEmployeeByDivisionAndDepartment($division_tid,$department_tid) {
           $query = $this->db->select('DISTINCT(ejh.content_id),sfe.content_id,sfe.emp_id,sfe.emp_name,ejh.division_tid,ejh.department_tid')
                             ->from('emp_job_history AS ejh')
                             ->join('search_field_emp AS sfe','sfe.content_id = ejh.content_id', 'LEFT')
                             ->where('ejh.division_tid', $division_tid)
                             ->where('ejh.department_tid', $department_tid)
                             ->order_by("sfe.emp_name", "ASC")
                             ->get();
        return $query->result_array();
    }
    
 
    function get_all_employee_info_by_division($emp_division, $startDate, $endDate) {
        $sql = "SELECT 
        search_field_emp.content_id, 
        search_field_emp.emp_id,
        search_field_emp.emp_name,
        taxonomy.name AS designation,
        CASE 
            WHEN emp_shift_history.attendance_required='Required'
                THEN (SELECT COUNT(
            CASE 
                WHEN 
                    emp_attendance.login_time<emp_shift_history.emp_latecount_time 
                    AND emp_attendance.logout_time>=emp_shift_history.emp_earlycount_time	     
                    THEN 1 	
                END
                ) 
                FROM emp_attendance WHERE emp_attendance.content_id=search_field_emp.content_id 
                    AND STR_TO_DATE(emp_attendance.attendance_date, '%d-%m-%Y') 
                    BETWEEN '$startDate' AND '$endDate' 
            )
     END  AS total_present,

        CASE 
        WHEN emp_shift_history.attendance_required='Required'
        THEN (SELECT COUNT(       
                        CASE        
                            WHEN emp_informed.presence_status IS NULL
                                AND emp_attendance.login_time>=emp_shift_history.emp_latecount_time 
                                AND emp_attendance.logout_time>=emp_shift_history.emp_earlycount_time 
                            THEN 1	
                        END
                )FROM emp_attendance
                LEFT JOIN emp_informed  ON  emp_attendance.content_id=emp_informed.content_id AND
                        emp_attendance.attendance_date=emp_informed.attendance_date
                WHERE emp_attendance.content_id=search_field_emp.content_id 
            AND STR_TO_DATE(emp_attendance.attendance_date, '%d-%m-%Y') BETWEEN '$startDate' AND '$endDate' )
        END AS total_latein

        ,
        CASE 
        WHEN emp_shift_history.logout_required='Required'
        THEN (SELECT  COUNT(CASE
            WHEN  emp_informed.presence_status IS NULL
                    AND emp_attendance.login_time<=emp_shift_history.emp_latecount_time 
                    AND (emp_attendance.logout_time IS NULL OR emp_attendance.logout_time<=emp_shift_history.emp_earlycount_time )
            THEN 1	
            END) FROM emp_attendance 
                LEFT JOIN emp_informed  ON  emp_attendance.content_id=emp_informed.content_id AND
                        emp_attendance.attendance_date=emp_informed.attendance_date
                WHERE emp_attendance.content_id=search_field_emp.content_id 
            AND STR_TO_DATE(emp_attendance.attendance_date, '%d-%m-%Y') BETWEEN '$startDate' AND '$endDate' ) 
        END AS total_earlyout,
        CASE 
        WHEN emp_shift_history.attendance_required='Required' AND emp_shift_history.logout_required='Required' 
        THEN (SELECT COUNT(CASE
            WHEN emp_informed.presence_status IS NULL
                    AND emp_attendance.login_time>=emp_shift_history.emp_latecount_time	     
                AND (emp_attendance.logout_time IS NULL OR emp_attendance.logout_time<=emp_shift_history.emp_earlycount_time )
            THEN 1	
            END) FROM emp_attendance 
                LEFT JOIN emp_informed  ON  emp_attendance.content_id=emp_informed.content_id AND
                        emp_attendance.attendance_date=emp_informed.attendance_date
                WHERE emp_attendance.content_id=search_field_emp.content_id 
            AND STR_TO_DATE(emp_attendance.attendance_date, '%d-%m-%Y') BETWEEN '$startDate' AND '$endDate' )
        END AS total_late_early,
            
        (SELECT COUNT(CASE
            WHEN emp_informed.presence_status='P' AND	     
                (emp_informed.logout_status='P' OR emp_informed.logout_status='')
            THEN 1 
            END)  FROM emp_informed 
            WHERE emp_informed.content_id=search_field_emp.content_id 
            AND STR_TO_DATE(emp_informed.attendance_date, '%d-%m-%Y') 
            BETWEEN '$startDate' AND '$endDate' GROUP BY content_id
            ) AS total_informed_present,	

        (SELECT COUNT(CASE
            WHEN emp_informed.presence_status='L' AND	     
                (emp_informed.logout_status='P' OR emp_informed.logout_status='')
            THEN 1	
            END) FROM emp_informed WHERE emp_informed.content_id=search_field_emp.content_id 
            AND STR_TO_DATE(emp_informed.attendance_date, '%d-%m-%Y') 
            BETWEEN '$startDate' AND '$endDate' GROUP BY content_id
            ) AS total_informed_latein,
        (SELECT COUNT(CASE
            WHEN emp_informed.presence_status='P' AND	     
                emp_informed.logout_status='E'
            THEN 1	
            END) FROM emp_informed WHERE emp_informed.content_id=search_field_emp.content_id 
            AND STR_TO_DATE(emp_informed.attendance_date, '%d-%m-%Y') 
            BETWEEN '$startDate' AND '$endDate' GROUP BY content_id
            ) AS total_informed_earlyout,
        (SELECT COUNT(CASE
            WHEN emp_informed.presence_status='L' AND	     
                emp_informed.logout_status='E'
            THEN 1	
            END) FROM emp_informed WHERE emp_informed.content_id=search_field_emp.content_id 
            AND STR_TO_DATE(emp_informed.attendance_date, '%d-%m-%Y') 
            BETWEEN '$startDate' AND '$endDate' GROUP BY content_id
            ) AS total_informed_latein_earlyout,
        (SELECT COUNT(CASE
            WHEN emp_informed.presence_status='A' THEN 1	
            END) FROM emp_informed WHERE emp_informed.content_id=search_field_emp.content_id 
            AND STR_TO_DATE(emp_informed.attendance_date, '%d-%m-%Y') 
            BETWEEN '$startDate' AND '$endDate' GROUP BY content_id
            ) AS total_informed_absent,
        (SELECT COUNT(CASE
                WHEN
                    emp_informed.reason='personal'            
                    THEN 1
            WHEN
                    emp_informed.reason=''
                    AND (emp_informed.remarks='Personal' OR emp_informed.remarks='sick')
                    /* AND MATCH(emp_informed.remarks) AGAINST('Personal')  #FullText index Support on MySQL version 5.6 to above*/ 
                    THEN 1 
                END) FROM emp_informed WHERE emp_informed.content_id=search_field_emp.content_id 
            AND STR_TO_DATE(emp_informed.attendance_date, '%d-%m-%Y') 
            BETWEEN '$startDate' AND '$endDate' GROUP BY content_id
            ) AS total_informed_personal,
        (SELECT SUM(emp_leave.leave_total_day) 
            FROM emp_leave WHERE  search_field_emp.content_id=emp_leave.content_id AND emp_leave.pay_status='payable'
            AND STR_TO_DATE(emp_leave.leave_start_date, '%d-%m-%Y')>='$startDate' 
            AND STR_TO_DATE(emp_leave.leave_end_date, '%d-%m-%Y')<='$endDate'
        )AS total_leave_with_pay,
        (SELECT SUM(emp_leave.leave_total_day) 
            FROM emp_leave WHERE  search_field_emp.content_id=emp_leave.content_id AND emp_leave.pay_status='not_payable' 
            AND STR_TO_DATE(emp_leave.leave_start_date, '%d-%m-%Y')>='$startDate' 
            AND STR_TO_DATE(emp_leave.leave_end_date, '%d-%m-%Y')<='$endDate'
        )AS total_leave_without_pay,
        (SELECT SUM(emp_yearlyholiday.holiday_total_day)
            FROM emp_yearlyholiday WHERE emp_yearlyholiday.holiday_for_division=$emp_division
            AND STR_TO_DATE(emp_yearlyholiday.holiday_start_date, '%d-%m-%Y')>='$startDate' 
            AND STR_TO_DATE(emp_yearlyholiday.holiday_end_date, '%d-%m-%Y')<='$endDate'
            ) AS total_yearly_holiday,
        (SELECT SUM(emp_yearlyholiday.holiday_total_day)
            FROM emp_yearlyholiday WHERE emp_yearlyholiday.holiday_for_division='all'
            AND STR_TO_DATE(emp_yearlyholiday.holiday_start_date, '%d-%m-%Y')>='$startDate' 
            AND STR_TO_DATE(emp_yearlyholiday.holiday_end_date, '%d-%m-%Y')<='$endDate'
            ) AS total_yearly_holiday_all
        FROM search_field_emp
            LEFT JOIN taxonomy ON search_field_emp.emp_post_id=taxonomy.tid 
            LEFT JOIN emp_shift_history ON search_field_emp.content_id=emp_shift_history.content_id
        WHERE
            search_field_emp.emp_division=$emp_division 
            AND search_field_emp.type_of_employee NOT IN(153,473)	
            AND emp_shift_history.id IN (SELECT MAX(id) FROM emp_shift_history GROUP BY content_id ORDER BY id DESC)	
        GROUP BY search_field_emp.content_id 
        ORDER BY search_field_emp.emp_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;

        //AND search_field_emp.content_id IN (286,275,375,379)
        //$test=$this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153,473) AND emp_division ='$division_tid' order by emp_id")->result_array();
    }

    function getallemployeebydivisionandids($division_tid, $leaved_emp_ids) {

        return $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153,473) AND emp_division ='$division_tid' AND content_id IN ($leaved_emp_ids) ORDER BY emp_id")->result_array();
    }

    function getallemployeebydepartment($department_tid) {
        return $this->db->query("select * from search_field_emp WHERE type_of_employee NOT IN(153,473) AND emp_department ='$department_tid' order by emp_id")->result_array();
    }

    function getallsearch_table_contentByempcode($emp_code) {
        if ($emp_code) {
            return $this->db->query("select * from search_field_emp WHERE emp_id =$emp_code")->row_array();
        }
    }

    public function updSearch_field_contenttbl($data = array(), $where = array()) {
        if ($data && $where) {
            $this->db->where($where);
            $this->db->update('search_field_emp', $data);
            return true;
        }
    }

    public function getallAge() {
        return $this->db->query("select DISTINCT age from search_field_emp order by age ASC")->result_array();
    }

    public function search_record_count($searchpage) {
        $user_id = $this->session->userdata('user_id');
        $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
        $search_query_result = $this->db->query($search_query)->row_array();
        $abb = $search_query_result['search_query'];
        if ($abb) {
            $query = $this->db->select('*')
                    ->from('search_field_emp')
                    ->where($abb, NULL, FALSE)
                    ->get();
            $total_row = $query->result_array();
            return count($total_row);
        } else {
            return 0;
        }
    }

    public function getsearchQuery($searchpage) {
        if ($searchpage) {
            $user_id = $this->session->userdata('user_id');
            $search_query = "SELECT * FROM search_query "
                    . " WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
            return $this->db->query($search_query)->row_array();
        }
    }

    function get_all_databysort($searchpage) {
        $limit = 50000;
        $offset = 0;
        $user_id = $this->session->userdata('user_id');
        $search_query = "SELECT * FROM search_query "
                . "WHERE user_id='$user_id' AND search_page='$searchpage' "
                . "order by id DESC limit 1";
        $search_query_result = $this->db->query($search_query)->row_array();
        $abb = $search_query_result['search_query'];
        if ($abb) {
            $user_type = $this->session->userdata('user_type');
            if ($user_type == 7) {
                $query = $this->db->select('*')
                        ->from('search_field_emp')
                        ->where($abb, NULL, FALSE)
                        ->limit($limit, $offset)
                        ->order_by("id", "DESC")
                        ->get();
            } else {
                $query = $this->db->select('*')
                        ->from('search_field_emp')
                        ->where($abb, NULL, FALSE)
                        ->limit($limit, $offset)
                        ->order_by("id", "DESC")
                        ->get();
            }
        }


        if (count($query) > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_all_data($limit = NULL, $offset = NULL, $searchpage) {
		$limit =50;
		$offset = 0;
        $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type');
        $search_query = "SELECT * FROM search_query "
                . "WHERE user_id='$user_id' AND search_page='$searchpage'  "
                . "order by id DESC limit 1";
        $search_query_result = $this->db->query($search_query)->row_array();
        $abb = $search_query_result['search_query'];
        $sortby = $search_query_result['table_view'];
        if (!$sortby) {
            $sortby = "grade";
        }
        if ($abb) {
            $user_type = $this->session->userdata('user_type');
            if ($user_type == 7) {
                $query = $this->db->select('sfe.*,grade.grade_name,es.id as emp_salary_id,es.mba,es.gross_salary,'
                                . 'esd.provident_fund_deduction,esd.other_deduction,esd.total_deduction,'
                                . 'taxonomy.name as bank_name,pay_math.branch_name,pay_math.bank_account_no,taxonomy2.name as pay_type_name')
                        ->from('search_field_emp sfe')
                        ->join('emp_salary es', 'sfe.content_id=es.content_id AND es.id =(SELECT MAX(id) FROM emp_salary z  WHERE z.content_id = es.content_id)', 'LEFT')
                        ->join('emp_salary_deduction esd', 'sfe.content_id=esd.content_id AND esd.id =(SELECT MAX(id) FROM emp_salary_deduction zesd  WHERE zesd.content_id = esd.content_id)', 'LEFT')
                        ->join('emp_payment_method pay_math', 'sfe.content_id=pay_math.content_id', 'LEFT')
                        ->join('taxonomy taxonomy', 'taxonomy.id=pay_math.bank_id', 'LEFT')
                        ->join('tbl_salary_grades grade', 'grade.id=sfe.grade', 'LEFT')
                        ->join('taxonomy taxonomy2', 'taxonomy2.id=pay_math.pay_type_id', 'LEFT')
                        ->where($abb, NULL, FALSE)
//                        ->where("sfe.content_id !='0' AND sfe.type_of_employee !='153' AND sfe.type_of_employee !='473'")
                       // ->where('sfe.publication_status', 1)
//                    ->limit($limit, $offset)
                        ->order_by("sfe." . $sortby . "", "ASC")
                        ->get();
            } else {
                $query = $this->db->select('sfe.*,grade.grade_name,es.id,es.mba,es.gross_salary,'
                                . 'esd.provident_fund_deduction,esd.other_deduction,esd.total_deduction,'
                                . 'taxonomy.name as bank_name,pay_math.branch_name,pay_math.bank_account_no,taxonomy2.name as pay_type_name')
                        ->from('search_field_emp sfe')
                        ->join('emp_salary es', 'sfe.content_id=es.content_id AND es.id =(SELECT MAX(id) FROM emp_salary z  WHERE z.content_id = es.content_id)', 'LEFT')
                        ->join('emp_salary_deduction esd', 'sfe.content_id=esd.content_id AND esd.id =(SELECT MAX(id) FROM emp_salary_deduction zesd  WHERE zesd.content_id = esd.content_id)', 'LEFT')
                        ->join('emp_payment_method pay_math', 'sfe.content_id=pay_math.content_id', 'LEFT')
                        ->join('taxonomy taxonomy', 'taxonomy.id=pay_math.bank_id', 'LEFT')
                        ->join('tbl_salary_grades grade', 'grade.id=sfe.grade', 'LEFT')
                        ->join('taxonomy taxonomy2', 'taxonomy2.id=pay_math.pay_type_id', 'LEFT')
                        ->where($abb, NULL, FALSE)
//                        ->where("sfe.content_id !='0' AND sfe.type_of_employee !='153' AND sfe.type_of_employee !='473'")
                       // ->where('sfe.publication_status', 1)
                    ->limit($limit, $offset)
                        ->order_by("sfe." . $sortby . "", "ASC")
                        ->get();
            }
        }

        if (count($query) > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_all_trash_data($limit = NULL, $offset = NULL, $searchpage) {
        $user_id = $this->session->userdata('user_id');
        $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage'  order by id DESC limit 1";
        $search_query_result = $this->db->query($search_query)->row_array();
        $abb = $search_query_result['search_query'];
        $sortby = $search_query_result['table_view'];
        if (!$sortby) {
            $sortby = "grade";
        }
        if ($abb) {
            $user_type = $this->session->userdata('user_type');
            if ($user_type == 7) {
                $query = $this->db->select('*')
                        ->from('search_field_emp')
                        ->where($abb, NULL, FALSE)
                        ->where('publication_status', 0)
                        ->limit($limit, $offset)
                        ->order_by("" . $sortby . "", "ASC")
                        ->get();
            } else {
                $query = $this->db->select('*')
                        ->from('search_field_emp')
                        ->where($abb, NULL, FALSE)
                        ->where('publication_status', 0)
                        ->limit($limit, $offset)
                        ->order_by("" . $sortby . "", "ASC")
                        ->get();
            }
        }

        if (count($query) > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_all_search_emp($searchpage) {
        $user_id = $this->session->userdata('user_id');
        $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
        $search_query_result = $this->db->query($search_query)->row_array();
        $abb = $search_query_result['search_query'];
        $sortby = $search_query_result['table_view'];
        if (!$sortby) {
            $sortby = "emp_id";
        }
        if ($abb) {
            $query = $this->db->select('sfe.*,grade.grade_name AS grade_name,division.name AS division_name,department.name AS department_name,'
                    . 'designation.name AS designation_name,typeOfEmployee.name AS type_of_emp_name,'
                    . 'meritalStatus.name AS merital_status_name,relegion.name AS religion_name,district.name AS district_name,epm.bank_account_no')
                    ->from('search_field_emp as sfe')
                    ->join('tbl_salary_grades as grade', 'grade.id = sfe.grade', 'left')
                    ->join('emp_payment_method as epm', 'sfe.content_id = epm.content_id', 'left')
                    ->join('taxonomy as division', 'division.tid = sfe.emp_division', 'left')
                    ->join('taxonomy as department', 'department.tid = sfe.emp_department', 'left')
                    ->join('taxonomy as designation', 'designation.tid = sfe.emp_post_id', 'left')
                    ->join('taxonomy as typeOfEmployee', 'typeOfEmployee.tid = sfe.type_of_employee', 'left')
                    ->join('taxonomy as meritalStatus', 'meritalStatus.tid = sfe.marital_status', 'left')
                    ->join('taxonomy as relegion', 'relegion.tid = sfe.religion', 'left')
                    ->join('taxonomy as district', 'district.tid = sfe.distict', 'left')
                    ->where($abb, NULL, FALSE)
//                    ->order_by("sfe." . $sortby . " + 0", "ASC")
                      ->order_by("" . $sortby . "", "ASC")
                    ->get();
        }

        if (count($query) > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_all_left_employee() {

        $sql = "SELECT sfe.content_id,sfe.emp_id,sfe.emp_name,sfe.gender,sfe.status,tdiv.name AS division,tdes.name AS designation
            FROM search_field_emp AS sfe
            JOIN taxonomy AS tdiv ON sfe.emp_division=tdiv.tid
            JOIN taxonomy AS tdes ON sfe.emp_post_id=tdes.tid
            WHERE  sfe.type_of_employee=153 AND sfe.deletion_status=0 
        ";

        $query = $this->db->query($sql);

        $data['result'] = $query->result();
        $data['rows'] = $query->num_rows();

        return $data;
    }

    public function get_all_delete_employee() {

        $sql = "SELECT sfe.content_id,sfe.emp_id,sfe.emp_name,sfe.gender,sfe.status,tdiv.name AS division,tdes.name AS designation "
                . "FROM search_field_emp AS sfe,taxonomy AS tdiv,taxonomy AS tdes "
                . "WHERE sfe.emp_division=tdiv.tid "
                . "AND sfe.emp_post_id=tdes.tid "
                . "AND (sfe.type_of_employee=153 OR sfe.type_of_employee=473) "
                . "AND sfe.deletion_status=1 "
                . "ORDER BY sfe.emp_name ASC";
        $query = $this->db->query($sql);

        $data['result'] = $query->result();
        $data['rows'] = $query->num_rows();
        return $data;
    }

    public function get_all_tarminated_employee() {

        $sql = "SELECT sfe.content_id,sfe.emp_id,sfe.emp_name,sfe.gender,tdiv.name AS division,tdes.name AS designation,sfe.status "
                . "FROM search_field_emp AS sfe,taxonomy AS tdiv,taxonomy AS tdes "
                . "WHERE sfe.emp_division=tdiv.tid "
                . "AND sfe.emp_post_id=tdes.tid "
                . "AND sfe.type_of_employee=473 "
                . "AND sfe.deletion_status=0 ";
        $query = $this->db->query($sql);

        $data['result'] = $query->result();
        $data['rows'] = $query->num_rows();
        return $data;
    }

}

?>