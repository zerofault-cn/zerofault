<?
include_once "../include/mysql_connect.php";
if(!isset($type_id)||$type_id=='')
{
	if(!isset($cookie_type_id)||$cookie_type_id=='')
	{
		$type_id=1;
	}
	else
	{
		$type_id=$cookie_type_id;
	}
}
setcookie("cookie_type_id",$type_id);
$sql1="select id,type_name from flash_type where del_flag=1 order by id";
$result1=mysql_query($sql1);
?>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption><span style="color:#3399cc">Flash��Դ�б�</span> ѡ�����</caption>
<tr bgcolor=white>
	<?
	while($r=mysql_fetch_array($result1))
	{
		$tmp_id=$r[0];
		$tmp_name=$r[1];
		?>
		<td align="center" 
		<?
		if($type_id==$tmp_id)
		{
			echo "bgcolor=#3399cc";
			$now_name=$tmp_name;
		}
		?>
		><a href="?content=flash_source&type_id=<?=$tmp_id?>"><?=$tmp_name?></td>
		<?
	}
	?>
</tr>
</table>
<?
if(!isset($offset)||$offset=='')
{
	if(!isset($cookie_flash_offset)||$cookie_flash_offset=='')
	{
		$offset=0;
	}
	else
	{
		$offset=$cookie_flash_offset;
	}
}
setcookie("cookie_flash_offset",$offset);
$pageitem=20;//�趨ÿҳ��ʾ����
$sql1="select count(*) from flash_source where type=".$type_id;
$sql2="select * from flash_source where type=".$type_id." order by id desc limit ".$offset.",".$pageitem;
$result1=mysql_query($sql1);
$rowCount=mysql_result($result1,0,0);//�������ܼ�¼��
$result2=mysql_query($sql2);
?>
<script language="javascript">
function del(id)
{
	
	if(confirm("ȷ��Ҫɾ���ü�¼��?"))
	{
		window.location="flash_delete_source.php?id="+id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor=white>
	<td>���</td>
	<td>����</td>
	<td>�ļ���</td>
	<td>¼��ʱ��</td>
	<td>��Ч��־</td>
	<td align=center>����</td>
</tr>
<?
$i=0;
while($r=mysql_fetch_array($result2))
{
	$i++;
	$id=$r[0];
	$flash_name=$r[2];
	$flash_path=$r[3];
	$time=$r[7];
	if($bgcolor!='#d0d0d0')
	{
		$bgcolor='#d0d0d0';
	}
	else
	{
		$bgcolor='#f0f0f0';
	}
	?>
<tr bgcolor='<?=$bgcolor?>'>
	<td><?=$i?></td>
	<td><a href='#<?=$id?>'><?=$flash_name?></a></td>
	<td><a href='../flash/<?=$flash_path?>'><?=substr(strrchr($flash_path,"/"),1)?></a></td>
	<td><?=$time?></td>
	<td>
	<?
	$flashfile_path='/jbproject/tomcat/goldsoft/php-vod/flash'.$flash_path;
	$f_exist=file_exists($flashfile_path);
	if($f_exist)
	{
		?>
		<a style='color:blue' title='�ļ�·��:<?=$flashfile_path?>'>��</a>
		<?
	}
	else
	{
		?>
		<a style='color:red' title='�ļ�·��:<?=$flashfile_path?>'>��</a>
		<?
	}
	?>
	<td align=center><input type=button onclick="window.open('flash_modify_source_1.php?id=<?=$id?>','','width=450,height=280,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="�޸�"><input type=button onclick='del(<?=$id?>)' value="ɾ��"></td>
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
	<a href="?content=flash_source&type_id=<?=$type_id?>&offset=0">����ǰ��</a>&nbsp;&nbsp;
	<a href="?content=flash_source&type_id=<?=$type_id?>&offset=<?=$preoffset?>">��ǰһҳ��</a>&nbsp;&nbsp;
	<?
}

if(($offset+$pageitem)<$rowCount)
{
	$nextoffset=$offset+$pageitem;
	$endpage=$rowCount-$pageitem;
	?>
	<a href="?content=flash_source&type_id=<?=$type_id?>&offset=<?=$nextoffset?>">����һҳ��</a>&nbsp;&nbsp;
	<a href="?content=flash_source&type_id=<?=$type_id?>&offset=<?=$endpage?>">�����</a>&nbsp;&nbsp;
	<?
}
?>
<?=(ceil(($rowCount-$offset)/$pageitem)).'/'.ceil($rowCount/$pageitem)?>,��<?=$rowCount?>��,ÿҳ<?=$pageitem?>��
</td></tr>
<tr bgcolor=white>
	<td colspan=6 align=center><a href='index.php?content=flash_add_source_1' style="color:red">��������ݡ�</a></td>
</tr>
<caption><span style="color:#3399cc"><?=$now_name?></span>�б�<span class=small>(��<span style="color:#3399cc"><?=$rowCount?></span>��)</caption>
</table>
