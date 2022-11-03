<div id="payment-detail" title="Salary Payment Detail" style="border:1px solid #ccc; padding: 5px;">
    <?php if($paySlipInfo){?>   
    
    <table style="width:100%;border: 0px solid #ccc;" class="table-condensed">
        <tr>
            <td colspan="2">Employee ID: <?php echo $paySlipInfo->emp_id ?></td>
            <td >Pay Slip ID : #00<?php echo $payslip_id; ?></td>
        </tr>
        <tr>
            <td colspan="2">Employee Name: <?php echo $paySlipInfo->emp_name ?></td>
            <td >Month: <?php echo $paySlipInfo->month_name."' ".$paySlipInfo->year; ?></td>
        </tr>
    <tr>
        <th>sl no</th>
        <th>Payment date</th>
        <th style="text-align: right"> Amount (tk)</th>
        
    </tr>
    <?php
    $sl_no=1;
    foreach($paymentDetailInfo as $singleData){?>
    <tr>
        <td><?php echo $sl_no++; ?></td>
        <td><?php echo $singleData->payment_date; ?></td>
        <td style="text-align: right"><?php echo $singleData->amount; ?></td>        
    </tr>
    <?php }?>
    <tr>
        <td style="font-weight:bold;">Total</td>
        <td></td>
        <td style="text-align: right; font-weight:bold;"><?php echo number_format($paySlipInfo->total_paid); ?></td>
    </tr>
</table> 
    <?php } ?>
</div>