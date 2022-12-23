<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which systems should be loaded by default.
|
| In order to keep the framework as light-weight as possible only the
| absolute minimal resources are loaded by default. For example,
| the database is not connected to automatically since no assumption
| is made regarding whether you intend to use it.  This file lets
| you globally define which systems you would like loaded with every
| request.
|
| -------------------------------------------------------------------
| Instructions
| -------------------------------------------------------------------
|
| These are the things you can load automatically:
|
| 1. Packages
| 2. Libraries
| 3. Drivers
| 4. Helper files
| 5. Custom config files
| 6. Language files
| 7. Models
|
*/

/*
| -------------------------------------------------------------------
|  Auto-load Packages
| -------------------------------------------------------------------
| Prototype:
|
|  $autoload['packages'] = array(APPPATH.'third_party', '/usr/local/shared');
|
*/
$autoload['packages'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Libraries
| -------------------------------------------------------------------
| These are the classes located in system/libraries/ or your
| application/libraries/ directory, with the addition of the
| 'database' library, which is somewhat of a special case.
|
| Prototype:
|
|	$autoload['libraries'] = array('database', 'email', 'session');
|
| You can also supply an alternative library name to be assigned
| in the controller:
|
|	$autoload['libraries'] = array('user_agent' => 'ua');
*/
$autoload['libraries'] = array('database','session','form_validation','email','globals','controllers/add_workingtime_controller', 'controllers/add_provision_controller', 'controllers/add_salary_controller', 'controllers/add_salarydeduction_controller', 'controllers/add_paymentmethod_controller', 'controllers/add_holiday_controller', 'controllers/add_leave_controller', 'controllers/add_company_controller', 'controllers/add_division_controller', 'controllers/addjobtitlecontroller', 'controllers/addtypeofemployeecontroller', 'controllers/addqualificationcontroller', 'controllers/addreligioncontroller', 'controllers/add_marital_status_controller', 'controllers/addbloodgroupcontroller', 'controllers/addpaytypecontroller', 'controllers/addleavetypecontroller', 'controllers/addbanknamecontroller', 'controllers/addcitycontroller', 'controllers/adddistictcontroller', 'controllers/add_relative_controller', 'controllers/addgradecontroller', 'controllers/add_leave_controller', 'controllers/add_tasktype_controller', 'controllers/add_userrole_controller', 'controllers/add_user_controller', 'controllers/add_yearlyholidaytype_controller', 'controllers/add_criteriacategory_controller', 'controllers/add_performancecriteria_controller', 'controllers/add_empperformance_controller' , 'controllers/add_attendance_controller', 'controllers/add_dailyattendance_controller', 'controllers/add_logmaintenence_controller', 'controllers/add_informed_controller', 'controllers/add_empjobhistory_controller', 'controllers/add_empshifthistory_controller', 'controllers/add_weeklyholidayhistory_controller', 'controllers/addcarcosttypecontroller', 'controllers/add_carcost_controller','controllers/add_carrequisition_controller', 'controllers/check_permission_controller', 'controllers/addworkingshiftcontroller','controllers/recruitmentcontroller','controllers/upload_attendance_controller');


/*
| -------------------------------------------------------------------
|  Auto-load Drivers
| -------------------------------------------------------------------
| These classes are located in system/libraries/ or in your
| application/libraries/ directory, but are also placed inside their
| own subdirectory and they extend the CI_Driver_Library class. They
| offer multiple interchangeable driver options.
|
| Prototype:
|
|	$autoload['drivers'] = array('cache');
|
| You can also supply an alternative property name to be assigned in
| the controller:
|
|	$autoload['drivers'] = array('cache' => 'cch');
|
*/
$autoload['drivers'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Helper Files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['helper'] = array('url', 'file');
*/
$autoload['helper'] = array('url','file','form','html','global_helper','date');

/*
| -------------------------------------------------------------------
|  Auto-load Config files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['config'] = array('config1', 'config2');
|
| NOTE: This item is intended for use ONLY if you have created custom
| config files.  Otherwise, leave it blank.
|
*/
$autoload['config'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Language files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['language'] = array('lang1', 'lang2');
|
| NOTE: Do not include the "_lang" part of your file.  For example
| "codeigniter_lang.php" would be referenced as array('codeigniter');
|
*/
$autoload['language'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Models
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['model'] = array('first_model', 'second_model');
|
| You can also supply an alternative model name to be assigned
| in the controller:
|
|	$autoload['model'] = array('first_model' => 'first');
*/
$autoload['model'] = array('company_info','role_model','users_model','hs_hr_country', 'taxonomy', 'employee_id_model','emp_details_model','search_field_emp_model', 'emp_working_time_model', 'emp_provision_model', 'emp_payment_method_model', 'emp_salary_deduction_model', 'emp_salary_model', 'emp_holiday_model','search_query_model', 'emp_leave_model', 'mycalholiday_model', 'emp_performance_model', 'emp_attendance_model', 'log_maintenence_model', 'emp_informed_model', 'emp_job_history_model', 'emp_shift_history_model','emp_weeklyholiday_history_model', 'emp_yearly_leave_history_model','car_info_model','re_circular_model');
