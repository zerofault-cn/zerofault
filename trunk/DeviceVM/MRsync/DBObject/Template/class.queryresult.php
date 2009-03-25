<?php
/*
#          File :   "<!!--{$tpl|lower}-->.queryresult"
#          Type :   ""
#          Name :   "<!!--{$tpl}--> Query Result"
#       Version :   "1.0"
#  Created Date :   "<!!--{$smarty.now|date_format:'%Y-%m-%d'}-->"
# Modified Date :   "<!!--{$smarty.now|date_format:'%Y-%m-%d'}-->"
#       Include :   "PATH_Include . pagelist_html.php"
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_SESSION[<!!--{$tpl}-->SearchResult][Flag], $_SESSION[<!!--{$tpl}-->SearchResult][Keyword], $_SESSION[MyWork][Page], $_POST[Action], $_GET[page]"
#      Template :   "<!!--{$tpl|lower}-->.queryresult.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
require_once(PATH_Include .'pagelist_html.php'); 

$FormAction = trim($_POST[Action]);

$sessFlag = trim($_SESSION[<!!--{$tpl}-->SearchResult][Flag]);
$sessKeyword = trim($_SESSION[<!!--{$tpl}-->SearchResult][Keyword]);
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


		$o<!!--{$tpl}--> = new <!!--{$tpl}-->;
		$option = $sql . "order by `<!!--{$columns[0]}-->` ASC";

		$amount =  $o<!!--{$tpl}-->->RecordCount($option);
		$nav =& new Pagelist_html($Page,$amount);
		$nav->set_Limit($perPage);
		$start = $nav->getRange1();
		$offset = $nav->getRange2();

		// Get Data
		$arr = $o<!!--{$tpl}-->->Browse($option,$offset,$start);


		// assign Smarty variable
		$smarty->assign('navagation', $nav->pageListStype1());

<!!--{section name=show loop=$columns}-->
		$smarty->assign('<!!--{$columns[show]}-->',$arr[<!!--{$columns[show]}-->]);
<!!--{/section }-->
	}else{
		$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=query");
		$smarty->assign('message',"You Don't select Search Condition !!");
		$smarty->display('message.htm');
	}
}
?>
