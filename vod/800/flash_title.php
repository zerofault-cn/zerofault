<?
if(!isset($offset)||$offset=='')
{
	$offset=0;
}
$pageitem=8;
if($offset==0)
{
	$pageitem=$pageitem-2;
}
setcookie("menu_focus",2);
$query_str=$_SERVER["QUERY_STRING"];
if(''!=$query_str)
{
	$query_str='.'.$query_str;
	$query_str=str_replace('=','.',$query_str);
	$query_str=str_replace('&','.',$query_str);
}
$this_file=basename($PHP_SELF);
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
$is_need=1;
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
include "color.inc.php";
$pageitem=9;
$n=0;
if(!isset($offset)||$offset=="")
{
	$offset=0;
}
if(!isset($type)||$type=='')
{
	$type=1;
}
$sql1="select count(*) from flash_source where del_flag=1 and type=".$type;
$sql2="select * from flash_source where del_flag=1 and type=".$type." order by time desc limit ".$offset.",".$pageitem;
$result1=$db->sql_query($sql1);
$intRowCount=$db->sql_fetchfield($result1,0,0);
$result2=$db->sql_query($sql2);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>模板</title>
<link rel="stylesheet" href="style.css" type="text/css">

</head>

<body leftMargin=0 topMargin=0 background="" style="background-Attachment:fixed;background-repeat:no-repeat;">

<table width="630" border="0" cellpadding="0" cellspacing="0" height="460">
<tr>
	<td width=33 height=15>&nbsp;</td>
	<td width=560><?include "top.php";?></td>
	<td width=37>&nbsp;</td>
</tr>
<tr>
	<td height=430>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table border=0 width=560 height=430 cellspacing=0 cellpadding=0>
	<tr>
		<td width=130 height=102></td>
		<td width="334"></td>
		<td width=29></td>
		<td width=67></td>
	</tr>
	<tr>
		<td height=255>
		<table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td valign=bottom align=right class=style24b>第<?=$offset/$pageitem+1?>页&nbsp;<br>共<?=ceil($intRowCount/$pageitem)?>页&nbsp;</td>
		</tr>
		</table>
		</td>
		<td valign=top>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<?
		$i=0;
		while($row=$db->sql_fetchrow($result2))
		{
			$flash_name=$row["flash_name"];
			?>
			<tr id=<?=$i?>>
			<td height=42 class=style24b onMouseOver='this.style.backgroundColor="<?=$daily_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><a style=color:#33CCFF href="flash_player.php?type=<?=$type?>&titleOffset=<?=$offset?>&id=<?=$row["id"]?>">&nbsp;<?=$flash_name?></td>
			</tr>
			<?
			$i++;
		}
		if($i==0)
		{
			?>
			<tr id=<?=$i?>>
			<td height=42 class=style24b><a style=color:white href=#>&nbsp;暂时没有</td>
			</tr>
			<?
			$i++;
		}
		?>
		</table>
		</td>
		<td></td>
		<td>
		<table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td height=8></td>
		</tr>
		<tr>
			<td valign=top class=style24b>
			<?
			if($offset!=0)
			{
				?>
				<a class=style24b style='color:white' href="?type=<?=$type?>&offset=<?=($offset-$pageitem)>0?($offset-$pageitem):0?>">上页</a>
				<?
			}
			?>
			</td>
		</tr>
		<tr>
			<td valign=bottom class=style24b>
			<?
			if(($offset+$pageitem)<$intRowCount)
			{
				?>
				<a class=style24b style='color:white' href="?type=<?=$type?>&offset=<?=$offset+$pageitem?>">下页</a>
				<?
			}
			?>
			</td>
		</tr>
		<tr>
			<td height=37></td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="350" border=0 cellpadding=0 cellspacing=0 class=style22w>
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
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$daily_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('menu_1.php');">返<br>回</td>
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
<tr>
	<td height=15>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
</table>
</body>
<script language="JavaScript" type="text/JavaScript">
var key2=0;
function onfoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<td height=42 class=style24b bgcolor=#ffcc33><a style="color:#6d0a00" ' + dat;
	document.links[n].focus();
}

function losefoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<td height=42 class=style24w><a style="color:white" ' + dat;
}

function keyPress(e)
{
	var keycode=e.which
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
		location="flash_typelist.php";
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
document.onkeydown=keyPress
onfoc(0);
//-->
</script>
</html>
