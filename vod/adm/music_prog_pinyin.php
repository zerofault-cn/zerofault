<script language="javascript">
function delrecord(prog_id)
{
	
	if(confirm("ȷ��Ҫɾ���ü�¼��?"))
	{
		window.location="prog_delete.php?del_flag=record&page_from=music_prog&prog_id="+prog_id;
	}
	else
		return;
}
function delfile(prog_id)
{
	
	if(confirm("ȷ��Ҫɾ�����ļ���")&&confirm("ɾ�����޷��ָ�Ŷ�����ȷ�ϣ�"))
	{
		window.location="prog_delete.php?del_flag=file&page_from=music_prog&prog_id="+prog_id;
	}
	else
		return;
}
</script>
<?
include_once "../include/mysql_connect.php";
include_once "../include/getplaypath.php";
if(!isset($offset)||$offset=='')
{
	if(!isset($cookie_music_offset)||$cookie_music_offset=='')
	{
		$offset=0;
	}
	else
	{
		$offset=$cookie_music_offset;
	}
}
setcookie("cookie_music_offset",$offset);
$pageitem=20;//�趨ÿҳ��ʾ����
$flet =substr($pinyin,0,1);
$elet =substr($pinyin,1)."zzzzzzzzzzzzzz";
$sql1="select count(prog_id) from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and prog_acot>='".$flet."' and prog_acot<='".$elet."'";
$sql2="select prog_id,singer_id,singer_name,prog_name,prog_path,prog_indate,del_flag from prog_info,singer_info where prog_name is not null and prog_path is not null and prog_kindsec=1026 and publisher=singer_id and prog_acot>='".$flet."' and prog_acot<='".$elet."' order by prog_acot limit ".$offset.",".$pageitem;
$result1=mysql_query($sql1);
$rowCount=mysql_result($result1,0,0);
$result2=mysql_query($sql2);
?>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor=white>
	<td>���</td>
	<td>����</td>
	<td>����</td>
	<td>��ʽ</td>
	<td>¼��ʱ��</td>
	<td align=center>�ļ�</td>
	<td align=center>��Ч��</td>
	<td align=center>����</td>
</tr>
<?
$i=0;
while($r=mysql_fetch_array($result2))
{
	$i++;
	$prog_id	=$r[0];
	$singer_id	=$r[1];
	$singer_name=$r[2];
	if(strlen($singer_name)>8)
		$tmp_singer_name=substr($singer_name,0,8);
	else
		$tmp_singer_name=$singer_name;
	$prog_name	=$r[3];
	if(strlen($prog_name)>10)
		$tmp_prog_name=substr($prog_name,0,10)."...";
	else
		$tmp_prog_name=$prog_name;
	$prog_path	=$r[4];
	$play_path	=getPlayPath($prog_path);
	$prog_indate=$r[5];
	$del_flag	=$r[6];
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
	<td><a href="index.php?content=music_singer_song&singer_id=<?=$singer_id?>" title="����鿴����<?=$singer_name?>����ϸ��Ϣ"><?=$tmp_singer_name?></a></td>
	<td class=narrow><a href="<?=$play_path?>" title="<?=$prog_name?>"><?=$tmp_prog_name?></td>
	<td><a href="#<?=$prog_id?>" title="<?=$prog_path?>"><?=substr(strrchr($prog_path,"."),1)?></a></td>
	<td><?=$prog_indate?></td>
	<td align=center>
	<?
	$prog_locate=getLocate($prog_path);
	if($prog_locate=='local')
	{
		$f_unknown=0;
		$f_exist=file_exists("/dpfs/".$prog_path);
		if($f_exist)
		{
			?>
			<a style='color:blue' href='#<?=$prog_id?>' title='�ļ�·��:/dpfs/<?=$prog_path?>'>��</a>
			<?
		}
		else
		{
			?>
			<a style='color:red' href='#<?=$prog_id?>' title='�ļ�·��:/dpfs/<?=$prog_path?>'>��</a>
			<?
		}
	}
	else
	{
		$f_unknown=1;
		?>
		<a style='color:green' href='#<?=$prog_id?>' title="���������޷��ж��ļ�����">δ֪</a>
		<?
	}
	?>
	</td>
	<td align=center>
	<?
	if($del_flag==1)
	{
		?>
		<span style=color:blue>��Ч</span>
		<?
	}
	else
	{
		?>
		<span style=color:red>��Ч</span>
		<?
	}
	?>
	</td>
	<td align=center><input type=button onclick="window.open('music_modify_prog_1.php?prog_id=<?=$prog_id?>','','width=450,height=600,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="�޸�"><input type=button onclick='delrecord(<?=$prog_id?>)'
		<?
		if($f_exist||$f_unknown)
			echo " disabled";
		?>
		value="ɾ����¼"><input type=button onclick='delfile(<?=$prog_id?>)'
		<?
		if(!$f_exist||$f_unknown)
			echo " disabled";
		?>
		value="ɾ���ļ�"></td>
</tr>
<?
}
?>
<tr bgcolor=white><td colspan=8 align=right>
<?
$preoffset=0;
$nextoffset=0;
$endpage=0;
if($offset!=0)
{
	$preoffset=($offset-$pageitem)>0?($offset-$pageitem):0;
	?>
	<a href="?content=music_prog_pinyin&pinyin=<?=$pinyin?>&offset=0">����ǰ��</a>&nbsp;&nbsp;
	<a href="?content=music_prog_pinyin&pinyin=<?=$pinyin?>&offset=<?=$preoffset?>">��ǰһҳ��</a>&nbsp;&nbsp;
	<?
}

if(($offset+$pageitem)<$rowCount)
{
	$nextoffset=$offset+$pageitem;
	$endpage=$rowCount-$pageitem;
	?>
	<a href="?content=music_prog_pinyin&pinyin=<?=$pinyin?>&offset=<?=$nextoffset?>">����һҳ��</a>&nbsp;&nbsp;
	<a href="?content=music_prog_pinyin&pinyin=<?=$pinyin?>&offset=<?=$endpage?>">�����</a>&nbsp;&nbsp;
	<?
}
?>
<?=(ceil(($rowCount-$offset)/$pageitem)).'/'.ceil($rowCount/$pageitem)?>,��<?=$rowCount?>��,ÿҳ<?=$pageitem?>��
</td></tr>
<caption valign=top>���и���<span class=small>(��<span class=red><?=$rowCount?></span>��)</span></caption>
</table>
