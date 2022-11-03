
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS | Item Wise Purchase Report</title>
         <!--chosen--> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.css">
        <?php
        $this->load->view('includes/cssjs');
       
        ?> 

        <script>
            $(document).ready(function () {
                 $('#employee_id').change(function(){
         
                        var itemId=$(this).val();  
                        //alert(0);
                          //show the loading div here
                           $('.display_report').hide("fade","fast");
                           $("#loader").show("fade","fast");
                           
                          
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>StoreReportController/getItemWisePurchaseReport",
                            data:{ 
                                item_id:itemId,
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
                    <h4> Item Wise Purchase Report </h4>         
                </div>
                <br/>
                <div class="wrapper">
                    <div class="row">
                        <div class="col-md-2 col-xs-12 display-list"></div>
                        <div class="col-md-8 col-xs-12 display-list">
                            <div class="row" style="border-bottom:1px solid #CCC;">
                                <div class="col-md-12">
                                    <form  class="myForm" id="myForm"  name="myForm">
                                        <div class="col-md-4">Item Name : </div>
                                        <div class="col-md-8">
                                            <select id="employee_id" name="employee_id" class="  chosen-select form-control">
                                            <option value="">--select item--</option>
                                            <?php
                                            foreach($items as $item){
                                            ?>
                                            <option value="<?php echo $item->id; ?>"><?php echo $item->item_name; ?></option>
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
        <!--Chosen--> 
        <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
    </body>
</html>