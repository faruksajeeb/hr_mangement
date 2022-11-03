<div id="purchase-detail" title="Purchase Details" style="border:1px solid #ccc; padding: 5px;">
    <?php if ($purchaseInfo) {
        ?>   
        <style>

        </style>
        <table style="" class="table table-condensed">
            <tr>
                <td >Supplier Name:</td>
                <td ><strong><?php echo $purchaseInfo->supplier_name ?></strong></td>
                <td ><strong>Purchase ID :</strong></td>
                <td >
                   <?php echo "#".str_pad($purchaseInfo->id, 11, '00000000000', STR_PAD_LEFT); ?>
                </td>
            </tr>
            <tr>
                <td >Delivered By:</td>
                <td ><?php echo $purchaseInfo->delevired_by ?></td>
                <td ><strong>Purchase Date:</strong></td>
                <td > <?php echo $purchaseInfo->purchase_date; ?></td>
            </tr>    

        </table> 

       
        <table style="width:100%;">
                <thead>
                    <tr style="background:#CCC">
                        <th style="text-align: left">#Item</th>
                        <th>Mfg. Date</th>
                        <th>Exp. Date</th>
                        <th style="text-align: center">Qty</th>                        
                        <th>Rec Qty</th>
                        <th style="text-align: right">Unite Price</th>
                        <th style="text-align: right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $slNo = 1;
                    foreach ($purchaseDetailInfo AS $item) {
                        ?>
                        <tr>
                            <td style="text-align: left"><?php echo $slNo++ . " " . $item->item_name; ?></td>
                            <td><?php echo $item->mfg_date; ?></td>
                            <td><?php echo $item->exp_date; ?></td>                            
                            <td style="text-align: center"><?php echo $item->total_qty; ?></td>
                            <td style="text-align: center"><?php echo $item->received_qty; ?></td>
                            <td style="text-align: right"><?php echo number_format($item->rate); ?></td>
                            <td style="text-align: right"><?php $amount = $item->amount;
                    echo number_format($amount);
                        ?></td>
                        </tr>
                        <?php
                        $subTotal += $amount;
                    }
                    $returItems = count($returnDetailInfo);
                    if($returItems>0){
                    ?>
                        
                    <tr style="background:#CCC">
                        <th style="text-align: left">Returned Items</th>
                        <th style="text-align: center"></th>
                        <th style="text-align: center"></th>
                        <th style="text-align: center"></th>
                        <th style="text-align: center"></th>
                        <th style="text-align: right"></th>
                        <th style="text-align: right"></th>
                    </tr>
                    <?php
                    $slNo = 1;
                    foreach ($returnDetailInfo AS $item) {
                        ?>
                        <tr>
                            <td style="text-align: left"><?php echo $slNo++ . " " . $item->item_name; ?></td>
                            <th style="text-align: center"></th>
                            <th style="text-align: center"></th>
                            <th style="text-align: center"></th>
                            <td style="text-align: center">-<?php echo $item->returned_qty; ?></td>
                            <td style="text-align: right"><?php echo number_format($item->rate); ?></td>
                            <td style="text-align: right">-<?php $ReturnAmount = $item->returned_qty * $item->rate;
                    echo number_format($ReturnAmount);
                        ?></td>
                        </tr>
                        <?php
                        $returnTotal += $ReturnAmount;
                    }
                    }
                    ?>
                    <?php  if($returItems>0){ ?>
                    <tr >
                        <td colspan="6" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Return Total:</td>
                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">-<?php echo number_format($returnTotal); ?></td>
                    </tr>
                    <?php } ?>
                    <tr >
                        <td colspan="6" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Sub Total:</td>
                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">
                            <?php 
                            if($returItems>0){
                                $subTotal = $subTotal-$returnTotal;
                                echo number_format($subTotal); 
                            }else{
                                echo number_format($subTotal); 
                            }
                            ?>
                        </td>
                    </tr>
                    
<!--                                    <tr >
                        <td colspan="3" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Discount:</td>
                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo number_format($dis); ?></td>
                    </tr>-->
                    <tr >
                        <td colspan="6" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Vat:</td>
                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo number_format($purchaseInfo->vat); ?></td>
                    </tr>
<!--                                    <tr >
                        <td colspan="3" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Shipping:</td>
                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo number_format($subTotal); ?></td>
                    </tr>-->
                    <tr >
                        <td colspan="6" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Grand Total:</td>
                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">
                            <?php
                            $grandTotal = $subTotal+$purchaseInfo->vat;
                            echo number_format($grandTotal); 
                            ?>
                        </td>
                    </tr>
                    <tr >
                        <td colspan="6" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Paid:</td>
                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo number_format($purchaseInfo->paid_amount); ?></td>
                    </tr>
                    <tr >
                        <td colspan="6" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Balance:</td>
                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo number_format($grandTotal-$purchaseInfo->paid_amount); ?></td>
                    </tr>
                </tbody>
            </table>


    <?php } ?>
</div>