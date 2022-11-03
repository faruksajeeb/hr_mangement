<script>
    $(function() {

        $('.edit_data').editable({
            validate: function(value) {
                if ($.trim(value) == '')
                    return 'This field is required';
            }
        });



        $(".delete_loan_disbursment").click(function() {
            var id = $(this).attr('dis_id');
            //            alert(id);
            var x = confirm("Are you sure you want to delete?");
            if (x) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>loan/deleteLoanDisAmount",
                    data: {
                        id: id
                    },
                    dataType: "text",
                    cache: false,
                    success: function(data) {
                        alert("Successfully deleted!");
                        //$("#payRollModal").html(data);
                        $('#disbursement-form').dialog("close");
                        window.location.reload(true);

                    }
                });
            } else {
                return false;
            }


        });
    });
</script>
<div id="disbursement-form" title="Loan Disbursement" style="padding: 5px;">
    <strong>LOAN ID : #00<?php echo $loan_id; ?></strong>
    <table style="width:100%" class="table">
        <tr>
            <th style="width:150px">sl no</th>

            <th>Payment date</th>
            <th>Principal Amount</th>
            <th>Interest Amount</th>
            <th>Penalty Amount</th>
            <th>Total Payment</th>
            <!--<th>Balance</th>-->
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        $sl_no = 1;
        $disNumber = count($loanDisbursmentInfo);
        foreach ($loanDisbursmentInfo as $singleData) { ?>
            <tr>
                <td><?php echo $sl_no; ?></td>
                <td>
                    <?php if ($singleData->status != 1) { ?>
                        <a href="#" rel="tooltip" data-placement="top" data-inputclass="some_class" class="edit_data" id="payment_date" data-type="text" data-title="Change Loan Payment Date" data-pk="<?php echo $singleData->id; ?>" data-url="<?php echo base_url(); ?>loan/updateLoanPaymentDate/tbl_loan_disbursement">
                            <?php echo  $singleData->payment_date; ?>
                        </a>
                    <?php } else {
                        echo  $singleData->payment_date;
                    } ?>
                </td>
                <td><?php echo $singleData->principal_amount; ?></td>
                <td><?php echo $singleData->interest_amount; ?></td>
                <td><?php echo $singleData->penalty_amount; ?></td>

                <td>
                    <?php if ($singleData->status != 1) { ?>
                        <a href="#" rel="tooltip" data-placement="top" data-inputclass="some_class" class="edit_data" id="total_payment" data-type="text" data-title="Change Payment Amount" data-pk="<?php echo $singleData->id; ?>" data-url="<?php echo base_url(); ?>loan/updateLoanPaymentAmount/tbl_loan_disbursement">
                            <?php echo  $singleData->total_payment; ?>
                        </a>
                    <?php } else {
                        echo  $singleData->total_payment;
                    } ?>
                </td>
                <!--<td><?php // echo $singleData->balance; 
                        ?></td>-->
                <td>
                    <?php
                    echo $singleData->status == 1 ?
                        '<span class="label label-success">Paid</span>' :
                        '<span class="label label-danger">Due</span>';
                    ?>
                </td>
                <td>
                    <?php if ($sl_no > 1 && $disNumber == $sl_no && $singleData->status != 1) { ?>
                        <button dis_id="<?php echo $singleData->id; ?>" class="operation-cut operation-link delete_loan_disbursment btn-xs">
                            <span class="glyphicon glyphicon-remove" style="color:red"></span>
                        </button>
                    <?php } ?>
                </td>
            </tr>
        <?php
            $sl_no++;
            $totalPrincipalAmount += $singleData->principal_amount;
            $totalInterestAmount += $singleData->interest_amount;
            $totalPenaltyAmount += $singleData->penalty_amount;
            $totalPaymentAmount += $singleData->total_payment;
        }
        ?>
        <tr>
            <th colspan="2">TOTAL</th>
            <th><?php echo number_format($totalPrincipalAmount, 2); ?></th>
            <th><?php echo number_format($totalInterestAmount, 2); ?></th>
            <th><?php echo number_format($totalPenaltyAmount, 2); ?></th>
            <th><?php echo number_format($totalPaymentAmount, 2); ?></th>
            <!--<th>Balance</th>-->
            <th></th>
            <th></th>
        </tr>
    </table>
</div>