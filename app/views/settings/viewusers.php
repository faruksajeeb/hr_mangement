<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Users</title>
    <?php
    $this->load->view('includes/cssjs');
    ?> 

    <script>
        $(document).ready(function ()
        {
            $("#myTable").tablesorter();
        });

        function ConfirmDelete()
        {
            var x = confirm("Are you sure you want to delete?");
            if (x)
                return true;
            else
                return false;
        }

        $(document).ready(function () {
                // Setup - add a text input to each footer cell
                $('#example tfoot th').each(function () {
                    var title = $('#example thead th').eq($(this).index()).text();
                    $(this).html('<input type="text" placeholder="Search" />');
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

                // select all checkbox in tables
                $('#check_all').click(function () {
                    var checked_status = this.checked;
                    $(this).closest('table').find('input:checkbox').each(function () {
                        this.checked = checked_status;
                    });
                });

            });
</script> 
<style>

</style>   
</head>
<body>
    <?php
    $this->load->view('includes/menu');
    ?>
    <form action="<?php echo base_url(); ?>users/activeinactiveuser" method="post" accept-charset="utf-8" enctype="multipart/form-data"> 
        <div class="container main-container">
            <div class="all-content">
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
                    <div class="col-md-2"><input type="submit" style="width:100%" name="user-actie-inactive" value="Execute" onclick="clicked='user-actie-inactive'" ></div>           
                </div> 
            </div> 
            <table id="example" class="display" cellspacing="0" width="100%" border="1">
                <thead>
                    <tr class="heading">
                        <th style="padding-left: 10px;text-align: left;width:10px!important"><input type='checkbox' class="check_all" id="check_all" value='all' /></th>
                        <th>Name</th>
                        <th>Username</th>
                        <!-- <th>Email</th> -->
                        <th>User status</th>
                        <th>Country</th>
                        <th>Phone</th>
                        <th>User type</th>
                        <th>Company name</th>
                        <th>Created</th>
                        <th>Operations</th>
                        <th>Delete</th>
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th style="width:10px!important;"></th>
                        <th>Name</th>
                        <th>Username</th>
                        <!-- <th>Email</th> -->
                        <th>User status</th>
                        <th>Country</th>
                        <th>Phone</th>
                        <th>User type</th>
                        <th>Company name</th>
                        <th>Created</th>
                        <th>Operations</th>
                        <th>Delete</th>
                    </tr>
                </tfoot>

                <tbody>
                    <?php
                    foreach ($users as $single_user) {
                                // echo "<pre>";
                                // print_r($single_user);
                                // echo "</pre>";
                                // die();getcountryById($tid)
                        $id = $single_user['id'];
                        $name = $single_user['name'];
                        $username = $single_user['username'];
                        $email = $single_user['email'];
                        $user_status = $single_user['user_status'];
                        $country_data = $this->displaycontent->getcountryById($single_user['country']);
                        $country = $country_data[0]['name'];
                        $phone = $single_user['phone'];
                        $role_data = $this->user_model->getRolebyid($single_user['user_type']);
                        $user_type = $role_data[0]['user_type'];
                        $company_data = $this->displaycontent->getcompanyById($single_user['company_name']);
                        $company_name = $company_data[0]['name'];
                        $created = $single_user['created'];
                                // $date = new DateTime($created);
                                // $updated=$date->format('d-m-Y');
                        ?>
                        <tr>
                            <td style="width:10px!important"><input type='checkbox' name='id[]' value='<?php print $id; ?>' /></td>
                            <td><a href="<?php echo site_url("content/singlebio") . '/' . $id; ?>" class="single_content_link"><?php print $name; ?></a></td>
                            <td><?php print $username; ?></td>
                            <!-- <td><?php //print $email;  ?></td> -->
                            <td><?php if ($user_status == "1") {
                                print "Active";
                            } else if ($user_status == "0") {
                                print "Inactive";
                            } ?></td>
                            <td><?php print $country; ?></td>
                            <td><?php print $phone; ?></td>
                            <td><?php print $user_type; ?></td>
                            <td><?php print $company_name; ?></td>
                            <td><?php print $created; ?></td>
                            <td>
                                <a href="<?php echo site_url("users/viewsingleuser") . '/' . $id; ?>" class="operation-view operation-link ev-view-link"><img src="<?php echo base_url(); ?>resources/images/view.png" alt="view ev" /></a>
                                <a href="<?php echo site_url("users/edituser") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit ev" /></a>
                                <a href="<?php echo site_url("users/userwisepermission") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit ev" /></a>
                            </td>
                            <td>
                                <a href="<?php echo site_url("users/deleteuser") . '/' . $id; ?>" class="operation-delete operation-link" onClick="return ConfirmDelete()">Delete</a>  
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>	
        </div>
    </form>
</body>
</html>