<?php
/*
#          File :   "<!!--{$tpl|lower}-->.query"
#          Type :   ""
#          Name :   "<!!--{$tpl}--> Query"
#       Version :   "1.0"
#  Created Date :   "<!!--{$smarty.now|date_format:'%Y-%m-%d'}-->"
# Modified Date :   "<!!--{$smarty.now|date_format:'%Y-%m-%d'}-->"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_POST[Action], $_POST[FromObject]"
#      Template :   "<!!--{$tpl|lower}-->.query.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
$FormAction = trim($_POST[Action]);
//if $FormAction == Search, myForm<!!--{$tpl}-->Search $_POST Variable in Search Block to setting

$serverHTTP_HOST = $_SERVER[HTTP_HOST];
$serverSCRIPT_NAME = $_SERVER[SCRIPT_NAME];

if($FormAction == 'Search')
{
	$frmKeyword = trim($_POST[Keyword]);

	//每次按下Search清掉session
	unset($_SESSION[<!!--{$tpl}-->SearchResult]);

	$_SESSION[<!!--{$tpl}-->SearchResult][Flag] = 'exist';
	$_SESSION[<!!--{$tpl}-->SearchResult][Keyword] = $frmKeyword;

	$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=queryresult&page=0");
	$smarty->display('message.htm');
}else{
	//每次進入該頁,就清掉 Search Sssion
	unset($_SESSION[<!!--{$tpl}-->SearchResult]);


	//other procedure
}

?>