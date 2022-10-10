<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Employee List</title>
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
                    "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,9 ] }  ]
                });


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
                                if (item.per_page == 1000) {
                                    window.location.href = "" + base_url + "findemployeelist/contentwithpagination";
                               } else {
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
            .title-area {
                margin-top: 20px;
                }
        </style>   
    </head>
    <body>
<!-- Page Content -->  
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php 
            $this -> load -> view('includes/menu');
        // $searchpage="contentwithpagination";
        // $per_page_query = $this->search_field_emp_model->getsearchQuery($searchpage);            
            ?> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="title-area">
                                <h1 class="title text-center" id="page-title">The Employees List </h1>
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
                        <div class="col-md-9"></div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-8" style="padding-right:0px;  padding-top: 5px;  text-align: right;">Applicant per page</div>
                                <div class="col-md-3" style="padding-left: 0px; padding-right: 0px; margin-left: 13px;">

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
                        </div>
                    </div>                         
                        <table id="example" class="display" cellspacing="0" width="100%" border="1">
                            <thead>
                                <tr class="heading">
                                    <th style="padding-left: 10px;text-align: left;width:10px!important"><input type='checkbox' class="check_all" id="check_all" value='all' /></th>                                
                                    <th>Emp. Code</th>
                                    <th>Name</th>
                                    <th>Driving License</th>
                                    <th>License Expires Date</th>
                                    <th>Office Phone</th>
                                    <th>Mobile</th>
                                    <th>Emergency Contact</th>
                                    <th>Joining Date</th>
                                     <th>Status</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th style="width:10px!important;"></th>
                                    <th>Emp. Code</th>
                                    <th>Name</th>
                                    <th>Driving License</th>
                                    <th>License Expires Date</th>
                                    <th>Office Phone</th>
                                    <th>Mobile</th>
                                    <th>Emergency Contact</th>
                                    <th>Joining Date</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                </tr>
                            </tfoot>
 
                            <tbody>
                                <?php
                                    foreach ($records as $single_car) {
                                            if($single_car['record']){
                                                $driver_data=$this->search_field_emp_model->getallsearch_table_contentByid($single_car['record']);
                                                $emp_code=$driver_data['emp_id'];
                                                $emp_name=$driver_data['emp_name'];
                                                $mobile_no = $driver_data['mobile_no'];
                                                $distict = $driver_data['distict'];
                                                $joining_date = $driver_data['joining_date']; ?>
                                        <tr>
                                        <td style="width:10px!important"><input type='checkbox' name='content_id[]' value='<?php print $content_id; ?>' /></td>                                    
                                        <td><?php print $emp_code; ?></td>
                                        <td><?php print $emp_name; ?></td>
                                        <td><?php print $emp_driving_license; ?></td>
                                        <td><?php print $License_Expires_Date; ?></td>
                                        <td><?php print $emp_office_phone; ?></td>
                                        <td><?php print $mobile_no; ?></td>
                                        <td><?php print $emp_emergency_contact; ?></td>
                                        <td><?php print $joining_date; ?></td>
                                        <td><?php print $driver_status; ?></td>
                                        <td>
                                            <a href="<?php echo site_url("addtransportemployee/addemployee") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit Details" /></a>
                                            <!-- <a href="<?php echo site_url("addprofile/deleteemployee") . '/' . $content_id; ?>" class="operation-cut operation-link" onClick="return ConfirmDelete()"> <img src="<?php echo base_url(); ?>resources/images/cut.jpg" alt="edit" /></a> -->
                                        </td>
                                    </tr>
                                    <?php                                                
                                            }                                                           
                                    } 
                                // foreach ($records as $sigle_content) {
                                //     $id = $sigle_content['id'];
                                //     $content_id = $sigle_content['content_id'];
                                //      if($content_id){
                                //         $emp_info=$this->search_field_emp_model->getallsearch_table_contentByid($content_id);
                                //         $emp_code=$emp_info['emp_id'];
                                //         $emp_name=$emp_info['emp_name'];
                                //     }                                    
                                //     $emp_office_phone = $sigle_content['emp_office_phone'];
                                //     $emp_phone = $sigle_content['emp_phone'];
                                //     $emp_emergency_contact = $sigle_content['emp_emergency_contact'];
                                //     $emp_driving_license = $sigle_content['emp_driving_license'];
                                //     $License_Expires_Date = $sigle_content['License_Expires_Date'];
                                //     $driver_status = $sigle_content['driver_status'];
                                    ?>
                                   <!--  <tr>
                                        <td style="width:10px!important"><input type='checkbox' name='content_id[]' value='<?php print $content_id; ?>' /></td>                                    
                                        <td><?php print $emp_code; ?></td>
                                        <td><?php print $emp_name; ?></td>
                                        <td><?php print $emp_driving_license; ?></td>
                                        <td><?php print $License_Expires_Date; ?></td>
                                        <td><?php print $emp_office_phone; ?></td>
                                        <td><?php print $emp_phone; ?></td>
                                        <td><?php print $emp_emergency_contact; ?></td>
                                        <td><?php print $driver_status; ?></td>
                                        <td>
                                            <a href="<?php echo site_url("addtransportemployee/addemployee") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit Details" /></a>
                                             <a href="<?php echo site_url("addprofile/deleteemployee") . '/' . $content_id; ?>" class="operation-cut operation-link" onClick="return ConfirmDelete()"> <img src="<?php echo base_url(); ?>resources/images/cut.jpg" alt="edit" /></a> -->
                                        <!-- </td> -->
                                    <!--</tr> -->
                                    <?php // } 
                                    ?>
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
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->           
    </body>
</html>