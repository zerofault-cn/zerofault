<?
require("./inc/inc.php");

if(!$UM->mail_connect()) { Header("Location: error.php?err=1&sid=$sid&tid=$tid&lid=$lid&retid=$retid\r\n"); exit; }
if(!$UM->mail_auth(true)) { Header("Location: badlogin.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid\r\n"); exit; }

if ($UM->mail_connected()) {
	$sess["auth"] = true;
	$SS->Save($sess);
	
	$UM->mail_disconnect();
	
	Header("Location: msglist.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid\r\n");
}else {
	Header("Location: badlogin.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid\r\n");
}

?>