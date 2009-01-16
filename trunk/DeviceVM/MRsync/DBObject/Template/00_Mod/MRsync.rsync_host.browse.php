<?php
/*
#          File :   "rsync_host.browse"
#          Type :   ""
#          Name :   "Rsync_Host Browse"
#       Version :   "1.0"
#  Created Date :   "2009-01-16"
# Modified Date :   "2009-01-16"
#       Include :   "PATH_Include . pagelist_html.php"
#   Global Vars :   "$_GET[page], $_SESSION[MyWork][Page]"
#      Template :   "rsync_host.browse.html"
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

$oRsync_Host = new Rsync_Host;
$option = 'order by `ID` ASC ';

$amount =  $oRsync_Host->RecordCount($option);
$nav =& new Pagelist_html($Page,$amount);
$nav->set_Limit($perPage);
$start = $nav->getRange1();
$offset = $nav->getRange2();

// Get Data
$arr = $oRsync_Host->Browse($option,$offset,$start);



// assign Smarty variable
$smarty->assign('navagation', $nav->pageListStype1());
$smarty->assign('NavCount', $offset);

$smarty->assign('ID',$arr[ID]);
$smarty->assign('Name',$arr[Name]);
$smarty->assign('Host',$arr[Host]);
$smarty->assign('Path',$arr[Path]);
$smarty->assign('Description',$arr[Description]);


?>