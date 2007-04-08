<?
/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
São Paulo - Brasil
*************************************************************************/

//defines
require("./inc/inc.php");

if(!isset($ix) || !isset($pag)) Header("Location: error.php?err=3&sid=$sid&tid=$tid&lid=$lid&retid=$retid");

$mysess = $sess["headers"][base64_encode($folder)];
$mail_info = $mysess[$ix];

if(isset($attachment)) {
	$is_attached = true;
	$root = $mail_info["attachments"][$attachment];

	if( !is_array($root) || !file_exists($root["filename"])) 
		Header("error.php?err=3&sid=$sid&tid=$tid&lid=$lid");

	$result = $UM->_read_file($root["filename"]);
}
else {
	$is_attached = false;
	$arAttachment = Array();
	
	if(!($result = $UM->mail_retr_msg($mail_info,1))) { Header("Location: msglist.php?err=2&folder=".urlencode($folder)."&pag=$pag&sid=$sid&tid=$tid&lid=$lid&retid=$retid&refr=true\r\n"); exit; }

	if($UM->mail_set_flag($mail_info,"\\SEEN","+")) {
		$sess["headers"][base64_encode($folder)][$ix] = $mail_info;
		$SS->Save($sess);
	}
}

echo($nocache);

$UM->displayimages = $prefs["display-images"];
$UM->allow_scripts = $allow_scripts;

$email = $UM->Decode($result);

if($ix > 0) {
	$umHavePrevious = 1;
	$umPreviousSubject = $mysess[($ix-1)]["subject"];

	$umPreviousLink = "readmsg.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=".urlencode($folder)."&pag=$pag&ix=".($ix-1);

	$smarty->assign("umHavePrevious",$umHavePrevious);
	$smarty->assign("umPreviousSubject",$umPreviousSubject);
	$smarty->assign("umPreviousLink",$umPreviousLink);

}

if($ix < (count($mysess)-1)) {
	$umHaveNext = 1;
	$umNextSubject = $mysess[($ix+1)]["subject"];
	$umNextLink = "readmsg.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=".urlencode($folder)."&pag=$pag&ix=".($ix+1);
	$smarty->assign("umHaveNext",$umHaveNext);
	$smarty->assign("umNextSubject",$umNextSubject);
	$smarty->assign("umNextLink",$umNextLink);
}

//$body = $email["body"];
$body = substr($email["body"], 0, -50); 
$endbody	= 	eregi_replace("<BR />\r\n.<BR />\r\n", "", substr($email["body"], -50));
$body	.= 	eregi_replace("\r\n.\r\n", "", $endbody);

$uagent = 	$HTTP_SERVER_VARS["HTTP_USER_AGENT"];

$ns4    = 	(ereg("Mozilla/4",$uagent) && !ereg("MSIE",$uagent) && 
			!ereg("Gecko",$uagent));
$ns6moz = 	ereg("Gecko",$uagent);
$ie4up  = 	ereg("MSIE (4|5|6)",$uagent);
$other	= 	(!$ns4 && !$ns6moz && !$ie4up);

if ($other) {

	$body 	= 	eregi_replace("<base","<uebimiau_base_not_alowed",
				eregi_replace("<link","<uebimiau_link_not_alowed",
				$body));

	if(eregi("<[ ]*body.*background[ ]*=[ ]*[\"']?([A-Za-z0-9._&?=:/{}%+-]+)[\"']?.*>",$body,$regs))
		$backimg = 	" background=\"".$regs[1]."\"";
	$smarty->assign("umBackImg",$backimg);
	if(eregi("<[ ]*body[A-Z0-9._&?=:/\"' -]*bgcolor=[\"']?([A-Z0-9#]+)[\"']?[A-Z0-9._&?=:/\"' -]*>",$body,$regs))
		$backcolor = " bgcolor=\"".$regs[1]."\"";
	$smarty->assign("umBackColor",$backcolor);

	$body = eregi_replace("<body","<uebimiau_body_not_alowed",$body);
	$body = eregi_replace("a:(link|visited|hover)",".".uniqid(""),$body);
	$body = eregi_replace("(body)[ ]?\\{",".".uniqid(""),$body);

} elseif($ie4up || $ns6moz) {
	$sess["currentbody"] = $body;;
	$SS->Save($sess);
	$body = "<iframe id=\"readerframe\" src=\"show_body.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=".urlencode($folder)."&ix=$ix\" width=\"100%\" height=\"400\" frameborder=\"0\"></iframe>";

} elseif($ns4) {
	$sess["currentbody"] = $body;;
	$SS->Save($sess);
	$body = "<ilayer id=\"readerframe\" width=\"100%\" left=\"0\" top=\"0\" >$body</ilayer>";
}

$smarty->assign("umMessageBody",$body);


$ARFrom = $email["from"];
$useremail = $sess["email"];

// from
$name = $ARFrom[0]["name"];
$thismail = $ARFrom[0]["mail"];
$ARFrom[0]["link"] = "newmsg.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&nameto=".urlencode($name)."&mailto=$thismail";
$ARFrom[0]["title"] = "$name <$thismail>";

$smarty->assign("umFromList",$ARFrom);

// To
$ARTo = $email["to"];

for($i=0;$i<count($ARTo);$i++) {
	$name = $ARTo[$i]["name"];
	$thismail = $ARTo[$i]["mail"];
	$link = "newmsg.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&nameto=".urlencode($name)."&mailto=$thismail";
	$ARTo[$i]["link"] = $link;
	$ARTo[$i]["title"] = "$name <$thismail>";
	$smarty->assign("umTOList",$ARTo);
}

// CC
$ARCC = $email["cc"];
if(count($ARCC) > 0) {
	$smarty->assign("umHaveCC",1);
	for($i=0;$i<count($ARCC);$i++) {
		$name = $ARCC[$i]["name"];
		$thismail = $ARCC[$i]["mail"];
		$link = "newmsg.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&nameto=".urlencode($name)."&mailto=$thismail";
		$ARCC[$i]["link"] = $link;
		$ARCC[$i]["title"] = "$name <$thismail>";
	}
	$smarty->assign("umCCList",$ARCC);
}

$smarty->assign("umPageTitle",$email["subject"]);

$jssource = $memujssource."
<script language=\"JavaScript\">

function deletemsg() { 
	if(confirm('".ereg_replace("'","\\'",$confirm_delete)."')) 
		with(document.move) { decision.value = 'delete'; submit(); } 
}
function reply() { document.msg.submit(); }
function movemsg() { document.move.submit(); }
function headers() { mywin = window.open('headers.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=".urlencode($folder)."&ix=$ix','Headers','width=550, top=100, left=100, height=320,directories=no,toolbar=no,status=no,scrollbars=yes,resizable=yes'); }
function catch_addresses() { mywin = window.open('catch.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=".urlencode($folder)."&ix=$ix','Catch','width=550, top=100, left=100, height=320,directories=no,toolbar=no,status=no,scrollbars=yes'); }
function replyall() { with(document.msg) { rtype.value = 'replyall'; submit(); } }
function forward() { with(document.msg) { rtype.value = 'forward'; submit(); } }
function goback() { location = 'msglist.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=".urlencode($folder)."&pag=$pag'; }
function printit() { window.open('printmsg.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=".urlencode($folder)."&ix=$ix','PrintView','resizable=1,top=10,left=10,width=600,heigth=500,scrollbars=yes,status=no,toolbar=yes,menubar=yes'); }
function openmessage(attach) { window.open('readmsg.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=".urlencode($folder)."&pag=$pag&ix=$ix&attachment='+attach,'','resizable=1,top=10,left=10,width=620,heigth=500,scrollbars=1,status=0'); }
function openwin(targetUrl) { window.open(targetUrl); }

</script>
";

$umDeleteForm = "<input type=hidden name=lid value=$lid>
<input type=hidden name=sid value=\"$sid\">
<input type=hidden name=tid value=\"$tid\">
<input type=hidden name=decision value=move>
<input type=hidden name=folder value=\"".htmlspecialchars($folder)."\">
<input type=hidden name=pag value=$pag>
<input type=hidden name=start_pos value=$ix>
<input type=hidden name=end_pos value=".($ix+1).">
<input type=hidden name=msg_$ix value=X>
<input type=hidden name=back value=true>";

$umReplyForm = "<form name=msg action=\"newmsg.php\" method=POST>
<input type=hidden name=rtype value=\"reply\">
<input type=hidden name=sid value=\"$sid\">
<input type=hidden name=lid value=\"$lid\">
<input type=hidden name=tid value=\"$tid\">
<input type=hidden name=folder value=\"".htmlspecialchars($folder)."\">
<input type=hidden name=ix value=\"$ix\">
</form>
";

$smarty->assign("umDeleteForm",$umDeleteForm);
$smarty->assign("umReplyForm",$umReplyForm);
$smarty->assign("umJS",$jssource);

$smarty->assign("umSubject",$email["subject"]);
$smarty->assign("umDate",$email["date"]);

$anexos = $email["attachments"];
$haveattachs = (count($anexos) > 0)?1:0;
$smarty->assign("umHaveAttachments",$haveattachs);

if(count($anexos) > 0) {

/*	$root = &$mail_info["attachments"];

	foreach($arAttachment as $item ) {
		if(is_numeric($item)) {
			$root = &$root[$item]["attachments"];
		}
	}
*/
	$mail_info["attachments"] = $email["attachments"];

	$sess["headers"][base64_encode($folder)][$ix] = $mail_info;

	for($i = 0; $i < count($anexos); $i++) {
		
		$iconname = "";
		if (strrpos($anexos[$i]["name"], '.') !== false) {
			$iconname = substr($anexos[$i]["name"], strrpos($anexos[$i]["name"], '.')+1);
			$iconname = strtolower($iconname);
			
			$iconfile = $fileiconpath.$iconname.".gif";
			if (!file_exists($iconfile))
				$iconfile = $fileiconpath."unknown.gif";
		}	
		else
			$iconfile = $fileiconpath."unknown.gif";

		$anexos[$i]["iconfile"] = $iconfile;
		
		$link1 = "download.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=$folder&ix=$ix&mnum=$mnum&bound=".base64_encode($anexos[$i]["boundary"])."&part=".$anexos[$i]["part"];
		$link2 = "$link1&down=1";
		
		if ($iconname == "txt" || $iconname == "htm" || $iconname == "html" || $iconname == "shtml" 
			|| $iconname == "pdf" || $iconname == "bmp" || $iconname == "jpg" || $iconname == "jpeg" 
			|| $iconname == "gif" || $iconname == "doc" || $iconname == "rtf" || $iconname == "xls" 
			|| $iconname == "mdb" || $iconname == "ppt" || $iconname == "xml" || $iconname == "chm" 
			|| $iconname == "swf" || $iconname == "jpe" || $iconname == "eml") {
				
			if(trim($anexos[$i]["content-type"]) == "message/rfc822") {
				$anexos[$i]["normlink"] = "javascript:openmessage('".$i."')";
			} 
			else
				$anexos[$i]["normlink"] = "javascript:openwin('".$link1."')";
		}
		else
			$anexos[$i]["normlink"] = "";
			
		$anexos[$i]["downlink"] = $link2;
		
		$anexos[$i]["size"] = ceil($anexos[$i]["size"]/1024);
		$anexos[$i]["type"] = trim($anexos[$i]["content-type"]);
	}
	
	$smarty->assign("umAttachList", $anexos);
}

$SS->Save($sess);

include("./inc/imap_utf7.php");
$avalfolders = Array();
$d = dir($userfolder);
while($entry=$d->read()) {
	if(	is_dir($userfolder.$entry) && 
		$entry != ".." && $entry != "." && 
		substr($entry,0,1) != "_" && $entry != $folder &&
		($mail_protocol == "imap" || strtolower($entry) != "inbox")) {
		switch(strtolower($entry)) {
		case "inbox":
			$display = $inbox_extended;
			break;
		case "sent":
			$display = $sent_extended;
			break;
		case "trash":
			$display = $trash_extended;
			break;
		case "draft":
			$display = $draft_extended;
			break;
		default:
			$display = utf7_decode($entry, $default_char_set);
		}
		$avalfolders[] = Array("path" => $entry, "display" => $display);

	}
}
$d->close();
$smarty->assign("umAvalFolders",$avalfolders);

if($is_attached)
	$smarty->display("$selected_theme/readmsg_popup.htm");
else
	$smarty->display("$selected_theme/readmsg.htm");
?>
