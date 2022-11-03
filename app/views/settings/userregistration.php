<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Your Account</title>
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

        function validate() {
            var valid = true;
            var msg = "<ul>";
            if (document.myForm.employee_id.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.myForm.employee_id.focus();
                        document.myForm.employee_id.style.border = "solid 1px red";
                        msg += "<li>You need to fill the Employee id field!</li>";
                        valid = false;
                        return false;
                    }
                }            
            if (document.myForm.fullname.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.myForm.fullname.focus();
                        document.myForm.fullname.style.border = "solid 1px red";
                        msg += "<li>You need to fill the Name field!</li>";
                        valid = false;
                        return false;
                    }
                }
                if (document.myForm.user_name.value == "") {
                    if (valid)//only receive focus if its the first error
                        document.myForm.user_name.focus();
                    document.myForm.user_name.style.border = "solid 1px red";
                    msg += "<li>You need to fill the username field!</li>";
                    valid = false;
                    return false;
                }
                if (document.myForm.email_address.value == "") {
                    if (valid)
                        document.myForm.email_address.focus();
                    document.myForm.email_address.style.border = "solid 1px red";
                    msg += "<li>You need to fill in your email!</li>";
                    valid = false;
                    return false;
                }
                if (document.myForm.email_address.value) {
                    if (!validateEmail(document.myForm.email_address.value)) {
                        document.myForm.email_address.focus();
                        document.myForm.email_address.style.border = "solid 1px red";
                        msg += "<li>Your email is not valid!</li>";
                        valid = false;
                        return false;
                    }
                }

                if (document.myForm.password.value == "") {
                    if (valid)
                        document.myForm.password.focus();
                    document.myForm.password.style.border = "solid 1px red";
                    msg += "<li>You need to fill the password field!</li>";
                    valid = false;
                    return false;
                }
                if (document.myForm.confirm_password.value == "") {
                    if (valid)
                        document.myForm.confirm_password.focus();
                    document.myForm.confirm_password.style.border = "solid 1px red";
                    msg += "<li>You need to fill the confirm password field!</li>";
                    valid = false;
                    return false;
                }
                if (document.myForm.confirm_password.value != document.myForm.password.value) {
                    if (valid)
                        document.myForm.confirm_password.focus();
                    document.myForm.confirm_password.style.border = "solid 1px red";
                    msg += "<li>Password and confirm password does not match!</li>";
                    valid = false;
                    return false;
                }
                if (document.myForm.user_division.value == "") {
                    if (valid)
                        document.myForm.user_division.focus();
                    document.myForm.user_division.style.border = "solid 1px red";
                    msg += "<li>You need to fill the User Division field!</li>";
                    valid = false;
                    return false;
                }
                if (!valid) {
                    msg += "</ul>";
                    //console.log("Hello Bd");
                    var div = document.getElementById('errors').innerHTML = msg;
                    document.getElementById("errors").style.display = 'block';
                    return false;
                }

            }

            function validateEmail(email) {
                var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }       

</script>    
</head>
<body class="logged-in dashboard current-page add-division">
    <!-- Page Content -->  
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php 
           // $this -> load -> view('includes/menu');
            ?>
            <div class="row under-header-bar text-center"> 
                <h4>Create Your Account</h4>         
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url(); ?>registration/userregistration" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                            <div class="row success-err-sms-area">
                                <div class="col-md-12">
                                    <!-- <input type="hidden" name="content_id" id="content_id" value="<?php print $id; ?>"> -->
                                    <div id="errors"></div>
                                    <?php echo $error; ?>
                                    <?php echo $msg; ?>
                                    <?php echo validation_errors(); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Employee ID:</div>
                                        <div class="col-md-9"><input type="text" name="employee_id" id="employee_id" value="<?php print $toedit_records['employee_id']; ?>" placeholder="For ID Ask HR. Example 99911"></div>
                                    </div>                                
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Name:</div>
                                        <div class="col-md-9"><input type="text" name="fullname" id="fullname" value="<?php print $toedit_records['name']; ?>"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">User ID:</div>
                                        <div class="col-md-9"><input type="text" name="user_name" id="user_name" value="<?php print $toedit_records['username']; ?>"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">E-mail address:</div>
                                        <div class="col-md-9"><input type="text" name="email_address" id="email_address" value="<?php print $toedit_records['email']; ?>"></div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Password:</div>
                                        <div class="col-md-9"><input type="password" name="password" id="password"></div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Confirm password:</div>
                                        <div class="col-md-9"><input type="password" name="confirm_password" id="confirm_password"></div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Phone:</div>
                                        <div class="col-md-9"><input type="text" name="phone" id="phone" value="<?php print $toedit_records['phone']; ?>"></div>
                                    </div>   
                                <div class="row">
                                    <div class="col-md-3 bgcolor_D8D8D8">Division:</div>
                                    <div class="col-md-9">      
                                        <select name="user_division" id="user_division">
                                            <option value="">Select Division</option>
                                            <?php foreach ($alldivision as $single_division) {
                                              if($toedit_records['user_division']==$single_division['tid']){
                                                echo '<option value="'.$single_division['tid'].'" selected="selected">'.$single_division['name'].'</option>';
                                            }else{
                                                echo '<option value="'.$single_division['tid'].'">'.$single_division['name'].'</option>';
                                            }
                                        } ?>
                                    </select>
                                </div>
                            </div>                                                                                       
                        <div class="row top10 bottom10">
                            <div class="col-md-3"></div>
                            <div class="col-md-9"><input type="submit" name="add_btn" value="Submit"><a href="<?php echo base_url(); ?>" class="create-link" style="float:right">Back to Login</a></div>
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