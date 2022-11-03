<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Company</title>
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
      msg+="<li>You need to fill the company_name field!</li>";
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
if ( document.myForm.company_code.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.company_code.focus();
      document.myForm.company_code.style.border="solid 1px red";
      msg+="<li>You need to fill the company_code field!</li>";
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
<body class="logged-in dashboard current-page add-company">
    <!-- Page Content -->  
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php 
            $this -> load -> view('includes/menu');
            ?>
            <div class="row under-header-bar text-center"> 
                <h4>Add Company</h4>         
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url(); ?>addtaxonomy/addCompany" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                            <div class="row success-err-sms-area">
                                <div class="col-md-12">
                                    <input type="hidden" name="company_id" id="company_id" value="<?php print $id; ?>">
                                    <div id="errors"></div>
                                    <?php echo $error; ?>
                                    <?php echo $msg; ?>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Company Head Name</div>
                                        <div class="col-md-9">
                                            <select name="emp_name" id="emp_name">
                                                <option value="">Select</option>
                                                <?php foreach ($employees as $single_employee) {
                                                    $default_emp_id=$default_emp['emp_id'];
                                                    $content_id=$single_employee['content_id'];
                                                    $emp_id=$single_employee['emp_id'];
                                                    $emp_name=$single_employee['emp_name'];
                                                    if($default_emp_id==$emp_id){
                                                        print '<option value="'.$emp_id.'" selected="selected">'.$emp_name.'</option>';
                                                    }else{
                                                        print '<option value="'.$emp_id.'">'.$emp_name.'</option>';
                                                    }

                                                } ?>

                                            </select>
                                        </div>
                                    </div>                                 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Company Name:</div>
                                        <div class="col-md-9"><input type="text" name="company_name" id="company_name" placeholder="e.g. Medisys" value="<?php print $toedit_records['name']; ?>"></div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Short Name:</div>
                                        <div class="col-md-9"><input type="text" name="short_name" id="short_name" placeholder="e.g. cocl" value="<?php print $toedit_records['keywords']; ?>"></div>
                                    </div>   
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Company Code:</div>
                                        <div class="col-md-9"><input type="text" name="company_code" id="company_code" placeholder="e.g. 9999" value="<?php print $toedit_records['weight']; ?>"></div>
                                    </div>                                                                     
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Company Location:</div>
                                        <div class="col-md-9"><input type="text" name="company_location" id="company_location" value="<?php print $toedit_records['url_path']; ?>"></div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Company Phone:</div>
                                        <div class="col-md-9"><input type="text" name="company_phone" id="company_phone" value="<?php print $toedit_records['page_title']; ?>"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Company Email:</div>
                                        <div class="col-md-9"><input type="text" name="company_email" id="company_email" value="<?php print $toedit_records['page_description']; ?>"></div>
                                    </div>                                                                                                                
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Description:</div>
                                        <div class="col-md-9">
                                            <textarea placeholder="Optional" name="company_description" id="company_description" cols="30" rows="10"><?php print $toedit_records['description']; ?></textarea>
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
                                        <div class="col-md-9"><input type="submit" name="add_company_btn" value="Submit"></div>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </form>
                        <table id="example" class="display" cellspacing="0" width="100%" border="1">
                            <thead>
                                <tr class="heading">
                                    <th>Company Name</th>
                                    <th>Short Name</th>
                                    <th>Company Code</th>
                                    <th>Company Head Name</th>                                    
                                    <th>Company Location</th>
                                    <th>Company Phone</th>
                                    <th>Company Email</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>Company Name</th>
                                    <th>Short Name</th>
                                    <th>Company Code</th>
                                    <th>Company Head Name</th>
                                    <th>Company Location</th>
                                    <th>Company Phone</th>
                                    <th>Company Email</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                </tr>
                            </tfoot>

                            <tbody>
                                <?php
                                foreach ($companies as $company) {
                                    $id = $company['id'];
                                    $company_name = $company['name'];
                                    $vid = $company['vid'];
                                    $tid = $company['tid'];
                                    $company_location =$company['url_path'];
                                    $company_head_employee_id =$company['parents_term'];
                                    $emp_info=$this->search_field_emp_model->getallsearch_table_contentByid($company_head_employee_id);
                                    $company_phone =$company['page_title'];
                                    $company_email =$company['page_description'];
                                    $short_name =$company['keywords'];
                                    $company_code =$company['weight'];
                                    $company_description = $company['description'];
                                    ?>
                                    <tr>
                                        <td><?php print $company_name; ?></td>
                                        <td><?php print $short_name; ?></td>
                                        <td><?php if($company_code){print $company_code;} ?></td>
                                        <td><?php print $emp_info['emp_name']; ?></td>
                                        <td><?php print $company_location; ?></td>
                                        <td><?php print $company_phone; ?></td>
                                        <td><?php print $company_email; ?></td>
                                        <td><?php print $company_description; ?></td>
                                        <td><?php
                                            if($company['status']==1){
                                                echo "active";
                                            }else{
                                                echo "Inactive";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url("addtaxonomy/addCompany") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit ev" /></a>
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