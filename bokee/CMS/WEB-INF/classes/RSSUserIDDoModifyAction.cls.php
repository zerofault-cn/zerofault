<?php
/**
* RSSUserIDDoModifyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/User.cls.php');

class RSSUserIDDoModifyAction extends Action {
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
			
        //修改用户RSS ID
        session_start();
        $id = intval($_SESSION['user']['id']);
		$user = new User();
		$user->GetByID($id);
		$user->SetRSSUserID($form['rss_uid']);
		// chengfeng add  0624
		$user->SetArticleNum(empty($request['article_num'])?0:$request['article_num']);
		// chengfeng add  0624
		
		if($user->Update())
		{
			return $actionMap->findForward('success');
		}
		else 
        	return $actionMap->findForward('sysError');
	}

}
?>