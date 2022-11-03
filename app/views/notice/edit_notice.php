<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Notice</title>
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
                    <h4>Edit Notice</h4>         
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
                        
                            <form action="<?php echo base_url(); ?>notice/edit_notice" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                                <div class="row success-err-sms-area">
                                    <div class="col-md-12">
                                        <input type="hidden"  name="notice_id" id="notice_id" value="<?php echo $display_notice_detail_by_id->NoticeID; ?>">
                                        <div id="errors"></div>
                                
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-9">
                                      
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Notice Name:</div>
                                            <div class="col-md-5">
                                                <input type="text" name="txt_notice_name" value="<?php echo $display_notice_detail_by_id->NoticeName; ?>" /> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Published On:</div>
                                            <div class="col-md-5">
                                                <input type="text" name="txt_published_on" id="Start_Date" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php echo $display_notice_detail_by_id->PublishedOn; ?>" />
                                            </div>
                                        </div>  
                                      
                         
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Short Description:</div>
                                            <div class="col-md-9">
                                                <textarea placeholder="Optional" name="txt_short_description" id="short_description" cols="20" rows="3">
                                                    <?php echo $display_notice_detail_by_id->ShortDescription; ?>
                                                </textarea>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Long Description:</div>
                                            <div class="col-md-9">                                            
                                                <textarea id="editor1" name="txt_long_description">
                                                    <?php echo $display_notice_detail_by_id->LongDescription; ?>
                                                </textarea>
                                                <script type="text/javascript">
                                                    CKEDITOR.replace('editor1');
                                                </script>                                          
                                            </div>
                                        </div>
                                       
                                      
                                            <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Notice File :</div>
                                            <div class="col-md-7">
                                               <div id="filefield">
                                                           
                                                                <div id="filediv"><input value=" <?php echo $display_notice_detail_by_id->NoticeFie; ?>" name="text_notice_file" type="file" id="file" style="width: inherit;" /></div>
                                                            </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3  bgcolor_D8D8D8"></div>
                                            <div class="col-md-5"><input type="submit" name="edit_btn" value="Submit Job"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-2"></div>
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
              