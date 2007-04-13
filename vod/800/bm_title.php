<?
$type=$_REQUEST['type'];
$offset=$_REQUEST["offset"];
if(isset($type)&&$type=='huoche')
{
	header("Location:bm_huoche_sn.php");
	exit;
}
if(isset($type)&&$type=='dianhua')
{
	header("Location:bm_dianhua_sn.php");
	exit;
}
include_once "../include/db_connect.php";
include_once "color.inc.php";
$city='suining';
$pageitem=9;
if(!isset($offset)||$offset=='')
{
	$offset=0;
}
$sql1="select count(*) from bianmin where city='".$city."' and type='".$type."'";
$sql2="select id,title from bianmin where city='".$city."' and type='".$type."' order by id desc limit ".$offset.",".$pageitem;
$result1=$db->sql_query($sql1);
$intRowCount=$db->sql_fetchfield(0,0,$result1);
$result2=$db->sql_query($sql2);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>无标题文档</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body leftMargin=0 topMargin=0 background="image/bm/bg_<?=$type?>.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="onfoc(0)">
<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
<tr>
	<td width=20 height=10>&nbsp;</td>
	<td width=760><?include "top.php";?></td>
	<td width=20>&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="50" height="30">&nbsp;</td>
		<td width="660">&nbsp;</td>
		<td width=50>&nbsp;</td>
	</tr>
	<tr>
		<td height=55>&nbsp;</td>
		<td valign=top class=style30w><span class=style32w style="color:#990099;margin-left:3em">第<?=$offset/$pageitem+1?>页&nbsp;&nbsp;共<?=ceil($intRowCount/$pageitem)?>页</span></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td height=370 valign="top">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<?
		$i=0;
		while($row=$db->sql_fetchrow($result2))
		{
			$id=$row[0];
			$title=$row[1];
			if(strlen($title)>34)
			{
				$title=substr($title,0,32).'..';
			}
			?>
		<tr>
			<td id=<?=$i?> height="43" class="style30w" onMouseOver='this.style.backgroundColor="<?=$bm_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><a style="color:<?=$bm_text?>" href="bm_info.php?id=<?=$id?>&type=<?=$type?>" onMouseOver='this.style.color="<?=$bm_text_focus?>"' onMouseOut='this.style.color="<?=$bm_text?>"'><?=$i+1?>.<?=$title?></a></td>
		</tr>
			<?
			$i++;
		}
		if($i==0)
		{
			?>
		<tr>
			<td id=<?=$i?> height="44" valign="top" class="style30w"><a href="#">暂时没有内容</a></td>
		</tr>
			<?
			$i++;
		}
		?>
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
			style="cursor:hand" onMouseOver='this.style.backgroundColor="#0066ff"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('?type=<?=$type?>&offset=<?=($offset-$pageitem)>0?($offset-$pageitem):0?>');">上<br>页</a>
			<?
		}
		else
		{
			echo '>';
		}
		?>
		</td>
	</tr>
	<tr height="33%">
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="#0066ff"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('bm_index.php');">返<br>回</td>
	</tr>
	<tr height="34%">
		<td height="34%" align=center 
		<?
		if(($offset+$pageitem) < $intRowCount)//表示还有下页
		{
			?>
			style="cursor:hand" onMouseOver='this.style.backgroundColor="#0066ff"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('?type=<?=$type?>&offset=<?=$offset+$pageitem?>');">下<br>页</a>
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
var key2=0;

function onfoc(n) {
	document.getElementById(n).style.backgroundColor="<?=$bm_selectbar?>";
	td=document.getElementById(n);
	dat =td.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	td.innerHTML = '<a style="color:<?=$bm_text_focus?>" ' + dat;
	document.links[n].focus();
}

function losefoc(n) {
	document.getElementById(n).style.backgroundColor="";
	td=document.getElementById(n);
	dat =td.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	td.innerHTML = '<a style="color:<?=$bm_text?>" ' + dat;
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
	var patern=/^[1-<?=$i?>]$/; 
	if (patern.exec(key1)) {
		if(key1 == key2 + 1) 
			onfoc(key1 - 1);
		else{
			losefoc(key2);
			onfoc(key1 - 1)
			key2 = key1 -1;
		}
		location=document.links[key2];
	}
	if(keycode==13)
	{
		location=document.links[key2];
	}
	if(keycode==36)
	{
		location='bm_index.php';
	}
	if(keycode==33 && <?=$offset?>!=0)//表示不是第一页
	{
		location="?type=<?=$type?>&offset=<?=($offset-$pageitem)>0?($offset-$pageitem):0?>";
	}
	if(keycode==34 && <?=$offset+$pageitem?> < <?=$intRowCount?>)
	{
		location="?type=<?=$type?>&offset=<?=$offset+$pageitem?>";
	}
	if(keycode==38)
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0)
			key2=<?=$i-1?>;
		onfoc(key2)
	}
	if(keycode==40)
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2><?=$i-1?>) 
			key2=0;
		onfoc(key2)
	}
}    
document.onkeydown=keyDown

//-->
</script>
</html>
