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
    function numberToWords($number)
    {
        $ones = array(
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
            19 => 'nineteen'
        );

        $tens = array(
            2 => 'twenty',
            3 => 'thirty',
            4 => 'forty',
            5 => 'fifty',
            6 => 'sixty',
            7 => 'seventy',
            8 => 'eighty',
            9 => 'ninety'
        );

        $words = '';

        if ($number < 0) {
            $words = 'minus ';
            $number = abs($number);
        }

        if ($number < 20) {
            $words .= $ones[$number];
        } elseif ($number < 100) {
            $words .= $tens[floor($number / 10)];
            $remainder = $number % 10;
            if ($remainder) {
                $words .= ' ' . $ones[$remainder];
            }
        } elseif ($number < 1000) {
            $words .= $ones[floor($number / 100)] . ' hundred';
            $remainder = $number % 100;
            if ($remainder) {
                $words .= ' ' . numberToWords($remainder);
            }
        } elseif ($number < 100000) {
            $words .= numberToWords(floor($number / 1000)) . ' thousand';
            $remainder = $number % 1000;
            if ($remainder) {
                $words .= ' ' . numberToWords($remainder);
            }
        } elseif ($number < 1000000) {
            $words .= numberToWords(floor($number / 100000)) . ' lac';
            $remainder = $number % 100000;
            if ($remainder) {
                $words .= ' ' . numberToWords($remainder);
            }
        } elseif ($number < 10000000) {
            $words .= numberToWords(floor($number / 1000000)) . ' million';
            $remainder = $number % 1000000;
            if ($remainder) {
                $words .= ' ' . numberToWords($remainder);
            }
        } elseif ($number < 100000000) {
            $words .= numberToWords(floor($number / 10000000)) . ' crore';
            $remainder = $number % 10000000;
            if ($remainder) {
                $words .= ' ' . numberToWords($remainder);
            }
        } else {
            $words .= numberToWords(floor($number / 1000000000)) . ' billion';
            $remainder = $number % 1000000000;
            if ($remainder) {
                $words .= ' ' . numberToWords($remainder);
            }
        }

        return $words;
    }

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
            100000 => 'lac',
            1000000 => 'million',
            10000000 => 'core',
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
            padding: .75em .75em .75em .75em;
            text-align: center;
        }

        .wrapper {
            padding: 0 50px 50px 50px;
        }
    </style>
    <style type="text/css" media="print">
        @page {
            size: auto;
            margin-top: 0.75in;
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



            <div class="wrapper">
                <div class="row" style="font-weight:normal;">
                    <div class="col-md-3" style="width:20%;float: left">
                        <img src="<?php echo base_url(); ?>resources/images/logo2.png" alt="" id="logo-img" style="width:70px;height:70px"/>
                    </div>
                    <div class="col-md-9" style="width:80%; float: right;padding:20px 0 0 -50px; ">
                        <h1 style="font-size:15px;font-weight:bold; color:#015d3f">IIDFC Securities Limited</h1>
                        <p>PFI Tower (3rd Floor), 56-57, Dilkusha C/A, Dhaka-1000<br/>
                            Bangladesh
                        </p>
                        <br />
                    </div>
                </div>
                <br />
                <br />
                <div class="row">
                    <?php echo date('F d, Y',$servertime); ?>
                </div><br />
                <div class="row">
                    <address>
                        <br />
                        <!-- <h3 style="font-weight:bold">Sub: Request for fund transfer as salary and allowances for the month of  <?php echo "" . $month . "' " . $year; ?></h3> -->
                        <h3 style="font-weight:bold">Subject : Transfer of Provident Fund for the Month of <?php echo "" . $month . " " . $year; ?>.
                        </h3>
                        </p><br />
                        <p>
                            Salary and allowances for the month of <?php echo "" . $month . " " . $year; ?> already disbursed to employee's
                            bank account after deducting employee's contribution to provident fund.
                            Now it is required to transfer the employee's contribution to provident fund balance
                            from company account to IIDFC Securities Limited Employee's Provident Fund bank account.


                        </p><br />
                        Details are presented below:
                        <br />
                        <br />
                </div>
                <div>

                </div>
                <div class="row">
                    <div class="col-md-12">

                        <table id="example" class="display" cellspacing="0" cellpadding="2" width="100%" border="1">
                            <thead>
                                <tr class="" style="border:1px solid #000;font-size:12px;">
                                    <th>Particulars</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="border-bottom: 1px solid #ccc;text-align:left">Basic Salary of Permanent Staff</td>
                                    <td style="border-bottom: 1px solid #ccc;text-align:left">TK. <?php echo number_format($total_basic, 2); ?></td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px solid #ccc;text-align:left">Employees' contribution to PF </td>
                                    <td style="border-bottom: 1px solid #ccc;text-align:left">TK. <?php echo number_format($employees_contribution, 2); ?></td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px solid #ccc;text-align:left">Employer's contribution to PF </td>
                                    <td style="border-bottom: 1px solid #ccc;text-align:left">TK. <?php echo number_format($employer_contribution, 2); ?></td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px solid #ccc;text-align:left">Total amount of PF</td>
                                    <td style="border-bottom: 1px solid #ccc;text-align:left">TK. <?php echo number_format($total_pf, 2); ?></td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px solid #ccc;text-align:left">Amount in words</td>
                                    <td style="border-bottom: 1px solid #ccc;text-align:left">Taka <?php echo ucfirst(numberToWords($total_pf)) . " only.";
                                                                                                    ?></td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px solid #ccc;text-align:left">Mode of transfer</td>
                                    <td style="border-bottom: 1px solid #ccc;text-align:left">A/C payee cheque</td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px solid #ccc;text-align:left">Cheque favoring</td>
                                    <td style="border-bottom: 1px solid #ccc;text-align:left">IIDFC Securities Limited Employee's Provident Fund</td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: 1px solid #ccc;text-align:left">Payee Bank A/C No</td>
                                    <td style="border-bottom: 1px solid #ccc;text-align:left">Southeast Bank 722</td>
                                </tr>
                            </tbody>
                        </table>
                        <br />
                        <p>
                            Placed for approval please.
                        </p><br /><br /><br />
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
        <htmlpagefooter name="MyFooter1" style="">
            <table width="100%" style="height:200px;vertical-align: bottom; font-family: serif; font-size: 10pt; 
                       color: #000000; text-align: left; ">
                <tr style="margin-bottom:10px;">
                    <td width="33%">
                        <span style="text-align: center; font-weight: bold; ">
                            Sabina Yesmin <br>
                        </span>
                        Assistant Manager (HR)
                    </td>
                    <td width="33%" style="text-align: center; ">

                        <span style="text-align: center; font-weight: bold; ">
                            Md. Maruf Hossain Khan<br>
                        </span>
                        AVP & Head of Accounts
                    </td>
                    <td width="33%" style="text-align: center; ">

                        <span style="height:50px;font-weight: bold; ">
                            Md. Nazmul Hasan Chowdhury <br>
                        </span>
                        Chief Executive Officer (cc)
                    </td>

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