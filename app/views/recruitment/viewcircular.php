<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Circular</title>
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
function ConfirmDelete()
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
                <h4>View Circular</h4>         
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <nav>
                        <?php print $this->pagination->create_links(); ?>
                        </nav>
                    </div>
                </div>            
                <div class="row">
                    <div class="col-md-12">
                    <?php if($records){
                    ?>
                        <table id="example" class="display" cellspacing="0" width="100%" border="1">
                            <thead>
                                <tr class="heading">
                                    <th>Post Name</th>
                                    <th>Start Date</th>
                                    <th>Last Date</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>Post Name</th>
                                    <th>Start Date</th>
                                    <th>Last Date</th>
                                    <th>Edit</th>
                                </tr>
                            </tfoot>

                            <tbody>
                                <?php
                                foreach ($records as $single_records) {
                                    $id = $single_records['id'];
                                    $position_id = $single_records['position_id'];
                                    $post_data=$this->taxonomy->getTaxonomyBytid($position_id);
                                    $Start_Date = $single_records['Start_Date'];
                                    $Last_Date = $single_records['Last_Date'];
                                    //$description = $single_records['description'];
                                    ?>
                                    <tr>
                                        <td><?php print $post_data['name']; ?></td>
                                        <td><?php print $Start_Date; ?></td>
                                        <td><?php print $Last_Date; ?></td>
                                        <td>
                                            <a href="<?php echo site_url("recruitment/post_circular") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit ev" /></a>
                                            <a href="<?php echo site_url("recruitment/deletecircular") . '/' . $id; ?>" class="operation-cut operation-link" onClick="return ConfirmDelete()"> <img src="<?php echo base_url(); ?>resources/images/cut.jpg" alt="edit" /></a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>  
                            <?php }else{
                                print "<h1><i>Sorry, no vacancy available at this moment. </i></h1>";
                                } ?>                      
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <nav>
                            <?php print $this->pagination->create_links(); ?>
                            </nav>
                        </div>
                    </div>                                 
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->        
    </body>
    </html>