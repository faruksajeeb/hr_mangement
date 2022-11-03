<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS | Available Stock</title>
        <?php
        $this->load->view('includes/cssjs');
        ?> 

        <script>
            $(document).ready(function () {
                

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
                    <h4>Available Stock</h4>         
                </div>
                <br/>
                <div class="wrapper">
                    <div class="row">
                        <div class="col-md-2 col-xs-12 display-list"></div>
                        <div class="col-md-8 col-xs-12 display-list">
                           <?php
                           $dataCount = count($availabe_stock);
                                    if($dataCount>0){
                           ?>
                            <a class="btn btn-default pull-right " id="printButton" href="#" onclick="PrintDiv();"><span class="glyphicon glyphicon-print"> Print</span></a>
                            <br/>
                            <div id="report">
                                <table width="80%" border="1" style="margin:0 auto;">
                                <thead>
                                    <tr class="heading">
                                        <th style="width: 20px;">Sl.</th>
                                        <th>Item Name</th>
                                        <th>Opening Stock</th>
                                        <th>Closing Stock</th>
                                        <th style="text-align: right">Unit Price</th>
                                        <th style="text-align: right">Total Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                              

                                <tbody>
                                    <?php
                                    $slNo = 1;
                                    
                                    foreach ($availabe_stock as $item) {
                                        ?>
                                        <tr>
                                            <td><?php echo $slNo++; ?></td>
                                            <td style="text-align: center"><?php echo $item->item_name; ?></td>
                                            <td style="text-align: center">
                                                <?php echo $item->initial_qty." <small style='font-style:italic'>".$item->short_name."</small>"; ?>
                                            </td>
                                            <td style="text-align: center">
                                                <?php echo $item->current_qty." <small style='font-style:italic'>".$item->short_name."</small>"; ?>
                                            </td>
                                            <td style="text-align: right">
                                                <?php echo $item->current_price." tk"; ?>
                                            </td>
                                            <td  style="text-align: right">
                                                <?php 
                                                $price = $item->current_qty*$item->current_price; 
                                                echo $price." tk";
                                                ?>
                                            </td>
                                            <td style="font-style: center;text-align: center">
                                                <?php
                                                if ($item->current_qty >= 1) {
                                                    echo '<label class="label label-success"> Stock Available </label>';
                                                }
                                                ?>
                                            </td>
                                            
                                        </tr>
                                    <?php 
                                    $totalIntialQty +=$item->initial_qty;
                                    $totalCurrentQty +=$item->current_qty;
                                    $totalPrice +=$price;
                                                }?>
                                        <tr style="text-align:center; font-weight: bold;">
                                            <td colspan="2">TOTAL</td>
                                            <td><?php echo $totalIntialQty;?></td>
                                            <td><?php echo $totalCurrentQty;?></td>
                                            <td style="text-align: right"></td>
                                            <td style="text-align: right"><?php echo number_format($totalPrice)." tk";?></td>
                                            <td></td>
                                        </tr>
                                </tbody>
                            </table> 
                                <br/>
                            </div>
                            
<?php }else{
                           echo "No record found";             
                                    } ?>
                        </div>
                        <div class="col-md-2 col-xs-12 display-list"></div>
                    </div>

                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->      
        <script>

    function PrintDiv() {
        var divToPrint = document.getElementById('report');
        var popupWin = window.open('', '_blank', 'width=800,height=auto');
        popupWin.document.open();
        var a = '<div style="width="100%; margin:0 auto;display:block;">\n\
        <div style="float:left;width:43%;text-align:right;">\n\
    \n\
    </div>\n\
    <div class="" style="line-height:40px;text-align: center;font-size:20px;color:black;font-weight:bold;text-decoration:underline;"> \n\
    <span style="padding-left:8px;font-family:Verdana, Geneva, sans-serif">Available Stock  Report <br><?php print $nowbigmonth; ?></span>' +
                '</div>\n\
    </div><br>';
        popupWin.document.write('<html><head><title>Available Stock Report </title>\n\
    \n\
    \n\
    \n\
    \n\
    <style> body{ text-align:center;font-size:15px;margin:0 auto;}table{margin:0 auto;}table, th, td {padding-left:5px;padding-right:5px;font-size:10px;border: 1px solid black; border-collapse: collapse;}th{background: #DCDCDC; border-top:2px solid #000;} tr:nth-child(even) {background: #DCDCDC }tr:nth-child(odd) {background: #FFF}</style>\n\
                      \n\
    \n\
    \n\
    \n\
    \n\
    </head><body onload="window.print()">' + a + divToPrint.innerHTML + '</html>');
        popupWin.document.close();
    }
</script>
    </body>
</html>