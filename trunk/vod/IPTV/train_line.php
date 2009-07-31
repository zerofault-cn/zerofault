<?
$offset=$_REQUEST["offset"];
$line_focus=$_REQUEST["line_focus"];
$line_arr=file("../include/train_cd.txt");
$title=trim($line_arr[0]);
$label=trim($line_arr[1]);
$labels=explode("\t",$label);
$line_count=sizeof($line_arr)-2;
for($i=0;$i<$line_count;$i++)
{
	$line_info[]=explode("\t",trim($line_arr[$i+2]));
}
if(!isset($offset)||$offset=='')
{
	$offset=0;
}
if(!isset($line_focus) || $line_focus=='')
{
	$line_focus=0;
}
$pageitem=9;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$title?></title>
<script language="JavaScript" type="text/JavaScript" src="locateCSS.js"></script>
<script language="JavaScript" type="text/JavaScript" src="functions.js"></script>

</head>
<body id="bm_bus" onload="onfoc(<?=$line_focus?>)">
<div id="topnavi">
<span class="bm_bus_navi"><?=$title?></span><span class="navi" style="margin-left:4em">第<?=$offset/$pageitem+1?>页&nbsp;&nbsp;共<?=ceil($line_count/$pageitem)?>页</span>
</div>
<div id="bm_bus_item">
<table border=0 width="100%" cellspacing=0 cellpadding=0>
<tr style="color:#ffcc00">
	<td><?=$labels[0]?></td>
	<td><?=$labels[1]?></td>
	<td><?=$labels[2]?></td>
	<td><?=$labels[6]?></td>
	<td><?=$labels[7]?></td>
</tr>
<?
$n=0;
for($i=0;$i<$pageitem;$i++)
{
	if(''==$line_info[$i+$offset][0])
	{
		break;
	}
?>
<tr id=<?=$i?> class="bm_bus_item">
	<td><?=$line_info[$i+$offset][0]?></td>
	<td><?=$line_info[$i+$offset][1]?></td>
	<td><?=$line_info[$i+$offset][2]?></td>
	<td><?=$line_info[$i+$offset][6]?></td>
	<td><?=$line_info[$i+$offset][7]?></td>
</tr>
<?
	$n++;
}
?>
</table>
</div>
</body>

<script language="JavaScript" type="text/JavaScript">

var line_name=new Array();//存储线路名称，传到二级页
<?
for($i=0;$i<$n;$i++)
{
?>
line_name[<?=$i?>]="<?=str_replace('/','-',$line_info[$i+$offset][0])?>";
<?
}
?>
function onfoc(n)
{
	document.getElementById(n).style.backgroundImage="url(src_800/image/service/bus/bar1.gif)";
	document.getElementById(n).style.color="#ffffff";
}
function losefoc(n)
{
	document.getElementById(n).style.backgroundImage="";
	document.getElementById(n).style.color="#b6dbf8";
}

var key2=<?=$line_focus?>;
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
		location="train_info.php?line_offset=<?=$offset?>&line_focus="+key2+"&line_name="+line_name[key2];
	}
	if(keycode==33 && <?=$offset?>!=0)
	{
		location="?offset=<?=$offset-$pageitem?>";
	}
	if(keycode==34 && <?=$offset+$pageitem?> < <?=$line_count?>)
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
