<?php
/**
 * subject_selelct.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author liangbiquan@bokee.com
**/
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('template_copy.html');
$tpl->assign('subjects',$response['subjects']);
$tpl->assign('tpl_list',$response['tpl_list']);
$tpl->assign('channel_name',$response['channel_name']);
$tpl->output();

?>