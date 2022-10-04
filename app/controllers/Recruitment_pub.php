<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Recruitment_pub extends CI_Controller {

  function __construct() {
     error_reporting(0);
    parent::__construct();
    $this->load->library('session');
    $autoload['libraries'] = array('globals');
    $this->load->helper('form');
    $this->load->helper(array('form', 'url'));
    $this->load->library('upload');
    $this->load->library('image_lib');        
    $this->load->library('pagination');  
    $this->load->library("pdf");    
  }

  public function index() {
     //redirect("holidaymaster/add_holiday");
  }


  public function viewcircular(){
   $searchpage="post_circular";
        $config = array();
        $config["base_url"] = base_url() . "recruitment/viewcircular";
        $total_row = $this->re_circular_model->search_record_count();
        $per_page_query = 20;
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
        $data["records"] = $this->re_circular_model->get_all_data($config["per_page"], $page);            
    $jobtitle_vid = 3;
    $data['alljobtitle'] = $this->taxonomy->getTaxonomyByvid($jobtitle_vid);
    $this->load->view("recruitment/view_pub_circular",$data);    
  }

  public function pub_post_details(){
      if($this->uri->segment(3)){
          $id = ($this->uri->segment(3)) ;
          $data['id']=$id;
          $data['toview_records']=$this->re_circular_model->get_data_by_id($id);
      }
                  
    $this->load->view("recruitment/view_pub_post_details",$data);
  }

      public function applynow() {
        // $this->check_permission_controller->check_permission_action("add_edit_profile");
        $qualification_vid = 5; $religion_vid = 6; $marital_status_vid = 7; $bloodgroup_vid = 8;
         $city_vid = 11; $distict_vid = 12; $relative_vid = 14; $jobtitle_vid = 3;
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $user_data=$this->users_model->getuserbyid($user_id);
        $user_division_id=$user_data['user_division'];
        $data['user_info']=$this->users_model->getuserbyid($user_id);
        $data['user_type_id'] =$this->session->userdata('user_type');
        $data['allqualification'] = $this->taxonomy->getTaxonomyByvid($qualification_vid);
        $data['allreligion'] = $this->taxonomy->getTaxonomyByvid($religion_vid);
        $data['allmarital_status'] = $this->taxonomy->getTaxonomyByvid($marital_status_vid);
        $data['allbloodgroup'] = $this->taxonomy->getTaxonomyByvid($bloodgroup_vid);
        $data['alljobtitle'] = $this->taxonomy->getTaxonomyByvid($jobtitle_vid);
        $data['allcity'] = $this->taxonomy->getTaxonomyByvid($city_vid);
        $data['alldistict'] = $this->taxonomy->getTaxonomyByvid($distict_vid);
        $data['allrelative'] = $this->taxonomy->getTaxonomyByvid($relative_vid);
        $data['country']=$this->hs_hr_country->getCountry();
        // $data['allleavetype'] = $this->taxonomy->getTaxonomyByvid($allleavetype_vid);        
        if($this->uri->segment(3)){
            $circular_id = ($this->uri->segment(3)) ;
            $data['circular_id']=$circular_id;                  
            $data['circular_details']=$this->re_circular_model->get_data_by_id($circular_id);                  
        }else{
          redirect('recruitment_pub/viewcircular');
        }
        // $this->session->set_flashdata('redirect', validation_errors());
        //     redirect('addprofile/addemployee');
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->session->set_userdata('session_redirect', $this->uri->uri_string());
        $this->load->view('recruitment/applynow',$data);
    }  

    function do_upload()
    {
        $this->form_validation->set_rules('emp_name', 'Name', 'required');
        $this->form_validation->set_rules('emp_fathername', 'Father\'s Name', 'required');
        $this->form_validation->set_rules('emp_gender', 'Gender', 'required');
        $this->form_validation->set_rules('emp_dob', 'Date of Birth', 'required');
        $edit_id=$this->input->post('content_id');
        if($edit_id){
            $this->form_validation->set_rules('content_id', 'Content ID', 'callback_edit_unique[re_search_field_emp.content_id.' . $edit_id . ']');
            // $this->form_validation->set_rules('emp_id', 'Employee Code', 'callback_edit_unique[search_field_emp.emp_id.' . $edit_id . ']');
        }else{
            $this->form_validation->set_rules('content_id', 'Content ID', 'is_unique[re_employee_id.id]');
            // $this->form_validation->set_rules('emp_id', 'Employee Code', 'required|is_unique[employee_id.emp_id]');
            $this->form_validation->set_rules('content_id', 'Content ID', 'is_unique[re_search_field_emp.content_id]');
            // $this->form_validation->set_rules('emp_id', 'Employee Code', 'required|is_unique[re_search_field_emp.emp_id]');
        }
        if($this->form_validation->run()==FALSE)
        {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('recruitment_pub/viewcircular');
            //redirect($this->session->flashdata('redirect'));
        }else{
            $content_edit_id=$this->input->post('content_id');
            if(!$content_edit_id){
                $content_id=$this->employee_id_model->getLastcontentId();
                $toadd_id=$content_id+1;
                $params_employee_id = array(
                    'id'                    => '',
                    'author'                =>  $this->session->userdata('user_id'),
                    'created'               =>  getCurrentDateTime(),
                    'updated'               =>  getCurrentDateTime(),
                    'status'                =>  1,
                    );
                $content_ids=$this->db->insert("re_employee_id",$params_employee_id);
                $insert_id = $this->db->insert_id(); 
                $file_counter=$_FILES['file'];
                foreach($_FILES['file'] as $key=>$val)
                {
                    $i = 1;
                    foreach($val as $v)
                    {
                        $field_name = "file_".$i;
                        $_FILES[$field_name][$key] = $v;
                        $i++;   
                    }
                }
        // Unset the useless one ;)
                unset($_FILES['file']);
                foreach($_FILES['documents'] as $key=>$val)
                {
                    $i = 1;
                    foreach($val as $v)
                    {
                        $field_name = "documents_".$i;
                        $_FILES[$field_name][$key] = $v;
                        $i++;   
                    }
                }
        // Unset the useless one ;)
                unset($_FILES['documents']);
                $content_repeat=0;
                $content_repeat2=0;
                foreach($_FILES as $field_name => $file)
                {

                    $new_name = time()."_".$file['name'];
                    $new_name = str_replace(' ', '_', $new_name);
                    $lastDot = strrpos($new_name, ".");
                    $new_name = str_replace(".", "", substr($new_name, 0, $lastDot)) . substr($new_name, $lastDot);                    
                    if($field_name=="file_1"){
                        $upload_conf = array(
                            'upload_path'   => './resources/uploads/',
                            'allowed_types' => 'gif|jpg|png',
                            'max_size'      => '3000',
                            'remove_spaces' => TRUE,
                            'file_name'     => $new_name,
                            );
                        if($file['name']){
                            $params_content = array(
                                'id' => '',
                                'content_id'    => $insert_id,
                                'field_repeat'  => $content_repeat,
                                'field_name'    => 'resources/uploads',
                                'field_value'   => $new_name,
                                ); 
                            $this->db->insert("re_emp_details", $params_content);
                            $content_repeat++; 
                        }              
                    }else{
                        if($file['name']){
                            $upload_conf = array(
                                'upload_path'   => './resources/uploads/documents/',
                                'allowed_types' => 'gif|jpg|png|pdf|doc|docs|txt',
                                'max_size'      => '30000',
                                'remove_spaces' => TRUE,
                                'file_name'     => $new_name,
                                );
                            $params_content2 = array(
                                'id' => '',
                                'content_id'    => $insert_id,
                                'emp_id'        => $emp_id,
                                'field_repeat'  => $content_repeat2,
                                'field_name'    => 'resources/uploads/documents',
                                'field_value'   => $new_name,
                                );
                            $this->db->insert("re_emp_details", $params_content2);
                            $content_repeat2++; 
                        }               
                    }
                    if($file['name']){
                        $this->upload->initialize( $upload_conf );
                        $this->upload->do_upload($field_name);
                    }

                }
                //end of documents uploads  
                foreach($this->input->post() as $key => $val){
                     if(trim($val) && $key !='emp_name'  && $key !='content_id' && $key !='emp_gender' && $key !='emp_dob' && $key !='emp_marital_status' && $key !='emp_religion' && $key !='emp_age'   && $key !='emp_current_distict' && $key !='emp_mobile_no' && $key !='emp_nid'  && $key !='current_img' && $key !='total_exp' && $key !='circular_id' && $key !='apply_date' && $key !='interview_date' && $key !='interview_time' && $key !='position_id' && $key !='qualification'){

                        $params_contents = array(
                            'id'                    => '',
                            'content_id'            =>  $insert_id,
                            'field_repeat'          =>  0,
                            'field_name'            =>  $key,
                            'field_value'           =>  trim($val),
                            );
                        $this->db->insert("re_emp_details",$params_contents);
                    }
                } 

                // insert employee search table
                $params_content_id = array(
                    'id'                        => '',
                    'content_id'                =>  $insert_id,
                    'emp_name'                  =>  $this->input->post('emp_name'),
                    'emp_post_id'               =>  $this->input->post('position_id'),
                    'gender'                    =>  $this->input->post('emp_gender'),
                    'dob'                       =>  $this->input->post('emp_dob'),
                    'marital_status'            =>  $this->input->post('emp_marital_status'),
                    'religion'                  =>  $this->input->post('emp_religion'),
                    'age'                       =>  $this->input->post('emp_age'),
                    'distict'                   =>  $this->input->post('emp_current_distict'),
                    'mobile_no'                 =>  $this->input->post('emp_mobile_no'),
                    'national_id'               =>  $this->input->post('emp_nid'),
                    'qualification'             =>  $this->input->post('emp_qualification'),
                    'total_exp'                 =>  $this->input->post('total_exp'), 
                    'apply_date'                =>  $this->input->post('apply_date'), 
                    'interview_date'            =>  "", 
                    'interview_time'            =>  "", 
                    'circular_id'               =>  $this->input->post('circular_id')
                    );
                    $content_ids=$this->db->insert("re_search_field_emp",$params_content_id);
                    $inserted_id=$this->db->insert_id();
                            // insert candidates status    
                    $this->session->set_flashdata('success', "Data Added");
                    redirect('recruitment_pub/viewcircular');   
                   // redirect($this->session->flashdata('redirect'));         
                }                     
}
}

public function edit_unique($value, $params) {
    $this->form_validation->set_message('edit_unique', 'The %s is already being used by another account.');

    list($table, $field, $id) = explode(".", $params, 3);

    $query = $this->db->select($field)->from($table)
    ->where($field, $value)->where('id !=', $id)->limit(1)->get();

    if ($query->row()) {
        return false;
    } else {
        return true;
    }
}

function findcandidates() {
        $searchpage="findcandidates";
        if ($this->input->post('multiple_search_btn')) {
            $searchbyname = $this->input->post('searchbyname');
            $job_title = $this->input->post('job_title_search_multiple');
            $emp_qualification = $this->input->post('emp_qualification');
            $gender = $this->input->post('gendersearch');
            $age_from = $this->input->post('age_from');
            $age_to = $this->input->post('age_to');
            $mobile_no = $this->input->post('mobile_no');
            $emp_religion = $this->input->post('emp_religion');
            $total_exp_frommltpl = $this->input->post('total_exp_frommltpl');
            $total_exp_tomltpl = $this->input->post('total_exp_tomltpl');
            $apply_date_from1 = $this->input->post('apply_date_from1');
            $apply_date_to1 = $this->input->post('apply_date_to1');
            $emp_marital_status = $this->input->post('emp_marital_status');
            $emp_parmanent_distict = $this->input->post('emp_parmanent_distict');
            $status = $this->input->post('status');
            if ($searchbyname) {
                $query = " emp_name LIKE '%$searchbyname'";
            } else {
                $query = " id !=0";
            }

            if ($job_title) {
                $query .= " AND emp_post_id LIKE '$job_title'";
            }
            if ($emp_qualification) {
                $query .= " AND qualification LIKE '$emp_qualification'";
            }
            if ($gender) { 
                $query .= " AND gender LIKE '$gender'";
            }
            if ($age_from && $age_to) {
                $query .= " AND age >=$age_from and age <=$age_to";
            } else if ($age_from) {
                $query .= " AND age >=$age_from";
            }

            if ($mobile_no) {
                $query .= " AND mobile_no LIKE '$mobile_no'";
            }
           if ($emp_religion) {
                $query .= " AND religion LIKE '$emp_religion'";
            }
            if ($emp_marital_status) {
                $query .= " AND marital_status LIKE '$emp_marital_status'";
            }
            if ($emp_parmanent_distict) {
                $query .= " AND distict LIKE '$emp_parmanent_distict'";
            }
            if ($status) {
                $query .= " AND status LIKE '$status'";
            }
            if ($total_exp_frommltpl && $total_exp_tomltpl) {
                $query .= " AND total_exp >=$total_exp_frommltpl and total_exp <=$total_exp_tomltpl";
            } else if ($total_exp_frommltpl) {
                $query .= " AND total_exp >=$total_exp_frommltpl";
            }
            
            if ($apply_date_from1 && $apply_date_to1) {
                $query .= " AND apply_date between '$apply_date_from1' and '$apply_date_to1'";
            } else if ($apply_date_from1) {
                $query .= " AND apply_date >='$apply_date_from1'";
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

            //$allname = $this->db->query($query)->result_array();
        } 
        $config = array();
        $config["base_url"] = base_url() . "recruitment_pub/findcandidates";
        $total_row = $this->re_circular_model->applicant_record_count($searchpage);
        $per_page_query = $this->re_circular_model->getapplicantsearchQuery($searchpage);
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
        $data["records"] = $this->re_circular_model->get_all_applicant_data($config["per_page"], $page, $searchpage);        
            $qualification_vid = 5; $religion_vid = 6; $marital_status_vid = 7; $bloodgroup_vid = 8;
         $city_vid = 11; $distict_vid = 12; $relative_vid = 14; $jobtitle_vid = 3;
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $user_data=$this->users_model->getuserbyid($user_id);
        $user_division_id=$user_data['user_division'];
        $data['user_info']=$this->users_model->getuserbyid($user_id);
        $data['user_type_id'] =$this->session->userdata('user_type');
        $data['allqualification'] = $this->taxonomy->getTaxonomyByvid($qualification_vid);
        $data['allreligion'] = $this->taxonomy->getTaxonomyByvid($religion_vid);
        $data['allmarital_status'] = $this->taxonomy->getTaxonomyByvid($marital_status_vid);
        $data['alldistict'] = $this->taxonomy->getTaxonomyByvid($distict_vid);
        $data['post'] = $this->re_circular_model->getcandidatesbycolumn("emp_post_id");
        $data['exptotla'] = $this->re_circular_model->getcandidatesbycolumn("total_exp");
        $data['age'] = $this->re_circular_model->getcandidatesbycolumn("age");
        // $data['cvtotal'] = $this->search->record_count();
        $data['total_search'] = $total_row;
        $this->load->view('recruitment/allcandidateswithpagination', $data);
    }

     public function submitmultipletask(){
        $searchpage="findcandidates";
        $user_id = $this->session->userdata('user_id');
        $post_data=$this->input->post();
        if($post_data['multiple_task']=="Delete Selected List"){
            foreach ($post_data['content_id'] as $sigle_id) {
                $this->deleteCandidatesBycontentid($sigle_id);
            }
        }else if($post_data['multiple_task']=="Delete Filtered List"){
            $page_query = $this->re_circular_model->get_all_search_emp($searchpage);
            foreach ($page_query as $sigle_content) {
                $content_id=$sigle_content['content_id'];
                $this->deleteCandidatesBycontentid($content_id);
            }
            
        }else if($post_data['multiple_task']=="Download All Candidates List" || $post_data['multiple_task']=="Download Selected Candidates List"){
            $this->candidateslistpdf($post_data);
        }
        redirect("recruitment_pub/findcandidates");

    }

    public function candidateslistpdf($post_data=array()){
       $this->load->library("pdflandscape");
        $searchpage="findcandidates"; 
        if($post_data['multiple_task']=="Download All Candidates List" || $post_data['multiple_task']=="Download Selected Candidates List"){
             $data['candidates_data']=$post_data;
             $mpdf = $this->pdflandscape->load();
             $html = $this->load->view('recruitment/printcandidateslistpdf', $data,true);
              //$mpdf->SetVisibility('printonly'); // This will be my code; 
               $mpdf->SetJS('this.print();');
              $mpdf->WriteHTML(utf8_encode($html));
              $mpdf->Output();  
        }else{
            redirect("recruitment_pub/findcandidates");
        }
                             
  }
function deleteCandidatesBycontentid($content_id) {
            $file_name_value = "resources/uploads";
            $image_exist = $this->re_circular_model->getcontentByidandname($content_id, $file_name_value);
            if($image_exist){
            $current_img = $image_exist[0]['field_value'];
            unlink('./resources/uploads/' . $current_img);
            }
            $this->re_circular_model->deleteCandidatesByid($content_id);
    }

    function addPreselected(){
    header('Content-type: application/json');
    $selected_id=$this->input->post('selected_id');
    $value_inserted=$this->input->post('value_inserted');
    if($value_inserted !="pre-selected"){
        $value_inserted="";
    }
    $params_contents = array(
        'status'         =>  $value_inserted
        );
    $params_condition= array(
        'content_id'         =>  $selected_id
        );
    $this->re_circular_model->updanytbl($params_contents, $params_condition, "re_search_field_emp");
    $search_table_content = $this->re_circular_model->getallsearch_table_contentByid($selected_id);

    echo json_encode($search_table_content);        
}

}

?>