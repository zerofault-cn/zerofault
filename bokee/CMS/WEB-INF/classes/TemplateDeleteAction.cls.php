<?php
/**
* TemplateDeleteAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('sql/DAO.cls.php');

class TemplateDeleteAction extends Action {
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
		$id = intval($request['id']);
        $request['p'] = empty($request['p'])?1:$request['p'];
        $channel_name = $request['channel_name'];
        $db = "cms_" . $channel_name;
        $template = new TemplateA($db);
        
		if (!empty($form['template_id'])){
			for ($i=0;$i<count($form['template_id']);$i++){
				$id = intval($form['template_id'][$i]);
				$template->DeleteByID($id);
			}
		}else {
        	// 删除单个模版
       		$template->DeleteByID($id);
        }       
        return "main.php?do=template_list&channel_name=".$request['channel_name']."&subject_id=".$request['subject_id']."&p=".$request['p'];
	}
}
?>