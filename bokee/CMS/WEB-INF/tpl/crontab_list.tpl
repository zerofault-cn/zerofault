<?php
/**
 * crontab_list.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('crontab_list.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign('file_list', $response['$file_list']);
$tpl->output();
?>