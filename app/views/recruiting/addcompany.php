<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Group</title>
    <?php
    $this->load->view('includes/cssjs');
    ?> 

    <script>
        $(document).ready(function(){
                // Setup - add a text input to each footer cell
                // $('#example tfoot th').each(function () {
                //     var title = $('#example thead th').eq($(this).index()).text();
                //     $(this).html('<input type="text" placeholder="Search ' + title + '" />');
                // });

                // // DataTable
                // var table = $('#example').DataTable();

                // // Apply the search
                // table.columns().eq(0).each(function (colIdx) {
                //     $('input', table.column(colIdx).footer()).on('keyup change', function () {
                //         table
                //         .column(colIdx)
                //         .search(this.value)
                //         .draw();
                //     });
                // });

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
                <h4>Define Company Name & Address</h4>         
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url(); ?>company/addcompany" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
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
                                        <div class="col-md-3 bgcolor_D8D8D8">Company Name:</div>
                                        <div class="col-md-9"><input type="text" name="company_name" disabled="disabled" id="company_name" placeholder="e.g. IIDFC Securities Limited" value="<?php print $companydetails['company_name']; ?>"></div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Company Address:</div>
                                        <div class="col-md-9"><input type="text" name="company_location" disabled="disabled" id="company_location" value="<?php print $companydetails['comp_addresss']; ?>"></div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Company Phone:</div>
                                        <div class="col-md-9"><input type="text" name="company_phone" disabled="disabled" id="company_phone" value="<?php print $companydetails['mobile_no']; ?>"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Company Email:</div>
                                        <div class="col-md-9"><input type="text" name="company_email" disabled="disabled" id="company_email" value="<?php print $companydetails['email_address']; ?>"></div>
                                    </div>                                                                                                                           
                                    <div class="row top10 bottom10">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-9"><input type="submit" name="add_company_btn" disabled="disabled" value="Submit"></div>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </form>                       
                    </div>
                </div>              
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->        
</body>
</html>