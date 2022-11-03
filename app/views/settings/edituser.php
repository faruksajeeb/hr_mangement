<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome to Registration</title>
        <?php
        $this->load->view('includes/cssjs');
        ?>

        <script type="text/javascript">
            function validate() {
                var valid = true;
                var msg = "<ul>";
                if (document.registration.fullname.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.registration.fullname.focus();
                        document.registration.fullname.style.border = "solid 1px red";
                        msg += "<li>You need to fill the Name field!</li>";
                        valid = false;
                        return false;
                    }
                }
                if (document.registration.user_name.value == "") {
                    if (valid)//only receive focus if its the first error
                        document.registration.user_name.focus();
                    document.registration.user_name.style.border = "solid 1px red";
                    msg += "<li>You need to fill the username field!</li>";
                    valid = false;
                    return false;
                }
                if (document.registration.email_address.value == "") {
                    if (valid)
                        document.registration.email_address.focus();
                    document.registration.email_address.style.border = "solid 1px red";
                    msg += "<li>You need to fill in your email!</li>";
                    valid = false;
                    return false;
                }
                if (document.registration.email_address.value) {
                    if (!validateEmail(document.registration.email_address.value)) {
                        document.registration.email_address.focus();
                        document.registration.email_address.style.border = "solid 1px red";
                        msg += "<li>Your email is not valid!</li>";
                        valid = false;
                        return false;
                    }
                }
                if (document.registration.confirm_password.value != document.registration.password.value) {
                    if (valid)
                        document.registration.confirm_password.focus();
                    document.registration.password.style.border = "solid 1px red";
                    document.registration.confirm_password.style.border = "solid 1px red";
                    msg += "<li>Password and confirm password does not match!</li>";
                    valid = false;
                    return false;
                }
                if (document.registration.user_type.value == "") {
                    document.registration.user_type.focus();
                    document.registration.user_type.style.border = "solid 1px red";
                    msg += "<li>You need to fill the user role field!</li>";
                    valid = false;
                    return false;

                }
                if (document.registration.user_type.value == "7") {
                    if (document.registration.company_name.value == "") {
                        document.registration.company_name.focus();
                        document.registration.company_name.style.border = "solid 1px red";
                        msg += "<li>You need to fill the confirm password field!</li>";
                        valid = false;
                        return false;
                    }
                }
                if (document.registration.user_type.value == "10") {
                    if (document.registration.short_name.value == "") {
                        document.registration.short_name.focus();
                        document.registration.short_name.style.border = "solid 1px red";
                        msg += "<li>You need to fill the passport no field!</li>";
                        valid = false;
                        return false;
                    }
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
    <body>
        <?php
        $this->load->view('includes/menu');
        ?>
        <?php
        foreach ($user as $single_user) {
            $id = $single_user['id'];
            $name = $single_user['name'];
            $username = $single_user['username'];
            $email = $single_user['email'];
            $user_status = $single_user['user_status'];
            $country = $single_user['country'];
            $phone = $single_user['phone'];
            $user_type = $single_user['user_type'];
            $company_name = $single_user['company_name'];
            $passport_no = $single_user['passport_no'];
            $created = $single_user['created'];
            $short_name = $single_user['short_name'];
        }
        ?>
        <div class="container main-container">
            <div class="add-user-area">        
                <div class="errors alert alert-error" id="errors" style="display:none"></div>
                <form name="registration" id="add-user-form" action="<?php echo base_url(); ?>register/edituserinfo" onSubmit="return validate();" method="post"  enctype="multipart/form-data" >
                    <?php echo validation_errors(); ?>
                    <input type="hidden" id="user_id" name="user_id" value="<?php print $id; ?>">
                    <div class="row">
                        <div class="col-md-12 background-color-heading text-center title">Edit User Information</div>
                    </div>      
                    <div class="row">
                        <div class="col-md-4 bgcolor_D8D8D8">Name:</div>
                        <div class="col-md-8"><input type="text" name="fullname" id="fullname" value="<?php print $name; ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 bgcolor_D8D8D8">User Name:</div>
                        <div class="col-md-8"><input type="text" name="user_name" id="user_name" value="<?php print $username; ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 bgcolor_D8D8D8">E-mail address:</div>
                        <div class="col-md-8"><input type="text" name="email_address" id="email_address" value="<?php print $email; ?>"></div>
                    </div> 
                    <div class="row">
                        <div class="col-md-4 bgcolor_D8D8D8">Password:</div>
                        <div class="col-md-8"><input type="password" name="password" id="password"></div>
                    </div> 
                    <div class="row">
                        <div class="col-md-4 bgcolor_D8D8D8">Confirm password:</div>
                        <div class="col-md-8"><input type="password" name="confirm_password" id="confirm_password"></div>
                    </div> 
                    <div class="row">
                        <div class="col-md-4 bgcolor_D8D8D8">User Status:</div>
                        <div class="col-md-8">
                            <select name="user_status" id="user_status">
                                <option value="1" <?php if ($user_status == '1') {
                        echo 'selected="selected"';
                    } ?>>Active</option>
                                <option value="0" <?php if ($user_status == '0') {
                        echo 'selected="selected"';
                    } ?>>Inactive</option>
                            </select>
                        </div>
                    </div> 
                    <div class="row"> 
                        <div class="col-md-4 bgcolor_D8D8D8">Country:</div>
                        <div class="col-md-8">
                            <select name="country" id="country">
                                <option value="">Select Country</option>
                                <?php
                                foreach ($country_taxonomy as $single_country) {
                                    if ($country == $single_country['tid']) {
                                        echo '<option value="' . $single_country['tid'] . '" selected="selected">' . $single_country['name'] . '</option>';
                                    } else {
                                        echo '<option value="' . $single_country['tid'] . '">' . $single_country['name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>      
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 bgcolor_D8D8D8">Phone:</div>
                        <div class="col-md-8"><input type="text" name="phone" id="phone" value="<?php print $phone; ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 bgcolor_D8D8D8">User Type:</div>
                        <div class="col-md-8">      
                            <select name="user_type" id="user_type">
                                <option value="">Select Role</option>
                                <?php
                                foreach ($user_role as $single_role) {
                                    if ($user_type == $single_role['id']) {
                                        echo '<option value="' . $single_role['id'] . '" selected="selected">' . $single_role['user_type'] . '</option>';
                                    } else {
                                        echo '<option value="' . $single_role['id'] . '" >' . $single_role['user_type'] . '</option>';
                                    }
                                }
                                ?> 
                            </select>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-md-4 bgcolor_D8D8D8">Company Name:</div>
                        <div class="col-md-8">
                            <select name="company_name" id="company_name">
                                <option value="">Select Company</option>
                                <?php
                                foreach ($company_taxonomy as $single_company) {
                                    if ($company_name == $single_company['tid']) {
                                        echo '<option value="' . $single_company['tid'] . '" selected="selected">' . $single_company['name'] . '</option>';
                                    } else {
                                        echo '<option value="' . $single_company['tid'] . '">' . $single_company['name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-md-4 bgcolor_D8D8D8">Passport No:</div>
                        <div class="col-md-8"><input type="text" name="passport_no" id="passport_no" value="<?php print $passport_no; ?>"></div>
                    </div>   
                    <div class="row">
                        <div class="col-md-4 bgcolor_D8D8D8">Short Name:</div>
                        <div class="col-md-8"><input type="text" name="short_name" id="short_name" value="<?php print $short_name; ?>"></div>
                    </div>                                      
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"><input type="submit" id="edit-submit" name="op" value="Update" class="form-submit"/></div>
                    </div>                                                     
<?php echo form_close(); ?>
            </div>
        </div>
    </body>
</html>



