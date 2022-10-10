<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Car Cost</title>
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
                        cost_type: "required",
                        Car_Name: "required",
                        cost_amount: "required",
                        car_cost_date : {required: true, mydate : true },
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
  if ( document.myForm.cost_type.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.cost_type.focus();
      document.myForm.cost_type.style.border="solid 1px red";
      msg+="<li>You need to fill the cost_type field!</li>";
      valid = false;
      return false;
  }
} 
if ( document.myForm.Car_Name.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.Car_Name.focus();
      document.myForm.Car_Name.style.border="solid 1px red";
      msg+="<li>You need to fill the Car_Name field!</li>";
      valid = false;
      return false;
  }
}
if ( document.myForm.car_cost_date.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.car_cost_date.focus();
      document.myForm.car_cost_date.style.border="solid 1px red";
      msg+="<li>You need to fill the car_cost_date field!</li>";
      valid = false;
      return false;
  }
}
if ( document.myForm.cost_amount.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.cost_amount.focus();
      document.myForm.cost_amount.style.border="solid 1px red";
      msg+="<li>You need to fill the cost_amount field!</li>";
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
<body class="logged-in dashboard current-page add-carcost">
    <!-- Page Content -->  
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php 
            $this -> load -> view('includes/menu');
            ?>
            <div class="row under-header-bar text-center"> 
                <h4>Add Car Cost</h4>         
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url(); ?>carcost/addcarcost" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                            <div class="row success-err-sms-area">
                                <div class="col-md-12">
                                    <input type="hidden" name="cost_id" id="cost_id" value="<?php print $toedit_id; ?>">
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
                                        <div class="col-md-3 bgcolor_D8D8D8">Cost Type</div>
                                        <div class="col-md-9">
                                            <select name="cost_type" id="cost_type">
                                                <option value="">Select Cost Type</option>
												<?php foreach ($allcosttype as $single_costtype) {
													if($cost_info['Cost_Type']==$single_costtype['tid']){
														echo '<option value="'.$single_costtype['tid'].'" selected="selected">'.$single_costtype['name'].'</option>';
													}else{
														echo '<option value="'.$single_costtype['tid'].'">'.$single_costtype['name'].'</option>';
													}
												} ?>
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Car Name</div>
                                        <div class="col-md-9">
											<select name="Car_Name" id="Car_Name">
                                                <option value="">Select Car Name</option>
                                                    <?php foreach ($allactivecar as $single_car) {
                                                        if($cost_info['car_id']==$single_car['id']){
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
                                        <div class="col-md-9"><input type="text" name="Car_Code" id="Car_Code" placeholder="Write Car Code or select Car Name" autocomplete="off" /></div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Buyer</div>
                                        <div class="col-md-9">
                                                <select name="cost_buyer" id="cost_buyer">
                                                    <option value="">Select Name</option>
                                                     <?php foreach ($alltransportemployee as $single_employee) {
                                                       if($cost_info['buyer']==$single_employee['content_id']){                                                           
                                                        echo '<option value="'.$single_employee['content_id'].'" selected="selected">'.$single_employee['emp_name'].'-'.$single_employee['emp_id'].'</option>';
                                                        }else{
                                                            echo '<option value="'.$single_employee['content_id'].'">'.$single_employee['emp_name'].'-'.$single_employee['emp_id'].'</option>';
                                                        }
                                                    } ?>
                                                </select>  
                                        </div>
                                    </div>                                                                      
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Cost Amount</div>
                                        <div class="col-md-9"><input type="text" name="cost_amount" onkeypress="return isNumber(event);" id="cost_amount" autocomplete="off" value="<?php print $cost_info['Cost_Amount'] ?>"/></div>
                                    </div>   
<!--                                     <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Drived Location</div>
                                        <div class="col-md-9"><input type="text" name="drived_location" id="drived_location" autocomplete="off"  value="<?php print $cost_info['Drived_Location'] ?>"/></div>
                                    </div>                                     
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Drived km</div>
                                        <div class="col-md-9"><input type="text" name="drived_km" id="drived_km" autocomplete="off" value="<?php print $cost_info['Drived_km'] ?>"/></div>
                                    </div> -->                                                                       
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Cost Date:</div>
                                        <div class="col-md-9"><input type="text" name="car_cost_date" class="datepicker numbersOnly" id="car_cost_date" value="<?php if($cost_info['Cost_Date']){ print $cost_info['Cost_Date']; }else{ print $today_date; } ?>" placeholder="dd-mm-yyyy"></div>
                                    </div>                                           
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Remarks:</div>
                                        <div class="col-md-9">
                                        <textarea name="remarks" id="remarks" cols="30" rows="10"><?php print $cost_info['Remarks'] ?></textarea>
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