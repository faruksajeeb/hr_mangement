<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Open A Performance Session</title>
    <?php
    $this->load->view('includes/cssjs');
    $user_type = $this->session->userdata('user_type');
    ?>
    <style>
        .panel-header {
            color: #000;
            background-color: #CCC;
            padding: 10px;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({

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
                <div class="col-md-4">
                    <div class="panel" style="padding: 5px; border:1px solid #ccc">
                        <div class="panel-header">
                            <h4 class="text-center">Create Performance Session</h4>
                        </div>
                        <hr />
                        <div class="card-body">
                            <form action="">
                                <div class="form-group">
                                    <label for="">Performance Title:</label>
                                    <input type="text" class="form-control" name="" id="">
                                </div>
                                <div class="form-group">
                                    <label for="">Evaluation Period From</label>
                                    <input type="text" class="form-control datepicker" name="" id="">
                                </div>
                                <div class="form-group">
                                    <label for="">Evaluation Period To</label>
                                    <input type="text" class="form-control datepicker" name="" id="">
                                </div>
                                <div class="form-group">
                                    <label for="">Last Date of Submission</label>
                                    <input type="text" class="form-control datepicker" name="" id="">
                                </div>
                                <div class="form-group">
                                    <label for="">Performance Criteria</label><br />
                                    <input type="checkbox" class="general" name="general" id="general"> General
                                    <input type="checkbox" class="business" name="business" id="business"> Business
                                </div>
                                <div class="form-group">
                                    <label for="">Performance Percentage(%) Ratio</label><br />
                                    <div class="row">
                                        <div class="col-md-6">
                                            General: <input type="text" class="general_percentage" name="general_percentage" id="general_percentage" placeholder="Ex: 60">
                                        </div>
                                        <div class="col-md-6">
                                            Business: <input type="text" class="business_percentage" name="business_percentage" id="business_percentage" placeholder="Ex: 40">
                                        </div>
                                    </div>


                                </div>
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea name="" id="" cols="30" rows="5" class="form-conntrol"></textarea>
                                </div>
                                <button type="submit" id="" name="" class="btn btn-sm btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="panel" style="padding: 5px; border:1px solid #ccc">
                        <div class="panel-header">
                            <h4 class="text-center">View Performance Session</h4>
                        </div>
                        <table id="example" class="display table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl no</th>
                                    <th>Performance Title</th>
                                    <th>Evaluation Period From</th>
                                    <th>Evaluation Period Till</th>
                                    <th>Last Date of Submission</th>
                                    <th>General</th>
                                    <th>Business</th>
                                    <th>General Ration Percentage</th>
                                    <th>Business Ration Percentage</th>
                                    <th>Description</th>
                                    <?php if ($user_type == 1) { ?>
                                        <th>Status</th>
                                    <?php } ?>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($records as $key => $val) : ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo $val->performance_title; ?></td>
                                        <td><?php echo $val->appraisal_period_from; ?></td>
                                        <td><?php echo $val->appraisal_period_to; ?></td>
                                        <td><?php echo $val->last_submission_date; ?></td>
                                        <td><?php echo $val->general; ?></td>
                                        <td><?php echo $val->business; ?></td>
                                        <td><?php echo $val->general_percentage; ?></td>
                                        <td><?php echo $val->business_percentage; ?></td>
                                        <td><?php echo $val->remarks; ?></td>
                                        <?php if ($user_type == 1) { ?>
                                            <td><?php echo ($val->status==1)? 'active':'inactive'; ?></td>
                                        <?php } ?>
                                        <td>
                                            <a href="" class="btn btn-sm btn-warning">Edit</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
</body>

</html>