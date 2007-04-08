<?PHP

$skin_prefix = "";

// ********************************************************************************
// Skin MENU
// ********************************************************************************
$skin_menu = <<<HTML
        <table cellpadding=8 cellspacing=4 border=0>
        <tr>
                <td>
        <a class="nav" href="$PHP_SELF?mod=main">主页</a>
                </td>
                <td>|</td>
                <td>
        <a class="nav" href="$PHP_SELF?mod=addnews&action=addnews">添加新闻</a>
                </td>
                <td>|</td>
                <td>
        <a class="nav" href="$PHP_SELF?mod=editnews&action=list">编辑新闻</a>
                </td>
                <td>|</td>
                <td>
        <a class="nav" href="$PHP_SELF?mod=options&action=options">设置</a>
                </td>
                <td>|</td>
				<td>
        <a class="nav" href="$PHP_SELF?mod=about&action=about">帮助/关于</a>
                </td>
                <td>|</td>
                <td>
        <a class="nav" href="$PHP_SELF?action=logout">登出</a>
                </td>
        </tr>
        </table>
HTML;
// ********************************************************************************
//  Template -> Header
// ********************************************************************************
$skin_header=<<<HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<script type="text/javascript" src="skins/cute.js"></script>
<style type="text/css">
<!--
        SELECT, option, textarea, input {
        BORDER-RIGHT: #808080 1px dotted;
        BORDER-TOP: #808080 1px dotted;
        BORDER-BOTTOM: #808080 1px dotted;
        BORDER-LEFT: #808080 1px dotted;
        COLOR: #000000;
        FONT-SIZE: 11px;
        FONT-FAMILY: Verdana; BACKGROUND-COLOR: #ffffff }

BODY {text-decoration: none; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8pt;}
TD {text-decoration: none; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8pt;}

a:active,a:visited,a:link {color: #446488; text-decoration: none; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8pt;}
a:hover {color: #00004F; text-decoration: none; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8pt;}

a.nav:active, a.nav:visited,  a.nav:link { color: #000000; font-size : 10px; font-weight: bold; font-family: verdana; text-decoration: none;}
a.nav:hover { font-size : 10px; font-weight: bold; color: black; font-family: verdana; text-decoration: underline; }

.header { font-size : 16px; font-weight: bold; color: #808080; font-family: verdana; text-decoration: none; }
.bborder	{ background-color: #FFFFFF; border: 1px #000000 solid; }

BODY, TD, TR {text-decoration: none; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 8pt; cursor: default;}

-->
</style>
	<title>CuteNews汉化版</title>
</head>

<body bgcolor="#A5CBDE">
<center>
<table width="565" border="0" cellspacing="0" cellpadding="2">
  <tr>
	<td class="bborder" bgcolor="#FFFFFF" width="777">
<table border=0 cellpadding=0 cellspacing=0 bgcolor="#ffffff" width="645" height="112">
<tr>
	<td width="62" height="61">
    <p align="center"><img border="0" src="images/{image-name}.gif"  align="right"></p>
	</td>
	<td width="583" height="61" valign="middle">
    &nbsp;{menu}
	</td>
</tr>
<tr>
	<td bgcolor="#000000" width="802" colspan="2" height="1"><img src="images/blank.gif" width=1 height=1></td>
</tr>
<tr><td bgcolor="#FFFFFF" width="802" colspan="2" height="9"><img src="images/blank.gif" width=1 height=5></td></tr>
<tr>
	<td width="802" colspan="2" height="42">
</center>
<!--SELF-->
<table border=0 cellpading=0 cellspacing=0 width="100%" height="100%" >
<td width="100%" height="55%" colspan="2">
<div class=header><i>&nbsp;{header-text}...</i><br />
  &nbsp;</div>
<tr>
<td width="2%" height="26%">
<td width="98%" height="46%">
<!--MAIN area-->
HTML;
// ********************************************************************************
//  Template -> Footer
// ********************************************************************************
$skin_footer=<<<HTML
	 <!--MAIN area-->
	</tr>
	</table>
	<!--/SELF-->
		</td>
	</tr></table></td></tr></table>
    <br /><center>{copyrights}
    </body></html>
HTML;
?>