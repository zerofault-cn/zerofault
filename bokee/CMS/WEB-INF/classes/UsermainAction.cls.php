<?php
/**
* UsermainAction.cls.php
* @copyright bokee dot com
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/User.cls.php');

/**
* UsermainAction
* 右侧用户欢迎界面
* @author yudunde@bokee.com
* @version 0.1
*/
class UsermainAction extends Action {
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
//		if(!User::Authorize())
//		{
//			return $actionMap->findForward('login');
//		}
//        session_start();

		$user = $_SESSION['user'];
		$u = new User();
		$u->GetByID($user['id']);
		$user['role_name'] = $u->GetRoleName($user['role_id']);

		$user['last_login'] = $u->GetLastLogin();
	//	$user['today_article_num'] = $u->GetTodayArticle();
	//	$user['week_article_num'] = $u->GetWeekArticle();
	//	$user['month_article_num'] = $u->GetMonthArticle();
	//	$user['today_rss_article_num'] = $u->GetTodayRSSArticle();
	//	$user['week_rss_article_num'] = $u->GetWeekRSSArticle();
	//	$user['month_rss_article_num'] = $u->GetMonthRSSArticle();
		$response['user'] = $user;
		
		$channel_names = $u->GetChannelNames();
		$channel_names_num = count($channel_names);
		$dao = dao::CreateInstance();
		$articles = array();
		$rss_articles = array();
		for($i=0;false && $i<$channel_names_num;$i++)
		{
			$db = "cms_" . $channel_names[$i]['dir_name'];
			$dao->SetCurrentSchema($db);
			$today = date('Y-m-d') . " 00:00:00";
			$sql = "select id, title, remote_url, create_time from article where user_id = " . $user['id'] . " and create_time>'$today' order by id desc";
			$arr = $dao->GetPlan($sql);
			$articles = array_merge($articles, $arr);
			
			$today = date('Ymd') . "000000";
			$sql = "select id, title, url, datetime from rel_article_subject where user_id = " . $user['id'] . " and datetime>'$today' order by datetime desc";
			$arr = $dao->GetPlan($sql);
			$rss_articles = array_merge($rss_articles, $arr);
		}
		$articles_num = count($articles);
		for($i=0;$i<$articles_num;$i++)
		{
			$articles[$i]['bgcolor'] = ($i%2==0)?"#ffffff":"#C6E6E6";
		}
		$rss_articles_num = count($rss_articles);
		for($i=0;$i<$rss_articles_num;$i++)
		{
			$rss_articles[$i]['bgcolor'] = ($i%2==0)?"#ffffff":"#C6E6E6";
		}
		$response['data']['articles'] = $articles;
		$response['data']['rss_articles'] = $rss_articles;
	}
}
?>