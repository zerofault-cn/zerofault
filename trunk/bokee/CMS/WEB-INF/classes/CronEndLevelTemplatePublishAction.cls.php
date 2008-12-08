<?php
/**
* CronEndLevelTemplatePublishAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('sql/DAO.cls.php');
require_once('com/Log.cls.php');

class CronEndLevelTemplatePublishAction extends Action {
	/**
    * 
    * @access public
    * @param array &$request
    * @param array &$files
    */
    function execute(&$actionMap,&$actionError,$request,&$response,$form){
        // 事务处理
        // 将需要显示给用户的错误注入到 $response['action_erros'] 中
        // 给forward增加参数(在进行页面跳转时使用)
        // $actionMap->addForwardParam('key_test','value_test','name_test');
        // 返回的forward是一个数组
        //return $actionMap->findForward('success');
        //return $actionMap->findForward('sysError');   
		$channel_name = $request['channel_name'];
        $db = "cms_" . $channel_name;
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema($db);
		$sql = "select t.* from template t, subject s where t.subject_id=s.id and s.sort=3 order by id asc";
		$rows = $dao->GetPlan($sql);
		$rows_num = count($rows);
		for($i=0;$i<$rows_num;$i++)
		{
        	$template = new TemplateA($db);
        	$template->GetTemplateById($rows[$i]['id']);
			$template->Publish();
			Log::AppendCron("发布 " . $channel_name . " 三级栏目模板 " . $rows[$i]['name'] . " (" . $rows[$i]['id'] . ")");
		}
		echo ok;
	}
}
?>