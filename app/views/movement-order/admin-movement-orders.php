<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS | Manage Daily Movement </title>
        <!--chosen--> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.css">
        <!-- XEditable -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>plugins/xeditable/bootstrap-editable.css">
        <?php
        $this->load->view('includes/cssjs');
        ?> 

        <script>
            $(document).ready(function () {
 $('[data-toggle="tooltip"]').tooltip();
                $('.edit_data').editable({
                    validate: function (value) {
                        if ($.trim(value) == '')
                            return 'This field is required';
                    }
                });

                $('.first_approve_status').editable({
                    prepend: "-- select status --",
                    showbuttons: false,
                    source: [
                        {
                            value: '0',
                            text: "Pending"

                        }, {
                            value: '1',
                            text: "Approved"

                        }, {
                          value: '-1',
                            text: "Not Approved"

                        },
                    ]
                });

                $('.chosen-container').css({'width': '350px'});
                // Setup - add a text input to each footer cell
                $('#example tfoot th').each(function () {
                    var title = $('#example thead th').eq($(this).index()).text();
                    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
                });

                // DataTable
                var table = $('#example').DataTable();

                // Apply the search
                table.columns().eq(0).each(function (colIdx) {
                    $('input', table.column(colIdx).footer()).on('keyup change', function () {
                        table
                                .column(colIdx)
                                .search(this.value)
                                .draw();
                    });
                });



            });
            function ConfirmDelete()
            {
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
            .some_class{
                width: 100% !important;
            }
            .select_class{
                width: 200px !important;
            }
            tr td{
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
                    <h4>Employee Movement Orders</h4>         
                </div> 
                <div class="wrapper">
                    <div class="col-md-12">

                        <div id="errors" style='color:red;text-align:right'></div>

                        <?php
                        $msg = $this->session->flashdata('success');
                        if ($msg) {
                            ?>
                            <br/>
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
                            <br/>
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
                            <table id="example" class="table  table-responsive table-sm table-bordered " >
                                <thead>
                                <th>Sl No.</th>
                                <th>Emp Name</th>
<!--                                <th>Emp ID</th>
                                <th style="text-align:center">Company</th>
                                <th>Division</th>
                                <th>Designation</th>-->
                                <th>Date Of Movement</th>
                                <th>Type Of Movement</th>


                                <th>Work Location</th>
                                <th>Informed Earlier</th>

                                <th>Location From</th>                                    
                                <th>Location To</th>                             
                                <th>Out Time</th>
                                <th>In Time</th>
                                <th>Possibility Of Return</th>
                                <th>Department Approval</th>
                                <th>Administrator Approval</th>
                                <th>Remarks</th>
                                <th>Reason</th>   
                                 <th>Action</th>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Emp Name</th>
<!--                                        <th style="text-align:center">Emp ID</th>
                                        <th>Company</th>
                                        <th>Division</th>
                                        <th>Designation</th>-->
                                        <th>Date Of Movement</th>
                                        <th>Type Of Movement</th>
                                        <th>Work Location</th>
                                        <th>Informed Earlier</th>

                                        <th>Location From</th>                                    
                                        <th>Location To</th>                             
                                        <th>Out Time</th>
                                        <th>In Time</th>
                                        <th>Possibility Of Return</th>
                                        <th>Department Approval</th>
                                        <th>Administrator Approval</th>
                                        <th>Remarks</th>
                                        <th>Reason</th> 
                                        <th></th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $slNo = 1;
                                    foreach ($employee_movement_orders as $employeeMovementOrder) {
                                        ?>
                                        <tr>
                                            <td><?php echo $slNo++; ?></td>
                                            <td style="width:250px;"><?php echo $employeeMovementOrder->emp_name ?>
                                                <a type="" class="" data-toggle="collapse" data-target="#empDetail<?php echo $slNo; ?>">details</a>
                                                <div id="empDetail<?php echo $slNo; ?>" class="collapse">
                                                    <?php 
                                                    echo 
                                                            $employeeMovementOrder->emp_id."<br>".
                                                            $employeeMovementOrder->designation_name."<br>".
                                                            $employeeMovementOrder->company_name." (".  $employeeMovementOrder->division_name.")"; 
                                                     ?>
                                                </div>
                                            </td>
                                            <!--<td><?php echo $employeeMovementOrder->emp_id;  ?></td>-->
                                            <!--<td style="text-align:center"><?php echo $employeeMovementOrder->company_name ?></td>-->
                                            <!--<td><?php echo $employeeMovementOrder->division_name ?></td>-->
                                            <!--<td><?php echo $employeeMovementOrder->designation_name ?></td>-->
                                            <td><?php echo $employeeMovementOrder->attendance_date ?></td>
                                            <td><?php echo $employeeMovementOrder->type_of_movement; ?></td>
                                            <td><?php echo $employeeMovementOrder->work_location; ?></td>
                                            <td><?php echo $employeeMovementOrder->informed_earlier; ?></td>
                                            <td><?php echo $employeeMovementOrder->location_from; ?></td>
                                            <td><?php echo $employeeMovementOrder->location_to; ?></td>
                                            <td><?php echo $employeeMovementOrder->out_time; ?></td>
                                            <td><?php echo $employeeMovementOrder->expected_in_time; ?></td>
                                            <td><?php echo $employeeMovementOrder->possibility_of_return; ?></td>   
                                            <td  style="font-style:italic">
                                                <a href="#" rel="tooltip" data-placement="top" data-inputclass="select_class"  class="first_approve_status" id="first_approval" data-type="select"data-title="Change Status" data-pk="<?php echo $employeeMovementOrder->id; ?>" data-url="<?php echo base_url(); ?>empattendance/updateApprovalStatus/emp_informed" >                                         
                                                    <?php
                                                    if ($employeeMovementOrder->first_approval == 0) {
                                                        echo '<font color="orange">Pending</font>';
                                                    } else if ($employeeMovementOrder->first_approval == 1) {
                                                        echo '<font color="green">Approved</font>';
                                                    } else if ($employeeMovementOrder->first_approval == -1) {
                                                        echo '<font color="red">Not Approved</font>';
                                                    } else {
                                                        echo "";
                                                    }
                                                    ?>
                                                </a> 
                                            </td>
                                            <td  style="font-style:italic">
                                                <?php
                                                if ($employeeMovementOrder->second_approval == 0) {
                                                    echo '<span class="label label-warning">Pending</span>';
                                                }else if ($employeeMovementOrder->second_approval == -1) {
                                                    echo '<span class="label label-danger">Not Approved</span>';
                                                }else if ($employeeMovementOrder->second_approval == 1) {
                                                    echo '<span class="label label-success">Approved</span>';
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $employeeMovementOrder->status_comments; ?></td>
                                            <td><?php echo $employeeMovementOrder->reason; ?></td>
                                            <td>
                                                <?php if($employeeMovementOrder->second_approval==0){ ?>
                                                <a href="<?php echo base_url("edit-admin-movement")."/".$employeeMovementOrder->id;?>?<?php echo time()."-_+="?>" data-toggle="tooltip" title="Edit"  class="btn btn-info btn-xs">edit</a>
                                                <a href="<?php echo base_url("delete-admin-movement")."/".$employeeMovementOrder->id;?>?<?php echo time()."-_+="?>" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger" onclick="return ConfirmDelete()">X</a>
                                                <?php } ?>
                                            </td>
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
    </body>
</html>