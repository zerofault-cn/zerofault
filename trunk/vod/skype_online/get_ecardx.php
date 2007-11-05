<?
if( (!isset($s) || ''==$s) && (!isset($epn) || ''==$epn))
{
	echo '非法引用！';
	exit;
}
include_once "mysql_connect.php";
if(''!=$epn)
{
	$sql1="select * from user_info where user_account='".$epn."'";
}
elseif(''!=$s)
{
	$sql1="select * from user_info where user_skype='".$s."'";
}
$result1=mysql_query($sql1);
$user_account	=mysql_result($result1,0,'user_account');
$user_realname	=mysql_result($result1,0,'user_realname');
$user_address	=mysql_result($result1,0,'user_address');
$user_company	=mysql_result($result1,0,'user_company');
$user_duty		=mysql_result($result1,0,'user_duty');
$user_email		=mysql_result($result1,0,'user_email');
$user_phone		=mysql_result($result1,0,'user_phone');
$user_mobile	=mysql_result($result1,0,'user_mobile');
$user_fax		=mysql_result($result1,0,'user_fax');
$user_qq		=mysql_result($result1,0,'user_qq');
$user_skype		=mysql_result($result1,0,'user_skype');
$user_website	=mysql_result($result1,0,'user_website');
$user_update	=mysql_result($result1,0,'user_update');
$user_avatar	=mysql_result($result1,0,'user_avatar');
$user_signature	=mysql_result($result1,0,'user_signature');
$user_status	=mysql_result($result1,0,'user_status');
if(''==$user_avatar)
{
	$user_avatar='no_avatar.gif';
}
if(''==$user_status)
{
	$user_status='UNKNOWN';
}

//重定义头像大小
$max_size=112;
if(!file_exists('avatars/'.$user_avatar))
{
	$user_avatar='no_avatar.gif';
}
$avatar_size=GetImageSize("avatars/".$user_avatar);
$avatar_width=$avatar_size[0];
$avatar_height=$avatar_size[1];
if($avatar_width/(float)$avatar_height >=1)
{
//	if($avatar_width>$max_size)
	{
		$avatar_width=$max_size;
		$avatar_height=$max_size*$avatar_size[1]/(float)$avatar_size[0];
	}
}
else
{
//	if($avatar_height>$max_size)
	{
		$avatar_height=$max_size;
		$avatar_width=$max_size*$avatar_size[0]/(float)$avatar_size[1];
	}
}
	
?>
<html>
<head>
<title><?=$user_realname?>的eCard</title>
<meta http-equiv=content-type content="text/html; charset=gb2312">
<style>
body
{
	color:#222;
	font-size:13px;
}
td
{
	color:#222;
	font-size:12px;
	line-height:130%;
}
.company
{
	font-family:楷体_GB2312;
	font-size:14pt;
	font-weight:bold;
	border-bottom:1px red solid;
	
}
.name
{
	font-family:仿宋_GB2312;
	font-size:14pt;
	font-weight:bold;
}
.duty
{
	font-size:16px;
}
.var
{
	font-family:Courier narrow;
	margin-left: 20px;
}
.sign
{
	margin-left:2em;
}
hr
{
	COLOR: #a5bede; 
	BACKGROUND-COLOR: transparent;
}
hr.dotted
{
	COLOR: #a5bede; 
	BACKGROUND-COLOR: transparent;
	border-style:dotted;
}

</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
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
//-->
</script>
</head>
<body background="image/ecardx_bg.gif" leftmargin=0 topmargin=0 onLoad="MM_preloadImages('image/ecardx_08_over.gif','image/ecardx_10_over.gif')">

<center>
<table width="387" height=232 border=0 cellpadding=0 cellspacing=0>
<tr>
	<td width=8 height=20></td>
	<td></td>
	<td width=8></td>
</tr>
<tr>
	<td></td>
	<td valign=top><!-- card正文 -->
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td width=138 align=center valign=top>
		<table width="100%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td width=138 height=122 background="image/ecardx_avatar_bg.gif" align=center><img src="avatars/<?=$user_avatar?>" width="<?=$avatar_width?>" height="<?=$avatar_height?>" border=0></td>
		</tr>
		</table>
		</td>
		<td valign=top align=center>
		<table width="90%" border=0 cellpadding=0 cellspacing=0><!-- 右边联系方式 -->
		<tr>
			<td class=company height=45 align=center valign=bottom><?=$user_company?></td>
		</tr>
		<tr>
			<td class=name height=60 align="center" valign=bottom><?=$user_realname?></td>
		</tr>
		</table>
		</td>
	</tr>
	</table>
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td height=20></td>
	</tr>
	<tr>
		<td align=center>
		<a href="javascript:void(0)" onclick="window.open('send_im.php?user_skype=<?=$user_skype?>','','width=400,height=300,toolbar=no,status=no,scrollbars=no,resizable=no');" onMouseOver="MM_swapImage('btn1','','image/ecardx_08_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="image/ecardx_08.gif" name="btn1" border=0 id="btn1"></a>
		<a href="callto:<?=$user_skype?>" onMouseOver="MM_swapImage('btn2','','image/ecardx_10_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="image/ecardx_10.gif" name="btn2" border=0 id="btn2"></a>
		&nbsp;&nbsp;&nbsp;&nbsp;<a href="get_ecard.php?epn=<?=$user_account?>" title="点击打开eCard" target=_blank><img src="get_ecard_pic.php?s=<?=$user_skype?>" border=0></a>
		</td>
	</tr>
	</table>
	</td>
	<td></td>
</tr>
<tr>
	<td></td>
	<td valign=bottom colspan=2><img src="image/ecardx_footer.gif"></td>
</tr>
<tr>
	<td colspan=3 height=5></td>
</tr>
</table>
</center>
</body>
</html>