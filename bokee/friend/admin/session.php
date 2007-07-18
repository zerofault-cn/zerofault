<?
session_start();

if(!session_is_registered("admin"))
{
	header("location:index.php");
}
?>