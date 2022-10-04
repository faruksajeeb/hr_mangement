<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BackupController
 *
 * @author Administrator
 */
class BackupController extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function software_backup() {

        $this->load->helper('download');
        $this->load->library('zip');
        $time = time();
        $this->zip->read_dir('../public_html/');
        $this->zip->download('my_backup.' . $time . '.zip');
    }

    function Export_Database() {
        $this->load->view('export_database');
    }
  


}
