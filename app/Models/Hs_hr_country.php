<?php

class Hs_hr_country extends CI_Model {

    public function getCountry() {
        return $this->db->query("select * from hs_hr_country order by name ASC")->result_array();
    }

}

?>