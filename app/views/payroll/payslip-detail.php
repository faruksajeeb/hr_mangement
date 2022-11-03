<div id="payslip-detail" title='Payslip Details'>
    <?php if ($paySlipInfo) {

    ?>
        <style>
            .payslip_detail_table td {
                background: #F0E68C;
                border-bottom: 1px solid #FFF;
                font-weight: bold;
                font-size: 10px;
            }

            .emp-info-value {
                font-weight: bold;
                vertical-align: top;
                width: 29%;
            }

            .emp-lavel {
                padding-left: 10px;
                vertical-align: top;
                width: 21%;
                /*text-align: right;*/
            }
        </style>
        <?php
        if ($paySlipInfo->checked == 1) {
        ?>

            <span class="pull-right label label-success" style="margin:5px;"><i class="fa fa-check-circle " style="color:#FFF"> Checked (<?php echo $paySlipInfo->checked_date; ?>)</i> </span>
        <?php } ?>
        <?php
        if ($paySlipInfo->approved == 1) {
        ?>

            <span class="pull-right label label-success" style="margin:5px;"><i class="fa fa-check-circle " style="color:#FFF"> Approved (<?php echo $paySlipInfo->approved_date; ?>)</i> </span>
        <?php } ?>
        <a href="<?php echo base_url(); ?>pay-slip/<?php echo $paySlipInfo->id; ?>" class=" btn btn-sm btn-default" target="_blank" style="margin:5px;"><i class="fas fa-print"></i> Print </a>
        <table style="width:100%;" class="payslip_detail_table table-condensed">
            <tr>
                <td class="emp-lavel">Employee ID: </td>
                <td class="emp-info-value"><?php echo $paySlipInfo->emp_id ?></td>
                <td class="emp-lavel">Pay Slip ID :</td>
                <td class="emp-info-value"> #<?php echo str_pad($payslip_id,10,"0",STR_PAD_LEFT); ?></td>
            </tr>
            <tr>
                <td class="emp-lavel">Employee Name:</td>
                <td class="emp-info-value"><?php echo $paySlipInfo->emp_name ?></td>
                <td class="emp-lavel">Month Of:</td>
                <td class="emp-info-value"> <?php echo $paySlipInfo->month_name . "' " . $paySlipInfo->year; ?></td>
            </tr>
            <tr>
                <td class="emp-lavel">Division:</td>
                <td class="emp-info-value"><?php echo $paySlipInfo->division_name ?></td>
                <td class="emp-lavel">Department:</td>
                <td class="emp-info-value"> <?php echo $paySlipInfo->department_name . "' " . $paySlipInfo->year; ?></td>
            </tr>
            <tr>
                <td class="emp-lavel">Joining Date:</td>
                <td class="emp-info-value"><?php echo date("j M, Y", strtotime($paySlipInfo->joining_date)); ?></td>
                <td class="emp-lavel">Service Length:</td>
                <td class="emp-info-value"> <?php
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
                <td class="emp-lavel">Gender:</td>
                <td class="emp-info-value"><?php echo $paySlipInfo->gender ?></td>
                <td class="emp-lavel">Religion:</td>
                <td class="emp-info-value"> <?php echo $paySlipInfo->religion; ?></td>
            </tr>

        </table>

        <style>
            .earning-area {
                background: #32CD32 !important;
            }

            .deduction-area {
                background: #FA8072 !important;
            }
        </style>
        <table style="width:100%;">
            <tr>
                <td>
                    <table width="100%" cellpadding="10">
                        <tr style="text-align:center">
                            <td class="earning-area" colspan="2" style="text-align:center;width:50%;font-weight: bold;border:1px solid #000"> Earnings</td>
                            <td class="deduction-area" colspan="2" style="text-align:center;width:50%;font-weight: bold;border:1px solid #000"> Deductions</td>
                        </tr>
                        <tr style="background:#000; color:#FFF!important">
                            <td colspan="" style="width:35%;text-align:left; font-weight: bold;color:#FFF!important">Particulars</td>
                            <td colspan="" style="width:15%;text-align:right; font-weight: bold;color:#FFF!important"> Taka</td>
                            <td colspan="" style="width:35%;text-align:left; font-weight: bold;color:#FFF!important">Particulars</td>
                            <td colspan="" style="width:15%;text-align:right; font-weight: bold;color:#FFF!important"> Taka</td>
                        </tr>

                        <tr style="">
                            <td class="earning-area" colspan="" style="text-align:left;"> Basic Salary</td>
                            <td class="earning-area" style="text-align:right;"> <?php $basic = $paySlipInfo->basic;
                                                                                echo number_format($basic) . " TK"; ?></td>
                            <td class="deduction-area" style="text-align:left;"> Loan</td>
                            <td class="deduction-area" style="text-align:right;"> <?php $loan = $paySlipInfo->loan;
                                                                                    echo number_format($loan) . " TK"; ?></td>
                        </tr>
                        <tr style="">
                            <td class="earning-area" colspan="" style="text-align:left;"> House Rent</td>
                            <td class="earning-area" style="text-align:right;">
                                <?php
                                $hr = $paySlipInfo->hra;
                                echo number_format($hr) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left;"> Advance Salary</td>
                            <td class="deduction-area" style="text-align:right;">
                                <?php
                                $advance_salary = $paySlipInfo->advance_salary;
                                echo number_format($advance_salary) . " TK";
                                ?>
                            </td>
                        </tr>
                        <tr style="">
                            <td class="earning-area" colspan="" style="text-align:left;"> Medical Allowances</td>
                            <td class="earning-area" style="text-align:right;">
                                <?php
                                $ma = $paySlipInfo->ma;
                                echo number_format($ma) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left;"> Tax/ AIT</td>
                            <td class="deduction-area" style="text-align:right;">
                                <?php
                                $tax = $paySlipInfo->tax;
                                echo number_format($tax) . " TK";
                                ?>
                            </td>
                        </tr>
                        <tr style="">
                            <td class="earning-area" colspan="" style="text-align:left;"> Transport Allowances</td>
                            <td class="earning-area" style="text-align:right;">
                                <?php
                                $ta = $paySlipInfo->ta;
                                echo number_format($ta) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left;"> PF Subscription and Contribution
</td>
                            <td class="deduction-area" style="text-align:right;">
                                <?php
                                $pf = ($paySlipInfo->arrear_pf+$paySlipInfo->pf)*2;
                                echo number_format($pf) . " TK";
                                ?>
                            </td>
                        </tr>
                        <tr style="">
                            <td class="earning-area" colspan="" style="text-align:left;"> Telephone Allowances</td>
                            <td class="earning-area" style="text-align:right;">
                                <?php
                                $mba = $paySlipInfo->mba;
                                echo number_format($mba) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left;"> Latein deduction</td>
                            <td class="deduction-area" style="text-align:right;">
                                <?php
                                $late_deduct = $paySlipInfo->late_deduct;
                                echo number_format($late_deduct) . " TK";
                                ?>
                            </td>
                        </tr>
                        <tr style="">
                            <td class="earning-area" colspan="" style="text-align:left;"> P.F. Allowances</td>
                            <td class="earning-area" style="text-align:right;">
                                <?php
                                $pfa = $paySlipInfo->pfa;
                                echo number_format($pfa) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left;"> Early out</td>
                            <td class="deduction-area" style="text-align:right;">
                                <?php
                                $early_deduct = $paySlipInfo->early_deduct;
                                echo number_format($early_deduct) . " TK";
                                ?>
                            </td>
                        </tr>
                        <tr style="">
                            <td class="earning-area" colspan="" style="text-align:left;"> Performance Bonus</td>
                            <td class="earning-area" style="text-align:right;">
                                <?php
                                $pb = $paySlipInfo->pb;
                                echo number_format($pb) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left;"> Absebt Deduction</td>
                            <td class="deduction-area" style="text-align:right;">
                                <?php
                                $absent_day_taka = $paySlipInfo->absent_day_taka;
                                echo number_format($absent_day_taka) . " TK";
                                ?>
                            </td>
                        </tr>
                        <tr style="">
                            <td class="earning-area" colspan="" style="text-align:left;"> Conveyance</td>
                            <td class="earning-area" style="text-align:right;">
                                <?php
                                $ca = $paySlipInfo->ca;
                                echo number_format($ca) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left;">Other Deduction</td>
                            <td class="deduction-area" style="text-align:right;">
                            <?php
                                $other_deduct = $paySlipInfo->other_deduct;
                                echo number_format($other_deduct) . " TK";
                                ?></td>
                        </tr>
                        <tr style="">
                            <td class="earning-area" colspan="" style="text-align:left;"> Daily Allowance</td>
                            <td class="earning-area" style="text-align:right;">
                                <?php
                                $da = $paySlipInfo->da;
                                echo number_format($da) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left;"></td>
                            <td class="deduction-area" style="text-align:right;"></td>
                        </tr>
                        <tr style="">
                            <td class="earning-area" colspan="" style="text-align:left;"> Entertainment Alllowance</td>
                            <td class="earning-area" style="text-align:right;">
                                <?php
                                $ea = $paySlipInfo->ea;
                                echo number_format($ea) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left;"></td>
                            <td class="deduction-area" style="text-align:right;"></td>
                        </tr>
                        <tr style="">
                            <td class="earning-area" colspan="" style="text-align:left;"> House Maintanence Alllowance</td>
                            <td class="earning-area" style="text-align:right;">
                                <?php
                                $hma = $paySlipInfo->hma;
                                echo number_format($hma) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left;"></td>
                            <td class="deduction-area" style="text-align:right;"></td>
                        </tr>
                        <tr style="">
                            <td class="earning-area" colspan="" style="text-align:left;"> Gratuity</td>
                            <td class="earning-area" style="text-align:right;">
                                <?php
                                $gratuity = $paySlipInfo->gratuity;
                                echo number_format($gratuity) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left;"></td>
                            <td class="deduction-area" style="text-align:right;"></td>
                        </tr>
                        <tr style=" ">
                            <td class="earning-area" colspan="" style="text-align:left;"> Arear</td>
                            <td class="earning-area" style="text-align:right;">
                                <?php
                                $arear = $paySlipInfo->arear;
                                echo number_format($arear) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left;"></td>
                            <td class="deduction-area" style="text-align:right;"></td>
                        </tr>
                        <tr style="">
                            <td class="earning-area" colspan="" style="text-align:left;"> Other Allowances</td>
                            <td class="earning-area" style="text-align:right;">
                                <?php
                                $oa = $paySlipInfo->oa;
                                echo number_format($oa) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left;"></td>
                            <td class="deduction-area" style="text-align:right;"></td>
                        </tr>
                        <tr style="">
                            <td class="earning-area" colspan="" style="text-align:left;"> Over Time</td>
                            <td class="earning-area" style="text-align:right;">
                                <?php
                                $ot = $paySlipInfo->ot_taka;
                                echo number_format($ot) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left;"></td>
                            <td class="deduction-area" style="text-align:right;"></td>
                        </tr>
                        <tr style="">
                            <td class="earning-area" colspan="" style="text-align:left;"> Special Bonus</td>
                            <td class="earning-area" style="text-align:right;">
                                <?php
                                $bonus = $paySlipInfo->bonus;
                                echo number_format($bonus) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left;"></td>
                            <td class="deduction-area" style="text-align:right;"></td>
                        </tr>
                        <tr style="">
                            <td class="earning-area" colspan="" style="text-align:left; "> Festival Bonus</td>
                            <td class="earning-area" style="text-align:right; ">
                                <?php
                                $festivalBonus = $paySlipInfo->festival_bonus;
                                echo number_format($festivalBonus) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left;"></td>
                            <td class="deduction-area" style="text-align:right;"></td>
                        </tr>
                        <tr style="">
                            
                        <td class="earning-area" colspan="" style="text-align:left; "> Incentive</td>                            
                            <td class="earning-area" style="text-align:right; ">
                                <?php
                                $incentive = $paySlipInfo->incentive;
                                echo number_format($incentive) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left;"></td>
                            <td class="deduction-area" style="text-align:right;"></td>
                        </tr>
                        <td class="earning-area" colspan="" style="text-align:left; "> Arrear PF</td>                            
                            <td class="earning-area" style="text-align:right; ">
                                <?php                                
                                echo number_format($paySlipInfo->arrear_pf) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left;"></td>
                            <td class="deduction-area" style="text-align:right;"></td>
                        </tr>
                        <td class="earning-area" colspan="" style="text-align:left; "> PF</td>                            
                            <td class="earning-area" style="text-align:right; ">
                                <?php                                
                                echo number_format($paySlipInfo->pf) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left;"></td>
                            <td class="deduction-area" style="text-align:right;"></td>
                        </tr>
                        <tr style="">
                            <td class="earning-area" colspan="" style="text-align:left; font-weight: bold;padding: 5px; "> Total </td>
                            <td class="earning-area" style="text-align:right; font-weight: bold;padding: 5px; ">
                                <?php
                                $total = $paySlipInfo->gross_salary;
                                echo number_format($total) . " TK";
                                ?>
                            </td>
                            <td class="deduction-area" style="text-align:left; font-weight: bold;padding: 5px; ">Total</td>
                            <td class="deduction-area" style="text-align:right; font-weight: bold;padding: 5px; ">
                                <?php
                                $totalDeduct = $loan + $advance_salary + $pf + $tax + $lateDeduct + $earlyDeduct + $absentDay + $otd;
                                echo number_format($totalDeduct) . " TK";
                                ?>
                            </td>
                        </tr>
                        <tr style="background: #F0E68C;">
                            <td colspan="2"> </td>
                            <td style=" padding: 5px; margin-top:2px;font-size:15px;font-weight:bold;font-style:italic;">Net Payment</td>
                            <td style="padding: 5px; text-align:right;width:100px;font-size:15px;font-weight:bold;font-style:italic;">
                                <?php 
                                //echo number_format($total - $totalDeduct) . " TK"; 
                                echo number_format($paySlipInfo->net_salary) . " TK"; 
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

            <tr style="background: #F0E68C; color:#000">
                <td colspan="3" style="text-align:left;color:#000">
                    <?php

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

                    echo "In words: <strong>" . ucfirst(convert_number_to_words($paySlipInfo->net_salary)) . " taka only.</strong>";
                    ?>

                </td>

            </tr>
        </table>

    <?php } ?>
</div>