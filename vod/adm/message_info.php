<?php
include_once "../include/mysql_connect.php";
$sql1="select * from admin_message where id=".$id;
$result1=mysql_query($sql1);
$r=mysql_fetch_array($result1);
$user=$r["user"];
$title=$r["title"];
$time=$r["time"];
$info=$r["info"];
$ip=$r["ip"];
$sql2="select * from admin_message where pid=".$id;
$result2=mysql_query($sql2);
?>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<caption class=big14>察看留言</caption>
<tr bgcolor=white>
	<td><span style="color:#3399cc"><?=$user?></span>从<span style="color:#003399"><?=$ip?>上于<?=$time?>留言:</td>
</tr>
<tr bgcolor=white>
	<td><?=$title?><br>------------------------<br><?=$info?></td>
</tr>
</table>
<?
while($r=mysql_fetch_array($result2))
{
	?>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<tr bgcolor=white>
	<td><span style="color:#3399cc"><?=$r["user"]?></span>从<span style="color:#003399"><?=$r["ip"]?>上于<?=$r["time"]?>回复:</td>
</tr>
<tr bgcolor=white>
	<td><?=$r["info"]?></td>
</tr>
</table>
	<?
}
?>
<form method=post action="message_insert_2.php">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor=black>
<tr bgcolor=white>
	<td width="20%" align=right><span class=red>*</span>回复者:</td>
	<td width="80%"><input type=text name=user size=20></td></tr>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>回复内容:</td>
	<td><textarea name=info rows=6 cols=50></textarea></td>
</tr>
<tr bgcolor=white>
	<td align=center colspan=2><input type=hidden name=pid value='<?=$id?>'><input type=hidden name=title value='<?=$title?>'><input type="submit" value="回复">&nbsp;&nbsp;&nbsp;&nbsp;
	<INPUT TYPE="reset" value="重写">&nbsp;&nbsp;&nbsp;&nbsp;<input type=button value="返回" onclick="javascript:window.location='index.php?content=message_index'"></td>
</tr>
</table>
</form>
