<?php
/*
#          File :   "admin_user.queryresult"
#          Type :   ""
#          Name :   "Admin_User Query Result"
#       Version :   "1.0"
#  Created Date :   "2008-12-17"
# Modified Date :   "2008-12-17"
#       Include :   "PATH_Include . pagelist_html.php"
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_SESSION[Admin_UserSearchResult][Flag], $_SESSION[Admin_UserSearchResult][Keyword], $_SESSION[MyWork][Page], $_POST[Action], $_GET[page]"
#      Template :   "admin_user.queryresult.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
require_once(PATH_Include .'pagelist_html.php'); 

$FormAction = trim($_POST[Action]);

$sessFlag = trim($_SESSION[Admin_UserSearchResult][Flag]);
$sessKeyword = trim($_SESSION[Admin_UserSearchResult][Keyword]);
$sessPage = trim($_SESSION[MyWork][Page]);

$serverHTTP_HOST = $_SERVER[HTTP_HOST];
$serverSCRIPT_NAME = $_SERVER[SCRIPT_NAME]

$Page = trim($_GET[page]);

if($FormAction == 'Back')
{
	$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=query");	
	$smarty->display('message.htm');
	
}else{
	if($sessFlag == 'exist')
	{
		if($Page != '')
		{
			$_SESSION[MyWork][Page] = $Page;
		}else{
			$Page = $sessPage;
		}


		//Result
		if($sessKeyword != '')
		{
			$sql = " where (`Name` like '%" . $sessKeyword . "%' or `Description` like '%" . $sessKeyword . "%')";
		}else{
			$sql = '';
		}


		// Navagation count Pages
		$perPage = 10;


		$oAdmin_User = new Admin_User;
		$option = $sql . "order by `ID` ASC";

		$amount =  $oAdmin_User->RecordCount($option);
		$nav =& new Pagelist_html($Page,$amount);
		$nav->set_Limit($perPage);
		$start = $nav->getRange1();
		$offset = $nav->getRange2();

		// Get Data
		$arr = $oAdmin_User->Browse($option,$offset,$start);


		// assign Smarty variable
		$smarty->assign('navagation', $nav->pageListStype1());

		$smarty->assign('ID',$arr[ID]);
		$smarty->assign('Type',$arr[Type]);
		$smarty->assign('Role',$arr[Role]);
		$smarty->assign('Username',$arr[Username]);
		$smarty->assign('Password',$arr[Password]);
		$smarty->assign('PassValidate',$arr[PassValidate]);
		$smarty->assign('PassChangeTime',$arr[PassChangeTime]);
		$smarty->assign('Name',$arr[Name]);
		$smarty->assign('EMail',$arr[EMail]);
		$smarty->assign('Memo',$arr[Memo]);
		$smarty->assign('CreateTime',$arr[CreateTime]);
		$smarty->assign('LastLoginTime',$arr[LastLoginTime]);
		$smarty->assign('LastLoginIP',$arr[LastLoginIP]);
	}else{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=query");
		$smarty->assign('message',"You Don't select Search Condition !!");
		$smarty->display('message.htm');
	}
}
?>