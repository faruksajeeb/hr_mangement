<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Import Attendance Data</title>
    <?php
    $this->load->view('includes/cssjs');

    ?> 
    <script>
        $(document).ready(function () {
                $("#loader").hide();
                //$("#loader").show("fade","slow");
            });
            function validate() {
                var valid = true;

                var msg = "<ul>";
                if (document.import_form.userfile.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.import_form.userfile.focus();
                        document.import_form.userfile.style.border = "solid 1px red";
                        //document.myForm.loan_type_name.style.backgroundColor="#FFA07A";
                        msg += '<li >You need to select the file field! <span class="glyphicon glyphicon-remove-circle"></li>';
                        valid = false;
                        // return false;
                    }
                }
                
               
                if (!valid) {
                    //alert(0);
                    msg += "</ul>";
                    //console.log("Hello Bd");

                    var div = document.getElementById('errors').innerHTML = msg;
                    document.getElementById("errors").style.display = 'block';
                    //Hide();
                    return false;
                }else{
			 $("#loader").show("fade","slow");
                        }

            }
    </script>
</head>
<body>
    <div class="container-fluid">
        <?php 
        $this -> load -> view('includes/menu');
        ?>
            <div class="row under-header-bar text-center"> 
                <h4>Import Attendance Data</h4>         
            </div> 

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('success') == TRUE): ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        <br><br><br><br>
        <div class="row">   
            <div class="col-md-4">  </div>
            <div class="col-md-4">
            <div class="alert alert-success note">
              <strong>Note:</strong> To import data just download data to a usb and upload to online. Hanvon Device will import only last month data. Other devices will import last 40 days data.
            </div>
            <br> 
            <div id="errors" style='color:red;text-align:right'></div>
            <form name="import_form" method="post" onsubmit=" return validate();" action="<?php echo base_url() ?>importdata/importbatdata" enctype="multipart/form-data">
                If need add digit before ID <input type="text" id="add_digit" name="add_digit">Example Add 9 for MTI Device. Because MTI Device dont support 6 length ID<br><br> 
                    <input type="file" name="userfile" ><br><br>
                    <input type="submit" name="submit" value="UPLOAD" class="btn btn-primary">
                </form>
            </div>
            <div class="col-md-4"> 
            <div id="loader" style="text-align:center; display:none;">
                <div style="padding: 5px;">Please be patient, Attendance imported is being Processed.</div>
                <img src="<?php echo base_url()?>resources/images/prosseging.gif" style="width: 100px;"  alt="Processing..."/>
                 <!-- Start Report -->
            </div>
            </div>
        </div>
    </div>
</body>
</html>