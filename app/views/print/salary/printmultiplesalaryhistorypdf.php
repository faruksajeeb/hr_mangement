<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Employee Wise Leave Reports</title>
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
    text-align: center;
  }
</style>
<style  type="text/css" media="print">
  @page 
  {
    size: auto;   
    margin-bottom: 35px; 
    margin-left: 24px; 
    margin-top: 35px; 
    margin-right: 35px; 
    margin-footer: 20mm;
  }
  body 
  {
    font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; 
    color: #000;
    margin-bottom: 35px; 
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
      $lastdateofattendance=end($date_range);
      $now = date("d-m-Y H:i:s", $servertime);
      $nowdate = date("d-m-Y", $servertime);
      $thisyear = date("Y", $servertime);
      $searchyear = date("Y", $default_date);
      $datee = date_create($lastdateofattendance);
      $nowbigmonth = date_format($datee, 'F Y');
      $arr_date=explode("-", $default_date);
      $nowtime = date("H:i:s a", $servertime);
            $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
            $last_day_this_month  = date('t-m-Y');
            $working_time_today_total=0; $emp_overtime_today=0;$t3=0;$ot3=0;
            $late_counter=0;$early_counter=0;$absent_halfday_counter=0;$absent_counter=0;
            ?>
            <div class="row" style="font-weight:normal">
              <div class="col-md-10" style="width:850px;">
                <h1 style="font-size:25px;font-weight:bold">IIDFC Securities Limited</h1>
                <!-- <p>House #25, Road #34, Gulshan-2, Dhaka-1212</p>
                <p>Telephone: +8802-8812396, 9880916, 9881424, 8818561, 9892111</p>
                <p>Fax: +8802-8826439, 9880918</p> -->
              </div>
              <!-- <div class="col-md-2" style="width:180px;"> <img src="<?php echo base_url(); ?>resources/images/logo.png" alt="" id="logo-img"/></div> -->
            </div>
            <div class="row">
              <div class="col-md-12">
                <!-- <p>E-mail : info@ahmedamin.com, cocdhaka@ahmedamin-bd.com, ahmedamingroup@gmail.com, misaag@ahmedamin.com</p> -->
              </div>
            </div>
            <div class="row under-header-bar text-center">
              <h1 style="font-size:20px;font-weight:bold">Employee Salary Increment Reports</h1>         
            </div> 
            <div class="emp_info">
              <div class="row">
                <div class="col-md-1" style="width:110px;">Division Name:</div>
                <div class="col-md-9" style="width:720px;"><?php print $defsultdivision_name; ?></div>
                <div class="col-md-1" style="width:35px;">Date:</div>
                <div class="col-md-1" style="width:78px;"><?php print $nowdate; ?></div>
              </div>
              <div class="row">
                <div class="col-md-1"  style="width:110px;">Short Name:</div>
                <div class="col-md-9" style="width:720px;"><?php print $defsultdivision_shortname; ?></div>
                <div class="col-md-1" style="width:35px;">Time:</div>
                <div class="col-md-1" style="width:78px;"><?php print $nowtime; ?></div>
              </div>                                                
            </div>               
            <div class="wrapper">
              <div class="row">
                <div class="col-md-12">

                              <table id="example" class="display" cellspacing="0" width="100%">
              <thead>
                <tr class="heading" style="border:2px solid #000;font-size:12px;">
                  <th>SL.</th>
                  <th>Face ID</th>
                  <th>Name of Employee</th>
                  <th>Designation</th>
                  <th style="width:73px;">Joining Date</th>
                  <th>Increment Date</th>
                  <th>%</th>
                  <th>Amount</th>
                  <th>Present Salary</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $counter=1;
                foreach ($emp_codes as $single_code) {
                  $content_id = $this->employee_id_model->getemp_idby_empcode($single_code);   
                  $single_emp=$this->search_field_emp_model->getallsearch_table_contentByid($content_id);
                  $emp_content_id=$content_id;

                  $single_code=$single_emp['emp_id'];
                  $emp_content_id=$single_emp['content_id'];
                  $emp_name=$single_emp['emp_name'];
                  $emp_division_id=$single_emp['emp_division']; 
                  $mobile_no="";
                  if($single_emp['mobile_no']){
                    $mobile_no="-".$single_emp['mobile_no']; 
                  }
                  $emp_division=$this->taxonomy->getTaxonomyBytid($emp_division_id);
                  $emp_post_id = $single_emp['emp_post_id']; 
                  $emp_post_id_data=$this->taxonomy->getTaxonomyBytid($emp_post_id);
                  $emp_designation=$emp_post_id_data['name'];
                  $emp_division_shortname = $emp_division['keywords'];
                  $emp_joining_date=$single_emp['joining_date'];
                  $today = date("d-m-Y", $servertime);
                  $grand_total_spant=0;
                  $leave_spent_date="";
                  $total_leave_spent=0;
                  $date_arr=explode("-", $default_date);
                  $year=$date_arr['2'];

                  // $emp_total_leave = $this->emp_yearly_leave_history_model->getemp_yearlyleave_historybydate($emp_content_id, $default_date);                           
                  // $total_leave_spent_query= $this->emp_leave_model->getemp_yearlyleavebyyear($emp_content_id, $year);

                  ?>
                  <tr style="border:1px solid #000;border-bottom:none;border-left:none;border-right:none;">
                    <td><?php print $counter; ?></td>
                    <td style="text-align:left"><?php print $single_code; ?></td>
                    <td style="text-align:left"><?php print $emp_name; ?></td>
                    <td style="text-align:left"><?php print $emp_designation; ?></td>
                    <td style="text-align:left"><?php print $single_emp['joining_date']; ?></td>
                    <td style="text-align:left;padding: 0;" colspan="4"><table border="1" width="100%"><?php 
                     $salary_allamount_ascorder = $this->emp_salary_model->getallsalarybyasc($emp_content_id);  
                     $salary_join_counter=1;
                     $salary_count=count($salary_allamount_ascorder);

                     foreach ($salary_allamount_ascorder as $single_salary) {
                      $gross_salary =$single_salary['gross_salary'];
                      $increment_amount =$single_salary['increment_amount'];
                      $increment_percentage =$single_salary['increment_percentage'];
                      $increment_date =$single_salary['increment_date'];
                      $id =$single_salary['id'];

                      ?>
                      <tr>                                    
                        <td width="100px"><?php if($salary_join_counter==1){
                          print $emp_joining_date;
                        }else{ print $increment_date; } ?></td>
                        <td width="70px"><?php print $increment_percentage; ?></td>
                        <td width="70px"><?php print $increment_amount; ?></td>
                        <td><?php print $gross_salary; ?></td>
                    </tr>
                    <?php 
                    $salary_join_counter++;
                  } ?></table>
                </td>
              </tr>

              <?php 
              $counter++;
            } ?>  
          </tbody>
        </table>  
                                                                                                                        
                    </div>
                  </div>              
                </div>
              </div>
              <!-- /#page-content-wrapper -->
            </div>
            <!-- /#wrapper -->    

          </body>
          </html>