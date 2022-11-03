<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS- Department</title>
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
                var table = $('#example').DataTable({
                    stateSave: true
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
          if ( document.myForm.department_name.value == "" ) {
            if (valid){ //only receive focus if its the first error
              document.myForm.department_name.focus();
              document.myForm.department_name.style.border="solid 1px red";
              msg+="<li>You need to fill the department_name field!</li>";
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
                <h4>Department</h4>         
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-4 col-xs-12 add-form">
                        <div class="row add-form-heading">
                            <div class="col-md-12 "><span class="glyphicon glyphicon-plus-sign"> </span> Add Department</div>
                        </div>
                         <form action="<?php echo base_url(); ?>addtaxonomy/addDepartment" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                            <div class="row success-err-sms-area">
                                <div class="col-md-12">
                                    <input type="hidden" name="content_id" id="content_id" value="<?php print $id; ?>">
                                    <div id="errors"></div>
                                    <?php echo $error; ?>
                                    <?php echo $msg; ?>
                                </div>
                            </div>
                            <div class="row">
                                
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Department Name:</div>
                                        <div class="col-md-9"><input type="text" name="department_name" id="department_name" placeholder="e.g. Accounts" value="<?php print $toedit_records['name']; ?>"></div>
                                    </div>                                                                                                              
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Description:</div>
                                        <div class="col-md-9">
                                            <textarea placeholder="Optional" name="description" id="description" cols="30" rows="10"><?php print $toedit_records['description']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Status:</div>
                                        <div class="col-md-9">
                                            <select name="status" id="status">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row top10 bottom10">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-9"><input type="submit" name="add_btn" value="Submit"></div>
                                    </div>
                               
                            </div>
                         </form>
                         
                    </div>
                    <div class="col-md-8 col-xs-12 display-list">
                        <div class="row display-list-heading">
                            <div class="col-md-12 "><span class="glyphicon glyphicon-list"> </span> Department List</div>
                        </div>
                           <table id="example" class="display" cellspacing="0" width="100%" border="1">
                            <thead>
                                <tr class="heading">
                                    <th>Department Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>Department Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>

                            <tbody>
                                <?php
                                foreach ($departments as $single_depatment_name) {
                                    $id = $single_depatment_name['id'];
                                    $depatment_name = $single_depatment_name['name'];
                                    $vid = $single_depatment_name['vid'];
                                    $tid = $single_depatment_name['tid'];
                                    $description = $single_depatment_name['description'];
                                    ?>
                                    <tr>
                                        <td><?php print $depatment_name; ?></td>
                                        <td><?php print $description; ?></td>
                                        <td>
                                            <?php
                                                if($single_depatment_name['status']==1){
                                                    echo '<label class="label label-success">Active</label>';
                                                }else{
                                                    echo '<label class="label label-danger">Inactive</label>';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                        <a class="btn btn-primary btn-xs" href="<?php echo site_url("addtaxonomy/addDepartment") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link">
                                            edit
                                        </a>
                                        
                                        <!--<a href="<?php echo site_url("deletecontent/deletetaxonomy") . '/' . $id; ?>" class="operation-cut operation-link" onClick="return ConfirmDelete()"> <img src="<?php echo base_url(); ?>resources/images/cut.jpg" alt="edit" /></a>-->
                                        
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