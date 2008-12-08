<?php
/**
* TemplateDoAddAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('mod/User.cls.php');
require_once('mod/Template.cls.php');


class TemplateDoAddAction extends Action {
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
            
       	// print_r($form);
        // 对先前的错误进行处理
        if ( !$actionError->isEmpty() ){
            // 是系统错误吗？
            if ($actionError->getProp('sysError') != false){
                return $actionMap->findForward('sysError');
            }
            $response['form']=$form;
		
            return $actionMap->findForward('failure');
        }
			
         //添加栏目处理
        $template = new TemplateA($db);
        
        $template->_subject_id = $form['subject_id'];
        $template->_name = $form['name'];
        $template->_file_name = $form['file_name'];
        $template->_content = stripslashes($form['content']);

		
      
        if ( $id = $template->Add() )
		{
			//Prepare data need save
			$tpl = new Template($db,$id);
			$tpl->getTemplateFileByPath($channel_name,$id);
			$tpl->setIsDefault("N");
			$tpl->setName($template->_name);
			$subchannel = "subject_id = " . $template->_subject_id;
			$dir = $tpl->setChannel($subchannel);
			$tpl->getSavePath($dir);

			//call the interface function
			if($result = $tpl->doSomethingAboutSave())
			{
				die("模板保存成功！");
			}
		}
	}
}
?>