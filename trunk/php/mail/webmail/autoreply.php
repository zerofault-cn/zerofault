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
	if (!$reply_status)
		$reply_status = 0;
		
	$myinfo["autoreplystatus"]	= $reply_status;
	$myinfo["autoreplycontent"]	= $reply_content;

	save_autoreply($myinfo); 
	
	$info = $myinfo;
}else {
	$info = load_autoreply();
}

$jssource = $memujssource;

$smarty->assign("umJS",$jssource);
$smarty->assign("umSid",$sid);
$smarty->assign("umLid",$lid);
$smarty->assign("umTid",$tid);

$status = ($info["autoreplystatus"] == 1)?" checked":" ";
$smarty->assign("umAutoReplyStatus", $status);
$smarty->assign("umAutoReplyContent",htmlspecialchars($info['autoreplycontent']));



$smarty->display("$selected_theme/autoreply.htm");

?>