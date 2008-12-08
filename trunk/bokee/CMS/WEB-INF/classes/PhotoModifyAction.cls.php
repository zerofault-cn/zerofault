<?php
/**
* PhotoModifyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('com/Pager.cls.php');

class PhotoModifyAction extends Action {
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
        $subject_id = $request['subject_id'];
        $id = $request['id'];
        $dao = DAO::CreateInstance();
        $db = "cms_" . $channel_name;
        $dao->SetCurrentSchema($db);
        $sql = "select * from gallery where id=$id";
        $row = $dao->GetRow($sql);
        $response['data']['options'] = $this->getSubjectList($dao, 0, "", $row['subject_id']);
        if($row['subject_id']==0)
        {
        	$response['data']['options'] = "<option value=0 selected>根栏目</option>" . $response['data']['options'];
        }
        else 
        {
        	$response['data']['options'] = "<option value=0>根栏目</option>" . $response['data']['options'];
    	}
    	$response['data']['channel_name'] = $channel_name;
    	$response['data']['subject_id'] = $subject_id;
    	$response['data']['path'] = $row['path'];
    	$response['data']['url'] = $row['url'];
    	$response['data']['name'] = $row['name'];
    	$response['data']['id'] = $id;
	}
	function getSubjectList($dao, $parent_id = 0, $prefix="", $selected_subject_id)
	{
		$sql = "SELECT id,name FROM subject WHERE parent_id = ".$parent_id." ORDER BY id,parent_id DESC";
		$rows = $dao->GetPlan($sql);
		$rows_num = count($rows);
		for($i=0;$i<$rows_num;$i++)
		{
			if($rows[$i]['id'] == $selected_subject_id)
			{
				$subject .= "<option value=\"" . $rows[$i]['id'] .  "\" selected>" . $prefix . $rows[$i]['name'] . "</option>\n";
			}
			else 
			{
				$subject .= "<option value=\"" . $rows[$i]['id'] .  "\">" . $prefix . $rows[$i]['name'] . "</option>\n";
			}
			$subject .= $this->getSubjectList($dao, $rows[$i]['id'],$prefix . "--", $selected_subject_id);
		}
		return $subject;
	}
}
?>