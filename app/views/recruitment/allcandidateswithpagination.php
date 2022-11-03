<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome to content page</title>
        <?php 
        $user_type = $this->session->userdata('user_type');
        ?>    
        <?php
        $this->load->view('includes/cssjs');
        ?>
        <script>
            $(document).ready(function () {
                $('#example').dataTable({
                    //"lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]]
                    paging: false,
                    "autoWidth": false,
                    //"searching": false,
                    "info": false,
                    "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0 ] }  ]
                });


                jQuery("#applicant_per_page").change(function (e) {
                    var applicant_per_page = $(this).val();
                    var search_page = "findcandidates";
                    if (!applicant_per_page) {
                        applicant_per_page = 12;
                    }
                    var base_url = '<?php echo base_url(); ?>';
                    var postData = {
                        "applicant_per_page": applicant_per_page,
                        "search_page": search_page                         
                    };
 
                    $.ajax({
                        type: "POST",
                        url: "" + base_url + "findemployeelist/insertItemperpage",
                        data: postData,
                        dataType: 'json',
                        success: function (data) {
                             $(data).each(function (index, item) {
                                //console.log(data);
                                if (item.per_page == 1000) {
                                    window.location.href = "" + base_url + "recruitment_pub/findcandidates";
                               } else{

                                    //window.location.reload();
                                     window.location.reload(true);
                                }                                
                             });
                        }

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

            $(document).ready(function () {

                $(".add-to-pre-selection").click(function (e) {
                    var selected_id = $(this).attr("data-id");
                    var data_value = $(this).attr("data-value");
                    var base_url = '<?php echo base_url(); ?>';
                    var postData = {
                        "selected_id": selected_id,
                        "value_inserted": data_value
                    };
                    $.ajax({
                        type: "POST",
                        url: "" + base_url + "recruitment_pub/addPreselected",
                        data: postData,
                        dataType: 'json',
                        success: function (data) {

                            $(data).each(function (index, item) {
                                // console.log(item);
                                if (item.status=="pre-selected") {
                                    $("img[data-id=" + selected_id + "][title='Remove pre-selected']").css("display","block");
                                    $("img[data-id=" + selected_id + "][title='Add pre-selected']").css("display","none");
                                }else{
                                    $("img[data-id=" + selected_id + "][title='Remove pre-selected']").css("display","none");
                                    $("img[data-id=" + selected_id + "][title='Add pre-selected']").css("display","block");
                                }

                            });
                        }

                    });
                });


                // Setup - add a text input to each footer cell
                $('#example tfoot th').each(function () {
                    var title = $('#example thead th').eq($(this).index()).text();
                    $(this).html('<input type="text" placeholder="Search" />');
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
            #search_button {
              width: 100%;
              margin-top: 15px;
            }
            .operation-edit img {
                margin-right: 10px;
                display: table-cell;
            }
        </style>   
    </head>
    <body>
        <?php
        $searchpage="findcandidates";
        $per_page_query = $this->re_circular_model->getapplicantsearchQuery($searchpage);

        //include('includes/menu.php');
        //echo form_open_multipart('searchcontent/printmultiplepdf');
        ?>
        <form action="<?php echo base_url(); ?>recruitment_pub/findcandidates" method="post" accept-charset="utf-8" enctype="multipart/form-data"> 
            <div id="page-content-wrapper">
        <div class="container-fluid">
        <?php
            $this->load->view('includes/menu');
         ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default" style="margin-top: 15px;">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Search by Multiple Options</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- sfsaf -->
                                            
                                            <div class="row">
                                                <div class="col-md-6">Job Title:</div>
                                                <div class="col-md-6">
                                                    <?php

                                                    ?>
                                                    <select name="job_title_search_multiple">
                                                        <option value="">All</option>
                                                        <?php
                                                        foreach ($post as $single_post) {
                                                            if ($single_post) {
                                                                $post_data=$this->taxonomy->getTaxonomyBytid($single_post['record']);
                                                                echo '<option value="' . $single_post['record'] . '">' . $post_data['name'] . '</option>';
                                                            }
                                                        }
                                                        ?>                  
                                                    </select>                       
                                                </div>
                                            </div>  
                                            <div class="row">
                                                    <div class="col-md-6">Qualification</div>
                                                    <div class="col-md-6">
                                                        <select name="emp_qualification" id="emp_qualification">
                                                            <option value="">Select Qualification</option>
                                                            <?php foreach ($allqualification as $single_qualification) {
                                                                    echo '<option value="'.$single_qualification['tid'].'">'.$single_qualification['name'].'</option>';
                                                                
                                                            } ?>
                                                        </select>         
                                                    </div>
                                                </div> 
                                            <div class="row">
                                                <div class="col-md-6">Gender:</div>
                                                <div class="col-md-6">
                                                    <select name="gendersearch" id="gendersearch">
                                                        <option value="">All</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">Age:</div>
                                                <div class="col-md-6">From
                                                    <select name="age_from" id="age_from">
                                                        <option value="">All</option>
                                                        <?php
                                                        foreach ($age as $single_age) {
                                                            if ($single_age['record']) {
                                                                echo '<option value="' . $single_age['record'] . '">' . $single_age['record'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"></div>
                                                <div class="col-md-6">To
                                                    <select name="age_to" id="age_to">
                                                        <option value=""></option>
                                                        <?php
                                                        foreach ($age as $single_age) {
                                                            if ($single_age['record']) {
                                                                echo '<option value="' . $single_age['record'] . '">' . $single_age['record'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>  

                                            <div class="row">
                                                <div class="col-md-6">Mobile No:</div>
                                                <div class="col-md-6"><input type="text" name="mobile_no" id="mobile_no"></div>
                                            </div>                                                  
 
                                            <div class="row">
                                                <div class="col-md-6">Name:</div>
                                                <div class="col-md-6">
                                                    <input type="text" name="searchbyname" id="searchbyname">
                                                </div>
                                            </div>                                                     
                                                <div class="row">
                                                    <div class="col-md-6">Religion</div>
                                                    <div class="col-md-6">
                                                        <select name="emp_religion" id="emp_religion">
                                                            <option value="">Select Religion</option>
                                                            <?php foreach ($allreligion as $single_religion) {
  
                                                                    echo '<option value="'.$single_religion['tid'].'">'.$single_religion['name'].'</option>';
                                                                
                                                            } ?>
                                                        </select>         
                                                    </div>
                                                </div>
                                             
                                            <!-- sldks -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- sjdksjd -->
                                            <div class="row">
                                                <div class="col-md-6">Total Experience:</div>
                                                <div class="col-md-6">From
                                                    <select name="total_exp_frommltpl" id="total_exp_frommltpl">
                                                        <option value="">All</option>
                                                        <?php
                                                        foreach ($exptotla as $single_exp) {
                                                            if ($single_exp['record']) {
                                                                echo '<option value="' . $single_exp['record'] . '">' . $single_exp['record'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6"></div>
                                                <div class="col-md-6">To
                                                    <select name="total_exp_tomltpl" id="total_exp_tomltpl">
                                                        <option value=""></option>
                                                        <?php
                                                        foreach ($exptotla as $single_exp) {
                                                            if ($single_exp['record']) {
                                                                echo '<option value="' . $single_exp['record'] . '">' . $single_exp['record'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">Apply Date:</div>
                                                <div class="col-md-6">From<input type="text" name="apply_date_from1" id="apply_date_from1" class="datepicker" placeholder="dd-mm-yyyy"></div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-6"></div>
                                                <div class="col-md-6">To<input type="text" name="apply_date_to1" id="apply_date_to1" class="datepicker" placeholder="dd-mm-yyyy"></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">Marital Status:</div>
                                                <div class="col-md-6">
                                                     <select name="emp_marital_status" id="emp_marital_status">
                                                            <option value="">Select Status</option>
                                                            <?php foreach ($allmarital_status as $single_maritial_status) {
                                                                
                                                                    echo '<option value="'.$single_maritial_status['tid'].'">'.$single_maritial_status['name'].'</option>';
                                                                
                                                            } ?>
                                                        </select>    
                                                </div>
                                            </div> 
                                            <div class="row">
                                            <div class="col-md-6">Distict</div>
                                            <div class="col-md-6">
                                                <select name="emp_parmanent_distict" id="emp_parmanent_distict">
                                                    <option value="">Select Distict</option>
                                                    <?php foreach ($alldistict as $single_distict) {
                                                        
                                                            echo '<option value="'.$single_distict['tid'].'">'.$single_distict['name'].'</option>';
                                                        
                                                    } ?>
                                                </select>         
                                            </div>
                                        </div>   
                                            <div class="row">
                                            <div class="col-md-6">Status</div>
                                            <div class="col-md-6">
                                                <select name="status" id="status">
                                                    <option value="">Select Status</option>
                                                    <option value="pre-selected">Pre Selected</option>
                                                </select>         
                                            </div>
                                        </div>                                                               
                                            <!-- kdjsfkd -->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4"><input type="submit" name="multiple_search_btn" value="Search" id="search_button"></div>
                                        <div class="col-md-4"></div>
                                    </div>
                                </div>
                            </div>                                  
                        </div>
                    </div>
                    </form>
                     <form action="<?php echo base_url(); ?>recruitment_pub/submitmultipletask" method="post" class="myForm" id="myFormmultiple"  name="myFormmultiple" enctype="multipart/form-data">   
                    <!-- ksdflkd -->            
                <div class="all-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title-area">
                                <h1 class="title text-center" id="page-title">The Job Seekers CVs </h1>
                                <span  class="total-query" style="  float: right;  margin-top: -19px; font-size: 20px;">Total:<?php print $total_search; ?></span>
                            </div> 

                        </div>
                    </div>                
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <nav>
                            <?php print $this->pagination->create_links(); ?>
                            </nav>
                        </div>
                    </div>                    


                    <div class="row">
                                <div class="col-md-2" style="width: 123px;font-size: 20px;line-height: 40px;"><?php if ($user_type == 1) { ?> Task Type<?php } ?></div>
                                <div class="col-md-3" style="padding-left: 0;">
                                <?php if ($user_type == 1) { ?>  
                                    <select name="multiple_task" id="multiple_task" style="padding: 10px;font-size: 15px;">
                                        <option value="">Select</option>
                                        <option value="Download All Candidates List" <?php if ($per_page_query['per_page'] == 'Download All Candidates List') { echo "selected='selected'";  } ?>>Download All Candidates List</option>
                                        <option value="Download Selected Candidates List" <?php if ($per_page_query['per_page'] == 'Download Selected Candidates List') { echo "selected='selected'";  } ?>>Download Selected Candidates List</option>
                                        <option value="Delete Selected List" <?php if ($per_page_query['per_page'] == 'Delete Selected List') { echo "selected='selected'";  } ?>>Delete Selected List</option>
                                        <option value="Delete Filtered List" <?php if ($per_page_query['per_page'] == 'Delete Filtered List') { echo "selected='selected'";  } ?>>Delete Filtered List</option>
                                    </select>
                                    <div class="total_leave_text" style="display:none">
                                        Effective Date:<input type="text" name="emp_job_change_date" id="emp_job_change_date"  class="datepicker numbersOnly" placeholder="dd-mm-yyyy"/>  <br>        
                                        Total Leave:<input type="text" name="annual_leave_total" id="annual_leave_total"  onkeypress="return isNumber(event);" />        
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-1" style="padding-left: 0px;"><?php if ($user_type == 1) { ?><input type="submit" value="Submit"><?php } ?></div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3" style="width:260px;padding-right:0px;  padding-top: 5px;  text-align: right;">Applicant per page</div>
                                <div class="col-md-1" style="padding-left: 0px; padding-right: 0px; margin-left: 13px;">

                                    <select name="applicant_per_page" id="applicant_per_page">
                                        <option value="">Select</option>
                                        <option value="8" <?php if ($per_page_query['per_page'] == '8') { echo "selected='selected'";  } ?>>8</option>
                                        <option value="12" <?php if ($per_page_query['per_page'] == '12') { echo "selected='selected'";  } ?>>12</option>
                                        <option value="24" <?php if ($per_page_query['per_page'] == '24') { echo "selected='selected'"; } ?>>24</option>
                                        <option value="48" <?php if ($per_page_query['per_page'] == '48') { echo "selected='selected'"; } ?>>48</option>
                                        <option value="96" <?php if ($per_page_query['per_page'] == '96') { echo "selected='selected'"; } ?>>96</option>
                                        <option value="1000" <?php if ($per_page_query['per_page'] > 96) { echo "selected='selected'"; } ?>>All</option>
                                    </select>
                                </div>
                            </div>
                    <table id="example" class="display" cellspacing="0" width="100%" border="1">
                        <thead>
                            <tr class="heading">
                                <th style="padding-left: 10px;text-align: left;width:10px!important"><input type='checkbox' class="check_all" id="check_all" value='all' /></th>
                                <th>Position</th>
                                <th>Name</th>
                                <th>Qualification</th>
                                <th style="padding-left: 10px;width:10px!important">Age</th>
                                <th>Gender</th>
                                <th style="padding-left: 10px;width:10px!important">Total Exp.</th>
                                <th style="padding-left: 10px;width:10px!important">Mobile No</th>
                                <th style="padding-left: 10px;width:10px!important">Religion</th>
                                <th>Marital Status</th>            
                                <th>Distict</th>
                                <th>Apply date</th>            
                                <th style="width:10px!important;">Action</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th style="width:10px!important;"></th>
                                <th>Position</th>
                                <th>Name</th>
                                <th>Qualification</th>
                                <th style="padding-left: 10px;width:10px!important">Age</th>
                                <th>Gender</th>
                                <th style="padding-left: 10px;width:10px!important">Total Exp.</th>
                                <th style="padding-left: 10px;width:10px!important">Mobile No</th>
                                <th style="padding-left: 10px;width:10px!important">Religion</th>
                                <th>Marital Status</th>            
                                <th>Distict</th>
                                <th>Apply date</th>             
                                <th style="width:10px!important;"></th>
                            </tr>
                        </tfoot>

                        <tbody>
                            <?php
                            
                            foreach ($records as $sigle_content) {
                                $id=$sigle_content['id'];
                                $content_id=$sigle_content['content_id'];
                                $emp_name=$sigle_content['emp_name'];
                                $emp_post_id=$sigle_content['emp_post_id'];
                                $post_data=$this->taxonomy->getTaxonomyBytid($emp_post_id);
                                $gender=$sigle_content['gender'];
                                $dob=$sigle_content['dob'];
                                $marital_status=$sigle_content['marital_status'];
                                $marital_status_data=$this->taxonomy->getTaxonomyBytid($marital_status);
                                $religion=$sigle_content['religion'];
                                $religion_data=$this->taxonomy->getTaxonomyBytid($religion);
                                $age=$sigle_content['age'];
                                $distict=$sigle_content['distict'];
                                $distict_data=$this->taxonomy->getTaxonomyBytid($distict);
                                $mobile_no=$sigle_content['mobile_no'];
                                $national_id=$sigle_content['national_id'];
                                $qualification=$sigle_content['qualification'];
                                $qualification_data=$this->taxonomy->getTaxonomyBytid($qualification);
                                $total_exp=$sigle_content['total_exp'];
                                $apply_date=$sigle_content['apply_date'];
                                $interview_date=$sigle_content['interview_date'];            
                                $interview_time=$sigle_content['interview_time'];            
                                $circular_id=$sigle_content['circular_id'];     
                                $status=$sigle_content['status'];  

                                ?> 
                                <tr>
                                    <td style="width:10px!important"><input type='checkbox' name='content_id[]' value='<?php print $content_id; ?>' /></td>
                                    <td><?php print $post_data['name']; ?></td>
                                    <td><?php print $emp_name; ?></td>
                                    <td><?php print $qualification_data['name']; ?></td>            
                                    <td style="width:10px!important"><?php if($age){ print $age; } ?></td>            
                                    <td><?php print $gender; ?></td>
                                    <td style="width:10px!important"><?php print $total_exp; ?></td>
                                    <td style="width:10px!important"><?php print $mobile_no; ?></td>
                                    <td style="width:10px!important"><?php print $religion_data['name']; ?></td>
                                    <td><?php print $marital_status_data['name']; ?></td>                                                            
                                    <td><?php print $distict_data['name']; ?></td>
                                    <td style="width:10px!important"><?php print $apply_date; ?></td>
                                    
                                        <td>
                                        <a href="<?php echo site_url("recruitment/candidateresume") . '/' . $content_id; ?>" target="_blank" class="operation-edit operation-link ev-edit-link" style="display: table-cell;"><img src="<?php echo base_url(); ?>resources/images/view.png" alt="pdf" title="View Resume" style="width:20px;"/></a>
                                        
                                        <a  class="operation-edit operation-link ev-edit-link" style="display: table-cell;"><img src="<?php echo base_url(); ?>resources/images/check.png"  title="Remove pre-selected" alt="pdf" class="add-to-pre-selection" data-id="<?php print $content_id; ?>" data-value="" style="cursor: pointer; width:15px; <?php if($status=="pre-selected"){ ?> display: block; <?php }else{ ?> display: none;<?php } ?> "/></a>
                                        
                                        <a  class="operation-edit operation-link ev-edit-link" style="display: table-cell;"><img src="<?php echo base_url(); ?>resources/images/add-icon.png" title="Add pre-selected" alt="pdf" data-id="<?php print $content_id; ?>" data-value="pre-selected" class="add-to-pre-selection" style="cursor: pointer;width:15px; <?php if($status=="pre-selected"){ ?> display: none; <?php }else{ ?> display: block;<?php } ?> "/></a>
                                        
                                        <a href="<?php echo site_url("recruitment/exportcandidate") . '/' . $content_id; ?>" target="_blank" class="operation-edit operation-link ev-edit-link" style="display: table-cell;"><img src="<?php echo base_url(); ?>resources/images/export.png" title="Export to HR Database" alt="pdf" style="width:20px;"/></a>
                                            <a href="<?php echo site_url("recruitment/candidateresumepdf") . '/' . $content_id; ?>" target="_blank" class="operation-edit operation-link ev-edit-link" style="display: table-cell;"><img src="<?php echo base_url(); ?>resources/images/pdf_icon_print.png" alt="pdf" title="Print resume as PDF" style="width:20px;"/></a>

                                                <a href="<?php echo site_url("deletecontent/deleteCandidate") . '/' . $content_id; ?>" class="operation-delete operation-link" onClick="return ConfirmDelete()" style="display: table-cell;"><img src="<?php echo base_url(); ?>resources/images/cut.jpg" title="Delete from Database" alt="edit" /></a>  
                                                      
                                        </td>
                                    

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <nav>
                            <?php print $this->pagination->create_links(); ?>
                            </nav>
                        </div>
                    </div>                    
                </div>  
            </div>
            </div>
        </form>
    </body>
</html>