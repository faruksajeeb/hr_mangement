<br/>
<?php
$dataCount = count($item_wise_purchases);
if ($dataCount > 0) {
    
    ?>
<a class="btn btn-default pull-right " id="printButton" href="#" onclick="PrintDiv();"><span class="glyphicon glyphicon-print"> Print</span></a>
                           
<div id="report">
<table cellspacing="0" width="100%" >
    <tr style="text-align: left">
                <th style="text-align: left" style="width:25%">Item/ Product Name : <?php echo  $item_name; ?></th>
                <th style="text-align: left" style="width:25%"></th>
                <th style="text-align: right" style="width:25%"></th>
                <th style="text-align: left" style="width:25%"><?php //echo $employee_company; ?></th>
            </tr>
   
</table>

    <table cellspacing="0" width="100%" border="1">
        <thead>
            
            <tr class="heading">
                <th style="width: 20px;">Sl.</th>
                <th>Purchase Date</th>
                <th>Supplier Name</th>
                <th>Received Qty</th>
                <th>Return Qty</th>
            </tr>
        </thead>



        <tbody>
            <?php
            $slNo = 1;
            
            foreach ($item_wise_purchases as $item) {
                ?>
                <tr>
                    <td><?php echo $slNo++; ?></td>
                    <td><?php echo $item->purchase_date; ?></td>
                    <td><?php echo $item->supplier_name; ?></td>
                    <td><?php echo $item->received_qty." <em style='font-size:8px;'>".$item->measurmentShortName ."</em>";; ?></td>
                    <td><?php echo $item->returned_qty." <em style='font-size:8px;'>".$item->measurmentShortName ."</em>";; ?></td>
                </tr>
            <?php 
            $recTotal +=  $item->received_qty;
            $retTotal +=  $item->returned_qty;
            } 
            ?>
                <tr>
                    <th colspan="3" style="text-align: right"> Total: </th>
                    <th><?php echo $recTotal; ?></th>
                    <th><?php echo $retTotal; ?></th>
                </tr>
        </tbody>
    </table>  
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
    <span style="padding-left:8px;font-family:Verdana, Geneva, sans-serif">Item Wise Item Purchase  Report <br><?php print $nowbigmonth; ?></span>' +
                '</div>\n\
    </div><br>';
        popupWin.document.write('<html><head><title>Item Wise Item Purchase Report </title>\n\
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