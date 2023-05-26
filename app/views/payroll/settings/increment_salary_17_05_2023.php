<div class="modal-content">
    <div class="modal-header">
        <a type="button" class="close pull-right" data-dismiss="modal">&times;</a>
        <h4 class="modal-title">Increment Staff Salary</h4>
    </div>
    <div class="modal-body">
        <form action="<?php echo site_url('save-increment') ?>" method="POST">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group col-md-12">
                        <label>Increment Based On</label>
                        <br />
                        <label class="radio-inline">
                            <input type="radio" name="increment_based_on" class="increment_based_on" value="basic" checked>Basic
                        </label>
                        <!-- <label class="radio-inline">
                        <input type="radio" name="increment_based_on" class="increment_based_on" value="gross">Gross
                    </label> -->
                    </div>
                    <div class="form-group col-md-12">
                        <label>New Basic Salary*</label>
                        <input class="form-control cal_new_basic" type="number" name="cal_new_basic" id="cal_new_basic" value="" placeholder="Please enter new basic salary" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Increment Amount (New Basic - Old Basic)*</label>
                        <input class="form-control increment_amount" type="number" name="increment_amount" id="increment_amount" value="" placeholder="Please enter increment amount (basic)" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Increment Percentage (Based on gross salary) *</label>
                        <input readonly class="form-control increment_percentage" type="number" name="increment_percentage" id="increment_percentage" value="" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Effective Date *</label>
                        <input class="form-control effective_date datepicker" type="text" name="effective_date" id="effective_date" value="" required>
                    </div>

                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="staff">Staff Name *:</label>
                                <input type="hidden" name="edit_content_id" id="edit_content_id" value="<?php echo $view_data->content_id; ?>">
                                <select disabled name="content_id" id="content_id" data-placeholder="Choose a staff..." class="chosen-select">
                                    <option value="">Choose a staff...</option>
                                    <?php foreach ($active_employees as $key => $empVal) : ?>
                                        <option value="<?php echo $empVal->content_id; ?>" <?php if (isset($view_data) && ($view_data->content_id == $empVal->content_id)) {
                                                                                                echo "selected='selected'";
                                                                                            } ?>><?php echo $empVal->emp_id . ' | ' . $empVal->emp_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="staff">Salary Grade *:</label>
                                <select name="grade_id" id="grade_id" data-placeholder="Choose a staff..." class="chosen-select grade_id">
                                    <option value="">Choose a salary grade...</option>
                                    <?php foreach ($salary_grades as $key => $gradeVal) : ?>
                                        <option value="<?php echo $gradeVal->id; ?>" <?php if (isset($view_data) && ($view_data->grade_id == $gradeVal->id)) {
                                                                                            echo "selected='selected'";
                                                                                        } ?>><?php echo $gradeVal->grade_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <br />
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border" style="color:orangered;">Salary History</legend>

                                <table class="table table-bordered">
                                    <thead>
                                        <th>SL No</th>
                                        <th>Grade</th>
                                        <th>Effective Date</th>
                                        <th>Increment Amount</th>
                                        <!-- <th>Increment Percentage</th> -->
                                        <th>Gross Salary</th>
                                        <th>Net Salary</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($salary_history as $key => $val) : ?>
                                            <tr>
                                                <td><?php echo $key + 1; ?></td>
                                                <td><?php echo $val->grade_name; ?></td>
                                                <td><?php echo $val->effective_date; ?></td>
                                                <td><?php echo $val->increment_amt; ?></td>
                                                <!-- <td><?php //echo $val->
                                                    ?></td> -->
                                                <td><?php echo $val->gross_salary; ?></td>
                                                <td><?php echo $val->net_salary; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </fieldset>
                        </div>
                    </div>


                </div>

            </div>
            <div class="row">
                <div class="col-sm-6">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border" style="color:orangered;">Earnings</legend>
                        <table>
                            <thead>
                                <th>Income Head</th>
                                <th>Previous Amount</th>
                                <th>After Increment</th>
                            </thead>

                            <!-- <h4 style="color:orangered;font-weight:bold;margin-bottom:10px">Earnings</h4> -->
                            <?php foreach ($salary_earning_heads as $earnHead) : ?>
                                <tr>
                                    <td><label><?php echo $earnHead->head_name; ?></label> <span class="txt_percentage_label txt_<?php echo $earnHead->short_name; ?>"></span></td>
                                    <td><input readonly class="form-control previous_salary_allowance_head" value="<?php if(isset($view_data->{$earnHead->short_name})){ 
                                            echo $view_data->{$earnHead->short_name};                                        
                                        }else{echo set_value($earnHead->short_name);} ?>" type="text" name="previous_<?php echo $earnHead->short_name; ?>" id="previous_<?php echo $earnHead->short_name; ?>"></td>
                                    <td><input readonly class="form-control salary_allowance_head" value="<?php echo set_value($earnHead->short_name) ?>" type="text" name="<?php echo $earnHead->short_name; ?>" id="<?php echo $earnHead->short_name; ?>"></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </fieldset>
                </div>
                <div class="col-sm-6">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border" style="color:orangered;">Deductions</legend>

                        <!-- <h4 style="color:orangered;font-weight:bold;margin-bottom:10px">Deductions</h4> -->
                        <table>
                            <thead>
                                <th>Income Head</th>
                                <th>Previous Amount</th>
                                <th>After Increment</th>
                            </thead>
                            <?php foreach ($salary_deduction_heads as $deductHead) : ?>
                                <tr>
                                    <td><label><?php echo $deductHead->head_name; ?></label> <span class="txt_percentage_label txt_<?php echo $deductHead->short_name; ?>"></span></td>
                                    <td><input readonly class="form-control previous_salary_deduction_head" type="text" name="previous_<?php echo $deductHead->short_name; ?>" id="previous_<?php echo $deductHead->short_name; ?>" value="<?php if(isset($view_data->{$deductHead->short_name})){ 
                                            echo $view_data->{$deductHead->short_name};                                        
                                        }else{echo set_value($deductHead->short_name);} ?>"></td>
                                    <td><input readonly class="form-control salary_deduction_head" type="text" name="<?php echo $deductHead->short_name; ?>" id="<?php echo $deductHead->short_name; ?>"></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border" style="color:orangered;">Total Payment</legend>
                        <table width="100%">
                            <tr>
                                <td style="text-align:right"><label>Gross Salary *</label></td>
                                <td><input readonly name="previous_gross_salary" id="previous_gross_salary" class="form-control" type="text" value="<?php if(isset($view_data->gross_salary)){ echo $view_data->gross_salary;}?>"></td>
                                <td><input readonly name="gross_salary" id="gross_salary" class="form-control" type="text">
                                </td>
                                <td style="text-align:right"><label>Net Salary *</label></td>
                                <td><input readonly name="previous_net_salary" id="previous_net_salary" class="form-control" type="text" value="<?php if(isset($view_data->net_salary)){ echo $view_data->net_salary;}?>"></td>
                                <td><input readonly name="net_salary" id="net_salary" class="form-control" type="text"></td>
                            </tr>
                        </table>
                    </fieldset>
                </div>
            </div>            
            <div class="modal-footer">
                <a type="button" class="btn btn-default close-btn" data-dismiss="modal">Close</a>
                <button type="submit" class="btn btn-sm btn-primary submit-btn" style="width:100px">Save Increment</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {

        $(".chosen-select").chosen();
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });
        var url_prefix = "<?php echo site_url(); ?>";
        $(document).on('keyup','.cal_new_basic', function() {
            var newBasic = $(this).val();
            if(!newBasic){
                newBasic = 0;
            }else if(newBasic<0){
                newBasic =0;
            }
            var previous_basic = $('#previous_basic').val();
            increment_amount = newBasic-previous_basic;
            
            $('.increment_amount').val(increment_amount);
            incCal(increment_amount);
        });
        
        $(document).on('keyup','.increment_amount', function() {
            var increment_amount = $(this).val();
            incCal(increment_amount);
            //console.log(increment_amount);
           
        });
        function incCal(increment_amount){
            var previous_basic = $('#previous_basic').val();
            var basic = Number(previous_basic) + Number(increment_amount);
            $('#basic').val(basic);
            var previous_gross_salary = $('#previous_gross_salary').val();
            var increment_percentage = increment_amount * 100 / previous_gross_salary;
            $('#increment_percentage').val(increment_percentage.toFixed(2));
            var gross_salary = Number(previous_gross_salary) + Number(increment_amount);
            $('#gross_salary').val(gross_salary.toFixed(2));
            var grade_id = $('#grade_id').val();

            if (grade_id) {
                $.ajax({
                    url: url_prefix + "grade-info-by-id",
                    dataType: 'JSON',
                    type: 'GET',
                    data: {
                        grade_id: grade_id
                    }
                }).done(function(response) {
                    var increment_based_on = $("input[name='increment_based_on']:checked").val();

                    $.each(response.salary_grade_allowances, function(key, value) {
                        var text = '';
                        var based_on = '';
                        var valueAmt = 0;

                        if (value.amount_type == 'based_on_other') {
                            text = " (" + value.percentage + " % based on " + value.based_on + ")";
                            $('.txt_' + value.head_short_name).text(text.toLowerCase());
                            var baseVal = $('#' + value.based_on).val();
                            valueAmt = baseVal * value.percentage / 100;
                        } else {
                            valueAmt = value.amount;
                        }

                        console.log( value.head_short_name +'=>'+ valueAmt);
                        if (increment_based_on == 'basic' && value.head_short_name == 'basic') {
                            $('#' + value.head_short_name).val(Number(previous_basic) + Number(increment_amount));
                             
                        } else {
                                $('#' + value.head_short_name).val(valueAmt);                          
                        }
                    });
                    $.each(response.salary_grade_deductions, function(key, value) {
                        var text = '';
                        var based_on = '';
                        var valueAmt = 0;
                        if (value.amount_type == 'based_on_other') {
                            text = " (" + value.percentage + " % based on " + value.based_on + ")";
                            $('.txt_' + value.head_short_name).text(text.toLowerCase());
                            var baseVal = $('#' + value.based_on).val();
                            valueAmt = baseVal * value.percentage / 100;
                        } else {
                            valueAmt = value.amount;
                        }
                        $('#' + value.head_short_name).val(valueAmt);
                    });
                    /*
                    
                    */
                    var previous_mba = $('#previous_mba').val();
                    var previous_td = $('#previous_td').val();
                    var mba = $('#mba').val();
                    var td = $('#td').val();
                    if(previous_mba>mba || mba==0){
                        $('#mba').val(previous_mba);
                    }
                    if(previous_td>td || td==0){
                        $('#td').val(previous_td);
                    }
                    totalCal();
                });
            }
        }
        $('.increment_percentage').on('keyup', function() {
            var increment_percentage = $(this).val();
            //console.log(increment_amount);
            var previous_gross_salary = $('#previous_gross_salary').val();
            var increment_amount = increment_percentage * previous_gross_salary / 100;
            $('#increment_amount').val(increment_amount.toFixed(2));
            var gross_salary = Number(previous_gross_salary) + Number(increment_amount);
            $('#gross_salary').val(gross_salary.toFixed(2));
        });
        $('.grade_id').on('change', function() {
            $('.salary_allowance_head').val(0);
            $('.salary_deduction_head').val(0);
            $('.txt_percentage_label').text('');
            var previous_basic = $('#previous_basic').val();
            var grade_id = $(this).val();

            //alert(grade_id);
            if (grade_id) {
                $.ajax({
                    url: url_prefix + "grade-info-by-id",
                    dataType: 'JSON',
                    type: 'GET',
                    data: {
                        grade_id: grade_id
                    }
                }).done(function(response) {
                    //console.log(response.salary_grade_deductions);

                    $.each(response.salary_grade_allowances, function(key, value) {
                        var text = '';
                        var based_on = '';
                        var valueAmt = 0;
                        if (value.amount_type == 'based_on_other') {
                            text = " (" + value.percentage + " % based on " + value.based_on + ")";
                            $('.txt_' + value.head_short_name).text(text.toLowerCase());
                            var baseVal = $('#previous_' + value.based_on).val();
                            valueAmt = baseVal * value.percentage / 100;
                        } else {
                            valueAmt = value.amount;
                        }
                        if(value.head_short_name=='basic'){
                            gradeBasicAmt=valueAmt;
                        }
                        if(gradeBasicAmt>0){
                            $('#previous_' + value.head_short_name).val(valueAmt);
                            $('#' + value.head_short_name).val(valueAmt);
                        }
                        

                    });
                    $.each(response.salary_grade_deductions, function(key, value) {
                        var text = '';
                        var based_on = '';
                        var valueAmt = 0;
                        if (value.amount_type == 'based_on_other') {
                            text = " (" + value.percentage + " % based on " + value.based_on + ")";
                            $('.txt_' + value.head_short_name).text(text.toLowerCase());
                            var baseVal = $('#previous_' + value.based_on).val();
                            valueAmt = baseVal * value.percentage / 100;
                        } else {
                            valueAmt = value.amount;
                        }
                        if(valueAmt>0){
                            $('#previous_' + value.head_short_name).val(valueAmt);
                            $('#' + value.head_short_name).val(valueAmt);
                        }
                    });
                    totalCal();
                });
            }
        });
        $('.salary_allowance_head').each(function() {
            var headVal = $(this).attr('id');
            $('#' + headVal).keyup(function() {
                totalCal();
            });
        });
        $('.salary_deduction_head').each(function() {
            var headVal = $(this).attr('id');
            $('#' + headVal).keyup(function() {
                totalCal();
            });
        });

        $('.submit-btn').on('click', function() {
            var content_id = $('#edit_content_id').val();
            var grade_id = $('#grade_id').val();
            var gross_salary = $('#gross_salary').val();
            var net_salary = $('#net_salary').val();
            if (!content_id || !grade_id || !gross_salary || !net_salary) {
                alert('Please fill out the all required fields which contains (*) sign.');
                return false;
            }
        });

        function totalCal() {
            var previous_salary_allowance_head_total = 0;
            var previous_salary_deduction_head_total = 0;
            var salary_allowance_head_total = 0;
            var salary_deduction_head_total = 0;
            var previous_pf_contribution=0;
            var pf_contribution=0;
            $('.previous_salary_allowance_head').each(function() {
                var headVal = $(this).val();
                previous_salary_allowance_head_total += Number(headVal);
            });

            $('.previous_salary_deduction_head').each(function() {
                var headVal = $(this).val();
                previous_salary_deduction_head_total += Number(headVal);
            });
            $('.salary_allowance_head').each(function() {
                var headVal = $(this).val();
                salary_allowance_head_total += Number(headVal);
            });

            $('.salary_deduction_head').each(function() {
                var headVal = $(this).val();
                salary_deduction_head_total += Number(headVal);
            });

            pf_contribution = $('#pf').val();
            previous_pf_contribution = $('#previous_pf').val();
           
            var previous_gross_salary = Number(previous_salary_allowance_head_total)+Number(previous_pf_contribution);
            
            $('#previous_gross_salary').val(previous_gross_salary.toFixed(2));

            var gross_salary = Number(salary_allowance_head_total)+Number(pf_contribution);
            $('#gross_salary').val(gross_salary.toFixed(2));

            var previous_net_salary = previous_salary_allowance_head_total - previous_salary_deduction_head_total
            var net_salary = salary_allowance_head_total - salary_deduction_head_total
            $('#net_salary').val(net_salary.toFixed(2));
            $('#previous_net_salary').val(previous_net_salary.toFixed(2));
        }
    });
</script>