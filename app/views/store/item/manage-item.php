<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS | Store Item</title>
        <?php
        $this->load->view('includes/cssjs');
        ?> 
                <!-- XEditable -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>plugins/xeditable/bootstrap-editable.css">
       
        <script>
            $(document).ready(function () {
                // Setup - add a text input to each footer cell
                $('#example tfoot th').each(function () {
                    var title = $('#example thead th').eq($(this).index()).text();
                    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
                });
               $('.edit_data').editable({
                    validate: function (value) {
                        if ($.trim(value) == '')
                            return 'This field is required';
                    }
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
                if (document.myForm.item_name.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.myForm.item_name.focus();
                        document.myForm.item_name.style.border = "solid 1px red";
                        msg += "<li>You need to fill the item name field!</li>";
                        valid = false;
                        // return false;
                    }
                }
                if (document.myForm.category_id.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.myForm.category_id.focus();
                        document.myForm.category_id.style.border = "solid 1px red";
                        msg += "<li>You need to select the category name field!</li>";
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
              .editable-container.editable-inline {
        display: inline; 
    }

    .editable-input {
        width: 50%;
    }

            .some_class{
                width: 100% !important;
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
                    <h4>Manage  Item</h4>         
                </div> 
                <div class="wrapper">
                    <div class="row">
                        <div class="col-md-3 col-xs-12 add-form">
                            <div class="row add-form-heading">
                                <div class="col-md-12 "><span class="glyphicon glyphicon-plus-sign"> </span> Add Item</div>
                            </div>
                            <form action="" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                                <div class="row success-err-sms-area">
                                    <div class="col-md-12">
                                        <input type="hidden" name="item_id" id="item_id" value="<?php print $id; ?>">
                                        <div id="errors" style="color:red">
                                            <?php
                                            $errMsg = $this->session->flashdata('errors');
                                            if ($errMsg) {
                                                echo $errMsg;
                                                $this->session->set_flashdata('errors', '');
                                            }
                                            ?>
                                        </div>
                                        <div style="color:green">
                                             <?php echo $msg; ?>
                                        </div>
                                       
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Item Name:</div>
                                        <div class="col-md-9"><input type="text" name="item_name" id="item_name" placeholder="e.g. Facial Tissue" value="<?php echo $toedit_records['item_name']; ?>"></div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Item Code:</div>
                                        <div class="col-md-9"><input type="text" name="item_code" id="item_code"  value="<?php echo $toedit_records['item_code']; ?>"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Category:</div>
                                        <div class="col-md-9">
                                            <select name="category_id" id="category_id">
                                                <option value="">--select category--</option>
                                                <?php foreach($publishCategories AS $category){?>
                                                    <option value="<?php echo $category->id;?>" <?php if($category->id==$toedit_records['category_id']){ echo 'selected';}?>>
                                                        <?php echo $category->category_name; ?>
                                                    </option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
<!--                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Brand:</div>
                                        <div class="col-md-9">
                                            <select name="brand_id" id="brand_id">
                                                <option value="">--select brand--</option>
                                                <?php foreach($publishBrands AS $brand){?>
                                                    <option value="<?php echo $brand->id;?>" <?php if($brand->id==$toedit_records['brand_id']){ echo 'selected';}?>>
                                                        <?php echo $brand->brand_name; ?>
                                                    </option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>-->
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Initial Qty:</div>
                                        <div class="col-md-9">
                                            <input type="hidden" name="initial_pre_qty" id="initial_pre_qty"  value="<?php echo $toedit_records['initial_qty']; ?>">
                                            <input type="hidden" name="current_qty" id="current_qty"  value="<?php echo $toedit_records['current_qty']; ?>">
                                            <input type="text" name="initial_qty" id="initial_qty"  value="<?php echo $toedit_records['initial_qty']; ?>">
                                        </div>
                                    </div>                                    
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Initial Price:</div>
                                        <div class="col-md-9"><input type="text" name="initial_price" id="initial_price"  value="<?php echo $toedit_records['initial_price']; ?>"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Minimum Stock:</div>
                                        <div class="col-md-9"><input type="text" name="min_stock_amt" id="min_stock_amt"  value="<?php echo $toedit_records['min_stock_amt']; ?>"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Measurement Type:</div>
                                        <div class="col-md-9">
                                            <select name="measurement_id" id="measurement_id">
                                                <option value="">--select measurement type--</option>
                                                <?php foreach($publishMeasurements AS $measurement_type){?>
                                                    <option value="<?php echo $measurement_type->id;?>" <?php if($measurement_type->id==$toedit_records['measurement_id']){ echo 'selected';}?>>
                                                        <?php echo $measurement_type->short_name; ?>
                                                    </option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Description:</div>
                                        <div class="col-md-9">
                                            <textarea name="description" id="description" rows="5"><?php echo $toedit_records['description']; ?></textarea>
                                        </div>
                                    </div>                                    
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Status:</div>
                                        <div class="col-md-9">
                                            <select name="status" id="status">
                                                <option value="0" <?php if($toedit_records['status']==0){ echo 'selected';}?>>Inactive</option>
                                                <option value="1" <?php if($toedit_records['status']==1){ echo 'selected';}?>>Active</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row top10 bottom10">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-9"><input type="submit" name="add_item" value="Submit"></div>
                                    </div>

                                </div>
                            </form>

                        </div>
                        <div class="col-md-9 col-xs-12 display-list">
                            <div class="row display-list-heading">
                                <div class="col-md-12 "><span class="glyphicon glyphicon-list"> </span> Item List</div>
                            </div>
                            <table id="example" class="display" cellspacing="0" width="100%" border="1">
                                <thead>
                                    <tr class="heading">
                                        <th style="width: 20px;">Sl.</th>
                                        <th>Item Name</th>
                                        <th>Category</th>
                                        <th>Initial Qty</th>
                                        <th>Current Qty</th>
                                        <th>Current Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                         <th>Sl. No.</th>
                                        <th>Item Name</th>
                                        <th>Category</th>
                                        <th>Initial Qty</th>
                                        <th>Current Qty</th>
                                        <th>Current Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>

                                <tbody>
                                    <?php
                                    $slNo = 1;
                                    foreach ($items as $item) {
                                        ?>
                                        <tr>
                                            <td><?php echo $slNo++; ?></td>
                                            <td><?php echo $item->item_name; ?></td>
                                            <td><?php echo $item->category_name; ?></td>
                                            <td style="text-align: right">
                                                <?php echo $item->initial_qty." <small style='font-style:italic'>".$item->measurement_name."</small>"; ?>
                                            </td>
                                            <td style="text-align: right">
                                                <?php echo $item->current_qty." <small style='font-style:italic'>".$item->measurement_name."</small>"; ?>
                                            </td>
                                            <td>
                                                 <a href="#" rel="tooltip" data-placement="top" data-inputclass="some_class"  class="edit_data" id="current_price" data-type="text"data-title="Enter current_price" data-pk="<?php echo $item->id; ?>" data-url="<?php echo base_url(); ?>StoreController/updateItemCurrentPrice/str_items" >                                         
                                     <?php echo $item->current_price; ?>
                                    </a>
                                               
                                            </td>
                                            <td style="font-style: italic">
                                                <?php
                                                if ($item->status == 1) {
                                                    echo '<label class="label label-success">Active</label>';
                                                } else {
                                                    echo '<label class="label label-danger">Inactive</label>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-xs" title="Edit" href="<?php echo site_url("manage-store-item") . '/' . $item->id; ?>" >
                                                    <span class="glyphicon glyphicon-pencil"></span> 
                                                </a>

                                                <a disabled title="Delete" href="<?php echo site_url("delete-store-item") . '/' . $item->id; ?>" class="btn btn-xs btn-danger"  onClick="return ConfirmDelete()"> 
                                                    <span class="glyphicon glyphicon-remove"></span> 
                                                </a>

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
                <!-- XEditable -->
        <script src="<?php echo site_url(); ?>plugins/xeditable/bootstrap-editable.min.js"></script>
    </body>
</html>