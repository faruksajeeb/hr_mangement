<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Movement Order </title>

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
                text-align: left !important ;
            }
            .emp-info-value{
                text-align: left !important ;
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
                                    <p style="padding:5px; background-color: #000; color:#FFF; border-radius: 5px; width:200px;margin:0 auto; ">Employee Movement Order</p>
                                </div>

                            </div>
                            <hr/>



                            <div class="emp_info" style="">
                                <div class="row">
                                    <div class="col-md-12" style='width:100%; border:1px solid #ccc; padding:2px;'>
                                        <div class="row" style="width:100%">

                                            <table width="100%" style="margin-left:20px;"  cellpadding="30" >
                                                <tr>
                                                    <td class="emp-lavel">Employee Name: </td><td class="emp-info-value" style="text-align:left"><?php echo $empDailyMovementInfo->emp_name; ?></td>   
                                                    <td class="emp-lavel">Employee ID: </td><td class="emp-info-value"><?php echo $empDailyMovementInfo->emp_id; ?></td>  
                                                                                                      
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel">Designation: </td><td class="emp-info-value"><?php echo $empDailyMovementInfo->designation_name; ?></td>
                                                    <td class="emp-lavel">Application Date : </td><td class="emp-info-value"><?php echo $empDailyMovementInfo->entry_date; ?></td> 
                                                    <!--<td class="emp-lavel">Joining Date: </td><td class="emp-info-value"><?php echo date("j M, Y", strtotime($empLeaveAppInfo->joining_date)); ?></td>-->
                                                </tr>
<!--                                                <tr>
                                                    
                                                    <td class="emp-lavel">Service Length: </td><td class="emp-info-value"><?php
//                                                        $joining_date_arr = explode('-', $empLeaveAppInfo->joining_date);
//                                                        $joining_date_reversed = $joining_date_arr[2] . "-" . $joining_date_arr[1] . "-" . $joining_date_arr[0] . " 00:00:00";
//                                                        $jo = strtotime($joining_date_reversed);
//                                                        date_default_timezone_set('Asia/Dhaka');
//                                                        $now = time();
//                                                        $removed = timespan($jo, $now);
//                                                        $pieces = explode(",", $removed);
//                                                        foreach ($pieces as $key => $ll) {
//                                                            if (strpos($ll, 'Hour') !== false || strpos($ll, 'Minute') !== false) {
//                                                                unset($pieces[$key]);
//                                                            }
//                                                        }
//                                                        $string = rtrim(implode(',', $pieces), ',');
//                                                        echo $string;
                                                        ?></td>
                                                </tr>-->
                                                <tr>
                                                    <td class="emp-lavel">Department: </td><td class="emp-info-value"><?php echo $empDailyMovementInfo->department_name; ?></td>
                                                    <td class="emp-lavel">Date Of Movement: </td><td class="emp-info-value"><?php echo $empDailyMovementInfo->attendance_date; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel">Work Location: </td><td class="emp-info-value"><?php echo $empDailyMovementInfo->designation_name; ?></td>
                                                    <td class="emp-lavel">Contact Number: </td><td class="emp-info-value"><?php echo $empDailyMovementInfo->religion; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel" >Informed Earlier For Such Movement: </td>
                                                    <td class="emp-info-value" style="text-align:left;" colspan="3"><?php echo $empDailyMovementInfo->informed_earlier; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel" >Type Of Movement: </td>
                                                    <td class="emp-info-value" style="text-align:left;" colspan="3"><?php echo $empDailyMovementInfo->type_of_movement; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel" >Reason For Movement: </td>
                                                    <td class="emp-info-value" style="text-align:left;" colspan="3"><?php echo $empDailyMovementInfo->reason; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel">Out/ Start Time: </td><td class="emp-info-value"><?php echo $empDailyMovementInfo->out_time; ?></td>   
                                                    <td class="emp-lavel">Expected In Time: </td><td class="emp-info-value"><?php echo $empDailyMovementInfo->expected_in_time; ?></td>  
                                               </tr>
                                               <tr>
                                                    <td class="emp-lavel">Location Form: </td><td class="emp-info-value"><?php echo $empDailyMovementInfo->location_from; ?></td>   
                                                    <td class="emp-lavel">Location To: </td><td class="emp-info-value"><?php echo $empDailyMovementInfo->location_to; ?></td>  
                                               </tr>
                                               <tr>
                                                    <td class="emp-lavel" >Possibility Of Return: </td>
                                                    <td class="emp-info-value" style="text-align:left;" colspan="3"><?php echo $empDailyMovementInfo->possibility_of_return; ?></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td colspan="">
                                                        <br><br>
                                                            
                                                        <p style=" font-style: italic;font-family: monospace">
                                                            <?php
                                                            echo $empDailyMovementInfo->emp_name."<br><span style='font-style: italic;font-size: 10px;'>".$empDailyMovementInfo->designation_name."</span><br>".$empDailyMovementInfo->entry_date;
                                                            ?>
                                                        </p><br>
                                                            <span style="font-weight: bold; ">Applicant's Signature </span>
                                                    </td>
                                                    <td style="text-align: right;">
                                                        <span style="font-weight: bold; font-style: italic;text-align: right;">
                                                            <p style="color:fff"></p>
                                                            <br><br><br><br><br><br>
                                                            Recomended By: <br>Supervisor</span></td>
                                                    <td colspan="2"  style="text-align: right;font-weight: bold; font-style: italic;">
                                                        <p style="color:fff"></p>
                           <?php
                            if ($empDailyMovementInfo->first_approval == 1) {
                                ?>
                                    <img src="<?php echo base_url(); ?>resources\images\signature\approved_by.jpg" alt="Approved By Accounts" width="18%" height="60" /><br>
                                <?php
                            }else{
                                echo "<br><br><br><br>";
                            }
                            ?>
                                                        Approved By:<br/><span style=""> (Department Of Head)</span></td>

                                                </tr>
                                                
                                                <tr>
                                                    <td class="emp-lavel" colspan="3">To : HR Division</td><td class="emp-info-value"><?php echo $paySlipInfo->designation_name; ?></td>
                                                    <!--<td class="emp-lavel">Leave Availed(Paid): </td><td class="emp-info-value"><?php echo $paySlipInfo->religion; ?></td>-->
                                                </tr>
                                            </table> 
                                            <table style="width:100%;margin-left: 20px; border: 1px solid #ccc" cellspacing="0">
                                                <tr>
                                                    <td class="emp-lavel" colspan="2">Comment(If any): </td><td class="emp-info-value"><?php echo $paySlipInfo->designation_name; ?></td>
                                                    <!--<td class="emp-lavel">Leave Availed(Paid): </td><td class="emp-info-value"><?php echo $paySlipInfo->religion; ?></td>-->
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel" colspan="2">. </td><td class="emp-info-value"><?php echo $paySlipInfo->designation_name; ?></td>
                                                    <!--<td class="emp-lavel">Leave Availed(Paid): </td><td class="emp-info-value"><?php echo $paySlipInfo->religion; ?></td>-->
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel" colspan="2">. </td><td class="emp-info-value"><?php echo $paySlipInfo->designation_name; ?></td>
                                                    <!--<td class="emp-lavel">Leave Availed(Paid): </td><td class="emp-info-value"><?php echo $paySlipInfo->religion; ?></td>-->
                                                </tr>
                                                <tr>
                                                    <td colspan=""><span style="font-weight: bold; font-style: italic;">
                                                            <p style="color:fff"></p><br><br><br>Recorded By <br/> HR Executive</span>
                                                    </td>
                                                    <td style="text-align: right;"><span style="font-weight: bold; font-style: italic;text-align: right;"><p style="color:fff"></p><br><br><br>Recomended By: <br>Supervisor</span></td>
                                                    <td colspan="2"  style="text-align: right;font-weight: bold; font-style: italic;">
                                                        <p style="color:fff"></p>
                                                        
                                                        <?php
                            if ($empDailyMovementInfo->second_approval == 1) {
                                ?>
                                    <img src="<?php echo base_url(); ?>resources\images\signature\approved_by.jpg" alt="Approved By Accounts" width="18%" height="60" /><br>
                                <?php
                            }else{
                                echo "<br><br><br>";
                            }
                            ?>
                                                        
                                                        Approved By:<br/><span style=""> (Administrator)</span></td>

                                                </tr>
                                            
                                            </table>
                                            
                                             
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