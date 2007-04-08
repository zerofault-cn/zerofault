<?
include_once "../include/mysql_connect.php";
$sql1="select * from rss_type where rss_type_id='".$rss_type_id."'";
$result1=mysql_query($sql1);
?>
<HTML>
<HEAD>
<META content="text/html; charset=gb2312" http-equiv=Content-Type>
<title>modify_RSS_type_name</title>
<script language="javascript">
function check()
{
	
	if(window.document.add.rss_type_name.value=="")
	{
		alert("您忘了输入分类名");
		document.add.rss_type_name.focus();
		return false;
	}
	return true;
}
</script>
</HEAD>
<body >
<form action="rss_modify_type_name_2.php" method=post name=add onsubmit="return check();">
<table width="100%" border=0 cellspacing=1 cellpadding=2 bgcolor=black>
<tr bgcolor=white>
	<td align=right>新分类名:</td>
	<td><input name=rss_type_name size=30 maxlength=30 value=<?=mysql_result($result1,0,"rss_type_name")?>></td>
</tr>
<tr bgcolor=white>
	<td align=right>简短介绍:</td>
	<td><textarea name=rss_type_descr cols=35 rows=4><?=mysql_result($result1,0,"rss_type_descr")?></textarea></td>
</tr>
<tr bgcolor=white>
	<td align=right><input type=hidden name=rss_type_id value=<?=$rss_type_id?>></td>
	<td><input type=submit value="提交修改">&nbsp;<input type=button onclick="javascript:window.close()" value="取消修改"></td>
</tr>
</table>
</form>
</body>
</html>
