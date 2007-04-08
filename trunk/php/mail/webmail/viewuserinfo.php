<?
/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
São Paulo - Brasil
*************************************************************************/

require("./inc/inc.php");

$smarty->assign("umLid",$lid);
$smarty->assign("umSid",$sid);
$smarty->assign("umTid",$sid);

$name = trim($username);
$userinfo = LDAPuserinfo($name);

$info = array();
if($userinfo == FALSE)
{
	$info[0]["cn"] = " ";
	$info[0]["sn"] = " ";
	$info[0]["mail"] = " ";

	$info[0]["homeaddress"] = " ";
	$info[0]["homephone"] = " ";	
	$info[0]["mobile"] = " ";

	$info[0]["ou"] = " ";
	$info[0]["title"] = " ";
	$info[0]["physicaldeliveryofficename"] = " ";
	$info[0]["telephonenumber"] = " ";
}            
else         
{            
	$info[0]["cn"] = $userinfo[0]["cn"][0];
	$info[0]["sn"] = decode_utf8($userinfo[0]["sn"][0]);
	$info[0]["mail"] = $userinfo[0]["mail"][0];

	$info[0]["homeaddress"] = decode_utf8($userinfo[0]["homepostaladdress"][0]);
	$info[0]["homephone"] = decode_utf8($userinfo[0]["homephone"][0]);	
	$info[0]["mobile"] = decode_utf8($userinfo[0]["mobile"][0]);
	 
	$info[0]["ou"] = decode_utf8($userinfo[0]["ou"][0]);
	$info[0]["title"] = decode_utf8($userinfo[0]["title"][0]);
	$info[0]["physicaldeliveryofficename"] = decode_utf8($userinfo[0]["physicaldeliveryofficename"][0]);
	$info[0]["telephonenumber"] = decode_utf8($userinfo[0]["telephonenumber"][0]);	
}

$smarty->assign("userinfo",$info);
$smarty->display("$selected_theme/viewuserinfo.htm");

?>