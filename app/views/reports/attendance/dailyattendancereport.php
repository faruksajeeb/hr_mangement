<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HRMS | Division wise daily attendance</title>
  <?php
  $this->load->view('includes/cssjs');
  date_default_timezone_set('Asia/Dhaka');
  $servertime = time();
  $today_date = date("d-m-Y", $servertime); 
  $user_type = $this->session->userdata('user_type');
  ?> 
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.form.min.js"></script>
  <script>
    $(document).ready(function(){ 
//      $('#division_code').keyup(function(){
//        var division_code=$("#division_code").val();  
//        $("#emp_division option[data-id='" + division_code + "']").prop('selected', true);                   
//      });  
//      $('#emp_division').change(function(){
//        var division_code = $("#emp_division").find('option:selected').attr("data-id"); 
//        $('#division_code').val(division_code);
//      });
$( "#emp_company" ).change(function(e) {
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
            $('#emp_division').html(options);    
        }
        });
    });
     $('.submit-query').click(function(){
//         alert(0);
                        var emp_company=$('#emp_company').val(); 
                        validate();
                        if(emp_company == ''){
                            alert('Please select company');
                        }else{
                        var emp_division=$('#emp_division').val();        
                        var emp_attendance_start_date=$('#emp_attendance_start_date').val();    
                          //show the loading div here
                           $('.display_report').hide("fade","fast");
                           $("#loader").show("fade","slow");
                          
                          
                        $('#myForm').ajaxSubmit({
                            type: "POST",
                            url: "<?php echo base_url(); ?>reports/dailyAttendance",
                            data:{ 
                                emp_company:emp_company,
                                emp_division:emp_division,
                                emp_attendance_start_date:emp_attendance_start_date
                            },            
                            dataType: 'html', // what to expect back from the server
                            
                            success: function (data) {
                                //then close the window 
//                                alert(data);
                                $("#loader").hide("fade","fast");
                                 
                                 $('.display_report').show("fade","slow");
                                $('.display_report').html(data);

                            }
                        });
//                        return false; 
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
      if ( document.myForm.emp_company.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.emp_company.focus();
      document.myForm.emp_company.style.border="solid 1px red";
      msg+="<li>You need to fill the emp_company field!</li>";
      valid = false;
      return false;
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
              <h4>Daily Attendance Reports</h4>         
            </div> 
            <div class="wrapper">
              <div class="row">
                <div class="col-md-12">
                  <form action="" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
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
                            <select name="emp_company" id="emp_company">
                                  <?php 
                                   if($user_type_id !=1){
                                        echo '<option value="">Select Company</option>';
                                    echo '<option value="'.$alldivision['tid'].'"  data-id="'.$alldivision['weight'].'">'.$alldivision['name'].'</option>';
                                   }else{
                                    echo '<option value="">Select Company</option>';
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
                        <div class="col-md-3 bgcolor_D8D8D8">Division/ Branch: </div>
                          <div class="col-md-9">
                            <select name="emp_division" id="emp_division">
                                  <option value="" >All</option>
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
                          <div class="col-md-3 bgcolor_D8D8D8">Attendance Date:</div>
                          <div class="col-md-9"><input type="text" name="emp_attendance_start_date" class="datepicker numbersOnly" id="emp_attendance_start_date" value="<?php if($default_date){ print $default_date; }else{ print $today; } ?>" placeholder="dd-mm-yyyy"></div>
                        </div> 
                        <div class="row top10 bottom10">
                          <div class="col-md-3"></div>
                          <div class="col-md-9">
                               <button type="button" class="btn btn-warning submit-query" name="textfield" id="textfield" class="form-control daterangepick" value="SUBMIT">SUBMIT <span class="glyphicon glyphicon-arrow-right"> </span></button>
                   
                              <!--<input type="submit" name="add_attendance_btn" value="Submit">-->
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2"></div>
                    </div>
                  </form>
                    <div id="loader" style="text-align:center; display:none;">
                                 <div>Please be patient, report is being processed.</div>
                                  <img src="<?php echo base_url()?>resources/images/200.gif" alt="Loading..."/>
                                 <!-- Start Report -->
                            </div>
                            <div class="display_report">
                               
                            
                            <!-- End Report -->
                            </div>
                  
                                            
                    </div>
                  </div>              
                </div>
              </div>
              <!-- /#page-content-wrapper -->
            </div>
            <!-- /#wrapper -->        
          </body>
          </html>