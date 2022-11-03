<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Leave Reports</title>
  <?php
  $this->load->view('includes/printcss');
  date_default_timezone_set('Asia/Dhaka');
  $servertime = time();
  $today_date = date("d-m-Y", $servertime);   
  ?> 
 
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
    height: 42px;
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
    text-align: left;
  }
</style>
<style  type="text/css" media="print">
  @page 
  {
    size: auto;   
    margin-bottom: 50px; 
    margin-left: 24px; 
    margin-top: 35px; 
    margin-right: 35px; 
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
  </style> 
</head>
<body class="logged-in dashboard current-page print-attendance">
  <!-- Page Content -->  
  <div id="page-content-wrapper">
    <div class="container-fluid">
      <?php 

      date_default_timezone_set('Asia/Dhaka');
      $servertime = time();
      $now = date("d-m-Y H:i:s", $servertime);
            $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
            $last_day_this_month  = date('t-m-Y');
            $today = date("d-m-Y", $servertime);
            $nowdate = date("d-m-Y", $servertime);
            $nowbigmonth = date_format($default_date, 'F Y');
            $nowtime = date("H:i:s a", $servertime);
            $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
            $last_day_this_month  = date('t-m-Y');

            ?>
            <div class="row" style="font-weight:normal">
              <div class="col-md-12" >
              <h1 style="font-size:25px;font-weight:bold;text-align:center">IIDFC Securities Limited</h1>
                <address style="text-align:center">
                PFI Tower (Level-3)
56-57, Dilkusha C/A, Dhaka-1000
Bangladesh
                </address>
              </div>
              <!-- <div class="col-md-2" style="width:100px;"> <img src="<?php echo base_url(); ?>resources/images/logo.png" alt="" id="logo-img"/></div> -->
            </div>
            <hr/>
            <!-- <div class="row">
              <div class="col-md-12">
                <p>E-mail : info@ahmedamin.com, cocdhaka@ahmedamin-bd.com, ahmedamingroup@gmail.com, misaag@ahmedamin.com</p>
              </div>
            </div> -->
            <div class="row under-header-bar text-center"> 
              <h1 style="font-size:20px;font-weight:bold">Employee Leave Reports-<?php print $defaultyear; ?></h1>         
            </div> 
            <div class="emp_info" style="border-bottom:5px solid #ddd;">
              <div class="row">
                <div class="col-md-1" style="width:110px;">Employee ID:</div>
                <div class="col-md-9" style="width:250px;"><?php print $default_emp['emp_id']; ?></div>
                <div class="col-md-1" style="width:100px;">Date:</div>
                <div class="col-md-1" style="width:180px;"><?php print $nowdate; ?></div>
              </div>
              <div class="row">
                <div class="col-md-1"  style="width:110px;">Employee Name:</div>
                <div class="col-md-9" style="width:250px;"><?php print $default_emp['emp_name']; ?></div>
                <div class="col-md-1" style="width:100px;">Total Leave:</div>
                <div class="col-md-1" style="width:180px;"><?php print $emp_total_leave; ?></div>
              </div>     
              <div class="row"> 
                <div class="col-md-1" style="width:110px;" >Designation:</div>
                <div class="col-md-9" style="width:250px;"><?php 
                  $emp_post_id = $default_emp['emp_post_id']; 
                  $emp_post_id_data=$this->taxonomy->getTaxonomyBytid($emp_post_id);
                  print $emp_post_id_data['name']; 
                  ?></div>          
                  <div class="col-md-1" style="width:100px;"  >Leave Spent:</div>
                  <div class="col-md-9" style="width:180px;" ><?php 
                    $total_leave_query=$this->emp_leave_model->getemp_sumleavetotal($defaultcontent_id, $lastdateofattendance);
                    if(!$total_leave_query['Totalleave']){
                      print "0";
                    }else{
                      print $total_leave_query['Totalleave'];
                    }  ?></div>

                  </div>  
              <div class="row"> 
                <div class="col-md-1" style="width:110px;" >Mobile No:</div>
                <div class="col-md-9" style="width:250px;"><?php if($default_emp['mobile_no']){ print $default_emp['mobile_no'];}else{ print "-";} ?></div>          
                  <div class="col-md-1" style="width:100px;"  >Total Absent:</div>
                  <div class="col-md-9" style="width:180px;" ><?php print $total_absent; ?></div>
                  </div>                   
                  <div class="row">
                    <div class="col-md-1" style="width:110px;"  >Joining Date:</div>
                    <div class="col-md-1" style="width:250px;" ><?php print $default_emp['joining_date']; ?></div>        
                    <div class="col-md-1" style="width:100px;">Service Length: </div>
                    <div class="col-md-9" style="width:180px;font-size: 10px;"><?php 
                     $joining_date_arr=explode('-',$default_emp['joining_date']);
                     $joining_date_reversed=$joining_date_arr[2]."-".$joining_date_arr[1]."-".$joining_date_arr[0]." 00:00:00";
                     $jo=strtotime($joining_date_reversed);
                     date_default_timezone_set('Asia/Dhaka');
                     $now = time();
                     $removed=timespan($jo, $now);
                     $removed=timespan($jo, $now);
                     $pieces = explode(",", $removed);
                     foreach ($pieces as $key => $ll) {
                      if (strpos($ll,'Hour') !== false || strpos($ll,'Minute') !== false) {
                        unset($pieces[$key]);
                      }
                    }
                    $string = rtrim(implode(',', $pieces), ',');
                    echo $string;                 
                // echo substr($removed, 0, -21);
                    ?></div>
                  </div>                                                              
                </div>

                <div class="wrapper">
                  <div class="row">
                    <div class="col-md-12">

                      <?php
                      $grand_total_spant=0;
                      foreach ($allleavetype as $single_leave) {
                        $id = $single_leave['id'];
                        $leavetype = $single_leave['name'];
                        $vid = $single_leave['vid'];
                        $tid = $single_leave['tid'];
                        $description = $single_leave['description'];
                        if($defaultcontent_id){
                                    //$total_leave=$this->emp_leave_model->getemp_yearlyleave($defaultcontent_id, $tid);
                          date_default_timezone_set('Asia/Dhaka');
                          $servertime = time();
                          $leave_year = date("Y", $servertime); 
                          $total_leave_spent_query=$this->emp_leave_model->getemp_spentleave($defaultcontent_id, $tid, $defaultyear);
                          $total_leave_spent=0;
                          $leave_spent_date="";
                          if(count($total_leave_spent_query)){
                            ?>
                            <h4 class="green_bg" style="margin-top:2px;font-size:20px;font-weight:bold;">Leave Type: <?php print $leavetype; ?></h4>
                            <table class="eexample" class="display" cellspacing="0" width="100%" border="1">
                              <thead>
                                <tr class="heading">
                                  <th width="100px">Date</th>
                                  <th>Description</th>
                                  <th width="100px">Total Days</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                foreach ($total_leave_spent_query as $single_spent_leave) {
                                 $total_leave_spent=$total_leave_spent+$single_spent_leave['leave_total_day'];
                                 if($tid !=336){
                                 $grand_total_spant=$grand_total_spant+$single_spent_leave['leave_total_day'];
                               }
                                 $leave_spent_date .="<u>".$single_spent_leave['leave_start_date']."</u>, ";
                                 ?>
                                 <tr>
                                  <td style="text-align:center;"><?php print $single_spent_leave['leave_start_date']; ?></td>
                                  <td style="padding-left:10px;"><?php if($single_spent_leave['justification']){ echo $single_spent_leave['justification'];} ?></td>
                                  <td style="text-align:center;"><?php if($single_spent_leave['leave_total_day']){ echo $single_spent_leave['leave_total_day'];} ?></td>
                                </tr>
                                <?php
                              }
                              if($tid !=336){
                              $available_leave=$emp_total_leave-$total_leave_spent;
                              $available_leave_grant_total=$emp_total_leave-$grand_total_spant;
                            }
                              ?>
                            </tbody>
                          </table>  

                          <table border="0" style="width:100%;margin-top:2px;font-size:20px;font-weight:bold;">
                            <tr>   <td align="right" style="text-align:right;"> Total Leave: <?php print $total_leave_spent; ?>  </td></tr>
                          </table>
                          <br>
                          <?php
                        }
                      }   
                    } ?>

                    <table border="0" style="width:100%;margin-top:2px;font-size:20px;font-weight:bold;">
                      <?php if($grand_total_spant){ ?>
                      <tr>   
                        <td align="right" style="text-align:right;"> Grand Total Leave: <?php print $grand_total_spant; ?>  </td>
                      </tr>
                      <?php  } ?>
                      <?php if($available_leave_grant_total){ ?>
                      <tr>   
                        <td align="right" style="text-align:right;"> Total Available Days: <?php print $available_leave_grant_total; ?>  </td>
                      </tr>
                      <?php 
                    } ?>         

                  </table>




                  <htmlpagefooter name="MyFooter1">
                  <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 12pt; 
                  color: #000000; font-weight: bold; font-style: italic;">
                  <tr style="margin-bottom:10px;">
                    <td width="53%"><span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000">Total Available Leave <?php print $available_leave_grant_total; ?></span></td>
                    <td width="13%" align="center" style="font-weight: bold; font-style: italic;"></td>
                    <td width="33%" style="text-align: right; "><span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000;">Page {nbpg} of {PAGENO}</span></td>
                  </tr>   
                </table>
                </htmlpagefooter>
                <sethtmlpagefooter name="MyFooter1" value="on" />
              </div>
            </div>              
          </div>
        </div>
        <!-- /#page-content-wrapper -->
      </div>
      <!-- /#wrapper -->        
    </body>
    </html>