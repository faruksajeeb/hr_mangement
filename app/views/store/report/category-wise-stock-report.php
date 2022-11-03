<br/>
<?php
$dataCount = count($all_stock);
if ($dataCount > 0) {
    ?>
   <a class="btn btn-default pull-right " id="printButton" href="#" onclick="PrintDiv();"><span class="glyphicon glyphicon-print"> Print</span></a>
                           
<div id="report">
    <table cellspacing="0" width="100%" border="1" >
        <thead>
            <tr class="heading">
                <th style="width: 20px;">Sl.</th>
                <th>Item Name</th>
                <th>Category</th>
                <th>Opening Stock</th>
                <th>Total Purchase</th>
                <th>Total  Return</th>
                <th>Total Issue</th>
                <th>Total Issue Return</th>
                <th>Closing Stock</th>
                <th>Status</th>
            </tr>
        </thead>



        <tbody>
            <?php
            $slNo = 1;

            foreach ($all_stock as $item) {
                ?>
                <tr>
                    <td><?php echo $slNo++; ?></td>
                    <td><?php echo $item->item_name; ?></td>
                    <td><?php echo $item->category_name; ?></td>
                    <td style="text-align: center">
                        <?php echo $item->initial_qty . " <small style='font-style:italic'>" . $item->short_name . "</small>"; ?>
                    </td>
                    <td><?php echo $item->total_purchase; ?></td>
                    <td><?php echo $item->total_purchase_return; ?></td>
                    <td><?php echo $item->total_delivered; ?></td>
                    <td><?php echo $item->total_returned; ?></td>
                    <td style="text-align: center">
                        <?php echo $item->current_qty . " <small style='font-style:italic'>" . $item->short_name . "</small>"; ?>
                    </td>
                    <td style="font-style: italic">
                        <?php
                        if ($item->current_qty == 0) {
                            echo '<label class="label label-danger">Out of stock</label>';
                        } else if ($item->current_qty >= 1) {
                            echo '<label class="label label-success">Available</label>';
                        } else {
                            echo '<label class="label label-info">Invalid Stock</label>';
                        }
                        ?>
                    </td>

                </tr>
            <?php } ?>
        </tbody>
    </table>  
    <br/>
    
</div>
<?php
} else {
    ?>
<div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="alert alert-danger text-center ">
                <strong>No record found!</strong> 
            </div> 
        </div>
        <div class="col-md-3"></div>
    </div>
<?php
}
?>
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
    <span style="padding-left:8px;font-family:Verdana, Geneva, sans-serif">Category Wise Stock  Report <br><?php print $nowbigmonth; ?></span>' +
                '</div>\n\
    </div><br>';
        popupWin.document.write('<html><head><title>Category Wise Stock Report </title>\n\
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