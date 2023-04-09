<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HRMS || Attendance Summary</title>
  <?php
  $this->load->view('includes/cssjs');
  date_default_timezone_set('Asia/Dhaka');
  $servertime = time();
  $today_date = date("d-m-Y", $servertime);
  ?>



  <style>
    #example td,
    th {
      padding: 0.30em 0.20em;
      text-align: left;
    }

    .label {
      font-size: 17px;
      color: #000;
    }

    .red-color {
      color: red;
    }

    .blue-color {
      color: #210EFF;
      /*background-color: #84B3D0;*/
      font-weight: bold;
    }
  </style>
</head>

<body class="logged-in dashboard current-page add-attendance">
  <!-- Page Content -->
  <div id="page-content-wrapper">
    <div class="container-fluid">
      <?php
      date_default_timezone_set('Asia/Dhaka');
      $servertime = time();
      $now = date("d-m-Y H:i:s", $servertime);
      $this->load->view('includes/menu');
      $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
      $last_day_this_month  = date('t-m-Y');
      $today = date("d-m-Y", $servertime);
      ?>

      <div class="wrapper">
        <div class="row">
          <div class="col-md-12">
            <div class="row success-err-sms-area">
              <div class="col-md-12">
                <input type="hidden" name="attendance_id" id="attendance_id" value="<?php print $id; ?>">
                <div id="errors"></div>
                <?php
                print $this->session->flashdata('errors');
                print $this->session->flashdata('success');
                ?>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-md-offset-3" style="background-color:#F0E68C; border-radius:5px; padding:0px">
                <!-- <form action="<?php echo base_url(); ?>savepdf/monthlyAttendanceSummaryReports" method="post" onSubmit="return validate();" target="_blank" class="myForm" id="myForm" name="myForm" enctype="multipart/form-data"> -->
                <form action="" method="post" onSubmit="return validate();" target="_blank" class="myForm" id="myForm" name="myForm" enctype="multipart/form-data">

                  <div class="card" style="border:1px solid #F0E68C">
                    <div class="card-header" style="background-color: #FFF;padding:15px;color:#BDB76B;font-weight:bold;text-shadow: 1px 1px #000">
                      <div class="crad-title ">
                        <h3 class="text-center">Monthly Attendance Summary Report</h3>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <label class="pull-right"> <span style="color:red">*</span> Fields are required.</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-3 bgcolor_D8D8D8 label">Company: <span style="color:red">*</span> :</div>
                        <div class="col-md-9">
                          <select name="emp_division" id="emp_division" class="input-lg form-control">
                            <?php
                            foreach ($companies as $val) :
                              echo '<option value="' . $val->tid . '">' . $val->name . '</option>';
                            endforeach;
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-3  bgcolor_D8D8D8 label">Division/ Branch <span style="color:red">*</span> : </div>
                        <div class="col-md-9">
                          <select name="emp_department" id="emp_department" class="input-lg form-control">
                            <!-- <option value="">All</option> -->
                            <option value="">Select Company First</option>
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
                      <div class="row">

                        <div class="col-md-3 bgcolor_D8D8D8 label">Date Range <span style="color:red">*</span> :</div>
                        <div class="col-md-9">
                          <!--   <input type="text" name="emp_attendance_start_date"  class="datepicker numbersOnly form-control" id="emp_attendance_start_date" value="<?php print $first_day_this_month;  ?>" placeholder="dd-mm-yyyy"> -->
                          <div class="input-daterange input-group" id="datepicker">
                            <input type="text" class="input-lg  form-control date_picker" name="emp_attendance_start_date" id="emp_attendance_start_date" value="<?php print $first_day_this_month;  ?>" placeholder="dd-mm-yyyy" />
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-lg  form-control date_picker" name="emp_attendance_end_date" id="emp_attendance_end_date" value="<?php print $last_day_this_month;  ?>" placeholder="dd-mm-yyyy" />
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-3 bgcolor_D8D8D8 label"> Format <span style="color:red">*</span>:</div>
                        <div class="col-md-9">
                          <select name="report_format" id="report_format" class="input-lg form-control">
                            <option value="excel">Excel</option>
                            <option value="pdf">PDF</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer" style="background-color: #FFF;padding: 10px;">
                      <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                          <input type="submit" name="add_attendance_btn" id="add_attendance_btn" class="input-lg form-control btn btn-lg btn-primary" value="Generate Report">
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <br>
            <br>
            <br>
            <br>
            <br>
          </div>
        </div>
      </div>
    </div>
    <!-- /#page-content-wrapper -->
  </div>
  <!-- /#wrapper -->
  <script>
    $(document).ready(function() {
      $(".date_picker").datepicker({
        dateFormat: "dd-mm-yy"
      });
      //$("input[type=submit]").attr("disabled", "disabled");
      var companyId = 11; // IIDFC Company ID
      $("select#emp_division").val(companyId).trigger('change');
          dependableBranch(companyId);
      $("#emp_division").change(function(e) {
        var companyId = $(this).val();
        dependableBranch(companyId);
      });

      $("#emp_department").change(function(e) {
        var divisionId = $(this).val();

        if (divisionId != '') {
          $("input[type=submit]").removeAttr("disabled");
        } else {
          $("input[type=submit]").attr("disabled", "disabled");
        }
      });

      function dependableBranch(companyId) {
        var base_url = '<?php echo base_url(); ?>';
        $.ajax({
          type: "POST",
          url: "" + base_url + "addprofile/getdepartmentidbydivisionid",
          data: {
            "division_tid": companyId
          },
          dataType: 'json',
          success: function(data) {
            //             alert(data);
            var options = "";
            options += '<option value="">Select Division/Branch</option>';
            $(data).each(function(index, item) {
              options += '<option value="' + item.tid + '">' + item.name + '</option>';
            });
            $('#emp_department').html(options);
          }
        });
      }
    });
  </script>
</body>

</html>