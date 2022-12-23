<?php

class Emp_details_model extends CI_Model {
	
	function getallcontentByid($content_id) {
		if($content_id){
			return $this->db->query("select * from emp_details WHERE content_id =$content_id")->result_array();
		}
	}
	public function getsinglebiodocuments($content_id) {
		if($content_id){
			return $this->db->query("select * from emp_details WHERE field_name LIKE '%resources/uploads/documents' and content_id =$content_id")->result_array();
		}
	}    
	public function deletesinglebiodocuments($content_id, $repeat_id) {
		if($content_id && $repeat_id){
			$field_name="resources/uploads/documents";
			$this->db->delete('emp_details', array('field_name' => $field_name,'content_id' => $content_id,'field_repeat' => $repeat_id)); 
			return true;
		}
	} 
	public function getbiodocumentsrepeatid($content_id) {
		if($content_id){
			return $this->db->query("select field_repeat from emp_details WHERE field_name LIKE '%resources/uploads/documents' and content_id =$content_id ORDER BY `field_repeat` DESC")->row_array();
		}
	}       
	public function getcontentByidandname($content_id, $field_name) {
		if($content_id && $field_name){
			return $this->db->query("select * from emp_details WHERE content_id =$content_id and field_name='$field_name'")->result_array();
		}
	}    
	public function updContenttbl($data = array(), $where = array()) {
		
		if($data && $where){
			$this->db->update('emp_details', $data,$where);
			return true;
		}
		
	}    
    function deleteContentByid($id) {
        $tables = array('emp_details', 'search_field_emp', 'emp_payment_method', 'emp_provision', 'emp_salary', 'emp_salary_deduction', 'emp_working_time');
        $this->db->where('content_id', $id);
        $this->db->delete($tables);
		return true;
    }
    function deleteemployeeidByid($id) {
        $tables = array('employee_id');
        $this->db->where('id', $id);
        $this->db->delete($tables);
		return true;
    }    
}

?>