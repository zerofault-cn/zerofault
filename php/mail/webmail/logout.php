<?

/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
São Paulo - Brasil
*************************************************************************/

require("./inc/inc.php");

if(is_array($sess["headers"]) && file_exists($userfolder)) {

	$inboxdir = $userfolder."INBOX/";
	
	$d = dir($temporary_directory."_attachments\\");
	while($entry=$d->read()) {
		if($entry != "." && $entry != ".."){
			$iLen = strlen($sess['user'].'_');
		 	$tmpuser = substr($entry, 0, $iLen-1);
		 	
		 	if ($tmpuser == $sess['user'])
		 		unlink($temporary_directory."_attachments\\$entry");
		}
	}
	$d->close();

	if($prefs["empty-trash"]) {
		$trash = "Trash";
		if(!is_array($sess["headers"][base64_encode($trash)])) {
			$sess["headers"][base64_encode($trash)] = $UM->mail_list_msgs($trash);
		}
		$trash = $sess["headers"][base64_encode($trash)];
		if(count($trash) > 0) {
			for($j=0;$j<count($trash);$j++) {
				$UM->mail_delete_msg($trash[$j],false);
			}
		}
	}
	$SS->Kill();
}

header("Location: index.php?retid=$retid\r\n");
?> 