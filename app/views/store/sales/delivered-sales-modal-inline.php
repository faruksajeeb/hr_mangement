<h1 style="font-size:15px;font-weight:bold;color: #666666">Order ID #0000<?php echo $salesInfo->id; ?></h1>
                   
<form id="purchase-payment-form" action="<?php echo base_url() ?>SalesController/saveDeliveredProduct" method="POST" class="smart-form">
    <input type="hidden" class="" name="sales_id" id="sales_id" value="<?php echo $salesInfo->id; ?>"  />                    
    <div id="delivered_product_calculation_area">
    <table width="100%">
        <thead>
            <tr>
                <th>Sl no.</th>
                <th>#Item</th>
                <th>Order Qty</th>
                <th>Delivered</th>
                <th>Delivered Qty. </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $slNo = 1;
            foreach ($salesDetailInfo as $singleItem) {
                $delQty = $singleItem->delivered_qty;
                $orderQty = $singleItem->order_qty;
                $stockQty = $singleItem->current_qty;
                ?>
                <tr>
                    <td><?php echo $slNo; ?></td>
                    <td><?php echo $singleItem->item_name; ?></td>
                    <td><?php echo $orderQty; ?>
                        <br/>
                        <span  class="rec_validation_msg" style="color:red;font-size:10px;" ></span>
                    </td>
                    <td><?php echo ($delQty==null)? "0": $delQty; ?></td>
                    <td>
                        <input type="hidden" name="sales_detail_id[]" value="<?php echo $singleItem->id; ?>" />
                        <input type="hidden" name="item_id[]" value="<?php echo $singleItem->item_id; ?>" />
                        <input type="hidden" name="order_qty[]" class="order_qty" value="<?php echo $orderQty; ?>" />
                        <input type="hidden" name="stock_qty[]" class="stock_qty" value="<?php echo $stockQty; ?>" />
                        <input type="hidden" name="delivered_qty[]" class="delivered_qty" value="<?php echo $delQty; ?>" />
                        <input type="text"  <?php if($orderQty==$delQty){ echo 'disabled';}?> name="deliver_qty[]" id="<?php echo $slNo;?>" class="deliver_qty" />
                    </td>
                </tr>
            <?php 
                $slNo++;            
            } 
            ?>
        </tbody>
    </table>
    </div>
  
    <div class="row">
        <div class="col-md-4  text-left">Received By: </div>
        <div class="col-md-8">
            <input type="text" name="received_by" id="received_by"  value=""/>        
        </div>
    </div>                                  
                             
<div class="modal-footer">                     
                <input type="SUBMIT" name="receive_btn" class="btn-sm btn-primary pull-right" id="receive_btn" value="Save Delivered" />
                <a type="button" class="btn btn-default pull-left" data-dismiss="modal">
                    Cancel
                </a>
            </div>
</form>   
<script>
    $(function () {
        $("#receive_btn").attr("disabled", "disabled");
        $("#delivered_product_calculation_area").delegate('.deliver_qty', 'keyup', function () {
            
            var tr = $(this).parent().parent();
            var delValue = parseInt(tr.find('.deliver_qty').val());
            var ordValue = parseInt(tr.find('.order_qty').val());
            var deliveredValue = parseInt(tr.find('.delivered_qty').val());
            var stockQty = parseInt(tr.find('.stock_qty').val());
            var availableVal = ordValue - deliveredValue;
//            alert(availableVal);
            if(delValue > availableVal){
                tr.find('.rec_validation_msg').text("Higher than order qty");
                $("#receive_btn").attr("disabled", "disabled");
            }else{
                if(delValue > stockQty){
                    tr.find('.rec_validation_msg').text("Higher than stock qty");
                    $("#receive_btn").attr("disabled", "disabled");
                }else{
                    tr.find('.rec_validation_msg').text("");
                    $("#receive_btn").removeAttr("disabled", "disabled");
                }
            }
            
        });
         $("#receive_btn").on('click', function (e) {
            
//            e.preventDefault(); //The preventDefault() method will prevent the link above from following the URL.
       
        var checkValues = $('.deliver_qty').map(function ()
            {
                var hasVal = $.trim($(this).val());
                //alert(hasVal);
                if(hasVal != ""){
                    return $(this).val();
                }                
            }).get();
            console.log(checkValues);
            $.each(checkValues, function (i, val) {
                //$("#" + val).remove();
            });
//                    return  false;
    
            if (checkValues.length === 0) //tell you if the array is empty
            {
                alert("Please enter atleast one deliver qty");
                return false;
            }else{
                return true;
            }
        });
    });
</script>