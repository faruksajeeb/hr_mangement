<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Post A Circular</title>
    <?php
    $this->load->view('includes/cssjs');
    ?> 

    <script>
        $(document).ready(function(){
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
  var msg="<ul>";
  if ( document.myForm.emp_position.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.emp_position.focus();
    document.myForm.emp_position.style.border="solid 1px red";
    msg+="<li>You need to fill the emp_position field!</li>";
    valid = false;
    return false;
  }
  } 
  if ( document.myForm.Start_Date.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.Start_Date.focus();
    document.myForm.Start_Date.style.border="solid 1px red";
    msg+="<li>You need to fill the Start_Date field!</li>";
    valid = false;
    return false;
  }
  } 
   if ( document.myForm.Last_Date.value == "" ) {
    if (valid){ //only receive focus if its the first error
      document.myForm.Last_Date.focus();
    document.myForm.Last_Date.style.border="solid 1px red";
    msg+="<li>You need to fill the Last_Date field!</li>";
    valid = false;
    return false;
  }
  } 
  if (!valid){
    msg+="</ul>";
    //console.log("Hello Bd");
    var div = document.getElementById('errors').innerHTML=msg;
    document.getElementById("errors").style.display = 'block';
    return false;
  }
  
}        
    </script>    
</head>
<body class="logged-in dashboard current-page add-division">
    <!-- Page Content -->  
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php 
            $this -> load -> view('includes/menu');
            ?>
            <div class="row under-header-bar text-center"> 
                <h4>Post A Circular</h4>         
            </div> 
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo base_url(); ?>recruitment/post_circular" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                            <div class="row success-err-sms-area">
                                <div class="col-md-12">
                                    <input type="hidden" name="circular_id" id="circular_id" value="<?php print $id; ?>">
                                    <div id="errors"></div>
                                    <?php echo $error; ?>
                                    <?php echo $msg; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Position:</div>
                                        <div class="col-md-9">
                                            <select name="emp_position" id="emp_position">
                                                        <option value="">Select Position</option>
                                                        <?php foreach ($alljobtitle as $single_jobtitle) {
                                                            if($single_jobtitle['tid']==$toedit_records['position_id']){
                                                                echo '<option value="'.$single_jobtitle['tid'].'" selected="selected">'.$single_jobtitle['name'].'</option>';
                                                            }else{
                                                                echo '<option value="'.$single_jobtitle['tid'].'">'.$single_jobtitle['name'].'</option>';
                                                            }
                                                        } ?>
                                            </select>  
                                        </div>
                                    </div>                                       
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Start Date:</div>
                                        <div class="col-md-9">
                                            <input type="text" name="Start_Date" id="Start_Date" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if($toedit_records['Start_Date']){ print $toedit_records['Start_Date'] ; } ?>" />
                                        </div>
                                    </div>    
                                     <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Last Date:</div>
                                        <div class="col-md-9">
                                            <input type="text" name="Last_Date" id="Last_Date" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if($toedit_records['Last_Date']){ print $toedit_records['Last_Date'] ; } ?>" />
                                        </div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Short Description:</div>
                                        <div class="col-md-9">
                                            <textarea placeholder="Optional" name="short_description" id="short_description" cols="30" rows="10"><?php print $toedit_records['short_description']; ?></textarea>
                                        </div>
                                    </div>                                                                                 
                                    <div class="row">
                                        <div class="col-md-3 bgcolor_D8D8D8">Description:</div>
                                        <div class="col-md-9">
                                            <textarea placeholder="Optional" name="description" id="description" cols="30" rows="10"><?php print $toedit_records['description']; ?></textarea>
                                        </div>
                                    </div>            
                                    <div class="row top10 bottom10">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-9"><input type="submit" name="add_btn" value="Submit"></div>
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
        <!-- /#wrapper -->        
    </body>
    </html>