<!-- 歌手信息及歌手歌曲列表 -->
<script language="javascript">
function delrecord(prog_id)
{
	if(confirm("确定要删除该记录吗?"))
	{
		window.location="prog_delete.php?del_flag=record&page_from=music_singer_song&prog_id="+prog_id;
	}
	else
		return;
}
function delfile(prog_id)
{
	if(confirm("确定要删除该文件吗？")&&confirm("删除将无法恢复哦！真的确认？"))
	{
		window.location="prog_delete.php?del_flag=file&page_from=music_singer_song&prog_id="+prog_id;
	}
	else
		return;
}
function delsinger(singer_id)
{
	if(songcount>0)
	{
		alert("该歌手还有"+songcount+"首歌曲,不能删除该歌手");
		return;
	}
	else
	{
		if(confirm("确定要删除该歌手吗?"))
		{
			window.location="music_delete_singer.php?singer_id="+singer_id;
		}
		else
			return;
	}
}
</script>
<?
function unformat($text)
{
	$text=str_replace('&nbsp;',' ',$text);
	$text=str_replace('<br />',"",$text);
	$text=str_replace('<br>',"",$text);
	return $text;
}
include_once "../include/mysql_connect.php";
include_once "../include/getplaypath.php";
if(!isset($singer_id)&&isset($cookie_singer_id)&&$cookie_singer_id!='')
{
	$singer_id=$cookie_singer_id;
}
setcookie("cookie_singer_id",$singer_id);
$sql1="select count(*) from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and publisher =".$singer_id;
$result1=mysql_query($sql1);
$singer_song_count=mysql_result($result1,0,0);
$sql2="select singer_name,photo,introduce from singer_info where singer_id='".$singer_id."'";
$result2=mysql_query($sql2);
$singer_name=mysql_result($result2,0,0);
$photo		=mysql_result($result2,0,1);
$introduce	=mysql_result($result2,0,2);

?>
<table width="100%" border=0 cellspacing=0 cellpadding=0 bgcolor=black>
<caption>歌手信息</caption>
<tr bgcolor=white>
	<td valign=top align=center width=120>
		<img src="music_singer_photo.php?singer_id=<?=$singer_id?>"><br>
		<?=$singer_name?><br>
		<?
		$sql3="select type_name from singer_type,singer_info where type_label=1 and singer_info.singer_id='".$singer_id."' and singer_info.type_area_id=type_id";
		echo "分类一:".mysql_result(mysql_query($sql3),0,0);
		$sql4="select type_name from singer_type,singer_info where type_label=2 and singer_info.singer_id='".$singer_id."' and singer_info.type_chorus_id=type_id";
		echo "<br>分类二:".mysql_result(mysql_query($sql4),0,0);
		$sql5="select type_name from singer_type,singer_info where type_label=5 and singer_info.singer_id='".$singer_id."' and singer_info.type_other_id=type_id";
		echo "<br>分类三:".mysql_result(mysql_query($sql5),0,0);
		?><br>
		<input type=button onclick="window.open('music_modify_singer_1.php?singer_id=<?=$singer_id?>','','width=450,height=470,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="修改">
		<input type=button onclick='delsinger(<?=$singer_id?>)' value="删除">
		</td>
	<td align=right>
	<textarea rows=15 cols=60 readonly><?=unformat($introduce)?></textarea><br>
	<input type=button onclick="javascript:window.location='?content=mp3_list&singer_id=<?=$singer_id?>';" value="转到歌手MP3列表页面"></td>
</tr>
</table>

<table width="100%" border=0 cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor=white>
	<td>序号</td>
	<td>名称</td>
	<td>格式</td>
	<td>录入时间</td>
	<td align=center>文件</td>
	<td align=center>有效否</td>
	<td align=center>操作</td>
</tr>
<?
$sql6="select prog_id,prog_name,prog_path,prog_indate,del_flag from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and publisher =".$singer_id." order by prog_name,prog_id desc,prog_path";
$result6=mysql_query($sql6);
$i=0;
while($r=mysql_fetch_array($result6))
{
	$i++;
	$prog_id	=$r[0];
	$prog_name	=$r[1];
	if(strlen($prog_name)>10)
		$tmp_prog_name=substr($prog_name,0,10)."...";
	else
		$tmp_prog_name=$prog_name;
	$prog_path	=$r[2];
	$play_path=getPlayPath($prog_path);
	$prog_indate=$r[3];
	$del_flag	=$r[4];
	if($bgcolor!='#d0d0d0')
	{
		$bgcolor='#d0d0d0';
	}
	else
	{
		$bgcolor='#f0f0f0';
	}
	?>
	<tr bgcolor=<?=$bgcolor?>>
	<td><?=$i?></td>
	<td class=narrow><a href="<?=$play_path?>" title="<?=$prog_name?>"><?=$tmp_prog_name?></td>
	<td><a href="#<?=$prog_id?>" title="<?=$prog_path?>"><?=substr(strrchr($prog_path,"."),1)?></a></td>
	<td><?=$prog_indate?></td>
	<td align=center>
	<?
	$prog_locate=getLocate($prog_path);
	if($prog_locate=='local')
	{
		$f_unknown=0;
		$f_exist=file_exists("/dpfs/".getRealPath($prog_path));
		if($f_exist)
		{
			?>
			<a style='color:blue' href='#<?=$prog_id?>' title='文件路径:/dpfs/<?=getRealPath($prog_path)?>'>有</a>
			<?
		}
		else
		{
			?>
			<a style='color:red' href='#<?=$prog_id?>' title='文件路径:/dpfs/<?=getRealPath($prog_path)?>'>无</a>
			<?
		}
	}
	else
	{
		$f_unknown=1;
		?>
		<a style='color:green' href='#<?=$prog_id?>' title="本服务器无法判断文件所在">未知</a>
		<?
	}
	?>
	</td>
	<td align=center>
	<?
	if($del_flag==1)
	{
		?>
		<span style=color:blue>有效</span>
		<?
	}
	else
	{
		?>
		<span style=color:red>无效</span>
		<?
	}
	?>
	</td>
	<td align=center><input type=button onclick="window.open('music_modify_prog_1.php?prog_id=<?=$prog_id?>','','width=450,height=600,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="修改"><input type=button onclick='delrecord(<?=$prog_id?>)'
		<?
		if($f_exist||$f_unknown)
			echo " disabled";
		?>
		value="删除记录"><input type=button onclick='delfile(<?=$prog_id?>)'
		<?
		if(!$f_exist||$f_unknown)
			echo " disabled";
		?>
		value="删除文件"></td>
</tr>
<?
}
?>
<caption>歌手所有歌曲<span class=small>(共<?=$i?>首)</span></caption>
</table>
<center><a href="#top">回到顶部</a></center>
<script>
var songcount=<?=$i?>;
</script>