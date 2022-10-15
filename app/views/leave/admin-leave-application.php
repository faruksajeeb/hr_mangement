<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS | Manage Leave </title>
        <!--chosen--> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.css">
        <!-- XEditable -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>plugins/xeditable/bootstrap-editable.css">
        <?php
        $this->load->view('includes/cssjs');
        ?> 

        <script>
            $(document).ready(function () {


                $('.leave_status').editable({
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
                $('.edit_data').editable({
                    validate: function (value) {
                        if ($.trim(value) == '')
                            return 'This field is required';
                    }
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
                    <h4>Leave Applications</h4>         
                </div> 
                <div class="wrapper">
                    <div class="col-md-12">
                        <br/>
[NOTE: বিশেষ ছুটি (Special Leave), সকরুণ ছুটি (Compassionate Leave) এবং ক্ষতিপূরণ ছুটি (Compensated Leave)  বার্ষিক ছুটি থেকে কেটে নেওয়া হবে না। ]
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
                            <table id="example" class="table table-responsive table-bordered">
                                <thead>
                                <th>#</th>
                                <th style="text-align:center">Leave Date</th>
                                <th>Emp Name</th>
                                <th>Length Of Services</th>
                                <th>Leave Type</th>
                                <th>Pay Status</th>
                                <th>Total Leave Availed</th>
                                <th>Total Paid Leave</th>
                                <th>Annual Leave Spent</th>
                                <th>Annual Leave Remaining</th>
                                <th>Department Approval</th>
                                <th>Administrator Approval</th>
                                <th>Remarks</th>
                                <th>Justification</th>
                                <th>Action</th>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th style="text-align:center">Leave Date</th>
                                        <th>Emp Name</th>
                                <th>Length Of Services</th>
                                <th>Leave Type</th>
                                <th>Pay Status</th>
                                <th>Total  Leave Availed</th>
                                <th>Total Paid Leave</th>
                                <th>Annual Leave Spent</th>
                                <th>Annual Leave Remaining</th>
                                <th>Department Approval</th>
                                <th>Administrator Approval</th>
                                <th>Remarks</th>
                                <th>Justification</th>
                                <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $slNo = 1;
                                    foreach ($employee_leaves as $employee_leave) {
                                        ?>
                                        <tr>
                                            <td style="width:50px;"><?php echo $slNo++; ?></td>
                                            <td  style="text-align:center;width:80px;"><?php echo $employee_leave->leave_start_date ?></td>
                                            <td>
                                                <?php 
                                                echo "<strong>".$employee_leave->emp_name."</strong><br/><em>"
                                                        .$employee_leave->emp_id ."</em><br/>"
                                                        .$employee_leave->designation_name ."</em><br/>"
                                                        .$employee_leave->company_name."(".$employee_leave->division_name.")";
                                                ?>
                                            </td>
                                            <td style="text-align:center"><?php echo $employee_leave->length_of_services; ?></td>
                                            <td style="text-align:center"><?php echo $employee_leave->leave_type_name; ?></td>
                                            <td style="text-align:center"><?php echo $employee_leave->pay_status ?></td>
                                            <td style="text-align:center"><?php echo $employee_leave->total_leave_availed ?></td>
                                            <td style="text-align:center"><?php echo $employee_leave->leave_availed ?></td>
                                            <td style="text-align:center"><?php echo $employee_leave->total_annual_leave_spent ?></td>
                                            <td style="text-align:center"><?php echo $employee_leave->leave_remaining ?></td>
                                            <td style="font-style:italic;text-align:center">
                                                <a href="#" rel="tooltip" data-placement="top" data-inputclass="select_class"  class="leave_status" id="department_approval" data-type="select"data-title="Change Status" data-pk="<?php echo $employee_leave->id; ?>" data-url="<?php echo base_url(); ?>leavemaster/updateLeaveStatus/emp_leave" >                                         

                                                    <?php
                                                    if ($employee_leave->department_approval == 0) {
                                                        echo '<font color="orange">Pending</font>';
                                                    } else if ($employee_leave->department_approval == 1) {
                                                        echo '<font color="green">Approved</font>';
                                                    } else if ($employee_leave->department_approval == -1) {
                                                        echo '<font color="red">Not Approved</font>';
                                                    }
                                                    ?>
                                                </a>
                                            </td>
                                            <td  style="font-style:italic;text-align:center">
                                                <!--<a href="#" rel="tooltip" data-placement="top" data-inputclass="select_class"  class="leave_status" id="approve_status" data-type="select"data-title="Change Status" data-pk="<?php echo $employee_leave->id; ?>" data-url="<?php echo base_url(); ?>Leavemaster/updateLeaveStatus/emp_leave" >-->                                         
                                                <?php
                                                if ($employee_leave->approve_status == 'pending') {
                                                    echo '<span class="label label-default">pending</span>';
                                                }else if ($employee_leave->approve_status == 'not_approved') {
                                                    echo '<span class="label label-danger">Not Approved</span>';
                                                } else {
                                                    echo '<span class="glyphicon glyphicon-ok"> </span> <span class="label label-success">approved</span>';
                                                }
                                                ?>
                                                <!--                                                    </a> -->

                                            </td>
                                            <td><?php echo $employee_leave->remarks ?></td>
                                            <td><?php echo $employee_leave->justification ?></td>
                                            <td>
                                                <?php if($employee_leave->approve_status=='pending'){ ?>
                                                    <a href="<?php echo base_url("edit-admin-leave-application")."/".$employee_leave->id;?>?<?php echo time()."-_+=";?>" class="btn btn-sm btn-info">edit</a>
                                                    <a href="<?php echo base_url("delete-admin-leave-application")."/".$employee_leave->id;?>?<?php echo time()."-_+=";?>" class="btn btn-sm btn-danger" onclick="return ConfirmDelete();">X</a>
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