<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS | Movement Order Form </title>
    <!--chosen-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.css">

    <?php
    $this->load->view('includes/cssjs');
    ?>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <script>
        $(document).ready(function() {



            $('.chosen-container').css({
                'width': '350px'
            });



        });

        function ConfirmDelete() {
            var x = confirm("Are you sure you want to delete?");
            if (x)
                return true;
            else
                return false;
        }

        function validate() {
            var valid = true;
            var msg = "<ul>";
            if (document.myForm.vendor_name.value == "") {
                if (valid) { //only receive focus if its the first error
                    document.myForm.vendor_name.focus();
                    document.myForm.vendor_name.style.border = "solid 1px red";
                    msg += "<li>You need to fill the vendor name field!</li>";
                    valid = false;
                    // return false;
                }
            }
            if (document.myForm.contact_person.value == "") {
                if (valid) { //only receive focus if its the first error
                    document.myForm.contact_person.focus();
                    document.myForm.contact_person.style.border = "solid 1px red";
                    msg += "<li>You need to fill contact_person field!</li>";
                    valid = false;
                    // return false;
                }
            }

            if (!valid) {
                msg += "</ul>";
                //console.log("Hello Bd");
                var div = document.getElementById('errors').innerHTML = msg;
                document.getElementById("errors").style.display = 'block';
                return false;
            }

        }
    </script>
    <style>



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
                <div class="col-md-12">

                    <div id="errors" style='color:red;text-align:right'></div>

               
                </div>
                <div class="row">
                    <!-- <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"> 
                                <a href="<?php echo base_url(); ?>admin-movement-orders" class="btn btn-sm btn-primary">Employee Movement Orders </a>
                            </div> -->
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-md-offset-4" style="background-color:#79a6d2;padding-bottom: 10px;">
                        <div class="card">
                            <div class="card-header under-header-bar" style="text-align: center; padding-top:20px">
                                <h1>Daily Movement Order</h1>
                            </div>
                            <?php

                            if ($msg=$this->session->flashdata('success')) {
                            ?>
                                <br />
                                <div class="alert alert-success text-center">
                                    <strong>Success!</strong> <?php echo $msg ?>
                                </div>
                            <?php
                            } elseif ($msg=$this->session->flashdata('error')) {
                            ?>
                                <br />
                                <div class="alert alert-danger text-center">
                                    <strong>Error!</strong> <?php echo $msg ?>
                                </div>
                            <?php } ?>
                            <div class="card-body">

                                <form class="" action="<?php echo base_url(); ?>empattendance/saveAdminMovementOrder" method="POST">
                                    <input type="hidden" name="edit_movement_id" ID="edit_movement_id" value="<?php if ($edit_info) {
                                                                                                                    echo $edit_info['id'];
                                                                                                                } ?>" />
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="label">Employee Name <span style="color:red">*</span>:</label>
                                            <select name="content_id" id="content_id" data-placeholder="Choose an Employee..." class="chosen-select form-control" required="">
                                                <option value=""></option>
                                                <?php
                                                $edit_content_id = $edit_info['content_id'];
                                                foreach ($allemployee as $single_employee) {
                                                    $content_id = $single_employee['content_id'];
                                                    $emp_id = $single_employee['emp_id'];
                                                    $emp_name = $single_employee['emp_name'];
                                                    if ($edit_content_id == $content_id) {
                                                        echo '<option value="' . $content_id . '" selected="selected">' . $emp_name . '-' . $emp_id . '</option>';
                                                    } else {
                                                        echo '<option value="' . $content_id . '">' . $emp_name . '-' . $emp_id . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="label">Date Of Movement <span style="color:red">*</span>:</label>
                                        <input value="<?php if ($edit_info) {
                                                            echo $edit_info['attendance_date'];
                                                        } ?>" class="form-control datepicker" data-date-format="mm/dd/yyyy" type="text" name="date_of_movement" id="date_of_movement" required="" />
                                    </div>

                                    <div class="form-group">
                                        <label class="label">Work Location <span style="color:red">*</span>:</label>
                                        <input value="<?php if ($edit_info) {
                                                            echo $edit_info['work_location'];
                                                        } ?>" class="form-control " type="text" name="work_location" id="work_location" required="" />
                                    </div>

                                    <!--                            <div class="form-group">
                                                                    <label class="label">Res. Hand Over:</label>
                                                                    <input class="form-control" type="text" name="res_hand_over" id="res_hand_over"/>
                                                                </div>-->
                                    <div class="form-group">
                                        <label class="label">Contact Number:</label>
                                        <input value="<?php if ($edit_info) {
                                                            echo $edit_info['contact_number'];
                                                        } ?>" class="form-control" type="text" name="contact_number" id="contact_number" />
                                    </div>
                                    <div class="form-group">
                                        <label for="type_of_movement" class="label">Informed Earlier For Such Movement:</label>
                                        <br />
                                        <label class="radio-inline"><input type="radio" name="informed_earlier" value="yes" checked <?php if ($edit_info['informed_earlier'] == "yes") {
                                                                                                                                        echo "checked";
                                                                                                                                    } ?>> Yes</label>
                                        <label class="radio-inline"><input type="radio" name="informed_earlier" value="no" <?php if ($edit_info['informed_earlier'] == "no") {
                                                                                                                                echo "checked";
                                                                                                                            } ?>> No</label>
                                    </div><br />
                                    <div class="form-group">
                                        <label for="type_of_movement" class="label">Type Of Movement <span style="color:red">*</span>:</label>
                                        <select name="type_of_movement" id="type_of_movement" class="form-control" required="">
                                            <option value="official" <?php if ($edit_info['type_of_movement'] == "official") {
                                                                            echo "selected='selected'";
                                                                        } ?>>Official</option>
                                            <option value="personal" <?php if ($edit_info['type_of_movement'] == "personal") {
                                                                            echo "selected='selected'";
                                                                        } ?>>Personal</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="label">Justification/ Reason <span style="color:red">*</span>:</label>
                                        <textarea name="reason" id="reason" class="form-control" required=""><?php if ($edit_info) {
                                                                                                                    echo $edit_info['reason'];
                                                                                                                } ?></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="label in">Out/ Start Time: </label><br>
                                            <div class="input-group-text">[24 H. Format] </div>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">

                                                </div>
                                                <input value="<?php if ($edit_info) {
                                                                    echo $edit_info['out_time'];
                                                                } ?>" type="text" class="form-control timepicker" id="out_time" name="out_time" placeholder="Eg.11:00">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="label">Expected Return/ In Time:</label>
                                            <div class="input-group-text">[24 H. Format] </div>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">

                                                </div>
                                                <input value="<?php if ($edit_info) {
                                                                    echo $edit_info['expected_in_time'];
                                                                } ?>" type="text" class="form-control timepicker" name="in_time" id="in_time" placeholder="Eg.19:00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="label">Location From:</label>
                                            <input value="<?php if ($edit_info) {
                                                                echo $edit_info['location_from'];
                                                            } ?>" class="form-control " type="text" name="location_form" id="location_form" />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="label">Location To:</label>
                                            <input value="<?php if ($edit_info) {
                                                                echo $edit_info['location_to'];
                                                            } ?>" class="form-control " type="text" name="location_to" id="location_to" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="label">Possibility Of Return:</label>
                                        <br />
                                        <label class="radio-inline"><input type="radio" name="possibility_of_return" value="yes" checked <?php if ($edit_info['possibility_of_return'] == "yes") {
                                                                                                                                                echo "checked";
                                                                                                                                            } ?>> Yes</label>
                                        <label class="radio-inline"><input type="radio" name="possibility_of_return" value="no" <?php if ($edit_info['possibility_of_return'] == "no") {
                                                                                                                                    echo "checked";
                                                                                                                                } ?>> No</label>
                                    </div><br />
                                    <div class="form-group">
                                        <button class="btn btn-primary pull-right under-header-bar" type="submit" name="save_leave" id="save_leave"> <?php if ($edit_info) {
                                                                                                                                                            echo "Save Changes";
                                                                                                                                                        } else {
                                                                                                                                                            echo "SUBMIT";
                                                                                                                                                        } ?> </button>
                                    </div>
                                    <br />
                                </form>
                            </div>
                            <div class="card-footer"></div>
                        </div>

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
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js">

    </script>
    <script>
        $(function() {
            $(".chosen-select").chosen();
            //                alert(0);
            $(".datepicker").datepicker({
                dateFormat: 'dd-mm-yy'
            });
            $('input.timepicker').timepicker({
                //             timeFormat: 'h:mm p',
                timeFormat: 'H:mm',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
        });
    </script>
</body>

</html>