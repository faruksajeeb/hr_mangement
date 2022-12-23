<?php

class Search_query_model extends CI_Model {
    function deleteQuerybyUserid($user_id, $searchpage) {
        if($user_id && $searchpage){
        $tables = array('search_query');
        $array = array('user_id' => $user_id, 'search_page' => $searchpage);
        $this->db->where($array);
        $this->db->delete($tables);
        return true;
        }
    }   
    public function update_view_status($data = array(), $where = array()) {
        $this->db->where($where);
        $this->db->update('search_query', $data);
        return true;
    }       
}

?>