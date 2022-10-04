<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
/**
 * Description of SalesController
 *
 * @author Mohammad Omar Faruk Sajeeb
 */
class SalesController extends CI_Controller {
    function __construct() {
        error_reporting(0);
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('SalesModel');
    }
    public function addSales(){
        if($this->input->post('save_btn')){
            //$this->check_permission_controller->check_permission_action("add_purchase");
            $this->form_validation->set_rules('consumer_name', 'Consumer Name', 'required');
            if($this->form_validation->run()==FALSE)
            {
                $this->session->set_flashdata('errors', validation_errors());            
                redirect('add-sales');
            }
            $postData = $this->input->post();
            $res = $this->SalesModel->insertSalesInfo($postData);
            if($res){  
                $msg = "<script>alert('Order sent successfully!')</script>";
            }else{
                $msg = "<script>alert('Order not sent. Something wrong!')</script>";
            }
            $data['msg']=$msg;
        }
        if($this->uri->segment(2)){
            $data['vendor_id'] = $this->uri->segment(2);
        }
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        if ($user_type == 8) {            
            $data['consumers'] = $this->search_field_emp_model->getallemployee();
           
        } else {
            $emp_ids_data = $this->users_model->getpermittedemployee($user_id);
            $content_ids = $emp_ids_data['emp_content_ids'];
            if ($user_id == 16 || $user_id == 36) {
                $data['consumers'] = $this->search_field_emp_model->getallemployee();
            } else {
                $data['consumers'] = $this->search_field_emp_model->getallsearch_table_contentByids($content_ids);
            }
        }
        //$data['consumers'] = $this->SalesModel->getPublishConsumer();
        $data['items'] = $this->SalesModel->getPublishItem();
        $this->load->view('store/sales/add-sales',$data);
    }
    public function manageSales(){   
        $data['salesItems']=$this->SalesModel->getAllSales();
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('store/sales/manage-sales',$data);
    }
   public function salesInvoice($id) {
        // echo $id; exit;
        $this->load->library("pdf");
        $mpdf = $this->pdf->load();

        $data['salesInfo'] = $this->SalesModel->getSalesData($id);
        $data['salesDetailInfo'] = $this->SalesModel->getSalesDetailData($id);
        $html = $this->load->view('store/sales/sales-invoice', $data, true);
        // $mpdf->SetProtection(array('print'), 'pass2open', 'pass2havefullaccess');
        // $mpdf->SetVisibility('screenonly'); 
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetVisibility('hidden');
        // $mpdf->SetProtection(array('copy','print','modify'), 'r', 'MyPassword');
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output();
    }
    public function saveDeliveredProduct(){
        $postData = $this->input->post();  
        $updateData = array(
                'received_by' => $postData['received_by'],
                'updated_at' => $this->currentTime(),
                'updated_by' => $this->session->user_id
            );
            $updateCondition = array('id' => $postData['sales_id']);
            $result = $this->SalesModel->updateSalesStatus($updateData, $updateCondition);
            $res = $this->SalesModel->updateSalesDeliveredData($postData);
            if($res==true){  
                // $this->session->set_flashdata('success', "Product received successfully.");
            }else{
                 $this->session->set_flashdata('error', "Not Deleivered! Something wrong.");
            }
       
        redirect('manage-sales');
    }
    public function saveSalesReturnProduct(){
        $postData = $this->input->post();  
        $updateData = array(
                'updated_at' => $this->currentTime(),
                'updated_by' => $this->session->user_id
            );
            $updateCondition = array('id' => $postData['sales_id']);
            $result = $this->SalesModel->updateSalesStatus($updateData, $updateCondition);
            $res = $this->SalesModel->updateSalesReturnData($postData);
            if($res==true){  
                 $this->session->set_flashdata('success', "Issued Item Returned successfully.");
            }else{
                 $this->session->set_flashdata('error', "Not Returned! Something wrong.");
            }
       
        redirect('manage-sales');
    }
    
    public function cancelSales($id){
            $updateData = array(
                'status' => -1,
                'updated_at' => $this->currentTime(),
                'updated_by' => $this->session->user_id
            );
            $updateCondition = array('id' => $id);
            $result = $this->SalesModel->updateSalesStatus($updateData, $updateCondition);
            if ($result == true) {
                $this->session->set_flashdata('success', "Canceled successfully.  ");
            } else {
                $this->session->set_flashdata('error', "Not Canceled!");
            }

            redirect('manage-sales');
    }
    public function restoreSales($id){
            $updateData = array(
                'status' => 0,
                'updated_at' => $this->currentTime(),
                'updated_by' => $this->session->user_id
            );
            $updateCondition = array('id' => $id);
            $result = $this->SalesModel->updateSalesStatus($updateData, $updateCondition);
            if ($result == true) {
                $this->session->set_flashdata('success', "Order restore successfully.  ");
            } else {
                $this->session->set_flashdata('error', "Not Restored!");
            }

            redirect('manage-sales');
    }
    public function deleteDeliveredSales($id){
        $delId = $this->uri->segment(2);
        $salesDetailId = $this->uri->segment(3);
        $itemId = $this->uri->segment(4);
        $delQty = $this->uri->segment(5);
        $result = $this->SalesModel->deleteDeliveredSalesById($delId,$salesDetailId,$itemId,$delQty);
        if ($result == true) {
            $this->session->set_flashdata('success', "Delivery Info deleted successfully. ");
        } else {
            $this->session->set_flashdata('errors', "Delivery Info not deleted!");
        }

        redirect('delivered-sales');
    }
   public function deleteSalesReturns($id){
        $delId = $this->uri->segment(2);
        $salesDetailId = $this->uri->segment(3);
        $itemId = $this->uri->segment(4);
        $returnedQty = $this->uri->segment(5);
        $result = $this->SalesModel->deleteSalesReturnById($delId,$salesDetailId,$itemId,$returnedQty);
        if ($result == true) {
            $this->session->set_flashdata('success', "Return Issued Info deleted successfully. ");
        } else {
            $this->session->set_flashdata('errors', "Return Issued Info not deleted!");
        }

        redirect('returned-sales');
    }
    public function deleteSales($id) {
            $salesInfo = $this->SalesModel->getSalesData($id);
            $salesDetailInfo = $this->SalesModel->getSalesDetailData($id);
            foreach($salesDetailInfo as $singleSalesDetInfo){
                $salesDetailId = $singleSalesDetInfo->id;
                $salesDelInfo = $this->db->query("SELECT * FROM str_sales_delivered WHERE sales_detail_id=$salesDetailId ")->result();
                foreach($salesDelInfo as $singleSalesDelInfo){
                    $delId = $singleSalesDelInfo->id;
                    $salesDetailId = $singleSalesDelInfo->sales_detail_id;
                    $itemId = $singleSalesDelInfo->item_id;
                    $delQty = $singleSalesDelInfo->delivered_qty;
                    $result = $this->SalesModel->deleteDeliveredSalesById($delId,$salesDetailId,$itemId,$delQty);
                }
                $salesReturnInfo = $this->db->query("SELECT * FROM str_sales_return WHERE sales_detail_id=$salesDetailId ")->result();
                foreach($salesReturnInfo as $singleSalesReturnInfo){
                    $retDelId = $singleSalesReturnInfo->id;
                    $retSalesDetailId = $singleSalesReturnInfo->sales_detail_id;
                    $retItemId = $singleSalesReturnInfo->item_id;
                    $retQty = $singleSalesReturnInfo->returned_qty;
                    $result = $this->SalesModel->deleteReturnSalesById($retDelId,$retSalesDetailId,$retItemId,$retQty);
                }
            }
            
            /*
            $salesPaymentInfo = $this->db->query("SELECT * FROM str_sales_payment WHERE sales_id=$id")->result();
            foreach($salesPaymentInfo as $singleSalesPaymentInfo){
                $paymentId = $singleSalesPaymentInfo->id;
                $accountId = $singleSalesPaymentInfo->account_id;
                $amount = $singleSalesPaymentInfo->amount;
                $this->db->query("DELETE FROM tbl_transactions WHERE AccountID=$accountId AND TTypeID=1 AND CategoryID=1 AND Ref='$paymentId' ");
                $this->db->query("UPDATE tbl_accounts SET balance=balance-$amount WHERE ID=$accountId");             
            }            
            $this->db->query("DELETE FROM str_sales_payment WHERE sales_id=$id");            
            */
            
            $this->db->query("DELETE FROM str_sales_details WHERE sales_id=$id");
            $result = $this->db->query("DELETE FROM str_sales WHERE id=$id");
            if ($result == true) {
                $this->session->set_flashdata('success', "Item Order deleted successfully. ");
            } else {
                $this->session->set_flashdata('errors', "Item Order not deleted!");
            }
        redirect('manage-sales');
    }
    public function getSalesDetailById(){
        $id = $this->input->post('sales_id');
        $data['salesInfo'] = $this->SalesModel->getSalesData($id);
        $data['salesDetailInfo'] = $this->SalesModel->getSalesDetailData($id);
        $this->load->view("store/sales/sales-detail", $data);
    }
    public function deliveredSalesList(){   
        $data['salesItems']=$this->SalesModel->getAllDeliveredSales();
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('store/sales/delivered-sales',$data);
    }
    public function returnedSalesList(){   
        $data['returnItems']=$this->SalesModel->getAllReturnedSales();
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('store/sales/sales-returns',$data);
    }
     public function getSalesOrderDetailById() {
        $id = $this->input->post('sales_id');
      
        $data['sales_id'] = $id;
        $data['salesInfo'] = $this->SalesModel->getSalesData($id);
        $data['salesDetailInfo'] = $this->SalesModel->getSalesDetailData($id);
        $this->load->view("store/sales/delivered-sales-modal-inline", $data);
    }
   public function returnSalesItemById() {
        $id = $this->input->post('sales_id');
      
        $data['sales_id'] = $id;
        $data['salesInfo'] = $this->SalesModel->getSalesData($id);
        $data['salesDetailInfo'] = $this->SalesModel->getSalesDetailData($id);
        $this->load->view("store/sales/return-sales-modal-inline", $data);
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
