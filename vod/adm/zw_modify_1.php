<?
function unformat($text)
{
	$text=str_replace('&nbsp;',' ',$text);
	$text=str_replace('<br />',"",$text);
	$text=str_replace('<br>',"",$text);
	return $text;
}
include_once "../include/mysql_connect.php";
$sql1="select * from zw_suining where id=".$id;
$result1=mysql_query($sql1);
$type=mysql_result($result1,0,'type');
$title=mysql_result($result1,0,'title');
$info=mysql_result($result1,0,'info');
?>
<html>
<head>
<title>�޸�</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<form method=post action="zw_modify_2.php" name="modify">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<caption>�޸�"��������"����</caption>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>����:</td>
	<td align=left><INPUT TYPE="text" NAME="title" size=30 value='<?=$title?>'></td>
</tr>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>����:</td>
	<td><textarea name=info rows=8 cols=40><?=unformat($info)?></textarea></td>
</tr>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=hidden name=id value='<?=$id?>'><input type=hidden name=select_flag><input type="submit" value="�ύ�޸�">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="reset" value="&nbsp;����&nbsp;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="ȡ���޸�"></td>
</tr>
</table>
</form>
</body>
</html>