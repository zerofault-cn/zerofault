<?
/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
São Paulo - Brasil
*************************************************************************/

require("./inc/inc.php");

$smarty->assign("umUser",$f_user);
$smarty->assign("umJS",$jssource);

$headers = $sess["headers"][base64_encode($folder)];

if(isset($start_pos) && isset($end_pos)) {

	for($i = $start_pos; $i < $end_pos; $i++) {
		if(isset(${"msg_$i"})) {
			if ($decision == "delete") {
				$UM->mail_delete_msg($headers[$i],$prefs["save-to-trash"]);
			} 
			else if ($decision == "drop") {
				$UM->mail_delete_msg($headers[$i],0);
			}
			else if ($decision == "move"){
				$UM->mail_move_msg($headers[$i],$aval_folders);
			}
			$expunge = true;
		}
	}

	if($expunge) {
		if($decision == "delete" && $prefs["save-to-trash"])
			unset($sess["headers"][base64_encode("Trash")]);
		if ($decision == "move")
			unset($sess["headers"][base64_encode($aval_folders)]);

		//some servers, don't hide deleted messages until you don't disconnect
		$SS->Save($sess);

		if ($back) {
			$back_to = $start_pos;
		}

	}
	
	unset($sess["headers"][base64_encode($folder)]);
} else {
	unset($sess["headers"][base64_encode($folder)]);
}

$boxes = $UM->mail_list_boxes();
$sess["folders"] = $boxes;

$sess["last-update"] = time();

if($quota_limit) {
	for($n = 0; $n < count($boxes); $n++) {
		$entry = $boxes[$n]["name"];
		
		//if(!is_array($sess["headers"][base64_encode($entry)])) {
			$sess["headers"][base64_encode($entry)] = $UM->mail_list_msgs($entry);
		//}
	}
} else {
	$sess["headers"][base64_encode($folder)] = $UM->mail_list_msgs($folder);
}

$headers = $sess["headers"][base64_encode($folder)];

if($check_first_login && !$prefs["first-login"]) {
	$SS->Save($sess);

	Header("Location: preferences.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=".urlencode($folder));
	exit;
}


$arrow = ($sortorder == "ASC") ? "images/arrow_up.gif" : "images/arrow_down.gif";
$arrow = "&nbsp;<img src=$arrow width=8 height=7 border=0 alt=>";

$attach_arrow  	= "";
$subject_arrow 	= "";
$fromname_arrow = "";
$date_arrow 	= "";
$size_arrow 	= "";

switch($sortby) {
	case "subject":
		$subject_arrow  	= $arrow;
		break;
	case "fromname":
		$fromname_arrow  	= $arrow;
		break;
	case "date":
		$date_arrow  		= $arrow;
		break;
	case "size":
		$size_arrow   		= $arrow;
		break;
}


array_qsort2($headers,$sortby,$sortorder);
reset($headers);

$sess["headers"][base64_encode($folder)] = $headers;
$SS->Save($sess);

if ($back_to) {
	if (count($headers) > $back_to) {
		Header("Location: readmsg.php?folder=".urlencode($folder)."&pag=$pag&ix=$back_to&sid=$sid&tid=$tid&lid=$lid&retid=$retid");
		exit;
	}
}

/* load total size */
while(list($box,$info) = each($sess["headers"])) {
	for($i = 0; $i < count($info); $i++)
		$totalused += $info[$i]["size"];
}



unset($UM);

$quota_limit = load_quotalimit();
$quota_enabled = ($quota_limit)?1:0;

$smarty->assign("umTotalUsed",ceil($totalused/1024));
$smarty->assign("umQuotaEnabled",$quota_enabled);
$smarty->assign("umQuotaLimit",$quota_limit);
$usageGraph = get_usage_graphic(($totalused/1024),$quota_limit);
$smarty->assign("umUsageGraph",$usageGraph);

$exceeded = (($quota_limit) && (ceil($totalused/1024) >= $quota_limit));

// sorting arrays..


$smarty->assign("umAttachArrow",$attach_arrow);
$smarty->assign("umSubjectArrow",$subject_arrow);
$smarty->assign("umFromArrow",$fromname_arrow);
$smarty->assign("umDateArrow",$date_arrow);
$smarty->assign("umSizeArrow",$size_arrow);

$nummsg = count($headers);
if(!isset($pag) || !is_numeric(trim($pag))) $pag = 1;

$reg_pp    = $prefs["rpp"];
$start_pos = ($pag-1)*$reg_pp;
$end_pos   = (($start_pos+$reg_pp) > $nummsg)?$nummsg:$start_pos+$reg_pp;

if(($start_pos >= $end_pos) && ($pag != 1)) 
	header("Location: msglist.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=$folder&pag=".($pag-1)."\r\n");

echo($nocache);

$jsquota = ($exceeded)?"true":"false";
$jssource = $memujssource."
<script language=\"JavaScript\">
no_quota  = $jsquota;
quota_msg = '".ereg_replace("'","\\'",$quota_exceeded)."';

function readmsg(ix,read) {
	if(!read && no_quota)
		alert(quota_msg)
	else
		location = 'readmsg.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=".urlencode($folder)."&pag=$pag&ix='+ix; 
}

function movemsg() {
	if(no_quota) 
		alert(quota_msg);
	else {
		with(document.form1) { decision.value = 'move'; submit(); } 
	}
}

function delemsg() { 
	if(confirm('".ereg_replace("'","\\'",$confirm_delete)."')) {
		if(no_quota) 
			alert(quota_msg);
		else {
			with(document.form1) { decision.value = 'delete'; submit(); } 
		}
	}
}
function dropmsg() { 
	if(confirm('".ereg_replace("'","\\'",$confirm_delete)."')) {
		if(no_quota) 
			alert(quota_msg);
		else {
			with(document.form1) { decision.value = 'drop'; submit(); } 
		}
	}
}

function sel() {
	with(document.form1) {
		for(i=0;i<elements.length;i++) {
			thiselm = elements[i];
			if(thiselm.name.substring(0,3) == 'msg')
				thiselm.checked = !thiselm.checked
		}
	}
}
sort_colum = '$sortby';
sort_order = '$sortorder';

function sortby(col) {
	if(col == sort_colum) ord = (sort_order == 'ASC')?'DESC':'ASC';
	else ord = 'ASC';
	location = 'msglist.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=$folder&pag=$pag&sortby='+col+'&sortorder='+ord;
}

</script>
";


$smarty->assign("umErrorMessage",$msg);


$forms = "<input type=hidden name=lid value=$lid>
<input type=hidden name=sid value=\"$sid\">
<input type=hidden name=tid value=\"$tid\">
<input type=hidden name=decision value=delete>
<input type=hidden name=folder value=\"".htmlspecialchars($folder)."\">
<input type=hidden name=pag value=$pag>
<input type=hidden name=start_pos value=$start_pos>
<input type=hidden name=end_pos value=$end_pos>";


$smarty->assign("umJS", $jssource);
$smarty->assign("umForms", $forms);
$smarty->assign("umUserEmail", $sess["email"]);
$smarty->assign("umFolder", strtolower($folder));

$messagelist = Array();

if($nummsg > 0) {

	$newmsgs = 0;
	for($i=0;$i<count($headers);$i++)
		if(!eregi("\\SEEN",$headers[$i]["flags"])) $newmsgs++;

	if($nummsg == 1) $counttext = $msg_count_s;
	else $counttext = sprintf($msg_count_p,$nummsg);
	if($newmsgs == 1) $counttext .= $msg_unread_s;
	elseif ($newmsgs > 1) $counttext .= sprintf($msg_unread_p,$newmsgs);
	else $counttext .= $msg_no_unread;

	$counttext .= sprintf($msg_boxname,$boxname);

	for($i = $start_pos; $i< $end_pos; $i++) {
		$mnum = $headers[$i]["id"]; 

		$read = (eregi("\\SEEN",$headers[$i]["flags"]))?"true":"false";
		$readlink = "javascript:readmsg($i,$read)";
		$composelink = "newmsg.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=$folder&nameto=".urlencode($headers[$i]["from"][0]["name"])."&mailto=".urlencode($headers[$i]["from"][0]["mail"]);
		$composelinksent = "newmsg.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=$folder&nameto=".urlencode($headers[$i]["to"][0]["name"])."&mailto=".urlencode($headers[$i]["to"][0]["mail"]);

		$from = $headers[$i]["from"][0]["name"];
		$frommail = $headers[$i]["from"][0]["mail"];
		$to = $headers[$i]["to"][0]["name"];
		$tomail = $headers[$i]["to"][0]["mail"];
		
		$subject = $headers[$i]["subject"];
		if(!eregi("\\SEEN",$headers[$i]["flags"])) {
			$msg_img = "./images/msg_unread.gif";
		} elseif (eregi("\\ANSWERED",$headers[$i]["flags"])) {
			$msg_img = "./images/msg_answered.gif";
		} else {
			$msg_img = "./images/msg_read.gif";
		}
		$prior = $headers[$i]["priority"];
		if($prior == 4 || $prior == 5)
			$img_prior = "&nbsp;<img src=\"./images/prior_low.gif\" width=5 height=11 border=0 alt=\"\">";
		elseif($prior == 1 || $prior == 2)
			$img_prior = "&nbsp;<img src=\"./images/prior_high.gif\" width=5 height=11 border=0 alt=\"\">";
		else
			$img_prior = "";

		$msg_img = "&nbsp;<img src=\"$msg_img\" width=14 height=14 border=0 alt=\"\">";
		$checkbox = "<input type=\"checkbox\" name=\"msg_$i\" value=1>";
		$attachimg = ($headers[$i]["attach"])?"&nbsp;<img src=images/attach.gif border=0>":"";

		$date = $headers[$i]["date"];
		$size = ceil($headers[$i]["size"]/1024);
		$index = count($messagelist);

		$messagelist[$index]["read"] = $read;
		$messagelist[$index]["readlink"] = $readlink;
		$messagelist[$index]["composelink"] = $composelink;
		$messagelist[$index]["composelinksent"] = $composelinksent;
		$messagelist[$index]["from"] = $from;
		$messagelist[$index]["frommail"] = $frommail;
		$messagelist[$index]["to"] = $to;
		$messagelist[$index]["tomail"] = $tomail;
		$messagelist[$index]["subject"] = $subject;
		$messagelist[$index]["date"] = $date;
		$messagelist[$index]["statusimg"] = $msg_img;
		$messagelist[$index]["checkbox"] = $checkbox;
		$messagelist[$index]["attachimg"] = $attachimg;
		$messagelist[$index]["priorimg"] = $img_prior;
		$messagelist[$index]["size"] = $size;
	}

} 
$smarty->assign("umNumMessages",$nummsg);
$smarty->assign("umNumUnread",$newmsgs);
$smarty->assign("umMessageList",$messagelist);

include("./inc/imap_utf7.php");
switch(strtolower($folder)) {
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
		$display = utf7_decode($folder, $default_char_set);
		break;
}

$smarty->assign("umBoxName",$display);

$navigation = "";
if($nummsg > 0 && ceil($nummsg / $reg_pp) > 1) {
	if($pag > 1) $smarty->assign("umPreviousLink","msglist.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=$folder&pag=".($pag-1));
	
	for($i=1; $i <= ceil($nummsg/$reg_pp); $i++) {
		if($pag == $i) 
			$navigation .= "$i ";
		else 
			$navigation .= "<a href=\"msglist.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=$folder&pag=$i\" class=\"navigation\">$i</a> ";
	}
	
	if($end_pos < $nummsg) $smarty->assign("umNextLink","msglist.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=$folder&pag=".($pag+1));
	$navigation .= " ($pag/".ceil($nummsg / $reg_pp).")";
}

$smarty->assign("umNavBar", $navigation);

$avalfolders = Array();
$d = dir($userfolder);
while($entry=$d->read()) {
	if(is_dir($userfolder.$entry) 
		&& $entry != ".." && $entry != "." 
		&& $entry != $folder) {
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
			break;
		}
		$avalfolders[] = Array("path" => $entry, "display" => $display);
	}
}
$d->close();


$smarty->assign("umAllowFromUrl",$msglist_allowfromurl);
$smarty->assign("umAvalFolders",$avalfolders);
$smarty->display("$selected_theme/messagelist.htm");

?>
