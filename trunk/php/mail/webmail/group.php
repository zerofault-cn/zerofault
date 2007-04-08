<?
/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
S鉶 Paulo - Brasil
*************************************************************************/

// load session management
require("./inc/inc.php");
require_once("./inc/userlib.php");

//获取当前帐号的邮件地址
$glist = getGroupList($sess['user']);

$jssource = $memujssource."
<script language=\"JavaScript\">

function openwin(targetUrl) { window.open(targetUrl,'CatchPublic','width=410, top=100, left=100, height=145,directories=no,toolbar=no,status=no,scrollbars=yes'); }
function openwin1(targetUrl) { window.open(targetUrl,'CatchPublic','width=410, top=100, left=100, height=250,directories=no,toolbar=no,status=no,scrollbars=yes'); }

</script>
";

$list = array();
$count = count($glist);

for($i = 0; $i < $count; $i++ )
{
	$list[$i]["gid"] = $glist[$i]["gid"];
	$list[$i]["description"] = $glist[$i]["description"];
	
	$list[$i]["mailto"] = "newmsg.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&nameto=".urlencode($list[$i]["gid"]);
	
	$memberlink = "memberlist.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&gidmail=".urlencode($list[$i]["gid"]);
	$list[$i]["memberlink"] = "javascript:openwin1('".$memberlink."')";
	
	$contactlink = "catchpublic.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&mail=".urlencode($list[$i]["gid"]);
	$list[$i]["addcontactlink"] = "javascript:openwin('".$contactlink."')";
}
$smarty->assign("grouplist",$list);

$smarty->assign("umLid", $lid);
$smarty->assign("umSid", $sid);
$smarty->assign("umTid", $tid);
$smarty->assign("umJS", $jssource);
$smarty->assign("umRetid", $retid);

$smarty->display("$selected_theme/group.htm");
?>