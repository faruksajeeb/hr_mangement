<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS- Payslip Confirmation</title>
    <!--chosen-->
    <?php
    $this->load->view('includes/cssjs');

    ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.form.min.js"></script>

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
            /* background: #ffffcc !important; */
        }

        tr:hover {
            background: #ADFF2F !important;
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
                <div class="row">
                    <div class="col-md-3 col-xs-12 ">
                        
                    </div>
                    <div class="col-md-6 col-xs-12 add-form">
                        <div class="row add-form-heading">
                            <div class="col-md-12 ">

                                <i class="fas fa-money-check-alt " style="font-size:20px"></i> Pay slip Confirmation
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
                                        <div class="col-md-12"><a href="pay-slip-check" class="btn btn-sm btn-info">Payslip Check >></a></div>                     
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-8">
                                                <input type="submit" name="add_btn" id="add_btn" style="width:100%;" value="Search" />
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
                            <a href="#" style="visibility: hidden" class='btn btn-md btn-warning pull-left confirm_multiple' rel="tooltip">
                                <i class="fa fa-trash-o">Confirm Selected</i>
                            </a>
                            <a href="#" style="visibility: hidden; margin-left: 5px;" class='btn btn-md btn-danger pull-left delete_multiple' rel="tooltip">
                                <i class="fa fa-remove"> Delete Selected</i>
                            </a>
                            <!-- <a class="btn btn-default pull-right " id="printButton" href="#" onclick="PrintDiv();"><span class="glyphicon glyphicon-print"> Print</span></a> -->
                            
                            <br />
                            <div id="payslip">
                                <div class="row">
                                    <div class="col-md-8" style="font-weight:bold; font-size: 20px;"> Company Name : <?php echo $company; ?></div>
                                    <div class="col-md-4" style="text-align:right">Month: <?php echo $month_name; ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8" style="font-weight:bold;">Division Name : <?php echo $division ?></div>
                                    <div class="col-md-4" style="text-align:right">Financial Year: <?php echo $year; ?></div>
                                </div>
                                <style>
                                    .table-cont {
                                        max-width: 100%;
                                        /* max-height: 600px; */
                                        overflow: auto;
                                        border: 1px red solid;
                                        margin-bottom: 50px;
                                    }

                                    .table-cont .table {
                                        min-width: 100%;
                                    }
                                </style>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-cont">
                                            <table id="example" class="display table table-sm">
                                            <thead>
                                            <tr style="background:#996600 !important;font-style: bold;color:#FFF">
                                                    <th><input type="checkbox" class='check-all'></th>
                                                    <th>Sl no</th>
                                                    <th style="width:300px!important">________Action_______</th>

                                                    <th>Status</th>
                                                    <th>Employee_Name,Designation,Emp_ID</th>
                                                    <!-- <th>Company</th> -->
                                                    <th>Division</th>
                                                    <th>DateFrom_DateTo</th>
                                                    <th>Basic</th>
                                                    <th>House rent</th>
                                                    <th>Medical Allow.</th>
                                                    <th>Transport Allow.</th>
                                                    <th>Con. Allow.</th>
                                                    <th>Daily Allow.</th>
                                                    <th>Eenter. Allow.</th>
                                                    <th>Tell. Allow.</th>
                                                    <th>O. Allow.</th>
                                                    <th>P. Fund Allow.</th>
                                                    <th>P. Bonus</th>
                                                    <th>F. Bonus</th>
                                                    <th>S. Bonus</th>
                                                    <th>Gratuity</th>
                                                    <th>Incentive</th>
                                                    <th>OT Taka</th>
                                                    <th>Arrear Salary</th>
                                                    <th>House M Allow.</th>
                                                    <th>Gross Salary</th>
                                                    <th>Total Earnings</th>
                                                    <th>Late Deduct.</th>
                                                    <th>Early Deduct.</th>
                                                    <th>Absent Deduct.</th>
                                                    <th>Advance Salary</th>
                                                    <th>Loan</th>
                                                    <th>Arrear PF </th>
                                                    <th>PF </th>
                                                    <th>Tax </th>
                                                    <th>Other Deduct.</th>
                                                    <th>Total Deduction</th>
                                                    <th>Net Payment</th>
                                                    <th>Remarks</th>
                                                </tr>
                                </thead>
                                <tbody>
                                                <?php
                                                foreach ($paySlips as $paySlip) {
                                                ?>
                                                    <tr class="checked checked-<?php echo $paySlip->id; ?>">
                                                        <td><input type="checkbox" class='check-single ' name="payslip_id" value="<?php echo $paySlip->id; ?>" /></td>
                                                        <td><?php echo $slNo++; ?></td>
                                                        <td style="text-align: center">
                                                            <a title="view" id="<?php echo $paySlip->id; ?>" class="payslip_detail  btn btn-xs btn-default"><i class="fas fa-search-plus"></i>view</a>

                                                            <a href="<?php echo base_url(); ?>pay-slip/<?php echo $paySlip->id; ?>" target="_blank" class="btn btn-xs btn-success">payslip</a>
                                                            <a title="edit" data-toggle="modal" data-target="#paySlipModal" href="<?php echo $paySlip->id; ?>" class="edit_payslip btn btn-xs btn-primary" data-payslip_id="<?php echo $paySlip->id; ?>" data-emp_id="<?php echo $paySlip->emp_id; ?>" data-emp_name="<?php echo $paySlip->emp_name; ?>" data-emp_post_id="<?php echo $paySlip->emp_post_id; ?>" data-year_name="<?php echo $paySlip->year; ?>" data-month="<?php echo $month_name; ?>" data-basic="<?php echo $paySlip->basic; ?>" data-hra="<?php echo $paySlip->hra; ?>" data-ma="<?php echo $paySlip->ma; ?>" data-ta="<?php echo $paySlip->ta; ?>" data-ca="<?php echo $paySlip->ca; ?>" data-da="<?php echo $paySlip->da; ?>" data-ea="<?php echo $paySlip->ea; ?>" data-mba="<?php echo $paySlip->mba; ?>" data-oa="<?php echo $paySlip->oa; ?>" data-pb="<?php echo $paySlip->pb; ?>" data-bonus="<?php echo $paySlip->bonus; ?>" data-festival_bonus="<?php echo $paySlip->festival_bonus; ?>" data-pfa="<?php echo $paySlip->pfa; ?>" data-gratuity="<?php echo $paySlip->gratuity; ?>" data-ot_hour="<?php echo $paySlip->ot_hour; ?>" data-ot_taka="<?php echo $paySlip->ot_taka; ?>" data-arear="<?php echo $paySlip->arear; ?>" data-incentive="<?php echo $paySlip->incentive; ?>" data-present_salary="<?php echo $paySlip->present_salary; ?>" data-gross_salary="<?php echo $paySlip->gross_salary; ?>" data-total="<?php echo $paySlip->total; ?>" data-loan="<?php echo $paySlip->loan; ?>" data-advance_salary="<?php echo $paySlip->advance_salary; ?>" data-late_early_day="<?php echo $paySlip->late_early_day; ?>" data-late_early_taka="<?php echo $paySlip->late_early_taka; ?>" data-present_day="<?php echo $paySlip->present_day; ?>" data-late_day="<?php echo $paySlip->late_day; ?>" data-late_deduct="<?php echo $paySlip->late_deduct; ?>" data-early_day="<?php echo $paySlip->early_day; ?>" data-early_deduct="<?php echo $paySlip->early_deduct; ?>" data-absent_day="<?php echo $paySlip->absent_day; ?>" data-absent_day_taka="<?php echo $paySlip->absent_day_taka; ?>" data-pf="<?php echo $paySlip->pf; ?>" data-arrear_pf="<?php echo $paySlip->arrear_pf; ?>" data-tax="<?php echo $paySlip->tax; ?>" data-other_deduct="<?php echo $paySlip->other_deduct; ?>" data-net_salary="<?php echo $paySlip->net_salary; ?>">
                                                                <i class="fas fa-edit"></i>edit
                                                            </a>
                                                            <a title="confirm payslip" href="<?php echo site_url(); ?>pay-slip-confirmation/<?php echo $paySlip->id; ?>" class=" btn btn-xs btn-warning"> Confirm</a>
                                                            <a title="Delete payslip" onclick="return confirmDelete();" href="<?php echo site_url(); ?>pay-slip-delete/<?php echo $paySlip->id; ?>" class=" btn btn-xs btn-danger " style="font-weight:bold"> X </a>
                                                        </td>
                                                        <td style="font-style:italic">
                                                            <?php
                                                            echo $paySlip->status == 0 ?
                                                                '<span class="label label-default">Pending</span>' :
                                                                '';
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            echo $paySlip->emp_name . "<br/><span style='color:#696969;font-size:10px;font-style:italic'>" . $paySlip->designation_name
                                                                . "</span><br/><span style='color:#8B4513;font-size:10px;'>" . $paySlip->emp_id . "</span>";
                                                            ?>
                                                        </td>
                                                        <!-- <td><?php //echo $paySlip->company_name; 
                                                                    ?></td> -->
                                                        <td><?php echo $paySlip->division_name; ?></td>
                                                        <td><?php echo $paySlip->pay_from . "<br/>" . $paySlip->pay_to; ?></td>

                                                        <td><?php echo number_format($paySlip->basic); ?></td>
                                                        <td><?php echo number_format($paySlip->hra); ?></td>
                                                        <td><?php echo number_format($paySlip->ma); ?></td>
                                                        <td><?php echo number_format($paySlip->ta); ?></td>
                                                        <td><?php echo number_format($paySlip->ca); ?></td>
                                                        <td><?php echo number_format($paySlip->da); ?></td>
                                                        <td><?php echo number_format($paySlip->ea); ?></td>
                                                        <td><?php echo number_format($paySlip->mba); ?></td>
                                                        <td><?php echo number_format($paySlip->oa); ?></td>
                                                        <td><?php echo number_format($paySlip->pfa); ?></td>
                                                        <td><?php echo number_format($paySlip->pb); ?></td>
                                                        <td><?php echo number_format($paySlip->festival_bonus); ?></td>
                                                        <td><?php echo number_format($paySlip->bonus); ?></td>
                                                        <td><?php echo number_format($paySlip->gratuity); ?></td>
                                                        <td><?php echo number_format($paySlip->incentive); ?></td>
                                                        <td><?php echo number_format($paySlip->ot_taka); ?></td>
                                                        <td><?php echo number_format($paySlip->arear); ?></td>
                                                        <td><?php echo number_format($paySlip->hma); ?></td>
                                                        <td style="text-align:right"><?php $grossSalary = $paySlip->gross_salary;
                                                                                        echo number_format($grossSalary); ?></td>
                                                        <td style="text-align:center"><?php echo number_format($paySlip->total); ?></td>
                                                        <td style="text-align:center"><?php echo $paySlip->late_deduct; ?></td>
                                                        <td style="text-align:center"><?php echo $paySlip->early_deduct; ?></td>
                                                        <td style="text-align:center"><?php echo $paySlip->absent_day_taka; ?></td>
                                                        <td style="text-align:right"><?php echo number_format($paySlip->advance_salary); ?></td>
                                                        <td style="text-align:right"><?php echo number_format($paySlip->loan); ?></td>
                                                        <td style="text-align:right"><?php echo number_format($paySlip->arrear_pf); ?></td>
                                                        <td style="text-align:right"><?php echo number_format($paySlip->pf); ?></td>
                                                        <td style="text-align:right"><?php echo number_format($paySlip->tax); ?></td>
                                                        <td style="text-align:right"><?php echo number_format($paySlip->other_deduct); ?></td>
                                                        <td style="text-align:right"><?php echo number_format($paySlip->total_deduction); ?></td>
                                                        <td style="text-align:right"><?php $netTotal = $paySlip->net_salary;
                                                                                        echo number_format($netTotal); ?></td>
                                                        <td><?php echo $paySlip->remarks; ?></td>


                                                    </tr>

                                                <?php

                                                    $totalGross += $grossSalary;
                                                    $totalNetPayment += $netTotal;
                                                } ?>
                                                <tbody>
                                                <tr style="font-weight: bold; text-align: right;">
                                                    <td colspan="35">TOTAL</td>
                                                    <td style="text-align:right"><?php echo number_format($totalNetPayment); ?></td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">

                                </div>

                            </div>
                            <?php
                            $this->load->view('payroll/payslip-detail', true);
                            $this->load->view('payroll/edit-payslip', true);
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
    <div style="display:none" id="dialog-confirm" title="Alert!">
        <p>
            <span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
            These items will be confirmed. Are you sure?
        </p>
    </div>
    <div style="display:none" id="dialog-delete" title="Alert!">
        <p>
            <span class="ui-icon ui-icon-alert ui-icon-danger" style="float:left;color:red; margin:12px 12px 20px 0;"></span>
            These items will be permanently deleted. Are you sure?
        </p>
    </div>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                stateSave: true
            });
            var base_url = '<?php echo base_url(); ?>';
            $('.confirm_multiple').css("visibility", "hidden");
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

            // ------------------------------
            $('.table').on('click', '.edit_payslip', function() {
                document.getElementById("payslip-form").reset();
                var payslipId = $(this).attr('href');
                if (payslipId) {
                    $.ajax({
                        type: "GET",
                        url: "<?php echo base_url(); ?>get_payslip_info_by_id/"+payslipId,
                        dataType: "JSON",
                        cache: false,
                        success: function(data) {
                            $('#emp_gross_salary').attr('readonly', 'readonly');                
                            $('#payslip_id').val(data.id);
                            $('#emp_id').val(data.emp_id);
                            $('#emp_name').val(data.emp_name);
                            $('#year_name').val(data.year);
                            $('#month').val(data.month_id);

                            $('#present_salary').val(data.present_salary);
                            $('#emp_gross_salary').val(Math.round(data.gross_salary));
                            $('#emp_basic_salary').val(data.basic);
                            $('#emp_house_rent').val(data.hra);
                            $('#emp_transport_allowance').val(data.ta);
                            $('#emp_daily_allowance').val(data.da);
                            $('#emp_telephone_allowance').val(data.mba);
                            $('#emp_pf_allowance').val(data.pfa);
                            $('#emp_arear').val(data.arear);
                            $('#emp_medical_allowance').val(data.ma);
                            $('#emp_entertainment_allowance').val(data.ea);

                            $('#emp_conveyance_allowance').val(data.ca);
                            $('#emp_other_allowance').val(data.oa);
                            $('#emp_performance_bonus').val(data.pb);
                            $('#emp_festival_bonus').val(data.festival_bonus);
                            $('#emp_incentive').val(data.incentive);

                            $('#emp_special_bonus').val(data.bonus);
                            $('#emp_gratuity').val(data.gratuity);
                            $('#emp_ot_hour').val(data.ot_hour);
                            $('#emp_ot_taka').val(data.ot_taka);
                            $('#emp_provident_fund_deduction').val(data.pf);
                            $('#arrear_pf').val(data.arrear_pf);
                            $('#emp_tax_deduction').val(data.tax);
                            $('#emp_other_deduction').val(data.other_deduct);
                            $('#other_deduction_note').val(data.other_deduction_note);
                            $('#emp_absent_day').val(data.absent_day);
                            $('#emp_absent_taka').val(data.absent_day_taka);

                            $('#emp_loan').val(data.loan);
                            $('#emp_advance_salary').val(data.advance_salary);
                            $('#late_day').val(data.late_day);
                            $('#late_deduction').val(data.late_deduct);
                            $('#early_day').val(data.early_day);
                            $('#early_deduction').val(data.early_deduct);
                            $('#emp_net_payment').val(Math.round(data.net_salary));
                            // $("#payslip-detail").html(data);
                            // payslipDialog.dialog("open");

                        },
                        error: function() {
                            alert('ERROR!');
                        }
                    });
                }
                

            });
            // Multiple select ------

            $('.check-all').click(function() {
                var checked_status = this.checked;
                $(this).closest('table').find('input:checkbox').each(function() {
                    if (checked_status) {
                        this.checked = true;
                        $('.confirm_multiple').css("visibility", "visible");
                        $('.delete_multiple').css("visibility", "visible");
                        $(".checked").css('background-color', "#98FB98 !important");
                    } else {
                        this.checked = false;
                        $(".checked").css('background-color', "#FFF !important");
                        $('.confirm_multiple').css("visibility", "hidden");
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

                    $('.confirm_multiple').css("visibility", "visible");
                    $('.delete_multiple').css("visibility", "visible");

                } else {
                    //$('#del_all').hide(); 

                    $('.confirm_multiple').css("visibility", "hidden");
                    $('.delete_multiple').css("visibility", "hidden");

                }

            });
            // Confirm multiple -----------------------
            $(".confirm_multiple").on('click', function(e) {
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
                    $("#dialog-confirm").dialog({
                        resizable: false,
                        height: "auto",
                        width: 400,
                        modal: true,
                        buttons: {
                            "Yes": function() {
                                $(this).dialog("close");
                                //alert('thanks');
                                $.ajax({
                                    url: '<?php echo base_url(); ?>payroll/confirmMultiplePayslip',
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
            // Delete multiple -----------------------
            $(".delete_multiple").on('click', function(e) {
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
                    $("#dialog-delete").dialog({
                        resizable: false,
                        height: "auto",
                        width: 400,
                        modal: true,
                        buttons: {
                            "Yes": function() {
                                $(this).dialog("close");
                                //alert('thanks');
                                $.ajax({
                                    url: '<?php echo base_url(); ?>payroll/deleteMultiplePayslip',
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