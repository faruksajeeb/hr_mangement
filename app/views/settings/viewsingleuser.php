<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to View User Information</title>
    <?php
    $this->load->view('includes/cssjs');
    ?>
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
                <div class="row">
                    <div class="col-md-12 background-color-heading text-center title">View User Information</div>
                </div>      
                <div class="row">
                    <div class="col-md-4 bgcolor_D8D8D8">Name:</div>
                    <div class="col-md-8"><input type="text" disabled="disabled" name="fullname" id="fullname" value="<?php print $name; ?>"></div>
                </div>
                <div class="row">
                    <div class="col-md-4 bgcolor_D8D8D8">User Name:</div>
                    <div class="col-md-8"><input type="text" disabled="disabled" name="user_name" id="user_name" value="<?php print $username; ?>"></div>
                </div>
                <div class="row">
                    <div class="col-md-4 bgcolor_D8D8D8">E-mail address:</div>
                    <div class="col-md-8"><input type="text" disabled="disabled" name="email_address" id="email_address" value="<?php print $email; ?>"></div>
                </div> 
                <div class="row">
                    <div class="col-md-4 bgcolor_D8D8D8">User Status:</div>
                    <div class="col-md-8">
                        <select name="user_status" id="user_status" disabled="disabled">
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
                        <select name="country" id="country" disabled="disabled">
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
                    <div class="col-md-8"><input type="text" disabled="disabled" name="phone" id="phone" value="<?php print $phone; ?>"></div>
                </div>
                <div class="row">
                    <div class="col-md-4 bgcolor_D8D8D8">User Type:</div>
                    <div class="col-md-8">      
                        <select name="user_type" id="user_type" disabled="disabled">
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
                        <select name="company_name" id="company_name" disabled="disabled">
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
                    <div class="col-md-8"><input type="text" disabled="disabled" name="passport_no" id="passport_no" value="<?php print $passport_no; ?>"></div>
                </div>   
                <div class="row">
                    <div class="col-md-4 bgcolor_D8D8D8">Short Name:</div>
                    <div class="col-md-8"><input type="text" disabled="disabled" name="short_name" id="short_name" value="<?php print $short_name; ?>"></div>
                </div>                                                                                           
            </div>
        </div>
    </body>
    </html>



