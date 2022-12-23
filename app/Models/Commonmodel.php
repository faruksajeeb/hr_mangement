<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommonModel
 *
 * @author Administrator
 */
class CommonModel extends CI_Model {
    public function update_publication_status_info($id, $data, $table_name) {
        $this->db->where("content_id", $id);
        $this->db->update($table_name, $data);
        return true;
    }
 public function update_resignation_emp_job_history_info($content_id,$resign_date,$resign_reason){  
        $this->db->select_max('id');
        $this->db->set('end_date',$resign_date);
        $this->db->set('end_type_id',153);
        $this->db->set('reason',$resign_reason);
        $this->db->where("content_id", $content_id);
        $this->db->update('emp_job_history');
        return true;
    }
    public function update_terminated_emp_job_history_info($content_id,$terminate_date,$terminate_reason){  
        $this->db->select_max('id');
        $this->db->set('end_date',$terminate_date);
        $this->db->set('end_type_id',473);
        $this->db->set('reason',$terminate_reason);
        $this->db->where("content_id", $content_id);
        $this->db->update('emp_job_history');
        return true;
    }
    
    public function update_resignation_type_of_employee_info($content_id) {
        $this->db->set('type_of_employee', 153);
        $this->db->where("content_id", $content_id);
        $this->db->update('search_field_emp');
        return true;
    }
    public function update_termination_type_of_employee_info($content_id) {
        $this->db->set('type_of_employee', 473);
        $this->db->where("content_id", $content_id);
        $this->db->update('search_field_emp');
        return true;
    }




    public function update_type_of_employee_info($id, $data, $table_name) {
        $this->db->where("content_id", $id);
        $this->db->update($table_name, $data);
        return true;
    }
    public function update_trash_employee_info($id, $data, $table_name) {
        $this->db->where("content_id", $id);
        $this->db->update($table_name, $data);
        return true;
    }
    public function resign_multiple_employee_info($ids) { 
        $count = 0;
        foreach ($ids as $id){
        $this->db->set('type_of_employee', 153);
        $this->db->where("content_id", $id);
        $this->db->update('search_field_emp');
        $count = $count+1;
        }
        echo "<script type='text/javascript'>alert('$count employee resigned successfully');</script>";
        $count = 0;
        return true;
   }
public function update_delete_employee_info($id, $data, $table_name) {
        $this->db->where("content_id", $id);
        $this->db->update($table_name, $data);
        return true;
    }
   public function terminate_multiple_employee_info($ids) { 
        $count = 0;
        foreach ($ids as $id){
        $this->db->set('type_of_employee', 473);
        $this->db->where("content_id", $id);
        $this->db->update('search_field_emp');
        $count = $count+1;
        }
        echo "<script type='text/javascript'>alert('$count employee terminated successfully');</script>";
        $count = 0;
        return true;
   }
    public function delete_multiple_trash_employee_info($ids) { 
        $count = 0;
        foreach ($ids as $id){
        $this->db->set('deletion_status', 1);
        $this->db->where("content_id", $id);
        $this->db->update('search_field_emp');
        $count = $count+1;

        }
        echo "<script type='text/javascript'>alert('$count Item deleted successfully');</script>";
        $count = 0;
        return true;
   }
   public function restore_multiple_trash_employee_info($ids) { 
        $count = 0;
        foreach ($ids as $id){
        $this->db->set('type_of_employee', 1);
        $this->db->where("content_id", $id);
        $this->db->update('search_field_emp');
        $count = $count+1;
        }
        echo "<script type='text/javascript'>alert('$count Item restore successfully');</script>";
        $count = 0;
        return true;
   }
    public function getTotalLate($emp_content_id,$startDate,$endDate){
                return $this->db->query("SELECT * FROM search_field_emp WHERE type_of_employee NOT IN(153,473) ORDER BY emp_division")->result_array();
    }
}
