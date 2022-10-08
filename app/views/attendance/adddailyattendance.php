<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Daily Attendance</title>
    <?php
    $this->load->view('includes/cssjs');
    date_default_timezone_set('Asia/Dhaka');
    $servertime = time();
    $today_date = date("d-m-Y", $servertime);    
    ?> 

    <script>
        $(document).ready(function(){
                // Setup - add a text input to each footer cell
                jQuery.validator.setDefaults({
                    debug: true,
                    success: "valid"
                });
                $( "#myForm" ).validate({
                    rules: {
                        emp_name: "required",
                        emp_id: "required",
                        emp_login_time: {required: true, time: true},
                        emp_logout_time: {required: true, time: true},
                        emp_attendance_date : {required: true, mydate : true },
                    },
                    submitHandler: function(form) {
                    // do other things for a valid form
                    form.submit();
                }
            });
                $.validator.addMethod('time', function(value, element, param) {
                   return /^([01]?[0-9]|2[0-3])(:[0-5][0-9]){2}$/.test(value);
               }, 'Enter a valid time: hh:mm:ss');  

                $.validator.addMethod("mydate", function (value, element) {
                    return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
                },
                "Please enter a date in the format dd-mm-yyyy"
                );  
                $('#emp_name').change(function(){
                    var emp_id=$("#emp_name").val();            
                    $('#emp_id').val(emp_id);
                    var emp_attendance_date=$("#emp_attendance_date").val();
                    var base_url='<?php echo base_url();?>';
                    var postData = {
                        "emp_id"              : emp_id,
                        "emp_attendance_date" : emp_attendance_date,
                    };
                    $.ajax({
                     type: "POST",
                     url: ""+base_url+"empattendance/getempattendancebydate",
                     data: postData,
                     dataType:'json',
                     success: function(data){
                         $("#emp_login_time").val(data.login_time);
                         $("#emp_logout_time").val(data.logout_time);
                     }
                 });            
                });  


                $(document).on('keydown', 'input#emp_id', function(e) { 
                    var keyCode = e.keyCode || e.which; 

                    if (keyCode == 9) { 
                      e.preventDefault(); 
    // call custom function here
    var emp_id=$(this).val();
    $('#emp_name').val(emp_id); 
    var emp_attendance_date=$("#emp_attendance_date").val();
    var base_url='<?php echo base_url();?>';
    var postData = {
        "emp_id"              : emp_id,
        "emp_attendance_date" : emp_attendance_date,
    };
    $.ajax({
     type: "POST",
     url: ""+base_url+"empattendance/getempattendancebydate",
     data: postData,
     dataType:'json',
     success: function(data){
         $("#emp_login_time").val(data.login_time);
         $("#emp_logout_time").val(data.logout_time);
     }
 });    
} 
});    

                $("#emp_attendance_date").keyup(function(){
                    var emp_attendance_date=$(this).val();
                    var base_url='<?php echo base_url();?>';
                    var emp_id=$("#emp_id").val();
                    var postData = {
                        "emp_id"              : emp_id,
                        "emp_attendance_date" : emp_attendance_date,
                    };
                    $.ajax({
                     type: "POST",
                     url: ""+base_url+"empattendance/getempattendancebydate",
                     data: postData,
                     dataType:'json',
                     success: function(data){
                         $("#emp_login_time").val(data.login_time);
                         $("#emp_logout_time").val(data.logout_time);
                     }
                 }); 
                });

                $("#emp_attendance_date").datepicker({
                }).on('changeDate', function(ev){
                    var emp_attendance_date=$("#emp_attendance_date").val();
                    var base_url='<?php echo base_url();?>';
                    var emp_id=$("#emp_id").val();
                    var postData = {
                        "emp_id"              : emp_id,
                        "emp_attendance_date" : emp_attendance_date,
                    };
                    $.ajax({
                     type: "POST",
                     url: ""+base_url+"empattendance/getempattendancebydate",
                     data: postData,
                     dataType:'json',
                     success: function(data){
                         $("#emp_login_time").val(data.login_time);
                         $("#emp_logout_time").val(data.logout_time);
                     }
                 });
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
if ( document.myForm.emp_id.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.emp_id.focus();
      document.myForm.emp_id.style.border="solid 1px red";
      msg+="<li>You need to fill the emp_id field!</li>";
      valid = false;
      return false;
  }
}
if ( document.myForm.emp_attendance_date.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.emp_attendance_date.focus();
      document.myForm.emp_attendance_date.style.border="solid 1px red";
      msg+="<li>You need to fill the emp_attendance_date field!</li>";
      valid = false;
      return false;
  }
}
if ( document.myForm.emp_login_time.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.emp_login_time.focus();
      document.myForm.emp_login_time.style.border="solid 1px red";
      msg+="<li>You need to fill the emp_login_time field!</li>";
      valid = false;
      return false;
  }
}
if ( document.myForm.emp_logout_time.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.emp_logout_time.focus();
      document.myForm.emp_logout_time.style.border="solid 1px red";
      msg+="<li>You need to fill the emp_logout_time field!</li>";
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

   $(document).ready(function(){ 
//    $('.wrapper').find('input, textarea, button, select').attr('disabled','disabled');
 });
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
                <h4>Add Daily Attendance</h4>         
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url(); ?>empattendance/adddailyattendance" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
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
                                                        print '<option value="'.$emp_id.'" selected="selected">'.$emp_name.'</option>';
                                                    }else{
                                                        print '<option value="'.$emp_id.'">'.$emp_name.'</option>';
                                                    }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>                                
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Employee Code</div>
                                        <div class="col-md-9"><input type="text" name="emp_id" id="emp_id" placeholder="Press TAB key after typing Emp id or select Emp Name" autocomplete="off" value="<?php if($default_emp['emp_id']){ echo $default_emp['emp_id'];} ?>"/></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Attendance Date:</div>
                                        <div class="col-md-9"><input type="text" name="emp_attendance_date" class="datepicker numbersOnly" id="emp_attendance_date" value="<?php if($emp_attendance_date){ print $emp_attendance_date; }else{ print $today_date; } ?>" placeholder="dd-mm-yyyy"></div>
                                    </div>                                                                                       
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Login Time:</div>
                                        <div class="col-md-9"><input type="text" name="emp_login_time" id="emp_login_time" value="<?php if($emp_login_time){ print $emp_login_time; }else{ print '09:30:00'; } ?>" placeholder="hh:mm:ss 24 hours format"></div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Logout Time:</div>
                                        <div class="col-md-9"><input type="text" name="emp_logout_time" id="emp_logout_time" value="<?php if($emp_logout_time){ print $emp_logout_time; }else{ print '17:30:00'; } ?>" placeholder="hh:mm:ss 24 hours format"></div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Attendance Status:</div>
                                        <div class="col-md-9">
                                          <select name="presence_status" id="presence_status">
                                            <option value="P">Present</option>
                                            <option value="L">Late</option>
                                            <option value="A">Absent</option>
                                          </select>
                                        </div>
                                    </div>    
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Remarks:</div>
                                        <div class="col-md-9">
                                        <textarea name="remarks" id="remarks" cols="30" rows="10"></textarea>
                                        </div>
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