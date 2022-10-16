  <?php if ($loans) { ?>
                        <br/>
                        <scrit>
                            <script>
            $(document).ready(function () {
               
                $('.loan_disbursement').click(function () {
                    //	alert(0);
                    var loan_id = $(this).attr('id');
                     //alert(loan_id);
                    // dialog.dialog( "open" );
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>loan/getLoanDisbursmentDataByLoanId",
                        data: {loan_id: loan_id},
                        dataType: "html",
                        cache: false,
                        success: function (data) {
                            // alert(data);
                            $("#disbursement-form").html(data);
                            $("#disbursement-form").dialog("open");

                        }, error: function () {
                            alert('ERROR!');
                        }
                    });
                });
                });
                        </script>
                        <div class="row" id=''>
                            <div class="col-md-1"></div>
                            <div class="col-md-10" style="border:1px solid #ccc; padding: 5px;">

                                <table style="width:100%;">
                                    <tr>
                                        <th>SL No.</th>
                                        <th>Loan ID</th>
                                        <th>Given Date</th>
                                        <th>Loan Type</th>
                                        <th>Amount</th>
                                        <th>Interest(%)</th>
                                        <th>Penalty(%)</th>
                                        <th>Installment</th>
                                        <th>Paid Installment</th>
                                        <th>Balance</th>
                                        <th>Remarks</th>
                                        <!--<th>Action</th>-->
                                    </tr>

                                        <?php
                                        $sl_no = 1;
                                        foreach ($loans as $loan) {
                                       ?>

                                        <tr>
                                            <td><?php echo $sl_no++; ?></td>
                                            <td><a class="loan_disbursement"  id="<?php echo $loan->id ?>"><?php echo '#00' . $loan->id ?></a></td>
                                            <td><?php echo $loan->trans_date; ?></td>
                                            <td><?php echo $loan->loan_type_name; ?></td>
                                            <td><?php echo $loan->amount; ?></td>
                                            <td><?php echo $loan->interest; ?></td>
                                            <td><?php echo $loan->penalty; ?></td>
                                            <td><?php echo $loan->installment; ?></td>
                                            <td><?php echo $loan->paid_installment; ?></td>
                                            <td><?php echo $loan->balance; ?></td>
                                            <td><?php
                                                if ($loan->balance > 0) {
                                                    echo 'due';
                                                } else {
                                                    echo 'paid';
                                                }
                                                ?></td>
<!--                                            <td>
                                                <a href="">Disbursement</a>
                                            </td>-->
                                        </tr>

                                    <?php } ?>


                                </table>

                            </div>
                            <div class="col-md-1"></div>
                        </div>
                       
                        	
<?php } ?>   