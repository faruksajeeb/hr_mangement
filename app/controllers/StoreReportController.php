<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of StoreReportController
 *
 * @author   Mohammad Omar Faruk Sajeeb
 */
class StoreReportController extends CI_Controller  {
    //put your code here
    function __construct() {
        error_reporting(0);
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->model('StoreReportModel');
    }
    function outOfStock(){
        $data['out_of_stock'] = $this->StoreReportModel->getOutOfStock();      
        $this->load->view('store/report/out-of-stock',$data);
    }
    function availableStock(){
        $data['availabe_stock'] = $this->StoreReportModel->getAvaliableStock();       
        $this->load->view('store/report/available-stock',$data);
    }
    function allStock(){
        $data['all_stock'] = $this->StoreReportModel->getAllStock();       
        $this->load->view('store/report/all-stock',$data);
    }
    function categoryWiseStock(){
        $data['active_categories'] = $this->StoreReportModel->getAllPublishCategory();
        $this->load->view('store/report/category-wise-stock',$data);
    }
    function categoryWiseStockReport(){
        $categoryId = $this->input->post('category_id');
        $data['all_stock'] = $this->StoreReportModel->getAllStockByCategory($categoryId);
        $this->load->view('store/report/category-wise-stock-report',$data);
    }
 
    
    function employeeWiseSalesReport(){
        $data['active_employees'] = $this->StoreReportModel->getPublishConsumer();
        $this->load->view('store/report/employee-wise-sales-report',$data);
    }
    function supplierWisePurchaseReport(){
        $data['active_suppliers'] = $this->StoreReportModel->getPublishSupplier();
        $this->load->view('store/report/purchase/supplier-wise-purchase-report',$data);
    }
    
    function categoryWiseSalesReport(){
        $data['active_categories'] = $this->StoreReportModel->getAllPublishCategory();
        $this->load->view('store/report/category-wise-sales-report',$data);
    }
    function categoryWisePurchaseReport(){
        $data['active_categories'] = $this->StoreReportModel->getAllPublishCategory();
        $this->load->view('store/report/purchase/category-wise-purchase-report',$data);
    }
    function itemWiseSalesReport(){
        $data['items'] = $this->StoreReportModel->getAllItems();
        $this->load->view('store/report/item-wise-sales-report',$data);
    }
    function itemWisePurchaseReport(){
        $data['items'] = $this->StoreReportModel->getAllItems();
        $this->load->view('store/report/purchase/item-wise-purchase-report',$data);
    }
       function getEmployeeWiseSalesReport(){
        $contentId = $this->input->post('employee_id');        
        $empInfo = $this->search_field_emp_model->getEmployeeInfoById($contentId);
        $data['employee_id'] = $empInfo->emp_id;
        $data['employee_name'] = $empInfo->emp_name;
        $data['employee_company'] = $empInfo->company_name;
        $data['employee_designation'] = $empInfo->designation_name;
        $data['employee_wise_sales'] = $this->StoreReportModel->getEmployeeWiseSalesReport($contentId);
//        print_r($data);
        $this->load->view('store/report/employee-wise-sales-report-inline',$data);
    }
       function getSupplierWisePurchaseReport(){
        $supplierId = $this->input->post('supplier_id');        
        $supplierInfo = $this->StoreReportModel->getSupplierInfoById($supplierId);
//        print_r($supplierInfo);
//        exit;
        $data['supplier_id'] = $supplierInfo->id;
        $data['supplier_name'] = $supplierInfo->supplier_name;
        $data['contact_person'] = $supplierInfo->contact_person;
        $data['address'] = $supplierInfo->address;
        $data['phone'] = $supplierInfo->phone;
        $data['supplier_wise_purchases'] = $this->StoreReportModel->getSupplierWisePurchaseReport($supplierId);
//        print_r($data);
//        exit;
        $this->load->view('store/report/purchase/supplier-wise-purchase-report-inline',$data);
    }
    
    function getCategoryWiseSalesReport(){
        $categoryId = $this->input->post('category_id'); 
        $catInfo = $this->StoreReportModel->getCategoryNameByID($categoryId);
        $data['category_name'] =$catInfo->category_name ;
        $data['category_wise_sales'] = $this->StoreReportModel->getCategoryWiseSalesReport($categoryId);
//        print_r($data);
        $this->load->view('store/report/category-wise-sales-report-inline',$data);
    }
    
  function getCategoryWisePurchaseReport(){
        $categoryId = $this->input->post('category_id'); 
        $catInfo = $this->StoreReportModel->getCategoryNameByID($categoryId);
        $data['category_name'] =$catInfo->category_name ;
        $data['category_wise_purchases'] = $this->StoreReportModel->getCategoryWisePurchaseReport($categoryId);
//        print_r($data);
        $this->load->view('store/report/purchase/category-wise-purchase-report-inline',$data);
    }
    function getItemWiseSalesReport(){
        $itemId = $this->input->post('item_id'); 
        $itemInfo = $this->StoreReportModel->getItemNameByID($itemId);
        $data['item_name'] =$itemInfo->item_name ;
        $data['item_wise_sales'] = $this->StoreReportModel->getItemWiseSalesReport($itemId);
//        print_r($data);
        $this->load->view('store/report/item-wise-sales-report-inline',$data);
    }
    function getItemWisePurchaseReport(){
        $itemId = $this->input->post('item_id'); 
        $itemInfo = $this->StoreReportModel->getItemNameByID($itemId);
        $data['item_name'] =$itemInfo->item_name ;
        $data['item_wise_purchases'] = $this->StoreReportModel->getItemWisePurchaseReport($itemId);
//        print_r($data);
        $this->load->view('store/report/purchase/item-wise-purchase-report-inline',$data);
    }
}
