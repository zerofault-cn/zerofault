<?
include_once "../800/color.inc.php";
$train_arr=file("../include/airline_cd_out.txt");
$title=trim($train_arr[0]);
$label=trim($train_arr[1]);
$labels=explode("\t",$label);
$line_count=sizeof($train_arr)-2;
for($i=0;$i<$line_count;$i++)
{
	$line_info[$i]=explode("\t",trim($train_arr[$i+2]));
	$line_info_table[$i]='<table border=1 width=100% cellpadding=5 cellspacing=0 class=style30w rules=1><caption class=style32b style=color:'.$bm_caption.'>&nbsp;</caption>';
	for($j=0,$k=0;$j<sizeof($labels);)
	{
//		if($j==0)
		{
			$line_info_table[$i].='<tr><td align=right style=color:'.$bm_item.'>'.trim($labels[$j++]).':</td><td colspan=3 style=color:'.$bm_text.'>'.trim($line_info[$i][$k++]).'</td></tr>';
		}
//		else
		{
//			$line_info_table[$i].='<tr><td align=right style=color:'.$bm_item.'>'.trim($labels[$j++]).'</td><td style=color:'.$bm_text.'>'.trim($line_info[$i][$k++]).'</td><td align=right  style=color:'.$bm_item.'>'.trim($labels[$j++]).'</td><td style=color:'.$bm_text.'>'.trim($line_info[$i][$k++]).'</td></tr>';
		}
	}
	$line_info_table[$i].='</table>';
}
$pageitem=9;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$title?></title>
<script language="JavaScript" type="text/JavaScript" src="locateCSS.js"></script>
<script language="JavaScript" type="text/JavaScript" src="functions.js"></script>
<script language="JavaScript" type="text/JavaScript">

var pageitem=<?=$pageitem?>;

var line_info=new Array(<?=$line_count?>);
var line_info_table=new Array(<?=$line_count?>);
<?
for($i=0;$i<$line_count;$i++)
{
?>
line_info[<?=$i?>]="<?=$line_info[$i][0]?>";
line_info_table[<?=$i?>]="<?=$line_info_table[$i]?>";
<?
}
?>

var i=0;
function init()
{
	for(k=0;k < pageitem; k++)
	{
		document.getElementById(k).innerHTML=line_info[k];
	}
	onfoc(i);
}
function onfoc(n)
{
	document.getElementById(n%pageitem).style.backgroundImage="url(src_"+src_width+"/image/service/huoche/bar1.gif)";
	document.getElementById(n%pageitem).style.color="#ffffff";
	show(n);
}
function losefoc(n)
{
	document.getElementById(n%pageitem).style.backgroundImage="";
	document.getElementById(n%pageitem).style.color="#b6dbf8";
}
function show(n) 
{
	document.getElementById('bm_huoche_lineinfo').innerHTML=line_info_table[n];
}

function newPage(n) 
{
	if((n % pageitem)==(pageitem-1))
	{		
		for(k = 0; k < pageitem; k++) 
		{
			document.getElementById(k).innerHTML=line_info[n-pageitem+k+1];
		}
	}
	else 
	{
		for(k = 0; k < pageitem; k++) 
		{
			if((n + k) > (line_info.length - 1)) 
			{
				document.getElementById(k).innerHTML='';
			}
			else 
			{
				document.getElementById(k).innerHTML=line_info[n + k];
			}
		}
	}
	onfoc(n);
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
	if((keycode==37 || keycode==38) && i>0)
	{
		losefoc(i);
		j=i%pageitem;
		i--;
		if(j == 0) 
		{
			newPage(i);
		}
		else 
		{
			onfoc(i);
		}
	}
	if((keycode==39 || keycode==40) && i < line_info.length - 1)
	{
		losefoc(i);
		j=i%pageitem;
		i++;
		if(j==pageitem-1)
		{
			newPage(i);
		}
		else
		{
			onfoc(i);
		}
	}
	if(keycode==33 && i-pageitem>=0)
	{
		losefoc(i);
		i=pageitem*Math.floor((i-pageitem)/pageitem);
		newPage(i);
	}
	if(keycode==34 && i+pageitem<line_info.length-1)
	{
		losefoc(i);	
		i=pageitem*Math.floor((i+pageitem)/pageitem);
		newPage(i);
	}
	if(keycode==36)	
	{
		location = "service_index.html";
	}
}    
document.onkeydown=keyDown

//-->
</script>
<style>
div#caption
{
	margin-left:58px;
	margin-top:87px;
	width:162px;
}
</style>
</head>

<body id="bm_airline" onload="init()">
<div id="topnavi">
<span class="topnavi">常用信息：<?=$title?></span>
</div>
<div id="caption">
<div style="position:relative;color:#ffcc00" align=center>航班号</div>
</div>
<div id="bm_huoche_line">
<table border="0" width="100%" cellpadding=0 cellspacing=0>
<tr>
	<td id=0 class="bm_huoche_line"></td>
</tr>
<tr>
	<td id=1 class="bm_huoche_line"></td>
</tr>
<tr>
	<td id=2 class="bm_huoche_line"></td>
</tr>
<tr>
	<td id=3 class="bm_huoche_line"></td>

</tr>
<tr>
	<td id=4 class="bm_huoche_line"></td>
</tr>
<tr>
	<td id=5 class="bm_huoche_line"></td>
</tr>
<tr>
	<td id=6 class="bm_huoche_line"></td>
</tr>
<tr>
	<td id=7 class="bm_huoche_line"></td>
</tr>

<tr>
	<td id=8 class="bm_huoche_line"></td>
</tr>
</table>
</div>
<div id="bm_huoche_lineinfo">
</div>
</body>
</html>