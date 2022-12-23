<?php

function pr(&$a)
{
    echo '<pre>';
    print_r($a);
    echo '</pre>';
}

function vd(&$a)
{
    echo '<pre>';
    var_dump($a);
    echo '</pre>';
}
function record_sort($records, $field, $reverse=false)
{
    $hash = array();
   
    foreach($records as $record)
    {
        $hash[$record[$field]] = $record;
    }
   
    ($reverse)? krsort($hash) : ksort($hash);
   
    $records = array();
   
    foreach($hash as $record)
    {
        $records []= $record;
    }
   
    return $records;
}

function is_valid_url($url)
{
    return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}

function load_img($filename,$params=array())
{
	$params_str = "";
	foreach($params as $key=>$param)
	{
		$params_str .= $key.'="'.$param.'" ';
	}
	return '<img src="'.base_url().'resources/images/'.$filename.'" '.$params_str.'>';
}

function getIndex($arrayName,$index)
{
	if(isset($arrayName[$index]))
		return $arrayName[$index];
	else
		return FALSE;
}

function formatDate($dt)
{
	$tstamp = strtotime($dt);
	return date("D jS M, Y ",$tstamp);
}
 
function formatTime($dt)
{
	$tstamp = strtotime($dt);
	return date("g:i a",$tstamp);
}

// function yearago($previousdate, $reference = null)
// {
// 	date_default_timezone_set('Asia/Dhaka');
//     $reference = $reference ?: new DateTime;

//     $diff = $reference->diff($previousdate);
//     $length = ($d = $diff->d) ? ' and '.$d.' '.str_plural('day', $d) : '';
//     $length = ($m = $diff->m) ? ($length ? ', ' : ' and ').$m.' '.str_plural('month', $m).$length : $length;
//     $length = ($y = $diff->y) ? $y.' '.str_plural('year', $y).$length  : $length;

//     // trim redundant ',' or 'and' parts
//     return ($s = trim(trim($length, ', '), ' and ')) ? $s.' old' : 'newborn';
// }
 
function ago($time)
{
    $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths = array("60","60","24","7","4.35","12","10");
	date_default_timezone_set('Asia/Dhaka');
    $now = time();

    $difference     = $now - $time;
    $tense         = "ago";

    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }

    $difference = round($difference);

    if($difference != 1) {
        $periods[$j].= "s";
    }

    return "$difference $periods[$j] ago ";
}

function formatDateTime($dt)
{
	$tstamp = strtotime($dt);
	return date("D jS M, Y (g:i a)",$tstamp);
}

function lq()
{
	// helper to show last query
	$CI =& get_instance();
	echo "<pre class='smalltext'>".htmlentities($CI->db->last_query())."</pre>";
}

function getCountryList($index=null)
{
	$countries = array(
		'-'=>' -Select- ',
		'AF'=>'Afghanistan',
		'AL'=>'Albania',
		'DZ'=>'Algeria',
		'AS'=>'American Samoa',
		'AD'=>'Andorra',
		'AO'=>'Angola',
		'AI'=>'Anguilla',
		'AQ'=>'Antarctica',
		'AG'=>'Antigua and Barbuda',
		'AR'=>'Argentina',
		'AM'=>'Armenia',
		'AW'=>'Aruba',
		'AU'=>'Australia',
		'AT'=>'Austria',
		'AZ'=>'Azerbaijan',
		'BS'=>'Bahamas',
		'BH'=>'Bahrain',
		'BD'=>'Bangladesh',
		'BB'=>'Barbados',
		'BY'=>'Belarus',
		'BE'=>'Belgium',
		'BZ'=>'Belize',
		'BJ'=>'Benin',
		'BM'=>'Bermuda',
		'BT'=>'Bhutan',
		'BO'=>'Bolivia',
		'BA'=>'Bosnia and Herzegovina',
		'BW'=>'Botswana',
		'BV'=>'Bouvet Island',
		'BR'=>'Brazil',
		'IO'=>'British Indian Ocean Territory',
		'BN'=>'Brunei Darussalam',
		'BG'=>'Bulgaria',
		'BF'=>'Burkina Faso',
		'BI'=>'Burundi',
		'KH'=>'Cambodia',
		'CM'=>'Cameroon',
		'CA'=>'Canada',
		'CV'=>'Cape Verde',
		'KY'=>'Cayman Islands',
		'CF'=>'Central African Republic',
		'TD'=>'Chad',
		'CL'=>'Chile',
		'CN'=>'China',
		'CX'=>'Christmas Island',
		'CC'=>'Cocos (Keeling) Islands',
		'CO'=>'Colombia',
		'KM'=>'Comoros',
		'CG'=>'Congo',
		'CD'=>'Congo, the Democratic Republic of the',
		'CK'=>'Cook Islands',
		'CR'=>'Costa Rica',
		'CI'=>'Cote D\'Ivoire',
		'HR'=>'Croatia',
		'CU'=>'Cuba',
		'CY'=>'Cyprus',
		'CZ'=>'Czech Republic',
		'DK'=>'Denmark',
		'DJ'=>'Djibouti',
		'DM'=>'Dominica',
		'DO'=>'Dominican Republic',
		'EC'=>'Ecuador',
		'EG'=>'Egypt',
		'SV'=>'El Salvador',
		'GQ'=>'Equatorial Guinea',
		'ER'=>'Eritrea',
		'EE'=>'Estonia',
		'ET'=>'Ethiopia',
		'FK'=>'Falkland Islands (Malvinas)',
		'FO'=>'Faroe Islands',
		'FJ'=>'Fiji',
		'FI'=>'Finland',
		'FR'=>'France',
		'GF'=>'French Guiana',
		'PF'=>'French Polynesia',
		'TF'=>'French Southern Territories',
		'GA'=>'Gabon',
		'GM'=>'Gambia',
		'GE'=>'Georgia',
		'DE'=>'Germany',
		'GH'=>'Ghana',
		'GI'=>'Gibraltar',
		'GR'=>'Greece',
		'GL'=>'Greenland',
		'GD'=>'Grenada',
		'GP'=>'Guadeloupe',
		'GU'=>'Guam',
		'GT'=>'Guatemala',
		'GN'=>'Guinea',
		'GW'=>'Guinea-Bissau',
		'GY'=>'Guyana',
		'HT'=>'Haiti',
		'HM'=>'Heard Island and Mcdonald Islands',
		'VA'=>'Holy See (Vatican City State)',
		'HN'=>'Honduras',
		'HK'=>'Hong Kong',
		'HU'=>'Hungary',
		'IS'=>'Iceland',
		'IN'=>'India',
		'ID'=>'Indonesia',
		'IR'=>'Iran, Islamic Republic of',
		'IQ'=>'Iraq',
		'IE'=>'Ireland',
		'IL'=>'Israel',
		'IT'=>'Italy',
		'JM'=>'Jamaica',
		'JP'=>'Japan',
		'JO'=>'Jordan',
		'KZ'=>'Kazakhstan',
		'KE'=>'Kenya',
		'KI'=>'Kiribati',
		'KP'=>'Korea, Democratic People\'s Republic of',
		'KR'=>'Korea, Republic of',
		'KW'=>'Kuwait',
		'KG'=>'Kyrgyzstan',
		'LA'=>'Lao People\'s Democratic Republic',
		'LV'=>'Latvia',
		'LB'=>'Lebanon',
		'LS'=>'Lesotho',
		'LR'=>'Liberia',
		'LY'=>'Libyan Arab Jamahiriya',
		'LI'=>'Liechtenstein',
		'LT'=>'Lithuania',
		'LU'=>'Luxembourg',
		'MO'=>'Macao',
		'MK'=>'Macedonia, the Former Yugoslav Republic of',
		'MG'=>'Madagascar',
		'MW'=>'Malawi',
		'MY'=>'Malaysia',
		'MV'=>'Maldives',
		'ML'=>'Mali',
		'MT'=>'Malta',
		'MH'=>'Marshall Islands',
		'MQ'=>'Martinique',
		'MR'=>'Mauritania',
		'MU'=>'Mauritius',
		'YT'=>'Mayotte',
		'MX'=>'Mexico',
		'FM'=>'Micronesia, Federated States of',
		'MD'=>'Moldova, Republic of',
		'MC'=>'Monaco',
		'MN'=>'Mongolia',
		'MS'=>'Montserrat',
		'MA'=>'Morocco',
		'MZ'=>'Mozambique',
		'MM'=>'Myanmar',
		'NA'=>'Namibia',
		'NR'=>'Nauru',
		'NP'=>'Nepal',
		'AN'=>'Netherlands Antilles',
		'NL'=>'Netherlands',
		'NC'=>'New Caledonia',
		'NZ'=>'New Zealand',
		'NI'=>'Nicaragua',
		'NE'=>'Niger',
		'NG'=>'Nigeria',
		'NU'=>'Niue',
		'NF'=>'Norfolk Island',
		'MP'=>'Northern Mariana Islands',
		'NO'=>'Norway',
		'OM'=>'Oman',
		'PK'=>'Pakistan',
		'PW'=>'Palau',
		'PS'=>'Palestinian Territory, Occupied',
		'PA'=>'Panama',
		'PG'=>'Papua New Guinea',
		'PY'=>'Paraguay',
		'PE'=>'Peru',
		'PH'=>'Philippines',
		'PN'=>'Pitcairn',
		'PL'=>'Poland',
		'PT'=>'Portugal',
		'PR'=>'Puerto Rico',
		'QA'=>'Qatar',
		'RE'=>'Reunion',
		'RO'=>'Romania',
		'RU'=>'Russian Federation',
		'RW'=>'Rwanda',
		'SH'=>'Saint Helena',
		'LC'=>'Saint Lucia',
		'PM'=>'Saint Pierre and Miquelon',
		'KN'=>'Saint Kitts and Nevis',
		'VC'=>'Saint Vincent and the Grenadines',
		'WS'=>'Samoa',
		'SM'=>'San Marino',
		'ST'=>'Sao Tome and Principe',
		'SA'=>'Saudi Arabia',
		'SN'=>'Senegal',
		'CS'=>'Serbia and Montenegro',
		'SC'=>'Seychelles',
		'SL'=>'Sierra Leone',
		'SG'=>'Singapore',
		'SK'=>'Slovakia',
		'SI'=>'Slovenia',
		'SB'=>'Solomon Islands',
		'SO'=>'Somalia',
		'ZA'=>'South Africa',
		'GS'=>'South Georgia and the South Sandwich Islands',
		'ES'=>'Spain',
		'LK'=>'Sri Lanka',
		'SD'=>'Sudan',
		'SR'=>'Suriname',
		'SJ'=>'Svalbard and Jan Mayen',
		'SZ'=>'Swaziland',
		'SE'=>'Sweden',
		'CH'=>'Switzerland',
		'SY'=>'Syrian Arab Republic',
		'TW'=>'Taiwan, Province of China',
		'TJ'=>'Tajikistan',
		'TZ'=>'Tanzania, United Republic of',
		'TH'=>'Thailand',
		'TL'=>'Timor-Leste',
		'TG'=>'Togo',
		'TK'=>'Tokelau',
		'TO'=>'Tonga',
		'TT'=>'Trinidad and Tobago',
		'TN'=>'Tunisia',
		'TR'=>'Turkey',
		'TM'=>'Turkmenistan',
		'TC'=>'Turks and Caicos Islands',
		'TV'=>'Tuvalu',
		'UG'=>'Uganda',
		'UA'=>'Ukraine',
		'GB'=>'United Kingdom',
		'US'=>'United States',
		'AE'=>'United Arab Emirates',
		'UM'=>'United States Minor Outlying Islands',
		'UY'=>'Uruguay',
		'UZ'=>'Uzbekistan',
		'VU'=>'Vanuatu',
		'VE'=>'Venezuela',
		'VN'=>'Viet Nam',
		'VG'=>'Virgin Islands, British',
		'VI'=>'Virgin Islands, U.s.',
		'WF'=>'Wallis and Futuna',
		'EH'=>'Western Sahara',
		'YE'=>'Yemen',
		'ZM'=>'Zambia',
		'ZW'=>'Zimbabwe'
	);

	if(is_null($index))
		return $countries;
	else
	{
		if(strlen($index)>2)
		{
			$key = array_search($index,$countries);
			return $key;
		}
		else
		{
			if(isset($countries[$index]))
				return $countries[$index];
			else
				return "";
		}

	}
}
//
////function to load he external js files not pertaining to controllers and action
//file name would be relative to js folder
function load_js($js_file=NULL)
{
	if($js_file!=NULL){
		return '<script language="javascript" src="'.base_url().'resources/js/'.$js_file.'"></script>';
	}
}

function load_css($css_file=NULL)
{
	if($css_file!=NULL){
		return '<link rel="stylesheet" href="'.base_url().'resources/css/'.$css_file.'" />';
	}
}

function getCurrentDateTime()
{
	date_default_timezone_set('Asia/Dhaka');
	$servertime = time();
	return date("d-m-Y H:i:s", $servertime);	
}
//debug helper function
function showArray($param) {
    echo '<pre>';
    print_r($param);
    echo '</pre>';
}

function findCustomWeeksStartTimestamp($timeStamp = 0){
     if($timeStamp == 0)
            $current_time = strtotime('today');
        else
            $current_time = strtotime('today',$timeStamp);
        // since the day of the week starts from thursday, we are getting the offset from thursday
            $weekday_offset = 4 - date('w',$current_time);
//            $week_start = '';
            if($weekday_offset > 0)
            {
                $week_start = $current_time + ($weekday_offset*24*60*60) - (7*24*60*60);

            }
            else
            {
                $week_start = $current_time + ($weekday_offset*24*60*60);

            }
            // showArray($week_start); die;
    return $week_start;
}

function invoiceTotal($resident_id){
    $CI =& get_instance();
}
function receiptTotal($resident_id){

}
// function get_time_difference($time1, $time2) 
// { 
//     $time1 = strtotime("1/1/1980 $time1"); 
//     $time2 = strtotime("1/1/1980 $time2"); 
     
//     if ($time2 < $time1) 
//     { 
//         $time2 = $time2 + 86400; 
//     } 
     
//     return ($time2 - $time1) / 3600; 
     
// } 

 
function get_time_difference($dtime,$atime){
 
 $nextDay=$dtime>$atime?1:0;
 $dep=EXPLODE(':',$dtime);
 $arr=EXPLODE(':',$atime);
 $diff=ABS(MKTIME($dep[0],$dep[1],$dep[2],DATE('n'),DATE('j'),DATE('y'))-MKTIME($arr[0],$arr[1],$arr[2],DATE('n'),DATE('j')+$nextDay,DATE('y')));
 $hours=FLOOR($diff/(60*60));
 $mins=FLOOR(($diff-($hours*60*60))/(60));
 $secs=FLOOR(($diff-(($hours*60*60)+($mins*60))));
 IF(STRLEN($hours)<2){$hours="0".$hours;}
 IF(STRLEN($mins)<2){$mins="0".$mins;}
 IF(STRLEN($secs)<2){$secs="0".$secs;}
 RETURN $hours.':'.$mins.':'.$secs;
}
// function get_time_difference($time1, $time2) {
//     $time1 = strtotime("1980-01-01 $time1");
//     $time2 = strtotime("1980-01-01 $time2");
    
//     if ($time2 < $time1) {
//         $time2 += 86400;
//     }
    
//     return date("H:i:s", strtotime("1980-01-01 00:00:00") + ($time2 - $time1));
// }

function dateRange( $first, $last, $step = '+1 day', $format = 'd-m-Y' ) {

	$dates = array();
	$current = strtotime( $first );
	$last = strtotime( $last );

	while( $current <= $last ) {

		$dates[] = date( $format, $current );
		$current = strtotime( $step, $current );
	}

	return $dates;
}

?>
