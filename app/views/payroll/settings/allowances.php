<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS | Payroll Allowances</title>    
        <?php
        $this->load->view('includes/cssjs');
        
        ?>
                <!-- XEditable -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>plugins/xeditable/bootstrap-editable.css">
       
        <script>
            $(function () {
                $('.example').dataTable({
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    //paging: false,
                    paging: true, //changed by sajeeb
                    "autoWidth": false,
                    //"searching": false,
                    "info": false,
                    //"aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,10 ] }  ]
                });
                
                $('.edit_data').editable({
                    validate: function (value) {
                        if ($.trim(value) == '')
                            return 'This field is required';
                    }
                });
            })
        </script>
         <style>
              .editable-container.editable-inline {
        display: inline; 
    }

    .editable-input {
        width: 50%;
    }

            .some_class{
                width: 100% !important;
             }
        </style>
    </head>
    <body>
        <!-- Page Content -->  
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php
                $this->load->view('includes/menu');
                ?>

                <div class="wrapper">
                    <div class="row add-form-heading">
                        <div class="col-md-12 ">

                            <i class="fas fa-money-check-alt " style="font-size:20px"></i> Payroll Allowances </div>
                    </div>
                    <table class="table table-striped table-responsive " class="display">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Emp ID</th>
                                <th>Emp Name</th>
                                <th>A/C No.</th>
                                <th>Division</th>
                                <th>Designation</th>
                                <!--
                                <th>HRent</th>
                                <th>M Allow.</th>
                                <th>Transport Allow.</th>
                                -->
                                <th>Conv. Allow.</th>
                                <th>Tele. Allow.</th>
                                <th>Emp. Status</th>
                            </tr>                            
                        </thead>
                        <tbody>
                            <?php 
                            $i=1;
                              foreach ($employees AS $employee){
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $employee->emp_id; ?></td>
                                <td><?php echo  $employee->emp_name; ?></td>
                                <td>
                                    <!--<a href="#" rel="tooltip" data-placement="top" data-inputclass="some_class"  class="edit_data" id="emp_bank_account" data-type="text"data-title="Enter Account Number" data-pk="<?php echo $employee->content_id; ?>" data-url="<?php echo base_url(); ?>payroll/bankAccountSetting/emp_payment_method" >-->                                         
                                    <?php echo  $employee->emp_bank_account; ?>
                                    <!--</a>-->
                                </td>
                                <td><?php echo  $employee->company; ?></td>
                                <td><?php echo  $employee->designation; ?></td>
                                <!--
                                <td>
                                    <?php //echo  $employee->house_rent; ?>                                    
                                </td>
                                <td>
                                    <?php //echo  $employee->medical_allow; ?>                                  
                                </td>
                                <td>
                                    <?php //echo  $employee->transport_allow; ?>                                   
                                </td>
                                -->
                                <td>
                                    <a href="#" rel="tooltip" data-placement="top" data-inputclass="some_class"  class="edit_data" id="conveyance_allow" data-type="text"data-title="Enter Conveyance Allowance" data-pk="<?php echo $employee->content_id; ?>" data-url="<?php echo base_url(); ?>payroll/allowanceSetting/emp_salary" >                                         
                                    <?php echo  $employee->conveyance_allow; ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" rel="tooltip" data-placement="top" data-inputclass="some_class"  class="edit_data" id="telephone_allow" data-type="text"data-title="Enter Telephone Allowance" data-pk="<?php echo $employee->content_id; ?>" data-url="<?php echo base_url(); ?>payroll/allowanceSetting/emp_salary" >                                         
                                    <?php echo  $employee->telephone_allow; ?>
                                    </a>
                                </td>
<td>
                                    <?php
                                    if($employee->type_of_employee == 1 || $employee->type_of_employee == 155){
                                        echo "<span class='label label-success'>active</span>";
                                    }else if($employee->type_of_employee == 153){
                                        echo "<span class='label label-default'>Left</span>";
                                    }else if($employee->type_of_employee == 473){
                                        echo "<span class='label label-danger'>Terminated</span>";
                                    }else if($employee->type_of_employee == 154){
                                        echo "<span class='label label-primary'>On vacation</span>";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- XEditable -->
        <script src="<?php echo site_url(); ?>plugins/xeditable/bootstrap-editable.min.js"></script>
    </body>
</html>
