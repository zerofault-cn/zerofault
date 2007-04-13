<?
session_start();
if(!isset($_SESSION['goldsoft_user'])||$_SESSION['goldsoft_user']=="")
{
	header("location:index.php");
	exit;
}
//include "vote_form.php";
if(!isset($_SESSION['account'])||$_SESSION['account']=="")
{
	include_once "autologin.php";
}
if(!$_SESSION['menu_focus']||$_SESSION['menu_focus']=='')
{
	$focus=0;
}
else
{
	$focus=$_SESSION['menu_focus'];
}

$notice_file="../notice.txt";
if(file_exists($notice_file)&&$fp=fopen($notice_file,"r"))
{
	$notice=str_replace("\n","<br>",fread($fp,filesize($notice_file)));
	fclose($fp);
}

$links[]='news_index.php';
$links[]='daily_index.php';
$links[]='vod_typelist.php';
$links[]='music_index.php';
$links[]='epg_station.php';
$links[]='bm_index.php';
$links[]='zw_index.php';
if($_SESSION['os']=='Windows')
{
	$links[]='http://www.10jqka.com.cn/ex_info/jhq/hexin.php';
}
else
{
	$links[]='http://www.10jqka.com.cn/ex_info/jhq/LoadHexin.php';
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>主菜单</title>
<link rel="stylesheet" href="style.css" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="functions.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--

function begin()
{
	t1 = document.getElementById('top');
	t1.innerHTML ='<img src=image/ing.gif height=24>'; 
	window.setTimeout('end()',5000);
}
function end()
{
	t1 = document.getElementById('top');
	t1.innerHTML = ''; 
}
function show(img)
{
	t1=document.getElementById('show');
	t1.innerHTML="<img src='image/menu/"+img+".gif'>";
}
function unshow()
{
	t1=document.getElementById('show');
	t1.innerHTML="";
}

var key2=0;
function setkey2(i)
{
	key2=i;
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
	var patern=/^[1-8]$/; 
	if (patern.exec(key1)) {
		document.links[key1-1].focus();
		location = document.links[key1-1];
	}
	if(keycode==38)
	{
		key2--;
		if(key2<0)
		{
			key2=7;
		}
		if(navigator.platform=='Win32')
		{
			document.links[key2].focus();
		}
	}
	if(keycode==40)
	{
		key2++;
		if(key2>7)
		{
			key2=0;
		}
		if(navigator.platform=='Win32')
		{
			document.links[key2].focus();
		}
	}
	if(keycode==57)//9
	{
		location="../skype_online/ebox_skype_index.php";
	}
	if(keycode==48)//0
	{
		location="http://192.168.0.100:8088/";
	}
	if(keycode==59 || keycode==186)//蓝键
	{
		location="ebox_intro/01.htm";
	}
	if(keycode==219)//红键
	{
		location="vote_form.php";
	}
}
document.onkeydown=keyDown

//-->
</script>

</head>

<body leftMargin=0 topMargin=0 background="image/menu/menu_bg.jpg" onload="document.links[<?=$focus?>].focus(),startclock()" style="background-Attachment:fixed;background-repeat:no-repeat;">
<DIV style='left:10px;position:absolute;top:10px;'>
<script>
if(navigator.platform=='Win32')
{
	document.write('<span class="style24w" style="font-family:黑体;cursor:hand" onMouseOver=\'this.style.backgroundColor="#8b4ac8"\' onMouseOut=\'this.style.backgroundColor=""\' onclick="window.location=(\'pc_logout.php\')">用户注销</span>');
}
</script>
</div>
<table width="800" height="590" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td width=20 height=13></td>
	<td width=760></td>
	<td width=20></td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--***************************** 可视面积:嵌入内容 ******************************************-->
	<table border=0 width="100%" cellspacing=0 cellpadding=0>
	<tr>
		<td width=391></td>
		<td width=369></td>
	</tr>
	<tr>
		<td valign=top>
		<table border=0 width="100%" height="100%" cellspacing=0 cellpadding=0>
		<tr>
			<td height=61 colspan=3>&nbsp;</td>
		</tr>
		<tr>
			<td width=74>&nbsp;</td>
			<td width=177><span id="realtime"></span></td>
			<td width=140>&nbsp;</td>
		</tr>
		<tr>
			<td colspan=3 height=12></td>
		</tr>
		<tr>
			<td valign=top height=200 colspan=3>
			<table border=0 width="100%" height="100%"cellspacing=0 cellpadding=0>
			<tr>
				<td width=80>&nbsp;</td>
				<td width=400 valign=top class=style30w style="color:#ffff00;line-height:1.4">
				<marquee DATAFORMATAS="HTML" height="170" loop="-1" direction="up" scrolldelay="0" scrollamount="1"><p style="text-indent:2em"><?=$notice?></p></marquee>				
				</td>
			</tr>
			</table>
			</td>
		</tr>
		</table>
		</td>
		<td valign=top>
		<table border=0 width="100%" cellspacing=0 cellpadding=0>
		<?
		for($i=0;$i<sizeof($links);$i++)
		{
			?>
		<tr>
			<td><a href="<?=$links[$i]?>" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image<?=($i+1)?>','','image/menu/menu<?=($i+1)?>_2.gif',1);setkey2(<?=$i?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image<?=($i+1)?>','','image/menu/menu<?=($i+1)?>_2.gif',1)"><img src='image/menu/menu<?=($i+1)?>_1.gif' name="Image<?=($i+1)?>" border="0"></a></td>
		</tr>
			<?
		}
		?>
		</table>
		</td>
	</tr>
	</table>
	<!--************************************* 可视面积结束 ******************************************-->
	</td>
	<td>&nbsp;</td>
</tr>
</table>
</body>
</html>
