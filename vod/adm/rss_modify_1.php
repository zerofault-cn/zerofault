<html>
<head>
<title>修改RSS</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
<?
include_once "../include/mysql_connect.php";
$sql1="select * from rss_source where id=".$id;
$result1=mysql_query($sql1);
$rss_source_url	=mysql_result($result1,0,"rss_source_url");
$rss_source_name=mysql_result($result1,0,"rss_source_name");
$del_flag		=mysql_result($result1,0,"del_flag");
$prefetch		=mysql_result($result1,0,"prefetch");
?>
<form action="rss_modify_2.php" method=post name=modify>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption>修改RSS资源信息</caption>
<tr bgcolor=white>
	<td align=right>资源名称:</td>
	<td><input name=rss_source_name value="<?=$rss_source_name?>"></td>
</tr>
<tr bgcolor=white>
	<td align=right>资源URL:</td>
	<td><input name=rss_source_url size=40 value="<?=$rss_source_url?>"></td>
</tr>
<tr bgcolor=white>
	<td align=right>有效标志:</td>
	<td><select name=del_flag>
		<option value="1" 
		<?
		if($del_flag==1)
			echo " selected";
		?>
		>有效</option>
		<option value="-1" 
		<?
		if($del_flag==-1)
			echo " selected";
		?>
		>无效</option></select></td>
</tr>
<tr bgcolor=white>
	<td align=right>需要预取:</td>
	<td><input type=checkbox name=prefetch value=1 <?if($prefetch)echo ' checked'?>></td>
</tr>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=hidden name=id value=<?=$id?>><input type=submit value=提交修改>&nbsp;&nbsp;<input type=reset value="重置">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="取消修改"></td>
</tr>
</table>
</form>
</body>
</html>