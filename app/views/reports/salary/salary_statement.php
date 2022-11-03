<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Salary Statement</title>
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
   
       /*
      $('#emp_division').change(function(){
        var division_code = $("#emp_division").find('option:selected').attr("data-id"); 
        $('#division_code').val(division_code);
      });
      */
      $("input[type=submit]").attr("disabled", "disabled");
      $( "#emp_division" ).change(function(e) {
          $("input[type=submit]").removeAttr("disabled");
    var division_tid = $(this).val(); 
    var base_url='<?php echo base_url();?>';
    var postData = {
        "division_tid" : division_tid
    };
    $.ajax({
        type: "POST",
        url: ""+base_url+"addprofile/getdepartmentidbydivisionid",
        data: postData,
        dataType:'json',
        success: function(data){
    // console.log(data);
    var options="";
    options += '<option value="">All</option>';
    $(data).each(function(index, item) {
        options += '<option value="' + item.tid + '">' + item.name + '</option>'; 
    });
    $('#emp_department').html(options);    
}
});
});
    });


          
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
  .label{
      font-size:17px;
      color:#000;
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
            <h4>Salary Statement Reports</h4>         
            </div> 
            <div class="wrapper">
              <div class="row">
                <div class="col-md-12">
                  <form action="<?php echo base_url(); ?>savepdf/monthlySalaryStatementReport" method="post" onSubmit="return validate();" target="_blank" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                    <div class="row success-err-sms-area">
                      <div class="col-md-12">
                        <div id="errors"></div>
                        <?php 
                        print $this->session->flashdata('errors'); 
                        print $this->session->flashdata('success'); 
                        ?>
                      </div>
                    </div>
                    <div class="row"> 
                      <div class="col-md-3"></div>
                      <div class="col-md-6" style="background-color:#F0E68C; border-radius:5px;">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="pull-right"> <span style="color:red">*</span> Fields are required.</label>
                            </div>
                            
                        </div>
                        <div class="row">
                          
                          <div class="col-md-3 bgcolor_D8D8D8 label">Division <span style="color:red">*</span> :</div>
                          <div class="col-md-9">
                            <select name="emp_division" id="emp_division" class="input-lg form-control">
                                
                                  <?php 
                                   if($user_type_id !=1){
                                       if($user_type_id==5){
                                           echo '<option value="">Select Division</option>';
                                            foreach ($alldivision as $single_division) {
                                            /*  if($defaultdivision_id==$single_division['tid']){
                                                echo '<option value="'.$single_division['tid'].'" selected="selected" data-id="'.$single_division['weight'].'">'.$single_division['name'].'</option>';
                                              }else{
                                                  */
                                                echo '<option value="'.$single_division['tid'].'" data-id="'.$single_division['weight'].'">'.$single_division['name'].'</option>';
                                             // }
                                            } 
                                       }else{
                                    echo '<option value="'.$alldivision['tid'].'" selected="selected" data-id="'.$alldivision['weight'].'">'.$alldivision['name'].'</option>';
                                       }
                                    
                                       }else{
                                    echo '<option value="">Select Division</option>';
                                    foreach ($alldivision as $single_division) {
                                    /*  if($defaultdivision_id==$single_division['tid']){
                                        echo '<option value="'.$single_division['tid'].'" selected="selected" data-id="'.$single_division['weight'].'">'.$single_division['name'].'</option>';
                                      }else{
                                          */
                                        echo '<option value="'.$single_division['tid'].'" data-id="'.$single_division['weight'].'">'.$single_division['name'].'</option>';
                                     // }
                                    } 
                                  }
                                  ?> 
                            </select>         
                          </div>
                        </div>     
                        <!--
                        <div class="row">
                          <div class="col-md-3 bgcolor_D8D8D8">Division Code</div>
                          <div class="col-md-9"><input type="text" name="division_code" id="division_code" placeholder="Write Division Code" autocomplete="off" value="<?php if($default_emp['emp_id']){ echo $default_division['emp_id'];} ?>"/></div>
                        </div>
                        -->
                        <div class="row">
                            <div class="col-md-3  bgcolor_D8D8D8 label">Department : </div>
                            <div class="col-md-9">
                              <select name="emp_department" id="emp_department"  class="input-lg form-control">
                                <option value="">All</option>
                                <?php 

                                foreach ($department_selected as $single_department) {
                                  if($emp_department==$single_department['tid']){
                                    echo '<option value="'.$single_department['tid'].'" selected="selected">'.$single_department['name'].'</option>';
                                }else{
                                    echo '<option value="'.$single_department['tid'].'">'.$single_department['name'].'</option>';
                                  }
                                } 
                                ?>
                              </select>                       
                            </div>
                        </div> 
                        <div class="row">
                                
                          <div class="col-md-3 bgcolor_D8D8D8 label">Date Range  <span style="color:red">*</span> :</div>
                          <div class="col-md-9">
                           <!--   <input type="text" name="emp_attendance_start_date"  class="datepicker numbersOnly form-control" id="emp_attendance_start_date" value="<?php  print $first_day_this_month;  ?>" placeholder="dd-mm-yyyy"> -->
                             <div class="input-daterange input-group" id="datepicker">
        <input type="text" class="input-lg  form-control datepicker" name="emp_attendance_start_date"  id="emp_attendance_start_date" value="<?php  print $first_day_this_month;  ?>" placeholder="dd-mm-yyyy" />
        <span class="input-group-addon">to</span>
        <input type="text" class="input-lg  form-control datepicker" name="emp_attendance_end_date" id="emp_attendance_end_date" value="<?php  print $last_day_this_month;  ?>" placeholder="dd-mm-yyyy" />
    </div>
                              </div>
                        </div>
                    
                        <div class="row">
                          <div class="col-md-3 bgcolor_D8D8D8 label"> Format <span style="color:red">*</span>:</div>
                          <div class="col-md-9">
                                <select name="report_format" id="report_format"  class="input-lg form-control">
                                      <option value="excel">Excel</option>
                                      <option value="pdf">PDF</option>
                                </select>
                          </div>
                        </div> 
                       <div class="row">
                          <div class="col-md-3 bgcolor_D8D8D8 label"> </div>
                          <div class="col-md-9">
                                Festival Bonus <input type='checkbox' name="festival_bonus" />
                          </div>
                        </div>
                        
                        <div class="row top10 bottom10">
                          <div class="col-md-3"></div>
                          <div class="col-md-9">
<input type="submit" name="add_attendance_btn" id="add_attendance_btn" class="input-lg form-control btn btn-lg btn-primary" style="width:150px;" value="Submit"></div>
                        </div>
                      </div>
                      <div class="col-md-3"></div>
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