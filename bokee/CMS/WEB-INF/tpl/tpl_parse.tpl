<?php
/**
 * parse_template.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author liut@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('tpl_parse.html');
//$tpl->assign($response['action_error']);
//$tpl->assign($response['form']);
//$tpl->assign($response['data']);

$tpl->assign('{HTML}',$response['html']);
die("保存成功");

$tpl->output();
?>