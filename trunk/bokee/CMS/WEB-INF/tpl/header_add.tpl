<?php
/**
 * header_add.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author zhangfang@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('header_add.html');
$tpl->assign('options', $response['options']);
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign('subject_id', $response['subject_id']);
$tpl->assign('channel_name', $response['channel_name']);
$tpl->assign('parent_id', $response['parent_id']);
$tpl->assign('subject_name', $response['subject_name']);
$tpl->assign('datetime', $response['datetime']);
$tpl->assign('options', $response['options']);
$tpl->assign('sort', $response['sort']);
$tpl->output();
?>