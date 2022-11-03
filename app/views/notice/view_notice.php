<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View Notice</title>
        <?php
        $this->load->view('includes/cssjs');
        ?> 

        <script>
            $(document).ready(function () {
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

            });
            function checkDelete()
            {
                var x = confirm("Are you sure you want to delete?");
                if (x)
                    return true;
                else
                    return false;
            }

        </script>    
    </head>
    <body class="logged-in dashboard current-page add-division">
        <!-- Page Content -->  
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php
                $this->load->view('includes/menu');
                ?>
                <div class="row under-header-bar text-center"> 
                    <h4>View Notice</h4>         
                </div> 
                <div class="wrapper">

                    <div class="row">
                        <div class="col-md-12">
  <?php
                                $err = $this->session->userdata('error');
                                if ($err) {
                                    echo $err;
                                    $this->session->unset_userdata('error');
                                }                             
                                $msg = $this->session->userdata('message');
                                if ($msg) {
                                    echo $msg;
                                    $this->session->unset_userdata('message');
                                }
                                ?>

                            <a href="<?php echo base_url(); ?>notice/trash_notice" class="btn btn-default  btn-xs pull-left" style="margin-top: 5px;" ><span class="glyphicon glyphicon-trash" title="Trash"  ></span> Trash</a>

<a href="http://ahmedamin.com/master_controller/media_centre/press_release" target="_blank" class="" style="position:absolute; top:10px; margin-bottom: 35px;margin-left: 15px;" >Notice on web</a>

                            <a href="<?php echo base_url(); ?>notice/insert_notice" class="btn btn-primary pull-right" style="margin-top: 5px;"><span class="glyphicon-plus"></span> Add a New Notice</a>
                            <table id="example" class="display" cellspacing="0" width="100%" border="1">
                                <thead>
                                    <tr class="heading">
                                        <th>Sl no.</th>

                                        <th>Notice Name</th>
                                        <th>Short Description</th>                              
                                        <th>Published On</th>                              
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tfoot>

                                </tfoot>

                                <tbody>
                                    <?php
                                    $sl_no = 1;
                                    foreach ($all_notice as $single_notice) {
                                        ?>
                                        <tr>
                                            <td><?php echo $sl_no; ?></td>

                                            <td>

                                                <a href="<?php echo base_url(); ?>notice/notice_detail_by_id/<?php echo $single_notice->NoticeID ?>" >
                                                    <?php echo $single_notice->NoticeName; ?>
                                                </a>


                                            </td>
                                            <td><?php echo $single_notice->ShortDescription; ?></td>
                                            <td>
                                            
                                            <?php $PublishedOn = date_create($single_notice->PublishedOn);
                                    echo date_format($PublishedOn, 'F j, Y');
                                        ?>
                                            </td>

                                            <td>
                                                <?php 
                                                
                                                if ($single_notice->PublicationStatus == 1) { ?>

                                                    <span class="" style="color:green;">
                                                        Published
                                                    </span>


                                                        <?php }else if ($single_notice->PublicationStatus == 0) {
                                                        ?>
                                                    <span style="color: #ff9900;" >
                                                        Unpublished
                                                    </span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php
                                            
                                            if ($single_notice->PublicationStatus == 0) {
                                                ?>
                                                <a href="<?php echo base_url(); ?>notice/status/publish/<?php echo $single_notice->NoticeID ?>" class="btn btn-success  btn-xs"><span class="glyphicon glyphicon-arrow-up" title="Publish"></span></a>
                                                <?php
                                            }
                                            if ($single_notice->PublicationStatus == 1) {
                                                ?>
                                                <a href="<?php echo base_url(); ?>notice/status/unpublish/<?php echo $single_notice->NoticeID ?>" class="btn btn-warning  btn-xs"><span class="glyphicon glyphicon-arrow-down" title="Unpublish"></span></a>

                                                <?php
                                            }
                                            ?>
                                            <a href="<?php echo base_url(); ?>notice/notice_edit_by_id/<?php echo $single_notice->NoticeID ?>" class="btn btn-default  btn-xs"><span class="glyphicon glyphicon-edit" title="Edit"></span></a>
                                            <a href="<?php echo base_url(); ?>notice/delete_notice/<?php echo $single_notice->NoticeID ?>" class="btn btn-danger  btn-xs" onclick="return checkDelete()"><span class="glyphicon glyphicon-trash" title="Trash"  ></span></a>

                                        </td>
                                    </tr>
<?php 
$sl_no++;
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