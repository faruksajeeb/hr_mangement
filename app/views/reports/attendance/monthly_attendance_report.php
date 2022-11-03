<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HR | Monthly Attendance Reports</title>
    <?php
    $this->load->view('includes/cssjs');
    date_default_timezone_set('Asia/Dhaka');
    $servertime = time();
    $today_date = date("d-m-Y", $servertime);
    ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.form.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".chosen-select").chosen();
            $("#loader").hide();
            // Setup - add a text input to each footer cell
            jQuery.validator.setDefaults({
                debug: true,
                success: "valid"
            });
            $("#myForm").validate({
                rules: {
                    emp_name: "required",
                    emp_id: "required",
                    // emp_login_time: {required: true, time: true},
                    // emp_logout_time: {required: true, time: true},
                    emp_attendance_date: {
                        required: true,
                        mydate: true
                    },
                },
                submitHandler: function(form) {
                    // do other things for a valid form
                    form.submit();
                }
            });
            $.validator.addMethod('time', function(value, element, param) {
                return /^([01]?[0-9]|2[0-3])(:[0-5][0-9]){2}$/.test(value);
            }, 'Enter a valid time: hh:mm:ss');

            $.validator.addMethod("mydate", function(value, element) {
                    return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
                },
                "Please enter a date in the format dd-mm-yyyy"
            );
            $('.submit-query').click(function() {
                var content_id = $('#content_id').val();
                var start_date = $('#emp_attendance_start_date').val();
                var end_date = $('#emp_attendance_end_date').val();
                //show the loading div here
                $('.display_report').hide("fade", "fast");

                if (!content_id && !start_date && !end_date) {
                    alert('Please fill up the required fields(employee,start date,end date) first.');
                } else {
                    $("#loader").show("fade", "slow");
                    $('#myForm').ajaxSubmit({
                        type: "POST",
                        url: "<?php echo base_url(); ?>monthly_attendance_report",
                        data: {
                            content_id: content_id,
                            start_date: start_date,
                            end_date: end_date
                        },
                        dataType: 'html', // what to expect back from the server
                        success: function(data) {
                            //then close the window 
                            $("#printButton").show("fade", "fast");
                            $("#loader").hide("fade", "fast");

                            $('.display_report').show("fade", "slow");
                            $('.display_report').html(data);

                        }
                    });
                }

            });

        });


        function popitup(url) {
            newwindow = window.open(url, 'name', 'height=auto,width=700px');
            //newwindow.echo();
            window.onfocus = function() {
                newwindow.close();
            }
            if (window.focus) {
                newwindow.focus();
            }
            var document_focus = false;
            $(newwindow).focus(function() {
                document_focus = true;
            });
            $(newwindow).load(function() {
                // setInterval(function() { if (document_focus === true) { newwindow.close();  document_focus = false;}  }, 7000);

            });
            return false;
        }
    </script>
    <style>
        #example td,
        th {
            padding: 0.30em 0.20em;
            text-align: center;
        }

        .red-color {
            color: red;
        }

        .blue-color {
            color: #210EFF;
            /*background-color: #84B3D0;*/
            font-weight: bold;
        }

        .chosen-container.chosen-container-single {
            width: 100% !important;
            /* or any value that fits your needs */
        }

        body {
            background: #FFF !important;
        }
    </style>
</head>

<body class="logged-in dashboard current-page add-attendance">
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php
            date_default_timezone_set('Asia/Dhaka');
            $servertime = time();
            $now = date("d-m-Y H:i:s", $servertime);
            $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
            $last_day_this_month = date('t-m-Y');
            $lastdateofattendance = end($date_range);
            $nowdate = date("d-m-Y", $servertime);
            $thisyear = date("Y", $servertime);
            $datee = date_create($lastdateofattendance);
            $nowbigmonth = date_format($datee, 'F Y');
            $nowtime = date("H:i:s a", $servertime);
            $this->load->view('includes/menu');
            ?>
            <div class="row under-header-bar text-center">
                <h4>Monthly Attendance Reports</h4>
            </div>
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <form action="" method="post" onSubmit="return validate();" class="myForm" id="myForm" name="myForm" enctype="multipart/form-data">
                            <div class="row success-err-sms-area">
                                <div class="col-md-12">
                                    <input type="hidden" name="attendance_id" id="attendance_id" value="<?php echo $id; ?>">
                                    <div id="errors"></div>
                                    <?php
                                    echo $this->session->flashdata('errors');
                                    echo $this->session->flashdata('success');
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Employee Name</div>
                                        <div class="col-md-9">
                                            <select name="content_id" id="content_id" data-placeholder="Choose an Employee..." class="chosen-select">
                                                <option value=""></option>
                                                <?php foreach ($employees as $v) : ?>
                                                    <option value="<?php echo $v->content_id; ?>"><?php echo $v->emp_name . ' >> ' . $v->emp_id; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Start Date:</div>
                                        <div class="col-md-9"><input type="text" name="start_date" class="datepicker numbersOnly" id="start_date" value="<?php if ($defaultstart_date) {
                                                                                                                                                                echo $defaultstart_date;
                                                                                                                                                            } else {
                                                                                                                                                                echo $first_day_this_month;
                                                                                                                                                            } ?>" placeholder="dd-mm-yyyy"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">End Date:</div>
                                        <div class="col-md-9"><input type="text" name="end_date" class="datepicker numbersOnly" id="end_date" value="<?php if ($defaultend_date) {
                                                                                                                                                            echo $defaultend_date;
                                                                                                                                                        } else {
                                                                                                                                                            echo $last_day_this_month;
                                                                                                                                                        } ?>" placeholder="dd-mm-yyyy"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Report Type * </div>
                                        <div class="col-md-9">
                                            <select name="report_type" id="report_type" class="form-control col-md-9">
                                                <!-- <option value="">--select type--</option> -->
                                                <option value="attendance" selected>Attendance</option>
                                                <option value="present">Present</option>
                                                <option value="absent">Absent</option>
                                                <option value="late">Late</option>
                                                <option value="early">Early</option>
                                                <option value="late_n_early">Late & Early</option>
                                                <option value="attendance_exception">Attendance Exception</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row top10 bottom10">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-9">
                                            <button type="button" class="btn btn-warning submit-query" name="textfield" id="textfield" class="form-control daterangepick" value="SUBMIT">Generate Report <span class="glyphicon glyphicon-arrow-right"> </span></button>

                                            <!--<input type="submit" name="add_attendance_btn" value="Submit">-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                        </form>
                        <div id="loader" style="text-align:center; display:none;">
                            <div>Please be patient, report is being processed.</div>
                            <img src="<?php echo base_url() ?>resources/images/200.gif" alt="Loading..." />
                            <!-- Start Report -->
                        </div>


                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <a class="btn btn-default pull-left " id="printButton" href="#" style="display:none" onclick="PrintDiv();"><span class="glyphicon glyphicon-print"> Print</span></a>
                        <div class="display_report" id="display_report">


                            <!-- End Report -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->

        <script>
            function PrintDiv() {

                var divToPrint = document.getElementById('display_report');

                var popupWin = window.open('', '_blank', 'width=800,height=auto');

                popupWin.document.open();

                var a = '<div style="width="100%; margin:0 auto;display:block;">\n\
        <div style="float:left;width:100%;text-align:right;">\n\
    \n\
    </div>\n\
    <div class="" style="line-height:40px;text-align: center;font-size:20px;color:black;font-weight:bold;text-decoration:underline;"> \n\
    <span style="padding-left:8px;font-family:Verdana, Geneva, sans-serif">Monthly Attendance Report <br><?php //print $nowbigmonth; 
                                                                                                    ?></span>' +
                    '</div>\n\
    </div><br>';
                popupWin.document.write('<html><head><title>Monthly Attendance Report </title>\n\
    \n\
    \n\
    \n\
    \n\
    <style> body{ text-align:center;font-size:15px;margin:0 auto;}table{margin:0 auto;}table, th, td {padding-left:5px;padding-right:5px;font-size:10px;border: 1px solid black; border-collapse: collapse;}th{background: #DCDCDC; border-top:2px solid #000;} </style>\n\
                      \n\
    \n\
    \n\
    \n\
    \n\
    </head><body onload="window.print()">' + a + divToPrint.innerHTML + '</html>');
                popupWin.document.close();
            }
        </script>
</body>

</html>