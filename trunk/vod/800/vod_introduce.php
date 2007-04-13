<?
$typeOffset=$_REQUEST["typeOffset"];
$nameOffset=$_REQUEST["nameOffset"];
$dentry_id=$_REQUEST['dentry_id'];
$dentry_name=$_REQUEST['dentry_name'];
$prog_id=$_REQUEST['prog_id'];
include_once "../include/db_connect.php";
include_once "../include/getplaypath.php";
include_once "color.inc.php";
$sql1="select prog_path,prog_name,director,prog_timespan,prog_acot,prog_describe,publisher,zoom_flag,quality from prog_info where prog_id='".$prog_id."'";
$result1=$db->sql_query($sql1);
$row=$db->sql_fetchrow($result1);
$prog_path		=$row[0];
$prog_name		=$row[1];
$director		=$row[2];
$prog_timespan	=$row[3];
$prog_acot		=$row[4];
$prog_describe	=$row[5];
$picture		=$row[6];//publisher列
$zoom_flag		=$row[7];
$quality		=$row[8];
if(strpos($picture,','))
{
	$pic1=substr($picture,0,strpos($picture,','));
}
else
{
	$pic1=$picture;
}
$haibao='../haibao/'.$pic1;
if($picture=='' || $picture=='null' || !file_exists($haibao))
{
	$haibao="image/none.jpg";
}
$imgsize=GetImageSize($haibao);
if($imgsize[0]>$imgsize[1])
{
	$width=256;
	$height=$width*$imgsize[1]/(float)$imgsize[0];
}
else
{
	$height=380;
	$width=$height*$imgsize[0]/(float)$imgsize[1];
}
if($zoom_flag==0)
{
	$zoom=".nozoom";
}
$quality_arr[0]="一般清晰";
$quality_arr[1]="高清晰";
$quality_arr[2]="中等清晰";
$quality_arr[3]="一般清晰";
$play_path=getPlayPath($prog_path);
$file_ext=substr(strrchr($prog_path,"."),1);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?=$dentry_name?></title>
<link rel="stylesheet" href="style.css" type="text/css">

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}


function begin()
{
	t1 = document.getElementById('ing');
	t1.innerHTML ='<img src="image/vod/waiting.png"><img src="image/ing.gif">'; 
	window.setTimeout('end()',5000);
}
function end()
{
	t1 = document.getElementById('ing');
	t1.innerHTML ='<img src="image/vod/show.png" width="100%">';
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
	}	var key1 = keycode -48;
	if(keycode==70||keycode==13)
	{
	//	begin();
		marquee1.stop();
		location="<?=$play_path?>";
		if(file_ext=='wmv')
		{
	//		new ActiveXObject("wscript.shell").run("wmplayer.exe "+prog_path+" /fullScreen")
		}
		else
		{
		}
	}
	if (keycode==36)
	{
		location ="vod_namelist.php?typeOffset=<?=$typeOffset?>&offset=<?=$nameOffset?>&dentry_id=<?=$dentry_id?>&dentry_name=<?=urlencode($dentry_name)?>";
	//	location="http://x=50?y=10?delay=2?请稍候…….osd";
	}
	if(keycode==40 || keycode==34)
	{
	//	marquee1.start();
	//	marquee1.stop();
	}
}
document.onkeydown=keyDown

//-->
</script>
</head>
<body leftMargin=0 topMargin=0 background="image/vod/vod3_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;">
<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
<tr>
	<td width=20 height=10></td>
	<td width=760><?include "top.php";?></td>
	<td width=20>&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="365" height="25">&nbsp;</td>
		<td width="385">&nbsp;</td>
		<td width="10">&nbsp;</td>
	</tr>
	<tr>
		<td height=40 colspan=3 valign=top><span class=style30w style="color:#c5f300;margin-left:1em"><?=$dentry_name?>：<?=$prog_name?></span></td>
	</tr>
	<tr>
		<td height=470 valign=bottom align=center>
		<table border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td width=4 height=4><img src="image/vod/border_left_top.gif" width=4 height=4></td>
			<td><img src="image/vod/border_top.gif" width="100%" height=4></td>
			<td width=10><img src="image/vod/border_right_top.gif" width=10 height=4></td>
		</tr>
		<tr>
			<td background="image/vod/border_left.gif"></td>
			<td><img src="<?=$haibao?>" width="<?=$width?>" height="<?=$height?>"></td>
			<td background="image/vod/border_right.gif"></td>
		</tr>
		<tr>
			<td height=9><img src="image/vod/border_left_bottom.gif" width=4 height=9></td>
			<td><img src="image/vod/border_bottom.gif" width="100%" height=9></td>
			<td><img src="image/vod/border_right_bottom.gif" width=10 height=9></td>
		</tr>
		</table>
		<table border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td height=55></td>
		</tr>
		</table>
		</td>
		<td valign=top>
		<table width="100%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td height=45></td>
		</tr>
		<tr>
			<td valign=top class="style30w" style="line-height:1.2em">
			<marquee id=marquee1 height=415 width=380 direction="up" loop=2 behavior="scroll" dataformatas="html" scrolldelay="6000" scrollamount="390" border="0">
			<p>
			<?
			echo "片名：".$prog_name."<br>";
			if($directors!="")
				echo "导演：".$director."<br>";
			echo "类型：".$dentry_name."<br>";
			echo "格式：".substr(strrchr($prog_path,"."),1)."<br>";
			echo "影片质量：".$quality_arr[$quality]."<br>";
			if($prog_timespan!=0)
				echo "片长：".$prog_timespan." 分钟<br>";
			if($prog_acot!="")
				echo "主要演员：".$prog_acot."<br>";
			?>
			</p>
			<p style="line-height:1.4em">
			<?=$prog_describe?></p>
			</marquee>
			</td>
		</tr>
		</table>
		</td>
		<td></td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="350" border=0 cellpadding=0 cellspacing=0 class=style22w>
	<tr>
		<td height="33%" align=center></td>
	</tr>
	<tr>
		<td height="33%" align=center style="cursor:hand" onMouseOver="this.style.backgroundColor='<?=$vod_selectbar?>'" onMouseOut="this.style.backgroundColor=''" onclick="window.location=('<?=$play_path?>');">播<br>放</td>
	</tr>
	<tr height="34%">
		<td height="34%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$vod_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('vod_namelist.php?typeOffset=<?=$typeOffset?>&offset=<?=$nameOffset?>&dentry_id=<?=$dentry_id?>&dentry_name=<?=urlencode($dentry_name)?>');">返<br>回</td>
	</tr>
	</table>
	</td>
</tr>
</table>
</body>
</html>