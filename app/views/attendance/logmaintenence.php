<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS || Log Maintenence</title>
    <?php
    $this->load->view('includes/cssjs');
    date_default_timezone_set('Asia/Dhaka');
    $servertime = time();
    $today_date = date("d-m-Y", $servertime);    
    ?> 
    <script>
        $(document).ready(function(){
      $("#entry_company_wise").click(function(){
            $('#entry_emp_wise').prop('checked', false);  
            $('#entry_division_wise').prop('checked', false);  
            $('.company_wise').css({"display":"block"});
            $('.name_wise_entry_area').css({"display":"none"});
            $('.division_wise_area').css({"display":"none"});
          
      });
      $("#entry_emp_wise").click(function(){
            $('#entry_company_wise').prop('checked', false); 
            $('#entry_division_wise').prop('checked', false); 
            $('.name_wise_entry_area').css({"display":"block"});
            $('.company_wise').css({"display":"none"});
            $('.division_wise_area').css({"display":"none"});
                                   
      });
      $("#entry_division_wise").click(function () {
                    $('#entry_emp_wise').prop('checked', false);
                    $('#entry_company_wise').prop('checked', false);
                    $('.division_wise_area').css({"display": "block"});
                    $('.name_wise_entry_area').css({"display": "none"});
                    $('.company_wise').css({"display":"none"});

                });
       $("#company").change(function (e) {
                    $("input[type=submit]").removeAttr("disabled");
                    var division_tid = $(this).val();
                    var base_url = '<?php echo base_url(); ?>';
                    var postData = {
                        "division_tid": division_tid
                    };
                    $.ajax({
                        type: "POST",
                        url: "" + base_url + "addprofile/getdepartmentidbydivisionid",
                        data: postData,
                        dataType: 'json',
                        success: function (data) {
                            // console.log(data);
                            var options = "";
                            options += '<option value="">select division</option>';
                            $(data).each(function (index, item) {
                                options += '<option value="' + item.tid + '">' + item.name + '</option>';
                            });
                            $('#emp_division').html(options);
                        }
                    });                   
                });
      $("#late_status").change(function(){
        var this_value=$(this).val();
        if(this_value=='Late_Count_Time'){
          $('.late_count_area').css({"display":"block"});
        }else{
          $('.late_count_area').css({"display":"none"})
        }       

      }); 
        $("#half_day_absent_status").change(function(){
        var this_value=$(this).val();
        if(this_value=='Half_Day_Absent_Count_Time'){
          $('.absent_count_area').css({"display":"block"});
        }else{
          $('.absent_count_area').css({"display":"none"})
        }        

      });     
        $("#early_status").change(function(){
        var this_value=$(this).val();
        if(this_value=='Early_Count_Time'){
          $('.early_count_area').css({"display":"block"});
        }else{
          $('.early_count_area').css({"display":"none"})
        }        

      });           
         
                // Setup - add a text input to each footer cell
            //     jQuery.validator.setDefaults({
            //         debug: true,
            //         success: "valid"
            //     });
            //     $( "#myForm" ).validate({
            //         rules: {
            //             emp_name: "required",
            //             emp_id: "required",
            //             // emp_login_time: {required: true, time: true},
            //             // emp_logout_time: {required: true, time: true},
            //             emp_attendance_date : {required: true, mydate : true },
            //         },
            //         submitHandler: function(form) {
            //         // do other things for a valid form
            //         form.submit();
            //     }
            // });
            //     $.validator.addMethod('time', function(value, element, param) {
            //        return /^([01]?[0-9]|2[0-3])(:[0-5][0-9]){2}$/.test(value);
            //    }, 'Enter a valid time: hh:mm:ss');  

            //     $.validator.addMethod("mydate", function (value, element) {
            //         return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
            //     },
            //     "Please enter a date in the format dd-mm-yyyy"
            //     );  
                $('#emp_name').change(function(){
                    var emp_id=$("#emp_name").val();            
                    $('#emp_id').val(emp_id);           
                });  
              $('#emp_id').keyup(function(){
                var emp_id=$("#emp_id").val();            
                $('#emp_name').val(emp_id);          
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
  if(document.myForm.entry_company_wise.checked){
    
      if ( document.myForm.emp_company.value == "" ) {
        if (valid){ //only receive focus if its the first error
          document.myForm.emp_company.focus();
          document.myForm.emp_company.style.border="solid 1px red";
          msg+="<li>You need to fill the Company field!</li>";
          valid = false;
          return false;
      }
    }    
  }
  if(document.myForm.entry_division_wise.checked){
    
      if ( document.myForm.emp_division.value == "" ) {
        if (valid){ //only receive focus if its the first error
          document.myForm.emp_division.focus();
          document.myForm.emp_division.style.border="solid 1px red";
          msg+="<li>You need to fill the division field!</li>";
          valid = false;
          return false;
      }
    }    
  }
  if(document.myForm.entry_emp_wise.checked){
    if ( document.myForm.emp_name.value == "" ) {
        if (valid){ //only receive focus if its the first error
          document.myForm.emp_name.focus();
          document.myForm.emp_name.style.border="solid 1px red";
          msg+="<li>You need to fill the emp_name field!</li>";
          valid = false;
          return false;
      }
    }     
  }
  // early_count_area early_status
 if ( document.myForm.late_status.value == "Late_Count_Time" ) {
    if ( document.myForm.emp_late_count_time.value == "" ) {
        if (valid){ //only receive focus if its the first error
          document.myForm.emp_late_count_time.focus();
          document.myForm.emp_late_count_time.style.border="solid 1px red";
          msg+="<li>You need to fill the emp_late_count_time field!</li>";
          valid = false;
          return false;
      }
    }  
 }
 if ( document.myForm.early_status.value == "Early_Count_Time" ) {
    if ( document.myForm.early_count_time.value == "" ) {
        if (valid){ //only receive focus if its the first error
          document.myForm.early_count_time.focus();
          document.myForm.early_count_time.style.border="solid 1px red";
          msg+="<li>You need to fill the early_count_time field!</li>";
          valid = false;
          return false;
      }
    }  
 } 
 if ( document.myForm.half_day_absent_status.value == "Half_Day_Absent_Count_Time" ) {
    if ( document.myForm.half_day_absent_count_time.value == "" ) {
        if (valid){ //only receive focus if its the first error
          document.myForm.half_day_absent_count_time.focus();
          document.myForm.half_day_absent_count_time.style.border="solid 1px red";
          msg+="<li>You need to fill the half_day_absent_count_time field!</li>";
          valid = false;
          return false;
      }
    }  
 }
if ( document.myForm.emp_attendance_start_date.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.emp_attendance_start_date.focus();
      document.myForm.emp_attendance_start_date.style.border="solid 1px red";
      msg+="<li>You need to fill the emp_attendance_start_date field!</li>";
      valid = false;
      return false;
  }
}
if ( document.myForm.emp_attendance_end_date.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.emp_attendance_end_date.focus();
      document.myForm.emp_attendance_end_date.style.border="solid 1px red";
      msg+="<li>You need to fill the emp_attendance_end_date field!</li>";
      valid = false;
      return false;
  }
}
var startdate=document.myForm.emp_attendance_start_date.value;
var enddate=document.myForm.emp_attendance_end_date.value;
var startdate_components = startdate.split("-");
var enddate_components = enddate.split("-");
var d1 = Date.parse(startdate_components[2]+"-"+startdate_components[1]+"-"+startdate_components[0]);
var d2 = Date.parse(enddate_components[2]+"-"+enddate_components[1]+"-"+enddate_components[0]);
if (d2 < d1) {
    if (valid){ //only receive focus if its the first error
      document.myForm.emp_attendance_end_date.focus();
      document.myForm.emp_attendance_end_date.style.border="solid 1px red";
      msg+="<li>You need to fill the emp_attendance_end_date field!</li>";
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
</head>
<body class="logged-in dashboard current-page add-attendance">
    <!-- Page Content -->  
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php 
            $this -> load -> view('includes/menu');
            ?>
            <div class="row under-header-bar text-center"> 
                <h4>Add Log Maintenence</h4>         
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="row success-err-sms-area">
                                        <div class="col-md-12">
                                            <div id="errors"></div>
                                            <?php 
                                            echo $this->session->flashdata('errors'); 
                                            echo "<font color=green>".$this->session->flashdata('success')."</font>"; 
                                            ?>
                                        </div>
                                    </div> 
                        <form action="<?php echo base_url(); ?>empattendance/logMaintenance" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                            
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Select Entry Type</div>
                                        <div class="col-md-9">
                                            <input type="radio" id="entry_company_wise" name="entry_company_wise" checked="checked"> Company Wise 
                                            <input type="radio" id="entry_division_wise" name="entry_division_wise"> Division Wise
                                            <input type="radio" id="entry_emp_wise" name="entry_emp_wise"> Employee Wise
                                        </div>
                                    </div> 
                              
                            <div class="row company_wise" style="margin-bottom:2px;">
                              <div class="col-md-3 bgcolor_D8D8D8">Company</div>
                              <div class="col-md-9">                             
                                <select name="emp_company[]" id="emp_company" size="7" multiple="">
                                  <?php 
                                   if($user_type_id !=1){
                                    echo '<option value="'.$alldivision['tid'].'" selected="selected" data-id="'.$alldivision['weight'].'">'.$alldivision['name'].'</option>';
                                   }else{
                                    echo '<option value="all">All</option>';
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
                             <?php if ($this->session->userdata('user_type') == '1') { ?>
                                            <div class="row division_wise_area" style="display:none;">
                                                <div class="row">
                                                    <div class="col-md-3 bgcolor_D8D8D8">Company : </div>
                                                    <div class="col-md-9">
                                                        <select name="company" id="company">
                                                            <option value="">--Select Company--</option>
                                                            <?php
                                                            foreach ($alldivision AS $single_division) {
                                                                echo '<option value="' . $single_division['tid'] . '" data-id="' . $single_division['weight'] . '">' . $single_division['name'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3  bgcolor_D8D8D8 label">Division/ Branch : </div>
                                                    <div class="col-md-9">
                                                        <select name="emp_division" id="emp_division"  class="">
                                                            <option value="">Select company first</option>
                                                            <?php
                                                            foreach ($department_selected as $single_department) {
                                                                if ($emp_department == $single_department['tid']) {
                                                                    echo '<option value="' . $single_department['tid'] . '" selected="selected">' . $single_department['name'] . '</option>';
                                                                } else {
                                                                    echo '<option value="' . $single_department['tid'] . '">' . $single_department['name'] . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>                       
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                            <div class="name_wise_entry_area" style="display:none;">                                                           
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Name</div>
                                        <div class="col-md-9">
                                            <select name="emp_name" id="emp_name">
                                                <option value="">Select</option>
                                                <?php foreach ($allemployee as $single_employee) {
                                                    $default_emp_id=$default_emp['emp_id'];
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
                                        <div class="col-md-3 bgcolor_D8D8D8">Employee Code</div>
                                        <div class="col-md-9"><input type="text" name="emp_id" id="emp_id" placeholder="type Emp id or select Emp Name" autocomplete="off" value="<?php if($default_emp['emp_id']){ echo $default_emp['emp_id'];} ?>"/></div>
                                    </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Start Date:</div>
                                        <div class="col-md-9"><input type="text" name="emp_attendance_start_date" class="datepicker numbersOnly" id="emp_attendance_date" value="<?php if($emp_attendance_date){ print $emp_attendance_date; }else{ print $today_date; } ?>" placeholder="dd-mm-yyyy"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">End Date:</div>
                                        <div class="col-md-9"><input type="text" name="emp_attendance_end_date" class="datepicker numbersOnly" id="emp_attendance_date" value="<?php if($emp_attendance_date){ print $emp_attendance_date; }else{ print $today_date; } ?>" placeholder="dd-mm-yyyy"></div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Weekly Holiday:</div>
                                        <div class="col-md-9">
                                          <select name="weekly_holiday" id="weekly_holiday">
                                            <option value="off_day">Off Day</option>
                                            <option value="working_day">Working Day</option>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Late Status:</div>
                                        <div class="col-md-9">
                                          <select name="late_status" id="late_status">
                                            <option value="Late_Not_Count">Late Not Count</option>
                                            <option value="Late_Count_Time">Late Count Time</option>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="row late_count_area" style="display:none;">
                                        <div class="col-md-3 bgcolor_D8D8D8">Late Count Time:</div>
                                        <div class="col-md-9"><input type="text" name="emp_late_count_time" id="emp_late_count_time" value="<?php if($emp_late_count_time){ print $emp_late_count_time; }else{ print '10:30:00'; } ?>" placeholder="hh:mm:ss 24 hours format"></div>
                                    </div>                                     
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Half Day Absent:</div>
                                        <div class="col-md-9">
                                          <select name="half_day_absent_status" id="half_day_absent_status">
                                            <option value="Half_Day_Absent_Not_Count">Half Day Absent Not Count</option>
                                            <option value="Half_Day_Absent_Count_Time">Half Day Absent Count Time</option>
                                          </select>
                                        </div>
                                    </div>                                       
                                    <div class="row absent_count_area"  style="display:none;">
                                        <div class="col-md-3 bgcolor_D8D8D8">Half Day Absent Count Time:</div>
                                        <div class="col-md-9"><input type="text" name="half_day_absent_count_time" id="half_day_absent_count_time" value="<?php if($half_day_absent_count_time){ print $half_day_absent_count_time; }else{ print '10:30:00'; } ?>" placeholder="hh:mm:ss 24 hours format"></div>
                                    </div>    
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Early Count:</div>
                                        <div class="col-md-9">
                                          <select name="early_status" id="early_status">
                                            <option value="Early_Not_Count">Early Not Count</option>
                                            <option value="Early_Count_Time">Early Count Time</option>
                                          </select>
                                        </div>
                                    </div>                                       
                                    <div class="row early_count_area"  style="display:none;">
                                        <div class="col-md-3 bgcolor_D8D8D8">Early Count Time:</div>
                                        <div class="col-md-9"><input type="text" name="early_count_time" id="early_count_time" value="<?php if($early_count_time){ print $early_count_time; }else{ print '17:30:00'; } ?>" placeholder="hh:mm:ss 24 hours format"></div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Attendance Status:</div>
                                        <div class="col-md-9">
                                          <select name="presence_status" id="presence_status">
                                            <option value="A">Absent who has no log</option>
                                            <option value="P">Present who has no log</option>
                                          </select>
                                        </div>
                                    </div>                                                                                                                                              
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Reason:</div>
                                        <div class="col-md-9">
                                        <textarea name="remarks" id="remarks" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>                                                                                                                                                         
<!--                                     <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Login Time:</div>
                                        <div class="col-md-9"><input type="text" name="emp_login_time" id="emp_login_time" value="<?php if($emp_login_time){ print $emp_login_time; }else{ print '09:30:00'; } ?>" placeholder="hh:mm:ss 24 hours format"></div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Logout Time:</div>
                                        <div class="col-md-9"><input type="text" name="emp_logout_time" id="emp_logout_time" value="<?php if($emp_logout_time){ print $emp_logout_time; }else{ print '17:30:00'; } ?>" placeholder="hh:mm:ss 24 hours format"></div>
                                    </div>   -->                                                                                                                    
                                    <div class="row top10 bottom10">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-9"><input type="submit" name="add_attendance_btn" value="Submit"></div>
                                    </div>
                                                                       
                                </div>
                                <div class="col-md-3"></div>
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