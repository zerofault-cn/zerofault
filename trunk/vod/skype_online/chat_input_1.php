<form name="post" method="post" action="chat_input.php" target="input_frm" style="margin:0;">
	<table width="98%"  border="0" align="center" cellpadding="0" cellspacing="1">
	<tr>
		<td>
		<table width="100%" height="25" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width="250"></td>
			<td width="40" align="center" ></td>
			<td width="65" align="center"></td>
			<td width="40" align="center" > </td>
			<td width="65" align="center"></td>
		</tr>
		</table>
		</td>
		<td align="right"></td>
	</tr>
	</table>
	<table width="98%" height="70" border="0" align="center" cellspacing="1">
	<tr>
		<td>
		<table width="100%" height="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td width="85%" valign="top" >
			<textarea name="message" rows="5" cols="60" wrap="virtual" style="width:400px; overflow:auto; border-color:#FFFFFF"  tabindex="3" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);" onKeyDown="sendmsg(this);"></textarea></td>
			<td width="15%" align="center" bgcolor="#FFFFFF"><input type="button" name="Submit" value="提交" onClick="msg_sub(this);"></td>
		</tr>
		</table>
		</td>
	</tr>
	</table>
	<input type=hidden name=user_flag value="<?=session_id()?>">
	<input type=hidden name=send_to value="goldsoft-zerofault">
	<input type=hidden name=send_from value="web_user">
	</form>
	<iframe name="input_frm" width="500" height="50" frameborder=0 src=""></iframe>

</body>
<script language="javascript" type="text/javascript">

	function endchat() {
	var truthBeTold = window.confirm("  锃稠单  斫図埃止");
		if (truthBeTold) {
			document.getElementById("emark").value = 1;
			location.href='http://free.eclickchat.net/op/chat/endchat?Y3JpZCUxMTE4&cnFpZCUxMjA5&Y29tJTEzNw&b3BpZCUxMzU&b3BuYW1lJWFkbWlu';
		}
	}
	
	function setChatTime(iHour, iMinute, iSecond) {
		iSecond++;
		if (iSecond == 60) {
			iSecond = 0;
			iMinute++;
			if (iMinute == 60) {
				iMinute = 0;
				iHour++;
			}
		}
		if (iSecond < 10) var sSecond = "0" + iSecond;
		else var sSecond = iSecond;
		if (iMinute < 10) var sMinute = "0" + iMinute;
		else var sMinute = iMinute;
		if (iHour < 10) var sHour = "0" + iHour;
		else var sHour = iHour;
		var sTime = sHour + ":" + sMinute + ":" + sSecond;
		document.getElementById("showtime").innerHTML = sTime;
		setTimeout("setChatTime(" + iHour + "," + iMinute + "," + iSecond + ")", 1000);
	}
	setTimeout("setChatTime(0,0,0)", 1000);
	
	function ChgImgSrc(t1, t2){
		document.getElementById(t1).src = t2;
	}
	

function GetCookie(sName) {
	// cookies are separated by semicolons
	var aCookie = document.cookie.split("; ");
	for (var i=0; i < aCookie.length; i++) {
		// a name/value pair (a crumb) is separated by an equal sign
		var aCrumb = aCookie[i].split("=");
		if (sName == aCrumb[0])
		return unescape(aCrumb[1]);
	}
	// a cookie with the requested name does not exist
	return 0;
}

function setCookie(sName, sValue) {
	var expires = new Date();
	expires.setTime(expires.getTime() + 365 * 24 * 60 * 60 * 1000);
	document.cookie = sName + "=" + escape(sValue) + "; expires=" + expires.toGMTString() + "; path=/";
}

function chatingAdd(sName) {
	var value = parseInt(GetCookie(sName));
	value++;
	setCookie(sName, value);
}

function chatingReduce(sName) {
	var value = parseInt(GetCookie(sName));
	value--;
	setCookie(sName, value);	
}

</script>
<script language="JavaScript" type="text/javascript">
<!--
var imageTag = false;
var theSelection = false;

var clientPC = navigator.userAgent.toLowerCase(); // Get client info
var clientVer = parseInt(navigator.appVersion); // Get browser version

var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1)
                && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1)
                && (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));
var is_moz = 0;

var is_win = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac = (clientPC.indexOf("mac")!=-1);


// Define the bbCode tags
bbcode = new Array();
bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[img]','[/img]');
imageTag = false;


// Replacement for arrayname.length property
function getarraysize(thearray) {
	for (i = 0; i < thearray.length; i++) {
		if ((thearray[i] == "undefined") || (thearray[i] == "") || (thearray[i] == null))
			return i;
		}
	return thearray.length;
}

// Replacement for arrayname.push(value) not implemented in IE until version 5.5
// Appends element to the array
function arraypush(thearray,value) {
	thearray[ getarraysize(thearray) ] = value;
}

// Replacement for arrayname.pop() not implemented in IE until version 5.5
// Removes and returns the last element of an array
function arraypop(thearray) {
	thearraysize = getarraysize(thearray);
	retval = thearray[thearraysize - 1];
	delete thearray[thearraysize - 1];
	return retval;
}


function checkForm() {

	formErrors = false;    

	if (document.post.message.value.length < 2) {
		formErrors = "";
	}

	if (formErrors) {
		alert(formErrors);
		return false;
	} else {
		bbstyle(-1);
		//formObj.preview.disabled = true;
		//formObj.submit.disabled = true;
		return true;
	}
}

function emoticon(text) {
	var txtarea = document.post.message;
	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos) {
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		txtarea.focus();
	} else {
		txtarea.value  += text;
		txtarea.focus();
	}
}

function bbfontstyle(bbopen, bbclose) {
	var txtarea = document.post.message;

	if ((clientVer >= 4) && is_ie && is_win) {
		theSelection = document.selection.createRange().text;
		if (!theSelection) {
			txtarea.value += bbopen + bbclose;
			txtarea.focus();
			return;
		}
		document.selection.createRange().text = bbopen + theSelection + bbclose;
		txtarea.focus();
		return;
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbopen, bbclose);
		return;
	}
	else
	{
		txtarea.value += bbopen + bbclose;
		txtarea.focus();
	}
	storeCaret(txtarea);
}


function bbstyle(bbnumber) {
	var txtarea = document.post.message;

	txtarea.focus();
	donotinsert = false;
	theSelection = false;
	bblast = 0;

	if (bbnumber == -1) { // Close all open tags & default button names
		while (bbcode[0]) {
			butnumber = arraypop(bbcode) - 1;
			txtarea.value += bbtags[butnumber + 1];
			buttext = eval('document.post.addbbcode' + butnumber + '.value');
			eval('document.post.addbbcode' + butnumber + '.value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
		}
		imageTag = false; // All tags are closed including image tags :D
		txtarea.focus();
		return;
	}

	if ((clientVer >= 4) && is_ie && is_win)
	{
		theSelection = document.selection.createRange().text; // Get text selection
		if (theSelection) {
			// Add tags around selection
			document.selection.createRange().text = bbtags[bbnumber] + theSelection + bbtags[bbnumber+1];
			txtarea.focus();
			theSelection = '';
			return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbtags[bbnumber], bbtags[bbnumber+1]);
		return;
	}
	
	// Find last occurance of an open tag the same as the one just clicked
	for (i = 0; i < bbcode.length; i++) {
		if (bbcode[i] == bbnumber+1) {
			bblast = i;
			donotinsert = true;
		}
	}

	if (donotinsert) {		// Close all open tags up to the one just clicked & default button names
		while (bbcode[bblast]) {
				butnumber = arraypop(bbcode) - 1;
				txtarea.value += bbtags[butnumber + 1];
				buttext = eval('document.post.addbbcode' + butnumber + '.value');
				eval('document.post.addbbcode' + butnumber + '.value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
				imageTag = false;
			}
			txtarea.focus();
			return;
	} else { // Open tags
	
		if (imageTag && (bbnumber != 14)) {		// Close image tag before adding another
			txtarea.value += bbtags[15];
			lastValue = arraypop(bbcode) - 1;	// Remove the close image tag from the list
			document.post.addbbcode14.value = "Img";	// Return button back to normal state
			imageTag = false;
		}
		
		// Open tag
		txtarea.value += bbtags[bbnumber];
		if ((bbnumber == 14) && (imageTag == false)) imageTag = 1; // Check to stop additional tags after an unclosed image tag
		arraypush(bbcode,bbnumber+1);
		eval('document.post.addbbcode'+bbnumber+'.value += "*"');
		txtarea.focus();
		return;
	}
	storeCaret(txtarea);
}

// From http://www.massless.org/mozedit/
function mozWrap(txtarea, open, close)
{
	var selLength = txtarea.textLength;
	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd;
	if (selEnd == 1 || selEnd == 2) 
		selEnd = selLength;

	var s1 = (txtarea.value).substring(0,selStart);
	var s2 = (txtarea.value).substring(selStart, selEnd)
	var s3 = (txtarea.value).substring(selEnd, selLength);
	txtarea.value = s1 + open + s2 + close + s3;
	return;
}

// Insert at Claret position. Code from
// http://www.faqts.com/knowledge_base/view.phtml/aid/1052/fid/130
function storeCaret(textEl) {
	if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}

function sendmsg(t) {
		keyCode = event.keyCode;
		ctrlKey = event.ctrlKey;
		shiftKey = event.shiftKey;
		if(keyCode==13 && !ctrlKey && !shiftKey) {
			msg_sub(t)
		}
}

function msg_sub(t){
	if(t.form.message.value != "") {
		t.form.submit();
		t.form.message.value = "";
		t.form.message.disabled = true;
		window.status = "消息正在发送，暂时无法输入。"; 	
	}
}

function chgcolor(t) {
	var color = t.form.font_color.value;
	t.form.message.style.color = color;
}
//document.getElementById('message').style.color = document.getElementById('font_color').value;

function chgsize(t) {
	var size = t.form.font_size.value;
	t.form.message.style.fontSize = size;
}
//document.getElementById('message').style.fontSize = document.getElementById('font_size').value;
//-->
</script>
</html>