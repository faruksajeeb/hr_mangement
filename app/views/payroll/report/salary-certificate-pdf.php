<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Salary Certificate | <?php echo $employeeInfo->emp_name; ?></title>

        <style>
           
            .wrapper{
                padding:100px 50px 50px 50px;
            }
            td,th{
                border:1px solid #000;
                padding: 3px;
            }
        </style>
        <style  type="text/css" media="print">
            @page 
            {
                size: auto;  
            }
            body 
            {
                font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; 
                color: #000;
            }
           
        </style>
    </head>
    <body class="logged-in dashboard current-page print-attendance">
        <!-- Page Content -->  
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php
                ?>

                <div class="wrapper">
                   
                    <div class="row" style="text-align: right">                        
                        <div class="col-md-12">
                            Date: 
                                <?php 
                                $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
                                $current_date = $dt->format('d/m/Y');
                                echo $current_date; 
                                ?>
                        </div>
                    </div>
                    <div class="row" style="font-style: italic;">
                        <div class="col-md-12">                      
                            <h1 style="text-align:center;font-size: 25px;margin:50px; ">TO WHOM IT MAY CONCERN</h1> 
                            <p style="text-align:justify"> 
                                This is to certify that <span style="font-weight:bold;"><?php echo $employeeInfo->emp_name; ?></span> has been working
                                from <?php echo date("j M, Y", strtotime($employeeInfo->joining_date)); ?> with 
                                <span style="font-weight:bold;"><?php echo $employeeInfo->company_name; ?></span> a sister concern of IIDFC, as 
                                <span style="font-weight:bold;"><?php echo $employeeInfo->designation_name; ?></span> his gross remuneration/ salary for 
                                the period from <?php echo date("j M, Y", strtotime($salaryStartFrom));?> to <?php echo date("j M, Y", strtotime($salaryEndTo));?> is as follows.
                            </p>
                            <?php
//                            echo "<pre>";
//                            print_r($payslip_info);
//                            echo "</pre>";
                            ?>
                            <table width="100%" cellspacing="0" >
                                <tr>
                                    <th>Description</th>
                                    <th style="width:150px;">Amount</th>
                                </tr>
                                <tr>
                                    <td>Basic Salary</td>
                                    <td style="text-align:right">
                                        <?php 
                                            $totalBasicSalary = $payslip_info->total_basic; 
                                            if(!$totalBasicSalary){ 
                                                      $totalBasicSalary = 0;                                         
                                            }
                                            echo $totalBasicSalary;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>House Rent</td>
                                    <td style="text-align:right">
                                        <?php 
                                            $totalHouseRent = $payslip_info->total_hra; 
                                            if(!$totalHouseRent){ 
                                                      $totalHouseRent = 0;                                         
                                            }
                                        echo  $totalHouseRent;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Transport Allowance</td>
                                    <td style="text-align:right">
                                        <?php 
                                            $totalTransportAllow = $payslip_info->total_ta; 
                                            if(!$totalTransportAllow){ 
                                                      $totalTransportAllow = 0;                                         
                                            }
                                        echo  $totalTransportAllow;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Medical Allowance</td>
                                    <td style="text-align:right">
                                        <?php 
                                            $totalMedicalAllow = $payslip_info->total_ma; 
                                            if(!$totalMedicalAllow){ 
                                                      $totalMedicalAllow = 0;                                         
                                            }
                                        echo  $totalMedicalAllow;
                                        ?>
                                    </td>
                                </tr>                               
                                <tr>
                                    <td>Festival Bonus</td>
                                    <td style="text-align:right">
                                         <?php 
                                            $totalFestivalBonus = $payslip_info->total_festival_bonus; 
                                            if(!$totalFestivalBonus){ 
                                                      $totalFestivalBonus = 0;                                         
                                            }
                                        echo  $totalFestivalBonus;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold">Total</td>
                                    <td style="text-align:right">
                                        <?php 
                                        $grandTotal = $totalBasicSalary + $totalHouseRent + $totalTransportAllow + $totalMedicalAllow + $totalFestivalBonus ;
                                        echo $grandTotal; 
                                        ?>
                                    </td>
                                </tr>
                            </table><br/>
                            <table width="100%" cellspacing="0" >
                                <tr>
                                    <td>Tax Deducted Source(TDS)</td>
                                    <td style="text-align:right;width:150px;">
                                        <?php 
                                        $totalTax = $payslip_info->total_tax; 
                                            if(!$totalTax){ 
                                                      $totalTax = 0;                                         
                                            }
                                        echo  $totalTax;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Provident Fund(P.F)</td>
                                    <td style="text-align:right">
                                        <?php 
                                        $totalProvidentFund = $payslip_info->pf; 
                                            if(!$totalProvidentFund){ 
                                                      $totalProvidentFund = 0;                                         
                                            }
                                        echo  $totalProvidentFund;
                                        ?>
                                    </td>
                                </tr>
                            </table>
                            <p style="text-align:justify">
                                In this aforesaid period the company has paid to him for the amount of total tk. <?php echo $grandTotal."/="; ?> as his 
                                remuneration/ salary with festival bonus and deducted tk. <?php echo $totalTax+$totalProvidentFund."/="; ?> as his AIT/ TDS vide the attached Challan and PF Information..
                            </p>
                            <h3>Challan Information:</h3>
                          
                            <table width="100%" cellspacing="0" style="font-size:10px;">
                                <tr>
                                    <th style="width:50px;">Sl No</th>
                                    <th style="text-align:center">Challan No.</th>
                                    <th style="text-align:center">Challan Date</th>
                                    <th style="text-align:center">Description</th>
                                    <th style="text-align:right">Amount</th>
                                </tr>
                                <?php $slNo=1; foreach($challan_info as $singleChallan){?>
                                <tr>
                                    <td><?php echo $slNo++; ?></td>
                                    <td style="text-align:center"><?php echo $singleChallan->challan_no; ?></td>
                                    <td style="text-align:center"><?php echo $singleChallan->challan_date; ?></td>
                                    <td style="text-align:center"><?php echo $singleChallan->month_name."' ".$singleChallan->year; ?></td>
                                    <td style="text-align:right"><?php echo number_format($singleChallan->amount,2); ?></td>
                                </tr>
                                <?php 
                                $total += $singleChallan->amount;
                                }?>
                                <tr>
                                    <td colspan="4" style="font-weight:bold;">Total</td>
                                    <td colspan="" style="text-align:right"><?php echo number_format($total,2); ?></td>
                                </tr>
                            </table>
                            <p>For, IIDFC</p><br/>
                            <p>Authorized Signature <br/></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            
                        </div>
                        
                    </div>
             
                </div>              
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->        
</body>
</html>