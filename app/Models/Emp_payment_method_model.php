<?php

class Emp_payment_method_model extends CI_Model {

    public function getpayment_method($content_id) {
    	if($content_id){
    		return $this->db->query("select * from emp_payment_method WHERE content_id=$content_id order by id DESC")->row_array();
    	}
    }

    function getLastcontentId($content_id) {
    	if($content_id){
        $query = $this->db->query("SELECT id FROM emp_payment_method WHERE content_id=$content_id ORDER BY id DESC LIMIT 1");
        return $last_id = $query->row()->id;
    	}
    }
	public function updEmp_payment_methodtbl($data = array(), $where = array()) {
		if($data && $where){
			$this->db->where($where);
			$this->db->update('emp_payment_method', $data);
			return true;
		}
	}     
}

?>