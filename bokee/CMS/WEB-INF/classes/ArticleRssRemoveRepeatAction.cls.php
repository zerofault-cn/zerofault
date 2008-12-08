<?php
/**
* ArticleRssRemoveRepeatAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
* 批量删除rss文章中重复的数据
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Article.cls.php');
require_once('mod/User.cls.php');

class ArticleRssRemoveRepeatAction extends Action {
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
		$subject_id=$request['subject_id'];
		$db = "cms_" . $channel_name;
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema($db);
		$sql="select id,article_id,datetime,count(id) as count from rel_article_subject where category=1 and subject_id=".$subject_id." group by datetime order by count desc limit 0,2000";
//		$sql="select id from rel_article_subject where category=1 and subject_id=".$subject_id." limit 0,3000";
		Log::Append($sql);
		$rows=$dao->GetPlan($sql);
		for($i=0;$i<sizeof($rows);$i++)
		{
			if($rows[$i]['count']<2)
			{
				break;
			}
			$sql1="delete from rss_entry_attach where id!=".$rows[$i]['article_id']." and datetime=".$rows[$i]['datetime'];
			$dao->Query($sql1);
//			Log::Append($sql1);
			$sql2 = "delete from rel_article_subject where id!=".$rows[$i]['id']." and datetime=".$rows[$i]['datetime'];
			$dao->Query($sql2);
//			Log::Append($sql2);
		}
		return "main.php?do=article_list&channel_name=".$channel_name."&subject_id=".$subject_id;
	}
}
?>