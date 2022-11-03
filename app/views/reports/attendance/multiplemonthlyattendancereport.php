<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HRMS || Multiple Attendance Report </title>
  <?php
  $this->load->view('includes/cssjs');
  date_default_timezone_set('Asia/Dhaka');
  $servertime = time();
  $today_date = date("d-m-Y", $servertime);    
  ?> 

  <script>
    $(document).ready(function(){
                $( "#emp_division" ).change(function(e) {
                  var division_tid = $(this).val(); 
                  var base_url='<?php echo base_url(); ?>';
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
        <h4>Monthly Attendance Reports by Multiple</h4>         
      </div> 
      <div class="wrapper">
        <div class="row">
          <div class="col-md-12">
            <form action="<?php echo base_url(); ?>savepdf/multipleattendancereportspdf"  target="_blank" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
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
                              <div class="col-md-3 bgcolor_D8D8D8">Company: </div>
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
                    <div class="col-md-3 bgcolor_D8D8D8">Name</div>
                    <div class="col-md-9">
                      <select name="emp_name[]" id="emp_name" size="10" multiple="" autocomplete="off">
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
                    <div class="col-md-3 bgcolor_D8D8D8">Start Date:</div>
                    <div class="col-md-9"><input type="text" name="emp_attendance_start_date" class="datepicker numbersOnly" id="emp_attendance_start_date" value="<?php if($defaultstart_date){ print $defaultstart_date; }else{ print $first_day_this_month; } ?>" placeholder="dd-mm-yyyy"></div>
                  </div> 
                  <div class="row">
                    <div class="col-md-3 bgcolor_D8D8D8">End Date:</div>
                    <div class="col-md-9"><input type="text" name="emp_attendance_end_date" class="datepicker numbersOnly" id="emp_attendance_end_date" value="<?php if($defaultend_date){ print $defaultend_date; }else{ print $last_day_this_month; } ?>" placeholder="dd-mm-yyyy"></div>
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
                </div>
              </div>
              <!-- /#page-content-wrapper -->
            </div>
            <!-- /#wrapper -->        
          </body>
          </html>