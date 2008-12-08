<?php
/**
 * subject_list_new.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author Tom@bokee.com
 */

require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('subject_serch_do.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign('result',$response['result']);

$tpl->output();
?>