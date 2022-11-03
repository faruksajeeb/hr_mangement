<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS | Manage Vendor</title>
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
    </head>
    <body class="logged-in dashboard current-page add-division">
        <!-- Page Content -->  
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php
                $this->load->view('includes/menu');
                ?>
                <div class="row under-header-bar text-center"> 
                    <h4>Manage  Vendor</h4>         
                </div> 
                <div class="wrapper">
                    <div class="row">
                        <div class="col-md-3 col-xs-12 add-form">
                            <div class="row add-form-heading">
                                <div class="col-md-12 "><span class="glyphicon glyphicon-plus-sign"> </span> Add Vendor</div>
                            </div>
                            <form action="" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                                <div class="row success-err-sms-area">
                                    <div class="col-md-12">
                                        <input type="hidden" name="vendor_id" id="vendor_id" value="<?php print $id; ?>">
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
                                        <div class="col-md-3 bgcolor_D8D8D8">Vendor Name:</div>
                                        <div class="col-md-9"><input type="text" name="vendor_name" id="vendor_name" placeholder="e.g. ACI" value="<?php echo $toedit_records['supplier_name']; ?>"></div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Contact Person:</div>
                                        <div class="col-md-9"><input type="text" name="contact_person" id="item_name" placeholder="e.g. Ekramul Haque" value="<?php echo $toedit_records['contact_person']; ?>"></div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Address:</div>
                                        <div class="col-md-9">
                                            <textarea name="address" id="address" rows="3"><?php echo $toedit_records['address']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Phone:</div>
                                        <div class="col-md-9"><input type="text" name="phone" id="phone" placeholder="" value="<?php echo $toedit_records['phone']; ?>"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Email:</div>
                                        <div class="col-md-9"><input type="text" name="email" id="email" placeholder="" value="<?php echo $toedit_records['email']; ?>"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Initial Balance:</div>
                                        <div class="col-md-9">
                                            <input type="hidden" name="previous_initial_balance" id="previous_initial_balance"  value="<?php echo $toedit_records['initial_balance']; ?>">
                                            <input type="hidden" name="balance" id="balance"  value="<?php echo $toedit_records['balance']; ?>">
                                            <input type="text" name="initial_balance" id="initial_balance"  value="<?php echo $toedit_records['initial_balance']; ?>">
                                        </div>
                                    </div>                                    

                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Note:</div>
                                        <div class="col-md-9">
                                            <textarea name="note" id="note" rows="3"><?php echo $toedit_records['note']; ?></textarea>
                                        </div>
                                    </div>                                    
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Status:</div>
                                        <div class="col-md-9">
                                            <select name="status" id="status">
                                                <option value="0" <?php if ($toedit_records['status'] == 0) {
                                                echo 'selected';
                                            } ?>>Inactive</option>
                                                <option value="1" <?php if ($toedit_records['status'] == 1) {
                                                echo 'selected';
                                            } ?>>Active</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row top10 bottom10">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-9"><input type="submit" name="add_vendor" value="Submit"></div>
                                    </div>

                                </div>
                            </form>

                        </div>
                        <div class="col-md-9 col-xs-12 display-list">
                            <div class="row display-list-heading">
                                <div class="col-md-12 "><span class="glyphicon glyphicon-list"> </span> Vendor List</div>
                            </div>
                            <table id="example" class="display" cellspacing="0" width="100%" border="1">
                                <thead>
                                    <tr class="heading">
                                        <th style="width: 20px;">Sl.</th>
                                        <th>Action</th>
                                        <th>Vendor Name</th>
                                        <th>Contact Person</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Balance</th>
                                        <th>Is Stock Available</th>
                                        <th>Status</th>
                                        
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th style="width: 20px;">Sl.</th>
                                        <th>Action</th>
                                        <th>Vendor Name</th>
                                        <th>Contact Person</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Balance</th>
                                        <th>Is Stock Available</th>
                                        <th>Status</th>
                                        
                                    </tr>
                                </tfoot>

                                <tbody>
                                <?php
                                $slNo = 1;
                                foreach ($vendors AS $vendor) {
                                    ?>
                                        <tr>
                                            <td><?php echo $slNo++; ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <!-- Example single danger button -->
                                                    <div class="btn-group">
                                                        <a class="btn dropdown-toggle btn-primary" data-toggle="dropdown" href="#">
                                                            Action
                                                            <span class="caret"></span>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <!-- dropdown menu links -->
                                                            <li>
                                                                <a class="" title="Create Bill/Purchase Now" href="<?php echo site_url("add-purchase") . '/' . $vendor->id; ?>" >
                                                                    <span class="glyphicon glyphicon-plus"> Purchase Now</span> 
                                                                </a>
                                                            </li> 
                                                            <li>
                                                                <a class="" title="Edit" href="<?php echo site_url("manage-store-vendor") . '/' . $vendor->id; ?>" >
                                                                    <span class="glyphicon glyphicon-pencil"></span> Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a disabled title="Delete" href="<?php echo site_url("delete-store-vendor") . '/' . $vendor->id; ?>" class=""  onClick="return ConfirmDelete()"> 
                                                                    <span class="glyphicon glyphicon-remove"></span> Delete
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo $vendor->supplier_name; ?></td>
                                            <td><?php echo $vendor->contact_person; ?></td>                                            
                                            <td><?php echo $vendor->phone; ?></td>                                            
                                            <td><?php echo $vendor->email; ?></td>                                            
                                            <td><?php echo $vendor->addres; ?></td>
                                            <td><?php echo $vendor->balance; ?></td>
                                            <td><?php echo $vendor->is_stock_available; ?></td>
                                            <td style="font-style: italic">
                                                <?php
                                                if ($vendor->status == 1) {
                                                    echo '<label class="label label-success">Active</label>';
                                                } else {
                                                    echo '<label class="label label-danger">Inactive</label>';
                                                }
                                                ?>
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