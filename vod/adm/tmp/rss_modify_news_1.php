<?
function unformat($text)
{
	$text=str_replace('&nbsp;',' ',$text);
	$text=str_replace('<br />',"",$text);
	$text=str_replace('<br>',"",$text);
	return $text;
}
include_once "../include/mysql_connect.php";
$sql1="select * from rss_news where id=".$id;
$result1=mysql_query($sql1);
$channel=mysql_result($result1,0,1);
$title=mysql_result($result1,0,2);
$author=mysql_result($result1,0,3);
$info=mysql_result($result1,0,4);
?>
<html>
<head>
<title>修改电影节目</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<form method=post action="rss_modify_news_2.php" name="modify">
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>修改"RSS新闻"标题和内容以及分类</caption>
<tr bgcolor=white>
	<td align=right>修改分类</td>
	<td><select name=channel>
		<?
		$sql2="select id,channel_name from rss_channel where del_flag=1 order by id";
		$result2=mysql_query($sql2);
		while($r=mysql_fetch_array($result2))
		{
			?>
			<option value="<?echo $tmp_id=$r[0];?>" 
			<?
			if($channel==$tmp_id)
				echo " selected";
			?>
			><?=$r[1]?></option>
			<?
		}
		?>
		</select>
		</td>
</tr>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>新闻标题:</td>
	<td align=left><INPUT TYPE="text" NAME="title" size=30 value='<?=$title?>'></td>
</tr>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>来源(作者):</td>
	<td align=left><INPUT TYPE="text" NAME="author" size=20 value='<?=$author?>'></td>
</tr>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>内容:</td>
	<td><textarea name=info rows=8 cols=40><?=unformat($info)?></textarea></td>
</tr>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=hidden name=id value='<?=$id?>'><input type=hidden name=select_flag><input type="submit" value="提交修改">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="reset" value="&nbsp;重填&nbsp;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="取消修改"></td>
</tr>
</table>
</form>
</body>
</html>