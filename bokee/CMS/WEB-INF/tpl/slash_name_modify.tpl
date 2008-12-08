<?php
/**
 * slash_name_modify.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('slash_name_modify.html');
$tpl->assign('slash_name',$response['slash_name']);
$tpl->assign('channel_name',$response['channel_name']);
$tpl->assign('slash_id',$response['slash_id']);
$tpl->output();
?>