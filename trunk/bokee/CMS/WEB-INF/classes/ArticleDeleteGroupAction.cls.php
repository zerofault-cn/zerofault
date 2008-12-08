<?php
/**
* ArticleDeleteAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Article.cls.php');
require_once('mod/User.cls.php');

class ArticleDeleteGroupAction extends Action {
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
		
		// dbname
		$db = "cms_".$request['channel_name'];
		$request['p'] = isset($request['p'])?$request['p']:1;
		$article = new Article($db);
		// 特殊的表单，所以还是用$_POST, 而没有用$form
		for ($i=0;$i<count($form['article_id']);$i++){
			$id = intval($form['article_id'][$i]);
			if($id>0){
				// 需要在Article class中增加或修改方法，防止误删除
				$article->DeleteByID($id,$request['channel_name']);
			}
		}
		// 两种方法都行，同样可以返回到页面
		/*$result['redirct']  = true;
		$result['parameters'] = array('channel_name'=>$request['channel_name'],'subject_id'=>$request['subject_id']);
		$result['path'] = 'main.php?do=article_list';
		return $result;*/
		return "main.php?do=article_list&channel_name=".$request['channel_name']."&subject_id=".$request['subject_id']."&p=".$request['p'];
	}
}
?>
