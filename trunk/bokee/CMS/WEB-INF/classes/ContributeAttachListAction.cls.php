<?php
/**
* FeedAttachListAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('com/Pager.cls.php');
require_once('mod/User.cls.php');

class ContributeAttachListAction extends Action {
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
       	
       	$db = "cms_" . $channel_name;
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema($db);
		
		$pageSize = 20;                                        // how many  per page 
		$sql_all = "select count(*) as num from rss_feed_attach where source='blogmark'"; // wenzhang zongshu
		$itemSum = $dao->GetOne($sql_all);
		$request['p'] = isset($request['p'])?$request['p']:1; // page number
		$request['p'] = (int)$request['p'];                   // int number
		$request['p'] = ($request['p']<1)?1:$request['p'];
		$request['p'] = ($request['p']>ceil($itemSum/$pageSize))?ceil($itemSum/$pageSize):$request['p'];
		$url = 'main.php?do=contribute_attach_list&channel_name=' . $channel_name . '&p='.$request['p'];
		$currentPageNumber = $request['p'];
		$pager = new Pager($url,$itemSum,$pageSize,$currentPageNumber);
		$response['pagebar'] = $pager->getBar();
		$response['p'] = $request['p'];

		if($itemSum>0)
		{
		$sql = "select * from rss_feed_attach where source='blogmark' order by id desc limit ".($request['p']-1)*$pageSize.", ".$pageSize;
		$rows = $dao->GetPlan($sql);
		$row_num = count($rows);
		$dao_rss = DAO::CreateInstanceEmpty();
		if(!$dao_rss->Connect('contribute', 'root', '10y9c2U5', '221.238.254.205'))
			die("connect error");
		
		for($i=0;$i<$row_num;$i++)
		{
			$sql_feed_title = "select name from channel where id=" . $rows[$i]['feed_id'];
			$rows[$i]['feed_title'] = conv($dao_rss->GetOne($sql_feed_title));
			$sql_subject_title = "select name from subject where id=" . $rows[$i]['subject_id'];
			$rows[$i]['subject_title'] = $dao->GetOne($sql_subject_title);
			$rows[$i]['channel_name'] = $channel_name;
		}
		}
		$response['mapping'] = $rows;
	}
}
function conv($str)
{
	return mb_convert_encoding($str,"utf-8","utf-8,gbk,gb2312");
}
?>