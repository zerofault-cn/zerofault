<html>
<head>
<title>修改权限类别信息-1</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
<?
include_once "../include/mysql_connect.php";
$sql1="select * from dict_entry where dentry_id='".$dentry_id."'";
$result1=mysql_query($sql1);
$dtype_id		=mysql_result($result1,0,"dtype_id");
$dentry_name	=mysql_result($result1,0,"dentry_name");
$dentry_describe=mysql_result($result1,0,"dentry_describe");
$del_flag		=mysql_result($result1,0,"del_flag");
?>
<form action="admin_modify_limittype_2.php" method=post name=modify>
<table width="100%" border=0 cellspacing=1 cellpadding=0 bgcolor=black>
<caption>修改分类信息</caption>
<tr bgcolor=white>
	<td align=right>项编号:</td>
	<td><input name=dentry_id value="<?=$dentry_id?>" readonly></td>
</tr>
<tr bgcolor=white>
	<td align=right>类型编号:</td>
	<td><input name=dtype_id value="<?=$dtype_id?>" readonly></td>
</tr>
<tr bgcolor=white>
	<td align=right>分类名称:</td>
	<td><input name=dentry_name value="<?=$dentry_name?>"></td>
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
		>无效</option></select><span class=small></span></td>
</tr>
<tr bgcolor=white>
	<td align=right>简短介绍:</td>
	<td><input name=dentry_describe value="<?=$dentry_describe?>"></td>
</tr>

<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value=提交修改>&nbsp;&nbsp;<input type=reset value="重置">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="取消修改"></td>
</tr>
</table>
</form>
</body>
</html>