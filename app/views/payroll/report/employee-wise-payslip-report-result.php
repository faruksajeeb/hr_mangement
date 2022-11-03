<?php
$slNo = 1;
if ($paySlips) {
    ?>
    <div class="row">
        <div class="col-md-4" style="font-weight:bold; font-size: 20px;"> Employee Name: <?php echo $employeInfo->emp_name; ?></div>
        <div class="col-md-4"></div>
        <div class="col-md-4"  style="text-align:right">Year: <?php echo $year ?></div>
    </div>
    <div class="row">
        <div class="col-md-4" style="font-weight:bold;">EMployee ID: <?php echo $employeInfo->emp_id ?></div>
        <div class="col-md-4"></div>
        <div class="col-md-4" style="text-align:right"></div>
    </div>
    <table style="width:100%"  id="example">
        <tr>
            <th>Sl no</th>
            <th>Month Name</th>
            <th>Company</th>
            <th>Division</th>
            <th style="width:170px;text-align: center">From-To</th>                                        
            <th>Gross Salary</th>
            <th>Earnings</th>
            <th>Deductions</th>
            <th>Absent Day</th>
            <th>Late Day</th>
            <th>Early Day</th>
            <th>Net Payment</th>
            <th>Paid Amount</th>
            <th>Due Amount</th>
            <th>Remarks</th>
            <th>Checked</th>
            <th>Approved</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        foreach ($paySlips as $paySlip) {
            ?>
            <tr>                                    
                <td><?php echo $slNo++; ?></td>

                <td style="width:170px;font-weight:bold">
                    <?php
                    echo $paySlip->month_name . "' " . $paySlip->year;
//                                                    echo $paySlip->emp_name . "<br/><span style='color:#696969;font-size:10px;font-style:italic'>" . $paySlip->designation_name
//                                                    . "</span><br/><span style='color:#8B4513;font-size:10px;'>" . $paySlip->emp_id . "</span>";
                    ?>
                </td>
                <td><?php echo $paySlip->company_name; ?></td>
                <td><?php echo $paySlip->division_name; ?></td>
                <td style="text-align: center"><?php echo "(" . $paySlip->pay_from . ")-(" . $paySlip->pay_to . ")"; ?></td>                                            
                <td style="text-align:right">
                    <?php $grossSalary = $paySlip->gross_salary;
                    echo number_format($grossSalary); ?>
                </td>
                <td style="width:150px;height:30px;vertical-align: top">


                    <div class="accordion" id="accordionExample">

                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h5 class="mb-0">
                                    <button style="font-style:italic; text-decoration: underline;  color:green;" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target=".collapseOne<?php echo $slNo; ?>" aria-expanded="false" aria-controls="collapseOne">
                                        Earnings 
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseOne<?php echo $slNo; ?>" class="collapse collapseOne<?php echo $slNo; ?>" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                    <?php
//                                                                        $data['paySlip'] = $paySlip;
//                                                                        $this->load->view('payroll/earnings',$data);
                                    include(APPPATH . 'views/payroll/earnings.php');
                                    ?>  
                                </div>
                            </div>
                        </div>

                    </div>

                </td >

                <td style="width:150px;height:30px;vertical-align: top"><div class="accordion" id="accordionExample">

                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h5 class="mb-0">
                                    <button  style="font-style:italic; text-decoration: underline; color:red;" class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target=".collapseOne<?php echo $slNo; ?>" aria-expanded="false" aria-controls="collapseTwo">
                                        Deductions 
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseOne<?php echo $slNo; ?>" class="collapse collapseOne<?php echo $slNo; ?>" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                    <?php
//                                                                        $data['paySlip'] = $paySlip;
//                                                                        $this->load->view('payroll/deductions',$data);
                                    include(APPPATH . 'views/payroll/deductions.php');
                                    ?>   
                                </div>
                            </div>
                        </div>

                    </div>

                </td>
                <td style="text-align:right"><?php echo $paySlip->absent_day; ?></td>
                <td style="text-align:right"><?php echo $paySlip->late_day; ?></td>
                <td style="text-align:right"><?php echo $paySlip->early_day; ?></td>
                <td style="text-align:right"><?php echo number_format($paySlip->net_salary); ?></td>
                <td style="text-align:right; font-style: italic;font-size:5px; font-weight: bold"><a class="payment_detail"  id="<?php echo $paySlip->id ?>"><?php echo number_format($paySlip->total_paid); ?></a></td>
                <td style="text-align:right">
                    <?php
                    $netPayment = $paySlip->net_salary;
                    $paidAmount = $paySlip->total_paid;
                    $dueAmount = $netPayment - $paidAmount;
                    echo number_format($dueAmount);
                    ?>
                </td>
                <td><?php echo $paySlip->remarks; ?></td>
                <td style="text-align:center">
                    <?php
                    if ($paySlip->checked == 1) {
                        echo '<i class="fa fa-check-circle" style="color:green"></i><br/><span style="font-size:10px;font-style:italic">' . $paySlip->checked_date . "</span>";
                    }
                    ?>
                </td>
                <td style="text-align:center">
                    <?php
                    if ($paySlip->approved == 1) {
                        echo '<i class="fa fa-check-circle" style="color:green"></i><br/><span style="font-size:10px;font-style:italic">' . $paySlip->approved_date . "</span>";
                    }
                    ?>
                </td>
                <td style="font-style:italic">
                    <?php
                    if ($paySlip->status == 1) {
                        echo '<span class="label label-danger">Due</span>';
                    } else if ($paySlip->status == 2) {
                        echo '<span class="label label-warning">Partly paid</span>';
                    } else if ($paySlip->status == 3) {
                        echo '<span class="label label-success">Paid</span>';
                    }
                    ?> 
                </td>
                <td style="width:150px;">
                    <a href="<?php echo base_url(); ?>pay-slip/<?php echo $paySlip->id; ?>" class=" btn btn-xs btn-warning" target="_blank">Payslip <i class="fas fa-file"></i></a>
                    <a title="view"    id="<?php echo $paySlip->id; ?>" class="payslip_detail  btn btn-xs btn-default" ><i class="fas fa-search-plus"></i></a>


                </td>
            </tr>
            <?php
            $totalGrandEarning += $totalEarning;
            $totalGrandDeduction += $totalDeduct;
            $totalGross += $grossSalary;
            $totalNetPayment += $netPayment;
            $totalPaidAmount += $paidAmount;
            $totalDueAmount += $dueAmount;
        }
        ?>
        <tr style="font-weight: bold; text-align: right;">
            <td colspan="5">TOTAL</td>
            <td style="text-align:right"><?php echo number_format($totalGross); ?></td>
            <td style="text-align:center"><?php echo number_format($totalGrandEarning); ?></td>
            <td style="text-align:center"><?php echo number_format($totalGrandDeduction); ?></td>
            <td colspan="3"></td>
            <td style="text-align:right"><?php echo number_format($totalNetPayment); ?></td>
            <td style="text-align:right"><?php echo number_format($totalPaidAmount); ?></td>
            <td style="text-align:right"><?php echo number_format($totalDueAmount); ?></td>

            <td colspan="5"></td>
        </tr>
    </table><br/>

    <?php
//    $this->load->view('payroll/payment-detail', true);
//    $this->load->view('payroll/payslip-detail', true);
} else {
    ?>
    <br/>
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
    $(function(){
         var dialog, form;
                dialog = $("#payment-detail").dialog({
                    autoOpen: false,
                    height: "auto",
                    width: "600",
                    modal: false,
                    dialogClass: 'dialogWithDropShadow',
                    position: {
                        my: "center",
                        at: "center",
                    },
                    Cancel: function () {
                        dialog.dialog("close");
                    },
                });
                var payslipDialog = $("#payslip-detail").dialog({
                    autoOpen: false,
                    height: "auto",
                    width: "700",
                    modal: false,
                    dialogClass: 'dialogWithDropShadow',
                    position: {
                        my: "center",
                        at: "center",
                    },
                    Cancel: function () {
                        payslipDialog.dialog("close");
                    },
                });
                $('.payment_detail').click(function () {
                    //	alert(0);
                    var payslip_id = $(this).attr('id');
//                     alert(payslip_id);
                    // dialog.dialog( "open" );
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>payroll/getPaymentDetailByPaySlipId",
                        data: {payslip_id: payslip_id},
                        dataType: "html",
                        cache: false,
                        
                        success: function (data) {
                            // alert(data);
                            $("#payment-detail").html(data);
                            dialog.dialog("open");

                        }, error: function () {
                            alert('ERROR!');
                        }
                    });
                });
                // 
                 $('.payslip_detail').click(function () {
                    //	alert(0);
                    var payslip_id = $(this).attr('id');
//                     alert(payslip_id);
                    // dialog.dialog( "open" );
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>payroll/getPayslipDetailByPaySlipId",
                        data: {payslip_id: payslip_id},
                        dataType: "html",
                        cache: false,
                        
                        success: function (data) {
                            // alert(data);
                            $("#payslip-detail").html(data);
                            payslipDialog.dialog("open");

                        }, error: function () {
                            alert('ERROR!');
                        }
                    });
                });
    });
      
    </script>