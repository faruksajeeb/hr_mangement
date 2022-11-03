<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Details Applicant</title>
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
                        <h4>Applicant Detail    </h4>         
                    </div> 
                    <div class="wrapper">
                        <div class="row">
                            <div class="col-md-12">
                               <div class="row">
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-2" style="background: #cccccc;">
                                            <div class="row"><img src="<?php echo base_url() . $applicant_detail->ApplicantImage; ?>" style="border:1px solid #ccc;"width="100%" /></div>
                                            <div class="row">
                                                <strong style="display: block; margin-bottom: 10px; border-bottom: 1px solid #fff;padding:5px ">
                                                    <span class="glyphicon glyphicon-envelope"></span> Email:
                                                </strong>  
                                                <div class="value" style="display: block; margin-bottom: 15px; padding:5px "><?php echo $applicant_detail->ApplicantEmail; ?></div>
                                            </div>
                                            <div class="row">
                                                <strong style="display: block; margin-bottom: 10px; border-bottom: 1px solid #fff;padding:5px ">
                                                    <span class="glyphicon glyphicon-phone"></span> Phone:
                                                </strong>  
                                                <div class="value" style="display: block; margin-bottom: 15px; padding:5px "><?php echo $applicant_detail->ApplicantPhone; ?> </div>
                                            </div>
                                   
                                            <div class="row">
                                                <strong style="display: block; margin-bottom: 10px; border-bottom: 1px solid #fff;padding:5px ">
                                                    <span class="glyphicon glyphicon-calendar"></span> Applied Time:
                                                </strong>  
                                                <div class="value" style="display: block; margin-bottom: 15px; padding:5px "><?php echo $applicant_detail->AppliedTime; ?></div>
                                            </div>
                                            <div class="row">
                                                <strong style="display: block; margin-bottom: 10px; border-bottom: 1px solid #fff;padding:5px ">
                                                    <span class="glyphicon glyphicon-old-man"></span>Applied Position:
                                                </strong>  
                                                <div class="value" style="display: block; margin-bottom: 15px; padding:5px ">
                                                    <?php echo $applicant_detail->post_name; ?> 
                                               
                                                </div>
                                            </div>
                                     
                                            <div class="row">
                                                <strong style="display: block; margin-bottom: 10px; border-bottom: 1px solid #fff;padding:5px ">
                                                    <span class="glyphicon glyphicon-shield"></span> Division:
                                                </strong>  
                                                <div class="value" style="display: block; margin-bottom: 15px; padding:5px "><?php echo $applicant_detail->division_name; ?></div>
                                            </div>
                                            <div class="row">
                                                <strong style="display: block; margin-bottom: 10px; border-bottom: 1px solid #fff;padding:5px ">
                                                    <span class="glyphicon glyphicon-shield"></span> Department:
                                                </strong>  
                                                <div class="value" style="display: block; margin-bottom: 15px; padding:5px "><?php echo $applicant_detail->department_name; ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-8" style="padding:15px;margin-left: 15px; text-align: justify;line-height: 25px;">
                                            <div class="row" style="margin-bottom:10px;"> <h2><?php echo $applicant_detail->ApplicantName; ?>
                                                    <?php if($applicant_detail->Status==0){?>
                                                  <a href="<?php echo base_url();?>recruitment/update_applicant_status/shortlist/<?php echo $applicant_detail->ApplicantID ?>" class="btn btn-success  btn-md"><span class="glyphicon glyphicon-ok" title="Short List"></span> Shortlist</a>
                                                    <?php }else if($applicant_detail->Status==1){?>
                                                   <a href="<?php echo base_url();?>recruitment/update_applicant_status/written/<?php echo $applicant_detail->ApplicantID ?>" class="btn btn-success  btn-md"><span class="glyphicon glyphicon-ok" title="Short List"></span> Written</a>
                                                    <?php }else if($applicant_detail->Status==2){?>
                                                   <a href="<?php echo base_url();?>recruitment/update_applicant_status/interview/<?php echo $applicant_detail->ApplicantID ?>" class="btn btn-success  btn-md"><span class="glyphicon glyphicon-ok" title="Short List"></span> interview</a>
                                                    <?php }else if($applicant_detail->Status==3){?>
                                                   <a href="<?php echo base_url();?>recruitment/update_applicant_status/selected/<?php echo $applicant_detail->ApplicantID ?>" class="btn btn-success  btn-md"><span class="glyphicon glyphicon-ok" title="Short List"></span> selected</a>
                                                    <?php }else if($applicant_detail->Status==4){?>
                                                   <a href="<?php echo base_url();?>recruitment/update_applicant_status/appointed/<?php echo $applicant_detail->ApplicantID ?>" class="btn btn-success  btn-md"><span class="glyphicon glyphicon-ok" title="Short List"></span> Appointed</a>
                                                    <?php }else{?>
                                                   <a href="<?php echo base_url();?>recruitment/update_applicant_status/joined/<?php echo $applicant_detail->ApplicantID ?>" class="btn btn-success  btn-md"><span class="glyphicon glyphicon-ok" title="Short List"></span> Joined</a>
                                                    <?php } ?>
                                                </h2>
                                            
                                            </div>
                                            <div class="row" style="margin-bottom:15px;">
                                          
                                                <a href="<?php echo base_url().$applicant_detail->ApplicantCV; ?>" target="_blank" style=" position: absolute; right: 0px; top:40px"> Open with new window</a>
                                            </div>
                                            <div class="row" style="margin-bottom:20px;"> 
                                             <iframe width="100%" height="1180" src="<?php echo base_url().$applicant_detail->ApplicantCV; ?>"></iframe>
                                            
                                            </div>
                                          
                                          
                                        </div>
                                          <div class="col-md-1"></div>
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
