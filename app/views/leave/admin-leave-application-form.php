<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS |  Leave Application Form </title>
        <!--chosen--> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.css">

        <?php
        $this->load->view('includes/cssjs');
        ?> 

        <script>
            $(document).ready(function () {
                $('.chosen-container').css({'width': '350px'});
                $("#content_id").change(function () {
                    var contentId = $(this).val();
                    var leaveFrom = $("#leave_form").val();
                    var currentDate = new Date();
                    var currentYear = currentDate.getFullYear();
//                    alert(leaveFrom);
                    var postdata = {
                        "content_id": contentId,
                        "year": currentYear,
                        "leave_from": leaveFrom
                    }
                   // GET Length Of Services -------------------
                    $.ajax({
                        type: "GET",
                        url: "<?php echo base_url() ?>leavemaster/getEmpLengthOfServices/"+contentId,
                        dataType: "text",
                        success: function (data) {
                            $("#length_of_services").val(data);
                        }
                    });
                    // GET Employee Leave Informations ---------------
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() ?>leavemaster/getEmpLeaveInfo",
                        data: postdata,
                        dataType: "json",
                        success: function (data) { 
//                            alert(data);
                            var totalPaidLeave = data.TotalPaidLeave;
                            var totalAnnualLeaveSpent = data.TotalAnnualLeaveSpent;
                            var TotalAvailedLeave = data.total_availed_leave;
                            if(!TotalAvailedLeave){
                                TotalAvailedLeave =0;
                            }
                                    if(!totalAnnualLeaveSpent){
                                        totalAnnualLeaveSpent =0;
                                    }
                                    if(!totalPaidLeave){
                                        totalPaidLeave =0;
                                    }
                                    $("#total_leave_availed").val(TotalAvailedLeave);
                                    $("#paid_leave").val(totalPaidLeave);
                                    $("#annual_leave_spent").val(totalAnnualLeaveSpent);
                                    var leaveRemaining = (parseInt(data.emp_total_annual_leave) - parseInt(totalAnnualLeaveSpent));
                                    $("#annual_leave_remaining").val(leaveRemaining);
                                    $("#contact_number").val(data.mobile_no);

                        
                          
                        }
                    });
                });



            });
            function ConfirmDelete()
            {
                var x = confirm("Are you sure you want to delete?");
                if (x)
                    return true;
                else
                    return false;
            }
            function validate() {
                var valid = true;
                var msg = "<ul>";
                if (document.myForm.vendor_name.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.myForm.vendor_name.focus();
                        document.myForm.vendor_name.style.border = "solid 1px red";
                        msg += "<li>You need to fill the vendor name field!</li>";
                        valid = false;
                        // return false;
                    }
                }
                if (document.myForm.contact_person.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.myForm.contact_person.focus();
                        document.myForm.contact_person.style.border = "solid 1px red";
                        msg += "<li>You need to fill contact_person field!</li>";
                        valid = false;
                        // return false;
                    }
                }

                if (!valid) {
                    msg += "</ul>";
                    //console.log("Hello Bd");
                    var div = document.getElementById('errors').innerHTML = msg;
                    document.getElementById("errors").style.display = 'block';
                    return false;
                }

            }

        </script>    
        <style>
            .form-group{
                margin-bottom: 3px;
                /*border-bottom:1px solid #CCC;*/
            }
            label{
                text-align: right!important;
                font-weight: bold;
            }
            .tag_name{
                 font-weight: bold;
                text-align: right!important;
            }
            ul.msg {list-style-type: square;}
        </style>
    </head>
    <body class="logged-in dashboard current-page add-division">
        <!-- Page Content -->  
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php
                $this->load->view('includes/menu');
                ?>
      
                <div class="wrapper">
                    <div class="col-md-12">

                        <div id="errors" style='color:red;text-align:right'></div>

                    </div>
                    <div class="row">

                        <div class="col-md-12 col-xs-12 display-list">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3"> 
                                <a href="<?php echo base_url(); ?>admin-leave-application" class="btn btn-sm btn-primary">Manage Employee Leave</a>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 ">   
                                <?php
                                $msg = $this->session->flashdata('msg');
                                
                                if ($msg) {
                                    ?>
                                    <br/>
                                    <div class="alert alert-warning text-left">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong></strong> <?php echo $msg ?>
                                    </div>                                    
                                    <?php
                                    $msg=null;
                                }
                                ?>
                                <form style="padding:0px;border: 2px solid #800000" class="" action="<?php echo base_url(); ?>save-admin-leave-application" method="POST">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                    <input type="hidden" name="leave_edit_id" id="leave_edit_id" value="<?php echo $edit_info->id; ?>" />
                                    <div class="row form-group" style="background-color:#800000;color:#FFF; text-align: center;padding: 10px;">                                        
                                            <h3>LEAVE APPLICATION FORM</h3>                                       
                                    </div>
                                    <div class="row form-group" style="background-color:#808080">                                        
                                            <span class="label pull-right">[<span style="color:red">*</span> Fileds are required.]</span>                                        
                                    </div>
                                    <div class="row form-group" style="background-color:#666666" >
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                                                <label class="label">Employee Name <span style="color:red">*</span>:</label>  
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                                <select name="content_id" id="content_id"  data-placeholder="Choose an Employee..." class="chosen-select form-control" required="" style="width: 100% !important;">
                                                    <option value=""></option>
                                                    <?php
                                                    $edit_content_id = $edit_info->content_id;
                                                    foreach ($allemployee as $single_employee) {
                                                        $content_id = $single_employee['content_id'];
                                                        $emp_id = $single_employee['emp_id'];
                                                        $emp_name = $single_employee['emp_name'];
                                                        if ($edit_content_id == $content_id) {
                                                            echo '<option value="' . $content_id . '" selected="selected">' . $emp_name . '-' . $emp_id . '</option>';
                                                        } else {
                                                            echo '<option value="' . $content_id . '">' . $emp_name . '-' . $emp_id . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                    </div>
                                    <div class="row form-group" style="background-color:#808080">
                                      
                                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                                                <label class="label">Leave Type <span style="color:red">*</span>:</label>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                                <select class="form-control  " name="leave_type" id="leave_type" required="">
                                                    <option value="">--select leave type--</option>
                                                    <?php
                                                    foreach ($allleavetype as $single_leavetype) {
                                                        $id = $single_leavetype['id'];
                                                        $leavetype = $single_leavetype['name'];
                                                        $vid = $single_leavetype['vid'];
                                                        $tid = $single_leavetype['tid'];
                                                        $description = $single_leavetype['description'];
                                                        ?>
                                                        <option value="<?php print $tid; ?>"  <?php
                                                        if ($tid == $edit_info->leave_type) {
                                                            echo "selected='selected'";
                                                        }
                                                        ?>><?php print $leavetype; ?></option>
<?php } ?>
                                                </select>
                                            </div> 
                                    </div>
                                    <div class="row form-group" style="background-color:#666666" >
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
                                                   ?>  class="form-control datepicker"  autocomplete="off"  data-date-format="mm/dd/yyyy" type="text" name="leave_form" id="leave_form" required=""/>
                                        </div>
                                    </div>
                                    <div class="row form-group" style="background-color:#808080">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                                            <label class="label">Leave To <span style="color:red">*</span>:</label>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                            <input value="<?php
                                                   if ($edit_info) {
                                                       echo $edit_info->leave_end_date;
                                                   }
                                                   ?>" <?php
                                                   if ($edit_info) {
                                                       echo "disabled";
                                                   }
                                                   ?>  class="form-control datepicker"  autocomplete="off" type="text" name="leave_to" id="leave_to" required=""/>
                                        </div>
                                    </div>
                                    <div class="row form-group" style="background-color:#666666" >
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                                            <label class="label">Length Of Services <span style="color:red"></span>:</label>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                            <input value="<?php if ($edit_info) { echo $edit_info->length_of_services; } ?>" readonly="" class="form-control" type="text" name="length_of_services" id="length_of_services" />
                                        </div>
                                    </div>
                                    <div class="row form-group" style="background-color:#808080">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                                            <label class="label">Total Leave Availed <span style="color:red"></span>:</label>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                            <input value="<?php if ($edit_info) { echo $edit_info->total_leave_availed; } ?>" readonly="" class="form-control" type="text" name="total_leave_availed" id="total_leave_availed" />
                                        </div>
                                    </div>
                                    <div class="row form-group"  style="background-color:#666666" >
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                                            <label class="label">Total Paid Leave <span style="color:red"></span>:</label>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                            <input value="<?php if ($edit_info) { echo $edit_info->leave_availed; } ?>" readonly="" class="form-control" type="text" name="paid_leave" id="paid_leave" />
                                        </div>
                                    </div>
                                    <div class="row form-group" style="background-color:#808080">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                                            <label class="label">Annual Leave Spent <span style="color:red"></span>:</label>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                            <input value="<?php if ($edit_info) { echo $edit_info->total_annual_leave_spent; } ?>" readonly="" class="form-control" type="text" name="annual_leave_spent" id="annual_leave_spent" />
                                        </div>
                                    </div>
                                    <div class="row form-group" style="background-color:#666666"  >
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                                            <label class="label">Annual Leave Remaining <span style="color:red"></span>:</label>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                            <input value="<?php if ($edit_info) { echo $edit_info->leave_remaining; } ?>" readonly="" class="form-control" type="text" name="annual_leave_remaining" id="annual_leave_remaining" />
                                        </div>
                                    </div>
                                    
                                    <div class="row form-group" style="background-color:#808080">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                                            <label class="label">Purpose Of Leave <span style="color:red">*</span>:</label>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                            <textarea class="form-control" id="purpose" name="purpose" required=""><?php
                                                if ($edit_info) {
                                                    echo $edit_info->justification;
                                                }
                                                ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row form-group"  style="background-color:#666666" >
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                                            <label class="label">Contact Address:</label>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                            <input value="<?php
                                            if ($edit_info) {
                                                echo $edit_info->leave_address;
                                            }
                                            ?>"  class="form-control" type="text" name="contact_address" id="contact_address"/>
                                        </div>
                                    </div>
                                    <!--                            <div class="form-group">
                                                                    <label class="label">Res. Hand Over:</label>
                                                                    <input class="form-control" type="text" name="res_hand_over" id="res_hand_over"/>
                                                                </div>-->
                                    <div class="row form-group"  style="background-color:#808080">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                                            <label class="label">Contact Number <span style="color:red">*</span>:</label>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                            <input value="<?php
                                                if ($edit_info) {
                                                    echo $edit_info->contact_number;
                                                }
                                                ?>" class="form-control" type="text" name="contact_number" id="contact_number" required=""/>
                                        </div>


                                    </div>
                                    <div class="row form-group"  style="background-color:#666666" >
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">
                                            <label for="leave_pay_status" class="label">Pay Status <span style="color:red">*</span>:</label>
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
                                    <div class="row form-group" style="background-color:#808080">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tag_name">

                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
                                            <button class="btn btn-primary pull-right" type="submit" name="save_leave" id="save_leave"/><?php
                                            if ($edit_info) {
                                                echo "Save Changes";
                                            } else {
                                                echo "SUBMIT";
                                            }
                                            ?>  </button>
                                        </div>

                                    </div>
                                   
                                </form>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3"> 
                                <br/>
                               [NOTE: বিশেষ ছুটি(Special Leave), সকরুণ ছুটি(Compassionate Leave) এবং ক্ষতিপূরণ ছুটি(Compensated Leave)  বার্ষিক ছুটি থেকে কেটে নেওয়া হবে না। ]                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->   

        <!--Chosen--> 
        <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/docsupport/init.js" type="text/javascript" charset="utf-8"></script>

    </body>
</html>