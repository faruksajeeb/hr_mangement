<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Task Type</title>
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
                $("#task_name").keyup(function () {
                    var textValue = $(this).val();
                    textValue =textValue.replace(/ /g,"_");
                    var val_lowercase=textValue.toLowerCase();
                    $("#task_machine_name").val(val_lowercase);
                });                

            });

function validate() {
  var valid = true;
  var msg="<ul>";
  if ( document.myForm.task_name.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.task_name.focus();
      document.myForm.task_name.style.border="solid 1px red";
      msg+="<li>You need to fill the task_name field!</li>";
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
                <h4>Add Task Type</h4>         
            </div>  
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url(); ?>user/addtasktype" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
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
                                        <div class="col-md-3 bgcolor_D8D8D8">Task Name:</div>
                                        <div class="col-md-9"><input type="text" name="task_name" id="task_name" placeholder="e.g. Add Profile" value="<?php print $toedit_records['name']; ?>"></div>
                                    </div>                                                                                                              
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Task Machine Name:</div>
                                        <div class="col-md-9">
                                        <input type="text" name="task_machine_name" readonly="readonly" id="task_machine_name" placeholder="e.g. add_profile" value="<?php print $toedit_records['description']; ?>">
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
                                    <th>Task Name</th>
                                    <th>Machine Name</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>Task Name</th>
                                    <th>Machine Name</th>
                                    <th>Edit</th>
                                </tr>
                            </tfoot>

                            <tbody>
                                <?php
                                foreach ($alltask as $single_tasktype) {
                                    $id = $single_tasktype['id'];
                                    $task_name = $single_tasktype['name'];
                                    $vid = $single_tasktype['vid'];
                                    $tid = $single_tasktype['tid'];
                                    $description = $single_tasktype['description'];
                                    ?>
                                    <tr>
                                        <td><?php print $task_name; ?></td>
                                        <td><?php print $description; ?></td>
                                        <td>
                                            <a href="<?php echo site_url("user/addtasktype") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit ev" /></a>
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