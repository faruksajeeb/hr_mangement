<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Manage User</title>
        <?php
        $this->load->view('includes/cssjs');
        $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type');
        ?> 

        <script>
            $(document).ready(function () {
                
                 $('.add').click(function () {
            $("#tag").html("<i class='fa fa-plus-square'></i>  Add");
            $("#tag_save_btn").html("Data"); 
            document.getElementById("user_form").reset();
           
        });
                $('.update').click(function () {
            
            $("#tag").html("<i class='fa fa-pencil-square-o'></i>  Edit");
            $("#tag_save_btn").html("Changes");            
            $('#user_id').val($(this).data('user_id'));
            $('#employee_id').val($(this).data('employee_id'));
            $('#fullname').val($(this).data('employee_name'));
            $('#user_name').val($(this).data('user_name'));
            $('#email_address').val($(this).data('email'));
            $('#password').val($(this).data('password'));
            $('#confirm_password').val($(this).data('password'));
            $('#phone').val($(this).data('phone'));
            $('#user_type').val($(this).data('user_type'));
            $('#user_division').val($(this).data('division'));
            $('#user_department').val($(this).data('department'));
            $('#user_status').val($(this).data('user_status'));
            

        });

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
                    textValue = textValue.replace(/ /g, "_");
                    var val_lowercase = textValue.toLowerCase();
                    $("#task_machine_name").val(val_lowercase);
                });
                // load department by division
                $("#user_division").change(function (e) {
                    var division_tid = $(this).val();
                    var base_url = '<?php echo base_url(); ?>';
                    var postData = {
                        "division_tid": division_tid
                    };
                    $.ajax({
                        type: "POST",
                        url: "" + base_url + "addprofile/getdepartmentidbydivisionid",
                        data: postData,
                        dataType: 'json',
                        success: function (data) {
                            // console.log(data);
                            var options = "";
                            options += '<option value="">Select Department</option>';
                            $(data).each(function (index, item) {
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
<?php if (!$id) { ?>
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
                width: 100%;
            }
        </style>
    </head>
    <body class="logged-in dashboard current-page add-division">
        <!-- Page Content -->  
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php
                $this->load->view('includes/menu');
                ?>
                <div class="row under-header-bar text-center"> 
                    <h4>
                        <span class="glyphicon glyphicon-user"></span>
                        Manage User
                    </h4>         
                </div> 
                <div class="wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row success-err-sms-area">
                                <div class="col-md-12">
                                    <input type="hidden" name="content_id" id="content_id" value="<?php echo $id; ?>">
                                    <div id="errors"></div>
                                    <?php if (!empty($this->session->userdata('add_status'))) { ?>
                                        <script type="text/javascript">
                                            $(window).on('load', function () {
                                                $('#myModal').modal('show');
                                            });
                                        </script>
                                    <?php
                                      $this->session->unset_userdata('add_status');
                                    
                                    } ?>
                                </div>
                            </div>

                            <form action="<?php echo base_url(); ?>user/activeInactiveUser" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                                <div class="row" style="margin-top:20px;">

                                    <div class="col-md-1 bgcolor_D8D8D8">Task Type<span style="color:red;float:right">*</span></div>
                                    <div class="col-md-2">
                                        <select name="task_type" id="task_type" class="" style="width:220px;">
                                            <?php
                                            $user_type_id = $this->session->userdata('user_type');
                                            ?>
                                            <option value="">--Select Type--</option>   
                                            <option value="1">Active the selected users</option>                                       
                                            <option value="0">Inactive the selected users</option>                                       
                                        </select>        
                                    </div>
                                    <div class="col-md-2"><input type="submit" style="padding: 5px;" name="user-actie-inactive" value="Execute" onclick="clicked = 'user-actie-inactive'" ></div>           
                                    <div class="col-md-7">
                                        <a href="" title="add" data-toggle="modal" data-target="#addModal" class="add btn btn-sm btn-primary pull-right operation-edit operation-link ev-edit-link"> <span class="glyphicon glyphicon-plus-sign"> Add user</span></a>

                                    </div>      

                                </div>             
                                <table id="example" class="display table table-sm table-bordered" cellspacing="0" width="100%" >
                                    <thead>
                                        <tr class="heading">
                                            <th style="padding-left: 10px;text-align: left;width:10px!important"><input type='checkbox' class="check_all" id="check_all" value='all' /></th>                    
                                            <th>Name</th>
                                            <th>Username</th>
                                            <?php if ($user_type == 1 && $user_id==6) { ?>
                                                <th>Password</th>
                                            <?php } ?>
            <!--                        <th>Email</th>
                                    <th>Phone</th>-->
                                            <th>User Role</th>
                                            <th>User Division</th>
                                            <th>User Department</th>
                                            <th>User Status</th>
                                            <!--<th>Edit</th>-->
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tfoot>
                                        <tr>
                                            <th style="width:10px!important;"></th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <?php if ($user_type == 1 && $user_id==6) { ?>
                                                <th>Password</th>
                                            <?php } ?>
            <!--                        <th>Email</th>
                                    <th>Phone</th>-->
                                            <th>User Role</th>
                                            <th>User Division</th>
                                            <th>User Department</th>
                                            <th style="width:100px;">User Status</th>
                                            <!--<th>Edit</th>-->
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>

                                    <tbody>
                                        <?php
                                                function secondsToTime($su) {
                                                        $then = new DateTime($su);
                                                        $now = new DateTime(date('Y-m-d H:i:s', time()));
                                                        $diff = $then->diff($now);
                                                        return array('years' => $diff->y, 'months' => $diff->m, 'days' => $diff->d, 'hours' => $diff->h, 'minutes' => $diff->i, 'seconds' => $diff->s);
                                                    }
                                        foreach ($all_users as $single_user) {
                                            $id = $single_user['id'];
                                            $name = $single_user['name'];
                                            $username = $single_user['username'];
                                            $password = $single_user['password'];
                                            $email = $single_user['email'];
                                            $user_status = $single_user['user_status'];
                                            $phone = $single_user['phone'];
                                            $created = $single_user['created'];
                                            if ($id != 6) {
                                                ?>
                                                <tr>
                                                    <td style="width:10px!important"><input type='checkbox' name='id[]' value='<?php print $id; ?>' /></td>
                                                    <td><?php print $name; ?></td>
                                                    <td><?php print $username;
                                                    if ($single_user['user_logged_status'] == 1) {
                                                    echo " <span class='glyphicon glyphicon-circle-arrow-up' style='color:#00FF00;font-size:8px'></span> ";
                                                } else {
                                                   // echo " <span class='glyphicon glyphicon-circle-arrow-down' style='color:#CCC;font-size:8px'></span> ";
                                                     /*
                                                      $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
                                                      $current_time = $dt->format('Y-m-d H:i:s');
                                                      $seconds = strtotime($current_time) - strtotime($single_user->UserLastAccessed);

                                                      $months = floor($seconds / (3600 * 24 * 30));
                                                      $day = floor($seconds / (3600 * 24));
                                                      $hours = floor($seconds / 3600);
                                                      $mins = floor(($seconds - ($hours * 3600)) / 60);
                                                      $secs = floor($seconds % 60);

                                                      if ($seconds < 60) {
                                                      $time = $secs . " seconds ago";
                                                      } else if ($seconds < 60 * 60) {
                                                      $time = $mins . " min ago";
                                                      } else if ($seconds < 24 * 60 * 60) {
                                                      $time = $hours . " hours ago";
                                                      } else if ($seconds < 30 * 24 * 60 * 60) {
                                                      $time = $day . " day ago";
                                                      } else {
                                                      $time = $months . " month ago";
                                                      }
                                                     */
                                                    $su = $single_user['user_last_accessed'];

                                                    $t = secondsToTime($su);
                                                    // print_r($t);

                                                    if ($t['years'] < 1 && $t['months'] < 1 && $t['days'] < 1 && $t['minutes'] < 1 && $t['seconds']>0) {
                                                        echo ' <span style="color:grey;font-size:8px;">' . $t['seconds'] . " seconds ago" . '</span>';
//                                                        echo ' <span style="color:grey;font-size:8px;">' . " never logged in" . '</span>';
                                                    } else if ($t['years'] < 1 && $t['months'] < 1 && $t['days'] < 1 && $t['minutes'] > 0) {
                                                        echo ' <span style="color:grey;font-size:8px;">' . $t['minutes'] . " minutes " . $t['seconds'] . " seconds ago" . '</span>';
                                                    } else if ($t['years'] < 1 && $t['months'] < 1 && $t['days'] > 0) {
                                                        echo ' <span style="color:grey;font-size:8px;">' . $t['days'] . " days " . $t['minutes'] . " minutes " . $t['seconds'] . " seconds ago" . '</span>';
                                                    } else if ($t['years'] < 1 && $t['months'] > 0) {
                                                        echo ' <span style="color:grey;font-size:8px;">' . $t['months'] . " months " . $t['days'] . " days " . $t['minutes'] . " minutes " . $t['seconds'] . " seconds ago" . '</span>';
                                                    } else if ($t['years'] > 0) {
                                                        echo ' <span style="color:grey;font-size:8px;">' . $t['years'] . " years " . $t['months'] . " months " . $t['days'] . " days " . $t['minutes'] . " minutes " . $t['seconds'] . " seconds ago" . '</span>';
                                                    } else {
                                                        echo '<span style="color:grey;font-size:8px;"> never logged in</span>';
                                                    }
                                                    
                                                }
                                                    
                                                    ?></td>
                                                    <?php if ($user_type == 1 && $user_id==6) { ?>
                                                        <td><?php print $password; ?></td>
                                                    <?php } ?>
                <!--                            <td><?php print $email; ?></td>
                                            <td><?php print $phone; ?></td>-->
                                                    <td><?php print $single_user['user_role']; ?></td>
                                                    <td><?php print $single_user['user_division_name']; ?></td>
                                                    <td><?php print $single_user['user_department_name']; ?></td>
                                                    <td style="font-style:italic;"><?php echo $user_status == '1' ? '<span class="label label-success">Active</span>' : '<span class="label label-default">Inactive</span>' ?></td>
                                                    <td>
                                                        <?php if ($user_type == 1 && $user_id==6) { ?>
                                                        <a data-toggle="modal" data-target="#addModal"  title="edit"
                                                            data-user_id="<?php echo $id; ?>" 
                                                            data-employee_id="<?php echo $single_user['employee_id']; ?>" 
                                                            data-employee_name="<?php echo $single_user['name']; ?>" 
                                                            data-user_name="<?php echo $single_user['username']; ?>" 
                                                            data-email="<?php echo $single_user['email']; ?>" 
                                                            data-password="<?php echo $single_user['password']; ?>" 
                                                            data-phone="<?php echo $single_user['phone']; ?>" 
                                                            data-user_type="<?php echo $single_user['role_id']; ?>" 
                                                            data-division="<?php echo $single_user['user_division']; ?>" 
                                                            data-department="<?php echo $single_user['user_department']; ?>" 
                                                            data-user_status="<?php echo $single_user['user_status']; ?>" 
                                                            
                                                           class="update btn btn-xs btn-info operation-edit operation-link ev-edit-link"> <span class="glyphicon glyphicon-edit"></span></a>
                                                       <?php } ?>
                                                        <a class="btn btn-xs btn-warning " href="<?php echo site_url("user/userwisepermission") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link" title="edit permission"> <span class="glyphicon glyphicon-check"> </span><span class="glyphicon glyphicon-user"> </span></a>
                                                        <a href="<?php echo site_url("user/viewuserwisepermission") . '/' . $id; ?>" title="view permission" class=" btn btn-xs btn-default operation-edit operation-link ev-edit-link"><span class="glyphicon glyphicon-zoom-in"></span> </a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>  
                            </form>                      
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="addModal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <a type="button" class="close " data-dismiss="modal" aria-hidden="true">
                                            &times;
                                        </a>
                                        <h4 class="modal-title" id="myModalLabel"><strong>
                                                <span style="font-size:15px" class="glyphicon glyphicon-plus"> </span> <span id="tag"></span>   User</strong></h4>
                                    </div>
                                    <form id="user_form" action="<?php echo base_url(); ?>user/saveUser" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                                      
                                                    <input type="hidden" name="user_id" id="user_id" value="">
                                        
                                    <div class="modal-body">
                                     
                                            <div class="row">
                                               
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-3 bgcolor_D8D8D8">Employee ID:</div>
                                                        <div class="col-md-7"><input type="text" name="employee_id" id="employee_id" value=""></div>
                                                    </div>                                
                                                    <div class="row">
                                                        <div class="col-md-3 bgcolor_D8D8D8">Name:</div>
                                                        <div class="col-md-7"><input type="text" name="fullname" id="fullname" value=""></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 bgcolor_D8D8D8">User Name:</div>
                                                        <div class="col-md-7"><input type="text" name="user_name" id="user_name" value=""></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 bgcolor_D8D8D8">E-mail address:</div>
                                                        <div class="col-md-7"><input type="text" name="email_address" id="email_address" value=""></div>
                                                    </div> 
                                                   
           
           
                                                    <div class="row">
                                                        <div class="col-md-3 bgcolor_D8D8D8">Password:</div>
                                                        <div class="col-md-8"><input type="password" name="password" id="password"></div>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-md-3 bgcolor_D8D8D8">Confirm password:</div>
                                                        <div class="col-md-8"><input type="password" name="confirm_password" id="confirm_password"></div>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-md-3 bgcolor_D8D8D8">Phone:</div>
                                                        <div class="col-md-8"><input type="text" name="phone" id="phone" value=""></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 bgcolor_D8D8D8">User Type:</div>
                                                        <div class="col-md-8">    
                                                            
                                                            <select name="user_type" id="user_type">
                                                                <option value=""> --Select Role-- </option>
                                                                <?php
                                                                foreach ($alluserrole as $single_role) {
                                                                    ?>
                                                                       <option value="<?php echo $single_role['id']; ?>"><?php echo $single_role['user_type']; ?></option>
                                                                  <?php  
                                                                    }
                                                                ?> 
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="row">
                                                        <div class="col-md-3 bgcolor_D8D8D8">Division:</div>
                                                        <div class="col-md-8">      
                                                            <select name="user_division" id="user_division">
                                                                <option value="">Select Division</option>
                                                                <?php
                                                                foreach ($alldivision as $single_division) {
                                                                  
                                                                        echo '<option value="' . $single_division['tid'] . '">' . $single_division['name'] . '</option>';
                                                                  
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3 bgcolor_D8D8D8">Department:</div>
                                                        <div class="col-md-8">      
                                                            <select name="user_department" id="user_department">
                                                                <option value="">Select Department</option>
                                                                <?php
                                                                foreach ($alldepartment as $single_department) {
                                                                 
                                                                        echo '<option value="' . $single_department['tid'] . '">' . $single_department['name'] . '</option>';
                                                                   
                                                                }
                                                                ?>                                    
                                                            </select>
                                                        </div>
                                                    </div>   
                                                    <div class="row">
                                                        <div class="col-md-3 bgcolor_D8D8D8">User Status:</div>
                                                        <div class="col-md-8">      
                                                            <select name="user_status" id="user_status">
                                                                <option value="1" <?php if ($toedit_records['user_status'] == '1') {
                                                                    echo 'selected="selected"';
                                                                } ?>>Active</option>
                                                                <option value="0" <?php if ($toedit_records['user_status'] == '0') {
                                                                    echo 'selected="selected"';
                                                                } ?>>Inactive</option>

                                                            </select>
                                                        </div>
                                                    </div>                                                                                        
                                               
                                                </div>
                                               
                                            </div>
                                       


                                    </div>
                                    <div class="modal-footer">

                                        <button type="submit" class="btn btn-default pull-right" name="add_btn" value="submit" style="width:150px;" >
                                            <span class="glyphicon glyphicon-save-file"></span>   Save <span id="tag_save_btn"></span>
                                        </button>
                                    </div>
                                     </form>

                                    <!--</form>-->
                                </div>
                            </div>
                        </div>
                        <!-- /.modal -->




                    </div>              
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->        
    </body>
</html>