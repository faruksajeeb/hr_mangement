<h1 style="font-size:15px;font-weight:bold;color: #666666">Order ID <?php echo "#".str_pad($purchaseInfo->id, 11, '00000000000', STR_PAD_LEFT); ?></h1>
                   
<form id="purchase-payment-form" action="<?php echo base_url() ?>PurchaseController/saveReceiveProduct" method="POST" class="smart-form">
    <input type="hidden" class="" name="payment_purchase_id" id="purchase_id" value="<?php echo $purchaseInfo->id; ?>"  />                    
    <div id="receive_product_calculation_area">
    <table width="100%">
        <thead>
            <tr>
                <th>Sl no.</th>
                <th>#Item</th>
                <th>Order Qty</th>
                <th>Received</th>
                <th>Received Qty</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $slNo = 1;
            foreach ($purchaseDetailInfo as $singleItem) {
                $recQty = $singleItem->received_qty;
                $totalQty = $singleItem->total_qty;
                ?>
                <tr>
                    <td><?php echo $slNo; ?></td>
                    <td><?php echo $singleItem->item_name; ?></td>
                    <td><?php echo $totalQty; ?>
                        <br/>
                        <span  class="rec_validation_msg" style="color:red;font-size:10px;" ></span>
                    </td>
                    <td><?php echo ($recQty==null)? "0": $singleItem->received_qty; ?></td>
                    <td>
                        <input type="hidden" name="purchase_detail_id[]" value="<?php echo $singleItem->id; ?>" />
                        <input type="hidden" name="item_id[]" value="<?php echo $singleItem->item_id; ?>" />
                        <input type="hidden" name="purchase_qty[]" class="purchase_qty" value="<?php echo $totalQty; ?>" />
                        <input type="hidden" name="received_qty[]" class="received_qty" value="<?php echo $singleItem->received_qty; ?>" />
                        <input type="text"  <?php if($recQty==$totalQty){ echo 'disabled';}?> name="receive_qty[]" id="<?php echo $slNo;?>" class="receive_qty" />
                    </td>
                </tr>
            <?php 
                $slNo++;            
            } 
            ?>
        </tbody>
    </table>
    </div>
<div class="modal-footer">                     
                <input type="SUBMIT" name="receive_btn" class="btn-sm btn-primary pull-right" id="receive_btn" value="Save Received" />
                <a type="button" class="btn btn-default pull-left" data-dismiss="modal">
                    Cancel
                </a>
            </div>
</form>   
<script>
    $(function () {
        $("#receive_btn").attr("disabled", "disabled");
        $("#receive_product_calculation_area").delegate('.receive_qty', 'keyup', function () {
            
            var tr = $(this).parent().parent();
            var recValue = parseInt(tr.find('.receive_qty').val());
            var purValue = parseInt(tr.find('.purchase_qty').val());
            var receivedValue = parseInt(tr.find('.received_qty').val());
            var availableVal = purValue - receivedValue;
            
            if(recValue > availableVal){
                tr.find('.rec_validation_msg').text("Higher than purchase qty");
                $("#receive_btn").attr("disabled", "disabled");
            }else{
                tr.find('.rec_validation_msg').text("");
                $("#receive_btn").removeAttr("disabled", "disabled");
            }
            
        });
         $("#receive_btn").on('click', function (e) {
            
//            e.preventDefault(); //The preventDefault() method will prevent the link above from following the URL.
       
        var checkValues = $('.receive_qty').map(function ()
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
                alert("Please enter atleast one received qty");
                return false;
            }else{
                return true;
            }
        });
    });
</script>