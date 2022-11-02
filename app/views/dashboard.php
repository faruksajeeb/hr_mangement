<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS- Home</title>
    <?php
    $this->load->view('includes/cssjs');
    ?>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                // $("#errors").hide("slide", {direction: "up" }, "slow"); 
                // $(".alert").hide("slide", {direction: "up"}, "slow");

            }, 80000);
        });
    </script>
    <style>
        .short_info_div .value {
            font-size: 35px;
            padding-top: 10px
        }

        .short_info_div {
            border: 10px solid #FFFFFF;
            border-radius: 5px;
            background-color: #fe821e;
            box-shadow: -2px 2px #CCC;
            padding: 15x;
            font-size: 25px;
            color: white;
            text-align: center;
            background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.2) 49%, rgba(0, 0, 0, 0.15) 51%, rgba(0, 0, 0, 0.05));
            background-repeat: repeat-x;
        }
    </style>
</head>

<body class="logged-in dashboard">
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php
            $this->load->view('includes/menu');
            ?>
           
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <?php
                        $msg = $this->session->flashdata('success');
                        if ($msg) {
                        ?>
                            <br />
                            <div class="alert alert-success text-center">
                                <strong> <?php echo $msg ?></strong>
                            </div>
                        <?php
                        }
                        $msg = null;
                        ?>
                    </div>
                    <div class="col-md-3"></div>

                </div>
                <div class="row" style="margin:0 20px 20px 20px;">
                    <div class='col-md-3 short_info_div' style="padding:20px ;">
                        <div class="row">
                            <div class="col-md-3">
                                <i class="fa fa-users" style="font-size:50px"></i>
                            </div>
                            <div class="col-md-9">
                                Total Employee <br />
                                <div class="value"><?php echo $total_employee; ?></div>
                            </div>
                        </div>                        
                    </div>
                    <a href="<?php echo base_url(); ?>today_present">
                        <div class='col-md-3 short_info_div' style="padding:20px ;">
                            <div class="row">
                                <div class="col-md-3">
                                    <i class="fa fa-users" style="font-size:50px"></i>
                                </div>
                                <div class="col-md-9">
                                    Total Present <br />
                                    <div class="value"><?php echo $total_present; ?></div>
                                </div>
                            </div>                        
                        </div>
                    </a>
                    <a href="<?php echo base_url(); ?>today_absent">
                        <div class='col-md-3 short_info_div' style="padding:20px ;">
                            <div class="row">
                                <div class="col-md-3">
                                    <i class="fa fa-users" style="font-size:50px"></i>
                                </div>
                                <div class="col-md-9">
                                    Total Absent <br />
                                    <div class="value"><?php echo $total_employee - $total_present; ?></div>
                                </div>
                            </div>                        
                        </div>
                    </a>
                    <a href="<?php echo base_url(); ?>daily_leave_report">
                        <div class='col-md-3 short_info_div' style="padding:20px ;">
                            <div class="row">
                                <div class="col-md-3">
                                <i class="fa fa-umbrella-beach"  style="font-size:50px"></i>
                                </div>
                                <div class="col-md-9">
                                    On Leave Today <br />
                                    <div class="value"><?php echo $todaysLeave=0; ?></div>
                                </div>
                            </div>                        
                        </div>
                    </a>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6 ">
                        <div id="division_attendance_overview" style="height: 400px; width: 100%;"></div>

                    </div>
                    <div class="col-md-6 ">
                        <div class="">
                            <!-- <div class="breadcrumb text-center"><b> Department Wise Attendance</b> </div> -->
                        <div id="department_wise_employee" style="height: 400px; width: 100%; background-color:#FFFFFF;overflow:scroll; padding:10px">
                            <div class="card" >
                                <div class="card-header">
                                    <h2 class="text-center" style="font-weight: bold; padding:10px">Department wise employee</h2>
                                </div>
                                <div class="card-body">
                                    <div class="responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="position: sticky;top: 0;z-index: 1;background: #fff;">Department / Branch</th>
                                                    <?php foreach($braches as $branch):?>
                                                    <th style="position: sticky;top: 0;z-index: 1;background: #fff;"><?php echo  $branch->branch_name; ?></th>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($departments as $department):?>
                                                <tr>
                                                    <td><?php echo $department->department_name; ?></td>
                                                    <?php 
                                                    foreach($braches as $branch):
                                                        $empTotal = $this->db->query("SELECT COUNT(emp_department) as empTotal FROM search_field_emp WHERE emp_department=$branch->id AND department_id=$department->id AND type_of_employee NOT IN (153,473)")->row('empTotal');
                                                        ?>
                                                    <td style="text-align:center">
                                                        <?php echo $empTotal; ?>
                                                    </td>
                                                    <?php
                                                endforeach; ?>
                                                </tr>
                                                <?php endforeach; ?>
                                              
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row mt-3">
                    <div class="col-md-12 ">
                        <div class="">
                            <!-- <div class="breadcrumb text-center"><b> Department Wise Attendance</b> </div> -->
                            <div id="employee_attendance_overview" style="height: 400px; width: 100%;"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <?php
                        $userName = $this->session->userdata('user_name');
                        if ($userName == 'ac-sadmin') {
                        ?>
                            <table class="table " style="margin-top:10%;color:blue;">
                                <thead>
                                    <tr class="heading">
                                        <th colspan="2">Notifications</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($approval_notifications as $res_single) {
                                    ?>
                                        <tr>
                                            <td><a href="<?php echo base_url(); ?>pay-slip-approval/<?php echo $res_single->company_id ?>/<?php echo $res_single->month_id; ?>/<?php echo $res_single->year; ?>/<?php echo $res_single->month_name; ?>" target="_blank">
                                                    <?php echo $res_single->company_name . " <strong>" . $res_single->month_name . ", " . $res_single->year . "</strong>"; ?> Pay slips Pending for Approval
                                                </a>
                                            </td>
                                            <td><?php echo $res_single->pending_approval ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php }
                        if ($userName == 'ac-admin') {
                        ?>
                            <table class="table table-condensed" style="margin-top:10%;color:blue;">
                                <thead>
                                    <tr class="heading">
                                        <th colspan="2">Notifications</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($checking_notifications as $res_single) {
                                    ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo base_url(); ?>pay-slip-check/<?php echo $res_single->company_id ?>/<?php echo $res_single->month_id; ?>/<?php echo $res_single->year; ?>/<?php echo $res_single->month_name; ?>" target="_blank">
                                                    <?php echo $res_single->company_name . " <strong><em>" . $res_single->month_name . ", " . $res_single->year . "</em></strong>"; ?> Pay slips Pending for Checking
                                                </a>
                                            </td>
                                            <td><?php echo $res_single->pending_chacking ?></td>
                                        </tr>
                                    <?php }
                                    foreach ($iou_first_approval_notifications as $singleIou) {
                                    ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo base_url(); ?>iou-first-approval" target="_blank">
                                                    IOU Pending for Checking
                                                </a>
                                            </td>
                                            <td><?php echo $singleIou->pending_iou ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php } ?>

                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <?php
    #dd($emp_attendance_data);
    $divAttDataPoints = array();
    foreach ($division_attendance_data as $k => $v) {
        $divAttDataPoints[] = array(
            "y" => $v->TotalEmployee,
            "label" => $v->DivisionName
        );
    }
    $divAttDataPoints2 = array();
    foreach ($division_attendance_data as $k => $v) {
        $divAttDataPoints2[] = array(
            "y" => $v->TotalPresentToday,
            "label" => $v->DivisionName
        );
    }
    // $divAttDataPoints3 = array();
    // foreach ($division_attendance_data as $k => $v) {
    //     $divAttDataPoints3[] = array(
    //         "y" => $v->TotalEmployee-$v->TotalPresentToday,
    //         "label" => $v->DivisionName
    //     );
    // }

    // $depAttDataPoints = array();
    // foreach ($dep_attendance_data as $k => $v) {
    //     $depAttDataPoints[] = array(
    //         "y" => $v->totalPresent,
    //         "label" => $v->DepartmentName
    //     );
    // }
    $empAttDataPoints = array();
    foreach ($emp_attendance_data as $k => $v) {
        $empAttDataPoints[] = array(
            "y" => $v->totalPresent,
            "label" => $v->EmployeeName
        );
    }
    ?>
    <script>
        $(function() {

            
            // Division Overview
            var division_attendance_overview = new CanvasJS.Chart("division_attendance_overview", {
                animationEnabled: true,
                theme: "theme2",
                title: {
                    // text: "Division/ Branch wise attendance (Today)"
                    text: "Branch wise attendance (Today)"
                },
                axisX: {
                    interval: 1,
                    labelFontSize: 10,
                    labelAngle: -45
                },
                axisY: {
                    title: "Total Employee",
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    labelFontSize: 10,
                    tickColor: "#4F81BC"
                },
                toolTip: {
                    shared: true
                },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                data: [{
                        type: "column",
                        color: "#008080",
                        name: "Total Employee",
                        legendText: "Total Employee",
                        showInLegend: true,
                        dataPoints: <?php echo json_encode($divAttDataPoints, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "column",
                        color: "#32cd32", 
                        name: "Total Present",
                        legendText: "Total Present",
                        showInLegend: true,
                        dataPoints: <?php echo json_encode($divAttDataPoints2, JSON_NUMERIC_CHECK); ?>
                    }
                    // ,{
                    //     type: "column",
                    //     name: "Total Absent",
                    //     legendText: "Total Absent",
                    //     showInLegend: true,
                    //     dataPoints: <?php echo json_encode($divAttDataPoints3, JSON_NUMERIC_CHECK); ?>
                    // }
                ]
            });
            division_attendance_overview.render();

            function toggleDataSeries(e) {
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                division_attendance_overview.render();
            }
            // Department Overview
            /*
            var department_attendance_overview = new CanvasJS.Chart("department_attendance_overview", {
                theme: "theme2",
                animationEnabled: true,
                title: {
                    text: "Department wise attendance (Today)"
                },
                axisX: {
                    interval: 1,
                    labelFontSize: 10,
                    labelAngle: -45
                },
                axisY: {
                    //interval: 1000
                },
                data: [{
                    type: "column",
                    dataPoints: <?php echo json_encode($depAttDataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            department_attendance_overview.render();
*/
            // Employee Overview
            var employee_attendance_overview = new CanvasJS.Chart("employee_attendance_overview", {
                theme: "theme2",
                animationEnabled: true,
                title: {
                    text: "Employee wise attendance present overview (Last 30 days)"
                },
                axisX: {
                    interval: 1,
                    labelFontSize: 10,
                    labelAngle: -90
                },
                axisY: {
                    //interval: 1
                },
                data: [{
                    type: "column",
                    dataPoints: <?php echo json_encode($empAttDataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            employee_attendance_overview.render();
        });
    </script>
</body>

</html>