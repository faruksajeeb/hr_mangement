<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Addtaxonomy extends CI_Controller {

    function __construct() {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        
    }

    public function index() {
        //$this->adddivisioncontroller->get_user_full_name();
         redirect("addtaxonomy/addCompany");
    }
    public function addCompany() {
        if($this->input->post('add_company_btn')){
            $result=$this->add_company_controller->addCompanyAction($this->input->post());
//            $msg = "Data inserted";
            $data['msg']=$result;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $division_vid = 1;
        $data['companies'] = $this->taxonomy->getTaxonomyByvid($division_vid);
        $data['employees']=$this->search_field_emp_model->getallemployee();
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/add_company',$data);
    }

    public function addDivision() {
        if($this->input->post('add_division_btn')){
            $result=$this->add_division_controller->addDivisionAction($this->input->post());
            //$msg = "Data inserted";
            $data['msg']=$result;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $companyVid = 1;
        $divisionVid = 2;
        $data['companies'] = $this->taxonomy->getTaxonomyByvid($companyVid);
        $data['divisions'] = $this->taxonomy->getTaxonomyByvid($divisionVid);
        $data['employees']=$this->search_field_emp_model->getallemployee();        
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/add_division',$data);
    }
    public function addDepartment() {
        if($this->input->post('add_btn')){
            $this->load->library('controllers/add_department_controller');
            $msg=$this->add_department_controller->addDepartmentAction($this->input->post());
           // $msg = "Data inserted";
            $data['msg']=$msg;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $departmentVid = 22;
        $data['departments'] = $this->taxonomy->getTaxonomyByvid($departmentVid);
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/add_department',$data);
    }
    public function addjobtitle() {
        if($this->input->post('add_btn')){
            $this->addjobtitlecontroller->addjobtitleaction($this->input->post());
            $msg = "Data inserted";
            $data['msg']=$msg;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $jobtitle_vid = 3;
        $data['alljobtitle'] = $this->taxonomy->getTaxonomyByvid($jobtitle_vid);
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/addjobtitle',$data);
    } 
    public function addworkingshift() {
        if($this->input->post('add_btn')){
            $this->addworkingshiftcontroller->addworkingshifaction($this->input->post());
            $msg = "Data inserted";
            $data['msg']=$msg;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $workingshift_vid = 21;
        $data['allworkingshift'] = $this->taxonomy->getTaxonomyByvid($workingshift_vid);
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/addworkingshift',$data);
    }     
    public function addgrade() {
        if($this->input->post('add_btn')){
            $this->addgradecontroller->addgradeaction($this->input->post());
            $msg = "Data inserted";
            $data['msg']=$msg;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $grade_vid = 15;
        $data['allgrade'] = $this->taxonomy->getTaxonomyByvid($grade_vid);
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/addgrade',$data);
    }     
    public function addtypeofemployee() {
        if($this->input->post('add_btn')){
            $this->addtypeofemployeecontroller->add_typeofemployee_action($this->input->post());
            $msg = "Data inserted";
            $data['msg']=$msg;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $typeofemployee_vid = 4;
        $data['alltypeofemployee'] = $this->taxonomy->getTaxonomyByvid($typeofemployee_vid);
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/addtypeofemployee',$data);
    }     
    public function addqualification() {
        if($this->input->post('add_btn')){
            $this->addqualificationcontroller->add_qualification_action($this->input->post());
            $msg = "Data inserted";
            $data['msg']=$msg;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $qualification_vid = 5;
        $data['allqualification'] = $this->taxonomy->getTaxonomyByvid($qualification_vid);
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/addqualification',$data);
    }   
    public function addreligion() {
        if($this->input->post('add_btn')){
            $this->addreligioncontroller->add_religion_action($this->input->post());
            $msg = "Data inserted";
            $data['msg']=$msg;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $religion_vid = 6;
        $data['allreligion'] = $this->taxonomy->getTaxonomyByvid($religion_vid);
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/addreligion',$data);
    }  
    public function addmarital_status() {
        if($this->input->post('add_btn')){
            $this->add_marital_status_controller->add_marital_status_action($this->input->post());
            $msg = "Data inserted";
            $data['msg']=$msg;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $marital_status_vid = 7;
        $data['allmarital_status'] = $this->taxonomy->getTaxonomyByvid($marital_status_vid);
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/add_marital_status',$data);
    }   
    public function addblood_group() {
        if($this->input->post('add_btn')){
            $this->addbloodgroupcontroller->add_bloodgroup_action($this->input->post());
            $msg = "Data inserted";
            $data['msg']=$msg;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $bloodgroup_vid = 8;
        $data['allbloodgroup'] = $this->taxonomy->getTaxonomyByvid($bloodgroup_vid);
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/addbloodgroup',$data);
    } 
    public function addpaytype() {
        if($this->input->post('add_btn')){
            $this->addpaytypecontroller->add_paytype_action($this->input->post());
            $msg = "Data inserted";
            $data['msg']=$msg;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $allpaytype_vid = 9;
        $data['allpaytype'] = $this->taxonomy->getTaxonomyByvid($allpaytype_vid);
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/addpaytype',$data);
    }  
    public function addleavetype() {
        if($this->input->post('add_btn')){
            $this->addleavetypecontroller->add_leavetype_action($this->input->post());
            $msg = "Data inserted";
            $data['msg']=$msg;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $allleavetype_vid = 16;
        $data['allleavetype'] = $this->taxonomy->getTaxonomyByvid($allleavetype_vid);
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/addleavetype',$data);
    }   
    public function addyearlyholidaytype() {
        if($this->input->post('add_btn')){
            $this->add_yearlyholidaytype_controller->add_holidaytype_action($this->input->post());
            $msg = "Data inserted";
            $data['msg']=$msg;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $allholidaytype_vid = 17;
        $data['allholidaytype'] = $this->taxonomy->getTaxonomyByvid($allholidaytype_vid);
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/addyearlyholidaytype',$data);
    }          
    public function addbankname() {
        if($this->input->post('add_btn')){
            $this->addbanknamecontroller->add_bankname_action($this->input->post());
            $msg = "Data inserted";
            $data['msg']=$msg;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $bankname_vid = 10;
        $data['allbankname'] = $this->taxonomy->getTaxonomyByvid($bankname_vid);
        //$this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/addbankname',$data);
    }   

    public function addcity() {
        if($this->input->post('add_btn')){
            $this->addcitycontroller->add_city_action($this->input->post());
            $msg = "Data inserted";
            $data['msg']=$msg;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $city_vid = 11;
        $data['allcity'] = $this->taxonomy->getTaxonomyByvid($city_vid);
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/addcity',$data);
    }  
    public function adddistict() {
        if($this->input->post('add_btn')){
            $this->adddistictcontroller->add_distict_action($this->input->post());
            $msg = "Data inserted";
            $data['msg']=$msg;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $distict_vid = 12;
        $data['alldistict'] = $this->taxonomy->getTaxonomyByvid($distict_vid);
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/adddistict',$data);
    }

    public function addrelative() {
        if($this->input->post('add_btn')){
            $this->add_relative_controller->add_relative_action($this->input->post());
            $msg = "Data inserted";
            $data['msg']=$msg;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $relative_vid = 14;
        $data['allrelative'] = $this->taxonomy->getTaxonomyByvid($relative_vid);
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/addrelative',$data);
    }

    public function addperformancecriteriacategory() {
        if($this->input->post('add_btn')){
            $this->add_criteriacategory_controller->add_criteriacategory_action($this->input->post());
            $msg = "Data inserted";
            $data['msg']=$msg;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $criteriacategory_vid = 18;
        $data['allcriteriacategory'] = $this->taxonomy->getTaxonomyByvid($criteriacategory_vid);
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/addperformancecriteriacategory',$data);
    } 

    public function addperformancecriteria() {
        if($this->input->post('add_btn')){
            $this->add_performancecriteria_controller->add_performancecriteria_action($this->input->post());
            $msg = "Data inserted";
            $data['msg']=$msg;
        }
        if($this->uri->segment(3)){
            $to_edit_id = ($this->uri->segment(3)) ;
            $data['id']=$to_edit_id;
            $data['toedit_records']=$this->taxonomy->getTaxonomybyid($to_edit_id);
        }
        $performancecriteria_vid = 19;
        $data['allperformancecriteriacriteria'] = $this->taxonomy->getcriteriaTaxonomybycriteriacategory($performancecriteria_vid);

        $performancecriteriacategory_vid = 18;
        $data['allperformancecriteriacriteriacategory'] = $this->taxonomy->getcriteriaTaxonomybycriteriacategory($performancecriteriacategory_vid);
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->load->view('recruiting/addperformancecriteria',$data);
    }       
}

?>