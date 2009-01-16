<?php
/*
#          File :   "sync_xml.queryresult"
#          Type :   ""
#          Name :   "Sync_XML Query Result"
#       Version :   "1.0"
#  Created Date :   "2009-01-16"
# Modified Date :   "2009-01-16"
#       Include :   "PATH_Include . pagelist_html.php"
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_SESSION[Sync_XMLSearchResult][Flag], $_SESSION[Sync_XMLSearchResult][Keyword], $_SESSION[MyWork][Page], $_POST[Action], $_GET[page]"
#      Template :   "sync_xml.queryresult.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
require_once(PATH_Include .'pagelist_html.php'); 

$FormAction = trim($_POST[Action]);

$sessFlag = trim($_SESSION[Sync_XMLSearchResult][Flag]);
$sessKeyword = trim($_SESSION[Sync_XMLSearchResult][Keyword]);
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


		$oSync_XML = new Sync_XML;
		$option = $sql . "order by `ID` ASC";

		$amount =  $oSync_XML->RecordCount($option);
		$nav =& new Pagelist_html($Page,$amount);
		$nav->set_Limit($perPage);
		$start = $nav->getRange1();
		$offset = $nav->getRange2();

		// Get Data
		$arr = $oSync_XML->Browse($option,$offset,$start);


		// assign Smarty variable
		$smarty->assign('navagation', $nav->pageListStype1());

		$smarty->assign('ID',$arr[ID]);
		$smarty->assign('User_ID',$arr[User_ID]);
		$smarty->assign('Host_ID',$arr[Host_ID]);
		$smarty->assign('Filename',$arr[Filename]);
		$smarty->assign('Content',$arr[Content]);
		$smarty->assign('Create_Time',$arr[Create_Time]);
		$smarty->assign('Modify_Time',$arr[Modify_Time]);
		$smarty->assign('status',$arr[status]);
	}else{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=query");
		$smarty->assign('message',"You Don't select Search Condition !!");
		$smarty->display('message.htm');
	}
}
?>