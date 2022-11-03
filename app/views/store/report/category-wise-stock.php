
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS | Category Wise Stock</title>
        <?php
        $this->load->view('includes/cssjs');
        ?> 

        <script>
            $(document).ready(function () {
                 $('#category_id').change(function(){
         
                        var categoryId=$(this).val();  
                        //alert(0);
                          //show the loading div here
                           $('.display_report').hide("fade","fast");
                           $("#loader").show("fade","fast");
                           
                          
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>StoreReportController/categoryWiseStockReport",
                            data:{ 
                                category_id:categoryId,
                            },            
                            dataType: 'html', // what to expect back from the server
                            
                            success: function (data) {
                                //then close the window 
                                        // alert(data);
                                $("#loader").hide("fade","fast");
                                 
                                 $('.display_report').show("fade","slow");
                                $('.display_report').html(data);

                            }
                        });
//                        return false; 
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
            th, td {
                padding: 10px;
                text-align: center;
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
                    <h4> Category Wise Stock</h4>         
                </div>
                <br/>
                <div class="wrapper">
                    <div class="row">
                        <div class="col-md-2 col-xs-12 display-list"></div>
                        <div class="col-md-8 col-xs-12 display-list">
                            <div class="row" style="border-bottom:1px solid #CCC;">
                                <div class="col-md-12">
                                    <form  class="myForm" id="myForm"  name="myForm">
                                        <div class="col-md-4">Item Category : </div>
                                        <div class="col-md-8">
                                            <select id="category_id" name="category_id">
                                            <option value="">--select category--</option>
                                            <?php
                                            foreach($active_categories as $category){
                                            ?>
                                            <option value="<?php echo $category->id; ?>"><?php echo $category->category_name; ?></option>
                                            <?php }?>
                                        </select>
                                        </div>                                      
                                        
                                    </form>
                                </div>
                            </div>
                            <div id="loader" style="text-align:center; display:none;">
                                 <div>Please be patient, report is being processed.</div>
                                  <img src="<?php echo base_url()?>resources/images/200.gif" alt="Loading..."/>
                                 <!-- Start Report -->
                            </div>
                             <div class="display_report">
                               
                            
                            <!-- End Report -->
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-12 display-list"></div>
                    </div>

                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->        
    </body>
</html>