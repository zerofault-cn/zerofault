<?
include_once "color.inc.php";
$train_arr=file("snrx_com_train.txt");
$title=trim($train_arr[0]);
$label=trim($train_arr[1]);
$labels=explode("\t",$label);
$line_count=sizeof($train_arr)-2;
for($i=0;$i<$line_count;$i++)
{
	$line_info[$i]=explode("\t",trim($train_arr[$i+2]));
	$line_info_table[$i]='<table border=1 width=100% cellpadding=5 cellspacing=0 class=style30w rules=1><caption class=style32b style=color:'.$bm_caption.'>'.$title.'</caption>';
	for($j=0,$k=0;$j<sizeof($labels);)
	{
		if($j==sizeof($labels)-1)
		{
			$line_info_table[$i].='<tr><td align=right style=color:'.$bm_item.'>'.trim($labels[$j++]).'</td><td colspan=3 style=color:'.$bm_text.'>'.trim($line_info[$i][$k++]).'</td></tr>';
		}
		else
		{
			$line_info_table[$i].='<tr><td align=right style=color:'.$bm_item.'>'.trim($labels[$j++]).'</td><td style=color:'.$bm_text.'>'.trim($line_info[$i][$k++]).'</td><td align=right  style=color:'.$bm_item.'>'.trim($labels[$j++]).'</td><td style=color:'.$bm_text.'>'.trim($line_info[$i][$k++]).'</td></tr>';
		}
	}
	$line_info_table[$i].='</table>';
}
$pageitem=8;
$line_height=41;

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$title?></title>
<link rel="stylesheet" href="style.css" type="text/css">
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
	document.getElementById(n%pageitem).style.backgroundColor="<?=$bm_selectbar?>";
	document.getElementById(n%pageitem).style.color="<?=$bm_text_focus?>";
	show(n);
}
function losefoc(n)
{
	document.getElementById(n%pageitem).style.backgroundColor="";
	document.getElementById(n%pageitem).style.color="<?=$bm_text?>";
}
function show(n) 
{
	document.getElementById('lineinfo').innerHTML=line_info_table[n];
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
	if(keycode==38 && i>0)
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
	if(keycode==40 && i < line_info.length - 1)
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
		location = "bm_index.php";
	}
}    
document.onkeydown=keyDown

//-->
</script>
</head>

<body leftMargin=0 topMargin=0 background="image/bm/bm4_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="init()">

<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
<tr>
	<td width=20 height=10>&nbsp;</td>
	<td width=760>&nbsp;</td>
	<td width=20>&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table border=0 cellpadding=0 cellspacing=0 width="100%">
	<tr>
		<td width=34 height="80">&nbsp;</td>
		<td width=160>&nbsp;</td>
		<td width=22>&nbsp;</td>
		<td width=514>&nbsp;</td>
		<td width=30>&nbsp;</td>
	</tr>
	<tr>
		<td height=360>&nbsp;</td>
		<td>
		<table border=0 cellpadding=0 cellspacing=0 width="100%" style="color:<?=$bm_text?>">
		<tr>
			<td height=55>&nbsp;</td>
		</tr>
		<!--***********************************线路列表**************************-->
		<?
		for($i=0;$i<$pageitem;$i++)
		{
			?>
		<tr>
			<td id=<?=$i?> height=<?=$line_height?> align=center class=style30b style="color:<?=$bm_text?>"></td>
		</tr>
			<?
		}
		?>
		<!--*************************************************************-->
		</table>
		</td>
		<td>&nbsp;</td>
		<td id=lineinfo>&nbsp;</td>
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
