<?php
$phpbbs_root_path='..';
$dbms='mssql';
include_once $phpbbs_root_path.'/include/db_class/'.$dbms.'.php';

$dbhost='211.152.20.41:20433';
$dbuser='btblog_client';
$dbpasswd='49CE-B1F5-5C4A1AFA6DBC';
$dbname='btblog';

$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);
if(!$db->db_connect_id)
{
	echo "Could not connect to the database";
}
else
{
	echo 'ok';
}
?>