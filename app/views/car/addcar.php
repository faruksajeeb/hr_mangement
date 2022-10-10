<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Car Information</title>
	<?php
	$this->load->view('includes/cssjs');	
	?> 
	<script> 
		function validate() {
			var valid = true;
				if ( document.myForm.vehicle_name.value == "" ) {
	            if (valid){ //only receive focus if its the first error
	            	document.myForm.vehicle_name.focus();
	            	document.myForm.vehicle_name.style.border="solid 1px red";
	            	valid = false;
	            	return false;
	            }
	        } 
				if ( document.myForm.vehicle_code.value == "" ) {
	            if (valid){ //only receive focus if its the first error
	            	document.myForm.vehicle_code.focus();
	            	document.myForm.vehicle_code.style.border="solid 1px red";
	            	valid = false;
	            	return false;
	            }
	        } 

	}

	$(document).ready(function(){

		var base_url='<?php echo base_url();?>';	
		$.ajax({
			type: "POST",
			url: ""+base_url+"addprofile/getactivetab",
			dataType: 'json',
			success: function (data) {
				if (data) {
					if(data !='Tab_1'){
						$('li[id="Tab_1"]').removeClass("activetab");
						$('li[id="Tab_1"]').addClass("nonactivetab");
						$('div[id="content_1"]').css({"display":"none"});
					}
					var tab_id=data.replace("Tab_", "");
					$('li[id="' + data + '"]').addClass("activetab");
					$('div[id="content_' + tab_id + '"]').css({"display":"block"});
				}
			}
		});

		$("ul.tabs li").click(function(){
			var activeid = $(this).attr("id"); 
			var base_url='<?php echo base_url();?>';
			var postData = {
				"activeid" : activeid
			};
			$.ajax({
				type: "POST",
				url: ""+base_url+"addprofile/getactivetab",
				data: postData,
				dataType:'json',
				success: function(data){
    // console.log(data);

}
});	
		});
		jQuery.validator.setDefaults({
			debug: true,
			success: "valid"
		});
		$( "#myForm" ).validate({
			rules: {
				vehicle_name: "required",
				vehicle_code: "required",
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
		function showActive()
		{
			var activeId = $(".activetab").attr("id");
			var splitid = activeId.split("_");
			var contentid = "content_"+splitid[1];
			$(".tabcontent").hide();
			$("#"+contentid).show();
		}

		$("ul.tabs li").click(function(){
			$("ul.tabs li").removeClass("activetab");
			$("ul.tabs li").addClass("nonactivetab");
			$(this).addClass("activetab");
			showActive();
		});

		showActive();


// load department by division

$('#default_driver').change(function(){
    var emp_id=$(this).val();
    $('#default_driver_code').val(emp_id);
});
$('#default_driver_code').keyup(function(){
  var emp_id=$("#default_driver_code").val();            
  $('#default_driver').val(emp_id);          
}); 
$('body').on('keydown', '.datepicker', function(e) {
	if (e.which == 9) {
		$(this).datepicker('hide');
        // do your code
    }
});    
    // prevent enter key to prevent form submitting 
    $(window).keydown(function(event){
    	if(event.keyCode == 13) {
    		$(this).next().focus();
    		event.preventDefault();
    		return false;
    	}
    });
    $('#myForm').find('input').keypress(function(e){
    if ( e.which == 13 ) // Enter key = keycode 13
    {
    }
});   

     // limit profile picture site
     $('#file').bind('change', function(event) {
     	var size_img=this.files[0].size/1024;
     	var final_size=float2int(size_img);
     	if(final_size>500){
     		alert('You must upload image lower 500KB size. This file size is: ' + final_size + "KB");
     		event.preventDefault();
     		return false;
     	}

     });
     function float2int (value) {
     	return value | 0;
     }
     $(".curr_doc_remove").click(function() {
     	var myid = $(this).attr("id-data");
     	var removed_img = $(this).attr("img-name");
     	$("#"+myid).val(removed_img);
     	$("li[id-hide="+myid+"]").hide();
   //alert(removed_img);
});
     



     $( document ).on( "keydown", function( event ) {
     	if (event.which == 77 && event.ctrlKey) {
  $("#vehicle_code").focus(); //ctrl+M
}        
if (event.which == 81 && event.ctrlKey) {
  $("#myForm").submit(); // ctrl+Q
}                          

});
     $(document).on('keydown', 'input#vehicle_code', function(e) { 
     	var keyCode = e.keyCode || e.which; 

    if (keyCode == 9) { //tab key
    	e.preventDefault(); 
    // call custom function here
    var vehicle_code = $("#vehicle_code").val(); 
    var base_url='<?php echo base_url();?>';
    var postData = {
    	"vehicle_code" : vehicle_code
    };
    $.ajax({
    	type: "POST",
    	url: ""+base_url+"vahicles/getcarcodeid",
    	data: postData,
    	dataType:'json',
    	success: function(data){
    		if (data) {
    			window.location.href = "" + base_url + "vahicles/addcar/"+data;
    		}else{
    			$("#vehicle_owner").focus();     	
    		}
    	}

    });
    
} 
});


// document.ready end
});

function ConfirmDelete()
{
	var x = confirm("Are you sure you want to delete?");
	if (x)
		return true;
	else
		return false;
}
</script>
<?php 

date_default_timezone_set('Asia/Dhaka');
$servertime = time();
$now = date("d-m-Y", $servertime);
if($car_info['id']){
$id=$car_info['id'];
$vehicle_code=$car_info['Car_Code'];
$vehicle_name=$car_info['Vehicle_Name'];
$vehicle_owner=$car_info['Vehicle_Owner'];
$vehicle_model=$car_info['Vehicle_Model'];
$vehicle_model_year=$car_info['Model_Year'];
$purchase_date=$car_info['Purchase_Date'];
$vehicle_plate=$car_info['Plate'];
$Total_Seats=$car_info['Total_Seats'];
$make=$car_info['Make'];
$Chassis_number=$car_info['Chassis_number'];
$engine=$car_info['Engine']; 
$transmission=$car_info['Transmission'];
$tire_size=$car_info['Tire_Size']; 
$vehicle_color=$car_info['Color']; 
$notes=$car_info['Notes']; 
$insurance_company=$car_info['Insurance_Company'];
$insurance_account=$car_info['Insurance_Account']; 
$insurance_premium=$car_info['Insurance_Premium']; 
$insurance_due=$car_info['Insurance_Due']; 
$insurance_paid_date=$car_info['Insurance_Date']; 
$Route_Permit_date=$car_info['Route_Permit_Date']; 
$Route_Permit_cost=$car_info['Route_Permit_Cost']; 
$tax_token_date=$car_info['Tax_Token_Date']; 
$tax_renewal_date=$car_info['Tax_Renewal_Date']; 
$Tax_Cost=$car_info['Tax_Cost']; 
$fitness_expire=$car_info['Fitness_Exp']; 
$Fitness_Cost=$car_info['Fitness_Cost']; 
$plate_renewal_date=$car_info['Plate_Renewal_Date']; 
$car_status=$car_info['Car_Status']; 
$status_date=$car_info['Car_Status_Date']; 
$Driver_Phone=$car_info['default_driver_phone']; 
$default_driver_emp_id=$car_info['default_driver_emp_id']; 
if($default_driver_emp_id){
	$emp_code=$this->employee_id_model->getemp_codeby_empid($default_driver_emp_id);
}

foreach ($car_documents as $value) {
	if($value['field_name']=='resources/uploads/cars'){
		$picture=$value['field_value'];
	}
}
}
// echo "<pre>";
// print_r($car_info);
// echo "</pre>";
?>    
<style type="text/css">
	#add_vehicle_btn {
		padding: 8px;
		/*background: #DCEDF6;*/

	}

</style>
</head>
<body class="logged-in dashboard">
	<!-- Page Content -->  
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<?php 
			$this -> load -> view('includes/menu');
			?>
			<div class="row under-header-bar text-center"> 
				<h4>Car Information</h4>         
			</div> 
			<div class="wrapper">
				<div class="row">
					<div class="col-md-12">
						<?php 
						print $this->session->flashdata('errors'); 
						print $this->session->flashdata('success'); 
						?>
						<form action="<?php echo base_url(); ?>vahicles/do_upload" method="post" class="myForm" id="myForm"  name="myForm" onSubmit="return validate();" enctype="multipart/form-data">
							<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
							<input type="hidden" id="current_img" name="current_img" value="<?php echo $picture;?>">                    
							<div class="row ">
								<div class="col-md-12">
									<input type="submit" id="add_vehicle_btn" value="Save">
									<a href="<?php echo base_url(); ?>vahicles/addcar" class="new-entry-link">New</a>
								</div>
							</div>							

							<div class="row custom-row-radious2">                 
								<div class="tabs">
									<ul class="tabs">
										<li class="activetab" id="Tab_1"> Car Information </li>
										<!-- <li class="nonactivetab" id="Tab_2"> Documents </li>                    -->
									</ul>
									<div class="tabcontent" id="content_1">
										<div class="row">
											<div class="col-md-12 heading_style">
												Car Info
											</div>
										</div>									
										<div class="row">
											<div class="col-md-10">
												<div class="row">
													<div class="col-md-6">
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Vehicle Name</div>
															<div class="col-md-8">
																<input type="text" id="vehicle_name" name="vehicle_name" value="<?php if($vehicle_name){ print $vehicle_name;} ?>">        
															</div>
														</div>			 										
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Vehicle Code</div>
															<div class="col-md-8"><input type="text" name="vehicle_code" id="vehicle_code" autocomplete="off" value="<?php if($vehicle_code){ echo $vehicle_code;} ?>"/></div>
														</div>	
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Vehicle Owner</div>
															<div class="col-md-8"><input type="text" name="vehicle_owner" id="vehicle_owner" value="<?php if($vehicle_owner){ echo $vehicle_owner;} ?>"/></div>
														</div> 																										
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Vehicle Model</div>
															<div class="col-md-8"><input type="text" name="vehicle_model" id="vehicle_model" value="<?php if($vehicle_model){ echo $vehicle_model;} ?>"/></div>
														</div>
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Year of Manufa.</div>
															<div class="col-md-8"><input type="text" name="vehicle_model_year" id="vehicle_model_year" value="<?php if($vehicle_model_year){ echo $vehicle_model_year;} ?>"/></div>
														</div>                                  
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Purchase Date</div>
															<div class="col-md-8"><input type="text" name="purchase_date" id="purchase_date"  class="datepicker numbersOnly" placeholder="dd-mm-yyyy"  value="<?php if($purchase_date){ echo $purchase_date;} ?>"/></div>
														</div>  
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Plate/ Tag</div>
															<div class="col-md-8">
																<input type="text" name="vehicle_plate" id="vehicle_plate" value="<?php if($vehicle_plate){ echo $vehicle_plate;} ?>"/>      
															</div>
														</div>                                       
													</div>
													<div class="col-md-6">
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Total Seats</div>
															<div class="col-md-8">
																<input type="text" name="Total_Seats" id="Total_Seats" value="<?php if($Total_Seats){ echo $Total_Seats;} ?>"/>         
															</div>
														</div> 
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Maker’s name</div>
															<div class="col-md-8"><input type="text" name="make" id="make" value="<?php if($make){ echo $make;} ?>"/></div>
														</div>  
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Chassis number</div>
															<div class="col-md-8"><input type="text" name="Chassis_number" id="Chassis_number" value="<?php if($Chassis_number){ echo $Chassis_number;} ?>"/></div>
														</div>  
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Engine number</div>
															<div class="col-md-8">
																<input type="text" name="engine" id="engine" value="<?php if($engine){ echo $engine;} ?>"/>        
															</div>
														</div> 
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Transmission</div>
															<div class="col-md-8">
																<input type="text" name="transmission" id="transmission" value="<?php if($transmission){ echo $transmission;} ?>"/>        
															</div>
														</div>
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Tire Size</div>
															<div class="col-md-8">
																<input type="text" name="tire_size" id="tire_size" value="<?php if($tire_size){ echo $tire_size;} ?>"/>
															</div>
														</div>
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Color</div>
															<div class="col-md-8"><input type="text" name="vehicle_color" id="vehicle_color" value="<?php if($vehicle_color){ echo $vehicle_color;} ?>"/></div>
														</div> 
													</div>
												</div>
												<div class="row">
													<div class="col-md-2 bgcolor_D8D8D8">Notes</div>
													<div class="col-md-10">
														<textarea rows="3" name="notes" id="notes"><?php if($notes){ echo $notes;} ?></textarea>
													</div>
												</div>
											</div>

											<div class="col-md-2">
												<div class="row">
													<!-- <div class="col-md-5 bgcolor_D8D8D8">Mother's Name</div> -->
													<div class="col-md-7">
														<div id="filefield">
															<?php if($picture){?>
															<img src="<?php echo base_url();?>resources/uploads/cars/<?php echo $picture;?>" id="preview" width="" style="max-width: 143px;max-height: 150px;" />
															<?php }else{?>
															<img src="<?php echo base_url();?>resources/images/avater.png" id="preview" width="160px" height="160px" style="margin-left:-15px;"/>
															<?php } ?>
															<div id="filediv"><input name="file[]" type="file" id="file" style="width: inherit;" /></div>
														</div>
													</div>
												</div>       
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 heading_style">
												Insurance Info
											</div>
										</div>	
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Company</div>
														<div class="col-md-8">
															<input type="text" id="insurance_company" name="insurance_company" value="<?php if($insurance_company){ print $insurance_company;} ?>">        
														</div>
													</div>	
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Premium</div>
														<div class="col-md-8">
															<input type="text" id="insurance_premium" name="insurance_premium" value="<?php if($insurance_premium){ print $insurance_premium;} ?>">        
														</div>
													</div>	
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Insurance Due Date</div>
														<div class="col-md-8">
															<input type="text" id="insurance_due" name="insurance_due" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if($insurance_due){ print $insurance_due;} ?>">        
														</div>
													</div>																																			
												</div>
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Account</div>
														<div class="col-md-8">
															<input type="text" id="insurance_account" name="insurance_account" value="<?php if($insurance_account){ print $insurance_account;} ?>">        
														</div>
													</div>	
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Insurance Date</div>
														<div class="col-md-8">
															<input type="text" id="insurance_paid_date" name="insurance_paid_date" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if($insurance_paid_date){ print $insurance_paid_date;} ?>">        
														</div>
													</div>																								
												</div>											
											</div>											
										</div>
										<div class="row">
											<div class="col-md-12 heading_style">
												Route Permit Info
											</div>
										</div>
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Route Permit Date</div>
														<div class="col-md-8">
															<input type="text" id="Route_Permit_date" name="Route_Permit_date" class="datepicker numbersOnly" placeholder="dd-mm-yyyy"  value="<?php if($Route_Permit_date){ print $Route_Permit_date;} ?>">        
														</div>
													</div>																							
												</div>
												<div class="col-md-6">

													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Route Permit Cost</div>
														<div class="col-md-8">
															<input type="text" id="Route_Permit_cost" name="Route_Permit_cost" onkeypress="return isNumber(event);" value="<?php if($Route_Permit_cost){ print $Route_Permit_cost;} ?>">        
														</div>
													</div>																								
												</div>											
											</div>											
										</div>										
										<div class="row">
											<div class="col-md-12 heading_style">
												Fitness Info
											</div>
										</div>
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Fitness I Date</div>
														<div class="col-md-8">
															<input type="text" id="fitness_expire" name="fitness_expire" class="datepicker numbersOnly" placeholder="dd-mm-yyyy"  value="<?php if($fitness_expire){ print $fitness_expire;} ?>">        
														</div>
													</div>													
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Fitness Expire Date</div>
														<div class="col-md-8">
															<input type="text" id="fitness_expire" name="fitness_expire" class="datepicker numbersOnly" placeholder="dd-mm-yyyy"  value="<?php if($fitness_expire){ print $fitness_expire;} ?>">        
														</div>
													</div>																							
												</div>
												<div class="col-md-6">

													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Fitness Cost</div>
														<div class="col-md-8">
															<input type="text" id="fitness_cost" name="fitness_cost" onkeypress="return isNumber(event);" value="<?php if($Fitness_Cost){ print $Fitness_Cost;} ?>">        
														</div>
													</div>																								
												</div>											
											</div>											
										</div>																					
										<div class="row">
											<div class="col-md-12 heading_style">
												Tax Info
											</div>
										</div>	
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Tax Token Date</div>
														<div class="col-md-8">
															<input type="text" id="tax_token_date" name="tax_token_date" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if($tax_token_date){ print $tax_token_date;} ?>">        
														</div>
													</div>	
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Tax Renewal Date</div>
														<div class="col-md-8">
															<input type="text" id="tax_renewal_date" name="tax_renewal_date" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if($tax_renewal_date){ print $tax_renewal_date;} ?>">        
														</div>
													</div>																							
												</div>
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Tax Cost</div>
														<div class="col-md-8">
															<input type="text" id="tax_cost" name="tax_cost" onkeypress="return isNumber(event);" value="<?php if($Tax_Cost){ print $Tax_Cost;} ?>">        
														</div>
													</div>	
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Plate Renewal Date</div>
														<div class="col-md-8">
															<input type="text" id="plate_renewal_date" name="plate_renewal_date" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if($plate_renewal_date){ print $plate_renewal_date;} ?>">        
														</div>
													</div>																								
												</div>											
											</div>											
										</div>	
										<div class="row">
											<div class="col-md-12 heading_style">
												Car Status Info
											</div>
										</div>	
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Car Status</div>
														<div class="col-md-8">
														<select name="car_status" id="car_status">
															<option value="Active" <?php if($car_status=="Active"){ echo 'selected="selected"';} ?> >Active</option>
															<option value="Inactive" <?php if($car_status=="Inactive"){ echo 'selected="selected"';} ?>>Inactive</option>
															<option value="Sold" <?php if($car_status=="Sold"){ echo 'selected="selected"';} ?>>Sold</option>
															<option value="Damaged" <?php if($car_status=="Damaged"){ echo 'selected="selected"';} ?>>Damaged</option>
															<option value="Stolen" <?php if($car_status=="Stolen"){ echo 'selected="selected"';} ?>>Stolen</option>
														</select>        
														</div>
													</div>																								
												</div>
												<div class="col-md-6">	
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Status Date</div>
														<div class="col-md-8">
															<input type="text" id="status_date" name="status_date" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if($status_date){ print $status_date;} ?>">        
														</div>
													</div>																								
												</div>											
											</div>											
										</div>	
										<div class="row">
											<div class="col-md-12 heading_style">
												Default Driver Info
											</div>
										</div>	
										<div class="col-md-12">
											<div class="row">
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Driver code</div>
														<div class="col-md-8">
														<input type="text" name="default_driver_code" id="default_driver_code" value="<?php if($emp_code){ print $emp_code; } ?>" >       
														</div>
													</div>	
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Driver Name</div>
														<div class="col-md-8">
														<select name="default_driver" id="default_driver">
						                                    <option value="">Select</option>
						                                    <?php foreach ($allemployee as $single_employee) {
						                                        $content_id=$single_employee['content_id'];
						                                        $emp_id=$single_employee['emp_id'];
						                                        $emp_name=$single_employee['emp_name'];
						                                        if($emp_code==$emp_id){
						                                            print '<option value="'.$emp_id.'" selected="selected">'.$emp_name.'-'.$emp_id.'</option>';
						                                        }else{
						                                            print '<option value="'.$emp_id.'">'.$emp_name.'-'.$emp_id.'</option>';
						                                        }

						                                    } ?>
														</select>        
														</div>
													</div>																																				
												</div>
												<div class="col-md-6">	
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Driver Phone</div>
														<div class="col-md-8">
															<input type="text" id="Driver_Phone" name="Driver_Phone" value="<?php if($Driver_Phone){ print $Driver_Phone;} ?>">        
														</div>
													</div>																								
												</div>											
											</div>											
										</div>																					
										<div class="row">
											<div class="col-md-12 heading_style">
												Documents Upload
											</div>
										</div>										
										<?php if($documents){  ?>
										<div class="row">
											<div class="col-md-12">

												<ul style="list-style-type: disc;  margin-left: 20px;">     
													<?php 
													// echo "<pre>";
													// print_r($documents);
													// echo "</pre>";
													foreach ($documents as $single_documents) {
														$file_name=$single_documents['field_value'];
														$file_location=$single_documents['field_name'];
														$file_repeat=$single_documents['field_repeat'];
														echo '<li style="margin-bottom:10px" id-hide="curr_doc_'.$file_repeat.'" class="current_doc_'.$file_repeat.'" ><input type="hidden" id="curr_doc_'.$file_repeat.'" name="curr_doc_['.$file_repeat.']" value=""><a href="'.base_url().$file_location.'/'.$file_name.'" target="_blank" >'.substr($file_name, 11, -4).'</a> <a  id-data="curr_doc_'.$file_repeat.'" class="curr_doc_remove" img-name="'.$file_name.'">Remove</a></li>';
													}

													?>
												</ul>

											</div>
										</div> 
										<?php } ?> 
										<div class="row">
											<div class="col-md-12 default-input-width">
												<div class="documentsdiv">
													<input  name="documents[]" type="file" class="documents1" multiple=""/>
													<br /><br />
												</div>
												<div class="documentsdiv">
													<!-- <input name="documents[]" type="file" class="documents1" /> -->
												</div>
												<input type="button" id="add_more_file"  class="upload" value="Add More Files"/>
											</div>
										</div>																																								
									</div>                     
								</div>
							</div>
						</div>
					</div>
				</div> 
			</form>             
		</div>
	</div>
	<!-- /#page-content-wrapper -->           
</div> 
<!-- /#wrapper -->       
</body>
</html>