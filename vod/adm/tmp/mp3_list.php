<!-- mp3�б� -->
<script language="javascript">
function del_mp3_record(mp3_id)
{
	if(confirm("ȷ��Ҫɾ����mp3�ļ�¼��?"))
	{
		window.location="mp3_del_record.php?mp3_id="+mp3_id;
		
	}
	else
		return;
}

function del_mp3_file(mp3_id)
{
	if(confirm("ȷ��Ҫɾ����mp3�ļ���?"))
	{
		window.location="mp3_del_file.php?mp3_id="+mp3_id;
		
	}
	else
		return;
}
</script> 

<?
include_once "../include/mysql_connect.php";
include_once "mp3_id3_utils.php";
$pageitem=20;
if(!isset($offset)||$offset=='')
{
	$offset=0;
}
$sql1="select count(*) from singer_info,song_info where singer_info.singer_id=song_info.singer_id ";
$sql2="select singer_info.singer_id,singer_info.singer_name,song_info.id,song_info.song_name,song_info.album_name,song_info.path,song_info.lyric,song_info.del_flag from singer_info,song_info where singer_info.singer_id=song_info.singer_id ";
if(isset($key_mp3_name)&&$key_mp3_name!="")
{
	$sql1.=" and (song_info.song_name like '%".$key_mp3_name."%' or song_info.album_name like '%".$key_mp3_name."%') ";
	$sql2.=" and (song_info.song_name like '%".$key_mp3_name."%' or song_info.album_name like '%".$key_mp3_name."%') ";
	$caption='query';//Ϊ������ʾ�������ж�����
	$newpage_url_ext='&key_mp3_name='.$key_mp3_name;//Ϊ��ҳʱ�ṩ����
}
if(isset($singer_id)&&$singer_id!="")
{
	$sql1.=" and song_info.singer_id='".$singer_id."' ";
	$sql2.=" and song_info.singer_id='".$singer_id."' ";
	$caption='singer';
	$newpage_url_ext='&singer_id='.$singer_id;
}
if(isset($album_name)&&$album_name!='')
{
	$sql1.=" and binary song_info.album_name='".$album_name."' ";
	$sql2.=" and binary song_info.album_name='".$album_name."' ";
	$caption='album';
	$newpage_url_ext='&album_name='.$album_name;
}
if(isset($listtype)&&$listtype=='new')
{
	$sql1.=" limit 0,20";
	$sql2.=" order by song_info.id desc limit 0,20";
	$caption='new';
}
else
{
	$sql2.=" order by song_info.id desc limit ".$offset.",".$pageitem;
}
$result1=mysql_query($sql1);
$rowCount=mysql_result($result1,0,0);
$result2=mysql_query($sql2);
?>
<table width="100%" border=0 cellspacing=1 cellpadding=0 bgcolor=black>
<tr>
	<td colspan=8 align=center>
<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor=white>
<tr>
	<td align=center>
		<?
		if(!isset($page_num) || ''==$page_num)
		{
			$page_num=1;
		}
		$allPage=ceil($rowCount/$pageitem);
		$page_size=20;
		$tmp_offset=0;
		$page_start=($page_num-1)*$page_size+1;
		$tmp_offset=($page_start-1)*$pageitem;
		if($page_num!=1)//��20ҳ
		{
			$pre_offset=$tmp_offset-$pageitem;
			$pre_page_num=$page_num-1;
			echo '<a style="font-size:9pt;color:red" href="?content=mp3_list'.$newpage_url_ext.'&page_num='.($pre_page_num).'&offset='.$pre_offset.'">&lt;&lt;&nbsp;</a>';
		}
		if($offset!=0)//��һҳ
		{
			$pre_offset=max(($offset-$pageitem),0);
			if($pre_offset < ($page_num-1)*$page_size*$pageitem)
			{
				$pre_page_num=$page_num-1;
			}
			else
			{
				$pre_page_num=$page_num;
			}
			echo '<a style="font-size:9pt;color:red" href="?content=mp3_list'.$newpage_url_ext.'&page_num='.$pre_page_num.'&offset='.$pre_offset.'">&nbsp;&lt;&nbsp;</a>';
		}
		for($i=$page_start;$i<=min($allPage,$page_num*$page_size);$i++)
		{
			if($offset==$tmp_offset)
			{
				echo '<span style="font-size:9pt;color:red">['.$i.'] </span>';
			}
			else
			{
				echo '<a style="font-size:9pt" href="?content=mp3_list'.$newpage_url_ext.'&page_num='.$page_num.'&offset='.$tmp_offset.'">'.$i.' </a>';
			}
			$tmp_offset+=$pageitem;
		}
		if(($offset+$pageitem)<$rowCount)//��һҳ
		{
			$next_offset=$offset+$pageitem;
			if(($offset+$pageitem)>=$page_num*$page_size*$pageitem)
			{
				$next_page_num=$page_num+1;
			}
			else
			{
				$next_page_num=$page_num;
			}
			echo '<a style="font-size:9pt;color:red" href="?content=mp3_list'.$newpage_url_ext.'&page_num='.$next_page_num.'&offset='.$next_offset.'">&nbsp;&gt;&nbsp;</a>';
		}
		if(($page_start+$page_size)<$allPage)//��20ҳ
		{
			$next_offset=$page_num*$page_size*$pageitem;
			$next_page_num=$page_num+1;
			echo '<a style="font-size:9pt;color:red" href="?content=mp3_list'.$newpage_url_ext.'&page_num='.$next_page_num.'&offset='.$next_offset.'">&nbsp;&gt;&gt;</a>';
		}
		?>
		<!-- &nbsp;&nbsp;<span style="font-size:9pt;color:red"><?=$offset+1?>-<?=min(($offset+$pageitem),$rowCount)?></span> -->
	</td>
</tr>
</table>
</td>
</tr>
<tr bgcolor=white>
	<td align=center>����</td>
	<td align=center>ר��</td>
	<td align=center>����</td>
	<td align=center>�ļ�</td>
	<td align=center>��Ч��</td>
	<td align=center>���</td>
	<td align=center>λ��</td>
	<td align=center>ִ�в���</td>
</tr>
<?
while($r=mysql_fetch_array($result2))
{
	$singer_id=$r[0];
	$singer_name=$r[1];
	$id=$r[2];
	$song_name=$r[3];
	$album_name=$r[4];
	$path=$r[5];
	$lyric=substr($r[6],0,4);
	$del_flag=$r[7];
	if(strlen($song_name)>14)
		$tmp_song_name=substr($song_name,0,14).'...';
	else
		$tmp_song_name=$song_name;
	if(strlen($album_name)>12)
		$tmp_album_name=substr($album_name,0,12).'..';
	else
		$tmp_album_name=$album_name;
	$prog_ip=getIpByPath($path);
	$server_ip=getServerIp();
	$s_ip=substr(strrchr($server_ip,"."),1);
	if($s_ip!=87&&$s_ip!=88&&$s_ip!=89&&$s_ip!=90&&$s_ip!=91&&$s_ip!=92)
	{
		$prog_ip=$server_ip;//������������6̨ʱ
	}
	$play_path='http://'.$prog_ip.':8088/'.$path;
	if($bgcolor!='#d0d0d0')
	{
		$bgcolor='#d0d0d0';
	}
	else
	{
		$bgcolor='#f0f0f0';
	}
	$file_exist=file_exists("/dpfs/".$path);
	?>
<tr bgcolor=<?=$bgcolor?>>
	<td align=center><a href="index.php?content=mp3_list&singer_id=<?=$singer_id?>"><?=$singer_name?></a></td>
	<td align=center class=narrow><a href="index.php?content=mp3_list&album_name=<?=urlencode($album_name)?>" title=<?=$album_name?>><?=$tmp_album_name?></a></td>
	<td align=center class=narrow><a href="<?=$play_path?>" title="<?=$song_name?>"><?=$tmp_song_name?></a></td>
	<td align=center>
	<?
	if($file_exist)
	{
		if(filesize("/dpfs/".$path)>0)
		{
			?>
			<a style=color:blue href=#<?=$id?> title="�ļ�·��:/dpfs/<?=$path?>">��</a>
			<?
		}
		else
		{
			?>
			<a style=color:#ff00ff href="#" onclick="javascript:window.open('mp3_upload_1.php?singer_name=<?=$singer_name?>&song_name=<?=$song_name?>&album_name=<?=$album_name?>&mp3_id=<?=$id?>','','width=450,height=250,toolbar=no,status=no,scrollbars=auto,resizable=yes');" title="�����ϴ�">��</a>
			<?
		}
	}
	else
	{
		?>
		<a style=color:red href="#" onclick="javascript:window.open('mp3_upload_1.php?singer_name=<?=$singer_name?>&song_name=<?=$song_name?>&album_name=<?=$album_name?>&mp3_id=<?=$id?>','','width=450,height=250,toolbar=no,status=no,scrollbars=auto,resizable=yes');" title="�ļ�·��:/dpfs/<?=$path?>">��</a>
		<?
	}
	?>
	<td align=center>
	<?
	if($del_flag==1)
	{
		$k++;
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
	<td align=center>
	<?
	if($lyric=='����'||$lyric=='')
	{
		echo '����';
	}
	else
	{
		?>
		<a href=# onclick="window.open('mp3_lyric.php?mp3_id=<?=$id?>','','width=300,height=400,toolbar=no,status=no,scrollbars=yes,resizable=yes');" title=���><img src="image/txtimg.gif" border=0 alt=���></a>
		<?
	}
	?></td>
	<td align=center><!-- ȡ��MP3��λ�� -->
	<?
	$id1 = mp3_id("/dpfs/".$path);
	if($id1!='-1' && $file_exist && reset($id1))
	{
		$bit=$id1['bitrate'];
		$mode=$id1['mode'];
		$lenght=$id1['lenght'];
		if($bit!='128' && $bit!='160' &&$bit!='192' &&$bit!='256' &&$bit!='320')
		{
			echo '<span class=red>'.$bit.'</span>';
		}
		else
		{
			echo $bit;
		}
		if($mode=='Stereo')
		{
		//	echo 'OK';
		}
		else
		{
		//	echo '<span class=red>KO</span>';
		}
	}
	else
	{
		echo '<span class=red>N/A</span>';
	}
	?>
	</td>
	<td align=center><input type=button onclick="window.open('mp3_amend_1.php?mp3_id=<?=$id?>','','width=480,height=410,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value= "�޸�" ><input type=button onclick="del_mp3_record(<?=$id?>)" 
		<?
		if($file_exist)
			echo " disabled ";
		?>
		value= "ɾ����¼" ><input type=button onclick='del_mp3_file(<?=$id?>)'
		<?
		if(!$file_exist)
			echo " disabled ";
		?>
		value= "ɾ���ļ�" ></td>
</tr>
<?
}
?>
<tr bgcolor=white border=0 bordercolor=#ffffff>
	<td colspan=8 align=right>
<?
if($offset!=0)
{
	$pre_offset=max(($offset-$pageitem),0);
	if($pre_offset < ($page_num-1)*$page_size*$pageitem)
	{
		$pre_page_num=$page_num-1;
	}
	else
	{
		$pre_page_num=$page_num;
	}
	?>
	<a href="?content=mp3_list<?=$newpage_url_ext?>&page_num=1&offset=0">����ǰ��</a>&nbsp;&nbsp;
	<a href="?content=mp3_list<?=$newpage_url_ext?>&page_num=<?=$pre_page_num?>&offset=<?=$pre_offset?>">��ǰһҳ��</a>&nbsp;&nbsp;
	<?
}

if(($offset+$pageitem)<$rowCount)
{
	$next_offset=$offset+$pageitem;
	$end_offset=$rowCount-($rowCount%$pageitem);
	if(($offset+$pageitem)>=$page_num*$page_size*$pageitem)
	{
		$next_page_num=$page_num+1;
	}
	else
	{
		$next_page_num=$page_num;
	}
	?>
	<a href="?content=mp3_list<?=$newpage_url_ext?>&page_num=<?=$next_page_num?>&offset=<?=$next_offset?>">����һҳ��</a>&nbsp;&nbsp;
	<a href="?content=mp3_list<?=$newpage_url_ext?>&page_num=<?=ceil($allPage/$page_size)?>&offset=<?=$end_offset?>">�����</a>&nbsp;&nbsp;
	<?
}
?>
<?=ceil(($offset+1)/$pageitem).'/'.ceil($rowCount/$pageitem)?>,��<?=$rowCount?>��,ÿҳ<?=$pageitem?>��
<a style="font-size:9pt;color:red" href="mp3_playall.php?offset=<?=$offset?><?=$newpage_url_ext?>">��������</a></td></tr>
<caption valign=top>
<?
if($caption=='query')
{
	echo '��ѯ�ؼ���<span style="color:#3399cc">'.$key_mp3_name.'</span>�Ľ��';
}
elseif($caption=='singer')
{
	echo '����<span style="color:#3399cc">'.$singer_name.'</span>���и���';
}
elseif($caption=='album')
{
	echo 'ר��<span style="color:#3399cc">'.$album_name.'</span>���и���';
}
elseif($caption=='new')
{
	echo '�����ϴ���20�׸���';
}
else
{
	echo '���и���';
}
?><span class=small>(��<span class=red><?=$rowCount?></span>��)</span></caption>
</table>