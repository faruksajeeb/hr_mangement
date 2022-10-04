<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notice extends CI_Controller {

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
        //$this->load->library('pagination');
       // $this->load->library("pdf");
        $this->load->model("notice_model");
    }

    public function view_notice() {
        $data = array();
        $data['all_notice'] = $this->notice_model->getAllNotice();
        $this->load->view("notice/view_notice", $data);
    }
    public function insert_notice() {
        
        $this->load->view("notice/notice_form");
    }

    public function save_notice() {
        $date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $publishedDate = date("Y-m-d", strtotime($this->input->post('txt_published_on', true)));
        $data = Array(
            'NoticeName' => $this->input->post('txt_notice_name', true),
            'ShortDescription' => $this->input->post('txt_short_description', true),
            'LongDescription' => $this->input->post('txt_long_description', true),
            'PublishedOn' =>$publishedDate ,
            'CreatedBy' => $this->session->userdata('user_id'),
            'CreatedTime' => $date->format('Y-m-d H:i:s')
        );
        /* Start image upload */
        $config = Array(
            'upload_path' => 'resources/images/notice/',
            'allowed_types' => 'doc|pdf|png|jpg',
            'max_size' => 2000
        );
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $error = '';
        $fdata = Array();
        if (!$this->upload->do_upload('notice_file')) {
            $error = $this->upload->display_errors();
            echo $error;
            //exit();
        } else {
            $fdata = $this->upload->data();
            $data['NoticeFile'] = $config['upload_path'] . $fdata['file_name'];
        }
        /* End image upload */


        $result = $this->notice_model->insert_notice_info($data);
        $sdata = Array();
        if ($result) {
            $sdata['message'] = 'saved';
        } else {
            $sdata['error'] = 'fail';
        }
        $this->session->set_userdata($sdata);
        $this->insert_notice();
    }
    
        public function status() {
        $status = $this->uri->segment(3);
        $id = $this->uri->segment(4);
        $data = array();
        if ($status == 'unpublish') {
            $data['PublicationStatus'] = 0;
        }if ($status == 'publish') {
            $data['PublicationStatus'] = 1;
        }
        $data['UpdatedBy']=$this->session->userdata('user_id');
        $this->notice_model->update_status_info($id, $data);
        $this->view_notice();
    }
    // Details -----------------------------------------------------------------------------------------------  
    public function notice_detail_by_id($id) {

        $data = Array(
            'display_notice_detail_by_id' => $this->notice_model->select_notice_detail_by_id($id)
        );
        //print_r( $data);
        // exit;
        $this->load->view("notice/notice_details", $data);
    }
        // edit ------------------------------------------------------------------------------------------------------------------------------------    
    public function notice_edit_by_id($id) {

        $data = Array(
            'display_notice_detail_by_id' => $this->notice_model->select_notice_detail_by_id($id)
        );

//        print_r( $data);
//         exit;
        $this->load->view("notice/edit_notice", $data);
    }
        public function edit_notice() {
        $id = $this->input->post('notice_id');      

        $date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $publishedDate = date("Y-m-d", strtotime($this->input->post('txt_published_on', true)));
        $data = Array(
            'NoticeName' => $this->input->post('txt_notice_name', true),
            'ShortDescription' => $this->input->post('txt_short_description', true),
            'LongDescription' => $this->input->post('txt_long_description', true),
            'PublishedOn' =>$publishedDate ,
            'UpdatedBy' => $this->session->userdata('user_id')
           
        );
        /* Start image upload */
        $config = Array(
            'upload_path' => 'resources/images/notice/',
            'allowed_types' => 'doc|pdf|png|jpg',
            'max_size' => 2000
        );
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $error = '';
        $fdata = Array();
        if (!$this->upload->do_upload('text_notice_file')) {
            $error = $this->upload->display_errors();
            echo $error;
            //exit();
        } else {
            $fdata = $this->upload->data();
            $data['NoticeFile'] = $config['upload_path'] . $fdata['file_name'];
        }
        /* End image upload */


        $result = $this->notice_model->edit_notice_info($id ,$data);
        $sdata = Array();
        if (!$result) {
            $sdata['message'] = 'Data Updated Sucessfully';
        } else {
            $sdata['error'] = 'fail updated';
        }
        $this->session->set_userdata($sdata);
        $this->session->set_userdata($sdata);
        $this->view_notice();
    }
        //Trash -------------------------------------------------------------------------------------------------------------------------------------
    public function delete_notice() {
        $id = $this->uri->segment(3);
        $this->notice_model->update_notice_deletion_status_info($id);
        redirect('notice/view_notice');
    }
        //---------- Tash View list -------------------------------------------------------------------------------------------------
    public function trash_notice() {
        $data = array();
        $data['all_trash_notice'] = $this->notice_model->getAllTrashNotice();
        $this->load->view("notice/trash_notice", $data);
    }
        // restore -------------------------------------------------------------------------------------------------------------------------------------
    public function restore_notice() {
        $id = $this->uri->segment(3);
        $this->notice_model->restore_notice($id);
        $this->trash_notice();
    }

    //Permanently Delete -------------------------------------------------------------------------------------------------------------------------------------
    public function parmanently_delete_notice() {
        $id = $this->uri->segment(3);
                $result = $this->notice_model->select_notice_detail_by_id($id);
//        print_r($result);
//        exit();

        $notice_file = $result->NoticeFile;
        if (file_exists($notice_file)) {
            if (!unlink($notice_file)) {

                echo ("<script type='text/javascript'> alert('Error deleting $result->NoticeName File'); </script>");
            } else {
                echo ("<script type='text/javascript'> alert('Deleted $result->NoticeName File'); </script>");
            }
        } else {
            echo "<script type='text/javascript'> alert('$result->NoticeName File not found '); </script>";
        }
        //exit();
        $this->notice_model->delete_notice($id);
        $this->trash_notice();
    }

}

?>