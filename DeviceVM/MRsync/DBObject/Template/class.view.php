<?php
/*
#          File :   "<!!--{$tpl|lower}-->.add"
#          Type :   ""
#          Name :   "<!!--{$tpl}--> Add"
#       Version :   "1.0"
#  Created Date :   "<!!--{$smarty.now|date_format:'%Y-%m-%d'}-->"
# Modified Date :   "<!!--{$smarty.now|date_format:'%Y-%m-%d'}-->"
#       Include :   ""
#   Global Vars :   "$_SERVER[HTTP_HOST], $_SERVER[SCRIPT_NAME], $_POST[Action], $_GET[ID]"
#      Template :   "<!!--{$tpl|lower}-->.add.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
//Global Lobal
$FormAction = trim($_POST[Action]);

$serverHTTP_HOST = trim($_SERVER[HTTP_HOST]);
$serverSCRIPT_NAME = trim($_SERVER[SCRIPT_NAME]);

$get<!!--{$tpl}-->ID = trim($_GET[ID]);

if($FormAction == 'Back')
{
	$smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");	
    $smarty->display('message.htm');
}else{
	if($get<!!--{$tpl}-->ID != '')
	{
		$o<!!--{$tpl}--> = new <!!--{$tpl}-->;
		$arr = $o<!!--{$tpl}-->->View($get<!!--{$tpl}-->ID);

<!!--{section name=show loop=$columns}-->
		$smarty->assign('<!!--{$columns[show]}-->',$arr[<!!--{$columns[show]}-->]);
<!!--{/section }-->

	}else{
        $smarty->assign('gotoURL',"http://$serverHTTP_HOST$serverSCRIPT_NAME?Mod=$iModule&op=$iop");
		$smarty->assign('message',"This Data is not exist!");
		$smarty->display('message.htm');
    }
}

?>
