<?php
$dbms='mysql4';
include_once $phpbbs_root_path.'/include/db_class/'.$dbms.'.php';

$dbhost='localhost';
$dbuser='root';
$dbpasswd='';
$dbname='phpbbs';

$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);
if(!$db->db_connect_id)
{
	echo "Could not connect to the database";
}
?>