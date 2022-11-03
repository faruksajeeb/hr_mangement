<div class="modal-content">
    <div class="modal-header">
        <a type="button" class="close pull-right" data-dismiss="modal">&times;</a>
        <h4 class="modal-title">View Staff Salary</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="staff">Staff Name *:</label>
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
                            <select disabled name="grade_id" id="grade_id" data-placeholder="Choose a staff..." class="chosen-select grade_id">
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
                    <div class="col-sm-6">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border" style="color:orangered;">Earnings</legend>

                            <!-- <h4 style="color:orangered;font-weight:bold;margin-bottom:10px">Earnings</h4> -->
                            <?php foreach ($salary_earning_heads as $earnHead) : ?>
                                <div class="form-group">
                                    <label><?php echo $earnHead->head_name; ?></label> <span class="txt_percentage_label txt_<?php echo $earnHead->short_name; ?>"></span>
                                    <input readonly class="form-control salary_allowance_head" value="<?php if(isset($view_data->{$earnHead->short_name})){ 
                                            echo $view_data->{$earnHead->short_name};                                        
                                        }else{echo set_value($earnHead->short_name);} ?>" type="text" name="<?php echo $earnHead->short_name; ?>" id="<?php echo $earnHead->short_name; ?>">
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
                                    <input readonly class="form-control salary_deduction_head" type="text" value="<?php if(isset($view_data->{$deductHead->short_name})){ 
                                            echo $view_data->{$deductHead->short_name };                                        
                                        }else{ echo set_value($deductHead->short_name);} ?>"  name="<?php echo $deductHead->short_name; ?>" id="<?php echo $deductHead->short_name; ?>">
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
                                <input readonly name="gross_salary" id="gross_salary" class="form-control" type="text" value="<?php if(isset($view_data->gross_salary)){ echo $view_data->gross_salary;}?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Net Salary *</label>
                                <input readonly name="net_salary" id="net_salary" class="form-control" type="text" value="<?php if(isset($view_data->net_salary)){ echo $view_data->net_salary;}?>">
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
                                <select disabled name="bank_id" id="bank_id" class="chosen-select">
                                    <option value="">--select bank--</option>
                                    <?php foreach ($banks as $val) : ?>
                                        <option value="<?php echo $val->id; ?>" <?php if (isset($view_data) && ($view_data->bank_id == $val->id)) {
                                                                                    echo "selected='selected'";
                                                                                } ?>><?php echo $val->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Branch Name</label>
                                <input readonly class="form-control" type="text" name="branch_name" id="branch_name" value="<?php if (isset($view_data)) {
                                                                                                                        echo $view_data->branch_name;
                                                                                                                    } ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label>A/C No.</label>
                                <input readonly class="form-control" type="text" name="account_no" id="account_no" value="<?php if (isset($view_data)) {
                                                                                                                        echo $view_data->bank_account_no;
                                                                                                                    } ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Pay Type *</label>
                                <select disabled required name="pay_type_id" id="pay_type_id" class="chosen-select">
                                    <option value="">--select pay type--</option>
                                    <?php foreach ($pay_types as $val) : ?>
                                        <option value="<?php echo $val->id; ?>" <?php if (isset($view_data) && ($view_data->pay_type_id == $val->id)) {
                                                                                    echo "selected='selected'";
                                                                                } ?>><?php echo $val->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="comments">Comments</label>
                                <textarea readonly name="comments" id="comments" cols="30" rows="3"><?php if (isset($view_data)) {
                                                                                                echo $view_data->comments;
                                                                                            } ?></textarea>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <h4>Salary History</h4>
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
                        <?php foreach($salary_history as $key => $val):?>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td><?php echo $val->grade_name; ?></td>
                            <td><?php echo $val->effective_date; ?></td>
                            <td><?php echo $val->increment_amt; ?></td>
                            <!-- <td><?php //echo $val->?></td> -->
                            <td><?php echo $val->gross_salary; ?></td>
                            <td><?php echo $val->net_salary; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <a type="button" class="btn btn-default close-btn" data-dismiss="modal">Close</a>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".chosen-select").chosen();
    });
</script>