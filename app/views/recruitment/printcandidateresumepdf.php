<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Candidate Resume</title>
  <?php
  $this->load->view('includes/printcss');
  date_default_timezone_set('Asia/Dhaka');
      $servertime = time();
      $now = date("d-m-Y H:i:s", $servertime);
      $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
      $last_day_this_month  = date('t-m-Y');
      $nowdate = date("d-m-Y", $servertime);
      $thisyear = date("Y", $servertime);
      $nowbigmonth = date_format($datee, 'F Y');
      $nowtime = date("H:i:s a", $servertime);         
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
            

            <div class="row under-header-bar text-center"> 
              <h1 style="font-size:20px;font-weight:bold">Candidate Resume</h1>         
            </div> 

                <div class="wrapper">
                  <div class="row">
                    <div class="col-md-12">

                 <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
                  <tbody><tr>
                    <td colspan="6">
                      <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                          <td width="73%" height="" align="left" valign="bottom" class="BDJApplicantsName">
                            <!--Applicant's Name:-->
                            <?php 
                            $emp_name=$candidate_search_tbl['emp_name'];
                            if($emp_name){
                              print "<b style='text-transform:uppercase'>".$emp_name."</b>";
                            }
                            ?>
                          </td>

                          <td width="27%" rowspan="2" align="right" valign="bottom">
                            <!--Photograph:-->

                            <table width="140" height="140" border="0" align="center" cellpadding="0" cellspacing="7" bgcolor="#dadce1">
                              <tbody><tr> 
                                <td width="126" height="135" align="center" bgcolor="#e2e4e5" valign="middle"> 
                                 <?php 
                                 $picture_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "resources/uploads");
                                 $picture=$picture_data[0]['field_value'];
                                 ?>
                                 <?php if($picture){?>
                                 <img src="<?php echo base_url();?>resources/uploads/<?php echo $picture;?>" id="preview" width="124" height="135"/>
                                 <?php }else{?>
                                 <img src="<?php echo base_url();?>resources/images/avater.png" id="preview" width="124" height="135"/>
                                 <?php } ?>
                               </td>
                             </tr>
                           </tbody></table>

                         </td>
                       </tr>

                       <tr>
                        <td class="BDJNormalText04" align="left" valign="middle">
                          <!--Contact Address:-->
                          <?php 
                          $contact_address_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_present_address");
                          $contact_address=$contact_address_data[0]['field_value'];
                          if($contact_address){
                            print "Address: ".$contact_address;
                          } ?>    

                          <!--Home Phone:-->
                          <?php 
                          $emp_home_phone_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_home_phone");
                          $emp_home_phone=$emp_home_phone_data[0]['field_value'];
                          if($emp_home_phone){
                            print "<br> Home Phone: ".$emp_home_phone;
                          } ?>    
                          <!--Office Phone:-->
                          <?php 
                          $emp_office_phone_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_office_phone");
                          $emp_office_phone=$emp_office_phone_data[0]['field_value'];
                          if($emp_office_phone){
                            print "<br> Office Phone: ".$emp_office_phone;
                          } ?>       
                          <!--Mobile:-->
                          <?php 
                          $emp_mobile_no_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_mobile_no");
                          $emp_mobile_no=$emp_mobile_no_data[0]['field_value'];
                          if($emp_mobile_no){
                            print "<br> Mobile: ".$emp_mobile_no;
                          } ?> 
                          <?php 
                          $emp_email_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_email");
                          $emp_email=$emp_email_data[0]['field_value'];
                          if($emp_email){
                            print "<br> e-mail : ".$emp_email;
                          } ?>                     

                        </td>
                      </tr>
                    </tbody></table>
                  </td>
                </tr>
              </tbody></table>



<!--
EMPLOYMENT HISTORY, TOTAL YEAR OF EXPERIENCE:
-->

<table border="0" cellpadding="0" style="margin-top:3px;" cellspacing="0" align="center" width="100%">
      <!--
      Employment History:
    -->
    <tbody><tr>
      <td colspan="6" class="BDJHeadline01"><u>Employment History:</u></td>
    </tr>
    <!--Total Year of Experience:-->

    <tr>
     <td colspan="6" align="left" style="padding-left:5px;" class="BDJNormalText01">
       <strong>Total Year of Experience :</strong> 2.1 Year(s)

       <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="border:1px solid #666666">
        <tbody><tr class="BDJNormalText02">
          <td width="20%" align="center" style="border-right:1px solid #666666"><strong>Position</strong></td>
          <td width="15%" align="center" style="border-right:1px solid #666666"><strong>Date From</strong></td>
          <td width="15%" align="center" style="border-right:1px solid #666666"><strong>Date To</strong></td>
          <td width="15%" align="center" style="border-right:1px solid #666666"><strong>Duration</strong></td>

          <td width="12.5%" align="center" style="border-right:1px solid #666666"><strong>Name of Organization</strong></td>            

        </tr>      

        <tr class="BDJNormalText02">

          <!--Position Name:-->
          <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
            <?php 
            $emp_exp_position_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_position_1");
            $emp_exp_position_1=$emp_exp_position_1_data[0]['field_value'];
            if($emp_exp_position_1){
              $emp_exp_position_1_taxonomy=$this->taxonomy->getTaxonomyBytid($emp_exp_position_1);
              print $emp_exp_position_1_taxonomy['name'];   
            } ?> 
            &nbsp;
          </td>
          <!--Date From:-->
          <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
           <?php 
           $emp_exp_datefrom_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_datefrom_1");
           $emp_exp_datefrom_1=$emp_exp_datefrom_1_data[0]['field_value'];
           if($emp_exp_datefrom_1){
            print $emp_exp_datefrom_1;
          } ?>  
          &nbsp;        
        </td>
        <!--Date to:-->
        <td width="12.5%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_exp_dateto_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_dateto_1");
          $emp_exp_dateto_1=$emp_exp_dateto_1_data[0]['field_value'];
          if($emp_exp_dateto_1){
            print $emp_exp_dateto_1;
          } ?> 
          &nbsp;          
        </td>
        <!--Duration:-->

        <td width="12.5%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
          <?php 
          $emp_exp_duration_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_duration_1");
          $emp_exp_duration_1=$emp_exp_duration_1_data[0]['field_value'];
          if($emp_exp_duration_1){
            print $emp_exp_duration_1;
          } ?> 
          &nbsp;
        </td>


        <!--Organization:-->
        <td width="10%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
         <?php 
         $emp_exp_organization_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_organization_1");
         $emp_exp_organization_1=$emp_exp_organization_1_data[0]['field_value'];
         if($emp_exp_organization_1){
          print $emp_exp_organization_1;
        } ?>   
        &nbsp;       
      </td>
    </tr>

    <tr class="BDJNormalText02">

      <!--Position Name:-->
      <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_exp_position_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_position_2");
        $emp_exp_position_2=$emp_exp_position_2_data[0]['field_value'];
        if($emp_exp_position_2){
          $emp_exp_position_2_taxonomy=$this->taxonomy->getTaxonomyBytid($emp_exp_position_2);
          print $emp_exp_position_2_taxonomy['name'];   
        } ?> 
        &nbsp;
      </td>
      <!--Date From:-->
      <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
       <?php 
       $emp_exp_datefrom_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_datefrom_2");
       $emp_exp_datefrom_2=$emp_exp_datefrom_2_data[0]['field_value'];
       if($emp_exp_datefrom_2){
        print $emp_exp_datefrom_2;
      } ?>  
      &nbsp;        
    </td>
    <!--Date to:-->
    <td width="12.5%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_exp_dateto_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_dateto_2");
      $emp_exp_dateto_2=$emp_exp_dateto_2_data[0]['field_value'];
      if($emp_exp_dateto_2){
        print $emp_exp_dateto_2;
      } ?> 
      &nbsp;          
    </td>
    <!--Duration:-->

    <td width="12.5%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
      <?php 
      $emp_exp_duration_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_duration_2");
      $emp_exp_duration_2=$emp_exp_duration_2_data[0]['field_value'];
      if($emp_exp_duration_2){
        print $emp_exp_duration_2;
      } ?> 
      &nbsp;
    </td>


    <!--Organization:-->
    <td width="10%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
     <?php 
     $emp_exp_organization_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_organization_2");
     $emp_exp_organization_2=$emp_exp_organization_2_data[0]['field_value'];
     if($emp_exp_organization_2){
      print $emp_exp_organization_2;
    } ?>   
    &nbsp;       
  </td>
</tr>

<tr class="BDJNormalText02">

  <!--Position Name:-->
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_exp_position_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_position_3");
    $emp_exp_position_3=$emp_exp_position_3_data[0]['field_value'];
    if($emp_exp_position_3){
      $emp_exp_position_3_taxonomy=$this->taxonomy->getTaxonomyBytid($emp_exp_position_3);
      print $emp_exp_position_3_taxonomy['name'];   
    } ?> 
    &nbsp;
  </td>
  <!--Date From:-->
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
   <?php 
   $emp_exp_datefrom_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_datefrom_3");
   $emp_exp_datefrom_3=$emp_exp_datefrom_3_data[0]['field_value'];
   if($emp_exp_datefrom_3){
    print $emp_exp_datefrom_3;
  } ?>  
  &nbsp;        
</td>
<!--Date to:-->
<td width="12.5%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_exp_dateto_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_dateto_3");
  $emp_exp_dateto_3=$emp_exp_dateto_3_data[0]['field_value'];
  if($emp_exp_dateto_3){
    print $emp_exp_dateto_3;
  } ?> 
  &nbsp;          
</td>
<!--Duration:-->

<td width="12.5%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
  <?php 
  $emp_exp_duration_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_duration_3");
  $emp_exp_duration_3=$emp_exp_duration_3_data[0]['field_value'];
  if($emp_exp_duration_3){
    print $emp_exp_duration_3;
  } ?> 
  &nbsp;
</td>


<!--Organization:-->
<td width="10%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
 <?php 
 $emp_exp_organization_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_organization_3");
 $emp_exp_organization_3=$emp_exp_organization_3_data[0]['field_value'];
 if($emp_exp_organization_3){
  print $emp_exp_organization_3;
} ?>   
&nbsp;       
</td>
</tr>

<tr class="BDJNormalText02">

  <!--Position Name:-->
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_exp_position_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_position_4");
    $emp_exp_position_4=$emp_exp_position_4_data[0]['field_value'];
    if($emp_exp_position_4){
      $emp_exp_position_4_taxonomy=$this->taxonomy->getTaxonomyBytid($emp_exp_position_4);
      print $emp_exp_position_4_taxonomy['name'];   
    } ?> 
    &nbsp;
  </td>
  <!--Date From:-->
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
   <?php 
   $emp_exp_datefrom_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_datefrom_4");
   $emp_exp_datefrom_4=$emp_exp_datefrom_4_data[0]['field_value'];
   if($emp_exp_datefrom_4){
    print $emp_exp_datefrom_4;
  } ?>  
  &nbsp;        
</td>
<!--Date to:-->
<td width="12.5%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_exp_dateto_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_dateto_4");
  $emp_exp_dateto_4=$emp_exp_dateto_4_data[0]['field_value'];
  if($emp_exp_dateto_4){
    print $emp_exp_dateto_4;
  } ?> 
  &nbsp;          
</td>
<!--Duration:-->

<td width="12.5%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
  <?php 
  $emp_exp_duration_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_duration_4");
  $emp_exp_duration_4=$emp_exp_duration_4_data[0]['field_value'];
  if($emp_exp_duration_4){
    print $emp_exp_duration_4;
  } ?> 
  &nbsp;
</td>


<!--Organization:-->
<td width="10%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
 <?php 
 $emp_exp_organization_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_organization_4");
 $emp_exp_organization_4=$emp_exp_organization_4_data[0]['field_value'];
 if($emp_exp_organization_4){
  print $emp_exp_organization_4;
} ?>   
&nbsp;       
</td>
</tr>

<tr class="BDJNormalText02">

  <!--Position Name:-->
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_exp_position_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_position_5");
    $emp_exp_position_5=$emp_exp_position_5_data[0]['field_value'];
    if($emp_exp_position_5){
      $emp_exp_position_5_taxonomy=$this->taxonomy->getTaxonomyBytid($emp_exp_position_5);
      print $emp_exp_position_5_taxonomy['name'];   
    } ?> 
    &nbsp;
  </td>
  <!--Date From:-->
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
   <?php 
   $emp_exp_datefrom_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_datefrom_5");
   $emp_exp_datefrom_5=$emp_exp_datefrom_5_data[0]['field_value'];
   if($emp_exp_datefrom_5){
    print $emp_exp_datefrom_5;
  } ?>  
  &nbsp;        
</td>
<!--Date to:-->
<td width="12.5%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_exp_dateto_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_dateto_5");
  $emp_exp_dateto_5=$emp_exp_dateto_5_data[0]['field_value'];
  if($emp_exp_dateto_5){
    print $emp_exp_dateto_5;
  } ?> 
  &nbsp;          
</td>
<!--Duration:-->

<td width="12.5%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
  <?php 
  $emp_exp_duration_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_duration_5");
  $emp_exp_duration_5=$emp_exp_duration_5_data[0]['field_value'];
  if($emp_exp_duration_5){
    print $emp_exp_duration_5;
  } ?> 
  &nbsp;
</td>


<!--Organization:-->
<td width="10%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
 <?php 
 $emp_exp_organization_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_organization_5");
 $emp_exp_organization_5=$emp_exp_organization_5_data[0]['field_value'];
 if($emp_exp_organization_5){
  print $emp_exp_organization_5;
} ?>   
&nbsp;       
</td>
</tr>

<tr class="BDJNormalText02">

  <!--Position Name:-->
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_exp_position_6_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_position_6");
    $emp_exp_position_6=$emp_exp_position_6_data[0]['field_value'];
    if($emp_exp_position_6){
      $emp_exp_position_6_taxonomy=$this->taxonomy->getTaxonomyBytid($emp_exp_position_6);
      print $emp_exp_position_6_taxonomy['name'];   
    } ?> 
    &nbsp;
  </td>
  <!--Date From:-->
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
   <?php 
   $emp_exp_datefrom_6_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_datefrom_6");
   $emp_exp_datefrom_6=$emp_exp_datefrom_6_data[0]['field_value'];
   if($emp_exp_datefrom_6){
    print $emp_exp_datefrom_6;
  } ?>  
  &nbsp;        
</td>
<!--Date to:-->
<td width="12.5%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_exp_dateto_6_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_dateto_6");
  $emp_exp_dateto_6=$emp_exp_dateto_6_data[0]['field_value'];
  if($emp_exp_dateto_6){
    print $emp_exp_dateto_6;
  } ?> 
  &nbsp;          
</td>
<!--Duration:-->

<td width="12.5%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
  <?php 
  $emp_exp_duration_6_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_duration_6");
  $emp_exp_duration_6=$emp_exp_duration_6_data[0]['field_value'];
  if($emp_exp_duration_6){
    print $emp_exp_duration_6;
  } ?> 
  &nbsp;
</td>


<!--Organization:-->
<td width="10%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
 <?php 
 $emp_exp_organization_6_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_organization_6");
 $emp_exp_organization_6=$emp_exp_organization_6_data[0]['field_value'];
 if($emp_exp_organization_6){
  print $emp_exp_organization_6;
} ?>   
&nbsp;       
</td>
</tr> 

<tr class="BDJNormalText02">

  <!--Position Name:-->
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_exp_position_7_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_position_7");
    $emp_exp_position_7=$emp_exp_position_7_data[0]['field_value'];
    if($emp_exp_position_7){
      $emp_exp_position_7_taxonomy=$this->taxonomy->getTaxonomyBytid($emp_exp_position_7);
      print $emp_exp_position_7_taxonomy['name'];   
    } ?> 
    &nbsp;
  </td>
  <!--Date From:-->
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
   <?php 
   $emp_exp_datefrom_7_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_datefrom_7");
   $emp_exp_datefrom_7=$emp_exp_datefrom_7_data[0]['field_value'];
   if($emp_exp_datefrom_7){
    print $emp_exp_datefrom_7;
  } ?>  
  &nbsp;        
</td>
<!--Date to:-->
<td width="12.5%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_exp_dateto_7_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_dateto_7");
  $emp_exp_dateto_7=$emp_exp_dateto_7_data[0]['field_value'];
  if($emp_exp_dateto_7){
    print $emp_exp_dateto_7;
  } ?> 
  &nbsp;          
</td>
<!--Duration:-->

<td width="12.5%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
  <?php 
  $emp_exp_duration_7_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_duration_7");
  $emp_exp_duration_7=$emp_exp_duration_7_data[0]['field_value'];
  if($emp_exp_duration_7){
    print $emp_exp_duration_7;
  } ?> 
  &nbsp;
</td>


<!--Organization:-->
<td width="10%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
 <?php 
 $emp_exp_organization_7_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_exp_organization_7");
 $emp_exp_organization_7=$emp_exp_organization_7_data[0]['field_value'];
 if($emp_exp_organization_7){
  print $emp_exp_organization_7;
} ?>   
&nbsp;       
</td>
</tr>                          
</tbody></table>         
</td>
</tr>

</tbody></table>

<!--
'ACADEMIC QUALIFICATION:
-->

<table border="0" cellpadding="0" style="margin-top:3px;" cellspacing="0" align="center" width="100%">
 <tbody><tr>
   <td colspan="6" class="BDJHeadline01"><u>Academic Qualification:</u></td>
 </tr>

 <tr>
   <td colspan="6" align="left" style="padding-left:5px;" class="BDJNormalText01">
     <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="border:1px solid #666666">
      <tbody><tr class="BDJNormalText02">
        <td width="20%" align="center" style="border-right:1px solid #666666"><strong>Education Level</strong></td>
        <td width="15%" align="center" style="border-right:1px solid #666666"><strong>Exam/Degree</strong></td>
        <td width="15%" align="center" style="border-right:1px solid #666666"><strong>Concentration/Major</strong></td>
        <td width="15%" align="center" style="border-right:1px solid #666666"><strong>Institution</strong></td>
        
        <td width="12.5%" align="center" style="border-right:1px solid #666666"><strong>Pas.Year</strong></td>            
        
        
        <td width="10%" align="center" style="border-right:1px solid #666666"><strong>Results</strong></td>
        
      </tr>      

      <tr class="BDJNormalText02">
        <!--Exam Title:-->

        <td width="20%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_education_level_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_level_1");
          $emp_education_level_1=$emp_education_level_1_data[0]['field_value'];
          if($emp_education_level_1){
            $emp_education_level_1_taxonomy=$this->taxonomy->getTaxonomyBytid($emp_education_level_1);
            print $emp_education_level_1_taxonomy['name'];   
          } ?>  
          &nbsp;
        </td>
        <!--Degree Name:-->
        <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_education_degree_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_degree_1");
          $emp_education_degree_1=$emp_education_degree_1_data[0]['field_value'];
          if($emp_education_degree_1){
            print $emp_education_degree_1;
          } ?> 
          &nbsp;
        </td>
        <!--Major:-->
        <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
         <?php 
         $emp_education_major_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_major_1");
         $emp_education_major_1=$emp_education_major_1_data[0]['field_value'];
         if($emp_education_major_1){
          print $emp_education_major_1;
        } ?>  
        &nbsp;        
      </td>
      <!--Institute:-->
      <td width="12.5%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_education_institute_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_institute_1");
        $emp_education_institute_1=$emp_education_institute_1_data[0]['field_value'];
        if($emp_education_institute_1){
          print $emp_education_institute_1;
        } ?> 
        &nbsp;          
      </td>
      <!--Passing Year:-->

      <td width="12.5%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
        <?php 
        $emp_education_year_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_year_1");
        $emp_education_year_1=$emp_education_year_1_data[0]['field_value'];
        if($emp_education_year_1){
          print $emp_education_year_1;
        } ?> 
        &nbsp;
      </td>


      <!--Result:-->
      <td width="10%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
       <?php 
       $emp_education_results_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_results_1");
       $emp_education_results_1=$emp_education_results_1_data[0]['field_value'];
       if($emp_education_results_1){
        print $emp_education_results_1;
      } ?>   
      &nbsp;       
    </td>
  </tr>

  <tr class="BDJNormalText02">
    <!--Exam Title:-->

    <td width="20%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_education_level_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_level_2");
      $emp_education_level_2=$emp_education_level_2_data[0]['field_value'];
      if($emp_education_level_2){
        $emp_education_level_2_taxonomy=$this->taxonomy->getTaxonomyBytid($emp_education_level_2);
        print $emp_education_level_2_taxonomy['name']; 

      } ?>  
      &nbsp;
    </td>
    <!--Degree Name:-->
    <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_education_degree_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_degree_2");
      $emp_education_degree_2=$emp_education_degree_2_data[0]['field_value'];
      if($emp_education_degree_2){
        print $emp_education_degree_2;
      } ?> 
      &nbsp;
    </td>
    <!--Major:-->
    <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
     <?php 
     $emp_education_major_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_major_2");
     $emp_education_major_2=$emp_education_major_2_data[0]['field_value'];
     if($emp_education_major_2){
      print $emp_education_major_2;
    } ?>  
    &nbsp;        
  </td>
  <!--Institute:-->
  <td width="12.5%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_education_institute_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_institute_2");
    $emp_education_institute_2=$emp_education_institute_2_data[0]['field_value'];
    if($emp_education_institute_2){
      print $emp_education_institute_2;
    } ?> 
    &nbsp;          
  </td>
  <!--Passing Year:-->

  <td width="12.5%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
    <?php 
    $emp_education_year_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_year_2");
    $emp_education_year_2=$emp_education_year_2_data[0]['field_value'];
    if($emp_education_year_2){
      print $emp_education_year_2;
    } ?> 
    &nbsp;
  </td>


  <!--Result:-->
  <td width="10%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
   <?php 
   $emp_education_results_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_results_2");
   $emp_education_results_2=$emp_education_results_2_data[0]['field_value'];
   if($emp_education_results_2){
    print $emp_education_results_2;
  } ?>   
  &nbsp;       
</td>
</tr>

<tr class="BDJNormalText02">
  <!--Exam Title:-->

  <td width="20%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_education_level_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_level_3");
    $emp_education_level_3=$emp_education_level_3_data[0]['field_value'];
    if($emp_education_level_3){
      $emp_education_level_3_taxonomy=$this->taxonomy->getTaxonomyBytid($emp_education_level_3);
      print $emp_education_level_3_taxonomy['name'];
    } ?>  
    &nbsp;
  </td>
  <!--Degree Name:-->
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_education_degree_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_degree_3");
    $emp_education_degree_3=$emp_education_degree_3_data[0]['field_value'];
    if($emp_education_degree_3){
      print $emp_education_degree_3;
    } ?> 
    &nbsp;
  </td>
  <!--Major:-->
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
   <?php 
   $emp_education_major_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_major_3");
   $emp_education_major_3=$emp_education_major_3_data[0]['field_value'];
   if($emp_education_major_3){
    print $emp_education_major_3;
  } ?>  
  &nbsp;        
</td>
<!--Institute:-->
<td width="12.5%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_education_institute_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_institute_3");
  $emp_education_institute_3=$emp_education_institute_3_data[0]['field_value'];
  if($emp_education_institute_3){
    print $emp_education_institute_3;
  } ?> 
  &nbsp;          
</td>
<!--Passing Year:-->

<td width="12.5%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
  <?php 
  $emp_education_year_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_year_3");
  $emp_education_year_3=$emp_education_year_3_data[0]['field_value'];
  if($emp_education_year_3){
    print $emp_education_year_3;
  } ?> 
  &nbsp;
</td>


<!--Result:-->
<td width="10%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
 <?php 
 $emp_education_results_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_results_3");
 $emp_education_results_3=$emp_education_results_3_data[0]['field_value'];
 if($emp_education_results_3){
  print $emp_education_results_3;
} ?>   
&nbsp;       
</td>
</tr>

<tr class="BDJNormalText02">
  <!--Exam Title:-->

  <td width="20%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_education_level_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_level_4");
    $emp_education_level_4=$emp_education_level_4_data[0]['field_value'];
    if($emp_education_level_4){
      $emp_education_level_4_taxonomy=$this->taxonomy->getTaxonomyBytid($emp_education_level_4);
      print $emp_education_level_4_taxonomy['name'];
    } ?>  
    &nbsp;
  </td>
  <!--Degree Name:-->
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_education_degree_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_degree_4");
    $emp_education_degree_4=$emp_education_degree_4_data[0]['field_value'];
    if($emp_education_degree_4){
      print $emp_education_degree_4;
    } ?> 
    &nbsp;
  </td>
  <!--Major:-->
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
   <?php 
   $emp_education_major_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_major_4");
   $emp_education_major_4=$emp_education_major_4_data[0]['field_value'];
   if($emp_education_major_4){
    print $emp_education_major_4;
  } ?>  
  &nbsp;        
</td>
<!--Institute:-->
<td width="12.5%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_education_institute_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_institute_4");
  $emp_education_institute_4=$emp_education_institute_4_data[0]['field_value'];
  if($emp_education_institute_4){
    print $emp_education_institute_4;
  } ?> 
  &nbsp;          
</td>
<!--Passing Year:-->

<td width="12.5%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
  <?php 
  $emp_education_year_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_year_4");
  $emp_education_year_4=$emp_education_year_4_data[0]['field_value'];
  if($emp_education_year_4){
    print $emp_education_year_4;
  } ?> 
  &nbsp;
</td>


<!--Result:-->
<td width="10%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
 <?php 
 $emp_education_results_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_results_4");
 $emp_education_results_4=$emp_education_results_4_data[0]['field_value'];
 if($emp_education_results_4){
  print $emp_education_results_4;
} ?>   
&nbsp;       
</td>
</tr>

<tr class="BDJNormalText02">
  <!--Exam Title:-->

  <td width="20%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_education_level_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_level_5");
    $emp_education_level_5=$emp_education_level_5_data[0]['field_value'];
    if($emp_education_level_5){
      $emp_education_level_5_taxonomy=$this->taxonomy->getTaxonomyBytid($emp_education_level_5);
      print $emp_education_level_5_taxonomy['name'];
    } ?>  
    &nbsp;
  </td>
  <!--Degree Name:-->
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_education_degree_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_degree_5");
    $emp_education_degree_5=$emp_education_degree_5_data[0]['field_value'];
    if($emp_education_degree_5){
      print $emp_education_degree_5;
    } ?> 
    &nbsp;
  </td>
  <!--Major:-->
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
   <?php 
   $emp_education_major_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_major_5");
   $emp_education_major_5=$emp_education_major_5_data[0]['field_value'];
   if($emp_education_major_5){
    print $emp_education_major_5;
  } ?>  
  &nbsp;        
</td>
<!--Institute:-->
<td width="12.5%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_education_institute_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_institute_5");
  $emp_education_institute_5=$emp_education_institute_5_data[0]['field_value'];
  if($emp_education_institute_5){
    print $emp_education_institute_5;
  } ?> 
  &nbsp;          
</td>
<!--Passing Year:-->

<td width="12.5%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
  <?php 
  $emp_education_year_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_year_5");
  $emp_education_year_5=$emp_education_year_5_data[0]['field_value'];
  if($emp_education_year_5){
    print $emp_education_year_5;
  } ?> 
  &nbsp;
</td>


<!--Result:-->
<td width="10%" style="border-right:1px solid #666666;border-top:1px solid #666666;" align="center">
 <?php 
 $emp_education_results_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_education_results_5");
 $emp_education_results_5=$emp_education_results_5_data[0]['field_value'];
 if($emp_education_results_5){
  print $emp_education_results_5;
} ?>   
&nbsp;       
</td>
</tr>

</tbody></table> 
</td>
</tr>
</tbody></table>

<!--
TRAINING:
-->

<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="margin-top:3px;">
 <tbody><tr>
   <td colspan="6" class="BDJHeadline01"><u>Training Summary:</u></td>
 </tr>

 <tr>
   <td colspan="6" align="left" style="padding-left:5px;" class="BDJNormalText01">
     <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="border:1px solid #666666">
       <tbody><tr class="BDJNormalText02">
         <td width="19%" align="center" style="border-right:1px solid #666666"><strong>Training Course</strong></td>
         <td width="19%" align="center" style="border-right:1px solid #666666"><strong>Date From</strong></td>
         <td width="15%" align="center" style="border-right:1px solid #666666"><strong>Date To</strong></td>
         <td width="15%" align="center" style="border-right:1px solid #666666"><strong>Duration</strong></td>
         <td width="15%" align="center" style="border-right:1px solid #666666"><strong>Name of Organization</strong></td>
       </tr>

       <tr class="BDJNormalText02">
         <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_training_course_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_course_1");
          $emp_training_course_1=$emp_training_course_1_data[0]['field_value'];
          if($emp_training_course_1){
            print $emp_training_course_1;
          } ?>   
          &nbsp;
        </td>
        <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666; padding-left:1px;">
          <?php 
          $emp_training_datefrom_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_datefrom_1");
          $emp_training_datefrom_1=$emp_training_datefrom_1_data[0]['field_value'];
          if($emp_training_datefrom_1){
            print $emp_training_datefrom_1;
          } ?> 
          &nbsp;        
        </td>
        <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_training_dateto_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_dateto_1");
          $emp_training_dateto_1=$emp_training_dateto_1_data[0]['field_value'];
          if($emp_training_dateto_1){
            print $emp_training_dateto_1;
          } ?> 
          &nbsp;
        </td>
        <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_training_duration_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_duration_1");
          $emp_training_duration_1=$emp_training_duration_1_data[0]['field_value'];
          if($emp_training_duration_1){
            print $emp_training_duration_1;
          } ?> 
          &nbsp;
        </td>
        <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_training_organization_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_organization_1");
          $emp_training_organization_1=$emp_training_organization_1_data[0]['field_value'];
          if($emp_training_organization_1){
            print $emp_training_organization_1;
          } ?> 
          &nbsp;
        </td>
      </tr>
      <tr class="BDJNormalText02">
       <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_training_course_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_course_2");
        $emp_training_course_2=$emp_training_course_2_data[0]['field_value'];
        if($emp_training_course_2){
          print $emp_training_course_2;
        } ?>   
        &nbsp;
      </td>
      <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666; padding-left:1px;">
        <?php 
        $emp_training_datefrom_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_datefrom_2");
        $emp_training_datefrom_2=$emp_training_datefrom_2_data[0]['field_value'];
        if($emp_training_datefrom_2){
          print $emp_training_datefrom_2;
        } ?> 
        &nbsp;        
      </td>
      <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_training_dateto_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_dateto_2");
        $emp_training_dateto_2=$emp_training_dateto_2_data[0]['field_value'];
        if($emp_training_dateto_2){
          print $emp_training_dateto_2;
        } ?> 
        &nbsp;
      </td>
      <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_training_duration_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_duration_2");
        $emp_training_duration_2=$emp_training_duration_2_data[0]['field_value'];
        if($emp_training_duration_2){
          print $emp_training_duration_2;
        } ?> 
        &nbsp;
      </td>
      <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_training_organization_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_organization_2");
        $emp_training_organization_2=$emp_training_organization_2_data[0]['field_value'];
        if($emp_training_organization_2){
          print $emp_training_organization_2;
        } ?> 
        &nbsp;
      </td>
    </tr>
    <tr class="BDJNormalText02">
     <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_training_course_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_course_3");
      $emp_training_course_3=$emp_training_course_3_data[0]['field_value'];
      if($emp_training_course_3){
        print $emp_training_course_3;
      } ?>   
      &nbsp;
    </td>
    <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666; padding-left:1px;">
      <?php 
      $emp_training_datefrom_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_datefrom_3");
      $emp_training_datefrom_3=$emp_training_datefrom_3_data[0]['field_value'];
      if($emp_training_datefrom_3){
        print $emp_training_datefrom_3;
      } ?> 
      &nbsp;        
    </td>
    <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_training_dateto_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_dateto_3");
      $emp_training_dateto_3=$emp_training_dateto_3_data[0]['field_value'];
      if($emp_training_dateto_3){
        print $emp_training_dateto_3;
      } ?> 
      &nbsp;
    </td>
    <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_training_duration_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_duration_3");
      $emp_training_duration_3=$emp_training_duration_3_data[0]['field_value'];
      if($emp_training_duration_3){
        print $emp_training_duration_3;
      } ?> 
      &nbsp;
    </td>
    <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_training_organization_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_organization_3");
      $emp_training_organization_3=$emp_training_organization_3_data[0]['field_value'];
      if($emp_training_organization_3){
        print $emp_training_organization_3;
      } ?> 
      &nbsp;
    </td>
  </tr>
  <tr class="BDJNormalText02">
   <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_training_course_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_course_4");
    $emp_training_course_4=$emp_training_course_4_data[0]['field_value'];
    if($emp_training_course_4){
      print $emp_training_course_4;
    } ?>   
    &nbsp;
  </td>
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666; padding-left:1px;">
    <?php 
    $emp_training_datefrom_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_datefrom_4");
    $emp_training_datefrom_4=$emp_training_datefrom_4_data[0]['field_value'];
    if($emp_training_datefrom_4){
      print $emp_training_datefrom_4;
    } ?> 
    &nbsp;        
  </td>
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_training_dateto_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_dateto_4");
    $emp_training_dateto_4=$emp_training_dateto_4_data[0]['field_value'];
    if($emp_training_dateto_4){
      print $emp_training_dateto_4;
    } ?> 
    &nbsp;
  </td>
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_training_duration_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_duration_4");
    $emp_training_duration_4=$emp_training_duration_4_data[0]['field_value'];
    if($emp_training_duration_4){
      print $emp_training_duration_4;
    } ?> 
    &nbsp;
  </td>
  <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_training_organization_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_organization_4");
    $emp_training_organization_4=$emp_training_organization_4_data[0]['field_value'];
    if($emp_training_organization_4){
      print $emp_training_organization_4;
    } ?> 
    &nbsp;
  </td>
</tr>
<tr class="BDJNormalText02">
 <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_training_course_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_course_5");
  $emp_training_course_5=$emp_training_course_5_data[0]['field_value'];
  if($emp_training_course_5){
    print $emp_training_course_5;
  } ?>   
  &nbsp;
</td>
<td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666; padding-left:1px;">
  <?php 
  $emp_training_datefrom_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_datefrom_5");
  $emp_training_datefrom_5=$emp_training_datefrom_5_data[0]['field_value'];
  if($emp_training_datefrom_5){
    print $emp_training_datefrom_5;
  } ?> 
  &nbsp;        
</td>
<td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_training_dateto_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_dateto_5");
  $emp_training_dateto_5=$emp_training_dateto_5_data[0]['field_value'];
  if($emp_training_dateto_5){
    print $emp_training_dateto_5;
  } ?> 
  &nbsp;
</td>
<td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_training_duration_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_duration_5");
  $emp_training_duration_5=$emp_training_duration_5_data[0]['field_value'];
  if($emp_training_duration_5){
    print $emp_training_duration_5;
  } ?> 
  &nbsp;
</td>
<td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_training_organization_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_organization_5");
  $emp_training_organization_5=$emp_training_organization_5_data[0]['field_value'];
  if($emp_training_organization_5){
    print $emp_training_organization_5;
  } ?> 
  &nbsp;
</td>
</tr>
<tr class="BDJNormalText02">
 <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_training_course_6_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_course_6");
  $emp_training_course_6=$emp_training_course_6_data[0]['field_value'];
  if($emp_training_course_6){
    print $emp_training_course_6;
  } ?>   
  &nbsp;
</td>
<td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666; padding-left:1px;">
  <?php 
  $emp_training_datefrom_6_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_datefrom_6");
  $emp_training_datefrom_6=$emp_training_datefrom_6_data[0]['field_value'];
  if($emp_training_datefrom_6){
    print $emp_training_datefrom_6;
  } ?> 
  &nbsp;        
</td>
<td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_training_dateto_6_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_dateto_6");
  $emp_training_dateto_6=$emp_training_dateto_6_data[0]['field_value'];
  if($emp_training_dateto_6){
    print $emp_training_dateto_6;
  } ?> 
  &nbsp;
</td>
<td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_training_duration_6_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_duration_6");
  $emp_training_duration_6=$emp_training_duration_6_data[0]['field_value'];
  if($emp_training_duration_6){
    print $emp_training_duration_6;
  } ?> 
  &nbsp;
</td>
<td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_training_organization_6_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_organization_6");
  $emp_training_organization_6=$emp_training_organization_6_data[0]['field_value'];
  if($emp_training_organization_6){
    print $emp_training_organization_6;
  } ?> 
  &nbsp;
</td>
</tr>
<tr class="BDJNormalText02">
 <td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_training_course_7_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_course_7");
  $emp_training_course_7=$emp_training_course_7_data[0]['field_value'];
  if($emp_training_course_7){
    print $emp_training_course_7;
  } ?>   
  &nbsp;
</td>
<td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666; padding-left:1px;">
  <?php 
  $emp_training_datefrom_7_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_datefrom_7");
  $emp_training_datefrom_7=$emp_training_datefrom_7_data[0]['field_value'];
  if($emp_training_datefrom_7){
    print $emp_training_datefrom_7;
  } ?> 
  &nbsp;        
</td>
<td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_training_dateto_7_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_dateto_7");
  $emp_training_dateto_7=$emp_training_dateto_7_data[0]['field_value'];
  if($emp_training_dateto_7){
    print $emp_training_dateto_7;
  } ?> 
  &nbsp;
</td>
<td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_training_duration_7_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_duration_7");
  $emp_training_duration_7=$emp_training_duration_7_data[0]['field_value'];
  if($emp_training_duration_7){
    print $emp_training_duration_7;
  } ?> 
  &nbsp;
</td>
<td width="15%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_training_organization_7_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_training_organization_7");
  $emp_training_organization_7=$emp_training_organization_7_data[0]['field_value'];
  if($emp_training_organization_7){
    print $emp_training_organization_7;
  } ?> 
  &nbsp;
</td>
</tr>                                                  
</tbody></table>
</td>
</tr>
</tbody></table>
<!--
Computer Skills:
-->

<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="margin-top:3px;">
 <tbody><tr>
   <td colspan="6" class="BDJHeadline01"><u>Computer Skills:</u></td>
 </tr>

 <tr>
   <td colspan="6" align="left" style="padding-left:5px;" class="BDJNormalText01">
     <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="border:1px solid #666666">
       <tbody><tr class="BDJNormalText02">
         <td width="100%" align="center" style="border-right:1px solid #666666"><strong>Topics</strong></td>
       </tr>

       <tr class="BDJNormalText02">
        <td width="100%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_computer_training_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_computer_training");
          $emp_computer_training=$emp_computer_training_data[0]['field_value'];
          if($emp_computer_training){
            print $emp_computer_training;
          } ?> 
          &nbsp;
        </td>
      </tr>

    </tbody></table> 
  </td>
</tr>
</tbody></table>
<!--
Language Proficiency:
-->

<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="margin-top:3px;">
 <tbody><tr>
   <td colspan="6" class="BDJHeadline01"><u>Language Proficiency:</u></td>
 </tr>

 <tr>
   <td colspan="6" align="left" style="padding-left:5px;" class="BDJNormalText01">
     <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="border:1px solid #666666">
       <tbody><tr class="BDJNormalText02">
         <td width="25%" align="center" style="border-right:1px solid #666666"><strong>Language</strong></td>
         <td width="25%" align="center" style="border-right:1px solid #666666"><strong>Reading</strong></td>
         <td width="25%" align="center" style="border-right:1px solid #666666"><strong>Writing</strong></td>
         <td width="25%" align="center" style="border-right:1px solid #666666"><strong>Speaking</strong></td>
         <td width="25%" align="center"><strong>Listening</strong></td>
       </tr>
       
       <tr class="BDJNormalText02">
         <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_language_name_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_language_name_1");
          $emp_language_name_1=$emp_language_name_1_data[0]['field_value'];
          if($emp_language_name_1){
            print $emp_language_name_1;
          } ?>    
          &nbsp;
        </td>
        <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_language_reading_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_language_reading_1");
          $emp_language_reading_1=$emp_language_reading_1_data[0]['field_value'];
          if($emp_language_reading_1){
            print $emp_language_reading_1;
          } ?>            
          &nbsp;
        </td>
        <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_language_writing_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_language_writing_1");
          $emp_language_writing_1=$emp_language_writing_1_data[0]['field_value'];
          if($emp_language_writing_1){
            print $emp_language_writing_1;
          } ?>            
          &nbsp;
        </td>
        <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_language_speaking_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_language_speaking_1");
          $emp_language_speaking_1=$emp_language_speaking_1_data[0]['field_value'];
          if($emp_language_speaking_1){
            print $emp_language_speaking_1;
          } ?>            
          &nbsp;
        </td>  
        <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_language_listening_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_language_listening_1");
          $emp_language_listening_1=$emp_language_listening_1_data[0]['field_value'];
          if($emp_language_listening_1){
            print $emp_language_listening_1;
          } ?>            
          &nbsp;
        </td>                                 
      </tr>
      <tr class="BDJNormalText02">
       <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_language_name_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_language_name_2");
        $emp_language_name_2=$emp_language_name_2_data[0]['field_value'];
        if($emp_language_name_2){
          print $emp_language_name_2;
        } ?>    
        &nbsp;
      </td>
      <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_language_reading_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_language_reading_2");
        $emp_language_reading_2=$emp_language_reading_2_data[0]['field_value'];
        if($emp_language_reading_2){
          print $emp_language_reading_2;
        } ?>            
        &nbsp;
      </td>
      <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_language_writing_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_language_writing_2");
        $emp_language_writing_2=$emp_language_writing_2_data[0]['field_value'];
        if($emp_language_writing_2){
          print $emp_language_writing_2;
        } ?>            
        &nbsp;
      </td>
      <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_language_speaking_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_language_speaking_2");
        $emp_language_speaking_2=$emp_language_speaking_2_data[0]['field_value'];
        if($emp_language_speaking_2){
          print $emp_language_speaking_2;
        } ?>            
        &nbsp;
      </td>  
      <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_language_listening_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_language_listening_2");
        $emp_language_listening_2=$emp_language_listening_2_data[0]['field_value'];
        if($emp_language_listening_2){
          print $emp_language_listening_2;
        } ?>            
        &nbsp;
      </td>                                 
    </tr>
    <tr class="BDJNormalText02">
     <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_language_name_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_language_name_3");
      $emp_language_name_3=$emp_language_name_3_data[0]['field_value'];
      if($emp_language_name_3){
        print $emp_language_name_3;
      } ?>    
      &nbsp;
    </td>
    <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_language_reading_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_language_reading_3");
      $emp_language_reading_3=$emp_language_reading_3_data[0]['field_value'];
      if($emp_language_reading_3){
        print $emp_language_reading_3;
      } ?>            
      &nbsp;
    </td>
    <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_language_writing_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_language_writing_3");
      $emp_language_writing_3=$emp_language_writing_3_data[0]['field_value'];
      if($emp_language_writing_3){
        print $emp_language_writing_3;
      } ?>            
      &nbsp;
    </td>
    <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_language_speaking_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_language_speaking_3");
      $emp_language_speaking_3=$emp_language_speaking_3_data[0]['field_value'];
      if($emp_language_speaking_3){
        print $emp_language_speaking_3;
      } ?>            
      &nbsp;
    </td>  
    <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_language_listening_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_language_listening_3");
      $emp_language_listening_3=$emp_language_listening_3_data[0]['field_value'];
      if($emp_language_listening_3){
        print $emp_language_listening_3;
      } ?>            
      &nbsp;
    </td>                                 
  </tr>                  
</tbody></table>
</td>
</tr>
</tbody></table>
<!--
References:
-->

<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="margin-top:3px;">
 <tbody><tr>
   <td colspan="6" class="BDJHeadline01"><u>References:</u></td>
 </tr>

 <tr>
   <td colspan="6" align="left" style="padding-left:5px;" class="BDJNormalText01">
     <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="border:1px solid #666666">
       <tbody><tr class="BDJNormalText02">
         <td width="14%" align="center" style="border-right:1px solid #666666"><strong>Name</strong></td>
         <td width="14%" align="center" style="border-right:1px solid #666666"><strong>Position</strong></td>
         <td width="14%" align="center" style="border-right:1px solid #666666"><strong>Organization</strong></td>
         <td width="16%" align="center" style="border-right:1px solid #666666"><strong>Address</strong></td>
         <td width="14%" align="center" style="border-right:1px solid #666666"><strong>Phone</strong></td>
         <td width="14%" align="center" style="border-right:1px solid #666666"><strong>Email</strong></td>
         <td width="14%" align="center"><strong>Relation</strong></td>
       </tr>
       
       <tr class="BDJNormalText02">
         <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_reference_name_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_name_1");
          $emp_reference_name_1=$emp_reference_name_1_data[0]['field_value'];
          if($emp_reference_name_1){
            print $emp_reference_name_1;
          } ?>    
          &nbsp;
        </td>
        <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_reference_position_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_position_1");
          $emp_reference_position_1=$emp_reference_position_1_data[0]['field_value'];
          if($emp_reference_position_1){
            print $emp_reference_position_1;
          } ?>            
          &nbsp;
        </td>
        <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_reference_org_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_org_1");
          $emp_reference_org_1=$emp_reference_org_1_data[0]['field_value'];
          if($emp_reference_org_1){
            print $emp_reference_org_1;
          } ?>            
          &nbsp;
        </td>
        <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_reference_address_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_address_1");
          $emp_reference_address_1=$emp_reference_address_1_data[0]['field_value'];
          if($emp_reference_address_1){
            print $emp_reference_address_1;
          } ?>            
          &nbsp;
        </td>  
        <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_reference_phone_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_phone_1");
          $emp_reference_phone_1=$emp_reference_phone_1_data[0]['field_value'];
          if($emp_reference_phone_1){
            print $emp_reference_phone_1;
          } ?>            
          &nbsp;
        </td>           
        <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_reference_email_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_email_1");
          $emp_reference_email_1=$emp_reference_email_1_data[0]['field_value'];
          if($emp_reference_email_1){
            print $emp_reference_email_1;
          } ?>            
          &nbsp;
        </td>   
        <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_reference_relation_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_relation_1");
          $emp_reference_relation_1=$emp_reference_relation_1_data[0]['field_value'];
          if($emp_reference_relation_1){
            print $emp_reference_relation_1;
          } ?>            
          &nbsp;
        </td>                                                    
      </tr>
      <tr class="BDJNormalText02">
       <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_reference_name_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_name_2");
        $emp_reference_name_2=$emp_reference_name_2_data[0]['field_value'];
        if($emp_reference_name_2){
          print $emp_reference_name_2;
        } ?>    
        &nbsp;
      </td>
      <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_reference_position_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_position_2");
        $emp_reference_position_2=$emp_reference_position_2_data[0]['field_value'];
        if($emp_reference_position_2){
          print $emp_reference_position_2;
        } ?>            
        &nbsp;
      </td>
      <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_reference_org_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_org_2");
        $emp_reference_org_2=$emp_reference_org_2_data[0]['field_value'];
        if($emp_reference_org_2){
          print $emp_reference_org_2;
        } ?>            
        &nbsp;
      </td>
      <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_reference_address_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_address_2");
        $emp_reference_address_2=$emp_reference_address_2_data[0]['field_value'];
        if($emp_reference_address_2){
          print $emp_reference_address_2;
        } ?>            
        &nbsp;
      </td>  
      <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_reference_phone_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_phone_2");
        $emp_reference_phone_2=$emp_reference_phone_2_data[0]['field_value'];
        if($emp_reference_phone_2){
          print $emp_reference_phone_2;
        } ?>            
        &nbsp;
      </td>           
      <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_reference_email_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_email_2");
        $emp_reference_email_2=$emp_reference_email_2_data[0]['field_value'];
        if($emp_reference_email_2){
          print $emp_reference_email_2;
        } ?>            
        &nbsp;
      </td>   
      <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_reference_relation_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_relation_2");
        $emp_reference_relation_2=$emp_reference_relation_2_data[0]['field_value'];
        if($emp_reference_relation_2){
          print $emp_reference_relation_2;
        } ?>            
        &nbsp;
      </td>                                                    
    </tr>
    <tr class="BDJNormalText02">
     <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_reference_name_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_name_3");
      $emp_reference_name_3=$emp_reference_name_3_data[0]['field_value'];
      if($emp_reference_name_3){
        print $emp_reference_name_3;
      } ?>    
      &nbsp;
    </td>
    <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_reference_position_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_position_3");
      $emp_reference_position_3=$emp_reference_position_3_data[0]['field_value'];
      if($emp_reference_position_3){
        print $emp_reference_position_3;
      } ?>            
      &nbsp;
    </td>
    <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_reference_org_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_org_3");
      $emp_reference_org_3=$emp_reference_org_3_data[0]['field_value'];
      if($emp_reference_org_3){
        print $emp_reference_org_3;
      } ?>            
      &nbsp;
    </td>
    <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_reference_address_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_address_3");
      $emp_reference_address_3=$emp_reference_address_3_data[0]['field_value'];
      if($emp_reference_address_3){
        print $emp_reference_address_3;
      } ?>            
      &nbsp;
    </td>  
    <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_reference_phone_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_phone_3");
      $emp_reference_phone_3=$emp_reference_phone_3_data[0]['field_value'];
      if($emp_reference_phone_3){
        print $emp_reference_phone_3;
      } ?>            
      &nbsp;
    </td>           
    <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_reference_email_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_email_3");
      $emp_reference_email_3=$emp_reference_email_3_data[0]['field_value'];
      if($emp_reference_email_3){
        print $emp_reference_email_3;
      } ?>            
      &nbsp;
    </td>   
    <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_reference_relation_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_reference_relation_3");
      $emp_reference_relation_3=$emp_reference_relation_3_data[0]['field_value'];
      if($emp_reference_relation_3){
        print $emp_reference_relation_3;
      } ?>            
      &nbsp;
    </td>                                                    
  </tr>                                    
</tbody></table>
</td>
</tr>
</tbody></table>

<!--
Dependents:
-->

<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="margin-top:3px;">
 <tbody><tr>
   <td colspan="6" class="BDJHeadline01"><u>Dependents:</u></td>
 </tr>

 <tr>
   <td colspan="6" align="left" style="padding-left:5px;" class="BDJNormalText01">
     <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="border:1px solid #666666">
       <tbody><tr class="BDJNormalText02">
         <td width="14%" align="center" style="border-right:1px solid #666666"><strong>Name</strong></td>
         <td width="14%" align="center" style="border-right:1px solid #666666"><strong>Date of Birth</strong></td>
         <td width="14%" align="center" style="border-right:1px solid #666666"><strong>Relation</strong></td>
         <td width="14%" align="center"><strong>Nominee Type</strong></td>
       </tr>
       
       <tr class="BDJNormalText02">
         <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_dependent_name_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_name_1");
          $emp_dependent_name_1=$emp_dependent_name_1_data[0]['field_value'];
          if($emp_dependent_name_1){
            print $emp_dependent_name_1;
          } ?>    
          &nbsp;
        </td>
        <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_dependent_dob_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_dob_1");
          $emp_dependent_dob_1=$emp_dependent_dob_1_data[0]['field_value'];
          if($emp_dependent_dob_1){
            print $emp_dependent_dob_1;
          } ?>            
          &nbsp;
        </td>
        <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_dependent_relation_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_relation_1");
          $emp_dependent_relation_1=$emp_dependent_relation_1_data[0]['field_value'];
          if($emp_dependent_relation_1){
            $emp_dependent_relation_1_data=$this->taxonomy->getTaxonomyBytid($emp_dependent_relation_1);
            print $emp_dependent_relation_1_data['name'];
          } ?>            
          &nbsp;
        </td>
        <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
          <?php 
          $emp_dependent_nomtype_1_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_nomtype_1");
          $emp_dependent_nomtype_1=$emp_dependent_nomtype_1_data[0]['field_value'];
          if($emp_dependent_nomtype_1){
            print $emp_dependent_nomtype_1;
          } ?>            
          &nbsp;
        </td>                                  
      </tr>
      <tr class="BDJNormalText02">
       <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_dependent_name_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_name_2");
        $emp_dependent_name_2=$emp_dependent_name_2_data[0]['field_value'];
        if($emp_dependent_name_2){
          print $emp_dependent_name_2;
        } ?>    
        &nbsp;
      </td>
      <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_dependent_dob_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_dob_2");
        $emp_dependent_dob_2=$emp_dependent_dob_2_data[0]['field_value'];
        if($emp_dependent_dob_2){
          print $emp_dependent_dob_2;
        } ?>            
        &nbsp;
      </td>
      <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_dependent_relation_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_relation_2");
        $emp_dependent_relation_2=$emp_dependent_relation_2_data[0]['field_value'];
        if($emp_dependent_relation_2){
          $emp_dependent_relation_2_data=$this->taxonomy->getTaxonomyBytid($emp_dependent_relation_2);
          print $emp_dependent_relation_2_data['name'];
        } ?>            
        &nbsp;
      </td>
      <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
        <?php 
        $emp_dependent_nomtype_2_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_nomtype_2");
        $emp_dependent_nomtype_2=$emp_dependent_nomtype_2_data[0]['field_value'];
        if($emp_dependent_nomtype_2){
          print $emp_dependent_nomtype_2;
        } ?>            
        &nbsp;
      </td>                                  
    </tr>
    <tr class="BDJNormalText02">
     <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_dependent_name_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_name_3");
      $emp_dependent_name_3=$emp_dependent_name_3_data[0]['field_value'];
      if($emp_dependent_name_3){
        print $emp_dependent_name_3;
      } ?>    
      &nbsp;
    </td>
    <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_dependent_dob_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_dob_3");
      $emp_dependent_dob_3=$emp_dependent_dob_3_data[0]['field_value'];
      if($emp_dependent_dob_3){
        print $emp_dependent_dob_3;
      } ?>            
      &nbsp;
    </td>
    <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_dependent_relation_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_relation_3");
      $emp_dependent_relation_3=$emp_dependent_relation_3_data[0]['field_value'];
      if($emp_dependent_relation_3){
        $emp_dependent_relation_3_data=$this->taxonomy->getTaxonomyBytid($emp_dependent_relation_3);
        print $emp_dependent_relation_3_data['name'];
      } ?>            
      &nbsp;
    </td>
    <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
      <?php 
      $emp_dependent_nomtype_3_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_nomtype_3");
      $emp_dependent_nomtype_3=$emp_dependent_nomtype_3_data[0]['field_value'];
      if($emp_dependent_nomtype_3){
        print $emp_dependent_nomtype_3;
      } ?>            
      &nbsp;
    </td>                                  
  </tr>
  <tr class="BDJNormalText02">
   <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_dependent_name_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_name_4");
    $emp_dependent_name_4=$emp_dependent_name_4_data[0]['field_value'];
    if($emp_dependent_name_4){
      print $emp_dependent_name_4;
    } ?>    
    &nbsp;
  </td>
  <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_dependent_dob_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_dob_4");
    $emp_dependent_dob_4=$emp_dependent_dob_4_data[0]['field_value'];
    if($emp_dependent_dob_4){
      print $emp_dependent_dob_4;
    } ?>            
    &nbsp;
  </td>
  <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_dependent_relation_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_relation_4");
    $emp_dependent_relation_4=$emp_dependent_relation_4_data[0]['field_value'];
    if($emp_dependent_relation_4){
      $emp_dependent_relation_4_data=$this->taxonomy->getTaxonomyBytid($emp_dependent_relation_4);
      print $emp_dependent_relation_4_data['name'];
    } ?>            
    &nbsp;
  </td>
  <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
    <?php 
    $emp_dependent_nomtype_4_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_nomtype_4");
    $emp_dependent_nomtype_4=$emp_dependent_nomtype_4_data[0]['field_value'];
    if($emp_dependent_nomtype_4){
      print $emp_dependent_nomtype_4;
    } ?>            
    &nbsp;
  </td>                                  
</tr>
<tr class="BDJNormalText02">
 <td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_dependent_name_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_name_5");
  $emp_dependent_name_5=$emp_dependent_name_5_data[0]['field_value'];
  if($emp_dependent_name_5){
    print $emp_dependent_name_5;
  } ?>    
  &nbsp;
</td>
<td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_dependent_dob_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_dob_5");
  $emp_dependent_dob_5=$emp_dependent_dob_5_data[0]['field_value'];
  if($emp_dependent_dob_5){
    print $emp_dependent_dob_5;
  } ?>            
  &nbsp;
</td>
<td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_dependent_relation_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_relation_5");
  $emp_dependent_relation_5=$emp_dependent_relation_5_data[0]['field_value'];
  if($emp_dependent_relation_5){
    $emp_dependent_relation_5_data=$this->taxonomy->getTaxonomyBytid($emp_dependent_relation_5);
    print $emp_dependent_relation_5_data['name'];
  } ?>            
  &nbsp;
</td>
<td width="25%" align="center" style="border-right:1px solid #666666;border-top:1px solid #666666;">
  <?php 
  $emp_dependent_nomtype_5_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_dependent_nomtype_5");
  $emp_dependent_nomtype_5=$emp_dependent_nomtype_5_data[0]['field_value'];
  if($emp_dependent_nomtype_5){
    print $emp_dependent_nomtype_5;
  } ?>            
  &nbsp;
</td>                                  
</tr>                                                                              
</tbody></table>
</td>
</tr>
</tbody></table>   
<!--
PERSONAL DETAILS:
-->

<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="margin-top:3px;">
    <!--
    Personal Details
  -->
  <tbody><tr>
    <td colspan="6" class="BDJHeadline01"><u>Personal Details :</u></td>
  </tr>
  
  <tr>
    <td colspan="6" align="left" class="BDJNormalText01">
      <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
        <!--Fathers Name:-->

        <tbody><tr class="BDJNormalText03">
         <td width="22%" align="left" style="padding-left:5px;">Father's Name </td>
         <td width="2%" align="center">:</td>
         <td width="76%" align="left">
           <?php 
           $emp_fathername_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_fathername");
           $emp_fathername=$emp_fathername_data[0]['field_value'];
           if($emp_fathername){
            print $emp_fathername;
          } ?> 
          
        </td>
      </tr>
      
      <!--Mothers Name:-->
      
      <tr class="BDJNormalText03">
       <td width="22%" align="left" style="padding-left:5px;">Mother's Name </td>
       <td width="2%" align="center">:</td>
       <td width="76%" align="left">
         <?php 
         $emp_mothername_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_mothername");
         $emp_mothername=$emp_mothername_data[0]['field_value'];
         if($emp_mothername){
          print $emp_mothername;
        } ?> 
      </td>
    </tr>

    <!--Date of Birth:-->
    <tr class="BDJNormalText03">
      <td width="22%" align="left" style="padding-left:5px;">Date  of Birth</td>
      <td width="2%" align="center">:</td>
      <td width="76%" align="left">
        <?php 
        $dob=$candidate_search_tbl['dob'];
        if($dob){
          print $dob;
        }
        ?> 
      </td>
    </tr>
    <!--Gender:-->
    <tr class="BDJNormalText03">
      <td width="22%" align="left" style="padding-left:5px;">Gender</td>
      <td width="2%" align="center">:</td>
      <td width="76%" align="left">
        <?php 
        $gender=$candidate_search_tbl['gender'];
        if($gender){
          print $gender;
        }
        ?> 
      </td>
    </tr>
    <!--Marital Status:-->
    <tr class="BDJNormalText03">
      <td width="22%" align="left" style="padding-left:5px;">Marital  Status </td>
      <td width="2%" align="center">:</td>
      <td width="76%" align="left">
       <?php 
       $marital_status=$candidate_search_tbl['marital_status'];
       if($marital_status){
        $merital_data=$this->taxonomy->getTaxonomyBytid($marital_status);
        print $merital_data['name'];
      }
      ?>
    </td>
  </tr>
  <!--Nationality:-->
  <tr class="BDJNormalText03">
    <td align="left" style="padding-left:5px;">Nationality</td>
    <td align="center">:</td>
    <td align="left">
      <?php 
      $emp_nationality_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_nationality");
      $emp_nationality=$emp_nationality_data[0]['field_value'];
      if($emp_nationality){
        print $emp_nationality;
      } ?> 
    </td>
  </tr>

  <!--Religion:-->

  <tr class="BDJNormalText03">
   <td align="left" style="padding-left:5px;">Religion</td>
   <td align="center">:</td>
   <td align="left">
    <?php 
    $religion=$candidate_search_tbl['religion'];
    if($religion){
      $religion_data=$this->taxonomy->getTaxonomyBytid($religion);
      print $religion_data['name'];
    }
    ?>
  </td>
</tr>

<!--Permanent Address:-->

<tr class="BDJNormalText03">
 <td align="left" style="padding-left:5px;">Permanent  Address</td>
 <td align="center">:</td>
 <td align="left">
  <?php 
  $emp_parmanent_address_data=$this->re_circular_model->getcontentByidandname($defaultcontent_id, "emp_parmanent_address");
  $emp_parmanent_address=$emp_parmanent_address_data[0]['field_value'];
  if($emp_parmanent_address){
    print $emp_parmanent_address;
  } ?> 
</td>
</tr>

<!--Current Location:-->
<tr class="BDJNormalText03">
  <td align="left" style="padding-left:5px;">Current  Location</td>
  <td align="center">:</td>
  <td align="left">     
   <?php 
   $distict=$candidate_search_tbl['distict'];
   if($distict){
     $distict_data=$this->taxonomy->getTaxonomyBytid($distict);
     print $distict_data['name'];
   }
   ?>    
 </td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>


<center>
  <div id="divCopyRight" class="BDJCopyRight" style="border-top:1px solid #999999; width:595px;">

  </div>
</center>
              </div>
            </div>              
          </div>
        </div>
        <!-- /#page-content-wrapper -->
      </div>
      <!-- /#wrapper -->        
    </body>
    </html>