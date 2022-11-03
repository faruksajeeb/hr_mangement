<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Division</title>
         <!--chosen--> 
        <link rel="stylesheet" href="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.css">
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
if ( document.myForm.company_name.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.company_name.focus();
      document.myForm.company_name.style.border="solid 1px red";
      msg+="<li>You need to fill the company name field!</li>";
      valid = false;
      return false;
  }
} 
if ( document.myForm.division_name.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.division_name.focus();
      document.myForm.division_name.style.border="solid 1px red";
      msg+="<li>You need to fill the division name field!</li>";
      valid = false;
      return false;
  }
} 
if ( document.myForm.short_name.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.short_name.focus();
      document.myForm.short_name.style.border="solid 1px red";
      msg+="<li>You need to fill the short_name field!</li>";
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
                <h4>Add Division</h4>         
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url(); ?>addtaxonomy/addDivision" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                            <div class="row success-err-sms-area">
                                <div class="col-md-12">
                                    <input type="hidden" name="division_id" id="division_id" value="<?php print $id; ?>">
                                    <div id="errors"></div>
                                    <?php echo $error; ?>
                                    <?php echo $msg; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Division Head Name</div>
                                        <div class="col-md-9">
                                            <select name="emp_name" id="emp_name" class="chosen-select form-control">
                                                <option value="">Select</option>
                                                <?php
                                                
                                                foreach ($employees as $single_employee) {
                                                    $default_emp_id=$default_emp['emp_id'];
                                                    $content_id=$single_employee['content_id'];
                                                    $emp_id=$single_employee['emp_id'];
                                                    $emp_name=$single_employee['emp_name'];
                                                    if($default_emp_id==$emp_id){
                                                        print '<option value="'.$emp_id.'" selected="selected">'.$emp_name.' - '.$emp_id.'</option>';
                                                    }else{
                                                        print '<option value="'.$emp_id.'">'.$emp_name.' - '.$emp_id.'</option>';
                                                    }

                                                } ?>

                                            </select>
                                        </div>
                                    </div>                                 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Company Name:</div>
                                        <div class="col-md-9">
                                            <select name="company_name" id="company_name">
                                                <option value="">Select Company</option>
                                                <?php
                                                foreach ($companies as $company) {
                                                    if ($toedit_records['parents_term'] == $company['tid']) {
                                                        echo '<option value="' . $company['tid'] . '" selected="selected">' . $company['name'] . '</option>';
                                                    } else {
                                                        echo '<option value="' . $company['tid'] . '">' . $company['name'] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>        
                                        </div>
                                    </div>                                
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Division Name:</div>
                                        <div class="col-md-9"><input type="text" name="division_name" id="division_name" placeholder="e.g. Block Division" value="<?php print $toedit_records['name']; ?>"></div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Short Name:</div>
                                        <div class="col-md-9"><input type="text" name="short_name" id="short_name" placeholder="e.g. cocl" value="<?php print $toedit_records['keywords']; ?>"></div>
                                    </div>                                      
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Division Location:</div>
                                        <div class="col-md-9"><input type="text" name="division_location" id="division_location" value="<?php print $toedit_records['url_path']; ?>"></div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Division Phone:</div>
                                        <div class="col-md-9"><input type="text" name="division_phone" id="division_phone" value="<?php print $toedit_records['page_title']; ?>"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Division Email:</div>
                                        <div class="col-md-9"><input type="text" name="division_email" id="division_email" value="<?php print $toedit_records['page_description']; ?>"></div>
                                    </div>                                                                                                                
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Description:</div>
                                        <div class="col-md-9">
                                            <textarea placeholder="Optional" name="division_description" id="division_description" cols="30" rows="10"><?php print $toedit_records['description']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Status:</div>
                                        <div class="col-md-9">
                                            <select name="status" id="status">
                                                <option value="1" <?php if($toedit_records['status']==1){ echo "selected";} ?>>Active</option>
                                                <option value="0" <?php if($toedit_records['status']==0){ echo "selected";} ?>>Inactive</option>                                               
                                            </select>        
                                        </div>
                                    </div>
                                    <div class="row top10 bottom10">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-9"><input type="submit" name="add_division_btn" value="Submit"></div>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </form>
                        <table id="example" class="display" cellspacing="0" width="100%" border="1">
                            <thead>
                                <tr class="heading">
                                    <th>ID</th>
                                    <th>Company Name</th>
                                    <th>Division Name</th>
                                    <th>Short Name</th>
                                    <th>Division Head Name</th>
                                    <th>Division Location</th>
                                    <th>Division Phone</th>
                                    <th>Division Email</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Company Name</th>
                                    <th>Department Name</th>
                                    <th>Short Name</th>
                                    <th>Division Head Name</th>                                    
                                    <th>Division Location</th>
                                    <th>Division Phone</th>
                                    <th>Division Email</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                foreach ($divisions as $division) {
                                    $parents_term=$division['parents_term'];
                                    $department_head_employee_id=$division['weight'];
                                    $emp_info=$this->search_field_emp_model->getallsearch_table_contentByid($department_head_employee_id);
                                    $division_data=$this->taxonomy->getTaxonomybyid($parents_term);                                    
                                    ?>
                                    <tr>
                                        <td><?php echo $division['id']; ?></td>
                                        <td><?php echo $division_data['name']; ?></td>
                                        <td><?php echo $division['name']; ?></td>
                                        <td><?php echo $division['keywords']; ?></td>
                                        <td><?php echo $emp_info['emp_name']; ?></td>
                                        <td><?php echo $division['url_path']; ?></td>
                                        <td><?php echo $division['page_title']; ?></td>
                                        <td><?php echo $division['page_description']; ?></td>
                                        <td><?php echo $division['description']; ?></td>
                                        <td><?php
                                            if($division['status']==1){
                                                echo "active";
                                            }else{
                                                echo "Inactive";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url("addtaxonomy/addDivision") . '/' . $division['id']; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit ev" /></a>
                                                                                        <a href="<?php echo site_url("deletecontent/deletetaxonomy") . '/' . $division['id']; ?>" class="operation-cut operation-link" onClick="return ConfirmDelete()"> <img src="<?php echo base_url(); ?>resources/images/cut.jpg" alt="edit" /></a>
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
                <!--Chosen--> 
        <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
    </body>
    </html>