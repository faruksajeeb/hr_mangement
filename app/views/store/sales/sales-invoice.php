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
        <title>Invoice #0000<?php echo $salesInfo->id; ?></title>
    </head>

    <body>

        <div class="page-header" style="text-align: center">
            <div class="row" style="font-weight:normal; line-height: 25px;">
                <div class="col-md-2" style="width:80px; float: left"> <img src="<?php echo base_url(); ?>resources/images/logo.png" alt="" id="logo-img"/></div>
                <div class="col-md-10" style=" text-align: right;  float: right; font-style: italic;">
                    <h1 style="font-size:25px;font-weight:bold;font-style: normal;">Order Invoice</h1>

                    <h1 style="font-size:15px;font-weight:bold;color: #666666">Order ID <?php echo "#".str_pad($salesInfo->id, 11, '00000000000', STR_PAD_LEFT); ?></h1>
                    <!--<p>House #25, Road #34, Gulshan-2, Dhaka-1212</p>-->
                    Order Date: <?php echo date_format(date_create($salesInfo->sales_date), "d M Y"); ?>
                    <br/>Order Status:
                    <?php
                    if($salesInfo->status ==-1){
                        echo '<label class="label label-danger pull-right">Canceled</label>';
                    }else if($salesInfo->total_delivered_qty==0){
                        echo '<label class="label label-warning pull-right">Pending Order</label>';
                    }else if($salesInfo->total_delivered_qty==$salesInfo->total_order_qty){
                        echo '<label class="label label-success pull-right">Delivered</label>';
                    }else if($salesInfo->total_delivered_qty<$salesInfo->total_order_qty){
                        echo '<label class="label label-info pull-right">Pertial Delivered</label>';
                    }
                    ?>
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
                        <div  style="width:550px; font-weight: bold">Employee ID: <?php echo $salesInfo->emp_id; ?></div>                   
                        <div  style="width:550px;  font-weight: bold">Employee Name: <?php echo $salesInfo->emp_name; ?></div>                   
                        <!--<div  style="width:550px;  font-weight: bold">Received By: <?php echo $salesInfo->received_by; ?></div>-->                   
                        
                </div>

            </div><br/><br/><br/>

            <table style="width:100%;">
                <thead>
                    <tr style="background:#CCC">
                        <th style="text-align: left">#Item</th>
                        <th style="text-align: center">Order Qty</th>
                        <th style="text-align: center">Delivered Qty</th>
                        <th style="text-align: center">Returned Qty</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $slNo = 1;
                    foreach ($salesDetailInfo AS $item) {
                        ?>
                        <tr>
                            <td style="text-align: left"><?php echo $slNo++ . " " . $item->item_name; ?></td>
                            <td style="text-align: center"><?php echo $item->order_qty; ?></td>
                            <td style="text-align: center"><?php echo $item->delivered_qty; ?></td>
                            <td style="text-align: center"><?php echo $item->returned_qty; ?></td>

                        </tr>
                        <?php
                        $totalOrderQty += $item->order_qty;
                        $totalDelQty += $item->delivered_qty;
                        $totalRetQty += $item->returned_qty;
                    }
                    ?>
                        <tr >
                        <td colspan="" style="text-align: left;font-weight: bold;border-top:1px solid #DCDCDC">Total Qty:</td>
                        <td style="text-align: center;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo $totalOrderQty; ?></td>
                        <td style="text-align: center;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo $totalDelQty; ?></td>
                        <td style="text-align: center;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo $totalRetQty; ?></td>
                    </tr>
                   
                   
                </tbody>
            </table>
        </div>
        <div class="page-footer-space"></div>

    </body>

</html>