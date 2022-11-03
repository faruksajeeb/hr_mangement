<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Employee List</title>
        <?php
        
        $this->load->view('includes/printcss');
        date_default_timezone_set('Asia/Dhaka');
        $servertime = time();
        $today_date = date("d-m-Y", $servertime);
        ?> 
        <script src="<?php echo base_url();?>plugins/export/tableToExcel.js">
        
        </script>
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
        <body onload="PrintDiv()" class="logged-in dashboard current-page print-attendance">
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
                $view_salary_in_emp_list = $this->users_model->userpermission("view_salary_in_emp_list", $user_type);
                $add_edit_profile = $this->users_model->userpermission("add_edit_profile", $user_type);
                
                // User wise permission ----------------------------------
                $view_employee_mobile_number = $this->users_model->getuserwisepermission("view_employee_mobile_number",$user_id);
                $view_employee_email_address = $this->users_model->getuserwisepermission("view_employee_email_address",$user_id);
                $view_employee_age = $this->users_model->getuserwisepermission("view_employee_age",$user_id);
                $view_employee_date_of_birth = $this->users_model->getuserwisepermission("view_employee_date_of_birth",$user_id);
                
                $searchpage = "contentwithpagination";
                $page_query = $this->search_field_emp_model->get_all_search_emp($searchpage);
   
                ?> 
                <a class=" pull-right " id="printButton" href="#" onclick="PrintDiv();"><span class="glyphicon glyphicon-print"></span> Print</a>
             
                <br/>
                  <div id="report">
            
                        <h1 style="font-size:25px;font-weight:bold">
                            <?php 
                      if($emp_division){
                       $empDivisionData = $this->taxonomy->getTaxonomyBytid($emp_division);
                       echo $empDivisionData['name']; 
                      }else{
                          echo "IIDFC";
                      }
                      ?>
                        </h1><br/>
              <span style="float:right">Downloaded Time: <?php echo $now; ?></span>
                      <hr/>
              
                <div class="row under-header-bar text-center"> 
                    <h2 style="font-weight:bold">
                        Employee List
                    </h2>         
                </div> 

                <div class="wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <style>
                                table, th, td {
                                    border: 1px solid #A9A9A9 ;
                                }
                            </style>
                            <table  class="display" cellspacing="0" width="100%" border="1" >
                                <thead>
                                    <tr class="heading">                               
                                        <th>Sl no.</th>
                                        <th>Emp. Code</th>
                                        <th>Name</th>
                                        <th>Grade</th>
                                         <?php if(!$emp_division){?>
                                         <th>Division Name</th> 
                                         <?php }?>
                                        <th>Department Name</th>
                                        <th>Position</th>
                                        <th>Type of Employee</th>
                                        <th>Joining Date</th>
                                        <?php if($view_employee_date_of_birth['status'] ==1){?>
                                        <th>Date of Birth</th>
                                        <?php }if($view_employee_age['status']==1){?>
                                        <th>Age</th>
                                        <?php }if ($view_salary_in_emp_list[0]['status'] == 1) { ?>                                     
                                            <th>Salary</th>
                                        <?php } ?>
                                        <th>Gender</th>
                                        <?php if($view_employee_mobile_number['status'] ==1){?>
                                        <th>Mobile No</th>
                                        <?php }?>
                                        <th>Distict</th>
                                      
                                    </tr>
                                </thead>
                                <tbody style="font-size:10px;">
                                    <?php 

                                    function ageDOB($y = 2014, $m = 12, $d = 31) { /* $y = year, $m = month, $d = day */
                                        date_default_timezone_set("Asia/Jakarta"); /* can change with others time zone */

                                        $ageY = date("Y") - intval($y);
                                        $ageM = date("n") - intval($m);
                                        $ageD = date("j") - intval($d);

                                        if ($ageD < 0) {
                                            $ageD = $ageD += date("t");
                                            $ageM--;
                                        }
                                        if ($ageM < 0) {
                                            $ageM += 12;
                                            $ageY--;
                                        }
                                        if ($ageY < 0) {
                                            $ageD = $ageM = $ageY = -1;
                                        }
                                        return array('y' => $ageY, 'm' => $ageM, 'd' => $ageD);
                                    }
         
                                    $sl_no=1;
                                        foreach ($page_query as $sigle_content) {
                                            $content_id = $sigle_content['content_id'];
                                            $emp_code = $sigle_content['emp_id'];
                                            $emp_name = $sigle_content['emp_name'];
                                            // $emp_grade = $sigle_content['grade'];
                                            // $emp_grade_data = $this->taxonomy->getTaxonomyBytid($emp_grade);
                                            $emp_division_id = $sigle_content['emp_division'];
                                            $emp_division_data = $this->taxonomy->getTaxonomyBytid($emp_division_id);
                                            $emp_department = $sigle_content['emp_department'];
                                            $emp_department_data = $this->taxonomy->getTaxonomyBytid($emp_department);
                                            $emp_post_id = $sigle_content['emp_post_id'];
                                            $emp_post_id_data = $this->taxonomy->getTaxonomyBytid($emp_post_id);
                                            $type_of_employee = $sigle_content['type_of_employee'];
                                            $type_of_employee_data = $this->taxonomy->getTaxonomyBytid($type_of_employee);
                                            $joining_date = $sigle_content['joining_date'];
                                            $gender = $sigle_content['gender'];
                                            $mobile_no = $sigle_content['mobile_no'];
                                            $distict = $sigle_content['distict'];
                                            $distict_data = $this->taxonomy->getTaxonomyBytid($distict);
                                            $salary_amount = $this->emp_salary_model->getsalary($content_id);
                                            $emp_gross_salary = $salary_amount['gross_salary'];
                                            ?>
                                            <tr>                                   
                                                <td><?php print $sl_no; ?></td>
                                                <td><?php print $emp_code; ?></td>
                                                <td><?php print $emp_name; ?></td>
                                                <td><?php print $sigle_content['grade_name']; ?></td>
                                                 <?php if(!$emp_division){?>
                                                <td><?php print $emp_division_data['keywords']; ?></td>
                                                 <?php }?>
                                                <td><?php print $emp_department_data['name']; ?></td>
                                                <td><?php print $emp_post_id_data['name']; ?></td>
                                                <td><?php print $type_of_employee_data['name']; ?></td>
                                                <td><?php print $joining_date; ?></td>
                                                <?php if($view_employee_date_of_birth['status'] ==1){?>
                                                <td><?php print $sigle_content['dob']; ?></td>
                                                 <?php }if($view_employee_age['status']==1){?>
                                                <td>
 
                                                    <?php
                                                    //  print $sigle_content['dob']."</br>";

                                                    $birthDate = $sigle_content['dob'];
                                                    //explode the date to get month, day and year
                                                    $birthDate = explode("-", $birthDate);
                                                    $age = ageDOB($birthDate[2], $birthDate[1], $birthDate[0]); /* with my local time is 2014-07-01 */
                                                    echo sprintf("%d years %d months %d days", $age['y'], $age['m'], $age['d']); /* output -> age = 29 year 1 month 24 day */
                                                    ?>


                                                </td>
                                                 <?php }if ($view_salary_in_emp_list[0]['status'] == 1) { ?> 
                                                    <td><?php print $emp_gross_salary; ?></td>
                                                 <?php } ?>
                                                <td><?php print $gender; ?></td>
                                                 <?php if($view_employee_mobile_number['status'] ==1){?>
                                                <td><?php print $mobile_no; ?></td>
                                                 <?php }?>
                                                <td><?php print $distict_data['name']; ?></td>
                                                
                                            </tr>
    <?php $sl_no++; }
 ?>
                                </tbody>
                            </table>  
                        </div>
                    </div>
                </div>
                <!-- /#page-content-wrapper -->
            </div>
            </div>
            <!-- /#wrapper -->        
    </body>
</html>
    <script>

        function PrintDiv() {
        var divToPrint = document.getElementById('report');
        var popupWin = window.open('', '_blank', 'width=1200,height=auto');
        popupWin.document.open();
        var a = '<div style="width="100%; margin:0 auto;display:block;">\n\
        <div style="float:left;width:43%;text-align:right;">\n\
    \n\
    </div>\n\
    <div class="" style="line-height:48px;text-align: left;font-size:25px;color:red;font-weight:bold;text-decoration:underline;"> \n\
    <span style="padding-left:8px;font-family:Verdana, Geneva, sans-serif"></span>' +
                '</div>\n\
    </div><br>';
        popupWin.document.write('<html><head><title>Employee List </title>\n\
    \n\
    \n\
    \n\
    \n\
    <style> body{ text-align:center;font-size:15px;margin:0 auto;}table{margin:0 auto;}table, th, td {padding-left:5px;padding-right:5px;font-size:10px;border-bottom: 1px solid black; border-collapse: collapse;}th{background: #DCDCDC; border-top:2px solid #000;} tr:nth-child(even) {background: #DCDCDC }tr:nth-child(odd) {background: #FFF}</style>\n\
                      \n\
    \n\
    \n\
    \n\
    \n\
    </head><body onload="window.print()">' + a + divToPrint.innerHTML + '</html>');
        popupWin.document.close();
        }
    </script>
       <?php exit; ?>
