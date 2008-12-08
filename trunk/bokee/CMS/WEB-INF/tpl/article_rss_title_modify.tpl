<?php
/**
 * slash_name_modify.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('article_rss_title_modify.html');
$tpl->assign('rss_title',$response['rss_title']);
$tpl->assign('author',$response['author']);
$tpl->assign('article_id',$response['article_id']);
$tpl->assign('subject_options',$response['subject_options']);
$tpl->assign('channel_name',$response['channel_name']);
$tpl->assign('rss_id',$response['rss_id']);
$tpl->assign('rss_mark',$response['rss_mark']);
$tpl->output();
?>