<!-- ������Ϣ�����ָ����б� -->
<script language="javascript">
function delrecord(prog_id)
{
	if(confirm("ȷ��Ҫɾ���ü�¼��?"))
	{
		window.location="prog_delete.php?del_flag=record&page_from=music_singer_song&prog_id="+prog_id;
	}
	else
		return;
}
function delfile(prog_id)
{
	if(confirm("ȷ��Ҫɾ�����ļ���")&&confirm("ɾ�����޷��ָ�Ŷ�����ȷ�ϣ�"))
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
		alert("�ø��ֻ���"+songcount+"�׸���,����ɾ���ø���");
		return;
	}
	else
	{
		if(confirm("ȷ��Ҫɾ���ø�����?"))
		{
			window.location="singer_delete.php?singer_id="+singer_id;
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
$phpbbs_root_path="../..";
include_once $phpbbs_root_path.'/include/db_connect.php';
$singer_id=$_REQUEST['singer_id'];
$sql1="select * from singer_info where singer_id=".$singer_id;
$result1=$db->sql_query($sql1);
$singer_name=$db->sql_fetchfield('singer_name',0,$result1);
$singer_photo=$db->sql_fetchfield('singer_photo',0,$result1);
$singer_intro=$db->sql_fetchfield('singer_intro',0,$result1);
$singer_area_id=$db->sql_fetchfield('singer_area_id',0,$result1);
$singer_chorus_id=$db->sql_fetchfield('singer_chorus_id',0,$result1);

$sql2="select * from singer_type where type_id=".$singer_area_id." and type_label=1";
$singer_area=$db->sql_fetchfield('type_name',0,$db->sql_query($sql2));
$sql3="select * from singer_type where type_id=".$singer_chorus_id." and type_label=2";
$singer_chorus=$db->sql_fetchfield('type_name',0,$db->sql_query($sql3));

$sql4="select * from album_info where album_name!='' and singer_id=".$singer_id;
$result4=$db->sql_query($sql4);
$i=0;
while($r=$db->sql_fetchrow($result4))
{
	$album_info[$i][0]=$r['album_id'];
	$album_info[$i][1]=$r['album_name'];
	$album_info[$i][2]=$r['album_pubdate'];
	$album_info[$i][3]=$r['album_intro'];
	$album_info[$i][4]=$r['album_count'];
	$i++;
}
$sql5="select * from album_info,song_info where album_info.singer_id=".$singer_id." and album_info.album_name='' and song_info.album_id=album_info.album_id";
$result5=$db->sql_query($sql5);
$j=0;
while($r=$db->sql_fetchrow($result5))
{
	$single_info[$j][0]=$r['song_id'];
	$single_info[$j][1]=$r['song_name'];
	$single_info[$j][2]=$r['song_count'];
	$j++;
}
?>
<table width="80%" border=0 rules=rows cellspacing=0 cellpadding=0 bgcolor=black>
<caption>������Ϣ</caption>
<tr bgcolor=white>
	<td valign=top align=center width=120>
		<img src="singer_photo.php?singer_id=<?=$singer_id?>"><br>
		<?=$singer_name?><br>
		<?=$singer_area?>
		<?=$singer_chorus?><br>
		<input type=button onclick="window.open('music_modify_singer_1.php?singer_id=<?=$singer_id?>','','width=450,height=470,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="�޸�">
		<input type=button onclick='delsinger(<?=$singer_id?>)' value="ɾ��">
		</td>
	<td align=right>
	<textarea rows=15 cols=60 readonly><?=unformat($singer_intro)?></textarea><br>
	</td>
</tr>
</table>

<table width="80%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor="white">
	<td>���</td>
	<td>ר��</td>
	<td>��������</td>
	<td>���</td>
</tr>
<?
for($i=0;$i<sizeof($album_info);$i++)
{
	?>
<tr bgcolor="white">
	<td><?=($i+1)?></td>
	<td><?=$album_info[$i][1]?></td>
	<td><?=$album_info[$i][2]?></td>
	<td><?=$album_info[$i][4]?></td>
</tr>
	<?
}
?>
<tr bgcolor="white">
	<td colspan=4 align=right><a href="album_add_1.php?singer_id=<?=$singer_id?>">���ר��</a></td>
</tr>
</table>
<?
if(sizeof($single_info)>0)
{
	?>
<br>
<br>
<table width="80%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor="white">
	<td>���</td>
	<td>����</td>
	<td>���</td>
	<td>����</td>
	<td>�㲥</td>
	<td>���</td>
</tr>
<?
	for($j=0;$j<sizeof($single_info);$j++)
	{
		?>
<tr bgcolor="white">
	<td><?=($j+1)?></td>
	<td><?=$single_info[$j][1]?></td>
	<td>lrc</td>
	<td>play</td>
	<td>queue</td>
	<td><?=$single_info[$j][2]?></td>
</tr>
		<?
	}
	?>
</table>
	<?
}
?>
<br>
<table width="80%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor="white">
	<td align=right><a href="song_add_1.php?singer_id=<?=$singer_id?>&album_id=<?=$album_id?>">��ӵ���</a></td>
</tr>
</table>
<script>
var songcount=<?=$i?>;
</script>