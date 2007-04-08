<?
/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
São Paulo - Brasil
*************************************************************************/


require("./inc/inc.php");



if(isset($save)) {
	if (!$fwd_savecopy)
		$fwd_savecopy = 0;
		
	$myinfo["forwardaddress"]		= $fwd_address;
	$myinfo["forwardsavecopy"]		= $fwd_savecopy;
	save_forward($myinfo);

	$info = $myinfo;
} else {
	$info = load_forward();
}

$jssource = $memujssource;

$smarty->assign("umJS",$jssource);
$smarty->assign("umSid",$sid);
$smarty->assign("umLid",$lid);
$smarty->assign("umTid",$tid);

$smarty->assign("umForwardAddress",$info["forwardaddress"]);
$status = ($info["forwardsavecopy"] == 1)?" checked":" ";
$smarty->assign("umForwardSavecopy", $status);

$smarty->display("$selected_theme/autoforward.htm");

?>