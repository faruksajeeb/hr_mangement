<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Informed Report</title>
    <?php
    $this->load->view('includes/cssjs');
    date_default_timezone_set('Asia/Dhaka');
    $servertime = time();
    $today_date = date("d-m-Y", $servertime);    
    ?> 
                           <!--chosen--> 
         <link rel="stylesheet" href="<?php echo base_url();?>resources/plugins/chosenSelect/chosen.css">
    <script>
      var dialog, form;
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
                        // emp_login_time: {required: true, time: true},
                        // emp_logout_time: {required: true, time: true},
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
                  // var emp_attendance_date=$("#emp_attendance_date").val();
                  // var base_url='<?php echo base_url();?>';
                  // var postData = {
                  //   "emp_id"              : emp_id,
                  //   "emp_attendance_date" : emp_attendance_date,
                  // };
                  // $.ajax({
                  //  type: "POST",
                  //  url: ""+base_url+"empattendance/getempattendancebydate",
                  //  data: postData,
                  //  dataType:'json',
                  //  success: function(data){
                  //        // $("#emp_login_time").val(data.login_time);
                  //        // $("#emp_logout_time").val(data.logout_time);
                  //      }
                  //    });            
              });  
                $('#emp_id').keyup(function(){
                  var emp_id=$("#emp_id").val();            
                  $('#emp_name').val(emp_id);          
                });  

// select all checkbox in tables
$('#check_all').click(function () {
    var checked_status = this.checked;
    $(this).closest('table').find('input:checkbox').each(function () {
        this.checked = checked_status;
    });
});   
function addInformed() {
        var edit_id=$("#informed_id").val();
        var emp_attendance_start_datepop=$("#emp_attendance_start_datepop").val();
        var login_statuspop=$("#login_statuspop").val();
        var logout_statuspop=$("#logout_statuspop").val();
        var reason=$("#reason").val();
        var remarkspop=$("#remarkspop").val();
        var base_url='<?php echo base_url();?>';
        var postData = {
            "informed_id"               : edit_id,
            "emp_attendance_start_date" : emp_attendance_start_datepop,
            "presence_status"           : login_statuspop,
            "logout_status"             : logout_statuspop,
            "reason"                    : reason,
            "remarks"                   : remarkspop
        };       
        
        $.ajax({
         type: "POST",
         url: "" + base_url + "empattendance/attendanceinformedajaxsubmit",
         data: postData,
         dataType:'json',
         success: function(data){
            if(data){
            dialog.dialog( "close" );
            console.log(data); 
            window.location.reload(true);            
            }
          }
        }) 
}
dialog = $( "#dialog-form" ).dialog({
  autoOpen: false,
  height: "auto",
  width: "auto",
  modal: true,
  buttons: {
   // "Add field": addField,
   "Add informed":     {
       text: "Submit",
       id: "add-informed-btn",
       click: addInformed   
   },
   Cancel: function() {
      dialog.dialog( "close" );
  }
},
position: { my: "center center", at: "center top" },
close: function() {
    form[ 0 ].reset();
        // allFields.removeClass( "ui-state-error" );
    }
});

form = dialog.find( "form" ).on( "submit", function( event ) {
  event.preventDefault();
    //  addField();
});

$( ".edit_img" ).on( "click", function(event) {
    event.preventDefault();
    var edit_id=  $(this).attr("id-edit");

    if(edit_id){
      $("#informed_id").val(edit_id);
        var base_url='<?php echo base_url();?>';
        var postData = {
            "informed_id"    : edit_id
        };        
        $.ajax({
         type: "POST",
         url: ""+base_url+"empattendance/attendanceinformedajax",
         data: postData,
         dataType:'json',
         success: function(data){
            if (data) {
              $("#informed_id").val(data.id);
              $("#emp_attendance_start_datepop").val(data.attendance_date);
              $("#emp_attendance_end_datepop").val(data.attendance_date);
              $("#login_statuspop").val(data.presence_status);
              $("#logout_statuspop").val(data.logout_status);
              $("#reason").val(data.reason);
              $("#remarkspop").val(data.remarks);
              dialog.dialog( "open" );
            }
          }
        })
        }
    })

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


function popitup(url) {
  newwindow=window.open(url,'name','height=auto,width=700px');
  //newwindow.print();
window.onfocus=function(){ newwindow.close();}
  if (window.focus) {newwindow.focus(); }
    var document_focus = false;
  $(newwindow).focus(function() { document_focus = true; });
      $(newwindow).load(function(){
   // setInterval(function() { if (document_focus === true) { newwindow.close();  document_focus = false;}  }, 7000);
   
});
  return false;
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
    font-weight: bold;
    }
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
      $this -> load -> view('includes/menu');
            $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
            $last_day_this_month  = date('t-m-Y');
            ?>
            <div class="row under-header-bar text-center"> 
                <h4>Informed Attendance Reports</h4>         
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                <form action="<?php echo base_url(); ?>reports/informedreports" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
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
                          <div class="col-md-3 bgcolor_D8D8D8">Employee Name</div>
                          <div class="col-md-9">
                            <select  name="emp_id" id="emp_id"  data-placeholder="Choose an Employee..." class="chosen-select">
                              <option value=""></option>
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
                          <!--
                        <div class="row">
                          <div class="col-md-3 bgcolor_D8D8D8">Employee Code</div>
                          <div class="col-md-9"><input type="text" name="emp_id" id="emp_id" placeholder="Press TAB key after typing Emp id or select Emp Name" autocomplete="off" value="<?php if($default_emp['emp_id']){ echo $default_emp['emp_id'];} ?>"/></div>
                        </div>
                          -->
                        <div class="row">
                          <div class="col-md-3 bgcolor_D8D8D8">Start Date:</div>
                          <div class="col-md-9"><input type="text" name="emp_attendance_start_date" class="datepicker numbersOnly" id="emp_attendance_start_date" value="<?php if($defaultstart_date){ print $defaultstart_date; }else{ print $first_day_this_month; } ?>" placeholder="dd-mm-yyyy"></div>
                        </div> 
                        <div class="row">
                          <div class="col-md-3 bgcolor_D8D8D8">End Date:</div>
                          <div class="col-md-9"><input type="text" name="emp_attendance_end_date" class="datepicker numbersOnly" id="emp_attendance_end_date" value="<?php if($defaultend_date){ print $defaultend_date; }else{ print $last_day_this_month; } ?>" placeholder="dd-mm-yyyy"></div>
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
                                    <div class="col-md-2"></div>
                                  </div>
                                </form>
                            <form action="<?php echo base_url(); ?>deletecontent/deleteinformedmultiple" method="post" class="myForm2" id="myForm2"  name="myForm2" enctype="multipart/form-data">
                                            <div class="row">
                        <div class="col-md-2">
                          <!--  <input type="submit" style="width:100%" name="change_selected_status" value="Multiple Delete" > -->
                        </div>            
                </div> 
                                <table id="example" class="display" cellspacing="0" width="100%">
                                  <thead>
                                    <tr class="heading">
                                      <th style="padding-left: 10px;text-align: left;width:10px!important"><input type='checkbox' class="check_all" id="check_all" value='all' /></th>
                                      <th>Employee Name</th>
                                      <th>Employee ID</th>
                                      <th>Attendance Date</th>
                                      <th>Login Status</th>
                                      <th>Logout Status</th>
                                      <th>Remarks</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  <?php foreach ($informed as $single_informed) {
                                    $content_id=$single_informed['content_id'];
                                    $id=$single_informed['id'];
                                    $emp_details_records=$this->search_field_emp_model->getallsearch_table_contentByid($content_id);     
                                       ?>
                                <tr>
                                <td style="width:10px!important"><input type='checkbox' name='id[]' value='<?php print $id; ?>' /></td>  
                                  <td><?php print $emp_details_records['emp_name']; ?></td>
                                  <td><?php print $emp_details_records['emp_id']; ?></td>
                                  <td><?php print $single_informed['attendance_date']; ?></td>
                                  <td><?php print $single_informed['presence_status']; ?></td>
                                  <td><?php print $single_informed['logout_status']; ?></td>
                                  <td><?php print $single_informed['remarks']; ?></td>
                                  <td>
                                      <!--
                                  <img src="<?php echo base_url(); ?>resources/images/edit.png" style="width: 20px;cursor: pointer;" title="Click to edit" class="edit_img" alt="edit cost" id-edit="<?php print $id; ?>"/>
                                  <a href="<?php echo site_url("deletecontent/deleteinformed") . '/' . $id; ?>" class="operation-cut operation-link"  onClick="return ConfirmDelete()"> <img src="<?php echo base_url(); ?>resources/images/cut.jpg" alt="edit" /></a>
                                 -->
                                  </td>
                                  </tr>
                                 <?php } ?>
                                  </tbody>
                                  </table>
                                  </form>
            <br><br><br><br>
                    </div>
                </div>              
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
        <div id="dialog-form" title="Edit Attendance Informed">
          <p class="validateTips"></p>
          <form>
            <fieldset>
                            <div class="row"> 
                                <div class="col-md-1">
                                <div class="hidden_id" style="visibility: hidden;">
                                  <input type="text" id="informed_id" name="informed_id" value="">
                                </div>
                                  
                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Start Date:</div>
                                        <div class="col-md-9"><input type="text" name="emp_attendance_start_datepop" class=" numbersOnly" id="emp_attendance_start_datepop" readonly="readonly" value="<?php if($emp_attendance_date){ print $emp_attendance_date; }else{ print $today_date; } ?>" placeholder="dd-mm-yyyy"></div>
                                    </div>                                       
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Login Status:</div>
                                        <div class="col-md-9">
                                          <select name="login_statuspop" id="login_statuspop">
                                            <option value="P">Present</option>
                                            <option value="L">Late</option>
                                            <option value="A">Absent</option>
                                          </select>
                                        </div>
                                    </div> 
                                     <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Logout Status:</div>
                                        <div class="col-md-9">
                                          <select name="logout_statuspop" id="logout_statuspop">
                                            <option value="P">Present</option>
                                            <option value="E">Early</option>
                                          </select>
                                        </div>
                                    </div>
                                     <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Reason:</div>
                                        <div class="col-md-9">                                       
                                        <select name="reason" id="reason" >
                                            <option value="personal">Personal</option> 
                                            <option value="official">Official</option>                                            
                                            <option value="technical_problem">Technical Problem</option> 
                                        </select>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Description:</div>
                                        <div class="col-md-9">
                                        <textarea name="remarkspop" id="remarkspop" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>                                                                                                                                                                                                                                                                           
                                </div>
                                <div class="col-md-1"></div>
                            </div>                           
                    <!-- Allow form submission with keyboard without duplicating the dialog button -->
                    <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                </fieldset>
            </form>
        </div>     
    <!-- /#wrapper -->  
                         <!--Chosen--> 
        <script src="<?php echo base_url();?>resources/plugins/chosenSelect/chosen.jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>resources/plugins/chosenSelect/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
   
</body>
</html>