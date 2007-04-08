<?
/************************************************************************
UebiMiau is a GPL'ed software developed by 

 - Aldoir Ventura - aldoir@users.sourceforge.net
 - http://uebimiau.sourceforge.net

Fell free to contact, send donations or anything to me :-)
S鉶 Paulo - Brasil
*************************************************************************/

@set_time_limit(0);

require("./inc/config.php");

if (strpos(strtolower($HTTP_SERVER_VARS["HTTP_ACCEPT_ENCODING"]),'gzip') !== false 
	&& $html_compress != "false"){
	@ob_start("ob_gzhandler"); 
}

require("./inc/class.uebimiau.php");
require("./inc/lib.php");
require("./inc/reguser.php");
define("SMARTY_DIR","./smarty/");
require_once(SMARTY_DIR."Smarty.class.php");

$smarty = new Smarty;
$smarty->security=true;
$smarty->secure_dir=array("./");
$smarty->compile_dir = $temporary_directory;
$smarty->assign("umLanguageFile",$selected_language.".txt");

//产生随机数
srand((double)microtime()*1000000);
$retid = rand();

load_initconfig();
$mail_servers = load_alldomain();

if ($allow_register == 0){
	Header("Location: index.php"); 
	exit;
} 

$iShowType = 0;
if(isset($save)) 
{	
	$domain = $mail_servers[$six]["domain"];
	$f_user = strtolower($f_user);
	$login_type = $mail_servers[$six]["login_type"];
	
	if($login_type != "") 
		$f_email = eregi_replace("%user%",$f_user,eregi_replace("%domain%",$domain,$login_type));
	else
		$f_email = $f_user;
		
	if ($mail_servers[$six]["allowregister"] == 0)
	{
		Header("Location: index.php"); 
		exit;
	}
	
	$admin_confirm = $mail_servers[$six]["adminconfirm"];
	$send_notify_mail = $mail_servers[$six]["sendnotifymail"];
	$mailquota_limit = $mail_servers[$six]["maxmailboxquota"];
	$mailtotal_limit = $mail_servers[$six]["maxmailboxmailnum"];
	$admin_address = $mail_servers[$six]["adminmailbox"];
	$public_info = $mail_servers[$six]["publicuserinfo"];

	if (!empty($mail_servers[$six]["mailboxstorage"]) && $mail_servers[$six]["usedmailboxstorage"]+($mail_servers[$six]["minmailboxquota"]/1024) > $mail_servers[$six]["mailboxstorage"])
	{
		$iRet = 5;
	}
	else if (!empty($mail_servers[$six]["mailboxtotal"]) && $mail_servers[$six]["usedmailboxtotal"] >= $mail_servers[$six]["mailboxtotal"])
	{
		$iRet = 6;
	}
	else 
	{
		if (empty($mailquota_limit) 
			|| (!empty($mail_servers[$six]["mailboxstorage"]) 
					&& $mail_servers[$six]["usedmailboxstorage"]+($mailquota_limit/1024) > $mail_servers[$six]["mailboxstorage"])
			||	$mailquota_limit < $mail_servers[$six]["minmailboxquota"])
			$mailquota_limit = $mail_servers[$six]["minmailboxquota"];
	
		$info['user'] = $f_user;
		$info['domain'] = $domain;
		if ($login_type != ""){
			if (strpos($login_type, '@') === false)
				$info['domain'] = "";
			else
				$info['domain'] = $domain;
		}
		else
			$info['domain'] = "";
		
		$info['email'] = $f_email;
		$info['password'] = '{md5}'.md5($f_password);
		$info['fullname'] = substr($f_fullname, 0, 120);
		$info['description'] = substr($f_description, 0, 250);
		$info['mailquota'] = $mailquota_limit;
		$info['mailtotal'] = $mailtotal_limit;
		
		//ldap begin
		$info['uid'] = $f_email;
		$info['mail'] = $f_user.'@'.$domain;
		
		if ($public_info != 0)
			$info['publicinfo'] = 1;
		else
			$info['publicinfo'] = 0;
		
		$info['homeaddress'] = substr(trim($f_homeaddress), 0, 256);
		$info['homephone']   = substr(trim($f_homephone), 0, 32);
		$info['mobile']      = substr(trim($f_mobile), 0, 32);
		$info['organizationunit'] = substr(trim($f_organizationunit), 0, 128);
		$info['jobtitle'] = substr(trim($f_jobtitle), 0, 128);
		$info['office'] = substr(trim($f_office), 0, 128);
		$info['officephone'] = substr(trim($f_officephone), 0, 32);
		$info['userpassword'] = substr(trim($f_password), 0, 32);
		
		if($info["publicinfo"] == 1)
		{
			if(LDAPAddUser($info) == false)
				$info["publicinfo"] = 0;
		}
		//ldap end
							
		$iRet = add_user($info, $admin_confirm);
	}

	if ($iRet == 0){
		unset($info);
		$info['mailquota'] = $mailquota_limit;
		$info['domain'] = $domain;
		add_domain_usedstorage($info);
		
		include("./inc/class.smtp.php");
		load_initconfig();
		
		if($admin_confirm){
			if($send_notify_mail){
				$mail = new phpmailer;
				
				$mail->CharSet		= $default_char_set;
				$mail->IPAddress	= getenv("REMOTE_ADDR");
				$mail->timezone		= $server_time_zone;
				$mail->From 		= $admin_address;
				$mail->FromName 	= $admin_address;
				$mail->Host 		= $smtp_server;
				$mail->Port 		= $smtp_port;
				$mail->WordWrap 	= 76;
				$mail->AddAddress($admin_address, $admin_address);
				$mail->Subject = $register_notify_subject;
				$body = str_replace("%mail", $f_user.'@'.$domain, $register_notify_content);
				$mail->Body = $body;
				$mail->Send();
			}
		}
		else {
			$mail = new phpmailer;
				
			$mail->CharSet		= $default_char_set;
			$mail->IPAddress	= getenv("REMOTE_ADDR");
			$mail->timezone		= $server_time_zone;
			$mail->From 		= $postmaster_address;
			$mail->FromName 	= $postmaster_address;
			$mail->Host 		= $smtp_server;
			$mail->Port 		= $smtp_port;
			$mail->WordWrap 	= 76;
			$mail->AddAddress($f_user.'@'.$domain, $f_user);
			
			if (empty($congratulate_subject) || empty($congratulate_content)){
				$subject = $register_welcome_subject;
				$body = $register_welcome_content;
			}
			else {
				$subject = $congratulate_subject;
				$body = $congratulate_content;
			}
			
			$body = str_replace("%user%", $f_user, $body);
			$body = str_replace("%mail%", $f_user.'@'.$domain, $body);
			
			$mail->Subject = $subject;
			$mail->Body = $body;
			$mail->Send();
		}
		
		$iShowType = 1;
	}
	else
	{
		$iShowType = -1;
		$iErrorCode = $iRet;
	}
}

$jssource = "";


$aval_servers = count($mail_servers);
$smarty->assign("umAvailableServers",$aval_servers);
		
if(!$aval_servers) die("You must set at least one domain, please review setup your mail server");

$iPos = strpos($HTTP_SERVER_VARS["HTTP_HOST"], ':');
if ($iPos !== false)
	$strVisitHost = substr($HTTP_SERVER_VARS["HTTP_HOST"], 0, $iPos);
else
	$strVisitHost = $HTTP_SERVER_VARS["HTTP_HOST"];

$directly_visit = false;
for($i = 0; $i < $aval_servers; $i++) {
	$strUrl = $mail_servers[$i]["directlyvisiturl"];
	if (strtolower(substr($strUrl, 0, 7)) == "http://")
		$strUrl = substr($strUrl, 7);
		
	if (strtolower(substr($strUrl, 0, 8)) == "https://")
		$strUrl = substr($strUrl, 8);
	
	$iPos = strpos($strUrl, '/');
	if ($iPos !== false)
		$strUrl = substr($strUrl, 0, $iPos);

	$iPos = strpos($strUrl, ':');
	if ($iPos !== false)
		$strUrl = substr($strUrl, 0, $iPos);

	if($strUrl != '' && ($strUrl == $strVisitHost || $strUrl == $HTTP_SERVER_VARS["QUERY_STRING"])){
		$allow_register = $mail_servers[$i]["allowregister"];
		$strServers = "@".$mail_servers[$i]["domain"]." <input type=hidden name=six value=$i>";
		$directly_visit = true;
		break;
	}
}

if ($directly_visit === false){
	if ($aval_servers == 1) {
		$strServers = "@".$mail_servers[0]["domain"]." <input type=hidden name=six value=0>";
	} else {
		$strServers = "@<select name=six>\r";
		for($i = 0; $i < $aval_servers; $i++) {
			$sel = ($i == $six) ? " selected" : "";
			if ($mail_servers[$i]["allowregister"])
				$strServers .= "<option value=$i$sel>".$mail_servers[$i]["domain"]."\r";
		}
		$strServers .= "</select>\r";
	}
}else {
	if ($allow_register == 0){
		Header("Location: index.php"); 
		exit;
	} 
}

$smarty->assign("umJS",$jssource);
$smarty->assign("umLid",$lid);
$smarty->assign("umTid",$tid);

$smarty->assign("umShowType",$iShowType);
$smarty->assign("umErrorCode",$iErrorCode);
$smarty->assign("umNeedAffirm",$admin_confirm);

$smarty->assign("umServer",$strServers);
$smarty->assign("umUser",$f_user);
$smarty->assign("umDomain",$domain);
$smarty->assign("umFullName",$f_fullname);
$smarty->assign("umDescription",$f_description);

//ldap 个人信息
if($f_publicinfo == "")
	$temp = "  ";
else
	$temp = "checked";

$smarty->assign("umPublicInfo",$temp);

$smarty->assign("umHomeAddress", $f_homeaddress);
$smarty->assign("umHomePhone", $f_homephone);
$smarty->assign("umMobile", $f_mobile);

$smarty->assign("umOrganizationUnit", $f_organizationunit);
$smarty->assign("umJobTitle", $f_jobtitle);
$smarty->assign("umOffice", $f_office);
$smarty->assign("umOfficePhone", $f_officephone);
//ldap                                                 

$smarty->display("$selected_theme/register.htm");
?>