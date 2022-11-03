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
                    
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    
                    //paging: false,
                    paging: true, //changed by sajeeb
                    "autoWidth": false,
                    //"searching": false,
                    "info": false,
                    "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,10 ] }  ]
                });

/*
                jQuery("#applicant_per_page").change(function (e) {
                    var applicant_per_page = $(this).val();
                    var search_page = "contentwithpagination";
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
                                    window.location.href = "" + base_url + "findemployeelist/contentwithpagination";
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
              


            $("#search_button").click(function() {
    $('html, body').animate({
        scrollTop: $("#list").offset().top
    }, 2000);
});







            });
            
            

        </script> 
        
        <style>
            .container-fluid {
                width: 100%;
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
        $searchpage="contentwithpagination";
        $per_page_query = $this->search_field_emp_model->getsearchQuery($searchpage);            
            ?> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
  

                    <div class="row" id="list">
                        <div class="col-md-12">
                            <div class="title-area">
                                <h1 class="title text-center" id="page-title">Deactive Employees List </h1>
                               
                            </div> 

                        </div>
                    </div>                
                 
                                    
                        <table id="example" class="display "  width="100%" border="0">
                            <thead>
                                <tr class="heading">
                                   <th>Sl</th>
                                    <th>Emp. Code</th>
                                    <th>Name</th>
                                    <th>Grade</th>
                                    <th>Division Name</th>
                                    <th>Department Name</th>
                                    <th>Position</th>
                                    <th>Type of Employee</th>
                                    <th>Joining Date</th>
                                    <?php if ($user_type == 1 || $view_salary_in_emp_list[0]['status'] == 1) { ?>                                     
                                    <th>Salary</th>
                                    <?php } ?>
                                    <th>Gender</th>
                                    <th>Mobile No</th>
                                    <th>Distict</th>
                                    <?php if ($user_type == 1 || $add_edit_profile[0]['status'] == 1) { ?> 
                                    <th>Action</th>
                                    <?php } ?>
                                </tr>
                            </thead>

                            
                            <tbody>
                                <?php
                                $sl=1;
                                foreach ($records as $sigle_content) {
                                    $content_id = $sigle_content['content_id'];
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
                                    $mobile_no = $sigle_content['mobile_no'];
                                    $distict = $sigle_content['distict'];
                                    $distict_data=$this->taxonomy->getTaxonomyBytid($distict);
                                    $salary_amount= $this->emp_salary_model->getsalary($content_id);
                                    $emp_gross_salary=$salary_amount['gross_salary'];
                                    ?>
                                    <tr>
                                       <td><?php echo $sl; ?></td>
                                        <td><?php print $emp_code; ?></td>
                                        <td><?php print $emp_name; ?></td>
                                        <td><?php print $emp_grade_data['name']; ?></td>
                                        <td><?php print $emp_division_data['keywords']; ?></td>
                                        <td><?php print $emp_department_data['name']; ?></td>
                                        <td><?php print $emp_post_id_data['name']; ?></td>
                                        <td><?php print $type_of_employee_data['name']; ?></td>
                                        <td><?php print $joining_date; ?></td>
                                        <?php if ($user_type == 1 || $view_salary_in_emp_list[0]['status'] == 1) { ?> 
                                        <td><?php print $emp_gross_salary; ?></td>
                                        <?php } ?>
                                        <td><?php print $gender; ?></td>
                                        <td><?php print $mobile_no; ?></td>
                                        <td><?php print $distict_data['name']; ?></td>
                                        <?php if ($user_type == 1 || $add_edit_profile[0]['status'] == 1) { ?> 
                                        <td>
                                            <a href="<?php echo site_url("commoncontroller/publication_update/search_field_emp/publish"). '/' . $content_id; ?>#list" class="operation-edit operation-link ev-edit-link"><span class="glyphicon glyphicon-ok"  title="active"> </span></a>
                                           <?php if($user_type_id ==1 && $user_id ==6){ ?> 
                                            <a href="<?php echo site_url("addprofile/deleteemployee") . '/' . $content_id; ?>" class="operation-cut operation-link" onClick="return ConfirmDelete()"> <img src="<?php echo base_url(); ?>resources/images/cut.jpg" alt="edit" /></a>
                                            <?php } ?>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                    <?php $sl++;
                                    
                                           } ?>
                                </tbody>
                            </table>  
                          
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