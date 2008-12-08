<?php
/**
 * flash_edit.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('flash_edit.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign('flash_id',$response['flash_id']);
$tpl->assign('path',$response['path']);
$tpl->assign('root_path',$response['root_path']);
$tpl->output();
?>