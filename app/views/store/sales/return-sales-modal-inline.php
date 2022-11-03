<h1 style="font-size:15px;font-weight:bold;color: #666666">Order ID #0000<?php echo $salesInfo->id; ?></h1>
                   
<form id="purchase-payment-form" action="<?php echo base_url() ?>SalesController/saveSalesReturnProduct" method="POST" class="smart-form">
    <input type="hidden" class="" name="sales_id" id="sales_id" value="<?php echo $salesInfo->id; ?>"  />                    
    <div id="returned_product_calculation_area">
    <table width="100%">
        <thead>
            <tr>
                <th>Sl no.</th>
                <th>#Item</th>
                <th>Delivered Qty</th>
                <th>Returned</th>
                <th>Return Qty. </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $slNo = 1;
            foreach ($salesDetailInfo as $singleItem) {
                $retQty = $singleItem->returned_qty;
                $deliveredQty = $singleItem->delivered_qty;
                $stockQty = $singleItem->current_qty;
                ?>
                <tr>
                    <td><?php echo $slNo; ?></td>
                    <td><?php echo $singleItem->item_name; ?></td>
                    <td><?php echo $deliveredQty; ?>
                        <br/>
                        <span  class="ret_validation_msg" style="color:red;font-size:10px;" ></span>
                    </td>
                    <td><?php echo ($retQty==null)? "0": $retQty; ?></td>
                    <td>
                        <input type="hidden" name="sales_detail_id[]" value="<?php echo $singleItem->id; ?>" />
                        <input type="hidden" name="item_id[]" value="<?php echo $singleItem->item_id; ?>" />
                        <input type="hidden" name="delivered_qty[]" class="delivered_qty" value="<?php echo $deliveredQty; ?>" />
                        <input type="hidden" name="stock_qty[]" class="stock_qty" value="<?php echo $stockQty; ?>" />
                        <input type="hidden" name="returned_qty[]" class="returned_qty" value="<?php echo $retQty; ?>" />
                        <input type="text"  <?php if($orderQty==$retQty){ echo 'disabled';}?> name="return_qty[]" id="return_qty<?php echo $slNo;?>" class="return_qty" />
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
        <div class="col-md-4  text-left">Return By: </div>
        <div class="col-md-8">
            <input type="text" name="return_by" id="return_by"  value=""/>        
        </div>
    </div>                                  
                             
<div class="modal-footer">                     
                <input type="SUBMIT" name="return_btn" class="btn-sm btn-primary pull-right" id="return_btn" value="Save Return" />
                <a type="button" class="btn btn-default pull-left" data-dismiss="modal">
                    Cancel
                </a>
            </div>
</form>   
<script>
    $(function () {
        $("#return_btn").attr("disabled", "disabled");
        $("#returned_product_calculation_area").delegate('.return_qty', 'keyup', function () {
            
            var tr = $(this).parent().parent();
            var retValue = parseInt(tr.find('.return_qty').val());
            var delValue = parseInt(tr.find('.delivered_qty').val());
            var returnedValue = parseInt(tr.find('.returned_qty').val());
            var stockQty = parseInt(tr.find('.stock_qty').val());
            var availableVal = delValue - returnedValue;
//            alert(availableVal);
            if(retValue > availableVal){
                tr.find('.ret_validation_msg').text("Higher than delivred qty");
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