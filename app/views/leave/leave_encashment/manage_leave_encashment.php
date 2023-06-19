<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS | Leave Encashment</title>
    <!--chosen-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.css">

    <?php
    $this->load->view('includes/cssjs');
    $userId =  $this->session->userdata('user_id');

    $userDivision =  $this->session->userdata('user_division');
    $userDepartment =  $this->session->userdata('user_department');
    ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.form.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#loader").hide();
            setTimeout(function() {
                // $("#errors").hide("slide", {direction: "up" }, "slow"); 
                $(".alert").hide("slide", {
                    direction: "up"
                }, "slow");

            }, 9000);
        });
    </script>
    <style>
        .modal-xl {
            width: 90%;
            max-width: 1200px;
        }

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

        td {
            height: 40px;
            vertical-align: middle !important;
        }

        .chosen-container.chosen-container-single {
            width: 100% !important;
            /* or any value that fits your needs */
        }

        .close-btn {
            border-radius: 50px;
            min-width: 200px;
            padding: 10px 20px;
        }

        .submit-btn {
            border-radius: 50px;
            font-size: 18px;
            font-weight: 600;
            min-width: 200px;
            padding: 10px 20px;
        }

        .custom-btn {
            border-radius: 50px;
        }

        .btn-primary {
            background-color: #ff9b44;
            border: 1px solid #ff9b44;
        }

        fieldset.scheduler-border {
            border: 1px dotted #FF7F50 !important;
            padding: 1em 1.4em 0.4em 1.4em !important;
            margin: 0 0 0.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
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
                    <div class="col-md-12 col-xs-12 ">
                        <h3>Leave Encashment</h3>
                        <hr>
                        <form id="Search_form" action="" method="GET">
                            <fieldset>
                                <!-- <legend>Filter Section</legend> -->
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="staff">Select Staff *:</label>
                                            <?php if (isset($edit_data)) { ?>
                                                <input type="hidden" name="search_content_id" id="" value="<?php echo $edit_data->content_id; ?>" />
                                            <?php } ?>
                                            <select name="search_content_id" id="search_content_id" <?php if (isset($edit_data)) {
                                                                                                        echo "disabled";
                                                                                                    } ?> data-placeholder="Choose a staff..." class="chosen-select" >
                                                <option value="">Choose a staff...</option>
                                                <?php foreach ($active_employees as $key => $empVal) : ?>
                                                    <option value="<?php echo $empVal->content_id; ?>"  <?php if (($this->input->get('search_content_id') == $empVal->content_id)) {
                                                                                                        echo "selected='selected'";
                                                                                                    } ?>><?php echo $empVal->emp_id . ' | ' . $empVal->emp_name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Leave Type *</label>
                                            <select class="form-select"  name="search_leave_type_id" id="search_leave_type_id" >
                                                <option value="">--select leave type--</option>
                                                <?php foreach ($leave_types as $leave_type) : ?>
                                                    <option value="<?php echo $leave_type->id; ?>" <?php if (($this->input->get('search_leave_type_id') == $leave_type->id)) {
                                                                                                        echo "selected='selected'";
                                                                                                    } ?>><?php echo $leave_type->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control search_datepicker" name="date_from" aria-label="Date From" placeholder="Date From" value="<?php echo $this->input->get('date_from');?>">
                                                <span class="input-group-addon">to</span>
                                                <input type="text" class="form-control search_datepicker" name="date_to" aria-label="Date To" placeholder="Date To" value="<?php echo $this->input->get('date_to');?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button type="submit" name="submit-btn" value="submit" class="btn btn-primary">Filter Data</button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>

                        <?php
                        $msg = $this->session->flashdata('message');
                        if ($msg) {
                        ?>
                            <div class="alert alert-info text-center">
                                <strong><?php echo $msg ?></strong>
                            </div>
                        <?php
                        }
                        $msg = null;
                        ?>
                        <a href="" class="btn custom-btn btn-warning pull-right addLeaveEncashment" data-toggle="modal" data-target="#addLeaveEncashment" id="add_leave_encashment"> <i class="fa fa-plus"></i> Add Leave Encashment</a>
                        <table id="example" class="display compact table" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Employee</th>
                                    <th>Employee ID</th>
                                    <th>Encashment Date</th>
                                    <th>Leave Type</th>
                                    <th>Days</th>
                                    <th>Per day Amount</th>
                                    <th>Encashed Amount</th>
                                    <th>Payment Type</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                #dd($leave_encashments);
                                foreach ($records as $k => $val) : ?>
                                    <tr>
                                        <td><?php echo $k + 1; ?></td>
                                        <td>
                                            <div class="row">

                                                <span class="" style="color:orangered;font-weight:bold"><?php echo $val->emp_name; ?></span><br />
                                                <!-- <span class="" style="color:gray;"><?php echo $val->designation_name; ?></span> -->

                                            </div>
                                        </td>
                                        <td><?php echo $val->emp_id; ?></td>
                                        <td><?php echo date("F jS, Y", strtotime($val->encashment_date)); ?></td>
                                        <td><?php echo $val->leave_type_name; ?></td>
                                        <td><?php echo $val->encashed_days; ?></td>
                                        <td style="font-weight:bold">৳ <?php echo number_format($val->per_day_amount); ?></td>
                                        <td style="font-weight:bold">৳ <?php echo number_format($val->encashment_amount); ?></td>


                                        <td><?php echo $val->payment_type; ?></td>
                                        <td><?php echo $val->remarks; ?></td>
                                        <td>
                                            <a class="btn custom-btn btn-sm btn-default edit_leave_encashment" id='<?php echo $val->id; ?>' href="#"><span class="glyphicon glyphicon-edit"> </span> Edit</a>
                                            <!-- <a class="btn custom-btn btn-sm btn-default view_salary" id="<?php echo $val->id; ?>" href="#"><span class="glyphicon glyphicon-eye-open"> </span> View</a> -->
                                            <a class="btn custom-btn btn-sm btn-danger" onclick="return confirm('You are not allow to delete this item?');">
                                                <span class="glyphicon glyphicon-remove-sign disabled" disabled="disabled"> </span> Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- Add/Edit Modal -->
                        <div class="modal fade" id="addLeaveEncashment" role="dialog" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div id="dynamic-body"></div>
                            </div>
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
    <script>
        $(document).ready(function() {
            var url_prefix = "<?php echo site_url(); ?>";
            $('#example').DataTable({
                stateSave: true,
            });
            $('.search_datepicker').datepicker({
                viewMode: 'days',
                // format: 'd-m-Y',
                showTodayButton: true,
                dateFormat: 'yy-mm-dd',
                maxDate: 0
            });

            $(".chosen-select").chosen();
            $('#add_leave_encashment').click(function(e) {
                $.ajax({
                    url: url_prefix + "add-leave-encashment",
                    dataType: 'html',
                    type: 'GET',
                    data: {

                    }
                }).done(function(data) {

                    $("#dynamic-body").html(data);
                    $("#addLeaveEncashment").modal("show");

                });
            });
            $(document).on("click", ".edit_leave_encashment", function(event) {
                edit_id = $(this).attr('id');
                if (edit_id) {
                    $.ajax({
                        url: url_prefix + "edit-leave-encashment",
                        dataType: 'html',
                        type: 'GET',
                        data: {
                            edit_id: edit_id
                        }
                    }).done(function(data) {
                        $("#dynamic-body").html(data);
                        $("#addLeaveEncashment").modal("show");
                    });
                }
            });

            $(".chosen-select").chosen();


        });
    </script>
</body>

</html>