<?php
/*
#          File :   "sync_xml.query"
#          Type :   ""
#          Name :   "Sync_XML Query"
#       Version :   "1.0"
#  Created Date :   "2008-12-17"
# Modified Date :   "2008-12-17"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_POST[Action], $_POST[FromObject]"
#      Template :   "sync_xml.query.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
$FormAction = trim($_POST[Action]);
//if $FormAction == Search, myFormSync_XMLSearch $_POST Variable in Search Block to setting

$serverHTTP_HOST = $_SERVER[HTTP_HOST];
$serverSCRIPT_NAME = $_SERVER[SCRIPT_NAME];

if($FormAction == 'Search')
{
	$frmKeyword = trim($_POST[Keyword]);

	//每次按下Search清掉session
	unset($_SESSION[Sync_XMLSearchResult]);

	$_SESSION[Sync_XMLSearchResult][Flag] = 'exist';
	$_SESSION[Sync_XMLSearchResult][Keyword] = $frmKeyword;

	$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=queryresult&page=0");
	$smarty->display('message.htm');
}else{
	//每次進入該頁,就清掉 Search Sssion
	unset($_SESSION[Sync_XMLSearchResult]);


	//other procedure
}

?>