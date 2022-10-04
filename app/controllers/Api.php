<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Api
 *
 * @author HP
 */
class Api extends CI_Controller {
    //put your code here
    public function getCurrentJobs(){
        $this->load->model('circular_model');
        $data = $this->circular_model->select_job_info();
        return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($data));
    }
    public function getJobDetailById($id){
        $this->load->model('circular_model');
        $data = $this->circular_model->select_detail_by_id($id);
        return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($data));
    }
    
    public function getEmployeeInfoByContentId($contentId){
        $data = $this->search_field_emp_model->getEmployeeInfoById($contentId);
        return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($data));
    }
}
