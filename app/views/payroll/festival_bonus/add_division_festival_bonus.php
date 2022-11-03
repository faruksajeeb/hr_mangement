<div class="modal-content">

    <div class="modal-header">
        <a type="button" class="close pull-right" data-dismiss="modal">&times;</a>
        <h3 class="modal-title"> Generate Festival Bonus</h3>
    </div>
    <form action="<?php echo site_url('save-division-festival-bonus') ?>" method="POST">
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
                    <div class="input-group input-group-lg " style="margin-top:5px">
                        <span class="input-group-addon" id="sizing-addon1">Company * </span>
                        <select name="company_id" id="company_id" class="form-control">
                            <option value="">--select company--</option>
                            <option value="11|IIDFC Securities Limited">IIDFC Securities Limited</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group input-group-lg " style="margin-top:5px">
                        <span class="input-group-addon " id="sizing-addon1">Division/ Branch * </span>
                        <select name="division_id" id="division_id" class="form-control">
                            <option value="">--select company first--</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">Provision(%) </div>
                <div class="col-md-8"><input type="number" name="provision_percentage" id="provision_percentage" class="form-control" /></div>
            </div>
            <div class="row">
                <div class="col-md-4">Permenent(%) </div>
                <div class="col-md-8"><input type="number" name="permenent_percentage" id="permenent_percentage" class="form-control" /></div>
            </div>
            <div class="row">
                <div class="col-md-4"> <label>Contactual(%) </label></div>
                <div class="col-md-8"><input type="number" name="contactual_percentage" id="contactual_percentage" class="form-control" /></div>
            </div>
            <div class="row">
                <div class="col-md-4"> <label>Payment Date</label></div>
                <div class="col-md-8"><input class="form-control datepicker" type="text" name="payment_date" id="div_payment_date" value="<?php if (isset($edit_data)) {
                                                                                                                                            echo $edit_data->payment_date;
                                                                                                                                        } else {
                                                                                                                                            echo date("Y-m-d");
                                                                                                                                        } ?>"></div>
            </div>
            <div class="row">
                <div class="col-md-4"> <label>Payment Type *</label></div>
                <div class="col-md-8">
                    <select required name="payment_type" id="div_payment_type" class="">
                        <option value="">--select payment type--</option>
                        <option value="with_salary" <?php if (isset($edit_data) && ($edit_data->payment_type == 'with_salary')) {
                                                        echo "selected='selected'";
                                                    } else {
                                                        echo 'selected';
                                                    } ?>>with_salary</option>
                        <option value="individual" <?php if (isset($edit_data) && ($edit_data->payment_type == 'individual')) {
                                                        echo "selected='selected'";
                                                    } ?>>individual</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>Adjust Year *</label>
                </div>
                <div class="col-md-8">
                    <select required name="adjust_year" id="div_adjust_year" class="chosen-select">
                        <option value="">--select year--</option>
                        <?php foreach ($years as $val) : ?>
                            <option value="<?php echo $val->year; ?>" <?php if ($val->year < date('Y')) {
                                                                            echo 'disabled';
                                                                        } ?> <?php if (isset($edit_data) && ($edit_data->adjust_year == $val->year)) {
                                                                                    echo "selected='selected'";
                                                                                } else {
                                                                                    if (date('Y') == $val->year) {
                                                                                        echo 'selected';
                                                                                    }
                                                                                } ?>><?php echo $val->year; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                <label>Adjust Month *</label>
                </div>
                <div class="col-md-8">
                <select required name="adjust_month" id="div_adjust_month" class="chosen-select">
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
                        <label>Remarks</label>
                        <textarea name="remarks" id="div_remarks" cols="30" rows="3"><?php if (isset($edit_data)) {
                                                                                        echo $edit_data->remarks;
                                                                                    } ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a type="button" class="btn btn-default btn-danger close-btn" data-dismiss="modal">Close</a>
            <button type="submit" class="btn btn-sm btn-primary submit-btn" id="div-submit-btn" style="width:100px"><?php echo isset($edit_data) ? 'Save Changes' : 'Submit'; ?> </button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {

        $('.datepicker').datepicker({
            viewMode: 'days',
            format: 'd-m-Y',
            showTodayButton: true,
            dateFormat: 'yy-mm-dd'
        });
        $(".chosen-select").chosen();

        var url_prefix = "<?php echo site_url(); ?>";
        var company_id = '11|IIDFC Securities Limited'; // IIDFC Company ID
        $("select#company_id").val(company_id).trigger('change');
        dependableBranch(company_id);

        $("#company_id").change(function(e) {
            var company_id = $(this).val();
            dependableBranch(company_id);
        });

        function dependableBranch(company_id) {
            $.ajax({
                url: url_prefix + "get_company_wise_branch",
                dataType: 'html',
                type: 'GET',
                data: {
                    company_id: company_id
                }
            }).done(function(data) {
                $("#division_id").html(data);
            });
        }

        $('#div-submit-btn').on('click', function() {
            var payment_type = $('#div_payment_type').val();
            var payment_date = $('#div_payment_date').val();
            var adjust_month = $('#div_adjust_month').val();
            var adjust_year = $('#div_adjust_year').val();
            var provision_percentage = $('#provision_percentage').val();
            var permenent_percentage = $('#permenent_percentage').val();
            var contactual_percentage = $('#contactual_percentage').val();
            if (!permenent_percentage || !provision_percentage  || !contactual_percentage || !payment_type || !payment_date || !adjust_month || !adjust_year) {
                alert('Please fill out the all required fields which contains (*) sign.');
                return false;
            }
        });
    });
</script>