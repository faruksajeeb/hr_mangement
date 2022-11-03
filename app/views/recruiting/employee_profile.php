<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS- Employee Profile</title>
    <?php
    $this->load->view('includes/cssjs');
    // User wise permission ----------------------------------
    $user_id = $this->session->userdata('user_id');
    $user_type = $this->session->userdata('user_type');
    $view_employee_mobile_number = $this->users_model->getuserwisepermission("view_employee_mobile_number", $user_id);
    $view_employee_email_address = $this->users_model->getuserwisepermission("view_employee_email_address", $user_id);
    $view_employee_age = $this->users_model->getuserwisepermission("view_employee_age", $user_id);
    $view_employee_date_of_birth = $this->users_model->getuserwisepermission("view_employee_date_of_birth", $user_id);
    ?>
    <script>
        function getAge(birthDate) {
            var now = new Date();

            function isLeap(year) {
                return year % 4 == 0 && (year % 100 != 0 || year % 400 == 0);
            }

            // days since the birthdate    
            var days = Math.floor((now.getTime() - birthDate.getTime()) / 1000 / 60 / 60 / 24);
            var age = 0;
            // iterate the years
            for (var y = birthDate.getFullYear(); y <= now.getFullYear(); y++) {
                var daysInYear = isLeap(y) ? 366 : 365;
                if (days >= daysInYear) {
                    days -= daysInYear;
                    age++;
                    // increment the age only if there are available enough days for the year.
                }
            }
            return age;
        }
        $(document).ready(function() {
            $("#leave_category_system").click(function() {
                if ($(this).is(':checked')) {
                    $('#leave_total_system').prop('checked', false);
                    $('.category_leave_area').css({
                        "display": "block"
                    });
                    $('.total_leave_area').css({
                        "display": "none"
                    });
                } else {
                    $('#leave_total_system').prop('checked', true);
                    $('.total_leave_area').css({
                        "display": "block"
                    });
                    $('.category_leave_area').css({
                        "display": "none"
                    });
                }
            });
            /*disable non active tabs*/
            // $('ul.tabs li').not('.activetab').addClass('disabled');

            $('ul.tabs li').click(function(e) {
                /*enable next tab*/
                // var emp_name=$("#emp_name").val();
                //alert(emp_name);
                //     if ($(this).hasClass('disabled')) {
                //     	// alert(emp_name);
                //         e.preventDefault();
                // return false;
                //     }
                //      if(emp_name){

                //  	}else{
                //  		alert(emp_name);
                //  		 $(this).removeClass('activetab');
                //      	//$('ul.tabs li.activetab').removeClass('activetab');
                //      	$('ul.tabs li').not('#Tab_1').addClass('nonactivetab');
                // $('li[id="Tab_1"]').addClass("activetab");
                //  	}
            });


            var base_url = '<?php echo base_url(); ?>';
            $.ajax({
                type: "POST",
                url: "" + base_url + "addprofile/getactivetab",
                dataType: 'json',
                success: function(data) {
                    if (data) {
                        if (data != 'Tab_1') {
                            $('li[id="Tab_1"]').removeClass("activetab");
                            $('li[id="Tab_1"]').addClass("nonactivetab");
                            $('div[id="content_1"]').css({
                                "display": "none"
                            });
                        } else {
                            $('ul.tabs li').not('.activetab').addClass('disabled');
                        }
                        var tab_id = data.replace("Tab_", "");
                        $('li[id="' + data + '"]').addClass("activetab");
                        $('div[id="content_' + tab_id + '"]').css({
                            "display": "block"
                        });
                    }
                }
            });

            $("ul.tabs li").click(function() {
                var activeid = $(this).attr("id");
                var base_url = '<?php echo base_url(); ?>';
                var postData = {
                    "activeid": activeid
                };
                $.ajax({
                    type: "POST",
                    url: "" + base_url + "addprofile/getactivetab",
                    data: postData,
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);

                    }
                });
            });
            jQuery.validator.setDefaults({
                debug: true,
                success: "valid"
            });


            $.validator.addMethod('time', function(value, element, param) {
                return /^([01]?[0-9]|2[0-3])(:[0-5][0-9]){2}$/.test(value);
            }, 'Enter a valid time: hh:mm:ss');

            $.validator.addMethod("mydate", function(value, element) {
                    return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
                },
                "Please enter a date in the format dd-mm-yyyy"
            );

            function showActive() {
                var activeId = $(".activetab").attr("id");
                var splitid = activeId.split("_");
                var contentid = "content_" + splitid[1];
                $(".tabcontent").hide();
                $("#" + contentid).show();
            }

            $("ul.tabs li").click(function() {
                $("ul.tabs li").removeClass("activetab");
                $("ul.tabs li").addClass("nonactivetab");
                $(this).addClass("activetab");
                showActive();
            });

            showActive();

            $('#emp_dob').blur(function() {
                // $(this).datepicker('hide');
                var datevalue = $('#emp_dob').val();
                var dateParts = datevalue.split("-");
                var date = new Date(dateParts[2], (dateParts[1] - 1), dateParts[0]);
                //console.log(datevalue);
                var final_age = getAge(date);
                if (final_age != 0) {
                    $("#emp_age").val(final_age);
                }

            });

            $('body').on('keydown', '.datepicker', function(e) {
                if (e.which == 9) {
                    $(this).datepicker('hide');
                    // do your code
                }
            });
            // prevent enter key to prevent form submitting 
            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    $(this).next().focus();
                    event.preventDefault();
                    return false;
                }
            });
            $('#myForm').find('input').keypress(function(e) {
                if (e.which == 13) // Enter key = keycode 13
                {
                    //e.preventDefault();
                    //alert("est");
                    //var a=$(this).attr('name');
                    //alert(a);
                    //$('#'+a).next('input').focus();
                    //   	var inputs = $(this).closest('form').find(':input');
                    // inputs.eq( inputs.index(this)+ 1 ).focus();
                    //Use whatever selector necessary to focus the 'next' input
                    //return false;
                }
            });

            $(document).on("keydown", function(event) {
                if (event.which == 77 && event.ctrlKey) {
                    $("#emp_id").focus(); //ctrl+M
                }
                if (event.which == 81 && event.ctrlKey) {
                    $("#myForm").submit(); // ctrl+Q
                }

            });



            // document.ready end
        });
    </script>
    <?php

    // provision variable
    if ($provision['provision_date_from']) {
        $emp_provision_starting_date = $provision['provision_date_from'];
    }
    if ($provision['provision_date_to']) {
        $emp_provision_ending_date = $provision['provision_date_to'];
    }
    if ($working_time['work_starting_time']) {
        $emp_working_time_from = $working_time['work_starting_time'];
    }
    if ($working_time['work_ending_time']) {
        $emp_working_end_time = $working_time['work_ending_time'];
    }
    if ($working_time['attendance_required']) {
        $attendance_required = $working_time['attendance_required'];
    }
    if ($working_time['emp_latecount_time']) {
        $emp_latecount_time = $working_time['emp_latecount_time'];
    }
    if ($working_time['emp_earlycount_time']) {
        $emp_earlycount_time = $working_time['emp_earlycount_time'];
    }

    if ($working_time['logout_required']) {
        $logout_required = $working_time['logout_required'];
    }
    if ($working_time['half_day_absent']) {
        $half_day_absent = $working_time['half_day_absent'];
    }
    if ($working_time['absent_count_time']) {
        $absent_count_time = $working_time['absent_count_time'];
    }
    if ($working_time['overtime_count']) {
        $overtime_count = $working_time['overtime_count'];
    }
    if ($working_time['overtime_hourly_rate']) {
        $overtime_hourly_rate = $working_time['overtime_hourly_rate'];
    }

    // Payroll --------------------------------------------------------------------------Payroll PHP ---------------------------

    if ($salary_amount['gross_salary']) {
        $emp_gross_salary = $salary_amount['gross_salary'];
        if (!$emp_gross_salary) {
            $emp_gross_salary = 0;
        }
        $emp_basic_salary = $emp_gross_salary * 50 / 100;
        $emp_house_rent = $emp_basic_salary * 60 / 100;
        $emp_medical_allowance = $emp_basic_salary * 20 / 100;
        $emp_transport_allowance = $emp_basic_salary * 10 / 100;
        $emp_other_allowance = $emp_basic_salary * 10 / 100;

        $emp_telephone_allowance = $salary_amount['telephone_allow'];
        $emp_festival_bonus = $salary_amount['festival_bonus'];

        $emp_total_benifit = $emp_house_rent + $emp_medical_allowance + $emp_transport_allowance + $emp_other_allowance;
    }
    if ($salary_amount['yearly_paid']) {
        $emp_yearly_paid = $salary_amount['yearly_paid'];
    }
    if ($salary_deduction['provident_fund_deduction']) {
        $emp_provident_fund_deduction = $salary_deduction['provident_fund_deduction'];
    }
    if ($salary_deduction['tax_deduction']) {
        $emp_tax_deduction = $salary_deduction['tax_deduction'];
        if (!$emp_tax_deduction) {
            $emp_tax_deduction = 0;
        }
    }
    if ($salary_deduction['advance_loan']) {
        $emp_advance_loan = $salary_deduction['advance_loan'];
    }
    if ($salary_deduction['other_deduction']) {
        $emp_other_deduction = $salary_deduction['other_deduction'];
    }
    if ($salary_deduction['total_deduction']) {
        $emp_total_deduction = $salary_deduction['total_deduction'];
    }
    if ($payment_type['bank_name']) {
        $emp_bank = $payment_type['bank_name'];
        $emp_bank = $this->taxonomy->getTaxonomyBytid($emp_bank);
    }
    if ($payment_type['emp_bank_branch']) {
        $emp_bank_branch = $payment_type['emp_bank_branch'];
    }
    if ($payment_type['emp_bank_account']) {
        $emp_bank_account = $payment_type['emp_bank_account'];
    }
    if ($payment_type['emp_pay_type']) {
        $emp_pay_type = $payment_type['emp_pay_type'];
        $emp_pay_type = $this->taxonomy->getTaxonomyBytid($emp_pay_type);
    }
    foreach ($emp_details_records as $value) {
        if ($value['field_name'] == 'resources/uploads') {
            $picture = $value['field_value'];
        } else if ($value['field_name'] == 'emp_nationality') {
            $emp_nationality_id = $value['field_value'];
        } else if ($value['field_name'] == 'emp_fathername') {
            $emp_fathername = $value['field_value'];
        } else if ($value['field_name'] == 'emp_mothername') {
            $emp_mothername = $value['field_value'];
        } else if ($value['field_name'] == 'emp_blood_group') {

            $emp_blood_group_id = $value['field_value'];
            $emp_blood_group = $this->taxonomy->getTaxonomyBytid($emp_blood_group_id);
        } else if ($value['field_name'] == 'husband_wife_name') {
            $husband_wife_name = $value['field_value'];
        } else if ($value['field_name'] == 'emp_qualification') {
            $emp_qualification_id = $value['field_value'];
            $emp_qualification = $this->taxonomy->getTaxonomyBytid($emp_qualification_id);
        } else if ($value['field_name'] == 'emp_parmanent_address') {
            $emp_parmanent_address = $value['field_value'];
        } else if ($value['field_name'] == 'emp_parmanent_city') {
            $emp_parmanent_city_id = $value['field_value'];
            $emp_parmanent_city = $this->taxonomy->getTaxonomyBytid($emp_parmanent_city_id);
        } else if ($value['field_name'] == 'emp_parmanent_distict') {
            $emp_parmanent_distict_id = $value['field_value'];
            $emp_parmanent_distict = $this->taxonomy->getTaxonomyBytid($emp_parmanent_distict_id);
        } else if ($value['field_name'] == 'emp_present_city') {
            $emp_present_city_id = $value['field_value'];
            $emp_present_city = $this->taxonomy->getTaxonomyBytid($emp_present_city_id);
        } else if ($value['field_name'] == 'emp_home_phone') {
            $emp_home_phone = $value['field_value'];
        } else if ($value['field_name'] == 'emp_email') {
            $emp_email = $value['field_value'];
        } else if ($value['field_name'] == 'emp_alt_email') {
            $emp_alt_email = $value['field_value'];
        } else if ($value['field_name'] == 'emp_present_address') {
            $emp_present_address = $value['field_value'];
        } else if ($value['field_name'] == 'emp_office_phone') {
            $emp_office_phone = $value['field_value'];
        } else if ($value['field_name'] == 'emp_emergency_contact') {
            $emp_emergency_contact = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_course_1') {
            $emp_training_course_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_course_2') {
            $emp_training_course_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_course_3') {
            $emp_training_course_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_course_4') {
            $emp_training_course_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_course_5') {
            $emp_training_course_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_course_6') {
            $emp_training_course_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_course_7') {
            $emp_training_course_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_datefrom_1') {
            $emp_training_datefrom_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_datefrom_2') {
            $emp_training_datefrom_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_datefrom_3') {
            $emp_training_datefrom_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_datefrom_4') {
            $emp_training_datefrom_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_datefrom_5') {
            $emp_training_datefrom_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_datefrom_6') {
            $emp_training_datefrom_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_datefrom_7') {
            $emp_training_datefrom_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_dateto_1') {
            $emp_training_dateto_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_dateto_2') {
            $emp_training_dateto_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_dateto_3') {
            $emp_training_dateto_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_dateto_4') {
            $emp_training_dateto_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_dateto_5') {
            $emp_training_dateto_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_dateto_6') {
            $emp_training_dateto_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_dateto_7') {
            $emp_training_dateto_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_duration_1') {
            $emp_training_duration_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_duration_2') {
            $emp_training_duration_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_duration_3') {
            $emp_training_duration_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_duration_4') {
            $emp_training_duration_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_duration_5') {
            $emp_training_duration_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_duration_6') {
            $emp_training_duration_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_duration_7') {
            $emp_training_duration_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_organization_1') {
            $emp_training_organization_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_organization_2') {
            $emp_training_organization_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_organization_3') {
            $emp_training_organization_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_organization_4') {
            $emp_training_organization_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_organization_5') {
            $emp_training_organization_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_organization_6') {
            $emp_training_organization_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_training_organization_7') {
            $emp_training_organization_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_position_1') {
            $emp_exp_position_1 = $value['field_value'];
            $emp_exp_position_1 = $this->taxonomy->getTaxonomyBytid($emp_exp_position_1);
        } else if ($value['field_name'] == 'emp_exp_position_2') {
            $emp_exp_position_2 = $value['field_value'];
            $emp_exp_position_2 = $this->taxonomy->getTaxonomyBytid($emp_exp_position_2);
        } else if ($value['field_name'] == 'emp_exp_position_3') {
            $emp_exp_position_3 = $value['field_value'];
            $emp_exp_position_3 = $this->taxonomy->getTaxonomyBytid($emp_exp_position_3);
        } else if ($value['field_name'] == 'emp_exp_position_4') {
            $emp_exp_position_4 = $value['field_value'];
            $emp_exp_position_4 = $this->taxonomy->getTaxonomyBytid($emp_exp_position_4);
        } else if ($value['field_name'] == 'emp_exp_position_5') {
            $emp_exp_position_5 = $value['field_value'];
            $emp_exp_position_5 = $this->taxonomy->getTaxonomyBytid($emp_exp_position_5);
        } else if ($value['field_name'] == 'emp_exp_position_6') {
            $emp_exp_position_6 = $value['field_value'];
            $emp_exp_position_6 = $this->taxonomy->getTaxonomyBytid($emp_exp_position_6);
        } else if ($value['field_name'] == 'emp_exp_position_7') {
            $emp_exp_position_7 = $value['field_value'];
            $emp_exp_position_7 = $this->taxonomy->getTaxonomyBytid($emp_exp_position_7);
        } else if ($value['field_name'] == 'emp_exp_datefrom_1') {
            $emp_exp_datefrom_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_datefrom_2') {
            $emp_exp_datefrom_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_datefrom_3') {
            $emp_exp_datefrom_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_datefrom_4') {
            $emp_exp_datefrom_4 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_datefrom_5') {
            $emp_exp_datefrom_5 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_datefrom_6') {
            $emp_exp_datefrom_6 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_datefrom_7') {
            $emp_exp_datefrom_7 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_dateto_1') {
            $emp_exp_dateto_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_dateto_2') {
            $emp_exp_dateto_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_dateto_3') {
            $emp_exp_dateto_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_dateto_4') {
            $emp_exp_dateto_4 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_dateto_5') {
            $emp_exp_dateto_5 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_dateto_6') {
            $emp_exp_dateto_6 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_dateto_7') {
            $emp_exp_dateto_7 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_duration_1') {
            $emp_exp_duration_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_duration_2') {
            $emp_exp_duration_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_duration_3') {
            $emp_exp_duration_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_duration_4') {
            $emp_exp_duration_4 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_duration_5') {
            $emp_exp_duration_5 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_duration_6') {
            $emp_exp_duration_6 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_duration_7') {
            $emp_exp_duration_7 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_organization_1') {
            $emp_exp_organization_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_organization_2') {
            $emp_exp_organization_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_organization_3') {
            $emp_exp_organization_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_organization_4') {
            $emp_exp_organization_4 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_organization_5') {
            $emp_exp_organization_5 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_organization_6') {
            $emp_exp_organization_6 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_exp_organization_7') {
            $emp_exp_organization_7 = $value['field_value'];
            // Education ----------------------------------------------------------
        } else if ($value['field_name'] == 'emp_education_level_1') {
            $emp_education_level_1 = $value['field_value'];
            $emp_education_level_1 = $this->taxonomy->getTaxonomyBytid($emp_education_level_1);
        } else if ($value['field_name'] == 'emp_education_level_2') {
            $emp_education_level_2 = $value['field_value'];
            $emp_education_level_2 = $this->taxonomy->getTaxonomyBytid($emp_education_level_2);
        } else if ($value['field_name'] == 'emp_education_level_3') {
            $emp_education_level_3 = $value['field_value'];
            $emp_education_level_3 = $this->taxonomy->getTaxonomyBytid($emp_education_level_3);
        } else if ($value['field_name'] == 'emp_education_level_4') {
            $emp_education_level_4 = $value['field_value'];
            $emp_education_level_4 = $this->taxonomy->getTaxonomyBytid($emp_education_level_4);
        } else if ($value['field_name'] == 'emp_education_level_5') {
            $emp_education_level_5 = $value['field_value'];
            $emp_education_level_5 = $this->taxonomy->getTaxonomyBytid($emp_education_level_5);
        } else if ($value['field_name'] == 'emp_education_degree_1') {
            $emp_education_degree_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_degree_2') {
            $emp_education_degree_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_degree_3') {
            $emp_education_degree_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_degree_4') {
            $emp_education_degree_4 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_degree_5') {
            $emp_education_degree_5 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_major_1') {
            $emp_education_major_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_major_2') {
            $emp_education_major_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_major_3') {
            $emp_education_major_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_major_4') {
            $emp_education_major_4 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_major_5') {
            $emp_education_major_5 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_institute_1') {
            $emp_education_institute_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_institute_2') {
            $emp_education_institute_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_institute_3') {
            $emp_education_institute_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_institute_4') {
            $emp_education_institute_4 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_institute_5') {
            $emp_education_institute_5 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_year_1') {
            $emp_education_year_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_year_2') {
            $emp_education_year_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_year_3') {
            $emp_education_year_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_year_4') {
            $emp_education_year_4 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_year_5') {
            $emp_education_year_5 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_results_1') {
            $emp_education_results_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_results_2') {
            $emp_education_results_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_results_3') {
            $emp_education_results_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_results_4') {
            $emp_education_results_4 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_education_results_5') {
            $emp_education_results_5 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_language_name_1') {
            $emp_language_name_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_language_name_2') {
            $emp_language_name_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_language_name_3') {
            $emp_language_name_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_language_reading_1') {
            $emp_language_reading_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_language_reading_2') {
            $emp_language_reading_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_language_reading_3') {
            $emp_language_reading_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_language_writing_1') {
            $emp_language_writing_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_language_writing_2') {
            $emp_language_writing_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_language_writing_3') {
            $emp_language_writing_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_language_speaking_1') {
            $emp_language_speaking_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_language_speaking_2') {
            $emp_language_speaking_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_language_speaking_3') {
            $emp_language_speaking_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_language_listening_1') {
            $emp_language_listening_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_language_listening_2') {
            $emp_language_listening_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_language_listening_3') {
            $emp_language_listening_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_computer_training') {
            $emp_computer_training = $value['field_value'];
        } else if ($value['field_name'] == 'emp_dependent_name_1') {
            $emp_dependent_name_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_dependent_name_2') {
            $emp_dependent_name_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_dependent_name_3') {
            $emp_dependent_name_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_dependent_name_4') {
            $emp_dependent_name_4 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_dependent_name_5') {
            $emp_dependent_name_5 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_dependent_dob_1') {
            $emp_dependent_dob_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_dependent_dob_2') {
            $emp_dependent_dob_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_dependent_dob_3') {
            $emp_dependent_dob_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_dependent_dob_4') {
            $emp_dependent_dob_4 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_dependent_dob_5') {
            $emp_dependent_dob_5 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_dependent_relation_1') {
            $emp_dependent_relation_1 = $value['field_value'];
            $emp_dependent_relation_1 = $this->taxonomy->getTaxonomyBytid($emp_dependent_relation_1);
        } else if ($value['field_name'] == 'emp_dependent_relation_2') {
            $emp_dependent_relation_2 = $value['field_value'];
            $emp_dependent_relation_2 = $this->taxonomy->getTaxonomyBytid($emp_dependent_relation_2);
        } else if ($value['field_name'] == 'emp_dependent_relation_3') {
            $emp_dependent_relation_3 = $value['field_value'];
            $emp_dependent_relation_3 = $this->taxonomy->getTaxonomyBytid($emp_dependent_relation_3);
        } else if ($value['field_name'] == 'emp_dependent_relation_4') {
            $emp_dependent_relation_4 = $value['field_value'];
            $emp_dependent_relation_4 = $this->taxonomy->getTaxonomyBytid($emp_dependent_relation_4);
        } else if ($value['field_name'] == 'emp_dependent_relation_5') {
            $emp_dependent_relation_5 = $value['field_value'];
            $emp_dependent_relation_5 = $this->taxonomy->getTaxonomyBytid($emp_dependent_relation_5);
        } else if ($value['field_name'] == 'emp_dependent_nomtype_1') {
            $emp_dependent_nomtype_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_dependent_nomtype_2') {
            $emp_dependent_nomtype_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_dependent_nomtype_3') {
            $emp_dependent_nomtype_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_dependent_nomtype_4') {
            $emp_dependent_nomtype_4 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_dependent_nomtype_5') {
            $emp_dependent_nomtype_5 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_name_1') {
            $emp_reference_name_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_name_2') {
            $emp_reference_name_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_name_3') {
            $emp_reference_name_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_position_1') {
            $emp_reference_position_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_position_2') {
            $emp_reference_position_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_position_3') {
            $emp_reference_position_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_org_1') {
            $emp_reference_org_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_org_2') {
            $emp_reference_org_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_org_3') {
            $emp_reference_org_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_address_1') {
            $emp_reference_address_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_address_2') {
            $emp_reference_address_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_address_3') {
            $emp_reference_address_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_phone_1') {
            $emp_reference_phone_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_phone_2') {
            $emp_reference_phone_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_phone_3') {
            $emp_reference_phone_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_email_1') {
            $emp_reference_email_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_email_2') {
            $emp_reference_email_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_email_3') {
            $emp_reference_email_3 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_relation_1') {
            $emp_reference_relation_1 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_relation_2') {
            $emp_reference_relation_2 = $value['field_value'];
        } else if ($value['field_name'] == 'emp_reference_relation_3') {
            $emp_reference_relation_3 = $value['field_value'];
        }
    }

    date_default_timezone_set('Asia/Dhaka');
    $servertime = time();
    $now = date("d-m-Y", $servertime);
    ?>
    <style type="text/css">
        input[type=text],
        select,
        textarea,
        input[type=checkbox],
        input[type=number],
        input[type=file] {
            /*background-color: #F0E68C;*/
            background-image: linear-gradient(#F0E68C, #FFFFFF, #F0E68C);
            padding: 5px;
            pointer-events: none;
        }

        .bgcolor_D8D8D8 {
            border-bottom: 1px dotted #CCC;
        }

        .provision {
            display: none;
        }

        .overtime_rate {
            display: none;
        }

        .absent_cnt_time {
            display: none;
        }

        .custom-row-radious2 {
            border-top: 1px solid #000;
        }

        #add_profile_btn {
            padding: 8px;
            /*background: #DCEDF6;*/

        }

        .chosen-container.chosen-container-single {
            width: 100% !important;
            /* or any value that fits your needs */
        }

        #preview {
            border: 10px solid #FFF;
            width: 180px;
            height: 210px;
        }
    </style>
</head>

<body class="logged-in dashboard">
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php
            $this->load->view('includes/menu');
            ?>
            <div class="row under-header-bar text-center">
                <h4>Employee Profile</h4>
            </div>
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        print $this->session->flashdata('errors');
                        print $this->session->flashdata('success');
                        ?>
                        <form action="<?php echo base_url(); ?>addprofile/do_upload" method="post" class="myForm" id="myForm" name="myForm" onSubmit="return validate();" enctype="multipart/form-data">
                            <input type="hidden" id="content_id" name="content_id" value="<?php echo $content_id; ?>">
                            <input type="hidden" id="current_img" name="current_img" value="<?php echo $picture; ?>">


                            <div class="row custom-row-radious2">
                                <div class="tabs">
                                    <ul class="tabs">
                                        <li class="activetab" id="Tab_1"> Employee Master </li>
                                        <!-- <li class="nonactivetab" id="Tab_2"> Contact </li> -->
                                        <!-- <li class="nonactivetab" id="Tab_3"> Trainings </li> -->
                                        <li class="nonactivetab" id="Tab_4"> Experiences/Trainings</li>
                                        <li class="nonactivetab" id="Tab_5"> Education </li>
                                        <!-- <li class="nonactivetab" id="Tab_6"> Language </li> -->
                                        <!-- <li class="nonactivetab" id="Tab_7"> Computer Skill </li> -->
                                        <li class="nonactivetab" id="Tab_8"> Others </li>
                                        <!-- <li class="nonactivetab" id="Tab_9"> PayRoll </li> -->
                                        <li class="nonactivetab" id="Tab_10"> Documents </li>
                                    </ul>
                                    <div class="tabcontent" id="content_1">
                                        <div class="row">
                                            <div class="col-md-12 heading_style">
                                                Employee
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="row">
                                                    <!-- <div class="col-md-5 bgcolor_D8D8D8">Mother's Name</div> -->
                                                    <div class="col-md-7">
                                                        <div id="filefield">
                                                            <?php if ($picture) { ?>
                                                                <img src="<?php echo base_url(); ?>resources/uploads/<?php echo $picture; ?>" id="preview" width="" />
                                                            <?php } else { ?>
                                                                <img src="<?php echo base_url(); ?>resources/uploads/no_image.jpg" id="preview" />
                                                            <?php } ?>
                                                            <!--<div id="filediv"><input name="file[]" type="file" id="file" style="width: inherit;" /></div>-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-4 bgcolor_D8D8D8">Employee Name</div>
                                                            <div class="col-md-8" style="font-weight:bold">
                                                                <input type="text" value="<?php echo $employeeInfo->emp_name; ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 bgcolor_D8D8D8">Employee Code</div>
                                                            <div class="col-md-8">
                                                                <input type="text" value="<?php echo $employeeInfo->emp_id; ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 bgcolor_D8D8D8">Company : </div>
                                                            <div class="col-md-8">
                                                                <input type="text" value="<?php echo $employeeInfo->company_name; ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 bgcolor_D8D8D8">Division : </div>
                                                            <div class="col-md-8">
                                                                <input type="text" value="<?php echo $employeeInfo->division_name; ?>" />
                                                            </div>
                                                        </div>


                                                        <div class="row">
                                                            <div class="col-md-4 bgcolor_D8D8D8">Department</div>
                                                            <div class="col-md-8">
                                                                <input type="text" value="<?php echo $employeeInfo->department_name; ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 bgcolor_D8D8D8">Nationality</div>
                                                            <div class="col-md-8">
                                                                <input type="text" value="<?php echo $emp_nationality_id; ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 bgcolor_D8D8D8">Gender</div>
                                                            <div class="col-md-8">
                                                                <input type="text" value="<?php echo $employeeInfo->gender; ?>  " />

                                                            </div>
                                                        </div>
                                                        <?php if ($view_employee_date_of_birth['status'] == 1) { ?>
                                                            <div class="row">
                                                                <div class="col-md-4 bgcolor_D8D8D8">Date of Birth</div>
                                                                <div class="col-md-8">
                                                                    <input type="text" value=" <?php echo $employeeInfo->dob; ?>" />

                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-4 bgcolor_D8D8D8">Father's Name</div>
                                                            <div class="col-md-8">
                                                                <input type="text" name="emp_fathername" id="emp_fathername" value="<?php if ($emp_fathername) {
                                                                                                                                        echo $emp_fathername;
                                                                                                                                    } ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 bgcolor_D8D8D8">Mother's Name</div>
                                                            <div class="col-md-8"><input type="text" name="emp_mothername" id="emp_mothername" value="<?php if ($emp_mothername) {
                                                                                                                                                            echo $emp_mothername;
                                                                                                                                                        } ?>" /></div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 bgcolor_D8D8D8">National ID</div>
                                                            <div class="col-md-8">
                                                                <input type="text" value="<?php echo $employeeInfo->national_id; ?>  " />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 bgcolor_D8D8D8">Marital Status</div>
                                                            <div class="col-md-8">
                                                                <input type="text" value="<?php echo $employeeInfo->merital_status_name; ?>  " />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 bgcolor_D8D8D8">Religion</div>
                                                            <div class="col-md-8">
                                                                <input type="text" value="<?php echo $employeeInfo->religion_name; ?>  " />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 bgcolor_D8D8D8">Blood Group</div>
                                                            <div class="col-md-8">
                                                                <input type="text" value="<?php echo $emp_blood_group['name']; ?>  " />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 bgcolor_D8D8D8">Husband/ Wife Name</div>
                                                            <div class="col-md-8">
                                                                <input type="text" value="<?php echo $employeeInfo->husband_wife_name; ?>  " />
                                                            </div>
                                                        </div>
                                                        <?php if ($view_employee_age['status'] == 1) { ?>
                                                            <div class="row">
                                                                <div class="col-md-4 bgcolor_D8D8D8">Age</div>
                                                                <div class="col-md-8">
                                                                    <input type="text" value="<?php //echo $employeeInfo->religion_name; 
                                                                                                ?>  " />
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 heading_style">
                                                Parmanent Address
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Address</div>
                                                    <div class="col-md-8">
                                                        <textarea name="emp_parmanent_address" id="emp_parmanent_address" cols="30" rows="3"><?php if ($emp_parmanent_address) {
                                                                                                                                                    echo $emp_parmanent_address;
                                                                                                                                                } ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">City</div>
                                                    <div class="col-md-8">
                                                        <input type="text" value="<?php echo $emp_parmanent_city['name']; ?>  " />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Distict</div>
                                                    <div class="col-md-8">
                                                        <input type="text" value="<?php echo $emp_parmanent_distict['name']; ?>  " />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 heading_style">
                                                Present Address
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Present Address</div>
                                                    <div class="col-md-8">
                                                        <textarea name="emp_present_address" id="emp_present_address" cols="30" rows="3"><?php if ($emp_present_address) {
                                                                                                                                                echo $emp_present_address;
                                                                                                                                            } ?></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">City</div>
                                                    <div class="col-md-8">
                                                        <input type="text" value="<?php echo $emp_present_city['name']; ?>  " />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Current Distict</div>
                                                    <div class="col-md-8">
                                                        <input type="text" value="<?php echo $employeeInfo->district_name; ?>  " />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 heading_style">
                                                Contact
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php if ($view_employee_mobile_number['status'] == 1) { ?>
                                                    <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Mobile No.</div>
                                                        <div class="col-md-8">
                                                            <input type="text" value="<?php echo $employeeInfo->mobile_no; ?>  " />
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Office Phone</div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="emp_office_phone" id="emp_office_phone" autocomplete="off" class="phonenumbersOnly" value="<?php if ($emp_office_phone) {
                                                                                                                                                                                echo $emp_office_phone;
                                                                                                                                                                            } ?>" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Home Phone</div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="emp_home_phone" id="emp_home_phone" autocomplete="off" class="phonenumbersOnly" value="<?php if ($emp_home_phone) {
                                                                                                                                                                            echo $emp_home_phone;
                                                                                                                                                                        } ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Emergency Contact</div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="emp_emergency_contact" id="emp_emergency_contact" autocomplete="off" class="phonenumbersOnly" value="<?php if ($emp_emergency_contact) {
                                                                                                                                                                                            echo $emp_emergency_contact;
                                                                                                                                                                                        } ?>" />
                                                    </div>
                                                </div>
                                                <?php if ($view_employee_email_address['status'] == 1) { ?>
                                                    <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Email</div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="emp_email" id="emp_email" value="<?php if ($emp_email) {
                                                                                                                            echo $emp_email;
                                                                                                                        } ?>" />
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Alternative Email</div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="emp_alt_email" id="emp_alt_email" value="<?php if ($emp_alt_email) {
                                                                                                                                echo $emp_alt_email;
                                                                                                                            } ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 heading_style">
                                                Job
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Joining Date</div>
                                                    <div class="col-md-8">
                                                        <input type="text" value="<?php echo $employeeInfo->joining_date; ?>  " />
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Position</div>
                                                    <div class="col-md-8">
                                                        <input type="text" value="<?php echo $employeeInfo->designation_name; ?>  " />
                                                    </div>
                                                </div>
                                                <div class="row">
													<div class="col-md-4 bgcolor_D8D8D8">Grade <?php echo $emp_grade; ?> <i class="fas fa-asterisk" style="font-size:7px;color:red"></i></div>
													<div class="col-md-8">
														<select name="emp_grade" id="emp_grade">
															<option value="">Select Grade</option>
															<?php foreach ($grades as $val) : ?>
																<option value="<?php echo $val->id; ?>" <?php echo  $val->id == $employeeInfo->grade ? 'selected="selected"' : ''; ?>><?php echo $val->grade_name; ?></option>;
															<?php endforeach; ?>
														</select>
													</div>
												</div>
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Qualification</div>
                                                    <div class="col-md-8">
                                                        <input type="text" value="<?php echo $emp_qualification['name']; ?>  " />
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Type Of Employee</div>
                                                    <div class="col-md-8">
                                                        <input type="text" value="<?php echo $employeeInfo->type_of_emp_name; ?>  " />
                                                    </div>
                                                </div>

                                                <div class="row provision" style="<?php if ($emp_provision_starting_date) {
                                                                                        echo "display:block";
                                                                                    } ?>">
                                                    <div class="col-md-4 bgcolor_D8D8D8">provision Date From</div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="emp_provision_starting_date" id="emp_provision_starting_date" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if ($emp_provision_starting_date) {
                                                                                                                                                                                                                    echo $emp_provision_starting_date;
                                                                                                                                                                                                                } ?>" />
                                                    </div>
                                                </div>
                                                <div class="row provision" style="<?php if ($emp_provision_starting_date) {
                                                                                        echo "display:block";
                                                                                    } ?>">
                                                    <div class="col-md-4 bgcolor_D8D8D8">provision Date To</div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="emp_provision_ending_date" id="emp_provision_ending_date" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if ($emp_provision_ending_date) {
                                                                                                                                                                                                                echo $emp_provision_ending_date;
                                                                                                                                                                                                            } ?>" />
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Overtime Count</div>
                                                    <div class="col-md-8">
                                                        <input type="text" value="<?php echo $overtime_count; ?>  " />
                                                    </div>
                                                </div>
                                                <div class="row overtime_rate" style="<?php if ($overtime_hourly_rate) {
                                                                                            echo "display:block";
                                                                                        } ?>">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Overtime Hourly Rate</div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="overtime_hourly_rate" id="overtime_hourly_rate" onkeypress="return isNumber(event);" value="<?php if ($overtime_hourly_rate) {
                                                                                                                                                                                    echo $overtime_hourly_rate;
                                                                                                                                                                                } ?>" placeholder="Amount in taka" />
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Present Salary</div>
                                                    <div class="col-md-8">
                                                        <input type="text" readonly="readonly" value="<?php if ($emp_gross_salary) {
                                                                                                            echo $emp_gross_salary;
                                                                                                        } ?>" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Attendance Required</div>
                                                    <div class="col-md-8">
                                                        <input type="text" value="<?php echo $attendance_required; ?>  " />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Work Starting Time</div>
                                                    <div class="col-md-8">
                                                        <input type="text" placeholder="e.g. hh:mm:ss" name="emp_working_time_from" id="emp_working_time_from" value="<?php if ($emp_working_time_from) {
                                                                                                                                                                            echo $emp_working_time_from;
                                                                                                                                                                        } else {
                                                                                                                                                                            echo "09:30:00";
                                                                                                                                                                        } ?>" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Work Ending Time</div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="emp_working_end_time" id="emp_working_end_time" placeholder="e.g. hh:mm:ss" value="<?php if ($emp_working_end_time) {
                                                                                                                                                                        echo $emp_working_end_time;
                                                                                                                                                                    } else {
                                                                                                                                                                        echo "17:30:00";
                                                                                                                                                                    } ?>" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Late Count Time</div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="emp_latecount_time" id="emp_latecount_time" placeholder="e.g. hh:mm:ss" value="<?php if ($emp_latecount_time) {
                                                                                                                                                                    echo $emp_latecount_time;
                                                                                                                                                                } else {
                                                                                                                                                                    echo "09:46:00";
                                                                                                                                                                } ?>" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Early Count Time</div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="emp_earlycount_time" id="emp_earlycount_time" placeholder="e.g. hh:mm:ss" value="<?php if ($emp_earlycount_time) {
                                                                                                                                                                        echo $emp_earlycount_time;
                                                                                                                                                                    } else {
                                                                                                                                                                        echo "17:20:00";
                                                                                                                                                                    } ?>" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Logout Required</div>
                                                    <div class="col-md-8">
                                                        <input type="text" value="<?php echo $logout_required; ?>  " />

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Half Day Absent</div>
                                                    <div class="col-md-8">
                                                        <input type="text" value="<?php echo $half_day_absent; ?>  " />

                                                    </div>
                                                </div>
                                                <div class="row absent_cnt_time" style="<?php if ($absent_count_time) {
                                                                                            echo "display:block";
                                                                                        } ?>">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Absent Count Time</div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="absent_count_time" id="absent_count_time" placeholder="e.g. hh:mm:ss" value="<?php if ($absent_count_time) {
                                                                                                                                                                    echo $absent_count_time;
                                                                                                                                                                } ?>" />
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 heading_style">
                                                Employee Weekly Holiday
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-2 bgcolor_D8D8D8">Weekly Holiday</div>
                                                    <div class="col-md-4">

                                                        <select size="7" multiple>
                                                            <option value="fri" <?php if ($emp_holiday['fri_off'] == 'off') {
                                                                                    print 'selected="selected"';
                                                                                } else if (!$emp_holiday) {
                                                                                    print 'selected="selected"';
                                                                                } ?>>Friday</option>
                                                            <option value="sat" <?php if ($emp_holiday['sat_off'] == 'off') {
                                                                                    print 'selected="selected"';
                                                                                } ?>>Saturday</option>
                                                            <option value="sun" <?php if ($emp_holiday['sun_off'] == 'off') {
                                                                                    print 'selected="selected"';
                                                                                } ?>>Sunday</option>
                                                            <option value="mon" <?php if ($emp_holiday['mon_off'] == 'off') {
                                                                                    print 'selected="selected"';
                                                                                } ?>>Monday</option>
                                                            <option value="tue" <?php if ($emp_holiday['tue_off'] == 'off') {
                                                                                    print 'selected="selected"';
                                                                                } ?>>Tuesday</option>
                                                            <option value="wed" <?php if ($emp_holiday['wed_off'] == 'off') {
                                                                                    print 'selected="selected"';
                                                                                } ?>>Wednesday</option>
                                                            <option value="thus" <?php if ($emp_holiday['thus_off'] == 'off') {
                                                                                        print 'selected="selected"';
                                                                                    } ?>>Thusday</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-4 bgcolor_D8D8D8">Total Leave</div>
                                                            <div class="col-md-8">
                                                                <input type="text" name="annual_leave_total" id="annual_leave_total" onkeypress="return isNumber(event);" value="<?php if ($emp_total_leave) {
                                                                                                                                                                                        echo $emp_total_leave['total_days'];
                                                                                                                                                                                    } else {
                                                                                                                                                                                        echo "12";
                                                                                                                                                                                    } ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 heading_style">
                                                Employee Yearly Leave
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2 heading_style" style="font-size: 13px;padding: 4.9px; display:none">
                                                <input type="checkbox" id="leave_total_system" name="leave_total_system" <?php //if($emp_total_leave){ echo 'checked="checked"'; }else if(!$leave_cat_count){ echo 'checked="checked"'; } 
                                                                                                                            ?>> Total System
                                            </div>
                                            <div class="col-md-2 heading_style" style="font-size: 13px;padding: 4.9px; ">
                                                <input type="checkbox" id="leave_category_system" name="leave_category_system" checked <?php //if($leave_cat_count && !$emp_total_leave){ echo 'checked="checked"'; } 
                                                                                                                                        ?>> Category System
                                            </div>
                                        </div>

                                        <div class="total_leave_area" style="display:none">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="">Total Leave:</label>
                                                    <input type="text" name="annual_leave_total" id="annual_leave_total" onkeypress="return isNumber(event);" value="<?php if ($emp_total_leave) {
                                                                                                                                                                            echo $emp_total_leave['total_days'];
                                                                                                                                                                        } else {
                                                                                                                                                                            echo "56";
                                                                                                                                                                        } ?>" />
                                                    <!-- [NOTE: Yearly Earned Leave 30, Yearly Casual Leave 12, Yearly Sick Leave 14] -->

                                                </div>

                                            </div>
                                        </div>

                                        <div class="category_leave_area" style="<?php if ($leave_cat_count && !$emp_total_leave) {
                                                                                    echo 'display:block;';
                                                                                } else {
                                                                                    //echo 'display:none;';
                                                                                }
                                                                                ?>">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <?php
                                                    $leave_field_count = count($allleavetype);
                                                    $leave_field_count_half = round($leave_field_count / 2);
                                                    $loop_counter = 1;
// dd($allleavetype);
                                                    foreach ($allleavetype as $single_leave) {
                                                        $leave_level = $single_leave['name'];
                                                        $leave_machine_name = $single_leave['description'];
                                                        $leave_id = $single_leave['id'];
                                                        if ($toedit_id) {
                                                            $previous_leave = $this->emp_leave_model->getemp_yearlyleave($toedit_id, $leave_id);
                                                        }

                                                    ?>
                                                        <div class="row">
                                                            <div class="col-md-4 bgcolor_D8D8D8"><?php echo $leave_level;
                                                                                                    ?></div>
                                                            <div class="col-md-8">
                                                                <input type="text" name="annual_leave[<?= $leave_id ?>]" id="<?= $leave_machine_name ?>" onkeypress="return isNumber(event);" value="<?php if ($previous_leave) {
                                                                                                                                                                                                            echo $previous_leave['total_days'];
                                                                                                                                                                                                        } ?>" />
                                                            </div>
                                                        </div>

                                                    <?php
                                                        if ($leave_field_count_half == $loop_counter) {
                                                            echo '</div>
														<div class="col-md-6">';
                                                        }
                                                        $loop_counter++;
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tabcontent" id="content_4">
                                        <div class="row">
                                            <div class="col-md-12 heading_style">
                                                Experience
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2 bgcolor_D8D8D8">Position</div>
                                            <div class="col-md-2 bgcolor_D8D8D8">Date From</div>
                                            <div class="col-md-2 bgcolor_D8D8D8">Date To</div>
                                            <div class="col-md-2 bgcolor_D8D8D8">Duration</div>
                                            <div class="col-md-3 bgcolor_D8D8D8">Name of Organization</div>
                                        </div>
                                        <?php if ($emp_exp_position_1) { ?>
                                            <div class="row">
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_exp_position_1['name']; ?>" />
                                                </div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_datefrom_1" id="emp_exp_datefrom_1" value="<?php if ($emp_exp_datefrom_1) {
                                                                                                                                                                                            echo $emp_exp_datefrom_1;
                                                                                                                                                                                        } ?>" />
                                                </div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_dateto_1" id="emp_exp_dateto_1" value="<?php if ($emp_exp_dateto_1) {
                                                                                                                                                                                                                                                            echo $emp_exp_dateto_1;
                                                                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_duration_1" id="emp_exp_duration_1" value="<?php if ($emp_exp_duration_1) {
                                                                                                                                                                                                        echo $emp_exp_duration_1;
                                                                                                                                                                                                    } ?>" /></div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_organization_1" id="emp_exp_organization_1" value="<?php if ($emp_exp_organization_1) {
                                                                                                                                                                                                                echo $emp_exp_organization_1;
                                                                                                                                                                                                            } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_exp_position_2) { ?>
                                            <div class="row">
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_exp_position_2['name']; ?>" />
                                                </div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_datefrom_2" id="emp_exp_datefrom_2" value="<?php if ($emp_exp_datefrom_2) {
                                                                                                                                                                                                                                                                echo $emp_exp_datefrom_2;
                                                                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_dateto_2" id="emp_exp_dateto_2" value="<?php if ($emp_exp_dateto_2) {
                                                                                                                                                                                                                                                            echo $emp_exp_dateto_2;
                                                                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_duration_2" id="emp_exp_duration_2" value="<?php if ($emp_exp_duration_2) {
                                                                                                                                                                                                        echo $emp_exp_duration_2;
                                                                                                                                                                                                    } ?>" /></div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_organization_2" id="emp_exp_organization_2" value="<?php if ($emp_exp_organization_2) {
                                                                                                                                                                                                                echo $emp_exp_organization_2;
                                                                                                                                                                                                            } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_exp_position_3) { ?>
                                            <div class="row">
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_exp_position_3['name']; ?>" />
                                                </div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_datefrom_3" id="emp_exp_datefrom_3" value="<?php if ($emp_exp_datefrom_3) {
                                                                                                                                                                                                                                                                echo $emp_exp_datefrom_3;
                                                                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_dateto_3" id="emp_exp_dateto_3" value="<?php if ($emp_exp_dateto_3) {
                                                                                                                                                                                                                                                            echo $emp_exp_dateto_3;
                                                                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_duration_3" id="emp_exp_duration_3" value="<?php if ($emp_exp_duration_3) {
                                                                                                                                                                                                        echo $emp_exp_duration_3;
                                                                                                                                                                                                    } ?>" /></div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_organization_3" id="emp_exp_organization_3" value="<?php if ($emp_exp_organization_3) {
                                                                                                                                                                                                                echo $emp_exp_organization_3;
                                                                                                                                                                                                            } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_exp_position_4) { ?>
                                            <div class="row">
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_exp_position_4['name']; ?>" />
                                                </div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_datefrom_4" id="emp_exp_datefrom_4" value="<?php if ($emp_exp_datefrom_4) {
                                                                                                                                                                                                                                                                echo $emp_exp_datefrom_4;
                                                                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_dateto_4" id="emp_exp_dateto_4" value="<?php if ($emp_exp_dateto_4) {
                                                                                                                                                                                                                                                            echo $emp_exp_dateto_4;
                                                                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_duration_4" id="emp_exp_duration_4" value="<?php if ($emp_exp_duration_4) {
                                                                                                                                                                                                        echo $emp_exp_duration_4;
                                                                                                                                                                                                    } ?>" /></div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_organization_4" id="emp_exp_organization_4" value="<?php if ($emp_exp_organization_4) {
                                                                                                                                                                                                                echo $emp_exp_organization_4;
                                                                                                                                                                                                            } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_exp_position_5) { ?>
                                            <div class="row">
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_exp_position_5['name']; ?>" />
                                                </div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_datefrom_5" id="emp_exp_datefrom_5" value="<?php if ($emp_exp_datefrom_5) {
                                                                                                                                                                                                                                                                echo $emp_exp_datefrom_5;
                                                                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_dateto_5" id="emp_exp_dateto_5" value="<?php if ($emp_exp_dateto_5) {
                                                                                                                                                                                                                                                            echo $emp_exp_dateto_5;
                                                                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_duration_5" id="emp_exp_duration_5" value="<?php if ($emp_exp_duration_5) {
                                                                                                                                                                                                        echo $emp_exp_duration_5;
                                                                                                                                                                                                    } ?>" /></div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_organization_5" id="emp_exp_organization_5" value="<?php if ($emp_exp_organization_5) {
                                                                                                                                                                                                                echo $emp_exp_organization_5;
                                                                                                                                                                                                            } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_exp_position_6) { ?>
                                            <div class="row">
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_exp_position_6['name']; ?>" />
                                                </div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_datefrom_6" id="emp_exp_datefrom_6" value="<?php if ($emp_exp_datefrom_6) {
                                                                                                                                                                                                                                                                echo $emp_exp_datefrom_6;
                                                                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_dateto_6" id="emp_exp_dateto_6" value="<?php if ($emp_exp_dateto_6) {
                                                                                                                                                                                                                                                            echo $emp_exp_dateto_6;
                                                                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_duration_6" id="emp_exp_duration_6" value="<?php if ($emp_exp_duration_6) {
                                                                                                                                                                                                        echo $emp_exp_duration_6;
                                                                                                                                                                                                    } ?>" /></div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_organization_6" id="emp_exp_organization_6" value="<?php if ($emp_exp_organization_6) {
                                                                                                                                                                                                                echo $emp_exp_organization_6;
                                                                                                                                                                                                            } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_exp_position_7) { ?>
                                            <div class="row">
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_exp_position_7['name']; ?>" />
                                                </div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_datefrom_7" id="emp_exp_datefrom_7" value="<?php if ($emp_exp_datefrom_7) {
                                                                                                                                                                                                                                                                echo $emp_exp_datefrom_7;
                                                                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_exp_dateto_7" id="emp_exp_dateto_7" value="<?php if ($emp_exp_dateto_7) {
                                                                                                                                                                                                                                                            echo $emp_exp_dateto_7;
                                                                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_duration_7" id="emp_exp_duration_7" value="<?php if ($emp_exp_duration_7) {
                                                                                                                                                                                                        echo $emp_exp_duration_7;
                                                                                                                                                                                                    } ?>" /></div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_exp_organization_7" id="emp_exp_organization_7" value="<?php if ($emp_exp_organization_7) {
                                                                                                                                                                                                                echo $emp_exp_organization_7;
                                                                                                                                                                                                            } ?>" /></div>
                                            </div>
                                        <?php } ?>
                                        <!-- training -->
                                        <div class="row">
                                            <div class="col-md-12 heading_style">
                                                Training
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Training Course</div>
                                            <div class="col-md-2 bgcolor_D8D8D8">Date From</div>
                                            <div class="col-md-2 bgcolor_D8D8D8">Date To</div>
                                            <div class="col-md-2 bgcolor_D8D8D8">Duration</div>
                                            <div class="col-md-3 bgcolor_D8D8D8">Name of Organization</div>
                                        </div>
                                        <?php if ($emp_training_course_1) { ?>
                                            <div class="row">
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_course_1" id="emp_training_course_1" value="<?php if ($emp_training_course_1) {
                                                                                                                                                                                                            echo $emp_training_course_1;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_datefrom_1" id="emp_training_datefrom_1" value="<?php if ($emp_training_datefrom_1) {
                                                                                                                                                                                                                                                                        echo $emp_training_datefrom_1;
                                                                                                                                                                                                                                                                    } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_dateto_1" id="emp_training_dateto_1" value="<?php if ($emp_training_dateto_1) {
                                                                                                                                                                                                                                                                    echo $emp_training_dateto_1;
                                                                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_duration_1" id="emp_training_duration_1" value="<?php if ($emp_training_duration_1) {
                                                                                                                                                                                                                echo $emp_training_duration_1;
                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_organization_1" id="emp_training_organization_1" value="<?php if ($emp_training_organization_1) {
                                                                                                                                                                                                                        echo $emp_training_organization_1;
                                                                                                                                                                                                                    } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_training_course_2) { ?>
                                            <div class="row">
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_course_2" id="emp_training_course_2" value="<?php if ($emp_training_course_2) {
                                                                                                                                                                                                            echo $emp_training_course_2;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_datefrom_2" id="emp_training_datefrom_2" value="<?php if ($emp_training_datefrom_2) {
                                                                                                                                                                                                                                                                        echo $emp_training_datefrom_2;
                                                                                                                                                                                                                                                                    } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_dateto_2" id="emp_training_dateto_2" value="<?php if ($emp_training_dateto_2) {
                                                                                                                                                                                                                                                                    echo $emp_training_dateto_2;
                                                                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_duration_2" id="emp_training_duration_2" value="<?php if ($emp_training_duration_2) {
                                                                                                                                                                                                                echo $emp_training_duration_2;
                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_organization_2" id="emp_training_organization_2" value="<?php if ($emp_training_organization_2) {
                                                                                                                                                                                                                        echo $emp_training_organization_2;
                                                                                                                                                                                                                    } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_training_course_3) { ?>
                                            <div class="row">
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_course_3" id="emp_training_course_3" value="<?php if ($emp_training_course_3) {
                                                                                                                                                                                                            echo $emp_training_course_3;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_datefrom_3" id="emp_training_datefrom_3" value="<?php if ($emp_training_datefrom_3) {
                                                                                                                                                                                                                                                                        echo $emp_training_datefrom_3;
                                                                                                                                                                                                                                                                    } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_dateto_3" id="emp_training_dateto_3" value="<?php if ($emp_training_dateto_3) {
                                                                                                                                                                                                                                                                    echo $emp_training_dateto_3;
                                                                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_duration_3" id="emp_training_duration_3" value="<?php if ($emp_training_duration_3) {
                                                                                                                                                                                                                echo $emp_training_duration_3;
                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_organization_3" id="emp_training_organization_3" value="<?php if ($emp_training_organization_3) {
                                                                                                                                                                                                                        echo $emp_training_organization_3;
                                                                                                                                                                                                                    } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_training_course_4) { ?>
                                            <div class="row">
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_course_4" id="emp_training_course_4" value="<?php if ($emp_training_course_4) {
                                                                                                                                                                                                            echo $emp_training_course_4;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_datefrom_4" id="emp_training_datefrom_4" value="<?php if ($emp_training_datefrom_4) {
                                                                                                                                                                                                                                                                        echo $emp_training_datefrom_4;
                                                                                                                                                                                                                                                                    } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_dateto_4" id="emp_training_dateto_4" value="<?php if ($emp_training_dateto_4) {
                                                                                                                                                                                                                                                                    echo $emp_training_dateto_4;
                                                                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_duration_4" id="emp_training_duration_4" value="<?php if ($emp_training_duration_4) {
                                                                                                                                                                                                                echo $emp_training_duration_4;
                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_organization_4" id="emp_training_organization_4" value="<?php if ($emp_training_organization_4) {
                                                                                                                                                                                                                        echo $emp_training_organization_4;
                                                                                                                                                                                                                    } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_training_course_5) { ?>
                                            <div class="row">
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_course_5" id="emp_training_course_5" value="<?php if ($emp_training_course_5) {
                                                                                                                                                                                                            echo $emp_training_course_5;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_datefrom_5" id="emp_training_datefrom_5" value="<?php if ($emp_training_datefrom_5) {
                                                                                                                                                                                                                                                                        echo $emp_training_datefrom_5;
                                                                                                                                                                                                                                                                    } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_dateto_5" id="emp_training_dateto_5" value="<?php if ($emp_training_dateto_5) {
                                                                                                                                                                                                                                                                    echo $emp_training_dateto_5;
                                                                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_duration_5" id="emp_training_duration_5" value="<?php if ($emp_training_duration_5) {
                                                                                                                                                                                                                echo $emp_training_duration_5;
                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_organization_5" id="emp_training_organization_5" value="<?php if ($emp_training_organization_5) {
                                                                                                                                                                                                                        echo $emp_training_organization_5;
                                                                                                                                                                                                                    } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_training_course_6) { ?>
                                            <div class="row">
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_course_6" id="emp_training_course_6" value="<?php if ($emp_training_course_6) {
                                                                                                                                                                                                            echo $emp_training_course_6;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_datefrom_6" id="emp_training_datefrom_6" value="<?php if ($emp_training_datefrom_6) {
                                                                                                                                                                                                                                                                        echo $emp_training_datefrom_6;
                                                                                                                                                                                                                                                                    } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_dateto_6" id="emp_training_dateto_6" value="<?php if ($emp_training_dateto_6) {
                                                                                                                                                                                                                                                                    echo $emp_training_dateto_6;
                                                                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_duration_6" id="emp_training_duration_6" value="<?php if ($emp_training_duration_6) {
                                                                                                                                                                                                                echo $emp_training_duration_6;
                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_organization_6" id="emp_training_organization_6" value="<?php if ($emp_training_organization_6) {
                                                                                                                                                                                                                        echo $emp_training_organization_6;
                                                                                                                                                                                                                    } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_training_course_7) { ?>
                                            <div class="row">
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_course_7" id="emp_training_course_7" value="<?php if ($emp_training_course_7) {
                                                                                                                                                                                                            echo $emp_training_course_7;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_datefrom_7" id="emp_training_datefrom_7" value="<?php if ($emp_training_datefrom_7) {
                                                                                                                                                                                                                                                                        echo $emp_training_datefrom_7;
                                                                                                                                                                                                                                                                    } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_training_dateto_7" id="emp_training_dateto_7" value="<?php if ($emp_training_dateto_7) {
                                                                                                                                                                                                                                                                    echo $emp_training_dateto_7;
                                                                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_duration_7" id="emp_training_duration_7" value="<?php if ($emp_training_duration_7) {
                                                                                                                                                                                                                echo $emp_training_duration_7;
                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_training_organization_7" id="emp_training_organization_7" value="<?php if ($emp_training_organization_7) {
                                                                                                                                                                                                                        echo $emp_training_organization_7;
                                                                                                                                                                                                                    } ?>" /></div>
                                            </div>
                                        <?php } ?>
                                        <div class="row">
                                            <div class="col-md-12 heading_style">
                                                Computer Skills
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1 bgcolor_D8D8D8">Topics</div>
                                            <div class="col-md-11"><textarea name="emp_computer_training" id="emp_computer_training" rows="5"><?php if ($emp_computer_training) {
                                                                                                                                                    print $emp_computer_training;
                                                                                                                                                } ?></textarea></div>
                                        </div>

                                        <!-- training end										 -->
                                    </div>

                                    <div class="tabcontent" id="content_5">
                                        <div class="row">
                                            <div class="col-md-12 heading_style">
                                                Education
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2 bgcolor_D8D8D8">Education Level</div>
                                            <div class="col-md-3 bgcolor_D8D8D8">Exam/Degree</div>
                                            <div class="col-md-1 bgcolor_D8D8D8">Major</div>
                                            <div class="col-md-4 bgcolor_D8D8D8">Institution</div>
                                            <div class="col-md-1 bgcolor_D8D8D8">Year</div>
                                            <div class="col-md-1 bgcolor_D8D8D8">Results</div>
                                        </div>
                                        <?php if ($emp_education_level_1) { ?>
                                            <div class="row">
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_education_level_1['name'] ?>" />
                                                </div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_degree_1" id="emp_education_degree_1" value="<?php if ($emp_education_degree_1) {
                                                                                                                                                                                                                echo $emp_education_degree_1;
                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_major_1" id="emp_education_major_1" value="<?php if ($emp_education_major_1) {
                                                                                                                                                                                                            echo $emp_education_major_1;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_institute_1" id="emp_education_institute_1" value="<?php if ($emp_education_institute_1) {
                                                                                                                                                                                                                    echo $emp_education_institute_1;
                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_year_1" id="emp_education_year_1" onkeypress="return isNumber(event);" value="<?php if ($emp_education_year_1) {
                                                                                                                                                                                                                                                echo $emp_education_year_1;
                                                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_results_1" id="emp_education_results_1" value="<?php if ($emp_education_results_1) {
                                                                                                                                                                                                                echo $emp_education_results_1;
                                                                                                                                                                                                            } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_education_level_2) { ?>
                                            <div class="row">
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_education_level_2['name'] ?>" />
                                                </div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_degree_2" id="emp_education_degree_2" value="<?php if ($emp_education_degree_2) {
                                                                                                                                                                                                                echo $emp_education_degree_2;
                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_major_2" id="emp_education_major_2" value="<?php if ($emp_education_major_2) {
                                                                                                                                                                                                            echo $emp_education_major_2;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_institute_2" id="emp_education_institute_2" value="<?php if ($emp_education_institute_2) {
                                                                                                                                                                                                                    echo $emp_education_institute_2;
                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_year_2" id="emp_education_year_2" onkeypress="return isNumber(event);" value="<?php if ($emp_education_year_2) {
                                                                                                                                                                                                                                                echo $emp_education_year_2;
                                                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_results_2" id="emp_education_results_2" value="<?php if ($emp_education_results_2) {
                                                                                                                                                                                                                echo $emp_education_results_2;
                                                                                                                                                                                                            } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_education_level_3) { ?>
                                            <div class="row">
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_education_level_3['name'] ?>" />
                                                </div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_degree_3" id="emp_education_degree_3" value="<?php if ($emp_education_degree_3) {
                                                                                                                                                                                                                echo $emp_education_degree_3;
                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_major_3" id="emp_education_major_3" value="<?php if ($emp_education_major_3) {
                                                                                                                                                                                                            echo $emp_education_major_3;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_institute_3" id="emp_education_institute_3" value="<?php if ($emp_education_institute_3) {
                                                                                                                                                                                                                    echo $emp_education_institute_3;
                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_year_3" id="emp_education_year_3" onkeypress="return isNumber(event);" value="<?php if ($emp_education_year_3) {
                                                                                                                                                                                                                                                echo $emp_education_year_3;
                                                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_results_3" id="emp_education_results_3" value="<?php if ($emp_education_results_3) {
                                                                                                                                                                                                                echo $emp_education_results_3;
                                                                                                                                                                                                            } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_education_level_4) { ?>
                                            <div class="row">
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_education_level_4['name'] ?>" />
                                                </div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_degree_4" id="emp_education_degree_4" value="<?php if ($emp_education_degree_4) {
                                                                                                                                                                                                                echo $emp_education_degree_4;
                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_major_4" id="emp_education_major_4" value="<?php if ($emp_education_major_4) {
                                                                                                                                                                                                            echo $emp_education_major_4;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_institute_4" id="emp_education_institute_4" value="<?php if ($emp_education_institute_4) {
                                                                                                                                                                                                                    echo $emp_education_institute_4;
                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_year_4" id="emp_education_year_4" onkeypress="return isNumber(event);" value="<?php if ($emp_education_year_4) {
                                                                                                                                                                                                                                                echo $emp_education_year_4;
                                                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_results_4" id="emp_education_results_4" value="<?php if ($emp_education_results_4) {
                                                                                                                                                                                                                echo $emp_education_results_4;
                                                                                                                                                                                                            } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_education_level_5) { ?>
                                            <div class="row">
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_education_level_5['name'] ?>" />
                                                </div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_degree_5" id="emp_education_degree_5" value="<?php if ($emp_education_degree_5) {
                                                                                                                                                                                                                echo $emp_education_degree_5;
                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_major_5" id="emp_education_major_5" value="<?php if ($emp_education_major_5) {
                                                                                                                                                                                                            echo $emp_education_major_5;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_institute_5" id="emp_education_institute_5" value="<?php if ($emp_education_institute_5) {
                                                                                                                                                                                                                    echo $emp_education_institute_5;
                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_year_5" id="emp_education_year_5" onkeypress="return isNumber(event);" value="<?php if ($emp_education_year_5) {
                                                                                                                                                                                                                                                echo $emp_education_year_5;
                                                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_education_results_5" id="emp_education_results_5" value="<?php if ($emp_education_results_5) {
                                                                                                                                                                                                                echo $emp_education_results_5;
                                                                                                                                                                                                            } ?>" /></div>
                                            </div>
                                        <?php } ?>


                                        <div class="row">
                                            <div class="col-md-12 heading_style">
                                                Language
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 bgcolor_D8D8D8">Language</div>
                                            <div class="col-md-2 bgcolor_D8D8D8">Reading</div>
                                            <div class="col-md-2 bgcolor_D8D8D8">Writing</div>
                                            <div class="col-md-2 bgcolor_D8D8D8">Speaking</div>
                                            <div class="col-md-3 bgcolor_D8D8D8">Listening</div>
                                        </div>
                                        <?php if ($emp_language_name_1) { ?>
                                            <div class="row">
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_language_name_1; ?>">
                                                </div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_language_reading_1; ?>">
                                                </div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_language_writing_1; ?>">
                                                </div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_language_speaking_1; ?>">
                                                </div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_language_listening_1; ?>">
                                                </div>
                                            </div>
                                        <?php }
                                        if ($emp_language_name_2) { ?>
                                            <div class="row">
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_language_name_2; ?>">
                                                </div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_language_reading_2; ?>">
                                                </div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_language_writing_2; ?>">
                                                </div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_language_speaking_2; ?>">
                                                </div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_language_listening_2; ?>">
                                                </div>
                                            </div>
                                        <?php }
                                        if ($emp_language_name_3) { ?>
                                            <div class="row">
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_language_name_3; ?>">
                                                </div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_language_reading_3; ?>">
                                                </div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_language_writing_3; ?>">
                                                </div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_language_speaking_3; ?>">
                                                </div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_language_listening_3; ?>">
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <div class="tabcontent" id="content_8">
                                        <div class="row">
                                            <div class="col-md-12 heading_style">
                                                References
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2 bgcolor_D8D8D8">Name</div>
                                            <div class="col-md-2 bgcolor_D8D8D8">Position</div>
                                            <div class="col-md-2 bgcolor_D8D8D8">Organization</div>
                                            <div class="col-md-2 bgcolor_D8D8D8">Address</div>
                                            <div class="col-md-2 bgcolor_D8D8D8 custom_width_10666667">Phone</div>
                                            <div class="col-md-1 bgcolor_D8D8D8 custom_width_13666667">Email</div>
                                            <div class="col-md-1 bgcolor_D8D8D8">Relation</div>
                                        </div>
                                        <?php if ($emp_reference_name_1) { ?>
                                            <div class="row">
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_name_1" id="emp_reference_name_1" value="<?php if ($emp_reference_name_1) {
                                                                                                                                                                                                            echo $emp_reference_name_1;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_position_1" id="emp_reference_position_1" value="<?php if ($emp_reference_position_1) {
                                                                                                                                                                                                                    echo $emp_reference_position_1;
                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_org_1" id="emp_reference_org_1" value="<?php if ($emp_reference_org_1) {
                                                                                                                                                                                                        echo $emp_reference_org_1;
                                                                                                                                                                                                    } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_address_1" id="emp_reference_address_1" value="<?php if ($emp_reference_address_1) {
                                                                                                                                                                                                                echo $emp_reference_address_1;
                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-2 custom_width_10666667" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_phone_1" id="emp_reference_phone_1" value="<?php if ($emp_reference_phone_1) {
                                                                                                                                                                                                                                    echo $emp_reference_phone_1;
                                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-1 custom_width_13666667" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_email_1" id="emp_reference_email_1" value="<?php if ($emp_reference_email_1) {
                                                                                                                                                                                                                                    echo $emp_reference_email_1;
                                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" name="emp_reference_relation_1" id="emp_reference_relation_1" value="<?php if ($emp_reference_relation_1) {
                                                                                                                                                echo $emp_reference_relation_1;
                                                                                                                                            } ?>" />
                                                </div>
                                            </div>
                                        <?php }
                                        if ($emp_reference_name_2) { ?>
                                            <div class="row">
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_name_2" id="emp_reference_name_2" value="<?php if ($emp_reference_name_2) {
                                                                                                                                                                                                            echo $emp_reference_name_2;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_position_2" id="emp_reference_position_2" value="<?php if ($emp_reference_position_2) {
                                                                                                                                                                                                                    echo $emp_reference_position_2;
                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_org_2" id="emp_reference_org_2" value="<?php if ($emp_reference_org_2) {
                                                                                                                                                                                                        echo $emp_reference_org_2;
                                                                                                                                                                                                    } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_address_2" id="emp_reference_address_2" value="<?php if ($emp_reference_address_2) {
                                                                                                                                                                                                                echo $emp_reference_address_2;
                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-2 custom_width_10666667" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_phone_2" id="emp_reference_phone_2" value="<?php if ($emp_reference_phone_2) {
                                                                                                                                                                                                                                    echo $emp_reference_phone_2;
                                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-1 custom_width_13666667" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_email_2" id="emp_reference_email_2" value="<?php if ($emp_reference_email_2) {
                                                                                                                                                                                                                                    echo $emp_reference_email_2;
                                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_relation_2" id="emp_reference_relation_2" value="<?php if ($emp_reference_relation_2) {
                                                                                                                                                                                                                    echo $emp_reference_relation_2;
                                                                                                                                                                                                                } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_reference_name_3) { ?>
                                            <div class="row">
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_name_3" id="emp_reference_name_3" value="<?php if ($emp_reference_name_3) {
                                                                                                                                                                                                            echo $emp_reference_name_3;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_position_3" id="emp_reference_position_3" value="<?php if ($emp_reference_position_3) {
                                                                                                                                                                                                                    echo $emp_reference_position_3;
                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_org_3" id="emp_reference_org_3" value="<?php if ($emp_reference_org_3) {
                                                                                                                                                                                                        echo $emp_reference_org_3;
                                                                                                                                                                                                    } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_address_3" id="emp_reference_address_3" value="<?php if ($emp_reference_address_3) {
                                                                                                                                                                                                                echo $emp_reference_address_3;
                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-2 custom_width_10666667" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_phone_3" id="emp_reference_phone_3" value="<?php if ($emp_reference_phone_3) {
                                                                                                                                                                                                                                    echo $emp_reference_phone_3;
                                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-1 custom_width_13666667" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_email_3" id="emp_reference_email_3" value="<?php if ($emp_reference_email_3) {
                                                                                                                                                                                                                                    echo $emp_reference_email_3;
                                                                                                                                                                                                                                } ?>" /></div>
                                                <div class="col-md-1" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_reference_relation_3" id="emp_reference_relation_3" value="<?php if ($emp_reference_relation_3) {
                                                                                                                                                                                                                    echo $emp_reference_relation_3;
                                                                                                                                                                                                                } ?>" /></div>
                                            </div>
                                        <?php } ?>

                                        <div class="row">
                                            <div class="col-md-12 heading_style">
                                                Dependents
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 bgcolor_D8D8D8">Name</div>
                                            <div class="col-md-2 bgcolor_D8D8D8">Date of Birth</div>
                                            <div class="col-md-3 bgcolor_D8D8D8">Relation</div>
                                            <div class="col-md-3 bgcolor_D8D8D8">Nominee Type</div>
                                        </div>
                                        <?php if ($emp_dependent_name_1) { ?>
                                            <div class="row">
                                                <div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_name_1" id="emp_dependent_name_1" value="<?php if ($emp_dependent_name_1) {
                                                                                                                                                                                                            echo $emp_dependent_name_1;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_dependent_dob_1" id="emp_dependent_dob_1" value="<?php if ($emp_dependent_dob_1) {
                                                                                                                                                                                                                                                                echo $emp_dependent_dob_1;
                                                                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_dependent_relation_1['name']; ?>" />

                                                </div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_nomtype_1" id="emp_dependent_nomtype_1" value="<?php if ($emp_dependent_nomtype_1) {
                                                                                                                                                                                                                echo $emp_dependent_nomtype_1;
                                                                                                                                                                                                            } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_dependent_name_2) { ?>
                                            <div class="row">
                                                <div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_name_2" id="emp_dependent_name_2" value="<?php if ($emp_dependent_name_2) {
                                                                                                                                                                                                            echo $emp_dependent_name_2;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_dependent_dob_2" id="emp_dependent_dob_2" value="<?php if ($emp_dependent_dob_2) {
                                                                                                                                                                                                                                                                echo $emp_dependent_dob_2;
                                                                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_dependent_relation_2['name']; ?>" />
                                                </div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_nomtype_2" id="emp_dependent_nomtype_2" value="<?php if ($emp_dependent_nomtype_2) {
                                                                                                                                                                                                                echo $emp_dependent_nomtype_2;
                                                                                                                                                                                                            } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_dependent_name_3) { ?>
                                            <div class="row">
                                                <div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_name_3" id="emp_dependent_name_3" value="<?php if ($emp_dependent_name_3) {
                                                                                                                                                                                                            echo $emp_dependent_name_3;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_dependent_dob_3" id="emp_dependent_dob_3" value="<?php if ($emp_dependent_dob_3) {
                                                                                                                                                                                                                                                                echo $emp_dependent_dob_3;
                                                                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_dependent_relation_3['name']; ?>" />
                                                </div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_nomtype_3" id="emp_dependent_nomtype_3" value="<?php if ($emp_dependent_nomtype_3) {
                                                                                                                                                                                                                echo $emp_dependent_nomtype_3;
                                                                                                                                                                                                            } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_dependent_name_4) { ?>
                                            <div class="row">
                                                <div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_name_4" id="emp_dependent_name_4" value="<?php if ($emp_dependent_name_4) {
                                                                                                                                                                                                            echo $emp_dependent_name_4;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_dependent_dob_4" id="emp_dependent_dob_4" value="<?php if ($emp_dependent_dob_4) {
                                                                                                                                                                                                                                                                echo $emp_dependent_dob_4;
                                                                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_dependent_relation_4['name']; ?>" />
                                                </div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_nomtype_4" id="emp_dependent_nomtype_4" value="<?php if ($emp_dependent_nomtype_4) {
                                                                                                                                                                                                                echo $emp_dependent_nomtype_4;
                                                                                                                                                                                                            } ?>" /></div>
                                            </div>
                                        <?php }
                                        if ($emp_dependent_name_5) { ?>
                                            <div class="row">
                                                <div class="col-md-4" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_name_5" id="emp_dependent_name_5" value="<?php if ($emp_dependent_name_5) {
                                                                                                                                                                                                            echo $emp_dependent_name_5;
                                                                                                                                                                                                        } ?>" /></div>
                                                <div class="col-md-2" style="padding-right: 2px;  padding-left: 2px;"><input type="text" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" name="emp_dependent_dob_5" id="emp_dependent_dob_5" value="<?php if ($emp_dependent_dob_5) {
                                                                                                                                                                                                                                                                echo $emp_dependent_dob_5;
                                                                                                                                                                                                                                                            } ?>" /></div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;">
                                                    <input type="text" value="<?php echo $emp_dependent_relation_5['name']; ?>" />
                                                </div>
                                                <div class="col-md-3" style="padding-right: 2px;  padding-left: 2px;"><input type="text" name="emp_dependent_nomtype_5" id="emp_dependent_nomtype_5" value="<?php if ($emp_dependent_nomtype_5) {
                                                                                                                                                                                                                echo $emp_dependent_nomtype_5;
                                                                                                                                                                                                            } ?>" /></div>
                                            </div>
                                        <?php } ?>

                                    </div>
                                    <div class="tabcontent" id="content_9">
                                        <div class="row">
                                            <div class="col-md-12 heading_style presentsalry_heading">
                                                Present Salary
                                            </div>



                                        </div>
                                        <div id="salary_area">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Basic Salary</div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="emp_basic_salary" id="emp_basic_salary" onkeypress="return isNumber(event);" value="<?php if ($emp_basic_salary) {
                                                                                                                                                                                echo $emp_basic_salary;
                                                                                                                                                                            } ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Medical Allowance</div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="emp_medical_allowance" id="emp_medical_allowance" onkeypress="return isNumber(event);" value="<?php if ($emp_medical_allowance) {
                                                                                                                                                                                        echo $emp_medical_allowance;
                                                                                                                                                                                    } ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Telephone Allowance</div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="emp_telephone_allowance" id="emp_telephone_allowance" onkeypress="return isNumber(event);" value="<?php if ($emp_telephone_allowance) {
                                                                                                                                                                                            echo $emp_telephone_allowance;
                                                                                                                                                                                        } ?>" />
                                                        </div>
                                                    </div>
                                                    <!--
                                                        <div class="row">
                                                                <div class="col-md-4 bgcolor_D8D8D8" style="font-size: 11px;">Provident/Welfare Fund</div>
                                                                <div class="col-md-8">
                                                                        <input type="text" name="emp_provident_fund_allowance" id="emp_provident_fund_allowance" onkeypress="return isNumber(event);" value="<?php if ($emp_provident_fund_allowance) {
                                                                                                                                                                                                                    echo $emp_provident_fund_allowance;
                                                                                                                                                                                                                } ?>"/>        
                                                                </div>
                                                        </div>	
                                                        -->

                                                    <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Festival Bonus(%)</div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="emp_festival_bonus" id="emp_festival_bonus" onkeypress="" value="<?php if ($emp_festival_bonus) {
                                                                                                                                                            echo $emp_festival_bonus;
                                                                                                                                                        } ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">House Rent Allowan.</div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="emp_house_rent" id="emp_house_rent" onkeypress="return isNumber(event);" value="<?php if ($emp_house_rent) {
                                                                                                                                                                            echo $emp_house_rent;
                                                                                                                                                                        } ?>" />
                                                        </div>
                                                    </div>
                                                    <!--
                                                        <div class="row">
                                                                <div class="col-md-4 bgcolor_D8D8D8">Conveyance Allow.</div>
                                                                <div class="col-md-8">
                                                                        <input type="text" name="emp_conveyance" id="emp_conveyance" onkeypress="return isNumber(event);" value="<?php if ($emp_conveyance) {
                                                                                                                                                                                        echo $emp_conveyance;
                                                                                                                                                                                    } ?>"/>        
                                                                </div>
                                                        </div>	
                                                        <div class="row">
                                                                <div class="col-md-4 bgcolor_D8D8D8">Special Allowance</div>
                                                                <div class="col-md-8">
                                                                        <input type="text" name="emp_special_allowance" id="emp_special_allowance" onkeypress="return isNumber(event);" value="<?php if ($emp_special_allowance) {
                                                                                                                                                                                                    echo $emp_special_allowance;
                                                                                                                                                                                                } ?>"/>        
                                                                </div>
                                                        </div>	
                                                        -->
                                                    <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Transport Allowance</div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="emp_transport_allowance" id="emp_transport_allowance" onkeypress="return isNumber(event);" value="<?php if ($emp_transport_allowance) {
                                                                                                                                                                                            echo $emp_transport_allowance;
                                                                                                                                                                                        } ?>" />
                                                        </div>
                                                    </div>
                                                    <!--
                                                        <div class="row">
                                                                <div class="col-md-4 bgcolor_D8D8D8">Performance Bonus</div>
                                                                <div class="col-md-8">
                                                                        <input type="text" name="emp_performance_bonus" id="emp_performance_bonus" onkeypress="return isNumber(event);" value="<?php if ($emp_performance_bonus) {
                                                                                                                                                                                                    echo $emp_performance_bonus;
                                                                                                                                                                                                } ?>"/>        
                                                                </div>
                                                        </div>
                                                        -->
                                                    <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Other Allowance</div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="emp_other_allowance" id="emp_other_allowance" onkeypress="return isNumber(event);" value="<?php if ($emp_other_allowance) {
                                                                                                                                                                                    echo $emp_other_allowance;
                                                                                                                                                                                } ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Total Benifit</div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="emp_total_benifit" id="emp_total_benifit" onkeypress="return isNumber(event);" value="<?php if ($emp_total_benifit) {
                                                                                                                                                                                echo $emp_total_benifit;
                                                                                                                                                                            } ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 heading_style">
                                                Payment Deduction
                                            </div>
                                        </div>
                                        <div id="deduction_area">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8" style="font-size: 11px;">Provident/Welfare Fund</div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="emp_provident_fund_deduction" id="emp_provident_fund_deduction" onkeypress="return isNumber(event);" value="<?php if ($emp_provident_fund_deduction) {
                                                                                                                                                                                                        echo $emp_provident_fund_deduction;
                                                                                                                                                                                                    } ?>" />
                                                        </div>
                                                    </div>
                                                    <!-- 													<div class="row">
                                                                                                                                                                        <div class="col-md-4 bgcolor_D8D8D8">Loan Deduction From</div>
                                                                                                                                                                        <div class="col-md-8">
                                                                                                                                                                                <input type="text" name="emp_loan_deduction_from" id="emp_loan_deduction_from" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if ($emp_loan_deduction_from) {
                                                                                                                                                                                                                                                                                                                                    echo $emp_loan_deduction_from;
                                                                                                                                                                                                                                                                                                                                } ?>"/>        
                                                                                                                                                                        </div>
                                                                                                                                                                </div> -->
                                                    <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Tax</div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="emp_tax_deduction" id="emp_tax_deduction" onkeypress="return isNumber(event);" value="<?php if ($emp_tax_deduction) {
                                                                                                                                                                                echo $emp_tax_deduction;
                                                                                                                                                                            } ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Other Deduction</div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="emp_other_deduction" id="emp_other_deduction" onkeypress="return isNumber(event);" value="<?php if ($emp_other_deduction) {
                                                                                                                                                                                    echo $emp_other_deduction;
                                                                                                                                                                                } ?>" />
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4 bgcolor_D8D8D8">Total Deduction</div>
                                                        <div class="col-md-8">
                                                            <input type="text" name="emp_total_deduction" id="emp_total_deduction" onkeypress="return isNumber(event);" value="<?php if ($emp_total_deduction) {
                                                                                                                                                                                    echo $emp_total_deduction;
                                                                                                                                                                                } ?>" />
                                                        </div>
                                                    </div>
                                                    <!-- 													<div class="row">
                                                                                                                                                                        <div class="col-md-4 bgcolor_D8D8D8">Advance Loan</div>
                                                                                                                                                                        <div class="col-md-8">
                                                                                                                                                                                <input type="text" name="emp_advance_loan" id="emp_advance_loan" onkeypress="return isNumber(event);" value="<?php if ($emp_advance_loan) {
                                                                                                                                                                                                                                                                                                    echo $emp_advance_loan;
                                                                                                                                                                                                                                                                                                } ?>"/>        
                                                                                                                                                                        </div>
                                                                                                                                                                </div>	
                                                                                                                                                                <div class="row">
                                                                                                                                                                        <div class="col-md-4 bgcolor_D8D8D8">Loan Deduction To</div>
                                                                                                                                                                        <div class="col-md-8">
                                                                                                                                                                                <input type="text" name="emp_loan_deduction_to" id="emp_loan_deduction_to" class="datepicker numbersOnly" placeholder="dd-mm-yyyy" value="<?php if ($emp_loan_deduction_to) {
                                                                                                                                                                                                                                                                                                                                echo $emp_loan_deduction_to;
                                                                                                                                                                                                                                                                                                                            } ?>"/>        
                                                                                                                                                                        </div>
                                                                                                                                                                </div>	 -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 heading_style">
                                                Total Payment
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Gross Salary</div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="emp_gross_salary" id="emp_gross_salary" onkeypress="return isNumber(event);" value="<?php if ($emp_gross_salary) {
                                                                                                                                                                            echo $emp_gross_salary;
                                                                                                                                                                        } ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Yearly Paid</div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="emp_yearly_paid" id="emp_yearly_paid" onkeypress="return isNumber(event);" value="<?php if ($emp_yearly_paid) {
                                                                                                                                                                        echo $emp_yearly_paid;
                                                                                                                                                                    } ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 heading_style">
                                                Payment Method
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Bank</div>
                                                    <div class="col-md-8">
                                                        <input type="text" value="<?php echo $emp_bank['name']; ?>" />
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Account Number</div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="emp_bank_account" id="emp_bank_account" value="<?php if ($emp_bank_account) {
                                                                                                                                    echo $emp_bank_account;
                                                                                                                                } ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Bank Branch</div>
                                                    <div class="col-md-8">
                                                        <input type="text" name="emp_bank_branch" id="emp_bank_branch" value="<?php if ($emp_bank_branch) {
                                                                                                                                    echo $emp_bank_branch;
                                                                                                                                } ?>" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 bgcolor_D8D8D8">Pay Type</div>
                                                    <div class="col-md-8">
                                                        <input type="text" value="<?php echo $emp_pay_type['name']; ?>" />

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tabcontent" id="content_10">
                                        <div class="row">
                                            <div class="col-md-12 heading_style">
                                                Documents
                                            </div>
                                        </div>
                                        <?php if ($documents) { ?>
                                            <div class="row">
                                                <div class="col-md-12">

                                                    <ul style="list-style-type: disc;  margin-left: 20px;">
                                                        <?php
                                                        // echo "<pre>";
                                                        // print_r($documents);
                                                        // echo "</pre>";
                                                        foreach ($documents as $single_documents) {
                                                            $file_name = $single_documents['field_value'];
                                                            $file_location = $single_documents['field_name'];
                                                            $file_repeat = $single_documents['field_repeat'];
                                                            echo '<li style="margin-bottom:10px" id-hide="curr_doc_' . $file_repeat . '" class="current_doc_' . $file_repeat . '" ><input type="hidden" id="curr_doc_' . $file_repeat . '" name="curr_doc_[' . $file_repeat . ']" value=""><a href="' . base_url() . $file_location . '/' . $file_name . '" target="_blank" >' . substr($file_name, 11, -4) . '</a> </li>';
                                                        }
                                                        ?>
                                                    </ul>

                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="row">
                                            <div class="col-md-12 default-input-width">
                                                <div class="documentsdiv">

                                                    <br /><br />
                                                </div>
                                                <div class="documentsdiv">
                                                    <!-- <input name="documents[]" type="file" class="documents1" /> -->
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- /#page-content-wrapper -->






    </div>
    <!-- /#wrapper -->


</body>

</html>