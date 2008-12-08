<?php
/**
* BlockNewAddAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('sql/DAO.cls.php');

class BlockNewAddAction extends Action {
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
		$subject_id = intval($request['subject_id']);
        $channel_name = $request['channel_name'];
        $db = "cms_" . $channel_name;
		$dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
        $response['data']['options'] = $this->getSubjectList($dao, 0, "");
        $response['data']['options'] = "<option value=0>频道所有栏目</option>" . $response['data']['options'];
        $response['data']['subject_id'] = $subject_id;
        $response['data']['channel_name'] = $channel_name;
	}
	
	function getSubjectList($dao, $parent_id = 0, $prefix="")
	{
		$sql = "SELECT id,name FROM subject WHERE parent_id = ".$parent_id." ORDER BY id,parent_id DESC";
		$rows = $dao->GetPlan($sql);
		$rows_num = count($rows);
		for($i=0;$i<$rows_num;$i++)
		{
			$subject .= "<option value=\"" . $rows[$i]['id'] .  "\">" . $prefix . $rows[$i]['name'] . "</option>\n";
			$subject .= $this->getSubjectList($dao, $rows[$i]['id'],$prefix . "--");
		}
		return $subject;
	}
}
?>