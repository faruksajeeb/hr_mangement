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
                var base_url = '<?php echo base_url(); ?>';
                $.ajax({
                    type: "POST",
                    url: "" + base_url + "user/getallpermissions",
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
    // code for add remove selected employee
                $("#btnLeft").click(function () {
                    var selectedItem = $("#emp_name_selcted option:selected");
                    $("#emp_name").append(selectedItem);
                    var usedNames = {};
                    $("#emp_name > option").each(function () {
                        if (usedNames[this.text]) {
                            $(this).remove();
                        } else {
                            usedNames[this.text] = this.value;
                        }

                    });

                });

                $("#btnRight").click(function () {
                    var selectedItem = $("#emp_name option:selected");
                    $("#emp_name_selcted").append(selectedItem);
                    var usedNames = {};
                    $("#emp_name_selcted > option").each(function () {
                        if (usedNames[this.text]) {
                            $(this).remove();
                        } else {
                            usedNames[this.text] = this.value;
                        }
                    });

                });
                $('form#add-user-form').submit(function (event) {
                    $("#emp_name_selcted > option").each(function () {
                        $(this).prop("selected", true);
                    });
                });

                $("#emp_division").change(function (e) {
                    var division_tid = $(this).val();
                    var base_url = '<?php echo base_url(); ?>';
                    var postData = {
                        "division_tid": division_tid
                    };
                    $.ajax({
                        type: "POST",
                        url: "" + base_url + "reports/getempbydivisionid",
                        data: postData,
                        dataType: 'json',
                        success: function (data) {
                            //console.log(data);
                            var options = "";
                            $(data).each(function (index, item) {
                                options += '<option value="' + item.content_id + '">' + item.emp_name + '-' + item.emp_id + '</option>';
                            });
                            $('#emp_name').html(options);
                        }
                    });
                });
                // Setup - add a text input to each footer cell
                var c = 1;
                $('#example tfoot th').each(function () {
                    var title = $('#example thead th').eq($(this).index()).text();
                    if (c === 1) {
                        $(this).html('<input type="text" placeholder="Search" />');
                    }
                    c++;
                });

                // DataTable
                var table = $('#example').DataTable({
                    "lengthMenu": [[100, 25, 50, 500, -1], [100, 25, 50, 500, "All"]],
                    "aoColumnDefs": [{'bSortable': false, 'aTargets': [0, 1]}]
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
                width: 100%;
            }
            table.dataTable{
                margin-top: 20px;
            }
            .task_table td{
                padding: 2px 10px !important;
            }
      

        </style>
    </head>

    <body>
        <!-- Page Content -->  
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php
                $this->load->view('includes/menu');
                ?> 
                <div class="wrapper" style="margin-top:5px;">
  
                    <?php if (!empty($msg)) { ?>
<script type="text/javascript">
    $(window).on('load',function(){
        $('#myModal').modal('show');
    });
</script>
                    <!-- Small modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <h4 class="modal-title" id="exampleModalLabel"></h4>
      </div>
      <div class="modal-body">
         <h3 class="alert-heading"><i class="fa fa-check-square-o"></i>
                                    <?php
                                    echo validation_errors();
                                    echo $error;
                                    echo $msg;
                                    ?>
                                </h3>
      </div>
      <div class="modal-footer">
          <button type="button" style="width:100px" class="btn btn-default" data-dismiss="modal">OK</button>
        
      </div>
    </div>
  </div>
</div>


                       


                    <?php } ?>
                    <form name="registration" id="add-user-form" action="<?php echo base_url(); ?>user/updateUserWisePermission" method="post" enctype="multipart/form-data" >   
                        <input type="hidden" name="user_id" value="<?php print $toedit_records['id']; ?>" >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-3 bgcolor_D8D8D8">Name:</div>
                                    <div class="col-md-9"><input type="text" name="fullname" readonly class="form-control-plaintext" id="fullname" value="<?php print $toedit_records['name']; ?>"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 bgcolor_D8D8D8">Username:</div>
                                    <div class="col-md-9"><input type="text" name="user_name" readonly=""  id="user_name" value="<?php print $toedit_records['username']; ?>"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 bgcolor_D8D8D8">Division:</div>
                                    <div class="col-md-9">                             
                                        <select name="emp_division" id="emp_division">
                                            <?php
                                            echo '<option value="all">All</option>';
                                            foreach ($all_division as $single_division) {
                                                if ($emp_division == $single_division['tid']) {
                                                    echo '<option value="' . $single_division['tid'] . '" selected="selected" data-id="' . $single_division['weight'] . '">' . $single_division['name'] . '</option>';
                                                } else {
                                                    echo '<option value="' . $single_division['tid'] . '" data-id="' . $single_division['weight'] . '">' . $single_division['name'] . '</option>';
                                                }
                                            }
                                            ?>                                
                                        </select>       
                                    </div>
                                </div>                   
                                <div class="row">
                                    <div class="col-md-3 bgcolor_D8D8D8">Employee:</div>
                                    <div class="col-md-9">
                                        <select name="emp_name[]" id="emp_name" size="10" multiple="" autocomplete="off">
                                            <?php
                                            $default_emp_id = $default_emp['emp_id'];
                                            foreach ($all_employee as $single_employee) {
                                                $content_id = $single_employee['content_id'];
                                                $emp_id = $single_employee['emp_id'];
                                                $emp_name = $single_employee['emp_name'];
                                                if ($default_emp_id == $emp_id) {
                                                    print '<option value="' . $content_id . '" selected="selected">' . $emp_name . '-' . $emp_id . '</option>';
                                                } else {
                                                    print '<option value="' . $content_id . '">' . $emp_name . '-' . $emp_id . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>                     
                            </div>   
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-3 bgcolor_D8D8D8">Selected Employee<br><br><br><br>
                                        <div>
                                            <input type="button" id="btnRight" value=">>">
                                            <input type="button" id="btnLeft" value="<<">
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <select name="emp_name_selcted[]" id="emp_name_selcted" dupes="false" size="14" multiple="" autocomplete="off">
                                            <?php
                                          
                                            foreach ($all_permitted_employee as $single_permitted_employee) {
                                                
                                                $content_id_permitted = $single_permitted_employee['content_id'];
                                                $emp_id_permitted = $single_permitted_employee['emp_id'];
                                                $emp_name_permitted = $single_permitted_employee['emp_name'];
                                                ?>
                                                <option selected="selected" value="<?php echo $content_id_permitted ?>" style="border-bottom:1px dotted #CCC;font-weight:bold;">
                                                    <?php echo $emp_name_permitted . ' - ' . $emp_id_permitted; ?>
                                                </option>
                                                <?php
                                               
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div> 
                            </div>   
                        </div>
                        <?php
                        $roles = $this->users_model->getallrole();
                        $permissions = $this->users_model->allpermission();
                        ?>
                        <div class="permission-user-area" style="width:80%; margin:0 auto;">
                            <div class="errors alert alert-error" id="errors" style="display:none"></div>                                     
                            <table id="example" class="display task_table" cellspacing="0" width="100%" border="1">
                                <thead>
                                    <tr class="heading">
                                        <th scope="col">Activity</th>
                                        <?php
                                        // foreach ($roles as $single_role) {
                                        //     $role_type=$single_role['user_type']; 
                                        //     $role_id=$single_role['id']; 
                                        //     if($role_id !=1){
                                        ?>
                                        <th scope="col"><?php print "Action"; ?></th>
                                        <?php // }}  ?>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th scope="col">ACTIVITY</th>
                                        <?php
                                        // foreach ($roles as $single_role) {
                                        //     $role_type=$single_role['user_type'];
                                        //     $role_id=$single_role['id'];  
                                        //     if($role_id !=1){
                                        ?>
                                        <th scope="col"></th>
                                        <?php //}}  ?>
                                    </tr>
                                </tfoot>

                                <tbody>

                                    <?php
                                    foreach ($all_task as $single_tasktype) {
                                        $id = $single_tasktype['id'];
                                        $task_name = $single_tasktype['name'];
                                        $vid = $single_tasktype['vid'];
                                        $tid = $single_tasktype['tid'];
                                        $description = $single_tasktype['description'];
                                        ?>
                                        <tr >
                                                 <?php
                                            //foreach ($roles as $single_role) {
                                            $user_id = $toedit_records['id'];
                                            //      $role_type=$single_role['user_type']; 
                                            //      if($role_id !=1){
                                            $permissions_tast_wise = $this->users_model->getuserwisepermission($description, $user_id);
                                            ?>
                                            <td <?php if($permissions_tast_wise) { echo 'style="background:#98FB98"'; } ?> class="permission-ok-<?php echo $id; ?>"><?php print $task_name; ?></td>
                                       
                                            <td <?php if($permissions_tast_wise) { echo 'style="background:#98FB98"'; } ?> class="permission-ok-<?php echo $id; ?>"><input type='checkbox' class="sub_chk" pid="<?php echo $id; ?>" name='task_value[<?php print $user_id; ?>][<?php print $description; ?>]' value='1' <?php if ($permissions_tast_wise) {
                                            print 'checked="checked"';
                                        } ?> /></td>
                                        <?php //}} ?>
                                        </tr>
<?php } ?>

                                </tbody>          
                            </table>
                            <script>
jQuery(document).ready(function($){
    $('.sub_chk').on('click', function(){
        var pid=$(this).attr('pid');
        
        if($(this).is(':checked')){
           $(".permission-ok-" + pid).css('background-color',"#98FB98");
        } else {
            $(".permission-ok-" + pid).css('background-color',"#F0F1F1");
        }
    })
})

</script>
                            <div class="row" style="margin-top:20px;">
                                <div class="col-md-12 text-center" >
                                    <input type="submit" name="save_permissions" value="Save permissions">
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>

                        </div>        
<?php echo form_close(); ?>                 
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->           
    </body>
</html>



