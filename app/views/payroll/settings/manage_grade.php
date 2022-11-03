<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS | Manage Salary Grade</title>
    <!--chosen-->
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
        td{
        background-color: none!important;
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
                        <h3>Salary Grades

                            <a href="<?php echo site_url('create-grade'); ?>" class="btn btn-md p-2 m-2 btn-warning pull-right"> <i class="fa fa-plus"></i> Add Grade</a>

                        </h3>
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
                        <!-- <a href="" class="btn btn-md p-2 m-2 btn-warning pull-right" data-toggle="modal" data-target="#addSalary"> <i class="fa fa-plus"></i> Add Grade</a> -->
                        <table id="example" class="display table" style="width:100%">
                            <thead>
                                <tr>
                                    <td></td>
                                    <th>Grade Name</th>
                                    <th>Description</th>
                                    <th>Absent Deduction Type</th>
                                    <th>Absent Deduction Fixed Amount</th>
                                    <th>Overtime Amount Type</th>
                                    <th>Overtime Rate Per Hour</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($grades as $val) : ?>
                                    <tr>
                                        <td></td>
                                        <td><?php echo $val->grade_name; ?></td>
                                        <td><?php echo $val->description; ?></td>
                                        <td><?php echo $val->absent_deduction_type; ?></td>
                                        <td><?php echo $val->absent_deduction_fixed_amount; ?></td>
                                        <td><?php echo $val->overtime_amount_type; ?></td>
                                        <td><?php echo $val->overtime_rate_per_hour; ?></td>
                                        <td><?php
                                            if ($val->status == 1) {
                                                echo "<span class='badge'>active</span>";
                                            } elseif ($val->status == 0) {
                                                echo "<span class='badge'>inactive</span>";
                                            }
                                            ?></td>
                                        <td>
                                            <?php if ($val->status == 1) { ?>
                                                <a href="<?php echo site_url('manage-grade/inactive/') . $val->id; ?>" class="btn btn-sm btn-danger">Inactive</a>
                                            <?php } elseif ($val->status == 0) { ?>
                                                <a href="<?php echo site_url('manage-grade/active/') . $val->id; ?>" class="btn btn-sm btn-success">Active</a>
                                            <?php
                                            }
                                            ?>
                                            <a href="<?php echo site_url('manage-grade/edit/') . $val->id; ?>" class="btn btn-sm btn-warning">Edit</a>
                                            <a class="btn btn-sm btn-default view" id='<?php echo $val->id; ?>'>View</a>
                                            <a class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- Start Approve Modal-->
    <div class="modal" id="view" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content view_body">

            </div>
        </div>
    </div>
    <!-- /#wrapper -->
    <!--Chosen-->
    <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.jquery.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
    <script>
        $(document).ready(function() {
            var url_prefix = "<?php echo site_url(); ?>";
            $('#example').DataTable({
                stateSave: true
            });
            $('.view').click(function(e) {
                e.preventDefault();
                var actionId = $(this).attr('id');
                if (actionId) {
                    $.ajax({
                        url: url_prefix + "view-grade",
                        dataType: 'html',
                        type: 'GET',
                        data: {
                            action_id: actionId
                        }
                    }).done(function(data) {
                        if (actionId) {
                            $(".view_body").html(data);
                            $("#view").modal("show");
                        }
                    });
                }

            });
        });
    </script>
</body>

</html>