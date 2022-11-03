<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS- Payslip Generator</title>
    <!--chosen-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.css">
    <?php
    $this->load->view('includes/cssjs');
    ?>

    <script>
        $(document).ready(function() {

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
            if (document.myForm.emp_content_id.value == "") {
                if (valid) { //only receive focus if its the first error
                    document.myForm.emp_content_id.focus();
                    document.myForm.emp_content_id.style.border = "solid 1px red";
                    //document.myForm.loan_type_name.style.backgroundColor="#FFA07A";
                    msg += '<li >You need to select  the employee field! <span class="glyphicon glyphicon-remove-circle"></li>';
                    valid = false;
                    // return false;
                }
            }
            if (document.myForm.salary_month.value == "") {
                if (valid) {
                    document.myForm.salary_month.focus();
                }
                document.myForm.salary_month.style.border = "solid 1px red";
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

                                <i class="fas fa-money-check-alt " style="font-size:20px"></i> Payslip Generator
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
                                                    <div class="col-md-4">Generated Date:</div>
                                                    <div class="col-md-8">
                                                        <?php
                                                        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
                                                        $current_date = $dt->format('d-m-Y');
                                                        ?>
                                                        <input type="text" class='datepicker' name="generated_date" id="generated_date" value="<?php echo $current_date; ?>" />
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
                                                    <div class="col-md-4">Employee name:</div>
                                                    <div class="col-md-8">
                                                        <select name='emp_content_id' id='emp_content_id' data-placeholder="Choose an Employee..." class="chosen-select">
                                                            <option value="">--Select employee name--</option>
                                                            <?php
                                                            foreach ($employees as $employee) {
                                                            ?>
                                                                <option value="<?php echo $employee['content_id']; ?>" <?php if ($emp_id) {
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
                                                    <div class="col-md-4">Financial Year:</div>
                                                    <div class="col-md-8">
                                                        <select name="year" id="year">
                                                            <option value="2019">2019</option>
                                                            <option value="2020">2020</option>
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
                                                        <select name="salary_month" id="salary_month">
                                                            <option value=""> --select employee salary month-- </option>
                                                            <option value="01">January</option>
                                                            <option value="02">February</option>
                                                            <option value="03">March</option>
                                                            <option value="04">April</option>
                                                            <option value="05">May</option>
                                                            <option value="06">June</option>
                                                            <option value="07">July</option>
                                                            <option value="08">August</option>
                                                            <option value="09">September</option>
                                                            <option value="10">October</option>
                                                            <option value="11">November</option>
                                                            <option value="12">December</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-4"></div>
                                                    <div class="col-md-8">
                                                        <!-- <input type="checkbox" name="festival_bonus" id="fastival_bonus" value="true" /> With festival bonus -->
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
                                                <input type="SUBMIT" name="add_btn" id="add_btn" style="width:100%;" value="Generate" />
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

</body>

</html>