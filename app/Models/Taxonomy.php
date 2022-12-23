<?php

class Taxonomy extends CI_Model {

    public function getTaxonomybyname($vid, $name) {
        if ($vid && $name) {
            return $this->db->query("select * from taxonomy WHERE vid='$vid' and name ='$name'")->result_array();
        }
    }
    public function getcriteriaTaxonomybycriteria($vid, $criteria_type, $criteria) {
        if ($vid && $criteria && $criteria_type) {
            return $this->db->query("select * from taxonomy WHERE vid='$vid' and name ='$criteria' and parents_term='$criteria_type' order by weight ASC")->result_array();
        }
    }   
    public function getcriteriaTaxonomybyparent($vid, $criteria_type) {
        if ($vid && $criteria_type) {
            return $this->db->query("select * from taxonomy WHERE vid='$vid' and parents_term='$criteria_type' order by weight ASC")->result_array();
        }
    }     
    function getTaxonomybynameandparent($vid, $name, $parent_term) {
        if ($vid && $name && $parent_term) {
            return $this->db->query("select * from taxonomy WHERE vid='$vid' and name ='$name' and parents_term ='$parent_term'")->result_array();
        }
    }    
    public function getcriteriaTaxonomybycriteriacategory($vid) {
        if ($vid) {
            return $this->db->query("select * from taxonomy WHERE vid='$vid' order by parents_term, weight * 1 ASC")->result_array();
        }
    }       
    function getLasttaxonomyId() {
        //$query = $this->db->query('SELECT tid FROM taxonomy ORDER BY tid DESC LIMIT 1');
        $query = $this->db->query('SELECT id FROM taxonomy ORDER BY id DESC LIMIT 1');
        return $last_tid = $query->row()->id;
    }

    public function updTaxanomytbl($data = array(), $where = array()) {
        $this->db->where($where);
        $this->db->update('taxonomy', $data);
        return true;
    }   

    function getTaxonomyByvid($vid) {
        if ($vid) {
            return $this->db->query("SELECT * FROM taxonomy WHERE vid='$vid' /*AND status=1 */ORDER BY name ASC")->result_array();
        }
    }
    function getActiveTaxonomyByVId($vid) {
        if ($vid) {
            return $this->db->query("SELECT * FROM taxonomy WHERE vid='$vid' AND status=1 ORDER BY name ASC")->result_array();
        }
    }
    function getTaxonomybyid($id) {
        $query = $this->db->get_where('taxonomy', array('tid' => $id));
        return $query->row_array();
    }     
    function getTaxonomyBytid($tid) {
        if ($tid) {
            return $this->db->query("SELECT * FROM taxonomy WHERE tid='$tid' AND status=1 ORDER BY name ASC")->row_array();
        }
    } 
    function getTaxonomychildbyparent($tid) {
        if ($tid) {
            return $this->db->query("SELECT * FROM taxonomy WHERE parents_term='$tid' AND status=1 ORDER BY name ASC")->result_array();
        }
    }    
    function deleteTexanomy($id) {
        $tables = array('taxonomy');
        $this->db->where('id', $id);
        $this->db->delete($tables);
        return true;
    }           
}

?>