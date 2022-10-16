<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS-Loan Payment</title>
    <!--chosen-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.css">
    <?php
    $this->load->view('includes/cssjs');
    ?>

    <script>
        $(document).ready(function() {
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
            $("#emp_name").change(function() {
                var result = $(this).val().split('-');;
                var content_id = result[0];
                var emp_id = result[1];
                var emp_name = result[2];
                var year = $('#year').val();
                //                    $.ajax({
                //                        type: 'POST',
                //                        url : '<?php echo base_url() ?>loan/getDueLoanByEmployeeId',
                //                        data : {
                //                            content_id : content_id,
                //                            year : year
                //                        },
                //                        dataType: 'html',
                //                        cache : false,
                //                        success: function (data){  
                //                           // alert(data);
                //                            $('#due_loan_display').html(data);
                //                            $('#emp_loan_id').html(data);
                //                        },
                //                        error : function(){
                //                            alert('ERROR!');
                //                        }
                //                    });
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() ?>loan/getDueLoanIdByEmployeeId',
                    data: {
                        content_id: content_id,
                        year: year
                    },
                    dataType: 'json',

                    success: function(data) {
                        // alert(data);
                        var options = "";
                        options += '<option value="">--select loan id--</option>';
                        $(data).each(function(index, item) {
                            options += '<option value="' + item.id + '">#00' + item.id + '</option>';
                        });
                        $('#emp_loan_id').html(options);
                        options = "";
                    },
                    error: function() {
                        alert('ERROR!');
                    }
                });


            });
            $("#emp_loan_id").change(function() {
                var result = $("#emp_name").val().split('-');;
                var content_id = result[0];
                var emp_id = result[1];
                var emp_name = result[2];
                var year = $('#year').val();
                var loan_id = $(this).val();
                var date_result = $('#posting_date').val().split('-');
                var day = date_result[0];
                var month = date_result[1];
                var year = date_result[2];
                var posting_date = year + '-' + month + '-' + day;
                //alert(emp_name);
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() ?>loan/getLoanDisbursmentPaymentDataByLoanId',
                    data: {
                        loan_id: loan_id
                    },
                    dataType: 'json',
                    cache: false,
                    success: function(data) {
                        var date1 = new Date(data.payment_date);
                        var date2 = new Date(posting_date);
                        // alert(date2);
                        var penalty_amount = 0;
                        if (date2 > date1) {
                            penalty_amount = data.penalty_amount;
                        }
                        var total_installment = parseInt(data.principal_amount) + parseInt(data.interest_amount) + parseInt(penalty_amount);
                        $('#disbursement_id').val(data.id);
                        $('#payment_date').val(data.payment_date);
                        $('#principal_amount').val(data.principal_amount);
                        $('#interest_amount').val(data.interest_amount);
                        $('#penalty_amount').val(penalty_amount);
                        $('#total_installment_amount').val(total_installment);

                    },
                    error: function() {
                        alert('ERROR!');
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() ?>loan/getLoanDisbursmentDataByLoanId',
                    data: {
                        loan_id: loan_id
                    },
                    dataType: 'html',
                    cache: false,
                    success: function(data) {
                        // alert(data);
                        $('#disbursement').html(data);
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
            if (document.myForm.emp_loan_id.value == "") {
                if (valid) {
                    document.myForm.emp_loan_id.focus();
                }
                document.myForm.emp_loan_id.style.border = "solid 1px red";
                msg += '<li >You need to select loan id field! <span class="glyphicon glyphicon-remove-circle"></li>';
                valid = false;
            }
            if (document.myForm.principal_amount.value == "") {
                if (valid) {
                    document.myForm.principal_amount.focus();
                }
                document.myForm.principal_amount.style.border = "solid 1px red";
                msg += '<li >You need to fill the principal amount field! <span class="glyphicon glyphicon-remove-circle"></li>';
                valid = false;
            }
            if (document.myForm.total_installment_amount.value == "") {
                if (valid) {
                    document.myForm.total_installment_amount.focus();
                }
                document.myForm.total_installment_amount.style.border = "solid 1px red";
                msg += '<li >You need to fill the total amount field! <span class="glyphicon glyphicon-remove-circle"></li>';
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

                                <i class="fas fa-hand-holding-usd" style="font-size:20px"></i> Loan Repayment/ Recover
                            </div>
                        </div>
                        <form action="" method="POST" onSubmit="return validate();" class="myForm" id="myForm" name="myForm" enctype="multipart/form-data">
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

                                    <div class="col-md-12 col-xs-12 col-sm-12">

                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-4">Posting Date:</div>
                                                    <div class="col-md-8">
                                                        <?php
                                                        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
                                                        $current_date = $dt->format('d-m-Y');
                                                        ?>
                                                        <input type="text" class='datepicker' name="posting_date" id="posting_date" value="<?php echo $current_date; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="row">                                    
                                                <div class="col-md-12 col-xs-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-4">Account:</div>
                                                        <div class="col-md-8">
                                                             <select name="account_id" id="account_id">
                                                                <?php foreach ($accounts as $account) { ?>
                                                                <option value="<?php echo $account->ID; ?>"><?php echo $account->AccountName; ?></option>
                                                                <?php } ?>
                                                             </select> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-4">Financial Year:</div>
                                                    <div class="col-md-8">
                                                        <select name="year" id="year">
                                                            <?php foreach ($years as $val) : ?>
                                                                <option value="<?php echo $val->year; ?>" <?php echo $val->year == date('Y') ? 'selected' : ''; ?>><?php echo $val->year; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                                                <option value="<?php echo $employee['content_id'] . '-' . $employee['emp_id'] . '-' . $employee['emp_name'] ?>" <?php if ($emp_id) {
                                                                                                                                                                                    if ($emp_id == $employee['emp_id']) {
                                                                                                                                                                                        echo "selected='selected'";
                                                                                                                                                                                    }
                                                                                                                                                                                } ?>>
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
                                                    <div class="col-md-4">Emp Loan ID:</div>
                                                    <div class="col-md-8">
                                                        <select name="emp_loan_id" id="emp_loan_id">

                                                        </select>
                                                        <input type="hidden" name="disbursement_id" id="disbursement_id" value="" />
                                                        <input type="hidden" name="payment_date" id="payment_date" value="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-4">Principal Amount:</div>
                                                    <div class="col-md-8">
                                                        <input type="number" readonly name="principal_amount" id="principal_amount" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-4">Interest Amount:</div>
                                                    <div class="col-md-8">
                                                        <input type="number" readonly name="interest_amount" id="interest_amount" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-4">Penalty Amount:</div>
                                                    <div class="col-md-8">
                                                        <input type="number" readonly name="penalty_amount" id="penalty_amount" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-4">Total Amount:</div>
                                                    <div class="col-md-8">
                                                        <input type="number" readonly name="total_installment_amount" id="total_installment_amount" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-4">Payment Method:</div>
                                                    <div class="col-md-8">
                                                        <select name="payment_method" id="payment_method">
                                                            <option value="1">Cash</option>
                                                            <option value="2">Cheque</option>
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
                <div id='due_loan_display'>

                </div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div id="disbursement" class="col-md-10">

                    </div>
                    <div class="col-md-1"></div>
                </div>

                <?php
                // $this->load->view('loan/report/disbursement', true);
                ?>
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
        $(document).on('keyup', '#principal_amount,#interest_amount,#penalty_amount', function() {
            totalAmount();
        });

        function totalAmount() {
            var principal_amount = Number($('#principal_amount').val());
            var interest_amount = Number($('#interest_amount').val());
            var penalty_amount = Number($('#penalty_amount').val());
            var total_amount = principal_amount + interest_amount + penalty_amount;
            $('#total_installment_amount').val(total_amount);
        }
    </script>
</body>

</html>