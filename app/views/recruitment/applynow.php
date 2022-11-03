<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Employee Master</title>
	<?php
	$this->load->view('includes/cssjs');	
	?> 
	<script>  
		function validate() {
			var valid = true;
     	

	}
	function getAge(birthDate) {
		var now = new Date();

		function isLeap(year) {
			return year % 4 == 0 && (year % 100 != 0 || year % 400 == 0);
		}

      // days since the birthdate    
      var days = Math.floor((now.getTime() - birthDate.getTime())/1000/60/60/24);
      var age = 0;
      // iterate the years
      for (var y = birthDate.getFullYear(); y <= now.getFullYear(); y++){
      	var daysInYear = isLeap(y) ? 366 : 365;
      	if (days >= daysInYear){
      		days -= daysInYear;
      		age++;
          // increment the age only if there are available enough days for the year.
      }
  }
  return age;
}
$(document).ready(function(){
	

    var base_url='<?php echo base_url();?>';	
    jQuery.validator.setDefaults({
    	debug: true,
    	success: "valid"
    });
    $( "#myForm" ).validate({
    	rules: {
    		emp_name: "required",
    		emp_fathername: "required",	
    		emp_gender: "required",	
    		emp_age: "required",	
    		emp_qualification: "required",	
    		total_exp: "required",	
    		apply_date: "required",	
    		emp_dob : {mydate : true },	
    		emp_email: {
    			email: true
    		},
    		emp_alt_email:{
    			email: true
    		},
    // field: {
    //   required: true,
    //   email: true
    // }
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


    $('#emp_dob').blur(function() {
      // $(this).datepicker('hide');
      var datevalue=$('#emp_dob').val();
      var dateParts = datevalue.split("-");
      var date = new Date(dateParts[2], (dateParts[1] - 1), dateParts[0]);
    //console.log(datevalue);
    var final_age=getAge(date);
    if(final_age !=0){ 
    	$("#emp_age").val(final_age);
    }    
    
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



     $( document ).on( "keydown", function( event ) {
     	if (event.which == 77 && event.ctrlKey) {
  $("#emp_id").focus(); //ctrl+M
}        
if (event.which == 81 && event.ctrlKey) {
  $("#myForm").submit(); // ctrl+Q
}                          

});


     $('#same_address').change(function() {
     	if($(this).is(":checked")) {
     		var emp_parmanent_address = $('#emp_parmanent_address').val();
     		var emp_parmanent_city = $('#emp_parmanent_city').val();
     		var emp_parmanent_distict = $('#emp_parmanent_distict').val();
     		$('#emp_present_address').val(emp_parmanent_address);
     		$('#emp_present_city').val(emp_parmanent_city);
     		$('#emp_current_distict').val(emp_parmanent_distict);
     	}       
     });

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
// document.ready end
});

</script>
<?php
date_default_timezone_set('Asia/Dhaka');
$servertime = time();
$now = date("d-m-Y", $servertime);
?>    
<style type="text/css">
	.custom-row-radious2 {
		border-top: 1px solid #000;
	}	
	#add_profile_btn {
		padding: 8px;
		/*background: #DCEDF6;*/

	}
	.under-header-bar a{
    	color: #fff;
    	text-decoration: none;
    }
</style>
</head>
<body class="logged-in dashboard">
	<!-- Page Content -->  
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<?php 
			//$this -> load -> view('includes/menu');
			?>
			<div class="row header">
				<div class="col-md-2">
					<div class="logo">
						<img src="<?php echo base_url(); ?>resources/images/logo.png" alt="" id="logo-img"/>
					</div>
				</div>
				<div class="col-md-10">
					<div class="company_name">
						<h1>IIDFC Securities Limited</h1>
					</div>
				</div>               
			</div>			
			<div class="row under-header-bar text-center"> 
			             <div class="col-md-4"><a href="http://ahmedamin.com/dav/career-opportunity">CAREER HOME</a></div> 
             <div class="col-md-4"><a href="<?php echo site_url("recruitment_pub/viewcircular"); ?>">AVAILABLE JOBS</a></div> 
             <!-- <div class="col-md-4"><a href="<?php echo site_url("recruitment_pub/viewcircular"); ?>">USER LOGIN</a></div>  -->
                <!-- <h4>Available Jobs</h4>      -->
				<!-- <h4>Employee Registration</h4>          -->
			</div> 
			<div class="wrapper"> 
				<div class="row">
					<div class="col-md-12">
						<?php 
						print $this->session->flashdata('errors'); 
						print $this->session->flashdata('success'); 
						?>
						<form action="<?php echo base_url(); ?>recruitment_pub/do_upload" method="post" class="myForm" id="myForm"  name="myForm" onSubmit="return validate();" enctype="multipart/form-data">
							<input type="hidden" id="position_id" name="position_id" value="<?php echo $circular_details['position_id'];?>">
							<input type="hidden" id="circular_id" name="circular_id" value="<?php echo $circular_id;?>">
							<input type="hidden" id="current_img" name="current_img" value="<?php echo $picture;?>">                    
							<div class="row ">
								<div class="col-md-12">
									<input type="submit" id="add_profile_btn" value="Submit">
								</div>
							</div>							

							<div class="row custom-row-radious2">                 
								<div class="tabs">
									<ul class="tabs">
										<li class="activetab" id="Tab_1"> Employee Master </li>

										<li class="nonactivetab" id="Tab_4"> Experiences/Trainings</li>
										<!-- <li class="nonactivetab" id="Tab_5"> Education </li> -->
										<li class="nonactivetab" id="Tab_8"> Others </li>
										<!-- <li class="nonactivetab" id="Tab_10"> Documents </li>                    -->
									</ul>
									<div class="tabcontent" id="content_1">
										<div class="row">
											<div class="col-md-12 heading_style">
												Employee
											</div>
										</div>									
										<div class="row">
											<div class="col-md-10">
												<div class="row">
													<div class="col-md-6">

														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Name<span style="color:red;float:right">*</span></div>
															<div class="col-md-8"><input type="text" name="emp_name" id="emp_name" autocomplete="off" value="<?php if($emp_name){ echo $emp_name;} ?>"/></div>
														</div>                                 
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Nationality</div>
															<div class="col-md-8">
																<select name="emp_nationality" id="emp_nationality">
																	<option value="">Select Country</option>
																	<?php foreach ($country as $single_cntry) {
																		if($emp_nationality==$single_cntry['cou_code']){
																			echo '<option value="'.$single_cntry['cou_code'].'" selected="selected">'.$single_cntry['name'].'</option>';
																		}else if (!$emp_nationality && $single_cntry['cou_code']=='BD'){
																			echo '<option value="'.$single_cntry['cou_code'].'" selected="selected">'.$single_cntry['name'].'</option>';
																		}else{
																			echo '<option value="'.$single_cntry['cou_code'].'">'.$single_cntry['name'].'</option>';
																		}
																	} ?>
																</select>         
															</div>
														</div>  
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Gender<span style="color:red;float:right">*</span></div>
															<div class="col-md-8">
																<select name="emp_gender" id="emp_gender">
																	<option value="">Select Gender</option>
																	<option value="Male" <?php if($emp_gender=="Male"){ echo 'selected="selected"';}else if(!$emp_gender){echo 'selected="selected"';} ?>>Male</option>
																	<option value="Female" <?php if($emp_gender=="Female"){ echo 'selected="selected"';} ?>>Female</option>
																	<option value="Others" <?php if($emp_gender=="Others"){ echo 'selected="selected"';} ?>>Others</option>
																</select>         
															</div>
														</div> 

														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Date of Birth<span style="color:red;float:right">*</span></div>
															<div class="col-md-8"><input type="text" name="emp_dob" id="emp_dob" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if($emp_dob){ echo $emp_dob;} ?>"/></div>
														</div> 
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Age<span style="color:red;float:right">*</span></div>
															<div class="col-md-8"><input type="text" name="emp_age" id="emp_age" class="numbersdotOnly" value="<?php if($emp_age){ echo $emp_age;} ?>"/></div>
														</div> 
														<input type="hidden" id="emp_position" name="emp_position" value="<?php echo $emp_position;?>">
														<!-- <div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Position</div>
													<div class="col-md-8">
														<select name="emp_position" id="emp_position">
															<option value="">Select Position</option>
															<?php foreach ($alljobtitle as $single_jobtitle) {
																if($emp_position==$single_jobtitle['tid']){
																	echo '<option value="'.$single_jobtitle['tid'].'" selected="selected">'.$single_jobtitle['name'].'</option>';
																}else{
																	echo '<option value="'.$single_jobtitle['tid'].'">'.$single_jobtitle['name'].'</option>';
																}
															} ?>
														</select>         
													</div>
												</div> -->
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Qualification<span style="color:red;float:right">*</span></div>
													<div class="col-md-8">
														<select name="emp_qualification" id="emp_qualification">
															<option value="">Select Qualification</option>
															<?php foreach ($allqualification as $single_qualification) {
																if($emp_qualification==$single_qualification['tid']){
																	echo '<option value="'.$single_qualification['tid'].'" selected="selected">'.$single_qualification['name'].'</option>';
																}else{
																	echo '<option value="'.$single_qualification['tid'].'">'.$single_qualification['name'].'</option>';
																}
															} ?>
														</select>         
													</div>
												</div> 
												<div class="row">
									            <div class="col-md-4 bgcolor_D8D8D8">Total Experience<span style="color:red;float:right;font-size: 14px;">*</span></div>
									        
									            <div class="col-md-8"><input type="text" name="total_exp" id="total_exp" class="numbersdotOnly"  value="" />

									            </div>
									          </div>                                   
											</div>
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Father's Name<span style="color:red;float:right">*</span></div>
													<div class="col-md-8">
														<input type="text" name="emp_fathername" id="emp_fathername" value="<?php if($emp_fathername){ echo $emp_fathername;} ?>"/>         
													</div>
												</div> 
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Mother's Name</div>
													<div class="col-md-8"><input type="text" name="emp_mothername" id="emp_mothername" value="<?php if($emp_mothername){ echo $emp_mothername;} ?>"/></div>
												</div>  
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">National ID</div>
													<div class="col-md-8"><input type="text" name="emp_nid" id="emp_nid" onkeypress="return isNumber(event);" value="<?php if($emp_nid){ echo $emp_nid;} ?>"/></div>
												</div>  
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Marital Status</div>
													<div class="col-md-8">
														<select name="emp_marital_status" id="emp_marital_status">
															<option value="">Select Status</option>
															<?php foreach ($allmarital_status as $single_maritial_status) {
																if($emp_marital_status==$single_maritial_status['tid']){
																	echo '<option value="'.$single_maritial_status['tid'].'" selected="selected">'.$single_maritial_status['name'].'</option>';
																}else if(!$emp_marital_status && $single_maritial_status['tid']=='156'){
																	echo '<option value="'.$single_maritial_status['tid'].'" selected="selected">'.$single_maritial_status['name'].'</option>';
																}else{
																	echo '<option value="'.$single_maritial_status['tid'].'">'.$single_maritial_status['name'].'</option>';
																}
															} ?>
														</select>         
													</div>
												</div> 
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Religion</div>
													<div class="col-md-8">
														<select name="emp_religion" id="emp_religion">
															<option value="">Select Religion</option>
															<?php foreach ($allreligion as $single_religion) {
																if($emp_religion==$single_religion['tid']){
																	echo '<option value="'.$single_religion['tid'].'" selected="selected">'.$single_religion['name'].'</option>';
																}else if(!$emp_religion && $single_religion['tid']=='4'){
																	echo '<option value="'.$single_religion['tid'].'" selected="selected">'.$single_religion['name'].'</option>';
																}else{
																	echo '<option value="'.$single_religion['tid'].'">'.$single_religion['name'].'</option>';
																}
															} ?>
														</select>         
													</div>
												</div>
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Blood Group</div>
													<div class="col-md-8">
														<select name="emp_blood_group" id="emp_blood_group">
															<option value="">Select Blood Group</option>
															<?php foreach ($allbloodgroup as $single_blood_grp) {
																if($emp_blood_group==$single_blood_grp['tid']){
																	echo '<option value="'.$single_blood_grp['tid'].'" selected="selected">'.$single_blood_grp['name'].'</option>';
																}else{
																	echo '<option value="'.$single_blood_grp['tid'].'">'.$single_blood_grp['name'].'</option>';
																}
															} ?>
														</select> 
													</div>
												</div>
												<div class="row">
									            <div class="col-md-4 bgcolor_D8D8D8">Apply Date<span style="color:red;float:right">*</span></div>
									            <?php 
									            date_default_timezone_set('Asia/Dhaka');
									            $servertime = time();
									            $now = date("d-m-Y", $servertime);
									            ?>
									            <div class="col-md-8"><input type="text" name="apply_date" id="apply_date" class="numbersOnly" readonly="readonly"  value="<?php if($apply_date){ echo $apply_date;}else{ echo $now; } ?>" /></div>
									          </div> 
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<div class="row">
											<!-- <div class="col-md-5 bgcolor_D8D8D8">Mother's Name</div> -->
											<div class="col-md-7">
												<div id="filefield">
													<?php if($picture){?>
													<img src="<?php echo base_url();?>resources/uploads/<?php echo $picture;?>" id="preview" width="" style="max-width: 143px;max-height: 150px;" />
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
										Parmanent Address
									</div>
								</div>	
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-4 bgcolor_D8D8D8">Address</div>
											<div class="col-md-8">
												<textarea name="emp_parmanent_address" id="emp_parmanent_address" cols="30" rows="3"><?php if($emp_parmanent_address){ echo $emp_parmanent_address;} ?></textarea>       
											</div>
										</div>											
									</div> 
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-4 bgcolor_D8D8D8">City</div>
											<div class="col-md-8">
												<select name="emp_parmanent_city" id="emp_parmanent_city">
													<option value="">Select City</option>
													<?php foreach ($allcity as $single_city) {
														if($emp_parmanent_city==$single_city['tid']){
															echo '<option value="'.$single_city['tid'].'" selected="selected">'.$single_city['name'].'</option>';
														}else{
															echo '<option value="'.$single_city['tid'].'">'.$single_city['name'].'</option>';
														}
													} ?>
												</select>         
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 bgcolor_D8D8D8">Distict</div>
											<div class="col-md-8">
												<select name="emp_parmanent_distict" id="emp_parmanent_distict">
													<option value="">Select Distict</option>
													<?php foreach ($alldistict as $single_distict) {
														if($emp_parmanent_distict==$single_distict['tid']){
															echo '<option value="'.$single_distict['tid'].'" selected="selected">'.$single_distict['name'].'</option>';
														}else{
															echo '<option value="'.$single_distict['tid'].'">'.$single_distict['name'].'</option>';
														}
													} ?>
												</select>         
											</div>
										</div>											
									</div>
								</div>	
								<div class="row">
									<div class="col-md-5 heading_style">
										Present Address
									</div>
									<div class="col-md-7 heading_style"> <input type="checkbox" id="same_address" style="margin: 0px 0 0;"> Permanent Address and Present Address are same.</div>
								</div>	
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-4 bgcolor_D8D8D8">Present Address</div>
											<div class="col-md-8">
												<textarea name="emp_present_address" id="emp_present_address" cols="30" rows="3"><?php if($emp_present_address){ echo $emp_present_address;} ?></textarea>        
											</div>
										</div> 
									</div>
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-4 bgcolor_D8D8D8">City</div>
											<div class="col-md-8">
												<select name="emp_present_city" id="emp_present_city">
													<option value="">Select City</option>
													<?php foreach ($allcity as $single_city) {
														if($emp_present_city==$single_city['tid']){
															echo '<option value="'.$single_city['tid'].'" selected="selected">'.$single_city['name'].'</option>';
														}else if(!$emp_present_city && $single_city['tid']=='209'){
															echo '<option value="'.$single_city['tid'].'" selected="selected">'.$single_city['name'].'</option>';
														}else{
															echo '<option value="'.$single_city['tid'].'">'.$single_city['name'].'</option>';
														}
													} ?>
												</select>         
											</div>
										</div>										
										<div class="row">
											<div class="col-md-4 bgcolor_D8D8D8">Current Distict</div>
											<div class="col-md-8">
												<select name="emp_current_distict" id="emp_current_distict">
													<option value="">Select Distict</option>
													<?php foreach ($alldistict as $single_distict) {
														if($emp_current_distict==$single_distict['tid']){
															echo '<option value="'.$single_distict['tid'].'" selected="selected">'.$single_distict['name'].'</option>';
														}else if(!$emp_current_distict && $single_distict['tid']=='235'){
															echo '<option value="'.$single_distict['tid'].'" selected="selected">'.$single_distict['name'].'</option>';
														}else{
															echo '<option value="'.$single_distict['tid'].'">'.$single_distict['name'].'</option>';
														}
													} ?>
												</select>         
											</div>
										</div> 											
									</div>
								</div>	
								<div class="row">
									<div class="col-md-12 heading_style">
										Contact
									</div>
								</div>	
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-4 bgcolor_D8D8D8">Mobile No.</div>
											<div class="col-md-8">
												<input type="text" name="emp_mobile_no" id="emp_mobile_no" autocomplete="off" class="phonenumbersOnly" value="<?php if($emp_mobile_no){ echo $emp_mobile_no;} ?>"/>        
											</div>
										</div>
										<div class="row">
											<div class="col-md-4 bgcolor_D8D8D8">Office Phone</div>
											<div class="col-md-8">
												<input type="text" name="emp_office_phone" id="emp_office_phone" autocomplete="off" class="phonenumbersOnly" value="<?php if($emp_office_phone){ echo $emp_office_phone;} ?>"/>        
											</div>
										</div>   
										<div class="row">
											<div class="col-md-4 bgcolor_D8D8D8">Home Phone</div>
											<div class="col-md-8">
												<input type="text" name="emp_home_phone" id="emp_home_phone" autocomplete="off" class="phonenumbersOnly" value="<?php if($emp_home_phone){ echo $emp_home_phone;} ?>"/>                
											</div>
										</div>												              
									</div>
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-4 bgcolor_D8D8D8">Emergency Contact</div>
											<div class="col-md-8">
												<input type="text" name="emp_emergency_contact" id="emp_emergency_contact" autocomplete="off" class="phonenumbersOnly" value="<?php if($emp_emergency_contact){ echo $emp_emergency_contact;} ?>"/>       
											</div>
										</div>												
										<div class="row">
											<div class="col-md-4 bgcolor_D8D8D8">Email</div>
											<div class="col-md-8">
												<input type="text" name="emp_email" id="emp_email" value="<?php if($emp_email){ echo $emp_email;} ?>"/>         
											</div>
										</div>  
										<div class="row">
											<div class="col-md-4 bgcolor_D8D8D8">Alternative Email</div>
											<div class="col-md-8">
												<input type="text" name="emp_alt_email" id="emp_alt_email" value="<?php if($emp_alt_email){ echo $emp_alt_email;} ?>"/>        
											</div>
										</div> 												
									</div>
								</div>	
									<div class="row">
											<div class="col-md-12 heading_style">
												Education
											</div>
										</div>										
										<div class="row">
											<div class="col-md-2 bgcolor_D8D8D8">Education Level</div>
											<div class="col-md-3 bgcolor_D8D8D8">Exam/Degree</div>
											<div class="col-md-1 bgcolor_D8D8D8">Major</div>
											<div class="col-md-4 bgcolor_D8D8D8">Institution</div>
											<div class="col-md-1 bgcolor_D8D8D8">Year</div>
											<div class="col-md-1 bgcolor_D8D8D8">Results</div>
										</div>
										<div class="row">
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_education_level_1" id="emp_education_level_1">
													<option value="">Select Level</option>
													<?php foreach ($allqualification as $single_qualification) {
														if($emp_education_level_1==$single_qualification['tid']){
															echo '<option value="'.$single_qualification['tid'].'" selected="selected">'.$single_qualification['name'].'</option>';
														}else{
															echo '<option value="'.$single_qualification['tid'].'">'.$single_qualification['name'].'</option>';
														}
													} ?>
												</select>  
											</div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_degree_1" id="emp_education_degree_1"  value="<?php if($emp_education_degree_1){ echo $emp_education_degree_1;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_major_1" id="emp_education_major_1"  value="<?php if($emp_education_major_1){ echo $emp_education_major_1;} ?>" /></div>
											<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_institute_1" id="emp_education_institute_1" value="<?php if($emp_education_institute_1){ echo $emp_education_institute_1;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_year_1" id="emp_education_year_1" onkeypress="return isNumber(event);" value="<?php if($emp_education_year_1){ echo $emp_education_year_1;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_results_1" id="emp_education_results_1"  value="<?php if($emp_education_results_1){ echo $emp_education_results_1;} ?>" /></div>
										</div>
										<div class="row">
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_education_level_2" id="emp_education_level_2">
													<option value="">Select Level</option>
													<?php foreach ($allqualification as $single_qualification) {
														if($emp_education_level_2==$single_qualification['tid']){
															echo '<option value="'.$single_qualification['tid'].'" selected="selected">'.$single_qualification['name'].'</option>';
														}else{
															echo '<option value="'.$single_qualification['tid'].'">'.$single_qualification['name'].'</option>';
														}
													} ?>
												</select>  
											</div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_degree_2" id="emp_education_degree_2"  value="<?php if($emp_education_degree_2){ echo $emp_education_degree_2;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_major_2" id="emp_education_major_2"  value="<?php if($emp_education_major_2){ echo $emp_education_major_2;} ?>" /></div>
											<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_institute_2" id="emp_education_institute_2" value="<?php if($emp_education_institute_2){ echo $emp_education_institute_2;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_year_2" id="emp_education_year_2"  onkeypress="return isNumber(event);" value="<?php if($emp_education_year_2){ echo $emp_education_year_2;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_results_2" id="emp_education_results_2"  value="<?php if($emp_education_results_2){ echo $emp_education_results_2;} ?>" /></div>
										</div>
										<div class="row">
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_education_level_3" id="emp_education_level_3">
													<option value="">Select Level</option>
													<?php foreach ($allqualification as $single_qualification) {
														if($emp_education_level_3==$single_qualification['tid']){
															echo '<option value="'.$single_qualification['tid'].'" selected="selected">'.$single_qualification['name'].'</option>';
														}else{
															echo '<option value="'.$single_qualification['tid'].'">'.$single_qualification['name'].'</option>';
														}
													} ?>
												</select>  
											</div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_degree_3" id="emp_education_degree_3"  value="<?php if($emp_education_degree_3){ echo $emp_education_degree_3;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_major_3" id="emp_education_major_3"  value="<?php if($emp_education_major_3){ echo $emp_education_major_3;} ?>" /></div>
											<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_institute_3" id="emp_education_institute_3" value="<?php if($emp_education_institute_3){ echo $emp_education_institute_3;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_year_3" id="emp_education_year_3"  onkeypress="return isNumber(event);" value="<?php if($emp_education_year_3){ echo $emp_education_year_3;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_results_3" id="emp_education_results_3"  value="<?php if($emp_education_results_3){ echo $emp_education_results_3;} ?>" /></div>
										</div>
										<div class="row">
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_education_level_4" id="emp_education_level_4">
													<option value="">Select Level</option>
													<?php foreach ($allqualification as $single_qualification) {
														if($emp_education_level_4==$single_qualification['tid']){
															echo '<option value="'.$single_qualification['tid'].'" selected="selected">'.$single_qualification['name'].'</option>';
														}else{
															echo '<option value="'.$single_qualification['tid'].'">'.$single_qualification['name'].'</option>';
														}
													} ?>
												</select>  
											</div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_degree_4" id="emp_education_degree_4"  value="<?php if($emp_education_degree_4){ echo $emp_education_degree_4;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_major_4" id="emp_education_major_4"  value="<?php if($emp_education_major_4){ echo $emp_education_major_4;} ?>" /></div>
											<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_institute_4" id="emp_education_institute_4" value="<?php if($emp_education_institute_4){ echo $emp_education_institute_4;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_year_4" id="emp_education_year_4" onkeypress="return isNumber(event);" value="<?php if($emp_education_year_4){ echo $emp_education_year_4;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_results_4" id="emp_education_results_4"  value="<?php if($emp_education_results_4){ echo $emp_education_results_4;} ?>" /></div>
										</div>
										<div class="row">
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_education_level_5" id="emp_education_level_5">
													<option value="">Select Level</option>
													<?php foreach ($allqualification as $single_qualification) {
														if($emp_education_level_5==$single_qualification['tid']){
															echo '<option value="'.$single_qualification['tid'].'" selected="selected">'.$single_qualification['name'].'</option>';
														}else{
															echo '<option value="'.$single_qualification['tid'].'">'.$single_qualification['name'].'</option>';
														}
													} ?>
												</select>  
											</div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_degree_5" id="emp_education_degree_5"  value="<?php if($emp_education_degree_5){ echo $emp_education_degree_5;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_major_5" id="emp_education_major_5"  value="<?php if($emp_education_major_5){ echo $emp_education_major_5;} ?>" /></div>
											<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_institute_5" id="emp_education_institute_5" value="<?php if($emp_education_institute_5){ echo $emp_education_institute_5;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_year_5" id="emp_education_year_5" onkeypress="return isNumber(event);" value="<?php if($emp_education_year_5){ echo $emp_education_year_5;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_results_5" id="emp_education_results_5"  value="<?php if($emp_education_results_5){ echo $emp_education_results_5;} ?>" /></div>
										</div>
										<div class="row">
											<div class="col-md-12 heading_style">
												Language
											</div>
										</div>																					
										<div class="row">
											<div class="col-md-3 bgcolor_D8D8D8">Language</div>
											<div class="col-md-2 bgcolor_D8D8D8">Reading</div>
											<div class="col-md-2 bgcolor_D8D8D8">Writing</div>
											<div class="col-md-2 bgcolor_D8D8D8">Speaking</div>
											<div class="col-md-3 bgcolor_D8D8D8">Listening</div>
										</div>
										<div class="row">
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_language_name_1" id="emp_language_name_1"  value="<?php if($emp_language_name_1){ echo $emp_language_name_1;} ?>" /></div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_reading_1" id="emp_language_reading_1">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_reading_1=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_reading_1=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_reading_1=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_writing_1" id="emp_language_writing_1">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_writing_1=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_writing_1=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_writing_1=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_speaking_1" id="emp_language_speaking_1">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_speaking_1=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_speaking_1=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_speaking_1=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_listening_1" id="emp_language_listening_1">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_listening_1=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_listening_1=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_listening_1=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_language_name_2" id="emp_language_name_2"  value="<?php if($emp_language_name_2){ echo $emp_language_name_2;} ?>" /></div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_reading_2" id="emp_language_reading_2">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_reading_2=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_reading_2=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_reading_2=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_writing_2" id="emp_language_writing_2">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_writing_2=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_writing_2=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_writing_2=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_speaking_2" id="emp_language_speaking_2">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_speaking_2=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_speaking_2=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_speaking_2=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_listening_2" id="emp_language_listening_2">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_listening_2=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_listening_2=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_listening_2=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_language_name_3" id="emp_language_name_3"  value="<?php if($emp_language_name_3){ echo $emp_language_name_3;} ?>" /></div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_reading_3" id="emp_language_reading_3">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_reading_3=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_reading_3=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_reading_3=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_writing_3" id="emp_language_writing_3">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_writing_3=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_writing_3=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_writing_3=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_speaking_3" id="emp_language_speaking_3">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_speaking_3=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_speaking_3=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_speaking_3=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_listening_3" id="emp_language_listening_3">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_listening_3=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_listening_3=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_listening_3=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
										</div>
							</div>
							<div class="tabcontent" id="content_4">
								<div class="row">
									<div class="col-md-12 heading_style">
										Experience
									</div>
								</div>
								<div class="row">
									<div class="col-md-3 bgcolor_D8D8D8">Position</div>
									<div class="col-md-2 bgcolor_D8D8D8">Date From</div>
									<div class="col-md-2 bgcolor_D8D8D8">Date To</div>
									<div class="col-md-2 bgcolor_D8D8D8">Duration</div>
									<div class="col-md-3 bgcolor_D8D8D8">Name of Organization</div>
								</div>
								<div class="row">
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
										<select name="emp_exp_position_1" id="emp_exp_position_1">
											<option value="">Select Position</option>
											<?php foreach ($alljobtitle as $single_jobtitle) {
												if($emp_exp_position_1==$single_jobtitle['tid']){
													echo '<option value="'.$single_jobtitle['tid'].'" selected="selected">'.$single_jobtitle['name'].'</option>';
												}else{
													echo '<option value="'.$single_jobtitle['tid'].'">'.$single_jobtitle['name'].'</option>';
												}
											} ?>
										</select> 
									</div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_datefrom_1" id="emp_exp_datefrom_1"  value="<?php if($emp_exp_datefrom_1){ echo $emp_exp_datefrom_1;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_dateto_1" id="emp_exp_dateto_1"  value="<?php if($emp_exp_dateto_1){ echo $emp_exp_dateto_1;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_duration_1" id="emp_exp_duration_1" value="<?php if($emp_exp_duration_1){ echo $emp_exp_duration_1;} ?>" /></div>
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_organization_1" id="emp_exp_organization_1"  value="<?php if($emp_exp_organization_1){ echo $emp_exp_organization_1;} ?>" /></div>
								</div>
								<div class="row">
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
										<select name="emp_exp_position_2" id="emp_exp_position_2">
											<option value="">Select Position</option>
											<?php foreach ($alljobtitle as $single_jobtitle) {
												if($emp_exp_position_2==$single_jobtitle['tid']){
													echo '<option value="'.$single_jobtitle['tid'].'" selected="selected">'.$single_jobtitle['name'].'</option>';
												}else{
													echo '<option value="'.$single_jobtitle['tid'].'">'.$single_jobtitle['name'].'</option>';
												}
											} ?>
										</select> 
									</div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_datefrom_2" id="emp_exp_datefrom_2"  value="<?php if($emp_exp_datefrom_2){ echo $emp_exp_datefrom_2;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_dateto_2" id="emp_exp_dateto_2"  value="<?php if($emp_exp_dateto_2){ echo $emp_exp_dateto_2;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_duration_2" id="emp_exp_duration_2" value="<?php if($emp_exp_duration_2){ echo $emp_exp_duration_2;} ?>" /></div>
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_organization_2" id="emp_exp_organization_2"  value="<?php if($emp_exp_organization_2){ echo $emp_exp_organization_2;} ?>" /></div>
								</div>
								<div class="row">
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
										<select name="emp_exp_position_3" id="emp_exp_position_3">
											<option value="">Select Position</option>
											<?php foreach ($alljobtitle as $single_jobtitle) {
												if($emp_exp_position_3==$single_jobtitle['tid']){
													echo '<option value="'.$single_jobtitle['tid'].'" selected="selected">'.$single_jobtitle['name'].'</option>';
												}else{
													echo '<option value="'.$single_jobtitle['tid'].'">'.$single_jobtitle['name'].'</option>';
												}
											} ?>
										</select> 
									</div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_datefrom_3" id="emp_exp_datefrom_3"  value="<?php if($emp_exp_datefrom_3){ echo $emp_exp_datefrom_3;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_dateto_3" id="emp_exp_dateto_3"  value="<?php if($emp_exp_dateto_3){ echo $emp_exp_dateto_3;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_duration_3" id="emp_exp_duration_3" value="<?php if($emp_exp_duration_3){ echo $emp_exp_duration_3;} ?>" /></div>
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_organization_3" id="emp_exp_organization_3"  value="<?php if($emp_exp_organization_3){ echo $emp_exp_organization_3;} ?>" /></div>
								</div>
								<div class="row">
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
										<select name="emp_exp_position_4" id="emp_exp_position_4">
											<option value="">Select Position</option>
											<?php foreach ($alljobtitle as $single_jobtitle) {
												if($emp_exp_position_4==$single_jobtitle['tid']){
													echo '<option value="'.$single_jobtitle['tid'].'" selected="selected">'.$single_jobtitle['name'].'</option>';
												}else{
													echo '<option value="'.$single_jobtitle['tid'].'">'.$single_jobtitle['name'].'</option>';
												}
											} ?>
										</select> 
									</div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_datefrom_4" id="emp_exp_datefrom_4"  value="<?php if($emp_exp_datefrom_4){ echo $emp_exp_datefrom_4;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_dateto_4" id="emp_exp_dateto_4"  value="<?php if($emp_exp_dateto_4){ echo $emp_exp_dateto_4;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_duration_4" id="emp_exp_duration_4" value="<?php if($emp_exp_duration_4){ echo $emp_exp_duration_4;} ?>" /></div>
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_organization_4" id="emp_exp_organization_4"  value="<?php if($emp_exp_organization_4){ echo $emp_exp_organization_4;} ?>" /></div>
								</div>
								<div class="row">
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
										<select name="emp_exp_position_5" id="emp_exp_position_5">
											<option value="">Select Position</option>
											<?php foreach ($alljobtitle as $single_jobtitle) {
												if($emp_exp_position_5==$single_jobtitle['tid']){
													echo '<option value="'.$single_jobtitle['tid'].'" selected="selected">'.$single_jobtitle['name'].'</option>';
												}else{
													echo '<option value="'.$single_jobtitle['tid'].'">'.$single_jobtitle['name'].'</option>';
												}
											} ?>
										</select> 
									</div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_datefrom_5" id="emp_exp_datefrom_5"  value="<?php if($emp_exp_datefrom_5){ echo $emp_exp_datefrom_5;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_dateto_5" id="emp_exp_dateto_5"  value="<?php if($emp_exp_dateto_5){ echo $emp_exp_dateto_5;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_duration_5" id="emp_exp_duration_5" value="<?php if($emp_exp_duration_5){ echo $emp_exp_duration_5;} ?>" /></div>
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_organization_5" id="emp_exp_organization_5"  value="<?php if($emp_exp_organization_5){ echo $emp_exp_organization_5;} ?>" /></div>
								</div>
								<div class="row">
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
										<select name="emp_exp_position_6" id="emp_exp_position_6">
											<option value="">Select Position</option>
											<?php foreach ($alljobtitle as $single_jobtitle) {
												if($emp_exp_position_6==$single_jobtitle['tid']){
													echo '<option value="'.$single_jobtitle['tid'].'" selected="selected">'.$single_jobtitle['name'].'</option>';
												}else{
													echo '<option value="'.$single_jobtitle['tid'].'">'.$single_jobtitle['name'].'</option>';
												}
											} ?>
										</select> 
									</div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_datefrom_6" id="emp_exp_datefrom_6"  value="<?php if($emp_exp_datefrom_6){ echo $emp_exp_datefrom_6;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_dateto_6" id="emp_exp_dateto_6"  value="<?php if($emp_exp_dateto_6){ echo $emp_exp_dateto_6;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_duration_6" id="emp_exp_duration_6" value="<?php if($emp_exp_duration_6){ echo $emp_exp_duration_6;} ?>" /></div>
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_organization_6" id="emp_exp_organization_6"  value="<?php if($emp_exp_organization_6){ echo $emp_exp_organization_6;} ?>" /></div>
								</div>
								<div class="row">
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
										<select name="emp_exp_position_7" id="emp_exp_position_7">
											<option value="">Select Position</option>
											<?php foreach ($alljobtitle as $single_jobtitle) {
												if($emp_exp_position_7==$single_jobtitle['tid']){
													echo '<option value="'.$single_jobtitle['tid'].'" selected="selected">'.$single_jobtitle['name'].'</option>';
												}else{
													echo '<option value="'.$single_jobtitle['tid'].'">'.$single_jobtitle['name'].'</option>';
												}
											} ?>
										</select> 
									</div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_datefrom_7" id="emp_exp_datefrom_7"  value="<?php if($emp_exp_datefrom_7){ echo $emp_exp_datefrom_7;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_dateto_7" id="emp_exp_dateto_7"  value="<?php if($emp_exp_dateto_7){ echo $emp_exp_dateto_7;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_duration_7" id="emp_exp_duration_7" value="<?php if($emp_exp_duration_7){ echo $emp_exp_duration_7;} ?>" /></div>
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_organization_7" id="emp_exp_organization_7"  value="<?php if($emp_exp_organization_7){ echo $emp_exp_organization_7;} ?>" /></div>
								</div>
								<!-- training -->
								<div class="row">
									<div class="col-md-12 heading_style">
										Training
									</div>
								</div>										
								<div class="row">
									<div class="col-md-3 bgcolor_D8D8D8">Training Course</div>
									<div class="col-md-2 bgcolor_D8D8D8">Date From</div>
									<div class="col-md-2 bgcolor_D8D8D8">Date To</div>
									<div class="col-md-2 bgcolor_D8D8D8">Duration</div>
									<div class="col-md-3 bgcolor_D8D8D8">Name of Organization</div>
								</div>
								<div class="row">
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_course_1" id="emp_training_course_1"  value="<?php if($emp_training_course_1){ echo $emp_training_course_1;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_datefrom_1" id="emp_training_datefrom_1"  value="<?php if($emp_training_datefrom_1){ echo $emp_training_datefrom_1;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_dateto_1" id="emp_training_dateto_1"  value="<?php if($emp_training_dateto_1){ echo $emp_training_dateto_1;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_duration_1" id="emp_training_duration_1" value="<?php if($emp_training_duration_1){ echo $emp_training_duration_1;} ?>" /></div>
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_organization_1" id="emp_training_organization_1"  value="<?php if($emp_training_organization_1){ echo $emp_training_organization_1;} ?>" /></div>
								</div>
								<div class="row">
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_course_2" id="emp_training_course_2"  value="<?php if($emp_training_course_2){ echo $emp_training_course_2;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_datefrom_2" id="emp_training_datefrom_2"  value="<?php if($emp_training_datefrom_2){ echo $emp_training_datefrom_2;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_dateto_2" id="emp_training_dateto_2"  value="<?php if($emp_training_dateto_2){ echo $emp_training_dateto_2;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_duration_2" id="emp_training_duration_2" value="<?php if($emp_training_duration_2){ echo $emp_training_duration_2;} ?>" /></div>
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_organization_2" id="emp_training_organization_2"  value="<?php if($emp_training_organization_2){ echo $emp_training_organization_2;} ?>" /></div>
								</div>
								<div class="row">
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_course_3" id="emp_training_course_3"  value="<?php if($emp_training_course_3){ echo $emp_training_course_3;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_datefrom_3" id="emp_training_datefrom_3"  value="<?php if($emp_training_datefrom_3){ echo $emp_training_datefrom_3;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_dateto_3" id="emp_training_dateto_3"  value="<?php if($emp_training_dateto_3){ echo $emp_training_dateto_3;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_duration_3" id="emp_training_duration_3" value="<?php if($emp_training_duration_3){ echo $emp_training_duration_3;} ?>" /></div>
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_organization_3" id="emp_training_organization_3"  value="<?php if($emp_training_organization_3){ echo $emp_training_organization_3;} ?>" /></div>
								</div>
								<div class="row">
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_course_4" id="emp_training_course_4"  value="<?php if($emp_training_course_4){ echo $emp_training_course_4;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_datefrom_4" id="emp_training_datefrom_4"  value="<?php if($emp_training_datefrom_4){ echo $emp_training_datefrom_4;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_dateto_4" id="emp_training_dateto_4"  value="<?php if($emp_training_dateto_4){ echo $emp_training_dateto_4;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_duration_4" id="emp_training_duration_4" value="<?php if($emp_training_duration_4){ echo $emp_training_duration_4;} ?>" /></div>
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_organization_4" id="emp_training_organization_4"  value="<?php if($emp_training_organization_4){ echo $emp_training_organization_4;} ?>" /></div>
								</div>
								<div class="row">
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_course_5" id="emp_training_course_5"  value="<?php if($emp_training_course_5){ echo $emp_training_course_5;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_datefrom_5" id="emp_training_datefrom_5"  value="<?php if($emp_training_datefrom_5){ echo $emp_training_datefrom_5;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_dateto_5" id="emp_training_dateto_5"  value="<?php if($emp_training_dateto_5){ echo $emp_training_dateto_5;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_duration_5" id="emp_training_duration_5" value="<?php if($emp_training_duration_5){ echo $emp_training_duration_5;} ?>" /></div>
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_organization_5" id="emp_training_organization_5"  value="<?php if($emp_training_organization_5){ echo $emp_training_organization_5;} ?>" /></div>
								</div>
								<div class="row">
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_course_6" id="emp_training_course_6"  value="<?php if($emp_training_course_6){ echo $emp_training_course_6;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_datefrom_6" id="emp_training_datefrom_6"  value="<?php if($emp_training_datefrom_6){ echo $emp_training_datefrom_6;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_dateto_6" id="emp_training_dateto_6"  value="<?php if($emp_training_dateto_6){ echo $emp_training_dateto_6;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_duration_6" id="emp_training_duration_6" value="<?php if($emp_training_duration_6){ echo $emp_training_duration_6;} ?>" /></div>
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_organization_6" id="emp_training_organization_6"  value="<?php if($emp_training_organization_6){ echo $emp_training_organization_6;} ?>" /></div>
								</div>
								<div class="row">
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_course_7" id="emp_training_course_7"  value="<?php if($emp_training_course_7){ echo $emp_training_course_7;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_datefrom_7" id="emp_training_datefrom_7"  value="<?php if($emp_training_datefrom_7){ echo $emp_training_datefrom_7;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_dateto_7" id="emp_training_dateto_7"  value="<?php if($emp_training_dateto_7){ echo $emp_training_dateto_7;} ?>" /></div>
									<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_duration_7" id="emp_training_duration_7" value="<?php if($emp_training_duration_7){ echo $emp_training_duration_7;} ?>" /></div>
									<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_organization_7" id="emp_training_organization_7"  value="<?php if($emp_training_organization_7){ echo $emp_training_organization_7;} ?>" /></div>
								</div>
								<div class="row">
									<div class="col-md-12 heading_style">
										Computer Skills
									</div>
								</div>	
								<div class="row">
									<div class="col-md-1 bgcolor_D8D8D8">Topics</div>
									<div class="col-md-11"><textarea name="emp_computer_training" id="emp_computer_training" rows="5"><?php if($emp_computer_training){ print $emp_computer_training; } ?></textarea></div>
								</div>										
																		
										<!-- training end										 -->
									</div>

								<div class="tabcontent" id="content_8">
									<div class="row">
										<div class="col-md-12 heading_style">
											References
										</div>
									</div>									
									<div class="row">
										<div class="col-md-2 bgcolor_D8D8D8">Name</div>
										<div class="col-md-2 bgcolor_D8D8D8">Position</div>
										<div class="col-md-2 bgcolor_D8D8D8">Organization</div>
										<div class="col-md-2 bgcolor_D8D8D8">Address</div>
										<div class="col-md-2 bgcolor_D8D8D8 custom_width_10666667">Phone</div>
										<div class="col-md-1 bgcolor_D8D8D8 custom_width_13666667">Email</div>
										<div class="col-md-1 bgcolor_D8D8D8">Relation</div>
									</div>
									<div class="row">
										<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_name_1" id="emp_reference_name_1"  value="<?php if($emp_reference_name_1){ echo $emp_reference_name_1;} ?>" /></div>
										<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_position_1" id="emp_reference_position_1"  value="<?php if($emp_reference_position_1){ echo $emp_reference_position_1;} ?>" /></div>
										<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_org_1" id="emp_reference_org_1"  value="<?php if($emp_reference_org_1){ echo $emp_reference_org_1;} ?>" /></div>
										<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_address_1" id="emp_reference_address_1" value="<?php if($emp_reference_address_1){ echo $emp_reference_address_1;} ?>" /></div>
										<div class="col-md-2 custom_width_10666667" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_phone_1" id="emp_reference_phone_1"  value="<?php if($emp_reference_phone_1){ echo $emp_reference_phone_1;} ?>" /></div>
										<div class="col-md-1 custom_width_13666667" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_email_1" id="emp_reference_email_1"  value="<?php if($emp_reference_email_1){ echo $emp_reference_email_1;} ?>" /></div>
										<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;">
											<input type="text" name="emp_reference_relation_1" id="emp_reference_relation_1"  value="<?php if($emp_reference_relation_1){ echo $emp_reference_relation_1;} ?>" /></div>
										</div>
										<div class="row">
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_name_2" id="emp_reference_name_2"  value="<?php if($emp_reference_name_2){ echo $emp_reference_name_2;} ?>" /></div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_position_2" id="emp_reference_position_2"  value="<?php if($emp_reference_position_2){ echo $emp_reference_position_2;} ?>" /></div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_org_2" id="emp_reference_org_2"  value="<?php if($emp_reference_org_2){ echo $emp_reference_org_2;} ?>" /></div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_address_2" id="emp_reference_address_2" value="<?php if($emp_reference_address_2){ echo $emp_reference_address_2;} ?>" /></div>
											<div class="col-md-2 custom_width_10666667" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_phone_2" id="emp_reference_phone_2"  value="<?php if($emp_reference_phone_2){ echo $emp_reference_phone_2;} ?>" /></div>
											<div class="col-md-1 custom_width_13666667" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_email_2" id="emp_reference_email_2"  value="<?php if($emp_reference_email_2){ echo $emp_reference_email_2;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_relation_2" id="emp_reference_relation_2"  value="<?php if($emp_reference_relation_2){ echo $emp_reference_relation_2;} ?>" /></div>
										</div>
										<div class="row">
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_name_3" id="emp_reference_name_3"  value="<?php if($emp_reference_name_3){ echo $emp_reference_name_3;} ?>" /></div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_position_3" id="emp_reference_position_3"  value="<?php if($emp_reference_position_3){ echo $emp_reference_position_3;} ?>" /></div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_org_3" id="emp_reference_org_3"  value="<?php if($emp_reference_org_3){ echo $emp_reference_org_3;} ?>" /></div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_address_3" id="emp_reference_address_3" value="<?php if($emp_reference_address_3){ echo $emp_reference_address_3;} ?>" /></div>
											<div class="col-md-2 custom_width_10666667" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_phone_3" id="emp_reference_phone_3"  value="<?php if($emp_reference_phone_3){ echo $emp_reference_phone_3;} ?>" /></div>
											<div class="col-md-1 custom_width_13666667" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_email_3" id="emp_reference_email_3"  value="<?php if($emp_reference_email_3){ echo $emp_reference_email_3;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_relation_3" id="emp_reference_relation_3"  value="<?php if($emp_reference_relation_3){ echo $emp_reference_relation_3;} ?>" /></div>
										</div>
											
											<div class="row">
												<div class="col-md-12 heading_style">
													Dependents
												</div>
											</div>																		
											<div class="row">
												<div class="col-md-4 bgcolor_D8D8D8">Name</div>
												<div class="col-md-2 bgcolor_D8D8D8">Date of Birth</div>
												<div class="col-md-3 bgcolor_D8D8D8">Relation</div>
												<div class="col-md-3 bgcolor_D8D8D8">Nominee Type</div>
											</div>
											<div class="row">
												<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_name_1" id="emp_dependent_name_1"  value="<?php if($emp_dependent_name_1){ echo $emp_dependent_name_1;} ?>" /></div>
												<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_dependent_dob_1" id="emp_dependent_dob_1"  value="<?php if($emp_dependent_dob_1){ echo $emp_dependent_dob_1;} ?>" /></div>
												<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
													<select name="emp_dependent_relation_1" id="emp_dependent_relation_1">
														<option value="">Select</option>
														<?php foreach ($allrelative as $single_relative) {
															if($emp_dependent_relation_1==$single_relative['tid']){
																echo '<option value="'.$single_relative['tid'].'" selected="selected">'.$single_relative['name'].'</option>';
															}else{
																echo '<option value="'.$single_relative['tid'].'">'.$single_relative['name'].'</option>';
															}
														} ?>
													</select> 
												</div>
												<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_nomtype_1" id="emp_dependent_nomtype_1" value="<?php if($emp_dependent_nomtype_1){ echo $emp_dependent_nomtype_1;} ?>" /></div>
											</div>
											<div class="row">
												<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_name_2" id="emp_dependent_name_2"  value="<?php if($emp_dependent_name_2){ echo $emp_dependent_name_2;} ?>" /></div>
												<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_dependent_dob_2" id="emp_dependent_dob_2"  value="<?php if($emp_dependent_dob_2){ echo $emp_dependent_dob_2;} ?>" /></div>
												<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
													<select name="emp_dependent_relation_2" id="emp_dependent_relation_2">
														<option value="">Select</option>
														<?php foreach ($allrelative as $single_relative) {
															if($emp_dependent_relation_2==$single_relative['tid']){
																echo '<option value="'.$single_relative['tid'].'" selected="selected">'.$single_relative['name'].'</option>';
															}else{
																echo '<option value="'.$single_relative['tid'].'">'.$single_relative['name'].'</option>';
															}
														} ?>
													</select> 
												</div>
												<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_nomtype_2" id="emp_dependent_nomtype_2" value="<?php if($emp_dependent_nomtype_2){ echo $emp_dependent_nomtype_2;} ?>" /></div>
											</div>
											<div class="row">
												<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_name_3" id="emp_dependent_name_3"  value="<?php if($emp_dependent_name_3){ echo $emp_dependent_name_3;} ?>" /></div>
												<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_dependent_dob_3" id="emp_dependent_dob_3"  value="<?php if($emp_dependent_dob_3){ echo $emp_dependent_dob_3;} ?>" /></div>
												<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
													<select name="emp_dependent_relation_3" id="emp_dependent_relation_3">
														<option value="">Select</option>
														<?php foreach ($allrelative as $single_relative) {
															if($emp_dependent_relation_3==$single_relative['tid']){
																echo '<option value="'.$single_relative['tid'].'" selected="selected">'.$single_relative['name'].'</option>';
															}else{
																echo '<option value="'.$single_relative['tid'].'">'.$single_relative['name'].'</option>';
															}
														} ?>
													</select> 
												</div>
												<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_nomtype_3" id="emp_dependent_nomtype_3" value="<?php if($emp_dependent_nomtype_3){ echo $emp_dependent_nomtype_3;} ?>" /></div>
											</div>
											<div class="row">
												<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_name_4" id="emp_dependent_name_4"  value="<?php if($emp_dependent_name_4){ echo $emp_dependent_name_4;} ?>" /></div>
												<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_dependent_dob_4" id="emp_dependent_dob_4"  value="<?php if($emp_dependent_dob_4){ echo $emp_dependent_dob_4;} ?>" /></div>
												<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
													<select name="emp_dependent_relation_4" id="emp_dependent_relation_4">
														<option value="">Select</option>
														<?php foreach ($allrelative as $single_relative) {
															if($emp_dependent_relation_4==$single_relative['tid']){
																echo '<option value="'.$single_relative['tid'].'" selected="selected">'.$single_relative['name'].'</option>';
															}else{
																echo '<option value="'.$single_relative['tid'].'">'.$single_relative['name'].'</option>';
															}
														} ?>
													</select> 
												</div>
												<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_nomtype_4" id="emp_dependent_nomtype_4" value="<?php if($emp_dependent_nomtype_4){ echo $emp_dependent_nomtype_4;} ?>" /></div>
											</div>
											<div class="row">
												<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_name_5" id="emp_dependent_name_5"  value="<?php if($emp_dependent_name_5){ echo $emp_dependent_name_5;} ?>" /></div>
												<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_dependent_dob_5" id="emp_dependent_dob_5"  value="<?php if($emp_dependent_dob_5){ echo $emp_dependent_dob_5;} ?>" /></div>
												<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
													<select name="emp_dependent_relation_5" id="emp_dependent_relation_5">
														<option value="">Select</option>
														<?php foreach ($allrelative as $single_relative) {
															if($emp_dependent_relation_5==$single_relative['tid']){
																echo '<option value="'.$single_relative['tid'].'" selected="selected">'.$single_relative['name'].'</option>';
															}else{
																echo '<option value="'.$single_relative['tid'].'">'.$single_relative['name'].'</option>';
															}
														} ?>
													</select> 
												</div>
												<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_nomtype_5" id="emp_dependent_nomtype_5" value="<?php if($emp_dependent_nomtype_5){ echo $emp_dependent_nomtype_5;} ?>" /></div>
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