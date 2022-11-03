<div id="payment-detail" title="Purchase Payment Detail" style="border:1px solid #ccc; padding: 5px;">
    <?php if($purchaseInfo){?>   
    
    <table style="width:100%;border: 0px solid #ccc;" class="table-condensed">
        <tr>
                <td >Supplier Name:</td>
                <td ><strong><?php echo $purchaseInfo->supplier_name ?></strong></td>
                <td ><strong>Purchase ID :</strong></td>
                <td > #0000<?php echo $purchaseInfo->id; ?></td>
            </tr>
            <tr>
                <td >Delivered By:</td>
                <td ><?php echo $purchaseInfo->delevired_by ?></td>
                <td ><strong>Purchase Date:</strong></td>
                <td > <?php echo $purchaseInfo->purchase_date; ?></td>
            </tr>
    <tr>
        <th>sl no</th>
        <th></th>
        <th>Payment date</th>
        <th style="text-align: right"> Amount (tk)</th>
        
    </tr>
    <?php
    $sl_no=1;
    foreach($paymentDetailInfo as $singleData){?>
    <tr>
        <td><?php echo $sl_no++; ?></td>
        <td></td>
        <td><?php echo $singleData->payment_date; ?></td>
        <td style="text-align: right"><?php echo $singleData->amount; ?></td>        
    </tr>
    <?php }?>
    <tr>
        <td style="font-weight:bold;">Total</td>
        <td></td>
         <td></td>
        <td style="text-align: right; font-weight:bold;"><?php echo number_format($purchaseInfo->paid_amount); ?></td>
    </tr>
</table> 
    <?php } ?>
</div>