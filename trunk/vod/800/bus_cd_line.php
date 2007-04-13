<?
$bus_offset=$_REQUEST["bus_offset"];
$bus_focus=$_REQUEST["bus_focus"];
$bus_name=$_REQUEST["bus_name"];//线路名称
include_once "../include/toPinyin.php";
include_once "color.inc.php";
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
$pageitem=8;
$line_height=38;
$subsite_height=40;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$title?></title>
<link rel="stylesheet" href="style.css" type="text/css">
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
	document.getElementById(n%pageitem).style.backgroundColor="#2b4971";
	document.getElementById(n%pageitem).style.color="#20e3f4";
	show(n);
}
function losefoc(n)
{
	document.getElementById(n%pageitem).style.backgroundColor="";
	document.getElementById(n%pageitem).style.color="#ffffff";
}
function subsite_onfoc(n) {
	n+=40;
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href"));
	t2.innerHTML = '<table width="100%" height="100%" bgcolor="<?=$music_selectbar?>" border=0 cellpadding=0 cellspacing=0><tr><td valign=center id=singer><a class=style30w style="color:<?=$music_text_focus?>" ' + dat + '</a></td></tr></table>';
	document.links[n-40].focus();
}

function subsite_losefoc(n) {
	n+=40;
	t2 = document.getElementById(n);
	t3 = document.getElementById('singer');
	dat = t3.innerHTML;
	dat = dat.substring(dat.indexOf("href"));
	t2.innerHTML = '<a class=style30w style="color:<?=$music_text?>" ' + dat;
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
		site_info_table+='<td id="'+(i+40)+'" height="<?=$subsite_height?>" onMouseOver=\'this.style.backgroundColor="<?=$music_selectbar?>"\' onMouseOut=\'this.style.backgroundColor=""\'><a class=style30w style="color:<?=$music_text?>" href="?bus_offset=<?=$bus_offset?>&bus_focus=<?=$bus_focus?>&bus_name='+site_info[n][2][i]+'">'+site_info[n][1][i]+'</a></td>';
		if(i % 4==3)
		{
			site_info_table+='</tr>';
		}
	}
	site_info_table+='</table>';
	document.getElementById('site_info').innerHTML=site_info_table;
	subsite_onfoc(key3);
}

function newPage(n) 
{
	if((n % pageitem)==(pageitem-1))//上页
	{		
		for(k = 0; k < pageitem; k++) 
		{
			document.getElementById(k).innerHTML='<td height=<?=$line_height?> class=style30b style="color:<?=$bm_text?>">'+(n-pageitem+1+k+1)+'.'+site_info[n-pageitem+k+1][0]+'</td>';
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
				document.getElementById(k).innerHTML='<td height=<?=$line_height?> class=style30b style="color:<?=$bm_text?>">'+(n+k+1)+'.'+site_info[n + k][0]+'</td>';
			}
		}
	}
	onfoc(n);
}
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
		location = "bus_cd.php?offset=<?=$bus_offset?>&bus_focus=<?=$bus_focus?>";
	//	window.history.go(-1);
	}
}    
document.onkeydown=keyDown

//-->
</script>
</head>

<body leftMargin=0 topMargin=0 background="image/bm/bus/bus_line_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="init()">

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
		<td width=24></td>
		<td width=282></td>
		<td width=13></td>
		<td width=427></td>
		<td width=18></td>
	</tr>
	<tr>
		<td height=70></td>
		<td colspan=3><span class=style30w style="color:#ffcc00;margin-left:1em"><?=$bus_name?><span style="color:white">公交经过的站点：</span></span></td>
		<td></td>
	</tr>
	<tr>
		<td height=84 colspan=5 valign=top>
		<table border=0 cellpadding=0 cellspacing=0 width="100%" class=style32w style="color:#990099">
		<tr>
			<td width=208></td>
			<td width=225><?=$start_time?></td>
			<td><?=$end_time?></td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td height=310>&nbsp;</td>
		<td valign=top>
		<table border=0 cellpadding=0 cellspacing=0 width="100%" style="color:<?=$bm_text?>">
		<!--***********************************线路列表**************************-->
		<?
		for($i=0;$i<$pageitem;$i++)
		{
			?>
		<tr>
			<td id=<?=$i?> height=<?=$line_height?> class=style30b style="color:<?=$bm_text?>"></td>
		</tr>
			<?
		}
		?>
		<!--*************************************************************-->
		</table>
		</td>
		<td></td>
		<td id=site_info></td>
		<td></td>
	</tr>
	</table>
	<!--************************************** 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="180" border=0 cellpadding=0 cellspacing=0 class=style22w>
	<tr>
		<td height="33%" align=center ></td>
	</tr>
	<tr>
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$vod_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('bus_cd.php?offset=<?=$bus_offset?>&bus_focus=<?=$bus_focus?>');">返<br>回</td>
	</tr>
	<tr>
		<td height="34%" align=center >
		</td>
	</tr>
	</table>
	</td>
</tr>
</table>
</body>

</html>
