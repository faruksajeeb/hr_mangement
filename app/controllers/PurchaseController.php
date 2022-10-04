<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Description of PurchaseController
 *
 * @author  Mohammad Omar Faruk Sajeeb
 */
class PurchaseController extends CI_Controller {
    //put your code here
    function __construct() {
        error_reporting(0);
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('PurchaseModel');
    }
    public function managePurchase(){
       if($this->input->post('save_changes')){           
       }
       if ($this->input->post('payment_btn')) {
            $paymentData = $this->input->post();
            $purchaseId = $paymentData['payment_purchase_id'];
            $amount = $paymentData['amount'];
            $dueAmount = $paymentData['due_amount'];
            $paidAmount = $paymentData['paid_amount'];
            $accountId = $paymentData['account_id'];
            if ($amount > $dueAmount) {
                $this->session->set_flashdata('error', "Amount not valid!");
                redirect('manage-purchase');
            } else {         

                $paymentData = array(
                    'purchase_id' => $purchaseId,
                    'account_id' => $accountId,
                    'payment_date' => date('Y-m-d', strtotime($paymentData['payment_date'])),
                    'amount' => $amount,
                    'created_at' => $this->currentTime(),
                    'created_by' => $this->session->userdata('user_id')
                );
                $paymentId = $this->PurchaseModel->insertPurchasePaymentData($paymentData);
                if ($paymentId == true) {
                    $transactionData = array(
                        'TransDate' => date('Y-m-d', strtotime($paymentData['payment_date'])),
                        'AccountID' => $accountId,
                        'TTypeID' => 2,
                        'CategoryID' => 52, //Printing & Stationary
                        'Amount' => $amount,
                        'Dr' => $amount,
                        'Ref' => $paymentId,
                        'CreatedAt' => $this->currentTime(),
                        'CreatedBy' => $this->session->userdata('user_id')
                    );
                    $this->PurchaseModel->insertPaymentTransData($transactionData);
                    $this->PurchaseModel->updateAccountBalance($accountId, $amount);

                    // update payslip paid amount and status -----------------------
                    $paidAmount = $paidAmount + $amount;
                    $balance = $dueAmount-$amount;
                    if ($dueAmount == $amount) {
                        //$status = 3;
                    } else if ($amount < $dueAmount) {
                       // $status = 2;
                    }
                    $updateData = array(
                        'paid_amount' => $paidAmount,
                        'balance' => $balance,
                       // 'status' => $status,
                        'updated_at' => $this->currentTime(),
                        'updated_by' => $user_id
                    );
                    $updateCondition = array('id' => $purchaseId);
                    $this->PurchaseModel->updatePurchaseData($updateData, $updateCondition);
                    $this->session->set_flashdata('success', "Payment completed successfully.");
                } else {
                    $this->session->set_flashdata('error', "Payment not completed!");
                }
                redirect('manage-purchase');
            }
        }
        
        $data['accounts'] = $this->PurchaseModel->getAccounts();
        $data['purchaseItems']=$this->PurchaseModel->getAllPurchase();
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('store/purchase/manage-purchase',$data);
    }
    public function addPurchase(){
        if($this->input->post('save_btn')){
            //$this->check_permission_controller->check_permission_action("add_purchase");
            $this->form_validation->set_rules('supplier_name', 'Supplier Name', 'required');
            if($this->form_validation->run()==FALSE)
            {
                $this->session->set_flashdata('errors', validation_errors());            
                redirect('add-purchase');
            }
            $postData = $this->input->post();
            $res = $this->PurchaseModel->insertPurchaseInfo($postData);
            if($res){  
                $msg = "<script>alert('Purchase inserted successfully!')</script>";
            }else{
                $msg = "<script>alert('Data not inserted. Something wrong!')</script>";
            }
            $data['msg']=$msg;
        }
        if($this->uri->segment(2)){
            $data['vendor_id'] = $this->uri->segment(2);
        }
        $data['vendors'] = $this->PurchaseModel->getPublishVendor();
        $data['items'] = $this->PurchaseModel->getPublishItem();
        $this->load->view('store/purchase/add-purchase',$data);
    }
     public function getPurchaseDetailById() {
        $id = $this->input->post('purchase_id');
      
        $data['purchase_id'] = $id;
        $data['purchaseInfo'] = $this->PurchaseModel->getPurchaseData($id);
        $data['purchaseDetailInfo'] = $this->PurchaseModel->getPurchaseDetailData($id);
        $data['returnDetailInfo'] = $this->PurchaseModel->getReturnDetailData($id);
//        print_r($data);
//        exit;
        $this->load->view("store/purchase/purchase-detail", $data);
    }
    public function getOrderDetailById() {
        $id = $this->input->post('purchase_id');
      
        $data['purchase_id'] = $id;
        $data['purchaseInfo'] = $this->PurchaseModel->getPurchaseData($id);
        $data['purchaseDetailInfo'] = $this->PurchaseModel->getPurchaseDetailData($id);
       // echo $data;
//        print_r($data);
    
        $this->load->view("store/purchase/receive-product-form", $data);
    }
    public function getOrderDetailById2() {
        $id = $this->input->post('purchase_id');
      
        $data['purchase_id'] = $id;
        $data['purchaseInfo'] = $this->PurchaseModel->getPurchaseData($id);
        $data['purchaseDetailInfo'] = $this->PurchaseModel->getPurchaseDetailData($id);
       // echo $data;
//        print_r($data);
    
        $this->load->view("store/purchase/return-product-form", $data);
    }
    public function itemInfoById(){
        $id = $this->input->post('id');
        $data = Array(
            'item_info' => $this->PurchaseModel->selectItemInfoById($id)
        );
//         print_r($data['item_info']);
//        exit();
        $output = null;
        foreach ($data AS $row) {
            //here we build a dropdown item line for each 
            $return_arr[] = array("id" => $row->id,
                    "current_price" => $row->current_price,                    
                    );
        }
        echo json_encode($data['item_info']);
        //  print_r($output);
        //exit();
    }
        public function currentTime() {
        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
        $current_time = $dt->format('Y-m-d H:i:s');
        return $current_time;
    }
    public function getPaymentDetailByPurchaseId() {
        $id = $this->input->post('payment_id');
        $sdata['payment_id'] = $id;
        $sdata['purchaseInfo'] = $this->PurchaseModel->getPurchaseData($id);
        $sdata['paymentDetailInfo'] = $this->PurchaseModel->getPaymentDetailData($id);
        $this->load->view("store/purchase/payment-detail", $sdata);
    }
    public function purchaseInvoice($id) {
        // echo $id; exit;
        $this->load->library("pdf");
        $mpdf = $this->pdf->load();

        $data['purchaseInfo'] = $this->PurchaseModel->getPurchaseData($id);
        $data['purchaseDetailInfo'] = $this->PurchaseModel->getPurchaseDetailData($id);
        $data['returnDetailInfo'] = $this->PurchaseModel->getReturnDetailData($id);
        $html = $this->load->view('store/purchase/purchase-invoice', $data, true);
        // $mpdf->SetProtection(array('print'), 'pass2open', 'pass2havefullaccess');
        // $mpdf->SetVisibility('screenonly'); 
        $mpdf->SetVisibility('printonly'); // This will be my code; 
        // $mpdf->SetVisibility('hidden');
        // $mpdf->SetProtection(array('copy','print','modify'), 'r', 'MyPassword');
        $mpdf->SetJS('this.print();');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output();
    }
    public function saveReceiveProduct(){
        $postData = $this->input->post();   
        $res = $this->PurchaseModel->updatePurchaseReceivedData($postData);
            if($res==true){  
                // $this->session->set_flashdata('success', "Product received successfully.");
            }else{
                 $this->session->set_flashdata('error', "Not Received! Something wrong.");
            }
       
        redirect('manage-purchase');
    }
    public function saveReturnProduct(){
        $postData = $this->input->post();   
        $res = $this->PurchaseModel->updatePurchaseReturnData($postData);
            if($res==true){  
                // $this->session->set_flashdata('success', "Product received successfully.");
            }else{
                 $this->session->set_flashdata('error', "Not Returned! Something went wrong.");
            }       
        redirect('manage-purchase');
    }
    public function receivedProduct(){
        $data['received_products'] = $this->PurchaseModel->getReceivedProduct();
        $this->load->view("store/purchase/received-product",$data);
    }
    public function returnProduct(){
        $data['returned_products'] = $this->PurchaseModel->getReturnProduct();
        $this->load->view("store/purchase/return-product",$data);
    }
    public function deleteReceivedPurchase($id){
        $delId = $this->uri->segment(2);
        $purchaseDetailId = $this->uri->segment(3);
        $itemId = $this->uri->segment(4);
        $recQty = $this->uri->segment(5);
        $result = $this->PurchaseModel->deleteReceivePurchaseById($delId,$purchaseDetailId,$itemId,$recQty);
        if ($result == true) {
            $this->session->set_flashdata('success', "Received purchase deleted successfully. ");
        } else {
            $this->session->set_flashdata('errors', "Received purchase not deleted!");
        }

        redirect('received-product');
    }
    public function deleteReturnedPurchase($id){
        $delId = $this->uri->segment(2);
        $purchaseDetailId = $this->uri->segment(3);
        $itemId = $this->uri->segment(4);
        $retQty = $this->uri->segment(5);
        $result = $this->PurchaseModel->deleteReturnPurchaseById($delId,$purchaseDetailId,$itemId,$retQty);
        if ($result == true) {
            $this->session->set_flashdata('success', "Return purchase deleted successfully. ");
        } else {
            $this->session->set_flashdata('errors', "Return purchase not deleted!");
        }

        redirect('return-product');
    }
    public function deletePurchase($id) {
            $purchaseInfo = $this->db->query("SELECT * FROM str_purchases WHERE id=$id")->row();
            $purchaseDetailInfo = $this->db->query("SELECT * FROM str_purchase_details WHERE purchase_id=$id")->result();
            foreach($purchaseDetailInfo as $singlePurDetInfo){
                $purDetailId = $singlePurDetInfo->id;
                $purchaseRecInfo = $this->db->query("SELECT * FROM str_purchase_receive WHERE purchase_detail_id=$purDetailId ")->result();
                foreach($purchaseRecInfo as $singlePurchaseRecInfo){
                    $delId = $singlePurchaseRecInfo->id;
                    $purchaseDetailId = $singlePurchaseRecInfo->purchase_detail_id;
                    $itemId = $singlePurchaseRecInfo->item_id;
                    $recQty = $singlePurchaseRecInfo->received_qty;
                    $result = $this->PurchaseModel->deleteReceivePurchaseById($delId,$purchaseDetailId,$itemId,$recQty);
                }
                $purchaseReturnInfo = $this->db->query("SELECT * FROM str_purchase_return WHERE purchase_detail_id=$purDetailId ")->result();
                foreach($purchaseReturnInfo as $singlePurchaseReturnInfo){
                    $retDelId = $singlePurchaseReturnInfo->id;
                    $retPurchaseDetailId = $singlePurchaseReturnInfo->purchase_detail_id;
                    $retItemId = $singlePurchaseReturnInfo->item_id;
                    $retQty = $singlePurchaseReturnInfo->returned_qty;
                    $result = $this->PurchaseModel->deleteReturnPurchaseById($retDelId,$retPurchaseDetailId,$retItemId,$retQty);
                }
            }
            $purchasePaymentInfo = $this->db->query("SELECT * FROM str_purchase_payment WHERE purchase_id=$id")->result();
            foreach($purchasePaymentInfo as $singlePurchasePaymentInfo){
                $paymentId = $singlePurchasePaymentInfo->id;
                $accountId = $singlePurchasePaymentInfo->account_id;
                $amount = $singlePurchasePaymentInfo->amount;
                $this->db->query("DELETE FROM tbl_transactions WHERE AccountID=$accountId AND TTypeID=2 AND CategoryID=52 AND Ref='$paymentId' ");
                $this->db->query("UPDATE tbl_accounts SET balance=balance+$amount WHERE ID=$accountId");             
            }
            $this->db->query("DELETE FROM str_purchase_payment WHERE purchase_id=$id");
            $this->db->query("DELETE FROM str_purchase_details WHERE purchase_id=$id");
            $result = $this->db->query("DELETE FROM str_purchases WHERE id=$id");
            if ($result == true) {
                $this->session->set_flashdata('success', "Purchase deleted successfully. ");
            } else {
                $this->session->set_flashdata('errors', "Purchase not deleted!");
            }

        redirect('manage-purchase');
    }
}
