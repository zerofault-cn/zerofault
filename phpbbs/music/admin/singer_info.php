<!-- ������Ϣ�����ָ����б� -->
<link rel="stylesheet" href="../../style.css" type="text/css">
<script language="javascript">
function delalbum(singer_id,album_id)
{
	if(confirm("ȷ��Ҫɾ����ר����?"))
	{
		if(confirm("��ר�������и������ᱻɾ��!\r\n�㡰ȷ������ɾ�����㡰ȡ������תΪ������"))
		{
			window.location="album_delete.php?singer_id="+singer_id+"&flag=delall&album_id="+album_id;
		}
		else
		{
			window.location="album_delete.php?singer_id="+singer_id+"&flag=delalbum&album_id="+album_id;
		}
	}
	else
		return;
}
function delsong(singer_id,song_id)
{
	if(confirm("ȷ��Ҫɾ���ø�����"))
	{
		window.location="song_delete.php?singer_id="+singer_id+"&song_id="+song_id;
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

$phpbbs_root_path="../..";
include_once $phpbbs_root_path.'/include/db_connect.php';
include_once $phpbbs_root_path.'/music/music_class.php';
$music=new Music();
$singer_id=$_REQUEST['singer_id'];
$sql1="select * from singer_info where singer_id=".$singer_id;
$result1=$db->sql_query($sql1);
$singer_name=$db->sql_fetchfield('singer_name',0,$result1);
$singer_intro=$db->sql_fetchfield('singer_intro',0,$result1);
$singer_area_id=$db->sql_fetchfield('singer_area_id',0,$result1);
$singer_chorus_id=$db->sql_fetchfield('singer_chorus_id',0,$result1);

$sql2="select * from singer_type where type_id=".$singer_area_id." and type_label=1";
$singer_area=$db->sql_fetchfield('type_name',0,$db->sql_query($sql2));
$sql3="select * from singer_type where type_id=".$singer_chorus_id." and type_label=2";
$singer_chorus=$db->sql_fetchfield('type_name',0,$db->sql_query($sql3));

$sql4="select * from album_info where singer_id=".$singer_id;
$result4=$db->sql_query($sql4);
$i=0;
while($r4=$db->sql_fetchrow($result4))
{
	$album_info[$i][0]=$r4['album_id'];
	$album_info[$i][1]=$r4['album_name'];
	$album_info[$i][2]=$r4['album_pubdate'];
	$album_info[$i][3]=$r4['album_intro'];
	$album_info[$i][4]=$r4['album_count'];
	$sql5="select * from song_info where album_id=".$album_info[$i][0];
	$result5=$db->sql_query($sql5);
	$j=0;
	while($r5=$db->sql_fetchrow($result5))
	{
		$album_info[$i][5][$j][0]=$r5['song_id'];
		$album_info[$i][5][$j][1]=$r5['song_name'];
		$album_info[$i][5][$j][2]=$r5['song_count'];
		$j++;
	}
	$i++;
}
$sql6="select * from song_info where singer_id=".$singer_id." and album_id=0";
$result6=$db->sql_query($sql6);
$j=0;
while($r6=$db->sql_fetchrow($result6))
{
	$album_info[$i][0]='';
	$album_info[$i][1]='����';
	$album_info[$i][2]='';
	$album_info[$i][3]='';
	$album_info[$i][4]='';
	$album_info[$i][5][$j][0]=$r6['song_id'];
	$album_info[$i][5][$j][1]=$r6['song_name'];
	$album_info[$i][5][$j][2]=$r6['song_count'];
	$j++;
}

?>
<table width="80%" border=0 cellspacing=0 cellpadding=0 bgcolor=black>
<caption>������Ϣ</caption>
<tr bgcolor=white>
	<td valign=top align=center width=120>
		<img src="../get_photo.php?photo_type=singer&photo_id=<?=$singer_id?>"><br>
		<?=$singer_name?><br>
		<?=$singer_area?>
		<?=$singer_chorus?><br>
		<input type=button onclick="window.open('singer_modify_1.php?singer_id=<?=$singer_id?>','','width=450,height=470,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="�޸�">
		<input type=button onclick='delsinger(<?=$singer_id?>)' value="ɾ��">
		</td>
	<td align=right>
	<textarea rows=15 cols=60 readonly><?=$music->unformat($singer_intro)?></textarea><br>
	</td>
</tr>
</table>

<table width="80%" border=0 cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor="#ed6f31">
	<td>ר�����</td>
	<td>��Ŀ���</td>
	<td>ר��</td>
	<td>��Ŀ</td>
	<td>��������</td>
	<td>���</td>
	<td>����</td>
</tr>
<?
for($i=0;$i<sizeof($album_info);$i++)
{
	?>
<tr bgcolor="white">
	<td><?=($i+1)?></td>
	<td></td>
	<td><a href="#album_id=<?=$album_info[$i][0]?>"><?=$album_info[$i][1]?></a></td>
	<td></td>
	<td><?=$album_info[$i][2]?></td>
	<td><?=$album_info[$i][4]?></td>
	<td><input type=button onclick="window.open('album_modify_1.php?album_id=<?=$album_info[$i][0]?>','','width=450,height=490,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="�޸�"> <input type="button" onclick="delalbum(<?=$singer_id?>,<?=$album_info[$i][0]?>)" value="ɾ��" <?if($album_info[$i][0]=='')echo ' disabled'?>> <input type="button" onclick="javascript:location='song_add_1.php?singer_id=<?=$singer_id?>&album_id=<?=$album_info[$i][0]?>'" value="��Ӹ���"></td>
</tr>
	<?
	for($j=0;$j<sizeof($album_info[$i][5]);$j++)
	{
		?>
<tr bgcolor="white">
	<td></td>
	<td><?=($j+1)?></td>
	<td></td>
	<td><a href="#song_id=<?=$album_info[$i][5][$j][0]?>"><?=$album_info[$i][5][$j][1]?></a></td>
	<td></td>
	<td><?=$album_info[$i][5][$j][2]?></td>
	<td><input type=button onclick="window.open('song_modify_1.php?song_id=<?=$album_info[$i][5][$j][0]?>','','width=480,height=280,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value= "�޸�" > <input type="button" onclick="delsong(<?=$singer_id?>,<?=$album_info[$i][5][$j][0]?>)" value="ɾ��"></td>
</tr>
		<?
	}
}
?>
<tr bgcolor="white">
	<td colspan=7 align=right>&nbsp;&nbsp;<input type="button" onclick="javascript:location='album_add_1.php?singer_id=<?=$singer_id?>'" value="���ר��"></td>
</tr>
</table>
<br>
<table width="80%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor="white">
	<td align=right><input type="button" onclick="javascript:location='song_add_1.php?singer_id=<?=$singer_id?>&album_id='" value="��ӵ���"></td>
</tr>
</table>
<br>
<table width="80%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor="white">
	<td align=right><a href="singer_list.php">���ظ����б�</a></td>
</tr>
</table>
<script>
var songcount=<?=$i?>;
</script>