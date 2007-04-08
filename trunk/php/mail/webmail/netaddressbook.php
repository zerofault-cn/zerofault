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
// keep cache clean
//echo($nocache);

$ldapsearchword = trim($ldapsearchword);
if($ldapflag == "")
   $ldapflag = 0;
   
$info = LDAPQueryResult($ldapsearchword,$ldapflag);

if($info == FALSE )
    $infocount = 0;
else
    $infocount = $info["count"];

$ldap_pagesize    = $prefs["rpp"];
$pagecount = $infocount / $ldap_pagesize;
$tmp = $infocount % $ldap_pagesize;
if($tmp != 0)
   $tmp = 1;
$pagecount = intval($pagecount) + $tmp;

if($ldappageid=="")   
   $ldappageid = 1;

if($ldappageid > 1)
   $ldappageforward = $ldappageid -1;
else
   $ldappageforward = 1;

if($ldappageid < $pagecount)
   $ldappagenext = $ldappageid +1;
else
   $ldappagenext = $pagecount;
   
$jssource = $memujssource."
<script language=\"JavaScript\">

function openwin(targetUrl) { window.open(targetUrl,'CatchPublic','width=410, top=100, left=100, height=145,directories=no,toolbar=no,status=no,scrollbars=yes'); }
function openwin1(targetUrl) { window.open(targetUrl,'CatchPublic','width=410, top=100, left=100, height=250,directories=no,toolbar=no,status=no,scrollbars=yes'); }

</script>
";

$smarty->assign("umLid",$lid);
$smarty->assign("umSid",$sid);
$smarty->assign("umTid",$tid);
$smarty->assign("umJS",$jssource);
$smarty->assign("umRetid",$retid);
$smarty->assign("umGoBack","addressbook.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid");

$forwardlink = "netaddressbook.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&ldapsearchword=$ldapsearchword&ldappageid=$ldappageforward";
$nextlink    = "netaddressbook.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&ldapsearchword=$ldapsearchword&ldappageid=$ldappagenext";

$infostart = $ldap_pagesize * ($ldappageid -1 );

$forend = $infocount - $infostart ;
if($forend > $ldap_pagesize)
    $forend = $ldap_pagesize;

$netulist= array();

for($i=0; $i < $forend; $i++)
{
	$j = $infostart + $i;		
	$netulist[$i]["name"]  = $info[$j]["cn"][0];
	$netulist[$i]["mail"]  = $info[$j]["mail"][0];
	$netulist[$i]["phone"] = decode_utf8($info[$j]["telephonenumber"][0]);	
	$netulist[$i]["maillink"] = "newmsg.php?nameto=".urlencode($info[$j]["cn"][0])."&mailto=".urlencode($info[$j]["mail"][0])."&sid=$sid&tid=$tid&lid=$lid&retid=$retid";

	$contactlink = "catchpublic.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&name=".urlencode($netulist[$i]["name"])."&mail=".urlencode($netulist[$i]["mail"])."&phone=".urlencode($netulist[$i]["phone"]);
	$netulist[$i]["addcontactlink"] = "javascript:openwin('".$contactlink."')";
	
	$viewlink = "viewuserinfo.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&username=".urlencode($netulist[$i]["mail"]);
	$netulist[$i]["viewlink"] = "javascript:openwin1('".$viewlink."')";
}

$linklist = array();
$linklist["100"] = "netaddressbook.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid";
for($i = 0;$i < 26 ;$i++)
{
	$linklist[$i] = "netaddressbook.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid&ldapflag=1&ldapsearchword=".chr(ord("A")+$i);	
} 

$smarty->assign("netulist", $netulist);
$smarty->assign("linklist", $linklist);
$smarty->assign("forwardlink", $forwardlink);
$smarty->assign("nextlink", $nextlink);

$smarty->assign("havenav", $pagecount > 1 ? 1 : 0);

$smarty->display("$selected_theme/netaddressbook.htm");
?>