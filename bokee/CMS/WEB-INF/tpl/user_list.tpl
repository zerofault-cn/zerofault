<?php
/**
 * user_list.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('user_list.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign('user', $response['user']);
$tpl->assign('pagebar', $response['pagebar']);
$tpl->assign('p', $response['p']);
$tpl->output();
?>