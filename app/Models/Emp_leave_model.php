<?php

class Emp_leave_model extends CI_Model
{
    public function getLeaveByLeaveId($id)
    {
        return $this->db->query("SELECT * FROM emp_leave WHERE id=$id")->row();
    }
    public function getemp_leave($content_id, $leave_date)
    {
        if ($content_id && $leave_date) {
            return $this->db->query("select * from emp_leave WHERE content_id='$content_id' and leave_start_date='$leave_date' AND approve_status='approved' order by id DESC")->row_array();
        }
    }
    public function leaveByEmp($contentId)
    {
        if ($contentId) {
            $year = date('Y');
            return $this->db->query("SELECT el.*,t.name as leave_type_name FROM emp_leave as el LEFT JOIN taxonomy as t ON t.tid=el.leave_type WHERE el.content_id='$contentId' AND el.leave_year=$year ORDER BY el.id DESC")->result();
        }
    }

    public function allLeaveApplication()
    {
        $year = date('Y');
        return $this->db->query("SELECT el.*,t.name as leave_type_name,sfe.emp_name,company.keywords AS company_name,division.name AS division_name,department.name AS department_name,designation.name AS designation_name FROM emp_leave as el "
            . "LEFT JOIN taxonomy as t ON t.tid=el.leave_type "
            . "LEFT JOIN search_field_emp as sfe ON sfe.content_id=el.content_id "
            . "LEFT JOIN taxonomy as company ON company.tid = sfe.emp_division "
            . "LEFT JOIN taxonomy as division ON division.tid = sfe.emp_department "
            . "LEFT JOIN taxonomy as department ON department.tid = sfe.department_id "
            . "LEFT JOIN taxonomy as designation ON designation.tid = sfe.emp_post_id "
            . "WHERE el.leave_year=$year ORDER BY el.id DESC")->result();
    }
    public function pendingLeaveApplication()
    {
        $year = date('Y');
        return $this->db->query("SELECT el.*,t.name as leave_type_name,sfe.emp_name,company.keywords AS company_name,division.name AS division_name,department.name AS department_name,designation.name AS designation_name FROM emp_leave as el "
            . "LEFT JOIN taxonomy as t ON t.tid=el.leave_type "
            . "LEFT JOIN search_field_emp as sfe ON sfe.content_id=el.content_id "
            . "LEFT JOIN taxonomy as company ON company.tid = sfe.emp_division "
            . "LEFT JOIN taxonomy as division ON division.tid = sfe.emp_department "
            . "LEFT JOIN taxonomy as department ON department.tid = sfe.department_id "
            . "LEFT JOIN taxonomy as designation ON designation.tid = sfe.emp_post_id "
            . "WHERE el.leave_year=$year AND approve_status='pending' ORDER BY el.id DESC")->result();
    }
    public function allAdminLeaveApplication($content_ids)
    {
        $adminId = $this->session->userdata("user_id");
        $year = date('Y');
        return $this->db->query("SELECT el.*,t.name as leave_type_name,sfe.emp_name,sfe.emp_id,company.keywords AS company_name,division.name AS division_name,department.name AS department_name,designation.name AS designation_name FROM emp_leave as el "
            . "LEFT JOIN taxonomy as t ON t.tid=el.leave_type "
            . "LEFT JOIN search_field_emp as sfe ON sfe.content_id=el.content_id "
            . "LEFT JOIN taxonomy as company ON company.tid = sfe.emp_division "
            . "LEFT JOIN taxonomy as division ON division.tid = sfe.emp_department "
            . "LEFT JOIN taxonomy as department ON department.tid = sfe.department_id "
            . "LEFT JOIN taxonomy as designation ON designation.tid = sfe.emp_post_id "
            . "WHERE el.leave_year=$year AND el.content_id IN ($content_ids) ORDER BY el.id DESC")->result();
    }
    public function getemp_spentleave($content_id, $leave_type, $leave_year)
    {
        if ($content_id && $leave_type) {

            /*  
            return $this->db->query("select * from emp_leave WHERE content_id='$content_id' and leave_year='$leave_year' and leave_type='$leave_type' order by id DESC")->result_array();
            */
            return $this->db->query("select DISTINCT leave_start_date,leave_total_day,leave_type from emp_leave WHERE content_id='$content_id' and leave_year='$leave_year' and leave_type='$leave_type' AND approve_status='approved' order by id DESC")->result_array();
        }
    }
    public function getempSpentleave($content_id, $leave_type, $leave_year)
    {
        if ($content_id && $leave_type) {

            return $this->db->query("select DISTINCT leave_start_date,leave_total_day,leave_type from emp_leave WHERE content_id='$content_id' and leave_year='$leave_year' and leave_type='$leave_type' AND leave_type  NOT IN(594,782) AND approve_status='approved' order by id DESC")->result_array();
        }
    }
    public function getEmpAnnualLeaveSpent($contentId, $leaveYear)
    {
        if ($contentId && $leaveYear) {
            // Compassionate Leave = 335, Special Leave = 594,  Compensated Leave = 782
            return $this->db->query("SELECT DISTINCT leave_start_date,SUM(leave_total_day) AS TotalAnnualLeaveSpent FROM emp_leave "
                . "WHERE content_id='$contentId' AND leave_year='$leaveYear' "
                . "AND leave_type  NOT IN(335,594,782) AND approve_status='approved' ORDER BY id DESC")->row();
        }
    }
    public function getPreviousCarryForwardLeaveBalance($year,$contentId){
        if($year && $contentId){
            $previous_year_total_earn_leave = $this->db->query("SELECT SUM(total_days) as total 
            FROM emp_yearly_leave_cat_history 
            WHERE 
            leave_type=864 AND 
            (
                (YEAR(start_year) <= ($year-1) AND end_year='0000-00-00') OR 
                (
                    YEAR(start_year) = ($year-1) AND YEAR(end_year)=($year-1)
                )
            ) AND 
            content_id=".$contentId." 
            GROUP BY content_id,leave_type")->row('total');
            $previous_year_earn_leave_availed = $this->db->query("SELECT SUM(leave_total_day) as total FROM emp_leave WHERE leave_type=864 AND leave_year <= ($year-1) AND content_id=".$contentId." GROUP BY content_id,leave_type")->row('total');
            $previous_carry_forward_leave_balance = $previous_year_total_earn_leave-$previous_year_earn_leave_availed;
            return $previous_carry_forward_leave_balance;
        }        
    }
    public function getCurrentYearTotalLeave($year, $contentId){
        if($year && $contentId){
            $current_year_total_leave = $this->db->query("SELECT SUM(total_days) AS total FROM emp_yearly_leave_cat_history WHERE ((YEAR(start_year)=$year AND end_year='0000-00-00') 
            OR (YEAR(start_year)=$year AND YEAR(end_year)=$year)) AND content_id=".$contentId." GROUP BY content_id")->row('total');
            return $current_year_total_leave; 
        }  
}
    public function getemp_spentleavebydate($leave_date)
    {
        if ($leave_date) {
            return $this->db->query("select * from emp_leave WHERE leave_start_date='$leave_date' AND approve_status='approved' order by id DESC")->result_array();
        }
    }
    public function updemp_leavetbl($data = array(), $where = array())
    {
        if ($data && $where) {
            $this->db->where($where);
            $this->db->update('emp_leave', $data);
            return true;
        }
    }
    function cancelLeave($content_id, $leave_date)
    {
        $tables = array('emp_leave');
        $where = array('content_id' => $content_id, 'leave_start_date' => $leave_date);
        $this->db->where($where);
        $this->db->delete($tables);
        return true;
    }
    function deleteLeaveById($id)
    {
        $tables = array('emp_leave');
        $where = array('id' => $id);
        $this->db->where($where);
        $this->db->delete($tables);
        return true;
    }
    public function getemp_yearlyleave($content_id, $leave_tid)
    {
        if ($content_id && $leave_tid) {
            return $this->db->query("SELECT * FROM emp_yearly_leave WHERE content_id='$content_id' and leave_type='$leave_tid' order by id DESC")->row_array();
        }
    }
    public function getemp_yearlyleavebyyear($content_id, $year)
    {
        if ($content_id && $year) {
            return $this->db->query("select * from emp_leave WHERE content_id='$content_id' and leave_type !='336' and leave_year='$year' AND approve_status='approved' order by id ASC")->result_array();
        }
    }
    public function getemp_yearlyleavebyid($content_id)
    {
        if ($content_id) {
            return $this->db->query("select * from emp_yearly_leave WHERE content_id='$content_id' order by id DESC")->row_array();
        }
    }
    public function getemp_yearlyleavetotal($content_id)
    {
        if ($content_id) {
            return $this->db->query("select * from emp_leave_total_system WHERE content_id='$content_id' order by id DESC")->row_array();
        }
    }
    public function updemp_yearly_leavetbl($data = array(), $where = array())
    {
        if ($data && $where) {
            $this->db->where($where);
            $this->db->update('emp_yearly_leave', $data);
            return true;
        }
    }
    public function updemp_yearlytotal_leavetbl($data = array(), $where = array())
    {
        if ($data && $where) {
            $this->db->where($where);
            $this->db->update('emp_leave_total_system', $data);
            return true;
        }
    }
    function deleteemp_leave_total_system($content_id)
    {
        $tables = array('emp_leave_total_system');
        $this->db->where('content_id', $content_id);
        $this->db->delete($tables);
        return true;
    }
    function deleteemp_yearly_leave($content_id)
    {
        $tables = array('emp_yearly_leave');
        $this->db->where('content_id', $content_id);
        $this->db->delete($tables);
        return true;
    }
    public function getemp_sumleavetotal($content_id, $lastdateofattendance)
    {
        if ($content_id && $lastdateofattendance) {
            $empatt_end_date_arr = explode("-", $lastdateofattendance);

            $emp_att_end_date = $empatt_end_date_arr[2] . "-" . $empatt_end_date_arr[1] . "-" . $empatt_end_date_arr[0];
            return $this->db->query("select SUM(leave_total_day) AS Totalleave FROM emp_leave WHERE content_id='$content_id' AND leave_year='$empatt_end_date_arr[2]' AND str_to_date(leave_end_date, '%d-%m-%Y') <='$emp_att_end_date' AND leave_type !='336' AND approve_status='approved' order by id DESC")->row_array();
        }
    }

    public function getallleavedate($content_id, $emp_att_start_date, $emp_att_end_date)
    {
        if ($content_id && $emp_att_start_date && $emp_att_end_date) {
            $empatt_start_date_arr = explode("-", $emp_att_start_date);
            $emp_att_end_date_arr = explode("-", $emp_att_end_date);
            $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
            $emp_att_end_date = $emp_att_end_date_arr[2] . "-" . $emp_att_end_date_arr[1] . "-" . $emp_att_end_date_arr[0];
            $this->db->simple_query('SET SESSION group_concat_max_len=100000000');
            return $this->db->query("SELECT GROUP_CONCAT(leave_start_date) as leave_dates FROM `emp_leave` WHERE str_to_date(leave_start_date, '%d-%m-%Y')>='$emp_att_start_date'  and str_to_date(leave_start_date, '%d-%m-%Y')<='$emp_att_end_date' AND content_id='$content_id' AND leave_type !='336' AND approve_status='approved' order by id DESC")->row_array();
        }
    }

    public function getLeaveApplicationInfoById($id)
    {
        return $this->db->query("SELECT el.*,t.name as leave_type_name,sfe.emp_id,sfe.emp_name,sfe.joining_date,sfe.gender,sfe.religion,t.name as leaveType,"
            . "company.keywords AS company_name,division.name AS division_name,department.name AS department_name,designation.name AS designation_name FROM emp_leave as el "
            . "LEFT JOIN taxonomy as t ON t.tid=el.leave_type "
            . "LEFT JOIN search_field_emp as sfe ON sfe.content_id=el.content_id "
            . "LEFT JOIN taxonomy as company ON company.tid = sfe.emp_division "
            . "LEFT JOIN taxonomy as division ON division.tid = sfe.emp_department "
            . "LEFT JOIN taxonomy as department ON department.tid = sfe.department_id "
            . "LEFT JOIN taxonomy as designation ON designation.tid = sfe.emp_post_id "
            . "WHERE el.id=$id")->row();
    }
    public function getEmpLeaveInfo($contentId, $leaveYear)
    {
        $result = $this->db->query("SELECT total_days AS emp_total_annual_leave "
            . ",(SELECT mobile_no FROM search_field_emp WHERE content_id=$contentId ORDER BY id DESC LIMIT 1) AS mobile_no"
            . ",(SELECT SUM(leave_total_day) FROM emp_leave WHERE content_id='$contentId' AND leave_year='$leaveYear' AND approve_status='approved' GROUP BY content_id) AS total_availed_leave "
            . ",(SELECT SUM(leave_total_day) FROM emp_leave WHERE content_id='$contentId' AND leave_year='$leaveYear' AND pay_status='payable' AND approve_status='approved' GROUP BY content_id) AS TotalPaidLeave,"
            . "(SELECT SUM(leave_total_day) FROM emp_leave WHERE content_id='$contentId' AND leave_year='$leaveYear' AND leave_type  NOT IN(335,594,782) AND approve_status='approved' GROUP BY content_id) AS TotalAnnualLeaveSpent "
            . "FROM emp_leave_total_system WHERE content_id='$contentId' ORDER BY id DESC ")->row();
        return $result;
    }
    public function getEmpInfo($contentId)
    {
        return $this->db->query("SELECT joining_date FROM search_field_emp WHERE content_id=$contentId ORDER BY id DESC LIMIT 1")->row();
    }
}
