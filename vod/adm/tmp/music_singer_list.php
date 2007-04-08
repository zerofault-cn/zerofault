<!-- 所有歌手按类列表 -->
<?
//include_once "update_singer_mp3_count.php";
if((!isset($type_label)||$type_label=="")&&(!isset($type_field)||$type_field==""))
{
	$type_label="0";
	$type_field="type_area_id";
}
?>
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<tr bgcolor=white>
	<td width="25%" align=center
	<?
	if($type_label=="0")
		echo "bgcolor=#b3b7e6";
	?>
	><a href="?content=music_singer_list&type_label=0">按歌手首字母排列</a></td>
	<td width="25%" align=center
	<?
	if($type_label=="1")
		echo "bgcolor=#b3b7e6";
	?>
	><a href="?content=music_singer_list&type_label=1&type_field=type_area_id">按歌手乐队方式排列</a></td>
	<td width="25%" align=center
	<?
	if($type_label=="2")
		echo "bgcolor=#b3b7e6";
	?>
	><a href="?content=music_singer_list&type_label=2&type_field=type_chorus_id">按演唱方式排列</a></td>
	<td width="25%" align=center
	<?
	if($type_label=="5")
		echo "bgcolor=#b3b7e6";
	?>
	><a href="?content=music_singer_list&type_label=5&type_field=type_other_id">其他类别</a></td>
</tr>	
<tr bgcolor=white>
	<td colspan=4>
	<table border=0 width="100%" cellspacing=0 cellpadding=0>
	<?
	include_once "../include/mysql_connect.php";
	if($type_label==0)
	{
		$sql1="select singer_id,singer_name,singer_name_fc as type_name,mp3_count,mtv_count from singer_info order by singer_name_fc";
	}
	else
	{
		$sql1="select singer_id,singer_name,type_name,mp3_count,mtv_count from singer_info,singer_type where singer_type.type_id=".$type_field." and singer_type.type_label='".$type_label."' order by singer_type.type_id,singer_info.singer_id";
	}
	$result1=mysql_query($sql1);
	$i=0;
	$col=8;
	static $navi='';
	$type_name_arr[0]="";
	while($r=mysql_fetch_array($result1))
	{
		$i++;
		$singer_id=$r[0];
		$singer_name=$r[1];
		$type_name =$r[2];
		$mp3_count=$r[3];
		$mtv_count=$r[4];
		$type_name_arr[$i]=$type_name;
		if($type_name_arr[$i]!=$type_name_arr[$i-1])
		{
			$navi.='<td align=center style="BORDER-RIGHT: #a5bede 1px solid;BORDER-TOP: #a5bede 1px solid;BORDER-LEFT: #a5bede 1px solid;BORDER-BOTTOM: #a5bede 1px solid;"><a style="color:red" href="#'.$type_name.'">'.$type_name.'</a></td>';
			?>
			<tr><td colspan="<?=$col?>" style=color:red><a name="#<?=$type_name?>"><?=$type_name?></a></td></tr>
			<?
			$j=0;
		}
		if($j%$col==0)
		{
			echo '<tr>';
		}
		?>
		<td align=center valign=top><a href="index.php?content=music_singer_song&singer_id=<?=$singer_id?>" title="点击查看歌手详细信息"><?=$singer_name?></a><br>(<span class=smallgreen><?=$mtv_count?></span>,<span class=smallblue><?=$mp3_count?></span>)</td>
		<?
		if($j%$col==($col-1))
		{
			echo '</tr>';
		}
		$j++;
	}
	?>
	<caption valign=top>
	<table border=0 width="100%" cellspacing=0 cellpadding=0 style="BORDER-RIGHT: #a5bede 1px solid;BORDER-TOP: #a5bede 1px solid;BORDER-LEFT: #a5bede 1px solid;BORDER-BOTTOM: #a5bede 1px solid;">
	<tr><?=$navi?></tr></table></caption>
	</table>
	</td>
</tr>
<caption valign=top>已有歌手(<span style="color:red"><?=$i?></span>个)<span class=small>(括号内分别为有效的MTV数,MP3数)</span></caption>
</table>
<center><a href="#top">回到顶部</a></center>