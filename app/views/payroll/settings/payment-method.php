<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS | Payment Method</title>    
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
                $('.bank_name').editable({
                            prepend: "-- select bank --",
                            showbuttons: false,                            
                            source: [
                                <?php
                                 foreach($bank_names AS $bank){
                                ?>
                                             {
                                    value: <?php echo $bank->tid; ?>,
                                    text: "<?php echo $bank->name; ?>"

                                },    
                                <?php
                                }
                                ?>                               
                            ]
                   });
                   $('.payment_method').editable({
                            prepend: "-- select Payment Method --",
                            showbuttons: false,                            
                            source: [
                                <?php
                                 foreach($payment_methods AS $paymentMethod){
                                ?>
                                             {
                                    value: <?php echo $paymentMethod->tid; ?>,
                                    text: "<?php echo $paymentMethod->name; ?>"

                                },    
                                <?php
                                }
                                ?>                               
                            ]
                   });
                
            });
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

                            <i class="fas fa-money-check-alt " style="font-size:20px"></i>  Payment Method Setting </div>
                    </div>
                    <table class="table table-striped table-responsive " class="display">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Emp ID</th>
                                <th>Emp Name</th>
                                <th>A/C Number</th>
                                <th>TIN</th>
                                <th>Division</th>
                                <th>Designation</th>
                                <th>Bank Name</th>
                                <th>Branch</th>
                                
                                <th>Payment Method</th>
                                <th>Emp Status</th>
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
                                    <a href="#" rel="tooltip" data-placement="top" data-inputclass="some_class"  class="edit_data" id="emp_bank_account" data-type="text"data-title="Enter Account Number" data-pk="<?php echo $employee->content_id; ?>" data-url="<?php echo base_url(); ?>payroll/bankAccountSetting/emp_payment_method" >                                         
                                    
                                    <?php echo  $employee->emp_bank_account; ?>   
                                        </a>
                                </td>
                                <td>
                                    <a href="#" rel="tooltip" data-placement="top" data-inputclass="some_class"  class="edit_data" id="tin" data-type="text"data-title="Enter TIN" data-pk="<?php echo $employee->content_id; ?>" data-url="<?php echo base_url(); ?>payroll/updateTIN/search_field_emp" >                                         
                                    
                                    <?php echo  $employee->tin; ?>   
                                        </a>
                                </td>
                                <td><?php echo  $employee->company; ?></td>
                                <td><?php echo  $employee->designation; ?></td>
                                <td>
                                    <a href="#" rel="tooltip" data-placement="top" data-inputclass="select_class"  class="bank_name" id="bank_name" data-type="select" data-title="Select Bank Name" data-pk="<?php echo $employee->content_id; ?>" data-url="<?php echo base_url(); ?>payroll/bankAccountSetting/emp_payment_method" >                                         
                                    
                                    <?php echo  $employee->bankName; ?>     
                                        </a>
                                </td>
                                <td>
                                    <a href="#" rel="tooltip" data-placement="top" data-inputclass="some_class"  class="edit_data" id="emp_bank_branch" data-type="text" data-title="Enter Branch Name" data-pk="<?php echo $employee->content_id; ?>" data-url="<?php echo base_url(); ?>payroll/bankAccountSetting/emp_payment_method" >                                         
                                    
                                    <?php echo  $employee->emp_bank_branch; ?>       
                                        </a>
                                </td>
                               
                                <td>
                                    <a href="#" rel="tooltip" data-placement="top" data-inputclass="select_class"  class="payment_method" id="emp_pay_type" data-type="select" data-title="Select Payment Method" data-pk="<?php echo $employee->content_id; ?>" data-url="<?php echo base_url(); ?>payroll/bankAccountSetting/emp_payment_method" >                                         
                                    
                                    <?php echo  $employee->paymentMethod; ?>      
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
