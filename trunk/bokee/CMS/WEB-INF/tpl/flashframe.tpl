<?php
/**
 * flashframe.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('flashframe.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign('channel_name', $response['channel_name']);
$tpl->assign('id', $response['id']);
$tpl->output();
?>