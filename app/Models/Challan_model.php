<?php

/**
 * Description of Challan_model
 *
 * @author Mohammad Omar Faruk Sajeeb Mridha
 */
class Challan_model extends CI_Model {
    
    function getChallanInfo(){
        return $this->db->query("SELECT * FROM tbl_challan")->result();
    }
    public function insertChallanInfo($postData){
        $challanData = array(
            'challan_date' => date('Y-m-d', strtotime($postData['challan_date'])),
            'challan_no' => $postData['challan_no'],
            'dipositor' => $postData['dipositor'],
            'total' => $postData['total'],
            'note' => $postData['note'],
            'created_at' => $this->currentTime(),
            'created_by' => $this->session->userdata('user_id')
        );
        $this->db->insert("tbl_challan",$challanData);
        
        $insertedChallanId = $this->db->insert_id();       
        $empId = $postData['grid_emp_name'];
        
        for ($i = 0; $i < count($empId); $i++) {
            $contentId = $postData['grid_emp_name'][$i];
            $empInfo = $this->search_field_emp_model->getEmployeeInfoById($contentId);
            $challanMonth = $postData['challan_month'][$i];
            $month = date("m", strtotime($challanMonth));
            $year = date("Y", strtotime($challanMonth));
            $sdata[] = array(
                'challan_id' => $insertedChallanId,
                'tin' => $postData['grid_emp_tin'][$i],
                'content_id' => $contentId,
                'emp_id' => $empInfo->emp_id,
                'company_id' => $empInfo->emp_division,
                'division_id' => $empInfo->emp_department,
                'department_id' => $empInfo->department_id,
                'designation_id' => $empInfo->emp_post_id,
                'month' => $month,
                'year' => $year,
                'amount' => $postData['grid_amount'][$i],
            );
        }
        return $this->db->insert_batch('tbl_challan_detail', $sdata);
        
    }
    public function getChallanData($id){
        return $this->db->query("SELECT * FROM tbl_challan WHERE id=$id")->row();
    }
    public function getChallanDetailData($id){
        return $this->db->query("SELECT cd.*,m.month_name,sfe.emp_name FROM tbl_challan_detail AS cd "
                . "LEFT JOIN search_field_emp AS sfe ON sfe.content_id=cd.content_id "
                . "LEFT JOIN tbl_month AS m ON m.month_id=cd.month WHERE cd.challan_id=$id")->result();
    }
    public function getChallanInfoByEmp($content_id,$salaryFromMonthId,$salaryFromYear,$salaryToMonthId,$salaryToYear){
        return $this->db->query("SELECT cd.*,c.challan_no,c.challan_date,m.month_name FROM tbl_challan_detail AS cd "
                . "LEFT JOIN tbl_challan AS c ON c.id=cd.challan_id "
                . "LEFT JOIN tbl_month AS m ON m.month_id=cd.month "
                . "WHERE cd.content_id=$content_id "
                . "AND (cd.year > $salaryFromYear OR (cd.year = $salaryFromYear AND cd.month >= $salaryFromMonthId)) "
                . "AND (cd.year < $salaryToYear OR (cd.year = $salaryToYear AND cd.month <= $salaryToMonthId))")->result();
    }
        public function currentTime() {
        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
        $current_time = $dt->format('Y-m-d H:i:s');
        return $current_time;
    }
    public function currentDate() {
        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
        $currentDate = $dt->format('Y-m-d');
        return $currentDate;
    } 
}
