<?php
/**
 * template_modify.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('template_modify_Look.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['slashes']);
$tpl->assign($response['template']);
$tpl->assign('defaulttlist', $response['defaulttlist']);
$tpl->assign('is_more', $response['is_more']);
$tpl->output();
?>