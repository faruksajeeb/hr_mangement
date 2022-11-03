<script>
    $(function() {
        // disable mousewheel on a input number field when in focus
        // (to prevent Cromium browsers change the value when scrolling)
        $('form').on('focus', 'input[type=number]', function(e) {
            $(this).on('mousewheel.disableScroll', function(e) {
                e.preventDefault()
            })
        })
        $('form').on('blur', 'input[type=number]', function(e) {
            $(this).off('mousewheel.disableScroll')
        })


    });
</script>
<style>
    input[readonly] {
        background-color: #CCC;
        cursor: not-allowed;
    }
</style>

<div class="modal fade" id="paySlipModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </a>
                <h4 class="modal-title" id="myModalLabel"><strong><span id="tag"></span> Edit Payslip</strong></h4>
            </div>
            <div class="modal-body">
                <form id="payslip-form" action="<?php echo base_url() ?>payroll/editPaySlip" method="POST" class="smart-form">
                    <input type="hidden" class="" name="payslip_id" id="payslip_id" />
                    <input type="hidden" class="" name="page_name" id="page_name" />
                    <div class="" id="payment_area">

                        <div id="salary_area">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4 text-left">Emp ID: </div>
                                        <div class="col-md-8">
                                            <input type="text" name="emp_id" id="emp_id" readonly value="" />
                                            <input type="hidden" name="emp_post" id="emp_post" value="" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4  text-left">Emp Name: </div>
                                        <div class="col-md-8">
                                            <input type="text" name="emp_name" id="emp_name" readonly="" />
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="row">
                                        <div class="col-md-4  text-left">Year: </div>
                                        <div class="col-md-8">
                                            <input type="text" name="year_name" id="year_name" readonly="" value="" />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4  text-left">Month: </div>
                                        <div class="col-md-8">
                                            <input type="text" name="month" id="month" readonly="" value="" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row heading_style ">
                            <div class="col-md-12 ">
                                Basic Salary & Allowances.
                            </div>
                        </div>
                        <div class="row" id="allowance_area">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Basic</div>
                                    <div class="col-md-8">
                                        <input class="allowance_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_basic_salary" id="emp_basic_salary" readonly value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">House Rent </div>
                                    <div class="col-md-8">
                                        <input class="allowance_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_house_rent" id="emp_house_rent" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Transport Allow.</div>
                                    <div class="col-md-8">
                                        <input class="allowance_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_transport_allowance" id="emp_transport_allowance" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Daily Allow.</div>
                                    <div class="col-md-8">
                                        <input class="allowance_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_daily_allowance" id="emp_daily_allowance" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Telephone Allow.</div>
                                    <div class="col-md-8">
                                        <input class="allowance_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_telephone_allowance" id="emp_telephone_allowance" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">P/F Allow.</div>
                                    <div class="col-md-8">
                                        <input class="allowance_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_pf_allowance" id="emp_pf_allowance" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Arrear Salary</div>
                                    <div class="col-md-8">
                                        <input class="allowance_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_arear" id="emp_arear" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">OT Hours</div>
                                    <div class="col-md-8">
                                        <input type="text" name="emp_ot_hour" id="emp_ot_hour" placeholder="Ex.03:30" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">OT Taka</div>
                                    <div class="col-md-8">
                                        <input class="allowance_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_ot_taka" id="emp_ot_taka" value="" />
                                    </div>
                                </div> <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">House maintenance Allowance</div>
                                    <div class="col-md-8">
                                        <input class="allowance_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_hma_allowance" id="emp_hma_allowance" value="" />
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-md-6">

                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Medical Allow.</div>
                                    <div class="col-md-8">
                                        <input class="allowance_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_medical_allowance" id="emp_medical_allowance" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Entertainment Allow.</div>
                                    <div class="col-md-8">
                                        <input class="allowance_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_entertainment_allowance" id="emp_entertainment_allowance" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Conveyance Allow.</div>
                                    <div class="col-md-8">
                                        <input class="allowance_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_conveyance_allowance" id="emp_conveyance_allowance" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Other Allow.</div>
                                    <div class="col-md-8">
                                        <input class="allowance_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_other_allowance" id="emp_other_allowance" value="" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Performance Bonus</div>
                                    <div class="col-md-8">
                                        <input class="allowance_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_performance_bonus" id="emp_performance_bonus" value="" placeholder="Ex.50" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Festival Bonus(tk)</div>
                                    <div class="col-md-8">
                                        <input class="allowance_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_festival_bonus" id="emp_festival_bonus" value="" placeholder="Ex.50" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Special Bonus</div>
                                    <div class="col-md-8">
                                        <input class="allowance_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_special_bonus" id="emp_special_bonus" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Gratuity</div>
                                    <div class="col-md-8">
                                        <input class="allowance_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_gratuity" id="emp_gratuity" value="" />
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Incentive</div>
                                    <div class="col-md-8">
                                        <input class="allowance_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_incentive" id="emp_incentive" value="" />
                                    </div>
                                </div>
                                
                               
                            </div>
                        </div>

                        <div class="row" id="deduction_area">
                            <div class="col-md-12 heading_style">
                                Payment Deduction
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8" style="font-size: 11px;">Arrear P/F</div>
                                    <div class="col-md-8">
                                        <input class="deduction_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="arrear_pf" id="arrear_pf" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8" style="font-size: 11px;">P/W Fund</div>
                                    <div class="col-md-8">
                                        <input class="deduction_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_provident_fund_deduction" id="emp_provident_fund_deduction" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Tax/ AIT</div>
                                    <div class="col-md-8">
                                        <input class="deduction_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_tax_deduction" id="emp_tax_deduction" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Other Deduction</div>
                                    <div class="col-md-8">
                                        <input class="deduction_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_other_deduction" id="emp_other_deduction" value="" />
                                        <a data-toggle="collapse" data-target="#other_deduction_note_accordion">note</a>

                                        <div id="other_deduction_note_accordion" class="collapse">
                                            <textarea name="other_deduction_note" id="other_deduction_note"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Absent Day</div>
                                    <div class="col-md-8">
                                        <input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_absent_day" id="emp_absent_day" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Absent (Tk.)</div>
                                    <div class="col-md-8">
                                        <input class="deduction_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_absent_taka" id="emp_absent_taka" value="" />
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Loan</div>
                                    <div class="col-md-8">
                                        <input class="deduction_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_loan" id="emp_loan" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Advance Salary</div>
                                    <div class="col-md-8">
                                        <input class="deduction_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_advance_salary" id="emp_advance_salary" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Late Day</div>
                                    <div class="col-md-8">
                                        <input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="late_day" id="late_day" value="" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Late (Tk.)</div>
                                    <div class="col-md-8">
                                        <input class="deduction_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="late_deduction" id="late_deduction" value="" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Early Day</div>
                                    <div class="col-md-8">
                                        <input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="early_day" id="early_day" value="" />
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 bgcolor_D8D8D8">Early (Tk.)</div>
                                    <div class="col-md-8">
                                        <input class="deduction_head" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="early_deduction" id="early_deduction" value="" />
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
                                    <input type="hidden" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="present_salary" id="present_salary" readonly="" value="" />
                                    <input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_gross_salary" id="emp_gross_salary" readonly="" value="" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 bgcolor_D8D8D8">Net Payment</div>
                                <div class="col-md-8">
                                    <input type="hidden" name="gross_total" readonly id="gross_total" readonly="" placeholder="total" value="" />
                                    <input type="hidden" name="total_deduction" readonly id="total_deduction" placeholder="total_d" readonly="" value="" />
                                    <input type="hidden" name="total_paid" readonly id="total_paid" placeholder="total_paid" readonly="" value="" />
                                    <input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="emp_net_payment" readonly id="emp_net_payment" readonly="" value="" />
                                    <span id="env_msg"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <footer>
                        <button id="payroll_edit_btn" type="submit" style="width:150px" class="btn btn-sm btn-primary pull-right">

                            Save Changes <span id="tag_save_btn"></span>
                        </button>
                        <a type="button" class="btn btn-default" data-dismiss="modal">
                            Cancel
                        </a>

                    </footer>
                </form>
            </div>




        </div>

        <!--</form>-->
    </div>
</div>
</div>
<script>
    $(function() {
        $('.allowance_head').each(function() {
            var headVal = $(this).attr('id');
            $('#' + headVal).keyup(function() {                
                totalCal();
            });
        });
        $('.deduction_head').each(function() {
            var headVal = $(this).attr('id');
            $('#' + headVal).keyup(function() {
                totalCal();
            });
        });

        function totalCal() {
            var allowance_head_total = 0;
            var deduction_head_total = 0;
            $('.allowance_head').each(function() {
                var headVal = $(this).val();
                if(!headVal){
                    headVal=0;
                }
                allowance_head_total += Number(headVal);
            });

            $('.deduction_head').each(function() {
                var headVal = $(this).val();
                if(!headVal){
                    headVal=0;
                }
                deduction_head_total += Number(headVal);
            });
            var pf_contribution = $('#emp_provident_fund_deduction').val();
            var gross_salary = Number(allowance_head_total)+Number(pf_contribution);
            $('#emp_gross_salary').val(Math.round(gross_salary.toFixed(2)));
            
            var net_salary = Number(allowance_head_total) - Number(deduction_head_total);
            $('#emp_net_payment').val(Math.round(net_salary.toFixed(2)));
        }
      
            <?php
            $userName = $this->session->userdata('user_name');
            if ($userName == 'ac-cocl' || $userName == 'ac-bl' || $userName == 'ac-agt') {
                // Overtime manual Entry--
            } else {
                // Overtime automatic calculation--
            } ?>
           
    });
</script>