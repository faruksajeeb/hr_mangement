<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS-Loan Report</title>
    <!--chosen-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.css">
    <?php
    $this->load->view('includes/cssjs');
    ?>

    <script>
        $(document).ready(function() {
            $(".chosen-select").chosen();
            var dialog, form;
            dialog = $("#disbursement-form").dialog({
                autoOpen: false,
                height: "auto",
                width: "auto",
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
            $('.loan_disbursement').click(function() {
                //	alert(0);
                var loan_id = $(this).attr('id');
                //alert(loan_id);
                // dialog.dialog( "open" );
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>loan/getLoanDisbursmentDataByLoanId",
                    data: {
                        loan_id: loan_id
                    },
                    dataType: "html",
                    cache: false,
                    success: function(data) {
                        // alert(data);
                        $("#disbursement-form").html(data);
                        dialog.dialog("open");

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
            if (document.myForm.emp_name.value == "") {
                if (valid) { //only receive focus if its the first error
                    document.myForm.emp_name.focus();
                    document.myForm.emp_name.style.border = "solid 1px red";
                    //document.myForm.loan_type_name.style.backgroundColor="#FFA07A";
                    msg += '<li >You need to select  the employee field! <span class="glyphicon glyphicon-remove-circle"></li>';
                    valid = false;
                    // return false;
                }
            }
            if (!valid) {
                //alert(0);
                msg += "</ul>";
                //console.log("Hello Bd");

                var div = document.getElementById('errors').innerHTML = msg;
                document.getElementById("errors").style.display = 'block';
                //Hide();
                return false;
            }

        }
    </script>
    <style>
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

                                <i class="fas fa-hand-holding-usd" style="font-size:20px"></i> Loan (Employee Wise)
                            </div>
                        </div>
                        <form action="" method="POST" onSubmit="return validate();" class="myForm" id="myForm" name="myForm" enctype="multipart/form-data">
                            <div class="row success-err-sms-area">
                                <div class="col-md-12">
                                    <input type="hidden" name="content_id" id="content_id" value="<?php print $id; ?>">
                                    <div id="errors" style='color:red;text-align:right'></div>


                                </div>
                            </div>
                            <div class="row">


                                <div class="row">

                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4">Employee name:</div>
                                            <div class="col-md-8">
                                                <select name='emp_name' id='emp_name' data-placeholder="Choose an Employee..." class="chosen-select">
                                                    <option value="">--Select employee name--</option>
                                                    <?php
                                                    foreach ($employees as $employee) {
                                                    ?>
                                                        <option value="<?php echo $employee['content_id'] . '-' . $employee['emp_id'] . '-' . $employee['emp_name'] ?>" <?php
                                                                                                                                                                        if ($emp_id) {
                                                                                                                                                                            if ($emp_id == $employee['emp_id']) {
                                                                                                                                                                                echo "selected='selected'";
                                                                                                                                                                            }
                                                                                                                                                                        }
                                                                                                                                                                        ?>>
                                                            <?php echo $employee['emp_name'] . '-' . $employee['emp_id']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4">Financial Year:</div>
                                            <div class="col-md-8">
                                                <select name="year" id="year" class="chosen-select">
                                                    <?php foreach($years as $val):?>
                                                    <option value="<?php echo $val->year; ?>" <?php echo $val->year==date('Y')?'selected':'';?>><?php echo $val->year; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
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
                                                <input type="SUBMIT" name="add_btn" id="add_btn" style="width:100%;" value="SUBMIT" />
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </form>

                    </div>

                    <div class="col-md-3 col-xs-12 "></div>

                </div>

                <div id="progress-div" style="display:none;">
                    <div id="progress-bar"></div>
                </div>
                <?php if ($loans) { ?>
                    <br />
                    <div class="row">

                        <div class="col-md-12" style="border:1px solid #ccc; padding: 5px;">

                            <div class="row">
                                <div class="col-md-4">Employee ID: <?php echo $emp_id; ?></div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" style="font-weight:bold;">Employee Name: <?php echo $emp_name ?></div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4" style="text-align:right">Financial Year: <?php echo $year; ?></div>
                            </div>
                            <table style="width:100%;" class="table table-sm">
                                <tr>
                                    <th>SL No.</th>
                                    <th>Loan ID</th>
                                    <th>Loan from</th>
                                    <th>Given Date</th>
                                    <th>Loan Type</th>
                                    <th>Repayment Type:</th>
                                    <th>Repay From</th>
                                    <th style="text-align:right;">Amount</th>
                                    <th style="text-align:right;">Interest(%)</th>
                                    <th style="text-align:right;">Penalty(%)</th>
                                    <th style="text-align:right;">Installment</th>
                                    <th style="text-align:right;">Paid Installment</th>
                                    <th style="text-align:right;">Balance</th>
                                    <th>Remarks</th>
                                    <!--<th>Action</th>-->
                                </tr>

                                <?php
                                $sl_no = 1;
                                foreach ($loans as $loan) {
                                ?>

                                    <tr>
                                        <td><?php echo $sl_no++; ?></td>
                                        <td><a class="loan_disbursement" id="<?php echo $loan->id ?>"><?php echo '#00' . $loan->id ?></a></td>
                                        <td><?php echo $loan->AccountName; ?></td>
                                        <td><?php echo $loan->trans_date; ?></td>
                                        <td><?php echo $loan->loan_type_name; ?></td>
                                        <td style="font-style:italic">
                                            <?php
                                            if ($loan->repayment_type == 'daily_repayment') {
                                                echo "Daily";
                                            } else if ($loan->repayment_type == 'weekly_repayment') {
                                                echo "Weekly";
                                            } else if ($loan->repayment_type == 'monthly_repayment') {
                                                echo "Monthly";
                                            } else if ($loan->repayment_type == 'yearly_repayment') {
                                                echo "Yearly";
                                            }
                                            ?>
                                        </td>
                                        <td style="font-style:italic">
                                            <?php
                                            if ($loan->repayment_from == 1) {
                                                echo "Repay from salary";
                                            } else {
                                                echo "Personally";
                                            }
                                            ?>
                                        </td>
                                        <td style="text-align:right;"><?php $loanAmount = $loan->amount;
                                                                        echo "৳ " . number_format($loanAmount); ?></td>
                                        <td style="text-align:right;"><?php echo $loan->interest; ?></td>
                                        <td style="text-align:right;"><?php echo $loan->penalty; ?></td>
                                        <td style="text-align:right;"><?php echo $loan->installment; ?></td>
                                        <td style="text-align:right;"><?php echo $loan->paid_installment; ?></td>
                                        <td style="text-align:right;"><?php $dueAmount = $loan->balance;
                                                                        echo "৳ " . number_format($dueAmount); ?></td>
                                        <td><?php
                                            if ($loan->balance > 0) {
                                                echo 'due';
                                            } else {
                                                echo 'paid';
                                            }
                                            ?></td>
                                        <!--                                            <td>
                                                <a href="">Disbursement</a>
                                            </td>-->
                                    </tr>

                                <?php
                                    $totalLoanAmount += $loanAmount;
                                    $totalDueAmount += $dueAmount;
                                }
                                ?>
                                <th>TOTAL</th>
                                <th colspan="6"></th>
                                <th style="text-align:right;"><?php echo "৳ " . number_format($totalLoanAmount); ?></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th style="text-align:right;">Total Due</th>
                                <th style="text-align:right;"><?php echo "৳ " . number_format($totalDueAmount); ?></th>
                                <th></th>


                            </table>

                        </div>

                    </div>
                    <?php
                    $this->load->view('loan/report/disbursement', true);
                    ?>

                    <?php } else {
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
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!--Chosen-->
    <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.jquery.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/docsupport/init.js" type="text/javascript" charset="utf-8"></script>

</body>

</html>