<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add User Role</title>
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
                $("#user_role").keyup(function () {
                    var textValue = $(this).val();
                    textValue =textValue.replace(/ /g,"_");
                    var val_lowercase=textValue.toLowerCase();
                    $("#task_machine_name").val(val_lowercase);
                });                

            });

function validate() {
  var valid = true;
  var msg="<ul>";
  if ( document.myForm.user_role.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.user_role.focus();
      document.myForm.user_role.style.border="solid 1px red";
      msg+="<li>You need to fill the user_role field!</li>";
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
                <h4>Add User Role</h4>         
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url(); ?>user/adduserrole" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
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
                                        <div class="col-md-3 bgcolor_D8D8D8">User Role:</div>
                                        <div class="col-md-9"><input type="text" name="user_role" id="user_role" placeholder="e.g. Admin" value="<?php print $toedit_records['user_type']; ?>"></div>
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
                                    <th>User Role</th>
                                    <th>Description</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>User Role</th>
                                    <th>Description</th>
                                    <th>Edit</th>
                                </tr>
                            </tfoot>

                            <tbody>
                                <?php
                                foreach ($alluserrole as $single_userrole) {
                                    $id = $single_userrole['id'];
                                    $user_role = $single_userrole['user_type'];
                                    $description = $single_userrole['description'];
                                    ?>
                                    <tr>
                                        <td><?php print $user_role; ?></td>
                                        <td><?php print $description; ?></td>
                                        <td>
                                            <a href="<?php echo site_url("user/adduserrole") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit ev" /></a>
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