<?php
/**
 * subject_add.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('subject_add.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign('subject_1', $response['subject_1']);
$tpl->assign('channel_name', $response['channel_name']);
$tpl->output();
?>