<?php
/**
 * subject_selelct.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author liangbiquan@bokee.com
**/
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('contribute_article_transfer.html');
$tpl->assign('rss_article_name',$response['rss_article_name']);
$tpl->assign('rss_article_num',$response['rss_article_num']);
$tpl->assign('rss_article_type',$response['rss_article_type']);
$tpl->assign('article_id_string',$response['article_id_string']);
$tpl->assign('feed_id',$response['feed_id']);
$tpl->assign('mark', $response['mark']);

$tpl->assign($response['data']);
$tpl->assign('channels',$response['channels']);
$tpl->output();

?>