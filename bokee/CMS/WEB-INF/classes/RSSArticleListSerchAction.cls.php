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

class RSSArticleListSerchAction extends Action {
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
        
		$dao = DAO::CreateInstance();
		$db = "cms_" . $request['channel_name'];
		$dao->SetCurrentSchema($db);
		$subject_id = $request['subject_id'];
		$response['subject_id'] = $subject_id;
		$response['channel_name'] = $request['channel_name'];

		$subject_id = $response['subject_id'];
		$Serch_condition = $_REQUEST['Serch_condition'];

		$date_time = trim($_REQUEST['datetime']);
		$datetime_tmp = explode ("-",$date_time);
		$Serch_datetime = $datetime_tmp[0].$datetime_tmp[1].$datetime_tmp[2];

		$Serch_title = trim($_REQUEST['title']);
		$Serch_source = trim($_REQUEST['source']);

		switch ($Serch_condition){
			case "datetime":

			$response['Serch_condition'] = "datetime";
			$response['Option'] = "
			 <select name=Serch_condition onchange = change(this.form)>
				<option value=Null>选择查询方式</option>
				<option value=datetime selected>发文时间</option>
				<option value=title>文章标题</option>
				<option value=source>文章来源</option>
			  </select>
			  <input name=datetime type=text size=20 maxlength=50 style=display:none onFocus=calendar() value=".$date_time.">
			  <input name=title type=text size=20 maxlength=50 style=display:none>
			  <input name=source type=text size=20 maxlength=50 style=display:none>
			";
			$sql_condition = "datetime  LIKE '%". $Serch_datetime ."%' ";
			break;

			case "title":
			$response['Option'] = "
			 <select name=Serch_condition onchange = change(this.form)>
				<option value=Null>选择查询方式</option>
				<option value=datetime >发文时间</option>
				<option value=title selected>文章标题</option>
				<option value=source>文章来源</option>
			  </select>
			  <input name=datetime type=text size=20 maxlength=50 style=display:none onFocus=calendar()>
			  <input name=title type=text size=20 maxlength=50 style=display:none value=".$Serch_title.">
			  <input name=source type=text size=20 maxlength=50 style=display:none>
			";
			$response['Serch_condition'] = "title";
			$sql_condition = "title  LIKE '%". $Serch_title ."%' ";
			break;

			case "source":
			$response['Option'] = "
			 <select name=Serch_condition onchange = change(this.form)>
				<option value=Null>选择查询方式</option>
				<option value=datetime >发文时间</option>
				<option value=title>文章标题</option>
				<option value=source selected>文章来源</option>
			  </select>
			  <input name=datetime type=text size=20 maxlength=50 style=display:none onFocus=calendar()>
			  <input name=title type=text size=20 maxlength=50 style=display:none >
			  <input name=source type=text size=20 maxlength=50 style=display:none value=".$source.">
			";
			$response['Serch_condition'] = "source";
			$sql_condition = "source  LIKE '%". $Serch_source ."%' ";
			break;

		}



		// how many  per page
		$pageSize = $_REQUEST['chioce'];                                     
		if(!$pageSize){$pageSize=20;
		}
		$pageSize_rss = $_REQUEST['chioce_rss'];
		if(!$pageSize_rss){$pageSize_rss=20;
		}
		$subject = new Subject($db);
		$subject->GetByID($subject_id);


		//articles from RSS_LIST
		if($subject->GetCategory()==0)
		{
			$subject_id_str = $subject->GetSubjectIdStr($subject_id);
			$sql_rss_all = "select count(*) as num from rel_article_subject where subject_id in (" . $subject_id_str . ") AND category > 0 AND ".$sql_condition ; // wenzhang zongshu
		}
		else 
		{
			$sql_rss_all = "select count(*) as num from rel_article_subject where category > 0 AND ".$sql_condition;
		}
		$total = $dao->GetOne($sql_rss_all);
		if ($total == 0){echo "<script>alert ('没有找到记录'); history.go(-1);</script>";}
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
			<input type="submit" value="删除选中">
			</form>
			';

			$request['p_rss'] = isset($request['p_rss'])?$request['p_rss']:1; // page number
			$request['p_rss'] = (int)$request['p_rss'];                   // int number
			$request['p_rss'] = ($request['p_rss']<1)?1:$request['p_rss'];
			
			$request['p_rss'] = ($request['p_rss']>ceil($total/$pageSize_rss))?ceil($total/$pageSize_rss):$request['p_rss'];
		
			$url = 'main.php?do=rss_article_list_serch&channel_name='.$request['channel_name'].'&subject_id='.$subject_id.'&p='.$request['p'].'&chioce='.$pageSize_rss;
			$currentPageNumber = $request['p_rss'];
			$pager = new Pager($url,$total,$pageSize_rss,$currentPageNumber,"p_rss");
			$response['pagebar_rss'] = $pager->getBar();
			$response['p_rss'] = $request['p_rss'];

			if($subject->GetCategory()==0)
			{
				$sql = "select * from rel_article_subject where subject_id in (" . $subject_id_str . ") AND category > 0 and ".$sql_condition." order by datetime desc limit ".($request['p_rss']-1)*$pageSize_rss.", ".$pageSize_rss;
			}
			else 
			{
				$sql = "select * from rel_article_subject where category > 0 and ".$sql_condition." order  by datetime desc limit ".($request['p_rss']-1)*$pageSize_rss.", ".$pageSize_rss;
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