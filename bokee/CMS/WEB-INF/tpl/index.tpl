<?php
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('index.htm');
$tpl->assign('hot_pri_cata',$response['hot_pri_cata']);
$tpl->assign('feednum', $response['data']['feednum']);
$tpl->assign('entrynum', $response['data']['entrynum']);
$tpl->assign($response['block']);
$tpl->output();
?>