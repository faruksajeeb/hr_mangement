<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS | Store Category</title>
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
                if (document.myForm.category_name.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.myForm.category_name.focus();
                        document.myForm.category_name.style.border = "solid 1px red";
                        msg += "<li>You need to fill the category name field!</li>";
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
                    <h4>Manage Store Category</h4>         
                </div> 
                <div class="wrapper">
                    <div class="row">
                        <div class="col-md-4 col-xs-12 add-form">
                            <div class="row add-form-heading">
                                <div class="col-md-12 "><span class="glyphicon glyphicon-plus-sign"> </span> Add Category</div>
                            </div>
                            <form action="" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                                <div class="row success-err-sms-area">
                                    <div class="col-md-12">
                                        <input type="hidden" name="category_id" id="category_id" value="<?php print $id; ?>">
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
                                        <div class="col-md-3 bgcolor_D8D8D8">Category Name:</div>
                                        <div class="col-md-9"><input type="text" name="category_name" id="category_name" placeholder="e.g. IT" value="<?php echo $toedit_records['category_name']; ?>"></div>
                                    </div>                                                                                                              
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Description:</div>
                                        <div class="col-md-9">
                                            <textarea placeholder="Optional" name="description" id="description" cols="30" rows="7"><?php echo $toedit_records['description']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Status:</div>
                                        <div class="col-md-9">
                                            <select name="status" id="status">
                                                <option value="1" <?php if($toedit_records['status']==1){ echo 'selected';}?>>Active</option>
                                                <option value="0" <?php if($toedit_records['status']==0){ echo 'selected';}?>>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row top10 bottom10">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-9"><input type="submit" name="add_category" value="Submit"></div>
                                    </div>

                                </div>
                            </form>

                        </div>
                        <div class="col-md-8 col-xs-12 display-list">
                            <div class="row display-list-heading">
                                <div class="col-md-12 "><span class="glyphicon glyphicon-list"> </span> Category List</div>
                            </div>
                            <table id="example" class="display" cellspacing="0" width="100%" border="1">
                                <thead>
                                    <tr class="heading">
                                        <th>Sl. No.</th>
                                        <th>Category Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                         <th>Sl. No.</th>
                                        <th>Category Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>

                                <tbody>
                                    <?php
                                    $slNo = 1;
                                    foreach ($categories as $category) {
                                        ?>
                                        <tr>
                                            <td><?php echo $slNo++; ?></td>
                                            <td><?php echo $category->category_name; ?></td>
                                            <td><?php echo $category->description; ?></td>
                                            <td style="font-style: italic">
                                                <?php
                                                if ($category->status == 1) {
                                                    echo '<label class="label label-success">Active</label>';
                                                } else {
                                                    echo '<label class="label label-danger">Inactive</label>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-xs" href="<?php echo site_url("manage-store-category") . '/' . $category->id; ?>" >
                                                    <span class="glyphicon glyphicon-pencil"></span> Edit
                                                </a>

                                                <a disabled href="<?php echo site_url("delete-store-category") . '/' . $category->id; ?>" class="btn btn-xs btn-danger"  onClick="return ConfirmDelete()"> 
                                                    <span class="glyphicon glyphicon-remove"></span> Delete
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
    </body>
</html>