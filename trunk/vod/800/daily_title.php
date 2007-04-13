<?
$type=$_REQUEST["type"];
$offset=$_REQUEST["offset"];
include_once "../include/db_connect.php";
include_once "color.inc.php";
$pageitem=9;
if(!isset($offset)||$offset=="")
{
	$offset=0;
}
if(!isset($type)||$type=='')
{
	$type=1;
}
$sql1="select count(*) from daily_source where del_flag=1 and type=".$type;
$sql2="select * from daily_source where del_flag=1 and type=".$type." order by id desc limit ".$offset.",".$pageitem;
$result1=$db->sql_query($sql1);
$intRowCount=$db->sql_fetchfield(0,0,$result1);
$result2=$db->sql_query($sql2);
$sql3="select type_name from daily_type where id=".$type;
$result3=$db->sql_query($sql3);
$type_name=$db->sql_fetchfield(0,0,$result3);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>天天在线_标题</title>
<link rel="stylesheet" href="style.css" type="text/css">

</head>

<body leftMargin=0 topMargin=0 background="image/daily/daily2_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="onfoc(0)">

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
	<table border=0 width="100%" cellspacing=0 cellpadding=0>
	<tr>
		<td width=20 height=87>&nbsp;</td>
		<td width=720>&nbsp;</td>
		<td width=20>&nbsp;</td>
	</tr>
	<tr>
		<td height=40 colspan=3 valign=top>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width=100>&nbsp;</td>
			<td valign=top class=style32w><?=$type_name?></td>
			<td valign=top align=right><span class=style30w style="color:#ffcc00;margin-right:0em">第<?=$offset/$pageitem+1?>页&nbsp;&nbsp;共<?=ceil($intRowCount/$pageitem)?>页</span></td>
			<td width=130>&nbsp;</td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td valign=top>
		<table border="0" cellpadding="0" cellspacing="0">
		<?
		$i=0;
		while($row=$db->sql_fetchrow($result2))
		{
			$id=$row["id"];
			$title=$row["title"];
			if(strlen($title)>34)
			{
				$title=substr($title,0,32).'..';
			}
			?>
		<tr>
			<td id=<?=$i?> height=45 class="style32b" onMouseOver='this.style.backgroundColor="<?=$daily_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><a style="letter-spacing:2px;color:<?=$daily_text?>" href="daily_info.php?type=<?=$type?>&id=<?=$id?>" onMouseOver='this.style.color="<?=$daily_text_focus?>"' onMouseOut='this.style.color="<?=$daily_text?>"'><span style="margin-left:2em"><?=$i+1?>.<?=$title?></span></td>
		</tr>
			<?
			$i++;
		}
		if($i==0)
		{
			?>
		<tr>
			<td id=<?=$i?> height=42 class=style32b><a style="color:white" href=#>&nbsp;暂时没有新闻</td>
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
			style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$daily_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('?type=<?=$type?>&offset=<?=($offset-$pageitem)>0?($offset-$pageitem):0?>');">上<br>页</a>
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
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$daily_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('daily_index.php');">返<br>回</td>
	</tr>
	<tr height="34%">
		<td height="34%" align=center 
		<?
		if(($offset+$pageitem) < $intRowCount)//表示还有下页
		{
			?>
			style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$daily_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('?type=<?=$type?>&offset=<?=$offset+$pageitem?>');">下<br>页</a>
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
	document.getElementById(n).style.backgroundColor="<?=$daily_selectbar?>";
	td=document.getElementById(n);
	dat =td.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	td.innerHTML = '<a style="letter-spacing:2px;color:<?=$daily_text_focus?>" ' + dat;
	document.links[n].focus();
}

function losefoc(n) {
	document.getElementById(n).style.backgroundColor="";
	td=document.getElementById(n);
	dat =td.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	td.innerHTML = '<a style="letter-spacing:2px;color:<?=$daily_text?>" ' + dat;
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
	var key1 = keycode -48
	var patern=/^[1-<?=$i?>]$/; 
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
		location = document.links[key2];
	}
		 
	if(keycode==13)
	{
		location = document.links[key2];
	}
	if(keycode==36)
	{
		location="daily_index.php";
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
