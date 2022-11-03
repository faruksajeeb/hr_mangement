<?php
date_default_timezone_set('Asia/Dhaka');
$servertime = time();
$now = date("d-m-Y H:i:s", $servertime);
$first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
$last_day_this_month = date('t-m-Y');
$lastdateofattendance = end($date_range);
$nowdate = date("d-m-Y", $servertime);
$thisyear = date("Y", $servertime);
$datee = date_create($lastdateofattendance);
$nowbigmonth = date_format($datee, 'F Y');
$nowtime = date("H:i:s a", $servertime);
$start = microtime(true);
$user_id= $this->session->userdata('user_id');
$user_type= $this->session->userdata('user_type');
?>
<style>
    table{margin:0 auto;}
    table, th, td {
        /*   padding-left:5px;padding-right:5px;font-size:10px; border-collapse: collapse; */
    }
    th{background:#333333;color:#FFF} 
    #heading th{background: #cccccc;color:black;border-bottom:1px solid #FFF} 
    tr:nth-child(even) {background: #DCDCDC !important }
    tr:nth-child(odd) {background: #FFF !important}
    @media print { body { display:none } }  
</style>



<div class="row">
    <div class="col-md-12 text-right">
        
        
        <?php 
            $print_attendance=$this->users_model->getuserwisepermission("print_attendance", $user_id);
            // $print_attendance['status'] == 1 
            if ($user_type == 1 || $print_attendance['status'] == 1 ) { ?>
            <a class="btn btn-default pull-left " id="printButton" href="#" onclick="PrintDiv();"><span class="glyphicon glyphicon-print"> Print</span></a>
            <a onclick="return popitup('<?php echo site_url("savepdf/singleattendancereportspdf"); ?>')" href="<?php echo site_url("savepdf/singleattendancereportspdf"); ?>"  class="operation-echo-pdf operation-link btn btn-success"><span class="glyphicon glyphicon-file"> PDF</span></a></div>
        <?php }?>
</div>
<div id="report">

    <div class="row" style="">
        <table class="display" width="97.5%" id="heading" style="text-align: left;margin:0 auto;border:1px solid #ccc;" border="0">
            <tr>
                <th >Employee ID:</th>
                <td><?php echo $emp_details_info['emp_id']; ?></td>
                <th >Date:</th>
                <td><?php echo $nowdate; ?></td>
            </tr>
            <tr>
                <th>Employee Name:</th>
                <td><?php echo $emp_details_info['emp_name']; ?></td>
                <th>Time:</th>
                <td><?php echo $nowtime; ?></td>
            </tr>
            <tr>
                <th>Designation:</th>
                <td><?php
                    echo $emp_details_info['post_name'];
                    ?></td>
                <th>Leave Spent:</th>
                <td><?php
//            $total_leave_query = $this->emp_leave_model->getemp_sumleavetotal($defaultcontent_id, $lastdateofattendance);
//            $total_leave_query = $emp_details_info['Totalleave'];
//           
                    if (!$emp_details_info['Totalleave']) {
                        echo "0";
                    } else {
                        echo $emp_details_info['Totalleave'];
                    }
                    ?></td>
            </tr>
            <tr>
                <th>Joining Date:</th>
                <td><?php echo $emp_details_info['joining_date']; ?></td>
                <th>Service Length:</th>
                <td><?php
                    $joining_date_arr = explode('-', $emp_details_info['joining_date']);
                    $joining_date_reversed = $joining_date_arr[2] . "-" . $joining_date_arr[1] . "-" . $joining_date_arr[0] . " 00:00:00";
                    $jo = strtotime($joining_date_reversed);
                    date_default_timezone_set('Asia/Dhaka');
                    $now = time();
                    $removed = timespan($jo, $now);
                    $pieces = explode(",", $removed);
                    foreach ($pieces as $key => $ll) {
                        if (strpos($ll, 'Hour') !== false || strpos($ll, 'Minute') !== false) {
                            unset($pieces[$key]);
                        }
                    }
                    $string = rtrim(implode(',', $pieces), ',');
                    echo $string;
// echo substr($removed, 0, -21);
                    ?></td>
            </tr>
            <?php
            //$emp_shift_time_last = $this->emp_working_time_model->getworkingtimeBydateandid($content_id, $lastdateofattendance);
            $work_starting_time_last = $emp_details_info['work_starting_time'];
            $work_ending_time_last = $emp_details_info['work_ending_time'];
            ?>

            <tr>
                <th>Work Start Time:</th>
                <td><?php echo $work_starting_time_last; ?></td>

                <th>Work End Time:</th>
                <td><?php echo $work_ending_time_last; ?></td>
            </tr>
        </table>
    </div>



    <table id="example" class="display" cellspacing="0" width="100%" border="1" style="text-align:center">
        <thead>
            <tr class="heading">
                <th>Log Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Division</th>
                <th>WHours</th>
                <th>Over Time</th>
                <th>Att</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            <?php
// $lastdateofattendance
            $late_counter = 0;
            $early_counter = 0;
            $absent_counter = 0;
            $absent_halfday_counter = 0;
            $daily_movement=0;
            $daily_movement_personal=0;
            $emp_joining_date = $emp_details_info['joining_date'];
            $emp_department_id = $emp_details_info['emp_department'];
            $emp_division_id = $emp_details_info['emp_division'];
            $half_day_absent_status = "";
            $early_status = "";
            $late_status = "";
            $today = date("d-m-Y", $servertime);
            $i = 1;
            $left_or_termineted = $emp_details_info['type_of_employee'];
            if ($left_or_termineted == 153 || $left_or_termineted == 473) {
                $left_or_termineted_data = $this->emp_job_history_model->getemp_last_job_history($emp_content_id);
                $left_or_termineted_date = $left_or_termineted_data['start_date'];
            }
            foreach ($date_range as $single_date) {
                // Check Employee left or Terminated ------------
                if ($left_or_termineted_date) {
                    if (strtotime($single_date) >= strtotime($left_or_termineted_date)) {
                        break;
                    }
                }
                // Check joining date ----------------------------------------
                if (strtotime($single_date) >= strtotime($emp_joining_date)) {
                    $empatt_start_date_arr = explode("-", $single_date);
                    $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
                    // Get employee shift history ---------------------------- 
                    $emp_shift_time = $this->db->query("select * from emp_shift_history WHERE content_id ='$emp_content_id' AND str_to_date(start_date, '%d-%m-%Y') <='$emp_att_start_date' ORDER BY ID DESC LIMIT 1")->row_array();
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
                    
                    $tstamp1 = strtotime($single_date);
                    $dated_day_name1 = date("D", $tstamp1);
                    $dated_day_name1 = strtolower($dated_day_name1);
                    // Noor Medical Services Work ending time 4:00:00 PM -----------------
                    if ($division_id_emp == 301 && $dated_day_name1 == 'thu') {
                        $work_ending_time = "16:00:00";
                        $emp_earlycount_time = "16:00:00";
                    }
                    // check employee log maintanence ----------------
                    $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,"
                                    . "half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status "
                                    . "FROM log_maintenence WHERE content_id=$emp_content_id and start_date='$single_date' "
                                    . "order by id DESC LIMIT 1")->row_array();
                                    
                    // check department log maintanence if employee log dosen't exist ----------------
                    if(!$has_log_attendance_error){
                        $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status FROM log_maintenence WHERE department_id=$emp_department_id and start_date='$single_date' order by id DESC LIMIT 1")->row_array();
                    }
                    // check division log maintanence if department & employee log dosen't  exist ----------------
                    if (!$has_log_attendance_error) {
                        
                        $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,
                        half_day_absent_count_time,early_status FROM log_maintenence WHERE division_id='$emp_division_id' and start_date='$single_date' order by id DESC LIMIT 1")->row_array();
                    }
                    // check all division log maintanence if division, department & employee log dosen't  exist ----------------
                    $division = "all";
                    if (!$has_log_attendance_error) {
                        $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status FROM log_maintenence WHERE division_id='$division' and start_date='$single_date' order by id DESC LIMIT 1")->row_array();
                    }

                    // If log exist ------------------
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
                        // If before December, 2018 ----------------------------------------------------
                        $attendance_info = $this->db->query("SELECT login_time,logout_time,remarks "
                                    . "FROM emp_attendance_old "
                                    . "WHERE content_id=$emp_content_id AND attendance_date='$single_date' "
                                    . "ORDER BY id DESC")->row_array();
                    }else{
                        // If after November, 2018 ------------------------------------------------------
                        $attendance_info = $this->db->query("SELECT login_time,logout_time,remarks "
                                    . "FROM emp_attendance "
                                    . "WHERE content_id=$emp_content_id AND attendance_date='$single_date' "
                                    . "ORDER BY id DESC")->row_array();
                    }
                    $login_time = $attendance_info['login_time'];
                    $logout_time = $attendance_info['logout_time']; 
                    // Attendance informed info from informed table(such as  Daily movement ) --------------------------------------
                    $emp_informed_info = $this->db->query("SELECT presence_status,logout_status,reason,remarks FROM emp_informed WHERE content_id=$emp_content_id AND attendance_date='$single_date' AND second_approval=1 ORDER BY id DESC")->row_array();
                    // If holiday exist for employee division ----
                        $holiday_exist = $this->db->query("SELECT eyh.holiday_type,t.name as holiday_name "
                                        . "FROM emp_yearlyholiday eyh "
                                        . "LEFT JOIN taxonomy t ON t.tid=eyh.holiday_type "
                                        . "WHERE eyh.holiday_for_division='$emp_division_id' AND eyh.holiday_for_department='$emp_department_id' AND eyh.holiday_start_date='$single_date' "
                                        . "ORDER BY eyh.id DESC")->row_array();
                    
                    if (!$holiday_exist) {
                        // If holiday exist for employee company ----
                        $holiday_exist = $this->db->query("SELECT eyh.holiday_type,t.name as holiday_name "
                                        . "FROM emp_yearlyholiday eyh "
                                        . "LEFT JOIN taxonomy t ON t.tid=eyh.holiday_type "
                                        . "WHERE eyh.holiday_for_division='$emp_division_id' AND (eyh.holiday_for_department = NULL OR eyh.holiday_for_department = '') AND eyh.holiday_start_date='$single_date' "
                                        . "ORDER BY eyh.id DESC")->row_array();
//                    $holiday_exist = $this->emp_holiday_model->getemp_yearlyholiday($division, $single_date);
                    }
                    if (!$holiday_exist) {
                        // If holiday exist for all company ----
                        $holiday_exist = $this->db->query("SELECT eyh.holiday_type,t.name as holiday_name "
                                    . "FROM emp_yearlyholiday eyh "
                                    . "LEFT JOIN taxonomy t ON t.tid=eyh.holiday_type "
                                    . "WHERE eyh.holiday_for_division='$division' AND eyh.holiday_start_date='$single_date' "
                                    . "ORDER BY eyh.id DESC LIMIT 1")->row_array();
//                $holiday_exist = $this->emp_holiday_model->getemp_yearlyholiday($division, $single_date);
                    }

                    if ($holiday_exist) {
                   // if ($holiday_exist && ($log_weekly_holiday != 'working_day')) {
                        // If holiday ----
                        $holiday_type_tid = $holiday_exist['holiday_type'];
                        $holiday_name = $holiday_exist['holiday_name']; // this will be echoed
                        $remarks = $holiday_exist['holiday_name'];
                        $login_time = $attendance_info['login_time'];
                        $logout_time = $attendance_info['logout_time'];
                         //echo "holiday";
                    } else {

                        $tstamp = strtotime($single_date);
                        $dated_day_name = date("D", $tstamp);
                         
                        $dated_day_name = strtolower($dated_day_name);
                             echo $dated_day_name;
                         
                        $empatt_start_date_arr = explode("-", $single_date);
                        $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
                        $offday_exist = $this->db->query("SELECT * FROM emp_weeklyholiday_history WHERE content_id='$emp_content_id' AND str_to_date(start_date, '%d-%m-%Y') <='$emp_att_start_date' ORDER BY id DESC LIMIT 1")->row_array();
//                    $offday_exist = $this->emp_weeklyholiday_history_model->getemp_weeklyholiday_historybydate($emp_content_id, $single_date);
                        //$offday_exist = $this->emp_holiday_model->getemp_holiday($emp_content_id);
                       
                        if ($offday_exist['' . $dated_day_name . '_off'] == 'off') {
   
                            $weekly_holiday = "Weekly Holiday";
                            $remarks = "Weekly Holiday";
                            // If weekly holiday
                          
                        }
                      
                        if ($log_weekly_holiday=='off_day') {
                            if($reason=="Weekly Holiday"){
                                $remarks = $reason;
                            }else if($reason=="Official Holiday"){
                                $holiday_name ="Official Holiday";
                            }
                            
                            // If log holiday
                        }

                        if (($remarks != "Weekly Holiday") || ($log_weekly_holiday=='working_day')) {
                             
//                        $leave_exist = $this->emp_leave_model->getemp_leave($emp_content_id, $single_date);
//                        $leave_exist = $this->db->query("SELECT leave_type,justification FROM emp_leave WHERE content_id='$emp_content_id' AND leave_start_date='$single_date' ORDER BY id DESC")->row_array();
                            $leave_exist = $this->db->query("SELECT el.leave_type,el.justification,t.name as leave_name "
                                            . "FROM emp_leave el "
                                            . "LEFT JOIN taxonomy t ON t.tid=el.leave_type "
                                            . "WHERE el.content_id='$emp_content_id' "
                                            . "AND el.leave_start_date='$single_date' AND approve_status='approved' ORDER BY el.id DESC")->row_array();

                            if ($leave_exist) {
                                 // If Leave ------
                                $leave_type = $leave_exist['leave_type'];
                                $leave_reason = $leave_exist['leave_name'];
                                if (!$leave_reason) {
                                    $leave_reason = "Leave";
                                }
                                if ($leave_type == '446') {
                                    $remarks = "Half Day Leave";
                                    $login_time = $attendance_info['login_time'];
                                    $logout_time = $attendance_info['logout_time'];
                                } else if ($leave_type == '336') {
                                    $remarks = "leave_without_pay";
                                } else {
                                    $remarks = "Leave";
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
                                            $remarks = "Half Day Absent";
                                        } else if (strtotime($emp_earlycount_time) > strtotime($logout_time)) {
                                            $half_absent_found = "Half Day Absent";
                                            $remarks = "Half Day Absent";
                                        } else {
                                            $half_absent_found = "Half Day Absent";
                                            $remarks = "Half Day Absent";
                                        }
                                    } else if ($late_status == "Late_Not_Count") {
                                        $remarks = $reason;
                                    } else if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                        $emp_late_found = "Late";
                                        $remarks = "Late";
                                        $login_time = "<font color=red >" . $login_time . "</font>";
                                    } else {
                                        $remarks = $attendance_info['remarks'];
                                    }
                                } else {
                                    //echo $emp_latecount_time;
                                    if ($presence_status_informed) {
                                        //---------------------------------------------------------------------------------------------------------------------------------------
                                        $presence_status = $presence_status_informed;
                                        $remarks = $informed_remarks;
                                        if ($presence_status == 'A') {
                                            $login_time = "";
                                            $logout_time = "";
                                        }
                                    } else if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                        $emp_late_found = "Late";
                                        $remarks = "Late";
                                        // $login_time="<font color=red >".$login_time."</font>";
                                    } else {
                                        $remarks = $attendance_info['remarks'];
                                    }
                                }
                            } // end of leave check condition
                        }
                        
                    }
                    // if not login but logout after 04:00 PM ....................................................
                    if (!$logout_time && $login_time && $login_time >= "16:00:00") {
                        $logout_time = $login_time;
                        $login_time = "";
                    }
                    ?>
                    <tr style="<?php
                    if ($remarks == "Weekly Holiday") {
                        echo "background-color:#FAEBD7 !important;";
                    }
                    ?>">
                        <td ><?php echo $single_date; ?></td>
                        <td style="<?php
                        if ($remarks != "Weekly Holiday" && $logout_time && !$login_time && strtotime($single_date) != strtotime($today)) {
                            echo "background:repeating-linear-gradient(45deg,#FFA07A,#FFA07A 2px, #FFF8DC 2px, #FFF8DC 3px);";
                        }
                        ?>"><?php
                                if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                    echo "<font color=red>" . $login_time . "</font>";
                                } else {
                                    echo $login_time;
                                }
                                ?></td>
                        <td style="<?php
                        if ($remarks != "Weekly Holiday" && $login_time && !$logout_time && strtotime($single_date) != strtotime($today)) {
                            echo "background:repeating-linear-gradient(45deg,#FFA07A,#FFA07A 2px, #FFF8DC 2px, #FFF8DC 3px);";
                        }
                        ?>"><?php
                                if ($logout_time && strtotime($logout_time) <= strtotime($emp_earlycount_time)) {
                                    echo "<font color=red>" . $logout_time . "</font>";
                                } else {
                                    echo $logout_time;
                                }
                                ?></td>
                        <td><?php echo $emp_details_info['division_name']; ?></td>
                        <td><?php
                            if ($login_time && $logout_time) {

                                if (strtotime($work_starting_time) > strtotime($login_time)) {
                                    if (strtotime($work_starting_time) > strtotime($logout_time)) {
                                        echo "00:00:00";
                                    } else {
                                        $working_time_today_total = get_time_difference($work_starting_time, $logout_time);
                                        $a = explode(':', $working_time_today_total);
                                        $t1 = $a[0] * 3600 + $a[1] * 60 + $a[2];
                                        $t3 = $t3 + $t1;
                                        echo $working_time_today_total;
                                    }
                                } else {
                                    $working_time_today_total = get_time_difference($login_time, $logout_time);
                                    $a = explode(':', $working_time_today_total);
                                    $t1 = $a[0] * 3600 + $a[1] * 60 + $a[2];
                                    $t3 = $t3 + $t1;
                                    echo $working_time_today_total;
                                }
                            }
                            $division_id_emp = $emp_details_info['emp_division'];
                            $post_id_emp = $emp_details_info['emp_post_id'];
                            ?></td>
                        <td><?php
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

                                        echo $emp_overtime_today;
                                    } else if ($remarks == "Weekly Holiday" && $working_time_today_total) {
                                        $b = explode(':', $working_time_today_total);
                                        $ot1 = $b[0] * 3600 + $b[1] * 60 + $b[2];
                                        $ot3 = $ot3 + $ot1;
                                        echo $working_time_today_total;
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
                                                    echo $timestamp;
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

                                            echo $emp_overtime_today;
                                        } else if ($remarks == "Weekly Holiday" && $working_time_today_total) {
                                            $b = explode(':', $working_time_today_total);
                                            $ot1 = $b[0] * 3600 + $b[1] * 60 + $b[2];
                                            $ot3 = $ot3 + $ot1;
                                            echo $working_time_today_total;
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
                            
                            ?></td>
                        <td><?php
                            // Counter Start ---------------------------------------------------------------Counter++ Start--
                            if ($holiday_name) {
                                echo "H";
                            } else if (($remarks == "Weekly Holiday") && ($log_weekly_holiday != 'working_day')) {
                              
                                    echo "W.H";
                                
                            } else if ($remarks == 'leave_without_pay') {
                                $remarks = "Leave without pay";
                                echo "<span class='red-color'>A</span>";
                                $absent_counter++;
                            } else if ($remarks == 'Leave') {
                                echo "A.L";
                              
                                $remarks = $leave_reason;
                            } else if ($remarks == 'Half Day Leave') {
                                echo "L.H";
                                $remarks = $leave_reason;
                            } else if ($attendance_required == 'Not_Required') {
                                echo "N"; //
                                $remarks = "Not Required";
                            } else if ($presence_status_informed) {
                                $daily_movement++;
                                if($informed_remarks=='personal'){
                                    $daily_movement_personal++;
                                }
                                $remarks = $informed_remarks;
                                if ($presence_status == 'A') {
                                    echo "<span class='red-color'>A</span>";
                                    $absent_counter++;
                                    $remarks = $informed_remarks;
                                } else if ($presence_status == 'P' && $logout_status_informed == 'P') {
                                    echo "P";
                                    $remarks = $informed_remarks;
                                } else if ($presence_status == 'P' && $logout_status_informed == 'E') {
                                    echo "<span class='blue-color'>E</span>"; // for early
                                    $remarks = " Early (" . $informed_remarks . ")";
                                    $early_counter++;
                                } else if ($presence_status == 'L' && $logout_status_informed == 'E') {
                                    echo "<span class='blue-color'>L.E</span>"; // for early
                                    $remarks = "Late & Early (" . $informed_remarks . ")";
                                    $late_counter++;
                                    $early_counter++;
                                } else if ($presence_status == 'A.H') {
                                    echo "<span class='red-color'>A.H</span>";
                                    $remarks = $informed_remarks;
                                    $absent_halfday_counter++;
                                } else if ($presence_status == 'L') {
                                    echo "<span class='blue-color'>L</span>";
                                    $remarks = $informed_remarks;
                                    $late_counter++;
                                } else if ($presence_status_informed == 'L') {
                                    $late_counter++;
                                    $remarks = "Late";
                                } else if ($logout_status_informed == 'E') {
                                    echo "<span class='blue-color'>E</span>"; // for early
                                    $remarks = "Early";
                                    $early_counter++;
                                }
                            } else if ($presence_status == 'A') {
                                echo "<span class='red-color'>A</span>";
                                $absent_counter++;
                                $remarks = $informed_remarks;
                            } else if ($presence_status == 'P') {
                                echo "P";
                                $remarks = $attendance_info['remarks'];
                            } else if ($presence_status == 'A.H') {
                                if (strtotime($single_date) == strtotime($today)) {
                                    echo "P";
                                } else {
                                    echo "<span class='red-color'>A.H</span>";
                                    $remarks = $attendance_info['remarks'];
                                    $absent_halfday_counter++;
                                }
                            } else if ($presence_status == 'L') {
                                echo "<span class='blue-color'>L</span>";
                                $remarks = $attendance_info['remarks'];
                                $late_counter++;
                            } else if ($late_status == "Late_Not_Count" && $early_status == "Early_Not_Count") {
                                if ($presence_status_has_no_log == "A" && !$login_time && !$logout_time) {
                                    $remarks = "Absent";
                                    echo "<span class='red-color'>A</span>";
                                    $absent_counter++;
                                } else if ($presence_status_has_no_log == "P") {
                                    echo "P";
                                    $remarks = $reason;
                                } else {
                                    echo "P";
                                    $remarks = $reason;
                                }
                            } else if ($late_status == "Late_Count_Time" && $early_status == "Early_Count_Time") {
                                //$emp_earlycount_time $emp_latecount_time
                                if ($login_time && $logout_time && strtotime($login_time) >= strtotime($emp_latecount_time) &&
                                        strtotime($logout_time) <= strtotime($emp_earlycount_time)) {
                                    $late_counter++;
                                    if (strtotime($single_date) == strtotime($today)) {
                                        echo "<span class='blue-color'>L</span>"; // for late
                                        $remarks = "Late!";                                        
                                    } else {
                                        echo "<span class='blue-color'>L.E</span>"; // for early
                                        $remarks = "Late & Early";
                                        $early_counter++;
                                    }
                                } else if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                    echo "<span class='blue-color'>L</span>"; // for Late
                                    $late_counter++;
                                    $remarks = "Late";
                                } else if ($logout_time && strtotime($logout_time) <= strtotime($emp_earlycount_time)) {
                                    if (strtotime($single_date) == strtotime($today)) {
                                        echo "P";
                                    } else {
                                        echo "<span class='blue-color'>E</span>"; // for early
                                        $remarks = $reason;
                                        $early_counter++;
                                    }
                                }else if ($login_time && !$logout_time) {
                                    $remarks = "Early";
                                    echo "<span class='blue-color'>E</span>";
                                    $early_counter++;
                                }else if (!$login_time && $logout_time) {
                                    $remarks = "Late";
                                    echo "<span class='blue-color'>L</span>";
                                    $early_counter++;
                                }else if (!$login_time && !$logout_time) {
                                    $remarks = "Absent";
                                    echo "<span class='red-color'>A</span>";
                                    $absent_counter++;
                                } else {
                                    $remarks = $reason;
                                    echo "P";
                                }
                            } else if ($late_status == "Late_Count_Time" && $early_status == "Early_Not_Count") {
                                
                                if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                    echo "<span class='blue-color'>L</span>"; // for Late
                                    $late_counter++;
                                    $remarks = $reason;
                                } else if (!$login_time && !$logout_time) {
                                    $remarks = "Absent";
                                    echo "<span class='red-color'>A</span>";
                                    $absent_counter++;
                                } else {
                                    $remarks = $reason;
                                    echo "P";
                                }
                            } else if ($late_status == "Late_Not_Count" && $early_status == "Early_Count_Time") {
                                
                                if (strtotime($logout_time) <= strtotime($emp_earlycount_time)) {
                                    if (strtotime($single_date) == strtotime($today)) {
                                        echo "P";
                                    } else {
                                        echo "<span class='blue-color'>E</span>"; // for early
                                        $remarks = $reason;
                                        $early_counter++;
                                    }
                                } else if (!$login_time && !$logout_time) {
                                    $remarks = "Absent";
                                    echo "<span class='red-color'>A</span>";
                                    $absent_counter++;
                                } else {
                                    $remarks = $reason;
                                    echo "P";
                                }
                            } else if (!$login_time && !$logout_time) {
                                $attendance_log = $this->emp_attendance_model->getemp_attendance_log();
                                $attendance_log_date = $attendance_log['attendance_date'];
                                if (strtotime($single_date) > strtotime($attendance_log_date)) {
                                    $remarks = "";
                                    echo "NC";
                                } else {
                                    $remarks = "Absent!";
                                    echo "<span class='red-color'>A</span>";
                                    $absent_counter++;
                                }
                                 
                            } else if ($login_time && !$logout_time && $logout_required == "Required" && $half_day_absent == 'Eligible') {
                                if (strtotime($single_date) == strtotime($today)) {
                                    echo "P";
                                } else {
                                    echo "<span class='red-color'>A.H</span>"; // for early
                                    $remarks = "Half Day Absent for Early";
                                    $absent_halfday_counter++;
                                }
                            } else if ($login_time && !$logout_time && $logout_required == "Required") {
                                if ($emp_late_found) {
                                    $late_counter++;
                                    if (strtotime($single_date) == strtotime($today)) {
                                        echo "<span class='blue-color'>L</span>"; // for late
                                        $remarks = "Late!";
                                    } else {
                                        echo "<span class='blue-color'>L.E</span>"; // for early
                                        $remarks = "Late & Early";
                                        $early_counter++;
                                    }
                                } else {
                                    if (strtotime($single_date) == strtotime($today)) {
                                        echo "p";
                                    } else {
                                        echo "<span class='blue-color'>E</span>"; // for early
                                        $remarks = "Early";
                                        $early_counter++;
                                    }
                                }
                            } else if ($login_time && !$logout_time && $logout_required == "Optional") {
                                echo "P";
                            } else if ($half_absent_found) {
                                if (strtotime($single_date) == strtotime($today)) {
                                    echo "P";
                                } else {
                                    echo "<span class='red-color'>A.H</span>";
                                    $absent_halfday_counter++;
                                }
                            } else if ($emp_late_found) {

                                if ($login_time && $logout_time && $logout_required == "Required" && strtotime($logout_time) <= strtotime($emp_earlycount_time)) {
                                    $late_counter++;
                                    if (strtotime($single_date) == strtotime($today)) {
                                        echo "<span class='blue-color'>L</span>"; // for late
                                        $remarks = "Late!";
                                    } else {
                                        echo "<span class='blue-color'>L.E</span>"; // for early
                                        $remarks = "Late & Early";
                                        $early_counter++;
                                    }
                                } else {
                                    echo "<span class='blue-color'>L</span>"; // for late
                                    $late_counter++;
                                    $remarks = "Late";
                                }
                            } else if ($login_time && $logout_time && $logout_required == "Required") {
                                if (strtotime($emp_earlycount_time) >= strtotime($logout_time)) {
                                    if (strtotime($single_date) == strtotime($today)) {
                                        echo "p";
                                    } else {
                                        echo "<span class='blue-color'>E</span>"; // for early
                                        $remarks = "Early";
                                        $early_counter++;
                                    }
                                } else {
                                    if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                        echo "<span class='blue-color'>L</span>";
                                        $late_counter++;
                                        $remarks = "Late";
                                    } else {
                                        echo "P";
                                    }
                                }
                            } else {
                                echo "P";
                            }
                            ?>
                        </td>
                        <td><?php
                            if ($remarks != 'NULL') {
                                echo $remarks;
                            }
                            ?></td>
                    </tr>
                    <?php
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
                    $holiday_exist = "";
                    if (strtotime($single_date) >= strtotime($today)) {
                        break;
                    }
                    if ($left_or_termineted_date) {
                        if (strtotime($single_date) >= strtotime($left_or_termineted_date)) {
                            break;
                        }
                    }
                }
            }
           
//        exit;
//        echo "end";
            $left_or_termineted_date = "";
            ?>
        </tbody>
        <tfoot style="border-bottom:none!important;">
            <tr style="border:none!important;">
                <td style="border:none!important;"></td>
                <td style="border:none!important;"></td>
                <td style="border:none!important;"></td>
                <td style="border:none!important;"></td>
                <td style="border-top:2px solid #000;;font-weight:bold"><?php
                    $h = floor($t3 / 3600);
                    $m = floor(($t3 % 3600) / 60);
                    $s = $t3 - $h * 3600 - $m * 60;
                    $total_wt=sprintf("%02d",$h).":".sprintf("%02d",$m).":".sprintf("%02d",$s);
                    echo $total_wt;
                    ?></td>
                <td style="border-top:2px solid #000;;font-weight:bold"><?php
                    $oh = floor($ot3 / 3600);
                    $om = floor(($ot3 % 3600) / 60);
                    $os = $ot3 - $oh * 3600 - $om * 60;
                    $total_ot=sprintf("%02d",$oh).":".sprintf("%02d",$om).":".sprintf("%02d",$os);
                     echo $total_ot;
                    ?></td>
                <td style="border:none!important;"></td>
                <td style="border:none!important;"></td>
            </tr>
        </tfoot>

    </table>

    <!--                         <div class="row">
                              <div class="col-md-6" style="width: 48%;color:#fff">.</div>
                              <div class="col-md-1" style="padding-left: 22px;width: 11.333333%;border-top:2px solid #000;font-weight:bold"><?php
    $h = floor($t3 / 3600);
    $m = floor(($t3 % 3600) / 60);
    $s = $t3 - $h * 3600 - $m * 60;
        $total_wt=sprintf("%02d",$h).":".sprintf("%02d",$m).":".sprintf("%02d",$s);
        echo $total_wt;
    ?></div>
                              <div class="col-md-1" style="width: 11.333333%;border-top:2px solid #000;font-weight:bold;padding-left:27px;"><?php
    $oh = floor($ot3 / 3600);
    $om = floor(($ot3 % 3600) / 60);
    $os = $ot3 - $oh * 3600 - $om * 60;
    $total_ot=sprintf("%02d",$oh).":".sprintf("%02d",$om).":".sprintf("%02d",$os);
     echo $total_ot; // sprintf("%02d", $num)
    ?></div>
                              <div class="col-md-2"></div>
                            </div>  
    -->
    <br>
    <br>
    <br>
    <br>
    <htmlpagefooter name="MyFooter1">
        <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;
               color: #000000; font-weight: bold; font-style: italic;">
            <tr style="margin-bottom:10px;color: #fff;font-size: 17px;">
                <td width="53%"><span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000;color:#000;">
                    Note: Total No of Late In <?php echo $late_counter; ?>, Early Out <?php echo $early_counter; ?>, 
                    Daily Movement
                        <?php
                            echo $daily_movement;
                            if($daily_movement>0){
                                $official=$daily_movement-$daily_movement_personal;
                                echo " (Per-".$daily_movement_personal.",Offi-".$official.")";
                            }
                        ?> and 
                    Half Day Absent <?php echo $absent_halfday_counter; ?></span></td>
                <td width="3%" align="center" style="font-weight: bold; font-style: italic;"></td>
                <td width="33%" style="text-align: right; "><span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000;color:#000">Total Days Absent <?php echo $absent_counter; ?></span></td>
            </tr>

        </table>
        <span style="font-weight: bold; font-style: italic;font-size:15px;">P: Present; A: Absent; A.H: Half Day Absent; L: Late; E: Early; L.E : Late & Early;Per: Personal; Offi:Official; H: Holiday; W.H: Weekly Holiday; NC: Not Calculated;</span>
    </htmlpagefooter>
</div>

<script>

    function PrintDiv() {
        var divToPrint = document.getElementById('report');
        var popupWin = window.open('', '_blank', 'width=800,height=auto');
        popupWin.document.open();
        var a = '<div style="width="100%; margin:0 auto;display:block;">\n\
        <div style="float:left;width:43%;text-align:right;">\n\
    \n\
    </div>\n\
    <div class="" style="line-height:40px;text-align: center;font-size:20px;color:black;font-weight:bold;text-decoration:underline;"> \n\
    <span style="padding-left:8px;font-family:Verdana, Geneva, sans-serif">Employee Wise Monthly Attendance Report <br><?php print $nowbigmonth; ?></span>' +
                '</div>\n\
    </div><br>';
        popupWin.document.write('<html><head><title>Monthly Attendance Report </title>\n\
    \n\
    \n\
    \n\
    \n\
    <style> body{ text-align:center;font-size:15px;margin:0 auto;}table{margin:0 auto;}table, th, td {padding-left:5px;padding-right:5px;font-size:10px;border: 1px solid black; border-collapse: collapse;}th{background: #DCDCDC; border-top:2px solid #000;} tr:nth-child(even) {background: #DCDCDC }tr:nth-child(odd) {background: #FFF}</style>\n\
                      \n\
    \n\
    \n\
    \n\
    \n\
    </head><body onload="window.print()">' + a + divToPrint.innerHTML + '</html>');
        popupWin.document.close();
    }
</script>
<sethtmlpagefooter name="MyFooter1" value="on" />
<br>

<?php
$end = microtime(true);
$exe_time = $end - $start;
echo "Report generated time: " . number_format($exe_time, 2) . " Seconds.";
?>