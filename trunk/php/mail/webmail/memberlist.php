<?
/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
São Paulo - Brasil
*************************************************************************/

require("./inc/inc.php");
require_once("./inc/userlib.php");

$smarty->assign("umLid",$lid);
$smarty->assign("umSid",$sid);
$smarty->assign("umTid",$sid);

$gidmail = trim($gidmail);
$tmplist = getGroupMemberList($gidmail);

$mlist = array();
$count = count($tmplist);

for($i = 0; $i < $count; $i++)
{
	$mlist[$i]["mail"] = $tmplist[$i];
	
	$contactlink = "catchpublic.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&mail=".urlencode($mlist[$i]["mail"]);
	$mlist[$i]["addlink"] = $contactlink;
}

$smarty->assign("mlist",$mlist);            

$smarty->assign("userinfo",$info);
$smarty->display("$selected_theme/memberlist.htm");

?>