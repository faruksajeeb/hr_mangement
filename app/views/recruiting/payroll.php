<script>
    $(function () {

        $("#increment_area").hide();
        
        $('#emp_gross_salary').attr('readonly', 'readonly').css("background-color","#F0E68C");
        $('#emp_yearly_paid').attr('readonly', 'readonly').css("background-color","#F0E68C");
        $("#payroll_edit_btn").attr("disabled", "disabled");
        $('#deduction_area').find('input').attr('readonly', 'readonly').css("background-color","#F0E68C");
        $('#salary_area').find('input').attr('readonly', 'readonly').css("background-color","#F0E68C");
         $('#payment_area').find('input,select').attr('readonly', 'readonly').css("background-color","#F0E68C");
        
        $("#emp_salary_increment").click(function () {
            if ($(this).is(':checked')) {
                $("#increment_area").show(1000);
                $("#payroll_edit_btn").removeAttr("disabled", "disabled");
                $("#emp_telephone_allowance").removeAttr("readonly", "readonly").css("background-color","#FFF");
                $("#emp_festival_bonus").removeAttr("readonly", "readonly").css("background-color","#FFF");
                $('#deduction_area').find('input').removeAttr('readonly', 'readonly').css("background-color","#FFF");
               // $('#salary_area').find('input').removeAttr('disabled', 'disabled').css("background-color","#FFF");
                $('#payment_area').find('input,select').removeAttr('readonly', 'readonly').css("background-color","#FFF");
        
            } else {
                $('#salary_area').find('input').attr('readonly', 'readonly').css("background-color","#F0E68C");
                $("#increment_area").hide(1000);
                $("#payroll_edit_btn").attr("disabled", "disabled");
                $('#deduction_area').find('input').attr('readonly', 'readonly').css("background-color","#F0E68C");
                $('#payment_area').find('input,select').attr('readonly', 'readonly').css("background-color","#F0E68C");
        
            }

           


        });
        /*
        $("#salary_area").keyup(function () {
            var emp_basic_salary = $('#basic_salary').val();
            if (!emp_basic_salary) {
                var emp_basic_salary = 0;
            }
            var emp_house_rent = $('#house_rent').val();
            if (!emp_house_rent) {
                var emp_house_rent = 0;
            }
            var emp_medical_allowance = $('#medical_allow').val();
            if (!emp_medical_allowance) {
                var emp_medical_allowance = 0;
            }
            var emp_conveyance = $('#conveyance_allow').val();
            if (!emp_conveyance) {
                var emp_conveyance = 0;
            }
            var emp_telephone_allowance = $('#telephone_allow').val();
            if (!emp_telephone_allowance) {
                var emp_telephone_allowance = 0;
            }
            var emp_special_allowance = $('#special_allowa').val();
            if (!emp_special_allowance) {
                var emp_special_allowance = 0;
            }
            var emp_provident_fund_allowance = $('#provident_allow').val();
            if (!emp_provident_fund_allowance) {
                var emp_provident_fund_allowance = 0;
            }
            var emp_transport_allowance = $('#transport_allow').val();
            if (!emp_transport_allowance) {
                var emp_transport_allowance = 0;
            }
            var emp_other_allowance = $('#other_allow').val();
            if (!emp_other_allowance) {
                var emp_other_allowance = 0;
            }
            var emp_performance_bonus = $('#performance_bonus').val();
            if (!emp_performance_bonus) {
                var emp_performance_bonus = 0;
            }
            var emp_festival_bonus = $('#festival_bonus').val();
            if (!emp_festival_bonus) {
                var emp_festival_bonus = 0;
            }
            var total_benifit = parseInt(emp_house_rent) + parseInt(emp_medical_allowance) + parseInt(emp_conveyance) + parseInt(emp_telephone_allowance) + parseInt(emp_special_allowance) + parseInt(emp_provident_fund_allowance) + parseInt(emp_transport_allowance) + parseInt(emp_other_allowance) + parseInt(emp_performance_bonus) + parseInt(emp_festival_bonus);
            $('#total_benifit').val(total_benifit);
            var emp_provident_fund_deduction = $('#provident_fund_deduction').val();
            if (!emp_provident_fund_deduction) {
                var emp_provident_fund_deduction = 0;
            }
            // var emp_advance_loan= $('#emp_advance_loan').val(); 
            // if(!emp_advance_loan) {
            // 	var emp_advance_loan = 0;
            // } 
            var emp_other_deduction = $('#other_deduction').val();
            if (!emp_other_deduction) {
                var emp_other_deduction = 0;
            }
            var present_salary = $('#present_salary').val(); 
            if(!present_salary){
            present_salary=0;
        }
            var total_deduction = parseInt(emp_provident_fund_deduction) + parseInt(emp_other_deduction);
            $('#total_deduction').val(total_deduction);
            var gross_salary = parseInt(total_benifit) + parseInt(emp_basic_salary) - parseInt(total_deduction);
            // var previous_salary= $('#emp_gross_salary').val(); 
            if ($('#emp_salary_increment').is(':checked')) {
                
                var total_increment_amount = parseInt(emp_basic_salary) + parseInt(total_benifit);
                var total_gross_salary = parseInt(present_salary) + parseInt(total_increment_amount) - parseInt(total_deduction);
                $('#increment_amount').val(total_increment_amount);
                var emp_increment_percentage = Math.round(total_increment_amount * 100 / present_salary);
            } else {
                var total_gross_salary = parseInt(gross_salary);
            }

            $('#gross_salary').val(total_gross_salary);
            var yearly_salary = total_gross_salary * 12;
            $('#yearly_paid').val(yearly_salary);
            if (!isNaN(emp_increment_percentage)) {
                $('#increment_percentage').val(emp_increment_percentage + "%");
            }

        });
        */
       
       



    });
</script>
 <?php
$editPayroll=$this->users_model->getuserwisepermission("edit_payroll", $this->session->userdata('user_id'));
//echo $editPayroll['status'];
?>
<div class="modal fade" id="payRollModal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </a>
                <h4 class="modal-title" id="myModalLabel"><strong><span id="tag"></span>   Payroll</strong></h4>
            </div>
            <div class="modal-body">
                <form id="payroll-form" action="<?php echo base_url() ?>salary/save_payroll" method="POST" class="smart-form">
                    <input type="hidden" class="" name="content_id" id="content_id"  />
                    <input type="hidden" class="" name="present_salary" id="present_salary"  />

                    <div class="" id="">
                        <div class="row heading_style presentsalry_heading">
                            <div class="col-md-7 ">
                                Present Salary 



                            </div>

                            <div class="col-md-5 " style="text-align:right;">
                                <span class="btn btn-xs btn-default pull-left" id="salary_history" data_id="<?php ?>">History</span> 
                                <!--Update	<input type="radio" class=""  name="action" id="emp_salary_update"  checked="checked" />-->
                              <?php if($editPayroll['status']==1 || $this->session->userdata('user_type')==1){?>
                                <span style="font-size:15px" class="glyphicon glyphicon-pencil"> </span> Edit / Increment	<input type="checkbox" name="emp_salary_increment" id="emp_salary_increment" />
                            <?php }?>
                            </div>
                        </div>	
                        <div id="salary_area">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4 bgcolor_D8D8D8">Basic Salary</div>
                                        <div class="col-md-8">
                                            <input type="text" name="emp_basic_salary" id="emp_basic_salary" readonly   value=""/>        
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 bgcolor_D8D8D8">House Rent Allowan.</div>
                                        <div class="col-md-8">
                                            <input type="text" name="emp_house_rent" id="emp_house_rent"   value=""/>        
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 bgcolor_D8D8D8">Transport Allowance</div>
                                        <div class="col-md-8">
                                            <input type="text" name="emp_transport_allowance" id="emp_transport_allowance"   value=""/>        
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 bgcolor_D8D8D8">Telephone Allowance</div>
                                        <div class="col-md-8">
                                            <input type="text" name="emp_telephone_allowance" id="emp_telephone_allowance"   value=""/>        
                                        </div>
                                    </div>																																																								
                                </div>
                                <div class="col-md-6">
                                    	
                                    <div class="row">
                                        <div class="col-md-4 bgcolor_D8D8D8">Medical Allowance</div>
                                        <div class="col-md-8">
                                            <input type="text" name="emp_medical_allowance" id="emp_medical_allowance"   value=""/>        
                                        </div>
                                    </div>	
                                    												
                                    <div class="row">
                                        <div class="col-md-4 bgcolor_D8D8D8">Other Allowance</div>
                                        <div class="col-md-8">
                                            <input type="text" name="emp_other_allowance" id="emp_other_allowance"   value=""/>        
                                        </div>
                                    </div>	
                                    <div class="row">
                                        <div class="col-md-4 bgcolor_D8D8D8">Festival Bonus(%)</div>
                                        <div class="col-md-8">
                                            <input type="text" name="emp_festival_bonus" id="emp_festival_bonus"   value="" placeholder="Ex.50"/>        
                                        </div>
                                    </div>	
                                    <div class="row">
                                        <div class="col-md-4 bgcolor_D8D8D8">Total Allowance</div>
                                        <div class="col-md-8">
                                            <input type="text" name="emp_total_benifit" id="emp_total_benifit" readonly=""  value=""/>        
                                        </div>
                                    </div>																																																									
                                </div>
                            </div>
                        </div>
                        <div id="increment_area">
                            
                            <div class="row">
                                <div class="col-md-12 heading_style">
                                    Increment
                                </div>
                            </div>	

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4 bgcolor_D8D8D8" style="font-size: 11px;">Increment Amount</div>
                                        <div class="col-md-8">
                                            <input type="text" name="emp_salary_increment_amount" id="emp_salary_increment_amount"  value=""/>        
                                        </div>
                                    </div>	
                                    <div class="row">
                                        <div class="col-md-4 bgcolor_D8D8D8" style="font-size: 11px;">Increment Percentage</div>
                                        <div class="col-md-8">
                                            <input type="text" name="emp_increment_percentage" id="emp_increment_percentage" readonly value=""/>        
                                        </div>
                                    </div>																									
                                </div>									
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4 bgcolor_D8D8D8" style="font-size: 11px;">Effective date from:</div>
                                        <div class="col-md-8">
                                             <?php
                            $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
                            $current_date = $dt->format('d-m-Y');
//                            echo $current_date;
                            ?>
                                            <input type="text" name="emp_increment_date" id="emp_increment_date"  value="<?php echo $current_date; ?>" class="datepicker"  placeholder="dd-mm-yyyy"/>        
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
                                            <input type="text" name="emp_provident_fund_deduction" id="emp_provident_fund_deduction" value=""/>        
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 bgcolor_D8D8D8">Tax</div>
                                        <div class="col-md-8">
                                            <input type="text" name="emp_tax_deduction" id="emp_tax_deduction"  value=""/>        
                                        </div>
                                    </div>
                                    																																																		
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4 bgcolor_D8D8D8">Other Deduction</div>
                                        <div class="col-md-8">
                                            <input type="text" name="emp_other_deduction" id="emp_other_deduction"  value=""/>        
                                        </div>
                                    </div>	
                                    <div class="row">
                                        <div class="col-md-4 bgcolor_D8D8D8">Total Deduction</div>
                                        <div class="col-md-8">
                                            <input type="text" name="emp_total_deduction" readonly id="emp_total_deduction"  value=""/>        
                                        </div>
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
                                    <input type="text" name="emp_gross_salary" id="emp_gross_salary"   value=""/>        
                                </div>
                            </div>													
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 bgcolor_D8D8D8">Yearly Paid</div>
                                <div class="col-md-8">
                                    <input type="text" name="emp_yearly_paid" readonly id="emp_yearly_paid" readonly="" onkeypress="return isNumber(event);" value=""/>        
                                </div>
                            </div>													
                        </div>
                    </div>																		
                    <div id="payment_area">
                    <div class="row">
                        <div class="col-md-12 heading_style">
                            Payment Method
                        </div>
                    </div>																			
                    <div class="row" >
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 bgcolor_D8D8D8">Bank</div>
                                <div class="col-md-8">
                                    <select name="emp_bank" id="emp_bank">
                                        <option value="">Select Bank</option>
                                        <?php
                                        foreach ($allbankname as $single_bank) {
                                            if ($emp_bank == $single_bank['tid']) {
                                                echo '<option value="' . $single_bank['tid'] . '" selected="selected">' . $single_bank['name'] . '</option>';
                                            } else {
                                                echo '<option value="' . $single_bank['tid'] . '">' . $single_bank['name'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>         
                                </div>
                            </div>  

                            <div class="row">
                                <div class="col-md-4 bgcolor_D8D8D8">Account Number</div>
                                <div class="col-md-8">
                                    <input type="text" name="emp_bank_account" id="emp_bank_account" value=""/>        
                                </div>
                            </div>                                 
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 bgcolor_D8D8D8">Bank Branch</div>
                                <div class="col-md-8">
                                    <input type="text" name="emp_bank_branch" id="emp_bank_branch" value=""/>        
                                </div>
                            </div>	
                            <div class="row">
                                <div class="col-md-4 bgcolor_D8D8D8">Pay Type</div>
                                <div class="col-md-8">
                                    <select name="emp_pay_type" id="emp_pay_type">
                                        <option value="">Select Pay Type</option>
                                        <?php
                                        foreach ($allpaytype as $single_paytype) {
                                            if ($emp_pay_type == $single_paytype['tid']) {
                                                echo '<option value="' . $single_paytype['tid'] . '" selected="selected">' . $single_paytype['name'] . '</option>';
                                            } else if ($single_paytype['tid'] == '207' && !$emp_pay_type) {
                                                echo '<option value="' . $single_paytype['tid'] . '" selected="selected">' . $single_paytype['name'] . '</option>';
                                            } else {
                                                echo '<option value="' . $single_paytype['tid'] . '">' . $single_paytype['name'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>         
                                </div>
                            </div>																							
                        </div>
                    </div>
                    </div>
            </div>
            <hr/>
            <footer>
                <button id="payroll_edit_btn" type="submit" style="width:150px" class="btn btn-sm btn-primary pull-right">

                    Save Changes  <span id="tag_save_btn"></span>
                </button>
                <a type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                </a>

            </footer>
            </form>	


        </div>

        <!--</form>-->
    </div>
</div>
</div>
<script>
    $(function(){
        // Increment Area ------------------------------------------------------
         $("#emp_salary_increment_amount").keyup(function(){
            	$('#emp_salary_increment_amount').removeAttr( "disabled" );
                var present_salary = $('#present_salary').val();
                if(!present_salary){
                    present_salary=0;
                }
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
            	var total_benifit=parseInt(house_rent)+parseInt(medical_allow)+parseInt(transport_allow)+parseInt(other_allow);
            	$('#emp_basic_salary').val(basic_salary);
            	$('#emp_house_rent').val(house_rent);
            	$('#emp_medical_allowance').val(medical_allow);
            	//$('#conveyance_allow').val(conveyance_allow);
            	//$('#provident_allow').val(provident_allow);
            	$('#emp_transport_allowance').val(transport_allow);
            	$('#emp_other_allowance').val(other_allow);
            	$('#emp_total_benifit').val(total_benifit);
        });
        // Deduction Area ------------------------------------------------------
        
         $("#deduction_area").keyup(function () {

            if ($("#emp_salary_increment").is(':checked')) {
                var provident_fund_deduction = $('#emp_provident_fund_deduction').val();
                if (!provident_fund_deduction) {
                    var provident_fund_deduction = 0;
                }
                var present_salary = $('#present_salary').val();
                if(!present_salary){
                    present_salary=0;
                }
                
                var tax_deduction= $('#emp_tax_deduction').val();
                if(!tax_deduction){
                    tax_deduction= 0;
                }
                var emp_other_deduction = $('#emp_other_deduction').val();
                if (!emp_other_deduction) {
                    var emp_other_deduction = 0;
                }
                var increment_amount=$('#emp_salary_increment_amount').val();
                    if(!increment_amount){
                    increment_amount=0;
                }
                var total_deduction = parseInt(provident_fund_deduction) + parseInt(tax_deduction) + parseInt(emp_other_deduction);
                $('#emp_total_deduction').val(total_deduction);
                
                
                
            }
        });
        
    });
</script>