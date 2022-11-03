<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Applicant  List</title>
        <?php
        $this->load->view('includes/printcss');
        date_default_timezone_set('Asia/Dhaka');
        $servertime = time();
        $today_date = date("d-m-Y", $servertime);
        ?> 

        <style>

            body{
                background-color: #ffffff;
            }
            .container-fluid{
                width: 100%;
                background-color: #ffffff;
                padding: 0!important;
                margin: 0;
            }

            .under-header-bar {
                min-height: 13px;
                background: #ffffff;
                padding: 3px;
                color: #fff;
                font-weight: bold;
            }
            body{
                -webkit-print-color-adjust:exact;
                color: #696969;
                line-height: 1;
                font-family: Arial,sans-serif; 
                background: none;
                background-color: white;
                background-image: none;
                font-size: 13px;

            }
            html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
                margin: 0;
                padding: 0;
                border: 0;
                vertical-align: baseline;
            }

            .container {
                width: 100%;
                margin-right: auto;
                margin-left: auto;
                padding-left: 2px;
                padding-right: 2px;
                border: 1px solid #000;
            }

            .main-container.container {
                background-color: inherit;
                background-image: none;
                background-repeat: inherit;
                border: 1px solid #000;
                border-style: outset;
                overflow: hidden;
            }
            .container.main-container .row {
                margin-top: 4px!important;
            }
            .row {
                margin-left: -15px;
                margin-right: -15px;
            }
            .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
                float: left;
            }
            .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
                position: relative;
                min-height: 1px;
                padding-left: 15px;
                padding-right: 15px;
            }

            .red-color{
                color: red!important;
                -webkit-print-color-adjust: exact;
            }

            #logo-img{
                height: 42px;
                width: 75px;
            }

            #example td, th {
                padding: 0.30em 0.20em;
                text-align: left;
            }
            table tr.heading {
                background: #ddd;
                color: #000;
            }
            tbody tr:nth-child(odd) {
                background: #ffffff;
            }
            table tbody tr {
                background-color: #ffffff;
            }
            table {
                padding: 0;
                margin: 0;
                background-color: #ffffff;
                font-size: 13px;
            }
            #example td, th {
                padding: 0.10em 0.80em 0.20em 0.80em;
                text-align: center;
            }
        </style>
        <style  type="text/css" media="print">
            @page 
            {
                size: auto;   
                margin-bottom: 35px; 
                margin-left: 24px; 
                margin-top: 35px; 
                margin-right: 35px; 
                margin-footer: 20mm;
            }
            body 
            {
                font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; 
                color: #000;
                margin-bottom: 35px; 
            }
            .row{
                margin-bottom: 5px!important;
            }
            .red-color{color: red;}
            .blue-color{    color: #210EFF;
                            font-weight: bold;}
            </style>  
        </head>
        <body class="logged-in dashboard current-page print-attendance">
        <!-- Page Content -->  
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php
                date_default_timezone_set('Asia/Dhaka');
                $servertime = time();
                $now = date("d-m-Y H:i:s", $servertime);
                $nowdate = date("d-m-Y", $servertime);
                $thisyear = date("Y", $servertime);
                $nowtime = date("H:i:s a", $servertime);
                $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
                $last_day_this_month = date('t-m-Y');
                $user_id = $this->session->userdata('user_id');
                $user_type = $this->session->userdata('user_type');
                $post_name = $this->session->userdata('post_name');
                $view_salary_in_emp_list = $this->users_model->userpermission("view_salary_in_emp_list", $user_type);
                $add_edit_profile = $this->users_model->userpermission("add_edit_profile", $user_type);
                $searchpage = "view_applicants"; 
                $query = $this->circular_model->get_all_applicant_data($searchpage);
                $data = array( 
                    'all_applicant' => $query['result'],
                    'num_row' => $query['rows']
                );
                $applicant_status=$this->session->userdata('applicant_status');
                ?> 
                <div class="row" style="font-weight:normal">
                    <div class="col-md-2" style="float:left;text-align: left;width:620px;">
                        <h1 style="font-size:25px;font-weight:bold">IIDFC Securities Limited</h1>
                        <!-- <p>House #25, Road #34, Gulshan-2, Dhaka-1212</p>
                        <p>Telephone: +8802-8812396, 9880916, 9881424, 8818561, 9892111</p>
                        <p>Fax: +8802-8826439, 9880918</p>
                        <p>E-mail : ahmedamingroup@gmail.com, misaag@ahmedamin.com</p> -->
                      
                    </div>
                    <!-- <div class="col-md-2" style="float:right;width:120px;" > <img src="<?php echo base_url(); ?>resources/images/logo.png" style="width:100px;height:100px;display:inline;" alt="" id="logo-img"/></div> -->


                </div>
                <div class="row" style="border-bottom:1px solid #ccc;" id="list"></div>
                <?php if($post_name){?>
                <h3 style="font-weight:bold;font-size:12px;">Job Title: <?php echo $post_name; ?></h3>
                <?php }?>
                <p >Downloaded on: <?php echo $now; ?></p>

                <div class="row under-header-bar text-center"> 
                    <h1 style="font-size:20px;font-weight:bold">
                        Summary of <?php
                        if($applicant_status==1){
                            echo "Shortlisted";
                        }else if($applicant_status==2){
                            echo "Written";
                        }else if($applicant_status==3){
                            echo "Interview";
                        }else if($applicant_status==4){
                            echo "Selected";
                        }else if($applicant_status==5){
                            echo "Appointed";
                        }else if($applicant_status==6){
                            echo "Joined";
                        }else{
                            echo "New";
                        }
                        ?> Applicant List 
                    </h1>         
                </div> 

                <div class="wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <style>
                                table, th, td {
                                    border: 1px solid #A9A9A9 ;
                                }
                            </style>
                            <table id="example" class="display" cellspacing="0" width="100%" border="1" >
                                <thead>
                                    <tr class="heading">                               
                                        <th>Sl no.</th>
                                        <th>Image</th>
                                        <th>Applicant Name</th>
                                        <th>Career Summary</th>
                                        <th>Experience</th>
                                        <th>Expected Salary</th>
                                         <?php if(!$post_name){?>
                                        <th>Post Name</th>
                                         <?php }?>
                                        <th>Applied on</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size:10px;">
                                    <?php
//                                                    print_r($applicant_data);
//                                    exit;
                                    if ($applicant_data['applicant_id']) { 
                                        $sl_no = 1;
                                        foreach ($applicant_data['applicant_id'] as $sigle_applicant_id) {
                                            $single_applicant = $this->circular_model->getAllApplicantById($sigle_applicant_id);
                                            ?>
                                            <tr>                                    
                                                <td><?php echo $sl_no; ?></td>
                                                <td>
                                                    <img src="<?php echo base_url() . $single_applicant->ApplicantImage; ?>" width="30" />
                                                </td>
                                               <td style="text-align:left;">
                                                <?php echo nl2br ("<strong>".$single_applicant->ApplicantName."</strong> \r\n Age: ".$single_applicant->Age." \r\n ".$single_applicant->LastInstitute." "
                                                        . " \r\n <a href='callto:".$single_applicant->ApplicantPhone."'>".$single_applicant->ApplicantPhone ."</a>"); ?> 
                                            </td>
                                                <td><span class="glyphicon glyphicon-envelope" title="Trash"  ></span> <?php echo $single_applicant->ExpDetail; ?></td>
                                                <td><span class="glyphicon glyphicon-earphone" title="Trash"  ></span> <?php echo $single_applicant->TotalExp ." years" ; ?></td>
                                                <td><span class="glyphicon glyphicon-earphone" title="Trash"  ></span> <?php echo $single_applicant->ExpSalary. " Tk" ; ?></td>
                                               <?php if(!$post_name){?>
                                                <td><?php echo $single_applicant->post_name; ?></td>
                                               <?php }?>
                                                <td><?php
                                    $appliedOn = date_create($single_applicant->AppliedTime);
                                    echo date_format($appliedOn, 'F j, Y');
                                            ?></td>
                                            </tr>
                                            <?php
                                            $sl_no++;
                                        }
                                    } else {

                                        $sl_no = 1;
                                        foreach ($data['all_applicant'] as $single_applicant) {
                                            ?>
                                            <tr class="separator">
                                                <td><?php echo $sl_no; ?></td>
                                                <td>
                                                    <img src="<?php echo base_url() . $single_applicant->ApplicantImage; ?>" width="30" />
                                                </td>
                                                <td style="text-align:left;">
                                                <?php echo nl2br ("<strong>".$single_applicant->ApplicantName."</strong> \r\n Age: ".$single_applicant->Age." \r\n ".$single_applicant->LastInstitute." "
                                                        . " \r\n <a href='callto:".$single_applicant->ApplicantPhone."'>".$single_applicant->ApplicantPhone ."</a> "); ?> 
                                            </td>
                                                <td style="text-align:left;"><span class="glyphicon glyphicon-envelope" title="Trash"  ></span> <?php echo $single_applicant->ExpDetail; ?></td>
                                                <td><span class="glyphicon glyphicon-earphone" title="Trash"  ></span> <?php echo $single_applicant->TotalExp ." years" ; ?></td>
                                                <td><span class="glyphicon glyphicon-earphone" title="Trash"  ></span> <?php echo $single_applicant->ExpSalary. " Tk" ; ?></td>
                                                <?php if(!$post_name){?>
                                                <td><?php echo $single_applicant->post_name; ?></td>
                                               <?php }?>
                                                <td><?php
                                                    $appliedOn = date_create($single_applicant->AppliedTime);
                                                    echo date_format($appliedOn, 'F j, Y');
                                                    ?></td>


                                            </tr>
                                            <?php
                                            $sl_no++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>  
                        </div>
                    </div>
                </div>
                <!-- /#page-content-wrapper -->
            </div>
            <!-- /#wrapper -->        
    </body>
</html>