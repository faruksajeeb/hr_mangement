<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS-Loan Type</title>
    <?php
    $this->load->view('includes/cssjs');
    ?> 

    <script>
        $(document).ready(function(){
                

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
                // check duplicate -------------------------------------------------------
                $('#loan_type_name').keyup(function () {                    
                    var id = $(this).attr('id');
                    var check_val = $(this).val();
                    //alert(table_name);
                    $.ajax({
                        type: "post",
                        url: "<?php echo base_url(); ?>loan/check_exists",
                        data: {id: id, check_val: check_val},
                        dataType: "html",
                        cache: false,
                        success: function (data) {
                            //alert(data);
                            if (data == 'Already exist!') {                                
                                    $('#errors').html(data);
                                    $("#add_btn").attr("disabled", "disabled");                                

                            } else {
                                
                                    $('#errors').html(data = null);
                                    $("#add_btn").removeAttr("disabled");
                                
                            }
                        }
                    });
                });
                
                //
                 setTimeout(function(){ 
                   // $("#errors").hide("slide", {direction: "up" }, "slow"); 
                    $(".alert").hide("slide", {direction: "up" }, "slow");
                   
                }, 5000);
        });
function ConfirmDelete()
{
    var x = confirm("Are you sure you want to permanently delete this data?");
    if (x)
        return true;
    else
        return false;
}
function validate() {
    var valid = true;
    var msg="<ul>";
    if ( document.myForm.loan_type_name.value == "" ) {
        if (valid){ //only receive focus if its the first error
            document.myForm.loan_type_name.focus();
            document.myForm.loan_type_name.style.border="solid 1px red";
            //document.myForm.loan_type_name.style.backgroundColor="#FFA07A";
            msg+='<li >You need to fill the loan type field! <span class="glyphicon glyphicon-remove-circle"></li>';         
            valid = false;
           // return false;
        }
    }
    if ( document.myForm.max_loan_amount.value == "" ) {
            if (valid){
                document.myForm.max_loan_amount.focus();
            }
            document.myForm.max_loan_amount.style.border="solid 1px red";
            //document.myForm.loan_type_name.style.backgroundColor="#FFA07A";
            msg+='<li >You need to fill the max_loan_amount field! <span class="glyphicon glyphicon-remove-circle"></li>';         
            valid = false;
           // return false;
      
        
    }
    if (!valid){
        
      msg+="</ul>";
      //console.log("Hello Bd");
     
      var div = document.getElementById('errors').innerHTML=msg;
      document.getElementById("errors").style.display = 'block';
      //Hide();
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
                <h4>Loan Type</h4>         
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-4 col-xs-12 add-form">
                        <div class="row add-form-heading">
                            <div class="col-md-12 "><span class="glyphicon glyphicon-plus-sign"> </span> Add Loan Type</div>
                        </div>
                         <form action="" method="POST" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                            <div class="row success-err-sms-area">
                                <div class="col-md-12">
                                    <input type="hidden" name="content_id" id="content_id" value="<?php print $id; ?>">
                                    <div id="errors" style='color:red;text-align:right'></div>
                                    
                                    <?php 
                                    $msg=$this->session->flashdata('success');
                                    if($msg){
                                        ?>
                                    <br/>
                                    <div class="alert alert-success text-center">
                                        <strong>Success!</strong> <?php echo $msg?>
                                      </div>                                    
                                    <?php
                                    }                                    
                                    $msg=null;
                                    ?>
                                    <?php 
                                    $error=$this->session->flashdata('error');
                                    if($error){
                                        ?>
                                    <br/>
                                    <div class="alert alert-success text-center">
                                        <strong>Success!</strong> <?php echo $error?>
                                      </div>                                    
                                    <?php
                                    }                                    
                                    $error=null;
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                               
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Loan Type:</div>
                                        <div class="col-md-9"><input type="text"  name="loan_type_name" id="loan_type_name" placeholder="e.g. Personal Loan" value="<?php print $toedit_records['loan_type_name']; ?>"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Maximum Loan Amount:</div>
                                        <div class="col-md-9"><input type="text" name="max_loan_amount" id="max_loan_amount" placeholder="e.g. 20000" value="<?php print $toedit_records['max_loan_amount']; ?>"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">interest(%) Yearly:</div>
                                        <div class="col-md-9"><input type="text" name="interest_percent" id="interest_percent" placeholder="e.g. 15" value="<?php print $toedit_records['interest_percentage']; ?>"></div>
                                    </div>
                                     <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Status:</div>
                                        <div class="col-md-9">
                                            <select name="status" id="status">
                                                <option value="1" <?php if($toedit_records['status']==1){ echo "selected='selected'";}?>>active</option>
                                                <option value="0" <?php if($toedit_records['status']==0){ echo "selected='selected'";}?>>deactive</option>
                                            </select>
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
                                        <div class="col-md-9"><input type="submit" id="add_btn" name="add_btn" value="Submit"></div>
                                    </div>
                                
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8 col-xs-12 display-list">
                        <div class="row display-list-heading">
                            <div class="col-md-12 "><span class="glyphicon glyphicon-list"> </span> Loan Type List</div>
                            
                            
                        </div>
                        <?php 
                                    $meg2=$this->session->flashdata('msg_success');
                                    if($meg2){
                                        ?>
                                    <br/>
                                    <div class="alert alert-success text-center">
                                        <strong>Success!</strong> <?php echo $meg2?>
                                      </div>                                    
                                    <?php
                                    }
                                    $meg2=null;
                                    ?>
                           <table id="example" class="display table table-striped" cellspacing="0" width="100%" border="1">
                            <thead>
                                <tr class="heading">
                                    <th>Sl no.</th>
                                    <th>Loan Type</th>
                                    <th title="Maximum Loan Amount">M. L. A.</th>
                                    <th>Interest(%) Yearly</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    
                                </tr>
                            </tfoot>

                            <tbody>
                               <?php
                               $sl_no=1;
                               foreach($loan_types as $loan_type){
                                   $id = $loan_type['id'];
                               ?>
                                    <tr>                                        
                                        <td><?php echo $sl_no++;?></td>
                                        <td><?php echo $loan_type['loan_type_name']?></td>
                                        <td><?php echo $loan_type['max_loan_amount']?></td>
                                        <td><?php echo $loan_type['interest_percentage']?></td>
                                        <td><?php echo $loan_type['description']?></td>
                                        <td>
                                            <?php 
                                            echo $loan_type['status']==1 ? 
                                                 '<span class="label label-success">active</span>' : 
                                                 '<span class="label label-danger">deactive</span>';
                                            ?>                                            
                                        </td>
                                        <td>
                                            <!--
                                            <?php if($loan_type['status']==1){ ?>
                                            <a href="<?php echo base_url(); ?>loan/activeInactiveLoanType" style="color:#A52A2A" title="inactive"><i class="fas fa-times-circle"></i></a>
                                            <?php }
                                            if($loan_type['status']==0){
                                            ?>
                                            <a href="<?php echo base_url(); ?>loan/activeInactiveLoanType" style="color:#228B22" title="active"><i class="fas fa-check-circle"></i></a>
                                            <?php } ?>
                                            -->
                                            <a title="edit" href="<?php echo site_url("loan-type") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><i class="fas fa-edit"></i></a>
                                            <a title="delete" href="<?php echo site_url("loan/deleteLoanType") . '/' . $id; ?>" class="operation-cut operation-link" onClick="return ConfirmDelete()"> <i class="fas fa-trash-alt" style="color:red"></i></a>
                                        </td>
                                    </tr>
                                <?php }?>
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