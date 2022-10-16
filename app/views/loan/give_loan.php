<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS-Give Loan</title>
    <!--chosen-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.css">
    <?php
    $this->load->view('includes/cssjs');

    ?>

    <script>
        $(document).ready(function() {

            $('#installment').keyup(function() {
                //                alert(0);
                var installmentNumber = $(this).val();
                var amount = $("#amount").val();
                var installmentAmount = amount / installmentNumber;
                //                alert(installmentAmount);
                $("#installment_amount").val(Number(installmentAmount).toFixed(2));

            });
            /*
               $('#emp_name').change(function () {
                   
                    var empInfo = $("#emp_name").val().split('|');
                    var emp_id = empInfo[0];
                    
                    $('#emp_id').val(emp_id);
                });
                $('#emp_id').keyup(function () {
                    var emp_id = $(this).val();
                    //alert(emp_id);
                    $('#emp_name').val(emp_id);
                    $('#emp_name').trigger('chosen:updated');
                });
                */
            $('#loan_type').change(function() {
                var loan_type_id = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>loan/getInterestByLoanId',
                    data: {
                        id: loan_type_id
                    },
                    dataType: 'html',
                    success: function(data) {
                        //alert(data);
                        $('#interest').val(data);
                    }
                });
            });
            setTimeout(function() {
                // $("#errors").hide("slide", {direction: "up" }, "slow"); 
                $(".alert").hide("slide", {
                    direction: "up"
                }, "slow");

            }, 5000);
        });

        function validate() {
            var valid = true;

            var msg = "<ul>";
            if (document.myForm.loan_type.value == "") {
                if (valid) { //only receive focus if its the first error
                    document.myForm.loan_type.focus();
                    document.myForm.loan_type.style.border = "solid 1px red";
                    //document.myForm.loan_type_name.style.backgroundColor="#FFA07A";
                    msg += '<li >You need to select the loan type field! <span class="glyphicon glyphicon-remove-circle"></li>';
                    valid = false;
                    // return false;
                }
            }
            if (document.myForm.emp_name.value == "") {
                if (valid) {
                    document.myForm.emp_name.focus();
                }
                document.myForm.emp_name.style.border = "solid 1px red";
                msg += '<li >You need to select employee name field! <span class="glyphicon glyphicon-remove-circle"></li>';
                valid = false;
            }
            if (document.myForm.amount.value == "") {
                if (valid) {
                    document.myForm.amount.focus();
                }
                document.myForm.amount.style.border = "solid 1px red";
                msg += '<li >You need to fill loan amount field! <span class="glyphicon glyphicon-remove-circle"></li>';
                valid = false;
            }
            if (document.myForm.installment.value == "") {
                if (valid) {
                    document.myForm.installment.focus();
                }
                document.myForm.installment.style.border = "solid 1px red";
                msg += '<li >You need to fill installment field! <span class="glyphicon glyphicon-remove-circle"></li>';
                valid = false;
            }
            if (document.myForm.disbursement_date.value == "") {
                if (valid) {
                    document.myForm.disbursement_date.focus();
                }
                document.myForm.disbursement_date.style.border = "solid 1px red";
                msg += '<li >You need to fill disbursement_date field! <span class="glyphicon glyphicon-remove-circle"></li>';
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
            }

        }
    </script>
    <style>
        .add-form {
            min-height: 350px;
        }

        select {
            margin: 0;
        }

        .col-md-4 {
            //text-align: right;
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
                    <div class="col-md-2 col-xs-12 "></div>
                    <div class="col-md-8 col-xs-12 add-form">
                        <div class="row add-form-heading">
                            <div class="col-md-12 ">

                                <i class="fas fa-hand-holding-usd" style="font-size:20px"></i> Loan Given
                            </div>
                        </div>
                        <form action="" method="POST" onSubmit="return validate();" class="myForm" id="myForm" name="myForm" enctype="multipart/form-data">
                            <div class="row success-err-sms-area">
                                <div class="col-md-12">
                                    <input type="hidden" name="content_id" id="content_id" value="<?php print $id; ?>">
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
                                        <div class="alert alert-success text-center">
                                            <strong>Success!</strong> <?php echo $error ?>
                                        </div>
                                    <?php
                                    }
                                    $error = null;
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <!-- <div class="row">
                                            <div class="col-md-4">Account:</div>
                                            <div class="col-md-8">
                                                <select name="account_id" id="account_id">
                                                <?php foreach ($accounts as $account) { ?>
                                                <option value="<?php echo $account->ID; ?>"><?php echo $account->AccountName; ?></option>
                                                <?php } ?>
                                            </select> 
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <?php
                                        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
                                        $current_date = $dt->format('d-m-Y');
                                        ?>
                                        <div class="row">
                                            <div class="col-md-4">Posting Date:</div>
                                            <div class="col-md-8">
                                                <input type="text" class='datepicker' name="trans_date" id="trans_date" value="<?php echo $current_date; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4">Loan Type *</div>
                                            <div class="col-md-8">
                                                <select name="loan_type" id='loan_type'>
                                                    <!--<option value="">--Select loan type--</option>-->
                                                    <?php
                                                    foreach ($loan_types as $loan_type) :
                                                    ?>
                                                        <option value="<?php echo $loan_type['id'];  ?>"><?php echo $loan_type['loan_type_name'];  ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4">Employee name *:</div>
                                            <div class="col-md-8">
                                                <select name='emp_name' id='emp_name' data-placeholder="Choose an Employee..." class="chosen-select">
                                                    <option value="">--Select employee name--</option>
                                                    <?php
                                                    foreach ($employees as $employee) {
                                                    ?>
                                                        <option value="<?php echo $employee['content_id'] ?>|<?php echo $employee['emp_id'] ?>|<?php echo $employee['division_tid'] ?>|<?php echo $employee['department_tid'] ?>"><?php echo $employee['emp_name'] . '-' . $employee['emp_id']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4">Amount *:</div>
                                            <div class="col-md-8">
                                                <input type="number" name="amount" id="amount" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4">Installment *:</div>
                                            <div class="col-md-8">
                                                <input type="number" name="installment" id="installment" value="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <!--                                        <div class="row">
                                            <div class="col-md-4">Amount:</div>
                                            <div class="col-md-8">
                                                <input type="number" name="amount" id="amount" value="" />
                                            </div>
                                        </div>-->
                                    </div>
                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4">Installment Amount *:</div>
                                            <div class="col-md-8">
                                                <input type="text" name="installment_amount" id="installment_amount" value="" readonly="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4">Interest (%):</div>
                                            <div class="col-md-8">
                                                <input type="number" name="interest" id="interest" value="0" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4">Penalty (%):</div>
                                            <div class="col-md-8">
                                                <input type="number" name="penalty" id="penalty" value="0" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4">Disbursement Date From *:</div>
                                            <div class="col-md-8">
                                                <input type="text" class='datepicker' name="disbursement_date" id="disbursement_date" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4">Financial Year *:</div>
                                            <div class="col-md-8">
                                                <select name="year" id="year">
                                                    <?php foreach ($years as $val) : ?>
                                                        <option value="<?php echo $val->year; ?>" <?php if ($val->year == date('Y')) {
                                                                                                        echo 'selected';
                                                                                                    } ?>><?php echo $val->year; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10 col-xs-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4">Repayment Type *:</div>
                                            <div class="col-md-8">
                                                <input type="radio" name="repayment" value="daily_repayment" /> Daily
                                                <input type="radio" style="margin-left:30px" name="repayment" value="weekly_repayment" /> Weekly
                                                <input type="radio" style="margin-left:30px" name="repayment" value="monthly_repayment" checked="" /> Monthly
                                                <input type="radio" style="margin-left:30px" name="repayment" value="yearly_repayment" /> Yearly
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-12 col-sm-12">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4">Method *:</div>
                                            <div class="col-md-8">
                                                <select name="loan_method" id="loan_method">
                                                    <option value="1">Cash</option>
                                                    <option value="2">Cheque</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-8">
                                                <input type="checkbox" checked="" name="repay_from_salary" id='repay_from_salary' value="repay_from_salary" /> <strong>Repay from salary </strong>
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
                        <?php

                        $data = $this->session->flashdata('data');
                        if ($data) {
                            // print_r($data);
                        ?>
                            <table style="width:100%" class="table table-bordered">
                                <thead>
                                    <tr style="background-color:orange;">
                                        <td>sl no</td>
                                        <td>Payment date</td>
                                        <td>Principal Amount</td>
                                        <td>Interest Amount</td>
                                        <td>Penalty Amount</td>
                                        <td>Total Payment</td>
                                        <td>Balance</td>
                                    </tr>
                                </thead>

                                <?php
                                $sl_no = 1;
                                foreach ($data as $singleData) { ?>
                                    <tr>
                                        <td><?php echo $sl_no++; ?></td>
                                        <td><?php echo $singleData->payment_date; ?></td>
                                        <td><?php echo $singleData->principal_amount; ?></td>
                                        <td><?php echo $singleData->interest_amount; ?></td>
                                        <td><?php echo $singleData->penalty_amount; ?></td>
                                        <td><?php echo $singleData->total_payment; ?></td>
                                        <td><?php echo $singleData->balance; ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php
                        }
                        $this->session->set_flashdata('data', null);
                        $data = null;
                        ?>
                    </div>

                    <div class="col-md-2 col-xs-12 "></div>

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