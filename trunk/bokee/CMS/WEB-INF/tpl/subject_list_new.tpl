<?php
/**
 * subject_list_new.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */

require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('subject_list.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign('channen_name',$response['channel_name']);
$tpl->output();
?>