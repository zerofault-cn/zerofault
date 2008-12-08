<?php
/**
* TemplateCopyAction.cls.php
* @copyright bokee dot com
* @author zhujiangmin@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Subject.cls.php');
require_once('mod/Channel.cls.php');

class FeedTransferRecordAction extends Action {

    function execute(&$actionMap,&$actionError,$request,&$response,$form){
    	
	//读取已有模版文件
	$entry_id = intval($request["entry_id"]);
	$dao = DAO::CreateInstance();
	$dao->SetCurrentSchema('cms');
	$sql_select = "select a.*, b.real_name, c.name channel ".
			"from cms_entry a, `user` b, channel c ".
			"where a.user_id = b.id and a.entry_id = '".$entry_id."' and c.dir_name = a.channel_name ".
			"order by id desc";
	$row = $dao->GetPlan( $sql_select );
	$count = count($row);
	for($i=0;$i<$count;$i++)
	{
		$db = 'cms_'.$row[$i]["channel_name"];
		$dao->SetCurrentSchema($db);
		$subject = new Subject($db);
		$subjectName = $subject->GetSubjectNameStr($row[$i]["subject_id"]);
		$subjectName = $row[$i]["channel"]."->".$subjectName;
		$row[$i]["subject_name"] = $subjectName;
		$row[$i]["num"] = $i+1;
		$row[$i]["time"] = date('Y-m-d H:i', $row[$i]["selected_time"]);
	}
	
	//输出至模版
	$response['record_list'] = $row;
	}
}