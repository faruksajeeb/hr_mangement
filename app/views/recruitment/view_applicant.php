<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>View Applicant</title>
         <?php 
        $user_type = $this->session->userdata('user_type');
        ?>
        <?php
        $this->load->view('includes/cssjs');
        ?> 

        <script>
            $(document).ready(function () {
                
                
                // select all checkbox in tables
                $('#check_all').click(function () {
                    var checked_status = this.checked;
                    $(this).closest('table').find('input:checkbox').each(function () {
                        if(checked_status){
                            this.checked=true;
                         
                     }else{
                         this.checked=false;
                         
                     }
                    });
                });
                
                
                
                
                
                
                $('#myFormmultiple').on('submit',function(e) {
                    var task_val=$('#multiple_task').val();
                      if(task_val == "download_all_applicant_list" || task_val == "download_selected_applicant_list"){
                          $(this).attr('target', '_blank');
                      }
                      $( "#myFormmultiple" ).submit();
                });
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

<!--                            <a href="<?php echo base_url(); ?>recruitment/shortlisted_applicant" class="btn btn-primary pull-right" style="margin: 5px; "><span class="glyphicon glyphicon-list"></span> Shortlisted (<?php echo $shortlist_num_row; ?>)</a>
                            <a href="<?php echo base_url(); ?>recruitment/written_applicant" class="btn btn-primary pull-right" style="margin: 5px;"><span class="glyphicon  glyphicon-list"></span> Written List (<?php echo $written_num_row; ?>)</a>
                            <a href="<?php echo base_url(); ?>recruitment/interview_applicant" class="btn btn-primary pull-right" style="margin: 5px;"><span class="glyphicon  glyphicon-list"></span> Interview List (<?php echo $interview_num_row; ?>)</a>
                            <a href="<?php echo base_url(); ?>recruitment/selected_applicant" class="btn btn-primary pull-right" style="margin: 5px;"><span class="glyphicon  glyphicon-list"></span> Selected (<?php echo $selected_num_row; ?>)</a>
                            <a href="<?php echo base_url(); ?>recruitment/appointed_applicant" class="btn btn-primary pull-right" style="margin: 5px;"><span class="glyphicon  glyphicon-list"></span> Appointed (<?php echo $appointed_num_row; ?>)</a>
                            <a href="<?php echo base_url(); ?>recruitment/joined_applicant" class="btn btn-primary pull-right" style="margin: 5px;"><span class="glyphicon  glyphicon-list"></span> Joined (<?php echo $joined_num_row; ?>)</a>-->
                       <br/>
                       <div class="row">
                           <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="panel panel-default" style="margin-top: 15px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Search Applicant</h3>
                                </div>
                                <div class="panel-body">
                                     <form action="<?php echo base_url(); ?>recruitment/view_applicant" method="post" accept-charset="utf-8" enctype="multipart/form-data"> 
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- sfsaf -->
                                            <div class="row">
                                                <div class="col-md-4">Division:</div>
                                                <div class="col-md-8">
                                                    <?php

                                                    ?>
                                                    <select name="job_division" class="form-control">
                                                        <option value="">All</option>
                                                        <?php
                                                                               
                                                        foreach ($circular_division as $single_division) {  
                                                            if ($single_division) {                                                                
                                                                echo '<option value="' . $single_division->DivisionID . '">' . $single_division->record_name . '</option>';
                                                            }
                                                        }
                                                        ?>                  
                                                    </select>                       
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">Job Title:</div>
                                                <div class="col-md-8">
                                                    <?php

                                                    ?>
                                                    <select name="job_post" class="form-control">
                                                        <option value="">All</option>
                                                        <?php
                                                                               
                                                        foreach ($circular_post as $single_post) {  
                                                            if ($single_post) {                                                                
                                                                echo '<option value="' . $single_post->PostID . '">' . $single_post->record_name . '</option>';
                                                            }
                                                        }
                                                        ?>                  
                                                    </select>                       
                                                </div>
                                            </div>  
                                              <div class="row">
                                                <div class="col-md-4">Status:</div>
                                                <div class="col-md-8">
                                                    
                                                    <select name="applicant_status" class="">
                                                       
                                                        <option value="0">Applied</option>
                                                        <option value="1">Shortlisted</option>                
                                                        <option value="2">Written</option>                
                                                        <option value="3">Interview</option>                
                                                        <option value="4">Selected</option>                
                                                        <option value="5">Applointed</option>                
                                                        <option value="6">Joined</option>                
                                                    </select>                       
                                                </div>
                                            </div>  
                                      
                                             
                                              
 
                                            <!-- sldks -->
                                        </div>
                                        <div class="col-md-6">
                                            
                                        

                                            <div class="row">
                                                <div class="col-md-4">Apply Date:</div>
                                                <div class="col-md-8">From<input type="text" name="applied_from" id="apply_date_from1" class="datepicker" placeholder="dd-mm-yyyy"></div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-8">To<input type="text" name="applied_to" id="apply_date_to1" class="datepicker" placeholder="dd-mm-yyyy"></div>
                                            </div>
                                                                                                   
                                            <!-- kdjsfkd -->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4"><input type="submit" name="multiple_search_btn" class="btn btn-default " style="width:100%" value="Search" id="search_button"></div>
                                        <div class="col-md-4"></div>
                                    </div>
                                </form>
                                </div>
                            </div>                                  
                        </div>
                           <div class="col-md-2"></div>
                    </div>
                       <div class="row under-header-bar text-center" style="padding: 10px;"> 
                              
                    <h4>
                        <span class="glyphicon glyphicon-list"></span> 
                        <?php  
                        $applicant_status=$this->session->userdata('applicant_status');
                        if($applicant_status==1){
                            echo "Shortlisted";
                        }else if($applicant_status==2){
                            echo "Written";
                        }else if($applicant_status==3){
                            echo "Interview";
                        }else if($applicant_status==4){
                            echo "Selected";
                        }else if($applicant_status==5){
                            echo "Appointed";
                        }else if($applicant_status==6){
                            echo "Joined";
                        }else{
                            echo "New";
                        }
                        ?>
                        Applicant List (<?php echo $num_row; ?>)</h4>         
                </div> 
                       <form action="<?php echo base_url();?>recruitment/submitMultipleTask" method="POST"  id="myFormmultiple"  name="myFormmultiple" >
                               <?php if ($user_type == 1) { ?>  
                       <div class="row" style="border:3px solid #ccc;width: 550px;padding: 1px;">
                                                                  
                                 <div class="col-md-3" style=""> Task Type:</div>
                                <div class="col-md-6" style="padding-left: 0;">
                              
                                    <select name="multiple_task" id="multiple_task" style="" required=""> 
                                        <option value="">-- Select Task --</option> 
                                        <option value="download_all_applicant_list" style="border-bottom:1px solid #ccc;"><span class="glyphicon glyphicon-download"></span> Download All Candidates List</option>
                                        <option value="download_selected_applicant_list"  style="border-bottom:1px solid #ccc;"><span class="glyphicon glyphicon-download"></span> Download Selected Candidates List</option>
                                        <option value="delete_selected_list"  style="border-bottom:1px solid #ccc;"><span class="glyphicon glyphicon-remove-circle"></span> Delete Selected List</option>
                                      
                                      <?php if($applicant_status==1){ ?>
                                        <option value="selected_list_written"  style="border-bottom:1px solid #ccc;"> Written Selected List</option>
                                         <?php  }else if($applicant_status==2){ ?>
                                        <option value="selected_list_interview"  style="border-bottom:1px solid #ccc;"> Interview Selected List</option>
                                         <?php  }else if($applicant_status==3){ ?>
                                        <option value="selected_list_selected"  style="border-bottom:1px solid #ccc;"> Selected Selected List</option>
                                         <?php  }else if($applicant_status==4){ ?>
                                        <option value="selected_list_appointed"  style="border-bottom:1px solid #ccc;"> Appointed Selected List</option>
                                         <?php  }else if($applicant_status==5){ ?>
                                        <option value="selected_list_joined"  style="border-bottom:1px solid #ccc;"> Joined Selected List</option>
                                        
                                         <?php  }else if($applicant_status==6){ ?>
                                       <?php }else{?>
                                            <option value="selected_list_shorted"  style="border-bottom:1px solid #ccc;"> Short Selected List</option>
                                     
                                        
                                         <?php } ?>
                                    </select>
                               
                                  
                                </div>
                                 <div class="col-md-3" style="padding-left: 0px; height: 15px;"><button style="" class="btn btn-sm btn-warning" type="submit" value="">Execute</button></div>
                                
                            </div>
                              <?php } ?>
                          
                            <table id="example" class="display" cellspacing="0" width="100%" border="1">
                                <thead>
                                    <tr class="heading">
                                        <th style="padding-left: 10px;text-align: left;width:10px!important"><input type='checkbox' class="check_all" id="check_all" value='all' /></th>
                                
                                        <th>Sl no.</th>
                                        <th>Image</th>
                                        <th>Applicant Name</th>
                                        
                                        <!--<th>Applicant Email</th>-->
                                        <th>Career Summary</th>
                                        <th>Experience</th>
                                        <th>Expected Salary</th>
                                        <!--<th>Phone</th>-->
                                        <th>Post Name</th>
                                        <th>Status</th>
                                        <th>Applied on</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tfoot>
                                     <th style="padding-left: 10px;text-align: left;width:10px!important"></th>
                                
                                        <th>Sl no.</th>
                                        <th>Image</th>
                                        <th>Applicant Name</th>
                                        <!--<th>Applicant Email</th>-->
                                        <th>Career Summary</th>
                                        <th>Experience</th>
                                        <th>Expected Salary</th>
                                        <!--<th>Phone</th>-->
                                        <th>Post Name</th>
                                        <th>Status</th>
                                        <th>Applied on</th>
                                        <th></th>
                                </tfoot>

                                <tbody>
                                    <?php
                                    $sl_no = 1;
                                    foreach ($all_applicant as $single_applicant) {
                                        ?>
                                        <tr class="separator">
                                             <td style="width:10px!important"><input type='checkbox' name='applicant_id[]' value='<?php print $single_applicant->ApplicantID; ?>' /></td>                                   
                                            <td><?php echo $sl_no; ?></td>
                                            <td><img src="<?php echo base_url().$single_applicant->ApplicantImage; ?>" width="30" /></td>
                                            <td style="text-align:left;">
                                                <?php echo nl2br ("<strong>".$single_applicant->ApplicantName."</strong> \r\n Age: ".$single_applicant->Age." \r\n ".$single_applicant->LastInstitute." "
                                                        . " \r\n <a href='callto:".$single_applicant->ApplicantPhone."'>".$single_applicant->ApplicantPhone ."</a> "
                                                        . " \r\n <span class='glyphicon glyphicon-envelope'  ></span> <a href='mailto:".$single_applicant->ApplicantEmail." '> ".$single_applicant->ApplicantEmail ."</a>"); ?> 
                                            </td>
                                           
                                            <td style="text-align:left;"> <?php echo $single_applicant->ExpDetail; ?></td>
                                                <td> <?php echo $single_applicant->TotalExp ." years" ; ?></td>
                                                <td><?php echo $single_applicant->ExpSalary. " Tk" ; ?></td>
                                            
                                            <!--<td><span class="glyphicon glyphicon-earphone" title="Trash"  ></span> <?php echo $single_applicant->ApplicantPhone; ?></td>-->
                                            <td><?php echo $single_applicant->post_name; ?></td>
                                            <td><?php 
                                            
                                            
                                            if($single_applicant->Status==0){
                                                echo "<span class='label label-default'>Applied</span>";
                                            }else if($single_applicant->Status==1){
                                                echo "Shortlisted";
                                            }else if($single_applicant->Status==2){
                                                echo "Written";
                                            }else if($single_applicant->Status==3){
                                                echo "Interview";
                                            }else if($single_applicant->Status==4){
                                                echo "Selected";
                                            }else if($single_applicant->Status==5){
                                                echo "Appointed";
                                            }else if($single_applicant->Status==6){
                                                echo "Joined";
                                            }
                                            
                                            ?></td>
                                            
                                            <td><?php $appliedOn = date_create($single_applicant->AppliedTime);
                                    echo date_format($appliedOn, 'F j, Y'); 
                                   
                                        ?></td>
 
                                            <td>
                                                <a href="<?php echo base_url(); ?>recruitment/applicant_detail_by_id/<?php echo $single_applicant->ApplicantID ?>" class="btn btn-default  btn-xs"><span class="glyphicon glyphicon-zoom-in" title="View"></span> view</a>
                                                <?php if($single_applicant->Status==0){ ?>
                                                <a href="<?php echo base_url(); ?>recruitment/update_applicant_status/shortlist/<?php echo $single_applicant->ApplicantID ?>" class="btn btn-success  btn-xs"><span class="glyphicon glyphicon-ok" title="Short List"></span> Shortlist</a>
                                                <?php }else if($single_applicant->Status==1){ ?>
                                                 <a href="<?php echo base_url(); ?>recruitment/update_applicant_status/written/<?php echo $single_applicant->ApplicantID ?>" class="btn btn-success  btn-xs"><span class="glyphicon glyphicon-ok" title="Short List"></span> Written</a>
                                                                                               
                                                 <?php }else if($single_applicant->Status==2){  ?>
                                                  <a href="<?php echo base_url(); ?>recruitment/update_applicant_status/interview/<?php echo $single_applicant->ApplicantID ?>" class="btn btn-success  btn-xs"><span class="glyphicon glyphicon-ok" title="Short List"></span> Interview</a>
                                                
                                                  <?php }else if($single_applicant->Status==3){  ?>
                                                  <a href="<?php echo base_url(); ?>recruitment/update_applicant_status/selected/<?php echo $single_applicant->ApplicantID ?>" class="btn btn-success  btn-xs"><span class="glyphicon glyphicon-ok" title="Short List"></span> Selected</a>
                                               
                                                  <?php }else if($single_applicant->Status==4){  ?>
                                                   <a href="<?php echo base_url(); ?>recruitment/update_applicant_status/appointed/<?php echo $single_applicant->ApplicantID ?>" class="btn btn-success  btn-xs"><span class="glyphicon glyphicon-ok" title=""></span> appointed</a>
                                                                                                 
                                                  <?php }else if($single_applicant->Status==5){  ?>
                                                  <a href="<?php echo base_url(); ?>recruitment/update_applicant_status/joined/<?php echo $single_applicant->ApplicantID ?>" class="btn btn-success  btn-xs"><span class="glyphicon glyphicon-ok" title=""></span> Joined</a>
                                                
                                                  <?php }?>
                                                <a href="<?php echo base_url(); ?>recruitment/trash_applicant_by_id/view/<?php echo $single_applicant->ApplicantID ?>" class="btn btn-danger  btn-xs" onclick="return checkDelete()"><span class="glyphicon glyphicon-remove-circle" title="Trash"  >Reject</span> </a>
                                            </td>
                                        </tr>
                                        <?php $sl_no++;
                                    }
                                    ?>
                                </tbody>
                            </table>  
                        </form>

                        </div>
                    </div> 

                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->        
    </body>
</html>