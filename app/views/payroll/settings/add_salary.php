<div class="modal-content">
    
    <div class="modal-header">
        <a type="button" class="close pull-right" data-dismiss="modal">&times;</a>
        <h4 class="modal-title"><?php echo isset($edit_data) ? 'Edit' : 'Add'; ?> Staff Salary</h4>
    </div>
    <form action="<?php echo site_url('save-salary') ?>" method="POST">
        <input type="hidden" name="edit_id" id="edit_id" value="<?php if (isset($edit_data)) {
                                                                    echo $edit_data->id;
                                                                } ?>" />
        <?php if ($error) : ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="staff">Select Staff *:</label>
                        <?php if (isset($edit_data)) { ?>
                            <input type="hidden" name="content_id" id="" value="<?php echo $edit_data->content_id; ?>" />
                        <?php } ?>
                        <select name="content_id" id="content_id" <?php if (isset($edit_data)) {
                                                                        echo "disabled";
                                                                    } ?> data-placeholder="Choose a staff..." class="chosen-select">
                            <option value="">Choose a staff...</option>
                            <?php foreach ($active_employees as $key => $empVal) : ?>
                                <option value="<?php echo $empVal->content_id; ?>" <?php if (isset($edit_data) && ($edit_data->content_id == $empVal->content_id)) {
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
                                <option value="<?php echo $gradeVal->id; ?>" <?php if (isset($edit_data) && ($edit_data->grade_id == $gradeVal->id)) {
                                                                                    echo "selected='selected'";
                                                                                } ?>><?php echo $gradeVal->grade_name.' ('.$gradeVal->description.')'; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border" style="color:orangered;">Earnings</legend>

                        <!-- <h4 style="color:orangered;font-weight:bold;margin-bottom:10px">Earnings</h4> -->
                        <?php foreach ($salary_earning_heads as $earnHead) : ?>
                            <div class="form-group">
                                <label><?php echo $earnHead->head_name; ?></label> <span class="txt_percentage_label txt_<?php echo $earnHead->short_name; ?>"></span>
                                <input class="form-control salary_allowance_head" value="<?php 
                                if(isset($edit_data->{$earnHead->short_name})){ 
                                            echo $edit_data->{$earnHead->short_name};                                        
                                        }else{
                                            echo set_value($earnHead->short_name);} ?>" type="text" name="<?php echo $earnHead->short_name; ?>" id="<?php echo $earnHead->short_name; ?>">
                            </div>
                        <?php endforeach; ?>
                    </fieldset>
                </div>
                <div class="col-sm-6">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border" style="color:orangered;">Deductions</legend>

                        <!-- <h4 style="color:orangered;font-weight:bold;margin-bottom:10px">Deductions</h4> -->
                        <?php foreach ($salary_deduction_heads as $deductHead) : ?>
                            <div class="form-group">
                                <label><?php echo $deductHead->head_name; ?></label> <span class="txt_percentage_label txt_<?php echo $deductHead->short_name; ?>"></span>
                                <input class="form-control salary_deduction_head" type="text" name="<?php echo $deductHead->short_name; ?>" id="<?php echo $deductHead->short_name; ?>" value="<?php 
                                if(isset($edit_data->{$deductHead->short_name})){ 
                                            echo $edit_data->{$deductHead->short_name};                                        
                                        }else{
                                            echo set_value($deductHead->short_name);} ?>">
                            </div>
                        <?php endforeach; ?>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border" style="color:orangered;">Total Payment</legend>
                        <div class="form-group col-md-6">
                            <label>Gross Salary *</label>
                            <input readonly name="gross_salary" id="gross_salary" class="form-control" type="text" value="<?php if(isset($edit_data->gross_salary)){ echo $edit_data->gross_salary;}?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Net Salary *</label>
                            <input readonly name="net_salary" id="net_salary" class="form-control" type="text" value="<?php if(isset($edit_data->net_salary)){ echo $edit_data->net_salary;}?>">
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <fieldset class="scheduler-border">
                        <legend class="scheduler-border" style="color:orangered;">Payment Method</legend>
                        <div class="form-group col-md-6">
                            <label>Bank Name</label>
                            <select name="bank_id" id="bank_id" class="chosen-select">
                                <option value="">--select bank--</option>
                                <?php foreach ($banks as $val) : ?>
                                    <option value="<?php echo $val->id; ?>" <?php if (isset($edit_data) && ($edit_data->bank_id == $val->id)) {
                                                                                echo "selected='selected'";
                                                                            } ?>><?php echo $val->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Branch Name</label>
                            <input class="form-control" type="text" name="branch_name" id="branch_name" value="<?php if (isset($edit_data)) {
                                                                                                                    echo $edit_data->branch_name;
                                                                                                                } ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>A/C No.</label>
                            <input class="form-control" type="text" name="account_no" id="account_no" value="<?php if (isset($edit_data)) {
                                                                                                                    echo $edit_data->bank_account_no;
                                                                                                                } ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Routing Number.</label>
                            <input class="form-control" type="text" name="routing_number" id="routing_number" value="<?php if (isset($edit_data)) {
                                                                                                                    echo $edit_data->routing_number;
                                                                                                                } ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Pay Type *</label>
                            <select required name="pay_type_id" id="pay_type_id" class="chosen-select">
                                <option value="">--select pay type--</option>
                                <?php foreach ($pay_types as $val) : ?>
                                    <option value="<?php echo $val->id; ?>" <?php if (isset($edit_data) && ($edit_data->pay_type_id == $val->id)) {
                                                                                echo "selected='selected'";
                                                                            } ?>><?php echo $val->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="comments">Comments</label>
                            <textarea name="comments" id="comments" cols="30" rows="3"><?php if (isset($edit_data)) {
                                                                                            echo $edit_data->comments;
                                                                                        } ?></textarea>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <a type="button" class="btn btn-default close-btn" data-dismiss="modal">Close</a>
            <button type="submit" class="btn btn-sm btn-primary submit-btn" style="width:100px"><?php echo isset($edit_data) ? 'Save Changes' : 'Submit'; ?> </button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {

        $(".chosen-select").chosen();

        var url_prefix = "<?php echo site_url(); ?>";
        $('#content_id').on('change', function() {
            var content_id = $(this).val();
            //alert(grade_id);
            if (content_id) {
                $.ajax({
                    url: url_prefix + "emp-grade-by-content-id",
                    dataType: 'text',
                    type: 'GET',
                    data: {
                        content_id: content_id
                    }
                }).done(function(response) {
                    //console.log(response);
                    $('#grade_id').val(response).trigger("chosen:updated").change();
                });
            }
        });
        $('.grade_id').on('change', function() {
            $('.salary_allowance_head').val(0);
            $('.salary_deduction_head').val(0);
            $('.txt_percentage_label').text('');
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
                            var baseVal = $('#' + value.based_on).val();
                            valueAmt = baseVal * value.percentage / 100;
                        } else {
                            valueAmt = value.amount;
                        }
                        $('#' + value.head_short_name).val(valueAmt);

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
                    totalCal();
                });
            }
        });
        $('.salary_allowance_head').each(function() {
            var headVal = $(this).attr('id');
           
            $('#' + headVal).keyup(function() {
                if(headVal=='basic'){
                    var basic = $(this).val();
                    var grade_id = $('#grade_id').val();

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
                            var baseVal = $('#' + value.based_on).val();
                            valueAmt = baseVal * value.percentage / 100;
                        } else {
                            valueAmt = value.amount;
                        }
                        if(value.head_short_name!='basic'){
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
                    totalCal();
                });
            }
                }
                totalCal();
            });
        });
        $('.salary_deduction_head').each(function() {
            var headVal = $(this).attr('id');
            $('#' + headVal).keyup(function() {
                totalCal();
            });
        });
        // $('#basic').on('keyup', function() {

        // });
        $('.submit-btn').on('click', function() {
            var content_id = $('#content_id').val();
            var grade_id = $('#grade_id').val();
            var pay_type_id = $('#pay_type_id').val();
            var gross_salary = $('#gross_salary').val();
            var net_salary = $('#net_salary').val();
            if (!content_id || !grade_id || !pay_type_id || !gross_salary || !net_salary) {
                alert('Please fill out the all required fields which contains (*) sign.');
                return false;
            }
        });

        function totalCal() {
            var salary_allowance_head_total = 0;
            var salary_deduction_head_total = 0;
            var pf_contribution=0;
            $('.salary_allowance_head').each(function() {
                var headVal = $(this).val();
                salary_allowance_head_total += Number(headVal);
            });

            $('.salary_deduction_head').each(function() {
                var headVal = $(this).val();
                salary_deduction_head_total += Number(headVal);
            });
            
            pf_contribution = $('#pf').val();
            //$('#gross_salary').val(salary_allowance_head_total.toFixed(2));
            var gross_salary = Number(salary_allowance_head_total)+Number(pf_contribution);
            $('#gross_salary').val(Math.round(gross_salary.toFixed(2)));
            
            var net_salary = salary_allowance_head_total - salary_deduction_head_total
            $('#net_salary').val(Math.round(net_salary.toFixed(2)));
        }
    });
</script>