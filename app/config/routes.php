<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
#$route['default_controller'] = "login";
$route['default_controller'] = "login/index";
$route['404_override'] = '';

# Dashboard Report
$route['today_present'] = 'ReportController/today_present';
$route['today_absent'] = 'ReportController/today_absent';

//$route['login']='login/index';
//$route['login']='login/adminLogin';
$route['test']='TestController/test';
$route['login']='login/index';
$route['admin-login']='login/adminLogin';
$route['employee-login']='login/employeeLogin';
$route['dashboard']='dashboard/index';
$route['employee-dashboard']='dashboard/employeeDashboard';
$route['logout'] = 'login/getLogout';
$route['employee-logout'] = 'login/employeeLogout';
$route['change-employee-password'] = 'login/employeePasswordChange';
$route['update-employee-password'] = 'login/updateEmployeePassword';

// Leave Appication
$route['employee-leave-application'] = 'leavemaster/employeeLeaveApplication';
$route['employee-leave-application/(:any)'] = 'leavemaster/employeeLeaveApplication/$1';
$route['edit-admin-leave-application/(:any)'] = 'leavemaster/adminLeaveApplicationForm/$1';
$route['delete-leave-application/(:any)'] = 'leavemaster/deleteLeaveApplication/$1';
$route['delete-admin-leave-application/(:any)'] = 'leavemaster/deleteAdminLeaveApplication/$1';
$route['employee-leave'] = 'leavemaster/employeeLeave';
$route['leave-application'] = 'leavemaster/leaveApplication';
$route['pending-leave-application'] = 'leavemaster/pendingLeaveApplication';
$route['admin-leave-application-form'] = 'leavemaster/adminLeaveApplicationForm';
$route['edit-admin-leave-application/(:any)'] = 'leavemaster/adminLeaveApplicationForm/$1';
$route['admin-leave-application'] = 'leavemaster/adminLeaveApplication';
$route['print-leave-application/(:any)'] = 'leavemaster/printLeaveApplication/$1';
$route['save-admin-leave-application'] = 'leavemaster/saveAdminLeaveApplication';

# Attendance Exceptions
$route['attendance-exceptions'] = 'AttendanceExceptionController/attendanceExceptions';

$route['attendance-exception-create'] = 'AttendanceExceptionController/create';
$route['my-attendance-exceptions'] = 'AttendanceExceptionController/myException';
$route['my-attendance-exceptions/(:any)/(:any)'] = 'AttendanceExceptionController/myException/$1/$1';



// Daily Movement
$route['admin-daily-movement-form'] = 'empattendance/adminMovementOrderForm';
$route['employee-movement-orders'] = 'empattendance/employeeMovementOrder';
$route['employee-movement-order-form'] = 'dashboard/employeeMovementOrderForm';

$route['edit-employee-movement/(:any)'] = 'dashboard/employeeMovementOrderForm/$1';
$route['edit-admin-movement/(:any)'] = 'empattendance/adminMovementOrderForm/$1';
$route['delete-employee-movement/(:any)'] = 'empattendance/deleteEmployeeMovementOrder/$1';
$route['delete-admin-movement/(:any)'] = 'empattendance/deleteAdminMovementOrder/$1';

$route['admin-movement-orders'] = 'empattendance/adminMovementOrder';
$route['daily-movement-orders'] = 'empattendance/dailyMovementOrders';
$route['pending-daily-movement-orders'] = 'empattendance/pendingDailyMovementOrders';
$route['print-daily-movement/(:any)'] = 'empattendance/printDailyMovement/$1';

# Employee ATtendance
$route['my-attendance'] = 'AttendanceReportController/myAttendance';
$route['update-data'] = 'updateController/updateProvisionData';
$route['delete-job-history/(:any)'] = 'posthistory/deleteJobHistory/$1';

//employee management
//$route['add-employee'] = 'addprofile/addEmployee';
$route['employee-list'] = 'findemployeelist/contentwithpagination';
$route['employee-profile/(:any)'] = 'addprofile/employeeProfile/$1';

// loan mangement
$route['loan-type']='loan/loanType';
$route['loan-type/(:any)']='loan/loanType/$id';
$route['give-loan']= 'loan/giveLoan';
$route['employee-loan-report'] = 'loan/employeeLoanReport';
$route['division-loan-report'] = 'loan/divisionLoanReport';
$route['loan-payment'] = 'loan/paymentLoan';
$route['loan-manage'] = 'loan/loanManage';
$route['delete-loan/(:any)'] = 'loan/deleteLoan/$1';

// payslip
$route['manage-grade'] = 'Payroll/manageGrade';
$route['create-grade'] = 'Payroll/createGrade';
$route['view-grade'] = 'Payroll/viewGrade';
$route['manage-grade/(:any)/(:any)'] = 'Payroll/manageGrade';
$route['grade-info-by-id'] = 'Payroll/gradeInfoById';
$route['emp-grade-by-content-id'] = 'Payroll/empGradeByContentId';
$route['add-salary'] = 'Payroll/addSalary';
$route['save-salary'] = 'Payroll/saveSalary';
$route['edit-salary'] = 'Payroll/editSalary';
$route['view-salary'] = 'Payroll/viewSalary';
$route['increment-salary'] = 'Payroll/incrementSalary';
$route['save-increment'] = 'Payroll/saveIncrement';

# Staff Salary
$route['staff-salary'] = 'Payroll/staffSalary';
$route['add-staff-salary'] = 'Payroll/addStaffSalary';
$route['edit-staff-salary'] = 'Payroll/editStaffSalary';
$route['increment-staff-salary'] = 'Payroll/incrementStaffSalary';

# Advance Salary
$route['advance-salary'] = 'AdvanceSalaryController/manage';
$route['add-advance-salary'] = 'AdvanceSalaryController/create';
$route['save-advance-salary'] = 'AdvanceSalaryController/save';
$route['edit-advance-salary'] = 'AdvanceSalaryController/edit';

# PF Payment
$route['pf-payments'] = 'PfPaymentController/manage';
$route['add-pf-payment'] = 'PfPaymentController/create';
$route['save-pf-payment'] = 'PfPaymentController/save';
$route['edit-pf-payment'] = 'PfPaymentController/edit';

# Gratuity
$route['gratuity'] = 'GratuityController/manage';
$route['add-gratuity'] = 'GratuityController/create';
$route['save-gratuity'] = 'GratuityController/save';
$route['edit-gratuity'] = 'GratuityController/edit';

# Performance Bonus
$route['performance-bonus'] = 'PerformanceBonusController/manage';
$route['add-performance-bonus'] = 'PerformanceBonusController/create';
$route['save-performance-bonus'] = 'PerformanceBonusController/save';
$route['edit-performance-bonus'] = 'PerformanceBonusController/edit';

# Festival Bonus
$route['festival-bonus'] = 'FestivalBonusController/manage';
$route['add-festival-bonus'] = 'FestivalBonusController/create';
$route['add-division-festival-bonus'] = 'FestivalBonusController/createDivisionWise';
$route['save-festival-bonus'] = 'FestivalBonusController/save';
$route['save-division-festival-bonus'] = 'FestivalBonusController/saveDivisionWise';
$route['edit-festival-bonus'] = 'FestivalBonusController/edit';

# Special Bonus
$route['special-bonus'] = 'SpecialBonusController/manage';
$route['add-special-bonus'] = 'SpecialBonusController/create';
$route['save-special-bonus'] = 'SpecialBonusController/save';
$route['edit-special-bonus'] = 'SpecialBonusController/edit';

# Incentive
$route['incentive'] = 'IncentiveController/manage';
$route['add-incentive'] = 'IncentiveController/create';
$route['save-incentive'] = 'IncentiveController/save';
$route['edit-incentive'] = 'IncentiveController/edit';

# Payslip Generation
$route['single-payslip-generation'] = 'payroll/singlePaySlipGeneratorManual';
$route['division-pay-slip-generation'] = 'payroll/divisionPaySlipGenerator';
$route['division-pay-slip-generation-manual'] = 'payroll/divisionPaySlipGeneratorManual';
$route['get_payslip_info_by_id/(:any)'] = 'payroll/getPayslipInfoById/$1';
# Payslip Confirmation
$route['pay-slip-confirmation'] = 'payroll/confirmPayslip';
$route['pay-slip-confirmation/(:any)'] = 'payroll/confirmPayslip/$1';
# Payslip Check
$route['pay-slip-check'] = 'payroll/checkPayslip';
$route['pay-slip-check/(:any)'] = 'payroll/checkPayslip/$1';
$route['pay-slip-check/(:any)/(:any)'] = 'payroll/checkPayslip/$1/$1';
$route['pay-slip-check/(:any)/(:any)/(:any)/(:any)'] = 'payroll/checkPayslip/$1/$1/$1/$1';
# Payslip Approve
$route['pay-slip-approval'] = 'payroll/approvePayslip';
$route['pay-slip-approval/(:any)'] = 'payroll/approvePayslip/$1';
$route['pay-slip-approval/(:any)/(:any)'] = 'payroll/approvePayslip/$1/$1';
$route['pay-slip-approval/(:any)/(:any)/(:any)/(:any)'] = 'payroll/approvePayslip/$1/$1/$1/$1';
# Payslip Delete
$route['pay-slip-delete/(:any)'] = 'payroll/deletePayslip/$1';
# Payslip Payment
$route['pay-slip-payment'] = 'payroll/paymentPayslip';
$route['pay-slip/(:any)'] = 'payroll/paySlip/$1';
$route['deductions'] = 'payroll/deduction';
$route['allowances'] = 'payroll/allowance';
$route['payment-method'] = 'payroll/paymentMethod';
$route['send-paylip-mail'] = 'payroll/sendPaylipMail';

# Challan
$route['manage-challan'] = 'ChallanController/manageChallan';
$route['add-challan'] = 'ChallanController/addChallan';
$route['delete-challan/(:any)'] = 'ChallanController/deleteChallan/$1';

$route['progress-bar'] = 'payroll/progressBar';

// Upload File
$route['upload-salary-increment'] = 'payroll/uploadSalaryIncrement';

// Store ------------------------------------------------------------

$route['manage-store-category'] = 'StoreController/manageCategory';
$route['manage-store-category/(:any)'] = 'StoreController/manageCategory/$1';
$route['delete-store-category/(:any)'] = 'StoreController/deleteCategory/$1';

$route['manage-store-brand'] = 'StoreController/manageBrand';
$route['manage-store-brand/(:any)'] = 'StoreController/manageBrand/$1';
$route['delete-store-brand/(:any)'] = 'StoreController/deleteBrand/$1';

$route['manage-store-measurement'] = 'StoreController/manageMeasurement';
$route['manage-store-measurement/(:any)'] = 'StoreController/manageMeasurement/$1';
$route['delete-store-measurement/(:any)'] = 'StoreController/deleteMeasurement/$1';

$route['manage-store-item'] = 'StoreController/manageItem';
$route['manage-store-item/(:any)'] = 'StoreController/manageItem/$1';
$route['delete-store-item/(:any)'] = 'StoreController/deleteItem/$1';

$route['manage-store-vendor'] = 'StoreController/manageVendor';
$route['manage-store-vendor/(:any)'] = 'StoreController/manageVendor/$1';
$route['delete-store-vendor/(:any)'] = 'StoreController/deleteVendor/$1';

$route['add-purchase'] = 'PurchaseController/addPurchase';
$route['add-purchase/(:any)'] = 'PurchaseController/addPurchase/$1';
$route['manage-purchase'] = 'PurchaseController/managePurchase';
$route['purchase-invoice/(:any)'] = 'PurchaseController/purchaseInvoice/$1';
$route['received-product'] = 'PurchaseController/receivedProduct';
$route['return-product'] = 'PurchaseController/returnProduct';
$route['delete-received-product/(:any)'] = 'PurchaseController/deleteReceivedPurchase/$1';
$route['delete-returned-product/(:any)'] = 'PurchaseController/deleteReturnedPurchase/$1';
$route['delete-purchase/(:any)'] = 'PurchaseController/deletePurchase/$1';
// Sales
$route['add-sales'] = 'SalesController/addSales';
$route['manage-sales'] = 'SalesController/manageSales';
$route['delivered-sales'] = 'SalesController/deliveredSalesList';
$route['returned-sales'] = 'SalesController/returnedSalesList';
$route['sales-invoice/(:any)'] = 'SalesController/salesInvoice/$1';
$route['delivered-sales/(:any)'] = 'SalesController/deliveredSalesList';
$route['cancel-sales/(:any)'] = 'SalesController/cancelSales/$1';
$route['restore-cancel-sales/(:any)'] = 'SalesController/restoreSales/$1';
$route['delete-sales/(:any)'] = 'SalesController/deleteSales/$1';
$route['delete-delivered-product/(:any)/(:any)/(:any)/(:any)'] = 'SalesController/deleteDeliveredSales/$1/$1/$1/$1';
$route['delete-returned-product/(:any)/(:any)/(:any)/(:any)'] = 'SalesController/deleteSalesReturns/$1/$1/$1/$1';

# Performance

$route['create-performance-session'] = 'PerformanceController/createPerformanceSession';
$route['add-employee-performance'] = 'PerformanceController/addEmployeePerformance';
$route['manage-employee-performance'] = 'PerformanceController/manageEmployeePerformance';
$route['single-employee-performance/(:any)'] = 'PerformanceController/printSinglePerformance/$1';
$route['get-performance-session-info-by-id/(:any)'] = 'PerformanceController/getPerformanceSessionInfoById/$1';
$route['get-employee-info-by-id/(:any)'] = 'PerformanceController/getEmployeeInfoById/$1';



### Report ---
// Stock report--
$route['out-of-stock'] = 'StoreReportController/outOfStock';
$route['available-stock'] = 'StoreReportController/availableStock';
$route['all-stock'] = 'StoreReportController/allStock';
$route['category-wise-stock'] = 'StoreReportController/categoryWiseStock';

// sales report --
$route['employee-wise-sales-report'] = 'StoreReportController/employeeWiseSalesReport';
$route['category-wise-sales-report'] = 'StoreReportController/categoryWiseSalesReport';
$route['item-wise-sales-report'] = 'StoreReportController/itemWiseSalesReport';
$route['date-wise-sales-report'] = 'StoreReportController/dateWiseSalesReport';
$route['month-wise-sales-report'] = 'StoreReportController/monthWiseSalesReport';
$route['year-wise-sales-report'] = 'StoreReportController/yearWiseSalesReport';

// purchase report --
$route['supplier-wise-purchase-report'] = 'StoreReportController/supplierWisePurchaseReport';
$route['category-wise-purchase-report'] = 'StoreReportController/categoryWisePurchaseReport';
$route['item-wise-purchase-report'] = 'StoreReportController/itemWisePurchaseReport';
$route['date-wise-purchase-report'] = 'StoreReportController/dateWisePurchaseReport';
$route['month-wise-purchase-report'] = 'StoreReportController/monthWisePurchaseReport';
$route['year-wise-purchase-report'] = 'StoreReportController/yearWisePurchaseReport';
$route['return-purchase-report'] = 'StoreReportController/returnPurchaseReport';
$route['payment-purchase-report'] = 'StoreReportController/paymentPurchaseReport';

// Attendance Report
$route['get_company_wise_branch'] = 'AttendanceReportController/getCompanyWiseBranch';

$route['daily_attendance_report'] = 'AttendanceReportController/dailyAttendanceReport';
$route['get_daily_attendance_report'] = 'AttendanceReportController/getDailyAttendanceReport';
$route['monthly_attendance_report'] = 'AttendanceReportController/monthlyAttendanceReport';
$route['monthly_attendance_summary_report'] = 'AttendanceReportController/monthlyAttendanceSummaryReport';

# Leave Report
$route['daily_leave_report'] = 'Report/LeaveReportController/daliyLeaveReport';
$route['single_leave_report'] = 'Report/LeaveReportController/singleLeaveReport';
$route['leave_summery_report'] = 'Report/LeaveReportController/leaveSummeryReport'; //yearly
$route['leave_summery_report_monthly'] = 'Report/LeaveReportController/leaveSummeryReportMonthly';

# Payroll Report
$route['pay-slip-report'] = 'Report/PayrollReportController/paySlipReport';
$route['salary-statement'] = 'Report/PayrollReportController/salaryStatement';
$route['salary-statement/(:any)'] = 'Report/PayrollReportController/salaryStatement/$1';
$route['bank-advice'] = 'Report/PayrollReportController/bankAdvice';
$route['export-bank-advice'] = 'Report/PayrollReportController/exportBankAdvice';
$route['salary-certificate'] = 'Report/PayrollReportController/salaryCertificate';
$route['employee-wise-pay-slip-report'] = 'Report/PayrollReportController/employeeWisePayslipReport';

$route['provident-fund-statement'] = 'Report/PayrollReportController/providentFundStatement';
$route['advance-salary-statement'] = 'Report/PayrollReportController/advanceSalaryStatement';
$route['gratuity-statement'] = 'Report/PayrollReportController/gratuityStatement';
$route['incentive-statement'] = 'Report/PayrollReportController/incentiveStatement';
$route['festival-bonus-statement'] = 'Report/PayrollReportController/festivalBonusStatement';
$route['performance-bonus-statement'] = 'Report/PayrollReportController/performanceBonusStatement';
$route['special-bonus-statement'] = 'Report/PayrollReportController/specialBonusStatement';

// api ---
$route['get-employee-info-by-content-id/(:any)'] = 'Api/getEmployeeInfoByContentId/$1';
