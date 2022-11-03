<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Employee Wise Yearly Leave Reports</title>
  <?php
  $this->load->view('includes/cssjs');
  date_default_timezone_set('Asia/Dhaka');
  $servertime = time();
  $today_date = date("d-m-Y", $servertime);    
  ?> 
                               <!--chosen--> 
         <link rel="stylesheet" href="<?php echo base_url();?>resources/plugins/chosenSelect/chosen.css">
  <script>
    $(document).ready(function(){  

      $( "#emp_division" ).change(function(e) {
        var division_tid = $(this).val(); 
        var base_url='<?php echo base_url();?>';
        var postData = {
          "division_tid" : division_tid
        };
        $.ajax({
          type: "POST",
          url: ""+base_url+"reports/getempbydivisionid",
          data: postData,
          dataType:'json',
          success: function(data){
                    //console.log(data);
                    var options="";
                    $(data).each(function(index, item) {
                      options += '<option value="' + item.emp_id + '">' + item.emp_name + '-' + item.emp_id + '</option>'; 
                    });
                    $('#emp_name').html(options);    
                  }
                });
      });   

      $('#emp_name').keydown(function(e) {
        if (e.ctrlKey) {
                      if (e.keyCode == 65 || e.keyCode == 97) { // 'A' or 'a'
                        $('#emp_name option').prop('selected', true);
                      e.preventDefault();
                    }
                  }
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
  if ( document.myForm.emp_name.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.emp_name.focus();
      document.myForm.emp_name.style.border="solid 1px red";
      msg+="<li>You need to fill the emp_name field!</li>";
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

</script>  
<style>
  #example td, th {
    padding: 0.30em 0.20em;
    text-align: center;
  }
  .red-color{color: red;}
  .blue-color{    color: #210EFF;
    /*background-color: #84B3D0;*/
    font-weight: bold;}
    .chosen-container.chosen-container-single {
    width: 100% !important; /* or any value that fits your needs */
}
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
      $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
      $last_day_this_month  = date('t-m-Y');
      $lastdateofattendance=end($date_range);
      $nowdate = date("d-m-Y", $servertime);
      $thisyear = date("Y", $servertime);
      $datee = date_create($lastdateofattendance);
      $nowbigmonth = date_format($datee, 'F Y');
      $nowtime = date("H:i:s a", $servertime);       
      $this -> load -> view('includes/menu');           
      ?>
      <div class="row under-header-bar text-center"> 
        <h4>Yearly Leave Reports by Multiple</h4>         
      </div> 
      <div class="wrapper">
        <div class="row">
          <div class="col-md-12">
            <form action="<?php echo base_url(); ?>reports/leavesummeryreport"  method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
              <div class="row success-err-sms-area">
                <div class="col-md-12">
                  <input type="hidden" name="attendance_id" id="attendance_id" value="<?php print $id; ?>">
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
                                    // echo '<option value="all">All</option>';
                          foreach ($alldivision as $single_division) {
                            if($emp_division==$single_division['tid']){
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
                    <div class="col-md-3 bgcolor_D8D8D8">Employee Name</div>
                    <div class="col-md-9">
                      <select name="emp_name[]" id="emp_name" size="10"  multiple >
                        <?php 
                        $default_emp_id=$default_emp['emp_id'];
                        foreach ($allemployee as $single_employee) {
                          $content_id=$single_employee['content_id'];
                          $emp_id=$single_employee['emp_id'];
                          $emp_name=$single_employee['emp_name'];
                          if($default_emp_id==$emp_id){
                            print '<option value="'.$emp_id.'" selected="selected">'.$emp_name.'-'.$emp_id.'</option>';
                          }else{
                            print '<option value="'.$emp_id.'">'.$emp_name.'-'.$emp_id.'</option>';
                          }
                        } ?>
                      </select>
                    </div>
                  </div>                                
                  <div class="row">
                    <div class="col-md-3 bgcolor_D8D8D8">Year:</div>
                    <div class="col-md-9"><input type="text" name="emp_attendance_start_date" class="datepicker numbersOnly" id="emp_attendance_start_date" value="<?php if($defaultstart_date){ print $defaultstart_date; }else{ print $first_day_this_month; } ?>" placeholder="dd-mm-yyyy"></div>
                  </div>                                                                                                                                                                                                                                                                                                              
                  <div class="row top10 bottom10">
                    <div class="col-md-3"></div>
                    <div class="col-md-9"><input type="submit" name="add_attendance_btn" value="Submit"></div>
                  </div>
                </div>
                <div class="col-md-2"></div>
              </div>
            </form>                      
          </div>
        </div> 
        <div class="row">
          <div class="col-md-12 text-right"><a target="_blank" href="<?php echo site_url("savepdf/leavesummerypdf") ; ?>"  class="operation-print-pdf operation-link"> <img src="<?php echo base_url(); ?>resources/images/pdf_icon_print.png" alt="pdf" style="width:20px;"/></a></div>
        </div>        
        <div class="emp_info">
          <div class="row">
            <div class="col-md-2">Division Name:</div>
            <div class="col-md-7"><?php print $defsultdivision_name; ?></div>
            <div class="col-md-1">Date:</div>
            <div class="col-md-2"><?php print $nowdate; ?></div>
          </div>
          <div class="row">
            <div class="col-md-2">Short Name:</div>
            <div class="col-md-7"><?php print $defsultdivision_shortname; ?></div>
            <div class="col-md-1">Time:</div>
            <div class="col-md-2"><?php print $nowtime; ?></div>
          </div>                                                
        </div>         
        <div class="row">
          <div class="col-md-12">
            <table id="example" class="display" cellspacing="0" width="100%">
              <thead>
                <tr class="heading" style="border:2px solid #000;font-size:12px;">
                  <th>SL.</th>
                  <th>Face ID</th>
                  <th>Name of Employee</th>
                  <th>Designation</th>
                  <th style="width:73px;">Joining Date</th>
                  <th>Service Length</th>
                  <th>Total Leave</th>
                  <th>Leave Spent</th>
                  <th>Leave Date</th>
                  <th>Available</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $counter=1;
                foreach ($emp_codes as $single_code) {
                  $content_id = $this->employee_id_model->getemp_idby_empcode($single_code);   
                  $single_emp=$this->search_field_emp_model->getallsearch_table_contentByid($content_id);
                  $emp_content_id=$content_id;

                  $single_code=$single_emp['emp_id'];
                  $emp_content_id=$single_emp['content_id'];
                  $emp_name=$single_emp['emp_name'];
                  $emp_division_id=$single_emp['emp_division']; 
                  $mobile_no="";
                  if($single_emp['mobile_no']){
                    $mobile_no="-".$single_emp['mobile_no']; 
                  }
                  $emp_division=$this->taxonomy->getTaxonomyBytid($emp_division_id);
                  $emp_post_id = $single_emp['emp_post_id']; 
                  $emp_post_id_data=$this->taxonomy->getTaxonomyBytid($emp_post_id);
                  $emp_designation=$emp_post_id_data['name'];
                  $emp_division_shortname = $emp_division['keywords'];
                  $emp_joining_date=$single_emp['joining_date'];
                  $today = date("d-m-Y", $servertime);
                  $grand_total_spant=0;
                  $leave_spent_date="";
                  $total_leave_spent=0;
                  $date_arr=explode("-", $default_date);
                  $year=$date_arr['2'];

                  $emp_total_leave = $this->emp_yearly_leave_history_model->getemp_yearlyleave_historybydate($emp_content_id, $default_date);                           
                  $total_leave_spent_query= $this->emp_leave_model->getemp_yearlyleavebyyear($emp_content_id, $year);
                  foreach ($total_leave_spent_query as $single_spent_leave) {
                    $total_leave_spent=$total_leave_spent+$single_spent_leave['leave_total_day'];
                    $grand_total_spant=$grand_total_spant+$single_spent_leave['leave_total_day'];
                    $leave_spent_date .="<u>".$single_spent_leave['leave_start_date']."</u>, ";
                  }
                  $available_leave=$emp_total_leave-$total_leave_spent;
                  $available_leave_grant_total=$emp_total_leave-$grand_total_spant;
                  ?>
                  <tr style="border:1px solid #000;border-bottom:none;border-left:none;border-right:none;">
                    <td><?php print $counter; ?></td>
                    <td style="text-align:left"><?php print $single_code; ?></td>
                    <td style="text-align:left"><?php print $emp_name; ?></td>
                    <td style="text-align:left"><?php print $emp_designation; ?></td>
                    <td style="text-align:left"><?php print $single_emp['joining_date']; ?></td>
                    <td style="text-align:left"><?php 
                      $joining_date_arr=explode('-',$single_emp['joining_date']);
                      $joining_date_reversed=$joining_date_arr[2]."-".$joining_date_arr[1]."-".$joining_date_arr[0]." 00:00:00";
                      $jo=strtotime($joining_date_reversed);
                      date_default_timezone_set('Asia/Dhaka');
                      $now = time();
                      $removed=timespan($jo, $now);
                      $pieces = explode(",", $removed);
                      foreach ($pieces as $key => $ll) {
                        if (strpos($ll,'Hour') !== false || strpos($ll,'Minute') !== false) {
                          unset($pieces[$key]);
                        }
                      }
                      $service_length = rtrim(implode(',', $pieces), ',');
                      echo $service_length;
                      ?></td>
                      <td><?php print $emp_total_leave; ?></td>
                      <td><?php print $grand_total_spant; ?></td>
                      <td style="width:200px"><?php print $leave_spent_date; ?></td>
                      <td><?php print $available_leave; ?></td>
                    </tr>

                    <?php 
                    $counter++;
                  } ?>  
                </tbody>
              </table>     
              <br><br><br><br>                                                                                                                 
            </div>
          </div>                                 
        </div>
      </div>
      <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->    
                         <!--Chosen--> 
        <script src="<?php echo base_url();?>resources/plugins/chosenSelect/chosen.jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>resources/plugins/chosenSelect/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
       
  </body>
  </html>