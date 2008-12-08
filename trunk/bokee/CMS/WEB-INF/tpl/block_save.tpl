<?php
/**
 * article_list.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author liut@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('block_save.html');
//$tpl->assign($response['action_error']);
//$tpl->assign($response['form']);
//$tpl->assign($response['data']);

$tpl->assign('ID', $response['save']['id']);
$tpl->assign('NAME', $response['save']['name']);

$tpl->assign('TITLE', $response['stage']);
$tpl->output();
?>