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
              <h1 style="font-size:20px;font-weight:bold">Employee Daily Leave Reports<br>Log Date:<?php print $default_date; ?></h1>         
            </div> 
            <div class="row">
              <div class="col-md-1" style="width:110px;">Division Name:</div>
              <div class="col-md-9" style="width:420px;"><?php print $defsultdivision_name; ?></div>
              <div class="col-md-1" style="width:35px;">Date:</div>
              <div class="col-md-1" style="width:78px;"><?php print $nowdate; ?></div>
            </div>
            <div class="row">
              <div class="col-md-1"  style="width:110px;">Short Name:</div>
              <div class="col-md-9" style="width:420px;"><?php print $defsultdivision_shortname; ?></div>
              <div class="col-md-1" style="width:35px;">Time:</div>
              <div class="col-md-1" style="width:78px;"><?php print $nowtime; ?></div>
            </div>        
            <div class="wrapper">
              <div class="row">
                <div class="col-md-12">
                  <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                      <tr class="heading" style="border:2px solid #000;font-size:12px;">
                        <tr class="heading">
                        <th>Log Date</th>
                        <th>Emp. Code</th>
                        <th>Emp Name</th>
                        <th>Department</th>
                        <th>Leave Type</th>
                        <th>Remarks</th>
                        </tr>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $total_emp=count($default_employee);
                      foreach ($default_employee as $single_emp) {
                        if(strtotime($default_date) > strtotime($today)){
                          break;
                        }  
                        $emp_content_id=$single_emp['content_id'];
                        $leave_exist = $this->emp_leave_model->getemp_leave($emp_content_id, $default_date);
                        $leave_type=$leave_exist['leave_type'];
                        $justification=$leave_exist['justification'];
                        $leave_type_taxonomy=$this->taxonomy->getTaxonomyBytid($leave_type);
                        $leave_type_details=$leave_type_taxonomy['name'];   
                        $emp_shift_time =$this->emp_working_time_model->getworkingtimeBydateandid($emp_content_id, $default_date);
                        $attendance_required = $emp_shift_time['attendance_required'];
                        $logout_required = $emp_shift_time['logout_required'];
                        $emp_details=$this->search_field_emp_model->getallsearch_table_contentByid($emp_content_id); 
                        $emp_code=$emp_details['emp_id'];
                        $emp_name=$emp_details['emp_name'];
                        $mobile_no="";
                        if($emp_details['mobile_no']){
                          $mobile_no="-".$emp_details['mobile_no'];
                        }
                        $emp_division=$this->taxonomy->getTaxonomyBytid($emp_details['emp_division']);
                        $emp_division_shortname = $emp_division['keywords'];                         
                        ?>
                        <tr>
                          <td><?php print $default_date; ?></td>
                          <td><?php print $emp_code; ?></td>
                          <td><?php print $emp_name."".$mobile_no; ?></td>
                          <td><?php print $emp_division_shortname; ?></td>
                          <td><?php if($leave_type_details !='NULL'){ print $leave_type_details;} ?></td>
                          <td><?php if($justification !='NULL'){ print $justification;} ?></td>
                        </tr>
                        <?php 
                        $leave_type_details="";
                        $reason="";
                      } ?>
                                </tbody>
                              </table> 
                              <htmlpagefooter name="MyFooter1">
                              <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 12pt; 
                              color: #000000; font-weight: bold; font-style: italic;">
                              <tr style="margin-bottom:10px;">
                                <td width="53%"><span style="font-weight: bold; font-style: italic;border-bottom:2px solid #000">Total Employee <?php print $total_emp; ?>;</span></td>
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