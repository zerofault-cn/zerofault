<?php
/**
* TestAction.cls.php
* @copyright bokee dot com
*/

require_once("mod/Article.cls.php");
require_once('mvc/Action.cls.php');

/**
* IndexAction
* 处理首页请求
* @author zczhong@hotmail.com
* @version 0.1
* @since PHP 4
*/
class TestAction extends Action {
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
        
        //获取文章内容
        /*
        $article = new Article("cms_life");
        if(!$article->GetByID(4))
        	return $actionMap->findForward('sysError');
        $article->Dump();
        */
        
        //更新文章
        /*
        $article->_author = "方兴东";
        $article->Update();
        $article->Dump();
        exit;
        */
                
        //删除文章
        /*
        $article->Delete();
        exit;
        */
        
        //添加文章
        /*
        $new_article = new Article("cms_life");
        $new_article->_author = "于敦德";
        $new_article->Insert();
        */
        $dao = DAO::CreateInstance();
        $sql = "update user set password='" . md5("hjiqpeqe") . "'";
        $dao->Query($sql);
        
        
	}
}
?>