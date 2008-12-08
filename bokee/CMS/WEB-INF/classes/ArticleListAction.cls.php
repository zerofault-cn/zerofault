<?php 
/**
* ArticleListAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/
require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Article.cls.php');
require_once('mod/User.cls.php');
require_once('com/Pager.cls.php');
require_once('mod/Subject.cls.php');

class ArticleListAction extends Action {
	/**
    * 
    * @access public
    * @param array &$request
    * @param array &$files
    */
    function execute(&$actionMap,&$actionError,$request,&$response,$form){
        // 事务处理
        // 将需要显示给用户的错误注入到 $response['action_erros'] 中

        //return $actionMap->findForward('success');
        //return $actionMap->findForward('sysError');   
        
		$dao = DAO::CreateInstance();
		$db = "cms_" . $request['channel_name'];
		$subject_id = $request['subject_id'];
		if($db=='cms_group' && $_REQUEST['forward']!=1)
		{
			return 'main.php?do=article_list_for_group&forward=1&channel_name=group&subject_id='.$subject_id.'&p_rss='.$request['p_rss'].'&chioce='.$request['chioce'].'&p='.$request['p'];
		}
		$dao->SetCurrentSchema($db);
		$response['subject_id'] = $subject_id;
		$response['channel_name'] = $request['channel_name'];

		// how many  per page
		$pageSize = $_REQUEST['chioce'];                                     
		if(!$pageSize){$pageSize=20;
		}
		$pageSize_rss = $_REQUEST['chioce_rss'];
		if(!$pageSize_rss){$pageSize_rss=20;
		}
		$subject = new Subject($db);
		$subject->GetByID($subject_id);

		if($subject->GetCategory()==0)
		{
			$subject_id_str = $subject->GetSubjectIdStr($subject_id);
			$sql_all = "select count(*) as num from article where subject_id in (" . $subject_id_str . ")"; // wenzhang zongshu
		}
		else 
		{
			$sql_all = "select count(*) as num from article"; 
		}
		$itemSum = $dao->GetOne($sql_all);
		$request['p'] = isset($request['p'])?$request['p']:1; // page number
		$request['p'] = (int)$request['p'];                   // int number
		$request['p'] = ($request['p']<1)?1:$request['p'];
		$request['p'] = ($request['p']>ceil($itemSum/$pageSize))?ceil($itemSum/$pageSize):$request['p'];
		
		$request['p_rss'] = isset($request['p_rss'])?$request['p_rss']:1; // page number
		$request['p_rss'] = (int)$request['p_rss'];                   // int number
		$request['p_rss'] = ($request['p_rss']<1)?1:$request['p_rss'];
			
		$url = 'main.php?do=article_list&channel_name='.$request['channel_name'].'&subject_id='.$subject_id.'&p_rss='.$request['p_rss'].'&chioce='.$pageSize;
		$currentPageNumber = $request['p'];
		$pager = new Pager($url,$itemSum,$pageSize,$currentPageNumber);
		$response['pagebar'] = $pager->getBar();
		$response['p'] = $request['p'];
		if($subject->GetCategory()==0)
		{
			$sql = "select * from article where subject_id in (" . $subject_id_str . ") order by id desc limit ".($request['p']-1)*$pageSize.", ".$pageSize;
		}
		else 
		{
			$sql = "select * from article order by id desc limit ".($request['p']-1)*$pageSize.", ".$pageSize;
		}
		$rows = $dao->GetPlan($sql);
		$row_num = count($rows);
		for($i=0;$i<$row_num;$i++)
		{
			if($db == 'cms_blog')
			$sql_plushtime="select * from rel_article_subject where article_id=".$rows[$i][id]." and category=0";
			else 
			$sql_plushtime="select * from rel_article_subject where article_id=".$rows[$i][id]."";
			$rows_time = $dao->query($sql_plushtime);
			$rows_plush[] = $dao->fa($rows_time);
			$datey=substr($rows_plush[$i]['plush_time'],0,4);
			$dated=substr($rows_plush[$i]['plush_time'],6,2);
			$datem=substr($rows_plush[$i]['plush_time'],4,2);
			$dates=substr($rows_plush[$i]['plush_time'],12,2);
			$datef=substr($rows_plush[$i]['plush_time'],10,2);
			$dateh=substr($rows_plush[$i]['plush_time'],8,2);
			$plush_time= mktime($dateh,$datef,$dates,$datem,$dated,$datey);
			if($plush_time>time())
			{
				$rows[$i]['title']="<font color=red>".$rows[$i]['title']."</font>";
			}
			$rows[$i]['subject_id'] = $request['subject_id'];
			$rows[$i]['channel_name'] = $request['channel_name'];
			$rows[$i]['p'] = $request['p'];
			$rows[$i]['p_rss'] = $request['p_rss'];
			$rows[$i]['bgcolor'] = ($i%2==0)?"#ffffff":"#C6E6E6";
			$rows[$i]['create_time'] = "<a href='#' onClick=\"window.open('main.php?do=article_time_modify&channel_name=" . $request['channel_name'] . "&article_id=" . $rows[$i]['id'] . "','article_time_modify','width=400,height=300')\">" . $rows[$i]['create_time'] . "</a>";
			//$rows[$i]['datetime'] = $this->hdate("Y-m-d H:i:s", $rows[$i]['datetime']);
		}
		$response['articles'] = $rows;

		//articles from RSS
		if($subject->GetCategory()==0)
		{
			$sql_rss_all = "select count(*) as num from rel_article_subject where subject_id in (" . $subject_id_str . ") AND category > 0"; // wenzhang zongshu
		}
		else 
		{
			$sql_rss_all = "select count(*) as num from rel_article_subject where category > 0";
		}
		$total = $dao->GetOne($sql_rss_all);
		if($total > 0)
		{
			$response['rss_begin'] = '<form method="post" name="articleRssDeleteGroupForm" action="main.php?do=article_rss_group_delete" onSubmit="return Checkform1(this)">
<table width="100%" cellspacing="2" bgcolor="#CCCCCC">
<tr bgcolor="#FFFFFF">
<td>&nbsp;</td>
<td>文章ID</td>
<td>文章标题</td>
<td>作者</td>
<td>发表时间</td>
<td>操作</td>
</tr>';

			$response['rss_end'] = '</table>
<input type="hidden" name="channel_name" value='.$request["channel_name"].'>
<input type="hidden" name="subject_id" value='.$request["subject_id"].'>
<INPUT TYPE="checkbox" NAME="chkall" onclick="RssCheckAll()"> 全选/取消
<input type="submit" value="删除选中"><input type="button" onclick="javascript:if(confirm(\'你确定要删除此栏目下半年前的RSS文章？\'))location.href=\'main.php?do=article_rss_batch_delete&channel_name='.$request["channel_name"].'&subject_id='.$request["subject_id"].'&monthlimit=6\';" value="删除半年前的RSS文章"><input type="button" onclick="javascript:if(confirm(\'你确定要删除此栏目下三个月前的RSS文章？\'))location.href=\'main.php?do=article_rss_batch_delete&channel_name='.$request["channel_name"].'&subject_id='.$request["subject_id"].'&monthlimit=3\';" value="删除三个月前的RSS文章"><input type="button" onclick="javascript:location.href=\'main.php?do=article_rss_remove_repeat&channel_name='.$request["channel_name"].'&subject_id='.$request["subject_id"].'\';" value="去除重复的RSS文章">
</form>
<form action="main.php?do=article_list&channel_name='.$request["channel_name"].'&subject_id='.$request["subject_id"].'&p={p}&p_rss={p_rss}"  name="articleListForm" method="post" style="text-align:right;">
  <label for="jumpage">到
  <input type="text" name="p_rss" id="p_rss" value="" style="border: 1px solid #7F9DB9;width: 2em; " />
  页</label>
  <input type="submit" value="go" style="width: 20px;border: 0; " />
</form>';
			
			$request['p_rss'] = ($request['p_rss']>ceil($total/$pageSize_rss))?ceil($total/$pageSize_rss):$request['p_rss'];
		
			$url = 'main.php?do=article_list&channel_name='.$request['channel_name'].'&subject_id='.$subject_id.'&p='.$request['p'].'&chioce='.$pageSize_rss;
			$currentPageNumber = $request['p_rss'];
			$pager = new Pager($url,$total,$pageSize_rss,$currentPageNumber,"p_rss");
			$response['pagebar_rss'] = $pager->getBar();
			$response['p_rss'] = $request['p_rss'];
			if($subject->GetCategory()==0)
			{
				$sql = "select * from rel_article_subject where subject_id in (" . $subject_id_str . ") AND category > 0 order by datetime desc limit ".($request['p_rss']-1)*$pageSize_rss.", ".$pageSize_rss;
			}
			else 
			{
				$sql = "select * from rel_article_subject where category > 0 order by datetime desc limit ".($request['p_rss']-1)*$pageSize_rss.", ".$pageSize_rss;
			}
			$rows_rss = $dao->GetPlan($sql);
			$row_rss_num = count($rows_rss);
			for($i=0;$i<$row_rss_num;$i++)
			{
				$rows_rss[$i]['subject_id'] = $request['subject_id'];
				$rows_rss[$i]['channel_name'] = $request['channel_name'];
				$rows_rss[$i]['p'] = $request['p'];
				$rows_rss[$i]['p_rss'] = $request['p_rss'];
				$rows_rss[$i]['bgcolor'] = ($i%2==0)?"#ffffff":"#C6E6E6";
				$sql1 = "select author from rss_entry_attach where id=" . $rows_rss[$i]['article_id'];
				$rows_rss[$i]['author'] = $dao->GetOne( $sql1 );
				//$rows_rss[$i]['datetime'] = preg_replace("#(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})#isU","\\2",$rows_rss[$i]['datetime']);
				$rows_rss[$i]['datetime'] = "<a href='#' onClick=\"window.open('main.php?do=article_time_modify&channel_name=" . $request['channel_name'] . "&r_id=" . $rows_rss[$i]['id'] . "','article_time_modify','width=400,height=300')\">" . $this->hdate("Y-m-d H:i:s", $rows_rss[$i]['datetime']) . "</a>";
				
			}
			$response['articles_rss'] = $rows_rss;
			
		}
	}
	
	function hdate($op,$ts)
	{
		 $unix_ts = mktime( substr($ts,8,2), substr($ts,10,2), substr($ts,12,2), substr($ts,4,2), substr($ts,6,2), substr($ts,0,4) );
		 $output = date($op,$unix_ts);
		 return $output;
	}
}
?>
