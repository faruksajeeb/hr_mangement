<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS- Employee Report</title>
    <?php
    $this->load->view('includes/cssjs');
    ?>
  
    <style>
        body {
            background-color: #FFF;
        }

        .short_info_div .value {
            font-size: 35px;
            padding-top: 10px
        }

        .short_info_div {
            border: 10px solid #FFFFFF;
            border-radius: 5px;
            background-color: #fe821e;
            box-shadow: -2px 2px #CCC;
            padding: 30px;
            font-size: 30px;
            color: white;
            text-align: center;
            background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.5), rgba(255, 255, 255, 0.2) 49%, rgba(0, 0, 0, 0.15) 51%, rgba(0, 0, 0, 0.05));
            background-repeat: repeat-x;
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
            <div class="row ">
                <div style="border:1px solid #CCC; padding-bottom:5px" class="col-md-10 col-lg-10 col-sm-10 col-md-offset-1">
                    <h3 class="text-center bg-warning" style="padding:20px; background-color:#696969; color:#FFF"> Yearly Employee Count </h3>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <form action="">
                                <div class="input-group input-group-lg " style="margin-top:5px">
                                    <span class="input-group-addon" id="sizing-addon1">Company * </span>
                                    <select name="company_id" id="company_id" class="form-control">
                                        <option value="">--select company--</option>
                                        <?php foreach ($companies as $val) : ?>
                                            <option value="<?php echo $val->tid; ?>|<?php echo $val->name; ?>"><?php echo $val->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="input-group input-group-lg " style="margin-top:5px">
                                    <span class="input-group-addon" id="sizing-addon1">Division/ Branch * </span>
                                    <select name="division_id" id="division_id" class="form-control">
                                        <option value="">--select company first--</option>
                                    </select>
                                </div>
                                <div class="input-group input-group-lg " style="margin-top:5px">
                                    <span class="input-group-addon" id="sizing-addon1">Date From *</span>
                                    <input type="text" name="date_from" id="date_from" class="form-control date_picker" value="<?php echo date('Y-01-01') ?>" required>
                                </div>
                               
                                <div class="input-group input-group-lg " style="margin-top:5px">
                                    <span class="input-group-addon" id="sizing-addon1">Date To *</span>
                                    <input type="text" name="date_to" id="date_to" class="form-control date_picker" value="<?php echo date('Y-m-d') ?>" required>
                                </div>
                               
                                <div class="input-group input-group-lg " style="margin-top:5px">
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
    <!-- /#wrapper -->
   
    <script>
        $(document).ready(function() {
            $(".date_picker").datepicker({
                dateFormat: "yy-mm-dd"
            });
            var url_prefix = "<?php echo site_url(); ?>";
            var company_id = '11|IIDFC Securities Limited'; // IIDFC Company ID
            $("select#company_id").val(company_id).trigger('change');
            dependableBranch(company_id);

            $("#company_id").change(function(e) {
                var company_id = $(this).val();
                dependableBranch(company_id);
            });

            function dependableBranch(company_id) {
                $.ajax({
                    url: url_prefix + "get_company_wise_branch",
                    dataType: 'html',
                    type: 'GET',
                    data: {
                        company_id: company_id
                    }
                }).done(function(data) {
                    $("#division_id").html(data);
                });
            }


            $('#btn_generate').on('click', function(e) {
                e.preventDefault();
                var company_id = $('#company_id').val();
                var division_id = $('#division_id').val();
                var date_from = $('#date_from').val();
                var date_to = $('#date_to').val();
                if (!company_id || !division_id || !date_from || !date_to) {
                    alert('Please fill out the required fildes *.');
                } else {
                  
                    //show the loading div here
                    $('#display_report').hide("fade", "fast");
                    $("#loader").show("fade", "slow");
                    $.ajax({
                        url: url_prefix + "yearly-employee-count",
                        dataType: 'html',
                        type: 'GET',
                        data: {
                            company_id: company_id,
                            division_id: division_id,
                            date_from: date_from,
                            date_to: date_to,
                        }
                    }).done(function(data) {
                        if (data != 'no_data_found') {
                            // alert(data);
                            $("#printButton").show("fade", "fast");
                            $("#exportButton").show("fade", "fast");
                        }else if (data == 'no_data_found') {
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
                        name: "Yearly Employee Count",
                        filename: "yearly_employee_count_report_" + new Date().toISOString().replace(/[\-\:\.]/g, "") + ".xls",
                        fileext: ".xls",
                        exclude_img: true,
                        exclude_links: true,
                        exclude_inputs: true,
                        preserveColors: preserveColors
                    });
                }
            });
        });

        function PrintDiv() {
            var divToPrint = document.getElementById('display_report');
            var popupWin = window.open('', '_blank', 'width=800,height=auto');
            popupWin.document.open();
            var a = '<div style="width="100%; margin:0 auto;display:block;">\n\
        <div style="float:left;width:100%;text-align:right;">\n\
    \n\
    </div>\n\
    <div class="" style="line-height:40px;text-align: center;font-size:20px;color:black;font-weight:bold;text-decoration:underline;"> \n\
    <span style="padding-left:8px;font-family:Verdana, Geneva, sans-serif">Yearly Employee Count <br><?php print $nowbigmonth; ?></span>' +
                '</div>\n\
    </div><br>';
            popupWin.document.write('<html><head><title>Yearly Employee Count </title>\n\
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

</body>

</html>