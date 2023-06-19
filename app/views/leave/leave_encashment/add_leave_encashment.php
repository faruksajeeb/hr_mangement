<div class="modal-content">

    <div class="modal-header">
        <a type="button" class="close pull-right" data-dismiss="modal">&times;</a>
        <h3 class="modal-title"><?php echo isset($edit_data) ? 'Edit' : 'Add'; ?> Leave Encashment</h3>
        
    </div>
    <br>
    <p style="margin-left: 30px; color:#ccc;">(* mark all the required fields)</p>
    <form action="<?php echo site_url('save-leave-encashment') ?>" method="POST">
        <input type="hidden" name="edit_id" id="edit_id" value="<?php if (isset($edit_data)) {
                                                                    echo $edit_data->id;
                                                                } ?>" />
        <?php if ($error) : ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <div class="modal-body encashment_calculator">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="staff">Select Staff *:</label>
                        <?php if (isset($edit_data)) { ?>
                            <input type="hidden" name="content_id" id="" value="<?php echo $edit_data->content_id; ?>" />
                        <?php } ?>
                        <select name="content_id" id="content_id" <?php if (isset($edit_data)) {
                                                                        echo "disabled";
                                                                    } ?> data-placeholder="Choose a staff..." class="chosen-select" required>
                            <option value="">Choose a staff...</option>
                            <?php foreach ($active_employees as $key => $empVal) : ?>
                                <option value="<?php echo $empVal->content_id; ?>" <?php if (isset($edit_data) && ($edit_data->content_id == $empVal->content_id)) {
                                                                                        echo "selected='selected'";
                                                                                    } ?>><?php echo $empVal->emp_id . ' | ' . $empVal->emp_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Encashment Date *</label>
                        <input class="form-control datepicker" type="text" name="encashment_date" id="encashment_date" required value="<?php if (isset($edit_data)) {
                                                                                                                                        echo $edit_data->encashment_date;
                                                                                                                                    } ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label>Leave Type *</label>
                    <select required name="leave_type_id" id="leave_type_id" required>
                        <option value="">--select leave type--</option>
                        <?php  foreach ($leave_types as $leave_type) : ?>
                            <option value="<?php echo $leave_type->id; ?>" <?php if (isset($edit_data) && ($edit_data->leave_type_id == $leave_type->id)) {
                                                                                echo "selected='selected'";
                                                                            } ?>><?php echo $leave_type->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label>Payment Type *</label>
                    <select required name="payment_type" id="payment_type" required>
                        <option value="">--select payment type--</option>
                        <option value="with_salary" <?php if (isset($edit_data) && ($edit_data->payment_type == 'with_salary')) {
                                                        echo "selected='selected'";
                                                    } ?>>with_salary</option>
                        <option value="individual" <?php if (isset($edit_data) && ($edit_data->payment_type == 'individual')) {
                                                        echo "selected='selected'";
                                                    } ?>>individual</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Encashed Days *</label>
                        <input class="form-control " type="number" name="encashed_days" id="encashed_days" required value="<?php if (isset($edit_data)) {
                                                                                                                                echo $edit_data->encashed_days;
                                                                                                                            }else{echo 1;} ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Per Day Amount *</label>
                        <input class="form-control " type="number" name="per_day_amount" id="per_day_amount" required value="<?php if (isset($edit_data)) {
                                                                                                                                echo $edit_data->per_day_amount;
                                                                                                                            } ?>">
                    </div>
                </div>
            </div>
          
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Encashment Amount *</label>
                        <input class="form-control " type="number" readonly name="encashment_amount" id="encashment_amount" required value="<?php if (isset($edit_data)) {
                                                                                                                echo $edit_data->encashment_amount;
                                                                                                            } ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Remarks</label>
                        <textarea name="remarks" id="remarks" cols="30" rows="3"><?php if (isset($edit_data)) {
                                                                                        echo $edit_data->remarks;
                                                                                    } ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <a type="button" class="btn btn-default btn-danger close-btn" data-dismiss="modal">Close</a>
            <button type="submit" class="btn btn-sm btn-primary submit-btn" style="width:100px"><?php echo isset($edit_data) ? 'Save Changes' : 'Submit'; ?> </button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            viewMode: 'days',
            format: 'd-m-Y',
            showTodayButton: true,
            dateFormat: 'yy-mm-dd',
            maxDate: 0
        });
        $(".chosen-select").chosen();

        var url_prefix = "<?php echo site_url(); ?>";

        $('.encashment_calculator').delegate('#encashed_days,#per_day_amount','keyup',function(){
            var encashed_days = $('#encashed_days').val();
            var per_day_amount = $('#per_day_amount').val();
            $('#encashment_amount').val(encashed_days*per_day_amount);
        });


        $('.submit-btn').on('click', function() {
            var content_id = $('#content_id').val();
            var payment_type = $('#payment_type').val();
            var encashment_date = $('#encashment_date').val();
            var encashment_amount = $('#encashment_amount').val();
            if (!content_id || !payment_type || !encashment_date || !encashment_amount) {
                window.alert('Please fill out the all required fields which contains (*) sign.');
                return false;
            }
        });
    });
</script>