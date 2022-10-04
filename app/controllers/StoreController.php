<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StoreController
 *
 * @author Md. Omar Faruk
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class StoreController extends CI_Controller {
    //put your code here
        function __construct() {
        error_reporting(0);
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('storeModel');
        
    }
    public function manageCategory(){
       if($this->input->post('add_category')){
           $result = $this->addCategory($this->input->post());
            $data['msg']=$result;
       }
       if($this->uri->segment(2)){
            $to_edit_id = ($this->uri->segment(2)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->storeModel->getCategoryById($to_edit_id);
        }
        $data['categories']=$this->storeModel->getAllCategory();
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('store/category/manage-category',$data);
    }
     public function manageBrand(){
       if($this->input->post('add_brand')){
           $result = $this->addBrand($this->input->post());
            $data['msg']=$result;
       }
       if($this->uri->segment(2)){
            $to_edit_id = ($this->uri->segment(2)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->storeModel->getBrandById($to_edit_id);
        }
        $data['brands']=$this->storeModel->getAllBrand();
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('store/brand/manage-brand',$data);
    }
    public function manageMeasurement(){
       if($this->input->post('add_measurement')){
           $result = $this->addMeasurement($this->input->post());
            $data['msg']=$result;
       }
       if($this->uri->segment(2)){
            $to_edit_id = ($this->uri->segment(2)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->storeModel->getMeasurementById($to_edit_id);
        }
        $data['measurements']=$this->storeModel->getAllMeasurement();
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('store/measurement/manage-measurement',$data);
    }
     public function manageItem(){
       if($this->input->post('add_item')){
           $result = $this->addItem($this->input->post());
            $data['msg']=$result;
       }
       if($this->uri->segment(2)){
            $to_edit_id = ($this->uri->segment(2)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->storeModel->getItemById($to_edit_id);
        }
        $data['items']=$this->storeModel->getAllItem();
        $data['publishCategories']=$this->storeModel->getAllPublishCategory();
       // $data['publishBrands']=$this->storeModel->getAllPublishBrand();
        $data['publishMeasurements']=$this->storeModel->getAllPublishMeasurement();
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('store/item/manage-item',$data);
    }
    public function manageVendor(){
       if($this->input->post('add_vendor')){
           $result = $this->addVendor($this->input->post());
            $data['msg']=$result;
       }
       if($this->uri->segment(2)){
            $to_edit_id = ($this->uri->segment(2)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->storeModel->getVendorById($to_edit_id);
        }
        $data['vendors']=$this->storeModel->getAllVendor();
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('store/traders/vendor/manage-vendor',$data);
    }
    private function addCategory($postData){
        //$this->check_permission_controller->check_permission_action("add_store_category");
        $this->form_validation->set_rules('category_name', 'Category Name', 'required');
        if($this->form_validation->run()==FALSE)
        {
            $this->session->set_flashdata('errors', validation_errors());            
            redirect('manage-store-category');
        }
        $categoryId = $postData['category_id'];
        $categoryName = $postData['category_name'];
        $checkDuplicate=$this->storeModel->getCategoryByName($categoryName);
        if($categoryName && !$checkDuplicate){
            if($categoryId){               
                $updateCondition=array('id' => $categoryId);
                $res = $this->storeModel->updateCategory($postData, $updateCondition);
                if($res){ 
                    $msg = "Category updated successfully!";
                }
            }else{                
                $res = $this->storeModel->insertCategory($postData);
                if($res){  
                    $msg = "Category inserted successfully!";
                }
            }
        }else if($checkDuplicate){
            $updateId=$checkDuplicate[0]['id'];
            $updateCondition=array('id' => $updateId);
                $res = $this->storeModel->updateCategory($postData, $updateCondition);
            if($res){ 
                $msg = "Category updated successfully!";
            }
        }
        return $msg;
    }
    private function addBrand($postData){
        //$this->check_permission_controller->check_permission_action("add_store_category");
        $this->form_validation->set_rules('brand_name', 'Brand Name', 'required');
        if($this->form_validation->run()==FALSE)
        {
            $this->session->set_flashdata('errors', validation_errors());            
            redirect('manage-store-brand');
        }
        $brandId = $postData['brand_id'];
        $brandName = $postData['brand_name'];
        $checkDuplicate=$this->storeModel->getBrandByName($brandName);
        if($brandName && !$checkDuplicate){
            if($brandId){               
                $updateCondition=array('id' => $brandId);
                $res = $this->storeModel->updateBrand($postData, $updateCondition);
                if($res){ 
                    $msg = "Brand updated successfully!";
                }
            }else{                
                $res = $this->storeModel->insertBrand($postData);
                if($res){  
                    $msg = "Brand inserted successfully!";
                }
            }
        }else if($checkDuplicate){
            $updateId=$checkDuplicate[0]['id'];
            $updateCondition=array('id' => $updateId);
                $res = $this->storeModel->updateBrand($postData, $updateCondition);
            if($res){ 
                $msg = "Brand updated successfully!";
            }
        }
        return $msg;
    }
    private function addMeasurement($postData){
        //$this->check_permission_controller->check_permission_action("add_measurement");
        $this->form_validation->set_rules('short_name', 'Measurment Name', 'required');
        if($this->form_validation->run()==FALSE)
        {
            $this->session->set_flashdata('errors', validation_errors());            
            redirect('manage-store-measurement');
        }
        $measurementId = $postData['measurement_id'];
        $measurementName = $postData['short_name'];
        $checkDuplicate=$this->storeModel->getMeasurementByName($measurementName);
        if($measurementName && !$checkDuplicate){
            if($measurementId){               
                $updateCondition=array('id' => $measurementId);
                $res = $this->storeModel->updateMeasurement($postData, $updateCondition);
                if($res){ 
                    $msg = "Measurement updated successfully!";
                }
            }else{                
                $res = $this->storeModel->insertMeasurement($postData);
                if($res){  
                    $msg = "Measurement inserted successfully!";
                }
            }
        }else if($checkDuplicate){
            $updateId=$checkDuplicate[0]['id'];
            $updateCondition=array('id' => $updateId);
                $res = $this->storeModel->updateMeasurement($postData, $updateCondition);
            if($res){ 
                $msg = "Measurement updated successfully!";
            }
        }
        return $msg;
    }
    private function addItem($postData){
        //$this->check_permission_controller->check_permission_action("add_item");
        $this->form_validation->set_rules('item_name', 'Item Name', 'required');
        if($this->form_validation->run()==FALSE)
        {
            $this->session->set_flashdata('errors', validation_errors());            
            redirect('manage-store-item');
        }
        $itemId = $postData['item_id'];
        $itemName = $postData['item_name'];
        $checkDuplicate=$this->storeModel->getItemByName($itemName);
        if($itemName && !$checkDuplicate){
            if($itemId){               
                $updateCondition=array('id' => $itemId);
                $res = $this->storeModel->updateItem($postData, $updateCondition);
                if($res){ 
                    $msg = "Item updated successfully!";
                }
            }else{                
                $res = $this->storeModel->insertItem($postData);
                if($res){  
                    $msg = "Item inserted successfully!";
                }
            }
        }else if($checkDuplicate){
            $updateId=$checkDuplicate[0]['id'];
            $updateCondition=array('id' => $updateId);
                $res = $this->storeModel->updateItem($postData, $updateCondition);
            if($res){ 
                $msg = "Item updated successfully!";
            }
        }
        return $msg;
    }
    private function addVendor($postData){
        //$this->check_permission_controller->check_permission_action("add_item");
        $this->form_validation->set_rules('vendor_name', 'Vendor Name', 'required');
        $this->form_validation->set_rules('contact_person', 'Contact Person Name', 'required');
        if($this->form_validation->run()==FALSE)
        {
            $this->session->set_flashdata('errors', validation_errors());            
            redirect('manage-store-vendor');
        }
        $vendorId = $postData['vendor_id'];
        $vendorName = $postData['vendor_name'];
        $checkDuplicate=$this->storeModel->getVendorByName($vendorName);
        if($vendorName && !$checkDuplicate){
            if($vendorId){               
                $updateCondition=array('id' => $vendorId);
                $res = $this->storeModel->updateVendor($postData, $updateCondition);
                if($res){ 
                    $msg = "Vendor updated successfully!";
                }
            }else{                
                $res = $this->storeModel->insertVendor($postData);
                if($res){  
                    $msg = "Vendor inserted successfully!";
                }
            }
        }else if($checkDuplicate){
            $updateId=$checkDuplicate[0]['id'];
            $updateCondition=array('id' => $updateId);
                $res = $this->storeModel->updateVendor($postData, $updateCondition);
            if($res){ 
                $msg = "Vendor updated successfully!";
            }
        }
        return $msg;
    }
    public function deleteCategory($id) {
        $delId = $this->uri->segment(2);
        $result = $this->storeModel->deleteCategoryById($delId);
        if ($result == true) {
            $this->session->set_flashdata('errors', "Category deleted successfully. ");
        } else {
            $this->session->set_flashdata('errors', "Category not deleted!");
        }

        redirect('manage-store-category');
    }
    public function deleteBrand($id) {
        $delId = $this->uri->segment(2);
        $result = $this->storeModel->deleteBrandById($delId);
        if ($result == true) {
            $this->session->set_flashdata('errors', "Brand deleted successfully. ");
        } else {
            $this->session->set_flashdata('errors', "Brand not deleted!");
        }

        redirect('manage-store-brand');
    }
     public function updateItemCurrentPrice($table) {
        $columnName = $this->input->post('name');
        $newValue = $this->input->post('value');
        $itemId = $this->input->post('pk');
        
            // UPDATE ---------------------------
            $this->db->set($columnName, $newValue);
            $this->db->set('updated_at', $this->current_time());
            $this->db->set('updated_by', $this->session->userdata('user_id'));
            $this->db->where('id', $itemId);
            $result = $this->db->update('str_items');
    
        return $result;
    }
        public function current_time() {
        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
        $current_time = $dt->format('Y-m-d H:i:s');
        return $current_time;
    }

    public function currentDate() {
        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
        $current_time = $dt->format('d-m-Y');
        return $current_time;
    }
    
   
}
