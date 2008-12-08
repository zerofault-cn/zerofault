<?php
/**
* RootFeedArticleListAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('com/Pager.cls.php');
require_once('com/Log.cls.php');

class RootFeedArticleListAction extends Action {
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
        session_start();
		$user = $_SESSION['user'];
        $dao = DAO::CreateInstanceEmpty();
		if(!$dao->Connect('rss', 'root', '10y9c2U5', '211.152.20.27'))
			die("connect error");
		$sql = "select * from feed_label where owner_id=" . $user['rss_uid'];
		$feeds = $dao->GetPlan($sql);
		$feeds_num = count($feeds); 
		$feed_ids = "";
		for($i=0;$i<$feeds_num;$i++)
		{
			if($i<($feeds_num-1))
				$feed_ids .= $feeds[$i]['feed_id'] . ",";
			else 
				$feed_ids .= $feeds[$i]['feed_id'];
		}

		$pageSize = 80;
		$sql_all = "select count(*) as num from entry where feed_id in ($feed_ids)"; 
		$itemSum = $dao->GetOne($sql_all);
		$request['p'] = isset($request['p'])?$request['p']:1; // page number
		$request['p'] = (int)$request['p'];                   // int number
		$request['p'] = ($request['p']<1)?1:$request['p'];
		$request['p'] = ($request['p']>ceil($itemSum/$pageSize))?ceil($itemSum/$pageSize):$request['p'];
		$url = 'main.php?do=root_feed_article_list&p='.$request['p'];
		$currentPageNumber = $request['p'];
		$pager = new Pager($url,$itemSum,$pageSize,$currentPageNumber);
		$response['pagebar'] = $pager->getBar();
		$response['p'] = $request['p'];

		$sql = "select * from entry where feed_id in ($feed_ids) order by id desc limit ".($request['p']-1)*$pageSize.", ".$pageSize;
		$rows = $dao->GetPlan($sql);
		$row_num = count($rows);
		/*
		for($i=0;$i<$row_num;$i++)
		{
			
			$key = $rows[$i]["feed_id"].'.'.$rows[$i]["id"].'.'.$rows[$i]["md5no"];
            $bdbPath = PATH_BDB . '/' . (int)($rows[$i]["id"]/10000) . '.db';
            Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 key:" . $key);
            Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 key:" . $bdbPath);
            $db = dba_open($bdbPath, "rl", "db4");
		    
            if (!$db) {
		            $rows[$i]['content'] = " ";
		    }
		    else 
		    {
            	$rows[$i]['content'] = dba_fetch($key, $db);
              	dba_close($db);
		    }
		    
		     
			$path = '/opt/bokee/www/entry/' . (int)(intval($rows[$i]["id"])/10000+1)*10000 . '/' . $rows[$i]["feed_id"].'.'.$rows[$i]["id"].'.'.$rows[$i]["md5no"].'.txt';
			if(file_exists($path))
				$rows[$i]['content'] = file_get_contents($path);
			else 
				$rows[$i]['content'] = "";
			
		}
		*/
		$response['articles'] = $rows;
	}
}
?>