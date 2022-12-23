<?php

class Emp_informed_model extends CI_Model {

    public function getemp_informed($content_id, $attendance_date) {
    	if($content_id && $attendance_date){
 			return $this->db->query("SELECT presence_status,logout_status,reason,remarks FROM emp_informed WHERE content_id=$content_id AND attendance_date='$attendance_date' AND second_approval=1 ORDER BY id DESC")->row_array();
    	}
    }
	public function updemp_emp_informedtbl($data = array(), $where = array()) {
		if($data && $where){
			$this->db->where($where);
			$this->db->update('emp_informed', $data);
			return true;
		}
	}     
        public function getemp_informedbyrange($content_id, $emp_att_start_date, $emp_att_end_date) {
			$empatt_start_date_arr=explode("-",$emp_att_start_date);
			$emp_att_end_date_arr=explode("-",$emp_att_end_date);
			$emp_att_start_date=$empatt_start_date_arr[2]."-".$empatt_start_date_arr[1]."-".$empatt_start_date_arr[0];
			$emp_att_end_date=$emp_att_end_date_arr[2]."-".$emp_att_end_date_arr[1]."-".$emp_att_end_date_arr[0];
            return $this->db->query("SELECT * FROM `emp_informed` WHERE str_to_date(attendance_date, '%d-%m-%Y')>='$emp_att_start_date'  and str_to_date(attendance_date, '%d-%m-%Y')<='$emp_att_end_date' AND content_id='$content_id' ")->result_array();
    } 
    public function getemp_informedbyid($id) {
        if($id){
            return $this->db->query("select * from emp_informed WHERE id='$id'")->row_array();
        }
    }    
    public function getemp_informealldates($content_id, $emp_att_start_date, $emp_att_end_date) {
            if($content_id && $emp_att_start_date && $emp_att_end_date){
            $empatt_start_date_arr=explode("-",$emp_att_start_date);
            $emp_att_end_date_arr=explode("-",$emp_att_end_date);
            $emp_att_start_date=$empatt_start_date_arr[2]."-".$empatt_start_date_arr[1]."-".$empatt_start_date_arr[0];
            $emp_att_end_date=$emp_att_end_date_arr[2]."-".$emp_att_end_date_arr[1]."-".$emp_att_end_date_arr[0];
            $this->db->simple_query('SET SESSION group_concat_max_len=100000000');
            return $this->db->query("SELECT GROUP_CONCAT(attendance_date) as informed_dates FROM `emp_informed` WHERE str_to_date(attendance_date, '%d-%m-%Y')>='$emp_att_start_date'  and str_to_date(attendance_date, '%d-%m-%Y')<='$emp_att_end_date' AND content_id='$content_id' ")->row_array();
        }
    }     
    public function deleteInformed($id) {
        $tables = array('emp_informed');
        $this->db->where('id', $id);
        $this->db->delete($tables);
        return true;
    } 
    
    public function movementOrderByEmp($contentId) {
        if($contentId){
            $year=date('Y');
             return $this->db->query("SELECT el.* FROM emp_informed as el  WHERE el.content_id='$contentId' AND YEAR(STR_TO_DATE(el.attendance_date, '%d-%m-%Y'))='$year' ORDER BY el.id DESC")->result();
        }
    }  
    
        public function allMovementOrderByAdmin($content_ids) {
            
      
            $year=date('Y');
             return $this->db->query("SELECT el.*,sfe.emp_id,sfe.emp_name,company.keywords AS company_name,division.name AS division_name,department.name AS department_name,designation.name AS designation_name FROM emp_informed as el  "
                     . "LEFT JOIN search_field_emp as sfe ON sfe.content_id=el.content_id "
                . "LEFT JOIN taxonomy as company ON company.tid = sfe.emp_division "
                . "LEFT JOIN taxonomy as division ON division.tid = sfe.emp_department "
                . "LEFT JOIN taxonomy as department ON department.tid = sfe.department_id "
                . "LEFT JOIN taxonomy as designation ON designation.tid = sfe.emp_post_id "
                     . "WHERE el.content_id IN ($content_ids) AND YEAR(STR_TO_DATE(el.attendance_date, '%d-%m-%Y'))='$year' ORDER BY el.id DESC")->result();
        
    } 
    
            public function allMovementOrderByHrAdmin() {
            
            $year=date('Y');
             return $this->db->query("SELECT el.*,sfe.emp_name,sfe.emp_id,company.keywords AS company_name,division.name AS division_name,department.name AS department_name,designation.name AS designation_name FROM emp_informed as el  "
                     . "LEFT JOIN search_field_emp as sfe ON sfe.content_id=el.content_id "
                . "LEFT JOIN taxonomy as company ON company.tid = sfe.emp_division "
                . "LEFT JOIN taxonomy as division ON division.tid = sfe.emp_department "
                . "LEFT JOIN taxonomy as department ON department.tid = sfe.department_id "
                . "LEFT JOIN taxonomy as designation ON designation.tid = sfe.emp_post_id "
                     . "WHERE YEAR(STR_TO_DATE(el.attendance_date, '%d-%m-%Y'))='$year' ORDER BY el.id DESC")->result();
        
    } 
                public function pendingMovementOrderByHrAdmin() {
            
            $year=date('Y');
             return $this->db->query("SELECT el.*,sfe.emp_name,sfe.emp_id,company.keywords AS company_name,division.name AS division_name,department.name AS department_name,designation.name AS designation_name FROM emp_informed as el  "
                     . "LEFT JOIN search_field_emp as sfe ON sfe.content_id=el.content_id "
                . "LEFT JOIN taxonomy as company ON company.tid = sfe.emp_division "
                . "LEFT JOIN taxonomy as division ON division.tid = sfe.emp_department "
                . "LEFT JOIN taxonomy as department ON department.tid = sfe.department_id "
                . "LEFT JOIN taxonomy as designation ON designation.tid = sfe.emp_post_id "
                . "WHERE YEAR(STR_TO_DATE(el.attendance_date, '%d-%m-%Y'))='$year' AND second_approval=0 ORDER BY el.id DESC")->result();
        
    } 
    public function getMovementOrderInfoById($id){
        
             return $this->db->query("SELECT el.*,sfe.emp_name,sfe.emp_id,"
                     . "company.keywords AS company_name,division.name AS division_name,department.name AS department_name,designation.name AS designation_name FROM emp_informed as el  "
                     . "LEFT JOIN search_field_emp as sfe ON sfe.content_id=el.content_id "
                . "LEFT JOIN taxonomy as company ON company.tid = sfe.emp_division "
                . "LEFT JOIN taxonomy as division ON division.tid = sfe.emp_department "
                . "LEFT JOIN taxonomy as department ON department.tid = sfe.department_id "
                . "LEFT JOIN taxonomy as designation ON designation.tid = sfe.emp_post_id "
                     . "WHERE el.id=$id")->row();
    }
}

?>