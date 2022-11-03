<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Single Leave Reports</title>
  <?php
  $this->load->view('includes/cssjs');
  date_default_timezone_set('Asia/Dhaka');
  $servertime = time();
  $today_date = date("d-m-Y", $servertime);
  ?>
  <!--chosen-->
  <link rel="stylesheet" href="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.css">
  <script>
    $(document).ready(function() {
      // Setup - add a text input to each footer cell
      jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
      });
      $("#myForm").validate({
        rules: {
          emp_name: "required",
          emp_id: "required",
          // emp_login_time: {required: true, time: true},
          // emp_logout_time: {required: true, time: true},
          emp_attendance_date: {
            required: true,
            mydate: true
          },
        },
        submitHandler: function(form) {
          // do other things for a valid form
          form.submit();
        }
      });
      $.validator.addMethod('time', function(value, element, param) {
        return /^([01]?[0-9]|2[0-3])(:[0-5][0-9]){2}$/.test(value);
      }, 'Enter a valid time: hh:mm:ss');

      $.validator.addMethod("mydate", function(value, element) {
          return value.match(/^\d\d?\-\d\d?\-\d\d\d\d$/);
        },
        "Please enter a date in the format dd-mm-yyyy"
      );
      $('#emp_name').change(function() {
        var emp_id = $("#emp_name").val();
        $('#emp_id').val(emp_id);
      });
      $('#emp_id').keyup(function() {
        var emp_id = $("#emp_id").val();
        $('#emp_name').val(emp_id);
      });
    });


    function ConfirmDelete() {
      var x = confirm("Are you sure you want to delete?");
      if (x)
        return true;
      else
        return false;
    }

    function validate() {
      var valid = true;
      var msg = "<ul>";
      if (document.myForm.emp_name.value == "") {
        if (valid) { //only receive focus if its the first error
          document.myForm.emp_name.focus();
          document.myForm.emp_name.style.border = "solid 1px red";
          msg += "<li>You need to fill the emp_name field!</li>";
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
  <style>
    #example td,
    th {
      padding: 0.30em 0.20em;
      text-align: center;
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
      $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
      $last_day_this_month  = date('t-m-Y');
      $lastdateofattendance = end($date_range);
      $nowdate = date("d-m-Y", $servertime);
      $thisyear = date("Y", $servertime);
      $datee = date_create($lastdateofattendance);
      $nowbigmonth = date_format($datee, 'F Y');
      $nowtime = date("H:i:s a", $servertime);
      $this->load->view('includes/menu');
      ?>
      <div class="row under-header-bar text-center">
        <h4>Single Leave Reports</h4>
      </div>
      <div class="wrapper">
        <div class="row">
          <div class="col-md-12">
            <form action="<?php echo base_url(); ?>reports_leave/single_leave_report" method="post" onSubmit="return validate();" class="myForm" id="myForm" name="myForm" enctype="multipart/form-data">
              <div class="row success-err-sms-area">
                <div class="col-md-12">
                  <!-- <input type="hidden" name="attendance_id" id="attendance_id" value="<?php print $id; ?>"> -->
                  <div id="errors"></div>
                  <?php
                  print $this->session->flashdata('errors');
                  print $this->session->flashdata('success');
                  ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <div class="row">
                    <div class="col-md-3 bgcolor_D8D8D8">Name</div>
                    <div class="col-md-9">
                      <select name="emp_id" id="emp_id" data-placeholder="Choose an Employee..." class="chosen-select">
                        <option value="">Select</option>
                        <?php
                        $default_emp_id = $default_emp['emp_id'];
                        foreach ($allemployee as $single_employee) {
                          $content_id = $single_employee['content_id'];
                          $emp_id = $single_employee['emp_id'];
                          $emp_name = $single_employee['emp_name'];
                          if ($default_emp_id == $emp_id) {
                            print '<option value="' . $emp_id . '" selected="selected">' . $emp_name . '-' . $emp_id . '</option>';
                          } else {
                            print '<option value="' . $emp_id . '">' . $emp_name . '-' . $emp_id . '</option>';
                          }
                        } ?>
                      </select>
                    </div>
                  </div>
                  <!--
                  <div class="row">
                    <div class="col-md-3 bgcolor_D8D8D8">Employee Code</div>
                    <div class="col-md-9"><input type="text" name="emp_id" id="emp_id" placeholder="Press TAB key after typing Emp id or select Emp Name" autocomplete="off" value="<?php if ($default_emp['emp_id']) {
                                                                                                                                                                                      echo $default_emp['emp_id'];
                                                                                                                                                                                    } ?>"/></div>
                  </div>
                    -->
                  <div class="row">
                    <div class="col-md-3 bgcolor_D8D8D8">Year:</div>
                    <div class="col-md-9"><input type="text" name="emp_attendance_start_date" class="datepicker numbersOnly" id="emp_attendance_start_date" value="<?php if ($defaultatt_date) {
                                                                                                                                                                      print $defaultatt_date;
                                                                                                                                                                    } else {
                                                                                                                                                                      print $first_day_this_month;
                                                                                                                                                                    } ?>" placeholder="dd-mm-yyyy"></div>
                  </div>
                  <div class="row top10 bottom10">
                    <div class="col-md-3"></div>
                    <div class="col-md-9"><input type="submit" name="add_attendance_btn" value="Submit"></div>
                  </div>
                </div>
                <div class="col-md-2"></div>
              </div>
            </form>
            <div class="row">
              <div class="col-md-12 text-right"><a onclick="return popitup('<?php echo site_url("savepdf/leave_single_pdf"); ?>')" href="<?php echo site_url("savepdf/leave_single_pdf"); ?>" class="operation-print-pdf operation-link"> <img src="<?php echo base_url(); ?>resources/images/pdf_icon_print.png" alt="pdf" style="width:20px;" /></a></div>
            </div>
            <div class="emp_info">
              <div class="row">
                <div class="col-md-2">Employee ID:</div>
                <div class="col-md-5"><?php print $default_emp['emp_id']; ?></div>
                <div class="col-md-2">Date:</div>
                <div class="col-md-3"><?php print $nowdate; ?></div>
              </div>
              <div class="row">
                <div class="col-md-2">Employee Name:</div>
                <div class="col-md-5"><?php print $default_emp['emp_name']; ?></div>
                <div class="col-md-2">Total Leave:</div>
                <div class="col-md-3"><?php print $emp_total_leave; ?></div>
              </div>
              <div class="row">
                <div class="col-md-2">Designation:</div>
                <div class="col-md-5"><?php
                                      $emp_post_id = $default_emp['emp_post_id'];
                                      $emp_post_id_data = $this->taxonomy->getTaxonomyBytid($emp_post_id);
                                      print $emp_post_id_data['name'];
                                      ?></div>
                <div class="col-md-2">Leave Spent:</div>
                <div class="col-md-3"><?php
                                      $total_leave_query = $this->emp_leave_model->getemp_sumleavetotal($defaultcontent_id, $defaultatt_date);
                                      if (!$total_leave_query['Totalleave']) {
                                        print "0";
                                      } else {
                                        print $total_leave_query['Totalleave'];
                                      } ?>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">Mobile No:</div>
                <div class="col-md-5"><?php print $default_emp['mobile_no']; ?></div>
                <div class="col-md-2">Total Absent:</div>
                <div class="col-md-3" style="font-size: 12px;"><?php print $total_absent; ?></div>
              </div>
              <div class="row">
                <div class="col-md-2">Joining Date:</div>
                <div class="col-md-5"><?php print $default_emp['joining_date']; ?></div>
                <div class="col-md-2">Service Length:</div>
                <div class="col-md-3" style="font-size: 12px;"><?php
                                                                $joining_date_arr = explode('-', $default_emp['joining_date']);
                                                                $joining_date_reversed = $joining_date_arr[2] . "-" . $joining_date_arr[1] . "-" . $joining_date_arr[0] . " 00:00:00";
                                                                $jo = strtotime($joining_date_reversed);
                                                                date_default_timezone_set('Asia/Dhaka');
                                                                $now = time();
                                                                $removed = timespan($jo, $now);
                                                                $pieces = explode(",", $removed);
                                                                foreach ($pieces as $key => $ll) {
                                                                  if (strpos($ll, 'Hour') !== false || strpos($ll, 'Minute') !== false) {
                                                                    unset($pieces[$key]);
                                                                  }
                                                                }
                                                                $string = rtrim(implode(',', $pieces), ',');
                                                                echo $string;
                                                                // echo substr($removed, 0, -21);
                                                                ?></div>
              </div>
              <?php
              $emp_shift_time_last = $this->emp_working_time_model->getworkingtimeBydateandid($defaultcontent_id, $lastdateofattendance);
              $work_starting_time_last = $emp_shift_time_last['work_starting_time'];
              $work_ending_time_last = $emp_shift_time_last['work_ending_time'];
              ?>
            </div>
            <style>
              .leave-total-days {
                margin-bottom: 20px;
                background-color: #A3C588;
                text-align: center;
                padding: 5px;
                font-size: 20px;
                color: #fff;
              }

              u {
                background-color: #51EA6C;
                display: inline-block;
                margin-top: 2px;
                font-size: 18px;
              }

              .float_left {
                float: right;
                background: #C4DCF0;
                color: #650707;
                margin-bottom: 2px;
              }

              .green_bg {
                background: #29B54D;
              }
            </style>
            <?php
            if ($emp_total_leave) { ?>
              <div class="row">
              </div>
              <div class="row">
                <div class="col-md-12">

                  <?php
                  $grand_total_spant = 0;
                  foreach ($allleavetype as $single_leave) {
                    $id = $single_leave['id'];
                    $leavetype = $single_leave['name'];
                    $vid = $single_leave['vid'];
                    $tid = $single_leave['tid'];
                    $description = $single_leave['description'];
                    if ($defaultcontent_id) {
                      //$total_leave=$this->emp_leave_model->getemp_yearlyleave($defaultcontent_id, $tid);
                      date_default_timezone_set('Asia/Dhaka');
                      $servertime = time();
                      $leave_year = date("Y", $servertime);
                      $total_leave_spent_query = $this->emp_leave_model->getemp_spentleave($defaultcontent_id, $tid, $defaultyear);
                      $total_leave_spent = 0;
                      $leave_spent_date = "";
                      if (count($total_leave_spent_query)) { ?>
                        <h4 class="green_bg">Leave Type: <?php print $leavetype; ?></h4>
                        <table class="eexample" class="display" cellspacing="0" width="100%" border="1">
                          <thead>
                            <tr class="heading">
                              <th>Date</th>
                              <th>Description</th>
                              <th>Total Days</th>
                            </tr>
                          </thead>

                          <tbody>
                            <?php
                            foreach ($total_leave_spent_query as $single_spent_leave) {
                              $total_leave_spent = $total_leave_spent + $single_spent_leave['leave_total_day'];
                              if ($tid != 336) {
                                $grand_total_spant = $grand_total_spant + $single_spent_leave['leave_total_day'];
                                $leave_spent_date .= "<u>" . $single_spent_leave['leave_start_date'] . "</u>, ";
                              }
                            ?>
                              <tr>
                                <td><?php print $single_spent_leave['leave_start_date']; ?></td>
                                <td><?php if ($single_spent_leave['justification']) {
                                      echo $single_spent_leave['justification'];
                                    } ?></td>
                                <td><?php if ($single_spent_leave['leave_total_day']) {
                                      echo $single_spent_leave['leave_total_day'];
                                    } ?></td>
                                <!-- <td><?php if ($available_leave_grant_total) {
                                            echo $available_leave_grant_total;
                                          } ?></td>  -->
                              </tr>
                            <?php
                            }
                            if ($tid != 336) {
                              $available_leave = $emp_total_leave - $total_leave_spent;
                              $available_leave_grant_total = $emp_total_leave - $grand_total_spant;
                            }
                            ?>
                          </tbody>
                        </table>
                        <h4 class="float_left">Total Leave: <?php print $total_leave_spent; ?> </h4>
                        <br>
                        <br>
                    <?php
                      }
                    }
                    ?>

                  <?php
                  } ?>
                </div>
              </div>
              <?php
              if ($grand_total_spant) { ?>
                <h4 class="float_left">Grand Total Leave: <?php print $grand_total_spant; ?> </h4>
              <?php  }
              ?>
              <br>
              <?php if ($available_leave_grant_total) { ?>
                <?php
                echo "<h4 class='float_left'>Total Available Days:" . $available_leave_grant_total . "</h4><br>";
                ?>
            <?php
              }
            } ?>
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
  <!--Chosen-->
  <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/chosen.jquery.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>resources/plugins/chosenSelect/docsupport/init.js" type="text/javascript" charset="utf-8"></script>

</body>

</html>