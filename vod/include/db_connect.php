<?php
$dbms='mysql';
$db_class_path='../include/db_class/';
include_once $db_class_path.$dbms.'.php';

$dbhost='localhost';
//$dbhost='192.168.0.238';
$dbuser='root';
$dbpasswd='';
$dbname='BOD_WIN';

$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);
if(!$db->db_connect_id)
{
	echo "Could not connect to the database!<br>\r\n";
}
?>