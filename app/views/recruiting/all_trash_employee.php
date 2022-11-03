<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> HRMS | Inactive Employee</title>
        <?php
        $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type');
        $this->load->view('includes/cssjs');
        ?>
                        <!-- XEditable -->
        <link rel="stylesheet" href="<?php echo site_url(); ?>plugins/xeditable/bootstrap-editable.css">
       
        <script>
            $(document).ready(function () {
                
                                 $('.employee_status').editable({
                            prepend: "-- select status --",
                            showbuttons: false,                            
                            source: [
                 
                                             {
                                                value: 1,
                                                text: "Unlock"
                                            }, {
                                                value: 0,
                                                text: "Locked"
                                            },    
                                                         
                            ]
                   });
                $('.example').dataTable({
                    "lengthMenu": [[15, 30, 50, -1], [15, 30, 50, "All"]],
                    //paging: false,
                    paging: true, //changed by sajeeb
                    "autoWidth": false,
                    //"searching": false,
                    "info": false,
                });


            });
            // Multiple delete/ Restore------------------------------------------------------------------------------
            jQuery(function ($)
            {
                resetcheckbox();
                $('#del_all').css("visibility", "hidden");
                $('#restore_all').css("visibility", "hidden");
                $('#ter_del_all').css("visibility", "hidden");
                $('#ter_restore_all').css("visibility", "hidden");
                // Multiple left/ Resigned employee delete..................................................
                $('#selecctall').click(function (event) {  //on click
                    if (this.checked) { // check select status
                        $('.sub_chk').each(function () { //loop through each checkbox
                            this.checked = true;  //select all checkboxes with class "checkbox1" 
                            $('#del_all').css("visibility", "visible");
                            $('#restore_all').css("visibility", "visible");
                        });
                    } else {
                        $('.sub_chk').each(function () { //loop through each checkbox
                            this.checked = false; //deselect all checkboxes with class "checkbox1"
                            $('#del_all').css("visibility", "hidden");
                            $('#restore_all').css("visibility", "hidden");
                        });
                    }

                });
                

                $('.sub_chk').click(function () {
                    if ($(".sub_chk:checked").length >= 1 && $('.sub_chk').is(":checked") == true) {
                        //$('#del_all').show();
                        $('#del_all').css("visibility", "visible");
                        $('#restore_all').css("visibility", "visible");
                    } else {
                        //$('#del_all').hide(); 
                        $('#del_all').css("visibility", "hidden");
                        $('#restore_all').css("visibility", "hidden");
                    }
                });
               
                $("#del_all").on('click', function (e) {
                    e.preventDefault();
                    if (confirm("Are you sure you want to delete this?"))
                    {
                        var checkValues = $('.sub_chk:checked').map(function ()
                        {
                            return $(this).val();
                        }).get();
                        console.log(checkValues);
                        $.each(checkValues, function (i, val) {
                            $("#" + val).remove();
                        });
//                    return  false;
                        if (checkValues.length === 0) //tell you if the array is empty
                        {
                            alert("Please Select atleast one checkbox");
                        } else {
                            if (confirm("If you delete this you permanently lost this data.")) {
                                //alert(checkValues);
                                $.ajax({
                                    url: '<?php echo base_url(); ?>commoncontroller/multiple_delete_employee',
                                    type: 'post',
                                    data: 'content_id=' + checkValues
                                }).done(function (data) {
                                    $("#respose").html(data);
                                    $('#selecctall').attr('checked', false);
                                    window.location.reload();

                                });
                            } else {
                                return false;
                            }
                        }

                    } else {
                        return false;
                    }
                });
                $("#restore_all").on('click', function (e) {
                    e.preventDefault();
                    if (confirm("Are you sure you want to restore this?"))
                    {
                        var checkValues = $('.sub_chk:checked').map(function ()
                        {
                            return $(this).val();
                        }).get();
                        console.log(checkValues);
                        $.each(checkValues, function (i, val) {
                            $("#" + val).remove();
                        });
//                    return  false;
                        if (checkValues.length === 0) //tell you if the array is empty
                        {
                            alert("Please Select atleast one checkbox");
                        } else {
                            //alert(checkValues);
                            $.ajax({
                                url: '<?php echo base_url(); ?>commoncontroller/multiple_restore_employee',
                                type: 'post',
                                data: 'content_id=' + checkValues
                            }).done(function (data) {
                                $("#respose").html(data);
                                $('#selecctall').attr('checked', false);
                                window.location.reload();

                            }).error(function(data) {
                                   alert("some error");
                                });
                        }

                    } else {
                        return false;
                    }
                });
                 //  restore/ delete trminated employee.......................................................................................
 
                $('#ter_select_all').click(function (event) {  //on click
                    if (this.checked) { // check select status
                        $('.sub_ter_chk').each(function () { //loop through each checkbox
                            this.checked = true;  //select all checkboxes with class "checkbox1" 
                             $('#ter_del_all').css("visibility", "visible");
                            $('#ter_restore_all').css("visibility", "visible");
                        });
                    } else {
                        $('.sub_ter_chk').each(function () { //loop through each checkbox
                            this.checked = false; //deselect all checkboxes with class "checkbox1"
                            $('#ter_del_all').css("visibility", "hidden");
                            $('#ter_restore_all').css("visibility", "hidden");
                        });
                    }

                });
                 $('.sub_ter_chk').click(function () {
                    if ($(".sub_ter_chk:checked").length >= 1 && $('.sub_ter_chk').is(":checked") == true) {
                        //$('#del_all').show();
                        $('#ter_del_all').css("visibility", "visible");
                        $('#ter_restore_all').css("visibility", "visible");
                    } else {
                        //$('#del_all').hide(); 
                        $('#ter_del_all').css("visibility", "hidden");
                        $('#ter_restore_all').css("visibility", "hidden");
                    }
                });
                $("#ter_restore_all").on('click', function (e) {
                    e.preventDefault();
                    if (confirm("Are you sure you want to restore this?"))
                    {
                        var checkValues = $('.sub_ter_chk:checked').map(function ()
                        {
                            return $(this).val();
                            
                        }).get();
                        console.log(checkValues);
                        $.each(checkValues, function (i, val) {
                            $("#" + val).remove();
                        });
//                    return  false;
                        if (checkValues.length === 0) //tell you if the array is empty
                        {
                            alert("Please Select atleast one checkbox");
                        } else {
                           // alert(checkValues);
                            $.ajax({
                                url: '<?php echo base_url(); ?>commoncontroller/multiple_delete_employee',
                                type: 'post',
                                data: 'content_id=' + checkValues
                            }).done(function (data) {
                                $("#respose").html(data);
                                $('#ter_select_all').attr('checked', false);
                                window.location.reload();

                            });
                        }

                    } else {
                        return false;
                    }
                });
                $("#ter_del_all").on('click', function (e) {
                    e.preventDefault();
                    if (confirm("Are you sure you want to delete this?"))
                    {
                        var checkValues = $('.sub_ter_chk:checked').map(function ()
                        {
                            return $(this).val();
                            
                        }).get();
                        console.log(checkValues);
                        $.each(checkValues, function (i, val) {
                            $("#" + val).remove();
                        });
//                    return  false;
                        if (checkValues.length === 0) //tell you if the array is empty
                        {
                            alert("Please Select atleast one checkbox");
                        } else {
                           // alert(checkValues);
                           if(confirm('If you delete this you permanently lost this data.')){
                            $.ajax({
                                url: '<?php echo base_url(); ?>commoncontroller/multiple_restore_employee',
                                type: 'post',
                                data: 'content_id=' + checkValues
                            }).done(function (data) {
                                $("#respose").html(data);
                                $('#ter_select_all').attr('checked', false);
                                window.location.reload();

                            });
                            }else{
                            return false;
                            }
                        }

                    } else {
                        return false;
                    }
                });

                
                
                
                
                
                
                
                
                
                function  resetcheckbox() {
                    $('input:checkbox').each(function () { //loop through each checkbox
                        this.checked = false; //deselect all checkboxes with class "checkbox1"
                    });
                }





            });








            function ConfirmDelete()
            {
                var x = confirm("Are you sure you want to Permanently delete this? If you delete this you permanently lost this data.");
                if (x)
                    return true;
                else
                    return false;
            }


        </script>

        <style>
            .container-fluid {
                width: 100%;
            }
            #search_button {
                width: 100%;
                margin-top: 15px;
            }
            .title-area,h3{
                background: #696969;
                border-bottom: 1px solid #696969;
                color: #fff !important;
                text-transform: uppercase;

                font-weight: bold;
                font-family:  serif;
            }
            .table_greed{
                border: 1px solid #696969;
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
                <div class="wrapper">
                    <?php if ($user_type == 1 && $user_id == 6) { ?> 
                        <a href="<?php echo site_url('findemployeelist/all_delete_employee'); ?>" class="btn btn-danger btn-sm pull-left" style="width:130px; margin:5px 0px" id=""><span class="glyphicon glyphicon-trash"  title=""></span> Trash Employee</a>
                    <?php } ?>
                    <div class="row" class="table_greed" style="padding:10px;">
                        <div class="col-md-12" style=" border: 2px solid #696969;background: #fff;">


                            <div class="row" id="list">
                                <div class="col-md-12">
                                    <div class="title-area">
                                        <h3 class=" text-center" id="">Left Employee List(<?php echo $left_employee_numbers; ?>) </h3>

                                    </div>

                                </div>
                            </div>
                            <div class="row clear_fix"><div class="col-md-12" id="respose" style="margin-bottom:5px "></div></div>

                            <table class="example"  width="100%" border="0">
                                <button class="btn btn-danger btn-sm pull-left disabled" style="width:130px;margin-right: 5px;margin-top: -15px;" id="del_all"><span class="glyphicon glyphicon-remove"  title=""></span> Delete selected</button>
                                <button class="btn btn-success btn-sm pull-left disabled" style="width:130px;margin-top: -15px;" id="restore_all"><span class="glyphicon glyphicon-repeat"  title=""></span> Re-join selected</button>
                                <thead>

                                    <tr class="heading">
                                        <th style="padding-left: 10px;text-align: left;width:10px!important"><input type='checkbox' class="selecctall" id="selecctall" value='all' /></th>

                                        <th>Sl</th>
                                        <th>Employee ID</th>
                                        <th>Employee Name</th>
                                        <th>Division Name</th>
                                        <th>Department Name</th>
                                        <th>Position</th>
                                        <th>Status</th>
                                        <?php if ($user_type == 1) { ?>
                                            <th style="width:200px">Action</th>
                                        <?php } ?>
                                    </tr>
                                </thead>


                                <tbody>
                                    <?php
                                    $sl = 1;
                                    foreach ($left_employee as $sigle_emp) {
                                        ?>
                                        <tr content_id="<?php echo $sigle_emp->content_id; ?>">
                                            <td style="width:10px!important"><input type='checkbox' class="sub_chk" name='content_id[]' value='<?php echo $sigle_emp->content_id; ?>' /></td>
                                            <td><?php echo $sl; ?></td>
                                            <td><?php echo $sigle_emp->emp_id; ?></td>
                                            <td><?php echo $sigle_emp->emp_name; ?></td>
                                            <td><?php echo $sigle_emp->division; ?></td>
                                            <td><?php echo $sigle_emp->department; ?></td>
                                            <td><?php echo $sigle_emp->designation; ?></td>                                          
                                             <td>
                                                 <?php                                                 
                                                if($user_type == 1){
                                                ?>
                                                <a href="#" rel="tooltip" data-placement="top" data-inputclass="select_class"  class="employee_status" id="status" data-type="select" data-title="Change Lock Status" data-pk="<?php echo $sigle_emp->content_id; ?>" data-url="<?php echo base_url(); ?>findemployeelist/employeeLockSystem/search_field_emp" >                                         
                                                    <?php
                                                }
                                                if($sigle_emp->status==1){
                                                    echo "<span class='' style='color:green'>unlock</span> ";
                                                }else if($sigle_emp->status==0){
                                                    echo "<span class='' style='color:red'>Locked</span>";
                                                }
                                                 if($user_type == 1){
                                                     echo "</a>";
                                                 }                                                 
                                                ?>                                      
                                             </td>                                        
                                            <?php if ($user_type == 1) { ?>
                                                <td >
                                                    <a class="btn btn-default btn-xs" href="<?php echo site_url("addprofile/addemployee") . '/' .$sigle_emp->content_id; ?>" class="operation-edit operation-link ev-edit-link"><span class="glyphicon glyphicon-edit" title="edit"></span>  edit</a>
                                            <!--        <a href="<?php echo site_url("CommonController/restore_type_of_employee/search_field_emp/restore") . '/' . $sigle_emp->content_id; ?>#list" class="btn btn-default btn-xs disabled"> <span class="glyphicon glyphicon-repeat"  title=""></span> Re-join</a> -->
                                                    <a href="<?php echo site_url("CommonController/restore_type_of_employee/search_field_emp/delete") . '/' . $sigle_emp->content_id; ?>#list" class="btn btn-danger btn-xs disabled" onclick="return  ConfirmDelete()" ><span class="glyphicon glyphicon-remove"  title="permanently delete"></span> Delete</a>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                        $sl++;
                                    }
                                    ?>
                                </tbody>

                            </table>

                        </div>
                    </div>








                    <div class="row"  style="padding:10px;">
                        <div class="col-md-12" style=" border: 2px solid #696969;background: #fff">


                            <div class="row" id="list" >
                                <div class="col-md-12">
                                    <div class="title-area">
                                        <h3 class="title text-center" id="page-title">Terminated Employee List(<?php echo $terminated_employee_numbers; ?>) </h3>

                                    </div>

                                </div>
                            </div>


                            <table class="example" id="terminated_list" width="100%" border="0">
                                <button class="btn btn-danger btn-sm pull-left" style="width:130px;margin-right: 5px;margin-top: -15px;" id="ter_del_all"><span class="glyphicon glyphicon-remove"  title=""></span> Delete selected</button>
                                <button class="btn btn-success btn-sm pull-left" style="width:130px;margin-top: -15px;" id="ter_restore_all"><span class="glyphicon glyphicon-repeat"  title=""></span> Re-join selected</button>

                                <thead>
                                    <tr class="heading">
                                         <th style="padding-left: 10px;text-align: left;width:10px!important"><input type='checkbox' class="ter_select_all" id="ter_select_all" value='all' /></th>
                                        <th>Sl</th>
                                        <th>Employee ID</th>
                                        <th>Employee Name</th>
                                        <th>Division Name</th>
                                        <th>Department Name</th>
                                        <th>Position</th>
                                        <th>
                                            Status
                                        </th>
                                        <?php if ($user_type == 1) { ?>
                                            <th style="width:200px">Action</th>
                                        <?php } ?>
                                    </tr>
                                </thead>


                                <tbody>
                                    <?php
                                    $sl = 1;
                                    foreach ($terminated_employee as $sigle_ter_emp) {
                                        ?>
                                        <tr>
                                            <td style="width:10px!important"><input type='checkbox' class="sub_ter_chk"  name='content_id[]' value='<?php echo $sigle_ter_emp->content_id; ?>' /></td>

                                            <td><?php echo $sl; ?></td>
                                            <td><?php echo $sigle_ter_emp->emp_id; ?></td>
                                            <td><?php echo $sigle_ter_emp->emp_name; ?></td>
                                            <td><?php echo $sigle_ter_emp->division; ?></td>
                                            <td><?php echo $sigle_ter_emp->department; ?></td>
                                            <td><?php echo $sigle_ter_emp->designation; ?></td>
                                            <td>
                                                  <?php
                                            if($user_type == 1){
                                            ?>
                                            <a href="#" rel="tooltip" data-placement="top" data-inputclass="select_class"  class="employee_status" id="status" data-type="select" data-title="Change Lock Status" data-pk="<?php echo $sigle_ter_emp->content_id; ?>" data-url="<?php echo base_url(); ?>findemployeelist/employeeLockSystem/search_field_emp" >                                         
                                                <?php
                                            }
                                                if($sigle_ter_emp->status==1){
                                                    echo "<span class='' style='color:green'>active</span> ";
                                                }else if($sigle_ter_emp->status==0){
                                                    echo "<span class='' style='color:red'>Locked</span>";
                                                }
                                                 if($user_type == 1){
                                                     echo "</a>";
                                                 }
                                                ?>     
                                       
                                        
                                            </td>
                                            <?php if ($user_type == 1) { ?>
                                                <td style="width:200px">
                                                                                                <a class="btn btn-default btn-xs" href="<?php echo site_url("addprofile/addemployee") . '/' .$sigle_ter_emp->content_id; ?>" class="operation-edit operation-link ev-edit-link"><span class="glyphicon glyphicon-edit" title="edit"></span>  edit</a>
                                                  <!--  <a href="<?php echo site_url("CommonController/restore_type_of_employee/search_field_emp/restore") . '/' . $sigle_ter_emp->content_id; ?>#terminated_list" class="btn btn-default btn-xs"> <span class="glyphicon glyphicon-repeat"  title=""></span> Re-join</a> -->
                                                    <a href="<?php echo site_url("CommonController/restore_type_of_employee/search_field_emp/delete") . '/' . $sigle_ter_emp->content_id; ?>#terminated_list" class="btn btn-danger btn-xs" onclick="return ConfirmDelete()" ><span class="glyphicon glyphicon-remove"  title="permanently delete"></span> Delete</a>

                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                        $sl++;
                                    }
                                    ?>
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->
                    <!-- XEditable -->
        <script src="<?php echo site_url(); ?>plugins/xeditable/bootstrap-editable.min.js"></script>
    </body>
</html>