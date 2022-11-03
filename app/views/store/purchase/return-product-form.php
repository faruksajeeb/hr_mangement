<h1 style="font-size:15px;font-weight:bold;color: #666666">Order ID <?php echo "#".str_pad($purchaseInfo->id, 11, '00000000000', STR_PAD_LEFT); ?></h1>
                   
<form id="purchase-payment-form" action="<?php echo base_url() ?>PurchaseController/saveReturnProduct" method="POST" class="smart-form">
    <input type="hidden" class="" name="payment_purchase_id" id="purchase_id" value="<?php echo $purchaseInfo->id; ?>"  />                    
    <div id="return_product_calculation_area">
    <table width="100%">
        <thead>
            <tr>
                <th>Sl no.</th>
                <th>#Item</th>
                <th>Purchase Qty</th>
                <th>Received</th>
                <th>Returned</th>
                <th>Return Qty</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $slNo = 1;
            foreach ($purchaseDetailInfo as $singleItem) {
                $recQty = $singleItem->received_qty;
                $retQty = $singleItem->returned_qty;
                ?>
                <tr>
                    <td><?php echo $slNo; ?></td>
                    <td><?php echo $singleItem->item_name; ?></td>
                    <td><?php echo $singleItem->total_qty; ?>
                        
                    </td>
                    <td><?php echo ($recQty==null)? "0": $singleItem->received_qty; ?>
                    <br/>
                        <span  class="ret_validation_msg" style="color:red;font-size:10px;" ></span>
                    </td>
                    <td><?php echo ($retQty==null)? "0": $singleItem->returned_qty; ?></td>
                    <td>
                        <input type="hidden" name="purchase_detail_id[]" value="<?php echo $singleItem->id; ?>" />
                        <input type="hidden" name="item_id[]" value="<?php echo $singleItem->item_id; ?>" />
                        <input type="hidden" name="purchase_qty[]" class="purchase_qty" value="<?php echo $singleItem->total_qty; ?>" />
                        <input type="hidden" name="received_qty[]" class="received_qty" value="<?php echo $singleItem->received_qty; ?>" />
                        <input type="hidden" name="returned_qty[]" class="returned_qty" value="<?php echo $singleItem->returned_qty; ?>" />
                        <input type="text" <?php if($recQty==0){ echo 'disabled';}?> name="return_qty[]" id="<?php echo $slNo;?>" class="return_qty" />
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
                <input type="SUBMIT" name="return_btn"  class="btn-sm btn-success pull-right" id="return_btn" class="return_btn" value="Save Ruturn" />
                <a type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                    Cancel
                </a>
            </div>
</form>   
<script>
    $(function () {
        $("#return_btn").attr("disabled", "disabled");
      
        $("#return_product_calculation_area").delegate('.return_qty', 'keyup', function () {            
            var tr = $(this).parent().parent();
            var returnValue = parseInt(tr.find('.return_qty').val());
            var receivedValue = parseInt(tr.find('.received_qty').val());            
            var returnedValue = parseInt(tr.find('.returned_qty').val());
            var avalableValue = receivedValue - returnedValue;
            if(returnValue > avalableValue){
                tr.find('.ret_validation_msg').text("Return Qty is Higher than received Qty");
                $("#return_btn").attr("disabled", "disabled");
            }else{
                tr.find('.ret_validation_msg').text("");
                $("#return_btn").removeAttr("disabled", "disabled");
            }
            
        });
        $("#return_btn").on('click', function (e) {
            
//            e.preventDefault(); //The preventDefault() method will prevent the link above from following the URL.
       
        var checkValues = $('.return_qty').map(function ()
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
                alert("Please enter atleast one return qty");
                return false;
            }else{
                return true;
            }
        });
    });
</script>