<?
include_once "../include/mysql_connect.php";
if(!isset($type)||$type=='')
{
	if(!isset($cookie_type)||$cookie_type=='')
	{
		$type='shenghuo';
	}
	else
	{
		$type=$cookie_type;
	}
}
if(!isset($offset)||$offset=='')
{
	if(!isset($cookie_bm_offset)||$cookie_bm_offset=='')
	{
		$offset=0;
	}
	else
	{
		$offset=$cookie_bm_offset;
	}
}
setcookie("cookie_type",$type);
setcookie("cookie_bm_offset",$offset);
$sql1="select distinct type from bianmin where city='suining' order by type";
$result1=mysql_query($sql1);
?>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption><span style="color:#3399cc">便民服务</span></caption>
<tr bgcolor=white>
	<?
	while($r=mysql_fetch_array($result1))
	{
		$tmp_type=$r[0];
		?>
		<td align="center" 
		<?
		if($tmp_type=='shenghuo')
		{
			$tmp_name='生活提示';
		}
		if($tmp_type=='yiliao')
		{
			$tmp_name='医疗保健';
		}
		if($tmp_type=='lvyou')
		{
			$tmp_name='旅游信息';
		}
		if($tmp_type=='news')
		{
			$tmp_name='遂宁新闻';
		}
		if($type==$tmp_type)
		{
			echo "bgcolor=#3399cc";
			$now_name=$tmp_name;
		}
		?>
		><a href="?content=bm_source&type=<?=$tmp_type?>"><?=$tmp_name?></td>
		<?
	}
	?>
</tr>
</table>
<?

$pageitem=20;//设定每页显示行数
$sql2="select count(*) from bianmin where type='".$type."'";
$sql3="select * from bianmin where type='".$type."' order by id desc limit ".$offset.",".$pageitem;
$result2=mysql_query($sql2);
$rowCount=mysql_result($result2,0,0);//本类别的总记录数
$result3=mysql_query($sql3);
?>
<script language="javascript">
function del(id)
{
	
	if(confirm("确定要删除该记录吗?"))
	{
		window.location="bm_delete.php?id="+id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor=white>
	<td>序号</td>
	<td>标题</td>
	<td>人气</td>
	<td>录入时间</td>
	<td align=center>操作</td>
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
	<td align=center><input type=button onclick="window.open('bm_modify_1.php?id=<?=$id?>','','width=450,height=280,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="修改"><input type=button onclick='del(<?=$id?>)' value="删除"></td>
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
	<a href="?content=bm_source&type=<?=$type?>&offset=0">【最前】</a>&nbsp;&nbsp;
	<a href="?content=bm_source&type=<?=$type?>&offset=<?=$preoffset?>">【前一页】</a>&nbsp;&nbsp;
	<?
}

if(($offset+$pageitem)<$rowCount)
{
	$nextoffset=$offset+$pageitem;
	$endpage=$rowCount-$pageitem;
	?>
	<a href="?content=bm_source&type=<?=$type?>&offset=<?=$nextoffset?>">【后一页】</a>&nbsp;&nbsp;
	<a href="?content=bm_source&type=<?=$type?>&offset=<?=$endpage?>">【最后】</a>&nbsp;&nbsp;
	<?
}
?>
<?=(ceil(($rowCount-$offset)/$pageitem)).'/'.ceil($rowCount/$pageitem)?>,共<?=$rowCount?>条,每页<?=$pageitem?>条
</td></tr>
<tr bgcolor=white>
	<td colspan=6 align=center><a href='index.php?content=bm_add_1' style="color:red">【添加内容】</a></td>
</tr>
<caption><span style="color:#3399cc"><?=$now_name?></span>列表<span class=small>(共<span style="color:#3399cc"><?=$rowCount?></span>个)</caption>
</table>
