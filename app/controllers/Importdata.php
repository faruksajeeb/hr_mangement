<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Importdata extends CI_Controller {

    function __construct() {
        error_reporting(0);
        parent::__construct();
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
        $this->load->helper(array('form', 'url'));
        $this->load->library('pagination');
        $this->load->library("pdf");
    }

    public function index() {
        $this->check_permission_controller->check_permission_action("import_attendance");
        $path = './resources/uploads/data';
        $this->load->helper("file"); // load the helper
        delete_files($path, true);
        $this->load->view('importbat', $data);
    }

    public function importbatdata() {
        $this->check_permission_controller->check_permission_action("import_attendance");
        $data['error'] = '';    //initialize image upload error array to empty

        $config['upload_path'] = './resources/uploads/data/';
        $config['allowed_types'] = '*';

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()) {
            $data['error'] = $this->upload->display_errors();

            $this->load->view('importbat', $data);
        } else {
            $extra_digits = $this->input->post('add_digit');
            $file_data = $this->upload->data();
            $file_path = './resources/uploads/data/' . $file_data['file_name'];
            if ($fil = fopen($file_path, "r")) {

                $fil = fopen($file_path, "r");
                $quotes = array();
                
                while ($linje = fgets($fil)) {

                    $arr = preg_split('/[\s]+/', trim($linje));
                    
                    foreach ($abc = $arr as $key => $one) {
                        if (strpos($one, 'card_src="from_door"') !== false || 
                                strpos($one, 'card_src="from_check"') !== false || 
                                strpos($one, 'status') !== false || 
                                strpos($one, 'workcode') !== false) {
                            unset($abc[$key]);
                        } else if (strpos($one, 'time="') !== false) {
                            unset($abc[$key]);
                            $abc[0] = str_replace('time="', '', $one);
                        } else if (strpos($one, 'id="') !== false) {
                            unset($abc[$key]);
                            $emp_code = str_replace('id="', '', $one);
                            $emp_code = str_replace('"', '', $emp_code);
                            $abc[2] = $emp_code;
                        } else if (strpos($one, '"') !== false && $key == 1) {
                            unset($abc[$key]);
                            $abc[1] = str_replace('"', '', $one);
                        }
                    }
                   

                   
                    $last_day_last_month = date("d-m-Y", mktime(0, 0, 0, date("m"), 0, date("Y")));
                    $first_day_last_month = date("d-m-Y", mktime(0, 0, 0, date("m") - 1, 1, date("Y")));
                    $atte_date = $abc[0];
                    $attInfo[] = $abc;
                   
                    if (strtotime($atte_date) >= strtotime($first_day_last_month) && 
                            strtotime($atte_date) <= strtotime($last_day_last_month)) {
                        $quotes[] = $abc;
                    } else if ($abc[0] == 'Return(result="success"') {
                        $quotes[] = $abc;
                    }
                }
                 
                 
                $final_att_arr = array();

                foreach ($quotes as $key1 => $val1) {
                    if ($val1[1]) {
                        $time[$key1] = $val1[1];
                        $array_sub = array(
                            'a' => $val1[2], 
                            'b' => $val1[0], 
                            'c' => $val1[1]
                        );
                        $final_att_arr[] = $array_sub;
                    }
                }
                
                $final_records = record_sort($final_att_arr, "c");
                
                if ($quotes[0][0] == 'Return(result="success"') {

                    foreach ($final_records as $key1 => $value1) {
                        $attendance_date = $value1['b'];
                        $emp_log_time = $value1['c'];
                        $emp_code = $value1['a'];
                        $newDate = date("d-m-Y", strtotime($attendance_date));
                        $post_data = array(
                            'emp_code' => $emp_code, 
                            'attendance_date' => $newDate, 
                            'emp_log_time' => $emp_log_time
                        );
                         
                        $this->upload_attendance_controller->add_attendance_action($post_data);
                    }
                } else {
//                    echo "<pre/>";
//                    print_r($attInfo);
//                    exit;
                  
                    foreach ($attInfo as $key => $value) {
                        $emp_code = $value[0];
                        if ($extra_digits) {
                            $emp_code = $extra_digits . $value[0];
                        }
                        $newDate = date("d-m-Y", strtotime($value[1]));
                        $attendance_date = explode("-", $value[1]);
                        $attendance_date = $attendance_date[2] . "-" . $attendance_date[1] . "-" . $attendance_date[0];
                        $emp_log_time = $value[2];
                        $post_data = array(
                            'emp_code' => $emp_code, 
                            'attendance_date' => $newDate, 
                            'emp_log_time' => $emp_log_time
                        );
                       
                        $this->upload_attendance_controller->add_attendance_action($post_data);
                    }
                    
                }
                
                $this->session->set_flashdata('success', 'Data Imported Succesfully');

                redirect(base_url() . 'importdata');
            } else {
                $data['error'] = "Error occured";
                $this->load->view('importbat', $data);
            }
        }
    }

}

?>
