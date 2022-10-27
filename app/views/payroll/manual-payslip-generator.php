<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS- Payslip Generator</title>
    <!--chosen-->
    <?php
    $this->load->view('includes/cssjs');
    $userId =  $this->session->userdata('user_id');
    $user_type = $this->session->userdata('user_type');
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
                // $(".alert").hide("slide", {
                //     direction: "up"
                // }, "slow");

            }, 9000);
        });

        function validate() {
            var valid = true;

            var msg = "<ul>";
            if (document.payslipForm.emp_company.value == "") {
                if (valid) { //only receive focus if its the first error
                    document.payslipForm.emp_company.focus();
                    document.payslipForm.emp_company.style.border = "solid 1px red";
                    //document.myForm.loan_type_name.style.backgroundColor="#FFA07A";
                    msg += '<li >You need to select company! <span class="glyphicon glyphicon-remove-circle"></li>';
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
                    <p><strong>Payslip Steps: </strong><br/>
                    >> Payslip Generation <br/>
                    >> Payslip Confirmation <br/>
                    >> Payslip Check <br/>
                    >> Payslip Approve <br/>
                    >> Payslip Payment
                    

                    </p>
                    </div>
                    <div class="col-md-6 col-xs-12 add-form">
                        <div class="row add-form-heading">
                            <div class="col-md-12 ">
                                <h3><i class="fas fa-money-check-alt " style="font-size:20px"></i> Payslip Generator</h3>

                            </div>
                        </div>
                        <form action="" onsubmit=" return validate();" method="POST" class="payslipForm" id="payslipForm" name="payslipForm" enctype="multipart/form-data">
                            <div class="row success-err-sms-area">
                                <div class="col-md-12">

                                    <?php
                                    $generated = $this->session->flashdata('generated');
                                    if ($generated) {
                                    ?>
                                        <br />
                                        <div class="alert alert-success text-center">
                                            <strong>Success!</strong> <?php echo $generated ?>
                                        </div>
                                    <?php
                                    }
                                    $msg = null;

                                    $error = $this->session->flashdata('error');
                                    if ($error) {
                                    ?>
                                        <div class="alert alert-danger text-left">
                                            <strong>ERROR!</strong> <?php echo $error ?>
                                        </div>
                                    <?php
                                    }
                                    $error = null;

                                    $generate_error = $this->session->flashdata('generate_error');
                                    if ($generate_error) {
                                    ?>
                                        <div class="alert alert-danger text-center">
                                            <strong>ERROR!</strong> <?php echo $generate_error ?>
                                        </div>
                                    <?php
                                    }
                                    $generate_error = null;

                                    $exist = $this->session->flashdata('exist');
                                    if ($exist) {
                                    ?>
                                        <div class="alert alert-danger text-center">
                                            <strong>ERROR!</strong> <?php echo $exist ?>
                                        </div>
                                    <?php
                                    }
                                    $exist = null;
                                    ?>
                                </div>
                            </div>
                            <div class="row">


                                <div class="row">

                                    <div class="col-md-12 col-xs-12 col-sm-12">

                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-4 text-right">Generated Date:</div>
                                                    <div class="col-md-8">
                                                        <?php
                                                        $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
                                                        $current_date = $dt->format('d-m-Y');
                                                        $current_year = $dt->format('Y');
                                                        ?>
                                                        <input type="text" class='datepicker' name="generated_date" id="generated_date" value="<?php echo $current_date; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12 col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-4 text-right">Financial Year:</div>
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
                                                    <div class="col-md-4 text-right">Company:</div>
                                                    <div class="col-md-8">
                                                        <select name="emp_company" id="emp_company" class=" form-control">

                                                            <?php
                                                            if ($user_type == 1 || $userId == 16) {
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
                                                    <div class="col-md-4 text-right">Division:</div>
                                                    <div class="col-md-8">
                                                        <select name="emp_division" id="emp_division" class=" form-control">

                                                            <?php
                                                            if ($user_type == 1 || $userId == 16 || !$userDepartment) {
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
                                                    <div class="col-md-4 text-right">Salary month:</div>
                                                    <div class="col-md-8">
                                                        <select name="salary_month" id="salary_month" class="form-control" required>
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
                                                        <!-- <input type="checkbox" class="" name="festival_bonus" id="fastival_bonus" value="true" /> With festival bonus -->
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
                                            <div class="col-md-12"><a href="pay-slip-confirmation" class="btn btn-sm btn-info pull-left">Payslip Confirmation >></a></div>
                     
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-8">
                                                <input type="submit" name="add_btn" id="add_btn" style="width:100%;" value="Generate" />
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
                    </div>
                </div>

            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->

</body>

</html>