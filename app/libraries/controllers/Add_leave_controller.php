<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_leave_controller
{
    public function __construct()
    {
        $this->CI = &get_instance();
    }
    public function insertLeaveApplication($postData, $leaveStartDate, $contentId)
    {

        $leaveYear = date("Y", strtotime($leaveStartDate));
        $insertData = array(
            'content_id' => $contentId,
            'leave_year' => $leaveYear,
            'leave_start_date' => $leaveStartDate,
            'leave_end_date' => $leaveStartDate,
            'leave_total_day' => 1,

            'length_of_services' => $postData['length_of_services'],
            'leave_availed' => $postData['paid_leave'],
            'leave_remaining' => $postData['annual_leave_remaining'],
            'total_leave_availed' => $postData['total_leave_availed'],
            'total_annual_leave_spent' => $postData['annual_leave_spent'],

            'leave_type' => $postData['leave_type'],
            'pay_status' => $postData['leave_pay_status'],
            'justification' => $postData['purpose'],
            'leave_address' => $postData['contact_address'],
            'contact_number' => $postData['contact_number'],
            'department_approval' => 0,
            'approve_status' => "pending",
            'created_time' => getCurrentDateTime(),
            'created_by' => $this->CI->session->userdata('user_id'),
        );
        $this->CI->db->insert("emp_leave", $insertData);
    }
    function add_leave_action($post_data = array(), $toadd_id, $leave_date)
    {
        //$ci=& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('emp_leave_model');
        $leave_category = $post_data['leave_category'];
        $justification = $post_data['justification'];
        $leave_address = $post_data['leave_address'];
        $leave_time_status = $post_data['leave_time_status'];
        if ($leave_time_status == 'half_day') {
            $leave_total_day = '0.50';
        } else {
            $leave_total_day = '1';
        }
        $leave_approve_status = $post_data['leave_approve_status'];
        $pay_status = $post_data['leave_pay_status'];
        if ($leave_category == 'cancel_leave') {
            $this->CI->emp_leave_model->cancelLeave($toadd_id, $leave_date);
        } else {
            $leave_start_date = $leave_date;
            date_default_timezone_set('Asia/Dhaka');
            $leave_year = date("Y", strtotime($leave_start_date));
            $content_exist = $this->CI->emp_leave_model->getemp_leave($toadd_id, $leave_start_date);
            $params_contents = array(
                'id'                    => '',
                'content_id'            =>  $toadd_id,
                'leave_year'            =>  $leave_year,
                'leave_start_date'      =>  $leave_start_date,
                'leave_end_date'        =>  $leave_start_date,
                'leave_total_day'       =>  $leave_total_day,
                'leave_type'            =>  $leave_category,
                'pay_status'            =>  $pay_status,
                'justification'         =>  $justification,
                'leave_address'         =>  $leave_address,
                'approve_status'        =>  $leave_approve_status,
                'created_time'          =>  getCurrentDateTime(),
                'updated_time'          =>  getCurrentDateTime(),
                'created_by'            =>  $this->CI->session->userdata('user_id'),
                'updated_by'            =>  $this->CI->session->userdata('user_id'),
            );
            if ($content_exist) {
                $params_toupdate_contents = array(
                    'leave_year'            =>  $leave_year,
                    'leave_start_date'      =>  $leave_start_date,
                    'leave_end_date'        =>  $leave_start_date,
                    'leave_total_day'       =>  $leave_total_day,
                    'leave_type'            =>  $leave_category,
                    'pay_status'            =>  $pay_status,
                    'justification'         =>  $justification,
                    'leave_address'         =>  $leave_address,
                    'approve_status'        =>  $leave_approve_status,
                    'updated_time'          =>  getCurrentDateTime(),
                    'updated_by'            =>  $this->CI->session->userdata('user_id'),
                );
                $update_conditions = array('content_id' => $toadd_id, 'leave_start_date' => $leave_start_date);
                $this->CI->emp_leave_model->updemp_leavetbl($params_toupdate_contents, $update_conditions);
            } else {
                $this->CI->db->insert("emp_leave", $params_contents);
            }
        }
    }



    function add_yearlyleave_action($post_data = array(), $toadd_id)
    {
        //$ci=& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('emp_leave_model');
        $leave_total_system = $post_data['leave_total_system'];
        $annual_leave_total = $post_data['annual_leave_total'];
        $leave_category_system = $post_data['leave_category_system'];
        $leave_category_system = 'on';
        $annual_leave = $post_data['annual_leave'];
        if ($leave_category_system == 'on') {
            if ($leave_category_system) {
                $this->CI->emp_leave_model->deleteemp_leave_total_system($toadd_id);
                foreach ($annual_leave as $key => $value) {
                    $content_exist = $this->CI->emp_leave_model->getemp_yearlyleave($toadd_id, $key);
                    $params_annual_leave = array(
                        // 'id'                    => '',
                        'content_id'            =>  $toadd_id,
                        'leave_type'            =>  $key,
                        'total_days'            =>  $value,
                        'created_at'    => date('Y-m-d H:i:s'),
                        'created_by' => $this->CI->session->userdata('user_id')
                    );

                    if ($content_exist) {
                        $params_toupdate_contents = array(
                            'leave_type'            =>  $key,
                            'total_days'            =>  $value,
                            'updated_at'    => date('Y-m-d H:i:s'),
                            'updated_by' => $this->CI->session->userdata('user_id')
                        );
                        $update_conditions = array('content_id' => $toadd_id, 'leave_type' => $key);
                        $this->CI->emp_leave_model->updemp_yearly_leavetbl($params_toupdate_contents, $update_conditions);
                    } else {
                        if ($value) {
                            $this->CI->db->insert("emp_yearly_leave", $params_annual_leave);
                        }
                    }
                }
            }
        } elseif ($leave_total_system == 'on') {
            if ($annual_leave_total) {

                $this->CI->emp_leave_model->deleteemp_yearly_leave($toadd_id);
                $total_leavcontent_exist = $this->CI->emp_leave_model->getemp_yearlyleavetotal($toadd_id);
                $params_annual_leavetotal = array(
                    // 'id'                    => '',
                    'content_id'            =>  $toadd_id,
                    'leave_type'            =>  "annual_leave_total",
                    'total_days'            =>  $annual_leave_total,
                );

                if ($total_leavcontent_exist) {
                    $params_toupdate_leavetotal = array(
                        'leave_type'            =>  "annual_leave_total",
                        'total_days'            =>  $annual_leave_total,
                    );
                    $update_conditions = array('content_id' => $toadd_id);
                    $this->CI->emp_leave_model->updemp_yearlytotal_leavetbl($params_toupdate_leavetotal, $update_conditions);
                } else {
                    if ($annual_leave_total) {
                        $this->CI->db->insert("emp_leave_total_system", $params_annual_leavetotal);
                    }
                }
            }
        }
    }


    function add_yearlyleavehistory_action($post_data = array(), $content_id)
    {
        //$ci=& get_instance();
        $this->CI->load->database();
        $leave_total_system = $post_data['leave_total_system'];
        $annual_leave_total = $post_data['annual_leave_total'];
        $leave_category_system = $post_data['leave_category_system'];
        $leave_category_system='on';
        $annual_leave = $post_data['annual_leave'];
        $emp_job_change_date = $post_data['emp_job_change_date'];
        if (!$emp_job_change_date) {
            $emp_job_change_date = $post_data['emp_starting_date'];
        }


        $d1_arr = explode('-', $emp_job_change_date);
        $d1_year = $d1_arr[2];

        $firstday_of_year = $d1_year.'-01-01';
        $lastday_of_year =  $d1_year.'-12-31';

        $this->CI->emp_yearly_leave_history_model->deleteemp_leave_history_emptyvalue();

        if ($leave_total_system == 'on') {
            $this->leave_total_sys_history($content_id, $annual_leave_total, $firstday_of_year, $lastday_of_year);
        } else if ($leave_category_system == 'on') {
            $this->leave_cet_system_history($annual_leave, $content_id, $firstday_of_year, $lastday_of_year);
        }
    }
    function leave_total_sys_history($content_id, $annual_leave_total, $firstday_of_year, $lastday_of_year)
    {

        $this->CI->emp_yearly_leave_history_model->deleteemp_yearly_leave_history($content_id, $firstday_of_year);
        $has_last_history = $this->CI->emp_yearly_leave_history_model->getemp_leave_total_system_history($content_id);
        if ($has_last_history) {
            $previous_id = $has_last_history['id'];
            $previous_start_date = $has_last_history['start_year'];
            $previous_leave_type = $has_last_history['leave_type'];
            $previous_total_days = $has_last_history['total_days'];
            $d1_arr = explode('-', $previous_start_date);
            $d2_arr = explode('-', $firstday_of_year);
            $previous_year = $d1_arr[2];
            $this_year = $d2_arr[2];
            $toadd_year = $d2_arr[2] - 1;
            $end_to_added = '31-12-' . $toadd_year;
            if ($annual_leave_total != $previous_total_days && $this_year >= $previous_year) {

                if ($previous_start_date != $firstday_of_year) {
                    $params = array(
                        'end_year'        =>  $end_to_added,
                        'updated_time'    =>  date('Y-m-d H:i:s'),
                        'updated_by'      =>  $this->CI->session->userdata('user_id'),
                    );
                    $update_condition = array('id' => $previous_id);
                    $this->CI->emp_yearly_leave_history_model->updemp_yearlytotal_leave_historytbl($params, $update_condition);
                    // insert new history
                    $this->insertemphistorytotal_leave($content_id, $firstday_of_year, $lastday_of_year, $annual_leave_total);
                } else {
                    $params = array(
                        'total_days'      =>  $annual_leave_total,
                        'updated_time'    =>  date('Y-m-d H:i:s'),
                        'updated_by'      =>  $this->CI->session->userdata('user_id'),
                    );
                    $update_condition = array('id' => $previous_id);
                    $this->CI->emp_yearly_leave_history_model->updemp_yearlytotal_leave_historytbl($params, $update_condition);
                }

                $this->CI->session->set_userdata("success", "Data Updated!");
            }
        } else {

            $this->insertemphistorytotal_leave($content_id, $firstday_of_year, $lastday_of_year, $annual_leave_total);
        }
    }
    function insertemphistorytotal_leave($content_id, $firstday_of_year, $lastday_of_year, $annual_leave_total)
    {
        $this->CI->load->database();
        $params = array(
            //'id'                    => '',
            'content_id'            =>  $content_id,
            'start_year'            =>  $firstday_of_year,
            'end_year'              =>  "",
            'leave_type'            =>  "annual_leave_total",
            'total_days'            =>  $annual_leave_total,
            'created_time'          =>  date('Y-m-d H:i:s'),
            'created_by'            =>  $this->CI->session->userdata('user_id'),
            // 'updated_time'          =>  date('Y-m-d H:i:s'),
            // 'updated_by'            =>  $this->CI->session->userdata('user_id'),
            // 'reserved1'             =>  "",
            // 'reserved2'             =>  "",
        );

        if ($annual_leave_total) {

            $this->CI->db->insert("emp_leave_total_system_history", $params);
            $insert_id = $this->CI->db->insert_id();
            $this->CI->session->set_userdata("success", "Data Inserted!");
            $msg = "Data inserted";
        }
    }
    function leave_cet_system_history($annual_leave = array(), $content_id, $firstday_of_year, $lastday_of_year)
    {
        $this->CI->emp_yearly_leave_history_model->deleteemp_leave_total_system_history($content_id, $firstday_of_year);
        foreach ($annual_leave as $key => $value) {
            $has_last_history = $this->CI->emp_yearly_leave_history_model->get_last_emp_yearly_leave_cat_history($content_id,  $firstday_of_year, $key);
            if ($has_last_history) {
                $previous_id = $has_last_history['id'];
                $previous_start_date = $has_last_history['start_year'];
                $previous_leave_type = $has_last_history['leave_type'];
                $previous_total_days = $has_last_history['total_days'];
                $d1_arr = explode('-', $previous_start_date);
                $d2_arr = explode('-', $firstday_of_year);
                $previous_year = $d1_arr[2];
                $this_year = $d2_arr[2];
                $toadd_year = $d2_arr[2] - 1;
                $end_to_added = $toadd_year.'-12-31';
                if ($value != $previous_total_days && $this_year >= $previous_year) {

                    if ($previous_start_date != $firstday_of_year) {
                        $params = array(
                            'end_year'        =>  $end_to_added,
                            'updated_time'    =>  date('Y-m-d H:i:s'),
                            'updated_by'      =>  $this->CI->session->userdata('user_id'),
                        );
                        $update_condition = array('id' => $previous_id);
                        $this->CI->emp_yearly_leave_history_model->updemp_yearly_leave_cat_history($params, $update_condition);
                        // insert new history
                        $this->insertemphistory_cat_leave($content_id, $firstday_of_year, $lastday_of_year, $key, $value);
                    } else {
                        //                         echo "<pre>";
                        // print_r($value."==".$previous_total_days."==".$this_year."==".$previous_year."==".$previous_id);
                        // echo "</pre>";
                        // die(); 
                        $params = array(
                            'total_days'      =>  $value,
                            'updated_time'    =>  date('Y-m-d H:i:s'),
                            'updated_by'      =>  $this->CI->session->userdata('user_id'),
                        );
                        // $this->CI->db->query("UPDATE emp_yearly_leave_cat_history 
                        // SET total_days=?,
                        // updated_time=?,
                        // updated_by=? WHERE id=?", array($value,getCurrentDateTime(),$this->CI->session->userdata('user_id'),$previous_id));
                     
                     $update_condition = array('id' => $previous_id);
                        
                        $this->CI->emp_yearly_leave_history_model->updemp_yearly_leave_cat_history($params, $update_condition);
                    }

                    $this->CI->session->set_userdata("success", "Data Updated!");
                }
            } else {
                $this->insertemphistory_cat_leave($content_id, $firstday_of_year, $lastday_of_year, $key, $value);
            }
        }
       
    }


    function insertemphistory_cat_leave($content_id, $firstday_of_year, $lastday_of_year, $key, $value)
    {
        $this->CI->load->database();
        $params = array(
            //'id'                    => '',
            'content_id'            =>  $content_id,
            'start_year'            =>  $firstday_of_year,
            'end_year'              =>  "",
            'leave_type'            =>  $key,
            'total_days'            =>  $value,
            'created_time'          =>  date('Y-m-d H:i:s'),
            'created_by'            =>  $this->CI->session->userdata('user_id'),
           // 'updated_time'          =>  getCurrentDateTime(),
           // 'updated_by'            =>  $this->CI->session->userdata('user_id'),
            
        );
        if ($value) {
            $this->CI->db->insert("emp_yearly_leave_cat_history", $params);
            $insert_id = $this->CI->db->insert_id();
            $this->CI->session->set_userdata("success", "Data Inserted!");
            $msg = "Data inserted";
        }
    }
}
