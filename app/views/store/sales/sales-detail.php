<div id="sales-detail" title="Issue Details" style="border:1px solid #ccc; padding: 5px;">
    <?php if ($salesInfo) {
        ?>   
        <style>

        </style>
        <div class="row" style="font-weight:normal; line-height: 25px;">
            <div class="col-md-2" style="width:80px; float: left"> <img src="<?php echo base_url(); ?>resources/images/logo.png" alt="" width="100px;" id="logo-img"/></div>
                <div class="col-md-10" style=" text-align: right;  float: right; font-style: italic;">
                    <h1 style="font-size:25px;font-weight:bold;font-style: normal;"> Invoice</h1>

                    <h1 style="font-size:15px;font-weight:bold;color: #666666">Issue Ref <?php echo "#".str_pad($salesInfo->id, 11, '00000000000', STR_PAD_LEFT); ?></h1>
                    <!--<p>House #25, Road #34, Gulshan-2, Dhaka-1212</p>-->
                    Issue Req. Date: <?php echo date_format(date_create($salesInfo->sales_date), "d M Y"); ?>
                    <br/>
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
        <div class="row" style="font-style: italic">                               
                <div class="col-md-12" style=''>
                        <br/>
                        <div  style="width:550px; font-weight: normal">Employee ID: <?php echo $salesInfo->emp_id; ?></div>                   
                        <div  style="width:550px;  font-weight: normal">Employee Name: <?php echo $salesInfo->emp_name; ?></div>                   
                        <div  style="width:550px;  font-weight: normal">Received By: 
                            <?php 
                            if($salesInfo->received_by !=NULL){
                            echo $salesInfo->received_by; 
                            }else{
                                $salesDelInfo = $this->db->query("SELECT received_by FROM str_sales_delivered WHERE sales_id=$salesInfo->id LIMIT 1")->row();
                            echo $salesDelInfo->received_by;
                                
                            }
                            ?>
                        </div>                   
                        
                </div>

            </div>

                    <br/>
                            NOTE: <?php echo $salesInfo->note; ?>
                   
        <br/>

       
        <table style="width:100%;">
                <thead>
                    <tr style="background:#CCC">
                        <th style="text-align: left">#Item</th>
                        <th style="text-align: center">Order Qty</th>
                        <th style="text-align: center">Delivered Qty</th>
                        <th style="text-align: center">Return Qty</th>
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
                        <td colspan="" style="text-align: left;font-weight: bold;border-top:1px solid #DCDCDC">Total :</td>
                        <td style="text-align: center;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo $totalOrderQty; ?></td>
                        <td style="text-align: center;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo $totalDelQty; ?></td>
                        <td style="text-align: center;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo $totalRetQty; ?></td>
                    </tr>
                  
                   
                   
                </tbody>
            </table>


    <?php } ?>
</div>