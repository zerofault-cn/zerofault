<?php
/**
 * subject_selelct.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author zhujiangmin@bokee.com
**/
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('feed_transfer_record.html');
$tpl->assign('record_list',$response['record_list']);
$tpl->output();
?>