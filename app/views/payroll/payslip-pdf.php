<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Payslip | <?php echo $paySlipInfo->emp_name; ?></title>

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
/* 
            .red-color{
                color: red!important;
                -webkit-print-color-adjust: exact;
            } */

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
                 /* margin-left: 30px;  */
                margin-top: 35px; 
                  /* margin-right: 30px;  */
                margin-footer: 0mm;
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
                padding: 3px;
            }
            .payslip_head{
                text-align:left;border-bottom:1px solid #CCC;
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
                                <div class="col-md-2" style="width:80px; float: left"> 
                                    <img src="<?php echo base_url(); ?>resources/images/logo2.png" alt="" id="logo-img"/>
                                </div>
                                <div class="col-md-8" style="width:600px; text-align: center;  float: right;padding-left: -100px;">
                                    <h1 style="font-size:25px;font-weight:bold; color:#015d3f"><?php echo $paySlipInfo->company_name; ?></h1>
                                    <!-- <p>House #25, Road #34, Gulshan-2, Dhaka-1212</p> -->
                                    <br/>
                                    <p style="padding:5px; background-color: #bc9732; color:#FFF; border-radius: 5px; width:100px;margin:0 auto; ">Payslip</p>
                                </div>
                            </div>
                            <div class="row" style="padding: 5px;">
                                <div class="col-md-2" style="width:80px; float: left"></div>
                                <div class="col-md-10 " style="width:600px; text-align: center;  float: right;padding-left: -100px;">
                                    <p style="font-style:italic; font-weight:bold;text-align: center">Salary for the month of <?php echo $paySlipInfo->month_name . "' " . $paySlipInfo->year; ?></p>
                                </div>
                            </div>


                            <div class="emp_info" style="margin-left:15px">
                                <div class="row">
                                    <div class="col-md-12" style='width:680px;border:1px solid #bc9732;padding:2px;'>
                                        <div class="row" style="width:100%">

                                            <table width="100%" style="margin-left:10px; font-size:11px">
                                                <tr>
                                                    <td class="emp-lavel">Employee ID </td><td class="emp-info-value">: <?php echo $paySlipInfo->emp_id; ?></td>                                                    
                                                    <td class="emp-lavel">Mobile No </td><td class="emp-info-value">: <?php echo $paySlipInfo->mobile_no; ?></td>                                                   
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel">Employee Name </td><td class="emp-info-value">: <?php echo $paySlipInfo->emp_name; ?></td>
                                                    <td class="emp-lavel">Joining Date </td><td class="emp-info-value">: <?php echo date("j M, Y", strtotime($paySlipInfo->joining_date)); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel">Division </td><td class="emp-info-value">: <?php echo $paySlipInfo->division_name; ?></td>
                                                    <td class="emp-lavel">Service Length </td><td class="emp-info-value">: <?php
                                                        $joining_date_arr = explode('-', $paySlipInfo->joining_date);
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
                                                    <td class="emp-lavel">Department </td><td class="emp-info-value">: <?php echo $paySlipInfo->department_name; ?></td>
                                                    <td class="emp-lavel">Gender </td><td class="emp-info-value">: <?php echo $paySlipInfo->gender; ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="emp-lavel">Designation </td><td class="emp-info-value">: <?php echo $paySlipInfo->designation_name; ?></td>
                                                    <td class="emp-lavel">Religion </td><td class="emp-info-value">: <?php echo $paySlipInfo->religion; ?></td>
                                                </tr>
                                            </table>                                            
                                        </div>



                                    </div>
                                    <!-- <div class="col-md-1" style='width:80px;'>
                                        <?php
                                        foreach ($emp_details_records as $value) {
                                            if ($value['field_name'] == 'resources/uploads') {
                                                $picture = $value['field_value'];
                                            }
                                            if (!$picture) {
                                                $picture = "no_image.jpg";
                                            }
                                        }
                                        ?>
                                        <img src="<?php echo base_url(); ?>resources/uploads/<?php echo $picture; ?>" width="100" height="150" alt="Emp Image" id="employee-img"/>
                                    </div> -->
                                </div>





                            </div>
                        </div>
                    </div> <br/>

                    <div style="border:1px dotted #bc9732">




                        <div class="row">
                            <div class="col-md-12">
                                <table style="width:100%;margin-right: -8px;">
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="10">
                                                <tr style="text-align:center">
                                                    <td colspan="2" style="text-align:center;width:50%;font-weight: bold;border:1px solid #6C6B6B; color:#3A3A3A"> Earnings</td>
                                                    <td colspan="2" style="text-align:center;width:50%;font-weight: bold;border:1px solid #6C6B6B; color:#3A3A3A"> Deductions</td>
                                                </tr>
                                                <tr style="background:#6C6B6B; color:#FFF!important">
                                                    <td style="width:35%;text-align:left; font-weight: bold; color:#FFFFFF">Particulars</td>
                                                    <td style="width:15%;text-align:right; font-weight: bold; color:#FFFFFF!important"> Taka</td>
                                                    <td style="width:35%;text-align:left; font-weight: bold; color:#FFFFFF!important">Particulars</td>
                                                    <td style="width:15%;text-align:right; font-weight: bold; color:#FFFFFF!important"> Taka</td>
                                                </tr>
                                                <tr>
                                                    <td colspan='2' style="padding:0;vertical-align: top;">
                                                        <table cellspacing='0' width='100%'>
                                                            <?php 
                                                            $basic = $paySlipInfo->basic; 
                                                            if($basic > 0): 
                                                            ?>
                                                            <tr>
                                                                <td class="payslip_head" > Basic Salary</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC"> 
                                                                    <?php echo number_format($basic)." TK";?>
                                                                </td>
                                                            </tr>
                                                            <?php endif; ?>
                                                            <?php 
                                                            $houseRent = $paySlipInfo->hra;
                                                            if($houseRent > 0): 
                                                            ?>
                                                            <tr>
                                                                <td class="payslip_head" > House Rent</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                    <?php echo number_format($houseRent)." TK"; ?>
                                                                </td>
                                                            </tr>
                                                            <?php endif; ?>
                                                            <?php 
                                                            $medical = $paySlipInfo->ma;
                                                            if($medical >0 ): 
                                                            ?>
                                                            <tr>
                                                                <td class="payslip_head" > Medical Allowances</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                    <?php echo number_format($medical)." TK"; ?>
                                                                </td>
                                                            </tr>
                                                            <?php endif; ?>
                                                            <?php 
                                                            $transport = $paySlipInfo->ta;
                                                            if($transport > 0): ?>
                                                            <tr>
                                                                <td class="payslip_head" > Transport Allowances</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                    <?php echo number_format($transport)." TK"; ?>
                                                                </td>
                                                            </tr>
                                                            <?php endif; ?>
                                                            <?php 
                                                            $mobile = $paySlipInfo->mba;
                                                            if($mobile > 0): 
                                                            ?>
                                                            <tr>
                                                                <td class="payslip_head" > Mobile Allowances</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                    <?php echo number_format($mobile)." TK"; ?>
                                                                </td>
                                                            </tr>
                                                            <?php endif; ?>
                                                            <?php 
                                                            $pfAllow = $paySlipInfo->pfa;
                                                            if($pfAllow>0): 
                                                            ?>
                                                            <tr>
                                                                <td class="payslip_head" > P.F. Allowances</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                    <?php echo number_format($pfAllow)." TK";?>
                                                                </td>
                                                            </tr>
                                                            <?php endif; ?>

                                                            <!-- Performance Bonus -->
                                                            <?php 
                                                            $performanceBonus = $paySlipInfo->pb;
                                                            if($performanceBonus > 0): 
                                                            ?>
                                                            <tr>
                                                                <td class="payslip_head" > Performance Bonus</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                    <?php echo number_format($performanceBonus)." TK";?>
                                                                </td>
                                                            </tr>
                                                            <?php endif; ?>

                                                            <!-- Conveyance -->
                                                            <?php 
                                                            $conveyance = $paySlipInfo->ca;
                                                            if($conveyance > 0): 
                                                            ?>
                                                            <tr>
                                                                <td class="payslip_head" > Conveyance</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                <?php echo number_format($conveyance)." TK"; ?></td>
                                                            </tr>
                                                            <?php endif; ?>

                                                            <!-- Daily Allowances -->
                                                            <?php 
                                                            $dailyAllow = $paySlipInfo->da;
                                                            if($dailyAllow > 0): 
                                                            ?>
                                                            <tr>
                                                                <td class="payslip_head" > Daily Allowances</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                    <?php echo number_format($dailyAllow)." TK"; ?>
                                                                </td>
                                                            </tr> 
                                                            <?php endif; ?>

                                                            <!-- Entertainment Allowances -->
                                                            <?php 
                                                            $entertainment = $paySlipInfo->ea;
                                                            if($entertainment > 0): 
                                                            ?>
                                                            <tr>
                                                                <td class="payslip_head" > Entertainment Allowances</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                    <?php echo number_format($entertainment)." TK"; ?>
                                                                </td>
                                                            </tr>
                                                            <?php endif; ?>

                                                            <!-- Other Allowances -->
                                                            <?php 
                                                            $otherAllow = $paySlipInfo->oa;
                                                            if($otherAllow > 0): ?>
                                                            <tr>
                                                                <td class="payslip_head" > Other Allowances</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                    <?php echo number_format($otherAllow)." TK";?>
                                                                </td>
                                                            </tr>
                                                            <?php endif; ?>

                                                            <!-- Gratuity -->
                                                            <?php 
                                                            $gratuity = $paySlipInfo->gratuity;
                                                            if($gratuity > 0): ?>
                                                            <tr>
                                                                <td class="payslip_head" > Gratuity</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                    <?php echo number_format($gratuity)." TK"; ?>
                                                                </td>
                                                            </tr> 
                                                            <?php endif; ?>

                                                            <!-- Over Time -->
                                                            <?php 
                                                            $overTime = $paySlipInfo->ot_taka;
                                                            if($overTime > 0): ?>
                                                            <tr>
                                                                <td class="payslip_head" > Over Time</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                    <?php echo number_format($overTime)." TK";?>
                                                                </td>
                                                            </tr>
                                                            <?php endif; ?>

                                                            <!-- Bonus -->
                                                            <?php 
                                                            $bonus = $paySlipInfo->bonus;
                                                            if($bonus > 0): 
                                                            ?>
                                                            <tr>
                                                                <td class="payslip_head" > Bonus </td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                <?php echo number_format($bonus)." TK"; ?></td>
                                                            </tr>
                                                            <?php endif; ?>

                                                            <!-- Festival Bonus -->
                                                            <?php 
                                                            $festivalBonus = $paySlipInfo->festival_bonus;
                                                            if($festivalBonus > 0): ?>
                                                            <tr>
                                                                <td class="payslip_head" > Festival Bonus </td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                <?php echo number_format($festivalBonus)." TK";
                                                                    ?></td>
                                                            </tr> 
                                                            <?php endif; ?>


                                                            <?php 
                                                            $incentive = $paySlipInfo->incentive;
                                                            if($incentive > 0): ?>
                                                            <tr>
                                                                <td class="payslip_head" > Incentive </td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC"> 
                                                                 <?php echo number_format($incentive)." TK";
                                                                    ?></td>
                                                            </tr>
                                                            <?php endif; ?>

                                                            <!-- Arrear Salary -->
                                                            <?php 
                                                            $arearSalary = $paySlipInfo->arear;
                                                            if($arearSalary > 0): ?>
                                                            <tr>
                                                                <td class="payslip_head" > Arrear Salary </td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                <?php echo number_format($arearSalary)." TK"; ?></td>
                                                            </tr>
                                                            <?php endif; ?>

                                                            <!-- House Maintenance Allowance -->
                                                            <?php 
                                                            $houseMaintenance = $paySlipInfo->hma;
                                                            if($houseMaintenance > 0): ?>
                                                            <tr>
                                                                <td class="payslip_head" > House Maintenance Allowance </td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                <?php echo number_format($houseMaintenance)." TK";
                                                                    ?></td>
                                                            </tr>
                                                            <?php endif; ?>

                                                            <!-- Company PF Subscription Deduction -->
                                                            <?php
                                                            $companyPFSubscriptionDeduct = $paySlipInfo->pf;
                                                            if($companyPFSubscriptionDeduct>0): 
                                                            ?>
                                                                <tr >
                                                                    <td class="payslip_head" > Company PF Subscription</td>
                                                                    <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                        <?php echo number_format($companyPFSubscriptionDeduct)." TK"; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endif; ?>

                                                            <!-- Company Arrear PF Subscription Deduction -->
                                                            <?php
                                                            $companyArrearPFSubscriptionDeduct = $paySlipInfo->arrear_pf;
                                                            if($companyArrearPFSubscriptionDeduct > 0): 
                                                            ?>
                                                                <tr >
                                                                    <td class="payslip_head" > Company Arrear PF Subscription</td>
                                                                    <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                        <?php echo number_format($companyArrearPFSubscriptionDeduct)." TK"; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endif; ?>
                                                            
                                                            
                                                        </table>
                                                    </td>
                                                    <td  colspan='2'  style="padding:0;vertical-align: top">
                                                        <!-- Deductions  -->
                                                        <table cellspacing='0' width='100%'>

                                                        <!-- Loan Deduction -->
                                                        <?php 
                                                        $loanDeduct = $paySlipInfo->loan;
                                                         if($loanDeduct > 0): 
                                                         ?>
                                                            <tr >
                                                                <td class="payslip_head" > Loan</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  <?php
                                                                    echo number_format($loanDeduct)." TK";
                                                                    ?></td>
                                                            </tr>
                                                        <?php endif; ?>

                                                        <!-- Advance Salary Deduction -->
                                                        <?php 
                                                        $advanceSalaryDeduct = $paySlipInfo->advance_salary;                                                                    
                                                        if($advanceSalaryDeduct > 0): 
                                                        ?>
                                                            <tr >
                                                                <td class="payslip_head" > Advance Salary Deduct.</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  <?php
                                                                    echo number_format($advanceSalaryDeduct)." TK";
                                                                    ?></td>
                                                            </tr> 
                                                        <?php endif; ?>

                                                        <!-- Tax/ AIT Deduction -->
                                                        <?php 
                                                        $taxDeduct = $paySlipInfo->tax;                                                                    
                                                        if($taxDeduct > 0): 
                                                        ?>
                                                            <tr >
                                                                <td class="payslip_head" > Tax/ AIT</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  <?php
                                                                    echo number_format($taxDeduct)." TK";
                                                                    ?></td>
                                                            </tr> 
                                                        <?php endif; ?>

                                                        <!-- PF Subscription Deduction -->
                                                        <?php
                                                        $pfSubscriptionDeduct = $paySlipInfo->pf;
                                                        if($pfSubscriptionDeduct > 0): 
                                                        ?>
                                                            <tr >
                                                                <td class="payslip_head" > Provident Fund Subscription</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                    <?php echo number_format($pfSubscriptionDeduct)." TK"; ?>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>

                                                        <!-- PF Contribution Deduction -->
                                                        <?php
                                                        $pfContributionDeduct = $paySlipInfo->pf;
                                                        if($pfContributionDeduct>0): 
                                                        ?>
                                                            <tr >
                                                                <td class="payslip_head" > Provident Fund Contribution</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                    <?php echo number_format($pfContributionDeduct)." TK"; ?>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>

                                                        <!-- Arrear PF Subscription Deduction -->
                                                        <?php 
                                                        $arrearPfSubscriptionDeduct = $paySlipInfo->arrear_pf;
                                                        if($arrearPfSubscriptionDeduct > 0): 
                                                        ?>
                                                            <tr >
                                                                <td class="payslip_head" > Arrear PF Subscription</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                <?php echo number_format($arrearPfSubscriptionDeduct)." TK"; ?></td>
                                                            </tr>  
                                                        <?php endif; ?>

                                                        <!-- Arrear PF Contribution Deduction -->
                                                        <?php 
                                                        $arrearPfContributionDeduct = $paySlipInfo->arrear_pf;
                                                        if($arrearPfContributionDeduct > 0): 
                                                        ?>
                                                            <tr >
                                                                <td class="payslip_head" > Arrear PF Contribution</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                <?php echo number_format($arrearPfContributionDeduct)." TK"; ?></td>
                                                            </tr>  
                                                        <?php endif; ?>

                                                        <!-- Late In Deduction -->
                                                        <?php 
                                                        $lateDeduct = $paySlipInfo->late_deduct;
                                                        if($lateDeduct > 0): 
                                                        ?>
                                                            <tr >
                                                                <td class="payslip_head" > Late In</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                    <?php echo number_format($lateDeduct)." TK"; ?>
                                                                </td>
                                                            </tr> 
                                                        <?php endif; ?>

                                                        <!-- Early Out Deduction -->
                                                        <?php 
                                                        $earlyDeduct = $paySlipInfo->early_deduct;
                                                        if($earlyDeduct > 0 ): 
                                                        ?>
                                                            <tr >
                                                                <td class="payslip_head" > Early out</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                    <?php echo number_format($earlyDeduct)." TK"; ?>
                                                                </td>
                                                            </tr> 
                                                        <?php endif; ?>

                                                        <!-- Absent Deduction -->
                                                        <?php 
                                                        $absentDeduct = $paySlipInfo->absent_deduct;
                                                        if($absentDeduct > 0): 
                                                        ?>
                                                            <tr >
                                                                <td class="payslip_head" >Absent</td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">
                                                                <?php echo number_format($absentDeduct)." TK"; ?></td>
                                                            </tr>
                                                        <?php endif; ?>   

                                                        <!-- Other Deduction -->
                                                        <?php 
                                                        $otherDeduct = $paySlipInfo->other_deduct;
                                                        if($otherDeduct > 0): 
                                                        ?>
                                                            <tr>
                                                                <td class="payslip_head" > Other Deduction<br>
                                                                <?php 
                                                                if($paySlipInfo->other_deduction_note){
                                                                    echo "<span style='font-size:8px;font-style:italic'>".$paySlipInfo->other_deduction_note."</span>";
                                                                }
                                                                ?></td>
                                                                <td style="text-align:right;border-bottom:1px solid #CCC">  
                                                                <?php
                                                                echo number_format($otherDeduct)." TK";
                                                                ?>
                                                                </td>
                                                            </tr>
                                                            <?php endif; ?>

                                                        </table>
                                                    </td>
                                                </tr>
                                             
                                                <tr style="background:#E5E4E4; ">
                                                    <td colspan="" style="text-align:left; font-weight: bold;padding: 5px; "> Gross Salary</td>
                                                    <td style="text-align:right; font-weight: bold;padding: 5px; "> 
                                                        <?php
                                                        $totalEarning =  $basic + $houseRent + $medical + $transport + $mobile + $pfAllow + $performanceBonus + $conveyance + $dailyAllow + $entertainment + $otherAllow + $gratuity + $overTime + $bonus + $festivalBonus + $incentive + $arearSalary + $houseMaintenance + $companyPFSubscriptionDeduct + $companyArrearPFSubscriptionDeduct;
                                                        echo number_format($totalEarning)." TK";
                                                        ?>
                                                    </td>
                                                    <td style="text-align:left; font-weight: bold;padding: 5px; ">Total Deductions</td>
                                                    <td style="text-align:right; font-weight: bold;padding: 5px; ">
                                                        <?php
                                                          $totalDeduct = $loanDeduct + $advanceSalaryDeduct + $taxDeduct + $pfSubscriptionDeduct + $pfContributionDeduct + $arrearPfSubscriptionDeduct + $arrearPfContributionDeduct + $lateDeduct + $earlyDeduct + $absentDeduct + $otherDeduct;
                                                        echo number_format($totalDeduct)." TK";
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr style="background:#E5E4E4; ">
                                                    <td colspan="2">  </td>                                                    
                                                    <td style=" padding: 5px; margin-top:2px;font-size:14px;font-weight:bold;font-style:italic;">Net Payment</td>
                                                    <td  style="padding: 5px; text-align:right;width:100px;font-size:14px;font-weight:bold;font-style:italic;">
                                                        <?php 
                                                        // echo number_format($total-$totalDeduct)." TK"; 
                                                        echo number_format($paySlipInfo->net_salary)." TK"; 
                                                        ?>
                                                    </td>
                                                </tr>
                                               
                                            </table>
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                </table>


                                
                                <table class="heading_table" cellspacing="0" width="100%" style="">                               

                                    <tr style="background:#E5E4E4; color:#000">
                                        <td colspan="3" style="text-align:left; font-weight: bold;color:#000">
                                            <?php

                                            function convert_number_to_words($number) {

                                                $hyphen = '-';
                                                $conjunction = ' and ';
                                                $separator = ', ';
                                                $negative = 'negative ';
                                                $decimal = ' point ';
                                                $dictionary = array(
                                                    0 => 'zero',
                                                    1 => 'one',
                                                    2 => 'two',
                                                    3 => 'three',
                                                    4 => 'four',
                                                    5 => 'five',
                                                    6 => 'six',
                                                    7 => 'seven',
                                                    8 => 'eight',
                                                    9 => 'nine',
                                                    10 => 'ten',
                                                    11 => 'eleven',
                                                    12 => 'twelve',
                                                    13 => 'thirteen',
                                                    14 => 'fourteen',
                                                    15 => 'fifteen',
                                                    16 => 'sixteen',
                                                    17 => 'seventeen',
                                                    18 => 'eighteen',
                                                    19 => 'nineteen',
                                                    20 => 'twenty',
                                                    30 => 'thirty',
                                                    40 => 'fourty',
                                                    50 => 'fifty',
                                                    60 => 'sixty',
                                                    70 => 'seventy',
                                                    80 => 'eighty',
                                                    90 => 'ninety',
                                                    100 => 'hundred',
                                                    1000 => 'thousand',
                                                    1000000 => 'million',
                                                    1000000000 => 'billion',
                                                    1000000000000 => 'trillion',
                                                    1000000000000000 => 'quadrillion',
                                                    1000000000000000000 => 'quintillion'
                                                );

                                                if (!is_numeric($number)) {
                                                    return false;
                                                }

                                                if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
                                                    // overflow
                                                    trigger_error(
                                                            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
                                                    );
                                                    return false;
                                                }

                                                if ($number < 0) {
                                                    return $negative . convert_number_to_words(abs($number));
                                                }

                                                $string = $fraction = null;

                                                if (strpos($number, '.') !== false) {
                                                    list($number, $fraction) = explode('.', $number);
                                                }

                                                switch (true) {
                                                    case $number < 21:
                                                        $string = $dictionary[$number];
                                                        break;
                                                    case $number < 100:
                                                        $tens = ((int) ($number / 10)) * 10;
                                                        $units = $number % 10;
                                                        $string = $dictionary[$tens];
                                                        if ($units) {
                                                            $string .= $hyphen . $dictionary[$units];
                                                        }
                                                        break;
                                                    case $number < 1000:
                                                        $hundreds = $number / 100;
                                                        $remainder = $number % 100;
                                                        $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                                                        if ($remainder) {
                                                            $string .= $conjunction . convert_number_to_words($remainder);
                                                        }
                                                        break;
                                                    default:
                                                        $baseUnit = pow(1000, floor(log($number, 1000)));
                                                        $numBaseUnits = (int) ($number / $baseUnit);
                                                        $remainder = $number % $baseUnit;
                                                        $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                                                        if ($remainder) {
                                                            $string .= $remainder < 100 ? $conjunction : $separator;
                                                            $string .= convert_number_to_words($remainder);
                                                        }
                                                        break;
                                                }

                                                if (null !== $fraction && is_numeric($fraction)) {
                                                    $string .= $decimal;
                                                    $words = array();
                                                    foreach (str_split((string) $fraction) as $number) {
                                                        $words[] = $dictionary[$number];
                                                    }
                                                    $string .= implode(' ', $words);
                                                }

                                                return $string;
                                            }

                                            echo "<strong>In words:</strong> " . ucfirst(convert_number_to_words(abs($paySlipInfo->net_salary))) . " taka only.";
                                            ?>

                                        </td>

                                    </tr>
                                </table>
                                
                            </div>

                            <p style="text-align:center;margin-top:30px">This is a system generated payslip and requires no signature
                        <br/>Note: If you have any query please contact with HR Team.</p>



                            <htmlpagefooter name="MyFooter1" style="">
                                <table width="100%" style="height:200px;vertical-align: bottom; font-family: serif; font-size: 10pt; 
                                       color: #000000; font-weight: bold; font-style: italic;">
                                    <tr style="margin-bottom:10px;">
                                         <!-- <td width="25%"  style="text-align: center; font-weight: bold; font-style: italic; ">
                                            <span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000;">
                                                Received By:<br><br>
                                            </span>
                                        </td>
                                        <td width="25%" style="text-align:center!important;">
                                        <span style="font-weight:normal; font-size:12px; font-style: normal; ">HR Executive</span> <br/>
                                            <span style="text-align: center; font-weight: bold; font-style: italic;border-bottom:2px solid #000;">
                                                Prepared By:<br><br>
                                            </span>
                                            
                                        </td> -->
                                        <!-- <td width="25%" style="text-align: center; ">
<?php
if ($paySlipInfo->checked == 1) {
    ?>
                                                <img src="<?php echo base_url(); ?>resources\images\signature\checked_by.jpg" alt="Checked By Auditor" width="18%" height="80"  />
    <?php
    echo "<br/><span style='font-weight: normal'>" . $paySlipInfo->checked_date . "</span><br/>";
}
?>
                                            <span style="text-align: center; font-weight: bold; font-style: italic;border-bottom:2px solid #000;">
                                                Checked By:<br><br>
                                            </span>
                                        </td>
                                        <td width="25%" style="text-align: center; ">
<?php
if ($paySlipInfo->approved == 1) {
    ?>
                                                <img src="<?php echo base_url(); ?>resources\images\signature\approved_by.jpg" alt="Approved By Accounts" width="18%" height="80" />
    <?php
    echo "<br/><span style='font-weight: normal'>" . $paySlipInfo->approved_date . "</span><br/>";
}
?>
                                            <span style="height:50px;font-weight: bold; font-style: italic;border-bottom:2px solid #000;">
                                                Approved By:<br><br>
                                            </span>
                                        </td> -->
                                       

                                    </tr>
<!--                                    <tr>
                                        <td width="25%"><span style="font-weight: bold; font-style: italic;"><p style="color:fff"></p><br>HR Executive </span></td>
                                        <td width="25%"><span style="font-weight: bold; font-style: italic;"><p style="color:fff"></p><br>Internal Auditor </span></td>
                                       <td width="25%" style="text-align: right;"><p style="color:fff"></p><br><br/>Group Vice President<br/><span style="">(Administration)</span></td>
                                        <td width="25%"  style="font-weight: bold; font-style: italic;"><p style="color:fff"></p><br>Accounts Department</td>
                                        
                                    </tr>    -->
                                </table>
                                
                                <br> <br> <br> <br> <br>
                                <span style="font-size:8px;font-style:italic">


                                </span>
                            </htmlpagefooter>
                            <sethtmlpagefooter name="MyFooter1" value="on" />
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