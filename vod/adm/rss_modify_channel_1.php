<html>
<head>
<title>�޸�rss_channel-1</title>
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
<caption>�޸ķ�����Ϣ</caption>
<tr bgcolor=white>
	<td align=right>����ID:</td>
	<td><input name=id value="<?=$id?>" readonly></td>
</tr>
<tr bgcolor=white>
	<td align=right>��������:</td>
	<td><input name=channel_name value="<?=$channel_name?>"></td>
</tr>
<tr bgcolor=white>
	<td align=right>��̽���:</td>
	<td><textarea name=channel_description cols=30 rows=4><?=$channel_description?></textarea></td>
</tr>
<tr bgcolor=white>
	<td align=right>��Ч��־:</td>
	<td><select name=del_flag>
		<option value="1" 
		<?
		if($del_flag==1)
			echo " selected";
		?>
		>��Ч</option>
		<option value="-1" 
		<?
		if($del_flag==-1)
			echo " selected";
		?>
		>��Ч</option></select></td>
</tr>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value=�ύ�޸�>&nbsp;&nbsp;<input type=reset value="����">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="ȡ���޸�"></td>
</tr>
</table>
</form>
</body>
</html>