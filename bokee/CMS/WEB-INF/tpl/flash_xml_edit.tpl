<?php
/**
 * include_modify.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('flash_xml_edit.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign('channel_name', $response['channel_name']);
$tpl->assign('path', $response['path']);
$tpl->assign('id', $response['id']);
$tpl->output();
?>