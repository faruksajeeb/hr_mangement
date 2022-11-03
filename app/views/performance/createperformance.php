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
                        <form action="<?php echo base_url(); ?>empperformance/createperformance" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                            <div class="row success-err-sms-area">
                                <div class="col-md-12">
                                    <input type="hidden" name="performance_id" id="performance_id" value="<?php print $performance_id_data['id']; ?>">
                                    <div id="errors"></div>
                                    <?php echo $error; ?>
                                    <?php echo $msg; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Performance Title:</div>
                                        <div class="col-md-9"><input type="text" name="Performance_Title" id="Performance_Title" placeholder="e.g. Performance for January 2016" value="<?php print $performance_id_data['Performance_Title']; ?>"></div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Evaluation Period From:</div>
                                        <div class="col-md-9"><input type="text" name="Evaluation_Period_From" id="Evaluation Perio_ From" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php print $performance_id_data['appraisal_period_from']; ?>"></div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Evaluation Period Till:</div>
                                        <div class="col-md-9"><input type="text" name="Evaluation_Period_Till" id="Evaluation_Period_Till" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php print $performance_id_data['appraisal_period_to']; ?>"></div>
                                    </div>   
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Last Date of Submission:</div>
                                        <div class="col-md-9"><input type="text" name="Last_Date_of_Submission" id="Last_Date_of_Submission" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php print $performance_id_data['Last_Date_Submission']; ?>"></div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Status:</div>
                                        <div class="col-md-9">
                                            <select name="performance_status" id="performance_status">
                                                    <option value="1" <?php if ($performance_id_data['Status']=='1'){ echo 'selected="selected"';} ?>>Active</option>
                                                    <option value="0" <?php if ($performance_id_data['Status']=='0'){ echo 'selected="selected"';} ?>>Inactive</option>
                                            </select>
                                        </div>
                                    </div>                                                                                                                                                                                                                      
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Description:</div>
                                        <div class="col-md-9">
                                            <textarea placeholder="Optional" name="description" id="description" cols="30" rows="10"><?php print $performance_id_data['Remarks']; ?></textarea>
                                        </div>
                                    </div>            
                                    <div class="row top10 bottom10">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-9"><input type="submit" name="add_btn" value="Submit"></div>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
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
                                    <th>Performance Title</th>
                                    <th>Evaluation Period From</th>
                                    <th>Evaluation Period Till</th>
                                    <th>Last Date of Submission</th>
                                    <?php if ($user_type == 1 ) { ?> 
                                    <th>Status</th>
                                    <?php } ?>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>Performance Title</th>
                                    <th>Evaluation Period From</th>
                                    <th>Evaluation Period Till</th>
                                    <th>Last Date of Submission</th>
                                    <?php if ($user_type == 1 ) { ?> 
                                    <th>Status</th>
                                    <?php } ?>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>

                            <tbody>
                                <?php
                                foreach ($all_performance_title as $single_performance_id) {
                                    $id = $single_performance_id['id'];
                                    $Performance_Title = $single_performance_id['Performance_Title'];
                                    $appraisal_period_from = $single_performance_id['appraisal_period_from'];
                                    $appraisal_period_to = $single_performance_id['appraisal_period_to'];
                                    $Last_Date_Submission = $single_performance_id['Last_Date_Submission'];
                                    $Status = $single_performance_id['Status'];
                                    $Remarks = $single_performance_id['Remarks'];
                                    ?>
                                    <tr>
                                        <td><?php print $Performance_Title; ?></td>
                                        <td><?php print $appraisal_period_from; ?></td>
                                        <td><?php print $appraisal_period_to; ?></td>
                                        <td><?php print $Last_Date_Submission; ?></td>
                                        <?php if ($user_type == 1 ) { ?> 
                                        <td><?php print $Status; ?></td>
                                        <?php } ?>
                                        <td><?php print $Remarks; ?></td>
                                        <td>
                                        <?php 

                                        if ($user_type == 1 && strtotime($Last_Date_Submission) >= strtotime($today)) { ?> 
                                            <a href="<?php echo site_url("empperformance/createperformance") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit ev" /></a>
                                        <?php } ?>
                                    <?php 
                                        if (strtotime($Last_Date_Submission) >= strtotime($today)) {  
                                    ?> 
                                            <a href="<?php echo site_url("empperformance/addempperformance") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/performance.png" alt="edit ev" /></a>
                                        <?php 
                                         }else{
                                            print "Expired!";
                                         } 
                                        ?>                                        
                                        </td>
                                    </tr>
                                    <?php } ?>
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