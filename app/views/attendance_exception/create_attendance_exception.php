<?php
$this->load->view('includes/employee-header');
?>
<style>
    .exception_form{
        padding: 10px; 
        border:1px dotted #ccc;
        margin: 5px; 
        background-color: #F5F5F5; 
        border-radius:5px
    }
    .label{
        font-weight: bold;
    }
</style>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3"> </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 exception_form" >
                <h3 style="text-align:center; padding: 10px;">Attendance Exception</h3>
                <hr />

                <?php
               
                $msg = $this->session->flashdata('success');
                if ($msg) {
                ?>
                <br />
                <div class="alert alert-success text-center">
                    <strong>Success!</strong> <?php echo $msg ?>
                </div>
                <?php
                }
                $msg = null;
                $this->session->set_flashdata('success',null);
                ?>
                <?php
                $error = $this->session->flashdata('errors');
                if ($error) {
                ?>
                <br />
                <div class="alert alert-danger text-center">
                    <strong>ERROR!</strong> <?php echo $error ?>
                </div>
                <?php
                }
                $error = null;
                $this->session->set_flashdata('errors',null);
                ?>
                <form class="" action="<?php echo base_url('attendance-exception-create');?>" method="POST">
                    <input type="hidden" name="edit_attendance_exception_id" ID="edit_attendance_exception_id" value="<?php if ($edit_info) {
                                                                                                    echo $edit_info->id;
                                                                                                }else{ echo set_value('edit_attendance_exception_id'); } ?>" />
                    
                  <?php
                    $csrf = array(
                            'name' => $this->security->get_csrf_token_name(),
                            'hash' => $this->security->get_csrf_hash()
                    );
                    ?>
<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    <div class="form-group">

                        <span class="label pull-right">[<span style="color:red">*</span> Fileds are required.]</span>
                    </div>
                    <div class="form-group">
                        <label class="label">Attendance Date <span style="color:red">*</span>:</label>
                        <input value="<?php if ($edit_info) {
                                            echo $edit_info->attendance_date;
                                        }else{ echo set_value('attendance_date'); } ?>" class="form-control datepicker" data-date-format="yyyy-mm-dd" type="text"
                            name="attendance_date" id="attendance_date" required />
                    </div>


                    <div class="form-group">
                        <label for="exception_type" class="label">Type Of Application <span
                                style="color:red">*</span>:</label>
                        <select name="exception_type" id="exception_type" class="form-control" required>
                            <option value="">--select one--</option>
                            <option value="late_in" <?php if (($edit_info->exception_type == "late_in") || (set_select('exception_type','late_in'))) {
                                                            echo "selected='selected'";
                                                        } ?>>Late In</option>
                            <option value="early_out" <?php if (($edit_info->exception_type == "early_out") || (set_select('exception_type','early_out'))) {
                                                            echo "selected='selected'";
                                                        } ?>>Early Out</option>
                            <option value="late_in_and_early_out" <?php if (($edit_info->exception_type == "late_in_and_early_out") || (set_select('exception_type','late_in_and_early_out'))) {
                                                            echo "selected='selected'";
                                                        } ?>>Late In & Early Out</option>
                            <option value="working_outside" <?php if (($edit_info->exception_type == "working_outside") || (set_select('exception_type','working_outside'))) {
                                                            echo "selected='selected'";
                                                        } ?>>Working Outside</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="" class="label">Justification/ Reason <span style="color:red">*</span>:</label>
                        <textarea name="reason" id="reason" class="form-control" required><?php if ($edit_info) {
                                                                                                    echo $edit_info->reason;
                                                                                                }else{ echo set_value('reason'); } ?></textarea>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-outline-dark btn-lg pull-right" type="submit" name="save_movement_order"
                            id="save_movement_order" />
                        <?php if ($edit_info) {
                                                                                                                                            echo "Save Changes";
                                                                                                                                        } else {
                                                                                                                                            echo "Submit";
                                                                                                                                        } ?> </button>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3"> </div>
        </div>
    </div>
</div>
<script>
    $('.datepicker').datepicker({ dateFormat: 'yyyy-mm-dd' });
</script>
<?php
$this->load->view('includes/employee-footer');
?>
