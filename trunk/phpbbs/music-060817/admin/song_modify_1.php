<!-- 修改mp3记录-1 -->
<html>
<head>
<title>修改MP3</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="../style.css" type="text/css">
</head>
<body>
<?
function unformat($text)
{
	$text=str_replace('&amp;','&',$text);
	$text=str_replace('&quot;','"',$text);
	$text=str_replace('&#039;','\'',$text);
	$text=str_replace('&lt;','<',$text);
	$text=str_replace('&gt;','>',$text);
	$text=str_replace('&nbsp;',' ',$text);
	$text=str_replace('<br />','',$text);
	$text=str_replace('<br>','',$text);
	return $text;
}
$phpbbs_root_path="../..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$song_id	=$_REQUEST['song_id'];
$sql1		="select * from song_info where song_id=".$song_id;
$result1	=$db->sql_query($sql1);
$singer_id	=$db->sql_fetchfield('singer_id',0,$result1);
$album_id	=$db->sql_fetchfield('album_id',0,$result1);
$song_name	=$db->sql_fetchfield('song_name',0,$result1);
$song_path	=$db->sql_fetchfield('song_path',0,$result1);
$song_lyric	=$db->sql_fetchfield('song_lyric',0,$result1);
$song_addtime=$db->sql_fetchfield('song_addtime',0,$result1);
?>
<form action="song_modify_2.php" method=post name="form1">
<table width="100%" border=0 cellspacing=1 cellpadding=0 bgcolor=black align=center>
<caption>修改mp3资料</caption>
<tr bgcolor=white>
	<td width="25%" bgcolor=#d0d0d0 align=right>歌曲ID</td>
	<td><input type=text name="song_id" value="<?=$song_id?>" readonly></td>
</tr>
<tr bgcolor=white>
	<td align=right bgcolor=#d0d0d0>歌手名称</td>
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
<tr bgcolor=white>
	<td bgcolor=#d0d0d0 align=right>专辑名称</td>
	<td><select name="album_id">
		<option value=0>单曲</option>
		<?
		$sql3="select * from album_info where singer_id=".$singer_id;
		$result3=$db->sql_query($sql3);
		$i=0;
		while($r3=$db->sql_fetchrow($result3))
		{
			?>
			<option value="<?echo $tmp_album_id=$r3['album_id'];?>"
			<?
			if($album_id==$tmp_album_id)
			{
				echo " selected";
			}
			?>
			><?=$r3['album_name']?></option>
			<?
			$i++;
		}
		?>
		</select></td>
</tr>
<tr bgcolor=white>
	<td bgcolor=#d0d0d0 align=right>歌曲名称</td>
	<td><input type=text name="song_name" value="<?=$song_name?>"></td>
</tr>
<tr bgcolor=white>
	<td bgcolor=#d0d0d0 align=right>MP3相对路径</td>
	<td><input type=text size=50 name="song_path" value="<?=$song_path?>"></td>
</tr>
<tr bgcolor=white>
	<td bgcolor=#d0d0d0 align=right>LRC相对路径</td>
	<td><input type=text size=50 name="song_lyric" value="<?=$song_lyric?>"></td>
</tr>
<tr bgcolor=white>
	<td bgcolor=#d0d0d0 align=right>文件大小</td>
	<td><?
	if(file_exists('f:/'.$song_path))
	{
		echo printf("%.3f",filesize('f:/'.$song_path)/(1024*1024)). 'MB';
	}
	else
	{
		echo '<span style="color:red">文件不存在!</span>';
	}
	?></td>
</tr>
<tr bgcolor=white>
	<td bgcolor=#d0d0d0 align=right>添加时间</td>
	<td><?=$song_addtime?></td>
</tr>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value=提交修改>&nbsp;&nbsp;&nbsp;&nbsp;<input type=reset value="重置">&nbsp;&nbsp;&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="取消修改"></td>
</tr>
</table>
</form>
</body>
</html>