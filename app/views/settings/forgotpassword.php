<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Your Account</title>
    <?php
    $this->load->view('includes/cssjs');
    ?> 
    <script type="text/javascript">
        function validate() {
            var valid = true;
            var msg = "<ul>";
            if (document.forgot.forgotemail.value == "") {
                if (valid)
                    document.forgot.forgotemail.focus();
                document.forgot.forgotemail.style.border = "solid 1px red";
                msg += "<li>You need to fill in your email!</li>";
                valid = false;
                return false;
            }

            if (document.forgot.forgotemail.value) {
                if (!validateEmail(document.forgot.forgotemail.value)) {
                    document.forgot.forgotemail.focus();
                    document.forgot.forgotemail.style.border = "solid 1px red";
                    msg += "<li>Your email is not valid!</li>";
                    valid = false;
                    return false;
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

            function validateEmail(email) {
                var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
        </script>    
    </head>
    <body class="logged-in dashboard current-page add-division">
        <div id="wrapper">
            <!-- Page Content -->
            <div id="page-content-wrapper">
                <div class="container-fluid">
                    <div class="row header">
                        <div class="col-md-2">
                            <div class="logo">
                                <img src="<?php echo base_url(); ?>resources/images/logo.png" alt="" id="logo-img"/>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="company_name">
                                <h1>IIDFC Securities Limited</h1>
                            </div>
                        </div>               
                    </div>
                    <div class="row under-header-bar">              
                    </div> 
                    <div class="row login-form">
                        <div class="col-md-10">
                        <?php 
                    if($msg){
                            echo $msg;
                        }
                        echo validation_errors();
                    ?>
                         <form name="forgot" id="forgot-form" action="<?php echo base_url(); ?>login/forgotpassword" method="post" onSubmit="return validate();" enctype="multipart/form-data" >
                            <p>Can't you remember your password? please enter your registered email address.</p>
                            Your e-mail address <input type="text" style="width:inherit" id="forgotemail" name="forgotemail" class="form-text"> <input type="submit" id="edit-submit" value="Submit" style="margin-left:10px">
                            <p><a href="<?php echo base_url(); ?>">Back to Login</a></p>
                        </form>
                    </div>
                    
                </div>               
                <div class="row">
                    <div class="footer">
                        <h2>Corporate Head Office</h2>
                        House - 25, Road - 34,<br>
                        Gulshan - 2, Dhaka - 1212. Bangladesh.<br>
                        Phone : +88 02 8812395,9880916,9880916,9881424,9892111.<br>
                        Fax : +88-02 8826439<br>
                        E-mail : info@ahmedamin.com,misaag@ahmedamin.com<br>
                    </div>
                </div>
                <div class="row text-right">
                    <p>Developed by: <a href="http://www.muslah.com/" target="_blank">Mosleh</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->        
</body>
</html>