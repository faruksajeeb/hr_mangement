<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS - Report | Employee Payslip </title>
        <!--chosen--> 
         <link rel="stylesheet" href="<?php echo base_url();?>resources/plugins/chosenSelect/chosen.css">
        <?php
        $this->load->view('includes/cssjs');
        $userId=  $this->session->userdata('user_id');
        
        $userDivision=  $this->session->userdata('user_division');
        $userDepartment=  $this->session->userdata('user_department');
        ?> 
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.form.min.js"></script>

        <style>
            body{
                background-color: #FFF;
            }
            .add-form{
                min-height:200px;
            }
            select{
                margin: 0;
            }
            .col-md-4{
                //text-align: right;
            }
            a:hover{
                cursor: pointer;
            }
            .dialogWithDropShadow
            {
                -webkit-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);  
                -moz-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5); 

            }
            .ui-dialog{
                //  background-color: #ffcc99;
            }
            table {
                border-collapse: collapse;
            }

            table, th, td {
                border: 1px solid #ccc;
                padding: 2px;
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

                    <br/>
                    <div class="row">
                        <div class="col-md-3 col-xs-12 "></div>
                        <div class="col-md-6 col-xs-12 add-form">
                            <div class="row add-form-heading">
                                <div class="col-md-12 ">

                                    <i class="fas fa-money-check-alt " style="font-size:20px"></i> Employee Payslip Report </div>
                            </div>
                            <form action="" method="POST"  class="payslipForm" id="payslipForm"  name="payslipForm" enctype="multipart/form-data">
                                <div class="row success-err-sms-area">
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
                                        $error = $this->session->flashdata('errors');
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
                                </div>
                                <div class="row"> 


                                    <div class="row">

                                        <div class="col-md-12 col-xs-12 col-sm-12">                                            
                                            
                                            <div class="row">                                    
                                                <div class="col-md-12 col-xs-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-3">Employee name:</div>
                                                        <div class="col-md-9">
                                                            <select name='emp_name' id='emp_name'  data-placeholder="Choose an Employee..." class="chosen-select">
                                                                <option value="">--Select employee name--</option>
                                                                <?php                                                    
                                                                foreach($employees as $employee){
                                                                ?>
                                                                <option value="<?php echo $employee['content_id']?>"><?php echo $employee['emp_name'].'-'.$employee['emp_id'];?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">                                    
                                                <div class="col-md-12 col-xs-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-3">Year:</div>
                                                        <div class="col-md-4">
                                                           
                                                            <select name="payslip_year" id="payslip_year" class="chosen-select">
                                                                <option value="2010">2010</option>
                                                                <option value="2011">2011</option>
                                                                <option value="2012">2012</option>
                                                                <option value="2013">2013</option>
                                                                <option value="2014">2014</option>
                                                                <option value="2015">2015</option>
                                                                <option value="2016">2016</option>
                                                                <option value="2017">2017</option>
                                                                <option value="2018">2018</option>
                                                                <option value="2019" >2019</option>
                                                                <option value="2020">2020</option>
                                                                <option value="2021">2021</option>
                                                                <option value="2022" selected>2022</option>
                                                                <option value="2023">2023</option>
                                                                <option value="2024">2024</option>
                                                                <option value="2025">2025</option>
                                                                <option value="2026">2026</option>
                                                                <option value="2027">2027</option>
                                                                <option value="2028">2028</option>
                                                                <option value="2029">2029</option>
                                                                <option value="2030">2030</option>
                                                            </select>
                                                       
                                                        </div>
                                                   
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-8">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-8">
                                                    <!--<input type="submit" name="export_btn" id="export_btn"  target="_blank"  style="width:100%;" value="Get Report" />-->
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
                         <div id="loader" style="text-align:center; display:none;">
                                 <div>Please be patient, report is being processed.</div>
                                  <img src="<?php echo base_url()?>resources/images/200.gif" alt="Loading..."/>
                                 <!-- Start Report -->
                            </div>
                        <div class="display_report col-md-12">
                               
                            
                            <!-- End Report -->
                            </div>
                    </div>
                    

                </div>
            </div>
                <?php
    $this->load->view('payroll/payment-detail', true);
    $this->load->view('payroll/payslip-detail', true);

    ?>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->   
        <script type="text/javascript">
    $(function() {
        $(".chosen-select").chosen();
           $("#loader").hide();

              
                setTimeout(function () {
                    // $("#errors").hide("slide", {direction: "up" }, "slow"); 
                    $(".alert").hide("slide", {direction: "up"}, "slow");

                }, 9000);
                
                
                $('#emp_name').change(function(){
//         alert(0);
                        var emp_name=$('#emp_name').val(); 
                        var year=$('#payslip_year').val();        
                          //show the loading div here
                           $('.display_report').hide("fade","fast");
                           $("#loader").show("fade","slow");
                           
                          
                        $('#payslipForm').ajaxSubmit({
                            type: "POST",
                            url: "<?php echo base_url(); ?>payroll/getEmployeeWisePayslip",
                            data:{ 
                                emp_name:emp_name,
                                year:year
                            },            
                            dataType: 'html', // what to expect back from the server
                            
                            success: function (data) {
                                //then close the window 
//                                alert(data);
                                $("#loader").hide("fade","fast");
                                 
                                 $('.display_report').show("fade","slow");
                                $('.display_report').html(data);

                            }
                        });
//                        return false; 
                    });
                            $('#payslip_year').change(function(){
//         alert(0);
                        var emp_name=$('#emp_name').val(); 
                        var year=$('#payslip_year').val();        
                          //show the loading div here
                           $('.display_report').hide("fade","fast");
                           $("#loader").show("fade","slow");
                           
                          
                        $('#payslipForm').ajaxSubmit({
                            type: "POST",
                            url: "<?php echo base_url(); ?>payroll/getEmployeeWisePayslip",
                            data:{ 
                                emp_name:emp_name,
                                year:year
                            },            
                            dataType: 'html', // what to expect back from the server
                            
                            success: function (data) {
                                //then close the window 
//                                alert(data);
                                $("#loader").hide("fade","fast");
                                 
                                 $('.display_report').show("fade","slow");
                                $('.display_report').html(data);

                            }
                        });
//                        return false; 
                    });
                    
                 
    });
    </script>
    <?php
    
    ?>
                                    <!--Chosen--> 
        <script src="<?php echo base_url();?>resources/plugins/chosenSelect/chosen.jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>resources/plugins/chosenSelect/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
   

    </body>
</html>