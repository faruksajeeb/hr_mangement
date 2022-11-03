<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to View Profile</title>
    <?php
    $this->load->view('includes/cssjs');
    ?> 
    <script type="text/javascript">
        function validate() {
            var valid = true;
            var msg = "<ul>";
            if (document.registration.fullname.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.registration.fullname.focus();
                        document.registration.fullname.style.border = "solid 1px red";
                        msg += "<li>You need to fill the Name field!</li>";
                        valid = false;
                        return false;
                    }
                }
                if (document.registration.user_name.value == "") {
                    if (valid)//only receive focus if its the first error
                        document.registration.user_name.focus();
                    document.registration.user_name.style.border = "solid 1px red";
                    msg += "<li>You need to fill the username field!</li>";
                    valid = false;
                    return false;
                }
                if (document.registration.email_address.value == "") {
                    if (valid)
                        document.registration.email_address.focus();
                    document.registration.email_address.style.border = "solid 1px red";
                    msg += "<li>You need to fill in your email!</li>";
                    valid = false;
                    return false;
                }
                if (document.registration.email_address.value) {
                    if (!validateEmail(document.registration.email_address.value)) {
                        document.registration.email_address.focus();
                        document.registration.email_address.style.border = "solid 1px red";
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
        <style>
            .bs-example {
                position: relative;
                padding: 45px 15px 15px;
                margin: 0 -15px 15px;
                border-color: #e5e5e5 #eee #eee;
                border-style: solid;
                border-width: 1px 0;
                -webkit-box-shadow: inset 0 3px 6px rgba(0,0,0,.05);
                box-shadow: inset 0 3px 6px rgba(0,0,0,.05);
            }
            .bs-example {
                margin-right: 0;
                margin-left: 0;
                background-color: #fff;
                border-color: #ddd;
                border-width: 1px;
                border-radius: 4px 4px 0 0;
                -webkit-box-shadow: none;
                box-shadow: none;
            }
            .nav {
                padding-left: 0;
                margin-bottom: 0;
                list-style: none;
            }
            .nav-tabs {
                border-bottom: 1px solid #ddd;
            }
            .bs-example-tabs .nav-tabs {
                margin-bottom: 15px;
            }
            .nav>li {
                position: relative;
                display: block;
            }
            .nav-tabs>li {
                float: left;
                margin-bottom: -1px;
            }
            .nav>li>a {
                position: relative;
                display: block;
                padding: 10px 15px;
            }
            .nav-tabs>li>a {
                margin-right: 2px;
                line-height: 1.42857143;
                border: 1px solid transparent;
                border-radius: 4px 4px 0 0;
            }
            .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
                color: #555;
                cursor: default;
                background-color: #fff;
                border: 1px solid #ddd;
                border-bottom-color: transparent;
            }
            .fade {
                opacity: 0;
                -webkit-transition: opacity .15s linear;
                -o-transition: opacity .15s linear;
                transition: opacity .15s linear;
            }
            .fade.in {
                opacity: 1;
            }
            .tab-content>.tab-pane {
                display: none;
                visibility: hidden;
            }
            .tab-content>.active {
                display: block;
                visibility: visible;
                margin-top: 55px;
                min-height: 286px;
            }
            #home .row{
                min-height: 40px;
                font-weight: bold;
            }
        </style>
    </head>
    <body class="logged-in dashboard">
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php 
                $this -> load -> view('includes/menu');
                ?>
                <div class="row under-header-bar">          
                </div> 
                <div class="wrapper">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="panel panel-default" style="margin-top:40px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">User Profile</h3>
                                </div>
                                <div class="panel-body">

                                    <!-- s -->
                                    <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                                        <?php
                                        echo validation_errors();
                                        echo $error;
                                        ?>
                                        <?php echo $msg; ?>

                                        <ul id = "myTab" class = "nav nav-tabs">
                                         <li class = "active"><a href = "#home" data-toggle = "tab">View</a></li>
                                         <li><a href = "#ios" data-toggle = "tab">Edit</a></li>
                                     </ul>

                                     <div id = "myTabContent" class = "tab-content">

                                         <div class = "tab-pane fade in active" id = "home">
                                            <?php if ($userinfo['name']) { ?>
                                            <div class="row">
                                                <div class="col-md-4">Name</div>
                                                <div class="col-md-8">: <?php print $userinfo['name']; ?></div>
                                            </div>
                                            <?php } ?>
                                            <?php if ($userinfo['email']) { ?>
                                            <div class="row">
                                                <div class="col-md-4">Email</div>
                                                <div class="col-md-8">: <?php print $userinfo['email']; ?></div>
                                            </div>  
                                            <?php } ?>

                                            <?php if ($userinfo['phone']) { ?>
                                            <div class="row">
                                                <div class="col-md-4">Phone</div>
                                                <div class="col-md-8">: <?php print $userinfo['phone']; ?></div>
                                            </div>   
                                            <?php } ?>
                                        </div>

                                        <div class = "tab-pane fade" id = "ios">
                                            <form name="registration" id="add-user-form" action="<?php echo base_url(); ?>user/viewprofile" onSubmit="return validate();" method="post"  enctype="multipart/form-data" >
                                                <?php echo validation_errors(); ?>
                                                <input type="hidden" id="user_id" name="user_id" value="<?php print $userinfo['id']; ?>">     
                                                <div class="row">
                                                    <div class="col-md-4">Name:</div>
                                                    <div class="col-md-8"><input type="text" name="fullname" id="fullname" value="<?php print $userinfo['name']; ?>"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">User Name:</div>
                                                    <div class="col-md-8"><input type="text" name="user_name" id="user_name" value="<?php print $userinfo['username']; ?>"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">E-mail address:</div>
                                                    <div class="col-md-8"><input type="text" name="email_address" id="email_address" value="<?php print $userinfo['email']; ?>"></div>
                                                </div> 
                                                <div class="row">
                                                    <div class="col-md-4">Password:</div>
                                                    <div class="col-md-8"><input type="password" name="password" id="password"></div>
                                                </div> 
                                                <div class="row">
                                                    <div class="col-md-4">Confirm password:</div>
                                                    <div class="col-md-8"><input type="password" name="confirm_password" id="confirm_password"></div>
                                                </div>  

                                                    <div class="row">
                                                        <div class="col-md-4">Phone:</div>
                                                        <div class="col-md-8"><input type="text" name="phone" id="phone" value="<?php print $userinfo['phone']; ?>"></div>
                                                    </div> 
                   
                                                    <div class="row">
                                                        <div class="col-md-4"></div>
                                                        <div class="col-md-4"><input type="submit" id="edit-submit" name="op" value="Update" class="form-submit"/></div>
                                                    </div>                                                     
                                                    <?php echo form_close(); ?>   
                                                </div>

                                            </div>

                                            <script>
                                             $(function () {
                                              $('#myTab li:eq(0) a').tab('show');
                                          });
                                         </script>
                                     </div>
                                     <!-- s -->


                                 </div>
                             </div>
                         </div>
                         <div class="col-md-2"></div>
                     </div>
                 </div>              
             </div>
         </div>
         <!-- /#page-content-wrapper -->
     </div>
     <!-- /#wrapper -->        
 </body>
 </html>