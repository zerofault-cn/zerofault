<?php
/**
* FeedArticleListAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('com/Pager.cls.php');

class FeedArticleListAction extends Action {
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
        $feed_id = $request['feed_id'];
        $response['data']['feed_id'] = $feed_id;
		$dao = DAO::CreateInstanceEmpty();
		$dao->Connect('rss', 'root', '10y9c2U5', '211.152.20.27');
		$pageSize = 20;                                        // how many  per page 
		$sql_all = "select count(*) as num from entry where feed_id=" . $feed_id; // wenzhang zongshu
		$itemSum = $dao->GetOne($sql_all);
		$request['p'] = isset($request['p'])?$request['p']:1; // page number
		$request['p'] = (int)$request['p'];                   // int number
		$request['p'] = ($request['p']<1)?1:$request['p'];
		$request['p'] = ($request['p']>ceil($itemSum/$pageSize))?ceil($itemSum/$pageSize):$request['p'];
		$url = 'main.php?do=feed_article_list&feed_id=' . $feed_id . '&p='.$request['p'];
		$currentPageNumber = $request['p'];
		$pager = new Pager($url,$itemSum,$pageSize,$currentPageNumber);
		$response['pagebar'] = $pager->getBar();
		$response['p'] = $request['p'];

		$sql = "select * from entry where feed_id=$feed_id order by date_time desc limit ".($request['p']-1)*$pageSize.", ".$pageSize;
		$rows = $dao->GetPlan($sql);
		$row_num = count($rows);
		/*
		for($i=0;$i<$row_num;$i++)
		{
			$path = '/opt/bokee/www/entry/' . (int)(intval($rows[$i]["id"])/10000+1)*10000 . '/' . $rows[$i]["feed_id"].'.'.$rows[$i]["id"].'.'.$rows[$i]["md5no"].'.txt';
			if(file_exists($path))
				$rows[$i]['content'] = file_get_contents($path);
			else 
				$rows[$i]['content'] = "";
		}
		*/
		$dao_cms = DAO::CreateInstance();
		$dao_cms->SetCurrentSchema('cms');
		for($i=0;$i<$row_num;$i++)
		{
			$sql = "select count(*) as count from cms_entry where entry_id = '".$rows[$i]["id"]."'";
                        $entry_count = $dao_cms->GetOne($sql);
			if($entry_count == 0)
				$rows[$i]['view_record'] = "";
			else
				$rows[$i]['view_record'] = "<a href='main.php?do=feed_transfer_record&entry_id=".$rows[$i]["id"]."' target='_blank'>查看转移记录</a>";
			
		}
		$response['articles'] = $rows;
	}
}
?>
