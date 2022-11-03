<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS | Manage Purchase</title>
        <?php
        $this->load->view('includes/cssjs');
        ?> 

        <script>
            $(document).ready(function () {
                
                var purchaseDialog = $("#purchase-detail").dialog({
                    autoOpen: false,
                    height: "auto",
                    width: "auto",
                    modal: false,
                    dialogClass: 'dialogWithDropShadow',
                    position: {
                        my: "center",
                        at: "center",
                    },
                    Cancel: function () {
                        purchaseDialog.dialog("close");
                    },
                });
                $('.purchase_detail').click(function () {
                    //	alert(0);
                    var purchaseId = $(this).attr('id');
//                     alert(purchaseId);

                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>PurchaseController/getPurchaseDetailById",
                        data: {purchase_id: purchaseId},
                        dataType: "html",
                        cache: false,
                        success: function (data) {
                            // alert(data);
                            $("#purchase-detail").html(data);
                            purchaseDialog.dialog("open");

                        }, error: function () {
                            alert('ERROR!');
                        }
                    });
                });
                $('.received_product').click(function () {                    //	alert(0);
                    var purchaseId = $(this).attr('href');
                     //alert(purchaseId);
                     
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>PurchaseController/getOrderDetailById",
                        data: {purchase_id: purchaseId},
                        dataType: "html",
                        cache: false,
                        success: function (data) {
                            // alert(data);
                            $("#receive-product-modal .modal-body").html(data)
                            $("#receive-product-modal").modal(show);
                        }, error: function () {
                            alert('ERROR!');
                        }
                    });
                });
                $('.return_product').click(function () {                    //	alert(0);
                    var purchaseId = $(this).attr('href');
                     //alert(purchaseId);
                     
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>PurchaseController/getOrderDetailById2",
                        data: {purchase_id: purchaseId},
                        dataType: "html",
                        cache: false,
                        success: function (data) {
                            // alert(data);
                            $("#return-product-modal .modal-body").html(data)
                            $("#return-product-modal").modal(show);
                        }, error: function () {
                            alert('ERROR!');
                        }
                    });
                });
                
                $('.payment_purchase').click(function () {
                    //alert($(this).data('due_amount'));
                    $("#payment_validation_msg").text("").hide().fadeOut(1000);
                    $("#amount").css("border", '1px solid #CCC');
                    $("#payment_btn").removeAttr("disabled", "disabled");
                    document.getElementById("purchase-payment-form").reset();
                    $('#payment_purchase_id').val($(this).data('purchase_id'));
                    $('#payment_supplier_name').val($(this).data('supplier_name'));
                    $('#payment_delevired_by').val($(this).data('delevired_by'));
                    var paid_amount = $(this).data('paid_amount');
                    if (!paid_amount) {
                        paid_amount = 0;
                    }
                    $('#paid_amount').val(paid_amount);
                    $('#due_amount').val($(this).data('due_amount'));
                    
                    $('#grand_total').val($(this).data('grand_total'));
                });
                var dialog, form;
                dialog = $("#payment-detail").dialog({
                    autoOpen: false,
                    height: "auto",
                    width: "600",
                    modal: false,
                    dialogClass: 'dialogWithDropShadow',
                    position: {
                        my: "center",
                        at: "center",
                    },
                    Cancel: function () {
                        dialog.dialog("close");
                    },
                });
         
                $('.payment_detail').click(function () {
                    //	alert(0);
                    var paymentId = $(this).attr('id');
//                     alert(payslip_id);
                    // dialog.dialog( "open" );
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>PurchaseController/getPaymentDetailByPurchaseId",
                        data: {payment_id: paymentId},
                        dataType: "html",
                        cache: false,
                        success: function (data) {
                             //alert(data);
                            $("#payment-detail").html(data);
                            dialog.dialog("open");

                        }, error: function () {
                            alert('ERROR!');
                        }
                    });
                });
                
                // Setup - add a text input to each footer cell
                $('#example tfoot th').each(function () {
                    var title = $('#example thead th').eq($(this).index()).text();
                    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
                });

                // DataTable
                var table = $('#example').DataTable();

                // Apply the search
                table.columns().eq(0).each(function (colIdx) {
                    $('input', table.column(colIdx).footer()).on('keyup change', function () {
                        table
                                .column(colIdx)
                                .search(this.value)
                                .draw();
                    });
                });
            });
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
                if (document.myForm.vendor_name.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.myForm.vendor_name.focus();
                        document.myForm.vendor_name.style.border = "solid 1px red";
                        msg += "<li>You need to fill the vendor name field!</li>";
                        valid = false;
                        // return false;
                    }
                }
                if (document.myForm.contact_person.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.myForm.contact_person.focus();
                        document.myForm.contact_person.style.border = "solid 1px red";
                        msg += "<li>You need to fill contact_person field!</li>";
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

            }
        </script>    
        <style>
        a:hover{
                        cursor: pointer;
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
                <div class="row under-header-bar text-center"> 
                    <h4>Manage  Purchase</h4>         
                </div> 
                <div class="wrapper">
                    <div class="col-md-12">

                                        <div id="errors" style='color:red;text-align:right'></div>

                                        <?php
                                        $msg = $this->session->flashdata('success');
                                        if ($msg) {
                                            ?>
                                            <br/>
                                            <div class="alert alert-success text-center">
                                                <strong>Success!</strong> <?php echo $msg ?>
                                            </div>                                    
                                            <?php
                                        }
                                        $msg = null;
                                        ?>
                                        <?php
                                        $error = $this->session->flashdata('error');
                                        if ($error) {
                                            ?>
                                            <br/>
                                            <div class="alert alert-danger text-center">
                                                <strong>ERROR!</strong> <?php echo $error ?>
                                            </div>                                    
                                            <?php
                                        }
                                        $error = null;
                                        ?>
                                    </div>
                    <div class="row">
                        
                        <div class="col-md-12 col-xs-12 display-list">
                            
                            <table id="example" class="display" cellspacing="0" width="100%" border="1">
                                <thead>
                                    <tr class="heading">
                                        <th style="width: 20px;">Sl.</th>
                                       
                                        <th>Purchase ID</th>
                                        <th>Purchase Date</th>
                                        <th>Supplier Name</th>
                                        <th>Total Amount</th>
                                        <th>Total Payment</th>
                                        <th>Balance</th>
<!--                                        <th>Total Qty</th>
                                        <th>Receive Qty</th>-->
                                        <th>Status</th> 
                                         <th>Action</th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th style="width: 20px;">Sl.</th>
                                        
                                        <th>Purchase ID</th>
                                        <th>Purchase Date</th>
                                        <th>Supplier Name</th>
                                        <th>Total Amount</th>
                                        <th>Total Payment</th>
                                        <th>Balance</th>
<!--                                        <th>Total Qty</th>
                                        <th>Receive Qty</th>-->
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>

                                <tbody>
                                <?php
                                $slNo = 1;
                                
                                foreach ($purchaseItems AS $purchaseItem) {
                                    ?>
                                        <tr>
                                            <td><?php echo $slNo++; ?></td>
                                            
                                            <td>
                                            <?php echo "#".str_pad($purchaseItem->id, 11, '00000000000', STR_PAD_LEFT); ?>
                                            </td>
                                            <td><?php echo $purchaseItem->purchase_date; ?></td>                                            
                                            <td><?php echo $purchaseItem->supplier_name; ?></td>                                            
                                            <td><?php echo $purchaseItem->grand_total; ?></td> 
                                            <td style="text-align:right; font-style: italic;font-size:5px; "><a class="payment_detail"  id="<?php echo $purchaseItem->id ?>"><?php echo number_format($purchaseItem->paid_amount); ?></a></td>
                                                
                                            <td><?php echo $purchaseItem->balance; ?></td>
                                            <?php
                                            $purchaseId = $purchaseItem->id;
                                                $purchaseDetailData = $this->db->query("SELECT SUM(total_qty) as total_purchase_qty,SUM(received_qty) AS total_rec_qty FROM str_purchase_details WHERE purchase_id=$purchaseId GROUP BY purchase_id")->row();
                                                $totalPurchaseQty = $purchaseDetailData->total_purchase_qty;
                                                $totalRecQty = $purchaseDetailData->total_rec_qty;
                                            ?>
<!--                                            <td><?php echo $totalPurchaseQty; ?></td>
                                            <td><?php echo $totalRecQty; ?></td>-->
                                            <td style="font-style: italic">
                                                <?php
                                                if($totalRecQty==0){
                                                    echo '<label class="label label-warning">Pending Received</label>';
                                                }else if($totalRecQty==$totalPurchaseQty){
                                                    echo '<label class="label label-success">Received</label>';
                                                }else if($totalRecQty<$totalPurchaseQty){
                                                    echo '<label class="label label-info">Pertial Received</label>';
                                                }
                                                
                                                //print_r($purchaseDetailData);
//                                                if ($purchaseItem->status == 0) {
//                                                    echo '<label class="label label-warning">Pending Received</label>';
//                                                }else if ($purchaseItem->status == 1) {
//                                                    echo '<label class="label label-success">Received</label>';
//                                                }else if ($purchaseItem->status == -1) {
//                                                    echo '<label class="label label-warning">Return Purchase</label>';
//                                                }else if ($purchaseItem->status == 2) {
//                                                    echo '<label class="label label-warning">Pertial Received</label>';
//                                                }else {
//                                                    echo '<label class="label label-danger">Inactive</label>';
//                                                }
                                                ?>
                                            </td>
                                            <td style="">
                                                                                                          
                                                        
                                                <div class="dropdown" style="display:inline-block">
                                                    <!-- Example single danger button -->
                                                    <div class="btn-group">
                                                        <a class="btn dropdown-toggle btn-primary btn-sm pull-left" data-toggle="dropdown" href="#" style="margin:0 5px;display:inline-block">
                                                            Action
                                                            <span class="caret"></span>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <!-- dropdown menu links -->
                                                             
                                                            <li>
                                                                <a class="payment_purchase" title=""  data-toggle="modal"  data-target="#paymentPurchaseModal"  href="<?php echo $purchaseItem->id; ?>" style="color:#cc00cc"
                                                                             data-purchase_id="<?php echo $purchaseItem->id; ?>" 
                                                                              data-supplier_name="<?php echo $purchaseItem->supplier_name; ?>" 
                                                                              data-delevired_by="<?php echo $purchaseItem->delevired_by; ?>" 
                                                                              data-paid_amount="<?php echo $purchaseItem->paid_amount; ?>"
                                                                              data-grand_total="<?php echo $purchaseItem->grand_total; ?>"
                                                                              <?php
                                                                              $grandTotal = $purchaseItem->grand_total;
                                                                              $paymentTotal = $purchaseItem->paid_amount;
                                                                              if (!$paymentTotal) {
                                                                                  $paymentTotal = 0;
                                                                              }
                                                                              $dueAmount = $grandTotal - $paymentTotal;
                                                                              ?>
                                                                              data-due_amount="<?php echo $dueAmount; ?>" 
                                                                   >
                                                                    <span class="glyphicon glyphicon-euro"> Pay Now</span> 
                                                                </a>
                                                            </li>
                                                            <li>
                                                                 <a href="<?php echo base_url(); ?>purchase-invoice/<?php echo $purchaseItem->id; ?>" target="_blank" class="">
                                                                    <span class="glyphicon glyphicon-print"> Print</span> 
                                                                </a>
                                                            </li> 
                                                            <li>
                                                                <a class="" title="" href="#" style="color:blue">
                                                                    <span class="glyphicon glyphicon-envelope"> Email Invoice</span> 
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="received_product" title=""   href="<?php echo $purchaseItem->id; ?>"   data-toggle="modal"  data-target="#receive-product-modal" style="color:green"  >
                                                                    <span class="glyphicon glyphicon-hand-left"> Received Product</span> 
                                                                </a>
                                                            </li> 
                                                            <li>
                                                                <a class="return_product" title=""   href="<?php echo $purchaseItem->id; ?>"   data-toggle="modal"  data-target="#return-product-modal"  style="color:orange" >
                                                                    <span class="glyphicon glyphicon-backward"> Return Product</span> 
                                                                </a>
                                                            </li> 
<!--                                                            <li>
                                                                <a class="" title="Edit" href="<?php echo site_url("manage-store-vendor") . '/' . $purchaseItem->id; ?>" >
                                                                    <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                </a>
                                                            </li>-->
                                                            <li>
                                                                <a disabled title="Delete" href="<?php echo site_url("delete-purchase") . '/' . $purchaseItem->id; ?>" class="danger"  onClick="return ConfirmDelete()" style="color:red"> 
                                                                    <span class="glyphicon glyphicon-remove"></span> Delete
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                 <a title="view" style="display:inline-block"    id="<?php echo $purchaseItem->id; ?>" class="pull-right purchase_detail btn btn-sm btn-default" ><i class="fa fa-search-plus"> View</i></a>
                                                 
                                            </td>
                                            
                                        </tr>
                                <?php } ?>
                                </tbody>
                            </table>  

                        </div>
                        <?php                         
                        
                        $this->load->view('store/purchase/purchase-detail', true);
                        $this->load->view('store/purchase/payment-purchase-form', true);
                        $this->load->view('store/purchase/payment-detail', true);
                        $this->load->view('store/purchase/receive-product-modal', true);
                        $this->load->view('store/purchase/return-product-modal', true);
                        
                        ?>
                    </div>

                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->        
    </body>
</html>