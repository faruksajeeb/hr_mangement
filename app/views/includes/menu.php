<?php

$user_id = $this->session->userdata('user_id');
$user_type = $this->session->userdata('user_type');
$user_name = $this->session->userdata('user_name');


$all_company_access = $this->users_model->getuserwisepermission("all_company_access", $user_id);

$add_daily_attendance = $this->users_model->getuserwisepermission("add_daily_attendance", $user_id);
$add_edit_profile = $this->users_model->getuserwisepermission("add_edit_profile", $user_id);
//echo $user_id;
//print_r($add_edit_profile);
//exit;
$add_employee_performance = $this->users_model->getuserwisepermission("add_employee_performance", $user_id);
$add_holiday = $this->users_model->getuserwisepermission("add_holiday", $user_id);
$add_informed = $this->users_model->getuserwisepermission("add_informed", $user_id);
$add_leave = $this->users_model->getuserwisepermission("add_leave", $user_id);
$add_log_maintenence = $this->users_model->getuserwisepermission("add_log_maintenence", $user_id);
$import_attendance = $this->users_model->getuserwisepermission("import_attendance", $user_id);
$edit_view_login_profile = $this->users_model->getuserwisepermission("edit_view_login_profile", $user_id);
$view_absent_reports_single = $this->users_model->getuserwisepermission("view_absent_reports_single", $user_id);
$view_attendance_informed_reports = $this->users_model->getuserwisepermission("view_attendance_informed_reports", $user_id);
$view_attendance_log_reports = $this->users_model->getuserwisepermission("view_attendance_log_reports", $user_id);
$view_attendance_reports_multiple = $this->users_model->getuserwisepermission("view_attendance_reports_multiple", $user_id);
$view_attendance_summery_reports = $this->users_model->getuserwisepermission("view_attendance_summery_reports", $user_id);
$view_daily_absent_reports = $this->users_model->getuserwisepermission("view_daily_absent_reports", $user_id);
$view_daily_attendance_reports = $this->users_model->getuserwisepermission("view_daily_attendance_reports", $user_id);
$view_daily_early_reports = $this->users_model->getuserwisepermission("view_daily_early_reports", $user_id);
$view_daily_late_reports = $this->users_model->getuserwisepermission("view_daily_late_reports", $user_id);
$view_daily_leave_reports = $this->users_model->getuserwisepermission("view_daily_leave_reports", $user_id);
$view_employee_list = $this->users_model->getuserwisepermission("view_employee_list", $user_id);
$view_attendance_wise_employee = $this->users_model->getuserwisepermission("view_attendance_wise_employee", $user_id);
$view_holiday_reports = $this->users_model->getuserwisepermission("view_holiday_reports", $user_id);
$view_job_history = $this->users_model->getuserwisepermission("view_job_history", $user_id);
$view_leave_summery_reports = $this->users_model->getuserwisepermission("view_leave_summery_reports", $user_id);
$view_monthly_attendance = $this->users_model->getuserwisepermission("view_monthly_attendance", $user_id);
$view_resume = $this->users_model->getuserwisepermission("view_resume", $user_id);
$view_salary_history = $this->users_model->getuserwisepermission("view_salary_history", $user_id);
$view_salary_history_multiple = $this->users_model->getuserwisepermission("view_salary_history_multiple", $user_id);
$view_salary_in_emp_list = $this->users_model->getuserwisepermission("view_salary_in_emp_list", $user_id);
$view_single_leave_reports = $this->users_model->getuserwisepermission("view_single_leave_reports", $user_id);
$create_requisition = $this->users_model->getuserwisepermission("create_requisition", $user_id);
$view_challan = $this->users_model->getuserwisepermission("view_challan", $user_id);

$tax_caculator = $this->users_model->getuserwisepermission("tax_caculator", $user_id);
$pf_statement = $this->users_model->getuserwisepermission("pf_statement", $user_id);
$add_leave_encashment = $this->users_model->getuserwisepermission("add_leave_encashment", $user_id);
$edit_leave_encashment = $this->users_model->getuserwisepermission("edit_leave_encashment", $user_id);
$view_leave_encashment = $this->users_model->getuserwisepermission("view_leave_encashment", $user_id);

if ($user_type == 1 || $user_type == 5 || $user_type == 9) {
  // Payslip Permission ----------
  $generatePayslip = $this->users_model->getuserwisepermission("genarate_pay_slip", $user_id);
  $confirmPayslip = $this->users_model->getuserwisepermission("confirm_pay_slip", $user_id);
  $checkPayslip = $this->users_model->getuserwisepermission("check_payslip", $user_id);
  $approvePayslip = $this->users_model->getuserwisepermission("approve_payslip", $user_id);
  $paymentPayslip = $this->users_model->getuserwisepermission("payment_pay_slip", $user_id);
  // Loan Permission --------------
  $addLoan = $this->users_model->getuserwisepermission("add_loan_given", $user_id);
  $addLoanRepayment = $this->users_model->getuserwisepermission("add_loan_repayment", $user_id);
  $approveLoanApplication = $this->users_model->getuserwisepermission("approve_loan_application", $user_id);
  $submitLoanApplication = $this->users_model->getuserwisepermission("submit_loan_application", $user_id);
  $manageLoan = $this->users_model->getuserwisepermission("manage_loan", $user_id);
  $addLoanType = $this->users_model->getuserwisepermission("add_loan_type", $user_id);
  $manageLoanType = $this->users_model->getuserwisepermission("manage_loan_type", $user_id);
}

$adminLeaveApplication = $this->users_model->getuserwisepermission("admin_leave_application", $user_id);
$adminDailyMovement = $this->users_model->getuserwisepermission("admin_daily_movement", $user_id);
$viewLeaveApplication = $this->users_model->getuserwisepermission("view_leave_application", $user_id);
$viewDailyMovement = $this->users_model->getuserwisepermission("view_daily_movement", $user_id);




?>
<script>
  setTimeout(function() {
    $('#myModal').modal('hide');
  }, 7000); // <-- time in milliseconds
</script>
<style>
  .display td {
    padding: 2px 10px !important;
  }
</style>
<!-- Small modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
        <h4 class="modal-title" id="exampleModalLabel"></h4>
      </div>
      <div class="modal-body">
        <h3 class="alert-heading">
          <i class="fa fa-check-square-o"></i>
          <?php
          echo "<span style='color:red' >" . validation_errors() . "</span>";
          echo $error;
          echo $this->session->userdata('add_status');
          ?>
        </h3>
      </div>
      <div class="modal-footer">
        <button type="button" style="width:100px" class="btn btn-default" data-dismiss="modal">OK</button>

      </div>
    </div>
  </div>
</div>
<div class="header-menu">
  <div class="row">
    <div class="menu-area">
      <!-- <nav class='navbar navbar-default navbar-fixed-top' style="margin-bottom:20px"> -->
      <nav class='navbar navbar-default'>
        <a class="toggleMenu" href="#"><img src="<?php echo site_url(); ?>resources/images/Mobile-icon.png" alt="" /></a>
        <!-- <ul>
                    <li><a href="<?php echo site_url('dashboard'); ?>"> Entry</a></li>
                </ul>  -->
        <ul id="menu-bar" class="nav">
          <li class="active"><a href="<?php echo site_url('dashboard'); ?>"><span class="glyphicon glyphicon-home"></span> Home</a></li>
          <?php // if ($this->session->userdata('user_type') !=6) { 
          ?>
          <!-- Entry parent menu start here -->
          <li><a href="#"><span class="glyphicon glyphicon-edit"> </span> Entry <span class="pull-right glyphicon glyphicon-menu-down"> </span></a>




            <ul>
              <?php if ($user_type == 8) { ?>
                <!-- Store -->

                <li><a href="<?php echo site_url('manage-store-category'); ?>">Category</a></li>
                <li><a href="<?php echo site_url('manage-store-brand'); ?>">Brand</a></li>
                <li><a href="<?php echo site_url('manage-store-measurement'); ?>">Unit Of Measurement</a></li>
                <li><a href="<?php echo site_url('manage-store-item'); ?>">Item</a></li>
                <li><a href="<?php echo site_url('manage-store-item'); ?>">Traders</a>
                  <ul>
                    <li><a href="<?php echo site_url('manage-store-vendor'); ?>">Vendor/ Supplier</a></li>
                    <li><a href="#">Consumer</a></li>
                  </ul>
                </li>



              <?php } ?>
              <?php if ($create_requisition['status'] == 1) { ?>
                <li><a href="<?php echo base_url(); ?>add-sales">Create Requisition</a></li>

              <?php  }
              if ($view_challan['status'] == 1) { ?>
                <li><a href="<?php echo base_url(); ?>manage-challan"> Challan </a></li>

              <?php  } ?>
              <?php if (
                $user_type == 1 || $add_edit_profile['status'] == 1 ||
                $view_employee_list['status'] == 1 ||
                $view_attendance_wise_employee['status'] == 1 || $add_employee_performance['status'] == 1 ||
                $add_daily_attendance['status'] == 1 || $add_informed['status'] == 1 ||
                $add_log_maintenence['status'] == 1 || $import_attendance['status'] == 1 ||
                $add_leave['status'] == 1 || $add_holiday['status'] == 1
              ) { ?>
                <?php if ($user_type == 1 || $add_edit_profile['status'] == 1 || $view_employee_list['status'] == 1 || $view_attendance_wise_employee['status'] == 1 || $add_employee_performance['status'] == 1) { ?>
                  <li><a href="#">Master <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                    <ul>
                      <?php if ($user_type == 1 || $add_edit_profile['status'] == 1) { ?>
                        <li><a href="<?php echo site_url('addprofile/addEmployee'); ?>">Employee Master</a></li>
                      <?php } ?>
                      <?php if ($user_type == 1 || $view_employee_list['status'] == 1) { ?>
                        <li><a href="<?php echo site_url('findemployeelist/contentwithpagination'); ?>">Employee List</a></li>
                      <?php } ?>
                      <?php if ($user_type == 1 || $view_attendance_wise_employee['status'] == 1) { ?>
                        <li><a href="<?php echo site_url('findemployeeattstatus/find_employee_by_att_status'); ?>">Attendance Wise Employee</a></li>
                      <?php } ?>

                      <?php if ($user_type == 1 || $add_employee_performance['status'] == 1) { ?>
                        <li><a href="<?php echo site_url(); ?>empperformance/createperformance">Employee Performance</a></li>
                      <?php } ?>
                      <?php if ($user_id == 6) { ?>
                        <li><a href="#">Define Cost Centre</a></li>
                        <li><a href="#">Level under the Grade</a></li>
                        <li><a href="#">Category of Employee</a></li>
                        <li><a href="#">Type of Staff</a></li>
                        <li><a href="#">Qualification Category</a></li>
                        <li><a href="#">Staturoy Deduction</a></li>
                        <li><a href="#">Fixed Earning Heads</a></li>
                        <li><a href="#">Placement Consultancy</a></li>
                        <li><a href="#">Department wise HDD Mapping</a></li>
                        <li><a href="#">Define Income Tax Slab</a></li>
                        <li><a href="#">State Wise Ptax Slab</a></li>
                      <?php } ?>
                    </ul>
                  </li>
                <?php } ?>
                <?php if ($user_id == 6) { ?>
                  <li><a href="#">Transaction Recruitment</a>
                    <ul>
                      <li><a href="#">Application Status Maintanence by HR Dept.</a></li>
                      <li><a href="#">Applicant Status Approval</a></li>
                      <li><a href="#">Offer Letter Generation</a></li>
                      <li><a href="#">Offer Letter Acceptance</a></li>
                      <li><a href="#">Date Of Joining Confirmation</a></li>
                    </ul>
                  </li>
                  <li><a href="#">Transaction Employee</a>
                    <ul>
                      <li><a href="#">Change Password</a></li>
                      <li><a href="#">Greetings</a></li>
                      <li><a href="#">Employee Wise Official Email-ID Declaration</a></li>
                      <li><a href="#">Employee Qualification</a></li>
                      <li><a href="#">Employee Previous Experience</a></li>
                      <li><a href="#">Employee Family Details</a></li>
                      <li><a href="#">Employee Nominee Details</a></li>
                      <li><a href="#">Salary Revision Details</a></li>
                      <li><a href="#">Define Annual Bonus and Maximum Mobile Limit</a></li>
                      <li><a href="#">Miscellaneous Earnings</a></li>
                      <li><a href="#">Miscellaneous Deduction</a></li>
                      <li><a href="#">KRA Entry Module</a></li>
                      <li><a href="#">Employee Wise Tax Computation</a></li>
                      <li><a href="#">Retirement / Resignation / Termination / Expired</a></li>
                      <li><a href="#">Monthly Income Taxt Deduction</a></li>
                      <li><a href="#">Monthly Income Tax Deduction Processing</a></li>
                    </ul>
                  </li>
                <?php } ?>
                <?php if ($viewDailyMovement['status'] == 1 || $user_type == 1 || $add_daily_attendance['status'] == 1 || $add_informed['status'] == 1 || $add_log_maintenence['status'] == 1 || $import_attendance['status'] == 1) { ?>
                  <li><a href="#">Employee Attendance <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                    <ul>
                      <?php if ($viewDailyMovement['status'] == 1 || $user_type == 1) { ?>
                        <!-- <li><a href="<?php echo site_url('admin-daily-movement-form'); ?>"> Create Daily Movement Order </a></li>
                        <li><a href="<?php echo site_url('pending-daily-movement-orders'); ?>">Pending Daily Movement Orders</a></li>
                        <li><a href="<?php echo site_url('daily-movement-orders'); ?>">Daily Movement Orders</a></li> -->
                        <li><a href="<?php echo site_url('attendance-exceptions'); ?>">Attendance Exceptions</a></li>
                      <?php }
                      if ($user_type == 1 || $add_daily_attendance['status'] == 1) { ?>
                        <li><a href="<?php echo site_url('empattendance/adddailyattendance'); ?>">Daily Attendance</a></li>
                      <?php } ?>
                      <!-- <?php if ($user_type == 1 || $add_informed['status'] == 1) { ?>
                         <li><a href="<?php echo site_url('empattendance/attendanceinformed');
                                      ?>">Informed Adjustment</a></li>
                      <?php } ?> -->
                      <?php if ($user_type == 1 || $add_log_maintenence['status'] == 1) { ?>
                        <li><a href="<?php echo site_url('empattendance/logMaintenance'); ?>">Log Maintenence</a></li>
                      <?php } ?>
                      <?php if ($user_type == 1 || $import_attendance['status'] == 1) { ?>
                        <li><a href="<?php echo site_url('importdata'); ?>">Import Attendance</a></li>
                      <?php } ?>
                      <?php if ($user_id == 6) { ?>
                        <li><a href="#">Late Attendance Adjustment</a></li>
                        <li><a href="#">Employee LWP Entry</a></li>
                        <li><a href="#">Monthly Recovery / Adjustment Entry</a></li>
                        <li><a href="#">Daily Exit</a></li>
                      <?php } ?>
                    </ul>
                  </li>


                <?php }
                if ($user_type == 1 || $add_leave['status'] == 1 || $viewLeaveApplication['status'] == 1) {
                ?>
                  <li><a href="#">Leave Master <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                    <ul>
                      <?php if ($add_leave['status'] == 1 || $user_type == 1) { ?>
                        <li><a href="<?php echo site_url('leavemaster/single_leave'); ?>">Manage Single Leave</a></li>
                      <?php }
                      if ($viewLeaveApplication['status'] == 1 ||  $user_type == 1) { ?>
                        <li><a href="<?php echo base_url(); ?>pending-leave-application">Pending Leave Application</a></li>
                        <li><a href="<?php echo base_url(); ?>leave-application">Leave Applications</a></li>
                      <?php }
                      if ($user_id == 6 || $user_id == 1) { ?>

                        <!-- <li><a href="#">Leave Credit For CL/SL</a></li>
                        <li><a href="#">Casual and Sick Leave Credit for New Employee</a></li>
                        <li><a href="#">List Of Approval Leave Application For Sanction</a></li>
                        <li><a href="#">Leave Cancellation Entry</a></li> -->
                      <?php } ?>
                      <?php if ($view_leave_encashment['status'] == 1 ||  $user_type == 1) { ?>
                        <li><a href="<?php echo base_url(); ?>leave-encashment">Leave Encashment</a></li>
                      <?php } ?>
                    </ul>
                  </li>
                <?php }
                if ($user_type == 1 || $add_holiday['status'] == 1) { ?>
                  <li><a href="<?php echo site_url('holidaymaster/add_holiday'); ?>">Holiday Master</a></li>
                <?php } ?>

                <?php if ($user_type == 1/* HR */ || $user_id == 6 || $user_type == 5 || $user_type == 9) { ?>
                  <!-- 5=Account User, 9=Accounts Head -->
                  <li><a href="#">Payroll Processing <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                    <ul>

                      <!--<li><a href="<?php echo site_url(); ?>division-pay-slip-generation">Dynamic Pay Slip Generation <br/>(Division)</a></li>-->
                      <?php if ($generatePayslip['status'] == 1) { ?>
                        <li><a href="<?php echo site_url(); ?>division-pay-slip-generation-manual">Pay Slip Generation (By Division)</a></li>

                        <!-- <li><a href="<?php echo site_url(); ?>single-payslip-generation">Pay Slip Generation (By Employee)</a></li> -->
                        <!--   Locked employee pay slip generation 
                            STEP-1 : Open employee lock.
                            STEP-2 : Generate single pay slip for this employee.
                            STEP-3 : Done.
                    -->

                      <?php }
                      if ($confirmPayslip['status'] == 1) { ?>
                        <li><a href="<?php echo site_url(); ?>pay-slip-confirmation">Payslip Confirmation</a></li>
                      <?php }
                      if ($checkPayslip['status'] == 1) { ?>
                        <li><a href="<?php echo site_url(); ?>pay-slip-check">Payslip Check</a></li>
                      <?php }
                      if ($approvePayslip['status'] == 1) { ?>
                        <li><a href="<?php echo site_url(); ?>pay-slip-approval">Payslip Approval</a></li>
                      <?php }
                      if ($paymentPayslip['status'] == 1) { ?>
                        <li><a href="<?php echo site_url(); ?>pay-slip-payment">Payslip Payment</a></li>
                      <?php } ?>
                      <!-- <li><a href="#">Pay Heads</a></li> -->
                    </ul>
                  </li>
                  <li><a href="#">Employee Loan <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                    <ul>

                      <?php if ($addLoan['status'] == 1) { ?>
                        <li><a href="<?php echo site_url(); ?>give-loan">Loan Given</a></li>
                      <?php }
                      if ($addLoanRepayment['status'] == 1) { ?>
                        <li><a href="<?php echo site_url(); ?>loan-payment">Loan Recover / Payment</a></li>
                      <?php }
                      if ($submitLoanApplication['status'] == 1) { ?>
                        <!-- <li><a href="#">Application for Loans</a></li> -->
                      <?php }
                      if ($approveLoanApplication['status'] == 1) { ?>
                        <li><a href="#">Loan Applications</a></li>
                      <?php }
                      if ($manageLoan['status'] == 1) { ?>
                        <li><a href="<?php echo site_url(); ?>loan-manage">Manage Loan</a></li>
                      <?php }
                      if ($manageLoanType['status'] == 1) { ?>
                        <li><a href="<?php echo site_url(); ?>loan-type">Loan type</a></li>
                      <?php } ?>

                      <!--<li><a href="#">Approval / Rejection Of Loan By HDD</a></li>-->
                      <!--<li><a href="#">Approval / Rejection Of Loan By CFO</a></li>-->
                      <!--<li><a href="#">Loans / Advances Disbursements</a></li>-->
                      <!--<li><a href="#">Loan / Advances Recovery</a></li>-->
                      <!--<li><a href="#">Loans / Monthly Advance Stop Recovery</a></li>-->
                    </ul>
                  </li>

                  <?php if ($user_id == 6) { ?>


                    <!--
                <li><a href="#">Employee Tour</a>
                <ul>
                    <li><a href="#">Tour Application</a></li>
                    <li><a href="#">Tour Application Approval</a></li>
                    <li><a href="#">Tour Advance Disbursement</a></li>
                    <li><a href="#">Tour Cancellation</a></li>
                    <li><a href="#">Tour Expenses</a></li>
                    <li><a href="#">Tour Expenses Approval</a></li>
                    <li><a href="#">Approved Tour Expenses Settlement</a></li>
                </ul>
            </li> 
               -->
                    <li><a href="#">Allowances</a>
                      <ul>
                        <li><a href="#">House rent</a></li>
                        <li><a href="#">Medical</a></li>
                        <li><a href="#">Transport</a></li>
                        <li><a href="#">Telephone</a></li>
                        <li><a href="">Educational</a></li>
                        <li><a href="#">Special</a></li>
                        <li><a href="#">Others</a></li>
                        <!--
                    <li><a href="#">Medical Allowances Entry</a></li>
                    <li><a href="#">Medical Allowances Passing</a></li>
                    <li><a href="#">Medical Allowances Payment</a></li>
                    -->
                      </ul>
                    </li>

                    <li><a href="#">Incentive</a>
                      <ul>
                        <li><a href="#">Incentive Disbursement Entry</a></li>
                        <li><a href="#">Incentive Calculation Confirmation</a></li>
                      </ul>
                    </li>

                    <!-- <li><a href="#">Deduction</a>
                      <ul>
                        <li><a href="">Income Tax</a></li>
                        <li><a href="">Provident Fund</a></li>
                        <li><a href="">Others</a></li>
                      </ul>
                    </li> -->
                    <li><a href="#">Payment Method</a></li>
                  <?php } ?>
                <?php

                }
                if ($user_type == 1) {
                ?>
                  <li><a href="<?php echo site_url(); ?>staff-salary">Staff Salary</a></li>
                  <li><a href="<?php echo site_url(); ?>advance-salary">Advance Salary</a></li>
                  <li><a href="<?php echo site_url(); ?>pf-payments">PF Payments</a></li>
                  <li>
                    <a href="#">Employee Bonus <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                    <ul>
                      <li><a href="<?php echo site_url(); ?>festival-bonus">Festival Bonus</a></li>
                      <li><a href="<?php echo site_url(); ?>performance-bonus">Performance Bonus</a></li>
                      <li><a href="<?php echo site_url(); ?>special-bonus">Special Bonus</a></li>
                      <li><a href="<?php echo site_url(); ?>incentive">Incentive</a></li>
                    </ul>
                  </li>
                  <li><a href="<?php echo site_url(); ?>gratuity">Gratuity</a></li>
                  <li><a href="#">Salary Increment <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                    <ul>
                      <li><a href="<?php echo site_url(); ?>upload-salary-increment">Import File</a></li>
                      <li><a href="">Employee Wise</a></li>
                    </ul>
                  </li>
                  <li><a href="#">Performance <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                    <ul>
                      <li><a href="<?php echo site_url(); ?>add-employee-performance">Add Employee Performance</a></li>
                      <li><a href="<?php echo site_url(); ?>manage-employee-performance">Manage Employee Performance</a></li>
                    </ul>
                  </li>
              <?php }
              } ?>
            </ul>

          </li>

          <!-- Entry parent menu ends here -->
          <?php if ($user_type == 8) { // Store area 
          ?>
            <li><a href="#"><span class="glyphicon glyphicon-shopping-cart"></span> Purchase <span class="pull-right glyphicon glyphicon-menu-down"></span></a>
              <ul>
                <li><a href="<?php echo base_url(); ?>add-purchase"><span class="glyphicon glyphicon-plus-sign"></span> Add Purchase</a></li>
                <li><a href="<?php echo base_url(); ?>manage-purchase"><span class="glyphicon glyphicon-list"></span> Manage Purchase</a></li>
                <li><a href="<?php echo base_url(); ?>received-product"><span class="glyphicon glyphicon-arrow-right"></span> Received Product</a></li>
                <li><a href="<?php echo base_url(); ?>return-product"><span class="glyphicon glyphicon-refresh"></span> Returned Product</a></li>
              </ul>
            </li>
            <li><a href=""><span class="glyphicon glyphicon-pencil"></span>Item Issues <span class="pull-right glyphicon glyphicon-menu-down"></span></a>
              <ul>
                <!--<li><a href="<?php echo base_url(); ?>add-sales"><span class="glyphicon glyphicon-forward"></span> Create Order </a></li>-->
                <li><a href="<?php echo base_url(); ?>manage-sales"><span class="glyphicon glyphicon-forward"></span> Manage Item Issued</a></li>
                <!--<li><a href="<?php echo base_url(); ?>manage-sales"><span class="glyphicon glyphicon-forward"></span> Processing Requisition</a></li>-->
                <li><a href="<?php echo base_url(); ?>delivered-sales"><span class="glyphicon glyphicon-forward"></span> Delivered Item</a></li>
                <li><a href="<?php echo base_url(); ?>returned-sales"><span class="glyphicon glyphicon-forward"></span> Returned Item</a></li>
                <!--        <li><a href="<?php echo base_url(); ?>manage-sales"><span class="glyphicon glyphicon-forward"></span> Quotation</a></li>
        <li><a href="<?php echo base_url(); ?>manage-sales"><span class="glyphicon glyphicon-forward"></span> All Quotation</a></li>-->
              </ul>
            </li>
          <?php

          }
          if ($user_type == 8) { // Store area 
          ?>

            <li><a href="#"><span class="glyphicon glyphicon-oil"></span> Stock <span class="pull-right glyphicon glyphicon-menu-down"></span></a>
              <ul>
                <li><a href="<?php echo base_url(); ?>out-of-stock">Out Of Stock</a></li>
                <li><a href="<?php echo base_url(); ?>available-stock">Available Stock</a></li>
                <li><a href="<?php echo base_url(); ?>all-stock">All Stock</a></li>
                <li><a href="<?php echo base_url(); ?>category-wise-stock">Category Wise Stock</a></li>
              </ul>
            </li>

          <?php } ?>

          <!-- Reports parent menu start here -->
          <li><a href="#"><span class="glyphicon glyphicon-file"></span> Reports <span class="pull-right glyphicon glyphicon-menu-down"></span></a>
            <?php if ($user_type == 8) { // Store area 
            ?>
              <ul>
                <li><a href="#">Item Issue <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                  <ul>
                    <li><a href="<?php echo base_url(); ?>employee-wise-sales-report">Employee Wise</a></li>
                    <li><a href="<?php echo base_url(); ?>category-wise-sales-report">Category Wise</a></li>
                    <li><a href="<?php echo base_url(); ?>item-wise-sales-report">Item Wise</a></li>
                    <li><a href="<?php echo base_url(); ?>date-wise-sales-report">Date Wise</a></li>
                    <li><a href="<?php echo base_url(); ?>month-wise-sales-report">Month Wise</a></li>
                    <li><a href="<?php echo base_url(); ?>year-wise-sales-report">Year Wise</a></li>
                  </ul>
                </li>
                <li><a href="#">Purchase <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                  <ul>
                    <li><a href="<?php echo base_url(); ?>supplier-wise-purchase-report">Supplier Wise</a></li>
                    <li><a href="<?php echo base_url(); ?>category-wise-purchase-report">Category Wise</a></li>
                    <li><a href="<?php echo base_url(); ?>item-wise-purchase-report">Item Wise</a></li>
                    <li><a href="<?php echo base_url(); ?>date-wise-purchase-report">Date Wise</a></li>
                    <li><a href="<?php echo base_url(); ?>month-wise-purchase-report">Month Wise</a></li>
                    <li><a href="<?php echo base_url(); ?>year-wise-purchase-report">Year Wise</a></li>
                    <li><a href="<?php echo base_url(); ?>return-purchase-report">Return Purchase</a></li>
                    <li><a href="<?php echo base_url(); ?>payment-purchase-report">Payment Purchase</a></li>
                  </ul>
                </li>
              </ul>

            <?php }
            if ($user_type == 1 || $view_monthly_attendance['status'] == 1 || $view_attendance_reports_multiple['status'] == 1 || $view_attendance_summery_reports['status'] == 1 || $view_daily_attendance_reports['status'] == 1 || $view_daily_late_reports['status'] == 1 || $view_daily_early_reports['status'] == 1 || $view_daily_absent_reports['status'] == 1 || $view_absent_reports_single['status'] == 1 || $view_daily_leave_reports['status'] == 1 || $view_single_leave_reports['status'] == 1 || $view_leave_summery_reports['status'] == 1 || $view_attendance_informed_reports['status'] == 1 || $view_attendance_log_reports['status'] == 1 || $view_salary_history['status'] == 1 || $view_salary_history_multiple['status'] == 1 || $view_job_history['status'] == 1 || $view_resume['status'] == 1 || $view_holiday_reports['status'] == 1) { ?>

              <ul>
                <?php if ($user_id == 6) { ?>
                  <li><a href="#">Recruitment <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                    <ul>
                      <li><a href="#">Applicant Details</a></li>
                      <li><a href="#">Single Applicant Details</a></li>
                      <li><a href="#">Appiontment Letter</a></li>
                      <li><a href="#">Offer Letter</a></li>
                    </ul>
                  </li>
                <?php } ?>
                <?php if ($user_id == 6 || $user_type == 5 || $user_type == 9 || $user_type == 1) { ?>
                  <li><a href="#">Payroll Reports <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                    <ul>
                      <li><a href="<?php echo base_url() ?>pay-slip-report">Pay Slip</a></li>
                      <li><a href="<?php echo base_url() ?>employee-wise-pay-slip-report">Employee Wise Payslip</a></li>

                      <li><a href="<?php echo base_url() ?>salary-statement">Salary Statement</a></li>
                      <li><a href="<?php echo base_url() ?>bank-advice">Bank Advice</a></li>
                      <li><a href="<?php echo base_url() ?>provident-fund-statement">Provident Fund Payment Statement</a></li>
                      <li><a href="<?php echo base_url() ?>advance-salary-statement">Advance Salary Statement</a></li>
                      <li><a href="<?php echo base_url() ?>gratuity-statement">Gratuity Statement</a></li>
                      <li><a href="<?php echo base_url() ?>incentive-statement">Incentive Statement</a></li>
                      <li><a href="<?php echo base_url() ?>festival-bonus-statement">Festival Bonus Statement</a></li>
                      <li><a href="<?php echo base_url() ?>performance-bonus-statement">Performance Bonus Statement</a></li>
                      <li><a href="<?php echo base_url() ?>special-bonus-statement">Special Bonus Statement</a></li>
                      <?php if ($user_id == 6) { ?>
                        <!-- <li><a href="#">Provident Fund Statement</a></li>
                        <li><a href="#">Medical Reimbursement Statement</a></li>
                        <li><a href="#">Income Tax Deduction</a></li>
                        <li><a href="#">ESI Deduction Statement</a></li>
                        <li><a href="#">Salary Recovery Statement</a></li>
                        <li><a href="#">Bank Payment Statement</a></li>
                        <li><a href="#">Salary Register</a></li>
                        <li><a href="#">PTax Deduction Statement</a></li> -->
                      <?php } ?>
                    </ul>
                  </li>
                  <li><a href="<?php echo base_url() ?>salary-certificate">Salary Certificate</a></li>
                  <li><a href="<?php echo base_url() ?>tax-calculation">Tax Calculator</a></li>
                  <li><a href="<?php echo base_url() ?>pf-statement">PF Statement</a></li>
                  <li><a href="#">Loan <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                    <ul>
                      <li><a href="<?php echo base_url() ?>employee-loan-report">Loan Statement (Employee Wise )</a></li>
                      <!-- <li><a href="<?php echo base_url() ?>division-loan-report">Loan Statement (Account Wise )</a></li> -->

                      <!--        <li><a href="#">Loan Disbursement Statement</a></li>
                        <li><a href="#">Loan Recovery Statement</a></li>-->
                    </ul>
                  </li>
                <?php } ?>

                <?php if (
                  $user_type == 1 ||
                  $view_monthly_attendance['status'] == 1 ||
                  $view_attendance_reports_multiple['status'] == 1 ||
                  $view_attendance_summery_reports['status'] == 1 ||
                  $view_daily_attendance_reports['status'] == 1 ||
                  $view_daily_late_reports['status'] == 1 ||
                  $view_daily_early_reports['status'] == 1 ||
                  $view_daily_absent_reports['status'] == 1 ||
                  $view_absent_reports_single['status'] == 1
                ) { ?>
                  <li><a href="#">Attendance <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                    <ul>
                      <?php if ($user_type == 1 || $view_monthly_attendance['status'] == 1) { ?>
                        <li><a href="<?php echo site_url('daily_attendance_report'); ?>">Daily Attendance Reports</a></li>
                        <li><a href="<?php echo site_url('monthly_attendance_report'); ?>">Monthly Attendance Reports</a></li>
                      <?php } ?>
                      <?php if ($user_id != 14) { ?>
                        <?php if ($user_type == 1 || $view_attendance_reports_multiple['status'] == 1) { ?>
                          <!-- <li><a href="<?php echo site_url('reports/monthlyattendancereportsmultiple'); ?>">Monthly Attendance Reports Multiple</a></li> -->
                        <?php } ?>
                        <?php if ($user_type == 1 || $view_attendance_summery_reports['status'] == 1) { ?>
                          <!-- <li><a href="<?php // echo site_url('attendance_summery_reports/monthly_attendance_summery_reports'); 
                                            ?>">Attendance Summery Reports New</a></li> -->

                          <li><a href="<?php echo site_url('monthly_attendance_summary_report'); ?>">Monthly Attendance Summary Report</a></li>
                        <?php } ?>
                        <?php if ($user_type == 1 || $view_daily_attendance_reports['status'] == 1) { ?>
                          <!-- <li><a href="<?php echo site_url('reports/dailyattendancereports'); ?>">Daily Attendance Reports</a></li> -->
                        <?php } ?>
                        <?php if ($user_type == 1 || $view_daily_late_reports['status'] == 1) { ?>
                          <!--<li><a href="<?php echo site_url('reports/dailylatereports'); ?>">Daily Late Reports</a></li>-->
                        <?php } ?>
                        <?php if ($user_type == 1 || $view_daily_early_reports['status'] == 1) { ?>
                          <!--<li><a href="<?php echo site_url('reports/dailyearlyreports'); ?>">Daily Early Reports</a></li>-->
                        <?php } ?>
                        <?php if ($user_type == 1 || $view_daily_absent_reports['status'] == 1) { ?>
                          <!--<li><a href="<?php echo site_url('reports/dailyabsentreports'); ?>">Daily Absent Reports</a></li>-->
                        <?php } ?>
                        <?php if ($user_type == 1 || $view_absent_reports_single['status'] == 1) { ?>
                          <!--<li><a href="<?php echo site_url('reports_leave/total_absent_reports'); ?>">Absent Reports Single</a></li>-->
                        <?php } ?>
                      <?php } ?>
                    </ul>
                  </li>
                <?php } ?>
                <?php if ($user_type == 1 || $view_daily_leave_reports['status'] == 1 || $view_single_leave_reports['status'] == 1 || $view_leave_summery_reports['status'] == 1) { ?>
                  <li><a href="#">Leave <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                    <ul>
                      <?php if ($user_type == 1 || $view_daily_leave_reports['status'] == 1) { ?>
                        <li><a href="<?php echo site_url('daily_leave_report'); ?>">Daily Leave Reports</a></li>
                      <?php } ?>
                      <?php if ($user_type == 1 || $view_single_leave_reports['status'] == 1) { ?>
                        <li><a href="<?php echo site_url('single_leave_report'); ?>">Single Leave Reports</a></li>
                      <?php } ?>
                      <?php if ($user_type == 1 || $view_leave_summery_reports['status'] == 1) { ?>
                        <li><a href="<?php echo site_url('leave_summery_report_monthly'); ?>">Leave Summery Reports Monthly</a></li>
                        <li><a href="<?php echo site_url('leave_summery_report'); ?>">Leave Summery Reports</a></li>
                      <?php } ?>
                    </ul>
                  </li>
                <?php } ?>
                <?php if ($user_type == 1 || $view_attendance_informed_reports['status'] == 1 || $view_attendance_log_reports['status'] == 1) { ?>
                  <li><a href="#">Attendance Problem <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                    <ul>
                      <?php if ($user_type == 1 || $view_attendance_informed_reports['status'] == 1) { ?>
                        <li><a href="<?php echo site_url('reports/informedreports'); ?>">Attendance Informed Reports</a></li>
                      <?php } ?>
                      <?php if ($user_type == 1 || $view_attendance_log_reports['status'] == 1) { ?>
                        <li><a href="<?php echo site_url('reports/logerrorreports'); ?>">Attendance Log Reports</a></li>
                      <?php } ?>
                    </ul>
                  </li>
                <?php } ?>
                <?php if ($user_type == 1 || $user_type == 5 || $view_salary_history['status'] == 1 || $view_salary_history_multiple['status'] == 1) { ?>
                  <li><a href="#">Salary <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                    <ul>
                      <?php if ($user_type == 1 || $view_salary_history['status'] == 1) { ?>
                        <li><a href="<?php echo site_url('salary/salaryhistorysingle'); ?>">Salary History</a></li>
                      <?php }
                      if ($user_type == 1 || $view_salary_history_multiple['status'] == 1) { ?>
                        <li><a href="<?php echo site_url('salary/salaryhistorymultiple'); ?>">Salary History Multiple</a></li>
                      <?php } ?>
                      <!--<li><a href="<?php echo site_url('salary/salaryStatement'); ?>">Salary Statement</a></li>-->
                    </ul>
                  </li>
                <?php } ?>
                <?php if ($user_type == 1 || $view_job_history['status'] == 1 || $view_resume['status'] == 1) { ?>
                  <li><a href="#">Employee <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                    <ul>
                      <?php if ($user_type == 1 || $view_job_history['status'] == 1) { ?>
                        <li><a href="<?php echo site_url('posthistory/jobhistorysingle'); ?>">Employee Job History</a></li>
                        <li><a href="<?php echo site_url('yearly-employee-count'); ?>">Yearly Employee Count</a></li>
                        <!-- <li><a href="<?php echo site_url('salary/salaryhistorymultiple'); ?>">Salary History Multiple</a></li>           -->
                      <?php } ?>
                      <?php if ($user_type == 1 || $view_resume['status'] == 1) { ?>
                        <li><a href="<?php echo site_url('reports/resume'); ?>">Resume</a></li>
                      <?php } ?>
                    </ul>
                  </li>
                <?php } ?>

                <!-- <li><a href="#">Employee Reports</a>
                <ul>
                    <li><a href="<?php echo site_url('reports/monthlyattendancereports'); ?>">Monthly Attendance Reports</a></li>
                    <li><a href="<?php echo site_url('reports/dailyattendancereports'); ?>">Daily Attendance Reports</a></li>
                    <li><a href="<?php echo site_url('reports/informedreports'); ?>">Attendance Informed Reports</a></li>
                </ul>
                </li> -->
                <?php if ($user_type == 1 || $view_holiday_reports['status'] == 1) { ?>
                  <li><a href="<?php echo site_url('reports/holidayreports'); ?>">Holiday Reports</a></li>
                <?php } ?>
                <?php if ($user_type == 1 || $view_performance_single['status'] == 1) { ?>
                  <li><a href="#">Performance <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                    <ul>
                      <?php if ($user_type == 1 || $view_performance['status'] == 1) { ?>
                        <li><a href="<?php echo site_url('empperformance/searchempperformance'); ?>">View Performance</a></li>
                        <li><a href="<?php echo site_url('empperformance/viewempperformancesummery'); ?>">View Performance Summery</a></li>
                      <?php } ?>
                    </ul>
                  </li>

                <?php } ?>
                <?php if ($user_id == 6) { ?>
                  <li><a href="#">Taxable Reports</a></li>
                <?php } ?>
              </ul>
            <?php } ?>
          </li>

          <!-- Reports parent menu ends here -->

          <?php if ($user_type == 1) { ?>
            <li><a href="#"><span class="glyphicon glyphicon-cog"> </span> Settings <span class="pull-right glyphicon glyphicon-menu-down"></span></a>
              <ul>
                <li><a href="#"> User <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                  <ul>
                    <!--     <li><a href="<?php echo site_url(); ?>user/userpermission">User Permission</a></li>
            <li><a href="<?php echo site_url(); ?>user/userwisepermission">User Wise Permission</a></li> -->
                    <li><a href="<?php echo site_url(); ?>user/adduserrole">User Roles</a></li>
                    <li><a href="<?php echo site_url(); ?>user/adduser">Add User</a></li>
                    <li><a href="<?php echo site_url(); ?>user/manageUser">View Users</a></li>
                    <li><a href="<?php echo site_url(); ?>user/addtasktype">Add Task Type</a></li>
                  </ul>
                </li>
                <li><a href="#">Add Vocabulary <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                  <ul>
                    <li><a href="<?php echo site_url(); ?>addtaxonomy/addCompany">Company</a></li>
                    <li><a href="<?php echo site_url(); ?>addtaxonomy/addDivision">Division</a></li>
                    <li><a href="<?php echo site_url(); ?>addtaxonomy/addDepartment">Department</a></li>
                    <li><a href="<?php echo site_url(); ?>addtaxonomy/addtypeofemployee">Employee Type</a></li>
                    <li><a href="<?php echo site_url(); ?>addtaxonomy/addworkingshift">Working Shift</a></li>
                    <li><a href="<?php echo site_url(); ?>addtaxonomy/addjobtitle">Job Title</a></li>
                    <!-- <li><a href="<?php echo site_url(); ?>addtaxonomy/addgrade">Grade</a></li> -->
                    <li><a href="<?php echo site_url(); ?>addtaxonomy/addqualification">Qualification Type</a></li>
                    <li><a href="<?php echo site_url(); ?>addtaxonomy/addreligion">Religion</a></li>
                    <li><a href="<?php echo site_url(); ?>addtaxonomy/addmarital_status">Marital Status</a></li>
                    <li><a href="<?php echo site_url(); ?>addtaxonomy/addblood_group">Blood Group</a></li>
                    <li><a href="<?php echo site_url(); ?>addtaxonomy/addrelative">Relative</a></li>
                    <li><a href="<?php echo site_url(); ?>addtaxonomy/addcity">City</a></li>
                    <li><a href="<?php echo site_url(); ?>addtaxonomy/adddistict">Distict</a></li>
                    <li><a href="<?php echo site_url(); ?>addtaxonomy/addbankname">Bank</a></li>
                    <li><a href="<?php echo site_url(); ?>addtaxonomy/addpaytype">Pay Type</a></li>
                    <li><a href="<?php echo site_url(); ?>addtaxonomy/addleavetype">Leave Type</a></li>
                    <li><a href="<?php echo site_url(); ?>addtaxonomy/addyearlyholidaytype">Yearly Holiday Type</a></li>
                    <li><a href="<?php echo site_url(); ?>addtaxonomy/addperformancecriteriacategory">Performance Criteria Category</a></li>
                    <li><a href="<?php echo site_url(); ?>addtaxonomy/addperformancecriteria">Performance Criteria</a></li>

                  </ul>
                </li>
                <li><a href="#">Grade <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                  <ul>
                    <li><a href="<?php echo site_url('create-grade'); ?>">Create Grade</a></li>
                    <li><a href="<?php echo site_url('manage-grade'); ?>">Manage Grade</a></li>
                  </ul>
                </li>
                <?php if ($user_type == 1) { ?>
                  <li><a href="#">Performance <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                    <ul>
                      <li><a href="<?php echo site_url(); ?>create-performance-session">Create Performance Session</a></li>
                      <li><a href="<?php echo site_url(); ?>empperformance/createperformance">Create Performance (Old)</a></li>
                    </ul>
                  </li>
                <?php } ?>
                <li><a href="<?php echo site_url(); ?>dashboard/globalsettings">Global Settings</a></li>
                <li><a href="#">Recruitment <span class="pull-right glyphicon glyphicon-menu-right"></span></a>
                  <ul>
                    <li><a href="<?php echo site_url(); ?>recruitment/post_circular">Post a Circular</a></li>
                    <li><a href="<?php echo site_url(); ?>recruitment/viewcircular">View Circular</a></li>
                    <li><a href="<?php echo site_url(); ?>recruitment_pub/findcandidates">Find Applicants</a></li>
                  </ul>
                </li>
                <li><a href="<?php echo site_url(); ?>company/addcompany">Define Company Name & Address</a></li>
                <!--   <li><a href="<?php echo site_url(); ?>ramadan/manage_ramadan_schedule">Ramadan Time Schedule</a></li> -->
              </ul>
            </li>
          <?php } ?>

          <?php if ($this->session->userdata('user_type') == 6) { ?>
            <li><a href="#">Vehicles</a>
              <ul>
                <li><a href="#">Entry</a>
                  <ul>
                    <li><a href="<?php echo site_url("vahicles/addcar"); ?>">Add Car</a></li>
                    <li><a href="<?php echo site_url("carcost/addcarcost"); ?>">Add Car Cost</a></li>
                    <li><a href="<?php echo site_url("vahicles/addcarlog"); ?>">Add Car Log</a></li>
                    <li><a href="<?php echo site_url("vahicles/addrequisition"); ?>">Add Car Requisition</a></li>
                    <li><a href="<?php echo site_url('addtransportemployee/addemployee'); ?>">Add Personnel</a></li>
                  </ul>
                </li>
                <li><a href="#">Reports</a>
                  <ul>
                    <li><a href="<?php echo site_url("findcarlist/cars"); ?>">Car List</a></li>
                    <li><a href="<?php echo site_url('transportemployeelist/emplist'); ?>">View Personnel</a></li>
                    <li><a href="<?php echo site_url('vahicles/viewcarcost'); ?>">View Car Cost</a></li>
                    <li><a href="<?php echo site_url('vahicles/viewrequisition'); ?>">View Car Requisition</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#">Settings</a>
              <ul>
                <li><a href="<?php echo site_url("carcost/addcosttype"); ?>">Add Car Cost Type</a></li>
              </ul>
            </li>
          <?php }
          if ($user_id == 6) { ?>
            <li><a href="#"><span class="glyphicon glyphicon-save-file"> </span> Backup</a>
              <ul>
                <?php if ($user_name == 'sajeeb') { ?>
                  <li><a href="<?php echo site_url("BackupController/software_backup"); ?>">Software</a></li>
                <?php }
                if ($user_name == 'sajeeb' || $user_type == 1) { ?>
                  <li><a href="<?php echo site_url("BackupController/Export_Database"); ?>">Database</a></li>
                <?php } ?>
              </ul>
            </li>
          <?php }
          if ($user_type == 1) { ?>
            <li><a href="<?php echo site_url(); ?>recruitment/view_circular" class=""><span class="glyphicon glyphicon-list-alt"> </span> Circular</a></li>
            <li><a href="<?php echo site_url(); ?>recruitment/view_applicant"><span class="glyphicon glyphicon-user"> </span> Applicant</a></li>
            <li><a href="<?php echo site_url(); ?>notice/view_notice" class=""><span class="glyphicon glyphicon-list-alt"> </span> Notice</a></li>

          <?php }

          if ($user_type == 1 || $adminLeaveApplication['status'] == 1 || $adminDailyMovement['status'] == 1) {
          ?>
            <!-- <li><a href="">Apply <span class="pull-right glyphicon glyphicon-menu-down"></span></a>
              <ul>
                <?php if ($user_type == 1 || $adminLeaveApplication['status'] == 1) { ?>
                  <li><a href="<?php echo site_url(); ?>admin-leave-application-form"><span class="glyphicon glyphicon-list-alt"> </span> Leave Application </a></li>
                <?php }
                if ($user_type == 1 || $adminDailyMovement['status'] == 1) { ?>
                  <li><a href="<?php echo site_url(); ?>admin-daily-movement-form"><span class="glyphicon glyphicon-list-alt"> </span> Daily Movement </a></li>
                <?php } ?>
              </ul>
            </li> -->
          <?php } ?>
          <li><a href="#"><span class="glyphicon glyphicon-user"> </span><?php echo " " . $user_name; ?> <span class="pull-right glyphicon glyphicon-menu-down"></span></a>
            <ul>
              <?php if ($user_type == 1 || $edit_view_login_profile['status'] == 1) { ?>
                <li><a href="<?php echo site_url(); ?>user/viewprofile"><span class="glyphicon glyphicon-list-alt"> </span> View Profile</a></li>
              <?php } ?>
              <li><a href="<?php echo site_url("logout"); ?>"><span class="glyphicon glyphicon-log-out"> </span> Logout</a></li>
            </ul>
          </li>
          <?php if ($user_id == 6) { ?>
            <a href="<?php echo base_url(); ?>update-data" class="btn btn-xs btn-default pull-right" style="margin: 5px 5px 0 0;">update</a>
          <?php } ?>
        </ul>

      </nav>

    </div>
  </div>

</div>