<?
include_once "../include/mysql_connect.php";
if(!isset($type)||$type=='')
{
	if(!isset($cookie_type)||$cookie_type=='')
	{
		$type='yaowen';
	}
	else
	{
		$type=$cookie_type;
	}
}
if(!isset($offset)||$offset=='')
{
	if(!isset($cookie_zw_offset)||$cookie_zw_offset=='')
	{
		$offset=0;
	}
	else
	{
		$offset=$cookie_zw_offset;
	}
}
setcookie("cookie_type",$type);
setcookie("cookie_zw_offset",$offset);
$sql1="select distinct type from zw_suining order by type";
$result1=mysql_query($sql1);
?>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption><span style="color:#3399cc">��������</span></caption>
<tr bgcolor=white>
	<?
	while($r=mysql_fetch_array($result1))
	{
		$tmp_type=$r[0];
		?>
		<td align="center" 
		<?
		if($tmp_type=='yaowen')
		{
			$tmp_name='����Ҫ��';
		}
		if($tmp_type=='xiangmu')
		{
			$tmp_name='Ͷ����Ŀ';
		}
		if($tmp_type=='huanjing')
		{
			$tmp_name='Ͷ�ʻ���';
		}
		if($tmp_type=='youhui')
		{
			$tmp_name='�Ż�����';
		}
		if($tmp_type=='fuwu')
		{
			$tmp_name='�������';
		}
		if($type==$tmp_type)
		{
			echo "bgcolor=#3399cc";
			$now_name=$tmp_name;
		}
		?>
		><a href="?content=zw_source&type=<?=$tmp_type?>"><?=$tmp_name?></td>
		<?
	}
	?>
</tr>
</table>
<?

$pageitem=20;//�趨ÿҳ��ʾ����
$sql2="select count(*) from zw_suining where type='".$type."'";
$sql3="select * from zw_suining where type='".$type."' order by id desc limit ".$offset.",".$pageitem;
$result2=mysql_query($sql2);
$rowCount=mysql_result($result2,0,0);//�������ܼ�¼��
$result3=mysql_query($sql3);
?>
<script language="javascript">
function del(id)
{
	
	if(confirm("ȷ��Ҫɾ���ü�¼��?"))
	{
		window.location="zw_delete.php?id="+id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor=white>
	<td>���</td>
	<td>����</td>
	<td>����</td>
	<td>¼��ʱ��</td>
	<td align=center>����</td>
</tr>
<?
$i=0;
while($r=mysql_fetch_array($result3))
{
	$i++;
	$id=$r[0];
	$title=$r[3];
	$count=$r[5];
	$time=$r[6];
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
	<td><a href='#<?=$id?>'><?=$title?></a></td>
	<td><?=$count?></td>
	<td><?=$time?></td>
	<td align=center><input type=button onclick="window.open('zw_modify_1.php?id=<?=$id?>','','width=450,height=280,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="�޸�"><input type=button onclick='del(<?=$id?>)' value="ɾ��"></td>
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
	<a href="?content=zw_source&type=<?=$type?>&offset=0">����ǰ��</a>&nbsp;&nbsp;
	<a href="?content=zw_source&type=<?=$type?>&offset=<?=$preoffset?>">��ǰһҳ��</a>&nbsp;&nbsp;
	<?
}

if(($offset+$pageitem)<$rowCount)
{
	$nextoffset=$offset+$pageitem;
	$endpage=$rowCount-$pageitem;
	?>
	<a href="?content=zw_source&type=<?=$type?>&offset=<?=$nextoffset?>">����һҳ��</a>&nbsp;&nbsp;
	<a href="?content=zw_source&type=<?=$type?>&offset=<?=$endpage?>">�����</a>&nbsp;&nbsp;
	<?
}
?>
<?=(ceil(($rowCount-$offset)/$pageitem)).'/'.ceil($rowCount/$pageitem)?>,��<?=$rowCount?>��,ÿҳ<?=$pageitem?>��
</td></tr>
<tr bgcolor=white>
	<td colspan=6 align=center><a href='index.php?content=zw_add_1' style="color:red">��������ݡ�</a></td>
</tr>
<caption><span style="color:#3399cc"><?=$now_name?></span>�б�<span class=small>(��<span style="color:#3399cc"><?=$rowCount?></span>��)</caption>
</table>
