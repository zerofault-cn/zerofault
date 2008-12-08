<?php
/**
* ArticleGroupDoModifyAction.cls.php
* @copyright bokee dot com
* @author liangbiquan@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/ArticleGroup.cls.php');

class ArticleGroupDoModifyAction extends Action {
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
		$group_name = $request['group_name'];
		$url = $request['url'];
		$category = $request['category'];
		$id = $request['id'];

		$db = "cms_" . $channel_name;

		if( empty($group_name) )
			die("参数错误");

		$article_group = new ArticleGroup( $db );
		$article_group->GetByID( $id );
		$article_group->SetName( $group_name );
		$article_group->SetUrl( $url );
		$article_group->SetCategory( $category );

		if( $article_group->Update() )
		{
			$str_js = "<script language='javascript'>";
			$str_js.= "alert('修改成功!');";
			$str_js.= "location.href='main.php?do=article_group_list&channel_name=$channel_name&subject_id=$subject_id';";
			$str_js.= "</script>";
			echo $str_js;
		}
		else
		{
			die("修改失败！");
		}
	}
}
?>