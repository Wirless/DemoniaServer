<?PHP
date_default_timezone_set('America/Sao_Paulo');
ob_start('ob_gzhandler');
header('Connection: close');
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest')
	exit();

header('X-Ajax-Cip-Response-Type: Container');

function f($e) {
	die('{"AjaxObjects": [{"DataType": "Attributes","Data": "style=background-image:url(account/nok.gif)","Target": "#email_indicator"},{"DataType": "HTML","Data": "'.$e.'","Target": "#email_errormessage"},{"DataType": "Attributes","Data": "class=red","Target": "#email_label"}]}');
}

$s = isset($_POST['a_EMail']) ? $_POST['a_EMail'] : '';

if($s == '')
	f('Please enter your email address!');
elseif(strlen($s) > 49)
	f('Your email address is too long!');
elseif(!filter_var($s, FILTER_VALIDATE_EMAIL))
	f('This email address has an invalid format. Please enter a correct email address!');

$c = parse_ini_file('../config/config.ini');
$c = parse_ini_file($c['server_path'].'config.lua');

$conn = mysql_pconnect($c['sqlHost'], $c['sqlUser'], $c['sqlPass']) or die();
mysql_select_db($c['sqlDatabase']);

if(mysql_num_rows(mysql_query('SELECT id FROM accounts WHERE email=\''.mysql_escape_string($s).'\' LIMIT 1')) != 0)
	f('This email address is already used. Please enter another email address!');

echo '{"AjaxObjects": [{"DataType": "Attributes","Data": "style=background-image:url(https://static.tibia.com/images/global/general/ok.gif);","Target": "#email_indicator"},{"DataType": "HTML","Data": "","Target": "#email_errormessage"},{"DataType": "Attributes","Data": "class=","Target": "#email_label"}]}';
ob_end_flush();
?>