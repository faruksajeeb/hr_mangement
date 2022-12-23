<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ramadan_model extends CI_Model {
 public function select_ramadan_scdedule_info() {
      $this->db->select('*')->from("tbl_ramadan_time_schedule");
      $this->db->order_by('year','ASC');
      $query = $this->db->get();
        $result = $query->result();
        return $result;
 }
     public function insert_table_info($data ) {
//        print_r($data);
//        exit;
        $result = $this->db->insert("tbl_ramadan_time_schedule", $data);
     
            return $result;
        
    }
       public function update_table_info($id,$data) {

            $this->db->where("ID", $id);
            $result = $this->db->update("tbl_ramadan_time_schedule", $data);
            return $result;
    }
 
}