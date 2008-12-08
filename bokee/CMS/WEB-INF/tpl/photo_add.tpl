<?php
/**
 * photo_add.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('photo_add.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->output();
?>