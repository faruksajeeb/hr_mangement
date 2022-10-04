<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Transportemployeelist extends CI_Controller {

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
        // $this->load->library("pdf");       
        
    }

    public function index() {

        //$this->load->view('recruiting/addprofile');
        redirect("transprtemployeelist/emplist");
    }
    function emplist() {

        $searchpage="emplist";
        $config = array();
        $config["base_url"] = base_url() . "transprtemployeelist/emplist";
        $total_row = $this->car_info_model->driver_record_count();
        $per_page_query = 24;
        $config["total_rows"] = $total_row;
        $config["per_page"] = 24;
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
       // $data["records"] = $this->car_info_model->get_all_driver_data($config["per_page"], $page);        
        $data["records"] =$this->car_info_model->getcarinfonotduplicate("default_driver_emp_id");        
        $i = 0;
        // $data['records'] = $allname;
        $data['total_search'] = $total_row;
        $this->load->view('car/all_transport_emp_list', $data);
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