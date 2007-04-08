<?
/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
São Paulo - Brasil
*************************************************************************/


// load session management
require("./inc/inc.php");

// check and create a new folder

$newfolder = trim($newfolder);
if($newfolder != "" 
	&& ereg("[A-Za-z0-9 -]",$newfolder) 
	&& !file_exists($userfolder.$newfolder)) {
	if ($UM->mail_create_box($newfolder)) {
		$boxes = $UM->mail_list_boxes();
		$sess["folders"] = $boxes;
		$SS->Save($sess);
	}
}

// check and delete the especified folder: system folders can not be deleted
$newdelfolder = strtolower($delfolder);
if(	$delfolder != "" 
	&& $newdelfolder != "inbox" && $newdelfolder != "sent" 
	&& $newdelfolder != "trash" && $newdelfolder != "draft" 
	&& (strpos($delfolder,"..") === false)) {
	if($UM->mail_delete_box($delfolder)) {
		unset($sess["headers"][base64_encode($delfolder)]);
		$boxes = $UM->mail_list_boxes();
		$sess["folders"] = $boxes;
		
		$SS->Save($sess);
	}
}

if(isset($empty)) {
	$headers = $sess["headers"][base64_encode($empty)];
	for($i=0;$i<count($headers);$i++) {
		$UM->mail_delete_msg($headers[$i],$prefs["save-to-trash"]);
		$expunge = true;
	}
	
	if($expunge) {
		unset($sess["headers"][base64_encode($empty)]);
		/* ops.. you have sent anything to trash, then you need refresh it */
		if($prefs["save-to-trash"])
			unset($sess["headers"][base64_encode("Trash")]);
		$SS->Save($sess);
	}

	if(isset($goback)) Header("Location: msglist.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=".urlencode($folder));
}

$jssource = $memujssource."
<script language=\"JavaScript\">
function create() {
	strPat = /[^A-Za-z0-9 -]/;
	frm = document.forms[0];
	strName = frm.newfolder.value
	mathArray = strName.match(strPat)
	if(mathArray != null) {
		alert('".ereg_replace("'","\\'",$error_invalid_name)."')
		return false;
	}else
		frm.submit();
}
</script>
";

$smarty->assign("umJS",$jssource);
$smarty->assign("umLid",$lid);
$smarty->assign("umTid",$tid);
$smarty->assign("umSid",$sid);
$smarty->assign("umUserEmail",$sess["email"]);


$boxes = $UM->mail_list_boxes();

$scounter = 0;
$pcounter = 0;

include("./inc/imap_utf7.php");
for($n = 0; $n < count($boxes); $n++) {
	$entry = $boxes[$n]["name"];

	$unread = 0;
	//if(!is_array($sess["headers"][base64_encode($entry)])) {
	$thisbox = $UM->mail_list_msgs($entry);
	$sess["headers"][base64_encode($entry)] = $thisbox;
	//} else 
	//	$thisbox = $sess["headers"][base64_encode($entry)];

	$boxsize = 0;
	for($i = 0; $i < count($thisbox); $i++) {
		if(!eregi("\\SEEN",$thisbox[$i]["flags"])) $unread++;
		$boxsize += $thisbox[$i]["size"];
	}

	//$boxname = $entry;

	if($unread != 0) 
		$unread = "<b>$unread</b>";

	$newentry = strtolower($entry);
	if ($newentry == "inbox" || $newentry == "sent" 
		|| $newentry == "trash" || $newentry == "draft" ) {
		switch ($newentry){
			case "inbox":
				$scounter = 0;
				$boxname = $inbox_extended;
				break;
			case "sent":
				$scounter = 1;
				$boxname = $sent_extended;
				break;
			case "trash":
				$scounter = 2;
				$boxname = $trash_extended;
				break;
			case "draft":
				$scounter = 3;
				$boxname = $draft_extended;
				break;
		}
		
		$delete = "&nbsp;";
		
		$system[$scounter]["entry"]     	= $entry;
		$system[$scounter]["name"]      	= $boxname;
		$system[$scounter]["msgs"]      	= count($thisbox)."/$unread";
		$system[$scounter]["del"]       	= $delete;
		$system[$scounter]["boxsize"]   	= ceil($boxsize/1024);
		$system[$scounter]["chlink"] 		= "msglist.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=".$entry;
		$system[$scounter]["emptylink"]		= "folders.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&empty=".$entry."&folder=".$entry;
	} else {
		$boxname = utf7_decode($entry, $default_char_set);

		$delete = "<a href=\"folders.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&delfolder=".urlencode($entry)."&folder=".urlencode($folder)."\">OK</a>";
		$personal[$pcounter]["entry"]   	= $entry;
		$personal[$pcounter]["name"]    	= $boxname;
		$personal[$pcounter]["msgs"]    	= count($thisbox)."/$unread";
		$personal[$pcounter]["del"]    		= $delete;
		$personal[$pcounter]["boxsize"]	 	= ceil($boxsize/1024);
		$personal[$pcounter]["chlink"]  	= "msglist.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&folder=".urlencode($entry);
		$personal[$pcounter]["emptylink"]	= "folders.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&empty=".urlencode($entry)."&folder=".urlencode($entry);

		$pcounter++;
	}
	$totalused += $boxsize;
}

$SS->Save($sess);

array_qsort2($personal, "entry");

for($n=0;$n<count($system);$n++)
	$umFolderList[] = $system[$n];
for($n=0;$n<count($personal);$n++)
	$umFolderList[] = $personal[$n];
	
$smarty->assign("umFolderList",$umFolderList);
$smarty->assign("umPersonal",$personal);
$smarty->assign("umTotalUsed",ceil($totalused/1024));

$quota_limit = load_quotalimit();
$quota_enabled = ($quota_limit)?1:0;

$smarty->assign("umQuotaEnabled",$quota_enabled);
$smarty->assign("umQuotaLimit",$quota_limit);
$usageGraph = get_usage_graphic(($totalused/1024),$quota_limit);
$smarty->assign("umUsageGraph",$usageGraph);
$noquota = (($totalused/1024) > $quota_limit)?1:0;
$smarty->assign("umNoQuota",$noquota);

echo($nocache);

$smarty->display("$selected_theme/folders.htm");

?>
