<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trash Circular</title>
    <?php
    $this->load->view('includes/cssjs');
    ?> 

    <script>
        $(document).ready(function(){
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
            $this -> load -> view('includes/menu');
            ?>
            <div class="row under-header-bar text-center"> 
                <h4>Trash Circular</h4>         
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
                    <table id="example" class="display" cellspacing="0" width="100%" border="1">
                            <thead>
                                <tr class="heading">
                                    <th>Sl no.</th>
                                    <th>Banner</th>
                                    <th>Post Name</th>
                                    <th>Division Name</th>
                                    <th>Start Date</th>
                                    <th>Last Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tfoot>
                              
                            </tfoot>

                            <tbody>
                                <?php
                                $sl_no=1;
                                foreach ($all_circular as $single_job) {
                               
                                    ?>
                                    <tr>
                                        <td><?php echo $sl_no;?></td>
                                        <td><img src="<?php echo base_url().$single_job->BannerImage;?>" width="30" /></td>
                                        <td><?php echo $single_job->post_name;?></td>
                                        <td><?php echo $single_job->division_name;?></td>
                                        <td><?php echo $single_job->StartDate;?></td>
                                        <td><?php echo $single_job->EndDate;?></td>
                                        <td><?php
                                        $date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
                                        $current_date=$date->format('Y-m-d');
                                        if($single_job->EndDate < $current_date){
                                            echo '<font color=red>Expired!</font>';
                                        }else{
                                        
                                        if ($single_job->PublicationStatus == 0) { ?> 
                                            <span class="" style="color: #ff9900">
                                            pending...
                                    </span>
                                        
                                    <?php }if($single_job->PublicationStatus == 1){ ?>
                                    
                                        <span class="" style="color:green;">
                                            Published
                                        </span>
                                        
                                        
                                        <?php
                                    } if($single_job->PublicationStatus == -1){ ?>
                                        <span style="color: #ff9900;" >
                                            Unpublished
                                        </span>
                                        <?php }} ?>
                                        </td>
                                        <td>
                                        
                                              <a href="<?php echo base_url();?>recruitment/restore_circular/<?php echo $single_job->CircularID ?>" class="btn btn-warning  btn-xs"><span class="glyphicon glyphicon-repeat" title="Approve"></span> Restore</a>
                                     <a href="<?php echo base_url();?>recruitment/post_detail_by_id/<?php echo $single_job->CircularID ?>" class="btn btn-default  btn-xs"><span class="glyphicon glyphicon-zoom-in" title="View"></span></a>
                                          <a href="<?php echo base_url();?>recruitment/parmanently_delete_circular/<?php echo $single_job->CircularID ?>" class="btn btn-danger  btn-xs" onclick="return checkDelete()"><span class="glyphicon glyphicon-remove" title="Trash"  > </span> </a>
                               
                                        </td>
                                    </tr>
                                    <?php $sl_no++; } ?>
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