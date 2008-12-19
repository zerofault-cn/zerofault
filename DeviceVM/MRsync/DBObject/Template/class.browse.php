<?php
/*
#          File :   "<!!--{$tpl|lower}-->.browse"
#          Type :   ""
#          Name :   "<!!--{$tpl}--> Browse"
#       Version :   "1.0"
#  Created Date :   "<!!--{$smarty.now|date_format:'%Y-%m-%d'}-->"
# Modified Date :   "<!!--{$smarty.now|date_format:'%Y-%m-%d'}-->"
#       Include :   "PATH_Include . pagelist_html.php"
#   Global Vars :   "$_GET[page], $_SESSION[MyWork][Page]"
#      Template :   "<!!--{$tpl|lower}-->.browse.html"
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

$o<!!--{$tpl}--> = new <!!--{$tpl}-->;
$option = 'order by `<!!--{$columns[0]}-->` ASC ';

$amount =  $o<!!--{$tpl}-->->RecordCount($option);
$nav =& new Pagelist_html($Page,$amount);
$nav->set_Limit($perPage);
$start = $nav->getRange1();
$offset = $nav->getRange2();

// Get Data
$arr = $o<!!--{$tpl}-->->Browse($option,$offset,$start);



// assign Smarty variable
$smarty->assign('navagation', $nav->pageListStype1());
$smarty->assign('NavCount', $offset);

<!!--{section name=show loop=$columns}-->
$smarty->assign('<!!--{$columns[show]}-->',$arr[<!!--{$columns[show]}-->]);
<!!--{/section }-->


?>