<?php
/**
* TemplateDoModifyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('sql/DAO.cls.php');

class TemplateDoModifyAction extends Action {
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
        $response['channel_name'] = $channel_name;
        $id = intval($form['id']);
        
        $subject_id = empty($form['subject_id'])?0:$form['subject_id'];
        $special_id = empty($form['special_id'])?0:$form['special_id'];
        $special_subject_id = empty($form['special_subject_id'])?0:$form['special_subject_id'];
        $rep_content = $form['rep_content'];
        $content = stripslashes($form['content']);
        if($rep_content!="")
        {
	        $rep_name = $form['rep_name'];
	        $rep_category = $form['rep_category'];
			$rep_blog_id = $form['select_block']!=""?$form['select_block']:0;
			$rep_content = str_replace( "'","\'",$rep_content );
	        $sql = "insert into template_slash (name, template_id, content, category, block_id) values('$rep_name',$id, '$rep_content', '$rep_category', $rep_blog_id)";
	        $dao = DAO::CreateInstance();
	        $dao->SetCurrentSchema($db);
	        $dao->Insert($sql);
	        $rep_id = $dao->LastID();
	        $replace = "<input type=hidden name=" . $rep_name . " value=" . $rep_id . ">";
	        //$replace=htmlspecialchars($replace);
	        $content = str_replace("[[##]]", $replace, $content);
        }
        $template = new TemplateA($db);
        $template->GetTemplateById($id);
        
        $template->_content = $content;
        $template->_name = $form['name'];
        $template->_file_name = $form['file_name'];
        $template->_default_template = $form['defaulttlist'];
		$template->_is_more = $form['is_more'];
        
        if($template->Update())
        {
        	return "main.php?do=template_modify&channel_name=".$channel_name."&subject_id=".$form['subject_id']."&id=".$id;
        }
        else 
        {
        	return $actionMap->findForward('failure');
        }
	}
}
?>