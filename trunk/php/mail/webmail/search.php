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


$jsquota = ($exceeded)?"true":"false";
$jssource = $memujssource."
<script language=\"JavaScript\">

no_quota  = $jsquota;
quota_msg = '".ereg_replace("'","\\'",$quota_exceeded)."';
function readmsg(ix,read,folder) {
	if(!read && no_quota)
		alert(quota_msg)
	else
		location = 'readmsg.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder='+folder+'&pag=$pag&ix='+ix; 
}

</script>
";

$smarty->assign("umSid",$sid);
$smarty->assign("umLid",$lid);
$smarty->assign("umTid",$tid);
$smarty->assign("umJS",$jssource);

$smarty->assign("umInputFrom",$srcFrom);
$smarty->assign("umInputTo",$srcTo);
$smarty->assign("umInputCc",$srcCc);
$smarty->assign("umInputSubject",$srcSubject);
$smarty->assign("umInputBody",$srcBody);



if($srcFrom != "" || $srcTo != "" || $srcCc != "" ||
	$srcSubject != "" || $srcBody != "") {

	$boxes = $sess["folders"];

	for($n = 0; $n < count($boxes); $n++) {
		$entry = $boxes[$n]["name"];
		if(!is_array($sess["headers"][base64_encode($entry)])) {
			$thisbox = $UM->mail_list_msgs($entry);
			$sess["headers"][base64_encode($entry)] = $thisbox;
		} else 
			$thisbox = $sess["headers"][base64_encode($entry)];
	}

	$SS->Save($sess);

	$boxlist = $sess["headers"];

	function build_regex($strSearch) {
		$strSearch = trim($strSearch);
		if($strSearch != "") {
			$strSearch = quotemeta($strSearch);
			$arSearch = split(" ",$strSearch);
			unset($strSearch);
			for($n = 0; $n < count($arSearch); $n++)
				if($strSearch != "") 
					$strSearch .= "|(".$arSearch[$n].")";
				else 
					$strSearch .= "(".$arSearch[$n].")";
		}
		
		return $strSearch;
	}


	if(trim($srcBody) != "") $get_body = 1;
	$search_results = Array();
	$start = $smarty->_get_microtime();
	$UM->use_html = false;

	if($srcFrom != "") $srcFrom = build_regex($srcFrom);
	if($srcSubject != "") $srcSubject = build_regex($srcSubject);
	if($srcBody != "") $srcBody = build_regex($srcBody);

	while(list($current_folder,$messages) = each($boxlist)) {
		$current_folder = base64_decode($current_folder);

		for($z = 0; $z < count($messages); $z++) {
			$email = $messages[$z];
			$localname = $email["localname"];

			if($get_body && file_exists($localname)) {
				$thisfile = $UM->_read_file($localname);
				$email = $UM->Decode($thisfile);
				unset($thisfile);
			}

			$found = false;

			if($srcFrom != "") {
				$from = $email["from"];
				$srcString = "";
				for ($i = 0; $i < count($from); $i++)
					$srcString .= $from[0]["name"]." ".$from[0]["mail"];
				if(eregi($srcFrom,$srcString)) $found = true;
			}

			if($srcTo != "") {
				$to = $email["to"];
				$srcString = "";
				for ($i = 0; $i < count($to); $i++)
					$srcString .= $to[0]["to"]." ".$to[0]["mail"];
				if(eregi($srcTo,$srcString)) $found = true;
			}

			if($srcCc != "") {
				$cc = $email["cc"];
				$srcString = "";
				for ($i = 0; $i < count($cc); $i++)
					$srcString .= $cc[0]["name"]." ".$cc[0]["mail"];
				if(eregi($srcCc,$srcString)) $found = true;
			}

			if($srcSubject != "" && !$found) {
				$srcString = $email["subject"];
				if(eregi($srcSubject,$srcString)) $found = true;
			}

			if($srcBody != "" && !$found) {
				$srcString = strip_tags($email["body"]);
				if(eregi($srcBody,$srcString)) $found = true;
			}

			if($found) {
				$messages[$z]["ix"] = $z;
				$headers[] = $messages[$z];
			}
		}

	}
	
	$messagelist = Array();

	for($i = 0; $i < count($headers); $i++) {
		$mnum = $headers[$i]["id"]; 
		$read = (eregi("\\SEEN",$headers[$i]["flags"]))?"true":"false";

		$readlink = "javascript:readmsg(".$headers[$i]["ix"].",$read,'".urlencode($headers[$i]["folder"])."')";
		$composelink = "newmsg.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=$folder&nameto=".urlencode($headers[$i]["from"][0]["name"])."&mailto=".urlencode($headers[$i]["from"][0]["mail"]);
		$composelinksent = "newmsg.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=$folder&nameto=".urlencode($headers[$i]["to"][0]["name"])."&mailto=".urlencode($headers[$i]["to"][0]["name"]);
		$folderlink = "msglist.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=".urlencode($headers[$i]["folder"]);
		
		$from = $headers[$i]["from"][0]["name"];
		$to = $headers[$i]["to"][0]["name"];
		$subject = $headers[$i]["subject"];
		if(!eregi("\\SEEN",$headers[$i]["flags"])) {
			$msg_img = "./images/msg_unread.gif";
		} elseif (eregi("\\ANSWERED",$headers[$i]["flags"])) {
			$msg_img = "./images/msg_answered.gif";
		} else {
			$msg_img = "./images/msg_read.gif";
		}
		$prior = $headers[$i]["priority"];
		if($prior == 1 || $prior == 2)
			$img_prior = "&nbsp;<img src=\"./images/prior_low.gif\" width=5 height=11 border=0 alt=\"\">";
		elseif($prior == 4 || $prior == 5)
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
		$messagelist[$index]["folderlink"] = $folderlink;
		$messagelist[$index]["from"] = $from;
		$messagelist[$index]["to"] = $to;
		$messagelist[$index]["subject"] = $subject;
		$messagelist[$index]["date"] = $date;
		$messagelist[$index]["statusimg"] = $msg_img;
		$messagelist[$index]["checkbox"] = $checkbox;
		$messagelist[$index]["attachimg"] = $attachimg;
		$messagelist[$index]["priorimg"] = $img_prior;
		$messagelist[$index]["size"] = $size;
		$messagelist[$index]["folder"] = $headers[$i]["folder"];
	}
	$smarty->assign("umMessageList",$messagelist);
	unset($headers);
	$smarty->assign("umDoSearch",1);
} else {
	$smarty->assign("umDoSearch",0);
}
$smarty->assign("umAllowFromUrl",$msglist_allowfromurl);
$smarty->display("$selected_theme/search.htm");

?>
