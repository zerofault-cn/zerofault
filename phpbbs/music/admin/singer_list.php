<!-- 所有歌手按类列表 -->
<?
session_start();
$_SESSION['uri']=$_SERVER['REQUEST_URI'];
if(!isset($phpbbs_root_path))
{
	$phpbbs_root_path='../..';
}
include_once $phpbbs_root_path.'/include/db_connect.php';
$list_id=$_REQUEST['list_id'];
$type_label=$_REQUEST['type_label'];
$type_field=$_REQUEST['type_field'];
if($list_id=='' && $type_label=='')
{
	$type_label="0";
}
?>
<link rel="stylesheet" href="../../style.css" type="text/css">
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=1 bgcolor="black">
<tr bgcolor="white">
	<td align="center"
	<?
	if($type_label=="0")
		echo "bgcolor=#b3b7e6";
	?>
	><a href="?type_label=0">按歌手首字母排列</a></td>
	<td align="center"
	<?
	if($type_label=="1")
		echo "bgcolor=#b3b7e6";
	?>
	><a href="?type_label=1&type_field=singer_area_id">按歌手乐队方式排列</a></td>
	<td align="center"
	<?
	if($type_label=="2")
		echo "bgcolor=#b3b7e6";
	?>
	><a href="?type_label=2&type_field=singer_chorus_id">按演唱方式排列</a></td>
</tr>	
<tr bgcolor="white">
	<td colspan=3>
	<table border=0 width="100%" cellspacing=0 cellpadding=0>
	<?
	if($list_id==30)
	{
		$sql1="select singer_id,singer_name,'其他地区' from singer_info where singer_area_id not in(1,2) order by singer_id";
	}
	elseif($list_id!='')
	{
		$sql1="select singer_id,singer_name,concat(singer_type1.type_name,singer_type2.type_name) from singer_info,singer_type as singer_type1,singer_type as singer_type2 where (singer_info.singer_area_id=".substr($list_id,0,1)." and singer_type1.type_id=".substr($list_id,0,1).") and (singer_info.singer_chorus_id=".substr($list_id,1)." and singer_type2.type_id=".substr($list_id,1).") order by singer_info.singer_id";
	}
	elseif($type_label==0)
	{
		$sql1="select singer_id,singer_name,singer_name_fc as type_name from singer_info order by singer_name_fc";
	}
	else
	{
		$sql1="select singer_id,singer_name,type_name from singer_info,singer_type where singer_type.type_id=singer_info.".$type_field." and singer_type.type_label='".$type_label."' order by singer_type.type_id,singer_info.singer_id";
	}
	$result1=$db->sql_query($sql1);
	$i=0;
	$col=5;
	static $navi='';
	$type_name_arr[0]="";
	while($r=$db->sql_fetchrow($result1))
	{
		$i++;
		$singer_id=$r[0];
		$singer_name=$r[1];
		$type_name =$r[2];
		$sql2="select * from album_info where singer_id=".$singer_id;
		$album_count=$db->sql_numrows($db->sql_query($sql2));
		$sql3="select * from song_info where singer_id=".$singer_id;
		$song_count=$db->sql_numrows($db->sql_query($sql3));
		$type_name_arr[$i]=$type_name;
		if($type_name_arr[$i]!=$type_name_arr[$i-1])
		{
			$navi.='<td align=center style="BORDER-RIGHT: #a5bede 1px solid;BORDER-TOP: #a5bede 1px solid;BORDER-LEFT: #a5bede 1px solid;BORDER-BOTTOM: #a5bede 1px solid;"><a style="color:red" href="#'.$type_name.'">&nbsp;'.$type_name.'&nbsp;</a></td>';
			?>
			<tr><td colspan="<?=$col?>" style="color:red"><a name="#<?=$type_name?>"><?=$type_name?></a></td></tr>
			<?
			$j=0;
		}
		if($j%$col==0)
		{
			echo '<tr>';
		}
		?>
		<td valign="top" style="line-height:180%"><a href="singer_info.php?singer_id=<?=$singer_id?>" title="点击查看歌手详细信息"><?=$singer_name?></a>(<span class="blue"><?=$album_count?></span>,<span class="green"><?=$song_count?></span>)</td>
		<?
		if($j%$col==($col-1))
		{
			echo '</tr>';
		}
		$j++;
	}
	?>
	<caption valign="top">
	<table border=0 width="100%" cellspacing=0 cellpadding=0 style="BORDER-RIGHT: #a5bede 1px solid;BORDER-TOP: #a5bede 1px solid;BORDER-LEFT: #a5bede 1px solid;BORDER-BOTTOM: #a5bede 1px solid;">
	<tr>
		<?=$navi?>
	</tr>
	</table>
	</caption>
	</table>
	</td>
</tr>
<caption valign="top">此类中有<span style="color:red"><?=$i?></span>个歌手<span class="small">(括号内分别为歌手的专辑数,歌曲数)</span></caption>
</table>
<center><a href="#top">回到顶部</a></center>