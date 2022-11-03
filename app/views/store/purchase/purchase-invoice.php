<!DOCTYPE html>
<html>

    <head>
        <style>
            /* Styles go here */

            .page-header, .page-header-space {
                height: 100px;
            }

            .page-footer, .page-footer-space {
                height: 50px;

            }

            .page-footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                border-top: 1px solid black; /* for demo */
                /*background: yellow;*/ 
                /* for demo */
            }

            .page-header {
                position: fixed;
                top: 0mm;
                width: 100%;
                border-bottom: 1px solid black; /* for demo */
                /*background: yellow;*/ 
                /* for demo */
            }

            .page {
                page-break-after: always;
            }

            @page {
                margin: 20mm
            }

            @media print {
                thead {display: table-header-group;} 
                tfoot {display: table-footer-group;}

                button {display: none;}

                body {margin: 0;}
            }
        </style>
    </head>

    <body>

        <div class="page-header" style="text-align: center">
            <div class="row" style="font-weight:normal; line-height: 25px;">
                <div class="col-md-2" style="width:80px; float: left"> <img src="<?php echo base_url(); ?>resources/images/logo.png" alt="" id="logo-img"/></div>
                <div class="col-md-10" style=" text-align: right;  float: right; font-style: italic;">
                    <h1 style="font-size:25px;font-weight:bold;font-style: normal;">Purchase Invoice</h1>

                    <h1 style="font-size:15px;font-weight:bold;color: #666666">
                        Purchase ID 
                        <?php echo "#".str_pad($purchaseInfo->id, 11, '00000000000', STR_PAD_LEFT); ?>
                    </h1>
                    <!--<p>House #25, Road #34, Gulshan-2, Dhaka-1212</p>-->
                    Order Date: <?php echo date_format(date_create($purchaseInfo->purchase_date), "d M Y"); ?>

                </div>

            </div>        
        </div>
        <div class="page-header-space"></div>
        <div class="page-footer">
            <div class="row">
                <div class="col-md-12 footer">
                    <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 10pt; 
                           color: #000000; font-weight: bold; font-style: italic;text-align: left; ">
                        <tr style="margin-bottom:10px;">
                            <td width="25%">
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
                                    Received By:<br><br>
                                </span>
                            </td>

                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="body">
            <div class="row" style="font-style: italic">                               
                <div class="col-md-12" style=''>
                        <br/>
                        <div  style="width:250px; font-weight: bold"><?php echo $purchaseInfo->supplier_name; ?></div>                   
                        <div  style="width:250px;  font-weight: bold"><?php echo $purchaseInfo->delevired_by; ?></div>                   
                        <div  style="width:250px;  font-weight: bold"><?php echo $purchaseInfo->contact_person; ?></div>                   
                        <div>
                            
                    <?php echo $purchaseInfo->address; ?><br>
                    <?php echo $purchaseInfo->phone; ?><br>
                    <?php echo $purchaseInfo->email; ?><br>
                        </div>
                </div>

            </div>

            <table style="width:100%;">
                <thead>
                    <tr style="background:#CCC">
                        <th style="text-align: left">#Item</th>
                        <th style="text-align: center">Qty</th>
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
                            <td style="text-align: center"><?php echo $item->total_qty; ?></td>
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
                        <th style="text-align: right"></th>
                        <th style="text-align: right"></th>
                    </tr>
                    <?php
                    $slNo = 1;
                    foreach ($returnDetailInfo AS $item) {
                        ?>
                        <tr>
                            <td style="text-align: left"><?php echo $slNo++ . " " . $item->item_name; ?></td>
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
                        <td colspan="3" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Return Total:</td>
                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">-<?php echo number_format($returnTotal); ?></td>
                    </tr>
                    <?php } ?>
                    <tr >
                        <td colspan="3" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Sub Total:</td>
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
                        <td colspan="3" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Vat:</td>
                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo number_format($purchaseInfo->vat); ?></td>
                    </tr>
<!--                                    <tr >
                        <td colspan="3" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Shipping:</td>
                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo number_format($subTotal); ?></td>
                    </tr>-->
                    <tr >
                        <td colspan="3" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Grand Total:</td>
                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">
                            <?php
                            $grandTotal = $subTotal+$purchaseInfo->vat;
                            echo number_format($grandTotal); 
                            ?>
                        </td>
                    </tr>
                    <tr >
                        <td colspan="3" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Paid:</td>
                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo number_format($purchaseInfo->paid_amount); ?></td>
                    </tr>
                    <tr >
                        <td colspan="3" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Balance:</td>
                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo number_format($grandTotal-$purchaseInfo->paid_amount); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="page-footer-space"></div>

    </body>

</html>