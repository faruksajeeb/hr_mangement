<?php
$this->load->view('includes/employee-header');
?> 
<style>
    .form-group{
        margin-bottom: 5px;
        border-bottom:1px solid #FFF;
    }
</style>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">  
            <br/>
              [NOTE: বিশেষ ছুটি(Special Leave), সকরুণ ছুটি(Compassionate Leave) এবং ক্ষতিপূরণ ছুটি(Compensated Leave)  বার্ষিক ছুটি থেকে কেটে নেওয়া হবে না। ]
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6" style="padding: 10px; border:1px dotted #ccc;margin: 5px; background: #90EE90">   
                <h3 style="text-align:center; padding: 10px; font-weight: bold; color:#4C4C4C">EMPLOYEE LEAVE APPLICATION</h3>
                <hr/>
                <form class="" action="<?php echo base_url(); ?>leavemaster/saveEmployeeLeaveApplication" method="POST">
                    <input type="hidden" name="leave_edit_id" id="leave_edit_id" value="<?php echo $edit_info->id; ?>" />
                    <?php
                    $error = $this->session->flashdata('errors');
                    if ($error) {
                        ?>
                        <br/>
                        <div class="alert alert-danger text-center">
                            <strong>Error!</strong> <?php echo $error ?>
                        </div>                                    
                        <?php
                        $error = null;
                    }
                    ?>
                    <div class="row form-group" >
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                            <span class="label pull-right">[<span style="color:red">*</span> Fileds are required.]</span>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                            <label class="label">Leave Type<span style="color:red">*</span>:</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                            <select class="form-control" name="leave_type" id="leave_type" required="">
                                <option value="">--select leave type--</option>
                                <?php
                                foreach ($allleavetype as $single_leavetype) {
                                    $id = $single_leavetype['id'];
                                    $leavetype = $single_leavetype['name'];
                                    $vid = $single_leavetype['vid'];
                                    $tid = $single_leavetype['tid'];
                                    $description = $single_leavetype['description'];
                                    ?>
                                    <option value="<?php print $tid; ?>" <?php
                                    if ($tid == $edit_info->leave_type) {
                                        echo "selected='selected'";
                                    }
                                    ?>><?php print $leavetype; ?></option>
<?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group" style="">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                            <label class="label">Leave From <span style="color:red">*</span>:</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                            <input value="<?php
                                   if ($edit_info) {
                                       echo $edit_info->leave_start_date;
                                   }
                                   ?>" <?php
                                   if ($edit_info) {
                                       echo "disabled";
                                   }
                                   ?> class="form-control datepicker"  data-date-format="mm/dd/yyyy" type="text" name="leave_form" id="leave_form" required=""/>
                        </div>
                    </div>
                    <div class="row form-group" style="">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                            <label class="label">Leave To <span style="color:red">*</span>:</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                            <input value="<?php
                                   if ($edit_info) {
                                       echo $edit_info->leave_end_date;
                                   }
                                   ?>"  <?php
                                   if ($edit_info) {
                                       echo "disabled";
                                   }
                                   ?>  class="form-control datepicker" type="text" name="leave_to" id="leave_to" required=""/>
                        </div>
                    </div>
                        <div class="row form-group" style="">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                            <label class="label">Length Of Services <span style="color:red"></span>:</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                            <input value="<?php
                            if ($edit_info) {
                                echo $edit_info->length_of_services;
                            } else {
                                echo $length_of_services;
                            }
                                   ?>" readonly="" class="form-control" type="text" name="length_of_services" id="length_of_services" />
                        </div>
                    </div>
                        <div class="row form-group" style="">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                            <label class="label">Total Leave Availed  <span style="color:red"></span>:</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                            <input value="<?php
                            if ($edit_info) {
                                echo $edit_info->leave_availed;
                            } else {
                                if($emp_leave_info->total_availed_leave){
                                echo $emp_leave_info->total_availed_leave;
                                }else {
                                echo 0;
                                }
                            }
                                   ?>" readonly="" class="form-control" type="text" name="total_leave_availed" id="total_leave_availed" />
                        </div>
                    </div>
                    <div class="row form-group" style="">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                            <label class="label">Leave Availed (Paid)  <span style="color:red"></span>:</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                            <input value="<?php
                            if ($edit_info) {
                                echo $edit_info->leave_availed;
                            } else {
                                if($emp_leave_info->TotalPaidLeave){
                                echo $emp_leave_info->TotalPaidLeave;
                                } else {
                                echo 0;
                                }
                            }
                                   ?>" readonly="" class="form-control" type="text" name="paid_leave" id="paid_leave" />
                        </div>
                    </div>
                        <div class="row form-group" style="">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                            <label class="label">Total Leave Spent <span style="color:red"></span>:</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                            <input value="<?php
                            if ($edit_info) {
                                echo $edit_info->leave_availed;
                            } else {
                                if($emp_leave_info->TotalAnnualLeaveSpent){
                                echo $emp_leave_info->TotalAnnualLeaveSpent;
                                }else {
                                echo 0;
                                }
                            }
                                   ?>" readonly="" class="form-control" type="text" name="annual_leave_spent" id="annual_leave_spent" />
                        </div>
                    </div>
                        <div class="row form-group" style="">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                            <label class="label">Leave Remaining  <span style="color:red"></span>:</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                            <input value="<?php
                            if ($edit_info) {
                                echo $edit_info->leave_availed;
                            } else {
                                if($emp_leave_info->emp_total_annual_leave){
                                echo $emp_leave_info->emp_total_annual_leave - $emp_leave_info->TotalAnnualLeaveSpent;
                                }else {
                                echo 0;
                                }
                            }
                                   ?>" readonly="" class="form-control" type="text" name="annual_leave_remaining" id="annual_leave_remaining" />
                        </div>
                    </div>
                    <div class="row form-group" style="">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                            <label class="label">Purpose Of Leave  <span style="color:red"></span>:</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                            <textarea class="form-control" id="purpose" name="purpose" required=""><?php
                            if ($edit_info) {
                                echo $edit_info->justification;
                            }
                                   ?> </textarea>
                        </div>
                    </div>
                    <div class="row form-group" style="">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                            <label class="label">Contact Address <span style="color:red"></span>:</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                            <input value="<?php
                            if ($edit_info) {
                                echo $edit_info->leave_address;
                            }
                                   ?>"  class="form-control" type="text" name="contact_address" id="contact_address"/>
                        </div>
                    </div>
                    <div class="row form-group" style="">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                            <label class="label">Contact Number <span style="color:red">*</span>:</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                            <input value="<?php
                            if ($edit_info) {
                                echo $edit_info->contact_number;
                            }else{
                                echo $emp_leave_info->mobile_no;
                            }
                                   ?>" class="form-control" type="text" name="contact_number" id="contact_number" required=""/>
                        </div>
                    </div>
                    <div class="row form-group" style="">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                            <label class="label">Pay Status <span style="color:red">*</span>:</label>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                            <select name="leave_pay_status" id="leave_pay_status" class="form-control">
                                <option value="payable" <?php
                            if ("payable" == $edit_info->pay_status) {
                                echo "selected='selected'";
                            }
                                   ?>>Payable</option>
                                <option value="not_payable" <?php
                            if ("not_payable" == $edit_info->pay_status) {
                                echo "selected='selected'";
                            }
                                   ?>>Not Payable</option>
                            </select>  
                        </div>
                    </div>
                    <div class="row form-group" style="">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                            <button class="btn btn-primary pull-right" type="submit" name="save_leave" id="save_leave"/><?php
                            if ($edit_info) {
                                echo "Save Changes";
                            } else {
                                echo "Submit";
                            }
                                   ?> </button> 
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            
            </div>
        </div>
    </div>
</div>

<?php
$this->load->view('includes/employee-footer');
?>