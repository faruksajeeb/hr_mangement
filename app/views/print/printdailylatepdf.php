<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Late Reports</title>
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
    text-align: left;
  }
</style>
<style  type="text/css" media="print">
  @page 
  {
    size: auto;   
    margin-bottom: 50px; 
    margin-left: 24px; 
    margin-top: 35px; 
    margin-right: 35px; 
    margin-footer: 20mm;
  }
  body 
  {
    font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; 
    color: #000;
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
      $now = date("d-m-Y H:i:s", $servertime);
            $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
            $last_day_this_month  = date('t-m-Y');
            $today = date("d-m-Y", $servertime);
            $nowdate = date("d-m-Y", $servertime);
            $nowbigmonth = date_format($default_date, 'F Y');
            $nowtime = date("H:i:s a", $servertime);
            $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
            $last_day_this_month  = date('t-m-Y');

            ?>
            <div class="row" style="font-weight:normal">
              <div class="col-md-10" style="width:595px;">
                <h1 style="font-size:25px;font-weight:bold">IIDFC Securities Limited</h1>
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
              <h1 style="font-size:20px;font-weight:bold">Employee Daily Late Reports<br>Log Date:<?php print $default_date; ?></h1>         
            </div> 
            <div class="row">
              <div class="col-md-1" style="width:110px;">Division Name:</div>
              <div class="col-md-9" style="width:420px;"><?php print $defsultdivision_name; ?></div>
              <div class="col-md-1" style="width:35px;">Date:</div>
              <div class="col-md-1" style="width:78px;"><?php print $nowdate; ?></div>
            </div>
            <div class="row">
              <div class="col-md-1"  style="width:110px;">Short Name:</div>
              <div class="col-md-9" style="width:420px;"><?php print $defsultdivision_shortname; ?></div>
              <div class="col-md-1" style="width:35px;">Time:</div>
              <div class="col-md-1" style="width:78px;"><?php print $nowtime; ?></div>
            </div>        
            <div class="wrapper">
              <div class="row">
                <div class="col-md-12">
                  <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                      <tr class="heading" style="border:2px solid #000;font-size:12px;">
                        <tr class="heading">
                          <th>Log Date</th>
                          <th>Emp. Code</th>
                          <th>Emp Name</th>
                          <th>Time In</th>
                          <th>Time Out</th>
                          <th>Department</th>
                          <th>Att</th>
                          <th>Remarks</th>
                        </tr>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $late_counter=0;
                      $early_counter=0;
                      $absent_counter=0;
                      $absent_halfday_counter=0;
                      $half_day_absent_status="";
                      $early_status="";
                      $late_status="";
                      $total_emp=count($default_employee);
                      foreach ($default_employee as $single_emp) {
                        if(strtotime($default_date) > strtotime($today)){
                          break;
                        }                          
                        $emp_content_id=$single_emp['content_id'];
                        $emp_shift_time =$this->emp_working_time_model->getworkingtimeBydateandid($emp_content_id, $default_date);
                    $division_id_emp = $emp_details_info['emp_division'];

                        $attendance_required = $emp_shift_time['attendance_required'];
                        $work_starting_time = $emp_shift_time['work_starting_time'];
                        $work_ending_time = $emp_shift_time['work_ending_time'];
                        $logout_required = $emp_shift_time['logout_required'];
                        $emp_latecount_time = $emp_shift_time['emp_latecount_time'];
                        $emp_earlycount_time = $emp_shift_time['emp_earlycount_time'];
                        $half_day_absent = $emp_shift_time['half_day_absent'];
                        $absent_count_time = $emp_shift_time['absent_count_time'];
                        $overtime_count = $emp_shift_time['overtime_count'];
                        $tstamp1 = strtotime($default_date);
                        $dated_day_name1 = date("D", $tstamp1);
                        $dated_day_name1 = strtolower($dated_day_name1);
                        if($division_id_emp==301 && $dated_day_name1 =='thu'){
                          $work_ending_time = "16:00:00";
                          $emp_earlycount_time = "16:00:00";
                        }                      
                        $emp_details=$this->search_field_emp_model->getallsearch_table_contentByid($emp_content_id); 
                        $emp_code=$emp_details['emp_id'];
                        $emp_name=$emp_details['emp_name'];
                        $mobile_no="";
                        if($emp_details['mobile_no']){
                          $mobile_no="-".$emp_details['mobile_no'];
                        }
                        $emp_division=$this->taxonomy->getTaxonomyBytid($emp_details['emp_division']);
                        $emp_division_shortname = $emp_division['keywords'];                        
                        $has_log_attendance_error = $this->log_maintenence_model->getlogbyemployee($emp_content_id, $default_date);
                        if(!$has_log_attendance_error){
                          $division_id_emp = $emp_details_info['emp_division'];
                          $has_log_attendance_error = $this->log_maintenence_model->getlogbydivision($division_id_emp, $default_date);
                        }                         
                        $division = "all";
                        if(!$has_log_attendance_error){
                          $has_log_attendance_error = $this->log_maintenence_model->getlogbydivision($division, $default_date);
                        }    
                        if($has_log_attendance_error){
                          $late_status=$has_log_attendance_error['late_status'];
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
                       $emp_atten_info = $this->emp_attendance_model->getemp_dailyattendance($emp_content_id, $default_date);
                       $emp_informed_info = $this->emp_informed_model->getemp_informed($emp_content_id, $default_date);

                       $holiday_exist = $this->emp_holiday_model->getemp_yearlyholiday($division, $default_date);
                       if (!$holiday_exist) {
                        $division = $emp_details_info['emp_division'];
                        $holiday_exist = $this->emp_holiday_model->getemp_yearlyholiday($division, $default_date);
                      }

                      if ($holiday_exist) {
                        $holiday_type_tid = $holiday_exist['holiday_type'];
                        $holiday_name_info = $this->taxonomy->getTaxonomyBytid($holiday_type_tid);
                                            $holiday_name = $holiday_name_info['name']; // this will be printed
                                            $remarks = $holiday_name_info['name'];
                                            $login_time = $emp_atten_info['login_time'];
                                            $logout_time = $emp_atten_info['logout_time'];                                              
                                          } else {
                                            $tstamp = strtotime($default_date);
                                            $dated_day_name = date("D", $tstamp);
                                            $dated_day_name = strtolower($dated_day_name);
                                            $offday_exist =$this->emp_weeklyholiday_history_model->getemp_weeklyholiday_historybydate($emp_content_id, $default_date);
                                            //$offday_exist = $this->emp_holiday_model->getemp_holiday($emp_content_id);
                                            if ($offday_exist['' . $dated_day_name . '_off'] == 'off') {
                                              $weekly_holiday = "Weekly Holiday";
                                              $remarks = "Weekly Holiday";
                                              $login_time = $emp_atten_info['login_time'];
                                              $logout_time = $emp_atten_info['logout_time'];                                                  
                                            }

                                            if ($offday_exist['' . $dated_day_name . '_off'] != 'off') {
                                              $leave_exist = $this->emp_leave_model->getemp_leave($emp_content_id, $default_date);
                                              if ($leave_exist) {
                                                $leave_type=$leave_exist['leave_type'];
                                                $leave_reason=$leave_exist['justification'];
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
                                                $presence_status = $emp_atten_info['presence_status'];
                                                $presence_status_informed = $emp_informed_info['presence_status'];
                                                $informed_remarks = $emp_informed_info['remarks'];
                                                $login_time = $emp_atten_info['login_time'];
                                                $logout_time = $emp_atten_info['logout_time'];   
                                                if ($half_day_absent == 'Eligible') {
                                                      if($half_day_absent_status=='Half_Day_Absent_Not_Count'){ // problem day
                                                        $remarks = $reason;
                                                      }else if ($login_time && strtotime($login_time) > strtotime($absent_count_time)) {
                                                        if(!$logout_time){
                                                          $half_absent_found = "Half Day Absent";
                                                          $remarks = "Half Day Absent";
                                                        }else if(strtotime($emp_earlycount_time) > strtotime($logout_time)){
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
                                            $tstamp = strtotime($default_date);
                                            $dated_day_name = date("D", $tstamp);
                                            $dated_day_name = strtolower($dated_day_name);
                                            if($offday_exist['' . $dated_day_name . '_off']=="off"){ 
                                              $remarks="Weekly Holiday";
                                            }

                                            if($holiday_name){ 
                                      //print "H";
                                            }else if($offday_exist['' . $dated_day_name . '_off']=="off"){ 
                                      //print "H";
                                            }else if($remarks=='leave_without_pay'){ 
                                              $remarks = "Leave without pay";
                                      //print "<span class='red-color'>A</span>";
                                              $absent_counter++;
                                            }else if($remarks=='Leave'){ 
                                      //print "A.L";
                                              $remarks=$leave_reason;
                                            }else if($remarks=='Half Day Leave'){ 
                                      //print "L.H";
                                              $remarks=$leave_reason;
                                            } else if($attendance_required=='Not_Required'){ 
                                      //print "N";//
                                              $remarks="Not Required";
                                            }else if($presence_status_informed){
                                      ////print $presence_status_informed;
                                              $remarks=$informed_remarks;
                                              if($presence_status=='A'){
                                          //print "<span class='red-color'>A</span>";
                                                $absent_counter++; 
                                                $remarks = $informed_remarks; 
                                              }else if($presence_status=='P'){
                                          //print "P";
                                                $remarks = $informed_remarks; 
                                              }else if($presence_status=='A.H'){ 
                                          //print "<span class='red-color'>A.H</span>";
                                                $remarks = $informed_remarks;
                                                $absent_halfday_counter++;
                                              }else if($presence_status=='L'){ 
                                         //print "<span class='blue-color'>L</span>";
                                               $remarks = $informed_remarks; 
                                               $late_print="L";
                                               $late_counter++;
                                             }else if($presence_status_informed=='L'){
                                              $late_print="L";
                                              $late_counter++;
                                              $remarks="Late";
                                            }   
                                          }else if($presence_status=='A'){
                                      //print "<span class='red-color'>A</span>";
                                            $absent_counter++; 
                                            $remarks = $informed_remarks; 
                                          }else if($presence_status=='P'){
                                      //print "P";
                                            $remarks = $emp_atten_info['remarks']; 
                                          }else if($presence_status=='A.H'){ 
                                      //print "<span class='red-color'>A.H</span>";
                                            $remarks = $emp_atten_info['remarks'];
                                            $absent_halfday_counter++;
                                          }else if($presence_status=='L'){ 
                                     //print "<span class='blue-color'>L</span>";
                                           $remarks = $emp_atten_info['remarks']; 
                                           $late_print="L";
                                           $late_counter++;
                                         }else if ($late_status =="Late_Not_Count" && $early_status =="Early_Not_Count"){
                                    //print "P";
                                         // $remarks = $reason; 
                                          if($presence_status_has_no_log=="A" && !$login_time && !$logout_time){
                                            $remarks = "Absent";
                                           // print "<span class='red-color'>A</span>";
                                            $absent_counter++; 
                                          }else if($presence_status_has_no_log=="P"){
                                            //print "P";
                                            $remarks = $reason;
                                          }else{
                                            //print "P";
                                            $remarks = $reason;
                                          }                                          
                                        }else if ($late_status =="Late_Count_Time" && $early_status =="Early_Count_Time") {
                                      //$emp_earlycount_time $emp_latecount_time
                                          if($login_time && $logout_time && strtotime($login_time) >= strtotime($emp_latecount_time) && strtotime($logout_time) <= strtotime($emp_earlycount_time)){ 
                                            $late_print="L";
                                            $late_counter++;                                         
                                            if(strtotime($default_date) == strtotime($today)){
                                            //print "<span class='blue-color'>L</span>"; // for Late
                                              $remarks="Late!";
                                            } else{
                                             //print "<span class='blue-color'>L.E</span>"; // for early
                                              $remarks="Late & Early";
                                              $early_counter++;        
                                            }                                       
                                          }else if($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)){
                                        //print "<span class='blue-color'>L</span>"; // for Late
                                            $late_print="L";
                                            $late_counter++;  
                                            $remarks="Late"; 
                                          }else if($logout_time && strtotime($logout_time) <= strtotime($emp_earlycount_time)){
                                            if(strtotime($default_date) == strtotime($today)){
                                            //print "P"; 
                                            } else{
                                             //print "<span class='blue-color'>E</span>"; // for early
                                              $remarks=$reason;
                                              $early_counter++;        
                                            }                                         

                                          }else if(!$login_time && !$logout_time){
                                            $remarks = "Absent";
                                        //print "<span class='red-color'>A</span>";
                                            $absent_counter++;                                       
                                          }else{
                                            $remarks = $reason;
                                        //print "P";
                                          }

                                        }else if ($late_status =="Late_Count_Time" && $early_status =="Early_Not_Count") {
                                      //$emp_earlycount_time $emp_latecount_time
                                          if($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)){ 
                                        //print "<span class='blue-color'>L</span>"; // for Late
                                            $late_print="L";
                                            $late_counter++;  
                                            $remarks=$reason;
                                          }else if(!$login_time && !$logout_time){
                                            $remarks = "Absent";
                                        //print "<span class='red-color'>A</span>";
                                            $absent_counter++;                                       
                                          }else{
                                            $remarks = $reason;
                                        //print "P";
                                          }

                                        }else if ($late_status =="Late_Not_Count" && $early_status =="Early_Count_Time") {
                                      //$emp_earlycount_time $emp_latecount_time
                                         if(strtotime($logout_time) <= strtotime($emp_earlycount_time)){
                                          if(strtotime($default_date) == strtotime($today)){
                                            //print "P"; 
                                          } else{
                                             //print "<span class='blue-color'>E</span>"; // for early
                                            $remarks=$reason;
                                            $early_counter++;        
                                          }                                       
                                        }else if(!$login_time && !$logout_time){
                                          $remarks = "Absent";
                                        //print "<span class='red-color'>A</span>";
                                          $absent_counter++;                                       
                                        }else{
                                          $remarks = $reason;
                                        //print "P";
                                        }

                                      }else if(!$login_time && !$logout_time){
                                        $attendance_log=$this->emp_attendance_model->getemp_attendance_log();
                                        $attendance_log_date=$attendance_log['attendance_date'];
                                        if(strtotime($single_date) > strtotime($attendance_log_date)){ 
                                          $remarks="";
                                        //print "NC";
                                        }else{
                                          $remarks="Absent!";
                                        //print "<span class='red-color'>A</span>";
                                          $absent_counter++;
                                        }
                                      }else if($login_time && !$logout_time && $logout_required=="Required" && $half_day_absent=='Eligible'){
                                      //print "<span class='red-color'>A.H</span>"; // for early
                                        $remarks = "Half Day Absent for Early";
                                        $absent_halfday_counter++;
                                      }else if($login_time && !$logout_time && $logout_required=="Required"){
                                        if($emp_late_found){
                                          $late_print="L";
                                          $late_counter++;  
                                          if(strtotime($default_date) == strtotime($today)){
                                            //print "<span class='blue-color'>L</span>"; // for late
                                            $remarks="Late!";
                                          } else{
                                             //print "<span class='blue-color'>L.E</span>"; // for early
                                            $remarks="Late & Early";
                                            $early_counter++;       
                                          }                                                                            
                                        }else{
                                          if(strtotime($default_date) == strtotime($today)){
                                            //print "P";
                                          } else{
                                            //print "<span class='blue-color'>E</span>"; // for early
                                            $remarks="Early";
                                            $early_counter++;        
                                          }                                                                             
                                        }

                                      }else if($login_time && !$logout_time && $logout_required=="Optional"){
                                      //print "P"; 

                                      }else if($half_absent_found){ 
                                      //print "<span class='red-color'>A.H</span>";
                                        $absent_halfday_counter++;
                                      }else if($emp_late_found){ 
                                      if($login_time && $logout_time && $logout_required=="Required" && strtotime($logout_time) <= strtotime($emp_earlycount_time)){
                                          $late_counter++; 
                                          if(strtotime($single_date) == strtotime($today)){
                                           // print "<span class='blue-color'>L</span>"; // for late 
                                            $remarks="Late!";
                                            $late_print="L";
                                          } else{
                                           // print "<span class='blue-color'>L.E</span>"; // for early 
                                            $remarks="Late & Early";
                                            $late_print="L";
                                            $early_counter++;      
                                          }                                                                          
                                      
                                    }else{
                                     // print "<span class='blue-color'>L</span>";// for late 
                                      $late_counter++;
                                      $late_print="L";
                                      $remarks="Late";
                                      }

                                      }else if($login_time && $logout_time && $logout_required=="Required"){
                                        if(strtotime($emp_earlycount_time) >= strtotime($logout_time)){
                                          if(strtotime($default_date) == strtotime($today)){
                                            //print "P";
                                          } else{
                                            //print "<span class='blue-color'>E</span>"; // for early
                                            $remarks="Early";
                                            $early_counter++;        
                                          }                                         
                                        }else{ 
                                          if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                          //print "<span class='blue-color'>L</span>";
                                            $late_print="L";
                                            $late_counter++;    
                                            $remarks="Late";
                                          }else{
                                         //print "P";
                                          }
                                        }

                                      }else{ 
                                    //print "P";
                                      }       
                                      if($late_print=="L"){                                          
                                        ?>
                                        <tr style="border:1px solid #000;border-bottom:none;border-left:none;border-right:none;">
                                         <td><?php print $default_date; ?></td>
                                         <td><?php print $emp_code; ?></td>
                                         <td><?php print $emp_name."".$mobile_no; ?></td>
                                         <td><?php print $login_time; ?></td>
                                         <td><?php print $logout_time; ?></td>
                                         <td><?php print $emp_division_shortname; ?></td>
                                         <td><?php 
                                          if($remarks=="Late & Early"){
                                            print "L.E";
                                          }else{
                                            print "L";
                                          }
                                          ?>
                                        </td>
                                        <td><?php if($remarks !='NULL'){ print $remarks;} ?></td>
                                      </tr>
                                      <?php 
                                    }
                                    $late_print="";
                                    $login_time="";
                                    $logout_time="";
                                    $holiday_name="";
                                    $weekly_holiday="";
                                    $remarks="";
                                    $reason="";
                                    $half_absent_found="";
                                    $emp_late_found="";
                                    $late_status="";
                                    $early_status="";                  
                                  } ?>
                                </tbody>
                              </table> 
                              <htmlpagefooter name="MyFooter1">
                              <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 12pt; 
                              color: #000000; font-weight: bold; font-style: italic;">
                              <tr style="margin-bottom:10px;">
                                <td width="53%"><span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000">Total No of Late <?php print $late_counter; ?></span></td>
                                <td width="13%" align="center" style="font-weight: bold; font-style: italic;"></td>
                                <td width="33%" style="text-align: right; "></td>
                              </tr>
                              <tr>
                                <td width="95%"><span style="font-weight: bold; font-style: italic;">P: Present; A : Absent; A.H: Half Day Absent; L: Late; H: Holiday; NC: Not Calculated;</span></td>
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