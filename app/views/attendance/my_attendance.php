<?php
$this->load->view('includes/employee-header');
?>
<style>
    .exception_form {
        padding: 10px;
        border: 1px dotted #ccc;
        margin: 5px;
        background-color: #F5F5F5;
        border-radius: 5px
    }

    .label {
        font-weight: bold;
    }
</style>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3"> </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 exception_form">
                <h3 style="text-align:center; padding: 10px;">My Attendance</h3>
                <hr />

                <form id="my_attendacne_report_from" class="" action="" method="POST">
                    <input type="hidden" name="edit_attendance_exception_id" ID="edit_attendance_exception_id" value="<?php if ($edit_info) {
                                                                                                                            echo $edit_info->id;
                                                                                                                        } else {
                                                                                                                            echo set_value('edit_attendance_exception_id');
                                                                                                                        } ?>" />

                    <?php
                    $csrf = array(
                        'name' => $this->security->get_csrf_token_name(),
                        'hash' => $this->security->get_csrf_hash()
                    );
                    ?>
                    <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />

                    <div class="row form-group">
                        <div class="col-md-6">
                            <label class="label">Date From <span style="color:red">*</span>:</label>

                            <input value="<?php echo date('Y-m-01') ?>" class="form-control datepicker" data-date-format="yyyy-mm-dd" type="text" name="attendance_date_from" id="attendance_date_from" required />
                        </div>
                        <div class="col-md-6">
                            <label class="label">Date To <span style="color:red">*</span>:</label>
                            <input value="<?php echo date('Y-m-t') ?>" class="form-control datepicker" data-date-format="yyyy-mm-dd" type="text" name="attendance_date_to" id="attendance_date_to" required />
                        </div>

                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-info">Submit</button>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3"> 

            </div>
        </div>
        <div class="row" id="display_section">

        </div>
    </div>
</div>
<?php
$this->load->view('includes/employee-footer');
?>
<script>
            $(document).ready(function () {
                getAttendance();
                $(".datepicker").datepicker(
                        {
                            dateFormat: 'yy-mm-dd'
                        }
                );
               
            });
            $('#my_attendacne_report_from').submit(function(e){  
                                  
                    e.preventDefault();
                    getAttendance();
                });
    function getAttendance() {    
        var dateFrom = $('#attendance_date_from').val();
        var dateTo = $('#attendance_date_to').val();
        if (!dateFrom || !dateTo) {
            alert('Please select date range.');
        } else if (dateFrom && dateTo) {
            var base_url = '<?php echo base_url(); ?>';
            $.ajax({
                type: "POST",
                url: "" + base_url + "my-attendance",
                data: {
                    "date_from": dateFrom,
                    "date_to": dateTo,
                },
          dataType: 'html',
          success: function(data) {            
            $('#display_section').html(data);
          }
            });
        }else{
            alert('Something went wrong!');
        }
    }
        </script>