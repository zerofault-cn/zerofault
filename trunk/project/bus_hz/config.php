<?php
error_reporting(E_ALL ^ E_NOTICE);
if(!defined("PATH_ROOT"))
{
	define("PATH_ROOT", dirname(__FILE__));
}
if($_SERVER['HTTP_HOST']=='zerofault.oxyhost.com')
{
	$dbhost = 'localhost';
	$dbname = 'zerofault_bus';
	$dbuser = 'zerofault_root';
	$dbpasswd = '123456';
}
else
{
	$dbhost = 'localhost';
	$dbname = 'bus';
	$dbuser = 'root';
	$dbpasswd = '';
}
include_once(PATH_ROOT.'/include/mysql.php');
$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);
if(!$db->db_connect_id)
{
	die("Could not connect to the database");
}

if(!defined("LINE_TABLE"))
{
	define("LINE_TABLE", 'hz_line');
	define("SITE_TABLE", 'hz_site');
	define("ROUTE_TABLE",'hz_route');
}


include_once(PATH_ROOT.'/include/template.php');
$tpl = new Template(PATH_ROOT."/template");

?>
