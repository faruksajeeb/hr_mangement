<?php

class Re_circular_model extends CI_Model {

    public function get_data_by_id($id) {
        if($id){
            return $this->db->query("select * from re_circular WHERE id='$id' ")->row_array();
        
        }
    }
    public function updanytbl($data = array(), $where = array(), $tblname) {
        if($data && $where && $tblname){
            $this->db->where($where);
            $this->db->update($tblname, $data);
            return true;
        }
    }  

    public function search_record_count() {
            $abb="id !=0";
            $query = $this->db->select('*')
            ->from('re_circular')
            ->where($abb, NULL, FALSE)
            ->get();
            $total_row = $query->result_array();
            return count($total_row);
        
    }  
    function get_all_data($limit = NULL, $offset = NULL) {
        $abb = "id !=0 ";
        $sortby = 'id';
        if ($abb) {
            $query = $this->db->select('*')
                    ->from('re_circular')
                    ->where($abb, NULL, FALSE)
                    ->limit($limit, $offset)
                    ->order_by("".$sortby."", "ASC") 
                    ->get();
            
        }

        if (count($query) > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    } 



    public function applicant_record_count($searchpage) {

        $user_id = $this->session->userdata('user_id');
        $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
        $search_query_result = $this->db->query($search_query)->row_array();
        $abb = $search_query_result['search_query'];
        if ($abb) {
            $query = $this->db->select('*')
                    ->from('re_search_field_emp')
                    ->where($abb, NULL, FALSE)
                    ->get();
            $total_row = $query->result_array();
            return count($total_row);
        } else {
            return 0;
        }
    } 
    public function getapplicantsearchQuery($searchpage) {
        $user_id = $this->session->userdata('user_id');
        $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
            return $this->db->query($search_query)->row_array();
    }  

    function get_all_applicant_data($limit = NULL, $offset = NULL, $searchpage) {
        $user_id = $this->session->userdata('user_id');
        $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
        $search_query_result = $this->db->query($search_query)->row_array();
        $abb = $search_query_result['search_query'];
        if ($abb) {
            $query = $this->db->select('*')
                    ->from('re_search_field_emp')
                    ->where($abb, NULL, FALSE)
                    ->limit($limit, $offset)
                    ->order_by("id", "desc") 
                    ->get();
            
        }
        if (count($query) > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    } 

    function getcandidatesbycolumn($column){
        return $this->db->query("select DISTINCT($column) as record from re_search_field_emp order by id DESC")->result_array();
    }
    function getallsearch_table_contentByid($content_id) {
        if($content_id){
            return $this->db->query("select * from re_search_field_emp WHERE content_id =$content_id")->row_array();
        }
    }
    function get_all_search_emp($searchpage) {
        $user_id = $this->session->userdata('user_id');
        $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
        $search_query_result = $this->db->query($search_query)->row_array();
        $abb = $search_query_result['search_query'];
        $sortby = $search_query_result['table_view'];
        if(!$sortby){
            $sortby="grade";
        }
        if ($abb) {
        $query = $this->db->select('*')
                ->from('re_search_field_emp')
                ->where($abb, NULL, FALSE)
                ->order_by("id", "ASC") 
                ->get();
        }

        if (count($query) > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }   

    public function getcontentByidandname($content_id, $field_name) {
        return $this->db->query("select * from re_emp_details WHERE content_id =$content_id and field_name='$field_name'")->result_array();
    }   
    function deleteCandidatesByid($id) {
        $tables = array('re_search_field_emp', 're_emp_details');
        $this->db->where('content_id', $id);
        $this->db->delete($tables);
        $this->deletere_employee_idByid($id);
    } 
    function deletere_employee_idByid($id) {
        $tables = array('re_employee_id');
        $this->db->where('id', $id);
        $this->db->delete($tables);
    }
    function getallcontentByid($content_id) {
        if($content_id){
            return $this->db->query("select * from re_emp_details WHERE content_id =$content_id")->result_array();
        }
    }
}	

?>