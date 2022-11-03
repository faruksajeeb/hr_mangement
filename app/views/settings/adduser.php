<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add User</title>
    <?php
    $this->load->view('includes/cssjs');
    $user_id = $this->session->userdata('user_id');
    $user_type = $this->session->userdata('user_type');
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
                $("#user_role").keyup(function () {
                    var textValue = $(this).val();
                    textValue =textValue.replace(/ /g,"_");
                    var val_lowercase=textValue.toLowerCase();
                    $("#task_machine_name").val(val_lowercase);
                });                
// load department by division
$( "#user_division" ).change(function(e) {
    var division_tid = $(this).val(); 
    var base_url='<?php echo base_url();?>';
    var postData = {
        "division_tid" : division_tid
    };
    $.ajax({
        type: "POST",
        url: ""+base_url+"addprofile/getdepartmentidbydivisionid",
        data: postData,
        dataType:'json',
        success: function(data){
    // console.log(data);
    var options="";
    options += '<option value="">Select Department</option>';
    $(data).each(function(index, item) {
        options += '<option value="' + item.tid + '">' + item.name + '</option>'; 
    });
    $('#user_department').html(options);    
}
});
});
                // select all checkbox in tables
                $('#check_all').click(function () {
                    var checked_status = this.checked;
                    $(this).closest('table').find('input:checkbox').each(function () {
                        this.checked = checked_status;
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
                <?php if(!$id){ ?>
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
                <?php } ?>
                if (document.myForm.confirm_password.value != document.myForm.password.value) {
                    if (valid)
                        document.myForm.confirm_password.focus();
                    document.myForm.confirm_password.style.border = "solid 1px red";
                    msg += "<li>Password and confirm password does not match!</li>";
                    valid = false;
                    return false;
                }
                if (document.myForm.user_type.value == "") {
                    document.myForm.user_type.focus();
                    document.myForm.user_type.style.border = "solid 1px red";
                    msg += "<li>You need to fill the user role field!</li>";
                    valid = false;
                    return false;

                }
                // if (document.myForm.user_type.value == "7") {
                //     if (document.myForm.company_name.value == "") {
                //         document.myForm.company_name.focus();
                //         document.myForm.company_name.style.border = "solid 1px red";
                //         msg += "<li>You need to fill the confirm password field!</li>";
                //         valid = false;
                //         return false;
                //     }
                // }
                // if (document.myForm.user_type.value == "10") {
                //     if (document.myForm.short_name.value == "") {
                //         document.myForm.short_name.focus();
                //         document.myForm.short_name.style.border = "solid 1px red";
                //         msg += "<li>You need to fill the short name field!</li>";
                //         valid = false;
                //         return false;
                //     }
                // }
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
<style>
    .container-fluid {
    width: 90%;
    }
</style>
</head>
<body class="logged-in dashboard current-page add-division">
    <!-- Page Content -->  
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php 
            $this -> load -> view('includes/menu');
            ?>
            <div class="row under-header-bar text-center"> 
                <h4>Add User</h4>         
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url(); ?>user/adduser" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                            <div class="row success-err-sms-area">
                                <div class="col-md-12">
                                    <input type="hidden" name="content_id" id="content_id" value="<?php print $id; ?>">
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
                                        <div class="col-md-9"><input type="text" name="employee_id" id="employee_id" value="<?php print $toedit_records['employee_id']; ?>"></div>
                                    </div>                                
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Name:</div>
                                        <div class="col-md-9"><input type="text" name="fullname" id="fullname" value="<?php print $toedit_records['name']; ?>"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">User Name:</div>
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
                                        <div class="col-md-3 bgcolor_D8D8D8">User Type:</div>
                                        <div class="col-md-9">      
                                            <select name="user_type" id="user_type">
                                                <option value="">Select Role</option>
                                                <?php
                                                foreach ($alluserrole as $single_role) {
                                                    if($toedit_records['user_role']==$single_role['id']){
                                                        echo '<option value="'.$single_role['id'].'" selected="selected">'.$single_role['user_type'].'</option>';
                                                    }else{
                                                        echo '<option value="' . $single_role['id'] . '">' . $single_role['user_type'] . '</option>';
                                                    }
                                                }
                                            ?> 
                                        </select>
                                    </div>
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
                            <div class="row">
                                <div class="col-md-3 bgcolor_D8D8D8">Department:</div>
                                <div class="col-md-9">      
                                    <select name="user_department" id="user_department">
                                    <option value="">Select Department</option>
                                    <?php foreach ($department_selected as $single_department) {
                                        if($toedit_records['user_department']==$single_department['tid']){
                                            echo '<option value="'.$single_department['tid'].'" selected="selected">'.$single_department['name'].'</option>';
                                        }else{
                                            echo '<option value="'.$single_department['tid'].'">'.$single_department['name'].'</option>';
                                        }
                                    } ?>                                    
                                </select>
                            </div>
                        </div>   
                            <div class="row">
                                <div class="col-md-3 bgcolor_D8D8D8">User Status:</div>
                                <div class="col-md-9">      
                                    <select name="user_status" id="user_status">
                                        <option value="1" <?php if ($toedit_records['user_status']=='1'){ echo 'selected="selected"';} ?>>Active</option>
                                        <option value="0" <?php if ($toedit_records['user_status']=='0'){ echo 'selected="selected"';} ?>>Inactive</option>
                                         
                                </select>
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
            <form action="<?php echo base_url(); ?>user/activeinactiveuser" method="post" accept-charset="utf-8" enctype="multipart/form-data">
             <div class="row" style="margin-top:20px;">
                <div class="col-md-12">
                    <div class="col-md-1 bgcolor_D8D8D8">Task Type<span style="color:red;float:right">*</span></div>
                    <div class="col-md-2">
                        <select name="task_type" id="task_type">
                            <?php
                            $user_type_id = $this->session->userdata('user_type');
                            ?>
                            <option value="">Select Type</option>   
                            <option value="active_selected_users">Unblock the selected users</option>                                       
                            <option value="inactive_selected_users">Block the selected users</option>                                       
                        </select>        
                    </div>
                    <div class="col-md-2"><input type="submit" style="padding: 5px;" name="user-actie-inactive" value="Execute" onclick="clicked='user-actie-inactive'" ></div>           
                </div> 
            </div>             
            <table id="example" class="display" cellspacing="0" width="100%" border="1">
                <thead>
                    <tr class="heading">
                        <th style="padding-left: 10px;text-align: left;width:10px!important"><input type='checkbox' class="check_all" id="check_all" value='all' /></th>                    
                        <th>Name</th>
                        <th>Username</th>
                        <?php if($user_type==1){ ?>
                        <th>Password</th>
                        <?php } ?>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>User Role</th>
                        <th>User Division</th>
                        <th>User Department</th>
                        <th>User Status</th>
                        <th>Edit</th>
                        <th>Permissions</th>
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th style="width:10px!important;"></th>
                        <th>Name</th>
                        <th>Username</th>
                        <?php if($user_type==1){ ?>
                        <th>Password</th>
                        <?php } ?>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>User Role</th>
                        <th>User Division</th>
                        <th>User Department</th>
                        <th>User Status</th>
                        <th>Edit</th>
                        <th>Permissions</th>
                    </tr>
                </tfoot>

                <tbody>
                    <?php
                    foreach ($allusers as $single_user) {
                        $id = $single_user['id'];
                        $name = $single_user['name'];
                        $username = $single_user['username'];
                        $password = $single_user['password'];
                        $email = $single_user['email'];
                        $user_status = $single_user['user_status'];
                        $phone = $single_user['phone'];
                        $user_role = $single_user['user_role'];
                        $user_role_query=$this->role_model->getrolebyid($user_role);
                        $user_division = $single_user['user_division'];
                        $user_division_query=$this->taxonomy->getTaxonomybyid($user_division);
                        $user_department = $single_user['user_department'];
                        $user_department_query=$this->taxonomy->getTaxonomybyid($user_department);
                        $created = $single_user['created'];
                        if($id !=6){
                        ?>
                        <tr>
                        <td style="width:10px!important"><input type='checkbox' name='id[]' value='<?php print $id; ?>' /></td>
                            <td><?php print $name; ?></td>
                            <td><?php print $username; ?></td>
                            <?php if($user_type==1){ ?>
                            <td><?php print $password; ?></td>
                            <?php } ?>
                            <td><?php print $email; ?></td>
                            <td><?php print $phone; ?></td>
                            <td><?php print $user_role_query['user_type']; ?></td>
                            <td><?php print $user_division_query['name']; ?></td>
                            <td><?php print $user_department_query['name']; ?></td>
                            <td><?php print $user_status; ?></td>
                            <td>
                                <a href="<?php echo site_url("user/adduser") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit ev" /></a>
                            </td>
                            <td>
                                <a href="<?php echo site_url("user/userwisepermission") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/permission.png" alt="edit Permission" title="Edit Permission"/></a>
                                <a href="<?php echo site_url("user/viewuserwisepermission") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/permission-view.png" alt="View Permission" title="View Permission" /></a>
                            </td>
                        </tr>
                        <?php 
                        } 

                        } ?>
                    </tbody>
                </table>  
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