<?php

class Employee_id_model extends CI_Model {
    function getLastcontentId() {
        $query = $this->db->query('SELECT id FROM `employee_id` ORDER BY `id` DESC LIMIT 1');
        return $last_id = $query->row()->id;
    }
    function getLastempcodebydivision($division_tid) {
        $query = $this->db->query("SELECT emp_id FROM `search_field_emp` WHERE `emp_division` ='$division_tid' ORDER BY  emp_id+0 DESC LIMIT 1");
        return $last_code = $query->row()->emp_id;
    }
    public function upddataContent($data, $content_id) {
    	if($data && $content_id){
        $this->db->where('id', $content_id);
        $this->db->update('employee_id', $data);
        return true;
    	}
    }  
     function getemp_idby_empcode($emp_id) {
        if($emp_id){
        $query = $this->db->query("SELECT id FROM `employee_id` WHERE `emp_id`='$emp_id' ORDER BY `id` DESC LIMIT 1");
        return $emp_id = $query->row()->id;
        }
    }
      function get_all_content_id($division_tid) {
      
        $query = $this->db->query("SELECT content_id FROM search_field_emp  WHERE type_of_employee NOT IN(153,473) AND emp_division ='$division_tid' ORDER BY content_id DESC");
        return $emp_id = $query->result();
      
    }
      function getAllActiveEmpByDivisionId($companyTid,$divisionTid) {
      
        $query = $this->db->query("SELECT content_id FROM search_field_emp  "
                . "WHERE type_of_employee NOT IN(153,473) AND "
                . "emp_division ='$companyTid' AND "
                . "emp_department ='$divisionTid' "
                . "ORDER BY content_id DESC");
        return $emp_id = $query->result();
      
    }
     function getemp_codeby_empid($emp_id) {
        if($emp_id){
        $query = $this->db->query("SELECT emp_id FROM `employee_id` WHERE `id`=$emp_id ORDER BY `id` DESC LIMIT 1");
        return $emp_id = $query->row()->emp_id;
        }
    }           
}

?>