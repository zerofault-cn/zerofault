<?php
/**
* ArticleRssDeleteBatchAction.cls.php
* @copyright bokee dot com
* @author zerofault@bokee.com
* @version 0.1
* 批量删除过期rss文章
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');

class ArticleRssDeleteBatchAction extends Action {
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
		$monthlimit=$request['monthlimit'];
		if(''==$monthlimit)
		{
			$monthlimit=6;
		}
        $db = "cms_" . $channel_name;
        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
		$timelimit=date("Ymdhis",time()-$monthlimit*30*24*3600);
		$sql0="select article_id from rel_article_subject where category=1 and subject_id=".$subject_id." and datetime<".$timelimit;
//		$sql1="delete from rss_entry_attach where  datetime<".$timelimit;
		$col=$dao->GetCol($sql0);
		for($i=0;$i<sizeof($col);$i+=100)
		{
			$sql1="delete from rss_entry_attach where id in (".implode(',',array_slice($col,$i,100)).")";
			$dao->Query($sql1);
		}
		$sql2 = "delete from rel_article_subject where category=1 and subject_id=".$subject_id." and  datetime<".$timelimit;
		if($dao->Query($sql2))
		{
			return "main.php?do=article_list&channel_name=".$channel_name."&subject_id=".$subject_id;
		}
		else 
		{
			return $actionMap->findForward('sysError');
		}
	}
}
?>