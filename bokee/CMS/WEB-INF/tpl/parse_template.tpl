<?php
/**
 * parse_template.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author liut@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('parse_template.html');
//$tpl->assign($response['action_error']);
//$tpl->assign($response['form']);
//$tpl->assign($response['data']);

print_r($response['html']);
$tpl->assign('{HTML}',$response['html']);

$tpl->output();
?>