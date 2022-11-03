<style>
    table{
        border-collapse: collapse;
    }
    td {
        background-color: none !important;
        
    }
</style>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true" style="color:black" class=" pull-right">&times;</span>
    </button>
    <h4 class="">View Salary Grade</h4>
</div>
<div class="modal-body">
    <h3>Grade name: <?php echo $gradeData->grade_name; ?></h3>
    <table class="table table-bordered" style="width:90%" border="1">
        <tr>
            <td>
                <table border="1">
                    <tr>
                        <th colspan="4">Earnings</th>
                    </tr>
                    <tr style="background-color: #DCDCDC;">
                        <th>Title</th>
                        <th>Amount Type</th>
                        <th></th>
                        <th>Amount/Percentage</th>
                    </tr>
                    <?php foreach ($GradeAllowanceData as $key => $val) : ?>
                        <tr>
                            <td><?php echo $val->component_name; ?></td>
                            <td><?php echo $val->amount_type; ?></td>
                            <td><?php echo $val->ref_name; ?></td>
                            <td><?php echo $val->amount_type=='fixed' ? $val->amount : $val->percentage; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
            <td>
                <table  border="1">
                    <tr>
                        <th colspan="4">Deductions</th>
                    </tr>
                    <tr style="background-color: #DCDCDC;">
                        <th>Title</th>
                        <th>Amount Type</th>
                        <th></th>
                        <th>Amount/Percentage</th>
                    </tr>
                    <?php foreach ($GradeDeductionData as $key => $val) : ?>
                        <tr>
                            <td><?php echo $val->component_name; ?></td>
                            <td><?php echo $val->amount_type; ?></td>
                            <td><?php echo $val->ref_name; ?></td>
                            <td><?php echo $val->amount_type=='fixed' ? $val->amount : $val->percentage; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    </table>
</div>
<div class="modal-footer">
<a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
</div>