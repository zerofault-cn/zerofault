<?php
/**
 * subject_modify.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('subject_modify.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign('subname', $response['name']);
$tpl->assign('dir_name', $response['dir_name']);
$tpl->assign('id', $response['id']);
$tpl->assign('list', $response['list']);
$tpl->assign('categorylist', $response['categorylist']);
$tpl->assign('channel_name', $response['channel_name']);
$tpl->output();
?>