<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PurchaseModel
 *
 * @author Md. Omar Faruk
 */
class PurchaseModel extends CI_Model {
    //put your code here
    public function getPublishItem(){
        return $this->db->query("SELECT * FROM str_items WHERE status=1 ORDER BY item_name ASC")->result();
    }
    public function getPublishVendor(){
        return $this->db->query("SELECT * FROM str_suppliers WHERE status=1 ORDER BY supplier_name ASC")->result();
    }
     public function selectItemInfoById($id) {
        $this->db->select('*');
        $this->db->from('str_items');     
        $this->db->where('id', $id);  
        $query = $this->db->get();
        $result = $query->row();
//              print_r($result);
//       exit();
        return $result;
    }
    public function getAllPurchase(){        
        return $this->db->query("SELECT p.*,s.supplier_name,s.contact_person FROM str_purchases AS p LEFT JOIN str_suppliers AS s ON s.id=p.supplier_id ORDER BY id DESC")->result();
    }
    public function getReceivedProduct(){        
        return $this->db->query("SELECT pr.*,pd.purchase_id,i.item_name,s.supplier_name,u.name as received_by_name FROM str_purchase_receive as pr LEFT JOIN str_items as i ON i.id=pr.item_id LEFT JOIN str_purchase_details as pd ON pd.id=pr.purchase_detail_id LEFT JOIN str_purchases as p ON p.id=pd.purchase_id LEFT JOIN str_suppliers as s ON s.id=p.supplier_id LEFT JOIN users as u ON u.id=pr.received_by ORDER BY pr.id DESC")->result();
    }
    public function getReturnProduct(){        
        return $this->db->query("SELECT pr.*,pd.purchase_id,i.item_name,s.supplier_name,u.name as returned_by_name FROM str_purchase_return as pr LEFT JOIN str_items as i ON i.id=pr.item_id LEFT JOIN str_purchase_details as pd ON pd.id=pr.purchase_detail_id LEFT JOIN str_purchases as p ON p.id=pd.purchase_id LEFT JOIN str_suppliers as s ON s.id=p.supplier_id LEFT JOIN users as u ON u.id=pr.returned_by ORDER BY pr.id DESC")->result();
    }
    public function insertPurchaseInfo($postData){
        
        $paidAmount = $postData['paid_amount'];
        $paramsData = array(
            'purchase_date' => date('Y-m-d', strtotime($postData['purchase_date'])),
            'supplier_id' => $postData['supplier_name'],
            'delevired_by' => $postData['deliverd_by'],
            'sub_total' => $postData['sub_total'],
            'vat' => $postData['vat_percentage'],
            'grand_total' => $postData['grand_total'],
            'paid_amount' => $postData['paid_amount'],
            'balance' => $postData['due_amount'],
            'note' => $postData['note'],
            'created_at' => $this->currentTime(),
            'created_by' => $this->session->userdata('user_id')
        );
        $this->db->insert("str_purchases",$paramsData);
        
        $insertedPurchaseId = $this->db->insert_id();
        if($paidAmount>0 && $insertedPurchaseId){
            $paymentData = array(
                    'purchase_id' => $insertedPurchaseId,
                    'account_id' => 1,
                    'payment_date' => date('Y-m-d', strtotime($postData['purchase_date'])),
                    'amount' => $paidAmount,
                    'created_at' => $this->currentTime(),
                    'created_by' => $this->session->userdata('user_id')
                );
            $paymentId = $this->db->insert("str_purchase_payment",$paymentData);            
            $transactionData = array(
                'TransDate' => date('Y-m-d', strtotime($postData['purchase_date'])),
                'AccountID' => 1,
                'TTypeID' => 2,
                'CategoryID' => 52, //Printing & Stationary
                'Amount' => $paidAmount,
                'Dr' => $paidAmount,
                'Ref' => $paymentId,
                'CreatedAt' => $this->currentTime(),
                'CreatedBy' => $this->session->userdata('user_id')
            );
            $this->insertPaymentTransData($transactionData);
            $this->updateAccountBalance(1, $paidAmount);
            
        }
        $itemId = $postData['grid_item_name'];
        
        for ($i = 0; $i < count($itemId); $i++) {

            $sdata[] = array(
                'purchase_id' => $insertedPurchaseId,
                'item_id' => $itemId[$i],
                'mfg_date' => $postData['mfg_date'][$i],
                'exp_date' => $postData['exp_date'][$i],
                'number_of_pack' => $postData['number_of_pack'][$i],
                'qty_per_pack' => $postData['qty_per_pack'][$i],
                'total_qty' => $postData['total_qty'][$i],
                'rate' => $postData['item_price'][$i],
                'amount' => $postData['amount'][$i],
            );
        }
        return $this->db->insert_batch('str_purchase_details', $sdata);
        
    }
    public function insertPurchasePaymentData($paramsData){
        $this->db->insert("str_purchase_payment",$paramsData);
        $paymentId = $this->db->insert_id();
        return $paymentId;
    }
    public function updatePurchaseData($data = array(),$where = array()){
        $this->db->where($where);
        $this->db->update('str_purchases', $data);
        return true;
    }
    public function getPurchaseData($id){
        return $this->db->query("SELECT p.*,s.supplier_name,s.contact_person,s.address,s.phone,s.email FROM str_purchases AS p "
                . "LEFT JOIN str_suppliers AS s ON s.id=p.supplier_id "
                . "WHERE p.id=$id")->row();
    }
    public function getPurchaseDetailData($id){
        return $this->db->query("SELECT pd.*,i.item_name FROM str_purchase_details AS pd "
                . "LEFT JOIN str_items AS i ON i.id=pd.item_id "
                . "WHERE pd.purchase_id=$id")->result();
    }
    public function getReturnDetailData($id){
        return $this->db->query("SELECT pr.*,i.item_name,pd.rate FROM str_purchase_return AS pr "
                . "LEFT JOIN str_items AS i ON i.id=pr.item_id "
                . "LEFT JOIN str_purchase_details AS pd ON pd.id=pr.purchase_detail_id "
                . "WHERE pd.purchase_id=$id")->result();
    }
    public function insertPaymentTransData($paramsData){
        return $this->db->insert("tbl_transactions",$paramsData);
    }
    public function updateAccountBalance($accountId,$amount){
        $query="UPDATE tbl_accounts SET Balance=Balance-$amount WHERE ID=$accountId ";
        $this->db->query($query);
        return true;
    }
    public function getAccounts(){
        return $this->db->query("SELECT * FROM tbl_accounts WHERE Status=1 ORDER BY SerialOrder")->result();
    }
        public function getPaymentDetailData($id){
        return $this->db->query("SELECT * FROM str_purchase_payment WHERE purchase_id=$id ")->result();
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
    public function getPurchaseDetailDataById($id){
        return $this->db->query("SELECT pd.*,i.item_name,i.current_qty FROM str_purchase_details AS pd "
                . "LEFT JOIN str_items AS i ON i.id=pd.item_id "
                . "WHERE pd.id=$id")->row();
    }
    
    public function updatePurchaseReceivedData($postData){
        $recItems = $postData['purchase_detail_id'];
        for ($i = 0; $i < count($recItems); $i++) {
            $newReceivedQty = $postData['receive_qty'][$i];
            $itemId = $postData['item_id'][$i];
            if($newReceivedQty > 0){
                $purchaseDetailData = $this->getPurchaseDetailDataById($postData['purchase_detail_id'][$i]);               
                $totalQty = $purchaseDetailData->total_qty;
                $receivedQty = $purchaseDetailData->received_qty;
                $totalReceived = $receivedQty+$newReceivedQty;
                if($totalReceived > $totalQty){
                    // Higher than purchase qty
                    $this->session->set_flashdata('error', "$purchaseDetailData->item_name received qty Higher than purchase qty.");
                }else{
                  $this->db->query("UPDATE str_purchase_details SET received_qty=received_qty+$newReceivedQty WHERE id=$recItems[$i]");
                  $this->db->query("UPDATE str_items SET current_qty=current_qty+$newReceivedQty WHERE id=$itemId");              
                  $insertData = array(
                    'receive_date' => $this->currentDate(),
                    'purchase_detail_id' => $postData['purchase_detail_id'][$i],
                    'item_id' => $postData['item_id'][$i],
                    'received_qty' => $postData['receive_qty'][$i],
                    'received_by' => $this->session->userdata('user_id')
                  );
                  $this->db->insert("str_purchase_receive",$insertData);
                  $this->session->set_flashdata('success', "Product received successfully.");
                }
            }
        }
        return true;
    }
    public function updatePurchaseReturnData($postData){
        $recItems = $postData['purchase_detail_id'];
        for ($i = 0; $i < count($recItems); $i++) {
            $newReturnQty = $postData['return_qty'][$i];
            $itemId = $postData['item_id'][$i];
            if($newReturnQty > 0){
                $purchaseDetailData = $this->getPurchaseDetailDataById($postData['purchase_detail_id'][$i]);
                $receivedQty = $purchaseDetailData->received_qty;
                $returnedQty = $purchaseDetailData->returned_qty;
                $currentStockQty = $purchaseDetailData->current_qty;
                $availableRetunQty = $receivedQty-$returnedQty;
                if($newReturnQty > $availableRetunQty){
                    // Higher than receive qty
                    $this->session->set_flashdata('error', "$purchaseDetailData->item_name return qty is Higher than received qty.");
                }else{
                    if($newReturnQty > $currentStockQty){
                        $this->session->set_flashdata('error', "$purchaseDetailData->item_name return qty is Higher than stock qty.");
                    }else{
                        $this->db->query("UPDATE str_purchase_details SET returned_qty=returned_qty+$newReturnQty WHERE id=$recItems[$i]");
                        $this->db->query("UPDATE str_items SET current_qty=current_qty-$newReturnQty WHERE id=$itemId");              
                        $insertData = array(
                          'return_date' => $this->currentDate(),
                          'purchase_detail_id' => $postData['purchase_detail_id'][$i],
                          'item_id' => $postData['item_id'][$i],
                          'returned_qty' => $postData['return_qty'][$i],
                          'returned_by' => $this->session->userdata('user_id')
                        );
                        $this->db->insert("str_purchase_return",$insertData);
                        $this->session->set_flashdata('success', "Product retuned successfully.");
                    }
                }
            }
        }
        return true;
    }
    public function deleteReturnPurchaseById($delId,$purchaseDetailId,$itemId,$retQty){
        if(!$retQty){
            $retQty=0;
        }
        $this->db->query("UPDATE str_purchase_details SET returned_qty=returned_qty-$retQty WHERE id=$purchaseDetailId ");
        $this->db->query("UPDATE str_items SET current_qty=current_qty+$retQty WHERE id=$itemId");       
        $this->db->query("DELETE FROM str_purchase_return WHERE id=$delId ");
        return true;
    }
    public function deleteReceivePurchaseById($delId,$purchaseDetailId,$itemId,$recQty){
        if(!$recQty){
            $recQty=0;
        }
        $this->db->query("UPDATE str_purchase_details SET received_qty=received_qty-$recQty WHERE id=$purchaseDetailId ");
        $this->db->query("UPDATE str_items SET current_qty=current_qty-$recQty WHERE id=$itemId");           
                  
        $this->db->query("DELETE FROM str_purchase_receive WHERE id=$delId ");
        return true;
    }
}
