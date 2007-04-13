<?
$type=$_REQUEST['type'];
$offset=$_REQUEST["offset"];
include "color.inc.php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>无标题文档</title>
<link rel="stylesheet" href="style.css" type="text/css">

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
	var key1 = keycode -48;
	var patern=/^[1-9]$/; 
	if (patern.exec(key1)) {
		if(key1 == key2 + 1) 
			onfoc(key1 - 1);
		else{
			losefoc(key2);
			onfoc(key1 - 1)
			key2 = key1 -1;
		}
		location=document.links[key2];
	}
	if(keycode==13)
	{
		location=document.links[key2];
	}

	<?
	if(isset($type0)&&$type0!='')
	{
		echo "if(keycode==36){location='zw_qiyefuwu.php';}";
	}
	else
	{
		echo "if(keycode==36){location='zw_index.php';}";
	}
	?>
	if(keycode==38)//光标左上键
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0) key2=7;
		onfoc(key2)
	}
	if(keycode==40)//光标右下键
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2>7) key2=0;
		onfoc(key2)
	}
}    
document.onkeydown=keyDown
//onfoc(0);
//-->
</script>
</head>


<body leftMargin=0 topMargin=0 background="image/zw/zw3_bg_<?=$type?>.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="onfoc(0)">
<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
<tr>
	<td width=20 height=10>&nbsp;</td>
	<td width=760><?include "top.php";?></td>
	<td width=20>&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="60" height="25">&nbsp;</td>
		<td width="660">&nbsp;</td>
		<td width=40>&nbsp;</td>
	</tr>
	<tr>
		<td height=105>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td valign="top">
		<table border="0" cellpadding="0" cellspacing="0">
		<?
		include "../include/db_connect.php";
		$pageitem=8;
		if(!isset($offset)||$offset=='')
		{
			$offset=0;
		}
		$sql1="select id,title from zw_suining where type='".$type."' order by id desc limit ".$offset.",".$pageitem;
		$result1=$db->sql_query($sql1);
		$i=0;
		while($row=$db->sql_fetchrow($result1))
		{
			$id=$row[0];
			$title=$row[1];
			if(strlen($title)>34)
			{
				$title=substr($title,0,32).'..';
			}
			?>
		<tr>
			<td id=<?=$i?> height="45" class="style30w" onMouseOver='this.style.backgroundColor="<?=$zw_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><a style="color:<?=$zw_text?>" href="zw_news_info.php?id=<?=$id?>&type0=<?=$type0?>&type=<?=$type?>" onMouseOver='this.style.color="<?=$zw_text_focus?>"' onMouseOut='this.style.color="<?=$zw_text?>"'><?=$i+1?>.<?=$title?></a></td>
		</tr>
			<?
			$i++;
		}
		?>
		</table>
		<td>&nbsp;</td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table height="20" border=0 cellpadding=0 cellspacing=0>
	<tr height="33%">
		<td valign=top></td>
	</tr>
	<tr height="33%">
		<td><a class=style22w style='color:white' href="
		<?
		if(isset($type0)&&$type0!='')
		{
			echo "zw_qiyefuwu.php";
		}
		else
		{
			echo "zw_index.php";
		}
		?>">返<br>回</a></td>
	</tr>
	<tr height="34%"></td>
	</tr>
	</table>
	</td>
</tr>

</table>

</body>
</html>
