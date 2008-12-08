<?php
/**
 * slash_name_modify.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('article_time_modify.html');
$tpl->assign('channel_name',$response['channel_name']);
$tpl->assign('article_id',$response['article_id']);
$tpl->assign('r_id',$response['r_id']);

$tpl->assign('year',$response['year']);
$tpl->assign('month',$response['month']);
$tpl->assign('day',$response['day']);
$tpl->assign('hour',$response['hour']);
$tpl->assign('minute',$response['minute']);
$tpl->assign('second',$response['second']);
$tpl->output();
?>