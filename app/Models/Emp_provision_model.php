<?php

class Emp_provision_model extends CI_Model
{

	public function getcontentByid($content_id)
	{
		if ($content_id) {
			return $this->db->query("select * from emp_provision WHERE content_id ='$content_id' and insertflag='0'")->row_array();
		}
	}
	public function updEmp_provisiontbl($data = array(), $where = array())
	{
		if ($data && $where) {
			$this->db->where($where);
			$this->db->update('emp_provision', $data);
			return true;
		}
	}
	public function getprovisionalemp()
	{
		date_default_timezone_set('Asia/Dhaka');
		$servertime = time();
		$today_date = date("d-m-Y", $servertime);
		return $this->db->query("select * from emp_provision WHERE STR_TO_DATE(provision_date_to, '%d-%m-%Y') < STR_TO_DATE('$today_date', '%d-%m-%Y') and insertflag='0'")->result_array();
	}
}
