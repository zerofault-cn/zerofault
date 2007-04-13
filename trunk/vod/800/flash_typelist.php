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
include_once "color.inc.php";
$line_height=48;
$row=0;
$i=0;
$sql1="select id,type_name from flash_type where del_flag=1 order by id";
$result1=$db->sql_query($sql1);
$rowCount=$db->sql_numrows($result1);
if($rowCount>0)
{
	while($row=$db->sql_fetchrow($result1))
	{
		$type_id[$i]=$row[0];
		$type_name[$i]=$row[1];
		$i++;
	}
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>flash</title>
<link rel="stylesheet" href="style.css" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
var key2=0;

function onfoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<td width=16 height=28><img src="image/selectright.gif"></td><td class=style24b bgcolor="#3366ff"><a style="color:white" ' + dat;
	document.links[n].focus();
}

function losefoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<td width=16 height=28></td><td class=style24b><a style="color:black" ' + dat;
}

function keyDown(e)
{
	var keycode=e.which
	var key1 = keycode -48;
	if(keycode==36)//HOME键
	{
		location="menu_1.php";
	}
	if(keycode==38)//光标左上键
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0) 
			key2=<?=$row-1?>;
		onfoc(key2)
	}
	if(keycode==40)//光标右下键
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2 > <?=$row-1?>)
			key2=0;
		onfoc(key2)
	}
	if(keycode==37||keycode==39)
	{
		losefoc(key2);
		if(key2 < <?=$row/2?>)
			key2=key2 + <?=ceil($row/2)?>;
		else 
			key2=key2 - <?=ceil($row/2)?>;
		if(key2 < 0) 
			key2=0;
		if(key2 > <?=$row-1?>)
			key2=<?=$row-1?>;
		onfoc(key2);
	}
	
}    
document.onkeydown=keyDown

//-->
</script>
</head>

<body leftMargin=0 topMargin=0 background="image/flash/flash_index.jpg" onload="onfoc(0);" style="background-Attachment:fixed;background-repeat:no-repeat;">

<table width="630" border="0" cellpadding="0" cellspacing="0" height="460">
<tr>
	<td width=33 height=15></td>
	<td width=560><?include "top.php";?></td>
	<td width=37 height="15">&nbsp;</td>
</tr>
<tr>
	<td height=430>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table width=560 height=430 border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td width=60 height=90>&nbsp;</td>
		<td width=200>&nbsp;</td>
		<td width=40>&nbsp;</td>
		<td width=200>&nbsp;</td>
		<td width=60>&nbsp;</td>
	</tr>
	<tr>
		<td height=350>&nbsp;</td>
		<td valign=top align=center>
		<table border=0 cellpadding=0 cellspacing=0>
		<?
		
		for($i=0;$i<$row/2;$i++)
		{
			if(!$type_id[$i]||$type_id[$i]=='')
				break;
			?>
			<tr id=<?=$i?>><td height=28 width=30>&nbsp;</td><td align=left class=style24b onMouseOver='this.style.backgroundColor="#3366ff"' onMouseOut='this.style.backgroundColor=""'><a style="color:black" href="flash_title.php?type=<?=$type_id[$i]?>"><?=$type_name[$i]?></a></td></tr>
			<?
		}
		?>
		</table>
		</td>
		<td></td>
		<td valign=top align=center>
		<table border=0 cellpadding=0 cellspacing=0>
		<?
		for($i=ceil($row/2);$i<$row;$i++)
		{
			if(!$type_id[$i]||$type_id[$i]=='')
				break;
			?>
			<tr id=<?=$i?>><td height=28 width=30>&nbsp;</td><td align=left class=style24b onMouseOver='this.style.backgroundColor="#3366ff"' onMouseOut='this.style.backgroundColor=""'><a style="color:black" href="flash_title.php?type=<?=$type_id[$i]?>"><?=$type_name[$i]?></a></td></tr>
			<?
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
	<table width="100%" height="350" border=0 cellpadding=0 cellspacing=0 class=style22w>
	<tr>
		<td height="33%"></td>
	</tr>
	<tr>
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="#0066ff"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('menu_1.php');">返<br>回</td>
	</tr>
	<tr>
		<td height="34%"></td>
	</tr>
	</table>
	</td>
</tr>
</table>
</body>
</html>
