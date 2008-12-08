<?php
/**
 * header_list.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author zhangfang@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('header_list.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign('headers',$response['headers']);
$tpl->assign('pagebar', $response['pagebar']);
$tpl->assign('channel_name', $response['channel_name']);
$tpl->assign('p', $response['p']);
$tpl->output();
?>