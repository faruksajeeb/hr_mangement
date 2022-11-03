
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>resources/images/favicon.ico" type="image/x-icon">
        <title>HRMS | Admin Login</title>
        <?php
        $this->load->view('includes/cssjs');
        $Password_Forget_System = $this->users_model->gettaskwiseglobalsettings("Password_Forget_System");
        $User_Registration_System = $this->users_model->gettaskwiseglobalsettings("User_Registration_System");
        ?> 
        <script type="text/javascript">
            // var macAddress = "";
            // var ipAddress = "";
            // var computerName = "";
            // var wmi = GetObject("winmgmts:{impersonationLevel=impersonate}");
            // e = new Enumerator(wmi.ExecQuery("SELECT * FROM Win32_NetworkAdapterConfiguration WHERE IPEnabled = True"));
            // for(; !e.atEnd(); e.moveNext()) {
            //     var s = e.item(); 
            //     macAddress = s.MACAddress;
            //     alert(unescape(macAddress));
            //     ipAddress = s.IPAddress(0);
            //     computerName = s.DNSHostName;
            // } 
        </script> 
        <style>
            body{
                background:  #3a4652   ;
            }
            #logo-img{
                float:right;
                margin-right:-30px;
            }
            .container-fluid{
                width: 75%;
                background-color:  #3a4652 !important ;

            }
        </style>   
    </head>
    <body class="not-logged login-page" >
        <div id="wrapper">
            <!-- Page Content -->
            <div id="page-content-wrapper">
                <div class="container-fluid login">

                    <div class="row login-form" >
                        <div class="col-md-3 col-xl-4"></div>
                        <div class="col-md-6 col-xl-4 col-sm-12 login-panel">
                            <div class="row header_login">
                               <!--  <div class="col-md-5 text-right">
                                    <div class="logo">
                                       <img src="<?php echo base_url(); ?>resources/images/logo.png" alt=""  id="logo-img"/> 
                                    </div>
                                </div> -->
                                <div class="col-md-12 text-center p-3" style="padding:20px 0;">
                                    <div class="company_name">
                                        <h1 style="margin-bottom:-10px; text-align:center">HRMS</h1>
                                        <br/><small style="font-size:15px;">Human Resource Management System</small>
                                    </div>
                                </div> 

                            </div>



                            <?php
                            echo form_open('login/loginget');
                            echo '<div class="sms-error  text-center" style="color:white;">';
                            if ($msg) {
                                echo $msg;
                            }
                            echo validation_errors();
                            echo "</div>";
                            ?>                    

                            <div class="row" style="margin-bottom:5px;">
                               <!-- <div class="col-md-4"><strong>User Name:</strong></div> -->
                                <div class="col-md-12"><input type="text" class="form-control" id="txtusername" name="txtusername" Placeholder="Username"></div>
                            </div>
                            <div class="row" style="margin-bottom:5px;">
                                <!-- <div class="col-md-4"><strong>Password:</strong></div> -->
                                <div class="col-md-12"><input class="form-control" placeholder="Password" type="password" id="txtpassword" name="txtpassword"></div>
                            </div>

                            <div class="row" >
                                <div class="col-md-12"  > 
								<button type="submit" class="btn btn-lg form-control" style="padding:30px 0 50px 0;background:#3c505b;color:#fff;">LOGIN</button></div>
                            </div>
                            <?php if ($Password_Forget_System['status'] == 1) { ?> 
                                <a href="<?php echo base_url(); ?>login/forgotpassword" class="forgot-link" style="float:left">Forgot Password</a>
                            <?php } ?>
                            <?php if ($User_Registration_System['status'] == 1) { ?>
                                <a href="<?php echo base_url(); ?>registration/userregistration" class="create-link" style="float:right">Create Account</a>
                            <?php } ?>
                            </form> 
                            <hr/>
                            <div class="row text-right "  style="padding:5px;font-size:10px;">

                                <p> Version:<?php echo  '<strong>' . CI_VERSION . '</strong>'; ?> || Developed by: <a href="http://faruksajeeb.wordpress.com" target="_blank" style="font-size:10px;">Faruk Sajeeb</a></p>
                            </div>				  
                        </div>
                        <div class="col-md-3 col-xl-4"></div>
                    </div>               


                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->        
</body>
</html>