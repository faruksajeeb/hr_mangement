<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Employee Wise Daily Late Reports</title>
  <?php
  $this->load->view('includes/cssjs');
  date_default_timezone_set('Asia/Dhaka');
  $servertime = time();
  $today_date = date("d-m-Y", $servertime);    
  ?> 

  <script>
    $(document).ready(function(){ 
      $('#division_code').keyup(function(){
        var division_code=$("#division_code").val();  
        $("#emp_division option[data-id='" + division_code + "']").prop('selected', true);                   
      });  
      $('#emp_division').change(function(){
        var division_code = $("#emp_division").find('option:selected').attr("data-id"); 
        $('#division_code').val(division_code);
      });
    });


    function ConfirmDelete()
    {
      var x = confirm("Are you sure you want to delete?");
      if (x)
        return true;
      else
        return false;
    }        
    function validate() {
      var valid = true;
      var msg="<ul>";
      if ( document.myForm.emp_attendance_start_date.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.emp_attendance_start_date.focus();
      document.myForm.emp_attendance_start_date.style.border="solid 1px red";
      msg+="<li>You need to fill the emp_attendance_start_date field!</li>";
      valid = false;
      return false;
    }
  } 


  if (!valid){
    msg+="</ul>";
    //console.log("Hello Bd");
    var div = document.getElementById('errors').innerHTML=msg;
    document.getElementById("errors").style.display = 'block';
    return false;
  }

}     
function popitup(url) {
  newwindow=window.open(url,'name','height=auto,width=700px');
 // newwindow.print();
window.onfocus=function(){ newwindow.close();}
  if (window.focus) {newwindow.focus(); }
    var document_focus = false;
  $(newwindow).focus(function() { document_focus = true; });
      $(newwindow).load(function(){
    //setInterval(function() { if (document_focus === true) { newwindow.close();  document_focus = false;}  }, 7000);
   
});
  return false;
}
</script>  

<style>
  #example td, th {
    padding: 0.30em 0.20em;
    text-align: left;
  }
  .red-color{color: red;}
  .blue-color{    color: #210EFF;
    /*background-color: #84B3D0;*/
    font-weight: bold;}

  </style>  
</head>
<body class="logged-in dashboard current-page add-attendance">
  <!-- Page Content -->  
  <div id="page-content-wrapper">
    <div class="container-fluid">
      <?php 
      date_default_timezone_set('Asia/Dhaka');
      $servertime = time();
      $now = date("d-m-Y H:i:s", $servertime);
      $this -> load -> view('includes/menu');
            $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
            $last_day_this_month  = date('t-m-Y');
            $today = date("d-m-Y", $servertime);
            ?>
            <div class="row under-header-bar text-center"> 
              <h4>Daily Late Reports</h4>         
            </div> 
            <div class="wrapper">
              <div class="row">
                <div class="col-md-12">
                  <form action="<?php echo base_url(); ?>reports/dailyabsentreports" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                    <div class="row success-err-sms-area">
                      <div class="col-md-12">
                        <!-- <input type="hidden" name="attendance_id" id="attendance_id" value="<?php print $id; ?>"> -->
                        <div id="errors"></div>
                        <?php 
                          print $this->session->flashdata('errors'); 
                          print $this->session->flashdata('success'); 
                        ?>
                      </div>
                    </div>
                    <div class="row"> 
                      <div class="col-md-2"></div>
                      <div class="col-md-8">
                        <div class="row">
                          <div class="col-md-3 bgcolor_D8D8D8">Division</div>
                          <div class="col-md-9">
                            <select name="emp_division" id="emp_division">
                                  <?php 
                                   if($user_type_id !=1){
                                    echo '<option value="'.$alldivision['tid'].'" selected="selected" data-id="'.$alldivision['weight'].'">'.$alldivision['name'].'</option>';
                                   }else{
                                    echo '<option value="all">All</option>';
                                    foreach ($alldivision as $single_division) {
                                      if($defaultdivision_id==$single_division['tid']){
                                        echo '<option value="'.$single_division['tid'].'" selected="selected" data-id="'.$single_division['weight'].'">'.$single_division['name'].'</option>';
                                      }else{
                                        echo '<option value="'.$single_division['tid'].'" data-id="'.$single_division['weight'].'">'.$single_division['name'].'</option>';
                                      }
                                    } 
                                  }
                                  ?>                            
                            </select>         
                          </div>
                        </div>                                                       
                        <div class="row">
                          <div class="col-md-3 bgcolor_D8D8D8">Division Code</div>
                          <div class="col-md-9"><input type="text" name="division_code" id="division_code" placeholder="Write Division Code" autocomplete="off" value="<?php if($default_emp['emp_id']){ echo $default_division['emp_id'];} ?>"/></div>
                        </div>
                        <div class="row">
                          <div class="col-md-3 bgcolor_D8D8D8">Attendance Date:</div>
                          <div class="col-md-9"><input type="text" name="emp_attendance_start_date" class="datepicker numbersOnly" id="emp_attendance_start_date" value="<?php if($default_date){ print $default_date; }else{ print $today; } ?>" placeholder="dd-mm-yyyy"></div>
                        </div> 
                        <div class="row top10 bottom10">
                          <div class="col-md-3"></div>
                          <div class="col-md-9"><input type="submit" name="add_attendance_btn" value="Submit"></div>
                        </div>
                      </div>
                      <div class="col-md-2"></div>
                    </div>
                  </form>
                  <div class="row">
                    <div class="col-md-12 text-right"><a onclick="return popitup('<?php echo site_url("savepdf/dailyabsentreportspdf") ; ?>')" href="<?php echo site_url("savepdf/dailyabsentreportspdf") ; ?>" class="operation-print-pdf operation-link"> <img src="<?php echo base_url(); ?>resources/images/pdf_icon_print.png" alt="pdf" style="width:20px;"/></a></div>
                  </div>
                  <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
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
                      $attendance_required = $emp_shift_time['attendance_required'];
                      $work_starting_time = $emp_shift_time['work_starting_time'];
                      $work_ending_time = $emp_shift_time['work_ending_time'];
                      $logout_required = $emp_shift_time['logout_required'];
                      $emp_latecount_time = $emp_shift_time['emp_latecount_time'];
                      $emp_earlycount_time = $emp_shift_time['emp_earlycount_time'];
                      $half_day_absent = $emp_shift_time['half_day_absent'];
                      $absent_count_time = $emp_shift_time['absent_count_time'];
                      $overtime_count = $emp_shift_time['overtime_count'];
                      $division_id_emp = $emp_details_info['emp_division'];
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
                                     // print "H";
                                    }else if($remarks=='leave_without_pay'){ 
                                      $remarks = "Leave without pay";
                                     // print "<span class='red-color'>A</span>";
                                      $absent_print="A";
                                      $absent_counter++;
                                    }else if($remarks=='Leave'){ 
                                     // print "A.L";
                                      $remarks=$leave_reason;
                                    }else if($remarks=='Half Day Leave'){ 
                                     // print "L.H";
                                      $remarks=$leave_reason;
                                    } else if($attendance_required=='Not_Required'){ 
                                      //print "N";//
                                      $remarks="Not Required";
                                    }else if($presence_status_informed){
                                      //print $presence_status_informed;
                                      $remarks=$informed_remarks;
                                        if($presence_status=='A'){
                                         // print "<span class='red-color'>A</span>";
                                          $absent_print="A";
                                          $absent_counter++; 
                                          $remarks = $informed_remarks; 
                                        }else if($presence_status=='P'){
                                         // print "P";
                                          $remarks = $informed_remarks; 
                                        }else if($presence_status=='A.H'){ 
                                        //  print "<span class='red-color'>A.H</span>";
                                          $remarks = $informed_remarks;
                                          $absent_halfday_counter++;
                                        }else if($presence_status=='L'){ 
                                        // print "<span class='blue-color'>L</span>";
                                          //$late_print="L";
                                         $remarks = $informed_remarks; 
                                         $late_counter++;
                                       }else if($presence_status_informed=='L'){
                                            $late_counter++;
                                            $remarks="Late";
                                            //$late_print="L";
                                        }   
                                    }else if($presence_status=='A'){
                                      //print "<span class='red-color'>A</span>";
                                      $absent_print="A";
                                        $absent_counter++; 
                                      $remarks = $informed_remarks; 
                                    }else if($presence_status=='P'){
                                     // print "P";
                                      $remarks = $emp_atten_info['remarks']; 
                                    }else if($presence_status=='A.H'){ 
                                     // print "<span class='red-color'>A.H</span>";
                                      $remarks = $emp_atten_info['remarks'];
                                      $absent_halfday_counter++;
                                    }else if($presence_status=='L'){ 
                                     //print "<span class='blue-color'>L</span>";
                                      //$late_print="L";
                                     $remarks = $emp_atten_info['remarks']; 
                                     $late_counter++;
                                   }else if ($late_status =="Late_Not_Count" && $early_status =="Early_Not_Count"){
                                   // print "P";
                                    //$remarks = $reason; 
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
                                       // print "<span class='blue-color'>L.E</span>"; // for early
                                      //$late_print="L";
                                        $late_counter++;  
                                        if(strtotime($default_date) == strtotime($today)){
                                            $remarks="Late";
                                          } else{
                                            $remarks="Late & Early";
                                             $early_counter++; 
                                          }
                                      }else if($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)){
                                       // print "<span class='blue-color'>L</span>"; // for Late
                                        //$late_print="L";
                                        $late_counter++;  
                                        $remarks="Late"; 
                                      }else if($logout_time && strtotime($logout_time) <= strtotime($emp_earlycount_time)){
                                          if(strtotime($default_date) == strtotime($today)){
                                           // print "p";
                                          } else{
                                           // print "<span class='blue-color'>E</span>"; // for early
                                             $early_counter++; 
                                             $remarks=$reason; 
                                          }                                        
                                        
                                      }else if(!$login_time && !$logout_time){
                                        $remarks = "Absent";
                                        //print "<span class='red-color'>A</span>";
                                        $absent_print="A";
                                        $absent_counter++;                                       
                                      }else{
                                        $remarks = $reason;
                                       // print "P";
                                      }

                                    }else if ($late_status =="Late_Count_Time" && $early_status =="Early_Not_Count") {
                                      //$emp_earlycount_time $emp_latecount_time
                                      if($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)){ 
                                       // print "<span class='blue-color'>L</span>"; // for Late
                                        //$late_print="L";
                                        $late_counter++;  
                                        $remarks=$reason;
                                      }else if(!$login_time && !$logout_time){
                                        $remarks = "Absent";
                                       // print "<span class='red-color'>A</span>";
                                        $absent_counter++;  
                                        $absent_print="A";                                     
                                      }else{
                                        $remarks = $reason;
                                        //print "P";
                                      }

                                    }else if ($late_status =="Late_Not_Count" && $early_status =="Early_Count_Time") {
                                      //$emp_earlycount_time $emp_latecount_time
                                     if(strtotime($logout_time) <= strtotime($emp_earlycount_time)){
                                          if(strtotime($default_date) == strtotime($today)){
                                            //print "p";
                                          } else{
                                           // print "<span class='blue-color'>E</span>"; // for early
                                             $early_counter++; 
                                             $remarks=$reason; 
                                          }                                        
                                      }else if(!$login_time && !$logout_time){
                                        $remarks = "Absent";
                                        //print "<span class='red-color'>A</span>";
                                        $absent_counter++;  
                                        $absent_print="A";                                     
                                      }else{
                                        $remarks = $reason;
                                       // print "P";
                                      }

                                    }else if(!$login_time && !$logout_time){
                                      $attendance_log=$this->emp_attendance_model->getemp_attendance_log();
                                      $attendance_log_date=$attendance_log['attendance_date'];
                                      if(strtotime($single_date) > strtotime($attendance_log_date)){ 
                                        $remarks="";
                                        //print "NC";
                                      }else{
                                        $remarks="Absent!";
                                       // print "<span class='red-color'>A</span>";
                                        $absent_counter++;
                                        $absent_print="A";
                                      }
                                    }else if($login_time && !$logout_time && $logout_required=="Required" && $half_day_absent=='Eligible'){
                                     // print "<span class='red-color'>A.H</span>"; // for early
                                      $remarks = "Half Day Absent for Early";
                                      $absent_halfday_counter++;
                                    }else if($login_time && !$logout_time && $logout_required=="Required"){
                                      if($emp_late_found){
                                        //$late_print="L";
                                        $late_counter++;  
                                          if(strtotime($default_date) == strtotime($today)){
                                            //print "<span class='blue-color'>L</span>"; 
                                            $remarks="Late!";
                                          } else{
                                          //  print "<span class='blue-color'>L.E</span>"; // for early
                                            $remarks="Late & Early";
                                            $early_counter++;   
                                          }                                         
                                                                           
                                      }else{
                                        if(strtotime($default_date) == strtotime($today)){
                                           // print "p";
                                          } else{
                                            // print "<span class='blue-color'>E</span>"; // for early
                                            $remarks="Early";
                                            $early_counter++;      
                                          }  
                                                                          
                                        }

                                      }else if($login_time && !$logout_time && $logout_required=="Optional"){
                                     // print "P"; // for early

                                    }else if($half_absent_found){ 
                                     // print "<span class='red-color'>A.H</span>";
                                      $absent_halfday_counter++;
                                    }else if($emp_late_found){ 
                                      //print "<span class='blue-color'>L</span>";
                                      //$late_print="L";
                                      $late_counter++;
                                      $remarks="Late";
                                    }else if($login_time && $logout_time && $logout_required=="Required"){
                                      if(strtotime($emp_earlycount_time) >= strtotime($logout_time)){
                                        if(strtotime($default_date) == strtotime($today)){
                                            //print "p";
                                          } else{
                                            // print "<span class='blue-color'>E</span>"; // for early
                                            $remarks="Early";
                                            $early_counter++;      
                                          }                                          
                                      }else{ 
                                        if ($login_time && strtotime($login_time) >= strtotime($emp_latecount_time)) {
                                         // print "<span class='blue-color'>L</span>";
                                          //$late_print="L";
                                          $late_counter++;    
                                          $remarks="Late";
                                        }else{
                                        // print "P";
                                       }
                                     }

                                   }else{ 
                                    //print "P";
                                  }               
                                  
                                  if($absent_print=="A"){                                        
                                            ?>
                                            <tr>
                                              <td><?php print $default_date; ?></td>
                                              <td><?php print $emp_code; ?></td>
                                              <td><?php print $emp_name."".$mobile_no; ?></td>
                                              <td><?php print $login_time; ?></td>
                                              <td><?php print $logout_time; ?></td>
                                              <td><?php print $emp_division_shortname; ?></td>
                                                <td><?php 
                                                print "<span class='red-color'>A</span>";
                                  ?>
                                </td>
                                <td><?php if($remarks !='NULL'){ print $remarks;} ?></td>
                              </tr>
                              <?php 
                            }
                            $absent_print="";
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
                        <br>
                        <br>
                        <br>
                        <br>
                        <htmlpagefooter name="MyFooter1">
                        <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; 
                        color: #000000; font-weight: bold; font-style: italic;">
                        <tr style="margin-bottom:10px;background: #40618C;color: #fff;font-size: 17px;">
                          <td width="53%"><span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000">Total Employee <?php print $total_emp; ?>; </span></td>
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
                      <br>                        
                    </div>
                  </div>              
                </div>
              </div>
              <!-- /#page-content-wrapper -->
            </div>
            <!-- /#wrapper -->        
          </body>
          </html>