<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User wise Permission</title>
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
            $( "#emp_division" ).change(function(e) {
              var division_tid = $(this).val(); 
              var base_url='<?php echo base_url();?>';
              var postData = {
                "division_tid" : division_tid
            };
            $.ajax({
                type: "POST",
                url: ""+base_url+"reports/getempbydivisionid",
                data: postData,
                dataType:'json',
                success: function(data){
                    //console.log(data);
                    var options="";
                    $(data).each(function(index, item) {
                      options += '<option value="' + item.content_id + '">' + item.emp_name + '-' + item.emp_id + '</option>'; 
                  });
                    $('#emp_name').html(options);    
                }
            });
        });
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
        <div class="wrapper">
            <div class="row success-err-sms-area">
                <div class="col-md-12">
                    <?php
                    echo validation_errors();
                    echo $error;
                    echo $msg; ?>
                </div>
            </div>  
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-3 bgcolor_D8D8D8">Name:</div>
                        <div class="col-md-9"><input type="text" name="fullname" readonly id="fullname" value="<?php print $toedit_records['name']; ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 bgcolor_D8D8D8">User Name:</div>
                        <div class="col-md-9"><input type="text" name="user_name" readonly id="user_name" value="<?php print $toedit_records['username']; ?>"></div>
                    </div>                   
            <div class="row">
                <div class="col-md-3 bgcolor_D8D8D8">Permitted Employees : </div>
                <div class="col-md-9">
                  <select name="emp_name[]" id="emp_name" size="15" multiple="" autocomplete="off" readonly>
                    <?php 
                    $i=1;
                    $default_emp_id=$default_emp['emp_id'];
                    foreach ($allemployee as $single_employee) {
                      $content_id=$single_employee['content_id'];
                      $emp_id=$single_employee['emp_id'];
                      $emp_name=$single_employee['emp_name'];
                      if($default_emp_id==$emp_id){
                        echo '<option value="'.$content_id.'" selected="selected">'.$i.'. '.$emp_name.' - '.$emp_id.'</option>';
                    }else{
                        echo '<option value="'.$content_id.'" style="padding:3px;border-bottom:1px solid #ccc; font-weight:bold; font-style:italic">'.$i.'. '.$emp_name.' - '.$emp_id.'</option>';
                    }
                    $i++;
                } 

                ?>
            </select>
                    
        </div>
    </div>                     
</div>   
<div class="col-md-6"></div>   
</div>
<div class="permission-user-area">
    <div class="errors alert alert-error" id="errors" style="display:none"></div>                                     
    <table id="example" class="display table table-bordered" cellspacing="0" width="100%" border="1">
        <thead>
            <tr class="heading">
                <th scope="col">Permitted Activity</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th scope="col">Permitted Activity</th>
                <th scope="col"></th>
            </tr>
        </tfoot>
        <tbody>
            <?php
            $i=1;
            foreach ($alltask as $single_tasktype) { 
                $id = $single_tasktype['id'];
                $task_name = $single_tasktype['name'];
                $vid = $single_tasktype['vid'];
                $tid = $single_tasktype['tid'];
                $description = $single_tasktype['description'];
                 $user_id=$toedit_records['id']; 
                    $permissions_tast_wise=$this->users_model->getuserwisepermission($description, $user_id);
                if($permissions_tast_wise){
                ?>
            <tr >
                    <td><?php print $i.'. '.$task_name; ?></td>
              
                    <td><?php if($permissions_tast_wise){ print '<span class="label label-success">Permitted</span>'; }?></td>
                </tr>
            <?php $i++;  }  } ?>
            </tbody>          
        </table>
    </div>                  
</div>
</div>
<!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->           
</body>
</html>



