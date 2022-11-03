<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS | Add Employee Performance</title>
    <?php
    $this->load->view('includes/cssjs');
    $user_type = $this->session->userdata('user_type');
    ?>
    <style>
        .panel-header {
            color: #000;
            background-color: #CCC;
            padding: 10px;
            margin-bottom: 10px;
        }

        fieldset.scheduler-border {
            border: 1px groove #ddd !important;
            padding: 1em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
            font-size: 1em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
        }

        .emp_option,
        .performance_session_option {
            border-bottom: 1px dotted #CCC;
        }

        .table-sm td {
            padding: 0px !important;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({

            });
            $(".chosen-select").chosen();
            $("#performance_session_id").change(function() {
                let performanceSessionId = $(this).val();
                if (performanceSessionId) {
                    $.ajax({

                    });
                }
            });
        });
    </script>
</head>

<body class="logged-in dashboard current-page add-division">
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <?php
            $this->load->view('includes/menu');
            date_default_timezone_set('Asia/Dhaka');
            $servertime = time();
            $today = date("d-m-Y", $servertime);
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel" style="padding: 5px; border:1px solid #ccc">
                        <div class="panel-header">
                            <h4 class="text-center">Add Employee Performance Appraisal</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7 col-sm-12">
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border">General Info.</legend>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Employee *</label>
                                                    <select name="emp_content_id" id="emp_content_id" class="form-control chosen-select" required>
                                                        <option class="emp_option" value="">--select employee--</option>
                                                        <?php foreach ($employees as $val) : ?>
                                                            <option class="emp_option" value="<?php echo $val->content_id ?>"><?php echo $val->emp_name . " | " . $val->emp_id; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Organization *</label>
                                                    <select name="emp_organization_id" id="emp_organization_id" disabled class="form-control " required>
                                                        <option class="emp_option" value="">--select organization--</option>
                                                        <?php foreach ($oranizations as $val) : ?>
                                                            <option class="emp_option" value="<?php echo $val->id ?>"><?php echo $val->name; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Division *</label>
                                                    <select name="emp_division_id" id="emp_division_id" disabled class="form-control " required>
                                                        <option class="emp_option" value="">--select division--</option>
                                                        <?php foreach ($branches as $val) : ?>
                                                            <option class="emp_option" value="<?php echo $val->id ?>"><?php echo $val->name; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Department *</label>
                                                    <select name="emp_department_id" id="emp_department_id" disabled class="form-control " required>
                                                        <option class="emp_option" value="">--select depatment--</option>
                                                        <?php foreach ($departments as $val) : ?>
                                                            <option class="emp_option" value="<?php echo $val->id ?>"><?php echo $val->name; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Designation *</label>
                                                    <select name="emp_designation_id" id="emp_designation_id" disabled class="form-control " required>
                                                        <option class="emp_option" value="">--select designation--</option>
                                                        <?php foreach ($designations as $val) : ?>
                                                            <option class="emp_option" value="<?php echo $val->id ?>"><?php echo $val->name; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Performance Session *</label>
                                                    <select name="performance_session_id" id="performance_session_id" class="form-control chosen-select" required>
                                                        <option value="">--select performance session--</option>
                                                        <?php foreach ($performance_sessions as $val) : ?>
                                                            <option class="performance_session_option" value="<?php echo $val->id ?>"><?php echo $val->performance_title; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Evaluation Period From *</label>
                                                    <input type="text" class="form-control " readonly name="" id="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Evaluation Period To *</label>
                                                    <input type="text" class="form-control " readonly name="" id="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Appraiser *</label>
                                                    <select name="appraiser_content_id" id="appraiser_content_id" class="form-control chosen-select" required>
                                                        <option class="emp_option" value="">--select appraiser--</option>
                                                        <?php foreach ($employees as $val) : ?>
                                                            <option class="emp_option" value="<?php echo $val->content_id ?>" <?php echo ($user_id == $val->emp_id) ? 'selected' : ''; ?>>
                                                                <?php echo $val->emp_name . " | " . $val->emp_id; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-5 col-sm-12">
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border">Performance Rating</legend>
                                        <table class="table ">
                                            <thead>
                                                <th>Title</th>
                                                <th>Percentage(%)</th>
                                                <th>Score</th>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($performance_ratings as $val) : ?>
                                                    <tr>
                                                        <td><?php echo $val->title . '/ ' . $val->Competencies; ?></td>
                                                        <td style="text-align:center"><?php echo $val->percentage_from . ' - ' . $val->percentage_to; ?></td>
                                                        <td style="text-align:center"><?php echo $val->score; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border">General Performance Indicators</legend>
                                        <table class="table table-sm table-striped table-bordered">
                                            <tr>
                                                <th>Title</th>
                                                <th style="text-align:center;">Weight</th>
                                                <th style="text-align:center; width:200px">Rating</th>
                                                <th style="text-align:center; width:200px">Score</th>
                                            </tr>
                                            <?php foreach ($general_performance_indicators as $key => $val) :

                                                $subIndicators = $this->db->query("SELECT * FROM performance_criteria_competency_details WHERE performance_criteria_competency_id=?", array($val->id))->result();

                                                if (count($subIndicators) > 0) {
                                            ?>
                                                    <tr>
                                                        <td colspan="4" style="font-weight:bold;font-size:15px"><?php echo ($key + 1) . '. ' . $val->competency_performance_indicator; ?></td>
                                                    </tr>
                                                    <?php
                                                    foreach ($subIndicators as $subVal) {
                                                    ?>
                                                        <tr>
                                                            <td style="padding:8px 0 0 30px!important"><?php echo $subVal->name; ?></td>
                                                            <td style="text-align:center;padding:8px 0 0 0!important"><?php echo $subVal->weight; ?></td>
                                                            <td>
                                                                <select name="rate" id="" class="form-control rate">
                                                                    <option value="">--select rate--</option>
                                                                    <?php foreach ($performance_ratings as $val) : ?>
                                                                    <option value=""><?php echo $val->title. ' ('.$val->score.')'; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </td>
                                                            <td><input type="number" name="" id="" class="" readonly></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td style="padding-left:30px"><?php echo $val->competency_performance_indicator; ?></td>
                                                        <td style="text-align:center;"><?php echo $val->weight; ?></td>
                                                        <td><select name="rate" id="" class="form-control rate">
                                                                    <option value="">--select rate--</option>
                                                                    <?php foreach ($performance_ratings as $val) : ?>
                                                                    <option value=""><?php echo $val->title. ' ('.$val->score.')'; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select></td>
                                                        <td><input type="number" name="" id="" class="" readonly></td>
                                                    </tr>
                                            <?php
                                                }
                                            endforeach; ?>
                                        </table>
                                        <p style="font-weight:bold; font-style:italic;font-size:15px">*** Total weightings must equal to 100 </p>
                                    </fieldset>
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border">Business Performance Indicators</legend>
                                        <table class="table table-sm table-striped table-bordered">
                                            <tr>
                                                <th>Deliverable Area/ Perspective</th>
                                                <th style="text-align:center;">KPI/Target</th>
                                                <th style="text-align:center;">Achievement</th>
                                                <th style="text-align:center;">Weight</th>
                                                <th style="text-align:center; width:200px">Rating</th>
                                                <th style="text-align:center; width:200px">Score</th>
                                            </tr>
                                            <?php foreach ($business_performance_indicators as $key => $val) :

                                                $subIndicators = $this->db->query("SELECT * FROM performance_criteria_business_details WHERE performance_criteria_business_id=?", array($val->id))->result();

                                                if (count($subIndicators) > 0) {
                                            ?>
                                                    <tr>
                                                        <td colspan="4" style="font-weight:bold;font-size:15px"><?php echo ($key + 1) . '. ' . $val->deliverable_area_or_perspective; ?></td>
                                                    </tr>
                                                    <?php
                                                    foreach ($subIndicators as $subVal) {
                                                    ?>
                                                        <tr>
                                                            <td style="padding:8px 0 0 30px!important"><?php echo $subVal->name; ?></td>
                                                            <td style="text-align:center;padding:8px 0 0 0!important"><?php echo $subVal->target_or_kpi; ?></td>
                                                            <td style="text-align:center;padding:8px 0 0 0!important"><?php echo $subVal->achivment; ?></td>
                                                            <td style="text-align:center;padding:8px 0 0 0!important"><?php echo $subVal->weight; ?></td>
                                                            <td>
                                                            <select name="rate" id="" class="form-control rate">
                                                                    <option value="">--select rate--</option>
                                                                    <?php foreach ($performance_ratings as $val) : ?>
                                                                    <option value=""><?php echo $val->title. ' ('.$val->score.')'; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </td>
                                                            <td><input type="number" name="" id="" class="" readonly></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td style="padding-left:30px"><strong><?php echo ($key+1).'. '.$val->deliverable_area_or_perspective ?> </strong><?php if($val->description){ echo ' ['.$val->description.']';} ?></td>
                                                        <td style="text-align:left;"><?php echo $val->target_or_kpi; ?></td>
                                                        <td style="text-align:left;"><?php echo $val->achivment; ?></td>
                                                        <td style="text-align:center;"><?php echo $val->weight; ?></td>
                                                        <td><select name="rate" id="" class="form-control rate">
                                                                    <option value="">--select rate--</option>
                                                                    <?php foreach ($performance_ratings as $val) : ?>
                                                                    <option value=""><?php echo $val->title. ' ('.$val->score.')'; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select></td>
                                                        <td><input type="number" name="" id="" class="" readonly></td>
                                                    </tr>
                                            <?php
                                                }
                                            endforeach; ?>
                                        </table>
                                        <p style="font-weight:bold; font-style:italic;font-size:15px">*** Total weightings must equal to 100 </p>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
</body>

</html>