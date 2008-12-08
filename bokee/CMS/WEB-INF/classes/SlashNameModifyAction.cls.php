<?php
/**
* SlashNameModifyAction.cls.php
* @copyright bokee dot com
* @author liangbiquan@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('sql/DAO.cls.php');

class SlashNameModifyAction extends Action {

    function execute(&$actionMap,&$actionError,$request,&$response,$form){

	$channel_name = $request['channel_name'];
        $db = "cms_" . $channel_name;
        $response['channel_name'] = $channel_name;
        $id = intval($request['slash_id']);
        $template_id = intval($request['template_id']);
        $subject_id = intval($request['subject_id']);
        
        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
        $sql = "select name from template_slash where id=" . $id;
        $row_slash = $dao->GetRow($sql);
        $response['slash_name'] = $row_slash['name'];
        $response['slash_id'] = $request['slash_id'];
    }
}
?>