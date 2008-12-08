<?php
/**
* SlashDeleteAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('sql/DAO.cls.php');

class SlashDeleteAction extends Action {
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
        $response['channel_name'] = $channel_name;
        $id = intval($request['id']);
        $template_id = intval($request['template_id']);
        $subject_id = intval($request['subject_id']);
        
        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
        $sql = "select name, content from template_slash where id=" . $id;
        $row_slash = $dao->GetRow($sql);
        $name = $row_slash['name'];
        $content_slash = $row_slash['content'];
        
        $sql = "delete from template_slash where id =" . $id;
		
        if( !$dao->Query($sql))
        {
        	return $actionMap->findForward('failure');
        }
        
        $template = new TemplateA($db);
        $template->GetTemplateById($template_id);
        
        $content = $template->_content;
        $find = "<input type=hidden name=" . $name . " value=" . $id . ">";
        //$find =htmlspecialchars($find);

        $template->_content = str_replace($find, $content_slash, $content);
		
		if($template->Update())
			return "main.php?do=template_modify&channel_name=".$channel_name."&id=".$template_id."&subject_id=".$subject_id;
		else
			return $actionMap->findForward('failure');
	}
}
?>