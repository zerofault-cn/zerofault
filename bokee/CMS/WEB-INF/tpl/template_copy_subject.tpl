<?php
/**
 * subject_selelct.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author liangbiquan@bokee.com
**/
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('template_copy_subject.html');
$tpl->assign('subject_list',$response['subject_list']);
$tpl->output();

?>