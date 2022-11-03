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
                // $('#example tfoot th').each(function () {
                //     var title = $('#example thead th').eq($(this).index()).text();
                //     $(this).html('<input type="text" placeholder="Search ' + title + '" />');
                // });

                // DataTable
                // var table = $('#example').DataTable();

                // Apply the search
                // table.columns().eq(0).each(function (colIdx) {
                //     $('input', table.column(colIdx).footer()).on('keyup change', function () {
                //         table
                //                 .column(colIdx)
                //                 .search(this.value)
                //                 .draw();
                //     });
                // });

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
    <style type="text/css">
    .under-header-bar a{
            color: #fff;
    text-decoration: none;
    }
    </style>  
</head>
<body class="logged-in dashboard current-page add-division">
    <!-- Page Content -->  
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php 
            //$this -> load -> view('includes/menu');
            ?>
                <div class="row header">
                    <div class="col-md-2">
                        <div class="logo">
                            <img src="<?php echo base_url(); ?>resources/images/logo.png" alt="" id="logo-img"/>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="company_name">
                            <h1>IIDFC Securities Limited</h1>
                        </div>
                    </div>               
                </div>            
            <div class="row under-header-bar text-center"> 
             <div class="col-md-4"><a href="http://ahmedamin.com/dav/career-opportunity">CAREER HOME</a></div> 
             <div class="col-md-4"><a href="<?php echo site_url("recruitment_pub/viewcircular"); ?>">AVAILABLE JOBS</a></div> 
             <!-- <div class="col-md-4"><a href="<?php echo site_url("recruitment_pub/viewcircular"); ?>">USER LOGIN</a></div>  -->
                <!-- <h4>Available Jobs</h4>      -->
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <?php 
                        date_default_timezone_set('Asia/Dhaka');
                        $servertime = time();
                        $now = date("d-m-Y", $servertime);
                        $Start_Date=$toview_records['Start_Date'];
                        $Last_Date=$toview_records['Last_Date'];
                        if(strtotime($Start_Date) <= strtotime($now) && strtotime($Last_Date) >= strtotime($now)){
                        $id=$toview_records['id'];
                        $post_data=$this->taxonomy->getTaxonomyBytid($toview_records['position_id']);
                        print "<h4>Position: </h4>".$post_data['name'];
                        ?>
                        <br/>
                        <br/>
                        <?php if($toview_records['Start_Date']){
                            print "<h4>Start Date: </h4>".$toview_records['Start_Date'];
                         } ?>
                         <br/>
                         <br/>
                        <?php if($toview_records['Last_Date']){ 
                            print "<h4>Last Date: </h4>".$toview_records['Last_Date'];
                             } ?>
                             <br/>
                             <br/>
                             <?php if($toview_records['short_description']){ 
                            print "<h4>Summery Details: </h4>".nl2br($toview_records['short_description']);
                             } ?>
                             <br/>
                             <br/>
                             <?php if($toview_records['description']){ 
                            print "<h4>Details: </h4>".nl2br($toview_records['description']);
                             } ?>
                             <br/>
                             <br/>
                             <div class="row text-center">
                                 <a href="<?php echo site_url("recruitment_pub/applynow") . '/' . $id; ?>" class="btn btn-primary">Apply Now</a>
                                 <br>
                                 <br>
                                 <br>
                             </div>
                             <?php }else{

                                } ?>
                        </div>
                    </div>                                 
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->        
    </body>
    </html>