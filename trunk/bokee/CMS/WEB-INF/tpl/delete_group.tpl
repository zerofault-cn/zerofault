<?php
/**
 * delete_group.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('delete_group.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign('channel_name', $_REQUEST['channel_name']);
$tpl->assign('subject_id', $_REQUEST['subject_id']);
$tpl->output();
?>