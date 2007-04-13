<?
$id=$_REQUEST['id'];
$offset=$_REQUEST["offset"];
include "../include/db_connect.php";
include "color.inc.php";
include "../include/rss_parser.php";
$pageitem=9;
if($offset=='')
{
	$offset=0;
}
$sql1="select rss_source_url,prefetch from rss_source where id='".$id."'";
$result1=mysql_query($sql1);
$rss_source_url=mysql_result($result1,0,0);
$prefetch=mysql_result($result1,0,1);
if($prefetch==1)//判断是否已预取
{
	$local_rss_tmp='../rss_tmp/'.eregi_replace("([?=&]+)","",basename($rss_source_url));
	if(file_exists($local_rss_tmp))
	{
		$rss_source_url=$local_rss_tmp;//取本地暂存的xml文件
	}
}
readXML($rss_source_url);
$intRowCount=sizeof($newsArray);
for($i=$offset,$j=0;$i<min($pageitem+$offset,sizeof($newsArray));$i++,$j++) 
{
	$tmp_newsArray[$j]=$newsArray[$i]['title'];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>模板</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body leftMargin=0 topMargin=0 background="image/news/news_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="onfoc(0)">
<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
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
		<td width=30 height=23>&nbsp;</td>
		<td width=350>&nbsp;</td>
		<td width=350>&nbsp;</td>
		<td width=30>&nbsp;</td>
	</tr>
	<tr>
		<td height=39>&nbsp;</td>
		<td colspan=2 class=style32w style="color:#c5f300"><?=$channelArray['title']?></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan=4 height=12>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td valign=top colspan=2 class=style30b style="line-height:1.5em">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<?
		$i=0;
		while($itemTitle=$tmp_newsArray[$i])
		{
			if(strpos($itemTitle,'<')==0 && strpos($itemTitle,'>')>0)
			{
				$itemTitle=substr($itemTitle,strpos($itemTitle,'>')+1);
			}
			if(strlen($itemTitle)>36)
			{
				$itemTitle=substr($itemTitle,0,36).' ';
			}
			?>
		<tr>
			<td id="<?=$i?>" height=46 class=style32b onMouseOver='this.style.backgroundColor="<?=$news_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><a style='color:<?=$news_text?>' href="news_info.php?id=<?=$id?>&offset=<?=$offset?>&i=<?=$i?>" onMouseOver='this.style.color="<?=$news_text_focus?>"' onMouseOut='this.style.color="<?=$news_text?>"'>&nbsp;<?=$offset+$i+1?>.&nbsp;<?=$itemTitle?></a></td>
		</tr>
			<?
			$i++;
		}
		?>
		</table>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr valign=bottom>
		<td height=50>&nbsp;</td>
		<td align=center class=style30w>
		<?
		if($offset!=0)
		{
			echo "上页";
		}
		?></td>
		<td align=center class=style30w>
		<?
		if(($offset+$pageitem) < $intRowCount)
		{
			echo "下页";
		}
		?></td>
		<td></td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="350" border=0 cellpadding=0 cellspacing=0 class=style22w>
	<tr>
		<td height="33%" align=center 
		<?
		if($offset!=0)//表示不是第一页
		{
			?>
			style="cursor:hand" onMouseOver="this.style.backgroundColor='<?=$news_selectbar?>'" onMouseOut="this.style.backgroundColor=''" onclick="window.location=('?id=<?=$id?>&offset=<?=min(0,$offset-$pageitem)?>');">上<br>页</a>
			<?
		}
		else
		{
			echo '>';
		}
		?>
		</td>
	</tr>
	<tr>
		<td height="33%" align=center style="cursor:hand" onMouseOver="this.style.backgroundColor='<?=$news_selectbar?>'" onMouseOut="this.style.backgroundColor=''" onclick="window.location=('news_index.php');">返<br>回</td>
	</tr>
	<tr>
		<td height="34%" align=center 
		<?
		if(($offset+$pageitem) < $intRowCount)//表示还有下页
		{
			?>
			style="cursor:hand" onMouseOver="this.style.backgroundColor='<?=$news_selectbar?>'" onMouseOut="this.style.backgroundColor=''" onclick="window.location=('?id=<?=$id?>&offset=<?=$offset+$pageitem?>');">下<br>页</a>
			<?
		}
		else
		{
			echo '>';
		}
		?>
		</td>
	</tr>
	</table>
	</td>
</tr>
</table>
</body>

<script language="JavaScript" type="text/JavaScript">
var key2=0;
function onfoc(n) {
	document.getElementById(n).style.backgroundColor="<?=$news_selectbar?>";
	td=document.getElementById(n);
	dat =td.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	td.innerHTML = '<a style="color:<?=$news_text_focus?>" ' + dat;
	document.links[n].focus();
}

function losefoc(n) {
	document.getElementById(n).style.backgroundColor="";
	td=document.getElementById(n);
	dat =td.innerHTML;
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
	var key1 = keycode -48
　	var patern=/^[1-<?=$i?>]$/; 
	if (patern.exec(key1)) 
	{
		if(key1 == key2 + 1) 
			onfoc(key1 - 1);
		else{
			losefoc(key2);
			onfoc(key1 - 1)
			key2 = key1 -1;
		}
		
		location = document.links[key1 - 1];
	}
	if(keycode==36)
	{
		location="news_index.php";
	}
	if(keycode==33 && <?=$offset?>!=0)
	{
		location="?id=<?=$id?>&offset=<?=min(0,$offset-$pageitem)?>";
	}
	if(keycode==34 && <?=$offset+$pageitem?> < <?=$intRowCount?>)
	{
		location="?id=<?=$id?>&offset=<?=$offset+$pageitem?>";
	}
	if(keycode==38)
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0) 
			key2=<?=$i-1?>;
		onfoc(key2)
	}
	if(keycode==40)
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2><?=$i-1?>) 
			key2=0;
		onfoc(key2)
	}
}   
document.onkeydown=keyDown

//-->
</script>
</html>
