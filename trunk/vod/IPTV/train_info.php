<?
$line_offset=$_REQUEST["line_offset"];
$line_focus=$_REQUEST["line_focus"];
$line_name=$_REQUEST["line_name"];//线路名称
include_once "../include/toPinyin.php";
$site_file='../include/'.$line_name.'.txt';
if(!file_exists($site_file))
{
	$site_file='../include/bus_line/cityboat/none.txt';
}
$site_arr=file($site_file);
$title=trim($site_arr[0]);
$title_info=explode("\t",$title);
$label=trim($site_arr[1]);
$labels=explode("\t",$label);
$site_count=sizeof($site_arr)-2;
for($i=0;$i<$site_count;$i++)
{
	$site_info[$i]=explode("\t",trim($site_arr[$i+2]));
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
<body id="bm_bus" onload="onfoc(0)">
<div id="topnavi">
<span class="bm_bus_navi"><?=$title_info[0].':'.$title_info[2].'('.$title_info[1].')'?></span>
</div>
<div id="bm_bus_item">
<table border=0 width="100%" cellspacing=0 cellpadding=0>
<tr style="color:#ffcc00">
	<td><?=$labels[0]?></td>
	<td><?=$labels[1]?></td>
	<td><?=$labels[2]?></td>
	<td><?=$labels[3]?></td>
	<td><?=$labels[4]?></td>
	<td><?=$labels[5]?></td>
</tr>
<?
$n=0;
for($i=0;$i<$pageitem;$i++)
{
?>
<tr id=<?=$i?> class="bm_bus_item">
	<td><?=$site_info[$i+$offset][0]?></td>
	<td><?=$site_info[$i+$offset][1]?></td>
	<td><?=$site_info[$i+$offset][2]?></td>
	<td><?=$site_info[$i+$offset][3]?></td>
	<td><?=$site_info[$i+$offset][4]?></td>
	<td><?=$site_info[$i+$offset][5]?></td>
</tr>
<?
	$n++;
}
?>
</table>
</div>
</body>

<script language="JavaScript" type="text/JavaScript">

var pageitem=<?=$pageitem?>;

var site_info=new Array();
<?
for($i=0;$i<$site_count;$i++)
{
?>
site_info[<?=$i?>]=new Array();
<?
	for($j=0;$j<sizeof($labels);$j++)
	{
?>
site_info[<?=$i?>][<?=$j?>]="<?=$site_info[$i][$j]?>";
<?
	}
}
?>
function onfoc(n)
{
	document.getElementById(n%pageitem).style.backgroundImage="url(src_800/image/service/bus/bar1.gif)";
	document.getElementById(n%pageitem).style.color="#ffffff";
}
function losefoc(n)
{
	document.getElementById(n%pageitem).style.backgroundImage="";
	document.getElementById(n%pageitem).style.color="#b6dbf8";
}

function newPage(n) 
{
	if((n % pageitem)==(pageitem-1))//上页
	{		
		for(k = 0; k < pageitem; k++) 
		{
			document.getElementById(k).innerHTML='<td>'+site_info[n-pageitem+k+1][0]+'</td><td>'+site_info[n-pageitem+k+1][1]+'</td><td>'+site_info[n-pageitem+k+1][2]+'</td><td>'+site_info[n-pageitem+k+1][3]+'</td><td>'+site_info[n-pageitem+k+1][4]+'</td><td>'+site_info[n-pageitem+k+1][5]+'</td>';
		}
	}
	else//下页
	{
		for(k = 0; k < pageitem; k++) 
		{
			if((n + k) > (site_info.length - 1)) 
			{
				document.getElementById(k).innerHTML='';
			}
			else 
			{
				document.getElementById(k).innerHTML='<td>'+site_info[n + k][0]+'</td><td>'+site_info[n + k][1]+'</td><td>'+site_info[n + k][2]+'</td><td>'+site_info[n + k][3]+'</td><td>'+site_info[n + k][4]+'</td><td>'+site_info[n + k][5]+'</td>';
			}
		}
	}
	onfoc(n);
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
	if(keycode==38 && key2>0)
	{
		losefoc(key2);
		j=key2%pageitem;
		key2--;
		key3=Math.floor((site_info[key2][1].length)/2);
		if(j == 0) 
		{
			newPage(key2);
		}
		else 
		{
			onfoc(key2);
		}
	}
	if(keycode==40 && key2<site_info.length-1)
	{
		losefoc(key2);
		j=key2%pageitem;
		key2++;
		if(j==pageitem-1)
		{
			newPage(key2);
		}
		else
		{
			onfoc(key2);
		}
	}
	if(keycode==33 && key2-pageitem>=0)
	{
		losefoc(key2);
		key2=pageitem*Math.floor((key2-pageitem)/pageitem);
		newPage(key2);
	}
	if(keycode==34 && key2+pageitem<site_info.length-1)
	{
		losefoc(key2);
		key2=pageitem*Math.floor((key2+pageitem)/pageitem);
		newPage(key2);
	}
	if(keycode==36)	
	{
		location = "train_line.php?offset=<?=$line_offset?>&line_focus=<?=$line_focus?>";
	//	location="train_line.html";
	}
}    
document.onkeydown=keyDown

//-->
</script>
</html>
