<table border=0 cellpadding=0 cellspacing=0 width=100%>
<caption>修改在线帮助内容</caption>
<tr>
<td align=center>
<?
function unformat($text)
{
	$text=str_replace('&nbsp;',' ',$text);
	$text=str_replace('<br />',"",$text);
	$text=str_replace('<br>',"",$text);
	return $text;
}
include_once "../include/mysql_connect.php";
$sql1="select * from help";
$result1=mysql_query($sql1);
while($r=mysql_fetch_array($result1))
{
	$id=$r["id"];
	$type1=$r["type1"];
	$type2=$r["type2"];
	$info=$r["info"];
	?>
	<table width="460" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
	<form method=post action="help_update_2.php">
	<tr bgcolor=white>
		<td align=right>对象:</td>
		<td><input type=hidden name=type1 value=<?=$type1?>><?=$type1?></td>
		<td align=right>主题:</td>
		<td><input type=hidden name=type2 value=<?=$type2?>><?=$type2?></td>
	</tr>
	<tr bgcolor=white>
		<td align=right>内容:</td>
		<td colspan=3><textarea name=info rows=10 cols=50><?=unformat($info)?></textarea></td>
	</tr>
	<tr bgcolor=white>
		<td align=center colspan=4>
		<input type="submit" value="提交">&nbsp;&nbsp;&nbsp;&nbsp;
		<INPUT TYPE="reset" value="重写">&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
	</form>
	</table>
	<br>
	<?
}
?>
</td>
</tr>
</table>
