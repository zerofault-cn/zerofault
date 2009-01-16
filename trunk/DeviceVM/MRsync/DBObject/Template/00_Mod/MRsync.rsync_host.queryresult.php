<?php
/*
#          File :   "rsync_host.queryresult"
#          Type :   ""
#          Name :   "Rsync_Host Query Result"
#       Version :   "1.0"
#  Created Date :   "2009-01-16"
# Modified Date :   "2009-01-16"
#       Include :   "PATH_Include . pagelist_html.php"
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_SESSION[Rsync_HostSearchResult][Flag], $_SESSION[Rsync_HostSearchResult][Keyword], $_SESSION[MyWork][Page], $_POST[Action], $_GET[page]"
#      Template :   "rsync_host.queryresult.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
require_once(PATH_Include .'pagelist_html.php'); 

$FormAction = trim($_POST[Action]);

$sessFlag = trim($_SESSION[Rsync_HostSearchResult][Flag]);
$sessKeyword = trim($_SESSION[Rsync_HostSearchResult][Keyword]);
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


		$oRsync_Host = new Rsync_Host;
		$option = $sql . "order by `ID` ASC";

		$amount =  $oRsync_Host->RecordCount($option);
		$nav =& new Pagelist_html($Page,$amount);
		$nav->set_Limit($perPage);
		$start = $nav->getRange1();
		$offset = $nav->getRange2();

		// Get Data
		$arr = $oRsync_Host->Browse($option,$offset,$start);


		// assign Smarty variable
		$smarty->assign('navagation', $nav->pageListStype1());

		$smarty->assign('ID',$arr[ID]);
		$smarty->assign('Name',$arr[Name]);
		$smarty->assign('Host',$arr[Host]);
		$smarty->assign('Path',$arr[Path]);
		$smarty->assign('Description',$arr[Description]);
	}else{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=query");
		$smarty->assign('message',"You Don't select Search Condition !!");
		$smarty->display('message.htm');
	}
}
?>