<?php
/**
* ArticleListAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/User.cls.php');
//require_once('mod/');

class RssBlogmarkListAction extends Action {
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
        if(!User::Authorize())
		{
			return $actionMap->findForward('login');
		}
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema('cms_life');
		$sql = "select * from article order by id desc limit 0, 50";
		$rows = $dao->GetPlan($sql);
//		$row_num = count($rows);
//		$articles = array();
//		for($i=0;$i<$row_num;$i++)
//		{
//			$article = new Article('cms_life', $rows[$i]);
//			$articles[] = $article->GetRow();
//		}
		//print_r($rows);
		$response['articles'] = $rows;
	}
}
?>