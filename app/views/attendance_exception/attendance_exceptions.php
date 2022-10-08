<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS | Manage Attendance Exceptions </title>
    <!--chosen-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.css">
    <!-- XEditable -->
    <link rel="stylesheet" href="<?php echo site_url(); ?>plugins/xeditable/bootstrap-editable.css">
    <?php
    $this->load->view('includes/cssjs');
    ?>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            $('.edit_data').editable({
                validate: function(value) {
                    if ($.trim(value) == '')
                        return 'This field is required';
                }
            });

            $('.first_approve_status').editable({
                prepend: "-- select status --",
                showbuttons: false,
                source: [{
                    value: '0',
                    text: "Pending"

                }, {
                    value: '1',
                    text: "Approved"

                }, {
                    value: '-1',
                    text: "Declined"

                }, ]
            });

            $('.chosen-container').css({
                'width': '350px'
            });
            // Setup - add a text input to each footer cell
            $('#example tfoot th').each(function() {
                var title = $('#example thead th').eq($(this).index()).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            });

            // DataTable
            var table = $('#example').DataTable();

            // Apply the search
            table.columns().eq(0).each(function(colIdx) {
                $('input', table.column(colIdx).footer()).on('keyup change', function() {
                    table
                        .column(colIdx)
                        .search(this.value)
                        .draw();
                });
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
        .editable-container.editable-inline {
            display: inline;
        }

        .editable-input {
            width: 50%;
        }

        .editable-select {
            width: 50%;
        }

        .some_class {
            width: 100% !important;
        }

        .select_class {
            width: 200px !important;
        }

        tr td {
            padding: 0 !important;
            margin: 0 !important;
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
            <div class="row under-header-bar text-center">
                <h4>Attendance Exceptions</h4>
            </div>
            <div class="wrapper">
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
                <div class="row">

                    <div class="col-md-12 col-xs-12 display-list">
                    <form action="" method="POST">
                        <div class="row">                            
                            <div class="col-md-3">
                                <select name="content_id" id="content_id"  data-placeholder="Choose an Employee..." class="chosen-select form-control">
                                    <option value="" <?php if(set_value('content_id')==""){ echo "selected";}?>>--select employee--</option>
                                    <?php foreach($employees as $val):?>
                                    <option value="<?php echo $val->content_id; ?>" <?php if(set_value('content_id')==$val->content_id){ echo "selected";}?>><?php echo $val->emp_name.' ('.$val->emp_id.')'; ?></option>
                                    <?php endforeach; ?>

                                </select>                                
                            </div>
                            <div class="col-md-3">
                                <select name="search_status" id="search_status" class="form-control">
                                    <option value="" <?php if(set_value('search_status')==""){ echo "selected";}?>>--select status--</option>
                                    <option value="0"  <?php if(set_value('search_status')==0){ echo "selected";}?>>Pending</option>
                                    <option value="1"  <?php if(set_value('search_status')==1){ echo "selected";}?>>Approved</option>
                                    <option value="-1"  <?php if(set_value('search_status')==-1){ echo "selected";}?>>Declined</option>
                                </select>                                
                            </div>
                            <div class="col-md-3">
                                <input type="submit" value="Search" class="btn btn-xs btn-success"/>
                            </div>
                        </div>
                        </form>
                        <table id="example" class="table  table-responsive table-sm table-bordered ">
                            <thead>
                            <th>Sl No.</th>
                                    <th>Date</th>
                                    <th>Emp ID</th>
                                    <th>Emp Name</th>
                                    <th>Emp Division</th>
                                    <th>Type Of Application</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <!-- <th></th> -->
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Date</th>
                                    <th>Emp ID</th>
                                    <th>Emp Name</th>
                                    <th>Emp Division</th>
                                    <th>Type Of Application</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <!-- <th></th> -->
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $slNo = 1;
                                foreach ($attendance_exceptions as $val) {
                                ?>
                                    <tr>
                                        <td><?php echo $slNo++; ?></td>
                                        <td><?php echo $val->attendance_date ?></td>
                                        <td><?php echo $val->emp_id ?></td>
                                        <td><?php echo $val->emp_name ?></td>
                                        <td><?php echo $val->emp_division; ?></td>
                                        <td><?php echo $val->exception_type; ?></td>
                                        <td><?php echo $val->reason; ?></td>
                                        <td style="font-style:italic;text-align:center">
                                            <a href="#" rel="tooltip" data-placement="top" data-inputclass="select_class" class="first_approve_status" id="status" data-type="select" data-title="Change Status" data-pk="<?php echo $val->id; ?>" data-url="<?php echo base_url(); ?>AttendanceExceptionController/updateStatus">
                                                <?php
                                                if ($val->status == 0) {
                                                    echo '<font color="orange">Pending</font>';
                                                } else if ($val->status == 1) {
                                                    echo '<font color="green">Approved</font>';
                                                } else if ($val->status == -1) {
                                                    echo '<font color="red">Declined</font>';
                                                }
                                                ?>
                                            </a>
                                        </td>
                                        <!-- <td style="text-align:center">
                                            <?php if ($val->second_approval == 0) { ?>
                                                <a href="<?php echo base_url("edit-admin-movement") . "/" . $val->id; ?>?<?php echo time() . "-_+=" ?>" data-toggle="tooltip" title="Edit" class="btn btn-info btn-xs">edit</a>
                                                <a href="<?php echo base_url("delete-admin-movement") . "/" . $val->id; ?>?<?php echo time() . "-_+=" ?>" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger" onclick="return ConfirmDelete()">X</a>
                                            <?php } ?>
                                        </td> -->
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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
    <!-- XEditable -->
    <script src="<?php echo site_url(); ?>plugins/xeditable/bootstrap-editable.min.js"></script>
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