<?php

class Role_model extends CI_Model {

    public function getuserrolebyrolename($rolename) {
        if ($rolename) {
            return $this->db->query("select * from role WHERE user_type ='$rolename'")->result_array();
        }
    }
    function getAllrole() {
        return $this->db->query("select * from role ORDER BY id ASC")->result_array();
    }
    public function getrolebyid($id)
    {
        if($id) {
            return $this->db->query("select * from role WHERE id ='$id'")->row_array();
        }     
    }
    public function updRoletbl($data = array(), $where = array()) {
        $this->db->where($where);
        $this->db->update('role', $data);
        return true;
    }   

}
?>