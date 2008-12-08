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

class ContributeArticleListAction extends Action {
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
		$dao->Connect('contribute', 'root', '10y9c2U5', '221.238.254.205');
		$pageSize = 20;
		if(''==$feed_id || 0==$feed_id)
		{
			$sql_all="select count(*) as num from article";
		}
		else
		{
			$sql_all = "select count(*) as num from article where channel_id1=" . $feed_id." or channel_id2=" . $feed_id." or channel_id3=" . $feed_id; 
		}
		$itemSum = $dao->GetOne($sql_all);
		$request['p'] = isset($request['p'])?$request['p']:1; // page number
		$request['p'] = (int)$request['p'];                   // int number
		$request['p'] = ($request['p']<1)?1:$request['p'];
		$request['p'] = ($request['p']>ceil($itemSum/$pageSize))?ceil($itemSum/$pageSize):$request['p'];
		$url = 'main.php?do=contribute_article_list&feed_id=' . $feed_id . '&p='.$request['p'];
		$currentPageNumber = $request['p'];
		$pager = new Pager($url,$itemSum,$pageSize,$currentPageNumber);
		$response['pagebar'] = $pager->getBar();
		$response['p'] = $request['p'];
		if(''==$feed_id || 0==$feed_id)
		{
			$sql="select * from article order by addtime desc limit ".($request['p']-1)*$pageSize.", ".$pageSize;
		}
		else
		{
			$sql = "select * from article where channel_id1=" . $feed_id." or channel_id2=" . $feed_id." or channel_id3=" . $feed_id." order by addtime desc limit ".($request['p']-1)*$pageSize.", ".$pageSize;
		}
		$rows = $dao->GetPlan($sql);
		for($i=0;$i<count($rows);$i++)
		{
			$rows[$i]['title']=conv($rows[$i]['title']);
			$rows[$i]['date_time']=date("Y-m-d H:i:s",$rows[$i]['addtime']);
		}
		$response['articles'] = $rows;
	}
}
function conv($str)
{
	return mb_convert_encoding($str,"utf-8","utf-8,gbk,gb2312");
}
?>
