<?
include_once "../include/mysql_connect.php";
include_once "../include/getplaypath.php";
$auth_str='';//atfilm:atfilm@';
if(!isset($dentry_id)||$dentry_id=='')
{
	if(!isset($cookie_dentry_id)||$cookie_dentry_id=='')
	{
		$dentry_id='new';
	}
	else
	{
		$dentry_id=$cookie_dentry_id;
	}
}
setcookie("cookie_dentry_id",$dentry_id);
//$request_url=$_SERVER["REQUEST_URI"];
//setcookie("lastpage",$request_url);
//���Ȳ������
$sql1="select dentry_id,dentry_name from dict_entry where dtype_id=50 and del_flag=1 order by dentry_id";
$result1=mysql_query($sql1);
?>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption>ѡ�����</caption>
<tr bgcolor=white>
	<td align="center" 
	<?
	if($dentry_id=='newpub')
	{
		echo "bgcolor=#3399cc";
		$now_dentry_name='��Ƭ';
	}
	?>
	><a href="?content=vod_prog&dentry_id=newpub">��Ƭ</td>
	<td align="center" 
	<?
	if($dentry_id=='new')
	{
		echo "bgcolor=#3399cc";
		$now_dentry_name='�´�Ƭ';
	}
	?>
	><a href="?content=vod_prog&dentry_id=new">�´�Ƭ</td>
	<?
	while($r=mysql_fetch_array($result1))
	{
		$tmp_dentry_id=$r[0];
		$tmp_dentry_name=$r[1];
		?>
		<td align="center" 
		<?
		if($dentry_id==$tmp_dentry_id)
		{
			echo "bgcolor=#3399cc";
			$now_dentry_name=$tmp_dentry_name;
		}
		?>
		><a href="?content=vod_prog&dentry_id=<?=$tmp_dentry_id?>"><?=$tmp_dentry_name?></a></td>
		<?
	}
	?>
</tr>
</table>
<?
if(!isset($offset)||$offset=='')
{
	if(!isset($cookie_vod_offset)||$cookie_vod_offset=='')
	{
		$offset=0;
	}
	else
	{
		$offset=$cookie_vod_offset;
	}
}
setcookie("cookie_vod_offset",$offset);
$pageitem=20;//�趨ÿҳ��ʾ����
if($dentry_id=='newpub')
{
	$sql2="select ".$pageitem;
	$sql3="select ".$pageitem;
	$sql4="select prog_id,prog_name,prog_path,prog_indate,del_flag,publisher from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1006 order by pubdate desc,prog_id desc limit ".$offset.",".$pageitem;
}
else if($dentry_id=='new')
{
	$sql2="select ".$pageitem;
	$sql3="select ".$pageitem;
	$sql4="select prog_id,prog_name,prog_path,prog_indate,del_flag,publisher from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1006 order by prog_indate desc,operdate desc,opertime desc limit ".$offset.",".$pageitem;
}
else
{
	$sql2="select count(*) from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1006 and prog_kindthr=".$dentry_id;
	$sql3="select count(*) from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1006 and del_flag=1 and prog_kindthr=".$dentry_id;
	$sql4="select prog_id,prog_name,prog_path,prog_indate,del_flag,publisher from prog_info where prog_name is not null and prog_path is not null and prog_kindsec=1006 and prog_kindthr=".$dentry_id." order by prog_id desc limit ".$offset.",".$pageitem;
}
$result2=mysql_query($sql2);
$rowCount=mysql_result($result2,0,0);//�������ܼ�¼��
$result3=mysql_query($sql3);
$validCount=mysql_result($result3,0,0);//��������Ч��¼��
$result4=mysql_query($sql4);
?>
<script language="javascript">
function delrecord(prog_id)
{
	
	if(confirm("ȷ��Ҫɾ���ü�¼��?"))
	{
		window.location="prog_delete.php?del_flag=record&prog_id="+prog_id+"&page_from=vod_prog";
	}
	else
		return;
}
function delfile(prog_id)
{
	if(confirm("ȷ��Ҫɾ�����ļ���")&&confirm("ɾ�����޷��ָ�Ŷ�����ȷ�ϣ�"))
	{
		window.location="prog_delete.php?del_flag=file&prog_id="+prog_id+"&page_from=vod_prog";
	}
	else
		return;
}
</script>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor=white>
	<td>����</td>
	<td>��ʽ</td>
	<td>¼��ʱ��</td>
	<td align=center>�ļ�</td>
	<td align=center>����</td>
	<td align=center>��Ч��</td>
	<td align=center>����</td>
</tr>
<?
$i=0;
while($r=mysql_fetch_array($result4))
{
	$i++;
	$prog_id=$r[0];
	$prog_name=$r[1];
	$prog_path=$r[2];
	$prog_indate=$r[3];
	$del_flag=$r[4];
	$publisher=$r[5];
	if(strlen($prog_name)>18)
		$tmp_prog_name=substr($prog_name,0,18)."...";
	else
		$tmp_prog_name=$prog_name;
	if(strpos($publisher,','))
	{
		$pics = explode(",",$publisher);
		$pic_file=$pics[0];	
	}
	else
	{
		$pic_file=$publisher;
	}
	if($bgcolor!='#d0d0d0')
	{
		$bgcolor='#d0d0d0';
	}
	else
	{
		$bgcolor='#f0f0f0';
	}
	$play_path=getPlayPath($prog_path);
	?>
<tr bgcolor='<?=$bgcolor?>'>
	<td><a href="<?=$play_path?>" title="<?=$prog_name?>"><?=$tmp_prog_name?></a></td>
	<td><?=substr(strrchr($prog_path,"."),1)?></td>
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
	$pic_exist=file_exists("../haibao/".$pic_file);
	if($pic_file!=""&&$pic_exist)
	{
		?>
		<a href=# style="color:blue" onclick="window.open('../haibao/<?=$pic_file?>','','width=450,height=320,toolbar=no,status=no,scrollbars=auto,resizable=yes');" title="�鿴����">��</a>
		<?
	}
	else
	{
		?>
		<a href=# style="color:red" onclick="window.open('pic_upload_1.php?pic_type=haibao&id=<?=$prog_id?>&name=<?=$prog_name?>','','width=450,height=120,toolbar=no,status=no,scrollbars=auto,resizable=yes');" title="�ϴ�����">��</a>
		<?
	}
	?>
	</td>
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
	<td align=center><input type=button onclick="window.open('vod_modify_prog_1.php?prog_id=<?=$prog_id?>','','width=450,height=605,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="�޸�"><input type=button onclick='delrecord(<?=$prog_id?>)'
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
<tr bgcolor=white><td colspan=7 align=right>
<?
$preoffset=0;
$nextoffset=0;
$endpage=0;
if($offset!=0)
{
	$preoffset=($offset-$pageitem)>0?($offset-$pageitem):0;
	?>
	<a href="?content=vod_prog&dentry_id=<?=$dentry_id?>&offset=0">����ǰ��</a>&nbsp;&nbsp;
	<a href="?content=vod_prog&dentry_id=<?=$dentry_id?>&offset=<?=$preoffset?>">��ǰһҳ��</a>&nbsp;&nbsp;
	<?
}

if(($offset+$pageitem)<$rowCount)
{
	$nextoffset=$offset+$pageitem;
	$endpage=$rowCount-$pageitem;
	?>
	<a href="?content=vod_prog&dentry_id=<?=$dentry_id?>&offset=<?=$nextoffset?>">����һҳ��</a>&nbsp;&nbsp;
	<a href="?content=vod_prog&dentry_id=<?=$dentry_id?>&offset=<?=$endpage?>">�����</a>&nbsp;&nbsp;
	<?
}
?>
<?=(ceil(($rowCount-$offset)/$pageitem)).'/'.ceil($rowCount/$pageitem)?>,��<?=$rowCount?>��,ÿҳ<?=$pageitem?>��
</td></tr>
<caption><span style="color:#3399cc"><?=$now_dentry_name?></span>��Ŀ�б�<span class=small>(��<span style="color:#3399cc"><?=$rowCount?></span>��,��Ч<span style="color:blue"><?=$validCount?></span>��)</span></caption>
</table>
