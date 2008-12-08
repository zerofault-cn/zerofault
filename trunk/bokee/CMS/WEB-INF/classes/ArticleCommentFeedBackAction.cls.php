<?php
/**
* ArticleCommentFeedBackAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Article.cls.php');
require_once('mod/Channel.cls.php');

class ArticleCommentFeedBackAction extends Action {
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
        
        $channel_id = $request['channel_id'];
        $article_id = $request['article_id'];
        $channel = new Channel();
        $channel->GetByID($channel_id);
        $channel_name = $channel->GetDirName();
		$article = new Article("cms_" . $channel_name);
		$article->GetByID($article_id);
		$article_comment_num = $article->GetCommentNum() + 1;
		$article->SetCommentNum($article_comment_num);
		$article->Update();
		exit;
	}
}
?>