<?
include_once "../include/mysql_connect.php";
$sql1="select * from vote_subject where id='".$subject_id."'";
$result1=mysql_query($sql1);
$title=mysql_result($result1,0,1);
$begin_date=mysql_result($result1,0,2);
$end_date=mysql_result($result1,0,3);
$mode=mysql_result($result1,0,4);
$i=0;
$sql2="select * from vote_item where subject_id='".$subject_id."' order by id";
$result2=mysql_query($sql2);
while($r=mysql_fetch_array($result2))
{
	$item_id[$i]=$r[0];
	$item_title[$i]=$r[2];
	$i++;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
<title>ͶƱ�޸�</title>
</head>
<body>
<form action="vote_modify_2.php" method=post name=add>
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>�޸�"ͶƱ"����</caption>
<tr bgcolor=white>
	<td align=right width="25%">���⣺</td>
	<td><input name=title size=30 value=<?=$title?>></td>
</tr>
<tr bgcolor=white>
	<td align=right>��ʼ����</td>
	<td><input name=begin_date value=<?=$begin_date?>></td>
</tr>
<tr bgcolor=white>
	<td align=right>��������</td>
	<td><input name=end_date value=<?=$end_date?>><span class=small>(ͶƱ����һ���Զ�ֹͣ)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>ѡ�</td>
	<td><textarea rows=7 name=item_text cols=29><?
		for($i=0;$i<sizeof($item_id);$i++)
		{
			echo $item_title[$i];
			echo "\r\n";
		}
		?></textarea><br>ע��:һ��Ϊһ��,һ�в�����14��,�ܹ����ܳ���7��!</td>
</tr>
<tr bgcolor=white>
	<td align=right>ѡ��ʽ��</td>
	<td><input type=radio name=mode value=checkbox 
		<?
		if($mode=='checkbox')
		{
			echo ' checked';
		}
		?>
		>��ѡ&nbsp;&nbsp;<input type=radio name=mode value=radio 
		<?
		if($mode=='radio')
		{
			echo ' checked';
		}
		?>
		>��ѡ
<tr bgcolor=white>
	<td colspan=2 align=center>
	<input type=hidden name=subject_id value=<?=$subject_id?>>
	<input type=hidden name=item_id value=<?=implode("|", $item_id)?>>
	<input type=submit value=�ύ�޸�>&nbsp;&nbsp;<input type=reset value="����">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="ȡ���޸�"></td>
</tr>
</table>
</form>
</body>
</html>