<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS | Manage Challan</title>
        <!--chosen--> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.css">
        <!-- XEditable -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>plugins/xeditable/bootstrap-editable.css">
        <?php
        $this->load->view('includes/cssjs');
        ?> 

        <script>
            $(document).ready(function () {



                var purchaseDialog = $("#challan-detail").dialog({
                    autoOpen: false,
                    height: "auto",
                    width: "900",
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
                $('.challan_detail').click(function () {
                    //	alert(0);
                    var challanId = $(this).attr('id');
//                     alert(purchaseId);

                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>ChallanController/getChallanDetailById",
                        data: {challan_id: challanId},
                        dataType: "html",
                        cache: false,
                        success: function (data) {
                            // alert(data);
                            $("#challan-detail").html(data);
                            purchaseDialog.dialog("open");

                        }, error: function () {
                            alert('ERROR!');
                        }
                    });
                });

                $('.chosen-container').css({'width': '350px'});
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

                $('.edit_data').editable({
                    validate: function (value) {
                        if ($.trim(value) == '')
                            return 'This field is required';
                    }
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
            .dialogWithDropShadow
            {
                -webkit-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);  
                -moz-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5); 

            }
                                    
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
                    <h4>Manage  Challan</h4>         
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
                            <a href="" class="btn btn-sm btn-success pull-right" data-toggle="modal"  data-target="#add_challan"><i class="fa fa-plus-circle"></i> Add Challan</a>
                            <table id="example" class="display" cellspacing="0" width="100%" border="1">
                                <thead>
                                    <tr class="heading">
                                        <th style="width: 20px;">Sl.</th>                                       
                                        <th>Challan No</th>
                                        <th>Challan Date</th>
                                        <th>Total Amount</th>
                                        <th>Dipositor</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th style="width: 20px;">Sl.</th>                                        
                                        <th>Challan No</th>
                                        <th>Challan Date</th>
                                        <th>Total Amount</th>
                                        <th>Dipositor</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $slNo = 1;

                                    foreach ($challan_info AS $singleChallan) {
                                        if ($this->session->userdata('user_id') == $singleChallan->created_by) {
                                            ?>
                                            <tr>
                                                <td><?php echo $slNo++; ?></td>                                            
        <!--                                            <td>
                                                <?php echo "#" . str_pad($singleChallan->id, 11, '00000000000', STR_PAD_LEFT); ?>
                                                </td>-->
                                                <td>

                                                    <a href="#" rel="tooltip" data-placement="top" data-inputclass="some_class"  class="edit_data" id="challan_no" data-type="text"data-title="Change Challan No" data-pk="<?php echo $singleChallan->id; ?>" data-url="<?php echo base_url(); ?>challanController/updateChallanData/tbl_challan" >                                         
                                                        <?php echo $singleChallan->challan_no; ?>
                                                    </a>   

                                                </td>                                            
                                                <td>
                                                    <a href="#" rel="tooltip" data-placement="top" data-inputclass="some_class"  class="edit_data" id="challan_date" data-type="text"data-title="Change Challan Date" data-pk="<?php echo $singleChallan->id; ?>" data-url="<?php echo base_url(); ?>challanController/updateChallanData/tbl_challan" >                                         
                                                        <?php echo $singleChallan->challan_date; ?>
                                                    </a>    
                                                </td>                                            
                                                <td><?php echo $singleChallan->total; ?></td> 
                                                <td>
                                                    <a href="#" rel="tooltip" data-placement="top" data-inputclass="some_class"  class="edit_data" id="dipositor" data-type="text"data-title="Change Dipositor" data-pk="<?php echo $singleChallan->id; ?>" data-url="<?php echo base_url(); ?>challanController/updateChallanData/tbl_challan" >                                         
                                                        <?php echo $singleChallan->dipositor; ?>
                                                    </a>  
                                                </td> 

                                                <td style="">                                                                                                         


                                                    <a title="view" style="display:inline-block"    id="<?php echo $singleChallan->id; ?>" class="challan_detail btn btn-sm btn-default" ><i class="fa fa-search-plus"> View</i></a>
                                                    <!--
                                                      <a disabled title="Delete" href="<?php //echo site_url("delete-challan") . '/' . $singleChallan->id;   ?>" class="danger"  disabled onClick="return ConfirmDelete()" style="color:red"> 
                                                         <span class="glyphicon glyphicon-remove"></span> Delete
                                                     </a>
                                                    -->

                                                </td>

                                            </tr>
                                        <?php }
                                    }
                                    ?>
                                </tbody>
                            </table>  

                        </div>
                        <?php
                        $this->load->view('challan/add-challan', true);
                        $this->load->view('challan/challan-detail', true);
                        ?>
                    </div>

                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->   

        <!--Chosen--> 
        <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
        <!-- XEditable -->
        <script src="<?php echo site_url(); ?>plugins/xeditable/bootstrap-editable.min.js"></script>
    </body>
</html>