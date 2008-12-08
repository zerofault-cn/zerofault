<?php
/**
 * block_hotcomment_modify.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author liut@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('block_hotcomment_modify.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign($response['radio_is_group']);
$tpl->assign($response['html_source']);
$tpl->output();

?>