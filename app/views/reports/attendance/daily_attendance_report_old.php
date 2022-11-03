<div class="row">
    <div class="col-md-12 text-right">
        <?php
        $user_type = $this->session->userdata('user_type');
        $user_id = $this->session->userdata('user_id');
        $print_attendance=$this->users_model->getuserwisepermission("print_attendance", $user_id);
        // $print_attendance['status'] == 1 
        if ($user_type == 1 || $print_attendance['status'] == 1 ) { ?>
        
        <a class="btn btn-default pull-left " id="printButton" href="#" onclick="PrintDiv();"><span class="glyphicon glyphicon-print"> Print</span></a>
        
          <!--  <a onclick="return popitup('<?php echo site_url("savepdf/dailyattendancereportspdf"); ?>')" href="<?php echo site_url("savepdf/dailyattendancereportspdf"); ?>" class="operation-print-pdf operation-link"> <img src="<?php echo base_url(); ?>resources/images/pdf_icon_print.png" alt="pdf" style="width:20px;"/> </a> -->
        <?php } ?>
    </div>
</div>
<div id="report">
<table id="example" class="display" cellspacing="0" width="100%">
    <thead>
        <tr class="heading">
            <th>Log Date</th>
            <th>Emp. Code</th>
            <th>Emp Name</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Division</th>
            <th>Department</th>
<!--                         <th>WHours</th>
            <th>Over Time</th> -->
            <th>Att</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $late_counter = 0;
        $early_counter = 0;
        $absent_counter = 0;
        $absent_halfday_counter = 0;
        $half_day_absent_status = "";
        $early_status = "";
        $late_status = "";
        $total_emp = count($default_employee);
        date_default_timezone_set('Asia/Dhaka');
  $servertime = time();
        $today = date("d-m-Y", $servertime);
//                      print_r($default_employee);
        foreach ($default_employee as $single_emp) {
            if (strtotime($default_date) > strtotime($today)) {
                
                break;
            }
            $emp_content_id = $single_emp['content_id'];
            $empatt_start_date_arr = explode("-", $default_date);
            $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
            $emp_shift_time = $this->db->query("select * from emp_shift_history WHERE content_id ='$emp_content_id' AND str_to_date(start_date, '%d-%m-%Y') <='$emp_att_start_date' ORDER BY ID DESC LIMIT 1")->row_array();
//                $emp_shift_time = $this->emp_working_time_model->getworkingtimeBydateandid($emp_content_id, $default_date);
            $attendance_required = $emp_shift_time['attendance_required'];
            $work_starting_time = $emp_shift_time['work_starting_time'];
            $work_ending_time = $emp_shift_time['work_ending_time'];
            $logout_required = $emp_shift_time['logout_required'];
            $year = date('Y', strtotime($default_date));

            $empatt_start_date_arr = explode("-", $default_date);
            $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];

            $emp_latecount_time = $emp_shift_time['emp_latecount_time'];
            $emp_earlycount_time = $emp_shift_time['emp_earlycount_time'];
//                }             
            $half_day_absent = $emp_shift_time['half_day_absent'];
            $absent_count_time = $emp_shift_time['absent_count_time'];
            $overtime_count = $emp_shift_time['overtime_count'];
            $division_id_emp = $single_emp['emp_division'];
            $emp_division_id = $single_emp['emp_division'];
            $emp_department_id = $single_emp['emp_department'];
            $tstamp1 = strtotime($default_date);
            $dated_day_name1 = date("D", $tstamp1);
            $dated_day_name1 = strtolower($dated_day_name1);
            if ($division_id_emp == 301 && $dated_day_name1 == 'thu') {
                $work_ending_time = "16:00:00";
                $emp_earlycount_time = "16:00:00";
            }
            // check employee log maintanence ----------------
            $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,"
                            . "half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status "
                            . "FROM log_maintenence WHERE content_id='$emp_content_id' AND start_date='$default_date' "
                            . "order by id DESC LIMIT 1")->row_array();
            // check department log maintanence if employee log dosen't exist ----------------
            if (!$has_log_attendance_error) {
                $empDepartmentId = $single_emp['emp_department'];

                $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status FROM log_maintenence WHERE department_id=$empDepartmentId and start_date='$default_date' order by id DESC LIMIT 1")->row_array();
                // print_r($has_log_attendance_error);
            }
            // check division log maintanence if department & employee log dosen't  exist ----------------
            if (!$has_log_attendance_error) {
                $division_id_emp = $single_emp['emp_division'];
                $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status FROM log_maintenence WHERE division_id='$division_id_emp' and start_date='$default_date' order by id DESC LIMIT 1")->row_array();
            }
            // check all division log maintanence if division, department & employee log dosen't  exist ----------------
            $division = "all";
            if (!$has_log_attendance_error) {
                $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status FROM log_maintenence WHERE division_id='$division' and start_date='$default_date' order by id DESC LIMIT 1")->row_array();
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
            if (strtotime($default_date) <= strtotime('30-11-2018')) {
                // If before December, 2018 ----------------------------------------------------
                $attendance_info = $this->db->query("SELECT login_time,logout_time,remarks "
                                . "FROM emp_attendance_old "
                                . "WHERE content_id=$emp_content_id AND attendance_date='$default_date' "
                                . "ORDER BY id DESC")->row_array();
            } else {
                // If after November, 2018 ------------------------------------------------------
                $attendance_info = $this->db->query("SELECT login_time,logout_time,remarks "
                                . "FROM emp_attendance "
                                . "WHERE content_id=$emp_content_id AND attendance_date='$default_date' "
                                . "ORDER BY id DESC")->row_array();
            }
            $login_time = $attendance_info['login_time'];
            $logout_time = $attendance_info['logout_time'];
            // Attendance informed info from informed table(such as  Daily movement ) --------------------------------------
            $emp_informed_info = $this->db->query("SELECT presence_status,logout_status,reason,remarks FROM emp_informed WHERE content_id=$emp_content_id AND attendance_date='$default_date' AND second_approval=1 ORDER BY id DESC")->row_array();

            // If holiday exist for employee division ----
                        $holiday_exist = $this->db->query("SELECT eyh.holiday_type,t.name as holiday_name "
                                        . "FROM emp_yearlyholiday eyh "
                                        . "LEFT JOIN taxonomy t ON t.tid=eyh.holiday_type "
                                        . "WHERE eyh.holiday_for_division='$emp_division_id' AND eyh.holiday_for_department='$emp_department_id' AND eyh.holiday_start_date='$default_date' "
                                        . "ORDER BY eyh.id DESC")->row_array();
                    
                    if (!$holiday_exist) {
                        // If holiday exist for employee company ----
                        $holiday_exist = $this->db->query("SELECT eyh.holiday_type,t.name as holiday_name "
                                        . "FROM emp_yearlyholiday eyh "
                                        . "LEFT JOIN taxonomy t ON t.tid=eyh.holiday_type "
                                        . "WHERE eyh.holiday_for_division='$emp_division_id' AND (eyh.holiday_for_department = NULL OR eyh.holiday_for_department = '') AND eyh.holiday_start_date='$default_date' "
                                        . "ORDER BY eyh.id DESC")->row_array();
//                    $holiday_exist = $this->emp_holiday_model->getemp_yearlyholiday($division, $single_date);
                    }
                    if (!$holiday_exist) {
                        // If holiday exist for all company ----
                        $holiday_exist = $this->db->query("SELECT eyh.holiday_type,t.name as holiday_name "
                                    . "FROM emp_yearlyholiday eyh "
                                    . "LEFT JOIN taxonomy t ON t.tid=eyh.holiday_type "
                                    . "WHERE eyh.holiday_for_division='$division' AND eyh.holiday_start_date='$default_date' "
                                    . "ORDER BY eyh.id DESC LIMIT 1")->row_array();
//                $holiday_exist = $this->emp_holiday_model->getemp_yearlyholiday($division, $single_date);
                    }
            if ($holiday_exist) {

                $holiday_type_tid = $holiday_exist['holiday_type'];
                $holiday_name = $holiday_exist['holiday_name']; // this will be echoed
                $remarks = $holiday_exist['holiday_name'];
                $login_time = $attendance_info['login_time'];
                $logout_time = $attendance_info['logout_time'];
            } else {

                $tstamp = strtotime($default_date);
                $dated_day_name = date("D", $tstamp);
                $dated_day_name = strtolower($dated_day_name);
                $empatt_start_date_arr = explode("-", $default_date);
                $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];
                $offday_exist = $this->db->query("SELECT * FROM emp_weeklyholiday_history WHERE content_id='$emp_content_id' AND str_to_date(start_date, '%d-%m-%Y') <='$emp_att_start_date' ORDER BY id DESC LIMIT 1")->row_array();
//                    $offday_exist = $this->emp_weeklyholiday_history_model->getemp_weeklyholiday_historybydate($emp_content_id, $default_date);
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

                if (($remarks != "Weekly Holiday") || ($log_weekly_holiday == 'working_day')) {
//                        $leave_exist = $this->emp_leave_model->getemp_leave($emp_content_id, $default_date);
//                        $leave_exist = $this->db->query("SELECT leave_type,justification FROM emp_leave WHERE content_id='$emp_content_id' AND leave_start_date='$default_date' ORDER BY id DESC")->row_array();
                    $leave_exist = $this->db->query("SELECT el.leave_type,el.justification,t.name as leave_name "
                                    . "FROM emp_leave el "
                                    . "LEFT JOIN taxonomy t ON t.tid=el.leave_type "
                                    . "WHERE el.content_id='$emp_content_id' "
                                    . "AND el.leave_start_date='$default_date' AND approve_status='approved' ORDER BY el.id DESC")->row_array();

                    if ($leave_exist) {

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
            <tr>
                <td><?php print $default_date; ?></td>
                <td><?php print $single_emp['emp_id']; ?></td>
                <td><?php print $single_emp['emp_name'] . "" . $mobile_no; ?></td>
                <td><?php print $login_time; ?></td>
                <td><?php print $logout_time; ?></td>
                <td><?php
        $emp_division = $this->taxonomy->getTaxonomyBytid($single_emp['emp_department']);
        $emp_division_shortname = $emp_division['name'];
        print $emp_division_shortname;
        ?></td>
                <td><?php
                    $emp_dep = $this->taxonomy->getTaxonomyBytid($single_emp['department_id']);
                    $empDepartment = $emp_dep['name'];
                    print $empDepartment;
                    ?></td>

                <td><?php
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
                        if ($reason_informed == 'personal') {
                            $daily_movement_personal++;
                        }
                        //echo $presence_status_informed;
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
                        } else if ($presence_status == 'L' && $logout_status_informed == 'E') {
                            echo "<span class='blue-color'>L.E</span>"; // for early
                            $remarks = "Late & Early (" . $informed_remarks . ")";
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
                        } else if (!$login_time && !$logout_time) {
                            $remarks = "Absent";
                            echo "<span class='red-color'>A</span>";
                            $absent_counter++;
                        } else {
                            $remarks = $reason;
                            echo "P";
                        }
                    } else if ($late_status == "Late_Count_Time" && $early_status == "Early_Not_Count") {
                        //$emp_earlycount_time $emp_latecount_time
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
                        //$emp_earlycount_time $emp_latecount_time
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
                            // if($emp_late_found){
                            //   echo "<span class='blue-color'>L</span>";
                            //   $late_counter++;
                            // }else{
                            //    echo "P";
                            // }
//echo $test;
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
                    $remarks = "";
                    $reason = "";
                    $half_absent_found = "";
                    $emp_late_found = "";
                    $late_status = "";
                    $early_status = "";
                }
                ?>
    </tbody>
</table>                       
<br>
<br>
<br>
<br>
<htmlpagefooter name="MyFooter1">
    <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; 
           color: #000000; font-weight: bold; font-style: italic;">
        <tr style="margin-bottom:10px;background: #40618C;color: #fff;font-size: 17px;">
            <td width="53%"><span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000">Total Employee <?php print $total_emp; ?>; Total No of Late <?php print $late_counter; ?>, Early Out <?php print $early_counter; ?> and Half Day Absent <?php print $absent_halfday_counter; ?></span></td>
            <td width="3%" align="center" style="font-weight: bold; font-style: italic;"></td>
            <td width="33%" style="text-align: right; "><span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000;">Total Absent <?php print $absent_counter; ?></span></td>
        </tr>
        <tr>
            <td width="73%"><span style="font-weight: bold; font-style: italic;">P: Present; A : Absent; A.H: Half Day Absent; L: Late; H: Holiday; NC: Not Calculated;</span></td>
            <td width="3%" align="center" style="font-weight: bold; font-style: italic;"></td>
            <td width="23%" style="text-align: right; "></td>
        </tr>    
    </table>
</htmlpagefooter>
<sethtmlpagefooter name="MyFooter1" value="on" /> 
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
    <span style="padding-left:8px;font-family:Verdana, Geneva, sans-serif">Daily Attendance Report <br><?php print $default_date; ?></span>' +
                '</div>\n\
    </div><br>';
        popupWin.document.write('<html><head><title>Daily Attendance Report </title>\n\
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
<br>  