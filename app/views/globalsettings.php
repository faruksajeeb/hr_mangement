<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Global Settings</title>
    <?php
    $this->load->view('includes/cssjs');
    ?>
    <script>
        $(document).ready(function ()
        {
            var base_url='<?php echo base_url();?>';
            $.ajax({
                type: "POST",
                url: ""+base_url+"user/getallglobalsettings",
                dataType: 'json',
                success: function (data) {
                    $(data).each(function (index, item) {
                        if (item.status == 1) {
                           // $('input[name="'[' + item.action + ']"]').prop('checked', true);
                            $('input[name="task_type[' + item.action + ']"]').prop('checked', true);
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
                    "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,1 ] }  ]
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
        <div class="row under-header-bar text-center"> 
                <h4>Global Settings</h4>         
            </div> 
        <div class="wrapper">
            <div class="row success-err-sms-area">
                <div class="col-md-12">
                    <?php
                    echo $error;
                    echo $msg; ?>
                </div>
            </div>
            <form name="globalsettings" id="add-user-form" action="<?php echo base_url(); ?>dashboard/globalsettings" method="post" enctype="multipart/form-data" >   
                <div class="global-settings-area">                                    
                    <table id="example" class="display" cellspacing="0" width="100%" border="1">
                        <thead>
                            <tr class="heading">
                                <th scope="col">ACTIVITY</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th scope="col">ACTIVITY</th>
                                <th scope="col"></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr>
                                <td>Open Password Forget System</td>
                                <td><input type='checkbox' name='task_type[Password_Forget_System]' value='1' <?php if($permissions_tast_wise){ print 'checked="checked"'; }?> /></td>
                            </tr>
                            <tr>
                                <td>Open User Registration System</td>
                                <td><input type='checkbox' name='task_type[User_Registration_System]' value='1' <?php if($permissions_tast_wise){ print 'checked="checked"'; }?> /></td>
                            </tr>
                        </tbody>          
                    </table>
                    <div class="row" style="margin-top:20px;">
                        <div class="col-md-12 text-center" >
                            <input type="submit" name="updateglobalSettings" value="Update Settings">
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



