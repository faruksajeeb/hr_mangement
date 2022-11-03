<script>
    $(function () {
        $("#amount").keyup(function () {
     // ckeck paid amount is not grater than net payment -------------
                var payAmount = parseInt($(this).val());
                var dueAmount = parseInt($("#due_amount").val());
                if (payAmount > dueAmount) {   
                    //alert("Invalid Payment amount! Payment  amount must be less than or equal to due amount.");
                    $("#payment_validation_msg").text("Invalid Payment amount! Payment  amount must be less than or equal to due amount.").show().fadeOut(10000);
                    $("#amount").css("border", '1px solid red');
                    $("#payment_btn").attr("disabled", "disabled");

                }else {     
    //                 alert(samount);
            
                    $("#amount").css("border", '');
                     $("#payment_btn").removeAttr("disabled", "disabled");
                }
            });
    });
</script>
<style>
    input[readonly]
{
    background-color:#CCC;
    cursor: not-allowed;
}
</style>

<div class="modal fade" id="paymentPurchaseModal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </a>
                <h4 class="modal-title" id="myModalLabel"><strong><span id="tag"></span> Add Purchase Payment</strong></h4>
            </div>
            <div class="modal-body">
                <form id="purchase-payment-form" action="<?php echo base_url() ?>PurchaseController/managePurchase" method="POST" class="smart-form">
                    <input type="hidden" class="" name="payment_purchase_id" id="payment_purchase_id"  />                    
                    <input type="hidden" class="" name="paid_amount" id="paid_amount"  />                    
                    <div class="" id="payment_area">
                        	
                        <div id="salary_area">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">Payment Date:</div>
                                        <div class="col-md-8">
                                            <?php
                                                $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
                                                $current_date = $dt->format('d-m-Y');                                               
                                            ?>
                                            <input type="text" class='datepicker' name="payment_date" id="payment_date" value="<?php echo $current_date; ?>"  />
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4  text-left">Supplier Name: </div>
                                        <div class="col-md-8">
                                            <input type="text" name="payment_supplier_name" id="payment_supplier_name" readonly="" />        
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4  text-left">Delivered By: </div>
                                        <div class="col-md-8">
                                            <input type="text" name="payment_delevired_by" id="payment_delevired_by" readonly=""  value=""/>        
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4  text-left">Grand Total: </div>
                                        <div class="col-md-8">
                                            <input type="text" name="grand_total" id="grand_total" readonly=""  value=""/>        
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4  text-left">Due Amount: </div>
                                        <div class="col-md-8">
                                            <input type="text" name="due_amount" id="due_amount" readonly=""  value=""/>        
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4  text-left">Payment Account: </div>
                                        <div class="col-md-8">
                                            <select name="account_id" id="account_id">
                                                <?php 
                                                
                                                foreach($accounts as $account){
                                                   // echo '<option value="">Select Account</option>';
                                                    ?>
                                                <option value="<?php echo $account->ID; ?>"><?php echo $account->AccountName; ?></option>
                                                <?php 
                                                
                                                }
                                                ?>
                                            </select>        
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4  text-left">Amount: </div>
                                        <div class="col-md-8">
                                            <!--<input type="number" name="amount" id="amount"  value="" />--> 
                                            <input type="text"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="amount"  id="amount" placeholder="Enter Payment Amount"  value=""/>
                                            <span id="payment_validation_msg"></span>
                                        </div>
                                    </div>
                                    																																																								
                                </div>
                               
                            </div>
                        </div>
                        
                        							
                       
                        	
                    </div>
                    
                    <hr/>
            <footer>
<!--                <button id="payroll_edit_btn" type="submit" style="width:150px" class="btn btn-sm btn-primary pull-right">

                    Save Changes  <span id="tag_save_btn"></span>
                </button>-->
<input type="SUBMIT" name="payment_btn" class="btn-sm btn-primary pull-right" id="payment_btn" value="Save Payment" />
                <a type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                </a>

            </footer>
                     </form>   
            </div>
            
        	


        </div>

        <!--</form>-->
    </div>
</div>
</div>
<script>
   
</script>