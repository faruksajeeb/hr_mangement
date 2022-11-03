<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Performance Criteria Category</title>
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
  if ( document.myForm.criteriacategory.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.criteriacategory.focus();
    document.myForm.criteriacategory.style.border="solid 1px red";
    msg+="<li>You need to fill the criteriacategory field!</li>";
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
                <h4>Add Performance Criteria Category</h4>         
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url(); ?>addtaxonomy/addperformancecriteriacategory" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
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
                                        <div class="col-md-3 bgcolor_D8D8D8">Criteria Serial:</div>
                                        <div class="col-md-9"><input type="text" name="criteriacategory_serial" id="criteriacategory_serial" placeholder="e.g. 1" value="<?php print $toedit_records['weight']; ?>"></div>
                                    </div>                                                                     
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Criteria Type:</div>
                                        <div class="col-md-9"><input type="text" name="criteriacategory" id="criteriacategory" placeholder="e.g. Quality of Work" value="<?php print $toedit_records['name']; ?>"></div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Criteria Weight-age:</div>
                                        <div class="col-md-9"><input type="text" name="criteriacategory_weight_age" id="criteriacategory_weight_age" placeholder="e.g. 30%" value="<?php print $toedit_records['url_path']; ?>"></div>
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
                                    <th>Criteria Serial</th>
                                    <th>Criteria Type</th>
                                    <th>Criteria Weight-age</th>
                                    <th>Description</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>Criteria Serial</th>
                                    <th>Criteria Type</th>
                                    <th>Criteria Weight-age</th>
                                    <th>Description</th>
                                    <th>Edit</th>
                                </tr>
                            </tfoot>

                            <tbody>
                                <?php
                                foreach ($allcriteriacategory as $single_criteriatype) {
                                    $id = $single_criteriatype['id'];
                                    $criteriacategory = $single_criteriatype['name'];
                                    $vid = $single_criteriatype['vid'];
                                    $tid = $single_criteriatype['tid'];
                                    $description = $single_criteriatype['description'];
                                    $criteriatype_serial = $single_criteriatype['weight'];
                                    $criteriatype_weight_age = $single_criteriatype['url_path'];
                                    ?>
                                    <tr>
                                        <td><?php print $criteriatype_serial; ?></td>
                                        <td><?php print $criteriacategory; ?></td>
                                        <td><?php print $criteriatype_weight_age; ?></td>
                                        <td><?php print $description; ?></td>
                                        <td>
                                            <a href="<?php echo site_url("addtaxonomy/addperformancecriteriacategory") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit ev" /></a>
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