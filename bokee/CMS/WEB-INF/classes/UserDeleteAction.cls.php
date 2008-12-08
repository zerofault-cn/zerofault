<?php
/**
* UserDeleteAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/User.cls.php');

class UserDeleteAction extends Action {
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
		if(!User::Authorize())
		{
			return $actionMap->findForward('login');
		}
		$db = "cms_".$request['channel_name'];
		$request['p'] = isset($request['p'])?$request['p']:1;
		$user = new User();
		if (!empty($form['user_id'])){
			for ($i=0;$i<count($form['user_id']);$i++){
				$id = intval($form['user_id'][$i]);
				$user->DeleteByID($id);
			}
			return "main.php?do=user_list&p=".$request['p'];
		}else {
			//删除单个用户处理
			$id = intval($request['id']);
			if($user->DeleteByID($id))
			{
				return "main.php?do=user_list&p=".$request['p'];
			}
			else
			return $actionMap->findForward('sysError');
		}
	}

}
?>