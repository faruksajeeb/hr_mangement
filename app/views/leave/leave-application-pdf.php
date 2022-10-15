<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Leave Application | <?php echo $empLeaveAppInfo->emp_name; ?></title>

        <style>
            body{
                background-color: #ffffff;
            }
            .container-fluid{
                width: 100%;
                background-color: #ffffff;
                padding: 0!important;
                margin: 0;
            }

            .under-header-bar {
                min-height: 13px;
                background: #ffffff;
                padding: 3px;
                color: #fff;
                font-weight: bold;
            }
            body{
                -webkit-print-color-adjust:exact;
                color: #696969;
                line-height: 1;
                font-family: Arial,sans-serif; 
                background: none;
                background-color: white;
                background-image: none;
                font-size: 13px;

            }
            html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
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
                margin-top: 4px!important;
            }
            .row {
                margin-left: -15px;
                margin-right: -15px;
            }
            .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
                float: left;
            }
            .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
                position: relative;
                min-height: 1px;
                padding-left: 15px;
                padding-right: 15px;
            }

            .red-color{
                color: red!important;
                -webkit-print-color-adjust: exact;
            }

            #logo-img{
                height: 70px;
                width: 75px;
            }

            #example td, th {
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
            #example td, th {
                padding: 0.10em 0.80em 0.20em 0.80em;
                text-align: center;
            }
        </style>
        <style  type="text/css" media="print">
            @page 
            {
                size: auto;   
                margin-bottom: 0px; 
                 /*margin-left: 30px;*/ 
                margin-top: 35px; 
                 /*margin-right: 30px;*/ 
                margin-bottom: 0mm;
            }
            body 
            {
                font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; 
                color: #000;
            }
            .row{
                margin-bottom: 5px!important;
            }
            .red-color{color: red;}
            .blue-color{    color: #210EFF;
                            font-weight: bold;}
            .float_left{float: right;}
            #employee-img{
                border: 1px solid #ccc;

            }
            .salary_info{ 
                border-collapse:separate; 
                border-spacing:0 4px; 
                margin-left:20px;
                border:1px dotted #ccc;
            } 
            .heading_table{
                color:#FFF;
                text-align: center;
            }

            .emp-info-value{
                font-weight: bold;
                border-bottom: 1px dotted #CCC;
                vertical-align: top;
                width:29%;
            }
            .emp-lavel{
                border-bottom: 1px dotted #CCC;
                padding-left: 10px;
                vertical-align: top;
                width:21%;
                /*text-align: right;*/
            }
            td{
                padding: 5px;
            }
        </style>
    </head>
    <body class="logged-in dashboard current-page print-attendance">
        <!-- Page Content -->  
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php
                ?>

                <div class="wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row" style="font-weight:normal;">
                                <div class="col-md-2" style="width:80px; float: left"> <img src="<?php echo base_url(); ?>resources/images/logo.png" alt="" id="logo-img"/></div>
                                <div class="col-md-8" style="width:600px; text-align: center;  float: right;padding-left: -100px;">
                                    <h1 style="font-size:25px;font-weight:bold">
                                        AHMED AMIN GROUP
                                        <?php //echo $paySlipInfo->company_name; ?>
                                    </h1>
                                    <p>House #25, Road #34, Gulshan-2, Dhaka-1212</p>
                                    <br/>
                                    <p style="padding:5px; background-color: #000; color:#FFF; border-radius: 5px; width:200px;margin:0 auto; ">Leave Application</p>
                                </div>

                            </div>
                            <hr/>



                            <div class="emp_info" style="">
                                <div class="row">
                                    <div class="col-md-12" style='width:100%; border:1px solid #ccc; padding:2px;'>
                                        <div class="row" style="width:100%">

                                            <table width="100%" style="margin-left:20px;"  cellpadding="30">
                                                <tr>
                                                    <td class="emp-lavel">Employee ID: </td><td class="emp-info-value"><?php echo $empLeaveAppInfo->emp_id; ?></td>                                                    
                                                    <td class="emp-lavel">Date: </td><td class="emp-info-value"><?php echo $empLeaveAppInfo->leave_start_date; ?></td>                                                   
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel">Employee Name: </td><td class="emp-info-value"><?php echo $empLeaveAppInfo->emp_name; ?></td>
                                                    <td class="emp-lavel">Joining Date: </td><td class="emp-info-value"><?php echo date("j M, Y", strtotime($empLeaveAppInfo->joining_date)); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel">Division: </td><td class="emp-info-value"><?php echo $empLeaveAppInfo->division_name; ?></td>
                                                    <td class="emp-lavel">Service Length: </td><td class="emp-info-value"><?php
                                                        $joining_date_arr = explode('-', $empLeaveAppInfo->joining_date);
                                                        $joining_date_reversed = $joining_date_arr[2] . "-" . $joining_date_arr[1] . "-" . $joining_date_arr[0] . " 00:00:00";
                                                        $jo = strtotime($joining_date_reversed);
                                                        date_default_timezone_set('Asia/Dhaka');
                                                        $now = time();
                                                        $removed = timespan($jo, $now);
                                                        $pieces = explode(",", $removed);
                                                        foreach ($pieces as $key => $ll) {
                                                            if (strpos($ll, 'Hour') !== false || strpos($ll, 'Minute') !== false) {
                                                                unset($pieces[$key]);
                                                            }
                                                        }
                                                        $string = rtrim(implode(',', $pieces), ',');
                                                        echo $string;
                                                        ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel">Department: </td><td class="emp-info-value"><?php echo $empLeaveAppInfo->department_name; ?></td>
                                                    <td class="emp-lavel">Gender: </td><td class="emp-info-value"><?php echo $empLeaveAppInfo->gender; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel">Designation: </td><td class="emp-info-value"><?php echo $empLeaveAppInfo->designation_name; ?></td>
                                                    <td class="emp-lavel">Location: </td><td class="emp-info-value"><?php //echo $empLeaveAppInfo->religion; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel">Leave From: </td><td class="emp-info-value"><?php echo $empLeaveAppInfo->leave_start_date; ?></td>
                                                    <td class="emp-lavel">Leave To: </td><td class="emp-info-value"><?php echo $empLeaveAppInfo->leave_end_date; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel">Total Leave: </td><td class="emp-info-value">
                                                        <?php
                                                    $year=date('Y');
                                                    $contentId = $empLeaveAppInfo->content_id;
                                                    $leaveYear="01-01-$empLeaveAppInfo->leave_year";
                                                    $data['emp_total_leave'] = $this->emp_yearly_leave_history_model->getemp_yearlyleave_historybydate($contentId, $leaveYear); 
                                                    echo $data['emp_total_leave'];
                                                    ?></td>
                                                    <td class="emp-lavel">Leave Availed(Paid): </td><td class="emp-info-value">                                                        
                                                        <?php
                                                        $leaveAvailed = $this->db->query("SELECT SUM(leave_total_day) AS totalLeaveAvailed FROM emp_leave WHERE content_id='$contentId' AND leave_year='$empLeaveAppInfo->leave_year' AND pay_status='payable' AND approve_status='approved' ")->row();
                                                        echo $leaveAvailed->totalLeaveAvailed;
                                                        
                                                        ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel" >Type Of Leave: </td>
                                                    <td class="emp-info-value" style="text-align:left;" colspan="3"><?php echo $empLeaveAppInfo->leaveType; ?></td>
                                                    <!--<td class="emp-lavel">Leave Availed(Paid): </td><td class="emp-info-value"><?php echo $empLeaveAppInfo->religion; ?></td>-->
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel" >Purpose Of Leave: </td><td colspan="3" class="emp-info-value"><?php echo $empLeaveAppInfo->justification; ?></td>
                                                    <!--<td class="emp-lavel">Leave Availed(Paid): </td><td class="emp-info-value"><?php echo $empLeaveAppInfo->religion; ?></td>-->
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel" >Contact Address While On Leave: </td><td colspan="3" class="emp-info-value"><?php echo $empLeaveAppInfo->leave_address; ?></td>
                                                    <!--<td class="emp-lavel">Leave Availed(Paid): </td><td class="emp-info-value"><?php echo $empLeaveAppInfo->religion; ?></td>-->
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel" >Responsibilities/ Liabilities Hand Over To: </td><td colspan="3" class="emp-info-value"><?php echo $empLeaveAppInfo->responsibilities; ?></td>
                                                    <!--<td class="emp-lavel">Leave Availed(Paid): </td><td class="emp-info-value"><?php echo $empLeaveAppInfo->religion; ?></td>-->
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel" >Contact Address: </td><td colspan="3" class="emp-info-value"><?php echo $empLeaveAppInfo->leave_address; ?></td>
                                                    <!--<td class="emp-lavel">Leave Availed(Paid): </td><td class="emp-info-value"><?php echo $empLeaveAppInfo->religion; ?></td>-->
                                                </tr>
                                                <tr>
                                                    <td colspan="">
                                                        <br>
                                                            
                                                        <p style=" font-style: italic;font-family: monospace">
                                                            <?php
                                                            echo $empLeaveAppInfo->emp_name."<br><span style='font-style: italic;font-size: 10px;'>".$empLeaveAppInfo->designation_name."</span><br>".$empLeaveAppInfo->created_time;
                                                            ?>
                                                        </p><br>
                                                            <span style="font-weight: bold; ">Applicant's Signature </span>
                                                    </td>
                                                    <td style="text-align: right;"><span style="font-weight: bold; font-style: italic;text-align: right;">
                                                            
                                                            <?php
                            if ($empLeaveAppInfo->department_approval == 1) {
                                ?>
                                                            <img src="<?php echo base_url(); ?>resources\images\signature\approved_by.jpg" alt="Approved By Accounts" width="18%" height="80" /><br>
                                <?php
                            }else{
                                echo "<br><br><br><br>";
                            }
                            ?>
                                                            Recomended By: 
                                                            <br>Head Of Department</span>
                                                    </td>
                                                    <td colspan="2"  style="text-align: right;font-weight: bold; font-style: italic;">
                                                     
                                                         <?php
                            if ($empLeaveAppInfo->approve_status == "approved") {
                                ?>
                                                            <img src="<?php echo base_url(); ?>resources\images\signature\approved_by.jpg" alt="Approved By Accounts" width="18%" height="80" /><br>
                                <?php
                            }else{
                                echo "<br><br><br><br><br><br>";
                            }
                            ?>
                                                        Approved By:<br/><span style=""> (Administration)</span></td>

                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel" colspan="3">Comment(If any): </td><td class="emp-info-value"><?php echo $paySlipInfo->designation_name; ?></td>
                                                    <!--<td class="emp-lavel">Leave Availed(Paid): </td><td class="emp-info-value"><?php echo $paySlipInfo->religion; ?></td>-->
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel" colspan="3">. </td><td class="emp-info-value"><?php echo $paySlipInfo->designation_name; ?></td>
                                                    <!--<td class="emp-lavel">Leave Availed(Paid): </td><td class="emp-info-value"><?php echo $paySlipInfo->religion; ?></td>-->
                                                </tr>
<!--                                                <tr>
                                                    <td class="emp-lavel" colspan="3">. </td><td class="emp-info-value"><?php echo $paySlipInfo->designation_name; ?></td>
                                                    <td class="emp-lavel">Leave Availed(Paid): </td><td class="emp-info-value"><?php echo $paySlipInfo->religion; ?></td>
                                                </tr>-->
                                                <tr>
                                                    <td class="emp-lavel" colspan="3">To : HR Division</td><td class="emp-info-value"><?php echo $paySlipInfo->designation_name; ?></td>
                                                    <!--<td class="emp-lavel">Leave Availed(Paid): </td><td class="emp-info-value"><?php echo $paySlipInfo->religion; ?></td>-->
                                                </tr>
                                            </table> 
                                            <table style="width:100%;margin-left: 20px;" border='1' cellspacing="0">
                                                <tr style="background:#DCDCDC; ">
                                                    <td colspan="" style="text-align:left;"> Leave Status</td>
                                                    <td style="text-align:center;"> Casual Leave</td>
                                                    <td style="text-align:center;">Sick Leave</td>
                                                    <td style="text-align:center;">Annual Leave</td>
                                                    <td style="text-align:center;">others</td>
                                                </tr>
                                                <tr style="">
                                                    <td colspan="" style="text-align:left;">At Credit</td>
                                                    <td style="text-align:center;"> </td>
                                                    <td style="text-align:center;"></td>
                                                    <td style="text-align:center;"></td>
                                                    <td style="text-align:center;"></td>
                                                </tr>
                                                <tr style="">
                                                    <td colspan="" style="text-align:left;">Leave Applied For</td>
                                                    <td style="text-align:center;"> </td>
                                                    <td style="text-align:center;"></td>
                                                    <td style="text-align:center;"></td>
                                                    <td style="text-align:center;"></td>
                                                </tr>
                                                <tr style="">
                                                    <td colspan="" style="text-align:left;">Balance</td>
                                                    <td style="text-align:center;"> </td>
                                                    <td style="text-align:center;"></td>
                                                    <td style="text-align:center;"></td>
                                                    <td style="text-align:center;"></td>
                                                </tr>
                                            
                                            </table>
                                            <div style="margin: 80px 0 0 30px">
                                                 Recorded By: <br/> Executive HRD 
                                            </div>
                                             
                                        </div>



                                    </div>

                                </div>





                            </div>
                        </div>
                    </div> 

                              
                </div>              
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->        
</body>
</html>