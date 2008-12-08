<?php
/**
* TemplateCopyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Subject.cls.php');

class TemplateCopySubjectAction extends Action {

    function execute(&$actionMap,&$actionError,$request,&$response,$form){
    
	$db = "cms_" . $request['channelName'];
	
	//读取已有模版文件
	$dao = DAO::CreateInstance();
	$dao->SetCurrentSchema( $db );
	$sql_select = "select id as subjectid,sort as subjectlevel,name as subjectname from subject order by sort,id";
	//$sql_select = "SELECT id,name FROM subject WHERE parent_id = ".$parent_id." ORDER BY id,parent_id DESC

	$row = $dao->GetPlan( $sql_select );

	//$subject = new Subject( $db );
	
	//输出至模版
	$response['subject_list'] = $row;
	//$response['subjects'] = $subject->GetSubjectListOptions();
	//$response['channel_name'] = $request['channelName'];
	}
}
