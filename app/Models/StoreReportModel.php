<?php
/**
 * Description of StoreReportModel
 *
  * @author Mohammad Omar Faruk Sajeeb
 */
class StoreReportModel  extends CI_Model {
    //put your code here
    public function getCategoryNameByID($categoryId){
        return $this->db->query("SELECT category_name FROM str_categories WHERE id=$categoryId")->row();
    }
    public function getItemNameByID($itemId){
        return $this->db->query("SELECT item_name FROM str_items WHERE id=$itemId")->row();
    }
    public function getAllItems(){
         return $this->db->query("SELECT * FROM str_items ORDER BY item_name ASC")->result();
    }
    function getPublishConsumer() {
        return $this->db->query("SELECT * FROM search_field_emp "
                . "WHERE type_of_employee NOT IN(153,473) ORDER BY emp_id")->result();
        
    }
    function getPublishSupplier() {
        return $this->db->query("SELECT * FROM str_suppliers "
                . "WHERE status=1 ORDER BY supplier_name")->result();        
    }
    
    function getSupplierInfoById($supplierId){
        return $this->db->query("SELECT * FROM str_suppliers WHERE id=$supplierId")->row();
    }
    function getOutOfStock(){
        return $this->db->query("SELECT si.*,m.short_name FROM str_items si LEFT JOIN str_measurements m ON m.id=si.measurement_id WHERE si.current_qty=0 AND si.status=1 ORDER BY si.item_name ")->result();    
    }
    function getAvaliableStock(){
        return $this->db->query("SELECT si.*,m.short_name FROM str_items si LEFT JOIN str_measurements m ON m.id=si.measurement_id WHERE si.current_qty >=1 AND si.status=1 ORDER BY si.item_name ")->result();    
    }
    function getAllStock(){
        return $this->db->query("SELECT si.*,m.short_name FROM str_items si LEFT JOIN str_measurements m ON m.id=si.measurement_id WHERE si.status=1 ORDER BY si.item_name ")->result();    
    }
    public function getAllPublishCategory(){
        return $this->db->query("SELECT * FROM str_categories WHERE status=1 ORDER BY category_name ASC")->result();
    }
    function getAllStockByCategory($categoryId){
        return $this->db->query("SELECT i.*,c.category_name,m.short_name,"
                . "(SELECT SUM(received_qty) FROM str_purchase_details WHERE item_id=i.id) as total_purchase,"
                . "(SELECT SUM(returned_qty) FROM str_purchase_details WHERE item_id=i.id) as total_purchase_return,"
                . "(SELECT SUM(sd.delivered_qty) FROM str_sales_details sd LEFT JOIN str_sales s ON s.id=sd.sales_id WHERE sd.item_id=i.id) as total_delivered, "
                . "(SELECT SUM(sd.returned_qty) FROM str_sales_details sd LEFT JOIN str_sales s ON s.id=sd.sales_id WHERE sd.item_id=i.id) as total_returned "
                . " FROM str_items i "
                . "LEFT JOIN str_categories c ON c.id=i.category_id "
                . "LEFT JOIN str_measurements m ON m.id=i.measurement_id "
                . "WHERE i.status=1 AND i.category_id=$categoryId ORDER BY i.item_name ")->result(); 
    }
    function getEmployeeWiseSalesReport($employeeId){
        return $this->db->query("SELECT sd.*,s.consumer_id,s.delivery_date,i.item_name "
                . "FROM str_sales_delivered sd "
                . "LEFT JOIN str_sales s ON s.id=sd.sales_id "
                . "LEFT JOIN str_items i ON i.id=sd.item_id WHERE s.consumer_id=$employeeId ORDER BY sd.id DESC")->result();
    }
    function getSupplierWisePurchaseReport($supplierId){
        return $this->db->query("SELECT pd.*,i.item_name,p.purchase_date,m.short_name as measurmentShortName "
                . "FROM str_purchase_details pd "
                . "LEFT JOIN str_purchases p ON p.id=pd.purchase_id "
                . "LEFT JOIN str_items i ON i.id=pd.item_id "                
                . "LEFT JOIN str_measurements m ON m.id=i.measurement_id "
                . "WHERE p.supplier_id=$supplierId AND pd.received_qty>0 ORDER BY pd.id DESC")->result();
    }
function getCategoryWiseSalesReport($categoryId){
        return $this->db->query("SELECT sd.*,sfe.emp_name,sfe.emp_id,s.delivery_date,i.item_name,i.item_code,taxo.name as designation "
                . "FROM str_sales_delivered sd "
                . "LEFT JOIN str_sales s ON s.id=sd.sales_id "
                . "LEFT JOIN str_items i ON i.id=sd.item_id "
                . "LEFT JOIN search_field_emp as sfe ON sfe.content_id=s.consumer_id "                
                . "LEFT JOIN taxonomy as taxo ON taxo.tid=sfe.emp_post_id "
                . "WHERE i.category_id=$categoryId ORDER BY sfe.emp_name ASC")->result();
    }
function getCategoryWisePurchaseReport($categoryId){
        return $this->db->query("SELECT pd.*,s.supplier_name,p.purchase_date,i.item_name,m.short_name as measurmentShortName "
                . "FROM str_purchase_details pd "
                . "LEFT JOIN str_purchases p ON p.id=pd.purchase_id "
                . "LEFT JOIN str_items i ON i.id=pd.item_id "
                . "LEFT JOIN str_suppliers as s ON s.id=p.supplier_id "  
                  . "LEFT JOIN str_measurements m ON m.id=i.measurement_id "
                . "WHERE i.category_id=$categoryId ORDER BY pd.id DESC")->result();
    }
   function getItemWiseSalesReport($itemId){
        return $this->db->query("SELECT sd.*,sfe.emp_name,sfe.emp_id,s.delivery_date,i.item_name,i.item_code,taxo.name as designation "
                . "FROM str_sales_delivered sd "
                . "LEFT JOIN str_sales s ON s.id=sd.sales_id "
                . "LEFT JOIN str_items i ON i.id=sd.item_id "
                . "LEFT JOIN search_field_emp as sfe ON sfe.content_id=s.consumer_id "                
                . "LEFT JOIN taxonomy as taxo ON taxo.tid=sfe.emp_post_id "
                . "WHERE sd.item_id=$itemId ORDER BY sd.delivered_date ASC")->result();
    }
   function getItemWisePurchaseReport($itemId){
        return $this->db->query("SELECT pd.*,s.supplier_name,p.purchase_date,i.item_name,m.short_name as measurmentShortName "
                . "FROM str_purchase_details pd "
                . "LEFT JOIN str_purchases p ON p.id=pd.purchase_id "
                . "LEFT JOIN str_items i ON i.id=pd.item_id "
                . "LEFT JOIN str_suppliers as s ON s.id=p.supplier_id "  
                  . "LEFT JOIN str_measurements m ON m.id=i.measurement_id "
                . "WHERE pd.item_id=$itemId ORDER BY pd.id DESC")->result();
    }
}
