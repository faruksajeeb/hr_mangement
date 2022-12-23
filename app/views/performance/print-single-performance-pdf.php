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
    body {
      background-color: #ffffff;
    }

    .container-fluid {
      width: 100%;
      background-color: #ffffff;
      padding: 0 !important;
      margin: 0;
    }

    fieldset.scheduler-border {
      border: 1px groove #ddd !important;
      padding: 1em !important;
      margin: 0 0 1.5em 0 !important;
      -webkit-box-shadow: 0px 0px 0px 0px #000;
      box-shadow: 0px 0px 0px 0px #000;
    }

    legend.scheduler-border {
      font-size: 1em !important;
      font-weight: bold !important;
      text-align: left !important;
      width: auto;
      padding: 0 10px;
      border-bottom: none;
    }

    .under-header-bar {
      min-height: 13px;
      background: #ffffff;
      padding: 3px;
      color: #fff;
      font-weight: bold;
    }

    body {
      -webkit-print-color-adjust: exact;
      color: #696969;
      line-height: 1;
      font-family: Arial, sans-serif;
      background: none;
      background-color: white;
      background-image: none;
      font-size: 13px;

    }

    html,
    body,
    div,
    span,
    applet,
    object,
    iframe,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    p,
    blockquote,
    pre,
    a,
    abbr,
    acronym,
    address,
    big,
    cite,
    code,
    del,
    dfn,
    em,
    img,
    ins,
    kbd,
    q,
    s,
    samp,
    small,
    strike,
    strong,
    sub,
    sup,
    tt,
    var,
    b,
    u,
    i,
    center,
    dl,
    dt,
    dd,
    ol,
    ul,
    li,
    fieldset,
    form,
    label,
    legend,
    article,
    aside,
    canvas,
    details,
    embed,
    figure,
    figcaption,
    footer,
    header,
    hgroup,
    menu,
    nav,
    output,
    ruby,
    section,
    summary,
    time,
    mark,
    audio,
    video {
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
      margin-top: 4px !important;
    }

    .row {
      margin-left: -15px;
      margin-right: -15px;
    }

    .col-md-1,
    .col-md-2,
    .col-md-3,
    .col-md-4,
    .col-md-5,
    .col-md-6,
    .col-md-7,
    .col-md-8,
    .col-md-9,
    .col-md-10,
    .col-md-11,
    .col-md-12 {
      float: left;
    }

    .col-xs-1,
    .col-sm-1,
    .col-md-1,
    .col-lg-1,
    .col-xs-2,
    .col-sm-2,
    .col-md-2,
    .col-lg-2,
    .col-xs-3,
    .col-sm-3,
    .col-md-3,
    .col-lg-3,
    .col-xs-4,
    .col-sm-4,
    .col-md-4,
    .col-lg-4,
    .col-xs-5,
    .col-sm-5,
    .col-md-5,
    .col-lg-5,
    .col-xs-6,
    .col-sm-6,
    .col-md-6,
    .col-lg-6,
    .col-xs-7,
    .col-sm-7,
    .col-md-7,
    .col-lg-7,
    .col-xs-8,
    .col-sm-8,
    .col-md-8,
    .col-lg-8,
    .col-xs-9,
    .col-sm-9,
    .col-md-9,
    .col-lg-9,
    .col-xs-10,
    .col-sm-10,
    .col-md-10,
    .col-lg-10,
    .col-xs-11,
    .col-sm-11,
    .col-md-11,
    .col-lg-11,
    .col-xs-12,
    .col-sm-12,
    .col-md-12,
    .col-lg-12 {
      position: relative;
      min-height: 1px;
      padding-left: 15px;
      padding-right: 15px;
    }

    .red-color {
      color: red !important;
      -webkit-print-color-adjust: exact;
    }

    #logo-img {
      height: 42px;
      width: 75px;
    }

    #examplee td {
      padding: 2px;
    }

    #example td,
    th {
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

    #example td,
    th {
      padding: 0.10em 0.80em 0.20em 0.80em;
      text-align: left;
    }
  </style>
  <style type="text/css" media="print">
    @page {
      size: auto;
      margin-bottom: 50px;
      margin-left: 24px;
      margin-top: 35px;
      margin-right: 35px;
      margin-footer: 20mm;
    }

    body {
      font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
      color: #000;
    }

    .row {
      margin-bottom: 5px !important;
    }

    .red-color {
      color: red;
    }

    .blue-color {
      color: #210EFF;
      font-weight: bold;
    }

    .float_left {
      float: right;
    }

    .table {
      /* border:1px solid #ccc!important; */
    }

    .table th,
    td {
      border: 1px solid #ccc !important;
      padding: 5px;
    }
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
      $performance_main_id_data = $this->emp_performance_model->getperfomanceidByid($performance_id_data['per_main_id']);
      ?>
      <div class="row" style="font-weight:normal;">
        <div class="col-md-2" style="width:100px; float: left">
          <img src="<?php echo base_url(); ?>resources/images/logo2.png" alt="" id="logo-img" />
        </div>
        <div class="col-md-8" style="width:700px; text-align: center;  float: right;padding-left: -100px;">
          <h1 style="font-size:25px;font-weight:bold; color:#015d3f"><?php echo $companyInfo->company_name; ?></h1>
          <p><?php echo $companyInfo->comp_addresss; ?></p>
          <br />
          <p style="padding:5px; background-color: #CCC; color:#000; width:300px;margin:0 auto; ">Performance Report</p>
        </div>
      </div>

      <hr />
      <div class="emp_info" style="border-bottom:5px solid #ddd;">
        <div class="row">
          <div class="col-md-8" style="width: 500px;">
            <div class="general_information">
              <table id="examplee" class="display" cellspacing="0" width="100%" border="1" align="center">
                <thead>
                  <th colspan="4">General Information </th>
                </thead>
                <tbody>
                  <tr>
                    <td>Name of Employee </td>
                    <td> <?php
                          echo $performanceInfo->emp_name;
                          ?> </td>
                    <td>Name of Appraiser </td>
                    <td> <?php echo $performanceInfo->appraiser_name; ?> </td>
                  </tr>
                  <tr>
                    <td>Company </td>
                    <td> <?php
                          echo $performanceInfo->company_name;
                          ?> </td>
                    <td>Division </td>
                    <td> <?php echo $performanceInfo->division_name; ?> </td>
                  </tr>
                  <tr>
                    <td>Department </td>
                    <td> <?php
                          echo $performanceInfo->department_name;
                          ?> </td>
                    <td>Designation </td>
                    <td> <?php echo $performanceInfo->designation_name; ?> </td>
                  </tr>

                  <tr>
                    <td>Performance Session </td>
                    <td colspan="3"> <?php
                                      echo $performanceInfo->performance_title;
                                      ?> </td>
                  </tr>
                  <tr>
                    <td>Appraisal Period From </td>
                    <td> <?php
                          echo $performanceInfo->date_from;
                          ?> </td>
                    <td>To </td>
                    <td> <?php
                          echo $performanceInfo->date_to;
                          ?> </td>
                  </tr>


                </tbody>

              </table>
            </div>
          </div>
          <div class="col-md-4" style="width: 200px;">
            <div class="overall_rating">
                <table class="table ">
                  <tr>
                    <th colspan="3">Performance Rating</th>
  </tr>
                  <tr>
                    <th>Title</th>
                    <th>Percentage(%)</th>
                    <th>Score</th>
  </tr>
                  <tbody>
                    <?php foreach ($performance_ratings as $val) : ?>
                      <tr>
                        <td><?php echo $val->title; ?></td>
                        <td style="text-align:center"><?php echo $val->percentage_from . ' - ' . $val->percentage_to; ?></td>
                        <td style="text-align:center"><?php echo $val->score; ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>

      <div class="wrapper">
        <div class="row">
          <div class="col-md-12">
            <table class="table">
              <tr>
                <th colspan="4">General Perofrmance Ratings</th>
              </tr>
              <tr>
                <td>Indicators</td>
                <td style="width:60px;text-align:center">Weight</td>
                <td style="width:60px;text-align:center">Rating</td>
                <td style="width:60px;text-align:center">Score</td>
              </tr>
              <?php
              $totalScoreGeneral = 0;
              foreach ($general_performances_rating_details as $key => $val) :
                if (count($val['records']) > 1) {
              ?>
                  <tr>
                    <td colspan="4" style="font-weight:bold;font-size:12px"><?php echo $key . '. ' . $val['parent_indicator_name']; ?>
                    </td>
                  </tr>
                  <?php
                  foreach ($val['records'] as $subVal) :
                  ?>
                    <tr>
                      <td style="text-align:left;padding-left:10px"><?php echo $subVal->sub_indicator_name; ?></td>
                      <td style="text-align:center"><?php echo $subVal->weight; ?></td>
                      <td style="text-align:center"><?php echo $subVal->rating; ?></td>
                      <td style="text-align:center"><?php echo $subVal->score; ?></td>
                    </tr>
                  <?php
                    $totalScoreGeneral += $val['score'];
                  endforeach; ?>

                <?php
                } else {
                ?>
                  <tr>
                    <td style="font-weight:bold;font-size:12px"><?php echo $key . '. ' . $val['parent_indicator_name']; ?>
                    </td>
                    <td style="text-align:center"><?php echo $val['weight']; ?></td>
                    <td style="text-align:center"><?php echo $val['rating']; ?></td>
                    <td style="text-align:center"><?php echo $val['score']; ?></td>
                  </tr>
              <?php
                  $totalScoreGeneral += $val['score'];
                }

              endforeach;
              ?>
              <tr>
                <td colspan="3" style="font-weight:bold;font-size:12px">Total Score General</td>
                <td style="font-weight:bold;font-size:12px;text-align:center"><?php echo $totalScoreGeneral; ?></td>
              </tr>
            </table>

            <p style="font-weight:bold; font-style:italic;font-size:15px">*** Total weightings must equal to 100 </p>
            <br>
            <table class="table">
              <tr>
                <th colspan="6">Business Perofrmance Ratings</th>
              </tr>
              <tr>
                <td>Deliverable Area/ Perspective</td>
                <td style="width:60px;text-align:center">KPI/Target</td>
                <td style="width:60px;text-align:center">Achievement</td>
                <td style="width:60px;text-align:center">Weight</td>
                <td style="width:60px;text-align:center">Rating</td>
                <td style="width:60px;text-align:center">Score</td>
              </tr>
              <?php
              $totalScoreBusiness = 0;
              foreach ($business_performances_rating_details as $key => $val) :
                if (count($val['records']) > 1) {
              ?>
                  <tr>
                    <td colspan="6" style="font-weight:bold;font-size:12px"><?php echo $key . '. ' . $val['parent_indicator_name']; ?>
                    </td>
                  </tr>
                  <?php
                  foreach ($val['records'] as $subVal) :
                    if ($subVal->sub_indicator_name == '') continue;
                  ?>
                    <tr>
                      <td style="text-align:left;padding-left:10px"><?php echo $subVal->sub_indicator_name; ?></td>
                      <td style="text-align:center"><?php echo $subVal->sub_target_or_kpi; ?></td>
                      <td style="text-align:center"><?php echo $subVal->sub_achivment; ?></td>
                      <td style="text-align:center"><?php echo $subVal->weight; ?></td>
                      <td style="text-align:center"><?php echo $subVal->rating; ?></td>
                      <td style="text-align:center"><?php echo $subVal->score; ?></td>
                    </tr>
                  <?php
                    $totalScoreBusiness += $subVal->score;
                  endforeach; ?>
                <?php
                } else {
                ?>
                  <tr>
                    <td style="font-weight:bold;font-size:12px"><?php echo $key . '. ' . $val['parent_indicator_name']; ?>
                    </td>
                    <td style="text-align:center"><?php echo $val['target_or_kpi']; ?></td>
                    <td style="text-align:center"><?php echo $val['achivment']; ?></td>
                    <td style="text-align:center"><?php echo $val['weight']; ?></td>
                    <td style="text-align:center"><?php echo $val['rating']; ?></td>
                    <td style="text-align:center"><?php echo $val['score']; ?></td>
                  </tr>
              <?php
                  $totalScoreBusiness += $val['score'];
                }
              endforeach;
              ?>
              <tr>
                <td colspan="5" style="font-weight:bold;font-size:12px">Total Score Business</td>
                <td style="font-weight:bold;font-size:12px;text-align:center"><?php echo $totalScoreBusiness; ?></td>
              </tr>
            </table>
            <br>
            <table width="100%">
              <tr>
                <td colspan="3">
                  Overall performance rating is determined by a combination of Targets/ KPIs and demonstration of CBCRL's Competencies. Weightage for KPIs & Competencies are given below:

                </td>
              </tr>
              <tr>
                <td style="text-align:center">Role</td>
                <td style="text-align:center">Targets/KPIs</td>
                <td style="text-align:center">Core Competencies</td>
              </tr>
              <tr>
                <td style="text-align:center">All Employees </td>
                <td style="text-align:center"><?php echo $performanceInfo->business_percentage; ?>%</td>
                <td style="text-align:center"><?php echo $performanceInfo->general_percentage; ?>%</td>
              </tr>
            </table>
            <br>
            <table width="100%">
              <tr>
                <td colspan="4">
                  Overall Performance Rating (Please find below your ratings from section I and II):
                </td>
              </tr>
              <tr>
                <td style="text-align:center">Section I: Targets/KPIs (What To Achieve )
                </td>
                <td style="text-align:center">"Section II: Core Values & Competencies
                  (How To Achieve) "
                </td>
                <td style="text-align:center">"Overall Performance Rating in %
                  (Numeric)"
                </td>
                <td style="text-align:center">Overall Performance Rating (Description )
                </td>
              </tr>
              <tr>
                <td style="text-align:center"><?php
                                              echo $businessScore = ($totalScoreBusiness * $performanceInfo->business_percentage) / 100;
                                              ?></td>
                <td style="text-align:center">
                  <?php

                  echo $generalScore = ($totalScoreGeneral * $performanceInfo->general_percentage) / 100;
                  ?>
                </td>
                <td style="text-align:center">
                  <?php
                  echo $overallPerformanceRatingPercentage = ($businessScore + $generalScore) / 600 * 120;
                  // $overallPerformanceRatingPercentage =121;
                  ?>
                </td>
                <td style="text-align:center">
                  <?php
                  $perRating = $this->db->query("SELECT title FROM performance_ratings WHERE percentage_from <=$overallPerformanceRatingPercentage AND percentage_to >= $overallPerformanceRatingPercentage")->row();
                  echo $perRating->title;
                  ?>
                </td>
              </tr>
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