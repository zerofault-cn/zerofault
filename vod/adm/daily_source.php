<?
include_once "../include/mysql_connect.php";
if(!isset($type)||$type=='')
{
	if(!isset($cookie_type)&&$type=='')
	{
		$type=1;
	}
	else
	{
		$type=$cookie_type;
	}
}
setcookie("cookie_type",$type);
$sql1="select id,type_name from daily_type where del_flag=1";
$result1=mysql_query($sql1);
?>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption>ѡ�����</caption>
<tr bgcolor=white>
	<?
	while($r=mysql_fetch_array($result1))
	{
		$tmp_id=$r[0];
		$tmp_type_name=$r[1];
		?>
		<td align="center" 
		<?
		if($type==$tmp_id)
		{
			echo "bgcolor=#3399cc";
			$now_type_name=$tmp_type_name;
		}
		?>
		><a href="?content=daily_source&type=<?=$tmp_id?>"><?=$tmp_type_name?></td>
		<?
	}
	?>
</tr>
</table>
<?
if(!isset($offset)||$offset=='')
{
	if(!isset($cookie_daily_offset)||$cookie_daily_offset=='')
	{
		$offset=0;
	}
	else
	{
		$offset=$cookie_daily_offset;
	}
}
setcookie("cookie_daily_offset",$offset);
$pageitem=20;//�趨ÿҳ��ʾ����
$sql1="select count(*) from daily_source where type=".$type;
$sql2="select * from daily_source where type=".$type." order by id desc limit ".$offset.",".$pageitem;
$result1=mysql_query($sql1);
$rowCount=mysql_result($result1,0,0);//�������ܼ�¼��
$result2=mysql_query($sql2);
?>
<script language="javascript">
function delrecord(id)
{
	
	if(confirm("ȷ��Ҫɾ���ü�¼��?"))
	{
		window.location="daily_delete.php?id="+id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor=white>
	<td>���</td>
	<td>���ű���</td>
	<td>¼��ʱ��</td>
	<td align=center>�ļ�</td>
	<td align=center>��Ч��־</td>
	<td align=center>����</td>
</tr>
<?
$i=0;
while($r=mysql_fetch_array($result2))
{
	$i++;
	$id=$r[0];
	$title=$r[1];
	$source=$r[2];
	$descr=$r[3];
	$time=$r[5];
	$source_path='/dpfs/bod/daily_source/'.str_replace('list__','',$source);
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
	<td><a title=<?=str_replace('<br />','&#13',addslashes($descr))?>><?=$title?></a></td>
	<td><?=$time?></td>
	<td align=center>
	<?
	$f_exist=file_exists($source_path);
	if(strrchr($source,".")=='.wmv'||strrchr($source,".")=='.WMV')
	{
		$link='mms://'.$_SERVER["SERVER_ADDR"].'/bod/daily_source/'.str_replace('list__','',$source);
	}
	if(strrchr($source,".")=='.rm'||strrchr($source,".")=='.RM')
	{
		$link='rtsp://'.$_SERVER["SERVER_ADDR"].':555/bod/daily_source/'.str_replace('list__','',$source);
	}
	if($f_exist)
	{
		?>
		<a style='color:blue' href='<?=$link?>' title='�ļ�·��:<?=$source_path?>'>��</a>
		<?
	}
	else
	{
		?>
		<a style='color:red' href='<?=$link?>' title='�ļ�·��:<?=$source_path?>'>��</a>
		<?
	}
	?>
	</td>
	<td align=center>
	<?
	$del_flag=$r["del_flag"];
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
	?></td>
	<td align=center><input type=button onclick="window.open('daily_modify_1.php?id=<?=$id?>','','width=450,height=280,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="�޸�"><input type=button onclick='delrecord(<?=$id?>)' value="ɾ��"></td>
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
	<a href="?content=daily_source&type=<?=$type?>&offset=0">����ǰ��</a>&nbsp;&nbsp;
	<a href="?content=daily_source&type=<?=$type?>&offset=<?=$preoffset?>">��ǰһҳ��</a>&nbsp;&nbsp;
	<?
}

if(($offset+$pageitem)<$rowCount)
{
	$nextoffset=$offset+$pageitem;
	$endpage=$rowCount-$pageitem;
	?>
	<a href="?content=daily_source&type=<?=$type?>&offset=<?=$nextoffset?>">����һҳ��</a>&nbsp;&nbsp;
	<a href="?content=daily_source&type=<?=$type?>&offset=<?=$endpage?>">�����</a>&nbsp;&nbsp;
	<?
}
?>
<?=(ceil(($rowCount-$offset)/$pageitem)).'/'.ceil($rowCount/$pageitem)?>,��<?=$rowCount?>��,ÿҳ<?=$pageitem?>��
</td></tr>
<tr bgcolor=white>
	<td colspan=6 align=center><a href='index.php?content=daily_add_source_1' style="color:red">��������ݡ�</a><a href="index.php?content=daily_delete2&type=<?=$type?>">��ɾ�������������ݡ�</td>
</tr>
<caption><span style="color:#3399cc"><?=$now_type_name?></span>�б�<span class=small>(��<span style="color:#3399cc"><?=$rowCount?></span>��)</caption>
</table>
