<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Working Shift</title>
    <?php
    $this->load->view('includes/cssjs');
    ?> 

    <script>
        $(document).ready(function(){
                // Setup - add a text input to each footer cell
                $('#example tfoot th').each(function () {
                    var title = $('#example thead th').eq($(this).index()).text();
                    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
                });

                // DataTable
                var table = $('#example').DataTable();

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
          if ( document.myForm.working_shift.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.working_shift.focus();
      document.myForm.working_shift.style.border="solid 1px red";
      msg+="<li>You need to fill the working_shift field!</li>";
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
</head>
<body class="logged-in dashboard current-page add-division">
    <!-- Page Content -->  
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php 
            $this -> load -> view('includes/menu');
            ?>
            <div class="row under-header-bar text-center"> 
                <h4>Add Working Shift</h4>         
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url(); ?>addtaxonomy/addworkingshift" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                            <div class="row success-err-sms-area">
                                <div class="col-md-12">
                                    <input type="hidden" name="content_id" id="content_id" value="<?php print $id; ?>">
                                    <div id="errors"></div>
                                    <?php echo $error; ?>
                                    <?php echo $msg; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Shift Name:</div>
                                        <div class="col-md-9"><input type="text" name="working_shift" id="working_shift" placeholder="e.g. Morning Shift" value="<?php print $toedit_records['name']; ?>"></div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Attendance Required:</div>
                                        <div class="col-md-9">  
                                            <select name="attendance_required" id="attendance_required">
                                                <option value="Required" <?php if($toedit_records['parents_term']=='Required'){print 'selected="selected"';} ?>>Required</option>
                                                <option value="Not_Required" <?php if($toedit_records['parents_term']=='Not_Required'){print 'selected="selected"';} ?>>Not Required</option>
                                                <option value="Optional" <?php if($toedit_records['parents_term']=='Optional'){print 'selected="selected"';} ?>>Optional</option>
                                            </select>   
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Work Starting Time</div>
                                        <div class="col-md-9">
                                            <input type="text" placeholder="e.g. hh:mm:ss" name="emp_working_time_from" id="emp_working_time_from" value="<?php if($toedit_records['weight']){ echo $toedit_records['weight'];}else{ echo "09:30:00";} ?>"/>        
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Work Ending Time</div>
                                        <div class="col-md-9">
                                            <input type="text" name="emp_working_end_time" id="emp_working_end_time" placeholder="e.g. hh:mm:ss"  value="<?php if($toedit_records['url_path']){ echo $toedit_records['url_path'];}else{ echo "17:30:00";} ?>"/>        
                                        </div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Late Count Time</div>
                                        <div class="col-md-9">
                                            <input type="text" name="emp_latecount_time" id="emp_latecount_time" placeholder="e.g. hh:mm:ss"  value="<?php if($toedit_records['page_title']){ echo $toedit_records['page_title'];}else{ echo "09:46:00";} ?>"/>        
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Early Count Time</div>
                                        <div class="col-md-9">
                                            <input type="text" name="emp_earlycount_time" id="emp_earlycount_time" placeholder="e.g. hh:mm:ss"  value="<?php if($toedit_records['page_description']){ echo $toedit_records['page_description'];}else{ echo "17:20:00";} ?>"/>        
                                        </div>
                                    </div>                                              
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Logout Required</div>
                                        <div class="col-md-9">
                                            <select name="logout_required" id="logout_required">
                                                <option value="Required" <?php if($toedit_records['keywords']=='Required'){print 'selected="selected"';} ?>>Required</option>
                                                <option value="Not_Required" <?php if($toedit_records['keywords']=='Not_Required'){print 'selected="selected"';} ?>>Not Required</option>
                                                <option value="Optional" <?php if($toedit_records['keywords']=='Optional'){print 'selected="selected"';} ?>>Optional</option>
                                            </select>                                                           
                                        </div>
                                    </div>      
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Half Day Absent</div>
                                        <div class="col-md-9">
                                            <select name="half_day_absent" id="half_day_absent">
                                                <option value="Not_Eligible" <?php if($toedit_records['reserved1']=='Not_Eligible'){print 'selected="selected"';} ?>>Not Eligible</option>                                                      
                                                <option value="Eligible" <?php if($toedit_records['reserved1']=='Eligible'){print 'selected="selected"';} ?>>Eligible</option>
                                            </select>                                                           
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Absent Count Time</div>
                                        <div class="col-md-9">
                                            <input type="text" name="absent_count_time" id="absent_count_time" placeholder="e.g. hh:mm:ss"  value="<?php if($toedit_records['reserved2']){ echo $toedit_records['reserved2'];} ?>"/>                                                            
                                        </div>
                                    </div>                                                                                                                                                                                       
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Description:</div>
                                        <div class="col-md-9">
                                            <textarea placeholder="Optional" name="description" id="description" cols="30" rows="10"><?php print $toedit_records['description']; ?></textarea>
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
                        <table id="example" class="display" cellspacing="0" width="100%" border="1">
                            <thead>
                                <tr class="heading">
                                    <th>Shift Name</th>
                                    <th>Attendance Required</th>
                                    <th>Work Starting Time</th>
                                    <th>Work Ending Time</th>
                                    <th>Late Count Time</th>
                                    <th>Early Count Time</th>
                                    <th>Logout Required</th>
                                    <th>Half Day Absent</th>             
                                    <th>Absent Count Time</th>             
                                    <th>Description</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>Shift Name</th>
                                    <th>Attendance Required</th>
                                    <th>Work Starting Time</th>
                                    <th>Work Ending Time</th>
                                    <th>Late Count Time</th>
                                    <th>Early Count Time</th>
                                    <th>Logout Required</th>
                                    <th>Half Day Absent</th>             
                                    <th>Absent Count Time</th>             
                                    <th>Description</th>
                                    <th>Edit</th>
                                </tr>
                            </tfoot>

                            <tbody>
                                <?php
                                foreach ($allworkingshift as $single_workingshift) {
                                    $id = $single_workingshift['id'];
                                    $working_shift = $single_workingshift['name'];
                                    $vid = $single_workingshift['vid'];
                                    $tid = $single_workingshift['tid'];
                                    $description = $single_workingshift['description'];
                                    $attendance_required=$single_workingshift['parents_term'];
                                    $emp_working_time_from=$single_workingshift['weight'];
                                    $emp_working_end_time=$single_workingshift['url_path'];
                                    $emp_latecount_time=$single_workingshift['page_title'];
                                    $emp_earlycount_time=$single_workingshift['page_description'];
                                    $logout_required=$single_workingshift['keywords'];
                                    $half_day_absent=$single_workingshift['reserved1'];
                                    $absent_count_time=$single_workingshift['reserved2'];
                                    ?>
                                    <tr>
                                        <td><?php print $working_shift; ?></td>
                                        <td><?php print $attendance_required; ?></td>
                                        <td><?php print $emp_working_time_from; ?></td>
                                        <td><?php print $emp_working_end_time; ?></td>
                                        <td><?php print $emp_latecount_time; ?></td>
                                        <td><?php print $emp_earlycount_time; ?></td>
                                        <td><?php print $logout_required; ?></td>
                                        <td><?php print $half_day_absent; ?></td>
                                        <td><?php print $absent_count_time; ?></td>
                                        <td><?php print $description; ?></td>
                                        <td>
                                            <a href="<?php echo site_url("addtaxonomy/addworkingshift") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit ev" /></a>
                                            <a href="<?php echo site_url("deletecontent/deletetaxonomy") . '/' . $id; ?>" class="operation-cut operation-link" onClick="return ConfirmDelete()"> <img src="<?php echo base_url(); ?>resources/images/cut.jpg" alt="edit" /></a>
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