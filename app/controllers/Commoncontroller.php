<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommonController
 *
 * @author Administrator
 */
class CommonController extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('CommonModel');
    }

    
        
    public function resignation_employee() {
        $content_id=$this->input->post('content_id',true);      
        $resign_date=$this->input->post('resign_date',true);
        $resign_reason=$this->input->post('resign_reason',true); 
       
        $this->CommonModel->update_resignation_emp_job_history_info($content_id,$resign_date,$resign_reason);
        $this->CommonModel->update_resignation_type_of_employee_info($content_id);
        redirect('findemployeelist/contentwithpagination');
    }
    public function termination_employee() {
        $content_id=$this->input->get_post('cont_id',true);       
        $terminate_date=$this->input->get_post('terminate_date',true);
        $terminate_reason=$this->input->get_post('terminate_reason',true);   
       
        $this->CommonModel->update_terminated_emp_job_history_info($content_id,$terminate_date,$terminate_reason);
        $this->CommonModel->update_termination_type_of_employee_info($content_id);
       // redirect('findemployeelist/contentwithpagination');
    }
    
    public function type_of_employee() {
        $table_name = $this->uri->segment(3);
        $status = $this->uri->segment(4);
        $id = $this->uri->segment(5);
        $data = Array();
        if ($status == 'left') {
            $data['type_of_employee'] =153;
        }if ($status == 'terminated') {
            $data['type_of_employee'] =473;
        }
        $this->CommonModel->update_type_of_employee_info($id, $data, $table_name);
        redirect('findemployeelist/contentwithpagination');
    }
    
    public function restore_type_of_employee() {
        $table_name = $this->uri->segment(3);
        $status = $this->uri->segment(4);
        $id = $this->uri->segment(5);
        $data = Array();
        if ($status == 'restore') {
            $data['type_of_employee'] =1;
        }if ($status == 'delete') {
            $data['deletion_status'] =1;
        }
        $this->CommonModel->update_trash_employee_info($id, $data, $table_name);
        redirect('findemployeelist/trash_employee');
    }
public function restore_delete_employee() {
        $table_name = $this->uri->segment(3);
        $id = $this->uri->segment(4);
            $data['deletion_status'] =0;
        $this->CommonModel->update_delete_employee_info($id, $data, $table_name);
        redirect('findemployeelist/all_delete_employee');
    }
    public function multiple_resign_employee() {
         $content_ids = $this->input->get_post('content_id');
         $ids = ( explode( ',',$content_ids));
         $this->CommonModel->resign_multiple_employee_info($ids);

    }
    public function multiple_terminate_employee() {
         $content_ids = $this->input->get_post('content_id');
         $ids = ( explode( ',',$content_ids));
         $this->CommonModel->terminate_multiple_employee_info($ids);

    }
         public function multiple_delete_employee() {
         $content_ids = $this->input->get_post('content_id');
         $ids = ( explode( ',',$content_ids));
        $this->CommonModel->delete_multiple_trash_employee_info($ids);

    }
    public function multiple_restore_employee() {
         $content_ids = $this->input->get_post('content_id');
         //exit($content_ids);
         $ids = ( explode( ',',$content_ids));
         $this->CommonModel->restore_multiple_trash_employee_info($ids);
    }
    
    
    
    
    
    
    
    
    // Publisd / unpublish ---------------------------------------------------------------------------------------------------------------------
    public function publication_update() {
        $table_name = $this->uri->segment(3);
        $status = $this->uri->segment(4);
        $id = $this->uri->segment(5);
        $data = Array();
        if ($status == 'unpublish') {
            $data['publication_status'] = 0;
        }if ($status == 'publish') {
            $data['publication_status'] = 1;
        }
        $this->CommonModel->update_publication_status_info($id, $data, $table_name);
        redirect('findemployeelist/contentwithpagination');
    }
}
