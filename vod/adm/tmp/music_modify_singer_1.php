<!-- 修改歌手信息-1 -->
<html>
<head>
<title>修改歌手信息-1</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
<?
function unformat($text)
{
	$text=str_replace('&nbsp;',' ',$text);
	$text=str_replace('<br />',"",$text);
	$text=str_replace('<br>',"",$text);
	return $text;
}
include_once "../include/mysql_connect.php";
$sql1="select * from singer_info where singer_id='".$singer_id."'";
$result1=mysql_query($sql1);
$singer_name	=mysql_result($result1,0,"singer_name");
$singer_name_fc	=mysql_result($result1,0,"singer_name_fc");
$photo			=mysql_result($result1,0,"photo");
$type_area_id	=mysql_result($result1,0,"type_area_id");
$type_chorus_id	=mysql_result($result1,0,"type_chorus_id");
$type_other_id	=mysql_result($result1,0,"type_other_id");
$introduce		=mysql_result($result1,0,"introduce");

?>
<form name=modify method=POST action="music_modify_singer_2.php">
<table width="100%" border=0 cellspacing=1 cellpadding=2 bgcolor=black>
<caption>修改歌手资料</caption>
<tr bgcolor=white>
	<td align=right>歌手名:</td>
	<td><input type=text name=singer_name value="<?=$singer_name?>"></td>
	<td rowspan=5>
	<?
	if($photo!='')
	{
		?>
		<img src="music_singer_photo.php?singer_id=<?=$singer_id?>"><br>
		<input type=button onclick="window.open('pic_upload_1.php?pic_type=photo&id=<?=$singer_id?>&name=<?=$singer_name?>','','width=450,height=120,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="重新上传">
		<?
	}
	else
	{
		?>
		<input type=button onclick="window.open('pic_upload_1.php?pic_type=photo&id=<?=$singer_id?>&name=<?=$singer_name?>','','width=450,height=120,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="上传照片">
		<?
	}
	?></td>
</tr>
<tr bgcolor=white>
	<td align=right>名称首字母:</td>
	<td><input type=text name=singer_name_fc value="<?=$singer_name_fc?>"></td>
</tr>
<tr bgcolor=white>
	<td align=right>地区及组合:</td>
	<td><select name=type_area_id>
		<?
		$sql2="select type_id,type_name from singer_type where type_label=1 order by type_id";
		$result2=mysql_query($sql2);
		while($r=mysql_fetch_array($result2))
		{
			?>
			<option value="<?echo $type_id=$r[0];?>"
			<?
			if($type_area_id==$type_id)
				echo " selected";
			?>
			><?=$r[1]?></option>
			<?
		}
		?>
		</select></td>
</tr>
<tr bgcolor=white>
	<td align=right>演唱方式:</td>
	<td><select name=type_chorus_id>
		<?
		$sql2="select type_id,type_name from singer_type where type_label=2 order by type_id";
		$result2=mysql_query($sql2);
		while($r=mysql_fetch_array($result2))
		{
			?>
			<option value="<?echo $type_id=$r[0];?>"
			<?
			if($type_chorus_id==$type_id)
				echo " selected";
			?>
			><?=$r[1]?></option>
			<?
		}
		?></select></td>
</tr>
<tr bgcolor=white>
	<td align=right>其他方式:</td>
	<td><select name=type_other_id>
		<?
		$sql2="select type_id,type_name from singer_type where type_label=5 order by type_id";
		$result2=mysql_query($sql2);
		while($r=mysql_fetch_array($result2))
		{
			?>
			<option value="<?echo $type_id=$r[0];?>"
			<?
			if($type_other_id==$type_id)
				echo " selected";
			?>
			><?=$r[1]?></option>
			<?
		}
		?>
		</select></td>
</tr>

<tr bgcolor=white>
	<td align=right>歌手简介:</td>
	<td colspan=2><textarea name=introduce cols=45 rows=12><?=unformat($introduce)?></textarea></td>
</tr>
<tr bgcolor=white>
	<td colspan=3 align=center><input type=submit value=提交修改>&nbsp;&nbsp;<input type=reset value="重置">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="取消修改"></td>
</tr>
</table>
<input type=hidden name=singer_id value="<?=$singer_id?>">
</form>
</body>
</html>
