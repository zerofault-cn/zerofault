<html>
<head>
<title>�޸Ĺ���Ա��Ϣ-1</title>
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
<caption>�޸Ĺ���Ա��Ϣ</caption>
<tr bgcolor=white>
	<td align=right>admin_id:</td>
	<td><?=$admin_id?></td>
</tr>
<tr bgcolor=white>
	<td align=right>����Ա�ʺ�:</td>
	<td><?=$admin_account?></td>
</tr>
<tr bgcolor=white>
	<td align=right>����Ա����:</td>
	<td><input name=admin_name value="<?=$admin_name?>"></td>
</tr>
<tr bgcolor=white>
  <td align=right>��Ч���</td>
  <td><select name=del_flag>
	<option value="1" <? if($del_flag==1) echo "selected";?>>��Ч</option>
	<option value="-1" <? if($del_flag==-1) echo "selected";?>>��Ч</option>	
	</select></td>
</tr>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=hidden name=admin_id value="<?=$admin_id?>"><input type=submit value=�ύ�޸�>&nbsp;&nbsp;<input type=reset value="����">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="ȡ���޸�"></td>
</tr>
</form>
</table>
</body>
</html>