<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS | Return Items</title>
        <?php
        $this->load->view('includes/cssjs');
        ?> 

        <script>
            $(document).ready(function () {
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
                     // alert(salesId);

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
                    <h4>Return Issued  Items </h4>         
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
                                       
                                        <th>Return ID</th>
                                        <th>Issued ID</th>
                                        <th>Issued Date</th>
                                        <th>Return Date</th>
                                        <th>Consumer Name</th>
                                        <th>Item Name</th>
                                        <th>Return Qty.</th>
                                        <th>Return By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th style="width: 20px;">Sl.</th>                                        
                                        <th>Return ID</th>
                                        <th>Issued ID</th>
                                        <th>Issued Date</th>
                                        <th>Return Date</th>
                                        <th>Consumer Name</th>
                                        <th>Item Name</th>
                                        <th>Return Qty.</th>
                                        <th>Return By</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>

                                <tbody>
                                <?php
                                $slNo = 1;
                                
                                foreach ($returnItems AS $returnItem) {
                                    ?>
                                        <tr>
                                            <td><?php echo $slNo++; ?></td>
                                            <td><?php echo "#".str_pad($returnItem->return_id, 11, '00000000000', STR_PAD_LEFT); ?></td>
                                            
                                            <td>
                                                <a title="view" style="display:inline-block"    id="<?php echo $returnItem->sales_id; ?>" class=" sales_detail" >
                                                 <?php echo "#".str_pad($returnItem->sales_id, 11, '00000000000', STR_PAD_LEFT); ?>
                                                </a>
                                               
                                            </td>
                                            <td><?php echo $returnItem->sales_date; ?></td>                                            
                                            <td><?php echo $returnItem->return_date; ?></td>                                            
                                            <td><?php echo $returnItem->consumer_name; ?></td>                                            
                                            <td><?php echo $returnItem->item_name; ?></td>                                            
                                            <td style="text-align:center"><?php echo $returnItem->returned_qty. " <small>".$returnItem->short_name."</small>"; ?></td>                                            
                                            <td><?php echo $returnItem->returned_by; ?></td>
                                            <td>
                                                <a title="Delete"  onclick="return ConfirmDelete()"   href="<?php echo site_url("delete-returned-product") . '/' . $returnItem->id. '/' . $returnItem->sales_detail_id. '/' . $returnItem->item_id. '/' . $returnItem->returned_qty; ?>" style="display:inline-block" class="btn btn-sm btn-danger" ><i class="fa fa-times-circle"> </i></a>                                                
                                           
                                            </td>
                                          
                                            
                                            
                                        </tr>
                                <?php } ?>
                                </tbody>
                            </table>  

                        </div>
                        <?php                         
                        
                        $this->load->view('store/sales/sales-detail', true);
                        
                        ?>
                    </div>

                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->  
       
    </body>
</html>