<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="{S_CONTENT_DIRECTION}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="Expires" content="-1">
{META}
{NAV_LINKS}
<title>{SITENAME} :: {PAGE_TITLE}</title>
<link rel="stylesheet" href="templates/cnphpbbice/{T_HEAD_STYLESHEET}" type="text/css">
<!-- Start add - Birthday MOD -->
{GREETING_POPUP}
<!-- End add - Birthday MOD -->
<!-- BEGIN switch_enable_pm_popup -->
<script language="Javascript" type="text/javascript">
<!--
	if ( {PRIVATE_MESSAGE_NEW_FLAG} )
	{
		window.open('{U_PRIVATEMSGS_POPUP}', '_phpbbprivmsg', 'HEIGHT=225,resizable=yes,WIDTH=400');;
	}
//-->
</script>
<!-- END switch_enable_pm_popup -->
<script language="javascript" type="text/javascript">
<!--
function setImageDimensions(gotImage)
{
  if(gotImage.width > 570) {
	gotImage.width = 570;
  }
}
function changeImageDimensions(gotImage, type)
{
  if(gotImage.width > 570 && type == 'out') {
	gotImage.width = 570;
    return;
  }
  if(type == 'over') {
	gotImage.removeAttribute('width');
  }
}

var PreloadFlag = false;
var expDays = 90;
var exp = new Date();
var tmp = '';
var tmp_counter = 0;
var tmp_open = 0;

exp.setTime(exp.getTime() + (expDays*24*60*60*1000));

function SetCookie(name, value)
{
	var argv = SetCookie.arguments;
	var argc = SetCookie.arguments.length;
	var expires = (argc > 2) ? argv[2] : null;
	var path = (argc > 3) ? argv[3] : null;
	var domain = (argc > 4) ? argv[4] : null;
	var secure = (argc > 5) ? argv[5] : false;
	document.cookie = name + "=" + escape(value) +
		((expires == null) ? "" : ("; expires=" + expires.toGMTString())) +
		((path == null) ? "" : ("; path=" + path)) +
		((domain == null) ? "" : ("; domain=" + domain)) +
		((secure == true) ? "; secure" : "");
}

function getCookieVal(offset)
{
	var endstr = document.cookie.indexOf(";",offset);
	if (endstr == -1)
	{
		endstr = document.cookie.length;
	}
	return unescape(document.cookie.substring(offset, endstr));
}

function GetCookie(name)
{
	var arg = name + "=";
	var alen = arg.length;
	var clen = document.cookie.length;
	var i = 0;
	while (i < clen)
	{
		var j = i + alen;
		if (document.cookie.substring(i, j) == arg)
			return getCookieVal(j);
		i = document.cookie.indexOf(" ", i) + 1;
		if (i == 0)
			break;
	}
	return null;
}

function ShowHide(id1, id2, id3)
{
	var res = expMenu(id1);
	if (id2 != '') expMenu(id2);
	if (id3 != '') SetCookie(id3, res, exp);
}

function expMenu(id)
{
	var itm = null;
	if (document.getElementById)
	{
		itm = document.getElementById(id);
	}
	else if (document.all)
	{
		itm = document.all[id];
	}
	else if (document.layers)
	{
		itm = document.layers[id];
	}
	if (!itm)
	{
		// do nothing
	}
	else if (itm.style)
	{
		if (itm.style.display == "none")
		{
			itm.style.display = "";
			return 1;
		}
		else
		{
			itm.style.display = "none";
			return 2;
		}
	}
	else
	{
		itm.visibility = "show";
		return 1;
	}
}

//-->
</script>
<script language="Javascript" type="text/javascript"> 
<!-- 
function setCheckboxes(theForm, elementName, isChecked)
{
    var chkboxes = document.forms[theForm].elements[elementName];
    var count = chkboxes.length;

    if (count) 
	{
        for (var i = 0; i < count; i++) 
		{
            chkboxes[i].checked = isChecked;
    	}
    } 
	else 
	{
    	chkboxes.checked = isChecked;
    } 

    return true;
} 
//--> 
</script>
</head>
<body bgcolor="{T_BODY_BGCOLOR}" text="{T_BODY_TEXT}" link="{T_BODY_LINK}" vlink="{T_BODY_VLINK}">

<a name="top"></a>

<table width="100%" border="0" cellspacing="2" cellpadding="0" class="bodyline" align="center">
            <tr >
              <td class="topnav"><table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                  <td><a href="{U_INDEX}"><img src="templates/cnphpbbice/images/sitelogo.jpg" border="0" alt="{L_INDEX}" /></a></td>
                  <td align="center" width="100%" valign="middle"><span class="maintitle">{SITENAME}</span><br /><span class="gen">{SITE_DESCRIPTION}<br />{L_DISABLE_BOARD_ACCESS}</span></td>
                </tr>
              </table>              
                <table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#DADCE5">
                  <tr>
                    <td ><span class="mainmenu"><a href="{U_LOGIN_LOGOUT}" class="mainmenu">{L_LOGIN_LOGOUT}</a>&nbsp;|&nbsp;<a href="{U_PRIVATEMSGS}" class="mainmenu">{PRIVATE_MESSAGE_INFO}</a>&nbsp;|&nbsp;<a href="{U_PROFILE}" class="mainmenu">{L_PROFILE}</a></span></td>
                    <td  align="right"><span class="mainmenu"><a href="{U_FAQ}" class="mainmenu">{L_FAQ}</a>&nbsp;|&nbsp;<a href="{U_SEARCH}" class="mainmenu">{L_SEARCH}</a>&nbsp;|&nbsp;<a href="{U_MEMBERLIST}" class="mainmenu">{L_MEMBERLIST}</a>&nbsp;|&nbsp;<a href="{U_GROUP_CP}" class="mainmenu">{L_USERGROUPS}</a>&nbsp;|&nbsp;<a href="{U_FAV}" class="mainmenu">{L_FAV}</a>
                        <!-- BEGIN switch_user_logged_out -->
				&nbsp;|&nbsp;<a href="{U_REGISTER}" class="mainmenu">{L_REGISTER}</a>
                        <!-- END switch_user_logged_out -->
					</span></td>
                  </tr>
                  <tr bgcolor="#C1C3D2">
                    <td height="2" colspan="2"></td>
                  </tr>
                </table></td>
            </tr>
</table>

<table width="100%" height="4"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td></td>
              </tr>
</table>

<table width="100%" cellspacing="0" cellpadding="15" border="0" align="center"> 
	<tr> 
		<td class="bodyline">
