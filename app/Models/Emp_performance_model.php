<?php

class Emp_performance_model extends CI_Model {

    public function updEmp_performance_idtbl($data = array(), $where = array()) {
        if($data && $where){
            $this->db->where($where);
            $this->db->update('emp_performance_id', $data);
            return true;
        }
    } 
    public function updEmp_performance_valuetbl($data = array(), $where = array()) {
        if($data && $where){
            $this->db->where($where);
            $this->db->update('emp_performance_value', $data);
            return true;
        }
    }    
    function getperfomanceByidandfieldname($performance_id, $fieldname) {
        if($performance_id && $fieldname ){
            return $this->db->query("select * from emp_performance_value WHERE performance_id ='$performance_id' and field_name='$fieldname' ")->row_array();
        }
    }    
    function getallperfomanceid() {
            return $this->db->query("SELECT * FROM `emp_performance_id` ORDER BY str_to_date(Last_Date_Submission, '%d-%m-%Y') DESC")->result_array();

    }  
    function getallappraisor() {
            return $this->db->query("SELECT DISTINCT appraisor_usr_id, id, per_main_id, to_emp_id FROM `emp_per_submit_id`")->result_array();

    }   
    function getperfomanceidByid($performance_id) {
        if($performance_id ){
            return $this->db->query("select * from emp_performance_id WHERE id ='$performance_id' ")->row_array();
        }
    }   
    function getsubmittedperformanceByid($performance_id) {
        if($performance_id ){
            return $this->db->query("select * from emp_per_submit_id WHERE id ='$performance_id' ")->row_array();
        }
    }        
    function getperfomanceidByidandempcode($performance_id, $emp_id, $appraisor_usr_id) {
        if($performance_id && $emp_id && $appraisor_usr_id){
            return $this->db->query("select * from emp_per_submit_id WHERE per_main_id ='$performance_id' and appraisor_usr_id='$appraisor_usr_id' and to_emp_id='$emp_id' ")->row_array();
        }
    }      
    function getemployeelastperformance($employee_id) {
        if($employee_id ){
            $query = $this->db->query("SELECT id FROM emp_performance_id WHERE content_id ='$employee_id' ORDER BY id DESC LIMIT 1");
            return $last_id = $query->row()->id;
        }
    }    

    public function search_record_count($searchpage) {
        $user_id = $this->session->userdata('user_id');
        $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
        $search_query_result = $this->db->query($search_query)->row_array();
        $abb = $search_query_result['search_query'];
        if ($abb) {
            $query = $this->db->select('*')
            ->from('emp_per_submit_id')
            ->where($abb, NULL, FALSE)
            ->get();
            $total_row = $query->result_array();
            return count($total_row);
        } else {
            return 0;
        }
    }  
        public function getsearchQuery($searchpage) {
        if($searchpage){
            $user_id = $this->session->userdata('user_id');
            $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
            return $this->db->query($search_query)->row_array();
        }
    }   
    function get_all_data($limit = NULL, $offset = NULL, $searchpage) {
        $user_id = $this->session->userdata('user_id');
        $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
        $search_query_result = $this->db->query($search_query)->row_array();
        $abb = $search_query_result['search_query'];
        $sortby = $search_query_result['table_view'];
        if ($abb) {
            $user_type=$this->session->userdata('user_type');
            if($user_type==7){
            $query = $this->db->select('*')
                    ->from('emp_per_submit_id')
                    ->where($abb, NULL, FALSE)
                    ->limit($limit, $offset)
                    // ->order_by("".$sortby."", "ASC") 
                    ->get();
            }else{
            $query = $this->db->select('*')
                    ->from('emp_per_submit_id')
                    ->where($abb, NULL, FALSE)
                    ->limit($limit, $offset)
                    // ->order_by("".$sortby."", "ASC") 
                    ->get();
            }
        }

        if (count($query) > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }     
}

?>