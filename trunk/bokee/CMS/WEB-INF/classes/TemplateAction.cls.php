<?php
/**
 * TemplateAction.cls.php
 * @copyright bokee dot com
 * @author liut@bokee.com
 * @version 0.1
 */
require_once('mvc/Action.cls.php');
require_once('mod/Template.cls.php');

class TemplateAction extends Action {
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


		$template = new Template;
		$action = $actionMap->getProp('path');
		if($action == "editTemplate")
		{

			$template->getTemplateById($form['id']);
			$response['is_default'] = $template->_template_is_default;
			$response['id'] = $form['id'];
			$response['file'] = $template->file;
		}
		elseif($action == "addTemplate")
		{
			$template->getTemplateFileByName($form['name']);
			$response['is_defaut'] = "N";
			$response['file'] = $form['name'];
			
		}
		elseif($action == "saveTemplate")
		{
			$template->_template_is_default = $form['is_default'];
			$template->setName($form['name']);
		}

		
		$result = $template->$action();
		$response['data'] = $result;
		$response['stage'] = $template->template_stage;

		if($result === false)
		{
			die("!");
			return $actionMap->findForward('failure');		
		}
	}

}
?>
