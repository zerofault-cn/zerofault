<html>
<head>
<title>修改电影类别信息-1</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
<?
include_once "../include/mysql_connect.php";
$sql1="select * from daily_type where id='".$id."'";
$result1=mysql_query($sql1);
$type_name	=mysql_result($result1,0,"type_name");
$type_descr	=mysql_result($result1,0,"type_descr");
$del_flag	=mysql_result($result1,0,"del_flag");
?>
<form action="daily_modify_type_2.php" method=post name=modify>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption>修改分类信息</caption>
<tr bgcolor=white>
	<td align=right>分类ID:</td>
	<td><input name=id value="<?=$id?>" readonly></td>
</tr>
<tr bgcolor=white>
	<td align=right>分类名称:</td>
	<td><input name=type_name value="<?=$type_name?>"></td>
</tr>
<tr bgcolor=white>
	<td align=right>简短介绍:</td>
	<td><textarea name=type_descr cols=30 rows=4><?=$type_descr?></textarea></td>
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