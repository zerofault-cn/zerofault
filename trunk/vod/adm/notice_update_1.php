<?
$notice_file="/jbproject/tomcat/goldsoft/php-vod/notice.txt";
if(file_exists($notice_file)&&$fp=fopen($notice_file,"r"))
{
	$notice=fread($fp,filesize($notice_file));
	fclose($fp);
}
?>
<center>
<form action="notice_update_2.php" method=post>
<table width="60%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption >修改系统通告<br><span class=small style=color:red>下面的内容将直接显示在主菜单左下角系统通告位置</span></caption>
<tr bgcolor=white>
	<td><textarea name=notice cols=50 rows=8><?=$notice?></textarea></td>
</tr>
<tr bgcolor=white>
	<td align=center><input type=submit value="确认修改"></td>
</tr>

</table>
</form>
</center>
