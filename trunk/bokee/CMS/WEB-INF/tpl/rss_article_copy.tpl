<?php
/**
 * subject_selelct.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author liangbiquan@bokee.com
**/
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('rss_article_copy.html');
$tpl->assign('subject_list',$response['subject_list']);
$tpl->assign('id',$response['id']);
$tpl->assign('mark', $response['mark']);
$tpl->assign('title', $response['title']);
$tpl->assign('channel_name', $response['channel_name']);
$tpl->output();

?>