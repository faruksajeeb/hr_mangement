<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SaveExcel extends CI_Controller {
    function __construct() {
      error_reporting(0);
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }
    
    function monthlySalaryStatementReport(){
        
    }
}