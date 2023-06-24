<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS- Report | Bank Advice</title>
    <!--chosen-->
    <?php
    $this->load->view('includes/cssjs');
    $userType = $this->session->userdata('user_type');
    $userId = $this->session->userdata('user_id');

    $userDivision = $this->session->userdata('user_division');
    $userDepartment = $this->session->userdata('user_department');
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







            // Multiple select ------

            $('.check-all').click(function() {
                var checked_status = this.checked;

                $(this).closest('table').find('input:checkbox').each(function() {
                    if (checked_status) {
                        this.checked = true;
                        $(".checked").css('background-color', "#98FB98 !important");
                    } else {
                        this.checked = false;
                        $(".checked").css('background-color', "#FFF !important");
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

                    $('.approved_multiple').css("visibility", "visible");
                    $('.cancel_approved_multiple').css("visibility", "visible");
                    $('.delete_multiple').css("visibility", "visible");

                } else {
                    //$('#del_all').hide(); 

                    $('.approved_multiple').css("visibility", "hidden");
                    $('.cancel_approved_multiple').css("visibility", "hidden");
                    $('.delete_multiple').css("visibility", "hidden");

                }

            });
            $('#export').on('submit', function(e) {
                var export_type = $("#export_bank_advice").val();

                if (export_type == '') {
                    alert('please select export type');
                    return false;
                } else if (export_type == 'export_selected_pdf' || export_type == 'export_selected_excel') {
                    var checkValues = $('.check-single:checked').map(function() {
                        return $(this).val();
                    }).get();
                    console.log(checkValues);
                    $.each(checkValues, function(i, val) {
                        $("#" + val).remove();
                    });
                    //                    return  false;
                    if (checkValues.length === 0) //tell you if the array is empty
                    {
                        alert("Please Select your desired employee");
                        return false;
                    } else {

                    }
                }
                //$(this).attr('target', '_blank');
                /*
                 $.ajax({
                 url: '<?php echo base_url(); ?>payroll/exportSalaryAdviser',
                 type: 'post',
                 data:{
                 'export_type' : export_type,
                 'payslip_id' : checkValues
                 }
                 
                 }).done(function (data) {
                 $(this).attr('target', '_blank');
                 alert(data);
                 // $("#content_display").html(data);
                 $('.check-all').attr('checked', false);
                 // location.reload(true);
                 //  alert(tbl_name + ' was successfully Deleted!');                                   
                 
                 });
                 */
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

                                <i class="fas fa-money-check-alt " style="font-size:20px"></i> Bank Advice
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
                                                            if ($userType == 1 || !$userDepartment) {
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
                    <div class="col-md-3"></div>
                    <div class="col-md-6" style="border:1px dotted #CCC">
                        <div id="loader" style="text-align:center; display:none;">
                            <div style="padding: 5px;">Please be patient, Salary Adviser is being generated.</div>
                            <img src="<?php echo base_url() ?>resources/images/prosseging.gif" style="width: 100px;" alt="Processing..." />
                            <!-- Start Report -->
                        </div>
                        <?php
                        $slNo = 1;
                        if ($paySlips) {
                        ?>

                            <br />
                            <form id="export" action="<?php echo base_url(); ?>export-bank-advice" method="POST">
                                <input type="hidden" name="company" id="company" value="<?php echo $company; ?>" />
                                <input type="hidden" name="division" id="division" value="<?php echo $division; ?>" />
                                <input type="hidden" name="month_name" id="month_year" value="<?php echo $month_name; ?>" />
                                <input type="hidden" name="year" id="month_year" value="<?php echo $year; ?>" />
                                <div class="row">

                                </div>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10 col-xs-12 col-sm-12" style="background:#ffcc99">
                                        <div class="form-group row" style="height:35px;vartical-align:middle">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label" style="text-align:right;margin-top: 10px;">Export Type:</label>
                                            <div class="col-sm-6" class="form-control" name="" id="">
                                                <select style="height:35px;" name="export_bank_advice" id='export_salary_adviser' required="">
                                                    <!--                                                        <option value="">select export type</option>-->
                                                    <option value="export_pdf"> PDF</option>
                                                    <option value="export_excel"> Excel</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-2" class="form-control" name="" id="" style="text-align:left;">
                                                <input type="submit" class="" name="btn_export" id="" value="Export" style="height:35px;">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10 col-xs-12 col-sm-12" style="background:#ffcc99">
                                        <div class="row">
                                            <div class="col-md-4">To Bank:</div>
                                            <div class="col-md-8">
                                                <select name="bank_name" id="bank_name" required="">
                                                    <option value=""> --select bank-- </option>
                                                    <?php foreach ($banks as $bank) { ?>
                                                        <option value="<?php echo $bank->name; ?>"><?php echo $bank->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10 col-xs-12 col-sm-12" style="background:#ffcc99">
                                        <div class="row">
                                            <div class="col-md-4">Bank Address:</div>
                                            <div class="col-md-8">
                                                <textarea id="bank_address" name="bank_address" required=""></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10 col-xs-12 col-sm-12" style="background:#ffcc99">
                                        <div class="row">
                                            <div class="col-md-4">From Account No:</div>
                                            <div class="col-md-8">
                                                <input type="text" id="bank_account_no" name="bank_account_no" required="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="background-color:#F0E68C;padding: 5px;">
                                    <div class="col-md-2"> </div>
                                    <div class="col-md-8" style="font-weight:bold; font-size: 20px;text-align:center">Bank Advice</div>
                                    <div class="col-md-2" style="text-align:right"></div>
                                </div>
                                <div class="row" style="background-color:#F0E68C;padding: 5px;">
                                    <div class="col-md-2"> </div>
                                    <div class="col-md-8" style="font-weight:bold; font-size: 15px;text-align:center"><?php echo $company; ?></div>
                                    <div class="col-md-2" style="text-align:right"></div>
                                </div>
                                <div class="row" style="background-color:#F0E68C;padding: 5px;">
                                    <div class="col-md-2"> </div>
                                    <div class="col-md-8" style="font-weight:bold; font-size: 15px;text-align:center"><?php echo $division; ?></div>
                                    <div class="col-md-2" style="text-align:right"></div>
                                </div>
                                <div class="row" style="background-color:#F0E68C;padding: 5px;">
                                    <div class="col-md-2"> </div>
                                    <div class="col-md-8" style="font-weight:bold; font-size: 15px;text-align:center">
                                        <?php echo "Salary for the month of " . $month_name . "' " . $year; ?>
                                    </div>
                                    <div class="col-md-2" style="text-align:right"></div>
                                </div>

                                <table style="width:100%">
                                    <tr>
                                        <th><input type="checkbox" class='check-all'></th>
                                        <th>Sl no</th>
                                        <th>Employee ID</th>
                                        <th>Employee Name</th>
                                        <th>Account Number</th>
                                        <th>Bank</th>
                                        <th>Branch</th>
                                        <th>Salary Amount</th>
                                    </tr>
                                    <?php
                                    foreach ($paySlips as $paySlip) {
                                    ?>
                                        <tr class="checked checked-<?php echo $paySlip->id; ?>">
                                            <td> <input type="checkbox" class='check-single ' name="payslip_id[]" value="<?php echo $paySlip->id; ?>" /></td>
                                            <td><?php echo $slNo++; ?> </td>

                                            <td><?php echo $paySlip->emp_id; ?></td>
                                            <td><?php echo $paySlip->emp_name; ?></td>
                                            <td><?php echo $paySlip->bank_account_no; ?></td>
                                            <td><?php echo $paySlip->bank_name; ?></td>
                                            <td><?php echo $paySlip->branch_name; ?></td>
                                            <td style="text-align:right"><?php $netPayment = $paySlip->net_salary;
                                                                            echo number_format($netPayment); ?></td>

                                        </tr>
                                    <?php
                                        $totalNetPayment += $netPayment;
                                    }
                                    ?>
                                    <tr>

                                        <td colspan="7" style="font-weight:bold;">Grand Total</td>
                                        <td style="text-align: right; font-weight:bold;"><?php echo number_format($totalNetPayment); ?></td>
                                    </tr>

                                </table>
                            </form>
                            <br />

                            <?php
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
                    <div class="col-md-3"></div>
                </div>

            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->


</body>

</html>