<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Open A Performance Session</title>
    <?php
    $this->load->view('includes/cssjs');
    $user_type = $this->session->userdata('user_type');
    ?> 

    <script>
        $(document).ready(function(){
                // Setup - add a text input to each footer cell
                $('#example tfoot th').each(function () {
                    var title = $('#example thead th').eq($(this).index()).text();
                    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
                });

                // DataTable
                var table = $('#example').DataTable({
                            "bSort": false
                          });

                // Apply the search
                table.columns().eq(0).each(function (colIdx) {
                    $('input', table.column(colIdx).footer()).on('keyup change', function () {
                        table
                                .column(colIdx)
                                .search(this.value)
                                .draw();
                    });
                });


$( "#emp_division" ).change(function(e) {
    var division_tid = $(this).val(); 
    var base_url='<?php echo base_url();?>';
    var postData = {
        "division_tid" : division_tid
    };
    $.ajax({
        type: "POST",
        url: ""+base_url+"addprofile/getdepartmentidbydivisionid",
        data: postData,
        dataType:'json',
        success: function(data){
    // console.log(data);
    var options="";
    options += '<option value="">Select Department</option>';
    $(data).each(function(index, item) {
        options += '<option value="' + item.tid + '">' + item.name + '</option>'; 
    });
    $('#emp_department').html(options);    
}
});
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
  // if ( document.myForm.bankname.value == "" ) {
  //   if (valid){ //only receive focus if its the first error
  //     document.myForm.bankname.focus();
  //   document.myForm.bankname.style.border="solid 1px red";
  //   msg+="<li>You need to fill the bankname field!</li>";
  //   valid = false;
  //   return false;
  // }
  // } 

  if (!valid){
    msg+="</ul>";
    //console.log("Hello Bd");
    var div = document.getElementById('errors').innerHTML=msg;
    document.getElementById("errors").style.display = 'block';
    return false;
  }
  
}        
    </script>    
</head>
<body class="logged-in dashboard current-page add-division">
    <!-- Page Content -->  
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php 
            $this -> load -> view('includes/menu');
            date_default_timezone_set('Asia/Dhaka');
            $servertime = time();
            $today = date("d-m-Y", $servertime);
            ?>
            <div class="row under-header-bar text-center"> 
                <h4>Performance Session</h4>         
            </div>  
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                    <?php if ($user_type == 1 ) { ?> 
                        <form action="<?php echo base_url(); ?>empperformance/searchempperformance" method="post" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default" style="margin-top: 15px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Search by Multiple Options</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- sfsaf -->                                                                                       
                                             <div class="row">
                                                <div class="col-md-4">Performance Title:</div>
                                                <div class="col-md-8">
                                                <select name="Performance_Title" id="Performance_Title">
                                                <option value="">Select Performance Title</option>
                                                    <?php
                                                    foreach ($all_performance_title as $single_performance_id) {
                                                    $id = $single_performance_id['id'];
                                                    $Performance_Title = $single_performance_id['Performance_Title'];
                                                    ?>
                                                    <option value="<?php print $id; ?>"><?php print $Performance_Title; ?></option>
                                                   <?php } ?>
                                                  </select>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">Evaluation Period From:</div>
                                                <div class="col-md-8"><input type="text" class="datepicker numbersOnly" name="Evaluation_Period_From" id="Evaluation_Period_From" placeholder="dd-mm-yyyy"></div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-4">Division Name:</div>
                                                <div class="col-md-8">
                                                  <select name="emp_division" id="emp_division">
                                                    
                                                    <?php 
                                                 if($user_type_id !=1){
                                                                // echo '<option value="'.$alldivision['tid'].'" selected="selected" data-id="'.$alldivision['weight'].'">'.$alldivision['name'].'</option>';
                                                             }else{
                                                                echo '<option value="">Select Division</option>';
                                                            
                                                    foreach ($alldivision as $single_division) {
                                                      if($emp_division==$single_division['tid']){
                                                        echo '<option value="'.$single_division['tid'].'" selected="selected">'.$single_division['name'].'</option>';
                                                      }else{
                                                        echo '<option value="'.$single_division['tid'].'">'.$single_division['name'].'</option>';
                                                      }
                                                    } }
                                                    ?>
                                                  </select>                     
                                                </div>
                                            </div> 
                                             
                                                                                                                                                       
                                            <!-- sldks -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- sjdksjd -->                                                                                                                                                                                                          

                                            <div class="row">
                                                <div class="col-md-4">Appraisor:</div>
                                                <div class="col-md-8">
                                                    <select name="appraisor_usr_id" id="appraisor_usr_id">
                                                    <option value="">Select Appraisor</option>
                                                        <?php
                                                    foreach ($all_appraisor as $single_appraisor) {
                                                    // $id = $single_appraisor['id'];
                                                    $appraisor_usr_id = $single_appraisor['appraisor_usr_id'];
                                                    $emp_data=$this->users_model->getuserbyid($appraisor_usr_id);
                                                    ?>
                                                    <option value="<?php print $appraisor_usr_id; ?>"><?php print $emp_data['name']; ?></option>
                                                   <?php } ?>
                                                   </select>
                                                </div>
                                            </div>  

                                            <div class="row">
                                                <div class="col-md-4">Evaluation Period Till:</div>
                                                <div class="col-md-8"><input type="text" class="datepicker numbersOnly" name="Evaluation_Period_Till" id="Evaluation_Period_Till" placeholder="dd-mm-yyyy"></div>
                                            </div>   
                                            <div class="row">
                                                <div class="col-md-4">Department Name:</div>
                                                <div class="col-md-8">
                                                  <select name="emp_department" id="emp_department">
                                                    <option value="">Select Department</option>
                                                    <?php 

                                                    foreach ($department_selected as $single_department) {
                                                      if($emp_department==$single_department['tid']){
                                                        echo '<option value="'.$single_department['tid'].'" selected="selected">'.$single_department['name'].'</option>';
                                                    }else{
                                                        echo '<option value="'.$single_department['tid'].'">'.$single_department['name'].'</option>';
                                                      }
                                                    } 
                                                    ?>
                                                  </select>                       
                                                </div>
                                            </div>                                                                                                                                                                            
                                            <!-- kdjsfkd -->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5"></div>
                                        <div class="col-md-2"><input type="submit" name="multiple_search_btn" value="Search" id="search_button"></div>
                                        <div class="col-md-5"></div>
                                    </div>
                                </div>
                            </div>                                  
                        </div>
                    </div>
                        </form>
                        <?php } 
                        // echo "<pre>";
                        // print_r($all_performance_title);
                        // echo "</pre>";
                        ?>

                        <table id="example" class="display" cellspacing="0" width="100%" border="1">
                            <thead>
                                <tr class="heading">
                                    <th>Emp Name</th>
                                    <th>Emp Division</th>                                
                                    <th>Appraisor Name</th>
                                    <th>Performance Title</th>
                                    <th>Evaluation Period From</th>
                                    <th>Evaluation Period Till</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>Emp Name</th>
                                    <th>Emp Division</th>                                
                                    <th>Appraisor Name</th>
                                    <th>Performance Title</th>
                                    <th>Evaluation Period From</th>
                                    <th>Evaluation Period Till</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>

                            <tbody>
                                <?php
                                
                                foreach ($records as $single_performance_id) {
                                    $id = $single_performance_id['id'];
                                    $per_main_id = $single_performance_id['per_main_id'];
                                    $appraisor_usr_id = $single_performance_id['appraisor_usr_id'];
                                    $to_emp_id = $single_performance_id['to_emp_id'];
                                    $emp_data=$this->users_model->getuserbyid($appraisor_usr_id);
                                    $to_emp_data=$this->search_field_emp_model->getallsearch_table_contentByid($to_emp_id);
                                
                                    $performace_id_data=$this->emp_performance_model->getperfomanceidByid($per_main_id);
                                    $Performance_Title = $performace_id_data['Performance_Title'];
                                    $appraisal_period_from = $performace_id_data['appraisal_period_from'];
                                    $appraisal_period_to = $performace_id_data['appraisal_period_to'];
                                    $Last_Date_Submission = $performace_id_data['Last_Date_Submission'];
                                    $Status = $performace_id_data['Status'];
                                    $Remarks = $performace_id_data['Remarks'];
                                    $division_data=$this->taxonomy->getTaxonomyBytid($to_emp_data['emp_division']); 
                                    ?>
                                    <tr>
                                        <td><?php print $to_emp_data['emp_name'].'-'.$to_emp_data['emp_id']; ?></td>
                                        <td><?php print $division_data['name']; ?></td>
                                        <td><?php print $emp_data['name']; ?></td>
                                        <td><?php print $Performance_Title; ?></td>
                                        <td><?php print $appraisal_period_from; ?></td>
                                        <td><?php print $appraisal_period_to; ?></td>
                                        <td><?php print $Remarks; ?></td>
                                        <td>
                                        <a href="<?php echo site_url("empperformance/viewsingleperformance/$id") ; ?>" target="_blank" class="operation-print-pdf operation-link"> <img src="<?php echo base_url(); ?>resources/images/pdf_icon_print.png" alt="pdf" style="width:20px;"/></a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table> 
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <nav>
                            <?php print $this->pagination->create_links(); ?>
                            </nav>
                        </div>
                    </div>                       
                        </div>
                    </div>              
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->        
    </body>
    </html>