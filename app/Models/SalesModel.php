<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
/**
 * Description of SalesModel
 *
 * @author Mohammad Omar Faruk Sajeeb
 */
class SalesModel extends CI_Model {
    function getPublishConsumer() {
        return $this->db->query("SELECT * FROM search_field_emp "
                . "WHERE type_of_employee NOT IN(153,473) ORDER BY emp_id")->result();
        
    }
    public function getPublishItem(){
        return $this->db->query("SELECT * FROM str_items WHERE status=1 ORDER BY item_name ASC")->result();
    }
    public function insertSalesInfo($postData){
       
        $paramsData = array(
            'sales_date' => date('Y-m-d', strtotime($postData['sales_date'])),
            'consumer_id' => $postData['consumer_name'],
//            'received_by' => $postData['received_by'],
            'note' => $postData['note'],
            'status' => 0,
            'created_at' => $this->currentTime(),
            'created_by' => $this->session->userdata('user_id')
        );
//         echo "</pre>";
//        print_r($paramsData);
//        exit;
        $this->db->insert("str_sales",$paramsData);
        
        $insertedSalesId = $this->db->insert_id();
        
        $itemId = $postData['grid_item_name'];
        
        for ($i = 0; $i < count($itemId); $i++) {
            $salesItemId = $itemId[$i];
            $salesQty = $postData['total_qty'][$i];
            $sdata[] = array(
                'sales_id' => $insertedSalesId,
                'item_id' => $salesItemId,
//                'number_of_pack' => $postData['number_of_pack'][$i],
//                'qty_per_pack' => $postData['qty_per_pack'][$i],
                'order_qty' => $postData['total_qty'][$i],
//                'rate' => $postData['item_price'][$i],
//                'amount' => $postData['amount'][$i],
            );
        }
        return $this->db->insert_batch('str_sales_details', $sdata);
        
    }
    public function getAllSales(){        
        return $this->db->query("SELECT s.*,c.emp_name as consumer_name,"
                . "(SELECT SUM(order_qty) FROM str_sales_details WHERE sales_id=s.id) AS total_order_qty, "
                . "(SELECT SUM(delivered_qty) FROM str_sales_details WHERE sales_id=s.id) AS total_delivered_qty, "
                . "(SELECT SUM(returned_qty) FROM str_sales_details WHERE sales_id=s.id) AS total_returned_qty "
                . " FROM str_sales AS s "
                . "LEFT JOIN search_field_emp AS c ON c.content_id=s.consumer_id ORDER BY s.id DESC")->result();
    }
    public function getAllDeliveredSales(){        
        return $this->db->query("SELECT sd.*,s.sales_date,sdd.returned_qty,si.item_name,sfe.emp_name as consumer_name,m.short_name FROM str_sales_delivered AS sd "
                . "LEFT JOIN str_sales AS s ON s.id=sd.sales_id "
                . "LEFT JOIN str_sales_details AS sdd ON sdd.id=sd.sales_detail_id "
                . "LEFT JOIN search_field_emp AS sfe ON sfe.content_id=s.consumer_id "
                . "LEFT JOIN str_items AS si ON si.id=sd.item_id "
                . "LEFT JOIN str_measurements AS m ON m.id=si.measurement_id "
                . "ORDER BY sd.id DESC")->result();
    }
    public function getAllReturnedSales(){        
        return $this->db->query("SELECT sr.*,s.sales_date,si.item_name,sfe.emp_name as consumer_name,m.short_name FROM str_sales_return AS sr "
                . "LEFT JOIN str_sales AS s ON s.id=sr.sales_id "
                . "LEFT JOIN search_field_emp AS sfe ON sfe.content_id=s.consumer_id "
                . "LEFT JOIN str_items AS si ON si.id=sr.item_id "
                . "LEFT JOIN str_measurements AS m ON m.id=si.measurement_id "
                . "ORDER BY sr.id DESC")->result();
    }
    public function getSalesData($id){
        return $this->db->query("SELECT s.*,c.emp_name,c.emp_id,"
                . "(SELECT SUM(order_qty) FROM str_sales_details WHERE sales_id=s.id) AS total_order_qty, "
                . "(SELECT SUM(delivered_qty) FROM str_sales_details WHERE sales_id=s.id) AS total_delivered_qty, "
                . "(SELECT SUM(returned_qty) FROM str_sales_details WHERE sales_id=s.id) AS total_returned_qty "
                . " FROM str_sales AS s "
                . "LEFT JOIN search_field_emp AS c ON c.content_id=s.consumer_id "
                . "WHERE s.id=$id")->row();
    }
    public function getSalesDetailData($id){
        return $this->db->query("SELECT sd.*,i.item_name,i.current_qty FROM str_sales_details AS sd "
                . "LEFT JOIN str_items AS i ON i.id=sd.item_id "
                . "WHERE sd.sales_id=$id")->result();
    }
    function minusSalesQty($salesQty,$salesItemId){
        $this->db->query("UPDATE str_items SET current_qty=current_qty-$salesQty WHERE id=$salesItemId ");
    }
    public function getSalesDetailDataById($id){
        return $this->db->query("SELECT sd.*,i.item_name,i.current_qty FROM str_sales_details AS sd "
                . "LEFT JOIN str_items AS i ON i.id=sd.item_id "
                . "WHERE sd.id=$id")->row();
    }
    public function updateSalesStatus($data = array(),$where = array()){
        $this->db->where($where);
        $this->db->update('str_sales', $data);
        return true;
    }
     public function updateSalesDeliveredData($postData){
        $delItems = $postData['sales_detail_id'];
        $deliveredInfo = $this->db->query("SELECT * FROM str_sales_delivered ORDER BY id DESC LIMIT 1")->row();
        if(count($deliveredInfo)>0){
            $deliveredId = $deliveredInfo->delivery_id + 1;
        }else{
            $deliveredId =1;
        }
        for ($i = 0; $i < count($delItems); $i++) {
            $newReceivedQty = $postData['deliver_qty'][$i];
            $itemId = $postData['item_id'][$i];
            if($newReceivedQty > 0){
                $purchaseDetailData = $this->getSalesDetailDataById($postData['sales_detail_id'][$i]);               
                $totalQty = $purchaseDetailData->order_qty;
                $receivedQty = $purchaseDetailData->delivered_qty;
                $totalReceived = $receivedQty+$newReceivedQty;
                if($totalReceived > $totalQty){
                    // Higher than purchase qty
                    $this->session->set_flashdata('error', "$purchaseDetailData->item_name delivered qty Higher than order qty.");
                }else{
                    $receivedBy = $postData['received_by'];
                  
                  $this->db->query("UPDATE str_sales_details SET delivered_qty=delivered_qty+$newReceivedQty WHERE id=$delItems[$i]");
                  $this->db->query("UPDATE str_items SET current_qty=current_qty-$newReceivedQty WHERE id=$itemId");              
                  
                  
                  $insertData = array(
                    'delivery_id' => $deliveredId,
                    'delivered_date' => $this->currentDate(),
                    'sales_id' => $postData['sales_id'],
                    'sales_detail_id' => $postData['sales_detail_id'][$i],
                    'item_id' => $postData['item_id'][$i],
                    'delivered_qty' => $postData['deliver_qty'][$i],
                    'delivered_by' => $this->session->userdata('user_id'),
                    'received_by' => $receivedBy
                  );
                  $this->db->insert("str_sales_delivered",$insertData);
                  $this->session->set_flashdata('success', "Item delivered successfully.");
                }
            }
        }
        return true;
    }
      public function updateSalesReturnData($postData){
        $retItems = $postData['sales_detail_id'];
        $returnedInfo = $this->db->query("SELECT * FROM str_sales_return ORDER BY id DESC LIMIT 1")->row();
        if(count($returnedInfo)>0){
            $returnId = $returnedInfo->return_id + 1;
        }else{
            $returnId =1;
        }
        for ($i = 0; $i < count($retItems); $i++) {
            $newReturnQty = $postData['return_qty'][$i];
            $itemId = $postData['item_id'][$i];
            if($newReturnQty > 0){
                $salesDetailData = $this->getSalesDetailDataById($postData['sales_detail_id'][$i]);               
                $totalDeliveredQty = $salesDetailData->delivered_qty;
                $returnedQty = $salesDetailData->returned_qty;
                $totalReturned = $returnedQty+$newReturnQty;
                if($totalReturned > $totalDeliveredQty){
                    // Higher than purchase qty
                    continue;
                   // $this->session->set_flashdata('error', "$purchaseDetailData->item_name delivered qty Higher than order qty.");
                }else{
                  $returnBy = $postData['return_by'];                  
                  $this->db->query("UPDATE str_sales_details SET returned_qty=returned_qty+$newReturnQty WHERE id=$retItems[$i]");
                  $this->db->query("UPDATE str_items SET current_qty=current_qty+$newReturnQty WHERE id=$itemId");         
                  
                  
                  $insertData = array(
                    'return_id' => $returnId,
                    'return_date' => $this->currentDate(),
                    'sales_id' => $postData['sales_id'],
                    'sales_detail_id' => $postData['sales_detail_id'][$i],
                    'item_id' => $postData['item_id'][$i],
                    'returned_qty' => $newReturnQty,
                    'returned_by' => $returnBy,
                    'received_by' => $this->session->userdata('user_id')
                  );
                  $this->db->insert("str_sales_return",$insertData);
                  
                }
            }
        }
        return true;
    }
    public function deleteDeliveredSalesById($delId,$salesDetailId,$itemId,$delQty){
        if(!$delQty){
            $delQty=0;
        }
        $this->db->query("UPDATE str_sales_details SET delivered_qty=delivered_qty-$delQty WHERE id=$salesDetailId ");
        $this->db->query("UPDATE str_items SET current_qty=current_qty+$delQty WHERE id=$itemId");           
                  
        $this->db->query("DELETE FROM str_sales_delivered WHERE id=$delId ");
        return true;
    }
    public function deleteSalesReturnById($retDelId,$retSalesDetailId,$retItemId,$retQty){
        if(!$retQty){
            $retQty=0;
        }
        $this->db->query("UPDATE str_sales_details SET returned_qty=returned_qty-$retQty WHERE id=$retSalesDetailId ");
        $this->db->query("UPDATE str_items SET current_qty=current_qty-$retQty WHERE id=$retItemId");       
        $this->db->query("DELETE FROM str_sales_return WHERE id=$retDelId ");
        return true;
    }
    public function deleteSalesById($id){
       $this->db->query("DELETE FROM str_sales_details WHERE sales_id=$id");
       $this->db->query("DELETE FROM str_sales WHERE id=$id"); 
       return true;
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
