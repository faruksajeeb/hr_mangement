<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Post Circular</title>
        <?php
        $this->load->view('includes/cssjs');
        ?> 

        <script>
            $(document).ready(function () {
                // Setup - add a text input to each footer cell

            });
            function ConfirmDelete()
            {
                var x = confirm("Are you sure you want to delete?");
                if (x)
                    return true;
                else
                    return false;
            }
            function validate() {
                var valid = true;
                var msg = "<ul>";
                if (document.myForm.emp_division.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.myForm.emp_division.focus();
                        document.myForm.emp_division.style.border = "solid 1px red";
                        alert('Please select the division name !');
                        valid = false;
                        return false;
                    }
                }
                if (document.myForm.emp_department.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.myForm.emp_department.focus();
                        document.myForm.emp_department.style.border = "solid 1px red";
                        alert('Please the department name!');
                        valid = false;
                        return false;
                    }
                }
                if (document.myForm.emp_position.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.myForm.emp_position.focus();
                        document.myForm.emp_position.style.border = "solid 1px red";
                        alert('Please select the post name!');
                        valid = false;
                        return false;
                    }
                }
                
                if (document.myForm.Start_Date.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.myForm.Start_Date.focus();
                        document.myForm.Start_Date.style.border = "solid 1px red";
                        alert('Please select the Start_Date!');
                        valid = false;
                        return false;
                    }
                }
                if (document.myForm.Last_Date.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.myForm.Last_Date.focus();
                        document.myForm.Last_Date.style.border = "solid 1px red";
                        alert('Please select the Last Date!');
                        valid = false;
                        return false;
                    }
                }
                if (document.myForm.editor.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.myForm.editor.focus();
                        document.myForm.editor.style.border = "solid 1px red";
                        alert('Please sefecify the education!');
                        valid = false;
                        return false;
                    }
                }
                
                
                
                
                
                
//                if (!valid) {
//                    msg += "</ul>";
//                    //console.log("Hello Bd");
//                    var div = document.getElementById('errors').innerHTML = msg;
//                    document.getElementById("errors").style.display = 'block';
//                    return false;
//                }

            }




        </script>
        <style>
            .row{
                margin-bottom:2px;
            }
        </style>
        <script src="<?php echo base_url(); ?>plugins/ckeditor/ckeditor.js"></script>
        <script src="<?php echo base_url(); ?>plugins/ckeditor/samples/js/sample.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/ckeditor/samples/css/samples.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">

    </head>
    <body class="logged-in dashboard current-page add-division">
        <!-- Page Content -->  
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php
                $this->load->view('includes/menu');
                ?>
                <div class="row under-header-bar text-center"> 
                    <h4>Post A Circular</h4>         
                </div> 
                <div class="wrapper">
                    <div class="row">
                        <div class="col-md-12">
                        
                                <?php
                                $err = $this->session->userdata('error');
                                if ($err) {
                                    echo $err;
                                    $this->session->unset_userdata('error');
                                }                             
                                $msg = $this->session->userdata('message');
                                if ($msg) {
                                    echo $msg;
                                    $this->session->unset_userdata('message');
                                }
                                ?>
                        
                            <form action="<?php echo base_url(); ?>recruitment/save_circular" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                                <div class="row success-err-sms-area">
                                    <div class="col-md-12">
                                        <input type="hidden"  name="circular_id" id="circular_id" value="<?php print $id; ?>">
                                        <div id="errors"></div>
                                
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Division Name:</div>
                                            <div class="col-md-5">
                                                <select name="txt_division" id="emp_division">
                                                    <option value="">Select Division</option>
                                                    <?php foreach ($alldivisions as $single_division) { ?>
                                                        <option value="<?php echo $single_division->tid; ?>"><?php echo $single_division->name; ?></option>
                                                    <?php } ?>
                                                </select>  
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Department Name:</div>
                                            <div class="col-md-5">
                                                <select name="txt_department" id="emp_department">
                                                    <option value="">Select Department</option>
                                                    <?php foreach ($alldepartments as $single_department) { ?>
                                                        <option value="<?php echo $single_department->tid; ?>"><?php echo $single_department->name . '(' . $single_department->keywords . ')'; ?></option>
                                                    <?php } ?>
                                                </select>  
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Post Name:</div>
                                            <div class="col-md-5">
                                                <select name="txt_post" id="emp_position">
                                                    <option value="">Select Position</option>
                                                    <?php foreach ($allposts as $single_post) { ?>
                                                        <option value="<?php echo $single_post->tid; ?>"><?php echo $single_post->name; ?></option>
                                                    <?php } ?>
                                                </select>  
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Start Date:</div>
                                            <div class="col-md-5">
                                                <input type="text" name="txt_Start_Date" id="Start_Date" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="" />
                                            </div>
                                        </div>    
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Last Date:</div>
                                            <div class="col-md-5">
                                                <input type="text" name="txt_Last_Date" id="Last_Date" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Job Type:</div>
                                            <div class="col-md-5">
                                                <select name="txt_job_type" id="txt_job_type">
                                                    <option value="">Select Job Type</option>                                                        
                                                    <option value="full-time">Full Time</option>
                                                    <option value="part-time">Part Time</option>

                                                </select>  
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Job Location:</div>
                                            <div class="col-md-5">
                                                <input type="text" name="txt_job_location" value="" /> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Job Experience:</div>
                                            <div class="col-md-9">
                                               <!--  <input type="text" name="txt_job_experience" value="" /> -->
                                                <textarea id="editor4" name="txt_job_experience"></textarea>
                                                <script type="text/javascript">
                                                    CKEDITOR.replace('editor4');
                                                </script> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Education:</div>
                                            <div class="col-md-9">                                            
                                                <textarea id="editor" name="txt_education" placeholder="text here..">
                                                        
                                                </textarea>                                          
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Short Description:</div>
                                            <div class="col-md-9">
                                                <textarea placeholder="Optional" name="txt_short_description" id="short_description" cols="20" rows="3"></textarea>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Long Description:</div>
                                            <div class="col-md-9">                                            
                                                <textarea id="editor1" name="txt_long_description"></textarea>
                                                <script type="text/javascript">
                                                    CKEDITOR.replace('editor1');
                                                </script>                                          
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Job requirements : </div>
                                            <div class="col-md-9">                                            
                                                <textarea id="editor2" name="txt_job_requirments"></textarea>
                                                <script type="text/javascript">
                                                    CKEDITOR.replace('editor2');
                                                </script>                                          
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Salary :</div>
                                            <div class="col-md-5">
                                                <input type="text" name="txt_salary" value="" /> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Other benefits  : </div>
                                            <div class="col-md-9">                                            
                                                <textarea id="editor3" name="txt_other_benefit"></textarea>
                                                <script type="text/javascript">
                                                    CKEDITOR.replace('editor3');
                                                </script>                                          
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Vacancy:</div>
                                            <div class="col-md-5">
                                                <input type="text" name="txt_vacancy" value="" /> 
                                            </div>
                                        </div>
                       <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Job banner image :</div>
                                            <div class="col-md-7">
                                               <div id="filefield">
                                                               <?php if ($picture) { ?>
                                                                    <img src="<?php echo base_url(); ?>resources/uploads/<?php echo $picture; ?>" id="preview" width="" style="max-width: 143px;max-height: 150px;" />
                                                                <?php } else { ?>
                                                                    <img src="<?php echo base_url(); ?>resources/images/avater.png" id="preview" width="160px" height="160px" style=""/>
                                                                <?php } ?>
                                                                <div id="filediv"><input name="text_banner_image" type="file" id="file" style="width: inherit;" /></div>
                                                            </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3  bgcolor_D8D8D8"></div>
                                            <div class="col-md-5"><input type="submit" name="add_btn" value="Submit Job"></div>
                                        </div>
                                    </div>
                                   
                                </div>
                            </form>

                        </div>
                    </div>              
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <script>
            //initSample();
            CKEDITOR.replace('editor');
        </script>
        <!-- /#wrapper -->        
    </body>
</html>