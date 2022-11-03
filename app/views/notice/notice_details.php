<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Details Notice</title>
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
                    <h4>Notice Detail    </h4>         
                </div> 
                <div class="wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?php echo site_url(); ?>notice/view_notice" class="btn btn-default"><span class="glyphicon glyphicon-backward"> </span> Notice</a>

                            <div class="row">
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2" style="background: #cccccc;">
                                        <div class="row">
                                            <strong style="display: block; margin-bottom: 10px; border-bottom: 1px solid #fff;padding:5px ">
                                                 Notice Name:
                                            </strong>  
                                            <div class="value" style="display: block; margin-bottom: 15px; padding:5px ">
                                                <?php echo $display_notice_detail_by_id->NoticeName; ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <strong style="display: block; margin-bottom: 10px; border-bottom: 1px solid #fff;padding:5px ">
                                                Short Description:
                                            </strong>  
                                            <div class="value" style="display: block; margin-bottom: 15px; padding:5px ">
                                                <?php echo $display_notice_detail_by_id->ShortDescription; ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <strong style="display: block; margin-bottom: 10px; border-bottom: 1px solid #fff;padding:5px ">
                                               Published On:
                                            </strong>  
                                            <div class="value" style="display: block; margin-bottom: 15px; padding:5px ">
                                             
                                                
                                                    <?php $PublishedOn = date_create($display_notice_detail_by_id->PublishedOn);
                                    echo date_format($PublishedOn, 'F j, Y');
                                        ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <strong style="display: block; margin-bottom: 10px; border-bottom: 1px solid #fff;padding:5px ">
                                                 Long Description:
                                            </strong>  
                                            <div class="value" style="display: block; margin-bottom: 15px; padding:5px ">
                                                <?php echo $display_notice_detail_by_id->LongDescription; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8" style="padding:15px;margin-left: 15px; text-align: justify;line-height: 25px;">
                                        <div class="row" style="margin-bottom:15px;">

                                            <a href="<?php echo base_url() . $display_notice_detail_by_id->NoticeFile; ?>" target="_blank" style=" position: absolute; right: 0px; top:5px"> Open with new window</a>
                                        </div>
                                        <div class="row" style="margin-bottom:20px;"> 
                                            <iframe width="100%" height="1180" src="<?php echo base_url() . $display_notice_detail_by_id->NoticeFile; ?>"></iframe>
                                        </div>
                                    </div>
                                   
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
