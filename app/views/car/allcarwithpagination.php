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
function popitup(url) {
  newwindow=window.open(url,'name','height=auto,width=700px');
  //newwindow.print();
  window.onfocus=function(){ newwindow.close();}
  if (window.focus) {newwindow.focus(); }
  var document_focus = false;
  $(newwindow).focus(function() { document_focus = true; });
  $(newwindow).load(function(){
 });
  return false;
}
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
            $searchpage="cars";
            $per_page_query = $this->search_field_emp_model->getsearchQuery($searchpage);            
            ?> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url(); ?>findcarlist/cars" method="post" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
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
                                                <div class="col-md-4">Vehicle Name:</div>
                                                <div class="col-md-8">
                                                  <select name="Vehicle_Name" id="Vehicle_Name">
                                                    <option value="">Select Vehicle Name</option>
                                                    <?php foreach ($car_name as $single_car) {
                                                        if($single_car['record']){
                                                            echo '<option value="'.$single_car['record'].'">'.$single_car['record'].'</option>';
                                                        }
                                                    } ?>
                                                  </select>                       
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">Vehicle Owner:</div>
                                                <div class="col-md-8">
                                                  <select name="Vehicle_Owner" id="Vehicle_Owner">
                                                    <option value="">Select Vehicle Owner</option>
                                                    <?php foreach ($car_owner as $single_car) {
                                                        if($single_car['record']){
                                                        echo '<option value="'.$single_car['record'].'">'.$single_car['record'].'</option>';
                                                        }                                                        
                                                    } ?>
                                                  </select>                       
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">Vehicle Model:</div>
                                                <div class="col-md-8">
                                                  <select name="Vehicle_Model" id="Vehicle_Model">
                                                    <option value="">Select Vehicle Model</option>
                                                    <?php foreach ($car_model as $single_car) {
                                                        if($single_car['record']){
                                                        echo '<option value="'.$single_car['record'].'">'.$single_car['record'].'</option>';
                                                        }
                                                    } ?>
                                                  </select>                       
                                                </div>
                                            </div>    
                                            <div class="row">
                                                <div class="col-md-4">Year of Manufa:</div>
                                                <div class="col-md-8">
                                                  <select name="Model_Year" id="Model_Year">
                                                    <option value="">Select Model Year</option>
                                                    <?php foreach ($car_model_year as $single_car) {
                                                        if($single_car['record']){
                                                        echo '<option value="'.$single_car['record'].'">'.$single_car['record'].'</option>';
                                                        }
                                                    } ?>
                                                  </select>                       
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">Plate/ Tag:</div>
                                                <div class="col-md-8">
                                                  <select name="Plate" id="Plate">
                                                    <option value="">Select Plate</option>
                                                    <?php foreach ($car_plate as $single_car) {
                                                        if($single_car['record']){
                                                        echo '<option value="'.$single_car['record'].'">'.$single_car['record'].'</option>';
                                                        }
                                                    } ?>
                                                  </select>                       
                                                </div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-4">Driver Name</div>
                                              <div class="col-md-8">
                                                <select name="default_driver" id="default_driver">
                                                    <option value="">Select Driver Name</option>
                                                     <?php foreach ($car_default_driver as $single_car) {
                                                        if($single_car['record']){
                                                            if($single_car['record']){
                                                                $driver_data=$this->search_field_emp_model->getallsearch_table_contentByid($single_car['record']);
                                                                $driver_name=$driver_data['emp_name'];
                                                                 echo '<option value="'.$single_car['record'].'">'.$driver_name.'</option>';
                                                            }                                                           
                                                       
                                                        }
                                                    } ?>
                                                </select>        
                                                </div>
                                            </div>                                                                                                                                                                                                                                                                                                                                                                                
                                            <!-- sldks -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- sjdksjd -->  
<!--                                             <div class="row">
                                                <div class="col-md-4">Make:</div>
                                                <div class="col-md-8">
                                                  <select name="Make" id="Make">
                                                    <option value="">Select Vehicle Name</option>
                                                    <?php 
                                                    //foreach ($getallcar as $single_car) {
                                                        // echo '<option value="'.$single_car['Make'].'">'.$single_car['Make'].'</option>';
                                                   // } 
                                                    ?>
                                                  </select>                       
                                                </div>
                                            </div> --> 
                                            <div class="row">
                                                <div class="col-md-4">Insurance Company:</div>
                                                <div class="col-md-8">
                                                  <select name="Insurance_Company" id="Insurance_Company">
                                                    <option value="">Select Company</option>
                                                    <?php foreach ($car_insurance_company as $single_car) {
                                                        if($single_car['record']){
                                                        echo '<option value="'.$single_car['record'].'">'.$single_car['record'].'</option>';
                                                        }
                                                    } ?>
                                                  </select>                       
                                                </div>
                                            </div>                                             
                                            <div class="row">
                                                <div class="col-md-4">Color:</div>
                                                <div class="col-md-8">
                                                  <select name="Color" id="Color">
                                                    <option value="">Select Color</option>
                                                    <?php foreach ($car_color as $single_car) {
                                                        if($single_car['record']){
                                                        echo '<option value="'.$single_car['record'].'">'.$single_car['record'].'</option>';
                                                        }
                                                    } ?>
                                                  </select>                       
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">Car Status:</div>
                                                <div class="col-md-8">
                                                  <select name="Car_Status" id="Car_Status">
                                                    <option value="Active" selected="selected" >Active</option>
                                                    <option value="Inactive" <?php if($car_status=="Inactive"){ echo 'selected="selected"';} ?>>Inactive</option>
                                                    <option value="Sold" <?php if($car_status=="Sold"){ echo 'selected="selected"';} ?>>Sold</option>
                                                    <option value="Damaged" <?php if($car_status=="Damaged"){ echo 'selected="selected"';} ?>>Damaged</option>
                                                    <option value="Stolen" <?php if($car_status=="Stolen"){ echo 'selected="selected"';} ?>>Stolen</option>
                                                    <option value="">All</option>
                                                  </select>                       
                                                </div>
                                            </div>    
                                            <div class="row">
                                                <div class="col-md-4">Purchase Date:</div>
                                                <div class="col-md-8">From<input type="text" class="datepicker numbersOnly" name="Purchase_date_from1" id="Purchase_date_from1" placeholder="dd-mm-yyyy"></div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-8">To<input type="text" class="datepicker numbersOnly" name="Purchase_date_to1" id="Purchase_date_to1" placeholder="dd-mm-yyyy"></div>
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
                    <div class="row"  style="padding: 5px; background: #A6CAF0;  margin-bottom: 20px;">
                        <div class="col-md-12">
                        <div class="col-md-1">
                            <a  onclick="return popitup('<?php echo site_url("savepdfcar/printcarlistpdf") ; ?>')" href="<?php echo site_url("savepdfcar/printcarlistpdf") ; ?>"  class="operation-print-pdf operation-link"> <img src="<?php echo base_url(); ?>resources/images/pdf_icon_print.png" alt="pdf"/></a>
                        </div>
                        <div class="col-md-11">
                            <div class="title-areaa">
                                <h1 class="title text-center" id="page-title">Car List </h1>
                                <span  class="total-query" style="  float: right;  margin-top: -19px; font-size: 20px;">Total:<?php print $total_search; ?></span>
                            </div> 

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
                                <div class="col-md-8" style="padding-right:0px;  padding-top: 5px;  text-align: right;">Car per page</div>
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
                                    <th>Vehicle Code</th>
                                    <th>Vehicle Name</th>
                                    <th>Vehicle Owner</th>
                                    <th>Plate/ Tag</th>  
                                    <th>Fitness Exp Date</th>  
                                    <th>Tax Paid Date</th>
                                    <th>Tax Renewal Date</th>
                                    <th>Insurance Paid Date</th>
                                    <th>Insurance Due Date</th>                                                                                                                                              
                                    <th>Driver Name</th>
                                    <th>Driver Phone</th>
                                    <th>Purchase Date</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th style="width:10px!important;"></th>
                                    <th>Vehicle Code</th>
                                    <th>Vehicle Name</th>
                                    <th>Vehicle Owner</th>
                                    <th>Plate/ Tag</th>  
                                    <th>Fitness Exp Date</th>  
                                    <th>Tax Paid Date</th>
                                    <th>Tax Renewal Date</th>
                                    <th>Insurance Paid Date</th>
                                    <th>Insurance Due Date</th>                                                                                                                                              
                                    <th>Driver Name</th>
                                    <th>Driver Phone</th>
                                    <th>Purchase Date</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                </tr>
                            </tfoot>

                            <tbody>
                                <?php
                                foreach ($records as $sigle_car) {
                                    $id = $sigle_car['id'];
                                    $Car_Code = $sigle_car['Car_Code'];
                                    $Vehicle_Name = $sigle_car['Vehicle_Name'];
                                    $Vehicle_Owner = $sigle_car['Vehicle_Owner'];
                                    $Vehicle_Model = $sigle_car['Vehicle_Model'];
                                    $Model_Year = $sigle_car['Model_Year'];
                                    $Purchase_Date = $sigle_car['Purchase_Date'];
                                    $Plate = $sigle_car['Plate'];
                                    $Make = $sigle_car['Make'];
                                    $Color = $sigle_car['Color'];
                                    $Fitness_Exp = $sigle_car['Fitness_Exp'];
                                    $Tax_Token_Date = $sigle_car['Tax_Token_Date'];
                                    $Tax_Renewal_Date = $sigle_car['Tax_Renewal_Date'];
                                    $Insurance_Date = $sigle_car['Insurance_Date'];
                                    $Insurance_Due = $sigle_car['Insurance_Due'];
                                    $default_driver_emp_id = $sigle_car['default_driver_emp_id'];
                                    if($default_driver_emp_id){
                                        $driver_data=$this->search_field_emp_model->getallsearch_table_contentByid($default_driver_emp_id);
                                        $driver_name=$driver_data['emp_name'];
                                    }else{
                                        $driver_name="";
                                    }
                                    $default_driver_phone = $sigle_car['default_driver_phone'];
                                    $Car_Status = $sigle_car['Car_Status'];
                                    ?>
                                    <tr>
                                        <td style="width:10px!important"><input type='checkbox' name='id[]' value='<?php print $id; ?>' /></td>                                    
                                        <td><?php print $Car_Code; ?></td>
                                        <td><?php print $Vehicle_Name; ?></td>
                                        <td><?php print $Vehicle_Owner; ?></td>
                                        <td><?php print $Plate; ?></td>                                        
                                        <td><?php print $Fitness_Exp; ?></td>
                                        <td><?php print $Tax_Token_Date; ?></td>
                                        <td><?php print $Tax_Renewal_Date; ?></td>
                                        <td><?php print $Insurance_Date; ?></td>                                                                                                                        
                                        <td><?php print $Insurance_Due; ?></td>
                                        <td><?php if($driver_name){ print $driver_name; } ?></td>                                        
                                        <td><?php print $default_driver_phone; ?></td>
                                        <td><?php print $Purchase_Date; ?></td>
                                        <td><?php print $Car_Status; ?></td>
                                        <td>
                                            <a href="<?php echo site_url("vahicles/addcar") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit Details" /></a>
                                            <a href="<?php echo site_url("addprofile/deleteemployee") . '/' . $id; ?>" class="operation-cut operation-link" onClick="return ConfirmDelete()"> <img src="<?php echo base_url(); ?>resources/images/cut.jpg" alt="edit" /></a>
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