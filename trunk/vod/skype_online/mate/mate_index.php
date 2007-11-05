<?
ob_start();
print <<<EOT
<html>
<head>
<title></title>
<link rel="stylesheet" href="../style.css" type="text/css">
<meta http-equiv=content-type content="text/html; charset=gb2312">
<meta content="skype call center" name=keywords>
<meta content="mshtml 6.00.2600.0" name=generator>
</head>
<body onload="startclock()">
<center>
<table width="100%" border=0 cellpadding=0 cellspacing=0>
<tr>
	<td>
EOT;
include_once "../mysql_connect.php";
include_once "functions.php";
if((''!=$HTTP_GET_VARS['user_account']) && (!isset($_COOKIE['cookie_user_account']) || ''==$_COOKIE['cookie_user_account']))
{
	include_once "autologin.php";
	mateAutoLogin();
}
topInfo();
if(!isset($action) || ''==$action)
{
	$action='listuser';
}
switch($action)
{
	case "addcat1":
		include_once "category_add.php";
		addCategory1();
		break;
	case "addcat2":
		include_once "category_add.php";
		addCategory2();
		break;
	case "addgroup1":
		include_once "group_add.php";
		addGroup1();
		break;
	case "addgroup2":
		include_once "group_add.php";
		addGroup2();
		break;
	case "addfriend":
		include_once "friend_add.php";
		include_once "user_list.php";
		addFriend();
		break;
	case "category":
		include_once "category_list.php";
		listCategory();
		break;
	case "joingroup":
		include_once "group_info.php";
		joinGroup();
		break;
	case "listfriend":
		include_once "user_list.php";	
		include_once "friend_list.php";
		listFriend();
		break;
	case "listuser":
		include_once "user_list.php";
		listUser();
		break;
	case "login1":
		include_once "user_login.php";
		userLogin1();
		break;
	case "login2":
		include_once "user_login.php";
		userLogin2();
		break;
	case "logout":
		include_once "user_logout.php";
		userLogout();
		break;
	case "profile1":
		include_once "user_profile.php";
		editProfile();
		break;
	case "profile2":
		include_once "user_profile.php";
		saveProfile();
		break;
	case "register1":
		include_once "user_register.php";
		userRegister1();
		break;
	case "register2":
		include_once "user_register.php";
		userRegister2();
		break;
	case "viewgroup":
		include_once "group_info.php";
		viewGroup();
		break;
	default:
		include_once "welcome.php";
		welcome();
}
footerInfo();
print <<<EOT
</td>
</tr>
</table>
EOT;
ob_end_flush();
?>
