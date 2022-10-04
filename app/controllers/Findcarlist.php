<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Findcarlist extends CI_Controller {

    function __construct() {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $autoload['libraries'] = array('globals');
        $this->load->helper('form');
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
        $this->load->library('image_lib');        
        $this->load->library('pagination');       
        
    }

    public function index() {

        //$this->load->view('recruiting/addprofile');
        redirect("findcarlist/cars");
    }
    function cars() {

        $searchpage="cars";
        if ($this->input->post('multiple_search_btn')) {
            $Vehicle_Name = $this->input->post('Vehicle_Name');
            $Vehicle_Owner = $this->input->post('Vehicle_Owner');
            $Vehicle_Model = $this->input->post('Vehicle_Model');
            $Model_Year = $this->input->post('Model_Year');
            $Plate = $this->input->post('Plate');
            $default_driver_id = $this->input->post('default_driver');
            $Insurance_Company = $this->input->post('Insurance_Company');
            $Color = $this->input->post('Color');
            $Car_Status = $this->input->post('Car_Status');
            $Purchase_date_from1 = $this->input->post('Purchase_date_from1');
            $Purchase_date_to1 = $this->input->post('Purchase_date_to1');
                
                $query = " id !='0' ";

            if ($Vehicle_Name) {
                $query .= " AND Vehicle_Name LIKE '$Vehicle_Name'";
            }
            if ($Vehicle_Owner) {
                $query .= " AND Vehicle_Owner LIKE '$Vehicle_Owner'";
            }
            if ($Vehicle_Model) {
                $query .= " AND Vehicle_Model LIKE '$Vehicle_Model'";
            }
            if ($Model_Year) {
                $query .= " AND Model_Year LIKE '$Model_Year'";
            }
            if ($Plate) {
                $query .= " AND Plate LIKE '$Plate'";
            } 
            if ($default_driver_id) {
                $query .= " AND default_driver_emp_id LIKE '$default_driver_id'";
            }            
            
            if ($Insurance_Company) {
                $query .= " AND Insurance_Company LIKE '$Insurance_Company'";
            } 
            if ($Color) {
                $query .= " AND Color LIKE '$Color'";
            } 
            if ($Car_Status) {
                $query .= " AND Car_Status LIKE '$Car_Status'";
            }                                               
            if ($Purchase_date_from1 && $Purchase_date_to1) {

                $Purchasedatefrom = explode("-", $Purchase_date_from1);
                $finalPurchasedatefrom=$Purchasedatefrom[2]."-".$Purchasedatefrom[1]."-".$Purchasedatefrom[0];
                $Purchasedateto = explode("-", $Purchase_date_to1);
                $finalPurchasedateto=$Purchasedateto[2]."-".$Purchasedateto[1]."-".$Purchasedateto[0];
                $query .= " AND str_to_date(Purchase_Date, '%d-%m-%Y') BETWEEN '$finalPurchasedatefrom' AND '$finalPurchasedateto'";
            } else if ($Purchase_date_from1) {
                $Purchasedatefrom = explode("-", $Purchase_date_from1);
                $finalPurchasedatefrom=$Purchasedatefrom[2]."-".$Purchasedatefrom[1]."-".$Purchasedatefrom[0];
                $query .= " AND str_to_date(Purchase_Date, '%d-%m-%Y') >='$finalPurchasedatefrom'";
            }                                                             
            $user_id = $this->session->userdata('user_id');
            $this->search_query_model->deleteQuerybyUserid($user_id, $searchpage);
            date_default_timezone_set('Asia/Dhaka');
            $servertime = time();
            $now = date("d-m-Y", $servertime);

            $params_contents = array(
                'id' => '',
                'search_query' => $query,
                'user_id' => $user_id,
                'table_view' => "0",
                'per_page' => "24",
                'search_page' => $searchpage,                
                'search_date' => $now,
                );
            $this->db->insert("search_query", $params_contents);

            // $allname = $this->db->query($query)->result_array();
        } 
        $config = array();
        $config["base_url"] = base_url() . "findcarlist/cars";
        $total_row = $this->car_info_model->search_record_count($searchpage);
        $per_page_query = $this->car_info_model->getsearchQuery($searchpage);
        $config["total_rows"] = $total_row;
        if ($per_page_query['per_page']) {
            $config["per_page"] = $per_page_query['per_page'];
        } else {
            $config["per_page"] = 12;
        }
        $config['use_page_numbers'] = FALSE;
        $config['num_links'] = 9;
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";

        $this->pagination->initialize($config);
        if ($this->uri->segment(3)) {
            $page = ($this->uri->segment(3));
        } else {
            $page = 0;
        }

        $data["records"] = $this->car_info_model->get_all_data($config["per_page"], $page, $searchpage);        
        //         echo "<pre>";
        // print_r($data["records"]);
        // echo "</pre>";
        $allcontent = array();
        $i = 0;
        $data['getallcar'] = $this->car_info_model->getallcar();
        $data['car_name']=$this->car_info_model->getcarinfonotduplicate("Vehicle_Name");
        $data['car_owner']=$this->car_info_model->getcarinfonotduplicate("Vehicle_Owner");
        $data['car_model']=$this->car_info_model->getcarinfonotduplicate("Vehicle_Model");
        $data['car_model_year']=$this->car_info_model->getcarinfonotduplicate("Model_Year");
        $data['car_plate']=$this->car_info_model->getcarinfonotduplicate("Plate");
        $data['car_default_driver']=$this->car_info_model->getcarinfonotduplicate("default_driver_emp_id");       
        $data['car_insurance_company']=$this->car_info_model->getcarinfonotduplicate("Insurance_Company");
        $data['car_color']=$this->car_info_model->getcarinfonotduplicate("Color");
        // $data['records'] = $allname;
        $data['total_search'] = $total_row;
        $this->load->view('car/allcarwithpagination', $data);
    }

    public function insertItemperpage() {
       header('Content-type: application/json');
       $applicant_per_page = $this->input->post('applicant_per_page');
        $user_id = $this->session->userdata('user_id');
         $searchpage=$this->input->post('search_page');
        $params_contents = array(
            'per_page' => $applicant_per_page,
        );
        $update_con = array('user_id' => $user_id, 'search_page' => $searchpage);
        $this->search_query_model->update_view_status($params_contents, $update_con);
        $content_table = $this->search_field_emp_model->getsearchQuery($searchpage);
        echo json_encode($content_table);
    }
}

?>