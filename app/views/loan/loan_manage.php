<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS | Manage Loan</title>
    <!--chosen-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.css">
    <!-- XEditable -->
    <link rel="stylesheet" href="<?php echo site_url(); ?>plugins/xeditable/bootstrap-editable.css">

    <?php
    $this->load->view('includes/cssjs');
    $userId =  $this->session->userdata('user_id');

    $userDivision =  $this->session->userdata('user_division');
    $userDepartment =  $this->session->userdata('user_department');
    ?>

    <script>
        $(document).ready(function() {
            var company_id = '11'; // IIDFC Company ID
            $("select#emp_company").val(company_id).trigger('change');
            dependableBranch(company_id);

            $("#emp_company").change(function(e) {
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
            setTimeout(function() {
                // $("#errors").hide("slide", {direction: "up" }, "slow"); 
                $(".alert").hide("slide", {
                    direction: "up"
                }, "slow");

            }, 9000);
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

        function confirmDelete() {
            var x = confirm("Are you sure you want to delete this loan?");
            if (x)
                return true;
            else
                return false;
        }
    </script>
    <style>
        .add-form {
            min-height: 80px;
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

        .editable-container.editable-inline {
            display: inline;
        }

        .editable-input {
            width: 50%;
        }

        .some_class {
            width: 100% !important;
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

                    <div class="col-md-12 col-xs-12 add-form">
                        <div class="row add-form-heading">
                            <div class="col-md-12 ">

                                <i class="fas fa-hand-holding-usd" style="font-size:20px"></i> Manage Loan
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <form action="" method="POST" onSubmit="return validate();" class="myForm" id="myForm" name="myForm" enctype="multipart/form-data">
                                    <div class="row success-err-sms-area">
                                        <div class="col-md-12">
                                            <input type="hidden" name="content_id" id="content_id" value="<?php print $id; ?>">
                                            <div id="errors" style='color:red;text-align:right'></div>


                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Company</label>
                                        <select name="emp_company" id="emp_company" class="">
                                            <?php
                                            if ($userId == 1) {
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
                                    <div class="form-group">
                                        <label for="">Division/ Branch</label>
                                        <select name="emp_division" id="emp_division" class="">
                                            <?php
                                            if ($userId == 1 || !$userDepartment) {
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
                                    <div class="form-group">
                                        <label for="">Financial Year</label>
                                        <select name="year" id="year">
                                            <?php foreach ($years as $val) : ?>
                                                <option value="<?php echo $val->year ?>" <?php echo $val->year == date('Y') ? 'selected' : ''; ?>><?php echo $val->year ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="form-control-lg" name="search_btn" id="search_btn" value="Search" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
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

            <div id="progress-div" style="display:none;">
                <div id="progress-bar"></div>
            </div>
            <?php if ($loans) { ?>
                <br />

                <div class="row">
                    <div class="col-md-12" style="border:1px solid #ccc; padding: 5px;">


                        <div class="row" style="padding:10px; background: #ffcc66;">
                            <div class="col-md-4" style="font-weight:bold;">Company Name: <?php echo $company_name ?></div>
                            <div class="col-md-4" style="font-weight:bold;">Division Name: <?php echo $division_name ?></div>
                            <div class="col-md-4" style="text-align:right">Financial Year: <?php echo $year; ?></div>
                        </div>
                        <table style="width:100%;" class="table table-sm">
                            <tr>
                                <th>SL No.</th>
                                <th>Loan ID</th>
                                <th>Emp name</th>
                                <th>Given Date</th>
                                <th>Loan Type</th>
                                <th>Repayment Type:</th>
                                <th>Repay From</th>
                                <th style="text-align:right;">Amount</th>
                                <!--<th style="text-align:right;">Interest(%)</th>-->
                                <!--<th style="text-align:right;">Penalty(%)</th>-->
                                <th style="text-align:right;">Installment</th>
                                <th style="text-align:right;">Paid Installment</th>
                                <th style="text-align:right;">Balance</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>

                            <?php
                            $sl_no = 1;
                            foreach ($loans as $loan) {
                            ?>

                                <tr>
                                    <td><?php echo $sl_no++; ?></td>
                                    <td><a class="loan_disbursement" id="<?php echo $loan->id ?>"><?php echo '#00' . $loan->id ?></a></td>
                                    <td><?php echo $loan->emp_name; ?></td>
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
                                                                    echo "৳ " . number_format($loanAmount, 2); ?></td>
                                    <!--                                            <td style="text-align:right;"><?php echo $loan->interest; ?></td>-->
                                    <!--<td style="text-align:right;"><?php echo $loan->penalty; ?></td>-->
                                    <td style="text-align:right;"><?php echo $loan->installment; ?></td>
                                    <td style="text-align:right;"><?php echo $loan->paid_installment; ?></td>
                                    <td style="text-align:right;"><?php $dueAmount = $loan->balance;
                                                                    echo "৳ " . number_format($dueAmount, 2); ?></td>
                                    <td><?php
                                        if ($loan->balance > 0) {
                                            echo 'due';
                                        } else {
                                            echo 'paid';
                                        }
                                        ?></td>
                                    <td>
                                        <a title="Delete Loan" onclick="return confirmDelete();" href="<?php echo site_url(); ?>delete-loan/<?php echo $loan->id; ?>" class=" btn btn-sm btn-danger " style="font-weight:bold"> x </a>

                                    </td>
                                </tr>

                            <?php
                                $totalLoanAmount += $loanAmount;
                                $totalDueAmount += $dueAmount;
                            }
                            ?>
                            <th>TOTAL</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align:right;"><?php echo "৳ " . number_format($totalLoanAmount); ?></th>
                            <!--<th></th>-->
                            <!--<th></th>-->
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
    <!-- XEditable -->
    <script src="<?php echo site_url(); ?>plugins/xeditable/bootstrap-editable.min.js"></script>
</body>

</html>