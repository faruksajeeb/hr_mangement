<?php

class Page_model extends CI_Model
{
    // function Page_model()
    // {
    //     parent::Model();
 
    //     // Make the database available to all the methods
    //     $this->load->database();
    // }
 
    function search($terms)
    {
        // Execute our SQL statement and return the result
        $sql = "SELECT url, title
                    FROM pages
                    WHERE MATCH (content) AGAINST (?) > 0";
        $query = $this->db->query($sql, array($terms, $terms));
        return $query->result();
    }
}
?>