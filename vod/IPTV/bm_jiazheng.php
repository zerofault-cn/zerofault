<?
$txt_arr=file("../include/jiazheng.txt","r");
$title=trim($txt_arr[0]);
$line_count=sizeof($txt_arr)-1;
for($i=0;$i<$line_count;$i++)
{
	$line_info[]=explode("\t",trim($txt_arr[$i+1]));
}

$pageitem=4;
$page_count=ceil($line_count/$pageitem);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$title?></title>
<script language="JavaScript" type="text/JavaScript" src="locateCSS.js"></script>
<script language="JavaScript" type="text/JavaScript" src="functions.js"></script>
<script language="JavaScript" type="text/JavaScript">

var line_info=new Array()
<?
for($i=0;$i<$line_count;$i++)
{
	if(trim($line_info[$i][1])=='')
	{
?>
line_info[<?=$i?>]='<table width="100%" border=0 cellpadding=0 cellspacing=0 class="dianhua_item_table"><tr><td align="center" style="color:#FFCC33"><?=trim($line_info[$i][0])?></td></tr></table>';
<?
	}
	elseif(trim($line_info[$i][2])=='')
	{
?>
line_info[<?=$i?>]='<table width="100%" border=0 cellpadding=0 cellspacing=0 class="dianhua_item_table"><tr><td style="color:#b3ffe1"><?=trim($line_info[$i][0])?></td></tr><tr><td style="color:#b3ffe1">&nbsp;&nbsp;&nbsp;<?=trim($line_info[$i][1])?></td></tr></table>';
<?
	}
	else
	{
?>
line_info[<?=$i?>]='<table width="100%" border=0 cellpadding=0 cellspacing=0 class="dianhua_item_table"><tr><td style="color:#b3ffe1"><?=trim($line_info[$i][0])?></td></tr><tr><td style="color:#b3ffe1">&nbsp;&nbsp;&nbsp;<?=trim($line_info[$i][1])?></td></tr><tr><td style="color:#b3ffe1">&nbsp;&nbsp;&nbsp;<?=trim($line_info[$i][2])?></td></tr></table>';
<?
	}
}
?>

var k=0;
var j=0;
var i=1;
function showPage(n) 
{
	j=0;
	var startline=k;
	var endline=Math.min(n*<?=$pageitem?>,<?=$line_count?>);
	t1=document.getElementById('dianhua_item');
	t2=document.getElementById('pre');
	t3=document.getElementById('next');
	t1.innerHTML='';
	for(k = startline; k < endline; k++)
	{
		t1.innerHTML+=line_info[k];
		j++;
	}
	if(startline!=0)
	{
		t2.innerHTML='上页';
	}
	else
	{
		t2.innerHTML='';
	}
	if(n < <?=$page_count?>)
	{
		t3.innerHTML='下页';
	}
	else
	{
		t3.innerHTML='';
	}
		
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
	if(keycode==37 || keycode==38||keycode==33)
	{
		i--;
		if(i >= 1)
		{
			k=k-j-<?=$pageitem?>;
			showPage(i);
		}
		else
		{
			i=1;
		}
	}
	if(keycode==39 || keycode==40||keycode==34)
	{
		i++;
		if(i <= <?=$page_count?>)
		{
			showPage(i);
		}
		else
		{
			i=<?=$page_count?>;
		}
	}
	if(keycode==36)	
	{
		location = "service_index.html";
	}
}
document.onkeydown=keyDown

//-->
</script>
</head>

<body id="dianhua" onload="showPage(1)">
<div id="topnavi">
<span class="topnavi">常用信息：<?=$title?></span>
</div>
<div id="dianhua_item">
</div>
<div id="dianhua_navi">
<table border=0 cellpadding=0 cellspacing=0 width="100%">
<tr>
	<td width="50%" valign=top align=center><span id=pre class=navi></span></td>
	<td width="50%" valign=top align=center><span id=next class=navi></span></td>
</tr>
</table>
</div>
</body>
</html>
