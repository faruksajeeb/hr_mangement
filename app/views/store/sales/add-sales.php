<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> HRMS | Create Order </title>
        <!--chosen--> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.css">
        <?php
        $this->load->view('includes/cssjs');
        ?> 
        <script>
            var res = "success";
        <?php
        $x = "<script>document.writeln(res);</script>";
        echo $x;
        ?>
        </script>

        <script>
            $(document).ready(function () {
                
                // Add item -------------------
                $(".item_name").change(function () {
                    var id = $(this).val();
                    //alert(id);
                    var gridItem = $('.grid_item_name').val();
                     var checkExist ='';
                    //alert(gridItem);
                    var slNo=0;
                    $('#update_item').val('');
                    $('.grid_item_name').each(function (i, e) {
                        //alert(slNo);
                        var existProductId = $(this).val();
                        if (id == existProductId) {
                            //alert('exist');
                            var tr = $(this).parent().parent();
                            var grdQty = tr.find('.grid_qty').val();
                            var newQty = parseInt(grdQty) + parseInt(1);
                            tr.find('.grid_qty').val(newQty);
                            grdQty = tr.find('.grid_qty').val();
                            var grdPrice = tr.find('.grid_price').val();
                            var amt = grdQty*grdPrice;
                            tr.find('.grid_amount').val(amt);
                            totalCal();
                            checkExist = 'true';
                          
                        }
                       
                    });
                   //var existItem = $('#update_item').val();
                    if((!gridItem) || (checkExist !='true')){
                      addItem();  
                    }
                     
                    


                });

                // Delete item -----------
                $('body').delegate('.remove', 'click', function () {
                    $(this).parent().parent().remove();
                    totalCal();
                });
                // Vat Entry calculation-------------
                $('.grand_table').delegate('.vat_percentage,.discount_percetage', 'keyup', function () {
                    totalCal();
                });
                // Paid Amount Entry check up and calculation------
                $('.grand_table').delegate('.paid_amount', 'keyup', function () {
                    var grandTotal = $('.grand_total').val();
                    var paidAmount = $('.paid_amount').val();
                    var dueAmount = grandTotal - paidAmount;
                    if (dueAmount < 0) {
                        alert('Invalid amount!');
                        $('.paid_amount').val(grandTotal);
                        $('.due_amount').val(0);
                    } else {
                        $('.due_amount').val(dueAmount.toFixed(2));
                    }
                });
                // Grid items area caculation --------------
                $('.grid_area').delegate('.grid_number_of_pack,.grid_qty_per_pack,.grid_price,.grid_qty', 'keyup', function () {
                    var tr = $(this).parent().parent();
                    var numberOfPack = tr.find('.grid_number_of_pack').val();
                    var qtyPerPack = tr.find('.grid_qty_per_pack').val();
                    var qty = numberOfPack * qtyPerPack;
                    tr.find('.grid_qty').val(qty);
                    var price = tr.find('.grid_price').val();
                    var qty = tr.find('.grid_qty').val();
                    var amt = (qty * price);
                    tr.find('.grid_amount').val(amt);
                    totalCal();
                });
                // If item change into grid --------------------------
                $('.grid_area').delegate('#grid_item_name', 'change', function () {
                    var id = $(this).val();
                    var tr = $(this).parent().parent();
                    // alert(id);
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo base_url('PurchaseController/itemInfoById'); ?>",
                        data: {id: id},
                        dataType: "JSON",
                        cache: false,
                        success: function (data) {
                            tr.find('.grid_price').val(data.current_price);
                            var price = tr.find('.grid_price').val();
                            var qty = tr.find('.grid_qty').val();
                            var amt = (qty * price);
                            // alert(price);
                            tr.find('.grid_amount').val(amt);
                            totalCal();
                        },
                        error: function () {
                            alert("error");
                        }
                    });
                });
                // Dainamic date picker into grid items ------
                 $('body').on('focus',".datepicker", function(){
                    $(this).datepicker({ 
                        dateFormat: 'yy-mm-dd' 
                    });
                    
                });
            });

            function addItem(){
                var id = $("#item_name").val();
                $.ajax({
                    type: 'POST',
                    url: "<?PHP echo base_url('PurchaseController/itemInfoById'); ?>",
                    data: {id: id},
                    dataType: "JSON",
                    cache: false,
                    success: function (data) {
                        $("#item_price").val(data.current_price);
                        var qty = $('#total_qty').val();
                        var price = $('#item_price').val();
                        var amt = (qty * price);
                        $('#amount').val(amt);
                        var selectedProductId = $('#item_name').val();

                        var selectedProduct = $('#item_name option:selected').text();
                        var n = ($('.grid tr').length - 0) + 1;
                        var sl = '<td >' + n + '</td>';
                        var a = '<td> <select name="grid_item_name[]" id="grid_item_name" class="grid_item_name"  value="' + $('#item_name').val() + '"  class="" style="width:200px; z-index:9999" data-placeholder="Please select item">' +
                                '<option value=' + selectedProductId + '>' + selectedProduct + '</option>' +
                        <?php
                        foreach ($items AS $item) {
                            //$x = "<script>document.writeln(productId);</script>";
                            ?>
                            '<option value="<?php echo $item->id; ?>"><?php echo $item->item_name; ?></option>' +
                        <?php
                        }
                        ?>          
                        '</select></td>';
                        //var b = '<td> <input type="text" value="' + $('#batch_no').val() + '" placeholder="XX"   class=" pbatch_no" id="batch_no" name="batch_no[]"/> </td>';
                        //var c = '<td> <input type="text" placeholder="date"  class="mpg_date datepicker"  value="" id="mfg_date' + n + '"  name="mfg_date[]"/> </td>';
                       // var d = '<td> <input type="text" placeholder="date"  class="exp_date datepicker" value="" id="exp_date' + n + '" name="exp_date[]"/> </td>';
                        var e = '<td> <input type="text" placeholder="xx"  class="grid_number_of_pack" value="' + $('#number_of_pack').val() + '" id="number_of_pack' + n + '" name="number_of_pack[]"/> </td>';
                        var f = '<td> <input type="text" placeholder="xx"  class="grid_qty_per_pack" value="' + $('#qty_per_pack').val() + '" id="qty_per_pack' + n + '" name="qty_per_pack[]"/> </td>';
                        //var g = '<td> <input type="text" placeholder="xx"  class="pfree_qty" value="' + $('#free_qty').val() + '" id="free_qty" name="free_qty[]"/> </td>  ';
                        var h = '<td> <input type="text" placeholder="XX" class="grid_qty"  value="' + $('#total_qty').val() + '" id="total_qty' + n + '" name="total_qty[]"/></td> ';
                        //var i = '<td><input type="text" placeholder="XX" class="grid_price"  value="' + $('#item_price').val() + '" id="item_price' + n + '" name="item_price[]" required=""/></td>      ';
                        //                    var j = '<td><input type="text" placeholder="XX" class="ppprice" value="' + $('#parmacy_pprice').val() + '" id="parmacy_pprice" name="parmacy_pprice[]" required=""/></td>    ';
                        //                    var k = '<td><input type="text" placeholder="XX" class="pdiscount" value="' + $('#pdiscount').val() + '" id="pdiscount" name="pdiscount[]"/></td> ';
                        //var l = '<td><input type="text" placeholder="XX" class="grid_amount"  value="' + $('#amount').val() + '" id="amount' + n + '" name="amount[]"/></td> ';
                        var m = '<td> <span class="glyphicon glyphicon-remove remove btn btn-xs btn-danger"></span></td>';
                        $(".item_grid").append('<tr style="border: 1px solid #2F4F4F;">' + sl + a + e + f + h + m + '</tr>');

                        totalCal();
                    }
                });
            }

            function totalCal() {
                var subTotal = 0;
                var grandTotal = 0;
                var vatAmount = 0;
                var paidAmount = 0;
                var dueAmount = 0;
                $('.grid_amount').each(function (i, e) {
                    var singleAmount = $(this).val();
                    singleAmount = singleAmount - 0;
                    //vat = $('.grid_vat').val();
                    subTotal += singleAmount;
                    var vatPercentage = $('.vat_percentage').val();
                    vatAmount = (subTotal * vatPercentage) / 100;
                    grandTotal = subTotal + vatAmount;
                });

                $('.sub_total').val(subTotal.toFixed(2));

                $('.grand_total').val(grandTotal.toFixed(2));
                $('.paid_amount').val(grandTotal.toFixed(2));

                paidAmount = $('.paid_amount').val();
                var dueAmount = grandTotal - paidAmount;
                $('.due_amount').val(dueAmount.toFixed(2));
            }
            function ConfirmDelete()
            {
                var x = confirm("Are you sure you want to delete?");
                if (x)
                    return true;
                else
                    return false;
            }
            function validate() {
                var valid = true;
                var msg = "<ul>";
                if (document.myForm.consumer_name.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.myForm.consumer_name.focus();
                        document.myForm.consumer_name.style.border = "solid 1px red";
                        msg += "<li>You need to select the consumer name field!</li>";
                        valid = false;
                        // return false;
                    }
                }
                

                if (!valid) {
                    msg += "</ul>";
                    //console.log("Hello Bd");
                    var div = document.getElementById('errors').innerHTML = msg;
                    document.getElementById("errors").style.display = 'block';
                    return false;
                }
                
                var gridItem = $('.grid_item_name').val();
                if(!gridItem){
                    alert("Please choose an item");
                    document.myForm.item_name.focus();
                    return false;
                }

            }
        </script>  
        <style>
            /*    .purchase_form input,select{
                    height: 20px;
                }
                .chosen-select{
                    height: 20px;
                }*/
            table { 
                //border-spacing: 2px;
                //border-collapse: separate;
            }
            td { 
                padding: 1px;
            }
            th{
                background:#CCC !important;
            }
            .chosen-container-single .chosen-single {
                height: 40px;
                border-radius: 3px;
                border: 1px solid #CCCCCC;
                vertical-align:middle;
            }
            .chosen-container-single .chosen-single span {
                padding: 5px;
            }
            .chosen-container-single .chosen-single div b {
                margin: 2px;
            }
        </style>
    </head>
    <body class="logged-in dashboard current-page add-division">
        <!-- Page Content -->  
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php
                $this->load->view('includes/menu');
                ?>
                <div class="wrapper">
                    <div class="row"  >
                        <div class="col-md-1"></div>
                        <div class="col-md-10 col-xs-10 " style="background:#CCC">
                            <div class="row add-form-heading">
                                <div class="col-md-12 "><span class="glyphicon glyphicon-plus-sign"> </span> Create Order </div>
                            </div>

                            <form   id="myForm"  name="myForm"  action=""  onSubmit="return validate();"  method="POST" class='form form-bordered'>
                                <div id="errors" style="color:red">
                                            <?php
                                            $errMsg = $this->session->flashdata('errors');
                                            if ($errMsg) {
                                                echo $errMsg;
                                                $this->session->set_flashdata('errors', '');
                                            }
                                            ?>
                                        </div>
                                        
                                <div class="form-group" style="">
                                    <label for="textfield" class="control-label col-sm-2">Employee name</label>
                                    <div class="col-sm-3">
                                        <select name="consumer_name"  id="consumer_name" class='form-control  chosen-select' style="">
                                            <option value="">Employee name</option>
                                            <?php
                                            foreach ($consumers AS $consumer) {
                                                ?>
                                                <option value="<?php echo $consumer['content_id']; ?>" <?php if($vendor_id==$consumer['content_id']){ echo "selected"; }?>><?php echo $consumer['emp_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
<!--                                    <label for="textfield" class="control-label col-sm-2">Received By</label>
                                    <div class="col-sm-2">
                                        <input type="text" placeholder="Received by"  class="form-control " id="received_by" name="received_by"/> 
                                    </div> -->
                                    <label for="textfield" class="control-label col-sm-1">Order Date</label>
                                    <div class="col-sm-2">
                                    <?php
                                    $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
                                    $current_date = $dt->format('d-m-Y');
                                    $current_year = $dt->format('Y');
                                    ?>
                                        <input type="text" placeholder="" value="<?php echo $current_date; ?>"  class="form-control datepicker" id="sales_date" name="sales_date"/>  
                                    </div>
                                </div>
                                <div class="row"  style="border-bottom:1px solid #FFF;margin-bottom:20px;"></div>

                                <div class="form-group">
                                    <table class="grand_table" style="width:100%;font-size: 10px;">

                                        <tr  style="height:35px; padding: 5px;"> 
                                            
                                            <td  colspan="7" >
                                                <select style="width:500px" name="item_name" id="item_name" class="item_name chosen-select form-control"  data-placeholder="Choose an item..." >
                                                    <option value="">-- Choose an item --</option>
                                                   <?php foreach ($items AS $item) { ?>
                                                        <option value="<?php echo $item->id; ?>"><?php echo $item->item_name; ?></option>
                                                    <?php } ?>

                                                </select>
                                                <input type="hidden" placeholder="xx"  class="number_of_pack" value="1"  id="number_of_pack" name="number_of_pack"/>
                                                <input type="hidden" placeholder="xx"  class="qty_per_pack" value="1"  id="qty_per_pack" name="qty_per_pack"/>
                                                <input type="hidden" placeholder="xx"  class="total_qty" value="1"  id="total_qty" name="total_qty"/>
                                                <!--<input type="hidden" placeholder="xx"  class="item_price" value=""  id="item_price" name="item_price"/>-->
                                                <!--<input type="hidden" placeholder="xx"  class="amount" value=""  id="amount" name="amount"/>-->
                                                <input type="hidden" placeholder="xx"  class="update_item" value=""  id="update_item" name="update_item"/>
                                            </td>
                                            <td colspan="7"></td>
                                        </tr>
                                        <tr style="height:150px; vertical-align: top;">
                                            <td colspan="14" style="background-color:#B0E0E6;padding:5px; border-radius: 5px;border: 1px solid #2F4F4F;">
                                                <table class="grid_area" style=" border: 1px solid #2F4F4F;width:100%;">
                                                    <thead>
                                                        <tr style="background-color:#2F4F4F;color: #fff;">
                                                            <th>Sl.</th>
                                                            <th>Item Name</th>
                                                            <!--<th>Batch No</th>-->
                                                            <th title="Number of pack">NOP</th>
                                                            <th title="Quantity per pack">QPP</th>
                                                            <!--<th>Free Qty</th>-->
                                                            <th title="Total quantity">T. Qty</th>                
                                                            <!--<th>Rate</th>-->
                                                            <!--<th title="Pharmacy rate">P rate</th>-->
                                                            <!--<th title="Discount">Dct(%)</th>-->
                                                            <!--<th title="Amount">Amt</th>-->
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="item_grid grid" >

                                                        <!--displaying flying value-->
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tfoot>               
<!--                                            <tr>
                                                <th colspan="12"></th>  
                                                <th style="text-align: right;">Sub Total</th>
                                                <th class="subtotal" style="text-align: center;">
                                                    <input type="text" class="form-control sub_total" id="sub_total" name="sub_total"/>
                                                </th>                
                                            </tr>-->
<!--                                            <tr>
                                                <th colspan="10">NOTE:</th>               
                                                <th style="text-align: right;">Vat (%)</th> 
                                                <th class="total" style="text-align: center;">
                                                    
                                                    <input type="text" class="form-control vat_percentage" id="vat_percentage" name="vat_percentage"/>
                                                </th>
                                                <th style="text-align: right;">Grand Total</th>   
                                                <th class="total" style="text-align: center;">
                                                    <input type="text" class="form-control grand_total" id="grand_total" name="grand_total"/>
                                                </th> 
                                            </tr>-->
                                            <tr>                    
                                                <th colspan="10">
                                                    Note:
                                                    <!--<input type="text" class="form-control note" id="note" name="note"/>-->
                                                    <textarea  class="form-control note" id="note" name="note" row="1"></textarea>
                                                </th>                    
<!--                                                <th style="text-align: right;">Paid Amount</th>              
                                                <th class="total" style="text-align: center;">
                                                    <input type="text" style="" class="form-control paid_amount" id="paid_amount" name="paid_amount"/>
                                                </th>
                                                <th style="text-align: right;">Amount to Pay /Due</th>                 
                                                <th class="total" style="text-align: center;">
                                                    <input type="text" class="form-control due_amount" id="due_amount" name="due_amount"/>
                                                </th>                   -->
                                            </tr>   
                                            <tr>                    
                                                <th colspan="12"></th>                    
                                                <th style="text-align: right;"></th>                 
                                                <th class="total" style="text-align: right;">              
                                                    <input type="submit" name="save_btn" class="btn btn-primary " value="Send Order" /> 
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <table class="pur_calculate purchase_form " style="text-align:center;color:#000; font-size: 10px;width:100%">

                                    <tbody class="detail">           


                                    </tbody>

                                </table>
                            </form>

                        </div>
                        <div class="col-md-1"></div>

                    </div>

                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <div style="color:green">
            <?php echo $msg; ?>
        </div>
        <!-- /#wrapper -->        
        <!--Chosen--> 
        <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>