﻿<?PHP
echo '<?xml version="1.0" encoding="utf-8" standalone="yes"?>';
$config_ini = parse_ini_file('../config/config.ini');
include('../config/config.php');
$name = strtolower(stripslashes(trim($_REQUEST['name'])));
if(empty($name))
{
	echo '<font color="red">Please enter new character name.</font>';
	exit;
}

//first word can't be:
$first_words_blocked = array('drugovich', 'drugo', 'adm', 'gm ','cm ', 'god ','tutor ', "'", '-');
//names blocked:
$names_blocked = array('puta', 'simoni', 'simone', 'porra', 'buceta', 'caralho', 'thunder', 'training', 'trimera', 'serve', 'drugovich', 'drugo', 'adm', 'gm', 'cm', 'god', 'tutor');
//name can't contain:
$words_blocked = array('gamemaster', 'game master', 'game-master', "game'master", '  ', '--', "''","' ", " '", '- ', ' -', "-'", "'-", 'fuck', 'sux', 'suck', 'noob', 'tutor');
$temp = strspn("$name", "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM- '");
if($temp != strlen($name))
{
	echo '<font color="red">Name contains illegal letters. Use only: <b>qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM- \'</b></font>';
	exit;
}
if(strlen($name) > 19)
{
	echo '<font color="red">Too long name. Max. lenght <b>19</b> letters.</font>';
	exit;
}
foreach($names_blocked as $word)
	if($word == $name)
	{
		echo '<font color="red">Blocked names:<b> '.$names_blocked[0];
		if(count($names_blocked) > 1)
			foreach($names_blocked as $word)
				if($word != $names_blocked[0])
					echo ','.$word;
		echo '</b></font>';
		exit;
	}
foreach($config['site']['monsters'] as $word)
	if($word == $name)
	{
		echo '<font color="red"><b>You can not use monster name.</b></font>';
		exit;
	}
foreach($config['site']['npc'] as $word)
	if($word == $name)
	{
		echo '<font color="red"><b>You can not use NPC name.</b></font>';
		exit;
	}	
foreach($first_words_blocked as $word)
	if($word == substr($name, 0, strlen($word)))
	{
		echo '<font color="red">First letters in name can\'t be:<b> '.$first_words_blocked[0];
		if(count($first_words_blocked) > 1)
			foreach($first_words_blocked as $word)
				if($word != $first_words_blocked[0])
					echo ','.$word;
		echo '</b></font>';
		exit;
	}
if(substr($name, -1) == "'" || substr($name, -1) == "-")
{
	echo '<font color="red">Last letter can\'t be <b>\'</b> and <b>-</b></font>';
	exit;
}
foreach($words_blocked as $word)
	if (!(strpos($name, $word) === false))
	{
		echo '<font color="red">Name can\'t cointain words:<b> '.$words_blocked[0];
		if(count($words_blocked) > 1)
			foreach($words_blocked as $word)
				if($word != $words_blocked[0])
					echo ','.$word;
		echo '</b></font>';
		exit;
	}
for($i = 0; $i < strlen($name); $i++)
	if($name[$i] == $name[($i+1)] && $name[$i] == $name[($i+2)])
	{
		echo '<font color="red">Name can\'t contain 3 same letters one by one.</font><br /><font color="green"><u>Good:</u> M<b>oo</b>nster</font><font color="red"><br />Wrong: M<b>ooo</b>nster</font>';
		exit;
	}
for($i = 0; $i < strlen($name); $i++)
	if($name[$i-1] == ' ' && $name[$i+1] == ' ')
	{
		echo '<font color="red">Use normal name format.</font><br /><font color="green"><u>Good:</u> <b>Gesior</b></font><font color="red"><br />Wrong: <b>G e s ior</b></font>';
		exit;
	}
if(substr($name, 1, 1) == ' ')
{
	echo '<font color="red">Use normal name format.</font><br /><font color="green"><u>Good:</u> <b>Gesior</b></font><font color="red"><br />Wrong: <b>G esior</b></font>';
	exit;
}
if(substr($name, -2, 1) == " ")
{
	echo '<font color="red">Use normal name format.</font><br /><font color="green"><u>Good:</u> <b>Gesior</b></font><font color="red"><br />Wrong: <b>Gesio r</b></font>';
	exit;
}
else
		//connect to DB
		$server_config = parse_ini_file($config_ini['server_path'].'config.lua');
		if(isset($server_config['mysqlHost']))
		{
			//new (0.2.6+) ots config.lua file
			$mysqlhost = $server_config['mysqlHost'];
			$mysqluser = $server_config['mysqlUser'];
			$mysqlpass = $server_config['mysqlPass'];
			$mysqldatabase = $server_config['mysqlDatabase'];
			$sqlitefile = $server_config['sqliteDatabase'];
		}
		elseif(isset($server_config['sqlHost']))
		{
			//old (0.2.4) ots config.lua file
			$mysqlhost = $server_config['sqlHost'];
			$mysqluser = $server_config['sqlUser'];
			$mysqlpass = $server_config['sqlPass'];
			$mysqldatabase = $server_config['sqlDatabase'];
			$sqlitefile = $server_config['sqliteDatabase'];
		}
		// loads #####POT mainfile#####
		include('../pot/OTS.php');
		// PDO and POT connects to database
		$ots = POT::getInstance();
		if($server_config['sqlType'] == "mysql")
			$ots->connect(POT::DB_MYSQL, array('host' => $mysqlhost, 'user' => $mysqluser, 'password' => $mysqlpass, 'database' => $mysqldatabase) );
		elseif($server_config['sqlType'] == "sqlite")
			$ots->connect(POT::DB_SQLITE, array('database' => $config_ini['server_path'].$sqlitefile));
		$name_db = new OTS_Player();
		$name_db->find($name);
		if($name_db->isLoaded())
			echo '<font color="red"><b>Player with this name already exist.</b></font>';
		else
			echo '<font color="green">Good. Your name will be:<br />"<b>'.ucwords($name).'</b>"</font>';

?>