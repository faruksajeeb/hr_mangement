<?php

class Company_info extends CI_Model {

    public function getcompany() {
        return $this->db->query("select * from company_info order by id ASC")->row_array();
    }

}

?>