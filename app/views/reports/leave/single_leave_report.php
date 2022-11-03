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
  <style>
    #example td,
    th {
      padding: 0.30em 0.20em;
      text-align: left;
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
      <div class="row ">
        <div style="border:1px solid #CCC; padding-bottom:5px" class="col-md-10 col-lg-10 col-sm-10 col-md-offset-1">
          <h3 class="text-center bg-warning" style="padding:20px; background-color:#696969; color:#FFF"> Single Leave Report </h3>
          <div class="row">
            <div class="col-md-6 col-md-offset-3">
              <form action="">
                <div class="input-group input-group " style="margin-top:5px">
                  <span class="input-group-addon" id="sizing-addon1">Employee * </span>
                  <select name="content_id" id="content_id" class="form-control-lg chosen-select">
                    <option value="">--select employee--</option>
                    <?php foreach ($employees as $val) : ?>
                      <option value="<?php echo $val->content_id; ?>"><?php echo $val->emp_name . " - " . $val->emp_id; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="input-group input-group " style="margin-top:5px">
                  <span class="input-group-addon" id="sizing-addon1">Date From *</span>
                  <input type="text" name="leave_date_from" id="leave_date_from" class="form-control date_picker" value="<?php echo date('Y-01-01') ?>" required>
                </div>
                <div class="input-group input-group " style="margin-top:5px">
                  <span class="input-group-addon" id="sizing-addon1">Date To *</span>
                  <input type="text" name="leave_date_to" id="leave_date_to" class="form-control date_picker" value="<?php echo date('Y-m-d') ?>" required>
                </div>
                <div class="input-group input-group " style="margin-top:5px">
                  <div class="input-group-btn">
                    <!-- Buttons -->
                    <button class="btn btn-primary " id="btn_generate">Generate Report <span class="glyphicon glyphicon-arrow-right"> </span> </button>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <div id="loader" style="text-align:center; display:none;">
            <div>Please be patient, report is being processed.</div>
            <img src="<?php echo base_url() ?>resources/images/200.gif" alt="Loading..." width="100" />
            <!-- Start Report -->
          </div>
          <a class="btn btn-default pull-left " id="printButton" href="#" style="display:none" onclick="PrintDiv();"><span class="glyphicon glyphicon-print"> Print</span></a>
          <a class="btn btn-success pull-right exportToExcel" id="exportButton" href="#" style="display:none" onclick="Export();"><span class="glyphicon glyphicon-file ">Export</span></a>

          <div id="display_report">


            <!-- End Report -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /#page-content-wrapper -->
  </div>
  <script>
    $(document).ready(function() {
      $(".chosen-select").chosen();
      $(".date_picker").datepicker({
        dateFormat: "yy-mm-dd"
      });
      var url_prefix = "<?php echo site_url(); ?>";

      $('#btn_generate').on('click', function(e) {
        e.preventDefault();
        var content_id = $('#content_id').val();
        var leave_date_from = $('#leave_date_from').val();
        var leave_date_to = $('#leave_date_to').val();
        if (!content_id || !leave_date_from || !leave_date_to) {
          alert('Please fill out the required fildes *.');
        } else {
          //show the loading div here
          $('#display_report').hide("fade", "fast");
          $("#loader").show("fade", "slow");
          $.ajax({
            url: url_prefix + "single_leave_report",
            dataType: 'html',
            type: 'POST',
            data: {
              content_id: content_id,
              leave_date_from: leave_date_from,
              leave_date_to: leave_date_to
            }
          }).done(function(data) {
            if (data != 'no_data_found') {
              $("#printButton").show("fade", "fast");
              $("#exportButton").show("fade", "fast");
            } else if (data == 'no_data_found') {
              $("#printButton").hide("fade", "fast");
              $("#exportButton").hide("fade", "fast");
              data = '<h1 class="text-center">No data found.</h1>';
            }
            $("#display_report").html(data);
            $('#display_report').show("fade", "fast");
            $("#loader").hide("fade", "fast");

          });
        }

      });
      $(".exportToExcel").click(function(e) {
        var table = $('#table2excel');
        console.log(table);
        if (table && table.length) {
          var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);

          $(table).table2excel({
            exclude: ".noExl",
            name: "Single Leave Report",
            filename: "Single_leave_report_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
            fileext: ".xls",
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true,
            preserveColors: preserveColors
          });
        }
      });
    });

    function validate() {
      var valid = true;
      var msg = "<ul>";
      if (document.myForm.emp_attendance_start_date.value == "") {
        if (valid) { //only receive focus if its the first error
          document.myForm.emp_attendance_start_date.focus();
          document.myForm.emp_attendance_start_date.style.border = "solid 1px red";
          msg += "<li>You need to fill the emp_attendance_start_date field!</li>";
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

    function PrintDiv() {
      var divToPrint = document.getElementById('display_report');
      var popupWin = window.open('', '_blank', 'width=800,height=auto');
      popupWin.document.open();
      var a = '<div style="width="100%; margin:0 auto;display:block;">\n\
        <div style="float:left;width:100%;text-align:right;">\n\
    \n\
    </div>\n\
    <div class="" style="line-height:40px;text-align: center;font-size:20px;color:black;font-weight:bold;text-decoration:underline;"> \n\
    <span style="padding-left:8px;font-family:Verdana, Geneva, sans-serif">Single Leave Report <br><?php print $nowbigmonth; ?></span>' +
        '</div>\n\
    </div><br>';
      popupWin.document.write('<html><head><title>Single Leave Report </title>\n\
    \n\
    \n\
    \n\
    \n\
    <style> body{ text-align:center;font-size:15px;margin:0 auto;}table{margin:0 auto;}table, th, td {padding-left:5px;padding-right:5px;font-size:10px;border: 1px solid black; border-collapse: collapse;}th{background: #DCDCDC; border-top:2px solid #000;} tr:nth-child(even) {background: #DCDCDC }tr:nth-child(odd) {background: #FFF}</style>\n\
                      \n\
    \n\
    \n\
    \n\
    \n\
    </head><body onload="window.print()">' + a + divToPrint.innerHTML + '</html>');
      popupWin.document.close();
    }
  </script>
  <!-- /#wrapper -->
</body>

</html>