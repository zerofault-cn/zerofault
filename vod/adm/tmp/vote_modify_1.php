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
<title>投票修改</title>
</head>
<body>
<form action="vote_modify_2.php" method=post name=add>
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>修改"投票"主题</caption>
<tr bgcolor=white>
	<td align=right width="25%">主题：</td>
	<td><input name=title size=30 value=<?=$title?>></td>
</tr>
<tr bgcolor=white>
	<td align=right>开始日期</td>
	<td><input name=begin_date value=<?=$begin_date?>></td>
</tr>
<tr bgcolor=white>
	<td align=right>结束日期</td>
	<td><input name=end_date value=<?=$end_date?>><span class=small>(投票到这一天自动停止)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>选项：</td>
	<td><textarea rows=7 name=item_text cols=29><?
		for($i=0;$i<sizeof($item_id);$i++)
		{
			echo $item_title[$i];
			echo "\r\n";
		}
		?></textarea><br>注意:一行为一项,一行不超过14字,总共不能超过7行!</td>
</tr>
<tr bgcolor=white>
	<td align=right>选择方式：</td>
	<td><input type=radio name=mode value=checkbox 
		<?
		if($mode=='checkbox')
		{
			echo ' checked';
		}
		?>
		>多选&nbsp;&nbsp;<input type=radio name=mode value=radio 
		<?
		if($mode=='radio')
		{
			echo ' checked';
		}
		?>
		>单选
<tr bgcolor=white>
	<td colspan=2 align=center>
	<input type=hidden name=subject_id value=<?=$subject_id?>>
	<input type=hidden name=item_id value=<?=implode("|", $item_id)?>>
	<input type=submit value=提交修改>&nbsp;&nbsp;<input type=reset value="重置">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="取消修改"></td>
</tr>
</table>
</form>
</body>
</html>