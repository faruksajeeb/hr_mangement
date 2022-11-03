<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS | Create Salary Grade</title>
    <!--chosen-->
    <?php
    $this->load->view('includes/cssjs');
    $userId =  $this->session->userdata('user_id');

    $userDivision =  $this->session->userdata('user_division');
    $userDepartment =  $this->session->userdata('user_department');
    ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.form.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#loader").hide();
            setTimeout(function() {
                // $("#errors").hide("slide", {direction: "up" }, "slow"); 
                $(".alert").hide("slide", {
                    direction: "up"
                }, "slow");

            }, 9000);
        });
    </script>
    <style>
        input.largerCheckbox {
            width: 25px;
            height: 25px;
        }

        td {
            vertical-align: middle !important;
            padding: 0!important;
        }

        label {
            margin-top: 7px;
        }
        input[type='checkbox'][readonly]{
            pointer-events: none;
        }
        select[readonly] {
            background: #eee; /*Simular campo inativo - Sugestão @GabrielRodrigues*/
            pointer-events: none;
            /* touch-action: none; */
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
                <div class="row">
                    <div class="col-md-12 col-xs-12 ">
                        <h3> <?php if (isset($gradeData)){ echo "Edit";}else{ echo "Create";} ?> Grade
                            <a href="<?php echo site_url('manage-grade'); ?>" class="btn btn-md p-2 m-2 btn-warning pull-right"> <i class="fa fa-list"></i> Manage Grade</a>
                        </h3>
                        <br />
                        <!-- <a href="" class="btn btn-md p-2 m-2 btn-warning pull-right" data-toggle="modal" data-target="#addSalary"> <i class="fa fa-plus"></i> Add Grade</a> -->
                        <form id="add_grade" action="<?php echo site_url('create-grade')?>" method="POST">
                        <?php if (isset($gradeData)) : ?>
                            <input type="hidden" value="<?php echo $gradeData->id; ?>" name="edit_id" />
                            <?php endif; ?>
                        <div class="row">
                                <div class="col-md-5">
                                    <?php if (validation_errors()) : ?>
                                        <div class="alert alert-danger">
                                            <?php echo validation_errors(); ?>
                                        </div>
                                    <?php endif; ?>
                                    

                                    <div class="form-group">
                                        <label for="gradeName">Grade Name</label>
                                        <input type="text" class="form-control" id="grade_name" name="grade_name" value="<?php if (isset($gradeData)) {
                                                                                                                                echo $gradeData->grade_name;
                                                                                                                            }else{ echo set_value('grade_name'); } ?>" placeholder="Enter grade name">

                                    </div>
                                    <div class="form-group">
                                        <label for="Description">Description Name</label>
                                        <textarea name="description" id="description" cols="30" rows="5"><?php if (isset($gradeData)) {
                                                                                                                echo $gradeData->description;
                                                                                                            }else{ echo set_value('description'); } ?></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="absent_deduction_type">Absent Deduction Type*</label>
                                                <select name="absent_deduction_type" id="absent_deduction_type" class="form-control" required>
                                                    <option value="">Select One</option>
                                                    <option value="fixed" <?php if (isset($gradeData)) {
                                                                                if ($gradeData->absent_deduction_type == 'fixed') {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                            }else{ echo set_select('absent_deduction_type','fixed'); } ?>>Fixed</option>
                                                    <option value="as_per_man_day" <?php if (isset($gradeData)) {
                                                                                        if ($gradeData->absent_deduction_type == 'as_per_man_day') {
                                                                                            echo 'selected="selected"';
                                                                                        }
                                                                                    }else{ echo set_select('absent_deduction_type','as_per_man_day').'selected="selected"'; } ?>>As per man day</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" id="show_absent_deduction_amount">
                                                <label for="AbsentDeductionAmount">Absent Deduction Amount*</label>
                                                <input type="text" class="form-control" id="absent_deduction_amount" name="absent_deduction_amount" value="<?php if (isset($gradeData)) {
                                                                                                                                                                echo $gradeData->absent_deduction_fixed_amount;
                                                                                                                                                            }else{ echo set_value('absent_deduction_amount');} ?>" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="overtime_amount_type">Overtime Amount Type*</label>
                                                <select name="overtime_amount_type" id="overtime_amount_type" class="form-control" required>
                                                    <option value="">Select One</option>
                                                    <option value="fixed" <?php if (isset($gradeData)) {
                                                                                if ($gradeData->overtime_amount_type == 'fixed') {
                                                                                    echo 'selected="selected"';
                                                                                }
                                                                            }else{ echo set_select('absent_deduction_type','fixed'); } ?>>Fixed</option>
                                                    <option value="as_per_man_day" <?php if (isset($gradeData)) {
                                                                                        if ($gradeData->overtime_amount_type == 'as_per_man_day') {
                                                                                            echo 'selected="selected"';
                                                                                        }
                                                                                    }else{ echo set_select('absent_deduction_type','as_per_man_day').'selected="selected"'; } ?>>As per man day</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" id="show_overtime_rate_per_hour">
                                                <label for="OvertimeRatePerHour">Overtime Rate Per Hour*</label>
                                                <input type="text" class="form-control" id="overtime_rate_per_hour" name="overtime_rate_per_hour" value="<?php if (isset($gradeData)) {
                                                                                                                                                                echo $gradeData->overtime_rate_per_hour;
                                                                                                                                                            }else{ echo set_value('overtime_rate_per_hour');} ?>" placeholder="">
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-md-7">
                                    <h4 class="text-bold">Enarnings</h4>
                                    <table class="table table-striped table-sm">
                                        <tr style="background-color: #DCDCDC;">
                                            <th>Title</th>
                                            <th>Amount Type</th>
                                            <th></th>
                                            <th>Amount/Percentage</th>
                                        </tr>

                                        <?php

                                        if (isset($gradeData)) {
                                            foreach ($editedGradeAllowanceData as $catID => $categoriesData) {
                                                $final_edited_salary_components[$categoriesData->head_id] = $categoriesData;
                                            }
                                        }
                                        $component_amount_type = NULL;
                                        $edited_id = NULL;
                                        $fixed_amount = NULL;
                                        $percentage = NULL;
                                        $salary_details_id = NULL;
                                        $reference = NULL;
                                        foreach ($earning_heads as $key => $earn_head) :
                                            $component_amount_type = NULL;
                                            $edited_id = NULL;
                                            $fixed_amount = NULL;
                                            $percentage = NULL;
                                            $reference = NULL;

                                            if (isset($editedGradeAllowanceData)) {
                                                if (isset($final_edited_salary_components[$earn_head->id]->head_id) && $earn_head->id == $final_edited_salary_components[$earn_head->id]->head_id) {
                                                    $edited_id = $final_edited_salary_components[$earn_head->id]->head_id;
                                                    $component_amount_type = $final_edited_salary_components[$earn_head->id]->amount_type;
                                                    $fixed_amount = $final_edited_salary_components[$earn_head->id]->amount;
                                                    $percentage = $final_edited_salary_components[$earn_head->id]->percentage;
                                                    $reference = $final_edited_salary_components[$earn_head->id]->based_on_ref_if;
                                                }
                                            }

                                        ?>
                                            <tr>
                                                <td>
                                                    <?php $defaultChecked = in_array($earn_head->id,array(1,2,3,4,24)) ? 'readonly onclick="return false;" checked="checked"':'' ?>
                                                    <input  style="float:left;margin-right:5px;" class="largerCheckbox component_id" type="checkbox" name="component_id[<?php echo $key; ?>]" id="component_id_<?php echo $earn_head->id; ?>" value="<?php echo $earn_head->id; ?>" <?php echo ($edited_id) ? 'checked="checked"' : $defaultChecked; ?>  <?php echo set_checkbox('component_id['.$key.']', $earn_head->id); ?> >
                                                    <label class="" for="component_id_<?php echo $earn_head->id; ?>"><?php echo $earn_head->head_name; ?></label>

                                                </td>
                                                <td>
                                                    <?php
                                                    $based_on;
                                                    if($earn_head->id==1){
                                                        $defaultAmountType = 'fixed';
                                                    }elseif(in_array($earn_head->id,array(2,3,4,24))){
                                                        $defaultAmountType = 'based_on_other';
                                                        $based_on = 'basic';
                                                    }else{
                                                        $defaultAmountType ='';
                                                    }
                                                    ?>
                                                    <select name="salary_component_amount_type[<?php echo $key; ?>]" id="salary_component_amount_type_<?php echo $earn_head->id; ?>" class="form-control salary_component_amount_type" <?php if(in_array($earn_head->id,array(1,2,3,4,24))){ echo 'readonly';}?>>
                                                        <option value="">Select One</option>
                                                        <option value="fixed" <?php echo ($component_amount_type == 'fixed') ? 'selected="selected"' : (($defaultAmountType=='fixed') ? 'selected="selected" ' : set_select('salary_component_amount_type['.$key.']', 'fixed')); ?>>Fixed</option>
                                                        <option value="based_on_other" <?php echo ($component_amount_type == 'based_on_other') ? 'selected="selected"' : (($defaultAmountType=='based_on_other') ? 'selected="selected" ' : set_select('salary_component_amount_type['.$key.']', 'based_on_other')); ?>>Based on other heads</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="show_components" style="<?php echo (isset($reference)) ? '' : 'display:none'; ?>">
                                                        <select name="reference_id[<?php echo $key; ?>]" id="reference_id_<?php echo $earn_head->id; ?>" class="form-control  reference_id"  <?php if(in_array($earn_head->id,array(1,2,3,4,24))){ echo 'readonly';}?>>
                                                            <option value="">Select Head</option>
                                                            <?php foreach ($earning_heads as $refVal) : ?>
                                                                <option value="<?php echo $refVal->id; ?>" <?php echo (isset($reference) && $reference == $refVal->id) ? 'selected="selected"' : (($based_on=='basic' && $refVal->id==1)? 'selected="selected" ' : set_select('reference_id['.$key.']', $refVal->id)); ?>><?php echo $refVal->head_name; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                </td>
                                                <td><input type="text" class="form-control salary_component_amount" id="salary_component_amount_<?php echo $earn_head->id; ?>" name="salary_component_amount[<?php echo $key; ?>]" value="<?php if($component_amount_type){echo ($component_amount_type == 'fixed') ? set_value('salary_component_amount['.$key.']', $fixed_amount) : set_value('salary_component_amount['.$key.']', $percentage);}else{ echo $earn_head->id==1 ? 0 :'';} ?>"></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                    <h4 class="text-bold">Deductions</h4>
                                    <table class="table table-striped">
                                        <tr style="background-color: #DCDCDC;">
                                            <th>Title</th>
                                            <th>Amount Type</th>
                                            <th></th>
                                            <th>Amount/Percentage</th>
                                        </tr>

                                        <?php
                                        if (isset($gradeData)) {
                                            foreach ($editedGradeDeductionData as $catID => $categoriesData) {
                                                $final_edited_deduction_components[$categoriesData->head_id] = $categoriesData;
                                            }
                                        }
                                        $deduction_component_amount_type = NULL;
                                        $deduction_edited_id = NULL;
                                        $deduction_fixed_amount = NULL;
                                        $deduction_percentage = NULL;
                                        $deduction_salary_details_id = NULL;
                                        $deduction_reference = NULL;
                                        foreach ($deduction_heads as $key => $deduction_head) :
                                            $deduction_component_amount_type = NULL;
                                            $deduction_edited_id = NULL;
                                            $deduction_fixed_amount = NULL;
                                            $deduction_percentage = NULL;
                                            $deduction_reference = NULL;

                                            if (isset($editedGradeAllowanceData)) {
                                                if (isset($final_edited_deduction_components[$deduction_head->id]->head_id) && $deduction_head->id == $final_edited_deduction_components[$deduction_head->id]->head_id) {
                                                    $deduction_edited_id = $final_edited_deduction_components[$deduction_head->id]->head_id;
                                                    $deduction_component_amount_type = $final_edited_deduction_components[$deduction_head->id]->amount_type;
                                                    $deduction_fixed_amount = $final_edited_deduction_components[$deduction_head->id]->amount;
                                                    $deduction_percentage = $final_edited_deduction_components[$deduction_head->id]->percentage;
                                                    $deduction_reference = $final_edited_deduction_components[$deduction_head->id]->based_on_ref_if;
                                                }
                                            }
                                        ?>
                                            <tr>
                                                <td>
                                                <?php $defaultChecked = in_array($deduction_head->id,array(8)) ? 'readonly onclick="return false;" checked="checked"':'' ?>
                                                    <!-- <input style="float:left;margin-right:5px;" class="largerCheckbox component_id" type="checkbox" name="deduction_component_id[<?php echo $key; ?>]" id="component_id_<?php echo $deduction_head->id; ?>" value="<?php echo $deduction_head->id; ?>"  <?php echo ($deduction_edited_id) ? 'checked="checked"' : set_checkbox('deduction_component_id['.$key.']', $deduction_head->id); ?>  > -->
                                                    <input style="float:left;margin-right:5px;" class="largerCheckbox component_id" type="checkbox" name="deduction_component_id[<?php echo $key; ?>]" id="component_id_<?php echo $deduction_head->id; ?>" value="<?php echo $deduction_head->id; ?>"  <?php echo ($deduction_edited_id) ? 'checked="checked"' : $defaultChecked; ?>  >
                                                    <label class="" for="component_id_<?php echo $deduction_head->id; ?>"><?php echo $deduction_head->head_name; ?></label>

                                                </td>
                                                <td>
                                                <?php
                                                    $based_on;
                                                    if(in_array($deduction_head->id,array(8))){
                                                        $defaultAmountType = 'based_on_other';
                                                        $based_on = 'basic';
                                                    }else{
                                                        $defaultAmountType ='';
                                                    }
                                                    ?>
                                                    <select name="deduction_salary_component_amount_type[<?php echo $key; ?>]" class="salary_component_amount_type form-control " <?php if(in_array($deduction_head->id,array(8))){ echo 'readonly';}?>>
                                                        <option value="">Select One</option>
                                                        <option value="fixed" <?php echo ($deduction_component_amount_type == 'fixed') ? 'selected="selected"' : (($defaultAmountType=='fixed') ? 'selected="selected" ' : set_select('deduction_salary_component_amount_type['.$key.']', 'fixed')); ?>>Fixed</option>
                                                        <option value="based_on_other" <?php echo ($deduction_component_amount_type == 'based_on_other') ? 'selected="selected"' : (($defaultAmountType=='based_on_other') ? 'selected="selected" ' : set_select('deduction_salary_component_amount_type['.$key.']', 'based_on_other')); ?>>Based on other heads</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="show_components"  style="<?php echo (isset($deduction_reference)) ? '' : 'display:none'; ?>">
                                                        <select name="deduction_reference_id[<?php echo $key; ?>]" class="reference_id form-control" <?php if(in_array($deduction_head->id,array(8))){ echo 'readonly';}?>>
                                                            <option value="">Select Head</option>
                                                            <?php foreach ($earning_heads as $refVal) : ?>
                                                                <option value="<?php echo $refVal->id; ?>" <?php echo (isset($deduction_reference) && $deduction_reference == $refVal->id) ? 'selected="selected"' : (($based_on=='basic' && $refVal->id==1)? 'selected="selected" ' : set_select('deduction_reference_id['.$key.']', $refVal->id)); ?>><?php echo $refVal->head_name; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td><input type="text" class="form-control salary_component_amount" name="deduction_salary_component_amount[<?php echo $key; ?>]" value="<?php echo ($deduction_component_amount_type == 'fixed') ? set_value('deduction_salary_component_amount['.$key.']', $deduction_fixed_amount) : set_value('deduction_salary_component_amount['.$key.']', $deduction_percentage); ?>"></td>
                                            </tr>
                                        <?php endforeach; ?>

                                    </table>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-lg pull-right" style="width:300px; margin-bottom:20px" id="btn_submit"><?php if (isset($gradeData)){ echo "Save Changes";}else{ echo "Save Grade";} ?> </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!--Chosen-->
    <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.jquery.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
    <script>
        $(document).ready(function() {
            $("#absent_deduction_amount").prop('required', false);
            $("#show_overtime_rate_per_hour").hide();
            $("#show_absent_deduction_amount").hide();
            $("#overtime_rate_per_hour").prop('required', false);
            $("#absent_deduction_type").change(function() {
                var absent_deduc = $(this).find("option:selected").val();
                if (absent_deduc == 'as_per_man_day') {
                    $("#show_absent_deduction_amount").hide();
                    $("#absent_deduction_amount").prop('required', false);
                } else {
                    $("#absent_deduction_amount").prop('required', true);
                    $("#show_absent_deduction_amount").show(500);
                }
            });

            $("#absent_deduction_type").trigger('change');

            $("#overtime_amount_type").change(function() {
                var absent_deduc = $(this).find("option:selected").val();
                if (absent_deduc == 'as_per_man_day') {
                    $("#show_overtime_rate_per_hour").hide();
                    $("#overtime_rate_per_hour").prop('required', false);
                } else {
                    $("#overtime_rate_per_hour").prop('required', true);
                    $("#show_overtime_rate_per_hour").show(500);
                }
            });

            $("#overtime_amount_type").trigger('change');

            $(".allowance_amount_type").change(function() {
                var tr = $(this).parent().parent();
                var amount_type = $(this).find("option:selected").val();
                if (amount_type == 'on_request') {
                    tr.find(".allowance_amount").prop('readonly', true).prop('required', false);
                    tr.find(".allowance_amount").prop('required', false);
                } else {
                    tr.find(".allowance_amount").prop('readonly', false);
                    if (tr.find(".allowance_id").is(":checked")) {
                        tr.find(".allowance_amount").prop('required', true);
                    }
                }
            });

            // $(".allowance_id").each(function() {
            //     $(".allowance_amount_type").trigger('change');
            // });
            $(".component_id").each(function() {
                var tr = $(this).parent().parent();
                if ($(this).is(":checked")) {
                    tr.find(".salary_component_amount_type").prop('required', true);
                    tr.find(".salary_component_amount").prop('required', true);
                    var selected_value =tr.find(".salary_component_amount_type").val();
                    if (selected_value == 'based_on_other') {
                        tr.find('.show_components').show(500).find('.reference_id').prop('required', true);
                    } else {
                        tr.find('.show_components').hide().find('.reference_id').prop('required', false);
                    }
                }
                $(".salary_component_amount_type").trigger('change');
            });

            // if select checkbox of salary component then require select relevant fields
            $(".component_id").click(function() {
                var tr = $(this).parent().parent();
                if ($(this).is(":checked")) {
                    tr.find(".salary_component_amount_type").prop('required', true);
                    tr.find(".salary_component_amount").prop('required', true);
                } else {
                    tr.find(".salary_component_amount_type").prop('required', false);
                    tr.find(".salary_component_amount_type").val(null);
                    tr.find(".salary_component_amount").prop('required', false);
                    tr.find(".salary_component_amount").val(null);
                    tr.find('.show_components').hide();
                }
            });

            // if select checkbox of allowance then require select relevant fields 
            $(".allowance_id").click(function() {
                var tr = $(this).parent().parent();
                if ($(this).is(":checked")) {
                    //$(this).parent().parent().siblings().find(".allowance_amount_type").prop('required', true);
                    tr.find(".allowance_amount_type").prop('required', true);
                    tr.find(".allowance_amount").prop('required', true);
                } else {
                    tr.find(".allowance_amount_type").prop('required', false);
                    tr.find(".allowance_amount_type").val(null);
                    tr.find(".allowance_amount").prop('required', false);
                    tr.find(".allowance_amount").val(null);
                    tr.find('.show_components').hide();
                }
            });

            $('.salary_component_amount_type').change(function() {
                
                var tr = $(this).parent().parent();
                var checked_box = tr.find('.component_id');
                var checked_value = tr.find('.component_id').val();
                tr.find('.salary_component_amount').val('');
                // alert(checked_value);
                if (!checked_box.is(':checked')) {
                    $(this).val(null);
                    alert("Please Select Checkbox of this row.");
                    return false;
                }

                var selected_value = $(this).val();
                if (selected_value == 'based_on_other') {

                    tr.find('.show_components').show(500).find('.reference_id').prop('required', true);
                } else {
                    tr.find('.show_components').hide().find('.reference_id').prop('required', false);
                }
            });

            $('.reference_id').change(function() {
                var tr = $(this).parent().parent();               
                
                var ComponentsArray = [];
                var checked_value = $(this).parent().parent().parent().find('.component_id').val();
                var this_val = $(this).val();
                if (checked_value == this_val) {
                    alert("Conponent cannot be same.");
                    $(this).val(null);
                    return false;
                }
                $('.component_id:checked').each(function() {
                    var each_value = $(this).val();
                    ComponentsArray.push(each_value);
                });

                if ($.inArray(this_val, Object.values(ComponentsArray)) !== -1) {
                    // works well
                } else {
                    alert("This Compononent must check first on another row.");
                    $(this).val(null);
                    return false;
                }
            });

            $('.salary_component_amount').keyup(function() {

                var tr = $(this).parent().parent();
                var salary_component_amount = $(this).val();
                var salary_component_amount_type = tr.find('.salary_component_amount_type').val();
                //alert(salary_component_amount_type);
                if (salary_component_amount_type == 'based_on_other') {

                    if (salary_component_amount > 100) {
                        alert('Value must be lessthan or equal to 100');
                        tr.find('.salary_component_amount').val(100);
                    }
                }
            });
            $('.allowance_amount_type').change(function() {
                var tr = $(this).parent().parent();
                var checked_box = tr.find('.allowance_id');
                var checked_value = tr.find('.allowance_id').val();
                if (!checked_box.is(':checked')) {
                    $(this).val(null);
                    alert("Please Select Checkbox of this row.");
                    return false;
                }

                var selected_value = $(this).val();
                if (selected_value == 'based_on_other') {
                    tr.find('.show_components').show(500).find('.reference_id').prop('required', true);
                } else {
                    tr.find('.show_components').hide().find('.reference_id').prop('required', false);
                }
            });

            // select at least one checkbox
            $('#btn_submit').on('click', function() {
                var is_checked = false;
                var is_checked_allowance = false;
                $('.component_id').each(function() {
                    if ($(this).is(':checked')) {
                        is_checked = true;
                    }
                });
                if (!is_checked) {
                    alert('Please select at least one Salary Component!');
                    return false;
                }
                // $('.allowance_id').each(function() {
                //     if ($(this).is(':checked')) {
                //         is_checked_allowance = true;
                //     }
                // });
                // if (!is_checked_allowance) {
                //     alert('Please select at least one Celing Allowance!');
                //     return false;
                // }
            });

        });
    </script>
</body>

</html>