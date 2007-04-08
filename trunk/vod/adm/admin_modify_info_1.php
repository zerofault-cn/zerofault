<html>
<head>
<title>修改管理员信息-1</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<?
include_once "../include/mysql_connect.php";
$sql1= "select * from admin_info where admin_id='".$admin_id."'";
$result1=mysql_query($sql1);
$admin_account=mysql_result($result1,0,1);
$admin_name=mysql_result($result1,0,2);
$del_flag=mysql_result($result1,0,6);
?>
<table width="100%" border=0 cellspacing=1 cellpadding=0 bgcolor=black align=center>
<form action="admin_modify_info_2.php" method=post name=amend>
<caption>修改管理员信息</caption>
<tr bgcolor=white>
	<td align=right>admin_id:</td>
	<td><?=$admin_id?></td>
</tr>
<tr bgcolor=white>
	<td align=right>管理员帐号:</td>
	<td><?=$admin_account?></td>
</tr>
<tr bgcolor=white>
	<td align=right>管理员真名:</td>
	<td><input name=admin_name value="<?=$admin_name?>"></td>
</tr>
<tr bgcolor=white>
  <td align=right>有效标记</td>
  <td><select name=del_flag>
	<option value="1" <? if($del_flag==1) echo "selected";?>>有效</option>
	<option value="-1" <? if($del_flag==-1) echo "selected";?>>无效</option>	
	</select></td>
</tr>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=hidden name=admin_id value="<?=$admin_id?>"><input type=submit value=提交修改>&nbsp;&nbsp;<input type=reset value="重置">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="取消修改"></td>
</tr>
</form>
</table>
</body>
</html>