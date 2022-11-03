<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Details Circular</title>
        <?php
        $this->load->view('includes/cssjs');
        ?> 

    </head>
    <body class="logged-in dashboard current-page add-division">
        <!-- Page Content -->  
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php
                $this->load->view('includes/menu');
           
                    ?>
                    <div class="row under-header-bar text-center"> 
                        <h4>Details Circular</h4>         
                    </div> 
                    <div class="wrapper">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?php echo site_url(); ?>recruitment/view_circular" class="btn btn-default"><span class="glyphicon glyphicon-backward"> </span> Circuar</a>
                                <div class="row">
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-2" style="background: #cccccc;">
                                            <div class="row"><img src="<?php echo base_url() . $display_detail_by_id->BannerImage; ?>" style="border:1px solid #ccc;"width="100%" /></div>
                                            <div class="row">
                                                <strong style="display: block; margin-bottom: 10px; border-bottom: 1px solid #fff;padding:5px ">
                                                    <span class="glyphicon glyphicon-map-marker"></span> Job Location:
                                                </strong>  
                                                <div class="value" style="display: block; margin-bottom: 15px; padding:5px "><?php echo $display_detail_by_id->JobLocation; ?></div>
                                            </div>
                                            <div class="row">
                                                <strong style="display: block; margin-bottom: 10px; border-bottom: 1px solid #fff;padding:5px ">
                                                    <span class="glyphicon glyphicon-usd"></span> Salary:
                                                </strong>  
                                                <div class="value" style="display: block; margin-bottom: 15px; padding:5px "><?php echo $display_detail_by_id->Salary; ?> </div>
                                            </div>
                                            <div class="row">
                                                <strong style="display: block; margin-bottom: 10px; border-bottom: 1px solid #fff;padding:5px ">
                                                    <span class="glyphicon glyphicon-shield"></span> Job Experience:
                                                </strong>  
                                                <div class="value" style="display: block; margin-bottom: 15px; padding:5px "><?php echo $display_detail_by_id->JobExperience; ?></div>
                                            </div>
                                            <div class="row">
                                                <strong style="display: block; margin-bottom: 10px; border-bottom: 1px solid #fff;padding:5px ">
                                                    <span class="glyphicon glyphicon-calendar"></span> Start Date:
                                                </strong>  
                                                <div class="value" style="display: block; margin-bottom: 15px; padding:5px "><?php echo $display_detail_by_id->StartDate; ?></div>
                                            </div>
                                            <div class="row">
                                                <strong style="display: block; margin-bottom: 10px; border-bottom: 1px solid #fff;padding:5px ">
                                                    <span class="glyphicon glyphicon-calendar"></span> End Date:
                                                </strong>  
                                                <div class="value" style="display: block; margin-bottom: 15px; padding:5px "><?php echo $display_detail_by_id->EndDate; ?></div>
                                            </div>
                                            <div class="row">
                                                <strong style="display: block; margin-bottom: 10px; border-bottom: 1px solid #fff;padding:5px ">
                                                    <span class="glyphicon glyphicon-shield"></span> Vacancy:
                                                </strong>  
                                                <div class="value" style="display: block; margin-bottom: 15px; padding:5px "><?php echo $display_detail_by_id->Vacancy; ?></div>
                                            </div>
                                            <div class="row">
                                                <strong style="display: block; margin-bottom: 10px; border-bottom: 1px solid #fff;padding:5px ">
                                                    <span class="glyphicon glyphicon-shield"></span> Division:
                                                </strong>  
                                                <div class="value" style="display: block; margin-bottom: 15px; padding:5px "><?php echo $display_detail_by_id->division_name; ?></div>
                                            </div>
                                            <div class="row">
                                                <strong style="display: block; margin-bottom: 10px; border-bottom: 1px solid #fff;padding:5px ">
                                                    <span class="glyphicon glyphicon-shield"></span> Department:
                                                </strong>  
                                                <div class="value" style="display: block; margin-bottom: 15px; padding:5px "><?php echo $display_detail_by_id->department_name; ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="padding:15px;margin-left: 15px; text-align: justify;line-height: 25px;">
                                            <div class="row" style="margin-bottom:10px;"> <h2><?php echo $display_detail_by_id->post_name; ?></h2> </div>
                                            <div class="row" style="margin-bottom:15px;"> <span style="padding: 5px; background: #ccc; border-radius: 5px;"> <?php echo $display_detail_by_id->JobType; ?></span> </div>
                                            <div class="row" style="margin-bottom:20px;"> <?php echo $display_detail_by_id->ShortDescription; ?> </div>
                                            <div class="row" style="margin-bottom:10px; border-bottom: 1px solid #ccc;"><h3>Job Description:</h3> </div>
                                            <div class="row" style="margin-bottom:20px;"> <?php echo $display_detail_by_id->LongDescription; ?> </div>
                                            <div class="row" style="margin-bottom:10px; border-bottom: 1px solid #ccc;"><h3>Job requirements :</h3> </div>
                                            <div class="row" style="margin-bottom:20px;"> <?php echo $display_detail_by_id->JobRequirments ; ?> </div>
                                            <div class="row" style="margin-bottom:10px; border-bottom: 1px solid #ccc;"><h3>Education :</h3> </div>
                                            <div class="row" style="margin-bottom:20px;"> <?php echo $display_detail_by_id->Education ; ?> </div>
                                            <div class="row" style="margin-bottom:10px; border-bottom: 1px solid #ccc;"><h3>Other Benefits  :</h3> </div>
                                            <div class="row" style="margin-bottom:20px;"> <?php echo $display_detail_by_id->OtherBenifits ; ?> </div>
                                          
                                        </div>
                                          <div class="col-md-2"></div>
                                    </div>
                                  
                                    
                                </div>



                        </div>
                    </div>              
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>

    </body>
    </html>
