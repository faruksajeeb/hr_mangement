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
                // Setup - add a text input to each footer cell
                // $('#example tfoot th').each(function () {
                //     var title = $('#example thead th').eq($(this).index()).text();
                //     $(this).html('<input type="text" placeholder="Search ' + title + '" />');
                // });

                // // DataTable
                // var table = $('#example').DataTable();

                // // Apply the search
                // table.columns().eq(0).each(function (colIdx) {
                //     $('input', table.column(colIdx).footer()).on('keyup change', function () {
                //         table
                //         .column(colIdx)
                //         .search(this.value)
                //         .draw();
                //     });
                // });

$("input:radio").click(function() {
    var name = $(this).attr('name');
    var name = name.replace("rating[", "");
    var name = name.replace("]", "");
    var index_array=locations("_",name);
    var final_index=index_array[index_array.length-2];
    var name_starting = name.substring(0, final_index);
    var cat_total=0;
    $('input[name^="rating['+name_starting+'"]:checked').each(function( index ) {
        var fieldname=$( this ).attr('name');
        var checked_value=$("input[name='"+fieldname+"']:checked").val();
        if(checked_value){
            cat_total=parseFloat(cat_total)+parseFloat(checked_value);
        }
    });
    var cat_pacentage=$('[id='+name_starting+'_parcentage]').text();
    var cat_pacentage = cat_pacentage.replace("%", "");
    var total_devide_by4=cat_total/4;
    var final_score=total_devide_by4*cat_pacentage/100;
    var obtain_total=0;
   // $('[id='+name_starting+'_total]').text(final_score.toFixed(2));
    // $("[id$='_total']").each(function( index ) {
    //     var cat_final_total=$( this ).text();
    //     if(cat_final_total){
    //         obtain_total=parseFloat(obtain_total)+parseFloat(cat_final_total);
    //     }
    // });
    //$('#obtain_total_score').text(obtain_total.toFixed(2));
});
function locations(substring,string){
  var a=[],i=-1;
  while((i=string.indexOf(substring,i+1)) >= 0) a.push(i);
  return a;
}

$("#emp_id").change(function(){
    var emp_id=$( this ).val();
    var base_url='<?php echo base_url();?>'; 
    $("#txt_employee_code").val(emp_id);
    var postData = {
        "emp_id" : emp_id,
    };
    $.ajax({
       type: "POST",
       url: ""+base_url+"empperformance/getempoyeeInfo",
       data: postData,
       dataType:'json',
       success: function(data){
        $("#emp_designation").val(data.emp_post_id);
        $("#emp_department").val(data.emp_department);
    }
});    
});
$("#emp_appraiser_name").change(function(){
    var emp_id=$( this ).val();
    $("#txt_appraiser_code").val(emp_id);
    var base_url='<?php echo base_url();?>';
    var postData = {
        "emp_id" : emp_id,
    };
    $.ajax({
       type: "POST",
       url: ""+base_url+"empperformance/getempoyeeInfo",
       data: postData,
       dataType:'json',
       success: function(data){
        $("#emp_appraiser_designation").val(data.emp_post_id);
        $("#emp_appraiser_department").val(data.emp_department);
    }
});    
});
  $(document).on('keydown', 'input#txt_employee_code', function(e) { 
    var keyCode = e.keyCode || e.which; 

    if (keyCode == 9) { //tab key
      e.preventDefault(); 
    // call custom function here
  var emp_code = $("#txt_employee_code").val(); 
  var base_url='<?php echo base_url();?>';
  var postData = {
    "emp_code" : emp_code
  };
  $.ajax({
   type: "POST",
   url: ""+base_url+"empperformance/getempcontentid",
   data: postData,
   dataType:'json',
   success: function(data){
    if (data) {
       window.location.href = "" + base_url + "empperformance/addempperformance/"+data;
      }
  }

});
    
    } 
  });
});
function ConfirmDelete()
{
    var x = confirm("Are you sure you want to delete?");
    if (x)
        return true;
    else
        return false;
}
function validate() {
  var valid = true;
  var msg="<ul>";
  if ( document.myForm.appraisal_period_from.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.appraisal_period_from.focus();
      document.myForm.appraisal_period_from.style.border="solid 1px red";
      msg+="<li>You need to fill the appraisal_period_from field!</li>";
      valid = false;
      return false;
  }
} 
if ( document.myForm.appraisal_period_to.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.appraisal_period_to.focus();
      document.myForm.appraisal_period_to.style.border="solid 1px red";
      msg+="<li>You need to fill the appraisal_period_to field!</li>";
      valid = false;
      return false;
  }
}
if ( document.myForm.emp_id.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.emp_id.focus();
      document.myForm.emp_id.style.border="solid 1px red";
      msg+="<li>You need to fill the emp_id field!</li>";
      valid = false;
      return false;
  }
}
if ( document.myForm.emp_appraiser_user_id.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.emp_appraiser_user_id.focus();
      document.myForm.emp_appraiser_user_id.style.border="solid 1px red";
      msg+="<li>You need to fill the emp_appraiser_user_id field!</li>";
      valid = false;
      return false;
  }
}
if ( document.myForm.txt_appraiser_code.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.txt_appraiser_code.focus();
      document.myForm.txt_appraiser_code.style.border="solid 1px red";
      msg+="<li>You need to fill the txt_appraiser_code field!</li>";
      valid = false;
      return false;
  }
}
if (!valid){
    msg+="</ul>";
    //console.log("Hello Bd");
    var div = document.getElementById('errors').innerHTML=msg;
    document.getElementById("errors").style.display = 'block';
    return false;
}

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
                    // echo "<pre>";
                    //                                       print_r($emp_info['emp_name']);
                    //                                       echo "</pre>";
                                                          //die();
            if($performance_id_data){
            $emp_content_id=$performance_id_data['content_id'];
            $emp_info=$this->search_field_emp_model->getallsearch_table_contentByid($emp_content_id);
            $emp_appraiser_content_id=$performance_id_data['emp_appraiser_name'];
            $emp_appraiser_info=$this->search_field_emp_model->getallsearch_table_contentByid($emp_appraiser_content_id);
            }
            
            ?>
            <div class="row under-header-bar text-center"> 
                <h4>Add Employee Performance Appraisal</h4>         
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
                                        <div class="row">
                                            <div class="col-md-12 border_left_0"><h4>General Information</h4> </div>
                                        </div>  
                                        <div class="row">
                                            <div class="col-md-3 padding_6 border_left_0" style="font-size:15px;">Appraisal Period From </div>
                                            <div class="col-md-3 padding_0"><input type="text" readonly="readonly" name="appraisal_period_from" id="appraisal_period_from" value="<?php if($performance_id_data){ print $performance_id_data['appraisal_period_from'];} ?>"/></div>
                                            <div class="col-md-3 padding_6">To </div>
                                            <div class="col-md-3 padding_0"><input type="text" readonly="readonly" name="appraisal_period_to" id="appraisal_period_to" value="<?php if($performance_id_data){ echo $performance_id_data['appraisal_period_to'];} ?>"/> </div>
                                        </div>                                            
                                        <div class="row">
                                            <div class="col-md-3 padding_6 border_left_0">Name of Employee </div>
                                            <div class="col-md-3 padding_0">
                                                <select name="emp_id" id="emp_id">
                                                    <option value="">Select</option>
                                                    <?php foreach ($allemployee as $single_employee) {
                                                        $content_id=$single_employee['content_id'];
                                                        $emp_id=$single_employee['emp_id'];
                                                        $emp_name=$single_employee['emp_name'];
                                                        $has_performance=$this->emp_performance_model->getperfomanceidByidandempcode($performance_id, $content_id, $user_data['id']);
                                                        if(!$has_performance){
                                                        if($emp_info['emp_id']==$emp_id){
                                                            print '<option value="'.$emp_id.'" selected="selected">'.$emp_name.'-'.$emp_id.'</option>';
                                                        }else{
                                                            print '<option value="'.$emp_id.'">'.$emp_name.'-'.$emp_id.'</option>';
                                                        }
                                                      }
                                                    } ?>

                                                </select>                                                
                                            </div>
                                            <div class="col-md-3 padding_6">Name of Appraiser</div>
                                            <div class="col-md-3 padding_0">
                                                <select name="emp_appraiser_user_id" id="emp_appraiser_user_id" readonly="readonly">
                                                    <?php 
                                                      if($user_data['name']){
                                                          print '<option value="'.$user_data['id'].'" selected="selected">'.$user_data['name'].'</option>';
                                                       }
                                                     ?>

                                                </select>
                                            </div>
                                        </div>  
                                        <div class="row">
                                            <div class="col-md-3 padding_6 border_left_0">Employee Code </div>
                                            <div class="col-md-3 padding_0"><input type="text" name="txt_employee_code" readonly="readonly" id="txt_employee_code" value=""/></div>
                                            <div class="col-md-3 padding_6">Appraiser Code </div>
                                            <div class="col-md-3 padding_0"><input type="text" name="txt_appraiser_code" readonly="readonly" id="txt_appraiser_code" value="<?php if($user_data['employee_id']){ echo $user_data['employee_id'];} ?>"/> </div>
                                        </div>                                           
                                        <div class="row">
                                            <div class="col-md-3 padding_6 border_left_0">Designation </div>
                                            <div class="col-md-3 padding_0">
                                                <select name="emp_designation" id="emp_designation" disabled="disabled">
                                                    <option value="">Select Designation</option>
                                                    <?php foreach ($alljobtitle as $single_jobtitle) {
                                                        if($emp_info['emp_post_id']==$single_jobtitle['tid']){
                                                            echo '<option value="'.$single_jobtitle['tid'].'" selected="selected">'.$single_jobtitle['name'].'</option>';
                                                        }else{
                                                            echo '<option value="'.$single_jobtitle['tid'].'">'.$single_jobtitle['name'].'</option>';
                                                        }
                                                    } ?>
                                                </select> 
                                            </div>
                                            <div class="col-md-3 padding_6">Designation </div>
                                            <div class="col-md-3 padding_0">
                                                <select name="emp_appraiser_designation" id="emp_appraiser_designation" disabled="disabled">
                                                    <?php 

                                                        if($emp_information['emp_post_id']){
                                                          $post_supervisor = $this->taxonomy->getTaxonomyBytid($emp_information['emp_post_id']); 
                                                            echo '<option value="'.$post_supervisor['tid'].'" selected="selected">'.$post_supervisor['name'].'</option>';
                                                        }
                                                     ?>
                                                </select>  
                                            </div>
                                        </div>  
                                        <div class="row">
                                            <div class="col-md-3 padding_6 border_left_0">Department </div>
                                            <div class="col-md-3 padding_0">
                                                <select name="emp_department" id="emp_department" disabled="disabled">
                                                    <option value="">Select Department</option>
                                                    <?php foreach ($alldepartment as $single_department) {
                                                        if($emp_info['emp_department']==$single_department['tid']){
                                                            echo '<option value="'.$single_department['tid'].'" selected="selected">'.$single_department['name'].'</option>';
                                                        }else{
                                                            echo '<option value="'.$single_department['tid'].'">'.$single_department['name'].'</option>';
                                                        }
                                                    } ?>
                                                </select>                                                 
                                            </div>
                                            <div class="col-md-3 padding_6">Department </div>
                                            <div class="col-md-3 padding_0">
                                                <select name="emp_appraiser_department" id="emp_appraiser_department" disabled="disabled">
                                                    <?php if($emp_information['emp_department']){
                                                          $department_supervisor = $this->taxonomy->getTaxonomyBytid($emp_information['emp_department']); 
                                                            echo '<option value="'.$department_supervisor['tid'].'" selected="selected">'.$department_supervisor['name'].'</option>';
                                                        }
                                                        ?>
                                                </select>                                             
                                            </div>
                                        </div>                                                                                                                                                                                                
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
                                                $child_data_counter=count($criteria_data);
                                                foreach ($criteria_data as $single_criteria) {
                                                 $single_criteria_name = $single_criteria['name'];
                                                 $single_criteria_machine_name = $single_criteria['url_path'];
                                                    if($performance_id){
                                                        $performance_value=$this->emp_performance_model->getperfomanceByidandfieldname($performance_id, $single_criteria_machine_name);
                                                        $comment_machine_name=$single_criteria_machine_name.'_comment';
                                                        $performance_value_comment=$this->emp_performance_model->getperfomanceByidandfieldname($performance_id, $comment_machine_name);
                                                    }                                                 
                                                 if($child_loop_counter==1){
                                                    
                                                   ?>
                                                   <tr>
                                                    <td class="text-left"><?php print $single_criteria_name; ?></td>
                                                    <td rowspan="<?php print $child_data_counter; ?>"><span id="<?php print $machine_name_category; ?>_parcentage"><?php print $criteriatype_weight_age; ?></span></td>
                                                    <td><input type="radio" value="4" name="rating[<?php print $single_criteria_machine_name; ?>]"></td>
                                                    <td><input type="radio" value="3" name="rating[<?php print $single_criteria_machine_name; ?>]"></td>
                                                    <td><input type="radio" value="2" name="rating[<?php print $single_criteria_machine_name; ?>]" ></td>
                                                    <td><input type="radio" value="1" name="rating[<?php print $single_criteria_machine_name; ?>]" ></td>
                                                    <td><input type="radio" value="0" name="rating[<?php print $single_criteria_machine_name; ?>]" ></td>
                                                    <td rowspan="<?php print $child_data_counter; ?>"><span id="<?php print $machine_name_category; ?>_total"></span></td>
                                                    <td style="padding:0px"><input type="text" id="<?php print $single_criteria_machine_name; ?>_comment" name="rating[<?php print $single_criteria_machine_name; ?>_comment]" ></td>
                                                </tr> 

                                                <?php
                                            }else{
                                                ?>
                                                <tr>
                                                    <td class="text-left"><?php print $single_criteria_name; ?></td>
                                                    <td><input type="radio" value="4" name="rating[<?php print $single_criteria_machine_name; ?>]"></td>
                                                    <td><input type="radio" value="3" name="rating[<?php print $single_criteria_machine_name; ?>]"></td>
                                                    <td><input type="radio" value="2" name="rating[<?php print $single_criteria_machine_name; ?>]"></td>
                                                    <td><input type="radio" value="1" name="rating[<?php print $single_criteria_machine_name; ?>]"></td>
                                                    <td><input type="radio" value="0" name="rating[<?php print $single_criteria_machine_name; ?>]"></td>
                                                    <td style="padding:0px"><input type="text" id="<?php print $single_criteria_machine_name; ?>_comment" name="rating[<?php print $single_criteria_machine_name; ?>_comment]" ></td>
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
                                <td><span id="obtain_total_score"></span></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-2"><br><input type="submit" id="add_performance_btn" value="Submit"></div>
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