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

class TemplateCopyAction extends Action {

    function execute(&$actionMap,&$actionError,$request,&$response,$form){
    
	$db = "cms_" . $request['channel_name'];

	//读取已有模版文件
	$dao = DAO::CreateInstance();
	$dao->SetCurrentSchema( $db );
	$sql_select = "select id,name from template order by id";

	$row = $dao->GetPlan( $sql_select );

	$subject = new Subject( $db );
	
	//输出至模版
	$response['tpl_list'] = $row;
	$response['subjects'] = $subject->GetSubjectOptions();
	$response['channel_name'] = $request['channel_name'];
	}
}
