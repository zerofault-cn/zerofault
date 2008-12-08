<?php
/**
 * template_list.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author liut@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('template_file_list.html');
//$tpl->assign($response['action_error']);
//$tpl->assign($response['form']);
//$tpl->assign($response['data']);

$tpl->assign('TITLE', $response['stage']);
$tpl->assign('template_file_list', $response['data']);



$tpl->output();

?>