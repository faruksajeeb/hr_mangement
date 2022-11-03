<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS-Blood Group</title>
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
  if ( document.myForm.blood_group.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.blood_group.focus();
    document.myForm.blood_group.style.border="solid 1px red";
    msg+="<li>You need to fill the blood_group field!</li>";
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
                <h4>Blood Group</h4>         
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-4 col-xs-12 add-form">
                        <div class="row add-form-heading">
                            <div class="col-md-12 "><span class="glyphicon glyphicon-plus-sign"> </span> Add Blood Group</div>
                        </div>
                        <form action="<?php echo base_url(); ?>addtaxonomy/addblood_group" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
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
                                        <div class="col-md-3 bgcolor_D8D8D8">Blood Group:</div>
                                        <div class="col-md-9"><input type="text" name="blood_group" id="blood_group" placeholder="e.g. A+" value="<?php print $toedit_records['name']; ?>"></div>
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
                        </form>
                    </div>
                    <div class="col-md-8 col-xs-12 display-list">
                        <div class="row display-list-heading">
                            <div class="col-md-12 "><span class="glyphicon glyphicon-list"> </span> Blood Group List</div>
                        </div>
                          <table id="example" class="display" cellspacing="0" width="100%" border="1">
                            <thead>
                                <tr class="heading">
                                    <th>Blood Group</th>
                                    <th>Description</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>Blood Group</th>
                                    <th>Description</th>
                                    <th>Edit</th>
                                </tr>
                            </tfoot>

                            <tbody>
                                <?php
                                foreach ($allbloodgroup as $single_blood_group) {
                                    $id = $single_blood_group['id'];
                                    $blood_group = $single_blood_group['name'];
                                    $vid = $single_blood_group['vid'];
                                    $tid = $single_blood_group['tid'];
                                    $description = $single_blood_group['description'];
                                    ?>
                                    <tr>
                                        <td><?php print $blood_group; ?></td>
                                        <td><?php print $description; ?></td>
                                        <td>
                                            <a href="<?php echo site_url("addtaxonomy/addblood_group") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit ev" /></a>
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