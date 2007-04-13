<?
/*
include_once "../include/db_connect.php";
$sql1="select * from flash_source where id=".$id;
$result1=$db->sql_query($sql1);
$flash_name=$db->sql_fetchfield(2,0,$result1);
$flash_path=$db->sql_fetchfield(3,0,$result1);
$intro=$db->sql_fetchfield(4,0,$result1);
$time=$db->sql_fetchfield(7,0,$result1);
*/
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>无标题文档</title>
<script language="JavaScript" type="text/JavaScript">
function esdOn()
{
//	location="game://esdon";
}
function esdOff()
{
//	location="game://esdoff";
}
function keyDown(e)
{
	var keycode=e.which;
	if(keycode==36)
	{
		location="javascript:history.go(-1)";
	}
}
document.onkeydown=keyDown

</script>

</head>
<body topmargin=0 leftmargin=0>
<embed src="../flash/wudixiaopaopao.swf" quality="low" type="application/x-shockwave-flash" width="800" height="590"></embed>
</body>
</html>
