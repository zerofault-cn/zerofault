<?php
/**
 * BlockAction.cls.php
 * @copyright bokee dot com
 * @author yudunde@bokee.com
 * @version 0.1
 */
require_once('mvc/Action.cls.php');
require_once('mod/Template.cls.php');
require_once('sql/DAO.cls.php');

class BlockHotCommentAddAction extends Action {
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
		$channel_name = $_REQUEST['channel_name'];
        $db = "cms_" . $channel_name;

		$template = new Template($db);
		$subject_list = $template->getSubjectList();

		$response['data']['subject_list'] = $subject_list;
		$response['data']['channel_name'] = $channel_name;
		$response['data']['subject_id'] = $request['subject_id'];
	}

}
?>
