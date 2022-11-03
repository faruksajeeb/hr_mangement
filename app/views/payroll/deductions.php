<table class="table_deduction" style="border:none !important;width:100%"  cellspacing="0" cellpadding="0" >
    <tr>
        <td class="accor_label">Loan:</td>
        <td class="accor_value"><?php echo number_format($paySlip->loan); ?></td>
    </tr>
    <tr>
        <td class="accor_label">Advance Salary:</td>
        <td class="accor_value"><?php echo number_format($paySlip->advance_salary); ?></td>
    </tr>
    <tr>
        <td class="accor_label">Tax:</td>
        <td class="accor_value"><?php echo number_format($paySlip->tax); ?></td>
    </tr>
    <tr>
        <td class="accor_label">P.F.:</td>
        <td class="accor_value"><?php 
        $arrear_pf = $paySlip->arrear_pf;
        $pf = $paySlip->pf;
        echo number_format(($pf+$arrer_pf)*2); 
        ?></td>
    </tr>
    <tr>
        <td class="accor_label">Late:</td>
        <td class="accor_value"><?php echo number_format($paySlip->late_deduct); ?></td>
    </tr>
    <tr>
        <td class="accor_label">Early:</td>
        <td class="accor_value"><?php echo number_format($paySlip->early_deduct); ?></td>
    </tr>
    <tr>
        <td class="accor_label">Absent:</td>
        <td class="accor_value"><?php echo number_format($paySlip->absent_day_taka); ?></td>
    </tr>
    <tr>
        <td class="accor_label">Other Deduct.:</td>
        <td class="accor_value"><?php echo number_format($paySlip->other_deduct); ?></td>
    </tr>
    <tr>
        <td class="accor_label" style="font-weight:bold">Total:</td>
        <td class="accor_value" style="font-weight:bold;">
            <?php
            $totalDeduct = $paySlip->loan + 
                        $paySlip->advance_salary+
                        $paySlip->tax + 
                        $paySlip->pf + 
                        $paySlip->late_deduct + 
                        $paySlip->early_deduct + 
                        $paySlip->absent_day_taka + 
                        $paySlip->other_deduct;
            echo number_format($paySlip->total_deduction);
            ?>
        </td>
    </tr>
</table>