<?php

class Globals {

// Pass array as an argument to constructor function
public function __construct($config = array()) {
if (function_exists("set_time_limit") == TRUE AND @ini_get("safe_mode") == 0)
	{
		@set_time_limit(30000);
	}
// Create associative array from the passed array

foreach ($config as $key => $value) {
$data[$key] = $value;
}

// Make instance of CodeIgniter to use its resources
$CI = & get_instance();

// Load data into CodeIgniter
$CI->load->vars($data);
}

}

?>