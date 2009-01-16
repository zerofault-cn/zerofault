<?php
/*
#          File :   "event_log.browse"
#          Type :   ""
#          Name :   "Event_Log Browse"
#       Version :   "1.0"
#  Created Date :   "2009-01-16"
# Modified Date :   "2009-01-16"
#       Include :   "PATH_Include . pagelist_html.php"
#   Global Vars :   "$_GET[page], $_SESSION[MyWork][Page]"
#      Template :   "event_log.browse.html"
#        Author :   "System <system@mdtech.com.tw>"
#        Others :   
#    
*/
// Load Config / Class / Function
require_once(PATH_Include .'pagelist_html.php'); 

$sessPage = trim($_SESSION[MyWork][Page]);
$Page = trim($_GET[page]);


if($Page != '')
{
    $_SESSION[MyWork][Page] = $Page;
}else{
    $Page = $sessPage;
}


// Navagation count Pages
$perPage = 10;

$oEvent_Log = new Event_Log;
$option = 'order by `ID` ASC ';

$amount =  $oEvent_Log->RecordCount($option);
$nav =& new Pagelist_html($Page,$amount);
$nav->set_Limit($perPage);
$start = $nav->getRange1();
$offset = $nav->getRange2();

// Get Data
$arr = $oEvent_Log->Browse($option,$offset,$start);



// assign Smarty variable
$smarty->assign('navagation', $nav->pageListStype1());
$smarty->assign('NavCount', $offset);

$smarty->assign('ID',$arr[ID]);
$smarty->assign('ETID',$arr[ETID]);
$smarty->assign('Timestamp',$arr[Timestamp]);
$smarty->assign('Source',$arr[Source]);
$smarty->assign('User',$arr[User]);
$smarty->assign('Action',$arr[Action]);
$smarty->assign('Info_XML',$arr[Info_XML]);
$smarty->assign('Description',$arr[Description]);


?>