<?
$fp=fopen("cd_dianhua.txt","r");
$title=fgets($fp,4096);
$label=fgets($fp,4096);
$labels=explode("\t",$label);

$i=0;
while($buffer=fgets($fp,4096))
{
	$lines[$i++]=explode("\t",$buffer);
}
$pageitem=7;
$rowCount=sizeof($lines);
$pageCount=ceil($rowCount/$pageitem);

/*读取一维数组的方法
for($i=0;$i<sizeof($lines);$i++)
{
	while(list($key,$val)=each($lines[$i]))
	{
		echo "$key => $val<br>";
	}
}
*/
//存储机构名称
for($i=0;$i<sizeof($lines);$i++)
{
	$str_line.='"'.$lines[$i][0].'",';
}
if(strlen($str_line)>0)
{
	$str_line=substr($str_line,0,-1);
}
//存储机构名称及其号码
for($i=0;$i<sizeof($lines);$i++)
{
	$str_line_info.='"<table border=0 cellpadding=0 cellspacing=0 class=style32b width=100% height=50><tr><td style=color:#b3ffe1>'.trim($lines[$i][0]).'</td><td align=right style=color:#b3ffe1>'.trim($lines[$i][1]).'</td></tr></table>",';
}
if(strlen($str_line_info)>0)
{
	$str_line_info=substr($str_line_info,0,-1);
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$title?></title>
<link rel="stylesheet" href="style.css" type="text/css">
<script language="JavaScript" type="text/JavaScript">

//var line=new Array(<?=$str_line?>);

var line_info=new Array(<?=$str_line_info?>);

var k=0;
var j=0;
var i=1;
function showPage(n) 
{
	j=0;
	var startline=k;
	var endline=Math.min(n*<?=$pageitem?>,<?=$rowCount?>);
	t1=document.getElementById('info');
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
	if(n < <?=$pageCount?>)
	{
		t3.innerHTML='下页';
	}
	else
	{
		t3.innerHTML='';
	}
		
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
	if(keycode==38||keycode==33)
	{
		i--;
		if(i >= 1)
		{
		//	alert(k);
			k=k-j-<?=$pageitem?>;
		//	alert(k);
			showPage(i);
		}
		else
		{
			i=1;
		}
	}
	if(keycode==40||keycode==34)
	{
		i++;
		if(i <= <?=$pageCount?>)
		{
			showPage(i);
		}
		else
		{
			i=<?=$pageCount?>;
		}
	}
	if(keycode==36)	
	{
		location = "bm_index.php";
	}
}    
document.onkeydown=keyDown

//-->
</script>
</head>

<body leftMargin=0 topMargin=0 background="image/bm/bm3_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="showPage(1)">

<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
<tr>
	<td width=20 height=10>&nbsp;</td>
	<td width=760>&nbsp;</td>
	<td width=20 >&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table border=0 cellpadding=0 cellspacing=0 width="100%">
	<tr>
		<td width=60 height="80">&nbsp;</td>
		<td width=600 colspan=2></td>
		<td width=100></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td id=info valign=top colspan=2></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="300" id=pre valign=top align=center class=style30w>&nbsp;</td>
		<td width="300" id=next valign=top align=center class=style30w>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td>&nbsp;</td>
</tr>

</table>

</body>
</html>
