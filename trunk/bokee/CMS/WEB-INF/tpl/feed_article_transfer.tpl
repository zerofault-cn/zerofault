<?php
/**
 * subject_selelct.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author liangbiquan@bokee.com
**/
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('feed_article_transfer.html');
$tpl->assign('rss_article_name',$response['rss_article_name']);
$tpl->assign('rss_article_num',$response['rss_article_num']);
$tpl->assign('rss_article_type',$response['rss_article_type']);
$tpl->assign('channel_list',$response['channel_list']);
$tpl->assign('feed_string',$response['feed_string']);
$tpl->assign('mark', $response['mark']);
$tpl->output();

?>