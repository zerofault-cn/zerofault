<!-- 修改歌手信息-1 -->
<html>
<head>
<title>修改歌手信息-1</title>
<META http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" href="../style.css" type="text/css">
</head>

<body>
<?
$phpbbs_root_path="../..";
include_once $phpbbs_root_path.'/include/db_connect.php';
include_once $phpbbs_root_path.'/music/music_functions.php';
$singer_id=$_REQUEST['singer_id'];
$sql1="select * from singer_info where singer_id=".$singer_id;
$result1=$db->sql_query($sql1);
$singer_name	=$db->sql_fetchfield('singer_name',0,$result1);
$singer_name_fc	=$db->sql_fetchfield('singer_name_fc',0,$result1);
$singer_photo	=$db->sql_fetchfield('singer_photo',0,$result1);
$singer_area_id	=$db->sql_fetchfield('singer_area_id',0,$result1);
$singer_chorus_id=$db->sql_fetchfield('singer_chorus_id',0,$result1);
$singer_intro	=$db->sql_fetchfield('singer_intro',0,$result1);

?>
<form name=form1 method=POST action="singer_modify_2.php">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=2 bgcolor=black>
<caption>修改歌手资料</caption>
<tr bgcolor=white>
	<td align=right>歌手名:</td>
	<td><input type=text name="singer_name" value="<?=$singer_name?>"></td>
	<td rowspan=4>
	<?
	if($singer_photo!='')
	{
		?>
		<img src="../get_photo.php?photo_type=singer&photo_id=<?=$singer_id?>"><br>
		<input type=button onclick="window.open('photo_upload_1.php?type=singer&value=<?=$singer_id?>','','width=470,height=120,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="重新上传">
		<?
	}
	else
	{
		?>
		<input type=button onclick="window.open('photo_upload_1.php?type=singer&value=<?=$singer_id?>','','width=470,height=120,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="上传照片">
		<?
	}
	?></td>
</tr>
<tr bgcolor=white>
	<td align=right>姓名首字母:</td>
	<td><input type=text name="singer_name_fc" value="<?=$singer_name_fc?>"></td>
</tr>
<tr bgcolor=white>
	<td align=right>地区:</td>
	<td><select name="singer_area_id">
		<?
		$sql2="select type_id,type_name from singer_type where type_label=1 order by type_id";
		$result2=$db->sql_query($sql2);
		while($r2=$db->sql_fetchrow($result2))
		{
			?>
			<option value="<?echo $area_id=$r2[0];?>"
			<?
			if($singer_area_id==$area_id)
				echo " selected";
			?>
			><?=$r2[1]?></option>
			<?
		}
		?>
		</select></td>
</tr>
<tr bgcolor=white>
	<td align=right>演唱方式:</td>
	<td><select name="singer_chorus_id">
		<?
		$sql3="select type_id,type_name from singer_type where type_label=2 order by type_id";
		$result3=$db->sql_query($sql3);
		while($r3=$db->sql_fetchrow($result3))
		{
			?>
			<option value="<?echo $chorus_id=$r3[0];?>"
			<?
			if($singer_chorus_id==$chorus_id)
				echo " selected";
			?>
			><?=$r3[1]?></option>
			<?
		}
		?></select></td>
</tr>
<tr bgcolor=white>
	<td align=right>歌手简介:</td>
	<td colspan=2><textarea name="singer_intro" cols=45 rows=12><?=unformat($singer_intro)?></textarea></td>
</tr>
<tr bgcolor=white>
	<td colspan=3 align=center><input type=submit value=提交修改>&nbsp;&nbsp;<input type=reset value="重置">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="取消修改"></td>
</tr>
</table>
<input type=hidden name="singer_id" value="<?=$singer_id?>">
</form>
</body>
</html>
