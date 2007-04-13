<?
$offset=$_REQUEST["offset"];
$bus_focus=$_REQUEST["bus_focus"];
include_once "color.inc.php";
$bus_arr=file("../include/bus_line/cityboat/all.txt");
$title=substr($bus_arr[0],0,strpos($bus_arr[0],'['));
$label=trim($bus_arr[1]);
$labels=explode("\t",$label);
$bus_count=sizeof($bus_arr)-2;
for($i=0;$i<$bus_count;$i++)
{
	$bus_info[]=explode("\t",trim($bus_arr[$i+2]));
}
if(!isset($offset)||$offset=='')
{
	$offset=0;
}
if(!isset($bus_focus) || $bus_focus=='')
{
	$bus_focus=0;
}
$pageitem=9;
$line_height=40;

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$title?></title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body leftMargin=0 topMargin=0 background="image/bm/bus/bus_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="onfoc(<?=$bus_focus?>)">

<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
<tr>
	<td width=20 height=10>&nbsp;</td>
	<td width=760><?include_once "top.php"?></td>
	<td width=20>&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table border=0 cellpadding=0 cellspacing=0 width="100%">
	<tr>
		<td width=22></td>
		<td width=720></td>
		<td width=18></td>
	</tr>
	<tr>
		<td height=64></td>
		<td><span class=style30w><?=$title?></span><span class=style30w style="color:#ffcc00;margin-left:2em">第<?=$offset/$pageitem+1?>页&nbsp;&nbsp;共<?=ceil($bus_count/$pageitem)?>页</span></td>
		<td></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td valign=top>
		<table border=0 cellpadding=0 cellspacing=0 width="100%" class=style30w style="color:<?=$bm_text?>">
		<tr>
			<td><img src="image/bm/bus/label1.gif"></td>
			<td><img src="image/bm/bus/label2.gif"></td>
			<td><img src="image/bm/bus/label3.gif"></td>
			<td><img src="image/bm/bus/label4.gif"></td>
			<td><img src="image/bm/bus/label5.gif"></td>
		</tr>
		<?
		$n=0;
		for($i=0;$i<$pageitem;$i++)
		{
			if(''==$bus_info[$i+$offset][0])
			{
				break;
			}
			?>
		<tr height=<?=$line_height?> id=<?=$i?> style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$vod_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('bus_cd_line.php?bus_offset=<?=$offset?>&bus_focus=<?=$i?>&bus_name=<?=urlencode($bus_info[$i+$offset][0])?>')">
			<td><?=$bus_info[$i+$offset][0]?></td>
			<td><?=substr($bus_info[$i+$offset][1],0,16)?></td>
			<td><?=substr($bus_info[$i+$offset][2],0,16)?></td>
			<td><?=$bus_info[$i+$offset][3]?></td>
			<td><?=$bus_info[$i+$offset][4]?></td>
		</tr>
			<?
			$n++;
		}
		?>
		</table>
		</td>
		<td></td>
	</tr>
	</table>
	<!--************************************** 可视面积 ***********************************************-->
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
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$vod_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('bm_index.php');">返<br>回</td>
	</tr>
	<tr>
		<td height="34%" align=center 
		<?
		if(($offset+$pageitem) < $bus_count)//表示还有下页
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

var bus_name=new Array(<?=$n?>);
<?
for($i=0;$i<$n;$i++)
{
?>
bus_name[<?=$i?>]="<?=$bus_info[$i+$offset][0]?>";
<?
}
?>
function onfoc(n)
{
	document.getElementById(n).style.backgroundColor="#2b4971";
	document.getElementById(n).style.color="#20e3f4";
}
function losefoc(n)
{
	document.getElementById(n).style.backgroundColor="";
	document.getElementById(n).style.color="#ffffff";
}

var key2=<?=$bus_focus?>;
if(document.all)
{
	var ie=1;
	var ns=0;
}
else
{
	var ns=1;
	var ie=0;
}
function keyDown(e)
{
	if (ns)
	{ 
		var keycode=e.which
	} 
	if (ie)
	{ 
		var keycode=event.keyCode; 
	} 
	if (keycode==0)
		keycode=e.keyCode;
	if(keycode==38)
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0)
			key2=<?=$n-1?>;
		onfoc(key2);
	}
	if(keycode==40)
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2><?=$n-1?>) 
			key2=0;
		onfoc(key2);
	}
	if(keycode==13)
	{
		location="bus_cd_line.php?bus_offset=<?=$offset?>&bus_focus="+key2+"&bus_name="+bus_name[key2];
	}
	if(keycode==33 && <?=$offset?>!=0)
	{
		location="?offset=<?=$offset-$pageitem?>";
	}
	if(keycode==34 && <?=$offset+$pageitem?> < <?=$bus_count?>)
	{
		location="?offset=<?=$offset+$pageitem?>";
	}
	if(keycode==36)	
	{
		location = "bm_index.php";
	}
}    
document.onkeydown=keyDown

//-->
</script>
</html>
