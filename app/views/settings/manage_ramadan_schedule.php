<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ramadan Schedule</title>
        <?php
        $this->load->view('includes/cssjs');
        $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type');
        ?> 

        <script>
            $(document).ready(function () {

                $('.add').click(function () {
                    $("#tag").html("<i class='fa fa-plus'></i>  Add");
                    $("#tag_save_btn").html("Data");
                    document.getElementById("schedule-form").reset();
                });
                $('.update').click(function () {
                    // alert(0);
                    $("#tag").html("<span class='glyphicon glyphicon-pencil'></span>  Edit");
                    $("#tag_save_btn").html("Changes");
                    var id = $(this).data('id');
                    var year = $(this).data('year');
                    var start_date = $(this).data('start_date');
                    var end_date = $(this).data('end_date');
                    var late_count_time = $(this).data('late_count_time');
                    var early_count_time = $(this).data('early_count_time');
                    $('#id').val(id);
                    $('#ramadan_year').val(year);
                    $('#start_date').val(start_date);
                    $('#end_date').val(end_date);
                    $('#late_count_time').val(late_count_time);
                    $('#early_count_time').val(early_count_time);

                });
            });

        </script>    
        <style>

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
                    <h4>  <span class="glyphicon glyphicon-time"> </span> Ramadan Schedule</h4>         
                </div> 
                <div class="wrapper">   









                    <script>

                        $(function () {



                        });

                    </script>
                    <!-- MAIN CONTENT -->
                    <div id="content">


                        <!-- widget grid -->
                        <section id="widget-grid" class="">

                            <!-- row -->
                            <div class="row">

                                <!-- NEW WIDGET START -->
                                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                    <!-- Widget ID (each widget will need unique ID)-->
                                    <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                                        <!-- widget options:
                                        usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
                    
                                        data-widget-colorbutton="false"
                                        data-widget-editbutton="false"
                                        data-widget-togglebutton="false"
                                        data-widget-deletebutton="false"
                                        data-widget-fullscreenbutton="false"
                                        data-widget-custombutton="false"
                                        data-widget-collapsed="true"
                                        data-widget-sortable="false"
                    
                                        -->
                                        <header>
                                            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                                            <h2>  <span style="font-size:25px" class="glyphicon glyphicon-time"> </span> Ramadan Schedule </h2>

                                            <a href="" class="pull-right btn btn-default add" data-toggle="modal" data-target="#exampleModal">  <span style="font-size:15px" class="glyphicon glyphicon-time"> </span>  Add Schedule</a>

                                        </header>

                                        <!-- widget div-->
                                        <div>

                                            <!-- widget edit box -->
                                            <div class="jarviswidget-editbox">
                                                <!-- This area used as dropdown edit box -->

                                            </div>
                                            <!-- end widget edit box -->

                                            <!-- widget content -->
                                            <div class="widget-body no-padding">

                                                <table id="" class="display"  width="100%">
                                                    <thead>			                
                                                        <tr>

                                                            <th data-hide="phone">ID</th>
                                                            <th data-class="expand"> Year </th>
                                                            <th data-class="expand"> Start Date </th>
                                                            <th data-class="expand"> End Date </th>
                                                            <th data-class="expand">Late Count Time </th>
                                                            <th data-class="expand">Early Count Time </th>
                                                            <th data-hide="phone,tablet">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($display_all_ramadan_info AS $single_info) {
                                                            ?>
                                                            <tr>

                                                                <td><?php echo $i; ?></td>
                                                                <td>

                                                                    <?php echo $single_info->year; ?>

                                                                </td>
                                                                <td><?php echo $single_info->start_date; ?></td>
                                                                <td><?php echo $single_info->end_date; ?></td>
                                                                <td><?php echo $single_info->late_count_time; ?></td>
                                                                <td><?php echo $single_info->early_count_time; ?></td>

                                                                <td>   

                                                                    <a data-toggle="modal" data-target="#exampleModal"  class="btn  btn-xs update"  
                                                                       data-id="<?php echo $single_info->id; ?>" 
                                                                       data-year="<?php echo $single_info->year; ?>" 
                                                                       data-start_date="<?php echo $single_info->start_date; ?>" 
                                                                       data-end_date="<?php echo $single_info->end_date; ?>" 
                                                                       data-late_count_time="<?php echo $single_info->late_count_time; ?>" 
                                                                       data-early_count_time="<?php echo $single_info->early_count_time; ?>"
                                                                       title="Edit">
                                                                        <span style="font-size:15px" class="glyphicon glyphicon-pencil"> </span>
                                                                    </a>

                                                                    <a class="btn btn-xs delete" style="color:#cc0033; " table_name="task"  title="Delete" id="" data_name="">
                                                                        <span style="font-size:15px" class="glyphicon glyphicon-trash"> </span>
                                                                    </a>


                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                        ?>

                                                    </tbody>
                                                </table>

                                            </div>
                                            <!-- end widget content -->

                                        </div>
                                        <!-- end widget div -->

                                    </div>
                                    <!-- end widget -->




                                </article>
                                <!-- WIDGET END -->

                            </div>

                            <!-- end row -->

                            <!-- end row -->

                        </section>
                        <!-- end widget grid -->

                    </div>
                    <!-- END MAIN CONTENT -->


                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal"  data-backdrop="static" data-keyboard="false"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog " role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <a type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        &times;
                                    </a>
                                    <h4 class="modal-title" id="myModalLabel"><strong><span id="tag"></span>   <span style="font-size:15px" class="glyphicon glyphicon-time"> </span> ramadan schedule</strong></h4>
                                </div>
                                <div class="modal-body">
                                    <form id="schedule-form" action="<?php echo base_url() ?>ramadan/save_ramadan_schedule" method="POST" class="smart-form">
                                        <input type="hidden" class="" name="id" id="id"  />

                                        <fieldset>
                                            <section>
                                                <div class="row">
                                                    <label class="col-md-4">Ramadan Year : </label>
                                                    <div class="col col-md-4">
                                                        <input type="text" class="form-control ckeck_exists"  name="ramadan_year" id="ramadan_year" placeholder="yyyy" required="" />

                                                    </div>
                                                    <span class="col-md-4" style="color:#ccc;font-size:12px;"> year example: 2018 </span>

                                                </div>
                                            </section><br/>

                                            <section>
                                                <div class="row">
                                                    <label class="col-md-4">Ramadan Start Date : </label>
                                                    <div class="col col-md-4">
                                                        <input type="text" class="form-control datepicker "  name="start_date" id="start_date" placeholder="dd-mm-yyyy" required=""  />

                                                    </div>
                                                    <span class="col-md-4" style="color:#ccc;font-size:12px;"> Date Format: dd-mm-yyyy </span>

                                                </div>
                                            </section><br/>
                                            <section>
                                                <div class="row">
                                                    <label class="col-md-4">Ramadan End Date : </label>
                                                    <div class="col col-md-4">
                                                        <input type="text" class="form-control datepicker"  name="end_date" id="end_date" placeholder="dd-mm-yyyy" required=""  />

                                                    </div>
                                                    <span class="col-md-4" style="color:#ccc;font-size:12px;"> Date Format: dd-mm-yyyy </span>

                                                </div>
                                            </section><br/>
                                            <section>
                                                <div class="row">
                                                    <label class="col-md-4">Late Count Time : </label>
                                                    <div class="col col-md-4">
                                                        <input type="text" class="form-control timepicker"  name="late_count_time" id="late_count_time" placeholder="00:00:00" required=""  />

                                                    </div>
                                                    <span class="col-md-4" style="color:#ccc;font-size:12px;"> Time Format(24 hr): hh:mm:ss </span>

                                                </div>
                                            </section><br/>
                                            <section>
                                                <div class="row">
                                                    <label class="col-md-4">Early Count Time : </label>
                                                    <div class="col col-md-4">
                                                        <input type="text" class="form-control timepicker"  name="early_count_time" id="early_count_time" placeholder="00:00:00" required=""  />

                                                    </div>
                                                    <span class="col-md-4" style="color:#ccc;font-size:12px;"> Time Format(24 hr): hh:mm:ss </span>

                                                </div>
                                            </section>
                                        </fieldset>

                                        <footer>
                                            <button id="button-ok-category" type="submit" style="width:150px" class="btn btn-sm btn-primary pull-right">

                                                Save  <span id="tag_save_btn"></span>
                                            </button>
                                            <a type="button" class="btn btn-default" data-dismiss="modal">
                                                Cancel
                                            </a>

                                        </footer>
                                    </form>	


                                </div>

                                <!--</form>-->
                            </div>
                        </div>
                    </div>
                    <!-- /.modal -->

                  
























                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->        
    </body>
</html>