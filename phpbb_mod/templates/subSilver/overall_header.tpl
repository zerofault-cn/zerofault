<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="{S_CONTENT_DIRECTION}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
<meta http-equiv="Content-Style-Type" content="text/css">
{META}
{NAV_LINKS}
<title>{SITENAME} :: {PAGE_TITLE}</title>
<!-- link rel="stylesheet" href="templates/subSilver/{T_HEAD_STYLESHEET}" type="text/css" -->
<style type="text/css">
<!--
/*
  The original subSilver Theme for phpBB version 2+
  Created by subBlue design
  http://www.subBlue.com

  NOTE: These CSS definitions are stored within the main page body so that you can use the phpBB2
  theme administration centre. When you have finalised your style you could cut the final CSS code
  and place it in an external file, deleting this section to save bandwidth.
*/

/* General page style. The scroll bar colours only visible in IE5.5+ */
body { 
	background-color: {T_BODY_BGCOLOR};
	background-image: url(templates/subSilver/images/{T_BODY_BACKGROUND});
	scrollbar-face-color: {T_TR_COLOR2};
	scrollbar-highlight-color: {T_TD_COLOR2};
	scrollbar-shadow-color: {T_TR_COLOR2};
	scrollbar-3dlight-color: {T_TR_COLOR3};
	scrollbar-arrow-color:  {T_BODY_LINK};
	scrollbar-track-color: {T_TR_COLOR1};
	scrollbar-darkshadow-color: {T_TH_COLOR1};
}

/* General font families for common tags */
font,th,td,p { font-family: {T_FONTFACE1} }
a:link,a:active,a:visited { color : {T_BODY_LINK}; }
a:hover		{ text-decoration: underline; color : {T_BODY_HLINK}; }
hr	{ height: 0px; border: solid {T_TR_COLOR3} 0px; border-top-width: 1px;}

/* This is the border line & background colour round the entire page */
.bodyline	{ background-color: {T_TD_COLOR2}; border: 1px {T_TH_COLOR1} solid; }

/* This is the outline round the main forum tables */
.forumline	{ background-color: {T_TD_COLOR2}; border: 2px {T_TH_COLOR2} solid; }

/* Main table cell colours and backgrounds */
td.row1	{ background-color: {T_TR_COLOR1}; }
td.row2	{ background-color: {T_TR_COLOR2}; }
td.row3	{ background-color: {T_TR_COLOR3}; }

/*
  This is for the table cell above the Topics, Post & Last posts on the index.php page
  By default this is the fading out gradiated silver background.
  However, you could replace this with a bitmap specific for each forum
*/
td.rowpic {
		background-color: {T_TD_COLOR2};
		background-image: url(templates/subSilver/images/{T_TH_CLASS3});
		background-repeat: repeat-y;
}

/* Header cells - the blue and silver gradient backgrounds */
th	{
	color: {T_FONTCOLOR3}; font-size: {T_FONTSIZE2}px; font-weight : bold; 
	background-color: {T_BODY_LINK}; height: 25px;
	background-image: url(templates/subSilver/images/{T_TH_CLASS2});
}

td.cat,td.catHead,td.catSides,td.catLeft,td.catRight,td.catBottom {
			background-image: url(templates/subSilver/images/{T_TH_CLASS1});
			background-color:{T_TR_COLOR3}; border: {T_TH_COLOR3}; border-style: solid; height: 28px;
}

/*
  Setting additional nice inner borders for the main table cells.
  The names indicate which sides the border will be on.
  Don't worry if you don't understand this, just ignore it :-)
*/
td.cat,td.catHead,td.catBottom {
	height: 29px;
	border-width: 0px 0px 0px 0px;
}
th.thHead,th.thSides,th.thTop,th.thLeft,th.thRight,th.thBottom,th.thCornerL,th.thCornerR {
	font-weight: bold; border: {T_TD_COLOR2}; border-style: solid; height: 28px;
}
td.row3Right,td.spaceRow {
	background-color: {T_TR_COLOR3}; border: {T_TH_COLOR3}; border-style: solid;
}

th.thHead,td.catHead { font-size: {T_FONTSIZE3}px; border-width: 1px 1px 0px 1px; }
th.thSides,td.catSides,td.spaceRow	 { border-width: 0px 1px 0px 1px; }
th.thRight,td.catRight,td.row3Right	 { border-width: 0px 1px 0px 0px; }
th.thLeft,td.catLeft	  { border-width: 0px 0px 0px 1px; }
th.thBottom,td.catBottom  { border-width: 0px 1px 1px 1px; }
th.thTop	 { border-width: 1px 0px 0px 0px; }
th.thCornerL { border-width: 1px 0px 0px 1px; }
th.thCornerR { border-width: 1px 1px 0px 0px; }

/* The largest text used in the index page title and toptic title etc. */
.maintitle	{
	font-weight: bold; font-size: 22px; font-family: "{T_FONTFACE2}",{T_FONTFACE1};
	text-decoration: none; line-height : 120%; color : {T_BODY_TEXT};
}

/* General text */
.gen { font-size : {T_FONTSIZE3}px; }
.genmed { font-size : {T_FONTSIZE2}px; }
.gensmall { font-size : {T_FONTSIZE1}px; }
.gen,.genmed,.gensmall { color : {T_BODY_TEXT}; }
a.gen,a.genmed,a.gensmall { color: {T_BODY_LINK}; text-decoration: none; }
a.gen:hover,a.genmed:hover,a.gensmall:hover	{ color: {T_BODY_HLINK}; text-decoration: underline; }

/* The register, login, search etc links at the top of the page */
.mainmenu		{ font-size : {T_FONTSIZE2}px; color : {T_BODY_TEXT} }
a.mainmenu		{ text-decoration: none; color : {T_BODY_LINK};  }
a.mainmenu:hover{ text-decoration: underline; color : {T_BODY_HLINK}; }

/* Forum category titles */
.cattitle		{ font-weight: bold; font-size: {T_FONTSIZE3}px ; letter-spacing: 1px; color : {T_BODY_LINK}}
a.cattitle		{ text-decoration: none; color : {T_BODY_LINK}; }
a.cattitle:hover{ text-decoration: underline; }

/* Forum title: Text and link to the forums used in: index.php */
.forumlink		{ font-weight: bold; font-size: {T_FONTSIZE3}px; color : {T_BODY_LINK}; }
a.forumlink 	{ text-decoration: none; color : {T_BODY_LINK}; }
a.forumlink:hover{ text-decoration: underline; color : {T_BODY_HLINK}; }

/* Used for the navigation text, (Page 1,2,3 etc) and the navigation bar when in a forum */
.nav			{ font-weight: bold; font-size: {T_FONTSIZE2}px; color : {T_BODY_TEXT};}
a.nav			{ text-decoration: none; color : {T_BODY_LINK}; }
a.nav:hover		{ text-decoration: underline; }

/* titles for the topics: could specify viewed link colour too */
.topictitle,h1,h2	{ font-weight: bold; font-size: {T_FONTSIZE2}px; color : {T_BODY_TEXT}; }
a.topictitle:link   { text-decoration: none; color : {T_BODY_LINK}; }
a.topictitle:visited { text-decoration: none; color : {T_BODY_VLINK}; }
a.topictitle:hover	{ text-decoration: underline; color : {T_BODY_HLINK}; }

/* Name of poster in viewmsg.php and viewtopic.php and other places */
.name			{ font-size : {T_FONTSIZE2}px; color : {T_BODY_TEXT};}

/* Location, number of posts, post date etc */
.postdetails		{ font-size : {T_FONTSIZE1}px; color : {T_BODY_TEXT}; }

/* The content of the posts (body of text) */
.postbody { font-size : {T_FONTSIZE3}px; line-height: 18px}
a.postlink:link	{ text-decoration: none; color : {T_BODY_LINK} }
a.postlink:visited { text-decoration: none; color : {T_BODY_VLINK}; }
a.postlink:hover { text-decoration: underline; color : {T_BODY_HLINK}}

/* Quote & Code blocks */
.code { 
	font-family: {T_FONTFACE3}; font-size: {T_FONTSIZE2}px; color: {T_FONTCOLOR2};
	background-color: {T_TD_COLOR1}; border: {T_TR_COLOR3}; border-style: solid;
	border-left-width: 1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px
}

.quote {
	font-family: {T_FONTFACE1}; font-size: {T_FONTSIZE2}px; color: {T_FONTCOLOR1}; line-height: 125%;
	background-color: {T_TD_COLOR1}; border: {T_TR_COLOR3}; border-style: solid;
	border-left-width: 1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px
}

/* Copyright and bottom info */
.copyright		{ font-size: {T_FONTSIZE1}px; font-family: {T_FONTFACE1}; color: {T_FONTCOLOR1}; letter-spacing: -1px;}
a.copyright		{ color: {T_FONTCOLOR1}; text-decoration: none;}
a.copyright:hover { color: {T_BODY_TEXT}; text-decoration: underline;}

/* Form elements */
input,textarea, select {
	color : {T_BODY_TEXT};
	font: normal {T_FONTSIZE2}px {T_FONTFACE1};
	border-color : {T_BODY_TEXT};
}

/* The text input fields background colour */
input.post, textarea.post, select {
	background-color : {T_TD_COLOR2};
}

input { text-indent : 2px; }

/* The buttons used for bbCode styling in message post */
input.button {
	background-color : {T_TR_COLOR1};
	color : {T_BODY_TEXT};
	font-size: {T_FONTSIZE2}px; font-family: {T_FONTFACE1};
}

/* The main submit button option */
input.mainoption {
	background-color : {T_TD_COLOR1};
	font-weight : bold;
}

/* None-bold submit button */
input.liteoption {
	background-color : {T_TD_COLOR1};
	font-weight : normal;
}

/* This is the line in the posting page which shows the rollover
  help line. This is actually a text box, but if set to be the same
  colour as the background no one will know ;)
*/
.helpline { background-color: {T_TR_COLOR2}; border-style: none; }
/* xHTML compliant, define border in CSS */
img, .forumline img	{
border: none;
}
#skypeTransparentDrp
{
width:135px !important;
clear:both !important;
clear:both !important;
line-height:0 !important;
text-indent:0 !important;
margin:0 !important;
padding:0 !important;
border:none !important
}
#skypeTransparentDrp img
{
border:none !important;
margin:0 !important;
padding:0 !important
}
#skypeTransparentDrp div#skypeDropdown-transparent
{
margin:0 !important;
padding:0 !important;
clear:both !important;
text-indent:0 !important;
line-height:0 !important;
border:none !important
}
#skypeDropdown-transparent a
{
display:block !important;
margin:0 !important;
padding:0 !important;
text-indent:0!important;
line-height:0 !important;
border:none !important
}
#skypeTransparentDrp > div#skypeDropdown-transparent
{
position: absolute;
}
/* Import the fancy styles for IE only (NS4.x doesn't use the @import function) */
@import url("templates/subSilver/formIE.css"); 
-->
</style>
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
<!-- Start add - Birthday MOD -->
{GREETING_POPUP}
<!-- End add - Birthday MOD -->
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="Expires" content="-1">
<script type="text/javascript">
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


var timerTransparent = false;
var tail='';
function skpBtnOvr(where) 
{
	skypeTransparentDrpDown(tail)
	var myId = where.id;
	var myImage = document.getElementById(myId);
	var idArray = myId.split("-");
	myImage.src = "skype_func/"+idArray[1]+"_over.gif"
}
function skpBtnOut(where) 
{
	skypeTransparentDrpUp()
	var myId = where.id;
	var myImage = document.getElementById(myId);
	var idArray = myId.split("-");
	myImage.src="skype_func/"+idArray[1]+".gif"
}
function skypeTransparentDrpDown()
{
	if(timerTransparent)
	{
		clearTimeout(timerTransparent);
		timerTransparent = false;
	}
	var skypeTransparentDrpCall = document.getElementById('skypeTransparentDrpCall-'+tail);
	var skypeTransparentDrpArrow = document.getElementById('skypeTransparentDrpArrow-'+tail);
	var skypeDropdowntransparent = document.getElementById('skypeDropdown-transparent-'+tail);
	skypeDropdowntransparent.style.display = "block";
	skypeTransparentDrpCall.src ="skype_func/call_over.gif";
	skypeTransparentDrpArrow.src ="skype_func/up.gif";
}
function skypeTransparentDrpUp()
{
	timerTransparent = setTimeout("skypeTransparentDrpClose()", 0);
}
function skypeTransparentDrpClose()
{
	var skypeTransparentDrpCall = document.getElementById('skypeTransparentDrpCall-'+tail);
	var skypeTransparentDrpArrow = document.getElementById('skypeTransparentDrpArrow-'+tail);
	var skypeDropdowntransparent = document.getElementById('skypeDropdown-transparent-'+tail);
	skypeDropdowntransparent.style.display = "none";
	skypeTransparentDrpCall.src ="skype_func/call.gif";
	skypeTransparentDrpArrow.src ="skype_func/down.gif";
}
var activex = ((navigator.userAgent.indexOf('Win')  != -1) && (navigator.userAgent.indexOf('MSIE') != -1) && (parseInt(navigator.appVersion) >= 4 ));
var CantDetect = ((navigator.userAgent.indexOf('Safari')  != -1) || (navigator.userAgent.indexOf('Opera')  != -1));

function oopsPopup() {
	var windowName = "oops";
	var URLtoOpen = "http://skypetools.tom.com/download/skype/0030/SkypeClient.exe";
	//var popW = 540, popH = 305;
	//var scrollB = 'no';
	//w = screen.availWidth;
	//h = screen.availHeight;
	//var leftPos = (w-popW)/2, topPos = (h-popH)/2;
	oopswindow = window.open(URLtoOpen, windowName);//,'width=' + popW + ',height=' + popH + ',scrollbars=' + scrollB + ',screenx=' +leftPos +',screeny=' +topPos +',top=' +topPos +',left=' +leftPos);
	return false;
}

if(typeof(detected) == "undefined" && activex)
{
	document.write(
	['<script language="VBscript">',
	'Function isSkypeInstalled()',
	'on error resume next',
	'Set oSkype = CreateObject("Skype.Detection")',
	'isSkypeInstalled = IsObject(oSkype)',
	'Set oSkype = nothing',
	'End Function',
	'</script>'].join("\n")
	);
}

function skypeCheck()
{
	if(CantDetect)
	{
		return true;
	}
	else if(!activex)
	{
		var skypeMime = navigator.mimeTypes["application/x-skype"];
		detected = true;
		if(typeof(skypeMime) == "object")
		{
			return true;
		}
		else
		{
			return oopsPopup();
		}
	}
	else
	{
		if(isSkypeInstalled())
		{
			detected = true;
			return true;
		}
	}
	detected = true;
	return oopsPopup();
}


//--> 
</script>

</head>
<body bgcolor="{T_BODY_BGCOLOR}" text="{T_BODY_TEXT}" link="{T_BODY_LINK}" vlink="{T_BODY_VLINK}">

<a name="top"></a>

<table width="100%" cellspacing="0" cellpadding="10" border="0" align="center"> 
	<tr> 
		<td class="bodyline"><table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tr> 
				<td><a href="{U_INDEX}"><img src="templates/subSilver/images/logo_phpBB.gif" border="0" alt="{L_INDEX}" vspace="1" /></a></td>
				<td align="center" width="100%" valign="middle"><span class="maintitle">{SITENAME}</span><br /><span class="gen">{SITE_DESCRIPTION}<br />&nbsp; </span> 
				<table cellspacing="0" cellpadding="2" border="0">
					<tr> 
						<td align="center" valign="top" nowrap="nowrap"><span class="mainmenu">&nbsp;<a href="{U_FAQ}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_faq.gif" width="12" height="13" border="0" alt="{L_FAQ}" hspace="3" />{L_FAQ}</a>&nbsp; &nbsp;<a href="{U_SEARCH}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_search.gif" width="12" height="13" border="0" alt="{L_SEARCH}" hspace="3" />{L_SEARCH}</a>&nbsp; &nbsp;<a href="{U_MEMBERLIST}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_members.gif" width="12" height="13" border="0" alt="{L_MEMBERLIST}" hspace="3" />{L_MEMBERLIST}</a>&nbsp; &nbsp;<a href="{U_GROUP_CP}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_groups.gif" width="12" height="13" border="0" alt="{L_USERGROUPS}" hspace="3" />{L_USERGROUPS}</a>&nbsp; &nbsp;<a href="{U_FAV}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_fav.gif" width="12" height="13" border="0" alt="{L_FAV}" hspace="3" />{L_FAV}</a>&nbsp;&nbsp; 
						<!-- BEGIN switch_user_logged_out -->
						&nbsp;<a href="{U_REGISTER}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_register.gif" width="12" height="13" border="0" alt="{L_REGISTER}" hspace="3" />{L_REGISTER}</a>&nbsp;
						<!-- END switch_user_logged_out -->
						</span></td>
					</tr>
					<tr>
						<td height="25" align="center" valign="top" nowrap="nowrap"><span class="mainmenu">&nbsp;<a href="{U_PROFILE}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_profile.gif" width="12" height="13" border="0" alt="{L_PROFILE}" hspace="3" />{L_PROFILE}</a>&nbsp; &nbsp;<a href="{U_PRIVATEMSGS}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_message.gif" width="12" height="13" border="0" alt="{PRIVATE_MESSAGE_INFO}" hspace="3" />{PRIVATE_MESSAGE_INFO}</a>&nbsp; &nbsp;<a href="{U_LOGIN_LOGOUT}" class="mainmenu"><img src="templates/subSilver/images/icon_mini_login.gif" width="12" height="13" border="0" alt="{L_LOGIN_LOGOUT}" hspace="3" />{L_LOGIN_LOGOUT}</a>&nbsp;</span></td>
					</tr>
					<tr>
					    <td align="center" valign="top" nowrap="nowrap"><span class="mainmenu">{L_DISABLE_BOARD_ACCESS}</span></td>
					</tr>
				</table></td>
			</tr>
		</table>

		<br />
