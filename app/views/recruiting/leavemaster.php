<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Leave Master</title>
    <?php
    $this->load->view('includes/cssjs');
    ?>
    <!--chosen-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.css">
    <script>
        $(document).ready(function() {
            $(".chosen-select").chosen();
            // Setup - add a text input to each footer cell
            // $('.calendar .day').click(function(){
            //     day_num=  $(this).find('.day_num').html();
            //     day_data=prompt('Enter Stuff', $(this).find('.content').html());
            //     if(day_data != null){
            //         $.ajax({
            //             url:window.location,
            //             type:'POST',
            //             data:{
            //                 day:day_num,
            //                 data:day_data
            //             },
            //             success:function(msg){
            //                 location.reload();
            //             }
            //         });
            //     }
            // });

            // dialog
            function addLeave() {
                //event.preventDefault();
                var valid = true;
                var leave_category = $('#leave_category').val();
                var emp_id = $('#emp_hidden_id').val();
                var leave_start_date = $('#leave_start_date').val();
                var leave_end_date = $('#leave_end_date').val();
                var available_leave = $('#available_leave').val();
                var leave_time_status = $('#leave_time_status').val();
                var leave_pay_status = $('#leave_pay_status').val();
                var justification = $('#justification').val();
                var leave_address = $('#leave_address').val();
                var leave_approve_status = $('#leave_approve_status').val();
                var base_url = '<?php echo base_url(); ?>';
                var postData = {
                    "emp_id": emp_id,
                    "leave_category": leave_category,
                    "leave_start_date": leave_start_date,
                    "leave_end_date": leave_end_date,
                    "available_leave": available_leave,
                    "leave_time_status": leave_time_status,
                    "leave_pay_status": leave_pay_status,
                    "justification": justification,
                    "leave_address": leave_address,
                    "leave_approve_status": leave_approve_status,
                };
                //console.log(postData);
                if (leave_category && leave_start_date && leave_end_date) {
                    if (leave_start_date != leave_end_date && leave_time_status == "half_day") {
                        $('#leave_time_status').css({
                            "border-color": "red"
                        });
                    } else {
                        var strtdate = leave_start_date.split("-");
                        var enddate = leave_end_date.split("-");
                        var d1 = new Date(strtdate[2] + "-" + strtdate[1] + "-" + strtdate[0]);
                        var d2 = new Date(enddate[2] + "-" + enddate[1] + "-" + enddate[0]);
                        // console.log(d1+" "+d2);
                        if (d1 <= d2) {
                            //if(leave_end_date>leave_start_date || leave_end_date==leave_start_date){
                            $.ajax({
                                type: "POST",
                                url: "" + base_url + "leavemaster/entryLeave",
                                data: postData,
                                dataType: 'json',
                                success: function(data) {
                                    if (data) {
                                        //location.reload();
                                        window.location.reload(true);
                                    }
                                    //dialog.dialog( "close" );
                                }
                            });
                        } else {
                            $('#leave_end_date').css({
                                "border-color": "red"
                            });
                        }
                    }

                } else {
                    if (leave_start_date != leave_end_date && leave_time_status == "half_day") {
                        $('#leave_time_status').css({
                            "border-color": "red"
                        });
                    }
                    if (!leave_category) {
                        $('#leave_category').css({
                            "border-color": "red"
                        });
                    }
                    if (!leave_start_date) {
                        $('#leave_start_date').css({
                            "border-color": "red"
                        });
                    }
                    if (!leave_end_date) {
                        $('#leave_end_date').css({
                            "border-color": "red"
                        });
                    }
                }
            }
            var dialog, form;
            dialog = $("#dialog-form").dialog({
                autoOpen: false,
                height: "auto",
                width: 350,
                modal: true,
                buttons: {
                    // "Add field": addField,
                    "Add Leave": {
                        text: "Submit",
                        id: "add-leave-btn",
                        click: addLeave
                    },
                    Cancel: function() {
                        dialog.dialog("close");
                    }
                },
                position: {
                    my: "center center",
                    at: "center center"
                },
                close: function() {
                    form[0].reset();
                    // allFields.removeClass( "ui-state-error" );
                }
            });

            form = dialog.find("form").on("submit", function(event) {
                event.preventDefault();
                //  addField();
            });

            $(".calendar .day").on("click", function(event) {
                event.preventDefault();
                day_num = $(this).find('.day_num').html();
                if (day_num) {
                    var year = $('tr th[colspan=5]').html();
                    var arr = year.split('&nbsp;');
                    var dat = new Date('1 ' + arr[0] + ' 1999');
                    var month_number = getMonthFromString(arr[0]);
                    var month_leangth = month_number.toString().length;
                    var day_leangth = day_num.toString().length;
                    if (month_leangth == 1) {
                        month_number = "0" + month_number;
                    }
                    if (day_leangth == 1) {
                        day_num = "0" + day_num;
                    }

                    $("#leave_start_date").val(day_num + "-" + month_number + "-" + arr[1]);
                    $("#leave_end_date").val(day_num + "-" + month_number + "-" + arr[1]);
                    var leave_date = day_num + "-" + month_number + "-" + arr[1];
                    var leave_type = $(this).find('.content').html();
                    var base_url = '<?php echo base_url(); ?>';
                    var postData = {
                        "leave_date": leave_date
                    };
                    if (leave_type) {
                        $.ajax({
                            type: "POST",
                            url: "" + base_url + "leavemaster/getEmployeeleave",
                            data: postData,
                            dataType: 'json',
                            success: function(data) {
                                if (data) {
                                    $('#leave_category').val(data.leave_type);
                                    $('#leave_start_date').val(data.leave_start_date);
                                    $('#leave_end_date').val(data.leave_end_date);
                                    $('#leave_pay_status').val(data.pay_status);
                                    $('#justification').val(data.justification);
                                    $('#leave_address').val(data.leave_address);
                                    $('#leave_approve_status').val(data.approve_status);
                                }
                            }

                        });
                    }


                    dialog.dialog("open");
                }

            });

            // $( "#leave_start_date" ).datepicker({ format: "dd-mm-yyyy" });
            //          $( ".datepicker" ).datepicker({ minDate: +1, 
            //          dateFormat:"yy-mm-dd",
            //      maxDate: "+0M +10D",
            //      beforeShowDay: function(date) {
            //                  var day = date.getDay();
            //                  return [(day != 0), ''];
            //              }
            //  });

            $("div.content").closest("td.day").css("background-color", "#84B3D0");
            <?php

            $sat_off      = $emp_holiday['sat_off'];
            $sun_off     = $emp_holiday['sun_off'];
            $mon_off    = $emp_holiday['mon_off'];
            $tue_off     = $emp_holiday['tue_off'];
            $wed_off    = $emp_holiday['wed_off'];
            $thus_off   = $emp_holiday['thus_off'];
            $fri_off      = $emp_holiday['fri_off'];
            if ($mon_off == 'off') {
                echo '$( ".calendar tbody tr td:nth-child(1)" ).closest( "td.day" ).css( "background-color", "#84B3D0" );';
            }
            if ($tue_off == 'off') {
                echo '$( ".calendar tbody tr td:nth-child(2)" ).closest( "td.day" ).css( "background-color", "#84B3D0" );';
            }
            if ($wed_off == 'off') {
                echo '$( ".calendar tbody tr td:nth-child(3)" ).closest( "td.day" ).css( "background-color", "#84B3D0" );';
            }
            if ($thus_off == 'off') {
                echo '$( ".calendar tbody tr td:nth-child(4)" ).closest( "td.day" ).css( "background-color", "#84B3D0" );';
            }
            if ($sat_off == 'off') {
                echo '$( ".calendar tbody tr td:nth-child(6n+0)" ).closest( "td.day" ).css( "background-color", "#84B3D0" );';
            }
            if ($sun_off == 'off') {
                echo '$( ".calendar tbody tr td:nth-child(7n+0)" ).closest( "td.day" ).css( "background-color", "#84B3D0" );';
            }
            if ($fri_off == 'off') {
                echo '$( ".calendar tbody tr td:nth-child(5n+0)" ).closest( "td.day" ).css( "background-color", "#84B3D0" );';
            }

            ?>

            function getMonthFromString(mon) {

                var d = Date.parse(mon + "1, 2012");
                if (!isNaN(d)) {
                    return new Date(d).getMonth() + 1;
                }
                return -1;
            }
            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
            // diolog

            $('#leave_category').change(function() {
                $('#available_leave').val('0');
                var leave_code = $(this).val();
                var emp_id = $("#emp_hidden_id").val();
                var leave_start_date = $("#leave_start_date").val();
                var base_url = '<?php echo base_url(); ?>';
                var postData = {
                    "leave_code": leave_code,
                    "leave_start_date": leave_start_date,
                    "emp_id": emp_id
                };
                $.ajax({
                    type: "POST",
                    url: "" + base_url + "leavemaster/getempavailleave",
                    data: postData,
                    dataType: 'json',
                    success: function(data) {
                        if (data) {
                            // location.reload();
                            $('#available_leave').val(data);
                        }
                    }

                });
            });
            $('#emp_id').change(function() {
                var emp_id = $(this).val();
                $('#emp_id').val(emp_id);
                $('#emp_hidden_id').val(emp_id);
                var emp_code = $("#emp_id").val();
                var base_url = '<?php echo base_url(); ?>';
                var postData = {
                    "emp_code": emp_code
                };
                $.ajax({
                    type: "POST",
                    url: "" + base_url + "leavemaster/getempcontentid",
                    data: postData,
                    dataType: 'json',
                    success: function(data) {
                        if (data) {
                            //location.reload();
                            window.location.reload(true);
                        }
                    }

                });
            });
            $(document).on('keydown', 'input#emp_id', function(e) {
                var keyCode = e.keyCode || e.which;

                if (keyCode == 9) {
                    e.preventDefault();
                    // call custom function here
                    var emp_code = $("#emp_id").val();
                    var base_url = '<?php echo base_url(); ?>';
                    var postData = {
                        "emp_code": emp_code
                    };
                    $.ajax({
                        type: "POST",
                        url: "" + base_url + "leavemaster/getempcontentid",
                        data: postData,
                        dataType: 'json',
                        success: function(data) {
                            if (data) {
                                window.location.reload(true);
                            }
                        }

                    });

                }
            });

            //end
            //$.noConflict(); 
        });
        //Not to conflict with other scripts
        jQuery(document).ready(function($) {

            $(".ddatepicker").datepicker({
                dateFormat: "dd-mm-yy",
            });

        });

        function ConfirmDelete() {
            var x = confirm("Are you sure you want to delete?");
            if (x)
                return true;
            else
                return false;
        }
    </script>
    <style>
        .calendar {
            font-family: Arial;
            font-size: 12px;
        }

        table.calendar {
            margin: auto;
            border-collapse: collapse;
        }

        .calendar .days td {
            width: 80px;
            height: 80px;
            padding: 4px;
            border: 1px solid #999;
            vertical-align: top;
            background-color: #DEF;
        }

        .calendar .days td:hover {
            background-color: #FFF;
        }

        .calendar .highlight {
            font-weight: bold;
            color: #00F;
        }

        /*    .calendar tbody tr td:nth-child(5n+0) {
        background: #84B3D0;
    }*/
        tr.days_headng td:nth-child(5) {
            background: #C4DCF0 !important;
        }

        .ui-dialog-buttonset button {
            width: initial;
        }

        .chosen-container.chosen-container-single {

            width: 100% !important;
            /* or any value that fits your needs */
        }

        .chosen-container {
            max-height: 100px;
        }

        select {
            height: 56px;

        }
    </style>
</head>

<body class="logged-in dashboard current-page add-division">
    <!-- Page Content -->

    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php
            echo load_css("jquery-ui.css");
            echo load_js("jquery-ui.js");
            $this->load->view('includes/menu');
            ?>
            <div class="row under-header-bar text-center">
                <h4>Leave Master</h4>
            </div>
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <!--
                        <div class="row">
                            <div class="col-md-4 bgcolor_D8D8D8">Employee Code</div>
                            <div class="col-md-8"><input type="text" name="emp_id" id="emp_id" title="Press CTRL+B after typing Emp id or select Emp Name" placeholder="Press CTRL+B after typing Emp id or select Emp Name" autocomplete="off" value="<?php if ($default_emp['emp_id']) {
                                                                                                                                                                                                                                                            echo $default_emp['emp_id'];
                                                                                                                                                                                                                                                        } ?>"/></div>
                        </div>    
                        -->
                        <br />
                        <div class="row">
                            <div class="col-md-2 bgcolor_D8D8D8 text-left">Employee Name</div>
                            <div class="col-md-10">
                                <select name="emp_id" id="emp_id" style="height:56px;" data-placeholder="Choose an Employee..." class="chosen-select">
                                    <option value=""></option>
                                    <?php foreach ($allemployee as $single_employee) {
                                        $default_emp_id = $default_emp['emp_id'];
                                        $content_id = $single_employee['content_id'];
                                        $emp_id = $single_employee['emp_id'];
                                        $emp_name = $single_employee['emp_name'];
                                        if ($default_emp_id == $emp_id) {
                                            print '<option value="' . $emp_id . '" selected="selected">' . $emp_name . '-' . $emp_id . '</option>';
                                        } else {
                                            print '<option value="' . $emp_id . '">' . $emp_name . '-' . $emp_id . '</option>';
                                        }
                                    } ?>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!--
                      <div class="row">
                        <label for="" style="font-style: italic;color: #D0C1C1;padding-top: 6px;font-family: sans-serif;">Press Tab After writing Employee Code. OR</label>
                      </div>
                      <div class="row">
                        <label for="" style="font-style: italic;color: #D0C1C1;padding-top: 17px;font-family: sans-serif;">Select Employee Name From Select Box</label>
                      </div>
                        -->
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-8" style="border:1px solid #CCC;padding:10px;border-radius:5px">
                        <?php echo $calendar; ?>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Employee Leave Details</h4>
                                <hr />
                            </div>
                            <div class="card-body">
                                <table class="table">

                                    <tr>
                                        <th>Previous Earn Leave Balance</th>
                                        <td>
                                            <div class="badge"><?php echo $previous_carry_forward_leave_balance; ?></div>
                                        </td>
                                    </tr>
                                    <?php
                                    $report_year = $defaultyear;
                                    $report_month = $defaultmonth;
                                    $report_date = "$report_year-$report_month-01";
                                    $earn_leave_number = $this->db->query("SELECT total_days as TOTAL FROM emp_yearly_leave_cat_history WHERE content_id=$defaultcontent_id AND leave_type=864 
                                        AND ((start_year<='$report_date' AND end_year='0000-00-00') OR ('$report_date' BETWEEN start_year AND end_year))")->row('TOTAL');

                                    ?>
                                    <tr>
                                        <th>This Year Earn Leave</th>
                                        <td>
                                            <div class="badge"><?php echo $earn_leave_number; ?></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total Earn Leave <span style="font-size:10px">(Previous+This Year)</span></th>
                                        <td>
                                            <div class="badge"><?php echo $earn_leave_number + $previous_carry_forward_leave_balance; ?></div>
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <th>This Year Total Leave</th>
                                        <td>
                                            <div class="badge"><?php echo $current_year_total_leave; ?></div>
                                        </td>
                                    </tr> -->
                                    <tr>
                                        <td colspan="2">
                                            <table class="table table-sm">
                                                <tr>
                                                    <th>Leave Name</th>
                                                    <th>Total</th>
                                                    <th style="color:red">Availed</th>
                                                    <th>Balance</th>
                                                </tr>
                                                <?php
                                                $thisYearAvailed = 0;
                                                $thisYearTotal =0;
                                                foreach ($allleavetype as $leave_type) {
                                                    $leave_type_id = $leave_type['id'];
                                                    $leave_type_total = 0;
                                                    $leave_availed = 0;

                                                    $report_year = $defaultyear;
                                                    $report_month = $defaultmonth;
                                                    $report_date = "$report_year-$report_month-01";
                                                    $default_year_first_day = "01-01-$defaultyear";
                                                    $default_year_last_day = "31-12-$defaultyear";
                                                    $leave_availed_info = $this->db->query("SELECT SUM(leave_total_day) as TOTAL FROM emp_leave WHERE content_id=$defaultcontent_id AND leave_type=$leave_type_id AND leave_year=$report_year AND STR_TO_DATE(leave_start_date,'%d-%m-%Y')>=STR_TO_DATE('$default_year_first_day','%d-%m-%Y') AND STR_TO_DATE(leave_end_date,'%d-%m-%Y')<=STR_TO_DATE('$default_year_last_day','%d-%m-%Y') GROUP BY content_id,leave_type")->row('TOTAL');
                                                    if ($leave_availed_info) {
                                                        $leave_availed = $leave_availed_info;
                                                        $specialLeavesArr = array('594', '782'); // 594=special leave, 782=compensated leave
                                                        if (!in_array($leave_type_id, $specialLeavesArr)) {
                                                            //echo "Don't deduct from total emp leave";                                            
                                                            $thisYearAvailed += $leave_availed;
                                                        }
                                                    }
                                                    $leave_number = $this->db->query("SELECT total_days as TOTAL FROM emp_yearly_leave_cat_history WHERE content_id=$defaultcontent_id AND leave_type=$leave_type_id 
                                                        AND ((start_year<='$report_date' AND end_year='0000-00-00') OR ('$report_date' BETWEEN start_year AND end_year))")->row('TOTAL');
                                                    if ($leave_number) {
                                                        $leave_type_total = $leave_number;
                                                        $thisYearTotal +=$leave_type_total;
                                                    }
                                                    $totalLeave = ($leave_type['name']=='Earned Leave') ? $leave_type_total+$previous_carry_forward_leave_balance : $leave_type_total;
                                                    $balance = $totalLeave-$leave_availed;
                                                    if(($totalLeave==0) && ($leave_availed==0) && ($balance ==0)){
                                                        continue;
                                                    }
                                                ?>
                                                    <tr>
                                                        <td><?php echo $leave_type['name']; ?></td>
                                                        <td><?php echo $totalLeave; ?></td>
                                                        <td style="color:red"><?php echo $leave_availed; ?></td>
                                                        <td style="color:green"><?php echo $balance; ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                    <tfoot>
                                                        <th>TOTAL</th>
                                                        <th><?php echo $leaveTotal = $current_year_total_leave+$previous_carry_forward_leave_balance; ?></th>
                                                        <th style="color:red"><?php echo $thisYearAvailed; ?></th>
                                                        <th style="color:green"><?php echo $leaveTotal-$thisYearAvailed; ?></th>
                                                    </tfoot>
                                            </table>
                                        </td>
                                    </tr>

                                    <!-- <tr>
                                        <td><?php echo $leave_type['name']; ?></td>
                                        <td>
                                            <div class="badge"><?php echo $leave_availed . " /" . $thisYearAvailed; ?></div>
                                        </td>
                                    </tr> -->
                              
                                <!-- <tr>
                                    <th>This Year Availed</th>
                                    <td>
                                        <div class="badge"><?php echo $thisYearAvailed ?></div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>This Year Available</th>
                                    <td>
                                        <div class="badge"><?php echo $current_year_total_leave - $thisYearAvailed ?></div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td colspan="2">
                                        [NOTE: Special Leave, Compensated Leave not deduct from Yearly Leave]
                                    </td>
                                </tr>
                                </table>
                            </div>
                        </div>


                    </div>

                </div>

                <style>
                    .leave-total-days {
                        margin-bottom: 20px;
                        background-color: #A3C588;
                        text-align: center;
                        padding: 5px;
                        font-size: 20px;
                        color: #fff;
                    }

                    u {
                        background-color: #51EA6C;
                        display: inline-block;
                        margin-top: 2px;
                        font-size: 18px;
                    }
                </style>

                <?php
                if ($emp_total_leave) { ?>
                    <!-- <div class="row">
                        <div class="col-md-12 leave-total-days">
                            <?php
                            echo "<span class='leave-total-days-span'>Total Leave Days=" . $emp_total_leave . "</span><br>";
                            ?>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $empId = $default_emp['emp_id'];
                            $empInfo = $this->db->query("SELECT SFE.*,
                            company.name as company_name,
                            division.name as division_name,
                            designation.name as designation_name 
                            FROM search_field_emp SFE 
                            LEFT JOIN taxonomy company ON company.id=sfe.emp_division
                            LEFT JOIN taxonomy division ON division.id=sfe.emp_department
                            LEFT JOIN taxonomy designation ON designation.id=sfe.emp_post_id
                            where SFE.emp_id='$empId' ")->row();

                            ?>
                            <a class="btn btn-default pull-left " id="printButton" href="#" style="" onclick="PrintDiv();"><span class="glyphicon glyphicon-print"> Print</span></a>
                            <a class="btn btn-success pull-right exportToExcel" id="exportButton" href="#" style="" onclick="Export();"><span class="glyphicon glyphicon-file ">Export</span></a>

                            <div id="display_report">
                                <table id="table2excel" class="table table-sm table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th colspan="3" style="background-color: #CCCCCC;text-align:center;">LEAVE REPORT</th>
                                        </tr>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th colspan="2"><?php echo $emp_id; ?></th>
                                        </tr>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th colspan="2"><?php echo $empInfo->emp_name; ?></th>
                                        </tr>
                                        <tr>
                                            <th>Company</th>
                                            <th colspan="2"><?php echo $empInfo->company_name; ?></th>
                                        </tr>
                                        <tr>
                                            <th>Division</th>
                                            <th colspan="2"><?php echo $empInfo->division_name; ?></th>
                                        </tr>
                                        <tr>
                                            <th>Designation</th>
                                            <th colspan="2"><?php echo $empInfo->designation_name; ?></th>
                                        </tr>
                                        <tr style="background-color: orange;">
                                            <th>Leave Type</th>
                                            <th style="text-align:center">Spent Leave</th>
                                            <th>Dates</th>
                                            <!-- <th>Available</th> -->
                                        </tr>


                                    </thead>

                                    <tbody>
                                        <?php
                                        $grand_total_spant = 0;
                                        foreach ($allleavetype as $single_leave) {
                                            $id = $single_leave['id'];
                                            $leavetype = $single_leave['name'];
                                            $vid = $single_leave['vid'];
                                            $tid = $single_leave['tid'];
                                            $description = $single_leave['description'];
                                            if ($defaultcontent_id) {
                                                //$total_leave=$this->emp_leave_model->getemp_yearlyleave($defaultcontent_id, $tid);
                                                date_default_timezone_set('Asia/Dhaka');
                                                $servertime = time();
                                                $leave_year = date("Y", $servertime);
                                                $total_leave_spent_query = $this->emp_leave_model->getemp_spentleave($defaultcontent_id, $tid, $defaultyear);
                                                $total_leave_spent = 0;
                                                $leave_spent_date = "";
                                                foreach ($total_leave_spent_query as $single_spent_leave) {

                                                    $total_leave_spent = $total_leave_spent + $single_spent_leave['leave_total_day'];
                                                    $specialLeavesArr = array('594', '782'); // 594=special leave, 782=compensated leave
                                                    if (in_array($single_spent_leave['leave_type'], $specialLeavesArr)) {
                                                        //echo "Don't deduct from total emp leave";
                                                    } else {
                                                        $grand_total_spant = $grand_total_spant + $single_spent_leave['leave_total_day'];
                                                    }
                                                    $leave_spent_date .= "<u>" . $single_spent_leave['leave_start_date'] . "</u>, ";
                                                }
                                                $available_leave = $emp_total_leave - $total_leave_spent;
                                                $available_leave_grant_total = $emp_total_leave - $grand_total_spant;
                                            }
                                            if ($total_leave_spent) {
                                        ?>
                                                <tr>
                                                    <td><?php print $leavetype; ?></td>
                                                    <td style="text-align:center"><?php if ($total_leave_spent) {
                                                                                        echo $total_leave_spent;
                                                                                    } ?></td>
                                                    <td><?php if ($leave_spent_date) {
                                                            echo $leave_spent_date;
                                                        } ?></td>
                                                    <!-- <td><?php if ($available_leave_grant_total) {
                                                                    // echo $available_leave_grant_total;
                                                                } ?></td> -->
                                                </tr>
                                        <?php
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <br>
                        </div>
                    </div>
                    <?php if ($available_leave_grant_total) { ?>
                        <!-- <div class="row">
                            <div class="col-md-12 leave-total-days">
                                <?php
                                echo "<span class='leave-total-days-span'>Total Available Days=" . $available_leave_grant_total . "</span><br>";
                                ?>
                            </div>
                        </div> -->
                <?php
                    }
                } ?>
                <?php
                //if($content_id && !$emp_total_leave){
                ?>
                <!-- <div class="row">
                <div class="col-md-12"> -->
                <!--  <table id="example" class="display" cellspacing="0" width="100%" border="1">
                        <thead>
                            <tr class="heading">
                                <th>Leave Type</th>
                                <th>Total Days</th>
                                <th>Spent Leave</th>
                                <th>Dates</th>
                                <th>Available</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            // $casual_leave=$emp_holiday['casual_leave'];
                            // $annual_leave=$emp_holiday['annual_leave'];
                            // $maternity_leave=$emp_holiday['maternity_leave'];
                            // $paternity_leave=$emp_holiday['paternity_leave'];
                            // $medical_leave=$emp_holiday['medical_leave'];
                            // $compassionate_leave=$emp_holiday['compassionate_leave'];
                            // $leave_without_pay=$emp_holiday['leave_without_pay'];
                            // foreach ($allleavetype as $single_leave) {
                            //     $id = $single_leave['id'];
                            //     $leavetype = $single_leave['name'];
                            //     $vid = $single_leave['vid'];
                            //     $tid = $single_leave['tid'];
                            //     $description = $single_leave['description'];
                            //     if($defaultcontent_id){
                            //         $total_leave=$this->emp_leave_model->getemp_yearlyleave($defaultcontent_id, $tid);
                            //         date_default_timezone_set('Asia/Dhaka');
                            //         $servertime = time();
                            //         $leave_year = date("Y", $servertime); 
                            //         $total_leave_spent_query=$this->emp_leave_model->getemp_spentleave($defaultcontent_id, $tid, $leave_year);
                            //         $total_leave_spent=0;
                            //         $leave_spent_date="";
                            //         foreach ($total_leave_spent_query as $single_spent_leave) {
                            //          $total_leave_spent=$total_leave_spent+$single_spent_leave['leave_total_day'];
                            //          $leave_spent_date .="<u>".$single_spent_leave['leave_start_date']."</u>, ";
                            //      }
                            //      $available_leave=$total_leave['total_days']-$total_leave_spent;
                            //  }   
                            //  if($total_leave['total_days'] || $total_leave_spent){                            
                            ?>
                                <tr>
                                    <td><?php //print $leavetype; 
                                        ?></td>
                                    <td><?php //if($total_leave){ echo $total_leave['total_days'];} 
                                        ?></td>
                                    <td><?php //if($total_leave_spent){ echo $total_leave_spent;} 
                                        ?></td>
                                    <td><?php //if($leave_spent_date){ echo $leave_spent_date;} 
                                        ?></td>
                                    <td><?php //if($available_leave){ echo $available_leave;} 
                                        ?></td>
                                </tr>
                                <?php
                                // }
                                //  } 
                                ?>
                    </tbody>
                </table>   -->
                <?php
                //if($available_leave){ 
                ?>
                <!--          <div class="row">
            <div class="col-md-12 leave-total-days">
                <?php
                // echo "<span class='leave-total-days-span'>Total Available Days=".$available_leave."</span><br>";
                ?>
            </div>
        </div>    -->
                <?php
                // }       
                ?>
                <!--    </div>
        </div>    -->
                <?php
                //} 
                ?>
                <br>
                <br>
                <div id="dialog-form" title="Add Leave">
                    <p class="validateTips"></p>
                    <form>
                        <fieldset>
                            <input type="text" style="display:none" name="emp_hidden_id" id="emp_hidden_id" value="<?php if ($default_emp['emp_id']) {
                                                                                                                        echo $default_emp['emp_id'];
                                                                                                                    } ?>" class="text ui-widget-content ui-corner-all">
                            <label for="leave_category">Leave Type</label>
                            <select name="leave_category" id="leave_category" class="select ui-widget-content ui-corner-all">
                                <option value="">Select</option>
                                <?php foreach ($allleavetype as $single_leavetype) {
                                    $id = $single_leavetype['id'];
                                    $leavetype = $single_leavetype['name'];
                                    $vid = $single_leavetype['vid'];
                                    $tid = $single_leavetype['tid'];
                                    $description = $single_leavetype['description'];
                                ?>
                                    <option value="<?php print $tid; ?>"><?php print $leavetype; ?></option>
                                <?php } ?>
                                <option value="cancel_leave">Cancel Leave</option>
                            </select>
                            <label for="available_leave">Available Leave</label>
                            <input type="text" name="available_leave" readonly="readonly" id="available_leave" class="text ui-widget-content ui-corner-all">
                            <label for="leave_start_date">Leave Start Date</label>
                            <input type="text" name="leave_start_date" class="ddatepicker numbersOnly" id="leave_start_date" class="text ui-widget-content ui-corner-all">
                            <label for="leave_end_date">Leave End Date</label>
                            <input type="text" name="leave_end_date" class="ddatepicker numbersOnly" id="leave_end_date" class="text ui-widget-content ui-corner-all">
                            <label for="leave_time_status">Day Status</label>
                            <select name="leave_time_status" id="leave_time_status" class="select ui-widget-content ui-corner-all">
                                <option value="full_day">Full Day</option>
                                <option value="half_day">Half Day</option>
                            </select>
                            <label for="leave_pay_status">Pay Status</label>
                            <select name="leave_pay_status" id="leave_pay_status" class="select ui-widget-content ui-corner-all">
                                <option value="payable">Payable</option>
                                <option value="not_payable">Not Payable</option>
                            </select>
                            <label for="justification">Justification</label>
                            <input type="text" name="justification" id="justification" class="text ui-widget-content ui-corner-all">
                            <label for="leave_address">Leave Address</label>
                            <input type="text" name="leave_address" id="leave_address" class="text ui-widget-content ui-corner-all">
                            <label for="leave_approve_status">Leave Approve Status</label>
                            <select name="leave_approve_status" id="leave_approve_status" class="select ui-widget-content ui-corner-all">
                                <option value="approved">Approved</option>
                                <option value="pending">Pending</option>
                            </select>
                            <!-- Allow form submission with keyboard without duplicating the dialog button -->
                            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!--Chosen-->
    <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.jquery.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
    <script>
        $(document).ready(function() {
            $(".exportToExcel").click(function(e) {
                var table = $('#table2excel');
                if (table && table.length) {
                    var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
                    $(table).table2excel({
                        exclude: ".noExl",
                        name: "Leave Report",
                        filename: "leave_report" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                        fileext: ".xls",
                        exclude_img: true,
                        exclude_links: true,
                        exclude_inputs: true,
                        preserveColors: preserveColors
                    });
                }
            });
        });

        function PrintDiv() {
            var divToPrint = document.getElementById('display_report');
            var popupWin = window.open('', '_blank', 'width=800,height=auto');
            popupWin.document.open();
            var a = '<div style="width="100%; margin:0 auto;display:block;">\n\
        <div style="float:left;width:100%;text-align:right;">\n\
    \n\
    </div>\n\
    <div class="" style="line-height:40px;text-align: center;font-size:20px;color:black;font-weight:bold;text-decoration:underline;"> \n\
    <span style="padding-left:8px;font-family:Verdana, Geneva, sans-serif">Daily Present Report <br><?php print $nowbigmonth; ?></span>' +
                '</div>\n\
    </div><br>';
            popupWin.document.write('<html><head><title>Daily Present Report </title>\n\
    \n\
    \n\
    \n\
    \n\
    <style> body{ text-align:center;font-size:15px;margin:0 auto;}table{margin:0 auto;}table, th, td {padding-left:5px;padding-right:5px;font-size:10px;border: 1px solid black; border-collapse: collapse;}th{background: #DCDCDC; border-top:2px solid #000;} tr:nth-child(even) {background: #DCDCDC }tr:nth-child(odd) {background: #FFF}</style>\n\
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