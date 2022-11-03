<?php

//foreach (range(0, 100, 3) as $number) {
//    echo $number ."<br/>";
//}
//exit();
?>
<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Attendance Summery Reports</title>
        <?php
//  echo '<pre>'; 
//  print_r($default_employee); 
//  echo '</pre>';
//  
//
        //exit();
        //Keyboard shortcut for comment Ctrl+Shift+c
        $this->load->view('includes/printcss');
        date_default_timezone_set('Asia/Dhaka');
        $servertime = time();
        $today_date = date("d-m-Y", $servertime);
        ?> 


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
                height: 42px;
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
                margin-bottom: 35px; 
                margin-left: 24px; 
                margin-top: 35px; 
                margin-right: 35px; 
                margin-footer: 20mm;
            }
            body 
            {
                font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; 
                color: #000;
                margin-bottom: 35px; 
            }
            .row{
                margin-bottom: 5px!important;
            }
            .red-color{color: red;}
            .blue-color{    color: #210EFF;
                            font-weight: bold;}

            </style>  
<!-- jQuery Plugin -->

<style>
  

</style>
<script language="JavaScript">  

    </script>  
        </head>

        <body class="logged-in dashboard current-page print-attendance">

        <!-- Page Content -->  
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php
                date_default_timezone_set('Asia/Dhaka');
                $servertime = time();
                $lastdateofattendance = end($date_range);
                $now = date("d-m-Y H:i:s", $servertime);
                $nowdate = date("d-m-Y", $servertime);
                $thisyear = date("Y", $servertime);
                $datee = date_create($lastdateofattendance);
                $nowbigmonth = date_format($datee, 'F Y');
                $nowtime = date("H:i:s a", $servertime);
                $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
                $last_day_this_month = date('t-m-Y');
                ?>
                <div class="row" style="font-weight:normal">
                    <div class="col-md-2" style="width:100px;  " > 
                        <!-- <img src="<?php echo base_url(); ?>resources/images/logo.png" style="margin-top:-5px;" alt="" id="logo-img"/> -->
                    </div>               
                    <div class="col-md-6" >
                        <h1 style="font-size:25px;font-weight:bold;color:#d73d37; margin-left: -55px;">IIDFC Securities Limited</h1>                      
                    </div>
                </div>
                <div class="row" style="border-bottom:1px solid #000;">
                    <div class="col-md-12">
                          <!-- <p>House #25, Road #34, Gulshan-2, Dhaka-1212</p>
                        <p>Telephone: +8802-8812396, 9880916, 9881424, 8818561, 9892111</p>
                        <p>Fax: +8802-8826439, 9880918</p>
                        <p>E-mail : info@ahmedamin.com, cocdhaka@ahmedamin-bd.com, ahmedamingroup@gmail.com, misaag@ahmedamin.com</p> -->
                        <br/>
                    </div>
                </div>
                
                <div class="row under-header-bar text-center"> 
                    <h1 style="font-size:20px;font-weight:bold">Monthly Attendance Summery Reports<br><?php print $nowbigmonth; ?></h1>         
                </div> 
                <div class="emp_info">
                    <div class="row">
                        <div class="col-md-1" style="width:110px;">Division Name:</div>
                        <div class="col-md-9" style="width:400px;"><?php print $defsultdivision_name; ?></div>
                        <div class="col-md-1" style="width:35px;">Date:</div>
                        <div class="col-md-1" style="width:78px;"><?php print $nowdate; ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"  style="width:110px;">Date Range:</div>
                        <div class="col-md-9" style="width:400px;"><?php echo "From: ". date("d-m-Y", strtotime($start_date)). " To: ".  date("d-m-Y", strtotime($end_date)); ?></div>
              
                        <div class="col-md-1" style="width:35px;">Time:</div>
                        <div class="col-md-1" style="width:78px;"><?php print $nowtime; ?></div>
                    </div>                                               
                </div>               
                <div class="wrapper">
                    <div class="row">
                        <div class="col-md-12">

                            <table id="example" class="display" border="1" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="heading" style="border:2px solid #000;font-size:12px;">
                                        <th>SL.</th>
                                        <th>Employee ID</th>
                                        <th>Employee Name</th>
                                        <th>Designation</th>
                                    <!--    <th>Total Present</th> -->
                                        <th>Total Late-in</th>
                                        <th>Total Early-out</th>
<!--                                        <th>Late & Early</th>-->
                                        <th>Daily Movement</th>
                                        <th>Total Leave</th>
<!--                                        <th>Total WeeklyHolidays</th>
                                        <th>Total yearly holiday</th>-->
                                        <th>Absent/ OT Day</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
//  echo '<pre/>';
//  print_r($default_employee);  
//
//  exit();
                                    $counter = 1;
                                    foreach ($default_employee as $single_emp) {
                                        ?>

                                        <tr style="">
                                            <td><?php echo $counter; ?></td>
                                            <td style="text-align:left"><?php echo $single_emp->emp_id; ?></td>
                                            <td style="text-align:left"><?php echo $single_emp->emp_name; ?></td>
                                            <td style="text-align:left"><?php echo $single_emp->designation; ?></td>
                                           <!-- <td></td> -->
                                           <?php
                                                if ($single_emp->total_present) {

                                                    $total_present = $single_emp->total_present;
                                                //    echo $total_present;
                                                } else {
                                                    $total_present = '0';
                                                //    echo $total_present ;
                                                }
                                                ?>
                                            <td><?php
                                            
                                                if ($single_emp->total_latein) {
                                                    $total_latein = $single_emp->total_latein;
                                                    echo $total_latein+$single_emp->total_late_early;
                                                } else {
                                                    $total_latein = '0';
                                                    echo $total_latein+$single_emp->total_late_early;
                                                }
                                          
                                                ?></td>
                                            <td><?php
                                            // Count Late & Early....................................
                                                if ($single_emp->total_late_early) {
                                                    $total_late_early = $single_emp->total_late_early;
                                                } else {
                                                    $total_late_early = '0';
                                                }
                                                
                                                if ($single_emp->total_earlyout) {
                                                    $total_earlyout = $single_emp->total_earlyout;
                                                    $ttlEarlyOut= $total_earlyout+$total_late_early;
                                                } else {
                                                    $total_earlyout = '0';
                                                    $ttlEarlyOut=$total_earlyout+$total_late_early;
                                                }
                                                 echo $ttlEarlyOut;
                                                
                                                
                                                
                                                
                                                
                                                ?></td>
<!--                                            <td><?php /*
                                                if ($single_emp->total_late_early) {
                                                    echo $total_late_early = $single_emp->total_late_early;
                                                } else {
                                                    echo $total_late_early = '0';
                                                } */
                                                ?></td>-->
                                            <td><?php
                                                if ($single_emp->total_informed_present || $single_emp->total_informed_latein ||
                                                        $single_emp->total_informed_latein_earlyout || $single_emp->total_informed_absent) {
                                                    echo $daily_movement = $single_emp->total_informed_present + $single_emp->total_informed_latein +
                                                    $single_emp->total_informed_latein_earlyout + $single_emp->total_informed_absent ;
                                                    $official=$daily_movement-$single_emp->total_informed_personal;
                                                    echo "(Per-".$single_emp->total_informed_personal.",Ofi-".$official.")";
//                                                    "<br/> (P-" . $single_emp->total_informed_present . ",L-" . $single_emp->total_informed_latein . ",L.E-" .
//                                                    $single_emp->total_informed_latein_earlyout . ",A-" . $single_emp->total_informed_absent . ")";
                                                } else {
                                                    echo $daily_movement = '0';
                                                }
                                                ?></td>
                                            <td><?php
                                            if ($single_emp->total_leave_with_pay || $single_emp->total_leave_without_pay) {
                                                echo $total_leave = $single_emp->total_leave_with_pay + $single_emp->total_leave_without_pay .
                                                "( WP-" . $single_emp->total_leave_with_pay . "WOP-" . $single_emp->total_leave_without_pay . ")";
                                            } else {
                                                echo $total_leave = '0';
                                            }
                                                ?></td>
                                            <td>
                                                <?php
                                                //echo $single_emp['total_weekends'];
                                                $weekend_counter = 0;

                                                $from_date = ("$start_date");
                                                $to_date = ("$end_date");
                                                $offday_exist = $this->emp_weeklyholiday_history_model->getemp_weekly_holiday_history_by_date($single_emp->content_id, $start_date, $end_date);
                                                /*
                                                  if(!$offday_exist){
                                                  echo 'Weekly holiday not found';
                                                  }else{

                                                 */
//print_r($offday_exist);                       
//exit();
//echo $offday_exist['fri_off'];

                                                while (strtotime($from_date) <= strtotime($to_date)) {

                                                    //5 for count Friday, 6 for Saturday , 7 for Sunday, 1 for Monday, 2 for Tuesday, 3 for wednesday, 4 for thursday
                                                    if ($offday_exist->mon_off == 'off') {
                                                        if (date("N", strtotime($from_date)) == 1) {
                                                            $weekend_counter++;
                                                        }
                                                    }
                                                    if ($offday_exist->tue_off == 'off') {
                                                        if (date("N", strtotime($from_date)) == 2) {
                                                            $weekend_counter++;
                                                        }
                                                    }
                                                    if ($offday_exist->wed_off == 'off') {
                                                        if (date("N", strtotime($from_date)) == 3) {
                                                            $weekend_counter++;
                                                        }
                                                    }
                                                    if ($offday_exist->thus_off == 'off') {
                                                        if (date("N", strtotime($from_date)) == 4) {
                                                            $weekend_counter++;
                                                        }
                                                    }
                                                    if ($offday_exist->fri_off == 'off') {
                                                        if (date("N", strtotime($from_date)) == 5) {
                                                            $weekend_counter++;
                                                        }
                                                    }
                                                    if ($offday_exist->sat_off == 'off') {
                                                        if (date("N", strtotime($from_date)) == 6) {
                                                            $weekend_counter++;
                                                        }
                                                    }
                                                    if ($offday_exist->sun_off == 'off') {
                                                        if (date("N", strtotime($from_date)) == 7) {
                                                            $weekend_counter++;
                                                        }
                                                    }

                                                    $from_date = date("Y-m-d", strtotime("+1 day", strtotime($from_date)));
                                                }
                                                //  }
                                                //echo $weekend_counter;

                                                if ($single_emp->total_yearly_holiday) {
                                                    $yearly_holiday = $single_emp->total_yearly_holiday;
                                                    // echo $yearly_holiday;
                                                } else if ($single_emp->total_yearly_holiday_all) {
                                                    $yearly_holiday = $single_emp->total_yearly_holiday_all;
                                                    // echo $yearly_holiday;
                                                } else {
                                                    $yearly_holiday = 0;
                                                    // echo $yearly_holiday;
                                                }
                                                $date1 = new DateTime("$start_date");
                                                $date2 = new DateTime("$end_date");

                                                $total_days = $date2->diff($date1)->format("%a") + 1;
                                                $absent = $total_days - ($total_present + $total_latein + $total_earlyout + $total_late_early + $daily_movement + $total_leave + $yearly_holiday + $weekend_counter);
                                                if($absent>=0){
                                                    echo $absent;
                                                }else{
                                                    echo "OT-Day:". abs($absent);
                                                }
                                                    
                                               
                                                ?></td>
                                            <td><?php
                                                ?></td>
                                        </tr>

    <?php
    $counter++;
    $weekend_counter = 0;
}
?>  
                                </tbody>
                            </table> 
                            <br/>
                            <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 12pt; 
                                   color: #000000; font-weight: bold; font-style: italic;">
                                <tr style="margin-bottom:10px;">
                                    <td width="33%"><span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000;">Prepared By:<br><br></span></td>
                                    <td width="33%"  style="font-weight: bold; font-style: italic;"><span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000;">Checked By:<br><br></span></td>
                                    <td width="34%" style="text-align: right; "><span style="height:50px;font-weight: bold; font-style: italic;border-bottom:2px solid #000;">Approved By:<br><br></span></td>
                                </tr>
                                <tr>
                                    <td width="33%"><span style="font-weight: bold; font-style: italic;"><p style="color:fff"></p><br>Supervisor of HRD </span></td>
                                    <td width="33%"  style="font-weight: bold; font-style: italic;"><p style="color:fff"></p><br>Accounts Department</td>
                                    <td width="34%" style="text-align: right; "><p style="color:fff"></p><br>Group Vice President</td>
                                </tr>    
                            </table>

                            <htmlpagefooter name="MyFooter1">
                                <span>[Note]: WP-With Pay, WOP-Without Pay, Per-Personal, E-Early Out, Ofi-Official,OT-Over Time </span>
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