<?php
/**
 * usermain.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('usermain.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign($response['user']);
$tpl->assign('str1','&lt;a href="{url}" title="{title0}"&gt;{title}&lt;/a&gt;');
$tpl->output();
?>