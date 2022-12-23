<?php

class Emp_salary_deduction_model extends CI_Model {

    public function getdeduction($content_id) {
    	if($content_id){
 			return $this->db->query("select * from emp_salary_deduction WHERE content_id=$content_id order by id DESC")->row_array();
    	}
       
    }

    function getLastcontentId($content_id) {
    	if($content_id){
    		$query = $this->db->query("SELECT id FROM emp_salary_deduction WHERE content_id=$content_id ORDER BY id DESC LIMIT 1");
        	return $last_id = $query->row()->id;
    	}
        
    }
	public function updEmp_salary_deductiontbl($data = array(), $where = array()) {
		if($data && $where){
			$this->db->where($where);
			$this->db->update('emp_salary_deduction', $data);
                       // return $this->db->query("UPDATE emp_salary_deduction SET provident_fund_deduction = $data['provident_fund_deduction'], tax_deduction =$data['tax_deduction'], other_deduction = $data['other_deduction'], total_deduction = $data['total_deduction'], updated =$data['updated'] ,updated_by =$data['updated_by'], comments = $data['comments'] WHERE id = $updateId ");
		
			return true;
		}
	}     
}

?>