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

$showType = 0;
$errorType == 0;
if (!isset($saveflag))
{
	$newinfo = getUserInfo($sess["user"]);
	
	if ($newinfo === false)
	{
		$showType = 1;
		$errorType == -1;
	}
	
	$newinfo["uid"] = $sess["user"];
	$newinfo["user"] = $sess["user"];
	$newinfo["mail"] = $sess["email"];
}
else
{
	//获取表单信息
	$newinfo["uid"] = $sess["user"];
	$newinfo["user"] = $sess["user"];
	$newinfo["mail"] = $sess["email"];

	if($m_name == "")
		$newinfo["name"] = "";
	else
		$newinfo["name"] = substr($m_name, 0, 64);
	if($m_fullname == "")
		$newinfo["fullname"] = "";
	else
		$newinfo["fullname"] = substr($m_fullname, 0, 120);
	if($m_description == "")
		$newinfo["description"] = "";
	else
		$newinfo["description"] = substr($m_description, 0, 250);
	
	$newinfo["publicinfo"] = $m_publicinfo;

	if($m_homeaddress == "")
		$newinfo["homeaddress"] = "";
	else
		$newinfo["homeaddress"] = substr($m_homeaddress, 0, 256);	
	if($m_homephone == "")
		$newinfo["homephone"] = "";
	else
		$newinfo["homephone"] = substr($m_homephone, 0, 32);
	if($m_mobile == "")
		$newinfo["mobile"] = "";
	else
		$newinfo["mobile"] = substr($m_mobile, 0, 32);
	if($m_organizationunit == "")
		$newinfo["organizationunit"] = "";
	else
		$newinfo["organizationunit"] = substr($m_organizationunit, 0, 128);
	if($m_jobtitle == "")
		$newinfo["jobtitle"] = "";
	else
		$newinfo["jobtitle"] = substr($m_jobtitle, 0, 128);
	if($m_office == "")
		$newinfo["office"] = "";
	else
		$newinfo["office"] = substr($m_office, 0, 128);
	if($m_officephone == "")
		$newinfo["officephone"] = "";
	else
		$newinfo["officephone"] = substr($m_officephone, 0, 32);
		
	$newinfo["userpassword"] = $sess["pass"];
	
	if ($newinfo["publicinfo"] == 1){
		if (LDAPModifyUser($newinfo))
			$newinfo["publicinfo"] = 1;
		else
			$newinfo["publicinfo"] = 0;
	}
	else {
		LDAPDelUser($newinfo["uid"]);
	}
	
	$showType = 1;
	if (modifyUserInfo($newinfo))
		$errorType == 0;
	else
		$errorType == 1;
}

$jssource = $memujssource;

//赋值，准备显示
$smarty->assign("info_user", $newinfo["user"]);
$smarty->assign("info_name", $newinfo["name"]);
$smarty->assign("info_fullname", $newinfo["fullname"]);
$smarty->assign("info_description", $newinfo["description"]);
 
if($newinfo["publicinfo"] == 1)
	$smarty->assign("info_publicinfo", "1");
else
	$smarty->assign("info_publicinfo", "0");

$smarty->assign("info_homeaddress", $newinfo["homeaddress"]);
$smarty->assign("info_homephone", $newinfo["homephone"]);
$smarty->assign("info_mobile", $newinfo["mobile"]);
$smarty->assign("info_organizationunit", $newinfo["organizationunit"]);
$smarty->assign("info_jobtitle", $newinfo["jobtitle"]);
$smarty->assign("info_office", $newinfo["office"]);
$smarty->assign("info_officephone", $newinfo["officephone"]);

$smarty->assign("showtype", $showType);
$smarty->assign("errortype", $errorType);

$smarty->assign("umLid", $lid);
$smarty->assign("umSid", $sid);
$smarty->assign("umTid", $tid);
$smarty->assign("umJS", $jssource);
$smarty->assign("umRetid", $retid);
$smarty->assign("umGoBack","addressbook.php?sid=$sid&tid=$tid&lid=$lid&retid=$retid");

$smarty->display("$selected_theme/userinfo.htm");
?>