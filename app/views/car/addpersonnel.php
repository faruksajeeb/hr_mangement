<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Personnel Information</title>
	<?php
	$this->load->view('includes/cssjs');	
	?> 
	<script> 
		function validate() {
			var valid = true;
				if ( document.myForm.Emp_Code.value == "" ) {
	            if (valid){ //only receive focus if its the first error
	            	document.myForm.Emp_Code.focus();
	            	document.myForm.Emp_Code.style.border="solid 1px red";
	            	valid = false;
	            	return false;
	            }
	        } 
				if ( document.myForm.emp_name.value == "" ) {
	            if (valid){ //only receive focus if its the first error
	            	document.myForm.emp_name.focus();
	            	document.myForm.emp_name.style.border="solid 1px red";
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
				Emp_Code: "required",
				emp_name: "required",
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

$('#emp_name').change(function(){
    var emp_id=$(this).val();
    $('#Emp_Code').val(emp_id);
});
$('#Emp_Code').keyup(function(){
  var emp_id=$("#Emp_Code").val();            
  $('#emp_name').val(emp_id);          
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
  $("#Emp_Code").focus(); //ctrl+M
}        
if (event.which == 81 && event.ctrlKey) {
  $("#myForm").submit(); // ctrl+Q
}                          

});
//      $(document).on('keydown', 'input#vehicle_code', function(e) { 
//      	var keyCode = e.keyCode || e.which; 

//     if (keyCode == 9) { //tab key
//     	e.preventDefault(); 
//     // call custom function here
//     var vehicle_code = $("#vehicle_code").val(); 
//     var base_url='<?php echo base_url();?>';
//     var postData = {
//     	"vehicle_code" : vehicle_code
//     };
//     $.ajax({
//     	type: "POST",
//     	url: ""+base_url+"vahicles/getcarcodeid",
//     	data: postData,
//     	dataType:'json',
//     	success: function(data){
//     		if (data) {
//     			window.location.href = "" + base_url + "vahicles/addcar/"+data;
//     		}else{
//     			$("#vehicle_owner").focus();     	
//     		}
//     	}

//     });
    
// } 
// });


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
 $id=$trans_emp_info['id'];
 $content_id=$trans_emp_info['content_id'];
 if($content_id){
	$emp_code=$this->employee_id_model->getemp_codeby_empid($content_id);
}
 $emp_office_phone=$trans_emp_info['emp_office_phone'];
 $emp_phone=$trans_emp_info['emp_phone'];
 $emp_emergency_contact=$trans_emp_info['emp_emergency_contact'];
 $emp_driving_license=$trans_emp_info['emp_driving_license'];
 $License_Expires_Date=$trans_emp_info['License_Expires_Date'];
 $notes=$trans_emp_info['notes'];
 $driver_status=$trans_emp_info['driver_status'];

// foreach ($driver_documents as $value) {
// 	if($value['field_name']=='resources/uploads/cars/drivers'){
// 		$picture=$value['field_value'];
// 	}
// }
?>    
<style type="text/css">
	#add_btn {
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
				<h4>Employee Information</h4>         
			</div> 
			<div class="wrapper">
				<div class="row">
					<div class="col-md-12">
						<?php 
						print $this->session->flashdata('errors'); 
						print $this->session->flashdata('success'); 
						?>
						<form action="<?php echo base_url(); ?>addtransportemployee/do_upload" method="post" class="myForm" id="myForm"  name="myForm" onSubmit="return validate();" enctype="multipart/form-data">
							<input type="hidden" id="id" name="id" value="<?php echo $id;?>">                    
							<div class="row ">
								<div class="col-md-12">
									<input type="submit" id="add_btn" value="Save">
									<a href="<?php echo base_url(); ?>addtransportemployee/addemployee" class="new-entry-link">New</a>
								</div>
							</div>							

							<div class="row custom-row-radious2">                 
								<div class="tabs">
									<ul class="tabs">
										<li class="activetab" id="Tab_1"> Personnel Info </li>
										<!-- <li class="nonactivetab" id="Tab_2"> Documents </li>                    -->
									</ul>
									<div class="tabcontent" id="content_1">
										<div class="row">
											<div class="col-md-12 heading_style">
												General Information
											</div>
										</div>									
										<div class="row">
											<div class="col-md-12">
												<div class="row">
													<div class="col-md-6">
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Emp Code</div>
															<div class="col-md-8">
																<input type="text" id="Emp_Code" name="Emp_Code" autocomplete="off" value="<?php if($emp_code){ print $emp_code;} ?>">        
															</div>
														</div>			 										
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Emp Name</div>
															<div class="col-md-8">
									                            <select name="emp_name" id="emp_name">
									                              <option value="">Select</option>
									                              <?php 
									                              $default_emp_id=$default_emp['emp_id'];
									                              foreach ($allemployee as $single_employee) {
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
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Office Phone</div>
															<div class="col-md-8"><input type="text" name="emp_office_phone" id="emp_office_phone" value="<?php if($emp_office_phone){ echo $emp_office_phone;} ?>"/></div>
														</div> 																										
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Mobile</div>
															<div class="col-md-8"><input type="text" name="emp_phone" id="emp_phone" value="<?php if($emp_phone){ echo $emp_phone;} ?>"/></div>
														</div>                                       
													</div>
													<div class="col-md-6">
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Emergency Contact</div>
															<div class="col-md-8"><input type="text" name="emp_emergency_contact" id="emp_emergency_contact" value="<?php if($emp_emergency_contact){ echo $emp_emergency_contact;} ?>"/></div>
														</div>   
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Driving License</div>
															<div class="col-md-8"><input type="text" name="emp_driving_license" id="emp_driving_license"   value="<?php if($emp_driving_license){ echo $emp_driving_license;} ?>"/></div>
														</div>  														                               
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">License Expires Date</div>
															<div class="col-md-8"><input type="text" name="License_Expires_Date" id="License_Expires_Date"  class="datepicker numbersOnly" placeholder="dd-mm-yyyy"  value="<?php if($License_Expires_Date){ echo $License_Expires_Date;} ?>"/></div>
														</div>
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Status</div>
															<div class="col-md-8">
																<select name="driver_status" id="driver_status">
																	<option value="Active" <?php if($driver_status=="Active"){ print 'selected="selected"'; } ?> >Active</option>
																	<option value="Inactive" <?php if($driver_status=="Inactive"){ print 'selected="selected"'; } ?>>Inactive</option>
																</select>
															</div>
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