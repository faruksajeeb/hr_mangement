<!DOCTYPE html>
<!--
// Line Index ----------
  Payroll JS----------378 line
  Payroll PHP ---------853 line
  Payroll Form -------2922 line

-->
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Employee Master</title>
	<?php
	$this->load->view('includes/cssjs');	
	?> 
	        <!--chosen--> 
         <link rel="stylesheet" href="<?php echo base_url();?>resources/plugins/chosenSelect/chosen.css">

   
	<script>  
	        function validate() {
                    var valid = true;
                    if ( document.myForm.half_day_absent.value == "Eligible" ) {
                        if ( document.myForm.absent_count_time.value == "" ) {
                          if (valid){ //only receive focus if its the first error
                            document.myForm.absent_count_time.focus();
                            document.myForm.absent_count_time.style.border="solid 1px red";
                            valid = false;
                            return false;
                          }
                        }                                                                                   
                    }
                    if ( document.myForm.emp_type.value == "155" ) {
                        if ( document.myForm.emp_provision_starting_date.value == "" ) {
                          if (valid){ //only receive focus if its the first error
                            document.myForm.emp_provision_starting_date.focus();
                            document.myForm.emp_provision_starting_date.style.border="solid 1px red";
                            valid = false;
                            return false;
                        }
                      }
                        if ( document.myForm.emp_provision_ending_date.value == "" ) {
                          if (valid){ //only receive focus if its the first error
                            document.myForm.emp_provision_ending_date.focus();
                            document.myForm.emp_provision_ending_date.style.border="solid 1px red";
                            valid = false;
                            return false;
                        }
                      }       		 
                  }      	
      	
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
    
    /*disable non active tabs*/
    // $('ul.tabs li').not('.activetab').addClass('disabled');

    $('ul.tabs li').click(function(e){
        /*enable next tab*/
        // var emp_name=$("#emp_name").val();
        //alert(emp_name);
    //     if ($(this).hasClass('disabled')) {
    //     	// alert(emp_name);
    //         e.preventDefault();
    // return false;
    //     }
   //      if(emp_name){
        
   //  	}else{
   //  		alert(emp_name);
   //  		 $(this).removeClass('activetab');
   //      	//$('ul.tabs li.activetab').removeClass('activetab');
   //      	$('ul.tabs li').not('#Tab_1').addClass('nonactivetab');
			// $('li[id="Tab_1"]').addClass("activetab");
   //  	}
    });


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
				}else{
					$('ul.tabs li').not('.activetab').addClass('disabled');
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
			emp_name: "required",
			emp_id: "required",
			emp_fathername: "required",
			emp_company: "required",
			emp_division: "required",
			emp_department: "required",
			emp_job_change_date: "required",
			emp_starting_date : {required: true, mydate : true },	
			emp_dob : {mydate : true },	
			emp_starting_date : {mydate : true },	
			emp_increment_date : {mydate : true },	
			emp_working_time_from: {time: true},            		
			emp_working_end_time: {time: true},            		
			emp_latecount_time: {time: true},            		
			emp_type: "required",
			emp_position: "required",
			emp_grade: "required",
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
                    var emp_type = $("#emp_type").val(); 
                    var emp_provision_starting_date = $("#emp_provision_starting_date").val(); 
                    var emp_provision_ending_date = $("#emp_provision_ending_date").val(); 
                    var absent_value=$("#absent_count_time").val();
                    var half_day_absent=$("#half_day_absent").val();
                    var company_code = $("#emp_company").find('option:selected').attr("data-id"); 
                    var emp_code = $("#emp_id").val(); 
                    var emp_code_divison_code = emp_code.substring(0, 4);
                    var joining_date = $("#emp_starting_date").val().split('-'); 
                    
                    var job_change_date = $("#emp_job_change_date").val().split('-'); 
                    //alert(job_change_date+joining_date);
                    
                    if(new Date(job_change_date[2],job_change_date[1],job_change_date[0]) < new Date(joining_date[2],joining_date[1],joining_date[0]) )
                    {
                        alert('Effective date not valid!');
                        $("#emp_job_change_date").css({"border":"1px solid red"}).focus();
                        return false;
                    }
                   
                    if(company_code == emp_code){
                                $("#emp_id").css({"border":"1px solid red"});
                    }
                    /* 
                    It's mute for employee company change without emp id changes ------------
                    else if(company_code != emp_code_divison_code){
                                $("#emp_id").css({"border":"1px solid red"});
                    }

                    */
                    else if(half_day_absent=='Eligible' && !absent_value){
                        $("#absent_count_time").css({"border":"1px solid red"});
                    }else if((emp_type=='155') && (!emp_provision_starting_date || !emp_provision_ending_date)){
                        $("#emp_type").css({"border":"1px solid red"});
                    }else{
                        form.submit();
                    }

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
// load division by company
$( "#emp_company" ).change(function(e) {
	var company_tid = $(this).val(); 
	var company_code = $('option:selected', this).attr('data-id');
	$("#emp_id").val(company_code); 
	$("#emp_id").focus(); 
	var base_url='<?php echo base_url();?>';
	var postData = {
		"company_tid" : company_tid
	};
	$.ajax({
		type: "POST",
		url: ""+base_url+"addprofile/getDivisionByCompanyId",
		data: postData,
		dataType:'json',
		success: function(data){
    // console.log(data);
    var options="";
    options += '<option value="">Select Division</option>';
    $(data).each(function(index, item) {
    	options += '<option value="' + item.tid + '">' + item.name + '</option>'; 
    });
    $('#emp_division').html(options);    
}
});
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
    	//e.preventDefault();
    	//alert("est");
    	//var a=$(this).attr('name');
    	//alert(a);
    	//$('#'+a).next('input').focus();
  //   	var inputs = $(this).closest('form').find(':input');
  // inputs.eq( inputs.index(this)+ 1 ).focus();
          //Use whatever selector necessary to focus the 'next' input
        //return false;
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
     $("#emp_type").change(function(){
     	var emp_type=$("#emp_type").val();
     	if(emp_type==='155'){
     		$(".provision").show();
     	}else{
     		$(".provision").hide();
     		$('#emp_provision_starting_date').val("");  
     		$('#emp_provision_ending_date').val("");  
     	}
     	
     });
     $("#overtime_count").change(function(){
     	var overtime_count=$("#overtime_count").val();
     	if(overtime_count==='Eligible'){
     		$(".overtime_rate").show();
     	}else{
     		$(".overtime_rate").hide();
     		$('#overtime_hourly_rate').val("");   
     	}
     	
     });     
     $("#half_day_absent").change(function(){
     	var half_day_absent=$("#half_day_absent").val();
     	if(half_day_absent==='Eligible'){
     		$(".absent_cnt_time").show();
     	}else{
     		$(".absent_cnt_time").hide();
     		$('#absent_count_time').val("");   
     	}
     	
     });
     $("#emp_shift").change(function(){
     	var emp_shift_id=$("#emp_shift").val();
			var base_url='<?php echo base_url();?>';
			var postData = {
				"emp_shift_id" : emp_shift_id
			};
			if(emp_shift_id){
				$.ajax({
					type: "POST",
					url: ""+base_url+"addprofile/getshifttime",
					data: postData,
					dataType:'json',
					success: function(data){
			     //console.log(data);
			     if(data.id){
			    $('#attendance_required').val(data.parents_term);    
			    $('#emp_working_time_from').val(data.weight);    
			    $('#emp_working_end_time').val(data.url_path);    
			    $('#emp_latecount_time').val(data.page_title);    
			    $('#emp_earlycount_time').val(data.page_description);    
			    $('#logout_required').val(data.keywords);    
			    $('#half_day_absent').val(data.reserved1);
				    if(data.reserved2){
				    	 $('#absent_count_time').val(data.reserved2);   
				    	 $('.absent_cnt_time').show();   
				    }else{
				    	$('#absent_count_time').val("");   
				    	 $('.absent_cnt_time').hide();
				    }   		     	
			     }
			}
			});    				
			}
     }); 
     // Payroll Area ---------------------------------------------------------------------------Pay Roll Area Start---------------------------------
     $("#increment_area").hide();
     $('#salary_area').find('input').attr('readonly', 'readonly').css("background-color","#F0E68C");
     $("#emp_basic_salary").removeAttr("readonly", "readonly").css("background-color","#FFF");
     $("#emp_telephone_allowance").removeAttr("readonly", "readonly").css("background-color","#FFF");
     $("#emp_festival_bonus").removeAttr("readonly", "readonly").css("background-color","#FFF");
     
    //$('#content_9').find('input, textarea, button, select').attr('disabled','disabled');
    $('#emp_yearly_paid').attr('readonly','readonly');
    <?php $salary_count=count($salary_amount_previous);
    if($salary_count){ ?>
//	$('#content_9').find('input').attr('readonly','readonly');
//	$('#content_9').find('input#emp_salary_update, input#emp_salary_increment, input#emp_bank_account, input#emp_bank_branch').removeAttr( "readonly" );
	<?php }else{ ?>
		$('#increment_area').find('input').attr('readonly','readonly');
		$('#increment_area').find('input').val('');
		<?php	} ?>
		<?php 

		if($salary_count>1){
		    echo "$('#emp_basic_salary').attr('readonly','readonly').css('background-color','#F0E68C');";
		    echo "$('#emp_gross_salary').attr('readonly','readonly').css('background-color','#F0E68C');";
			$previoussalary=$salary_amount_previous[1]['gross_salary'];
			echo "var previous_salary= $previoussalary; "; 
			$presentsalry=$salary_amount_previous[0]['gross_salary'];
			if($presentsalry){
				echo "var present_salary= $presentsalry; "; 
			}else{
				echo "var present_salary= 0; ";
			}
		}else{ 
		    echo "$('#emp_basic_salary').removeAttr('readonly','readonly').css('background-color','#FFF');";
		    echo "$('#emp_gross_salary').removeAttr('readonly','readonly').css('background-color','#FFF');";
			$presentsalry=$salary_amount_previous[0]['gross_salary'];
			if($presentsalry){
				echo "var present_salary= $presentsalry; "; 
			}else{
				echo "var present_salary= 0; ";
			}

			?>
			var previous_salary= 0; 

		<?php } ?>

     $("#emp_gross_salary").keyup(function(){
         
    	var gross_salary=$(this).val();
    	if(!gross_salary){
    	    gross_salary=0;
    	}
    	var basic_salary=Math.round(gross_salary/100*50);
    	var house_rent=Math.round(basic_salary/100*60);
    	var medical_allow=Math.round(basic_salary/100*20);
    	//var conveyance_allow=Math.round(total_salary_increment/100*8.88888889);
    	//var provident_allow=Math.round(total_salary_increment/100*4.44445);
    	var transport_allow=Math.round(basic_salary/100*10);
    	//var without_other_allow=basic_salary+house_rent+medical_allow+conveyance_allow+provident_allow+transport_allow;
    	var other_allow=Math.round(basic_salary/100*10);
    	var total_benifit=house_rent+medical_allow+transport_allow+other_allow;
    	$('#emp_basic_salary').val(basic_salary);
    	$('#emp_house_rent').val(house_rent);
    	$('#emp_medical_allowance').val(medical_allow);
    	//$('#conveyance_allow').val(conveyance_allow);
    	//$('#provident_allow').val(provident_allow);
    	$('#emp_transport_allowance').val(transport_allow);
    	$('#emp_other_allowance').val(other_allow);
    	$('#emp_total_benifit').val(total_benifit);
    	var yearly_salary= gross_salary * 12;
    	$('#emp_yearly_paid').val(yearly_salary);  
    	//$('#emp_increment_percentage').val(emp_increment_percentage+"%");  

    });
    $("#emp_basic_salary").keyup(function(){
    	var basic_salary=$(this).val();
    	if(!basic_salary){
    	    basic_salary=0;
    	}
    	var house_rent=Math.round(basic_salary/100*60);
    	var medical_allow=Math.round(basic_salary/100*20);
    	//var conveyance_allow=Math.round(total_salary_increment/100*8.88888889);
    	//var provident_allow=Math.round(total_salary_increment/100*4.44445);
    	var transport_allow=Math.round(basic_salary/100*10);
    	//var without_other_allow=basic_salary+house_rent+medical_allow+conveyance_allow+provident_allow+transport_allow;
    	var other_allow=Math.round(basic_salary/100*10);
    	var total_benifit=parseInt(house_rent)+parseInt(medical_allow)+parseInt(transport_allow)+parseInt(other_allow);
    	var gross_salary=parseInt(basic_salary)+parseInt(total_benifit);
    	$('#emp_house_rent').val(house_rent);
    	$('#emp_medical_allowance').val(medical_allow);
    	//$('#conveyance_allow').val(conveyance_allow);
    	//$('#provident_allow').val(provident_allow);
    	$('#emp_transport_allowance').val(transport_allow);
    	$('#emp_other_allowance').val(other_allow);
    	$('#emp_total_benifit').val(total_benifit);
    	$('#emp_gross_salary').val(gross_salary);
    	var yearly_salary= gross_salary * 12;
    	$('#emp_yearly_paid').val(yearly_salary);  
    	//$('#emp_increment_percentage').val(emp_increment_percentage+"%");  

    });
    
    // Deduction Area ------------------------------------------------------
        
     $("#deduction_area").keyup(function () {
         
            var provident_fund_deduction = $('#emp_provident_fund_deduction').val();
            if (!provident_fund_deduction) {
                var provident_fund_deduction = 0;
            }
            
            var tax_deduction= $('#emp_tax_deduction').val();
            if(!tax_deduction){
                tax_deduction= 0;
            }
            var emp_other_deduction = $('#emp_other_deduction').val();
            if (!emp_other_deduction) {
                var emp_other_deduction = 0;
            }
           
            var total_deduction = parseInt(provident_fund_deduction) + parseInt(tax_deduction) + parseInt(emp_other_deduction);
            $('#emp_total_deduction').val(total_deduction);
    });
    
// Increment Area ------------------------------------------------------
$("#emp_salary_increment").click(function(){
	
	if($(this).is(':checked')) {
	    $("#increment_area").show(1000);
		$('#emp_salary_update').removeAttr( "checked" );
	//	$('#content_9').find('input, textarea, button, select').removeAttr( "readonly" );
		$('#emp_basic_salary').attr('readonly', 'readonly').css("background-color","#F0E68C");
		$('#emp_gross_salary').attr('readonly','readonly');
		$('#emp_yearly_paid').attr('readonly','readonly');
	} else {
	    $("#increment_area").hide(1000);
	//	$('#content_9').find('input').attr('readonly','readonly');
	<?php
	if($salary_count<=1){
	?>
		$('#emp_gross_salary').removeAttr('readonly','readonly');
		$('#emp_basic_salary').removeAttr('readonly', 'readonly').css("background-color","#FFF");
		<?php }?>
		$('#content_9').find('input#emp_salary_update, input#emp_salary_increment, input#emp_bank_account, input#emp_bank_branch').removeAttr( "readonly" );
	}
});

  $("#emp_salary_increment_amount").keyup(function(){

        var increment_amount=$(this).val();
        if(!increment_amount){
        increment_amount=0;
    }
    	var emp_increment_percentage= Math.round(increment_amount*100/present_salary); 
    if(!isNaN(emp_increment_percentage)){
		$('#emp_increment_percentage').val(emp_increment_percentage+"%");  
	} 
    		var total_deduction=$('#emp_total_deduction').val();
	if(!total_deduction){
		total_deduction=0;
	}

	var gross_total=parseInt(present_salary)+parseInt(increment_amount);
	$('#emp_gross_salary').val(gross_total);
	var yearly_salary= gross_total * 12;
    $('#emp_yearly_paid').val(yearly_salary); 
    

	//alert(increment_amount);

	// Math.round(65.98);
	var basic_salary=Math.round(gross_total/100*50);
	var house_rent=Math.round(basic_salary/100*60);
	var medical_allow=Math.round(basic_salary/100*20);
	//var conveyance_allow=Math.round(total_salary_increment/100*8.88888889);
	//var provident_allow=Math.round(total_salary_increment/100*4.44445);
	var transport_allow=Math.round(basic_salary/100*10);
	//var without_other_allow=basic_salary+house_rent+medical_allow+conveyance_allow+provident_allow+transport_allow;
	var other_allow=Math.round(basic_salary/100*10);
	var total_benifit=house_rent+medical_allow+transport_allow+other_allow;
	$('#emp_basic_salary').val(basic_salary);
	$('#emp_house_rent').val(house_rent);
	$('#emp_medical_allowance').val(medical_allow);
	//$('#conveyance_allow').val(conveyance_allow);
	//$('#provident_allow').val(provident_allow);
	$('#emp_transport_allowance').val(transport_allow);
	$('#emp_other_allowance').val(other_allow);
	$('#emp_total_benifit').val(total_benifit);
});
    
/*
			$("#salary_area").keyup(function(){
				var emp_basic_salary=$('#emp_basic_salary').val();
				var emp_house_rent=$('#emp_house_rent').val();
				if(!emp_house_rent) {
					var emp_house_rent = 0;
				}
				var emp_medical_allowance=$('#emp_medical_allowance').val();
				if(!emp_medical_allowance) {
					var emp_medical_allowance = 0;
				}     	
				var emp_conveyance=$('#emp_conveyance').val();
				if(!emp_conveyance) {
					var emp_conveyance = 0;
				}       	
				var emp_telephone_allowance=$('#emp_telephone_allowance').val();
				if(!emp_telephone_allowance) {
					var emp_telephone_allowance = 0;
				}      	
				var emp_special_allowance=$('#emp_special_allowance').val();
				if(!emp_special_allowance) {
					var emp_special_allowance = 0;
				}     	
				var emp_provident_fund_allowance=$('#emp_provident_fund_allowance').val();
				if(!emp_provident_fund_allowance) {
					var emp_provident_fund_allowance = 0;
				}        	
				var emp_transport_allowance=$('#emp_transport_allowance').val();  
				if(!emp_transport_allowance) {
					var emp_transport_allowance = 0;
				}     	 	
				var emp_other_allowance=$('#emp_other_allowance').val(); 
				if(!emp_other_allowance) {
					var emp_other_allowance = 0;
				}      	   	
				var emp_performance_bonus=$('#emp_performance_bonus').val();   	
				if(!emp_performance_bonus) {
					var emp_performance_bonus = 0;
				}      	
				var emp_festival_bonus=$('#emp_festival_bonus').val(); 
				if(!emp_festival_bonus) {
					var emp_festival_bonus = 0;
				}      	
				var total_benifit=parseInt(emp_house_rent)+parseInt(emp_medical_allowance)+parseInt(emp_conveyance)+parseInt(emp_telephone_allowance)+parseInt(emp_special_allowance)+parseInt(emp_provident_fund_allowance)+parseInt(emp_transport_allowance)+parseInt(emp_other_allowance)+parseInt(emp_performance_bonus)+parseInt(emp_festival_bonus);
				$('#emp_total_benifit').val(total_benifit);  
				var emp_provident_fund_deduction= $('#emp_provident_fund_deduction').val(); 
				if(!emp_provident_fund_deduction) {
					var emp_provident_fund_deduction = 0;
				}    
			// var emp_advance_loan= $('#emp_advance_loan').val(); 
			// if(!emp_advance_loan) {
			// 	var emp_advance_loan = 0;
			// } 
			var emp_other_deduction= $('#emp_other_deduction').val(); 
			if(!emp_other_deduction) {
				var emp_other_deduction = 0;
			} 
		// if(!present_salary) {
		// var present_salary = 0;
		// } 
		var total_deduction=parseInt(emp_provident_fund_deduction)+	parseInt(emp_other_deduction);					
		$('#emp_total_deduction').val(total_deduction);  
		var gross_salary=parseInt(total_benifit)+parseInt(emp_basic_salary)-parseInt(total_deduction);
     	// var previous_salary= $('#emp_gross_salary').val(); 
     	if($('#emp_salary_increment').is(':checked')) {
     		var total_gross_salary=parseInt(present_salary)+parseInt(gross_salary);
     		var total_increment_amount=parseInt(emp_basic_salary)+	parseInt(total_benifit);
     		$('#emp_salary_increment_amount').val(total_increment_amount);  
     		var emp_increment_percentage= Math.round(total_increment_amount*100/present_salary);     		
     	}else if($('#emp_salary_update').is(':checked')){
     		var total_gross_salary=parseInt(previous_salary)+parseInt(gross_salary);
     		var emp_increment_percentage= Math.round(total_increment_amount*100/previous_salary); 
     	}else{
     		var total_gross_salary=parseInt(gross_salary);
     	}

     	$('#emp_gross_salary').val(total_gross_salary);   
     	var yearly_salary= total_gross_salary * 12;
     	$('#emp_yearly_paid').val(yearly_salary); 
     	if(!isNaN(emp_increment_percentage)){
     		$('#emp_increment_percentage').val(emp_increment_percentage+"%");
     	}

     });
     */


$("#emp_salary_update").click(function(){
	
	$('#emp_basic_salary').val('');
	$('#emp_house_rent').val('');
	$('#emp_medical_allowance').val('');
	$('#emp_conveyance').val('');
	$('#emp_telephone_allowance').val('');
	$('#emp_special_allowance').val('');
	$('#emp_provident_fund_allowance').val('');
	$('#emp_transport_allowance').val('');
	$('#emp_other_allowance').val('');
	$('#emp_performance_bonus').val('');
	$('#emp_festival_bonus').val('');
	$('#emp_total_benifit').val('');
	$('#emp_salary_increment_amount').val('');
	$('#emp_increment_date').val('');
	$('#emp_increment_percentage').val('');				
	if($(this).is(':checked')) {
		$('#emp_salary_increment').removeAttr( "checked" );
		$('#content_9').find('input, textarea, button, select').removeAttr( "readonly" );
		$('#emp_yearly_paid').attr('readonly','readonly');	
	} else {
		$('#content_9').find('input').attr('readonly','readonly');
		$('#content_9').find('input#emp_salary_update, input#emp_salary_increment, input#emp_bank_account, input#emp_bank_branch').removeAttr( "readonly" );
	}		
});

$( document ).on( "keydown", function( event ) {
	if (event.which == 77 && event.ctrlKey) {
  $("#emp_id").focus(); //ctrl+M
}        
if (event.which == 81 && event.ctrlKey) {
  $("#myForm").submit(); // ctrl+Q
}                          

});
$(document).on('keydown', 'input#emp_id', function(e) { 
	var keyCode = e.keyCode || e.which; 

    if (keyCode == 9) { //tab key
    	e.preventDefault(); 
    // call custom function here
    var emp_code = $("#emp_id").val(); 
    var base_url='<?php echo base_url();?>';
    var postData = {
    	"emp_code" : emp_code
    };
    $.ajax({
    	type: "POST",
    	url: ""+base_url+"addprofile/getempcontentid",
    	data: postData,
    	dataType:'json',
    	success: function(data){
    		if (data) {
    			window.location.href = "" + base_url + "addprofile/addemployee/"+data;
    		}else{
    			$("#emp_name").focus();     	
    		}
    	}

    });
    
} 
});
$( document ).on( "keydown", function( event ) {
if (event.which == 66 && event.ctrlKey) { //ctrl+B
	var emp_code = $("#emp_id").val(); 
	var base_url='<?php echo base_url();?>';
	var postData = {
		"emp_code" : emp_code
	};
	$.ajax({
		type: "POST",
		url: ""+base_url+"addprofile/getempcontentid",
		data: postData,
		dataType:'json',
		success: function(data){
			if (data) {
				window.location.href = "" + base_url + "addprofile/addemployee/"+data;
			}
		}

	});          
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


// document.ready end
});
// function monthDiff(day1, day2) {
// 	var d1= day1,d2= day2;
// 	if(day1<day2){
// 		d1= day2;
// 		d2= day1;
// 	}
// 	var m= (d1.getFullYear()-d2.getFullYear())*12+(d1.getMonth()-d2.getMonth());
// 	if(d1.getDate()<d2.getDate()) --m;
// 	return m;    
// }
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

if($search_field_emp_data['emp_name']){
	$emp_name=$search_field_emp_data['emp_name'];
}
if($search_field_emp_data['content_id']){
	$content_id=$search_field_emp_data['content_id'];
}
if($search_field_emp_data['emp_id']){
	$emp_id=$search_field_emp_data['emp_id'];
}
if($search_field_emp_data['emp_post_id']){
	$emp_position=$search_field_emp_data['emp_post_id'];
}
if($search_field_emp_data['grade']){
	$emp_grade=$search_field_emp_data['grade'];
}

if($search_field_emp_data['emp_division']){
	$emp_company=$search_field_emp_data['emp_division'];
}
if($search_field_emp_data['emp_department']){
	$emp_division=$search_field_emp_data['emp_department'];
}
if($search_field_emp_data['department_id']){
	$emp_department=$search_field_emp_data['department_id'];
}
if($search_field_emp_data['gender']){
	$emp_gender=$search_field_emp_data['gender'];
}

if($search_field_emp_data['dob']){
	$emp_dob=$search_field_emp_data['dob'];
}

if($search_field_emp_data['national_id']){
	$emp_nid=$search_field_emp_data['national_id'];
}
if($search_field_emp_data['tin']){
	$emp_tin=$search_field_emp_data['tin'];
}
if($search_field_emp_data['marital_status']){
	$emp_marital_status=$search_field_emp_data['marital_status'];
}
if($search_field_emp_data['religion']){
	$emp_religion=$search_field_emp_data['religion'];
}

if($search_field_emp_data['age']){
	$emp_age=$search_field_emp_data['age'];
}
if($search_field_emp_data['joining_date']){
	$emp_starting_date=$search_field_emp_data['joining_date'];
}
if($search_field_emp_data['type_of_employee']){
	$emp_type=$search_field_emp_data['type_of_employee'];
}
if($search_field_emp_data['visa_selling']){
	$emp_visa_selling=$search_field_emp_data['visa_selling'];
}

if($search_field_emp_data['pay_type']){
	$emp_pay_type=$search_field_emp_data['pay_type'];
}
if($search_field_emp_data['distict']){ 
	$emp_current_distict=$search_field_emp_data['distict'];
}
if($search_field_emp_data['mobile_no']){
	$emp_mobile_no=$search_field_emp_data['mobile_no'];
}
// provision variable
if($provision['provision_date_from']){
	$emp_provision_starting_date=$provision['provision_date_from'];
}
if($provision['provision_date_to']){
	$emp_provision_ending_date=$provision['provision_date_to'];
}
if($working_time['work_starting_time']){
	$emp_working_time_from=$working_time['work_starting_time'];
}
if($working_time['work_ending_time']){
	$emp_working_end_time=$working_time['work_ending_time'];
}
if($working_time['attendance_required']){
	$attendance_required=$working_time['attendance_required'];
}
if($working_time['emp_latecount_time']){
	$emp_latecount_time=$working_time['emp_latecount_time'];
}
if($working_time['emp_earlycount_time']){
	$emp_earlycount_time=$working_time['emp_earlycount_time'];
}

if($working_time['logout_required']){
	$logout_required=$working_time['logout_required'];
}
if($working_time['half_day_absent']){
	$half_day_absent=$working_time['half_day_absent'];
}
if($working_time['absent_count_time']){
	$absent_count_time=$working_time['absent_count_time'];
}
if($working_time['overtime_count']){
	$overtime_count=$working_time['overtime_count'];
}
if($working_time['overtime_hourly_rate']){
	$overtime_hourly_rate=$working_time['overtime_hourly_rate'];
}

// Payroll --------------------------------------------------------------------------Payroll PHP ---------------------------
/*
foreach ($salary_allamount as $single_salary) {
	if($single_salary['basic_salary']){
		$emp_basic_salary +=$single_salary['basic_salary'];
	}
	if($single_salary['house_rent']){
		$emp_house_rent +=$single_salary['house_rent'];
		
	}
	if($single_salary['medical_allow']){
		$emp_medical_allowance +=$single_salary['medical_allow'];
	}
	if($single_salary['conveyance_allow']){
		$emp_conveyance +=$single_salary['conveyance_allow'];
	}
	if($single_salary['telephone_allow']){
		$emp_telephone_allowance +=$single_salary['telephone_allow'];
	}
	if($single_salary['special_allowa']){
		$emp_special_allowance +=$single_salary['special_allowa'];
	}
	if($single_salary['provident_allow']){
		$emp_provident_fund_allowance +=$single_salary['provident_allow'];
	}
	if($single_salary['transport_allow']){
		$emp_transport_allowance +=$single_salary['transport_allow'];
	}
	if($single_salary['other_allow']){
		$emp_other_allowance +=$single_salary['other_allow'];
	}
	if($single_salary['performance_bonus']){
		$emp_performance_bonus +=$single_salary['performance_bonus'];
	}
	if($single_salary['festival_bonus']){
		$emp_festival_bonus +=$single_salary['festival_bonus'];
	}
	if($single_salary['total_benifit']){
		$emp_total_benifit +=$single_salary['total_benifit'];
	}	
}
*/
if($salary_amount['gross_salary']){
	$emp_gross_salary=$salary_amount['gross_salary'];
	if(!$emp_gross_salary){
	    $emp_gross_salary=0;
	}
	$emp_basic_salary=$emp_gross_salary*50/100;
	$emp_house_rent=$emp_basic_salary*60/100;
	$emp_medical_allowance=$emp_basic_salary*20/100;
	$emp_transport_allowance=$emp_basic_salary*10/100;
	$emp_other_allowance=$emp_basic_salary*10/100;
	
	$emp_telephone_allowance=$salary_amount['telephone_allow'];
	$emp_festival_bonus=$salary_amount['festival_bonus'];
	
	$emp_total_benifit=$emp_house_rent+$emp_medical_allowance+$emp_transport_allowance+$emp_other_allowance;
	
	    
}
if($salary_amount['yearly_paid']){
	$emp_yearly_paid=$salary_amount['yearly_paid'];
}
if($salary_deduction['provident_fund_deduction']){
	$emp_provident_fund_deduction=$salary_deduction['provident_fund_deduction'];
}
if($salary_deduction['tax_deduction']){
	$emp_tax_deduction=$salary_deduction['tax_deduction'];
	if(!$emp_tax_deduction){
	    $emp_tax_deduction=0;
	}
}
if($salary_deduction['advance_loan']){
	$emp_advance_loan=$salary_deduction['advance_loan'];
}
if($salary_deduction['other_deduction']){
	$emp_other_deduction=$salary_deduction['other_deduction'];
}
if($salary_deduction['total_deduction']){
	$emp_total_deduction=$salary_deduction['total_deduction'];
}
if($payment_type['bank_name']){
	$emp_bank=$payment_type['bank_name'];
}
if($payment_type['emp_bank_branch']){
	$emp_bank_branch=$payment_type['emp_bank_branch'];
}
if($payment_type['emp_bank_account']){
	$emp_bank_account=$payment_type['emp_bank_account'];
}
if($payment_type['emp_pay_type']){
	$emp_pay_type=$payment_type['emp_pay_type'];
}
foreach ($emp_details_records as $value) {
	if($value['field_name']=='resources/uploads'){
		$picture=$value['field_value'];
	}else if($value['field_name']=='emp_nationality'){
		$emp_nationality=$value['field_value'];
	}else if($value['field_name']=='emp_fathername'){
		$emp_fathername=$value['field_value'];
	}else if($value['field_name']=='emp_mothername'){
		$emp_mothername=$value['field_value'];
	}else if($value['field_name']=='husband_wife_name'){
		$husband_wife_name=$value['field_value'];
	}else if($value['field_name']=='emp_blood_group'){
		$emp_blood_group=$value['field_value'];
	}else if($value['field_name']=='emp_qualification'){
		$emp_qualification=$value['field_value'];
	}else if($value['field_name']=='emp_parmanent_address'){
		$emp_parmanent_address=$value['field_value'];
	}else if($value['field_name']=='emp_parmanent_city'){
		$emp_parmanent_city=$value['field_value'];
	}else if($value['field_name']=='emp_parmanent_distict'){
		$emp_parmanent_distict=$value['field_value'];
	}else if($value['field_name']=='emp_present_city'){
		$emp_present_city=$value['field_value'];
	}else if($value['field_name']=='emp_home_phone'){
		$emp_home_phone=$value['field_value'];
	}else if($value['field_name']=='emp_email'){
		$emp_email=$value['field_value'];
	}else if($value['field_name']=='emp_alt_email'){
		$emp_alt_email=$value['field_value'];
	}else if($value['field_name']=='emp_present_address'){
		$emp_present_address=$value['field_value'];
	}else if($value['field_name']=='emp_office_phone'){
		$emp_office_phone=$value['field_value'];
	}else if($value['field_name']=='emp_emergency_contact'){
		$emp_emergency_contact=$value['field_value'];
	}else if($value['field_name']=='emp_training_course_1'){
		$emp_training_course_1=$value['field_value'];
	}else if($value['field_name']=='emp_training_course_2'){
		$emp_training_course_2=$value['field_value'];
	}else if($value['field_name']=='emp_training_course_3'){
		$emp_training_course_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_course_4'){
		$emp_training_course_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_course_5'){
		$emp_training_course_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_course_6'){
		$emp_training_course_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_course_7'){
		$emp_training_course_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_datefrom_1'){
		$emp_training_datefrom_1=$value['field_value'];
	}else if($value['field_name']=='emp_training_datefrom_2'){
		$emp_training_datefrom_2=$value['field_value'];
	}else if($value['field_name']=='emp_training_datefrom_3'){
		$emp_training_datefrom_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_datefrom_4'){
		$emp_training_datefrom_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_datefrom_5'){
		$emp_training_datefrom_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_datefrom_6'){
		$emp_training_datefrom_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_datefrom_7'){
		$emp_training_datefrom_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_dateto_1'){
		$emp_training_dateto_1=$value['field_value'];
	}else if($value['field_name']=='emp_training_dateto_2'){
		$emp_training_dateto_2=$value['field_value'];
	}else if($value['field_name']=='emp_training_dateto_3'){
		$emp_training_dateto_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_dateto_4'){
		$emp_training_dateto_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_dateto_5'){
		$emp_training_dateto_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_dateto_6'){
		$emp_training_dateto_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_dateto_7'){
		$emp_training_dateto_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_duration_1'){
		$emp_training_duration_1=$value['field_value'];
	}else if($value['field_name']=='emp_training_duration_2'){
		$emp_training_duration_2=$value['field_value'];
	}else if($value['field_name']=='emp_training_duration_3'){
		$emp_training_duration_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_duration_4'){
		$emp_training_duration_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_duration_5'){
		$emp_training_duration_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_duration_6'){
		$emp_training_duration_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_duration_7'){
		$emp_training_duration_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_organization_1'){
		$emp_training_organization_1=$value['field_value'];
	}else if($value['field_name']=='emp_training_organization_2'){
		$emp_training_organization_2=$value['field_value'];
	}else if($value['field_name']=='emp_training_organization_3'){
		$emp_training_organization_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_organization_4'){
		$emp_training_organization_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_organization_5'){
		$emp_training_organization_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_organization_6'){
		$emp_training_organization_3=$value['field_value'];
	}else if($value['field_name']=='emp_training_organization_7'){
		$emp_training_organization_3=$value['field_value'];
	}else if($value['field_name']=='emp_exp_position_1'){
		$emp_exp_position_1=$value['field_value'];
	}else if($value['field_name']=='emp_exp_position_2'){
		$emp_exp_position_2=$value['field_value'];
	}else if($value['field_name']=='emp_exp_position_3'){
		$emp_exp_position_3=$value['field_value'];
	}else if($value['field_name']=='emp_exp_position_4'){
		$emp_exp_position_4=$value['field_value'];
	}else if($value['field_name']=='emp_exp_position_5'){
		$emp_exp_position_5=$value['field_value'];
	}else if($value['field_name']=='emp_exp_position_6'){
		$emp_exp_position_5=$value['field_value'];
	}else if($value['field_name']=='emp_exp_position_7'){
		$emp_exp_position_5=$value['field_value'];
	}else if($value['field_name']=='emp_exp_datefrom_1'){
		$emp_exp_datefrom_1=$value['field_value'];
	}else if($value['field_name']=='emp_exp_datefrom_2'){
		$emp_exp_datefrom_2=$value['field_value'];
	}else if($value['field_name']=='emp_exp_datefrom_3'){
		$emp_exp_datefrom_3=$value['field_value'];
	}else if($value['field_name']=='emp_exp_datefrom_4'){
		$emp_exp_datefrom_4=$value['field_value'];
	}else if($value['field_name']=='emp_exp_datefrom_5'){
		$emp_exp_datefrom_5=$value['field_value'];
	}else if($value['field_name']=='emp_exp_datefrom_6'){
		$emp_exp_datefrom_5=$value['field_value'];
	}else if($value['field_name']=='emp_exp_datefrom_7'){
		$emp_exp_datefrom_5=$value['field_value'];
	}else if($value['field_name']=='emp_exp_dateto_1'){
		$emp_exp_dateto_1=$value['field_value'];
	}else if($value['field_name']=='emp_exp_dateto_2'){
		$emp_exp_dateto_2=$value['field_value'];
	}else if($value['field_name']=='emp_exp_dateto_3'){
		$emp_exp_dateto_3=$value['field_value'];
	}else if($value['field_name']=='emp_exp_dateto_4'){
		$emp_exp_dateto_4=$value['field_value'];
	}else if($value['field_name']=='emp_exp_dateto_5'){
		$emp_exp_dateto_5=$value['field_value'];
	}else if($value['field_name']=='emp_exp_dateto_6'){
		$emp_exp_dateto_5=$value['field_value'];
	}else if($value['field_name']=='emp_exp_dateto_7'){
		$emp_exp_dateto_5=$value['field_value'];
	}else if($value['field_name']=='emp_exp_duration_1'){
		$emp_exp_duration_1=$value['field_value'];
	}else if($value['field_name']=='emp_exp_duration_2'){
		$emp_exp_duration_2=$value['field_value'];
	}else if($value['field_name']=='emp_exp_duration_3'){
		$emp_exp_duration_3=$value['field_value'];
	}else if($value['field_name']=='emp_exp_duration_4'){
		$emp_exp_duration_4=$value['field_value'];
	}else if($value['field_name']=='emp_exp_duration_5'){
		$emp_exp_duration_5=$value['field_value'];
	}else if($value['field_name']=='emp_exp_duration_6'){
		$emp_exp_duration_5=$value['field_value'];
	}else if($value['field_name']=='emp_exp_duration_7'){
		$emp_exp_duration_5=$value['field_value'];
	}else if($value['field_name']=='emp_exp_organization_1'){
		$emp_exp_organization_1=$value['field_value'];
	}else if($value['field_name']=='emp_exp_organization_2'){
		$emp_exp_organization_2=$value['field_value'];
	}else if($value['field_name']=='emp_exp_organization_3'){
		$emp_exp_organization_3=$value['field_value'];
	}else if($value['field_name']=='emp_exp_organization_4'){
		$emp_exp_organization_4=$value['field_value'];
	}else if($value['field_name']=='emp_exp_organization_5'){
		$emp_exp_organization_5=$value['field_value'];
	}else if($value['field_name']=='emp_exp_organization_6'){
		$emp_exp_organization_5=$value['field_value'];
	}else if($value['field_name']=='emp_exp_organization_7'){
		$emp_exp_organization_5=$value['field_value'];
	}else if($value['field_name']=='emp_education_level_1'){
		$emp_education_level_1=$value['field_value'];
	}else if($value['field_name']=='emp_education_level_2'){
		$emp_education_level_2=$value['field_value'];
	}else if($value['field_name']=='emp_education_level_3'){
		$emp_education_level_3=$value['field_value'];
	}else if($value['field_name']=='emp_education_level_4'){
		$emp_education_level_4=$value['field_value'];
	}else if($value['field_name']=='emp_education_level_5'){
		$emp_education_level_5=$value['field_value'];
	}else if($value['field_name']=='emp_education_degree_1'){
		$emp_education_degree_1=$value['field_value'];
	}else if($value['field_name']=='emp_education_degree_2'){
		$emp_education_degree_2=$value['field_value'];
	}else if($value['field_name']=='emp_education_degree_3'){
		$emp_education_degree_3=$value['field_value'];
	}else if($value['field_name']=='emp_education_degree_4'){
		$emp_education_degree_4=$value['field_value'];
	}else if($value['field_name']=='emp_education_degree_5'){
		$emp_education_degree_5=$value['field_value'];
	}else if($value['field_name']=='emp_education_major_1'){
		$emp_education_major_1=$value['field_value'];
	}else if($value['field_name']=='emp_education_major_2'){
		$emp_education_major_2=$value['field_value'];
	}else if($value['field_name']=='emp_education_major_3'){
		$emp_education_major_3=$value['field_value'];
	}else if($value['field_name']=='emp_education_major_4'){
		$emp_education_major_4=$value['field_value'];
	}else if($value['field_name']=='emp_education_major_5'){
		$emp_education_major_5=$value['field_value'];
	}else if($value['field_name']=='emp_education_institute_1'){
		$emp_education_institute_1=$value['field_value'];
	}else if($value['field_name']=='emp_education_institute_2'){
		$emp_education_institute_2=$value['field_value'];
	}else if($value['field_name']=='emp_education_institute_3'){
		$emp_education_institute_3=$value['field_value'];
	}else if($value['field_name']=='emp_education_institute_4'){
		$emp_education_institute_4=$value['field_value'];
	}else if($value['field_name']=='emp_education_institute_5'){
		$emp_education_institute_5=$value['field_value'];
	}else if($value['field_name']=='emp_education_year_1'){
		$emp_education_year_1=$value['field_value'];
	}else if($value['field_name']=='emp_education_year_2'){
		$emp_education_year_2=$value['field_value'];
	}else if($value['field_name']=='emp_education_year_3'){
		$emp_education_year_3=$value['field_value'];
	}else if($value['field_name']=='emp_education_year_4'){
		$emp_education_year_4=$value['field_value'];
	}else if($value['field_name']=='emp_education_year_5'){
		$emp_education_year_5=$value['field_value'];
	}else if($value['field_name']=='emp_education_results_1'){
		$emp_education_results_1=$value['field_value'];
	}else if($value['field_name']=='emp_education_results_2'){
		$emp_education_results_2=$value['field_value'];
	}else if($value['field_name']=='emp_education_results_3'){
		$emp_education_results_3=$value['field_value'];
	}else if($value['field_name']=='emp_education_results_4'){
		$emp_education_results_4=$value['field_value'];
	}else if($value['field_name']=='emp_education_results_5'){
		$emp_education_results_5=$value['field_value'];
	}else if($value['field_name']=='emp_language_name_1'){
		$emp_language_name_1=$value['field_value'];
	}else if($value['field_name']=='emp_language_name_2'){
		$emp_language_name_2=$value['field_value'];
	}else if($value['field_name']=='emp_language_name_3'){
		$emp_language_name_3=$value['field_value'];
	}else if($value['field_name']=='emp_language_reading_1'){
		$emp_language_reading_1=$value['field_value'];
	}else if($value['field_name']=='emp_language_reading_2'){
		$emp_language_reading_2=$value['field_value'];
	}else if($value['field_name']=='emp_language_reading_3'){
		$emp_language_reading_3=$value['field_value'];
	}else if($value['field_name']=='emp_language_writing_1'){
		$emp_language_writing_1=$value['field_value'];
	}else if($value['field_name']=='emp_language_writing_2'){
		$emp_language_writing_2=$value['field_value'];
	}else if($value['field_name']=='emp_language_writing_3'){
		$emp_language_writing_3=$value['field_value'];
	}else if($value['field_name']=='emp_language_speaking_1'){
		$emp_language_speaking_1=$value['field_value'];
	}else if($value['field_name']=='emp_language_speaking_2'){
		$emp_language_speaking_2=$value['field_value'];
	}else if($value['field_name']=='emp_language_speaking_3'){
		$emp_language_speaking_3=$value['field_value'];
	}else if($value['field_name']=='emp_language_listening_1'){
		$emp_language_listening_1=$value['field_value'];
	}else if($value['field_name']=='emp_language_listening_2'){
		$emp_language_listening_2=$value['field_value'];
	}else if($value['field_name']=='emp_language_listening_3'){
		$emp_language_listening_3=$value['field_value'];
	}else if($value['field_name']=='emp_computer_training'){
		$emp_computer_training=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_name_1'){
		$emp_dependent_name_1=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_name_2'){
		$emp_dependent_name_2=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_name_3'){
		$emp_dependent_name_3=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_name_4'){
		$emp_dependent_name_4=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_name_5'){
		$emp_dependent_name_5=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_dob_1'){
		$emp_dependent_dob_1=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_dob_2'){
		$emp_dependent_dob_2=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_dob_3'){
		$emp_dependent_dob_3=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_dob_4'){
		$emp_dependent_dob_4=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_dob_5'){
		$emp_dependent_dob_5=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_relation_1'){
		$emp_dependent_relation_1=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_relation_2'){
		$emp_dependent_relation_2=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_relation_3'){
		$emp_dependent_relation_3=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_relation_4'){
		$emp_dependent_relation_4=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_relation_5'){
		$emp_dependent_relation_5=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_nomtype_1'){
		$emp_dependent_nomtype_1=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_nomtype_2'){
		$emp_dependent_nomtype_2=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_nomtype_3'){
		$emp_dependent_nomtype_3=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_nomtype_4'){
		$emp_dependent_nomtype_4=$value['field_value'];
	}else if($value['field_name']=='emp_dependent_nomtype_5'){
		$emp_dependent_nomtype_5=$value['field_value'];
	}else if($value['field_name']=='emp_reference_name_1'){
		$emp_reference_name_1=$value['field_value'];
	}else if($value['field_name']=='emp_reference_name_2'){
		$emp_reference_name_2=$value['field_value'];
	}else if($value['field_name']=='emp_reference_name_3'){
		$emp_reference_name_3=$value['field_value'];
	}else if($value['field_name']=='emp_reference_position_1'){
		$emp_reference_position_1=$value['field_value'];
	}else if($value['field_name']=='emp_reference_position_2'){
		$emp_reference_position_2=$value['field_value'];
	}else if($value['field_name']=='emp_reference_position_3'){
		$emp_reference_position_3=$value['field_value'];
	}else if($value['field_name']=='emp_reference_org_1'){
		$emp_reference_org_1=$value['field_value'];
	}else if($value['field_name']=='emp_reference_org_2'){
		$emp_reference_org_2=$value['field_value'];
	}else if($value['field_name']=='emp_reference_org_3'){
		$emp_reference_org_3=$value['field_value'];
	}else if($value['field_name']=='emp_reference_address_1'){
		$emp_reference_address_1=$value['field_value'];
	}else if($value['field_name']=='emp_reference_address_2'){
		$emp_reference_address_2=$value['field_value'];
	}else if($value['field_name']=='emp_reference_address_3'){
		$emp_reference_address_3=$value['field_value'];
	}else if($value['field_name']=='emp_reference_phone_1'){
		$emp_reference_phone_1=$value['field_value'];
	}else if($value['field_name']=='emp_reference_phone_2'){
		$emp_reference_phone_2=$value['field_value'];
	}else if($value['field_name']=='emp_reference_phone_3'){
		$emp_reference_phone_3=$value['field_value'];
	}else if($value['field_name']=='emp_reference_email_1'){
		$emp_reference_email_1=$value['field_value'];
	}else if($value['field_name']=='emp_reference_email_2'){
		$emp_reference_email_2=$value['field_value'];
	}else if($value['field_name']=='emp_reference_email_3'){
		$emp_reference_email_3=$value['field_value'];
	}else if($value['field_name']=='emp_reference_relation_1'){
		$emp_reference_relation_1=$value['field_value'];
	}else if($value['field_name']=='emp_reference_relation_2'){
		$emp_reference_relation_2=$value['field_value'];
	}else if($value['field_name']=='emp_reference_relation_3'){
		$emp_reference_relation_3=$value['field_value'];
	}
}

date_default_timezone_set('Asia/Dhaka');
$servertime = time();
$now = date("d-m-Y", $servertime);
?>    
<style type="text/css">
	.provision{
		display: none;
	}
	.overtime_rate{
		display: none;
	}
	.absent_cnt_time{
		display: none;
	}
	.custom-row-radious2 {
		border-top: 1px solid #000;
	}	
	#add_profile_btn {
		padding: 8px;
		/*background: #DCEDF6;*/

	}
	            .chosen-container.chosen-container-single {
    width: 100% !important; /* or any value that fits your needs */
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
				<h4>Employee Registration</h4>         
			</div> 
			<div class="wrapper">
				<div class="row">
					<div class="col-md-12">
						<?php 
						print $this->session->flashdata('errors'); 
						print $this->session->flashdata('success'); 
						?>
						<form action="<?php echo base_url(); ?>addprofile/do_upload" method="post" class="myForm" id="myForm"  name="myForm" onSubmit="return validate();" enctype="multipart/form-data">
							<input type="hidden" id="content_id" name="content_id" value="<?php echo $content_id;?>">
							<input type="hidden" id="current_img" name="current_img" value="<?php echo $picture;?>">                    
							<div class="row ">
								<div class="col-md-12">
									<input type="submit" id="add_profile_btn" value="Save">
									<a href="<?php echo base_url(); ?>addprofile/addemployee" class="new-entry-link">New</a>
								</div>
							</div>							

							<div class="row custom-row-radious2">                 
								<div class="tabs">
									<ul class="tabs">
										<li class="activetab" id="Tab_1"> Employee Master </li>
										<!-- <li class="nonactivetab" id="Tab_2"> Contact </li> -->
										<!-- <li class="nonactivetab" id="Tab_3"> Trainings </li> -->
										<li class="nonactivetab" id="Tab_4"> Experiences/Trainings</li>
										<li class="nonactivetab" id="Tab_5"> Education </li>
										<!-- <li class="nonactivetab" id="Tab_6"> Language </li> -->
										<!-- <li class="nonactivetab" id="Tab_7"> Computer Skill </li> -->
										<li class="nonactivetab" id="Tab_8"> Others </li>
										<!-- <li class="nonactivetab" id="Tab_9"> PayRoll </li> -->
										<li class="nonactivetab" id="Tab_10"> Documents </li>                   
									</ul>
									<div class="tabcontent" id="content_1">
                                                                             <i class="fas fa-asterisk" style="font-size:10px;color:red"></i>  Fields are required.
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
                                                                                                                    <div class="col-md-4 bgcolor_D8D8D8">Company  <i class="fas fa-asterisk" style="font-size:7px;color:red"></i></div>
															<div class="col-md-8">
															
																<select name="emp_company" id="emp_company"> 
																	<option value="">Select Company</option>
																	<?php 
																	 if($user_type_id !=1){
																	 	echo '<option value="'.$companies['tid'].'" selected="selected" data-id="'.$companies['weight'].'">'.$companies['name'].'</option>';
																	 }else{
																		foreach ($companies as $single_company) {
																			if($emp_company==$single_company['tid']){
																				echo '<option value="'.$single_company['tid'].'" selected="selected" data-id="'.$single_company['weight'].'">'.$single_company['name'].'</option>';
																			}else{
																				echo '<option value="'.$single_company['tid'].'" data-id="'.$single_company['weight'].'">'.$single_company['name'].'</option>';
																			}
																		} 
																	}
																	?>
																</select>         
															</div>
														</div>			 										
														<div class="row">
                                                                                                                    <div class="col-md-4 bgcolor_D8D8D8">Employee Code <i class="fas fa-asterisk" style="font-size:7px;color:red"></i></div>
															<div class="col-md-8"><input type="text" name="emp_id" id="emp_id" autocomplete="off" value="<?php if($emp_id){ echo $emp_id;}else if($user_type_id !=1){ print $tobeaddempcode; } ?>"/></div>
														</div>													
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Name  <i class="fas fa-asterisk" style="font-size:7px;color:red"></i></div>
															<div class="col-md-8"><input type="text" name="emp_name" id="emp_name" autocomplete="off" value="<?php if($emp_name){ echo $emp_name;} ?>"/></div>
														</div>
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Division or Branch  <i class="fas fa-asterisk" style="font-size:7px;color:red"></i></div>
															<div class="col-md-8">
																<select name="emp_division" id="emp_division">
																	<option value="">Select Division</option>
																	<?php foreach ($division_selected as $single_division) {
																		if($emp_division==$single_division['tid']){
																			echo '<option value="'.$single_division['tid'].'" selected="selected">'.$single_division['name'].'</option>';
																		}else{
																			echo '<option value="'.$single_division['tid'].'">'.$single_division['name'].'</option>';
																		}
																	} ?>
																</select>         
															</div>
														</div>
                                                                                                                <div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Department <i class="fas fa-asterisk" style="font-size:7px;color:red"></i></div>
															<div class="col-md-8">
																<select name="emp_department" id="emp_department" class="chosen-select">
																	<option value="">Select Department</option>
                                                                                                                                        <?php foreach($departments as $department){?>
                                                                                                                                        <option value="<?php echo $department['tid']; ?>" <?php if($department['tid']==$emp_department){ echo "selected"; }?> ><?php echo $department['name']; ?></option>
                                                                                                                                        <?php } ?>
																</select>         
															</div>
														</div>
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Nationality</div>
															<div class="col-md-8">
																<select name="emp_nationality" id="emp_nationality"   data-placeholder="Choose a Country..." class="chosen-select" >
																	<option value=""></option>
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
															<div class="col-md-4 bgcolor_D8D8D8">Gender</div>
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
															<div class="col-md-4 bgcolor_D8D8D8">Date of Birth <i class="fas fa-asterisk" style="font-size:7px;color:red"></i></div>
															<div class="col-md-8"><input type="text" name="emp_dob" id="emp_dob" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if($emp_dob){ echo $emp_dob;} ?>"/></div>
														</div>                                       
													</div>
													<div class="col-md-6">
														<div class="row">
															<div class="col-md-4 bgcolor_D8D8D8">Father's Name <i class="fas fa-asterisk" style="font-size:7px;color:red"></i></div>
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
															<div class="col-md-4 bgcolor_D8D8D8">Husband/ Wife Name</div>
															<div class="col-md-8">
															<input type="text" name="husband_wife_name" id="husband_wife_name" 
															value="<?php if($husband_wife_name){ echo $husband_wife_name;} ?>"/>
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
															<div class="col-md-4 bgcolor_D8D8D8">Age</div>
															<div class="col-md-8"><input type="text" class="numbersdotOnly" name="emp_age" id="emp_age" value="<?php if($emp_age){ echo $emp_age;} ?>"/></div>
														</div> 
                                                                                                                                                                                                                                                            <div class="row">
                                                                                                                                                                                                                                                            <div class="col-md-4 bgcolor_D8D8D8" title="Tax Identification Number">TIN </div>
															<div class="col-md-8"><input type="text" class="numbersdotOnly" name="emp_tin" id="emp_tin" value="<?php if($emp_tin){ echo $emp_tin;} ?>"/></div>
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
														<select name="emp_parmanent_distict" id="emp_parmanent_distict" data-placeholder="Choose a District..." class="chosen-select">
															<option value=""></option>
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
											<div class="col-md-8 heading_style">
												Job
											</div>
											<div class="col-md-2 heading_style" style="text-align: right;">
												Select Shift
											</div>	
											<div class="col-md-2 heading_style" style="padding: 2px;">
												<select name="emp_shift" id="emp_shift" style="padding: 2px;font-size: 14px;">
													<option value="">Select Shift</option>
													<?php  
													foreach ($allworkingshift as $single_workingshift) {
														if($single_workingshift['name']){
															echo '<option value="'.$single_workingshift['tid'].'">'.$single_workingshift['name'].'</option>';
														}
														$working_shift ="";
													} ?>
												</select> 												
											</div>																						
										</div>																																											
										<div class="row">
											<div class="col-md-6">	
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Joining Date <i class="fas fa-asterisk" style="font-size:7px;color:red"></i></div>
													<div class="col-md-8">
														<input type="text" name="emp_starting_date" id="emp_starting_date" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if($emp_starting_date){ echo $emp_starting_date;} ?>"/>        
													</div>
												</div>

												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Position <i class="fas fa-asterisk" style="font-size:7px;color:red"></i></div>
													<div class="col-md-8">
														<select name="emp_position" id="emp_position" data-placeholder="Choose a Position..." class="chosen-select">
															<option value=""></option>
															<?php foreach ($alljobtitle as $single_jobtitle) {
																if($emp_position==$single_jobtitle['tid']){
																	echo '<option value="'.$single_jobtitle['tid'].'" selected="selected">'.$single_jobtitle['name'].'</option>';
																}else{
																	echo '<option value="'.$single_jobtitle['tid'].'">'.$single_jobtitle['name'].'</option>';
																}
															} ?>
														</select>         
													</div>
												</div>
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Grade <i class="fas fa-asterisk" style="font-size:7px;color:red"></i></div>
													<div class="col-md-8">
														<select name="emp_grade" id="emp_grade">
															<option value="">Select Grade</option>
															<?php foreach ($allgrade as $single_grade) {
																if($emp_grade==$single_grade['tid']){
																	echo '<option value="'.$single_grade['tid'].'" selected="selected">'.$single_grade['name'].'</option>';
																}else{
																	echo '<option value="'.$single_grade['tid'].'">'.$single_grade['name'].'</option>';
																}
															} ?>
														</select>         
													</div>
												</div>												
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Qualification</div>
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
													<div class="col-md-4 bgcolor_D8D8D8">Type Of Employee</div>
													<div class="col-md-8">
														<select name="emp_type" id="emp_type">
															<option value="">Select Type</option>
															<?php foreach ($alltypeofemployee as $single_emp_type) {
																if($emp_type==$single_emp_type['tid']){
																	echo '<option value="'.$single_emp_type['tid'].'" selected="selected">'.$single_emp_type['name'].'</option>';
																}else if(!$emp_type && $single_emp_type['tid']=='1'){
																	echo '<option value="'.$single_emp_type['tid'].'" selected="selected">'.$single_emp_type['name'].'</option>';
																}else{
																	echo '<option value="'.$single_emp_type['tid'].'">'.$single_emp_type['name'].'</option>';
																}
															} ?>
														</select>         
													</div>
												</div> 
																							
												<div class="row provision" style="<?php if($emp_provision_starting_date){ echo "display:block";} ?>">
													<div class="col-md-4 bgcolor_D8D8D8">provision Date From</div>
													<div class="col-md-8">
														<input type="text" name="emp_provision_starting_date" id="emp_provision_starting_date" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if($emp_provision_starting_date){ echo $emp_provision_starting_date;} ?>"/>        
													</div>
												</div>                 
												<div class="row provision" style="<?php if($emp_provision_starting_date){ echo "display:block";} ?>">
													<div class="col-md-4 bgcolor_D8D8D8">provision Date To</div>
													<div class="col-md-8">
														<input type="text" name="emp_provision_ending_date" id="emp_provision_ending_date" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if($emp_provision_ending_date){ echo $emp_provision_ending_date;} ?>"/>        
													</div>
												</div>
												<!--
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Visa Selling</div>
													<div class="col-md-8">
														<input type="checkbox" name="emp_visa_selling" id="emp_visa_selling" <?php 
														//if($emp_visa_selling){ echo 'checked="checked"';} ?>/>        
													</div>
												</div>	-->												
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Overtime Count</div>
													<div class="col-md-8">
														<select name="overtime_count" id="overtime_count">
															<option value="Not_Eligible" <?php if($overtime_count=='Not_Eligible'){print 'selected="selected"';} ?>>Not Eligible</option>														
															<option value="Eligible" <?php if($overtime_count=='Eligible'){print 'selected="selected"';} ?>>Eligible</option>
														</select>         
													</div>
												</div>
												<div class="row overtime_rate" style="<?php if($overtime_hourly_rate){ echo "display:block";} ?>">
													<div class="col-md-4 bgcolor_D8D8D8">Overtime Hourly Rate</div>
													<div class="col-md-8">
														<input type="text" name="overtime_hourly_rate" id="overtime_hourly_rate"  onkeypress="return isNumber(event);" value="<?php if($overtime_hourly_rate){ echo $overtime_hourly_rate;} ?>" placeholder="Amount in taka"/>        
													</div>
												</div>
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Effective Date <i class="fas fa-asterisk" style="font-size:7px;color:red"></i></div>
													<div class="col-md-8">
														<input type="text" name="emp_job_change_date" id="emp_job_change_date"  class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php //if($emp_starting_date){ echo $emp_starting_date;} //if($emp_job_change_date){ echo $emp_job_change_date;} ?>"/>        
													</div>
												</div> 																																																
											</div>
											<div class="col-md-6">  
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Present Salary</div> 
													<div class="col-md-8">
														<input type="text" name="emp_present_salary" id="emp_present_salary" readonly="readonly" onkeypress="return isNumber(event);" value="<?php if($emp_gross_salary){ echo $emp_gross_salary;} ?>"/>        
													</div>
												</div> 																																																				 
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Attendance Required</div>
													<div class="col-md-8">
														<select name="attendance_required" id="attendance_required">
															<option value="Required" <?php if($attendance_required=='Required'){print 'selected="selected"';} ?>>Required</option>
															<option value="Not_Required" <?php if($attendance_required=='Not_Required'){print 'selected="selected"';} ?>>Not Required</option>
															<option value="Optional" <?php if($attendance_required=='Optional'){print 'selected="selected"';} ?>>Optional</option>
														</select> 													        
													</div>
												</div> 												
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Work Starting Time</div>
													<div class="col-md-8">
														<input type="text" placeholder="e.g. hh:mm:ss" name="emp_working_time_from" id="emp_working_time_from" value="<?php if($emp_working_time_from){ echo $emp_working_time_from;}else{ echo "09:30:00";} ?>"/>        
													</div>
												</div>
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Work Ending Time</div>
													<div class="col-md-8">
														<input type="text" name="emp_working_end_time" id="emp_working_end_time" placeholder="e.g. hh:mm:ss"  value="<?php if($emp_working_end_time){ echo $emp_working_end_time;}else{ echo "17:30:00";} ?>"/>        
													</div>
												</div>	
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Late Count Time</div>
													<div class="col-md-8">
														<input type="text" name="emp_latecount_time" id="emp_latecount_time" placeholder="e.g. hh:mm:ss"  value="<?php if($emp_latecount_time){ echo $emp_latecount_time;}else{ echo "09:46:00";} ?>"/>        
													</div>
												</div>
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Early Count Time</div>
													<div class="col-md-8">
														<input type="text" name="emp_earlycount_time" id="emp_earlycount_time" placeholder="e.g. hh:mm:ss"  value="<?php if($emp_earlycount_time){ echo $emp_earlycount_time;}else{ echo "17:20:00";} ?>"/>        
													</div>
												</div>												
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Logout Required</div>
													<div class="col-md-8">
														<select name="logout_required" id="logout_required">
															<option value="Required" <?php if($logout_required=='Required'){print 'selected="selected"';} ?>>Required</option>
															<option value="Not_Required" <?php if($logout_required=='Not_Required'){print 'selected="selected"';} ?>>Not Required</option>
															<option value="Optional" <?php if($logout_required=='Optional'){print 'selected="selected"';} ?>>Optional</option>
														</select> 													        
													</div>
												</div> 		
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Half Day Absent</div>
													<div class="col-md-8">
														<select name="half_day_absent" id="half_day_absent">
															<option value="Not_Eligible" <?php if($half_day_absent=='Not_Eligible'){print 'selected="selected"';} ?>>Not Eligible</option>														
															<option value="Eligible" <?php if($half_day_absent=='Eligible'){print 'selected="selected"';} ?>>Eligible</option>
														</select> 													        
													</div>
												</div> 
												<div class="row absent_cnt_time" style="<?php if($absent_count_time){ echo "display:block";} ?>">
													<div class="col-md-4 bgcolor_D8D8D8">Absent Count Time</div>
													<div class="col-md-8">
														<input type="text" name="absent_count_time" id="absent_count_time" placeholder="e.g. hh:mm:ss"  value="<?php if($absent_count_time){ echo $absent_count_time;} ?>"/> 													        
													</div>
												</div> 																																																										 
												
											</div>
										</div>
										<div class="row">
											<div class="col-md-12 heading_style">
												Employee Weekly Holiday
											</div>
										</div>	
										<div class="row">
											<div class="col-md-12">
												<div class="row">
													<div class="col-md-2 bgcolor_D8D8D8">Weekly Holiday</div>
													<div class="col-md-10">
														<!-- <input type="text" name="emp_weekly_holiday" id="emp_weekly_holiday"  value="<?php if($emp_weekly_holiday){ echo $emp_weekly_holiday;} ?>"/>  -->
														<select name="emp_weekly_holiday[]" id="emp_weekly_holiday" size="7" multiple>
															<option value="fri" <?php if($emp_holiday['fri_off']=='off'){echo 'selected="selected"';}else if(!$emp_holiday){ echo 'selected="selected"';} ?>>Friday</option>
															<option value="sat" <?php if($emp_holiday['sat_off']=='off'){ echo 'selected="selected"';}else if(!$emp_holiday){ echo 'selected="selected"';}  ?>>Saturday</option>
															<option value="sun" <?php if($emp_holiday['sun_off']=='off'){ echo 'selected="selected"';} ?>>Sunday</option>
															<option value="mon" <?php if($emp_holiday['mon_off']=='off'){ echo 'selected="selected"';} ?>>Monday</option>
															<option value="tue" <?php if($emp_holiday['tue_off']=='off'){ echo 'selected="selected"';} ?>>Tuesday</option>
															<option value="wed" <?php if($emp_holiday['wed_off']=='off'){ echo 'selected="selected"';} ?>>Wednesday</option>
															<option value="thus"<?php if($emp_holiday['thus_off']=='off'){ echo 'selected="selected"';} ?>>Thusday</option>
														</select>       
													</div>
												</div>													
											</div>
										</div>
										<script>
										// $(document).ready(function(){
										// 	$("#leave_category_system").click(function(){
										// 			if($(this).is(':checked')) {
										// 				$('#leave_total_system').prop('checked', false);	
										// 				$('.category_leave_area').css({"display":"block"});
										// 				$('.total_leave_area').css({"display":"none"});
										// 			}else {
										// 				$('#leave_total_system').prop('checked', true);
										// 				$('.total_leave_area').css({"display":"block"});
										// 				$('.category_leave_area').css({"display":"none"});
										// 			}
										// 	});
										// 	$("#leave_total_system").click(function(){
										// 			if($(this).is(':checked')) {
										// 				$('#leave_category_system').prop('checked', false);	
										// 				$('.total_leave_area').css({"display":"block"});
										// 				$('.category_leave_area').css({"display":"none"});
										// 			}else {
										// 				$('#leave_category_system').prop('checked', true);	
										// 				$('.total_leave_area').css({"display":"none"});
										// 				$('.category_leave_area').css({"display":"block"});
										// 			}													
										// 	});											
										// });
										</script>
										<?php 
										// $has_cat_leave=$this->emp_leave_model->getemp_yearlyleavebyid($toedit_id);
										// $leave_cat_count=count($has_cat_leave);
										 ?>
										<div class="row">
											<div class="col-md-12 heading_style">
												Employee Yearly Leave
											</div>
											<!-- <div class="col-md-2 heading_style" style="font-size: 13px;padding: 4.9px;">
												<input type="checkbox" id="leave_total_system" name="leave_total_system" <?php //if($emp_total_leave){ print 'checked="checked"'; }else if(!$leave_cat_count){ print 'checked="checked"'; } ?>> Total System
											</div>	 -->
											<!-- <div class="col-md-2 heading_style" style="font-size: 13px;padding: 4.9px;padding: 14px;"> -->
												<!-- <input type="checkbox" id="leave_category_system" name="leave_category_system" <?php //if($leave_cat_count && !$emp_total_leave){ print 'checked="checked"'; } ?>> Category System -->
											<!-- </div>																						 -->
										</div>		

										<div class="total_leave_area">
											<div class="row">
												<div class="col-md-6">
												<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Total Leave</div>
														<div class="col-md-8">
															<input type="text" name="annual_leave_total" id="annual_leave_total"  onkeypress="return isNumber(event);" value="<?php if($emp_total_leave){ echo $emp_total_leave['total_days'];}else{ echo "56";} ?>"/>  
																[NOTE: Yearly Earned Leave 30, Yearly Casual Leave 12, Yearly Sick Leave 14]
														</div>
													</div>													
												</div>
											</div>
										</div>
<!-- 										<div class="category_leave_area" style="<?php //if($leave_cat_count && !$emp_total_leave){ print 'display:block;'; }else{ print 'display:none;';} ?>">				
										<div class="row">
											<div class="col-md-6">
												<?php 
												// $leave_field_count=count($allleavetype);
												// $leave_field_count_half=round($leave_field_count/2);
												// $loop_counter=1;
												// foreach ($allleavetype as $single_leave) { 
												// 	$leave_level=$single_leave['name'];
												// 	$leave_machine_name=$single_leave['description'];
												// 	$leave_tid=$single_leave['tid'];
												// 	if($toedit_id){
												// 		$previous_leave=$this->emp_leave_model->getemp_yearlyleave($toedit_id, $leave_tid);
												// 	}

													?>
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8"><?php //print $leave_level; ?></div>
														<div class="col-md-8">
															<input type="text" name="annual_leave[<?=$leave_tid ?>]" id="<?=$leave_machine_name ?>"  onkeypress="return isNumber(event);" value="<?php if($previous_leave){ echo $previous_leave['total_days'];} ?>"/>        
														</div>
													</div>

													<?php
													// if($leave_field_count_half==$loop_counter){
													// 	echo '</div>
													// 	<div class="col-md-6">';
													// 	}
													// 	$loop_counter++;
													// }
													?>
												</div>
										</div>	
										</div>	 -->								
									</div>
<!-- 									<div class="tabcontent" id="content_2">
										<div class="row">
											<div class="col-md-6">
                                              
											</div>
											<div class="col-md-6">
                           
											</div>
										</div>
									</div> -->
									<!-- <div class="tabcontent" id="content_3">


								</div> -->
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
											<select name="emp_exp_position_1" id="emp_exp_position_1"  data-placeholder="Choose a Position..." class="chosen-select">
												<option value=""></option>
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
											<select name="emp_exp_position_2" id="emp_exp_position_2"  data-placeholder="Choose a Position..." class="chosen-select">
												<option value=""></option>
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
											<select name="emp_exp_position_3" id="emp_exp_position_3"  data-placeholder="Choose a Position..." class="chosen-select">
												<option value=""></option>
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
											<select name="emp_exp_position_4" id="emp_exp_position_4"  data-placeholder="Choose a Position..." class="chosen-select">
												<option value=""></option>
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
											<select name="emp_exp_position_5" id="emp_exp_position_5"  data-placeholder="Choose a Position..." class="chosen-select">
												<option value=""></option>
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
											<select name="emp_exp_position_6" id="emp_exp_position_6"  data-placeholder="Choose a Position..." class="chosen-select">
												<option value=""></option>
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
											<select name="emp_exp_position_7" id="emp_exp_position_7"  data-placeholder="Choose a Position..." class="chosen-select">
												<option value=""></option>
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
										<!-- <div class="row">
											<div class="col-md-2 bgcolor_D8D8D8">Training Title</div>
											<div class="col-md-3 bgcolor_D8D8D8">Topics Covered</div>
											<div class="col-md-4 bgcolor_D8D8D8">Institution</div>
											<div class="col-md-1 bgcolor_D8D8D8">Year</div>
											<div class="col-md-1 bgcolor_D8D8D8">Duration</div>
											<div class="col-md-1 bgcolor_D8D8D8">Results</div>
										</div> 
										<div class="row">
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_level_1" id="emp_comskill_level_1"  value="<?php if($emp_comskill_level_1){ echo $emp_comskill_level_1;} ?>" /></div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_topics_1" id="emp_comskill_topics_1"  value="<?php if($emp_comskill_topics_1){ echo $emp_comskill_topics_1;} ?>" /></div>
											<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_institute_1" id="emp_comskill_institute_1"  value="<?php if($emp_comskill_institute_1){ echo $emp_comskill_institute_1;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_year_1" id="emp_comskill_year_1" onkeypress="return isNumber(event);" value="<?php if($emp_comskill_year_1){ echo $emp_comskill_year_1;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_duration_1" id="emp_comskill_duration_1"  value="<?php if($emp_comskill_duration_1){ echo $emp_comskill_duration_1;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_results_1" id="emp_comskill_results_1"  value="<?php if($emp_comskill_results_1){ echo $emp_comskill_results_1;} ?>" /></div>
										</div>
										<div class="row">
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_level_2" id="emp_comskill_level_2"  value="<?php if($emp_comskill_level_2){ echo $emp_comskill_level_2;} ?>" /></div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_topics_2" id="emp_comskill_topics_2"  value="<?php if($emp_comskill_topics_2){ echo $emp_comskill_topics_2;} ?>" /></div>
											<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_institute_2" id="emp_comskill_institute_2"  value="<?php if($emp_comskill_institute_2){ echo $emp_comskill_institute_2;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_year_2" id="emp_comskill_year_2" onkeypress="return isNumber(event);" value="<?php if($emp_comskill_year_2){ echo $emp_comskill_year_2;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_duration_2" id="emp_comskill_duration_2"  value="<?php if($emp_comskill_duration_2){ echo $emp_comskill_duration_2;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_results_2" id="emp_comskill_results_2"  value="<?php if($emp_comskill_results_2){ echo $emp_comskill_results_2;} ?>" /></div>
										</div>
										<div class="row">
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_level_3" id="emp_comskill_level_3"  value="<?php if($emp_comskill_level_3){ echo $emp_comskill_level_3;} ?>" /></div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_topics_3" id="emp_comskill_topics_3"  value="<?php if($emp_comskill_topics_3){ echo $emp_comskill_topics_3;} ?>" /></div>
											<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_institute_3" id="emp_comskill_institute_3"  value="<?php if($emp_comskill_institute_3){ echo $emp_comskill_institute_3;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_year_3" id="emp_comskill_year_3" onkeypress="return isNumber(event);" value="<?php if($emp_comskill_year_3){ echo $emp_comskill_year_3;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_duration_3" id="emp_comskill_duration_3"  value="<?php if($emp_comskill_duration_3){ echo $emp_comskill_duration_3;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_results_3" id="emp_comskill_results_3"  value="<?php if($emp_comskill_results_3){ echo $emp_comskill_results_3;} ?>" /></div>
										</div>-->
										<!-- <div class="row">
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_level_4" id="emp_comskill_level_4"  value="<?php if($emp_comskill_level_4){ echo $emp_comskill_level_4;} ?>" /></div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_topics_4" id="emp_comskill_topics_4"  value="<?php if($emp_comskill_topics_4){ echo $emp_comskill_topics_4;} ?>" /></div>
											<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_institute_4" id="emp_comskill_institute_4"  value="<?php if($emp_comskill_institute_4){ echo $emp_comskill_institute_4;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_year_4" id="emp_comskill_year_4" onkeypress="return isNumber(event);" value="<?php if($emp_comskill_year_4){ echo $emp_comskill_year_4;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_duration_4" id="emp_comskill_duration_4"  value="<?php if($emp_comskill_duration_4){ echo $emp_comskill_duration_4;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_results_4" id="emp_comskill_results_4"  value="<?php if($emp_comskill_results_4){ echo $emp_comskill_results_4;} ?>" /></div>
										</div>
										<div class="row">
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_level_5" id="emp_comskill_level_5"  value="<?php if($emp_comskill_level_5){ echo $emp_comskill_level_5;} ?>" /></div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_topics_5" id="emp_comskill_topics_5"  value="<?php if($emp_comskill_topics_5){ echo $emp_comskill_topics_5;} ?>" /></div>
											<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_institute_5" id="emp_comskill_institute_5"  value="<?php if($emp_comskill_institute_5){ echo $emp_comskill_institute_5;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_year_5" id="emp_comskill_year_5" onkeypress="return isNumber(event);" value="<?php if($emp_comskill_year_5){ echo $emp_comskill_year_5;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_duration_5" id="emp_comskill_duration_5"  value="<?php if($emp_comskill_duration_5){ echo $emp_comskill_duration_5;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_results_5" id="emp_comskill_results_5"  value="<?php if($emp_comskill_results_5){ echo $emp_comskill_results_5;} ?>" /></div>
										</div>
										<div class="row">
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_level_6" id="emp_comskill_level_6"  value="<?php if($emp_comskill_level_6){ echo $emp_comskill_level_6;} ?>" /></div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_topics_6" id="emp_comskill_topics_6"  value="<?php if($emp_comskill_topics_6){ echo $emp_comskill_topics_6;} ?>" /></div>
											<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_institute_6" id="emp_comskill_institute_6"  value="<?php if($emp_comskill_institute_6){ echo $emp_comskill_institute_6;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_year_6" id="emp_comskill_year_6" onkeypress="return isNumber(event);" value="<?php if($emp_comskill_year_6){ echo $emp_comskill_year_6;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_duration_6" id="emp_comskill_duration_6"  value="<?php if($emp_comskill_duration_6){ echo $emp_comskill_duration_6;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_results_6" id="emp_comskill_results_6"  value="<?php if($emp_comskill_results_6){ echo $emp_comskill_results_6;} ?>" /></div>
										</div>
										<div class="row">
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_level_7" id="emp_comskill_level_7"  value="<?php if($emp_comskill_level_7){ echo $emp_comskill_level_7;} ?>" /></div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_topics_7" id="emp_comskill_topics_7"  value="<?php if($emp_comskill_topics_7){ echo $emp_comskill_topics_7;} ?>" /></div>
											<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_institute_7" id="emp_comskill_institute_7"  value="<?php if($emp_comskill_institute_7){ echo $emp_comskill_institute_7;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_year_7" id="emp_comskill_year_7" onkeypress="return isNumber(event);" value="<?php if($emp_comskill_year_7){ echo $emp_comskill_year_7;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_duration_7" id="emp_comskill_duration_7"  value="<?php if($emp_comskill_duration_7){ echo $emp_comskill_duration_7;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_comskill_results_7" id="emp_comskill_results_7"  value="<?php if($emp_comskill_results_7){ echo $emp_comskill_results_7;} ?>" /></div>
										</div> -->										
										<!-- training end										 -->
									</div>

									<div class="tabcontent" id="content_5">
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
<!-- 										<div class="row">
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_education_level_6" id="emp_education_level_6">
													<option value="">Select Level</option>
													<?php foreach ($allqualification as $single_qualification) {
														if($emp_education_level_6==$single_qualification['tid']){
															echo '<option value="'.$single_qualification['tid'].'" selected="selected">'.$single_qualification['name'].'</option>';
														}else{
															echo '<option value="'.$single_qualification['tid'].'">'.$single_qualification['name'].'</option>';
														}
													} ?>
												</select>  
											</div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_degree_6" id="emp_education_degree_6"  value="<?php if($emp_education_degree_6){ echo $emp_education_degree_6;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_major_6" id="emp_education_major_6"  value="<?php if($emp_education_major_6){ echo $emp_education_major_6;} ?>" /></div>
											<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_institute_6" id="emp_education_institute_6" value="<?php if($emp_education_institute_6){ echo $emp_education_institute_6;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_year_6" id="emp_education_year_6" onkeypress="return isNumber(event);" value="<?php if($emp_education_year_6){ echo $emp_education_year_6;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_results_6" id="emp_education_results_6"  value="<?php if($emp_education_results_6){ echo $emp_education_results_6;} ?>" /></div>
										</div>
										<div class="row">
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_education_level_7" id="emp_education_level_7">
													<option value="">Select Level</option>
													<?php foreach ($allqualification as $single_qualification) {
														if($emp_education_level_7==$single_qualification['tid']){
															echo '<option value="'.$single_qualification['tid'].'" selected="selected">'.$single_qualification['name'].'</option>';
														}else{
															echo '<option value="'.$single_qualification['tid'].'">'.$single_qualification['name'].'</option>';
														}
													} ?>
												</select>  
											</div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_degree_7" id="emp_education_degree_7"  value="<?php if($emp_education_degree_7){ echo $emp_education_degree_7;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_major_7" id="emp_education_major_7"  value="<?php if($emp_education_major_7){ echo $emp_education_major_7;} ?>" /></div>
											<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_institute_7" id="emp_education_institute_7" value="<?php if($emp_education_institute_7){ echo $emp_education_institute_7;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_year_7" id="emp_education_year_7" onkeypress="return isNumber(event);" value="<?php if($emp_education_year_7){ echo $emp_education_year_7;} ?>" /></div>
											<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_results_7" id="emp_education_results_7"  value="<?php if($emp_education_results_7){ echo $emp_education_results_7;} ?>" /></div>
										</div> -->

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
										<!-- <div class="row">
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_language_name_4" id="emp_language_name_4"  value="<?php if($emp_language_name_4){ echo $emp_language_name_4;} ?>" /></div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_reading_4" id="emp_language_reading_4">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_reading_4=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_reading_4=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_reading_4=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_writing_4" id="emp_language_writing_4">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_writing_4=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_writing_4=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_writing_4=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_speaking_4" id="emp_language_speaking_4">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_speaking_4=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_speaking_4=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_speaking_4=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_listening_4" id="emp_language_listening_4">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_listening_4=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_listening_4=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_listening_4=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_language_name_5" id="emp_language_name_5"  value="<?php if($emp_language_name_5){ echo $emp_language_name_5;} ?>" /></div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_reading_5" id="emp_language_reading_5">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_reading_5=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_reading_5=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_reading_5=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_writing_5" id="emp_language_writing_5">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_writing_5=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_writing_5=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_writing_5=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_speaking_5" id="emp_language_speaking_5">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_speaking_5=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_speaking_5=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_speaking_5=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_listening_5" id="emp_language_listening_5">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_listening_5=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_listening_5=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_listening_5=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_language_name_6" id="emp_language_name_6"  value="<?php if($emp_language_name_6){ echo $emp_language_name_6;} ?>" /></div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_reading_6" id="emp_language_reading_6">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_reading_6=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_reading_6=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_reading_6=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_writing_6" id="emp_language_writing_6">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_writing_6=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_writing_6=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_writing_6=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_speaking_6" id="emp_language_speaking_6">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_speaking_6=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_speaking_6=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_speaking_6=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_listening_6" id="emp_language_listening_6">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_listening_6=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_listening_6=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_listening_6=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
										</div>
										<div class="row">
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_language_name_7" id="emp_language_name_7"  value="<?php if($emp_language_name_7){ echo $emp_language_name_7;} ?>" /></div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_reading_7" id="emp_language_reading_7">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_reading_7=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_reading_7=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_reading_7=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_writing_7" id="emp_language_writing_7">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_writing_7=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_writing_7=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_writing_7=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_speaking_7" id="emp_language_speaking_7">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_speaking_7=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_speaking_7=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_speaking_7=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_language_listening_7" id="emp_language_listening_7">
													<option value="">Select</option>
													<option value="High" <?php if($emp_language_listening_7=='High'){ echo 'selected="selected"';} ?>>High</option>
													<option value="Medium" <?php if($emp_language_listening_7=='Medium'){ echo 'selected="selected"';} ?>>Medium</option>
													<option value="Low" <?php if($emp_language_listening_7=='Low'){ echo 'selected="selected"';} ?>>Low</option>
												</select>
											</div>
										</div>	 -->									
									</div> 
									<!-- <div class="tabcontent" id="content_6">

								</div> -->
									<!-- <div class="tabcontent" id="content_7">

								</div> -->
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
										<!-- 	<div class="row">
												<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_name_4" id="emp_reference_name_4"  value="<?php if($emp_reference_name_4){ echo $emp_reference_name_4;} ?>" /></div>
												<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_position_4" id="emp_reference_position_4"  value="<?php if($emp_reference_position_4){ echo $emp_reference_position_4;} ?>" /></div>
												<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_org_4" id="emp_reference_org_4"  value="<?php if($emp_reference_org_4){ echo $emp_reference_org_4;} ?>" /></div>
												<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_address_4" id="emp_reference_address_4" value="<?php if($emp_reference_address_4){ echo $emp_reference_address_4;} ?>" /></div>
												<div class="col-md-2 custom_width_10666667" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_phone_4" id="emp_reference_phone_4"  value="<?php if($emp_reference_phone_4){ echo $emp_reference_phone_4;} ?>" /></div>
												<div class="col-md-1 custom_width_13666667" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_email_4" id="emp_reference_email_4"  value="<?php if($emp_reference_email_4){ echo $emp_reference_email_4;} ?>" /></div>
												<div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_relation_4" id="emp_reference_relation_4"  value="<?php if($emp_reference_relation_4){ echo $emp_reference_relation_4;} ?>" /></div>
											</div> -->		
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
										<!-- <div class="row">
											<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_name_6" id="emp_dependent_name_6"  value="<?php if($emp_dependent_name_6){ echo $emp_dependent_name_6;} ?>" /></div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_dependent_dob_6" id="emp_dependent_dob_6"  value="<?php if($emp_dependent_dob_6){ echo $emp_dependent_dob_6;} ?>" /></div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_dependent_relation_6" id="emp_dependent_relation_6">
													<option value="">Select</option>
													<?php foreach ($allrelative as $single_relative) {
														if($emp_dependent_relation_6==$single_relative['tid']){
															echo '<option value="'.$single_relative['tid'].'" selected="selected">'.$single_relative['name'].'</option>';
														}else{
															echo '<option value="'.$single_relative['tid'].'">'.$single_relative['name'].'</option>';
														}
													} ?>
												</select> 
											</div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_nomtype_6" id="emp_dependent_nomtype_6" value="<?php if($emp_dependent_nomtype_6){ echo $emp_dependent_nomtype_6;} ?>" /></div>
										</div>
										<div class="row">
											<div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_name_7" id="emp_dependent_name_7"  value="<?php if($emp_dependent_name_7){ echo $emp_dependent_name_7;} ?>" /></div>
											<div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_dependent_dob_7" id="emp_dependent_dob_7"  value="<?php if($emp_dependent_dob_7){ echo $emp_dependent_dob_7;} ?>" /></div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
												<select name="emp_dependent_relation_7" id="emp_dependent_relation_7">
													<option value="">Select</option>
													<?php foreach ($allrelative as $single_relative) {
														if($emp_dependent_relation_7==$single_relative['tid']){
															echo '<option value="'.$single_relative['tid'].'" selected="selected">'.$single_relative['name'].'</option>';
														}else{
															echo '<option value="'.$single_relative['tid'].'">'.$single_relative['name'].'</option>';
														}
													} ?>
												</select> 
											</div>
											<div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_nomtype_7" id="emp_dependent_nomtype_7" value="<?php if($emp_dependent_nomtype_7){ echo $emp_dependent_nomtype_7;} ?>" /></div>
										</div> -->
									</div>
									<div class="tabcontent" id="content_9">
										<div class="row">
											<div class="col-md-8 heading_style presentsalry_heading">
												Present Salary 
											</div>
											<div class="col-md-2 increament heading_style text-right" style="<?php if(!$salary_count){ echo "padding: 16px;"; }?>">
												<?php if($salary_count){ ?><span class="btn" id="salary_history">History</span> <?php }?>
											</div>											
									<!-- <div class="col-md-2 increament heading_style text-right">
										<span class="btn" id="decrement">Decreament</span>
									</div> -->											
									<!-- <div class="col-md-2 increament heading_style text-right">
										<span class="btn" id="increment">Increament</span>
									</div> -->
									<!-- <div class="col-md-2 increament heading_style text-right">
										<span class="btn" id="update">Update</span>
									</div> -->
									<!--
									<div class="col-md-2 increament heading_style text-right" style="<?php if($salary_count){ echo "padding:6.5px;"; }else{ echo "padding:16px;";} ?>">
									    <?php if($salary_count){ ?>
									    Update	<input type="checkbox" name="emp_salary_update" id="emp_salary_update" <?php if($emp_salary_update){ echo 'checked="checked"';} ?>/>
									    <?php } ?>
									 </div>
									 -->
									<div class="col-md-2 increament heading_style text-right" style="<?php if($salary_count){ echo "padding:6.5px;"; }else{ echo "padding:16px;";} ?>"><?php if($salary_count){ ?>Increment	<input type="checkbox" name="emp_salary_increment" id="emp_salary_increment" <?php if($emp_salary_increment){ echo 'checked="checked"';} ?>/> <?php } ?></div>
								</div>	
								<div id="salary_area">
									<div class="row">
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-4 bgcolor_D8D8D8">Basic Salary</div>
												<div class="col-md-8">
													<input type="text" name="emp_basic_salary" id="emp_basic_salary" onkeypress="return isNumber(event);" value="<?php if($emp_basic_salary){ echo $emp_basic_salary;} ?>"/>        
												</div>
											</div>	
											<div class="row">
												<div class="col-md-4 bgcolor_D8D8D8">Medical Allowance</div>
												<div class="col-md-8">
													<input type="text" name="emp_medical_allowance" id="emp_medical_allowance" onkeypress="return isNumber(event);" value="<?php if($emp_medical_allowance){ echo $emp_medical_allowance;} ?>"/>        
												</div>
											</div>	
											<div class="row">
												<div class="col-md-4 bgcolor_D8D8D8">Telephone Allowance</div>
												<div class="col-md-8">
													<input type="text" name="emp_telephone_allowance" id="emp_telephone_allowance" onkeypress="return isNumber(event);" value="<?php if($emp_telephone_allowance){ echo $emp_telephone_allowance;} ?>"/>        
												</div>
											</div>
											<!--
											<div class="row">
												<div class="col-md-4 bgcolor_D8D8D8" style="font-size: 11px;">Provident/Welfare Fund</div>
												<div class="col-md-8">
													<input type="text" name="emp_provident_fund_allowance" id="emp_provident_fund_allowance" onkeypress="return isNumber(event);" value="<?php if($emp_provident_fund_allowance){ echo $emp_provident_fund_allowance;} ?>"/>        
												</div>
											</div>	
											-->
												
											<div class="row">
												<div class="col-md-4 bgcolor_D8D8D8">Festival Bonus(%)</div>
												<div class="col-md-8">
													<input type="number" name="emp_festival_bonus" id="emp_festival_bonus" onkeypress="" value="<?php if($emp_festival_bonus){ echo $emp_festival_bonus;} ?>"/>        
												</div>
											</div>																																																										
										</div>
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-4 bgcolor_D8D8D8">House Rent Allowan.</div>
												<div class="col-md-8">
													<input type="text" name="emp_house_rent" id="emp_house_rent" onkeypress="return isNumber(event);" value="<?php if($emp_house_rent){ echo $emp_house_rent;} ?>"/>        
												</div>
											</div>	
											<!--
											<div class="row">
												<div class="col-md-4 bgcolor_D8D8D8">Conveyance Allow.</div>
												<div class="col-md-8">
													<input type="text" name="emp_conveyance" id="emp_conveyance" onkeypress="return isNumber(event);" value="<?php if($emp_conveyance){ echo $emp_conveyance;} ?>"/>        
												</div>
											</div>	
											<div class="row">
												<div class="col-md-4 bgcolor_D8D8D8">Special Allowance</div>
												<div class="col-md-8">
													<input type="text" name="emp_special_allowance" id="emp_special_allowance" onkeypress="return isNumber(event);" value="<?php if($emp_special_allowance){ echo $emp_special_allowance;} ?>"/>        
												</div>
											</div>	
											-->
											<div class="row">
												<div class="col-md-4 bgcolor_D8D8D8">Transport Allowance</div>
												<div class="col-md-8">
													<input type="text" name="emp_transport_allowance" id="emp_transport_allowance" onkeypress="return isNumber(event);" value="<?php if($emp_transport_allowance){ echo $emp_transport_allowance;} ?>"/>        
												</div>
											</div>	
											<!--
											<div class="row">
												<div class="col-md-4 bgcolor_D8D8D8">Performance Bonus</div>
												<div class="col-md-8">
													<input type="text" name="emp_performance_bonus" id="emp_performance_bonus" onkeypress="return isNumber(event);" value="<?php if($emp_performance_bonus){ echo $emp_performance_bonus;} ?>"/>        
												</div>
											</div>
											-->
											<div class="row">
												<div class="col-md-4 bgcolor_D8D8D8">Other Allowance</div>
												<div class="col-md-8">
													<input type="text" name="emp_other_allowance" id="emp_other_allowance" onkeypress="return isNumber(event);" value="<?php if($emp_other_allowance){ echo $emp_other_allowance;} ?>"/>        
												</div>
											</div>
											<div class="row">
												<div class="col-md-4 bgcolor_D8D8D8">Total Benifit</div>
												<div class="col-md-8">
													<input type="text" name="emp_total_benifit" id="emp_total_benifit" onkeypress="return isNumber(event);" value="<?php if($emp_total_benifit){ echo $emp_total_benifit;} ?>"/>        
												</div>
											</div>																																																									
										</div>
									</div>
								</div>
								<div class="row" id="increment_area">
									<div class="col-md-12 heading_style">
										Increment
									</div>
							
								<div >
									<div class="row">
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-4 bgcolor_D8D8D8" style="font-size: 11px;">Increment Amount</div>
												<div class="col-md-8">
													<input type="text" name="emp_salary_increment_amount" id="emp_salary_increment_amount" onkeypress="return isNumber(event);" value="<?php if($emp_salary_increment_amount){ echo $emp_salary_increment_amount;} ?>"/>        
												</div>
											</div>	
											<div class="row">
												<div class="col-md-4 bgcolor_D8D8D8" style="font-size: 11px;">Increment Percentage</div>
												<div class="col-md-8">
													<input type="text" name="emp_increment_percentage" id="emp_increment_percentage" value="<?php if($emp_increment_percentage){ echo $emp_increment_percentage;} ?>"/>        
												</div>
											</div>																									
										</div>									
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-4 bgcolor_D8D8D8" style="font-size: 11px;">Increment Date</div>
												<div class="col-md-8">
													<input type="text" name="emp_increment_date" id="emp_increment_date" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if($emp_increment_date){ echo $emp_increment_date;}else{ echo $now;} ?>"/>        
												</div>
											</div>													
										</div>
									</div>	
								</div>
									</div>	
								<div class="row">
									<div class="col-md-12 heading_style">
										Payment Deduction
									</div>
								</div>	
								<div id="deduction_area">
									<div class="row">
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-4 bgcolor_D8D8D8" style="font-size: 11px;">Provident/Welfare Fund</div>
												<div class="col-md-8">
													<input type="text" name="emp_provident_fund_deduction" id="emp_provident_fund_deduction" onkeypress="return isNumber(event);" value="<?php if($emp_provident_fund_deduction){ echo $emp_provident_fund_deduction;} ?>"/>        
												</div>
											</div>
<!-- 													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Loan Deduction From</div>
														<div class="col-md-8">
															<input type="text" name="emp_loan_deduction_from" id="emp_loan_deduction_from" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if($emp_loan_deduction_from){ echo $emp_loan_deduction_from;} ?>"/>        
														</div>
													</div> -->
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Tax</div>
														<div class="col-md-8">
															<input type="text" name="emp_tax_deduction" id="emp_tax_deduction" onkeypress="return isNumber(event);" value="<?php if($emp_tax_deduction){ echo $emp_tax_deduction;} ?>"/>        
														</div>
													</div>																																																		
												</div>
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Other Deduction</div>
														<div class="col-md-8">
															<input type="text" name="emp_other_deduction" id="emp_other_deduction" onkeypress="return isNumber(event);" value="<?php if($emp_other_deduction){ echo $emp_other_deduction;} ?>"/>        
														</div>
													</div>
													
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Total Deduction</div>
														<div class="col-md-8">
															<input type="text" name="emp_total_deduction" id="emp_total_deduction" onkeypress="return isNumber(event);" value="<?php if($emp_total_deduction){ echo $emp_total_deduction;} ?>"/>        
														</div>
													</div>
<!-- 													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Advance Loan</div>
														<div class="col-md-8">
															<input type="text" name="emp_advance_loan" id="emp_advance_loan" onkeypress="return isNumber(event);" value="<?php if($emp_advance_loan){ echo $emp_advance_loan;} ?>"/>        
														</div>
													</div>	
													<div class="row">
														<div class="col-md-4 bgcolor_D8D8D8">Loan Deduction To</div>
														<div class="col-md-8">
															<input type="text" name="emp_loan_deduction_to" id="emp_loan_deduction_to" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if($emp_loan_deduction_to){ echo $emp_loan_deduction_to;} ?>"/>        
														</div>
													</div>	 -->																																		
												</div>
											</div>	
										</div>
										<div class="row">
											<div class="col-md-12 heading_style">
												Total Payment
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Gross Salary</div>
													<div class="col-md-8">
														<input type="text" name="emp_gross_salary" id="emp_gross_salary" onkeypress="return isNumber(event);" value="<?php if($emp_gross_salary){ echo $emp_gross_salary;} ?>"/>        
													</div>
												</div>													
											</div>
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Yearly Paid</div>
													<div class="col-md-8">
														<input type="text" name="emp_yearly_paid" id="emp_yearly_paid" onkeypress="return isNumber(event);" value="<?php if($emp_yearly_paid){ echo $emp_yearly_paid;} ?>"/>        
													</div>
												</div>													
											</div>
										</div>																		
										<div class="row">
											<div class="col-md-12 heading_style">
												Payment Method
											</div>
										</div>																			
										<div class="row">
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Bank</div>
													<div class="col-md-8">
														<select name="emp_bank" id="emp_bank">
															<option value="">Select Bank</option>
															<?php foreach ($allbankname as $single_bank) {
																if($emp_bank==$single_bank['tid']){
																	echo '<option value="'.$single_bank['tid'].'" selected="selected">'.$single_bank['name'].'</option>';
																}else{
																	echo '<option value="'.$single_bank['tid'].'">'.$single_bank['name'].'</option>';
																}
															} ?>
														</select>         
													</div>
												</div>  

												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Account Number</div>
													<div class="col-md-8">
														<input type="text" name="emp_bank_account" id="emp_bank_account" value="<?php if($emp_bank_account){ echo $emp_bank_account;} ?>"/>        
													</div>
												</div>                                 
											</div>
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Bank Branch</div>
													<div class="col-md-8">
														<input type="text" name="emp_bank_branch" id="emp_bank_branch" value="<?php if($emp_bank_branch){ echo $emp_bank_branch;} ?>"/>        
													</div>
												</div>	
												<div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Pay Type</div>
													<div class="col-md-8">
														<select name="emp_pay_type" id="emp_pay_type">
															<option value="">Select Pay Type</option>
															<?php foreach ($allpaytype as $single_paytype) {
																if($emp_pay_type==$single_paytype['tid']){
																	echo '<option value="'.$single_paytype['tid'].'" selected="selected">'.$single_paytype['name'].'</option>';
																}else if($single_paytype['tid']=='207' && !$emp_pay_type){
																	echo '<option value="'.$single_paytype['tid'].'" selected="selected">'.$single_paytype['name'].'</option>';
																}else{
																	echo '<option value="'.$single_paytype['tid'].'">'.$single_paytype['name'].'</option>';
																}
															} ?>
														</select>         
													</div>
												</div>																							
											</div>
										</div>
									</div>
									<div class="tabcontent" id="content_10">
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


	<script type="text/javascript">
		$(document).ready(function(){
$('#popup_emp_yearly_paid').attr('readonly','readonly');
<?php $salary_count=count($salary_amount_previous); ?>

		<?php 

		if($salary_count>1){ 
			$previoussalary=$salary_amount_previous[1]['gross_salary'];
			echo "var previous_salary= $previoussalary; "; 
			$presentsalry=$salary_amount_previous[0]['gross_salary'];
			if($presentsalry){
				echo "var present_salary= $presentsalry; "; 
			}else{
				echo "var present_salary= 0; ";
			}
		}else{ 
			$presentsalry=$salary_amount_previous[0]['gross_salary'];
			if($presentsalry){
				echo "var present_salary= $presentsalry; "; 
			}else{
				echo "var present_salary= 0; ";
			}

			?>
			var previous_salary= 0; 

			<?php } ?>			
			var dialog, form;
			dialog = $( "#dialog-form" ).dialog({
				autoOpen: false,
				height: "auto",
				width: "auto",
				modal: true,
				Cancel: function() {
					dialog.dialog( "close" );
				},
				position: { my: "center center", at: "center center" },
			});


			$('#salary_history').click(function(){
				dialog.dialog( "open" );
			});


			var dialog2, form2;
			dialog2 = $( "#dialog-form-foredit" ).dialog({
				autoOpen: false,
				height: "auto",
				width: "auto",
				modal: true,
				buttons: {
   // "Add field": addField,
   "Edit salary":     {
   	text: "Submit",
   	id: "edit-salary-btn",
   	click: editsalary   
   },
   Cancel: function() {
   	dialog2.dialog( "close" );
   }
},
position: { my: "center center", at: "center center" },
close: function() {
	form2[ 0 ].reset();
        // allFields.removeClass( "ui-state-error" );
    }
});

			form2 = dialog2.find( "form" ).on( "submit", function( event ) {
				event.preventDefault();
    //  addField();
});
			$(".salary-edit-link").click(function(evt){
				evt.preventDefault;
				var salary_id=$(this).attr('data-id');
				var base_url='<?php echo base_url();?>';
				var postData = {
					"salary_id"    : salary_id
				};	
				$.ajax({
					type: "POST",
					url: ""+base_url+"addprofile/getsalarybysalaryid",
					data: postData,
					dataType:'json',
					success: function(data){
            //console.log(data);
            if (data) {
            	$('#popup_emp_salary_id').val(salary_id);
            	$('#popup_emp_basic_salary').val(data.basic_salary);
            	$('#popup_emp_house_rent').val(data.house_rent);
            	$('#popup_emp_medical_allowance').val(data.medical_allow);
            	$('#popup_emp_conveyance').val(data.conveyance_allow);
            	$('#popup_emp_telephone_allowance').val(data.telephone_allow);
            	$('#popup_emp_special_allowance').val(data.special_allowa);
            	$('#popup_emp_provident_fund_allowance').val(data.provident_allow);
            	$('#popup_emp_transport_allowance').val(data.transport_allow);
            	$('#popup_emp_other_allowance').val(data.other_allow);
            	$('#popup_emp_performance_bonus').val(data.performance_bonus);
            	$('#popup_emp_festival_bonus').val(data.festival_bonus);
            	$('#popup_emp_total_benifit').val(data.total_benifit);
            	var increamentamnt=data.increment_amount;
            	if(increamentamnt.length === 0){
            		$('.increament-display').css({"display":"none"});
            	}else{
            		$('.increament-display').css({"display":"block"});
            	}
            	$('#popup_emp_salary_increment_amount').val(data.increment_amount);
            	$('#popup_emp_increment_percentage').val(data.increment_percentage);
            	$('#popup_emp_increment_date').val(data.increment_date);
            	$('#popup_emp_gross_salary').val(data.gross_salary);
            	$('#popup_emp_yearly_paid').val(data.yearly_paid);
            	dialog2.dialog( "open" );
            }
        }

    });	


});
function editsalary() {
	var valid = true;
	var emp_salary_id=$('#popup_emp_salary_id').val();
	var emp_basic_salary=$('#popup_emp_basic_salary').val();
	var emp_house_rent=$('#popup_emp_house_rent').val();
	var emp_medical_allowance=$('#popup_emp_medical_allowance').val();
	var emp_conveyance=$('#popup_emp_conveyance').val();
	var emp_telephone_allowance=$('#popup_emp_telephone_allowance').val();
	var emp_special_allowance=$('#popup_emp_special_allowance').val();
	var emp_provident_fund_allowance=$('#popup_emp_provident_fund_allowance').val();
	var emp_transport_allowance=$('#popup_emp_transport_allowance').val();
	var emp_other_allowance=$('#popup_emp_other_allowance').val();
	var emp_performance_bonus=$('#popup_emp_performance_bonus').val();
	var emp_festival_bonus=$('#popup_emp_festival_bonus').val();
	var emp_total_benifit=$('#popup_emp_total_benifit').val();
	var emp_salary_increment_amount=$('#popup_emp_salary_increment_amount').val();
	var emp_increment_percentage=$('#popup_emp_increment_percentage').val();
	var emp_increment_date=$('#popup_emp_increment_date').val();
	var emp_gross_salary=$('#popup_emp_gross_salary').val();
	var emp_yearly_paid=$('#popup_emp_yearly_paid').val();
	var base_url='<?php echo base_url();?>';

	var postData = {
		"emp_salary_id":emp_salary_id,
		"emp_basic_salary":emp_basic_salary,
		"emp_house_rent":emp_house_rent,
		"emp_medical_allowance":emp_medical_allowance,
		"emp_conveyance":emp_conveyance,
		"emp_telephone_allowance":emp_telephone_allowance,
		"emp_special_allowance":emp_special_allowance,
		"emp_provident_fund_allowance":emp_provident_fund_allowance,
		"emp_transport_allowance":emp_transport_allowance,
		"emp_other_allowance":emp_other_allowance,
		"emp_performance_bonus":emp_performance_bonus,
		"emp_festival_bonus":emp_festival_bonus,
		"emp_total_benifit":emp_total_benifit,
		"emp_salary_increment_amount":emp_salary_increment_amount,
		"emp_increment_percentage":emp_increment_percentage,
		"emp_increment_date":emp_increment_date,
		"emp_gross_salary":emp_gross_salary,
		"emp_yearly_paid":emp_yearly_paid,
	};
	$.ajax({
		type: "POST",
		url: ""+base_url+"addprofile/updatesalarybysalaryid",
		data: postData,
		dataType:'json',
		success: function(data){
	//location.reload();
	dialog2.dialog( "close" );
}
});
}

$("#popup_salary_area").keyup(function(){
	var emp_salary_id=$('#popup_emp_salary_id').val();
	var emp_basic_salary=$('#popup_emp_basic_salary').val();
	var emp_house_rent=$('#popup_emp_house_rent').val();
	var emp_medical_allowance=$('#popup_emp_medical_allowance').val();
	var emp_conveyance=$('#popup_emp_conveyance').val();
	var emp_telephone_allowance=$('#popup_emp_telephone_allowance').val();
	var emp_special_allowance=$('#popup_emp_special_allowance').val();
	var emp_provident_fund_allowance=$('#popup_emp_provident_fund_allowance').val();
	var emp_transport_allowance=$('#popup_emp_transport_allowance').val();
	var emp_other_allowance=$('#popup_emp_other_allowance').val();
	var emp_performance_bonus=$('#popup_emp_performance_bonus').val();
	var emp_festival_bonus=$('#popup_emp_festival_bonus').val();
	var emp_total_benifit=$('#popup_emp_total_benifit').val();
	var emp_salary_increment_amount=$('#popup_emp_salary_increment_amount').val();
	var emp_increment_percentage=$('#popup_emp_increment_percentage').val();
	var emp_increment_date=$('#popup_emp_increment_date').val();
	var emp_gross_salary=$('#popup_emp_gross_salary').val();
	var emp_yearly_paid=$('#popup_emp_yearly_paid').val();
	var emp_house_rent=$('#popup_emp_house_rent').val();
	if(!emp_house_rent) {
		var emp_house_rent = 0;
	}
	if(!emp_medical_allowance) {
		var emp_medical_allowance = 0;
	}     	
	if(!emp_conveyance) {
		var emp_conveyance = 0;
	}       	
	if(!emp_telephone_allowance) {
		var emp_telephone_allowance = 0;
	}      	
	if(!emp_special_allowance) {
		var emp_special_allowance = 0;
	}     	
	if(!emp_provident_fund_allowance) {
		var emp_provident_fund_allowance = 0;
	}        	 
	if(!emp_transport_allowance) {
		var emp_transport_allowance = 0;
	}     	 	
	if(!emp_other_allowance) {
		var emp_other_allowance = 0;
	}      	   	  	
	if(!emp_performance_bonus) {
		var emp_performance_bonus = 0;
	}      	
	if(!emp_festival_bonus) {
		var emp_festival_bonus = 0;
	}     	
	var total_benifit=parseInt(emp_house_rent)+parseInt(emp_medical_allowance)+parseInt(emp_conveyance)+parseInt(emp_telephone_allowance)+parseInt(emp_special_allowance)+parseInt(emp_provident_fund_allowance)+parseInt(emp_transport_allowance)+parseInt(emp_other_allowance)+parseInt(emp_performance_bonus)+parseInt(emp_festival_bonus);
	$('#popup_emp_total_benifit').val(total_benifit);  
	var emp_provident_fund_deduction= $('#popup_emp_provident_fund_deduction').val(); 
	if(!emp_provident_fund_deduction) {
		var emp_provident_fund_deduction = 0;
	}    
			// var emp_advance_loan= $('#emp_advance_loan').val(); 
			// if(!emp_advance_loan) {
			// 	var emp_advance_loan = 0;
			// } 
			var emp_other_deduction= $('#popup_emp_other_deduction').val(); 
			if(!emp_other_deduction) {
				var emp_other_deduction = 0;
			} 
		// if(!present_salary) {
		// var present_salary = 0;
		// } 
		var total_deduction=parseInt(emp_provident_fund_deduction)+	parseInt(emp_other_deduction);					
		$('#popup_emp_total_deduction').val(total_deduction);  
		var gross_salary=parseInt(total_benifit)+parseInt(emp_basic_salary)-parseInt(total_deduction);
     	// var previous_salary= $('#emp_gross_salary').val(); 
     		var total_gross_salary=parseInt(present_salary)+parseInt(gross_salary);
     		var total_increment_amount=parseInt(emp_basic_salary)+	parseInt(total_benifit);
     		if(emp_salary_increment_amount){
     			$('#popup_emp_salary_increment_amount').val(total_increment_amount); 
     		}
     		 
     		var emp_increment_percentage_value= Math.round(total_increment_amount*100/present_salary);     		
     	// }else if($('#popup_emp_salary_update').is(':checked')){
     	// 	var total_gross_salary=parseInt(previous_salary)+parseInt(gross_salary);
     	// 	var emp_increment_percentage= Math.round(total_increment_amount*100/previous_salary); 
     	// }else{
     	// 	var total_gross_salary=parseInt(gross_salary);
     	// }

     	$('#popup_emp_gross_salary').val(total_gross_salary);   
     	var yearly_salary= total_gross_salary * 12;
     	$('#popup_emp_yearly_paid').val(yearly_salary); 
     	if(!isNaN(emp_increment_percentage_value && emp_increment_percentage)){
     		$('#popup_emp_increment_percentage').val(emp_increment_percentage_value+"%");
     	}

     });

// end of document	
});
</script>
<?php

?>

<div id="dialog-form" title="Salary Increament History">
	<p class="validateTips"></p>
	<table  class="pop-up-table" cellspacing="0" width="100%" border="1">
		<thead>
			<tr class="heading">                                
				<th>Gross Salary</th>
				<th>Increament Amount</th>
				<th>Increament Percentage</th>
				<th>Fulfill Date</th>
				<th>Action</th>
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
						print $emp_starting_date;
					}else{ print $increment_date; } ?>
				</td>
				<td>
				<?php 
				if($salary_count==$salary_join_counter){ ?>
				<!--	 <a href="#" data-id="<?php echo $id; ?>" class="operation-edit operation-link salary-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit Details" /></a> -->
					<a href="<?php echo base_url(); ?>deletecontent/deletesalary/<?php echo  $id; ?>" class="operation-cut operation-link" onClick="return ConfirmDelete()"> <img src="<?php echo base_url(); ?>resources/images/cut.jpg" alt="edit" title="Click to delete"/></a>
				<?php } ?>
				</td>
			</tr>
			<?php 
			$salary_join_counter++;
		} ?>
	</tbody>
</table>  				
</div>	
<!--
<div id="dialog-form-foredit" title="Edit Salary">
	<p class="validateTips"></p>
	<form>
		<div class="row">
			<div class="col-md-12 heading_style presentsalry_heading">
				Allowances
			</div>
		</div>	
		<div id="popup_salary_area">
			<div class="row">
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-4 bgcolor_D8D8D8">Basic Salary</div>
						<div class="col-md-8">
							<input type="text" name="salaryedit[id]" id="popup_emp_salary_id" value="" style="display:none;"/>        
							<input type="text" name="salaryedit[emp_basic_salary]" id="popup_emp_basic_salary" onkeypress="return isNumber(event);" value="<?php if($emp_basic_salary){ echo $emp_basic_salary;} ?>"/>        
						</div>
					</div>	
					<div class="row">
						<div class="col-md-4 bgcolor_D8D8D8">Medical Allowance</div>
						<div class="col-md-8">
							<input type="text" name="salaryedit[emp_medical_allowance]" id="popup_emp_medical_allowance" onkeypress="return isNumber(event);" value="<?php if($emp_medical_allowance){ echo $emp_medical_allowance;} ?>"/>        
						</div>
					</div>	
					<div class="row">
						<div class="col-md-4 bgcolor_D8D8D8">Telephone Allowance</div>
						<div class="col-md-8">
							<input type="text" name="salaryedit[emp_telephone_allowance]" id="popup_emp_telephone_allowance" onkeypress="return isNumber(event);" value="<?php if($emp_telephone_allowance){ echo $emp_telephone_allowance;} ?>"/>        
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 bgcolor_D8D8D8" style="font-size: 11px;">Provident/Welfare Fund</div>
						<div class="col-md-8">
							<input type="text" name="salaryedit[emp_provident_fund_allowance]" id="popup_emp_provident_fund_allowance" onkeypress="return isNumber(event);" value="<?php if($emp_provident_fund_allowance){ echo $emp_provident_fund_allowance;} ?>"/>        
						</div>
					</div>												
					<div class="row">
						<div class="col-md-4 bgcolor_D8D8D8">Other Allowance</div>
						<div class="col-md-8">
							<input type="text" name="salaryedit[emp_other_allowance]" id="popup_emp_other_allowance" onkeypress="return isNumber(event);" value="<?php if($emp_other_allowance){ echo $emp_other_allowance;} ?>"/>        
						</div>
					</div>	
					<div class="row">
						<div class="col-md-4 bgcolor_D8D8D8">Festival Bonus</div>
						<div class="col-md-8">
							<input type="text" name="salaryedit[emp_festival_bonus]" id="popup_emp_festival_bonus" onkeypress="return isNumber(event);" value="<?php if($emp_festival_bonus){ echo $emp_festival_bonus;} ?>"/>        
						</div>
					</div>																																																										
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-4 bgcolor_D8D8D8">House Rent Allowan.</div>
						<div class="col-md-8">
							<input type="text" name="salaryedit[emp_house_rent]" id="popup_emp_house_rent" onkeypress="return isNumber(event);" value="<?php if($emp_house_rent){ echo $emp_house_rent;} ?>"/>        
						</div>
					</div>	
					<div class="row">
						<div class="col-md-4 bgcolor_D8D8D8">Conveyance Allow.</div>
						<div class="col-md-8">
							<input type="text" name="salaryedit[emp_conveyance]" id="popup_emp_conveyance" onkeypress="return isNumber(event);" value="<?php if($emp_conveyance){ echo $emp_conveyance;} ?>"/>        
						</div>
					</div>	
					<div class="row">
						<div class="col-md-4 bgcolor_D8D8D8">Special Allowance</div>
						<div class="col-md-8">
							<input type="text" name="salaryedit[emp_special_allowance]" id="popup_emp_special_allowance" onkeypress="return isNumber(event);" value="<?php if($emp_special_allowance){ echo $emp_special_allowance;} ?>"/>        
						</div>
					</div>	
					<div class="row">
						<div class="col-md-4 bgcolor_D8D8D8">Transport Allowance</div>
						<div class="col-md-8">
							<input type="text" name="salaryedit[emp_transport_allowance]" id="popup_emp_transport_allowance" onkeypress="return isNumber(event);" value="<?php if($emp_transport_allowance){ echo $emp_transport_allowance;} ?>"/>        
						</div>
					</div>												
					<div class="row">
						<div class="col-md-4 bgcolor_D8D8D8">Performance Bonus</div>
						<div class="col-md-8">
							<input type="text" name="salaryedit[emp_performance_bonus]" id="popup_emp_performance_bonus" onkeypress="return isNumber(event);" value="<?php if($emp_performance_bonus){ echo $emp_performance_bonus;} ?>"/>        
						</div>
					</div>	
					<div class="row">
						<div class="col-md-4 bgcolor_D8D8D8">Total Benifit</div>
						<div class="col-md-8">
							<input type="text" name="salaryedit[emp_total_benifit]" id="popup_emp_total_benifit" onkeypress="return isNumber(event);" value="<?php if($emp_total_benifit){ echo $emp_total_benifit;} ?>"/>        
						</div>
					</div>																																																									
				</div>
			</div>
		</div>
		<div class="row increament-display" style="display:none;">
			<div class="col-md-12 heading_style">
				Increment
			</div>
		</div>	
		<div id="popup_increment_area" class="increament-display" style="display:none">
			<div class="row">
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-4 bgcolor_D8D8D8" style="font-size: 11px;">Increment Amount</div>
						<div class="col-md-8">
							<input type="text" name="salaryedit[emp_salary_increment_amount]" id="popup_emp_salary_increment_amount" onkeypress="return isNumber(event);" value="<?php if($emp_salary_increment_amount){ echo $emp_salary_increment_amount;} ?>"/>        
						</div>
					</div>	
					<div class="row">
						<div class="col-md-4 bgcolor_D8D8D8" style="font-size: 11px;">Increment Percentage</div>
						<div class="col-md-8">
							<input type="text" name="salaryedit[emp_increment_percentage]" id="popup_emp_increment_percentage" value="<?php if($emp_increment_percentage){ echo $emp_increment_percentage;} ?>"/>        
						</div>
					</div>																									
				</div>									
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-4 bgcolor_D8D8D8" style="font-size: 11px;">Increment Date</div>
						<div class="col-md-8">
							<input type="text" name="salaryedit[emp_increment_date]" id="popup_emp_increment_date" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if($emp_increment_date){ echo $emp_increment_date;}else{ echo $now;} ?>"/>        
						</div>
					</div>													
				</div>
			</div>	
		</div>	
		<div class="row">
			<div class="col-md-12 heading_style">
				Payment Deduction
			</div>
		</div>	
		<div id="popup_deduction_area">
			<div class="row">
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-4 bgcolor_D8D8D8" style="font-size: 11px;">Provident/Welfare Fund</div>
						<div class="col-md-8">
							<input type="text" name="salaryedit[emp_provident_fund_deduction]" id="popup_emp_provident_fund_deduction" onkeypress="return isNumber(event);" value="<?php if($emp_provident_fund_deduction){ echo $emp_provident_fund_deduction;} ?>"/>        
						</div>
					</div>	
					<div class="row">
						<div class="col-md-4 bgcolor_D8D8D8">Total Deduction</div>
						<div class="col-md-8">
							<input type="text" name="salaryedit[emp_total_deduction]" id="popup_emp_total_deduction" onkeypress="return isNumber(event);" value="<?php if($emp_total_deduction){ echo $emp_total_deduction;} ?>"/>        
						</div>
					</div>																																																		
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-4 bgcolor_D8D8D8">Other Deduction</div>
						<div class="col-md-8">
							<input type="text" name="salaryedit[emp_other_deduction]" id="popup_emp_other_deduction" onkeypress="return isNumber(event);" value="<?php if($emp_other_deduction){ echo $emp_other_deduction;} ?>"/>        
						</div>
					</div>																																														
				</div>
			</div>	
		</div>										
		<div class="row">
			<div class="col-md-12 heading_style">
				Total Payment
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-4 bgcolor_D8D8D8">Gross Salary</div>
					<div class="col-md-8">
						<input type="text" name="salaryedit[emp_gross_salary]" id="popup_emp_gross_salary" onkeypress="return isNumber(event);" value="<?php if($emp_gross_salary){ echo $emp_gross_salary;} ?>"/>        
					</div>
				</div>													
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-4 bgcolor_D8D8D8">Yearly Paid</div>
					<div class="col-md-8">
						<input type="text" name="salaryedit[emp_yearly_paid]" id="popup_emp_yearly_paid" onkeypress="return isNumber(event);" value="<?php if($emp_yearly_paid){ echo $emp_yearly_paid;} ?>"/>        
					</div>
				</div>													
			</div>
		</div>																																					
	</form>
</div>  
-->
</div> 
<!-- /#wrapper -->     
     <!--Chosen--> 
        <script src="<?php echo base_url();?>resources/plugins/chosenSelect/chosen.jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>resources/plugins/chosenSelect/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
		<script>
                $(document).ready(function() {
                    $(".chosen-select").chosen();
                 });
             </script>
    
</body>
</html>