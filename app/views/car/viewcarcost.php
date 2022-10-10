<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Car Cost List</title>
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
                    "aoColumnDefs": [ { 'bSortable': false, 'aTargets': [ 0,8 ] }  ]
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
   // setInterval(function() { if (document_focus === true) { newwindow.close();  document_focus = false;}  }, 7000);
   
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
            $searchpage="viewcarcost";
            $per_page_query = $this->search_field_emp_model->getsearchQuery($searchpage);            
            ?> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url(); ?>vahicles/viewcarcost" method="post" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
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
                                                    <?php foreach ($cost_car as $single_car) {
                                                        if($single_car['record']){
                                                            $car_data=$this->car_info_model->getcar_info($single_car['record']);
                                                            echo '<option value="'.$single_car['record'].'">'.$car_data['Vehicle_Name'].'</option>';
                                                        }
                                                    } ?>
                                                  </select>                       
                                                </div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-4">Bearer Name</div>
                                              <div class="col-md-8">
                                                <select name="Bearer_Name" id="Bearer_Name">
                                                    <option value="">Select Bearer Name</option>
                                                     <?php foreach ($cost_bearer as $single_bearer) {
                                                        if($single_bearer['record']){
                                                            if($single_bearer['record']){
                                                                $bearer_data=$this->search_field_emp_model->getallsearch_table_contentByid($single_bearer['record']);
                                                                $bearer_name=$bearer_data['emp_name'];
                                                                 echo '<option value="'.$single_bearer['record'].'">'.$bearer_name.'</option>';
                                                            }                                                           
                                                       
                                                        }
                                                    } ?>
                                                </select>        
                                                </div>
                                            </div>   
                                            <div class="row">
                                                <div class="col-md-4">Expense Type</div>
                                              <div class="col-md-8">
                                                <select name="Expense_type" id="Expense_type">
                                                    <option value="">Select Expense Type</option>
                                                     <?php foreach ($alladdedcost_type as $single_cost_type) {
                                                        if($single_cost_type['record']){
                                                            $cost_type_data=$this->taxonomy->getTaxonomyBytid($single_cost_type['record']);
                                                            echo '<option value="'.$single_cost_type['record'].'">'.$cost_type_data['name'].'</option>';                                                              
                                                        }
                                                    } ?>
                                                </select>        
                                                </div>
                                            </div>                                                                                                                                                                                                                                                                                                                                                                                                                          
                                            <!-- sldks -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- sjdksjd -->     
                                            <div class="row">
                                                <div class="col-md-4">Expense Date:</div>
                                                <div class="col-md-8">From<input type="text" class="datepicker numbersOnly" name="Expense_date_from1" id="Expense_date_from1" placeholder="dd-mm-yyyy"></div>
                                            </div>  
                                            <div class="row">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-8">To<input type="text" class="datepicker numbersOnly" name="Expense_date_to1" id="Expense_date_to1" placeholder="dd-mm-yyyy"></div>
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
                    <div class="row" style="padding: 5px; background: #A6CAF0;  margin-bottom: 20px;">
                        <div class="col-md-1">
                            <a  onclick="return popitup('<?php echo site_url("savepdfcar/printcarcostpdf") ; ?>')" href="<?php echo site_url("savepdfcar/printcarcostpdf") ; ?>"  class="operation-print-pdf operation-link"> <img src="<?php echo base_url(); ?>resources/images/pdf_icon_print.png" alt="pdf"/></a>
                        </div>
                        <div class="col-md-11">
                            <div class="title-areaa">
                                <h1 class="title text-center" id="page-title">Car Cost List </h1>
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
            <div class="row">
              <div class="col-md-12 text-right"></div>
            </div>                                            
                        <table id="example" class="display" cellspacing="0" width="100%" border="1">
                            <thead>
                                <tr class="heading">
                                    <th style="padding-left: 10px;text-align: left;width:10px!important"><input type='checkbox' class="check_all" id="check_all" value='all' /></th>                                
                                    <th>Vehicle Code</th>
                                    <th>Vehicle Name</th>                                                                                                                                           
                                    <th>Cost Type</th>                                                                                                                                           
                                    <th>Cost Amount</th>                                                                                                                                           
                                    <th>Cost Date</th>                                                                                                                                           
                                    <th>Bearer</th>
                                    <th>Remarks</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th style="width:10px!important;"></th>
                                    <th>Vehicle Code</th>
                                    <th>Vehicle Name</th>                                                                                                                                           
                                    <th>Cost Type</th>                                                                                                                                           
                                    <th>Cost Amount</th>                                                                                                                                           
                                    <th>Cost Date</th>                                                                                                                                           
                                    <th>Bearer</th>
                                    <th>Remarks</th>
                                    <th>Edit</th>
                                </tr>
                            </tfoot>

                            <tbody>
                                <?php
                                foreach ($records as $single_cost) {
                                    $id = $single_cost['id'];
                                    $car_id = $single_cost['car_id'];
                                    $car_data=$this->car_info_model->getcar_info($car_id);
                                    $car_code=$car_data['Car_Code'];
                                    $car_name=$car_data['Vehicle_Name'];
                                    $Cost_Type_id = $single_cost['Cost_Type'];
                                    $cost_type_data2=$this->taxonomy->getTaxonomyBytid($Cost_Type_id);
                                    $cost_type_name=$cost_type_data2['name'];
                                    $Cost_Amount = $single_cost['Cost_Amount'];
                                    $Cost_Date = $single_cost['Cost_Date'];
                                    $buyer_id = $single_cost['buyer'];
                                    $buyer_data=$this->search_field_emp_model->getallsearch_table_contentByid($buyer_id);
                                    $buyer_name=$buyer_data['emp_name'];                                    
                                    $Remarks = $single_cost['Remarks'];

                                    ?>
                                    <tr>
                                        <td style="width:10px!important"><input type='checkbox' name='id[]' value='<?php print $id; ?>' /></td>                                    
                                        <td><?php print $car_code; ?></td>
                                        <td><?php print $car_name; ?></td>
                                        <td><?php print $cost_type_name; ?></td>
                                        <td><?php print $Cost_Amount; ?></td>                                        
                                        <td><?php print $Cost_Date; ?></td>
                                        <td><?php print $buyer_name; ?></td>
                                        <td><?php print $Remarks; ?></td>
                                        <td>
                                            <a href="<?php echo site_url("carcost/addcarcost") . '/' . $id; ?>" class="operation-edit operation-link ev-edit-link"><img src="<?php echo base_url(); ?>resources/images/edit.png" alt="edit Details" /></a>
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