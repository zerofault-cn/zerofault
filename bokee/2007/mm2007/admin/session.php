<?
session_start();
//echo session_id();
if(!session_is_registered("user") && !session_is_registered("admin"))
{
	header("location:index.php");
}
if(session_is_registered("admin"))
{
	$sysadmin=true;
}
if(session_is_registered("user"))
{
	$btnfn=" disabled";//������ͨ�û��Ĺ���Ա�԰�ť�Ĳ���Ȩ��button function
}
?>