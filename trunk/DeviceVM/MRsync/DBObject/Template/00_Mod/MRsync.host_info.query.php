<?php
/*
#          File :   "host_info.query"
#          Type :   ""
#          Name :   "Host_Info Query"
#       Version :   "1.0"
#  Created Date :   "2009-02-13"
# Modified Date :   "2009-02-13"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_POST[Action], $_POST[FromObject]"
#      Template :   "host_info.query.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
$FormAction = trim($_POST[Action]);
//if $FormAction == Search, myFormHost_InfoSearch $_POST Variable in Search Block to setting

$serverHTTP_HOST = $_SERVER[HTTP_HOST];
$serverSCRIPT_NAME = $_SERVER[SCRIPT_NAME];

if($FormAction == 'Search')
{
	$frmKeyword = trim($_POST[Keyword]);

	//每次按下Search清掉session
	unset($_SESSION[Host_InfoSearchResult]);

	$_SESSION[Host_InfoSearchResult][Flag] = 'exist';
	$_SESSION[Host_InfoSearchResult][Keyword] = $frmKeyword;

	$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=queryresult&page=0");
	$smarty->display('message.htm');
}else{
	//每次進入該頁,就清掉 Search Sssion
	unset($_SESSION[Host_InfoSearchResult]);


	//other procedure
}

?>