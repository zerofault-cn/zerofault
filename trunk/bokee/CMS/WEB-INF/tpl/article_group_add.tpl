<?php
/**
 * article_group_add.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('article_group_add.html');
$tpl->assign('channel_name',$response['channel_name']);
$tpl->assign('subject_id',$response['subject_id']);
$tpl->output();
?>