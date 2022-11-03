<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Permission</title>
    <?php
    $this->load->view('includes/cssjs');
    ?>
    <script>
        $(document).ready(function ()
        {
        var base_url='<?php echo base_url();?>';
            $.ajax({
                type: "POST",
                url: ""+base_url+"user/getallpermissions",
                dataType: 'json',
                success: function (data) {
                    $(data).each(function (index, item) {
                        if (item.status == 1) {
                            $('input[name="' + item.user_type + '[' + item.action + ']"]').prop('checked', true);
                        }
                            //console.log(item);
                        });
                }
            });
        });


        $(document).ready(function () {
                // Setup - add a text input to each footer cell
                var c=1;
                $('#example tfoot th').each(function () {
                    var title = $('#example thead th').eq($(this).index()).text();
                    if(c===1){
                        $(this).html('<input type="text" placeholder="Search" />');
                    }
                    c++;
                });

                // DataTable
                var table = $('#example').DataTable({
                    "lengthMenu": [[100, 25, 50, 500, -1], [100, 25, 50, 500, "All"]],
                    "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,1,2,3,4,5,6 ] }  ]
                });

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
    .container-fluid {
        width: 90%;
    }
    table.dataTable{
        margin-top: 20px;
    }

</style>
</head>
<body>
   <!-- Page Content -->  
   <div id="page-content-wrapper">
    <div class="container-fluid">
        <?php 
        $this -> load -> view('includes/menu');         
        ?> 
        <div class="wrapper">
            <div class="row success-err-sms-area">
                <div class="col-md-12">
                    <?php
                    echo validation_errors();
                    echo $error;
                    echo $msg; ?>
                </div>
            </div>
                            <?php 
                                $roles=$this->users_model->getallrole();
                                $permissions=$this->users_model->allpermission();
                                ?>
            <div class="permission-user-area">
                <div class="errors alert alert-error" id="errors" style="display:none"></div>
                <form name="registration" id="add-user-form" action="<?php echo base_url(); ?>user/userpermission" method="post" enctype="multipart/form-data" >                                        
                    <table id="example" class="display" cellspacing="0" width="100%" border="1">
                        <thead>
                            <tr class="heading">
                                <th scope="col">ACTIVITY</th>
                                <?php 
                                foreach ($roles as $single_role) {
                                    $role_type=$single_role['user_type']; 
                                    $role_id=$single_role['id']; 
                                    if($role_id !=1){
                                    ?>
                                    <th scope="col"><?php print $role_type; ?></th>
                              <?php  }}  ?>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th scope="col">ACTIVITY</th>
                                <?php 
                                foreach ($roles as $single_role) {
                                    $role_type=$single_role['user_type'];
                                    $role_id=$single_role['id'];  
                                    if($role_id !=1){
                                    ?>
                                    <th scope="col"></th>
                              <?php  }}  ?>
                            </tr>
                        </tfoot>

                        <tbody>
                            
                                <?php 
                                foreach ($alltask as $single_tasktype) { 
                                    $id = $single_tasktype['id'];
                                    $task_name = $single_tasktype['name'];
                                    $vid = $single_tasktype['vid'];
                                    $tid = $single_tasktype['tid'];
                                    $description = $single_tasktype['description'];
                                    ?>
                                <tr>
                                <td><?php print $task_name; ?></td>
                               <?php foreach ($roles as $single_role) {
                                    $role_id=$single_role['id']; 
                                    $role_type=$single_role['user_type']; 
                                    if($role_id !=1){
                                    ?>
                                    <td><input type="hidden" name="<?php print $role_id; ?>[<?php print $description; ?>]" value="0" /><input type='checkbox' name='<?php print $role_id; ?>[<?php print $description; ?>]' value='1' /></td>
                              <?php  }} ?>
                                </tr>
                              <?php  } ?>
                                                                        
                        </tbody>          
                    </table>
                    <div class="row" style="margin-top:20px;">
                        <div class="col-md-12 text-center" >
                            <input type="submit" name="save_permissions" value="Save permissions">
                        </div>
                    </div>

                    <?php echo form_close(); ?>
                </div>                         
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->           
</body>
</html>



