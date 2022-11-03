<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Summery-Attendance</title>
    <?php
    $this->load->view('includes/printcss');
    date_default_timezone_set('Asia/Dhaka');
    $servertime = time();
    $today_date = date("d-m-Y", $servertime);

    $start = microtime(true);
    ?>

    <style>
        body {
            background-color: #ffffff;
        }

        .container-fluid {
            width: 100%;
            background-color: #ffffff;
            padding: 0 !important;
            margin: 0;
        }

        .under-header-bar {
            min-height: 13px;
            background: #ffffff;
            padding: 3px;
            color: #fff;
            font-weight: bold;
        }

        body {
            -webkit-print-color-adjust: exact;
            color: #696969;
            line-height: 1;
            font-family: Arial, sans-serif;
            background: none;
            background-color: white;
            background-image: none;
            font-size: 13px;

        }

        html,
        body,
        div,
        span,
        applet,
        object,
        iframe,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        blockquote,
        pre,
        a,
        abbr,
        acronym,
        address,
        big,
        cite,
        code,
        del,
        dfn,
        em,
        img,
        ins,
        kbd,
        q,
        s,
        samp,
        small,
        strike,
        strong,
        sub,
        sup,
        tt,
        var,
        b,
        u,
        i,
        center,
        dl,
        dt,
        dd,
        ol,
        ul,
        li,
        fieldset,
        form,
        label,
        legend,
        article,
        aside,
        canvas,
        details,
        embed,
        figure,
        figcaption,
        footer,
        header,
        hgroup,
        menu,
        nav,
        output,
        ruby,
        section,
        summary,
        time,
        mark,
        audio,
        video {
            margin: 0;
            padding: 0;
            border: 0;
            vertical-align: baseline;
        }

        .container {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
            padding-left: 2px;
            padding-right: 2px;
            border: 1px solid #000;
        }

        .main-container.container {
            background-color: inherit;
            background-image: none;
            background-repeat: inherit;
            border: 1px solid #000;
            border-style: outset;
            overflow: hidden;
        }

        .container.main-container .row {
            margin-top: 4px !important;
        }

        .row {
            margin-left: -15px;
            margin-right: -15px;
        }

        .col-md-1,
        .col-md-2,
        .col-md-3,
        .col-md-4,
        .col-md-5,
        .col-md-6,
        .col-md-7,
        .col-md-8,
        .col-md-9,
        .col-md-10,
        .col-md-11,
        .col-md-12 {
            float: left;
        }

        .col-xs-1,
        .col-sm-1,
        .col-md-1,
        .col-lg-1,
        .col-xs-2,
        .col-sm-2,
        .col-md-2,
        .col-lg-2,
        .col-xs-3,
        .col-sm-3,
        .col-md-3,
        .col-lg-3,
        .col-xs-4,
        .col-sm-4,
        .col-md-4,
        .col-lg-4,
        .col-xs-5,
        .col-sm-5,
        .col-md-5,
        .col-lg-5,
        .col-xs-6,
        .col-sm-6,
        .col-md-6,
        .col-lg-6,
        .col-xs-7,
        .col-sm-7,
        .col-md-7,
        .col-lg-7,
        .col-xs-8,
        .col-sm-8,
        .col-md-8,
        .col-lg-8,
        .col-xs-9,
        .col-sm-9,
        .col-md-9,
        .col-lg-9,
        .col-xs-10,
        .col-sm-10,
        .col-md-10,
        .col-lg-10,
        .col-xs-11,
        .col-sm-11,
        .col-md-11,
        .col-lg-11,
        .col-xs-12,
        .col-sm-12,
        .col-md-12,
        .col-lg-12 {
            position: relative;
            min-height: 1px;
            padding-left: 15px;
            padding-right: 15px;
        }

        .red-color {
            color: red !important;
            -webkit-print-color-adjust: exact;
        }

        #logo-img {
            height: 70px;
            width: 75px;
        }

        #example td,
        th {
            padding: 0.30em 0.20em;
            text-align: left;
        }

        table tr.heading {
            background: #ddd;
            color: #000;
        }

        tbody tr:nth-child(odd) {
            background: #ffffff;
        }

        table tbody tr {
            background-color: #ffffff;
        }

        table {
            padding: 0;
            margin: 0;
            background-color: #ffffff;
            font-size: 13px;
        }

        #example td,
        th {
            padding: 0.10em 0.80em 0.20em 0.80em;
            text-align: center;
        }
    </style>
    <style type="text/css" media="print">
        @page {
            size: auto;
            margin-bottom: 35px;
            margin-left: 24px;
            margin-top: 35px;
            margin-right: 35px;
            margin-footer: 20mm;
        }

        body {
            font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
            color: #000;
            margin-bottom: 35px;
        }

        .row {
            margin-bottom: 5px !important;
        }

        .red-color {
            color: red;
        }

        .blue-color {
            color: #210EFF;
            font-weight: bold;
        }
    </style>
</head>

<body class="logged-in dashboard current-page print-attendance">
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
          
            <div class="row" style="font-weight:normal">
                <!-- <div class="col-md-12" style="width:595px;"> -->
                <div class="col-md-12">
                    <h1 style="font-size:25px;font-weight:bold;text-align:center">IIDFC Securities Limited</h1>
                    <p style="text-align:center">PFI Tower (Level-3)56-57, Dilkusha C/A, Dhaka-1000, Bangladesh</p>
                   
                </div>
                <!-- <div class="col-md-2" style="width:100px;"> <img src="<?php echo base_url(); ?>resources/images/logo.png" alt=""  id="logo-img"/></div> -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- <p>E-mail :ahmedamingroup@gmail.com, misaag@ahmedamin.com</p> -->
                </div>
            </div>
            <div class="row under-header-bar text-center">
                <h1 style="font-size:20px;font-weight:bold">Monthly Attendance Summery Report<br><?php echo $nowbigmonth; ?></h1>
            </div>
            <div class="emp_info">
                <div class="row">
                    <div class="col-md-1" style="width:110px;">Company Name:</div>
                    <div class="col-md-9" style="width:400px;"><?php echo $company_name; ?></div>
                    <div class="col-md-1" style="width:35px;">From:</div>
                    <div class="col-md-1" style="width:78px;"><?php print $start_date; ?></div>
                </div>
                <div class="row">
                    <div class="col-md-1" style="width:110px;">Division:</div>
                    <div class="col-md-9" style="width:400px;"><?php print $division_name; ?></div>
                    <div class="col-md-1" style="width:35px;">To:</div>
                    <div class="col-md-1" style="width:78px;"><?php print $end_date; ?></div>
                </div>
            </div>
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">

                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr class="heading" style="border:2px solid #000;font-size:12px;">
                                    <th>SL.</th>
                                    <th>Face ID</th>
                                    <th>Employee</th>
                                    <th>Designation</th>
                                    <th>Late In</th>
                                    <th>Early Out</th>
                                    <th>Daily Mov.</th>
                                    <th>Total Leave</th>
                                    <th>Absent</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 1;
                                
                                foreach ($records as $v) {
                                ?>
                                    <tr style="border:1px solid #000;border-bottom:none;border-left:none;border-right:none;">
                                        <td><?php echo $counter++; ?></td>
                                        <td style="text-align:left"><?php echo $v['employee_id']; ?></td>
                                        <td style="text-align:left"><?php echo $v['employee_name']; ?></td>
                                        <td style="text-align:left"><?php echo $v['emp_designation']."-".$v['emp_grade']; ?></td>
                                        <td><?php echo $v['total_late']; ?></td>
                                        <td><?php echo $v['total_early']; ?></td>
                                        <td><?php echo $v['total_daily_movement']; ?></td>
                                        <td><?php echo $v['total_leave']; ?></td>
                                        <td><?php echo $v['total_absent']; ?></td>
                                        <td><?php echo $v['total_attendance_not_required']>0?'Attendance Not Required':''; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>

                        <htmlpagefooter name="MyFooter1">
                            <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 10pt; 
                                       color: #000000; font-weight: bold; font-style: italic;text-align: left; ">
                                <tr style="margin-bottom:10px;">
                                    <td width="25%"><span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000;">Prepared By:<br><br></span></td>
                                    <td width="25%"><span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000;">Checked By:<br><br></span></td>
                                    <td width="25%" style="font-weight: bold; font-style: italic;"><span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000;">Recommended By:<br><br></span></td>
                                    <td width="25%" style="text-align: right; "><span style="height:50px;font-weight: bold; font-style: italic;border-bottom:2px solid #000;">Approved By:<br><br></span></td>
                                </tr>
                                <tr>
                                    <td width="25%"><span style="font-weight: bold; font-style: italic;">
                                            <p style="color:fff"></p><br>HR Executive
                                        </span></td>
                                    <td width="25%"><span style="font-weight: bold; font-style: italic;">
                                            <p style="color:fff"></p><br>Head Of Account
                                        </span></td>
                                    <td width="25%" style="font-weight: bold; font-style: italic;">
                                        <p style="color:fff"></p><br>Deputy CEO
                                    </td>
                                    <td width="25%" style="text-align: right;">
                                        <p style="color:fff"></p><br><br />CEO
                                        <!-- <br /><span style="">(Administration) -->

                                        </span>
                                    </td>
                                </tr>
                            </table>
                            <br> <br> <br> <br> <br>
                            <span style="font-size:8px;font-style:italic">

                                <?php
                                $end = microtime(true);
                                $exe_time = $end - $start;
                                //echo "Report generated time: " . number_format($exe_time, 2) . " Seconds.";
                                echo "Report generated by HR Software at " . $nowdate . " " . $nowtime;
                                ?>

                            </span>
                        </htmlpagefooter>
                        <sethtmlpagefooter name="MyFooter1" value="on" />

                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->

</body>

</html>