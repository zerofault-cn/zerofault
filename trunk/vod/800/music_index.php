<?
session_start();
$_SESSION['menu_focus']=3;
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
include_once "color.inc.php";
include_once "../include/db_connect.php";
$sql4="select count(*) from singer_info";//歌手数
$sql5="select count(*) from prog_info where prog_kindsec=1026 and del_flag=1";//有效的歌曲
$sql7="select count(*) from song_info where del_flag=1";

$result4=$db->sql_query($sql4);
$singer_count=$db->sql_fetchfield(0,0,$result4);

$result5=$db->sql_query($sql5);
$music_count=$db->sql_fetchfield(0,0,$result5);

$result7=$db->sql_query($sql7);
$mp3_count=$db->sql_fetchfield(0,0,$result7);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>音乐</title>
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
	var patern=/^[1-6]$/; 
	if (patern.exec(key1)) 
	{
		document.links[key1-1].focus();
		location = document.links[key1 - 1];
	}
	if(keycode==36)//HOME键
	{
		location="menu_1.php";
	}
	if(keycode==38)
	{
		key2--;
		if(key2<0)
		{
			key2=5;
		}
		if(navigator.platform=='Win32')
		{
			document.links[key2].focus();
		}
	}
	if(keycode==40)
	{
		key2++;
		if(key2>5)
		{
			key2=0;
		}
		if(navigator.platform=='Win32')
		{
			document.links[key2].focus();
		}
	}
	if(keycode==55)
	{
		location="music_singer_listall.php";
	}
	if(keycode==59 || keycode==186)
	{
		document.getElementById('blink').innerHTML='<br>正在打开,请稍候...';
		location="music_singer_listall.php";
	}
	
}    
document.onkeydown=keyDown
//-->
</script>
</head>

<body leftMargin=0 topMargin=0 background="image/music/music1_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="setkey2(0);document.links[0].focus()">

<table width="800" height="590" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td width=20 height=10>&nbsp;</td>
	<td width=760><?include "top.php";?></td>
	<td width=20 >&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--*********************************可视面积:嵌入内容*************************************************-->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width=40 height=15>&nbsp;</td>
		<td width=310>&nbsp;</td>
		<td width=20>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td></td>
		<td height=84 align=right valign=top><span class=style30w style="color:#c5f300;margin-right:0em">选择类别&gt;&gt;</span></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td></td>
		<td valign=top class=style32w style="color:#bafd76;line-height:140%">
		<br>
		服务器资源<br>
		歌手数:<?=$singer_count?><br>
		MTV数:<?=$music_count?><br>
		MP3数:<?=$mp3_count?><br>
		<br>
		<span class=style30w style="color:#bafd76;cursor:hand" id=blink onclick="window.location=('music_singer_listall.php');">按【蓝键】<br>快速选择MP3歌手</span>
		<br>
		<br>
		</td>
		<td>&nbsp;</td>
		<td valign=top>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td height=20>&nbsp;</td>
		</tr>
		<?
		for($i=1;$i<7;$i++)
		{
			?>
		<tr>
			<td height=53><a href="music_typelist.php?type_label=<?=$i?>" onblur="MM_swapImgRestore()" onfocus="MM_swapImage('Image<?=$i?>','','image/music/music<?=$i?>_2.gif',1);setkey2(<?=($i-1)?>)" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image<?=$i?>','','image/music/music<?=$i?>_2.gif',1)"><img src="image/music/music<?=$i?>_1.gif" name="Image<?=$i?>" border="0"></a></td>
		</tr>
			<?
		}
		?>
		</table>
		</td>
		
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="180" border=0 cellpadding=0 cellspacing=0 class=style22w>
	<tr>
		<td height="33%">&nbsp;</td>
	</tr>
	<tr>
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$music_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.location=('menu_1.php');">返<br>回</td>
	</tr>
	<tr>
		<td height="34%"></td>
	</tr>
	</table>
	</td>
</tr>
</table>
</body>
</html>
<?
$fwp=fopen($html_file,"w"); 
fwrite($fwp,ob_get_contents());
fclose($fwp);
ob_end_flush();
}
?>