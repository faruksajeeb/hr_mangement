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
            <!-- <div class="col-md-4"><a href="http://ahmedamin.com/dav/career-opportunity">CAREER HOME</a></div> -->
            <!-- <div class="col-md-4"><a href="<?php echo site_url("recruitment_pub/viewcircular"); ?>">AVAILABLE JOBS</a></div> -->
            <!-- <div class="col-md-4"><a href="<?php echo site_url("recruitment_pub/viewcircular"); ?>">USER LOGIN</a></div> -->
                <h4>Available Jobs</h4>     
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <nav>
                        <?php print $this->pagination->create_links(); ?>
                        </nav>
                    </div>
                </div>            
                <div class="row">
                    <div class="col-md-12">
                    <?php if($records){
                    ?>
                        <table id="example" class="display" cellspacing="0" width="100%" border="1">
                            <thead>
                                <tr class="heading">
                                    <th>Post Name</th>
                                    <th>Requirements</th>
                                    <th width="123px">Last Date</th>
                                    <th width="240px">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($records as $single_records) {
                                    $id = $single_records['id'];
                                    $position_id = $single_records['position_id'];
                                    $post_data=$this->taxonomy->getTaxonomyBytid($position_id);
                                    $Start_Date = $single_records['Start_Date'];
                                    $short_description = $single_records['short_description'];
                                    $Last_Date = $single_records['Last_Date'];
                                    //$description = $single_records['description'];
                                    date_default_timezone_set('Asia/Dhaka');
                                    $servertime = time();
                                    $now = date("d-m-Y", $servertime);
                                    if(strtotime($Start_Date) <= strtotime($now) && strtotime($Last_Date) >= strtotime($now)){
                                    ?>
                                    <tr>
                                        <td><?php print $post_data['name']; ?></td>
                                        <td><?php print $short_description; ?></td>
                                        <td><?php print $Last_Date; ?></td>
                                        <td>
                                            
                                            <a href="<?php echo site_url("recruitment_pub/pub_post_details") . '/' . $id; ?>" class="btn btn-primary">View Details </a>
                                            <a href="<?php echo site_url("recruitment_pub/applynow") . '/' . $id; ?>" class="btn btn-primary">Apply Now</a>
                                        </td>
                                    </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table> 
                            <?php }else{
                                print "<h1><i>Sorry, no vacancy available at this moment. </i></h1>";
                                } ?>                        
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <nav>
                            <?php print $this->pagination->create_links(); ?>
                            </nav>
                        </div>
                    </div>                                 
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->        
    </body>
    </html>