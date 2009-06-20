<?php

if ( !defined('IN_MATCH') )
{
	die("Hacking attempt");
}

switch($dbms)
{
	case 'mysql':
		include("./includes/mysql.php");
		break;

	case 'mysql4':
		include($root_path."includes/mysql4.php");
		break;

	case 'postgres':
		include("./includes/postgres7.php");
		break;

	case 'mssql':
		include("./includes/mssql.php");
		break;

	case 'oracle':
		include("./includes/oracle.php");
		break;

	case 'msaccess':
		include("./includes/msaccess.php");
		break;

	case 'mssql-odbc':
		include("./includes/mssql-odbc.php");
		break;
}

// Make the database connection.
$db = new sql_db($dbhost, $dbuser, $dbpasswd, $dbname, false);
if(!$db->db_connect_id)
{
   die("Could not connect to the database");
}
//$db->sql_query("SET character_set_connection=uft-8 , character_set_results=utf-8, character_set_client=binary, sql_mode=''");
//$db->sql_query("set names utf8;");
?>