<html>
    <head> 
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Employee List</title> 
        <?php 
        $user_id = $this->session->userdata('user_id');
        $user_type = $this->session->userdata('user_type');
        $view_salary_in_emp_list= $this->users_model->userpermission("view_salary_in_emp_list", $user_type);
        $add_edit_profile= $this->users_model->userpermission("add_edit_profile", $user_type);
        $this->load->view('includes/cssjs');
        ?>
        <script>
            $(document).ready(function () {
                 $('#myFormmultiple').on('submit',function(e) {
                    var task_val=$('#multiple_task').val();
                      if(task_val == "Download All Employee List" || task_val == "Download Selected Employee List"){
                          $(this).attr('target', '_blank');
                      }
                      $( "#myFormmultiple" ).submit();
                });
                $('#example').dataTable({
                    "lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"]],
                    //paging: false,
                     paging: true, //change by sajeeb
                    "autoWidth": false,
                    //"searching": false,
                    "info": false,
                    "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,10 ] }  ]
                });

/*
                jQuery("#applicant_per_page").change(function (e) {
                    var applicant_per_page = $(this).val();
                    var search_page = "find_employee_by_att_status";
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
                                    window.location.href = "" + base_url + "findemployeeattstatus/find_employee_by_att_status";
                               } else{

                                    //window.location.reload();
                                     window.location.reload(true);
                                }                                
                             });
                        }

                    });
                }); 
                */
$( "#emp_division" ).change(function(e) {
    var division_tid = $(this).val(); 
    var base_url='<?php echo base_url();?>';
    var postData = {
        "division_tid" : division_tid
    };
    $.ajax({
        type: "POST",
        url: ""+base_url+"addprofile/getdepartmentidbydivisionid",
        data: postData,
        dataType:'json',
        success: function(data){
    // console.log(data);
    var options="";
    options += '<option value="">Select Department</option>';
    $(data).each(function(index, item) {
        options += '<option value="' + item.tid + '">' + item.name + '</option>'; 
    });
    $('#emp_department').html(options);    
}
});
});

$("#multiple_task").change(function(e){
    var multiple_task_val = $(this).val(); 
    var base_url='<?php echo base_url();?>';
    if(multiple_task_val=="Update Total Leave For All" || multiple_task_val=="Update Total Leave For Selected"){
        $(".total_leave_text").show();
    }else{
        $(".total_leave_text").hide();
    }
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
        </style>   
    </head>
    <body>
<!-- Page Content -->  
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php 
            $this -> load -> view('includes/menu');
        $searchpage="find_employee_by_att_status";
        $per_page_query = $this->search_field_emp_model->getsearchQuery($searchpage);            
            ?> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url(); ?>findemployeeattstatus/find_employee_by_att_status#list" method="post" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data" >
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
                                                <div class="col-md-4">Division Name:</div>
                                                <div class="col-md-8">
                                                  <select name="emp_division" id="emp_division">
                                                    
                                                    <?php 
                                                 if($user_type_id !=1){
                                                                // echo '<option value="'.$alldivision['tid'].'" selected="selected" data-id="'.$alldivision['weight'].'">'.$alldivision['name'].'</option>';
                                                             }else{
                                                                echo '<option value="">Select Division</option>';
                                                    foreach ($alldivision as $single_division) {
                                                      if($emp_division==$single_division['tid']){
                                                        echo '<option value="'.$single_division['tid'].'" selected="selected">'.$single_division['name'].'</option>';
                                                      }else{
                                                        echo '<option value="'.$single_division['tid'].'">'.$single_division['name'].'</option>';
                                                      }
                                                    } }
                                                    ?>
                                                  </select>                     
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">Department Name:</div>
                                                <div class="col-md-8">
                                                  <select name="emp_department" id="emp_department">
                                                    <option value="">Select Department</option>
                                                    <?php 

                                                    foreach ($department_selected as $single_department) {
                                                      if($emp_department==$single_department['tid']){
                                                        echo '<option value="'.$single_department['tid'].'" selected="selected">'.$single_department['name'].'</option>';
                                                    }else{
                                                        echo '<option value="'.$single_department['tid'].'">'.$single_department['name'].'</option>';
                                                      }
                                                    } 
                                                    ?>
                                                  </select>                       
                                                </div>
                                            </div>                                                                                       
                                            <div class="row">
                                                <div class="col-md-4">Job Title:</div>
                                                <div class="col-md-8">
                                                      <select name="emp_position" id="emp_position">
                                                        <option value="">Select Position</option>
                                                        <?php foreach ($alljobtitle as $single_jobtitle) {
                                                          if($emp_position==$single_jobtitle['tid']){
                                                            echo '<option value="'.$single_jobtitle['tid'].'" selected="selected">'.$single_jobtitle['name'].'</option>';
                                                          }else{
                                                            echo '<option value="'.$single_jobtitle['tid'].'">'.$single_jobtitle['name'].'</option>';
                                                          }
                                                        } ?>
                                                      </select>                        
                                                </div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-4">Type of Employee:</div>
                                                <div class="col-md-8">
                                                  <select name="emp_type" id="emp_type">
                                                    <option value="">Select Type</option>
                                                    <?php foreach ($alltypeofemployee as $single_emp_type) {
                                                      if($emp_type==$single_emp_type['tid']){
                                                        echo '<option value="'.$single_emp_type['tid'].'" selected="selected">'.$single_emp_type['name'].'</option>';
                                                      }else{
                                                        echo '<option value="'.$single_emp_type['tid'].'">'.$single_emp_type['name'].'</option>';
                                                      }
                                                    } ?>
                                                  </select>                       
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">Joining Date:</div>
                                                <div class="col-md-8">From<input type="text" class="datepicker numbersOnly" name="joining_date_from1" id="joining_date_from1" placeholder="dd-mm-yyyy"></div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-8">To<input type="text" class="datepicker numbersOnly" name="joining_date_to1" id="joining_date_to1" placeholder="dd-mm-yyyy"></div>
                                            </div>                                             
                                            <div class="row">
                                                <div class="col-md-4">Pay Type:</div>
                                                <div class="col-md-8">
                                                  <select name="emp_pay_type" id="emp_pay_type">
                                                    <option value="">Select Pay Type</option>
                                                    <?php foreach ($allpaytype as $single_paytype) {
                                                      if($emp_pay_type==$single_paytype['tid']){
                                                        echo '<option value="'.$single_paytype['tid'].'" selected="selected">'.$single_paytype['name'].'</option>';
                                                      }else{
                                                        echo '<option value="'.$single_paytype['tid'].'">'.$single_paytype['name'].'</option>';
                                                      }
                                                    } ?>
                                                  </select>                       
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">Sort By:</div>
                                                <div class="col-md-8">
                                                  <select name="sort_by" id="sort_by">
                                                    <option value="grade">Employee Grade</option>
                                                    <option value="emp_id">Employee Code</option>
                                                    <option value="emp_name">Employee Name</option>
                                                    <option value="emp_division">Division</option>
                                                    <option value="gender">Gender</option>
                                                    <option value="marital_status">Marital Status</option>
                                                    <option value="religion">Religion</option>
                                                    <option value="joining_date">Joining Date</option>
                                                    <option value="type_of_employee">Type_of Employee</option>
                                                    <option value="distict">Distict</option>
                                                  </select>                       
                                                </div>
                                            </div>                                             
                                            <div class="row">
                                                <div class="col-md-4">Visa Selling:</div>
                                                <div class="col-md-8"><input type="checkbox" name="emp_visa_selling" id="emp_visa_selling"/>    </div>
                                            </div>                                                                                                                                                        
                                            <!-- sldks -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- sjdksjd --> 
                                            <div class="row">
                                                    <div class="col-md-4">Attendance Required</div>
                                                    <div class="col-md-8">
                                                        <select name="attendance_required" id="attendance_required">
                                                            <option value="Required" <?php if($attendance_required=='Required'){print 'selected="selected"';} ?>>Required</option>
                                                            <option value="Not_Required" <?php if($attendance_required=='Not_Required'){print 'selected="selected"';} ?>>Not Required</option>
                                                            <option value="Optional" <?php if($attendance_required=='Optional'){print 'selected="selected"';} ?>>Optional</option>
                                                        </select>                                                           
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">Logout Required</div>
                                                    <div class="col-md-8">
                                                        <select name="logout_required" id="logout_required">
                                                            <option value="Required" <?php if($logout_required=='Required'){print 'selected="selected"';} ?>>Required</option>
                                                            <option value="Not_Required" <?php if($logout_required=='Not_Required'){print 'selected="selected"';} ?>>Not Required</option>
                                                            <option value="Optional" <?php if($logout_required=='Optional'){print 'selected="selected"';} ?>>Optional</option>
                                                        </select>                                                           
                                                    </div>
                                                </div>      
                                                <div class="row">
                                                    <div class="col-md-4">Half Day Absent</div>
                                                    <div class="col-md-8">
                                                        <select name="half_day_absent" id="half_day_absent">
                                                            <option value="Not_Eligible" <?php if($half_day_absent=='Not_Eligible'){print 'selected="selected"';} ?>>Not Eligible</option>                                                      
                                                            <option value="Eligible" <?php if($half_day_absent=='Eligible'){print 'selected="selected"';} ?>>Eligible</option>
                                                        </select>                                                           
                                                    </div>
                                                </div>                                               <div class="row">
                                                    <div class="col-md-4">Overtime Count</div>
                                                    <div class="col-md-8">
                                                        <select name="overtime_count" id="overtime_count">
                                                            <option value="Not_Eligible" <?php if($overtime_count=='Not_Eligible'){print 'selected="selected"';} ?>>Not Eligible</option>                                                       
                                                            <option value="Eligible" <?php if($overtime_count=='Eligible'){print 'selected="selected"';} ?>>Eligible</option>
                                                        </select>         
                                                    </div>
                                                </div>  
                                                <div class="row">
                                                    <div class="col-md-4">Weekly Holiday</div>
                                                    <div class="col-md-8">
                                                        <!-- <input type="text" name="emp_weekly_holiday" id="emp_weekly_holiday"  value="<?php if($emp_weekly_holiday){ echo $emp_weekly_holiday;} ?>"/>  -->
                                                        <select name="emp_weekly_holiday" id="emp_weekly_holiday">
                                                        <option value="">Select Holiday</option>
                                                            <option value="fri" <?php if($emp_holiday['fri_off']=='off'){print 'selected="selected"';} ?>>Friday</option>
                                                            <option value="sat" <?php if($emp_holiday['sat_off']=='off'){print 'selected="selected"';} ?>>Saturday</option>
                                                            <option value="sun" <?php if($emp_holiday['sun_off']=='off'){print 'selected="selected"';} ?>>Sunday</option>
                                                            <option value="mon" <?php if($emp_holiday['mon_off']=='off'){print 'selected="selected"';} ?>>Monday</option>
                                                            <option value="tue" <?php if($emp_holiday['tue_off']=='off'){print 'selected="selected"';} ?>>Tuesday</option>
                                                            <option value="wed" <?php if($emp_holiday['wed_off']=='off'){print 'selected="selected"';} ?>>Wednesday</option>
                                                            <option value="thus"<?php if($emp_holiday['thus_off']=='off'){print 'selected="selected"';} ?>>Thusday</option>
                                                        </select>       
                                                    </div>
                                                </div>                                                                                       
                                            <div class="row">
                                                <div class="col-md-4">Gender:</div>
                                                <div class="col-md-8">
                                                  <select name="emp_gender" id="emp_gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Others">Others</option>
                                                  </select>   
                                                </div>
                                            </div>
                                                                                                                                                                                                             
                                         
                                            <div class="row">
                                                <div class="col-md-4">Mobile No:</div>
                                                <div class="col-md-8"><input type="text" class="phonenumbersOnly" name="mobile_no" id="mobile_no"></div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-4">Name:</div>
                                                <div class="col-md-8">
                                                    <input type="text" name="searchbyname" id="searchbyname">
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

                    <div class="row" id="list">
                        <div class="col-md-12">
                            <div class="title-area">
                                <h1 class="title text-center" id="page-title">The Employees List </h1>
                                <span  class="total-query" style="  float: right;  margin-top: -19px; font-size: 20px;">Total:<?php print $total_search; ?></span>
                            </div> 

                        </div>
                    </div>   
                    <!--             
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <nav>
                            <?php print $this->pagination->create_links(); ?>
                            </nav>
                        </div>
                    </div> 
                    -->  
                    <form action="<?php echo base_url(); ?>findemployeeattstatus/submitmultipletask" method="post" class="myForm" id="myFormmultiple"  name="myFormmultiple" enctype="multipart/form-data">                
                                                               
                            <div class="row">
                                <div class="col-md-2" style="width: 123px;font-size: 20px;line-height: 40px;"><?php if ($user_type == 1) { ?> Task Type<?php } ?></div>
                                <div class="col-md-3" style="padding-left: 0;">
                                <?php if ($user_type == 1) { ?>  
                                    <select name="multiple_task" id="multiple_task" style="padding: 10px;font-size: 15px;">
                                        <option value="">Select</option>
                                        <option value="Update Total Leave For All" <?php if ($per_page_query['per_page'] == 'Update Total Leave For All') { echo "selected='selected'";  } ?>>Update Total Leave  For All</option>
                                        <option value="Update Total Leave For Selected" <?php if ($per_page_query['per_page'] == 'Update Total Leave For Selected') { echo "selected='selected'";  } ?>>Update Total Leave  For Selected</option>
                                        <option value="Download All Employee List" <?php if ($per_page_query['per_page'] == 'Download All Employee List') { echo "selected='selected'";  } ?>>Download All Employee List</option>
                                        <option value="Download Selected Employee List" <?php if ($per_page_query['per_page'] == 'Download Selected Employee List') { echo "selected='selected'";  } ?>>Download Selected Employee List</option>
                                    </select>
                                    <div class="total_leave_text" style="display:none">
                                        Effective Date:<input type="text" name="emp_job_change_date" id="emp_job_change_date"  class="datepicker numbersOnly" placeholder="dd-mm-yyyy"/>  <br>        
                                        Total Leave:<input type="text" name="annual_leave_total" id="annual_leave_total"  onkeypress="return isNumber(event);" />        
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-1" style="padding-left: 0px;"><?php if ($user_type == 1) { ?><input type="submit" value="Submit"><?php } ?></div>
                                <div class="col-md-3"></div>
                                <!--
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
                                -->
                            </div>     
                                    
                        <table id="example" class="display" cellspacing="0" width="100%" border="1">
                            <thead>
                                <tr class="heading">
                                    <th style="padding-left: 10px;text-align: left;width:10px!important"><input type='checkbox' class="check_all" id="check_all" value='all' /></th>                                
                                    <th>Sl</th>
                                    <th>Emp. Code</th>
                                    <th>Name</th>
                                    <th>Grade</th>
                                    <th>Division Name</th>
                                    <th>Department Name</th>
                                    <th>Position</th>
                                    <th>Type of Employee</th>
                                    <th>Joining Date</th>
                                    <th>In Status</th>
                                    <th>Out Status</th>
                                    <th>Half Day Absent Status</th>
                                    <th>Overtime Status</th>
                                    <?php if ($user_type == 1 || $add_edit_profile[0]['status'] == 1) { ?> 
                                    <th>Edit</th>
                                    <?php } ?>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th style="width:10px!important;"></th>
                                    <th></th>
                                    <th>Emp. Code</th>                                    
                                    <th>Name</th>
                                    <th>Grade</th>
                                    <th>Division Name</th>
                                    <th>Department Name</th>
                                    <th>Position</th>
                                    <th>Type of Employee</th>
                                    <th>Joining Date</th>
                                    <th>In Status</th>
                                    <th>Out Status</th>
                                    <th>Half Day Absent Status</th>
                                    <th>Overtime Status</th>
                                    <?php if ($user_type == 1 || $add_edit_profile[0]['status'] == 1) { ?> 
                                    <th>Edit</th>
                                    <?php } ?>
                                </tr>
                            </tfoot>

                            <tbody>
                                <?php
                                foreach ($records as $sigle_content) {
                                    $content_id = $sigle_content['content_id'];
                                    $emp_working_time=$this->emp_working_time_model->getcontentByid($content_id);
                                    $emp_code = $sigle_content['emp_id'];
                                    $emp_name = $sigle_content['emp_name'];
                                    $emp_grade = $sigle_content['grade'];
                                    $emp_grade_data=$this->taxonomy->getTaxonomyBytid($emp_grade);
                                    $emp_division = $sigle_content['emp_division'];
                                    $emp_division_data=$this->taxonomy->getTaxonomyBytid($emp_division);
                                    $emp_department = $sigle_content['emp_department'];
                                    $emp_department_data=$this->taxonomy->getTaxonomyBytid($emp_department);
                                    $emp_post_id = $sigle_content['emp_post_id']; 
                                    $emp_post_id_data=$this->taxonomy->getTaxonomyBytid($emp_post_id);
                                    $type_of_employee = $sigle_content['type_of_employee'];
                                    $type_of_employee_data=$this->taxonomy->getTaxonomyBytid($type_of_employee);
                                    $joining_date = $sigle_content['joining_date'];
                                    $gender = $sigle_content['gender'];
                                    $in_status=$emp_working_time['attendance_required'];
                                    $out_status=$emp_working_time['logout_required'];
                                    $half_day_absent_status=$emp_working_time['half_day_absent'];
                                    $overtime_status=$emp_working_time['overtime_count'];
                                    ?>
                                    <tr>
                                        <td style="width:10px!important"><input type='checkbox' name='content_id[]' value='<?php print $content_id; ?>' /></td>                                    
                                        <td><?php echo $sl;?></td>
                                        <td><?php print $emp_code; ?></td>
                                        <td><?php print $emp_name; ?></td>
                                        <td><?php print $emp_grade_data['name']; ?></td>
                                        <td><?php print $emp_division_data['keywords']; ?></td>
                                        <td><?php print $emp_department_data['name']; ?></td>
                                        <td><?php print $emp_post_id_data['name']; ?></td>
                                        <td><?php print $type_of_employee_data['name']; ?></td>
                                        <td><?php print $joining_date; ?></td>
                                        <td><?php print str_replace("_", " ", $in_status); ?></td>
                                        <td><?php print str_replace("_", " ", $out_status); ?></td>
                                        <td><?php print str_replace("_", " ", $half_day_absent_status); ?></td>
                                        <td><?php print str_replace("_", " ", $overtime_status); ?></td>
                                        <?php if ($user_type == 1 || $add_edit_profile[0]['status'] == 1) { ?> 
                                        <td>
                                            <a href="<?php echo site_url("addprofile/addemployee") . '/' . $content_id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit Details" /></a>
                                           <?php if($user_type_id ==1 && $user_id ==6){ ?> 
                                            <a href="<?php echo site_url("addprofile/deleteemployee") . '/' . $content_id; ?>" class="operation-cut operation-link" onClick="return ConfirmDelete()"> <img src="<?php echo base_url(); ?>resources/images/cut.jpg" alt="edit" /></a>
                                            <?php } ?>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                    <?php $sl++; } ?>
                                </tbody>
                            </table>  
                            </form>
                            <!--
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <nav>
                                    <?php print $this->pagination->create_links(); ?>
                                    </nav>
                                </div>
                            </div> 
                            -->                                                  
                        </div>
                    </div>              
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->           
    </body>
</html>