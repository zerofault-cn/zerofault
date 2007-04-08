<html>
<head>
<title>修改rss_channel-1</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
<?
include_once "../include/mysql_connect.php";
$sql1="select * from rss_channel where id=".$id;
$result1=mysql_query($sql1);
$channel_name	=mysql_result($result1,0,"channel_name");
$channel_description =mysql_result($result1,0,"channel_description");
$del_flag	=mysql_result($result1,0,"del_flag");
?>
<form action="rss_modify_channel_2.php" method=post name=modify>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption>修改分类信息</caption>
<tr bgcolor=white>
	<td align=right>分类ID:</td>
	<td><input name=id value="<?=$id?>" readonly></td>
</tr>
<tr bgcolor=white>
	<td align=right>分类名称:</td>
	<td><input name=channel_name value="<?=$channel_name?>"></td>
</tr>
<tr bgcolor=white>
	<td align=right>简短介绍:</td>
	<td><textarea name=channel_description cols=30 rows=4><?=$channel_description?></textarea></td>
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
	<td colspan=2 align=center><input type=submit value=提交修改>&nbsp;&nbsp;<input type=reset value="重置">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="取消修改"></td>
</tr>
</table>
</form>
</body>
</html>