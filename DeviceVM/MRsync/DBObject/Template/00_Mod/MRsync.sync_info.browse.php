<?php
/*
#          File :   "sync_info.browse"
#          Type :   ""
#          Name :   "Sync_Info Browse"
#       Version :   "1.0"
#  Created Date :   "2009-02-13"
# Modified Date :   "2009-02-13"
#       Include :   "PATH_Include . pagelist_html.php"
#   Global Vars :   "$_GET[page], $_SESSION[MyWork][Page]"
#      Template :   "sync_info.browse.html"
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

$oSync_Info = new Sync_Info;
$option = 'order by `ID` ASC ';

$amount =  $oSync_Info->RecordCount($option);
$nav =& new Pagelist_html($Page,$amount);
$nav->set_Limit($perPage);
$start = $nav->getRange1();
$offset = $nav->getRange2();

// Get Data
$arr = $oSync_Info->Browse($option,$offset,$start);



// assign Smarty variable
$smarty->assign('navagation', $nav->pageListStype1());
$smarty->assign('NavCount', $offset);

$smarty->assign('ID',$arr[ID]);
$smarty->assign('Sync_ID',$arr[Sync_ID]);
$smarty->assign('Path',$arr[Path]);
$smarty->assign('Filename',$arr[Filename]);


?>