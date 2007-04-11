<?
session_start();
//echo session_id();
if(!session_is_registered("user") && !session_is_registered("admin"))
{
//	header("location:index.php");
}
?>