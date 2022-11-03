<br/>
<?php
$dataCount = count($employee_wise_sales);
if ($dataCount > 0) {
    ?>
<table cellspacing="0" width="100%" >
    <tr style="text-align: left">
                <th style="text-align: left">Emp ID :</th>
                <th style="text-align: left"><?php echo $employee_id; ?></th>
                <th style="text-align: right">Company : </th>
                <th style="text-align: left"><?php echo $employee_company; ?></th>
            </tr>
            <tr>
                <th style="text-align: left">Emp Name :</th>
                <th style="text-align: left"><?php echo $employee_name; ?></th>
                <th style="text-align: right">Designation : </th>
                <th style="text-align: left"><?php echo $employee_designation; ?></th>
            </tr>
</table>
    <table cellspacing="0" width="100%" border="1">
        <thead>
            
            <tr class="heading">
                <th style="width: 20px;">Sl.</th>
                <th>Issue Date</th>
                <th>Item Name</th>
                <th>Issue Qty</th>
            </tr>
        </thead>



        <tbody>
            <?php
            $slNo = 1;

            foreach ($employee_wise_sales as $item) {
                ?>
                <tr>
                    <td><?php echo $slNo++; ?></td>
                    <td><?php echo $item->delivered_date; ?></td>
                    <td><?php echo $item->item_name; ?></td>
                    <td><?php echo $item->delivered_qty; ?></td>
                    

                </tr>
            <?php } ?>
        </tbody>
    </table>  
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