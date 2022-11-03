<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS | Manage Item Issued</title>
        <?php
        $this->load->view('includes/cssjs');
        ?> 

        <script>
            $(document).ready(function () {
                
                $('.delivered_sales').click(function () {                    //	alert(0);
                    var salesId = $(this).attr('href');
                     //alert(purchaseId);                     
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>SalesController/getSalesOrderDetailById",
                        data: {sales_id: salesId},
                        dataType: "html",
                        cache: false,
                        success: function (data) {
                            // alert(data);
                            $("#delivered-sales-modal .modal-body").html(data)
                            $("#delivered-sales-modal").modal(show);
                        }, error: function () {
                            alert('ERROR!');
                        }
                    });
                });
                $('.returned_sales').click(function () {                    //	alert(0);
                    var salesId = $(this).attr('href');
                     //alert(purchaseId);                     
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>SalesController/returnSalesItemById",
                        data: {sales_id: salesId},
                        dataType: "html",
                        cache: false,
                        success: function (data) {
                            // alert(data);
                            $("#return-sales-modal .modal-body").html(data)
                            $("#return-sales-modal").modal(show);
                        }, error: function () {
                            alert('ERROR!');
                        }
                    });
                });
                var salesDialog = $("#sales-detail").dialog({
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
                        salesDialog.dialog("close");
                    },
                });
                $('.sales_detail').click(function () {
                    //	alert(0);
                    var salesId = $(this).attr('id');
//                     alert(salesId);

                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>SalesController/getSalesDetailById",
                        data: {sales_id: salesId},
                        dataType: "html",
                        cache: false,
                        success: function (data) {
                            // alert(data);
                            $("#sales-detail").html(data);
                            salesDialog.dialog("open");

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
                    <h4>Manage   Item Issued </h4>         
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
                                        <th>Issued ID</th>
                                        <th>Issue Date</th>
                                        <!--<th>Delivered Date</th>-->
                                        <th>Consumer Name</th>
                                        <th>Qty</th>
                                        <!--<th>Received By</th>-->
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th style="width: 20px;">Sl.</th>                                        
                                        <th>Issued ID</th>
                                        <th>Issue Date</th>
                                        <!--<th>Delivered Date</th>-->
                                        <th>Consumer Name</th>
                                        <th>Qty</th>
                                        <!--<th>Received By</th>-->
                                        <th style="text-align:center !important">Status</th>
                                         <th>Action</th>
                                    </tr>
                                </tfoot>

                                <tbody>
                                <?php
                                $slNo = 1;
                                
                                foreach ($salesItems AS $salesItem) {
                                    ?>
                                        <tr>
                                            <td><?php echo $slNo++; ?></td>
                                            
                                            <td><?php echo "#".str_pad($salesItem->id, 11, '00000000000', STR_PAD_LEFT); ?></td>
                                            <td><?php echo $salesItem->sales_date; ?></td>                                            
                                            <!--<td><?php echo $salesItem->delivery_date; ?></td>-->                                            
                                            <td><?php echo $salesItem->consumer_name; ?></td>                                            
                                            <td style="font-style:italic"><?php echo "Order Qty: ".$salesItem->total_order_qty.
                                                    "<br/>Delivered Qty: ".$salesItem->total_delivered_qty.
                                                    "<br/>Returned Qty: ".$salesItem->total_returned_qty; ?></td> 
                                            <!--<td><?php echo $salesItem->received_by; ?></td>--> 
                                            <td style="text-align:center">
                                                <?php
                                                if($salesItem->status ==-1){
                                                    echo '<label class="label label-danger">Canceled</label>';
                                                }else if($salesItem->total_delivered_qty==0){
                                                    echo '<label class="label label-warning">Pending Order</label>';
                                                }else if($salesItem->total_delivered_qty==$salesItem->total_order_qty){
                                                    echo '<label class="label label-success">Delivered</label>';
                                                }else if($salesItem->total_delivered_qty<$salesItem->total_order_qty){
                                                    echo '<label class="label label-info">Pertial Delivered</label>';
                                                }
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
                                                                 <a href="<?php echo base_url(); ?>sales-invoice/<?php echo $salesItem->id; ?>" target="_blank" class="">
                                                                    <span class="glyphicon glyphicon-print"> Print</span> 
                                                                </a>
                                                            </li> 
                                                            <li>
                                                                <a class="" title="" href="#" style="color:blue">
                                                                    <span class="glyphicon glyphicon-envelope"> Email Invoice</span> 
                                                                </a>
                                                            </li>
                                                            <?php if($salesItem->status ==-1){?>
                                                                <li>
                                                                 <a href="<?php echo base_url(); ?>restore-cancel-sales/<?php echo $salesItem->id; ?>"  class="">
                                                                    <span class="glyphicon glyphicon-refresh"> Restore </span> 
                                                                </a>
                                                                </li>
                                                            <?php }else{?>
                                                            <li>
                                                                 <a href="<?php echo $salesItem->id; ?>"  class="delivered_sales"   data-toggle="modal"  data-target="#delivered-sales-modal" >
                                                                    <span class="glyphicon glyphicon-saved"> Delivered</span> 
                                                                </a>
                                                            </li>
                                                            <li>
                                                                 <a href="<?php echo $salesItem->id; ?>"  class="returned_sales"   data-toggle="modal"  data-target="#return-sales-modal" >
                                                                    <span class="glyphicon glyphicon-refresh"> Return Item</span> 
                                                                </a>
                                                            </li>
                                                            <?php
                                                            if($salesItem->total_delivered_qty==0){
                                                            ?>
                                                            <li>
                                                                 <a href="<?php echo base_url(); ?>cancel-sales/<?php echo $salesItem->id; ?>"  class="">
                                                                    <span class="glyphicon glyphicon-remove-circle"> Cancel</span> 
                                                                </a>
                                                            </li>
                                                            <?php }} ?>
                                                            <li>
                                                                <a disabled title="Delete" href="<?php echo site_url("delete-sales") . '/' . $salesItem->id; ?>" class="danger"  onClick="return ConfirmDelete()" style="color:red"> 
                                                                    <span class="glyphicon glyphicon-remove"></span> Delete
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                 <a title="view" style="display:inline-block"    id="<?php echo $salesItem->id; ?>" class=" sales_detail btn btn-sm btn-default" ><i class="fa fa-search-plus"> View</i></a>
                                                 
                                            </td>
                                            
                                        </tr>
                                <?php } ?>
                                </tbody>
                            </table>  

                        </div>
                        <?php                         
                        
                        $this->load->view('store/sales/sales-detail', true);
                        $this->load->view('store/sales/delivered-sales-modal', true);
                        $this->load->view('store/sales/return-sales-modal', true);
                        
                        ?>
                    </div>

                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->  
       
    </body>
</html>