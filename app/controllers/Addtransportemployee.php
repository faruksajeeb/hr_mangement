<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Addtransportemployee extends CI_Controller {

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
        
    }

    public function index() {

        //$this->load->view('recruiting/addprofile');
        redirect("addtransportemployee/addemployee");
    }
    public function addemployee() {    
        if($this->uri->segment(3)){
            $id = ($this->uri->segment(3)) ;
            $data['toedit_id']=$id;
            $driver_info=$this->car_info_model->getemp_info($id);  
            $content_id=$driver_info['content_id'];                 
            $data['trans_emp_info'] = $this->car_info_model->getemp_info($id);
            $data['documents'] = $this->car_info_model->getdriverdocuments($content_id);                   
        }
        $this->session->set_flashdata('redirect', $this->uri->uri_string());
        $this->session->set_userdata('session_redirect', $this->uri->uri_string());
        $data['allemployee']=$this->search_field_emp_model->getallemployee();
        $this->load->view('car/addpersonnel',$data);
    }   

    function do_upload()
    {

        $this->form_validation->set_rules('Emp_Code', 'Emp Code', 'required');
        $Emp_Code = $this->input->post('Emp_Code');
        if($Emp_Code){
        $content_id = $this->employee_id_model->getemp_idby_empcode($Emp_Code); 
        }

        if($content_id){
            $this->form_validation->set_rules('vehicle_code', 'Vehicle Code', 'callback_edit_unique[car_emp_info.content_id.' . $content_id . ']');
        }else{
            $this->form_validation->set_rules('vehicle_code', 'Vehicle Code', 'is_unique[car_emp_info.content_id]');
        }
        if($this->form_validation->run()==FALSE)
        {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('addtransportemployee/addemployee');
            //redirect($this->session->flashdata('redirect'));
        }else{
            $content_edit_id=$this->input->post('id');
            if(!$content_edit_id){
                $params_info =array('id'=>'', 'content_id'=>$content_id, 'emp_office_phone'=>$this->input->post('emp_office_phone'), 'emp_phone'=>$this->input->post('emp_phone'), 'emp_emergency_contact'=>$this->input->post('emp_emergency_contact'), 'emp_driving_license'=>$this->input->post('emp_driving_license'), 'License_Expires_Date'=>$this->input->post('License_Expires_Date'), 'notes'=>$this->input->post('notes'),  'driver_status'=>$this->input->post('driver_status'),'created_by'=>$this->session->userdata('user_id'), 'created_time'=>getCurrentDateTime(), 'updated_by'=>$this->session->userdata('user_id'), 'updated_time'=>getCurrentDateTime(), 'reserved'=>'');

                $this->db->insert("car_emp_info",$params_info);
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
                            'upload_path'   => './resources/uploads/cars/drivers/',
                            'allowed_types' => 'gif|jpg|png',
                            'max_size'      => '3000',
                            'remove_spaces' => TRUE,
                            'file_name'     => $new_name,
                            );
                        if($file['name']){
                            $params_content = array(
                                'id'            => '',
                                'content_id'    => $content_id,
                                'emp_id'        => $Emp_Code,
                                'field_repeat'  => $content_repeat,
                                'field_name'    => 'resources/uploads/cars/drivers',
                                'field_value'   => $new_name,
                                ); 
                            $this->db->insert("emp_details", $params_content);
                            $content_repeat++; 
                        }              
                    }else{             
                        if($file['name']){
                            $upload_conf = array(
                                'upload_path'   => './resources/uploads/cars/drivers/documents/',
                                'allowed_types' => 'gif|jpg|png|pdf|doc|docs|txt',
                                'max_size'      => '30000',
                                'remove_spaces' => TRUE,
                                'file_name'     => $new_name,
                                );
                            $params_content2 = array(
                                'id'            => '',
                                'content_id'    => $content_id,
                                'emp_id'        => $Emp_Code,
                                'field_repeat'  => $content_repeat2,
                                'field_name'    => 'resources/uploads/cars/drivers/documents',
                                'field_value'   => $new_name,
                                );
                            $this->db->insert("emp_details", $params_content2);
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
                redirect('addtransportemployee/addemployee/'.$insert_id);   
                   // redirect($this->session->flashdata('redirect'));         
                }else if($content_edit_id){ // content edit start
                    // $status=$this->input->post('field_publish_status');
                    $params_update_date = array('emp_office_phone'=>$this->input->post('emp_office_phone'), 'emp_phone'=>$this->input->post('emp_phone'), 'emp_emergency_contact'=>$this->input->post('emp_emergency_contact'), 'emp_driving_license'=>$this->input->post('emp_driving_license'), 'License_Expires_Date'=>$this->input->post('License_Expires_Date'), 'notes'=>$this->input->post('notes'),  'driver_status'=>$this->input->post('driver_status'),'updated_by'=>$this->session->userdata('user_id'), 'updated_time'=>getCurrentDateTime());
                        $condition=array('id'=>$content_edit_id);
                        $tblname="car_emp_info";
                        $this->car_info_model->updanytbl($params_update_date, $condition, $tblname);
                    // update image
                    $current_removed_docs=$this->input->post('curr_doc_');
                    foreach($current_removed_docs as $single_remo_docskey=>$single_remo_docs){
                        if($single_remo_docs){
                            $this->car_info_model->deletedriverdocuments($content_id, $single_remo_docskey);
                            unlink('./resources/uploads/cars/drivers/documents/'.$single_remo_docs);
                        }
                    } 
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
                    $last_repeat_id=$this->car_info_model->getdriverdocumentsrepeatid($content_id);
                    $content_repeat2=$last_repeat_id['field_repeat']+1;
                    foreach($_FILES as $field_name => $file)
                    {

                        $new_name = time()."_".$file['name'];
                        $new_name = str_replace(' ', '_', $new_name);
                        $lastDot = strrpos($new_name, ".");
                        $new_name = str_replace(".", "", substr($new_name, 0, $lastDot)) . substr($new_name, $lastDot);
                        if($field_name=="file_1"){
                            $upload_conf = array(
                                'upload_path'   => './resources/uploads/cars/drivers/',
                                'allowed_types' => 'gif|jpg|png',
                                'max_size'      => '3000',
                                'remove_spaces' => TRUE,
                                'file_name'     => $new_name,
                                );
                            $params_image_content = array(
                                'content_id'            =>  $content_id, 
                                'field_value'           =>  $new_name,
                                );
                            $params_new_img_content = array(
                                'id'                    => '',
                                'content_id'            => $content_id,
                                'emp_id'                => $Emp_Code,                                
                                'field_repeat'          =>  $content_repeat,
                                'field_name'            =>  'resources/uploads/cars/drivers',
                                'field_value'           =>  $new_name,
                                );
                            if($file['name']){
                                $file_name_value="resources/uploads/cars/drivers";
                                $current_img=$this->input->post('current_img');
                                $image_exist=$this->car_info_model->getdriverimgByidandname($content_id, $file_name_value);
                                if($image_exist){
                                    $update_condition=array('content_id' => $content_id,'field_name' => $file_name_value);
                                    $tblname="emp_details";
                                    $this->car_info_model->updanytbl($params_image_content, $update_condition, $tblname);
                                    unlink('./resources/uploads/cars/drivers/'.$current_img);
                                }else{
                                    $this->db->insert("emp_details",$params_new_img_content); 
                                }
                            }
                            $content_repeat++;               
                        }else{
                            if($file['name']){
                                $upload_conf = array(
                                    'upload_path'   => './resources/uploads/cars/drivers/documents/',
                                    'allowed_types' => 'gif|jpg|png|pdf|doc|docs|txt',
                                    'max_size'      => '30000',
                                    'remove_spaces' => TRUE,
                                    'file_name'     => $new_name,
                                    );
                                $params_content2 = array(
                                    'id'            => '',
                                    'content_id'    => $content_id,
                                    'emp_id'        => $Emp_Code,                       
                                    'field_repeat'  => $content_repeat2,
                                    'field_name'    => 'resources/uploads/cars/drivers/documents',
                                    'field_value'   => $new_name,
                                    );
                                $this->db->insert("emp_details", $params_content2);
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
redirect('addtransportemployee/addemployee/'.$content_edit_id); 
//redirect($this->session->flashdata('redirect'));

}                     
}
}

public function edit_unique($value, $params) {
    $this->form_validation->set_message('edit_unique', 'The %s is already being used by another account.');

    list($table, $field, $id) = explode(".", $params, 3);

    $query = $this->db->select($field)->from($table)
    ->where($field, $value)->where('content_id !=', $id)->limit(1)->get();

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
}

?>