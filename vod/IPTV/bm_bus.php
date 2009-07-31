<?
$offset=$_REQUEST["offset"];
$bus_focus=$_REQUEST["bus_focus"];
include_once "../800/color.inc.php";
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
if(!isset($focus) || $focus=='')
{
	$focus=0;
}
$pageitem=9;
$line_height=40;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>成都公交线路</title>
<script language="JavaScript" type="text/JavaScript" src="locateCSS.js"></script><script language="JavaScript" type="text/JavaScript" src="functions.js"></script>
</head>

<body id="bm_bus" onload="onfoc(<?=$focus?>)">
<div id="topnavi">
<span class="bm_bus_navi">成都公交线路</span><span class="navi" style="margin-left:8em">第<?=$offset/$pageitem+1?>页&nbsp;&nbsp;共<?=ceil($bus_count/$pageitem)?>页</span>
</div>

<div id="bm_bus_item">
<table border=0 width="100%" cellspacing=0 cellpadding=0>
<tr>
	<td><img src="src_800/image/service/bus/label1.gif" class="bm_bus_label"></td>
	<td><img src="src_800/image/service/bus/label2.gif" class="bm_bus_label"></td>
	<td><img src="src_800/image/service/bus/label3.gif" class="bm_bus_label"></td>
	<td><img src="src_800/image/service/bus/label4.gif" class="bm_bus_label"></td>
	<td><img src="src_800/image/service/bus/label5.gif" class="bm_bus_label"></td>
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
<tr id=<?=$i?> class="bm_bus_item" style="font-size:30px;">
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
</div>
</body>

<script language="JavaScript" type="text/JavaScript">
pageitem=<?=$pageitem?>;
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
	document.getElementById(n).style.backgroundImage="url(src_"+src_width+"/image/service/bus/bar1.gif)";
	document.getElementById(n).style.color="#ffffff";
//	show(n);
}
function losefoc(n)
{
	document.getElementById(n).style.backgroundImage="";
	document.getElementById(n).style.color="#b6dbf8";
}

var key2=0;
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
	if (keycode==0)
		keycode=e.keyCode;
	if(keycode==37 || keycode==38)
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0)
			key2=<?=$n-1?>;
		onfoc(key2);
	}
	if(keycode==39 || keycode==40)
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2><?=$n-1?>) 
			key2=0;
		onfoc(key2);
	}
	if(keycode==13)
	{
		location="bm_bus_site.php?bus_offset=<?=$offset?>&bus_focus="+key2+"&bus_name="+bus_name[key2];
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
		location = "service_index.html";
	}
}    
document.onkeydown=keyDown

//-->
</script>
</html>
