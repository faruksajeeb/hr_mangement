<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Employee Wise Monthly Attendance Reports</title>
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
                  $month_ini = new DateTime("first day of last month");
$month_end = new DateTime("last day of last month");
            $first_day_this_month = $month_ini->format('d-m-Y'); // 2012-02-01 
            $last_day_this_month  = $month_end->format('d-m-Y'); 
            $today = date("d-m-Y", $servertime);
            ?>
            <div class="row under-header-bar text-center"> 
            <h4>Monthly Attendance Summery Reports New</h4>         
            </div> 
            <div class="wrapper">
              <div class="row">
                <div class="col-md-12">
                  <form action="<?php echo base_url(); ?>attendance_pdf/monthly_attendance_reports_summery_pdf" target="_blank" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
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
                          <div class="col-md-3 bgcolor_D8D8D8">Start Date:</div>
                          <div class="col-md-9"><input type="text" name="emp_attendance_start_date" class="datepicker numbersOnly" id="emp_attendance_start_date" value="<?php  print $first_day_this_month;  ?>" placeholder="dd-mm-yyyy"></div>
                        </div> 
                        <div class="row">
                          <div class="col-md-3 bgcolor_D8D8D8">End Date:</div>
                          <div class="col-md-9"><input type="text" name="emp_attendance_end_date" class="datepicker numbersOnly" id="emp_attendance_end_date" value="<?php  print $last_day_this_month;  ?>" placeholder="dd-mm-yyyy"></div>
                        </div>  
                        <div class="row top10 bottom10">
                          <div class="col-md-3"></div>
                          <div class="col-md-9"><input type="submit" name="add_attendance_btn" value="Submit"></div>
                        </div>
                      </div>
                      <div class="col-md-2"></div>
                    </div>
                  </form>
                  <br>
                  <br>
                  <br>
                  <br>
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