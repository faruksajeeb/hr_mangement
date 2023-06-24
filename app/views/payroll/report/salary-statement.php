<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS- Report | Salary Statement</title>
    <!--chosen-->
    <?php
    $this->load->view('includes/cssjs');
    $userId =  $this->session->userdata('user_id');
    $userType =  $this->session->userdata('user_type');
    $userDivision =  $this->session->userdata('user_division');
    $userDepartment =  $this->session->userdata('user_department');
    ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.form.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#loader").hide();

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


            $('.payment_payslip').click(function() {
                //alert($(this).data('due_amount'));
                $('#payslip_id').val($(this).data('payslip_id'));
                $('#emp_id').val($(this).data('emp_id'));
                $('#emp_name').val($(this).data('emp_name'));
                $('#year_name').val($(this).data('year_name'));
                $('#month').val($(this).data('month'));
                var paid_amount = $(this).data('paid_amount');
                if (!paid_amount) {
                    paid_amount = 0;
                }
                $('#paid_amount').val(paid_amount);
                $('#due_amount').val($(this).data('due_amount'));
                $('#net_total').val($(this).data('net_total'));
            });

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
            $('.payment_detail').click(function() {
                //	alert(0);
                var payslip_id = $(this).attr('id');
                //                     alert(payslip_id);
                // dialog.dialog( "open" );
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>payroll/getPaymentDetailByPaySlipId",
                    data: {
                        payslip_id: payslip_id
                    },
                    dataType: "html",
                    cache: false,

                    success: function(data) {
                        // alert(data);
                        $("#payment-detail").html(data);
                        dialog.dialog("open");

                    },
                    error: function() {
                        alert('ERROR!');
                    }
                });
            });
            // 
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

        });

        function validate() {
            var valid = true;

            var msg = "<ul>";
            if (document.payslipForm.emp_company.value == "") {
                if (valid) { //only receive focus if its the first error
                    document.payslipForm.emp_company.focus();
                    document.payslipForm.emp_company.style.border = "solid 1px red";
                    //document.myForm.loan_type_name.style.backgroundColor="#FFA07A";
                    msg += '<li >You need to select the company! <span class="glyphicon glyphicon-remove-circle"></li>';
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
            //text-align: right;
        }

        a:hover {
            cursor: pointer;
        }

        .dialogWithDropShadow {
            -webkit-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            -moz-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);

        }

        .ui-dialog {
            //  background-color: #ffcc99;
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

                                <i class="fas fa-money-check-alt " style="font-size:20px"></i> Salary Statement
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

                                                            if ($userType == 1 || $userType == 9 || ($all_company_access['status'] == 1)) {
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
                                                        <select name="salary_month" id="salary_month" class="form-control" required>
                                                            <option value=""> --select employee salary month-- </option>
                                                            <?php foreach ($months as $month) { ?>
                                                                <option value="<?php echo $month->month_id . '-' . $month->month_name; ?>"><?php echo $month->month_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-4">Employee Type:</div>
                                                    <div class="col-md-8">
                                                        <select name="employee_type" id="employee_type" class="form-control">
                                                            <option value="all"> All </option>
                                                            <?php foreach ($employee_types as $val) { ?>
                                                                <option value="<?php echo $val->tid . '-' . $val->name; ?>"><?php echo $val->name; ?></option>
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
                                            <div class="col-md-4"></div>
                                            <div class="col-md-8">

                                            </div>
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

                            <br />
                            <!-- <a href="#" class="pull-right btn btn-default">PDF</a> -->
                            <a href="<?php echo base_url(); ?>salary-statement/excel" class="pull-right btn btn-default">Excel</a>

                            <div class="row" style="background-color:#F0E68C;padding: 5px;">
                                <div class="col-md-2"> </div>
                                <div class="col-md-8" style="font-weight:bold; font-size: 20px;text-align:center"><?php echo $company; ?></div>
                                <div class="col-md-2" style="text-align:right"></div>
                            </div>
                            <div class="row" style="background-color:#F0E68C;padding: 5px;">
                                <div class="col-md-2"> </div>
                                <div class="col-md-8" style="font-weight:bold; font-size: 20px;text-align:center"><?php echo $division; ?></div>
                                <div class="col-md-2" style="text-align:right"></div>
                            </div>
                            <div class="row" style="background-color:#F0E68C;padding: 5px;">
                                <div class="col-md-2"> </div>
                                <div class="col-md-8" style="font-weight:bold; font-size: 20px;text-align:center">
                                    <?php echo "Salary for the month of " . $month_name . "' " . $year; ?>
                                </div>
                                <div class="col-md-2" style="text-align:right"></div>
                            </div>

                            <table style="width:100%" id="example">
                                <tr>
                                    <th>Sl no</th>
                                    <th>Grade</th>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Division</th>
                                    <th>Designation</th>
                                    <th>Basic</th>
                                    <th>House Rent</th>
                                    <th>Medical</th>
                                    <th>CA</th>
                                    <th>EA</th>
                                    <th>HMA</th>
                                    <th>Total Allowance</th>
                                    <th>PF</th>
                                    <th>Gross</th>
                                    <th>PF Subscription and Contribution
                                    </th>
                                    <th>AIT</th>
                                    <th>Loan</th>
                                    <th>Total Deduction</th>
                                    <th>Net Payable</th>
                                    <th>Status</th>
                                </tr>
                                <?php
                                $grandTotalBasicSalary =
                                $grandTotalHouseRent =
                                $grandTotalMedical =
                                $grandTotalConveyance  =
                                $grandTotalEntertainment =
                                $grandTotalHouseMAllowance =
                                $grandTotalTotalAllowance =
                                $grandTotalPFContribution =
                                $grandTotalGrossSalary =
                                $grandTotalPFSubscriptionAndContribution =
                                $grandTotalAITEmployee =
                                $grandTotalstaffLoan =
                                $grandTotalTotalDeduction =
                                $grandTotalNetPayable = 0;
                                foreach ($paySlips as $paySlip) {
                                ?>
                                    <tr>
                                        <td><?php echo $slNo++; ?></td>
                                        <td><?php echo $paySlip->grade_name; ?></td>
                                        <td><?php echo $paySlip->emp_id; ?></td>
                                        <td><?php echo $paySlip->emp_name; ?></td>
                                        <td><?php echo $paySlip->division_name; ?></td>
                                        <td><?php echo $paySlip->designation_name; ?></td>
                                        <td><?php echo $paySlip->basic; ?></td>
                                        <td><?php echo $paySlip->hra; ?></td>
                                        <td><?php echo $paySlip->ma; ?></td>
                                        <td><?php echo $paySlip->ca; ?></td>
                                        <td><?php echo $paySlip->ea; ?></td>
                                        <td><?php echo $paySlip->hma; ?></td>
                                        <td style="text-align:right"><?php
                                                                        $totalAllowance = $paySlip->hra + $paySlip->ma + $paySlip->ca + $paySlip->ea + $paySlip->hma;
                                                                        echo number_format($totalAllowance); ?></td>
                                        <td style="text-align:right"><?php echo $paySlip->pf; ?></td>
                                        <td style="text-align:right"><?php echo $paySlip->gross_salary; ?></td>
                                        <td style="text-align:right"><?php echo $paySlip->pf * 2; ?></td>
                                        <td style="text-align:right"><?php echo $paySlip->tax; ?></td>
                                        <td style="text-align:right"><?php echo $paySlip->loan; ?></td>
                                        <?php $totalDeduction = ($paySlip->pf * 2) + $paySlip->tax + $paySlip->loan; ?>
                                        <td style="text-align:center"><?php echo $totalDeduction; ?></td>
                                        <td style="text-align:right"><?php echo $paySlip->net_salary; ?></td>
                                        
                                        <td style="font-style:italic">
                                            <?php
                                            if ($paySlip->status == 1) {
                                                echo '<span class="label label-danger">Due</span>';
                                            } else if ($paySlip->status == 2) {
                                                echo '<span class="label label-warning">Partly paid</span>';
                                            } else if ($paySlip->status == 3) {
                                                echo '<span class="label label-success">Paid</span>';
                                            }
                                            ?>
                                        </td>
                                        <!--                                            <td style="width:150px;">
                                                 <a href="<?php echo base_url(); ?>pay-slip/<?php echo $paySlip->id; ?>" target="_blank">Payslip</a>
                                               

                                                <a title="view"    id="<?php echo $paySlip->id; ?>" class="payslip_detail" ><i class="fas fa-search-plus"></i> view</a>
                                                   
                                                   
                                               
                                            </td>-->
                                    </tr>
                                <?php
                                    $grandTotalBasicSalary += $paySlip->basic;
                                    $grandTotalHouseRent += $paySlip->hra;
                                    $grandTotalMedical += $paySlip->ma;
                                    $grandTotalConveyance  += $paySlip->ca;
                                    $grandTotalEntertainment += $paySlip->ea;
                                    $grandTotalHouseMAllowance += $paySlip->hma;
                                    $grandTotalTotalAllowance += $totalAllowance;
                                    $grandTotalPFContribution += $paySlip->pf;
                                    $grandTotalGrossSalary += $paySlip->gross_salary;
                                    $grandTotalPFSubscriptionAndContribution += ($paySlip->pf*2);
                                    $grandTotalAITEmployee += $paySlip->tax;
                                    $grandTotalstaffLoan += $paySlip->loan;
                                    $grandTotalTotalDeduction += $totalDeduction;
                                    $grandTotalNetPayable += $paySlip->net_salary;
                                }
                                ?>
                                <tr>

                                    <td colspan="6" style="font-weight:bold;">Grand Total</td>
                                    
                                    <td style="text-align: right; font-weight:bold;"><?php echo number_format($grandTotalBasicSalary); ?></td>
                                    <td style="text-align: right; font-weight:bold;"><?php echo number_format($grandTotalHouseRent); ?></td>
                                    <td style="text-align: right; font-weight:bold;"><?php echo number_format($grandTotalMedical); ?></td>
                                    <td style="text-align: right; font-weight:bold;"><?php echo number_format($grandTotalConveyance); ?></td>
                                    <td style="text-align: right; font-weight:bold;"><?php echo number_format($grandTotalEntertainment); ?></td>
                                    <td style="text-align: right; font-weight:bold;"><?php echo number_format($grandTotalHouseMAllowance); ?></td>
                                    <td style="text-align: right; font-weight:bold;"><?php echo number_format($grandTotalTotalAllowance); ?></td>
                                    <td style="text-align: right; font-weight:bold;"><?php echo number_format($grandTotalPFContribution); ?></td>
                                    <td style="text-align: right; font-weight:bold;"><?php echo number_format($grandTotalGrossSalary); ?></td>
                                    <td style="text-align: right; font-weight:bold;"><?php echo number_format($grandTotalPFSubscriptionAndContribution); ?></td>
                                    <td style="text-align: right; font-weight:bold;"><?php echo number_format($grandTotalAITEmployee); ?></td>
                                    <td style="text-align: right; font-weight:bold;"><?php echo number_format($grandTotalstaffLoan); ?></td>
                                    <td style="text-align: right; font-weight:bold;"><?php echo number_format($grandTotalTotalDeduction); ?></td>
                                    <td style="text-align: right; font-weight:bold;"><?php echo number_format($grandTotalNetPayable); ?></td>
                                    <td></td>
                                </tr>
                                <!-- <tr>
                                    <td colspan="18" style="text-align:right;font-weight: bold">Tax Payable</td>
                                    <td style="text-align: right; font-weight:bold;"><?php echo number_format($totalTax); ?></td>
                                    <td colspan="3"></td>
                                </tr> 
                                <tr>
                                    <td colspan="18" style="text-align:right;font-weight: bold">Total Payable</td>
                                    <td style="text-align: right; font-weight:bold;"><?php echo number_format($totalNetPayment + $totalTax); ?></td>
                                    <td colspan="3"></td>
                                </tr>-->
                            </table><br />

                            <?php
                            // $this->load->view('payroll/edit-payslip', true);
                            $this->load->view('payroll/payment-payslip-form', true);
                            $this->load->view('payroll/payment-detail', true);
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
    <!--Chosen-->
    <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.jquery.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
    <script>
        $(".chosen-select").chosen();
    </script>
</body>

</html>