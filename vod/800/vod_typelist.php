<?
session_start();
$_SESSION['menu_focus']=2;
$offset=$_REQUEST["offset"];
if(!isset($offset)||$offset=='')
{
	$offset=0;
}
$pageitem=8;
if($offset==0)
{
	$pageitem=$pageitem-2;
}
$query_str=$_SERVER["QUERY_STRING"];
if(''!=$query_str)
{
	$query_str='.'.$query_str;
	$query_str=str_replace('=','.',$query_str);
	$query_str=str_replace('&','.',$query_str);
}
$this_file=basename($_SERVER["PHP_SELF"]);
$html_file='html_cache/'.$this_file.$query_str.'.htm';
$frp=fopen("../include/html_need_update.ini","r+");
while($buffer=fgets($frp,4096))
{
	
	if(substr($buffer,0,strlen($this_file))==$this_file)
	{
		$is_need=substr(trim($buffer),-1);
		break;
	}
	else
	{
		continue;
	}
}
//$is_need=1;
if(isset($is_need) && $is_need==0 && file_exists($html_file))
{
	echo file_get_contents($html_file);
}
else
{
fseek($frp,ftell($frp)-3);
fwrite($frp,"0\r\n");
fclose($frp);
ob_start();
include_once "../include/db_connect.php";
include_once "color.inc.php";
$line_height=48;
$n=0;
$sql1="select count(distinct de.dentry_id) from dict_entry de,prog_info pi where pi.prog_kindsec='1006' and pi.prog_kindthr=de.dentry_id and de.dentry_id!=1026 and de.del_flag=1 and pi.del_flag=1";
$sql2="select distinct de.dentry_id,de.dentry_name from dict_entry de,prog_info pi where pi.prog_kindsec='1006' and de.dentry_id=pi.prog_kindthr and de.dentry_id!=1026 and de.del_flag=1 and pi.del_flag=1 order by length(de.dentry_name),de.dentry_id limit ".$offset.",".$pageitem;
$result1=$db->sql_query($sql1);
$intRowCount=$db->sql_fetchfield(0,0,$result1);
$result2=$db->sql_query($sql2);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>VOD电影</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body leftMargin=0 topMargin=0 background="image/vod/vod1_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="onfoc(0)">

<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
<tr>
	<td width=20 height=10></td>
	<td width=760><?include "top.php";?></td>
	<td width=20>&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table border=0 width="100%" cellspacing=0 cellpadding=0>
	<tr>
		<td height=27>&nbsp;</td>
		<td width="232">&nbsp;</td>
		<td width=38></td>
	</tr>
	<tr>
		<td height=60 align=right valign=top><span class=style30w style="color:#c5f300;margin-right:2em">选择类别&gt;&gt;</span></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td height=393>&nbsp;</td>
		<td align=left valign=top>
		<table border=0 width="100%" cellspacing=0 cellpadding=0>
<?
if($intRowCount>0)
{
	if($offset==0)
	{
		?>
	<tr>
		<td id=0 height="<?=$line_height?>" class="style30b" onMouseOver='this.style.backgroundColor="<?=$vod_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><a style="color:<?=$vod_text?>" href='vod_namelist.php?typeOffset=0&dentry_id=newpub'><img src="image/blank.gif" width=20 height=1 border=0>最新大片</a></td>
	</tr>
	<!-- <tr>
		<td id=1 height="<?=$line_height?>" class=style30b onMouseOver='this.style.backgroundColor="<?=$vod_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><a style="color:<?=$vod_text?>" href='vod_namelist.php?typeOffset=<?=$offset?>&dentry_id=top'><img src="image/blank.gif" width=20 height=1 border=0>热门点播</a></td>
	</tr> -->
	<tr>
		<td id=1 height="<?=$line_height?>" class="style30b" onMouseOver='this.style.backgroundColor="<?=$vod_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><a style="color:<?=$vod_text?>" href='vod_namelist.php?typeOffset=0&dentry_id=newup'><img src="image/blank.gif" width=20 height=1 border=0>最新添加</a></td>
	</tr>
		<?	
		$n=2;
	}
	while($row=$db->sql_fetchrow($result2))
	{
		$dentry_id=$row[0];
		$dentry_name=$row[1];
		?>
	<tr>
		<td id=<?=$n?> height="<?=$line_height?>" class="style30w" onMouseOver='this.style.backgroundColor="<?=$vod_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><a style="color:<?=$vod_text?>" href='vod_namelist.php?typeOffset=<?=$offset?>&dentry_id=<?=$dentry_id?>&dentry_name=<?=urlencode($dentry_name)?>'><img src="image/blank.gif" width=20 height=1 border=0><?=$dentry_name?></a></td>
	</tr>
		<?
		$n++;
	}
}
else
{
	?>
		<tr id=0>
			<td height="<?=$line_height?>" class=style30b><a href="#">暂无数据</a></td>
		</tr>
	<?	
}
if($offset==0)
{
	$tmp_offset=$offset;
	$tmp_pageitem=$pageitem+2;
}
else
{
	$tmp_offset=$offset+2;
	$tmp_pageitem=$pageitem;
}
?>
		</table></td>
		<td></td>
	</tr>
	<tr>
		<td id='aa'>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align=right valign=bottom><span class=style30w style="color:#ffcc00;margin-right:1em">第<?=$tmp_offset/$tmp_pageitem+1?>页&nbsp;&nbsp;共<?=ceil(($intRowCount+2)/$tmp_pageitem)?>页</span></td>
		</tr>
		<tr>
			<td height=20></td>
		</tr>
		</table>
		</td>
		<td>&nbsp;</td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="180" border=0 cellpadding=0 cellspacing=0 class=style22w>
	<tr>
		<td height="33%" align=center 
		<?
		if($offset!=0)//表示不是第一页
		{
			?>
			style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$vod_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('?offset=<?=($offset-$pageitem)>0?($offset-$pageitem):0?>');">上<br>页</a>
			<?
		}
		else
		{
			echo '>';
		}
		?>
		</td>
	</tr>
	<tr>
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$vod_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('menu_1.php');">返<br>回</td>
	</tr>
	<tr>
		<td height="34%" align=center 
		<?
		if(($offset+$pageitem) < $intRowCount)//表示还有下页
		{
			?>
			style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$vod_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('?offset=<?=$offset+$pageitem?>');">下<br>页</a>
			<?
		}
		else
		{
			echo '>';
		}
		?>
		</td>
	</tr>
	</table>
	</td>
</tr>

</table>

</body>

<script language="JavaScript" type="text/JavaScript">
<!--

var key2=0;

function onfoc(n) {
	document.getElementById(n).style.backgroundColor="<?=$vod_selectbar?>";
	td=document.getElementById(n);
	dat =td.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	td.innerHTML = '<a style="color:<?=$vod_text_focus?>" ' + dat;
	document.links[n].focus();
}

function losefoc(n) {
	document.getElementById(n).style.backgroundColor="";
	td=document.getElementById(n);
	dat =td.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	td.innerHTML = '<a style="color:<?=$vod_text?>" ' + dat;
}
if(document.all)
{
	var ie=1;
}
else
{
	var ie=0;
}
function keyDown(e)
{
	if (ie)
	{
		var keycode=event.keyCode; 
	}
	else
	{
		var keycode=e.which;
	}
	var key1 = keycode -48;
	var patern=/^[1-<?=$n?>]$/; 
	if (patern.exec(key1)) 
	{
		if(key1 == key2 + 1) 
			onfoc(key1 - 1);
		else
		{
			losefoc(key2);
			onfoc(key1 - 1)
			key2 = key1 -1;
		}
		location=document.links[key2];
	}
	if(keycode==36)//HOME键
	{
		location="menu_1.php";
	}
	if(keycode==38)//光标左上键
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0) key2=<?=$n-1?>;
		onfoc(key2)
	}
	if(keycode==40)//光标右下键
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2><?=$n-1?>) key2=0;
		onfoc(key2)
		
	}
	if(keycode==33 && <?=$offset?>!=0)
	{
		location="?offset=<?=($offset+2-$pageitem)>0?($offset-$pageitem):0?>";
	}
	if(keycode==34 && <?=$offset+$pageitem?> < <?=$intRowCount?>)
	{
		location="?offset=<?=$offset+$pageitem?>";
	}
}    
document.onkeydown=keyDown
//-->
</script>
</html>
<?
$fwp=fopen($html_file,"w"); 
fwrite($fwp,ob_get_contents());
fclose($fwp);
ob_end_flush();
}
?>