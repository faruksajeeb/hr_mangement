<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS | <?php echo $title; ?></title>
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


        });

        function popitup(url) {
            newwindow = window.open(url, 'name', 'height=auto,width=700px');
            //newwindow.print();
            window.onfocus = function() {
                newwindow.close();
            }
            if (window.focus) {
                newwindow.focus();
            }
            var document_focus = false;
            $(newwindow).focus(function() {
                document_focus = true;
            });
            $(newwindow).load(function() {
                // setInterval(function() { if (document_focus === true) { newwindow.close();  document_focus = false;}  }, 7000);

            });
            return false;
        }
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
                            <h4 class="text-center">Manage Employee Performance Appraisal</h4>
                        </div>
                        <div class="card-body">
                            <form action="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Employee *</label>
                                            <select name="emp_content_id" id="emp_content_id" class="form-control chosen-select">
                                                <option class="emp_option" value="">--select employee--</option>
                                                <?php foreach ($employees as $val) : ?>
                                                    <option class="emp_option" value="<?php echo $val->content_id ?>"><?php echo $val->emp_name . " | " . $val->emp_id; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Organization *</label>
                                            <select name="emp_organization_id" id="emp_organization_id" class="form-control chosen-select">
                                                <option class="emp_option" value="">--select organization--</option>
                                                <?php foreach ($oranizations as $val) : ?>
                                                    <option class="emp_option" value="<?php echo $val->id ?>"><?php echo $val->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Division *</label>
                                            <select name="emp_division_id" id="emp_division_id" class="form-control chosen-select ">
                                                <option class="emp_option" value="">--select division--</option>
                                                <?php foreach ($branches as $val) : ?>
                                                    <option class="emp_option" value="<?php echo $val->id ?>"><?php echo $val->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Department *</label>
                                            <select name="emp_department_id" id="emp_department_id" class="form-control chosen-select">
                                                <option class="emp_option" value="">--select depatment--</option>
                                                <?php foreach ($departments as $val) : ?>
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
                                            <input type="text" class="form-control datepicker" name="" id="appraisal_period_from">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Evaluation Period To *</label>
                                            <input type="text" class="form-control datepicker" name="" id="appraisal_period_to">
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
                                    <div class="col-md-12" style="text-align:center">
                                        <button type="submit" class="btn btn-primary btn-lg pull-center" style="width:300px; text-align:center ">Search</button>
                                    </div>

                                </div>
                            </form>
                            <table class="table" id="example">
                                <thead>
                                    <th>Sl no</th>
                                    <th>Employee</th>
                                    <th>Company</th>
                                    <th>Performance Session</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Appraiser</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($records as $key => $val) : ?>
                                        <tr>
                                            <td><?php echo $key + 1 ?></td>
                                            <td><?php echo $val->emp_name . '(' . $val->emp_id . ')'; ?></td>
                                            <td><?php echo $val->company_name; ?></td>
                                            <td><?php echo $val->performance_title; ?></td>
                                            <td><?php echo $val->date_from; ?></td>
                                            <td><?php echo $val->date_to; ?></td>
                                            <td><?php echo $val->appraiser_name; ?></td>
                                            <td>
                                                <a style="text-decoration: none; float: right;" onclick="return popitup('<?php echo site_url("single-employee-performance/$val->id"); ?>')" href="<?php echo site_url("single-employee-performance/$val->id"); ?>" class="operation-print-pdf operation-link btn btn-sm btn-default"> <i class="fa fa-print"> Print</i> </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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