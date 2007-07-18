<?
session_start();
//echo session_id();
if(!session_is_registered("user") && !session_is_registered("admin"))
{
	header("location:index.php");
}
$is_admin=false;
if(session_is_registered("admin"))
{
	$is_admin=true;
}
?>