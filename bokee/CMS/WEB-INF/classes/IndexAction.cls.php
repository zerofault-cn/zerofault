<?php
/**
* IndexAction.cls.php
* @copyright zhong zichang Wed Jan 19 15:58:13 CST 2005
*/

require_once('mvc/Action.cls.php');

/*
require_once('mod/rss/Entry.cls.php');
require_once('mod/rss/Feed.cls.php');
require_once('mod/rss/Cata.cls.php');
require_once('mod/rss/Headline.cls.php');
*/

/**
* IndexAction
* 处理首页请求
* @author yudunde@bokee.com
* @version 0.1
*/
class IndexAction extends Action {
	
    /**
    * 
    * @access public
    * @param array &$request
    * @param array &$files
    */
    function execute(&$actionMap,&$actionError,$request,&$response,$form){
        /*
        // 事务处理
        // 将需要显示给用户的错误注入到 $response['action_erros'] 中
        // 给forward增加参数(在进行页面跳转时使用)
        // $actionMap->addForwardParam('key_test','value_test','name_test');
        // 返回的forward是一个数组
        //return $actionMap->findForward('success');
        //return $actionMap->findForward('sysError'); 
        */  
        

     
   }
}
?>