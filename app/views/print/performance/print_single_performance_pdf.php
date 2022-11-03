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
$performance_main_id_data=$this->emp_performance_model->getperfomanceidByid($performance_id_data['per_main_id']);
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
              <h1 style="font-size:20px;font-weight:bold">Employee Performance Report</h1>         
            </div> 
            <div class="emp_info" style="border-bottom:5px solid #ddd;">
              <div class="row">
                <div class="col-md-8" style="width: 500px;">
                  <div class="general_information">
                  <table id="examplee" class="display" cellspacing="0" width="100%" border="1" align="center">
                  <thead> <th colspan="4">General Information  </th></thead> 
                  <tbody> 
                      <tr>  
                      <td>Appraisal Period From  </td>
                      <td> <?php if($performance_main_id_data){ print $performance_main_id_data['appraisal_period_from'];} ?> </td>
                      <td>To  </td>
                      <td> <?php if($performance_main_id_data){ echo $performance_main_id_data['appraisal_period_to'];} ?> </td>
                      </tr>
                      <tr>  
                      <td>Name of Employee  </td>
                      <td> <?php 
                        $Employee_data=$this->search_field_emp_model->getallsearch_table_contentByid($performance_id_data['per_main_id']);
                        print $Employee_data['emp_name'];
                        ?> </td>
                      <td>Name of Appraiser  </td>
                      <td> <?php print $user_data['name']; ?> </td>
                      </tr>  
                      <tr>  
                      <td>Employee Code  </td>
                      <td> <?php print $Employee_data['emp_id']; ?> </td>
                      <td>Appraiser Code  </td>
                      <td> <?php if($user_data['employee_id']){ echo $user_data['employee_id'];} ?> </td>
                      </tr>  
                      <tr>  
                      <td>Designation  </td>
                      <td> <?php 
                       if($Employee_data['emp_post_id']){
                        $post_employee = $this->taxonomy->getTaxonomyBytid($Employee_data['emp_post_id']); 
                        echo $post_employee['name'];
                      }
                      ?>  </td>
                      <td>Designation  </td>
                      <td> <?php 
                      if($emp_information['emp_post_id']){
                        $post_supervisor = $this->taxonomy->getTaxonomyBytid($emp_information['emp_post_id']); 
                        echo $post_supervisor['name'];
                      }
                      ?> </td>
                      </tr>  
                      <tr>  
                      <td>Department  </td>
                      <td> <?php 
                      if($Employee_data['emp_department']){
                        $department_employee = $this->taxonomy->getTaxonomyBytid($Employee_data['emp_department']); 
                        echo $department_employee['name'];
                      }
                      ?> </td>
                      <td>Department  </td>
                      <td> <?php if($emp_information['emp_department']){
                        $department_supervisor = $this->taxonomy->getTaxonomyBytid($emp_information['emp_department']); 
                        echo $department_supervisor['name'];
                      }
                      ?>  </td>
                      </tr>                                         
                  </tbody>

                  </table>                                                                                                                                                                                              
                </div>
              </div> 
              <div class="col-md-4" style="width: 200px;">
                <div class="overall_rating">
                  <table id="exampleee" class="display" cellspacing="0" width="100%" border="1" align="center">
                  <thead> <th colspan="2">Overall Performance Rating  </th></thead> 
                  <tbody> 
                  <tr>
                    <td>Excellent</td>
                    <td>3.50 - 4.00</td>
                  </tr>
                  <tr>
                    <td>Good</td>
                    <td>2.81 - 3.49</td>
                  </tr>
                  <tr>
                    <td>Average</td>
                    <td>2.01- 2.80</td>
                  </tr>
                  <tr>
                    <td>Need Improvement</td>
                    <td>1.00 - 2.00</td>
                  </tr>
                  <tr>
                    <td>Unsatisfactory</td>
                    <td>0.00 - 0.99</td>
                  </tr>                  
                  </tbody>
                  </table>                                                                                                                                                              
                </div>
              </div>
            </div>                                                          
                </div>

                <div class="wrapper">
                  <div class="row">
                    <div class="col-md-12">

            <table id="example" class="display" cellspacing="0" width="100%" border="1" align="center">
              <thead>
                <tr class="heading" align="center">
                  <th rowspan="2">SL No</th>                                
                  <th rowspan="2">Criteria</th>                                
                  <th colspan="7" align="center">Score Recommended</th>
                  <th rowspan="2">Comments</th>
                </tr>
                <tr class="heading" align="center">
                  <th>Weight-age</th>                                
                  <th>Excellent (4)</th>                                
                  <th>Good (3)</th>
                  <th>Average (2)</th>
                  <th>Need Improvement <br />(1)</th>
                  <th>Unsatisfactory (0)</th>
                  <th>Total</th>
                </tr>                                
              </thead>
              <tbody>
                <?php 
                foreach ($allcriteriacategory as $single_criteriatype) {
                  $id = $single_criteriatype['id'];
                  $criteriacategory = $single_criteriatype['name'];
                  $vid = $single_criteriatype['vid'];
                  $tid_parent = $single_criteriatype['tid'];
                  $description = $single_criteriatype['description'];
                  $criteriatype_serial = $single_criteriatype['weight'];
                  $criteriatype_weight_age = $single_criteriatype['url_path'];
                  $machine_name_category = $single_criteriatype['page_title'];
                  $vid_criteria=19;
                  $criteria_data=$this->taxonomy->getcriteriaTaxonomybyparent($vid_criteria, $tid_parent);
                  $criteria_counter=count($criteria_data);
                  $criteria_counter=$criteria_counter+1;
                  if($criteriacategory){
                    ?>
                    <tr>
                      <td rowspan="<?php print $criteria_counter; ?>" style="font-weight:bold"><?php print $criteriatype_serial; ?></td>
                      <td colspan="9" class="text-left" style="font-weight:bold"><?php print $criteriacategory; ?></td>
                    </tr>
                    <?php
                    if($criteria_data){
                      $child_loop_counter=1;
                      $child_loop_counter2=0;
                      $child_data_counter=count($criteria_data);
                      $child_group_getting_value=0;
                      $total_marks_child=0;
                      foreach ($criteria_data as $single_criteria) {
                                                 // $child_loop_counter3++;
                        $child_loop_counter2++;
                        $single_criteria_name = $single_criteria['name'];
                        $single_criteria_machine_name = $single_criteria['url_path'];
                        if($performance_id){
                          $performance_value=$this->emp_performance_model->getperfomanceByidandfieldname($performance_id, $single_criteria_machine_name);
                          $comment_machine_name=$single_criteria_machine_name.'_comment';
                          $performance_value_comment=$this->emp_performance_model->getperfomanceByidandfieldname($performance_id, $comment_machine_name);
                          $child_group_getting_value2=0;
                          foreach ($criteria_data as $single_criteria2) {
                            $single_criteria_machine_name2 = $single_criteria2['url_path'];
                            $performance_value2=$this->emp_performance_model->getperfomanceByidandfieldname($performance_id, $single_criteria_machine_name2);

                            $child_group_getting_value2 +=$performance_value2['field_value'];
                          }
                        }       
                        $child_group_getting_value +=$performance_value['field_value'];
                        if($child_loop_counter2==$child_data_counter){
                         $total_marks_child=$child_data_counter*4;
                         $devidebycounter=$child_group_getting_value/$child_data_counter;
                         $abc=str_replace("%","",$criteriatype_weight_age);
                         $new_width = ($abc / 100) * $devidebycounter;
                         $hh +=$new_width;
                         $child_group_getting_valuelast=$child_group_getting_value;
                                                   // echo "<pre>";
                                                   //  print_r($child_loop_counter2."ann".$child_data_counter);
                                                   //  echo "</pre>";

                       }
                       if($child_loop_counter==1){

                         ?>
                         <tr>
                          <td class="text-left"><?php print $single_criteria_name; ?></td>
                          <td rowspan="<?php print $child_data_counter; ?>"><span id="<?php print $machine_name_category; ?>_parcentage"><?php print $criteriatype_weight_age; ?></span></td>
                          <td><input type="radio" value="4" disabled="disabled" name="rating[<?php print $single_criteria_machine_name; ?>]" <?php if($performance_value['field_value'] =='4'){print 'checked="checked"';} ?>></td>
                          <td><input type="radio" value="3" disabled="disabled" name="rating[<?php print $single_criteria_machine_name; ?>]"  <?php if($performance_value['field_value'] =='3'){print 'checked="checked"';} ?>></td>
                          <td><input type="radio" value="2" disabled="disabled" name="rating[<?php print $single_criteria_machine_name; ?>]"  <?php if($performance_value['field_value'] =='2'){print 'checked="checked"';} ?>></td>
                          <td><input type="radio" value="1" disabled="disabled" name="rating[<?php print $single_criteria_machine_name; ?>]"  <?php if($performance_value['field_value'] =='1'){print 'checked="checked"';} ?>></td>
                          <td><input type="radio" value="0" disabled="disabled" name="rating[<?php print $single_criteria_machine_name; ?>]"  <?php if($performance_value['field_value'] =='0'){print 'checked="checked"';} ?>></td>
                          <td rowspan="<?php print $child_data_counter; ?>"><span id="<?php print $machine_name_category; ?>_total"><?php   print $child_group_getting_value2;  ?></span></td>
                          <td style="padding:0px"><?php if($performance_value_comment){ $comment_value=$performance_value_comment['field_value']; print $comment_value;} ?></td>
                        </tr> 

                        <?php
                      }else{
                        ?>
                        <tr>
                          <td class="text-left"><?php print $single_criteria_name; ?></td>
                          <td><input type="radio" value="4" disabled="disabled" name="rating[<?php print $single_criteria_machine_name; ?>]" <?php if($performance_value['field_value'] =='4'){print 'checked="checked"';} ?>></td>
                          <td><input type="radio" value="3" disabled="disabled" name="rating[<?php print $single_criteria_machine_name; ?>]" <?php if($performance_value['field_value'] =='3'){print 'checked="checked"';} ?>></td>
                          <td><input type="radio" value="2" disabled="disabled" name="rating[<?php print $single_criteria_machine_name; ?>]" <?php if($performance_value['field_value'] =='2'){print 'checked="checked"';} ?>></td>
                          <td><input type="radio" value="1" disabled="disabled" name="rating[<?php print $single_criteria_machine_name; ?>]" <?php if($performance_value['field_value'] =='1'){print 'checked="checked"';} ?>></td>
                          <td><input type="radio" value="0" disabled="disabled" name="rating[<?php print $single_criteria_machine_name; ?>]" <?php if($performance_value['field_value'] =='0'){print 'checked="checked"';} ?>></td>
                          <td style="padding:0px"><?php if($performance_value_comment){ $comment_value=$performance_value_comment['field_value']; print $comment_value;} ?></td>
                        </tr> 
                        <?php
                      }

                      $child_loop_counter++;
                    }
                  }
                }

              }
              ?>
              <tr style="font-weight:bold">
                <td colspan="2"> Total Score</td>
                <td>100%</td>
                <td colspan="5">Total Performance Score Achieved for reward:</td>
                <td><span id="obtain_total_score"><?php print $hh; ?></span></td>
                <td></td>
              </tr>
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