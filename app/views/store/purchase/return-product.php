<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS | Return Product</title>
        <?php
        $this->load->view('includes/cssjs');
        ?> 
<script>
            $(document).ready(function () {
               
                // DataTable
                var table = $('#example').DataTable();
            });
                     function ConfirmDelete()
            {
                var x = confirm("Are you sure you want to delete?");
                if (x)
                    return true;
                else
                    return false;
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
                    <h4>Return  Product</h4>         
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
                                        <th>Return Date</th>
                                        <th>Purchase No</th>
                                        <th>Supplier Name</th>
                                        <th>Product Name</th>
                                        <th>Returned Qty</th>
                                        <th>Received By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php
                                $slNo = 1;
                                
                                foreach ($returned_products AS $returnedProduct) {
                                    ?>
                                        <tr>
                                            <td><?php echo $slNo++; ?></td>
                                            <td><?php echo $returnedProduct->return_date; ?></td>                                            
                                            <td><?php echo "Purchase-0000".$returnedProduct->purchase_id; ?></td>                                            
                                            <td><?php echo $returnedProduct->supplier_name; ?></td> 
                                            <td><?php echo $returnedProduct->item_name; ?></td> 
                                            <td><?php echo $returnedProduct->returned_qty; ?></td> 
                                            <td><?php echo $returnedProduct->returned_by_name; ?></td>                                             
                                            <td>
                                                <a title="Delete"  onclick="return ConfirmDelete()"   href="<?php echo site_url("delete-returned-product") . '/' . $returnedProduct->id. '/' . $returnedProduct->purchase_detail_id. '/' . $returnedProduct->item_id. '/' . $returnedProduct->returned_qty; ?>" style="display:inline-block" class="btn btn-sm btn-danger" ><i class="fa fa-times-circle"> </i></a>                                                
                                            </td>                                             
                                        </tr>
                                <?php } ?>
                                </tbody>
                            </table>  

                        </div>
                  
                    </div>

                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->        
    </body>
</html>