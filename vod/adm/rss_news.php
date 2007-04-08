<?
include_once "../include/mysql_connect.php";
if(!isset($channel)||$channel=='')
{
	if(!isset($cookie_channel)||$cookie_channel=='')
	{
		$channel=2;
	}
	else
	{
		$channel=$cookie_channel;
	}
}
setcookie("cookie_channel",$channel);
$sql1="select id,channel_name from rss_channel where del_flag=1 order by id";
$result1=mysql_query($sql1);
?>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption><span style="color:#3399cc">RSS实时新闻</span> 选择分类</caption>
<tr bgcolor=white>
	<?
	while($r=mysql_fetch_array($result1))
	{
		$tmp_id=$r[0];
		$tmp_name=$r[1];
		?>
		<td align="center" 
		<?
		if($channel==$tmp_id)
		{
			echo "bgcolor=#3399cc";
			$now_name=$tmp_name;
		}
		?>
		><a href="?content=rss_news&channel=<?=$tmp_id?>"><?=$tmp_name?></td>
		<?
	}
	?>
</tr>
</table>
<?
if(!isset($offset)||$offset=='')
{
	if(!isset($cookie_rss_offset)||$cookie_rss_offset=='')
	{
		$offset=0;
	}
	else
	{
		$offset=$cookie_rss_offset;
	}
}
setcookie("cookie_rss_offset",$offset);
$pageitem=20;//设定每页显示行数
$sql1="select count(*) from rss_news where channel=".$channel;
$sql2="select * from rss_news where channel=".$channel." order by id desc limit ".$offset.",".$pageitem;
$result1=mysql_query($sql1);
$rowCount=mysql_result($result1,0,0);//本类别的总记录数
$result2=mysql_query($sql2);
?>
<script language="javascript">
function del(id)
{
	
	if(confirm("确定要删除该记录吗?"))
	{
		window.location="rss_delete_news.php?id="+id;
	}
	else
		return;
}
</script>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<tr bgcolor=white>
	<td>序号</td>
	<td>标题</td>
	<td>录入时间</td>
	<td align=center>操作</td>
</tr>
<?
$i=0;
while($r=mysql_fetch_array($result2))
{
	$i++;
	$id=$r[0];
	$title=$r[2];
	$time=$r[5];
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
	<td><?=$time?></td>
	<td align=center><input type=button onclick="window.open('rss_modify_news_1.php?id=<?=$id?>','','width=450,height=280,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="修改"><input type=button onclick='del(<?=$id?>)' value="删除"></td>
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
	<a href="?content=rss_news&type=<?=$type?>&offset=0">【最前】</a>&nbsp;&nbsp;
	<a href="?content=rss_news&type=<?=$type?>&offset=<?=$preoffset?>">【前一页】</a>&nbsp;&nbsp;
	<?
}

if(($offset+$pageitem)<$rowCount)
{
	$nextoffset=$offset+$pageitem;
	$endpage=$rowCount-$pageitem;
	?>
	<a href="?content=rss_news&type=<?=$type?>&offset=<?=$nextoffset?>">【后一页】</a>&nbsp;&nbsp;
	<a href="?content=rss_news&type=<?=$type?>&offset=<?=$endpage?>">【最后】</a>&nbsp;&nbsp;
	<?
}
?>
<?=(ceil(($rowCount-$offset)/$pageitem)).'/'.ceil($rowCount/$pageitem)?>,共<?=$rowCount?>条,每页<?=$pageitem?>条
</td></tr>
<tr bgcolor=white>
	<td colspan=6 align=center><a href='index.php?content=rss_add_news_1' style="color:red">【添加内容】</a></td>
</tr>
<caption><span style="color:#3399cc"><?=$now_name?></span>列表<span class=small>(共<span style="color:#3399cc"><?=$rowCount?></span>个)</caption>
</table>
