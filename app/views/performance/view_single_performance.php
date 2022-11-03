<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Employee Performance</title>
  <?php
  $this->load->view('includes/cssjs');
  ?> 

  <script>
    $(document).ready(function(){


                function locations(substring,string){
                  var a=[],i=-1;
                  while((i=string.indexOf(substring,i+1)) >= 0) a.push(i);
                  return a;
                }
              });
     function popitup(url) {
  newwindow=window.open(url,'name','height=auto,width=700px');
  //newwindow.print();
  window.onfocus=function(){ newwindow.close();}
  if (window.focus) {newwindow.focus(); }
  var document_focus = false;
  $(newwindow).focus(function() { document_focus = true; });
  $(newwindow).load(function(){
   // setInterval(function() { if (document_focus === true) { newwindow.close();  document_focus = false;}  }, 7000);
   
 });
  return false;
} 
</script>   
<style>
  .general_information .row{
    border-left: 1px solid #000;
    border-right: 1px solid #000;    
  }

  .general_information div[class^="col-md-"]{
    border-top: 1px solid #000;
    border-left: 1px solid #000;
  }
  .general_information .row:last-child{
    border-bottom: 1px solid #000;
  }    
  .general_information div.border_left_0{
    border-left: 0px;
  }
  .general_information input{
    padding: 3px 0px;
  }
  .overall_rating{
    margin-left: 10px;
  }
  .overall_rating .row{
    border-left: 1px solid #000;
    border-right: 1px solid #000;    
  }    
  .overall_rating div[class^="col-md-"]{
    border-top: 1px solid #000;
    border-left: 1px solid #000;
  }
  .overall_rating .row:last-child{
    border-bottom: 1px solid #000;
  }    
  .overall_rating div.border_left_0{
    border-left: 0px;
  }    
  .padding_6{
    padding: 6px;
  }
  .padding_7{
    padding: 7px;
  }
  .padding_0{
    padding: 0px;
  }    
  #example{
    margin-top:15px;
  }
  #example td, th {
    padding: 4px;
    text-align: center;
  }
  #example td.text-left{
    text-align: left;
  }
</style> 
</head>
<body class="logged-in dashboard current-page add-division">
  <!-- Page Content -->  
  <div id="page-content-wrapper">
    <div class="container-fluid">
      <?php 
      $this -> load -> view('includes/menu');
      $performance_main_id_data=$this->emp_performance_model->getperfomanceidByid($performance_id_data['per_main_id']);
      ?>
      <div class="row under-header-bar text-center"> 
        <h4>Employee Performance Appraisal <a style="text-decoration: none;color: #fff; float: right;" onclick="return popitup('<?php echo site_url("empperformance/printsingleperformancepdf/$performance_id") ; ?>')" href="<?php echo site_url("empperformance/printsingleperformancepdf/$performance_id") ; ?>"  class="operation-print-pdf operation-link"> Print</a></h4>         
      </div> 
      <div class="wrapper">
        <div class="row">
          <div class="col-md-12">
            <form action="<?php echo base_url(); ?>empperformance/addempperformance" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
              <div class="row success-err-sms-area">
                <div class="col-md-12">
                  <input type="hidden" name="performance_content_id" id="performance_content_id" value="<?php print $performance_id; ?>">
                  <div id="errors"></div>
                  <?php echo $error; ?>
                  <?php echo $msg; 
                  ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8">
                  <div class="general_information">
                  <table border="1" width="100%">
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
              <div class="col-md-4">
                <div class="overall_rating">
                  <div class="row">
                    <div class="col-md-12 border_left_0"><h4>Overall Performance Rating</h4></div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 padding_7 border_left_0">Excellent</div>
                    <div class="col-md-6 padding_7">3.50 - 4.00</div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 padding_7 border_left_0">Good</div>
                    <div class="col-md-6 padding_7">2.81 - 3.49</div>
                  </div> 
                  <div class="row">
                    <div class="col-md-6 padding_7 border_left_0">Average</div>
                    <div class="col-md-6 padding_7">2.01- 2.80</div>
                  </div>  
                  <div class="row">
                    <div class="col-md-6 padding_7 border_left_0">Need Improvement</div>
                    <div class="col-md-6 padding_7">1.00 - 2.00</div>
                  </div> 
                  <div class="row">
                    <div class="col-md-6 padding_7 border_left_0">Unsatisfactory</div>
                    <div class="col-md-6 padding_7">0.00 - 0.99</div>
                  </div>                                                                                                                                                               
                </div>
              </div>
            </div>
            <div class="row">

            </div>

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
          <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-2"><br><a style="background: #fff;padding: 13px;border-radius: 20px;color: #000;" onclick="return popitup('<?php echo site_url("empperformance/printsingleperformancepdf/$performance_id") ; ?>')" href="<?php echo site_url("empperformance/printsingleperformancepdf/$performance_id") ; ?>"  class="operation-print-pdf operation-link"> Print</a></div>
            <div class="col-md-5"></div>
          </div>
          <br>                        
          <br>                        
          <br>                        
        </div>
      </form>
    </div>              
  </div>
</div>
<!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->        
</body>
</html>