<?

/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
São Paulo - Brasil
*************************************************************************/

require("./inc/inc.php");

echo($nocache);

if($tipo == "send") {

	require("./inc/class.smtp.php");

	$ARTo = $UM->get_names(stripslashes($to));
	$ARCc = $UM->get_names(stripslashes($cc));
	$ARBcc = $UM->get_names(stripslashes($bcc));

	if((count($ARTo)+count($ARCc)+count($ARBcc)) > 0) {
		$mail = new phpmailer;
		// for password authenticated servers

		if($use_password_for_smtp) {
			$mail->UseAuthLogin($sess["user"],$sess["pass"]);
		}
		// if using the advanced editor
		if ($sign != ""){
			if ($is_html == "true")	{
				$body .= '<br><br>---------<br>';
				$body .= nl2br($sign);
			}else {
				$body .= '\r\n\r\n---------\r\n';
				$body .= $sign;
			}
		}
	
		if($is_html == "true")  {
			$mail->IsHTML(1);
			if($footer != "") 
				$body .= preg_replace("/(\r\n|\n|\r)/","<BR />\\1",$footer);

		} else if ($footer != "") 
			$body .= $footer;

		$mail->CharSet		= $default_char_set;
		$mail->IPAddress	= getenv("REMOTE_ADDR");
		$mail->timezone		= $server_time_zone;
		$mail->From 		= (!empty($sess["email"])) ? $sess["email"] : $prefs["reply-to"];
		$mail->FromName 	= $UM->mime_encode_headers((empty($prefs["real-name"])) ? $sess["user"] : $prefs["real-name"]);
		$mail->AddReplyTo(empty($prefs["reply-to"]) ? $sess["email"] : $prefs["reply-to"], $UM->mime_encode_headers( empty($prefs["real-name"]) ? $sess["user"] : $prefs["real-name"]));
		$mail->Host 		= $smtp_server;
		$mail->Port 		= $smtp_port;
		$mail->WordWrap 	= 76;
		$mail->Priority		= $priority;

		if(count($ARTo) != 0) {
			for($i=0;$i<count($ARTo);$i++) {
				$name = $ARTo[$i]["name"];
				$email = $ARTo[$i]["mail"];
				if($name != $email)
					$mail->AddAddress($email,$UM->mime_encode_headers($name));
				else
					$mail->AddAddress($email);
			}
		}

		if(count($ARCc) != 0) {
			for($i=0;$i<count($ARCc);$i++) {
				$name = $ARCc[$i]["name"];
				$email = $ARCc[$i]["mail"];
				if($name != $email)
					$mail->AddCC($email,$UM->mime_encode_headers($name));
				else
					$mail->AddCC($email);
			}
		}

		if(count($ARBcc) != 0) {
			for($i=0;$i<count($ARBcc);$i++) {
				$name = $ARBcc[$i]["name"];
				$email = $ARBcc[$i]["mail"];
				if($name != $email)
					$mail->AddBCC($email,$UM->mime_encode_headers($name));
				else
					$mail->AddBCC($email);
			}
		}

		if(is_array($attachs = $sess["attachments"])) {
			for($i=0;$i<count($attachs);$i++) {
				if(file_exists($attachs[$i]["localname"])) {
					$mail->AddAttachment($attachs[$i]["localname"], $attachs[$i]["name"], $attachs[$i]["type"]);
				}
			}
		}

		$mail->Subject = $UM->mime_encode_headers(stripslashes($subject));
		$mail->Body = stripslashes($body);

		if(($resultmail = $mail->Send()) === false) {
			$err = $mail->ErrorAlerts[count($mail->ErrorAlerts)-1];
			$smarty->assign("umMailSent",false);
			$smarty->assign("umErrorMessage",$err);

		} else {
			$smarty->assign("umMailSent",true);

			if(is_array($attachs = $sess["attachments"])) {
				for($i=0;$i<count($attachs);$i++) {
					if(file_exists($attachs[$i]["localname"])) {
						@unlink($attachs[$i]["localname"]);
					}
				}
				
				unset($sess["attachments"]);
				reset($sess);
				$SS->Save($sess);
			}

			if($prefs["save-to-sent"]) {
				$UM->mail_save_message("Sent",$resultmail);
				unset($sess["headers"][base64_encode("sent")]);
				$SS->Save($sess);
			}
		}
	} 
	else 
		die("<script language=\"javascript\">location = 'error.php?err=3&sid=$sid&tid=$tid&lid=$lid&retid=$retid';</script>");

	$jssource = $memujssource;

	$smarty->assign("umSid",$sid);
	$smarty->assign("umLid",$lid);
	$smarty->assign("umTid",$tid);
	$smarty->assign("umJS",$jssource);

	$smarty->display("$selected_theme/newmsg-result.htm");

}else {

	$priority_level = (!$priority)?3:$priority;
	$bg_color = (!$bgcolor)?'-1':$bgcolor;

	$uagent = $HTTP_SERVER_VARS["HTTP_USER_AGENT"];
	$isMac = ereg("Mac",$uagent);
	$isOpera = ereg("Opera",$uagent);
	
	$uagent = explode("; ",$uagent);
	$uagent = explode(" ",$uagent[1]);
	$bname = strtoupper($uagent[0]);
	$bvers = $uagent[1];

	$show_advanced = (($bname == "MSIE") && (intval($bvers) >= 5) && (!$isMac) && (!$isOpera)) ? 1 : 0;
	
	if ($show_advanced)
	{
		$show_advanced = ($prefs["editor-mode"] != "text") ? 1 : 0;
		
		if ($textmode === "1")
			$show_advanced = 0;
			
		if ($textmode === "0")
			$show_advanced = 1;
	}

	$js_advanced = ($show_advanced)? "true" : "false";

	$tmpsignlist = load_signature();
	
	$umAddSig = count($tmpsignlist) ? 1 : 0;
	
	$signlist[0]['name'] = "$signature_noselect";
	$signlist[0]['content'] = '';
	for ($i = 0; $i < count($tmpsignlist); $i++){
		$signlist[$i+1]['name'] = $tmpsignlist[$i]['name'];
		$signlist[$i+1]['content'] = htmlspecialchars($tmpsignlist[$i]['content']);
	}

	$forms = "<input type=hidden name=tipo value=edit>
	<input type=hidden name=is_html value=\"$js_advanced\">
	<input type=hidden name=sid value=\"$sid\">
	<input type=hidden name=lid value=\"$lid\">
	<input type=hidden name=tid value=\"$tid\">
	<input type=hidden name=folder value=\"$folder\">
	<input type=hidden name=textmode value=\"$textmode\">
	";



	$jssource = $memujssource."
<script language=\"javascript\">
bIs_html = $js_advanced;
bsig_added = false;

function chgsig() {
	with(document.composeForm) {
		var oSig = sign_name.options;
		sign.value=oSig[oSig.selectedIndex].value;
	}
	return true;
}

function upwin(rem) { 
	mywin = 'upload.php';
	if (rem != null) 
		mywin += '?rem='+rem+'&sid=$sid&tid=$tid&lid=$lid&retid=$retid';
	else 
		mywin += '?sid=$sid&tid=$tid&lid=$lid&retid=$retid';
	window.open(mywin,'Upload','width=320,height=400,directories=no,toolbar=no,status=no,scrollbars=yes,resizable=yes'); 
}

function doupload() {
	if(bIs_html) document.composeForm.body.value = GetHtml();
	document.composeForm.tipo.value = 'edit';
	document.composeForm.submit();
}

function textmode() {
	with(document.composeForm) {
		if(bIs_html) body.value = GetHtml();
		textmode.value = '1';
		tipo.value = 'edit';
		submit();
	}
}

function htmlmode() {
	with(document.composeForm) {
		textmode.value = '0';
		tipo.value = 'edit';
		submit();
	}
}

function enviar() {
	error_msg = new Array();
	frm = document.composeForm;
	check_mail(frm.to.value);
	check_mail(frm.cc.value);
	check_mail(frm.bcc.value);
	errors = error_msg.length;

	if(frm.to.value == '' && frm.cc.value == '' && frm.bcc.value == '')
		alert('".ereg_replace("'","\\'",$error_no_recipients)."');

	else if (errors > 0) {

		if (errors == 1) errmsg = '".ereg_replace("'","\\'",$error_compose_invalid_mail1_s)."\\r\\r';
		else  errmsg = '".ereg_replace("'","\\'",$error_compose_invalid_mail1_p)."\\r\\r';

		for(i = 0; i < errors; i++)
			errmsg += error_msg[i]+'\\r';

		if (errors == 1) errmsg += '\\r".ereg_replace("'","\\'",$error_compose_invalid_mail2_s)."s';
		else  errmsg += '\\r".ereg_replace("'","\\'",$error_compose_invalid_mail2_p)."';

		alert(errmsg)

	} else {
		if(bIs_html) {
			var strbody = '<HTML><BODY';
			
			if( document.composeForm.bgcolor.value != '-1' ){
				strbody += ' bgcolor=' + document.composeForm.bgcolor.value;
			}
			
			strbody += '>';
			strbody += GetHtml();
			strbody += '</BODY></HTML>';
			
			frm.body.value = strbody;
		}
		
		frm.tipo.value = 'send';
		frm.submit();
	}
}

function envspell() {
	error_msg = new Array();
	frm = document.composeForm;

	if(bIs_html) frm.body.value = GetHtml();
	frm.tipo.value = 'spell';
	frm.submit();
}

function addrpopup() {	
	mywin = window.open('quick_address.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid','AddressBook','width=480,height=220,top=200,left=200'); 
}

function AddAddress(strType,strAddress) {
	obj = eval('document.composeForm.'+strType);
	if (obj.value.indexOf(strAddress) == -1){
		if(obj.value == '') obj.value = strAddress
		else  obj.value = obj.value + ', ' + strAddress
	}
}

function check_mail(strmail) {
	if(strmail == '') return;
	chartosplit = ',;';
	protectchar = '\"';
	temp = '';
	armail = new Array();
	inthechar = false; 
	lt = '<';
	gt = '>'; 
	isclosed = true;

	for(i=0;i<strmail.length;i++) {
		thischar = strmail.charAt(i);
		if(thischar == lt && isclosed) isclosed = false;
		if(thischar == gt && !isclosed) isclosed = true;
		if(thischar == protectchar) inthechar = (inthechar)?0:1;
		if(chartosplit.indexOf(thischar) != -1 && !inthechar && isclosed) {
			armail[armail.length] = temp; temp = '';
		} else temp += thischar;
	}

	armail[armail.length] = temp; 

	for(i=0;i<armail.length;i++) {
		thismail = armail[i]; strPat = /(.*)<(.*)>/;
		matchArray = thismail.match(strPat); 
		if (matchArray != null) strEmail = matchArray[2];
		else {
			strPat = /([-a-zA-Z0-9_$+.]+@[-a-zA-Z0-9_.]+[-a-zA-Z0-9_]+)((.*))/; matchArray = thismail.match(strPat); 
			if (matchArray != null) strEmail = matchArray[1];
			else strEmail = thismail;
		}
		if(strEmail.charAt(0) == '\"' && strEmail.charAt(strEmail.length-1) == '\"') strEmail = strEmail.substring(1,strEmail.length-1)
		if(strEmail.charAt(0) == '<' && strEmail.charAt(strEmail.length-1) == '>') strEmail = strEmail.substring(1,strEmail.length-1)

		strPat = /([-a-zA-Z0-9_$+.]+@[-a-zA-Z0-9_.]+[-a-zA-Z0-9_]+)((.*))/;
		matchArray = strEmail.match(strPat); 
		if(matchArray == null)
			error_msg[error_msg.length] = strEmail;
	}
}


</script>
";

	$smarty->assign("umBgColor",$bg_color);
	$smarty->assign("umPriority",$priority_level);
	$smarty->assign("umAddSignature",$umAddSig);
	$smarty->assign("umSignatureList",$signlist);
	$smarty->assign("umForms",$forms);
	$smarty->assign("umJS",$jssource);

	$body = stripslashes($body);


	if(isset($rtype)) {
		$mail_info = $sess["headers"][base64_encode($folder)][$ix];

		if(!eregi("\\ANSWERED",$mail_info["flags"])) {
			if($UM->mail_set_flag($mail_info,"\\ANSWERED","+")) {
				$sess["headers"][base64_encode($folder)][$ix] = $mail_info;
				$SS->Save($sess);
			}
		}


		$filename = $mail_info["localname"];

		if(!file_exists($filename)) die("<script>location = 'msglist.php?err=2&folder=".urlencode($folder)."&pag=$pag&sid=$sid&tid=$tid&lid=$lid&retid=$retid&refr=true';</script>");
		$result = $UM->_read_file($filename);
		
		$email = $UM->Decode($result);
		$result = $UM->fetch_structure($result);


		//$tmpbody = $email["body"];
		$tmpbody = substr($email["body"], 0, -50); 
		$endbody	= 	eregi_replace("<BR />\r\n.<BR />\r\n", "", substr($email["body"], -50));
		$tmpbody	.= 	eregi_replace("\r\n.\r\n", "", $endbody);
		
		$subject = $mail_info["subject"];

		$ARReplyTo = $email["reply-to"];
		$ARFrom = $email["from"];
		$useremail = $sess["email"];

		// from
		if($ARReplyTo[0]["mail"] != "") {
			$name = $ARReplyTo[0]["name"];
			$thismail = $ARReplyTo[0]["mail"];
		} else {
			$name = $ARFrom[0]["name"];
			$thismail = $ARFrom[0]["mail"];
		}
		$fromreply = "\"$name\" <$thismail>";

		// To
		$ARTo = $email["to"];
		for($i=0;$i<count($ARTo);$i++) {
			$name = $ARTo[$i]["name"]; 
			$thismail = $ARTo[$i]["mail"];
			
			if (strtolower($thismail) == strtolower($sess['email']))
				continue;
				
			if(isset($toreply)) $toreply .= ", \"$name\" <$thismail>";
			else $toreply = "\"$name\" <$thismail>";
		}

		// CC
		$ARCC = $email["cc"];
		for($i=0;$i<count($ARCC);$i++) {
			$name = $ARCC[$i]["name"]; 
			$thismail = $ARCC[$i]["mail"];
			
			if (strtolower($thismail) == strtolower($sess['email']))
				continue;

			if(isset($ccreply)) $ccreply .= ", \"$name\" <$thismail>";
			else $ccreply = "\"$name\" <$thismail>";
		}

		function clear_names($strMail) {
			global $UM;
			$strMail = $UM->get_names($strMail);
			for($i=0;$i<count($strMail);$i++) {
				$thismail = $strMail[$i];
				$thisline = ($thismail["mail"] != $thismail["name"])?"\"".$thismail["name"]."\""." <".$thismail["mail"].">":$thismail["mail"];
				if($thismail["mail"] != "" && strpos($result,$thismail["mail"]) === false) {
					if($result != "") $result .= ", ".$thisline;
					else $result = $thisline;
				}
			}
			return $result;
		}


		$allreply = clear_names($fromreply.", ".$toreply);
		$ccreply = clear_names($ccreply);
		$fromreply = clear_names($fromreply);

		$msgsubject = $email["subject"];

		$fromreply_quote 	= $fromreply;
		$toreply_quote		= $toreply;
		$ccreply_quote		= $ccreply;
		$msgsubject_quote	= $msgsubject;

		if($show_advanced) {
			$fromreply_quote 	= htmlspecialchars($fromreply_quote);
			$toreply_quote		= htmlspecialchars($toreply_quote);
			$ccreply_quote		= htmlspecialchars($ccreply_quote);
			$msgsubject_quote	= htmlspecialchars($msgsubject_quote);
			$linebreak			= "<br>";

		} else {
			$tmpbody			= strip_tags($tmpbody);
			$quote_string = "> ";
			$tmpbody = $quote_string.ereg_replace("\n","\n$quote_string",$tmpbody);
		}

$body = "$linebreak
$reply_delimiter$linebreak
$reply_from_hea ".ereg_replace("(\")","",$fromreply_quote)."$linebreak
$reply_to_hea ".ereg_replace("(\")","",$toreply_quote);

if(!empty($ccreply)) {
	$body .= "$linebreak
	$reply_cc_hea ".ereg_replace("(\")","",$ccreply_quote);
}


$body .= "$linebreak
$reply_subject_hea ".$msgsubject_quote."$linebreak
$reply_date_hea ".@strftime($date_format,$email["date"])."$linebreak
$linebreak
$tmpbody";


		if($show_advanced) {
			$body = "
<br>
<BLOCKQUOTE dir=ltr style=\"PADDING-RIGHT: 0px; PADDING-LEFT: 5px; MARGIN-LEFT: 5px; BORDER-LEFT: #000000 2px solid; MARGIN-RIGHT: 0px\">
  <DIV style=\"FONT: 10pt arial\">
  $body
  </DIV>
</BLOCKQUOTE>
";
		}

		switch($rtype) {
		case "reply":
			if(!eregi("^$reply_prefix",trim($subject))) $subject = "$reply_prefix $subject";
			$to = $fromreply;
			break;
		case "replyall":
			if(!eregi("^$reply_prefix",trim($subject))) $subject = "$reply_prefix $subject";
			$to = $allreply;
			$cc = $ccreply;
			break;
		case "forward":
			if(!eregi("^$forward_prefix",trim($subject))) $subject = "$forward_prefix $subject";

			if(count($email["attachments"]) > 0) {
				$bound = $email["attachments"][0]["boundary"];
				if($bound != "") {
					$parts = $UM->split_parts($bound,$result["body"]);
				} else {
					$parts[0] = $result["body"];
				}

				for($i = 0; $i < count($email["attachments"]); $i++) {

					$current = $email["attachments"][$i];

					$currentstruc = $UM->fetch_structure($parts[$current["part"]]);

					$tmpfilename 	= $temporary_directory."_attachments\\".$sess['user'].'_'.uniqid("").".tmp";
					$contenttype 	= ($current["content-type"] != "")?$current["content-type"]:"application/octet-stream";
					$filename		= ($current["name"] != "")?$current["name"]:basename($tmpfilename);

					if (strrpos($current["name"], '.') !== false) {
						$iconname = substr($current["name"], strrpos($current["name"], '.')+1);
						$iconfile = $fileiconpath.$iconname.".gif";
						if (!file_exists($iconfile))
							$iconfile = $fileiconpath."unknown.gif";
					}	
					else
						$iconfile = $fileiconpath."unknown.gif";

					$UM->save_attach($currentstruc["header"],$currentstruc["body"],$tmpfilename);

					$ind = count($sess["attachments"]);
					$sess["attachments"][$ind]["localname"] = $tmpfilename;
					$sess["attachments"][$ind]["name"] = $filename;
					$sess["attachments"][$ind]["type"] = $contenttype;
					$sess["attachments"][$ind]["size"] = filesize($tmpfilename);
					$sess["attachments"][$ind]["iconfile"] = $iconfile;
				}
	
				$SS->Save($sess);
			}
			break;
		}
	} 

	if(!isset($mailto)) $mailto=$nameto;
	if(!isset($to)) $to = null;
	if(!isset($cc)) $cc = null;
	if(!isset($bcc)) $bcc = null;
	if(!isset($subject)) $subject = null;

	$strto = (isset($nameto) && eregi("([-a-z0-9_$+.]+@[-a-z0-9_.]+[-a-z0-9_])",$mailto))?
	"<input class=textbox type=text size=50 name=to value=\"&quot;".htmlspecialchars(stripslashes($nameto))."&quot; <".htmlspecialchars(stripslashes($mailto)).">\">
	":"<input class=textbox type=text size=50 name=to value=\"".htmlspecialchars(stripslashes($to))."\">";

	$strcc = "<input class=textbox type=text size=50 name=cc value=\"".htmlspecialchars(stripslashes($cc))."\">";
	$strbcc = "<input class=textbox type=text size=50 name=bcc value=\"".htmlspecialchars(stripslashes($bcc))."\">";
	$strsubject = "<input class=textbox type=text size=80 name=subject value=\"".htmlspecialchars(stripslashes($subject))."\">";

	$haveAttachs = (is_array($attachs = $sess["attachments"]) && count($sess["attachments"]) != 0)?1:0;
	$smarty->assign("umHaveAttachs",$haveAttachs);

	if(is_array($attachs = $sess["attachments"]) && count($sess["attachments"]) != 0) {

		$attachlist = Array();
		for($i=0;$i<count($attachs);$i++) {
			$index = count($attachlist);

			$attachlist[$index]["name"] = $attachs[$i]["name"];
			$attachlist[$index]["size"] = ceil($attachs[$i]["size"]/1024);
			
			if (!empty($attachs[$i]["iconfile"]))
			{
				$iconfile = $attachs[$i]["iconfile"];
			}
			else
			{
				if (strrpos($attachs[$i]["name"], '.') !== false) {
					$iconname = substr($attachs[$i]["name"], strrpos($attachs[$i]["name"], '.')+1);
					$iconfile = $fileiconpath.$iconname.".gif";
					if (!file_exists($iconfile))
						$iconfile = $fileiconpath."unknown.gif";
				}	
				else
					$iconfile = $fileiconpath."unknown.gif";
			}

			$attachlist[$index]["iconfile"] = $iconfile;
			$attachlist[$index]["type"] = $attachs[$i]["type"];
			$attachlist[$index]["link"] = "javascript:upwin($i)";
		}
		$smarty->assign("umAttachList",$attachlist);
	}

	if(!$show_advanced) $body = stripslashes($body);

	$umAdvEdit = ($show_advanced)?1:0;

	$smarty->assign("umBody",$body);
	$smarty->assign("umTo",$strto);
	$smarty->assign("umCc",$strcc);
	$smarty->assign("umBcc",$strbcc);
	$smarty->assign("umSubject",$strsubject);
	$smarty->assign("umTextEditor",$txtarea);
	$smarty->assign("umAdvancedEditor",$umAdvEdit);
	
	$selclrurl = "selcolor.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid";
	$smarty->assign("umSelColorUrl",$selclrurl);

	$inspicurl = "inspicture.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid";
	$smarty->assign("umInsPictureUrl",$inspicurl);

	$instaburl = "instable.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid";
	$smarty->assign("umInsTableUrl",$instaburl);

	$smarty->display("$selected_theme/newmsg.htm");

}

?>

