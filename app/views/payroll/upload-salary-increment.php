
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS | Salary Increment-Upload</title>
        <!--chosen--> 
        <?php
        $this->load->view('includes/cssjs');
        $userId=  $this->session->userdata('user_id');
        
        $userDivision=  $this->session->userdata('user_division');
        $userDepartment=  $this->session->userdata('user_department');
        ?> 
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.form.min.js"></script>
     
 <script>
            $(document).ready(function () {
                $("#loader").hide();
             
               
                setTimeout(function(){ 
                   // $("#errors").hide("slide", {direction: "up" }, "slow"); 
                    $(".alert").hide("slide", {direction: "up" }, "slow");
                   
                }, 9000);
            });

            function validate() {
                var valid = true;

                var msg = "<ul>";
                if (document.importForm.userfile.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.importForm.userfile.focus();
                        document.importForm.userfile.style.border = "solid 1px red";
                        //document.myForm.loan_type_name.style.backgroundColor="#FFA07A";
                        msg += '<li >You need to select a file! <span class="glyphicon glyphicon-remove-circle"></li>';
                        valid = false;
                        // return false;
                    }
                }
                
               
                if (!valid) {
                    //alert(0);
                    msg += "</ul>";
                    //console.log("Hello Bd");

                    var div = document.getElementById('errors').innerHTML = msg;
                    document.getElementById("errors").style.display = 'block';
                    //Hide();
                    return false;
                }else{
			 $("#loader").show("fade","slow");
                        }

            }



        </script>
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
                        <div class="col-md-6 col-xs-12 add-form" style="border-radius:5px;">
                            <div class="row add-form-heading" style="border-top-left-radius: 5px;border-top-right-radius: 5px;">
                                <div class="col-md-12 ">

                                    <i class="fas fa-money-check-alt " style="font-size:20px"></i> Salary Increment Uploader </div>
                            </div>
                            <form action="" onsubmit=" return validate();" method="POST"  class="" id=""  name="importForm" enctype="multipart/form-data">
                                <div class="row success-err-sms-area">
                                    <div class="col-md-12">
                                        
                                        <div id="errors" style='color:red;text-align:right'></div>

                                             <?php 
                                    $msg=$this->session->flashdata('success');
                                    if($msg){
                                        ?>
                                    <br/>
                                    <div class="alert alert-success text-center">
                                        <strong>Success!</strong> <?php echo $msg?>
                                      </div>                                    
                                    <?php
                                    }                                    
                                    $msg=null;
                                    ?>
                                    <?php 
                                    $error=$this->session->flashdata('error');
                                    if($error){
                                        ?>
                                    <br/>
                                    <div class="alert alert-danger text-center">
                                        <strong>ERROR!</strong> <?php echo $error?>
                                      </div>                                    
                                    <?php
                                    }                                    
                                    $error=null;
                                    ?>
                                    </div>
                                </div>
                                <div class="row"> 
 

                                    <div class="row">

                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            
<!--                                            <div class="row">                                    
                                                <div class="col-md-12 col-xs-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-4">Generated Date:</div>
                                                        <div class="col-md-8">
                                                            <?php
                                                                $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
                                                                $current_date = $dt->format('d-m-Y');                                               
                                                            ?>
                                                            <input type="text" class='datepicker' name="generated_date" id="generated_date" value="<?php echo $current_date; ?>"  />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>-->
                                            <div class="row">                                    
                                                <div class="col-md-12 col-xs-12 col-sm-12">
                                                    <div class="row">
                                                        
                                                        
                                                        <div class="col-md-4" style="text-align:right;vertical-align: middle; line-height: 30px;">Upload File:</div>
                                                        <div class="col-md-8  ">
                                                            <input type="file" name="userfile" id="userfile" />
                                                            <br/>
                                                            <div class="label label-default " style="">
                                                                <strong>[Note:</strong> must be import excel file.]
                                                                
                                                            </div> 
                                                            <a href="<?php echo base_url();?>resources/files/sample-salary-increment-file.xlsx" class="pull-right" style="font-style: italic"><i class="fa fa-download"></i>Sample File</a>
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
                                                    <input type="submit" name="upload_btn" id="upload_btn" style="width:100%;" value="Import" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </form>

                        </div>

                        <div class="col-md-3 col-xs-12 ">
                            <div id="loader" style="text-align:center; display:none;">
                                <div style="padding: 5px;">Please be patient, Increment data is being imported.</div>
                                <img src="<?php echo base_url()?>resources/images/prosseging.gif" style="width: 100px;"  alt="Processing..."/>
                                 <!-- Start Report -->
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

    </body>
</html>