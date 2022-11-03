
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS- Payslip Generator</title>
        <!--chosen--> 
        <?php
        $this->load->view('includes/cssjs');
        ?> 
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.form.min.js"></script>
     
 <script>
            $(document).ready(function () {
               
             
                $( "#emp_division" ).change(function(e) {
                        $("input[type=submit]").removeAttr("disabled");
                          var division_tid = $(this).val(); 
                          var base_url='<?php echo base_url();?>';
                          var postData = {
                              "division_tid" : division_tid
                          };
                          $.ajax({
                              type: "POST",
                              url: ""+base_url+"addprofile/getdepartmentidbydivisionid",
                              data: postData,
                              dataType:'json',
                              success: function(data){
                          // console.log(data);
                          var options="";
                          options += '<option value="">All</option>';
                          $(data).each(function(index, item) {
                              options += '<option value="' + item.tid + '">' + item.name + '</option>'; 
                          });
                          $('#emp_department').html(options);    
                      }
                      });
                  });
                setTimeout(function(){ 
                   // $("#errors").hide("slide", {direction: "up" }, "slow"); 
                    $(".alert").hide("slide", {direction: "up" }, "slow");
                   
                }, 5000);
            });

            function validate() {
                var valid = true;

                var msg = "<ul>";
                if (document.payslipForm.emp_division.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.payslipForm.emp_division.focus();
                        document.payslipForm.emp_division.style.border = "solid 1px red";
                        //document.myForm.loan_type_name.style.backgroundColor="#FFA07A";
                        msg += '<li >You need to select the division field! <span class="glyphicon glyphicon-remove-circle"></li>';
                        valid = false;
                        // return false;
                    }
                }
                if ( document.payslipForm.salary_month.value == "" ) {
                        if (valid){
                            document.payslipForm.salary_month.focus();
                        }
                        document.payslipForm.salary_month.style.border="solid 1px red";
                        msg+='<li >You need to select salary month field! <span class="glyphicon glyphicon-remove-circle"></li>';         
                        valid = false;       
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
			
                        }

            }



        </script>
        <style>
            .add-form{
                min-height:200px;
            }
            select{
                margin: 0;
            }
            .col-md-4{
                //text-align: right;
            }
            a:hover{
                cursor: pointer;
            }
            .dialogWithDropShadow
                {
                    -webkit-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);  
                    -moz-box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5); 
                    
                }
                .ui-dialog{
                  //  background-color: #ffcc99;
                }


        </style>
    </head>
    <body class="logged-in dashboard current-page add-division">
        <!-- Page Content -->  
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php
                $this->load->view('includes/menu');
                ?>

                <div class="wrapper">

                    <br/>
                    <div class="row">
                        <div class="col-md-3 col-xs-12 "></div>
                        <div class="col-md-6 col-xs-12 add-form">
                            <div class="row add-form-heading">
                                <div class="col-md-12 ">

                                    <i class="fas fa-money-check-alt " style="font-size:20px"></i> Payslip Generator</div>
                            </div>
                            <form action="" onsubmit=" return validate();" method="POST"  class="payslipForm" id="payslipForm"  name="payslipForm" enctype="multipart/form-data">
                                <div class="row success-err-sms-area">
                                    <div class="col-md-12">
                                             <?php 
                                    $msg=$this->session->flashdata('success');
                                    if($msg){
                                        ?>
                                    <br/>
                                    <div class="alert alert-success text-center">
                                        <strong>Success!</strong> <?php echo $msg?>
                                      </div>                                    
                                    <?php
                                    }                                    
                                    $msg=null;
                                    ?>
                                    <?php 
                                    $error=$this->session->flashdata('error');
                                    if($error){
                                        ?>
                                    <br/>
                                    <div class="alert alert-success text-left">
                                        <strong>ERROR!</strong> <?php echo $error?>
                                      </div>                                    
                                    <?php
                                    }                                    
                                    $error=null;
                                    ?>
                                    </div>
                                </div>
                                <div class="row"> 
 

                                    <div class="row">

                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            
                                            <div class="row">                                    
                                                <div class="col-md-12 col-xs-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-4">Generated Date:</div>
                                                        <div class="col-md-8">
                                                            <?php
                                                                $dt = new DateTime("now", new DateTimeZone('Asia/Dhaka'));
                                                                $current_date = $dt->format('d-m-Y');                                               
                                                            ?>
                                                            <input type="text" class='datepicker' name="generated_date" id="generated_date" value="<?php echo $current_date; ?>"  />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">                                    
                                                <div class="col-md-12 col-xs-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-4">Account:</div>
                                                        <div class="col-md-8">
                                                            <select name="account_id" id="account_id">
                                                                <option value="1">COCL</option>
                                                                <!--<option value="cheque">Cheque</option>-->
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">                                    
                                                <div class="col-md-12 col-xs-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-4">Division:</div>
                                                        <div class="col-md-8">
                                                            <select name="emp_division" id="emp_division" class="">
                                                                <option value=""> --select division--</option>
                                                                <?php 
                                                                 
                                                                  foreach ($alldivision as $single_division) {
                                                                  
                                                                      echo '<option value="'.$single_division['tid'].'" data-id="'.$single_division['weight'].'">'.$single_division['name'].'</option>';
                                                                   
                                                                  } 
                                                                    
                                                                ?> 
                                                          </select> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">                                    
                                                <div class="col-md-12 col-xs-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-4">Department:</div>
                                                        <div class="col-md-8">
                                                            <select name="emp_department" id="emp_department"  class="">
                                                                <option value="">All</option>
                                                                <?php 

                                                                foreach ($department_selected as $single_department) {
                                                                  if($emp_department==$single_department['tid']){
                                                                    echo '<option value="'.$single_department['tid'].'" selected="selected">'.$single_department['name'].'</option>';
                                                                }else{
                                                                    echo '<option value="'.$single_department['tid'].'">'.$single_department['name'].'</option>';
                                                                  }
                                                                } 
                                                                ?>
                                                              </select> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="row">                                    
                                                <div class="col-md-12 col-xs-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-4">Financial Year:</div>
                                                        <div class="col-md-8">
                                                            <select name="year" id="year">
                                                                <option value="2019">2019</option>
                                                                <option value="2020">2020</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">                                    
                                                <div class="col-md-12 col-xs-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-4">Salary month:</div>
                                                        <div class="col-md-8">
                                                            <select name="salary_month" id="salary_month">
                                                                <option value=""> --select employee salary month-- </option>
                                                                <option value="01">January</option>
                                                                <option value="02">February</option>
                                                                <option value="03">March</option>
                                                                <option value="04">April</option>
                                                                <option value="05">May</option>
                                                                <option value="06">June</option>
                                                                <option value="07">July</option>
                                                                <option value="08">August</option>
                                                                <option value="09">September</option>
                                                                <option value="10">October</option>
                                                                <option value="11">November</option>
                                                                <option value="12">December</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">                                    
                                                <div class="col-md-12 col-xs-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="col-md-4"></div>
                                                        <div class="col-md-8">
                                                            <!-- <input type="checkbox" name="festival_bonus" id="fastival_bonus" value="true" /> With festival bonus -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            
                                            
                                        </div>
                                    </div>
                                    
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-8">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-12">
                                            <div class="row">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-8">
                                                    <input type="submit" name="add_btn" id="add_btn" style="width:100%;" value="Generate" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </form>

                        </div>

                        <div class="col-md-3 col-xs-12 "></div>

                    </div>
                    
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->    
        <!--Chosen--> 
        <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/docsupport/init.js" type="text/javascript" charset="utf-8"></script>

    </body>
</html>