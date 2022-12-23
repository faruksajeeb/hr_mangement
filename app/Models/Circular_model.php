<?php

class Circular_model extends CI_Model {

    public function getAllCircular() {
        $this->db->select('c.*')->from('tbl_circular AS c');
        $this->db->select('p.name AS post_name')->from('taxonomy AS p');
        $this->db->select('d.name AS division_name')->from('taxonomy AS d');
        $this->db->where('c.PostID = p.tid');
        $this->db->where('c.DivisionID = d.tid');
        $this->db->where('c.DeletionStatus = 0');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function select_job_info(){ 
            // connect to secondary database
            $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
            $today = $dt->format('Y-m-d');
            $this->db->select('c.*')->from('tbl_circular AS c');
            $this->db->select('p.name AS post_name')->from('taxonomy AS p');
            $this->db->select('d.name AS division_name')->from('taxonomy AS d');
            $this->db->where('c.PostID = p.tid');
            $this->db->where('c.DivisionID = d.tid');
            $this->db->where("c.EndDate >= '$today' ");
            $this->db->where('c.PublicationStatus = 1');
            $query=$this->db->get();
            $result=$query->result();
            return $result;
    }

    public function getAllTrashCircular() {
        $this->db->select('c.*')->from('tbl_circular AS c');
        $this->db->select('p.name AS post_name')->from('taxonomy AS p');
        $this->db->select('d.name AS division_name')->from('taxonomy AS d');
        $this->db->where('c.PostID = p.tid');
        $this->db->where('c.DivisionID = d.tid');
        $this->db->where('c.DeletionStatus = 1');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getAllTrashApplicant() {
        $this->db->select('a.*')->from('tbl_applicant AS a');
        $this->db->select('c.salary')->from('tbl_circular AS c');
        $this->db->select('p.name AS post_name')->from('taxonomy AS p');
        $this->db->select('d.name AS division_name')->from('taxonomy AS d');
        $this->db->where('a.CircularID = c.CircularID');
        $this->db->where('c.PostID = p.tid');
        $this->db->where('c.DivisionID = d.tid');
        $this->db->where('a.DeletionStatus = 1');
        $query = $this->db->get();
        $data['result'] = $query->result();
        $data['rows'] = $query->num_rows();
        return $data;
    }

    public function getAllDivisions() {
        $query = $this->db->select('tid,name')->from('taxonomy')->WHERE('vid', 1)->order_by('name')->get();
        $result = $query->result();
        return $result;
    }

    public function getAllDepartments() {
        $query = $this->db->select('tid,name,keywords')->from('taxonomy')->WHERE('vid', 2)->order_by('name')->get();
        $result = $query->result();
        return $result;
    }

    public function getAllPost() {
        $query = $this->db->select('tid,name')->from('taxonomy')->WHERE('vid', 3)->order_by('name')->get();
        $result = $query->result();
        return $result;
    }

    public function insert_circular_info($data) {
        $result = $this->db->insert("tbl_circular", $data);
        return $result;
    }

    public function update_status_info($id, $data) {

        $this->db->where("CircularID", $id);
        $this->db->update('tbl_circular', $data);
    }

    public function select_detail_by_id($id) {
        $this->db->select('c.*')->from('tbl_circular c');
        $this->db->select('p.tid AS post_id,p.name AS post_name')->from('taxonomy AS p');
        $this->db->select('d.tid AS division_id,d.name AS division_name')->from('taxonomy AS d');
        $this->db->select('dep.tid AS department_id,dep.name AS department_name')->from('taxonomy AS dep');
        $this->db->where('c.PostID = p.tid');
        $this->db->where('c.DivisionID = d.tid');
        $this->db->where('c.DepartmentID = dep.tid');
        $this->db->where('c.CircularID', $id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function select_applicant_detail_by_id($id) {
        $this->db->select('a.*')->from('tbl_applicant a');
        $this->db->select('c.*')->from('tbl_circular AS c');
        $this->db->select('p.tid AS post_id,p.name AS post_name')->from('taxonomy AS p');
        $this->db->select('d.tid AS division_id,d.name AS division_name')->from('taxonomy AS d');
        $this->db->select('dep.tid AS department_id,dep.name AS department_name')->from('taxonomy AS dep');
        $this->db->where('a.CircularID = c.CircularID');
        $this->db->where('c.PostID = p.tid');
        $this->db->where('c.DivisionID = d.tid');
        $this->db->where('c.DepartmentID = dep.tid');
        $this->db->where('a.ApplicantID', $id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function edit_circular_info($id, $data) {
        $this->db->where('CircularID', $id);
        $this->db->update('tbl_circular', $data);
    }

    public function update_deletion_status_info($id) {
        $this->db->set('PublicationStatus', 0);
        $this->db->set('DeletionStatus', 1);
        $this->db->where("CircularID", $id);
        $this->db->update('tbl_circular');
    }

    public function update_applicant_deletion_status_info($id) {
        $this->db->set('Status', 0);
        $this->db->set('DeletionStatus', 1);
        $this->db->where("ApplicantID", $id);
        $this->db->update('tbl_applicant');
    }

    public function restore_circular($id) {
        $this->db->set('PublicationStatus', 0);
        $this->db->set('DeletionStatus', 0);
        $this->db->where("CircularID", $id);
        $this->db->update('tbl_circular');
    }

    public function restore_applicant($id) {
        $this->db->set('Status', 0);
        $this->db->set('DeletionStatus', 0);
        $this->db->where("ApplicantID", $id);
        $this->db->update('tbl_applicant');
    }

    public function delete_circular($id) {
        $this->db->where("CircularID", $id);
        $this->db->delete('tbl_circular');
    }

    public function delete_applicant($id) {
        $this->db->where("ApplicantID", $id);
        $this->db->delete('tbl_applicant');
    }
 
    function get_all_applicant_data($searchpage) {
        $user_id = $this->session->userdata('user_id');
        $search_query = "SELECT * FROM search_query WHERE user_id='$user_id' AND search_page='$searchpage' order by id DESC limit 1";
        $search_query_result = $this->db->query($search_query)->row_array();
        $search_condition = $search_query_result['search_query'];
        if ($search_condition) {          
            $this->db->select('a.*')->from('tbl_applicant AS a');
            $this->db->select('c.salary')->from('tbl_circular AS c');
            $this->db->select('p.name AS post_name')->from('taxonomy AS p');
            $this->db->select('d.name AS division_name')->from('taxonomy AS d');
            $this->db->where('a.CircularID = c.CircularID');
            $this->db->where('c.PostID = p.tid');
            $this->db->where('c.DivisionID = d.tid');
            $this->db->where($search_condition, NULL, FALSE);            
//            $this->db->where('a.Status = 0');
            $this->db->where('a.DeletionStatus = 0');
            $this->db->order_by('a.AppliedTime');
            $query = $this->db->get();
            $data['result'] = $query->result();
            $data['rows'] = $query->num_rows();
            
        }
        if (count($data) > 0) {
            return $data;
        } else {
            return false;
        }
    }

    public function getAllApplicantById($id) {
        $this->db->select('a.*')->from('tbl_applicant AS a');
        $this->db->select('c.salary')->from('tbl_circular AS c');
        $this->db->select('p.name AS post_name')->from('taxonomy AS p');
        $this->db->select('d.name AS division_name')->from('taxonomy AS d');
        $this->db->where('a.CircularID = c.CircularID');
        $this->db->where('c.PostID = p.tid');
        $this->db->where('c.DivisionID = d.tid');
//        $this->db->where('a.Status = 1');
        $this->db->where('a.DeletionStatus = 0');
        $this->db->where("a.ApplicantID = $id");
        $query = $this->db->get();
        $data = $query->row();
        return $data;
    }

    function getApplicantInfo($column) {

        $this->db->select('a.CircularID')->from('tbl_applicant AS a');
        $this->db->select("c.$column")->from('tbl_circular AS c');
        $this->db->select('t.name AS record_name')->from('taxonomy AS t');
        $this->db->where('a.CircularID = c.CircularID');
        $this->db->where("c.$column = t.tid");
        $this->db->where('a.DeletionStatus = 0');
        $this->db->group_by("t.tid");
        $this->db->order_by("c.$column", 'DESC');
        $query = $this->db->get();
        $result = $query->result();
//          print_r($data);
//          exit;
        return $result;
//        return $this->db->query("select DISTINCT($column) as record from re_search_field_emp order by id DESC")->result_array();
    }

    public function getAllApplicantShortlist() {
        $this->db->select('a.*')->from('tbl_applicant AS a');
        $this->db->select('c.salary')->from('tbl_circular AS c');
        $this->db->select('p.name AS post_name')->from('taxonomy AS p');
        $this->db->select('d.name AS division_name')->from('taxonomy AS d');
        $this->db->where('a.CircularID = c.CircularID');
        $this->db->where('c.PostID = p.tid');
        $this->db->where('c.DivisionID = d.tid');
        $this->db->where('a.Status = 1');
        $this->db->where('a.DeletionStatus = 0');
        $query = $this->db->get();
        $data['result'] = $query->result();
        $data['rows'] = $query->num_rows();
        return $data;
    }

    public function getAllApplicantWrittenlist() {
        $this->db->select('a.*')->from('tbl_applicant AS a');
        $this->db->select('c.salary')->from('tbl_circular AS c');
        $this->db->select('p.name AS post_name')->from('taxonomy AS p');
        $this->db->select('d.name AS division_name')->from('taxonomy AS d');
        $this->db->where('a.CircularID = c.CircularID');
        $this->db->where('c.PostID = p.tid');
        $this->db->where('c.DivisionID = d.tid');
        $this->db->where('a.Status = 2');
        $this->db->where('a.DeletionStatus = 0');
        $query = $this->db->get();
        $data['result'] = $query->result();
        $data['rows'] = $query->num_rows();
        return $data;
    }

    public function getAllApplicantInterviewlist() {
        $this->db->select('a.*')->from('tbl_applicant AS a');
        $this->db->select('c.salary')->from('tbl_circular AS c');
        $this->db->select('p.name AS post_name')->from('taxonomy AS p');
        $this->db->select('d.name AS division_name')->from('taxonomy AS d');
        $this->db->where('a.CircularID = c.CircularID');
        $this->db->where('c.PostID = p.tid');
        $this->db->where('c.DivisionID = d.tid');
        $this->db->where('a.Status = 3');
        $this->db->where('a.DeletionStatus = 0');
        $query = $this->db->get();
        $data['result'] = $query->result();
        $data['rows'] = $query->num_rows();
        return $data;
    }

    public function getAllApplicantSelectedlist() {
        $this->db->select('a.*')->from('tbl_applicant AS a');
        $this->db->select('c.salary')->from('tbl_circular AS c');
        $this->db->select('p.name AS post_name')->from('taxonomy AS p');
        $this->db->select('d.name AS division_name')->from('taxonomy AS d');
        $this->db->where('a.CircularID = c.CircularID');
        $this->db->where('c.PostID = p.tid');
        $this->db->where('c.DivisionID = d.tid');
        $this->db->where('a.Status = 4');
        $this->db->where('a.DeletionStatus = 0');
        $query = $this->db->get();
        $data['result'] = $query->result();
        $data['rows'] = $query->num_rows();
        return $data;
    }

    public function getAllApplicantappointedlist() {
        $this->db->select('a.*')->from('tbl_applicant AS a');
        $this->db->select('c.salary')->from('tbl_circular AS c');
        $this->db->select('p.name AS post_name')->from('taxonomy AS p');
        $this->db->select('d.name AS division_name')->from('taxonomy AS d');
        $this->db->where('a.CircularID = c.CircularID');
        $this->db->where('c.PostID = p.tid');
        $this->db->where('c.DivisionID = d.tid');
        $this->db->where('a.Status = 5');
        $this->db->where('a.DeletionStatus = 0');
        $query = $this->db->get();
        $data['result'] = $query->result();
        $data['rows'] = $query->num_rows();
        return $data;
    }

    public function getAllApplicantjoinedlist() {
        $this->db->select('a.*')->from('tbl_applicant AS a');
        $this->db->select('c.salary')->from('tbl_circular AS c');
        $this->db->select('p.name AS post_name')->from('taxonomy AS p');
        $this->db->select('d.name AS division_name')->from('taxonomy AS d');
        $this->db->where('a.CircularID = c.CircularID');
        $this->db->where('c.PostID = p.tid');
        $this->db->where('c.DivisionID = d.tid');
        $this->db->where('a.Status = 6');
        $this->db->where('a.DeletionStatus = 0');
        $query = $this->db->get();
        $data['result'] = $query->result();
        $data['rows'] = $query->num_rows();
        return $data;
    }
 
    public function update_applicant_status_info($id, $data) {
        $this->db->where("ApplicantID", $id);
        $this->db->update('tbl_applicant', $data);
    }

}

?>