<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
/**
 * Description of ChallanController
 *
 * @author Mohammad Omar Faruk Sajeeb Mridha
 * Created at : 1 September 2019
 */
class ChallanController extends CI_Controller{
    function __construct() {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model("challan_model");
    }
    public function manageChallan(){
        $this->check_permission_controller->check_permission_action("view_challan");
		$data['title'] = 'Manage Challan';
        $data['challan_info'] = $this->challan_model->getChallanInfo();
        $userType = $this->session->userdata('user_type');
        $userId = $this->session->userdata('user_id');
        $userDivision = $this->session->userdata('user_division');
        $userDepartment = $this->session->userdata('user_department');       
        if($userType==1){
            $data['employees']=$this->search_field_emp_model->getAllEmployees();
        }else{
             if (!$userDepartment) {
                $data['employees'] = $this->search_field_emp_model->getEmployeeByDivision($userDivision);
            } else {
                $data['employees'] = $this->search_field_emp_model->getEmployeeByDivisionAndDepartment($userDivision, $userDepartment);
            }
        }
//        print_r($data);
        $this->load->view('challan/manage-challan',$data);
    }
   public function empInfoById(){
        $id = $this->input->post('id');
//        echo $id;
//        exit;
        $data['emp_info'] = $this->search_field_emp_model->getEmployeeInfoById($id);
//        
//        print_r($data['emp_info']);
//        exit;
        $output = null;
        foreach ($data AS $row) {
            //here we build a dropdown item line for each 
            $return_arr[] = array("id" => $row->id,
                    "emp_tin" => $row->tin,                    
                    );
        }
        echo json_encode($data['emp_info']);
        //  print_r($output);
        //exit();
    }
    public function addChallan(){
        if($this->input->post('save_challan')){
            //$this->check_permission_controller->check_permission_action("add_purchase");
            $this->form_validation->set_rules('challan_no', 'Challan No ', 'required');
            if($this->form_validation->run()==FALSE)
            {
                $this->session->set_flashdata('errors', validation_errors());            
                redirect('manage-challan');
            }
            $postData = $this->input->post();
            $res = $this->challan_model->insertChallanInfo($postData);
             if ($res == true) {
                $this->session->set_flashdata('success', "Challan Inserted successfully. ");
            } else {
                $this->session->set_flashdata('errors', "Challan not inserted!");
            }
        }
        if($this->uri->segment(2)){
            $data['vendor_id'] = $this->uri->segment(2);
        }
        redirect('manage-challan');
    }
    public function getChallanDetailById() {
        $id = $this->input->post('challan_id');      
        $data['challan_id'] = $id;
        $data['challanInfo'] = $this->challan_model->getChallanData($id);
        $data['challanDetailInfo'] = $this->challan_model->getChallanDetailData($id);
        $this->load->view("challan/challan-detail", $data);
    }
    public function deleteChallan($id) {            
            $this->db->query("DELETE FROM tbl_challan_detail WHERE challan_id=$id");
            $result = $this->db->query("DELETE FROM tbl_challan WHERE id=$id");
            if ($result == true) {
                $this->session->set_flashdata('success', "Challan deleted successfully. ");
            } else {
                $this->session->set_flashdata('errors', "Challan not deleted!");
            }

        redirect('manage-challan');
    }
    
   public function updateChallanData(){
        $columnName = $this->input->post('name');
        $newValue = $this->input->post('value');
        $contentId = $this->input->post('pk');
        // Edit ----------------------------------
            $this->db->set($columnName, $newValue);
            $this->db->set('updated_at', $this->current_time());
            $this->db->set('updated_by', $this->session->userdata('user_id'));
            $this->db->where('id', $contentId);
            $result = $this->db->update('tbl_challan');
    }
    
    public function updateChallanDetailData(){
        $columnName = $this->input->post('name');
        $newValue = $this->input->post('value');
        $contentId = $this->input->post('pk');
        if($columnName=='year'){
            $month = date("m", strtotime($newValue));
            $year = date("Y", strtotime($newValue));
             $this->db->set("month", $month);
             $this->db->set("year", $year);
        }else if($columnName=='amount'){
            $challanDetailInfo = $this->db->query("SELECT * FROM tbl_challan_detail WHERE id=$contentId")->row();
            $oldAmount = $challanDetailInfo->amount;
            $challanId = $challanDetailInfo->challan_id;
             if($newValue>$oldAmount){ 
                $addAmt = $newValue-$oldAmount;
                $newValue = $oldAmount+$addAmt;
                $this->db->set($columnName, $newValue);
                $this->db->query("UPDATE tbl_challan SET total=total+$addAmt WHERE id=$challanId");
            }else if($newValue<$oldAmount){
                $minusAmt = $oldAmount-$minusAmt;
                $newValue = $oldAmount-$addAmt;
                $this->db->set($columnName, $newValue);
                $this->db->query("UPDATE tbl_challan SET total=total-$minusAmt WHERE id=$challanId");
            }
        }else{
            $this->db->set($columnName, $newValue);
        }
         
//            $this->db->set('updated_at', $this->current_time());
//            $this->db->set('updated_by', $this->session->userdata('user_id'));
            $this->db->where('id', $contentId);
            $result = $this->db->update('tbl_challan_detail');
    }
    
        public function current_time() {
        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
        $current_time = $dt->format('Y-m-d H:i:s');
        return $current_time;
    }
}
