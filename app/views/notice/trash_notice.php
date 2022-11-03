<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trash Notice</title>
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
                <h4>Trash Notice</h4>         
            </div> 
            <div class="wrapper">
                 
                <div class="row">
                    <div class="col-md-12">
                   
                    <table id="example" class="display" cellspacing="0" width="100%" border="1">
                            <thead>
                                <tr class="heading">
                                    <th>Sl no.</th>
                               <th>Notice Name</th>
                                        <th>Short Description</th>                              
                                        <th>Published On</th> 
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tfoot>
                              
                            </tfoot>

                            <tbody>
                                <?php
                                $sl_no=1;
                                foreach ($all_trash_notice as $single_notice) {
                               
                                    ?>
                                    <tr>
                                        <td><?php echo $sl_no;?></td>
                                        <td><?php echo $single_notice->NoticeName;?></td>
                                        <td><?php echo $single_notice->ShortDescription;?></td>
                                        <td><?php echo $single_notice->PublishedOn;?></td>
                                    
                                        <td>                                        
                                          <a href="<?php echo base_url();?>notice/restore_notice/<?php echo $single_notice->NoticeID ?>" class="btn btn-warning  btn-xs"><span class="glyphicon glyphicon-repeat" title="Approve"></span> Restore</a>
                                        <a href="<?php echo base_url();?>notice/parmanently_delete_notice/<?php echo $single_notice->NoticeID ?>" class="btn btn-danger  btn-xs" onclick="return checkDelete()"><span class="glyphicon glyphicon-remove" title="Delete"  > </span>Permanently Delete  </a>
                               
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