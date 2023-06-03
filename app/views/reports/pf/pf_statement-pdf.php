<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bank Advice</title>
    <?php
    $this->load->view('includes/printcss');
    date_default_timezone_set('Asia/Dhaka');
    $servertime = time();
    $today_date = date("d-m-Y", $servertime);

    function convert_number_to_words($number)
    {
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
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
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

        .container.main-container .row {}

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
            height: 42px;
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

        .wrapper {
            padding: 0 50px 50px 50px;
        }
    </style>
    <style type="text/css" media="print">
        @page {
            size: auto;
            margin-top: 1.75in;
            margin-bottom: 1.5in;
        }

        body {
            font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
            color: #000;
        }
    </style>
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
            $nowbigmonth = date_format($datee, 'F, Y');
            $nowtime = date("H:i:s a", $servertime);
            $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
            $last_day_this_month = date('t-m-Y');
            ?>
            <!--
                <div class="row" style="font-weight:normal">
                    <div class="col-md-10" style="width:595px;">
                        <h1 style="font-size:25px;font-weight:bold"><?php echo $company; ?></h1>
                        <p>House #25, Road #34, Gulshan-2, Dhaka-1212</p>
                        <p>Telephone: +8802-8812396, 9880916, 9881424, 8818561, 9892111</p>
                        <p>Fax: +8802-8826439, 9880918</p>
                    </div>
                    <div class="col-md-2" style="width:100px;"> <img src="<?php echo base_url(); ?>resources/images/logo.png" alt="" id="logo-img"/></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>E-mail : info@ahmedamin.com,ahmedamingroup@gmail.com, misaag@ahmedamin.com</p>
                    </div>
                </div>
                
                <div class="row under-header-bar text-center"> 
                    <h1 style="font-size:20px;font-weight:bold">Bank Advice <br>
                        <span style="font-size:15px;">
<?php echo $division; ?><br>
                <?php echo "Salary for the month of " . $month . "' " . $year; ?>
                        </span>
                        
                    </h1>         
                </div> 
                -->
            <div class="wrapper" style="">
                <div class="row">
                    Date: <?php echo $nowdate; ?>
                </div><br />
                <div class="row">
                    <address>
                        <p>To
                        <p>The Manager</p>
                        <p><?php echo $bankName; ?></p>
                        <p><?php echo $bankAddress; ?></p>
                        <p><br />
                            <!-- <h3 style="font-weight:bold">Sub: Request for fund transfer as salary and allowances for the month of  <?php echo "" . $month . "' " . $year; ?></h3> -->
                        <h3 style="font-weight:bold">Subject : Payment of Salary <?php echo "" . $month . "-" . $year; ?> for IIDFC Securities Limited for Permanent and On probation .
                        </h3>
                        </p><br />
                        <!-- <p>Dear Sir,</p><br/> -->
                        <?php foreach ($paySlips as $paySlip) {
                            $amt = $paySlip->net_salary - $paySlip->total_paid;
                            $totalAmt += $amt;
                        } ?>
                        <!-- <p>     Kindly refer to subject mentioned above, please transfer Tk. <?php echo number_format($totalAmt); ?> (<?php echo ucfirst(convert_number_to_words($totalAmt)) . " taka only."; ?>) from account no. <strong><?php echo $bankAccountNo; ?></strong> name: <strong><?php echo $company; ?> </strong> to under mentioned account numbers and account names being maintained with your Bank.</p><br/> -->
                        <p>We would like to inform you that the company decided to pay the emoluments of the employees by transferring fund to their personal accounts maintained with your bank. With this view, you are advised to make payment of Tk. <?php echo $totalAmt ?> (<?php echo ucfirst(convert_number_to_words($totalAmt)) . " taka only."; ?>) only by transferring the amounts as mentioned against the respective accounts of the employees and debit out STD Account No <strong><?php echo $bankAccountNo; ?></strong> for the same amount.
                        </p><br />
                </div>
                <div>

                </div>
                <div class="row">
                    <div class="col-md-12">

                        <table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr class="heading" style="border:2px solid #000;font-size:12px;">
                                    <th>Sl No</th>
                                    <!--<th>Employee ID</th>-->
                                    <th style="text-align:left">Name of Account</th>
                                    <th>Account No.</th>
                                    <th>Bank</th>
                                    <th>Branch</th>
                                    <th style="text-align:right">Salary Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $slNo = 1;
                                foreach ($paySlips as $paySlip) {
                                ?>
                                    <tr>
                                        <td style="border-bottom: 1px solid #ccc"><?php echo $slNo++; ?></td>
                                        <!--<td style="border-bottom: 1px solid #ccc"><?php echo $paySlip->emp_id; ?></td>-->
                                        <td style="border-bottom: 1px solid #ccc;text-align:left"><?php echo $paySlip->emp_name; ?></td>
                                        <td style="border-bottom: 1px solid #ccc"><?php echo $paySlip->bank_account_no; ?></td>
                                        <td style="border-bottom: 1px solid #ccc"><?php echo $paySlip->bank_name; ?></td>
                                        <td style="border-bottom: 1px solid #ccc"><?php echo $paySlip->branch_name; ?></td>
                                        <td style="border-bottom: 1px solid #ccc;text-align:right">
                                            <?php $amt = $paySlip->net_salary - $paySlip->total_paid;
                                            echo number_format($amt); ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <th colspan="5" style="text-align:left;border-bottom: 1px solid #ccc">Total</th>
                                    <th style="text-align:right;border-bottom: 1px solid #ccc"><?php echo number_format($totalAmt); ?></th>
                                </tr>
                            </tbody>
                        </table>
                        <br />
                        <p>
                            Kindly make the transfer arrangement as on <?php echo $nowdate; ?>. Look forward to your best co-opration.
                        </p><br /><br /><br />
                        <p>
                            Thanking you,
                        </p>

                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
        <htmlpagefooter name="MyFooter1" style="">
            <table width="100%" style="height:200px;vertical-align: bottom; font-family: serif; font-size: 10pt; 
                       color: #000000; font-weight: bold; font-style: italic;text-align: left; ">
                <tr style="margin-bottom:10px;">
                    <!--                        <td width="25%">
                            <span style="text-align: center; font-weight: bold; font-style: italic;border-bottom:2px solid #000;">
                                Prepared By:<br><br>
                            </span>
                        </td>
                        <td width="25%" style="text-align: center; ">

                            <span style="text-align: center; font-weight: bold; font-style: italic;border-bottom:2px solid #000;">
                                Checked By:<br><br>
                            </span>
                        </td>
                        <td width="25%" style="text-align: center; ">

                            <span style="height:50px;font-weight: bold; font-style: italic;border-bottom:2px solid #000;">
                                Approved By:<br><br>
                            </span>
                        </td>
                        <td width="25%"  style="text-align: center; font-weight: bold; font-style: italic;">
                            <span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000;">
                                Authorized By:<br><br>
                            </span>
                        </td>
-->
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
    <!-- /#wrapper -->
</body>

</html>