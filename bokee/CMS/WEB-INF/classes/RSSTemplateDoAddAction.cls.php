<?php
/**
* RSSTemplateDoAddAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('mod/User.cls.php');
require_once('mod/Template.cls.php');


class RSSTemplateDoAddAction extends Action {
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
		
		$channel_name = $form['channel_name'];
        $db = "cms_" . $channel_name;
       
        // 对先前的错误进行处理
        if ( !$actionError->isEmpty() ){
            // 是系统错误吗？
            if ($actionError->getProp('sysError') != false){
                return $actionMap->findForward('sysError');
            }
            $response['form']=$form;
		
            return $actionMap->findForward('failure');
        }
			
         //添加模板处理
        $template = new TemplateA($db);
        $template->_subject_id = $form['subject_id'];
        $template->_name = $form['name'];
        $template->_file_name = $form['file_name'];
        $template->_default_template = urldecode($form['radiodefault']);
        $template->_limit = $form['limit'];
        $template->_source = $form['source'];
        $template->_path = PATH_HTML_ROOT . "/" . $db . "/" . rsstemplate . ".txt";
		$template->Add();
		$template->AddBlock();
		$template->Addslash();
		$template->Publish();	
			
		return "main.php?do=template_list&channel_name=$channel_name&subject_id=" . $form['subject_id'];
		

	}
}
?>