<?php
/**
* TemplateEditAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('sql/DAO.cls.php');

class TemplateEditAction extends Action {
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
		session_start();
		$dao = DAO::CreateInstance();
		$user = $_SESSION['user'];

		$channel_name = $request['channel_name'];
        $db = "cms_" . $channel_name;
        $response['channel_name'] = $channel_name;
        $id = intval($request['id']);
        
        $subject_id = empty($request['subject_id'])?0:$request['subject_id'];
        $special_id = empty($request['special_id'])?0:$request['special_id'];
        $special_subject_id = empty($request['special_subject_id'])?0:$request['special_subject_id'];
        
        $template = new TemplateA($db);
        $template->GetTemplateById($id);
        $template->_row['channel_name'] = $channel_name;
        $response['template'] = $template->_row;
        
        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
        $sql = "select * from template_slash where template_id=" . $id . " order by id asc";
        $rows = $dao->GetPlan($sql);
        $rows_num = count($rows);
        $rows_edit = array();
        for($i=0;$i<$rows_num;$i++)
        {
        	$rows[$i]['channel_name'] = $channel_name;
        	$rows[$i]['subject_id'] = $subject_id;
        	if($rows[$i]['category'] == "block" )
        	{
        		continue;
        	}
			if( ( $rows[$i]['category'] == "image" || $rows[$i]['category'] == "text" ) && $user['role_id'] >3 )
        	{
        		continue;
        	}
			if( $rows[$i]['category'] == "ad" && $user['role_id'] < 4 )
        	{
        		continue;
        	}

        	if($rows[$i]['category']=="image")
        	{
        		$rows[$i]['edit'] = "<textarea name=content cols=80 rows=2 id=content>" . $rows[$i]['content'] . "</textarea><br><input type=file name=image id=image>";
        	}
        	else 
        	{
        		$rows[$i]['edit'] = "<textarea name=content cols=100 rows=12 id=content>" . $rows[$i]['content'] . "</textarea>";
        	}
        	$rows_edit[] = $rows[$i];
    	}
        $response['data']['slashes'] = $rows_edit;
	}
}
?>