<?php
/**
* ArticleRssDeleteGroupAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Article.cls.php');
require_once('mod/User.cls.php');

class ArticleRssDeleteGroupAction extends Action {
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
		
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema("cms_" . $request['channel_name']);
		
		$article_string = "(";
		for ($i=0;$i<count($form['article_id']);$i++){
			$id = intval($form['article_id'][$i]);
			if($id>0){
				$article_string .= 	$id . ",";		}
		}
		$article_string = substr( $article_string ,0,-1 ) . ")" ;

		$sql_del = "delete from rel_article_subject where id in $article_string";
		if( !$dao->Query($sql_del) )
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行删除RSS文章出错。");
		
		return "main.php?do=article_list&channel_name=".$request['channel_name']."&subject_id=".$request['subject_id'];
	}
}
?>
