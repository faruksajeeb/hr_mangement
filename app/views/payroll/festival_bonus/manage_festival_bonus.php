<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS | Festival Bonus</title>
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

                <br />
                <div class="row">
                    <div class="col-md-12 col-xs-12 ">
                        <h3>Festival Bonus</h3>
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
                        <a href="" class="btn custom-btn btn-warning pull-right addDivisionFestivalBonus" data-toggle="modal" data-target="#addDivisionFestivalBonus" id="add_division_festival_bonus" style="margin:0 5px;"> <i class="fa fa-plus"></i> Add Division Festival Bonus</a>
                        <a href="" class="btn custom-btn btn-warning pull-right addFestivalBonus" data-toggle="modal" data-target="#addFestivalBonus" id="add_festival_bonus"> <i class="fa fa-plus"></i> Add Single Festival Bonus</a>
                        <table id="example" class="display compact table" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Employee</th>
                                    <th>Employee ID</th>
                                    <th>Adjust Month(mm/yy)</th>
                                    <th>Payment Type</th>
                                    <th>Amount</th>
                                    <th>Payment Date</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                #dd($festival_bonuss);
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
                                        <td><?php
                                        $dt = DateTime::createFromFormat('!m', $val->adjust_month);
                                        $adjust_month = $dt->format('F');
                                        
                                        
                                        echo $adjust_month.', '.$val->adjust_year; ?></td>
                                        <td><?php echo $val->payment_type; ?></td>
                                        <td style="font-weight:bold">৳ <?php echo number_format($val->amount); ?></td>                                        
                                        <td><?php echo date("F jS, Y", strtotime($val->payment_date)); ?></td>
                                        <td><?php echo $val->remarks; ?></td>
                                        <td>
                                            <a class="btn custom-btn btn-sm btn-default edit_festival_bonus" id='<?php echo $val->id; ?>' href="#"><span class="glyphicon glyphicon-edit"> </span> Edit</a>
                                            <!-- <a class="btn custom-btn btn-sm btn-default view_salary" id="<?php echo $val->id; ?>" href="#"><span class="glyphicon glyphicon-eye-open"> </span> View</a> -->
                                            <a class="btn custom-btn btn-sm btn-danger"  onclick="return confirm('You are not allow to delete this item?');">
                                                <span class="glyphicon glyphicon-remove-sign"> </span> Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- Add/Edit Modal -->
                        <div class="modal fade" id="addFestivalBonus" role="dialog" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div id="dynamic-body"></div>
                            </div>
                        </div>
                        <!-- Add Division Wise Festival Bonus -->
                        <div class="modal fade" id="addDivisionFestivalBonus" role="dialog" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div id="division-dynamic-body"></div>
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

            $('#add_festival_bonus').click(function(e) {
                $.ajax({
                    url: url_prefix + "add-festival-bonus",
                    dataType: 'html',
                    type: 'GET',
                    data: {

                    }
                }).done(function(data) {

                    $("#dynamic-body").html(data);
                    $("#addFestivalBonus").modal("show");

                });
            });
            $('#add_division_festival_bonus').click(function(e) {
                $.ajax({
                    url: url_prefix + "add-division-festival-bonus",
                    dataType: 'html',
                    type: 'GET',
                    data: {

                    }
                }).done(function(data) {
                    $("#division-dynamic-body").html(data);
                    $("#addDivisionFestivalBonus").modal("show");

                });
            });
            $(document).on("click", ".edit_festival_bonus", function(event) {
                edit_id = $(this).attr('id');
                if (edit_id) {
                    $.ajax({
                        url: url_prefix + "edit-festival-bonus",
                        dataType: 'html',
                        type: 'GET',
                        data: {
                            edit_id: edit_id
                        }
                    }).done(function(data) {
                        $("#dynamic-body").html(data);
                        $("#addFestivalBonus").modal("show");
                    });
                }
            });
      
            $(".chosen-select").chosen();


        });
    </script>
</body>

</html>