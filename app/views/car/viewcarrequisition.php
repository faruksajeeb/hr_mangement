<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Car List</title>
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
                    "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,10 ] }  ]
                });


                jQuery("#applicant_per_page").change(function (e) {
                    var applicant_per_page = $(this).val();
                    var search_page = "cars";
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
                        url: "" + base_url + "findcarlist/insertItemperpage",
                        data: postData,
                        dataType: 'json',
                        success: function (data) {
                             $(data).each(function (index, item) {
                                if (item.per_page == 1000) {
                                    window.location.href = "" + base_url + "findcarlist/cars";
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
        </style>   
    </head>
    <body>
<!-- Page Content -->  
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php 
            $this -> load -> view('includes/menu');
            $searchpage="viewrequisition";
            $per_page_query = $this->search_field_emp_model->getsearchQuery($searchpage);            
            ?> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url(); ?>vahicles/viewrequisition" method="post" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
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
                                                <div class="col-md-4">Requester Name:</div>
                                                <div class="col-md-8">
                                                  <select name="Requester_Name" id="Requester_Name">
                                                    <option value="">Select Requester Name</option>
                                                    <?php foreach ($allrequester as $single_req_id) {
                                                        if($single_req_id['record']){
                                                            if($single_req_id['record']){
                                                                $requester_data=$this->search_field_emp_model->getallsearch_table_contentByid($single_req_id['record']);
                                                                $requester_name=$requester_data['emp_name'];
                                                                 echo '<option value="'.$single_req_id['record'].'">'.$requester_name.'</option>';
                                                            }                                                           
                                                       
                                                        }
                                                    } ?>
                                                  </select>                       
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">Requisition Location:</div>
                                                <div class="col-md-8">
                                                  <select name="Requisition_Location" id="Requisition_Location">
                                                    <option value="">Select Requisition Location</option>
                                                    <?php foreach ($allrequisition_location as $single_loca) {
                                                        if($single_loca['record']){
                                                            if($single_loca['record']){
                                                                 echo '<option value="'.$single_loca['record'].'">'.$single_loca['record'].'</option>';
                                                            }                                                           
                                                       
                                                        }
                                                    } ?>
                                                  </select>                       
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">Requisition Status:</div>
                                                <div class="col-md-8">
                                                <select name="Requisition_Status" id="Requisition_Status">
                                                    <option value="">Select Status</option>                                                    
                                                    <option value="2" <?php if($requisition_info['status']=="2"){ print 'selected="selected"'; } ?> >Pending</option>                                                    
                                                    <option value="1" <?php if($requisition_info['status']=="1"){ print 'selected="selected"'; } ?>>Approved</option>
                                                    <option value="3" <?php if($requisition_info['status']=="3"){ print 'selected="selected"'; } ?>>Cancel</option>
                                                </select>                      
                                                </div>
                                            </div>                                                                                                                                                                                                                                                                                                                                                                                                                              
                                            <!-- sldks -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- sjdksjd -->                                                  
                                            <div class="row">
                                                <div class="col-md-4">Requisition Date:</div>
                                                <div class="col-md-8">From<input type="text" class="datepicker numbersOnly" name="requisition_date_from1" id="requisition_date_from1" placeholder="dd-mm-yyyy"></div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-8">To<input type="text" class="datepicker numbersOnly" name="requisition_date_to1" id="requisition_date_to1" placeholder="dd-mm-yyyy"></div>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title-area">
                                <h1 class="title text-center" id="page-title">Car Requisition List</h1>
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
                                <div class="col-md-8" style="padding-right:0px;  padding-top: 5px;  text-align: right;">View per page</div>
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
                                    <th>Requester Name</th>
                                    <th>Requisition Date</th>
                                    <th>Requisition Time</th>
                                    <th>Purpose</th>  
                                    <th>Requisition Location</th>  
                                    <th>Location Distance</th>
                                    <th>Car Code</th>
                                    <th>Driver Name</th>
                                    <th>Driver Phone</th>
                                    <th>Notes</th>                                                                                                                                              
                                    <th>Status</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th style="width:10px!important;"></th>
                                    <th>Requester Name</th>
                                    <th>Requisition Date</th>
                                    <th>Requisition Time</th>
                                    <th>Purpose</th>  
                                    <th>Requisition Location</th>  
                                    <th>Location Distance</th>
                                    <th>Car Code</th>
                                    <th>Driver Name</th>
                                    <th>Driver Phone</th>
                                    <th>Notes</th>                                                                                                                                              
                                    <th>Status</th>
                                    <th>Edit</th>
                                </tr>
                            </tfoot>

                            <tbody>
                                <?php
                                foreach ($records as $sigle_requisition) {
                                    $id = $sigle_requisition['id'];
                                    $requester_content_id = $sigle_requisition['requester_content_id'];
                                    $requester_data=$this->search_field_emp_model->getallsearch_table_contentByid($requester_content_id);
                                    $requester_name=$requester_data['emp_name'];
                                    $Requisition_Date=$sigle_requisition['Requisition_Date']; 
                                    $Requisition_Time=$sigle_requisition['Requisition_Time']; 
                                    $purpose=$sigle_requisition['purpose']; 
                                    $Requisition_Location=$sigle_requisition['Requisition_Location']; 
                                    $Location_Distance=$sigle_requisition['Location_Distance']; 
                                    $Car_content_id=$sigle_requisition['Car_Code']; 
                                    $car_data=$this->car_info_model->getcar_info($Car_content_id);
                                    $car_code=$car_data['Car_Code'];
                                    $driver_content_id=$sigle_requisition['driver_content_id']; 
                                    $driver_data=$this->search_field_emp_model->getallsearch_table_contentByid($driver_content_id);
                                    $driver_name=$driver_data['emp_name'];
                                    $driver_mobile_no=$driver_data['mobile_no'];
                                    $Requisition_Status=$sigle_requisition['Requisition_Status']; 
                                    $remarks=$sigle_requisition['notes'];                                     
                                    $status=$sigle_requisition['status'];                                     

                                    ?>
                                    <tr>
                                        <td style="width:10px!important"><input type='checkbox' name='id[]' value='<?php print $id; ?>' /></td>                                    
                                        <td><?php print $requester_name; ?></td>
                                        <td><?php print $Requisition_Date; ?></td>
                                        <td><?php print $Requisition_Time; ?></td>                                      
                                        <td><?php print $purpose; ?></td>
                                        <td><?php print $Requisition_Location; ?></td>
                                        <td><?php print $Location_Distance; ?></td>
                                        <td><?php print $car_code; ?></td>                                                                                                                        
                                        <td><?php if($driver_name){ print $driver_name; } ?></td>                                        
                                        <td><?php print $driver_mobile_no; ?></td>
                                        <td><?php print $remarks; ?></td>
                                        <td><?php if($status==1){print "Approved";}else if($status==2){print "Pending";}else if($status==3){print "Cancel";} ?></td>
                                        <td>
                                            <a href="<?php echo site_url("vahicles/addrequisition") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit Details" /></a>
                                            <!-- <a href="<?php echo site_url("addprofile/deleteemployee") . '/' . $id; ?>" class="operation-cut operation-link" onClick="return ConfirmDelete()"> <img src="<?php echo base_url(); ?>resources/images/cut.jpg" alt="edit" /></a> -->
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
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->           
    </body>
</html>