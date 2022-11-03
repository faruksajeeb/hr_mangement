<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Attendance Reports of <?php print $default_emp['emp_name']; ?></title>
  <?php
  $this->load->view('includes/printcss');
  date_default_timezone_set('Asia/Dhaka');
  $servertime = time();
  $today_date = date("d-m-Y", $servertime);    
  ?> 

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
    height: 42px;
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
<body class="logged-in dashboard current-page print-attendance">
  <!-- Page Content -->  
  <div id="page-content-wrapper">
    <div class="container-fluid">
      <?php 
      date_default_timezone_set('Asia/Dhaka');
      $servertime = time();
      $lastdateofattendance=end($date_range); 
      $now = date("d-m-Y H:i:s", $servertime);
      $nowdate = date("d-m-Y", $servertime);
      $thisyear = date("Y", $servertime);
      $datee = date_create($lastdateofattendance);
      $nowbigmonth = date_format($datee, 'F, Y');
      $nowtime = date("H:i:s a", $servertime);
            $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
            $last_day_this_month  = date('t-m-Y');
            ?>
            <div class="row" style="font-weight:normal">
              <!-- <div class="col-md-12" style="width:595px;"> -->
              <div class="col-md-12" >
                <h1 style="font-size:25px;font-weight:bold;text-align:center">IIDFC Securities Limited</h1>
                <!-- <p>House #25, Road #34, Gulshan-2, Dhaka-1212</p>
                <p>Telephone: +8802-8812396, 9880916, 9881424, 8818561, 9892111</p>
                <p>Fax: +8802-8826439, 9880918</p> -->
              </div>
              <!-- <div class="col-md-2" style="width:100px;"> <img src="<?php echo base_url(); ?>resources/images/logo.png" alt="" id="logo-img"/></div> -->
            </div>
            <div class="row">
              <div class="col-md-12">
                <!-- <p>E-mail : info@ahmedamin.com, cocdhaka@ahmedamin-bd.com, ahmedamingroup@gmail.com, misaag@ahmedamin.com</p> -->
              </div>
            </div>
            <div class="row under-header-bar text-center"> 
              <h1 style="font-size:20px;font-weight:bold">Employee Wise Monthly Attendance Report<br><?php print $nowbigmonth; ?></h1>         
            </div> 
        <div class="emp_info">
          <div class="row">
            <div class="col-md-1" style="width:110px;">Employee ID:</div>
            <div class="col-md-9" style="width:250px;"><?php print $default_emp['emp_id']; ?></div>
            <div class="col-md-1" style="width:100px;">Date:</div>
            <div class="col-md-1" style="width:180px;"><?php print $nowdate; ?></div>
          </div>
          <div class="row">
            <div class="col-md-1"  style="width:110px;">Employee Name:</div>
            <div class="col-md-9" style="width:250px;"><?php print $default_emp['emp_name']; ?></div>
            <div class="col-md-1" style="width:100px;">Time:</div>
            <div class="col-md-1" style="width:180px;"><?php print $nowtime; ?></div>
          </div>     
          <div class="row"> 
            <div class="col-md-1" style="width:110px;" >Designation:</div>
            <div class="col-md-9" style="width:250px;"><?php 
              $emp_post_id = $default_emp['emp_post_id']; 
              $emp_post_id_data=$this->taxonomy->getTaxonomyBytid($emp_post_id);
              print $emp_post_id_data['name']; 
              ?></div>          
              <div class="col-md-1" style="width:100px;"  >Leave Spent:</div>
              <div class="col-md-9" style="width:180px;" ><?php 
                $total_leave_query=$this->emp_leave_model->getemp_sumleavetotal($defaultcontent_id, $lastdateofattendance);
                if(!$total_leave_query['Totalleave']){
                  print "0";
                }else{
                  print $total_leave_query['Totalleave'];
                }  ?></div>

              </div>  
              <div class="row">
                <div class="col-md-1" style="width:110px;"  >Joining Date:</div>
                <div class="col-md-1" style="width:250px;" ><?php print $default_emp['joining_date']; ?></div>        
                <div class="col-md-1" style="width:100px;">Service Length: </div>
                <div class="col-md-9" style="width:180px;font-size: 10px;"><?php 
                 $joining_date_arr=explode('-',$default_emp['joining_date']);
                 $joining_date_reversed=$joining_date_arr[2]."-".$joining_date_arr[1]."-".$joining_date_arr[0]." 00:00:00";
                 $jo=strtotime($joining_date_reversed);
                 date_default_timezone_set('Asia/Dhaka');
                 $now = time();
                 $removed=timespan($jo, $now);
                   $removed=timespan($jo, $now);
                   $pieces = explode(",", $removed);
                   foreach ($pieces as $key => $ll) {
                      if (strpos($ll,'Hour') !== false || strpos($ll,'Minute') !== false) {
                          unset($pieces[$key]);
                      }
                  }
                  $string = rtrim(implode(',', $pieces), ',');
                  echo $string;                 
                // echo substr($removed, 0, -21);
                 ?></div>
               </div> 
                 <?php 
                      $left_or_termineted=$default_emp['type_of_employee'];
                      if($left_or_termineted==153 || $left_or_termineted==473){
                        $left_or_termineted_data =$this->emp_job_history_model->getemp_last_job_history($defaultcontent_id);
                        $left_or_termineted_date=$left_or_termineted_data['start_date'];
                      }                 
                      $emp_shift_time_last =$this->emp_working_time_model->getworkingtimeBydateandid($defaultcontent_id, $lastdateofattendance);
                      $work_starting_time_last = $emp_shift_time_last['work_starting_time'];
                      $work_ending_time_last = $emp_shift_time_last['work_ending_time'];
                 ?> 
              <div class="row">
                <div class="col-md-1" style="width:110px;"  >Work Start Time:</div>
                <div class="col-md-1" style="width:250px;" ><?php print $work_starting_time_last; ?></div>
                <div class="col-md-1" style="width:100px;" >Work End Time:</div>
                <div class="col-md-1" style="width:180px;" ><?php print $work_ending_time_last; ?></div>
              </div>                                                              
             </div>               
             <div class="wrapper">
              <div class="row">
                <div class="col-md-12">

                  <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                      <tr class="heading" style="border:2px solid #000;font-size:12px;">
                        <th>Log Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Department</th>
                        <th>WHours</th>
                        <th>Over Time</th>
                        <th>Att</th>
                        <th>Remarks</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $late_counter=0;
                      $early_counter=0;
                      $absent_counter=0;
                      $absent_halfday_counter=0;
                      $daily_movement=0;
                      $daily_movement_personal=0;
                      $emp_division_shortname = $emp_division['keywords'];
                      $emp_division_id = $emp_details_info['emp_division'];
                      $emp_department_id = $emp_details_info['emp_department'];
                      $emp_joining_date=$default_emp['joining_date'];
                      $half_day_absent_status="";
                      $early_status="";
                      $late_status="";
                      $today = date("d-m-Y", $servertime);
                      foreach ($date_range as $single_date) {
                        if($left_or_termineted_date){
                          if(strtotime($single_date) >= strtotime($left_or_termineted_date)){
                            break;
                          }
                        }
                        if(strtotime($single_date) >= strtotime($emp_joining_date)){
                          $emp_shift_time =$this->emp_working_time_model->getworkingtimeBydateandid($emp_content_id, $single_date);
                          $division_id_emp = $emp_details_info['emp_division'];

                        $attendance_required = $emp_shift_time['attendance_required'];
                        $work_starting_time = $emp_shift_time['work_starting_time'];
                        $work_ending_time = $emp_shift_time['work_ending_time'];
                        $logout_required = $emp_shift_time['logout_required'];
                        $year=date('Y', strtotime($single_date));
                        $empatt_start_date_arr = explode("-", $single_date);
                        $emp_att_start_date = $empatt_start_date_arr[2] . "-" . $empatt_start_date_arr[1] . "-" . $empatt_start_date_arr[0];

                        $emp_latecount_time = $emp_shift_time['emp_latecount_time'];
                        $emp_earlycount_time = $emp_shift_time['emp_earlycount_time'];                 
                        $half_day_absent = $emp_shift_time['half_day_absent'];
                        $absent_count_time = $emp_shift_time['absent_count_time'];
                        $overtime_count = $emp_shift_time['overtime_count'];
                        $tstamp1 = strtotime($single_date);
                        $dated_day_name1 = date("D", $tstamp1);
                        $dated_day_name1 = strtolower($dated_day_name1);
                        if($division_id_emp==301 && $dated_day_name1 =='thu'){
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
                                $empDepartmentId = $emp_details_info['emp_department'];
                                $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status FROM log_maintenence WHERE department_id=$empDepartmentId and start_date='$single_date' order by id DESC LIMIT 1")->row_array();
                            }
                            // check division log maintanence if department & employee log dosen't  exist ----------------
                            if (!$has_log_attendance_error) {
                                $division_id_emp = $emp_details_info['emp_division'];
                                $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status FROM log_maintenence WHERE division_id='$division_id_emp' and start_date='$single_date' order by id DESC LIMIT 1")->row_array();
                            }
                            // check all division log maintanence if division, department & employee log dosen't  exist ----------------
                            $division = "all";
                            if (!$has_log_attendance_error) {
                                $has_log_attendance_error = $this->db->query("SELECT weekly_holiday,late_status,present_status,late_count_time,half_day_absent_status,early_count_time,reason,half_day_absent_count_time,early_status FROM log_maintenence WHERE division_id='$division' and start_date='$single_date' order by id DESC LIMIT 1")->row_array();
                            }

                            // If log exist ------------------      
                          if($has_log_attendance_error){
                            $late_status=$has_log_attendance_error['late_status'];
                            $log_weekly_holiday = $has_log_attendance_error['weekly_holiday'];
                            if($late_status=='Late_Count_Time'){
                              $emp_latecount_time=$has_log_attendance_error['late_count_time'];
                            }
                            $half_day_absent_status=$has_log_attendance_error['half_day_absent_status'];
                            if($half_day_absent_status=='Half_Day_Absent_Count_Time'){
                             $absent_count_time=$has_log_attendance_error['half_day_absent_count_time'];
                           } 
                           $early_status=$has_log_attendance_error['early_status'];
                           if($early_status=='Early_Count_Time'){
                             $emp_earlycount_time=$has_log_attendance_error['early_count_time'];
                           }                                                                                    
                           $reason=$has_log_attendance_error['reason'];
                         }  
                         if(strtotime($single_date) <= strtotime('30-11-2018')){
                        $emp_atten_info = $this->db->query("SELECT login_time,logout_time,remarks "
                                    . "FROM emp_attendance_old "
                                    . "WHERE content_id=$emp_content_id AND attendance_date='$single_date' "
                                    . "ORDER BY id DESC")->row_array();
                    }else{

                        $emp_atten_info = $this->db->query("SELECT login_time,logout_time,remarks "
                                    . "FROM emp_attendance "
                                    . "WHERE content_id=$emp_content_id AND attendance_date='$single_date' "
                                    . "ORDER BY id DESC")->row_array();
                    }
                         // $emp_atten_info = $this->emp_attendance_model->getemp_dailyattendance($emp_content_id, $single_date);
                         $emp_informed_info = $this->emp_informed_model->getemp_informed($emp_content_id, $single_date);

                       
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
                          $holiday_type_tid = $holiday_exist['holiday_type'];
                          $holiday_name_info = $this->taxonomy->getTaxonomyBytid($holiday_type_tid);
                                            $holiday_name = $holiday_name_info['name']; // this will be printed
                                            $remarks = $holiday_name_info['name'];
                                            $login_time = $emp_atten_info['login_time'];
                                            $logout_time = $emp_atten_info['logout_time'];                                              
                                          } else {
                                            $tstamp = strtotime($single_date);
                                            $dated_day_name = date("D", $tstamp);
                                            $dated_day_name = strtolower($dated_day_name);
                                            $offday_exist =$this->emp_weeklyholiday_history_model->getemp_weeklyholiday_historybydate($emp_content_id, $single_date);
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
                                              $leave_exist = $this->emp_leave_model->getemp_leave($emp_content_id, $single_date);
                                              if ($leave_exist) {
                                                $leave_type=$leave_exist['leave_type'];
                                                $leave_type_taxonomy=$this->taxonomy->getTaxonomyBytid($leave_type);
                                                $leave_reason=$leave_type_taxonomy['name'];
                                                if(!$leave_reason){
                                                  $leave_reason="Leave";
                                                }
                                                if($leave_type=='446'){
                                                  $remarks = "Half Day Leave";
                                                  $login_time = $emp_atten_info['login_time'];
                                                  $logout_time = $emp_atten_info['logout_time'];                                                      
                                                }else if($leave_type=='336'){
                                                  $remarks = "leave_without_pay";                                                    
                                                }else{
                                                  $remarks = "Leave";
                                                }
                                              } else {
                                                $presence_status ="";
                                                $presence_status_informed = $emp_informed_info['presence_status'];
                                                 $logout_status_informed = $emp_informed_info['logout_status'];
                                                 $reason_informed = $emp_informed_info['reason'];
                                                $informed_remarks = $emp_informed_info['remarks'];
                                                 if($reason_informed!=$informed_remarks){
                                $informed_remarks = $emp_informed_info['reason']." [<span style='font-size:8px;'>".$emp_informed_info['remarks']."]</span>";
                            }
                                                $login_time = $emp_atten_info['login_time'];
                                                $logout_time = $emp_atten_info['logout_time'];   
                                                if ($half_day_absent == 'Eligible') {
                                                      if($half_day_absent_status=='Half_Day_Absent_Not_Count'){ // problem day
                                                        $remarks = $reason;
                                                      }else if ($login_time && strtotime($login_time) >= strtotime($absent_count_time)) {
                                                        if(!$logout_time){
                                                          $half_absent_found = "Half Day Absent";
                                                          $remarks = "Half Day Absent";
                                                        }else if(strtotime($emp_earlycount_time) >= strtotime($logout_time)){
                                                          $half_absent_found = "Half Day Absent";
                                                          $remarks = "Half Day Absent";
                                                        }else{
                                                          $half_absent_found = "Half Day Absent";
                                                          $remarks = "Half Day Absent";
                                                        }
                                                      } else if ($late_status =="Late_Not_Count") {
                                                        $remarks = $reason;
                                                      }else if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                                        $emp_late_found = "Late";
                                                        $remarks = "Late";
                                                      } else {
                                                        $remarks = $emp_atten_info['remarks'];
                                                      }
                                                    } else {
                                                        //print $emp_latecount_time;
                                                      if($presence_status_informed){
                                                        $presence_status=$presence_status_informed;
                                                        $remarks=$informed_remarks;
                                                        if($presence_status=='A'){
                                                          $login_time="";
                                                          $logout_time="";
                                                         }                                                        
                                                      }else if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                                        $emp_late_found = "Late";
                                                        $remarks = "Late";
                                                      } else {
                                                        $remarks = $emp_atten_info['remarks'];
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
                                            <tr style="border:1px solid #000;border-bottom:none;border-left:none;border-right:none;<?php if($remarks =="Weekly Holiday"){ echo "background-color:#FAEBD7 !important;"; } ?>">
                                              <td><?php print $single_date; ?></td>
                                              <td><?php print $login_time; ?></td>
                                              <td><?php print $logout_time; ?></td>
                                              <td><?php print $emp_division_shortname; ?></td>
                                              <td><?php 

                                                if($login_time && $logout_time){
                                                  if(strtotime($work_starting_time) > strtotime($login_time)){
                                                    if(strtotime($work_starting_time) > strtotime($logout_time)){
                                                      print "00:00:00";
                                                    }else{
                                                      $working_time_today_total=get_time_difference($work_starting_time, $logout_time);
                                                      $a=explode(':',$working_time_today_total);
                                                      $t1=$a[0]*3600+$a[1]*60+$a[2];
                                                      $t3=$t3+$t1;
                                                      print $working_time_today_total;
                                                    }
                                                  }else{
                                                    $working_time_today_total= get_time_difference($login_time, $logout_time);
                                                    $a=explode(':',$working_time_today_total);
                                                    $t1=$a[0]*3600+$a[1]*60+$a[2];
                                                    $t3=$t3+$t1;
                                                    print $working_time_today_total;
                                                  }
                                                }
                                                $division_id_emp = $emp_details_info['emp_division'];
                                                $post_id_emp = $emp_details_info['emp_post_id'];
                                                ?></td>
                                                <td><?php if(strtotime($logout_time) > strtotime($work_ending_time) || ($login_time && $logout_time && $division_id_emp==20)){ 
                                                     // overtime count after 10 minutes for medisys
                                                    
                                                    if($division_id_emp==20){
                                                      $medisys_time = strtotime($work_ending_time);
                                                      $endTime_medisys = date("H:i:s", strtotime('+16 minutes', $medisys_time));
                                                      if(strtotime($logout_time) > strtotime($endTime_medisys)){
                                                      $emp_overtime_today= get_time_difference($endTime_medisys, $logout_time); 
                                                      if($holiday_exist || $remarks=='Weekly Holiday'){
                                                        $emp_overtime_today=$working_time_today_total;
                                                      }
                                                      $b=explode(':',$emp_overtime_today);
                                                      $ot1=$b[0]*3600+$b[1]*60+$b[2];
                                                      $ot3=$ot3+$ot1;
                                                      print $emp_overtime_today;
                                                      }else if($remarks=="Weekly Holiday" && $working_time_today_total){
                                                        $b=explode(':',$working_time_today_total);
                                                        $ot1=$b[0]*3600+$b[1]*60+$b[2];
                                                        $ot3=$ot3+$ot1;
                                                        print $working_time_today_total;
                                                      }
                                                    }else{
                                                      
                                                        // security guard er jonno daily -8 hours overtime and holiday wholeday holiday
                                                        if($post_id_emp==57 || $post_id_emp==58 || $post_id_emp==59 || $post_id_emp==60 || $post_id_emp==117){
                                                          if(strtotime($login_time) && strtotime($logout_time)){
                                                          $emp_overtime_today= get_time_difference($login_time, $logout_time); 
                                                        $officetime = strtotime("-8 hours");
                                                          $timestamp = strtotime($emp_overtime_today);
                                                          if($timestamp>$officetime){
                                                            if($holiday_exist || $remarks=='Weekly Holiday'){
                                                            $timestamp = strtotime($emp_overtime_today);
                                                            }else{
                                                              $timestamp = strtotime($emp_overtime_today) - 60*60*8;
                                                            }
                                                          
                                                          $timestamp = date("H:i:s", $timestamp);

                                                          if($timestamp){
                                                            $b=explode(':',$timestamp);
                                                            $ot1=$b[0]*3600+$b[1]*60+$b[2];
                                                            $ot3=$ot3+$ot1;
                                                            print $timestamp;
                                                          }
                                                        }
                                                        }
                                                      }else{

                                                        $for_all_time = strtotime($work_ending_time);
                                                     // $endTime_for_all = date("H:i:s", strtotime('+20 minutes', $for_all_time));
                                                      $endTime_for_all = date("H:i:s", strtotime('+00 minutes', $for_all_time));
                                                      if(strtotime($logout_time) > strtotime($endTime_for_all)){
                                                      $emp_overtime_today= get_time_difference($endTime_for_all, $logout_time); 
                                                      
                                                      if($holiday_exist || $remarks=="Weekly Holiday"){
                                                        $emp_overtime_today=$working_time_today_total;
                                                      }else if(!$emp_overtime_today){
                                                        $emp_overtime_today=$working_time_today_total;
                                                      }

                                                      $b=explode(':',$emp_overtime_today);
                                                      $ot1=$b[0]*3600+$b[1]*60+$b[2];
                                                      $ot3=$ot3+$ot1;
                                                      
                                                         print $emp_overtime_today;
                                                      }else if($remarks=="Weekly Holiday" && $working_time_today_total){
                                                        $b=explode(':',$working_time_today_total);
                                                        $ot1=$b[0]*3600+$b[1]*60+$b[2];
                                                        $ot3=$ot3+$ot1;
                                                        print $working_time_today_total;
                                                      }


                                                      // start for all overtime
                                                        // $emp_overtime_today= get_time_difference($work_ending_time, $logout_time); 
                                                        // $b=explode(':',$emp_overtime_today);
                                                        // $ot1=$b[0]*3600+$b[1]*60+$b[2];
                                                        // $ot3=$ot3+$ot1;
                                                        // print $emp_overtime_today;
                                                        // ends for all overtime
                                                      }

                                                      
                                                      
                                                    }
                                                } 
                                                ?></td>
                                                <td><?php 
                                                  if($holiday_name){ 
                                                    print "H";
                                                  } else if (($remarks == "Weekly Holiday") && ($log_weekly_holiday != 'working_day')) {
                              
                                                            echo "W.H";
                                                        
                                                  }else if($remarks=='leave_without_pay'){ 
                                                    $remarks = "Leave without pay";
                                                    print "A";
                                                    $absent_counter++;
                                                  }else if($remarks=='Leave'){ 
                                                    print "A.L";
                                                    $remarks=$leave_reason;
                                                  }else if($remarks=='Half Day Leave'){ 
                                                    print "L.H";
                                                    $remarks=$leave_reason;
                                                  } else if($attendance_required=='Not_Required'){ 
                                      print "N";
                                      $remarks="Not Required";
                                    } else if ($presence_status_informed) {
                                        $daily_movement++;
                                        if($informed_remarks=='personal'){
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
                                                            $remarks =" Early (". $informed_remarks.")";
                                                        }else if ($presence_status== 'L' && $logout_status_informed == 'E' ) {
                                                            echo "<span class='blue-color'>L.E</span>"; // for early
                                                                $remarks = "Late & Early (". $informed_remarks.")";
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
                                                        }  else if ($logout_status_informed == 'E' ) {
                                                            echo "<span class='blue-color'>E</span>"; // for early
                                                                $remarks = "Early";
                                                                $early_counter++;
                                                        }
                                                    } else if($presence_status=='P'){ 
                                      print "P";
                                      $remarks = $emp_atten_info['remarks']; 
                                    }else if($presence_status=='A.H'){ 
                                      if(strtotime($single_date) == strtotime($today)){
                                            print "P"; 
                                          }else{
                                            print "<span class='red-color'>A.H</span>";
                                            $remarks = $emp_atten_info['remarks'];
                                            $absent_halfday_counter++;
                                          } 
                                    }else if($presence_status=='L'){ 
                                      print "<span class='blue-color'>L</span>";
                                      $remarks = $emp_atten_info['remarks']; 
                                      $late_counter++;
                                    }else if ($late_status =="Late_Not_Count" && $early_status =="Early_Not_Count"){
                                      //print "P";
                                      //$remarks = $reason; 
                                    if($presence_status_has_no_log=="A" && !$login_time && !$logout_time){
                                      $remarks = "Absent";
                                      print "<span class='red-color'>A</span>";
                                      $absent_counter++; 
                                    }else if($presence_status_has_no_log=="P"){
                                      print "P";
                                      $remarks = $reason;
                                    }else{
                                      print "P";
                                      $remarks = $reason;
                                    }
                                    }else if ($late_status =="Late_Count_Time" && $early_status =="Early_Count_Time") {
                                      //$emp_earlycount_time $emp_latecount_time
                                      if($login_time && $logout_time && strtotime($login_time) >= strtotime($emp_latecount_time) && strtotime($logout_time) <= strtotime($emp_earlycount_time)){ 
                                          $late_counter++;  
                                          if(strtotime($single_date) == strtotime($today)){
                                            print "<span class='blue-color'>L</span>"; // for late 
                                            $remarks="Late!";
                                          } else{
                                            print "<span class='blue-color'>L.E</span>"; // for early 
                                            $remarks="Late & Early";
                                            $early_counter++;      
                                          }                                           
                                      }else if($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)){
                                        print "<span class='blue-color'>L</span>"; // for Late
                                        $late_counter++;  
                                        $remarks="Late"; 
                                      }else if($logout_time && strtotime($logout_time) <= strtotime($emp_earlycount_time)){
                                        print "<span class='blue-color'>E</span>"; // for early
                                        $early_counter++;  
                                        $remarks=$reason; 
                                      }else if(!$login_time && !$logout_time){
                                        $remarks = "Absent";
                                        print "A"; 
                                        $absent_counter++;                                       
                                      }else{
                                        $remarks = $reason;
                                        print "P";
                                      }

                                    }else if ($late_status =="Late_Count_Time" && $early_status =="Early_Not_Count") {
                                      //$emp_earlycount_time $emp_latecount_time
                                      if($login_time && strtotime($login_time) > strtotime($emp_latecount_time)){ 
                                        print "<span class='blue-color'>L</span>"; // for Late
                                        $late_counter++;  
                                        $remarks=$reason;
                                      }else if(!$login_time && !$logout_time){
                                        $remarks = "Absent";
                                        print "A"; 
                                        $absent_counter++;                                       
                                      }else{
                                        $remarks = $reason;
                                        print "P";
                                      }
                                    }else if ($late_status =="Late_Not_Count" && $early_status =="Early_Count_Time") {
                                      //$emp_earlycount_time $emp_latecount_time
                                     if(strtotime($logout_time) <= strtotime($emp_earlycount_time)){
                                          if(strtotime($single_date) == strtotime($today)){
                                            print "P"; 
                                          } else{
                                            print "<span class='blue-color'>E</span>"; // for early 
                                            $remarks=$reason; 
                                            $early_counter++;      
                                          }                                       
                                      }else if(!$login_time && !$logout_time){
                                        $remarks = "Absent";
                                        print "A"; 
                                        $absent_counter++;                                       
                                      }else{
                                        $remarks = $reason;
                                        print "P";
                                      }

                                    }else if(!$login_time && !$logout_time){
                                      $attendance_log=$this->emp_attendance_model->getemp_attendance_log();
                                      $attendance_log_date=$attendance_log['attendance_date'];
                                      if(strtotime($single_date) > strtotime($attendance_log_date)){ 
                                        $remarks="";
                                        print "NC";
                                      }else{
                                        $remarks="Absent!";
                                        print "<span class='red-color'>A</span>";
                                        $absent_counter++;
                                      }
                                    }else if($login_time && !$logout_time && $logout_required=="Required" && $half_day_absent=='Eligible'){
                                     if(strtotime($single_date) == strtotime($today)){
                                            print "P"; 
                                          }else{
                                            print "<span class='red-color'>A.H</span>"; // for early
                                            $remarks = "Half Day Absent for Early";
                                            $absent_halfday_counter++;
                                          } 
                                    }else if($login_time && !$logout_time && $logout_required=="Required"){
                                      if($emp_late_found){
                                          $late_counter++; 
                                          if(strtotime($single_date) == strtotime($today)){
                                            print "<span class='blue-color'>L</span>"; // for late 
                                            $remarks="Late!";
                                          } else{
                                            print "<span class='blue-color'>L.E</span>"; // for early 
                                            $remarks="Late & Early";
                                            $early_counter++;      
                                          }                                                                           
                                      }else{
                                          if(strtotime($single_date) == strtotime($today)){
                                            print "P"; 
                                          } else{
                                            print "<span class='blue-color'>E</span>"; // for early 
                                            $remarks="Early";
                                            $early_counter++;      
                                          }                                                                              
                                        }
                                      }else if($login_time && !$logout_time && $logout_required=="Optional"){
                                      print "P"; // for early
                                    }else if($half_absent_found){ 
                                      if(strtotime($single_date) == strtotime($today)){
                                            print "P"; 
                                          }else{
                                            print "<span class='red-color'>A.H</span>";
                                            $absent_halfday_counter++;
                                          } 
                                    }else if($emp_late_found){ 
                                      if($login_time && $logout_time && $logout_required=="Required" && strtotime($logout_time) <= strtotime($emp_earlycount_time)){
                                          $late_counter++; 
                                          if(strtotime($single_date) == strtotime($today)){
                                            print "<span class='blue-color'>L</span>"; // for late 
                                            $remarks="Late!";
                                          } else{
                                            print "<span class='blue-color'>L.E</span>"; // for early 
                                            $remarks="Late & Early";
                                            $early_counter++;      
                                          }                                                                          
                                      
                                    }else{
                                      print "<span class='blue-color'>L</span>";// for late 
                                      $late_counter++;
                                      $remarks="Late";
                                      }
                                    }else if($login_time && $logout_time && $logout_required=="Required"){
                                      if(strtotime($emp_earlycount_time) >= strtotime($logout_time)){
                                          if(strtotime($single_date) == strtotime($today)){
                                            print "P"; 
                                          } else{
                                            print "<span class='blue-color'>E</span>"; // for early 
                                            $remarks="Early";
                                            $early_counter++;      
                                          }                                            
                                      }else{ 
                                        if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                          print "<span class='blue-color'>L</span>";
                                          $late_counter++;  
                                          $remarks="Late!";  
                                        }else{
                                         print "P";
                                       }
                                         //print "P";

                                     }

                                   }else{ 
                                    print "P";
                                  } 
                                  ?>
                                </td>
                                <td><?php if($remarks !='NULL'){ print $remarks;} ?></td>
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
                              if(strtotime($single_date) >= strtotime($today)){
                                break;
                              }
                              if($left_or_termineted_date){
                                if(strtotime($single_date) >= strtotime($left_or_termineted_date)){
                                  break;
                                }
                              }                              
                            }
                          } 
                          $left_or_termineted_date="";
                          ?>
                        </tbody>
                      </table> 
                      <div class="row" style="margin-top:10px;">
                        <div class="col-md-8" style="width:320px;color:#fff">.</div>
                        <div class="col-md-1" style="width:68px;border-top:2px solid #000;font-weight:bold"><?php
                         $h=floor($t3/3600);
                         $m=floor(($t3%3600)/60);
                         $s=$t3-$h*3600-$m*60;
                         echo $h.':'.$m.':'.$s; ?></div>
                         <div class="col-md-1" style="width:60px;border-top:2px solid #000;font-weight:bold;padding-left:3px;"><?php
                           $oh=floor($ot3/3600);
                           $om=floor(($ot3%3600)/60);
                           $os=$ot3-$oh*3600-$om*60;
                           echo $oh.':'.$om.':'.$os; ?></div>
                           <div class="col-md-2"></div>
                         </div>
                         <htmlpagefooter name="MyFooter1">
                         <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 12pt; 
                         color: #000000; font-weight: bold; font-style: italic;">
                         <tr style="margin-bottom:10px;">
                          <td width="66%"><span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000">Note: Total No of Late <?php print $late_counter; ?>, Early Out <?php print $early_counter; ?>, 
                     Daily Movement
                        <?php
                            echo $daily_movement;
                            if($daily_movement>0){
                                $official=$daily_movement-$daily_movement_personal;
                                echo " (Per-".$daily_movement_personal.",Offi-".$official.")";
                            }
                        ?>  and Half Day Absent <?php print $absent_halfday_counter; ?></span></td>
                          <td width="0%" align="center" style="font-weight: bold; font-style: italic;"></td>
                          <td width="33%" style="text-align: right; "><span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000;">Total Days Absent <?php print $absent_counter; ?></span></td>
                        </tr>
                        <tr>
                          <td width="95%"> <span style="font-weight: bold; font-style: italic;">P: Present; A: Absent; A.H: Half Day Absent; L: Late; E: Early; L.E : Late & Early; H: Holiday; W.H: Weekly Holiday; NC: Not Calculated;</span>
</td>
                          <td width="0%" align="center" style="font-weight: bold; font-style: italic;"></td>
                          <td width="5%" style="text-align: right; ">Page {nbpg} of {PAGENO}</td>
                        </tr>    
                      </table>
                      </htmlpagefooter>
                      <sethtmlpagefooter name="MyFooter1" value="on" />
                    </div>
                  </div>              
                </div>
              </div>
              <!-- /#page-content-wrapper -->
            </div>
            <!-- /#wrapper -->        
          </body>
          </html>