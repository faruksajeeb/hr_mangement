<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Salary Increment Reports of <?php print $default_emp['emp_name']; ?></title>
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
      $datee = date_create($lastdateofattendance);
      $nowbigmonth = date_format($datee, 'F Y');
      $nowtime = date("H:i:s a", $servertime);
            $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
            $last_day_this_month  = date('t-m-Y');
            ?>
            <div class="row" style="font-weight:normal">
              <div class="col-md-10" style="width:595px;">
                <h1 style="font-size:25px;font-weight:bold">IIDFC Securities Limited</h1>
                <!-- <p>House #25, Road #34, Gulshan-2, Dhaka-1212</p>
                <p>Telephone: +8802-8812396, 9880916, 9881424, 8818561, 9892111</p>
                <p>Fax: +8802-8826439, 9880918</p> -->
              </div>
              <!-- <div class="col-md-2" style="width:100px;"> <img src="<?php echo base_url(); ?>resources/images/logo.png" alt="" id="logo-img"/></div> -->
            </div>
            <div class="row">
              <div class="col-md-12">
                <!-- <p>E-mail : info@ahmedamin.com, cocdhaka@ahmedamin-bd.com, ahmedamingroup@gmail.com, misaag@ahmedamin.com</p> -->
              </div>
            </div>
            <div class="row under-header-bar text-center"> 
              <h1 style="font-size:20px;font-weight:bold">Employee Wise Salary Increment Reports</h1>         
            </div> 
        <div class="emp_info">
          <div class="row">
            <div class="col-md-1" style="width:110px;">Employee ID:</div>
            <div class="col-md-9" style="width:250px;"><?php print $default_emp['emp_id']; ?></div>
            <div class="col-md-1" style="width:100px;">Date:</div>
            <div class="col-md-1" style="width:180px;"><?php print $nowdate; ?></div>
          </div>
          <div class="row">
            <div class="col-md-1"  style="width:110px;">Employee Name:</div>
            <div class="col-md-9" style="width:250px;"><?php print $default_emp['emp_name']; ?></div>
            <div class="col-md-1" style="width:100px;">Time:</div>
            <div class="col-md-1" style="width:180px;"><?php print $nowtime; ?></div>
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
                $total_leave_query=$this->emp_leave_model->getemp_sumleavetotal($defaultcontent_id, $thisyear);
                if(!$total_leave_query['Totalleave']){
                  print "0";
                }else{
                  print $total_leave_query['Totalleave'];
                }  ?></div>

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
  <table  class="pop-up-table" cellspacing="0" width="100%" border="1">
    <thead>
      <tr class="heading">                                
        <th>SL</th>
        <th>Gross Salary</th>
        <th>Increament Amount</th>
        <th>Increament Percentage</th>
        <th>Fulfill Date</th>
      </tr>
    </thead>
    <tbody>
      <?php
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
          <td><?php print $salary_join_counter; ?></td>
          <td><?php print $gross_salary; ?></td>
          <td><?php print $increment_amount; ?></td>
          <td><?php print $increment_percentage; ?></td>
          <td><?php if($salary_join_counter==1){
            print $default_emp['joining_date'];
          }else{ print $increment_date; } ?>
        </td>
      </tr>
      <?php 
      $salary_join_counter++;
    } ?>
  </tbody>
</table>      
  </div>
</div>
              </div>
              <!-- /#page-content-wrapper -->
            </div>
            <!-- /#wrapper -->        
          </body>
          </html>