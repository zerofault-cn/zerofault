<?php
/*
#          File :   "host_info.queryresult"
#          Type :   ""
#          Name :   "Host_Info Query Result"
#       Version :   "1.0"
#  Created Date :   "2008-12-17"
# Modified Date :   "2008-12-17"
#       Include :   "PATH_Include . pagelist_html.php"
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_SESSION[Host_InfoSearchResult][Flag], $_SESSION[Host_InfoSearchResult][Keyword], $_SESSION[MyWork][Page], $_POST[Action], $_GET[page]"
#      Template :   "host_info.queryresult.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
require_once(PATH_Include .'pagelist_html.php'); 

$FormAction = trim($_POST[Action]);

$sessFlag = trim($_SESSION[Host_InfoSearchResult][Flag]);
$sessKeyword = trim($_SESSION[Host_InfoSearchResult][Keyword]);
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


		$oHost_Info = new Host_Info;
		$option = $sql . "order by `ID` ASC";

		$amount =  $oHost_Info->RecordCount($option);
		$nav =& new Pagelist_html($Page,$amount);
		$nav->set_Limit($perPage);
		$start = $nav->getRange1();
		$offset = $nav->getRange2();

		// Get Data
		$arr = $oHost_Info->Browse($option,$offset,$start);


		// assign Smarty variable
		$smarty->assign('navagation', $nav->pageListStype1());

		$smarty->assign('ID',$arr[ID]);
		$smarty->assign('Host',$arr[Host]);
		$smarty->assign('Path',$arr[Path]);
		$smarty->assign('Sync_ID',$arr[Sync_ID]);
	}else{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=query");
		$smarty->assign('message',"You Don't select Search Condition !!");
		$smarty->display('message.htm');
	}
}
?>