<div class="modal-content">

    <div class="modal-header">
        <a type="button" class="close pull-right" data-dismiss="modal">&times;</a>
        <h3 class="modal-title"><?php echo isset($edit_data) ? 'Edit' : 'Add'; ?> Special Bonus</h3>
    </div>
    <form action="<?php echo site_url('save-special-bonus') ?>" method="POST">
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
                <div class="col-md-12">
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
            </div>
            <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                            <label>Payment Date</label>
                            <input class="form-control datepicker" type="text" name="payment_date" id="payment_date" value="<?php if (isset($edit_data)) {
                                                                                                                    echo $edit_data->payment_date;
                                                                                                                }else{ echo date("Y-m-d");} ?>">
                        </div>
                </div>
            </div>
            <div class="row">
                    <div class="form-group col-md-12">
                        <label>Payment Type *</label>
                        <select required name="payment_type" id="payment_type" class="chosen-select">
                            <option value="">--select payment type--</option>
                            <option value="with_salary" <?php if (isset($edit_data) && ($edit_data->payment_type == 'with_salary')) { echo "selected='selected'";  }else{ echo 'selected';} ?>>with_salary</option>
                            <option value="individual" <?php if (isset($edit_data) && ($edit_data->payment_type == 'individual')) { echo "selected='selected'";  } ?>>individual</option>
                        </select>
                    </div>
            </div>
            <div class="row">
                    <div class="form-group col-md-12">
                        <label>Adjust Year *</label>
                        <select required name="adjust_year" id="adjust_year" class="chosen-select">
                            <option value="">--select year--</option>
                            <?php foreach ($years as $val) : ?>
                                <option value="<?php echo $val->year; ?>" <?php if($val->year<date('Y')){echo 'disabled'; } ?> <?php if (isset($edit_data) && ($edit_data->adjust_year == $val->year)) {
                                                                            echo "selected='selected'";
                                                                        }else{ if(date('Y')==$val->year){ echo 'selected'; }} ?>><?php echo $val->year; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
            </div>
            <div class="row">
                    <div class="form-group col-md-12">
                        <label>Adjust Month *</label>
                        <select required name="adjust_month" id="adjust_month" class="chosen-select">
                            <option value="">--select month--</option>
                            <?php foreach ($months as $val) : ?>
                                <option value="<?php echo $val->id; ?>" <?php if (isset($edit_data) && ($edit_data->adjust_month == $val->id)) {
                                                                            echo "selected='selected'";
                                                                        } ?>><?php echo $val->month_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                            <label>Bonus Amount</label>
                            <input class="form-control " type="text" name="amount" id="amount" value="<?php if (isset($edit_data)) {
                                                                                                                    echo $edit_data->amount;
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
            showTodayButton:true,
            dateFormat: 'yy-mm-dd'
        });
        $(".chosen-select").chosen();

        var url_prefix = "<?php echo site_url(); ?>";
       
  
        $('.submit-btn').on('click', function() {
            var content_id = $('#content_id').val();
            var payment_type = $('#payment_type').val();
            var payment_date = $('#payment_date').val();
            var amount = $('#amount').val();
            var adjust_month = $('#adjust_month').val();
            var adjust_year = $('#adjust_year').val();
            if (!content_id || !payment_type || !payment_date || !amount || !adjust_month || !adjust_year ) {
                alert('Please fill out the all required fields which contains (*) sign.');
                return false;
            }
        });
    });
</script>