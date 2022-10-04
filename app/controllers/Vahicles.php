<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vahicles extends CI_Controller {

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
        redirect("vahicles/addcar");
    }
    public function addcar() {    
        if($this->uri->segment(3)){
            $id = ($this->uri->segment(3)) ;
            $data['toedit_id']=$id;                     
            $data['car_info'] = $this->car_info_model->getcar_info($id);
            $data['car_documents']=$this->car_info_model->getallcontentByid($id);  
            $data['documents'] = $this->car_info_model->getsinglebiodocuments($id);                   
        }
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->session->set_userdata('session_redirect', $this->uri->uri_string());
        $data['allemployee']=$this->search_field_emp_model->getallemployee();
        $this->load->view('car/addcar',$data);
    }   
public function addrequisition(){
        if($this->input->post()){
            $this->form_validation->set_rules('emp_name', 'Requester Name', 'required');
            $this->form_validation->set_rules('Requisition_Date', 'Requisition Date', 'required');
            $this->form_validation->set_rules('Requisition_Location', 'Requisition Location', 'required');
            $this->form_validation->set_rules('Requisition_Time', 'Requisition Time', 'required');
            if($this->form_validation->run()==FALSE)
            {
                $this->session->set_flashdata('errors', validation_errors());
            }else{
                $this->add_carrequisition_controller->add_carrequisition_action($this->input->post());
            }
        }          
        if($this->uri->segment(3)){
            $id = ($this->uri->segment(3)) ;
            $data['toedit_id']=$id;                     
            $data['requisition_info'] = $this->car_info_model->getrequisition_info($id);
            $data['car_documents']=$this->car_info_model->getallcontentByid($id);  
            $data['documents'] = $this->car_info_model->getsinglebiodocuments($id);                   
        }
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->session->set_userdata('session_redirect', $this->uri->uri_string());
        $data['allemployee']=$this->search_field_emp_model->getallemployee();
        $data['alltransportemployee']=$this->car_info_model->getalltransportemployee();
        $data['allactivecar']=$this->car_info_model->getallactivecar();
        $this->load->view('car/addcarrequisition',$data);    
}
public function addcarlog(){
        if($this->input->post()){
            $this->form_validation->set_rules('emp_name', 'Requester Name', 'required');
            $this->form_validation->set_rules('Requisition_Date', 'Requisition Date', 'required');
            $this->form_validation->set_rules('Requisition_Location', 'Requisition Location', 'required');
            $this->form_validation->set_rules('Requisition_Time', 'Requisition Time', 'required');
            if($this->form_validation->run()==FALSE)
            {
                $this->session->set_flashdata('errors', validation_errors());
            }else{
                $this->add_carrequisition_controller->add_carrequisition_action($this->input->post());
            }
        }          
        if($this->uri->segment(3)){
            $id = ($this->uri->segment(3)) ;
            $data['toedit_id']=$id;                     
            $data['requisition_info'] = $this->car_info_model->getrequisition_info($id);
            $data['car_documents']=$this->car_info_model->getallcontentByid($id);  
            $data['documents'] = $this->car_info_model->getsinglebiodocuments($id);                   
        }
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->session->set_userdata('session_redirect', $this->uri->uri_string());
        $data['allemployee']=$this->search_field_emp_model->getallemployee();
        $data['alltransportemployee']=$this->car_info_model->getalltransportemployee();
        $data['allactivecar']=$this->car_info_model->getallactivecar();
        $this->load->view('car/addcarlog',$data);    
}
    function do_upload()
    {

        $this->form_validation->set_rules('vehicle_name', 'Vehicle Name', 'required');
        $this->form_validation->set_rules('vehicle_code', 'Vehicle Code', 'required');
        $this->form_validation->set_rules('vehicle_owner', 'Vehicle Owner', 'required');
        $default_driver_id = $this->input->post('default_driver');
        if($default_driver_id){
        $emp_id = $this->employee_id_model->getemp_idby_empcode($default_driver_id); 
        }else{
           $emp_id= "";
        }
        
        $id=$this->input->post('id');
        $edit_vehicle_code=$this->input->post('vehicle_code');
        if($id){
            $this->form_validation->set_rules('vehicle_code', 'Vehicle Code', 'callback_edit_unique[car_info.Car_Code.' . $edit_vehicle_code . ']');
        }else{
            $this->form_validation->set_rules('vehicle_code', 'Vehicle Code', 'is_unique[car_info.Car_Code]');
        }
        if($this->form_validation->run()==FALSE)
        {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('vahicles/addcar');
            //redirect($this->session->flashdata('redirect'));
        }else{
            $content_edit_id=$this->input->post('id');
            if(!$content_edit_id){
                $params_info =array('id'=>'', 'Car_Code'=>$this->input->post('vehicle_code'), 'Vehicle_Name'=>$this->input->post('vehicle_name'), 'Vehicle_Owner'=>$this->input->post('vehicle_owner'), 'Vehicle_Model'=>$this->input->post('vehicle_model'), 'Model_Year'=>$this->input->post('vehicle_model_year'), 'Purchase_Date'=>$this->input->post('purchase_date'), 'Plate'=>$this->input->post('vehicle_plate'), 'Total_Seats'=>$this->input->post('Total_Seats'),  'Make'=>$this->input->post('make'),  'Chassis_number'=>$this->input->post('Chassis_number'),  'Engine'=>$this->input->post('engine'), 'Transmission'=>$this->input->post('transmission'), 'Tire_Size'=>$this->input->post('tire_size'), 'Color'=>$this->input->post('vehicle_color'), 'Notes'=>$this->input->post('notes'), 'Insurance_Company'=>$this->input->post('insurance_company'), 'Insurance_Account'=>$this->input->post('insurance_account'), 'Insurance_Premium'=>$this->input->post('insurance_premium'), 'Insurance_Date'=>$this->input->post('insurance_paid_date'), 'Insurance_Due'=>$this->input->post('insurance_due'), 'Route_Permit_Date'=>$this->input->post('Route_Permit_date'), 'Route_Permit_Cost'=>$this->input->post('Route_Permit_cost'), 'Tax_Token_Date'=>$this->input->post('tax_token_date'), 'Tax_Renewal_Date'=>$this->input->post('tax_renewal_date'), 'Tax_Cost'=>$this->input->post('tax_cost'), 'Fitness_Exp'=>$this->input->post('fitness_expire'), 'Fitness_Cost'=>$this->input->post('fitness_cost'), 'Plate_Renewal_Date'=>$this->input->post('plate_renewal_date'), 'Car_Status'=>$this->input->post('car_status'), 'Car_Status_Date'=>$this->input->post('status_date'), 'default_driver_emp_id'=>$emp_id, 'default_driver_phone'=>$this->input->post('Driver_Phone'), 'Created_By'=>$this->session->userdata('user_id'), 'Created_Time'=>getCurrentDateTime(), 'Updated_By'=>$this->session->userdata('user_id'), 'Updated_Time'=>getCurrentDateTime(), 'Reserved1'=>'');

                $this->db->insert("car_info",$params_info);
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
                            'upload_path'   => './resources/uploads/cars/',
                            'allowed_types' => 'gif|jpg|png',
                            'max_size'      => '3000',
                            'remove_spaces' => TRUE,
                            'file_name'     => $new_name,
                            );
                        if($file['name']){
                            $params_content = array(
                                'id'            => '',
                                'car_id'        => $insert_id,
                                'field_repeat'  => $content_repeat,
                                'field_name'    => 'resources/uploads/cars',
                                'field_value'   => $new_name,
                                ); 
                            $this->db->insert("car_documents", $params_content);
                            $content_repeat++; 
                        }              
                    }else{
                        if($file['name']){
                            $upload_conf = array(
                                'upload_path'   => './resources/uploads/cars/documents/',
                                'allowed_types' => 'gif|jpg|png|pdf|doc|docs|txt',
                                'max_size'      => '30000',
                                'remove_spaces' => TRUE,
                                'file_name'     => $new_name,
                                );
                            $params_content2 = array(
                                'id'            => '',
                                'car_id'        => $insert_id,
                                'field_repeat'  => $content_repeat2,
                                'field_name'    => 'resources/uploads/cars/documents',
                                'field_value'   => $new_name,
                                );
                            $this->db->insert("car_documents", $params_content2);
                            $content_repeat2++; 
                        }               
                    }
                    if($file['name']){
                        $this->upload->initialize( $upload_conf );
                        $this->upload->do_upload($field_name);
                    }

                }
                //end of documents uploads 
  
                    $this->session->set_flashdata('success', "Data Added");
                redirect('vahicles/addcar/'.$insert_id);   
                   // redirect($this->session->flashdata('redirect'));         
                }else if($content_edit_id){ // content edit start
                    // $status=$this->input->post('field_publish_status');
                    $params_update_date = array('Car_Code'=>$this->input->post('vehicle_code'), 'Vehicle_Name'=>$this->input->post('vehicle_name'), 'Vehicle_Owner'=>$this->input->post('vehicle_owner'), 'Vehicle_Model'=>$this->input->post('vehicle_model'), 'Model_Year'=>$this->input->post('vehicle_model_year'), 'Purchase_Date'=>$this->input->post('purchase_date'), 'Plate'=>$this->input->post('vehicle_plate'), 'Total_Seats'=>$this->input->post('Total_Seats'),  'Make'=>$this->input->post('make'),  'Chassis_number'=>$this->input->post('Chassis_number'),  'Engine'=>$this->input->post('engine'), 'Transmission'=>$this->input->post('transmission'), 'Tire_Size'=>$this->input->post('tire_size'), 'Color'=>$this->input->post('vehicle_color'), 'Notes'=>$this->input->post('notes'), 'Insurance_Company'=>$this->input->post('insurance_company'), 'Insurance_Account'=>$this->input->post('insurance_account'), 'Insurance_Premium'=>$this->input->post('insurance_premium'), 'Insurance_Date'=>$this->input->post('insurance_paid_date'), 'Insurance_Due'=>$this->input->post('insurance_due'), 'Route_Permit_Date'=>$this->input->post('Route_Permit_date'), 'Route_Permit_Cost'=>$this->input->post('Route_Permit_cost'), 'Tax_Token_Date'=>$this->input->post('tax_token_date'), 'Tax_Renewal_Date'=>$this->input->post('tax_renewal_date'), 'Tax_Cost'=>$this->input->post('tax_cost'), 'Fitness_Exp'=>$this->input->post('fitness_expire'), 'Fitness_Cost'=>$this->input->post('fitness_cost'),  'Plate_Renewal_Date'=>$this->input->post('plate_renewal_date'), 'Car_Status'=>$this->input->post('car_status'), 'Car_Status_Date'=>$this->input->post('status_date'), 'default_driver_emp_id'=>$emp_id, 'default_driver_phone'=>$this->input->post('Driver_Phone'), 'Updated_By'=>$this->session->userdata('user_id'), 'Updated_Time'=>getCurrentDateTime());
                    // echo "<pre>";
                    // print_r($params_update_date);
                    // echo "</pre>";
                    // die();
                        $condition=array('id'=>$content_edit_id);
                    $this->car_info_model->updcar_infotbl($params_update_date, $condition);
                    // update image
                    $current_removed_docs=$this->input->post('curr_doc_');
                    foreach($current_removed_docs as $single_remo_docskey=>$single_remo_docs){
                        if($single_remo_docs){
                            $this->car_info_model->deletesinglebiodocuments($content_edit_id, $single_remo_docskey);
                            unlink('./resources/uploads/cars/documents/'.$single_remo_docs);
                        }
                    } 
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
                    $last_repeat_id=$this->car_info_model->getbiodocumentsrepeatid($content_edit_id);
                    $content_repeat2=$last_repeat_id['field_repeat']+1;
                    foreach($_FILES as $field_name => $file)
                    {

                        $new_name = time()."_".$file['name'];
                        $new_name = str_replace(' ', '_', $new_name);
                        $lastDot = strrpos($new_name, ".");
                        $new_name = str_replace(".", "", substr($new_name, 0, $lastDot)) . substr($new_name, $lastDot);
                        if($field_name=="file_1"){
                            $upload_conf = array(
                                'upload_path'   => './resources/uploads/cars/',
                                'allowed_types' => 'gif|jpg|png',
                                'max_size'      => '3000',
                                'remove_spaces' => TRUE,
                                'file_name'     => $new_name,
                                );
                            $params_image_content = array(
                                'car_id'                =>  $content_edit_id, 
                                'field_value'           =>  $new_name,
                                );
                            $params_new_img_content = array(
                                'id'                    => '',
                                'car_id'                =>  $content_edit_id,
                                'field_repeat'          =>  $content_repeat,
                                'field_name'            =>  'resources/uploads/cars',
                                'field_value'           =>  $new_name,
                                );
                            if($file['name']){
                                $file_name_value="resources/uploads/cars";
                                $current_img=$this->input->post('current_img');
                                $image_exist=$this->car_info_model->getcontentByidandname($content_edit_id, $file_name_value);
                                if($image_exist){
                                    $update_condition=array('car_id' => $content_edit_id,'field_name' => $file_name_value);
                                    $this->car_info_model->updContenttbl($params_image_content, $update_condition);
                                    unlink('./resources/uploads/cars/'.$current_img);
                                }else{
                                    $this->db->insert("car_documents",$params_new_img_content); 
                                }
                            }
                            $content_repeat++;               
                        }else{
                            if($file['name']){
                                $upload_conf = array(
                                    'upload_path'   => './resources/uploads/cars/documents/',
                                    'allowed_types' => 'gif|jpg|png|pdf|doc|docs|txt',
                                    'max_size'      => '30000',
                                    'remove_spaces' => TRUE,
                                    'file_name'     => $new_name,
                                    );
                                $params_content2 = array(
                                    'id'            => '',
                                    'car_id'        => $content_edit_id,                      
                                    'field_repeat'  => $content_repeat2,
                                    'field_name'    => 'resources/uploads/cars/documents',
                                    'field_value'   => $new_name,
                                    );
                                $this->db->insert("car_documents", $params_content2);
                                $content_repeat2++; 
                            }               
                        }
                        if($file['name']){
                            $this->upload->initialize( $upload_conf );
                            $this->upload->do_upload($field_name);
                        }

                    }
// end of update image and start of update or insert image
                    
                
$this->session->set_flashdata('success', "Data Updated");
//redirect('addprofile/addemployee');
redirect('vahicles/addcar/'.$content_edit_id); 
//redirect($this->session->flashdata('redirect'));

}                     
}
}

public function edit_unique($value, $params) {
    $this->form_validation->set_message('edit_unique', 'The %s is already being used by another account.');

    list($table, $field, $id) = explode(".", $params, 3);

    $query = $this->db->select($field)->from($table)
    ->where($field, $value)->where('Car_Code !=', $id)->limit(1)->get();

    if ($query->row()) {
        return false;
    } else {
        return true;
    }
}



public function getcarcodeid() {
    header('Content-type: application/json');
    $vehicle_code = $this->input->post('vehicle_code');
    $car_id = $this->car_info_model->getcar_infobycardcode($vehicle_code);
    echo json_encode($car_id);

}


    public function getactivetab() {
        header('Content-type: application/json');
        $activeid = $this->input->post('activeid');
        if($activeid){
            $sessiondata = array(
                'activeid' => "",
            );            
           $this->session->set_userdata($sessiondata);
            $sessiondata = array(
                'activeid' => $activeid,
            );
        $this->session->set_userdata($sessiondata); 
        }

        echo json_encode($this->session->userdata('activeid'));
    }    
    function viewcarcost() {

        $searchpage="viewcarcost";
        $table_name="car_cost";
        if($this->input->post()){
        $query=" id !=0 ";
        $Vehicle_id=$this->input->post('Vehicle_Name');
        $Bearer_id=$this->input->post('Bearer_Name');
        $Expense_type_id=$this->input->post('Expense_type');
        $Expense_date_from1=$this->input->post('Expense_date_from1');
        $Expense_date_to1=$this->input->post('Expense_date_to1');
        if ($Vehicle_id) {
            $query .= " AND car_id LIKE '$Vehicle_id'";
        }  
        if ($Expense_type_id) {
            $query .= " AND Cost_Type LIKE '$Expense_type_id'";
        }    
        if ($Bearer_id) {
            $query .= " AND buyer LIKE '$Bearer_id'";
        } 
        if ($Expense_date_from1 && $Expense_date_to1) {
            $expensedatefrom = explode("-", $Expense_date_from1);
            $finalexpensedatefrom=$expensedatefrom[2]."-".$expensedatefrom[1]."-".$expensedatefrom[0];
            $expensedateto = explode("-", $Expense_date_to1);
            $finalexpensedateto=$expensedateto[2]."-".$expensedateto[1]."-".$expensedateto[0];
            $query .= " AND str_to_date(Cost_Date, '%d-%m-%Y') BETWEEN '$finalexpensedatefrom' AND '$finalexpensedateto'";
        } else if ($Expense_date_from1) {
            $expensedatefrom = explode("-", $Expense_date_from1);
            $finalexpensedatefrom=$expensedatefrom[2]."-".$expensedatefrom[1]."-".$expensedatefrom[0];
            $query .= " AND str_to_date(Cost_Date, '%d-%m-%Y') >='$finalexpensedatefrom'";
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
        }      
        $config = array();
        $config["base_url"] = base_url() . "vahicles/viewcarcost";
        $total_row = $this->car_info_model->data_count($searchpage);
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
        $data["records"] = $this->car_info_model->get_all_record($config["per_page"], $page, $searchpage);       
        $allcontent = array();
        $i = 0;
        // $data['records'] = $allname;
        $data['total_search'] = $total_row;
        $column="car_id";
        $data['cost_car'] = $this->car_info_model->getcarcostbycolumn($column);
        $column="buyer";
        $data['cost_bearer'] = $this->car_info_model->getcarcostbycolumn($column);
        $column="Cost_Type";
        $data['alladdedcost_type'] = $this->car_info_model->getcarcostbycolumn($column);
                
        $this->load->view('car/viewcarcost', $data);
    }
    function viewrequisition() {

        $searchpage="viewrequisition";
        $table_name="car_cost";
        if($this->input->post()){
        $query=" id !=0 ";
        $Requester_Name=$this->input->post('Requester_Name');
        $Requisition_Location=$this->input->post('Requisition_Location');
        $Requisition_Status=$this->input->post('Requisition_Status');
        $requisition_date_from1=$this->input->post('requisition_date_from1');
        $requisition_date_to1=$this->input->post('requisition_date_to1');
        if ($Requester_Name) {
            $query .= " AND requester_content_id LIKE '$Requester_Name'";
        }  
        if ($Requisition_Location) {
            $query .= " AND Requisition_Location LIKE '$Requisition_Location'";
        }    
        if ($Requisition_Status) {
            $query .= " AND status LIKE '$Requisition_Status'";
        } 
        if ($requisition_date_from1 && $requisition_date_to1) {
            $requisitiondatefrom = explode("-", $requisition_date_from1);
            $finalrequisitiondatefrom=$requisitiondatefrom[2]."-".$requisitiondatefrom[1]."-".$requisitiondatefrom[0];
            $requisitiondateto = explode("-", $requisition_date_to1);
            $finalrequisitiondateto=$requisitiondateto[2]."-".$requisitiondateto[1]."-".$requisitiondateto[0];
            $query .= " AND str_to_date(Requisition_Date, '%d-%m-%Y') BETWEEN '$finalrequisitiondatefrom' AND '$finalrequisitiondateto'";
        } else if ($requisition_date_from1) {
            $requisitiondatefrom = explode("-", $requisition_date_from1);
            $finalrequisitiondatefrom=$requisitiondatefrom[2]."-".$requisitiondatefrom[1]."-".$requisitiondatefrom[0];
            $query .= " AND str_to_date(Requisition_Date, '%d-%m-%Y') >='$finalrequisitiondatefrom'";
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
        }      
        $config = array();
        $config["base_url"] = base_url() . "vahicles/viewrequisition";
        $total_row = $this->car_info_model->search_requisition_count($searchpage);  
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
        $data["records"] = $this->car_info_model->get_all_requisition_data($config["per_page"], $page, $searchpage);  
        $allcontent = array();
        $i = 0;
        // $data['records'] = $allname;
        $data['total_search'] = $total_row;
        $column="requester_content_id";
        $data['allrequester'] = $this->car_info_model->getcarrequester($column);
        $column="Requisition_Location";
        $data['allrequisition_location'] = $this->car_info_model->getcarrequester($column);
        $this->load->view('car/viewcarrequisition', $data);
    }
}

?>