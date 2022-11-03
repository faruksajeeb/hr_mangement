<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Trash Employee</title>
        <?php
        $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type');
        $this->load->view('includes/cssjs');
        ?>
        <script>
            $(document).ready(function () {

                $('.example').dataTable({
                    "lengthMenu": [[15, 30, 50, -1], [15, 30, 50, "All"]],
                    //paging: false,
                    paging: true, //changed by sajeeb
                    "autoWidth": false,
                    //"searching": false,
                    "info": false,
                });


            });
           







            function ConfirmDelete()
            {
                var x = confirm("Are you sure you want to Permanently delete this? If you delete this, you permanently lost all data this employee. ");
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
         
                    <div class="row" class="table_greed" style="padding:10px;">
                        <div class="col-md-12" style=" border: 2px solid #696969;background: #fff;">


                            <div class="row" id="list">
                                <div class="col-md-12">
                                    <div class="title-area">
                                        <h3 class=" text-center" id="">Trash Employee List(<?php echo $delete_employee_numbers; ?>) </h3>

                                    </div>

                                </div>
                            </div>
                            <div class="row clear_fix"><div class="col-md-12" id="respose" style="margin-bottom:5px "></div></div>

                            <table class="example"  width="100%" border="0">
                       <thead>

                                    <tr class="heading">
                                  
                                        <th>Sl</th>
                                        <th>Employee ID</th>
                                        <th>Employee Name</th>
                                        <th>Division Name</th>
                               
                                        <th>Position</th>
                                        <?php if ($user_type == 1 && $user_id==6) { ?>
                                            <th style="width:200px">Action</th>
                                        <?php } ?>
                                    </tr>
                                </thead>


                                <tbody>
                                    <?php
                                    $sl = 1;
                                    foreach ($delete_employee as $sigle_emp) {
                                        ?>
                                        <tr content_id="<?php echo $sigle_emp->content_id; ?>">
                                        <td><?php echo $sl; ?></td>
                                            <td><?php echo $sigle_emp->emp_id; ?></td>
                                            <td><?php echo $sigle_emp->emp_name; ?></td>
                                            <td><?php echo $sigle_emp->division; ?></td>
                                 
                                            <td><?php echo $sigle_emp->designation; ?></td>
                                            <?php if ($user_type == 1 && $user_id== 6) { ?>
                                                <td >
                                                    <a href="<?php echo site_url("CommonController/restore_delete_employee/search_field_emp") . '/' . $sigle_emp->content_id; ?>#list" class="btn btn-default btn-xs"> <span class="glyphicon glyphicon-repeat"  title=""></span> Restore</a>
                                                    <a href="<?php echo site_url("addprofile/deleteemployee") . '/' . $sigle_emp->content_id; ?>#list" class="btn btn-danger btn-xs" onclick="return  ConfirmDelete()" >
                                                        <span class="glyphicon glyphicon-remove"  title="permanently delete with all documnent"></span>Finally Delete</a>
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
    </body>
</html>