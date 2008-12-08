<?php
/**
 * TemplateAction.cls.php
 * @copyright bokee dot com
 * @author liut@bokee.com
 * @version 0.1
 */
require_once('mvc/Action.cls.php');
require_once('mod/Template.cls.php');

class TplAction extends Action {
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

		$showAd = isset($_REQUEST['showAd'])?isset($_REQUEST['showAd']):"false";
		$template = new Template($db);
		$action = $actionMap->getProp('path');
		if($action == "editTemplate")
		{
			$template->getTemplateById($_REQUEST['id']);
			$response['is_default'] = $template->_template_is_default;
			$response['id'] = $form['id'];
			$response['file'] = $template->file;
		}
		elseif($action == "addTemplate")
		{
			if(!empty($_REQUEST['channel_name']))
			{
				$template->getTemplateFileByPath(urldecode($_REQUEST['channel_name']),$_REQUEST['id']);
				$response['file'] = $template->_template_file;
			}
			else
			{
				$template->getTemplateFileByName($form['name']);
				$response['file'] = $form['name'];
			}

			$response['is_defaut'] = "N";
			$response['id'] = $_REQUEST['id'];

			
		}
		elseif($action == "saveTemplate")
		{
			$template->_template_is_default = $form['is_default'];
			$template->setName($form['name']);
		}

		
		if($result = $template->$action())
		{
			if($action == "saveTemplate")
			{
				return "main.php?do=tpl_parse&channel_name=".$channel_name."&id=".$result;
			}
		}
		$response['showAd'] = $showAd;
		$response['channel_name'] = $channel_name;
		$response['data'] = $result;
		$response['stage'] = $template->template_stage;
		

	}

}
?>
