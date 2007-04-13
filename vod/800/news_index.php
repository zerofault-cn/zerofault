<?
session_start();
$_SESSION['menu_focus']=0;
$query_str=$_SERVER["QUERY_STRING"];
if(''!=$query_str)
{
	$query_str='.'.$query_str;
	$query_str=str_replace('=','.',$query_str);
	$query_str=str_replace('&','.',$query_str);
}
$this_file=basename($_SERVER["PHP_SELF"]);
$html_file='html_cache/'.$this_file.$query_str.'.htm';
$frp=fopen("../include/html_need_update.ini","r+");
while($buffer=fgets($frp,4096))
{
	
	if(substr($buffer,0,strlen($this_file))==$this_file)
	{
		$is_need=substr(trim($buffer),-1);
		break;
	}
	else
	{
		continue;
	}
}
//$is_need=1;
if(isset($is_need) && $is_need==0 && file_exists($html_file))
{
	echo file_get_contents($html_file);
}
else
{
fseek($frp,ftell($frp)-3);
fwrite($frp,"0\r\n");
fclose($frp);
ob_start();
include "../include/db_connect.php";
include "color.inc.php";
$col=2;
$sql1="select * from rss_source where del_flag=1 order by id";
$result1=$db->sql_query($sql1);
$rowCount=$db->sql_numrows($result1);
while($row=$db->sql_fetchrow($result1))
{
	$id[]=$row['id'];
	$rss_source_name[]=$row['rss_source_name'];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>RSS News</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body leftMargin=0 topMargin=0 background="image/news/news_bg.jpg" onload="onfoc(0)" style="background-Attachment:fixed;background-repeat:no-repeat;">

<table width="800" border="0" cellpadding="0" cellspacing="0" height="570">
<tr>
	<td width=20 height=10></td>
	<td width=760><?include "top.php";?></td>
	<td width=20></td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td width=50 height=76>&nbsp;</td>
		<td width=310>&nbsp;</td>
		<td width=20>&nbsp;</td>
		<td width=330>&nbsp;</td>
		<td width=50>&nbsp;</td>
	</tr>
	<tr>
		<td height=350>&nbsp;</td>
		<td colspan=3 valign=top align=center>
		<table width="100%" border=0 cellpadding=0 cellspacing=0>
		<?
		for($i=0;$i<$rowCount;$i++)
		{
			if($i%$col==0)
			{
				echo '<tr>';
			}
			?>
			<td>
			<table width="100%" border=0 cellpadding=0 cellspacing=0>
			<tr id=<?=$i?> onMouseOver='this.style.backgroundColor="<?=$news_selectbar?>"' onMouseOut='this.style.backgroundColor=""'>
				<td height=48 width=20 id="finger<?=$i?>">&nbsp;</td>
				<td class="style32b" id="link<?=$i?>"><a style="color:<?=$news_text?>" href="news_title.php?id=<?=$id[$i]?>" onMouseOver='this.style.color="<?=$news_text_focus?>"' onMouseOut='this.style.color="<?=$news_text?>"'><?=$rss_source_name[$i]?></a></td>
			</tr>
			</table>
			</td>
			<?
			if($i%$col==($col-1))
			{
				echo '</tr>';
			}
		}
		if($rowCount==0)
		{
			?>
			<tr id=0>
				<td height="60" valign="top" class="style32w">暂无内容</td>
			</tr>
			<?
			$i++;
		}
		?>
		</table>
		</td>
		<td>&nbsp;</td>
	</tr>
	</table>
	<!--************************************** 可视面积结束 ******************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="180" border=0 cellpadding=0 cellspacing=0 class=style22w>
	<tr>
		<td height="33%"></td>
	</tr>
	<tr>
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$news_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('menu_1.php');">返<br>回</td>
	</tr>
	<tr>
		<td height="34%"></td>
	</tr>
	</table>
	</td>
</tr>
</table>
</body>
<script language="JavaScript" type="text/JavaScript">
<!--
var key2=0;

function onfoc(n) {
	document.getElementById(n).style.backgroundColor="<?=$news_selectbar?>";
	document.getElementById('finger'+n).innerHTML='<img src="image/news/selectright.gif">';
	td=document.getElementById('link'+n);
	dat =td.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	td.innerHTML = '<a style="color:<?=$news_text_focus?>" ' + dat;
	document.links[n].focus();
}

function losefoc(n) {
	document.getElementById(n).style.backgroundColor='';
	document.getElementById('finger'+n).innerHTML='';
	td=document.getElementById('link'+n);
	dat = td.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	td.innerHTML = '<a style="color:<?=$news_text?>" ' + dat;
}
if(document.all)
{
	var ie=1;
}
else
{
	var ie=0;
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
	var key1 = keycode -48;
	if(keycode==36)//HOME键
	{
		location="menu_1.php";
	}
	if(keycode==37)
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0)
			key2=<?=$rowCount-1?>;
		onfoc(key2)
	}
	if(keycode==39)
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2><?=$rowCount-1?>) 
			key2=0;
		onfoc(key2)
	}
	if(keycode==38)
	{
		losefoc(key2);
		key2-=2;
		if(key2<0)
		{
			if(key2%2==0)
			{
				key2=<?=$rowCount%2==0?$rowCount-2:$rowCount-1?>;
			}
			else
			{
				key2=<?=$rowCount%2==0?$rowCount-1:$rowCount-2?>;
			}
		}
		onfoc(key2);
	}
	if(keycode==40)
	{
		losefoc(key2);
		key2+=2;
		if(key2><?=$rowCount-1?>)
		{
			if(key2%2==0)
			{
				key2=0;
			}
			else
			{
				key2=1;
			}
		}
		onfoc(key2);
	}
}    
document.onkeydown=keyDown

//-->
</script>
</html>
<?
$fwp=fopen($html_file,"w"); 
fwrite($fwp,ob_get_contents());
fclose($fwp);
ob_end_flush();
}
?>