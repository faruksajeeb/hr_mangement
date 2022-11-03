
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS- Payslip Generator</title>
        <!--chosen--> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.css">
        <?php
        $this->load->view('includes/cssjs');
        ?> 

        <script>
            $(document).ready(function () {
                    $("#button1").click(function(){
                            document.getElementById('loadarea').src = '<?php base_url();?>payroll/progress_bar';
                    });
                    $("#button2").click(function(){
                            document.getElementById('loadarea').src = '';
                    });
            });



        </script>
        <style>
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

                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <button type="button" id="button1"  class="btn btn-success btn-block">Click Here To Start Progress Bar</button>
                                <p>&nbsp;<p>
                                    <button type="button" id="button2"  class="btn btn-danger btn-block">Click Here To Stop Progress Bar</button>
                            </div>
                            <div class="col-md-12">
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <div id="progressbar" style="border:1px solid #ccc; border-radius: 5px; "></div>

                                <!-- Progress information -->
                                <br>
                                <div id="information" ></div>
                            </div>
                        </div>
                    </div>

                    <iframe id="loadarea" style="display:none;"></iframe><br />
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>

    </body>
</html>