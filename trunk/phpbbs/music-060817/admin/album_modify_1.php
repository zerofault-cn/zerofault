<style>
table
{
	background-color:#000000;
}
tr
{
	background-color:#ffffff;
}
</style>
<?
$phpbbs_root_path="../..";
include_once $phpbbs_root_path.'/include/db_connect.php';
include_once $phpbbs_root_path.'/music/music_functions.php';
$album_id=$_REQUEST['album_id'];
$sql1="select * from album_info where album_id=".$album_id;
$result1=$db->sql_query($sql1);
$singer_id=$db->sql_fetchfield('singer_id',0,$result1);
$album_name=$db->sql_fetchfield('album_name',0,$result1);
$album_pubdate=$db->sql_fetchfield('album_pubdate',0,$result1);
$album_photo=$db->sql_fetchfield('album_photo',0,$result1);
$album_intro=$db->sql_fetchfield('album_intro',0,$result1);
?>
<form name="form1" method="POST" action="album_modify_2.php">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1>
<caption>修改专辑</caption>
<tr>
	<td rowspan=3>
	<?
	if($album_photo!='')
	{
		?>
		<img src="../get_photo.php?photo_type=album&photo_id=<?=$album_id?>"><br>
		<input type=button onclick="window.open('photo_upload_1.php?type=album&value=<?=$album_id?>','','width=500,height=120,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="重新上传">
		<?
	}
	else
	{
		?>
		<input type=button onclick="window.open('photo_upload_1.php?type=album&value=<?=$album_id?>','','width=450,height=120,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="上传照片">
		<?
	}
	?>
	</td>
	<td>歌手</td>
	<td><select name="singer_id">
		<?
		$sql2="select * from singer_info order by singer_name_fc,binary singer_name";
		$result2=$db->sql_query($sql2);
		$i=0;
		while($r2=$db->sql_fetchrow($result2))
		{
			$singer_name_fc[]=$r2['singer_name_fc'];
			if($singer_name_fc[$i]!=$singer_name_fc[$i-1])
			{
				?>
				<option value=""><?=$singer_name_fc[$i]?>-------</option>
				<?
			}
			?>
			<option value="<?echo $tmp_singer_id=$r2['singer_id'];?>"
			<?
			if($singer_id==$tmp_singer_id)
			{
				echo " selected";
			}
			?>
			><?=$r2['singer_name']?></option>
			<?
			$i++;
		}
		?>
		</select></td>
</tr>
<tr>
	<td><span style="color:red">*</span>专辑名:</td>
	<td><input type=text name="album_name" value="<?=$album_name?>"></td>
</tr>
<tr>
	<td>专辑发布日期:</td>
	<td><input type=text name="album_pubdate" size=10 value="<?=$album_pubdate?>"></td>
</tr>
<tr>
	<td colspan=3><textarea name="album_intro" cols="55" rows="15"><?=unformat($album_intro)?></textarea></td>
</tr>
<tr>
	<td colspan=3 align=center><input type=submit value=提交修改>&nbsp;&nbsp;&nbsp;&nbsp;<input type=reset value="重置">&nbsp;&nbsp;&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="取消修改"></td>
</tr>
</table>
<input type="hidden" name="album_id" value="<?=$album_id?>">
</form>