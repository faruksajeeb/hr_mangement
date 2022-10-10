<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Car Requisition</title>
    <?php
    $this->load->view('includes/cssjs');
    date_default_timezone_set('Asia/Dhaka');
    $servertime = time();
    $today_date = date("d-m-Y", $servertime);    
    $today_time = date("d-m-Y", $servertime);    
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
                        Requisition_Date: "required",
                        Requisition_Location: "required",
                        Requisition_Time: {time: true}, 
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

                $('#emp_id').keyup(function(){
                  var emp_id=$("#emp_id").val(); 
                  $("#emp_name").val(emp_id); 
                 // $('#emp_name option[carid="' + emp_id +'"]').prop('selected',true);                                    
                });  
   
 
            $( "#emp_name" ).change(function(e) {
                var emp_name_id = $(this).val(); 
                //var emp_id = $('option:selected', this).attr('carid');
                $("#emp_id").val(emp_name_id); 
                $("#Requisition_Time").focus(); 
            });

                $('#Car_Code').keyup(function(){
                  var Car_Code=$("#Car_Code").val(); 
                  $('#Car_Name option[carid="' + Car_Code +'"]').prop('selected',true);                   
                });  
   
 
            $( "#Car_Name" ).change(function(e) {
                var Car_Name_id = $(this).val(); 
                var Car_code = $('option:selected', this).attr('carid');
                $("#Car_Code").val(Car_code); 
                $("#fuel_litres").focus(); 
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
if ( document.myForm.Requisition_Date.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.Requisition_Date.focus();
      document.myForm.Requisition_Date.style.border="solid 1px red";
      msg+="<li>You need to fill the Requisition_Date field!</li>";
      valid = false;
      return false;
  }
}
if ( document.myForm.Requisition_Location.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.Requisition_Location.focus();
      document.myForm.Requisition_Location.style.border="solid 1px red";
      msg+="<li>You need to fill the Requisition_Location field!</li>";
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
<?php 

?>
</head>
<body class="logged-in dashboard current-page add-carcost">
    <!-- Page Content -->  
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php 
            $this -> load -> view('includes/menu');
            ?>
            <div class="row under-header-bar text-center"> 
                <h4>Add Car Requisition</h4>         
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url(); ?>vahicles/addrequisition" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                            <div class="row success-err-sms-area">
                                <div class="col-md-12">
                                    <input type="hidden" name="id" id="id" value="<?php print $toedit_id; ?>">
                                    <div id="errors"></div>
                                    <?php 
                                    print $this->session->flashdata('errors'); 
                                    print $this->session->flashdata('success');
                                    print $this->session->userdata('success');
                                    $this->session->set_userdata("success", "");
                                    ?>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-md-2"></div>
                                <div class="col-md-8">                                                 
		                        <div class="row">
		                            <div class="col-md-3 bgcolor_D8D8D8">Requester Name</div>
		                            <div class="col-md-9">
		                                <select name="emp_name" id="emp_name">
		                                    <option value="">Select</option>
		                                    <?php foreach ($allemployee as $single_employee) {
		                                        $default_emp_id=$default_emp['emp_id'];
		                                        $content_id=$single_employee['content_id'];
		                                        $emp_id=$single_employee['emp_id'];
		                                        $emp_name=$single_employee['emp_name'];
		                                        if($requisition_info['requester_content_id']==$content_id){
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
                                    <?php 
                                        if($requisition_info['requester_content_id']){
                                            $emp_code=$this->employee_id_model->getemp_codeby_empid($requisition_info['requester_content_id']);
                                        }
                                    ?>
		                            <div class="col-md-9"><input type="text" name="emp_id" id="emp_id" autocomplete="off" value="<?php if($emp_code){ echo $emp_code;} ?>"/></div>
		                        </div>                          
		                        <div class="row">
		                            <div class="col-md-3 bgcolor_D8D8D8">Requisition Date</div>
		                            <div class="col-md-9"><input type="text" name="Requisition_Date" id="Requisition_Date" class="datepicker numbersOnly" value="<?php if($requisition_info['Requisition_Date']){ print $requisition_info['Requisition_Date']; }else{ print $today_date; } ?>" placeholder="dd-mm-yyyy"/></div>
		                        </div> 
								<div class="row">
		                            <div class="col-md-3 bgcolor_D8D8D8">Requisition Time</div>
		                            <div class="col-md-9"><input type="text" name="Requisition_Time" id="Requisition_Time" placeholder="e.g. hh:mm:ss" value="<?php if($requisition_info['Requisition_Time']){ echo $requisition_info['Requisition_Time'];}else{ echo "09:30:00";} ?>"/></div>
		                        </div>
								<div class="row">
		                            <div class="col-md-3 bgcolor_D8D8D8">Purpose</div>
		                            <div class="col-md-9"><input type="text" name="purpose" id="purpose" value="<?php if($requisition_info['purpose']){ echo $requisition_info['purpose'];} ?>"/></div>
		                        </div>	
								<div class="row">
		                            <div class="col-md-3 bgcolor_D8D8D8">Requisition Location</div>
		                            <div class="col-md-9"><input type="text" name="Requisition_Location" id="Requisition_Location" value="<?php if($requisition_info['Requisition_Location']){ echo $requisition_info['Requisition_Location'];} ?>"/></div>
		                        </div>	
								<div class="row">
		                            <div class="col-md-3 bgcolor_D8D8D8">Location Distance KM</div>
		                            <div class="col-md-9"><input type="text" name="Location_Distance" id="Location_Distance" onkeypress="return isNumber(event);" value="<?php if($requisition_info['Location_Distance']){ echo $requisition_info['Location_Distance'];} ?>"/></div>
		                        </div>		                        		                        	                        		                        
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Car Name</div>
                                        <div class="col-md-9">
											<select name="Car_Name" id="Car_Name">
                                                <option value="">Select Car Name</option>
                                                    <?php foreach ($allactivecar as $single_car) {
                                                        if($requisition_info['Car_Code']==$single_car['id']){
                                                            echo '<option value="'.$single_car['id'].'" carid="'.$single_car['Car_Code'].'" selected="selected">'.$single_car['Vehicle_Name'].'</option>';
                                                        }else if($single_car['Vehicle_Name']){
                                                            echo '<option value="'.$single_car['id'].'" carid="'.$single_car['Car_Code'].'">'.$single_car['Vehicle_Name'].'</option>';
                                                        }
                                                    } ?>
                                            </select>
                                        </div>
                                    </div>                                                                   
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Car Code</div>
                                        <?php 
                                        if($requisition_info['Car_Code']){
                                            $car_code_info=$this->car_info_model->getcar_info($requisition_info['Car_Code']);
                                        }                                        
                                       
                                        ?>
                                        <div class="col-md-9"><input type="text" name="Car_Code" id="Car_Code" placeholder="Write Car Code or select Car Name" autocomplete="off" value="<?php if($car_code_info['Car_Code']){ echo $car_code_info['Car_Code'];} ?>" /></div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Driver Name</div>
                                        <div class="col-md-9">
                                                <select name="driver_content_id" id="driver_content_id">
                                                    <option value="">Select Name</option>
                                                     <?php foreach ($alltransportemployee as $single_employee) {
                                                       if($requisition_info['driver_content_id']==$single_employee['content_id']){                                                           
                                                        echo '<option value="'.$single_employee['content_id'].'" selected="selected">'.$single_employee['emp_name'].'-'.$single_employee['emp_id'].'</option>';
                                                        }else{
                                                            echo '<option value="'.$single_employee['content_id'].'">'.$single_employee['emp_name'].'-'.$single_employee['emp_id'].'</option>';
                                                        }
                                                    } ?>
                                                </select>  
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Requisition Status</div>
                                        <div class="col-md-9">
                                                <select name="Requisition_Status" id="Requisition_Status">
                                                    <option value="2" <?php if($requisition_info['status']=="2"){ print 'selected="selected"'; } ?> >Pending</option>                                                    
                                                    <option value="1" <?php if($requisition_info['status']=="1"){ print 'selected="selected"'; } ?>>Approved</option>
                                                    <option value="3" <?php if($requisition_info['status']=="3"){ print 'selected="selected"'; } ?>>Cancel</option>
                                                </select>  
                                        </div>
                                    </div>                                                                                                             
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Remarks:</div>
                                        <div class="col-md-9">
                                        <textarea name="remarks" id="remarks" cols="30" rows="10"><?php print $requisition_info['notes'] ?></textarea>
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