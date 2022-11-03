<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Purchase Invoice</title>

        <style>
            body{
                background-color: #ffffff;
            }
            .container-fluid{
                width: 100%;
                background-color: #ffffff;
                padding: 0!important;
                margin: 0;
            }

            .under-header-bar {
                min-height: 13px;
                background: #ffffff;
                padding: 3px;
                color: #fff;
                font-weight: bold;
            }
            body{
                -webkit-print-color-adjust:exact;
                color: #696969;
                line-height: 1;
                font-family: Arial,sans-serif; 
                background: none;
                background-color: white;
                background-image: none;
                font-size: 13px;

            }
            html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
                margin: 0;
                padding: 0;
                border: 0;
                vertical-align: baseline;
            }

            .container {
                width: 100%;
                margin-right: auto;
                margin-left: auto;
                padding-left: 2px;
                padding-right: 2px;
                border: 1px solid #000;
            }

            .main-container.container {
                background-color: inherit;
                background-image: none;
                background-repeat: inherit;
                border: 1px solid #000;
                border-style: outset;
                overflow: hidden;
            }
            .container.main-container .row {
                margin-top: 4px!important;
            }
            .row {
                margin-left: -15px;
                margin-right: -15px;
            }
            .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
                float: left;
            }
            .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
                position: relative;
                min-height: 1px;
                padding-left: 15px;
                padding-right: 15px;
            }

            .red-color{
                color: red!important;
                -webkit-print-color-adjust: exact;
            }

            #logo-img{
                height: 70px;
                width: 75px;
            }

            #example td, th {
                padding: 0.30em 0.20em;
                text-align: left;
            }
            table tr.heading {
                background: #ddd;
                color: #000;
            }
            tbody tr:nth-child(odd) {
                background: #ffffff;
            }
            table tbody tr {
                background-color: #ffffff;
            }
            table {
                padding: 0;
                margin: 0;
                background-color: #ffffff;
                font-size: 13px;
            }
            #example td, th {
                padding: 0.10em 0.80em 0.20em 0.80em;
                text-align: center;
            }
        </style>
        <style  type="text/css" media="print">
            @page 
            {
                size: auto;   
                margin-bottom: 50px; 
                // margin-left: 30px; 
                margin-top: 35px; 
                //  margin-right: 30px; 
                margin-footer: 20mm;
            }
            body 
            {
                font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; 
                color: #000;
            }
            .row{
                margin-bottom: 5px!important;
            }
            .red-color{color: red;}
            .blue-color{    color: #210EFF;
                            font-weight: bold;}
            .float_left{float: right;}
            #employee-img{
                border: 1px solid #ccc;
                
            }
            .salary_info{ 
                border-collapse:separate; 
                border-spacing:0 4px; 
                margin-left:20px;
                border:1px dotted #ccc;
            } 
            .heading_table{
                color:#FFF;
                text-align: center;
            }
            th, td {
                padding: 5px;
              }
              .footer{
                    position: absolute; 
                    bottom:-100;
                    right:0;
                   /* margin-left: 500px;*/
                   float: right;
                   margin-top: 150px;
                   
              }
        </style> 
    </head>
    <body class="logged-in dashboard current-page print-attendance">
        <!-- Page Content -->  
        <div id="page-content-wrapper">
            <div class="container-fluid">
            
                <div class="wrapper" style="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row" style="font-weight:normal; line-height: 25px;">
                                <div class="col-md-2" style="width:80px; float: left"> <img src="<?php echo base_url(); ?>resources/images/logo.png" alt="" id="logo-img"/></div>
                                <div class="col-md-10" style=" text-align: right;  float: right; font-style: italic;">
                                    <h1 style="font-size:25px;font-weight:bold;font-style: normal;">Purchase Invoice</h1>
                                    
                                    <h1 style="font-size:15px;font-weight:bold;color: #666666">Purchase Ref #0000<?php echo $purchaseInfo->id;?></h1>
                                    <!--<p>House #25, Road #34, Gulshan-2, Dhaka-1212</p>-->
                                    Order Date: <?php echo date_format(date_create($purchaseInfo->purchase_date),"d M Y");?>
                                    
                                </div>

                            </div>
                            <hr/>
                            <div class="row" style="margin-left:10px; font-style: italic">                               
                                    <div class="col-md-12" style=''>
                                        <div class="row">
                                            <div class="col-md-1" style="width:110px;">Supplier Name:</div>
                                            <div class="col-md-9" style="width:250px; font-weight: bold"><?php echo $purchaseInfo->supplier_name; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1"  style="width:110px;">Delivered By:</div>
                                            <div class="col-md-9" style="width:250px;  font-weight: bold"><?php echo $purchaseInfo->delevired_by; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1"  style="width:110px;">Contact Person :</div>
                                            <div class="col-md-9" style="width:250px;  font-weight: bold"><?php echo $purchaseInfo->contact_person;?></div>
                                        </div>
                                        
                                        <?php echo $purchaseInfo->address;?><br>
                                        <?php echo $purchaseInfo->phone;?><br>
                                        <?php echo $purchaseInfo->email;?><br>
                                    </div>
                        
                            </div>
                        </div>
                    </div>
                    <br/>
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <table style="width:100%;">
                                <thead>
                                    <tr style="background:#CCC">
                                        <th style="text-align: left">#Item</th>
                                        <th style="text-align: center">Qty</th>
                                        <th style="text-align: right">Unite Price</th>
                                        <th style="text-align: right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $slNo = 1;
                                    foreach($purchaseDetailInfo AS $item){
                                    ?>
                                    <tr>
                                        <td style="text-align: left"><?php echo $slNo++ ." ".$item->item_name; ?></td>
                                        <td style="text-align: center"><?php echo $item->total_qty; ?></td>
                                        <td style="text-align: right"><?php echo number_format($item->rate); ?></td>
                                        <td style="text-align: right"><?php $amount=$item->amount; echo number_format($amount); ?></td>
                                    </tr>
                                    <?php  
                                    $subTotal += $amount; 
                                    } 
                                    ?>
                                    <tr >
                                        <td colspan="3" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Sub Total:</td>
                                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo number_format($subTotal); ?></td>
                                    </tr>
<!--                                    <tr >
                                        <td colspan="3" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Discount:</td>
                                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo number_format($dis); ?></td>
                                    </tr>-->
                                    <tr >
                                        <td colspan="3" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Vat:</td>
                                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo number_format($purchaseInfo->vat); ?></td>
                                    </tr>
<!--                                    <tr >
                                        <td colspan="3" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Shipping:</td>
                                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo number_format($subTotal); ?></td>
                                    </tr>-->
                                    <tr >
                                        <td colspan="3" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Grand Total:</td>
                                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo number_format($purchaseInfo->grand_total); ?></td>
                                    </tr>
                                    <tr >
                                        <td colspan="3" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Paid:</td>
                                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo number_format($purchaseInfo->paid_amount); ?></td>
                                    </tr>
                                    <tr >
                                        <td colspan="3" style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC">Balance:</td>
                                        <td style="text-align: right;font-weight: bold;border-top:1px solid #DCDCDC"><?php echo number_format($purchaseInfo->balance); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12 footer">
                             <!--<htmlpagefooter name="MyFooter1">-->
                                <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 10pt; 
                                       color: #000000; font-weight: bold; font-style: italic;text-align: left; ">
                                    <tr style="margin-bottom:10px;">
                                        <td width="25%">
                                            <span style="text-align: center; font-weight: bold; font-style: italic;border-bottom:2px solid #000;">
                                                Prepared By:<br><br>
                                            </span>
                                        </td>
                                        <td width="25%" style="text-align: center; ">
                                            
                                            <span style="text-align: center; font-weight: bold; font-style: italic;border-bottom:2px solid #000;">
                                                Checked By:<br><br>
                                            </span>
                                        </td>
                                        <td width="25%" style="text-align: center; ">
                                            
                                            
                                            <span style="height:50px;font-weight: bold; font-style: italic;border-bottom:2px solid #000;">
                                                Approved By:<br><br>
                                            </span>
                                        </td>
                                        <td width="25%"  style="text-align: center; font-weight: bold; font-style: italic;">
                                            <span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000;">
                                                Received By:<br><br>
                                            </span>
                                        </td>

                                    </tr>
                                </table>
               
                            <!--</htmlpagefooter>-->
                            <!--<sethtmlpagefooter name="MyFooter1" value="on" />-->
                        </div>
                        </div>
                           
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->        
</body>
</html>