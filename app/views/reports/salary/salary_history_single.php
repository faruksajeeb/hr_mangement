<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Employee Wise Salary Increment Reports</title>
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
      $nowdate = date("d-m-Y", $servertime);
      $thisyear = date("Y", $servertime);
      $nowbigmonth = date_format($datee, 'F Y');
      $nowtime = date("H:i:s a", $servertime);       
      $this -> load -> view('includes/menu');           
      ?>
      <div class="row under-header-bar text-center"> 
        <h4>Salary Increment History Reports</h4>         
      </div> 
      <div class="wrapper">
        <div class="row">
          <div class="col-md-12">
          <form action="<?php echo base_url(); ?>salary/salaryhistorysingle" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
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
                    <div class="col-md-3 bgcolor_D8D8D8">Name</div>
                    <div class="col-md-9">
                      <select name="emp_name" id="emp_name">
                        <option value="">Select</option>
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
                    <div class="col-md-3 bgcolor_D8D8D8">Employee Code</div>
                    <div class="col-md-9"><input type="text" name="emp_id" id="emp_id" placeholder="Press TAB key after typing Emp id or select Emp Name" autocomplete="off" value="<?php if($default_emp['emp_id']){ echo $default_emp['emp_id'];} ?>"/></div>
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
              <div class="col-md-12 text-right"><a onclick="return popitup('<?php echo site_url("salary/singlesalaryincrementpdf") ; ?>')" href="<?php echo site_url("salary/singlesalaryincrementpdf") ; ?>"  class="operation-print-pdf operation-link"> <img src="<?php echo base_url(); ?>resources/images/pdf_icon_print.png" alt="pdf" style="width:20px;"/></a></div>
            </div>
            <div class="emp_info">
              <div class="row">
                <div class="col-md-2" >Employee ID:</div>
                <div class="col-md-5" ><?php print $default_emp['emp_id']; ?></div>
                <div class="col-md-2" >Date:</div>
                <div class="col-md-3" ><?php print $nowdate; ?></div>
              </div>
              <div class="row">
                <div class="col-md-2"  >Employee Name:</div>
                <div class="col-md-5" ><?php print $default_emp['emp_name']; ?></div>
                  <div class="col-md-2"  >Joining Date:</div>
                  <div class="col-md-3" ><?php print $default_emp['joining_date']; ?></div>                  
 
              </div>  
          
                <div class="row">
                <div class="col-md-2" >Designation:</div>
                <div class="col-md-5"><?php 
                  $emp_post_id = $default_emp['emp_post_id']; 
                  $emp_post_id_data=$this->taxonomy->getTaxonomyBytid($emp_post_id);
                  print $emp_post_id_data['name']; 
                  ?></div> 
                  <div class="col-md-2">Service Length:</div> 
                  <div class="col-md-3" style="font-size: 12px;"><?php 
                   $joining_date_arr=explode('-',$default_emp['joining_date']);
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
                  $string = rtrim(implode(',', $pieces), ',');
                  echo $string;
                  // echo substr($removed, 0, -21);
                  ?></div>
                </div> 
              </div>
              
<div class="row">
  <div class="col-md-12">
  <table  class="pop-up-table" cellspacing="0" width="100%" border="1">
    <thead>
      <tr class="heading">                                
        <th>Gross Salary</th>
        <th>Increament Amount</th>
        <th>Increament Percentage</th>
        <th>Fulfill Date</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $salary_join_counter=1;
      $salary_count=count($salary_allamount_ascorder);
      foreach ($salary_allamount_ascorder as $single_salary) {
        $gross_salary =$single_salary['gross_salary'];
        $increment_amount =$single_salary['increment_amount'];
        $increment_percentage =$single_salary['increment_percentage'];
        $increment_date =$single_salary['increment_date'];
        $id =$single_salary['id'];

        ?>
        <tr>                                    
          <td><?php print $gross_salary; ?></td>
          <td><?php print $increment_amount; ?></td>
          <td><?php print $increment_percentage; ?></td>
          <td><?php if($salary_join_counter==1){
            print $default_emp['joining_date'];
          }else{ print $increment_date; } ?>
        </td>
      </tr>
      <?php 
      $salary_join_counter++;
    } ?>
  </tbody>
</table>      
  </div>
</div>

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