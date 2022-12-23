<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StoreModel
 *
 * @author Md. Omar Faruk
 */
class StoreModel extends CI_Model {
    //put your code here
    public function insertCategory($postData){
        $paramsData = array(
            'category_name' => $postData['category_name'],
            'description' => $postData['description'],
            'status' => $postData['status'],
            'created_at' => $this->currentTime(),
            'created_by' => $this->session->userdata('user_id')
        );
        return $this->db->insert("str_categories",$paramsData);
    }
    public function insertBrand($postData){
        $paramsData = array(
            'brand_name' => $postData['brand_name'],
            'address' => $postData['address'],
            'phone' => $postData['phone'],
            'email' => $postData['email'],
            'website' => $postData['website'],
            'status' => $postData['status'],
            'created_at' => $this->currentTime(),
            'created_by' => $this->session->userdata('user_id')
        );
        return $this->db->insert("str_brands",$paramsData);
    }
    public function insertMeasurement($postData){
        $paramsData = array(
            'short_name' => $postData['short_name'],
            'full_name' => $postData['full_name'],
            'description' => $postData['description'],
            'status' => $postData['status'],
            'created_at' => $this->currentTime(),
            'created_by' => $this->session->userdata('user_id')
        );
        return $this->db->insert("str_measurements",$paramsData);
    }
    public function insertItem($postData){
        $paramsData = array(
            'item_name' => $postData['item_name'],
            'item_code' => $postData['item_code'],
            'category_id' => $postData['category_id'],
            'initial_qty' => $postData['initial_qty'],
            'initial_price' => $postData['initial_price'],
            'current_qty' => $postData['initial_qty'],
            'current_price' => $postData['initial_price'],
            'min_stock_amt' => $postData['min_stock_amt'],
            'measurement_id' => $postData['measurement_id'],
            'description' => $postData['description'],
            'status' => $postData['status'],
            'created_at' => $this->currentTime(),
            'created_by' => $this->session->userdata('user_id')
        );
        return $this->db->insert("str_items",$paramsData);
    }
    public function insertVendor($postData){
        $paramsData = array(
            'supplier_name' => $postData['vendor_name'],
            'contact_person' => $postData['contact_person'],
            'address' => $postData['address'],
            'phone' => $postData['phone'],
            'email' => $postData['email'],
            'initial_balance' => $postData['initial_balance'],
            'balance' => $postData['initial_balance'],
            'note' => $postData['note'],
            'status' => $postData['status'],
            'created_at' => $this->currentTime(),
            'created_by' => $this->session->userdata('user_id')
        );
        return $this->db->insert("str_suppliers",$paramsData);
    }
    public function getAllCategory(){
        return $this->db->query("SELECT * FROM str_categories ORDER BY category_name ASC")->result();
    }
    public function getAllBrand(){
        return $this->db->query("SELECT * FROM str_brands ORDER BY brand_name ASC")->result();
    }
    public function getAllMeasurement(){
        return $this->db->query("SELECT * FROM str_measurements ORDER BY id ASC")->result();
    }
    public function getAllItem(){
        return $this->db->query("SELECT i.*,c.category_name,m.short_name as measurement_name FROM str_items as i "
                . "LEFT JOIN str_categories as c ON c.id=i.category_id LEFT JOIN str_measurements as m ON m.id=i.measurement_id "
                . "ORDER BY item_name ASC")->result();
    }
    public function getAllVendor(){
        return $this->db->query("SELECT * FROM str_suppliers ORDER BY id ASC")->result();
    }
    public function getCategoryByName($name){
        return $this->db->query("SELECT * FROM str_categories WHERE category_name ='$name'")->result_array();
    }
    public function getBrandByName($name){
        return $this->db->query("SELECT * FROM str_brands WHERE brand_name ='$name'")->result_array();
    }
    public function getMeasurementByName($name){
        return $this->db->query("SELECT * FROM str_measurements WHERE short_name ='$name'")->result_array();
    }
    public function getItemByName($name){
        return $this->db->query("SELECT * FROM str_items WHERE item_name ='$name'")->result_array();
    }
    public function getVendorByName($name){
        return $this->db->query("SELECT * FROM str_suppliers WHERE supplier_name ='$name'")->result_array();
    }
    function getCategoryById($id) {
        $query = $this->db->get_where('str_categories', array('id' => $id));
        return $query->row_array();
    }
    function getBrandById($id) {
        $query = $this->db->get_where('str_brands', array('id' => $id));
        return $query->row_array();
    }    
    function getMeasurementById($id) {
        $query = $this->db->get_where('str_measurements', array('id' => $id));
        return $query->row_array();
    }    
    function getItemById($id) {
        $query = $this->db->get_where('str_items', array('id' => $id));
        return $query->row_array();
    } 
    function getVendorById($id) {
        $query = $this->db->get_where('str_suppliers', array('id' => $id));
        return $query->row_array();
    }
    public function getAllPublishCategory(){
        return $this->db->query("SELECT * FROM str_categories WHERE status=1 ORDER BY category_name ASC")->result();
    }
    public function getAllPublishBrand(){
        return $this->db->query("SELECT * FROM str_brands WHERE status=1 ORDER BY brand_name ASC")->result();
    }
    public function getAllPublishMeasurement(){
        return $this->db->query("SELECT * FROM str_measurements WHERE status=1 ORDER BY id ASC")->result();
    }
    public function updateCategory($postData, $where = array()) {
        $paramsData = array(
            'category_name' => $postData['category_name'],
            'description' => $postData['description'],
            'status' => $postData['status'],
            'updated_at' => $this->currentTime(),
            'updated_by' => $this->session->userdata('user_id')
        );
        $this->db->where($where);
        $this->db->update('str_categories', $paramsData);
        return true;
    }
    public function updateBrand($postData, $where = array()) {
        $paramsData = array(
            'brand_name' => $postData['brand_name'],
            'address' => $postData['address'],
            'phone' => $postData['phone'],
            'email' => $postData['email'],
            'website' => $postData['website'],
            'status' => $postData['status'],
            'updated_at' => $this->currentTime(),
            'updated_by' => $this->session->userdata('user_id')
        );
        $this->db->where($where);
        $this->db->update('str_brands', $paramsData);
        return true;
    }
    public function updateMeasurement($postData, $where = array()) {
        $paramsData = array(
            'short_name' => $postData['short_name'],
            'full_name' => $postData['full_name'],
            'description' => $postData['description'],
            'status' => $postData['status'],
            'updated_at' => $this->currentTime(),
            'updated_by' => $this->session->userdata('user_id')
        );
        $this->db->where($where);
        $this->db->update('str_measurements', $paramsData);
        return true;
    }
    public function updateItem($postData, $where = array()) {
        $paramsData = array(
            'item_name' => $postData['item_name'],
            'item_code' => $postData['item_code'],
            'category_id' => $postData['category_id'],
            'initial_qty' => $postData['initial_qty'],
            'initial_price' => $postData['initial_price'],
            'min_stock_amt' => $postData['min_stock_amt'],
            'measurement_id' => $postData['measurement_id'],
            'description' => $postData['description'],
            'status' => $postData['status'],
            'updated_at' => $this->currentTime(),
            'updated_by' => $this->session->userdata('user_id')
        );
        $previousIniQty = $postData['initial_pre_qty'];
        $presentIniQty = $postData['initial_qty'];
        $currentQty = $postData['current_qty'];
        if($previousIniQty != $presentIniQty){
            if ($presentIniQty > $previousIniQty) {
                $addQty = $presentIniQty - $previousIniQty;
                $paramsData['current_qty'] = $currentQty + $addQty;
            } else if ($presentIniQty < $previousIniQty) {
                $deductQty = $previousIniQty - $presentIniQty;
                $paramsData['current_qty'] = $currentQty - $deductQty;
            }
        }
        $this->db->where($where);
        $this->db->update('str_items', $paramsData);
        return true;
    }
    public function updateVendor($postData, $where = array()) {
        $paramsData = array(
            'supplier_name' => $postData['vendor_name'],
            'contact_person' => $postData['contact_person'],
            'address' => $postData['address'],
            'phone' => $postData['phone'],
            'email' => $postData['email'],
            'initial_balance' => $postData['initial_balance'],
            'note' => $postData['note'],
            'status' => $postData['status'],
            'updated_at' => $this->currentTime(),
            'updated_by' => $this->session->userdata('user_id')
        );
        $previousInitialBalance = $postData['previous_initial_balance'];
        $presentInitialBalance = $postData['initial_balance'];
        $currentBalance = $postData['balance'];
        if($previousInitialBalance != $presentInitialBalance){
            if ($presentInitialBalance > $previousInitialBalance) {
                $addBalance = $presentInitialBalance - $previousInitialBalance;
                $paramsData['balance'] = $currentBalance + $addBalance;
            } else if ($presentInitialBalance < $previousInitialBalance) {
                $deductBalance = $previousInitialBalance - $presentInitialBalance;
                $paramsData['balance'] = $currentBalance - $deductBalance;
            }
        }
        $this->db->where($where);
        $this->db->update('str_suppliers', $paramsData);
        return true;
    }
    public function deleteCategoryById($id){
        $query="DELETE FROM str_categories WHERE id=$id ";
        $this->db->query($query);
        return true;
    }
    public function deleteBrandById($id){
        $query="DELETE FROM str_brands WHERE id=$id ";
        $this->db->query($query);
        return true;
    }
    public function currentTime() {
        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
        $current_time = $dt->format('Y-m-d H:i:s');
        return $current_time;
    }
    
}
