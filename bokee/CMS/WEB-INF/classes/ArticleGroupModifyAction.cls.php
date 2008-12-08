<?php
/**
* ArticleGroupModifyAction.cls.php
* @copyright bokee dot com
* @author liangbiquan@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/ArticleGroup.cls.php');

class ArticleGroupModifyAction extends Action {
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
		$channel_name = $request['channel_name'];
        $subject_id = $request['subject_id'];
		$id = $request['id'];
		$db = "cms_" . $channel_name;

		$article_group = new ArticleGroup( $db );
		$article_group->GetByID( $id );

		$response['channel_name'] = $channel_name;
		$response['subject_id'] = $subject_id;
		$response['group_name'] = $article_group->GetName();
		$response['url'] = $article_group->GetUrl();
		$category = $article_group->GetCategory();

		if( "photo" == $category )
			$response['photo_selected'] = "selected";
		if( "article" == $category )
			$response['article_selected'] = "selected";

		$response['id'] = $id;
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema($db);
		$sql = "select * from article where group_id=$id and subject_id=$subject_id";
		$rows = $dao->GetPlan($sql);
		$rows_num = count($rows);
		for($i=0;$i<$rows_num;$i++)
		{
			$rows[$i]['channel_name'] = $channel_name;
			$rows[$i]['bgcolor'] = ($i%2==0)?"#ffffff":"#C6E6E6";
		}
		$response['data']['articles'] = $rows;
	}
}
?>