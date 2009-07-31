<?
$bus_offset=$_REQUEST["bus_offset"];
$bus_focus=$_REQUEST["bus_focus"];
$bus_name=$_REQUEST["bus_name"];//线路名称
include_once "../include/toPinyin.php";
$site_file='../include/bus_line/cityboat/'.words(urldecode($bus_name)).'.txt';
if(!file_exists($site_file))
{
	$site_file='../include/bus_line/cityboat/none.txt';
}
$site_arr=file($site_file);
$tmp_site_info=trim($site_arr[0]);
$start_time=substr($tmp_site_info,strpos($tmp_site_info,':')-1,4);//开车时间
$tmp_site_info=substr($tmp_site_info,strpos($tmp_site_info,':')+2);
$end_time=substr($tmp_site_info,strpos($tmp_site_info,':')-2,5);//收车时间
$site_count=sizeof($site_arr)-2;
for($i=0;$i<$site_count;$i++)
{
	$site_info[$i]=explode("\t",trim($site_arr[$i+2]));
	$site_info[$i][1]=explode("　",$site_info[$i][1]);
}
$pageitem=9;

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$bus_name?></title>
<script language="JavaScript" type="text/JavaScript" src="locateCSS.js"></script>
<script language="JavaScript" type="text/JavaScript" src="functions.js"></script>
<script language="JavaScript" type="text/JavaScript">

var pageitem=<?=$pageitem?>;

var site_info=new Array(<?=$site_count?>);
<?
for($i=0;$i<$site_count;$i++)
{
?>
site_info[<?=$i?>]=new Array(3);
site_info[<?=$i?>][0]="<?=trim($site_info[$i][0])?>";
site_info[<?=$i?>][1]=new Array(<?=sizeof($site_info[$i][1])?>);
site_info[<?=$i?>][2]=new Array(<?=sizeof($site_info[$i][1])?>);
<?
	for($j=0;$j<sizeof($site_info[$i][1]);$j++)
	{
		if(''==$site_info[$i][1][0])
		{
?>
site_info[<?=$i?>][1][<?=$j?>]="没有换乘列表";
site_info[<?=$i?>][2][<?=$j?>]="";
<?
		}
		else
		{
?>
site_info[<?=$i?>][1][<?=$j?>]="<?=$site_info[$i][1][$j]?>";
site_info[<?=$i?>][2][<?=$j?>]="<?=urlencode($site_info[$i][1][$j])?>";
<?
		}
	}
}
?>


var key2=0;
var key3=Math.floor((site_info[key2][1].length)/2);
function init()
{
	for(k=0; k < Math.min(site_info.length,pageitem); k++)
	{
		document.getElementById(k).innerHTML=''+(k+1)+'.'+site_info[k][0];
	}
	onfoc(key2);
}
function onfoc(n)
{
	document.getElementById(n%pageitem).style.backgroundImage="url(src_"+src_width+"/image/service/bus/bar2.gif)";
	document.getElementById(n%pageitem).style.color="#ffffff";
	show(n);
}
function losefoc(n)
{
	document.getElementById(n%pageitem).style.backgroundImage="";
	document.getElementById(n%pageitem).style.color="#b6dbf8";
}
function subsite_onfoc(n) {
	n+=40;
	t2 = document.getElementById(n);
	t2.style.backgroundImage="url(src_"+src_width+"/image/service/bus/bar3.gif)";
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href"));
	t2.innerHTML = '<a style="color:#ffffff" ' + dat;
	document.links[n-40].focus();
}

function subsite_losefoc(n) {
	n+=40;
	t2 = document.getElementById(n);
	t2.style.backgroundImage="";
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href"));
	t2.innerHTML = '<a style="color:#b6dbf8" ' + dat;
}
function show(n) 
{
	site_info_table='<table border=0  cellpadding=0 cellspacing=0 width="100%">';
	for(i = 0; i < site_info[n][1].length;i++)
	{
		if(i % 4==0)
		{
			site_info_table+='<tr>';
		}
		site_info_table+='<td id="'+(i+40)+'" class="bm_bus_subsite"><a style="color:#b6dbf8" href="#">'+site_info[n][1][i]+'</a></td>';
		if(i % 4==3)
		{
			site_info_table+='</tr>';
		}
	}
	site_info_table+='</table>';
	document.getElementById('bm_bus_site_info').innerHTML=site_info_table;
	subsite_onfoc(key3);
}

function newPage(n) 
{
	if((n % pageitem)==(pageitem-1))//上页
	{		
		for(k = 0; k < pageitem; k++) 
		{
			document.getElementById(k).innerHTML='<td height=38 class=style30b style="color:">'+(n-pageitem+1+k+1)+'.'+site_info[n-pageitem+k+1][0]+'</td>';
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
				document.getElementById(k).innerHTML='<td height=38 class=style30b style="color:">'+(n+k+1)+'.'+site_info[n + k][0]+'</td>';
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
	if(keycode==37)
	{
		subsite_losefoc(key3);
		key3--;
		if(key3<0)
		{
			key3=site_info[key2][1].length-1;
		}
		subsite_onfoc(key3)
	}
	if(keycode==39)
	{
		subsite_losefoc(key3);
		key3++;
		if(key3>site_info[key2][1].length-1) 
		{
			key3=0;
		}
		subsite_onfoc(key3)
	}
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
		key3=Math.floor((site_info[key2][1].length)/2);
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
		location="bm_bus.php?offset=<?=$bus_offset?>&focus=<?=$bus_focus?>";
	//	location = "bm_bus.html";
	}
}    
document.onkeydown=keyDown

//-->
</script>
</head>

<body id="bm_bus_site" onload="init()">
<div id="topnavi">
<span class="bm_bus_navi"><?=$bus_name?>公交经过的站点：
</div>

<div id="start_time">
<?=$start_time?>
</div>
<div id="end_time">
<?=$end_time?>
</div>
<div id="bm_bus_site">
<table border=0 cellpadding=0 cellspacing=0 width="100%">
<?
for($i=0;$i<$pageitem;$i++)
{
?>
<tr>
	<td id="<?=$i?>" class="bm_bus_site_item"></td>
</tr>
<?
	}
?>
</table>
</div>
<div id="bm_bus_site_info">
</div>
</body>
</html>