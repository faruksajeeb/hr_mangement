<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Written Applicant List</title>
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
                    <h4>Written Applicant List(<?php echo $written_num_row; ?>)</h4>         
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

                            <a href="<?php echo base_url(); ?>recruitment/trash_applicant" class="btn btn-default  btn-xs pull-left" style="margin-top: 5px;" ><span class="glyphicon glyphicon-trash" title="Trash"  ></span> Trash(<?php echo $trash_num_row; ?>)</a>
                          <a href="<?php echo base_url(); ?>recruitment/interview_applicant" class="btn btn-primary pull-right" style="margin: 5px;"><span class="glyphicon  glyphicon-list"></span> Interview List (<?php echo $interview_num_row; ?>)</a>
                            <a href="<?php echo base_url(); ?>recruitment/selected_applicant" class="btn btn-primary pull-right" style="margin: 5px;"><span class="glyphicon  glyphicon-list"></span> Selected (<?php echo $selected_num_row; ?>)</a>
                            <a href="<?php echo base_url(); ?>recruitment/appointed_applicant" class="btn btn-primary pull-right" style="margin: 5px;"><span class="glyphicon  glyphicon-list"></span> Appointed (<?php echo $appointed_num_row; ?>)</a>
                            <a href="<?php echo base_url(); ?>recruitment/joined_applicant" class="btn btn-primary pull-right" style="margin: 5px;"><span class="glyphicon  glyphicon-list"></span> Joined (<?php echo $joined_num_row; ?>)</a>
                            <style>


                            </style>
                            <table id="example" class="display" cellspacing="0" width="100%" border="1">
                                <thead>
                                    <tr class="heading">
                                        <th>Sl no.</th>
                                        <th>Image</th>
                                        <th>Applicant Name</th>
                                        <th>Applicant Email</th>
                                        <th>Phone</th>
                                        <th>Post Name</th>
                                        <th>Applied on</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tfoot>

                                </tfoot>

                                <tbody>
                                    <?php
                                    $sl_no = 1;
                                    foreach ($all_written_applicant as $single_applicant) {
                                        ?>
                                        <tr class="separator">
                                            <td><?php echo $sl_no; ?></td>
                                            <td><img src="<?php echo base_url() . $single_applicant->ApplicantImage; ?>" width="30" /></td>
                                            <td><?php echo $single_applicant->ApplicantName; ?></td>
                                            <td><span class="glyphicon glyphicon-envelope" title="Trash"  ></span> <?php echo $single_applicant->ApplicantEmail; ?></td>
                                            <td><span class="glyphicon glyphicon-earphone" title="Trash"  ></span> <?php echo $single_applicant->ApplicantPhone; ?></td>
                                            <td><?php echo $single_applicant->post_name; ?></td>
                                            <td><?php $appliedOn = date_create($single_applicant->AppliedTime);
                                    echo date_format($appliedOn, 'F j, Y');
                                        ?></td>

                                            <td>
                                                <a href="<?php echo base_url(); ?>recruitment/applicant_detail_by_id/<?php echo $single_applicant->ApplicantID ?>" class="btn btn-default  btn-xs"><span class="glyphicon glyphicon-zoom-in" title="View"></span> view more</a>
                                                <a href="<?php echo base_url(); ?>recruitment/update_applicant_status/interview/<?php echo $single_applicant->ApplicantID ?>" class="btn btn-success  btn-xs"><span class="glyphicon glyphicon-ok" title="Short List"></span> Interview</a>
                                                <a href="<?php echo base_url(); ?>recruitment/trash_applicant_by_id/written/<?php echo $single_applicant->ApplicantID ?>" class="btn btn-danger  btn-xs" onclick="return checkDelete()"><span class="glyphicon glyphicon-remove-circle" title="Trash"  ></span> reject</a>
                                            </td>
                                        </tr>
                                        <?php $sl_no++;
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