<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Employee List</title>
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
      $now = date("d-m-Y H:i:s", $servertime);
      $nowdate = date("d-m-Y", $servertime);
      $thisyear = date("Y", $servertime);
      $nowtime = date("H:i:s a", $servertime);
            $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
            $last_day_this_month  = date('t-m-Y');
            $user_id = $this->session->userdata('user_id');
            $user_type = $this->session->userdata('user_type');
            $searchpage="findcandidates";
            $page_query = $this->re_circular_model->get_all_search_emp($searchpage);
            ?> 
            <div class="row" style="font-weight:normal">
              <div class="col-md-10" style="width:595px;">
                <h1 style="font-size:25px;font-weight:bold">IIDFC Securities Limited</h1>
                <p>House #25, Road #34, Gulshan-2, Dhaka-1212</p>
                <p>Telephone: +8802-8812396, 9880916, 9881424, 8818561, 9892111</p>
                <p>Fax: +8802-8826439, 9880918</p>
              </div>
              <div class="col-md-2" style="width:400px;"> <img src="<?php echo base_url(); ?>resources/images/logo.png" alt="" id="logo-img"/></div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <p>E-mail : info@ahmedamin.com, cocdhaka@ahmedamin-bd.com, ahmedamingroup@gmail.com, misaag@ahmedamin.com</p>
              </div>
            </div>
            <div class="row under-header-bar text-center"> 
              <h1 style="font-size:20px;font-weight:bold">
             Candidates List</h1>         
            </div> 
                <div class="wrapper">
                  <div class="row">
                    <div class="col-md-12">
                      <table id="example" class="display" cellspacing="0" width="100%" border="1">
                        <thead>
                          <tr class="heading">                               
                            <th>Position</th>
                            <th>Name</th>
                            <th>Qualification</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Total Exp.</th>
                            <th>Mobile No</th>
                            <th>Religion</th>
                            <th>Marital Status</th>            
                            <th>Distict</th>
                            <th>Apply date</th>        
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if($candidates_data['content_id']){
                            foreach ($candidates_data['content_id'] as $sigle_id) {
                              $sigle_content=$this->re_circular_model->getallsearch_table_contentByid($sigle_id);
                              $id=$sigle_content['id'];
                                $content_id=$sigle_content['content_id'];
                                $emp_name=$sigle_content['emp_name'];
                                $emp_post_id=$sigle_content['emp_post_id'];
                                $post_data=$this->taxonomy->getTaxonomyBytid($emp_post_id);
                                $gender=$sigle_content['gender'];
                                $dob=$sigle_content['dob'];
                                $marital_status=$sigle_content['marital_status'];
                                $marital_status_data=$this->taxonomy->getTaxonomyBytid($marital_status);
                                $religion=$sigle_content['religion'];
                                $religion_data=$this->taxonomy->getTaxonomyBytid($religion);
                                $age=$sigle_content['age'];
                                $distict=$sigle_content['distict'];
                                $distict_data=$this->taxonomy->getTaxonomyBytid($distict);
                                $mobile_no=$sigle_content['mobile_no'];
                                $national_id=$sigle_content['national_id'];
                                $qualification=$sigle_content['qualification'];
                                $qualification_data=$this->taxonomy->getTaxonomyBytid($qualification);
                                $total_exp=$sigle_content['total_exp'];
                                $apply_date=$sigle_content['apply_date'];
                                $interview_date=$sigle_content['interview_date'];            
                                $interview_time=$sigle_content['interview_time'];            
                                $circular_id=$sigle_content['circular_id'];   
                              ?>
                              <tr>
                                    <td><?php print $post_data['name']; ?></td>
                                    <td><?php print $emp_name; ?></td>
                                    <td><?php print $qualification_data['name']; ?></td>            
                                    <td><?php if($age){ print $age; } ?></td>            
                                    <td><?php print $gender; ?></td>
                                    <td><?php print $total_exp; ?></td>
                                    <td><?php print $mobile_no; ?></td>
                                    <td><?php print $religion_data['name']; ?></td>
                                    <td><?php print $marital_status_data['name']; ?></td>   
                                    <td><?php print $distict_data['name']; ?></td>
                                    <td><?php print $apply_date; ?></td>

                                </tr>
                              <?php
                            }
                          }else{
                            foreach ($page_query as $sigle_content) {
                              $id=$sigle_content['id'];
                                $content_id=$sigle_content['content_id'];
                                $emp_name=$sigle_content['emp_name'];
                                $emp_post_id=$sigle_content['emp_post_id'];
                                $post_data=$this->taxonomy->getTaxonomyBytid($emp_post_id);
                                $gender=$sigle_content['gender'];
                                $dob=$sigle_content['dob'];
                                $marital_status=$sigle_content['marital_status'];
                                $marital_status_data=$this->taxonomy->getTaxonomyBytid($marital_status);
                                $religion=$sigle_content['religion'];
                                $religion_data=$this->taxonomy->getTaxonomyBytid($religion);
                                $age=$sigle_content['age'];
                                $distict=$sigle_content['distict'];
                                $distict_data=$this->taxonomy->getTaxonomyBytid($distict);
                                $mobile_no=$sigle_content['mobile_no'];
                                $national_id=$sigle_content['national_id'];
                                $qualification=$sigle_content['qualification'];
                                $qualification_data=$this->taxonomy->getTaxonomyBytid($qualification);
                                $total_exp=$sigle_content['total_exp'];
                                $apply_date=$sigle_content['apply_date'];
                                $interview_date=$sigle_content['interview_date'];            
                                $interview_time=$sigle_content['interview_time'];            
                                $circular_id=$sigle_content['circular_id'];   
                              ?>
                              <tr>
                                    <td><?php print $post_data['name']; ?></td>
                                    <td><?php print $emp_name; ?></td>
                                    <td><?php print $qualification_data['name']; ?></td>            
                                    <td><?php if($age){ print $age; } ?></td>            
                                    <td><?php print $gender; ?></td>
                                    <td><?php print $total_exp; ?></td>
                                    <td><?php print $mobile_no; ?></td>
                                    <td><?php print $religion_data['name']; ?></td>
                                    <td><?php print $marital_status_data['name']; ?></td>   
                                    <td><?php print $distict_data['name']; ?></td>
                                    <td><?php print $apply_date; ?></td>

                                </tr>
                              <?php } }   ?>
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