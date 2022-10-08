<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HRMS || Attendance Informed</title>
        <?php
        $this->load->view('includes/cssjs');
        date_default_timezone_set('Asia/Dhaka');
        $servertime = time();
        $today_date = date("d-m-Y", $servertime);
        ?> 
        <script>
            $(document).ready(function () {
                $("#entry_division_wise").click(function () {
                    $('#entry_emp_wise').prop('checked', false);
                    $('.division_wise_area').css({"display": "block"});
                    $('.emp_wise_area').css({"display": "none"});

                });
                $("#entry_emp_wise").click(function () {
                    $('#entry_division_wise').prop('checked', false);
                    $('.division_wise_area').css({"display": "none"});
                    $('.emp_wise_area').css({"display": "block"});

                });

                $("#emp_company").change(function (e) {
                    $("input[type=submit]").removeAttr("disabled");
                    var division_tid = $(this).val();
                    var base_url = '<?php echo base_url(); ?>';
                    var postData = {
                        "division_tid": division_tid
                    };
                    $.ajax({
                        type: "POST",
                        url: "" + base_url + "addprofile/getdepartmentidbydivisionid",
                        data: postData,
                        dataType: 'json',
                        success: function (data) {
                            // console.log(data);
                            var options = "";
                            options += '<option value="">All</option>';
                            $(data).each(function (index, item) {
                                options += '<option value="' + item.tid + '">' + item.name + '</option>';
                            });
                            $('#emp_division').html(options);
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "" + base_url + "reports/getempbydivisionid",
                        data: postData,
                        dataType: 'json',
                        success: function (data) {
                            var options = "";
                            var val = "--Select employee--";
                            options += '<option value="">' + val + '</option>';
                            $(data).each(function (index, item) {

                                options += '<option value="' + item.emp_id + '">' + item.emp_name + '-' + item.emp_id + '</option>';
                            });
                            $('#emp_name').html(options);
                        }
                    });
                });

                $("#emp_division").change(function (e) {
                    var company_tid = $("#emp_company").val();
                    var division_tid = $(this).val();
                    var base_url = '<?php echo base_url(); ?>';
                    var postData = {
                        "division_tid": division_tid,
                        "company_tid": company_tid
                    };
                    //alert(division_tid);
                    $.ajax({
                        type: "POST",
                        url: "" + base_url + "reports/getEmployeeByDivisionId",
                        data: postData,
                        dataType: 'json',
                        success: function (data) {
                            var options = "";
                            var val = "--Select employee--";
                            options += '<option value="">' + val + '</option>';
                            $(data).each(function (index, item) {

                                options += '<option value="' + item.emp_id + '">' + item.emp_name + '-' + item.emp_id + '</option>';
                            });
                            $('#emp_name').html(options);
                        }
                    });
                });














                // Setup - add a text input to each footer cell    

                jQuery.validator.setDefaults({
                    debug: true,
                    success: "valid"
                });
                $("#myForm").validate({
                    rules: {
                        //emp_division: "required",
                        //emp_name: "required",
                        //emp_id: "required",
                        emp_attendance_end_date: "required",
                        emp_attendance_start_date: {required: true, mydate: true},
                    },
                    submitHandler: function (form) {
                        // do other things for a valid form
//                        var emp_name = $("#emp_name").val();
//                        if (emp_name == '') {
//                            var x = confirm("Are you sure you want to effected this action on all employees of this division?");
//                            if (x) {
//                                // return true;
//                            } else {
//                                return false;
//                            }
//                        }
                        var empEntryType = document.getElementById('entry_emp_wise');
                        var divisionEntryType = document.getElementById('entry_division_wise');
                        if (empEntryType.checked == true) {
                            if (document.myForm.emp_name.value == "") {
                                if (valid) { //only receive focus if its the first error
                                    document.myForm.emp_name.focus();
                                    document.myForm.emp_name.style.border = "solid 1px red";
                                    msg += "<li>You need to fill the emp_name field!</li>";
                                    valid = false;
                                    return false;
                                }
                            }
                            if (document.myForm.emp_id.value == "") {
                                if (valid) { //only receive focus if its the first error
                                    document.myForm.emp_id.focus();
                                    document.myForm.emp_id.style.border = "solid 1px red";
                                    msg += "<li>You need to fill the emp_id field!</li>";
                                    valid = false;
                                    return false;
                                }
                            }
                        } else if (divisionEntryType.checked == true) {
                            if (document.myForm.emp_company.value == "") {
                                if (valid) { //only receive focus if its the first error
                                    document.myForm.emp_company.focus();
                                    document.myForm.emp_company.style.border = "solid 1px red";
                                    msg += "<li>You need to select the division field!</li>";
                                    valid = false;
                                    return false;
                                }
                            }else{
                                var x = confirm("Are you sure you want to effected this action on all employees of this division?");
                                if (x) {
                                    // return true;
                                } else {
                                    return false;
                                }
                            }
                        }
                        var earraydate = $("#emp_attendance_start_date").val();
                        var earraydate = earraydate.split('-');
                        var eday = earraydate[0];
                        var emonth = earraydate[1];
                        var eyear = earraydate[2];
                        var enddate = eyear + "/" + emonth + "/" + eday;
                        var startdate = $("#emp_attendance_end_date").val();
                        var sarraydate = startdate.split('-');
                        var sday = sarraydate[0];
                        var smonth = sarraydate[1];
                        var syear = sarraydate[2];
                        var stadate = syear + "/" + smonth + "/" + sday;
                        if (new Date(stadate) >= new Date(enddate)) {
                            form.submit();
                        } else {
                            $("#emp_attendance_end_date").css({"border": "1px solid red"});
                        }
                    }
                });
                $.validator.addMethod('time', function (value, element, param) {
                    return /^([01]?[0-9]|2[0-3])(:[0-5][0-9]){2}$/.test(value);
                }, 'Enter a valid time: hh:mm:ss');

                $.validator.addMethod("mydate", function (value, element) {
                    return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
                },
                        "Please enter a date in the format dd-mm-yyyy"
                        );
                $('#emp_name').change(function () {
                    var emp_id = $("#emp_name").val();
                    $('#emp_id').val(emp_id);
                });

                $('#emp_id').keyup(function () {
                    var emp_id = $("#emp_id").val();
                    $('#emp_name').val(emp_id);
                });

                $("#emp_attendance_date").datepicker({
                }).on('changeDate', function (ev) {
                });

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
                var empEntryType = document.getElementById('entry_emp_wise');
                 var divisionEntryType = document.getElementById('entry_division_wise');
                if (empEntryType.checked == true) {
                    if (document.myForm.emp_name.value == "") {
                        if (valid) { //only receive focus if its the first error
                            document.myForm.emp_name.focus();
                            document.myForm.emp_name.style.border = "solid 1px red";
                            msg += "<li>You need to fill the emp_name field!</li>";
                            valid = false;
                            return false;
                        }
                    }
                }else if (divisionEntryType.checked == true) {
                            if (document.myForm.emp_company.value == "") {
                                if (valid) { //only receive focus if its the first error
                                    document.myForm.emp_company.focus();
                                    document.myForm.emp_company.style.border = "solid 1px red";
                                    msg += "<li>You need to select the division field!</li>";
                                    valid = false;
                                    return false;
                                }
                            }
                        }



                if (document.myForm.emp_attendance_start_date.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.myForm.emp_attendance_start_date.focus();
                        document.myForm.emp_attendance_start_date.style.border = "solid 1px red";
                        msg += "<li>You need to fill the emp_attendance_start_date field!</li>";
                        valid = false;
                        return false;
                    }
                }
                if (document.myForm.emp_attendance_end_date.value == "") {
                    if (valid) { //only receive focus if its the first error
                        document.myForm.emp_attendance_end_date.focus();
                        document.myForm.emp_attendance_end_date.style.border = "solid 1px red";
                        msg += "<li>You need to fill the emp_attendance_end_date field!</li>";
                        valid = false;
                        return false;
                    }
                }
                var startdate = document.myForm.emp_attendance_start_date.value;
                var enddate = document.myForm.emp_attendance_end_date.value;
                var startdate_components = startdate.split("-");
                var enddate_components = enddate.split("-");
                var d1 = Date.parse(startdate_components[2] + "-" + startdate_components[1] + "-" + startdate_components[0]);
                var d2 = Date.parse(enddate_components[2] + "-" + enddate_components[1] + "-" + enddate_components[0]);
                if (d2 < d1) {
                    if (valid) { //only receive focus if its the first error
                        document.myForm.emp_attendance_end_date.focus();
                        document.myForm.emp_attendance_end_date.style.border = "solid 1px red";
                        msg += "<li>You need to fill the emp_attendance_end_date field!</li>";
                        valid = false;
                        return false;
                    }
                }
                if (!valid) {
                    msg += "</ul>";
                    //console.log("Hello Bd");
                    var div = document.getElementById('errors').innerHTML = msg;
                    document.getElementById("errors").style.display = 'block';
                    return false;
                }

            }
        </script>    
    </head>
    <body class="logged-in dashboard current-page add-attendance">
        <!-- Page Content -->  
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <?php
                $this->load->view('includes/menu');
                ?>
                <div class="row under-header-bar text-center"> 
                    <h4>Add Informed Attendance</h4>         
                </div> 
                <div class="wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="<?php echo base_url(); ?>empattendance/attendanceinformed" method="post" onSubmit="return validate();" class="myForm" id="myForm"  name="myForm" enctype="multipart/form-data">
                                <div class="row success-err-sms-area">
                                    <div class="col-md-12">
                                        <input type="hidden" name="attendance_id" id="attendance_id" value="<?php print $id; ?>">
                                        <div id="errors"></div>
                                        <?php
                                        print $this->session->flashdata('errors');
                                        print $this->session->flashdata('success');
                                        print $this->session->userdata('success');
                                        $this->session->set_userdata("success", "");
//           echo '<pre>';                                                                        
//  print_r($allemployee);
//   echo '</pre>'; 
//                                                exit();   
                                        ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-3 bgcolor_D8D8D8">Select Entry Type</div>
                                    <div class="col-md-7">
                                        <input type="radio" value="entry_emp_wise" id="entry_emp_wise" name="entry_emp_wise" checked="checked"> Employee Wise
                                        <input type="radio" value="entry_division_wise" id="entry_division_wise" name="entry_division_wise" > Division Wise
                                    </div>   
                                </div> 
                                <div class="row"> 
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">

                                        <?php if ($this->session->userdata('user_type') == '1') { ?>
                                            <div class="row division_wise_area" style="display:none;">
                                                <div class="row">
                                                    <div class="col-md-3 bgcolor_D8D8D8">Company : </div>
                                                    <div class="col-md-9">
                                                        <select name="emp_company" id="emp_company">
                                                            <option value="">--Select Company--</option>
                                                            <?php
                                                            foreach ($alldivision AS $single_division) {
                                                                echo '<option value="' . $single_division['tid'] . '" data-id="' . $single_division['weight'] . '">' . $single_division['name'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3  bgcolor_D8D8D8 label">Division/ Branch : </div>
                                                    <div class="col-md-9">
                                                        <select name="emp_division" id="emp_division"  class="">
                                                            <option value="">Select company first</option>
                                                            <?php
                                                            foreach ($department_selected as $single_department) {
                                                                if ($emp_department == $single_department['tid']) {
                                                                    echo '<option value="' . $single_department['tid'] . '" selected="selected">' . $single_department['name'] . '</option>';
                                                                } else {
                                                                    echo '<option value="' . $single_department['tid'] . '">' . $single_department['name'] . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>                       
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="emp_wise_area">
                                            <div class="row ">
                                                <div class="col-md-3 bgcolor_D8D8D8">Name</div>
                                                <div class="col-md-9">
                                                    <select name="emp_name" id="emp_name">
                                                        <option value="">--Select Employee--</option>

                                                        <?php
                                                        foreach ($allemployee as $single_employee) {
                                                            $default_emp_id = $default_emp['emp_id'];
                                                            $content_id = $single_employee['content_id'];
                                                            $emp_id = $single_employee['emp_id'];
                                                            $emp_name = $single_employee['emp_name'];
                                                            if ($default_emp_id == $emp_id) {
                                                                print '<option value="' . $emp_id . '" selected="selected">' . $emp_name . '-' . $emp_id . '</option>';
                                                            } else {
                                                                print '<option value="' . $emp_id . '">' . $emp_name . '-' . $emp_id . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>                                
                                            <div class="row">
                                                <div class="col-md-3 bgcolor_D8D8D8">Employee Code</div>
                                                <div class="col-md-9"><input type="text" name="emp_id" id="emp_id" placeholder="Write Emp id or select Emp Name" autocomplete="off" value="<?php
                                                        if ($default_emp['emp_id']) {
                                                            echo $default_emp['emp_id'];
                                                        }
                                                        ?>"/></div>
                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Start Date:</div>
                                            <div class="col-md-9"><input type="text" name="emp_attendance_start_date" class="datepicker numbersOnly" id="emp_attendance_start_date" value="<?php
                                                    if ($emp_attendance_date) {
                                                        print $emp_attendance_date;
                                                    } else {
                                                        print $today_date;
                                                    }
                                                        ?>" placeholder="dd-mm-yyyy"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">End Date:</div>
                                            <div class="col-md-9"><input type="text" name="emp_attendance_end_date" class="datepicker numbersOnly" id="emp_attendance_end_date" value="<?php
                                                if ($emp_attendance_date) {
                                                    print $emp_attendance_date;
                                                } else {
                                                    print $today_date;
                                                }
                                                        ?>" placeholder="dd-mm-yyyy"></div>
                                        </div>                                        
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Login Status:</div>
                                            <div class="col-md-9">
                                                <select name="presence_status" id="presence_status">
                                                    <option value="P">Present</option>
                                                    <option value="L">Late</option>
                                                    <option value="A">Absent</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Logout Status:</div>
                                            <div class="col-md-9">
                                                <select name="logout_status" id="login_status">
                                                    <option value="P">Present</option>
                                                    <option value="E">Early</option>                                           
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Reason:</div>
                                            <div class="col-md-9">                                       
                                                <select name="reason" id="reason" >
                                                    <option value="official">Official</option> 
                                                    <option value="personal">Personal</option> 
                                                    <option value="technical_problem">Technical Problem</option> 
                                                    <option value="electricity_problem">Electricity Problem</option> 
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Description:</div>
                                            <div class="col-md-9">
                                                <textarea  name="remarks" id="remarks" cols="30" rows="3"></textarea>

                                            </div>
                                        </div>   
                                        <!--                                     <div class="row">
                                                                                <div class="col-md-3 bgcolor_D8D8D8">Login Time:</div>
                                                                                <div class="col-md-9"><input type="text" name="emp_login_time" id="emp_login_time" value="<?php
                                                if ($emp_login_time) {
                                                    print $emp_login_time;
                                                } else {
                                                    print '09:30:00';
                                                }
                                                        ?>" placeholder="hh:mm:ss 24 hours format"></div>
                                                                            </div> 
                                                                            <div class="row">
                                                                                <div class="col-md-3 bgcolor_D8D8D8">Logout Time:</div>
                                                                                <div class="col-md-9"><input type="text" name="emp_logout_time" id="emp_logout_time" value="<?php
                                        if ($emp_logout_time) {
                                            print $emp_logout_time;
                                        } else {
                                            print '17:30:00';
                                        }
                                                        ?>" placeholder="hh:mm:ss 24 hours format"></div>
                                                                            </div>   -->                                                                                                                    
                                        <div class="row top10 bottom10">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-9"><input type="submit" name="add_attendance_btn" value="Submit"></div>
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