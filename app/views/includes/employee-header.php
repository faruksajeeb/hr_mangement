<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>resources/images/favicon.ico" type="image/x-icon">
        <title>HRMS | Employee Dashboard</title>
        <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/font-end/css/bootstrap.min.css" >
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
        <script>
                    function ConfirmDelete()
            {
                var x = confirm("Are you sure you want to delete?");
                if (x)
                    return true;
                else
                    return false;
            }
        </script>
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <a class="navbar-brand" href="<?php echo base_url();?>employee-dashboard">IIDFC</a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="<?php echo base_url();?>employee-leave">My Leave <span class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <!-- <a class="nav-link" href="<?php echo base_url();?>employee-movement-orders">Daily Movement</a> -->
                                        <a class="nav-link btn btn-outline-secondary" href="<?php echo base_url();?>my-attendance-exceptions">My Attendance Exceptions</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Apply
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="<?php echo base_url(); ?>employee-leave-application">Leave Application</a>
                                            <!-- <a class="dropdown-item" href="<?php echo base_url();?>employee-movement-order-form">Daily Movement</a> -->
                                            <a class="dropdown-item" href="<?php echo base_url(); ?>attendance-exception-create">Attendance Exception</a>
                                            <!--                                            <div class="dropdown-divider"></div>
                                                                                        <a class="dropdown-item" href="#">Something else here</a>-->
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php echo base_url(); ?>my-attendance" tabindex="-1" aria-disabled="true">My Attendance</a>
                                    </li>
                                </ul>
                                <form class="form-inline my-2 my-lg-0">
                                    <span style="margin:5px; font-weight:bold;">Welcome, <?php echo $this->session->userdata('emp_name');?></span>
                                    <a class=" btn btn-outline-primary my-2 my-sm-0" href="<?php echo site_url("change-employee-password"); ?>" tabindex="-1" aria-disabled="true">Change Password</a>
                                    <a class=" btn btn-outline-danger  my-2 my-sm-0" href="<?php echo site_url("employee-logout"); ?>" tabindex="-1" aria-disabled="true">Logout</a>
                                </form>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>