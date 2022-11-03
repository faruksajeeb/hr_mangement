<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Summery-Attendance</title>
      
        <?php
        $this->load->view('includes/printcss');
        date_default_timezone_set('Asia/Dhaka');
        $servertime = time();
        $today_date = date("d-m-Y", $servertime);
        $now = date("d-m-Y H:i:s", $servertime);
$start = microtime(true);
        ?> 
 <script src="<?php echo base_url();?>plugins/export/tableToExcel.js">
        
        </script>
        <style>
            body{
                background-color: #ffffff;
            }
            .container-fluid{
                width: 100%;
                background-color: #ffffff;
                padding: 0!important;
                margin: 0;
            }

            .under-header-bar {
                min-height: 13px;
                background: #ffffff;
                padding: 3px;
                color: #fff;
                font-weight: bold;
            }
            body{
                -webkit-print-color-adjust:exact;
                color: #696969;
                line-height: 1;
                font-family: Arial,sans-serif; 
                background: none;
                background-color: white;
                background-image: none;
                font-size: 13px;

            }
            html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
                margin: 0;
                padding: 0;
                border: 0;
                vertical-align: baseline;
            }

            .container {
                width: 100%;
                margin-right: auto;
                margin-left: auto;
                padding-left: 2px;
                padding-right: 2px;
                border: 1px solid #000;
            }

            .main-container.container {
                background-color: inherit;
                background-image: none;
                background-repeat: inherit;
                border: 1px solid #000;
                border-style: outset;
                overflow: hidden;
            }
            .container.main-container .row {
                margin-top: 4px!important;
            }
            .row {
                margin-left: -15px;
                margin-right: -15px;
            }
            .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
                float: left;
            }
            .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
                position: relative;
                min-height: 1px;
                padding-left: 15px;
                padding-right: 15px;
            }

            .red-color{
                color: red!important;
                -webkit-print-color-adjust: exact;
            }

            #logo-img{
                height: 70px;
                width: 75px;
            }

            #example td, th {
                padding: 0.30em 0.20em;
                text-align: left;
            }
            table tr.heading {
                background: #ddd;
                color: #000;
            }
            tbody tr:nth-child(odd) {
                background: #ffffff;
            }
            table tbody tr {
                background-color: #ffffff;
            }
            table {
                padding: 0;
                margin: 0;
                background-color: #ffffff;
                font-size: 13px;
            }
            #example td, th {
                padding: 0.10em 0.80em 0.20em 0.80em;
                text-align: center;
            }
        </style>
        <style  type="text/css" media="print">
            @page 
            {
                size: auto;   
                margin-bottom: 35px; 
                margin-left: 24px; 
                margin-top: 35px; 
                margin-right: 35px; 
                margin-footer: 20mm;
            }
            body 
            {
                font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; 
                color: #000;
                margin-bottom: 35px; 
            }
            .row{
                margin-bottom: 5px!important;
            }
            .red-color{color: red;}
            .blue-color{    color: #210EFF;
                            font-weight: bold;}
            </style>  
            
        </head>

        <body class="logged-in dashboard current-page print-attendance" onload="tableToExcel('report',  'Attendance Summary', 'attendance-summary-<?php echo $now; ?>.xls')">
        <!-- Page Content -->  
                       <a href="#"  class="btn btn-sm btn-warning" style="width:150px;" onclick="tableToExcel('report',  'Attendance Summary', 'attendance-summary-<?php echo $now; ?>.xls')" ><span class="glyphicon glyphicon-file"></span>Export to Excel</a>
<br/>
<div id="report">
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php
                date_default_timezone_set('Asia/Dhaka');
                $servertime = time();
                $lastdateofattendance = end($date_range);
                $now = date("d-m-Y H:i:s", $servertime);
                $nowdate = date("d-m-Y", $servertime);
                $thisyear = date("Y", $servertime);
                $datee = date_create($lastdateofattendance);
                $nowbigmonth = date_format($datee, 'F, Y');
                $nowtime = date("H:i:s a", $servertime);
                $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
                $last_day_this_month = date('t-m-Y');
                $working_time_today_total = 0;
                $emp_overtime_today = 0;
                $t3 = 0;
                $ot3 = 0;
                $late_counter = 0;
                $early_counter = 0;
                $absent_halfday_counter = 0;
                $absent_counter = 0;
                $daily_movement=0;
                $daily_movement_personal=0;
                ?>
                    
                <div class="wrapper">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10"  style="padding:3px;background:#FFF;" >
                            
                            <table  class="display" cellspacing="0" width="100%" >
                                <thead>
                                    <tr style="background:#BDB76B" >
                                    <td colspan="<?php if($defsultdivision_shortname=='BCPL'){ echo "11"; }else{ echo "10";} ?>" style="text-align:center">
                                      <!--  <img src="<?php echo base_url(); ?>resources/images/logo.png" alt=""  id="logo-img"/> -->
                                        <h1 style="font-size:25px;font-weight:bold">IIDFC Securities Limited</h1>
                                        <h1 style="font-size:20px;font-weight:bold">Monthly Attendance Summery Report<br><?php print $nowbigmonth; ?></h1>  
                                    </td>
                                    </tr>
                                    <tr style="font-weight:bold;background:#EEE8AA">
                                        <td colspan="2">Division:</td>
                                         <td colspan="5"><?php print $defsultdivision_name; ?></td>
                                          <?php if($defsultdivision_shortname=='BCPL'){ ?>
                                            <td></td>
                                        <?php }?>
                                          <td colspan="1">From: </td>
                                           <td colspan="2" style="text-align:left;"><?php $newDate = date("d-m-Y", strtotime($defaultstart_date)); print $newDate; ?></td>
                                    </tr>
                                    <tr style="font-weight:bold;background:#EEE8AA">
                                        <td colspan="2">Department:</td>
                                         <td colspan="5"><?php print $department_name; ?></td>
                                           <?php if($defsultdivision_shortname=='BCPL'){ ?>
                                            <td></td>
                                        <?php }?>
                                          <td colspan="1">To: </td>
                                           <td colspan="2"><?php print $defaultend_date; ?></td>
                                    </tr>
                                    <tr class="heading" style="border:2px solid #000;font-size:12px; background:#ccc">
                                        <th>SL.</th>
                                        <th>Face ID</th>
                                        <th>Employee</th>
                                        <th>Designation</th>
                                        <th>Late In</th>
                                        <th>Early Out</th>
                                        <th>Daily Mov.</th>
                                        <th>Total Leave</th>
                                       <!-- <th>H.Day A.</th> -->
                                        <th>Absent</th>
                                        <?php if($defsultdivision_shortname=='BCPL'){ ?>
                                            <th>Total OT</th>
                                        <?php }?>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $counter = 1;
                                    foreach ($default_employee as $single_emp) {
                                        $single_code = $single_emp['emp_id'];
                                        $emp_content_id = $single_emp['content_id'];
                                        $emp_name = $single_emp['emp_name'];
                                        $emp_division_id = $single_emp['emp_division'];
                                        $mobile_no = "";
                                        if ($single_emp['mobile_no']) {
                                            $mobile_no = "-" . $single_emp['mobile_no'];
                                        }
                                        $emp_division = $this->taxonomy->getTaxonomyBytid($emp_division_id);
                                        $emp_post_id = $single_emp['emp_post_id'];
                                        $emp_post_id_data = $this->taxonomy->getTaxonomyBytid($emp_post_id);
                                        $emp_designation = $emp_post_id_data['name'];
                                        ?>                    
                                        <?php
                                        $late_counter = 0;
                                        $early_counter = 0;
                                        $absent_counter = 0;
                                        $absent_halfday_counter = 0;
                                        $leave_with_pay=0;
                                        $leave_without_pay=0;
                                        $emp_division_shortname = $emp_division['keywords'];
                                        $emp_joining_date = $single_emp['joining_date'];
                                        $half_day_absent_status = "";
                                        $early_status = "";
                                        $late_status = "";
                                        $today = date("d-m-Y", $servertime);
                                        foreach ($date_range as $single_date) {
                                             if (strtotime($single_date) >= strtotime($emp_joining_date)) {
                                                 $empatt_start_date_arr = explode("-", $single_date);
                                                $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
                                                // Shift History ---------------------------------------------------------------------------------------------------
                                                $emp_shift_time = $this->db->query("SELECT * FROM emp_shift_history WHERE content_id ='$emp_content_id' AND str_to_date(start_date, '%d-%m-%Y') <='$emp_att_start_date' ORDER BY ID DESC LIMIT 1")->row_array();
                                                
                                                $attendance_required = $emp_shift_time['attendance_required'];
                                                $work_starting_time = $emp_shift_time['work_starting_time'];
                                                $work_ending_time = $emp_shift_time['work_ending_time'];
                                                $logout_required = $emp_shift_time['logout_required'];
                                                $year = date('Y', strtotime($single_date));
                                                $empatt_start_date_arr = explode("-", $single_date);
                                                $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
                                                $emp_latecount_time = $emp_shift_time['emp_latecount_time'];
                                                $emp_earlycount_time = $emp_shift_time['emp_earlycount_time'];
                                                $half_day_absent = $emp_shift_time['half_day_absent'];
                                                $absent_count_time = $emp_shift_time['absent_count_time'];
                                                $overtime_count = $emp_shift_time['overtime_count'];
                                                $division_id_emp = $emp_details_info['emp_division'];
                                                $tstamp1 = strtotime($default_date);
                                                $dated_day_name1 = date("D", $tstamp1);
                                                $dated_day_name1 = strtolower($dated_day_name1);
                                                // Noor Medical Services Ltd.--------------------------------
                                                if ($division_id_emp == 301 && $dated_day_name1 == 'thu') {
                                                    $work_ending_time = "16:00:00";
                                                    $emp_earlycount_time = "16:00:00";
                                                }
                                                // Check Attendance log mantainance ----------------------------------------------------------------------------
                                                $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,"
                                                                . "half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status "
                                                                . "FROM log_maintenence WHERE content_id=$emp_content_id and start_date='$single_date' "
                                                                . "order by id DESC LIMIT 1")->row_array();

                                                if (!$has_log_attendance_error) {
                                                    $division_id_emp = $emp_details_info['emp_division'];
                                                    $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status FROM log_maintenence WHERE division_id='$division_id_emp' and start_date='$single_date' order by id DESC LIMIT 1")->row_array();
                                                }
                                                $division = "all";
                                                if (!$has_log_attendance_error) {
                                                    $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status FROM log_maintenence WHERE division_id='$division' and start_date='$single_date' order by id DESC LIMIT 1")->row_array();
                                                }


                                                if ($has_log_attendance_error) {

                                                    $late_status = $has_log_attendance_error['late_status'];
                                                    $log_weekly_holiday = $has_log_attendance_error['weekly_holiday'];
                                                    $presence_status_has_no_log = $has_log_attendance_error['present_status'];
                                                    if ($late_status == 'Late_Count_Time') {
                                                        $emp_latecount_time = $has_log_attendance_error['late_count_time'];
                                                    }
                                                    $half_day_absent_status = $has_log_attendance_error['half_day_absent_status'];
                                                    if ($half_day_absent_status == 'Half_Day_Absent_Count_Time') {
                                                        $absent_count_time = $has_log_attendance_error['half_day_absent_count_time'];
                                                    }
                                                    $early_status = $has_log_attendance_error['early_status'];
                                                    if ($early_status == 'Early_Count_Time') {
                                                        $emp_earlycount_time = $has_log_attendance_error['early_count_time'];
                                                    }

                                                    $reason = $has_log_attendance_error['reason'];
                                                }
                                                // Attendance info from attendance table -------------------------------------------------
                                                if(strtotime($single_date) <= strtotime('30-11-2018')){ 
                                                    // If before December 01, 2018 ----------------------------------------------------
                                                    $attendance_info = $this->db->query("SELECT login_time,logout_time,remarks "
                                                                . "FROM emp_attendance_old "
                                                                . "WHERE content_id=$emp_content_id AND attendance_date='$single_date' "
                                                                . "ORDER BY id DESC")->row_array();
                                                }else{
                                                    // If after November 30, 2018 ------------------------------------------------------
                                                    $attendance_info = $this->db->query("SELECT login_time,logout_time,remarks "
                                                                . "FROM emp_attendance "
                                                                . "WHERE content_id=$emp_content_id AND attendance_date='$single_date' "
                                                                . "ORDER BY id DESC")->row_array();
                                                }
                                                $login_time = $attendance_info['login_time'];
                                                $logout_time = $attendance_info['logout_time'];    
                                                // Attendance Information check( Daily movement) -------------------------------------------------------------
                                                $emp_informed_info = $this->db->query("SELECT presence_status,logout_status,reason,remarks FROM emp_informed WHERE content_id=$emp_content_id AND attendance_date='$single_date' AND second_approval=1 ORDER BY id DESC")->row_array();
                                                
                                                // Holiday Check ---------------------------------------------------------------------------------------------
                                                $holiday_exist = $this->db->query("SELECT eyh.holiday_type,t.name as holiday_name "
                                                                . "FROM emp_yearlyholiday eyh "
                                                                . "LEFT JOIN taxonomy t ON t.tid=eyh.holiday_type "
                                                                . "WHERE eyh.holiday_for_division='$division' AND eyh.holiday_start_date='$single_date' "
                                                                . "ORDER BY eyh.id DESC LIMIT 1")->row_array();
                                                if (!$holiday_exist) {
                                                    $division = $emp_details_info['emp_division'];
                                                    $holiday_exist = $this->db->query("SELECT eyh.holiday_type,t.name as holiday_name "
                                                                    . "FROM emp_yearlyholiday eyh "
                                                                    . "LEFT JOIN taxonomy t ON t.tid=eyh.holiday_type "
                                                                    . "WHERE eyh.holiday_for_division='$division' AND eyh.holiday_start_date='$single_date' "
                                                                    . "ORDER BY eyh.id DESC")->row_array();
                                                }
                                                if ($holiday_exist) {
                                                    // If holiday -------------------------------------
                                                    $holiday_type_tid = $holiday_exist['holiday_type'];
                                                    $holiday_name = $holiday_exist['holiday_name']; // this will be echoed
                                                    $remarks = $holiday_exist['holiday_name'];
                                                } else {
                                                    // If holiday doesn't exist ------------------------
                                                    $tstamp = strtotime($single_date);
                                                    $dated_day_name = date("D", $tstamp);
                                                    $dated_day_name = strtolower($dated_day_name);
                                                    $empatt_start_date_arr = explode("-", $single_date);
                                                    $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
                                                    
                                                    // Check weekly holiday -------------------------------
                                                    $offday_exist = $this->db->query("SELECT * FROM emp_weeklyholiday_history WHERE content_id='$emp_content_id' AND str_to_date(start_date, '%d-%m-%Y') <='$emp_att_start_date' ORDER BY id DESC LIMIT 1")->row_array();
                                                    if ($offday_exist['' . $dated_day_name . '_off'] == 'off') {
                                                        // If weekly holiday
                                                        // Check if weekly holiday is working day -------------------------
                                                        if($log_weekly_holiday=='working_day'){
                                                            //Check Attendance informed ------------------------
                                                            
                                                        }else{
                                                            $weekly_holiday = "Weekly Holiday";
                                                            $remarks = "Weekly Holiday";
                                                        }
                                                    }
                                                    // If Not weekly holiday ---------------------------------
                                                    if ($offday_exist['' . $dated_day_name . '_off'] != 'off') {
                                                        // Check employee leave --------------------------------------------------------------------
                                                        $leave_exist = $this->db->query("SELECT el.leave_type,el.justification,t.name as leave_name "
                                                                        . "FROM emp_leave el "
                                                                        . "LEFT JOIN taxonomy t ON t.tid=el.leave_type "
                                                                        . "WHERE el.content_id='$emp_content_id' "
                                                                        . "AND el.leave_start_date='$single_date' ORDER BY el.id DESC")->row_array();

                                                        if ($leave_exist) {
                                                            
                                                            
                                                            // If employee leave --------------------- 
                                                            $leave_type = $leave_exist['leave_type'];
                                                            $leave_reason = $leave_exist['leave_name'];
                                                            if (!$leave_reason) {
                                                                $leave_reason = "Leave";
                                                            }
                                                            if ($leave_type == '446') {
                                                                $remarks = "Half Day Leave";
                                                            } else if ($leave_type == '336') {
                                                                $remarks = "leave_without_pay";
                                                                $leave_without_pay++;
                                                            } else {
                                                                $remarks = "Leave";
                                                                $leave_with_pay++;
                                                            }
                                                        } else {
                                                            // If employee no leave ----------------------------
                                                            // Check Attendance Informed Info(Such as :Daily Movement)-----------------------------
                                                            $presence_status = "";
                                                            $presence_status_informed = $emp_informed_info['presence_status'];
                                                            $logout_status_informed = $emp_informed_info['logout_status'];
                                                            $reason_informed = $emp_informed_info['reason'];
                                                            $informed_remarks = $emp_informed_info['remarks'];
                                                            if ($reason_informed != $informed_remarks) {
                                                                $informed_remarks = $emp_informed_info['reason'] . " [<span style='font-size:8px;'>" . $emp_informed_info['remarks'] . "]</span>";
                                                            }
                                                            $login_time = $attendance_info['login_time'];
                                                            $logout_time = $attendance_info['logout_time'];
                                                            if ($half_day_absent == 'Eligible') {
                                                                if ($half_day_absent_status == 'Half_Day_Absent_Not_Count') { // problem day
                                                                    $remarks = $reason;
                                                                } else if ($login_time && strtotime($login_time) > strtotime($absent_count_time)) {
                                                                    if (!$logout_time) {
                                                                        $half_absent_found = "Half Day Absent";
                                                                    } else if (strtotime($emp_earlycount_time) > strtotime($logout_time)) {
                                                                        $half_absent_found = "Half Day Absent";
                                                                    } else {
                                                                        $half_absent_found = "Half Day Absent";
                                                                    }
                                                                } else if ($late_status == "Late_Not_Count") {
                                                                    $remarks = $reason;
                                                                } else if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                                                    $login_time = "<font color=red >" . $login_time . "</font>";
                                                                } else {
                                                                }
                                                            } else {
                                                                //echo $emp_latecount_time;
                                                                if ($presence_status_informed) {
                                                                    $presence_status = $presence_status_informed;
                                                                    $remarks = $informed_remarks;
                                                                    if ($presence_status == 'A') {
                                                                        $login_time = "";
                                                                        $logout_time = "";
                                                                    }
                                                                } else if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                                                    $emp_late_found = "Late";
                                                                } else {
                                                                }
                                                            }
                                                            
                                                        }
                                                    }
                                                }
                                                
                                                // if not login but logout after 04:00 PM ....................................................
                                                if (!$logout_time && $login_time && $login_time >= "16:00:00") {
                                                    $logout_time = $login_time;
                                                    $login_time = "";
                                                }
                                                $tstamp = strtotime($single_date);
                                                $dated_day_name = date("D", $tstamp);
                                                $dated_day_name = strtolower($dated_day_name);
                                                if ($offday_exist['' . $dated_day_name . '_off'] == "off") {
                                                    $remarks = "Weekly Holiday";
                                                }
                                                // Counter Start ------------------------------------------------------------------------------------------------------------
                                                if ($holiday_name) {
                                                } else if ($offday_exist['' . $dated_day_name . '_off'] == "off") {
                                                    if ($log_weekly_holiday && $log_weekly_holiday == 'working_day') {
                                                        // Check Informed attendance ----------------------------------------
                                                        $presence_status = "";
                                                        $presence_status_informed = $emp_informed_info['presence_status'];
                                                        $logout_status_informed = $emp_informed_info['logout_status'];
                                                        $reason_informed = $emp_informed_info['reason'];
                                                        $informed_remarks = $emp_informed_info['remarks'];
                                                        if ($presence_status_informed) {
                                                             $daily_movement++;
                                                            if($informed_remarks=='personal'){
                                                                $daily_movement_personal++;
                                                            }
                                                            $presence_status = $presence_status_informed;
                                                            if ($presence_status == 'A') {
                                                                $absent_counter++;
                                                            } else if ($presence_status == 'P' && $logout_status_informed == 'P') {
                                                                
                                                            } else if ($presence_status == 'P' && $logout_status_informed == 'E') {
                                                                 $early_counter++;
                                                            } else if ($presence_status == 'L' && $logout_status_informed == 'E') {
                                                                $late_counter++;
                                                                $early_counter++;
                                                            } else if ($presence_status == 'A.H') {
                                                                $absent_halfday_counter++;
                                                            } else if ($presence_status == 'L') {
                                                                $late_counter++;
                                                            } else if ($presence_status_informed == 'L') {
                                                                $late_counter++;
                                                            } else if ($logout_status_informed == 'E') {
                                                                $early_counter++;
                                                            }
                                                        } else {
                                                            if ($login_time && $logout_time) {
                                                                if (strtotime($login_time) >= strtotime($emp_latecount_time) && strtotime($logout_time) <= strtotime($emp_earlycount_time)) {
                                                                    $late_counter++;
                                                                    $early_counter++;
                                                                } else if (strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                                                    echo "<span class='blue-color'>L</span>";
                                                                    $remarks = "Late";
                                                                    $late_counter++;
                                                                } else if (strtotime($logout_time) <= strtotime($emp_earlycount_time)) {
                                                                    $early_counter++;
                                                                } else {
                                                                }
                                                            } else if ($login_time && !$logout_time) {
                                                                if (strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                                                    $late_counter++;
                                                                    $early_counter++;
                                                                } else {
                                                                    $early_counter++;
                                                                }
                                                            } else if (!$login_time && $logout_time) {
                                                                if (strtotime($logout_time) <= strtotime($emp_earlycount_time)) {
                                                                    $late_counter++;
                                                                    $early_counter++;
                                                                } else {
                                                                    $late_counter++;
                                                                }
                                                            } else {
                                                                $absent_counter++;
                                                            }
                                                        }
                                                    } else {
                                                    }
                                                } else if ($remarks == 'leave_without_pay') {
                                                    $absent_counter++;
                                                } else if ($remarks == 'Leave') {
                                                    
                                                } else if ($remarks == 'Half Day Leave') {
                                                    
                                                } else if ($attendance_required == 'Not_Required') {
                                                    
                                                } else if ($presence_status_informed) {
                                                     $daily_movement++;
                                                    if($informed_remarks=='personal'){
                                                        $daily_movement_personal++;
                                                    }
                                                    if ($presence_status == 'A') {
                                                        $absent_counter++;
                                                    } else if ($presence_status == 'P' && $logout_status_informed == 'P') {
                                                       
                                                    } else if ($presence_status == 'P' && $logout_status_informed == 'E') {
                                                        $early_counter++;
                                                    } else if ($presence_status == 'L' && $logout_status_informed == 'E') {
                                                        $early_counter++;
                                                    } else if ($presence_status == 'A.H') {
                                                        $absent_halfday_counter++;
                                                    } else if ($presence_status == 'L') {
                                                        $late_counter++;
                                                    } else if ($presence_status_informed == 'L') {
                                                        $late_counter++;
                                                    } else if ($logout_status_informed == 'E') {
                                                        $early_counter++;
                                                    }
                                                } else if ($presence_status == 'A') {
                                                    $absent_counter++;
                                                } else if ($presence_status == 'P') {
                                                    
                                                } else if ($presence_status == 'A.H') {
                                                    if (strtotime($single_date) == strtotime($today)) {
                                                       // echo "P";
                                                    } else {
                                                        $absent_halfday_counter++;
                                                    }
                                                } else if ($presence_status == 'L') {
                                                    $late_counter++;
                                                } else if ($late_status == "Late_Not_Count" && $early_status == "Early_Not_Count") {
                                                    if ($presence_status_has_no_log == "A" && !$login_time && !$logout_time) {
                                                        $absent_counter++;
                                                    } else if ($presence_status_has_no_log == "P") {
                                                    //    echo "P";
                                                    } else {
                                                        // echo "P";
                                                    }
                                                } else if ($late_status == "Late_Count_Time" && $early_status == "Early_Count_Time") {
                                                    if ($login_time && $logout_time && strtotime($login_time) >= strtotime($emp_latecount_time) &&
                                                            strtotime($logout_time) <= strtotime($emp_earlycount_time)) {
                                                        $late_counter++;
                                                        if (strtotime($single_date) == strtotime($today)) {
                                                            $late_counter++;
                                                        } else {
                                                            $late_counter++;
                                                            $early_counter++;
                                                        }
                                                    } else if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                                        $late_counter++;
                                                    } else if ($logout_time && strtotime($logout_time) <= strtotime($emp_earlycount_time)) {
                                                        if (strtotime($single_date) == strtotime($today)) {
                                                          //  echo "P";
                                                        } else {
                                                            $early_counter++;
                                                        }
                                                    } else if (!$login_time && !$logout_time) {
                                                        $absent_counter++;
                                                    } else {
                                                       // echo "P";
                                                    }
                                                } else if ($late_status == "Late_Count_Time" && $early_status == "Early_Not_Count") {
                                                    if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                                        $late_counter++;
                                                    } else if (!$login_time && !$logout_time) {
                                                        $absent_counter++;
                                                    } else {
                                                       // echo "P";
                                                    }
                                                } else if ($late_status == "Late_Not_Count" && $early_status == "Early_Count_Time") {
                                                    if (strtotime($logout_time) <= strtotime($emp_earlycount_time)) {
                                                        if (strtotime($single_date) == strtotime($today)) {
                                                           // echo "P";
                                                        } else {
                                                            $early_counter++;
                                                        }
                                                    } else if (!$login_time && !$logout_time) {
                                                        $absent_counter++;
                                                    } else {
                                                        // echo "P";
                                                    }
                                                } else if (!$login_time && !$logout_time) {
                                                    $attendance_log = $this->emp_attendance_model->getemp_attendance_log();
                                                    $attendance_log_date = $attendance_log['attendance_date'];
                                                    if (strtotime($single_date) > strtotime($attendance_log_date)) {
                                                       // echo "NC";
                                                    } else {
                                                        $absent_counter++;
                                                    }
                                                } else if ($login_time && !$logout_time && $logout_required == "Required" && $half_day_absent == 'Eligible') {
                                                    if (strtotime($single_date) == strtotime($today)) {
                                                       // echo "P";
                                                    } else {
                                                        $absent_halfday_counter++;
                                                    }
                                                } else if ($login_time && !$logout_time && $logout_required == "Required") {
                                                    if ($emp_late_found) {
                                                        $late_counter++;
                                                        if (strtotime($single_date) == strtotime($today)) {
                                                        } else {
                                                            $early_counter++;
                                                        }
                                                    } else {
                                                        if (strtotime($single_date) == strtotime($today)) {
                                                            //echo "p";
                                                        } else {
                                                            $early_counter++;
                                                        }
                                                    }
                                                } else if ($login_time && !$logout_time && $logout_required == "Optional") {
                                                   // echo "P";
                                                } else if ($half_absent_found) {
                                                    if (strtotime($single_date) == strtotime($today)) {
                                                       // echo "P";
                                                    } else {
                                                        $absent_halfday_counter++;
                                                    }
                                                } else if ($emp_late_found) {
                                                    if ($login_time && $logout_time && $logout_required == "Required" && strtotime($logout_time) <= strtotime($emp_earlycount_time)) {
                                                        $late_counter++;
                                                        if (strtotime($single_date) == strtotime($today)) {
                                                        } else {
                                                            $early_counter++;
                                                        }
                                                    } else {
                                                        $late_counter++;
                                                    }
                                                } else if ($login_time && $logout_time && $logout_required == "Required") {
                                                    if (strtotime($emp_earlycount_time) >= strtotime($logout_time)) {
                                                        if (strtotime($single_date) == strtotime($today)) {
                                                           // echo "p";
                                                        } else {
                                                            $early_counter++;
                                                        }
                                                    } else {
                                                        if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                                            $late_counter++;
                                                        } else {
                                                          //  echo "P";
                                                        }
                                                    }
                                                } else {
                                                    // echo "P";
                                                }
                                              // Start Over Time Count ------------------------------------------------------------------------------------------
                                              if($defsultdivision_shortname=='BCPL'){
                                              if (strtotime($logout_time) > strtotime($work_ending_time) || ($login_time && $logout_time && $division_id_emp == 20)) {
                                // overtime count after 16 minutes for medisys
                                // echo $working_time_today_total;
                                if ($division_id_emp == 20) {
                                    $medisys_time = strtotime($work_ending_time);
                                    $endTime_medisys = date("H:i:s", strtotime('+16 minutes', $medisys_time));
                                    if (strtotime($logout_time) > strtotime($endTime_medisys)) {
                                        $emp_overtime_today = get_time_difference($endTime_medisys, $logout_time);

                                        if ($holiday_exist || $remarks == "Weekly Holiday") {

                                            $emp_overtime_today = $working_time_today_total;
                                        } else if (!$emp_overtime_today) {
                                            $emp_overtime_today = $working_time_today_total;
                                        }

                                        $b = explode(':', $emp_overtime_today);
                                        $ot1 = $b[0] * 3600 + $b[1] * 60 + $b[2];
                                        $ot3 = $ot3 + $ot1;

                                      //  echo $emp_overtime_today;
                                    } else if ($remarks == "Weekly Holiday" && $working_time_today_total) {
                                        $b = explode(':', $working_time_today_total);
                                        $ot1 = $b[0] * 3600 + $b[1] * 60 + $b[2];
                                        $ot3 = $ot3 + $ot1;
                                      //  echo $working_time_today_total;
                                    }
                                } else {
                                    // for BEL over time
                                    // security guard er jonno daily -8 hours overtime and holiday wholeday holiday
                                    if ($post_id_emp == 57 || $post_id_emp == 58 || $post_id_emp == 59 || $post_id_emp == 60 || $post_id_emp == 117) {
                                        if (strtotime($login_time) && strtotime($logout_time)) {
                                            $emp_overtime_today = get_time_difference($login_time, $logout_time);
                                            $officetime = strtotime("-8 hours");
                                            $timestamp = strtotime($emp_overtime_today);
                                            if ($timestamp > $officetime) {
                                                if ($holiday_exist || $remarks == 'Weekly Holiday') {
                                                    $timestamp = strtotime($emp_overtime_today);
                                                } else {
                                                    $timestamp = strtotime($emp_overtime_today) - 60 * 60 * 8;
                                                }

                                                $timestamp = date("H:i:s", $timestamp);

                                                if ($timestamp) {
                                                    $b = explode(':', $timestamp);
                                                    $ot1 = $b[0] * 3600 + $b[1] * 60 + $b[2];
                                                    $ot3 = $ot3 + $ot1;
                                                  //  echo $timestamp;
                                                }
                                            }
                                        }
                                    } else {
                                        // For BCPL & others...
                                        $for_all_time = strtotime($work_ending_time);
                                        //$endTime_for_all = date("H:i:s", strtotime('+20 minutes', $for_all_time));
                                        $endTime_for_all = date("H:i:s", strtotime('+00 minutes', $for_all_time));
                                        if (strtotime($logout_time) > strtotime($endTime_for_all)) {
                                            $emp_overtime_today = get_time_difference($endTime_for_all, $logout_time);

                                            if ($holiday_exist || $remarks == "Weekly Holiday") {
                                                $emp_overtime_today = $working_time_today_total;
                                            } else if (!$emp_overtime_today) {
                                                $emp_overtime_today = $working_time_today_total;
                                            }

                                            $b = explode(':', $emp_overtime_today);
                                            $ot1 = $b[0] * 3600 + $b[1] * 60 + $b[2];
                                            $ot3 = $ot3 + $ot1;

                                           // echo $emp_overtime_today;
                                        } else if ($remarks == "Weekly Holiday" && $working_time_today_total) {
                                            $b = explode(':', $working_time_today_total);
                                            $ot1 = $b[0] * 3600 + $b[1] * 60 + $b[2];
                                            $ot3 = $ot3 + $ot1;
                                           // echo $working_time_today_total;
                                        }


                                        // start for all overtime
                                        // $emp_overtime_today= get_time_difference($work_ending_time, $logout_time);
                                        // $b=explode(':',$emp_overtime_today);
                                        // $ot1=$b[0]*3600+$b[1]*60+$b[2];
                                        // $ot3=$ot3+$ot1;
                                        // echo $emp_overtime_today;
                                        // ends for all overtime
                                    }
                                }
                            }
                                              }
                                              // End Over Time Count -------------------------------------------------------------------------------------------
                                                $login_time = "";
                                                $logout_time = "";
                                                $holiday_name = "";
                                                $weekly_holiday = "";
                                                $log_weekly_holiday = "";
                                                $remarks = "";
                                                $reason = "";
                                                $half_absent_found = "";
                                                $emp_late_found = "";
                                                $late_status = "";
                                                $early_status = "";
                                                if (strtotime($single_date) >= strtotime($today)) {
                                                    break;
                                                }
                                             }
                                        }
                                        ?>
                                        <tr style="border:1px solid #000;border-bottom:none;border-left:none;border-right:none;">
                                            <td><?php print $counter; ?></td>
                                            <td style="text-align:left"><?php echo $single_code; ?></td>
                                            <td style="text-align:left"><?php echo $emp_name; ?></td>
                                            <td style="text-align:left"><?php echo $emp_designation; ?></td>
                                            <td><?php echo $late_counter; ?></td>
                                            <td><?php echo $early_counter; ?></td>
                                            <td>
                                                <?php
                                                    echo $daily_movement;
                                                    if($daily_movement>0){
                                                        $official=$daily_movement-$daily_movement_personal;
                                                        echo "<br/><span style='font-size:8px;'> (Per-".$daily_movement_personal.",Offi-".$official.") <span>";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                  $total_leave=$leave_with_pay+$leave_without_pay;
                                                  if($total_leave==0){
                                                      echo '0';
                                                  }else{
                                                  echo $total_leave ."<br/><span style='font-size:8px;'> (WP-".$leave_with_pay.",WOP-".$leave_without_pay.") <span>";
                                                  }
                                                ?>
                                            </td>
                                          <!--  <td><?php // echo $absent_halfday_counter; ?></td> -->
                                            <td><?php echo $absent_counter; ?></td>
                                            <?php if($defsultdivision_shortname=='BCPL'){ ?>
                                              <td><?php
                                              
                                                    $oh = floor($ot3 / 3600);
                                                    $om = floor(($ot3 % 3600) / 60);
                                                    $os = $ot3 - $oh * 3600 - $om * 60;
                                                    $total_ot=sprintf("%02d",$oh).":".sprintf("%02d",$om).":".sprintf("%02d",$os);
                                                  //  echo $total_ot; // sprintf("%02d", $num)
                    
                                              ?></td>
                                        <?php }?>
                                            <td><?php
                                                if ($attendance_required == 'Not_Required') {
                                                    echo "Not Required";
                                                }
                                                ?></td>
                                        </tr>

                                        <?php
                                        $late_counter = 0;
                                        $early_counter = 0;
                                        $absent_halfday_counter = 0;
                                        $absent_counter = 0;
                                        $daily_movement=0;
                                        $daily_movement_personal=0;
                                        $mobile_no = "";
                                        $counter++;
                                        $ot3=0;
                                        $oh=0;
                                        $om=0;
                                        $os=0;
                                        $total_ot=0;
                                        $leave_with_pay=0;
                                        $leave_without_pay=0;
                                        $total_leave=0;
                                    }
                                    
                                    ?>  
                                </tbody>
                            </table> 
                            
                            <htmlpagefooter name="MyFooter1">
                                <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 10pt; 
                                       color: #000000; font-weight: bold; font-style: italic;text-align: left; ">
                                    <tr style="margin-bottom:10px; background:#EEE8AA">
                                        <td colspan="2"><span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000;">Prepared By:<br><br></span></td>
                                        <td colspan="1" style="text-align:right"><span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000;">Checked By:<br><br></span></td>
                                        <td colspan="2"  style="font-weight: bold; font-style: italic;text-align:right"><span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000;">Checked By:<br><br></span></td>
                                        <td colspan="5" style="text-align: right; "><span style="height:50px;font-weight: bold; font-style: italic;border-bottom:2px solid #000;">Approved By:<br><br></span></td>
                                    </tr>
                                    <tr style="background:#EEE8AA">
                                        <td colspan="2"><span style="font-weight: bold; font-style: italic;"><p style="color:fff"></p><br>HR Executive </span></td>
                                        <td colspan="1"  style="text-align:right"><span style="font-weight: bold; font-style: italic;"><p style="color:fff"></p><br>Internal Auditor </span></td>
                                        <td colspan="2"  style="font-weight: bold; font-style: italic;text-align:right"><p style="color:fff"></p><br>Accounts Department</td>
                                        <td colspan="5" style="text-align: right;"><p style="color:fff"></p><br><br/>Group Vice President<br/><span style="">(Administration)</span></td>
                                    </tr>    
                                </table>
                                <br> <br> <br>
                                <span style="font-size:10px;font-style:italic">
                                    
                                <?php
$end = microtime(true);
$exe_time = $end - $start;
 //echo "Report generated time: " . number_format($exe_time, 2) . " Seconds.";
 echo "Report generated by HR Software at ".$nowdate." ".$nowtime ;
?>

                                </span>
                            </htmlpagefooter>
                            <sethtmlpagefooter name="MyFooter1" value="on" />        
                            
                        </div>
                        <div class="col-md-1"></div>
                    </div>              
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        </div>
        <!-- /#wrapper -->    

    </body>
</html>
<?php exit; ?>
