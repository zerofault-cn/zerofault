<?php
/**
 * TemplateAction.cls.php
 * @copyright bokee dot com
 * @author liut@bokee.com
 * @version 0.1
 */
require_once('mvc/Action.cls.php');
require_once('mod/ParseTemplate.cls.php');

class TplParseAction extends Action {
	/**
	 * 
	 * @access public
	 * @param array &$request
	 * @param array &$files
	 */

	function getArg($name,$param,&$result)
	{
		if(is_array($param))
		{
			foreach($param as $value)
			{	
				$result[] = array($name => $value);
			}
		}
		$result[] = array($name => $param);
	}

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

		$arg = array();

		$array = array("subject_id","special_id","special_subject_id","id");

		foreach($array as $type)
		{
			if(array_key_exists($type,$_REQUEST))
			{
				$this->getArg($type,$_REQUEST[$type],&$arg);
			}
		}

		$parser = new ParseTemplate($db,$arg);
		
		$result = $parser->getTemplates();
		$response['html'] = $result[0];

	}

}
?>
