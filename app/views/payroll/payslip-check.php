<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS- Payslip Check</title>
    <!--chosen-->
    <?php
    $this->load->view('includes/cssjs');
    $userId = $this->session->userdata('user_id');

    $userDivision = $this->session->userdata('user_division');
    $userDepartment = $this->session->userdata('user_department');
    ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.form.min.js"></script>

    <script>
        $(document).ready(function() {

            $('.checked_multiple').css("visibility", "hidden");
            $("#loader").hide();
            var dialog, form;
            dialog = $("#payment-detail").dialog({
                autoOpen: false,
                height: "auto",
                width: "600",
                modal: false,
                dialogClass: 'dialogWithDropShadow',
                position: {
                    my: "center",
                    at: "center",
                },
                Cancel: function() {
                    dialog.dialog("close");
                },
            });
            var payslipDialog = $("#payslip-detail").dialog({
                autoOpen: false,
                height: "auto",
                width: "600",
                modal: false,
                dialogClass: 'dialogWithDropShadow',
                position: {
                    my: "center",
                    at: "center",
                },
                Cancel: function() {
                    payslipDialog.dialog("close");
                },
            });
            $('.payslip_detail').click(function() {
                //	alert(0);
                var payslip_id = $(this).attr('id');
                //                     alert(payslip_id);
                // dialog.dialog( "open" );
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>payroll/getPayslipDetailByPaySlipId",
                    data: {
                        payslip_id: payslip_id
                    },
                    dataType: "html",
                    cache: false,
                    success: function(data) {
                        // alert(data);
                        $("#payslip-detail").html(data);
                        payslipDialog.dialog("open");

                    },
                    error: function() {
                        alert('ERROR!');
                    }
                });
            });

            var company_id = '11'; // IIDFC Company ID
            $("select#emp_company").val(company_id).trigger('change');
            dependableBranch(company_id);

            $("#emp_company").change(function(e) {
                $("input[type=submit]").removeAttr("disabled");
                var company_id = $(this).val();
                dependableBranch(company_id);
            });

            function dependableBranch(company_id) {
                if (company_id) {
                    var base_url = '<?php echo base_url(); ?>';
                    $.ajax({
                        type: "POST",
                        url: "" + base_url + "addprofile/getdepartmentidbydivisionid",
                        data: {
                            "division_tid": company_id
                        },
                        dataType: 'json',
                        success: function(data) {
                            // console.log(data);
                            var options = "";
                            options += '<option value="">All</option>';
                            $(data).each(function(index, item) {
                                options += '<option value="' + item.tid + '">' + item.name + '</option>';
                            });
                            $('#emp_division').html(options);
                        }
                    });
                }
            }
            setTimeout(function() {
                // $("#errors").hide("slide", {direction: "up" }, "slow"); 
                $(".alert").hide("slide", {
                    direction: "up"
                }, "slow");

            }, 9000);


            // Multiple select ------

            $('.check-all').click(function() {
                var checked_status = this.checked;

                $(this).closest('table').find('input:checkbox').each(function() {
                    if (checked_status) {
                        this.checked = true;

                        $('.checked_multiple').css("visibility", "visible");
                        $('.cancel_checked_multiple').css("visibility", "visible");
                        $('.delete_multiple').css("visibility", "visible");
                        $(".checked").css('background-color', "#98FB98 !important");
                    } else {
                        this.checked = false;
                        $(".checked").css('background-color', "#FFF !important");
                        $('.checked_multiple').css("visibility", "hidden");
                        $('.cancel_checked_multiple').css("visibility", "hidden");
                        $('.delete_multiple').css("visibility", "hidden");
                    }
                });
            });
            $('.check-single').click(function() {
                var pid = $(this).val();
                if ($(this).is(':checked')) {
                    $(".checked-" + pid).css('background-color', "#98FB98 !important");
                } else {
                    $(".checked-" + pid).css('background-color', "#FFF !important");
                }
                if ($(".check-single:checked").length >= 1 && $('.check-single').is(":checked") == true) {
                    //$('#del_all').show();                         

                    $('.cancel_checked_multiple').css("visibility", "visible");
                    $('.checked_multiple').css("visibility", "visible");
                    $('.delete_multiple').css("visibility", "visible");

                } else {
                    //$('#del_all').hide(); 

                    $('.checked_multiple').css("visibility", "hidden");
                    $('.cancel_checked_multiple').css("visibility", "hidden");
                    $('.delete_multiple').css("visibility", "hidden");

                }

            });
            // Chacked multiple -----------------------
            $(".checked_multiple").on('click', function(e) {
                e.preventDefault(); //The preventDefault() method will prevent the link above from following the URL.
                var checkValues = $('.check-single:checked').map(function() {
                    return $(this).val();
                }).get();
                console.log(checkValues);
                $.each(checkValues, function(i, val) {
                    //$("#" + val).remove();
                });
                //                    return  false;

                if (checkValues.length === 0) //tell you if the array is empty
                {
                    alert("Please Select atleast one payslip");
                } else {
                    $("#dialog-checked").dialog({
                        resizable: false,
                        height: "auto",
                        width: 400,
                        modal: true,
                        buttons: {
                            "Yes": function() {
                                $(this).dialog("close");
                                //alert('thanks');
                                $.ajax({
                                    url: '<?php echo base_url(); ?>payroll/checkedMultiplePayslip',
                                    type: 'post',
                                    data: 'payslip_id=' + checkValues
                                }).done(function(data) {
                                    alert(data);
                                    // $("#content_display").html(data);
                                    $('.check-all').attr('checked', false);
                                    location.reload(true);
                                    //  alert(tbl_name + ' was successfully Deleted!');                                   

                                });
                            },
                            No: function() {
                                $(this).dialog("close");
                            }
                        }
                    });
                }

            });
            // Chacked multiple -----------------------
            $(".cancel_checked_multiple").on('click', function(e) {
                e.preventDefault(); //The preventDefault() method will prevent the link above from following the URL.
                var checkValues = $('.check-single:checked').map(function() {
                    return $(this).val();
                }).get();
                console.log(checkValues);
                $.each(checkValues, function(i, val) {
                    //$("#" + val).remove();
                });
                //                    return  false;

                if (checkValues.length === 0) //tell you if the array is empty
                {
                    alert("Please Select atleast one payslip");
                } else {
                    $("#dialog-cancel-checked").dialog({
                        resizable: false,
                        height: "auto",
                        width: 400,
                        modal: true,
                        buttons: {
                            "Yes": function() {
                                $(this).dialog("close");
                                //alert('thanks');
                                $.ajax({
                                    url: '<?php echo base_url(); ?>payroll/cancelCheckedMultiplePayslip',
                                    type: 'post',
                                    data: 'payslip_id=' + checkValues
                                }).done(function(data) {
                                    alert(data);
                                    // $("#content_display").html(data);
                                    $('.check-all').attr('checked', false);
                                    location.reload(true);
                                    //  alert(tbl_name + ' was successfully Deleted!');                                   

                                });
                            },
                            No: function() {
                                $(this).dialog("close");
                            }
                        }
                    });
                }

            });

        });

        function validate() {
            var valid = true;

            var msg = "<ul>";
            if (document.payslipForm.emp_company.value == "") {
                if (valid) { //only receive focus if its the first error
                    document.payslipForm.emp_company.focus();
                    document.payslipForm.emp_company.style.border = "solid 1px red";
                    //document.myForm.loan_type_name.style.backgroundColor="#FFA07A";
                    msg += '<li >You need to select the company field! <span class="glyphicon glyphicon-remove-circle"></li>';
                    valid = false;
                    // return false;
                }
            }
            if (document.payslipForm.salary_month.value == "") {
                if (valid) {
                    document.payslipForm.salary_month.focus();
                }
                document.payslipForm.salary_month.style.border = "solid 1px red";
                msg += '<li >You need to select salary month field! <span class="glyphicon glyphicon-remove-circle"></li>';
                valid = false;
            }

            if (!valid) {
                //alert(0);
                msg += "</ul>";
                //console.log("Hello Bd");

                var div = document.getElementById('errors').innerHTML = msg;
                document.getElementById("errors").style.display = 'block';
                //Hide();
                return false;
            } else {
                $("#loader").show("fade", "slow");
            }

        }

        function confirmDelete() {
            var x = confirm("Are you sure you want to delete this pay slip?");
            if (x)
                return true;
            else
                return false;
        }
    </script>
    <style>
        body {
            background-color: #FFF;
        }

        .add-form {
            min-height: 200px;
        }

        select {
            margin: 0;
        }

        .col-md-4 {
            /* text-align: right; */
        }

        a:hover {
            cursor: pointer;
        }

        .dialogWithDropShadow {
            -webkit-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            -moz-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);

        }

        .ui-dialog {
              /* background-color: #ffcc99; */
        }

        table {
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
            padding: 2px;
        }

        tr:nth-child(even) {
            /* background: #FFF !important; */
        }

        tr:nth-child(odd) {
            /* background: #FFF !important; */
        }

        tr:hover {
            background: #98FB98 !important;
        }

        .table_earning,
        .table_deduction {
            border: none !important;
        }

        .table_earning td,
        .table_deduction td {
            font-style: italic;

            border-bottom: 1px dotted #FFF;
        }

        .table_deduction td {
            background: #FA8072 !important;
        }

        .table_earning td {
            background: #32CD32 !important;
        }

        .accor_label {
            text-align: left;
        }

        .accor_value {
            text-align: right;
        }

        .panel,
        .panel-body {
            box-shadow: none;
        }

        .panel-group .panel-heading {
            padding: 0;
        }

        .panel-group .panel-heading a {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            position: relative;
        }
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

                <br />
                <div class="row">
                    <div class="col-md-3 col-xs-12 "></div>
                    <div class="col-md-6 col-xs-12 add-form">
                        <div class="row add-form-heading">
                            <div class="col-md-12 ">

                                <i class="fas fa-money-check-alt " style="font-size:20px"></i> Check Payslip
                            </div>
                        </div>
                        <form action="" onsubmit=" return validate();" method="POST" class="payslipForm" id="payslipForm" name="payslipForm" enctype="multipart/form-data">
                            <div class="row success-err-sms-area">
                                <div class="col-md-12">

                                    <div id="errors" style='color:red;text-align:right'></div>

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
                                    ?>
                                    <?php
                                    $error = $this->session->flashdata('error');
                                    if ($error) {
                                    ?>
                                        <br />
                                        <div class="alert alert-danger text-center">
                                            <strong>ERROR!</strong> <?php echo $error ?>
                                        </div>
                                    <?php
                                    }
                                    $error = null;
                                    ?>
                                </div>
                            </div>
                            <div class="row">

                                <div class="row">

                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-4">Financial Year:</div>
                                                    <div class="col-md-8">
                                                        <?php
                                                        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
                                                        $current_date = $dt->format('d-m-Y');
                                                        $current_year = $dt->format('Y');
                                                        ?>
                                                        <select name="year" id="year" class=" form-control">
                                                            <?php foreach ($years as $val) : ?>
                                                                <option value="<?php echo $val->year; ?>" <?php echo $val->year == date('Y') ? 'selected' : ''; ?>><?php echo $val->year; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--                                            <div class="row">                                    
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-4">Account:</div>
                                                    <div class="col-md-8">
                                                        <select name="account_id" id="account_id">
                                                            <option value="1">COCL</option>
                                                            <option value="cheque">Cheque</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-4">Company: </div>
                                                    <div class="col-md-8">
                                                        <select name="emp_company" id="emp_company" class="form-control">

                                                            <?php

                                                            if ($user_type == 1 || ($all_company_access['status'] == 1)) {
                                                                echo '<option value="">--select company--</option>';
                                                                foreach ($alldivision as $single_division) {

                                                                    echo '<option value="' . $single_division['tid'] . '" >' . $single_division['name'] . '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="' . $alldivision['tid'] . '" selected="selected" data-id="' . $alldivision['weight'] . '">' . $alldivision['name'] . '</option>';
                                                            }


                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-4">Division:</div>
                                                    <div class="col-md-8">
                                                        <select name="emp_division" id="emp_division" class="form-control">
                                                            <?php
                                                            if ($userId == 16 || !$userDepartment) {
                                                                echo '<option value="">All</option>';
                                                                foreach ($department_selected as $single_department) {
                                                                    if ($userDepartment == $single_department['tid']) {
                                                                        echo '<option value="' . $single_department['tid'] . '" selected="selected">' . $single_department['name'] . '</option>';
                                                                    } else {
                                                                        echo '<option value="' . $single_department['tid'] . '">' . $single_department['name'] . '</option>';
                                                                    }
                                                                }
                                                            } else {
                                                                echo '<option value="' . $department_selected['tid'] . '" selected="selected">' . $department_selected['name'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-4">Salary month:</div>
                                                    <div class="col-md-8">
                                                        <select name="salary_month" id="salary_month" class="form-control">
                                                            <option value=""> --select employee salary month-- </option>
                                                            <?php foreach ($months as $month) { ?>
                                                                <option value="<?php echo $month->month_id . '-' . $month->month_name; ?>"><?php echo $month->month_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr />
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <div class="row">
                                        <div class="col-md-12"><a href="pay-slip-approval" class="btn btn-sm btn-info">Payslip Approve >></a></div>
                     
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-8">
                                                <input type="submit" name="add_btn" id="add_btn" style="width:100%;" value="SUBMIT" />
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </form>

                    </div>

                    <div class="col-md-3 col-xs-12 ">

                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="loader" style="text-align:center; display:none;">
                            <div style="padding: 5px;">Please be patient, Pay slip is being generated.</div>
                            <img src="<?php echo base_url() ?>resources/images/prosseging.gif" style="width: 100px;" alt="Processing..." />
                            <!-- Start Report -->
                        </div>
                        <?php
                        $slNo = 1;
                        if ($paySlips) {
                        ?>
                            <a href="#" style="visibility: hidden; margin-right: 5px;" class='btn btn-md btn-success pull-left checked_multiple' rel="tooltip">
                                <i class="fa fa-trash-o">Checked Selected</i>
                            </a>
                            <a href="#" style="visibility: hidden" class='btn btn-md btn-danger pull-left cancel_checked_multiple' rel="tooltip">
                                <i class="fa fa-trash-o">Cancel Checked Selected</i>
                            </a>
                            <a class="btn btn-default pull-right " id="printButton" href="#" onclick="PrintDiv();"><span class="glyphicon glyphicon-print"> Print</span></a><br />
                            <div id="payslip">
                                <div class="row">
                                    <div class="col-md-8" style="font-weight:bold; font-size: 20px;"> Company Name : <?php echo $company; ?></div>
                                    <div class="col-md-4" style="text-align:right">Month: <?php echo $month_name; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8" style="font-weight:bold;">Division Name : <?php echo $division ?></div>
                                    <div class="col-md-4" style="text-align:right">Financial Year: <?php echo $year; ?></div>
                                </div>
                                <table style="width:100%" id="example">
                                    <tr style="background:#996600 !important;font-style: bold;color:#FFF">
                                        <th><input type="checkbox" class='check-all'></th>
                                        <th>Sl no</th>
                                        <th style="text-align:center">Action</th>                                        
                                        <th>Status</th>
                                        <th>Employee Name</th>
                                        <th>Division</th>
                                        <th>DateFrom_To</th>
                                        <th>Gross Salary</th>
                                        <th>Earnings</th>
                                        <th>Deductions</th>
                                        <th>Absent Day</th>
                                        <th>Late Day</th>
                                        <th>Early Day</th>
                                        <!--<th>Tax</th>-->
                                        <!--<th>Late/Early(TK)</th>-->
                                        <!--<th>Absent(TK)</th>-->
                                        <th>Net Payment</th>
                                        <th>Remarks</th>
                                        <th>Checked</th>
                                        <th>Approved</th>
                                       
                                    </tr>
                                    <?php
                                    foreach ($paySlips as $paySlip) {
                                    ?>
                                        <tr class="checked checked-<?php echo $paySlip->id; ?>">
                                            <td>

                                                <input type="checkbox" class='check-single ' name="payslip_id" value="<?php echo $paySlip->id; ?>" />

                                            </td>
                                            <td><?php echo $slNo++; ?></td>
                                            <td style="width:200px;text-align: center">
                                                <a title="view" id="<?php echo $paySlip->id; ?>" class="payslip_detail  btn btn-xs btn-default"><i class="fa fa-search-plus"></i>view</a>

                                                <a href="<?php echo base_url(); ?>pay-slip/<?php echo $paySlip->id; ?>" target="_blank" class="btn btn-xs btn-primary">payslip</a>
                                                <?php if ($paySlip->check_status == 0) { ?>
                                                    <a title="Checked payslip" href="<?php echo site_url(); ?>pay-slip-check/<?php echo $paySlip->id; ?>/checked" class=" btn btn-xs btn-success"> Checked</a>
                                                <?php } ?>
                                                <?php if ($paySlip->check_status == 1) { ?>
                                                    <a title="Cancel Checked" href="<?php echo site_url(); ?>pay-slip-check/<?php echo $paySlip->id; ?>/cancel_checked" class=" btn btn-xs btn-danger">Cancel Checked</a>
                                                <?php } ?>
                                            </td>
                                            <td style="font-style:italic">
                                                <?php
                                                if ($paySlip->status == 3) {
                                                    echo '<span class="label label-warning">Paid</span>';
                                                } else if ($paySlip->status == 2) {
                                                    echo '<span class="label label-success">Partly Paid</span>';
                                                } else if ($paySlip->status == 1) {
                                                    echo '<span class="label label-danger">Due</span>';
                                                }
                                                ?>
                                            </td>
                                            <td style="width:170px;font-weight:bold">
                                                <?php
                                                echo $paySlip->emp_name . "<br/><span style='color:#696969;font-size:10px;font-style:italic'>" . $paySlip->designation_name
                                                    . "</span><br/><span style='color:#8B4513;font-size:10px;'>" . $paySlip->emp_id . "</span>";
                                                ?>
                                            </td>
                                            <!--<td><?php //echo $paySlip->company_name; ?></td>-->
                                            <td><?php echo $paySlip->division_name; ?></td>
                                            <td><?php echo $paySlip->pay_from."<br/>".$paySlip->pay_to; ?></td>
                                            <td style="text-align:right"><?php $grossSalary = $paySlip->gross_salary;
                                                                            echo number_format($grossSalary); ?></td>
                                            <td style="width:150px;height:30px;vertical-align: top">


                                                <div class="accordion" id="accordionExample">

                                                    <div class="card">
                                                        <div class="card-header" id="headingTwo">
                                                            <h5 class="mb-0">
                                                                <button style="font-style:italic; text-decoration: underline;  color:green;" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target=".collapseOne<?php echo $slNo; ?>" aria-expanded="false" aria-controls="collapseOne">
                                                                    Earnings
                                                                </button>
                                                            </h5>
                                                        </div>
                                                        <div id="collapseOne<?php echo $slNo; ?>" class="collapse collapseOne<?php echo $slNo; ?>" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                            <div class="card-body">
                                                                <?php
                                                                //                                                                        $data['paySlip'] = $paySlip;
                                                                //                                                                        $this->load->view('payroll/earnings',$data);
                                                                include(APPPATH . 'views/payroll/earnings.php');
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </td>

                                            <td style="width:150px;height:30px;vertical-align: top">
                                                <div class="accordion" id="accordionExample">

                                                    <div class="card">
                                                        <div class="card-header" id="headingTwo">
                                                            <h5 class="mb-0">
                                                                <button style="font-style:italic; text-decoration: underline; color:red;" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target=".collapseOne<?php echo $slNo; ?>" aria-expanded="false" aria-controls="collapseTwo">
                                                                    Deductions
                                                                </button>
                                                            </h5>
                                                        </div>
                                                        <div id="collapseOne<?php echo $slNo; ?>" class="collapse collapseOne<?php echo $slNo; ?>" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                            <div class="card-body">
                                                                <?php
                                                                //                                                                        $data['paySlip'] = $paySlip;
                                                                //                                                                        $this->load->view('payroll/deductions',$data);
                                                                include(APPPATH . 'views/payroll/deductions.php');
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </td>
                                            <td style="text-align:center"><?php echo $paySlip->absent_day; ?></td>
                                            <td style="text-align:center"><?php echo $paySlip->late_day; ?></td>
                                            <td style="text-align:center"><?php echo $paySlip->early_day; ?></td>
                                            <td style="text-align:right"><?php $netTotal = $paySlip->net_salary;
                                                                            echo number_format($netTotal); ?></td>
                                            <td><?php echo $paySlip->remarks; ?></td>
                                            <td style="text-align:center">
                                                <?php
                                                if ($paySlip->checked == 1) {
                                                    echo '<i class="fa fa-check-circle" style="color:green"></i><br/><span style="font-size:10px;font-style:italic">' . $paySlip->checked_date . "</span>";
                                                }
                                                ?>
                                            </td>
                                            <td style="text-align:center">
                                                <?php
                                                if ($paySlip->approved == 1) {
                                                    echo '<i class="fa fa-check-circle" style="color:green"></i><br/><span style="font-size:10px;font-style:italic">' . $paySlip->approved_date . "</span>";
                                                }
                                                ?>
                                            </td>
                                            
                                            
                                        </tr>


                                    <?php
                                        $totalGrandEarning += $totalEarning;
                                        $totalGrandDeduction += $totalDeduct;
                                        $totalGross += $grossSalary;
                                        $totalNetPayment += $netTotal;
                                    } ?>
                                    <!-- <tr style="font-weight: bold; text-align: right;">
                                        <td colspan="6">TOTAL</td>
                                        <td style="text-align:right"><?php echo number_format($totalGross); ?></td>
                                        <td style="text-align:center"><?php echo number_format($totalGrandEarning); ?></td>
                                        <td style="text-align:center"><?php echo number_format($totalGrandDeduction); ?></td>
                                        <td colspan="3"></td>
                                        <td style="text-align:right"><?php echo number_format($totalNetPayment); ?></td>

                                        <td colspan="5"></td>
                                    </tr> -->
                                </table>
                            </div>
                            <?php
                            $this->load->view('payroll/payslip-detail', true);
                        } else {
                            if ($search_record == true) {
                            ?>
                                <br />
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">
                                        <div class="alert alert-danger text-center ">
                                            <strong>No record found!</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>

                        <?php
                            }
                        }
                        ?>

                    </div>
                </div>

            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <div style="display:none" id="dialog-checked" title="Alert!">
        <p>
            <span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
            These items will be checked. Are you sure?
        </p>
    </div>
    <div style="display:none" id="dialog-cancel-checked" title="Alert!">
        <p>
            <span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
            These items checked will be canceled. Are you sure?
        </p>
    </div>
    <script>
        function PrintDiv() {
            var divToPrint = document.getElementById('payslip');
            var popupWin = window.open('', '_blank', 'width=1000,height=auto');
            popupWin.document.open();
            var a = '<div style="width="100%; margin:0 auto;display:block;">\n\
                <div style="float:left;width:43%;text-align:right;">\n\
            \n\
            </div>\n\
            <div class="" style="line-height:40px;text-align: center;font-size:20px;color:black;font-weight:bold;text-decoration:underline;"> \n\
            <span style="padding-left:8px;font-family:Verdana, Geneva, sans-serif">Pay Slips <br></span>' +
                '</div>\n\
            </div><br>';
            popupWin.document.write('<html><head><title>Pay Slips </title>\n\
            \n\
            \n\
            \n\
            \n\
            <style> body{ text-align:center;font-size:15px;margin:0 auto;}table{margin:0 auto;}table, th, td {padding-left:5px;padding-right:5px;font-size:10px;border: 1px solid black; border-collapse: collapse;}th{background: #DCDCDC; border-top:2px solid #000;} tr:nth-child(even) {background: #DCDCDC }tr:nth-child(odd) {background: #FFF}</style>\n\
                              \n\
            \n\
            \n\
            \n\
            \n\
            </head><body onload="window.print()">' + a + divToPrint.innerHTML + '</html>');
            popupWin.document.close();
        }
    </script>
</body>

</html>