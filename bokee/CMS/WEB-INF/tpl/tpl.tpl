<?php
/**
 * template.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author liut@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('tpl.html');
//$tpl->assign($response['action_error']);
//$tpl->assign($response['form']);
//$tpl->assign($response['data']);

$tpl->assign('showAd',$response['showAd']);
$tpl->assign('FILE',$response['file']);
$tpl->assign('ID',$response['id']);
$tpl->assign('TITLE',$response['stage']);
$tpl->assign('NAME',$response['data']['name']);
$tpl->assign('is_default',$response['is_default']);
$tpl->assign('JS',$response['data']['chanel_checked_js']);

$tpl->assign('ID',$response['data']['id']);

//print_r($response['data']['block'][0]);
//exit;
$tpl->assign('block',$response['data']['block']);
$tpl->assign('subject',$response['data']['subject']);
$tpl->assign('special',$response['data']['special']);

$tpl->assign('CHANNEL_NAME',$response['channel_name']);
$tpl->output();
?>