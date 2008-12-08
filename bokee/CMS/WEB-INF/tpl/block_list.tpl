<?php
/**
 * blcok_list.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author liut@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('block_list.html');

$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign('template_block', $response['template_block']);
$tpl->assign('channel_name', $response['channel_name']);
$tpl->assign('subject_id', $response['subject_id']);
$tpl->assign('pagebar', $response['pagebar']);
$tpl->assign('p', $response['p']);
$tpl->output();
?>